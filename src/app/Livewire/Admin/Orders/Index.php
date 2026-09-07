<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Pemesanan;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public string $paymentFilter = 'all'; // all, belum_bayar, sudah_dp, lunas
    public string $statusFilter = 'all'; // all, waiting, agreed
    public ?string $feedbackMessage = null;
    public bool $feedbackError = false;

    // Quick set price modal
    public ?int $quickOrderId = null;
    public string $quickOrderNumber = '';
    public string $quickCustomerName = '';
    public string $quickPrice = '';

    public function filterPayment(string $payment)
    {
        $this->paymentFilter = $payment;
    }

    public function filterStatus(string $status)
    {
        $this->statusFilter = $status;
    }

    public function setPaymentStatus(int $id, string $status)
    {
        if (!in_array($status, ['belum_bayar', 'sudah_dp', 'lunas'])) {
            return;
        }

        $order = Pemesanan::findOrFail($id);
        $order->status_pembayaran = $status;
        $order->save();

        $label = match ($status) {
            'sudah_dp' => 'Sudah DP',
            'lunas' => 'Sudah Lunas',
            default => 'Belum Bayar',
        };

        $this->feedbackError = false;
        $this->feedbackMessage = 'Status pembayaran pesanan #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) . ' diubah menjadi "' . $label . '".';
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->paymentFilter = 'all';
        $this->statusFilter = 'all';
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

    public function markAsCompleted(int $id)
    {
        $order = Pemesanan::findOrFail($id);

        if (!$order->isLunas()) {
            $this->feedbackError = true;
            $this->feedbackMessage = 'Pesanan #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) . ' tidak bisa dipindahkan ke Pesanan Selesai karena pembayaran belum lunas.';
            return;
        }

        $order->status = 'selesai';
        $order->save();

        $this->feedbackError = false;
        $this->feedbackMessage = 'Pesanan #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) . ' berhasil dipindahkan ke Pesanan Selesai.';
    }

    public function dismissFeedback()
    {
        $this->feedbackMessage = null;
    }

    public function render()
    {
        $query = Pemesanan::masuk()->with(['produk.kategori', 'bahan', 'ukuran'])->latest('id_pemesanan');

        if ($this->paymentFilter === 'belum_bayar') {
            $query->where(function ($q) {
                $q->whereNull('status_pembayaran')->orWhere('status_pembayaran', 'belum_bayar');
            });
        } elseif ($this->paymentFilter === 'sudah_dp') {
            $query->where('status_pembayaran', 'sudah_dp');
        } elseif ($this->paymentFilter === 'lunas') {
            $query->where('status_pembayaran', 'lunas');
        }

        if ($this->statusFilter === 'waiting') {
            $query->whereNull('total_harga');
        } elseif ($this->statusFilter === 'agreed') {
            $query->whereNotNull('total_harga');
        }

        if (!empty($this->search)) {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'ilike', "%{$s}%")
                  ->orWhereHas('produk', function ($pq) use ($s) {
                      $pq->where('nama_produk', 'ilike', "%{$s}%");
                  });

                // Support formatted Order IDs: #ORD-0001, ORD-0001, ord-0001, 0001, 1
                if (preg_match('/^#?ord-?0*(\d+)$/i', $s, $matches)) {
                    $q->orWhere('id_pemesanan', (int) $matches[1]);
                } elseif (ctype_digit($s)) {
                    $q->orWhere('id_pemesanan', (int) $s);
                }

                // Phone search: only check if input looks like a phone number (>=4 digits or starts with 08/+62/62)
                $cleanDigits = preg_replace('/\D/', '', $s);
                if (strlen($cleanDigits) >= 4 || str_starts_with($s, '08') || str_starts_with($s, '+62') || str_starts_with($s, '62')) {
                    $q->orWhere('no_hp', 'like', "%{$cleanDigits}%");
                }
            });
        }

        $orders = $query->get();

        $counts = [
            'all' => Pemesanan::masuk()->count(),
            'belum_bayar' => Pemesanan::masuk()->where(function ($q) {
                $q->whereNull('status_pembayaran')->orWhere('status_pembayaran', 'belum_bayar');
            })->count(),
            'sudah_dp' => Pemesanan::masuk()->where('status_pembayaran', 'sudah_dp')->count(),
            'lunas' => Pemesanan::masuk()->where('status_pembayaran', 'lunas')->count(),
        ];

        return view('livewire.admin.orders.index', compact('orders', 'counts'));
    }
}
