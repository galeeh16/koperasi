<?php declare(strict_types=1);

namespace App\Services\Transaction;

use App\Models\Pemasukan;
use Illuminate\Http\Request;

interface PemasukanService
{
    public function findAll(Request $request): array;

    public function findByID(int|string $id): Pemasukan;

    public function createPemasukan(array $validated): Pemasukan;

    public function updatePemasukan(array $validated, int|string $id): Pemasukan;

    public function deletePemasukan(int|string $id): void;
}
