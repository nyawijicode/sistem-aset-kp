<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Models\Asset;
use App\Models\AssetIn;
use App\Models\AssetOut;

Route::middleware(['auth'])->group(function () {
    Route::get('/laporan/aset', function () {
        return view('laporan.asset', ['data' => Asset::orderBy('name')->get()]);
    })->name('laporan.asset');

    Route::get('/laporan/aset-masuk', function () {
        return view('laporan.asset-in', ['data' => AssetIn::with(['asset', 'creator'])->latest('date')->get()]);
    })->name('laporan.asset-in');

    Route::get('/laporan/aset-keluar', function () {
        return view('laporan.asset-out', ['data' => AssetOut::with(['asset', 'creator'])->latest('date')->get()]);
    })->name('laporan.asset-out');
});
