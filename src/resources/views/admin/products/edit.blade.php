@extends('layouts.admin')

@section('title', 'Edit Product - ' . $product->nama_produk)

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
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">{{ $product->nama_produk }}</h1>
                <span class="px-3 py-1 text-[10px] font-black uppercase bg-[#172A39] text-[#FAF8F5] rounded-full shadow-xs">
                    {{ $product->kategori ? $product->kategori->nama_kategori : 'Tanpa Kategori' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.produk.index') }}"
                class="btn-cream-pill px-5 py-2.5 text-xs uppercase tracking-wide cursor-pointer"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="product-edit-form"
                class="btn-navy-pill px-7 py-2.5 text-xs uppercase tracking-wide cursor-pointer border-0 shadow-md"
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
                <div class="admin-card-rich p-6 sm:p-8 space-y-5">
                    <div>
                        <h2 class="text-base font-black text-[#172A39]">Product Information</h2>
                        <p class="text-xs text-[#6E7575] mt-0.5">Nama produk, kategori, dan harga base satuan.</p>
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
                                value="{{ old('nama_produk', $product->nama_produk) }}"
                                required
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
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id_kategori }}" {{ old('kategori_id', $product->kategori_id) == $cat->id_kategori ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="harga" class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                                HARGA (RP) <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative max-w-md">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-black text-[#6E7575] pointer-events-none">
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
                                    class="w-full pl-10 pr-3.5 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-black text-[#172A39] rounded-xl focus:outline-none transition-colors"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Materials Selection -->
                <div class="admin-card-rich p-6 sm:p-8 space-y-4">
                    <div>
                        <h2 class="text-base font-black text-[#172A39]">Pilihan Bahan / Material Kain</h2>
                        <p class="text-xs text-[#6E7575] mt-0.5">Pilih material kain yang tersedia untuk produk ini.</p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                        @foreach ($availableMaterials as $mat)
                            <label class="flex items-center gap-2.5 p-3.5 border border-[#DCD6D0] rounded-xl hover:bg-[#FAF8F5] cursor-pointer transition-colors bg-white">
                                <input
                                    type="checkbox"
                                    name="bahan_ids[]"
                                    value="{{ $mat->id_bahan }}"
                                    {{ in_array($mat->id_bahan, $selectedMaterialIds) ? 'checked' : '' }}
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
                        <p class="text-xs text-[#6E7575] mt-0.5">Ganti atau perbarui foto produk katalog.</p>
                    </div>

                    @if ($product->gambar)
                        <div class="space-y-2">
                            <img
                                src="{{ asset('storage/' . $product->gambar) }}"
                                alt="{{ $product->nama_produk }}"
                                class="w-full h-44 object-cover rounded-xl border border-[#DCD6D0]"
                            />
                            <p class="text-[10px] text-[#6E7575] text-center font-bold">Foto saat ini</p>
                        </div>
                    @endif

                    <div class="space-y-3 pt-2">
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
                            <h2 class="text-base font-black text-[#172A39]">3D Model Asset</h2>
                            <p class="text-xs text-[#6E7575] mt-0.5">File model 3D pakaian (.glb / .gltf).</p>
                        </div>
                        @if ($product->file_model_3d)
                            <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full">
                                Attached
                            </span>
                        @endif
                    </div>

                    @if ($product->file_model_3d)
                        <div class="p-3 bg-[#FAF8F5] border border-[#DCD6D0] rounded-xl flex items-center justify-between">
                            <div class="truncate text-xs font-mono text-[#172A39] font-bold">
                                📁 {{ basename($product->file_model_3d) }}
                            </div>
                            <a
                                href="{{ route('admin.model-3d.preview', $product->id_produk) }}"
                                class="text-xs font-black text-[#172A39] hover:underline shrink-0 ml-2"
                            >
                                Preview &rarr;
                            </a>
                        </div>
                    @endif

                    <div class="space-y-3 pt-2">
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
