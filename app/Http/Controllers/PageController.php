<?php

namespace App\Http\Controllers;

/**
 * Halaman "Isi Data" (OPD, Instansi Vertikal, BPS).
 * Hanya menyiapkan data katalog tabel buatan sendiri untuk ditampilkan di halaman.
 */
class PageController extends Controller
{
    /** Halaman isi data OPD */
    public function isiDataOpd()
    {
        $customTables = \App\Models\TabelMetadata::whereIn('source_type', ['custom', 'custom_opd'])
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();
        return view('dinas.isi-opd', compact('customTables'));
    }

    /** Halaman isi data Instansi Vertikal */
    public function isiDataInstansi()
    {
        $customTables = \App\Models\TabelMetadata::where(function($q) {
                $q->whereIn('source_type', ['custom_instansi', 'instansi'])
                  ->orWhere('source_type', 'like', '%instansi%');
            })
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();
        return view('dinas.isi-instansi', compact('customTables'));
    }

    /** Halaman data BPS */
    public function dataBps()
    {
        $customTables = \App\Models\TabelMetadata::where(function($q) {
                $q->whereIn('source_type', ['custom_bps', 'bps'])
                  ->orWhere('source_type', 'like', '%bps%');
            })
            ->select('table_code as code', 'opd_code', 'title_id as title', 'title_en as titleEn')
            ->distinct()
            ->get();
        return view('dinas.data-bps', compact('customTables'));
    }
}
