<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction\TransferController;
use App\Http\Controllers\Transaction\PemasukanController;
use App\Http\Controllers\Transaction\PengeluaranController;

Route::group(['prefix' => 'transactions'], function() {
    // pemasukan
    Route::group(['prefix' => 'pemasukan'], function() {
        Route::get('/', [PemasukanController::class,  'index']);
        Route::get('/{id}', [PemasukanController::class, 'show']);
        Route::post('/', [PemasukanController::class, 'store']);
        Route::post('/list', [PemasukanController::class, 'list']);
        Route::put('/{id}', [PemasukanController::class, 'update']);
        Route::delete('/{id}', [PemasukanController::class, 'destroy']);
    });

    // pengeluaran
    Route::group(['prefix' => 'pengeluaran'], function() {
        Route::get('/', [PengeluaranController::class, 'index']);
        Route::get('/{id}', [PengeluaranController::class, 'show']);
        Route::post('/', [PengeluaranController::class, 'store']);
        Route::post('/list', [PengeluaranController::class, 'list']);
        Route::put('/{id}', [PengeluaranController::class, 'update']);
        Route::delete('/{id}', [PengeluaranController::class, 'destroy']);
    });

    // transfer
    Route::group(['prefix' => 'transfer'], function() {
        Route::get('/', [TransferController::class, 'index']);
        Route::get('/{id}', [TransferController::class, 'show']);
        Route::post('/', [TransferController::class, 'store']);
        Route::post('/list', [TransferController::class, 'list']);
        Route::put('/{id}', [TransferController::class, 'update']);
        Route::delete('/{id}', [TransferController::class, 'destroy']);
    });
});
