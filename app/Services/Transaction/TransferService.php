<?php declare(strict_types=1);

namespace App\Services\Transaction;

use App\Models\Transfer;
use Illuminate\Http\Request;

interface TransferService
{
    public function findAll(Request $request): array;

    public function findByID(int|string $id): Transfer;

    public function createTransfer(array $validated): Transfer;

    public function updateTransfer(array $validated, int|string $id): Transfer;

    public function deleteTransfer(int|string $id): void;
}
