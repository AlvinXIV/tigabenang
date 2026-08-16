<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Support\CustomerCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index(Request $request): View
    {
        $categories = CustomerCatalog::categories();
        $selectedCategory = $request->query('category');

        $matchedCategoryIds = $selectedCategory
            ? $categories
                ->filter(fn (Kategori $kategori) => $this->categoryMatches($kategori, (string) $selectedCategory))
                ->pluck('id_kategori')
            : collect();

        $products = Produk::query()
            ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga', 'gambar'])
            ->when($selectedCategory, function ($query) use ($matchedCategoryIds) {
                if ($matchedCategoryIds->isEmpty()) {
                    $query->whereRaw('0 = 1');

                    return;
                }

                $query->whereIn('kategori_id', $matchedCategoryIds);
            })
            ->latest('id_produk')
            ->get();

        CustomerCatalog::attachKategori($products);

        $activeCategory = $selectedCategory
            ? $categories->first(fn (Kategori $kategori) => $this->categoryMatches($kategori, (string) $selectedCategory))
            : null;

        return view('customer.collection.index', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(string $produk): View|Response
    {
        $product = Produk::query()
            ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga', 'gambar', 'file_model_3d'])
            ->with(['bahan:id_bahan,nama_bahan'])
            ->find($produk);

        if (! $product) {
            return response()->view('customer.missing', [
                'title' => 'Product not found',
                'message' => 'The garment you are looking for is no longer in the collection.',
            ], 404);
        }

        CustomerCatalog::attachKategoriAndSizes($product);

        $related = Produk::query()
            ->select(['id_produk', 'kategori_id', 'nama_produk', 'harga', 'gambar'])
            ->where('kategori_id', $product->kategori_id)
            ->where('id_produk', '!=', $product->id_produk)
            ->take(3)
            ->get();

        CustomerCatalog::attachKategori($related);

        return view('customer.collection.show', [
            'product' => $product,
            'sizes' => $product->kategori?->ukuran ?? collect(),
            'related' => $related,
        ]);
    }

    private function categoryMatches(Kategori $kategori, string $selectedCategory): bool
    {
        $slug = Str::slug($kategori->nama_kategori);
        $needle = Str::slug($selectedCategory);

        return (string) $kategori->id_kategori === $selectedCategory
            || $slug === $needle
            || ($needle !== '' && str_contains($slug, $needle))
            || mb_strtolower($kategori->nama_kategori) === mb_strtolower($selectedCategory);
    }
}
