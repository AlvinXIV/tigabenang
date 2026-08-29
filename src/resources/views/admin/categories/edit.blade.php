@extends('layouts.admin')

@section('title', 'Edit Category / Material')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.kategori.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-mono font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Materials & Categories</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">
                Edit {{ $kategori ? 'Kategori' : 'Material Kain' }}
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.kategori.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="category-edit-form"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase shadow-xs cursor-pointer"
            >
                Save Changes
            </button>
        </div>
    </div>

    <form id="category-edit-form" action="{{ route('admin.kategori.update', $kategori ? $kategori->id_kategori : $bahan->id_bahan) }}" method="POST" class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        @if ($bahan)
            <input type="hidden" name="type" value="bahan" />
            <div>
                <label for="nama_bahan" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                    NAMA MATERIAL KAIN <span class="text-[#B85331]">*</span>
                </label>
                <input
                    type="text"
                    id="nama_bahan"
                    name="nama_bahan"
                    value="{{ old('nama_bahan', $bahan->nama_bahan) }}"
                    required
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none"
                />
            </div>
        @else
            <div>
                <label for="nama_kategori" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                    NAMA KATEGORI PRODUK <span class="text-[#B85331]">*</span>
                </label>
                <input
                    type="text"
                    id="nama_kategori"
                    name="nama_kategori"
                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                    required
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none"
                />
            </div>
        @endif

        <div class="flex justify-end gap-3 pt-4 border-t border-[#EADACE]">
            <button
                type="submit"
                class="px-6 py-2.5 bg-[#B85331] text-white text-xs font-mono font-medium uppercase hover:bg-[#A34524]"
            >
                Save Changes
            </button>
        </div>
    </form>

</div>
@endsection
