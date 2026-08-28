@extends('layouts.customer')

@section('title', 'Clothiq — Custom Clothing')
@section('description', 'Pakaian custom berkualitas tinggi. Pilih produk, sesuaikan ukuran, dan nikmati virtual fitting 3D.')

@section('content')

    {{-- ═══════════════════════════════════════════
        HERO
    ═══════════════════════════════════════════ --}}
    <section style="background-color:#011F7B; min-height:90vh;" class="relative overflow-hidden flex items-center">

        {{-- Decorative background shapes --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div style="background:rgba(255,186,9,0.12); width:700px; height:700px; border-radius:50%; position:absolute; top:-200px; right:-200px;"></div>
            <div style="background:rgba(255,186,9,0.06); width:400px; height:400px; border-radius:50%; position:absolute; bottom:-150px; left:-100px;"></div>
        </div>

        <div class="mx-auto grid max-w-7xl w-full items-center gap-12 px-5 py-16 lg:grid-cols-2 lg:px-8 lg:py-24 relative z-10">

            {{-- ── Left: Copy ── --}}
            <div>

                <div style="display:inline-flex;align-items:center;gap:0.75rem;background:rgba(255,186,9,0.18);border:1px solid rgba(255,186,9,0.4);border-radius:9999px;padding:0.375rem 1rem;margin-bottom:1.5rem;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#FFBA09;display:inline-block;"></span>
                    <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#FFBA09;">Custom Clothing Studio</span>
                </div>

                <h1 style="font-size:clamp(2.75rem,5vw,4.5rem);font-weight:900;color:#FFFFFF;line-height:1.1;letter-spacing:-0.02em;">
                    Find Your<br>
                    <span style="color:#FFBA09;">Perfect Fit</span>
                </h1>

                <p style="margin-top:1.5rem;font-size:1.0625rem;line-height:1.75;color:rgba(255,255,255,0.75);max-width:480px;">
                    Pakaian custom berkualitas tinggi dengan teknologi virtual fitting 3D. Pilih produk, sesuaikan ukuran, dan pesan langsung ke tim kami.
                </p>

                <div style="margin-top:2.5rem;display:flex;flex-wrap:wrap;gap:1rem;align-items:center;">
                    <a
                        href="{{ route('collection.index') }}"
                        class="btn-accent hero-collection-action"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;min-height:3.25rem;padding:0.75rem 1.5rem;background:#FFBA09;color:#011F7B;border:2px solid #FFBA09;border-radius:0.75rem;font-size:0.875rem;font-weight:800;letter-spacing:0.04em;text-decoration:none;box-shadow:0 8px 22px rgba(0,0,0,0.2),0 0 0 4px rgba(255,186,9,0.14);"
                    >
                        Lihat Koleksi
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a
                        href="{{ route('virtual-fitting') }}"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:3.25rem;padding:0.75rem 1.25rem;background:rgba(255,255,255,0.1);color:#FFFFFF;border:1.5px solid rgba(255,255,255,0.7);border-radius:0.75rem;font-size:0.875rem;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(0,0,0,0.12);transition:background 0.15s,transform 0.15s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.transform='translateY(0)'"
                    >
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.847v6.306a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Virtual Fitting 3D
                    </a>
                </div>

                {{-- Trust badges --}}
                <div style="margin-top:2.5rem;display:flex;flex-wrap:wrap;gap:1.5rem;">
                    @foreach(['Ukuran Custom', 'Virtual 3D Preview', 'Tanpa Akun'] as $f)
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <svg width="16" height="16" style="color:#FFBA09;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span style="font-size:0.8125rem;color:rgba(255,255,255,0.7);font-weight:500;">{{ $f }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Right: Hero Image ── --}}
            <div class="hidden lg:block">
                @php
                    use App\Support\CustomerMedia;
                    $heroImgUrl = $heroImageUrl ?? ($featuredProduct ? CustomerMedia::productImageUrl($featuredProduct) : null);
                @endphp
                @if ($heroImgUrl)
                    <div style="border-radius:1.5rem;overflow:hidden;aspect-ratio:3/4;max-width:460px;margin-left:auto;box-shadow:0 32px 80px rgba(0,0,0,0.4),0 0 0 1px rgba(255,255,255,0.1);position:relative;">
                        <img src="{{ $heroImgUrl }}" alt="Clothiq Collection" style="width:100%;height:100%;object-fit:cover;">
                        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(1,31,123,0.35) 0%,transparent 60%);pointer-events:none;"></div>
                        @if ($featuredProduct)
                            <div style="position:absolute;bottom:1.25rem;left:1.25rem;right:1.25rem;">
                                <div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.2);border-radius:0.875rem;padding:1rem 1.25rem;">
                                    <p style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.65);">{{ $featuredProduct->kategori?->nama_kategori }}</p>
                                    <p style="font-size:1.0625rem;font-weight:800;color:#fff;margin-top:0.25rem;">{{ $featuredProduct->nama_produk }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div style="border-radius:1.5rem;aspect-ratio:3/4;max-width:460px;margin-left:auto;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1rem;">
                        <p style="color:rgba(255,255,255,0.3);font-size:0.875rem;">Clothiq Collection</p>
                    </div>
                @endif
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        STATS STRIP
    ═══════════════════════════════════════════ --}}
    <section style="background:#FFBA09;">
        <div class="mx-auto max-w-7xl px-5 py-5 lg:px-8">
            <div class="grid grid-cols-3 gap-4 divide-x divide-yellow-600/30 text-center">
                @foreach([['100+','Produk tersedia'],['3D','Virtual Fitting'],['Fast','Proses cepat']] as [$num,$label])
                    <div class="px-4 py-1">
                        <p style="font-size:1.375rem;font-weight:900;color:#011F7B;">{{ $num }}</p>
                        <p style="font-size:0.7125rem;font-weight:600;color:rgba(1,31,123,0.7);text-transform:uppercase;letter-spacing:0.08em;">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        FEATURED PRODUCT + SUPPORTING
    ═══════════════════════════════════════════ --}}
    @if ($featuredProduct)
        <section style="background:#FFFFFF;padding:5rem 0;">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <span class="section-badge" style="margin-bottom:0.75rem;">Koleksi Unggulan</span>
                        <h2 style="font-size:2rem;font-weight:900;color:#011F7B;letter-spacing:-0.02em;">Pilihan Terbaik</h2>
                    </div>
                    <a href="{{ route('collection.index') }}" style="font-size:0.8125rem;font-weight:700;color:#011F7B;text-decoration:none;display:flex;align-items:center;gap:0.375rem;opacity:0.75;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.75'">
                        Lihat semua
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <div class="grid gap-6 lg:grid-cols-12">
                    <div class="lg:col-span-5">
                        <x-collection-product-card :produk="$featuredProduct" :lazy="false" />
                    </div>
                    @if ($supportingProducts->isNotEmpty())
                        <div class="catalog-grid catalog-grid--3 lg:col-span-7" style="align-content:start;">
                            @foreach ($supportingProducts->take(3) as $produk)
                                <x-collection-product-card :produk="$produk" :lazy="true" />
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif


    {{-- ═══════════════════════════════════════════
        WHY FITVENDOR — Blue section
    ═══════════════════════════════════════════ --}}
    <section style="background:#011F7B;padding:5rem 0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="text-center mb-12">
                <span style="display:inline-flex;align-items:center;gap:0.5rem;color:#FFBA09;font-size:0.7rem;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;margin-bottom:0.75rem;">
                    <span style="width:1.5rem;height:3px;background:#FFBA09;border-radius:2px;display:inline-block;"></span>
                    Mengapa Clothiq
                    <span style="width:1.5rem;height:3px;background:#FFBA09;border-radius:2px;display:inline-block;"></span>
                </span>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $features = [
                        ['icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title'=>'Ukuran Custom', 'desc'=>'Tentukan ukuran tubuhmu sendiri. Tidak ada S/M/L — setiap pakaian dibuat sesuai pengukuranmu.'],
                        ['icon'=>'M15 10l4.553-2.069A1 1 0 0121 8.847v6.306a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'title'=>'Virtual Fitting 3D', 'desc'=>'Lihat bagaimana pakaian akan terlihat di tubuhmu menggunakan teknologi virtual fitting 3D interaktif.'],
                        ['icon'=>'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01', 'title'=>'Material Premium', 'desc'=>'Pilih dari berbagai material pilihan. Setiap bahan dipilih untuk kenyamanan dan ketahanan jangka panjang.'],
                    ];
                @endphp
                @foreach ($features as $f)
                    <div style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:1rem;padding:2rem;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.11)'" onmouseout="this.style.background='rgba(255,255,255,0.07)'">
                        <div style="width:3rem;height:3rem;background:rgba(255,186,9,0.2);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" style="color:#FFBA09;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 style="font-size:1.0625rem;font-weight:800;color:#FFFFFF;margin-bottom:0.625rem;">{{ $f['title'] }}</h3>
                        <p style="font-size:0.875rem;line-height:1.7;color:rgba(255,255,255,0.6);">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        SUPPORTING PRODUCTS LOOKBOOK
    ═══════════════════════════════════════════ --}}
    @if ($supportingProducts->isNotEmpty())
        <section style="background:#F5F7FF;padding:5rem 0;">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mb-10">
                    <span class="section-badge" style="margin-bottom:0.75rem;">Our Work</span>
                    <h2 style="font-size:2rem;font-weight:900;color:#011F7B;letter-spacing:-0.02em;">Crafted for Every Story</h2>
                    <p style="margin-top:0.75rem;font-size:0.9375rem;color:#4E5A88;max-width:520px;">Setiap pakaian menceritakan sebuah cerita. Jelajahi hasil karya kami yang telah diproduksi untuk berbagai pelanggan.</p>
                </div>
                <x-lookbook-composition :products="$supportingProducts" />
                <div class="mt-10 text-center">
                    <a
                        href="{{ route('collection.index') }}"
                        class="btn-primary"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;min-height:3.25rem;padding:0.75rem 1.5rem;background:#011F7B;color:#FFFFFF;border:2px solid #011F7B;border-radius:0.75rem;font-size:0.875rem;font-weight:800;letter-spacing:0.04em;text-decoration:none;box-shadow:0 8px 20px rgba(1,31,123,0.24);"
                    >
                        View Collection
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </section>
    @endif


    {{-- ═══════════════════════════════════════════
        VIRTUAL FITTING CTA
    ═══════════════════════════════════════════ --}}
    <section style="background:#FFBA09;padding:4rem 0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-2 items-center">
                <div>
                    <p style="font-size:0.7rem;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:rgba(1,31,123,0.6);margin-bottom:0.75rem;">Studio Interaktif</p>
                    <h2 style="font-size:2.25rem;font-weight:900;color:#011F7B;line-height:1.15;letter-spacing:-0.02em;">Coba Virtual<br>Fitting Sekarang</h2>
                    <p style="margin-top:1rem;font-size:0.9375rem;color:rgba(1,31,123,0.7);line-height:1.7;">Pilih produk, sesuaikan profilmu, lalu lihat preview pakaian sebelum mengirim request ke tim kami.</p>
                    <a href="{{ route('virtual-fitting') }}" style="margin-top:2rem;display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;background:#011F7B;color:#FFFFFF;padding:0.875rem 2rem;font-size:0.875rem;font-weight:800;border-radius:0.625rem;text-decoration:none;transition:background 0.15s,box-shadow 0.15s;box-shadow:0 4px 16px rgba(1,31,123,0.35);" onmouseover="this.style.background='#011060'" onmouseout="this.style.background='#011F7B'">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.847v6.306a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Buka Virtual Fitting
                    </a>
                </div>
                <div class="hidden lg:flex justify-center">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;max-width:360px;">
                        @foreach([
                            ['01', 'Pilih Produk', 'Tentukan item yang ingin dicoba', 'collection.index'],
                            ['02', 'Atur Profil', 'Sesuaikan tampilan untukmu', 'virtual-fitting'],
                            ['03', 'Lihat Preview', 'Amati fitting dalam tampilan 3D', 'virtual-fitting'],
                            ['04', 'Kirim Request', 'Lanjutkan pesanan dengan mudah', 'order.create'],
                        ] as [$number, $title, $description, $route])
                            <a
                                href="{{ route($route) }}"
                                style="min-height:9rem;display:flex;flex-direction:column;background:#FFFFFF;border:2px solid rgba(1,31,123,0.28);border-radius:0.875rem;padding:1rem;text-align:left;text-decoration:none;box-shadow:0 5px 14px rgba(1,31,123,0.12);transition:transform 0.15s,background 0.15s,box-shadow 0.15s;"
                                onmouseover="this.style.transform='translateY(-4px)';this.style.background='#E6EAF8';this.style.boxShadow='0 10px 20px rgba(1,31,123,0.2)'"
                                onmouseout="this.style.transform='translateY(0)';this.style.background='#FFFFFF';this.style.boxShadow='0 5px 14px rgba(1,31,123,0.12)'"
                            >
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:9999px;background:#011F7B;color:#FFBA09;font-size:0.75rem;font-weight:900;line-height:1;">{{ $number }}</span>
                                <span style="font-size:0.8125rem;font-weight:800;color:#011F7B;margin-top:0.75rem;">{{ $title }}</span>
                                <span style="font-size:0.6875rem;line-height:1.45;color:rgba(1,31,123,0.68);margin-top:0.25rem;">{{ $description }}</span>
                                <span style="display:flex;align-items:center;gap:0.25rem;margin-top:auto;padding-top:0.625rem;font-size:0.6875rem;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;color:#011F7B;">Buka <span aria-hidden="true">→</span></span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        MATERIALS TEASER
    ═══════════════════════════════════════════ --}}
    @if ($materials->isNotEmpty())
        <section style="background:#FFFFFF;padding:5rem 0;border-top:1px solid #D8DDEF;">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-2 items-start">
                    <div>
                        <span class="section-badge mb-3">Material</span>
                        <h2 style="font-size:2rem;font-weight:900;color:#011F7B;letter-spacing:-0.02em;">Pilihan Bahan</h2>
                        <p style="margin-top:0.75rem;font-size:0.9375rem;color:#4E5A88;line-height:1.7;max-width:420px;">Setiap bahan dipilih dengan cermat untuk memastikan kenyamanan dan kualitas terbaik bagi setiap produk.</p>
                        <a href="{{ route('materials.index') }}" class="btn-primary mt-6">
                            Lihat Semua Bahan
                        </a>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($materials->take(4) as $bahan)
                            <x-material-item :bahan="$bahan" />
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
