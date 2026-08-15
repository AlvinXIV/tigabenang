@extends('layouts.admin')

@section('title', 'Tambah Produk Pakaian')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="space-y-6 max-w-4xl">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Formulir Produk Baru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi detail spesifikasi bahan kain, harga estimasi, dan foto produk pakaian vendor.</p>
        </div>
        <x-button variant="outline" size="sm" href="{{ route('admin.produk.index') }}">
            &larr; Kembali ke Katalog
        </x-button>
    </div>

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <x-card title="Informasi Dasar Produk" subtitle="Nama, kategori, dan deskripsi pakaian">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-input label="Nama Produk Pakaian" name="name" placeholder="Contoh: Jaket Coach Taslan Waterproof" required />
                
                <x-input type="select" label="Kategori Pakaian" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </x-input>

                <x-input label="Spesifikasi Bahan Kain" name="material" placeholder="Contoh: Cotton Combed 24s / Taslan Milky" hint="Tuliskan jenis kain dan karakteristiknya" required />
                <x-input label="Pilihan Varian Warna" name="colors" placeholder="Hitam, Navy, Hijau Army, Maroon" hint="Pisahkan dengan koma" required />

                <x-input label="Estimasi Harga Satuan (Rp)" name="estimated_price" type="number" placeholder="185000" hint="Harga acuan sebelum kustomisasi jumlah" required />
                <x-input label="Minimal Pemesanan (Min. Order)" name="min_order" type="number" placeholder="24" hint="Dalam satuan pcs" required />

                <div class="md:col-span-2">
                    <x-input type="textarea" label="Deskripsi Detail Produk & Rekomendasi Penggunaan" name="description" rows="4" placeholder="Jelaskan keunggulan jahitan, ketebalan bahan, serta opsi sablon/bordir yang dapat diterapkan..." required />
                </div>
            </div>
        </x-card>

        <x-card title="Galeri Foto & Media Produk" subtitle="Unggah gambar produk pakaian untuk katalog">
            <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center bg-slate-50 hover:bg-slate-100/80 transition-colors cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="text-xs font-bold text-slate-800">Klik untuk upload atau drag and drop foto produk</p>
                <p class="text-[11px] text-slate-400 mt-1">Format PNG, JPG, WEBP maksimal 5MB per file</p>
                <input type="file" name="photos[]" multiple class="hidden" />
            </div>
        </x-card>

        <div class="flex items-center justify-end gap-3 pt-2">
            <x-button variant="secondary" href="{{ route('admin.produk.index') }}">Batal</x-button>
            <x-button type="submit" variant="primary" size="lg">
                Simpan & Terbitkan Produk
            </x-button>
        </div>
    </form>

</div>
@endsection
