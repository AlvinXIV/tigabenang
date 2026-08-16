<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Summary Cards Data (Based strictly on ERD entities)
        $summary = [
            'total_orders' => [
                'count' => 156,
                'subtitle' => 'This month',
            ],
            'pending_orders' => [
                'count' => 18,
                'subtitle' => 'Awaiting review',
            ],
            'waiting_price' => [
                'count' => 7,
                'subtitle' => 'Price needs finalized',
            ],
            'low_stock' => [
                'count' => 5,
                'subtitle' => 'Below reorder level',
            ],
        ];

        // 2. Orders Needing Action (Orders requiring admin attention/pricing/review)
        $ordersNeedingAction = [
            [
                'id' => 1,
                'order_code' => '#FV-1024',
                'customer_name' => 'Gibral',
                'product_name' => 'Custom Hoodie',
                'status' => 'Waiting Price',
                'action_label' => 'Set Price',
                'route' => route('admin.pesanan.show', 1),
            ],
            [
                'id' => 2,
                'order_code' => '#FV-1023',
                'customer_name' => 'Polman Bandung',
                'product_name' => 'Custom Jersey',
                'status' => 'New',
                'action_label' => 'Review',
                'route' => route('admin.pesanan.show', 2),
            ],
            [
                'id' => 3,
                'order_code' => '#FV-1022',
                'customer_name' => 'Karsa Apparel',
                'product_name' => 'Oversized T-Shirt',
                'status' => 'New',
                'action_label' => 'Review',
                'route' => route('admin.pesanan.show', 3),
            ],
            [
                'id' => 4,
                'order_code' => '#FV-1021',
                'customer_name' => 'Bandung Community',
                'product_name' => 'Custom Jacket',
                'status' => 'Confirmed',
                'action_label' => 'View',
                'route' => route('admin.pesanan.show', 4),
            ],
        ];

        // 3. Material Alerts (Internal inventory stock vs reorder level)
        $materialAlerts = [
            [
                'id' => 1,
                'name' => 'Baby Terry',
                'available_stock' => '40 m',
                'reorder_level' => '200 m',
                'is_low_stock' => true,
            ],
            [
                'id' => 2,
                'name' => 'Cotton Fleece',
                'available_stock' => '1,250 m',
                'reorder_level' => '500 m',
                'is_low_stock' => false,
            ],
            [
                'id' => 3,
                'name' => 'Taslan Milky',
                'available_stock' => '85 m',
                'reorder_level' => '150 m',
                'is_low_stock' => true,
            ],
        ];

        // 4. Recent Orders (Latest orders with finalized or waiting price)
        $recentOrders = [
            [
                'id' => 5,
                'order_code' => '#FV-1020',
                'customer_name' => 'StudioX',
                'product_name' => 'Tech Joggers',
                'final_price' => 'Rp 450.000',
                'is_waiting_price' => false,
                'status' => 'Shipped',
                'date' => '12 Agu',
            ],
            [
                'id' => 6,
                'order_code' => '#FV-1019',
                'customer_name' => 'Urban Wear',
                'product_name' => 'Graphic Tee',
                'final_price' => 'Rp 120.000',
                'is_waiting_price' => false,
                'status' => 'Processing',
                'date' => '11 Agu',
            ],
            [
                'id' => 7,
                'order_code' => '#FV-1018',
                'customer_name' => 'Bandung Community',
                'product_name' => 'Custom Jacket',
                'final_price' => 'Waiting Price',
                'is_waiting_price' => true,
                'status' => 'Confirmed',
                'date' => '10 Agu',
            ],
        ];

        // 5. Product Overview
        $productOverview = [
            'total_products' => 142,
            'models_3d_linked' => 98,
            'incomplete_products' => 5,
        ];

        return view('admin.dashboard.index', compact(
            'summary',
            'ordersNeedingAction',
            'materialAlerts',
            'recentOrders',
            'productOverview'
        ));
    }
}
