<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('pelanggan', PelangganController::class);
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.create');
Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');

// Route::get('/pelanggan/data', [PembayaranController::class, 'getPelangganData'])->name('pelanggan.data');
Route::get('/pelangganPembayaran/{id}', [PembayaranController::class, 'getPelangganData'])->name('pelanggan.data');