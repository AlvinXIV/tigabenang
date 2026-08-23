@props([
    'products',
])

@php
    $items = collect($products)->filter()->values()->take(6);
@endphp

@if ($items->isNotEmpty())
    <div class="catalog-grid catalog-grid--4">
        @foreach ($items as $index => $produk)
            <x-portfolio-product-card :produk="$produk" :lazy="$index > 2" />
        @endforeach
    </div>
@endif
