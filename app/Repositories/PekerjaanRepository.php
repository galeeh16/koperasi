<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use App\Services\PekerjaanService;
use Illuminate\Support\Facades\DB;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;

final class PekerjaanRepository implements PekerjaanService
{
    public function findAll(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $pekerjaan = Pekerjaan::query();

        $pekerjaan = $pekerjaan->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(nama_pekerjaan)'), 'like', '%'. strtolower($value) .'%');
        });

        $pekerjaan = $pekerjaan->paginate($limit);

        $data = $pekerjaan->items();
        $total_items = $pekerjaan->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): Pekerjaan
    {
        $pekerjaan = Pekerjaan::where('id', $id)->first();

        if (!$pekerjaan) {
            throw new DataNotFoundException('Pekerjaan not found');
        }

        return $pekerjaan;
    }

    public function createPekerjaan(array $validated): Pekerjaan
    {
        return Pekerjaan::create([
            'nama_pekerjaan' => $validated['pekerjaan']
        ]);
    }

    public function updatePekerjaan(array $validated, int|string $id): Pekerjaan
    {
        $pekerjaan = $this->findByID($id);

        $pekerjaan->nama_pekerjaan = $validated['pekerjaan'];
        $pekerjaan->save();

        return $pekerjaan;
    }

    public function deletePekerjaan(int|string $id): void
    {
        $pekerjaan = $this->findByID($id);
        $pekerjaan->delete();
    }
}
