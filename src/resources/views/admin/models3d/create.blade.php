@extends('layouts.admin')

@section('title', 'Upload 3D Model')

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
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Upload 3D Model</h1>
        </div>
    </div>

    <form action="{{ route('admin.model-3d.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6 max-w-2xl">
        @csrf

        <div>
            <label for="produk_id" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                HUBUNGKAN KE PRODUK <span class="text-[#B85331]">*</span>
            </label>
            <select
                id="produk_id"
                name="produk_id"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
            >
                <option value="" disabled selected>Pilih Produk</option>
                @foreach ($availableProducts as $prod)
                    <option value="{{ $prod->id_produk }}">{{ $prod->nama_produk }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="file_model_3d" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                FILE MODEL 3D (.GLB / .GLTF) <span class="text-[#B85331]">*</span>
            </label>
            <input
                type="file"
                id="file_model_3d"
                name="file_model_3d"
                accept=".glb,.gltf"
                required
                class="w-full text-xs text-[#574E46] file:mr-4 file:py-2 file:px-4 file:border file:border-[#D9CCC1] file:bg-[#FAF7F2] file:text-xs file:font-mono file:text-[#292524] hover:file:bg-[#EFE7DE] file:cursor-pointer"
            />
            <p class="text-[10px] text-[#78716C] mt-2">Maksimal ukuran file 20MB.</p>
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
                Upload & Connect
            </button>
        </div>

    </form>

</div>
@endsection
