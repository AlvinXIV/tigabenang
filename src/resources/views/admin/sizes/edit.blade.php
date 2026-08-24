@extends('layouts.admin')

@section('title', 'Edit Size Spec')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.ukuran.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-mono font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Size Charts</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Edit Size Specification</h1>
        </div>
    </div>

    <form action="{{ route('admin.ukuran.update', $ukuran->id_ukuran) }}" method="POST" class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div>
            <label for="kategori_id" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                KATEGORI <span class="text-[#B85331]">*</span>
            </label>
            <select
                id="kategori_id"
                name="kategori_id"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
            >
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id_kategori }}" {{ old('kategori_id', $ukuran->kategori_id) == $cat->id_kategori ? 'selected' : '' }}>
                        {{ $cat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="nama_ukuran" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                NAMA UKURAN <span class="text-[#B85331]">*</span>
            </label>
            <input
                type="text"
                id="nama_ukuran"
                name="nama_ukuran"
                value="{{ old('nama_ukuran', $ukuran->nama_ukuran) }}"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
            />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="lebar_dada" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                    LEBAR DADA (CM)
                </label>
                <input
                    type="number"
                    step="0.01"
                    id="lebar_dada"
                    name="lebar_dada"
                    value="{{ old('lebar_dada', $ukuran->lebar_dada) }}"
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] font-mono text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                />
            </div>

            <div>
                <label for="panjang" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                    PANJANG (CM)
                </label>
                <input
                    type="number"
                    step="0.01"
                    id="panjang"
                    name="panjang"
                    value="{{ old('panjang', $ukuran->panjang) }}"
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] font-mono text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                />
            </div>

            <div>
                <label for="lebar_bahu" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                    LEBAR BAHU (CM)
                </label>
                <input
                    type="number"
                    step="0.01"
                    id="lebar_bahu"
                    name="lebar_bahu"
                    value="{{ old('lebar_bahu', $ukuran->lebar_bahu) }}"
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] font-mono text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                />
            </div>

            <div>
                <label for="panjang_lengan" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                    PANJANG LENGAN (CM)
                </label>
                <input
                    type="number"
                    step="0.01"
                    id="panjang_lengan"
                    name="panjang_lengan"
                    value="{{ old('panjang_lengan', $ukuran->panjang_lengan) }}"
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] font-mono text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                />
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]">
            <a
                href="{{ route('admin.ukuran.index') }}"
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
