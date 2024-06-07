<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['key' => 'persen_anggota', 'value' => '5'],
            ['key' => 'persen_non_anggota', 'value' => '0'],
            ['key' => 'pph', 'value' => '10'],
            ['key' => 'ppn', 'value' => '12'],
        ];

        Setting::insert($records);
    }
}
