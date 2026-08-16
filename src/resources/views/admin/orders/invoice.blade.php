<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order['invoice_number'] }} - Tigabenang</title>
    
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
        <a href="{{ route('admin.pesanan.show', $order['id']) }}" class="inline-flex items-center gap-2 text-xs font-mono font-medium text-[#78716C] hover:text-[#B85331] bg-white px-4 py-2 border border-[#D9CCC1] transition-colors uppercase tracking-wider">
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
                    INVOICE
                </span>
                <p class="text-base font-bold text-[#1C1917]">{{ $order['invoice_number'] }}</p>
                <div class="text-xs text-[#78716C] mt-1 space-y-0.5">
                    <p>Date: <strong class="text-[#292524]">{{ $order['invoice_date'] }}</strong></p>
                    <p>Due Date: <strong class="text-[#292524]">{{ $order['due_date'] }}</strong></p>
                    <p>Status: <span class="font-bold text-amber-700 uppercase">UNPAID (PENDING)</span></p>
                </div>
            </div>
        </div>

        <!-- Customer Bill To Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-8 border-b border-[#EADACE]/70 text-xs">
            <div>
                <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-1">BILLED TO:</span>
                <h3 class="text-sm font-medium text-[#1C1917]">{{ $order['customer_name'] }}</h3>
                <p class="text-[#574E46]">{{ $order['company_or_institution'] }}</p>
                <p class="text-[#78716C] font-mono mt-0.5">{{ $order['phone'] }} | {{ $order['email'] }}</p>
            </div>
            <div>
                <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-1">SHIPPING DESTINATION:</span>
                <p class="text-[#78716C] leading-relaxed">{{ $order['shipping_address'] }}</p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-8 border-b border-[#EADACE]/70">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        <th class="py-3">ITEM DESCRIPTION</th>
                        <th class="py-3 text-center">QTY</th>
                        <th class="py-3 text-right">UNIT PRICE</th>
                        <th class="py-3 text-right">TOTAL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/50">
                    <tr>
                        <td class="py-4">
                            <p class="font-medium text-[#1C1917]">{{ $order['product_name'] }}</p>
                            <p class="text-[#78716C] text-[11px] mt-0.5">Color: {{ $order['color'] }} • Custom print & embroidery</p>
                        </td>
                        <td class="py-4 text-center font-mono text-[#1C1917]">{{ $order['quantity'] }} pcs</td>
                        <td class="py-4 text-right font-mono text-[#78716C]">Rp {{ number_format($order['unit_price'], 0, ',', '.') }}</td>
                        <td class="py-4 text-right font-mono font-medium text-[#1C1917]">Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals & Payment Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-8">
            
            <!-- Bank Transfer Account Info -->
            <div class="bg-[#FAF7F2]/60 p-5 border border-[#EADACE] text-xs">
                <span class="text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase block mb-2">BANK TRANSFER DETAILS:</span>
                <div class="space-y-1 font-mono text-[#292524]">
                    <p>Bank: <strong class="text-[#1C1917]">{{ $order['bank_info']['bank_name'] }}</strong></p>
                    <p>Account: <strong class="text-[#B85331]">{{ $order['bank_info']['account_number'] }}</strong></p>
                    <p>Account Name: <strong class="text-[#1C1917]">{{ $order['bank_info']['account_name'] }}</strong></p>
                </div>
                <p class="text-[10px] text-[#9E9084] mt-3 italic">*Please include order reference ({{ $order['order_code'] }}) in transfer note.</p>
            </div>

            <!-- Summary Calculations -->
            <div class="space-y-2 text-xs font-mono">
                <div class="flex justify-between py-1 text-[#78716C]">
                    <span>Subtotal:</span>
                    <span class="font-medium text-[#1C1917]">Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1 text-[#78716C]">
                    <span>Tax (0%):</span>
                    <span class="font-medium text-[#1C1917]">Rp 0</span>
                </div>
                <div class="flex justify-between py-1 text-[#78716C]">
                    <span>Shipping:</span>
                    <span class="font-medium text-emerald-800">FREE</span>
                </div>
                <div class="flex justify-between py-3 border-t border-[#EADACE] text-sm font-bold text-[#1C1917]">
                    <span>TOTAL DUE:</span>
                    <span class="text-[#B85331] text-base">Rp {{ number_format($order['total_price'], 0, ',', '.') }}</span>
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
