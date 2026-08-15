@extends('layouts.admin')

@section('title', 'Matriks Ukuran Produk (cm)')
@section('page-title', 'Kelola Matriks Ukuran & Size Guide')

@section('content')
<div class="space-y-8" x-data="{ activeTab: 1 }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Matriks Ukuran Pakaian (Basis Virtual Fitting 3D)</h2>
            <p class="text-xs text-slate-500 mt-0.5">Spesifikasi dimensi fisik pakaian (dalam centimeter) yang digunakan oleh algoritma untuk merekomendasikan ukuran pas kepada customer.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-bold border border-indigo-200 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Engine Rekomendasi Terhubung
            </span>
        </div>
    </div>

    <!-- Product Selection Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200">
        @foreach ($products as $p)
            <button
                @click="activeTab = {{ $p['id'] }}"
                :class="activeTab === {{ $p['id'] }} ? 'bg-indigo-600 text-white shadow-sm font-bold' : 'bg-white text-slate-600 hover:bg-slate-100 font-semibold border border-slate-200'"
                class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition-all flex items-center gap-2"
            >
                <span>{{ $p['name'] }}</span>
                <span class="text-[10px] px-1.5 py-0.5 rounded-md" :class="activeTab === {{ $p['id'] }} ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500'">
                    {{ $p['category'] }}
                </span>
            </button>
        @endforeach
    </div>

    <!-- Size Table for Each Product -->
    @foreach ($products as $p)
        <div x-show="activeTab === {{ $p['id'] }}" class="space-y-6">
            
            <form action="{{ route('admin.ukuran.update', $p['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <x-card
                    title="Tabel Spesifikasi Dimensi: {{ $p['name'] }}"
                    subtitle="Nilai toleransi jahitan konveksi: ± 1 - 1.5 cm"
                >
                    <x-slot:action>
                        <x-button type="submit" variant="primary" size="sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Simpan Dimensi Ukuran</span>
                        </x-button>
                    </x-slot:action>

                    <div class="overflow-x-auto -mx-6 -my-6">
                        <x-table :headers="['Ukuran (Size)', 'Lebar Dada (cm)', 'Panjang Baju (cm)', 'Lebar Bahu (cm)', 'Panjang Lengan (cm)', 'Aksi']">
                            @foreach ($p['sizes'] as $index => $sz)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-3.5 whitespace-nowrap">
                                        <span class="w-9 h-9 rounded-xl bg-slate-900 text-white font-extrabold text-sm flex items-center justify-center shadow-xs">
                                            {{ $sz['size'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-1">
                                            <input
                                                type="number"
                                                name="sizes[{{ $index }}][chest_width]"
                                                value="{{ $sz['chest_width'] }}"
                                                class="w-20 px-3 py-1.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-500"
                                            />
                                            <span class="text-xs text-slate-400">cm</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-1">
                                            <input
                                                type="number"
                                                name="sizes[{{ $index }}][body_length]"
                                                value="{{ $sz['body_length'] }}"
                                                class="w-20 px-3 py-1.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-500"
                                            />
                                            <span class="text-xs text-slate-400">cm</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-1">
                                            <input
                                                type="number"
                                                name="sizes[{{ $index }}][shoulder_width]"
                                                value="{{ $sz['shoulder_width'] }}"
                                                class="w-20 px-3 py-1.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-500"
                                            />
                                            <span class="text-xs text-slate-400">cm</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-1">
                                            <input
                                                type="number"
                                                name="sizes[{{ $index }}][sleeve_length]"
                                                value="{{ $sz['sleeve_length'] }}"
                                                class="w-20 px-3 py-1.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-500"
                                            />
                                            <span class="text-xs text-slate-400">cm</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5 whitespace-nowrap text-right">
                                        <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif di Rekomendasi
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>
                </x-card>
            </form>

            <!-- Size Recommendation Calculation Guide Box -->
            <div class="bg-indigo-50/70 border border-indigo-100 rounded-2xl p-5 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-xs text-indigo-950 space-y-1">
                    <h4 class="font-bold text-indigo-900">Cara Kerja Algoritma Rekomendasi Ukuran</h4>
                    <p class="text-indigo-800/90 leading-relaxed">
                        Ketika pelanggan memasukkan tinggi, berat, dan lingkar dada di halaman <strong>Virtual Fitting</strong>, sistem menghitung <em>Ease Allowance</em> (kelonggaran pakaian +4 s/d 6 cm dari lingkar dada tubuh) dan mencocokkannya secara otomatis dengan baris tabel ukuran di atas untuk memberikan rekomendasi size yang paling proporsional.
                    </p>
                </div>
            </div>

        </div>
    @endforeach

</div>
@endsection
