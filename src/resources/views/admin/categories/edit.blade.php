@extends('layouts.admin')

@section('title', 'Ubah ' . ($kategori ? 'Kategori Produk' : 'Material Kain'))

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">

    <!-- TOP HEADER -->
    <div class="pb-5 border-b border-[#E2E5E9]">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">
            Ubah {{ $kategori ? 'Kategori Produk' : 'Material Kain' }}
        </h1>
        <p class="text-xs sm:text-sm text-[#667085] mt-1">
            Perbarui nama taksonomi busana atelier.
        </p>
    </div>

    <form
        id="category-edit-form"
        action="{{ route('admin.kategori.update', $kategori ? $kategori->id_kategori : $bahan->id_bahan) }}"
        method="POST"
        class="admin-card p-6 sm:p-8 space-y-5"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf
        @method('PUT')

        @if ($bahan)
            <input type="hidden" name="type" value="bahan" />
            <div>
                <label for="nama_bahan" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                    Nama Material Kain <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama_bahan"
                    name="nama_bahan"
                    value="{{ old('nama_bahan', $bahan->nama_bahan) }}"
                    required
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
                @error('nama_bahan')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
        @else
            <div>
                <label for="nama_kategori" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                    Nama Kategori Produk <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama_kategori"
                    name="nama_kategori"
                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                    required
                    class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
                @error('nama_kategori')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <div class="flex justify-end gap-3 pt-4 border-t border-[#E2E5E9]">
            <a
                href="{{ $bahan ? route('admin.kategori.index', ['tab' => 'material']) . '#material' : route('admin.kategori.index') }}"
                class="btn-secondary px-4 py-2 text-xs sm:text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                :disabled="isSubmitting"
                class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium cursor-pointer"
            >
                <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
            </button>
        </div>
    </form>

</div>
@endsection
