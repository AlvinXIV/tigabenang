@extends('layouts.admin')

@section('title', 'Ubah Produk - ' . $product->nama_produk)

@section('content')
<div class="space-y-6">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <a href="{{ route('admin.produk.index') }}" class="text-xs text-[#667085] hover:text-[#B8664A] inline-flex items-center gap-1.5 mb-2 transition-colors text-decoration-none font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Katalog Produk</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">{{ $product->nama_produk }}</h1>
                <span class="px-2.5 py-0.5 text-xs font-medium bg-[#F7F7F5] border border-[#E2E5E9] text-[#1C2430] rounded-md">
                    {{ $product->kategori ? $product->kategori->nama_kategori : 'Tanpa Kategori' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            <a
                href="{{ route('admin.produk.index') }}"
                class="btn-secondary px-4 py-2 text-xs sm:text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                form="product-edit-form"
                class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium"
            >
                Simpan Perubahan
            </button>
        </div>
    </div>

    <!-- EDIT FORM -->
    <form
        id="product-edit-form"
        action="{{ route('admin.produk.update', $product->id_produk) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- LEFT COLUMN (2/3): INFORMASI UTAMA & BAHAN -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- CARD 1: Product Information -->
                <div class="admin-card p-5 sm:p-6 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Informasi Produk</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Nama produk, kategori, dan harga dasar satuan.</p>
                    </div>

                    <div class="space-y-4 pt-1">
                        <!-- Product Name -->
                        <div>
                            <label for="nama_produk" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_produk"
                                name="nama_produk"
                                value="{{ old('nama_produk', $product->nama_produk) }}"
                                required
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                            />
                            @error('nama_produk')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category & Price in Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="kategori_id" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                                    Kategori Produk <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    id="kategori_id"
                                    name="kategori_id"
                                    required
                                    class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                                >
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id_kategori }}" {{ old('kategori_id', $product->kategori_id) == $cat->id_kategori ? 'selected' : '' }}>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="harga" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                                    Harga Satuan Dasar (Rp) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-semibold text-[#667085] pointer-events-none">
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
                                        class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 font-semibold text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                                    />
                                </div>
                                @error('harga')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Materials Selection -->
                <div class="admin-card p-5 sm:p-6 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Pilihan Bahan / Material Kain Kompatibel</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Centang material kain yang dapat dipesan untuk produk ini.</p>
                    </div>

                    @php
                        $selectedMaterialIds = old('bahan_ids', $product->bahan ? $product->bahan->pluck('id_bahan')->toArray() : []);
                    @endphp
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-1">
                        @foreach ($availableMaterials as $mat)
                            <label class="flex items-center gap-2.5 p-2.5 border border-[#E2E5E9] rounded-lg hover:bg-[#F7F7F5] cursor-pointer transition-colors bg-white">
                                <input
                                    type="checkbox"
                                    name="bahan_ids[]"
                                    value="{{ $mat->id_bahan }}"
                                    {{ in_array($mat->id_bahan, $selectedMaterialIds) ? 'checked' : '' }}
                                    class="rounded text-[#B8664A] focus:ring-[#B8664A]"
                                />
                                <span class="text-xs text-[#1C2430] font-medium">{{ $mat->nama_bahan }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (1/3): MEDIA & 3D -->
            <div class="space-y-6">
                
                <!-- CARD 3: Product Image -->
                <div class="admin-card p-5 sm:p-6 space-y-3">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Foto Sampul Produk</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Ganti atau perbarui foto produk katalog (max 2MB).</p>
                    </div>

                    @if ($product->gambar)
                        <div class="space-y-1.5">
                            <img
                                src="{{ asset('storage/' . $product->gambar) }}"
                                alt="{{ $product->nama_produk }}"
                                class="w-full h-40 object-cover rounded-lg border border-[#E2E5E9]"
                            />
                            <p class="text-[11px] text-[#667085] text-center font-medium">Foto yang aktif saat ini</p>
                        </div>
                    @endif

                    <div class="pt-1">
                        <input
                            type="file"
                            id="gambar"
                            name="gambar"
                            accept="image/jpeg,image/png,image/webp"
                            class="w-full text-xs text-[#667085] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#1C2430] file:text-white hover:file:bg-[#2D3748] cursor-pointer"
                        />
                        @error('gambar')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- CARD 4: 3D Model Attachment -->
                <div class="admin-card p-5 sm:p-6 space-y-3">
                    <div class="flex items-center justify-between border-b border-[#E2E5E9] pb-3">
                        <div>
                            <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Aset Model 3D</h2>
                            <p class="text-xs text-[#667085] mt-0.5">Format .glb / .gltf, maksimal 20MB.</p>
                        </div>
                        @if ($product->file_model_3d)
                            <span class="px-2 py-0.5 text-[11px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full">
                                3D Aktif
                            </span>
                        @endif
                    </div>

                    @if ($product->file_model_3d)
                        <div class="p-3 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg flex items-center justify-between">
                            <div class="truncate text-xs font-mono text-[#1C2430] font-semibold">
                                📁 {{ basename($product->file_model_3d) }}
                            </div>
                            <a
                                href="{{ route('admin.model-3d.preview', $product->id_produk) }}"
                                class="text-xs font-medium text-[#B8664A] hover:underline shrink-0 ml-2"
                            >
                                Pratinjau 3D &rarr;
                            </a>
                        </div>
                    @endif

                    <div class="pt-1">
                        <input
                            type="file"
                            id="file_model_3d"
                            name="file_model_3d"
                            accept=".glb,.gltf"
                            class="w-full text-xs text-[#667085] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#B8664A] file:text-white hover:file:bg-[#9A4E3A] cursor-pointer"
                        />
                        @error('file_model_3d')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

        </div>

    </form>

</div>
@endsection

