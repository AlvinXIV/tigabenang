@props([
    'produk',
    'featured' => false,
    'variant' => 'default',
    'showPrice' => true,
    'showDescription' => false,
    'lazy' => true,
])

<x-collection-product-card :produk="$produk" :lazy="$lazy" />
