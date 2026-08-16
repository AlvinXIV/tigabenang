<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemesananMaterial extends Model
{
    protected $table = 'pemesanan_material';

    protected $primaryKey = 'id_pemesanan_material';

    public $timestamps = false;

    protected $fillable = [
        'pemesanan_id',
        'bahan_id',
    ];

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(
            Pemesanan::class,
            'pemesanan_id',
            'id_pemesanan'
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