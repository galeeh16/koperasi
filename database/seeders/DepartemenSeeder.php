<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departemen::insert(
            ['nama_departemen' => 'Anggota'],
            ['nama_departemen' => 'Pengurus'],
        );
    }
}
