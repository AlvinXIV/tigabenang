<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_produk
 * @property int $kategori_id
 * @property string $nama_produk
 * @property float|string $harga
 * @property string|null $gambar
 * @property string|null $file_model_3d
 * @property-read string|null $gambar_webp
 * @property-read string|null $gambar_webp_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kategori|null $kategori
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bahan> $bahan
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'harga',
        'gambar',
        'file_model_3d',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function getGambarWebpAttribute(): ?string
    {
        if (! filled($this->gambar)) {
            return null;
        }

        return \App\Support\ImageOptimizer::getWebpRelativePath($this->gambar);
    }

    public function getGambarWebpUrlAttribute(): ?string
    {
        return \App\Support\ImageOptimizer::getWebpUrl($this->gambar, 'public');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(
            Kategori::class,
            'kategori_id',
            'id_kategori'
        );
    }

    public function bahan(): BelongsToMany
    {
        return $this->belongsToMany(
            Bahan::class,
            'produk_bahan',
            'produk_id',
            'bahan_id',
            'id_produk',
            'id_bahan'
        );
    }

    public function pemesanan(): HasMany
    {
        return $this->hasMany(
            Pemesanan::class,
            'produk_id',
            'id_produk'
        );
    }
}