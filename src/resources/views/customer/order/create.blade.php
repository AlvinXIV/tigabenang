@extends('layouts.customer')

@section('title', 'Request Order')
@section('description', 'Request a custom FitVendor garment. No account required.')

@push('vite')
    @vite(['resources/js/customer/order.js'])
@endpush

@section('content')
    <section class="border-b border-line px-5 py-14 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-3xl">
            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">Request</p>
            <h1 class="mt-3 font-serif text-5xl text-charcoal">Tell us what to make</h1>
            <p class="mt-4 text-sm leading-relaxed text-muted">
                No account is created. We use this form to reach you and to calculate the order from product price × total quantity.
            </p>
        </div>
    </section>

    <section class="px-5 py-12 lg:px-8 lg:py-16">
        <div class="mx-auto max-w-3xl">
            @if ($errors->any())
                <div class="mb-8 border border-terracotta/40 bg-paper px-5 py-4 text-sm text-terracotta-dark" role="alert">
                    <p class="font-medium">Please review the form.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($products->isEmpty())
                <x-empty-state title="Nothing to request yet" message="Products need to be added before a production request can be sent." />
            @else
                <form
                    action="{{ route('order.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-10"
                    data-order-form
                    novalidate
                >
                    @csrf
                    @php
                        $orderOld = [
                            'materials' => old('materials', []),
                            'sizes' => old('sizes', []),
                        ];
                        $selectedProductId = old('produk_id', $selected?->id_produk);
                        $selectedCatalog = collect($catalog)->firstWhere('id', (int) $selectedProductId)
                            ?? collect($catalog)->first();
                        $selectedMaterials = collect($selectedCatalog['materials'] ?? []);
                        $selectedSizes = collect($selectedCatalog['sizes'] ?? []);
                        $oldMaterialIds = collect($orderOld['materials'])->map(fn ($id) => (string) $id);
                        $oldQtyBySize = collect($orderOld['sizes'])->mapWithKeys(function ($row) {
                            return [(string) ($row['ukuran_id'] ?? '') => $row['kuantitas'] ?? 0];
                        });
                    @endphp
                    <script type="application/json" data-order-catalog>@json($catalog)</script>
                    <script type="application/json" data-order-old>@json($orderOld)</script>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="nama" class="text-[11px] uppercase tracking-[0.2em] text-muted">Name</label>
                            <input id="nama" name="nama" type="text" required value="{{ old('nama') }}" class="mt-2 w-full border-b border-line bg-transparent py-3 text-charcoal placeholder:text-muted/60" placeholder="Your full name">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="alamat" class="text-[11px] uppercase tracking-[0.2em] text-muted">Address</label>
                            <textarea id="alamat" name="alamat" rows="3" required class="mt-2 w-full border-b border-line bg-transparent py-3 text-charcoal">{{ old('alamat') }}</textarea>
                        </div>
                        <div>
                            <label for="no_hp" class="text-[11px] uppercase tracking-[0.2em] text-muted">Phone</label>
                            <input id="no_hp" name="no_hp" type="tel" required value="{{ old('no_hp') }}" class="mt-2 w-full border-b border-line bg-transparent py-3">
                        </div>
                        <div>
                            <label for="produk_id" class="text-[11px] uppercase tracking-[0.2em] text-muted">Product</label>
                            <select id="produk_id" name="produk_id" required data-order-product class="mt-2 w-full border-b border-line bg-transparent py-3">
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

                    <fieldset>
                        <legend class="text-[11px] uppercase tracking-[0.2em] text-muted">Materials</legend>
                        <p class="mt-2 text-sm text-muted">Select one or more bahan for this request.</p>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2" data-order-materials>
                            @forelse ($selectedMaterials as $index => $material)
                                @php
                                    $checked = $oldMaterialIds->isNotEmpty()
                                        ? $oldMaterialIds->contains((string) $material['id'])
                                        : $index === 0;
                                @endphp
                                <label class="flex items-center gap-3 border border-line px-4 py-3 text-sm">
                                    <input type="checkbox" name="materials[]" value="{{ $material['id'] }}" class="accent-terracotta" @checked($checked)>
                                    <span>{{ $material['name'] }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-muted sm:col-span-2">No materials are paired with this garment yet.</p>
                            @endforelse
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="text-[11px] uppercase tracking-[0.2em] text-muted">Size &amp; quantity</legend>
                        <p class="mt-2 text-sm text-muted">Sizes come from the product’s category. Enter a quantity for each size you need.</p>
                        <div class="mt-5 divide-y divide-line border-y border-line" data-order-sizes>
                            @forelse ($selectedSizes as $index => $size)
                                <div class="flex items-center justify-between gap-4 py-4" data-ukuran-id="{{ $size['id'] }}">
                                    <input type="hidden" name="sizes[{{ $index }}][ukuran_id]" value="{{ $size['id'] }}">
                                    <label class="text-sm tracking-[0.12em]" for="qty-{{ $size['id'] }}">{{ $size['name'] }}</label>
                                    <input
                                        id="qty-{{ $size['id'] }}"
                                        type="number"
                                        min="0"
                                        step="1"
                                        inputmode="numeric"
                                        data-order-qty
                                        name="sizes[{{ $index }}][kuantitas]"
                                        value="{{ $oldQtyBySize->get((string) $size['id'], 0) }}"
                                        class="w-24 border-b border-line bg-transparent py-2 text-right"
                                    >
                                </div>
                            @empty
                                <p class="py-4 text-sm text-muted">No sizes are defined for this garment’s category yet.</p>
                            @endforelse
                        </div>
                    </fieldset>

                    <div>
                        <label for="upload_design" class="text-[11px] uppercase tracking-[0.2em] text-muted">Design upload <span class="text-muted/70">(optional)</span></label>
                        <input id="upload_design" name="upload_design" type="file" accept=".jpg,.jpeg,.png,.webp,.pdf" class="mt-3 block w-full text-sm text-muted file:mr-4 file:border file:border-line file:bg-transparent file:px-4 file:py-2 file:text-[11px] file:uppercase file:tracking-[0.16em] file:text-charcoal">
                    </div>

                    <div>
                        <label for="notes" class="text-[11px] uppercase tracking-[0.2em] text-muted">Notes <span class="text-muted/70">(optional)</span></label>
                        <textarea id="notes" name="notes" rows="4" class="mt-2 w-full border-b border-line bg-transparent py-3">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex flex-col gap-2 border-t border-line pt-8 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.2em] text-muted">Estimated total</p>
                            <p class="mt-2 font-serif text-3xl text-charcoal" data-order-total>Rp 0</p>
                            <p class="mt-1 text-xs text-muted">
                                Product price × total quantity. This is an estimated total — final pricing will be confirmed with our team.
                            </p>
                        </div>
                        <button type="submit" class="bg-charcoal px-8 py-3 text-[11px] uppercase tracking-[0.22em] text-ivory hover:bg-terracotta">
                            Submit request
                        </button>
                    </div>
                    </form>
                    <script>
                        (function () {
                            const form = document.querySelector('[data-order-form]');
                            if (!form) {
                                return;
                            }

                            const formatRupiah = (value) =>
                                `Rp ${Math.round(Math.max(0, Number(value) || 0)).toLocaleString('id-ID')}`;

                            const productSelect = form.querySelector('[data-order-product]');
                            const totalNode = form.querySelector('[data-order-total]');
                            const catalogNode = form.querySelector('[data-order-catalog]');

                            let catalog = [];
                            try {
                                catalog = JSON.parse(catalogNode?.textContent || '[]') || [];
                            } catch {
                                catalog = [];
                            }

                            const productPrice = () => {
                                const fromOption = Number(productSelect?.selectedOptions?.[0]?.dataset?.price);
                                if (Number.isFinite(fromOption) && fromOption >= 0) {
                                    return fromOption;
                                }

                                const product = catalog.find((item) => String(item.id) === String(productSelect?.value));
                                return Number(product?.price) || 0;
                            };

                            const quantityInputs = () =>
                                form.querySelectorAll('[data-order-qty], input[name*="[kuantitas]"]');

                            const updateEstimate = () => {
                                if (!totalNode) {
                                    return;
                                }

                                const totalQuantity = [...quantityInputs()].reduce(
                                    (sum, input) => sum + Math.max(0, Number(input.value) || 0),
                                    0,
                                );

                                totalNode.textContent = formatRupiah(productPrice() * totalQuantity);
                            };

                            form.addEventListener('input', updateEstimate);
                            form.addEventListener('change', updateEstimate);
                            updateEstimate();

                            window.updateOrderEstimate = updateEstimate;

                            productSelect?.addEventListener('change', function () {
                                if (window.FitVendorOrder) {
                                    return;
                                }

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
