<?php declare(strict_types=1);

namespace App\Repositories\Transaction;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Transaction\PemasukanService;

final class PemasukanRepository implements PemasukanService
{
    public function findAll(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $pemasukan = Pemasukan::query();

        $pemasukan = $pemasukan->with(['user:id,name', 'kas:id,nama_kas', 'akun:id,akun']);

        $pemasukan = $pemasukan->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(kode_transaksi)'), 'like', '%'. strtolower($value) .'%');
        });

        $pemasukan = $pemasukan->paginate($limit);

        $data = $pemasukan->items();
        $total_items = $pemasukan->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): Pemasukan
    {
        $data = Pemasukan::where('id', $id)->first();

        if (!$data) {
            throw new DataNotFoundException('Pemasukan ' . $id. ' tidak ditemukan');
        }

        return $data;
    }

    public function createPemasukan(array $validated): Pemasukan
    {
        $pemasukan = new Pemasukan();

        $pemasukan->kode_transaksi = 'TRX-' . rand();
        $pemasukan->tanggal_transaksi = date('Y-m-d H:i:s');
        $pemasukan->jumlah = $validated['jumlah'];
        $pemasukan->keterangan = $validated['keterangan'];
        $pemasukan->akun_id = $validated['dari_akun'];
        $pemasukan->kas_id = $validated['untuk_kas'];
        $pemasukan->user_id = auth()->user()->id;
        $pemasukan->save();

        return $pemasukan;
    }

    public function updatePemasukan(array $validated, int|string $id): Pemasukan
    {
        $pemasukan = $this->findByID($id);

        $pemasukan->jumlah = $validated['jumlah'];
        $pemasukan->keterangan = $validated['keterangan'];
        $pemasukan->akun_id = $validated['dari_akun'];
        $pemasukan->kas_id = $validated['untuk_kas'];
        $pemasukan->user_id = auth()->user()->id;
        $pemasukan->save();

        return $pemasukan;
    }

    public function deletePemasukan(int|string $id): void
    {
        $pemasukan = $this->findByID($id);
        $pemasukan->delete();
    }
}
