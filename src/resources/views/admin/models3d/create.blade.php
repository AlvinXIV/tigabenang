@extends('layouts.admin')

@section('title', 'Upload 3D Model')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <a href="{{ route('admin.model-3d.index') }}" class="text-xs text-[#172A39] hover:underline font-black inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider text-decoration-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>&larr; Kembali ke Library 3D</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Upload &amp; Hubungkan 3D Model</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Pilih produk katalog dan unggah file 3D (.glb / .gltf) untuk simulasi virtual fitting.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="btn-cream-pill px-5 py-2.5 text-xs uppercase tracking-wide cursor-pointer"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="upload-3d-form"
                class="btn-navy-pill px-7 py-2.5 text-xs uppercase tracking-wide cursor-pointer border-0 shadow-md"
            >
                Upload &amp; Connect
            </button>
        </div>
    </div>

    <!-- MAIN FORM -->
    <form
        id="upload-3d-form"
        action="{{ route('admin.model-3d.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="admin-card-rich p-6 sm:p-8 space-y-6 max-w-2xl"
    >
        @csrf

        <div>
            <label for="produk_id" class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                HUBUNGKAN KE PRODUK <span class="text-rose-600">*</span>
            </label>
            <select
                id="produk_id"
                name="produk_id"
                required
                class="w-full px-4 py-3 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-bold text-[#172A39] rounded-xl focus:outline-none transition-colors"
            >
                <option value="" disabled selected>Pilih Produk Katalog</option>
                @foreach ($availableProducts as $prod)
                    <option value="{{ $prod->id_produk }}">{{ $prod->nama_produk }} ({{ $prod->kategori ? $prod->kategori->nama_kategori : 'Katalog' }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="file_model_3d" class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                FILE MODEL 3D (.GLB / .GLTF) <span class="text-rose-600">*</span>
            </label>
            <input
                type="file"
                id="file_model_3d"
                name="file_model_3d"
                accept=".glb,.gltf"
                required
                class="w-full text-xs text-[#555E68] file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-[#172A39] file:text-white hover:file:bg-[#0E1B25] cursor-pointer"
            />
            <p class="text-[11px] text-[#6E7575] mt-2 font-medium">Format didukung: <strong>.glb</strong> atau <strong>.gltf</strong> (Maksimal ukuran 20MB).</p>
        </div>

        <div class="pt-4 border-t border-[#DCD6D0] flex items-center justify-end gap-3">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="btn-cream-pill px-5 py-2.5 text-xs uppercase tracking-wide cursor-pointer"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="btn-navy-pill px-7 py-2.5 text-xs uppercase tracking-wide cursor-pointer border-0 shadow-md"
            >
                Upload &amp; Hubungkan
            </button>
        </div>

    </form>

</div>
@endsection
