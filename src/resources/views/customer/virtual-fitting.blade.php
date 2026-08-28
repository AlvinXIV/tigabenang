@extends('layouts.customer')

@section('title', 'Virtual Fitting')
@section('description', 'Studio fitting 3D interaktif Clothiq. Sesuaikan ukuran tubuh dan amati estimasi ukuran pakaian secara digital.')

@section('content')

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="border-b border-border bg-primary" style="background-color:#172A39;border-color:#DCD6D0;">
        <div class="mx-auto max-w-7xl px-5 py-12 lg:px-8 lg:py-16">
            <span class="section-badge mb-4" style="color:#FC563C;">
                <span style="width:1.5rem;height:3px;background:#FC563C;border-radius:2px;display:inline-block;"></span>
                Virtual Fitting
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl">Virtual Fitting Studio</h1>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/75">
                Adjust your body measurements to create a virtual figure.
                These measurements are used only for this virtual fitting session.
            </p>
        </div>
    </section>


    {{-- ── Main Studio ──────────────────────────────── --}}
    <section
        class="px-5 py-8 lg:px-8 lg:py-10"
        data-fitting-root
        style="background:#FFFFFF;"
    >
        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-12">

            {{-- ── 3D Viewport ─────────────────────── --}}
            <div
                class="relative min-h-[520px] overflow-hidden rounded-2xl border bg-surface-alt shadow-sm lg:col-span-7 lg:min-h-[680px]"
                style="border-color:#DCD6D0;background-color:#F6F4F1;"
            >
                {{-- Three.js canvas --}}
                <div
                    id="fitting-viewport"
                    class="absolute inset-0"
                    aria-label="Virtual body 3D viewport"
                ></div>

                {{-- Label --}}
                <p class="pointer-events-none absolute left-4 top-4 rounded-full px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-[0.18em] shadow-sm backdrop-blur-md" style="background:rgba(255,255,255,0.9);color:#172A39;border:1px solid #DCD6D0;">
                    Virtual Model
                </p>

                {{-- Status --}}
                <p
                    class="pointer-events-none absolute bottom-4 left-4 rounded-full px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-[0.15em] shadow-sm backdrop-blur-md"
                    style="background:rgba(255,255,255,0.9);color:#172A39;border:1px solid #DCD6D0;"
                    data-fitting-status
                >
                    Preparing studio
                </p>
            </div>


            {{-- ── Right Panel ──────────────────────── --}}
            <aside class="rounded-2xl border bg-white overflow-hidden shadow-sm lg:col-span-5" style="border-color:#DCD6D0;">

                {{-- Panel Header --}}
                <div class="border-b px-6 py-5" style="background:#F6F4F1;border-color:#DCD6D0;">
                    <span class="section-badge text-xs" style="color:#172A39;">Virtual Model</span>
                    <h2 class="mt-1.5 text-xl font-extrabold" style="color:#172A39;">Your Body Profile</h2>
                    <p class="mt-1 text-xs leading-relaxed" style="color:#6E7575;">
                        Adjust the measurements to change the shape of the virtual figure.
                    </p>
                </div>

                {{-- Tabs --}}
                <div
                    class="flex border-b"
                    style="border-color:#DCD6D0;"
                    role="tablist"
                    aria-label="Virtual fitting panels"
                >
                    <button
                        type="button"
                        class="flex-1 py-3.5 text-xs font-bold uppercase tracking-[0.12em] transition-colors border-b-2"
                        style="color:#172A39;border-color:#FC563C;background:#F6F4F1;"
                        role="tab"
                        aria-selected="true"
                        data-fitting-tab="body"
                    >
                        Body
                    </button>
                    <button
                        type="button"
                        class="flex-1 py-3.5 text-xs font-bold uppercase tracking-[0.12em] transition-colors border-b-2 border-transparent"
                        style="color:#6E7575;"
                        role="tab"
                        aria-selected="false"
                        data-fitting-tab="info"
                    >
                        Info
                    </button>
                </div>


                {{-- ── Body Panel ───────────────────── --}}
                <div
                    class="max-h-[520px] overflow-y-auto p-6 space-y-0"
                    data-fitting-panel="body"
                    role="tabpanel"
                >
                    <p class="text-xs font-bold uppercase tracking-[0.12em] mb-4" style="color:#6E7575;">Body Measurements</p>

                    <div class="space-y-3.5">

                        {{-- Helper macro: measurement input --}}
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
                                <label for="{{ $inp['id'] }}" class="block text-xs font-bold mb-1" style="color:#172A39;">
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
                                        class="w-full rounded-xl border px-4 py-2.5 pr-12 text-sm font-bold transition"
                                        style="border-color:#DCD6D0;background:#F6F4F1;color:#172A39;"
                                        onfocus="this.style.borderColor='#FC563C';this.style.background='#FFFFFF';"
                                        onblur="this.style.borderColor='#DCD6D0';this.style.background='#F6F4F1';"
                                    >
                                    <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:#6E7575;">cm</span>
                                </div>
                            </div>
                        @endforeach

                        {{-- Torso Type --}}
                        <div class="pt-2">
                            <p class="text-xs font-bold mb-2" style="color:#172A39;">Proporsi tubuh</p>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach (['short' => 'Short', 'normal' => 'Normal', 'long' => 'Long'] as $val => $label)
                                    <label
                                        class="flex cursor-pointer items-center justify-center rounded-xl border px-3 py-2.5 text-xs font-bold transition"
                                        style="border-color:#DCD6D0;background:#F6F4F1;color:#6E7575;"
                                    >
                                        <input
                                            type="radio"
                                            name="torso-type"
                                            value="{{ $val }}"
                                            @checked($val === 'normal')
                                            class="sr-only"
                                            data-fitting-torso-type
                                            onchange="document.querySelectorAll('[data-fitting-torso-type]').forEach(el => { el.parentElement.style.borderColor = el.checked ? '#FC563C' : '#DCD6D0'; el.parentElement.style.color = el.checked ? '#172A39' : '#6E7575'; el.parentElement.style.background = el.checked ? '#EAEFF4' : '#F6F4F1'; });"
                                        >
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- Model Status --}}
                    <div class="mt-6 rounded-xl border p-4" style="border-color:#DCD6D0;background:#F6F4F1;">
                        <p class="text-[10px] font-bold uppercase tracking-[0.12em]" style="color:#6E7575;">Model Status</p>
                        <p class="mt-1 text-sm font-extrabold" style="color:#172A39;">Virtual body ready.</p>
                        <p class="mt-0.5 text-xs" style="color:#6E7575;">
                            Garments can be tested once the body profile is ready.
                        </p>
                    </div>
                </div>


                {{-- ── Info Panel ───────────────────── --}}
                <div
                    class="hidden p-6"
                    data-fitting-panel="info"
                    role="tabpanel"
                >
                    <p class="text-xs font-bold uppercase tracking-[0.12em] mb-4" style="color:#6E7575;">Panduan Pengukuran</p>

                    <div class="space-y-3.5">
                        @foreach ([
                            ['Tinggi badan',    'Ukur dari lantai ke puncak kepala. Berdiri tegak tanpa alas kaki.'],
                            ['Lingkar dada',    'Lingkarkan meteran di bagian dada terlebar, di bawah ketiak.'],
                            ['Lingkar pinggang','Ukur di bagian pinggang paling sempit, biasanya di atas pusar.'],
                            ['Lingkar pinggul', 'Lingkarkan meteran di bagian pinggul terlebar.'],
                            ['Lebar bahu',      'Ukur dari ujung bahu kiri ke ujung bahu kanan secara horizontal.'],
                            ['Panjang lengan',  'Ukur dari ujung bahu ke pergelangan tangan dengan siku sedikit ditekuk.'],
                            ['Panjang torso',   'Ukur dari titik bahu (dekat leher) ke garis pinggang alami.'],
                            ['Proporsi tubuh',  'Pilih proporsi tubuh Anda. Short torso berarti badan atas lebih pendek dari kaki. Long torso berarti sebaliknya.'],
                        ] as [$term, $desc])
                            <div class="rounded-xl border p-4" style="border-color:#DCD6D0;background:#F6F4F1;">
                                <p class="text-xs font-bold" style="color:#172A39;">{{ $term }}</p>
                                <p class="mt-1 text-xs leading-relaxed" style="color:#6E7575;">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 rounded-xl border p-4" style="border-color:rgba(252,86,60,0.3);background:rgba(252,86,60,0.08);">
                        <p class="text-xs leading-relaxed" style="color:#172A39;">
                            Pengukuran hanya digunakan di sesi browser dan tidak disimpan di database.
                        </p>
                    </div>
                </div>

            </aside>
        </div>
    </section>

@endsection


{{-- ── Vite ─────────────────────────────────────── --}}
@push('vite')
    @vite(['resources/js/customer/virtual-fitting.js'])
@endpush
