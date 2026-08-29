@extends('layouts.admin')

@section('title', 'Size Charts')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-[#172A39] text-white rounded-full text-[11px] font-black uppercase tracking-widest mb-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Dimension Matrix
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Size Charts &amp; Dimensions</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Matriks standar ukuran pakaian atelier (lebar dada, panjang badan, dan panjang lengan).
            </p>
        </div>
    </div>

    <!-- ADD SIZE FORM & TABLE -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- FORM COLUMN -->
        <div class="lg:col-span-1 admin-card-rich p-6 space-y-5">
            <div>
                <h2 class="text-base font-black text-[#172A39]">Tambah Ukuran Baru</h2>
                <p class="text-xs text-[#6E7575] mt-1">Masukkan spesifikasi dimensi dalam satuan cm.</p>
            </div>

            <form action="{{ route('admin.ukuran.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="nama_ukuran" class="block text-[10px] font-black tracking-widest text-[#6E7575] uppercase mb-1">
                        KODE UKURAN (MIS. S, M, L, XL, XXL)
                    </label>
                    <input
                        type="text"
                        name="nama_ukuran"
                        id="nama_ukuran"
                        required
                        placeholder="Contoh: XL"
                        class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] text-xs font-bold text-[#172A39] rounded-xl focus:outline-none focus:border-[#172A39] focus:bg-white"
                    />
                </div>

                <div>
                    <label for="panjang" class="block text-[10px] font-black tracking-widest text-[#6E7575] uppercase mb-1">
                        PANJANG BADAN (CM)
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        name="panjang"
                        id="panjang"
                        placeholder="Contoh: 72.0"
                        class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] text-xs font-bold text-[#172A39] rounded-xl focus:outline-none focus:border-[#172A39] focus:bg-white"
                    />
                </div>

                <div>
                    <label for="lebar" class="block text-[10px] font-black tracking-widest text-[#6E7575] uppercase mb-1">
                        LEBAR DADA (CM)
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        name="lebar"
                        id="lebar"
                        placeholder="Contoh: 54.0"
                        class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] text-xs font-bold text-[#172A39] rounded-xl focus:outline-none focus:border-[#172A39] focus:bg-white"
                    />
                </div>

                <div>
                    <label for="panjang_lengan" class="block text-[10px] font-black tracking-widest text-[#6E7575] uppercase mb-1">
                        PANJANG LENGAN (CM)
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        name="panjang_lengan"
                        id="panjang_lengan"
                        placeholder="Contoh: 62.0"
                        class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] text-xs font-bold text-[#172A39] rounded-xl focus:outline-none focus:border-[#172A39] focus:bg-white"
                    />
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="btn-navy-pill w-full py-3 text-xs uppercase tracking-wider cursor-pointer border-0 shadow-md"
                    >
                        Simpan Ukuran
                    </button>
                </div>
            </form>
        </div>

        <!-- TABLE COLUMN -->
        <div class="lg:col-span-2 admin-card-rich overflow-hidden">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr style="background:#172A39;color:#FAF8F5;" class="text-[10px] font-black tracking-wider uppercase">
                        <th class="px-6 py-4">UKURAN</th>
                        <th class="px-6 py-4">PANJANG (CM)</th>
                        <th class="px-6 py-4">LEBAR (CM)</th>
                        <th class="px-6 py-4">LENGAN (CM)</th>
                        <th class="px-6 py-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD6D0] bg-white">
                    @forelse ($sizes as $size)
                        <tr class="admin-table-row">
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-[#FAF8F5] border border-[#DCD6D0] rounded-lg font-black text-sm text-[#172A39]">
                                    {{ $size->nama_ukuran }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-[#172A39]">{{ $size->panjang ? $size->panjang . ' cm' : '-' }}</td>
                            <td class="px-6 py-4 font-bold text-[#172A39]">{{ $size->lebar ? $size->lebar . ' cm' : '-' }}</td>
                            <td class="px-6 py-4 font-bold text-[#172A39]">{{ $size->panjang_lengan ? $size->panjang_lengan . ' cm' : '-' }}</td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <form action="{{ route('admin.ukuran.destroy', $size->id_ukuran) }}" method="POST" onsubmit="return confirm('Hapus ukuran {{ $size->nama_ukuran }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition-colors font-bold cursor-pointer border-0 bg-transparent"
                                        title="Hapus Ukuran"
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
                            <td colspan="5" class="px-6 py-8 text-center text-[#6E7575] font-medium">
                                Belum ada spesifikasi ukuran di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
