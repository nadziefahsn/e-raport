<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KriteriaPenilaianController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KarakterController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CapaianPerkembanganController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\PengumumanController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('sekolah', SekolahController::class);
    Route::resource('kriteria', KriteriaPenilaianController::class)->parameters([
        'kriteria' => 'kriteriapenilaian',
    ]);
    Route::resource('tahun_ajaran', TahunAjaranController::class);
    Route::resource('capaian-perkembangan', CapaianPerkembanganController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class)->parameters([
        'kelas'=>'kelas'
    ]);
    Route::resource('karakter', KarakterController::class);
    Route::resource('pengumuman', PengumumanController::class);
Route::resource('indikator', IndikatorController::class);
});