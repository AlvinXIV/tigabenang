@props([
    'title' => null,
    'subtitle' => null,
    'action' => null,
    'footer' => null,
    'padding' => 'p-5 sm:p-6',
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-[#E2E5E9] shadow-2xs overflow-hidden ' . $class]) }}>
    @if ($title || $subtitle || $action)
        <div class="px-5 sm:px-6 py-4 border-b border-[#E2E5E9] flex flex-wrap items-center justify-between gap-3 bg-white">
            <div>
                @if ($title)
                    <h3 class="text-sm sm:text-base font-semibold text-[#1C2430] leading-snug">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-xs text-[#667085] mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($action)
                <div class="flex items-center gap-2">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="px-5 sm:px-6 py-3.5 bg-[#F7F7F5] border-t border-[#E2E5E9] text-xs text-[#667085] flex items-center justify-between">
            {{ $footer }}
        </div>
    @endif
</div>

