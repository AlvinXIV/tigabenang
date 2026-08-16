@extends('layouts.admin')

@section('title', 'Material Inventory')

@section('content')
<div class="space-y-8" x-data="{ searchQuery: '', registerModalOpen: false }">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & SEARCH / ACTION TOOLBAR        -->
    <!-- ============================================== -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Material Inventory</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Manage and review available materials.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Search Input -->
            <div class="relative w-full sm:w-72">
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Search materials, SKU..."
                    class="w-full pl-9 pr-3.5 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] transition-colors"
                />
                <svg class="w-4 h-4 text-[#A89A8E] absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Register Material Button -->
            <button
                type="button"
                @click="registerModalOpen = true"
                class="px-4 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-1.5 cursor-pointer"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>REGISTER MATERIAL</span>
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. PRIMARY SUMMARY CARDS (TOTAL & LOW STOCK)   -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: TOTAL MATERIALS -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                TOTAL MATERIALS
            </span>
            <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight mt-3">{{ $summary['total_materials'] }}</h3>
        </div>

        <!-- Card 2: LOW STOCK -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                LOW STOCK
            </span>
            <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight mt-3">{{ $summary['low_stock_count'] }}</h3>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. MATERIAL INVENTORY TABLE (LIST VIEW)        -->
    <!-- ============================================== -->
    <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/50 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        <th class="px-6 py-3.5">MATERIAL</th>
                        <th class="px-6 py-3.5">TYPE / WEAVE</th>
                        <th class="px-6 py-3.5">USED IN</th>
                        <th class="px-6 py-3.5">STOCK LEVEL</th>
                        <th class="px-6 py-3.5">STATUS</th>
                        <th class="px-6 py-3.5 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    @foreach ($materials as $mat)
                        <tr
                            class="hover:bg-[#FAF7F2]/60 transition-colors group"
                            x-show="'{{ strtolower($mat['name']) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($mat['sku']) }}'.includes(searchQuery.toLowerCase())"
                        >
                            <!-- Material Column (Thumbnail + Name + SKU) -->
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.kategori.edit', $mat['id']) }}" class="flex items-center gap-3.5 group">
                                    <img
                                        src="{{ $mat['image'] }}"
                                        alt="{{ $mat['name'] }}"
                                        class="w-10 h-10 object-cover rounded-none border border-[#EADACE] shrink-0 group-hover:opacity-90 transition-opacity"
                                    />
                                    <div>
                                        <span class="font-medium text-[#1C1917] text-xs sm:text-sm block group-hover:text-[#B85331] transition-colors leading-tight">
                                            {{ $mat['name'] }}
                                        </span>
                                        <span class="text-[10px] font-mono text-[#786C62] tracking-wider uppercase block mt-0.5">
                                            {{ $mat['sku'] }}
                                        </span>
                                    </div>
                                </a>
                            </td>

                            <!-- Type / Weave -->
                            <td class="px-6 py-4 text-xs text-[#574E46]">
                                <span>{{ $mat['type'] }}</span>
                            </td>

                            <!-- Used in Products -->
                            <td class="px-6 py-4 text-xs text-[#78716C]">
                                <span class="text-[#574E46]">{{ implode(' • ', $mat['used_in']) }}</span>
                            </td>

                            <!-- Current Stock -->
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-[#1C1917] font-medium">
                                {{ $mat['stock'] }} {{ $mat['unit'] }}
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (!empty($mat['is_low_stock']))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-amber-50 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        LOW STOCK
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        IN STOCK
                                    </span>
                                @endif
                            </td>

                            <!-- Action Column: Review, Edit Material and Delete -->
                            <td class="px-6 py-4 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                <div class="relative inline-block text-left">
                                    <button
                                        type="button"
                                        @click="menuOpen = !menuOpen"
                                        class="p-1.5 text-[#786C62] hover:text-[#1C1917] hover:bg-[#FAF7F2] transition-colors focus:outline-none cursor-pointer"
                                        title="Actions"
                                    >
                                        <!-- Vertical 3-dots -->
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="2"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <circle cx="12" cy="19" r="2"></circle>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div
                                        x-show="menuOpen"
                                        @click.away="menuOpen = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-1 w-40 bg-white border border-[#EADACE] shadow-lg py-1 z-30 text-left divide-y divide-[#EADACE]/50"
                                        style="display: none;"
                                    >
                                        <div class="py-0.5">
                                            <!-- Edit Material -->
                                            <a
                                                href="{{ route('admin.kategori.edit', $mat['id']) }}"
                                                class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                            >
                                                <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span>Edit Material</span>
                                            </a>
                                        </div>

                                        <div class="py-0.5">
                                            <!-- Delete -->
                                            <form
                                                action="{{ route('admin.kategori.destroy', $mat['id']) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus data material {{ $mat['name'] }}?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="w-full flex items-center gap-2 px-3.5 py-2 text-xs text-rose-700 hover:bg-rose-50 transition-colors font-medium cursor-pointer"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 4. MODAL: REGISTER MATERIAL                    -->
    <!-- ============================================== -->
    <div
        x-show="registerModalOpen"
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
            @click.away="registerModalOpen = false"
            class="bg-white border border-[#EADACE] shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6"
        >
            <div class="flex items-center justify-between pb-4 border-b border-[#EADACE]/70">
                <h2 class="text-lg font-normal text-[#1C1917]">Register New Material</h2>
                <button @click="registerModalOpen = false" class="text-[#786C62] hover:text-[#1C1917] text-lg font-mono">
                    ✕
                </button>
            </div>

            <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        MATERIAL NAME <span class="text-[#B85331]">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        required
                        placeholder="e.g. Cotton Combed 24s"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="type" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            MATERIAL TYPE
                        </label>
                        <input
                            type="text"
                            name="type"
                            id="type"
                            placeholder="e.g. Knit / Single Jersey"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="unit" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            UNIT
                        </label>
                        <select
                            name="unit"
                            id="unit"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        >
                            <option value="meter">Meter (m)</option>
                            <option value="yard">Yard (yd)</option>
                            <option value="kg">Kilogram (kg)</option>
                            <option value="roll">Roll</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stock" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            INITIAL STOCK <span class="text-[#B85331]">*</span>
                        </label>
                        <input
                            type="number"
                            name="stock"
                            id="stock"
                            required
                            placeholder="100"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="min_stock" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            MINIMUM THRESHOLD
                        </label>
                        <input
                            type="number"
                            name="min_stock"
                            id="min_stock"
                            placeholder="20"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        DESCRIPTION
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="2"
                        placeholder="Material specs and details..."
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                    ></textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#EADACE]/70">
                    <button
                        type="button"
                        @click="registerModalOpen = false"
                        class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium uppercase transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] text-white text-xs font-mono font-medium uppercase transition-all shadow-xs cursor-pointer"
                    >
                        Register Material
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
