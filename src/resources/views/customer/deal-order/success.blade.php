@extends('layouts.customer')

@section('title', 'Pesanan Berhasil')
@section('description', 'Detail konfirmasi pemesanan pakaian custom Tigabenang.')

@section('content')
    @php
        $totalQty = $pemesanan
            ? (int) $pemesanan->ukuran->sum(fn ($u) => (int) ($u->pivot->kuantitas ?? 0))
            : 0;
        $estimatedTotal = $pemesanan
            ? (float) ($pemesanan->produk?->harga ?? 0) * $totalQty
            : 0;
        $categoryName = $pemesanan?->categoryDisplayName() ?: '-';
    @endphp

    <section class="fv-page-hero">
        <div class="mx-auto max-w-3xl px-5 py-12 text-center lg:px-8">
            <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-[10px] bg-[#3F7A62]">
                <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="section-badge mb-3 justify-center">Permintaan tercatat</span>
            <h1 class="text-3xl font-bold tracking-tight md:text-4xl">Formulir berhasil diterima</h1>
            <p class="mx-auto mt-3 max-w-lg text-sm leading-relaxed">
                Rincian pesanan sudah tersimpan ke admin Tigabenang dan siap ditinjau untuk konfirmasi bahan dan produksi.
            </p>
        </div>
    </section>

    <section class="px-5 py-10 lg:px-8 lg:py-12">
        <div class="mx-auto max-w-2xl space-y-5">

            @if ($pemesanan)
                <div class="overflow-hidden rounded-[14px] border border-[#E2E5E9] bg-white">
                    <div class="border-b border-[#E2E5E9] bg-[#F7F7F5] px-5 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-[#667085]">Kategori dipilih</p>
                                <p class="mt-1 text-2xl font-bold text-[#102A43]">{{ $categoryName }}</p>
                                <p class="mt-2 text-sm font-semibold text-[#102A43]">Nomor permintaan #{{ $pemesanan->id_pemesanan }}</p>
                            </div>
                            <span class="shrink-0 rounded-lg bg-[#102A43] px-2.5 py-1 text-xs font-bold text-white">
                                #TB-{{ str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>

                    <div class="border-b border-[#E2E5E9] bg-[#FAF8F5] px-5 py-4 text-xs">
                        <p class="mb-1 text-[11px] font-bold uppercase tracking-wider text-[#667085]">Data pemesan</p>
                        <p class="text-sm font-bold text-[#102A43]">{{ $pemesanan->nama }}</p>
                        <p class="mt-0.5 font-mono text-[#667085]">WhatsApp / HP: {{ $pemesanan->no_hp }}</p>
                        <p class="mt-0.5 leading-relaxed text-[#667085]">Alamat pengiriman: {{ $pemesanan->alamat }}</p>
                    </div>

                    <div class="grid sm:grid-cols-2">
                        <div class="border-b border-[#E2E5E9] px-5 py-5 sm:border-b-0 sm:border-r">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#667085]">Bahan kain</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @forelse ($pemesanan->bahan as $b)
                                    <span class="rounded-md border border-[#E2E5E9] bg-[#F7F7F5] px-2.5 py-1 text-xs font-medium text-[#102A43]">
                                        {{ $b->nama_bahan }}
                                    </span>
                                @empty
                                    <span class="text-xs text-[#98A2B3]">Bahan standar atelier</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="px-5 py-5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#667085]">Rincian ukuran</p>
                            <div class="mt-2 space-y-1.5">
                                @foreach ($pemesanan->ukuran as $u)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="font-semibold text-[#102A43]">Ukuran {{ $u->nama_ukuran }}</span>
                                        <span class="text-[#667085]">{{ $u->pivot->kuantitas }} pcs</span>
                                    </div>
                                @endforeach
                                <div class="flex items-center justify-between border-t border-[#E2E5E9] pt-2 text-sm font-bold text-[#102A43]">
                                    <span>Total jumlah</span>
                                    <span>{{ $totalQty }} pcs</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($pemesanan->upload_design)
                        @php
                            $fileExt = strtolower(pathinfo($pemesanan->upload_design, PATHINFO_EXTENSION));
                            $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                            $designUrl = \App\Support\CustomerMedia::imageUrl($pemesanan->upload_design) ?? asset('storage/' . $pemesanan->upload_design);
                        @endphp
                        <div class="border-t border-[#E2E5E9] px-5 py-5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#667085]">Desain terlampir</p>
                            <div class="mt-2 flex items-center gap-3">
                                @if ($isImage && $designUrl)
                                    <a href="{{ $designUrl }}" target="_blank" class="shrink-0">
                                        <img src="{{ $designUrl }}" alt="Desain" class="h-16 w-16 rounded-lg border border-[#E2E5E9] bg-white object-contain">
                                    </a>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-[#102A43]">{{ basename($pemesanan->upload_design) }}</p>
                                    @if ($designUrl)
                                        <a href="{{ $designUrl }}" target="_blank" class="text-xs font-semibold text-[#102A43] underline">Buka berkas asli</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($pemesanan->notes)
                        <div class="border-t border-[#E2E5E9] px-5 py-5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#667085]">Catatan pemesan</p>
                            <p class="mt-1 text-sm italic leading-relaxed text-[#102A43]">{{ $pemesanan->notes }}</p>
                        </div>
                    @endif

                    <div class="border-t border-[#E2E5E9] px-5 py-5">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-[#667085]">Estimasi Total:</span>
                            <span class="text-xl font-bold text-[#102A43]">Rp {{ number_format($estimatedTotal, 0, ',', '.') }}</span>
                        </div>
                        <p class="mt-1 text-xs leading-relaxed text-[#667085]">
                            Harga ini merupakan estimasi awal. Harga final akan dikonfirmasi bersama vendor melalui WhatsApp.
                        </p>
                    </div>
                </div>

                @php
                    $waNum = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number', '6281234567890'));
                    $bahanList = $pemesanan->bahan->pluck('nama_bahan')->filter()->join(', ');
                    $sizeBreakdown = $pemesanan->ukuran
                        ->map(fn ($u) => '• Ukuran '.$u->nama_ukuran.': '.(int)($u->pivot->kuantitas ?? 0).' pcs')
                        ->join("\n");
                    $designUrl = $pemesanan->upload_design
                        ? (\App\Support\CustomerMedia::imageUrl($pemesanan->upload_design) ?? asset('storage/' . $pemesanan->upload_design))
                        : null;
                    $pdfUrl = route('order.pdf', $pemesanan->id_pemesanan);

                    $msgParts = [
                        'Halo Tigabenang, saya ingin konsultasi pemesanan pakaian custom dengan detail berikut:',
                        '',
                        '◆ *DATA PEMESAN*',
                        '• No. Antrean: #TB-' . str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT),
                        '• Nama: ' . $pemesanan->nama,
                        '• No. HP: ' . $pemesanan->no_hp,
                        '• Alamat: ' . $pemesanan->alamat,
                        '',
                        '◆ *SPESIFIKASI PRODUK & BAHAN*',
                        '• Kategori: ' . $categoryName,
                        '• Pilihan Bahan: ' . ($bahanList ?: 'Bahan Standar Atelier'),
                        '',
                        '◆ *RINCIAN UKURAN & JUMLAH*',
                        $sizeBreakdown ?: '• Belum ada rincian ukuran',
                        '*Total Kuantitas:* ' . $totalQty . ' pcs',
                    ];

                    if ($designUrl) {
                        $msgParts[] = '';
                        $msgParts[] = '◆ *DESAIN / ARTWORK:*';
                        $msgParts[] = $designUrl;
                    }

                    if (!empty($pemesanan->notes)) {
                        $msgParts[] = '';
                        $msgParts[] = '◆ *CATATAN TAMBAHAN:*';
                        $msgParts[] = $pemesanan->notes;
                    }

                    $msgParts[] = '';
                    $msgParts[] = '◆ *ESTIMASI TOTAL AWAL:* Rp ' . number_format($estimatedTotal, 0, ',', '.');
                    $msgParts[] = '*(Harga final & DP akan disepakati bersama)*';
                    $msgParts[] = '';
                    $msgParts[] = '◆ *LEMBAR KONSULTASI LENGKAP (PDF):*';
                    $msgParts[] = $pdfUrl;
                    $msgParts[] = '';
                    $msgParts[] = 'Mohon konfirmasi ketersediaan bahan, kalkulasi harga final, dan jadwal antrean produksi. Terima kasih!';

                    $waText = rawurlencode(implode("\n", $msgParts));
                    $waLink = "https://wa.me/{$waNum}?text={$waText}";
                @endphp

                <div class="space-y-3">
                    <a
                        href="{{ $waLink }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-primary flex min-h-12 w-full items-center justify-center gap-2"
                    >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                        </svg>
                        Lanjut via WhatsApp
                    </a>

                    <a
                        href="{{ route('order.pdf', $pemesanan->id_pemesanan) }}"
                        target="_blank"
                        class="btn-outline flex min-h-12 w-full items-center justify-center gap-2"
                    >
                        Lihat / Cetak Dokumen PDF
                    </a>

                    <p class="text-center">
                        <a href="{{ route('deal-order.create') }}" class="text-sm font-medium text-[#667085] underline">
                            Isi formulir pesanan lainnya
                        </a>
                    </p>
                </div>
            @else
                <div class="rounded-[14px] border border-[#E2E5E9] bg-white p-6 text-center">
                    <a href="{{ route('deal-order.create') }}" class="btn-primary">
                        Buka formulir pemesanan
                    </a>
                </div>
            @endif

        </div>
    </section>
@endsection
