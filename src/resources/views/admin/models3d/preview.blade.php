@extends('layouts.admin')

@section('title', 'Preview Model 3D')
@section('page-title', 'Inspeksi Model 3D: ' . $model['product_name'])

@section('content')
<div class="space-y-6 max-w-5xl" x-data="{ autoRotate: true, shadowIntensity: 1.2 }">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">{{ $model['product_name'] }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Inspeksi visual model pakaian 3D interaktif sebelum digunakan di Virtual Fitting Room.</p>
        </div>
        <x-button variant="outline" size="sm" href="{{ route('admin.model-3d.index') }}">
            &larr; Kembali ke Daftar Model
        </x-button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Interactive 3D Viewer Canvas (2 Cols) -->
        <div class="lg:col-span-2 bg-slate-900 rounded-3xl p-4 border border-slate-800 shadow-xl overflow-hidden relative">
            
            <div class="h-[450px] w-full rounded-2xl overflow-hidden relative">
                <model-viewer
                    src="{{ $model['model_url'] }}"
                    alt="{{ $model['product_name'] }}"
                    camera-controls
                    touch-action="pan-y"
                    :auto-rotate="autoRotate"
                    rotation-per-second="30deg"
                    :shadow-intensity="shadowIntensity"
                    exposure="1.1"
                    class="w-full h-full cursor-grab active:cursor-grabbing bg-slate-950"
                ></model-viewer>

                <!-- Floating Controls Overlay -->
                <div class="absolute top-4 left-4 flex items-center gap-2">
                    <span class="px-3 py-1 bg-slate-900/80 backdrop-blur-md text-cyan-400 text-xs font-bold rounded-xl border border-slate-700/80 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                        WebGL 3D Active
                    </span>
                </div>

                <div class="absolute bottom-4 right-4 bg-slate-900/80 backdrop-blur-md p-2 rounded-xl border border-slate-700/80 flex items-center gap-3 text-xs text-white">
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input type="checkbox" x-model="autoRotate" class="rounded bg-slate-800 border-slate-700 text-indigo-600" />
                        <span>Auto Rotate</span>
                    </label>
                </div>
            </div>

            <!-- Hint below canvas -->
            <div class="mt-3 px-2 flex items-center justify-between text-xs text-slate-400">
                <p>💡 Gunakan <strong>Scroll Mouse</strong> untuk Zoom In/Out, dan <strong>Klik Kiri + Drag</strong> untuk rotasi sudut pandang.</p>
            </div>
        </div>

        <!-- Model Metadata & Calibration Info (1 Col) -->
        <div class="space-y-6">
            
            <x-card title="Spesifikasi Berkas 3D" subtitle="Rincian aset garmen format GLB">
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Nama File:</span>
                        <span class="font-bold text-slate-800">{{ $model['file_name'] }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Format:</span>
                        <span class="font-bold text-indigo-600">glTF 2.0 Binary (.glb)</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Ukuran File:</span>
                        <span class="font-bold text-slate-800">{{ $model['file_size'] }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Status Integrasi:</span>
                        <x-badge variant="emerald" dot="true">Siap Virtual Fitting</x-badge>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-slate-500">Terdaftar Pada:</span>
                        <span class="text-slate-700">{{ $model['created_at'] }}</span>
                    </div>
                </div>
            </x-card>

            <x-card title="Petunjuk Pembuatan Model (Blender)" subtitle="Panduan bagi 3D artist">
                <ul class="text-xs text-slate-600 space-y-2 list-disc list-inside">
                    <li>Origin point pakaian berada tepat di titik tengah bahu (0, 0, 0).</li>
                    <li>Gunakan tekstur PBR (Base Color, Normal, Roughness) ter-bake dalam single material.</li>
                    <li>Ekspor dari Blender menggunakan preset <strong>glTF 2.0 (.glb)</strong> dengan kompresi Draco aktif.</li>
                </ul>
            </x-card>

        </div>

    </div>

</div>
@endsection
