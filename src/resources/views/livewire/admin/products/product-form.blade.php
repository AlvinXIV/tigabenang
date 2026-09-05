<div class="space-y-6">

    <!-- TOP HEADER -->
    <div class="pb-5 border-b border-[#E2E5E9]">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">
            {{ $productId ? 'Ubah Produk' : 'Tambah Produk Baru' }}
        </h1>
        <p class="text-xs sm:text-sm text-[#667085] mt-1">
            {{ $productId ? 'Perbarui spesifikasi produk garmen custom.' : 'Daftarkan busana garmen custom baru ke dalam katalog Tigabenang.' }}
        </p>
    </div>

    <!-- MAIN FORM -->
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- LEFT COLUMN (2/3): INFORMASI UTAMA & BAHAN -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- CARD 1: Informasi Produk -->
                <div class="admin-card p-5 sm:p-6 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Informasi Produk</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Nama produk, kategori, dan penetapan harga dasar.</p>
                    </div>

                    <div class="space-y-4 pt-1">
                        <!-- Product Name -->
                        <div>
                            <label for="nama_produk" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_produk"
                                wire:model="nama_produk"
                                required
                                placeholder="Contoh: Varsity Jacket Polman, Kemeja Workwear Oxford"
                                class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                            />
                            @error('nama_produk')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category & Price in Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="kategori_id" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                                    Kategori Produk <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    id="kategori_id"
                                    wire:model="kategori_id"
                                    required
                                    class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                                >
                                    <option value="">Pilih Kategori...</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id_kategori }}">
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="harga" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                                    Harga Dasar Acuan <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center font-mono text-xs text-[#667085] pointer-events-none">Rp</span>
                                    <input
                                        type="number"
                                        id="harga"
                                        wire:model="harga"
                                        required
                                        min="0"
                                        placeholder="150000"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                                    />
                                </div>
                                @error('harga')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Material Kain yang Didukung -->
                <div class="admin-card p-5 sm:p-6 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Material Kain yang Didukung</h2>
                            <p class="text-xs text-[#667085] mt-0.5">Pilih material kain garmen yang dapat dipilih pemesan.</p>
                        </div>
                        <a href="{{ route('admin.kategori.index', ['tab' => 'material']) }}" target="_blank" class="text-xs text-[#102A43] hover:text-[#193B5C] font-medium text-decoration-none">
                            Kelola Material &rarr;
                        </a>
                    </div>

                    <div class="pt-1">
                        @if ($availableMaterials->isEmpty())
                            <p class="text-xs text-[#667085] italic py-2">
                                Belum ada material kain terdaftar.
                            </p>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($availableMaterials as $material)
                                    <label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-[#E2E5E9] hover:bg-[#F7F7F5] cursor-pointer transition-colors">
                                        <input
                                            type="checkbox"
                                            wire:model="bahan_ids"
                                            value="{{ $material->id_bahan }}"
                                            class="w-4 h-4 rounded text-[#102A43] focus:ring-[#102A43] border-[#D0D5DD]"
                                        />
                                        <span class="text-xs text-[#1C2430] font-medium select-none truncate">
                                            {{ $material->nama_bahan }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        @error('bahan_ids')
                            <p class="text-xs text-rose-600 mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (1/3): FOTO & MODEL 3D -->
            <div class="space-y-6">
                
                <!-- CARD 3: Gambar / Foto Produk -->
                <div class="admin-card p-5 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm font-semibold text-[#1C2430]">Foto Katalog Produk</h2>
                        <p class="text-xs text-[#667085] mt-0.5">JPG, PNG, atau WEBP (Maks 4MB).</p>
                    </div>

                    <div class="space-y-3">
                        <!-- Preview Box -->
                        <div class="w-full aspect-square rounded-lg border-2 border-dashed border-[#D0D5DD] bg-[#F7F7F5] overflow-hidden flex items-center justify-center relative">
                            @if ($gambar)
                                <img src="{{ $gambar->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover" />
                            @elseif ($existingGambar)
                                <img src="{{ asset('storage/' . $existingGambar) }}" alt="Existing Foto" class="w-full h-full object-cover" />
                            @else
                                <div class="text-center p-4">
                                    <svg class="w-10 h-10 mx-auto text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-xs text-[#667085] mt-2">Belum ada foto dipilih</p>
                                </div>
                            @endif

                            <div wire:loading wire:target="gambar" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                <span class="text-xs text-[#102A43] font-medium">Memproses gambar...</span>
                            </div>
                        </div>

                        <!-- Input File -->
                        <input
                            type="file"
                            wire:model="gambar"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="w-full text-xs text-[#667085] file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-[#F7F7F5] file:text-[#1C2430] hover:file:bg-[#E2E5E9] cursor-pointer"
                        />
                        @error('gambar')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- CARD 4: File Model 3D -->
                <div class="admin-card p-5 space-y-4">
                    <div class="border-b border-[#E2E5E9] pb-3">
                        <h2 class="text-sm font-semibold text-[#1C2430]">Model Virtual Fitting 3D</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Format .glb atau .gltf (Maks 20MB).</p>
                    </div>

                    <div class="space-y-3">
                        @if ($existingModel3d && !$file_model_3d)
                            <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-lg text-xs text-emerald-800 flex items-center justify-between">
                                <div>
                                    <p class="font-medium">Model 3D Aktif Tersedia</p>
                                    <p class="text-[11px] text-emerald-600 truncate max-w-xs">{{ basename($existingModel3d) }}</p>
                                </div>
                                <a href="{{ route('admin.model-3d.preview', $productId) }}" target="_blank" class="text-xs text-emerald-700 hover:text-emerald-900 font-semibold underline">
                                    Pratinjau
                                </a>
                            </div>
                        @endif

                        <input
                            type="file"
                            wire:model="file_model_3d"
                            accept=".glb,.gltf"
                            class="w-full text-xs text-[#667085] file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-[#F7F7F5] file:text-[#1C2430] hover:file:bg-[#E2E5E9] cursor-pointer"
                        />
                        <div wire:loading wire:target="file_model_3d" class="text-xs text-[#102A43] font-medium">
                            Mengunggah berkas 3D...
                        </div>
                        @error('file_model_3d')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

        </div>

        <div class="pt-6 border-t border-[#E2E5E9] flex items-center justify-end gap-3">
            <a
                href="{{ route('admin.produk.index') }}"
                class="btn-secondary px-4 py-2.5 text-xs sm:text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="btn-primary px-6 py-2.5 text-xs sm:text-sm font-medium cursor-pointer shadow-2xs"
            >
                <span wire:loading.remove>{{ $productId ? 'Simpan Perubahan' : 'Simpan Produk' }}</span>
                <span wire:loading class="flex items-center gap-1.5">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>

</div>
