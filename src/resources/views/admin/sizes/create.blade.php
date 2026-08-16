@extends('layouts.admin')

@section('title', 'Create New Size Chart')

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
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Create New Size Chart</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Create a size chart for product measurements.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.ukuran.index') }}"
                class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="create-size-chart-form"
                class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs cursor-pointer"
            >
                Create Size Chart
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. MAIN CREATE FORM                            -->
    <!-- ============================================== -->
    <form id="create-size-chart-form" action="{{ route('admin.ukuran.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- SECTION 1: Chart Information -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div>
                <h2 class="text-base font-medium text-[#1C1917]">Chart Information</h2>
                <p class="text-xs text-[#78716C] mt-0.5">This profile will standardize measurements across products.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <!-- Chart Name -->
                <div>
                    <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CHART NAME
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        required
                        placeholder="e.g. Men's Slim Fit T-Shirt Baseline"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CATEGORY
                    </label>
                    <select
                        name="category"
                        id="category"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    >
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
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
                        placeholder="e.g. Standard pattern measurements for t-shirt baseline. Values in cm."
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                    ></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Size Measurements Table -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div>
                <h2 class="text-base font-medium text-[#1C1917]">Size Measurements (cm)</h2>
                <p class="text-xs text-[#78716C] mt-0.5">Enter measurement dimensions in cm for each supported size.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                            <th class="px-5 py-3.5">MEASUREMENT POINT</th>
                            @foreach ($defaultSizes as $sz)
                                <th class="px-5 py-3.5 text-center font-mono font-bold">{{ $sz }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EADACE]/60">
                        @foreach ($defaultPoints as $point)
                            <tr class="hover:bg-[#FAF7F2]/40 transition-colors">
                                <td class="px-5 py-3.5 font-medium text-[#1C1917] whitespace-nowrap flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#B85331]"></span>
                                    <span>{{ $point }}</span>
                                </td>
                                @foreach ($defaultSizes as $sz)
                                    <td class="px-5 py-3.5 text-center">
                                        <input
                                            type="text"
                                            name="measurements[{{ $point }}][{{ $sz }}]"
                                            placeholder="--"
                                            class="w-16 px-2 py-1.5 bg-white border border-[#D9CCC1] text-xs font-mono text-center text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                                        />
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-2 text-[11px] text-[#78716C]">
                <p>Values entered will be standardized across all products linked to this size profile.</p>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- BOTTOM ACTION BUTTONS                          -->
        <!-- ============================================== -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#EADACE]/70">
            <a
                href="{{ route('admin.ukuran.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs cursor-pointer"
            >
                Create Size Chart
            </button>
        </div>

    </form>

</div>
@endsection
