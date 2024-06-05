<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Agama;
use App\Enums\CacheName;
use App\Models\DataKas;
use App\Models\Pekerjaan;
use App\Models\Departemen;
use App\Models\JenisAkun;
use App\Models\StatusMenikah;
use App\Services\DropdownService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

final class DropdownRepository implements DropdownService
{
    /** @var int ttl */
    private int $ttl = 180;

    public function dropdownStatusMenikah(): ?Collection
    {
        return Cache::remember(CacheName::DropdownStatusMenikah->value, $this->ttl, function() {
            return StatusMenikah::all();
        });
    }

    public function dropdownDepartemen(): ?Collection
    {
        return Cache::remember(CacheName::DropdownDepartemen->value, $this->ttl, function() {
            return Departemen::all();
        });
    }

    public function dropdownPekerjaan(): ?Collection
    {
        return Cache::remember(CacheName::DropdownPekerjaan->value, $this->ttl, function() {
            return Pekerjaan::all();
        });
    }

    public function dropdownAgama(): ?Collection
    {
        return Cache::remember(CacheName::DropdownAgama->value, $this->ttl, function() {
            return Agama::all();
        });
    }

    public function dropdownJenisAkun(): ?Collection
    {
        return Cache::remember(CacheName::DropdownJenisAkun->value, $this->ttl, function() {
            return JenisAkun::all();
        });
    }

    public function dropdownDataKas(): ?Collection
    {
        return Cache::remember(CacheName::DropdownDataKas->value, $this->ttl, function() {
            return DataKas::all();
        });
    }
}
