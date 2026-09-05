@extends('layouts.deal-order')

@section('title', 'Formulir Konfirmasi Pemesanan')
@section('description', 'Formulir resmi permintaan pesanan pakaian custom Tigabenang Atelier.')

@section('content')

    {{-- ── Banner Header ────────────────────────────────────────── --}}
    <section style="background:#172A39;color:#FFFFFF;padding:3.5rem 0;border-bottom:1.5px solid #DCD6D0;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-6rem;right:-6rem;width:22rem;height:22rem;border-radius:50%;background:rgba(234,226,216,0.06);pointer-events:none;"></div>
        <div style="position:absolute;bottom:-6rem;left:-6rem;width:18rem;height:18rem;border-radius:50%;border:16px solid rgba(234,226,216,0.04);pointer-events:none;"></div>

        <div class="mx-auto max-w-4xl px-5 lg:px-8 relative">
            <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.35rem 1rem;background:rgba(234,226,216,0.12);border:1px solid rgba(234,226,216,0.25);border-radius:9999px;font-size:0.75rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#EAE2D8;margin-bottom:1rem;">
                <span style="width:6px;height:6px;border-radius:50%;background:#EAE2D8;"></span>
                Official Order Form
            </div>
            <h1 style="font-size:clamp(1.85rem, 3.5vw, 2.75rem);font-weight:900;letter-spacing:-0.03em;line-height:1.15;margin:0;color:#FFFFFF;">
                Formulir Pemesanan
            </h1>
            <p style="margin-top:0.875rem;font-size:0.9375rem;line-height:1.7;color:rgba(255,255,255,0.8);max-width:640px;">
                Lengkapi rincian pesanan berikut untuk pengajuan pesanan dengan tim Tigabenang. Data ini akan menjadi acuan konfirmasi spesifikasi pakaian dan antrean produksi Anda.
            </p>
        </div>
    </section>

    {{-- ── Form Section ─────────────────────────────────────────── --}}
    <section style="background:#FAF8F5;padding:3.5rem 0 5rem;">
        <div class="mx-auto max-w-4xl px-5 lg:px-8">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div style="background:#FDF2F2;border:1.5px solid #F87171;border-radius:1.25rem;padding:1.5rem;margin-bottom:2.5rem;box-shadow:0 6px 16px rgba(239,68,68,0.08);">
                    <div style="display:flex;align-items:flex-start;gap:0.875rem;">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#DC2626" stroke-width="2" style="flex-shrink:0;margin-top:2px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <p style="font-size:0.9375rem;font-weight:800;color:#991B1B;margin:0;">Mohon periksa kembali formulir Anda:</p>
                            <ul style="margin:0.5rem 0 0;padding-left:1.25rem;font-size:0.875rem;color:#B91C1C;line-height:1.6;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $oldProduct = old('produk_id', $selected?->id_produk);
                $oldMaterials = collect(old('materials', []))->map(fn ($id) => (int) $id);
                $oldSizes = collect(old('sizes', []))->keyBy('ukuran_id');
            @endphp

            <form
                action="{{ route('deal-order.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="deal-order-form"
                novalidate
                style="display:flex;flex-direction:column;gap:2rem;"
            >
                @csrf

                {{-- JSON Catalog for dynamic JS updates --}}
                <script type="application/json" id="deal-order-catalog-json">@json($catalog)</script>

                {{-- ═══════════════════════════════════════════
                    STEP 1: INFORMASI PEMESAN (CONTACT & DELIVERY)
                ═══════════════════════════════════════════ --}}
                <div style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2.25rem;box-shadow:0 6px 20px rgba(23,42,57,0.03);">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1.5px solid #EAE2D8;">
                        <span style="width:2rem;height:2rem;border-radius:50%;background:#172A39;color:#FFFFFF;display:flex;align-items:center;justify-content:center;font-size:0.8125rem;font-weight:900;">1</span>
                        <div>
                            <h2 style="font-size:1.125rem;font-weight:800;color:#172A39;margin:0;">Informasi Pemesan &amp; Alamat Pengiriman</h2>
                            <p style="font-size:0.75rem;color:#6E7575;margin:0.15rem 0 0;">Data PIC pemesan dan tujuan pengiriman paket produksi.</p>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr;gap:1.25rem;">
                        <div>
                            <label for="nama" style="display:block;font-size:0.8125rem;font-weight:800;color:#172A39;margin-bottom:0.4rem;">
                                Nama Lengkap / PIC Pemesan <span style="color:#DC2626;">*</span>
                            </label>
                            <input
                                id="nama" name="nama" type="text" required
                                value="{{ old('nama') }}"
                                placeholder="Contoh: Bagus Pratama (Studio Karsa)"
                                style="width:100%;border:1.5px solid #DCD6D0;border-radius:0.875rem;padding:0.75rem 1rem;font-size:0.9375rem;color:#172A39;background:#FAF8F5;outline:none;transition:border-color 0.2s;"
                                onfocus="this.style.borderColor='#172A39';this.style.background='#FFFFFF';"
                                onblur="this.style.borderColor='#DCD6D0';this.style.background='#FAF8F5';"
                            >
                        </div>

                        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:1.25rem;">
                            <div>
                                <label for="no_hp" style="display:block;font-size:0.8125rem;font-weight:800;color:#172A39;margin-bottom:0.4rem;">
                                    Nomor WhatsApp Aktif <span style="color:#DC2626;">*</span>
                                </label>
                                <input
                                    id="no_hp" name="no_hp" type="tel" required
                                    value="{{ old('no_hp') }}"
                                    placeholder="Contoh: 081234567890"
                                    style="width:100%;border:1.5px solid #DCD6D0;border-radius:0.875rem;padding:0.75rem 1rem;font-size:0.9375rem;color:#172A39;background:#FAF8F5;outline:none;transition:border-color 0.2s;"
                                    onfocus="this.style.borderColor='#172A39';this.style.background='#FFFFFF';"
                                    onblur="this.style.borderColor='#DCD6D0';this.style.background='#FAF8F5';"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="alamat" style="display:block;font-size:0.8125rem;font-weight:800;color:#172A39;margin-bottom:0.4rem;">
                                Alamat Lengkap Pengiriman <span style="color:#DC2626;">*</span>
                            </label>
                            <textarea
                                id="alamat" name="alamat" rows="3" required
                                placeholder="Tuliskan nama jalan, nomor bangunan, RT/RW, kelurahan, kecamatan, kota/kabupaten, dan kode pos"
                                style="width:100%;border:1.5px solid #DCD6D0;border-radius:0.875rem;padding:0.75rem 1rem;font-size:0.9375rem;color:#172A39;background:#FAF8F5;outline:none;resize:vertical;transition:border-color 0.2s;"
                                onfocus="this.style.borderColor='#172A39';this.style.background='#FFFFFF';"
                                onblur="this.style.borderColor='#DCD6D0';this.style.background='#FAF8F5';"
                            >{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════
                    STEP 2: PRODUK YANG DISEPAKATI (PRODUCT SELECTION)
                ═══════════════════════════════════════════ --}}
                <div style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2.25rem;box-shadow:0 6px 20px rgba(23,42,57,0.03);">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1.5px solid #EAE2D8;">
                        <span style="width:2rem;height:2rem;border-radius:50%;background:#172A39;color:#FFFFFF;display:flex;align-items:center;justify-content:center;font-size:0.8125rem;font-weight:900;">2</span>
                        <div>
                            <h2 style="font-size:1.125rem;font-weight:800;color:#172A39;margin:0;">Pilihan Produk Pakaian</h2>
                            <p style="font-size:0.75rem;color:#6E7575;margin:0.15rem 0 0;">Pilih tipe produk pakaian custom yang telah disepakati.</p>
                        </div>
                    </div>

                    <div>
                        <label for="produk_id" style="display:block;font-size:0.8125rem;font-weight:800;color:#172A39;margin-bottom:0.4rem;">
                            Model / Tipe Produk <span style="color:#DC2626;">*</span>
                        </label>
                        <select
                            id="produk_id" name="produk_id" required
                            style="width:100%;border:1.5px solid #DCD6D0;border-radius:0.875rem;padding:0.875rem 1.25rem;font-size:1rem;font-weight:700;color:#172A39;background:#FAF8F5;outline:none;cursor:pointer;transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#172A39';this.style.background='#FFFFFF';"
                            onblur="this.style.borderColor='#DCD6D0';this.style.background='#FAF8F5';"
                        >
                            @foreach ($products as $produk)
                                <option
                                    value="{{ $produk->id_produk }}"
                                    data-price="{{ (float) $produk->harga }}"
                                    data-category="{{ $produk->kategori?->nama_kategori }}"
                                    @selected((int) $oldProduct === (int) $produk->id_produk)
                                >
                                    {{ $produk->nama_produk }} ({{ $produk->kategori?->nama_kategori ?? 'Custom' }}) — Rp {{ number_format((float) $produk->harga, 0, ',', '.') }} / pcs
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════
                    STEP 3: PILIHAN BAHAN / MATERIAL KAIN (NEW REQUESTED SECTION!)
                ═══════════════════════════════════════════ --}}
                <div style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2.25rem;box-shadow:0 6px 20px rgba(23,42,57,0.03);">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1.5px solid #EAE2D8;flex-wrap:wrap;gap:0.75rem;">
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <span style="width:2rem;height:2rem;border-radius:50%;background:#172A39;color:#FFFFFF;display:flex;align-items:center;justify-content:center;font-size:0.8125rem;font-weight:900;">3</span>
                            <div>
                                <h2 style="font-size:1.125rem;font-weight:800;color:#172A39;margin:0;">Pilihan Bahan / Material Kain <span style="color:#DC2626;">*</span></h2>
                                <p style="font-size:0.75rem;color:#6E7575;margin:0.15rem 0 0;">Pilih satu atau lebih jenis bahan kain yang disepakati untuk pakaian ini.</p>
                            </div>
                        </div>
                        <span style="font-size:0.6875rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:#172A39;background:#FAF8F5;border:1px solid #DCD6D0;border-radius:9999px;padding:0.25rem 0.75rem;">
                            Bisa Pilih > 1 Bahan
                        </span>
                    </div>

                    {{-- Material Selection Grid Cards --}}
                    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:1rem;" id="deal-materials-container">
                        @foreach ($allMaterials as $m)
                            @php
                                $isMaterialChecked = $oldMaterials->isNotEmpty()
                                    ? $oldMaterials->contains((int) $m->id_bahan)
                                    : ($selected && $selected->bahan->pluck('id_bahan')->contains($m->id_bahan));
                            @endphp
                            <label
                                class="deal-material-card"
                                data-material-id="{{ $m->id_bahan }}"
                                style="border:1.5px solid {{ $isMaterialChecked ? '#172A39' : '#DCD6D0' }};background:{{ $isMaterialChecked ? '#FAF8F5' : '#FFFFFF' }};border-radius:1rem;padding:1.25rem;display:flex;align-items:center;gap:0.875rem;cursor:pointer;transition:all 0.2s;"
                                onmouseover="if(!this.querySelector('input').checked){this.style.borderColor='#172A39';this.style.background='#FAF8F5';}"
                                onmouseout="if(!this.querySelector('input').checked){this.style.borderColor='#DCD6D0';this.style.background='#FFFFFF';}"
                            >
                                <input
                                    type="checkbox"
                                    name="materials[]"
                                    value="{{ $m->id_bahan }}"
                                    class="deal-material-checkbox"
                                    style="width:1.25rem;height:1.25rem;accent-color:#172A39;cursor:pointer;flex-shrink:0;"
                                    @checked($isMaterialChecked)
                                    onchange="
                                        const card = this.closest('.deal-material-card');
                                        if (this.checked) {
                                            card.style.borderColor = '#172A39';
                                            card.style.background = '#FAF8F5';
                                        } else {
                                            card.style.borderColor = '#DCD6D0';
                                            card.style.background = '#FFFFFF';
                                        }
                                    "
                                >
                                <div>
                                    <p style="font-size:0.9375rem;font-weight:800;color:#172A39;margin:0;">
                                        {{ $m->nama_bahan }}
                                    </p>
                                    <p style="font-size:0.6875rem;color:#6E7575;margin:0.15rem 0 0;">
                                        Atelier Material
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════
                    STEP 4: RINCIAN UKURAN & KUANTITAS (SIZE BREAKDOWN)
                ═══════════════════════════════════════════ --}}
                <div style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2.25rem;box-shadow:0 6px 20px rgba(23,42,57,0.03);">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1.5px solid #EAE2D8;flex-wrap:wrap;gap:0.75rem;">
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <span style="width:2rem;height:2rem;border-radius:50%;background:#172A39;color:#FFFFFF;display:flex;align-items:center;justify-content:center;font-size:0.8125rem;font-weight:900;">4</span>
                            <div>
                                <h2 style="font-size:1.125rem;font-weight:800;color:#172A39;margin:0;">Rincian Ukuran &amp; Jumlah Pesanan <span style="color:#DC2626;">*</span></h2>
                                <p style="font-size:0.75rem;color:#6E7575;margin:0.15rem 0 0;">Masukkan kuantitas (jumlah) pakaian untuk masing-masing ukuran (Pcs).</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;font-weight:800;color:#172A39;background:#FAF8F5;border:1px solid #DCD6D0;border-radius:9999px;padding:0.35rem 1rem;">
                            <span>Total Pcs:</span>
                            <span id="deal-total-pcs" style="color:#172A39;font-size:1rem;">0 Pcs</span>
                        </div>
                    </div>

                    {{-- Sizes Container Table --}}
                    <div id="deal-sizes-container" style="border:1.5px solid #DCD6D0;border-radius:1rem;overflow:hidden;background:#FFFFFF;">
                        {{-- Populated dynamically by JavaScript based on selected product --}}
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════
                    STEP 5: UPLOAD DESAIN & CATATAN KHUSUS (NOTES & DESIGN)
                ═══════════════════════════════════════════ --}}
                <div style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2.25rem;box-shadow:0 6px 20px rgba(23,42,57,0.03);">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1.5px solid #EAE2D8;">
                        <span style="width:2rem;height:2rem;border-radius:50%;background:#172A39;color:#FFFFFF;display:flex;align-items:center;justify-content:center;font-size:0.8125rem;font-weight:900;">5</span>
                        <div>
                            <h2 style="font-size:1.125rem;font-weight:800;color:#172A39;margin:0;">Upload Desain &amp; Catatan Khusus</h2>
                            <p style="font-size:0.75rem;color:#6E7575;margin:0.15rem 0 0;">Sertakan file mockup / referensi desain dan detail catatan pengerjaan.</p>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr;gap:1.5rem;">
                        {{-- Upload Box --}}
                        <div style="border:1.5px solid #DCD6D0;border-radius:1rem;background:linear-gradient(135deg,#FFFFFF 0%,#FAF8F5 100%);padding:1.5rem;">
                            <div style="display:flex;align-items:flex-start;gap:0.875rem;">
                                <div style="width:2.75rem;height:2.75rem;border-radius:0.75rem;background:#172A39;color:#EAE2D8;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M4 16.5v1A2.5 2.5 0 006.5 20h11a2.5 2.5 0 002.5-2.5v-1"/>
                                    </svg>
                                </div>
                                <div>
                                    <label for="upload_design" style="display:block;font-size:0.9375rem;font-weight:800;color:#172A39;margin:0;">
                                        Upload File Desain / Mockup <span style="font-size:0.75rem;font-weight:500;color:#6E7575;">(Opsional)</span>
                                    </label>
                                    <p style="font-size:0.75rem;color:#6E7575;margin:0.2rem 0 0;">
                                        Unggah file desain akhir yang telah disepakati untuk panduan penjahit dan QC atelier.
                                    </p>
                                </div>
                            </div>

                            <div style="margin-top:1.25rem;border:2px dashed #DCD6D0;border-radius:0.875rem;background:#FFFFFF;padding:1.5rem;text-align:center;">
                                <input
                                    id="upload_design" name="upload_design" type="file"
                                    accept=".jpg,.jpeg,.png,.webp,.pdf"
                                    style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;"
                                    onchange="document.getElementById('deal-design-name').textContent = this.files.length ? this.files[0].name : 'Belum ada file dipilih';"
                                >
                                <label for="upload_design" class="deal-btn-pill" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;min-height:2.75rem;padding:0.625rem 1.75rem;background:#172A39;color:#FFFFFF;border:1px solid #172A39;font-size:0.8125rem;font-weight:800;letter-spacing:0.04em;text-transform:uppercase;cursor:pointer;box-shadow:0 4px 12px rgba(23,42,57,0.18);">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M4 16.5v1A2.5 2.5 0 006.5 20h11a2.5 2.5 0 002.5-2.5v-1"/></svg>
                                    Pilih File Desain
                                </label>
                                <p id="deal-design-name" style="margin-top:0.75rem;font-size:0.8125rem;font-weight:700;color:#172A39;">Belum ada file dipilih</p>
                                <p style="margin-top:0.2rem;font-size:0.6875rem;color:#8D9494;">Format yang didukung: JPG, PNG, WEBP, atau PDF (Maksimal 5 MB)</p>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="notes" style="display:block;font-size:0.8125rem;font-weight:800;color:#172A39;margin-bottom:0.4rem;">
                                Catatan Khusus Produksi <span style="font-size:0.75rem;font-weight:500;color:#6E7575;">(Opsional)</span>
                            </label>
                            <textarea
                                id="notes" name="notes" rows="4"
                                placeholder="Tuliskan catatan khusus kesepakatan seperti: jenis sablon/bordir, warna benang, letak logo dada kiri/punggung, detail resleting, dll."
                                style="width:100%;border:1.5px solid #DCD6D0;border-radius:0.875rem;padding:0.75rem 1rem;font-size:0.9375rem;color:#172A39;background:#FAF8F5;outline:none;resize:vertical;transition:border-color 0.2s;"
                                onfocus="this.style.borderColor='#172A39';this.style.background='#FFFFFF';"
                                onblur="this.style.borderColor='#DCD6D0';this.style.background='#FAF8F5';"
                            >{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════
                    STEP 6: RINGKASAN TOTAL & SUBMIT KONFIRMASI
                ═══════════════════════════════════════════ --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1.5rem;">
                    {{-- Total Estimation Card --}}
                    <div style="background:#FFFFFF;border:1.5px solid #DCD6D0;border-radius:1.5rem;padding:2rem;box-shadow:0 6px 20px rgba(23,42,57,0.03);display:flex;flex-direction:column;justify-content:center;">
                        <p style="font-size:0.75rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:#6E7575;margin:0;">
                            Estimasi Total Pesanan
                        </p>
                        <p id="deal-total-price" style="font-size:2.25rem;font-weight:900;letter-spacing:-0.03em;color:#172A39;margin:0.35rem 0 0;">
                            Rp 0
                        </p>
                        <p style="font-size:0.75rem;color:#6E7575;margin:0.35rem 0 0;line-height:1.5;">
                            Harga satuan produk × total kuantitas seluruh ukuran.
                        </p>
                    </div>

                    {{-- Submit Button Card --}}
                    <div style="background:#172A39;border-radius:1.5rem;padding:2rem;box-shadow:0 10px 30px rgba(23,42,57,0.25);display:flex;flex-direction:column;justify-content:center;align-items:stretch;">
                        <p style="font-size:0.75rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.7);margin:0 0 0.875rem;">
                            Periksa Rincian Permintaan Anda
                        </p>
                        <button
                            type="submit"
                            class="deal-btn-pill"
                            style="width:100%;min-height:3.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg, #FAF8F5 0%, #EAE2D8 100%);color:#172A39;border:2px solid #EAE2D8;font-size:1rem;font-weight:900;letter-spacing:0.02em;cursor:pointer;box-shadow:0 6px 20px rgba(0,0,0,0.3);"
                        >
                            Kirim Permintaan Pesanan
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </section>

    {{-- ── Client-Side Script for Real-Time Size & Price Matrix ── --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('deal-order-form');
            const productSelect = document.getElementById('produk_id');
            const sizesContainer = document.getElementById('deal-sizes-container');
            const totalPcsDisplay = document.getElementById('deal-total-pcs');
            const totalPriceDisplay = document.getElementById('deal-total-price');
            const catalogJson = document.getElementById('deal-order-catalog-json');

            if (!form || !productSelect || !sizesContainer || !catalogJson) return;

            let catalog = [];
            try {
                catalog = JSON.parse(catalogJson.textContent) || [];
            } catch (e) {
                console.error('Failed parsing catalog:', e);
            }

            const formatRupiah = (num) => {
                return 'Rp ' + Math.round(Math.max(0, Number(num) || 0)).toLocaleString('id-ID');
            };

            const renderSizes = () => {
                const selectedProductId = productSelect.value;
                const product = catalog.find(p => String(p.id) === String(selectedProductId));

                if (!product || !product.sizes || product.sizes.length === 0) {
                    sizesContainer.innerHTML = `
                        <div style="padding:2rem;text-align:center;color:#6E7575;font-size:0.875rem;">
                            Tidak ada ukuran spesifik yang terdaftar untuk kategori produk ini.
                        </div>
                    `;
                    calculateTotals();
                    return;
                }

                let html = '';
                product.sizes.forEach((size, idx) => {
                    const dimensionInfo = [
                        size.chest ? `LD: ${size.chest}cm` : null,
                        size.length ? `P: ${size.length}cm` : null,
                        size.shoulder ? `Bahu: ${size.shoulder}cm` : null,
                        size.sleeve ? `Lengan: ${size.sleeve}cm` : null,
                    ].filter(Boolean).join(' • ');

                    html += `
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1.125rem 1.75rem;background:#FFFFFF;border-bottom:${idx === product.sizes.length - 1 ? 'none' : '1px solid #DCD6D0'};">
                            <input type="hidden" name="sizes[${idx}][ukuran_id]" value="${size.id}">
                            <div>
                                <label for="deal-qty-${size.id}" style="font-size:1rem;font-weight:800;color:#172A39;cursor:pointer;display:block;">
                                    ${size.name}
                                </label>
                                ${dimensionInfo ? `<span style="font-size:0.6875rem;color:#8D9494;font-weight:600;">${dimensionInfo}</span>` : ''}
                            </div>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <button
                                    type="button"
                                    onclick="
                                        const inp = document.getElementById('deal-qty-${size.id}');
                                        inp.value = Math.max(0, (parseInt(inp.value) || 0) - 1);
                                        inp.dispatchEvent(new Event('input', { bubbles: true }));
                                    "
                                    style="width:2.25rem;height:2.25rem;border-radius:50%;background:#FAF8F5;border:1.5px solid #DCD6D0;color:#172A39;font-weight:800;font-size:1.125rem;cursor:pointer;display:flex;align-items:center;justify-content:center;"
                                >-</button>
                                <input
                                    id="deal-qty-${size.id}"
                                    type="number"
                                    name="sizes[${idx}][kuantitas]"
                                    min="0"
                                    step="1"
                                    value="0"
                                    class="deal-qty-input"
                                    style="width:5.5rem;height:2.5rem;text-align:center;border:1.5px solid #DCD6D0;background:#FAF8F5;border-radius:0.625rem;font-size:1rem;font-weight:800;color:#172A39;outline:none;"
                                    onfocus="this.style.borderColor='#172A39';this.style.background='#FFFFFF';"
                                    onblur="this.style.borderColor='#DCD6D0';this.style.background='#FAF8F5';"
                                >
                                <button
                                    type="button"
                                    onclick="
                                        const inp = document.getElementById('deal-qty-${size.id}');
                                        inp.value = (parseInt(inp.value) || 0) + 1;
                                        inp.dispatchEvent(new Event('input', { bubbles: true }));
                                    "
                                    style="width:2.25rem;height:2.25rem;border-radius:50%;background:#172A39;border:1.5px solid #172A39;color:#FFFFFF;font-weight:800;font-size:1.125rem;cursor:pointer;display:flex;align-items:center;justify-content:center;"
                                >+</button>
                            </div>
                        </div>
                    `;
                });

                sizesContainer.innerHTML = html;
                calculateTotals();
            };

            const calculateTotals = () => {
                const qtyInputs = sizesContainer.querySelectorAll('.deal-qty-input');
                let totalPcs = 0;
                qtyInputs.forEach(input => {
                    totalPcs += Math.max(0, parseInt(input.value) || 0);
                });

                totalPcsDisplay.textContent = `${totalPcs} Pcs`;

                const selectedOption = productSelect.selectedOptions[0];
                const price = selectedOption ? parseFloat(selectedOption.dataset.price) || 0 : 0;
                const totalPrice = price * totalPcs;

                totalPriceDisplay.textContent = formatRupiah(totalPrice);
            };

            productSelect.addEventListener('change', renderSizes);
            form.addEventListener('input', function (e) {
                if (e.target.classList.contains('deal-qty-input')) {
                    calculateTotals();
                }
            });

            // Initial render
            renderSizes();
        });
    </script>

@endsection
