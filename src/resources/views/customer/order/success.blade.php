@extends('layouts.customer')

@section('title', 'Request Received')

@section('content')
    <section class="px-5 py-20 lg:px-8 lg:py-28">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">FitVendor</p>
            <h1 class="mt-4 font-serif text-5xl text-charcoal">Request Received</h1>
            <p class="mt-5 text-base leading-relaxed text-muted">
                We've received your clothing request. Our team will contact you shortly.
            </p>
        </div>

        @if ($pemesanan)
            <div class="mx-auto mt-14 max-w-2xl border border-line bg-paper px-6 py-8 text-left">
                <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Selected product</p>
                <p class="mt-2 font-serif text-3xl text-charcoal">{{ $pemesanan->produk?->nama_produk }}</p>
                <p class="mt-1 text-sm text-muted">{{ $pemesanan->produk?->kategori?->nama_kategori }}</p>

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
                    <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Total estimated order</p>
                    <p class="mt-2 font-serif text-3xl"><x-price :amount="$pemesanan->total_harga" /></p>
                </div>
            </div>
        @endif

        <div class="mt-12 text-center">
            <a href="{{ route('collection.index') }}" class="text-[11px] uppercase tracking-[0.22em] text-terracotta hover:text-terracotta-dark">
                Return to collection
            </a>
        </div>
    </section>
@endsection
