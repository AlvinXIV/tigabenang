@extends('layouts.customer')

@section('title', 'Permintaan diterima')

@php
    $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
    $vendorEmail = trim((string) config('fitvendor.contact.email'));
    $vendorLocation = trim((string) config('fitvendor.contact.location'));
    $totalQuantity = $pemesanan
        ? (int) $pemesanan->ukuran->sum(fn ($ukuran) => (int) ($ukuran->pivot->kuantitas ?? 0))
        : 0;
    $estimatedTotal = $pemesanan
        ? (float) ($pemesanan->produk?->harga ?? 0) * $totalQuantity
        : 0;
    $estimatedTotalLabel = 'Rp '.number_format($estimatedTotal, 0, ',', '.');

    $bahanList = $pemesanan ? $pemesanan->bahan->pluck('nama_bahan')->filter()->join(', ') : '';
    $sizeBreakdown = $pemesanan
        ? $pemesanan->ukuran->map(fn ($u) => '• Ukuran '.$u->nama_ukuran.': '.(int)($u->pivot->kuantitas ?? 0).' pcs')->join("\n")
        : '';

    $fileExt = $pemesanan && $pemesanan->upload_design ? strtolower(pathinfo($pemesanan->upload_design, PATHINFO_EXTENSION)) : '';
    $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
    $designUrl = $pemesanan && $pemesanan->upload_design
        ? (\App\Support\CustomerMedia::imageUrl($pemesanan->upload_design) ?? asset('storage/' . $pemesanan->upload_design))
        : null;

    $pdfUrl = $pemesanan ? route('order.pdf', $pemesanan->id_pemesanan) : null;

    if ($pemesanan) {
        $msgParts = [
            'Halo Tigabenang, saya ingin konsultasi pemesanan pakaian custom dengan detail berikut:',
            '',
            '📋 *DATA PEMESAN*',
            '• No. Antrean: #TB-' . str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT),
            '• Nama: ' . $pemesanan->nama,
            '• No. HP: ' . $pemesanan->no_hp,
            '• Alamat: ' . $pemesanan->alamat,
            '',
            '👕 *SPESIFIKASI PRODUK & BAHAN*',
            '• Kategori: ' . \App\Support\CustomerCatalog::categoryLabel($pemesanan->produk?->kategori?->nama_kategori),
            '• Produk: ' . ($pemesanan->produk?->nama_produk ?: '-'),
            '• Pilihan Bahan: ' . ($bahanList ?: 'Bahan Standar Atelier'),
            '',
            '📏 *RINCIAN UKURAN & JUMLAH*',
            $sizeBreakdown ?: '• Belum ada rincian ukuran',
            '*Total Kuantitas:* ' . $totalQuantity . ' pcs',
        ];

        if ($designUrl) {
            $msgParts[] = '';
            $msgParts[] = '📸 *DESAIN / ARTWORK:*';
            $msgParts[] = $designUrl;
        }

        if (!empty($pemesanan->notes)) {
            $msgParts[] = '';
            $msgParts[] = '📝 *CATATAN TAMBAHAN:*';
            $msgParts[] = $pemesanan->notes;
        }

        $msgParts[] = '';
        $msgParts[] = '💰 *ESTIMASI TOTAL AWAL:* ' . $estimatedTotalLabel;
        $msgParts[] = '*(Harga final & DP akan disepakati bersama)*';

        if ($pdfUrl) {
            $msgParts[] = '';
            $msgParts[] = '📄 *LEMBAR KONSULTASI LENGKAP (PDF):*';
            $msgParts[] = $pdfUrl;
        }

        $msgParts[] = '';
        $msgParts[] = 'Mohon konfirmasi ketersediaan bahan, kalkulasi harga final, dan jadwal antrean produksi. Terima kasih!';

        $whatsappMessage = implode("\n", $msgParts);
    } else {
        $whatsappMessage = (string) config('fitvendor.whatsapp.message');
    }

    $whatsappHref = $whatsappNumber !== ''
        ? 'https://wa.me/'.$whatsappNumber.'?text='.rawurlencode($whatsappMessage)
        : null;
@endphp

@section('content')

    <section class="fv-page-hero">
        <div class="mx-auto max-w-3xl px-5 py-12 text-center lg:px-8">
            <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-[10px] bg-[#3F7A62]">
                <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="section-badge mb-3 justify-center">Permintaan tercatat</span>
            <h1 class="text-3xl font-bold tracking-tight md:text-4xl">Terima kasih, permintaan Anda sudah masuk</h1>
            <p class="mx-auto mt-3 max-w-lg text-sm leading-relaxed">
                Data pesanan sudah tersimpan. Lanjutkan lewat WhatsApp untuk konfirmasi harga dan produksi.
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
                            <p class="text-sm font-semibold text-[#667085]">Produk dipilih</p>
                            <p class="mt-1 text-2xl font-bold text-[#102A43]">{{ $pemesanan->produk?->nama_produk }}</p>
                            <p class="mt-0.5 text-sm font-medium text-[#667085]">{{ \App\Support\CustomerCatalog::categoryLabel($pemesanan->produk?->kategori?->nama_kategori) }}</p>
                            <p class="mt-2 text-sm font-semibold text-[#102A43]">Nomor permintaan #{{ $pemesanan->id_pemesanan }}</p>
                        </div>
                        <span class="shrink-0 rounded-lg bg-[#102A43] px-2.5 py-1 text-xs font-bold text-white">
                            #TB-{{ str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="border-b border-[#E2E5E9] px-5 py-4 bg-[#FAF8F5] text-xs">
                    <p class="font-bold uppercase tracking-wider text-[11px] text-[#667085] mb-1">Data Pemesan</p>
                    <p class="font-bold text-sm text-[#102A43]">{{ $pemesanan->nama }}</p>
                    <p class="text-[#667085] font-mono mt-0.5">WhatsApp / HP: {{ $pemesanan->no_hp }}</p>
                    <p class="text-[#667085] mt-0.5 leading-relaxed">Alamat Pengiriman: {{ $pemesanan->alamat }}</p>
                </div>

                <div class="grid sm:grid-cols-2">
                    <div class="border-b border-[#E2E5E9] px-5 py-5 sm:border-b-0 sm:border-r">
                        <p class="mb-3 text-sm font-semibold text-[#667085]">Ukuran dipilih</p>
                        <ul class="space-y-2 text-sm">
                            @forelse ($pemesanan->ukuran as $ukuran)
                                <li class="flex justify-between">
                                    <span class="font-semibold text-[#102A43]">{{ $ukuran->nama_ukuran }}</span>
                                    <span class="font-bold text-[#102A43]">× {{ $ukuran->pivot->kuantitas }}</span>
                                </li>
                            @empty
                                <li class="text-[#667085]">Tidak ada ukuran tercatat.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="px-5 py-5">
                        <p class="mb-3 text-sm font-semibold text-[#667085]">Bahan dipilih</p>
                        <ul class="space-y-2 text-sm">
                            @forelse ($pemesanan->bahan as $bahan)
                                <li class="font-semibold text-[#102A43]">{{ $bahan->nama_bahan }}</li>
                            @empty
                                <li class="text-[#667085]">Tidak ada bahan tercatat.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Uploaded Design Preview if exists --}}
                @if ($pemesanan->upload_design)
                    <div class="border-t border-[#E2E5E9] px-5 py-4 bg-[#F8FAFC]">
                        <p class="text-[11px] font-bold text-[#667085] uppercase tracking-wider mb-2">Desain / Artwork Terlampir</p>
                        <div class="flex items-center gap-3.5">
                            @if ($isImage && $designUrl)
                                <a href="{{ $designUrl }}" target="_blank" class="block shrink-0">
                                    <img src="{{ $designUrl }}" alt="Desain Pemesan" class="w-16 h-16 object-contain bg-white rounded-lg border border-[#CBD5E1] shadow-2xs hover:opacity-90 transition-opacity">
                                </a>
                            @else
                                <div class="w-12 h-12 rounded-lg bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-[#102A43] truncate">{{ basename($pemesanan->upload_design) }}</p>
                                @if ($designUrl)
                                    <a href="{{ $designUrl }}" target="_blank" class="text-xs font-bold text-[#102A43] underline mt-0.5 inline-block">
                                        Buka Gambar Resolusi Penuh
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Notes if exists --}}
                @if ($pemesanan->notes)
                    <div class="border-t border-[#E2E5E9] px-5 py-4 bg-[#F7F7F5] text-xs">
                        <p class="font-bold text-[#667085] uppercase tracking-wider text-[11px] mb-1">Catatan Pemesan</p>
                        <p class="text-[#102A43] italic leading-relaxed">{{ $pemesanan->notes }}</p>
                    </div>
                @endif

                <div class="border-t border-[#E2E5E9] bg-[#F7F7F5] px-5 py-5">
                    <p class="text-sm font-semibold text-[#667085]">Estimasi total</p>
                    <p class="mt-1 text-3xl font-bold tracking-tight text-[#1C2430]">
                        <x-price :amount="$estimatedTotal" />
                    </p>
                    <p class="mt-2 text-xs leading-relaxed text-[#667085]">
                        Harga ini merupakan estimasi awal. Harga final akan dikonfirmasi bersama vendor melalui WhatsApp.
                    </p>
                </div>
            </div>

            <div class="overflow-hidden rounded-[14px] border border-[#E2E5E9] bg-white">
                <div class="border-b border-[#E2E5E9] bg-[#F7F7F5] px-5 py-4">
                    <span class="section-badge">Langkah berikutnya</span>
                    <h2 class="mt-2 text-xl font-bold text-[#102A43]">Konfirmasi harga &amp; konsultasi</h2>
                </div>
                <div class="px-5 py-5">
                    <p class="text-sm leading-relaxed text-[#667085]">
                        Harga final dikonfirmasi bersama vendor. Lanjut via WhatsApp untuk konfirmasi harga dan jadwal produksi. Anda juga dapat melihat dan mengunduh berkas lembar konsultasi resmi dalam format PDF di bawah ini.
                    </p>

                    @if ($vendorEmail !== '' || $vendorLocation !== '')
                        <div class="mt-5 rounded-xl border border-[#E2E5E9] bg-[#F7F7F5] p-4">
                            <p class="mb-1 text-sm font-semibold text-[#667085]">Kontak vendor</p>
                            <p class="font-bold text-[#1C2430]">Tigabenang</p>
                            @if ($vendorLocation !== '')
                                <p class="mt-1 text-sm text-[#667085]">{{ $vendorLocation }}</p>
                            @endif
                            @if ($vendorEmail !== '')
                                <a href="mailto:{{ $vendorEmail }}" class="mt-1 block text-sm font-medium text-[#102A43] underline underline-offset-2 hover:text-[#102A43]">{{ $vendorEmail }}</a>
                            @endif
                        </div>
                    @endif

                    <div class="mt-5 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        @if ($whatsappHref)
                            <a
                                href="{{ $whatsappHref }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-[8px] bg-[#25D366] hover:bg-[#20ba59] px-5 py-3.5 text-sm font-bold text-white no-underline shadow-xs transition-colors"
                            >
                                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41a10.1 10.1 0 0 0 4.65 1.12h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                                </svg>
                                Lanjut via WhatsApp
                            </a>
                        @endif

                        @if ($pemesanan)
                            <a
                                href="{{ route('order.pdf', $pemesanan->id_pemesanan) }}"
                                target="_blank"
                                class="inline-flex items-center justify-center gap-2 rounded-[8px] border border-[#CBD5E1] bg-white hover:bg-[#F8FAFC] px-5 py-3.5 text-sm font-bold text-[#172A39] no-underline shadow-xs transition-colors"
                            >
                                <svg class="h-4 w-4 text-[#172A39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Lihat / Cetak Dokumen PDF
                            </a>
                        @endif
                    </div>
                    <p class="mt-2.5 text-center text-xs text-[#667085]">
                        Pesan WhatsApp otomatis menyertakan seluruh rincian pesanan, gambar desain, dan tautan PDF lembar konsultasi.
                    </p>
                </div>
            </div>
        @endif

            <div class="pt-2 text-center">
                <a href="{{ route('collection.index') }}" class="btn-outline">
                    Kembali ke koleksi
                </a>
            </div>
        </div>
    </section>

@endsection
