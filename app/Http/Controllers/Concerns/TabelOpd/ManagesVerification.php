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
     * Workflow Verifikasi: Dinas mengirim data tabel (dengan pernyataan kebenaran data).
     * Setelah dikirim: Monitoring mencatat "Input Data", lalu Wali Data memverifikasi,
     * lalu Admin BPS memvalidasi.
     */
    public function apiSubmitVerification(Request $request)
    {
        $tableCode = $request->input('table_code');
        $opdCode = (string) $request->input('opd_code', '');
        $year = (int) $request->input('year', 2025);
        $type = $request->input('type', 'opd');

        // Pernyataan kebenaran data wajib dicentang sebelum data dikirim.
        if (!filter_var($request->input('declaration', $request->input('data_declared')), FILTER_VALIDATE_BOOLEAN)) {
            return response()->json([
                'success' => false,
                'message' => 'Centang pernyataan kebenaran data terlebih dahulu sebelum mengirim data.',
            ], 422);
        }

        if ($type !== 'bps' && $type !== 'instansi') {
            $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
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

        if (!$meta) {
            return response()->json([
                'success' => false,
                'message' => 'Data tabel belum tersimpan di database. Simpan data terlebih dahulu, lalu kirim.',
            ], 422);
        }

        // Tabel yang sudah diverifikasi / divalidasi tidak boleh dikirim ulang (kecuali dibuka Admin BPS).
        if (in_array($meta->verification_status, ['verified', 'validated'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Tabel ini sudah diverifikasi/divalidasi dan tidak dapat dikirim ulang.',
            ], 422);
        }

        $sender = session('user.displayName', 'Pengguna');

        $meta->verification_status = 'submitted';
        $meta->is_saved = true;
        $meta->rejection_notes = null;
        if (\Illuminate\Support\Facades\Schema::hasColumn('tabel_opd_metadata', 'data_declared')) {
            $meta->data_declared = true;
            $meta->submitted_at = now();
            $meta->submitted_by = $sender;
        }
        $meta->save();

        // Samakan Monitoring: tahap Input Data selesai -> menunggu verifikasi Wali Data
        \App\Support\MonitoringProgress::syncStage(
            $type,
            $cleanOpd,
            $year,
            'Tabel ' . $tableCode . ' dikirim oleh ' . $sender . ' dengan pernyataan kebenaran data. Menunggu verifikasi Wali Data.'
        );

        return response()->json([
            'success' => true,
            'message' => 'Data tabel berhasil dikirim. Data masuk Monitoring sebagai Input Data dan menunggu verifikasi Wali Data.',
            'status' => 'submitted',
            'submitted_by' => $sender,
            'submitted_at' => now()->translatedFormat('d F Y H:i'),
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
            $meta->fill(\App\Support\MonitoringProgress::activityFields('walidata', $userName));
            $meta->save();

            // Sinkronisasi status stage ke Monitoring: Stage 2 Terverifikasi Wali Data
            \App\Support\MonitoringProgress::syncStage($type, $cleanOpd, $year, 'Tabel ' . $tableCode . ' telah diverifikasi oleh Wali Data (' . $userName . '). Menunggu Validasi BPS.');

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
            $meta->fill(\App\Support\MonitoringProgress::activityFields('validated', $userName));
            $meta->save();

            // Sinkronisasi status stage ke Monitoring: Stage 3 Validasi BPS Selesai
            \App\Support\MonitoringProgress::syncStage($type, $cleanOpd, $year, 'Tabel ' . $tableCode . ' telah divalidasi oleh Admin BPS (' . $userName . ').');

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
        \App\Support\MonitoringProgress::syncStage($type, $cleanOpd, $year, $notes);

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
        $type = $request->input('type', 'opd');

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $meta = TabelMetadata::where('table_code', $tableCode)
            ->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
            ->where('year', $year)
            ->first();

        if ($meta) {
            $meta->is_locked = false;
            $meta->verification_status = 'draft';
            $meta->save();

            \App\Support\MonitoringProgress::syncStage($type, $cleanOpd, $year, 'Kunci tabel ' . $tableCode . ' dibuka oleh Admin BPS.');
        }

        return response()->json([
            'success' => true,
            'message' => 'Kunci tabel berhasil dibuka! Dinas dapat mengedit kembali.',
            'status' => 'draft',
            'is_locked' => false,
        ]);
    }
}
