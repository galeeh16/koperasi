<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

interface PekerjaanService
{
    public function findAll(Request $request): array;

    public function findByID(int|string $id): Pekerjaan;

    public function createPekerjaan(array $validated): Pekerjaan;

    public function updatePekerjaan(array $validated, int|string $id): Pekerjaan;

    public function deletePekerjaan(int|string $id): void;
}
