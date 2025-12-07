<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KejadianBencanaController;
use App\Http\Controllers\UserController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('check.login')->group(function () {

    // Dashboard bisa diakses semua role (Admin, Warga, Mitra)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /// ===================== ADMIN =====================
    Route::middleware('checkrole:Admin')->group(function () {
        Route::resource('warga', WargaController::class);
        Route::resource('users', UserController::class);

        // Admin boleh CRUD kejadian
        Route::resource('kejadian', KejadianBencanaController::class)
            ->except(['index', 'show']);
    });

    // ===================== WARGA =====================
    Route::middleware('checkrole:Warga')->group(function () {
        Route::resource('kejadian', KejadianBencanaController::class)
            ->only(['index', 'show']);
    });

    // ===================== MITRA =====================
    Route::middleware('checkrole:Mitra')->group(function () {
        Route::resource('kejadian', KejadianBencanaController::class)
            ->only(['index', 'show']);
    });
    
    // Logout untuk semua role
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
