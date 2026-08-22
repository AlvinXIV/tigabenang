<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan_ukuran', function (Blueprint $table) {
            $table->id('id_pemesanan_ukuran');

            $table->foreignId('pemesanan_id')
                  ->constrained('pemesanan', 'id_pemesanan')
                  ->cascadeOnDelete();

            $table->foreignId('ukuran_id')
                  ->constrained('ukuran', 'id_ukuran')
                  ->restrictOnDelete();

            $table->unsignedInteger('kuantitas');

            $table->unique(['pemesanan_id', 'ukuran_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan_ukuran');
    }
};