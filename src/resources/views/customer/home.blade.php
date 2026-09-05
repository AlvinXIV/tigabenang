@extends('layouts.customer')

@section('title', 'FitVendor. Pakaian custom')
@section('description', 'Pesan pakaian sesuai kebutuhan tim, komunitas, acara, atau brand Anda.')

@section('content')

    @php
        use App\Support\CustomerMedia;
        $heroImgUrl = asset('images/hero-banner.jpg');
    @endphp

    <style>
        #main-navbar {
            border-bottom: none !important;
            box-shadow: none !important;
        }
        .fv-home-hero-wrap {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }
        .fv-home-hero {
            min-height: 720px !important;
            height: clamp(640px, 58vw, 860px) !important;
            max-height: 920px !important;
        }
        .fv-home-hero__content {
            padding-bottom: 84px !important;
        }
        @media (min-width: 1024px) {
            .fv-home-hero {
                min-height: 800px !important;
                height: 840px !important;
            }
            .fv-home-hero__content {
                padding-bottom: 110px !important;
            }
        }
    </style>

    <div class="bg-white pt-4 pb-12 sm:pb-16 lg:pb-24">
        <section class="fv-home-hero-wrap" aria-label="Pengantar FitVendor">
            <div class="fv-home-hero">
                @if ($heroImgUrl)
                    <img
                        src="{{ $heroImgUrl }}"
                        alt="Koleksi FitVendor"
                        class="fv-home-hero__image"
                        fetchpriority="high"
                        decoding="async"
                    >
                @endif
                <div class="fv-home-hero__overlay" aria-hidden="true"></div>

                <div class="fv-home-hero__content">
                    <div class="fv-home-hero__copy">
                        <h1>
                            <span>Pesan pakaian custom</span>
                            <span>untuk kebutuhan Anda</span>
                        </h1>
                        <p>
                            Pesan pakaian untuk tim, komunitas, acara, atau kebutuhan brand dengan pilihan bahan dan ukuran yang dapat disesuaikan.
                        </p>
                        <div class="fv-home-hero__actions">
                            <a href="{{ route('order.create') }}" class="fv-home-hero__cta">Pesan custom</a>
                            <a href="{{ route('virtual-fitting') }}" class="fv-home-hero__cta-secondary">Coba virtual fitting</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="bg-white pt-6 pb-24 sm:pt-8 sm:pb-28 lg:pt-12 lg:pb-36">
        <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3 md:gap-6">
                <article class="fv-icon-card text-center">
                    <div class="fv-icon-wrap mx-auto" aria-hidden="true">
                        <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h10M4 17h7M19 10v8m0 0-2.5-2.5M19 18l2.5-2.5"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-[#102A43]">Bahan terukur</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                        Pilih kain dari katalog yang sama dengan stok produksi, bukan spek yang dibuat-buat.
                    </p>
                </article>

                <article class="fv-icon-card text-center">
                    <div class="fv-icon-wrap mx-auto" aria-hidden="true">
                        <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 14 10m0 0 2.5-2.5a3.5 3.5 0 1 0-5-5L9 5m5 5-5-5m-3.5 8.5 1.5 1.5M7 19l-3 1 1-3"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-[#102A43]">Jahitan rapi</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                        Pola dan produksi dikerjakan per pesanan supaya hasilnya konsisten untuk tim Anda.
                    </p>
                </article>

                <article class="fv-icon-card text-center">
                    <div class="fv-icon-wrap mx-auto" aria-hidden="true">
                        <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6a2 2 0 0 1 2 2v12l-5-2-5 2V7a2 2 0 0 1 2-2Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 10h5M9.5 13.5h3.5"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-[#102A43]">Proses jelas</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                        Kirim permintaan, bahas harga di WhatsApp, lalu produksi berjalan setelah konfirmasi.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="bg-[#F7F7F5] py-16 sm:py-20 lg:py-24">
        <div class="mx-auto grid max-w-[1200px] items-center gap-10 px-5 lg:grid-cols-2 lg:px-8">
            <div>
                <span class="section-badge mb-3">Tentang kami</span>
                <h2 class="mt-2 text-[clamp(1.75rem,3vw,2.25rem)] font-bold leading-tight text-[#102A43]">
                    7+ tahun memproduksi pakaian custom berkualitas
                </h2>
                <div class="mt-5 space-y-3 text-sm leading-relaxed text-[#667085]">
                    <p>
                        <strong class="font-semibold text-[#102A43]">FitVendor</strong> adalah konveksi garmen berbasis di Bandung dengan pengalaman lebih dari 7 tahun. Kami dipercaya ratusan komunitas, kampus, dan brand untuk memproduksi jaket, kemeja, jersey, hingga seragam kerja.
                    </p>
                    <p>
                        Dengan meja potong mandiri dan penjahit ahli, setiap pesanan dikerjakan dengan bahan pilihan, pola proporsional, dan proses produksi yang transparan.
                    </p>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-3 border-y border-[#E2E5E9] py-3.5">
                    <div>
                        <p class="text-base font-bold text-[#102A43] sm:text-lg">7+ Tahun</p>
                        <p class="text-[11px] text-[#667085] sm:text-xs">Pengalaman garmen</p>
                    </div>
                    <div>
                        <p class="text-base font-bold text-[#102A43] sm:text-lg">50.000+</p>
                        <p class="text-[11px] text-[#667085] sm:text-xs">Pcs diproduksi</p>
                    </div>
                    <div>
                        <p class="text-base font-bold text-[#102A43] sm:text-lg">300+</p>
                        <p class="text-[11px] text-[#667085] sm:text-xs">Mitra & komunitas</p>
                    </div>
                </div>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('about') }}" class="btn-primary">Profil perusahaan</a>
                    <a href="{{ route('order.create') }}" class="btn-outline">Konsultasi pesanan</a>
                </div>
            </div>
            <div class="fv-media aspect-[4/3] shadow-sm">
                <img
                    src="{{ asset('images/about-production.jpg') }}"
                    alt="Proses jahit dan produksi pakaian custom FitVendor"
                    class="h-full w-full object-cover"
                    loading="lazy"
                >
            </div>
        </div>
    </section>

    @php
        $showcaseItems = $categoryShowcase ?? collect([]);
    @endphp

    @if ($showcaseItems->isNotEmpty())
        <section class="border-y border-[#E2E5E9] bg-white py-16 sm:py-20 lg:py-24">
            <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
                <div class="mb-10 flex flex-col justify-between gap-5 md:flex-row md:items-end">
                    <div>
                        <span class="section-badge mb-3">Karya kami</span>
                        <h2 class="mt-1 text-[clamp(1.75rem,3vw,2.5rem)] font-bold text-[#102A43]">
                            Pilihan kategori
                        </h2>
                        <p class="mt-2 max-w-xl text-sm text-[#667085]">
                            Lihat contoh produk per kategori. Harga di kartu adalah harga mulai, belum termasuk negosiasi produksi.
                        </p>
                    </div>
                    <a href="{{ route('collection.index') }}" class="btn-primary self-start">Lihat koleksi</a>
                </div>

                <div class="category-showcase-grid grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($showcaseItems as $item)
                        @php
                            $cat = $item['category'];
                            $prod = $item['product'];
                            $catSlug = \Illuminate\Support\Str::slug($cat->nama_kategori);
                            $catUrl = route('collection.index', ['category' => $catSlug]);
                            $imgUrl = $prod ? CustomerMedia::productImageUrl($prod) : null;
                        @endphp
                        <a href="{{ $catUrl }}" class="group block no-underline">
                            <div class="fv-media relative aspect-[4/5]">
                                @if ($imgUrl)
                                    <img
                                        src="{{ $imgUrl }}"
                                        alt="{{ $prod ? $prod->nama_produk : \App\Support\CustomerCatalog::categoryLabel($cat->nama_kategori) }}"
                                        width="600"
                                        height="750"
                                        loading="lazy"
                                        decoding="async"
                                        class="absolute inset-0 h-full w-full object-cover"
                                    >
                                @endif
                                <span class="absolute bottom-4 right-4 inline-flex items-center gap-1.5 rounded-xl bg-[#102A43] px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition-all duration-200 group-hover:bg-[#1C3D5A]">
                                    <span>Lihat kategori</span>
                                    <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-3">
                                <h3 class="text-lg font-bold text-[#102A43]">{{ \App\Support\CustomerCatalog::categoryLabel($cat->nama_kategori) }}</h3>
                                @if ($prod)
                                    <p class="mt-1 font-bold text-[#102A43]"><x-price :amount="$prod->harga" /></p>
                                    <span class="hidden" data-product="{{ $prod->nama_produk }}">{{ $prod->nama_produk }}</span>
                                @else
                                    <p class="mt-1 text-sm text-[#667085]">Pakaian custom</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section
        class="fv-services border-y border-[#E2E5E9]"
        style="background-image: linear-gradient(180deg, rgba(247, 247, 245, 0.93) 0%, rgba(247, 247, 245, 0.88) 50%, rgba(247, 247, 245, 0.95) 100%), url('{{ asset('images/bgproduksi.jpg') }}'); background-size: cover; background-position: center;"
    >
        <div class="fv-services__inner">
            <div class="fv-services__intro">
                <span class="section-badge mb-3">Layanan produksi</span>
                <h2 class="fv-services__title mt-1">
                    Pesanan custom untuk berbagai kebutuhan
                </h2>
                <p class="fv-services__lead">
                    Pilihan produksi pakaian berkualitas sesuai kebutuhan tim dan organisasi Anda.
                </p>
            </div>
            <div class="fv-services__grid">
                @php
                    $services = [
                        ['title' => 'Jaket dan outerwear angkatan', 'desc' => 'Varsity, windbreaker, work jacket, dan hoodie dengan bordir atau sablon sesuai identitas tim.', 'icon' => 'jacket'],
                        ['title' => 'Seragam kerja dan organisasi', 'desc' => 'Kemeja PDH/PDL, rompi, dan polo untuk aktivitas kantor atau lapangan.', 'icon' => 'shirt'],
                        ['title' => 'Jersey dan sportswear', 'desc' => 'Jersey tim dengan kain dry-fit dan cetak yang tahan dipakai latihan.', 'icon' => 'sport'],
                        ['title' => 'Kaos event dan merchandise', 'desc' => 'Kaos cotton combed untuk acara, panitia, atau clothing line.', 'icon' => 'tee'],
                    ];
                @endphp
                @foreach ($services as $s)
                    <div class="fv-services__item">
                        <div class="fv-services__icon" aria-hidden="true">
                            @if ($s['icon'] === 'jacket')
                                <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 4 4 7v13h5v-6h6v6h5V7l-4-3-3 3-3-3Z"/>
                                </svg>
                            @elseif ($s['icon'] === 'shirt')
                                <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5 4 8v3h3v8h10v-8h3V8l-4-3-2 2.5L12 7l-2 .5L8 5Z"/>
                                </svg>
                            @elseif ($s['icon'] === 'sport')
                                <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c4.97 0 9-4.03 9-9s-4.03-9-9-9-9 4.03-9 9 4.03 9 9 9Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3c2.2 3 3.3 6 3.3 9S14.2 18 12 21c-2.2-3-3.3-6-3.3-9S9.8 6 12 3Z"/>
                                </svg>
                            @else
                                <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5 6 8v11h12V8l-3-3H9Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5c0 1.5 1.3 3 3 3s3-1.5 3-3"/>
                                </svg>
                            @endif
                        </div>
                        <div class="fv-services__copy">
                            <h3>{{ $s['title'] }}</h3>
                            <p>{{ $s['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y border-[#E2E5E9] bg-white py-16 sm:py-20 lg:py-24">
        <div class="mx-auto grid max-w-[1200px] items-center gap-10 lg:gap-16 px-5 lg:grid-cols-2 lg:px-8">
            <div class="fv-fitting-promo-media">
                <div class="fv-media aspect-[4/3]">
                    <img
                        src="{{ asset('images/virtual.jpg') }}"
                        alt="Studio virtual fitting FitVendor"
                        class="h-full w-full object-cover object-center"
                        loading="lazy"
                    >
                </div>
            </div>
            <div class="lg:pl-8 xl:pl-12">
                <p class="text-sm font-medium text-[#667085]">Studio interaktif</p>
                <h2 class="mt-2 text-[clamp(1.75rem,3vw,2.25rem)] font-bold text-[#102A43]">
                    Coba virtual fitting sebelum pesan
                </h2>
                <p class="mt-4 max-w-lg text-sm leading-relaxed text-[#667085]">
                    Gunakan virtual fitting untuk melihat perkiraan tampilan pakaian pada ukuran tubuh Anda. Ini pratinjau, bukan pengukuran jahit final.
                </p>
                <div class="mt-6">
                    <a href="{{ route('virtual-fitting') }}" class="btn-primary group inline-flex items-center gap-2">
                        <span>Buka virtual fitting</span>
                        <svg class="h-4 w-4 shrink-0 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0H8.25m11.25 0v11.25"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#F7F7F5] py-16 sm:py-20 lg:py-24">
        <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <span class="section-badge mb-3">Pertanyaan umum</span>
                    <h2 class="mt-2 text-[clamp(1.75rem,3vw,2.25rem)] font-bold text-[#102A43]">
                        Hal yang sering ditanyakan
                    </h2>
                    <p class="mt-3 max-w-md text-sm leading-relaxed text-[#667085]">
                        Seputar jumlah pesanan, virtual fitting, desain, dan jadwal produksi.
                    </p>

                    @php
                        $waNum = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
                        $waUrl = $waNum ? 'https://wa.me/'.$waNum.'?text='.rawurlencode('Halo FitVendor, saya ingin bertanya soal pesanan custom.') : 'https://wa.me/6281234567890';
                    @endphp

                    <div class="mt-8 max-w-md rounded-[14px] border border-[#E2E5E9] bg-white p-5">
                        <h3 class="text-base font-bold text-[#102A43]">Masih ada pertanyaan?</h3>
                        <p class="mt-1 text-sm leading-relaxed text-[#667085]">
                            Tim kami siap membahas bahan, jumlah, dan jadwal lewat WhatsApp.
                        </p>
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn-primary mt-4 inline-flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                            </svg>
                            <span>Tanya via WhatsApp</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    @php
                        $faqs = [
                            [
                                'q' => 'Berapa minimal jumlah pesanan di FitVendor?',
                                'a' => 'Kami menerima pesanan mulai 12 pcs sampai skala besar untuk komunitas, organisasi, kampus, atau clothing brand.',
                            ],
                            [
                                'q' => 'Bagaimana cara kerja virtual fitting?',
                                'a' => 'Masukkan tinggi, lingkar dada, pinggang, dan pinggul di halaman Virtual fitting. Sistem menampilkan pratinjau 3D. Ini perkiraan tampilan, bukan ukur jahit final.',
                            ],
                            [
                                'q' => 'Bisa pakai desain dan bahan sendiri?',
                                'a' => 'Bisa. Pilih bahan dari katalog, lalu unggah file desain, logo bordir, atau referensi sablon lewat formulir pesanan.',
                            ],
                            [
                                'q' => 'Berapa lama estimasi produksi?',
                                'a' => 'Umumnya 7 sampai 14 hari kerja setelah mock-up disetujui dan uang muka dikonfirmasi. Deadline ketat bisa dibahas dengan tim.',
                            ],
                            [
                                'q' => 'Bagaimana pembayaran dan pengiriman?',
                                'a' => 'Setelah permintaan masuk, total dibahas via WhatsApp. Biasanya DP di awal, pelunasan sebelum barang dikirim ke seluruh Indonesia.',
                            ],
                        ];
                    @endphp
                    <div class="flex flex-col gap-3">
                        @foreach ($faqs as $index => $faq)
                            <details class="faq-item rounded-[14px] border border-[#E2E5E9] bg-white px-5 py-4" {{ $index === 0 ? 'open' : '' }}>
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-[0.95rem] font-semibold text-[#102A43]">
                                    <span>{{ $faq['q'] }}</span>
                                    <span class="faq-icon inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-[#E2E5E9] bg-[#F7F7F5]">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </span>
                                </summary>
                                <div class="mt-3 border-t border-[#E2E5E9] pt-3 text-sm leading-relaxed text-[#667085]">
                                    {{ $faq['a'] }}
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-t border-[#E2E5E9] bg-white py-16 sm:py-20 lg:py-24">
        <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
            <div class="testimonial-header mb-8">
                <div class="testimonial-header__copy">
                    <span class="section-badge mb-3">Cerita pelanggan</span>
                    <h2 class="mt-1 text-[clamp(1.75rem,3vw,2.25rem)] font-bold text-[#102A43]">
                        Dipakai tim yang butuh hasil rapi
                    </h2>
                    <p class="mt-3 text-sm leading-relaxed text-[#667085]">
                        Cuplikan dari komunitas, brand, dan panitia yang memesan lewat FitVendor.
                    </p>
                </div>
                <div class="testimonial-header__nav">
                    <button type="button" id="testimonial-prev-btn" aria-label="Testimoni sebelumnya" class="flex h-11 w-11 items-center justify-center rounded-[8px] border border-[#E2E5E9] bg-white text-[#102A43]">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" id="testimonial-next-btn" aria-label="Testimoni berikutnya" class="flex h-11 w-11 items-center justify-center rounded-[8px] bg-[#102A43] text-white">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div id="testimonial-carousel-track" class="flex cursor-grab gap-4 overflow-x-auto pb-2" style="scroll-snap-type:x mandatory;scrollbar-width:none;">
                @php
                    $testimonials = [
                        ['name' => 'Bagus Pratama', 'role' => 'Kepala kreatif, Studio Karsa', 'tag' => 'Jaket kerja', 'photo' => 'images/profile1.jpg', 'quote' => 'Jahitannya rapi. Virtual fitting membantu tim kami memilih ukuran tanpa bolak-balik sampel fisik.'],
                        ['name' => 'Alika Salsabila', 'role' => 'Koordinator komunitas, Urban Runners ID', 'tag' => 'Windbreaker', 'photo' => 'images/profile2.jpg', 'quote' => 'Kain dan bordir sesuai yang dijanjikan. Warna konsisten, bahannya nyaman dipakai lari, komunikasi cepat.'],
                        ['name' => 'Dimas Arya Nugraha', 'role' => 'Pendiri, Niscala Apparel', 'tag' => 'Hoodie', 'photo' => 'images/profile3.jpg', 'quote' => 'Pola jatuhnya pas. Jahitan kuat, dan timnya jelas dari diskusi awal sampai barang sampai.'],
                        ['name' => 'Jessica Tandiono', 'role' => 'Direktur proyek, Arkana Agency', 'tag' => 'Varsity', 'photo' => 'images/profile4.jpg', 'quote' => 'Bahan wool blend dan aksen kulit sintetis terasa solid. Tim puas dengan hasil varsity-nya.'],
                        ['name' => 'Rian Hidayat', 'role' => 'Kapten, Garuda Basketball Club', 'tag' => 'Jersey', 'photo' => 'images/profile5.jpg', 'quote' => 'Jersey menyerap keringat, sablon dan emblem tahan cuci. Cocok untuk kebutuhan tim olahraga.'],
                        ['name' => 'Fikri Ramadhan', 'role' => 'Penyelenggara acara, Tech Innovators', 'tag' => 'Kaos oversized', 'photo' => 'images/profile6.jpg', 'quote' => 'Cotton combed 24s terasa tebal tapi tetap adem. Potongan oversized-nya konsisten untuk ratusan panitia.'],
                        ['name' => 'Nadia Putri', 'role' => 'Bendahara, Himpunan Mahasiswa Desain', 'tag' => 'Kaos', 'photo' => 'images/profile7.jpg', 'quote' => 'Ukuran dan bahan yang kami pilih sesuai kebutuhan tim. Proses pemesanannya juga jelas dari awal.'],
                        ['name' => 'Yoga Prasetyo', 'role' => 'Koordinator komunitas, Komunitas Sepeda Pagi', 'tag' => 'Windbreaker', 'photo' => 'images/profile8.jpg', 'quote' => 'Jahitannya rapi dan komunikasinya cepat selama pengerjaan. Cocok untuk kebutuhan komunitas kami.'],
                    ];
                @endphp
                @foreach($testimonials as $t)
                    <div class="testimonial-slide-card w-[min(360px,85vw)] shrink-0 snap-start rounded-[14px] border border-[#E2E5E9] bg-[#F7F7F5] p-6">
                        <div class="mb-4 flex items-center justify-end">
                            <span class="rounded-[8px] border border-[#E2E5E9] bg-white px-2 py-1 text-xs font-medium text-[#102A43]">{{ $t['tag'] }}</span>
                        </div>
                        <p class="testimonial-slide-card__quote text-sm leading-relaxed text-[#102A43]">{{ $t['quote'] }}</p>
                        <div class="testimonial-identity">
                            <img
                                src="{{ asset($t['photo']) }}"
                                alt="{{ $t['name'] }}"
                                width="40"
                                height="40"
                                loading="lazy"
                            >
                            <div class="testimonial-identity__copy">
                                <h3 class="testimonial-identity__name">{{ $t['name'] }}</h3>
                                <p class="testimonial-identity__role">{{ $t['role'] }}</p>
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
                return card ? card.offsetWidth + 16 : 376;
            };

            prevBtn.addEventListener('click', () => track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' }));
            nextBtn.addEventListener('click', () => track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' }));

            let isDown = false;
            let startX;
            let scrollLeft;

            track.addEventListener('mousedown', (e) => {
                isDown = true;
                track.style.cursor = 'grabbing';
                startX = e.pageX - track.offsetLeft;
                scrollLeft = track.scrollLeft;
            });
            track.addEventListener('mouseleave', () => { isDown = false; track.style.cursor = 'grab'; });
            track.addEventListener('mouseup', () => { isDown = false; track.style.cursor = 'grab'; });
            track.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                track.scrollLeft = scrollLeft - ((e.pageX - track.offsetLeft) - startX) * 1.5;
            });
        });
    </script>

    <style>
        details.faq-item summary::-webkit-details-marker,
        details.faq-item summary::marker { display: none; content: ""; }
        details.faq-item[open] { border-color: #102A43; }
        details.faq-item[open] .faq-icon { background: #102A43; color: #fff; border-color: #102A43; }
        details.faq-item[open] .faq-icon svg { transform: rotate(180deg); }
        .fv-fitting-promo-media {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        .fv-fitting-promo-media .fv-media {
            width: 92%;
            max-width: 100%;
        }
        .testimonial-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            overflow: visible;
        }
        .testimonial-header__copy {
            min-width: 0;
            max-width: 36rem;
            flex: 1 1 16rem;
        }
        .testimonial-header__nav {
            display: flex;
            flex-shrink: 0;
            gap: 0.5rem;
        }
        .testimonial-header__nav button {
            flex-shrink: 0;
        }
        #testimonial-carousel-track {
            align-items: stretch;
        }
        #testimonial-carousel-track::-webkit-scrollbar { display: none; }
        .testimonial-slide-card {
            display: flex;
            flex-direction: column;
        }
        .testimonial-slide-card__quote {
            flex: 1 1 auto;
            margin: 0 0 1.25rem;
        }
        .testimonial-identity {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid #E2E5E9;
        }
        .testimonial-identity img {
            display: block;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 50%;
            object-fit: cover;
        }
        .testimonial-identity__copy {
            min-width: 0;
            flex: 1 1 auto;
        }
        .testimonial-identity__name {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 700;
            line-height: 1.3;
            color: #102A43;
        }
        .testimonial-identity__role {
            margin: 2px 0 0;
            min-height: 2.7em;
            font-size: 0.75rem;
            font-weight: 400;
            line-height: 1.35;
            color: #667085;
        }
    </style>

@endsection
