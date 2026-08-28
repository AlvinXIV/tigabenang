@extends('layouts.customer')

@section('title', 'Request Received')

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
            'Halo Clothiq,',
            '',
            'Saya ingin melanjutkan konfirmasi pesanan.',
            '',
            'Produk: '.($pemesanan->produk?->nama_produk ?: '—'),
            'Total kuantitas: '.$totalQuantity,
            'Estimasi total: '.$estimatedTotalLabel,
            'Order reference: #'.$pemesanan->id_pemesanan,
            '',
            'Saya ingin mendiskusikan harga final dan melanjutkan pembayaran melalui WhatsApp.',
        ]))
        : (string) config('fitvendor.whatsapp.message');
    $whatsappHref = $whatsappNumber !== ''
        ? 'https://wa.me/'.$whatsappNumber.'?text='.rawurlencode($whatsappMessage)
        : null;
@endphp

@section('content')

    {{-- ── Success Header ───────────────────────── --}}
    <section class="border-b border-border bg-primary" style="background-color:#172A39;border-color:#DCD6D0;">
        <div class="mx-auto max-w-3xl px-5 py-16 lg:px-8 lg:py-20 text-center">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full" style="background:#FC563C;box-shadow:0 6px 20px rgba(252,86,60,0.4);">
                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="section-badge justify-center mb-4" style="color:#FC563C;">
                <span style="width:1.5rem;height:3px;background:#FC563C;border-radius:2px;display:inline-block;"></span>
                Clothiq
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl">Request Received</h1>
            <p class="mt-5 text-base leading-relaxed text-white/75 max-w-xl mx-auto">
                We've received your clothing request. The amount below is an estimated total — final pricing will be confirmed with our team.
            </p>
        </div>
    </section>

    <section class="px-5 py-12 lg:px-8 lg:py-16" style="background:#FFFFFF;">
        <div class="mx-auto max-w-2xl space-y-6">

        @if ($pemesanan)
            {{-- ── Order Summary ─────────────────── --}}
            <div class="rounded-2xl border bg-white overflow-hidden shadow-sm" style="border-color:#DCD6D0;">
                <div class="border-b px-6 py-5" style="background:#F6F4F1;border-color:#DCD6D0;">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.12em]" style="color:#6E7575;">Selected Product</p>
                            <p class="mt-1 text-2xl font-black" style="color:#172A39;">{{ $pemesanan->produk?->nama_produk }}</p>
                            <p class="mt-0.5 text-sm font-semibold" style="color:#6E7575;">{{ $pemesanan->produk?->kategori?->nama_kategori }}</p>
                            <p class="mt-2 text-xs font-bold" style="color:#FC563C;">Order reference #{{ $pemesanan->id_pemesanan }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-3.5 py-1.5 text-xs font-extrabold uppercase tracking-wider" style="background:#172A39;color:#FFFFFF;">
                            #{{ $pemesanan->id_pemesanan }}
                        </span>
                    </div>
                </div>

                <div class="grid gap-0 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x" style="border-color:#DCD6D0;">
                    {{-- Sizes --}}
                    <div class="px-6 py-5">
                        <p class="text-xs font-bold uppercase tracking-[0.12em] mb-3" style="color:#6E7575;">Selected Sizes</p>
                        <ul class="space-y-2.5 text-sm">
                            @forelse ($pemesanan->ukuran as $ukuran)
                                <li class="flex justify-between">
                                    <span class="font-bold" style="color:#172A39;">{{ $ukuran->nama_ukuran }}</span>
                                    <span class="font-extrabold" style="color:#FC563C;">× {{ $ukuran->pivot->kuantitas }}</span>
                                </li>
                            @empty
                                <li style="color:#6E7575;">No sizes recorded.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Materials --}}
                    <div class="px-6 py-5">
                        <p class="text-xs font-bold uppercase tracking-[0.12em] mb-3" style="color:#6E7575;">Selected Materials</p>
                        <ul class="space-y-2.5 text-sm">
                            @forelse ($pemesanan->bahan as $bahan)
                                <li class="font-bold" style="color:#172A39;">{{ $bahan->nama_bahan }}</li>
                            @empty
                                <li style="color:#6E7575;">No materials recorded.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="border-t px-6 py-6" style="background:#F6F4F1;border-color:#DCD6D0;">
                    <p class="text-xs font-bold uppercase tracking-[0.12em]" style="color:#6E7575;">Estimated total</p>
                    <p class="mt-1.5 text-3xl font-black tracking-tight" style="color:#172A39;">
                        <x-price :amount="$pemesanan->total_harga" />
                    </p>
                    <p class="mt-2 text-xs leading-relaxed" style="color:#6E7575;">
                        Prices shown here are estimates and may still be negotiated or adjusted based on the final production details.
                    </p>
                </div>
            </div>

            {{-- ── Next Step: WhatsApp ──────────── --}}
            <div class="rounded-2xl border bg-white overflow-hidden shadow-sm" style="border-color:#DCD6D0;">
                <div class="border-b px-6 py-4" style="background:#F6F4F1;border-color:#DCD6D0;">
                    <span class="section-badge">Next Step</span>
                    <h2 class="mt-2 text-xl font-extrabold" style="color:#172A39;">Payment & Confirmation</h2>
                </div>
                <div class="px-6 py-6">
                    <p class="text-sm leading-relaxed" style="color:#6E7575;">
                        Final pricing is confirmed with the vendor. Continue via WhatsApp to confirm the final price and payment. No payment has been taken yet.
                    </p>

                    @if ($vendorEmail !== '' || $vendorLocation !== '')
                        <div class="mt-6 rounded-xl border p-4" style="border-color:#DCD6D0;background:#F6F4F1;">
                            <p class="text-xs font-bold uppercase tracking-[0.12em] mb-2" style="color:#6E7575;">Vendor Contact</p>
                            <p class="font-extrabold" style="color:#172A39;">Clothiq</p>
                            @if ($vendorLocation !== '')
                                <p class="mt-1 text-sm" style="color:#6E7575;">{{ $vendorLocation }}</p>
                            @endif
                            @if ($vendorEmail !== '')
                                <a href="mailto:{{ $vendorEmail }}" class="mt-1 block text-sm font-bold hover:underline" style="color:#FC563C;">{{ $vendorEmail }}</a>
                            @endif
                        </div>
                    @endif

                    @if ($whatsappHref)
                        <div class="mt-6">
                            <a
                                href="{{ $whatsappHref }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex w-full items-center justify-center gap-3 rounded-xl px-6 py-4 text-sm font-extrabold text-white shadow-lg transition-all"
                                style="background:#25D366;box-shadow:0 6px 20px rgba(37,211,102,0.35);"
                                onmouseover="this.style.background='#1ebe5d'"
                                onmouseout="this.style.background='#25D366'"
                            >
                                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41a10.1 10.1 0 0 0 4.65 1.12h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                                </svg>
                                Continue on WhatsApp
                            </a>
                            <p class="mt-2 text-center text-xs" style="color:#6E7575;">
                                Discuss the final price and payment confirmation with our team. This does not complete a payment.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

            {{-- Return link --}}
            <div class="text-center pt-2">
                <a href="{{ route('collection.index') }}" class="section-badge justify-center hover:opacity-75 transition-opacity" style="color:#172A39;">
                    Return to Collection
                </a>
            </div>
        </div>
    </section>

@endsection
