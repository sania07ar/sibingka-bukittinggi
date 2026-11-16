<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

use App\Models\TabelData;
use App\Models\TabelMetadata;
use App\Models\TabelComment;
use App\Exports\TableOpdExport;
use App\Imports\TableOpdImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

/**
 * Alur kirim, verifikasi, tolak, dan buka kunci tabel.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait ManagesVerification
{
    /**
     * Workflow Verifikasi: Dinas Mengajukan Data Tabel ke BPS
     */
    public function apiSubmitVerification(Request $request)
    {
        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $year = (int) $request->input('year', 2025);
        $type = $request->input('type', 'opd');

        if ($type !== 'bps' && $type !== 'instansi') {
            $opdCode = $this->normalizeOpdCode($tableCode, $opdCode ?: '');
        }

        $existingMetaQuery = TabelMetadata::where('table_code', $tableCode)->where('year', $year);
        if ($type === 'bps') {
            $existingMetaQuery->where('source_type', 'like', '%bps%');
        } elseif ($type === 'instansi') {
            $existingMetaQuery->where('source_type', 'like', '%instansi%');
        }
        $existingMeta = $existingMetaQuery->first();
        if ($existingMeta && !empty($existingMeta->opd_code)) {
            $opdCode = $existingMeta->opd_code;
        }

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = $existingMeta ?: $this->getOrCreateMetadata($tableCode, $opdCode, $year, $type);

        if ($meta) {
            $meta->verification_status = 'submitted';
            $meta->is_saved = true;
            $meta->rejection_notes = null;
            $meta->save();
        }

        // Sinkronisasi otomatis ke Tahap 2 (Verifikasi oleh Wali Data Kominfo) di Monitoring
        if (in_array($type, ['opd', 'instansi', 'bps'])) {
            \App\Models\MonitoringStage::updateOrCreate(
                [
                    'agency_type' => $type,
                    'agency_code' => $cleanOpd,
                    'year' => $year,
                ],
                [
                    'stage' => 2,
                    'status_text' => 'Menunggu Verifikasi Wali Data',
                    'notes' => 'Tabel ' . $tableCode . ' diajukan/diteruskan oleh instansi untuk diverifikasi oleh Wali Data Kominfo.',
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Data tabel berhasil dikirim/diteruskan ke Wali Data (Diskominfo) untuk diverifikasi.',
            'status' => 'submitted',
        ]);
    }

    /**
     * Workflow Verifikasi: Wali Data (Kominfo) Memverifikasi atau Admin BPS Memvalidasi (ACC) Data Tabel
     */
    public function apiApproveVerification(Request $request)
    {
        $userRole = session('user.role');
        if (!in_array($userRole, ['admin', 'walidata'])) {
            return response()->json(['success' => false, 'message' => 'Hanya Wali Data (Diskominfo) atau Admin BPS yang berhak melakukan verifikasi / validasi data tabel.'], 403);
        }

        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $year = (int) $request->input('year', 2025);
        $type = $request->input('type', 'opd');

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->where('year', $year)
            ->first();

        if (!$meta) {
            $meta = $this->getOrCreateMetadata($tableCode, $opdCode, $year, $type);
        }

        // Syarat 1: Jika yang verifikasi adalah Wali Data, produsen data (OPD/Instansi/BPS) harus SUDAH mengirim data (submitted)
        if ($userRole === 'walidata') {
            if ($meta->verification_status !== 'submitted') {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tabel belum dapat diverifikasi karena dinas OPD/instansi/BPS belum mengirim/meneruskan data ke Wali Data.'
                ], 422);
            }

            $userName = session('user.displayName', 'Wali Data Kominfo');
            $verifiedSignature = $userName . ' (Wali Data)';

            $meta->verification_status = 'verified';
            $meta->is_locked = true;
            $meta->verified_at = now();
            $meta->verified_by = $verifiedSignature;
            $meta->rejection_notes = null;
            $meta->save();

            // Sinkronisasi status stage ke Monitoring: Stage 2 Terverifikasi Wali Data
            if (in_array($type, ['opd', 'instansi', 'bps'])) {
                \App\Models\MonitoringStage::updateOrCreate(
                    [
                        'agency_type' => $type,
                        'agency_code' => $cleanOpd,
                        'year' => $year,
                    ],
                    [
                        'stage' => 2,
                        'status_text' => 'Terverifikasi Wali Data',
                        'notes' => 'Tabel ' . $tableCode . ' telah diverifikasi oleh Wali Data (' . $userName . '). Menunggu Validasi BPS.',
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Data tabel berhasil diverifikasi oleh Wali Data (Diskominfo)! Menunggu Validasi BPS.',
                'status' => 'verified',
                'verified_by' => $verifiedSignature,
                'verified_at' => now()->translatedFormat('d F Y H:i'),
            ]);
        }

        // Syarat 2: Jika yang validasi adalah Admin BPS, data HARUS SUDAH diverifikasi oleh Wali Data!
        if ($userRole === 'admin') {
            if ($meta->verification_status !== 'verified') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi BPS hanya dapat dilakukan ketika Wali Data sudah memverifikasi data dari dinas OPD, instansi, atau BPS.'
                ], 422);
            }

            $userName = session('user.displayName', 'Admin BPS Bukittinggi');
            $validatedSignature = $userName . ' (Admin BPS)';

            $meta->verification_status = 'validated';
            $meta->is_locked = true;
            $meta->verified_at = now();
            $meta->verified_by = ($meta->verified_by ? $meta->verified_by . ' & ' : '') . $validatedSignature;
            $meta->rejection_notes = null;
            $meta->save();

            // Sinkronisasi status stage ke Monitoring: Stage 3 Validasi BPS Selesai
            if (in_array($type, ['opd', 'instansi', 'bps'])) {
                \App\Models\MonitoringStage::updateOrCreate(
                    [
                        'agency_type' => $type,
                        'agency_code' => $cleanOpd,
                        'year' => $year,
                    ],
                    [
                        'stage' => 3,
                        'status_text' => 'Validasi BPS Selesai',
                        'notes' => 'Tabel ' . $tableCode . ' telah divalidasi oleh Admin BPS (' . $userName . ').',
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Data tabel berhasil divalidasi oleh Admin BPS (ACC Final Selesai)!',
                'status' => 'validated',
                'verified_by' => $meta->verified_by,
                'verified_at' => now()->translatedFormat('d F Y H:i'),
            ]);
        }
    }

    /**
     * Workflow Verifikasi: Wali Data (Kominfo) atau Admin BPS Meminta Revisi
     */
    public function apiRejectVerification(Request $request)
    {
        $userRole = session('user.role');
        if (!in_array($userRole, ['admin', 'walidata'])) {
            return response()->json(['success' => false, 'message' => 'Hanya Wali Data (Diskominfo) atau Admin BPS yang berhak meminta revisi data tabel.'], 403);
        }

        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $year = (int) $request->input('year', 2025);
        $type = $request->input('type', 'opd');
        $notes = $request->input('notes', 'Mohon periksa kembali kelengkapan dan kewajaran data.');

        if ($type !== 'bps' && $type !== 'instansi') {
            $opdCode = $this->normalizeOpdCode($tableCode, $opdCode ?: '');
        }

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->where('year', $year)
            ->first();

        if ($meta) {
            $meta->verification_status = 'revision';
            $meta->is_locked = false;
            $meta->rejection_notes = $notes;
            $meta->save();
        }

        // Sinkronisasi otomatis ke Tahap 1 (Input Data / Perlu Revisi) di Monitoring
        if (in_array($type, ['opd', 'instansi', 'bps'])) {
            \App\Models\MonitoringStage::updateOrCreate(
                [
                    'agency_type' => $type,
                    'agency_code' => $cleanOpd,
                    'year' => $year,
                ],
                [
                    'stage' => 1,
                    'status_text' => 'Perlu Revisi',
                    'notes' => $notes,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Catatan revisi berhasil dikirim ke dinas pengisi data!',
            'status' => 'revision',
        ]);
    }

    /**
     * Workflow Verifikasi: Buka Kunci (Unlock) Tabel
     */
    public function apiUnlockTable(Request $request)
    {
        $userRole = session('user.role');
        if (!in_array($userRole, ['admin', 'walidata'])) {
            return response()->json(['success' => false, 'message' => 'Hanya Wali Data atau Admin BPS yang berhak membuka kunci tabel.'], 403);
        }
        if (session('user.role') !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya Admin BPS yang berhak membuka kunci tabel.'], 403);
        }

        $tableCode = $request->input('table_code');
        $opdCode = $request->input('opd_code');
        $year = (int) $request->input('year', 2025);

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->where('year', $year)
            ->first();

        if ($meta) {
            $meta->is_locked = false;
            $meta->verification_status = 'draft';
            $meta->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Kunci tabel berhasil dibuka! Dinas dapat mengedit kembali.',
            'status' => 'draft',
            'is_locked' => false,
        ]);
    }
}
