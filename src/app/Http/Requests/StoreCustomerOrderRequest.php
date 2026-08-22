<?php

namespace App\Http\Requests;

use App\Models\Produk;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreCustomerOrderRequest extends FormRequest
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

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $sizeRows = collect($this->input('sizes', []));
            $hasQuantity = $sizeRows->contains(fn ($row) => (int) ($row['kuantitas'] ?? 0) > 0);

            if (! $hasQuantity) {
                $validator->errors()->add('sizes', 'Please request at least one size with a quantity greater than zero.');
            }

            $produk = Produk::query()
                ->with(['kategori.ukuran', 'bahan'])
                ->find($this->input('produk_id'));

            if (! $produk) {
                return;
            }

            $allowedSizeIds = $produk->kategori?->ukuran->pluck('id_ukuran') ?? collect();

            foreach ($sizeRows as $index => $row) {
                $ukuranId = (int) ($row['ukuran_id'] ?? 0);
                $qty = (int) ($row['kuantitas'] ?? 0);

                if ($qty > 0 && $allowedSizeIds->isNotEmpty() && ! $allowedSizeIds->contains($ukuranId)) {
                    $validator->errors()->add(
                        "sizes.{$index}.ukuran_id",
                        'The selected size is not available for this garment.'
                    );
                }
            }

            $allowedMaterialIds = $produk->bahan->pluck('id_bahan');

            if ($allowedMaterialIds->isNotEmpty()) {
                foreach ($this->input('materials', []) as $index => $bahanId) {
                    if (! $allowedMaterialIds->contains((int) $bahanId)) {
                        $validator->errors()->add(
                            "materials.{$index}",
                            'The selected material is not available for this garment.'
                        );
                    }
                }
            }
        });
    }
}
