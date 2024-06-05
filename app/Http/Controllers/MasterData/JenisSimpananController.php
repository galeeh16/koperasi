<?php declare(strict_types=1);

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\JenisSimpananService;
use App\Exceptions\DataNotFoundException;

final class JenisSimpananController extends Controller
{
    public function __construct(private JenisSimpananService $service) {}

    public function index(): View
    {
        return view('master-data.jenis-simpanan.index');
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $data = $this->service->findAll($request);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'jenis_simpanan' => 'required|string',
            'jumlah' => 'required|numeric',
            'tampil' => 'required|string|in:Y,N'
        ]);

        try {
            $jenis_simpanan = $this->service->createJenisSimpanan($validated);

            return response()->success($jenis_simpanan, 'Success created data', 201);
        } catch (\Exception $e) {
            return response()->json($this->formatError($e), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'jenis_simpanan' => 'required|string',
            'jumlah' => 'required|numeric',
            'tampil' => 'required|string|in:Y,N'
        ]);

        try {
            $jenis_simpanan = $this->service->updateJenisSimpanan($validated, $id);

            return response()->success($jenis_simpanan, 'Success update data');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->json($this->formatError($e), 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->deleteJenisSimpanan($id);

            return response()->success(null, 'Sukses menghapus data');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->json($this->formatError($e), 500);
        }
    }
}
