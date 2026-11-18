<?php

namespace App\Support;

use App\Models\MonitoringStage;
use App\Models\TabelMetadata;
use Illuminate\Support\Facades\Schema;

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
        $all = config('sibingka_tables.' . (in_array($type, ['instansi', 'bps'], true) ? $type : 'opd'), []);
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
        // Dataset BPS: pakai daftar tabel resmi bila ada; bila belum ada, pakai tabel yang terdaftar di database
        $tables = self::catalogTables($type, $code);
        if ($type === 'bps' && !$tables) {
            $tables = array_keys($rows);
        }

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

    // ------------------------------------------------------------------ riwayat aktivitas

    /** Apakah kolom waktu aktivitas (migrasi 2026_11_17) sudah ada di database? */
    public static function hasActivityColumns(): bool
    {
        static $exists = null;
        if ($exists === null) {
            try {
                $exists = Schema::hasColumn('tabel_opd_metadata', 'validated_at');
            } catch (\Throwable $e) {
                $exists = false;
            }
        }

        return $exists;
    }

    /**
     * Kolom waktu/pelaku yang diisi saat sebuah tahap selesai.
     * $stage: 'walidata' (verifikasi), 'validated' (validasi BPS), 'unvalidate' (validasi dibatalkan).
     * Mengembalikan [] bila migrasi belum dijalankan, supaya penyimpanan tetap aman.
     */
    public static function activityFields(string $stage, ?string $actor = null): array
    {
        if (!self::hasActivityColumns()) {
            return [];
        }

        return match ($stage) {
            'walidata' => ['walidata_verified_at' => now(), 'walidata_verified_by' => $actor],
            'validated' => ['validated_at' => now(), 'validated_by' => $actor],
            'unvalidate' => ['validated_at' => null, 'validated_by' => null],
            default => [],
        };
    }

    private static function formatMoment($moment): array
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $carbon = \Illuminate\Support\Carbon::parse($moment);

        return [
            'date' => $carbon->format('j') . ' ' . $months[(int) $carbon->format('n') - 1] . ' ' . $carbon->format('Y'),
            'time' => $carbon->format('H:i'),
            'sort' => $carbon->getTimestamp(),
        ];
    }

    /** Muat semua kejadian (kirim, verifikasi, validasi) pada satu tahun. */
    public static function loadActivities(int $year): array
    {
        $columns = ['opd_code', 'table_code', 'title_id', 'source_type', 'verification_status',
            'submitted_at', 'submitted_by', 'verified_at', 'verified_by'];
        if (self::hasActivityColumns()) {
            array_push($columns, 'walidata_verified_at', 'walidata_verified_by', 'validated_at', 'validated_by');
        }

        $rows = TabelMetadata::where('year', $year)
            ->where('source_type', '!=', 'deleted')
            ->whereIn('verification_status', ['submitted', 'verified', 'validated'])
            ->get($columns);

        $map = ['opd' => [], 'bps' => []];
        foreach ($rows as $row) {
            $bucket = str_contains((string) $row->source_type, 'bps') ? 'bps' : 'opd';
            $code = self::cleanCode((string) $row->opd_code);
            $title = trim((string) $row->title_id);
            $base = ['table_code' => $row->table_code, 'title' => $title];

            $events = [];
            if ($row->submitted_at) {
                $events[] = $base + ['kind' => 'kirim', 'at' => $row->submitted_at, 'actor' => $row->submitted_by];
            }

            // Verifikasi Wali Data (data lama: memakai verified_at bila kolom baru belum terisi)
            $walidataAt = $row->walidata_verified_at ?? (in_array($row->verification_status, ['verified'], true) ? $row->verified_at : null);
            if ($walidataAt) {
                $actor = $row->walidata_verified_by ?? preg_replace('/\s*&.*$/', '', (string) $row->verified_by);
                $events[] = $base + ['kind' => 'verifikasi', 'at' => $walidataAt, 'actor' => $actor];
            }

            // Validasi Admin BPS
            $validatedAt = $row->validated_at ?? ($row->verification_status === 'validated' ? $row->verified_at : null);
            if ($validatedAt) {
                $actor = $row->validated_by;
                if (!$actor && str_contains((string) $row->verified_by, '&')) {
                    $actor = trim(substr((string) $row->verified_by, strrpos((string) $row->verified_by, '&') + 1));
                }
                $events[] = $base + ['kind' => 'validasi', 'at' => $validatedAt, 'actor' => $actor];
            }

            foreach ($events as $event) {
                $map[$bucket][$code][] = $event;
            }
        }

        return $map;
    }

    /** Daftar aktivitas satu instansi (terbaru di atas), siap dipakai halaman Monitoring. */
    public static function activitiesFor(array $activityMap, string $type, string $code, int $limit = 40): array
    {
        $code = self::cleanCode($code);
        $events = $activityMap[$type === 'bps' ? 'bps' : 'opd'][$code] ?? [];

        $official = self::catalogTables($type, $code);
        if ($official) {
            $events = array_values(array_filter($events, fn ($e) => in_array($e['table_code'], $official, true)));
        }

        $result = [];
        foreach ($events as $event) {
            $moment = self::formatMoment($event['at']);
            $result[] = [
                'kind' => $event['kind'],
                'table_code' => $event['table_code'],
                'title' => $event['title'],
                'actor' => $event['actor'] ?: '-',
                'date' => $moment['date'],
                'time' => $moment['time'],
                'sort' => $moment['sort'],
            ];
        }

        usort($result, fn ($a, $b) => $b['sort'] <=> $a['sort']);

        return array_slice($result, 0, $limit);
    }
}
