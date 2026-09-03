@extends('layouts.customer')

@section('title', 'Tentang')
@section('description', 'Profil FitVendor. Vendor pakaian custom dengan fitting virtual dan produksi sesuai pesanan.')

@section('content')

    <section class="fv-page-hero">
        <div class="mx-auto max-w-[1200px] px-5 py-12 lg:px-8 lg:py-14">
            <span class="section-badge mb-3">Tentang FitVendor</span>
            <h1 class="mt-2 max-w-3xl text-4xl font-bold leading-tight tracking-tight md:text-5xl">
                Vendor pakaian yang mengutamakan ukuran yang pas
            </h1>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed">
                FitVendor membuat pakaian custom untuk tim, komunitas, dan individu. Dari pilihan model sampai potongan jadi.
            </p>
        </div>
    </section>

    <section class="border-b border-[#E2E5E9] bg-white px-5 py-14 lg:px-8">
        <div class="mx-auto grid max-w-[1200px] gap-10 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Cerita</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-bold tracking-tight text-[#1C2430] md:text-4xl">
                    Antara meja potong dan layar fitting
                </h2>
                <p class="mt-5 text-sm leading-relaxed text-[#667085] md:text-base">
                    Kami mulai sebagai vendor yang tidak mau menyerahkan ukuran pada tebakan. FitVendor tetap memotong dan menjahit per pesanan, plus studio fitting digital supaya model bisa dilihat sebelum produksi.
                </p>
            </div>
        </div>
    </section>

    <section class="border-b border-[#E2E5E9] bg-[#F7F7F5] px-5 py-14 lg:px-8">
        <div class="mx-auto grid max-w-[1200px] gap-10 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Visi</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-bold tracking-tight text-[#1C2430] md:text-4xl">Visi</h2>
                <p class="mt-5 text-sm leading-relaxed text-[#667085] md:text-base">
                    Menjadi vendor pakaian yang terpercaya untuk kebutuhan tim, komunitas, acara, dan brand melalui kualitas produksi yang konsisten dan pelayanan yang jelas.
                </p>
            </div>
        </div>
    </section>

    <section class="border-b border-[#E2E5E9] bg-white px-5 py-14 lg:px-8">
        <div class="mx-auto grid max-w-[1200px] gap-10 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Misi</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-bold tracking-tight text-[#1C2430] md:text-4xl">Misi</h2>
                <ul class="mt-5 space-y-3 p-0 text-sm leading-relaxed text-[#667085] md:text-base">
                    <li class="flex gap-3">
                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-sm bg-[#B8664A]" aria-hidden="true"></span>
                        <span>Menjaga kualitas bahan dan hasil produksi.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-sm bg-[#B8664A]" aria-hidden="true"></span>
                        <span>Memberikan proses pemesanan yang jelas dan mudah dipahami.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-sm bg-[#B8664A]" aria-hidden="true"></span>
                        <span>Membantu pelanggan menentukan pilihan pakaian sesuai kebutuhan.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-sm bg-[#B8664A]" aria-hidden="true"></span>
                        <span>Menjaga komunikasi yang cepat dan terbuka selama proses produksi.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="border-b border-[#E2E5E9] bg-[#F7F7F5] px-5 py-14 lg:px-8">
        <div class="mx-auto grid max-w-[1200px] gap-10 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Yang kami kerjakan</span>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:col-span-9">
                @foreach ([
                    ['title' => 'Pakaian custom', 'desc' => 'Varsity, work jacket, windbreaker, jersey, dan model lain dari koleksi yang tampil di situs.', 'icon' => 'garment'],
                    ['title' => 'Pemilihan bahan', 'desc' => 'Pilih bahan yang memang tersedia untuk produk itu. Katalog menampilkan nama, bukan spek fiktif.', 'icon' => 'fabric'],
                    ['title' => 'Fitting digital', 'desc' => 'Satu manekin, satu pakaian. Proporsi terlihat sebelum Anda mengirim permintaan.', 'icon' => 'fit'],
                ] as $item)
                    <div class="fv-icon-card">
                        <div class="fv-icon-wrap" aria-hidden="true">
                            @if ($item['icon'] === 'garment')
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5 4 8v3h3v8h10v-8h3V8l-4-3-2 2.5L12 7l-2 .5L8 5Z"/>
                                </svg>
                            @elseif ($item['icon'] === 'fabric')
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v10H4V7Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v10M12 7v10M16 7v10M4 12h16"/>
                                </svg>
                            @else
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4a3 3 0 0 1 3 3v2H9V7a3 3 0 0 1 3-3Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 9h8l1 11H7L8 9Z"/>
                                </svg>
                            @endif
                        </div>
                        <h3 class="mt-4 text-base font-bold text-[#1C2430]">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-[#667085]">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-b border-[#E2E5E9] bg-white px-5 py-14 lg:px-8">
        <div class="mx-auto grid max-w-[1200px] gap-10 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Alur kerja</span>
            </div>
            <ol class="grid list-none gap-4 p-0 sm:grid-cols-2 lg:col-span-9">
                @foreach ([
                    ['num' => '01', 'title' => 'Pilih pakaian', 'desc' => 'Jelajahi koleksi dan buka model yang sesuai kebutuhan.'],
                    ['num' => '02', 'title' => 'Pilih bahan',  'desc' => 'Ambil satu atau lebih bahan yang tersedia untuk produk itu.'],
                    ['num' => '03', 'title' => 'Lihat fitting',   'desc' => 'Pakai fitting virtual jika ada file 3D, atau langsung ke formulir.'],
                    ['num' => '04', 'title' => 'Kirim permintaan', 'desc' => 'Isi data pemesan, rincian ukuran, dan catatan desain. Tanpa akun.'],
                ] as $step)
                    <li class="rounded-[14px] border border-[#E2E5E9] bg-[#F7F7F5] p-6">
                        <span class="text-2xl font-semibold text-[#1C2430]">{{ $step['num'] }}</span>
                        <h3 class="mt-2 text-base font-bold text-[#1C2430]">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-[#667085]">{{ $step['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="border-b border-[#E2E5E9] bg-[#F7F7F5] px-5 py-14 lg:px-8">
        <div class="mx-auto grid max-w-[1200px] gap-10 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Tim</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-bold tracking-tight text-[#1C2430] md:text-4xl">Studio kecil, dekat dengan produksinya</h2>
                <p class="mt-5 text-sm leading-relaxed text-[#667085] md:text-base">
                    Pola, produksi, dan fitting digital dibahas dalam satu alur. Permintaan Anda dibaca orang, bukan portal otomatis.
                </p>
            </div>
        </div>
    </section>

    @php
        $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
        $whatsappMessage = rawurlencode((string) config('fitvendor.whatsapp.message'));
        $whatsappHref = $whatsappNumber !== '' ? 'https://wa.me/'.$whatsappNumber.'?text='.$whatsappMessage : null;
        $vendorEmail = trim((string) config('fitvendor.contact.email'));
        $vendorLocation = trim((string) config('fitvendor.contact.location'));
    @endphp

    <section class="bg-white px-5 py-14 lg:px-8">
        <div class="mx-auto grid max-w-[1200px] gap-10 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Hubungi kami</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-bold tracking-tight text-[#1C2430] md:text-4xl">Hubungi Kami</h2>
                <p class="mt-4 max-w-xl text-sm leading-relaxed text-[#667085] md:text-base">
                    Punya pertanyaan atau ingin membahas kebutuhan produksi?
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    @if ($whatsappHref)
                        <div class="rounded-[12px] border border-[#E2E5E9] bg-[#F7F7F5] p-5">
                            <span class="fv-contact-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
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
                        <div class="rounded-[12px] border border-[#E2E5E9] bg-[#F7F7F5] p-5">
                            <span class="fv-contact-icon" aria-hidden="true">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
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
                        <div class="rounded-[12px] border border-[#E2E5E9] bg-[#F7F7F5] p-5">
                            <span class="fv-contact-icon" aria-hidden="true">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
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
        </div>
    </section>

@endsection
