<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\KejadianBencanaController;
use App\Http\Controllers\Admin\PoskoBencanaController;
use App\Http\Controllers\Admin\DonasiBencanaController;
use App\Http\Controllers\Admin\LogistikBencanaController;
use App\Http\Controllers\Admin\DistribusiLogistikController;
use App\Http\Controllers\Admin\UserController;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('check.login')->group(function () {

    // Dashboard bisa diakses semua user (semua Admin)
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // Semua fitur bisa diakses karena semua user adalah Admin
    Route::resource('warga', WargaController::class);
    Route::resource('users', UserController::class);
    Route::resource('kejadian', KejadianBencanaController::class);
    Route::resource('posko', PoskoBencanaController::class);
    Route::resource('donasi', DonasiBencanaController::class);
    Route::resource('logistik', LogistikBencanaController::class);
    Route::resource('distribusi', DistribusiLogistikController::class);
    
    // AJAX routes
    Route::get('/api/logistik/{id?}', [DistribusiLogistikController::class, 'getLogistikData'])->name('api.logistik');

    // Logout untuk semua user
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
