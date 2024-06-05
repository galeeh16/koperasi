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
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();

            $table->string('kode_transaksi', 255)->unique();
            $table->dateTime('tanggal_transaksi')->default(date('Y-m-d H:i:s'));
            $table->unsignedBigInteger('jumlah');
            $table->string('keterangan', 255);
            $table->unsignedBigInteger('dari_kas_id');
            $table->unsignedBigInteger('untuk_kas_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('dari_kas_id')->references('id')->on('data_kas');
            $table->foreign('untuk_kas_id')->references('id')->on('data_kas');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer');
    }
};
