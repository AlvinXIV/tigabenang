@extends('layouts.admin')

@section('title', 'Preview 3D Model - ' . $product->nama_produk)

@push('scripts')
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
@endpush

@section('content')
<div class="space-y-8 max-w-6xl mx-auto" x-data="{ autoRotate: true }">

    <!-- Header Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.model-3d.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-mono font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>3D Models</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">{{ $product->nama_produk }}</h1>
                <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                    ACTIVE
                </span>
            </div>
            <p class="text-xs font-mono text-[#78716C] mt-1 tracking-wide">
                <span>Category: {{ $product->kategori ? $product->kategori->nama_kategori : '-' }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Back to Library
            </a>
            <a
                href="{{ route('admin.produk.edit', $product->id_produk) }}"
                class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs"
            >
                View Product
            </a>
        </div>
    </div>

    <!-- Main 3D Canvas Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- 3D WebGL Canvas (2 Cols) -->
        <div class="lg:col-span-2 bg-[#FAF7F2] border border-[#EADACE] p-4 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
            <div class="h-[480px] w-full bg-stone-900 border border-[#EADACE] relative overflow-hidden">
                <model-viewer
                    src="{{ asset('storage/' . $product->file_model_3d) }}"
                    alt="{{ $product->nama_produk }}"
                    camera-controls
                    touch-action="pan-y"
                    :auto-rotate="autoRotate"
                    rotation-per-second="30deg"
                    shadow-intensity="1.2"
                    exposure="1.1"
                    class="w-full h-full cursor-grab active:cursor-grabbing bg-[#1C1917]"
                ></model-viewer>

                <div class="absolute top-4 left-4">
                    <span class="px-2.5 py-1 bg-black/70 backdrop-blur-xs text-white text-[10px] font-mono font-medium tracking-wider uppercase border border-white/20 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Interactive 3D Viewer
                    </span>
                </div>

                <div class="absolute bottom-4 right-4 bg-black/70 backdrop-blur-xs px-3 py-1.5 border border-white/20 flex items-center gap-2 text-xs text-white">
                    <label class="flex items-center gap-1.5 cursor-pointer text-[11px] font-mono">
                        <input type="checkbox" x-model="autoRotate" class="rounded text-[#B85331]" />
                        <span>Auto-Rotate</span>
                    </label>
                </div>
            </div>

            <div class="px-2 text-xs text-[#78716C] flex items-center justify-between">
                <p>💡 Click and drag to rotate view. Scroll mouse to zoom in/out.</p>
                <span class="font-mono text-[11px] text-[#8C7E72]">{{ basename($product->file_model_3d) }}</span>
            </div>
        </div>

        <!-- 3D Specifications Sidebar (1 Col) -->
        <div class="space-y-6">
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Model Specifications</h2>

                <div class="space-y-3 text-xs divide-y divide-[#EADACE]/60">
                    <div class="flex justify-between py-2">
                        <span class="text-[#78716C]">File Name:</span>
                        <span class="font-mono font-medium text-[#1C1917] truncate max-w-[150px]">{{ basename($product->file_model_3d) }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-[#78716C]">Linked Product:</span>
                        <a href="{{ route('admin.produk.edit', $product->id_produk) }}" class="font-medium text-[#B85331] hover:underline">
                            {{ $product->nama_produk }}
                        </a>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-[#78716C]">Harga:</span>
                        <span class="font-mono font-medium text-[#1C1917]">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
