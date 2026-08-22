<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $primaryKey = 'id_pemesanan';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'produk_id',
        'total_harga',
        'upload_design',
        'notes',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(
            Produk::class,
            'produk_id',
            'id_produk'
        );
    }

    public function bahan(): BelongsToMany
    {
        return $this->belongsToMany(
            Bahan::class,
            'pemesanan_material',
            'pemesanan_id',
            'bahan_id',
            'id_pemesanan',
            'id_bahan'
        );
    }

    public function ukuran(): BelongsToMany
    {
        return $this->belongsToMany(
            Ukuran::class,
            'pemesanan_ukuran',
            'pemesanan_id',
            'ukuran_id',
            'id_pemesanan',
            'id_ukuran'
        )->withPivot('kuantitas');
    }
}