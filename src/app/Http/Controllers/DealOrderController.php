<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDealOrderRequest;
use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Support\CustomerCatalog;
use App\Support\CustomerMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class DealOrderController extends Controller
{
    public function create(Request $request): View
    {
        $categories = Kategori::query()
            ->whereHas('produk')
            ->with([
                'ukuran' => fn ($query) => $query->orderBy('id_ukuran'),
                'produk' => fn ($query) => $query
                    ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga'])
                    ->orderBy('nama_produk')
                    ->with(['bahan:id_bahan,nama_bahan']),
            ])
            ->orderBy('nama_kategori')
            ->get();

        $requestedProductId = $request->query('product');
        $requestedCategoryId = $request->query('category');

        $selected = $categories->first(function (Kategori $kategori) use ($requestedProductId, $requestedCategoryId) {
            if (filled($requestedCategoryId) && (string) $kategori->id_kategori === (string) $requestedCategoryId) {
                return true;
            }

            return filled($requestedProductId)
                && $kategori->produk->contains('id_produk', (int) $requestedProductId);
        }) ?? $categories->first();

        $catalog = $categories->map(function (Kategori $kategori) {
            $materials = CustomerCatalog::materialsForCategory($kategori);

            return [
                'id' => $kategori->id_kategori,
                'name' => $kategori->nama_kategori,
                'label' => CustomerCatalog::categoryLabel($kategori->nama_kategori),
                'product_id' => $kategori->produk->first()?->id_produk,
                'sizes' => $kategori->ukuran
                    ->map(fn ($ukuran) => [
                        'id' => $ukuran->id_ukuran,
                        'name' => $ukuran->nama_ukuran,
                        'chest' => $ukuran->lebar_dada,
                        'length' => $ukuran->panjang,
                        'shoulder' => $ukuran->lebar_bahu,
                        'sleeve' => $ukuran->panjang_lengan,
                    ])->values(),
                'materials' => $materials->map(fn (Bahan $bahan) => [
                    'id' => $bahan->id_bahan,
                    'name' => $bahan->nama_bahan,
                    'image' => CustomerMedia::materialImageUrl($bahan->nama_bahan),
                ])->values(),
            ];
        })->values();

        return view('customer.deal-order.create', [
            'categories' => $categories,
            'selected' => $selected,
            'catalog' => $catalog,
        ]);
    }

    public function store(StoreDealOrderRequest $request): RedirectResponse
    {
        $kategori = Kategori::query()
            ->with(['produk', 'ukuran'])
            ->findOrFail($request->validated('kategori_id'));

        $produk = $kategori->produk->first();

        if (! $produk instanceof Produk) {
            return back()
                ->withInput()
                ->withErrors([
                    'kategori_id' => 'Kategori yang dipilih belum memiliki produk yang dapat dipesan.',
                ]);
        }

        $sizeRows = collect($request->validated('sizes'))
            ->filter(fn (array $row) => (int) ($row['kuantitas'] ?? 0) > 0)
            ->values();

        try {
            $pemesanan = DB::transaction(function () use ($request, $produk, $sizeRows) {
                $designPath = null;

                if ($request->hasFile('upload_design')) {
                    $designPath = $request->file('upload_design')->store('designs', 'public');
                }

                $pemesanan = Pemesanan::query()->create([
                    'nama' => $request->validated('nama'),
                    'alamat' => $request->validated('alamat'),
                    'no_hp' => $request->validated('no_hp'),
                    'produk_id' => $produk->id_produk,
                    'total_harga' => null,
                    'upload_design' => $designPath,
                    'notes' => $request->validated('notes'),
                ]);

                $materialIds = array_unique((array) $request->validated('materials'));
                $pemesanan->bahan()->attach($materialIds);

                $ukuranAttach = [];
                foreach ($sizeRows as $row) {
                    $ukuranAttach[$row['ukuran_id']] = [
                        'kuantitas' => (int) $row['kuantitas'],
                    ];
                }

                $pemesanan->ukuran()->attach($ukuranAttach);

                return $pemesanan;
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'order' => 'Terjadi kesalahan saat memproses formulir pemesanan. Silakan periksa kembali data Anda.',
                ]);
        }

        return redirect()
            ->route('deal-order.success')
            ->with('order_id', $pemesanan->id_pemesanan);
    }

    public function success(): View|RedirectResponse
    {
        $orderId = session('order_id');

        $pemesanan = $orderId
            ? Pemesanan::query()
                ->with(['produk.kategori', 'bahan', 'ukuran'])
                ->find($orderId)
            : null;

        if (! $pemesanan) {
            return redirect()->route('deal-order.create');
        }

        return view('customer.deal-order.success', [
            'pemesanan' => $pemesanan,
        ]);
    }
}
