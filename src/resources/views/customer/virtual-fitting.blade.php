@extends('layouts.customer')

@section('title', 'Virtual Fitting')
@section('description', 'Studio fitting 3D interaktif Clothiq. Sesuaikan ukuran tubuh dan amati estimasi ukuran pakaian secara digital.')

@section('content')

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="border-b border-border bg-primary" style="background-color:#172A39;border-color:#DCD6D0;">
        <div class="mx-auto max-w-7xl px-5 py-9 lg:px-8 lg:py-12">
            <span class="section-badge mb-3" style="color:#EAE2D8;">
                <span style="width:1.35rem;height:2.5px;background:#EAE2D8;border-radius:2px;display:inline-block;"></span>
                Virtual Fitting
            </span>
            <h1 class="text-3xl font-extrabold tracking-tight text-white md:text-4xl">Virtual Fitting Studio</h1>
            <p class="mt-2.5 max-w-2xl text-sm leading-relaxed text-white/75">
                Sesuaikan proporsi tubuh dan amati bagaimana pakaian 3D pas, sempit, atau longgar pada avatar digital Anda secara real-time.
            </p>
        </div>
    </section>


    {{-- ── Main Studio ──────────────────────────────── --}}
    <section
        class="px-5 py-8 lg:px-8 lg:py-10"
        data-fitting-root
        style="background:#FFFFFF;"
    >
        {{-- JSON Catalog Data --}}
        <script type="application/json" data-fitting-catalog>{!! json_encode($catalog) !!}</script>

        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-12">

            {{-- ── 3D Viewport ─────────────────────── --}}
            <div
                class="relative min-h-[540px] overflow-hidden rounded-2xl border bg-surface-alt shadow-sm lg:col-span-7 lg:min-h-[700px]"
                style="border-color:#DCD6D0;background-color:#FAF8F5;"
            >
                {{-- Global Error Handler --}}
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
                {{-- Three.js canvas --}}
                <div
                    id="fitting-viewport"
                    class="absolute inset-0"
                    aria-label="Virtual body 3D viewport"
                ></div>

                {{-- Product Pill Overlay --}}
                <div class="absolute left-4 top-4 flex flex-col gap-1.5 pointer-events-none">
                    <p class="rounded-full px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.18em] shadow-sm backdrop-blur-md" style="background:rgba(255,255,255,0.92);color:#172A39;border:1px solid #DCD6D0;">
                        Interactive 3D Fitting
                    </p>
                    <div class="rounded-xl p-3 shadow-md backdrop-blur-md flex items-center gap-3" style="background:rgba(23,42,57,0.92);color:#FFFFFF;border:1px solid rgba(255,255,255,0.15);">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
                        <div>
                            <p class="text-xs font-black" data-fitting-name>{{ $selected?->nama_produk ?? 'Katalog Pakaian' }}</p>
                            <p class="text-[10px] text-white/70 font-semibold" data-fitting-category>{{ $selected?->kategori?->nama_kategori ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Real-time Fit Badge on Top Right --}}
                <div class="absolute right-4 top-4">
                    <span
                        class="rounded-full px-4 py-1.5 text-[11px] font-black uppercase tracking-widest shadow-md backdrop-blur-md flex items-center gap-2"
                        style="background:rgba(255,255,255,0.95);color:#172A39;border:1.5px solid #DCD6D0;"
                        data-fitting-match
                    >
                        Analyzing Fit...
                    </span>
                </div>

                {{-- Status --}}
                <p
                    class="pointer-events-none absolute bottom-4 left-4 z-20 rounded-full px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-[0.15em] shadow-sm backdrop-blur-md transition-colors"
                    style="background:rgba(255,255,255,0.92);color:#172A39;border:1px solid #DCD6D0;"
                    data-fitting-status
                >
                    Preparing studio
                </p>
            </div>


            {{-- ── Right Control Panel ──────────────────────── --}}
            <aside class="rounded-2xl border bg-white overflow-hidden shadow-sm lg:col-span-5 flex flex-col justify-between" style="border-color:#DCD6D0;">

                <div>
                    {{-- Panel Header --}}
                    <div class="border-b px-6 py-5" style="background:#FAF8F5;border-color:#DCD6D0;">
                        <span class="section-badge text-xs" style="color:#172A39;">Fitting Studio</span>
                        <h2 class="mt-1.5 text-xl font-black" style="color:#172A39;">Fitting &amp; Body Controls</h2>
                        <p class="mt-1 text-xs leading-relaxed" style="color:#6E7575;">
                            Ganti produk, pilih ukuran pakaian (S/M/L/XL), dan sesuaikan ukuran tubuh avatar.
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
                            style="color:#172A39;border-color:#172A39;background:#FAF8F5;"
                            role="tab"
                            aria-selected="true"
                            data-fitting-tab="garment"
                        >
                            Garment &amp; Size
                        </button>

                        <button
                            type="button"
                            class="flex-1 py-3.5 text-xs font-bold uppercase tracking-[0.12em] transition-colors border-b-2 border-transparent"
                            style="color:#6E7575;"
                            role="tab"
                            aria-selected="false"
                            data-fitting-tab="body"
                        >
                            Body Profile
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

                    {{-- ── Panel 1: Garment & Size Selection ───────────────────── --}}
                    <div
                        class="p-6 space-y-6"
                        data-fitting-panel="garment"
                        role="tabpanel"
                    >
                        <!-- Product Selection Dropdown -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider mb-2" style="color:#172A39;">
                                Pilih Model Pakaian
                            </label>
                            <select
                                data-fitting-product
                                class="w-full rounded-xl border px-4 py-3 text-sm font-bold transition focus:outline-none"
                                style="border-color:#DCD6D0;background:#FAF8F5;color:#172A39;"
                            >
                                @foreach ($products as $prod)
                                    <option value="{{ $prod->id_produk }}" @selected($selected && $selected->id_produk === $prod->id_produk)>
                                        {{ $prod->nama_produk }} ({{ $prod->kategori?->nama_kategori ?? 'Katalog' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Size Selector Pills -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-black uppercase tracking-wider" style="color:#172A39;">
                                    Uji Coba Ukuran Pakaian
                                </label>
                                <span class="text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200" data-fitting-size-label>
                                    Auto: <span data-fitting-size>M</span>
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-2 pt-1" data-fitting-size-buttons>
                                <!-- Rendered dynamically or fallback buttons -->
                                <button type="button" data-size="S" class="size-pill-btn px-4 py-2 rounded-xl text-xs font-black border transition-all cursor-pointer" style="border-color:#DCD6D0;background:#FAF8F5;color:#172A39;">S</button>
                                <button type="button" data-size="M" class="size-pill-btn px-4 py-2 rounded-xl text-xs font-black border transition-all cursor-pointer" style="border-color:#DCD6D0;background:#FAF8F5;color:#172A39;">M</button>
                                <button type="button" data-size="L" class="size-pill-btn px-4 py-2 rounded-xl text-xs font-black border transition-all cursor-pointer" style="border-color:#DCD6D0;background:#FAF8F5;color:#172A39;">L</button>
                                <button type="button" data-size="XL" class="size-pill-btn px-4 py-2 rounded-xl text-xs font-black border transition-all cursor-pointer" style="border-color:#DCD6D0;background:#FAF8F5;color:#172A39;">XL</button>
                                <button type="button" data-size="XXL" class="size-pill-btn px-4 py-2 rounded-xl text-xs font-black border transition-all cursor-pointer" style="border-color:#DCD6D0;background:#FAF8F5;color:#172A39;">XXL</button>
                            </div>
                            <p class="text-[11px] text-[#6E7575] mt-2 font-medium">
                                💡 Klik ukuran di atas untuk melihat bagaimana pakaian berubah bentuk (ketat/pas/oversize).
                            </p>
                        </div>
                        <!-- DEBUG: Custom Adjustments -->
                        <div class="rounded-xl border p-4 mb-6" style="border-color:#DCD6D0;background:#FAF8F5;">
                            <p class="text-[10px] font-black uppercase tracking-[0.14em] mb-2 text-rose-600">Debug: Adjust Garment</p>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label class="text-[11px] font-bold text-[#172A39]">Garment Scale</label>
                                        <span id="debug-scale-val" class="text-[11px] font-mono text-[#6E7575]">1.00</span>
                                    </div>
                                    <input type="range" id="debug-scale" min="0.1" max="3.0" step="0.01" value="1.00" class="w-full accent-rose-600">
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label class="text-[11px] font-bold text-[#172A39]">Garment Y Offset</label>
                                        <span id="debug-y-val" class="text-[11px] font-mono text-[#6E7575]">0.00</span>
                                    </div>
                                    <input type="range" id="debug-y" min="-3.0" max="3.0" step="0.01" value="0.00" class="w-full accent-rose-600">
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label class="text-[11px] font-bold text-[#172A39]">Garment Z Offset (Maju/Mundur)</label>
                                        <span id="debug-z-val" class="text-[11px] font-mono text-[#6E7575]">0.00</span>
                                    </div>
                                    <input type="range" id="debug-z" min="-3.0" max="3.0" step="0.01" value="0.00" class="w-full accent-rose-600">
                                </div>
                            </div>
                        </div>

                        <!-- Fit Heatmap Analysis List -->
                        <div class="rounded-xl border p-4" style="border-color:#DCD6D0;background:#FAF8F5;">
                            <p class="text-[10px] font-black uppercase tracking-[0.14em] mb-2" style="color:#6E7575;">Analisis Tekanan Tubuh (Fit Heatmap)</p>
                            <ul class="space-y-1.5 text-xs" data-fitting-heatmap>
                                <li class="flex items-center justify-between py-1 border-b border-[#DCD6D0]/60">
                                    <span class="font-bold text-[#172A39]">Dada (Chest)</span>
                                    <span class="font-black text-xs uppercase" style="color:#172A39;">Evaluating</span>
                                </li>
                                <li class="flex items-center justify-between py-1 border-b border-[#DCD6D0]/60">
                                    <span class="font-bold text-[#172A39]">Bahu (Shoulder)</span>
                                    <span class="font-black text-xs uppercase" style="color:#172A39;">Evaluating</span>
                                </li>
                                <li class="flex items-center justify-between py-1">
                                    <span class="font-bold text-[#172A39]">Pinggang (Waist)</span>
                                    <span class="font-black text-xs uppercase" style="color:#172A39;">Evaluating</span>
                                </li>
                            </ul>
                        </div>
                    </div>


                    {{-- ── Panel 2: Body Measurements ───────────────────── --}}
                    <div
                        class="hidden max-h-[520px] overflow-y-auto p-6 space-y-0"
                        data-fitting-panel="body"
                        role="tabpanel"
                    >
                        <p class="text-xs font-bold uppercase tracking-[0.12em] mb-4" style="color:#6E7575;">Body Measurements</p>

                        <div class="space-y-3.5">

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
                                            style="border-color:#DCD6D0;background:#FAF8F5;color:#172A39;"
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
                                            style="border-color:#DCD6D0;background:#FAF8F5;color:#6E7575;"
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
                    </div>


                    {{-- ── Panel 3: Info Panel ───────────────────── --}}
                    <div
                        class="hidden p-6 space-y-3.5"
                        data-fitting-panel="info"
                        role="tabpanel"
                    >
                        <p class="text-xs font-bold uppercase tracking-[0.12em] mb-4" style="color:#6E7575;">Panduan Pengukuran</p>

                        @foreach ([
                            ['Tinggi badan',    'Ukur dari lantai ke puncak kepala. Berdiri tegak tanpa alas kaki.'],
                            ['Lingkar dada',    'Lingkarkan meteran di bagian dada terlebar, di bawah ketiak.'],
                            ['Lingkar pinggang','Ukur di bagian pinggang paling sempit, biasanya di atas pusar.'],
                            ['Lingkar pinggul', 'Lingkarkan meteran di bagian pinggul terlebar.'],
                            ['Lebar bahu',      'Ukur dari ujung bahu kiri ke ujung bahu kanan secara horizontal.'],
                            ['Panjang lengan',  'Ukur dari ujung bahu ke pergelangan tangan dengan siku sedikit ditekuk.'],
                            ['Panjang torso',   'Ukur dari titik bahu (dekat leher) ke garis pinggang alami.'],
                        ] as [$term, $desc])
                            <div class="rounded-xl border p-3.5" style="border-color:#DCD6D0;background:#FAF8F5;">
                                <p class="text-xs font-bold" style="color:#172A39;">{{ $term }}</p>
                                <p class="mt-0.5 text-xs leading-relaxed" style="color:#6E7575;">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Action Footer --}}
                <div class="p-6 border-t" style="border-color:#DCD6D0;background:#FAF8F5;">
                    <a
                        href="{{ route('order.create') }}"
                        class="w-full py-3.5 rounded-full flex items-center justify-center gap-2 text-xs font-extrabold uppercase tracking-wider text-white shadow-md transition-all cursor-pointer text-decoration-none"
                        style="background:linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%);"
                    >
                        <span>Pesan Ukuran Ini Sekarang &rarr;</span>
                    </a>
                </div>

            </aside>
        </div>
    </section>

@endsection

@push('vite')
    @vite(['resources/js/customer/virtual-fitting.js'])
@endpush
