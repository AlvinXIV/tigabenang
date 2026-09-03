@extends('layouts.admin')

@section('title', 'Ubah Spesifikasi Ukuran')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <a href="{{ route('admin.ukuran.index') }}" class="text-xs text-[#667085] hover:text-[#B8664A] inline-flex items-center gap-1.5 mb-2 transition-colors text-decoration-none font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Standar Ukuran</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">Ubah Spesifikasi Ukuran</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Perbarui dimensi pola potong pakaian: {{ $ukuran->nama_ukuran }}.
            </p>
        </div>
    </div>

    <form
        action="{{ route('admin.ukuran.update', $ukuran->id_ukuran) }}"
        method="POST"
        class="admin-card p-6 sm:p-8 space-y-5"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="kategori_id" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                Kategori Produk <span class="text-rose-500">*</span>
            </label>
            <select
                id="kategori_id"
                name="kategori_id"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
            >
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id_kategori }}" {{ old('kategori_id', $ukuran->kategori_id) == $cat->id_kategori ? 'selected' : '' }}>
                        {{ $cat->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id')
                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nama_ukuran" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                Label Ukuran <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="nama_ukuran"
                name="nama_ukuran"
                value="{{ old('nama_ukuran', $ukuran->nama_ukuran) }}"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
            />
            @error('nama_ukuran')
                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="lebar_dada" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                    Lebar Dada (cm)
                </label>
                <input
                    type="number"
                    step="0.1"
                    id="lebar_dada"
                    name="lebar_dada"
                    value="{{ old('lebar_dada', $ukuran->lebar_dada) }}"
                    placeholder="54.0"
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <div>
                <label for="panjang" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                    Panjang Badan (cm)
                </label>
                <input
                    type="number"
                    step="0.1"
                    id="panjang"
                    name="panjang"
                    value="{{ old('panjang', $ukuran->panjang) }}"
                    placeholder="68.0"
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <div>
                <label for="lebar_bahu" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                    Lebar Bahu (cm)
                </label>
                <input
                    type="number"
                    step="0.1"
                    id="lebar_bahu"
                    name="lebar_bahu"
                    value="{{ old('lebar_bahu', $ukuran->lebar_bahu) }}"
                    placeholder="48.0"
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <div>
                <label for="panjang_lengan" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                    Panjang Lengan (cm)
                </label>
                <input
                    type="number"
                    step="0.1"
                    id="panjang_lengan"
                    name="panjang_lengan"
                    value="{{ old('panjang_lengan', $ukuran->panjang_lengan) }}"
                    placeholder="62.0"
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E2E5E9]">
            <a
                href="{{ route('admin.ukuran.index') }}"
                class="btn-secondary px-4 py-2 text-xs sm:text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                :disabled="isSubmitting"
                class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium"
            >
                <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
            </button>
        </div>

    </form>

</div>
@endsection

