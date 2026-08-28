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
    <section style="border-bottom:1px solid #D8DDEF;">
        <div class="mx-auto grid max-w-7xl items-start gap-10 px-5 py-10 lg:grid-cols-12 lg:px-8 lg:py-16" style="column-gap:4rem;row-gap:2.5rem;">

            {{-- Image --}}
            <div class="lg:col-span-5">
                <div style="aspect-ratio:3/4;border-radius:1rem;overflow:hidden;background:#F5F7FF;box-shadow:0 4px 24px rgba(1,31,123,0.08);position:relative;">
                    @if ($imageUrl)
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $product->nama_produk }}"
                            width="600" height="800"
                            fetchpriority="high" decoding="async"
                            style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s ease;"
                            onmouseover="this.style.transform='scale(1.04)'"
                            onmouseout="this.style.transform='scale(1)'"
                        >
                    @else
                        <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.75rem;padding:2rem;text-align:center;">
                            <div style="width:4rem;height:4rem;background:#E6EAF8;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#011F7B" stroke-width="1.5" opacity="0.4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p style="font-size:0.75rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#8892B8;">{{ $product->kategori?->nama_kategori ?? 'Garment' }}</p>
                            <p style="font-size:1rem;font-weight:800;color:#011F7B;">{{ $product->nama_produk }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Details --}}
            <div class="mt-0 flex flex-col justify-center rounded-2xl border border-border bg-white p-6 shadow-[0_12px_36px_rgba(1,31,123,0.07)] sm:p-8 lg:col-span-7 lg:mt-4 lg:p-10" style="margin-left:0.5rem;">

                @if ($product->kategori?->nama_kategori)
                    <span class="section-badge" style="margin-bottom:1rem;">{{ $product->kategori->nama_kategori }}</span>
                @endif

                <h1 style="font-size:clamp(1.75rem,3.5vw,3rem);font-weight:900;color:#011F7B;letter-spacing:-0.025em;line-height:1.1;">
                    {{ $product->nama_produk }}
                </h1>

                <p style="margin-top:0.875rem;font-size:1.5rem;font-weight:900;color:#011F7B;">
                    <x-price :amount="$product->harga" />
                </p>

                @if (filled($product->deskripsi ?? null))
                    <p style="margin-top:1.25rem;font-size:0.9375rem;line-height:1.75;color:#4E5A88;">{{ $product->deskripsi }}</p>
                @else
                    <p style="margin-top:1.25rem;font-size:0.9375rem;line-height:1.75;color:#4E5A88;">
                        A made-to-order garment from the {{ $product->kategori?->nama_kategori ?? 'Clothiq' }} line. Request production with your preferred materials and size breakdown.
                    </p>
                @endif

                {{-- Action Buttons --}}
                <div style="margin-top:2rem;display:flex;flex-wrap:wrap;gap:0.75rem;">
                    <a
                        href="{{ route('order.create', ['product' => $product->id_produk]) }}"
                        class="btn-primary product-request-action"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:3.25rem;padding:0.75rem 1.5rem;background:#011F7B;color:#FFFFFF;border:2px solid #011F7B;border-radius:0.75rem;font-size:0.8125rem;font-weight:700;letter-spacing:0.05em;text-decoration:none;box-shadow:0 8px 20px rgba(1,31,123,0.2);"
                    >
                        Request This Product
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @if ($hasModel)
                        <a
                            href="{{ route('virtual-fitting', ['product' => $product->id_produk]) }}"
                            class="btn-outline"
                        >
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.847v6.306a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            View in 3D Fitting
                        </a>
                    @endif
                </div>

                {{-- Quick Facts --}}
                <div style="margin-top:1.5rem;display:flex;flex-wrap:wrap;gap:0.625rem;">
                    <div style="display:flex;align-items:center;gap:0.375rem;background:#F5F7FF;border:1px solid #D8DDEF;border-radius:9999px;padding:0.375rem 0.875rem;font-size:0.75rem;font-weight:600;color:#4E5A88;">
                        <svg width="13" height="13" fill="#011F7B" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Made to order
                    </div>
                    <div style="display:flex;align-items:center;gap:0.375rem;background:#F5F7FF;border:1px solid #D8DDEF;border-radius:9999px;padding:0.375rem 0.875rem;font-size:0.75rem;font-weight:600;color:#4E5A88;">
                        <svg width="13" height="13" fill="#011F7B" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Custom sizing
                    </div>
                    @if ($hasModel)
                        <div style="display:flex;align-items:center;gap:0.375rem;background:#E6EAF8;border:1px solid rgba(1,31,123,0.2);border-radius:9999px;padding:0.375rem 0.875rem;font-size:0.75rem;font-weight:600;color:#011F7B;">
                            <svg width="13" height="13" fill="#011F7B" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/></svg>
                            3D Preview
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ── Materials & Sizes ────────────────────── --}}
    <section style="background:#F5F7FF;border-bottom:1px solid #D8DDEF;padding:3.5rem 0;">
        <div class="mx-auto grid max-w-7xl gap-12 px-5 lg:grid-cols-2 lg:px-8">

            {{-- Materials --}}
            <div>
                <span class="section-badge" style="margin-bottom:0.875rem;">Materials</span>
                <h2 style="font-size:1.375rem;font-weight:900;color:#011F7B;margin-bottom:0.375rem;">Bahan Tersedia</h2>
                <p style="font-size:0.8125rem;color:#4E5A88;margin-bottom:1.25rem;">Available through this garment's material pairing.</p>
                @if ($product->bahan->isNotEmpty())
                    <ul style="border:1px solid #D8DDEF;border-radius:0.875rem;overflow:hidden;background:#FFFFFF;list-style:none;padding:0;margin:0;">
                        @foreach ($product->bahan as $bahan)
                            <li style="display:flex;align-items:center;justify-content:space-between;padding:0.875rem 1.125rem;border-bottom:1px solid #D8DDEF;">
                                <span style="font-size:0.9375rem;font-weight:700;color:#0D1540;">{{ $bahan->nama_bahan }}</span>
                                <span style="background:#E6EAF8;color:#011F7B;font-size:0.65rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;border-radius:9999px;padding:0.25rem 0.625rem;">Bahan</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="font-size:0.875rem;color:#8892B8;">No materials are paired with this garment yet.</p>
                @endif
            </div>

            {{-- Sizes --}}
            <div>
                <span class="section-badge" style="margin-bottom:0.875rem;">Sizes</span>
                <h2 style="font-size:1.375rem;font-weight:900;color:#011F7B;margin-bottom:0.375rem;">Ukuran Tersedia</h2>
                <p style="font-size:0.8125rem;color:#4E5A88;margin-bottom:1.25rem;">Sizes follow the garment category.</p>
                @if ($sizes->isNotEmpty())
                    <div style="display:flex;flex-wrap:wrap;gap:0.625rem;">
                        @foreach ($sizes as $ukuran)
                            <span style="display:flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;border-radius:0.625rem;border:2px solid #D8DDEF;background:#FFFFFF;font-size:0.875rem;font-weight:800;color:#011F7B;transition:all 0.15s;cursor:default;" onmouseover="this.style.borderColor='#011F7B';this.style.background='#E6EAF8'" onmouseout="this.style.borderColor='#D8DDEF';this.style.background='#FFFFFF'">
                                {{ $ukuran->nama_ukuran }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p style="font-size:0.875rem;color:#8892B8;">Sizes for this category have not been defined yet.</p>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Related Products ────────────────────── --}}
    @if ($related->isNotEmpty())
        <section style="padding:4rem 0;">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <span class="section-badge" style="margin-bottom:0.875rem;">More from this category</span>
                <h2 style="font-size:1.5rem;font-weight:900;color:#011F7B;margin-bottom:2rem;">Produk Serupa</h2>
                <div class="catalog-grid catalog-grid--4">
                    @foreach ($related as $produk)
                        <x-collection-product-card :produk="$produk" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
