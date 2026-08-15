<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Jaket & Outerwear',
                'slug' => 'jaket-outerwear',
                'description' => 'Jaket Coach, Varsity, Bomber, Windbreaker, dan Parka berbahan Taslan & Canvas.',
                'products_count' => 6,
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Kaos & T-Shirt',
                'slug' => 'kaos-tshirt',
                'description' => 'Kaos Regular & Oversize Cotton Combed 20s, 24s, 30s sablon plastisol/DTF.',
                'products_count' => 8,
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Hoodie & Sweater',
                'slug' => 'hoodie-sweater',
                'description' => 'Hoodie Pullover, Zip-up, dan Crewneck Cotton Fleece gramasi 280-330 gsm.',
                'products_count' => 5,
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Kemeja & Workshirt',
                'slug' => 'kemeja-workshirt',
                'description' => 'Kemeja PDH, PDL, Tactical, dan Workshirt berbahan American/Japan Drill.',
                'products_count' => 4,
                'is_active' => true,
            ],
            [
                'id' => 5,
                'name' => 'Jersey & Sportswear',
                'slug' => 'jersey-sportswear',
                'description' => 'Jersey sepakbola, futsal, sepeda, esport metode Full Sublimation Drifit.',
                'products_count' => 3,
                'is_active' => true,
            ],
            [
                'id' => 6,
                'name' => 'Produk Custom Spesial',
                'slug' => 'produk-custom',
                'description' => 'Produksi custom dengan pola, bordir, dan detail aksesoris khusus pesanan klien.',
                'products_count' => 2,
                'is_active' => true,
            ],
        ];

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
