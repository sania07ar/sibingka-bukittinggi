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
 * Pembuatan metadata tabel dan pemuatan data tersimpan dari database.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait ManagesTableMetadata
{
    /**
     * Ambil metadata tabel dari database, atau generate template kosong (dengan nilai '-') dan simpan langsung ke database
     */
    private function getOrCreateMetadata(string $tableCode, string $opdCode, int $year, string $type = 'opd'): ?TabelMetadata
    {
        if ($tableCode === '1.18') {
            $tableCode = '1.1.8';
        }

        if ($type !== 'bps' && $type !== 'instansi') {
            $opdCode = $this->normalizeOpdCode($tableCode, $opdCode);
        }

        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
        $metaQuery = TabelMetadata::where('table_code', $tableCode)
            ->where('year', $year);

        if ($type === 'bps') {
            $metaQuery->where(function($q) use ($opdCode, $cleanOpd) {
                $q->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
                  ->orWhere('source_type', 'like', '%bps%');
            });
        } elseif ($type === 'instansi') {
            $metaQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
        } else {
            $metaQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
        }
        $dbMetadata = $metaQuery->first();

        $definitiveOpd = ($type !== 'bps' && $type !== 'instansi') ? $this->normalizeOpdCode($tableCode, '') : '';
        if (!$dbMetadata) {
            if (!empty($definitiveOpd)) {
                $dbMetadata = TabelMetadata::where('table_code', $tableCode)
                    ->where('year', $year)
                    ->first();
                if ($dbMetadata) {
                    $dbMetadata->opd_code = $definitiveOpd;
                }
            } elseif ($type !== 'instansi') {
                $existingOpdQuery = TabelMetadata::where('table_code', $tableCode)
                    ->whereNotNull('table_html');
                if ($type === 'bps') {
                    $existingOpdQuery->where('source_type', 'like', '%bps%');
                }
                $existingOpd = $existingOpdQuery->value('opd_code');
                if ($existingOpd && $existingOpd !== $opdCode) {
                    $opdCode = $existingOpd;
                    $dbMetadata = TabelMetadata::where('table_code', $tableCode)
                        ->where('opd_code', $opdCode)
                        ->where('year', $year)
                        ->first();
                }
            }
        }

        if ($dbMetadata && !empty($definitiveOpd)) {
            $dbMetadata->opd_code = $definitiveOpd;
        }

        // Cek file-based snapshot storage hanya jika di database belum ada metadata / table_html
        if (!$dbMetadata || empty($dbMetadata->table_html) || str_contains($dbMetadata->table_html, 'Indicator Details')) {
            $scopedCacheFile = storage_path("app/tables/table_{$type}_{$cleanOpd}_{$tableCode}_{$year}.json");
            $legacyCacheFile = storage_path("app/tables/table_{$tableCode}_{$year}.json");
            $cacheFile = file_exists($scopedCacheFile) ? $scopedCacheFile : $legacyCacheFile;
            if (file_exists($cacheFile)) {
                $cachedData = json_decode(@file_get_contents($cacheFile), true);
                $isMatchingOpd = ($cacheFile === $scopedCacheFile) || 
                                 ($type !== 'instansi' && (!empty($cachedData['opd_code']) && in_array($cachedData['opd_code'], array_unique([$opdCode, $cleanOpd]))));
                if ($isMatchingOpd && is_array($cachedData) && !empty($cachedData['table_html'])) {
                    if (!$dbMetadata) {
                        $dbMetadata = new TabelMetadata();
                        $dbMetadata->table_code = $tableCode;
                        $dbMetadata->opd_code = $cachedData['opd_code'] ?? $opdCode;
                        $dbMetadata->year = $year;
                    }
                    $dbMetadata->table_html = $cachedData['table_html'];
                    if (!empty($cachedData['title_id'])) $dbMetadata->title_id = $cachedData['title_id'];
                    if (!empty($cachedData['title_en'])) $dbMetadata->title_en = $cachedData['title_en'];
                    if (!empty($cachedData['source'])) $dbMetadata->source = $cachedData['source'];
                    if (isset($cachedData['note'])) $dbMetadata->note = $cachedData['note'];
                    if (!empty($cachedData['source_type'])) $dbMetadata->source_type = $cachedData['source_type'];
                    $dbMetadata->is_saved = true;
                }
            }
        }

        // Khusus tabel 4.1.2 (Kemenag - Raudatul Athfal): Hanya 2 tahun ajaran (Sekolah, Guru, Murid berstatus swasta)
        if ($tableCode === '4.1.2') {
            $expectedY1 = ($year - 1) . '/' . ($year);
            $expectedY2 = ($year) . '/' . ($year + 1);
            $expectedTitleEnd = "{$expectedY1} dan {$expectedY2}";

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsUpdate = false;
                $html = $dbMetadata->table_html;

                if (preg_match('/\b\d{4}\s*\/\s*\d{4}\b/', $html)) {
                    $idx = 0;
                    $newHtml = preg_replace_callback('/\b\d{4}\s*\/\s*\d{4}\b/', function($matches) use (&$idx, $expectedY1, $expectedY2) {
                        $col = $idx % 2;
                        $idx++;
                        return ($col === 0) ? $expectedY1 : $expectedY2;
                    }, $html);

                    if ($newHtml !== $html) {
                        $html = $newHtml;
                        $needsUpdate = true;
                    }
                }

                if (!empty($dbMetadata->title_id) && !str_ends_with(trim($dbMetadata->title_id), $expectedTitleEnd)) {
                    $dbMetadata->title_id = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_id);
                    $needsUpdate = true;
                }
                if (!empty($dbMetadata->title_en) && !str_ends_with(trim($dbMetadata->title_en), $expectedTitleEnd)) {
                    $dbMetadata->title_en = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedY1} and {$expectedY2}", $dbMetadata->title_en);
                    $needsUpdate = true;
                }

                if ($needsUpdate) {
                    $dbMetadata->table_html = $html;
                    $dbMetadata->save();
                }
            }
        }

        // Khusus tabel Perguruan Tinggi (4.1.18 & 4.1.19): Multi-tahun
        if (in_array($tableCode, ['4.1.18', '4.1.19'])) {
            $span = ($opdCode === '07' && in_array($tableCode, ['4.1.18', '4.1.19'])) ? 2 : 4;
            $expectedRange = ($year - $span) . '–' . $year;

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsUpdate = false;
                $html = $dbMetadata->table_html;

                // Bersihkan baris hantu (duplikasi header / nomor kolom) dari <tbody>
                $cleanedHtml = preg_replace_callback('/<tbody([^>]*)>(.*?)<\/tbody>/is', function($tb) {
                    $inner = preg_replace_callback('/<tr[^>]*>(.*?)<\/tr>/is', function($trM) {
                        if (preg_match('/<td[^>]*>(.*?)<\/td>/is', $trM[1], $firstTd)) {
                            $txt = trim(strip_tags($firstTd[1]));
                            if (str_contains($txt, 'Perguruan Tinggi') || str_contains($txt, 'College') || $txt === '-1' || $txt === '(1)' || preg_match('/^-1\b/', $txt)) {
                                return '';
                            }
                            if (!preg_match('/^(?:19|20)\d{2}$/', $txt) && !preg_match('/(?:Jumlah|Total|Rata-rata|Average|BUKITTINGGI)/i', $txt)) {
                                return '';
                            }
                        }
                        return $trM[0];
                    }, $tb[2]);
                    return "<tbody{$tb[1]}>{$inner}</tbody>";
                }, $html);

                if ($cleanedHtml !== $html) {
                    $html = $cleanedHtml;
                    $needsUpdate = true;
                }

                // Deteksi rentang tahun aktual dari baris yang ada di HTML
                if (preg_match_all('/<tr[^>]*>\s*<td[^>]*>\s*((?:19|20)\d{2})\s*<\/td>/i', $html, $yearMatches)) {
                    $foundYears = array_map('intval', $yearMatches[1]);
                    if (!empty($foundYears)) {
                        $minY = min($foundYears);
                        $maxY = max($foundYears);
                        if ($minY !== $maxY) {
                            $expectedRange = "{$minY}–{$maxY}";
                        }
                    }
                }

                // Perbaiki rentang tahun di judul jika masih berupa format pecahan tahun ajaran (misal 2021/2022) atau rentang yang keliru
                if (!empty($dbMetadata->title_id) && !str_ends_with(trim($dbMetadata->title_id), $expectedRange)) {
                    $dbMetadata->title_id = preg_replace('/([,\s]+)(?:19|20)\d{2}(?:\s*[\/–\-]\s*(?:19|20)\d{2})?.*$/i', ", {$expectedRange}", $dbMetadata->title_id);
                    $needsUpdate = true;
                }
                if (!empty($dbMetadata->title_en) && !str_ends_with(trim($dbMetadata->title_en), $expectedRange)) {
                    $dbMetadata->title_en = preg_replace('/([,\s]+)(?:19|20)\d{2}(?:\s*[\/–\-]\s*(?:19|20)\d{2})?.*$/i', ", {$expectedRange}", $dbMetadata->title_en);
                    $needsUpdate = true;
                }

                if ($needsUpdate) {
                    $dbMetadata->table_html = $html;
                    $dbMetadata->save();
                }
            }
        }

        // Khusus tabel-tabel sekolah (Dinas Pendidikan - 4.1.1, 4.1.3 s.d. 4.1.17):
        // Di SiBingka, tahun ajaran terkininya adalah Tahun + 1 (misal tahun 2025 memuat 2023/2024, 2024/2025, 2025/2026 dengan judul berakhiran 2025/2026)
        // Col 1: (year-2)/(year-1), Col 2: (year-1)/year, Col 3: year/(year+1), Judul: year/(year+1)
        $schoolCodes = ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'];
        if (in_array($tableCode, $schoolCodes)) {
            $expectedY1 = ($year - 3) . '/' . ($year - 2);
            $expectedY2 = ($year - 2) . '/' . ($year - 1);
            $expectedY3 = ($year - 1) . '/' . ($year);
            $expectedTitleEnd = ($year - 1) . '/' . ($year);

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsUpdate = false;
                $html = $dbMetadata->table_html;

                // Perbaiki struktur subheader 3-in-1 (Guru & Murid) jika rusak akibat impor / template lama
                $hasBrokenSubheader = !str_contains($html, 'subtable-header-numbering') || 
                                      !str_contains($html, 'colspan="6"') || 
                                      str_contains($html, 'GuruTeachers') || 
                                      str_contains($html, 'MuridStudents') || 
                                      str_contains($html, 'row_5_col_1') ||
                                      str_contains($html, 'row_5_col_2');

                if ($hasBrokenSubheader) {
                    $html = $this->build3in1EducationHtml($year, $html);
                    $needsUpdate = true;
                } elseif (preg_match('/\b\d{4}\s*\/\s*\d{4}\b/', $html)) {
                    // Rapikan thead/header tahun ajaran berulang (Negeri, Swasta, Total) dengan urutan Y1, Y2, Y3
                    $idx = 0;
                    $newHtml = preg_replace_callback('/\b\d{4}\s*\/\s*\d{4}\b/', function($matches) use (&$idx, $expectedY1, $expectedY2, $expectedY3) {
                        $col = $idx % 3;
                        $idx++;
                        if ($col === 0) return $expectedY1;
                        if ($col === 1) return $expectedY2;
                        return $expectedY3;
                    }, $html);

                    if ($newHtml !== $html) {
                        $html = $newHtml;
                        $needsUpdate = true;
                    }
                }

                // Cek judul
                if (!empty($dbMetadata->title_id) && !str_ends_with(trim($dbMetadata->title_id), $expectedTitleEnd)) {
                    $dbMetadata->title_id = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_id);
                    if (!str_contains($dbMetadata->title_id, $expectedTitleEnd)) {
                        $dbMetadata->title_id = preg_replace('/(,\s*|\s+)\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_id);
                    }
                    $needsUpdate = true;
                }

                if (!empty($dbMetadata->title_en) && !str_ends_with(trim($dbMetadata->title_en), $expectedTitleEnd)) {
                    $dbMetadata->title_en = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_en);
                    if (!str_contains($dbMetadata->title_en, $expectedTitleEnd)) {
                        $dbMetadata->title_en = preg_replace('/(,\s*|\s+)\d{4}.*$/i', ", {$expectedTitleEnd}", $dbMetadata->title_en);
                    }
                    $needsUpdate = true;
                }

                if ($needsUpdate) {
                    $dbMetadata->table_html = $html;
                    $dbMetadata->save();
                }

                return $dbMetadata;
            }
        }

        // Khusus tabel 4.1.21 (UPT Perpustakaan Proklamator Bung Hatta), perbaiki header 'Kolom 10' menjadi 'Lain-lain' / 'Others'
        if ($tableCode === '4.1.21' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if (str_contains($dbMetadata->table_html, 'Kolom 10')) {
                $dbMetadata->table_html = preg_replace('/<th([^>]*)colspan="2"([^>]*)>\s*(?:<div>)?\s*Kolom\s*10\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div></th>', $dbMetadata->table_html);
                $dbMetadata->table_html = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*10\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div></th>', $dbMetadata->table_html);
                $dbMetadata->table_html = str_replace(['<div>Kolom 10</div>', 'Kolom 10'], ['<div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div>', 'Lain-lain'], $dbMetadata->table_html);
                $dbMetadata->save();
            }
        }

        // Khusus tabel 4.1.23 (Penggolongan Koleksi Buku), perbaiki header 'Kolom 2' menjadi 'Bulan / Month' dan '0'
        if ($tableCode === '4.1.23' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if (str_contains($dbMetadata->table_html, 'Kolom 2')) {
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)colspan="2"([^>]*)>\s*(?:<div>)?\s*Kolom\s*2\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div></th>' . "\n" . '        <th class="py-3 px-4 font-bold border border-slate-700"><div>0</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*2\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->save();
            }
        }

        // Khusus tabel 4.5.2 (Kejaksaan Negeri - Perkara Masuk), perbaiki sub-kolom Pidana 'Kolom 6' menjadi 'Ringan / Slightly'
        if ($tableCode === '4.5.2' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if (str_contains($dbMetadata->table_html, 'Kolom 6')) {
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)colspan=["\']?\d+["\']?([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->save();
            }
        }

        // Khusus tabel 4.5.4 (Kejaksaan Negeri - Perkara Pidana Diselesaikan), perbaiki sub-kolom Pidana 'Kolom 7' menjadi 'Ringan / Slightly'
        if ($tableCode === '4.5.4' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if (str_contains($dbMetadata->table_html, 'Kolom 7')) {
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)colspan=["\']?\d+["\']?([^>]*)>\s*(?:<div>)?\s*Kolom\s*7\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*7\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->save();
            }
        }

        // Khusus tabel 4.2.11 (PMI - Donatur Darah), rapikan tahun ganda dan urutan tahun historis setelah Jumlah
        if ($tableCode === '4.2.11' && $dbMetadata && !empty($dbMetadata->table_html)) {
            $html = $dbMetadata->table_html;
            if (preg_match('/<tbody([^>]*)>(.*?)<\/tbody>/is', $html, $mTb)) {
                $tbodyAttr = $mTb[1];
                $tbodyHtml = $mTb[2];
                preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $tbodyHtml, $trs);
                $monthRows = [];
                $totalRow = null;
                $historyRows = [];
                $needsPmiClean = false;

                foreach ($trs[0] as $tr) {
                    if (preg_match('/<td[^>]*>(.*?)<\/td>/is', $tr, $firstTd)) {
                        $txt = trim(strip_tags($firstTd[1]));
                        if (preg_match('/(?:Jumlah|Total)/i', $txt)) {
                            $totalRow = $tr;
                            continue;
                        }
                        if (preg_match('/^(?:19|20)\d{2}$/', $txt)) {
                            $rowYr = (int)$txt;
                            if ($rowYr === $year) {
                                $needsPmiClean = true;
                                continue;
                            }
                            if ($totalRow === null) {
                                $needsPmiClean = true;
                            }
                            $historyRows[$rowYr] = $tr;
                            continue;
                        }
                        $monthRows[] = $tr;
                    }
                }

                if ($totalRow !== null && $needsPmiClean) {
                    $newRows = $monthRows;
                    $newRows[] = $totalRow;
                    for ($prevY = $year - 1; $prevY >= $year - 5; $prevY--) {
                        if (isset($historyRows[$prevY])) {
                            $newRows[] = $historyRows[$prevY];
                        } else {
                            $newRows[] = '<tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">' . "\n" .
                                '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">' . $prevY . '</td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-medium"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-medium"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-medium"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-medium"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-bold"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '</tr>';
                        }
                    }
                    $newTbodyHtml = "<tbody{$tbodyAttr}>\n" . implode("\n", $newRows) . "\n</tbody>";
                    $dbMetadata->table_html = preg_replace('/<tbody[^>]*>.*?<\/tbody>/is', $newTbodyHtml, $html);
                    $dbMetadata->save();
                }
            }
        }

        // Khusus tabel 4.2.22 (BPJS - Peserta Aktif Menurut Jenis Kepesertaan), rapikan tahun ganda dan urutan tahun historis setelah Jumlah
        if ($tableCode === '4.2.22' && $dbMetadata && !empty($dbMetadata->table_html)) {
            $html = $dbMetadata->table_html;
            if (preg_match('/<tbody([^>]*)>(.*?)<\/tbody>/is', $html, $mTb)) {
                $tbodyAttr = $mTb[1];
                $tbodyHtml = $mTb[2];
                preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $tbodyHtml, $trs);
                $catRows = [];
                $totalRow = null;
                $historyRows = [];
                $needsClean = false;

                foreach ($trs[0] as $tr) {
                    if (preg_match('/<td[^>]*>(.*?)<\/td>/is', $tr, $firstTd)) {
                        $txt = trim(strip_tags($firstTd[1]));
                        if (preg_match('/(?:Jumlah|Total)/i', $txt)) {
                            $totalRow = $tr;
                            continue;
                        }
                        if (preg_match('/^(?:19|20)\d{2}$/', $txt)) {
                            $rowYr = (int)$txt;
                            if ($rowYr === (int)$year) {
                                $needsClean = true;
                                continue;
                            }
                            if ($totalRow === null) {
                                $needsClean = true;
                            }
                            $historyRows[$rowYr] = $tr;
                            continue;
                        }
                        if ($totalRow === null) {
                            $catRows[] = $tr;
                        }
                    }
                }

                if ($totalRow !== null && ($needsClean || count($historyRows) < 5)) {
                    $newRows = $catRows;
                    $newRows[] = $totalRow;
                    for ($prevY = (int)$year - 1; $prevY >= (int)$year - 5; $prevY--) {
                        if (isset($historyRows[$prevY])) {
                            $newRows[] = $historyRows[$prevY];
                        } else {
                            $newRows[] = '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n" .
                                '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">' . $prevY . '</td>' . "\n" .
                                '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top text-center align-middle"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '</tr>';
                            $needsClean = true;
                        }
                    }
                    if ($needsClean) {
                        $newTbodyHtml = "<tbody{$tbodyAttr}>\n" . implode("\n", $newRows) . "\n</tbody>";
                        $dbMetadata->table_html = preg_replace('/<tbody[^>]*>.*?<\/tbody>/is', $newTbodyHtml, $html);
                        $dbMetadata->save();
                    }
                }
            }
        }

        // Khusus tabel 8.1.10 (Polres - Kecelakaan Lalu Lintas), rapikan header dan pergeseran kolom
        if ($tableCode === '8.1.10' && $dbMetadata && !empty($dbMetadata->table_html)) {
            $h8110 = $dbMetadata->table_html;
            $needs8110Save = false;

            if (str_contains($h8110, 'Severly') || str_contains($h8110, 'Sligly') || str_contains($h8110, '<div>Taksiran Kerugian</div>')) {
                $h8110 = preg_replace('/Severly/i', 'Severely', $h8110);
                $h8110 = preg_replace('/Sligly/i', 'Slightly', $h8110);
                $h8110 = preg_replace('/<div>Taksiran Kerugian<\/div>/i', '<div>Taksiran Kerugian Material (Rp)</div>', $h8110);
                $needs8110Save = true;
            }

            if (preg_match('/<td[^>]*>[^<]*Januari[^<]*<\/td>\s*<td[^>]*>\s*(?:<span[^>]*>)?-(?:<\/span>)?\s*<\/td>/i', $h8110)) {
                $masterHtml = TabelMetadata::where('table_code', '8.1.10')
                    ->where('year', $year)
                    ->where('opd_code', '01')
                    ->value('table_html');
                if (!empty($masterHtml)) {
                    $h8110 = $masterHtml;
                    $needs8110Save = true;
                }
            }

            if ($needs8110Save) {
                $dbMetadata->table_html = $h8110;
                $dbMetadata->save();
            }
        }

        // Khusus tabel 8.1.11 (Samsat - Kendaraan Bermotor), rapikan header bertingkat jika ada broken rowspan/colspan
        if ($tableCode === '8.1.11' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if ((str_contains($dbMetadata->table_html, '<div>-</div>') || !str_contains($dbMetadata->table_html, 'rowspan="2"')) && str_contains($dbMetadata->table_html, 'Mendaftar Ulang')) {
                $cleanThead = '<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2"><div>Jenis Kendaraan</div><div class="italic font-normal text-[11px] sm:text-xs">Kind of Car</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700" colspan="4"><div>Mendaftar Ulang (Plat)</div><div class="italic font-normal text-[11px] sm:text-xs">Registered Jenis (Unit)</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700" colspan="4"><div>Balik Nama (Plat)</div><div class="italic font-normal text-[11px] sm:text-xs">Name Return (Unit)</div></th>
                    </tr>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Hitam</div><div class="italic font-normal text-[11px] sm:text-xs">Black</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Kuning</div><div class="italic font-normal text-[11px] sm:text-xs">Yellow</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Merah</div><div class="italic font-normal text-[11px] sm:text-xs">Red</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Hitam</div><div class="italic font-normal text-[11px] sm:text-xs">Black</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Kuning</div><div class="italic font-normal text-[11px] sm:text-xs">Yellow</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Merah</div><div class="italic font-normal text-[11px] sm:text-xs">Red</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div></th>
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700">(1)</th>
                        <th class="py-1 px-3 border border-slate-700">(2)</th>
                        <th class="py-1 px-3 border border-slate-700">(3)</th>
                        <th class="py-1 px-3 border border-slate-700">(4)</th>
                        <th class="py-1 px-3 border border-slate-700">(5)</th>
                        <th class="py-1 px-3 border border-slate-700">(6)</th>
                        <th class="py-1 px-3 border border-slate-700">(7)</th>
                        <th class="py-1 px-3 border border-slate-700">(8)</th>
                        <th class="py-1 px-3 border border-slate-700">(9)</th>
                    </tr>
                </thead>';
                $dbMetadata->table_html = preg_replace('/<thead>.*?<\/thead>/is', $cleanThead, $dbMetadata->table_html);
                $dbMetadata->save();
            }
        }

        // Khusus tabel 8.1.1 (Dinas PUPR - Panjang Jalan Menurut Tingkat Kewenangan)
        if ($tableCode === '8.1.1') {
            $expectedRange = ($year - 4) . '–' . $year;
            $titleId811 = "Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi, {$expectedRange}";
            $titleEn811 = "Length of Road by Level of Government Authority in Bukittinggi Municipality (Km), {$expectedRange}";
            $source811 = 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>';
            $note811 = '<div class="space-y-1"><div>1. Data tidak termasuk panjang jalan tol / <span class="italic text-slate-500">Excluding toll road</span></div><div>2. Data tahun 2023 berdasarkan Keputusan Menteri Pekerjaan Umum dan Perumahan Rakyat No. 1688/KPTS/M/2022 / <span class="italic text-slate-500">Data of 2023 based on Public Works and Public Housing Ministerial Decree No. 1688/KPTS/M/2022</span></div></div>';

            $startYr = (string)($year - 4);
            $endYr = (string)$year;
            $hasValidHtml = $dbMetadata && !empty($dbMetadata->table_html) && str_contains($dbMetadata->table_html, $startYr) && str_contains($dbMetadata->table_html, $endYr);

            if (!$hasValidHtml) {
                $html811 = $this->buildTabel811Html($year);
                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId811,
                        'title_en' => $titleEn811,
                        'source' => $source811,
                        'note' => $note811,
                        'table_html' => $html811,
                        'source_type' => 'database',
                        'is_saved' => true,
                    ]
                );
            }

            if ($dbMetadata && ($dbMetadata->title_id !== $titleId811 || $dbMetadata->title_en !== $titleEn811)) {
                $dbMetadata->title_id = $titleId811;
                $dbMetadata->title_en = $titleEn811;
                $dbMetadata->save();
            }

            return $dbMetadata;
        }

        // Khusus tabel 8.1.3 (Dinas PUPR - Panjang Jalan Menurut Kondisi Jalan)
        if ($tableCode === '8.1.3') {
            $expectedRange = ($year - 4) . '–' . $year;
            $titleId813 = "Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km), {$expectedRange}";
            $titleEn813 = "Length of Road by Condition of Road in Bukittinggi Municipality (km), {$expectedRange}";
            $source813 = 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>';

            $startYr = (string)($year - 4);
            $endYr = (string)$year;
            $hasValidHtml = $dbMetadata && !empty($dbMetadata->table_html) && str_contains($dbMetadata->table_html, $startYr) && str_contains($dbMetadata->table_html, $endYr);

            if (!$hasValidHtml) {
                $html813 = $this->buildTabel813Html($year);
                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId813,
                        'title_en' => $titleEn813,
                        'source' => $source813,
                        'note' => '',
                        'table_html' => $html813,
                        'source_type' => 'database',
                        'is_saved' => true,
                    ]
                );
            }

            if ($dbMetadata && ($dbMetadata->title_id !== $titleId813 || $dbMetadata->title_en !== $titleEn813)) {
                $dbMetadata->title_id = $titleId813;
                $dbMetadata->title_en = $titleEn813;
                $dbMetadata->save();
            }

            return $dbMetadata;
        }

        // Khusus tabel 11.2 (Dinas PMPTSP - NIB menurut sektor), pastikan rentang tahun Jumlah valid [year, year-1, ..., year-5]
        if ($tableCode === '11.2') {
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasCurrentYear = str_contains($dbMetadata->table_html, (string)$year);
                $hasCorruptJumlah = str_contains($dbMetadata->table_html, 'Jumlah') && (str_contains($dbMetadata->table_html, '<span class="text-slate-400 font-normal">-</span>') && !str_contains($dbMetadata->table_html, "font-extrabold\">\n                                    {$year}\n") && !str_contains($dbMetadata->table_html, "font-extrabold\">\n        {$year}\n") && !str_contains($dbMetadata->table_html, "font-extrabold\">{$year}<"));
                $hasGhostRow = str_contains($dbMetadata->table_html, "-</span>\n                                </td>\n                            \n                                <td class=\"py-2.5 px-4 border border-slate-700 text-center align-top \">\n                                    2025");
                if ($hasCurrentYear && !$hasCorruptJumlah && !$hasGhostRow) {
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel112Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Tabel 11.2 Jumlah Nomor Induk Berusaha (NIB) yang Dikeluarkan Menurut Sektor di Kota Bukittinggi, {$year}";
            $titleEn = "Table 11.2 Number of Business Identification Numbers (NIB) Issued by Sector in Bukittinggi Municipality, {$year}";
            $source = 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kota Bukittinggi / <span class="italic text-slate-500">Bukittinggi Municipality Investment and One Stop Integrated Services Service</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => ($year === 2024 || $year === 2025) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 3.1.1 (Disdukcapil - Penduduk Menurut Kecamatan)
        if ($tableCode === '3.1.1') {
            $isKnownYear = in_array($year, [2024, 2025]);
            $isOldEmptyTemplate = $dbMetadata && !empty($dbMetadata->table_html) && $dbMetadata->source_type === 'template' && !str_contains($dbMetadata->table_html, '49.614') && !str_contains($dbMetadata->table_html, '50.210') && $isKnownYear;

            if (!$dbMetadata || empty($dbMetadata->table_html) || $isOldEmptyTemplate) {
                $html311 = $this->buildTabel311Html($year, $dbMetadata ? $dbMetadata->table_html : null);
                $titleId311 = "Jumlah Penduduk, Laju Pertumbuhan Penduduk, Distribusi Persentase Penduduk, Kepadatan Penduduk, Rasio Jenis Kelamin Penduduk Menurut Kecamatan di Kota Bukittinggi";
                $titleEn311 = "Population, Population Growth Rate, Percentage Distribution of Population, Population Density, and Population Sex Ratio by District in Bukittinggi Municipality";
                $source311 = 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>';
                
                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId311,
                        'title_en' => $titleEn311,
                        'source' => $source311,
                        'note' => '',
                        'table_html' => $html311,
                        'source_type' => $isKnownYear ? 'excel' : 'template',
                        'is_saved' => true,
                    ]
                );
            }
            return $dbMetadata;
        }



        // Khusus tabel 3.1.2 (Disdukcapil - Penduduk Menurut Kelompok Umur & Jenis Kelamin)
        if ($tableCode === '3.1.2') {
            $is2025 = ($year === 2025);
            $isOldUnformattedOrEmpty = $dbMetadata && !empty($dbMetadata->table_html) && $is2025 && (!str_contains($dbMetadata->table_html, '5.203') || !str_contains($dbMetadata->table_html, '71.987'));

            if (!$dbMetadata || empty($dbMetadata->table_html) || $isOldUnformattedOrEmpty) {
                $html312 = $this->buildTabel312Html($year, $dbMetadata ? $dbMetadata->table_html : null);
                $titleId312 = "Penduduk Menurut Golongan Umur dan Jenis Kelamin di Kota Bukittinggi";
                $titleEn312 = "Population by Age Group and Sex in Bukittinggi Municipality";
                $source312 = 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>';
                
                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId312,
                        'title_en' => $titleEn312,
                        'source' => $source312,
                        'note' => '',
                        'table_html' => $html312,
                        'source_type' => $is2025 ? 'excel' : 'template',
                        'is_saved' => true,
                    ]
                );
            }
            return $dbMetadata;
        }



        // Khusus tabel 1.1.8 (Kantor Pertanahan - Pembuatan Sertifikat Menurut Jenis Kepemilikan)
        // Memastikan rentang 7 tahun dinamis [year - 6 s.d. year] dan struktur kolom lengkap
        if ($tableCode === '1.1.8') {
            $startYear = $year - 6;
            $expectedTitle = "Jumlah Pembuatan Sertifikat Menurut Jenis Kepemilikan di Kota Bukittinggi, {$startYear}–{$year}";
            $hasCorrectRange = false;
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasStartYear = str_contains($dbMetadata->table_html, (string)$startYear);
                $hasEndYear = str_contains($dbMetadata->table_html, (string)$year);
                $hasCorrectCols = str_contains($dbMetadata->table_html, '(7)') || str_contains($dbMetadata->table_html, 'Hak Tanggungan');
                if ($hasStartYear && $hasEndYear && $hasCorrectCols && $dbMetadata->title_id === $expectedTitle) {
                    $hasCorrectRange = true;
                }
            }

            if (!$hasCorrectRange) {
                $fixedHtml = $this->buildTabel118Html($year, $dbMetadata ? $dbMetadata->table_html : null);
                $titleId = $expectedTitle;
                $titleEn = "Number of Issued Land Certificates by Type of Ownership in Bukittinggi, {$startYear}–{$year}";
                $source = 'Kantor Pertanahan Kota Bukittinggi / <span class="italic text-slate-500">Land Office of Bukittinggi Municipality</span>';

                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId,
                        'title_en' => $titleEn,
                        'source' => $source,
                        'note' => '',
                        'table_html' => $fixedHtml,
                        'source_type' => in_array($year, [2023, 2024, 2025]) ? 'excel' : 'template',
                        'is_saved' => true,
                    ]
                );
            }
            return $dbMetadata;
        }

        // Khusus tabel 1.1.9 (Kantor Pertanahan - Pencatatan Peralihan Hak Menurut Jenis Kepemilikan)
        // Memastikan rentang tahun pada judul selalu sinkron dengan kolom tahun pada tabel (7 tahun: year - 6 s.d. year)
        if ($tableCode === '1.1.9') {
            if ($dbMetadata) {
                $years = [];
                if (!empty($dbMetadata->table_html) && preg_match('/<thead[^>]*>(.*?)<\/thead>/is', $dbMetadata->table_html, $thMatch)) {
                    preg_match_all('/<th[^>]*>(.*?)<\/th>/is', $thMatch[1], $ths);
                    foreach ($ths[1] as $th) {
                        $txt = trim(strip_tags($th));
                        if (preg_match('/^(?:19|20)\d{2}$/', $txt, $ym)) {
                            $years[] = (int)$ym[0];
                        }
                    }
                }
                $startYear = count($years) >= 2 ? min($years) : ($year - 6);
                $endYear = count($years) >= 2 ? max($years) : $year;
                $expectedTitle = "Jumlah Pencatatan Peralihan Hak Menurut Jenis Kepemilikan di Kota Bukittinggi, {$startYear}–{$endYear}";

                if ($dbMetadata->title_id !== $expectedTitle) {
                    $dbMetadata->title_id = $expectedTitle;
                    $dbMetadata->title_en = "Number of Title Transfer Registrations by Type of Ownership in Bukittinggi Municipality, {$startYear}–{$endYear}";
                    $dbMetadata->save();
                }
            }
            return $dbMetadata;
        }

        // Khusus tabel 3.1.8 (Disdukcapil - Penduduk Wajib KTP & KTP Elektronik)
        // Memastikan 6 tahun historis pada Jumlah dinamis [year, year-1, ..., year-5] dan tanpa ghost cell
        if ($tableCode === '3.1.8') {
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasCurrentYear = str_contains($dbMetadata->table_html, (string)$year);
                $hasGhostRowspan = str_contains($dbMetadata->table_html, 'rowspan="3"');
                $hasYearInJumlah = preg_match('/<td[^>]*>\s*' . $year . '\s*<\/td>/i', $dbMetadata->table_html);
                if ($hasCurrentYear && !$hasGhostRowspan && $hasYearInJumlah) {
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel318Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Jumlah Penduduk Wajib KTP (Kartu Tanda Penduduk) dan yang Telah Memiliki KTP dirinci Menurut Kecamatan di Kota Bukittinggi, {$year}";
            $titleEn = "Number of Population Owner Identity Card and Be Possessed Identity Card Already by District in Bukittinggi Municipality, {$year}";
            $source = 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => ($year === 2025 || $year === 2024) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 4.3.1 (Disdukcapil - Penduduk Menurut Agama yang Dianut)
        if ($tableCode === '4.3.1') {
            $isKnownYear = in_array($year, [2023, 2024, 2025]);
            $isOldUnformatted = $dbMetadata && !empty($dbMetadata->table_html) && (
                !str_contains($dbMetadata->table_html, '.') || str_contains($dbMetadata->table_html, '(8)')
            );

            if (!$dbMetadata || empty($dbMetadata->table_html) || ($isKnownYear && $isOldUnformatted)) {
                $html431 = $this->buildTabel431Html($year, $dbMetadata ? $dbMetadata->table_html : null);
                $titleId431 = "Jumlah Penduduk Menurut Agama yang Dianut di Kota Bukittinggi, {$year}";
                $titleEn431 = "Number of Population by Religion in Bukittinggi, {$year}";
                $source431 = 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>';

                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId431,
                        'title_en' => $titleEn431,
                        'source' => $source431,
                        'note' => '',
                        'table_html' => $html431,
                        'source_type' => $isKnownYear ? 'excel' : 'template',
                        'is_saved' => true,
                    ]
                );
            }
            return $dbMetadata;
        }



        // Khusus tabel 3.2.8 (Dinas Koperasi, UKM dan Tenaga Kerja - Pencari Kerja Menurut Tingkat Pendidikan)
        if ($tableCode === '3.2.8') {
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasCurrentYear = str_contains($dbMetadata->table_html, (string)$year);
                $hasCol13 = str_contains($dbMetadata->table_html, '(13)');
                $hasYearInJumlah = preg_match('/<td[^>]*>\s*' . $year . '\s*<\/td>/i', $dbMetadata->table_html);
                if ($hasCurrentYear && $hasCol13 && $hasYearInJumlah) {
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel328Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Jumlah Pencari Kerja yang Terdaftar Menurut Tingkat Pendidikan yang Ditamatkan di Kota Bukittinggi, {$year}";
            $titleEn = "Number of Job Seeker Registered by Educational Attainment in Bukittinggi Municipality, {$year}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => in_array($year, [2020, 2021, 2022, 2023, 2024, 2025]) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 9.1 (Dinas Koperasi, UKM dan Tenaga Kerja - Jumlah Koperasi Aktif Menurut Kecamatan)
        if ($tableCode === '9.1') {
            $startYr = (string)($year - 4);
            $endYr = (string)$year;
            $rangeLabel = "{$startYr}–{$endYr}";
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasStartYr = str_contains($dbMetadata->table_html, $startYr);
                $hasEndYr = str_contains($dbMetadata->table_html, $endYr);
                $hasCol6 = str_contains($dbMetadata->table_html, '(6)');
                if ($hasStartYr && $hasEndYr && $hasCol6) {
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel91Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Jumlah Koperasi Aktif Menurut Kecamatan di Kota Bukittinggi, {$rangeLabel}";
            $titleEn = "Number of Active Cooperative in Bukittinggi Municipality, {$rangeLabel}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 9.3 (Dinas Koperasi, UKM dan Tenaga Kerja - Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha)
        if ($tableCode === '9.3') {
            $startYr = (string)($year - 6);
            $endYr = (string)$year;
            $rangeLabel = "{$startYr}–{$endYr}";
            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $hasStartYr = str_contains($dbMetadata->table_html, $startYr);
                $hasEndYr = str_contains($dbMetadata->table_html, $endYr);
                $hasCol6 = str_contains($dbMetadata->table_html, '(6)');
                if ($hasStartYr && $hasEndYr && $hasCol6) {
                    $cleanTitleId = "Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha di Kota Bukittinggi, {$year}";
                    $cleanTitleEn = "Growth of Cooperative by Member, Deposite and Omset in Bukittinggi, {$year}";
                    if ($dbMetadata->title_id !== $cleanTitleId || $dbMetadata->title_en !== $cleanTitleEn) {
                        $dbMetadata->title_id = $cleanTitleId;
                        $dbMetadata->title_en = $cleanTitleEn;
                        $dbMetadata->save();
                    }
                    return $dbMetadata;
                }
            }

            $fixedHtml = $this->buildTabel93Html($year, $dbMetadata ? $dbMetadata->table_html : null);
            $titleId = "Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha di Kota Bukittinggi, {$year}";
            $titleEn = "Growth of Cooperative by Member, Deposite and Omset in Bukittinggi, {$year}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $titleId,
                    'title_en' => $titleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => true,
                ]
            );
        }

                // Khusus tabel 4.1.20 (Dinas Pemuda dan Olahraga - Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi)
        if ($tableCode === '4.1.20') {
            $y1 = $year - 3;
            $y4 = $year;
            $rangeLabel = "{$y1}–{$y4}";
            $cleanTitleId = "Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi, {$rangeLabel}";
            $cleanTitleEn = "Number of Sport Club in Bukittinggi, {$rangeLabel}";
            $source = 'Dinas Pemuda dan Olahraga Kota Bukittinggi / <span class="italic text-slate-500">Youth and Sports Agency of Bukittinggi Municipality</span>';

            $hasGapInHeaders = $dbMetadata && !empty($dbMetadata->table_html) && str_contains($dbMetadata->table_html, '2022') && str_contains($dbMetadata->table_html, (string)$year) && $year >= 2026;
            $isCorruptTitle = $dbMetadata && str_contains($dbMetadata->title_id ?? '', 'Number of Sport');

            if ($dbMetadata && !empty($dbMetadata->table_html) && !$hasGapInHeaders && !$isCorruptTitle) {
                $needsSave = false;
                if ($dbMetadata->title_id !== $cleanTitleId) {
                    $dbMetadata->title_id = $cleanTitleId;
                    $needsSave = true;
                }
                if ($dbMetadata->title_en !== $cleanTitleEn) {
                    $dbMetadata->title_en = $cleanTitleEn;
                    $needsSave = true;
                }
                if ($needsSave) {
                    $dbMetadata->save();
                }
                return $dbMetadata;
            }

            $fixedHtml = $this->buildTabel4120Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => in_array($year, [2022, 2023, 2024, 2025]) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

                // Khusus tabel 4.1.24 (Dinas Perpustakaan dan Kearsipan - Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi)
        if ($tableCode === '4.1.24') {
            $cleanTitleId = "Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi, {$year}";
            $cleanTitleEn = "Number of Library Institutions, Collections, and Library Visitors in the City of Bukittinggi, {$year}";
            $source = 'Dinas Perpustakaan dan Kearsipan Kota Bukittinggi / <span class="italic text-slate-500">Library and Archives Service of Bukittinggi Municipality</span>';

            $fixedHtml = $this->buildTabel4124Html($year, $dbMetadata ? $dbMetadata->table_html : null, $opdCode);

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => ($year == 2025) ? 'excel' : 'template',
                    'is_saved' => true,
                ]
            );
        }

        // Khusus tabel 4.3.4 (Badan Penanggulangan Bencana Daerah / BPBD - Jumlah Kejadian Bencana Alam di Kota Bukittinggi Menurut Kecamatan)
        if ($tableCode === '4.3.4') {
            $cleanTitleId = "Jumlah Kejadian Bencana Alam di Kota Bukittinggi Menurut Kecamatan, {$year}";
            $cleanTitleEn = "Number of Natural Disasters in Bukittinggi Municipality by District, {$year}";
            $source = 'Badan Penanggulangan Bencana Daerah (BPBD) Kota Bukittinggi / <span class="italic text-slate-500">Regional Agency for Disaster Management of Bukittinggi Municipality</span>';

            $fixedHtml = $this->buildTabel434Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsSave = false;
                if ($dbMetadata->title_id !== $cleanTitleId) {
                    $dbMetadata->title_id = $cleanTitleId;
                    $needsSave = true;
                }
                if ($dbMetadata->title_en !== $cleanTitleEn) {
                    $dbMetadata->title_en = $cleanTitleEn;
                    $needsSave = true;
                }
                if ($needsSave) {
                    $dbMetadata->save();
                }
                return $dbMetadata;
            }

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => in_array($year, [2023, 2024, 2025]),
                ]
            );
        }

        // Khusus tabel 4.3.5 (Dinas Pemadam Kebakaran dan Penyelamatan - Jumlah Kejadian Kebakaran Menurut Bulan)
        if ($tableCode === '4.3.5') {
            $y1 = $year - 4;
            $y5 = $year;
            $rangeLabel = "{$y1}–{$y5}";
            $cleanTitleId = "Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Bulan, {$rangeLabel}";
            $cleanTitleEn = "Number of Fire Incident in Bukittinggi Municipality by Month, {$rangeLabel}";
            $source = 'Dinas Pemadam Kebakaran dan Penyelamatan Kota Bukittinggi / <span class="italic text-slate-500">Fire and Rescue Service of Bukittinggi Municipality</span>';

            $isWrongLibrary = $dbMetadata && !empty($dbMetadata->table_html) && (
                str_contains($dbMetadata->table_html, 'Perpustakaan') ||
                str_contains($dbMetadata->table_html, 'Library') ||
                str_contains($dbMetadata->title_id ?? '', 'Perpustakaan')
            );

            if ($dbMetadata && !empty($dbMetadata->table_html) && !$isWrongLibrary) {
                return $dbMetadata;
            }

            $fixedHtml = $this->buildTabel435Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => '15',
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => false,
                ]
            );
        }

        // Khusus tabel 9.2 (Dinas Koperasi, UKM dan Tenaga Kerja - Jumlah Koperasi Menurut Jenis Koperasi dan Kecamatan)
        if ($tableCode === '9.2') {
            $cleanTitleId = "Jumlah Koperasi Menurut Jenis Koperasi dan Kecamatan di Kota Bukittinggi, {$year}";
            $cleanTitleEn = "Number of Cooperative by Kind of Cooperative and Subdistrict in Bukittinggi Municipality, {$year}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            $fixedHtml = $this->buildTabel92Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsSave = false;
                if ($dbMetadata->title_id !== $cleanTitleId) {
                    $dbMetadata->title_id = $cleanTitleId;
                    $needsSave = true;
                }
                if ($dbMetadata->title_en !== $cleanTitleEn) {
                    $dbMetadata->title_en = $cleanTitleEn;
                    $needsSave = true;
                }
                if ($needsSave) {
                    $dbMetadata->save();
                }
                return $dbMetadata;
            }

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => in_array($year, [2023, 2024, 2025]),
                ]
            );
        }

        // Khusus tabel 9.4 (Dinas Koperasi, UKM dan Tenaga Kerja - Jumlah Koperasi Menurut Jenisnya per Kecamatan)
        if ($tableCode === '9.4') {
            $cleanTitleId = "Jumlah Koperasi Menurut Jenisnya per Kecamatan di Kota Bukittinggi, {$year}";
            $cleanTitleEn = "Number of Cooperation by Kind in District in Bukittinggi, {$year}";
            $source = 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>';

            $fixedHtml = $this->buildTabel94Html($year, $dbMetadata ? $dbMetadata->table_html : null);

            if ($dbMetadata && !empty($dbMetadata->table_html)) {
                $needsSave = false;
                if ($dbMetadata->title_id !== $cleanTitleId) {
                    $dbMetadata->title_id = $cleanTitleId;
                    $needsSave = true;
                }
                if ($dbMetadata->title_en !== $cleanTitleEn) {
                    $dbMetadata->title_en = $cleanTitleEn;
                    $needsSave = true;
                }
                if (str_contains($dbMetadata->table_html, 'Kolom 6') || !str_contains($dbMetadata->table_html, (string)$year)) {
                    $dbMetadata->table_html = $fixedHtml;
                    $needsSave = true;
                }
                if ($needsSave) {
                    $dbMetadata->save();
                }
                return $dbMetadata;
            }

            return TabelMetadata::updateOrCreate(
                [
                    'table_code' => $tableCode,
                    'opd_code' => $opdCode,
                    'year' => $year,
                ],
                [
                    'title_id' => $cleanTitleId,
                    'title_en' => $cleanTitleEn,
                    'source' => $source,
                    'note' => '',
                    'table_html' => $fixedHtml,
                    'source_type' => 'template',
                    'is_saved' => true,
                ]
            );
        }

        $isStarterDummy = false;
        if ($dbMetadata && !empty($dbMetadata->table_html)) {
            $htmlLower = strtolower($dbMetadata->table_html);
            if (str_contains($htmlLower, 'indicator details') || 
                str_contains($htmlLower, 'rincian indikator') || 
                str_contains($htmlLower, 'data statistik sektoral') || 
                str_contains($htmlLower, 'capaian nilai tahun') || 
                str_contains($htmlLower, 'belum ada data untuk tabel ini')) {
                $isStarterDummy = true;
            }
        }

        if ($dbMetadata && !empty($dbMetadata->table_html) && !$isStarterDummy) {
            // Untuk tabel multi-tahun (4.1.18, 4.1.19, 8.1.1-8.1.8, 8.2.2, 2.2.5, 1.1.10, 9.1, 9.3, 2.4.3, 2.4.1, 2.4.2), pastikan table_html memuat tahun awal dan tahun akhir rentang
            $isMultiYear = in_array($tableCode, ['4.1.18', '4.1.19', '8.1.1', '8.1.2', '8.1.3', '8.1.6', '8.1.7', '8.1.8', '8.2.2', '2.2.5', '1.1.10', '9.1', '9.3', '2.4.3', '2.4.1', '2.4.2']);
            if ($isMultiYear) {
                $span = ($tableCode === '9.3') ? 6 : (($tableCode === '2.4.1' || $tableCode === '2.4.2') ? 3 : ((in_array($tableCode, ['4.1.18', '4.1.19']) && $opdCode === '07') ? 2 : 4));
                $startYr = (string)($year - $span);
                $endYr = (string)$year;
                if (!str_contains($dbMetadata->table_html, $startYr) || !str_contains($dbMetadata->table_html, $endYr)) {
                    return null;
                }
            } elseif (str_starts_with($tableCode, '5.') && $dbMetadata->source_type === 'template') {
                if (!str_contains($dbMetadata->table_html, (string)$year) || ($tableCode === '5.3.1' && !str_contains(strtolower($dbMetadata->table_html), 'jumlah'))) {
                    $dbMetadata = null;
                }
            }
            if ($dbMetadata) {
                return $dbMetadata;
            }
        }

        // Khusus tabel 4.1.21 (UPT Perpustakaan Proklamator Bung Hatta), perbaiki header 'Kolom 10' menjadi 'Lain-lain' / 'Others'
        if ($tableCode === '4.1.21' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if (str_contains($dbMetadata->table_html, 'Kolom 10')) {
                $dbMetadata->table_html = preg_replace('/<th([^>]*)colspan="2"([^>]*)>\s*(?:<div>)?\s*Kolom\s*10\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div></th>', $dbMetadata->table_html);
                $dbMetadata->table_html = preg_replace('/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*10\s*(?:<\/div>)?\s*<\/th>/i', '<th class="py-3 px-4 font-bold border border-slate-700"><div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div></th>', $dbMetadata->table_html);
                $dbMetadata->table_html = str_replace(['<div>Kolom 10</div>', 'Kolom 10'], ['<div>Lain-lain</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div>', 'Lain-lain'], $dbMetadata->table_html);
                $dbMetadata->save();
            }
        }

        // Khusus tabel 4.1.23 (Penggolongan Koleksi Buku), perbaiki header 'Kolom 2' menjadi 'Bulan / Month' dan '0'
        if ($tableCode === '4.1.23' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if (str_contains($dbMetadata->table_html, 'Kolom 2')) {
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)colspan="2"([^>]*)>\s*(?:<div>)?\s*Kolom\s*2\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div></th>' . "\n" . '        <th class="py-3 px-4 font-bold border border-slate-700"><div>0</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*2\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->save();
            }
        }

        // Khusus tabel 4.5.2 (Kejaksaan Negeri - Perkara Masuk), perbaiki sub-kolom Pidana 'Kolom 6' menjadi 'Ringan / Slightly'
        if ($tableCode === '4.5.2' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if (str_contains($dbMetadata->table_html, 'Kolom 6')) {
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)colspan=["\']?\d+["\']?([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->save();
            }
        }

        // Khusus tabel 4.5.4 (Kejaksaan Negeri - Perkara Pidana Diselesaikan), perbaiki sub-kolom Pidana 'Kolom 7' menjadi 'Ringan / Slightly'
        if ($tableCode === '4.5.4' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if (str_contains($dbMetadata->table_html, 'Kolom 7')) {
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)colspan=["\']?\d+["\']?([^>]*)>\s*(?:<div>)?\s*Kolom\s*7\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->table_html = preg_replace(
                    '/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*7\s*(?:<\/div>)?\s*<\/th>/i',
                    '<th class="py-3 px-4 font-bold border border-slate-700"><div>Ringan</div><div class="italic font-normal text-[11px] sm:text-xs">Slightly</div></th>',
                    $dbMetadata->table_html
                );
                $dbMetadata->save();
            }
        }

        // Khusus tabel 4.2.11 (PMI - Donatur Darah), rapikan tahun ganda dan urutan tahun historis setelah Jumlah
        if ($tableCode === '4.2.11' && $dbMetadata && !empty($dbMetadata->table_html)) {
            $html = $dbMetadata->table_html;
            if (preg_match('/<tbody([^>]*)>(.*?)<\/tbody>/is', $html, $mTb)) {
                $tbodyAttr = $mTb[1];
                $tbodyHtml = $mTb[2];
                preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $tbodyHtml, $trs);
                $monthRows = [];
                $totalRow = null;
                $historyRows = [];
                $needsPmiClean = false;

                foreach ($trs[0] as $tr) {
                    if (preg_match('/<td[^>]*>(.*?)<\/td>/is', $tr, $firstTd)) {
                        $txt = trim(strip_tags($firstTd[1]));
                        if (preg_match('/(?:Jumlah|Total)/i', $txt)) {
                            $totalRow = $tr;
                            continue;
                        }
                        if (preg_match('/^(?:19|20)\d{2}$/', $txt)) {
                            $rowYr = (int)$txt;
                            if ($rowYr === $year) {
                                $needsPmiClean = true;
                                continue;
                            }
                            if ($totalRow === null) {
                                $needsPmiClean = true;
                            }
                            $historyRows[$rowYr] = $tr;
                            continue;
                        }
                        $monthRows[] = $tr;
                    }
                }

                if ($totalRow !== null && $needsPmiClean) {
                    $newRows = $monthRows;
                    $newRows[] = $totalRow;
                    for ($prevY = $year - 1; $prevY >= $year - 5; $prevY--) {
                        if (isset($historyRows[$prevY])) {
                            $newRows[] = $historyRows[$prevY];
                        } else {
                            $newRows[] = '<tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">' . "\n" .
                                '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">' . $prevY . '</td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-medium"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-medium"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-medium"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-medium"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '    <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-bold"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '</tr>';
                        }
                    }
                    $newTbodyHtml = "<tbody{$tbodyAttr}>\n" . implode("\n", $newRows) . "\n</tbody>";
                    $dbMetadata->table_html = preg_replace('/<tbody[^>]*>.*?<\/tbody>/is', $newTbodyHtml, $html);
                    $dbMetadata->save();
                }
            }
        }

        // Khusus tabel 4.2.22 (BPJS - Peserta Aktif Menurut Jenis Kepesertaan), rapikan tahun ganda dan urutan tahun historis setelah Jumlah
        if ($tableCode === '4.2.22' && $dbMetadata && !empty($dbMetadata->table_html)) {
            $html = $dbMetadata->table_html;
            if (preg_match('/<tbody([^>]*)>(.*?)<\/tbody>/is', $html, $mTb)) {
                $tbodyAttr = $mTb[1];
                $tbodyHtml = $mTb[2];
                preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $tbodyHtml, $trs);
                $catRows = [];
                $totalRow = null;
                $historyRows = [];
                $needsClean = false;

                foreach ($trs[0] as $tr) {
                    if (preg_match('/<td[^>]*>(.*?)<\/td>/is', $tr, $firstTd)) {
                        $txt = trim(strip_tags($firstTd[1]));
                        if (preg_match('/(?:Jumlah|Total)/i', $txt)) {
                            $totalRow = $tr;
                            continue;
                        }
                        if (preg_match('/^(?:19|20)\d{2}$/', $txt)) {
                            $rowYr = (int)$txt;
                            if ($rowYr === (int)$year) {
                                $needsClean = true;
                                continue;
                            }
                            if ($totalRow === null) {
                                $needsClean = true;
                            }
                            $historyRows[$rowYr] = $tr;
                            continue;
                        }
                        if ($totalRow === null) {
                            $catRows[] = $tr;
                        }
                    }
                }

                if ($totalRow !== null && ($needsClean || count($historyRows) < 5)) {
                    $newRows = $catRows;
                    $newRows[] = $totalRow;
                    for ($prevY = (int)$year - 1; $prevY >= (int)$year - 5; $prevY--) {
                        if (isset($historyRows[$prevY])) {
                            $newRows[] = $historyRows[$prevY];
                        } else {
                            $newRows[] = '<tr class="hover:bg-amber-100/60 transition-colors">' . "\n" .
                                '    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">' . $prevY . '</td>' . "\n" .
                                '    <td class="py-2.5 px-4 border border-slate-700 text-center align-top text-center align-middle"><span class="text-slate-400 font-normal">-</span></td>' . "\n" .
                                '</tr>';
                            $needsClean = true;
                        }
                    }
                    if ($needsClean) {
                        $newTbodyHtml = "<tbody{$tbodyAttr}>\n" . implode("\n", $newRows) . "\n</tbody>";
                        $dbMetadata->table_html = preg_replace('/<tbody[^>]*>.*?<\/tbody>/is', $newTbodyHtml, $html);
                        $dbMetadata->save();
                    }
                }
            }
        }

        // Khusus tabel 8.1.10 (Polres - Kecelakaan Lalu Lintas), rapikan header dan pergeseran kolom
        if ($tableCode === '8.1.10' && $dbMetadata && !empty($dbMetadata->table_html)) {
            $h8110 = $dbMetadata->table_html;
            $needs8110Save = false;

            if (str_contains($h8110, 'Severly') || str_contains($h8110, 'Sligly') || str_contains($h8110, '<div>Taksiran Kerugian</div>')) {
                $h8110 = preg_replace('/Severly/i', 'Severely', $h8110);
                $h8110 = preg_replace('/Sligly/i', 'Slightly', $h8110);
                $h8110 = preg_replace('/<div>Taksiran Kerugian<\/div>/i', '<div>Taksiran Kerugian Material (Rp)</div>', $h8110);
                $needs8110Save = true;
            }

            if (preg_match('/<td[^>]*>[^<]*Januari[^<]*<\/td>\s*<td[^>]*>\s*(?:<span[^>]*>)?-(?:<\/span>)?\s*<\/td>/i', $h8110)) {
                $masterHtml = TabelMetadata::where('table_code', '8.1.10')
                    ->where('year', $year)
                    ->where('opd_code', '01')
                    ->value('table_html');
                if (!empty($masterHtml)) {
                    $h8110 = $masterHtml;
                    $needs8110Save = true;
                }
            }

            if ($needs8110Save) {
                $dbMetadata->table_html = $h8110;
                $dbMetadata->save();
            }
        }

        // Khusus tabel 8.1.11 (Samsat - Kendaraan Bermotor), rapikan header bertingkat jika ada broken rowspan/colspan
        if ($tableCode === '8.1.11' && $dbMetadata && !empty($dbMetadata->table_html)) {
            if ((str_contains($dbMetadata->table_html, '<div>-</div>') || !str_contains($dbMetadata->table_html, 'rowspan="2"')) && str_contains($dbMetadata->table_html, 'Mendaftar Ulang')) {
                $cleanThead = '<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2"><div>Jenis Kendaraan</div><div class="italic font-normal text-[11px] sm:text-xs">Kind of Car</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700" colspan="4"><div>Mendaftar Ulang (Plat)</div><div class="italic font-normal text-[11px] sm:text-xs">Registered Jenis (Unit)</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700" colspan="4"><div>Balik Nama (Plat)</div><div class="italic font-normal text-[11px] sm:text-xs">Name Return (Unit)</div></th>
                    </tr>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Hitam</div><div class="italic font-normal text-[11px] sm:text-xs">Black</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Kuning</div><div class="italic font-normal text-[11px] sm:text-xs">Yellow</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Merah</div><div class="italic font-normal text-[11px] sm:text-xs">Red</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Hitam</div><div class="italic font-normal text-[11px] sm:text-xs">Black</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Kuning</div><div class="italic font-normal text-[11px] sm:text-xs">Yellow</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Merah</div><div class="italic font-normal text-[11px] sm:text-xs">Red</div></th>
                        <th class="py-3 px-4 font-bold border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div></th>
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700">(1)</th>
                        <th class="py-1 px-3 border border-slate-700">(2)</th>
                        <th class="py-1 px-3 border border-slate-700">(3)</th>
                        <th class="py-1 px-3 border border-slate-700">(4)</th>
                        <th class="py-1 px-3 border border-slate-700">(5)</th>
                        <th class="py-1 px-3 border border-slate-700">(6)</th>
                        <th class="py-1 px-3 border border-slate-700">(7)</th>
                        <th class="py-1 px-3 border border-slate-700">(8)</th>
                        <th class="py-1 px-3 border border-slate-700">(9)</th>
                    </tr>
                </thead>';
                $dbMetadata->table_html = preg_replace('/<thead>.*?<\/thead>/is', $cleanThead, $dbMetadata->table_html);
                $dbMetadata->save();
            }
        }

        // Khusus tabel 8.1.1 (Dinas PUPR - Panjang Jalan Menurut Tingkat Kewenangan)
        if ($tableCode === '8.1.1') {
            $expectedRange = ($year - 4) . '–' . $year;
            $titleId811 = "Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi, {$expectedRange}";
            $titleEn811 = "Length of Road by Level of Government Authority in Bukittinggi Municipality (Km), {$expectedRange}";
            $source811 = 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>';
            $note811 = '<div class="space-y-1"><div>1. Data tidak termasuk panjang jalan tol / <span class="italic text-slate-500">Excluding toll road</span></div><div>2. Data tahun 2023 berdasarkan Keputusan Menteri Pekerjaan Umum dan Perumahan Rakyat No. 1688/KPTS/M/2022 / <span class="italic text-slate-500">Data of 2023 based on Public Works and Public Housing Ministerial Decree No. 1688/KPTS/M/2022</span></div></div>';

            $startYr = (string)($year - 4);
            $endYr = (string)$year;
            $hasValidHtml = $dbMetadata && !empty($dbMetadata->table_html) && str_contains($dbMetadata->table_html, $startYr) && str_contains($dbMetadata->table_html, $endYr);

            if (!$hasValidHtml) {
                $html811 = $this->buildTabel811Html($year);
                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId811,
                        'title_en' => $titleEn811,
                        'source' => $source811,
                        'note' => $note811,
                        'table_html' => $html811,
                        'source_type' => 'database',
                        'is_saved' => true,
                    ]
                );
            }

            if ($dbMetadata && ($dbMetadata->title_id !== $titleId811 || $dbMetadata->title_en !== $titleEn811)) {
                $dbMetadata->title_id = $titleId811;
                $dbMetadata->title_en = $titleEn811;
                $dbMetadata->save();
            }

            return $dbMetadata;
        }

        // Khusus tabel 8.1.3 (Dinas PUPR - Panjang Jalan Menurut Kondisi Jalan)
        if ($tableCode === '8.1.3') {
            $expectedRange = ($year - 4) . '–' . $year;
            $titleId813 = "Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km), {$expectedRange}";
            $titleEn813 = "Length of Road by Condition of Road in Bukittinggi Municipality (km), {$expectedRange}";
            $source813 = 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>';

            $startYr = (string)($year - 4);
            $endYr = (string)$year;
            $hasValidHtml = $dbMetadata && !empty($dbMetadata->table_html) && str_contains($dbMetadata->table_html, $startYr) && str_contains($dbMetadata->table_html, $endYr);

            if (!$hasValidHtml) {
                $html813 = $this->buildTabel813Html($year);
                return TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $year,
                    ],
                    [
                        'title_id' => $titleId813,
                        'title_en' => $titleEn813,
                        'source' => $source813,
                        'note' => '',
                        'table_html' => $html813,
                        'source_type' => 'database',
                        'is_saved' => true,
                    ]
                );
            }

            if ($dbMetadata && ($dbMetadata->title_id !== $titleId813 || $dbMetadata->title_en !== $titleEn813)) {
                $dbMetadata->title_id = $titleId813;
                $dbMetadata->title_en = $titleEn813;
                $dbMetadata->save();
            }

            return $dbMetadata;
        }

        // Tabel multi-tahun dan instansi dengan format tahunan unik seperti RRI (8.2.7 / OPD 35).
        // Jangan pernah meminjam metadata/HTML dari tahun lain karena setiap tahun isian/strukturnya berbeda.
        if ($opdCode === '35' || $tableCode === '8.2.7' || in_array($tableCode, ['4.1.18', '4.1.19', '8.1.1', '8.1.2', '8.1.3', '8.1.6', '8.1.7', '8.1.8', '8.2.2', '2.2.5', '1.1.10', '9.1', '9.3', '2.4.3', '2.4.1', '2.4.2'])) {
            return $dbMetadata;
        }



        // Cari struktur tabel dari tahun lain sebagai sumber (hanya untuk tabel non-multi-tahun)
        $sourceMetaQuery = TabelMetadata::where('table_code', $tableCode)
            ->whereNotNull('table_html')
            ->where('table_html', '!=', '')
            ->where('table_html', 'not like', '%Indicator Details%')
            ->where('table_html', 'not like', '%Rincian Indikator%')
            ->where('table_html', 'not like', '%Data Statistik Sektoral%')
            ->where('table_html', 'not like', '%Belum ada data untuk tabel ini%');

        if ($type === 'bps') {
            $sourceMetaQuery->where(function($q) use ($opdCode, $cleanOpd) {
                $q->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]))
                  ->orWhere('source_type', 'like', '%bps%');
            });
        } elseif ($type === 'instansi') {
            $sourceMetaQuery->whereIn('opd_code', array_unique([$opdCode, $cleanOpd]));
        } else {
            $sourceMetaQuery->where('opd_code', $opdCode);
        }

        $sourceMeta = $sourceMetaQuery->orderByRaw("CASE WHEN source_type NOT IN ('template') THEN 0 ELSE 1 END ASC, ABS(year - {$year}) ASC")
            ->first();

        if (!$sourceMeta) {
            return $dbMetadata;
        }



        $cleanHtml = $this->buildEmptyTemplateFromHtml($sourceMeta->table_html);
        $yHtml = $this->adjustYearInHtml($cleanHtml, (int)$sourceMeta->year, $year);
        $yTitleId = $this->adjustYearInTitle($sourceMeta->title_id, (int)$sourceMeta->year, $year);
        $yTitleEn = $this->adjustYearInTitle($sourceMeta->title_en, (int)$sourceMeta->year, $year);
        $yNote = $this->adjustYearInNote($sourceMeta->note, (int)$sourceMeta->year, $year);

        // Khusus tabel 4.1.2 (Kemenag RA)
        if ($tableCode === '4.1.2') {
            $expectedY1 = ($year - 1) . '/' . ($year);
            $expectedY2 = ($year) . '/' . ($year + 1);
            $expectedTitleEnd = "{$expectedY1} dan {$expectedY2}";

            if (preg_match('/\b\d{4}\s*\/\s*\d{4}\b/', $yHtml)) {
                $idx = 0;
                $yHtml = preg_replace_callback('/\b\d{4}\s*\/\s*\d{4}\b/', function($matches) use (&$idx, $expectedY1, $expectedY2) {
                    $col = $idx % 2;
                    $idx++;
                    return ($col === 0) ? $expectedY1 : $expectedY2;
                }, $yHtml);
            }
            if (!empty($yTitleId)) {
                $yTitleId = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $yTitleId);
            }
            if (!empty($yTitleEn)) {
                $yTitleEn = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedY1} and {$expectedY2}", $yTitleEn);
            }
        } elseif (in_array($tableCode, ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'])) {
            $expectedY1 = ($year - 2) . '/' . ($year - 1);
            $expectedY2 = ($year - 1) . '/' . ($year);
            $expectedY3 = ($year) . '/' . ($year + 1);
            $expectedTitleEnd = ($year) . '/' . ($year + 1);

            if (preg_match('/\b\d{4}\s*\/\s*\d{4}\b/', $yHtml)) {
                $idx = 0;
                $yHtml = preg_replace_callback('/\b\d{4}\s*\/\s*\d{4}\b/', function($matches) use (&$idx, $expectedY1, $expectedY2, $expectedY3) {
                    $col = $idx % 3;
                    $idx++;
                    if ($col === 0) return $expectedY1;
                    if ($col === 1) return $expectedY2;
                    return $expectedY3;
                }, $yHtml);
            }
            if (!empty($yTitleId)) {
                $yTitleId = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $yTitleId);
            }
            if (!empty($yTitleEn)) {
                $yTitleEn = preg_replace('/(,\s*|\s+)\d{4}\s*\/\s*\d{4}.*$/i', ", {$expectedTitleEnd}", $yTitleEn);
            }
        }

        $targetSourceType = match($type) {
            'bps' => 'custom_bps',
            'instansi' => 'custom_instansi',
            default => 'template'
        };

        return TabelMetadata::updateOrCreate(
            [
                'table_code' => $tableCode,
                'opd_code' => $opdCode,
                'year' => $year,
            ],
            [
                'title_id' => $yTitleId,
                'title_en' => $yTitleEn,
                'source' => $sourceMeta->source,
                'note' => $yNote,
                'table_html' => $yHtml,
                'source_type' => $targetSourceType,
                'is_saved' => true,
            ]
        );
    }

    /**
     * Membangun HTML tabel 8.1.1 (Panjang Jalan Menurut Tingkat Kewenangan) dengan rentang 5 tahun [year-4 .. year]
     */
    private function buildTabel811Html(int $year): string
    {
        $years = range($year - 4, $year);

        // Nilai acuan historis (dari data resmi PUPR / database)
        $knownData = [
            2019 => ['negara' => '-',     'provinsi' => '-', 'kota' => '-',      'total' => '-'],
            2020 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92'],
            2021 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92'],
            2022 => ['negara' => '11,75', 'provinsi' => '-', 'kota' => '180,17', 'total' => '191,92'],
            2023 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48'],
            2024 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48'],
            2025 => ['negara' => '8,18',  'provinsi' => '-', 'kota' => '198,3',  'total' => '206,48'],
        ];

        // Ambil data aktual dari tabel_opd_data jika ada
        $dbData = TabelData::where('table_code', '8.1.1')
            ->whereIn('year', $years)
            ->get();
        $dbMap = [];
        foreach ($dbData as $d) {
            $lbl = strtolower($d->row_label ?? '');
            $k = str_contains($lbl, 'negara') ? 'negara' : (str_contains($lbl, 'provinsi') ? 'provinsi' : (str_contains($lbl, 'kota') ? 'kota' : (str_contains($lbl, 'jumlah') ? 'total' : '')));
            if ($k) {
                $dbMap[$d->year][$k] = $d->value;
            }
        }

        $getVal = function($y, $key) use ($dbMap, $knownData) {
            if (isset($dbMap[$y][$key]) && $dbMap[$y][$key] !== '' && $dbMap[$y][$key] !== null) {
                return $dbMap[$y][$key];
            }
            if (isset($knownData[$y][$key])) {
                return $knownData[$y][$key];
            }
            return '-';
        };

        $thCols = '';
        $thNum = '';
        foreach ($years as $idx => $y) {
            $isCurr = ($y === $year);
            $activeClass = $isCurr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : '';
            $thCols .= "<th class=\"py-3 px-4 border border-slate-700 text-center {$activeClass}\">{$y}</th>";
            $colNum = $idx + 2;
            $thNum .= "<th class=\"py-1 px-3 border border-slate-700 text-center\">({$colNum})</th>";
        }

        $tdNegara = '';
        $tdProv = '';
        $tdKota = '';
        $tdTotal = '';
        foreach ($years as $y) {
            $isCurr = ($y === $year);
            $activeTd = $isCurr ? 'font-bold bg-amber-100/60' : '';
            $vNegara = $getVal($y, 'negara');
            $vProv = $getVal($y, 'provinsi');
            $vKota = $getVal($y, 'kota');
            $vTotal = $getVal($y, 'total');

            $tdNegara .= "<td class=\"py-2.5 px-3 border border-slate-700 " . ($vNegara === '-' ? 'text-center align-middle font-medium' : 'text-right font-semibold') . " {$activeTd}\">{$vNegara}</td>";
            $tdProv .= "<td class=\"py-2.5 px-3 border border-slate-700 text-center align-middle font-medium {$activeTd}\">{$vProv}</td>";
            $tdKota .= "<td class=\"py-2.5 px-3 border border-slate-700 " . ($vKota === '-' ? 'text-center align-middle font-medium' : 'text-right font-semibold') . " {$activeTd}\">{$vKota}</td>";
            $tdTotal .= "<td class=\"py-2.5 px-3 border border-slate-700 " . ($vTotal === '-' ? 'text-center align-middle' : 'text-right font-extrabold') . " " . ($isCurr ? 'bg-amber-200/80' : '') . "\">{$vTotal}</td>";
        }

        return "<thead>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
        <th class=\"py-3 px-4 font-bold border border-slate-700 text-left align-middle\">
            <div>Tingkat Kewenangan Pemerintahan</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Level of Government Authority</div>
        </th>
        {$thCols}
    </tr>
    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
        <th class=\"py-1 px-3 border border-slate-700 text-center\">(1)</th>
        {$thNum}
    </tr>
</thead>
<tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\">
            1. Negara / <span class=\"italic font-normal text-slate-700\">State</span>
        </td>
        {$tdNegara}
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\">
            2. Provinsi / <span class=\"italic font-normal text-slate-700\">Province</span>
        </td>
        {$tdProv}
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700 text-left\">
            3. Kota / <span class=\"italic font-normal text-slate-700\">Municipality</span>
        </td>
        {$tdKota}
    </tr>
    <tr class=\"bg-[#fed7aa] font-bold\">
        <td class=\"py-2.5 px-4 border border-slate-700 text-left font-bold text-slate-900\">
            Jumlah / <span class=\"italic font-bold\">Total</span>
        </td>
        {$tdTotal}
    </tr>
</tbody>";
    }

    /**
     * Membangun HTML tabel 8.1.3 (Panjang Jalan Menurut Kondisi Jalan) dengan rentang 5 tahun [year-4 .. year]
     */
    private function buildTabel813Html(int $year): string
    {
        $years = range($year - 4, $year);

        // Nilai acuan historis (dari data resmi PUPR / database)
        $knownData = [
            2020 => ['baik' => '-',      'sedang' => '-',     'rusak' => '-',     'rusak_berat' => '-',    'total' => '180,17'],
            2021 => ['baik' => '70,32',  'sedang' => '90,29', 'rusak' => '18,42', 'rusak_berat' => '1,14', 'total' => '180,17'],
            2022 => ['baik' => '94,34',  'sedang' => '69,37', 'rusak' => '15,83', 'rusak_berat' => '0,63', 'total' => '180,17'],
            2023 => ['baik' => '98,56',  'sedang' => '66,66', 'rusak' => '14,52', 'rusak_berat' => '0,43', 'total' => '198,3'],
            2024 => ['baik' => '151,56', 'sedang' => '29,78', 'rusak' => '8,44',  'rusak_berat' => '8,52', 'total' => '198,3'],
            2025 => ['baik' => '134,92', 'sedang' => '47,02', 'rusak' => '11,01', 'rusak_berat' => '5,35', 'total' => '198,3'],
        ];

        // Ambil data aktual dari tabel_opd_data jika ada
        $dbData = TabelData::where('table_code', '8.1.3')
            ->whereIn('year', $years)
            ->get();
        $dbMap = [];
        foreach ($dbData as $d) {
            $lbl = strtolower($d->row_label ?? '');
            $k = str_contains($lbl, 'berat') ? 'rusak_berat' : (str_contains($lbl, 'rusak') ? 'rusak' : (str_contains($lbl, 'sedang') ? 'sedang' : (str_contains($lbl, 'baik') ? 'baik' : (str_contains($lbl, 'jumlah') ? 'total' : ''))));
            if ($k) {
                $dbMap[$d->year][$k] = $d->value;
            }
        }

        $getVal = function($y, $key) use ($dbMap, $knownData) {
            if (isset($dbMap[$y][$key]) && $dbMap[$y][$key] !== '' && $dbMap[$y][$key] !== null) {
                return $dbMap[$y][$key];
            }
            if (isset($knownData[$y][$key])) {
                return $knownData[$y][$key];
            }
            return '-';
        };

        $thCols = '';
        $thNum = '';
        foreach ($years as $idx => $y) {
            $isCurr = ($y === $year);
            $activeClass = $isCurr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : '';
            $thCols .= "<th class=\"py-2 px-3 border border-slate-700 text-center {$activeClass}\">{$y}</th>";
            $colNum = $idx + 2;
            $thNum .= "<th class=\"py-1 px-3 border border-slate-700 text-center\">({$colNum})</th>";
        }

        $tdBaik = '';
        $tdSedang = '';
        $tdRusak = '';
        $tdRusakBerat = '';
        $tdTotal = '';
        foreach ($years as $y) {
            $isCurr = ($y === $year);
            $activeTd = $isCurr ? 'font-bold bg-amber-100/60' : '';
            $vBaik = $getVal($y, 'baik');
            $vSedang = $getVal($y, 'sedang');
            $vRusak = $getVal($y, 'rusak');
            $vRusakBerat = $getVal($y, 'rusak_berat');
            $vTotal = $getVal($y, 'total');

            $tdBaik .= "<td class=\"py-2.5 px-3 border border-slate-700 " . ($vBaik === '-' ? 'text-center align-middle font-medium' : 'text-right font-semibold') . " {$activeTd}\">{$vBaik}</td>";
            $tdSedang .= "<td class=\"py-2.5 px-3 border border-slate-700 " . ($vSedang === '-' ? 'text-center align-middle font-medium' : 'text-right font-semibold') . " {$activeTd}\">{$vSedang}</td>";
            $tdRusak .= "<td class=\"py-2.5 px-3 border border-slate-700 " . ($vRusak === '-' ? 'text-center align-middle font-medium' : 'text-right font-semibold') . " {$activeTd}\">{$vRusak}</td>";
            $tdRusakBerat .= "<td class=\"py-2.5 px-3 border border-slate-700 " . ($vRusakBerat === '-' ? 'text-center align-middle font-medium' : 'text-right font-semibold') . " {$activeTd}\">{$vRusakBerat}</td>";
            $tdTotal .= "<td class=\"py-2.5 px-3 border border-slate-700 " . ($vTotal === '-' ? 'text-center align-middle' : 'text-right font-extrabold') . " " . ($isCurr ? 'bg-amber-200/80' : '') . "\">{$vTotal}</td>";
        }

        return "<thead>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold\">
        <th class=\"py-3 px-4 font-bold border border-slate-700\" rowspan=\"2\">
            <div>Kondisi Jalan</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Road Condition</div>
        </th>
        <th class=\"py-2 px-3 font-bold border border-slate-700\" colspan=\"5\">
            <div>Tahun (km)</div>
            <div class=\"italic font-normal text-[11px] sm:text-xs\">Year (km)</div>
        </th>
    </tr>
    <tr class=\"bg-[#f95a00] text-white text-center font-bold text-xs sm:text-sm\">
        {$thCols}
    </tr>
    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs\">
        <th class=\"py-1 px-3 border border-slate-700\">(1)</th>
        {$thNum}
    </tr>
</thead>
<tbody class=\"bg-[#fef9c3] text-slate-900 font-medium\">
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700\">1. Baik / <span class=\"italic font-normal text-slate-700\">Good</span></td>
        {$tdBaik}
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700\">2. Sedang / <span class=\"italic font-normal text-slate-700\">Moderate</span></td>
        {$tdSedang}
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700\">3. Rusak / <span class=\"italic font-normal text-slate-700\">Damage</span></td>
        {$tdRusak}
    </tr>
    <tr>
        <td class=\"py-2.5 px-4 font-semibold border border-slate-700\">4. Rusak Berat / <span class=\"italic font-normal text-slate-700\">Severely Damage</span></td>
        {$tdRusakBerat}
    </tr>
    <tr class=\"bg-[#fed7aa] font-bold\">
        <td class=\"py-2.5 px-4 border border-slate-700\">Jumlah / <span class=\"italic font-bold\">Total</span></td>
        {$tdTotal}
    </tr>
</tbody>";
    }

    /**
     * Helper: Memuat Data Store dari Database MySQL
     */
    private function loadDbDataStore(string $tableCode, string $opdCode): array
    {
        $records = TabelData::where('table_code', $tableCode)
            ->where('opd_code', $opdCode)
            ->orderBy('year')
            ->orderBy('order_index')
            ->get();

        $store = [];
        foreach ($records as $rec) {
            $y = (int) $rec->year;
            if (!isset($store[$y])) {
                $store[$y] = [];
            }
            $store[$y][$rec->row_key] = $rec->value;
        }

        return $store;
    }
}
