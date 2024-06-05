<?php declare(strict_types=1);

namespace App\Repositories\Transaction;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Transaction\PengeluaranService;

final class PengeluaranRepository implements PengeluaranService
{
    public function findAll(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $pengeluaran = Pengeluaran::query();

        $pengeluaran = $pengeluaran->with(['user:id,name', 'kas:id,nama_kas', 'akun:id,akun']);

        $pengeluaran = $pengeluaran->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(kode_transaksi)'), 'like', '%'. strtolower($value) .'%');
        });

        $pengeluaran = $pengeluaran->paginate($limit);

        $data = $pengeluaran->items();
        $total_items = $pengeluaran->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): Pengeluaran
    {
        $data = Pengeluaran::where('id', $id)->first();

        if (!$data) {
            throw new DataNotFoundException('Pengeluaran ' . $id. ' tidak ditemukan');
        }

        return $data;
    }

    public function createPengeluaran(array $validated): Pengeluaran
    {
        $pengeluaran = new Pengeluaran();

        $pengeluaran->kode_transaksi = 'TRX-' . rand();
        $pengeluaran->tanggal_transaksi = date('Y-m-d H:i:s');
        $pengeluaran->jumlah = $validated['jumlah'];
        $pengeluaran->keterangan = $validated['keterangan'];
        $pengeluaran->akun_id = $validated['dari_akun'];
        $pengeluaran->kas_id = $validated['untuk_kas'];
        $pengeluaran->user_id = auth()->user()->id;
        $pengeluaran->save();

        return $pengeluaran;
    }

    public function updatePengeluaran(array $validated, int|string $id): Pengeluaran
    {
        $pengeluaran = $this->findByID($id);

        $pengeluaran->jumlah = $validated['jumlah'];
        $pengeluaran->keterangan = $validated['keterangan'];
        $pengeluaran->akun_id = $validated['dari_akun'];
        $pengeluaran->kas_id = $validated['untuk_kas'];
        $pengeluaran->user_id = auth()->user()->id;
        $pengeluaran->save();

        return $pengeluaran;
    }

    public function deletePengeluaran(int|string $id): void
    {
        $pengeluaran = $this->findByID($id);
        $pengeluaran->delete();
    }
}
