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
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id('detail_id');
            $table->unsignedBigInteger('peminjaman_id')->nullable(false);
            $table->unsignedBigInteger('produk_id')->nullable(false);
            $table->integer('jumlah')->nullable(false);
            $table->timestamps();

            $table->foreign('peminjaman_id')->references('peminjaman_id')->on('peminjaman')->onDelete('cascade');
            $table->foreign('produk_id')->references('produk_id')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
