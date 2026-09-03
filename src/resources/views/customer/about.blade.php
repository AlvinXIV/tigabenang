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
                <span class="section-badge">Yang kami kerjakan</span>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:col-span-9">
                @foreach ([
                    ['title' => 'Pakaian custom', 'desc' => 'Varsity, work jacket, windbreaker, jersey, dan model lain dari koleksi yang tampil di situs.'],
                    ['title' => 'Pemilihan bahan', 'desc' => 'Pilih bahan yang memang tersedia untuk produk itu. Katalog menampilkan nama, bukan spek fiktif.'],
                    ['title' => 'Fitting digital', 'desc' => 'Satu manekin, satu pakaian. Proporsi terlihat sebelum Anda mengirim permintaan.'],
                ] as $item)
                    <div class="rounded-[14px] border border-[#E2E5E9] bg-white p-6">
                        <h3 class="text-base font-bold text-[#1C2430]">{{ $item['title'] }}</h3>
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
                        ['num' => '04', 'title' => 'Kirim permintaan',    'desc' => 'Isi data pemesan, rincian ukuran, dan catatan desain. Tanpa akun.'],
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

    <section class="bg-white px-5 py-14 lg:px-8">
        <div class="mx-auto grid max-w-[1200px] lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Kontak</span>
            </div>
            <div class="mt-4 lg:col-span-8 lg:mt-0">
                <p class="text-xl font-bold text-[#1C2430]">{{ config('fitvendor.contact.location') }}</p>
                <a href="mailto:{{ config('fitvendor.contact.email') }}" class="mt-2 block text-sm font-medium text-[#1C2430] underline underline-offset-2 hover:text-[#B8664A]">
                    {{ config('fitvendor.contact.email') }}
                </a>
                    <a href="{{ route('order.create') }}" class="btn-primary mt-6 inline-flex">
                    Mulai permintaan
                </a>
            </div>
        </div>
    </section>

@endsection
