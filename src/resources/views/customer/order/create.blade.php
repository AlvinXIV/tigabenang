@extends('layouts.customer')

@section('title', 'Pesan Produk')
@section('description', 'Kirim permintaan pakaian custom FitVendor. Tidak perlu akun.')

@push('vite')
    @vite(['resources/js/customer/order.js'])
@endpush

@section('content')

    <style>
        .fv-request-page { width: 100%; max-width: 100%; min-width: 0; }
        .fv-request-page .fv-request-shell { width: 100%; max-width: 48rem; margin-inline: auto; padding-inline: 16px; }
        @media (min-width: 768px) {
            .fv-request-page .fv-request-shell { padding-inline: 24px; }
        }
        [data-order-sizes] > [data-ukuran-id] {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            height: 68px !important;
            min-height: 68px !important;
            padding: 0 16px !important;
            border-bottom: 1px solid #E2E5E9 !important;
        }
        [data-order-sizes] > [data-ukuran-id]:last-child { border-bottom: 0 !important; }
        [data-order-sizes] input[type="number"] {
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
        .request-total-actions { width: 100%; }
        .request-total-actions button { width: 100%; }
    </style>

<div class="fv-request-page">
    <section class="fv-page-hero">
        <div class="fv-request-shell py-10 lg:py-12">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/15 text-xs font-semibold text-white mb-3">
                Konsultasi Pemesanan
            </span>
            <h1 class="max-w-xl text-3xl font-bold tracking-tight md:text-4xl text-white">Konsultasikan Pesanan Custom Anda</h1>
            <p class="mt-3 text-sm leading-relaxed text-white/80">
                Pilih kategori pakaian, bahan, dan rincian ukuran. Saat tombol ditekan, seluruh detail konsultasi akan langsung diteruskan ke WhatsApp admin FitVendor.
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

            @if ($products->isEmpty())
                <x-empty-state title="Belum ada produk yang bisa dipesan" message="Produk perlu ditambahkan dulu sebelum permintaan bisa dikirim." />
            @else
                @php
                    $orderOld = [
                        'materials' => old('materials', []),
                        'sizes'     => old('sizes', []),
                    ];
                    $catalogRows = collect($catalog);
                    $sizesForProduct = fn ($produkId) => collect(
                        $catalogRows->firstWhere('id', (int) $produkId)['sizes'] ?? []
                    );

                    $categoryList = $products
                        ->filter(fn ($produk) => filled($produk->kategori?->nama_kategori))
                        ->groupBy('kategori_id')
                        ->map(fn ($items) => [
                            'id' => (string) $items->first()->kategori_id,
                            'name' => $items->first()->kategori->nama_kategori,
                            'products' => $items->values(),
                        ])
                        ->sortBy('name')
                        ->values();

                    // Only treat a product as chosen when the customer actually asked for it,
                    // so a category with several prices never resolves one on its own.
                    $explicitProductId = old('produk_id', request()->query('product'));
                    $explicitProduct = filled($explicitProductId)
                        ? $products->firstWhere('id_produk', (int) $explicitProductId)
                        : null;

                    $activeCategoryId = (string) (
                        $explicitProduct?->kategori_id
                        ?? request()->query('category')
                        ?? $selected?->kategori_id
                        ?? ''
                    );
                    $activeCategory = $categoryList->firstWhere('id', $activeCategoryId)
                        ?? $categoryList->first();
                    $categoryProducts = collect($activeCategory['products'] ?? []);

                    // Sizes belong to the category, so any product in it resolves the same list.
                    // Price and materials belong to the product, so they need one resolved product.
                    $categoryNeedsProduct = $categoryProducts->count() > 1;
                    $resolvedProduct = $explicitProduct
                        ?? ($categoryNeedsProduct ? null : $categoryProducts->first());

                    $selectedCatalog   = $resolvedProduct
                        ? $catalogRows->firstWhere('id', (int) $resolvedProduct->id_produk)
                        : null;
                    $selectedMaterials = collect($selectedCatalog['materials'] ?? []);
                    $selectedSizes     = $sizesForProduct($categoryProducts->first()?->id_produk);

                    $categoryPayload = $categoryList->map(fn ($category) => [
                        'id' => $category['id'],
                        'name' => $category['name'],
                        'products' => collect($category['products'])
                            ->map(fn ($produk) => [
                                'id' => $produk->id_produk,
                                'name' => $produk->nama_produk,
                            ])->values(),
                        'sizes' => $sizesForProduct(collect($category['products'])->first()?->id_produk),
                    ])->values();

                    $oldMaterialIds    = collect($orderOld['materials'])->map(fn ($id) => (string) $id);
                    $oldQtyBySize      = collect($orderOld['sizes'])->mapWithKeys(function ($row) {
                        return [(string) ($row['ukuran_id'] ?? '') => $row['kuantitas'] ?? 0];
                    });
                    $waConsultationNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number', '6281234567890'));

                    $requestedProductId = request()->query('product');
                    $consultProduct = filled($requestedProductId)
                        ? $products->firstWhere('id_produk', (int) $requestedProductId)
                        : null;

                    if ($consultProduct) {
                        $waDirectMessage = 'Halo FitVendor, saya ingin konsultasi mengenai produk ' . $consultProduct->nama_produk . '. Mohon info ketersediaan bahan dan minimal pemesanannya.';
                    } else {
                        $waDirectMessage = 'Halo FitVendor, saya ingin bertanya dan konsultasi seputar pembuatan pakaian custom.';
                    }
                    $waDirectUrl = 'https://wa.me/' . $waConsultationNumber . '?text=' . rawurlencode($waDirectMessage);
                @endphp

                <!-- Choice Selector Section: Bagaimana Anda ingin melanjutkan? -->
                <section class="mb-10" aria-label="Pilihan Alur Pemesanan">
                    <div class="text-center mb-6">
                        <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-[#102A43]">
                            Bagaimana Anda ingin melanjutkan?
                        </h2>
                        <p class="mt-1.5 text-sm text-[#667085]">
                            Pilih cara yang paling sesuai dengan kebutuhan Anda saat ini.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- 1. PESAN SEKARANG -->
                        <div class="rounded-[16px] border-2 border-[#102A43]/15 bg-white p-6 shadow-sm flex flex-col justify-between transition-all duration-200 hover:border-[#102A43]/40 hover:shadow-md relative group">
                            <div>
                                <div class="flex items-center gap-3.5 mb-3">
                                    <div class="w-11 h-11 rounded-xl bg-[#102A43]/10 text-[#102A43] flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="inline-block text-[11px] font-bold tracking-wide uppercase text-[#102A43]/70 mb-0.5">Pilihan 1</span>
                                        <h3 class="text-lg font-bold text-[#102A43] leading-tight">Pesan Sekarang</h3>
                                    </div>
                                </div>
                                <p class="text-sm leading-relaxed text-[#667085]">
                                    Isi detail pesanan dan dapatkan estimasi harga.
                                </p>
                            </div>
                            <div class="mt-6 pt-2">
                                <a
                                    href="#order-form-container"
                                    id="btn-lanjutkan-pesanan"
                                    class="btn-primary min-h-[44px] w-full flex items-center justify-center gap-2 text-sm font-semibold cursor-pointer shadow-sm hover:shadow"
                                >
                                    <span>Lanjutkan Pesanan</span>
                                    <svg class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- 2. TANYA VIA WHATSAPP -->
                        <div class="rounded-[16px] border border-[#E2E5E9] bg-white p-6 shadow-sm flex flex-col justify-between transition-all duration-200 hover:border-[#25D366]/60 hover:shadow-md relative group">
                            <div>
                                <div class="flex items-center gap-3.5 mb-3">
                                    <div class="w-11 h-11 rounded-xl bg-[#25D366]/10 text-[#25D366] flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41a10.1 10.1 0 0 0 4.65 1.12h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="inline-block text-[11px] font-bold tracking-wide uppercase text-[#25D366] mb-0.5">Konsultasi</span>
                                        <h3 class="text-lg font-bold text-[#102A43] leading-tight">Tanya via WhatsApp</h3>
                                    </div>
                                </div>
                                <p class="text-sm leading-relaxed text-[#667085]">
                                    Masih bingung atau ingin konsultasi terlebih dahulu?
                                </p>
                            </div>
                            <div class="mt-6 pt-2">
                                <a
                                    href="{{ $waDirectUrl }}"
                                    id="wa-direct-consult-btn"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-outline min-h-[44px] w-full flex items-center justify-center gap-2 text-sm font-semibold border-[#D0D5DD] text-[#102A43] hover:border-[#25D366] hover:bg-[#25D366]/10 hover:text-[#075E54] transition-all"
                                >
                                    <svg class="h-4 w-4 shrink-0 fill-current text-[#25D366]" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41a10.1 10.1 0 0 0 4.65 1.12h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                                    </svg>
                                    <span>Chat WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <div id="order-form-container" class="scroll-mt-6">
                    <form
                        action="{{ route('order.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="space-y-6"
                        data-order-form
                        novalidate
                    >
                        @csrf
                    <script type="application/json" data-order-catalog>@json($catalog)</script>
                    <script type="application/json" data-order-categories>@json($categoryPayload)</script>
                    <script type="application/json" data-order-old>@json($orderOld)</script>

                    <fieldset class="request-form-panel">
                        <h2 class="request-form-panel__title">Data pemesan</h2>
                        <div class="request-form-fields" style="margin-top:22px;">
                            <div class="request-form-field">
                                <label for="nama">Nama lengkap</label>
                                <input
                                    id="nama" name="nama" type="text" required
                                    value="{{ old('nama') }}"
                                    placeholder="Nama lengkap Anda"
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
                            <div class="request-form-field">
                                <label for="no_hp">No. telepon</label>
                                <input
                                    id="no_hp" name="no_hp" type="tel" required
                                    value="{{ old('no_hp') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="fv-input"
                                >
                            </div>
                            <div class="request-form-field">
                                <label for="order-category">Kategori pakaian</label>
                                <p class="mb-2 text-sm leading-relaxed text-[#667085]">Pilih kategori pakaian yang ingin Anda pesan.</p>
                                <select id="order-category" data-order-category class="fv-select">
                                    @foreach ($categoryList as $category)
                                        <option
                                            value="{{ $category['id'] }}"
                                            @selected((string) ($activeCategory['id'] ?? '') === (string) $category['id'])
                                        >
                                            {{ \App\Support\CustomerCatalog::categoryLabel($category['name']) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div
                                class="request-form-field {{ $categoryNeedsProduct ? '' : 'hidden' }}"
                                data-order-product-wrap
                                @unless ($categoryNeedsProduct) aria-hidden="true" @endunless
                            >
                                <label for="produk_id">Pilihan produk</label>
                                <p class="mb-2 text-sm leading-relaxed text-[#667085]">
                                    Kategori ini punya beberapa pilihan dengan harga berbeda. Pilih satu agar estimasi harga tepat.
                                </p>
                                <select id="produk_id" name="produk_id" required data-order-product class="fv-select">
                                    @if ($categoryNeedsProduct && ! $resolvedProduct)
                                        <option value="">Pilih salah satu</option>
                                    @endif
                                    @foreach ($categoryProducts as $produk)
                                        <option
                                            value="{{ $produk->id_produk }}"
                                            data-price="{{ (float) $produk->harga }}"
                                            @selected((string) $resolvedProduct?->id_produk === (string) $produk->id_produk)
                                        >
                                            {{ $produk->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-2 hidden text-sm font-medium text-[#B42318]" data-order-product-error>
                                    Pilih salah satu produk terlebih dahulu.
                                </p>
                            </div>
                        </div>
                    </fieldset>

                    <div class="hidden" data-order-materials aria-hidden="true">
                        @forelse ($selectedMaterials as $index => $material)
                            @php
                                $checked = $oldMaterialIds->isNotEmpty()
                                    ? $oldMaterialIds->contains((string) $material['id'])
                                    : $index === 0;
                            @endphp
                            <input type="checkbox" name="materials[]" value="{{ $material['id'] }}" @checked($checked)>
                        @empty
                            <input type="hidden" name="materials[]" value="">
                        @endforelse
                    </div>

                    <fieldset class="request-size-panel">
                        <h2 class="request-size-panel__title">Ukuran dan jumlah</h2>
                        <p class="request-size-panel__help">Isi jumlah untuk setiap ukuran yang dibutuhkan.</p>
                        <div class="request-size-list" data-order-sizes>
                            @forelse ($selectedSizes as $index => $size)
                                <div class="request-size-row" data-ukuran-id="{{ $size['id'] }}">
                                    <input type="hidden" name="sizes[{{ $index }}][ukuran_id]" value="{{ $size['id'] }}">
                                    <label class="cursor-pointer" for="qty-{{ $size['id'] }}">{{ $size['name'] }}</label>
                                    <input
                                        id="qty-{{ $size['id'] }}"
                                        type="number"
                                        min="0"
                                        step="1"
                                        inputmode="numeric"
                                        data-order-qty
                                        name="sizes[{{ $index }}][kuantitas]"
                                        value="{{ $oldQtyBySize->get((string) $size['id'], 0) }}"
                                        class="font-semibold"
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
                        <div class="mt-4 rounded-[12px] border border-dashed border-[#D0D5DD] bg-[#F7F7F5] p-5 text-center">
                            <input
                                id="upload_design" name="upload_design" type="file"
                                accept=".jpg,.jpeg,.png,.webp,.pdf"
                                class="sr-only"
                            >
                            <label for="upload_design" class="btn-primary cursor-pointer inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Pilih file desain</span>
                            </label>
                            <p id="design-file-name" class="mt-3 text-sm font-medium text-[#102A43]">Belum ada file dipilih</p>
                            <p class="mt-1 text-xs text-[#667085]">JPG, PNG, WEBP, atau PDF. Maksimum 5 MB. Desain akan otomatis terlampir saat konsultasi WhatsApp dibuka.</p>

                            <div id="design-preview-container" class="mt-4 hidden">
                                <div class="inline-block relative rounded-xl border border-[#E2E5E9] bg-white p-2 shadow-sm">
                                    <img id="design-preview-img" src="" alt="Pratinjau Desain" class="max-h-48 max-w-full rounded-lg object-contain mx-auto">
                                    <button type="button" id="btn-remove-design" class="mt-2 block mx-auto text-xs font-semibold text-red-600 hover:text-red-700">Hapus gambar</button>
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

                    <div class="request-total-actions">
                        <div class="rounded-[14px] border border-[#E2E5E9] bg-white p-5 sm:p-6">
                            <p class="text-sm font-semibold text-[#667085]">Estimasi total</p>
                            <p class="mt-1 text-3xl font-bold tracking-tight text-[#102A43]" data-order-total>Rp 0</p>
                            <p class="mt-2 text-xs leading-relaxed text-[#667085]">
                                Harga produk dikali jumlah. Harga final dikonfirmasi tim kami.
                            </p>

                            <div class="mt-5">
                                <button
                                    type="submit"
                                    class="btn-primary min-h-12 w-full flex items-center justify-center gap-2 font-bold text-base cursor-pointer"
                                    style="border: none !important; box-shadow: none;"
                                >
                                    <span>Submit</span>
                                </button>
                                <p class="mt-2.5 text-center text-xs text-[#667085] flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#25D366] shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41a10.1 10.1 0 0 0 4.65 1.12h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Zm5.76 14.16c-.24.67-1.18 1.23-1.93 1.4-.51.11-1.18.2-3.44-.74-2.89-1.2-4.75-4.13-4.89-4.32-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.08 1-2.37.24-.26.64-.38 1.02-.38.12 0 .23 0 .33.01.3.01.44.03.64.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.15.32-.3.49-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.03 1.12 1 2.07 1.31 2.39 1.46.3.14.48.12.66-.07.18-.19.77-.9.98-1.21.21-.3.42-.26.7-.15.28.1 1.78.84 2.08.99.3.15.5.22.57.35.07.13.07.75-.17 1.42Z"/>
                                    </svg>
                                    <span>Akan diarahkan langsung ke WhatsApp</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
                </div>

                <script>
                    (function () {
                        const form = document.querySelector('[data-order-form]');
                        if (!form) { return; }

                        const btnLanjutPesanan = document.getElementById('btn-lanjutkan-pesanan');
                        const orderFormContainer = document.getElementById('order-form-container');

                        btnLanjutPesanan?.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (orderFormContainer) {
                                orderFormContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                setTimeout(() => {
                                    const firstInput = form.querySelector('#nama') || form.querySelector('input:not([type="hidden"]), select');
                                    firstInput?.focus();
                                }, 350);
                            }
                        });

                        const formatRupiah = (value) =>
                            `Rp ${Math.round(Math.max(0, Number(value) || 0)).toLocaleString('id-ID')}`;

                        const categorySelect = form.querySelector('[data-order-category]');
                        const productSelect = form.querySelector('[data-order-product]');
                        const totalNode     = form.querySelector('[data-order-total]');
                        const catalogNode   = form.querySelector('[data-order-catalog]');

                        const waDirectBtn = document.getElementById('wa-direct-consult-btn');
                        const baseWaNumber = '{{ $waConsultationNumber }}';

                        const updateDirectWaLink = () => {
                            if (!waDirectBtn) return;
                            const selectedProdText = productSelect?.selectedOptions?.[0]?.text?.trim();
                            const prodVal = productSelect?.value;

                            let msg = 'Halo FitVendor, saya ingin bertanya dan konsultasi seputar pembuatan pakaian custom.';
                            if (prodVal && selectedProdText && !selectedProdText.toLowerCase().includes('pilih salah satu')) {
                                msg = `Halo FitVendor, saya ingin konsultasi mengenai produk ${selectedProdText}. Mohon info ketersediaan bahan dan minimal pemesanannya.`;
                            }

                            waDirectBtn.href = `https://wa.me/${baseWaNumber}?text=${encodeURIComponent(msg)}`;
                        };

                        productSelect?.addEventListener('change', updateDirectWaLink);

                        let catalog = [];
                        try { catalog = JSON.parse(catalogNode?.textContent || '[]') || []; } catch { catalog = []; }

                        const productPrice = () => {
                            const fromOption = Number(productSelect?.selectedOptions?.[0]?.dataset?.price);
                            if (Number.isFinite(fromOption) && fromOption >= 0) { return fromOption; }
                            const product = catalog.find((item) => String(item.id) === String(productSelect?.value));
                            return Number(product?.price) || 0;
                        };

                        const quantityInputs = () =>
                            form.querySelectorAll('[data-order-qty], input[name*="[kuantitas]"]');

                        const updateEstimate = () => {
                            if (!totalNode) { return; }
                            const totalQuantity = [...quantityInputs()].reduce(
                                (sum, input) => sum + Math.max(0, Number(input.value) || 0), 0
                            );
                            totalNode.textContent = formatRupiah(productPrice() * totalQuantity);
                        };

                        form.addEventListener('input', updateEstimate);
                        form.addEventListener('change', updateEstimate);
                        updateEstimate();

                        window.updateOrderEstimate = updateEstimate;

                        categorySelect?.addEventListener('change', function () {
                            if (window.FitVendorOrder) { return; }
                            const url = new URL(window.location.href);
                            url.searchParams.set('category', this.value);
                            url.searchParams.delete('product');
                            window.location.href = url.pathname + url.search;
                        });

                        productSelect?.addEventListener('change', function () {
                            if (window.FitVendorOrder || !this.value) { return; }
                            const url = new URL(window.location.href);
                            url.searchParams.set('product', this.value);
                            window.location.href = url.pathname + url.search;
                        });

                        const uploadInput = form.querySelector('#upload_design');
                        const fileNameNode = document.getElementById('design-file-name');
                        const previewContainer = document.getElementById('design-preview-container');
                        const previewImg = document.getElementById('design-preview-img');
                        const btnRemoveDesign = document.getElementById('btn-remove-design');

                        uploadInput?.addEventListener('change', function () {
                            const file = this.files?.[0];
                            if (file) {
                                if (fileNameNode) { fileNameNode.textContent = file.name; }
                                if (file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        if (previewImg) { previewImg.src = e.target.result; }
                                        previewContainer?.classList.remove('hidden');
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    previewContainer?.classList.add('hidden');
                                }
                            } else {
                                if (fileNameNode) { fileNameNode.textContent = 'Belum ada file dipilih'; }
                                previewContainer?.classList.add('hidden');
                            }
                        });

                        btnRemoveDesign?.addEventListener('click', function () {
                            if (uploadInput) { uploadInput.value = ''; }
                            if (fileNameNode) { fileNameNode.textContent = 'Belum ada file dipilih'; }
                            if (previewImg) { previewImg.src = ''; }
                            previewContainer?.classList.add('hidden');
                        });

                        form.addEventListener('submit', async function (e) {
                            e.preventDefault();

                            const nama = form.querySelector('#nama')?.value?.trim();
                            const alamat = form.querySelector('#alamat')?.value?.trim();
                            const noHp = form.querySelector('#no_hp')?.value?.trim();
                            const productVal = productSelect?.value;
                            const categoryText = categorySelect?.selectedOptions?.[0]?.text?.trim() || '';
                            const productText = productSelect?.selectedOptions?.[0]?.text?.trim() || '';

                            if (!nama) {
                                alert('Mohon isi nama lengkap Anda.');
                                form.querySelector('#nama')?.focus();
                                return;
                            }
                            if (!alamat) {
                                alert('Mohon isi alamat pengiriman Anda.');
                                form.querySelector('#alamat')?.focus();
                                return;
                            }
                            if (!noHp) {
                                alert('Mohon isi nomor telepon / WhatsApp Anda.');
                                form.querySelector('#no_hp')?.focus();
                                return;
                            }
                            if (!productVal) {
                                alert('Mohon pilih produk pakaian terlebih dahulu.');
                                productSelect?.focus();
                                return;
                            }

                            const activeProduct = catalog.find((item) => String(item.id) === String(productVal));

                            const sizeBreakdown = [];
                            let totalQty = 0;
                            [...quantityInputs()].forEach((input) => {
                                const qty = Math.max(0, Number(input.value) || 0);
                                if (qty > 0) {
                                    totalQty += qty;
                                    const row = input.closest('[data-ukuran-id]');
                                    const label = row?.querySelector('label')?.textContent?.trim() || 'Ukuran';
                                    sizeBreakdown.push(`• Ukuran ${label}: ${qty} pcs`);
                                }
                            });

                            if (totalQty <= 0) {
                                alert('Mohon isi jumlah minimal 1 pcs pada salah satu ukuran.');
                                return;
                            }

                            const submitBtn = form.querySelector('button[type="submit"]');
                            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
                            const designFile = uploadInput?.files?.[0];
                            let uploadedDesignUrl = null;

                            if (designFile) {
                                if (submitBtn) {
                                    submitBtn.disabled = true;
                                    submitBtn.style.opacity = '0.75';
                                    submitBtn.innerHTML = `
                                        <svg class="w-5 h-5 animate-spin shrink-0 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                        <span>Mengunggah gambar desain...</span>
                                    `;
                                }

                                try {
                                    const uploadData = new FormData();
                                    uploadData.append('upload_design', designFile);

                                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                                        || form.querySelector('input[name="_token"]')?.value || '';

                                    const uploadResponse = await fetch('{{ route('order.upload-design') }}', {
                                        method: 'POST',
                                        body: uploadData,
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Accept': 'application/json',
                                        },
                                    });

                                    if (uploadResponse.ok) {
                                        const resData = await uploadResponse.json();
                                        if (resData && resData.url) {
                                            uploadedDesignUrl = resData.url;
                                        }
                                    }
                                } catch (uploadErr) {
                                    console.error('Gagal mengunggah desain:', uploadErr);
                                } finally {
                                    if (submitBtn) {
                                        submitBtn.disabled = false;
                                        submitBtn.style.opacity = '1';
                                        submitBtn.innerHTML = originalBtnHtml;
                                    }
                                }
                            }

                            const materials = (activeProduct?.materials || []).map((m) => m.name).filter(Boolean);
                            const notes = form.querySelector('#notes')?.value?.trim();
                            const totalLabel = totalNode?.textContent?.trim() || 'Rp 0';

                            const waNumber = '{{ $waConsultationNumber }}';

                            const lines = [
                                'Halo FitVendor, saya ingin konsultasi pemesanan pakaian custom:',
                                '',
                                '◆ *DATA PEMESAN*',
                                '• Nama: ' + nama,
                                '• No. HP: ' + noHp,
                                '• Alamat: ' + alamat,
                                '',
                                '◆ *SPESIFIKASI PRODUK & BAHAN*',
                                '• Kategori: ' + categoryText,
                                '• Produk: ' + productText,
                            ];

                            if (materials.length > 0) {
                                lines.push('• Pilihan Bahan: ' + materials.join(', '));
                            }

                            lines.push('');
                            lines.push('◆ *RINCIAN UKURAN & JUMLAH*');
                            lines.push(sizeBreakdown.join('\n'));
                            lines.push('*Total Kuantitas:* ' + totalQty + ' pcs');
                            lines.push('');
                            lines.push('◆ *ESTIMASI TOTAL AWAL:* ' + totalLabel);
                            lines.push('*(Estimasi dasar, harga final & DP disepakati bersama)*');

                            if (notes) {
                                lines.push('');
                                lines.push('◆ *CATATAN TAMBAHAN:*');
                                lines.push(notes);
                            }

                            if (uploadedDesignUrl) {
                                lines.push('');
                                lines.push('◆ *LAMPIRAN DESAIN:*');
                                lines.push(uploadedDesignUrl);
                            } else if (designFile) {
                                lines.push('');
                                lines.push('◆ *LAMPIRAN DESAIN:*');
                                lines.push('File: ' + designFile.name + ' (akan saya kirimkan gambarnya langsung di chat ini)');
                            }

                            lines.push('');
                            lines.push('Mohon informasi ketersediaan slot produksi dan kalkulasi harga finalnya. Terima kasih!');

                            const waUrl = 'https://wa.me/' + waNumber + '?text=' + encodeURIComponent(lines.join('\n'));
                            window.location.href = waUrl;
                        });
                    })();
                </script>
            @endif
        </div>
    </section>
</div>

@endsection
