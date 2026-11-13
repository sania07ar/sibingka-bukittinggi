<?php

use App\Http\Controllers\AuthController;
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
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/sibingka', function () {
        return view('welcome');
    })->name('sibingka');

    Route::get('/isi-data-opd', function () {
        $customTables = \App\Models\TabelMetadata::whereIn('source_type', ['custom', 'custom_opd'])
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();
        return view('dinas.isi-opd', compact('customTables'));
    })->name('isi-data-opd');

    Route::get('/isi-data-instansi', function () {
        $customTables = \App\Models\TabelMetadata::where(function($q) {
                $q->whereIn('source_type', ['custom_instansi', 'instansi'])
                  ->orWhere('source_type', 'like', '%instansi%');
            })
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();
        return view('dinas.isi-instansi', compact('customTables'));
    })->name('isi-data-instansi');

    Route::get('/data-bps', function () {
        $customTables = \App\Models\TabelMetadata::where(function($q) {
                $q->whereIn('source_type', ['custom_bps', 'bps'])
                  ->orWhere('source_type', 'like', '%bps%');
            })
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

    Route::get('/monitoring-bps', function () {
        return view('monitoring.bps');
    })->name('monitoring-bps');

    Route::post('/monitoring/update-stage', function (\Illuminate\Http\Request $request) {
        $userRole = session('user.role');
        if (!in_array($userRole, ['admin', 'walidata'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki hak akses untuk memverifikasi atau memvalidasi data monitoring.',
            ], 403);
        }

        $validated = $request->validate([
            'agency_type' => 'required|in:opd,instansi,bps',
            'agency_code' => 'required|string',
            'year' => 'required|integer',
            'stage' => 'required|integer|between:1,3',
        ]);

        $stage = (int) $validated['stage'];
        $agencyType = $validated['agency_type'];
        $rawOpd = $validated['agency_code'];
        $cleanOpd = str_pad($rawOpd, 2, '0', STR_PAD_LEFT);
        $year = (int) $validated['year'];

        $currentRecord = \App\Models\MonitoringStage::where('agency_type', $agencyType)
            ->where(function($q) use ($rawOpd, $cleanOpd) {
                $q->where('agency_code', $cleanOpd)->orWhere('agency_code', $rawOpd);
            })
            ->where('year', $year)
            ->first();

        // 1. ATURAN WALI DATA (Diskominfo):
        // Wali Data hanya bisa memverifikasi jika OPD/Instansi/BPS sudah mengirim data!
        if ($userRole === 'walidata') {
            if ($stage === 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya Administrator BPS yang berhak melakukan Validasi BPS.',
                ], 403);
            }

            // Cek apakah data dari OPD/Instansi/BPS sudah dikirim (ada tabel dengan verification_status = submitted atau verified)
            $hasSubmitted = \App\Models\TabelMetadata::where('year', $year)
                ->whereIn('opd_code', array_unique([$rawOpd, $cleanOpd]))
                ->where(function($q) {
                    $q->where('verification_status', 'submitted')
                      ->orWhere('verification_status', 'verified')
                      ->orWhere('verification_status', 'validated');
                })
                ->exists();

            $hasSubmittedStage = $currentRecord && in_array($currentRecord->status_text, ['Menunggu Verifikasi Wali Data', 'Verifikasi', 'Terverifikasi Wali Data']);

            if (!$hasSubmitted && !$hasSubmittedStage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data belum dapat diverifikasi karena dinas/instansi/BPS belum mengirim/meneruskan data ke Wali Data.',
                ], 422);
            }

            $record = \App\Models\MonitoringStage::updateOrCreate(
                [
                    'agency_type' => $agencyType,
                    'agency_code' => $cleanOpd,
                    'year' => $year,
                ],
                [
                    'stage' => 2,
                    'status_text' => 'Terverifikasi Wali Data',
                    'notes' => 'Data telah diverifikasi oleh Wali Data (' . session('user.displayName', 'Wali Data Kominfo') . ').',
                ]
            );

            // Update status tabel submitted di metadata menjadi verified
            \App\Models\TabelMetadata::where('year', $year)
                ->whereIn('opd_code', array_unique([$rawOpd, $cleanOpd]))
                ->where('verification_status', 'submitted')
                ->update([
                    'verification_status' => 'verified',
                    'verified_by' => session('user.displayName', 'Wali Data Kominfo') . ' (Wali Data)',
                    'verified_at' => now(),
                    'is_locked' => true,
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diverifikasi oleh Wali Data (Diskominfo)! Menunggu Validasi BPS.',
                'data' => $record,
            ]);
        }

        // 2. ATURAN ADMIN BPS:
        // Validasi BPS di semua monitoring admin hanya bisa divalidasi ketika Wali Data SUDAH verifikasi data!
        if ($userRole === 'admin') {
            if ($stage === 3) {
                $isVerifiedByWali = false;

                // Cek status_text di monitoring_stages
                if ($currentRecord && ($currentRecord->status_text === 'Terverifikasi Wali Data' || str_contains($currentRecord->notes ?? '', 'Wali Data'))) {
                    $isVerifiedByWali = true;
                }

                // Cek apakah ada tabel yang sudah berstatus 'verified' oleh Wali Data
                if (!$isVerifiedByWali) {
                    $hasVerifiedTable = \App\Models\TabelMetadata::where('year', $year)
                        ->whereIn('opd_code', array_unique([$rawOpd, $cleanOpd]))
                        ->where('verification_status', 'verified')
                        ->exists();

                    if ($hasVerifiedTable) {
                        $isVerifiedByWali = true;
                    }
                }

                if (!$isVerifiedByWali) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi BPS hanya dapat dilakukan ketika Wali Data sudah memverifikasi data dari dinas OPD, instansi, atau BPS.',
                    ], 422);
                }

                $record = \App\Models\MonitoringStage::updateOrCreate(
                    [
                        'agency_type' => $agencyType,
                        'agency_code' => $cleanOpd,
                        'year' => $year,
                    ],
                    [
                        'stage' => 3,
                        'status_text' => 'Validasi BPS Selesai',
                        'notes' => 'Data telah divalidasi oleh Admin BPS (' . session('user.displayName', 'Admin BPS') . ').',
                    ]
                );

                \App\Models\TabelMetadata::where('year', $year)
                    ->whereIn('opd_code', array_unique([$rawOpd, $cleanOpd]))
                    ->whereIn('verification_status', ['verified', 'submitted'])
                    ->update([
                        'verification_status' => 'validated',
                        'is_locked' => true,
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Validasi BPS berhasil disetujui (ACC Selesai)!',
                    'data' => $record,
                ]);
            } else {
                // Membatalkan Validasi BPS kembali ke Tahap 2 (Terverifikasi Wali Data)
                $record = \App\Models\MonitoringStage::updateOrCreate(
                    [
                        'agency_type' => $agencyType,
                        'agency_code' => $cleanOpd,
                        'year' => $year,
                    ],
                    [
                        'stage' => 2,
                        'status_text' => 'Terverifikasi Wali Data',
                        'notes' => 'Validasi BPS dibatalkan oleh Admin BPS. Status kembali ke Terverifikasi Wali Data.',
                    ]
                );

                \App\Models\TabelMetadata::where('year', $year)
                    ->whereIn('opd_code', array_unique([$rawOpd, $cleanOpd]))
                    ->where('verification_status', 'validated')
                    ->update([
                        'verification_status' => 'verified',
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Validasi BPS berhasil dibatalkan. Status kembali ke Terverifikasi Wali Data.',
                    'data' => $record,
                ]);
            }
        }
    })->name('monitoring.update-stage');

    Route::get('/tabel-opd', [TabelOpdController::class, 'index'])->name('tabel-opd');
    Route::get('/tabel', [TabelOpdController::class, 'index'])->name('tabel');
    Route::get('/edit-tabel-opd', [TabelOpdController::class, 'edit'])->name('edit-tabel-opd');
    Route::get('/tabel-opd/export-excel', [TabelOpdController::class, 'exportExcel'])->name('tabel-opd.export-excel');
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
