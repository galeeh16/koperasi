<?php declare(strict_types=1);

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Services\AnggotaService;
use App\Services\DropdownService;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Exceptions\DataNotFoundException;
use App\Http\Requests\Anggota\CreateAnggotaRequest;
use App\Http\Requests\Anggota\UpdateAnggotaRequest;

final class AnggotaController extends Controller
{
    public function __construct(
        private AnggotaService $anggotaService,
        private DropdownService $dropdownService
    ) {}

    public function index(): View
    {
        $status_menikah = $this->dropdownService->dropdownStatusMenikah();
        $departemen = $this->dropdownService->dropdownDepartemen();
        $pekerjaan = $this->dropdownService->dropdownPekerjaan();
        $agama = $this->dropdownService->dropdownAgama();

        return view('master-data.anggota.index', [
            'status_menikah' => $status_menikah,
            'departemen' => $departemen,
            'pekerjaan' => $pekerjaan,
            'agama' => $agama,
        ]);
    }

    public function show($id): JsonResponse
    {
        try {
            $anggota = $this->anggotaService->findByID($id);

            return response()->success($anggota);
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $data = $this->anggotaService->findAll($request);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e), status: 500);
        }
    }

    public function store(CreateAnggotaRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $new_anggota = $this->anggotaService->createAnggota($validated);

        return response()->success($new_anggota, 'Success create anggota', 201);
    }

    public function update(UpdateAnggotaRequest $request, $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            $update_anggota = $this->anggotaService->updateAnggota($validated, $id);

            return response()->success($update_anggota, 'Success update anggota');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->anggotaService->deleteAnggotaByID($id);

            return response()->success(null, 'Success delete anggota');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }
}
