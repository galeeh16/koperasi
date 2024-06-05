<?php declare(strict_types=1);

namespace App\Repositories\Transaction;

use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Transaction\TransferService;

final class TransferRepository implements TransferService
{
    public function findAll(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $transfer = Transfer::query();

        $transfer = $transfer->with(['user:id,name', 'untukKas:id,nama_kas', 'dariKas:id,nama_kas']);

        $transfer = $transfer->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(kode_transaksi)'), 'like', '%'. strtolower($value) .'%');
        });

        $transfer = $transfer->paginate($limit);

        $data = $transfer->items();
        $total_items = $transfer->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): Transfer
    {
        $data = Transfer::where('id', $id)->first();

        if (!$data) {
            throw new DataNotFoundException('Pengeluaran ' . $id. ' tidak ditemukan');
        }

        return $data;
    }

    public function createTransfer(array $validated): Transfer
    {
        $transfer = new Transfer();

        $transfer->kode_transaksi = 'TRX-' . rand();
        $transfer->tanggal_transaksi = date('Y-m-d H:i:s');
        $transfer->jumlah = $validated['jumlah'];
        $transfer->keterangan = $validated['keterangan'];
        $transfer->dari_kas_id = $validated['dari_kas'];
        $transfer->untuk_kas_id = $validated['untuk_kas'];
        $transfer->user_id = auth()->user()->id;
        $transfer->save();

        return $transfer;
    }

    public function updateTransfer(array $validated, int|string $id): Transfer
    {
        $transfer = $this->findByID($id);

        $transfer->kode_transaksi = 'TRX-' . rand();
        $transfer->tanggal_transaksi = date('Y-m-d H:i:s');
        $transfer->jumlah = $validated['jumlah'];
        $transfer->keterangan = $validated['keterangan'];
        $transfer->dari_kas_id = $validated['dari_kas'];
        $transfer->untuk_kas_id = $validated['untuk_kas'];
        $transfer->user_id = auth()->user()->id;
        $transfer->save();

        return $transfer;
    }

    public function deleteTransfer(int|string $id): void
    {
        $transfer = $this->findByID($id);
        $transfer->delete();
    }
}
