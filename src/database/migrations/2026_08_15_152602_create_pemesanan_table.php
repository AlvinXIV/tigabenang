<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan');

            $table->string('nama');
            $table->text('alamat');
            $table->string('no_hp');

            $table->foreignId('produk_id')
                  ->constrained('produk', 'id_produk')
                  ->restrictOnDelete();

            $table->decimal('total_harga', 15, 2)->nullable();

            $table->string('upload_design')->nullable();
            $table->text('notes')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};