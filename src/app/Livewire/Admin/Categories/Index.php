<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Bahan;
use App\Models\Kategori;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    #[Url(as: 'tab')]
    public string $activeTab = 'kategori';
    public string $searchKategori = '';
    public string $searchMaterial = '';


    // Edit states
    public ?int $editingKategoriId = null;
    public string $editingKategoriName = '';

    public ?int $editingBahanId = null;
    public string $editingBahanName = '';

    // Feedback
    public ?string $feedbackMessage = null;

    public function mount()
    {
        $requestedTab = request()->query('tab', request()->query('activeTab'));
        if ($requestedTab === 'material') {
            $this->activeTab = 'material';
        }
    }

    public function switchTab(string $tab)
    {
        $this->activeTab = $tab;
        $this->dispatch('tab-changed', $tab);
    }

    public function resetFilters()
    {
        $this->searchKategori = '';
        $this->searchMaterial = '';
    }


    public function startEditKategori(int $id, string $name)
    {
        $this->editingKategoriId = $id;
        $this->editingKategoriName = $name;
    }

    public function updateKategori()
    {
        $this->validate([
            'editingKategoriName' => 'required|string|max:255',
        ]);

        $cat = Kategori::findOrFail($this->editingKategoriId);
        $cat->update(['nama_kategori' => trim($this->editingKategoriName)]);

        $this->editingKategoriId = null;
        $this->editingKategoriName = '';
        $this->feedbackMessage = 'Nama kategori berhasil diperbarui!';
    }

    public function cancelEditKategori()
    {
        $this->editingKategoriId = null;
        $this->editingKategoriName = '';
    }

    public function deleteKategori(int $id)
    {
        $cat = Kategori::findOrFail($id);
        $cat->delete();
        $this->feedbackMessage = 'Kategori berhasil dihapus.';
    }


    public function startEditBahan(int $id, string $name)
    {
        $this->editingBahanId = $id;
        $this->editingBahanName = $name;
    }

    public function updateBahan()
    {
        $this->validate([
            'editingBahanName' => 'required|string|max:255',
        ]);

        $mat = Bahan::findOrFail($this->editingBahanId);
        $mat->update(['nama_bahan' => trim($this->editingBahanName)]);

        $this->editingBahanId = null;
        $this->editingBahanName = '';
        $this->feedbackMessage = 'Nama material berhasil diperbarui!';
    }

    public function cancelEditBahan()
    {
        $this->editingBahanId = null;
        $this->editingBahanName = '';
    }

    public function deleteMaterial(int $id)
    {
        $mat = Bahan::findOrFail($id);
        $mat->delete();
        $this->feedbackMessage = 'Material kain berhasil dihapus.';
    }

    public function dismissFeedback()
    {
        $this->feedbackMessage = null;
    }

    public function render()
    {
        $catQuery = Kategori::withCount('produk')->latest('id_kategori');
        if (!empty($this->searchKategori)) {
            $catQuery->where('nama_kategori', 'ilike', '%' . trim($this->searchKategori) . '%');
        }
        $categories = $catQuery->get();

        $matQuery = Bahan::latest('id_bahan');
        if (!empty($this->searchMaterial)) {
            $matQuery->where('nama_bahan', 'ilike', '%' . trim($this->searchMaterial) . '%');
        }
        $materials = $matQuery->get();

        $summary = [
            'total_categories' => Kategori::count(),
            'total_materials' => Bahan::count(),
        ];

        return view('livewire.admin.categories.index', compact('categories', 'materials', 'summary'));
    }
}
