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

<article {{ $attributes->class(['product-tile']) }}>
    <a href="{{ $detailUrl }}" class="image-frame">
        @if ($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $produk->nama_produk }}"
                width="480"
                height="640"
                @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
            >
        @else
            <div class="flex h-full w-full items-center justify-center px-3 text-center">
                <p class="text-[10px] uppercase tracking-[0.28em] text-charcoal/35">Product preview</p>
            </div>
        @endif
    </a>

    <div class="product-tile-meta flex flex-1 flex-col">
        <p class="text-[10px] uppercase tracking-[0.22em] text-muted">{{ $category ?? 'Garment' }}</p>
        <h3 class="mt-1 line-clamp-2 min-h-[2.25rem] font-serif text-base leading-snug text-charcoal">
            <a href="{{ $detailUrl }}" class="hover:text-terracotta">{{ $produk->nama_produk }}</a>
        </h3>
        <p class="mt-1 text-sm text-ink"><x-price :amount="$produk->harga" /></p>
        <p class="mt-1 line-clamp-2 min-h-[2.25rem] text-sm leading-relaxed text-muted">
            @if (filled($produk->deskripsi ?? null))
                {{ $produk->deskripsi }}
            @else
                Made to order{{ $category ? ' · '.$category : '' }}.
            @endif
        </p>
        <a href="{{ $detailUrl }}" class="mt-auto pt-3 text-[11px] uppercase tracking-[0.2em] text-terracotta hover:text-terracotta-dark">
            View Details
        </a>
    </div>
</article>
