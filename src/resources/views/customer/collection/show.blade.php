@extends('layouts.customer')

@section('title', $product->nama_produk)
@section('description', $product->kategori?->nama_kategori.' — custom garment by Clothiq')

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::productImageUrl($product);
    $hasModel = filled($product->file_model_3d);
@endphp

@section('content')

    {{-- ── Product Hero ─────────────────────────── --}}
    <section style="border-bottom:1px solid #DCD6D0;background:#FFFFFF;">
        <div class="mx-auto grid max-w-7xl items-start gap-10 px-5 py-12 lg:grid-cols-12 lg:gap-14 lg:px-8 lg:py-16">

            {{-- Image --}}
            <div class="lg:col-span-5">
                <div style="aspect-ratio:3/4;border-radius:1.25rem;overflow:hidden;background:#FAF8F5;box-shadow:0 8px 30px rgba(23,42,57,0.08);border:1px solid #DCD6D0;position:relative;">
                    @if ($imageUrl)
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $product->nama_produk }}"
                            width="600" height="800"
                            fetchpriority="high" decoding="async"
                            style="width:100%;height:100%;object-fit:cover;display:block;"
                        >
                    @else
                        <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.75rem;padding:2rem;text-align:center;">
                            <div style="width:4.5rem;height:4.5rem;background:#EAEFF4;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#172A39" stroke-width="1.5" opacity="0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p style="font-size:0.75rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#6E7575;">{{ $product->kategori?->nama_kategori ?? 'Garment' }}</p>
                            <p style="font-size:1.125rem;font-weight:800;color:#172A39;">{{ $product->nama_produk }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Details --}}
            <div class="flex flex-col justify-center rounded-2xl border border-border bg-white p-7 shadow-[0_12px_36px_rgba(23,42,57,0.06)] sm:p-9 lg:col-span-7 lg:p-10" style="border-color:#DCD6D0;">

                @if ($product->kategori?->nama_kategori)
                    <div style="display:inline-flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
                        <span style="width:1.5rem;height:3px;background:#172A39;border-radius:2px;display:inline-block;"></span>
                        <span style="font-size:0.75rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:#172A39;">{{ $product->kategori->nama_kategori }}</span>
                    </div>
                @endif

                <h1 style="font-size:clamp(2rem,4vw,3.25rem);font-weight:900;color:#172A39;letter-spacing:-0.03em;line-height:1.1;">
                    {{ $product->nama_produk }}
                </h1>

                <p style="margin-top:1rem;font-size:1.75rem;font-weight:900;color:#172A39;letter-spacing:-0.02em;">
                    <x-price :amount="$product->harga" />
                </p>

                @if (filled($product->deskripsi ?? null))
                    <p style="margin-top:1.25rem;font-size:0.9375rem;line-height:1.75;color:#6E7575;">{{ $product->deskripsi }}</p>
                @else
                    <p style="margin-top:1.25rem;font-size:0.9375rem;line-height:1.75;color:#6E7575;">
                        A made-to-order garment from the {{ $product->kategori?->nama_kategori ?? 'Clothiq' }} line. Request production with your preferred materials and size breakdown.
                    </p>
                @endif

                {{-- Action Buttons --}}
                <div style="margin-top:2.25rem;display:flex;flex-wrap:wrap;gap:1rem;align-items:center;">
                    <a
                        href="{{ route('order.create', ['product' => $product->id_produk]) }}"
                        class="btn-primary product-request-action"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;min-height:3.25rem;padding:0.75rem 1.75rem;background:#172A39;color:#FFFFFF !important;border:2px solid #172A39;border-radius:0.75rem;font-size:0.875rem;font-weight:800;letter-spacing:0.04em;text-decoration:none;box-shadow:0 6px 18px rgba(23,42,57,0.25);transition:all 0.15s;"
                        onmouseover="this.style.background='#0E1B25';this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='#172A39';this.style.transform='translateY(0)'"
                    >
                        Request This Product
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @if ($hasModel)
                        <a
                            href="{{ route('virtual-fitting', ['product' => $product->id_produk]) }}"
                            class="btn-outline"
                            style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:3.25rem;padding:0.75rem 1.5rem;background:transparent;color:#172A39 !important;border:2px solid #172A39;border-radius:0.75rem;font-size:0.875rem;font-weight:800;letter-spacing:0.04em;text-decoration:none;transition:all 0.15s;"
                            onmouseover="this.style.background='#EAEFF4';this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.background='transparent';this.style.transform='translateY(0)'"
                        >
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.847v6.306a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            View in 3D Fitting
                        </a>
                    @endif
                </div>

                {{-- Quick Facts --}}
                <div style="margin-top:2rem;display:flex;flex-wrap:wrap;gap:0.75rem;">
                    <div style="display:inline-flex;align-items:center;gap:0.5rem;background:#FAF8F5;border:1px solid #DCD6D0;border-radius:9999px;padding:0.45rem 1rem;font-size:0.775rem;font-weight:700;color:#172A39;">
                        <svg width="14" height="14" fill="#172A39" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Made to order
                    </div>
                    <div style="display:inline-flex;align-items:center;gap:0.5rem;background:#FAF8F5;border:1px solid #DCD6D0;border-radius:9999px;padding:0.45rem 1rem;font-size:0.775rem;font-weight:700;color:#172A39;">
                        <svg width="14" height="14" fill="#172A39" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Custom sizing
                    </div>
                    @if ($hasModel)
                        <div style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(23,42,57,0.08);border:1px solid rgba(23,42,57,0.2);border-radius:9999px;padding:0.45rem 1rem;font-size:0.775rem;font-weight:800;color:#172A39;">
                            <svg width="14" height="14" fill="#172A39" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/></svg>
                            3D Preview Available
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ── Materials & Sizes ────────────────────── --}}
    <section style="background:#FAF8F5;border-bottom:1px solid #DCD6D0;padding:4rem 0;">
        <div class="mx-auto grid max-w-7xl gap-12 px-5 lg:grid-cols-2 lg:px-8">

            {{-- Materials --}}
            <div>
                <span class="section-badge" style="margin-bottom:0.875rem;">Materials</span>
                <h2 style="font-size:1.5rem;font-weight:900;color:#172A39;margin-bottom:0.375rem;">Bahan Tersedia</h2>
                <p style="font-size:0.875rem;color:#6E7575;margin-bottom:1.5rem;">Available through this garment's material pairing.</p>
                @if ($product->bahan->isNotEmpty())
                    <ul style="border:1.5px solid #DCD6D0;border-radius:1rem;overflow:hidden;background:#FFFFFF;list-style:none;padding:0;margin:0;box-shadow:0 4px 16px rgba(23,42,57,0.04);">
                        @foreach ($product->bahan as $bahan)
                            <li style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:1px solid #DCD6D0;">
                                <span style="font-size:0.9375rem;font-weight:700;color:#172A39;">{{ $bahan->nama_bahan }}</span>
                                <span style="background:#EAEFF4;color:#172A39;font-size:0.6875rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;border-radius:9999px;padding:0.3rem 0.75rem;">Bahan</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="font-size:0.875rem;color:#8D9494;">No materials are paired with this garment yet.</p>
                @endif
            </div>

            {{-- Sizes --}}
            <div>
                <span class="section-badge" style="margin-bottom:0.875rem;">Sizes</span>
                <h2 style="font-size:1.5rem;font-weight:900;color:#172A39;margin-bottom:0.375rem;">Ukuran Tersedia</h2>
                <p style="font-size:0.875rem;color:#6E7575;margin-bottom:1.5rem;">Sizes follow the garment category.</p>
                @if ($sizes->isNotEmpty())
                    <div style="display:flex;flex-wrap:wrap;gap:0.75rem;">
                        @foreach ($sizes as $ukuran)
                            <span style="display:flex;align-items:center;justify-content:center;width:3.75rem;height:3.75rem;border-radius:0.75rem;border:2px solid #DCD6D0;background:#FFFFFF;font-size:0.9375rem;font-weight:800;color:#172A39;transition:all 0.15s;cursor:default;box-shadow:0 2px 6px rgba(23,42,57,0.04);" onmouseover="this.style.borderColor='#172A39';this.style.color='#FFFFFF';this.style.background='#172A39'" onmouseout="this.style.borderColor='#DCD6D0';this.style.color='#172A39';this.style.background='#FFFFFF'">
                                {{ $ukuran->nama_ukuran }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p style="font-size:0.875rem;color:#8D9494;">Sizes for this category have not been defined yet.</p>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Related Products ────────────────────── --}}
    @if ($related->isNotEmpty())
        <section style="padding:4.5rem 0;background:#FFFFFF;">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <span class="section-badge" style="margin-bottom:0.875rem;">More from this category</span>
                <h2 style="font-size:1.75rem;font-weight:900;color:#172A39;margin-bottom:2rem;">Produk Serupa</h2>
                <div class="catalog-grid catalog-grid--4">
                    @foreach ($related as $produk)
                        <x-collection-product-card :produk="$produk" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
