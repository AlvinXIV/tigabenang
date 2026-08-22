<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_bahan', function (Blueprint $table) {
            $table->id('id_produk_bahan');

            $table->foreignId('produk_id')
                  ->constrained('produk', 'id_produk')
                  ->cascadeOnDelete();

            $table->foreignId('bahan_id')
                  ->constrained('bahan', 'id_bahan')
                  ->cascadeOnDelete();

            $table->unique(['produk_id', 'bahan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_bahan');
    }
};