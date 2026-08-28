@extends('layouts.customer')

@section('title', 'Collection')
@section('description', 'Browse Clothiq custom garments across every available category.')

@section('content')

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="border-b border-border bg-primary">
        <div class="mx-auto max-w-7xl px-5 py-10 lg:px-8 lg:py-14">
            <span class="section-badge text-accent [&::before]:bg-accent mb-5">Catalog</span>
            <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl">Collection</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/70">
                Browse every available garment. Filter by category, then open a piece to request production.
            </p>
        </div>
    </section>

    <section class="px-5 py-8 lg:px-8 lg:py-10">
        <div class="catalog-shell">

            {{-- ── Category Filter ─────────────────── --}}
            <div class="flex gap-2 overflow-x-auto pb-2" role="navigation" aria-label="Category filter">
                <a
                    href="{{ route('collection.index') }}"
                    class="shrink-0 rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.1em] transition-colors {{ $activeCategory ? 'border border-border text-text-muted hover:text-primary hover:border-primary' : 'bg-primary text-white' }}"
                    style="display:inline-flex;align-items:center;justify-content:center;min-height:2.5rem;padding:0.5rem 1rem;border:1.5px solid {{ $activeCategory ? '#011F7B' : '#011F7B' }};border-radius:9999px;background:{{ $activeCategory ? '#FFFFFF' : '#011F7B' }};color:{{ $activeCategory ? '#011F7B' : '#FFFFFF' }};font-size:0.75rem;font-weight:800;letter-spacing:0.06em;text-decoration:none;"
                >
                    All
                </a>
                @foreach ($categories as $kategori)
                    @php $slug = \Illuminate\Support\Str::slug($kategori->nama_kategori); @endphp
                    <a
                        href="{{ route('collection.index', ['category' => $slug]) }}"
                        class="shrink-0 rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.1em] transition-colors {{ $activeCategory?->id_kategori === $kategori->id_kategori ? 'bg-primary text-white' : 'border border-border text-text-muted hover:text-primary hover:border-primary' }}"
                        style="display:inline-flex;align-items:center;justify-content:center;min-height:2.5rem;padding:0.5rem 1rem;border:1.5px solid #011F7B;border-radius:9999px;background:{{ $activeCategory?->id_kategori === $kategori->id_kategori ? '#011F7B' : '#FFFFFF' }};color:{{ $activeCategory?->id_kategori === $kategori->id_kategori ? '#FFFFFF' : '#011F7B' }};font-size:0.75rem;font-weight:800;letter-spacing:0.06em;text-decoration:none;"
                    >
                        {{ $kategori->nama_kategori }}
                    </a>
                @endforeach
            </div>

            {{-- ── Product Grid ────────────────────── --}}
            @if ($products->isNotEmpty())
                <div class="catalog-grid catalog-grid--4 mt-8">
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
