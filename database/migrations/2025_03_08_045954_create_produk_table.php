<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('produk_id');
            $table->string('nama_produk', 255)->nullable(false);
            $table->string('gambar_produk', 255)->nullable(false);
            $table->string('kategori', 255)->nullable(false);
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->nullable(false);
            $table->integer('biaya_sewa')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
