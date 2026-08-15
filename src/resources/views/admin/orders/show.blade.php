@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order['order_code'])
@section('page-title', 'Rincian Pesanan: ' . $order['order_code'])

@section('content')
<div class="space-y-8 max-w-5xl">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-slate-900">Pesanan {{ $order['order_code'] }}</h2>
                @if ($order['status'] === 'pending')
                    <x-badge variant="amber" dot="true">Menunggu Review</x-badge>
                @elseif ($order['status'] === 'confirmed')
                    <x-badge variant="sky">Dikonfirmasi</x-badge>
                @elseif ($order['status'] === 'in_production')
                    <x-badge variant="indigo" dot="true">Sedang Produksi</x-badge>
                @elseif ($order['status'] === 'completed')
                    <x-badge variant="emerald">Selesai</x-badge>
                @else
                    <x-badge variant="rose">Ditolak</x-badge>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1">Diterima pada {{ $order['created_at'] }} melalui portal pesanan website</p>
        </div>

        <div class="flex items-center gap-3">
            <x-button variant="outline" size="sm" href="{{ route('admin.pesanan.index') }}">
                &larr; Kembali
            </x-button>
            <x-button variant="primary" size="sm" href="{{ route('admin.orders.invoice', $order['id']) }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Cetak / Lihat Invoice</span>
            </x-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Order Details & Specs (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Product & Specs Card -->
            <x-card title="Spesifikasi Produk Pakaian Dipesan" subtitle="Detail item dan rincian kain yang dipesan">
                <div class="space-y-4">
                    <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                        <div>
                            <h4 class="text-base font-bold text-slate-900">{{ $order['product_name'] }}</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Kategori: {{ $order['category'] }} • Varian Warna: <strong class="text-slate-800">{{ $order['color'] }}</strong></p>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 bg-slate-100 rounded-lg text-slate-700">
                            Total {{ $order['quantity'] }} pcs
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block mb-0.5">Spesifikasi Bahan</span>
                            <span class="font-bold text-slate-800">{{ $order['material'] }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block mb-0.5">Estimasi Harga Satuan</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($order['unit_price'], 0, ',', '.') }} / pcs</span>
                        </div>
                    </div>

                    <!-- Size breakdown matrix -->
                    <div>
                        <h5 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">Rincian Ukuran Pesanan (Breakdown Size)</h5>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($order['size_breakdown'] as $sb)
                                <div class="p-3 bg-indigo-50/50 rounded-xl border border-indigo-100/80 flex items-center justify-between">
                                    <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white font-black text-xs flex items-center justify-center">
                                        {{ $sb['size'] }}
                                    </span>
                                    <span class="text-sm font-extrabold text-indigo-950">{{ $sb['qty'] }} pcs</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Custom Notes & Design Files -->
            <x-card title="Catatan Khusus Sablon / Bordir & File Desain" subtitle="Instruksi tambahan dari pelanggan">
                <div class="space-y-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-700 leading-relaxed">
                        <p class="font-bold text-slate-900 mb-1">Catatan Klien:</p>
                        "{{ $order['custom_notes'] }}"
                    </div>

                    <div class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs">
                                PDF
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Mockup_Desain_Sinergi_2026.pdf</p>
                                <span class="text-[11px] text-slate-400">Lampiran file vektor / desain sablon (2.4 MB)</span>
                            </div>
                        </div>
                        <a href="{{ $order['design_file'] }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition-colors">
                            Unduh File
                        </a>
                    </div>
                </div>
            </x-card>

        </div>

        <!-- Right: Customer Info & Status Manager (1 Col) -->
        <div class="space-y-6">
            
            <!-- Update Status Box -->
            <x-card title="Perbarui Status Pesanan" subtitle="Ubah alur proses pesanan">
                <form action="{{ route('admin.pesanan.update', $order['id']) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-input type="select" label="Status Alur Produksi" name="status" required>
                        <option value="pending" {{ $order['status'] == 'pending' ? 'selected' : '' }}>1. Menunggu Review (Pending)</option>
                        <option value="confirmed" {{ $order['status'] == 'confirmed' ? 'selected' : '' }}>2. Dikonfirmasi (Confirmed)</option>
                        <option value="in_production" {{ $order['status'] == 'in_production' ? 'selected' : '' }}>3. Sedang Diproses Produksi (In Production)</option>
                        <option value="completed" {{ $order['status'] == 'completed' ? 'selected' : '' }}>4. Selesai / Siap Kirim (Completed)</option>
                        <option value="cancelled" {{ $order['status'] == 'cancelled' ? 'selected' : '' }}>5. Ditolak / Dibatalkan (Cancelled)</option>
                    </x-input>

                    <x-button type="submit" variant="primary" class="w-full">
                        Simpan Perubahan Status
                    </x-button>
                </form>
            </x-card>

            <!-- Customer Contact Card -->
            <x-card title="Informasi Pemesan" subtitle="Kontak dan alamat pengiriman pesanan">
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Nama Pemesan</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $order['customer_name'] }}</span>
                        <span class="text-[11px] text-slate-500 block">{{ $order['company_or_institution'] }}</span>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 block mb-0.5">Nomor WhatsApp</span>
                        <a
                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order['phone']) }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 font-bold text-emerald-600 hover:text-emerald-700"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"></path>
                            </svg>
                            <span>{{ $order['phone'] }} (Chat WhatsApp)</span>
                        </a>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 block mb-0.5">Email</span>
                        <span class="font-medium text-slate-800">{{ $order['email'] }}</span>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400 block mb-0.5">Alamat Pengiriman / Ekspedisi</span>
                        <p class="text-slate-700 leading-relaxed">{{ $order['shipping_address'] }}</p>
                    </div>
                </div>
            </x-card>

        </div>

    </div>

</div>
@endsection
