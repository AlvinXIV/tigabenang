<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('ukuran', function (Blueprint $table) {
    $table->id('id_ukuran');

    $table->foreignId('kategori_id')
          ->constrained('kategori', 'id_kategori')
          ->cascadeOnDelete();

    $table->string('nama_ukuran');
    $table->decimal('lebar_dada', 5, 2)->nullable();
    $table->decimal('panjang', 5, 2)->nullable();
    $table->decimal('lebar_bahu', 5, 2)->nullable();
    $table->decimal('panjang_lengan', 5, 2)->nullable();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('ukuran');
    }
};