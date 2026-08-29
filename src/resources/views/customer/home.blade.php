@extends('layouts.customer')

@section('title', 'Clothiq — Custom Clothing')
@section('description', 'Pakaian custom berkualitas tinggi. Pilih produk, sesuaikan ukuran, dan nikmati virtual fitting 3D.')

@section('content')

    {{-- ═══════════════════════════════════════════
        HERO
    ═══════════════════════════════════════════ --}}
    <section style="background: radial-gradient(ellipse 65% 85% at 82% 50%, #FAF8F5 0%, #EFE9E1 28%, #B8ABA0 48%, rgba(23,42,57,0) 75%), linear-gradient(to right, #172A39 0%, #172A39 42%, #1F3648 55%, #3B5366 70%, #EAE2D8 92%, #FAF8F5 100%); min-height:88vh;" class="relative overflow-hidden flex items-center">

        {{-- Decorative ambient lighting --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div style="background:radial-gradient(circle, rgba(250,248,245,0.35) 0%, transparent 70%); width:650px; height:650px; position:absolute; top:50%; right:5%; transform:translateY(-50%); filter:blur(40px);"></div>
            <div style="background:rgba(35,59,78,0.5); width:450px; height:450px; border-radius:50%; position:absolute; bottom:-150px; left:-100px; filter:blur(60px);"></div>
        </div>

        <div class="mx-auto grid max-w-7xl w-full items-center gap-12 px-5 py-16 lg:grid-cols-2 lg:px-8 lg:py-24 relative z-10">

            {{-- ── Left: Copy ── --}}
            <div>

                <div style="display:inline-flex;align-items:center;gap:0.75rem;background:rgba(234,226,216,0.12);border:1px solid rgba(234,226,216,0.25);border-radius:9999px;padding:0.4rem 1.1rem;margin-bottom:1.5rem;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#EAE2D8;display:inline-block;"></span>
                    <span style="font-size:0.725rem;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:#EAE2D8;">Custom Clothing Studio</span>
                </div>

                <h1 style="font-size:clamp(2.75rem,5vw,4.5rem);font-weight:900;color:#FFFFFF;line-height:1.1;letter-spacing:-0.025em;">
                    Find Your<br>
                    <span style="background:linear-gradient(135deg, #FFFFFF 0%, #EAE2D8 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Perfect Fit</span>
                </h1>

                <p style="margin-top:1.5rem;font-size:1.0625rem;line-height:1.75;color:rgba(233,228,224,0.85);max-width:480px;">
                    Pakaian custom berkualitas tinggi dengan teknologi virtual fitting 3D. Pilih produk, sesuaikan ukuran, dan pesan langsung ke tim kami.
                </p>

                <div style="margin-top:2.5rem;display:flex;flex-wrap:wrap;gap:1.25rem;align-items:center;">
                    <a
                        href="{{ route('collection.index') }}"
                        class="hero-collection-action"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;min-height:3.25rem;padding:0.75rem 2rem;background:linear-gradient(135deg, #FAF8F5 0%, #EAE2D8 100%);color:#172A39 !important;border:2px solid #EAE2D8;border-radius:9999px;font-size:0.875rem;font-weight:800;letter-spacing:0.04em;text-decoration:none;box-shadow:0 8px 24px rgba(0,0,0,0.3),0 0 0 4px rgba(234,226,216,0.25);transition:all 0.15s;"
                    >
                        Lihat Koleksi
                    </a>
                    <a
                        href="{{ route('virtual-fitting') }}"
                        style="display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;min-height:3.25rem;padding:0.75rem 1.5rem;background:rgba(255,255,255,0.08);color:#FFFFFF !important;border:1.5px solid rgba(233,228,224,0.6);border-radius:9999px;font-size:0.875rem;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(0,0,0,0.15);transition:all 0.15s;"
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
                            <svg width="16" height="16" style="color:#EAE2D8;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span style="font-size:0.8125rem;color:rgba(233,228,224,0.85);font-weight:600;">{{ $f }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Right: Hero Image (Anti-Mainstream Couture Arch Silhouette with Layered Accents) ── --}}
            <div class="hidden lg:flex justify-end relative items-center">
                @php
                    use App\Support\CustomerMedia;
                    $heroImgUrl = $heroImageUrl ?? ($featuredProduct ? CustomerMedia::productImageUrl($featuredProduct) : null);
                @endphp
                @if ($heroImgUrl)
                    <div style="position:relative;width:100%;max-width:580px;aspect-ratio:3/4;display:flex;align-items:center;justify-content:center;z-index:2;">
                        
                        {{-- Decorative Offset Outline Frame --}}
                        <div style="position:absolute;inset:-15px;border-radius:20rem 3rem 18rem 3rem;border:1.5px dashed rgba(234,226,216,0.45);transform:rotate(-3deg);pointer-events:none;z-index:1;"></div>

                        {{-- Main Couture Arch Image Container --}}
                        <div style="position:relative;width:100%;height:100%;border-radius:20rem 3rem 18rem 3rem;overflow:hidden;box-shadow:0 35px 80px -10px rgba(23,42,57,0.45),0 0 0 2px rgba(255,255,255,0.2);z-index:2;background:#EAE2D8;">
                            <img
                                src="{{ $heroImgUrl }}"
                                alt="Clothiq Collection"
                                style="width:100%;height:100%;object-fit:cover;transform:scale(1.05);display:block;"
                            >
                        </div>

                    </div>
                @else
                    <div style="aspect-ratio:3/4;width:100%;max-width:540px;background:rgba(255,255,255,0.05);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1rem;">
                        <p style="color:rgba(233,228,224,0.4);font-size:0.875rem;">Clothiq Collection</p>
                    </div>
                @endif
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        VALUE PROPOSITIONS (Premium, Modern, Certified — Direct on Cream Background)
    ═══════════════════════════════════════════ --}}
    <section style="background:#FAF8F5;border-bottom:1px solid #DCD6D0;padding:5rem 0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="value-props-container" style="display:grid;grid-template-columns:repeat(3, minmax(0, 1fr));gap:3rem;width:100%;align-items:start;">
                
                {{-- Item 1: Premium --}}
                <div style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:0.5rem 1rem;">
                    <div style="display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:#172A39;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1.375rem;font-weight:900;color:#172A39;letter-spacing:-0.02em;">Premium</h3>
                    <p style="font-size:0.9375rem;line-height:1.7;color:#555E68;margin-top:0.75rem;max-width:340px;">
                        Bahan premium memberi kesan profesional sejak pandangan pertama, nyaman dipakai dan percaya diri.
                    </p>
                </div>

                {{-- Item 2: Modern --}}
                <div style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:0.5rem 1rem;">
                    <div style="display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:#172A39;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12l4 6-10 12L2 9l4-6z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 9h20M12 21L8 9l4-6 4 6-4 12z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1.375rem;font-weight:900;color:#172A39;letter-spacing:-0.02em;">Modern</h3>
                    <p style="font-size:0.9375rem;line-height:1.7;color:#555E68;margin-top:0.75rem;max-width:340px;">
                        Menggunakan mesin paling mutakhir sehingga menghasilkan produk berkualitas dan presisi tinggi.
                    </p>
                </div>

                {{-- Item 3: Certified --}}
                <div style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:0.5rem 1rem;">
                    <div style="display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:#172A39;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1.375rem;font-weight:900;color:#172A39;letter-spacing:-0.02em;">Certified</h3>
                    <p style="font-size:0.9375rem;line-height:1.7;color:#555E68;margin-top:0.75rem;max-width:340px;">
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
                gap: 2.25rem !important;
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
                        <span style="width:1.5rem;height:3px;background:#172A39;border-radius:2px;display:inline-block;"></span>
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
                        <a href="{{ route('about') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;font-size:0.875rem;font-weight:800;border-radius:9999px;text-decoration:none;">
                            Kisah Lengkap Clothiq
                        </a>
                        <a href="{{ route('order.create') }}" class="btn-outline" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 1.75rem;font-size:0.875rem;font-weight:800;border-radius:9999px;text-decoration:none;">
                            Konsultasi Custom
                        </a>
                    </div>
                </div>

                {{-- Right Column: Brand Highlights & Pillar Cards --}}
                <div class="lg:col-span-5">
                    <div style="background:#FAF8F5;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2.25rem;display:flex;flex-direction:column;gap:1.5rem;box-shadow:0 6px 20px rgba(23,42,57,0.04);">
                        
                        <div style="display:flex;align-items:flex-start;gap:1rem;">
                            <div style="width:3rem;height:3rem;border-radius:0.875rem;background:#172A39;color:#EAE2D8;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
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
                            <div style="width:3rem;height:3rem;border-radius:0.875rem;background:#172A39;color:#EAE2D8;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
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
                            <div style="width:3rem;height:3rem;border-radius:0.875rem;background:#172A39;color:#EAE2D8;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
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
        CATEGORY SHOWCASE (Koleksi Kategori Pilihan Terbaik)
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
                            <span style="width:1.5rem;height:3px;background:#172A39;border-radius:2px;display:inline-block;"></span>
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
                        style="display:inline-flex;align-items:center;gap:0.625rem;padding:1rem 2rem;font-size:0.9375rem;font-weight:800;border-radius:9999px;text-decoration:none;align-self:flex-start;md:align-self:auto;box-shadow:0 6px 20px rgba(23,42,57,0.2);"
                    >
                        View Collection
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
                            <div style="position:relative;width:100%;aspect-ratio:4/5;border-radius:1.75rem;overflow:hidden;background:#FAF8F5;border:2px solid #DCD6D0;box-shadow:0 10px 30px rgba(23,42,57,0.06);transition:all 0.3s ease;" onmouseover="this.style.borderColor='#172A39';this.style.boxShadow='0 20px 44px rgba(23,42,57,0.14)'" onmouseout="this.style.borderColor='#DCD6D0';this.style.boxShadow='0 10px 30px rgba(23,42,57,0.06)'">
                                
                                {{-- Action button on bottom right --}}
                                <div style="position:absolute;bottom:1.25rem;right:1.25rem;z-index:10;background:linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%);color:#FFFFFF;padding:0.5rem 1.125rem;border-radius:9999px;font-size:0.8125rem;font-weight:800;letter-spacing:0.04em;display:flex;align-items:center;gap:0.375rem;box-shadow:0 8px 22px rgba(23,42,57,0.35);transition:all 0.2s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
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
                                    <p style="margin-top:0.35rem;font-size:1.0625rem;font-weight:900;color:#172A39;">
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
        LAYANAN & SOLUSI PRODUKSI APPAREL — 2x2 Grid (Left-Aligned, Centered Container)
    ═══════════════════════════════════════════ --}}
    <section style="background:#172A39;padding:5.5rem 0;">
        <div class="mx-auto max-w-5xl px-6 lg:px-8">
            <div class="text-center" style="margin-bottom:4.5rem;">
                <span style="display:inline-flex;align-items:center;gap:0.5rem;color:#EAE2D8;font-size:0.6875rem;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;margin-bottom:0.75rem;">
                    <span style="width:1.25rem;height:2.5px;background:#EAE2D8;border-radius:2px;display:inline-block;"></span>
                    Layanan Produksi
                    <span style="width:1.25rem;height:2.5px;background:#EAE2D8;border-radius:2px;display:inline-block;"></span>
                </span>
                <h2 style="font-size:clamp(1.625rem, 3.5vw, 2.125rem);font-weight:900;color:#FFFFFF;letter-spacing:-0.025em;margin-top:0.35rem;line-height:1.25;">
                    Solusi Pakaian Custom untuk Berbagai Kebutuhan
                </h2>
            </div>

            {{-- 2x2 Grid with left alignment and balanced spacing --}}
            <div class="services-2x2-grid" style="display:grid;grid-template-columns:repeat(2, minmax(0, 1fr));column-gap:5.5rem;row-gap:4rem;">
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
                    <div style="display:flex;flex-direction:column;text-align:left;">
                        <div style="display:inline-flex;align-items:center;margin-bottom:1rem;">
                            <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:#EAE2D8;flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 style="font-size:1.15rem;font-weight:800;color:#FFFFFF;margin-bottom:0.5rem;line-height:1.35;letter-spacing:-0.01em;">{{ $s['title'] }}</h3>
                        <p style="font-size:0.8125rem;line-height:1.65;color:rgba(233,228,224,0.75);max-width:400px;">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        @media (max-width: 767px) {
            .services-2x2-grid {
                grid-template-columns: 1fr !important;
                row-gap: 2.5rem !important;
            }
        }
    </style>


    {{-- ═══════════════════════════════════════════
        VIRTUAL FITTING CTA
    ═══════════════════════════════════════════ --}}
    <section style="background:linear-gradient(135deg, #FAF8F5 0%, #EAE2D8 100%);padding:4.5rem 0;border-bottom:1px solid #DCD6D0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 items-center">
                
                {{-- Left Text --}}
                <div>
                    <p style="font-size:0.75rem;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:#172A39;margin-bottom:0.75rem;">Studio Interaktif</p>
                    <h2 style="font-size:clamp(2rem, 3.5vw, 2.5rem);font-weight:900;color:#172A39;line-height:1.15;letter-spacing:-0.025em;">
                        Coba Virtual<br>Fitting Sekarang
                    </h2>
                    <p style="margin-top:1rem;font-size:0.9375rem;color:#555E68;line-height:1.7;max-width:480px;">
                        Pilih produk, sesuaikan profil ukuran tubuhmu, lalu amati preview pakaian dalam tampilan 3D sebelum mengirim request ke tim kami.
                    </p>
                    <div style="margin-top:2rem;">
                        <a href="{{ route('virtual-fitting') }}" class="btn-primary" style="display:inline-flex;align-items:center;justify-content:center;gap:0.625rem;padding:0.875rem 2rem;font-size:0.875rem;font-weight:800;border-radius:9999px;text-decoration:none;box-shadow:0 6px 20px rgba(23,42,57,0.25);">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.847v6.306a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            Buka Virtual Fitting
                        </a>
                    </div>
                </div>

                {{-- Right Image Frame (Anti-Mainstream Couture Arch with Layered Tailor Outline) --}}
                <div class="flex justify-center lg:justify-end relative items-center">
                    <div style="position:relative;width:100%;max-width:540px;aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;z-index:2;">
                        
                        {{-- Decorative Dashed Tailor Stitch Frame --}}
                        <div style="position:absolute;inset:-12px;border-radius:3rem 16rem 3rem 16rem;border:1.5px dashed rgba(23,42,57,0.25);transform:rotate(2.5deg);pointer-events:none;z-index:1;"></div>

                        {{-- Main Asymmetric Couture Image Container --}}
                        <div style="position:relative;width:100%;height:100%;border-radius:3rem 16rem 3rem 16rem;overflow:hidden;border:2px solid #FFFFFF;box-shadow:0 25px 60px -12px rgba(23,42,57,0.18),0 4px 16px rgba(23,42,57,0.06);background:#EAE2D8;z-index:2;">
                            <img
                                src="{{ asset('images/virtual-fitting-teaser.jpg') }}?v=11"
                                alt="Clothiq 3D Virtual Fitting Studio - Custom Work Jacket"
                                style="width:100%;height:100%;object-fit:cover;object-position:center 30%;display:block;"
                                loading="lazy"
                            >
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        FAQ SECTION
    ═══════════════════════════════════════════ --}}
    <section style="background:#FFFFFF;padding:6rem 0;border-bottom:1px solid #DCD6D0;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 items-start">
                
                {{-- Left: FAQ Info & WhatsApp CTA --}}
                <div class="lg:col-span-5">
                    <span class="section-badge mb-3" style="color:#172A39;">
                        <span style="width:1.35rem;height:2.5px;background:#172A39;border-radius:2px;display:inline-block;"></span>
                        Frequently Asked Questions
                    </span>
                    <h2 style="font-size:2.25rem;font-weight:900;color:#172A39;letter-spacing:-0.025em;line-height:1.2;">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                    <p style="margin-top:1rem;font-size:0.9375rem;color:#555E68;line-height:1.7;max-width:420px;">
                        Punya pertanyaan seputar proses pemesanan, simulasi Virtual Fitting 3D, atau bahan pakaian? Temukan jawabannya di sini.
                    </p>

                    @php
                        $waNum = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
                        $waUrl = $waNum ? 'https://wa.me/'.$waNum.'?text='.rawurlencode('Halo Clothiq, saya ingin bertanya seputar pemesanan custom clothing.') : 'https://wa.me/6281234567890';
                    @endphp

                    <div style="margin-top:2.5rem;padding:1.75rem;background:#FAF8F5;border:1.5px solid #DCD6D0;border-radius:1.25rem;max-width:420px;">
                        <h3 style="font-size:1.0625rem;font-weight:800;color:#172A39;">Masih punya pertanyaan lain?</h3>
                        <p style="font-size:0.8125rem;color:#6E7575;line-height:1.65;margin-top:0.35rem;">
                            Tim konsultan Clothiq siap membantu Anda mendiskusikan kebutuhan pakaian custom, katalog bahan, dan penawaran terbaik.
                        </p>
                        <a
                            href="{{ $waUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            style="margin-top:1.25rem;display:inline-flex;align-items:center;gap:0.5rem;background:#172A39;color:#FFFFFF;padding:0.625rem 1.25rem;font-size:0.8125rem;font-weight:800;border-radius:9999px;text-decoration:none;transition:all 0.15s;box-shadow:0 4px 12px rgba(23,42,57,0.15);"
                            onmouseover="this.style.background='#0E1B25';this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.background='#172A39';this.style.transform='translateY(0)'"
                        >
                            <span>Tanya via WhatsApp</span>
                        </a>
                    </div>
                </div>

                {{-- Right: Accordion Items --}}
                <div class="lg:col-span-7">
                    @php
                        $faqs = [
                            [
                                'q' => 'Berapa minimal kuantitas pemesanan (MOQ) di Clothiq?',
                                'a' => 'Kami melayani pesanan fleksibel mulai dari partai kecil (minimal 12 pcs) hingga skala besar ribuan pcs untuk komunitas, organisasi, instansi, kampus, maupun clothing brand.',
                            ],
                            [
                                'q' => 'Bagaimana cara kerja fitur Virtual Fitting 3D?',
                                'a' => 'Anda cukup memasukkan parameter ukuran tubuh (tinggi badan, berat, lingkar dada, lingkar pinggang, dan lingkar pinggul) di halaman Virtual Fitting. Sistem kami akan mensimulasikan fitting pakaian secara 3D interaktif dan merekomendasikan ukuran yang paling akurat.',
                            ],
                            [
                                'q' => 'Apakah saya bisa mengajukan desain dan bahan kustom sendiri?',
                                'a' => 'Tentu saja! Anda dapat memilih bahan premium dari katalog kami, serta mengunggah file desain custom, logo bordir komputer, maupun sablon (DTF, Rubber, Plastisol, Sublimasi) melalui form Request Order.',
                            ],
                            [
                                'q' => 'Berapa lama estimasi waktu produksi?',
                                'a' => 'Estimasi waktu produksi standar adalah 7 hingga 14 hari kerja setelah approval mock-up dan konfirmasi pembayaran uang muka (DP). Untuk kebutuhan mendesak / deadline khusus, silakan konsultasikan dengan tim kami.',
                            ],
                            [
                                'q' => 'Bagaimana proses pembayaran dan pengiriman barang?',
                                'a' => 'Setelah Anda mengirimkan Request Order, tim kami akan mengonfirmasi total biaya via WhatsApp. Pembayaran dilakukan dengan sistem DP di awal dan pelunasan saat pesanan selesai sebelum dikirim melalui ekspedisi terpercaya ke seluruh Indonesia.',
                            ],
                        ];
                    @endphp

                    <div style="display:flex;flex-direction:column;gap:0.75rem;">
                        @foreach ($faqs as $index => $faq)
                            <details
                                class="faq-item"
                                style="background:#FAF8F5;border:1.5px solid #DCD6D0;border-radius:1rem;padding:1.25rem 1.5rem;transition:all 0.2s ease;"
                                {{ $index === 0 ? 'open' : '' }}
                            >
                                <summary style="display:flex;align-items:center;justify-content:space-between;font-size:1.0625rem;font-weight:800;color:#172A39;cursor:pointer;list-style:none;gap:1rem;user-select:none;">
                                    <span>{{ $faq['q'] }}</span>
                                    <span class="faq-icon">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </span>
                                </summary>
                                <div style="margin-top:1rem;padding-top:0.875rem;border-top:1px solid #EAE2D8;font-size:0.875rem;line-height:1.75;color:#555E68;">
                                    {{ $faq['a'] }}
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════
        CUSTOMER TESTIMONIALS SECTION (Interactive Slider)
    ═══════════════════════════════════════════ --}}
    <section style="background:#FAF8F5;padding:6rem 0;border-bottom:1px solid #DCD6D0;overflow:hidden;">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            
            {{-- Header with Slider Navigation Controls --}}
            <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:2rem;margin-bottom:3.5rem;">
                <div style="max-width:620px;">
                    <span class="section-badge mb-3" style="color:#172A39;">
                        Client Experiences • Cerita Pelanggan
                    </span>
                    <h2 style="font-size:clamp(2.25rem, 4vw, 3.25rem);font-weight:900;color:#172A39;letter-spacing:-0.03em;line-height:1.15;">
                        Kepuasan Klien Adalah Standar Kami
                    </h2>
                    <p style="margin-top:1rem;font-size:1rem;color:#555E68;line-height:1.7;">
                        Dengarkan cerita langsung dari komunitas, brand, dan tim kreatif yang telah mempercayakan produksi pakaian custom mereka kepada Clothiq.
                    </p>
                </div>

                {{-- Carousel Prev / Next Controls --}}
                <div style="display:flex;align-items:center;gap:0.75rem;">
                    <button
                        type="button"
                        id="testimonial-prev-btn"
                        aria-label="Previous Testimonials"
                        style="width:3.25rem;height:3.25rem;border-radius:9999px;background:#FFFFFF;border:1.5px solid #DCD6D0;color:#172A39;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s cubic-bezier(0.16, 1, 0.3, 1);box-shadow:0 4px 12px rgba(23,42,57,0.06);"
                        onmouseover="this.style.background='#172A39';this.style.borderColor='#172A39';this.style.color='#FFFFFF';this.style.transform='translateX(-2px)';"
                        onmouseout="this.style.background='#FFFFFF';this.style.borderColor='#DCD6D0';this.style.color='#172A39';this.style.transform='translateX(0)';"
                    >
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        id="testimonial-next-btn"
                        aria-label="Next Testimonials"
                        style="width:3.25rem;height:3.25rem;border-radius:9999px;background:#172A39;border:1.5px solid #172A39;color:#FFFFFF;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s cubic-bezier(0.16, 1, 0.3, 1);box-shadow:0 6px 16px rgba(23,42,57,0.2);"
                        onmouseover="this.style.background='#0E1B25';this.style.transform='translateX(2px)';"
                        onmouseout="this.style.background='#172A39';this.style.transform='translateX(0)';"
                    >
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Horizontal Testimonial Carousel Track --}}
            <div
                id="testimonial-carousel-track"
                style="display:flex;gap:1.75rem;overflow-x:auto;scroll-snap-type:x mandatory;scroll-behavior:smooth;padding:0.75rem 0.25rem 1.5rem;scrollbar-width:none;-ms-overflow-style:none;-webkit-overflow-scrolling:touch;cursor:grab;"
            >
                @php
                    $testimonials = [
                        [
                            'name' => 'Bagus Pratama',
                            'role' => 'Head of Creative, Studio Karsa',
                            'order' => 'Custom Work Jacket (50 pcs)',
                            'tag' => 'Work Jacket Custom',
                            'avatar_bg' => '#172A39',
                            'avatar_text' => 'BP',
                            'quote' => 'Hasil jahitannya luar biasa rapi dan presisi. Fitur Virtual Fitting 3D sangat membantu tim kami dalam menentukan size chart tanpa harus coba fitting sampel fisik berulang kali.',
                        ],
                        [
                            'name' => 'Alika Salsabila',
                            'role' => 'Community Lead, Urban Runners ID',
                            'order' => 'Windbreaker & Technical Gear (120 pcs)',
                            'tag' => 'Windbreaker Series',
                            'avatar_bg' => '#2A4356',
                            'avatar_text' => 'AS',
                            'quote' => 'Kualitas material kain dan bordirnya jauh di atas ekspektasi. Warna kain konsisten, bahannya nyaman untuk aktivitas outdoor, dan proses konsultasi dengan tim Clothiq sangat cepat.',
                        ],
                        [
                            'name' => 'Dimas Arya Nugraha',
                            'role' => 'Founder, Niscala Apparel',
                            'order' => 'Heavyweight Cotton Hoodie (85 pcs)',
                            'tag' => 'Heavyweight Hoodie',
                            'avatar_bg' => '#1E3345',
                            'avatar_text' => 'DA',
                            'quote' => 'Clothiq benar-benar atelier standar tinggi. Pola potongan jatuhnya pas di badan, detail stitching kuat, dan timnya sangat profesional dari awal diskusi hingga pesanan tiba.',
                        ],
                        [
                            'name' => 'Jessica Tandiono',
                            'role' => 'Project Director, Arkana Agency',
                            'order' => 'Varsity Jacket Edition (40 pcs)',
                            'tag' => 'Varsity Edition',
                            'avatar_bg' => '#172A39',
                            'avatar_text' => 'JT',
                            'quote' => 'Bahan wool blend dan detail kulit sintetis pada varsity jacket pesanan kami terasa sangat mewah. Semua anggota tim sangat puas dengan hasil jadinya yang eksklusif.',
                        ],
                        [
                            'name' => 'Rian Hidayat',
                            'role' => 'Captain, Garuda Basketball Club',
                            'order' => 'Technical Jersey & Warm-Up (60 pcs)',
                            'tag' => 'Technical Jersey',
                            'avatar_bg' => '#2A4356',
                            'avatar_text' => 'RH',
                            'quote' => 'Bahan jersey menyerap keringat dengan sangat baik, sablon dan bordir emblem tim rapi dan tahan cuci berkali-kali. Recommended untuk kebutuhan tim olahraga.',
                        ],
                        [
                            'name' => 'Fikri Ramadhan',
                            'role' => 'Event Organizer, Tech Innovators',
                            'order' => 'Commuter Oversized Tees (250 pcs)',
                            'tag' => 'Oversized Tees',
                            'avatar_bg' => '#1E3345',
                            'avatar_text' => 'FR',
                            'quote' => 'Kain cotton combed 24s heavy grade terasa sangat tebal namun tetap adem. Potongan pola oversized-nya modern dan fitting-nya konsisten untuk ratusan anggota panitia.',
                        ],
                    ];
                @endphp

                @foreach($testimonials as $t)
                    <div
                        class="testimonial-slide-card"
                        style="flex:0 0 380px;max-width:85vw;scroll-snap-align:start;background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2.25rem;display:flex;flex-direction:column;justify-content:space-between;box-shadow:0 8px 24px rgba(23,42,57,0.04);transition:all 0.3s cubic-bezier(0.16, 1, 0.3, 1);user-select:none;"
                        onmouseover="this.style.transform='translateY(-6px)';this.style.borderColor='#172A39';this.style.boxShadow='0 18px 40px rgba(23,42,57,0.12)';"
                        onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#DCD6D0';this.style.boxShadow='0 8px 24px rgba(23,42,57,0.04)';"
                    >
                        <div>
                            {{-- Top: Rating Stars & Order Tag --}}
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.25rem;">
                                {{-- 5 Stars Gold --}}
                                <div style="display:flex;gap:0.25rem;color:#D5A755;">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span style="font-size:0.6875rem;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;color:#172A39;background:#FAF8F5;border:1px solid #DCD6D0;border-radius:9999px;padding:0.25rem 0.75rem;">
                                    {{ $t['tag'] }}
                                </span>
                            </div>

                            {{-- Quote Content --}}
                            <p style="font-size:0.9375rem;line-height:1.75;color:#172A39;font-weight:500;margin:0 0 1.75rem;">
                                “{{ $t['quote'] }}”
                            </p>
                        </div>

                        {{-- Client Info Footer --}}
                        <div style="display:flex;align-items:center;gap:0.875rem;padding-top:1.25rem;border-top:1px solid #EAE2D8;">
                            <div style="width:2.75rem;height:2.75rem;border-radius:50%;background:{{ $t['avatar_bg'] }};color:#FFFFFF;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.875rem;flex-shrink:0;box-shadow:0 4px 10px rgba(23,42,57,0.15);">
                                {{ $t['avatar_text'] }}
                            </div>
                            <div>
                                <h3 style="font-size:0.9375rem;font-weight:800;color:#172A39;margin:0;">
                                    {{ $t['name'] }}
                                </h3>
                                <p style="font-size:0.75rem;color:#6E7575;margin:0.125rem 0 0;">
                                    {{ $t['role'] }}
                                </p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const track = document.getElementById('testimonial-carousel-track');
            const prevBtn = document.getElementById('testimonial-prev-btn');
            const nextBtn = document.getElementById('testimonial-next-btn');

            if (!track || !prevBtn || !nextBtn) return;

            const getScrollAmount = () => {
                const card = track.querySelector('.testimonial-slide-card');
                return card ? card.offsetWidth + 28 : 400;
            };

            prevBtn.addEventListener('click', () => {
                track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
            });

            nextBtn.addEventListener('click', () => {
                track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
            });

            // Drag to scroll functionality for desktop
            let isDown = false;
            let startX;
            let scrollLeft;

            track.addEventListener('mousedown', (e) => {
                isDown = true;
                track.style.cursor = 'grabbing';
                startX = e.pageX - track.offsetLeft;
                scrollLeft = track.scrollLeft;
            });

            track.addEventListener('mouseleave', () => {
                isDown = false;
                track.style.cursor = 'grab';
            });

            track.addEventListener('mouseup', () => {
                isDown = false;
                track.style.cursor = 'grab';
            });

            track.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - track.offsetLeft;
                const walk = (x - startX) * 1.5;
                track.scrollLeft = scrollLeft - walk;
            });
        });
    </script>

    <style>
        .faq-icon {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 9999px;
            background: #FFFFFF;
            border: 1.5px solid #DCD6D0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #172A39;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .faq-icon svg {
            stroke: currentColor;
            transition: stroke 0.2s ease;
        }
        details.faq-item summary::-webkit-details-marker,
        details.faq-item summary::marker {
            display: none;
            content: "";
        }
        details.faq-item[open] {
            border-color: #172A39 !important;
            background: #FFFFFF !important;
            box-shadow: 0 8px 24px rgba(23,42,57,0.06);
        }
        details.faq-item[open] .faq-icon {
            transform: rotate(180deg);
            background: #172A39 !important;
            border-color: #172A39 !important;
            color: #FFFFFF !important;
        }
        details.faq-item[open] .faq-icon svg {
            color: #FFFFFF !important;
            stroke: #FFFFFF !important;
        }
    </style>

@endsection
