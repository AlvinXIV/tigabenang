<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FitVendor') — Custom Clothing</title>
    <meta name="description" content="@yield('description', 'Custom clothing crafted with thoughtful materials, precise sizing, and modern fitting technology.')">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    @php
        $viteHotFile = public_path('hot');
        $viteOrigin = is_file($viteHotFile) ? trim((string) file_get_contents($viteHotFile)) : null;
    @endphp
    @if ($viteOrigin)
        <link rel="preconnect" href="{{ $viteOrigin }}" crossorigin>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ivory text-charcoal antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-charcoal focus:px-4 focus:py-2 focus:text-ivory">
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
