<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TabelOpdController;
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

    // 2. Modul Kelola Akun Administrator & Akun Dinas
    Route::get('/kelola-akun', [AuthController::class, 'showKelolaAkun'])->name('kelola-akun');
    Route::post('/kelola-akun', [AuthController::class, 'updateKelolaAkun'])->name('kelola-akun.update');

    // Operasi CRUD Akun Dinas & Hak Akses Halaman
    Route::post('/kelola-akun/dinas', [AuthController::class, 'createDinasUser'])->name('kelola-akun.dinas.create');
    Route::post('/kelola-akun/dinas/{id}/update', [AuthController::class, 'updateDinasUser'])->name('kelola-akun.dinas.update');
    Route::post('/kelola-akun/dinas/{id}/delete', [AuthController::class, 'deleteDinasUser'])->name('kelola-akun.dinas.delete');
    Route::post('/kelola-akun/dinas/bulk-delete', [AuthController::class, 'bulkDeleteDinasUsers'])->name('kelola-akun.dinas.bulk-delete');
    Route::post('/kelola-akun/dinas/{id}/toggle-status', [AuthController::class, 'toggleDinasUserStatus'])->name('kelola-akun.dinas.toggle-status');
    Route::post('/kelola-akun/dinas/batch-seed', [AuthController::class, 'batchSeedDinasUsers'])->name('kelola-akun.dinas.batch-seed');
    Route::post('/kelola-akun/instansi/batch-seed', [AuthController::class, 'batchSeedInstansiUsers'])->name('kelola-akun.instansi.batch-seed');

    // 3. Modul Utama SiMonDa Bukittinggi (Berisi Isi Data OPD, Instansi, BPS, Monitoring, dll)
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/simonda', function () {
        return view('welcome');
    })->name('simonda');

    Route::get('/isi-data-opd', function () {
        return view('dinas.isi-opd');
    })->name('isi-data-opd');

    Route::get('/isi-data-instansi', function () {
        return view('dinas.isi-instansi');
    })->name('isi-data-instansi');

    Route::get('/data-bps', function () {
        return view('dinas.data-bps');
    })->name('data-bps');

    Route::get('/monitoring-opd', function () {
        return view('monitoring.opd');
    })->name('monitoring-opd');

    Route::get('/monitoring-instansi', function () {
        return view('monitoring.instansi');
    })->name('monitoring-instansi');

    Route::get('/tabel-opd', [TabelOpdController::class, 'index'])->name('tabel-opd');
    Route::get('/edit-tabel-opd', [TabelOpdController::class, 'edit'])->name('edit-tabel-opd');
    Route::get('/api/tabel-opd/data', [TabelOpdController::class, 'apiGetData'])->name('tabel-opd.api.data');
    Route::post('/api/tabel-opd/save', [TabelOpdController::class, 'apiSaveData'])->name('tabel-opd.api.save');
    Route::post('/api/tabel-opd/delete', [TabelOpdController::class, 'apiDeleteData'])->name('tabel-opd.api.delete');
});
