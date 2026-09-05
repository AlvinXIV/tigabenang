@extends('layouts.customer')

@section('title', $product->nama_produk)
@section('description', \App\Support\CustomerCatalog::categoryLabel($product->kategori?->nama_kategori).' - pakaian custom FitVendor')

@php
    use App\Support\CustomerCatalog;
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::productImageUrl($product);
    $hasModel = filled($product->file_model_3d);
    $categoryLabel = CustomerCatalog::categoryLabel($product->kategori?->nama_kategori);
    $displayMaterials = CustomerCatalog::previewMaterials(
        $product->bahan,
        $product->kategori?->nama_kategori,
        $product->id_produk
    );
@endphp

@section('content')

    <section class="border-b border-[#E2E5E9] bg-white">
        <div class="mx-auto grid max-w-[1200px] items-start gap-10 px-5 py-10 lg:grid-cols-12 lg:gap-12 lg:px-8 lg:py-14">
            <div class="lg:col-span-5">
                <div class="fv-media relative aspect-[3/4]">
                    @if ($imageUrl)
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $product->nama_produk }}"
                            width="600" height="800"
                            fetchpriority="high" decoding="async"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full flex-col items-center justify-center gap-2 p-8 text-center">
                            <p class="text-xs font-medium text-[#667085]">{{ $categoryLabel !== '' ? $categoryLabel : 'Produk' }}</p>
                            <p class="text-lg font-bold text-[#1C2430]">{{ $product->nama_produk }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-[14px] border border-[#E2E5E9] bg-[#F7F7F5] p-6 sm:p-8 lg:col-span-7">
                @if ($categoryLabel !== '')
                    <p class="mb-3 text-sm font-medium text-[#667085]">{{ $categoryLabel }}</p>
                @endif

                <h1 class="text-[clamp(1.75rem,3.5vw,2.75rem)] font-bold leading-tight tracking-tight text-[#1C2430]">
                    {{ $product->nama_produk }}
                </h1>

                <p class="mt-4 text-2xl font-bold text-[#1C2430]">
                    Estimasi mulai <x-price :amount="$product->harga" /> / pcs
                </p>

                @if (filled($product->deskripsi ?? null))
                    <p class="mt-4 text-sm leading-relaxed text-[#667085]">{{ $product->deskripsi }}</p>
                @endif

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a
                        href="{{ route('order.create', ['product' => $product->id_produk]) }}"
                        class="btn-primary product-request-action"
                    >
                        Pesan produk ini
                    </a>
                    @if ($hasModel)
                        <a href="{{ route('virtual-fitting', ['product' => $product->id_produk]) }}" class="btn-outline">
                            Lihat di fitting 3D
                        </a>
                    @endif
                </div>

                @if ($hasModel)
                    <div class="mt-6">
                        <span class="rounded-[8px] border border-[#E2E5E9] bg-white px-3 py-1.5 text-xs font-medium text-[#1C2430]">Ada pratinjau 3D</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="border-b border-[#E2E5E9] bg-[#F7F7F5] py-12">
        <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
            <span class="section-badge mb-2">Bahan</span>
            <h2 class="mb-1 text-xl font-bold text-[#1C2430]">Bahan tersedia</h2>
            <p class="mb-5 text-sm text-[#667085]">Bahan yang terhubung dengan produk ini.</p>
            @if ($displayMaterials->isNotEmpty())
                <ul class="fv-material-thumbs">
                    @foreach ($displayMaterials as $bahan)
                        @php
                            $materialImageUrl = CustomerMedia::materialImageUrl($bahan->nama_bahan);
                        @endphp
                        <li>
                            @if ($materialImageUrl)
                                <button
                                    type="button"
                                    class="fv-material-thumb"
                                    data-material-src="{{ $materialImageUrl }}"
                                    data-material-name="{{ $bahan->nama_bahan }}"
                                >
                                    <span class="fv-material-thumb__frame">
                                        <img
                                            src="{{ $materialImageUrl }}"
                                            alt="{{ $bahan->nama_bahan }}"
                                            width="96"
                                            height="96"
                                        >
                                    </span>
                                    <span class="fv-material-thumb__name">{{ $bahan->nama_bahan }}</span>
                                </button>
                            @else
                                <div class="fv-material-thumb fv-material-thumb--static">
                                    <span class="fv-material-thumb__frame fv-material-thumb__frame--empty">
                                        <span>Pratinjau bahan</span>
                                    </span>
                                    <span class="fv-material-thumb__name">{{ $bahan->nama_bahan }}</span>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-[#667085]">Belum ada bahan yang dipasangkan ke produk ini.</p>
            @endif
        </div>
    </section>

    <div
        id="material-lightbox"
        class="fv-material-lightbox"
        hidden
        role="dialog"
        aria-modal="true"
        aria-labelledby="material-lightbox-title"
    >
        <button type="button" class="fv-material-lightbox__backdrop" data-material-lightbox-close aria-label="Tutup pratinjau bahan"></button>
        <div class="fv-material-lightbox__panel">
            <button type="button" class="fv-material-lightbox__close" data-material-lightbox-close aria-label="Tutup">
                <span aria-hidden="true">×</span>
            </button>
            <p id="material-lightbox-title" class="fv-material-lightbox__title" data-material-lightbox-caption></p>
            <img
                data-material-lightbox-image
                alt=""
                class="fv-material-lightbox__image"
            >
        </div>
    </div>

    @if ($related->isNotEmpty())
        <section class="bg-white py-12">
            <div class="mx-auto max-w-[1200px] px-5 lg:px-8">
                <span class="section-badge mb-2">Dari kategori yang sama</span>
                <h2 class="mb-6 text-xl font-bold text-[#1C2430]">Produk serupa</h2>
                <div class="catalog-grid catalog-grid--4">
                    @foreach ($related as $produk)
                        <x-collection-product-card :produk="$produk" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('vite')
    <script>
        (function () {
            const lightbox = document.getElementById('material-lightbox');

            if (!lightbox) {
                return;
            }

            const image = lightbox.querySelector('[data-material-lightbox-image]');
            const caption = lightbox.querySelector('[data-material-lightbox-caption]');
            const closeTargets = lightbox.querySelectorAll('[data-material-lightbox-close]');
            const closeButton = lightbox.querySelector('.fv-material-lightbox__close');
            let lastTrigger = null;

            const closeLightbox = () => {
                if (lightbox.hidden) {
                    return;
                }

                lightbox.hidden = true;
                document.body.classList.remove('overflow-hidden');

                if (image) {
                    image.removeAttribute('src');
                    image.alt = '';
                }

                if (caption) {
                    caption.textContent = '';
                }

                if (lastTrigger) {
                    lastTrigger.focus();
                }
            };

            const openLightbox = (trigger) => {
                const src = trigger.getAttribute('data-material-src');
                const name = trigger.getAttribute('data-material-name') || 'Bahan';

                if (!src || !image) {
                    return;
                }

                lastTrigger = trigger;
                image.src = src;
                image.alt = name;

                if (caption) {
                    caption.textContent = name;
                }

                lightbox.hidden = false;
                document.body.classList.add('overflow-hidden');

                if (closeButton) {
                    closeButton.focus();
                }
            };

            document.querySelectorAll('.fv-material-thumb[data-material-src]').forEach((button) => {
                button.addEventListener('click', () => openLightbox(button));
            });

            closeTargets.forEach((target) => {
                target.addEventListener('click', closeLightbox);
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeLightbox();
                }
            });
        })();
    </script>
@endpush
