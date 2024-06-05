<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Departemen;
use Illuminate\Http\Request;

interface DepartemenService
{
    public function findAll(Request $request): array;

    public function findByID(int|string $id): Departemen;

    public function createDepartemen(array $validated): Departemen;

    public function updateDepartemen(array $validated, int|string $id): Departemen;

    public function deleteDepartemen(int|string $id): void;
}
