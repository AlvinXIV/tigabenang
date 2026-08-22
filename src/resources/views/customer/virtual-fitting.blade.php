@extends('layouts.customer')

@section('title', 'Virtual Fitting')
@section('description', 'Preview a FitVendor garment on a single fitting figure. Measurements stay in this session only.')

@section('content')
    <section class="border-b border-line px-5 py-10 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">Virtual Fitting</p>
            <h1 class="mt-3 font-serif text-4xl text-charcoal md:text-5xl">See the garment on a single figure</h1>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-muted">
                Height and weight stay in this browser session. They are not saved, and they are not a medical or tailoring guarantee.
            </p>
        </div>
    </section>

    @if ($catalog->isEmpty())
        <section class="px-5 py-16 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <x-empty-state
                    title="No 3D garments yet"
                    message="Virtual fitting appears when a product has a file_model_3d. You can still browse the collection and send a request."
                >
                    <a href="{{ route('collection.index') }}" class="mt-6 inline-block text-[11px] uppercase tracking-[0.2em] text-terracotta">Browse collection</a>
                </x-empty-state>
            </div>
        </section>
    @else
        @push('vite')
            @vite(['resources/js/customer/virtual-fitting.js'])
        @endpush
        <section class="px-5 py-8 lg:px-8 lg:py-10" data-fitting-root>
            <script type="application/json" data-fitting-catalog>@json($catalog)</script>
            <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-12">
                <div class="relative min-h-[480px] border border-line bg-ivory-deep lg:col-span-7 lg:min-h-[720px]">
                    <div id="fitting-viewport" class="absolute inset-0" aria-label="3D fitting viewport"></div>
                    <p class="pointer-events-none absolute left-4 top-4 text-[10px] uppercase tracking-[0.22em] text-muted">One figure</p>
                    <p class="pointer-events-none absolute bottom-4 left-4 text-[10px] uppercase tracking-[0.18em] text-muted" data-fitting-status>Preparing studio</p>
                </div>

                <aside class="border border-line bg-paper lg:col-span-5">
                    <div class="border-b border-line p-5">
                        <label for="fitting-product" class="text-[11px] uppercase tracking-[0.2em] text-muted">Garment</label>
                        <select id="fitting-product" data-fitting-product class="mt-2 w-full border-b border-line bg-transparent py-2 text-charcoal">
                            @foreach ($products as $produk)
                                <option value="{{ $produk->id_produk }}" @selected((int) $selected?->id_produk === (int) $produk->id_produk)>
                                    {{ $produk->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-3 font-serif text-2xl text-charcoal" data-fitting-name>{{ $selected?->nama_produk }}</p>
                        <p class="text-sm text-muted" data-fitting-category>{{ $selected?->kategori?->nama_kategori }}</p>
                        <p class="mt-2 text-[11px] uppercase tracking-[0.16em] text-muted" data-fitting-sizes></p>
                    </div>

                    <div class="flex border-b border-line" role="tablist" aria-label="Fitting panels">
                        <button type="button" class="flex-1 py-3 text-[11px] uppercase tracking-[0.18em] text-terracotta" role="tab" aria-selected="true" data-fitting-tab="body">
                            Body
                        </button>
                        <button type="button" class="flex-1 py-3 text-[11px] uppercase tracking-[0.18em] text-muted" role="tab" aria-selected="false" data-fitting-tab="heatmap">
                            Heatmap
                        </button>
                    </div>

                    <div class="p-5" data-fitting-panel="body" role="tabpanel">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Body measurements</p>
                        <p class="mt-2 text-xs leading-relaxed text-muted">Temporary for this session. Not stored in the database.</p>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div>
                                <label for="fitting-height" class="text-xs text-muted">Height (cm)</label>
                                <input id="fitting-height" type="number" min="140" max="210" value="170" data-fitting-height class="mt-2 w-full border-b border-line bg-transparent py-2">
                            </div>
                            <div>
                                <label for="fitting-weight" class="text-xs text-muted">Weight (kg)</label>
                                <input id="fitting-weight" type="number" min="40" max="160" value="68" data-fitting-weight class="mt-2 w-full border-b border-line bg-transparent py-2">
                            </div>
                        </div>

                        <div class="mt-8 border-t border-line pt-6">
                            <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Fit analysis</p>
                            <p class="mt-1 text-xs text-muted">Demo estimate — replaceable algorithm, not a physical measurement.</p>
                            <div class="mt-5 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-muted">Recommended size</p>
                                    <p class="mt-1 font-serif text-3xl" data-fitting-size>—</p>
                                </div>
                                <div>
                                    <p class="text-xs text-muted">Overall match</p>
                                    <p class="mt-1 font-serif text-3xl" data-fitting-match>—</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden p-5" data-fitting-panel="heatmap" role="tabpanel">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Fit heatmap</p>
                        <p class="mt-1 text-xs text-muted">Visual output only. Too tight / perfect / too loose are demo states.</p>
                        <ul class="mt-6 space-y-4" data-fitting-heatmap></ul>
                    </div>
                </aside>
            </div>
        </section>
    @endif
@endsection
