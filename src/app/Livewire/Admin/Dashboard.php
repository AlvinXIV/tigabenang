<?php

namespace App\Livewire\Admin;

use App\Models\Pemesanan;
use App\Models\Produk;
use Livewire\Component;

class Dashboard extends Component
{
    public string $search = '';

    public function render()
    {
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

        $ordersNeedingActionQuery = Pemesanan::with(['produk', 'bahan', 'ukuran'])
            ->whereNull('total_harga');

        if (!empty($this->search)) {
            $s = trim($this->search);
            $ordersNeedingActionQuery->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('no_hp', 'like', "%{$s}%")
                  ->orWhere('id_pemesanan', 'like', "%{$s}%");
            });
        }

        $ordersNeedingAction = $ordersNeedingActionQuery
            ->latest('id_pemesanan')
            ->get();

        $recentOrdersQuery = Pemesanan::with(['produk', 'bahan', 'ukuran']);

        if (!empty($this->search)) {
            $s = trim($this->search);
            $recentOrdersQuery->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('no_hp', 'like', "%{$s}%")
                  ->orWhere('id_pemesanan', 'like', "%{$s}%");
            });
        }

        $recentOrders = $recentOrdersQuery
            ->latest('id_pemesanan')
            ->take(10)
            ->get();

        $productOverview = [
            'total_products' => $totalProductsCount,
            'models_3d_linked' => Produk::whereNotNull('file_model_3d')->where('file_model_3d', '!=', '')->count(),
        ];

        return view('livewire.admin.dashboard', compact(
            'summary',
            'ordersNeedingAction',
            'recentOrders',
            'productOverview'
        ));
    }
}
