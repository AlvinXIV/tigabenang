@props([
    'headers' => [],
])

<div class="overflow-x-auto w-full">
    <table {{ $attributes->merge(['class' => 'w-full text-left border-collapse text-sm text-[#1C2430]']) }}>
        @if (!empty($headers))
            <thead>
                <tr class="border-b border-[#E2E5E9] bg-[#F7F7F5] text-[11px] font-bold text-[#1C2430] uppercase tracking-wider">
                    @foreach ($headers as $header)
                        <th class="px-5 py-3.5 whitespace-nowrap">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-[#E2E5E9] bg-white">
            {{ $slot }}
        </tbody>
    </table>
</div>

