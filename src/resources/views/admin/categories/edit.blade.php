@extends('layouts.admin')

@section('title', 'Material Detail - ' . $material['name'])

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.kategori.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase font-mono tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Materials</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">{{ $material['name'] }}</h1>
                @if ($material['is_low_stock'])
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-white text-[#B85331] border border-[#F7DDD2]">
                        ● LOW STOCK
                    </span>
                @else
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                        ● IN STOCK
                    </span>
                @endif
            </div>
            <p class="text-xs font-mono text-[#78716C] mt-1 tracking-wide">
                <span>{{ $material['sku'] }}</span>
                <span class="mx-2 text-[#D9CCC1]">•</span>
                <span>{{ $material['category'] }}</span>
                <span class="mx-2 text-[#D9CCC1]">•</span>
                <span>{{ $material['color'] }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.kategori.index') }}"
                class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="material-edit-form"
                class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs cursor-pointer"
            >
                Save Changes
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. MAIN EDIT FORM & RELATIONSHIPS              -->
    <!-- ============================================== -->
    <form id="material-edit-form" action="{{ route('admin.kategori.update', $material['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- ========================================== -->
            <!-- LEFT COLUMN (2/3): INFORMATION & INVENTORY -->
            <!-- ========================================== -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- CARD 1: Material Information -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
                    <div>
                        <h2 class="text-base font-medium text-[#1C1917]">Material Information</h2>
                        <p class="text-xs text-[#78716C] mt-0.5">Manage the specifications and identity of this material.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                        <!-- Material Name -->
                        <div>
                            <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                MATERIAL NAME
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ $material['name'] }}"
                                required
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- SKU -->
                        <div>
                            <label for="sku" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                SKU
                            </label>
                            <input
                                type="text"
                                id="sku"
                                name="sku"
                                value="{{ $material['sku'] }}"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                CATEGORY
                            </label>
                            <select
                                id="category"
                                name="category"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            >
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" {{ $material['category'] === $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Color / Variant -->
                        <div>
                            <label for="color" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                COLOR / VARIANT
                            </label>
                            <input
                                type="text"
                                id="color"
                                name="color"
                                value="{{ $material['color'] }}"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- Composition -->
                        <div>
                            <label for="composition" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                COMPOSITION
                            </label>
                            <input
                                type="text"
                                id="composition"
                                name="composition"
                                value="{{ $material['composition'] }}"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- Weight -->
                        <div>
                            <label for="weight" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                WEIGHT
                            </label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="weight"
                                    name="weight"
                                    value="{{ $material['weight'] }}"
                                    class="w-full pr-12 pl-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors font-mono"
                                />
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-mono text-[#786C62] pointer-events-none">
                                    g/m²
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Inventory -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
                    <div>
                        <h2 class="text-base font-medium text-[#1C1917]">Inventory</h2>
                        <p class="text-xs text-[#78716C] mt-0.5">Monitor available material stock levels.</p>
                    </div>

                    <!-- Current Stock Banner -->
                    <div class="p-5 border border-[#EADACE] bg-[#FAF7F2]/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                                CURRENT STOCK
                            </span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono">{{ $material['stock'] }}</h3>
                                <span class="text-sm text-[#78716C] font-mono">{{ $material['unit'] }}</span>
                            </div>
                        </div>

                        <div class="w-full sm:w-48">
                            <label class="block text-[10px] font-mono tracking-widest text-[#786C62] uppercase mb-1">
                                UPDATE STOCK ({{ $material['unit'] }})
                            </label>
                            <input
                                type="text"
                                name="stock"
                                value="{{ $material['stock'] }}"
                                class="w-full px-3 py-2 bg-white border border-[#D9CCC1] text-xs font-mono text-[#292524] focus:outline-none focus:border-[#B85331]"
                            />
                        </div>
                    </div>

                    <div class="pt-2">
                        <span class="text-[11px] font-mono tracking-widest text-[#786C62] uppercase block mb-1">STATUS</span>
                        @if ($material['is_low_stock'])
                            <span class="text-xs font-medium text-[#B85331] inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B85331]"></span>
                                LOW STOCK — Stock is below standard threshold
                            </span>
                        @else
                            <span class="text-xs font-medium text-emerald-700 inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                IN STOCK — Sufficient fabric roll available
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- RIGHT COLUMN (1/3): PREVIEW & USED IN      -->
            <!-- ========================================== -->
            <div class="space-y-8">
                
                <!-- CARD 1: Material Preview -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <h2 class="text-base font-medium text-[#1C1917]">Material Preview</h2>

                    <div class="w-full h-52 bg-stone-100 border border-[#EADACE] overflow-hidden">
                        <img
                            src="{{ $material['image'] }}"
                            alt="{{ $material['name'] }}"
                            class="w-full h-full object-cover"
                        />
                    </div>

                    <button
                        type="button"
                        onclick="alert('Pilih foto tekstur material baru untuk diunggah.');"
                        class="w-full py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors cursor-pointer"
                    >
                        Change Image
                    </button>
                </div>

                <!-- CARD 2: Used in Products -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <h2 class="text-base font-medium text-[#1C1917]">Used in Products</h2>

                    <div class="space-y-3">
                        @foreach ($material['used_in_products'] as $prod)
                            <a
                                href="{{ $prod['route'] }}"
                                class="p-3 border border-[#EADACE] bg-[#FAF7F2]/30 hover:bg-[#FAF7F2] flex items-center gap-3 transition-colors group"
                            >
                                <img
                                    src="{{ $prod['thumbnail'] }}"
                                    alt="{{ $prod['name'] }}"
                                    class="w-10 h-10 object-cover border border-[#EADACE] shrink-0"
                                />
                                <div class="min-w-0">
                                    <span class="text-xs font-medium text-[#1C1917] group-hover:text-[#B85331] transition-colors block truncate">
                                        {{ $prod['name'] }}
                                    </span>
                                    <span class="text-[10px] font-mono text-[#786C62] uppercase block">
                                        {{ $prod['sku'] }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

        <!-- ============================================== -->
        <!-- BOTTOM ACTION BUTTONS                          -->
        <!-- ============================================== -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]/70 mt-8">
            <a
                href="{{ route('admin.kategori.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs cursor-pointer"
            >
                Save Changes
            </button>
        </div>

    </form>

</div>
@endsection
