<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\JenisSimpanan;
use Illuminate\Support\Facades\DB;
use App\Services\JenisSimpananService;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;

final class JenisSimpananRepository implements JenisSimpananService
{
    public function findAll(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $jenis_simpanan = JenisSimpanan::query();

        $jenis_simpanan = $jenis_simpanan->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(nama_jenis_simpanan)'), 'like', '%'. strtolower($value) .'%');
        });

        $jenis_simpanan = $jenis_simpanan->paginate($limit);

        $data = $jenis_simpanan->items();
        $total_items = $jenis_simpanan->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): JenisSimpanan
    {
        $jenis_simpanan = JenisSimpanan::where('id', $id)->first();

        if (!$jenis_simpanan) {
            throw new DataNotFoundException('Jenis simpanan not found');
        }

        return $jenis_simpanan;
    }

    public function createJenisSimpanan(array $validated): JenisSimpanan
    {
        $simpanan = new JenisSimpanan();

        $simpanan->nama_jenis_simpanan =  $validated['jenis_simpanan'];
        $simpanan->jumlah =  $validated['jumlah'];
        $simpanan->tampil =  $validated['tampil'];
        $simpanan->save();

        return $simpanan;
    }

    public function updateJenisSimpanan(array $validated, int|string $id): JenisSimpanan
    {
        $simpanan = $this->findByID($id);

        $simpanan->nama_jenis_simpanan =  $validated['jenis_simpanan'];
        $simpanan->jumlah =  $validated['jumlah'];
        $simpanan->tampil =  $validated['tampil'];
        $simpanan->save();

        return $simpanan;
    }

    public function deleteJenisSimpanan(int|string $id): void
    {
        $simpanan = $this->findByID($id);
        $simpanan->delete();
    }
}
