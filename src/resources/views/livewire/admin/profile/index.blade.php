<div class="space-y-6 max-w-4xl">

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

    <!-- FLASH NOTIFICATION -->
    @if ($feedbackMessage)
        <div class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button wire:click="dismissFeedback" class="text-emerald-600 hover:text-emerald-800 text-xs font-semibold">&times;</button>
        </div>
    @endif

    <!-- MAIN SETTINGS FORM -->
    <form wire:submit="updateProfile" class="space-y-6">

        <!-- SECTION 1: PROFIL ADMINISTRATOR -->
        <div class="admin-card p-5 sm:p-6 space-y-5">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Profil Administrator</h2>
                <p class="text-xs text-[#667085] mt-0.5">Informasi akun pengguna pengelola panel admin.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- ID Pengguna (Readonly) -->
                <div>
                    <label class="block text-xs font-semibold text-[#667085] uppercase tracking-wider mb-1.5">
                        ID Pengguna
                    </label>
                    <div class="px-3.5 py-2.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg text-xs sm:text-sm font-mono text-[#1C2430]">
                        #{{ $user_id }}
                    </div>
                </div>

                <!-- Username (Readonly) -->
                <div>
                    <label class="block text-xs font-semibold text-[#667085] uppercase tracking-wider mb-1.5">
                        Username
                    </label>
                    <div class="px-3.5 py-2.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg text-xs sm:text-sm font-mono text-[#1C2430]">
                        {{ $username }}
                    </div>
                </div>

                <!-- Nama Lengkap (Editable) -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        wire:model="name"
                        id="name"
                        required
                        class="w-full px-3.5 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Editable) -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Email Administrator <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="email"
                        wire:model="email"
                        id="email"
                        required
                        class="w-full px-3.5 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2: KEAMANAN & PASSWORD -->
        <div class="admin-card p-5 sm:p-6 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Keamanan &amp; Kata Sandi</h2>
                    <p class="text-xs text-[#667085] mt-0.5">Ubah kata sandi untuk melindungi keamanan akun Anda.</p>
                </div>
                <button
                    type="button"
                    wire:click="$toggle('changePassword')"
                    class="text-xs text-[#B8664A] hover:underline font-medium cursor-pointer"
                >
                    {{ $changePassword ? 'Batal Ganti Kata Sandi' : 'Ganti Kata Sandi' }}
                </button>
            </div>

            @if ($changePassword)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div>
                        <label for="password" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                            Kata Sandi Baru <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="password"
                            wire:model="password"
                            id="password"
                            required
                            placeholder="Minimal 8 karakter"
                            class="w-full px-3.5 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none"
                        />
                        @error('password')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                            Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="password"
                            wire:model="password_confirmation"
                            id="password_confirmation"
                            required
                            placeholder="Ulangi kata sandi baru"
                            class="w-full px-3.5 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none"
                        />
                    </div>
                </div>
            @else
                <p class="text-xs text-[#667085]">
                    Kata sandi terakhir aktif. Klik tombol "Ganti Kata Sandi" di atas untuk memperbarui kredensial Anda.
                </p>
            @endif

            <div class="pt-3 border-t border-[#E2E5E9] flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium cursor-pointer"
                >
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </div>

        <!-- SECTION 3: INFORMASI BISNIS & KONVEKSI -->
        <div class="admin-card p-5 sm:p-6 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Profil Perusahaan Tigabenang</h2>
                <p class="text-xs text-[#667085] mt-0.5">Identitas vendor garmen dan informasi kontak usaha.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-[#667085] block font-medium">Nama Brand / Usaha</span>
                    <span class="text-sm font-semibold text-[#1C2430] mt-0.5 block">Tigabenang Apparel & Confection</span>
                </div>
                <div>
                    <span class="text-[#667085] block font-medium">Tagline Operasional</span>
                    <span class="text-xs font-medium text-[#1C2430] mt-0.5 block">Solusi Vendor Pakaian Berkualitas dengan Teknologi Fitting 3D</span>
                </div>
                <div>
                    <span class="text-[#667085] block font-medium">WhatsApp Layanan CS</span>
                    <span class="text-xs font-mono font-medium text-[#1C2430] mt-0.5 block">0812-3456-7890</span>
                </div>
                <div>
                    <span class="text-[#667085] block font-medium">Alamat Workshop</span>
                    <span class="text-xs text-[#1C2430] mt-0.5 block">Jl. Industri Kreatif No. 88, Cibaduyut, Bandung, Jawa Barat 40235</span>
                </div>
            </div>
        </div>

    </form>

</div>
