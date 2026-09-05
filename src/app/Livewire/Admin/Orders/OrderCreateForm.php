<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Bahan;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\Ukuran;
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

    public function mount()
    {
        $sizes = Ukuran::all();
        foreach ($sizes as $s) {
            $this->ukuran[$s->id_ukuran] = 0;
        }
    }

    public function save()
    {
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
            $ukuranPivot = [];
            foreach ($this->ukuran as $ukuranId => $qty) {
                if ((int)$qty > 0) {
                    $ukuranPivot[$ukuranId] = ['kuantitas' => (int)$qty];
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
        $products = Produk::orderBy('nama_produk')->get();
        $materials = Bahan::orderBy('nama_bahan')->get();
        $sizes = Ukuran::with('kategori')->get();

        return view('livewire.admin.orders.order-create-form', compact('products', 'materials', 'sizes'));
    }
}
