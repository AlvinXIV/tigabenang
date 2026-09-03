@props(['title' => 'Belum ada data', 'message' => 'Silakan periksa kembali nanti.'])

<div class="rounded-xl border border-dashed border-[#E2E5E9] bg-white px-6 py-12 text-center">
    <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[#F4E9E4]">
        <svg class="h-5 w-5 text-[#B8664A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
    </div>
    <p class="text-sm sm:text-base font-semibold text-[#1C2430]">{{ $title }}</p>
    <p class="mx-auto mt-1 max-w-sm text-xs leading-relaxed text-[#667085]">{{ $message }}</p>
    @if ($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>

