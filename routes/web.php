<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TabelOpdController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SiBingka - Sistem Informasi Bukittinggi dalam Angka
|--------------------------------------------------------------------------
*/

// Authentication Routes (Guest)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Requires Login)
Route::middleware(['sibingka.auth'])->group(function () {

    // 1. Halaman Pilihan Portal (Setelah Login: Kelola Akun atau Masuk SiBingka)
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

    // 3. Modul Utama SiBingka Bukittinggi (Berisi Isi Data OPD, Instansi, BPS, Monitoring, dll)
    Route::view('/', 'welcome')->name('home');

    Route::view('/sibingka', 'welcome')->name('sibingka');

    Route::get('/isi-data-opd', [PageController::class, 'isiDataOpd'])->name('isi-data-opd');

    Route::get('/isi-data-instansi', [PageController::class, 'isiDataInstansi'])->name('isi-data-instansi');

    Route::get('/data-bps', [PageController::class, 'dataBps'])->name('data-bps');

    Route::view('/monitoring-opd', 'monitoring.opd')->name('monitoring-opd');

    Route::view('/monitoring-instansi', 'monitoring.instansi')->name('monitoring-instansi');

    Route::view('/monitoring-bps', 'monitoring.bps')->name('monitoring-bps');

    Route::post('/monitoring/update-stage', [MonitoringController::class, 'updateStage'])->name('monitoring.update-stage');

    Route::get('/tabel-opd', [TabelOpdController::class, 'index'])->name('tabel-opd');
    Route::get('/tabel', [TabelOpdController::class, 'index'])->name('tabel');
    Route::get('/edit-tabel-opd', [TabelOpdController::class, 'edit'])->name('edit-tabel-opd');
    Route::get('/tabel-opd/export-excel', [TabelOpdController::class, 'exportExcel'])->name('tabel-opd.export-excel');
    Route::get('/tabel-opd/export-agency-excel', [TabelOpdController::class, 'exportAgencyExcel'])->name('tabel-opd.export-agency-excel');
    Route::post('/tabel-opd/import-excel', [TabelOpdController::class, 'importExcel'])->name('tabel-opd.import-excel');
    Route::get('/api/tabel-opd/data', [TabelOpdController::class, 'apiGetData'])->name('tabel-opd.api.data');
    Route::post('/api/tabel-opd/save', [TabelOpdController::class, 'apiSaveData'])->name('tabel-opd.api.save');
    Route::post('/api/tabel-opd/delete', [TabelOpdController::class, 'apiDeleteData'])->name('tabel-opd.api.delete');
    Route::get('/api/tabel-opd/custom-catalog', [TabelOpdController::class, 'apiGetCustomCatalog'])->name('tabel-opd.api.custom-catalog');
    Route::post('/api/tabel-opd/save-custom-catalog', [TabelOpdController::class, 'apiSaveCustomCatalog'])->name('tabel-opd.api.save-custom-catalog');
    Route::post('/api/tabel-opd/delete-custom-catalog', [TabelOpdController::class, 'apiDeleteCustomCatalog'])->name('tabel-opd.api.delete-custom-catalog');
    Route::get('/api/tabel-opd/comments', [TabelOpdController::class, 'apiGetComments'])->name('tabel-opd.api.comments');
    Route::post('/api/tabel-opd/comments', [TabelOpdController::class, 'apiSaveComment'])->name('tabel-opd.api.save-comment');
    Route::delete('/api/tabel-opd/comments/{id}', [TabelOpdController::class, 'apiDeleteComment'])->name('tabel-opd.api.delete-comment');

    // Workflow Verifikasi & ACC Monitoring Tabel
    Route::post('/api/tabel-opd/submit-verification', [TabelOpdController::class, 'apiSubmitVerification'])->name('tabel-opd.api.submit-verification');
    Route::post('/api/tabel-opd/approve-verification', [TabelOpdController::class, 'apiApproveVerification'])->name('tabel-opd.api.approve-verification');
    Route::post('/api/tabel-opd/reject-verification', [TabelOpdController::class, 'apiRejectVerification'])->name('tabel-opd.api.reject-verification');
    Route::post('/api/tabel-opd/unlock-table', [TabelOpdController::class, 'apiUnlockTable'])->name('tabel-opd.api.unlock-table');
});
