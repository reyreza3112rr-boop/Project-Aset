<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman login — hanya bisa diakses jika BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // OAuth — Google & GitHub
    Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirectToProvider'])
        ->name('auth.redirect');
    Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback'])
        ->name('auth.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard & resource lain — sebaiknya dilindungi middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('stok', StokController::class);
    Route::resource('ruangan', RuanganController::class);
});