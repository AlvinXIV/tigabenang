@extends('layouts.customer')

@section('title', 'Permintaan diterima')

@php
    $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
    $vendorEmail = trim((string) config('fitvendor.contact.email'));
    $vendorLocation = trim((string) config('fitvendor.contact.location'));
    $totalQuantity = $pemesanan
        ? (int) $pemesanan->ukuran->sum(fn ($ukuran) => (int) ($ukuran->pivot->kuantitas ?? 0))
        : 0;
    $estimatedTotalLabel = $pemesanan
        ? 'Rp '.number_format((float) $pemesanan->total_harga, 0, ',', '.')
        : 'Rp 0';
    $whatsappMessage = $pemesanan
        ? implode("\n", array_filter([
            'Halo FitVendor,',
            '',
            'Saya ingin melanjutkan konfirmasi pesanan.',
            '',
            'Produk: '.($pemesanan->produk?->nama_produk ?: '-'),
            'Total kuantitas: '.$totalQuantity,
            'Estimasi total: '.$estimatedTotalLabel,
            'Nomor permintaan: #'.$pemesanan->id_pemesanan,
            '',
            'Saya ingin membahas harga final dan pembayaran melalui WhatsApp.',
        ]))
        : (string) config('fitvendor.whatsapp.message');
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
                            <p class="mt-1 text-2xl font-bold text-[#1C2430]">{{ $pemesanan->produk?->nama_produk }}</p>
                            <p class="mt-0.5 text-sm font-medium text-[#667085]">{{ \App\Support\CustomerCatalog::categoryLabel($pemesanan->produk?->kategori?->nama_kategori) }}</p>
                            <p class="mt-2 text-sm font-semibold text-[#1C2430]">Nomor permintaan #{{ $pemesanan->id_pemesanan }}</p>
                        </div>
                        <span class="shrink-0 rounded-lg bg-[#1C2430] px-2.5 py-1 text-xs font-bold text-white">
                            #{{ $pemesanan->id_pemesanan }}
                        </span>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2">
                    <div class="border-b border-[#E2E5E9] px-5 py-5 sm:border-b-0 sm:border-r">
                        <p class="mb-3 text-sm font-semibold text-[#667085]">Ukuran dipilih</p>
                        <ul class="space-y-2 text-sm">
                            @forelse ($pemesanan->ukuran as $ukuran)
                                <li class="flex justify-between">
                                    <span class="font-semibold text-[#1C2430]">{{ $ukuran->nama_ukuran }}</span>
                                    <span class="font-bold text-[#1C2430]">× {{ $ukuran->pivot->kuantitas }}</span>
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
                                <li class="font-semibold text-[#1C2430]">{{ $bahan->nama_bahan }}</li>
                            @empty
                                <li class="text-[#667085]">Tidak ada bahan tercatat.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="border-t border-[#E2E5E9] bg-[#F7F7F5] px-5 py-5">
                    <p class="text-sm font-semibold text-[#667085]">Estimasi total</p>
                    <p class="mt-1 text-3xl font-bold tracking-tight text-[#1C2430]">
                        <x-price :amount="$pemesanan->total_harga" />
                    </p>
                    <p class="mt-2 text-xs leading-relaxed text-[#667085]">
                        Angka ini estimasi. Bisa berubah sesuai detail produksi yang disepakati.
                    </p>
                </div>
            </div>

            <div class="overflow-hidden rounded-[14px] border border-[#E2E5E9] bg-white">
                <div class="border-b border-[#E2E5E9] bg-[#F7F7F5] px-5 py-4">
                    <span class="section-badge">Langkah berikutnya</span>
                    <h2 class="mt-2 text-xl font-bold text-[#1C2430]">Konfirmasi harga</h2>
                </div>
                <div class="px-5 py-5">
                    <p class="text-sm leading-relaxed text-[#667085]">
                        Harga final dikonfirmasi bersama vendor. Lanjut via WhatsApp untuk harga dan pembayaran. Belum ada pembayaran yang dipotong.
                    </p>

                    @if ($vendorEmail !== '' || $vendorLocation !== '')
                        <div class="mt-5 rounded-xl border border-[#E2E5E9] bg-[#F7F7F5] p-4">
                            <p class="mb-1 text-sm font-semibold text-[#667085]">Kontak vendor</p>
                            <p class="font-bold text-[#1C2430]">FitVendor</p>
                            @if ($vendorLocation !== '')
                                <p class="mt-1 text-sm text-[#667085]">{{ $vendorLocation }}</p>
                            @endif
                            @if ($vendorEmail !== '')
                                <a href="mailto:{{ $vendorEmail }}" class="mt-1 block text-sm font-medium text-[#1C2430] underline underline-offset-2 hover:text-[#B8664A]">{{ $vendorEmail }}</a>
                            @endif
                        </div>
                    @endif

                    @if ($whatsappHref)
                        <div class="mt-5">
                            <a
                                href="{{ $whatsappHref }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-[8px] bg-[#25D366] px-5 py-3.5 text-sm font-semibold text-white no-underline"
                            >
                                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41a10.1 10.1 0 0 0 4.65 1.12h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                                </svg>
                                Lanjut via WhatsApp
                            </a>
                            <p class="mt-2 text-center text-xs text-[#667085]">
                                Bahas harga final dan konfirmasi pembayaran. Ini belum menyelesaikan pembayaran.
                            </p>
                        </div>
                    @endif
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
