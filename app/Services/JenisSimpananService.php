<?php declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\JenisSimpanan;

interface JenisSimpananService
{
    public function findAll(Request $request): array;

    public function findByID(int|string $id): JenisSimpanan;

    public function createJenisSimpanan(array $validated): JenisSimpanan;

    public function updateJenisSimpanan(array $validated, int|string $id): JenisSimpanan;

    public function deleteJenisSimpanan(int|string $id): void;
}
