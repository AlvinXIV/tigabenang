<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Pemesanan;
use Livewire\Component;

class Detail extends Component
{
    public int $orderId;
    public string $total_harga = '';
    public ?string $feedbackMessage = null;

    // Edit customer info state
    public bool $editCustomerOpen = false;
    public string $edit_nama = '';
    public string $edit_no_hp = '';
    public string $edit_alamat = '';
    public string $edit_notes = '';

    public function mount(int $orderId)
    {
        $this->orderId = $orderId;
        $order = Pemesanan::findOrFail($orderId);
        $this->total_harga = (string) ($order->total_harga ?? '');
        $this->edit_nama = $order->nama;
        $this->edit_no_hp = $order->no_hp ?? '';
        $this->edit_alamat = $order->alamat ?? '';
        $this->edit_notes = $order->notes ?? '';
    }

    public function updatePrice()
    {
        $this->validate([
            'total_harga' => 'required|numeric|min:0',
        ]);

        $order = Pemesanan::findOrFail($this->orderId);
        $order->total_harga = $this->total_harga;
        $order->save();

        $this->feedbackMessage = 'Kesepakatan harga berhasil diperbarui!';
    }

    public function openEditCustomer()
    {
        $order = Pemesanan::findOrFail($this->orderId);
        $this->edit_nama = $order->nama;
        $this->edit_no_hp = $order->no_hp ?? '';
        $this->edit_alamat = $order->alamat ?? '';
        $this->edit_notes = $order->notes ?? '';
        $this->editCustomerOpen = true;
    }

    public function saveCustomer()
    {
        $this->validate([
            'edit_nama' => 'required|string|max:255',
            'edit_no_hp' => 'required|string|max:50',
            'edit_alamat' => 'required|string',
            'edit_notes' => 'nullable|string',
        ]);

        $order = Pemesanan::findOrFail($this->orderId);
        $order->update([
            'nama' => trim($this->edit_nama),
            'no_hp' => trim($this->edit_no_hp),
            'alamat' => trim($this->edit_alamat),
            'notes' => trim($this->edit_notes) ?: null,
        ]);

        $this->editCustomerOpen = false;
        $this->feedbackMessage = 'Informasi pelanggan berhasil diperbarui!';
    }

    public function dismissFeedback()
    {
        $this->feedbackMessage = null;
    }

    public function render()
    {
        $order = Pemesanan::with(['produk.kategori', 'bahan', 'ukuran'])->findOrFail($this->orderId);

        return view('livewire.admin.orders.detail', compact('order'));
    }
}
