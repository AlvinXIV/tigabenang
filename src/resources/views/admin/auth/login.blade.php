@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<div
    class="w-full flex flex-col items-center"
    x-data="{
        email: 'vendor@example.com',
        password: 'password123',
        showPassword: false,
        isSubmitting: false,
        errors: {
            email: '',
            password: ''
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
            if (!this.password || !this.password.trim()) {
                this.errors.password = 'Password cannot be empty.';
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
            // Native form submits or simulation
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
    <div class="text-center max-w-md mx-auto mb-8">
        <h1 class="text-3xl sm:text-4xl font-normal text-[#1C1917] tracking-tight">Tigabenang</h1>
        <h2 class="text-xl sm:text-2xl font-normal text-[#292524] tracking-tight mt-1">Vendor Management Portal</h2>
        <p class="text-xs sm:text-sm text-[#78716C] mt-2.5 leading-relaxed">
            Manage your products, orders, materials, and production.
        </p>
    </div>

    <!-- Login Card Container -->
    <div class="w-full max-w-md bg-white border border-[#EADACE] shadow-[0_4px_24px_rgba(0,0,0,0.015)] p-8 sm:p-12">
        
        <!-- Feedback messages if any -->
        @if (session('success'))
            <div class="mb-6 p-3.5 bg-[#FBF6EE] border border-[#E5D7CA] text-xs text-[#8A4222] flex items-center gap-2">
                <svg class="w-4 h-4 text-[#B85331] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" @submit="handleSubmit($event)" class="space-y-6">
            @csrf

            <!-- Email Address Field -->
            <div>
                <label for="email" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-2">
                    EMAIL ADDRESS
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#A89A8E]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        x-model="email"
                        @blur="validateEmail()"
                        @input="if(errors.email) validateEmail()"
                        placeholder="vendor@example.com"
                        :class="errors.email ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-400' : 'border-[#D9CCC1] focus:border-[#B85331] focus:ring-[#B85331]'"
                        class="w-full pl-10 pr-3.5 py-3 bg-white border text-xs sm:text-sm text-[#292524] placeholder-[#C2B5A9] rounded-none focus:outline-none focus:ring-1 transition-colors"
                    />
                </div>
                <template x-if="errors.email">
                    <p class="text-[11px] text-rose-600 mt-1.5 flex items-center gap-1 font-sans" x-text="errors.email"></p>
                </template>
            </div>

            <!-- Password Field -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        PASSWORD
                    </label>
                    <a href="#" class="text-xs text-[#78716C] hover:text-[#B85331] transition-colors">
                        Forgot password?
                    </a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#A89A8E]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
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
                        :class="errors.password ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-400' : 'border-[#D9CCC1] focus:border-[#B85331] focus:ring-[#B85331]'"
                        class="w-full pl-10 pr-10 py-3 bg-white border text-xs sm:text-sm text-[#292524] placeholder-[#C2B5A9] rounded-none focus:outline-none focus:ring-1 transition-colors tracking-widest"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#A89A8E] hover:text-[#786C62] transition-colors focus:outline-none"
                    >
                        <!-- Eye icon (Show) -->
                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <!-- Eye-off icon (Hide) -->
                        <svg x-show="showPassword" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                        </svg>
                    </button>
                </div>
                <template x-if="errors.password">
                    <p class="text-[11px] text-rose-600 mt-1.5 flex items-center gap-1 font-sans" x-text="errors.password"></p>
                </template>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="w-full py-3.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] disabled:opacity-75 disabled:cursor-not-allowed text-white text-sm font-normal tracking-wide transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg x-show="isSubmitting" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Signing in...' : 'Sign in'"></span>
                </button>
            </div>
        </form>

    </div>

    <!-- Bottom Navigation Link -->
    <div class="mt-8 text-center text-xs sm:text-sm text-[#78716C]">
        <span>Don't have an account?</span>
        <a href="{{ route('register') }}" class="text-[#B85331] hover:underline font-medium ml-1 transition-colors">
            Create an account
        </a>
    </div>

</div>
@endsection
