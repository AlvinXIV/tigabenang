@extends('layouts.auth')

@section('title', 'Masuk Admin')

@section('content')
<div
    class="w-full flex flex-col items-center"
    x-data="{
        email: '{{ old('email', '') }}',
        password: '',
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
                this.errors.password = 'Kata sandi tidak boleh kosong.';
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
    <!-- Brand Emblem & Identity (Official Customer Portal Asset) -->
    <div class="flex flex-col items-center justify-center mb-5 select-none text-center">
        <div class="w-12 h-12 rounded-[12px] border border-[#E2E5E9] bg-white flex items-center justify-center shadow-xs mb-2.5 overflow-hidden">
            <img
                src="{{ asset('images/clothiq-logo.png') }}?v=3"
                alt="Logo Tigabenang"
                width="36"
                height="36"
                class="h-[78%] w-[78%] object-contain select-none"
            />
        </div>
        <span class="text-base font-bold tracking-tight text-[#102A43]">Tigabenang</span>
        <span class="text-[11px] text-[#667085] font-medium tracking-normal mt-0.5">Konveksi &amp; Atelier Digital</span>
    </div>

    <!-- Portal Title & Subtitle -->
    <div class="text-center max-w-sm mx-auto mb-5">
        <h1 class="text-2xl sm:text-[26px] font-bold text-[#102A43] tracking-tight m-0">Admin Portal Tigabenang</h1>
        <p class="text-sm text-[#667085] mt-1.5 leading-relaxed m-0">
            Masuk untuk mengelola katalog produk, pesanan garmen, dan konfigurasi atelier.
        </p>
    </div>

    <!-- Login Card Container (Max-Width 420px, Natural Height, Centered) -->
    <div class="auth-card">
        
        <!-- Feedback notifications -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-xs font-medium text-emerald-800 rounded-lg flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-xs font-medium text-rose-800 rounded-lg flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" @submit="handleSubmit($event)" class="space-y-4 m-0">
            @csrf

            <!-- Username Field -->
            <div>
                <label for="email" class="block text-xs font-semibold text-[#102A43] mb-1.5">
                    Username <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#98A2B3]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        x-model="email"
                        @blur="validateEmail()"
                        @input="if(errors.email) validateEmail()"
                        placeholder="Masukkan username"
                        autocomplete="username"
                        required
                        class="auth-input pl-10 pr-3.5"
                    />
                </div>
                <template x-if="errors.email">
                    <p class="text-xs text-rose-600 mt-1 font-medium" x-text="errors.email"></p>
                </template>
                @error('email')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-xs font-semibold text-[#102A43] mb-1.5">
                    Kata Sandi <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#98A2B3]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        type="password"
                        id="password"
                        name="password"
                        x-model="password"
                        @blur="validatePassword()"
                        @input="if(errors.password) validatePassword()"
                        placeholder="Masukkan kata sandi"
                        autocomplete="current-password"
                        required
                        class="auth-input pl-10 pr-11"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#98A2B3] hover:text-[#102A43] transition-colors focus:outline-none cursor-pointer bg-transparent border-0"
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
                @error('password')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button (Always clearly visible, #102A43 with white text, server-rendered fallback) -->
            <div class="pt-2">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="auth-btn-primary"
                >
                    <svg x-show="isSubmitting" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Memverifikasi...' : 'Masuk'">Masuk</span>
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
