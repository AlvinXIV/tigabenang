@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="space-y-6">

    <!-- TOP HEADER -->
    <div class="pb-5 border-b border-[#E2E5E9]">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#102A43] tracking-tight">
            Tambah Produk
        </h1>
        <p class="text-xs sm:text-sm text-[#667085] mt-1">
            Daftarkan produk pakaian atau busana kustom baru ke dalam katalog.
        </p>
    </div>

    <!-- MAIN FORM -->
    <form
        id="product-create-form"
        action="{{ route('admin.produk.store') }}"
        method="POST"
        enctype="multipart/form-data"
        novalidate
        class="space-y-6"
    >
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- LEFT COLUMN (2/3): INFORMASI UTAMA & BAHAN -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- CARD 1: Informasi Produk -->
                <div class="admin-card p-5 sm:p-6 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-[#102A43]">Informasi Produk</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Nama produk, kategori, dan penetapan harga dasar.</p>
                    </div>

                    <div class="space-y-4 pt-1">
                        <!-- Product Name -->
                        <div>
                            <label for="nama_produk" class="block text-xs font-semibold text-[#102A43] mb-1.5">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_produk"
                                name="nama_produk"
                                value="{{ old('nama_produk') }}"
                                placeholder="Contoh: Essential Polo Shirt, Varsity Jacket"
                                class="w-full px-3.5 py-2.5 bg-white border @error('nama_produk') border-rose-400 @else border-[#D0D5DD] @enderror focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 text-xs sm:text-sm text-[#102A43] rounded-lg focus:outline-none transition-colors"
                            />
                            @error('nama_produk')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category & Price in Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="kategori_id" class="block text-xs font-semibold text-[#102A43] mb-1.5">
                                    Kategori Produk <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    id="kategori_id"
                                    name="kategori_id"
                                    class="w-full px-3.5 py-2.5 bg-white border @error('kategori_id') border-rose-400 @else border-[#D0D5DD] @enderror focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 text-xs sm:text-sm text-[#102A43] rounded-lg focus:outline-none transition-colors"
                                >
                                    <option value="">Pilih Kategori...</option>
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
                                <label for="harga" class="block text-xs font-semibold text-[#102A43] mb-1.5">
                                    Harga Dasar Acuan <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center font-mono text-xs text-[#667085] pointer-events-none">Rp</span>
                                    <input
                                        type="number"
                                        id="harga"
                                        name="harga"
                                        value="{{ old('harga') }}"
                                        min="0"
                                        step="1"
                                        placeholder="175000"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-white border @error('harga') border-rose-400 @else border-[#D0D5DD] @enderror focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 font-mono text-xs sm:text-sm text-[#102A43] rounded-lg focus:outline-none transition-colors"
                                    />
                                </div>
                                @error('harga')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Material Kain yang Didukung -->
                <div class="admin-card p-5 sm:p-6 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm sm:text-base font-semibold text-[#102A43]">Material Kain yang Didukung</h2>
                            <p class="text-xs text-[#667085] mt-0.5">Pilih material kain yang dapat dipilih pemesan (bisa lebih dari satu).</p>
                        </div>
                        <a href="{{ route('admin.kategori.index', ['tab' => 'material']) }}" target="_blank" class="text-xs text-[#102A43] hover:text-[#193B5C] font-medium text-decoration-none">
                            Kelola Material &rarr;
                        </a>
                    </div>

                    <div class="pt-1">
                        @if ($availableMaterials->isEmpty())
                            <p class="text-xs text-[#667085] italic py-2">
                                Belum ada material kain terdaftar.
                            </p>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($availableMaterials as $material)
                                    <label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-[#E2E5E9] hover:bg-[#F7F7F5] cursor-pointer transition-colors">
                                        <input
                                            type="checkbox"
                                            name="bahan_ids[]"
                                            value="{{ $material->id_bahan }}"
                                            {{ in_array($material->id_bahan, old('bahan_ids', [])) ? 'checked' : '' }}
                                            class="w-4 h-4 rounded text-[#102A43] focus:ring-[#102A43] border-[#D0D5DD]"
                                        />
                                        <span class="text-xs text-[#102A43] font-medium select-none truncate">
                                            {{ $material->nama_bahan }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        @error('bahan_ids')
                            <p class="text-xs text-rose-600 mt-2 font-medium">{{ $message }}</p>
                        @enderror
                        @error('bahan_ids.*')
                            <p class="text-xs text-rose-600 mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (1/3): FOTO & MODEL 3D -->
            <div class="space-y-6">
                
                <!-- CARD 3: Gambar / Foto Produk -->
                <div class="admin-card p-5 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm font-semibold text-[#102A43]">Foto Katalog Produk</h2>
                        <p class="text-xs text-[#667085] mt-0.5">JPG, PNG, atau WEBP (Maks 4MB). Opsional.</p>
                    </div>

                    <div class="space-y-3">
                        <!-- Preview Box -->
                        <div class="w-full aspect-square rounded-lg border-2 border-dashed border-[#D0D5DD] bg-[#F7F7F5] overflow-hidden flex items-center justify-center relative" id="image-preview-container">
                            <img id="image-preview" src="#" alt="Preview Foto" class="w-full h-full object-cover hidden" />
                            <div id="image-placeholder" class="text-center p-4">
                                <svg class="w-10 h-10 mx-auto text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs text-[#667085] mt-2">Belum ada foto dipilih</p>
                            </div>
                        </div>

                        <!-- Input File -->
                        <input
                            type="file"
                            id="gambar"
                            name="gambar"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            onchange="previewProductImage(this)"
                            class="w-full text-xs text-[#667085] file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-[#F7F7F5] file:text-[#102A43] hover:file:bg-[#E2E5E9] cursor-pointer"
                        />
                        @error('gambar')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- CARD 4: File Model 3D -->
                <div class="admin-card p-5 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm font-semibold text-[#102A43]">Model Virtual Fitting 3D</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Format .glb atau .gltf (Maks 20MB). Opsional.</p>
                    </div>

                    <div class="space-y-3">
                        <input
                            type="file"
                            id="file_model_3d"
                            name="file_model_3d"
                            accept=".glb,.gltf"
                            class="w-full text-xs text-[#667085] file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-[#F7F7F5] file:text-[#102A43] hover:file:bg-[#E2E5E9] cursor-pointer"
                        />
                        <p class="text-[11px] text-[#667085]">
                            Model 3D dapat ditambahkan sekarang atau diunggah nanti dari menu katalog.
                        </p>
                        @error('file_model_3d')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

        </div>

        <!-- ACTION BUTTONS AT BOTTOM -->
        <div class="pt-6 border-t border-[#E2E5E9] flex items-center justify-end gap-3">
            <a
                href="{{ route('admin.produk.index') }}"
                class="btn-secondary px-4 py-2.5 text-xs sm:text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                class="btn-primary px-6 py-2.5 text-xs sm:text-sm font-medium cursor-pointer shadow-2xs"
            >
                Simpan Produk
            </button>
        </div>
    </form>

</div>

<script>
function previewProductImage(input) {
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
}
</script>
@endsection
