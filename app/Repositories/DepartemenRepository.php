<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\DepartemenService;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;

final class DepartemenRepository implements DepartemenService
{
    public function findAll(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $departemen = Departemen::query();

        $departemen = $departemen->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(nama_pekerjaan)'), 'like', '%'. strtolower($value) .'%');
        });

        $departemen = $departemen->paginate($limit);

        $data = $departemen->items();
        $total_items = $departemen->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): Departemen
    {
        $departemen = Departemen::where('id', $id)->first();

        if (!$departemen) {
            throw new DataNotFoundException('Departemen not found');
        }

        return $departemen;
    }

    public function createDepartemen(array $validated): Departemen
    {
        $departemen = new Departemen();

        $departemen->nama_departemen = $validated['nama_departemen'];
        $departemen->save();

        return $departemen;
    }

    public function updateDepartemen(array $validated, int|string $id): Departemen
    {
        $departemen = $this->findByID($id);

        $departemen->nama_departemen = $validated['nama_departemen'];
        $departemen->save();

        return $departemen;
    }

    public function deleteDepartemen(int|string $id): void
    {
        $departemen = $this->findByID($id);
        $departemen->delete();
    }
}
