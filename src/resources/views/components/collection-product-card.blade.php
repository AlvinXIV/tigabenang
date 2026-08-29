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
    <a href="{{ $detailUrl }}" class="image-frame overflow-hidden rounded-2xl border border-border" style="border-color:#DCD6D0;background-color:#FAF8F5;">
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
            <div class="flex h-full w-full flex-col items-center justify-center gap-3 px-3 text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-full" style="background:#EAEFF4;">
                    <svg class="h-6 w-6" style="color:#6E7575;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em]" style="color:#6E7575;">Product preview</p>
            </div>
        @endif
    </a>

    <div class="product-tile-meta flex flex-1 flex-col">
        @if ($category)
            <span class="inline-block self-start rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em]" style="background:#EAEFF4;color:#172A39;">{{ $category }}</span>
        @endif
        <h3 class="mt-2 line-clamp-2 min-h-[2.25rem] text-base font-bold leading-snug" style="color:#172A39;">
            <a href="{{ $detailUrl }}" class="transition-opacity hover:opacity-75">{{ $produk->nama_produk }}</a>
        </h3>
        <p class="mt-1 text-sm font-extrabold" style="color:#172A39;"><x-price :amount="$produk->harga" /></p>
        <p class="mt-1 line-clamp-2 min-h-[2.25rem] text-xs leading-relaxed" style="color:#6E7575;">
            @if (filled($produk->deskripsi ?? null))
                {{ $produk->deskripsi }}
            @else
                Made to order{{ $category ? ' · '.$category : '' }}.
            @endif
        </p>
        <a href="{{ $detailUrl }}" class="mt-auto pt-3 section-badge text-[11px] hover:opacity-75 transition-opacity" style="color:#172A39;">
            View Details
        </a>
    </div>
</article>
