<?php

use App\Http\Controllers\laporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::resource('pelanggan', PelangganController::class);
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.create');
Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');

// Route::get('/pelanggan/data', [PembayaranController::class, 'getPelangganData'])->name('pelanggan.data');
Route::get('/pelangganPembayaran/{id}', [PembayaranController::class, 'getPelangganData'])->name('pelanggan.data');
Route::get('/laporan', [App\Http\Controllers\laporanController::class, 'laporanPelanggan'])->name('laporan.pelanggan');
Route::get('/export-excel', [laporanController::class, 'exportExcel'])->name('export.excel');
Route::get('/export-pdf', [laporanController::class, 'exportPDF'])->name('export.pdf');



Route::get('/home', [PelangganController::class, 'index']);
Route::resource('users', UserController::class);
});