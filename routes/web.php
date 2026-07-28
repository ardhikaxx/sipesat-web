<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Masyarakat\DashboardController as MasyarakatDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;

Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'active'])->group(function () {

    Route::prefix('masyarakat')->middleware('role:masyarakat')->name('masyarakat.')->group(function () {
        Route::get('/dashboard', [MasyarakatDashboard::class, 'index'])->name('dashboard');
        Route::resource('laporan', App\Http\Controllers\Masyarakat\LaporanController::class);
    });

    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('laporan/export/pdf', [App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
        Route::get('laporan/export/excel', [App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
        Route::resource('laporan', App\Http\Controllers\Admin\LaporanController::class);
        Route::post('laporan/{laporan}/verifikasi', [App\Http\Controllers\Admin\LaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
        Route::post('laporan/{laporan}/tugaskan', [App\Http\Controllers\Admin\LaporanController::class, 'tugaskan'])->name('laporan.tugaskan');
        Route::post('laporan/{laporan}/validasi-akhir', [App\Http\Controllers\Admin\LaporanController::class, 'validasiAkhir'])->name('laporan.validasi-akhir');
        
        Route::resource('kategori-sampah', App\Http\Controllers\Admin\KategoriSampahController::class);
        Route::resource('wilayah', App\Http\Controllers\Admin\WilayahController::class);
        Route::resource('petugas', App\Http\Controllers\Admin\PetugasController::class);
        Route::resource('berita', App\Http\Controllers\Admin\BeritaController::class);
        Route::get('monitoring', [App\Http\Controllers\Admin\MonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('statistik', [App\Http\Controllers\Admin\StatistikController::class, 'index'])->name('statistik.index');
        Route::get('activity-log', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-log.index');
    });

    Route::prefix('petugas')->middleware('role:petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
        Route::resource('tugas', App\Http\Controllers\Petugas\TugasController::class);
        Route::post('tugas/{tugas}/update-status', [App\Http\Controllers\Petugas\TugasController::class, 'updateStatus'])->name('tugas.update-status');
    });
});
