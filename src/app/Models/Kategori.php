<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    public function produk(): HasMany
    {
        return $this->hasMany(
            Produk::class,
            'kategori_id',
            'id_kategori'
        );
    }

    public function ukuran(): HasMany
    {
        return $this->hasMany(
            Ukuran::class,
            'kategori_id',
            'id_kategori'
        );
    }
}