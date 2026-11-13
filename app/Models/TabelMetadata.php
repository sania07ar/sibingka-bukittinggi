<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelMetadata extends Model
{
    use HasFactory;

    protected $table = 'tabel_opd_metadata';

    protected $fillable = [
        'table_code',
        'opd_code',
        'year',
        'title_id',
        'title_en',
        'source',
        'note',
        'table_html',
        'source_type',
        'is_saved',
        'verification_status',
        'verified_at',
        'verified_by',
        'rejection_notes',
        'is_locked',
    ];

    protected $casts = [
        'is_saved' => 'boolean',
        'is_locked' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Evaluasi status keterisian angka data riil untuk suatu tabel.
     * Kriteria deteksi:
     * - 'lengkap': seluruh sel data angka terisi bilangan riil valid (100%)
     * - 'proses' (Belum Lengkap): sebagian sel terisi angka riil, sebagian masih strip '-' / kosong (1% s.d. 99%)
     * - 'belum' (Belum Berisi): tidak ada satupun sel data yang terisi angka (hanya memuat label teks seperti nama kecamatan dengan nilai '-' / kosong) (0%)
     */
    public static function evaluateNumericStatus(?string $tableHtml, int $numericCountTabelData = 0): array
    {
        $numericCells = 0;
        $emptyCells = 0;

        if (!empty($tableHtml)) {
            // Ambil konten tbody (atau seluruh html jika tidak ada tbody eksplisit)
            if (preg_match('/<tbody[^>]*>(.*?)<\/tbody>/is', $tableHtml, $tbodyMatch)) {
                $bodyContent = $tbodyMatch[1];
            } else {
                $bodyContent = $tableHtml;
            }

            // Ekstrak setiap baris <tr>
            preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $bodyContent, $trMatches);

            foreach ($trMatches[1] as $tr) {
                // Ekstrak semua sel <td> dalam baris ini
                preg_match_all('/<td[^>]*>(.*?)<\/td>/is', $tr, $tdMatches);
                $tds = $tdMatches[1];
                if (empty($tds)) continue;

                // Pada struktur tabel statistik SiBingka:
                // Kolom index 0 biasanya adalah nama indikator/kecamatan/kategori (label baris).
                // Kolom index >= 1 adalah sel data angka.
                // Jika hanya ada 1 kolom, maka kolom tersebut diperiksa.
                $startIndex = (count($tds) > 1) ? 1 : 0;

                for ($i = $startIndex; $i < count($tds); $i++) {
                    $rawText = strip_tags($tds[$i]);
                    // Bersihkan entitas HTML & spasi tak terlihat
                    $text = html_entity_decode($rawText);
                    $text = trim(str_replace(["\xc2\xa0", '&nbsp;', "\r", "\n", "\t"], ' ', $text));

                    // Periksa apakah sel berupa tanda strip / strip panjang / titik-titik / kosong
                    if ($text === '' || $text === '-' || $text === '–' || $text === '—' || $text === '...' || $text === 'null') {
                        $emptyCells++;
                    } elseif (preg_match('/\d/', $text)) {
                        // Memuat digit angka (misal "17", "38.460", "11,75", "100%", "0", "0,00")
                        $numericCells++;
                    } else {
                        // Teks non-angka lain diperlakukan sebagai sel yang belum diisi data kuantitatif
                        $emptyCells++;
                    }
                }
            }
        }

        // Jika dari HTML tidak ditemukan sel tapi ada data angka di tabel_opd_data
        if ($numericCells === 0 && $numericCountTabelData > 0) {
            $numericCells = $numericCountTabelData;
        }

        $totalCells = $numericCells + $emptyCells;

        if ($totalCells === 0) {
            if ($numericCountTabelData > 0) {
                return [
                    'status' => 'lengkap',
                    'status_label' => 'Lengkap',
                    'numeric_cells' => $numericCountTabelData,
                    'empty_cells' => 0,
                    'total_cells' => $numericCountTabelData,
                    'pct' => 100,
                ];
            }
            return [
                'status' => 'belum',
                'status_label' => 'Belum Diisi',
                'numeric_cells' => 0,
                'empty_cells' => 0,
                'total_cells' => 0,
                'pct' => 0,
            ];
        }

        if ($numericCells === 0) {
            $status = 'belum';
            $statusLabel = 'Belum Diisi';
            $pct = 0;
        } elseif ($emptyCells === 0 || $numericCells >= $totalCells) {
            $status = 'lengkap';
            $statusLabel = 'Lengkap';
            $pct = 100;
        } else {
            $status = 'proses';
            $statusLabel = 'Belum Lengkap';
            $pct = max(1, min(99, (int) round(($numericCells / $totalCells) * 100)));
        }

        return [
            'status' => $status,
            'status_label' => $statusLabel,
            'numeric_cells' => $numericCells,
            'empty_cells' => $emptyCells,
            'total_cells' => $totalCells,
            'pct' => $pct,
        ];
    }

    /**
     * Helper instance untuk evaluasi keterisian angka data
     */
    public function getNumericStatus(int $numericCountTabelData = 0): array
    {
        return self::evaluateNumericStatus($this->table_html, $numericCountTabelData);
    }
}
