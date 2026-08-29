@extends('layouts.admin')

@section('title', '3D Fitting Models')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-[#172A39] text-white rounded-full text-[11px] font-black uppercase tracking-widest mb-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Interactive Assets
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">3D Fitting Models</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Kelola file aset 3D (.glb / .gltf) untuk simulasi virtual fitting interaktif di landing page.
            </p>
        </div>
    </div>

    <!-- 3D ASSETS LIST / GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($productsWith3D as $prod)
            <div class="admin-card-rich p-6 space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 bg-[#FAF8F5] border border-[#DCD6D0] rounded-full text-[10px] font-black uppercase tracking-wider text-[#172A39]">
                            {{ $prod->kategori ? $prod->kategori->nama_kategori : 'Katalog' }}
                        </span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100" title="Model 3D Aktif"></span>
                    </div>

                    <h3 class="text-base font-black text-[#172A39]">{{ $prod->nama_produk }}</h3>
                    <p class="text-xs font-mono text-[#6E7575] truncate bg-[#FAF8F5] p-2 rounded-lg border border-[#DCD6D0]">
                        📁 {{ basename($prod->file_model_3d) }}
                    </p>
                </div>

                <div class="pt-4 border-t border-[#DCD6D0] flex items-center justify-between gap-3">
                    <a
                        href="{{ route('admin.model-3d.preview', $prod->id_produk) }}"
                        class="btn-navy-pill flex-1 py-2.5 text-xs uppercase tracking-wider text-center"
                    >
                        Preview 3D
                    </a>

                    <a
                        href="{{ route('admin.produk.edit', $prod->id_produk) }}"
                        class="btn-cream-pill px-4 py-2.5 text-xs uppercase tracking-wider text-center"
                    >
                        Edit
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full admin-card-rich p-12 text-center space-y-3">
                <div class="w-16 h-16 rounded-3xl bg-[#172A39] text-white flex items-center justify-center mx-auto shadow-md shadow-[#172A39]/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-base font-black text-[#172A39]">Belum ada Produk dengan File 3D</h3>
                <p class="text-xs text-[#555E68] max-w-md mx-auto font-medium">
                    Upload file .glb pada halaman tambah/edit produk untuk mengaktifkan fitur virtual fitting.
                </p>
                <div class="pt-3">
                    <a href="{{ route('admin.produk.create') }}" class="btn-navy-pill px-6 py-2.5 text-xs uppercase tracking-wider">
                        + Tambah Produk 3D
                    </a>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection
