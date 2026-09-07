<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Pemesanan;
use Livewire\Component;

class Completed extends Component
{
    public string $search = '';
    public string $paymentFilter = 'all'; // all, belum_bayar, sudah_dp, lunas
    public ?string $feedbackMessage = null;

    public function filterPayment(string $payment)
    {
        $this->paymentFilter = $payment;
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

        $this->feedbackMessage = 'Status pembayaran pesanan #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) . ' diubah menjadi "' . $label . '".';
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->paymentFilter = 'all';
    }

    public function markAsActive(int $id)
    {
        $order = Pemesanan::findOrFail($id);
        $order->status = 'masuk';
        $order->save();

        $this->feedbackMessage = 'Pesanan #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) . ' berhasil dikembalikan ke Pesanan Masuk.';
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
        $query = Pemesanan::selesai()->with(['produk.kategori', 'bahan', 'ukuran'])->latest('id_pemesanan');

        if ($this->paymentFilter === 'belum_bayar') {
            $query->where(function ($q) {
                $q->whereNull('status_pembayaran')->orWhere('status_pembayaran', 'belum_bayar');
            });
        } elseif ($this->paymentFilter === 'sudah_dp') {
            $query->where('status_pembayaran', 'sudah_dp');
        } elseif ($this->paymentFilter === 'lunas') {
            $query->where('status_pembayaran', 'lunas');
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

                // Phone search
                $cleanDigits = preg_replace('/\D/', '', $s);
                if (strlen($cleanDigits) >= 4 || str_starts_with($s, '08') || str_starts_with($s, '+62') || str_starts_with($s, '62')) {
                    $q->orWhere('no_hp', 'like', "%{$cleanDigits}%");
                }
            });
        }

        $orders = $query->get();

        $counts = [
            'all' => Pemesanan::selesai()->count(),
            'belum_bayar' => Pemesanan::selesai()->where(function ($q) {
                $q->whereNull('status_pembayaran')->orWhere('status_pembayaran', 'belum_bayar');
            })->count(),
            'sudah_dp' => Pemesanan::selesai()->where('status_pembayaran', 'sudah_dp')->count(),
            'lunas' => Pemesanan::selesai()->where('status_pembayaran', 'lunas')->count(),
        ];

        return view('livewire.admin.orders.completed', compact('orders', 'counts'));
    }
}
