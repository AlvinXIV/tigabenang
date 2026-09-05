<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') - Tigabenang Vendor Portal</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        :root {
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
        body {
            font-family: var(--font-sans);
            background-color: #F7F7F5;
            color: #1C2430;
        }
    </style>
</head>
<body class="min-h-full antialiased text-[#1C2430] bg-[#F7F7F5] flex flex-col justify-between py-10 sm:py-16 px-4 selection:bg-[#102A43]/20 selection:text-[#1C2430]">

    <div class="w-full flex-1 flex flex-col items-center justify-center">
        @yield('content')
    </div>

    <!-- Persistent Minimal Footer -->
    <footer class="w-full text-center mt-12 pt-4">
        <p class="text-xs text-[#667085]">
            &copy; {{ date('Y') }} Tigabenang. Vendor Management Portal.
        </p>
    </footer>

    @stack('scripts')
</body>
</html>

