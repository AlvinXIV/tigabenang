@extends('layouts.admin')

@section('title', 'Unggah Model 3D')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">

    <!-- TOP HEADER -->
    <div class="pb-5 border-b border-[#E2E5E9]">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">Hubungkan Model 3D</h1>
        <p class="text-xs sm:text-sm text-[#667085] mt-1">
            Pilih produk katalog dan unggah file 3D (.glb / .gltf) untuk simulasi virtual fitting.
        </p>
    </div>

    <!-- MAIN FORM -->
    <form
        id="upload-3d-form"
        action="{{ route('admin.model-3d.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="admin-card p-6 sm:p-8 space-y-5"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf

        <div>
            <label for="produk_id" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                Pilih Produk Katalog <span class="text-rose-500">*</span>
            </label>
            <select
                id="produk_id"
                name="produk_id"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
            >
                <option value="" disabled selected>Pilih Produk Katalog...</option>
                @foreach ($availableProducts as $prod)
                    <option value="{{ $prod->id_produk }}">{{ $prod->nama_produk }} ({{ $prod->kategori ? $prod->kategori->nama_kategori : 'Katalog' }})</option>
                @endforeach
            </select>
            @error('produk_id')
                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="file_model_3d" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                File Model 3D (.glb / .gltf) <span class="text-rose-500">*</span>
            </label>
            <input
                type="file"
                id="file_model_3d"
                name="file_model_3d"
                accept=".glb,.gltf"
                required
                class="w-full text-xs text-[#667085] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#102A43] file:text-white hover:file:bg-[#193B5C] cursor-pointer"
            />
            <p class="text-[11px] text-[#667085] mt-2">Format yang didukung: <strong>.glb</strong> atau <strong>.gltf</strong> (Maksimal 20MB).</p>
            @error('file_model_3d')
                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-[#E2E5E9] flex items-center justify-end gap-3">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="btn-secondary px-4 py-2 text-xs sm:text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                :disabled="isSubmitting"
                class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium"
            >
                <span x-text="isSubmitting ? 'Mengunggah...' : 'Unggah & Hubungkan'"></span>
            </button>
        </div>

    </form>

</div>
@endsection

