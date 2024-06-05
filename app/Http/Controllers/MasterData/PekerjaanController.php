<?php declare(strict_types=1);

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PekerjaanService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Exceptions\DataNotFoundException;

final class PekerjaanController extends Controller
{
    public function __construct(private PekerjaanService $pekerjaanService) {}

    public function index(): View
    {
        return view('master-data.pekerjaan.index');
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $data = $this->pekerjaanService->findAll($request);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'pekerjaan' => 'required|string|min:3|max:255'
        ]);

        try {
            $data = $this->pekerjaanService->createPekerjaan($validated);

            return response()->success($data, 'Success create pekerjaan', 201);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'pekerjaan' => 'required|string|min:3|max:255'
        ]);

        try {
            $data = $this->pekerjaanService->updatePekerjaan($validated, $id);

            return response()->success($data, 'Success update pekerjaan');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function destroy($id)
    {
        try {
            $this->pekerjaanService->deletePekerjaan($id);

            return response()->success(null, 'Success delete pekerjaan');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }
}
