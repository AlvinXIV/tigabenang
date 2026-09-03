@extends('layouts.auth')

@section('title', 'Masuk Portal')

@section('content')
<div
    class="w-full flex flex-col items-center"
    x-data="{
        email: 'admin',
        password: 'password',
        showPassword: false,
        isSubmitting: false,
        errors: {
            email: '',
            password: ''
        },
        validateEmail() {
            if (!this.email || !this.email.trim()) {
                this.errors.email = 'Username wajib diisi.';
                return false;
            }
            this.errors.email = '';
            return true;
        },
        validatePassword() {
            if (!this.password || !this.password.trim()) {
                this.errors.password = 'Password tidak boleh kosong.';
                return false;
            }
            this.errors.password = '';
            return true;
        },
        handleSubmit(e) {
            const emailValid = this.validateEmail();
            const passValid = this.validatePassword();

            if (!emailValid || !passValid) {
                e.preventDefault();
                return false;
            }

            this.isSubmitting = true;
            return true;
        }
    }"
>
    <!-- Brand Emblem -->
    <div class="inline-flex flex-col items-center justify-center mb-6 select-none">
        <div class="w-12 h-12 bg-[#B8664A] text-white rounded-xl flex items-center justify-center font-bold text-base shadow-xs mb-2.5">
            TB
        </div>
        <span class="text-sm font-bold tracking-tight text-[#1C2430]">Tigabenang</span>
        <span class="text-[11px] text-[#667085] font-medium">Konveksi &amp; Atelier Digital</span>
    </div>

    <!-- Portal Title & Subtitle -->
    <div class="text-center max-w-md mx-auto mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-[#1C2430] tracking-tight">Tigabenang Vendor Portal</h1>
        <p class="text-xs text-[#667085] mt-1 leading-relaxed">
            Masuk untuk mengelola katalog produk, pesanan garmen, dan konfigurasi bengkel.
        </p>
    </div>

    <!-- Login Card Container -->
    <div class="w-full max-w-md bg-white border border-[#E2E5E9] rounded-xl shadow-xs p-6 sm:p-8">
        
        <!-- Feedback messages if any -->
        @if (session('success'))
            <div class="mb-5 p-3 bg-emerald-50 border border-emerald-200 text-xs font-medium text-emerald-800 rounded-lg flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" @submit="handleSubmit($event)" class="space-y-4">
            @csrf

            <!-- Username Field -->
            <div>
                <label for="email" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                    Username Akun <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        x-model="email"
                        @blur="validateEmail()"
                        @input="if(errors.email) validateEmail()"
                        placeholder="admin"
                        class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                </div>
                <template x-if="errors.email">
                    <p class="text-xs text-rose-600 mt-1 font-medium" x-text="errors.email"></p>
                </template>
            </div>

            <!-- Password Field -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-semibold text-[#1C2430]">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        id="password"
                        name="password"
                        x-model="password"
                        @blur="validatePassword()"
                        @input="if(errors.password) validatePassword()"
                        placeholder="••••••••"
                        class="w-full pl-9 pr-10 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#98A2B3] hover:text-[#1C2430] transition-colors focus:outline-none cursor-pointer bg-transparent border-0"
                    >
                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg x-show="showPassword" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                        </svg>
                    </button>
                </div>
                <template x-if="errors.password">
                    <p class="text-xs text-rose-600 mt-1 font-medium" x-text="errors.password"></p>
                </template>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="w-full py-2.5 bg-[#B8664A] hover:bg-[#9A4E3A] active:bg-[#8A4330] disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2 cursor-pointer border-0 shadow-2xs"
                >
                    <svg x-show="isSubmitting" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Memverifikasi...' : 'Masuk ke Portal Vendor'"></span>
                </button>
            </div>
        </form>

    </div>

    <!-- Storefront Link -->
    <div class="mt-6 text-center text-xs text-[#6E7575]">
        <a href="{{ route('home') }}" class="text-[#1C2430] hover:text-[#B8664A] font-medium transition-colors text-decoration-none">
            &larr; Kembali ke Toko Tigabenang
        </a>
    </div>

</div>
@endsection

