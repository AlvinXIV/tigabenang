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
                'product_name' => 'Jaket Coach Taslan Waterproof',
                'category' => 'Jaket & Outerwear',
                'file_name' => 'jacket_coach_taslan_v2.glb',
                'file_size' => '4.8 MB',
                'status' => 'active',
                'fitting_ready' => true,
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb', // Demo public 3D asset
                'last_updated' => '12 Agu 2026',
            ],
            [
                'id' => 2,
                'product_name' => 'Hoodie Heavyweight Fleece 330gsm',
                'category' => 'Hoodie & Sweater',
                'file_name' => 'hoodie_heavyweight_330.glb',
                'file_size' => '6.2 MB',
                'status' => 'active',
                'fitting_ready' => true,
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'last_updated' => '10 Agu 2026',
            ],
            [
                'id' => 3,
                'product_name' => 'Kaos Oversize Cotton Combed 24s',
                'category' => 'Kaos & T-Shirt',
                'file_name' => 'tshirt_oversize_combed24s.glb',
                'file_size' => '3.5 MB',
                'status' => 'active',
                'fitting_ready' => true,
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'last_updated' => '08 Agu 2026',
            ],
            [
                'id' => 4,
                'product_name' => 'Jersey Full Printing Sublim Drifit',
                'category' => 'Jersey & Sportswear',
                'file_name' => 'jersey_sublim_drifit.glb',
                'file_size' => '5.1 MB',
                'status' => 'active',
                'fitting_ready' => true,
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'last_updated' => '05 Agu 2026',
            ],
        ];

        return view('admin.models3d.index', compact('models'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.model-3d.index')->with('success', 'File model 3D pakaian (.glb) berhasil diunggah dan dikaitkan ke produk!');
    }

    public function preview($id)
    {
        $model = [
            'id' => $id,
            'product_name' => 'Jaket Coach Taslan Waterproof',
            'category' => 'Jaket & Outerwear',
            'file_name' => 'jacket_coach_taslan_v2.glb',
            'file_size' => '4.8 MB',
            'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
            'created_at' => '12 Agu 2026',
        ];

        return view('admin.models3d.preview', compact('model'));
    }

    public function destroy($id)
    {
        return redirect()->route('admin.model-3d.index')->with('success', 'Aset model 3D berhasil dihapus.');
    }
}
