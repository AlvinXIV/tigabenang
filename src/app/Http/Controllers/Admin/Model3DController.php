<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Model3DController extends Controller
{
    public function index()
    {
        $models = [
            [
                'id' => 1,
                'name' => 'Silk Drape Blouse',
                'sku' => 'SLK-BLS-01',
                'format' => 'GLB/USDZ',
                'version' => 'v2.4',
                'status' => 'Optimized',
                'preview_image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?w=600&auto=format&fit=crop&q=80',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'linked_product' => 'Silk Drape Blouse',
                'product_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Tailored Wool Blazer',
                'sku' => 'TL-BZR-99',
                'format' => 'OBJ',
                'version' => 'v1.0',
                'status' => 'Processing',
                'preview_image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600&auto=format&fit=crop&q=80',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'linked_product' => 'Tailored Wool Blazer',
                'product_id' => 4,
            ],
            [
                'id' => 3,
                'name' => 'Linen Wide Trousers',
                'sku' => 'WID-TR-04',
                'format' => 'GLB',
                'version' => 'v3.1',
                'status' => 'Optimized',
                'preview_image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=600&auto=format&fit=crop&q=80',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'linked_product' => 'Linen Wide Trousers',
                'product_id' => 5,
            ],
            [
                'id' => 4,
                'name' => 'Custom Hoodie 330gsm',
                'sku' => 'FV-HOD-001',
                'format' => 'GLB',
                'version' => 'v1.2',
                'status' => 'Optimized',
                'preview_image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&auto=format&fit=crop&q=80',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'linked_product' => 'Custom Hoodie',
                'product_id' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Oversized Cotton T-Shirt',
                'sku' => 'SKU-TSH-003',
                'format' => 'GLB',
                'version' => 'v1.0',
                'status' => 'Drafts',
                'preview_image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'linked_product' => 'Oversized T-Shirt',
                'product_id' => 3,
            ],
            [
                'id' => 6,
                'name' => 'Sublim Sport Jersey',
                'sku' => 'SKU-JER-002',
                'format' => 'GLB',
                'version' => 'v2.0',
                'status' => 'Optimized',
                'preview_image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&auto=format&fit=crop&q=80',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'linked_product' => 'Custom Jersey',
                'product_id' => 2,
            ],
        ];

        $availableProducts = [
            ['id' => 1, 'name' => 'Custom Hoodie', 'sku' => 'FV-HOD-001', 'thumbnail' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=300&auto=format&fit=crop&q=80'],
            ['id' => 2, 'name' => 'Custom Jersey', 'sku' => 'SKU-JER-002', 'thumbnail' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=300&auto=format&fit=crop&q=80'],
            ['id' => 3, 'name' => 'Oversized T-Shirt', 'sku' => 'SKU-TSH-003', 'thumbnail' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=300&auto=format&fit=crop&q=80'],
            ['id' => 4, 'name' => 'Tailored Wool Blazer', 'sku' => 'TL-BZR-99', 'thumbnail' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=300&auto=format&fit=crop&q=80'],
            ['id' => 5, 'name' => 'Linen Wide Trousers', 'sku' => 'WID-TR-04', 'thumbnail' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=300&auto=format&fit=crop&q=80'],
        ];

        return view('admin.models3d.index', compact('models', 'availableProducts'));
    }

    public function create()
    {
        $availableProducts = [
            ['id' => 1, 'name' => 'Custom Hoodie', 'sku' => 'FV-HOD-001', 'thumbnail' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=300&auto=format&fit=crop&q=80'],
            ['id' => 2, 'name' => 'Custom Jersey', 'sku' => 'SKU-JER-002', 'thumbnail' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=300&auto=format&fit=crop&q=80'],
            ['id' => 3, 'name' => 'Oversized T-Shirt', 'sku' => 'SKU-TSH-003', 'thumbnail' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=300&auto=format&fit=crop&q=80'],
            ['id' => 4, 'name' => 'Tailored Wool Blazer', 'sku' => 'TL-BZR-99', 'thumbnail' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=300&auto=format&fit=crop&q=80'],
            ['id' => 5, 'name' => 'Linen Wide Trousers', 'sku' => 'WID-TR-04', 'thumbnail' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=300&auto=format&fit=crop&q=80'],
        ];

        return view('admin.models3d.create', compact('availableProducts'));
    }

    public function edit($id)
    {
        $availableProducts = [
            ['id' => 1, 'name' => 'Custom Hoodie', 'sku' => 'FV-HOD-001', 'thumbnail' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=300&auto=format&fit=crop&q=80'],
            ['id' => 2, 'name' => 'Custom Jersey', 'sku' => 'SKU-JER-002', 'thumbnail' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=300&auto=format&fit=crop&q=80'],
            ['id' => 3, 'name' => 'Oversized T-Shirt', 'sku' => 'SKU-TSH-003', 'thumbnail' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=300&auto=format&fit=crop&q=80'],
            ['id' => 4, 'name' => 'Tailored Wool Blazer', 'sku' => 'TL-BZR-99', 'thumbnail' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=300&auto=format&fit=crop&q=80'],
            ['id' => 5, 'name' => 'Linen Wide Trousers', 'sku' => 'WID-TR-04', 'thumbnail' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=300&auto=format&fit=crop&q=80'],
        ];

        $model = [
            'id' => $id,
            'name' => 'Custom Hoodie 3D Model',
            'file_name' => 'custom-hoodie.glb',
            'file_size' => '8.4 MB',
            'format' => 'GLB',
            'version' => 'v1.0',
            'product_id' => 1,
            'description' => 'High-poly model tailored for virtual try-on module. Includes standard cotton texture maps.',
            'preview_image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&auto=format&fit=crop&q=80',
            'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
        ];

        return view('admin.models3d.edit', compact('model', 'availableProducts'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.model-3d.index')->with('success', 'Model 3D (.glb) baru berhasil diunggah ke perpustakaan asset!');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.model-3d.index')->with('success', 'Informasi model 3D berhasil diperbarui!');
    }

    public function preview($id)
    {
        $model = [
            'id' => $id,
            'name' => 'Custom Hoodie 3D Asset',
            'product_name' => 'Custom Hoodie',
            'sku' => 'FV-HOD-001',
            'format' => 'GLB',
            'version' => 'v1.2',
            'file_name' => 'custom-hoodie.glb',
            'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
        ];

        return view('admin.models3d.preview', compact('model'));
    }

    public function destroy($id)
    {
        return redirect()->route('admin.model-3d.index')->with('success', 'Aset model 3D berhasil dihapus.');
    }
}
