<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;

Route::get('/pembayaran', function () {
    return view('pembayaran.index');
});

Route::resource('pelanggan', PelangganController::class);

