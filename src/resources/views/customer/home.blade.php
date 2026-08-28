@extends('layouts.customer')

@section('title', 'Clothiq — Custom Clothing')
@section('description', 'Pakaian custom berkualitas tinggi. Pilih produk, sesuaikan ukuran, dan nikmati virtual fitting 3D.')

@section('content')

    {{-- ═══════════════════════════════════════════
        HERO
    ═══════════════════════════════════════════ --}}
    <section style="background-color:#172A39; min-height:88vh;" class="relative overflow-hidden flex items-center">

        {{-- Decorative background shapes --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div style="background:rgba(252,86,60,0.12); width:700px; height:700px; border-radius:50%; position:absolute; top:-200px; right:-200px; filter:blur(60px);"></div>
            <div style="background:rgba(233,228,224,0.06); width:450px; height:450px; border-radius:50%; position:absolute; bottom:-150px; left:-100px; filter:blur(50px);"></div>
        </div>

        <div class="mx-auto grid max-w-7xl w-full items-center gap-12 px-5 py-16 lg:grid-cols-2 lg:px-8 lg:py-24 relative z-10">

            {{-- ── Left: Copy ── --}}
            <div>

                <div style="display:inline-flex;align-items:center;gap:0.75rem;background:rgba(252,86,60,0.15);border:1px solid rgba(252,86,60,0.4);border-radius:9999px;padding:0.4rem 1.1rem;margin-bottom:1.5rem;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#FC563C;display:inline-block;"></span>
                    <span style="font-size:0.725rem;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:#FC563C;">Custom Clothing Studio</span>
                </div>

                <h1 style="font-size:clamp(2.75rem,5vw,4.5rem);font-weight:900;color:#FFFFFF;line-height:1.1;letter-spacing:-0.025em;">
                    Find Your<br>
                    <span style="color:#FC563C;">Perfect Fit</span>
                </h1>

                <p style="margin-top:1.5rem;font-size:1.0625rem;line-height:1.75;color:rgba(233,228,224,0.85);max-width:480px;">
                    Pakaian custom berkualitas tinggi dengan teknologi virtual fitting 3D. Pilih produk, sesuaikan ukuran, dan pesan langsung ke tim kami.
                </p>

                <div style="margin-top:2.5rem;display:flex;flex-wrap:wrap;gap:1.25rem;align-items:center;">
                    <a
                        href="{{ route('collection.index') }}"
                        class="btn-accent hero-collection-action"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;min-height:3.25rem;padding:0.75rem 1.75rem;background:#FC563C;color:#FFFFFF !important;border:2px solid #FC563C;border-radius:0.75rem;font-size:0.875rem;font-weight:800;letter-spacing:0.04em;text-decoration:none;box-shadow:0 8px 24px rgba(0,0,0,0.25),0 0 0 4px rgba(252,86,60,0.2);transition:all 0.15s;"
                    >
                        Lihat Koleksi
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a
                        href="{{ route('virtual-fitting') }}"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;min-height:3.25rem;padding:0.75rem 1.5rem;background:rgba(255,255,255,0.08);color:#FFFFFF !important;border:1.5px solid rgba(233,228,224,0.6);border-radius:0.75rem;font-size:0.875rem;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(0,0,0,0.15);transition:all 0.15s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.18)';this.style.borderColor='#FFFFFF';this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.borderColor='rgba(233,228,224,0.6)';this.style.transform='translateY(0)'"
                    >
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.847v6.306a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Virtual Fitting 3D
                    </a>
                </div>

                {{-- Trust badges --}}
                <div style="margin-top:2.75rem;display:flex;flex-wrap:wrap;gap:1.5rem;">
                    @foreach(['Ukuran Custom', 'Virtual 3D Preview', 'Tanpa Akun'] as $f)
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <svg width="16" height="16" style="color:#FC563C;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span style="font-size:0.8125rem;color:rgba(233,228,224,0.8);font-weight:600;">{{ $f }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Right: Hero Image ── --}}
            <div class="hidden lg:flex justify-end">
                @php
                    use App\Support\CustomerMedia;
                    $heroImgUrl = $heroImageUrl ?? ($featuredProduct ? CustomerMedia::productImageUrl($featuredProduct) : null);
                @endphp
                @if ($heroImgUrl)
                    <div style="border-radius:1.75rem;overflow:hidden;aspect-ratio:3/4;width:100%;max-width:540px;box-shadow:0 36px 90px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,255,255,0.15);position:relative;background:#172A39;">
                        <img
                            src="{{ $heroImgUrl }}"
                            alt="Clothiq Collection"
                            style="width:100%;height:100%;object-fit:cover;transform:scale(1.08);transform-origin:center;display:block;"
                        >
                    </div>
                @else
                    <div style="border-radius:1.75rem;aspect-ratio:3/4;width:100%;max-width:540px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1rem;">
                        <p style="color:rgba(233,228,224,0.4);font-size:0.875rem;">Clothiq Collection</p>
                    </div>
                @endif
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        VALUE PROPOSITION CARDS (Premium, Modern, Certified)
    ═══════════════════════════════════════════ --}}
    <section style="background:#F6F4F1;border-bottom:1px solid #DCD6D0;padding:4rem 0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="value-props-container" style="display:grid;grid-template-columns:repeat(3, minmax(0, 1fr));gap:1.5rem;width:100%;">
                
                {{-- Card 1: Premium --}}
                <div
                    style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.25rem;padding:2.25rem 1.75rem;text-align:center;box-shadow:0 4px 16px rgba(23,42,57,0.04);transition:all 0.2s ease;display:flex;flex-direction:column;align-items:center;"
                    onmouseover="this.style.transform='translateY(-4px)';this.style.borderColor='#FC563C';this.style.boxShadow='0 12px 28px rgba(23,42,57,0.09)'"
                    onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#DCD6D0';this.style.boxShadow='0 4px 16px rgba(23,42,57,0.04)'"
                >
                    <div style="width:3.5rem;height:3.5rem;background:#EAEFF4;border-radius:1rem;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:#172A39;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1.25rem;font-weight:900;color:#172A39;letter-spacing:-0.02em;">Premium</h3>
                    <p style="font-size:0.875rem;line-height:1.65;color:#6E7575;margin-top:0.75rem;">
                        Bahan premium memberi kesan profesional sejak pandangan pertama, nyaman dipakai dan percaya diri.
                    </p>
                </div>

                {{-- Card 2: Modern --}}
                <div
                    style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.25rem;padding:2.25rem 1.75rem;text-align:center;box-shadow:0 4px 16px rgba(23,42,57,0.04);transition:all 0.2s ease;display:flex;flex-direction:column;align-items:center;"
                    onmouseover="this.style.transform='translateY(-4px)';this.style.borderColor='#FC563C';this.style.boxShadow='0 12px 28px rgba(23,42,57,0.09)'"
                    onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#DCD6D0';this.style.boxShadow='0 4px 16px rgba(23,42,57,0.04)'"
                >
                    <div style="width:3.5rem;height:3.5rem;background:#EAEFF4;border-radius:1rem;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:#172A39;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12l4 6-10 12L2 9l4-6z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 9h20M12 21L8 9l4-6 4 6-4 12z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1.25rem;font-weight:900;color:#172A39;letter-spacing:-0.02em;">Modern</h3>
                    <p style="font-size:0.875rem;line-height:1.65;color:#6E7575;margin-top:0.75rem;">
                        Menggunakan mesin paling mutakhir sehingga menghasilkan produk berkualitas dan presisi tinggi.
                    </p>
                </div>

                {{-- Card 3: Certified --}}
                <div
                    style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.25rem;padding:2.25rem 1.75rem;text-align:center;box-shadow:0 4px 16px rgba(23,42,57,0.04);transition:all 0.2s ease;display:flex;flex-direction:column;align-items:center;"
                    onmouseover="this.style.transform='translateY(-4px)';this.style.borderColor='#FC563C';this.style.boxShadow='0 12px 28px rgba(23,42,57,0.09)'"
                    onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#DCD6D0';this.style.boxShadow='0 4px 16px rgba(23,42,57,0.04)'"
                >
                    <div style="width:3.5rem;height:3.5rem;background:#EAEFF4;border-radius:1rem;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:#172A39;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1.25rem;font-weight:900;color:#172A39;letter-spacing:-0.02em;">Certified</h3>
                    <p style="font-size:0.875rem;line-height:1.65;color:#6E7575;margin-top:0.75rem;">
                        Setiap proses produksi di Clothiq terjamin baik kualitas, mutu, maupun ketahanannya.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <style>
        @media (max-width: 767px) {
            .value-props-container {
                grid-template-columns: 1fr !important;
            }
        }
    </style>


    {{-- ═══════════════════════════════════════════
        TENTANG KAMI / ABOUT CLOTHIQ
    ═══════════════════════════════════════════ --}}
    <section style="background:#FFFFFF;padding:5.5rem 0;border-bottom:1px solid #DCD6D0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-center">
                
                {{-- Left Column: Brand Story & Narrative --}}
                <div class="lg:col-span-7">
                    <span class="section-badge" style="margin-bottom:1rem;">
                        <span style="width:1.5rem;height:3px;background:#FC563C;border-radius:2px;display:inline-block;"></span>
                        Tentang Kami
                    </span>
                    <h2 style="font-size:2.25rem;font-weight:900;color:#172A39;letter-spacing:-0.025em;line-height:1.2;margin-top:0.5rem;" class="md:text-4xl">
                        Mewujudkan Pakaian Custom dengan Presisi, Karakter, dan Kualitas Tinggi.
                    </h2>
                    <div style="margin-top:1.5rem;display:flex;flex-direction:column;gap:1rem;color:#6E7575;font-size:0.9375rem;line-height:1.75;">
                        <p>
                            <strong style="color:#172A39;font-weight:800;">Clothiq</strong> hadir sebagai atelier pakaian custom modern yang memadukan keahlian jahit berpengalaman dengan ketelitian pola dan kurasi material terbaik. Kami percaya bahwa setiap pakaian harus dibuat dengan tujuan yang jelas dan kenyamanan maksimal bagi pemakainya.
                        </p>
                        <p>
                            Mulai dari jaket varsity, windbreaker, work jacket, jersey, hingga kaos komunitas, setiap pesanan diproses dengan kontrol mutu ketat, jahitan presisi berstandar tinggi, dan pemilihan bahan kain premium agar hasil akhir sesuai dengan ekspektasi Anda.
                        </p>
                    </div>

                    <div style="margin-top:2.25rem;display:flex;flex-wrap:wrap;align-items:center;gap:1rem;">
                        <a href="{{ route('about') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 1.75rem;font-size:0.875rem;font-weight:800;border-radius:0.75rem;text-decoration:none;">
                            Kisah Lengkap Clothiq
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('order.create') }}" class="btn-outline" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 1.75rem;font-size:0.875rem;font-weight:800;border-radius:0.75rem;text-decoration:none;">
                            Konsultasi Custom
                        </a>
                    </div>
                </div>

                {{-- Right Column: Brand Highlights & Pillar Cards --}}
                <div class="lg:col-span-5">
                    <div style="background:#F6F4F1;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2.25rem;display:flex;flex-direction:column;gap:1.5rem;box-shadow:0 6px 20px rgba(23,42,57,0.04);">
                        
                        <div style="display:flex;align-items:flex-start;gap:1rem;">
                            <div style="width:3rem;height:3rem;border-radius:0.875rem;background:#172A39;color:#FC563C;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 style="font-size:1.0625rem;font-weight:800;color:#172A39;">Sentuhan Personal & Kustom</h3>
                                <p style="font-size:0.8125rem;line-height:1.6;color:#6E7575;margin-top:0.25rem;">
                                    Bebas atur ukuran, kombinasi bahan, dan aplikasi bordir/sablon sesuai identitas tim atau brand Anda.
                                </p>
                            </div>
                        </div>

                        <div style="width:100%;height:1px;background:#DCD6D0;"></div>

                        <div style="display:flex;align-items:flex-start;gap:1rem;">
                            <div style="width:3rem;height:3rem;border-radius:0.875rem;background:#172A39;color:#FC563C;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879a3 3 0 11-4.242-4.242 3 3 0 014.242 0L12 12zm0 0l-2.879-2.879a3 3 0 10-4.242 4.242 3 3 0 004.242 0L12 12z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 style="font-size:1.0625rem;font-weight:800;color:#172A39;">Presisi Pola & Jahitan Rapi</h3>
                                <p style="font-size:0.8125rem;line-height:1.6;color:#6E7575;margin-top:0.25rem;">
                                    Setiap helai pakaian dipotong dengan pola proporsional dan dijahit rapi oleh tenaga ahli berpengalaman demi kenyamanan dan ketahanan maksimal.
                                </p>
                            </div>
                        </div>

                        <div style="width:100%;height:1px;background:#DCD6D0;"></div>

                        <div style="display:flex;align-items:flex-start;gap:1rem;">
                            <div style="width:3rem;height:3rem;border-radius:0.875rem;background:#172A39;color:#FC563C;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <h3 style="font-size:1.0625rem;font-weight:800;color:#172A39;">Produksi Terpercaya & Berpengalaman</h3>
                                <p style="font-size:0.8125rem;line-height:1.6;color:#6E7575;margin-top:0.25rem;">
                                    Telah dipercaya oleh berbagai instansi kampus, komunitas, dan organisasi untuk apparel berkualitas.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        CATEGORY SHOWCASE (Koleksi Kategori Pilihan Terbaik — Extra Large & Striking)
    ═══════════════════════════════════════════ --}}
    @php
        $showcaseItems = $categoryShowcase ?? collect([]);
    @endphp

    @if ($showcaseItems->isNotEmpty())
        <section style="background:#FFFFFF;padding:6.5rem 0;border-bottom:1px solid #DCD6D0;">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
                    <div>
                        <span class="section-badge" style="margin-bottom:0.875rem;font-size:0.8125rem;">
                            <span style="width:1.5rem;height:3px;background:#FC563C;border-radius:2px;display:inline-block;"></span>
                            Our Work • Koleksi Unggulan
                        </span>
                        <h2 style="font-size:3rem;font-weight:900;color:#172A39;letter-spacing:-0.03em;line-height:1.1;" class="text-4xl md:text-5xl lg:text-6xl">
                            Pilihan Kategori Terbaik
                        </h2>
                        <p style="margin-top:0.75rem;font-size:1rem;color:#6E7575;max-width:560px;">
                            Jelajahi lini produk pakaian custom pilihan kami dengan standar jahitan tinggi, bahan berkualitas, dan presisi terbaik.
                        </p>
                    </div>
                    <a
                        href="{{ route('collection.index') }}"
                        class="btn-primary"
                        style="display:inline-flex;align-items:center;gap:0.625rem;padding:1rem 2rem;font-size:0.9375rem;font-weight:800;border-radius:0.875rem;text-decoration:none;align-self:flex-start;md:align-self:auto;box-shadow:0 6px 20px rgba(23,42,57,0.2);"
                    >
                        View Collection
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="category-showcase-grid" style="display:grid;grid-template-columns:repeat(3, minmax(0, 1fr));gap:2.25rem;width:100%;">
                    @foreach ($showcaseItems as $item)
                        @php
                            $cat = $item['category'];
                            $prod = $item['product'];
                            $catSlug = \Illuminate\Support\Str::slug($cat->nama_kategori);
                            $catUrl = route('collection.index', ['category' => $catSlug]);
                            $imgUrl = $prod ? CustomerMedia::productImageUrl($prod) : null;
                        @endphp
                        <a
                            href="{{ $catUrl }}"
                            class="group"
                            style="display:flex;flex-direction:column;text-decoration:none;transition:transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);"
                            onmouseover="this.style.transform='translateY(-8px)'"
                            onmouseout="this.style.transform='translateY(0)'"
                        >
                            <div style="position:relative;width:100%;aspect-ratio:4/5;border-radius:1.75rem;overflow:hidden;background:#F6F4F1;border:2px solid #DCD6D0;box-shadow:0 10px 30px rgba(23,42,57,0.06);transition:all 0.3s ease;" onmouseover="this.style.borderColor='#FC563C';this.style.boxShadow='0 20px 44px rgba(23,42,57,0.14)'" onmouseout="this.style.borderColor='#DCD6D0';this.style.boxShadow='0 10px 30px rgba(23,42,57,0.06)'">
                                
                                {{-- Action button on bottom right --}}
                                <div style="position:absolute;bottom:1.25rem;right:1.25rem;z-index:10;background:#FC563C;color:#FFFFFF;padding:0.5rem 1.125rem;border-radius:9999px;font-size:0.8125rem;font-weight:800;letter-spacing:0.04em;display:flex;align-items:center;gap:0.375rem;box-shadow:0 8px 22px rgba(252,86,60,0.45);transition:all 0.2s ease;" onmouseover="this.style.background='#E44229';this.style.transform='scale(1.05)'" onmouseout="this.style.background='#FC563C';this.style.transform='scale(1)'">
                                    <span>Lihat Detail</span>
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>

                                @if ($imgUrl)
                                    <img
                                        src="{{ $imgUrl }}"
                                        alt="{{ $prod ? $prod->nama_produk : $cat->nama_kategori }}"
                                        width="600"
                                        height="750"
                                        loading="lazy"
                                        decoding="async"
                                        style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"
                                    >
                                @else
                                    <div style="display:flex;height:100%;width:100%;flex-direction:column;align-items:center;justify-content:center;padding:2rem;text-align:center;">
                                        <div style="width:4.5rem;height:4.5rem;border-radius:50%;background:#EAEFF4;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                                            <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#172A39" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        </div>
                                        <p style="font-size:0.875rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#6E7575;">Clothiq</p>
                                    </div>
                                @endif
                            </div>

                            <div style="margin-top:1.25rem;display:flex;flex-direction:column;">
                                <h3 style="font-size:1.375rem;font-weight:900;color:#172A39;letter-spacing:-0.02em;line-height:1.25;">
                                    {{ $cat->nama_kategori }}
                                </h3>
                                @if ($prod)
                                    <p style="margin-top:0.35rem;font-size:1.0625rem;font-weight:900;color:#FC563C;">
                                        <x-price :amount="$prod->harga" />
                                    </p>
                                    <span style="display:none;" data-product="{{ $prod->nama_produk }}">{{ $prod->nama_produk }}</span>
                                @else
                                    <p style="margin-top:0.35rem;font-size:0.875rem;color:#6E7575;">Custom Garment</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <style>
            @media (max-width: 1024px) {
                .category-showcase-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                    gap: 1.5rem !important;
                }
            }
            @media (max-width: 640px) {
                .category-showcase-grid {
                    grid-template-columns: 1fr !important;
                    gap: 1.5rem !important;
                }
            }
        </style>
    @endif


    {{-- ═══════════════════════════════════════════
        LAYANAN & SOLUSI PRODUKSI APPAREL — Dark Slate Navy Section
    ═══════════════════════════════════════════ --}}
    <section style="background:#172A39;padding:5.5rem 0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="text-center" style="margin-bottom:4.5rem;">
                <span style="display:inline-flex;align-items:center;gap:0.5rem;color:#FC563C;font-size:0.75rem;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;margin-bottom:1rem;">
                    <span style="width:1.5rem;height:3px;background:#FC563C;border-radius:2px;display:inline-block;"></span>
                    Layanan Produksi
                    <span style="width:1.5rem;height:3px;background:#FC563C;border-radius:2px;display:inline-block;"></span>
                </span>
                <h2 style="font-size:2.25rem;font-weight:900;color:#FFFFFF;letter-spacing:-0.025em;margin-top:0.5rem;" class="md:text-4xl">
                    Solusi Pakaian Custom untuk Berbagai Kebutuhan
                </h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $services = [
                        [
                            'tag' => 'Outerwear',
                            'title' => 'Jaket & Outerwear Angkatan',
                            'desc' => 'Varsity jacket, windbreaker tahan angin, work jacket, dan hoodie fleece berkarakter dengan bordir komputer detail.',
                            'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                        ],
                        [
                            'tag' => 'Corporate & PDH',
                            'title' => 'Seragam Kerja & Organisasi',
                            'desc' => 'Kemeja PDH/PDL, rompi lapangan, dan polo shirt eksklusif dengan pola nyaman untuk aktivitas formal maupun lapangan.',
                            'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                        ],
                        [
                            'tag' => 'Sportswear',
                            'title' => 'Jersey & Sportswear',
                            'desc' => 'Jersey tim olahraga berteknologi kain dry-fit dengan sirkulasi udara maksimal dan cetak sublimasi warna tajam.',
                            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                        ],
                        [
                            'tag' => 'Event & Distro',
                            'title' => 'Kaos Event & Merchandise',
                            'desc' => 'Kaos Cotton Combed premium lembut dan adem dengan sablon berkualitas tinggi untuk event akbar dan clothing brand.',
                            'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                        ],
                    ];
                @endphp
                @foreach ($services as $s)
                    <div
                        style="background:rgba(255,255,255,0.04);border:1.5px solid rgba(233,228,224,0.12);border-radius:1.25rem;padding:2rem 1.75rem;display:flex;flex-direction:column;transition:all 0.2s ease;"
                        onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.borderColor='#FC563C';this.style.transform='translateY(-4px)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.04)';this.style.borderColor='rgba(233,228,224,0.12)';this.style.transform='translateY(0)'"
                    >
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                            <div style="width:3rem;height:3rem;border-radius:0.875rem;background:rgba(252,86,60,0.16);display:flex;align-items:center;justify-content:center;">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#FC563C;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
                                </svg>
                            </div>
                            <span style="font-size:0.6875rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:rgba(233,228,224,0.6);background:rgba(255,255,255,0.06);padding:0.25rem 0.625rem;border-radius:9999px;">
                                {{ $s['tag'] }}
                            </span>
                        </div>
                        <h3 style="font-size:1.125rem;font-weight:800;color:#FFFFFF;margin-bottom:0.625rem;line-height:1.3;">{{ $s['title'] }}</h3>
                        <p style="font-size:0.8125rem;line-height:1.65;color:rgba(233,228,224,0.75);">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <div style="margin-top:3.5rem;display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:1.5rem;padding:1.5rem 2rem;background:rgba(255,255,255,0.03);border:1px solid rgba(233,228,224,0.1);border-radius:1rem;">
                <div style="display:flex;align-items:center;gap:0.5rem;color:#FFFFFF;font-size:0.8125rem;font-weight:700;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#FC563C" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Kapasitas Partai Kecil & Besar
                </div>
                <span style="color:rgba(233,228,224,0.2);display:none;sm:inline;">•</span>
                <div style="display:flex;align-items:center;gap:0.5rem;color:#FFFFFF;font-size:0.8125rem;font-weight:700;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#FC563C" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Bordir & Sablon Standar Distro
                </div>
                <span style="color:rgba(233,228,224,0.2);display:none;sm:inline;">•</span>
                <div style="display:flex;align-items:center;gap:0.5rem;color:#FFFFFF;font-size:0.8125rem;font-weight:700;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#FC563C" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Garansi Ketepatan Deadline & QC Ketat
                </div>
            </div>
        </div>
    </section>





    {{-- ═══════════════════════════════════════════
        VIRTUAL FITTING CTA
    ═══════════════════════════════════════════ --}}
    <section style="background:#E9E4E0;padding:5rem 0;border-bottom:1px solid #DCD6D0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 items-center">
                <div>
                    <p style="font-size:0.725rem;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:#FC563C;margin-bottom:0.75rem;">Studio Interaktif</p>
                    <h2 style="font-size:2.25rem;font-weight:900;color:#172A39;line-height:1.15;letter-spacing:-0.025em;">Coba Virtual<br>Fitting Sekarang</h2>
                    <p style="margin-top:1rem;font-size:0.9375rem;color:#6E7575;line-height:1.7;">Pilih produk, sesuaikan profil ukuran tubuhmu, lalu amati preview pakaian dalam tampilan 3D sebelum mengirim request ke tim kami.</p>
                    <a href="{{ route('virtual-fitting') }}" class="btn-accent" style="margin-top:2rem;display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;background:#FC563C;color:#FFFFFF !important;padding:0.875rem 2rem;font-size:0.875rem;font-weight:800;border-radius:0.75rem;text-decoration:none;transition:all 0.15s;box-shadow:0 6px 20px rgba(252,86,60,0.4);" onmouseover="this.style.background='#E44229';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#FC563C';this.style.transform='translateY(0)'">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.847v6.306a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Buka Virtual Fitting
                    </a>
                </div>
                <div class="hidden lg:flex justify-end">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;width:100%;max-width:520px;">
                        @foreach([
                            ['01', 'Pilih Produk', 'Tentukan item pakaian custom yang ingin dicoba.'],
                            ['02', 'Atur Profil', 'Sesuaikan ukuran tubuhmu untuk simulasi yang akurat.'],
                            ['03', 'Lihat Preview', 'Amati fitting proporsi pakaian dalam visualisasi 3D.'],
                            ['04', 'Kirim Request', 'Kirim detail pesanan langsung ke tim kami.'],
                        ] as [$number, $title, $description])
                            <div
                                style="min-height:11rem;display:flex;flex-direction:column;background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.25rem;padding:1.5rem;text-align:left;box-shadow:0 6px 18px rgba(23,42,57,0.06);transition:all 0.2s ease;"
                                onmouseover="this.style.transform='translateY(-3px)';this.style.borderColor='#FC563C';this.style.boxShadow='0 12px 28px rgba(23,42,57,0.1)'"
                                onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#DCD6D0';this.style.boxShadow='0 6px 18px rgba(23,42,57,0.06)'"
                            >
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:2.35rem;height:2.35rem;border-radius:9999px;background:#172A39;color:#FC563C;font-size:0.8125rem;font-weight:900;line-height:1;">{{ $number }}</span>
                                <span style="font-size:1.0625rem;font-weight:800;color:#172A39;margin-top:1rem;">{{ $title }}</span>
                                <span style="font-size:0.8125rem;line-height:1.6;color:#6E7575;margin-top:0.375rem;">{{ $description }}</span>
                            </div>
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
        <section style="background:#FFFFFF;padding:5rem 0;">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-2 items-start">
                    <div>
                        <span class="section-badge" style="margin-bottom:0.75rem;">Material</span>
                        <h2 style="font-size:2.25rem;font-weight:900;color:#172A39;letter-spacing:-0.025em;">Pilihan Bahan</h2>
                        <p style="margin-top:0.75rem;font-size:0.9375rem;color:#6E7575;line-height:1.7;max-width:420px;">Setiap bahan dipilih dengan cermat untuk memastikan kenyamanan dan kualitas terbaik bagi setiap produk.</p>
                        <a href="{{ route('materials.index') }}" class="btn-primary" style="margin-top:1.75rem;display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:3rem;padding:0.75rem 1.5rem;background:#172A39;color:#FFFFFF;border-radius:0.625rem;text-decoration:none;font-weight:800;font-size:0.8125rem;">
                            Lihat Semua Bahan
                        </a>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        @foreach ($materials->take(4) as $bahan)
                            <x-material-item :bahan="$bahan" />
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
