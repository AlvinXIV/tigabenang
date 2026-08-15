@extends('layouts.admin')

@section('title', 'Profil Vendor & Perusahaan')
@section('page-title', 'Identitas & Informasi Perusahaan')

@section('content')
<div class="space-y-8 max-w-5xl">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Profil Vendor Tigabenang</h2>
            <p class="text-xs text-slate-500 mt-0.5">Informasi perusahaan ini akan ditampilkan pada Landing Page publik, About Us, dan dokumen invoice resmi.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-semibold border border-emerald-200 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Profil Aktif & Terverifikasi
            </span>
        </div>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Identitas Utama Perusahaan -->
        <x-card title="1. Informasi Utama Perusahaan" subtitle="Nama vendor, tagline resmi, dan deskripsi bisnis konveksi">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-input label="Nama Perusahaan / Brand Vendor" name="company_name" value="{{ $profile['company_name'] }}" required />
                <x-input label="Slogan / Tagline" name="tagline" value="{{ $profile['tagline'] }}" />
                <div class="md:col-span-2">
                    <x-input type="textarea" label="Deskripsi Profil Bisnis" name="description" rows="4" required>{{ $profile['description'] }}</x-input>
                </div>
            </div>
        </x-card>

        <!-- Visi & Misi Perusahaan (SDG 8 Aligned) -->
        <x-card title="2. Visi & Misi Bisnis" subtitle="Pernyataan visi misi perusahaan dan komitmen pengembangan UMKM">
            <div class="space-y-5">
                <x-input type="textarea" label="Visi Perusahaan" name="vision" rows="2" required>{{ $profile['vision'] }}</x-input>
                <x-input type="textarea" label="Misi Perusahaan" name="mission" rows="4" required>{{ $profile['mission'] }}</x-input>
            </div>
        </x-card>

        <!-- Kontak & Alamat Workshop -->
        <x-card title="3. Kontak Resmi & Workshop Konveksi" subtitle="Nomor kontak untuk pemesanan kustom dan lokasi workshop">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-input label="Nomor WhatsApp Hotline" name="whatsapp" value="{{ $profile['whatsapp'] }}" hint="Digunakan untuk tombol langsung hubungi vendor di katalog" required />
                <x-input label="Email Resmi" name="email" type="email" value="{{ $profile['email'] }}" required />
                <x-input label="Nomor Telepon Kantor" name="phone" value="{{ $profile['phone'] }}" />
                <x-input label="Akun Instagram" name="instagram" value="{{ $profile['instagram'] }}" />
                <div class="md:col-span-2">
                    <x-input type="textarea" label="Alamat Lengkap Workshop / Pabrik Garmen" name="address" rows="3" required>{{ $profile['address'] }}</x-input>
                </div>
            </div>
        </x-card>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <x-button variant="secondary" href="{{ route('admin.dashboard') }}">Batal</x-button>
            <x-button type="submit" variant="primary" size="lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Simpan Perubahan Profil</span>
            </x-button>
        </div>

    </form>

</div>
@endsection
