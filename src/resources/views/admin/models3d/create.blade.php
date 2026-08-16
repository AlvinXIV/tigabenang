@extends('layouts.admin')

@section('title', 'Upload 3D Model')

@section('content')
<div
    class="space-y-8 max-w-5xl mx-auto"
    x-data="{
        availableProducts: {{ json_encode($availableProducts) }},
        selectedProductId: '1',
        modelFile: null,
        fileName: 'custom-hoodie.glb',
        fileSize: '8.4 MB',
        fileUploaded: true,
        modelName: 'Custom Hoodie 3D Model',
        version: 'v1.0',
        description: 'High-poly model tailored for virtual try-on module. Includes standard cotton texture maps.',
        
        get selectedProduct() {
            return this.availableProducts.find(p => p.id == this.selectedProductId) || this.availableProducts[0];
        },
        
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.modelFile = file;
                this.fileName = file.name;
                const sizeMb = (file.size / (1024 * 1024)).toFixed(1);
                this.fileSize = sizeMb + ' MB';
                this.fileUploaded = true;
                if (!this.modelName) {
                    this.modelName = file.name.replace(/\.[^/.]+$/, '') + ' 3D Model';
                }
            }
        },
        
        triggerFileInput() {
            this.$refs.fileInput.click();
        }
    }"
>

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.model-3d.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase font-mono tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>3D Models</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Upload 3D Model</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Add a digital garment model for virtual fitting.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-colors inline-block text-center min-w-[90px]"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="upload-model-form"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer flex items-center gap-2"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                <span>Upload Model</span>
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. MAIN FORM: TWO-COLUMN EDITORIAL LAYOUT      -->
    <!-- ============================================== -->
    <form id="upload-model-form" action="{{ route('admin.model-3d.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- ========================================== -->
            <!-- LEFT COLUMN (2/3): FILE, PRODUCT, INFO     -->
            <!-- ========================================== -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- CARD 1: 3D Model File -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <h2 class="text-xs font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        3D MODEL FILE
                    </h2>

                    <!-- Hidden File Input -->
                    <input
                        type="file"
                        x-ref="fileInput"
                        name="model_file"
                        accept=".glb,.gltf,.obj,.usdz"
                        @change="handleFileChange($event)"
                        class="hidden"
                    />

                    <!-- Uploaded File Card State -->
                    <template x-if="fileUploaded">
                        <div class="p-5 bg-[#FAF7F2]/60 border border-[#EADACE] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white border border-[#D9CCC1] flex items-center justify-center shrink-0 text-[#B85331]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-[#1C1917] font-mono" x-text="fileName"></h3>
                                    <p class="text-xs text-[#78716C] mt-0.5 font-mono">
                                        <span x-text="fileSize"></span>
                                        <span class="mx-1.5">•</span>
                                        <span>Uploaded Just Now</span>
                                    </p>
                                </div>
                            </div>

                            <button
                                type="button"
                                @click="triggerFileInput()"
                                class="text-xs font-mono font-medium text-[#B85331] hover:underline flex items-center gap-1.5 uppercase tracking-wider shrink-0 cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Replace file</span>
                            </button>
                        </div>
                    </template>

                    <!-- Empty Upload Box State -->
                    <template x-if="!fileUploaded">
                        <div
                            @click="triggerFileInput()"
                            class="border-2 border-dashed border-[#D9CCC1] hover:border-[#B85331] p-8 text-center bg-[#FAF7F2]/40 hover:bg-[#FAF7F2] transition-colors cursor-pointer space-y-2"
                        >
                            <div class="w-10 h-10 mx-auto text-[#786C62]">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-[#292524]">Select 3D garment model file</p>
                            <p class="text-[10px] text-[#78716C]">Supports .glb, .gltf, .obj up to 25MB</p>
                        </div>
                    </template>
                </div>

                <!-- CARD 2: Product Association -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-5">
                    <h2 class="text-xs font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        PRODUCT ASSOCIATION
                    </h2>

                    <div>
                        <label for="product_id" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            Select Product
                        </label>
                        <select
                            id="product_id"
                            name="product_id"
                            x-model="selectedProductId"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        >
                            @foreach ($availableProducts as $prod)
                                <option value="{{ $prod['id'] }}">
                                    {{ $prod['name'] }} ({{ $prod['sku'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Associated Product Card Preview -->
                    <template x-if="selectedProduct">
                        <div class="p-4 bg-[#FAF7F2]/60 border border-[#EADACE] flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3.5">
                                <img
                                    :src="selectedProduct.thumbnail"
                                    :alt="selectedProduct.name"
                                    class="w-12 h-12 object-cover border border-[#EADACE] bg-white shrink-0"
                                />
                                <div>
                                    <h4 class="text-xs sm:text-sm font-medium text-[#1C1917]" x-text="selectedProduct.name"></h4>
                                    <p class="text-[10px] font-mono text-[#786C62] mt-0.5">
                                        SKU: <span x-text="selectedProduct.sku"></span>
                                    </p>
                                </div>
                            </div>

                            <span class="px-2.5 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-[#EFE7DE] text-[#786C62] border border-[#E0D0C2]">
                                ASSOCIATED
                            </span>
                        </div>
                    </template>
                </div>

                <!-- CARD 3: Model Information -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-5">
                    <h2 class="text-xs font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        MODEL INFORMATION
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-1">
                        <!-- Model Name -->
                        <div>
                            <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                Model Name
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                x-model="modelName"
                                required
                                placeholder="Custom Hoodie 3D Model"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- Version -->
                        <div>
                            <label for="version" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                Version
                            </label>
                            <input
                                type="text"
                                id="version"
                                name="version"
                                x-model="version"
                                placeholder="v1.0"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                Description
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                x-model="description"
                                rows="3"
                                placeholder="High-poly model tailored for virtual try-on module. Includes standard cotton texture maps."
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                            ></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- RIGHT COLUMN (1/3): PREVIEW & READINESS    -->
            <!-- ========================================== -->
            <div class="space-y-8">
                
                <!-- CARD 1: Model Preview -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xs font-mono font-medium tracking-widest text-[#786C62] uppercase">
                            MODEL PREVIEW
                        </h2>
                        <div class="flex items-center gap-2 text-[#786C62]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- 3D Preview Image Container -->
                    <div class="w-full h-64 bg-stone-100 border border-[#EADACE] overflow-hidden relative group">
                        <img
                            src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&auto=format&fit=crop&q=80"
                            alt="3D Preview"
                            class="w-full h-full object-cover"
                        />

                        <!-- Floating Status Pill on Canvas -->
                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2">
                            <span class="px-2.5 py-0.5 bg-black/75 backdrop-blur-xs text-white text-[9px] font-mono uppercase tracking-wider flex items-center gap-1.5 shadow-xs whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B85331]"></span>
                                ALIGNED LOD: HIGH
                            </span>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Virtual Fitting Readiness -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <h2 class="text-xs font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        VIRTUAL FITTING READINESS
                    </h2>

                    <div class="space-y-3.5 text-xs">
                        <!-- Product Selected -->
                        <div class="flex items-start gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-300 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">
                                ✓
                            </div>
                            <div>
                                <p class="font-medium text-[#1C1917]">Product selected</p>
                                <p class="text-[10px] font-mono text-[#78716C]" x-text="selectedProduct ? selectedProduct.sku : 'None'"></p>
                            </div>
                        </div>

                        <!-- Supported File Format -->
                        <div class="flex items-start gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-300 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">
                                ✓
                            </div>
                            <div>
                                <p class="font-medium text-[#1C1917]">Supported file format</p>
                                <p class="text-[10px] font-mono text-[#78716C]">.GLB detected</p>
                            </div>
                        </div>

                        <!-- Model File Uploaded -->
                        <div class="flex items-start gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-300 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">
                                ✓
                            </div>
                            <div>
                                <p class="font-medium text-[#1C1917]">Model file uploaded</p>
                                <p class="text-[10px] font-mono text-[#78716C]" x-text="fileName"></p>
                            </div>
                        </div>

                        <!-- Model Processing -->
                        <div class="flex items-start gap-2.5">
                            <div class="w-4 h-4 rounded-full border border-stone-300 flex items-center justify-center text-[10px] text-stone-400 shrink-0 mt-0.5">
                                ○
                            </div>
                            <div>
                                <p class="font-medium text-[#78716C]">Model processing</p>
                                <p class="text-[10px] text-[#9E9084]">Pending upload completion</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- ============================================== -->
        <!-- BOTTOM ACTION BUTTONS                          -->
        <!-- ============================================== -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]/70 mt-8">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="px-6 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-colors inline-block text-center min-w-[100px]"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer flex items-center gap-2 inline-block text-center"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                <span>Upload Model</span>
            </button>
        </div>

    </form>

</div>
@endsection
