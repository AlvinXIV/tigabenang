@props([
    'bahan',
    'lazy' => true,
])

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::materialImageUrl($bahan->nama_bahan);
@endphp

<article class="group border border-line bg-paper">
    <div class="relative aspect-[4/3] overflow-hidden bg-ivory-deep">
            @if ($imageUrl)
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $bahan->nama_bahan }}"
                    width="800"
                    height="600"
                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
                    @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
                >
        @else
            <div class="flex h-full items-end p-6">
                <span class="font-serif text-5xl leading-none text-charcoal/15">{{ mb_substr($bahan->nama_bahan, 0, 1) }}</span>
            </div>
        @endif
    </div>
    <div class="px-5 py-5">
        <p class="text-[10px] uppercase tracking-[0.24em] text-muted">Material</p>
        <h3 class="mt-2 font-serif text-2xl text-charcoal">{{ $bahan->nama_bahan }}</h3>
    </div>
</article>
