<?php

namespace Database\Seeders;

use App\Models\StatusMenikah;
use Illuminate\Database\Seeder;

class StatusMenikahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusMenikah::insert([
            ['nama_status' => 'Belum Kawin'],
            ['nama_status' => 'Kawin'],
            ['nama_status' => 'Cerai Hidup'],
            ['nama_status' => 'Cerai Mati'],
            ['nama_status' => 'Lainnya'],
        ]);
    }
}
