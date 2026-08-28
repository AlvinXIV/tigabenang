@extends('layouts.customer')

@section('title', 'Request Order')
@section('description', 'Request a custom Clothiq garment. No account required.')

@push('vite')
    @vite(['resources/js/customer/order.js'])
@endpush

@section('content')

    <style>
        /* Kept here because the size rows are generated dynamically by order.js. */
        [data-order-sizes] > [data-ukuran-id] {
            min-height: 5.25rem !important;
            padding: 1.25rem 1.75rem !important;
            border-bottom: 1px solid #DCD6D0 !important;
        }
        [data-order-sizes] > [data-ukuran-id]:last-child { border-bottom: 0 !important; }
        [data-order-sizes] input[type="number"] {
            width: 6.5rem !important;
            min-height: 2.75rem !important;
            padding: 0.625rem 0.875rem !important;
            border: 1.5px solid #DCD6D0 !important;
            border-radius: 0.625rem !important;
            background: #F6F4F1 !important;
            color: #172A39 !important;
        }
        .request-total-actions { display:grid; grid-template-columns:1fr; gap:1.25rem; }
        @media (min-width: 640px) {
            .request-total-actions { grid-template-columns: 1fr 1fr; }
        }
        .request-total-actions button { width:100%; }
    </style>

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="relative overflow-hidden border-b border-border bg-primary" style="background-color:#172A39;border-color:#DCD6D0;">
        <div class="pointer-events-none absolute -right-24 -top-32 h-80 w-80 rounded-full" style="background:rgba(252,86,60,0.12);"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-20 h-64 w-64 rounded-full border-[24px]" style="border-color:rgba(233,228,224,0.06);"></div>
        <div class="relative mx-auto max-w-3xl px-5 py-14 lg:px-8 lg:py-20">
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.68rem] font-bold uppercase tracking-[0.16em]" style="border-color:rgba(252,86,60,0.4);background:rgba(252,86,60,0.15);color:#FC563C;">
                <span class="h-2 w-2 rounded-full" style="background:#FC563C;"></span>
                Custom order studio
            </div>
            <h1 class="max-w-xl text-4xl font-extrabold tracking-tight text-white md:text-5xl">Tell us what to make</h1>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-white/75">
                No account is created. We use this form to reach you and to calculate the order from product price × total quantity.
            </p>
        </div>
    </section>

    <section class="px-5 py-12 lg:px-8 lg:py-16" style="background:#FFFFFF;">
        <div class="mx-auto max-w-3xl">

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-8 flex gap-3 rounded-xl border border-danger/30 bg-danger/5 px-5 py-4" role="alert">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="text-sm text-danger">
                        <p class="font-semibold">Please review the form.</p>
                        <ul class="mt-1.5 list-disc space-y-0.5 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($products->isEmpty())
                <x-empty-state title="Nothing to request yet" message="Products need to be added before a production request can be sent." />
            @else
                <form
                    action="{{ route('order.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-8"
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

                    {{-- ── Contact info ────────────────── --}}
                    <fieldset>
                        <legend class="text-xs font-bold uppercase tracking-[0.14em] mb-5" style="color:#6E7575;">Contact Information</legend>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="nama" class="block text-xs font-bold mb-2" style="color:#172A39;">Full Name</label>
                                <input
                                    id="nama" name="nama" type="text" required
                                    value="{{ old('nama') }}"
                                    placeholder="Your full name"
                                    class="w-full rounded-xl border px-4 py-3 text-sm transition"
                                    style="border-color:#DCD6D0;background:#FFFFFF;color:#172A39;"
                                    onfocus="this.style.borderColor='#FC563C'"
                                    onblur="this.style.borderColor='#DCD6D0'"
                                >
                            </div>
                            <div class="sm:col-span-2">
                                <label for="alamat" class="block text-xs font-bold mb-2" style="color:#172A39;">Delivery Address</label>
                                <textarea
                                    id="alamat" name="alamat" rows="3" required
                                    placeholder="Complete street address, city, postal code"
                                    class="w-full rounded-xl border px-4 py-3 text-sm transition resize-none"
                                    style="border-color:#DCD6D0;background:#FFFFFF;color:#172A39;"
                                    onfocus="this.style.borderColor='#FC563C'"
                                    onblur="this.style.borderColor='#DCD6D0'"
                                >{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <label for="no_hp" class="block text-xs font-bold mb-2" style="color:#172A39;">Phone Number</label>
                                <input
                                    id="no_hp" name="no_hp" type="tel" required
                                    value="{{ old('no_hp') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full rounded-xl border px-4 py-3 text-sm transition"
                                    style="border-color:#DCD6D0;background:#FFFFFF;color:#172A39;"
                                    onfocus="this.style.borderColor='#FC563C'"
                                    onblur="this.style.borderColor='#DCD6D0'"
                                >
                            </div>
                            <div>
                                <label for="produk_id" class="block text-xs font-bold mb-2" style="color:#172A39;">Product</label>
                                <select
                                    id="produk_id" name="produk_id" required
                                    data-order-product
                                    class="w-full rounded-xl border px-4 py-3 text-sm transition"
                                    style="border-color:#DCD6D0;background:#FFFFFF;color:#172A39;"
                                    onfocus="this.style.borderColor='#FC563C'"
                                    onblur="this.style.borderColor='#DCD6D0'"
                                >
                                    @foreach ($products as $produk)
                                        <option
                                            value="{{ $produk->id_produk }}"
                                            data-price="{{ (float) $produk->harga }}"
                                            @selected((string) $selectedProductId === (string) $produk->id_produk)
                                        >
                                            {{ $produk->nama_produk }} — Rp {{ number_format((float) $produk->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Material is assigned automatically from the selected product. --}}
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

                    {{-- ── Size & Quantity ──────────────── --}}
                    <fieldset>
                        <legend class="text-xs font-bold uppercase tracking-[0.14em] mb-1.5" style="color:#6E7575;">Size & Quantity</legend>
                        <p class="text-xs mb-4" style="color:#6E7575;">Sizes come from the product's category. Enter a quantity for each size you need.</p>
                        <div class="request-size-list" data-order-sizes style="overflow:hidden;border:1.5px solid #DCD6D0;border-radius:1rem;background:#FFFFFF;box-shadow:0 6px 20px rgba(23,42,57,0.05);">
                            @forelse ($selectedSizes as $index => $size)
                                <div class="request-size-row" data-ukuran-id="{{ $size['id'] }}" style="display:flex;align-items:center;justify-content:space-between;gap:1.5rem;min-height:5.25rem;padding:1.25rem 1.75rem;background:#FFFFFF;border-bottom:1px solid #DCD6D0;">
                                    <input type="hidden" name="sizes[{{ $index }}][ukuran_id]" value="{{ $size['id'] }}">
                                    <label style="font-size:0.9375rem;font-weight:700;color:#172A39;cursor:pointer;" for="qty-{{ $size['id'] }}">{{ $size['name'] }}</label>
                                    <input
                                        id="qty-{{ $size['id'] }}"
                                        type="number"
                                        min="0"
                                        step="1"
                                        inputmode="numeric"
                                        data-order-qty
                                        name="sizes[{{ $index }}][kuantitas]"
                                        value="{{ $oldQtyBySize->get((string) $size['id'], 0) }}"
                                        style="width:6.5rem;min-height:2.75rem;border:1.5px solid #DCD6D0;background:#F6F4F1;padding:0.625rem 0.875rem;border-radius:0.625rem;font-size:0.9375rem;font-weight:700;color:#172A39;text-align:right;"
                                    >
                                </div>
                            @empty
                                <p class="px-6 py-5 text-sm" style="color:#6E7575;">No sizes are defined for this garment's category yet.</p>
                            @endforelse
                        </div>
                    </fieldset>

                    {{-- ── Design Upload ────────────────── --}}
                    <div class="request-upload-panel" style="border:1.5px solid #DCD6D0;border-radius:1rem;background:linear-gradient(135deg,#FFFFFF 0%,#F6F4F1 100%);padding:1.5rem;">
                        <div class="flex items-start gap-3.5">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl" style="background:#172A39;color:#FC563C;">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M4 16.5v1A2.5 2.5 0 006.5 20h11a2.5 2.5 0 002.5-2.5v-1"/></svg>
                            </span>
                            <div>
                                <label for="upload_design" class="block text-sm font-extrabold" style="color:#172A39;">
                                    Upload your design <span class="font-normal text-xs" style="color:#6E7575;">(optional)</span>
                                </label>
                                <p class="mt-1 text-xs leading-relaxed" style="color:#6E7575;">Tambahkan referensi desain agar tim kami dapat memahami request-mu dengan lebih akurat.</p>
                            </div>
                        </div>
                        <div style="margin-top:1.25rem;border:2px dashed #DCD6D0;border-radius:0.875rem;background:#FFFFFF;padding:1.5rem;text-align:center;">
                            <input
                                id="upload_design" name="upload_design" type="file"
                                accept=".jpg,.jpeg,.png,.webp,.pdf"
                                style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;"
                                onchange="document.getElementById('design-file-name').textContent = this.files.length ? this.files[0].name : 'Belum ada file dipilih';"
                            >
                            <label for="upload_design" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:2.75rem;padding:0.625rem 1.25rem;background:#172A39;color:#FFFFFF;border:1px solid #172A39;border-radius:0.625rem;font-size:0.775rem;font-weight:800;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;box-shadow:0 3px 10px rgba(23,42,57,0.2);transition:all 0.15s;" onmouseover="this.style.background='#0E1B25'" onmouseout="this.style.background='#172A39'">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M4 16.5v1A2.5 2.5 0 006.5 20h11a2.5 2.5 0 002.5-2.5v-1"/></svg>
                                Pilih file desain
                            </label>
                            <p id="design-file-name" style="margin-top:0.75rem;font-size:0.8125rem;font-weight:600;color:#172A39;">Belum ada file dipilih</p>
                            <p style="margin-top:0.25rem;font-size:0.6875rem;color:#8D9494;">JPG, PNG, WEBP, atau PDF · maksimum 5 MB</p>
                        </div>
                    </div>

                    {{-- ── Notes ───────────────────────── --}}
                    <div>
                        <label for="notes" class="block text-xs font-bold mb-2" style="color:#172A39;">
                            Notes <span class="font-normal text-xs" style="color:#6E7575;">(optional)</span>
                        </label>
                        <textarea
                            id="notes" name="notes" rows="4"
                            placeholder="Catatan tambahan seperti detail sablon, bordir, penyesuaian khusus..."
                            class="w-full rounded-xl border px-4 py-3 text-sm transition resize-none"
                            style="border-color:#DCD6D0;background:#FFFFFF;color:#172A39;"
                            onfocus="this.style.borderColor='#FC563C'"
                            onblur="this.style.borderColor='#DCD6D0'"
                        >{{ old('notes') }}</textarea>
                    </div>

                    {{-- ── Total + Submit ───────────────── --}}
                    <div class="request-total-actions">
                        <div style="border:1.5px solid #DCD6D0;border-radius:1rem;background:#F6F4F1;padding:1.5rem;">
                            <p style="font-size:0.75rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:#6E7575;">Estimated Total</p>
                            <p style="margin-top:0.375rem;font-size:2rem;font-weight:900;letter-spacing:-0.03em;color:#172A39;" data-order-total>Rp 0</p>
                            <p style="margin-top:0.375rem;font-size:0.75rem;line-height:1.5;color:#6E7575;">
                                Product price × total quantity — final pricing confirmed by our team.
                            </p>
                        </div>
                        <div style="display:flex;flex-direction:column;justify-content:center;border-radius:1rem;background:#172A39;padding:1.5rem;box-shadow:0 8px 24px rgba(23,42,57,0.25);">
                            <p style="margin:0 0 0.625rem;font-size:0.6875rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.7);">Ready to order?</p>
                            <button
                                type="submit"
                                class="btn-accent shrink-0"
                                style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:3.25rem;padding:0.75rem 1.25rem;background:#FC563C;color:#FFFFFF;border:1px solid #FC563C;border-radius:0.75rem;font-size:0.875rem;font-weight:800;letter-spacing:0.04em;cursor:pointer;box-shadow:0 4px 16px rgba(252,86,60,0.4);transition:all 0.15s;"
                                onmouseover="this.style.background='#E44229';this.style.transform='translateY(-1px)'"
                                onmouseout="this.style.background='#FC563C';this.style.transform='translateY(0)'"
                            >
                                Submit Request
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
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
