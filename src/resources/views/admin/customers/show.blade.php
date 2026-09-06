@extends('layouts.admin')

@section('title', 'Pelanggan: ' . $customer['name'])

@section('content')
    <livewire:admin.customers.detail :customerId="$customer['id']" />
@endsection
