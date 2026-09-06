@php
    $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
    $whatsappMessage = rawurlencode((string) config('fitvendor.whatsapp.message'));
    $whatsappHref   = $whatsappNumber !== '' ? "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}" : null;
    $email          = trim((string) config('fitvendor.contact.email'));
    $location       = trim((string) config('fitvendor.contact.location'));
    $bantuanLinks = [
        ['Tentang Kami',   route('about')],
        ['Cara Pemesanan', route('about') . '#cara-pemesanan'],
        ['FAQ',            route('home') . '#faq'],
    ];
@endphp

<footer style="background:#0D2237;color:#FFFFFF;border-top:1px solid rgba(255,255,255,0.08);">
    <div class="mx-auto max-w-[1200px] px-5 py-12 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-3">
            <div>
                <a href="{{ route('home') }}" class="mb-4 inline-flex items-center gap-2.5 no-underline">
                    <span class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-[10px] bg-white">
                        <img src="{{ asset('images/clothiq-logo.png') }}?v=3" alt="Logo Tigabenang" width="32" height="32" class="h-[78%] w-[78%] object-contain">
                    </span>
                    <span class="text-lg font-semibold tracking-tight text-white">Tigabenang</span>
                </a>
                <p class="max-w-xs text-sm leading-relaxed text-white/70">
                    Vendor pakaian custom untuk tim, komunitas, acara, dan brand. Atur ukuran, pilih bahan, lalu kirim detail pesanan.
                </p>
            </div>

            <div>
                <p class="mb-4 text-sm font-semibold text-white">Bantuan</p>
                <ul class="m-0 flex list-none flex-col gap-2.5 p-0">
                    @foreach ($bantuanLinks as [$label, $href])
                        <li>
                            <a href="{{ $href }}" class="text-sm text-white/70 no-underline hover:text-white transition-colors">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="mb-4 text-sm font-semibold text-white">Kontak</p>
                <ul class="m-0 flex list-none flex-col gap-3 p-0">
                    @if ($whatsappNumber !== '')
                        @php
                            $phoneFormatted = $whatsappNumber;
                            if (str_starts_with($whatsappNumber, '62') && strlen($whatsappNumber) >= 11) {
                                $phoneFormatted = '+62 ' . substr($whatsappNumber, 2, 3) . '-' . substr($whatsappNumber, 5, 4) . '-' . substr($whatsappNumber, 9);
                            } elseif (!str_starts_with($whatsappNumber, '+')) {
                                $phoneFormatted = '+' . $whatsappNumber;
                            }
                        @endphp
                        <li>
                            <a href="{{ $whatsappHref ?? 'https://wa.me/'.$whatsappNumber }}" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center gap-2.5 text-sm text-white/80 no-underline hover:text-white transition-colors">
                                <svg class="h-4 w-4 shrink-0 fill-white/70 group-hover:fill-white transition-colors" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                                </svg>
                                <span>{{ $phoneFormatted }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($email !== '')
                        <li>
                            <a href="mailto:{{ $email }}" class="group inline-flex items-center gap-2.5 text-sm text-white/80 no-underline hover:text-white transition-colors">
                                <svg class="h-4 w-4 shrink-0 stroke-white/70 group-hover:stroke-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.75A1.75 1.75 0 0 1 5.75 5h12.5A1.75 1.75 0 0 1 20 6.75v10.5A1.75 1.75 0 0 1 18.25 19H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 7 7 5 7-5"/>
                                </svg>
                                <span>{{ $email }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($location !== '')
                        <li class="flex items-start gap-2.5 text-sm text-white/80">
                            <svg class="h-4 w-4 shrink-0 stroke-white/70 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"/>
                            </svg>
                            <span class="leading-relaxed">{{ $location }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-[1200px] flex-wrap items-center justify-between gap-3 px-5 py-4 lg:px-8">
            <p class="text-xs text-white/50">© {{ date('Y') }} Tigabenang. Hak cipta dilindungi.</p>
            <p class="text-xs text-white/50">Vendor pakaian custom</p>
        </div>
    </div>
</footer>
