@extends('layouts.admin')

@section('title', 'Ubah File Model 3D')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <a href="{{ route('admin.model-3d.index') }}" class="text-xs text-[#667085] hover:text-[#B8664A] inline-flex items-center gap-1.5 mb-2 transition-colors text-decoration-none font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Library 3D</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">Perbarui Aset 3D</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Perbarui atau ganti file 3D (.glb) yang terhubung ke produk {{ $product->nama_produk }}.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="btn-secondary px-4 py-2 text-xs sm:text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                form="edit-3d-form"
                class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium"
            >
                Simpan
            </button>
        </div>
    </div>

    <!-- MAIN FORM -->
    <form
        id="edit-3d-form"
        action="{{ route('admin.model-3d.update', $product->id_produk) }}"
        method="POST"
        enctype="multipart/form-data"
        class="admin-card p-6 sm:p-8 space-y-5"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                Produk Katalog Terhubung
            </label>
            <input
                type="text"
                disabled
                value="{{ $product->nama_produk }} ({{ $product->kategori ? $product->kategori->nama_kategori : 'Katalog' }})"
                class="w-full px-3.5 py-2.5 bg-[#F7F7F5] border border-[#E2E5E9] text-xs sm:text-sm text-[#1C2430] rounded-lg cursor-not-allowed font-semibold"
            />
        </div>

        @if ($product->file_model_3d)
            <div class="p-3.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-[#667085] block">File 3D Aktif Saat Ini:</span>
                    <p class="text-xs font-mono font-semibold text-[#1C2430] mt-0.5">📁 {{ basename($product->file_model_3d) }}</p>
                </div>
                <a
                    href="{{ route('admin.model-3d.preview', $product->id_produk) }}"
                    class="btn-secondary px-3 py-1 text-xs"
                >
                    Pratinjau
                </a>
            </div>
        @endif

        <div>
            <label for="file_model_3d" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                Ganti File Model 3D (.glb / .gltf)
            </label>
            <input
                type="file"
                id="file_model_3d"
                name="file_model_3d"
                accept=".glb,.gltf"
                class="w-full text-xs text-[#667085] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#B8664A] file:text-white hover:file:bg-[#9A4E3A] cursor-pointer"
            />
            <p class="text-[11px] text-[#667085] mt-2">Kosongkan jika tidak ingin mengganti file model 3D (Maksimal 20MB).</p>
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
                <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
            </button>
        </div>

    </form>

</div>
@endsection

