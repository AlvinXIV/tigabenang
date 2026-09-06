<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') - Tigabenang</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
        }
        body {
            font-family: var(--font-sans);
            background-color: #F7F7F5;
            color: #102A43;
        }
    </style>
</head>
<body class="min-h-full antialiased text-[#102A43] bg-[#F7F7F5] flex flex-col justify-between py-10 sm:py-16 px-4 selection:bg-[#102A43]/20 selection:text-[#102A43]">

    <div class="w-full flex-1 flex flex-col items-center justify-center">
        @yield('content')
    </div>

    <!-- Persistent Minimal Footer -->
    <footer class="w-full text-center mt-12 pt-4">
        <p class="text-xs text-[#667085]">
            &copy; {{ date('Y') }} Tigabenang. Konveksi &amp; Atelier Digital.
        </p>
    </footer>

    @stack('scripts')
</body>
</html>

