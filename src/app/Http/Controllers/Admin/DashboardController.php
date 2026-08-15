<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_products' => 24,
            'total_orders' => 148,
            'active_models_3d' => 12,
            'estimated_revenue' => 'Rp 48.500.000',
            'pending_orders_count' => 3,
        ];

        $recentOrders = [
            [
                'id' => 1,
                'order_code' => 'TB-9021',
                'customer_name' => 'Ahmad Fauzi (PT Sinergi Abadi)',
                'product_name' => 'Jaket Coach Taslan Custom',
                'size' => 'L & XL',
                'quantity' => 50,
                'total_price' => 'Rp 9.250.000',
                'status' => 'pending',
                'date' => '15 Agu 2026',
            ],
            [
                'id' => 2,
                'order_code' => 'TB-9020',
                'customer_name' => 'Dimas Pratama',
                'product_name' => 'Hoodie Heavyweight Fleece 330gsm',
                'size' => 'L',
                'quantity' => 30,
                'total_price' => 'Rp 5.400.000',
                'status' => 'in_production',
                'date' => '14 Agu 2026',
            ],
            [
                'id' => 3,
                'order_code' => 'TB-9019',
                'customer_name' => 'Siti Nurhaliza',
                'product_name' => 'Kaos Oversize Combed 24s',
                'size' => 'M',
                'quantity' => 100,
                'total_price' => 'Rp 6.500.000',
                'status' => 'confirmed',
                'date' => '13 Agu 2026',
            ],
            [
                'id' => 4,
                'order_code' => 'TB-9018',
                'customer_name' => 'Budi Santoso (BEM Fasilkom)',
                'product_name' => 'Jersey Full Printing Drifit',
                'size' => 'S, M, L, XXL',
                'quantity' => 80,
                'total_price' => 'Rp 11.200.000',
                'status' => 'completed',
                'date' => '10 Agu 2026',
            ],
            [
                'id' => 5,
                'order_code' => 'TB-9017',
                'customer_name' => 'Rian Hidayat',
                'product_name' => 'Kemeja Workshirt Drill',
                'size' => 'XL',
                'quantity' => 40,
                'total_price' => 'Rp 5.800.000',
                'status' => 'completed',
                'date' => '08 Agu 2026',
            ],
        ];

        $popularProducts = [
            ['name' => 'Hoodie Heavyweight Fleece', 'category' => 'Hoodie', 'orders' => 42, '3d_ready' => true],
            ['name' => 'Kaos Oversize Combed 24s', 'category' => 'Kaos', 'orders' => 38, '3d_ready' => true],
            ['name' => 'Jaket Coach Taslan Custom', 'category' => 'Jaket', 'orders' => 29, '3d_ready' => true],
            ['name' => 'Jersey Full Printing Drifit', 'category' => 'Jersey', 'orders' => 25, '3d_ready' => false],
        ];

        return view('admin.dashboard.index', compact('metrics', 'recentOrders', 'popularProducts'));
    }
}
