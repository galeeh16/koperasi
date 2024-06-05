<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\JenisAkun;
use Illuminate\Http\Request;
use App\Services\JenisAkunService;
use Illuminate\Support\Facades\DB;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;

final class JenisAkunRepository implements JenisAkunService
{
    public function findAll(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $jenis_akun = JenisAkun::query();

        $jenis_akun = $jenis_akun->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(kode_aktiva)'), 'like', '%'. strtolower($value) .'%')
                        ->orWhere(DB::raw('lower(nama_akun)'), 'like', '%'. strtolower($value) .'%')
                        ->orWhere(DB::raw('lower(akun)'), 'like', '%'. strtolower($value) .'%');
        });

        $jenis_akun = $jenis_akun->paginate($limit);

        $data = $jenis_akun->items();
        $total_items = $jenis_akun->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): JenisAkun
    {
        $jenis_akun = JenisAkun::where('id', $id)->first();

        if (!$jenis_akun) {
            throw new DataNotFoundException('Jenis akun not found');
        }

        return $jenis_akun;
    }

    public function createJenisAkun(array $validated): JenisAkun
    {
        $jenis_akun = new JenisAkun();

        $jenis_akun->kode_aktiva = $validated['kode_aktiva'];
        $jenis_akun->nama_akun = $validated['nama_akun'];
        $jenis_akun->akun = $validated['akun'];
        $jenis_akun->pemasukan = $validated['pemasukan'];
        $jenis_akun->pengeluaran = $validated['pengeluaran'];
        $jenis_akun->laba_rugi = $validated['laba_rugi'];
        $jenis_akun->save();

        return $jenis_akun;
    }

    public function updateJenisAkun(array $validated, int|string $id): JenisAkun
    {
        $jenis_akun = $this->findByID($id);

        $jenis_akun->kode_aktiva = $validated['kode_aktiva'];
        $jenis_akun->nama_akun = $validated['nama_akun'];
        $jenis_akun->akun = $validated['akun'];
        $jenis_akun->pemasukan = $validated['pemasukan'];
        $jenis_akun->pengeluaran = $validated['pengeluaran'];
        $jenis_akun->laba_rugi = $validated['laba_rugi'];
        $jenis_akun->save();

        return $jenis_akun;
    }

    public function deleteJenisAkun(int|string $id): void
    {
        $jenis_akun = $this->findByID($id);
        $jenis_akun->delete();
    }
}
