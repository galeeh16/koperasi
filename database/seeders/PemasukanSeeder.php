<?php

namespace Database\Seeders;

use App\Models\DataKas;
use App\Models\JenisAkun;
use App\Models\Pemasukan;
use Illuminate\Database\Seeder;

class PemasukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kas = DataKas::first();
        $akun = JenisAkun::first();

        Pemasukan::create([
            'kode_transaksi' => 'TRX-212317382',
            // 'tanggal_transaksi' => ,
            'jumlah' => 2_000_000,
            'keterangan' => 'Terang',
            'akun_id' => $akun->id,
            'kas_id' => $kas->id,
            'user_id' => 1, // admin
        ]);
    }
}
