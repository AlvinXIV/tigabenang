<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Konsultasi Pesanan #TB-{{ str_pad($order->id_pemesanan, 5, '0', STR_PAD_LEFT) }} | Tigabenang</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #F8F9FA;
            color: #172A39;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        @page {
            size: A4 portrait;
            margin: 10mm 12mm;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            html, body {
                background: #FFFFFF !important;
                color: #172A39 !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .document-card {
                max-width: 100% !important;
                width: 100% !important;
                border: none !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .print-avoid-break {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            thead tr {
                background-color: #F1F4F7 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            a, a[href]:after {
                text-decoration: none !important;
                content: none !important;
            }
        }
        .document-card {
            max-width: 820px;
            margin: 2rem auto;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(23, 42, 57, 0.06);
            padding: 2.5rem 3rem;
        }
    </style>
</head>
<body class="py-6 px-4">

    @php
        $totalQuantity = (int) $order->ukuran->sum(fn ($u) => (int) ($u->pivot->kuantitas ?? 0));
        $unitPrice = (float) ($order->produk?->harga ?? 0);
        $estimatedTotal = $unitPrice * $totalQuantity;
        
        $fileExt = $order->upload_design ? strtolower(pathinfo($order->upload_design, PATHINFO_EXTENSION)) : '';
        $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
        $designUrl = $order->upload_design
            ? (\App\Support\CustomerMedia::imageUrl($order->upload_design) ?? asset('storage/' . $order->upload_design))
            : null;
            
        $waNum = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number', '6281234567890'));
        $waText = rawurlencode("Halo Tigabenang, saya ingin konsultasi terkait pesanan #TB-" . str_pad($order->id_pemesanan, 5, '0', STR_PAD_LEFT));
        $waHref = $waNum ? "https://wa.me/{$waNum}?text={$waText}" : null;
    @endphp

    {{-- Top Action Bar (Screen Only, Hidden on Print) --}}
    <div class="max-w-[820px] mx-auto mb-5 flex flex-wrap items-center justify-between gap-3 no-print">
        <a
            href="{{ url()->previous() ?: route('order.success') }}"
            class="inline-flex items-center gap-2 text-xs font-semibold text-[#172A39] bg-white px-4 py-2.5 border border-[#CBD5E1] hover:bg-[#F8FAFC] rounded-lg transition-colors text-decoration-none shadow-xs"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Halaman Pesanan</span>
        </a>

        <div class="flex items-center gap-2.5">
            <button
                onclick="window.print()"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#172A39] hover:bg-[#243D52] text-white text-xs font-bold rounded-lg transition-all shadow-xs cursor-pointer border-0"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak / Simpan PDF</span>
            </button>

            @if ($waHref)
                <a
                    href="{{ $waHref }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#25D366] hover:bg-[#20ba59] text-white text-xs font-bold rounded-lg transition-all shadow-xs text-decoration-none"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                    </svg>
                    <span>Lanjut ke WhatsApp</span>
                </a>
            @endif
        </div>
    </div>

    {{-- Official Printable Document --}}
    <main class="document-card">
        
        {{-- Header: Brand & Document Meta --}}
        <header class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-6 border-b border-[#E2E8F0]">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-11 h-11 bg-[#172A39] text-[#FAF8F5] rounded-xl flex items-center justify-center font-extrabold text-base tracking-wider shadow-xs">
                        TB
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-[#172A39] tracking-tight leading-none">TIGABENANG</h1>
                        <p class="text-[11px] font-semibold tracking-wider text-[#64748B] uppercase mt-1">Konveksi &amp; Atelier Digital</p>
                    </div>
                </div>
                <p class="text-xs text-[#64748B] max-w-sm mt-3 leading-relaxed">
                    Spesialis Pakaian Custom, Seragam &amp; Busana Komunitas Berkualitas<br>
                    WhatsApp: {{ config('fitvendor.whatsapp.number', '0812-3456-7890') }} &bull; Web: tigabenang.com
                </p>
            </div>

            <div class="text-left sm:text-right">
                <span class="inline-block px-2.5 py-1 bg-[#F1F5F9] border border-[#CBD5E1] rounded-full text-[10px] font-extrabold tracking-wider text-[#172A39] uppercase mb-1.5">
                    Order Brief / Konsultasi
                </span>
                <h2 class="text-base sm:text-lg font-mono font-extrabold text-[#172A39] tracking-tight">
                    #TB-{{ str_pad($order->id_pemesanan, 5, '0', STR_PAD_LEFT) }}
                </h2>
                <div class="text-xs text-[#64748B] mt-2 space-y-0.5">
                    <p>Tanggal: <strong class="text-[#172A39] font-semibold">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') . ' WIB' : date('d M Y') }}</strong></p>
                    <p>Status: <strong class="text-amber-700 font-bold">Konsultasi Awal (Pra-Produksi)</strong></p>
                </div>
            </div>
        </header>

        {{-- Section 1: Customer Information --}}
        <section class="py-5 border-b border-[#E2E8F0] grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
            <div>
                <span class="text-[10px] font-extrabold tracking-wider text-[#64748B] uppercase block mb-1">
                    DATA PEMESAN
                </span>
                <p class="text-sm font-bold text-[#172A39] m-0">{{ $order->nama }}</p>
                <p class="text-xs font-medium text-[#475569] mt-0.5 font-mono">No. WhatsApp: {{ $order->no_hp ?? '-' }}</p>
            </div>
            <div>
                <span class="text-[10px] font-extrabold tracking-wider text-[#64748B] uppercase block mb-1">
                    ALAMAT PENGIRIMAN
                </span>
                <p class="text-xs leading-relaxed text-[#334155] font-medium m-0">
                    {{ $order->alamat ?? '-' }}
                </p>
            </div>
        </section>

        {{-- Section 2: Product & Fabric Materials --}}
        <section class="py-5 border-b border-[#E2E8F0]">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                <div>
                    <span class="text-[10px] font-extrabold tracking-wider text-[#64748B] uppercase block mb-1">
                        PRODUK DIPILIH
                    </span>
                    <p class="text-sm font-bold text-[#172A39] m-0">
                        {{ $order->produk?->nama_produk ?: '-' }}
                    </p>
                    @if ($order->produk?->kategori)
                        <p class="text-xs font-semibold text-[#64748B] mt-0.5">
                            Kategori: {{ \App\Support\CustomerCatalog::categoryLabel($order->produk->kategori->nama_kategori) }}
                        </p>
                    @endif
                </div>
                <div>
                    <span class="text-[10px] font-extrabold tracking-wider text-[#64748B] uppercase block mb-1">
                        PILIHAN BAHAN KAIN
                    </span>
                    <div class="flex flex-wrap gap-1.5 mt-1">
                        @forelse ($order->bahan as $b)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-[#F8FAFC] border border-[#CBD5E1] text-xs font-semibold text-[#172A39]">
                                🧵 {{ $b->nama_bahan }}
                            </span>
                        @empty
                            <span class="text-xs text-[#94A3B8] italic">Bahan standar atelier</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 3: Size Breakdown Table --}}
        <section class="py-5 border-b border-[#E2E8F0]">
            <span class="text-[10px] font-extrabold tracking-wider text-[#64748B] uppercase block mb-2.5">
                RINCIAN UKURAN &amp; JUMLAH (SIZE BREAKDOWN)
            </span>
            <div class="overflow-x-auto rounded-lg border border-[#E2E8F0]">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-[#E2E8F0] text-[10px] font-extrabold tracking-wider text-[#475569] uppercase">
                            <th class="p-3">Ukuran</th>
                            <th class="p-3 text-center">Jumlah (Qty)</th>
                            <th class="p-3 text-right">Estimasi Satuan</th>
                            <th class="p-3 text-right">Subtotal Estimasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E8F0]">
                        @forelse ($order->ukuran as $u)
                            @php
                                $qty = (int) ($u->pivot->kuantitas ?? 0);
                                $rowSubtotal = $unitPrice * $qty;
                            @endphp
                            <tr>
                                <td class="p-3 font-bold text-[#172A39]">
                                    Ukuran {{ $u->nama_ukuran }}
                                </td>
                                <td class="p-3 text-center font-bold text-[#172A39]">
                                    {{ $qty }} pcs
                                </td>
                                <td class="p-3 text-right text-[#64748B] font-mono">
                                    Rp {{ number_format($unitPrice, 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-right font-bold text-[#172A39] font-mono">
                                    Rp {{ number_format($rowSubtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-[#94A3B8] italic">
                                    Tidak ada data ukuran tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-[#F1F5F9] font-extrabold text-[#172A39] border-t-2 border-[#CBD5E1]">
                            <td class="p-3 uppercase text-[11px] tracking-wide">
                                Total Kuantitas
                            </td>
                            <td class="p-3 text-center font-mono text-sm">
                                {{ $totalQuantity }} pcs
                            </td>
                            <td class="p-3 text-right text-[11px] uppercase text-[#64748B]">
                                Estimasi Total
                            </td>
                            <td class="p-3 text-right font-mono text-sm font-extrabold text-[#172A39]">
                                Rp {{ number_format($estimatedTotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        {{-- Section 4: Attached Design / Artwork --}}
        <section class="py-5 border-b border-[#E2E8F0] print-avoid-break">
            <span class="text-[10px] font-extrabold tracking-wider text-[#64748B] uppercase block mb-2">
                LAMPIRAN DESAIN / ARTWORK PEMESAN
            </span>

            @if ($order->upload_design)
                <div class="p-4 bg-[#F8FAFC] border border-[#CBD5E1] rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4 min-w-0">
                        @if ($isImage && $designUrl)
                            <a href="{{ $designUrl }}" target="_blank" class="block shrink-0">
                                <img
                                    src="{{ $designUrl }}"
                                    alt="Mockup Desain"
                                    class="w-24 h-24 sm:w-28 sm:h-28 object-contain bg-white rounded-lg border border-[#E2E8F0] shadow-xs hover:opacity-90 transition-opacity"
                                >
                            </a>
                        @else
                            <div class="w-16 h-16 rounded-lg bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-bold text-[#172A39] truncate">
                                {{ basename($order->upload_design) }}
                            </p>
                            <p class="text-[11px] text-[#64748B] mt-0.5 font-medium uppercase">
                                Format: {{ $fileExt ?: 'Berkas' }} &bull; Status: Terunggah
                            </p>
                            @if ($designUrl)
                                <a
                                    href="{{ $designUrl }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-1 mt-2 text-xs font-bold text-[#172A39] hover:underline no-print"
                                >
                                    <span>Buka Gambar Asli (Resolusi Penuh)</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="p-4 bg-[#F8FAFC] border border-dashed border-[#CBD5E1] rounded-xl text-xs text-[#64748B]">
                    <p class="m-0 font-medium">
                        Tidak ada file desain yang diunggah saat pengisian formulir. Konsep desain dan artwork dapat didiskusikan langsung bersama tim atelier Tigabenang melalui WhatsApp.
                    </p>
                </div>
            @endif
        </section>

        {{-- Section 5: Customer Notes --}}
        @if ($order->notes)
            <section class="py-5 border-b border-[#E2E8F0] print-avoid-break">
                <span class="text-[10px] font-extrabold tracking-wider text-[#64748B] uppercase block mb-1.5">
                    CATATAN KHUSUS PEMESAN
                </span>
                <div class="p-3.5 bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl text-xs leading-relaxed text-[#172A39] font-medium">
                    {{ $order->notes }}
                </div>
            </section>
        @endif

        {{-- Section 6: Summary & Consultation Notice --}}
        <section class="pt-5 print-avoid-break">
            <div class="bg-[#F8FAFC] p-4 border border-[#E2E8F0] rounded-xl space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-bold text-[#64748B] uppercase text-[10px] tracking-wider">Estimasi Awal Pesanan:</span>
                    <span class="text-base font-extrabold text-[#172A39] font-mono">
                        Rp {{ number_format($estimatedTotal, 0, ',', '.') }}
                    </span>
                </div>
                <p class="text-[11px] leading-relaxed text-[#64748B] m-0 border-t border-[#E2E8F0] pt-2">
                    *<strong>Catatan Penting:</strong> Nominal di atas merupakan estimasi harga dasar berdasarkan kuantitas yang diajukan. Harga final, biaya tambahan penyesuaian bordir/sablon khusus, serta jadwal antrean produksi akan dikonfirmasi dan disepakati bersama pihak vendor Tigabenang melalui WhatsApp sebelum proses produksi dimulai.
                </p>
            </div>
        </section>

        {{-- Document Footer --}}
        <footer class="mt-8 pt-4 border-t border-[#E2E8F0] flex items-center justify-between text-[11px] text-[#94A3B8] print-avoid-break">
            <p class="m-0">&copy; {{ date('Y') }} Tigabenang Atelier. Hak cipta dilindungi undang-undang.</p>
            <p class="m-0 font-medium text-[#475569]">Dokumen Ringkasan Konsultasi Resmi</p>
        </footer>

    </main>

</body>
</html>
