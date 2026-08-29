<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private function getCustomersFromDB()
    {
        $allOrders = Pemesanan::with(['produk', 'bahan', 'ukuran'])->latest('id_pemesanan')->get();
        
        $grouped = $allOrders->groupBy(function ($item) {
            return $item->no_hp ?: $item->nama;
        });

        $customers = [];
        $idCounter = 1;

        foreach ($grouped as $key => $orders) {
            $first = $orders->first();
            $customers[] = [
                'id' => $idCounter++,
                'name' => $first->nama,
                'phone' => $first->no_hp,
                'address' => $first->alamat,
                'total_orders' => $orders->count(),
                'total_spent' => $orders->sum('total_harga'),
                'last_order_date' => $orders->max('created_at'),
                'orders' => $orders,
            ];
        }

        return $customers;
    }

    public function index()
    {
        $customers = $this->getCustomersFromDB();
        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customers = $this->getCustomersFromDB();
        $customer = collect($customers)->firstWhere('id', (int)$id);

        if (!$customer) {
            abort(404, 'Pelanggan tidak ditemukan.');
        }

        return view('admin.customers.show', compact('customer'));
    }
}

