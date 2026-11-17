<?php

namespace App\Support;

use App\Models\MonitoringStage;
use App\Models\TabelMetadata;

/**
 * Perhitungan 3 persentase Monitoring SiBingka:
 *
 *   1. Input Data           = tabel yang sudah dikirim instansi (status submitted / verified / validated)
 *   2. Verifikasi Wali Data = tabel yang sudah diverifikasi Wali Data (status verified / validated)
 *   3. Validasi BPS         = tabel yang sudah divalidasi Admin BPS (status validated)
 *
 * Pembagi = jumlah tabel resmi milik instansi tersebut (config/sibingka_tables.php).
 * Untuk dataset BPS pembagi = jumlah tabel yang terdaftar di database.
 *
 * Alur status tabel: draft -> submitted -> verified -> validated  (revision = dikembalikan untuk diperbaiki)
 */
class MonitoringProgress
{
    /** Pecah "bps_01" / "5" / "05" menjadi kode 2 digit yang seragam. */
    public static function cleanCode(string $code): string
    {
        $code = preg_replace('/^bps_/i', '', trim($code));
        return ctype_digit($code) ? str_pad($code, 2, '0', STR_PAD_LEFT) : $code;
    }

    /** Daftar kode tabel resmi milik sebuah OPD / Instansi (dari config/sibingka_tables.php). */
    public static function catalogTables(string $type, string $code): array
    {
        $all = config('sibingka_tables.' . ($type === 'instansi' ? 'instansi' : 'opd'), []);
        $tables = $all[self::cleanCode($code)] ?? [];

        return is_array($tables) ? $tables : [];
    }

    /**
     * Muat status verifikasi semua tabel pada satu tahun.
     * Hasil: ['opd' => [kode => [kode_tabel => status]], 'bps' => [kode => [kode_tabel => status]]]
     * ('opd' dipakai bersama OPD dan Instansi; kode tabel yang membedakannya.)
     */
    public static function load(int $year): array
    {
        $map = ['opd' => [], 'bps' => []];

        $rows = TabelMetadata::where('year', $year)
            ->where('source_type', '!=', 'deleted')
            ->select('opd_code', 'table_code', 'verification_status', 'source_type')
            ->get();

        foreach ($rows as $row) {
            $bucket = str_contains((string) $row->source_type, 'bps') ? 'bps' : 'opd';
            $map[$bucket][self::cleanCode((string) $row->opd_code)][$row->table_code] = $row->verification_status ?: 'draft';
        }

        return $map;
    }

    private static function pct(int $count, int $total): int
    {
        return $total > 0 ? min(100, (int) round($count / $total * 100)) : 0;
    }

    /** Hitung jumlah dan 3 persentase untuk satu OPD / Instansi / dataset BPS. */
    public static function stats(array $map, string $type, string $code): array
    {
        $code = self::cleanCode($code);
        $rows = $map[$type === 'bps' ? 'bps' : 'opd'][$code] ?? [];
        $tables = $type === 'bps' ? array_keys($rows) : self::catalogTables($type, $code);

        $counts = ['draft' => 0, 'submitted' => 0, 'verified' => 0, 'validated' => 0, 'revision' => 0];
        foreach ($tables as $tableCode) {
            $status = $rows[$tableCode] ?? 'draft';
            $counts[isset($counts[$status]) ? $status : 'draft']++;
        }

        $total = count($tables);
        $input = $counts['submitted'] + $counts['verified'] + $counts['validated'];
        $verified = $counts['verified'] + $counts['validated'];
        $validated = $counts['validated'];

        return [
            'total' => $total,
            'input_count' => $input,
            'verified_count' => $verified,
            'validated_count' => $validated,
            'revision_count' => $counts['revision'],
            'pct_input' => self::pct($input, $total),
            'pct_verif' => self::pct($verified, $total),
            'pct_valid' => self::pct($validated, $total),
        ];
    }

    /** Jumlahkan seluruh instansi pada satu halaman untuk persentase keseluruhan. */
    public static function overall(array $agencies): array
    {
        $sum = ['total' => 0, 'input_count' => 0, 'verified_count' => 0, 'validated_count' => 0];
        foreach ($agencies as $agency) {
            foreach ($sum as $key => $value) {
                $sum[$key] += (int) ($agency[$key] ?? 0);
            }
        }

        return $sum + [
            'pct_input' => self::pct($sum['input_count'], $sum['total']),
            'pct_verif' => self::pct($sum['verified_count'], $sum['total']),
            'pct_valid' => self::pct($sum['validated_count'], $sum['total']),
        ];
    }

    /**
     * Samakan tahap di tabel monitoring_stages dengan status tabel yang sebenarnya.
     * Dipanggil setiap kali ada tabel dikirim / diverifikasi / divalidasi / dikembalikan.
     */
    public static function syncStage(string $type, string $code, int $year, ?string $note = null): void
    {
        if (!in_array($type, ['opd', 'instansi', 'bps'], true)) {
            return;
        }

        $code = self::cleanCode($code);
        $stats = self::stats(self::load($year), $type, $code);

        if ($stats['total'] > 0 && $stats['validated_count'] >= $stats['total']) {
            $stage = 3;
            $text = 'Validasi BPS Selesai';
        } elseif ($stats['verified_count'] > 0) {
            $stage = 2;
            $text = 'Terverifikasi Wali Data';
        } elseif ($stats['input_count'] > 0) {
            $stage = 2;
            $text = 'Menunggu Verifikasi Wali Data';
        } elseif ($stats['revision_count'] > 0) {
            $stage = 1;
            $text = 'Perlu Revisi';
        } else {
            $stage = 1;
            $text = 'Input Data';
        }

        MonitoringStage::updateOrCreate(
            ['agency_type' => $type, 'agency_code' => $code, 'year' => $year],
            ['stage' => $stage, 'status_text' => $text, 'notes' => $note ?? $text]
        );
    }
}
