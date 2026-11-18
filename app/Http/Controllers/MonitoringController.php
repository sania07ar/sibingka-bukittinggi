<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Monitoring: Wali Data memverifikasi, Admin BPS memvalidasi (tahap 1-3).
 */
class MonitoringController extends Controller
{
    /**
     * Ubah tahap monitoring (verifikasi Wali Data / validasi BPS).
     * Dipanggil dari tombol di halaman monitoring (POST /monitoring/update-stage).
     */
    public function updateStage(Request $request)
    {
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
                ] + \App\Support\MonitoringProgress::activityFields('walidata', session('user.displayName', 'Wali Data Kominfo')));

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
                    ] + \App\Support\MonitoringProgress::activityFields('validated', session('user.displayName', 'Admin BPS Bukittinggi')));

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
                    ] + \App\Support\MonitoringProgress::activityFields('unvalidate'));

                return response()->json([
                    'success' => true,
                    'message' => 'Validasi BPS berhasil dibatalkan. Status kembali ke Terverifikasi Wali Data.',
                    'data' => $record,
                ]);
            }
        }
    }
}
