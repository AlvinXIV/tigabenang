@props([
    'src' => null,
    'poster' => null,
    'alt' => 'Model Pakaian 3D Tigabenang',
    'height' => 'h-72',
    'autoRotate' => true,
])

<div {{ $attributes->merge(['class' => 'relative w-full ' . $height . ' rounded-2xl bg-gradient-to-b from-slate-100 to-slate-200/80 border border-slate-200 overflow-hidden group']) }}>
    @if ($src)
        <model-viewer
            src="{{ $src }}"
            poster="{{ $poster }}"
            alt="{{ $alt }}"
            camera-controls
            touch-action="pan-y"
            {{ $autoRotate ? 'auto-rotate' : '' }}
            rotation-per-second="30deg"
            shadow-intensity="1.2"
            exposure="1"
            class="w-full h-full cursor-grab active:cursor-grabbing"
        >
            <div slot="poster" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-100 text-slate-400">
                <svg class="w-10 h-10 animate-spin text-indigo-500 mb-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-xs font-medium text-slate-500">Memuat Model 3D...</span>
            </div>
        </model-viewer>
        
        <!-- Controls Helper Badge -->
        <div class="absolute bottom-3 left-3 bg-slate-900/70 backdrop-blur-xs text-white text-[11px] px-2.5 py-1 rounded-lg flex items-center gap-1.5 opacity-80 group-hover:opacity-100 transition-opacity">
            <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Klik & Drag untuk memutar 360°</span>
        </div>
    @else
        <!-- Placeholder when no GLB file is available yet -->
        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-6 text-center">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 mb-3 shadow-xs">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-700">Model 3D (.glb) Belum Diunggah</p>
            <p class="text-[11px] text-slate-400 mt-1 max-w-xs">Aset 3D pakaian akan dirender interaktif setelah file diunggah.</p>
        </div>
    @endif
</div>
