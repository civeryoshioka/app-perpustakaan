<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);

    // Route laporan didaftarkan sebelum resource loans supaya '/loans/report'
    // tidak tertangkap parameter {loan} milik route show resource.
    Route::get('/loans/report', [LoanController::class, 'report'])->name('loans.report');
    Route::resource('loans', LoanController::class);
    Route::put('/loans/{id}/kembalikan', [LoanController::class, 'kembalikan'])
        ->name('loans.kembalikan');

    // Kelola kategori sifatnya administratif (bukan operasional harian petugas),
    // jadi khusus dibatasi untuk role admin lewat middleware CheckAdminRole.
    Route::middleware(['admin'])->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
    });
});
