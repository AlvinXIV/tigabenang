@extends('layouts.auth')

@section('title', 'Create Account')

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
                this.errors.fullName = 'Full name is required.';
                return false;
            } else if (this.fullName.trim().length < 2) {
                this.errors.fullName = 'Full name must be at least 2 characters.';
                return false;
            }
            this.errors.fullName = '';
            return true;
        },
        validateEmail() {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.email || !this.email.trim()) {
                this.errors.email = 'Email address is required.';
                return false;
            } else if (!re.test(this.email.trim())) {
                this.errors.email = 'Please enter a valid email address.';
                return false;
            }
            this.errors.email = '';
            return true;
        },
        validatePassword() {
            if (!this.password) {
                this.errors.password = 'Password is required.';
                return false;
            } else if (this.password.length < 6) {
                this.errors.password = 'Password must be at least 6 characters.';
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
                this.errors.confirmPassword = 'Confirm password is required.';
                return false;
            } else if (this.confirmPassword !== this.password) {
                this.errors.confirmPassword = 'Passwords do not match.';
                return false;
            }
            this.errors.confirmPassword = '';
            return true;
        },
        validateTerms() {
            if (!this.termsAccepted) {
                this.errors.terms = 'You must agree to the Terms of Service & Privacy Policy.';
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
    <!-- Seamless Brand Emblem (No Card, Blends into Base Layer) -->
    <div class="inline-flex flex-col items-center justify-center mb-6 select-none">
        <svg class="w-12 h-12 text-[#B85331]" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Rounded decorative stitch frame -->
            <rect x="5" y="5" width="46" height="46" rx="14" stroke="#B85331" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <!-- 3 Woven Threads (Tiga Benang) & Stylized 't' 'b' monogram -->
            <path d="M19 17c0-2.5 2-4.5 4.5-4.5s4.5 2 4.5 4.5v19c0 3.5 2.8 6.5 6.5 6.5s6.5-3 6.5-6.5-2.8-6.5-6.5-6.5H18" stroke="#B85331" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M15 22.5h15" stroke="#B85331" stroke-width="2.2" stroke-linecap="round"/>
            <path d="M22 36c0 2.5 2 4.5 4.5 4.5s4.5-2 4.5-4.5-2-4.5-4.5-4.5-4.5 2-4.5 4.5z" stroke="#B85331" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
        <span class="text-[8.5px] font-mono font-bold tracking-[0.28em] text-[#B85331] uppercase mt-2">TIGABENANG</span>
    </div>

    <!-- Portal Title & Subtitle -->
    <div class="text-center max-w-lg mx-auto mb-8">
        <h1 class="text-3xl sm:text-4xl font-normal text-[#1C1917] tracking-tight leading-tight">
            Vendor Management<br class="hidden sm:inline"> Portal
        </h1>
        <p class="text-xs sm:text-sm text-[#78716C] mt-2.5 leading-relaxed max-w-sm mx-auto">
            Create your vendor account and start managing your business.
        </p>
    </div>

    <!-- Register Card Container -->
    <div class="w-full max-w-2xl bg-white border border-[#EADACE] shadow-[0_4px_24px_rgba(0,0,0,0.015)] p-8 sm:p-12">
        
        <h2 class="text-xl font-normal text-[#1C1917] mb-6">Create your account</h2>

        <form action="{{ route('register') }}" method="POST" @submit="handleSubmit($event)" class="space-y-5">
            @csrf

            <!-- Row 1: Full Name & Business Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div>
                    <label for="fullName" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        FULL NAME
                    </label>
                    <input
                        type="text"
                        id="fullName"
                        name="name"
                        x-model="fullName"
                        @blur="validateFullName()"
                        @input="if(errors.fullName) validateFullName()"
                        placeholder="Jane Doe"
                        :class="errors.fullName ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-400' : 'border-[#D9CCC1] focus:border-[#B85331] focus:ring-[#B85331]'"
                        class="w-full px-3.5 py-2.5 sm:py-3 bg-white border text-xs sm:text-sm text-[#292524] placeholder-[#C2B5A9] rounded-none focus:outline-none focus:ring-1 transition-colors"
                    />
                    <template x-if="errors.fullName">
                        <p class="text-[11px] text-rose-600 mt-1 font-sans" x-text="errors.fullName"></p>
                    </template>
                </div>

                <div>
                    <label for="businessName" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        BUSINESS / VENDOR NAME
                    </label>
                    <input
                        type="text"
                        id="businessName"
                        name="business_name"
                        x-model="businessName"
                        placeholder="Acme Textiles"
                        class="w-full px-3.5 py-2.5 sm:py-3 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] placeholder-[#C2B5A9] rounded-none focus:outline-none transition-colors"
                    />
                </div>
            </div>

            <!-- Row 2: Email Address & Phone Number -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div>
                    <label for="email" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        EMAIL ADDRESS
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        x-model="email"
                        @blur="validateEmail()"
                        @input="if(errors.email) validateEmail()"
                        placeholder="jane@example.com"
                        :class="errors.email ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-400' : 'border-[#D9CCC1] focus:border-[#B85331] focus:ring-[#B85331]'"
                        class="w-full px-3.5 py-2.5 sm:py-3 bg-white border text-xs sm:text-sm text-[#292524] placeholder-[#C2B5A9] rounded-none focus:outline-none focus:ring-1 transition-colors"
                    />
                    <template x-if="errors.email">
                        <p class="text-[11px] text-rose-600 mt-1 font-sans" x-text="errors.email"></p>
                    </template>
                </div>

                <div>
                    <label for="phone" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        PHONE NUMBER
                    </label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        x-model="phone"
                        placeholder="+1 (555) 000-0000"
                        class="w-full px-3.5 py-2.5 sm:py-3 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] placeholder-[#C2B5A9] rounded-none focus:outline-none transition-colors"
                    />
                </div>
            </div>

            <!-- Row 3: Password & Confirm Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div>
                    <label for="password" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        PASSWORD
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
                            :class="errors.password ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-400' : 'border-[#D9CCC1] focus:border-[#B85331] focus:ring-[#B85331]'"
                            class="w-full pl-3.5 pr-10 py-2.5 sm:py-3 bg-white border text-xs sm:text-sm text-[#292524] placeholder-[#C2B5A9] rounded-none focus:outline-none focus:ring-1 transition-colors tracking-widest"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#A89A8E] hover:text-[#786C62] transition-colors focus:outline-none"
                        >
                            <!-- Eye icon -->
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <!-- Eye off icon -->
                            <svg x-show="showPassword" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                            </svg>
                        </button>
                    </div>
                    <template x-if="errors.password">
                        <p class="text-[11px] text-rose-600 mt-1 font-sans" x-text="errors.password"></p>
                    </template>
                </div>

                <div>
                    <label for="confirmPassword" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CONFIRM PASSWORD
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
                            :class="errors.confirmPassword ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-400' : 'border-[#D9CCC1] focus:border-[#B85331] focus:ring-[#B85331]'"
                            class="w-full pl-3.5 pr-10 py-2.5 sm:py-3 bg-white border text-xs sm:text-sm text-[#292524] placeholder-[#C2B5A9] rounded-none focus:outline-none focus:ring-1 transition-colors tracking-widest"
                        />
                        <button
                            type="button"
                            @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#A89A8E] hover:text-[#786C62] transition-colors focus:outline-none"
                        >
                            <!-- Eye icon -->
                            <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <!-- Eye off icon -->
                            <svg x-show="showConfirmPassword" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                            </svg>
                        </button>
                    </div>
                    <template x-if="errors.confirmPassword">
                        <p class="text-[11px] text-rose-600 mt-1 font-sans" x-text="errors.confirmPassword"></p>
                    </template>
                </div>
            </div>

            <!-- Checkbox Terms of Service -->
            <div class="pt-2">
                <label class="flex items-start gap-2.5 cursor-pointer select-none">
                    <input
                        type="checkbox"
                        x-model="termsAccepted"
                        @change="validateTerms()"
                        class="mt-0.5 w-4 h-4 rounded-none border-[#D9CCC1] text-[#B85331] focus:ring-[#B85331]"
                    />
                    <span class="text-xs text-[#78716C] leading-snug">
                        I agree to the <a href="#" class="text-[#B85331] hover:underline">Terms of Service</a> and <a href="#" class="text-[#B85331] hover:underline">Privacy Policy</a>.
                    </span>
                </label>
                <template x-if="errors.terms">
                    <p class="text-[11px] text-rose-600 mt-1 font-sans" x-text="errors.terms"></p>
                </template>
            </div>

            <!-- Submit Button -->
            <div class="pt-3">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="w-full py-3.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] disabled:opacity-75 disabled:cursor-not-allowed text-white text-sm font-normal tracking-wide transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg x-show="isSubmitting" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Creating Account...' : 'Create Account'"></span>
                </button>
            </div>

            <!-- Divider Line inside card -->
            <div class="border-t border-[#F0E6DD] pt-6 text-center">
                <p class="text-xs sm:text-sm text-[#78716C]">
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-[#B85331] hover:underline font-medium ml-1 transition-colors">
                        Sign In
                    </a>
                </p>
            </div>

        </form>

    </div>

</div>
@endsection
