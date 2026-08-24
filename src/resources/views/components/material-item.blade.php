@props([
    'bahan',
    'lazy' => true,
])

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::materialImageUrl($bahan->nama_bahan);
@endphp

<article {{ $attributes->class(['product-tile']) }}>
    <div class="image-frame">
        @if ($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $bahan->nama_bahan }}"
                width="480"
                height="640"
                @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
            >
        @else
            <div class="flex h-full w-full items-center justify-center px-3 text-center">
                <p class="text-[10px] uppercase tracking-[0.28em] text-charcoal/35">Material preview</p>
            </div>
        @endif
    </div>
    <div class="product-tile-meta">
        <p class="text-[10px] uppercase tracking-[0.22em] text-muted">Material</p>
        <h3 class="mt-1.5 font-serif text-base leading-snug text-charcoal md:text-lg">{{ $bahan->nama_bahan }}</h3>
    </div>
</article>
