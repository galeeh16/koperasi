<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anggota = Anggota::query()->orderBy('id', 'desc')->first();
        $no_anggota_1 = $anggota ? 'ANG-'. str_pad(($anggota->id + 1), 7, '0', STR_PAD_LEFT) : 'ANG-0000001';
        // dd($no_anggota_1);

        Anggota::insert([
            [
                'username' => 'galiando',
                'password' => Hash::make('Secret123'),
                'no_anggota' => $no_anggota_1,
                'nama_lengkap' => 'Galih Anggoro Jati',
                'jenis_kelamin' => 'l',
                'tempat_lahir' => 'New York',
                'tanggal_lahir' => '1996-01-16',
                'status_menikah' => 1,
                'departemen' => 1,
                'pekerjaan' => 1, // pekerjaan / jabatan
                'agama' => 1,
                'alamat' => 'Jalan Jakarta',
                'kota' => 'Jakarta',
                // 'no_hp' => null,
                // 'tanggal_registrasi' => date('Y-m-d H:i:s'),
                'aktif_keanggotaan' => 'Y',
                'status_peminjaman' => 'Y',
                'gaji' => 100_000_000,
                // 'setting_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
