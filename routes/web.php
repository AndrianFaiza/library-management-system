<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DetailController;

// view login
Route::get('/', [AuthController::class, 'showLogin'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::resource('book', BookController::class);
    Route::resource('pengembalian', PengembalianController::class);
    Route::resource('detail', DetailController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('rak', RakController::class);
    Route::resource('siswa', SiswaController::class);
    Route::post('/detail/{detail}/kembalikan', [\App\Http\Controllers\PengembalianController::class, 'kembalikan'])->name('detail.kembalikan');
});
