@extends('layouts.admin')

@section('title', 'Edit 3D Model - ' . $model['name'])

@section('content')
<div
    class="space-y-8 max-w-5xl mx-auto"
    x-data="{
        availableProducts: {{ json_encode($availableProducts) }},
        selectedProductId: '{{ $model['product_id'] }}',
        fileName: '{{ $model['file_name'] }}',
        fileSize: '{{ $model['file_size'] }}',
        fileUploaded: true,
        modelName: '{{ $model['name'] }}',
        version: '{{ $model['version'] }}',
        description: '{{ $model['description'] }}',
        discardModalOpen: false,
        
        get selectedProduct() {
            return this.availableProducts.find(p => p.id == this.selectedProductId) || this.availableProducts[0];
        },
        
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
                const sizeMb = (file.size / (1024 * 1024)).toFixed(1);
                this.fileSize = sizeMb + ' MB';
                this.fileUploaded = true;
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
            <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-wider text-[#78716C] mb-1.5">
                <a href="{{ route('admin.model-3d.index') }}" class="hover:text-[#B85331] transition-colors">3D Models</a>
                <span>&rsaquo;</span>
                <span class="text-[#292524] font-medium">Edit Model</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Edit 3D Model</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Manage the digital garment model and its product association.
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
                form="edit-model-form"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer"
            >
                Save Changes
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. MAIN FORM: TWO-COLUMN EDITORIAL LAYOUT      -->
    <!-- ============================================== -->
    <form id="edit-model-form" action="{{ route('admin.model-3d.update', $model['id']) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

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

                    <!-- Current File Display -->
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
                                    <span>Current Asset</span>
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
                                <option value="{{ $prod['id'] }}" {{ $model['product_id'] == $prod['id'] ? 'selected' : '' }}>
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
                            src="{{ $model['preview_image'] }}"
                            alt="{{ $model['name'] }}"
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

                        <!-- Model File Available -->
                        <div class="flex items-start gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-300 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">
                                ✓
                            </div>
                            <div>
                                <p class="font-medium text-[#1C1917]">Model file available</p>
                                <p class="text-[10px] font-mono text-[#78716C]" x-text="fileName"></p>
                            </div>
                        </div>

                        <!-- Model Ready -->
                        <div class="flex items-start gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-300 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">
                                ✓
                            </div>
                            <div>
                                <p class="font-medium text-[#1C1917]">Model ready</p>
                                <p class="text-[10px] text-emerald-700 font-mono">Active in catalog</p>
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
                class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer inline-block text-center"
            >
                Save Changes
            </button>
        </div>

    </form>

</div>
@endsection
