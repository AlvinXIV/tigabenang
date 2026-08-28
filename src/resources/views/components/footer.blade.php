@php
    $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));
    $whatsappMessage = rawurlencode((string) config('fitvendor.whatsapp.message'));
    $whatsappHref   = $whatsappNumber !== '' ? "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}" : null;
    $email          = trim((string) config('fitvendor.contact.email'));
    $location       = trim((string) config('fitvendor.contact.location'));
    $navLinks = [
        ['Portfolio',       'home'],
        ['Collection',      'collection.index'],
        ['Materials',       'materials.index'],
        ['Virtual Fitting', 'virtual-fitting'],
        ['About',           'about'],
        ['Request Order',   'order.create'],
    ];
@endphp

<footer style="background:#172A39;color:#FFFFFF;border-top:1px solid rgba(233,228,224,0.1);">

    {{-- ── Upper ─────────────────────────────────── --}}
    <div class="mx-auto max-w-7xl px-5 py-14 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-3">

            {{-- Brand --}}
            <div>
                <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;margin-bottom:1.25rem;">
                    <span style="width:46px;height:46px;background:#FFFFFF;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                        <img src="{{ asset('images/clothiq.png') }}" alt="Clothiq logo" width="46" height="46" style="width:100%;height:100%;object-fit:contain;">
                    </span>
                    <span style="font-size:1.125rem;font-weight:900;letter-spacing:0.06em;text-transform:uppercase;color:#FFFFFF;">Clothiq</span>
                </a>
                <p style="font-size:0.875rem;line-height:1.75;color:rgba(233,228,224,0.7);max-width:280px;">
                    Studio pakaian custom dengan teknologi virtual fitting 3D. Pesan pakaian sesuai ukuran tubuhmu.
                </p>
                @if ($whatsappHref)
                    <a
                        href="{{ $whatsappHref }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="margin-top:1.5rem;display:inline-flex;align-items:center;gap:0.625rem;background:#25D366;color:#FFFFFF;padding:0.6875rem 1.25rem;font-size:0.8125rem;font-weight:800;border-radius:0.625rem;text-decoration:none;box-shadow:0 4px 14px rgba(37,211,102,0.3);transition:all 0.15s;"
                        onmouseover="this.style.background='#1ebe5d';this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='#25D366';this.style.transform='translateY(0)'"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                @endif
            </div>

            {{-- Quick Links --}}
            <div>
                <p style="font-size:0.75rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:#FC563C;margin-bottom:1.25rem;">Navigasi</p>
                <ul style="display:flex;flex-direction:column;gap:0.625rem;list-style:none;padding:0;margin:0;">
                    @foreach ($navLinks as [$label, $route])
                        <li>
                            <a href="{{ route($route) }}" style="font-size:0.875rem;font-weight:500;color:rgba(233,228,224,0.75);text-decoration:none;transition:color 0.15s;" onmouseover="this.style.color='#FC563C'" onmouseout="this.style.color='rgba(233,228,224,0.75)'">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <p style="font-size:0.75rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:#FC563C;margin-bottom:1.25rem;">Kontak</p>
                <ul style="display:flex;flex-direction:column;gap:0.875rem;list-style:none;padding:0;margin:0;">
                    @if ($email !== '')
                        <li style="display:flex;align-items:flex-start;gap:0.75rem;">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" style="color:#FC563C;margin-top:2px;flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $email }}" style="font-size:0.875rem;color:rgba(233,228,224,0.85);text-decoration:none;transition:color 0.15s;" onmouseover="this.style.color='#FC563C'" onmouseout="this.style.color='rgba(233,228,224,0.85)'">{{ $email }}</a>
                        </li>
                    @endif
                    @if ($location !== '')
                        <li style="display:flex;align-items:flex-start;gap:0.75rem;">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" style="color:#FC563C;margin-top:2px;flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span style="font-size:0.875rem;color:rgba(233,228,224,0.85);">{{ $location }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    {{-- ── Bottom Bar ──────────────────────────── --}}
    <div style="border-top:1px solid rgba(233,228,224,0.1);">
        <div class="mx-auto max-w-7xl px-5 py-5 lg:px-8" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;">
            <p style="font-size:0.8125rem;color:rgba(233,228,224,0.5);">© {{ date('Y') }} Clothiq. All rights reserved.</p>
            <p style="font-size:0.8125rem;color:rgba(233,228,224,0.5);">Made with <span style="color:#FC563C;">♥</span> for custom clothing</p>
        </div>
    </div>

</footer>
