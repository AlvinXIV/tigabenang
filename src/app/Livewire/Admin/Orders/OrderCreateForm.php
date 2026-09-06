<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Bahan;
use App\Models\Pemesanan;
use App\Models\Produk;
use Livewire\Component;

class OrderCreateForm extends Component
{
    public string $nama = '';
    public string $no_hp = '';
    public string $alamat = '';
    public ?int $produk_id = null;
    public array $bahan_ids = [];
    public array $ukuran = []; // [ukuran_id => qty]
    public string $total_harga = '';
    public string $notes = '';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'no_hp' => 'required|string|max:50',
        'alamat' => 'required|string',
        'produk_id' => 'required|exists:produk,id_produk',
        'total_harga' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
        'bahan_ids' => 'nullable|array',
        'bahan_ids.*' => 'exists:bahan,id_bahan',
        'ukuran' => 'nullable|array',
        'ukuran.*' => 'nullable|integer|min:0',
    ];

    public function mount(): void
    {
        $this->ukuran = [];
        if ($this->produk_id) {
            $this->loadSizesForProduct($this->produk_id);
        }
    }

    public function updatedProdukId($value): void
    {
        $this->loadSizesForProduct($value ? (int) $value : null);
    }

    protected function loadSizesForProduct(?int $productId): void
    {
        $this->ukuran = [];

        if (!empty($productId)) {
            $product = Produk::with(['kategori.ukuran' => fn ($q) => $q->orderBy('id_ukuran')])->find($productId);
            if ($product && $product->kategori && $product->kategori->ukuran) {
                foreach ($product->kategori->ukuran as $s) {
                    $this->ukuran[$s->id_ukuran] = 0;
                }
            }
        }
    }

    public function save()
    {
        if (is_array($this->ukuran)) {
            foreach ($this->ukuran as $key => $val) {
                if ($val === '' || $val === null) {
                    $this->ukuran[$key] = 0;
                }
            }
        }

        $this->validate();

        $pemesanan = Pemesanan::create([
            'nama' => trim($this->nama),
            'no_hp' => trim($this->no_hp),
            'alamat' => trim($this->alamat),
            'produk_id' => $this->produk_id,
            'total_harga' => !empty($this->total_harga) ? $this->total_harga : null,
            'notes' => trim($this->notes) ?: null,
        ]);

        if (!empty($this->bahan_ids)) {
            $pemesanan->bahan()->sync($this->bahan_ids);
        }

        if (!empty($this->ukuran)) {
            $product = Produk::with('kategori.ukuran')->find($this->produk_id);
            $validUkuranIds = ($product && $product->kategori && $product->kategori->ukuran)
                ? $product->kategori->ukuran->pluck('id_ukuran')->all()
                : [];

            $ukuranPivot = [];
            foreach ($this->ukuran as $ukuranId => $qty) {
                if (in_array((int)$ukuranId, $validUkuranIds, true) && (int)$qty > 0) {
                    $ukuranPivot[(int)$ukuranId] = ['kuantitas' => (int)$qty];
                }
            }
            if (!empty($ukuranPivot)) {
                $pemesanan->ukuran()->sync($ukuranPivot);
            }
        }

        session()->flash('success', 'Pesanan baru berhasil ditambahkan!');
        return redirect()->route('admin.pesanan.index');
    }

    public function render()
    {
        $products = Produk::with('kategori')->orderBy('nama_produk')->get();
        $materials = Bahan::orderBy('nama_bahan')->get();

        $selectedProduct = $this->produk_id
            ? $products->firstWhere('id_produk', (int) $this->produk_id)
            : null;

        $sizes = ($selectedProduct && $selectedProduct->kategori)
            ? $selectedProduct->kategori->ukuran()->orderBy('id_ukuran')->get()
            : collect();

        return view('livewire.admin.orders.order-create-form', compact('products', 'materials', 'sizes', 'selectedProduct'));
    }
}
