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
                'name' => 'Custom Hoodie',
                'sku' => 'SKU-HOD-001',
                'category' => 'Hoodie',
                'category_id' => 3,
                'price' => 'Rp125.000',
                'thumbnail' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 2,
                'name' => 'Custom Jersey',
                'sku' => 'SKU-JER-002',
                'category' => 'Jersey',
                'category_id' => 5,
                'price' => 'Rp110.000',
                'thumbnail' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 3,
                'name' => 'Oversized T-Shirt',
                'sku' => 'SKU-TSH-003',
                'category' => 'T-Shirt',
                'category_id' => 2,
                'price' => 'Rp85.000',
                'thumbnail' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 4,
                'name' => 'Custom Jacket',
                'sku' => 'SKU-JKT-004',
                'category' => 'Jacket',
                'category_id' => 1,
                'price' => 'Rp175.000',
                'thumbnail' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 5,
                'name' => 'Custom Polo',
                'sku' => 'SKU-POL-005',
                'category' => 'Polo',
                'category_id' => 4,
                'price' => 'Rp95.000',
                'thumbnail' => 'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        $totalProducts = 142;

        return view('admin.products.index', compact('products', 'totalProducts'));
    }

    public function create()
    {
        $categories = ['Hoodie', 'T-Shirt', 'Jacket', 'Polo', 'Jersey', 'Pants & Shorts'];
        
        $availableMaterials = [
            'Cotton Fleece',
            'Baby Terry',
            'Cotton Combed 24s',
            'Cotton Combed 30s',
            'Taslan Milky',
            'Japan Drill',
            'Drifit Milano',
            'Lacoste CVC',
            'Canvas',
        ];

        $categorySizes = [
            'Hoodie' => ['S', 'M', 'L', 'XL', 'XXL'],
            'T-Shirt' => ['S', 'M', 'L', 'XL', 'XXL'],
            'Jacket' => ['S', 'M', 'L', 'XL', 'XXL'],
            'Polo' => ['S', 'M', 'L', 'XL'],
            'Jersey' => ['S', 'M', 'L', 'XL', 'XXL'],
            'Pants & Shorts' => ['28', '30', '32', '34', '36'],
        ];

        return view('admin.products.create', compact('categories', 'availableMaterials', 'categorySizes'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.produk.index')->with('success', 'Produk baru berhasil ditambahkan ke katalog!');
    }

    public function edit($id)
    {
        $product = [
            'id' => $id,
            'name' => 'Custom Hoodie',
            'sku' => 'FV-HOD-001',
            'category_id' => 3,
            'category_name' => 'Hoodie',
            'description' => 'Customizable everyday hoodie designed for comfortable casual wear and bulk vendor production.',
            'price' => 125000,
            'image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&auto=format&fit=crop&q=80',
            'materials' => [
                [
                    'id' => 1,
                    'name' => 'Cotton Fleece',
                    'description' => 'Premium warm soft interior, ideal for cooler climates.',
                    'selected' => true,
                ],
                [
                    'id' => 2,
                    'name' => 'Baby Terry',
                    'description' => 'Lightweight, breathable loop-knit. Great for everyday wear.',
                    'selected' => false,
                ],
                [
                    'id' => 3,
                    'name' => 'French Terry',
                    'description' => 'Durable, moisture-wicking structured drape.',
                    'selected' => false,
                ],
            ],
            'size_chart_name' => "Men's Hoodie Standard",
            'sizes' => [
                ['size' => 'S', 'chest' => 50, 'length' => 68, 'shoulder' => 44, 'sleeve' => 62],
                ['size' => 'M', 'chest' => 52, 'length' => 70, 'shoulder' => 46, 'sleeve' => 64],
                ['size' => 'L', 'chest' => 54, 'length' => 72, 'shoulder' => 48, 'sleeve' => 66],
                ['size' => 'XL', 'chest' => 56, 'length' => 74, 'shoulder' => 50, 'sleeve' => 68],
            ],
            'model_3d' => [
                'file_name' => 'custom-hoodie.glb',
                'file_size' => '4.2 MB',
                'preview_image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&auto=format&fit=crop&q=80',
            ],
        ];

        $categories = [
            ['id' => 1, 'name' => 'Jacket'],
            ['id' => 2, 'name' => 'T-Shirt'],
            ['id' => 3, 'name' => 'Hoodie'],
            ['id' => 4, 'name' => 'Polo'],
            ['id' => 5, 'name' => 'Jersey'],
            ['id' => 6, 'name' => 'Custom Special'],
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
