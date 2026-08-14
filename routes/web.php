<?php
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoletUndianController;
use Illuminate\Support\Facades\Route;
Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
Route::get('/absensi/hasil', [AbsensiController::class, 'hasil'])->name('absensi.hasil');
Route::get('/rolet-undian/tampilan', [RoletUndianController::class, 'display'])->name('rolet.display');
Route::get('/rolet-undian/latest-json', [RoletUndianController::class, 'latestJson'])->name('rolet.latest');

// Halaman Admin

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/cetak-pdf', [DashboardController::class, 'cetakPdf'])->name('dashboard.cetak');
        Route::prefix('peserta')->name('peserta.')->group(function () {
            Route::get('/create', [DashboardController::class, 'create'])->name('create');
            Route::post('/', [DashboardController::class, 'store'])->name('store');
            Route::get('/{peserta}/edit', [DashboardController::class, 'edit'])->name('edit');
            Route::put('/{peserta}', [DashboardController::class, 'update'])->name('update');
            Route::delete('/{peserta}', [DashboardController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('rolet-undian')->name('rolet.')->group(function () {
            Route::get('/', [RoletUndianController::class, 'index'])->name('index');
            Route::post('/undi', [RoletUndianController::class, 'undi'])->name('undi');
            Route::post('/reset', [RoletUndianController::class, 'reset'])->name('reset');
        });
    });
});