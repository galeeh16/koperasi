<?php declare(strict_types=1);

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\JenisAkunService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Exceptions\DataNotFoundException;

final class JenisAkunController extends Controller
{
    public function __construct(private JenisAkunService $service) {}

    public function index(): View
    {
        return view('master-data.jenis-akun.index');
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $data = $this->service->findAll($request);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kode_aktiva' => 'required|string|min:2|max:255',
            'nama_akun' => 'required|string',
            'akun' => 'required|string',
            'pemasukan' => 'required|string',
            'pengeluaran' => 'required|string',
            'laba_rugi' => 'required|string',
        ]);

        try {
            $jenis_akun = $this->service->createJenisAkun($validated);

            return response()->success($jenis_akun, 'Success create jenis akun', 201);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'kode_aktiva' => 'required|string|min:2|max:255',
            'nama_akun' => 'required|string',
            'akun' => 'required|string',
            'pemasukan' => 'required|string',
            'pengeluaran' => 'required|string',
            'laba_rugi' => 'required|string',
        ]);

        try {
            $update = $this->service->updateJenisAkun($validated, $id);

            return response()->success($update, 'Success update jenis akun', 200);
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->deleteJenisAkun($id);

            return response()->success(null, 'Success delete jenis akun', 200);
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }
}
