@extends('layouts.customer')

@section('title', $product->nama_produk)
@section('description', $product->kategori?->nama_kategori.' — custom garment by FitVendor')

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::imageUrl($product->gambar);
    $hasModel = filled($product->file_model_3d);
@endphp

@section('content')
    <section class="border-b border-line">
        <div class="mx-auto grid max-w-7xl lg:grid-cols-12">
            <div class="relative min-h-[480px] bg-ivory-deep lg:col-span-7">
                @if ($imageUrl)
                    <img src="{{ $imageUrl }}" alt="{{ $product->nama_produk }}" width="1200" height="1500" class="h-full w-full object-cover" fetchpriority="high" decoding="async">
                @else
                    <div class="flex h-full min-h-[480px] flex-col justify-between p-8 lg:p-12">
                        <p class="text-[11px] uppercase tracking-[0.28em] text-muted">{{ $product->kategori?->nama_kategori ?? 'Garment' }}</p>
                        <p class="font-serif text-5xl text-charcoal/80 lg:text-7xl">{{ $product->nama_produk }}</p>
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Product image placeholder</p>
                    </div>
                @endif
            </div>

            <div class="flex flex-col justify-center px-5 py-12 lg:col-span-5 lg:px-10 lg:py-16">
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
                <div class="mt-10 grid gap-8 sm:grid-cols-3">
                    @foreach ($related as $produk)
                        <x-product-card :produk="$produk" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
