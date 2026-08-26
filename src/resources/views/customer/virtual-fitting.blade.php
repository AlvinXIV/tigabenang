@extends('layouts.customer')

@section('title', 'Virtual Fitting')

@section('description', 'Create your virtual body profile for FitVendor virtual fitting.')

@section('content')

    {{-- ============================================================
        HEADER
    ============================================================= --}}
    <section class="border-b border-line px-5 py-10 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">
                Virtual Fitting
            </p>

            <h1 class="mt-3 font-serif text-4xl text-charcoal md:text-5xl">
                Your Body Profile
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-muted">
                Adjust your body measurements to create a virtual figure.
                These measurements are used only for this virtual fitting session.
            </p>

        </div>
    </section>


    {{-- ============================================================
        VIRTUAL FITTING
    ============================================================= --}}
    <section
        class="px-5 py-8 lg:px-8 lg:py-10"
        data-fitting-root
    >

        <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-12">


            {{-- ====================================================
                3D VIEWPORT
            ===================================================== --}}
            <div
                class="relative min-h-[600px] overflow-hidden border border-line bg-ivory-deep lg:col-span-7 lg:min-h-[720px]"
            >

                {{-- Three.js akan masuk ke sini --}}
                <div
                    id="fitting-viewport"
                    class="absolute inset-0"
                    aria-label="Virtual body 3D viewport"
                ></div>


                {{-- Label atas --}}
                <p
                    class="pointer-events-none absolute left-5 top-5 text-[10px] uppercase tracking-[0.22em] text-muted"
                >
                    Virtual Model
                </p>


                {{-- Status --}}
                <p
                    class="pointer-events-none absolute bottom-5 left-5 text-[10px] uppercase tracking-[0.18em] text-muted"
                    data-fitting-status
                >
                    Preparing studio
                </p>

            </div>


            {{-- ====================================================
                RIGHT PANEL
            ===================================================== --}}
            <aside
                class="border border-line bg-paper lg:col-span-5"
            >


                {{-- ================================================
                    PANEL HEADER
                ================================================= --}}
                <div class="border-b border-line p-6">

                    <p
                        class="text-[11px] uppercase tracking-[0.28em] text-terracotta"
                    >
                        Virtual Model
                    </p>

                    <h2
                        class="mt-2 font-serif text-3xl text-charcoal md:text-4xl"
                    >
                        Your Body Profile
                    </h2>

                    <p
                        class="mt-2 text-sm leading-relaxed text-muted"
                    >
                        Adjust the measurements to change the shape
                        of the virtual figure.
                    </p>

                </div>


                {{-- ================================================
                    TABS
                ================================================= --}}
                <div
                    class="flex border-b border-line"
                    role="tablist"
                    aria-label="Virtual fitting panels"
                >

                    <button
                        type="button"
                        class="flex-1 py-4 text-[11px] uppercase tracking-[0.2em] text-terracotta"
                        role="tab"
                        aria-selected="true"
                        data-fitting-tab="body"
                    >
                        Body
                    </button>

                    <button
                        type="button"
                        class="flex-1 py-4 text-[11px] uppercase tracking-[0.2em] text-muted"
                        role="tab"
                        aria-selected="false"
                        data-fitting-tab="info"
                    >
                        Info
                    </button>

                </div>


                {{-- ====================================================
                    BODY PANEL
                ===================================================== --}}
                <div
                    class="max-h-[520px] overflow-y-auto p-6"
                    data-fitting-panel="body"
                    role="tabpanel"
                >

                    <p
                        class="text-[11px] uppercase tracking-[0.2em] text-muted"
                    >
                        Body Measurements
                    </p>

                    <p
                        class="mt-2 text-xs leading-relaxed text-muted"
                    >
                        Enter your measurements below to shape the
                        virtual figure.
                    </p>


                    {{-- ============================================
                        MEASUREMENTS
                    ============================================= --}}
                    <div class="mt-7 space-y-5">


                        {{-- HEIGHT --}}
                        <div>

                            <label
                                for="fitting-height"
                                class="text-xs text-muted"
                            >
                                Tinggi badan
                            </label>

                            <div class="relative mt-2">

                                <input
                                    id="fitting-height"
                                    type="number"
                                    min="140"
                                    max="210"
                                    step="1"
                                    value="170"
                                    data-fitting-height
                                    class="w-full border border-line bg-transparent px-4 py-3 pr-14 text-charcoal outline-none transition focus:border-terracotta"
                                >

                                <span
                                    class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-muted"
                                >
                                    cm
                                </span>

                            </div>

                        </div>


                        {{-- CHEST --}}
                        <div>

                            <label
                                for="fitting-chest"
                                class="text-xs text-muted"
                            >
                                Lingkar dada
                            </label>

                            <div class="relative mt-2">

                                <input
                                    id="fitting-chest"
                                    type="number"
                                    min="70"
                                    max="150"
                                    step="1"
                                    value="92"
                                    data-fitting-chest
                                    class="w-full border border-line bg-transparent px-4 py-3 pr-14 text-charcoal outline-none transition focus:border-terracotta"
                                >

                                <span
                                    class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-muted"
                                >
                                    cm
                                </span>

                            </div>

                        </div>


                        {{-- WAIST --}}
                        <div>

                            <label
                                for="fitting-waist"
                                class="text-xs text-muted"
                            >
                                Lingkar pinggang
                            </label>

                            <div class="relative mt-2">

                                <input
                                    id="fitting-waist"
                                    type="number"
                                    min="60"
                                    max="140"
                                    step="1"
                                    value="76"
                                    data-fitting-waist
                                    class="w-full border border-line bg-transparent px-4 py-3 pr-14 text-charcoal outline-none transition focus:border-terracotta"
                                >

                                <span
                                    class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-muted"
                                >
                                    cm
                                </span>

                            </div>

                        </div>


                        {{-- HIP --}}
                        <div>

                            <label
                                for="fitting-hip"
                                class="text-xs text-muted"
                            >
                                Lingkar pinggul
                            </label>

                            <div class="relative mt-2">

                                <input
                                    id="fitting-hip"
                                    type="number"
                                    min="70"
                                    max="150"
                                    step="1"
                                    value="96"
                                    data-fitting-hip
                                    class="w-full border border-line bg-transparent px-4 py-3 pr-14 text-charcoal outline-none transition focus:border-terracotta"
                                >

                                <span
                                    class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-muted"
                                >
                                    cm
                                </span>

                            </div>

                        </div>


                        {{-- SHOULDER --}}
                        <div>

                            <label
                                for="fitting-shoulder"
                                class="text-xs text-muted"
                            >
                                Lebar bahu
                            </label>

                            <div class="relative mt-2">

                                <input
                                    id="fitting-shoulder"
                                    type="number"
                                    min="30"
                                    max="60"
                                    step="1"
                                    value="44"
                                    data-fitting-shoulder
                                    class="w-full border border-line bg-transparent px-4 py-3 pr-14 text-charcoal outline-none transition focus:border-terracotta"
                                >

                                <span
                                    class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-muted"
                                >
                                    cm
                                </span>

                            </div>

                        </div>


                        {{-- ARM LENGTH --}}
                        <div>

                            <label
                                for="fitting-arm-length"
                                class="text-xs text-muted"
                            >
                                Panjang lengan
                            </label>

                            <div class="relative mt-2">

                                <input
                                    id="fitting-arm-length"
                                    type="number"
                                    min="40"
                                    max="80"
                                    step="1"
                                    value="58"
                                    data-fitting-arm-length
                                    class="w-full border border-line bg-transparent px-4 py-3 pr-14 text-charcoal outline-none transition focus:border-terracotta"
                                >

                                <span
                                    class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-muted"
                                >
                                    cm
                                </span>

                            </div>

                        </div>


                        {{-- TORSO LENGTH --}}
                        <div>

                            <label
                                for="fitting-torso-length"
                                class="text-xs text-muted"
                            >
                                Panjang torso
                            </label>

                            <div class="relative mt-2">

                                <input
                                    id="fitting-torso-length"
                                    type="number"
                                    min="30"
                                    max="60"
                                    step="1"
                                    value="44"
                                    data-fitting-torso-length
                                    class="w-full border border-line bg-transparent px-4 py-3 pr-14 text-charcoal outline-none transition focus:border-terracotta"
                                >

                                <span
                                    class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-muted"
                                >
                                    cm
                                </span>

                            </div>

                        </div>


                        {{-- TORSO TYPE --}}
                        <div>

                            <p class="text-xs text-muted">
                                Proporsi tubuh
                            </p>

                            <div class="mt-3 flex gap-3">

                                <label
                                    class="group flex flex-1 cursor-pointer items-center justify-center gap-2 border border-line px-3 py-3 text-xs text-charcoal transition has-[:checked]:border-terracotta has-[:checked]:bg-terracotta/5"
                                >
                                    <input
                                        type="radio"
                                        name="torso-type"
                                        value="short"
                                        class="sr-only"
                                        data-fitting-torso-type
                                    >
                                    Short
                                </label>

                                <label
                                    class="group flex flex-1 cursor-pointer items-center justify-center gap-2 border border-line px-3 py-3 text-xs text-charcoal transition has-[:checked]:border-terracotta has-[:checked]:bg-terracotta/5"
                                >
                                    <input
                                        type="radio"
                                        name="torso-type"
                                        value="normal"
                                        checked
                                        class="sr-only"
                                        data-fitting-torso-type
                                    >
                                    Normal
                                </label>

                                <label
                                    class="group flex flex-1 cursor-pointer items-center justify-center gap-2 border border-line px-3 py-3 text-xs text-charcoal transition has-[:checked]:border-terracotta has-[:checked]:bg-terracotta/5"
                                >
                                    <input
                                        type="radio"
                                        name="torso-type"
                                        value="long"
                                        class="sr-only"
                                        data-fitting-torso-type
                                    >
                                    Long
                                </label>

                            </div>

                        </div>


                    </div>


                    {{-- ============================================
                        MODEL STATUS
                    ============================================= --}}
                    <div class="mt-8 border-t border-line pt-6">

                        <p
                            class="text-[11px] uppercase tracking-[0.2em] text-muted"
                        >
                            Model Status
                        </p>

                        <p
                            class="mt-3 text-sm text-charcoal"
                        >
                            Virtual body ready.
                        </p>

                        <p
                            class="mt-1 text-xs leading-relaxed text-muted"
                        >
                            Garments can be added later once the body
                            profile is ready.
                        </p>

                    </div>

                </div>


                {{-- ====================================================
                    INFO PANEL
                ===================================================== --}}
                <div
                    class="hidden p-6"
                    data-fitting-panel="info"
                    role="tabpanel"
                >

                    <p
                        class="text-[11px] uppercase tracking-[0.2em] text-muted"
                    >
                        Panduan Pengukuran
                    </p>

                    <div class="mt-5 space-y-5 text-sm leading-relaxed text-muted">

                        <div>
                            <p class="font-medium text-charcoal">
                                Tinggi badan
                            </p>

                            <p class="mt-1">
                                Ukur dari lantai ke puncak kepala.
                                Berdiri tegak tanpa alas kaki.
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-charcoal">
                                Lingkar dada
                            </p>

                            <p class="mt-1">
                                Lingkarkan meteran di bagian dada
                                terlebar, di bawah ketiak.
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-charcoal">
                                Lingkar pinggang
                            </p>

                            <p class="mt-1">
                                Ukur di bagian pinggang paling sempit,
                                biasanya di atas pusar.
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-charcoal">
                                Lingkar pinggul
                            </p>

                            <p class="mt-1">
                                Lingkarkan meteran di bagian pinggul
                                terlebar.
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-charcoal">
                                Lebar bahu
                            </p>

                            <p class="mt-1">
                                Ukur dari ujung bahu kiri ke ujung
                                bahu kanan secara horizontal.
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-charcoal">
                                Panjang lengan
                            </p>

                            <p class="mt-1">
                                Ukur dari ujung bahu ke pergelangan
                                tangan dengan siku sedikit ditekuk.
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-charcoal">
                                Panjang torso
                            </p>

                            <p class="mt-1">
                                Ukur dari titik bahu (dekat leher)
                                ke garis pinggang alami.
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-charcoal">
                                Proporsi tubuh
                            </p>

                            <p class="mt-1">
                                Pilih proporsi tubuh Anda. Short torso
                                berarti badan atas lebih pendek dari
                                kaki. Long torso berarti sebaliknya.
                            </p>
                        </div>

                    </div>

                    <div class="mt-8 border-t border-line pt-6">

                        <p
                            class="text-xs leading-relaxed text-muted"
                        >
                            Pengukuran hanya digunakan di sesi
                            browser dan tidak disimpan di database.
                        </p>

                    </div>

                </div>

            </aside>

        </div>

    </section>

@endsection


{{-- ================================================================
    VITE
================================================================ --}}
@push('vite')

    @vite([
        'resources/js/customer/virtual-fitting.js'
    ])

@endpush