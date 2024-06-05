<?php

namespace Database\Seeders;

use App\Models\JenisSimpanan;
use Illuminate\Database\Seeder;

class JenisSimpananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisSimpanan::insert([
            ['nama_jenis_simpanan' => 'Simpanan Pokok', 'tampil' => 'Y', 'jumlah' => 100_000_000, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_jenis_simpanan' => 'Simpanan Berjangka', 'tampil' => 'Y', 'jumlah' => 400_000_000, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_jenis_simpanan' => 'Simpanan Wajib', 'tampil' => 'Y', 'jumlah' => 5_000_000, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ]);
    }
}
