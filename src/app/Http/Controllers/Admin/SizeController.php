<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Jaket Coach Taslan Waterproof',
                'category' => 'Jaket & Outerwear',
                'sizes' => [
                    ['size' => 'S', 'chest_width' => 52, 'body_length' => 68, 'shoulder_width' => 45, 'sleeve_length' => 60],
                    ['size' => 'M', 'chest_width' => 55, 'body_length' => 70, 'shoulder_width' => 47, 'sleeve_length' => 62],
                    ['size' => 'L', 'chest_width' => 58, 'body_length' => 72, 'shoulder_width' => 49, 'sleeve_length' => 64],
                    ['size' => 'XL', 'chest_width' => 61, 'body_length' => 74, 'shoulder_width' => 51, 'sleeve_length' => 66],
                    ['size' => 'XXL', 'chest_width' => 64, 'body_length' => 76, 'shoulder_width' => 53, 'sleeve_length' => 68],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Hoodie Heavyweight Fleece 330gsm',
                'category' => 'Hoodie & Sweater',
                'sizes' => [
                    ['size' => 'S', 'chest_width' => 54, 'body_length' => 66, 'shoulder_width' => 50, 'sleeve_length' => 59],
                    ['size' => 'M', 'chest_width' => 57, 'body_length' => 69, 'shoulder_width' => 52, 'sleeve_length' => 61],
                    ['size' => 'L', 'chest_width' => 60, 'body_length' => 72, 'shoulder_width' => 54, 'sleeve_length' => 63],
                    ['size' => 'XL', 'chest_width' => 63, 'body_length' => 75, 'shoulder_width' => 56, 'sleeve_length' => 65],
                    ['size' => 'XXL', 'chest_width' => 66, 'body_length' => 78, 'shoulder_width' => 58, 'sleeve_length' => 67],
                ]
            ],
            [
                'id' => 3,
                'name' => 'Kaos Oversize Cotton Combed 24s',
                'category' => 'Kaos & T-Shirt',
                'sizes' => [
                    ['size' => 'S', 'chest_width' => 54, 'body_length' => 70, 'shoulder_width' => 50, 'sleeve_length' => 24],
                    ['size' => 'M', 'chest_width' => 57, 'body_length' => 73, 'shoulder_width' => 52, 'sleeve_length' => 25],
                    ['size' => 'L', 'chest_width' => 60, 'body_length' => 76, 'shoulder_width' => 54, 'sleeve_length' => 26],
                    ['size' => 'XL', 'chest_width' => 63, 'body_length' => 79, 'shoulder_width' => 56, 'sleeve_length' => 27],
                ]
            ],
        ];

        return view('admin.sizes.index', compact('products'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.ukuran.index')->with('success', 'Matriks ukuran produk berhasil diperbarui!');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.ukuran.index')->with('success', 'Ukuran spesifikasi berhasil diperbarui!');
    }
}
