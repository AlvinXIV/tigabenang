<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerOrderRequest;
use App\Models\Bahan;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Support\CustomerCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class OrderController extends Controller
{
    public function create(Request $request): View
    {
        $products = Produk::query()
            ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga'])
            ->with(['bahan:id_bahan,nama_bahan'])
            ->orderBy('nama_produk')
            ->get();

        CustomerCatalog::attachKategoriAndSizes($products);

        $selectedId = $request->query('product');
        $selected = $products->firstWhere('id_produk', (int) $selectedId) ?? $products->first();

        $allMaterials = CustomerCatalog::materials();

        $catalog = $products->map(function (Produk $produk) use ($allMaterials) {
            $productMaterials = $produk->bahan->isNotEmpty()
                ? $produk->bahan
                : $allMaterials;

            return [
                'id' => $produk->id_produk,
                'name' => $produk->nama_produk,
                'category' => $produk->kategori?->nama_kategori,
                'price' => (float) $produk->harga,
                'sizes' => $produk->kategori?->ukuran
                    ?->map(fn ($ukuran) => [
                        'id' => $ukuran->id_ukuran,
                        'name' => $ukuran->nama_ukuran,
                    ])->values() ?? [],
                'materials' => $productMaterials->map(fn (Bahan $bahan) => [
                    'id' => $bahan->id_bahan,
                    'name' => $bahan->nama_bahan,
                ])->values(),
            ];
        })->values();

        return view('customer.order.create', [
            'products' => $products,
            'selected' => $selected,
            'catalog' => $catalog,
        ]);
    }

    public function store(StoreCustomerOrderRequest $request): RedirectResponse
    {
        $produk = Produk::query()
            ->with('kategori.ukuran')
            ->findOrFail($request->validated('produk_id'));

        $sizeRows = collect($request->validated('sizes'))
            ->filter(fn (array $row) => (int) $row['kuantitas'] > 0)
            ->values();

        $totalQuantity = $sizeRows->sum(fn (array $row) => (int) $row['kuantitas']);
        $totalHarga = (float) $produk->harga * $totalQuantity;

        try {
            $pemesanan = DB::transaction(function () use ($request, $produk, $sizeRows, $totalHarga) {
                $designPath = null;

                if ($request->hasFile('upload_design')) {
                    $designPath = $request->file('upload_design')->store('designs', 'public');
                }

                $pemesanan = Pemesanan::query()->create([
                    'nama' => $request->validated('nama'),
                    'alamat' => $request->validated('alamat'),
                    'no_hp' => $request->validated('no_hp'),
                    'produk_id' => $produk->id_produk,
                    'total_harga' => $totalHarga,
                    'upload_design' => $designPath,
                    'notes' => $request->validated('notes'),
                ]);

                $pemesanan->bahan()->attach($request->validated('materials'));

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
                    'order' => 'We could not submit your request. Please try again.',
                ]);
        }

        return redirect()
            ->route('order.success')
            ->with('order_id', $pemesanan->id_pemesanan);
    }

    public function success(): View
    {
        $orderId = session('order_id');

        $pemesanan = $orderId
            ? Pemesanan::query()
                ->with(['produk.kategori', 'bahan', 'ukuran'])
                ->find($orderId)
            : null;

        return view('customer.order.success', [
            'pemesanan' => $pemesanan,
        ]);
    }
}
