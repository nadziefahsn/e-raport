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
use App\Http\Controllers\AnggotaKelasController;
use App\Http\Controllers\IndikatorCapaianController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KesehatanGigiController;
use App\Http\Controllers\KondisiTubuhController;
use App\Http\Controllers\KesehatanMulutController;
use App\Http\Controllers\KesehatanMataController;
use App\Http\Controllers\KebersihanSiswaController;
use App\Http\Controllers\NilaiKarakterController;
use App\Http\Controllers\KesehatanTelingaController;

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
        'kelas' => 'kelas'
    ]);
    Route::resource('karakter', KarakterController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('indikator', IndikatorController::class);
    Route::resource('anggota-kelas', AnggotaKelasController::class);
    Route::resource('kehadiran', KehadiranController::class);
    Route::resource('gigi', KesehatanGigiController::class);
    Route::resource('mulut', KesehatanMulutController::class);
    Route::resource('mata', KesehatanMataController::class);
    Route::resource('kondisi-tubuh', KondisiTubuhController::class);
    Route::resource('kebersihan-siswa', KebersihanSiswaController::class);
    Route::resource('indikator-capaian', IndikatorCapaianController::class);
    Route::get('/indikator-{kategori}', [IndikatorCapaianController::class, 'index'])->name('indikator-capaian.index');
    Route::resource('nilai-karakter', NilaiKarakterController::class);
    Route::resource('kesehatan-telinga', KesehatanTelingaController::class)->parameters([
        'kesehatan-telinga' => 'telinga'
    ]);
});