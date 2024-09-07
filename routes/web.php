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
    Route::resource('cuti', CutiController::class);
    Route::resource('pengajuan_cuti', PengajuanCutiController::class);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
