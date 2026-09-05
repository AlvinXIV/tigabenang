<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Pemesanan;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public string $statusFilter = 'all'; // all, waiting, agreed
    public ?string $feedbackMessage = null;

    // Quick set price modal
    public ?int $quickOrderId = null;
    public string $quickOrderNumber = '';
    public string $quickCustomerName = '';
    public string $quickPrice = '';

    public function filterStatus(string $status)
    {
        $this->statusFilter = $status;
    }

    public function openQuickPrice(int $id)
    {
        $order = Pemesanan::findOrFail($id);
        $this->quickOrderId = $order->id_pemesanan;
        $this->quickOrderNumber = '#ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT);
        $this->quickCustomerName = $order->nama;
        $this->quickPrice = (string) ($order->total_harga ?? '');
    }

    public function saveQuickPrice()
    {
        $this->validate([
            'quickPrice' => 'required|numeric|min:0',
        ]);

        $order = Pemesanan::findOrFail($this->quickOrderId);
        $order->total_harga = $this->quickPrice;
        $order->save();

        $this->quickOrderId = null;
        $this->quickPrice = '';
        $this->feedbackMessage = 'Harga disepakati pesanan ' . $this->quickOrderNumber . ' berhasil ditetapkan!';
    }

    public function cancelQuickPrice()
    {
        $this->quickOrderId = null;
        $this->quickPrice = '';
    }

    public function deleteOrder(int $id)
    {
        $order = Pemesanan::findOrFail($id);
        $order->bahan()->detach();
        $order->ukuran()->detach();
        $order->delete();

        $this->feedbackMessage = 'Pesanan berhasil dihapus.';
    }

    public function dismissFeedback()
    {
        $this->feedbackMessage = null;
    }

    public function render()
    {
        $query = Pemesanan::with(['produk', 'bahan', 'ukuran'])->latest('id_pemesanan');

        if ($this->statusFilter === 'waiting') {
            $query->whereNull('total_harga');
        } elseif ($this->statusFilter === 'agreed') {
            $query->whereNotNull('total_harga');
        }

        if (!empty($this->search)) {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('no_hp', 'like', "%{$s}%")
                  ->orWhere('id_pemesanan', 'like', "%{$s}%")
                  ->orWhereHas('produk', function ($pq) use ($s) {
                      $pq->where('nama_produk', 'like', "%{$s}%");
                  });
            });
        }

        $orders = $query->get();

        $counts = [
            'all' => Pemesanan::count(),
            'waiting' => Pemesanan::whereNull('total_harga')->count(),
            'agreed' => Pemesanan::whereNotNull('total_harga')->count(),
        ];

        return view('livewire.admin.orders.index', compact('orders', 'counts'));
    }
}
