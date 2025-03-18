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
    Route::get('/dashboard', [ZakatController::class, 'dashboard'])->name('dashboard');

    //route rekap
    Route::get('/rekap-zakat', [ZakatController::class, 'index_zakat'])->name('rekap_zakat');
    Route::get('/rekap-pemohon', [ZakatController::class, 'index_pemohon'])->name('rekap_pemohon');
    Route::get('/rekap-pengeluaran', [ZakatController::class, 'index_pengeluaran'])->name('rekap_pengeluaran');

    //route form tambah
    Route::get('/zakat-form', function () {
        return view('form_zakat');
    })->name('form-zakat');
    Route::post('/zakat', [ZakatController::class, 'store_zakat'])->name('zakat');

    Route::get('/pemohon-form', function () {
        return view('form_pemohon');
    })->name('form-pemohon');
    Route::post('/pemohon', [ZakatController::class, 'store_pemohon'])->name('pemohon');

    Route::get('/pengeluaran-form', function () {
        return view('form_pengeluaran');
    })->name('form-pengeluaran');
    Route::post('/pengeluaran', [ZakatController::class, 'store_pengeluaran'])->name('pengeluaran');

    //route form edit & hapus
    Route::get('/pemohon/{id}/edit', [ZakatController::class, 'edit_pemohon'])->name('edit_pemohon');
    Route::put('/pemohon/{id}', [ZakatController::class, 'update_pemohon'])->name('update_pemohon');
    Route::delete('/pemohon/{id}', [ZakatController::class, 'delete_pemohon'])->name('delete_pemohon');

    Route::get('/pengeluaran/{id}/edit', [ZakatController::class, 'edit_pengeluaran'])->name('edit_pengeluaran');
    Route::put('/pengeluaran/{id}', [ZakatController::class, 'update_pengeluaran'])->name('update_pengeluaran');
    Route::delete('/pengeluaran/{id}', [ZakatController::class, 'delete_pengeluaran'])->name('delete_pengeluaran');

    Route::get('/zakat/{id}/edit', [ZakatController::class, 'edit_zakat'])->name('edit_zakat');
    Route::put('/zakat/{id}', [ZakatController::class, 'update_zakat'])->name('update_zakat');
    Route::delete('/zakat/{id}', [ZakatController::class, 'delete_zakat'])->name('delete_zakat');

    //export
    Route::get('/export-pemohon', [ZakatController::class, 'export_pemohon'])->name('export.pemohon');
    Route::get('/export-pengeluaran', [ZakatController::class, 'export_pengeluaran'])->name('export.pengeluaran');

    //delete all
});
