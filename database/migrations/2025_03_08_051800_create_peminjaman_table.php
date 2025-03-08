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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('peminjaman_id');
            $table->unsignedBigInteger('pengguna_id')->nullable(false);
            $table->date('tanggal_pinjam')->nullable(false);
            $table->date('tanggal_kembali')->nullable();
            $table->string('status', 50)->nullable(false);
            $table->timestamps();

            $table->foreign('pengguna_id')->references('pengguna_id')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
