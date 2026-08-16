<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ukuran extends Model
{
    protected $table = 'ukuran';

    protected $primaryKey = 'id_ukuran';

    protected $fillable = [
        'kategori_id',
        'nama_ukuran',
        'lebar_dada',
        'panjang',
        'lebar_bahu',
        'panjang_lengan',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(
            Kategori::class,
            'kategori_id',
            'id_kategori'
        );
    }

    public function pemesanan(): BelongsToMany
    {
        return $this->belongsToMany(
            Pemesanan::class,
            'pemesanan_ukuran',
            'ukuran_id',
            'pemesanan_id',
            'id_ukuran',
            'id_pemesanan'
        )->withPivot('kuantitas');
    }
}