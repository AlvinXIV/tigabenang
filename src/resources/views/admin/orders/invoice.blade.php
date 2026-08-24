<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-TB-{{ $order->id_pemesanan }} - Tigabenang</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])

    <style>
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
<body class="bg-[#FAF7F2] min-h-screen py-8 px-4 font-sans text-[#292524] antialiased">

    <!-- Top Action Bar for Admin -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}" class="inline-flex items-center gap-2 text-xs font-mono font-medium text-[#78716C] hover:text-[#B85331] bg-white px-4 py-2 border border-[#D9CCC1] transition-colors uppercase tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Order Detail</span>
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium uppercase tracking-wider transition-all shadow-xs cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Print Invoice</span>
            </button>
        </div>
    </div>

    <!-- Official Invoice Document -->
    <div class="invoice-box max-w-4xl mx-auto bg-white border border-[#EADACE] shadow-[0_4px_24px_rgba(0,0,0,0.015)] p-8 sm:p-12">
        
        <!-- Header: Company Brand & Invoice Badge -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-8 border-b border-[#EADACE]/70">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-[#EFE7DE] border border-[#E0D0C2] flex items-center justify-center text-[#B85331] font-bold text-lg">
                        T
                    </div>
                    <div>
                        <h1 class="text-xl font-medium text-[#1C1917] leading-tight">TIGABENANG APPAREL</h1>
                        <p class="text-xs text-[#78716C]">Vendor Management & Custom Production</p>
                    </div>
                </div>
                <p class="text-xs text-[#78716C] max-w-sm mt-2 leading-relaxed font-mono">
                    Jl. Industri Kreatif No. 88, Bandung, Jawa Barat 40235<br>
                    WhatsApp: 0812-3456-7890 | Email: finance@tigabenang.com
                </p>
            </div>

            <div class="text-left sm:text-right font-mono">
                <span class="inline-block px-2.5 py-0.5 bg-[#FAF7F2] text-[#B85331] text-[10px] font-bold uppercase tracking-widest mb-2 border border-[#EADACE]">
                    INVOICE FAKTUR
                </span>
                <p class="text-base font-bold text-[#1C1917]">INV/TB/{{ date('Y/m') }}/{{ $order->id_pemesanan }}</p>
                <div class="text-xs text-[#78716C] mt-1 space-y-0.5">
                    <p>Tanggal: <strong class="text-[#292524]">{{ $order->created_at ? $order->created_at->format('d M Y') : date('d M Y') }}</strong></p>
                    <p>Status: 
                        @if ($order->total_harga)
                            <span class="font-bold text-emerald-800 uppercase">Harga Disepakati</span>
                        @else
                            <span class="font-bold text-amber-700 uppercase">Belum Ditentukan (Waiting Price)</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Customer Bill To Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-8 border-b border-[#EADACE]/70 text-xs">
            <div>
                <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-1">PELANGGAN:</span>
                <h3 class="text-sm font-medium text-[#1C1917]">{{ $order->nama }}</h3>
                <p class="text-[#78716C] font-mono mt-0.5">No HP: {{ $order->no_hp }}</p>
            </div>
            <div>
                <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-1">ALAMAT PENGIRIMAN:</span>
                <p class="text-[#78716C] leading-relaxed">{{ $order->alamat }}</p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-8 border-b border-[#EADACE]/70">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        <th class="py-3">NAMA PRODUK</th>
                        <th class="py-3">BAHAN & UKURAN</th>
                        <th class="py-3 text-right">TOTAL HARGA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/50">
                    <tr>
                        <td class="py-4">
                            <p class="font-medium text-[#1C1917]">{{ $order->produk ? $order->produk->nama_produk : '-' }}</p>
                            @if ($order->notes)
                                <p class="text-[#78716C] text-[11px] mt-0.5">Catatan: {{ $order->notes }}</p>
                            @endif
                        </td>
                        <td class="py-4 text-xs text-[#574E46]">
                            <p>Bahan: {{ $order->bahan->pluck('nama_bahan')->implode(', ') ?: '-' }}</p>
                            <p class="mt-1 font-mono">Ukuran: {{ $order->ukuran->map(fn($u) => $u->nama_ukuran . ' (' . $u->pivot->kuantitas . ' pcs)')->implode(', ') ?: '-' }}</p>
                        </td>
                        <td class="py-4 text-right font-mono font-medium text-[#1C1917]">
                            {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Waiting Price' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals & Payment Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-8">
            
            <div class="bg-[#FAF7F2]/60 p-5 border border-[#EADACE] text-xs">
                <span class="text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase block mb-2">REKENING PEMBAYARAN:</span>
                <div class="space-y-1 font-mono text-[#292524]">
                    <p>Bank: <strong class="text-[#1C1917]">Bank Central Asia (BCA)</strong></p>
                    <p>No. Rekening: <strong class="text-[#B85331]">8420-9988-771</strong></p>
                    <p>Atas Nama: <strong class="text-[#1C1917]">PT Tigabenang Busana Indonesia</strong></p>
                </div>
            </div>

            <!-- Summary Calculations -->
            <div class="space-y-2 text-xs font-mono">
                <div class="flex justify-between py-3 border-t border-[#EADACE] text-sm font-bold text-[#1C1917]">
                    <span>TOTAL HARGA:</span>
                    <span class="text-[#B85331] text-base">
                        {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Waiting Price' }}
                    </span>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t border-[#EADACE]/70 flex flex-col sm:flex-row items-center justify-between text-xs text-[#9E9084] gap-4">
            <p>&copy; {{ date('Y') }} Tigabenang. All rights reserved.</p>
            <div class="text-right text-[11px] font-mono">
                <p class="font-medium text-[#292524]">Tigabenang Vendor Portal</p>
                <p>Finance & Administration</p>
            </div>
        </div>

    </div>

</body>
</html>
