@extends('layouts.deal-order')

@section('title', 'Konfirmasi Pesanan Berhasil')
@section('description', 'Detail konfirmasi pemesanan pakaian custom Clothiq Atelier.')

@section('content')
    <section style="background:#FAF8F5;padding:4rem 0 6rem;">
        <div class="mx-auto max-w-2xl px-5 lg:px-8">

            {{-- ── Success Header Card ──────────────────────────────── --}}
            <div style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:2rem;padding:3rem 2rem;text-align:center;box-shadow:0 12px 36px rgba(23,42,57,0.05);position:relative;overflow:hidden;">
                <div style="width:4.5rem;height:4.5rem;border-radius:50%;background:#172A39;color:#FFFFFF;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.5rem;box-shadow:0 8px 24px rgba(23,42,57,0.25);">
                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="#FAF8F5" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <div style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.35rem 0.875rem;background:#FAF8F5;border:1px solid #DCD6D0;border-radius:9999px;font-size:0.6875rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:#172A39;margin-bottom:0.75rem;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#10B981;"></span>
                    Deal Order Received
                </div>

                <h1 style="font-size:clamp(1.75rem, 3vw, 2.25rem);font-weight:900;letter-spacing:-0.03em;color:#172A39;margin:0;">
                    Formulir Berhasil Diterima
                </h1>

                <p style="margin-top:0.75rem;font-size:0.9375rem;line-height:1.6;color:#555E68;">
                    Terima kasih! Rincian pesanan Anda telah tersimpan ke sistem Clothiq dan siap diproses ke tahap verifikasi bahan &amp; antrean produksi.
                </p>

                @if ($pemesanan)
                    {{-- Order ID Badge --}}
                    <div style="margin-top:2rem;padding:1rem 1.5rem;background:#FAF8F5;border:1.5px dashed #DCD6D0;border-radius:1rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
                        <span style="font-size:0.8125rem;font-weight:700;color:#6E7575;">Nomor Antrean Pesanan:</span>
                        <span style="font-size:1.125rem;font-weight:900;color:#172A39;letter-spacing:0.05em;">#CLQ-{{ str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    {{-- Order Breakdown --}}
                    <div style="margin-top:2rem;text-align:left;border-top:1px solid #EAE2D8;padding-top:1.5rem;display:flex;flex-direction:column;gap:1.25rem;">
                        
                        {{-- Customer Info --}}
                        <div>
                            <p style="font-size:0.6875rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#6E7575;margin:0 0 0.25rem;">Pemesan &amp; Kontak</p>
                            <p style="font-size:0.9375rem;font-weight:800;color:#172A39;margin:0;">{{ $pemesanan->nama }}</p>
                            <p style="font-size:0.8125rem;color:#555E68;margin:0.15rem 0 0;">WhatsApp: {{ $pemesanan->no_hp }}</p>
                            <p style="font-size:0.8125rem;color:#555E68;margin:0.15rem 0 0;">Alamat: {{ $pemesanan->alamat }}</p>
                        </div>

                        {{-- Product & Materials --}}
                        <div>
                            <p style="font-size:0.6875rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#6E7575;margin:0 0 0.25rem;">Produk &amp; Bahan Kain</p>
                            <p style="font-size:0.9375rem;font-weight:800;color:#172A39;margin:0;">
                                {{ $pemesanan->produk?->nama_produk }}
                                @if ($pemesanan->produk?->kategori)
                                    <span style="font-size:0.75rem;font-weight:600;color:#6E7575;">({{ $pemesanan->produk->kategori->nama_kategori }})</span>
                                @endif
                            </p>
                            <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin-top:0.4rem;">
                                @forelse ($pemesanan->bahan as $b)
                                    <span style="font-size:0.75rem;font-weight:800;color:#172A39;background:#FAF8F5;border:1px solid #DCD6D0;border-radius:9999px;padding:0.2rem 0.65rem;">
                                        🧵 {{ $b->nama_bahan }}
                                    </span>
                                @empty
                                    <span style="font-size:0.75rem;color:#8D9494;">Bahan standar atelier</span>
                                @endforelse
                            </div>
                        </div>

                        {{-- Size Breakdown --}}
                        <div>
                            <p style="font-size:0.6875rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#6E7575;margin:0 0 0.5rem;">Rincian Ukuran</p>
                            <div style="background:#FAF8F5;border:1px solid #DCD6D0;border-radius:0.75rem;overflow:hidden;">
                                @php $totalQty = 0; @endphp
                                @foreach ($pemesanan->ukuran as $u)
                                    @php $totalQty += $u->pivot->kuantitas; @endphp
                                    <div style="display:flex;align-items:center;justify-content:space-between;padding:0.65rem 1rem;border-bottom:1px solid #EAE2D8;">
                                        <span style="font-size:0.875rem;font-weight:800;color:#172A39;">Ukuran {{ $u->nama_ukuran }}</span>
                                        <span style="font-size:0.875rem;font-weight:800;color:#172A39;">{{ $u->pivot->kuantitas }} pcs</span>
                                    </div>
                                @endforeach
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem 1rem;background:#EAE2D8;font-weight:900;">
                                    <span style="font-size:0.875rem;color:#172A39;">Total Jumlah</span>
                                    <span style="font-size:0.9375rem;color:#172A39;">{{ $totalQty }} pcs</span>
                                </div>
                            </div>
                        </div>

                        {{-- Total Price --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:1rem;border-top:1.5px solid #EAE2D8;">
                            <span style="font-size:0.875rem;font-weight:800;color:#6E7575;">Estimasi Total:</span>
                            <span style="font-size:1.35rem;font-weight:900;color:#172A39;">Rp {{ number_format((float) $pemesanan->total_harga, 0, ',', '.') }}</span>
                        </div>

                    </div>

                    {{-- WhatsApp Follow Up Action --}}
                    @php
                        $waNum = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number', '628123456789'));
                        $bahanList = $pemesanan->bahan->pluck('nama_bahan')->join(', ');
                        $waText = rawurlencode("Halo Clothiq, saya telah mengisi formulir konfirmasi pesanan dengan detail:\n"
                            . "- No. Antrean: #CLQ-" . str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) . "\n"
                            . "- Nama: {$pemesanan->nama}\n"
                            . "- Produk: {$pemesanan->produk?->nama_produk}\n"
                            . "- Bahan: {$bahanList}\n"
                            . "- Total Qty: {$totalQty} pcs\n"
                            . "- Estimasi: Rp " . number_format((float) $pemesanan->total_harga, 0, ',', '.') . "\n\n"
                            . "Mohon dikonfirmasi untuk proses produksi selanjutnya. Terima kasih!");
                        $waLink = "https://wa.me/{$waNum}?text={$waText}";
                    @endphp

                    <div style="margin-top:2.5rem;display:flex;flex-direction:column;gap:0.75rem;">
                        <a
                            href="{{ $waLink }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="deal-btn-pill"
                            style="display:flex;align-items:center;justify-content:center;gap:0.625rem;min-height:3.25rem;padding:0.75rem 1.75rem;background:#25D366;color:#FFFFFF;border:none;font-size:0.9375rem;font-weight:800;text-decoration:none;box-shadow:0 6px 20px rgba(37,211,102,0.35);"
                        >
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                            </svg>
                            Konfirmasi ke WhatsApp Vendor
                        </a>

                        <a
                            href="{{ route('deal-order.create') }}"
                            style="font-size:0.8125rem;font-weight:700;color:#6E7575;text-decoration:underline;margin-top:0.5rem;"
                        >
                            Isi formulir pesanan lainnya
                        </a>
                    </div>
                @else
                    <div style="margin-top:2rem;">
                        <a href="{{ route('deal-order.create') }}" class="deal-btn-pill" style="display:inline-flex;align-items:center;justify-content:center;padding:0.75rem 2rem;background:#172A39;color:#FFFFFF;text-decoration:none;font-weight:800;font-size:0.875rem;">
                            Buka Formulir Pemesanan
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </section>
@endsection
