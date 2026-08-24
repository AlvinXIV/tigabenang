<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Ukuran;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Ukuran::with('kategori')->get();
        $categories = Kategori::with('ukuran')->get();

        return view('admin.sizes.index', compact('sizes', 'categories'));
    }

    public function create()
    {
        $categories = Kategori::all();
        return view('admin.sizes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'nama_ukuran' => 'required|string|max:50',
            'lebar_dada' => 'nullable|numeric|min:0',
            'panjang' => 'nullable|numeric|min:0',
            'lebar_bahu' => 'nullable|numeric|min:0',
            'panjang_lengan' => 'nullable|numeric|min:0',
        ]);

        Ukuran::create($validated);

        return redirect()->route('admin.ukuran.index')->with('success', 'Ukuran baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ukuran = Ukuran::with('kategori')->findOrFail($id);
        $categories = Kategori::all();

        return view('admin.sizes.edit', compact('ukuran', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $ukuran = Ukuran::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'nama_ukuran' => 'required|string|max:50',
            'lebar_dada' => 'nullable|numeric|min:0',
            'panjang' => 'nullable|numeric|min:0',
            'lebar_bahu' => 'nullable|numeric|min:0',
            'panjang_lengan' => 'nullable|numeric|min:0',
        ]);

        $ukuran->update($validated);

        return redirect()->route('admin.ukuran.index')->with('success', 'Spesifikasi ukuran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ukuran = Ukuran::findOrFail($id);
        $ukuran->delete();

        return redirect()->route('admin.ukuran.index')->with('success', 'Ukuran berhasil dihapus.');
    }
}

