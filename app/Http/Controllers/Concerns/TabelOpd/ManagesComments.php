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
 * Komentar / catatan pada tabel.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait ManagesComments
{
    /**
     * API GET: Ambil daftar catatan / komentar rincian data tabel
     */
    public function apiGetComments(Request $request)
    {
        $tableCode = $request->query('table_code');
        $opdCode = $request->query('opd_code');
        $year = (int) $request->query('year');

        $query = TabelComment::query();

        if ($tableCode) {
            $query->where('table_code', $tableCode);
        }
        if ($opdCode) {
            $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            $query->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
        }
        if ($year) {
            $query->where('year', $year);
        }

        $comments = $query->orderBy('created_at', 'asc')->get();
        $grouped = $comments->groupBy('cell_key');

        return response()->json([
            'status' => 'success',
            'comments' => $comments,
            'grouped' => $grouped,
            'count' => $comments->count(),
        ]);
    }

    /**
     * API POST: Tambah catatan / komentar baru pada rincian data tertentu
     */
    public function apiSaveComment(Request $request)
    {
        $request->validate([
            'table_code' => 'required|string',
            'opd_code' => 'required|string',
            'year' => 'required|integer',
            'cell_key' => 'required|string',
            'comment' => 'required|string|max:2000',
        ]);

        $userRole = session('user.role', 'opd');
        $displayName = session('user.displayName') ?? session('user.name') ?? null;
        $dinasName = session('user.dinas_name') ?? null;

        // Tentukan identitas pengirim secara jelas dan informatif
        if ($userRole === 'admin') {
            $userName = $displayName ?: 'Administrator BPS Bukittinggi';
        } elseif ($userRole === 'walidata') {
            $userName = $displayName ?: 'Wali Data (Diskominfo Bukittinggi)';
        } elseif ($userRole === 'instansi') {
            if ($displayName && $dinasName && $displayName !== $dinasName) {
                $userName = "{$displayName} ({$dinasName})";
            } else {
                $userName = $dinasName ?: $displayName ?: 'Instansi Vertikal';
            }
        } else {
            // OPD / Dinas
            if ($displayName && $dinasName && $displayName !== $dinasName) {
                $userName = "{$displayName} ({$dinasName})";
            } else {
                $userName = $dinasName ?: $displayName ?: 'Dinas OPD';
            }
        }

        // Batasi panjang untuk keamanan kolom DB (maksimal 95 karakter)
        $userName = mb_substr($userName, 0, 95);

        $comment = TabelComment::create([
            'table_code' => $request->table_code,
            'opd_code' => $request->opd_code,
            'year' => (int) $request->year,
            'cell_key' => $request->cell_key,
            'cell_label' => $request->cell_label ?? $request->cell_key,
            'cell_value' => $request->cell_value,
            'user_name' => $userName,
            'user_role' => $userRole,
            'comment' => trim($request->comment),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Catatan berhasil ditambahkan.',
            'data' => $comment,
        ]);
    }

    /**
     * API DELETE: Hapus catatan
     */
    public function apiDeleteComment($id)
    {
        $comment = TabelComment::find($id);
        if (!$comment) {
            return response()->json(['status' => 'error', 'message' => 'Catatan tidak ditemukan.'], 404);
        }

        $userRole = session('user.role', 'opd');
        $displayName = session('user.displayName') ?? session('user.name') ?? '';

        // Admin & Wali Data dapat menghapus semua catatan, pengguna lain hanya bisa menghapus catatan miliknya
        $canDelete = ($userRole === 'admin' || $userRole === 'walidata' || ($displayName && str_contains($comment->user_name, $displayName)));
        if (!$canDelete) {
            return response()->json(['status' => 'error', 'message' => 'Anda tidak memiliki hak untuk menghapus catatan ini.'], 403);
        }

        $comment->delete();
        return response()->json(['status' => 'success', 'message' => 'Catatan berhasil dihapus.']);
    }
}
