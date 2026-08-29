@props([
    'headers' => [],
])

<div class="overflow-x-auto w-full">
    <table {{ $attributes->merge(['class' => 'w-full text-left border-collapse text-sm text-slate-600']) }}>
        @if (!empty($headers))
            <thead>
                <tr class="border-b border-slate-200/80 bg-slate-50/80 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    @foreach ($headers as $header)
                        <th class="px-6 py-3.5 whitespace-nowrap">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-slate-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
