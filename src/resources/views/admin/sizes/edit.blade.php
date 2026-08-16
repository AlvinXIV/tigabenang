@extends('layouts.admin')

@section('title', 'Edit Size Chart - ' . $chart['name'])

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.ukuran.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase font-mono tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Size Charts</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Edit Size Chart</h1>
                <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                    ● {{ $chart['status'] }}
                </span>
            </div>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Modify measurement profile and dimension specifications.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a
                href="{{ route('admin.ukuran.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-colors inline-block text-center min-w-[90px]"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="edit-size-chart-form"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer"
            >
                Save Changes
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. MAIN EDIT FORM                              -->
    <!-- ============================================== -->
    <form id="edit-size-chart-form" action="{{ route('admin.ukuran.update', $chart['id']) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: Chart Information -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div>
                <h2 class="text-base font-medium text-[#1C1917]">Chart Information</h2>
                <p class="text-xs text-[#78716C] mt-0.5">Manage the specifications and category identity of this size chart profile.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <!-- Chart Name -->
                <div>
                    <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CHART PROFILE NAME <span class="text-[#B85331]">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ $chart['name'] }}"
                        required
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CATEGORY <span class="text-[#B85331]">*</span>
                    </label>
                    <select
                        name="category"
                        id="category"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    >
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $chart['category'] === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                <div class="sm:col-span-2">
                    <label for="description" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        DESCRIPTION
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="2"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                    >{{ $chart['description'] }}</textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Size Measurements Table Matrix -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div>
                <h2 class="text-base font-medium text-[#1C1917]">Size Measurements (cm)</h2>
                <p class="text-xs text-[#78716C] mt-0.5">Update measurement dimensions in cm for each supported size.</p>
            </div>

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
                        @foreach ($chart['points'] as $index => $point)
                            <tr class="hover:bg-[#FAF7F2]/40 transition-colors">
                                <td class="px-5 py-3.5 font-medium text-[#1C1917] whitespace-nowrap flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#B85331]"></span>
                                    <span>{{ $point['name'] }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <input
                                        type="text"
                                        name="points[{{ $index }}][s]"
                                        value="{{ $point['s'] }}"
                                        class="w-16 px-2 py-1.5 bg-white border border-[#D9CCC1] text-xs font-mono text-center text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <input
                                        type="text"
                                        name="points[{{ $index }}][m]"
                                        value="{{ $point['m'] }}"
                                        class="w-16 px-2 py-1.5 bg-white border border-[#D9CCC1] text-xs font-mono text-center text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <input
                                        type="text"
                                        name="points[{{ $index }}][l]"
                                        value="{{ $point['l'] }}"
                                        class="w-16 px-2 py-1.5 bg-white border border-[#D9CCC1] text-xs font-mono text-center text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <input
                                        type="text"
                                        name="points[{{ $index }}][xl]"
                                        value="{{ $point['xl'] }}"
                                        class="w-16 px-2 py-1.5 bg-white border border-[#D9CCC1] text-xs font-mono text-center text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <input
                                        type="text"
                                        name="points[{{ $index }}][xxl]"
                                        value="{{ $point['xxl'] ?? '--' }}"
                                        class="w-16 px-2 py-1.5 bg-white border border-[#D9CCC1] text-xs font-mono text-center text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-2 text-[11px] text-[#78716C]">
                <p>Measurement dimensions (in cm) are used as standard specification guides for patterns and manufacturing.</p>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- BOTTOM ACTION BUTTONS                          -->
        <!-- ============================================== -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]/70 mt-8">
            <a
                href="{{ route('admin.ukuran.index') }}"
                class="px-6 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-colors inline-block text-center min-w-[100px]"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer inline-block text-center"
            >
                Save Changes
            </button>
        </div>

    </form>

</div>
@endsection
