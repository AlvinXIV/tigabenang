@extends('layouts.admin')

@section('title', 'Materials & Categories')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Materials & Categories</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Kelola data kategori produk dan material kain dari database.
            </p>
        </div>
    </div>

    <!-- SUMMARY METRICS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                TOTAL KATEGORI
            </span>
            <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono mt-3">
                {{ $summary['total_categories'] }}
            </h3>
        </div>

        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                TOTAL MATERIAL KAIN
            </span>
            <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono mt-3">
                {{ $summary['total_materials'] }}
            </h3>
        </div>
    </div>

    <!-- TWO COLUMN TABLES: KATEGORI & MATERIAL -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- COLUMN 1: KATEGORI PRODUK -->
        <div class="space-y-4">
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] p-6 space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Tambah Kategori</h2>
                <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input
                        type="text"
                        name="nama_kategori"
                        required
                        placeholder="Nama kategori (mis. Jaket, Kaos)"
                        class="flex-1 px-3.5 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                    />
                    <button
                        type="submit"
                        class="px-4 py-2 bg-[#B85331] text-white text-xs font-mono font-medium uppercase hover:bg-[#A34524] transition-colors cursor-pointer"
                    >
                        Tambah
                    </button>
                </form>
            </div>

            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
                <div class="p-4 border-b border-[#EADACE]/70 bg-[#FAF7F2]/60">
                    <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-[#786C62]">Daftar Kategori</h3>
                </div>
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/30 text-[10px] font-mono text-[#786C62] uppercase">
                            <th class="px-6 py-3.5">ID</th>
                            <th class="px-6 py-3.5">NAMA KATEGORI</th>
                            <th class="px-6 py-3.5">PRODUK TERKAIT</th>
                            <th class="px-6 py-3.5 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EADACE]/60">
                        @forelse ($categories as $cat)
                            <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                                <td class="px-6 py-3.5 font-mono text-[#786C62]">#{{ $cat->id_kategori }}</td>
                                <td class="px-6 py-3.5 font-medium text-[#1C1917]">{{ $cat->nama_kategori }}</td>
                                <td class="px-6 py-3.5 text-[#574E46]">{{ $cat->produk_count }} produk</td>
                                <td class="px-6 py-3.5 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                    <div class="relative inline-block text-left">
                                        <button
                                            type="button"
                                            @click="menuOpen = !menuOpen"
                                            class="p-1.5 text-[#786C62] hover:text-[#1C1917] hover:bg-[#FAF7F2] border border-transparent hover:border-[#EADACE] transition-colors focus:outline-none cursor-pointer"
                                            title="Actions"
                                        >
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="2"></circle>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <circle cx="12" cy="19" r="2"></circle>
                                            </svg>
                                        </button>

                                        <div
                                            x-show="menuOpen"
                                            @click.away="menuOpen = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute right-0 mt-1 w-36 bg-white border border-[#EADACE] shadow-lg py-1 z-30 text-left divide-y divide-[#EADACE]/50"
                                            style="display: none;"
                                        >
                                            <div class="py-0.5">
                                                <a
                                                    href="{{ route('admin.kategori.edit', $cat->id_kategori) }}"
                                                    class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    <span>Edit Kategori</span>
                                                </a>
                                            </div>

                                            <div class="py-0.5">
                                                <form action="{{ route('admin.kategori.destroy', $cat->id_kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ $cat->nama_kategori }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="w-full flex items-center gap-2 px-3.5 py-2 text-xs text-rose-700 hover:bg-rose-50 transition-colors font-medium cursor-pointer"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-[#78716C]">Belum ada kategori di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- COLUMN 2: MATERIAL KAIN -->
        <div class="space-y-4">
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] p-6 space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Tambah Material Kain</h2>
                <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="type" value="bahan" />
                    <input
                        type="text"
                        name="nama_bahan"
                        required
                        placeholder="Nama material (mis. Cotton Fleece, Baby Terry)"
                        class="flex-1 px-3.5 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                    />
                    <button
                        type="submit"
                        class="px-4 py-2 bg-[#B85331] text-white text-xs font-mono font-medium uppercase hover:bg-[#A34524] transition-colors cursor-pointer"
                    >
                        Tambah
                    </button>
                </form>
            </div>

            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
                <div class="p-4 border-b border-[#EADACE]/70 bg-[#FAF7F2]/60">
                    <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-[#786C62]">Daftar Material Kain</h3>
                </div>
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/30 text-[10px] font-mono text-[#786C62] uppercase">
                            <th class="px-6 py-3.5">ID</th>
                            <th class="px-6 py-3.5">NAMA MATERIAL</th>
                            <th class="px-6 py-3.5 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EADACE]/60">
                        @forelse ($materials as $mat)
                            <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                                <td class="px-6 py-3.5 font-mono text-[#786C62]">#{{ $mat->id_bahan }}</td>
                                <td class="px-6 py-3.5 font-medium text-[#1C1917]">{{ $mat->nama_bahan }}</td>
                                <td class="px-6 py-3.5 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                    <div class="relative inline-block text-left">
                                        <button
                                            type="button"
                                            @click="menuOpen = !menuOpen"
                                            class="p-1.5 text-[#786C62] hover:text-[#1C1917] hover:bg-[#FAF7F2] border border-transparent hover:border-[#EADACE] transition-colors focus:outline-none cursor-pointer"
                                            title="Actions"
                                        >
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="2"></circle>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <circle cx="12" cy="19" r="2"></circle>
                                            </svg>
                                        </button>

                                        <div
                                            x-show="menuOpen"
                                            @click.away="menuOpen = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute right-0 mt-1 w-36 bg-white border border-[#EADACE] shadow-lg py-1 z-30 text-left divide-y divide-[#EADACE]/50"
                                            style="display: none;"
                                        >
                                            <div class="py-0.5">
                                                <a
                                                    href="{{ route('admin.kategori.edit', $mat->id_bahan) }}"
                                                    class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    <span>Edit Material</span>
                                                </a>
                                            </div>

                                            <div class="py-0.5">
                                                <form action="{{ route('admin.kategori.destroy', ['kategori' => $mat->id_bahan, 'type' => 'bahan']) }}" method="POST" onsubmit="return confirm('Hapus material {{ $mat->nama_bahan }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="w-full flex items-center gap-2 px-3.5 py-2 text-xs text-rose-700 hover:bg-rose-50 transition-colors font-medium cursor-pointer"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-[#78716C]">Belum ada material kain di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
