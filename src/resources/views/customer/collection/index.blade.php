@extends('layouts.customer')

@section('title', 'Collection')
@section('description', 'Browse Clothiq custom garments across every available category.')

@section('content')

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="border-b border-border bg-primary" style="background-color:#172A39;border-color:#DCD6D0;">
        <div class="mx-auto max-w-7xl px-5 py-12 lg:px-8 lg:py-16">
            <span class="section-badge mb-4" style="color:#FC563C;">
                <span style="width:1.5rem;height:3px;background:#FC563C;border-radius:2px;display:inline-block;"></span>
                Catalog
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl">Collection</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/75">
                Browse every available garment. Filter by category, then open a piece to request production.
            </p>
        </div>
    </section>

    <section class="px-5 py-10 lg:px-8 lg:py-12" style="background:#FFFFFF;">
        <div class="catalog-shell">

            {{-- ── Category Filter ─────────────────── --}}
            <div class="flex gap-2.5 overflow-x-auto pb-3" role="navigation" aria-label="Category filter">
                <a
                    href="{{ route('collection.index') }}"
                    class="shrink-0 rounded-full px-5 py-2.5 text-xs font-bold uppercase tracking-[0.1em] transition-all"
                    style="display:inline-flex;align-items:center;justify-content:center;min-height:2.625rem;border:1.5px solid {{ $activeCategory ? '#DCD6D0' : '#172A39' }};border-radius:9999px;background:{{ $activeCategory ? '#FFFFFF' : '#172A39' }};color:{{ $activeCategory ? '#172A39' : '#FFFFFF' }};font-size:0.775rem;font-weight:800;letter-spacing:0.06em;text-decoration:none;box-shadow:{{ $activeCategory ? 'none' : '0 4px 12px rgba(23,42,57,0.2)' }};"
                >
                    All
                </a>
                @foreach ($categories as $kategori)
                    @php
                        $slug = \Illuminate\Support\Str::slug($kategori->nama_kategori);
                        $isActive = $activeCategory?->id_kategori === $kategori->id_kategori;
                    @endphp
                    <a
                        href="{{ route('collection.index', ['category' => $slug]) }}"
                        class="shrink-0 rounded-full px-5 py-2.5 text-xs font-bold uppercase tracking-[0.1em] transition-all"
                        style="display:inline-flex;align-items:center;justify-content:center;min-height:2.625rem;border:1.5px solid {{ $isActive ? '#172A39' : '#DCD6D0' }};border-radius:9999px;background:{{ $isActive ? '#172A39' : '#FFFFFF' }};color:{{ $isActive ? '#FFFFFF' : '#172A39' }};font-size:0.775rem;font-weight:800;letter-spacing:0.06em;text-decoration:none;box-shadow:{{ $isActive ? '0 4px 12px rgba(23,42,57,0.2)' : 'none' }};"
                        onmouseover="if(!{{ $isActive ? 1 : 0 }}){this.style.borderColor='#FC563C';this.style.color='#FC563C';}"
                        onmouseout="if(!{{ $isActive ? 1 : 0 }}){this.style.borderColor='#DCD6D0';this.style.color='#172A39';}"
                    >
                        {{ $kategori->nama_kategori }}
                    </a>
                @endforeach
            </div>

            {{-- ── Product Grid ────────────────────── --}}
            @if ($products->isNotEmpty())
                <div class="catalog-grid catalog-grid--4 mt-10">
                    @foreach ($products as $index => $produk)
                        <x-collection-product-card :produk="$produk" :lazy="$index > 3" />
                    @endforeach
                </div>
            @else
                <div class="mt-12">
                    <x-empty-state
                        title="No garments in this view"
                        message="Try another category, or check back when new pieces are added to the collection."
                    >
                        <a href="{{ route('collection.index') }}" class="btn-outline mt-5 text-xs">View all</a>
                    </x-empty-state>
                </div>
            @endif
        </div>
    </section>

@endsection
