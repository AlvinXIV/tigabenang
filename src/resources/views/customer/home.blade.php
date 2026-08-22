@extends('layouts.customer')

@section('title', 'FitVendor')
@section('description', 'Custom clothing crafted with thoughtful materials, precise sizing, and modern fitting technology.')

@section('content')
    {{-- Place a hero photograph at public/images/hero.jpg to replace this editorial block. --}}
    <section class="border-b border-line">
        <div class="mx-auto grid max-w-7xl lg:grid-cols-12">
            <div class="flex flex-col justify-center px-5 py-16 lg:col-span-6 lg:px-8 lg:py-28">
                <p class="text-[11px] uppercase tracking-[0.32em] text-terracotta">FitVendor / Custom Clothing</p>
                <h1 class="mt-6 max-w-xl font-serif text-5xl leading-[0.95] text-charcoal md:text-7xl">
                    Find Your Perfect Fit
                </h1>
                <p class="mt-6 max-w-md text-base leading-relaxed text-muted">
                    Custom clothing crafted with thoughtful materials, precise sizing, and modern fitting technology.
                </p>
                <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('collection.index') }}" class="inline-flex items-center justify-center bg-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-ivory transition-colors hover:bg-terracotta">
                        Explore Collection
                    </a>
                    <a href="{{ route('virtual-fitting') }}" class="inline-flex items-center justify-center border border-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-charcoal transition-colors hover:border-terracotta hover:text-terracotta">
                        Try Virtual Fitting
                    </a>
                </div>
            </div>

            <div class="relative min-h-[420px] bg-ivory-deep lg:col-span-6 lg:min-h-[640px]">
                @if ($heroImageUrl)
                    <img src="{{ $heroImageUrl }}" alt="FitVendor custom clothing" width="1200" height="1600" class="absolute inset-0 h-full w-full object-cover" fetchpriority="high" decoding="async">
                @else
                    <div class="absolute inset-0 flex flex-col justify-between p-8 lg:p-12">
                        <p class="text-[11px] uppercase tracking-[0.3em] text-muted">Lookbook</p>
                        <div>
                            <p class="font-serif text-6xl leading-none text-charcoal/20 md:text-8xl">01</p>
                            <p class="mt-4 max-w-xs font-serif text-3xl text-charcoal">Garments made for the body that will wear them.</p>
                        </div>
                        <p class="text-[11px] uppercase tracking-[0.22em] text-muted">Add public/images/hero.jpg</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="work" class="border-b border-line px-5 py-20 lg:px-8 lg:py-28">
        <div class="mx-auto max-w-7xl">
            <x-section-heading
                eyebrow="Our Work"
                title="Crafted for Every Story"
                action-label="View Full Collection"
                action-url="{{ route('collection.index') }}"
            />

            @if ($featuredProduct)
                <div class="mt-14 grid gap-8 lg:grid-cols-12">
                    <div class="lg:col-span-7">
                        <x-product-card :produk="$featuredProduct" :featured="true" :show-price="false" :lazy="false" />
                    </div>
                    <div class="grid gap-8 sm:grid-cols-2 lg:col-span-5 lg:grid-cols-1">
                        @forelse ($supportingProducts as $index => $produk)
                            <x-product-card :produk="$produk" :show-price="false" :lazy="$index > 0" />
                        @empty
                            <p class="text-sm text-muted">More garments will appear here as the collection grows.</p>
                        @endforelse
                    </div>
                </div>
            @else
                <div class="mt-14">
                    <x-empty-state title="Collection coming soon" message="Featured garments will appear here once products are added." />
                </div>
            @endif
        </div>
    </section>

    <section class="border-b border-line bg-paper px-5 py-20 lg:px-8 lg:py-28">
        <div class="mx-auto max-w-7xl">
            <x-section-heading
                title="Every Garment Starts With the Right Material"
                action-label="Explore Materials"
                action-url="{{ route('materials.index') }}"
            />

            @if ($materials->isNotEmpty())
                <div class="mt-14 grid gap-px bg-line sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($materials as $bahan)
                        <x-material-item :bahan="$bahan" />
                    @endforeach
                </div>
            @else
                <div class="mt-14">
                    <x-empty-state title="Materials coming soon" message="The material library will appear here once bahan records are available." />
                </div>
            @endif
        </div>
    </section>

    <section class="border-b border-line px-5 py-20 lg:px-8 lg:py-28">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-6">
                <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">Virtual Fitting</p>
                <h2 class="mt-3 font-serif text-4xl leading-tight text-charcoal md:text-5xl">See the Garment Before You Request It</h2>
                <p class="mt-5 max-w-md text-sm leading-relaxed text-muted md:text-base">
                    Preview silhouette, proportion, and presence on a single fitting figure — then request production when it feels right.
                </p>
                <a href="{{ route('virtual-fitting') }}" class="mt-8 inline-flex bg-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-ivory transition-colors hover:bg-terracotta">
                    Try Virtual Fitting
                </a>
            </div>

            <div class="border border-line bg-ivory-deep lg:col-span-6">
                <div class="grid gap-0 md:grid-cols-5">
                    <div class="relative min-h-[320px] md:col-span-3">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="h-48 w-24 rounded-full border border-line/80 bg-sand/40"></div>
                        </div>
                        <p class="absolute left-5 top-5 text-[10px] uppercase tracking-[0.22em] text-muted">3D preview</p>
                    </div>
                    <div class="border-t border-line p-6 md:col-span-2 md:border-l md:border-t-0">
                        <p class="text-[10px] uppercase tracking-[0.22em] text-muted">Selected garment</p>
                        @if ($fittingProduct)
                            <p class="mt-3 font-serif text-2xl text-charcoal">{{ $fittingProduct->nama_produk }}</p>
                            <p class="mt-2 text-sm text-muted">{{ $fittingProduct->kategori?->nama_kategori }}</p>
                        @else
                            <p class="mt-3 font-serif text-2xl text-charcoal">Fitting studio</p>
                            <p class="mt-2 text-sm text-muted">A 3D garment will appear here when a product includes a model file.</p>
                        @endif
                        <div class="mt-8 border-t border-line pt-5">
                            <p class="text-[10px] uppercase tracking-[0.22em] text-muted">Visual result</p>
                            <p class="mt-2 text-sm text-ink">Silhouette study · one figure</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-5 py-20 lg:px-8 lg:py-28">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="font-serif text-4xl leading-tight text-charcoal md:text-6xl">From Your Idea to a Finished Garment</h2>
            <p class="mx-auto mt-6 max-w-xl text-base leading-relaxed text-muted">
                Explore garments, choose materials, visualize the fit, and start your production request.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ route('collection.index') }}" class="inline-flex bg-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-ivory hover:bg-terracotta">
                    Explore Collection
                </a>
                <a href="{{ route('about') }}" class="inline-flex border border-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-charcoal hover:border-terracotta hover:text-terracotta">
                    About FitVendor
                </a>
            </div>
        </div>
    </section>
@endsection
