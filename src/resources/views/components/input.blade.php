@props([
    'disabled' => false,
    'label' => null,
    'error' => null,
    'hint' => null,
    'type' => 'text',
    'id' => null,
])

@php
    $id = $id ?? ($attributes->get('name') ?? 'input_' . uniqid());
@endphp

<div class="space-y-1.5 w-full">
    @if ($label)
        <label for="{{ $id }}" class="block text-xs font-semibold text-[#1C2430] tracking-normal">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-lg">
        @if ($type === 'textarea')
            <textarea
                id="{{ $id }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge(['class' => 'w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] rounded-lg text-sm text-[#1C2430] placeholder-[#98A2B3] focus:outline-none focus:ring-2 focus:ring-[#102A43]/20 focus:border-[#102A43] transition-colors duration-150 disabled:bg-[#F7F7F5] disabled:text-[#98A2B3] resize-y shadow-2xs']) }}
            >{{ $slot }}</textarea>
        @elseif ($type === 'select')
            <select
                id="{{ $id }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge(['class' => 'w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] rounded-lg text-sm text-[#1C2430] focus:outline-none focus:ring-2 focus:ring-[#102A43]/20 focus:border-[#102A43] transition-colors duration-150 disabled:bg-[#F7F7F5] disabled:text-[#98A2B3] shadow-2xs']) }}
            >
                {{ $slot }}
            </select>
        @else
            <input
                type="{{ $type }}"
                id="{{ $id }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge(['class' => 'w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] rounded-lg text-sm text-[#1C2430] placeholder-[#98A2B3] focus:outline-none focus:ring-2 focus:ring-[#102A43]/20 focus:border-[#102A43] transition-colors duration-150 disabled:bg-[#F7F7F5] disabled:text-[#98A2B3] shadow-2xs']) }}
            />
        @endif
    </div>

    @if ($hint && !$error)
        <p class="text-[11px] text-[#667085]">{{ $hint }}</p>
    @endif

    @if ($error)
        <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ $error }}
        </p>
    @endif
</div>

