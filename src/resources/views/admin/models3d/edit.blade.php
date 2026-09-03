@extends('layouts.admin')

@section('title', 'Edit 3D Model Asset')

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
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Edit 3D Model Asset</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Perbarui atau ganti file 3D (.glb) yang terhubung ke produk ini.
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
                form="edit-3d-form"
                class="btn-navy-pill px-7 py-2.5 text-xs uppercase tracking-wide cursor-pointer border-0 shadow-md"
            >
                Save Changes
            </button>
        </div>
    </div>

    <!-- MAIN FORM -->
    <form
        id="edit-3d-form"
        action="{{ route('admin.model-3d.update', $product->id_produk) }}"
        method="POST"
        enctype="multipart/form-data"
        class="admin-card-rich p-6 sm:p-8 space-y-6 max-w-2xl"
    >
        @csrf
        @method('PUT')

        <div>
            <label class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                PRODUK TERHUBUNG
            </label>
            <input
                type="text"
                disabled
                value="{{ $product->nama_produk }}"
                class="w-full px-4 py-3 bg-[#FAF8F5] border border-[#DCD6D0] text-xs sm:text-sm text-[#172A39] rounded-xl cursor-not-allowed font-black"
            />
        </div>

        @if ($product->file_model_3d)
            <div class="p-4 bg-[#FAF8F5] border border-[#DCD6D0] rounded-xl flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black tracking-widest text-[#6E7575] uppercase block">FILE 3D SAAT INI</span>
                    <p class="text-xs font-mono font-bold text-[#172A39] mt-1">📁 {{ basename($product->file_model_3d) }}</p>
                </div>
                <a
                    href="{{ route('admin.model-3d.preview', $product->id_produk) }}"
                    class="btn-navy-pill px-4 py-1.5 text-xs uppercase tracking-wider"
                >
                    Preview
                </a>
            </div>
        @endif

        <div>
            <label for="file_model_3d" class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                GANTI FILE 3D (.GLB / .GLTF)
            </label>
            <input
                type="file"
                id="file_model_3d"
                name="file_model_3d"
                accept=".glb,.gltf"
                class="w-full text-xs text-[#555E68] file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-[#172A39] file:text-white hover:file:bg-[#0E1B25] cursor-pointer"
            />
            <p class="text-[11px] text-[#6E7575] mt-2 font-medium">Kosongkan jika tidak ingin mengganti file model 3D.</p>
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
                Save Changes
            </button>
        </div>

    </form>

</div>
@endsection
