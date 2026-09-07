<?php

namespace App\Models;

use App\Support\CustomerCatalog;
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
        'status',
        'status_pembayaran',
        'upload_design',
        'notes',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function scopeMasuk($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'masuk')
              ->orWhereNull('status');
        });
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }

    public function isSudahDp(): bool
    {
        return $this->status_pembayaran === 'sudah_dp';
    }

    public function isLunas(): bool
    {
        return $this->status_pembayaran === 'lunas';
    }

    public function isBelumBayar(): bool
    {
        return empty($this->status_pembayaran) || $this->status_pembayaran === 'belum_bayar';
    }

    public function paymentStatusLabel(): string
    {
        return match ($this->status_pembayaran) {
            'sudah_dp' => 'Sudah DP',
            'lunas' => 'Sudah Lunas',
            default => 'Belum Bayar',
        };
    }

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

    public function categoryDisplayName(): string
    {
        $kategori = $this->produk?->kategori?->nama_kategori;

        if (filled($kategori)) {
            return CustomerCatalog::categoryLabel($kategori);
        }

        return $this->produk?->nama_produk ?: '-';
    }
}