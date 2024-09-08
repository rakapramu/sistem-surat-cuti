<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\CutiController;
use App\Http\Controllers\Dashboard\PengajuanCutiController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginAction'])->name('loginAction');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerAction'])->name('registerAction');
});
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.main');
    })->name('dashboard');
    Route::resource('cuti', CutiController::class)->middleware('isAdmin');
    Route::resource('pengajuan_cuti', PengajuanCutiController::class);
    Route::get('riwayat-pengajuan', [PengajuanCutiController::class, 'riwayat'])->name('riwayatPengajuan')->middleware('isAdmin');
    Route::post('updateStatus/{pengajuanCuti}', [PengajuanCutiController::class, 'updateStatus'])->name('updateStatus')->middleware('isAdmin');
    Route::get('report', [PengajuanCutiController::class, 'report'])->name('report')->middleware('isAdmin');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
