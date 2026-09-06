@php
    $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
    $whatsappMessage = rawurlencode((string) config('fitvendor.whatsapp.message'));
    $whatsappHref   = $whatsappNumber !== '' ? "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}" : null;
    $email          = trim((string) config('fitvendor.contact.email'));
    $location       = trim((string) config('fitvendor.contact.location'));
    $navLinks = [
        ['Portofolio',       'home'],
        ['Koleksi',          'collection.index'],
        ['Virtual fitting',  'virtual-fitting'],
        ['Tentang',          'about'],
        ['Pesan custom',     'order.create'],
    ];
@endphp

<footer style="background:#0D2237;color:#FFFFFF;border-top:1px solid rgba(255,255,255,0.08);">
    <div class="mx-auto max-w-[1200px] px-5 py-12 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-3">
            <div>
                <a href="{{ route('home') }}" class="mb-4 inline-flex items-center gap-2.5 no-underline">
                    <span class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-[10px] bg-white">
                        <img src="{{ asset('images/clothiq-logo.png') }}?v=3" alt="Logo FitVendor" width="32" height="32" class="h-[78%] w-[78%] object-contain">
                    </span>
                    <span class="text-lg font-semibold tracking-tight text-white">FitVendor</span>
                </a>
                <p class="max-w-xs text-sm leading-relaxed text-white/70">
                    Vendor pakaian custom untuk tim, komunitas, acara, dan brand. Atur ukuran, pilih bahan, lalu kirim detail pesanan.
                </p>
            </div>

            <div>
                <p class="mb-4 text-sm font-semibold text-white">Navigasi</p>
                <ul class="m-0 flex list-none flex-col gap-2.5 p-0">
                    @foreach ($navLinks as [$label, $route])
                        <li>
                            <a href="{{ route($route) }}" class="text-sm text-white/70 no-underline hover:text-white">
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
                            <a href="{{ $whatsappHref ?? 'https://wa.me/'.$whatsappNumber }}" target="_blank" rel="noopener noreferrer" class="text-sm text-white/80 no-underline hover:text-white">
                                {{ $phoneFormatted }}
                            </a>
                        </li>
                    @endif
                    @if ($email !== '')
                        <li>
                            <a href="mailto:{{ $email }}" class="text-sm text-white/80 no-underline hover:text-white">{{ $email }}</a>
                        </li>
                    @endif
                    @if ($location !== '')
                        <li class="text-sm text-white/80">{{ $location }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-[1200px] flex-wrap items-center justify-between gap-3 px-5 py-4 lg:px-8">
            <p class="text-xs text-white/50">© {{ date('Y') }} FitVendor. Hak cipta dilindungi.</p>
            <p class="text-xs text-white/50">Vendor pakaian custom</p>
        </div>
    </div>
</footer>
