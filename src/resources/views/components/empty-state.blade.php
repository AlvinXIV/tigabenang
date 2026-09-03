@props(['title' => 'Belum ada data', 'message' => 'Silakan cek lagi nanti.'])

<div class="rounded-[14px] border border-dashed border-[#E2E5E9] bg-white px-8 py-16 text-center">
    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-[10px] bg-[#F4E9E4]">
        <svg class="h-6 w-6 text-[#B8664A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
    </div>
    <p class="text-lg font-semibold text-[#1C2430]">{{ $title }}</p>
    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-[#667085]">{{ $message }}</p>
    {{ $slot }}
</div>
