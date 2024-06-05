<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\DataKas;
use Illuminate\Http\Request;
use App\Services\DataKasService;
use Illuminate\Support\Facades\DB;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;

final class DataKasRepository implements DataKasService
{
    public function findALl(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $data_kas = DataKas::query();

        $data_kas = $data_kas->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(nama_kas)'), 'like', '%'. strtolower($value) .'%');
        });

        $data_kas = $data_kas->paginate($limit);

        $data = $data_kas->items();
        $total_items = $data_kas->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): DataKas
    {
        $data_kas = DataKas::where('id', $id)->first();

        if (!$data_kas) {
            throw new DataNotFoundException('Data kas not found');
        }

        return $data_kas;
    }

    public function createDataKas(array $validated): DataKas
    {
        $data_kas = new DataKas();

        $data_kas->nama_kas = $validated['nama_kas'];
        $data_kas->aktif = $validated['aktif'];
        $data_kas->simpanan = $validated['simpanan'];
        $data_kas->penarikan = $validated['penarikan'];
        $data_kas->pinjaman = $validated['pinjaman'];
        $data_kas->angsuran = $validated['angsuran'];
        $data_kas->pemasukan_kas = $validated['pemasukan_kas'];
        $data_kas->pengeluaran_kas = $validated['pengeluaran_kas'];
        $data_kas->transfer_kas = $validated['transfer_kas'];
        $data_kas->save();

        return $data_kas;
    }

    public function updateDataKas(array $validated, int|string $id): DataKas
    {
        $data_kas = $this->findByID($id);

        $data_kas->nama_kas = $validated['nama_kas'];
        $data_kas->aktif = $validated['aktif'];
        $data_kas->simpanan = $validated['simpanan'];
        $data_kas->penarikan = $validated['penarikan'];
        $data_kas->pinjaman = $validated['pinjaman'];
        $data_kas->angsuran = $validated['angsuran'];
        $data_kas->pemasukan_kas = $validated['pemasukan_kas'];
        $data_kas->pengeluaran_kas = $validated['pengeluaran_kas'];
        $data_kas->transfer_kas = $validated['transfer_kas'];
        $data_kas->save();

        return $data_kas;
    }

    public function deleteDataKas(int|string $id): void
    {
        $data_kas = $this->findByID($id);
        $data_kas->delete();
    }
}
