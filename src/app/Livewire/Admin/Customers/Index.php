<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Pemesanan;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public string $sortBy = 'orders'; // 'orders', 'spent', 'recent'

    public function render()
    {
        $allOrders = Pemesanan::with(['produk', 'bahan', 'ukuran'])->latest('id_pemesanan')->get();

        $grouped = $allOrders->groupBy(function ($item) {
            return $item->no_hp ?: $item->nama;
        });

        $customerList = [];
        $idCounter = 1;

        foreach ($grouped as $key => $orders) {
            $first = $orders->first();
            $customerList[] = [
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

        $collection = collect($customerList);

        if (!empty($this->search)) {
            $s = strtolower(trim($this->search));
            $collection = $collection->filter(function ($item) use ($s) {
                return str_contains(strtolower($item['name']), $s) ||
                       str_contains(strtolower($item['phone'] ?? ''), $s) ||
                       str_contains(strtolower($item['address'] ?? ''), $s);
            });
        }

        if ($this->sortBy === 'spent') {
            $customers = $collection->sortByDesc('total_spent')->values();
        } elseif ($this->sortBy === 'recent') {
            $customers = $collection->sortByDesc('last_order_date')->values();
        } else {
            $customers = $collection->sortByDesc('total_orders')->values();
        }

        $totalCustomers = count($customerList);

        return view('livewire.admin.customers.index', compact('customers', 'totalCustomers'));
    }
}
