<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'bahan']);

        if ($request->filled('category_id')) {
            $query->where('kategori_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest('id_produk')->get();
        $categories = Kategori::all();
        $totalProducts = Produk::count();

        return view('admin.products.index', compact('products', 'categories', 'totalProducts'));
    }

    public function create()
    {
        $categories = Kategori::all();
        $availableMaterials = Bahan::all();

        return view('admin.products.create', compact('categories', 'availableMaterials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'file_model_3d' => 'nullable|file|mimes:glb,gltf|max:20480',
            'bahan_ids' => 'nullable|array',
            'bahan_ids.*' => 'exists:bahan,id_bahan',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        $model3dPath = null;
        if ($request->hasFile('file_model_3d')) {
            $model3dPath = $request->file('file_model_3d')->store('models3d', 'public');
        }

        $produk = Produk::create([
            'nama_produk' => $validated['nama_produk'],
            'kategori_id' => $validated['kategori_id'],
            'harga' => $validated['harga'],
            'gambar' => $gambarPath,
            'file_model_3d' => $model3dPath,
        ]);

        if (!empty($validated['bahan_ids'])) {
            $produk->bahan()->sync($validated['bahan_ids']);
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Produk::with(['kategori', 'bahan'])->findOrFail($id);
        $categories = Kategori::all();
        $availableMaterials = Bahan::all();

        return view('admin.products.edit', compact('product', 'categories', 'availableMaterials'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'file_model_3d' => 'nullable|file|mimes:glb,gltf|max:20480',
            'bahan_ids' => 'nullable|array',
            'bahan_ids.*' => 'exists:bahan,id_bahan',
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $produk->gambar = $request->file('gambar')->store('produk', 'public');
        }

        if ($request->hasFile('file_model_3d')) {
            if ($produk->file_model_3d && Storage::disk('public')->exists($produk->file_model_3d)) {
                Storage::disk('public')->delete($produk->file_model_3d);
            }
            $produk->file_model_3d = $request->file('file_model_3d')->store('models3d', 'public');
        }

        $produk->nama_produk = $validated['nama_produk'];
        $produk->kategori_id = $validated['kategori_id'];
        $produk->harga = $validated['harga'];
        $produk->save();

        if (isset($validated['bahan_ids'])) {
            $produk->bahan()->sync($validated['bahan_ids']);
        } else {
            $produk->bahan()->detach();
        }

        return redirect()->route('admin.produk.index')->with('success', 'Informasi produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }
        if ($produk->file_model_3d && Storage::disk('public')->exists($produk->file_model_3d)) {
            Storage::disk('public')->delete($produk->file_model_3d);
        }

        $produk->bahan()->detach();
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus dari katalog.');
    }
}

