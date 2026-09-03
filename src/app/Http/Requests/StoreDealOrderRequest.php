<?php

namespace App\Http\Requests;

use App\Models\Produk;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreDealOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:2000'],
            'no_hp' => ['required', 'string', 'max:30'],
            'produk_id' => ['required', 'integer', 'exists:produk,id_produk'],
            'materials' => ['required', 'array', 'min:1'],
            'materials.*' => ['integer', 'exists:bahan,id_bahan'],
            'sizes' => ['required', 'array', 'min:1'],
            'sizes.*.ukuran_id' => ['required', 'integer', 'exists:ukuran,id_ukuran'],
            'sizes.*.kuantitas' => ['required', 'integer', 'min:0'],
            'upload_design' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap pemesan wajib diisi.',
            'alamat.required' => 'Alamat lengkap pengiriman wajib diisi.',
            'no_hp.required' => 'Nomor WhatsApp / HP wajib diisi untuk koordinasi produksi.',
            'produk_id.required' => 'Pilih produk yang dipesan.',
            'materials.required' => 'Pilih minimal satu jenis bahan kain yang disepakati.',
            'materials.min' => 'Pilih minimal satu jenis bahan kain yang disepakati.',
            'sizes.required' => 'Rincian ukuran wajib diisi.',
            'upload_design.max' => 'Ukuran file desain maksimal 5MB.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $sizeRows = collect($this->input('sizes', []));
            $hasQuantity = $sizeRows->contains(fn ($row) => (int) ($row['kuantitas'] ?? 0) > 0);

            if (! $hasQuantity) {
                $validator->errors()->add('sizes', 'Mohon masukkan kuantitas (jumlah) minimal 1 pcs pada salah satu ukuran.');
            }
        });
    }
}
