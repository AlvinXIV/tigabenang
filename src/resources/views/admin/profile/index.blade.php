@extends('layouts.admin')

@section('title', 'Settings & Vendor Profile')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto" x-data="{ activeTab: 'profile' }">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & TABS                           -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#FAF8F5] border border-[#DCD6D0] rounded-full text-[11px] font-extrabold uppercase tracking-widest text-[#172A39] mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#172A39]"></span>
                Atelier Configuration
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#172A39] tracking-tight">Settings &amp; Vendor Profile</h1>
            <p class="text-xs sm:text-sm text-[#6E7575] mt-1">
                Kelola identitas vendor Clothiq, hotline kontak WhatsApp, dan keamanan portal.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full">
                ACTIVE VENDOR
            </span>
        </div>
    </div>

    <!-- Tab Buttons -->
    <div class="flex items-center gap-6 border-b border-[#DCD6D0] text-xs uppercase tracking-wider font-bold">
        <button
            type="button"
            @click="activeTab = 'profile'"
            :class="activeTab === 'profile' ? 'border-b-2 border-[#172A39] text-[#172A39]' : 'text-[#6E7575] hover:text-[#172A39] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer bg-transparent border-t-0 border-x-0"
        >
            Vendor Identity &amp; Contact
        </button>

        <button
            type="button"
            @click="activeTab = 'security'"
            :class="activeTab === 'security' ? 'border-b-2 border-[#172A39] text-[#172A39]' : 'text-[#6E7575] hover:text-[#172A39] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer bg-transparent border-t-0 border-x-0"
        >
            Account Security &amp; Password
        </button>
    </div>

    <!-- ============================================== -->
    <!-- TAB 1: VENDOR PROFILE & CONTACT                -->
    <!-- ============================================== -->
    <div x-show="activeTab === 'profile'" class="space-y-8">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-8 max-w-4xl">
            @csrf
            @method('PUT')

            <!-- SECTION 1: Brand Details -->
            <div class="admin-card p-6 sm:p-8 space-y-6">
                <div>
                    <h2 class="text-base font-bold text-[#172A39]">Brand Information</h2>
                    <p class="text-xs text-[#6E7575] mt-0.5">Nama resmi bisnis pakaian atelier dan deskripsi profil publik.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label for="company_name" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            VENDOR / COMPANY NAME <span class="text-rose-600">*</span>
                        </label>
                        <input
                            type="text"
                            name="company_name"
                            id="company_name"
                            value="{{ $profile['company_name'] }}"
                            required
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-bold text-[#172A39] rounded-xl focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="tagline" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            SLOGAN / TAGLINE
                        </label>
                        <input
                            type="text"
                            name="tagline"
                            id="tagline"
                            value="{{ $profile['tagline'] }}"
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-bold text-[#172A39] rounded-xl focus:outline-none transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            BUSINESS PROFILE DESCRIPTION
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm text-[#172A39] rounded-xl focus:outline-none transition-colors leading-relaxed font-medium"
                        >{{ $profile['description'] }}</textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Official Contact & Workshop Coordinates -->
            <div class="admin-card p-6 sm:p-8 space-y-6">
                <div>
                    <h2 class="text-base font-bold text-[#172A39]">Contact &amp; Workshop Coordinates</h2>
                    <p class="text-xs text-[#6E7575] mt-0.5">Digunakan untuk hotline WhatsApp customer, faktur invoice resmi, dan pengiriman.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label for="whatsapp" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            WHATSAPP HOTLINE <span class="text-rose-600">*</span>
                        </label>
                        <input
                            type="text"
                            name="whatsapp"
                            id="whatsapp"
                            value="{{ $profile['whatsapp'] }}"
                            required
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-bold text-[#172A39] rounded-xl focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="email" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            OFFICIAL EMAIL <span class="text-rose-600">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ $profile['email'] }}"
                            required
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-bold text-[#172A39] rounded-xl focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="phone" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            OFFICE PHONE
                        </label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            value="{{ $profile['phone'] }}"
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-bold text-[#172A39] rounded-xl focus:outline-none transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            GARMENT WORKSHOP / FACTORY ADDRESS <span class="text-rose-600">*</span>
                        </label>
                        <textarea
                            name="address"
                            id="address"
                            rows="2"
                            required
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm text-[#172A39] rounded-xl focus:outline-none transition-colors leading-relaxed font-medium"
                        >{{ $profile['address'] }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#DCD6D0]">
                <button
                    type="submit"
                    class="admin-pill-btn px-7 py-2.5 bg-[#172A39] hover:bg-[#0E1B25] text-white text-xs font-bold uppercase tracking-wider whitespace-nowrap transition-all shadow-md shadow-[#172A39]/20 cursor-pointer border-0"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- ============================================== -->
    <!-- TAB 2: SECURITY & PASSWORD                     -->
    <!-- ============================================== -->
    <div x-show="activeTab === 'security'" style="display: none;" class="space-y-8">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-8 max-w-4xl">
            @csrf
            @method('PUT')

            <!-- Account Credentials -->
            <div class="admin-card p-6 sm:p-8 space-y-6">
                <div>
                    <h2 class="text-base font-bold text-[#172A39]">Account Credentials</h2>
                    <p class="text-xs text-[#6E7575] mt-0.5">Authentication and login credentials for this atelier vendor portal.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            LOGIN EMAIL / USERNAME
                        </label>
                        <input
                            type="text"
                            disabled
                            value="{{ $profile['email'] }}"
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] text-xs sm:text-sm text-[#6E7575] rounded-xl cursor-not-allowed font-bold"
                        />
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            CURRENT ROLE
                        </label>
                        <input
                            type="text"
                            disabled
                            value="Atelier Administrator"
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] text-xs sm:text-sm text-[#6E7575] rounded-xl cursor-not-allowed font-bold"
                        />
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="admin-card p-6 sm:p-8 space-y-6">
                <div>
                    <h2 class="text-base font-bold text-[#172A39]">Change Password</h2>
                    <p class="text-xs text-[#6E7575] mt-0.5">Pastikan akun menggunakan password yang kuat dan aman.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-2">
                    <div>
                        <label for="current_password" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            CURRENT PASSWORD
                        </label>
                        <input
                            type="password"
                            name="current_password"
                            id="current_password"
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm text-[#172A39] rounded-xl focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="new_password" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            NEW PASSWORD
                        </label>
                        <input
                            type="password"
                            name="new_password"
                            id="new_password"
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm text-[#172A39] rounded-xl focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-[11px] font-bold tracking-widest text-[#6E7575] uppercase mb-1.5">
                            CONFIRM PASSWORD
                        </label>
                        <input
                            type="password"
                            name="new_password_confirmation"
                            id="new_password_confirmation"
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm text-[#172A39] rounded-xl focus:outline-none transition-colors"
                        />
                    </div>
                </div>
            </div>

            <!-- Submit Button & Logout -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-[#DCD6D0]">
                <a
                    href="{{ route('login') }}"
                    class="text-xs font-bold text-rose-700 hover:underline uppercase tracking-wider text-decoration-none"
                >
                    Log Out of Session &rarr;
                </a>

                <button
                    type="submit"
                    class="admin-pill-btn px-7 py-2.5 bg-[#172A39] hover:bg-[#0E1B25] text-white text-xs font-bold uppercase tracking-wider whitespace-nowrap transition-all shadow-md shadow-[#172A39]/20 cursor-pointer border-0"
                >
                    Update Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
