<?php declare(strict_types=1);

namespace App\Services;

use App\Models\DataKas;
use Illuminate\Http\Request;

interface DataKasService
{
    public function findALl(Request $request): array;

    public function findByID(int|string $id): DataKas;

    public function createDataKas(array $validated): DataKas;

    public function updateDataKas(array $validated, int|string $id): DataKas;

    public function deleteDataKas(int|string $id): void;
}
