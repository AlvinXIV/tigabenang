@extends('layouts.customer')

@section('title', 'Tentang')
@section('description', 'Profil FitVendor. Vendor pakaian custom dengan virtual fitting dan produksi sesuai pesanan.')

@section('content')

    <style>
        .fv-about {
            background: #F7F7F5;
            color: #1C2430;
        }
        .fv-about__shell {
            width: 100%;
            max-width: 1200px;
            margin-inline: auto;
            padding-inline: 1.25rem;
        }
        @media (min-width: 1024px) {
            .fv-about__shell { padding-inline: 2rem; }
        }
        .fv-about__section {
            padding-block: 3.5rem;
        }
        @media (min-width: 768px) {
            .fv-about__section { padding-block: 5rem; }
        }
        @media (min-width: 1024px) {
            .fv-about__section { padding-block: 6rem; }
        }
        .fv-about__photo {
            display: block;
            overflow: hidden;
            border: 1px solid #E2E5E9;
            border-radius: 18px;
            background: #EEEFEC;
        }
        .fv-about__photo img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }
        .fv-about__photo:hover img {
            transform: scale(1.02);
        }
        .fv-about__photo--hero { aspect-ratio: 4 / 5; }
        .fv-about__photo--story { aspect-ratio: 4 / 3; }
        .fv-about__photo--process {
            width: 100%;
            max-width: 100%;
            height: auto;
            aspect-ratio: 4 / 5;
        }
        .fv-about__photo--process img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            transform: none;
        }
        .fv-about__photo--process:hover img {
            transform: none;
        }
        .fv-about__process {
            display: grid;
            gap: 2.25rem;
        }
        @media (min-width: 768px) {
            .fv-about__process {
                grid-template-columns: minmax(0, 1.15fr) minmax(0, 0.95fr);
                gap: 3.5rem;
                align-items: center;
            }
        }
        .fv-about__photo--work { aspect-ratio: 4 / 5; }
        .fv-about__intro,
        .fv-about__story,
        .fv-about__work {
            display: grid;
            gap: 2.25rem;
        }
        @media (min-width: 1024px) {
            .fv-about__intro,
            .fv-about__story,
            .fv-about__work {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
                gap: 4rem;
                align-items: center;
            }
        }
        .about-eyebrow {
            display: block;
            margin: 0 0 10px;
            font-size: 0.8125rem;
            font-weight: 500;
            line-height: 1.4;
            letter-spacing: 0.03em;
            color: #667085;
            text-transform: none;
        }
        .fv-about__heading {
            margin: 0;
            font-size: clamp(1.75rem, 3.4vw, 2.75rem);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -0.02em;
            color: #1C2430;
        }
        .fv-about__lead,
        .fv-about__copy {
            margin: 1rem 0 0;
            max-width: 36rem;
            font-size: 0.9375rem;
            line-height: 1.7;
            color: #667085;
        }
        .fv-about__rule {
            width: 3rem;
            height: 1px;
            margin: 1.5rem 0 0;
            background: #E2E5E9;
            border: 0;
        }
        .fv-about__visi {
            max-width: 46rem;
        }
        .fv-about__visi p {
            margin: 1.25rem 0 0;
            font-size: clamp(1.25rem, 2.2vw, 1.75rem);
            font-weight: 500;
            line-height: 1.45;
            letter-spacing: -0.015em;
            color: #1C2430;
        }
        .fv-about__misi {
            margin: 2rem 0 0;
            padding: 0;
            list-style: none;
        }
        .fv-about__misi li {
            display: grid;
            grid-template-columns: 2.5rem minmax(0, 1fr);
            gap: 1rem;
            padding: 1.25rem 0;
            border-top: 1px solid #E2E5E9;
        }
        .fv-about__misi li:last-child { border-bottom: 1px solid #E2E5E9; }
        .fv-about__misi-num {
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1.6;
            color: #1C2430;
        }
        .fv-about__misi-text {
            margin: 0;
            font-size: 0.9375rem;
            line-height: 1.6;
            color: #667085;
        }
        .fv-about__services {
            display: grid;
            gap: 1.75rem;
            margin: 1.75rem 0 0;
        }
        .fv-about__service h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: #1C2430;
        }
        .fv-about__service p {
            margin: 0.4rem 0 0;
            font-size: 0.875rem;
            line-height: 1.6;
            color: #667085;
        }
        .fv-about__steps {
            display: grid;
            gap: 0;
            margin: 2rem 0 0;
            padding: 0;
            list-style: none;
        }
        @media (min-width: 768px) {
            .fv-about__steps {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }
        .fv-about__steps li {
            padding: 1.25rem 0;
            border-top: 1px solid #E2E5E9;
        }
        @media (min-width: 768px) {
            .fv-about__steps li {
                padding: 0 1.25rem 0 0;
                border-top: 0;
                border-right: 1px solid #E2E5E9;
            }
            .fv-about__steps li:last-child {
                padding-right: 0;
                border-right: 0;
            }
        }
        .fv-about__steps-num {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #1C2430;
        }
        .fv-about__steps h3 {
            margin: 0.75rem 0 0;
            font-size: 1rem;
            font-weight: 600;
            color: #1C2430;
        }
        .fv-about__steps p {
            margin: 0.5rem 0 0;
            font-size: 0.875rem;
            line-height: 1.6;
            color: #667085;
        }
        .fv-about__contact-grid {
            display: grid;
            gap: 1rem;
            margin-top: 2rem;
        }
        @media (min-width: 640px) {
            .fv-about__contact-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        .fv-about__contact-card {
            padding: 1.25rem;
            border: 1px solid #E2E5E9;
            border-radius: 12px;
            background: #FFFFFF;
        }
        @media (max-width: 767px) {
            .fv-about__process .fv-about__photo { order: 2; }
            .fv-about__process .fv-about__copy-col { order: 1; }
        }
        @media (max-width: 1023px) {
            .fv-about__intro .fv-about__photo,
            .fv-about__work .fv-about__photo { order: 2; }
            .fv-about__intro .fv-about__copy-col,
            .fv-about__work .fv-about__copy-col { order: 1; }
        }
    </style>

    <div class="fv-about">
        <section class="fv-about__section bg-white">
            <div class="fv-about__shell fv-about__intro">
                <div class="fv-about__copy-col">
                    <span class="about-eyebrow">Tentang FitVendor</span>
                    <h1 class="fv-about__heading">
                        Vendor pakaian yang mengutamakan ukuran yang pas
                    </h1>
                    <p class="fv-about__lead">
                        FitVendor membuat pakaian custom untuk tim, komunitas, dan individu. Dari pilihan model sampai potongan jadi.
                    </p>
                </div>
                <div class="fv-about__photo fv-about__photo--hero">
                    <img
                        src="{{ asset('images/tentang1.jpg') }}"
                        alt="Studio produksi FitVendor"
                        width="720"
                        height="900"
                    >
                </div>
            </div>
        </section>

        <section class="fv-about__section">
            <div class="fv-about__shell fv-about__story">
                <div class="fv-about__photo fv-about__photo--story">
                    <img
                        src="{{ asset('images/tentang2.jpg') }}"
                        alt="Meja potong dan pola pakaian FitVendor"
                        width="800"
                        height="600"
                    >
                </div>
                <div>
                    <span class="about-eyebrow">Cerita</span>
                    <h2 class="fv-about__heading">
                        Antara meja potong dan layar fitting
                    </h2>
                    <p class="fv-about__copy">
                        Kami mulai sebagai vendor yang tidak mau menyerahkan ukuran pada tebakan.
                    </p>
                    <p class="fv-about__copy">
                        FitVendor tetap memotong dan menjahit per pesanan, plus studio fitting digital supaya model bisa dilihat sebelum produksi.
                    </p>
                </div>
            </div>
        </section>

        <section class="fv-about__section bg-white">
            <div class="fv-about__shell fv-about__process">
                <div class="fv-about__copy-col">
                    <span class="about-eyebrow">Produksi</span>
                    <h2 class="fv-about__heading">Proses yang kami kerjakan</h2>
                    <p class="fv-about__copy">
                        FitVendor tetap memotong dan menjahit per pesanan, plus studio fitting digital supaya model bisa dilihat sebelum produksi.
                    </p>
                </div>
                <div class="fv-about__photo fv-about__photo--process">
                    <img
                        src="{{ asset('images/tentang3.jpg') }}"
                        alt="Gudang bahan dan proses produksi FitVendor"
                        width="720"
                        height="900"
                    >
                </div>
            </div>
        </section>

        <section class="fv-about__section">
            <div class="fv-about__shell">
                <div class="fv-about__visi">
                    <span class="about-eyebrow">Arah perusahaan</span>
                    <h2 class="fv-about__heading">Visi</h2>
                    <hr class="fv-about__rule">
                    <p>
                        Menjadi vendor pakaian yang terpercaya untuk kebutuhan tim, komunitas, acara, dan brand melalui kualitas produksi yang konsisten dan pelayanan yang jelas.
                    </p>
                </div>
            </div>
        </section>

        <section class="fv-about__section bg-white">
            <div class="fv-about__shell">
                <span class="about-eyebrow">Prinsip kami</span>
                <h2 class="fv-about__heading">Misi</h2>
                <ol class="fv-about__misi">
                    <li>
                        <span class="fv-about__misi-num">01</span>
                        <p class="fv-about__misi-text">Menjaga kualitas bahan dan hasil produksi.</p>
                    </li>
                    <li>
                        <span class="fv-about__misi-num">02</span>
                        <p class="fv-about__misi-text">Memberikan proses pemesanan yang jelas dan mudah dipahami.</p>
                    </li>
                    <li>
                        <span class="fv-about__misi-num">03</span>
                        <p class="fv-about__misi-text">Membantu pelanggan menentukan pilihan pakaian sesuai kebutuhan.</p>
                    </li>
                    <li>
                        <span class="fv-about__misi-num">04</span>
                        <p class="fv-about__misi-text">Menjaga komunikasi yang cepat dan terbuka selama proses produksi.</p>
                    </li>
                </ol>
            </div>
        </section>

        <section class="fv-about__section">
            <div class="fv-about__shell fv-about__work">
                <div class="fv-about__copy-col">
                    <span class="about-eyebrow">Layanan kami</span>
                    <h2 class="fv-about__heading">Yang kami kerjakan</h2>
                    <div class="fv-about__services">
                        @foreach ([
                            ['title' => 'Pakaian custom', 'desc' => 'Varsity, work jacket, windbreaker, jersey, dan model lain dari koleksi yang tampil di situs.', 'icon' => 'garment'],
                            ['title' => 'Pemilihan bahan', 'desc' => 'Pilih bahan yang memang tersedia untuk produk itu. Katalog menampilkan nama, bukan spek fiktif.', 'icon' => 'fabric'],
                            ['title' => 'Fitting digital', 'desc' => 'Satu manekin, satu pakaian. Proporsi terlihat sebelum Anda mengirim permintaan.', 'icon' => 'fit'],
                        ] as $item)
                            <div class="fv-about__service">
                                <div class="fv-icon-wrap" aria-hidden="true">
                                    @if ($item['icon'] === 'garment')
                                        <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 5 4 8v3h3v8h10v-8h3V8l-4-3-2 2.5L12 7l-2 .5L8 5Z"/>
                                        </svg>
                                    @elseif ($item['icon'] === 'fabric')
                                        <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v10H4V7Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v10M12 7v10M16 7v10M4 12h16"/>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 shrink-0" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4a3 3 0 0 1 3 3v2H9V7a3 3 0 0 1 3-3Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 9h8l1 11H7L8 9Z"/>
                                        </svg>
                                    @endif
                                </div>
                                <h3 class="mt-3">{{ $item['title'] }}</h3>
                                <p>{{ $item['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="fv-about__photo fv-about__photo--work">
                    <img
                        src="{{ asset('images/tentang4.jpg') }}"
                        alt="Tim FitVendor membahas bahan dan desain"
                        width="720"
                        height="900"
                    >
                </div>
            </div>
        </section>

        <section class="fv-about__section bg-white">
            <div class="fv-about__shell">
                <span class="about-eyebrow">Proses pemesanan</span>
                <h2 class="fv-about__heading">Alur kerja</h2>
                <ol class="fv-about__steps">
                    @foreach ([
                        ['num' => '01', 'title' => 'Pilih pakaian', 'desc' => 'Jelajahi koleksi dan buka model yang sesuai kebutuhan.'],
                        ['num' => '02', 'title' => 'Pilih bahan',  'desc' => 'Ambil satu atau lebih bahan yang tersedia untuk produk itu.'],
                        ['num' => '03', 'title' => 'Lihat fitting',   'desc' => 'Pakai virtual fitting jika ada file 3D, atau langsung ke formulir.'],
                        ['num' => '04', 'title' => 'Kirim permintaan', 'desc' => 'Isi data pemesan, rincian ukuran, dan catatan desain. Tanpa akun.'],
                    ] as $step)
                        <li>
                            <span class="fv-about__steps-num">{{ $step['num'] }}</span>
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['desc'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        <section class="fv-about__section">
            <div class="fv-about__shell">
                <span class="about-eyebrow">Tim</span>
                <h2 class="fv-about__heading">Studio kecil, dekat dengan produksinya</h2>
                <p class="fv-about__copy">
                    Pola, produksi, dan fitting digital dibahas dalam satu alur. Permintaan Anda dibaca orang, bukan portal otomatis.
                </p>
            </div>
        </section>

        @php
            $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
            $whatsappMessage = rawurlencode((string) config('fitvendor.whatsapp.message'));
            $whatsappHref = $whatsappNumber !== '' ? 'https://wa.me/'.$whatsappNumber.'?text='.$whatsappMessage : null;
            $vendorEmail = trim((string) config('fitvendor.contact.email'));
            $vendorLocation = trim((string) config('fitvendor.contact.location'));
        @endphp

        <section class="fv-about__section bg-white">
            <div class="fv-about__shell">
                <span class="about-eyebrow">Kontak</span>
                <h2 class="fv-about__heading">Hubungi Kami</h2>
                <p class="fv-about__copy">
                    Punya pertanyaan atau ingin membahas kebutuhan produksi?
                </p>

                <div class="fv-about__contact-grid">
                    @if ($whatsappHref)
                        <div class="fv-about__contact-card">
                            <span class="fv-contact-icon" aria-hidden="true">
                                <svg class="h-6 w-6 shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                                </svg>
                            </span>
                            <p class="text-sm font-semibold text-[#667085]">WhatsApp</p>
                            <a href="{{ $whatsappHref }}" target="_blank" rel="noopener noreferrer" class="mt-2 block text-sm font-semibold text-[#1C2430] no-underline hover:text-[#B8664A]">
                                {{ $whatsappNumber }}
                            </a>
                        </div>
                    @endif
                    @if ($vendorEmail !== '')
                        <div class="fv-about__contact-card">
                            <span class="fv-contact-icon" aria-hidden="true">
                                <svg class="h-6 w-6 shrink-0" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.75A1.75 1.75 0 0 1 5.75 5h12.5A1.75 1.75 0 0 1 20 6.75v10.5A1.75 1.75 0 0 1 18.25 19H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 7 7 5 7-5"/>
                                </svg>
                            </span>
                            <p class="text-sm font-semibold text-[#667085]">Email</p>
                            <a href="mailto:{{ $vendorEmail }}" class="mt-2 block text-sm font-semibold text-[#1C2430] underline underline-offset-2 hover:text-[#B8664A]">
                                {{ $vendorEmail }}
                            </a>
                        </div>
                    @endif
                    @if ($vendorLocation !== '')
                        <div class="fv-about__contact-card">
                            <span class="fv-contact-icon" aria-hidden="true">
                                <svg class="h-6 w-6 shrink-0" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"/>
                                </svg>
                            </span>
                            <p class="text-sm font-semibold text-[#667085]">Alamat</p>
                            <p class="mt-2 text-sm font-semibold text-[#1C2430]">{{ $vendorLocation }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    @if ($whatsappHref)
                        <a href="{{ $whatsappHref }}" target="_blank" rel="noopener noreferrer" class="btn-primary inline-flex">
                            Hubungi melalui WhatsApp
                        </a>
                    @endif
                    <a href="{{ route('order.create') }}" class="btn-outline inline-flex">
                        Mulai permintaan
                    </a>
                </div>
            </div>
        </section>
    </div>

@endsection
