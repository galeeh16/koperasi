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
        Schema::create('jenis_akun', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aktiva', 255)->unique();
            $table->string('nama_akun', 255)->nullable();
            $table->string('jenis_transaksi', 255)->nullable();
            $table->enum('akun', ['Aktiva', 'Pasiva']);
            $table->enum('pemasukan', ['Y', 'N']);
            $table->enum('pengeluaran', ['Y', 'N']);
            $table->string('laba_rugi')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_akun');
    }
};
