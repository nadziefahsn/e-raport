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
use App\Http\Controllers\DataKarakterController;
use App\Http\Controllers\HasilCapaianController;
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

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('sekolah', SekolahController::class)->except(['create','show','edit','destroy'])->whereNumber('sekolah');
    Route::resource('kriteria', KriteriaPenilaianController::class)->parameters([
        'kriteria' => 'kriteriapenilaian',
    ]);

    Route::resource('tahun_ajaran', TahunAjaranController::class);
    Route::resource('capaian-perkembangan', CapaianPerkembanganController::class);
    
    // Rute Guru
    Route::resource('guru', GuruController::class);
    Route::get('/guru/{id}/edit-password', [GuruController::class, 'editPassword'])->name('guru.edit-password');
    Route::put('/guru/{id}/update-password', [GuruController::class, 'updatePassword'])->name('guru.update-password');
    Route::put('/guru/{id}/update-user', [GuruController::class, 'updateUser'])->name('guru.update-user');

    Route::resource('siswa', SiswaController::class)->except(['show'])->whereNumber('siswa');
    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas'
    ]);
    Route::resource('karakter', KarakterController::class)->except(['show'])->whereNumber('karakter');
    Route::resource('pengumuman', PengumumanController::class)->except(['show'])->whereNumber('pengumuman');
    Route::resource('indikator', IndikatorController::class);
    Route::resource('anggota-kelas', AnggotaKelasController::class);
    Route::resource('kehadiran', KehadiranController::class)->only(['index','update'])->whereNumber('kehadiran');
    
    Route::resource('gigi', KesehatanGigiController::class)->only(['index','update'])->whereNumber('gigi');
    Route::resource('mulut', KesehatanMulutController::class)->only(['index','update'])->whereNumber('mulut');
    Route::resource('mata', KesehatanMataController::class)->only(['index','update'])->whereNumber('mata');
    Route::resource('kondisi-tubuh', KondisiTubuhController::class)->only(['index','update'])->whereNumber('kondisi-tubuh');
    Route::resource('kebersihan-siswa', KebersihanSiswaController::class)->only(['index','update'])->whereNumber('kebersihan-siswa');
    
    Route::get('/indikator-{kategori}', [IndikatorCapaianController::class, 'index'])->name('indikator-capaian.index');
    Route::resource('indikator-capaian', IndikatorCapaianController::class)->except(['create','show','edit','update'])->whereNumber('indikator-capaian');
    
    Route::resource('nilai-karakter', NilaiKarakterController::class)->except(['create','show','edit','destroy'])->whereNumber('nilai-karakter');
    
    Route::get('/hasil-capaian/{slug?}', [HasilCapaianController::class, 'index'])->name('hasil-capaian.kategori');
    Route::resource('hasil-capaian', HasilCapaianController::class)->except(['create','show','edit','destroy'])->whereNumber('hasil-capaian');
    
    Route::resource('kesehatan-telinga', KesehatanTelingaController::class)
    ->except(['create','show','store','edit','destroy'])
    ->parameters([
        'kesehatan-telinga' => 'telinga'
    ])
    ->whereNumber('telinga');

    Route::resource('data-karakter', DataKarakterController::class)->only(['index']);
});