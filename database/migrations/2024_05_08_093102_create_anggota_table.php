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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('no_anggota', 30)->unique();
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['l', 'p'])->nullable()->comment('Laki-Laki, Perempuan');
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->dateTime('bersihkan')->nullable();

            $table->unsignedInteger('status_menikah')->nullable();
            $table->unsignedInteger('departemen')->nullable();
            $table->unsignedInteger('pekerjaan')->nullable();
            $table->unsignedInteger('agama')->nullable();

            $table->unsignedBigInteger('gaji')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->string('photo', 255)->nullable();

            // $table->datetime('tanggal_registrasi');
            $table->enum('aktif_keanggotaan', ['Y', 'N'])->default('N');
            $table->enum('status_peminjaman', ['Y', 'N'])->default('N');
            $table->unsignedBigInteger('setting_id')->nullable();

            $table->timestamps();

            $table->foreign('setting_id')->references('id')->on('settings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
