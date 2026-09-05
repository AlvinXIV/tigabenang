@extends('layouts.customer')

@section('title', $product->nama_produk)
@section('description', $product->kategori?->nama_kategori.' - pakaian custom FitVendor')

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::productImageUrl($product);
    $hasModel = filled($product->file_model_3d);
@endphp

@section('content')

    <section class="border-b border-[#E2E5E9] bg-white">
        <div class="mx-auto grid max-w-[1200px] items-start gap-10 px-5 py-10 lg:grid-cols-12 lg:gap-12 lg:px-8 lg:py-14">
            <div class="lg:col-span-5">
                <div class="fv-media relative aspect-[3/4]">
                    @if ($imageUrl)
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $product->nama_produk }}"
                            width="600" height="800"
                            fetchpriority="high" decoding="async"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full flex-col items-center justify-center gap-2 p-8 text-center">
                            <p class="text-xs font-medium text-[#667085]">{{ $product->kategori?->nama_kategori ?? 'Produk' }}</p>
                            <p class="text-lg font-bold text-[#1C2430]">{{ $product->nama_produk }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-[14px] border border-[#E2E5E9] bg-[#F7F7F5] p-6 sm:p-8 lg:col-span-7">
                @if ($product->kategori?->nama_kategori)
                    <p class="mb-3 text-sm font-medium text-[#667085]">{{ $product->kategori->nama_kategori }}</p>
                @endif

                <h1 class="text-[clamp(1.75rem,3.5vw,2.75rem)] font-bold leading-tight tracking-tight text-[#1C2430]">
                    {{ $product->nama_produk }}
                </h1>

                <p class="mt-4 text-2xl font-bold text-[#1C2430]">
                    Estimasi mulai <x-price :amount="$product->harga" /> / pcs
                </p>

                @if (filled($product->deskripsi ?? null))
                    <p class="mt-4 text-sm leading-relaxed text-[#667085]">{{ $product->deskripsi }}</p>
                @endif

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a
                        href="{{ route('order.create', ['product' => $product->id_produk]) }}"
                        class="btn-primary product-request-action"
                    >
                        Pesan produk ini
                    </a>
                    @if ($hasModel)
                        <a href="{{ route('virtual-fitting', ['product' => $product->id_produk]) }}" class="btn-outline">
                            Lihat di fitting 3D
                        </a>
                    @endif
                </div>

                @if ($hasModel)
                    <div class="mt-6">
                        <span class="rounded-[8px] border border-[#E2E5E9] bg-white px-3 py-1.5 text-xs font-medium text-[#1C2430]">Ada pratinjau 3D</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="border-b border-[#E2E5E9] bg-[#F7F7F5] py-12">
        <div class="mx-auto grid max-w-[1200px] gap-10 px-5 lg:grid-cols-2 lg:px-8">
            <div>
                <span class="section-badge mb-2">Bahan</span>
                <h2 class="mb-1 text-xl font-bold text-[#1C2430]">Bahan tersedia</h2>
                <p class="mb-5 text-sm text-[#667085]">Bahan yang terhubung dengan produk ini.</p>
                @if ($product->bahan->isNotEmpty())
                    <ul class="m-0 list-none overflow-hidden rounded-[14px] border border-[#E2E5E9] bg-white p-0">
                        @foreach ($product->bahan as $bahan)
                            <li class="flex items-center justify-between border-b border-[#E2E5E9] px-4 py-3 last:border-b-0">
                                <span class="text-sm font-semibold text-[#1C2430]">{{ $bahan->nama_bahan }}</span>
                                <span class="rounded-[8px] border border-[#E2E5E9] bg-[#F7F7F5] px-2 py-1 text-xs font-medium text-[#667085]">Bahan</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-[#667085]">Belum ada bahan yang dipasangkan ke produk ini.</p>
                @endif
            </div>

            <div>
                <span class="section-badge mb-2">Ukuran</span>
                <h2 class="mb-1 text-xl font-bold text-[#1C2430]">Ukuran tersedia</h2>
                <p class="mb-5 text-sm text-[#667085]">Mengikuti size chart kategori produk.</p>
                @if ($sizes->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($sizes as $ukuran)
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-[#E2E5E9] bg-white text-sm font-bold text-[#1C2430]">
                                {{ $ukuran->nama_ukuran }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-[#667085]">Ukuran untuk kategori ini belum diatur.</p>
                @endif
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="bg-white py-12">
            <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
                <span class="section-badge mb-2">Dari kategori yang sama</span>
                <h2 class="mb-6 text-xl font-bold text-[#1C2430]">Produk serupa</h2>
                <div class="catalog-grid catalog-grid--4">
                    @foreach ($related as $produk)
                        <x-collection-product-card :produk="$produk" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
