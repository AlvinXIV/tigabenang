<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Pesanan #INV-TB-{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }} - Tigabenang</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #F7F7F5;
            color: #1C2430;
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
    </style>
</head>
<body class="min-h-screen py-8 px-4 antialiased">

    <!-- Top Action Bar for Admin -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#1C2430] bg-white px-4 py-2 border border-[#E2E5E9] hover:bg-[#F7F7F5] rounded-lg transition-colors text-decoration-none shadow-2xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Detail Pesanan</span>
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2 bg-[#B8664A] hover:bg-[#9A4E3A] text-white text-xs font-medium rounded-lg transition-colors shadow-2xs cursor-pointer border-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Cetak Faktur</span>
            </button>
        </div>
    </div>

    <!-- Official Invoice Document -->
    <div class="invoice-box max-w-4xl mx-auto bg-white border border-[#E2E5E9] rounded-xl shadow-xs p-8 sm:p-12">
        
        <!-- Header: Company Brand & Invoice Badge -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-8 border-b border-[#E2E5E9]">
            <div>
                <div class="flex items-center gap-3.5 mb-2">
                    <div class="w-12 h-12 bg-[#B8664A] text-white rounded-xl flex items-center justify-center font-bold text-base shadow-xs">
                        TB
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-[#1C2430] leading-tight">Tigabenang</h1>
                        <p class="text-xs text-[#667085] font-medium">Konveksi &amp; Atelier Digital</p>
                    </div>
                </div>
                <p class="text-xs text-[#667085] max-w-sm mt-3 leading-relaxed">
                    Pusat Konveksi &amp; Produksi Busana Berkualitas<br>
                    WhatsApp Layanan: 0812-3456-7890 | Website: tigabenang.com
                </p>
            </div>

            <div class="text-left sm:text-right">
                <span class="inline-block px-3 py-1 bg-[#F7F7F5] text-[#1C2430] text-[10px] font-bold uppercase tracking-wider mb-2 border border-[#E2E5E9] rounded-full">
                    FAKTUR PESANAN RESMI
                </span>
                <p class="text-sm sm:text-base font-mono font-bold text-[#1C2430]">
                    INV/TB/{{ date('Y/m') }}/{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                </p>
                <div class="text-xs text-[#667085] mt-1.5 space-y-0.5">
                    <p>Tanggal: <strong class="text-[#1C2430] font-medium">{{ $order->created_at ? $order->created_at->format('d M Y') : date('d M Y') }}</strong></p>
                    <p>Status Harga: 
                        @if ($order->total_harga)
                            <span class="font-semibold text-emerald-700">Harga Disepakati</span>
                        @else
                            <span class="font-semibold text-amber-700">Menunggu Penetapan Harga</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Customer Bill To Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-6 border-b border-[#E2E5E9] text-xs">
            <div>
                <span class="text-[10px] font-bold tracking-wider text-[#667085] uppercase block mb-1">DITUJUKAN KEPADA:</span>
                <h3 class="text-sm font-semibold text-[#1C2430]">{{ $order->nama }}</h3>
                <p class="text-[#667085] font-medium mt-0.5">WhatsApp / HP: {{ $order->no_hp ?? '-' }}</p>
            </div>
            <div>
                <span class="text-[10px] font-bold tracking-wider text-[#667085] uppercase block mb-1">ALAMAT PENGIRIMAN:</span>
                <p class="text-[#667085] font-medium leading-relaxed">{{ $order->alamat ?? '-' }}</p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-6 border-b border-[#E2E5E9]">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="border-b border-[#E2E5E9] bg-[#F7F7F5] text-[10px] font-bold tracking-wider text-[#1C2430] uppercase">
                        <th class="p-3">Nama Produk</th>
                        <th class="p-3">Spesifikasi Bahan &amp; Ukuran</th>
                        <th class="p-3 text-right">Estimasi Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9]">
                    <tr>
                        <td class="p-4 align-top">
                            <p class="font-semibold text-[#1C2430] text-sm">{{ $order->produk ? $order->produk->nama_produk : '-' }}</p>
                            @if ($order->notes)
                                <p class="text-[#667085] text-xs mt-1 italic">Catatan: {{ $order->notes }}</p>
                            @endif
                        </td>
                        <td class="p-4 text-xs text-[#667085] align-top">
                            <p><strong class="text-[#1C2430]">Bahan:</strong> {{ $order->bahan->pluck('nama_bahan')->implode(', ') ?: '-' }}</p>
                            <p class="mt-1"><strong class="text-[#1C2430]">Ukuran:</strong> {{ $order->ukuran->map(fn($u) => $u->nama_ukuran . ' (' . $u->pivot->kuantitas . ' pcs)')->implode(', ') ?: '-' }}</p>
                        </td>
                        <td class="p-4 text-right font-bold text-base text-[#1C2430] align-top">
                            {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Menunggu Penetapan Harga' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals & Payment Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6">
            
            <div class="bg-[#F7F7F5] p-4 border border-[#E2E5E9] rounded-lg text-xs">
                <span class="text-[10px] font-bold tracking-wider text-[#667085] uppercase block mb-1.5">REKENING PEMBAYARAN KESEPAKATAN:</span>
                <div class="space-y-1 text-[#1C2430]">
                    <p>Bank: <strong class="text-[#1C2430]">Bank Central Asia (BCA)</strong></p>
                    <p>No. Rekening: <strong class="text-[#1C2430] font-mono text-xs sm:text-sm">8420-9988-771</strong></p>
                    <p>Atas Nama: <strong class="text-[#1C2430]">Tigabenang Konveksi Digital</strong></p>
                </div>
            </div>

            <!-- Summary Calculations -->
            <div class="space-y-2 text-xs flex flex-col justify-center">
                <div class="flex justify-between items-center py-2.5 border-t border-[#E2E5E9] text-sm font-semibold text-[#1C2430]">
                    <span>Total Estimasi Disepakati:</span>
                    <span class="text-[#1C2430] text-lg sm:text-xl font-bold">
                        {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Belum Ditetapkan' }}
                    </span>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-[#E2E5E9] flex flex-col sm:flex-row items-center justify-between text-xs text-[#667085] gap-4">
            <p>&copy; {{ date('Y') }} Tigabenang. Hak cipta dilindungi undang-undang.</p>
            <div class="text-right text-[11px]">
                <p class="font-semibold text-[#1C2430]">Tigabenang Vendor Portal</p>
                <p>Konveksi &amp; Atelier Digital</p>
            </div>
        </div>

    </div>

</body>
</html>

