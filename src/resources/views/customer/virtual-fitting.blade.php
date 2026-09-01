@extends('layouts.customer')

@section('title', 'Fitting virtual')
@section('description', 'Studio fitting 3D FitVendor. Sesuaikan ukuran tubuh dan lihat perkiraan tampilan pakaian.')

@section('content')

    <section class="fv-page-hero">
        <div class="mx-auto max-w-[1200px] px-5 py-10 lg:px-8 lg:py-12">
            <span class="section-badge mb-3">Studio interaktif</span>
            <h1 class="text-3xl font-bold tracking-tight md:text-4xl">Fitting virtual</h1>
            <p class="mt-2.5 max-w-2xl text-sm leading-relaxed">
                Gunakan fitting virtual untuk melihat perkiraan tampilan pakaian pada ukuran tubuh Anda.
            </p>
        </div>
    </section>

    <section class="px-5 py-8 lg:px-8 lg:py-10" data-fitting-root>
        <script type="application/json" data-fitting-catalog>{!! json_encode($catalog) !!}</script>

        <div class="mx-auto grid max-w-[1200px] gap-5 lg:grid-cols-12">

            <div
                class="vf-stage relative overflow-hidden rounded-[14px] border border-[#E2E5E9] bg-[#EEEFEC] lg:col-span-7"
                style="min-height:680px;height:680px;"
            >
                <script>
                    window.addEventListener('error', function(e) {
                        const err = document.createElement('div');
                        err.style.position = 'absolute';
                        err.style.inset = '0';
                        err.style.zIndex = '999999';
                        err.style.background = 'rgba(255,0,0,0.9)';
                        err.style.color = 'white';
                        err.style.padding = '20px';
                        err.style.overflow = 'auto';
                        err.style.fontFamily = 'monospace';
                        err.innerHTML = '<h2>CRITICAL JAVASCRIPT ERROR</h2><p>' + e.message + '</p><p>Line: ' + e.lineno + '</p><pre>' + (e.error && e.error.stack ? e.error.stack : '') + '</pre>';
                        document.getElementById('fitting-viewport').appendChild(err);
                    });
                    window.addEventListener('unhandledrejection', function(e) {
                        const err = document.createElement('div');
                        err.style.position = 'absolute';
                        err.style.inset = '0';
                        err.style.zIndex = '999999';
                        err.style.background = 'rgba(200,0,0,0.9)';
                        err.style.color = 'white';
                        err.style.padding = '20px';
                        err.style.overflow = 'auto';
                        err.style.fontFamily = 'monospace';
                        err.innerHTML = '<h2>UNHANDLED PROMISE REJECTION</h2><p>' + (e.reason && e.reason.message ? e.reason.message : e.reason) + '</p><pre>' + (e.reason && e.reason.stack ? e.reason.stack : '') + '</pre>';
                        document.getElementById('fitting-viewport').appendChild(err);
                    });
                </script>
                <div
                    id="fitting-viewport"
                    class="absolute inset-0"
                    style="width:100%;height:100%;min-height:680px;"
                    aria-label="Viewport tubuh 3D"
                ></div>

                <div class="pointer-events-none absolute left-4 top-4 flex flex-col gap-1.5">
                    <p class="rounded-lg border border-[#E2E5E9] bg-white/95 px-3 py-1.5 text-xs font-semibold text-[#1C2430]">
                        Manekin studio
                    </p>
                    <div class="flex items-center gap-3 rounded-[10px] border border-[#E2E5E9] bg-[#1C2430] p-3 text-white">
                        <div>
                            <p class="text-xs font-bold" data-fitting-name>Manekin studio</p>
                            <p class="text-[11px] text-white/70" data-fitting-category>Pratinjau kaos</p>
                        </div>
                    </div>
                </div>

                <div class="absolute right-4 top-4">
                    <span
                        class="inline-flex items-center rounded-lg border border-[#E2E5E9] bg-white/95 px-3 py-1.5 text-xs font-semibold text-[#1C2430]"
                        data-fitting-match
                    >
                        Menyiapkan pratinjau
                    </span>
                </div>

                <p
                    class="pointer-events-none absolute bottom-4 left-4 z-20 rounded-lg border border-[#E2E5E9] bg-white/95 px-3 py-1.5 text-xs font-semibold text-[#1C2430]"
                    data-fitting-status
                >
                    Menyiapkan studio
                </p>

                <button
                    type="button"
                    data-fitting-reset-view
                    class="absolute bottom-4 right-4 z-20 rounded-lg border border-[#E2E5E9] bg-white px-3 py-1.5 text-xs font-semibold text-[#1C2430]"
                >
                    Reset tampilan
                </button>
            </div>

            <aside class="flex flex-col justify-between overflow-hidden rounded-[14px] border border-[#E2E5E9] bg-white lg:col-span-5">
                <div>
                    <div class="border-b border-[#E2E5E9] bg-[#F7F7F5] px-5 py-4">
                        <span class="section-badge text-xs">Alat fitting</span>
                        <h2 class="mt-1 text-lg font-bold text-[#1C2430]">Kontrol pakaian dan tubuh</h2>
                        <p class="mt-1 text-xs leading-relaxed text-[#667085]">
                            Ganti model, pilih ukuran S sampai XXL, lalu sesuaikan ukuran tubuh.
                        </p>
                    </div>

                    <div class="flex border-b border-[#E2E5E9]" role="tablist" aria-label="Panel fitting virtual">
                        <button
                            type="button"
                            class="flex-1 border-b-2 border-[#1C2430] bg-[#F7F7F5] py-3 text-xs font-semibold text-[#1C2430]"
                            role="tab"
                            aria-selected="true"
                            data-fitting-tab="garment"
                        >
                            Pakaian dan ukuran
                        </button>
                        <button
                            type="button"
                            class="flex-1 border-b-2 border-transparent py-3 text-xs font-semibold text-[#667085]"
                            role="tab"
                            aria-selected="false"
                            data-fitting-tab="body"
                        >
                            Profil tubuh
                        </button>
                        <button
                            type="button"
                            class="flex-1 border-b-2 border-transparent py-3 text-xs font-semibold text-[#667085]"
                            role="tab"
                            aria-selected="false"
                            data-fitting-tab="info"
                        >
                            Info
                        </button>
                    </div>

                    <div class="space-y-5 p-5" data-fitting-panel="garment" role="tabpanel">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-[#1C2430]">Pilih model pakaian</label>
                            <select data-fitting-product class="fv-select">
                                @forelse ($products as $prod)
                                    <option value="{{ $prod->id_produk }}" @selected($selected && $selected->id_produk === $prod->id_produk)>
                                        {{ $prod->nama_produk }} ({{ $prod->kategori?->nama_kategori ?? 'Katalog' }})
                                    </option>
                                @empty
                                    <option value="t-shirt-preview" selected>Pratinjau kaos</option>
                                @endforelse
                            </select>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label class="text-sm font-semibold text-[#1C2430]">Uji ukuran pakaian</label>
                                <span class="rounded-[8px] border border-[#E2E5E9] bg-white px-2 py-0.5 text-[11px] font-medium text-[#1C2430]" data-fitting-size-label>
                                    Pratinjau ukuran: <span data-fitting-size>M</span>
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-2" data-fitting-size-buttons>
                                <button type="button" data-size="S" class="size-pill-btn rounded-lg border border-[#E2E5E9] bg-[#F7F7F5] px-3 py-2 text-xs font-semibold text-[#1C2430]">S</button>
                                <button type="button" data-size="M" class="size-pill-btn rounded-lg border border-[#E2E5E9] bg-[#F7F7F5] px-3 py-2 text-xs font-semibold text-[#1C2430]">M</button>
                                <button type="button" data-size="L" class="size-pill-btn rounded-lg border border-[#E2E5E9] bg-[#F7F7F5] px-3 py-2 text-xs font-semibold text-[#1C2430]">L</button>
                                <button type="button" data-size="XL" class="size-pill-btn rounded-lg border border-[#E2E5E9] bg-[#F7F7F5] px-3 py-2 text-xs font-semibold text-[#1C2430]">XL</button>
                                <button type="button" data-size="XXL" class="size-pill-btn rounded-lg border border-[#E2E5E9] bg-[#F7F7F5] px-3 py-2 text-xs font-semibold text-[#1C2430]">XXL</button>
                            </div>
                            <p class="mt-2 text-xs text-[#667085]">
                                Klik ukuran untuk melihat perubahan skala pakaian (ketat, pas, atau longgar).
                            </p>
                        </div>

                        <div class="rounded-xl border border-[#E2E5E9] bg-[#F7F7F5] p-4">
                            <p class="mb-2 text-xs font-semibold text-[#667085]">Catatan pratinjau</p>
                            <ul class="space-y-1.5 text-xs" data-fitting-heatmap>
                                <li class="flex items-center justify-between border-b border-[#E2E5E9] py-1">
                                    <span class="font-semibold text-[#1C2430]">Dada</span>
                                    <span class="text-[11px] font-semibold text-[#667085]">Memuat</span>
                                </li>
                                <li class="flex items-center justify-between border-b border-[#E2E5E9] py-1">
                                    <span class="font-semibold text-[#1C2430]">Bahu</span>
                                    <span class="text-[11px] font-semibold text-[#667085]">Memuat</span>
                                </li>
                                <li class="flex items-center justify-between py-1">
                                    <span class="font-semibold text-[#1C2430]">Pinggang</span>
                                    <span class="text-[11px] font-semibold text-[#667085]">Memuat</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="hidden max-h-[520px] space-y-0 overflow-y-auto p-5" data-fitting-panel="body" role="tabpanel">
                        <p class="mb-4 text-sm font-semibold text-[#667085]">Ukuran tubuh</p>
                        <div class="space-y-3">
                            @php
                                $inputs = [
                                    ['id' => 'fitting-height',       'label' => 'Tinggi badan',     'attr' => 'data-fitting-height',       'min' => 140, 'max' => 210, 'value' => 170],
                                    ['id' => 'fitting-chest',        'label' => 'Lingkar dada',     'attr' => 'data-fitting-chest',        'min' => 70,  'max' => 150, 'value' => 92],
                                    ['id' => 'fitting-waist',        'label' => 'Lingkar pinggang', 'attr' => 'data-fitting-waist',        'min' => 60,  'max' => 140, 'value' => 76],
                                    ['id' => 'fitting-hip',          'label' => 'Lingkar pinggul',  'attr' => 'data-fitting-hip',          'min' => 70,  'max' => 150, 'value' => 96],
                                    ['id' => 'fitting-shoulder',     'label' => 'Lebar bahu',       'attr' => 'data-fitting-shoulder',     'min' => 30,  'max' => 60,  'value' => 44],
                                    ['id' => 'fitting-arm-length',   'label' => 'Panjang lengan',   'attr' => 'data-fitting-arm-length',   'min' => 40,  'max' => 80,  'value' => 58],
                                    ['id' => 'fitting-torso-length', 'label' => 'Panjang torso',    'attr' => 'data-fitting-torso-length', 'min' => 30,  'max' => 60,  'value' => 44],
                                ];
                            @endphp
                            @foreach ($inputs as $inp)
                                <div>
                                    <label for="{{ $inp['id'] }}" class="mb-1 block text-sm font-semibold text-[#1C2430]">
                                        {{ $inp['label'] }}
                                    </label>
                                    <div class="relative">
                                        <input
                                            id="{{ $inp['id'] }}"
                                            type="number"
                                            min="{{ $inp['min'] }}"
                                            max="{{ $inp['max'] }}"
                                            step="1"
                                            value="{{ $inp['value'] }}"
                                            {{ $inp['attr'] }}
                                            class="fv-input pr-12 font-semibold"
                                        >
                                        <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#667085]">cm</span>
                                    </div>
                                </div>
                            @endforeach

                            <div class="pt-2">
                                <p class="mb-2 text-sm font-semibold text-[#1C2430]">Proporsi tubuh</p>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach (['short' => 'Pendek', 'normal' => 'Normal', 'long' => 'Panjang'] as $val => $label)
                                        <label class="flex cursor-pointer items-center justify-center rounded-xl border border-[#E2E5E9] bg-[#F7F7F5] px-3 py-2.5 text-xs font-semibold text-[#344054]">
                                            <input
                                                type="radio"
                                                name="torso-type"
                                                value="{{ $val }}"
                                                @checked($val === 'normal')
                                                class="sr-only"
                                                data-fitting-torso-type
                                            >
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden space-y-3 p-5" data-fitting-panel="info" role="tabpanel">
                        <p class="mb-3 text-sm font-semibold text-[#667085]">Panduan pengukuran</p>
                        @foreach ([
                            ['Tinggi badan',    'Ukur dari lantai ke puncak kepala. Berdiri tegak tanpa alas kaki.'],
                            ['Lingkar dada',    'Lingkarkan meteran di bagian dada terlebar, di bawah ketiak.'],
                            ['Lingkar pinggang','Ukur di bagian pinggang paling sempit, biasanya di atas pusar.'],
                            ['Lingkar pinggul', 'Lingkarkan meteran di bagian pinggul terlebar.'],
                            ['Lebar bahu',      'Ukur dari ujung bahu kiri ke ujung bahu kanan secara horizontal.'],
                            ['Panjang lengan',  'Ukur dari ujung bahu ke pergelangan tangan dengan siku sedikit ditekuk.'],
                            ['Panjang torso',   'Ukur dari titik bahu (dekat leher) ke garis pinggang alami.'],
                        ] as [$term, $desc])
                            <div class="rounded-xl border border-[#E2E5E9] bg-[#F7F7F5] p-3.5">
                                <p class="text-xs font-bold text-[#1C2430]">{{ $term }}</p>
                                <p class="mt-0.5 text-xs leading-relaxed text-[#667085]">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-[#E2E5E9] bg-[#F7F7F5] p-5">
                    <a href="{{ route('order.create') }}" class="btn-primary w-full">
                        Pesan ukuran ini
                    </a>
                </div>
            </aside>
        </div>
    </section>

@endsection

@push('vite-early')
    @vite(['resources/js/customer/virtual-fitting.js'])
@endpush
