@if (! request()->routeIs('order.*', 'deal-order.*') && ! request()->is('order*', 'form-pemesanan*'))
<a
    href="{{ route('order.create') }}"
    class="fixed right-5 bottom-5 z-[90] inline-flex min-h-12 items-center gap-2.5 rounded-[10px] bg-[#102A43] px-4 py-2.5 text-sm font-semibold text-white no-underline shadow-[0_4px_16px_rgba(16,42,67,0.25)] transition-all duration-200 hover:bg-[#1C3D5A] hover:shadow-[0_8px_24px_rgba(16,42,67,0.35)] hover:-translate-y-0.5"
    aria-label="Konsultasikan pesanan"
>
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a.75.75 0 0 1-1.154-.598 4.793 4.793 0 0 0 1.258-3.023C3.996 15.752 3 13.978 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
    </svg>
    <span>Konsultasikan pesanan</span>
</a>
@endif

