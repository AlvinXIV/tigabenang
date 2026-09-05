@extends('layouts.customer')

@section('title', 'Koleksi')
@section('description', 'Lihat semua pakaian custom FitVendor. Filter berdasarkan kategori, lalu buka produk untuk memesan.')

@section('content')

    <section class="fv-page-hero">
        <div class="mx-auto max-w-[1200px] px-5 py-10 lg:px-8 lg:py-12">
            <span class="section-badge mb-3">Katalog</span>
            <h1 class="text-3xl font-bold tracking-tight md:text-4xl">Koleksi</h1>
            <p class="mt-2.5 max-w-xl text-sm leading-relaxed">
                Semua model yang tersedia. Filter kategori, lalu buka produk untuk mengirim permintaan produksi.
            </p>
        </div>
    </section>

    <section class="px-5 py-10 lg:px-8 lg:py-12">
        <div class="catalog-shell">
            <div class="flex gap-2 overflow-x-auto pb-2" role="navigation" aria-label="Filter kategori">
                <a
                    href="{{ route('collection.index') }}"
                    class="fv-chip {{ $activeCategory ? '' : 'is-active' }}"
                >
                    Semua
                </a>
                @foreach ($categories as $kategori)
                    @php
                        $slug = \Illuminate\Support\Str::slug($kategori->nama_kategori);
                        $isActive = $activeCategory?->id_kategori === $kategori->id_kategori;
                    @endphp
                    <a
                        href="{{ route('collection.index', ['category' => $slug]) }}"
                        class="fv-chip {{ $isActive ? 'is-active' : '' }}"
                    >
                        {{ \App\Support\CustomerCatalog::categoryLabel($kategori->nama_kategori) }}
                    </a>
                @endforeach
            </div>

            @if ($products->isNotEmpty())
                <div class="catalog-grid catalog-grid--4 mt-8">
                    @foreach ($products as $index => $produk)
                        <x-collection-product-card :produk="$produk" :lazy="$index > 3" />
                    @endforeach
                </div>
            @else
                <div class="mt-10">
                    <x-empty-state
                        title="Belum ada produk di tampilan ini"
                        message="Coba kategori lain, atau kembali lagi saat ada model baru."
                    >
                        <a href="{{ route('collection.index') }}" class="btn-outline mt-5">Lihat semua</a>
                    </x-empty-state>
                </div>
            @endif
        </div>
    </section>

@endsection
