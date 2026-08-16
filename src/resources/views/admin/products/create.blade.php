@extends('layouts.admin')

@section('title', 'Create New Product')

@section('content')
<div
    class="space-y-8 max-w-5xl mx-auto"
    x-data="{
        selectedCategory: '',
        categorySizes: {{ json_encode($categorySizes) }},
        availableMaterials: {{ json_encode($availableMaterials) }},
        materials: [
            { material: 'Cotton Fleece', percentage: 100 }
        ],
        imagePreview: null,
        model3dFileName: null,
        
        get totalComposition() {
            return this.materials.reduce((sum, item) => sum + (parseFloat(item.percentage) || 0), 0);
        },
        
        addMaterial() {
            if (this.availableMaterials.length > 0) {
                const nextMaterial = this.availableMaterials[this.materials.length % this.availableMaterials.length];
                this.materials.push({ material: nextMaterial, percentage: 0 });
            }
        },
        
        removeMaterial(index) {
            if (this.materials.length > 1) {
                this.materials.splice(index, 1);
            }
        },
        
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        handleModelUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.model3dFileName = file.name;
            }
        },

        validateAndSubmit(e) {
            if (this.totalComposition !== 100) {
                e.preventDefault();
                alert('Total komposisi bahan material harus tepat 100%. Saat ini: ' + this.totalComposition + '%');
                return false;
            }
        }
    }"
>

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-wider text-[#78716C] mb-1.5">
                <a href="{{ route('admin.produk.index') }}" class="hover:text-[#B85331] transition-colors">Products</a>
                <span>&rsaquo;</span>
                <span class="text-[#292524] font-medium">New Product</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Create New Product</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Add a new garment product to the Tigabenang catalog.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a
                href="{{ route('admin.produk.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-colors inline-block text-center min-w-[90px]"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="create-product-form"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer inline-block text-center"
            >
                Create Product
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. MAIN FORM: TWO-COLUMN EDITORIAL LAYOUT      -->
    <!-- ============================================== -->
    <form
        id="create-product-form"
        action="{{ route('admin.produk.store') }}"
        method="POST"
        enctype="multipart/form-data"
        @submit="validateAndSubmit($event)"
        class="space-y-8"
    >
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- ========================================== -->
            <!-- LEFT COLUMN (2/3): INFO, PRICING, MATERIAL -->
            <!-- ========================================== -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- CARD 1: Product Information -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-5">
                    <div>
                        <h2 class="text-base font-medium text-[#1C1917]">Product Information</h2>
                        <p class="text-xs text-[#78716C] mt-0.5">Enter basic garment details and category.</p>
                    </div>

                    <div class="space-y-4 pt-1">
                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                PRODUCT NAME <span class="text-[#B85331]">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                required
                                placeholder="Enter product name"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none transition-colors"
                            />
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                CATEGORY <span class="text-[#B85331]">*</span>
                            </label>
                            <select
                                id="category"
                                name="category"
                                x-model="selectedCategory"
                                required
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                            >
                                <option value="" disabled selected>Select category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                                DESCRIPTION
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Write a short product description..."
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none transition-colors leading-relaxed"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Pricing -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <div>
                        <h2 class="text-base font-medium text-[#1C1917]">Pricing</h2>
                        <p class="text-xs text-[#78716C] mt-0.5">Specify standard starting price for vendor production.</p>
                    </div>

                    <div class="pt-1">
                        <label for="price" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            BASE PRICE <span class="text-[#B85331]">*</span>
                        </label>
                        <div class="relative max-w-md">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-mono text-[#786C62] pointer-events-none">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="price"
                                name="price"
                                required
                                min="0"
                                placeholder="0"
                                class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>
                        <p class="text-[11px] text-[#78716C] mt-1.5">This is the product's base catalog price.</p>
                    </div>
                </div>

                <!-- CARD 3: Materials -->
                <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-5">
                    <div class="flex items-center justify-between gap-4 pb-2 border-b border-[#EADACE]/60">
                        <div>
                            <h2 class="text-base font-medium text-[#1C1917]">Materials</h2>
                            <p class="text-xs text-[#78716C] mt-0.5">Configure fabric composition for this product.</p>
                        </div>

                        <!-- Properly Sized Add Material Button -->
                        <button
                            type="button"
                            @click="addMaterial()"
                            class="px-3.5 py-1.5 bg-white border border-[#D9CCC1] hover:bg-[#FAF7F2] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors whitespace-nowrap shrink-0 flex items-center gap-1.5 cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Add Material</span>
                        </button>
                    </div>

                    <!-- Material Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-[#FAF7F2]/80 border-b border-[#EADACE]/70 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                                    <th class="px-4 py-3">MATERIAL</th>
                                    <th class="px-4 py-3 w-36">PERCENTAGE</th>
                                    <th class="px-4 py-3 w-16 text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EADACE]/50">
                                <template x-for="(item, index) in materials" :key="index">
                                    <tr class="hover:bg-[#FAF7F2]/40 transition-colors">
                                        <!-- Material Selection Dropdown -->
                                        <td class="px-4 py-3">
                                            <select
                                                x-model="item.material"
                                                :name="'materials[' + index + '][name]'"
                                                class="w-full px-3 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                                            >
                                                <template x-for="mat in availableMaterials" :key="mat">
                                                    <option :value="mat" :selected="item.material === mat" x-text="mat"></option>
                                                </template>
                                            </select>
                                        </td>

                                        <!-- Percentage Input -->
                                        <td class="px-4 py-3">
                                            <div class="relative flex items-center">
                                                <input
                                                    type="number"
                                                    x-model.number="item.percentage"
                                                    :name="'materials[' + index + '][percentage]'"
                                                    min="0"
                                                    max="100"
                                                    required
                                                    class="w-full pr-7 pl-3 py-2 bg-white border border-[#D9CCC1] text-xs font-mono text-center text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                                                />
                                                <span class="absolute right-2.5 text-xs font-mono text-[#786C62] pointer-events-none">%</span>
                                            </div>
                                        </td>

                                        <!-- Delete Action Button -->
                                        <td class="px-4 py-3 text-center">
                                            <button
                                                type="button"
                                                @click="removeMaterial(index)"
                                                :disabled="materials.length === 1"
                                                :class="materials.length === 1 ? 'opacity-30 cursor-not-allowed text-stone-400' : 'text-[#786C62] hover:text-[#B85331] cursor-pointer'"
                                                class="p-1 transition-colors"
                                                title="Hapus Material"
                                            >
                                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Composition Validation Bar -->
                    <div class="pt-3 border-t border-[#EADACE]/70 flex items-center justify-between">
                        <div class="text-xs">
                            <span class="font-mono text-[11px] uppercase tracking-wider text-[#786C62]">TOTAL COMPOSITION:</span>
                            <span
                                class="font-mono font-bold ml-1.5 text-sm"
                                :class="totalComposition === 100 ? 'text-emerald-700' : 'text-[#B85331]'"
                                x-text="totalComposition + '%'"
                            ></span>
                        </div>

                        <div>
                            <span
                                x-show="totalComposition === 100"
                                class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200"
                            >
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Composition Valid
                            </span>
                            <span
                                x-show="totalComposition !== 100"
                                class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-white text-[#B85331] border border-[#F7DDD2]"
                            >
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B85331]"></span>
                                Must equal 100%
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- RIGHT COLUMN (1/3): IMAGE, 3D MODEL, SIZES -->
            <!-- ========================================== -->
            <div class="space-y-8">
                
                <!-- CARD 1: Product Image -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <h2 class="text-base font-medium text-[#1C1917]">Product Image</h2>

                    <!-- Image Preview / Drop Area -->
                    <div class="relative border-2 border-dashed border-[#D9CCC1] hover:border-[#B85331] transition-colors p-6 text-center bg-[#FAF7F2]/40 min-h-[220px] flex flex-col items-center justify-center cursor-pointer group">
                        
                        <!-- Show Preview If Selected -->
                        <template x-if="imagePreview">
                            <div class="w-full h-44 overflow-hidden border border-[#EADACE] relative">
                                <img :src="imagePreview" alt="Preview" class="w-full h-full object-cover" />
                            </div>
                        </template>

                        <!-- Show Placeholder If Empty -->
                        <template x-if="!imagePreview">
                            <div class="space-y-3">
                                <div class="w-10 h-10 mx-auto text-[#8C7E72] group-hover:text-[#B85331] transition-colors">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-[#292524]">Upload the main product image</p>
                                    <p class="text-[10px] text-[#78716C] mt-0.5">PNG, JPG, WebP up to 5MB</p>
                                </div>
                            </div>
                        </template>

                        <input
                            type="file"
                            name="image"
                            accept="image/png, image/jpeg, image/webp"
                            @change="handleImageUpload($event)"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        />
                    </div>
                </div>

                <!-- CARD 2: 3D Model (OPTIONAL) -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-medium text-[#1C1917]">3D Model</h2>
                        <span class="px-2 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-[#EFE7DE] text-[#786C62]">
                            OPTIONAL
                        </span>
                    </div>

                    <!-- 3D Upload Box -->
                    <div class="relative border border-[#D9CCC1] p-4 bg-[#FAF7F2]/40 hover:bg-[#FAF7F2] transition-colors flex items-center gap-3.5 cursor-pointer group">
                        <div class="w-10 h-10 bg-white border border-[#D9CCC1] flex items-center justify-center shrink-0 text-[#786C62] group-hover:text-[#B85331] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p
                                class="text-xs font-medium text-[#1C1917] truncate"
                                x-text="model3dFileName ? model3dFileName : 'Upload 3D Model'"
                            ></p>
                            <p class="text-[10px] text-[#78716C] truncate mt-0.5">
                                <span x-show="!model3dFileName">Upload a .glb / .gltf file</span>
                                <span x-show="model3dFileName" class="text-emerald-700 font-mono font-medium">Ready for upload</span>
                            </p>
                        </div>
                        <input
                            type="file"
                            name="model_3d"
                            accept=".glb,.gltf"
                            @change="handleModelUpload($event)"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        />
                    </div>
                </div>

                <!-- CARD 3: Size Information -->
                <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                    <h2 class="text-base font-medium text-[#1C1917]">Size Information</h2>

                    <div class="p-4 bg-[#FAF7F2]/60 border border-[#EADACE] space-y-3">
                        <span class="text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                            AVAILABLE SIZES
                        </span>

                        <!-- Sizing Pills Display -->
                        <div class="flex flex-wrap gap-2 pt-0.5">
                            <template x-if="selectedCategory && categorySizes[selectedCategory]">
                                <template x-for="sz in categorySizes[selectedCategory]" :key="sz">
                                    <span class="w-8 h-8 flex items-center justify-center bg-white border border-[#D9CCC1] text-xs font-mono font-semibold text-[#1C1917] shadow-2xs" x-text="sz"></span>
                                </template>
                            </template>

                            <template x-if="!selectedCategory || !categorySizes[selectedCategory]">
                                <div class="text-xs text-[#8C7E72] italic py-1">
                                    Select a category above to preview standard sizes.
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-2 pt-1">
                        <p class="text-[11px] text-[#78716C] leading-snug">
                            Sizes are managed through the selected category.
                        </p>
                        <a
                            href="{{ route('admin.ukuran.index') }}"
                            class="text-xs font-mono font-medium text-[#B85331] hover:underline flex items-center gap-1.5 uppercase tracking-wider"
                        >
                            <span>⚙ Manage Sizes</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- ============================================== -->
        <!-- BOTTOM ACTION BUTTONS                          -->
        <!-- ============================================== -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]/70 mt-8">
            <a
                href="{{ route('admin.produk.index') }}"
                class="px-6 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-colors inline-block text-center min-w-[100px]"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer inline-block text-center"
            >
                Create Product
            </button>
        </div>

    </form>

</div>
@endsection
