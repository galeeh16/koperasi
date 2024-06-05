<?php declare(strict_types=1);

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\DepartemenService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Exceptions\DataNotFoundException;

final class DepartemenController extends Controller
{
    public function __construct(private DepartemenService $departemenService) {}

    public function index(): View
    {
        return view('master-data.departemen.index');
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $data = $this->departemenService->findAll($request);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($this->formatError($e));
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|min:3|max:255'
        ]);

        try {
            $departemen = $this->departemenService->createDepartemen($validated);

            return response()->success($departemen, 'Success create departemen', 201);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|min:3|max:255'
        ]);

        try {
            $departemen = $this->departemenService->updateDepartemen($validated, $id);

            return response()->success($departemen, 'Success update departemen');
        } catch(DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->departemenService->deleteDepartemen($id);

            return response()->success(null, 'Success delete departemen');
        } catch(DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }
}
