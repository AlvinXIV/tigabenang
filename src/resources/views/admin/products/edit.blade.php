@extends('layouts.admin')

@section('title', 'Edit Product - ' . $product->nama_produk)

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.produk.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-mono font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Products</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">{{ $product->nama_produk }}</h1>
                <span class="px-2.5 py-0.5 text-[10px] font-mono tracking-wider uppercase bg-[#EFE7DE] text-[#786C62]">
                    {{ $product->kategori ? $product->kategori->nama_kategori : 'Tanpa Kategori' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.produk.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="product-edit-form"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs cursor-pointer"
            >
                Save Changes
            </button>
        </div>
    </div>

    <!-- EDIT FORM -->
    <form id="product-edit-form" action="{{ route('admin.produk.update', $product->id_produk) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- LEFT COLUMN (2/3): INFORMASI UTAMA & BAHAN -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- CARD 1: Product Information -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-5">
                    <div>
                        <h2 class="text-base font-medium text-[#1C1917]">Product Information</h2>
                        <p class="text-xs text-[#78716C] mt-0.5">Nama produk, kategori, dan harga base.</p>
                    </div>

                    <div class="space-y-4 pt-1">
                        <!-- Product Name -->
                        <div>
                            <label for="nama_produk" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                NAMA PRODUK <span class="text-[#B85331]">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_produk"
                                name="nama_produk"
                                value="{{ old('nama_produk', $product->nama_produk) }}"
                                required
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="kategori_id" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                KATEGORI <span class="text-[#B85331]">*</span>
                            </label>
                            <select
                                id="kategori_id"
                                name="kategori_id"
                                required
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            >
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id_kategori }}" {{ old('kategori_id', $product->kategori_id) == $cat->id_kategori ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="harga" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                HARGA (RP) <span class="text-[#B85331]">*</span>
                            </label>
                            <div class="relative max-w-md">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-mono text-[#786C62] pointer-events-none">
                                    Rp
                                </span>
                                <input
                                    type="number"
                                    id="harga"
                                    name="harga"
                                    value="{{ old('harga', $product->harga) }}"
                                    required
                                    min="0"
                                    step="1000"
                                    class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Materials -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <div>
                        <h2 class="text-base font-medium text-[#1C1917]">Pilihan Bahan</h2>
                        <p class="text-xs text-[#78716C] mt-0.5">Pilih bahan kain yang dapat digunakan untuk produk ini.</p>
                    </div>

                    @php
                        $selectedBahanIds = $product->bahan->pluck('id_bahan')->toArray();
                    @endphp

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                        @foreach ($availableMaterials as $mat)
                            <label class="flex items-center gap-2 p-3 border border-[#EADACE] hover:bg-[#FAF7F2] cursor-pointer transition-colors">
                                <input
                                    type="checkbox"
                                    name="bahan_ids[]"
                                    value="{{ $mat->id_bahan }}"
                                    {{ in_array($mat->id_bahan, $selectedBahanIds) ? 'checked' : '' }}
                                    class="rounded-none border-[#D9CCC1] text-[#B85331] focus:ring-[#B85331]"
                                />
                                <span class="text-xs text-[#292524] font-medium">{{ $mat->nama_bahan }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (1/3): MEDIA & 3D -->
            <div class="space-y-8">
                
                <!-- CARD 1: Gambar Produk -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <h2 class="text-base font-medium text-[#1C1917]">Gambar Produk</h2>
                    @if ($product->gambar)
                        <div class="w-full h-40 overflow-hidden border border-[#EADACE] bg-[#FAF7F2]">
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover" />
                        </div>
                    @endif
                    <div>
                        <input
                            type="file"
                            name="gambar"
                            accept="image/png, image/jpeg, image/webp"
                            class="w-full text-xs text-[#574E46] file:mr-4 file:py-2 file:px-4 file:border file:border-[#D9CCC1] file:bg-[#FAF7F2] file:text-xs file:font-mono file:text-[#292524] hover:file:bg-[#EFE7DE] file:cursor-pointer"
                        />
                        <p class="text-[10px] text-[#78716C] mt-2">Pilih gambar baru untuk mengganti.</p>
                    </div>
                </div>

                <!-- CARD 2: Model 3D -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-medium text-[#1C1917]">Model 3D</h2>
                        @if ($product->file_model_3d)
                            <span class="px-2 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                                3D ACTIVE
                            </span>
                        @else
                            <span class="px-2 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-[#EFE7DE] text-[#786C62]">
                                NONE
                            </span>
                        @endif
                    </div>
                    @if ($product->file_model_3d)
                        <div class="p-3 bg-[#FAF7F2] border border-[#EADACE] font-mono text-xs text-[#292524] truncate">
                            File: {{ $product->file_model_3d }}
                        </div>
                    @endif
                    <div>
                        <input
                            type="file"
                            name="file_model_3d"
                            accept=".glb,.gltf"
                            class="w-full text-xs text-[#574E46] file:mr-4 file:py-2 file:px-4 file:border file:border-[#D9CCC1] file:bg-[#FAF7F2] file:text-xs file:font-mono file:text-[#292524] hover:file:bg-[#EFE7DE] file:cursor-pointer"
                        />
                        <p class="text-[10px] text-[#78716C] mt-2">Upload file 3D (.glb/.gltf) baru untuk memperbarui.</p>
                    </div>
                </div>

            </div>

        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]/70 mt-8">
            <a
                href="{{ route('admin.produk.index') }}"
                class="px-6 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase shadow-xs cursor-pointer"
            >
                Save Changes
            </button>
        </div>

    </form>

</div>
@endsection
