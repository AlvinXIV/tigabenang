<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bahan extends Model
{
    protected $table = 'bahan';

    protected $primaryKey = 'id_bahan';

    protected $fillable = [
        'nama_bahan',
    ];

    public function produk(): BelongsToMany
    {
        return $this->belongsToMany(
            Produk::class,
            'produk_bahan',
            'bahan_id',
            'produk_id',
            'id_bahan',
            'id_produk'
        );
    }

    public function pemesanan(): BelongsToMany
    {
        return $this->belongsToMany(
            Pemesanan::class,
            'pemesanan_material',
            'bahan_id',
            'pemesanan_id',
            'id_bahan',
            'id_pemesanan'
        );
    }
}