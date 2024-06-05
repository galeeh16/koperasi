<?php

namespace App\Http\Controllers\Reports;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Exports\Excel\FromViewExcel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Pdf\AnggotaExportPdf;

final class AnggotaController extends Controller
{
    public function index()
    {
        return view('reports.anggota.index');
    }

    public function list(Request $request)
    {

    }

    public function exportPdf(Request $request)
    {
        $pdf = new AnggotaExportPdf(title: 'Test Aja Gasih');
        $str = $pdf->make();

        return response()->download($str)->deleteFileAfterSend(true);
    }

    public function exportExcel(Request $request)
    {
        $view = 'excel.anggota.excel';
    	$sheetName = 'Anggota';
    	$fileName = 'Laporan Anggota.xlsx';

        $data = $this->getData();

    	$params = [
    		'data' => $data,
    	];

    	return Excel::download(new FromViewExcel(
    		$view,
    		$params,
    		$sheetName, // [optional] Nama sheet default Sheet
    		false // [optional] untuk lock excel default true (terkunci)
    	), $fileName);
    }

    private function getData(): \Generator
    {
        $data = Anggota::query()->cursor();

        foreach ($data as $row) {
            yield $row;
        }
    }
}
