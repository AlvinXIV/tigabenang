@props([
    'label' => 'Menu aksi',
    'align' => 'right',
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'left-0 origin-top-left',
        default => 'right-0 origin-top-right',
    };
@endphp

<div
    x-data="{
        open: false,
        id: 'menu-' + Math.random().toString(36).substring(2, 9),
        dropUp: false,
        toggle() {
            if (!this.open) {
                const rect = $el.getBoundingClientRect();
                this.dropUp = (window.innerHeight - rect.bottom) < 180;
                window.dispatchEvent(new CustomEvent('action-menu-opened', { detail: this.id }));
                this.open = true;
            } else {
                this.open = false;
            }
        },
        close() {
            this.open = false;
        }
    }"
    @action-menu-opened.window="if ($event.detail !== id) open = false"
    @keydown.escape.window="close()"
    @click.outside="close()"
    class="relative inline-block text-left"
>
    <button
        type="button"
        @click.stop="toggle()"
        :aria-expanded="open"
        aria-haspopup="true"
        aria-label="{{ $label }}"
        title="{{ $label }}"
        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-[#667085] hover:text-[#1C2430] hover:bg-[#F0F2F5] active:bg-[#E2E5E9] focus:outline-none focus:ring-2 focus:ring-[#B8664A]/30 transition-colors cursor-pointer border-0 bg-transparent"
    >
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
        </svg>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        :class="dropUp ? 'bottom-full mb-1' : 'top-full mt-1'"
        class="absolute {{ $alignmentClasses }} z-50 w-44 sm:w-48 bg-white border border-[#E2E5E9] rounded-lg shadow-lg py-1 text-xs focus:outline-none overflow-hidden"
        style="display: none;"
        @click="close()"
    >
        {{ $slot }}
    </div>
</div>
