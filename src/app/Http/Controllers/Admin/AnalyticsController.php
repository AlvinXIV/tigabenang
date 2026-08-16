<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $kpis = [
            'total_revenue' => 'Rp 38.200.000',
            'total_orders' => 18,
            'avg_order_value' => 'Rp 2.122.222',
            'active_products' => 8,
        ];

        $monthlyTrend = [
            ['month' => 'Mar', 'revenue' => 4500000, 'orders' => 2, 'formatted_revenue' => 'Rp 4,5 Jt'],
            ['month' => 'Apr', 'revenue' => 6200000, 'orders' => 3, 'formatted_revenue' => 'Rp 6,2 Jt'],
            ['month' => 'Mei', 'revenue' => 8800000, 'orders' => 4, 'formatted_revenue' => 'Rp 8,8 Jt'],
            ['month' => 'Jun', 'revenue' => 9500000, 'orders' => 4, 'formatted_revenue' => 'Rp 9,5 Jt'],
            ['month' => 'Jul', 'revenue' => 12400000, 'orders' => 5, 'formatted_revenue' => 'Rp 12,4 Jt'],
            ['month' => 'Agu', 'revenue' => 38200000, 'orders' => 18, 'formatted_revenue' => 'Rp 38,2 Jt'],
        ];

        $topProducts = [
            ['name' => 'Custom Hoodie 330gsm', 'category' => 'Hoodie & Outerwear', 'orders_count' => 6, 'total_units' => 180, 'revenue' => 'Rp 14.250.000'],
            ['name' => 'Custom Coach Jacket', 'category' => 'Jaket & Outerwear', 'orders_count' => 4, 'total_units' => 140, 'revenue' => 'Rp 11.250.000'],
            ['name' => 'Sublim Sport Jersey', 'category' => 'Jersey & Sportswear', 'orders_count' => 4, 'total_units' => 160, 'revenue' => 'Rp 10.800.000'],
            ['name' => 'Oversized Cotton T-Shirt', 'category' => 'Kaos & Tops', 'orders_count' => 3, 'total_units' => 240, 'revenue' => 'Rp 8.500.000'],
            ['name' => 'Kemeja PDL Tactical', 'category' => 'Kemeja & Seragam', 'orders_count' => 1, 'total_units' => 40, 'revenue' => 'Rp 5.800.000'],
        ];

        $topMaterials = [
            ['name' => 'Cotton Combed 24s', 'usage_percentage' => 35, 'unit' => 'meter', 'stock_left' => '320 m'],
            ['name' => 'Heavyweight Fleece 330gsm', 'usage_percentage' => 28, 'unit' => 'meter', 'stock_left' => '145 m'],
            ['name' => 'Taslan Milky Waterproof', 'usage_percentage' => 18, 'unit' => 'yard', 'stock_left' => '85 yd'],
            ['name' => 'Drifit Milano Quick-Dry', 'usage_percentage' => 12, 'unit' => 'meter', 'stock_left' => '210 m'],
            ['name' => 'Japan Drill High Grade', 'usage_percentage' => 7, 'unit' => 'meter', 'stock_left' => '95 m'],
        ];

        $statusDistribution = [
            ['status' => 'Completed', 'count' => 9, 'percentage' => 50, 'color' => 'bg-emerald-500'],
            ['status' => 'In Production', 'count' => 4, 'percentage' => 22, 'color' => 'bg-indigo-500'],
            ['status' => 'Confirmed', 'count' => 3, 'percentage' => 17, 'color' => 'bg-sky-500'],
            ['status' => 'Pending Review', 'count' => 2, 'percentage' => 11, 'color' => 'bg-amber-500'],
        ];

        return view('admin.analytics.index', compact(
            'kpis',
            'monthlyTrend',
            'topProducts',
            'topMaterials',
            'statusDistribution'
        ));
    }
}
