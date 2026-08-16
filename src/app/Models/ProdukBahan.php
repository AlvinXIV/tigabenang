<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukBahan extends Model
{
    protected $table = 'produk_bahan';

    protected $primaryKey = 'id_produk_bahan';

    public $timestamps = false;

    protected $fillable = [
        'produk_id',
        'bahan_id',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(
            Produk::class,
            'produk_id',
            'id_produk'
        );
    }

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(
            Bahan::class,
            'bahan_id',
            'id_bahan'
        );
    }
}