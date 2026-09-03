@extends('layouts.admin')

@section('title', 'Pratinjau Model 3D - ' . $product->nama_produk)

@push('scripts')
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
@endpush

@section('content')
<div class="space-y-6" x-data="{ autoRotate: true }">

    <!-- Header Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <a href="{{ route('admin.model-3d.index') }}" class="text-xs text-[#667085] hover:text-[#B8664A] inline-flex items-center gap-1.5 mb-2 transition-colors text-decoration-none font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Library 3D</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">{{ $product->nama_produk }}</h1>
                <span class="px-2.5 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">
                    3D Model Aktif
                </span>
            </div>
            <p class="text-xs text-[#667085] mt-1">
                Kategori: {{ $product->kategori ? $product->kategori->nama_kategori : '-' }}
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="btn-secondary px-4 py-2 text-xs sm:text-sm"
            >
                Library 3D
            </a>
            <a
                href="{{ route('admin.produk.edit', $product->id_produk) }}"
                class="btn-primary px-4 py-2 text-xs sm:text-sm font-medium"
            >
                Kelola Produk
            </a>
        </div>
    </div>

    <!-- Main 3D Canvas Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- 3D WebGL Canvas (2 Cols) -->
        <div class="lg:col-span-2 admin-card p-4 space-y-3">
            <div class="h-[460px] w-full bg-[#1C2430] rounded-xl relative overflow-hidden shadow-inner">
                <model-viewer
                    src="{{ asset('storage/' . $product->file_model_3d) }}"
                    alt="{{ $product->nama_produk }}"
                    camera-controls
                    touch-action="pan-y"
                    :auto-rotate="autoRotate"
                    rotation-per-second="30deg"
                    shadow-intensity="1.2"
                    exposure="1.1"
                    class="w-full h-full cursor-grab active:cursor-grabbing bg-[#1C2430]"
                ></model-viewer>

                <div class="absolute top-3.5 left-3.5">
                    <span class="px-3 py-1 bg-[#1C2430]/90 backdrop-blur-xs text-white text-[11px] font-medium border border-white/20 rounded-full flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Pratinjau Interaktif 3D
                    </span>
                </div>

                <div class="absolute bottom-3.5 right-3.5 bg-[#1C2430]/90 backdrop-blur-xs px-3 py-1.5 border border-white/20 rounded-lg flex items-center gap-2 text-xs text-white">
                    <label class="flex items-center gap-2 cursor-pointer text-xs">
                        <input type="checkbox" x-model="autoRotate" class="rounded text-[#B8664A] focus:ring-[#B8664A]" />
                        <span>Putar Otomatis</span>
                    </label>
                </div>
            </div>

            <div class="px-1 text-xs text-[#667085] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-1">
                <p>💡 Geser kursor untuk memutar sudut pandang 360°. Scroll untuk perbesar/perkecil.</p>
                <span class="font-mono text-[11px] text-[#1C2430] font-semibold">📁 {{ basename($product->file_model_3d) }}</span>
            </div>
        </div>

        <!-- 3D Specifications Sidebar (1 Col) -->
        <div class="space-y-6">
            <div class="admin-card p-5 space-y-4">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430] border-b border-[#E2E5E9] pb-3">Spesifikasi Model</h2>

                <div class="space-y-3 text-xs sm:text-sm divide-y divide-[#E2E5E9]">
                    <div class="flex justify-between py-2">
                        <span class="text-[#667085]">Nama File:</span>
                        <span class="font-mono font-semibold text-[#1C2430] truncate max-w-[150px]">{{ basename($product->file_model_3d) }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-[#667085]">Produk Terhubung:</span>
                        <a href="{{ route('admin.produk.edit', $product->id_produk) }}" class="font-medium text-[#B8664A] hover:underline">
                            {{ $product->nama_produk }}
                        </a>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-[#667085]">Harga Dasar:</span>
                        <span class="font-semibold text-[#1C2430]">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-2">
                    <a
                        href="{{ route('admin.model-3d.edit', $product->id_produk) }}"
                        class="btn-secondary w-full py-2 text-xs text-center block"
                    >
                        Ganti File 3D (.glb)
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

