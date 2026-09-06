@props([
    'produk',
    'lazy' => true,
])

@php
    use App\Support\CustomerCatalog;
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::productImageUrl($produk);
    $webpUrl = CustomerMedia::productWebpUrl($produk);
    $category = CustomerCatalog::categoryLabel($produk->kategori?->nama_kategori);
    $detailUrl = route('collection.show', $produk->id_produk);
@endphp

<article {{ $attributes->class(['product-tile group']) }}>
    <a href="{{ $detailUrl }}" class="image-frame">
        @if ($imageUrl)
            <picture class="absolute inset-0 block h-full w-full">
                @if ($webpUrl)
                    <source srcset="{{ $webpUrl }}" type="image/webp">
                @endif
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $produk->nama_produk }}"
                    width="480"
                    height="640"
                    class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-[1.03]"
                    @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
                >
            </picture>
        @else
            <div class="flex h-full w-full flex-col items-center justify-center gap-2 px-3 text-center">
                <p class="text-xs font-semibold text-[#667085]">Pratinjau produk</p>
            </div>
        @endif
    </a>

    <div class="product-tile-meta flex flex-1 flex-col">
        @if ($category)
            <span class="text-xs font-medium text-[#667085]">{{ $category }}</span>
        @endif
        <h3 class="mt-1 line-clamp-2 min-h-[2.5rem] text-[0.95rem] font-semibold leading-snug text-[#1C2430]">
            <a href="{{ $detailUrl }}" class="no-underline hover:text-[#102A43]">{{ $produk->nama_produk }}</a>
        </h3>
        <p class="mt-1 text-sm font-semibold text-[#1C2430]">Mulai <x-price :amount="$produk->harga" /></p>
        @if (filled($produk->deskripsi ?? null))
            <p class="mt-1 line-clamp-2 text-sm leading-relaxed text-[#667085]">{{ $produk->deskripsi }}</p>
        @endif
        <a href="{{ $detailUrl }}" class="mt-auto inline-flex items-center gap-1.5 pt-3 text-sm font-semibold text-[#102A43] no-underline transition-all duration-200 hover:text-[#B8664A] group-hover:text-[#B8664A]">
            <span class="group-hover:underline underline-offset-4">Lihat detail</span>
            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
            </svg>
        </a>
    </div>
</article>
