@extends('layouts.admin')

@section('title', 'Create New Product')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <a href="{{ route('admin.produk.index') }}" class="text-xs text-[#172A39] hover:underline font-black inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider text-decoration-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>&larr; Kembali ke Katalog Produk</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Create New Product</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Tambah produk garmen custom baru ke dalam katalog Clothiq Atelier.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a
                href="{{ route('admin.produk.index') }}"
                class="btn-cream-pill px-5 py-2.5 text-xs uppercase tracking-wide cursor-pointer"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="create-product-form"
                class="btn-navy-pill px-7 py-2.5 text-xs uppercase tracking-wide cursor-pointer border-0 shadow-md"
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
                <div class="admin-card-rich p-6 sm:p-8 space-y-5">
                    <div>
                        <h2 class="text-base font-black text-[#172A39]">Product Information</h2>
                        <p class="text-xs text-[#6E7575] mt-0.5">Nama produk, kategori, dan penetapan harga dasar.</p>
                    </div>

                    <div class="space-y-4 pt-1">
                        <!-- Product Name -->
                        <div>
                            <label for="nama_produk" class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                                NAMA PRODUK <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_produk"
                                name="nama_produk"
                                required
                                value="{{ old('nama_produk') }}"
                                placeholder="mis. Varsity HIMAMO, Work Jacket Polman"
                                class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-bold text-[#172A39] rounded-xl focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="kategori_id" class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                                KATEGORI <span class="text-rose-600">*</span>
                            </label>
                            <select
                                id="kategori_id"
                                name="kategori_id"
                                required
                                class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-bold text-[#172A39] rounded-xl focus:outline-none transition-colors"
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
                            <label for="harga" class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                                HARGA SATUAN DASAR (RP) <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative max-w-md">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-black text-[#6E7575] pointer-events-none">
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
                                    class="w-full pl-10 pr-3.5 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-black text-[#172A39] rounded-xl focus:outline-none transition-colors"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Materials -->
                <div class="admin-card-rich p-6 sm:p-8 space-y-4">
                    <div>
                        <h2 class="text-base font-black text-[#172A39]">Pilihan Bahan / Material Kain</h2>
                        <p class="text-xs text-[#6E7575] mt-0.5">Pilih bahan kain yang kompatibel &amp; dapat digunakan untuk produk ini.</p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                        @foreach ($availableMaterials as $mat)
                            <label class="flex items-center gap-2.5 p-3.5 border border-[#DCD6D0] rounded-xl hover:bg-[#FAF8F5] cursor-pointer transition-colors bg-white">
                                <input
                                    type="checkbox"
                                    name="bahan_ids[]"
                                    value="{{ $mat->id_bahan }}"
                                    class="w-4 h-4 accent-[#172A39]"
                                />
                                <span class="text-xs text-[#172A39] font-bold">{{ $mat->nama_bahan }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (1/3): MEDIA & 3D -->
            <div class="space-y-8">
                
                <!-- CARD 3: Product Image -->
                <div class="admin-card-rich p-6 space-y-4">
                    <div>
                        <h2 class="text-base font-black text-[#172A39]">Product Image</h2>
                        <p class="text-xs text-[#6E7575] mt-0.5">Thumbnail katalog (JPG/PNG, max 2MB).</p>
                    </div>

                    <div class="space-y-3">
                        <input
                            type="file"
                            id="gambar"
                            name="gambar"
                            accept="image/jpeg,image/png,image/webp"
                            class="w-full text-xs text-[#555E68] file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-[#172A39] file:text-white hover:file:bg-[#0E1B25] cursor-pointer"
                        />
                    </div>
                </div>

                <!-- CARD 4: 3D Model Attachment -->
                <div class="admin-card-rich p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-black text-[#172A39]">3D Fitting Model</h2>
                            <p class="text-xs text-[#6E7575] mt-0.5">File model 3D pakaian (.glb / .gltf, max 50MB).</p>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full">
                            Interactive
                        </span>
                    </div>

                    <div class="space-y-3">
                        <input
                            type="file"
                            id="file_model_3d"
                            name="file_model_3d"
                            accept=".glb,.gltf"
                            class="w-full text-xs text-[#555E68] file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-[#172A39] file:text-white hover:file:bg-[#0E1B25] cursor-pointer"
                        />
                    </div>
                </div>

            </div>

        </div>

    </form>

</div>
@endsection
