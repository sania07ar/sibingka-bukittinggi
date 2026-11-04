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
        $customTables = \App\Models\TabelMetadata::whereIn('source_type', ['custom', 'custom_opd'])
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();
        return view('dinas.isi-opd', compact('customTables'));
    })->name('isi-data-opd');

    Route::get('/isi-data-instansi', function () {
        $customTables = \App\Models\TabelMetadata::where('source_type', 'custom_instansi')
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();
        return view('dinas.isi-instansi', compact('customTables'));
    })->name('isi-data-instansi');

    Route::get('/data-bps', function () {
        $customTables = \App\Models\TabelMetadata::whereIn('source_type', ['custom_bps', 'bps'])
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();
        return view('dinas.data-bps', compact('customTables'));
    })->name('data-bps');

    Route::get('/monitoring-opd', function () {
        return view('monitoring.opd');
    })->name('monitoring-opd');

    Route::get('/monitoring-instansi', function () {
        return view('monitoring.instansi');
    })->name('monitoring-instansi');

    Route::post('/monitoring/update-stage', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'agency_type' => 'required|in:opd,instansi',
            'agency_code' => 'required|string',
            'year' => 'required|integer',
            'stage' => 'required|integer|between:1,5',
        ]);

        $stageInfo = \App\Models\MonitoringStage::getStageInfo($validated['stage']);

        $record = \App\Models\MonitoringStage::updateOrCreate(
            [
                'agency_type' => $validated['agency_type'],
                'agency_code' => $validated['agency_code'],
                'year' => $validated['year'],
            ],
            [
                'stage' => $validated['stage'],
                'status_text' => $stageInfo['label'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Tahapan berhasil diubah ke ' . $stageInfo['label'],
            'data' => $record,
            'stageInfo' => $stageInfo,
        ]);
    })->name('monitoring.update-stage');

    Route::get('/tabel-opd', [TabelOpdController::class, 'index'])->name('tabel-opd');
    Route::get('/edit-tabel-opd', [TabelOpdController::class, 'edit'])->name('edit-tabel-opd');
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
