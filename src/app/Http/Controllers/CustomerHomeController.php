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
        $products = Produk::query()
            ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga', 'gambar', 'file_model_3d'])
            ->latest('id_produk')
            ->take(6)
            ->get();

        CustomerCatalog::attachKategori($products);

        $featuredProduct = $products->first();
        $supportingProducts = $products->skip(1)->values();

        $fittingProduct = $products->first(fn (Produk $produk) => filled($produk->file_model_3d));

        if (! $fittingProduct && $products->count() === 6 && CustomerCatalog::hasThreeDProduct()) {
            $fittingProduct = Produk::query()
                ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga', 'gambar', 'file_model_3d'])
                ->whereNotNull('file_model_3d')
                ->where('file_model_3d', '!=', '')
                ->latest('id_produk')
                ->first();

            if ($fittingProduct) {
                CustomerCatalog::attachKategori($fittingProduct);
            }
        }

        $allCategories = CustomerCatalog::categories();
        $allProducts = Produk::query()
            ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga', 'gambar', 'file_model_3d'])
            ->latest('id_produk')
            ->get();

        CustomerCatalog::attachKategori($allProducts);

        $categoryShowcase = $allCategories->map(function ($kategori) use ($allProducts) {
            $product = $allProducts->firstWhere('kategori_id', $kategori->id_kategori);
            return [
                'category' => $kategori,
                'product' => $product,
            ];
        });

        return view('customer.home', [
            'featuredProduct' => $featuredProduct,
            'supportingProducts' => $products,
            'categoryShowcase' => $categoryShowcase,
            'categories' => $allCategories,
            'materials' => CustomerCatalog::materials()->take(6)->values(),
            'fittingProduct' => $fittingProduct,
            'heroImageUrl' => CustomerMedia::heroImageUrl(),
        ]);
    }
}
