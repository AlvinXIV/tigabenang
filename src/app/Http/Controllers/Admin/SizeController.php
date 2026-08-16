<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizeCharts = [
            [
                'id' => 1,
                'name' => 'Tailored Jacket Standard',
                'description' => 'Base pattern measurements for standard tailored jackets. Values in cm.',
                'category' => 'Jacket',
                'status' => 'Active',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'points' => [
                    ['name' => 'Neck Base', 's' => '38.0', 'm' => '39.0', 'l' => '40.5', 'xl' => '42.0', 'xxl' => '--'],
                    ['name' => 'Chest (Full)', 's' => '98.0', 'm' => '102.0', 'l' => '106.0', 'xl' => '110.0', 'xxl' => '114.0'],
                    ['name' => 'Waist', 's' => '86.0', 'm' => '90.0', 'l' => '94.0', 'xl' => '98.0', 'xxl' => '102.0'],
                    ['name' => 'Hip (Seat)', 's' => '100.0', 'm' => '104.0', 'l' => '108.0', 'xl' => '112.0', 'xxl' => '116.0'],
                    ['name' => 'Sleeve Length', 's' => '84.0', 'm' => '85.5', 'l' => '87.0', 'xl' => '88.5', 'xxl' => '90.0'],
                    ['name' => 'Back Length', 's' => '73.5', 'm' => '75.0', 'l' => '76.5', 'xl' => '78.0', 'xxl' => '79.5'],
                ],
            ],
            [
                'id' => 2,
                'name' => "Men's Hoodie Standard",
                'description' => 'Measurement specifications for fleece pullover & zip hoodies. Values in cm.',
                'category' => 'Hoodie',
                'status' => 'Active',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'points' => [
                    ['name' => 'Chest Width', 's' => '54.0', 'm' => '57.0', 'l' => '60.0', 'xl' => '63.0', 'xxl' => '66.0'],
                    ['name' => 'Body Length', 's' => '66.0', 'm' => '69.0', 'l' => '72.0', 'xl' => '75.0', 'xxl' => '78.0'],
                    ['name' => 'Shoulder Width', 's' => '50.0', 'm' => '52.0', 'l' => '54.0', 'xl' => '56.0', 'xxl' => '58.0'],
                    ['name' => 'Sleeve Length', 's' => '59.0', 'm' => '61.0', 'l' => '63.0', 'xl' => '65.0', 'xxl' => '67.0'],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Oversized T-Shirt Profile',
                'description' => 'Drop-shoulder and relaxed fit t-shirt measurements. Values in cm.',
                'category' => 'T-Shirt',
                'status' => 'Active',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'points' => [
                    ['name' => 'Chest Width', 's' => '54.0', 'm' => '57.0', 'l' => '60.0', 'xl' => '63.0', 'xxl' => '66.0'],
                    ['name' => 'Body Length', 's' => '70.0', 'm' => '73.0', 'l' => '76.0', 'xl' => '79.0', 'xxl' => '82.0'],
                    ['name' => 'Shoulder Width', 's' => '50.0', 'm' => '52.0', 'l' => '54.0', 'xl' => '56.0', 'xxl' => '58.0'],
                    ['name' => 'Sleeve Length', 's' => '24.0', 'm' => '25.0', 'l' => '26.0', 'xl' => '27.0', 'xxl' => '28.0'],
                ],
            ],
            [
                'id' => 4,
                'name' => 'Sport Jersey Regular',
                'description' => 'Standard athletic sports jersey measurements. Values in cm.',
                'category' => 'Jersey',
                'status' => 'Active',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'points' => [
                    ['name' => 'Chest Width', 's' => '50.0', 'm' => '52.0', 'l' => '54.0', 'xl' => '56.0', 'xxl' => '58.0'],
                    ['name' => 'Body Length', 's' => '68.0', 'm' => '70.0', 'l' => '72.0', 'xl' => '74.0', 'xxl' => '76.0'],
                    ['name' => 'Shoulder Width', 's' => '44.0', 'm' => '46.0', 'l' => '48.0', 'xl' => '50.0', 'xxl' => '52.0'],
                ],
            ],
        ];

        return view('admin.sizes.index', compact('sizeCharts'));
    }

    public function create()
    {
        $categories = ['Jacket & Outerwear', 'Hoodie & Sweater', 'T-Shirt & Tops', 'Polo Shirt', 'Jersey & Sportswear'];
        $defaultSizes = ['S', 'M', 'L', 'XL', 'XXL'];
        $defaultPoints = ['Chest (cm)', 'Length (cm)', 'Shoulder (cm)', 'Sleeve Length (cm)', 'Waist (cm)'];

        return view('admin.sizes.create', compact('categories', 'defaultSizes', 'defaultPoints'));
    }

    public function edit($id)
    {
        $categories = ['Jacket & Outerwear', 'Hoodie & Sweater', 'T-Shirt & Tops', 'Polo Shirt', 'Jersey & Sportswear'];
        
        $sizeCharts = [
            1 => [
                'id' => 1,
                'name' => 'Tailored Jacket Standard',
                'description' => 'Base pattern measurements for standard tailored jackets. Values in cm.',
                'category' => 'Jacket & Outerwear',
                'status' => 'Active',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'points' => [
                    ['name' => 'Neck Base', 's' => '38.0', 'm' => '39.0', 'l' => '40.5', 'xl' => '42.0', 'xxl' => '--'],
                    ['name' => 'Chest (Full)', 's' => '98.0', 'm' => '102.0', 'l' => '106.0', 'xl' => '110.0', 'xxl' => '114.0'],
                    ['name' => 'Waist', 's' => '86.0', 'm' => '90.0', 'l' => '94.0', 'xl' => '98.0', 'xxl' => '102.0'],
                    ['name' => 'Hip (Seat)', 's' => '100.0', 'm' => '104.0', 'l' => '108.0', 'xl' => '112.0', 'xxl' => '116.0'],
                    ['name' => 'Sleeve Length', 's' => '84.0', 'm' => '85.5', 'l' => '87.0', 'xl' => '88.5', 'xxl' => '90.0'],
                    ['name' => 'Back Length', 's' => '73.5', 'm' => '75.0', 'l' => '76.5', 'xl' => '78.0', 'xxl' => '79.5'],
                ],
            ],
            2 => [
                'id' => 2,
                'name' => "Men's Hoodie Standard",
                'description' => 'Measurement specifications for fleece pullover & zip hoodies. Values in cm.',
                'category' => 'Hoodie & Sweater',
                'status' => 'Active',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'points' => [
                    ['name' => 'Chest Width', 's' => '54.0', 'm' => '57.0', 'l' => '60.0', 'xl' => '63.0', 'xxl' => '66.0'],
                    ['name' => 'Body Length', 's' => '66.0', 'm' => '69.0', 'l' => '72.0', 'xl' => '75.0', 'xxl' => '78.0'],
                    ['name' => 'Shoulder Width', 's' => '50.0', 'm' => '52.0', 'l' => '54.0', 'xl' => '56.0', 'xxl' => '58.0'],
                    ['name' => 'Sleeve Length', 's' => '59.0', 'm' => '61.0', 'l' => '63.0', 'xl' => '65.0', 'xxl' => '67.0'],
                ],
            ],
            3 => [
                'id' => 3,
                'name' => 'Oversized T-Shirt Profile',
                'description' => 'Drop-shoulder and relaxed fit t-shirt measurements. Values in cm.',
                'category' => 'T-Shirt & Tops',
                'status' => 'Active',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'points' => [
                    ['name' => 'Chest Width', 's' => '54.0', 'm' => '57.0', 'l' => '60.0', 'xl' => '63.0', 'xxl' => '66.0'],
                    ['name' => 'Body Length', 's' => '70.0', 'm' => '73.0', 'l' => '76.0', 'xl' => '79.0', 'xxl' => '82.0'],
                    ['name' => 'Shoulder Width', 's' => '50.0', 'm' => '52.0', 'l' => '54.0', 'xl' => '56.0', 'xxl' => '58.0'],
                    ['name' => 'Sleeve Length', 's' => '24.0', 'm' => '25.0', 'l' => '26.0', 'xl' => '27.0', 'xxl' => '28.0'],
                ],
            ],
            4 => [
                'id' => 4,
                'name' => 'Sport Jersey Regular',
                'description' => 'Standard athletic sports jersey measurements. Values in cm.',
                'category' => 'Jersey & Sportswear',
                'status' => 'Active',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'points' => [
                    ['name' => 'Chest Width', 's' => '50.0', 'm' => '52.0', 'l' => '54.0', 'xl' => '56.0', 'xxl' => '58.0'],
                    ['name' => 'Body Length', 's' => '68.0', 'm' => '70.0', 'l' => '72.0', 'xl' => '74.0', 'xxl' => '76.0'],
                    ['name' => 'Shoulder Width', 's' => '44.0', 'm' => '46.0', 'l' => '48.0', 'xl' => '50.0', 'xxl' => '52.0'],
                ],
            ],
        ];

        $chart = $sizeCharts[$id] ?? $sizeCharts[1];

        return view('admin.sizes.edit', compact('chart', 'categories'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.ukuran.index')->with('success', 'Profil Size Chart baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.ukuran.index')->with('success', 'Ukuran spesifikasi Size Chart berhasil diperbarui!');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.ukuran.index')->with('success', 'Size Chart berhasil dihapus.');
    }
}
