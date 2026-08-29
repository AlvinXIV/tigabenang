<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Clothiq') — Custom Clothing</title>
    <meta name="description" content="@yield('description', 'Custom clothing crafted with thoughtful materials, precise sizing, and modern fitting technology.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/png" href="{{ asset('images/clothiq-logo.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @php
        $viteHotFile = public_path('hot');
        $viteOrigin = is_file($viteHotFile) ? trim((string) file_get_contents($viteHotFile)) : null;
    @endphp
    @if ($viteOrigin)
        <link rel="preconnect" href="{{ $viteOrigin }}" crossorigin>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Critical catalog grid: ships with HTML so product tiles never wait on Vite/Tailwind. --}}
    <style>
        .catalog-shell { width: 100%; max-width: 1320px; margin-inline: auto; }
        .catalog-grid { display: grid; width: 100%; grid-template-columns: minmax(0, 1fr); column-gap: 1.75rem; row-gap: 2.25rem; }
        .catalog-grid > * { min-width: 0; width: 100%; max-width: 100%; }
        @media (min-width: 768px) {
            .catalog-grid--4, .catalog-grid--3 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (min-width: 1024px) {
            .catalog-grid--4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .catalog-grid--3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        .product-tile { display: flex; flex-direction: column; width: 100%; min-width: 0; }
        .product-tile-meta { margin-top: 0.875rem; }
        .image-frame { position: relative; display: block; width: 100%; max-width: 100%; aspect-ratio: 3 / 4; overflow: hidden; background-color: #F6F4F1; }
        .image-frame > img { position: absolute; inset: 0; display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; object-position: center; }
    </style>
</head>
<body class="min-h-screen bg-white text-text-base antialiased" style="font-family: 'Inter', system-ui, sans-serif; color: #172A39; background-color: #FFFFFF;">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-primary focus:px-4 focus:py-2 focus:text-white focus:rounded">
        Skip to content
    </a>

    <x-navbar />

    <main id="main-content">
        @yield('content')
    </main>

    <x-whatsapp-button />
    <x-footer />
    @stack('vite')
</body>
</html>
