<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/penjualan/data-customer', fn() => view('penjualan.data-customer.index'));

    Route::get('/transaksi-kas/pemasukan', fn() => view('transaksi-kas.pemasukan.index', ['card_title' => 'Data Transaksi Pemasukan Kas']));
    Route::get('/transaksi-kas/pengeluaran', fn() => view('transaksi-kas.pemasukan.index', ['card_title' => 'Data Transaksi Pengeluaran Kas']));
    Route::get('/transaksi-kas/transfer', fn() => view('transaksi-kas.pemasukan.index', ['card_title' => 'Data Transaksi Transfer Kas']));

    Route::get('/simpanan/setoran-anggota', fn() => view('simpanan.setoran-anggota.index', ['card_title' => 'Data Transaksi Setoran Tunai']));
    Route::get('/simpanan/penarikan-simpanan', fn() => view('simpanan.setoran-anggota.index', ['card_title' => 'Data Transaksi Penarikan Simpanan']));
});

require __DIR__.'/auth.php';
require __DIR__ . '/master-data.php';
require __DIR__ . '/transaction.php';
require __DIR__ . '/reports.php';

