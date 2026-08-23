@extends('layouts.customer')

@section('title', $product->nama_produk)
@section('description', $product->kategori?->nama_kategori.' — custom garment by FitVendor')

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::productImageUrl($product);
    $hasModel = filled($product->file_model_3d);
@endphp

@section('content')
    <section class="border-b border-line">
        <div class="mx-auto grid max-w-7xl items-start gap-8 px-5 py-10 lg:grid-cols-12 lg:px-8 lg:py-12">
            <div class="bg-ivory-deep lg:col-span-5">
                <div class="image-frame">
                    @if ($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $product->nama_produk }}" width="600" height="800" fetchpriority="high" decoding="async">
                    @else
                        <div class="flex h-full w-full flex-col items-center justify-center p-6 text-center">
                            <p class="text-[11px] uppercase tracking-[0.28em] text-muted">{{ $product->kategori?->nama_kategori ?? 'Garment' }}</p>
                            <p class="mt-3 font-serif text-2xl text-charcoal/80">{{ $product->nama_produk }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col justify-center lg:col-span-7 lg:pl-4">
                <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">{{ $product->kategori?->nama_kategori }}</p>
                <h1 class="mt-4 font-serif text-4xl leading-tight text-charcoal md:text-5xl">{{ $product->nama_produk }}</h1>
                <p class="mt-5 font-serif text-2xl text-ink"><x-price :amount="$product->harga" /></p>

                @if (filled($product->deskripsi ?? null))
                    <p class="mt-6 text-sm leading-relaxed text-muted">{{ $product->deskripsi }}</p>
                @else
                    <p class="mt-6 text-sm leading-relaxed text-muted">
                        A made-to-order garment from the {{ $product->kategori?->nama_kategori ?? 'FitVendor' }} line. Request production with your preferred materials and size breakdown.
                    </p>
                @endif

                <div class="mt-10 flex flex-col gap-3">
                    <a href="{{ route('order.create', ['product' => $product->id_produk]) }}" class="inline-flex items-center justify-center bg-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-ivory hover:bg-terracotta">
                        Request This Product
                    </a>
                    @if ($hasModel)
                        <a href="{{ route('virtual-fitting', ['product' => $product->id_produk]) }}" class="inline-flex items-center justify-center border border-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-charcoal hover:border-terracotta hover:text-terracotta">
                            View in 3D / Try Virtual Fitting
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-line px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-2">
            <div>
                <h2 class="font-serif text-3xl text-charcoal">Materials</h2>
                <p class="mt-2 text-sm text-muted">Available through this garment’s material pairing.</p>
                @if ($product->bahan->isNotEmpty())
                    <ul class="mt-8 divide-y divide-line border-y border-line">
                        @foreach ($product->bahan as $bahan)
                            <li class="flex items-center justify-between py-4">
                                <span class="font-serif text-xl">{{ $bahan->nama_bahan }}</span>
                                <span class="text-[10px] uppercase tracking-[0.2em] text-muted">Bahan</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-8 text-sm text-muted">No materials are paired with this garment yet.</p>
                @endif
            </div>

            <div>
                <h2 class="font-serif text-3xl text-charcoal">Available Sizes</h2>
                <p class="mt-2 text-sm text-muted">Sizes follow the garment category, not a separate product-size table.</p>
                @if ($sizes->isNotEmpty())
                    <div class="mt-8 flex flex-wrap gap-2">
                        @foreach ($sizes as $ukuran)
                            <span class="min-w-16 border border-line px-4 py-3 text-center text-sm tracking-[0.12em]">
                                {{ $ukuran->nama_ukuran }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="mt-8 text-sm text-muted">Sizes for this category have not been defined yet.</p>
                @endif
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="px-5 py-16 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <h2 class="font-serif text-3xl text-charcoal">More from this category</h2>
                <div class="catalog-grid catalog-grid--4 mt-8">
                    @foreach ($related as $produk)
                        <x-collection-product-card :produk="$produk" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
