<?php

namespace App\Livewire\Admin\Products;

use App\Models\Kategori;
use App\Models\Produk;
use App\Support\ImageOptimizer;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public string $categoryFilter = '';
    public string $status3dFilter = '';
    public ?string $feedbackMessage = null;

    public function resetFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->status3dFilter = '';
    }

    public function delete(int $id)
    {
        $product = Produk::findOrFail($id);

        $disk = in_array(config('filesystems.default'), ['supabase', 's3']) ? config('filesystems.default') : 'public';

        if ($product->gambar) {
            ImageOptimizer::deleteWithWebp($product->gambar, $disk);
        }

        if ($product->file_model_3d && Storage::disk($disk)->exists($product->file_model_3d)) {
            Storage::disk($disk)->delete($product->file_model_3d);
        }

        $product->bahan()->detach();
        $product->delete();

        $this->feedbackMessage = 'Produk berhasil dihapus dari katalog.';
    }

    public function dismissFeedback()
    {
        $this->feedbackMessage = null;
    }

    public function render()
    {
        $query = Produk::with(['kategori', 'bahan'])->latest('id_produk');

        if (!empty($this->categoryFilter)) {
            $query->where('kategori_id', $this->categoryFilter);
        }

        if ($this->status3dFilter === 'connected') {
            $query->whereNotNull('file_model_3d')->where('file_model_3d', '!=', '');
        } elseif ($this->status3dFilter === 'missing') {
            $query->where(function ($q) {
                $q->whereNull('file_model_3d')->orWhere('file_model_3d', '');
            });
        }

        if (!empty($this->search)) {
            $query->where('nama_produk', 'ilike', '%' . trim($this->search) . '%');
        }

        $products = $query->get();
        $categories = Kategori::orderBy('nama_kategori')->get();
        $totalProducts = Produk::count();

        return view('livewire.admin.products.index', compact('products', 'categories', 'totalProducts'));
    }
}
