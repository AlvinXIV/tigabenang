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
    <a href="{{ $detailUrl }}" class="image-frame rounded-2xl overflow-hidden border border-border" style="border-color:#DCD6D0;background-color:#F6F4F1;">
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
                <p class="text-xs font-bold uppercase tracking-widest" style="color:#6E7575;">Lookbook</p>
            </div>
        @endif
    </a>
    <div class="product-tile-meta">
        @if ($category)
            <span class="inline-block rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em]" style="background:#EAEFF4;color:#172A39;">{{ $category }}</span>
        @endif
        <h3 class="mt-2 line-clamp-2 text-base font-bold leading-snug" style="color:#172A39;">
            <a href="{{ $detailUrl }}" class="transition-colors hover:text-[#FC563C]">{{ $produk->nama_produk }}</a>
        </h3>
        <a href="{{ $detailUrl }}" class="mt-2 section-badge text-[11px] hover:opacity-75 transition-opacity" style="color:#172A39;">
            View Details
        </a>
    </div>
</article>
