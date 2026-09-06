<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk Admin') | FitVendor</title>
    
    <!-- Favicon matching Customer Portal -->
    <link rel="icon" type="image/png" href="{{ asset('images/clothiq-logo.png') }}?v=3">

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
        *, *::before, *::after {
            box-sizing: border-box;
        }
        body {
            font-family: var(--font-sans);
            background-color: #F7F7F5;
            color: #102A43;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .auth-container {
            width: 100%;
            max-width: 420px;
            padding-left: 16px;
            padding-right: 16px;
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            background-color: #FFFFFF;
            border: 1px solid #E2E5E9;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(16, 42, 67, 0.05);
            padding: 28px;
        }
        .auth-btn-primary {
            width: 100%;
            height: 44px;
            background-color: #102A43 !important;
            color: #FFFFFF !important;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            font-family: var(--font-sans);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.15s ease, transform 0.05s ease;
            text-decoration: none;
        }
        .auth-btn-primary:hover {
            background-color: #193B5C !important;
        }
        .auth-btn-primary:active {
            background-color: #0A1C2E !important;
            transform: scale(0.99);
        }
        .auth-btn-primary:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed;
        }
        .auth-input {
            width: 100%;
            height: 44px;
            background-color: #FFFFFF;
            border: 1px solid #D0D5DD;
            border-radius: 8px;
            font-size: 14px;
            font-family: var(--font-sans);
            color: #102A43;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            outline: none;
        }
        .auth-input:focus {
            border-color: #102A43;
            box-shadow: 0 0 0 2px rgba(16, 42, 67, 0.2);
        }
        .auth-input::placeholder {
            color: #667085;
            font-size: 13px;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#102A43]/20 selection:text-[#102A43]">

    <main class="auth-container py-8 sm:py-10">
        @yield('content')
    </main>

    <!-- Persistent Minimal Footer (Proporsional, tidak terlalu jauh) -->
    <footer class="w-full text-center pb-8 pt-2">
        <p class="text-[12px] sm:text-[13px] text-[#667085] m-0">
            &copy; {{ date('Y') }} FitVendor. Konveksi &amp; Atelier Digital.
        </p>
    </footer>

    @stack('scripts')
</body>
</html>
