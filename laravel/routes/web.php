<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ReservasiController;



// Landing untuk customer
Route::get('/', function () {
    return view('landing');
})->name('landing');

// KATALOG CUSTOMER
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');

// RESERVASI CUSTOMER
Route::get('/reservasi/{id?}', [ReservasiController::class, 'create'])->name('reservasi.create');
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');



// GROUP ADMIN
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('produk', ProdukController::class);
});

