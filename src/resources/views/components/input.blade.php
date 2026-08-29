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
        <label for="{{ $id }}" class="block text-xs font-semibold text-slate-700 tracking-wide">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-xl">
        @if ($type === 'textarea')
            <textarea
                id="{{ $id }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge(['class' => 'w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-colors duration-150 disabled:bg-slate-50 disabled:text-slate-400 resize-y shadow-xs']) }}
            >{{ $slot }}</textarea>
        @elseif ($type === 'select')
            <select
                id="{{ $id }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge(['class' => 'w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-colors duration-150 disabled:bg-slate-50 disabled:text-slate-400 shadow-xs']) }}
            >
                {{ $slot }}
            </select>
        @else
            <input
                type="{{ $type }}"
                id="{{ $id }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge(['class' => 'w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-colors duration-150 disabled:bg-slate-50 disabled:text-slate-400 shadow-xs']) }}
            />
        @endif
    </div>

    @if ($hint && !$error)
        <p class="text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @if ($error)
        <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ $error }}
        </p>
    @endif
</div>
