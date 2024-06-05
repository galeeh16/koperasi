<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AgamaSeeder;
use Database\Seeders\LevelSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\TransferSeeder;
use Database\Seeders\JenisAkunSeeder;
use Database\Seeders\PekerjaanSeeder;
use Database\Seeders\PemasukanSeeder;
use Database\Seeders\DepartemenSeeder;
use Database\Seeders\PengeluaranSeeder;
use Database\Seeders\LamaAngsuranSeeder;
use Database\Seeders\JenisSimpananSeeder;
use Database\Seeders\StatusMenikahSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            AgamaSeeder::class,
            StatusMenikahSeeder::class,
            PekerjaanSeeder::class,
            DepartemenSeeder::class,
            LevelSeeder::class,
            LamaAngsuranSeeder::class,
            JenisSimpananSeeder::class,
            DataKasSeeder::class,
            JenisAkunSeeder::class,

            UserSeeder::class,
            AnggotaSeeder::class,

            // transaksi
            PemasukanSeeder::class,
            PengeluaranSeeder::class,
            TransferSeeder::class
        ]);
    }
}
