@extends('layouts.admin')

@section('title', 'Preview 3D Model - ' . $product->nama_produk)

@push('scripts')
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
@endpush

@section('content')
<div class="space-y-8 max-w-6xl mx-auto" x-data="{ autoRotate: true }">

    <!-- Header Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <a href="{{ route('admin.model-3d.index') }}" class="text-xs text-[#172A39] hover:underline font-black inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider text-decoration-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>&larr; Kembali ke Library 3D</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">{{ $product->nama_produk }}</h1>
                <span class="px-3 py-1 text-[10px] font-black tracking-wider uppercase bg-emerald-100 text-emerald-900 border border-emerald-300 rounded-full">
                    ACTIVE 3D
                </span>
            </div>
            <p class="text-xs text-[#555E68] font-bold mt-1">
                Kategori: {{ $product->kategori ? $product->kategori->nama_kategori : '-' }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="btn-cream-pill px-5 py-2.5 text-xs uppercase tracking-wide cursor-pointer"
            >
                Back to Library
            </a>
            <a
                href="{{ route('admin.produk.edit', $product->id_produk) }}"
                class="btn-navy-pill px-6 py-2.5 text-xs uppercase tracking-wide gap-2 cursor-pointer shadow-md"
            >
                View Product
            </a>
        </div>
    </div>

    <!-- Main 3D Canvas Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- 3D WebGL Canvas (2 Cols) -->
        <div class="lg:col-span-2 admin-card-rich p-4 space-y-4">
            <div class="h-[480px] w-full bg-[#172A39] rounded-2xl border border-[#DCD6D0] relative overflow-hidden shadow-inner">
                <model-viewer
                    src="{{ asset('storage/' . $product->file_model_3d) }}"
                    alt="{{ $product->nama_produk }}"
                    camera-controls
                    touch-action="pan-y"
                    :auto-rotate="autoRotate"
                    rotation-per-second="30deg"
                    shadow-intensity="1.2"
                    exposure="1.1"
                    class="w-full h-full cursor-grab active:cursor-grabbing bg-[#172A39]"
                ></model-viewer>

                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1.5 bg-[#0E1B25]/80 backdrop-blur-xs text-white text-[10px] font-black tracking-widest uppercase border border-white/20 rounded-full flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Interactive 3D Viewer
                    </span>
                </div>

                <div class="absolute bottom-4 right-4 bg-[#0E1B25]/80 backdrop-blur-xs px-3.5 py-2 border border-white/20 rounded-xl flex items-center gap-2 text-xs text-white">
                    <label class="flex items-center gap-2 cursor-pointer text-[11px] font-bold">
                        <input type="checkbox" x-model="autoRotate" class="rounded accent-[#172A39]" />
                        <span>Auto-Rotate</span>
                    </label>
                </div>
            </div>

            <div class="px-2 text-xs text-[#6E7575] flex items-center justify-between font-medium">
                <p>💡 Geser kursor untuk memutar model 3D. Scroll untuk zoom in/out.</p>
                <span class="font-mono text-[11px] text-[#172A39] font-bold">📁 {{ basename($product->file_model_3d) }}</span>
            </div>
        </div>

        <!-- 3D Specifications Sidebar (1 Col) -->
        <div class="space-y-6">
            <div class="admin-card-rich p-6 space-y-4">
                <h2 class="text-base font-black text-[#172A39]">Model Specifications</h2>

                <div class="space-y-3 text-xs divide-y divide-[#DCD6D0]">
                    <div class="flex justify-between py-2">
                        <span class="text-[#6E7575] font-bold">File Name:</span>
                        <span class="font-mono font-bold text-[#172A39] truncate max-w-[150px]">{{ basename($product->file_model_3d) }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-[#6E7575] font-bold">Linked Product:</span>
                        <a href="{{ route('admin.produk.edit', $product->id_produk) }}" class="font-black text-[#172A39] hover:underline">
                            {{ $product->nama_produk }}
                        </a>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-[#6E7575] font-bold">Harga Satuan:</span>
                        <span class="font-black text-sm text-[#172A39]">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
