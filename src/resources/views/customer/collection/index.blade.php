@extends('layouts.customer')

@section('title', 'Collection')
@section('description', 'Browse FitVendor custom garments across every available category.')

@section('content')
    <section class="border-b border-line px-5 py-10 lg:px-8 lg:py-12">
        <div class="mx-auto max-w-7xl">
            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">Catalog</p>
            <h1 class="mt-3 font-serif text-5xl text-charcoal md:text-6xl">Collection</h1>
            <p class="mt-4 max-w-xl text-sm leading-relaxed text-muted">
                Browse every available garment. Filter by category, then open a piece to request production.
            </p>
        </div>
    </section>

    <section class="px-5 py-8 lg:px-8">
        <div class="catalog-shell">
            <div class="flex gap-2 overflow-x-auto pb-2" role="navigation" aria-label="Category filter">
                <a
                    href="{{ route('collection.index') }}"
                    class="shrink-0 border px-4 py-2 text-[11px] uppercase tracking-[0.18em] {{ $activeCategory ? 'border-line text-muted hover:text-charcoal' : 'border-charcoal bg-charcoal text-ivory' }}"
                >
                    All
                </a>
                @foreach ($categories as $kategori)
                    @php $slug = \Illuminate\Support\Str::slug($kategori->nama_kategori); @endphp
                    <a
                        href="{{ route('collection.index', ['category' => $slug]) }}"
                        class="shrink-0 border px-4 py-2 text-[11px] uppercase tracking-[0.18em] {{ $activeCategory?->id_kategori === $kategori->id_kategori ? 'border-charcoal bg-charcoal text-ivory' : 'border-line text-muted hover:border-charcoal hover:text-charcoal' }}"
                    >
                        {{ $kategori->nama_kategori }}
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
                <div class="mt-12">
                    <x-empty-state
                        title="No garments in this view"
                        message="Try another category, or check back when new pieces are added to the collection."
                    >
                        <a href="{{ route('collection.index') }}" class="mt-6 inline-block text-[11px] uppercase tracking-[0.2em] text-terracotta">View all</a>
                    </x-empty-state>
                </div>
            @endif
        </div>
    </section>
@endsection
