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
        Schema::create('data_kas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kas', 255);
            $table->enum('aktif', ['Y', 'N']);
            $table->enum('simpanan', ['Y', 'N']);
            $table->enum('penarikan', ['Y', 'N']);
            $table->enum('pinjaman', ['Y', 'N']);
            $table->enum('angsuran', ['Y', 'N']);
            $table->enum('pemasukan_kas', ['Y', 'N']);
            $table->enum('pengeluaran_kas', ['Y', 'N']);
            $table->enum('transfer_kas', ['Y', 'N']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kas');
    }
};
