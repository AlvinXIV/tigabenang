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

    <div class="bg-white pt-4 pb-6 sm:pb-8 lg:pb-10">
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
                            <a href="{{ route('virtual-fitting') }}" class="fv-home-hero__cta-secondary">Coba fitting virtual</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="bg-white py-12">
        <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3 md:gap-6">
                <article class="fv-icon-card">
                    <div class="fv-icon-wrap" aria-hidden="true">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h10M4 17h7M19 10v8m0 0-2.5-2.5M19 18l2.5-2.5"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-[#1C2430]">Bahan terukur</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                        Pilih kain dari katalog yang sama dengan stok produksi, bukan spek yang dibuat-buat.
                    </p>
                </article>

                <article class="fv-icon-card">
                    <div class="fv-icon-wrap" aria-hidden="true">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 14 10m0 0 2.5-2.5a3.5 3.5 0 1 0-5-5L9 5m5 5-5-5m-3.5 8.5 1.5 1.5M7 19l-3 1 1-3"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-[#1C2430]">Jahitan rapi</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                        Pola dan produksi dikerjakan per pesanan supaya hasilnya konsisten untuk tim Anda.
                    </p>
                </article>

                <article class="fv-icon-card">
                    <div class="fv-icon-wrap" aria-hidden="true">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6a2 2 0 0 1 2 2v12l-5-2-5 2V7a2 2 0 0 1 2-2Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 10h5M9.5 13.5h3.5"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-[#1C2430]">Proses jelas</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                        Kirim permintaan, bahas harga di WhatsApp, lalu produksi berjalan setelah konfirmasi.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="bg-[#F7F7F5] py-16">
        <div class="mx-auto grid max-w-[1200px] items-center gap-10 px-5 lg:grid-cols-2 lg:px-8">
            <div>
                <span class="section-badge mb-3">Tentang kami</span>
                <h2 class="mt-2 text-[clamp(1.75rem,3vw,2.25rem)] font-bold leading-tight text-[#1C2430]">
                    7+ tahun memproduksi pakaian custom berkualitas
                </h2>
                <div class="mt-5 space-y-3 text-sm leading-relaxed text-[#667085]">
                    <p>
                        <strong class="font-semibold text-[#1C2430]">FitVendor</strong> adalah konveksi garmen berbasis di Bandung dengan pengalaman lebih dari 7 tahun. Kami dipercaya ratusan komunitas, kampus, dan brand untuk memproduksi jaket, kemeja, jersey, hingga seragam kerja.
                    </p>
                    <p>
                        Dengan meja potong mandiri dan penjahit ahli, setiap pesanan dikerjakan dengan bahan pilihan, pola proporsional, dan proses produksi yang transparan.
                    </p>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-3 border-y border-[#E2E5E9] py-3.5">
                    <div>
                        <p class="text-base font-bold text-[#1C2430] sm:text-lg">7+ Tahun</p>
                        <p class="text-[11px] text-[#667085] sm:text-xs">Pengalaman garmen</p>
                    </div>
                    <div>
                        <p class="text-base font-bold text-[#1C2430] sm:text-lg">50.000+</p>
                        <p class="text-[11px] text-[#667085] sm:text-xs">Pcs diproduksi</p>
                    </div>
                    <div>
                        <p class="text-base font-bold text-[#1C2430] sm:text-lg">300+</p>
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
        <section class="border-y border-[#E2E5E9] bg-white py-16">
            <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
                <div class="mb-10 flex flex-col justify-between gap-5 md:flex-row md:items-end">
                    <div>
                        <span class="section-badge mb-3">Karya kami</span>
                        <h2 class="mt-1 text-[clamp(1.75rem,3vw,2.5rem)] font-bold text-[#1C2430]">
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
                                        alt="{{ $prod ? $prod->nama_produk : $cat->nama_kategori }}"
                                        width="600"
                                        height="750"
                                        loading="lazy"
                                        decoding="async"
                                        class="absolute inset-0 h-full w-full object-cover"
                                    >
                                @endif
                                <span class="absolute bottom-4 right-4 rounded-xl bg-[#1C2430] px-3 py-1.5 text-xs font-semibold text-white">
                                    Lihat kategori
                                </span>
                            </div>
                            <div class="mt-3">
                                <h3 class="text-lg font-bold text-[#1C2430]">{{ $cat->nama_kategori }}</h3>
                                @if ($prod)
                                    <p class="mt-1 font-bold text-[#1C2430]"><x-price :amount="$prod->harga" /></p>
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

    <section class="fv-services">
        <div class="fv-services__inner">
            <div class="fv-services__intro">
                <h2 class="fv-services__title">
                    Layanan produksi
                </h2>
                <p class="fv-services__lead">
                    Pesanan custom untuk berbagai kebutuhan.
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
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 4 4 7v13h5v-6h6v6h5V7l-4-3-3 3-3-3Z"/>
                                </svg>
                            @elseif ($s['icon'] === 'shirt')
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5 4 8v3h3v8h10v-8h3V8l-4-3-2 2.5L12 7l-2 .5L8 5Z"/>
                                </svg>
                            @elseif ($s['icon'] === 'sport')
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c4.97 0 9-4.03 9-9s-4.03-9-9-9-9 4.03-9 9 4.03 9 9 9Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3c2.2 3 3.3 6 3.3 9S14.2 18 12 21c-2.2-3-3.3-6-3.3-9S9.8 6 12 3Z"/>
                                </svg>
                            @else
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
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

    <section class="border-y border-[#E2E5E9] bg-white py-16">
        <div class="mx-auto grid max-w-[1200px] items-center gap-10 px-5 lg:grid-cols-2 lg:px-8">
            <div>
                <p class="text-sm font-medium text-[#667085]">Studio interaktif</p>
                <h2 class="mt-2 text-[clamp(1.75rem,3vw,2.25rem)] font-bold text-[#1C2430]">
                    Coba fitting virtual sebelum pesan
                </h2>
                <p class="mt-4 max-w-lg text-sm leading-relaxed text-[#667085]">
                    Gunakan fitting virtual untuk melihat perkiraan tampilan pakaian pada ukuran tubuh Anda. Ini pratinjau, bukan pengukuran jahit final.
                </p>
                <div class="mt-6">
                    <a href="{{ route('virtual-fitting') }}" class="btn-primary">Buka fitting virtual</a>
                </div>
            </div>
            <div class="fv-media aspect-[4/3]">
                <img
                    src="{{ asset('images/virtual-fitting-teaser.jpg') }}?v=11"
                    alt="Studio fitting virtual FitVendor"
                    class="h-full w-full object-cover object-[center_30%]"
                    loading="lazy"
                >
            </div>
        </div>
    </section>

    <section class="bg-[#F7F7F5] py-16">
        <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <span class="section-badge mb-3">Pertanyaan umum</span>
                    <h2 class="mt-2 text-[clamp(1.75rem,3vw,2.25rem)] font-bold text-[#1C2430]">
                        Hal yang sering ditanyakan
                    </h2>
                    <p class="mt-3 max-w-md text-sm leading-relaxed text-[#667085]">
                        Seputar jumlah pesanan, fitting virtual, desain, dan jadwal produksi.
                    </p>

                    @php
                        $waNum = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
                        $waUrl = $waNum ? 'https://wa.me/'.$waNum.'?text='.rawurlencode('Halo FitVendor, saya ingin bertanya soal pesanan custom.') : 'https://wa.me/6281234567890';
                    @endphp

                    <div class="mt-8 max-w-md rounded-[14px] border border-[#E2E5E9] bg-white p-5">
                        <h3 class="text-base font-bold text-[#1C2430]">Masih ada pertanyaan?</h3>
                        <p class="mt-1 text-sm leading-relaxed text-[#667085]">
                            Tim kami siap membahas bahan, jumlah, dan jadwal lewat WhatsApp.
                        </p>
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn-primary mt-4">
                            Tanya via WhatsApp
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
                                'q' => 'Bagaimana cara kerja fitting virtual?',
                                'a' => 'Masukkan tinggi, lingkar dada, pinggang, dan pinggul di halaman Fitting virtual. Sistem menampilkan pratinjau 3D. Ini perkiraan tampilan, bukan ukur jahit final.',
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
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-[0.95rem] font-semibold text-[#1C2430]">
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

    <section class="border-t border-[#E2E5E9] bg-white py-16">
        <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
            <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
                <div class="max-w-xl">
                    <span class="section-badge mb-3">Cerita pelanggan</span>
                    <h2 class="mt-1 text-[clamp(1.75rem,3vw,2.25rem)] font-bold text-[#1C2430]">
                        Dipakai tim yang butuh hasil rapi
                    </h2>
                    <p class="mt-3 text-sm leading-relaxed text-[#667085]">
                        Cuplikan dari komunitas, brand, dan panitia yang memesan lewat FitVendor.
                    </p>
                </div>
                <div class="flex gap-2">
                    <button type="button" id="testimonial-prev-btn" aria-label="Testimoni sebelumnya" class="flex h-11 w-11 items-center justify-center rounded-[8px] border border-[#E2E5E9] bg-white text-[#1C2430]">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" id="testimonial-next-btn" aria-label="Testimoni berikutnya" class="flex h-11 w-11 items-center justify-center rounded-[8px] bg-[#1C2430] text-white">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div id="testimonial-carousel-track" class="flex cursor-grab gap-4 overflow-x-auto pb-2" style="scroll-snap-type:x mandatory;scrollbar-width:none;">
                @php
                    $testimonials = [
                        ['name' => 'Bagus Pratama', 'role' => 'Kepala kreatif, Studio Karsa', 'tag' => 'Jaket kerja', 'avatar_bg' => '#1C2430', 'avatar_text' => 'BP', 'quote' => 'Jahitannya rapi. Fitting virtual membantu tim kami memilih ukuran tanpa bolak-balik sampel fisik.'],
                        ['name' => 'Alika Salsabila', 'role' => 'Koordinator komunitas, Urban Runners ID', 'tag' => 'Windbreaker', 'avatar_bg' => '#2A3442', 'avatar_text' => 'AS', 'quote' => 'Kain dan bordir sesuai yang dijanjikan. Warna konsisten, bahannya nyaman dipakai lari, komunikasi cepat.'],
                        ['name' => 'Dimas Arya Nugraha', 'role' => 'Pendiri, Niscala Apparel', 'tag' => 'Hoodie', 'avatar_bg' => '#2A3542', 'avatar_text' => 'DA', 'quote' => 'Pola jatuhnya pas. Jahitan kuat, dan timnya jelas dari diskusi awal sampai barang sampai.'],
                        ['name' => 'Jessica Tandiono', 'role' => 'Direktur proyek, Arkana Agency', 'tag' => 'Varsity', 'avatar_bg' => '#1C2430', 'avatar_text' => 'JT', 'quote' => 'Bahan wool blend dan aksen kulit sintetis terasa solid. Tim puas dengan hasil varsity-nya.'],
                        ['name' => 'Rian Hidayat', 'role' => 'Kapten, Garuda Basketball Club', 'tag' => 'Jersey', 'avatar_bg' => '#2A3442', 'avatar_text' => 'RH', 'quote' => 'Jersey menyerap keringat, sablon dan emblem tahan cuci. Cocok untuk kebutuhan tim olahraga.'],
                        ['name' => 'Fikri Ramadhan', 'role' => 'Penyelenggara acara, Tech Innovators', 'tag' => 'Kaos oversized', 'avatar_bg' => '#2A3542', 'avatar_text' => 'FR', 'quote' => 'Cotton combed 24s terasa tebal tapi tetap adem. Potongan oversized-nya konsisten untuk ratusan panitia.'],
                    ];
                @endphp
                @foreach($testimonials as $t)
                    <div class="testimonial-slide-card w-[min(360px,85vw)] shrink-0 snap-start rounded-[14px] border border-[#E2E5E9] bg-[#F7F7F5] p-6">
                        <div class="mb-4 flex items-center justify-end">
                            <span class="rounded-[8px] border border-[#E2E5E9] bg-white px-2 py-1 text-xs font-medium text-[#1C2430]">{{ $t['tag'] }}</span>
                        </div>
                        <p class="mb-5 text-sm leading-relaxed text-[#1C2430]">{{ $t['quote'] }}</p>
                        <div class="flex items-center gap-3 border-t border-[#E2E5E9] pt-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[10px] text-sm font-semibold text-white" style="background:{{ $t['avatar_bg'] }};">
                                {{ $t['avatar_text'] }}
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-[#1C2430]">{{ $t['name'] }}</h3>
                                <p class="text-xs text-[#667085]">{{ $t['role'] }}</p>
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
        details.faq-item[open] { border-color: #1C2430; }
        details.faq-item[open] .faq-icon { background: #1C2430; color: #fff; border-color: #1C2430; }
        details.faq-item[open] .faq-icon svg { transform: rotate(180deg); }
        #testimonial-carousel-track::-webkit-scrollbar { display: none; }
    </style>

@endsection
