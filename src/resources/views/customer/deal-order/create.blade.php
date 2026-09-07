@extends('layouts.customer')

@section('title', 'Formulir Pemesanan')
@section('description', 'Kirim permintaan pakaian custom Tigabenang. Pilih kategori, bahan, dan rincian ukuran.')

@section('content')

    <style>
        .fv-request-page { width: 100%; max-width: 100%; min-width: 0; }
        .fv-request-page .fv-request-shell { width: 100%; max-width: 48rem; margin-inline: auto; padding-inline: 16px; }
        @media (min-width: 768px) {
            .fv-request-page .fv-request-shell { padding-inline: 24px; }
        }
        [data-deal-sizes] > [data-ukuran-id] {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            height: 68px !important;
            min-height: 68px !important;
            padding: 0 16px !important;
            border-bottom: 1px solid #E2E5E9 !important;
        }
        [data-deal-sizes] > [data-ukuran-id]:last-child { border-bottom: 0 !important; }
        [data-deal-sizes] input[type="number"] {
            width: 96px !important;
            height: 42px !important;
            min-height: 42px !important;
            padding: 0 0.5rem !important;
            border: 1px solid #E2E5E9 !important;
            border-radius: 8px !important;
            background: #FFFFFF !important;
            color: #102A43 !important;
            text-align: center !important;
        }
        @media (max-width: 767px) {
            .fv-request-page .fv-request-shell { padding-inline: 16px; }
            .fv-request-page .fv-page-hero .fv-request-shell { padding-top: 2rem; padding-bottom: 2rem; }
            .fv-request-page .fv-page-hero h1 { font-size: 1.625rem; }
            .fv-request-page section.py-10 { padding-top: 2rem; padding-bottom: 2rem; }
            [data-deal-sizes] > [data-ukuran-id] {
                height: 58px !important;
                min-height: 58px !important;
                padding: 0 12px !important;
            }
            [data-deal-sizes] input[type="number"] {
                width: 84px !important;
                height: 40px !important;
                min-height: 40px !important;
            }
        }
    </style>

<div class="fv-request-page">
    <section class="fv-page-hero">
        <div class="fv-request-shell py-10 lg:py-12">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/15 text-xs font-semibold text-white mb-3">
                Formulir Pemesanan
            </span>
            <h1 class="max-w-xl text-3xl font-bold tracking-tight md:text-4xl text-white">Pesan pakaian custom Anda</h1>
            <p class="mt-3 text-sm leading-relaxed text-white/80">
                Pilih kategori pakaian, bahan, dan rincian ukuran. Data ini masuk ke admin Tigabenang untuk ditinjau dan dikonfirmasi.
            </p>
        </div>
    </section>

    <section class="py-10 lg:py-12">
        <div class="fv-request-shell">

            @if ($errors->any())
                <div class="mb-6 flex gap-3 rounded-[14px] border border-red-200 bg-red-50 px-4 py-4" role="alert">
                    <div class="text-sm text-red-800">
                        <p class="font-semibold">Periksa kembali formulir.</p>
                        <ul class="mt-1.5 list-disc space-y-0.5 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($categories->isEmpty())
                <x-empty-state title="Belum ada kategori yang bisa dipesan" message="Kategori pakaian perlu ditambahkan dulu sebelum permintaan bisa dikirim." />
            @else
                @php
                    $oldCategoryId = old('kategori_id', $selected?->id_kategori);
                    $oldMaterials = collect(old('materials', []))->map(fn ($id) => (int) $id);
                    $oldSizes = collect(old('sizes', []))->mapWithKeys(fn ($row) => [
                        (string) ($row['ukuran_id'] ?? '') => (int) ($row['kuantitas'] ?? 0),
                    ]);
                    $activeCategory = $categories->firstWhere('id_kategori', (int) $oldCategoryId) ?? $selected;
                    $activeSizes = $activeCategory?->ukuran ?? collect();
                    $activeMaterials = $activeCategory
                        ? \App\Support\CustomerCatalog::materialsForCategory($activeCategory)
                        : collect();
                @endphp

                <form
                    action="{{ route('deal-order.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="deal-order-form"
                    class="space-y-6"
                    novalidate
                >
                    @csrf
                    <script type="application/json" id="deal-order-catalog-json">@json($catalog)</script>
                    <script type="application/json" id="deal-order-old-sizes">@json($oldSizes)</script>

                    <fieldset class="request-form-panel">
                        <h2 class="request-form-panel__title">Data pemesan</h2>
                        <p class="request-form-panel__help">Isi data PIC dan alamat pengiriman pesanan.</p>
                        <div class="request-form-fields">
                            <div class="request-form-field">
                                <label for="nama">Nama lengkap / PIC</label>
                                <input
                                    id="nama" name="nama" type="text" required
                                    value="{{ old('nama') }}"
                                    placeholder="Nama lengkap Anda"
                                    class="fv-input"
                                >
                            </div>
                            <div class="request-form-field">
                                <label for="no_hp">Nomor WhatsApp</label>
                                <input
                                    id="no_hp" name="no_hp" type="tel" required
                                    value="{{ old('no_hp') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="fv-input"
                                >
                            </div>
                            <div class="request-form-field">
                                <label for="alamat">Alamat pengiriman</label>
                                <textarea
                                    id="alamat" name="alamat" rows="5" required
                                    placeholder="Jalan, kota, kode pos"
                                    class="fv-textarea resize-none"
                                >{{ old('alamat') }}</textarea>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="request-form-panel">
                        <h2 class="request-form-panel__title">Kategori pakaian</h2>
                        <p class="request-form-panel__help">Pilih kategori pakaian custom yang ingin dipesan.</p>
                        <div class="request-form-field">
                            <label for="kategori_id">Kategori pakaian <span class="text-[#B42318]">*</span></label>
                            <select id="kategori_id" name="kategori_id" required class="fv-select">
                                @foreach ($categories as $kategori)
                                    <option
                                        value="{{ $kategori->id_kategori }}"
                                        @selected((int) $oldCategoryId === (int) $kategori->id_kategori)
                                    >
                                        {{ \App\Support\CustomerCatalog::categoryLabel($kategori->nama_kategori) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>

                    <fieldset class="request-form-panel">
                        <h2 class="request-form-panel__title">Bahan tersedia <span class="text-[#B42318]">*</span></h2>
                        <p class="request-form-panel__help">Bahan yang terhubung dengan kategori pakaian ini.</p>
                        <div id="deal-materials-container" class="grid gap-3 sm:grid-cols-2">
                            @forelse ($activeMaterials as $index => $m)
                                @php
                                    $isMaterialChecked = $oldMaterials->isNotEmpty()
                                        ? $oldMaterials->contains((int) $m->id_bahan)
                                        : $index === 0;
                                    $materialImageUrl = \App\Support\CustomerMedia::materialImageUrl($m->nama_bahan);
                                @endphp
                                <label class="flex cursor-pointer items-center gap-3 rounded-[12px] border border-[#E2E5E9] bg-white px-4 py-3">
                                    <input
                                        type="checkbox"
                                        name="materials[]"
                                        value="{{ $m->id_bahan }}"
                                        class="h-4 w-4 accent-[#102A43]"
                                        @checked($isMaterialChecked)
                                    >
                                    @if ($materialImageUrl)
                                        <img src="{{ $materialImageUrl }}" alt="" class="h-10 w-10 rounded-lg object-cover">
                                    @endif
                                    <span class="text-sm font-semibold text-[#102A43]">{{ $m->nama_bahan }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-[#667085]">Bahan untuk kategori ini belum diatur.</p>
                            @endforelse
                        </div>
                    </fieldset>

                    <fieldset class="request-size-panel">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h2 class="request-size-panel__title">Ukuran dan jumlah <span class="text-[#B42318]">*</span></h2>
                                <p class="request-size-panel__help">Isi jumlah untuk setiap ukuran yang dibutuhkan.</p>
                            </div>
                            <p class="rounded-lg border border-[#E2E5E9] bg-[#F7F7F5] px-3 py-1.5 text-sm font-semibold text-[#102A43]">
                                Total: <span id="deal-total-pcs">0 pcs</span>
                            </p>
                        </div>
                        <div class="request-size-list" id="deal-sizes-container" data-deal-sizes>
                            @forelse ($activeSizes as $index => $size)
                                <div class="request-size-row" data-ukuran-id="{{ $size->id_ukuran }}">
                                    <input type="hidden" name="sizes[{{ $index }}][ukuran_id]" value="{{ $size->id_ukuran }}">
                                    <label class="cursor-pointer" for="deal-qty-{{ $size->id_ukuran }}">{{ $size->nama_ukuran }}</label>
                                    <input
                                        id="deal-qty-{{ $size->id_ukuran }}"
                                        type="number"
                                        min="0"
                                        step="1"
                                        inputmode="numeric"
                                        name="sizes[{{ $index }}][kuantitas]"
                                        value="{{ $oldSizes->get((string) $size->id_ukuran, 0) }}"
                                        class="deal-qty-input font-semibold"
                                    >
                                </div>
                            @empty
                                <p class="px-5 py-4 text-sm text-[#667085]">Ukuran untuk kategori ini belum diatur.</p>
                            @endforelse
                        </div>
                    </fieldset>

                    <div class="request-upload-panel">
                        <label for="upload_design" class="block text-sm font-semibold text-[#102A43]">
                            Unggah desain <span class="font-normal text-[#667085]">(opsional)</span>
                        </label>
                        <div id="deal-upload-dropzone" class="mt-4 rounded-[12px] border border-dashed border-[#D0D5DD] bg-[#F7F7F5] p-5 text-center transition-colors hover:border-[#102A43]/40">
                            <input
                                id="upload_design" name="upload_design" type="file"
                                accept=".jpg,.jpeg,.png,.webp,.pdf"
                                class="sr-only"
                            >
                            <label for="upload_design" class="btn-primary inline-flex cursor-pointer items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Pilih file desain</span>
                            </label>
                            <p id="deal-design-name" class="mt-3 text-sm font-medium text-[#102A43]">Belum ada file dipilih</p>
                            <p class="mt-1 text-xs text-[#667085]">JPG, PNG, WEBP, atau PDF. Maksimum 5 MB.</p>

                            <!-- Pratinjau Desain / Gambar -->
                            <div id="deal-design-preview-container" class="mt-4 hidden">
                                <div class="inline-block relative rounded-xl border border-[#E2E5E9] bg-white p-3 shadow-sm max-w-sm mx-auto">
                                    <img id="deal-design-preview-img" src="" alt="Pratinjau Desain" class="max-h-52 max-w-full rounded-lg object-contain mx-auto">
                                    <div id="deal-design-doc-preview" class="hidden flex items-center justify-center gap-2 p-4 text-sm font-semibold text-[#102A43]">
                                        <svg class="h-8 w-8 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        <span id="deal-design-doc-name" class="truncate max-w-[200px]">Dokumen PDF</span>
                                    </div>
                                    <button type="button" id="deal-btn-remove-design" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-red-700 transition-colors">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus berkas
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[14px] border border-[#E2E5E9] bg-white p-5 sm:p-6">
                        <label for="notes" class="mb-1.5 block text-sm font-semibold text-[#102A43]">
                            Catatan <span class="font-normal text-[#667085]">(opsional)</span>
                        </label>
                        <textarea
                            id="notes" name="notes" rows="4"
                            placeholder="Catatan sablon, bordir, atau penyesuaian lain"
                            class="fv-textarea resize-none"
                        >{{ old('notes') }}</textarea>
                    </div>

                    <div class="rounded-[14px] border border-[#E2E5E9] bg-white p-5 sm:p-6">
                        <p class="text-sm leading-relaxed text-[#667085]">
                            Periksa rincian pesanan sebelum dikirim. Admin Tigabenang akan meninjau data ini dan menghubungi Anda untuk konfirmasi harga.
                        </p>
                        <button
                            type="submit"
                            class="btn-primary mt-5 flex min-h-12 w-full cursor-pointer items-center justify-center gap-2 text-base font-bold"
                            style="border: none !important; box-shadow: none;"
                        >
                            Kirim permintaan pesanan
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </section>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('deal-order-form');
            const categorySelect = document.getElementById('kategori_id');
            const sizesContainer = document.getElementById('deal-sizes-container');
            const materialsContainer = document.getElementById('deal-materials-container');
            const totalPcsDisplay = document.getElementById('deal-total-pcs');
            const catalogJson = document.getElementById('deal-order-catalog-json');
            const oldSizesJson = document.getElementById('deal-order-old-sizes');
            const designInput = document.getElementById('upload_design');
            const designName = document.getElementById('deal-design-name');
            const previewContainer = document.getElementById('deal-design-preview-container');
            const previewImg = document.getElementById('deal-design-preview-img');
            const docPreview = document.getElementById('deal-design-doc-preview');
            const docName = document.getElementById('deal-design-doc-name');
            const btnRemoveDesign = document.getElementById('deal-btn-remove-design');

            if (!form || !categorySelect || !sizesContainer || !catalogJson) return;

            let catalog = [];
            let preferredQty = {};
            let preferredMaterials = new Set(
                Array.from(form.querySelectorAll('input[name="materials[]"]:checked')).map((input) => input.value)
            );

            try {
                catalog = JSON.parse(catalogJson.textContent) || [];
            } catch (e) {
                catalog = [];
            }

            try {
                preferredQty = JSON.parse(oldSizesJson?.textContent || '{}') || {};
            } catch (e) {
                preferredQty = {};
            }

            const currentQtyMap = () => {
                const map = { ...preferredQty };
                sizesContainer.querySelectorAll('[data-ukuran-id]').forEach((row) => {
                    map[row.dataset.ukuranId] = row.querySelector('input[type="number"]')?.value ?? 0;
                });
                return map;
            };

            const calculateTotals = () => {
                const qtyInputs = sizesContainer.querySelectorAll('.deal-qty-input');
                let totalPcs = 0;
                qtyInputs.forEach((input) => {
                    totalPcs += Math.max(0, parseInt(input.value, 10) || 0);
                });

                if (totalPcsDisplay) {
                    totalPcsDisplay.textContent = `${totalPcs} pcs`;
                }
            };

            const renderMaterials = () => {
                if (!materialsContainer) {
                    return;
                }

                const category = catalog.find((item) => String(item.id) === String(categorySelect.value));
                const materials = category?.materials || [];

                if (!materials.length) {
                    materialsContainer.innerHTML = '<p class="text-sm text-[#667085]">Bahan untuk kategori ini belum diatur.</p>';
                    return;
                }

                const selected = preferredMaterials.size
                    ? preferredMaterials
                    : new Set();

                materialsContainer.innerHTML = materials.map((material, index) => {
                    const checked = selected.has(String(material.id)) || (selected.size === 0 && index === 0);
                    const image = material.image
                        ? `<img src="${material.image}" alt="" class="h-10 w-10 rounded-lg object-cover">`
                        : '';

                    return `
                        <label class="flex cursor-pointer items-center gap-3 rounded-[12px] border border-[#E2E5E9] bg-white px-4 py-3">
                            <input
                                type="checkbox"
                                name="materials[]"
                                value="${material.id}"
                                class="h-4 w-4 accent-[#102A43]"
                                ${checked ? 'checked' : ''}
                            >
                            ${image}
                            <span class="text-sm font-semibold text-[#102A43]">${material.name}</span>
                        </label>
                    `;
                }).join('');
            };

            const renderSizes = () => {
                const category = catalog.find((item) => String(item.id) === String(categorySelect.value));
                const sizes = category?.sizes || [];
                const qty = currentQtyMap();

                if (!sizes.length) {
                    sizesContainer.innerHTML = '<p class="px-5 py-4 text-sm text-[#667085]">Ukuran untuk kategori ini belum diatur.</p>';
                    calculateTotals();
                    return;
                }

                sizesContainer.innerHTML = sizes.map((size, index) => `
                    <div class="request-size-row" data-ukuran-id="${size.id}">
                        <input type="hidden" name="sizes[${index}][ukuran_id]" value="${size.id}">
                        <label class="cursor-pointer" for="deal-qty-${size.id}">${size.name}</label>
                        <input
                            id="deal-qty-${size.id}"
                            type="number"
                            min="0"
                            step="1"
                            inputmode="numeric"
                            name="sizes[${index}][kuantitas]"
                            value="${qty[String(size.id)] ?? 0}"
                            class="deal-qty-input font-semibold"
                        >
                    </div>
                `).join('');

                calculateTotals();
            };

            categorySelect.addEventListener('change', () => {
                preferredQty = currentQtyMap();
                preferredMaterials = new Set();
                renderMaterials();
                renderSizes();
            });

            form.addEventListener('input', function (e) {
                if (e.target.classList.contains('deal-qty-input')) {
                    calculateTotals();
                }
            });

            designInput?.addEventListener('change', function () {
                const file = this.files?.[0];
                if (file) {
                    if (designName) {
                        designName.textContent = file.name;
                    }
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            if (previewImg) {
                                previewImg.src = e.target.result;
                                previewImg.classList.remove('hidden');
                            }
                            if (docPreview) {
                                docPreview.classList.add('hidden');
                            }
                            previewContainer?.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf')) {
                        if (previewImg) {
                            previewImg.src = '';
                            previewImg.classList.add('hidden');
                        }
                        if (docPreview && docName) {
                            docName.textContent = file.name;
                            docPreview.classList.remove('hidden');
                        }
                        previewContainer?.classList.remove('hidden');
                    } else {
                        previewContainer?.classList.add('hidden');
                    }
                } else {
                    if (designName) {
                        designName.textContent = 'Belum ada file dipilih';
                    }
                    if (previewImg) {
                        previewImg.src = '';
                    }
                    previewContainer?.classList.add('hidden');
                }
            });

            btnRemoveDesign?.addEventListener('click', function () {
                if (designInput) {
                    designInput.value = '';
                }
                if (designName) {
                    designName.textContent = 'Belum ada file dipilih';
                }
                if (previewImg) {
                    previewImg.src = '';
                }
                previewContainer?.classList.add('hidden');
            });

            const dropzone = document.getElementById('deal-upload-dropzone');
            if (dropzone) {
                ['dragenter', 'dragover'].forEach((eventName) => {
                    dropzone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.classList.add('border-[#102A43]', 'bg-[#102A43]/5');
                    }, false);
                });
                ['dragleave', 'drop'].forEach((eventName) => {
                    dropzone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.classList.remove('border-[#102A43]', 'bg-[#102A43]/5');
                    }, false);
                });
                dropzone.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt?.files;
                    if (files && files.length && designInput) {
                        designInput.files = files;
                        designInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }, false);
            }

            calculateTotals();
        });
    </script>

@endsection
