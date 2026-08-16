@extends('layouts.admin')

@section('title', 'New Order')

@section('content')
<div
    class="space-y-8 max-w-5xl mx-auto"
    x-data="{
        products: {{ json_encode($products) }},
        selectedProductId: '1',
        qtyS: 10,
        qtyM: 20,
        qtyL: 15,
        qtyXL: 5,
        qtyXXL: 0,
        unitPrice: 185000,
        
        get totalQty() {
            return (parseInt(this.qtyS) || 0) + 
                   (parseInt(this.qtyM) || 0) + 
                   (parseInt(this.qtyL) || 0) + 
                   (parseInt(this.qtyXL) || 0) + 
                   (parseInt(this.qtyXXL) || 0);
        },
        
        get totalPrice() {
            return this.totalQty * (parseInt(this.unitPrice) || 0);
        },
        
        formatRupiah(num) {
            return 'Rp ' + (num || 0).toLocaleString('id-ID');
        }
    }"
>

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase font-mono tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Orders</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">New Custom Order</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Register a direct custom garment production order from a client.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a
                href="{{ route('admin.pesanan.index') }}"
                class="px-5 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-colors inline-block text-center min-w-[90px]"
            >
                Cancel
            </a>
            <button
                type="submit"
                form="create-order-form"
                class="px-6 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer flex items-center gap-2"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Create Order</span>
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. ORDER CREATION FORM                         -->
    <!-- ============================================== -->
    <form id="create-order-form" action="{{ route('admin.pesanan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- SECTION 1: Customer & Shipping Information -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div>
                <h2 class="text-base font-medium text-[#1C1917]">1. Customer Information</h2>
                <p class="text-xs text-[#78716C] mt-0.5">Contact coordinates and shipping destination for the order.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <!-- Customer Name -->
                <div>
                    <label for="customer_name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CUSTOMER NAME <span class="text-[#B85331]">*</span>
                    </label>
                    <input
                        type="text"
                        name="customer_name"
                        id="customer_name"
                        required
                        placeholder="e.g. Ahmad Fauzi"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <!-- Company or Institution -->
                <div>
                    <label for="company_or_institution" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        INSTITUTION / COMPANY (OPTIONAL)
                    </label>
                    <input
                        type="text"
                        name="company_or_institution"
                        id="company_or_institution"
                        placeholder="e.g. PT Sinergi Abadi Kreatif"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        WHATSAPP / PHONE NUMBER <span class="text-[#B85331]">*</span>
                    </label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        required
                        placeholder="0812-3456-7890"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        EMAIL ADDRESS
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="ahmad@sinergi.co.id"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <!-- Shipping Address -->
                <div class="sm:col-span-2">
                    <label for="shipping_address" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        SHIPPING / DELIVERY ADDRESS <span class="text-[#B85331]">*</span>
                    </label>
                    <textarea
                        name="shipping_address"
                        id="shipping_address"
                        rows="2"
                        required
                        placeholder="Jl. Asia Afrika No. 120, Bandung, Jawa Barat 40112"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                    ></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Garment Specification & Size Breakdown -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div>
                <h2 class="text-base font-medium text-[#1C1917]">2. Garment Specifications & Sizes</h2>
                <p class="text-xs text-[#78716C] mt-0.5">Select the apparel catalog item, fabric specification, and size distribution.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <!-- Select Product -->
                <div>
                    <label for="product_id" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        PRODUCT <span class="text-[#B85331]">*</span>
                    </label>
                    <select
                        name="product_id"
                        id="product_id"
                        x-model="selectedProductId"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    >
                        @foreach ($products as $p)
                            <option value="{{ $p['id'] }}">{{ $p['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Material -->
                <div>
                    <label for="material" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        FABRIC MATERIAL <span class="text-[#B85331]">*</span>
                    </label>
                    <select
                        name="material"
                        id="material"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    >
                        @foreach ($materials as $m)
                            <option value="{{ $m }}">{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Size Breakdown Matrix -->
            <div class="pt-4 border-t border-[#EADACE]/70 space-y-3">
                <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    SIZE BREAKDOWN (QUANTITY PER SIZE)
                </label>

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    <div class="p-3 bg-[#FAF7F2]/60 border border-[#EADACE] text-center">
                        <span class="text-xs font-mono font-bold text-[#786C62] block mb-1">SIZE S</span>
                        <input
                            type="number"
                            min="0"
                            x-model="qtyS"
                            class="w-full px-2 py-1.5 bg-white border border-[#D9CCC1] text-center font-mono text-sm font-semibold text-[#1C1917] rounded-none focus:outline-none focus:border-[#B85331]"
                        />
                    </div>
                    <div class="p-3 bg-[#FAF7F2]/60 border border-[#EADACE] text-center">
                        <span class="text-xs font-mono font-bold text-[#786C62] block mb-1">SIZE M</span>
                        <input
                            type="number"
                            min="0"
                            x-model="qtyM"
                            class="w-full px-2 py-1.5 bg-white border border-[#D9CCC1] text-center font-mono text-sm font-semibold text-[#1C1917] rounded-none focus:outline-none focus:border-[#B85331]"
                        />
                    </div>
                    <div class="p-3 bg-[#FAF7F2]/60 border border-[#EADACE] text-center">
                        <span class="text-xs font-mono font-bold text-[#786C62] block mb-1">SIZE L</span>
                        <input
                            type="number"
                            min="0"
                            x-model="qtyL"
                            class="w-full px-2 py-1.5 bg-white border border-[#D9CCC1] text-center font-mono text-sm font-semibold text-[#1C1917] rounded-none focus:outline-none focus:border-[#B85331]"
                        />
                    </div>
                    <div class="p-3 bg-[#FAF7F2]/60 border border-[#EADACE] text-center">
                        <span class="text-xs font-mono font-bold text-[#786C62] block mb-1">SIZE XL</span>
                        <input
                            type="number"
                            min="0"
                            x-model="qtyXL"
                            class="w-full px-2 py-1.5 bg-white border border-[#D9CCC1] text-center font-mono text-sm font-semibold text-[#1C1917] rounded-none focus:outline-none focus:border-[#B85331]"
                        />
                    </div>
                    <div class="p-3 bg-[#FAF7F2]/60 border border-[#EADACE] text-center">
                        <span class="text-xs font-mono font-bold text-[#786C62] block mb-1">SIZE XXL</span>
                        <input
                            type="number"
                            min="0"
                            x-model="qtyXXL"
                            class="w-full px-2 py-1.5 bg-white border border-[#D9CCC1] text-center font-mono text-sm font-semibold text-[#1C1917] rounded-none focus:outline-none focus:border-[#B85331]"
                        />
                    </div>
                </div>
            </div>

            <!-- Price & Quantity Calculation Summary -->
            <div class="p-4 bg-[#FAF7F2] border border-[#EADACE] flex flex-col sm:flex-row sm:items-center justify-between gap-4 font-mono">
                <div class="flex items-center gap-4">
                    <div>
                        <span class="text-[10px] text-[#9E9084] uppercase tracking-wider block">TOTAL UNITS</span>
                        <span class="text-base font-semibold text-[#1C1917]" x-text="totalQty + ' pcs'"></span>
                    </div>
                    <span class="text-[#D9CCC1]">/</span>
                    <div>
                        <span class="text-[10px] text-[#9E9084] uppercase tracking-wider block">UNIT PRICE (DEAL)</span>
                        <div class="flex items-center gap-1">
                            <span class="text-xs text-[#78716C]">Rp</span>
                            <input
                                type="number"
                                x-model="unitPrice"
                                class="w-28 px-2 py-1 bg-white border border-[#D9CCC1] text-xs font-mono font-medium rounded-none focus:outline-none focus:border-[#B85331]"
                            />
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-[10px] text-[#9E9084] uppercase tracking-wider block">ESTIMATED TOTAL</span>
                    <span class="text-lg font-bold text-[#B85331]" x-text="formatRupiah(totalPrice)"></span>
                </div>
            </div>
        </div>

        <!-- SECTION 3: Custom Notes & Design Files -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
            <div>
                <h2 class="text-base font-medium text-[#1C1917]">3. Mockup Design & Production Notes</h2>
                <p class="text-xs text-[#78716C] mt-0.5">Attach custom embroidery/print artwork files and specific notes.</p>
            </div>

            <div class="space-y-4 pt-1">
                <div>
                    <label for="custom_notes" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        PRODUCTION NOTES / PRINT & EMBROIDERY INSTRUCTIONS
                    </label>
                    <textarea
                        name="custom_notes"
                        id="custom_notes"
                        rows="3"
                        placeholder="e.g. Bordir logo dada kiri 7cm, sablon rubber punggung belakang, deadline tgl 30..."
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors leading-relaxed"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        DESIGN MOCKUP / VECTOR ARTWORK (OPTIONAL)
                    </label>
                    <div class="border-2 border-dashed border-[#D9CCC1] p-6 text-center bg-[#FAF7F2]/40 hover:bg-[#FAF7F2] transition-colors relative cursor-pointer">
                        <div class="w-8 h-8 mx-auto text-[#786C62] mb-2">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-[#292524]">Select design file (PDF, PNG, JPG, AI)</p>
                        <p class="text-[10px] text-[#78716C] mt-0.5">Maximum file size 25MB</p>
                        <input type="file" name="design_file" accept=".pdf,.png,.jpg,.jpeg,.ai,.psd" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- BOTTOM ACTION BUTTONS                          -->
        <!-- ============================================== -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#EADACE]/70 mt-8">
            <a
                href="{{ route('admin.pesanan.index') }}"
                class="px-6 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-colors inline-block text-center min-w-[100px]"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="px-7 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase whitespace-nowrap transition-all shadow-xs cursor-pointer inline-block text-center"
            >
                Create Order
            </button>
        </div>

    </form>

</div>
@endsection
