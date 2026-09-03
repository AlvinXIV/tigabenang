@extends('layouts.admin')

@section('title', 'Materials & Categories')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-[#172A39] text-white rounded-full text-[11px] font-black uppercase tracking-widest mb-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Garment Taxonomy
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Materials &amp; Categories</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Kelola master data kategori produk pakaian dan kurasi material kain atelier.
            </p>
        </div>
    </div>

    <!-- SUMMARY METRICS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="admin-card-rich p-6 flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase block">
                    TOTAL KATEGORI
                </span>
                <h3 class="text-3xl font-black text-[#172A39] tracking-tight mt-2">
                    {{ $summary['total_categories'] }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#172A39] text-white flex items-center justify-center shadow-md shadow-[#172A39]/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
            </div>
        </div>

        <div class="admin-card-rich p-6 flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase block">
                    TOTAL MATERIAL KAIN
                </span>
                <h3 class="text-3xl font-black text-[#172A39] tracking-tight mt-2">
                    {{ $summary['total_materials'] }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#172A39] text-white flex items-center justify-center shadow-md shadow-[#172A39]/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- TWO COLUMN TABLES: KATEGORI & MATERIAL -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- COLUMN 1: KATEGORI PRODUK -->
        <div class="space-y-4">
            <div class="admin-card-rich p-6 space-y-4">
                <h2 class="text-base font-black text-[#172A39]">Tambah Kategori Baru</h2>
                <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input
                        type="text"
                        name="nama_kategori"
                        required
                        placeholder="Nama kategori (mis. Jaket Varsity, Kaos)"
                        class="flex-1 px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] text-xs font-bold text-[#172A39] rounded-xl focus:outline-none focus:border-[#172A39] focus:bg-white"
                    />
                    <button
                        type="submit"
                        class="btn-navy-pill px-6 py-2.5 text-xs uppercase tracking-wider cursor-pointer border-0 shadow-xs"
                    >
                        Tambah
                    </button>
                </form>
            </div>

            <div class="admin-card-rich overflow-hidden">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr style="background:#172A39;color:#FAF8F5;" class="text-[10px] font-black tracking-wider uppercase">
                            <th class="px-6 py-3.5">ID</th>
                            <th class="px-6 py-3.5">NAMA KATEGORI</th>
                            <th class="px-6 py-3.5">PRODUK</th>
                            <th class="px-6 py-3.5 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#DCD6D0] bg-white">
                        @forelse ($categories as $cat)
                            <tr class="admin-table-row">
                                <td class="px-6 py-3.5 font-black text-[#6E7575]">#{{ $cat->id_kategori }}</td>
                                <td class="px-6 py-3.5 font-extrabold text-[#172A39] text-sm">{{ $cat->nama_kategori }}</td>
                                <td class="px-6 py-3.5 text-[#555E68] font-bold">{{ $cat->produk_count }} produk</td>
                                <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                    <form action="{{ route('admin.kategori.destroy', $cat->id_kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ $cat->nama_kategori }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors font-bold cursor-pointer border-0 bg-transparent"
                                            title="Hapus Kategori"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-[#6E7575] font-medium">Belum ada kategori di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- COLUMN 2: MATERIAL KAIN -->
        <div class="space-y-4">
            <div class="admin-card-rich p-6 space-y-4">
                <h2 class="text-base font-black text-[#172A39]">Tambah Material Kain</h2>
                <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="type" value="bahan" />
                    <input
                        type="text"
                        name="nama_bahan"
                        required
                        placeholder="Nama material (mis. Fleece, Cotton Combed)"
                        class="flex-1 px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] text-xs font-bold text-[#172A39] rounded-xl focus:outline-none focus:border-[#172A39] focus:bg-white"
                    />
                    <button
                        type="submit"
                        class="btn-navy-pill px-6 py-2.5 text-xs uppercase tracking-wider cursor-pointer border-0 shadow-xs"
                    >
                        Tambah
                    </button>
                </form>
            </div>

            <div class="admin-card-rich overflow-hidden">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr style="background:#172A39;color:#FAF8F5;" class="text-[10px] font-black tracking-wider uppercase">
                            <th class="px-6 py-3.5">ID</th>
                            <th class="px-6 py-3.5">NAMA MATERIAL</th>
                            <th class="px-6 py-3.5 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#DCD6D0] bg-white">
                        @forelse ($materials as $mat)
                            <tr class="admin-table-row">
                                <td class="px-6 py-3.5 font-black text-[#6E7575]">#{{ $mat->id_bahan }}</td>
                                <td class="px-6 py-3.5 font-black text-[#172A39] text-sm">🧵 {{ $mat->nama_bahan }}</td>
                                <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                    <form action="{{ route('admin.kategori.destroy', ['kategori' => $mat->id_bahan, 'type' => 'bahan']) }}" method="POST" onsubmit="return confirm('Hapus material {{ $mat->nama_bahan }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors font-bold cursor-pointer border-0 bg-transparent"
                                            title="Hapus Material"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-[#6E7575] font-medium">Belum ada material kain di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
