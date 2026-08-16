@extends('layouts.admin')

@section('title', 'Product Detail - ' . $product['name'])

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.produk.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-medium inline-flex items-center gap-1.5 mb-2 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Products</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">{{ $product['name'] }}</h1>
                <span class="px-2.5 py-0.5 text-[10px] font-mono tracking-wider uppercase bg-[#EFE7DE] text-[#786C62]">
                    {{ $product['category_name'] }}
                </span>
            </div>
            <p class="text-xs font-mono text-[#78716C] mt-1 tracking-wide">
                <span>SKU: {{ $product['sku'] }}</span>
                <span class="mx-2 text-[#D9CCC1]">•</span>
                <span>Category: {{ $product['category_name'] }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.produk.index') }}"
                class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="product-edit-form"
                class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs cursor-pointer"
            >
                Save Changes
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. EDIT FORM & RELATIONSHIPS                   -->
    <!-- ============================================== -->
    <form id="product-edit-form" action="{{ route('admin.produk.update', $product['id']) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: Product Information -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <h2 class="text-base font-medium text-[#1C1917] pb-3 border-b border-[#EADACE]/70">
                Product Information
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        PRODUCT NAME
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ $product['name'] }}"
                        required
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CATEGORY
                    </label>
                    <select
                        id="category_id"
                        name="category_id"
                        required
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    >
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}" {{ $product['category_id'] == $cat['id'] ? 'selected' : '' }}>
                                {{ $cat['name'] }}
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
                        id="description"
                        name="description"
                        rows="3"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                    >{{ $product['description'] }}</textarea>
                </div>

                <!-- Product Image -->
                <div class="sm:col-span-2 pt-2">
                    <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-2">
                        PRODUCT IMAGE
                    </label>
                    <div class="flex items-center gap-4">
                        <img
                            src="{{ $product['image'] }}"
                            alt="{{ $product['name'] }}"
                            class="w-24 h-24 object-cover border border-[#EADACE] rounded-none shadow-xs"
                        />
                        <div>
                            <button
                                type="button"
                                onclick="alert('Pilih gambar produk baru untuk diunggah.');"
                                class="px-3.5 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors cursor-pointer"
                            >
                                Change Image
                            </button>
                            <p class="text-[11px] text-[#78716C] mt-1.5">Supported formats: JPG, PNG, WEBP (Max 2MB)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Pricing (Base Price Only) -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <h2 class="text-base font-medium text-[#1C1917] pb-3 border-b border-[#EADACE]/70">
                Pricing
            </h2>

            <div class="max-w-md">
                <label for="price" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                    BASE PRICE
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-mono font-medium text-[#786C62] pointer-events-none">
                        Rp
                    </span>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="{{ $product['price'] }}"
                        required
                        class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>
                <p class="text-[11px] text-[#78716C] mt-1.5">
                    Base manufacturing reference price. Final order price is negotiated per custom order.
                </p>
            </div>
        </div>

        <!-- SECTION 3: Materials (Associated Materials) -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <h2 class="text-base font-medium text-[#1C1917] pb-3 border-b border-[#EADACE]/70">
                Materials
            </h2>

            <div class="space-y-3">
                @foreach ($product['materials'] as $material)
                    <label class="p-4 border border-[#EADACE] bg-[#FAF7F2]/30 flex items-start justify-between cursor-pointer hover:bg-[#FAF7F2] transition-colors">
                        <div class="flex items-start gap-3">
                            <input
                                type="radio"
                                name="primary_material"
                                value="{{ $material['id'] }}"
                                {{ $material['selected'] ? 'checked' : '' }}
                                class="mt-1 text-[#B85331] focus:ring-[#B85331]"
                            />
                            <div>
                                <span class="text-xs sm:text-sm font-medium text-[#1C1917] block">{{ $material['name'] }}</span>
                                <span class="text-xs text-[#78716C] mt-0.5 block">{{ $material['description'] }}</span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- SECTION 4: Size Chart -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-[#EADACE]/70">
                <div>
                    <h2 class="text-base font-medium text-[#1C1917]">Size Chart</h2>
                    <p class="text-xs text-[#78716C] mt-0.5">Linked profile: <span class="font-medium text-[#1C1917]">{{ $product['size_chart_name'] }}</span></p>
                </div>
                <a href="{{ route('admin.ukuran.index') }}" class="text-xs text-[#B85331] hover:underline font-medium">
                    Manage Size Charts &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/50 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                            <th class="px-4 py-3">SIZE</th>
                            <th class="px-4 py-3">CHEST (cm)</th>
                            <th class="px-4 py-3">LENGTH (cm)</th>
                            <th class="px-4 py-3">SHOULDER (cm)</th>
                            <th class="px-4 py-3">SLEEVE (cm)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EADACE]/60">
                        @foreach ($product['sizes'] as $size)
                            <tr class="hover:bg-[#FAF7F2]/40 transition-colors">
                                <td class="px-4 py-3 font-mono font-bold text-[#1C1917]">
                                    {{ $size['size'] }}
                                </td>
                                <td class="px-4 py-3 font-mono text-[#292524]">
                                    <input
                                        type="number"
                                        value="{{ $size['chest'] }}"
                                        class="w-16 px-2 py-1 bg-white border border-[#D9CCC1] text-xs font-mono text-center focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                                <td class="px-4 py-3 font-mono text-[#292524]">
                                    <input
                                        type="number"
                                        value="{{ $size['length'] }}"
                                        class="w-16 px-2 py-1 bg-white border border-[#D9CCC1] text-xs font-mono text-center focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                                <td class="px-4 py-3 font-mono text-[#292524]">
                                    <input
                                        type="number"
                                        value="{{ $size['shoulder'] }}"
                                        class="w-16 px-2 py-1 bg-white border border-[#D9CCC1] text-xs font-mono text-center focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                                <td class="px-4 py-3 font-mono text-[#292524]">
                                    <input
                                        type="number"
                                        value="{{ $size['sleeve'] }}"
                                        class="w-16 px-2 py-1 bg-white border border-[#D9CCC1] text-xs font-mono text-center focus:outline-none focus:border-[#B85331]"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECTION 5: 3D Model -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#EADACE]/70">
                <h2 class="text-base font-medium text-[#1C1917]">3D Model</h2>
                <span class="px-2 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-[#EFE7DE] text-[#786C62]">
                    3D Active
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <div class="md:col-span-2 h-56 bg-[#FAF7F2] border border-[#EADACE] flex items-center justify-center overflow-hidden relative group">
                    <img
                        src="{{ $product['model_3d']['preview_image'] }}"
                        alt="3D Preview"
                        class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-300"
                    />
                    <div class="absolute inset-0 bg-stone-900/10 flex items-center justify-center">
                        <span class="px-3 py-1.5 bg-white/90 backdrop-blur-xs text-xs font-mono text-[#292524] border border-[#EADACE]">
                            Interactive 3D Preview Available
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <span class="text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                            CURRENT FILE
                        </span>
                        <div class="mt-1 p-3 bg-[#FAF7F2] border border-[#EADACE] flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#B85331] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="text-xs font-mono text-[#292524] truncate">{{ $product['model_3d']['file_name'] }}</span>
                        </div>
                    </div>

                    <div class="pt-2 space-y-2">
                        <button
                            type="button"
                            onclick="alert('Pilih file 3D .GLB baru untuk produk ini.');"
                            class="w-full py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors cursor-pointer"
                        >
                            Replace Model
                        </button>
                        <button
                            type="button"
                            onclick="if(confirm('Hapus relasi model 3D dari produk ini?')) alert('Model 3D dilepas.');"
                            class="w-full text-center text-xs text-rose-600 hover:text-rose-700 py-1 transition-colors cursor-pointer"
                        >
                            Remove Model
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- BOTTOM ACTION BUTTONS                          -->
        <!-- ============================================== -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#EADACE]/70">
            <a
                href="{{ route('admin.produk.index') }}"
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
