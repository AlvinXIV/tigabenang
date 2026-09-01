@extends('layouts.customer')

@section('title', 'Bahan')
@section('description', 'Katalog bahan FitVendor. Nama kain mengikuti catatan produksi.')

@section('content')

    <section class="fv-page-hero">
        <div class="mx-auto max-w-[1200px] px-5 py-10 lg:px-8 lg:py-12">
            <span class="section-badge mb-3">Katalog bahan</span>
            <h1 class="text-3xl font-bold tracking-tight md:text-4xl">Bahan produksi</h1>
            <p class="mt-2.5 max-w-xl text-sm leading-relaxed">
                Nama di bawah ini diambil dari catatan bahan kami. Komposisi, gramasi, dan perawatan dibahas langsung dengan tim.
            </p>
        </div>
    </section>

    <section class="px-5 py-10 lg:px-8 lg:py-12">
        <div class="catalog-shell">
            @if ($materials->isNotEmpty())
                <div class="catalog-grid catalog-grid--3">
                    @foreach ($materials as $index => $bahan)
                        <x-material-item :bahan="$bahan" :lazy="$index > 2" />
                    @endforeach
                </div>
            @else
                <x-empty-state title="Katalog bahan masih kosong" message="Daftar bahan akan muncul di sini setelah ditambahkan." />
            @endif
        </div>
    </section>

@endsection
