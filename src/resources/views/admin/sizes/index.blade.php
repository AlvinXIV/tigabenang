@extends('layouts.admin')

@section('title', 'Size Charts')

@section('content')
<div class="space-y-8" x-data="{ selectedChartId: 1, newChartModalOpen: false, editModalOpen: false }">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTON                  -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Size Charts</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Manage and standardize your measurement profiles across garment categories.
            </p>
        </div>

        <a
            href="{{ route('admin.ukuran.create') }}"
            class="px-4 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-1.5 cursor-pointer"
        >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>NEW CHART</span>
        </a>
    </div>

    <!-- ============================================== -->
    <!-- 2. MASTER-DETAIL TWO-COLUMN LAYOUT             -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- LEFT COLUMN (1/3): SIZE CHARTS LIST -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    ACTIVE PROFILES
                </span>
                <span class="text-xs font-mono text-[#78716C]">
                    {{ count($sizeCharts) }} Profiles
                </span>
            </div>

            <div class="space-y-3">
                @foreach ($sizeCharts as $chart)
                    <div
                        @click="selectedChartId = {{ $chart['id'] }}"
                        :class="selectedChartId === {{ $chart['id'] }} ? 'border-l-4 border-l-[#B85331] border-[#EADACE] bg-white shadow-[0_2px_12px_rgba(0,0,0,0.02)]' : 'border border-[#EADACE]/70 bg-white/60 hover:bg-white'"
                        class="p-5 cursor-pointer transition-all space-y-3"
                    >
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="text-sm sm:text-base font-medium text-[#1C1917] leading-snug">
                                {{ $chart['name'] }}
                            </h3>
                            <span class="px-2 py-0.5 text-[9px] font-mono font-medium uppercase tracking-wider bg-[#EFE7DE] text-[#786C62] shrink-0">
                                {{ $chart['category'] }}
                            </span>
                        </div>

                        <p class="text-xs text-[#78716C] line-clamp-2">
                            {{ $chart['description'] }}
                        </p>

                        <div class="pt-2 border-t border-[#EADACE]/50 flex items-center justify-between text-xs text-[#78716C]">
                            <span class="font-mono text-[11px]">Sizes: {{ implode(', ', $chart['sizes']) }}</span>
                            <span class="text-emerald-700 text-[10px] font-mono font-bold uppercase">● {{ $chart['status'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- RIGHT COLUMN (2/3): SELECTED SIZE CHART DETAIL -->
        <div class="lg:col-span-2">
            @foreach ($sizeCharts as $chart)
                <div
                    x-show="selectedChartId === {{ $chart['id'] }}"
                    class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6"
                >
                    <!-- Detail Header -->
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-4 border-b border-[#EADACE]/70">
                        <div>
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-xl sm:text-2xl font-normal text-[#1C1917] tracking-tight">
                                    {{ $chart['name'] }}
                                </h2>
                                <span class="px-2 py-0.5 text-[9px] font-mono font-bold uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $chart['status'] }}
                                </span>
                            </div>
                            <p class="text-xs text-[#78716C] mt-1.5 leading-relaxed max-w-xl">
                                {{ $chart['description'] }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('admin.ukuran.edit', $chart['id']) }}"
                                title="Edit Size Chart"
                                class="p-2 text-[#786C62] hover:text-[#1C1917] hover:bg-[#FAF7F2] border border-[#EADACE] transition-colors cursor-pointer inline-flex items-center justify-center"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.ukuran.destroy', $chart['id']) }}" method="POST" onsubmit="return confirm('Hapus profil size chart ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    title="Delete Size Chart"
                                    class="p-2 text-rose-600 hover:text-rose-700 hover:bg-rose-50 border border-[#EADACE] transition-colors cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Measurement Matrix Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                                    <th class="px-5 py-3.5">MEASUREMENT POINT</th>
                                    @foreach ($chart['sizes'] as $sz)
                                        <th class="px-5 py-3.5 text-center font-mono font-bold">{{ $sz }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EADACE]/60">
                                @foreach ($chart['points'] as $pt)
                                    <tr class="hover:bg-[#FAF7F2]/40 transition-colors">
                                        <td class="px-5 py-3.5 font-medium text-[#1C1917] whitespace-nowrap flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#B85331]"></span>
                                            <span>{{ $pt['name'] }}</span>
                                        </td>
                                        <td class="px-5 py-3.5 text-center font-mono text-[#292524]">{{ $pt['s'] }}</td>
                                        <td class="px-5 py-3.5 text-center font-mono text-[#292524] font-medium">{{ $pt['m'] }}</td>
                                        <td class="px-5 py-3.5 text-center font-mono text-[#292524]">{{ $pt['l'] }}</td>
                                        <td class="px-5 py-3.5 text-center font-mono text-[#292524]">{{ $pt['xl'] }}</td>
                                        <td class="px-5 py-3.5 text-center font-mono text-[#292524]">{{ $pt['xxl'] ?? '--' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Info Note -->
                    <div class="pt-4 border-t border-[#EADACE]/70 text-[11px] text-[#78716C]">
                        <p>
                            Measurement dimensions (in cm) are used as standard specification guides for patterns and manufacturing.
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <!-- ============================================== -->
    <!-- 3. NEW CHART MODAL                             -->
    <!-- ============================================== -->
    <div
        x-show="newChartModalOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-xs"
        style="display: none;"
    >
        <div
            @click.away="newChartModalOpen = false"
            class="bg-white border border-[#EADACE] shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6"
        >
            <div class="flex items-center justify-between pb-4 border-b border-[#EADACE]/70">
                <h2 class="text-lg font-normal text-[#1C1917]">Create Size Chart Profile</h2>
                <button @click="newChartModalOpen = false" class="text-[#786C62] hover:text-[#1C1917] text-lg font-mono">
                    ✕
                </button>
            </div>

            <form action="{{ route('admin.ukuran.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CHART PROFILE NAME
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        required
                        placeholder="e.g. Women's Blazer Standard"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <div>
                    <label for="category" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        GARMENT CATEGORY
                    </label>
                    <select
                        name="category"
                        id="category"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    >
                        <option value="Jacket">Jacket & Outerwear</option>
                        <option value="Hoodie">Hoodie & Sweater</option>
                        <option value="T-Shirt">T-Shirt & Tops</option>
                        <option value="Polo">Polo Shirt</option>
                        <option value="Jersey">Jersey & Sportswear</option>
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        DESCRIPTION
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="2"
                        placeholder="e.g. Standard pattern measurements for women's tailored blazer."
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    ></textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#EADACE]/70">
                    <button
                        type="button"
                        @click="newChartModalOpen = false"
                        class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium uppercase transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] text-white text-xs font-mono font-medium uppercase transition-all shadow-xs"
                    >
                        Save Chart
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
