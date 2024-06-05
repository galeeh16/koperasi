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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255)->unique()->comment('Untuk Login');
            $table->string('password', 255);
            $table->string('name', 255);
            // $table->enum('jenis_kelamin', ['l', 'p'])->comment('Laki-Laki, Perempuan');
            // $table->string('tempat_lahir', 255);
            // $table->date('tanggal_lahir');
            // $table->dateTime('bersihkan');

            // $table->unsignedInteger('status_menikah');
            // $table->unsignedInteger('departemen');
            // $table->unsignedInteger('pekerjaan');
            // $table->unsignedInteger('agama');

            // $table->string('alamat', 255);
            // $table->string('kota', 255);
            // $table->string('no_hp', 30);
            // $table->datetime('tanggal_registrasi');
            // $table->enum('aktif_keanggotaan', ['Y', 'N']);
            // $table->enum('status_peminjaman', ['Y', 'N']);

            $table->unsignedInteger('level');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
