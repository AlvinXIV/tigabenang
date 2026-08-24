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
            'Halo FitVendor,',
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
    <section class="px-5 py-20 lg:px-8 lg:py-28">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">FitVendor</p>
            <h1 class="mt-4 font-serif text-5xl text-charcoal">Request Received</h1>
            <p class="mt-5 text-base leading-relaxed text-muted">
                We've received your clothing request. The amount below is an estimated total — final pricing will be confirmed with our team.
            </p>
        </div>

        @if ($pemesanan)
            <div class="mx-auto mt-14 max-w-2xl border border-line bg-paper px-6 py-8 text-left">
                <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Selected product</p>
                <p class="mt-2 font-serif text-3xl text-charcoal">{{ $pemesanan->produk?->nama_produk }}</p>
                <p class="mt-1 text-sm text-muted">{{ $pemesanan->produk?->kategori?->nama_kategori }}</p>
                <p class="mt-3 text-[11px] uppercase tracking-[0.18em] text-muted">Order reference #{{ $pemesanan->id_pemesanan }}</p>

                <div class="mt-8 grid gap-8 sm:grid-cols-2">
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Selected sizes</p>
                        <ul class="mt-3 space-y-2 text-sm">
                            @forelse ($pemesanan->ukuran as $ukuran)
                                <li class="flex justify-between border-b border-line py-2">
                                    <span>{{ $ukuran->nama_ukuran }}</span>
                                    <span>{{ $ukuran->pivot->kuantitas }}</span>
                                </li>
                            @empty
                                <li class="text-muted">No sizes recorded.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Selected materials</p>
                        <ul class="mt-3 space-y-2 text-sm">
                            @forelse ($pemesanan->bahan as $bahan)
                                <li class="border-b border-line py-2">{{ $bahan->nama_bahan }}</li>
                            @empty
                                <li class="text-muted">No materials recorded.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="mt-8 border-t border-line pt-6">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Estimated total</p>
                    <p class="mt-2 font-serif text-3xl"><x-price :amount="$pemesanan->total_harga" /></p>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Prices shown here are estimates and may still be negotiated or adjusted based on the final production details.
                    </p>
                </div>
            </div>

            <div class="mx-auto mt-8 max-w-2xl border border-line px-6 py-8 text-left">
                <p class="text-[11px] uppercase tracking-[0.2em] text-terracotta">Next step</p>
                <h2 class="mt-3 font-serif text-3xl text-charcoal">Payment &amp; confirmation</h2>
                <p class="mt-4 text-sm leading-relaxed text-muted">
                    Final pricing is confirmed with the vendor. Continue via WhatsApp to confirm the final price and payment. No payment has been taken yet.
                </p>

                @if ($vendorEmail !== '' || $vendorLocation !== '')
                    <div class="mt-8 border-t border-line pt-6">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Vendor contact</p>
                        <p class="mt-3 font-serif text-2xl text-charcoal">FitVendor</p>
                        @if ($vendorLocation !== '')
                            <p class="mt-2 text-sm text-ink">{{ $vendorLocation }}</p>
                        @endif
                        @if ($vendorEmail !== '')
                            <p class="mt-1 text-sm text-ink">{{ $vendorEmail }}</p>
                        @endif
                    </div>
                @endif

                @if ($whatsappHref)
                    <div class="mt-8">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted">WhatsApp</p>
                        <a
                            href="{{ $whatsappHref }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-4 inline-flex items-center justify-center bg-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-ivory hover:bg-terracotta"
                        >
                            Continue on WhatsApp
                        </a>
                        <p class="mt-3 text-xs leading-relaxed text-muted">
                            Discuss the final price and payment confirmation with our team. This does not complete a payment.
                        </p>
                    </div>
                @endif
            </div>
        @endif

        <div class="mt-12 text-center">
            <a href="{{ route('collection.index') }}" class="text-[11px] uppercase tracking-[0.22em] text-terracotta hover:text-terracotta-dark">
                Return to collection
            </a>
        </div>
    </section>
@endsection
