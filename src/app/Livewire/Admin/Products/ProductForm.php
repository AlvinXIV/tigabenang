<?php

namespace App\Livewire\Admin\Products;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public ?int $productId = null;
    public string $nama_produk = '';
    public ?int $kategori_id = null;
    public string $harga = '';
    public array $bahan_ids = [];

    public $gambar;
    public ?string $existingGambar = null;

    public $file_model_3d;
    public ?string $existingModel3d = null;

    public ?string $feedbackMessage = null;

    public function mount(?int $id = null)
    {
        if ($id) {
            $product = Produk::with(['kategori', 'bahan'])->findOrFail($id);
            $this->productId = $product->id_produk;
            $this->nama_produk = $product->nama_produk;
            $this->kategori_id = $product->kategori_id;
            $this->harga = (string) $product->harga;
            $this->bahan_ids = $product->bahan->pluck('id_bahan')->toArray();
            $this->existingGambar = $product->gambar;
            $this->existingModel3d = $product->file_model_3d;
        }
    }

    public function save()
    {
        $rules = [
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'harga' => 'required|numeric|min:0',
            'bahan_ids' => 'nullable|array',
            'bahan_ids.*' => 'exists:bahan,id_bahan',
        ];

        if ($this->gambar) {
            $rules['gambar'] = 'image|mimes:jpeg,png,jpg,webp|max:4096';
        }

        if ($this->file_model_3d) {
            $rules['file_model_3d'] = 'file|mimes:glb,gltf|max:20480';
        }

        $this->validate($rules);

        $data = [
            'nama_produk' => trim($this->nama_produk),
            'kategori_id' => $this->kategori_id,
            'harga' => $this->harga,
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('produk', 'public');
        }

        if ($this->file_model_3d) {
            $data['file_model_3d'] = $this->file_model_3d->store('models3d', 'public');
        }

        if ($this->productId) {
            $product = Produk::findOrFail($this->productId);
            $product->update($data);
            $product->bahan()->sync($this->bahan_ids);
            session()->flash('success', 'Produk berhasil diperbarui!');
            return redirect()->route('admin.produk.index');
        } else {
            $product = Produk::create($data);
            if (!empty($this->bahan_ids)) {
                $product->bahan()->sync($this->bahan_ids);
            }
            session()->flash('success', 'Produk baru berhasil ditambahkan!');
            return redirect()->route('admin.produk.index');
        }
    }

    public function render()
    {
        $categories = Kategori::orderBy('nama_kategori')->get();
        $availableMaterials = Bahan::orderBy('nama_bahan')->get();

        return view('livewire.admin.products.product-form', compact('categories', 'availableMaterials'));
    }
}
