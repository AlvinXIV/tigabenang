@extends('layouts.admin')

@section('title', 'Model Pakaian 3D')

@section('content')
    @livewire(\App\Livewire\Admin\Models3D\Index::class)
@endsection
