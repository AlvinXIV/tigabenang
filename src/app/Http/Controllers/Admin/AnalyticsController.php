<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Pemesanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalRevenue = Pemesanan::sum('total_harga') ?? 0;
        $totalOrders = Pemesanan::count();
        $avgOrderValue = Pemesanan::whereNotNull('total_harga')->avg('total_harga') ?? 0;
        $activeProducts = Produk::count();

        $kpis = [
            'total_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
            'total_orders' => $totalOrders,
            'avg_order_value' => 'Rp ' . number_format($avgOrderValue, 0, ',', '.'),
            'active_products' => $activeProducts,
        ];

        $topProducts = Produk::withCount('pemesanan')
            ->with('kategori')
            ->orderByDesc('pemesanan_count')
            ->take(5)
            ->get();

        $topMaterials = Bahan::withCount('pemesanan')
            ->orderByDesc('pemesanan_count')
            ->take(5)
            ->get();

        return view('admin.analytics.index', compact(
            'kpis',
            'topProducts',
            'topMaterials'
        ));
    }
}

