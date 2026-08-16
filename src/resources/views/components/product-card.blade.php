@props([
    'produk',
    'featured' => false,
    'showPrice' => true,
    'showDescription' => false,
    'lazy' => true,
])

@php
    use App\Support\CustomerMedia;
    $imageUrl = CustomerMedia::imageUrl($produk->gambar);
    $category = $produk->kategori?->nama_kategori;
@endphp

<article class="group {{ $featured ? '' : 'flex h-full flex-col' }}">
    <a href="{{ route('collection.show', $produk->id_produk) }}" class="block">
        <div class="relative overflow-hidden bg-ivory-deep {{ $featured ? 'aspect-[4/5] md:aspect-[5/6]' : 'aspect-[3/4]' }}">
            @if ($imageUrl)
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $produk->nama_produk }}"
                    width="800"
                    height="{{ $featured ? 960 : 1067 }}"
                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
                    @if ($lazy) loading="lazy" decoding="async" @else fetchpriority="high" decoding="async" @endif
                >
            @else
                <div class="flex h-full w-full flex-col justify-between p-6">
                    <p class="text-[10px] uppercase tracking-[0.28em] text-muted">{{ $category ?? 'Garment' }}</p>
                    <p class="font-serif text-3xl leading-tight text-charcoal/80 md:text-4xl">{{ $produk->nama_produk }}</p>
                    <p class="text-[10px] uppercase tracking-[0.22em] text-muted">Lookbook</p>
                </div>
            @endif
        </div>
    </a>

    <div class="mt-4 flex flex-1 flex-col">
        @if ($category)
            <p class="text-[10px] uppercase tracking-[0.24em] text-muted">{{ $category }}</p>
        @endif
        <h3 class="mt-2 font-serif text-2xl leading-snug text-charcoal">
            <a href="{{ route('collection.show', $produk->id_produk) }}" class="hover:text-terracotta">
                {{ $produk->nama_produk }}
            </a>
        </h3>
        @if ($showPrice)
            <p class="mt-2 text-sm text-ink"><x-price :amount="$produk->harga" /></p>
        @endif
        @if ($showDescription && filled($produk->deskripsi ?? null))
            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted">{{ $produk->deskripsi }}</p>
        @endif
        <a href="{{ route('collection.show', $produk->id_produk) }}" class="mt-4 inline-block text-[11px] uppercase tracking-[0.2em] text-terracotta hover:text-terracotta-dark">
            View Details
        </a>
    </div>
</article>
