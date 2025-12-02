<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KejadianBencanaController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
}); 

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/ketua', function () {
    return view('ketua');
});

Route::get('/angggota', function () {
    return view('anggota');
});

Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

Route::resource('warga',WargaController::class);
Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
  // Route::get('/', fn() => redirect()->route('admin.dashboard'));
  // Route::get('/dashboard', [AdminDashboardController::class,'index'])->name('dashboard');
  // Route::resource('incidents', Admin\IncidentController::class);
});


Route::resource('kejadian', KejadianBencanaController::class);