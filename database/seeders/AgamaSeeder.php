<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agama::insert([
            ['nama_agama' => 'Islam'],
            ['nama_agama' => 'Katolik'],
            ['nama_agama' => 'Protestan'],
            ['nama_agama' => 'Hindu'],
            ['nama_agama' => 'Budha'],
            ['nama_agama' => 'Lainnya'],
        ]);
    }
}
