@extends('layouts.customer')

@section('title', 'Kirim permintaan')
@section('description', 'Kirim permintaan pakaian custom FitVendor. Tidak perlu akun.')

@push('vite')
    @vite(['resources/js/customer/order.js'])
@endpush

@section('content')

    <style>
        [data-order-sizes] > [data-ukuran-id] {
            min-height: 4.25rem !important;
            padding: 1rem 1.25rem !important;
            border-bottom: 1px solid #E2E5E9 !important;
        }
        [data-order-sizes] > [data-ukuran-id]:last-child { border-bottom: 0 !important; }
        [data-order-sizes] input[type="number"] {
            width: 5.75rem !important;
            min-height: 2.5rem !important;
            padding: 0.5rem 0.75rem !important;
            border: 1px solid #E2E5E9 !important;
            border-radius: 10px !important;
            background: #FFFFFF !important;
            color: #1C2430 !important;
        }
        .request-total-actions { display:grid; grid-template-columns:1fr; gap:1rem; }
        @media (min-width: 640px) {
            .request-total-actions { grid-template-columns: 1fr 1fr; }
        }
        .request-total-actions button { width:100%; }
    </style>

    <section class="fv-page-hero">
        <div class="mx-auto max-w-3xl px-5 py-10 lg:px-8 lg:py-12">
            <p class="mb-3 text-sm font-medium text-white/70">
                Formulir pesanan
            </p>
            <h1 class="max-w-xl text-3xl font-bold tracking-tight md:text-4xl">Kirim detail pesanan Anda</h1>
            <p class="mt-3 text-sm leading-relaxed">
                Isi produk, bahan, dan rincian ukuran. Kami lanjutkan lewat WhatsApp untuk harga dan jadwal produksi.
            </p>
        </div>
    </section>

    <section class="px-5 py-10 lg:px-8 lg:py-12">
        <div class="mx-auto max-w-3xl">

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
                        $selectedProductId = old('produk_id', $selected?->id_produk);
                        $selectedCatalog   = collect($catalog)->firstWhere('id', (int) $selectedProductId)
                            ?? collect($catalog)->first();
                        $selectedMaterials = collect($selectedCatalog['materials'] ?? []);
                        $selectedSizes     = collect($selectedCatalog['sizes']     ?? []);
                        $oldMaterialIds    = collect($orderOld['materials'])->map(fn ($id) => (string) $id);
                        $oldQtyBySize      = collect($orderOld['sizes'])->mapWithKeys(function ($row) {
                            return [(string) ($row['ukuran_id'] ?? '') => $row['kuantitas'] ?? 0];
                        });
                    @endphp
                    <script type="application/json" data-order-catalog>@json($catalog)</script>
                    <script type="application/json" data-order-old>@json($orderOld)</script>

                    <fieldset class="rounded-[14px] border border-[#E2E5E9] bg-white p-5 sm:p-6">
                        <legend class="px-1 text-sm font-semibold text-[#1C2430]">Data pemesan</legend>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="nama" class="mb-1.5 block text-sm font-semibold text-[#1C2430]">Nama lengkap</label>
                                <input
                                    id="nama" name="nama" type="text" required
                                    value="{{ old('nama') }}"
                                    placeholder="Nama lengkap Anda"
                                    class="fv-input"
                                >
                            </div>
                            <div class="sm:col-span-2">
                                <label for="alamat" class="mb-1.5 block text-sm font-semibold text-[#1C2430]">Alamat pengiriman</label>
                                <textarea
                                    id="alamat" name="alamat" rows="3" required
                                    placeholder="Jalan, kota, kode pos"
                                    class="fv-textarea resize-none"
                                >{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <label for="no_hp" class="mb-1.5 block text-sm font-semibold text-[#1C2430]">Nomor HP</label>
                                <input
                                    id="no_hp" name="no_hp" type="tel" required
                                    value="{{ old('no_hp') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="fv-input"
                                >
                            </div>
                            <div>
                                <label for="produk_id" class="mb-1.5 block text-sm font-semibold text-[#1C2430]">Produk</label>
                                <select id="produk_id" name="produk_id" required data-order-product class="fv-select">
                                    @foreach ($products as $produk)
                                        <option
                                            value="{{ $produk->id_produk }}"
                                            data-price="{{ (float) $produk->harga }}"
                                            @selected((string) $selectedProductId === (string) $produk->id_produk)
                                        >
                                            {{ $produk->nama_produk }} · Rp {{ number_format((float) $produk->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
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

                    <fieldset class="rounded-[14px] border border-[#E2E5E9] bg-white p-5 sm:p-6">
                        <legend class="px-1 text-sm font-semibold text-[#1C2430]">Ukuran dan jumlah</legend>
                        <p class="mb-4 text-sm text-[#667085]">Ukuran mengikuti kategori produk. Isi jumlah untuk setiap size yang dibutuhkan.</p>
                        <div class="request-size-list" data-order-sizes>
                            @forelse ($selectedSizes as $index => $size)
                                <div class="request-size-row flex items-center justify-between gap-4" data-ukuran-id="{{ $size['id'] }}">
                                    <input type="hidden" name="sizes[{{ $index }}][ukuran_id]" value="{{ $size['id'] }}">
                                    <label class="cursor-pointer text-sm font-semibold text-[#1C2430]" for="qty-{{ $size['id'] }}">{{ $size['name'] }}</label>
                                    <input
                                        id="qty-{{ $size['id'] }}"
                                        type="number"
                                        min="0"
                                        step="1"
                                        inputmode="numeric"
                                        data-order-qty
                                        name="sizes[{{ $index }}][kuantitas]"
                                        value="{{ $oldQtyBySize->get((string) $size['id'], 0) }}"
                                        class="text-right font-semibold"
                                    >
                                </div>
                            @empty
                                <p class="px-5 py-4 text-sm text-[#667085]">Ukuran untuk kategori produk ini belum diatur.</p>
                            @endforelse
                        </div>
                    </fieldset>

                    <div class="request-upload-panel">
                        <label for="upload_design" class="block text-sm font-semibold text-[#1C2430]">
                            Unggah desain <span class="font-normal text-[#667085]">(opsional)</span>
                        </label>
                        <p class="mt-1 text-sm leading-relaxed text-[#667085]">Tambahkan referensi desain agar tim kami paham permintaan Anda.</p>
                        <div class="mt-4 rounded-xl border border-dashed border-[#D0D5DD] bg-[#F7F7F5] p-5 text-center">
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
                            <p class="mb-3 text-sm text-white/70">Siap kirim permintaan?</p>
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

                        productSelect?.addEventListener('change', function () {
                            if (window.FitVendorOrder) { return; }
                            const url = new URL(window.location.href);
                            url.searchParams.set('product', this.value);
                            window.location.href = url.pathname + url.search;
                        });
                    })();
                </script>
            @endif
        </div>
    </section>

@endsection
