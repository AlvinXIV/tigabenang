<div class="space-y-5">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Direktori Pelanggan</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Basis data kontak dan akumulasi pesanan pemesan custom garmen Tigabenang.
            </p>
        </div>
    </div>

    <!-- TOOLBAR: SEARCH & SORT -->
    <div class="admin-card p-3.5 bg-white flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2.5 flex-1">
            <!-- Search -->
            <div class="relative flex-1 min-w-[200px] sm:max-w-md w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama pelanggan atau nomor WhatsApp..."
                    class="w-full h-10 pl-9 pr-3.5 bg-[#F7F7F5] border border-[#E2E5E9] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <!-- Sort Select -->
            <select
                wire:model.live="sortBy"
                class="h-10 px-3 bg-[#F7F7F5] border border-[#E2E5E9] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors cursor-pointer w-full sm:w-auto"
            >
                <option value="orders">Urut: Pesanan Terbanyak</option>
                <option value="spent">Urut: Total Belanja Tertinggi</option>
                <option value="recent">Urut: Pesanan Terakhir</option>
            </select>

            <!-- Reset Button (Ghost Action) -->
            @if (!empty($search) || $sortBy !== 'orders')
                <button
                    type="button"
                    wire:click="$set('search', ''); $set('sortBy', 'orders')"
                    class="h-10 px-3 inline-flex items-center gap-1.5 text-xs text-[#667085] hover:text-[#B8664A] hover:bg-[#F7F7F5] border border-transparent hover:border-[#E2E5E9] rounded-lg transition-colors font-medium cursor-pointer shrink-0 whitespace-nowrap"
                >
                    <svg class="w-3.5 h-3.5 text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Reset Filter</span>
                </button>
            @endif
        </div>

        <div class="text-xs text-[#667085] shrink-0 self-end md:self-center">
            Total: <strong class="text-[#1C2430]">{{ $customers->count() }}</strong> dari {{ $totalCustomers }} pelanggan
        </div>
    </div>

    <!-- CUSTOMERS FULL-WIDTH TABLE -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-4 py-3">Pelanggan</th>
                        <th class="px-4 py-3 font-mono">WhatsApp</th>
                        <th class="px-4 py-3">Alamat Pengiriman</th>
                        <th class="px-4 py-3 text-center">Jumlah Pesanan</th>
                        <th class="px-4 py-3 font-mono">Total Estimasi</th>
                        <th class="px-4 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($customers as $c)
                        <tr class="admin-table-row">
                            <td class="px-4 py-3.5 font-medium text-[#1C2430] whitespace-nowrap">
                                <a href="{{ route('admin.customers.show', $c['id']) }}" class="hover:text-[#B8664A] text-[#1C2430] text-decoration-none font-medium">
                                    {{ $c['name'] }}
                                </a>
                            </td>

                            <td class="px-4 py-3.5 text-[#1C2430] font-mono text-xs whitespace-nowrap">
                                @if ($c['phone'])
                                    <a
                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['phone']) }}"
                                        target="_blank"
                                        class="text-emerald-700 hover:underline text-decoration-none inline-flex items-center gap-1"
                                    >
                                        <span>{{ $c['phone'] }}</span>
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-[#667085]">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-[#667085] text-xs max-w-xs truncate">
                                {{ $c['address'] ?: 'Belum ada alamat' }}
                            </td>

                            <td class="px-4 py-3.5 text-center whitespace-nowrap font-medium text-[#1C2430]">
                                <span class="px-2.5 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-xs font-semibold">
                                    {{ $c['total_orders'] ?? count($c['orders'] ?? []) }} pesanan
                                </span>
                            </td>

                            <td class="px-4 py-3.5 font-mono text-xs text-[#1C2430] whitespace-nowrap font-medium">
                                {{ $c['total_spent'] ? 'Rp ' . number_format($c['total_spent'], 0, ',', '.') : 'Rp 0' }}
                            </td>

                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <x-action-menu :label="'Menu aksi pelanggan ' . $c['name']">
                                    <x-action-menu.item href="{{ route('admin.customers.show', $c['id']) }}">
                                        Lihat Profil &amp; Riwayat
                                    </x-action-menu.item>

                                    @if ($c['phone'])
                                        <x-action-menu.item
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['phone']) }}"
                                            target="_blank"
                                        >
                                            Chat WhatsApp
                                        </x-action-menu.item>
                                    @endif
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-[#667085] text-xs sm:text-sm">
                                @if (!empty($search))
                                    <p class="font-medium text-[#1C2430]">Tidak ada pelanggan yang sesuai dengan pencarian "{{ $search }}".</p>
                                @else
                                    <p class="font-medium text-[#1C2430]">Belum ada data pelanggan tercatat.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
