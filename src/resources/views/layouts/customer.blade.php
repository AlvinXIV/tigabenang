<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FitVendor')</title>
    <meta name="description" content="@yield('description', 'Pesan pakaian custom untuk tim, komunitas, acara, atau brand Anda.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="{{ asset('images/clothiq-logo.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @php
        $viteHotFile = public_path('hot');
        $viteOrigin = is_file($viteHotFile) ? trim((string) file_get_contents($viteHotFile)) : null;
    @endphp
    @if ($viteOrigin)
        <link rel="preconnect" href="{{ $viteOrigin }}" crossorigin>
    @endif
    {{-- Page scripts first so Tailwind CSS transform cannot queue Virtual Fitting / Three.js. --}}
    @stack('vite-early')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Critical catalog grid: ships with HTML so product tiles never wait on Vite/Tailwind. --}}
    <style>
        html, body { max-width: 100%; overflow-x: clip; }
        body { font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif; background: #F7F7F5; color: #1C2430; }
        #main-content, .main-navbar, footer { width: 100%; max-width: 100%; min-width: 0; }
        fieldset { min-width: 0; max-width: 100%; }
        .catalog-shell { width: 100%; max-width: 1200px; margin-inline: auto; }
        .catalog-grid { display: grid; width: 100%; grid-template-columns: minmax(0, 1fr); column-gap: 1.25rem; row-gap: 1.75rem; }
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
        .image-frame { position: relative; display: block; width: 100%; max-width: 100%; aspect-ratio: 3 / 4; overflow: hidden; background-color: #EEEFEC; border-radius: 12px; border: 1px solid #E2E5E9; }
        .image-frame > img { position: absolute; inset: 0; display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; object-position: center; }
        .vf-stage { position: relative; width: 100%; min-height: 680px; height: 680px; }
        @media (min-width: 1024px) {
            .vf-stage { min-height: 700px; height: 700px; }
        }
        #fitting-viewport { position: absolute; inset: 0; width: 100%; height: 100%; min-height: 680px; }
        #fitting-viewport canvas { display: block; width: 100% !important; height: 100% !important; }
    </style>
</head>
<body class="min-h-screen bg-surface-alt text-text-base antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-primary focus:px-4 focus:py-2 focus:text-white">
        Langsung ke isi
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
