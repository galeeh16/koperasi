<?php declare(strict_types=1);

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Services\DropdownService;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Exceptions\DataNotFoundException;
use App\Services\Transaction\PemasukanService;

final class PemasukanController extends Controller
{
    public function __construct(
        private PemasukanService $service,
        private DropdownService $dropdownService
    ) {}

    public function index(): View
    {
        $jenis_akun = $this->dropdownService->dropdownJenisAkun();
        $data_kas = $this->dropdownService->dropdownDataKas();

        return view('transaction.pemasukan.index', [
            'jenis_akun' => $jenis_akun,
            'data_kas' => $data_kas
        ]);
    }

    public function show($id): JsonResponse
    {
        try {
            $data = $this->service->findByID($id);
            return response()->success($data);
        } catch(DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
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
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
            'dari_akun' => 'required|string|max:255',
            'untuk_kas' => 'required|string|max:255',
        ]);

        try {
            $pemasukan = $this->service->createPemasukan($validated);

            return response()->success($pemasukan, 'Success create pemasukan', 201);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
            'dari_akun' => 'required|string|max:255',
            'untuk_kas' => 'required|string|max:255',
        ]);

        try {
            $pemasukan = $this->service->updatePemasukan($validated, $id);

            return response()->success($pemasukan, 'Success update pemasukan');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->deletePemasukan($id);

            return response()->success(null, 'Success delete pemasukan');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }
}
