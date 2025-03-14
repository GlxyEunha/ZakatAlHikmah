<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZakatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('form-login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth.custom')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/rekap-zakat', function () {
        return view('zakat');
    })->name('rekap_zakat');
    Route::get('/rekap-pemohon', function () {
        return view('pemohon');
    })->name('rekap_pemohon');
    Route::get('/rekap-pengeluaran', function () {
        return view('pengeluaran');
    })->name('rekap_pengeluaran');
    Route::get('/zakat-form', [ZakatController::class, 'index_zakat'])->name('form-zakat');
    Route::post('/zakat', [ZakatController::class, 'store_zakat'])->name('zakat');
    Route::get('/pemohon-form', [ZakatController::class, 'index_pemohon'])->name('form-pemohon');
    Route::post('/pemohon', [ZakatController::class, 'store_pemohon'])->name('pemohon');
    Route::get('/pengeluaran-form', [ZakatController::class, 'index_pengeluaran'])->name('form-pengeluaran');
    Route::post('/pengeluaran', [ZakatController::class, 'store_pengeluaran'])->name('pengeluaran');
});
