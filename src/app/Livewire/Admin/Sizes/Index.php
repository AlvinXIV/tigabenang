<?php

namespace App\Livewire\Admin\Sizes;

use App\Models\Kategori;
use App\Models\Ukuran;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public string $categoryFilter = '';
    public bool $addFormOpen = false;

    // Create form fields
    public ?int $kategori_id = null;
    public string $nama_ukuran = '';
    public string $lebar_dada = '';
    public string $panjang = '';
    public string $lebar_bahu = '';
    public string $panjang_lengan = '';

    // Edit state
    public ?int $editingId = null;
    public ?int $edit_kategori_id = null;
    public string $edit_nama_ukuran = '';
    public string $edit_lebar_dada = '';
    public string $edit_panjang = '';
    public string $edit_lebar_bahu = '';
    public string $edit_panjang_lengan = '';

    public ?string $feedbackMessage = null;

    protected $rules = [
        'kategori_id' => 'required|exists:kategori,id_kategori',
        'nama_ukuran' => 'required|string|max:50',
        'lebar_dada' => 'required|numeric|min:0',
        'panjang' => 'required|numeric|min:0',
        'lebar_bahu' => 'nullable|numeric|min:0',
        'panjang_lengan' => 'nullable|numeric|min:0',
    ];

    public function save()
    {
        $this->validate();

        Ukuran::create([
            'kategori_id' => $this->kategori_id,
            'nama_ukuran' => trim($this->nama_ukuran),
            'lebar_dada' => $this->lebar_dada,
            'panjang' => $this->panjang,
            'lebar_bahu' => $this->lebar_bahu ?: null,
            'panjang_lengan' => $this->panjang_lengan ?: null,
        ]);

        $this->reset(['kategori_id', 'nama_ukuran', 'lebar_dada', 'panjang', 'lebar_bahu', 'panjang_lengan', 'addFormOpen']);
        $this->feedbackMessage = 'Spesifikasi ukuran baru berhasil disimpan!';
    }

    public function startEdit(int $id)
    {
        $u = Ukuran::findOrFail($id);
        $this->editingId = $u->id_ukuran;
        $this->edit_kategori_id = $u->kategori_id;
        $this->edit_nama_ukuran = $u->nama_ukuran;
        $this->edit_lebar_dada = (string) $u->lebar_dada;
        $this->edit_panjang = (string) $u->panjang;
        $this->edit_lebar_bahu = (string) ($u->lebar_bahu ?? '');
        $this->edit_panjang_lengan = (string) ($u->panjang_lengan ?? '');
    }

    public function update()
    {
        $this->validate([
            'edit_kategori_id' => 'required|exists:kategori,id_kategori',
            'edit_nama_ukuran' => 'required|string|max:50',
            'edit_lebar_dada' => 'required|numeric|min:0',
            'edit_panjang' => 'required|numeric|min:0',
            'edit_lebar_bahu' => 'nullable|numeric|min:0',
            'edit_panjang_lengan' => 'nullable|numeric|min:0',
        ]);

        $u = Ukuran::findOrFail($this->editingId);
        $u->update([
            'kategori_id' => $this->edit_kategori_id,
            'nama_ukuran' => trim($this->edit_nama_ukuran),
            'lebar_dada' => $this->edit_lebar_dada,
            'panjang' => $this->edit_panjang,
            'lebar_bahu' => $this->edit_lebar_bahu ?: null,
            'panjang_lengan' => $this->edit_panjang_lengan ?: null,
        ]);

        $this->editingId = null;
        $this->feedbackMessage = 'Spesifikasi ukuran berhasil diperbarui!';
    }

    public function cancelEdit()
    {
        $this->editingId = null;
    }

    public function delete(int $id)
    {
        $u = Ukuran::findOrFail($id);
        $u->delete();
        $this->feedbackMessage = 'Ukuran berhasil dihapus.';
    }

    public function dismissFeedback()
    {
        $this->feedbackMessage = null;
    }

    public function render()
    {
        $categories = Kategori::orderBy('nama_kategori')->get();

        $query = Ukuran::with('kategori')->latest('id_ukuran');

        if (!empty($this->categoryFilter)) {
            $query->where('kategori_id', $this->categoryFilter);
        }

        if (!empty($this->search)) {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('nama_ukuran', 'like', "%{$s}%")
                  ->orWhereHas('kategori', function ($cq) use ($s) {
                      $cq->where('nama_kategori', 'like', "%{$s}%");
                  });
            });
        }

        $sizes = $query->get();

        return view('livewire.admin.sizes.index', compact('categories', 'sizes'));
    }
}
