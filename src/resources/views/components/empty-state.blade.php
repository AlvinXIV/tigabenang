@props(['title' => 'Nothing here yet', 'message' => 'Please check back shortly.'])

<div class="rounded-2xl border border-dashed border-border bg-surface-alt px-8 py-16 text-center">
    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-primary-muted">
        <svg class="h-7 w-7 text-primary/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
    </div>
    <p class="text-lg font-bold text-text-base">{{ $title }}</p>
    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-text-muted">{{ $message }}</p>
    {{ $slot }}
</div>
