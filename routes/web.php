<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SiMonDa Bukittinggi dalam Angka
|--------------------------------------------------------------------------
*/

// Authentication Routes (Guest)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Requires Login)
Route::middleware(['simonda.auth'])->group(function () {

    // 1. Halaman Pilihan Portal (Setelah Login: Kelola Akun atau Masuk SiMonDa)
    Route::get('/portal', [AuthController::class, 'showPortal'])->name('portal');

    // 2. Modul Kelola Akun Administrator
    Route::get('/kelola-akun', [AuthController::class, 'showKelolaAkun'])->name('kelola-akun');
    Route::post('/kelola-akun', [AuthController::class, 'updateKelolaAkun'])->name('kelola-akun.update');

    // 3. Modul Utama SiMonDa Bukittinggi (Berisi Isi Data OPD, Instansi, BPS, Monitoring, dll)
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/simonda', function () {
        return view('welcome');
    })->name('simonda');

    Route::get('/isi-data-opd', function () {
        return view('isi-data-opd');
    })->name('isi-data-opd');

    Route::get('/isi-data-instansi', function () {
        return view('isi-data-instansi');
    })->name('isi-data-instansi');

    Route::get('/data-bps', function () {
        return view('data-bps');
    })->name('data-bps');

    Route::get('/monitoring-opd', function () {
        return view('monitoring-opd');
    })->name('monitoring-opd');

    Route::get('/monitoring-instansi', function () {
        return view('monitoring-instansi');
    })->name('monitoring-instansi');

    Route::get('/tabel-opd', function () {
        return view('tabel-opd');
    })->name('tabel-opd');

    Route::get('/edit-tabel-opd', function () {
        return view('edit-tabel-opd');
    })->name('edit-tabel-opd');
});
