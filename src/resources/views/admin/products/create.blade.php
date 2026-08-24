@extends('layouts.admin')

@section('title', 'Create New Product')

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
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Create New Product</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Tambah produk garmen baru ke dalam katalog database.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a
                href="{{ route('admin.produk.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="create-product-form"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs cursor-pointer"
            >
                Save Product
            </button>
        </div>
    </div>

    <!-- MAIN FORM -->
    <form
        id="create-product-form"
        action="{{ route('admin.produk.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-8"
    >
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- LEFT COLUMN (2/3): INFORMASI UTAMA & BAHAN -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- CARD 1: Product Information -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-5">
                    <div>
                        <h2 class="text-base font-medium text-[#1C1917]">Product Information</h2>
                        <p class="text-xs text-[#78716C] mt-0.5">Nama produk, kategori, dan harga.</p>
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
                                required
                                value="{{ old('nama_produk') }}"
                                placeholder="mis. Varsity HIMAMO, Kaos Polos"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none transition-colors"
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
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id_kategori }}" {{ old('kategori_id') == $cat->id_kategori ? 'selected' : '' }}>
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
                                    required
                                    min="0"
                                    step="1000"
                                    value="{{ old('harga') }}"
                                    placeholder="350000"
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

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                        @foreach ($availableMaterials as $mat)
                            <label class="flex items-center gap-2 p-3 border border-[#EADACE] hover:bg-[#FAF7F2] cursor-pointer transition-colors">
                                <input
                                    type="checkbox"
                                    name="bahan_ids[]"
                                    value="{{ $mat->id_bahan }}"
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
                    <div>
                        <input
                            type="file"
                            name="gambar"
                            accept="image/png, image/jpeg, image/webp"
                            class="w-full text-xs text-[#574E46] file:mr-4 file:py-2 file:px-4 file:border file:border-[#D9CCC1] file:bg-[#FAF7F2] file:text-xs file:font-mono file:text-[#292524] hover:file:bg-[#EFE7DE] file:cursor-pointer"
                        />
                        <p class="text-[10px] text-[#78716C] mt-2">Format JPEG, PNG, atau WebP (maks. 4MB).</p>
                    </div>
                </div>

                <!-- CARD 2: Model 3D -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-medium text-[#1C1917]">File Model 3D</h2>
                        <span class="px-2 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-[#EFE7DE] text-[#786C62]">
                            OPSIONAL
                        </span>
                    </div>
                    <div>
                        <input
                            type="file"
                            name="file_model_3d"
                            accept=".glb,.gltf"
                            class="w-full text-xs text-[#574E46] file:mr-4 file:py-2 file:px-4 file:border file:border-[#D9CCC1] file:bg-[#FAF7F2] file:text-xs file:font-mono file:text-[#292524] hover:file:bg-[#EFE7DE] file:cursor-pointer"
                        />
                        <p class="text-[10px] text-[#78716C] mt-2">File aset 3D (.glb / .gltf) untuk fitur virtual fitting.</p>
                    </div>
                </div>

            </div>

        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]/70 mt-8">
            <a
                href="{{ route('admin.produk.index') }}"
                class="px-6 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase shadow-xs cursor-pointer"
            >
                Save Product
            </button>
        </div>

    </form>

</div>
@endsection
