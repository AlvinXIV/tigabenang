@extends('layouts.customer')

@section('title', 'Virtual Fitting')
@section('description', 'Studio fitting 3D interaktif Clothiq. Sesuaikan ukuran tubuh dan amati estimasi ukuran pakaian secara digital.')

@section('content')

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="border-b border-border bg-primary">
        <div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">
            <span class="section-badge text-accent [&::before]:bg-accent mb-5">Virtual Fitting</span>
            <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl">Virtual Fitting Studio</h1>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/70">
                Adjust your body measurements to create a virtual figure.
                These measurements are used only for this virtual fitting session.
            </p>
        </div>
    </section>


    {{-- ── Main Studio ──────────────────────────────── --}}
    <section
        class="px-5 py-8 lg:px-8 lg:py-10"
        data-fitting-root
    >
        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-12">

            {{-- ── 3D Viewport ─────────────────────── --}}
            <div
                class="relative min-h-[520px] overflow-hidden rounded-2xl border border-border bg-surface-alt shadow-sm lg:col-span-7 lg:min-h-[680px]"
            >
                {{-- Three.js canvas --}}
                <div
                    id="fitting-viewport"
                    class="absolute inset-0"
                    aria-label="Virtual body 3D viewport"
                ></div>

                {{-- Label --}}
                <p class="pointer-events-none absolute left-4 top-4 rounded-full bg-white/80 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-text-muted backdrop-blur-sm">
                    Virtual Model
                </p>

                {{-- Status --}}
                <p
                    class="pointer-events-none absolute bottom-4 left-4 rounded-full bg-white/80 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-text-muted backdrop-blur-sm"
                    data-fitting-status
                >
                    Preparing studio
                </p>
            </div>


            {{-- ── Right Panel ──────────────────────── --}}
            <aside class="rounded-2xl border border-border bg-white overflow-hidden shadow-sm lg:col-span-5">

                {{-- Panel Header --}}
                <div class="border-b border-border bg-surface-alt px-5 py-4">
                    <span class="section-badge text-xs">Virtual Model</span>
                    <h2 class="mt-1.5 text-xl font-extrabold text-primary">Your Body Profile</h2>
                    <p class="mt-1 text-xs leading-relaxed text-text-muted">
                        Adjust the measurements to change the shape of the virtual figure.
                    </p>
                </div>

                {{-- Tabs --}}
                <div
                    class="flex border-b border-border"
                    role="tablist"
                    aria-label="Virtual fitting panels"
                >
                    <button
                        type="button"
                        class="flex-1 py-3.5 text-xs font-semibold uppercase tracking-[0.12em] transition-colors text-primary border-b-2 border-primary bg-primary-muted"
                        role="tab"
                        aria-selected="true"
                        data-fitting-tab="body"
                    >
                        Body
                    </button>
                    <button
                        type="button"
                        class="flex-1 py-3.5 text-xs font-semibold uppercase tracking-[0.12em] transition-colors text-text-muted border-b-2 border-transparent"
                        role="tab"
                        aria-selected="false"
                        data-fitting-tab="info"
                    >
                        Info
                    </button>
                </div>


                {{-- ── Body Panel ───────────────────── --}}
                <div
                    class="max-h-[520px] overflow-y-auto p-5 space-y-0"
                    data-fitting-panel="body"
                    role="tabpanel"
                >
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-text-subtle mb-4">Body Measurements</p>

                    <div class="space-y-3">

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
                                <label for="{{ $inp['id'] }}" class="block text-xs font-medium text-text-muted mb-1">
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
                                        class="w-full rounded-lg border border-border bg-surface-alt px-4 py-2.5 pr-12 text-sm font-semibold text-text-base focus:border-primary focus:ring-1 focus:ring-primary transition"
                                    >
                                    <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-medium text-text-subtle">cm</span>
                                </div>
                            </div>
                        @endforeach

                        {{-- Torso Type --}}
                        <div class="pt-1">
                            <p class="text-xs font-medium text-text-muted mb-2">Proporsi tubuh</p>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach (['short' => 'Short', 'normal' => 'Normal', 'long' => 'Long'] as $val => $label)
                                    <label
                                        class="flex cursor-pointer items-center justify-center rounded-lg border border-border bg-surface-alt px-3 py-2.5 text-xs font-semibold text-text-muted transition has-[:checked]:border-primary has-[:checked]:bg-primary-muted has-[:checked]:text-primary"
                                    >
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

                    {{-- Model Status --}}
                    <div class="mt-6 rounded-xl border border-border bg-surface-alt p-4">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-text-subtle">Model Status</p>
                        <p class="mt-1.5 text-sm font-semibold text-text-base">Virtual body ready.</p>
                        <p class="mt-0.5 text-xs text-text-muted">
                            Garments can be added later once the body profile is ready.
                        </p>
                    </div>
                </div>


                {{-- ── Info Panel ───────────────────── --}}
                <div
                    class="hidden p-5"
                    data-fitting-panel="info"
                    role="tabpanel"
                >
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-text-subtle mb-4">Panduan Pengukuran</p>

                    <div class="space-y-4">
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
                            <div class="rounded-lg border border-border bg-surface-alt p-3.5">
                                <p class="text-xs font-bold text-primary">{{ $term }}</p>
                                <p class="mt-1 text-xs leading-relaxed text-text-muted">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 rounded-xl border border-border bg-primary-muted p-4">
                        <p class="text-xs leading-relaxed text-primary/70">
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
