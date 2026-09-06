@extends('layouts.admin')

@section('title', 'Ubah Model 3D')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">

    <!-- TOP HEADER -->
    <div class="pb-5 border-b border-[#E2E5E9]">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#102A43] tracking-tight">Perbarui Aset 3D</h1>
        <p class="text-xs sm:text-sm text-[#667085] mt-1">
            Perbarui atau ganti file 3D (.glb) yang terhubung ke produk {{ $product->nama_produk }}.
        </p>
    </div>

    <!-- MAIN FORM -->
    <form
        id="edit-3d-form"
        action="{{ route('admin.model-3d.update', $product->id_produk) }}"
        method="POST"
        enctype="multipart/form-data"
        class="admin-card p-6 sm:p-8 space-y-5"
        x-data="{
            isSubmitting: false,
            hasError: false,
            fileErrorType: null,
            fileSizeFormatted: '',
            fileExt: '',
            fileName: '',
            isValid: false,
            maxSizeBytes: 20 * 1024 * 1024,

            handleFileChange(event) {
                const file = event.target.files ? event.target.files[0] : null;
                this.hasError = false;
                this.fileErrorType = null;
                this.fileSizeFormatted = '';
                this.fileExt = '';
                this.fileName = '';
                this.isValid = false;

                if (!file) {
                    return;
                }

                this.fileName = file.name;
                const ext = file.name.includes('.') ? file.name.split('.').pop().toLowerCase() : '';
                this.fileExt = ext ? '.' + ext.toUpperCase() : '';
                const allowedExts = ['glb', 'gltf'];

                // 1. Validasi format
                if (!allowedExts.includes(ext)) {
                    this.hasError = true;
                    this.fileErrorType = 'extension';
                    return;
                }

                // 2. Format perhitungan ukuran dalam MB
                const mbValue = file.size / (1024 * 1024);
                this.fileSizeFormatted = (Math.round(mbValue * 10) / 10).toFixed(1).replace('.', ',') + ' MB';

                // 3. Validasi batas ukuran 20 MB
                if (file.size > this.maxSizeBytes) {
                    this.hasError = true;
                    this.fileErrorType = 'size';
                    return;
                }

                // State valid
                this.isValid = true;
            },

            handleSubmit(event) {
                if (this.hasError) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }

                const fileInput = document.getElementById('file_model_3d');
                if (fileInput && fileInput.files && fileInput.files[0]) {
                    const file = fileInput.files[0];
                    if (file.size > this.maxSizeBytes) {
                        this.hasError = true;
                        this.fileErrorType = 'size';
                        event.preventDefault();
                        event.stopPropagation();
                        return false;
                    }
                    const ext = file.name.includes('.') ? file.name.split('.').pop().toLowerCase() : '';
                    if (!['glb', 'gltf'].includes(ext)) {
                        this.hasError = true;
                        this.fileErrorType = 'extension';
                        event.preventDefault();
                        event.stopPropagation();
                        return false;
                    }
                }

                this.isSubmitting = true;
            }
        }"
        @submit="handleSubmit($event)"
    >
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-[#102A43] mb-1.5">
                Produk Katalog Terhubung
            </label>
            <input
                type="text"
                disabled
                value="{{ $product->nama_produk }} ({{ $product->kategori ? $product->kategori->nama_kategori : 'Katalog' }})"
                class="w-full px-3.5 py-2.5 bg-[#F7F7F5] border border-[#E2E5E9] text-xs sm:text-sm text-[#102A43] rounded-lg cursor-not-allowed font-semibold"
            />
        </div>

        @if ($product->file_model_3d)
            <div class="p-3.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-[#667085] block">File 3D Aktif Saat Ini:</span>
                    <p class="text-xs font-mono font-semibold text-[#102A43] mt-0.5">📁 {{ basename($product->file_model_3d) }}</p>
                </div>
                <a
                    href="{{ route('admin.model-3d.preview', $product->id_produk) }}"
                    class="btn-secondary px-3 py-1 text-xs"
                >
                    Pratinjau
                </a>
            </div>
        @endif

        <div>
            <label for="file_model_3d" class="block text-xs font-semibold text-[#102A43] mb-1.5">
                Ganti File Model 3D (.glb / .gltf)
            </label>
            <input
                type="file"
                id="file_model_3d"
                name="file_model_3d"
                accept=".glb,.gltf"
                @change="handleFileChange($event)"
                class="w-full text-xs text-[#667085] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#102A43] file:text-white hover:file:bg-[#193B5C] cursor-pointer"
            />
            
            <!-- INFORMASI BATAS UKURAN SECARA PERMANEN -->
            <p class="text-[11px] text-[#667085] mt-2 font-medium flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-[#102A43] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Format .GLB / .GLTF • Maksimal 20 MB</span>
            </p>
            <p class="text-[11px] text-[#667085] mt-0.5">Kosongkan jika tidak ingin mengganti file model 3D.</p>

            <!-- WARNING BOX (FILE > 20 MB / FORMAT INVALID) -->
            <div
                x-show="hasError"
                style="display: none;"
                id="model3d-warning-box"
                class="mt-3 p-4 bg-amber-50 border border-amber-300 rounded-xl shadow-xs transition-all"
                role="alert"
            >
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <template x-if="fileErrorType === 'size'">
                            <div>
                                <h4 class="text-xs sm:text-sm font-bold text-amber-900 flex items-center gap-1.5">
                                    <span>⚠ File terlalu besar</span>
                                </h4>
                                <div class="text-xs text-amber-900 mt-2 space-y-1">
                                    <p>Ukuran file: <strong x-text="fileSizeFormatted"></strong></p>
                                    <p>Maksimal yang diperbolehkan: <strong>20 MB</strong></p>
                                    <p class="text-[11px] text-amber-800 pt-1">Silakan pilih file Model 3D dengan ukuran maksimal 20 MB.</p>
                                </div>
                            </div>
                        </template>

                        <template x-if="fileErrorType === 'extension'">
                            <div>
                                <h4 class="text-xs sm:text-sm font-bold text-rose-900 flex items-center gap-1.5">
                                    <span>⚠ Format file tidak didukung</span>
                                </h4>
                                <div class="text-xs text-rose-900 mt-2 space-y-1">
                                    <p>Format file: <strong x-text="fileExt"></strong></p>
                                    <p>Format yang diperbolehkan: <strong>.GLB</strong> atau <strong>.GLTF</strong></p>
                                    <p class="text-[11px] text-rose-800 pt-1">Silakan pilih file Model 3D dengan format .GLB atau .GLTF.</p>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button
                        type="button"
                        @click="hasError = false; fileErrorType = null"
                        class="text-amber-600 hover:text-amber-800 p-1 rounded-md transition-colors"
                        title="Tutup peringatan"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- VALID STATE CARD -->
            <div
                x-show="isValid && !hasError"
                style="display: none;"
                id="model3d-valid-box"
                class="mt-3 p-3 bg-emerald-50/80 border border-emerald-200 rounded-xl flex items-center justify-between shadow-2xs"
            >
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-6 h-6 rounded-md bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="truncate text-xs">
                        <span class="font-semibold text-emerald-950" x-text="fileName"></span>
                        <span class="text-emerald-700 font-mono text-[11px] ml-1.5" x-text="'(' + fileSizeFormatted + ')'"></span>
                    </div>
                </div>
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100/80 px-2.5 py-0.5 rounded-full shrink-0">Siap Diunggah</span>
            </div>

            @error('file_model_3d')
                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-[#E2E5E9] flex items-center justify-end gap-3">
            <a
                href="{{ route('admin.model-3d.index') }}"
                class="btn-secondary px-4 py-2 text-xs sm:text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                :disabled="isSubmitting || hasError"
                :class="(isSubmitting || hasError) ? 'opacity-50 cursor-not-allowed' : ''"
                class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium transition-opacity"
            >
                <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
            </button>
        </div>

    </form>

</div>
@endsection

