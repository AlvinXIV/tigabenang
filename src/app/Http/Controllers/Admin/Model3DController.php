<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Model3DController extends Controller
{
    public function index()
    {
        $models = Produk::with('kategori')
            ->whereNotNull('file_model_3d')
            ->where('file_model_3d', '!=', '')
            ->latest('id_produk')
            ->get();

        $availableProducts = Produk::whereNull('file_model_3d')
            ->orWhere('file_model_3d', '')
            ->get();

        return view('admin.models3d.index', compact('models', 'availableProducts'));
    }

    public function create()
    {
        $availableProducts = Produk::all();

        return view('admin.models3d.create', compact('availableProducts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,id_produk',
            'file_model_3d' => 'required|file|mimes:glb,gltf|max:20480',
        ]);

        $produk = Produk::findOrFail($validated['produk_id']);

        if ($request->hasFile('file_model_3d')) {
            if ($produk->file_model_3d && Storage::disk('public')->exists($produk->file_model_3d)) {
                Storage::disk('public')->delete($produk->file_model_3d);
            }
            $produk->file_model_3d = $request->file('file_model_3d')->store('models3d', 'public');
            $produk->save();
        }

        return redirect()->route('admin.model-3d.index')->with('success', 'Model 3D (.glb) berhasil diunggah dan dihubungkan ke produk!');
    }

    public function edit($id)
    {
        $product = Produk::findOrFail($id);
        $availableProducts = Produk::all();

        return view('admin.models3d.edit', compact('product', 'availableProducts'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'file_model_3d' => 'nullable|file|mimes:glb,gltf|max:20480',
        ]);

        if ($request->hasFile('file_model_3d')) {
            if ($produk->file_model_3d && Storage::disk('public')->exists($produk->file_model_3d)) {
                Storage::disk('public')->delete($produk->file_model_3d);
            }
            $produk->file_model_3d = $request->file('file_model_3d')->store('models3d', 'public');
            $produk->save();
        }

        return redirect()->route('admin.model-3d.index')->with('success', 'Informasi model 3D berhasil diperbarui!');
    }

    public function preview($id)
    {
        $product = Produk::with('kategori')->findOrFail($id);

        return view('admin.models3d.preview', compact('product'));
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->file_model_3d && Storage::disk('public')->exists($produk->file_model_3d)) {
            Storage::disk('public')->delete($produk->file_model_3d);
        }
        $produk->file_model_3d = null;
        $produk->save();

        return redirect()->route('admin.model-3d.index')->with('success', 'Aset model 3D berhasil dihapus.');
    }
}

