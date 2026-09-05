<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Support\CustomerCatalog;
use App\Support\CustomerMedia;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VirtualFittingController extends Controller
{
    public function index(Request $request): View
    {
        $products = Produk::query()
            ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga', 'gambar', 'file_model_3d'])
            ->whereNotNull('file_model_3d')
            ->where('file_model_3d', '!=', '')
            ->orderBy('nama_produk')
            ->get();

        CustomerCatalog::attachKategoriAndSizes($products);

        $selectedId = $request->query('product');
        $selected = $products->firstWhere('id_produk', (int) $selectedId) ?? $products->first();

        $catalog = $products->map(function (Produk $produk) {
            return [
                'id' => $produk->id_produk,
                'name' => $produk->nama_produk,
                'category' => $produk->kategori?->nama_kategori,
                'price' => (float) $produk->harga,
                'imageUrl' => CustomerMedia::productImageUrl($produk),
                'modelUrl' => CustomerMedia::modelUrl($produk->file_model_3d),
                'sizes' => $produk->kategori?->ukuran
                    ?->map(fn ($ukuran) => [
                        'id' => $ukuran->id_ukuran,
                        'name' => $ukuran->nama_ukuran,
                        'lebar_dada' => $ukuran->lebar_dada !== null ? (float) $ukuran->lebar_dada : null,
                        'panjang' => $ukuran->panjang !== null ? (float) $ukuran->panjang : null,
                        'lebar_bahu' => $ukuran->lebar_bahu !== null ? (float) $ukuran->lebar_bahu : null,
                        'panjang_lengan' => $ukuran->panjang_lengan !== null ? (float) $ukuran->panjang_lengan : null,
                    ])->values() ?? [],
            ];
        })->values();

        $allCategories = Kategori::orderBy('nama_kategori')->get();

        return view('customer.virtual-fitting', [
            'products' => $products,
            'selected' => $selected,
            'catalog' => $catalog,
            'allCategories' => $allCategories,
        ]);
    }
}
