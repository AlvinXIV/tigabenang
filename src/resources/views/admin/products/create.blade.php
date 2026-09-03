@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

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
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">Tambah Produk Baru</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Daftarkan busana garmen custom baru ke dalam katalog Tigabenang.
            </p>
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
                form="create-product-form"
                class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium"
            >
                Simpan Produk
            </button>
        </div>
    </div>

    <!-- MAIN FORM -->
    <form
        id="create-product-form"
        action="{{ route('admin.produk.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- LEFT COLUMN (2/3): INFORMASI UTAMA & BAHAN -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- CARD 1: Informasi Produk -->
                <div class="admin-card p-5 sm:p-6 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Informasi Produk</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Nama produk, kategori, dan penetapan harga dasar.</p>
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
                                required
                                value="{{ old('nama_produk') }}"
                                placeholder="Contoh: Varsity Jacket Polman, Kemeja Workwear Oxford"
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
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id_kategori }}" {{ old('kategori_id') == $cat->id_kategori ? 'selected' : '' }}>
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
                                        required
                                        min="0"
                                        step="1000"
                                        value="{{ old('harga') }}"
                                        placeholder="350000"
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

                <!-- CARD 2: Pilihan Bahan Kain -->
                <div class="admin-card p-5 sm:p-6 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Pilihan Material Kain Kompatibel</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Pilih bahan kain yang dapat dipesan untuk model busana ini.</p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-1">
                        @foreach ($availableMaterials as $mat)
                            <label class="flex items-center gap-2.5 p-2.5 border border-[#E2E5E9] rounded-lg hover:bg-[#F7F7F5] cursor-pointer transition-colors bg-white">
                                <input
                                    type="checkbox"
                                    name="bahan_ids[]"
                                    value="{{ $mat->id_bahan }}"
                                    class="rounded text-[#B8664A] focus:ring-[#B8664A]"
                                    {{ is_array(old('bahan_ids')) && in_array($mat->id_bahan, old('bahan_ids')) ? 'checked' : '' }}
                                />
                                <span class="text-xs text-[#1C2430] font-medium">{{ $mat->nama_bahan }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (1/3): MEDIA & 3D -->
            <div class="space-y-6">
                
                <!-- CARD 3: Gambar Thumbnail -->
                <div class="admin-card p-5 sm:p-6 space-y-3">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Foto Sampul Produk</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Format JPG/PNG/WEBP, maksimal 2MB.</p>
                    </div>

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

                <!-- CARD 4: File Model 3D -->
                <div class="admin-card p-5 sm:p-6 space-y-3">
                    <div class="flex items-center justify-between border-b border-[#E2E5E9] pb-3">
                        <div>
                            <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Model 3D Fitting</h2>
                            <p class="text-xs text-[#667085] mt-0.5">Format .glb / .gltf, maksimal 20MB.</p>
                        </div>
                        <span class="px-2 py-0.5 text-[11px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full">
                            Interaktif
                        </span>
                    </div>

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

