<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProdukController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tailwind-test', function () {
    return view('tailwind-test');
});

// GROUP ADMIN
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('produk', ProdukController::class);
});
