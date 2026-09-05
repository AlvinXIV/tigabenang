<?php

namespace App\Livewire\Admin\Models3D;

use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public ?string $feedbackMessage = null;

    public function unlink3D(int $productId)
    {
        $product = Produk::findOrFail($productId);

        if ($product->file_model_3d && Storage::disk('public')->exists($product->file_model_3d)) {
            Storage::disk('public')->delete($product->file_model_3d);
        }

        $product->file_model_3d = null;
        $product->save();

        $this->feedbackMessage = 'Model 3D berhasil dilepas dari produk.';
    }

    public function dismissFeedback()
    {
        $this->feedbackMessage = null;
    }

    public function render()
    {
        $query = Produk::with('kategori')
            ->whereNotNull('file_model_3d')
            ->where('file_model_3d', '!=', '')
            ->latest('id_produk');

        if (!empty($this->search)) {
            $query->where('nama_produk', 'like', '%' . trim($this->search) . '%');
        }

        $models = $query->get();

        $availableProducts = Produk::whereNull('file_model_3d')
            ->orWhere('file_model_3d', '')
            ->get();

        return view('livewire.admin.models3d.index', compact('models', 'availableProducts'));
    }
}
