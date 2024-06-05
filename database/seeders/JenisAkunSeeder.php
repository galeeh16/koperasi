<?php

namespace Database\Seeders;

use App\Models\JenisAkun;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;
use Spatie\SimpleExcel\SimpleExcelReader;

class JenisAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');
        $path_to_excel = public_path('example/Data_Akun.xlsx');

        SimpleExcelReader::create($path_to_excel)
            ->headersToSnakeCase()
            ->getRows()
            ->chunk(1000)
            ->each(function(LazyCollection $chunk) use ($now) {
                $records = $chunk->map(function ($row) use ($now) {
                    return [
                        'kode_aktiva' => $row['kode_aktiva'],
                        'nama_akun' => $row['nama_akun'],
                        // 'jenis_transaksi' => $row[''],
                        'akun' => $row['akun'],
                        'pemasukan' => $row['pemasuka'],
                        'pengeluaran' => $row['pengeluaran'],
                        'laba_rugi' => $row['laba_rugi'],
                        'is_aktif' => true,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                })
                ->toArray();

                JenisAkun::insert($records);
            });
    }
}
