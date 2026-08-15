<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order['invoice_number'] }} - Tigabenang</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
<body class="bg-slate-100 min-h-screen py-8 px-4 font-sans text-slate-800 antialiased">

    <!-- Top Action Bar for Admin -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.pesanan.show', $order['id']) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Detail Pesanan</span>
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-xs font-bold rounded-xl shadow-md transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Cetak Faktur (Print / PDF)</span>
            </button>
        </div>
    </div>

    <!-- Official Invoice Document -->
    <div class="invoice-box max-w-4xl mx-auto bg-white rounded-3xl border border-slate-200/80 shadow-xl p-8 sm:p-12">
        
        <!-- Header: Company Brand & Invoice Badge -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-8 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-cyan-500 flex items-center justify-center text-white font-black text-xl shadow-sm">
                        T
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-900 leading-tight">PT TIGABENANG APPAREL</h1>
                        <p class="text-xs text-slate-500 font-medium">Digital Confection & Fashion Vendor</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500 max-w-sm mt-2 leading-relaxed">
                    Jl. Industri Kreatif No. 88, Cibaduyut, Bandung, Jawa Barat 40235<br>
                    Telp: +62 22 7890 1234 | WhatsApp: 0812-3456-7890<br>
                    Email: finance@tigabenang.com
                </p>
            </div>

            <div class="text-left sm:text-right">
                <span class="inline-block px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-black uppercase tracking-wider mb-2 border border-indigo-100">
                    Faktur Penjualan (Invoice)
                </span>
                <p class="text-lg font-extrabold text-slate-900">{{ $order['invoice_number'] }}</p>
                <div class="text-xs text-slate-500 mt-1 space-y-0.5">
                    <p>Tanggal: <strong class="text-slate-700">{{ $order['invoice_date'] }}</strong></p>
                    <p>Jatuh Tempo: <strong class="text-slate-700">{{ $order['due_date'] }}</strong></p>
                    <p>Status: <span class="font-bold text-amber-600 uppercase">Belum Lunas (Pending)</span></p>
                </div>
            </div>
        </div>

        <!-- Customer Bill To Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-8 border-b border-slate-200 text-xs">
            <div>
                <span class="text-slate-400 font-bold uppercase tracking-wider block mb-2">Tagihan Kepada:</span>
                <h3 class="text-base font-bold text-slate-900">{{ $order['customer_name'] }}</h3>
                <p class="font-semibold text-slate-700">{{ $order['company_or_institution'] }}</p>
                <p class="text-slate-500 mt-1">{{ $order['phone'] }} | {{ $order['email'] }}</p>
            </div>
            <div>
                <span class="text-slate-400 font-bold uppercase tracking-wider block mb-2">Alamat Pengiriman:</span>
                <p class="text-slate-700 leading-relaxed">{{ $order['shipping_address'] }}</p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-8 border-b border-slate-200">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 uppercase tracking-wider">
                        <th class="py-3 font-bold">Deskripsi Barang / Jasa Konveksi</th>
                        <th class="py-3 font-bold text-center">Jumlah</th>
                        <th class="py-3 font-bold text-right">Harga Satuan</th>
                        <th class="py-3 font-bold text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-4">
                            <p class="font-bold text-slate-900 text-sm">{{ $order['product_name'] }}</p>
                            <p class="text-slate-500 text-[11px] mt-0.5">Warna: {{ $order['color'] }} • Custom Bordir & Sablon Plastisol</p>
                        </td>
                        <td class="py-4 text-center font-bold text-slate-800">{{ $order['quantity'] }} pcs</td>
                        <td class="py-4 text-right font-medium text-slate-700">Rp {{ number_format($order['unit_price'], 0, ',', '.') }}</td>
                        <td class="py-4 text-right font-bold text-slate-900">Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals & Payment Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-8">
            
            <!-- Bank Transfer Account Info -->
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 text-xs">
                <span class="font-bold text-slate-900 block mb-2">Informasi Pembayaran Transfer Bank:</span>
                <div class="space-y-1 text-slate-600">
                    <p>Bank: <strong class="text-slate-800">{{ $order['bank_info']['bank_name'] }}</strong></p>
                    <p>Nomor Rekening: <strong class="text-indigo-600 font-mono text-sm">{{ $order['bank_info']['account_number'] }}</strong></p>
                    <p>Atas Nama: <strong class="text-slate-800">{{ $order['bank_info']['account_name'] }}</strong></p>
                </div>
                <p class="text-[11px] text-slate-400 mt-3 italic">*Harap sertakan kode pesanan ({{ $order['order_code'] }}) pada berita transfer.</p>
            </div>

            <!-- Summary Calculations -->
            <div class="space-y-2 text-xs">
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Subtotal:</span>
                    <span class="font-semibold text-slate-800">Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1 text-slate-600">
                    <span>PPN (0%):</span>
                    <span class="font-semibold text-slate-800">Rp 0</span>
                </div>
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Biaya Pengiriman (Bandung Area):</span>
                    <span class="font-semibold text-emerald-600">Gratis (Free Ongkir)</span>
                </div>
                <div class="flex justify-between py-3 border-t-2 border-slate-900 text-sm font-extrabold text-slate-900">
                    <span>Total Tagihan:</span>
                    <span class="text-indigo-600 text-lg">Rp {{ number_format($order['total_price'], 0, ',', '.') }}</span>
                </div>
            </div>

        </div>

        <!-- Footer Signatures & SDG 8 Support Note -->
        <div class="mt-12 pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
            <p>Terima kasih atas kepercayaan Anda memesan di Tigabenang.</p>
            <div class="text-right text-[11px]">
                <p class="font-bold text-slate-700">Tigabenang Digital Apparel</p>
                <p>Bagian Keuangan & Administrasi</p>
            </div>
        </div>

    </div>

</body>
</html>
