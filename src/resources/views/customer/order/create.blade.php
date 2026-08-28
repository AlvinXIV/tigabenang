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
            padding: 1rem 1.75rem !important;
            border-bottom: 1px solid #D8DDEF !important;
        }
        [data-order-sizes] > [data-ukuran-id]:last-child { border-bottom: 0 !important; }
        [data-order-sizes] input[type="number"] {
            width: 6.5rem !important;
            min-height: 2.75rem !important;
            padding: 0.625rem 0.875rem !important;
            border: 1px solid #B3BCDA !important;
            border-radius: 0.625rem !important;
            background: #F5F7FF !important;
        }
        .request-total-actions { display:grid; grid-template-columns:1fr; gap:1rem; }
        .request-total-actions button { width:100%; }
    </style>

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="relative overflow-hidden border-b border-border bg-primary">
        <div class="pointer-events-none absolute -right-24 -top-32 h-80 w-80 rounded-full bg-accent/10"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-20 h-64 w-64 rounded-full border-[24px] border-white/5"></div>
        <div class="relative mx-auto max-w-3xl px-5 py-14 lg:px-8 lg:py-20">
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-accent/40 bg-accent/15 px-3.5 py-1.5 text-[0.68rem] font-bold uppercase tracking-[0.16em] text-accent">
                <span class="h-2 w-2 rounded-full bg-accent"></span>
                Custom order studio
            </div>
            <h1 class="max-w-xl text-4xl font-extrabold tracking-tight text-white md:text-5xl">Tell us what to make</h1>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-white/70">
                No account is created. We use this form to reach you and to calculate the order from product price × total quantity.
            </p>
        </div>
    </section>

    <section class="px-5 py-12 lg:px-8 lg:py-16">
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
                        <legend class="text-xs font-semibold uppercase tracking-[0.12em] text-text-subtle mb-5">Contact Information</legend>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="nama" class="block text-xs font-semibold text-text-muted mb-1.5">Full Name</label>
                                <input
                                    id="nama" name="nama" type="text" required
                                    value="{{ old('nama') }}"
                                    placeholder="Your full name"
                                    class="w-full rounded-lg border border-border bg-white px-4 py-2.5 text-sm text-text-base placeholder:text-text-subtle focus:border-primary focus:ring-1 focus:ring-primary transition"
                                >
                            </div>
                            <div class="sm:col-span-2">
                                <label for="alamat" class="block text-xs font-semibold text-text-muted mb-1.5">Delivery Address</label>
                                <textarea
                                    id="alamat" name="alamat" rows="3" required
                                    class="w-full rounded-lg border border-border bg-white px-4 py-2.5 text-sm text-text-base focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"
                                >{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <label for="no_hp" class="block text-xs font-semibold text-text-muted mb-1.5">Phone Number</label>
                                <input
                                    id="no_hp" name="no_hp" type="tel" required
                                    value="{{ old('no_hp') }}"
                                    class="w-full rounded-lg border border-border bg-white px-4 py-2.5 text-sm text-text-base focus:border-primary focus:ring-1 focus:ring-primary transition"
                                >
                            </div>
                            <div>
                                <label for="produk_id" class="block text-xs font-semibold text-text-muted mb-1.5">Product</label>
                                <select
                                    id="produk_id" name="produk_id" required
                                    data-order-product
                                    class="w-full rounded-lg border border-border bg-white px-4 py-2.5 text-sm text-text-base focus:border-primary focus:ring-1 focus:ring-primary transition"
                                >
                                    @foreach ($products as $produk)
                                        <option
                                            value="{{ $produk->id_produk }}"
                                            data-price="{{ (float) $produk->harga }}"
                                            @selected((string) $selectedProductId === (string) $produk->id_produk)
                                        >
                                            {{ $produk->nama_produk }}
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
                        <legend class="text-xs font-semibold uppercase tracking-[0.12em] text-text-subtle mb-1.5">Size & Quantity</legend>
                        <p class="text-xs text-text-muted mb-4">Sizes come from the product's category. Enter a quantity for each size you need.</p>
                        <div class="request-size-list" data-order-sizes style="overflow:hidden;border:1px solid #B3BCDA;border-radius:1rem;background:#FFFFFF;box-shadow:0 8px 24px rgba(1,31,123,0.06);">
                            @forelse ($selectedSizes as $index => $size)
                                <div class="request-size-row flex items-center justify-between gap-4 border-b border-border last:border-0 bg-white" data-ukuran-id="{{ $size['id'] }}" style="min-height:5rem;padding:1rem 1.5rem;">
                                    <input type="hidden" name="sizes[{{ $index }}][ukuran_id]" value="{{ $size['id'] }}">
                                    <label class="text-sm font-semibold text-text-base" for="qty-{{ $size['id'] }}">{{ $size['name'] }}</label>
                                    <input
                                        id="qty-{{ $size['id'] }}"
                                        type="number"
                                        min="0"
                                        step="1"
                                        inputmode="numeric"
                                        data-order-qty
                                        name="sizes[{{ $index }}][kuantitas]"
                                        value="{{ $oldQtyBySize->get((string) $size['id'], 0) }}"
                                        class="w-24 rounded-lg border border-border bg-surface-alt px-3 py-2 text-right text-sm font-semibold text-text-base focus:border-primary focus:ring-1 focus:ring-primary transition"
                                        style="width:6.5rem;min-height:2.75rem;border:1px solid #B3BCDA;background:#F5F7FF;padding:0.625rem 0.875rem;border-radius:0.625rem;"
                                    >
                                </div>
                            @empty
                                <p class="px-5 py-4 text-sm text-text-muted">No sizes are defined for this garment's category yet.</p>
                            @endforelse
                        </div>
                    </fieldset>

                    {{-- ── Design Upload ────────────────── --}}
                    <div class="request-upload-panel" style="border:1px solid #B3BCDA;border-radius:1rem;background:linear-gradient(135deg,#FFFFFF 0%,#F5F7FF 100%);padding:1.25rem;">
                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary text-accent">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M4 16.5v1A2.5 2.5 0 006.5 20h11a2.5 2.5 0 002.5-2.5v-1"/></svg>
                            </span>
                            <div>
                                <label for="upload_design" class="block text-sm font-bold text-primary">
                                    Upload your design <span class="font-normal text-text-subtle">(optional)</span>
                                </label>
                                <p class="mt-1 text-xs leading-relaxed text-text-muted">Tambahkan referensi desain agar tim kami dapat memahami request-mu dengan lebih akurat.</p>
                            </div>
                        </div>
                        <div style="margin-top:1rem;border:2px dashed #B3BCDA;border-radius:0.75rem;background:#FFFFFF;padding:1rem;text-align:center;">
                            <input
                                id="upload_design" name="upload_design" type="file"
                                accept=".jpg,.jpeg,.png,.webp,.pdf"
                                style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;"
                                onchange="document.getElementById('design-file-name').textContent = this.files.length ? this.files[0].name : 'Belum ada file dipilih';"
                            >
                            <label for="upload_design" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:2.75rem;padding:0.625rem 1rem;background:#011F7B;color:#FFFFFF;border:1px solid #011F7B;border-radius:0.625rem;font-size:0.75rem;font-weight:800;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;box-shadow:0 3px 10px rgba(1,31,123,0.2);">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M4 16.5v1A2.5 2.5 0 006.5 20h11a2.5 2.5 0 002.5-2.5v-1"/></svg>
                                Pilih file desain
                            </label>
                            <p id="design-file-name" style="margin-top:0.625rem;font-size:0.75rem;font-weight:600;color:#4E5A88;">Belum ada file dipilih</p>
                            <p style="margin-top:0.25rem;font-size:0.6875rem;color:#8892B8;">JPG, PNG, WEBP, atau PDF · maksimum 5 MB</p>
                        </div>
                    </div>

                    {{-- ── Notes ───────────────────────── --}}
                    <div>
                        <label for="notes" class="block text-xs font-semibold text-text-muted mb-1.5">
                            Notes <span class="text-text-subtle font-normal">(optional)</span>
                        </label>
                        <textarea
                            id="notes" name="notes" rows="4"
                            class="w-full rounded-lg border border-border bg-white px-4 py-2.5 text-sm text-text-base focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"
                        >{{ old('notes') }}</textarea>
                    </div>

                    {{-- ── Total + Submit ───────────────── --}}
                    <div class="request-total-actions">
                        <div style="border:1px solid #B3BCDA;border-radius:1rem;background:#F5F7FF;padding:1.25rem 1.5rem;">
                            <p style="font-size:0.75rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:#4E5A88;">Estimated Total</p>
                            <p style="margin-top:0.375rem;font-size:2rem;font-weight:900;letter-spacing:-0.03em;color:#011F7B;" data-order-total>Rp 0</p>
                            <p style="margin-top:0.375rem;font-size:0.75rem;line-height:1.5;color:#4E5A88;">
                                Product price × total quantity — final pricing confirmed by our team.
                            </p>
                        </div>
                        <div style="display:flex;flex-direction:column;justify-content:center;width:100%;border-radius:1rem;background:#011F7B;padding:1rem 1.25rem;box-shadow:0 8px 20px rgba(1,31,123,0.2);">
                            <p style="margin:0 0 0.625rem;font-size:0.6875rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.65);">Ready to order?</p>
                            <button
                                type="submit"
                                class="btn-primary shrink-0"
                                style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:3rem;padding:0.75rem 1rem;background:#FFBA09;color:#011F7B;border:2px solid #FFBA09;border-radius:0.75rem;font-size:0.8125rem;font-weight:800;letter-spacing:0.04em;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,0.18);"
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
