<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Kategori::withCount('produk')->latest('id_kategori')->get();
        $materials = Bahan::latest('id_bahan')->get();

        $summary = [
            'total_categories' => $categories->count(),
            'total_materials' => $materials->count(),
        ];

        return view('admin.categories.index', compact('categories', 'materials', 'summary'));
    }

    public function store(Request $request)
    {
        if ($request->has('type') && $request->type === 'bahan') {
            $validated = $request->validate([
                'nama_bahan' => 'required|string|max:255',
            ]);
            Bahan::create(['nama_bahan' => $validated['nama_bahan']]);
            return redirect()->route('admin.kategori.index')->with('success', 'Material kain baru berhasil ditambahkan!');
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create(['nama_kategori' => $validated['nama_kategori']]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori produk baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        $bahan = null;
        if (!$kategori) {
            $bahan = Bahan::findOrFail($id);
        }

        return view('admin.categories.edit', compact('kategori', 'bahan'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('type') && $request->type === 'bahan') {
            $validated = $request->validate([
                'nama_bahan' => 'required|string|max:255',
            ]);
            $bahan = Bahan::findOrFail($id);
            $bahan->update(['nama_bahan' => $validated['nama_bahan']]);
            return redirect()->route('admin.kategori.index')->with('success', 'Nama material berhasil diperbarui!');
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama_kategori' => $validated['nama_kategori']]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (request('type') === 'bahan') {
            $bahan = Bahan::findOrFail($id);
            $bahan->delete();
            return redirect()->route('admin.kategori.index')->with('success', 'Material berhasil dihapus.');
        }

        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}

