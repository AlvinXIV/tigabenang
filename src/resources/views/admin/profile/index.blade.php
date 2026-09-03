@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="space-y-6 max-w-4xl" x-data="{ changePassword: false }">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Pengaturan Akun</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Kelola profil administrator dan keamanan akses akun Tigabenang.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Administrator Aktif
            </span>
        </div>
    </div>

    <!-- MAIN SETTINGS FORM -->
    <form
        action="{{ route('admin.profile.update') }}"
        method="POST"
        class="space-y-6"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf
        @method('PUT')

        <!-- Hidden email fallback to satisfy backend ProfileController validation -->
        <input type="hidden" name="email" value="{{ old('email', $user->email ?? $profile['email']) }}" />

        <!-- SECTION 1: PROFIL ADMINISTRATOR -->
        <div class="admin-card p-5 sm:p-6 space-y-5">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Profil Administrator</h2>
                <p class="text-xs text-[#667085] mt-0.5">Informasi akun pengguna pengelola panel admin.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- ID Pengguna (Readonly) -->
                <div>
                    <label class="block text-xs font-semibold text-[#667085] uppercase tracking-wider mb-1.5">
                        ID Pengguna
                    </label>
                    <div class="px-3.5 py-2.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg text-xs sm:text-sm font-mono text-[#1C2430]">
                        #{{ $user->id_user ?? ($user->id ?? '1') }}
                    </div>
                </div>

                <!-- Username (Readonly) -->
                <div>
                    <label class="block text-xs font-semibold text-[#667085] uppercase tracking-wider mb-1.5">
                        Username
                    </label>
                    <div class="px-3.5 py-2.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg text-xs sm:text-sm font-mono text-[#1C2430]">
                        {{ $user->username ?? 'admin' }}
                    </div>
                </div>

                <!-- Nama Lengkap (Editable) -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $user->nama ?? ($user->name ?? $profile['name'])) }}"
                        required
                        class="w-full px-3.5 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="btn-primary px-4 py-2 text-xs sm:text-sm font-medium cursor-pointer"
                >
                    <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Profil'"></span>
                </button>
            </div>
        </div>

        <!-- SECTION 2: KEAMANAN & PASSWORD -->
        <div class="admin-card p-5 sm:p-6 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Keamanan Akses</h2>
                    <p class="text-xs text-[#667085] mt-0.5">Ubah kata sandi akun jika ingin memperbarui kredensial masuk.</p>
                </div>
                <button
                    type="button"
                    @click="changePassword = !changePassword"
                    class="btn-secondary px-3 py-1.5 text-xs cursor-pointer"
                >
                    <span x-text="changePassword ? 'Tutup Form' : 'Ganti Password'"></span>
                </button>
            </div>

            <div x-show="changePassword" x-transition class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label for="password" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Kata Sandi Baru (Minimal 8 Karakter)
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                </div>

                <div class="sm:col-span-2 flex justify-end pt-2">
                    <button
                        type="submit"
                        :disabled="isSubmitting"
                        class="btn-primary px-4 py-2 text-xs sm:text-sm font-medium cursor-pointer"
                    >
                        Perbarui Password
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- SECTION 3: KELUAR DARI SISTEM -->
    <div class="admin-card p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-rose-200">
        <div>
            <h3 class="text-sm font-semibold text-[#1C2430]">Keluar dari Panel Admin</h3>
            <p class="text-xs text-[#667085] mt-0.5">Akhiri sesi administrator Anda saat ini di peramban ini.</p>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="px-4 py-2 rounded-lg border border-rose-300 text-rose-700 bg-rose-50 hover:bg-rose-100 text-xs font-medium transition-colors cursor-pointer"
            >
                Keluar (Logout)
            </button>
        </form>
    </div>

</div>
@endsection
