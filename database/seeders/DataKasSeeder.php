<?php

namespace Database\Seeders;

use App\Models\DataKas;
use Illuminate\Database\Seeder;

class DataKasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataKas::insert([
            [
                // 'id' => 1,
                'nama_kas' => 'Kas 1',
                'aktif' => 'Y',
                'simpanan' => 'Y',
                'penarikan' => 'Y',
                'pinjaman' => 'Y',
                'angsuran' => 'Y',
                'pemasukan_kas' => 'Y',
                'pengeluaran_kas' => 'Y',
                'transfer_kas' => 'Y',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                // 'id' => 2,
                'nama_kas' => 'Kas 2',
                'aktif' => 'Y',
                'simpanan' => 'Y',
                'penarikan' => 'Y',
                'pinjaman' => 'Y',
                'angsuran' => 'Y',
                'pemasukan_kas' => 'Y',
                'pengeluaran_kas' => 'Y',
                'transfer_kas' => 'Y',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                // 'id' => 3,
                'nama_kas' => 'Kas 3',
                'aktif' => 'Y',
                'simpanan' => 'Y',
                'penarikan' => 'Y',
                'pinjaman' => 'Y',
                'angsuran' => 'Y',
                'pemasukan_kas' => 'Y',
                'pengeluaran_kas' => 'Y',
                'transfer_kas' => 'Y',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
