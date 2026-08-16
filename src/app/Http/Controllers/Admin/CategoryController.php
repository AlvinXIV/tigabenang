<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $materials = [
            [
                'id' => 1,
                'name' => 'Cotton Fleece',
                'sku' => 'TB-CF-001',
                'type' => 'Knit / Fleece',
                'description' => 'Black • 100% Cotton • 280 g/m²',
                'stock' => '1,250',
                'unit' => 'm',
                'is_low_stock' => false,
                'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=500&auto=format&fit=crop&q=80',
                'used_in' => ['Custom Hoodie', 'Crewneck Sweater'],
            ],
            [
                'id' => 2,
                'name' => 'Baby Terry',
                'sku' => 'TB-BT-002',
                'type' => 'Knit / French Terry',
                'description' => 'Grey • 100% Cotton • 240 g/m²',
                'stock' => '40',
                'unit' => 'm',
                'is_low_stock' => true,
                'image' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=500&auto=format&fit=crop&q=80',
                'used_in' => ['Custom Hoodie', 'Custom Jacket'],
            ],
            [
                'id' => 3,
                'name' => 'Cotton Combed 24s',
                'sku' => 'TB-CC-003',
                'type' => 'Knit / Single Jersey',
                'description' => 'White • 100% Cotton • 175 g/m²',
                'stock' => '850',
                'unit' => 'm',
                'is_low_stock' => false,
                'image' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=500&auto=format&fit=crop&q=80',
                'used_in' => ['Oversized T-Shirt', 'Custom Polo'],
            ],
            [
                'id' => 4,
                'name' => 'Taslan Milky',
                'sku' => 'TB-TM-004',
                'type' => 'Woven / Waterproof',
                'description' => 'Navy • Microfiber Taslan • 120 g/m²',
                'stock' => '85',
                'unit' => 'm',
                'is_low_stock' => true,
                'image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=500&auto=format&fit=crop&q=80',
                'used_in' => ['Custom Coach Jacket', 'Windbreaker'],
            ],
            [
                'id' => 5,
                'name' => 'Japan Drill',
                'sku' => 'TB-JD-005',
                'type' => 'Woven / Drill',
                'description' => 'Khaki • Polyester-Cotton • 210 g/m²',
                'stock' => '640',
                'unit' => 'm',
                'is_low_stock' => false,
                'image' => 'https://images.unsplash.com/photo-1528459801416-a9e53bbf4e17?w=500&auto=format&fit=crop&q=80',
                'used_in' => ['Workshirt', 'Cargo Pants'],
            ],
            [
                'id' => 6,
                'name' => 'Drifit Milano',
                'sku' => 'TB-DM-006',
                'type' => 'Knit / Performance',
                'description' => 'Full White • 100% Polyester • 150 g/m²',
                'stock' => '920',
                'unit' => 'm',
                'is_low_stock' => false,
                'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=500&auto=format&fit=crop&q=80',
                'used_in' => ['Custom Jersey', 'Sportswear'],
            ],
        ];

        $summary = [
            'total_materials' => 24,
            'low_stock_count' => 2,
        ];

        return view('admin.categories.index', compact('materials', 'summary'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.kategori.index')->with('success', 'Material kain baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $categories = ['Knit', 'Woven', 'Synthetic', 'Denim', 'Leather'];

        $material = [
            'id' => $id,
            'name' => 'Cotton Fleece',
            'sku' => 'TB-CF-001',
            'category' => 'Knit',
            'color' => 'Black',
            'composition' => '100% Cotton',
            'weight' => '280',
            'stock' => '1,250',
            'unit' => 'm',
            'is_low_stock' => false,
            'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=500&auto=format&fit=crop&q=80',
            'description' => 'Heavyweight cotton fleece material suitable for hoodies and sweatshirts with high warmth and soft touch.',
            'used_in_products' => [
                [
                    'id' => 1,
                    'name' => 'Custom Hoodie 330gsm',
                    'sku' => 'TB-HD-001',
                    'thumbnail' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=500&auto=format&fit=crop&q=80',
                    'route' => route('admin.produk.edit', 1)
                ],
                [
                    'id' => 4,
                    'name' => 'Custom Coach Jacket',
                    'sku' => 'TB-CJ-004',
                    'thumbnail' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=500&auto=format&fit=crop&q=80',
                    'route' => route('admin.produk.edit', 4)
                ],
            ]
        ];

        return view('admin.categories.edit', compact('material', 'categories'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.kategori.index')->with('success', 'Stok dan spesifikasi material berhasil diperbarui!');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.kategori.index')->with('success', 'Material berhasil dihapus.');
    }
}
