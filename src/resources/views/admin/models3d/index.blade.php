@extends('layouts.admin')

@section('title', '3D Model Assets')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">3D Model Assets</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Kelola file aset 3D (.glb / .gltf) yang terhubung ke produk untuk virtual fitting.
            </p>
        </div>

        <div>
            <a
                href="{{ route('admin.model-3d.create') }}"
                class="px-4 py-2.5 bg-[#B85331] hover:bg-[#A34524] text-white text-xs font-mono font-medium tracking-wider uppercase shadow-xs flex items-center gap-1.5"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Upload 3D Model</span>
            </a>
        </div>
    </div>

    <!-- MODELS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($models as $prod)
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] p-5 space-y-4">
                <div class="h-44 bg-[#FAF7F2] border border-[#EADACE] flex flex-col items-center justify-center relative group p-4 text-center">
                    @if ($prod->gambar)
                        <img src="{{ asset('storage/' . $prod->gambar) }}" alt="{{ $prod->nama_produk }}" class="w-full h-full object-cover opacity-80" />
                    @else
                        <svg class="w-12 h-12 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    @endif
                    <div class="absolute inset-0 bg-stone-900/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <a
                            href="{{ route('admin.model-3d.preview', $prod->id_produk) }}"
                            class="px-3.5 py-1.5 bg-white text-[#1C1917] text-xs font-mono font-medium border border-[#EADACE] shadow-sm hover:bg-[#FAF7F2]"
                        >
                            Preview 3D
                        </a>
                    </div>
                </div>

                <div class="space-y-1">
                    <span class="text-[10px] font-mono uppercase tracking-wider text-[#786C62]">
                        {{ $prod->kategori ? $prod->kategori->nama_kategori : 'Garment' }}
                    </span>
                    <h3 class="text-base font-medium text-[#1C1917] truncate">{{ $prod->nama_produk }}</h3>
                    <p class="text-xs font-mono text-[#78716C] truncate">File: {{ basename($prod->file_model_3d) }}</p>
                </div>

                <div class="pt-3 border-t border-[#EADACE]/70 flex items-center justify-between">
                    <a href="{{ route('admin.model-3d.preview', $prod->id_produk) }}" class="text-xs text-[#B85331] font-medium hover:underline">
                        View Model &rarr;
                    </a>
                    <form action="{{ route('admin.model-3d.destroy', $prod->id_produk) }}" method="POST" onsubmit="return confirm('Hapus aset 3D dari produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-rose-600 hover:underline cursor-pointer">
                            Remove 3D
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-[#EADACE] p-12 text-center text-[#78716C] space-y-3">
                <svg class="w-10 h-10 mx-auto text-[#D9CCC1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <p>Belum ada produk yang memiliki aset file Model 3D (.glb) terhubung.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
