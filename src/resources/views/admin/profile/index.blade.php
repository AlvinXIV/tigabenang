@extends('layouts.admin')

@section('title', 'Settings & Vendor Profile')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto" x-data="{ activeTab: 'profile' }">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & TABS                           -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Settings & Vendor Profile</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Manage your vendor brand identity, contact coordinates, and portal security.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                ACTIVE VENDOR
            </span>
        </div>
    </div>

    <!-- Tab Buttons -->
    <div class="flex items-center gap-6 border-b border-[#EADACE]/70 text-xs font-mono uppercase tracking-wider font-medium">
        <button
            type="button"
            @click="activeTab = 'profile'"
            :class="activeTab === 'profile' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-bold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer"
        >
            Vendor Identity & Contact
        </button>

        <button
            type="button"
            @click="activeTab = 'security'"
            :class="activeTab === 'security' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-bold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer"
        >
            Account Security & Password
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
            <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
                <div>
                    <h2 class="text-base font-medium text-[#1C1917]">Brand Information</h2>
                    <p class="text-xs text-[#78716C] mt-0.5">Your official business name and public catalog description.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label for="company_name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            VENDOR / COMPANY NAME <span class="text-[#B85331]">*</span>
                        </label>
                        <input
                            type="text"
                            name="company_name"
                            id="company_name"
                            value="{{ $profile['company_name'] }}"
                            required
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="tagline" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            SLOGAN / TAGLINE
                        </label>
                        <input
                            type="text"
                            name="tagline"
                            id="tagline"
                            value="{{ $profile['tagline'] }}"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            BUSINESS PROFILE DESCRIPTION
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                        >{{ $profile['description'] }}</textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Official Contact & Workshop Coordinates -->
            <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
                <div>
                    <h2 class="text-base font-medium text-[#1C1917]">Contact & Workshop Coordinates</h2>
                    <p class="text-xs text-[#78716C] mt-0.5">Used for customer WhatsApp inquiries, official invoices, and order communications.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label for="whatsapp" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            WHATSAPP HOTLINE <span class="text-[#B85331]">*</span>
                        </label>
                        <input
                            type="text"
                            name="whatsapp"
                            id="whatsapp"
                            value="{{ $profile['whatsapp'] }}"
                            required
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="email" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            OFFICIAL EMAIL <span class="text-[#B85331]">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ $profile['email'] }}"
                            required
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="phone" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            OFFICE PHONE
                        </label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            value="{{ $profile['phone'] }}"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            GARMENT WORKSHOP / FACTORY ADDRESS <span class="text-[#B85331]">*</span>
                        </label>
                        <textarea
                            name="address"
                            id="address"
                            rows="2"
                            required
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                        >{{ $profile['address'] }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#EADACE]/70">
                <button
                    type="submit"
                    class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer"
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
            <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
                <div>
                    <h2 class="text-base font-medium text-[#1C1917]">Account Credentials</h2>
                    <p class="text-xs text-[#78716C] mt-0.5">Authentication and login credentials for this vendor portal.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            LOGIN EMAIL
                        </label>
                        <input
                            type="text"
                            disabled
                            value="{{ $profile['email'] }}"
                            class="w-full px-3.5 py-2.5 bg-[#FAF7F2] border border-[#D9CCC1] text-xs sm:text-sm text-[#78716C] font-mono rounded-none cursor-not-allowed font-medium"
                        />
                    </div>

                    <div>
                        <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            CURRENT ROLE
                        </label>
                        <input
                            type="text"
                            disabled
                            value="Vendor Administrator"
                            class="w-full px-3.5 py-2.5 bg-[#FAF7F2] border border-[#D9CCC1] text-xs sm:text-sm text-[#78716C] rounded-none cursor-not-allowed font-medium"
                        />
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
                <div>
                    <h2 class="text-base font-medium text-[#1C1917]">Change Password</h2>
                    <p class="text-xs text-[#78716C] mt-0.5">Ensure your account is using a long, random password to stay secure.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-2">
                    <div>
                        <label for="current_password" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            CURRENT PASSWORD
                        </label>
                        <input
                            type="password"
                            name="current_password"
                            id="current_password"
                            placeholder="••••••••"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="new_password" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            NEW PASSWORD
                        </label>
                        <input
                            type="password"
                            name="new_password"
                            id="new_password"
                            placeholder="••••••••"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            CONFIRM PASSWORD
                        </label>
                        <input
                            type="password"
                            name="new_password_confirmation"
                            id="new_password_confirmation"
                            placeholder="••••••••"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>
                </div>
            </div>

            <!-- Submit Button & Logout -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-[#EADACE]/70">
                <a
                    href="{{ route('login') }}"
                    class="text-xs font-mono font-medium text-rose-700 hover:underline uppercase tracking-wider"
                >
                    Log Out of Session &rarr;
                </a>

                <button
                    type="submit"
                    class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer"
                >
                    Update Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
