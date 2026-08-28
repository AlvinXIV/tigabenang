@props([
    'bahan',
    'lazy' => true,
])

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::materialImageUrl($bahan->nama_bahan);
@endphp

<article {{ $attributes->class(['product-tile group']) }}>
    <div class="image-frame rounded-2xl overflow-hidden border border-border" style="border-color:#DCD6D0;background-color:#F6F4F1;">
        @if ($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $bahan->nama_bahan }}"
                width="480"
                height="640"
                class="transition-transform duration-500 group-hover:scale-105"
                @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
            >
        @else
            <div class="flex h-full w-full flex-col items-center justify-center gap-3 px-3 text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-full" style="background:#EAEFF4;">
                    <svg class="h-6 w-6" style="color:#6E7575;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em]" style="color:#6E7575;">Material preview</p>
            </div>
        @endif
    </div>
    <div class="product-tile-meta">
        <span class="inline-block rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em]" style="background:#EAEFF4;color:#172A39;">Material</span>
        <h3 class="mt-2 text-base font-bold leading-snug" style="color:#172A39;">{{ $bahan->nama_bahan }}</h3>
    </div>
</article>
