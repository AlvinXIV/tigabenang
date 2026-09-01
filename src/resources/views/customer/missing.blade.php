@extends('layouts.customer')

@section('title', $title ?? 'Tidak ditemukan')

@section('content')
    <section class="px-5 py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-sm font-medium text-[#667085]">FitVendor</p>
            <h1 class="mt-3 text-4xl font-bold tracking-tight text-[#1C2430]">{{ $title }}</h1>
            <p class="mt-4 text-sm leading-relaxed text-[#667085]">{{ $message }}</p>
            <a href="{{ route('collection.index') }}" class="btn-primary mt-8 inline-flex">
                Kembali ke koleksi
            </a>
        </div>
    </section>
@endsection
