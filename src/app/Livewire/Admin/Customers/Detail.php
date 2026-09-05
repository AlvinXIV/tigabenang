<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Pemesanan;
use Livewire\Component;

class Detail extends Component
{
    public int $customerId;
    public string $orderSearch = '';

    public function mount(int $customerId)
    {
        $this->customerId = $customerId;
    }

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

        $customer = collect($customerList)->firstWhere('id', $this->customerId);

        if (!$customer) {
            abort(404, 'Pelanggan tidak ditemukan.');
        }

        $orders = $customer['orders'];
        if (!empty($this->orderSearch)) {
            $s = strtolower(trim($this->orderSearch));
            $orders = $orders->filter(function ($ord) use ($s) {
                return str_contains(strtolower((string)$ord->id_pemesanan), $s) ||
                       str_contains(strtolower($ord->produk->nama_produk ?? ''), $s);
            });
        }

        return view('livewire.admin.customers.detail', compact('customer', 'orders'));
    }
}
