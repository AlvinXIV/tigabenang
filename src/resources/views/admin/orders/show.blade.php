@extends('layouts.admin')

@section('title', 'Pesanan #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT))

@section('content')
    <livewire:admin.orders.detail :orderId="$order->id_pemesanan" />
@endsection
