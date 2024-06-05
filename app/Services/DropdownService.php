<?php declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface DropdownService
{
    public function dropdownStatusMenikah(): ?Collection;

    public function dropdownDepartemen(): ?Collection;

    public function dropdownPekerjaan(): ?Collection;

    public function dropdownAgama(): ?Collection;

    public function dropdownJenisAkun(): ?Collection;

    public function dropdownDataKas(): ?Collection;
}
