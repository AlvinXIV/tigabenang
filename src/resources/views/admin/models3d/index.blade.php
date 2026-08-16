@extends('layouts.admin')

@section('title', '3D Model Library')

@section('content')
<div
    class="space-y-8"
    x-data="{
        searchQuery: '',
        activeTab: 'all',
        uploadModalOpen: false,
        models: {{ json_encode($models) }},
        
        filteredModels() {
            return this.models.filter(m => {
                const matchesTab = (this.activeTab === 'all') || (m.status.toLowerCase() === this.activeTab.toLowerCase());
                const query = this.searchQuery.toLowerCase();
                const matchesSearch = !query || 
                    m.name.toLowerCase().includes(query) || 
                    (m.sku && m.sku.toLowerCase().includes(query)) || 
                    (m.linked_product && m.linked_product.toLowerCase().includes(query)) ||
                    (m.format && m.format.toLowerCase().includes(query));
                return matchesTab && matchesSearch;
            });
        }
    }"
>

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & SEARCH / UPLOAD TOOLBAR        -->
    <!-- ============================================== -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">3D Model Library</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Manage and optimize your digital garment assets.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Search Input -->
            <div class="relative w-full sm:w-72">
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Search models..."
                    class="w-full pl-9 pr-3.5 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] transition-colors"
                />
                <svg class="w-4 h-4 text-[#A89A8E] absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Upload Model Button -->
            <a
                href="{{ route('admin.model-3d.create') }}"
                class="px-4 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-2 cursor-pointer whitespace-nowrap"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                <span>UPLOAD MODEL</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. STATUS FILTER TABS                          -->
    <!-- ============================================== -->
    <div class="flex items-center gap-6 border-b border-[#EADACE]/70 text-xs font-medium">
        <button
            type="button"
            @click="activeTab = 'all'"
            :class="activeTab === 'all' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer"
        >
            All Models
        </button>

        <button
            type="button"
            @click="activeTab = 'optimized'"
            :class="activeTab === 'optimized' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer"
        >
            Optimized
        </button>

        <button
            type="button"
            @click="activeTab = 'processing'"
            :class="activeTab === 'processing' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer"
        >
            Processing
        </button>

        <button
            type="button"
            @click="activeTab = 'drafts'"
            :class="activeTab === 'drafts' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer"
        >
            Drafts
        </button>
    </div>

    <!-- ============================================== -->
    <!-- 3. 3D MODELS GRID (3 COLUMNS)                  -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="filteredModels().length > 0">
        <template x-for="m in filteredModels()" :key="m.id">
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between transition-all hover:border-[#D9CCC1] group">
                
                <!-- 3D Render Image & Status Badge -->
                <a :href="'/admin/model-3d/' + m.id + '/preview'" class="h-56 w-full bg-[#FAF7F2]/80 relative overflow-hidden border-b border-[#EADACE]/70 block">
                    <img
                        :src="m.preview_image"
                        :alt="m.name"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    />

                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        <template x-if="m.status === 'Optimized'">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-white/95 text-stone-800 border border-[#EADACE] shadow-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                OPTIMIZED
                            </span>
                        </template>

                        <template x-if="m.status === 'Processing'">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-white/95 text-[#B85331] border border-[#F7DDD2] shadow-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B85331]"></span>
                                PROCESSING
                            </span>
                        </template>

                        <template x-if="m.status === 'Drafts'">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-white/95 text-stone-600 border border-stone-200 shadow-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                                DRAFT
                            </span>
                        </template>
                    </div>
                </a>

                <!-- Model Card Details -->
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <span class="text-[10px] font-mono text-[#786C62] uppercase tracking-wider block mb-1">
                            SKU: <span x-text="m.sku ? m.sku : '--'"></span>
                        </span>
                        <a :href="'/admin/model-3d/' + m.id + '/edit'" class="text-base font-medium text-[#1C1917] group-hover:text-[#B85331] transition-colors block leading-tight">
                            <span x-text="m.name"></span>
                        </a>
                    </div>

                    <div class="space-y-3 pt-3 border-t border-[#EADACE]/60">
                        <!-- Format & Version -->
                        <div class="flex items-center justify-between text-xs font-mono">
                            <div>
                                <span class="text-[10px] tracking-widest text-[#9E9084] uppercase block">FORMAT</span>
                                <span class="text-xs font-medium text-[#1C1917]" x-text="m.format"></span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] tracking-widest text-[#9E9084] uppercase block">VERSION</span>
                                <span class="text-xs font-medium text-[#1C1917]" x-text="m.version"></span>
                            </div>
                        </div>

                        <!-- Linked Product Relation & Edit Action -->
                        <div class="pt-2 border-t border-[#EADACE]/40 flex items-center justify-between text-[11px]">
                            <span class="text-[#78716C]">
                                Linked Product: 
                                <span class="font-medium text-[#1C1917]" x-text="m.linked_product ? m.linked_product : 'Not linked'"></span>
                            </span>

                            <a
                                :href="'/admin/model-3d/' + m.id + '/edit'"
                                class="text-xs font-mono font-medium tracking-wider text-[#B85331] hover:underline uppercase transition-colors cursor-pointer"
                            >
                                MANAGE
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </template>
    </div>

    <!-- ============================================== -->
    <!-- 4. EMPTY / NO RESULTS STATE                    -->
    <!-- ============================================== -->
    <div
        x-show="filteredModels().length === 0"
        class="bg-white border border-[#EADACE] p-12 text-center space-y-4 max-w-xl mx-auto my-8 shadow-xs"
        style="display: none;"
    >
        <div class="w-12 h-12 rounded-full bg-[#FAF7F2] border border-[#EADACE] flex items-center justify-center mx-auto text-[#786C62]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-base font-medium text-[#1C1917]">No 3D models found</h3>
            <p class="text-xs text-[#78716C] mt-1 max-w-sm mx-auto">
                No digital assets match your current filter or search query. Upload a 3D model to start building your library.
            </p>
        </div>
        <button
            type="button"
            @click="uploadModalOpen = true"
            class="px-5 py-2.5 bg-[#B85331] hover:bg-[#A34524] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs inline-flex items-center gap-2 cursor-pointer"
        >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
            </svg>
            <span>Upload Model</span>
        </button>
    </div>

    <!-- ============================================== -->
    <!-- 5. UPLOAD 3D MODEL MODAL                       -->
    <!-- ============================================== -->
    <div
        x-show="uploadModalOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-xs"
        style="display: none;"
    >
        <div
            @click.away="uploadModalOpen = false"
            class="bg-white border border-[#EADACE] shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6"
        >
            <div class="flex items-center justify-between pb-4 border-b border-[#EADACE]/70">
                <h2 class="text-lg font-normal text-[#1C1917]">Upload 3D Garment Model</h2>
                <button @click="uploadModalOpen = false" class="text-[#786C62] hover:text-[#1C1917] text-lg font-mono">
                    ✕
                </button>
            </div>

            <form action="{{ route('admin.model-3d.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="model_name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        MODEL NAME <span class="text-[#B85331]">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="model_name"
                        required
                        placeholder="e.g. Silk Drape Blouse 3D"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="format" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            FORMAT
                        </label>
                        <select
                            name="format"
                            id="format"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        >
                            <option value="GLB">GLB</option>
                            <option value="GLB/USDZ">GLB / USDZ</option>
                            <option value="GLTF">GLTF</option>
                            <option value="OBJ">OBJ</option>
                        </select>
                    </div>

                    <div>
                        <label for="version" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            VERSION
                        </label>
                        <input
                            type="text"
                            name="version"
                            id="version"
                            placeholder="e.g. v1.0"
                            value="v1.0"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>
                </div>

                <div>
                    <label for="product_id" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        LINK TO PRODUCT
                    </label>
                    <select
                        name="product_id"
                        id="product_id"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    >
                        <option value="">-- Not linked / Standalone --</option>
                        @foreach ($availableProducts as $prod)
                            <option value="{{ $prod['id'] }}">{{ $prod['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        3D MODEL FILE (.glb, .gltf, .obj) <span class="text-[#B85331]">*</span>
                    </label>
                    <div class="border-2 border-dashed border-[#D9CCC1] p-6 text-center bg-[#FAF7F2]/40 hover:bg-[#FAF7F2] transition-colors relative cursor-pointer">
                        <div class="w-8 h-8 mx-auto text-[#786C62] mb-2">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-[#292524]">Click to upload or drag and drop 3D file</p>
                        <p class="text-[10px] text-[#78716C] mt-0.5">Supports .glb, .gltf, .obj up to 25MB</p>
                        <input type="file" name="model_file" accept=".glb,.gltf,.obj" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#EADACE]/70">
                    <button
                        type="button"
                        @click="uploadModalOpen = false"
                        class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium uppercase transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] text-white text-xs font-mono font-medium uppercase transition-all shadow-xs cursor-pointer"
                    >
                        Upload Model
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
