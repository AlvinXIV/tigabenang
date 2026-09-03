<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Form Konfirmasi Pemesanan') - Clothiq Atelier</title>
    <meta name="description" content="@yield('description', 'Formulir resmi konfirmasi pemesanan pakaian custom Clothiq Atelier.')">
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('vite')

    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            --color-primary: #172A39;
            --color-cream: #FAF8F5;
            --color-cream-border: #DCD6D0;
        }

        body {
            font-family: var(--font-sans);
            background-color: #FAF8F5;
            color: #172A39;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .deal-btn-pill {
            border-radius: 9999px !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .deal-btn-pill:hover {
            transform: translateY(-2px);
        }

        .deal-btn-pill:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-[#172A39] selection:text-white">

    {{-- ── Dedicated Minimalist Brand Topbar ────────────────────── --}}
    <header style="background:linear-gradient(135deg, #FAF8F5 0%, #F2ECE5 30%, #EAE2D8 100%);border-bottom:1.5px solid #D5CDC4;position:sticky;top:0;z-index:50;box-shadow:0 4px 20px rgba(23,42,57,0.04);backdrop-filter:blur(16px);">
        <div class="mx-auto max-w-5xl px-5 py-4 lg:px-8 flex items-center justify-between">
            
            {{-- Brand Wordmark & Monogram --}}
            <div class="flex items-center gap-3.5">
                <span style="width:46px;height:46px;background:#FFFFFF;border:1.5px solid #D5CDC4;border-radius:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(23,42,57,0.08);overflow:hidden;flex-shrink:0;">
                    <img src="{{ asset('images/clothiq-logo.png') }}?v=2" alt="Clothiq Logo" width="36" height="36" style="width:84%;height:84%;object-fit:contain;">
                </span>
                <div>
                    <span style="font-size:1.35rem;font-weight:900;letter-spacing:0.12em;text-transform:uppercase;color:#172A39;display:block;line-height:1;">
                        Clothiq
                    </span>
                    <span style="font-size:0.6875rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#6E7575;">
                        Official Deal Order Portal
                    </span>
                </div>
            </div>

            {{-- Verified Badge --}}
            <div class="hidden sm:flex items-center gap-2 px-3.5 py-1.5 rounded-full" style="background:#FFFFFF;border:1px solid #DCD6D0;box-shadow:0 2px 8px rgba(23,42,57,0.04);">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span style="font-size:0.75rem;font-weight:800;color:#172A39;letter-spacing:0.02em;">Verified Production Queue</span>
            </div>
        </div>
    </header>

    {{-- ── Main Content Area ────────────────────────────────────── --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- ── Standalone Footer ─────────────────────────────────────── --}}
    <footer style="background:#172A39;color:#FFFFFF;border-top:1px solid rgba(234,226,216,0.1);padding:2.5rem 0 2rem;">
        <div class="mx-auto max-w-5xl px-5 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div>
                <p style="font-size:0.875rem;font-weight:800;letter-spacing:0.04em;color:#FFFFFF;margin:0;">
                    Clothiq Custom Atelier &amp; Production
                </p>
                <p style="font-size:0.75rem;color:rgba(234,226,216,0.65);margin-top:0.25rem;">
                    Formulir resmi kesepakatan produksi pakaian custom dengan garansi presisi &amp; mutu.
                </p>
            </div>
            <p style="font-size:0.75rem;color:rgba(234,226,216,0.5);margin:0;">
                &copy; {{ date('Y') }} Clothiq. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
