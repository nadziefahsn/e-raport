<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KriteriaPenilaianController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('sekolah', SekolahController::class);

    Route::get('kriteria', [KriteriaPenilaianController::class, 'update'])->name('kriteria.update');
    Route::resource('kriteria', KriteriaPenilaianController::class);
    Route::resource('guru', GuruController::class);
});