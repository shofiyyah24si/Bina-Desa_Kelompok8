<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KejadianBencanaController;
use App\Http\Controllers\PoskoBencanaController;
use App\Http\Controllers\DonasiBencanaController;
use App\Http\Controllers\LogistikBencanaController;
use App\Http\Controllers\DistribusiLogistikController;
use App\Http\Controllers\UserController;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

 Route::view('/', 'landing/landing')->name('landing');

Route::middleware(['auth'])->group(function () {
    // =============================================
    // ROUTE UNTUK SEMUA USER (ADMIN & WARGA)
    // =============================================

    // DASHBOARD - bisa diakses admin & warga
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PROFILE ROUTES - bisa diakses admin & warga
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/avatar/update', [ProfileController::class, 'updateAvatar'])
            ->name('profile.avatar.update');
        Route::delete('/avatar/delete', [ProfileController::class, 'deleteAvatar'])
            ->name('profile.avatar.delete');
        Route::post('/update', [ProfileController::class, 'updateProfile'])
            ->name('profile.update');
    });

    // =============================================
    // ROUTE KHUSUS ADMIN SAJA
    // =============================================
    // GANTI INI:
    // Route::middleware('admin')->group(function () {
    // MENJADI INI:
    Route::middleware([AdminMiddleware::class])->group(function () {
        // RESTful CRUD Routes - hanya untuk admin
        Route::resource('kejadian', KejadianController::class);
        Route::resource('posko', PoskoController::class);
        Route::resource('donasi', DonasiBencanaController::class);
        Route::resource('logistik', LogistikBencanaController::class);

        // Additional custom routes - hanya untuk admin
        Route::delete('/kejadian/file/{id}', [KejadianController::class, 'deleteFile'])
            ->name('kejadian.deleteFile');

        Route::post('/logistik/{id}/reduce-stock', [LogistikBencanaController::class, 'reduceStock'])
            ->name('logistik.reduce-stock');
    });
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

    Route::resource('posko', PoskoBencanaController::class);

    Route::resource('donasi', DonasiBencanaController::class);

    Route::resource('logistik', LogistikBencanaController::class);

    Route::resource('distribusi', DistribusiLogistikController::class);

});
