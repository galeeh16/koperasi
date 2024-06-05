<?php

namespace Database\Seeders;

use App\Models\DataKas;
use App\Models\JenisAkun;
use App\Models\Pengeluaran;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kas = DataKas::first();
        $akun = JenisAkun::first();

        Pengeluaran::create([
            'kode_transaksi' => 'TRX-212317382',
            // 'tanggal_transaksi' => ,
            'jumlah' => 100_000,
            'keterangan' => 'Pengeluaran keterangan',
            'akun_id' => $akun->id,
            'kas_id' => $kas->id,
            'user_id' => 1, // admin
        ]);
    }
}
