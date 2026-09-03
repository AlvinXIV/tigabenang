@extends('layouts.customer')

@section('title', 'Kirim permintaan')
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
            color: #1C2430 !important;
            text-align: center !important;
        }
        .request-total-actions { display:grid; grid-template-columns:1fr; gap:1rem; }
        @media (min-width: 640px) {
            .request-total-actions { grid-template-columns: 1fr 1fr; }
        }
        .request-total-actions button { width:100%; }
    </style>

<div class="fv-request-page">
    <section class="fv-page-hero">
        <div class="fv-request-shell py-10 lg:py-12">
            <p class="mb-3 text-sm font-medium text-white/70">
                Formulir pesanan
            </p>
            <h1 class="max-w-xl text-3xl font-bold tracking-tight md:text-4xl">Kirim detail pesanan Anda</h1>
            <p class="mt-3 text-sm leading-relaxed">
                Pilih kategori pakaian, lalu isi bahan dan rincian ukuran. Kami lanjutkan lewat WhatsApp untuk harga dan jadwal produksi.
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
                <form
                    action="{{ route('order.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6"
                    data-order-form
                    novalidate
                >
                    @csrf
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
                    @endphp
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
                                            {{ $category['name'] }}
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
                        <label for="upload_design" class="block text-sm font-semibold text-[#1C2430]">
                            Unggah desain <span class="font-normal text-[#667085]">(opsional)</span>
                        </label>
                        <div class="mt-4 rounded-[12px] border border-dashed border-[#D0D5DD] bg-[#F7F7F5] p-5 text-center">
                            <input
                                id="upload_design" name="upload_design" type="file"
                                accept=".jpg,.jpeg,.png,.webp,.pdf"
                                class="sr-only"
                                onchange="document.getElementById('design-file-name').textContent = this.files.length ? this.files[0].name : 'Belum ada file dipilih';"
                            >
                            <label for="upload_design" class="btn-primary cursor-pointer">Pilih file desain</label>
                            <p id="design-file-name" class="mt-3 text-sm font-medium text-[#1C2430]">Belum ada file dipilih</p>
                            <p class="mt-1 text-xs text-[#667085]">JPG, PNG, WEBP, atau PDF. Maksimum 5 MB.</p>
                        </div>
                    </div>

                    <div class="rounded-[14px] border border-[#E2E5E9] bg-white p-5 sm:p-6">
                        <label for="notes" class="mb-1.5 block text-sm font-semibold text-[#1C2430]">
                            Catatan <span class="font-normal text-[#667085]">(opsional)</span>
                        </label>
                        <textarea
                            id="notes" name="notes" rows="4"
                            placeholder="Catatan sablon, bordir, atau penyesuaian lain"
                            class="fv-textarea resize-none"
                        >{{ old('notes') }}</textarea>
                    </div>

                    <div class="request-total-actions">
                        <div class="rounded-[14px] border border-[#E2E5E9] bg-white p-5">
                            <p class="text-sm font-semibold text-[#667085]">Estimasi total</p>
                            <p class="mt-1 text-3xl font-bold tracking-tight text-[#1C2430]" data-order-total>Rp 0</p>
                            <p class="mt-2 text-xs leading-relaxed text-[#667085]">
                                Harga produk dikali jumlah. Harga final dikonfirmasi tim kami.
                            </p>
                        </div>
                        <div class="flex flex-col justify-center rounded-[14px] bg-[#1C2430] p-5">
                            <button type="submit" class="btn-primary min-h-12" style="background:#FFFFFF;color:#1C2430 !important;border-color:#FFFFFF;">
                                Kirim permintaan
                            </button>
                        </div>
                    </div>
                </form>

                <script>
                    (function () {
                        const form = document.querySelector('[data-order-form]');
                        if (!form) { return; }

                        const formatRupiah = (value) =>
                            `Rp ${Math.round(Math.max(0, Number(value) || 0)).toLocaleString('id-ID')}`;

                        const categorySelect = form.querySelector('[data-order-category]');
                        const productSelect = form.querySelector('[data-order-product]');
                        const totalNode     = form.querySelector('[data-order-total]');
                        const catalogNode   = form.querySelector('[data-order-catalog]');

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
                    })();
                </script>
            @endif
        </div>
    </section>
</div>

@endsection
