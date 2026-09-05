@extends('layouts.admin')

@section('title', 'Tambah Ukuran Pola')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">

    <div class="pb-5 border-b border-[#E2E5E9]">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">Tambah Ukuran Baru</h1>
        <p class="text-xs sm:text-sm text-[#667085] mt-1">
            Tentukan kategori pakaian dan spesifikasi ukuran dalam satuan cm.
        </p>
    </div>

    <form
        id="size-create-form"
        action="{{ route('admin.ukuran.store') }}"
        method="POST"
        class="admin-card p-6 sm:p-8 space-y-5"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf

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
                <option value="" disabled selected>Pilih Kategori...</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id_kategori }}" {{ old('kategori_id') == $cat->id_kategori ? 'selected' : '' }}>
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
                value="{{ old('nama_ukuran') }}"
                required
                placeholder="Contoh: S, M, L, XL, XXL, 32"
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
                    value="{{ old('lebar_dada') }}"
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
                    value="{{ old('panjang') }}"
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
                    value="{{ old('lebar_bahu') }}"
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
                    value="{{ old('panjang_lengan') }}"
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
                <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Ukuran'"></span>
            </button>
        </div>

    </form>

</div>
@endsection

