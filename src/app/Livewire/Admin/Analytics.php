<?php

namespace App\Livewire\Admin;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Pemesanan;
use App\Models\Produk;
use Livewire\Component;

class Analytics extends Component
{
    public function render()
    {
        $rawOrders = Pemesanan::with(['produk.kategori', 'bahan'])
            ->orderBy('created_at', 'asc')
            ->get();

        $analyticsOrders = $rawOrders->map(function ($order) {
            return [
                'id' => $order->id_pemesanan,
                'date' => $order->created_at ? $order->created_at->format('Y-m-d') : null,
                'display_date' => $order->created_at ? $order->created_at->translatedFormat('d M Y') : '-',
                'short_date' => $order->created_at ? $order->created_at->format('d M') : '-',
                'timestamp' => $order->created_at ? $order->created_at->timestamp : 0,
                'total_harga' => $order->total_harga !== null ? (float) $order->total_harga : null,
                'product_id' => $order->produk_id,
                'product_name' => $order->produk ? $order->produk->nama_produk : 'Produk Dihapus',
                'category_name' => ($order->produk && $order->produk->kategori) ? $order->produk->kategori->nama_kategori : 'Katalog Standar',
                'materials' => $order->bahan->pluck('nama_bahan')->toArray(),
            ];
        });

        $allCategories = Kategori::withCount('produk')->get()->map(function ($cat) {
            return [
                'id' => $cat->id_kategori,
                'name' => $cat->nama_kategori,
                'products_count' => $cat->produk_count,
            ];
        });

        $totalRevenue = Pemesanan::sum('total_harga') ?? 0;
        $totalOrders = Pemesanan::count();
        $avgOrderValue = Pemesanan::whereNotNull('total_harga')->avg('total_harga') ?? 0;
        $totalCatalogProducts = Produk::count();
        $productsWithout3DCount = Produk::whereNull('file_model_3d')->orWhere('file_model_3d', '')->count();
        $categoriesWithoutProductsCount = Kategori::doesntHave('produk')->count();

        $kpis = [
            'total_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
            'total_orders' => $totalOrders,
            'avg_order_value' => 'Rp ' . number_format($avgOrderValue, 0, ',', '.'),
            'active_products' => $totalCatalogProducts,
        ];

        return view('livewire.admin.analytics', compact(
            'analyticsOrders',
            'allCategories',
            'kpis',
            'totalCatalogProducts',
            'productsWithout3DCount',
            'categoriesWithoutProductsCount'
        ));
    }
}
