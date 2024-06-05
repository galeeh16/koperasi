<?php declare(strict_types=1);

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Services\DropdownService;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Exceptions\DataNotFoundException;
use App\Services\Transaction\TransferService;

final class TransferController extends Controller
{
    public function __construct(
        private TransferService $transferService,
        private DropdownService $dropdownService
    ) {}

    public function index(): View
    {
        $data_kas = $this->dropdownService->dropdownDataKas();

        return view('transaction.transfer.index', [
            'data_kas' => $data_kas,
        ]);
    }

    public function show($id): JsonResponse
    {
        try {
            $data = $this->transferService->findByID($id);
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
            $data = $this->transferService->findAll($request);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
            'dari_kas' => 'required|string|max:255',
            'untuk_kas' => 'required|string|max:255',
        ]);

        try {
            $transfer = $this->transferService->createTransfer($validated);

            return response()->success($transfer, 'Success create transfer', 201);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
            'dari_kas' => 'required|string|max:255',
            'untuk_kas' => 'required|string|max:255',
        ]);

        try {
            $transfer = $this->transferService->updateTransfer($validated, $id);

            return response()->success($transfer, 'Success update transfer');
        } catch(DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->transferService->deleteTransfer($id);

            return response()->success(null, 'Success delete transfer');
        } catch (DataNotFoundException $e) {
            return response()->error(null, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->error($this->formatError($e));
        }
    }

}
