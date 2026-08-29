<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Summary Cards Data from Database
        $totalOrdersCount = Pemesanan::count();
        $waitingPriceCount = Pemesanan::whereNull('total_harga')->count();
        $confirmedCount = Pemesanan::whereNotNull('total_harga')->count();
        $totalProductsCount = Produk::count();

        $summary = [
            'total_orders' => [
                'count' => $totalOrdersCount,
                'subtitle' => 'Total pesanan',
            ],
            'pending_orders' => [
                'count' => $waitingPriceCount,
                'subtitle' => 'Menunggu penetapan harga',
            ],
            'waiting_price' => [
                'count' => $waitingPriceCount,
                'subtitle' => 'Perlu nego / harga',
            ],
            'confirmed_orders' => [
                'count' => $confirmedCount,
                'subtitle' => 'Harga disepakati',
            ],
        ];

        // 2. Orders Needing Action (Waiting for admin to set agreed price)
        $ordersNeedingAction = Pemesanan::with(['produk', 'bahan', 'ukuran'])
            ->whereNull('total_harga')
            ->latest('id_pemesanan')
            ->get();

        // 3. Recent Orders
        $recentOrders = Pemesanan::with(['produk', 'bahan', 'ukuran'])
            ->latest('id_pemesanan')
            ->take(10)
            ->get();

        // 4. Product Overview
        $productOverview = [
            'total_products' => $totalProductsCount,
            'models_3d_linked' => Produk::whereNotNull('file_model_3d')->where('file_model_3d', '!=', '')->count(),
        ];

        return view('admin.dashboard.index', compact(
            'summary',
            'ordersNeedingAction',
            'recentOrders',
            'productOverview'
        ));
    }
}

