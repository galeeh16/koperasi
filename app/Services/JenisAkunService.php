<?php declare(strict_types=1);

namespace App\Services;

use App\Models\JenisAkun;
use Illuminate\Http\Request;

interface JenisAkunService
{
    public function findAll(Request $request): array;

    public function findByID(int|string $id): JenisAkun;

    public function createJenisAkun(array $validated): JenisAkun;

    public function updateJenisAkun(array $validated, int|string $id): JenisAkun;

    public function deleteJenisAkun(int|string $id): void;
}
