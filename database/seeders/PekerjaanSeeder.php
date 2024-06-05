<?php

namespace Database\Seeders;

use App\Models\Pekerjaan;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pekerjaan::insert([
            ['nama_pekerjaan' => 'Ketua Koperasi'],
            ['nama_pekerjaan' => 'General Manager'],
            ['nama_pekerjaan' => 'Staff'],
            ['nama_pekerjaan' => 'Lainnya'],
        ]);
    }
}
