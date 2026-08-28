@props([
    'produk',
    'lazy' => true,
])

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::productImageUrl($produk);
    $category = $produk->kategori?->nama_kategori;
    $detailUrl = route('collection.show', $produk->id_produk);
@endphp

<article {{ $attributes->class(['product-tile group']) }}>
    <a href="{{ $detailUrl }}" class="image-frame rounded-xl overflow-hidden">
        @if ($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $produk->nama_produk }}"
                width="480"
                height="640"
                class="transition-transform duration-500 group-hover:scale-105"
                @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
            >
        @else
            <div class="flex h-full w-full flex-col items-center justify-center gap-2 px-3 text-center">
                <p class="text-xs font-semibold uppercase tracking-widest text-text-subtle">Lookbook</p>
            </div>
        @endif
    </a>
    <div class="product-tile-meta">
        @if ($category)
            <span class="inline-block rounded-full bg-primary-muted px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-primary">{{ $category }}</span>
        @endif
        <h3 class="mt-2 line-clamp-2 text-base font-bold leading-snug text-text-base">
            <a href="{{ $detailUrl }}" class="hover:text-primary transition-colors">{{ $produk->nama_produk }}</a>
        </h3>
        <a href="{{ $detailUrl }}" class="mt-2 section-badge text-[11px] hover:opacity-70 transition-opacity">
            View Details
        </a>
    </div>
</article>
