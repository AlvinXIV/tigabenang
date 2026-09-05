<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_kategori
 * @property string $nama_kategori
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
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