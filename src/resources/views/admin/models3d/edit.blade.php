@extends('layouts.admin')

@section('title', 'Edit 3D Model Asset')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.model-3d.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-mono font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>3D Models</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Edit 3D Model Asset</h1>
        </div>
    </div>

    <form action="{{ route('admin.model-3d.update', $product->id_produk) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                PRODUK TERHUBUNG
            </label>
            <input
                type="text"
                disabled
                value="{{ $product->nama_produk }}"
                class="w-full px-3.5 py-2.5 bg-[#FAF7F2] border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none cursor-not-allowed font-medium"
            />
        </div>

        @if ($product->file_model_3d)
            <div class="p-4 bg-[#FAF7F2] border border-[#EADACE]">
                <span class="text-[10px] font-mono text-[#786C62] uppercase block">FILE SAAT INI</span>
                <p class="text-xs font-mono text-[#1C1917] mt-1">{{ $product->file_model_3d }}</p>
            </div>
        @endif

        <div>
            <label for="file_model_3d" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                GANTI FILE 3D (.GLB / .GLTF)
            </label>
            <input
                type="file"
                id="file_model_3d"
                name="file_model_3d"
                accept=".glb,.gltf"
                class="w-full text-xs text-[#574E46] file:mr-4 file:py-2 file:px-4 file:border file:border-[#D9CCC1] file:bg-[#FAF7F2] file:text-xs file:font-mono file:text-[#292524] hover:file:bg-[#EFE7DE] file:cursor-pointer"
            />
            <p class="text-[10px] text-[#78716C] mt-2">Maksimal 20MB.</p>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium uppercase"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] text-white text-xs font-mono font-medium uppercase cursor-pointer"
            >
                Save Changes
            </button>
        </div>

    </form>

</div>
@endsection
