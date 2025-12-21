<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| LANDING & KATALOG
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('landing'))->name('landing');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/produk/stok', [KatalogController::class, 'stok'])->name('produk.stok');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| CUSTOMER (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // KERANJANG
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    Route::post('/keranjang/item/{id}/plus', [KeranjangController::class, 'increaseQty'])
        ->name('keranjang.plus');
    Route::post('/keranjang/item/{id}/minus', [KeranjangController::class, 'decreaseQty'])
        ->name('keranjang.minus');

    // CHECKOUT
    Route::post('/checkout', [ReservasiController::class, 'storeFromKeranjang'])
        ->name('checkout.store');

    // RESERVASI
    Route::get('/reservasi', [ReservasiController::class, 'index'])
        ->name('reservasi.index');

    Route::get('/reservasi/create/{idbarang?}', [ReservasiController::class, 'create'])
        ->name('reservasi.create');

    Route::post('/reservasi', [ReservasiController::class, 'store'])
        ->name('reservasi.store');

    Route::post('/reservasi/from-keranjang', [ReservasiController::class, 'storeFromKeranjang'])
        ->name('reservasi.storeFromKeranjang');

    

    // 🔐 PAYMENT MIDTRANS
    Route::get(
        '/reservasi/{reservation}/pay',
        [PaymentController::class, 'pay']
    )->name('reservasi.pay');

    // (opsional, kalau suatu saat customer boleh cancel)
    Route::post('/reservasi/status/{id}', [ReservasiController::class, 'updateStatus'])
        ->name('reservasi.updateStatus');

    // AJAX
    Route::get('/get-products-by-category', [ReservasiController::class, 'getProductsByCategory'])
        ->name('get.products.by.category');
});

/*
| ADMIN ROUTES
*/
Route::prefix('admin')
    ->middleware('auth')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('produk', ProdukController::class);

        Route::patch(
            '/reservasi/{reservation}/status',
            [ReservationAdminController::class, 'updateStatus']
        )->name('reservasi.update-status');
    });

/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK (NO AUTH)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [PaymentController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| PAYMENT FINISH / RESULT
|--------------------------------------------------------------------------
*/
Route::get('/payment/finish', [PaymentController::class, 'finish'])
    ->name('payment.finish');
Route::get('/payment/unfinish', [PaymentController::class, 'unfinish'])
    ->name('payment.unfinish');
Route::get('/payment/error', [PaymentController::class, 'error'])
    ->name('payment.error');