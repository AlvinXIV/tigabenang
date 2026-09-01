@props([
    'bahan',
    'lazy' => true,
])

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::materialImageUrl($bahan->nama_bahan);
@endphp

<article {{ $attributes->class(['product-tile group']) }}>
    <div class="image-frame">
        @if ($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $bahan->nama_bahan }}"
                width="480"
                height="640"
                class="transition-transform duration-500 group-hover:scale-[1.03]"
                @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
            >
        @else
            <div class="flex h-full w-full flex-col items-center justify-center gap-2 px-3 text-center">
                <p class="text-xs font-semibold text-[#667085]">Pratinjau bahan</p>
            </div>
        @endif
    </div>
    <div class="product-tile-meta">
        <span class="text-xs font-medium text-[#667085]">Bahan</span>
        <h3 class="mt-1 text-[0.95rem] font-semibold leading-snug text-[#1C2430]">{{ $bahan->nama_bahan }}</h3>
    </div>
</article>
