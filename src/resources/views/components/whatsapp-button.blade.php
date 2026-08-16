@php
    $number = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
    $message = rawurlencode((string) config('fitvendor.whatsapp.message'));
    $href = "https://wa.me/{$number}?text={$message}";
@endphp

<a
    href="{{ $href }}"
    target="_blank"
    rel="noopener noreferrer"
    class="fixed bottom-5 right-5 z-40 inline-flex items-center gap-3 border border-charcoal bg-charcoal px-4 py-3 text-ivory shadow-sm transition-colors hover:bg-terracotta hover:border-terracotta"
    aria-label="Pesan Sekarang on WhatsApp"
>
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41a10.1 10.1 0 0 0 4.65 1.12h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
    </svg>
    <span class="text-[11px] font-medium uppercase tracking-[0.18em]">Pesan Sekarang</span>
</a>
