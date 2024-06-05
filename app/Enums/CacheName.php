<?php declare(strict_types=1);

namespace App\Enums;

enum CacheName: string
{
    case DropdownStatusMenikah = 'dropdown_status_menikah';
    case DropdownDepartemen = 'dropdown_departemen';
    case DropdownPekerjaan = 'dropdown_pekerjaan';
    case DropdownAgama = 'dropdown_agama';
    case DropdownJenisAkun = 'dropdown_jenis_akun';
    case DropdownDataKas = 'dropdown_data_kas';
}
