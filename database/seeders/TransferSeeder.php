<?php

namespace Database\Seeders;

use App\Models\DataKas;
use App\Models\Transfer;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dari_kas = DataKas::first();
        $untuk_kas = DataKas::orderBy('id', 'desc')->first();

        Transfer::create([
            'kode_transaksi' => 'TRX-'.rand(),
            // 'tanggal_transaksi' => ,
            'jumlah' => 41_000_000,
            'keterangan' => 'Terang',
            'dari_kas_id' => $dari_kas->id,
            'untuk_kas_id' => $untuk_kas->id,
            'user_id' => 1, // admin
        ]);
    }
}
