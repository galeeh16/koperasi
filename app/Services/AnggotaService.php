<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Anggota;
use Illuminate\Http\Request;

interface AnggotaService
{
    public function findAll(Request $request): array;

    public function findByID(int|string $id): Anggota;

    public function createAnggota(array $validated): Anggota;

    public function updateAnggota(array $validated, string|int $id): Anggota;

    public function deleteAnggotaByID(int|string $id): void;
}
