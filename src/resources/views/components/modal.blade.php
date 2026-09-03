@props([
    'name',
    'title' => null,
    'maxWidth' => '2xl',
])

@php
    $maxWidths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        'full' => 'max-w-full',
    ];
@endphp

<div
    x-data="{ show: false }"
    x-show="show"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center"
>
    <!-- Backdrop -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-[#1C2430]/60 backdrop-blur-xs transition-opacity"
        x-on:click="show = false"
    ></div>

    <!-- Modal Dialog -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 sm:scale-98"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 sm:scale-98"
        class="bg-white rounded-xl overflow-hidden shadow-xl transform transition-all w-full {{ $maxWidths[$maxWidth] ?? 'max-w-2xl' }} z-10 border border-[#E2E5E9] my-8"
    >
        @if ($title)
            <div class="px-5 sm:px-6 py-4 border-b border-[#E2E5E9] flex items-center justify-between bg-[#F7F7F5]">
                <h3 class="text-sm sm:text-base font-semibold text-[#1C2430]">{{ $title }}</h3>
                <button type="button" x-on:click="show = false" class="text-[#667085] hover:text-[#1C2430] rounded-md p-1 hover:bg-[#E2E5E9] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <div class="p-5 sm:p-6">
            {{ $slot }}
        </div>
    </div>
</div>

