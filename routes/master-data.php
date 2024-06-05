<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterData\AnggotaController;
use App\Http\Controllers\MasterData\DataKasController;
use App\Http\Controllers\MasterData\JenisAkunController;
use App\Http\Controllers\MasterData\PekerjaanController;
use App\Http\Controllers\MasterData\DepartemenController;
use App\Http\Controllers\MasterData\JenisSimpananController;

Route::group(['prefix' => 'master-data', 'middleware' => 'auth'], function() {
    // jenis simpanan
    Route::group(['prefix' => 'jenis-simpanan'], function() {
        Route::get('/', [JenisSimpananController::class, 'index']);
        Route::post('/', [JenisSimpananController::class, 'store']);
        Route::post('/list', [JenisSimpananController::class, 'list']);
        Route::put('/{id}', [JenisSimpananController::class, 'update']);
        Route::delete('/{id}', [JenisSimpananController::class, 'destroy']);
    });

    // anggota
    Route::group(['prefix' => 'anggota'], function() {
        Route::get('/', [AnggotaController::class, 'index']);
        Route::get('/{id}', [AnggotaController::class, 'show']);
        Route::post('/', [AnggotaController::class, 'store']);
        Route::post('/list', [AnggotaController::class, 'list']);
        Route::post('/update/{id}', [AnggotaController::class, 'update']);
        Route::delete('/{id}', [AnggotaController::class, 'destroy']);
    });

    // pekerjaan
    Route::group(['prefix' => 'pekerjaan'], function() {
        Route::get('/', [PekerjaanController::class, 'index']);
        Route::post('/', [PekerjaanController::class, 'store']);
        Route::post('/list', [PekerjaanController::class, 'list']);
        Route::put('/{id}', [PekerjaanController::class, 'update']);
        Route::delete('/{id}', [PekerjaanController::class, 'destroy']);
    });

    // jenis akun
    Route::group(['prefix' => 'jenis-akun'], function() {
        Route::get('/', [JenisAkunController::class, 'index']);
        Route::post('/', [JenisAkunController::class, 'store']);
        Route::post('/list', [JenisAkunController::class, 'list']);
        Route::put('/{id}', [JenisAkunController::class, 'update']);
        Route::delete('/{id}', [JenisAkunController::class, 'destroy']);
    });

    // data kas
    Route::group(['prefix' => 'data-kas'], function() {
        Route::get('/', [DataKasController::class, 'index']);
        Route::post('/', [DataKasController::class, 'store']);
        Route::post('/list', [DataKasController::class, 'list']);
        Route::put('/{id}', [DataKasController::class, 'update']);
        Route::delete('/{id}', [DataKasController::class, 'destroy']);
    });

    // departemen
    Route::group(['prefix' => 'departemen'], function() {
        Route::get('/', [DepartemenController::class, 'index']);
        Route::post('/', [DepartemenController::class, 'store']);
        Route::post('/list', [DepartemenController::class, 'list']);
        Route::put('/{id}', [DepartemenController::class, 'update']);
        Route::delete('/{id}', [DepartemenController::class, 'destroy']);
    });
});
