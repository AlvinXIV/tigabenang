<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sign In') - Clothiq Atelier Management Portal</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        body {
            font-family: var(--font-sans);
            background-color: #FAF8F5;
            color: #172A39;
        }
        .pill-btn {
            border-radius: 9999px !important;
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="min-h-full antialiased font-sans text-[#172A39] bg-[#FAF8F5] flex flex-col justify-between py-10 sm:py-16 px-4 selection:bg-[#172A39] selection:text-white">

    <div class="w-full flex-1 flex flex-col items-center justify-center">
        @yield('content')
    </div>

    <!-- Persistent Minimal Footer -->
    <footer class="w-full text-center mt-12 pt-4">
        <p class="text-[11px] tracking-widest text-[#6E7575] uppercase font-bold">
            &copy; {{ date('Y') }} Clothiq Atelier. Secure Vendor Portal.
        </p>
    </footer>

    @stack('scripts')
</body>
</html>
