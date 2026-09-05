@extends('layouts.admin')

@section('title', 'Ubah Produk')

@section('content')
    <livewire:admin.products.product-form :id="$product->id_produk" />
@endsection
