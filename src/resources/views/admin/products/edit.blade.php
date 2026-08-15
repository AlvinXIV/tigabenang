@extends('layouts.admin')

@section('title', 'Edit Produk Pakaian')
@section('page-title', 'Edit Produk')

@section('content')
<div class="space-y-6 max-w-4xl">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Edit Produk: {{ $product['name'] }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui spesifikasi produk pakaian dan informasi harga estimasi.</p>
        </div>
        <x-button variant="outline" size="sm" href="{{ route('admin.produk.index') }}">
            &larr; Kembali ke Katalog
        </x-button>
    </div>

    <form action="{{ route('admin.produk.update', $product['id']) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <x-card title="Informasi Dasar Produk" subtitle="Nama, kategori, dan deskripsi pakaian">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-input label="Nama Produk Pakaian" name="name" value="{{ $product['name'] }}" required />
                
                <x-input type="select" label="Kategori Pakaian" name="category_id" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat['id'] }}" {{ $product['category_id'] == $cat['id'] ? 'selected' : '' }}>
                            {{ $cat['name'] }}
                        </option>
                    @endforeach
                </x-input>

                <x-input label="Spesifikasi Bahan Kain" name="material" value="{{ $product['material'] }}" required />
                <x-input label="Pilihan Varian Warna" name="colors" value="{{ $product['colors'] }}" required />

                <x-input label="Estimasi Harga Satuan (Rp)" name="estimated_price" type="number" value="{{ $product['estimated_price'] }}" required />
                <x-input label="Minimal Pemesanan (Min. Order)" name="min_order" type="number" value="{{ $product['min_order'] }}" required />

                <div class="md:col-span-2">
                    <x-input type="textarea" label="Deskripsi Detail Produk" name="description" rows="4" required>{{ $product['description'] }}</x-input>
                </div>
            </div>
        </x-card>

        <div class="flex items-center justify-end gap-3 pt-2">
            <x-button variant="secondary" href="{{ route('admin.produk.index') }}">Batal</x-button>
            <x-button type="submit" variant="primary" size="lg">
                Simpan Perubahan
            </x-button>
        </div>
    </form>

</div>
@endsection
