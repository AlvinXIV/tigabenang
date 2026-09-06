<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Support\CustomerCatalog;
use App\Support\CustomerMedia;
use Illuminate\View\View;

class CustomerHomeController extends Controller
{
    public function index(): View
    {
        $allCategories = CustomerCatalog::categories();

        // Ambil 1 produk terbaru per kategori dalam 1 query efisien dan terindeks
        $latestPerCategory = Produk::query()
            ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga', 'gambar', 'file_model_3d'])
            ->whereIn('id_produk', function ($sub) {
                $sub->selectRaw('MAX(id_produk)')
                    ->from('produk')
                    ->groupBy('kategori_id');
            })
            ->get()
            ->keyBy('kategori_id');

        CustomerCatalog::attachKategori($latestPerCategory);

        $categoryShowcase = $allCategories->map(function ($kategori) use ($latestPerCategory) {
            return [
                'category' => $kategori,
                'product' => $latestPerCategory->get($kategori->id_kategori),
            ];
        });

        $featuredProduct = $latestPerCategory->first();

        return view('customer.home', [
            'featuredProduct' => $featuredProduct,
            'supportingProducts' => $latestPerCategory->values(),
            'categoryShowcase' => $categoryShowcase,
            'categories' => $allCategories,
            'materials' => collect(),
            'fittingProduct' => $latestPerCategory->first(fn (Produk $p) => filled($p->file_model_3d)),
            'heroImageUrl' => CustomerMedia::heroImageUrl(),
        ]);
    }
}
