@extends('layouts.admin')

@section('title', 'Aset Model Pakaian 3D')
@section('page-title', 'Kelola Model 3D Virtual Fitting (.glb)')

@section('content')
<div class="space-y-8" x-data="{ uploadModalOpen: false }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Aset 3D Pakaian untuk Virtual Fitting</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola model 3D pakaian format <code>.glb / .gltf</code> yang digunakan untuk simulasi pada avatar customer di Virtual Fitting Room.</p>
        </div>
        <button
            @click="$dispatch('open-modal', 'upload-model-modal')"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-cyan-600 hover:from-indigo-500 hover:to-cyan-500 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-500/20 transition-all"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
            </svg>
            <span>Unggah File Model 3D Baru</span>
        </button>
    </div>

    <!-- 3D Models Grid with Live Web Component Viewer -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($models as $m)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col hover:shadow-lg transition-all duration-200">
                
                <!-- 3D Canvas / Model Viewer Component -->
                <div class="p-3 bg-slate-100/60">
                    <x-model3d-viewer
                        :src="$m['model_url']"
                        :alt="$m['product_name']"
                        height="h-64"
                    />
                </div>

                <!-- Info Body -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-semibold">
                                {{ $m['category'] }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-cyan-50 text-cyan-700 border border-cyan-200">
                                3D Fitting Ready
                            </span>
                        </div>

                        <h3 class="text-sm font-bold text-slate-900 leading-snug">{{ $m['product_name'] }}</h3>
                        
                        <div class="mt-3 space-y-1 text-xs text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <div class="flex items-center justify-between">
                                <span>Nama File:</span>
                                <code class="font-mono text-slate-800 text-[11px]">{{ $m['file_name'] }}</code>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Ukuran File:</span>
                                <span class="font-semibold text-slate-700">{{ $m['file_size'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Terakhir Diperbarui:</span>
                                <span>{{ $m['last_updated'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                        <a
                            href="{{ route('admin.model-3d.preview', $m['id']) }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition-colors"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>Preview Fullscreen</span>
                        </a>

                        <form action="{{ route('admin.model-3d.destroy', $m['id']) }}" method="POST" onsubmit="return confirm('Hapus aset model 3D ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg text-xs font-semibold">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <!-- Modal Upload File 3D (.glb) -->
    <x-modal name="upload-model-modal" title="Unggah Model Pakaian 3D (.glb / .gltf)">
        <form action="{{ route('admin.model-3d.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <x-input type="select" label="Kaitkan ke Produk Pakaian" name="product_id" required>
                <option value="">-- Pilih Produk Pakaian --</option>
                <option value="1">Jaket Coach Taslan Waterproof</option>
                <option value="2">Hoodie Heavyweight Fleece 330gsm</option>
                <option value="3">Kaos Oversize Cotton Combed 24s</option>
                <option value="4">Kemeja Tactical PDL Japan Drill</option>
                <option value="5">Jersey Full Printing Sublim Drifit</option>
            </x-input>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700">Pilih File Model 3D (.glb / .gltf) <span class="text-rose-500">*</span></label>
                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center bg-slate-50 hover:bg-slate-100 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-800">Pilih file 3D berekstensi .glb atau .gltf</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Maksimal ukuran file 25MB (Dibuat via Blender)</p>
                    <input type="file" name="model_file" accept=".glb,.gltf" required class="mt-3 text-xs" />
                </div>
            </div>

            <x-input label="Catatan Skala / Offset Posisi (Opsional)" name="scale_config" placeholder='{"scale": 1.0, "offset_y": 0.0}' hint="Konfigurasi JSON opsional untuk kalibrasi posisi avatar" />

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" @click="$dispatch('close-modal', 'upload-model-modal')" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                    Batal
                </button>
                <x-button type="submit" variant="primary">
                    Upload & Render Model
                </x-button>
            </div>
        </form>
    </x-modal>

</div>
@endsection
