<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\Ukuran;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['produk', 'bahan', 'ukuran']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('id_pemesanan', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest('id_pemesanan')->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Produk::all();
        $materials = Bahan::all();
        $sizes = Ukuran::all();

        return view('admin.orders.create', compact('products', 'materials', 'sizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:50',
            'produk_id' => 'required|exists:produk,id_produk',
            'total_harga' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'bahan_ids' => 'nullable|array',
            'bahan_ids.*' => 'exists:bahan,id_bahan',
            'ukuran' => 'nullable|array',
            'ukuran.*' => 'integer|min:0',
        ]);

        $pemesanan = Pemesanan::create([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'produk_id' => $validated['produk_id'],
            'total_harga' => $validated['total_harga'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        if (!empty($validated['bahan_ids'])) {
            $pemesanan->bahan()->sync($validated['bahan_ids']);
        }

        if (!empty($validated['ukuran'])) {
            $ukuranPivot = [];
            foreach ($validated['ukuran'] as $ukuranId => $qty) {
                if ($qty > 0) {
                    $ukuranPivot[$ukuranId] = ['kuantitas' => $qty];
                }
            }
            if (!empty($ukuranPivot)) {
                $pemesanan->ukuran()->sync($ukuranPivot);
            }
        }

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan baru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $order = Pemesanan::with(['produk', 'bahan', 'ukuran'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        $validated = $request->validate([
            'total_harga' => 'nullable|numeric|min:0',
            'nama' => 'sometimes|required|string|max:255',
            'alamat' => 'sometimes|required|string',
            'no_hp' => 'sometimes|required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $pemesanan->update($validated);

        return redirect()->route('admin.pesanan.show', $id)->with('success', 'Informasi dan penetapan harga pesanan berhasil diperbarui!');
    }

    public function invoice($id)
    {
        $order = Pemesanan::with(['produk', 'bahan', 'ukuran'])->findOrFail($id);

        return view('admin.orders.invoice', compact('order'));
    }

    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->bahan()->detach();
        $pemesanan->ukuran()->detach();
        $pemesanan->delete();

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}

