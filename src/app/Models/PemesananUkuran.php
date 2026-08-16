<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemesananUkuran extends Model
{
    protected $table = 'pemesanan_ukuran';

    protected $primaryKey = 'id_pemesanan_ukuran';

    public $timestamps = false;

    protected $fillable = [
        'pemesanan_id',
        'ukuran_id',
        'kuantitas',
    ];

    protected $casts = [
        'kuantitas' => 'integer',
    ];

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(
            Pemesanan::class,
            'pemesanan_id',
            'id_pemesanan'
        );
    }

    public function ukuran(): BelongsTo
    {
        return $this->belongsTo(
            Ukuran::class,
            'ukuran_id',
            'id_ukuran'
        );
    }
}