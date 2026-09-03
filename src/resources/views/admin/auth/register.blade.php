@extends('layouts.auth')

@section('title', 'Daftar Akun Vendor')

@section('content')
<div
    class="w-full flex flex-col items-center"
    x-data="{
        fullName: '',
        businessName: '',
        email: '',
        phone: '',
        password: '',
        confirmPassword: '',
        termsAccepted: false,
        showPassword: false,
        showConfirmPassword: false,
        isSubmitting: false,
        errors: {
            fullName: '',
            email: '',
            password: '',
            confirmPassword: '',
            terms: ''
        },
        validateFullName() {
            if (!this.fullName || !this.fullName.trim()) {
                this.errors.fullName = 'Nama lengkap wajib diisi.';
                return false;
            } else if (this.fullName.trim().length < 2) {
                this.errors.fullName = 'Nama lengkap minimal 2 karakter.';
                return false;
            }
            this.errors.fullName = '';
            return true;
        },
        validateEmail() {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.email || !this.email.trim()) {
                this.errors.email = 'Alamat email wajib diisi.';
                return false;
            } else if (!re.test(this.email.trim())) {
                this.errors.email = 'Format alamat email tidak valid.';
                return false;
            }
            this.errors.email = '';
            return true;
        },
        validatePassword() {
            if (!this.password) {
                this.errors.password = 'Password wajib diisi.';
                return false;
            } else if (this.password.length < 6) {
                this.errors.password = 'Password minimal 6 karakter.';
                return false;
            }
            this.errors.password = '';
            if (this.confirmPassword) {
                this.validateConfirmPassword();
            }
            return true;
        },
        validateConfirmPassword() {
            if (!this.confirmPassword) {
                this.errors.confirmPassword = 'Konfirmasi password wajib diisi.';
                return false;
            } else if (this.confirmPassword !== this.password) {
                this.errors.confirmPassword = 'Password konfirmasi tidak cocok.';
                return false;
            }
            this.errors.confirmPassword = '';
            return true;
        },
        validateTerms() {
            if (!this.termsAccepted) {
                this.errors.terms = 'Anda harus menyetujui syarat & ketentuan layanan.';
                return false;
            }
            this.errors.terms = '';
            return true;
        },
        handleSubmit(e) {
            const nameValid = this.validateFullName();
            const emailValid = this.validateEmail();
            const passValid = this.validatePassword();
            const confirmValid = this.validateConfirmPassword();
            const termsValid = this.validateTerms();

            if (!nameValid || !emailValid || !passValid || !confirmValid || !termsValid) {
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
        <h1 class="text-xl sm:text-2xl font-bold text-[#1C2430] tracking-tight">Daftar Akun Vendor</h1>
        <p class="text-xs text-[#667085] mt-1 leading-relaxed">
            Daftarkan workshop atau usaha konveksi Anda ke sistem manajemen Tigabenang.
        </p>
    </div>

    <!-- Register Card Container -->
    <div class="w-full max-w-xl bg-white border border-[#E2E5E9] rounded-xl shadow-xs p-6 sm:p-8">
        
        <form action="{{ route('register') }}" method="POST" @submit="handleSubmit($event)" class="space-y-4">
            @csrf

            <!-- Row 1: Full Name & Business Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="fullName" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="fullName"
                        name="name"
                        x-model="fullName"
                        @blur="validateFullName()"
                        @input="if(errors.fullName) validateFullName()"
                        placeholder="Nama admin"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    <template x-if="errors.fullName">
                        <p class="text-xs text-rose-600 mt-1 font-medium" x-text="errors.fullName"></p>
                    </template>
                </div>

                <div>
                    <label for="businessName" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Nama Usaha / Konveksi
                    </label>
                    <input
                        type="text"
                        id="businessName"
                        name="business_name"
                        x-model="businessName"
                        placeholder="Contoh: CV Tigabenang Mandiri"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                </div>
            </div>

            <!-- Row 2: Email Address & Phone Number -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        x-model="email"
                        @blur="validateEmail()"
                        @input="if(errors.email) validateEmail()"
                        placeholder="admin@domain.com"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    <template x-if="errors.email">
                        <p class="text-xs text-rose-600 mt-1 font-medium" x-text="errors.email"></p>
                    </template>
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Nomor WhatsApp / HP
                    </label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        x-model="phone"
                        placeholder="08123456789"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                </div>
            </div>

            <!-- Row 3: Password & Confirm Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password"
                            x-model="password"
                            @blur="validatePassword()"
                            @input="if(errors.password) validatePassword()"
                            placeholder="••••••••"
                            class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#98A2B3] hover:text-[#1C2430] transition-colors focus:outline-none"
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

                <div>
                    <label for="confirmPassword" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            :type="showConfirmPassword ? 'text' : 'password'"
                            id="confirmPassword"
                            name="password_confirmation"
                            x-model="confirmPassword"
                            @blur="validateConfirmPassword()"
                            @input="if(errors.confirmPassword) validateConfirmPassword()"
                            placeholder="••••••••"
                            class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                        />
                        <button
                            type="button"
                            @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#98A2B3] hover:text-[#1C2430] transition-colors focus:outline-none"
                        >
                            <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showConfirmPassword" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                            </svg>
                        </button>
                    </div>
                    <template x-if="errors.confirmPassword">
                        <p class="text-xs text-rose-600 mt-1 font-medium" x-text="errors.confirmPassword"></p>
                    </template>
                </div>
            </div>

            <!-- Checkbox Terms of Service -->
            <div class="pt-1">
                <label class="flex items-start gap-2.5 cursor-pointer select-none">
                    <input
                        type="checkbox"
                        x-model="termsAccepted"
                        @change="validateTerms()"
                        class="mt-0.5 w-4 h-4 rounded border-[#D0D5DD] text-[#B8664A] focus:ring-[#B8664A]"
                    />
                    <span class="text-xs text-[#667085] leading-snug">
                        Saya menyetujui <a href="#" class="text-[#B8664A] hover:underline font-medium">Syarat &amp; Ketentuan</a> serta <a href="#" class="text-[#B8664A] hover:underline font-medium">Kebijakan Privasi</a> portal Tigabenang.
                    </span>
                </label>
                <template x-if="errors.terms">
                    <p class="text-xs text-rose-600 mt-1 font-medium" x-text="errors.terms"></p>
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
                    <span x-text="isSubmitting ? 'Memproses Pendaftaran...' : 'Daftarkan Akun Vendor'"></span>
                </button>
            </div>

            <!-- Divider Line inside card -->
            <div class="border-t border-[#E2E5E9] pt-4 text-center">
                <p class="text-xs text-[#667085]">
                    <span>Sudah memiliki akun vendor?</span>
                    <a href="{{ route('login') }}" class="text-[#B8664A] hover:underline font-medium ml-1 transition-colors">
                        Masuk di Sini
                    </a>
                </p>
            </div>

        </form>

    </div>

</div>
@endsection

