<?php

namespace App\Livewire\Admin\Models3D;

use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public string $statusFilter = 'all'; // 'all', 'connected', 'missing'
    public ?string $feedbackMessage = null;

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = 'all';
    }

    public function unlink3D(int $productId)
    {
        $product = Produk::findOrFail($productId);

        $disk = in_array(config('filesystems.default'), ['supabase', 's3']) ? config('filesystems.default') : 'public';

        if ($product->file_model_3d && Storage::disk($disk)->exists($product->file_model_3d)) {
            Storage::disk($disk)->delete($product->file_model_3d);
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
        $s = trim($this->search);

        // 1. Query for Connected 3D products
        $modelsQuery = Produk::with('kategori')
            ->whereNotNull('file_model_3d')
            ->where('file_model_3d', '!=', '')
            ->latest('id_produk');

        if (!empty($s)) {
            $modelsQuery->where(function ($q) use ($s) {
                $q->where('nama_produk', 'ilike', "%{$s}%")
                  ->orWhereHas('kategori', function ($cq) use ($s) {
                      $cq->where('nama_kategori', 'ilike', "%{$s}%");
                  });
            });
        }

        // 2. Query for Unconnected products
        $availableQuery = Produk::with('kategori')
            ->where(function ($q) {
                $q->whereNull('file_model_3d')->orWhere('file_model_3d', '');
            })
            ->latest('id_produk');

        if (!empty($s)) {
            $availableQuery->where(function ($q) use ($s) {
                $q->where('nama_produk', 'ilike', "%{$s}%")
                  ->orWhereHas('kategori', function ($cq) use ($s) {
                      $cq->where('nama_kategori', 'ilike', "%{$s}%");
                  });
            });
        }

        // Apply Status 3D filter
        if ($this->statusFilter === 'connected') {
            $models = $modelsQuery->get();
            $availableProducts = collect();
        } elseif ($this->statusFilter === 'missing') {
            $models = collect();
            $availableProducts = $availableQuery->get();
        } else { // 'all'
            $models = $modelsQuery->get();
            $availableProducts = $availableQuery->get();
        }

        $totalFiltered = $models->count() + $availableProducts->count();

        return view('livewire.admin.models3d.index', compact('models', 'availableProducts', 'totalFiltered'));
    }
}
