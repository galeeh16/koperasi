<?php declare(strict_types=1);

namespace App\Services\Transaction;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

interface PengeluaranService
{
    public function findAll(Request $request): array;

    public function findByID(int|string $id): Pengeluaran;

    public function createPengeluaran(array $validated): Pengeluaran;

    public function updatePengeluaran(array $validated, int|string $id): Pengeluaran;

    public function deletePengeluaran(int|string $id): void;
}
