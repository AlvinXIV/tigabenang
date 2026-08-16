<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan_material', function (Blueprint $table) {
            $table->id('id_pemesanan_material');

            $table->foreignId('pemesanan_id')
                  ->constrained('pemesanan', 'id_pemesanan')
                  ->cascadeOnDelete();

            $table->foreignId('bahan_id')
                  ->constrained('bahan', 'id_bahan')
                  ->restrictOnDelete();

            $table->unique(['pemesanan_id', 'bahan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan_material');
    }
};