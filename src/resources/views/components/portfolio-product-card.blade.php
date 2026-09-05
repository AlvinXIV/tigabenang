@props([
    'produk',
    'lazy' => true,
])

@php
    use App\Support\CustomerCatalog;
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::productImageUrl($produk);
    $category = CustomerCatalog::categoryLabel($produk->kategori?->nama_kategori);
    $detailUrl = route('collection.show', $produk->id_produk);
@endphp

<article {{ $attributes->class(['product-tile group']) }}>
    <a href="{{ $detailUrl }}" class="image-frame">
        @if ($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $produk->nama_produk }}"
                width="480"
                height="640"
                class="transition-transform duration-500 group-hover:scale-[1.03]"
                @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
            >
        @else
            <div class="flex h-full w-full flex-col items-center justify-center gap-2 px-3 text-center">
                <p class="text-xs font-semibold text-[#667085]">Katalog</p>
            </div>
        @endif
    </a>
    <div class="product-tile-meta">
        @if ($category)
            <span class="text-xs font-medium text-[#667085]">{{ $category }}</span>
        @endif
        <h3 class="mt-1 line-clamp-2 text-[0.95rem] font-semibold leading-snug text-[#1C2430]">
            <a href="{{ $detailUrl }}" class="no-underline hover:text-[#B8664A]">{{ $produk->nama_produk }}</a>
        </h3>
        <a href="{{ $detailUrl }}" class="mt-2 text-sm font-semibold text-[#1C2430] no-underline hover:text-[#B8664A]">
            Lihat detail
        </a>
    </div>
</article>
