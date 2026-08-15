<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Jaket Coach Taslan Waterproof',
                'slug' => 'jaket-coach-taslan',
                'category' => 'Jaket & Outerwear',
                'category_id' => 1,
                'material' => 'Taslan Milky Waterproof + Furing Asahi',
                'colors' => ['Hitam', 'Navy', 'Hijau Army', 'Maroon'],
                'estimated_price' => 'Rp 185.000',
                'min_order' => '24 pcs',
                'has_3d_model' => true,
                'status' => 'active',
                'thumbnail' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 2,
                'name' => 'Hoodie Heavyweight Fleece 330gsm',
                'slug' => 'hoodie-heavyweight-fleece',
                'category' => 'Hoodie & Sweater',
                'category_id' => 3,
                'material' => '100% Cotton Fleece Heavyweight 330gsm',
                'colors' => ['Hitam', 'Abu Misty', 'Oatmeal', 'Dark Olive'],
                'estimated_price' => 'Rp 175.000',
                'min_order' => '24 pcs',
                'has_3d_model' => true,
                'status' => 'active',
                'thumbnail' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 3,
                'name' => 'Kaos Oversize Cotton Combed 24s',
                'slug' => 'kaos-oversize-combed-24s',
                'category' => 'Kaos & T-Shirt',
                'category_id' => 2,
                'material' => 'Cotton Combed 24s Premium Soft',
                'colors' => ['Putih Solid', 'Hitam Jetblack', 'Sage Green', 'Khaki'],
                'estimated_price' => 'Rp 65.000',
                'min_order' => '36 pcs',
                'has_3d_model' => true,
                'status' => 'active',
                'thumbnail' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 4,
                'name' => 'Kemeja Tactical PDL Japan Drill',
                'slug' => 'kemeja-tactical-pdl',
                'category' => 'Kemeja & Workshirt',
                'category_id' => 4,
                'material' => 'Japan Drill Original Grade A',
                'colors' => ['Khaki', 'Hitam', 'Hijau Army', 'Biru Navy'],
                'estimated_price' => 'Rp 145.000',
                'min_order' => '20 pcs',
                'has_3d_model' => false,
                'status' => 'active',
                'thumbnail' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 5,
                'name' => 'Jersey Full Printing Sublim Drifit Milano',
                'slug' => 'jersey-full-printing-drifit',
                'category' => 'Jersey & Sportswear',
                'category_id' => 5,
                'material' => 'Drifit Milano Anti-Bacterial UV Protect',
                'colors' => ['Custom Full Color Gradient'],
                'estimated_price' => 'Rp 135.000',
                'min_order' => '12 pcs',
                'has_3d_model' => true,
                'status' => 'active',
                'thumbnail' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 6,
                'name' => 'Jaket Varsity Wool Leather Combination',
                'slug' => 'jaket-varsity-wool',
                'category' => 'Jaket & Outerwear',
                'category_id' => 1,
                'material' => 'Wool Laken Premium + Leather Sintetis Grade A',
                'colors' => ['Hitam-Putih', 'Hijau Botol-Krem', 'Maroon-Putih'],
                'estimated_price' => 'Rp 265.000',
                'min_order' => '24 pcs',
                'has_3d_model' => false,
                'status' => 'active',
                'thumbnail' => 'https://images.unsplash.com/photo-1548883354-7622d03aca27?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = [
            ['id' => 1, 'name' => 'Jaket & Outerwear'],
            ['id' => 2, 'name' => 'Kaos & T-Shirt'],
            ['id' => 3, 'name' => 'Hoodie & Sweater'],
            ['id' => 4, 'name' => 'Kemeja & Workshirt'],
            ['id' => 5, 'name' => 'Jersey & Sportswear'],
            ['id' => 6, 'name' => 'Produk Custom Spesial'],
        ];

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.produk.index')->with('success', 'Produk pakaian baru berhasil ditambahkan ke katalog!');
    }

    public function edit($id)
    {
        $product = [
            'id' => $id,
            'name' => 'Jaket Coach Taslan Waterproof',
            'category_id' => 1,
            'material' => 'Taslan Milky Waterproof + Furing Asahi',
            'colors' => 'Hitam, Navy, Hijau Army, Maroon',
            'estimated_price' => 185000,
            'min_order' => 24,
            'status' => 'active',
            'description' => 'Jaket coach kustom dengan bahan luar taslan milky tahan air ringan (water-repellent) dan furing dalam asahi yang sejuk. Cocok untuk seragam panitia event, jaket angkatan mahasiswa, maupun merchandise komunitas.',
        ];

        $categories = [
            ['id' => 1, 'name' => 'Jaket & Outerwear'],
            ['id' => 2, 'name' => 'Kaos & T-Shirt'],
            ['id' => 3, 'name' => 'Hoodie & Sweater'],
            ['id' => 4, 'name' => 'Kemeja & Workshirt'],
            ['id' => 5, 'name' => 'Jersey & Sportswear'],
            ['id' => 6, 'name' => 'Produk Custom Spesial'],
        ];

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.produk.index')->with('success', 'Informasi produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus dari katalog.');
    }
}
