<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\KlaimController;

// ─── AUTH ─────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── PUBLIC ───────────────────────────────────────────────
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/barang', [PublicController::class, 'galeri'])->name('barang.index');
Route::get('/barang/{id}', [PublicController::class, 'detail'])->name('barang.show');
Route::post('/barang/{id}/klaim', [PublicController::class, 'klaim'])->name('barang.klaim');

// ─── ADMIN (protected) ────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Barang (CRUD)
    Route::resource('barang', BarangController::class);

    // Klaim
    Route::get('/klaim', [KlaimController::class, 'index'])->name('klaim.index');
    Route::get('/klaim/{id}', [KlaimController::class, 'show'])->name('klaim.show');
    Route::post('/klaim/{id}/update', [KlaimController::class, 'update'])->name('klaim.update');
});
