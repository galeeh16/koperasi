<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\AnggotaController;

Route::group(['prefix' => 'reports'], function() {
    // report anggota
    Route::group(['prefix' => 'anggota'], function() {
        Route::get('/', [AnggotaController::class, 'index']);
        Route::post('/list', [AnggotaController::class, 'list']);
        Route::post('/export-excel', [AnggotaController::class, 'exportExcel']);
        Route::post('/export-pdf', [AnggotaController::class, 'exportPdf']);
    });
});
