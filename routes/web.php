<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KriteriaPenilaianController;

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
    Route::post('kriteria', [KriteriaPenilaianController::class, 'store'])->name('kriteria.store');
    Route::delete('kriteria', [KriteriaPenilaianController::class, 'destroy'])->name('kriteria.destroy');
});