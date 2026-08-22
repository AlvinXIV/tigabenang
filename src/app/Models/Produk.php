<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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