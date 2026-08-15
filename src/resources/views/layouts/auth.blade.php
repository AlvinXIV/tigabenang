<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tigabenang') - Vendor Management Portal</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full antialiased font-sans text-stone-800 bg-[#FAF7F2] flex flex-col justify-between py-10 sm:py-16 px-4 selection:bg-[#B85331] selection:text-white">

    <div class="w-full flex-1 flex flex-col items-center justify-center">
        @yield('content')
    </div>

    <!-- Persistent Minimal Footer -->
    <footer class="w-full text-center mt-12 pt-4">
        <p class="text-[10px] tracking-[0.2em] text-[#9E9084] uppercase font-mono">
            &copy; {{ date('Y') }} TIGABENANG. SECURE VENDOR PORTAL.
        </p>
    </footer>

    @stack('scripts')
</body>
</html>
