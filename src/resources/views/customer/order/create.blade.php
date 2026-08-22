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
                                    <option value="{{ $produk->id_produk }}" @selected((string) $selectedProductId === (string) $produk->id_produk)>
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
                            {{-- Populated by order.js from the selected product --}}
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="text-[11px] uppercase tracking-[0.2em] text-muted">Size &amp; quantity</legend>
                        <p class="mt-2 text-sm text-muted">Sizes come from the product’s category. Enter a quantity for each size you need.</p>
                        <div class="mt-5 divide-y divide-line border-y border-line" data-order-sizes></div>
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
                            <p class="mt-1 text-xs text-muted">Calculated as product price × total quantity. The server recalculates the final amount.</p>
                        </div>
                        <button type="submit" class="bg-charcoal px-8 py-3 text-[11px] uppercase tracking-[0.22em] text-ivory hover:bg-terracotta">
                            Submit request
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </section>
@endsection
