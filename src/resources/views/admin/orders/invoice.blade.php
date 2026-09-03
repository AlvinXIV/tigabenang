<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-CLQ-{{ $order->id_pemesanan }} - Clothiq Atelier</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])

    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        body {
            font-family: var(--font-sans);
            background-color: #FAF8F5;
            color: #172A39;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .invoice-box {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
        }
        .pill-btn {
            border-radius: 9999px !important;
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="min-h-screen py-8 px-4 antialiased">

    <!-- Top Action Bar for Admin -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}" class="pill-btn inline-flex items-center gap-2 text-xs font-bold text-[#172A39] bg-white px-5 py-2.5 border border-[#DCD6D0] hover:bg-[#FAF8F5] transition-colors uppercase tracking-wider text-decoration-none shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Detail Pesanan</span>
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="pill-btn inline-flex items-center gap-2 px-6 py-2.5 bg-[#172A39] hover:bg-[#0E1B25] text-white text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-[#172A39]/20 cursor-pointer border-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Cetak Invoice</span>
            </button>
        </div>
    </div>

    <!-- Official Invoice Document -->
    <div class="invoice-box max-w-4xl mx-auto bg-white border border-[#DCD6D0] rounded-3xl shadow-[0_10px_36px_rgba(23,42,57,0.05)] p-8 sm:p-12">
        
        <!-- Header: Company Brand & Invoice Badge -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-8 border-b border-[#DCD6D0]">
            <div>
                <div class="flex items-center gap-3.5 mb-2">
                    <div class="w-12 h-12 bg-white border border-[#DCD6D0] rounded-2xl flex items-center justify-center shadow-xs overflow-hidden">
                        <img src="{{ asset('images/clothiq-logo.png') }}?v=2" alt="Clothiq Logo" width="36" height="36" class="w-4/5 h-4/5 object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-[#172A39] leading-tight tracking-wider uppercase">Clothiq Atelier</h1>
                        <p class="text-xs text-[#6E7575] font-bold">Custom Garment &amp; Production Workshop</p>
                    </div>
                </div>
                <p class="text-xs text-[#6E7575] max-w-sm mt-3 leading-relaxed">
                    Jl. Industri Garment Presisi No. 18, Bandung, Jawa Barat<br>
                    WhatsApp: 0812-3456-7890 | Email: finance@clothiq.com
                </p>
            </div>

            <div class="text-left sm:text-right">
                <span class="inline-block px-3.5 py-1 bg-[#FAF8F5] text-[#172A39] text-[10px] font-extrabold uppercase tracking-widest mb-2 border border-[#DCD6D0] rounded-full">
                    INVOICE RESMI
                </span>
                <p class="text-base font-extrabold text-[#172A39]">INV/CLQ/{{ date('Y/m') }}/{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}</p>
                <div class="text-xs text-[#6E7575] mt-1 space-y-0.5">
                    <p>Tanggal: <strong class="text-[#172A39]">{{ $order->created_at ? $order->created_at->format('d M Y') : date('d M Y') }}</strong></p>
                    <p>Status: 
                        @if ($order->total_harga)
                            <span class="font-bold text-emerald-700 uppercase">Harga Disepakati</span>
                        @else
                            <span class="font-bold text-amber-700 uppercase">Waiting Price</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Customer Bill To Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-8 border-b border-[#DCD6D0] text-xs">
            <div>
                <span class="text-[10px] font-extrabold tracking-widest text-[#6E7575] uppercase block mb-1">DITUJUKAN KEPADA:</span>
                <h3 class="text-sm font-extrabold text-[#172A39]">{{ $order->nama }}</h3>
                <p class="text-[#555E68] font-medium mt-0.5">WhatsApp / HP: {{ $order->no_hp }}</p>
            </div>
            <div>
                <span class="text-[10px] font-extrabold tracking-widest text-[#6E7575] uppercase block mb-1">ALAMAT PENGIRIMAN:</span>
                <p class="text-[#555E68] font-medium leading-relaxed">{{ $order->alamat }}</p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-8 border-b border-[#DCD6D0]">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#DCD6D0] bg-[#FAF8F5] text-[10px] font-bold tracking-widest text-[#6E7575] uppercase">
                        <th class="p-3.5">NAMA PRODUK</th>
                        <th class="p-3.5">BAHAN &amp; UKURAN</th>
                        <th class="p-3.5 text-right">TOTAL HARGA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD6D0]">
                    <tr>
                        <td class="p-4">
                            <p class="font-extrabold text-[#172A39] text-sm">{{ $order->produk ? $order->produk->nama_produk : '-' }}</p>
                            @if ($order->notes)
                                <p class="text-[#6E7575] text-xs mt-1">Catatan: {{ $order->notes }}</p>
                            @endif
                        </td>
                        <td class="p-4 text-xs text-[#555E68]">
                            <p><strong class="text-[#172A39]">Bahan:</strong> {{ $order->bahan->pluck('nama_bahan')->implode(', ') ?: '-' }}</p>
                            <p class="mt-1"><strong class="text-[#172A39]">Ukuran:</strong> {{ $order->ukuran->map(fn($u) => $u->nama_ukuran . ' (' . $u->pivot->kuantitas . ' pcs)')->implode(', ') ?: '-' }}</p>
                        </td>
                        <td class="p-4 text-right font-extrabold text-base text-[#172A39]">
                            {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Waiting Price' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals & Payment Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-8">
            
            <div class="bg-[#FAF8F5] p-5 border border-[#DCD6D0] rounded-2xl text-xs">
                <span class="text-[10px] font-bold tracking-widest text-[#6E7575] uppercase block mb-2">REKENING PEMBAYARAN:</span>
                <div class="space-y-1 text-[#172A39]">
                    <p>Bank: <strong class="text-[#172A39]">Bank Central Asia (BCA)</strong></p>
                    <p>No. Rekening: <strong class="text-[#172A39] font-mono text-sm">8420-9988-771</strong></p>
                    <p>Atas Nama: <strong class="text-[#172A39]">Clothiq Atelier Indonesia</strong></p>
                </div>
            </div>

            <!-- Summary Calculations -->
            <div class="space-y-2 text-xs flex flex-col justify-center">
                <div class="flex justify-between py-3 border-t border-[#DCD6D0] text-sm font-extrabold text-[#172A39]">
                    <span>TOTAL HARGA:</span>
                    <span class="text-[#172A39] text-xl font-black">
                        {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Waiting Price' }}
                    </span>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t border-[#DCD6D0] flex flex-col sm:flex-row items-center justify-between text-xs text-[#6E7575] gap-4">
            <p>&copy; {{ date('Y') }} Clothiq Atelier. All rights reserved.</p>
            <div class="text-right text-[11px]">
                <p class="font-bold text-[#172A39]">Clothiq Atelier Portal</p>
                <p>Finance &amp; Workshop Administration</p>
            </div>
        </div>

    </div>

</body>
</html>
