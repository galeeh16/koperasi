<?php declare(strict_types=1);

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Services\DataKasService;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Exceptions\DataNotFoundException;

final class DataKasController extends Controller
{
    public function __construct(private DataKasService $service) {}

    public function index(): View
    {
        return view('master-data.data-kas.index');
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $data = $this->service->findAll($request);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e), status: 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_kas' => 'required|string|max:255',
            'aktif' => 'required|string|in:Y,N',
            'simpanan' => 'required|string|in:Y,N',
            'penarikan' => 'required|string|in:Y,N',
            'pinjaman' => 'required|string|in:Y,N',
            'angsuran' => 'required|string|in:Y,N',
            'pemasukan_kas' => 'required|string|in:Y,N',
            'pengeluaran_kas' => 'required|string|in:Y,N',
            'transfer_kas' => 'required|string|in:Y,N',
        ]);

        try {
            $data_kas = $this->service->createDataKas($validated);

            return response()->success($data_kas, 'Success create data kas', 201);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'nama_kas' => 'required|string|max:255',
            'aktif' => 'required|string|in:Y,N',
            'simpanan' => 'required|string|in:Y,N',
            'penarikan' => 'required|string|in:Y,N',
            'pinjaman' => 'required|string|in:Y,N',
            'angsuran' => 'required|string|in:Y,N',
            'pemasukan_kas' => 'required|string|in:Y,N',
            'pengeluaran_kas' => 'required|string|in:Y,N',
            'transfer_kas' => 'required|string|in:Y,N',
        ]);

        try {
            $data_kas = $this->service->updateDataKas($validated, $id);

            return response()->success($data_kas, 'Success update data kas');
        } catch(DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->deleteDataKas($id);

            return response()->success(null, 'Success delete data kas');
        } catch(DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }
}
