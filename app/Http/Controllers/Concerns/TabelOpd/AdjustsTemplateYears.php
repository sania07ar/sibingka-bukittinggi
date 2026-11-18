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
 * Menyalin template tabel ke tahun lain dan menyesuaikan tahun pada judul/isi.
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait AdjustsTemplateYears
{
    /**
     * Otomatis membuat template kosong pada tahun-tahun lain di database jika belum ada data tersimpan
     */
    private function syncTemplateToOtherYears(string $tableCode, string $opdCode, int $sourceYear, string $html, ?string $titleId, ?string $titleEn, ?string $source, ?string $note, string $sourceType = 'template', string $type = 'opd'): void
    {
        // Khusus instansi RRI (tabel 8.2.7 / OPD 35), isian dan struktur tabel berbeda setiap tahun dan diisi via import Excel per tahun. Jangan sinkronkan template ke tahun lain.
        if ($opdCode === '35' || $tableCode === '8.2.7') {
            return;
        }

        if ($source) {
            $source = preg_replace('/^\s*(?:sumber\s*[\/:]\s*source|sumber\s*[\/:]|source\s*[\/:]|sumber|source)\s*:\s*/i', '', $source);
            $source = trim($source);
        }
        $years = range(2018, 2036);
        $cleanHtml = $this->buildEmptyTemplateFromHtml($html);
        $targetSourceType = match($type) {
            'bps' => 'custom_bps',
            'instansi' => 'custom_instansi',
            default => (in_array($sourceType, ['custom', 'custom_opd']) ? $sourceType : 'custom_opd')
        };

        foreach ($years as $targetYear) {
            if ($targetYear === $sourceYear) continue;

            $existing = TabelMetadata::where('table_code', $tableCode)
                ->where('opd_code', $opdCode)
                ->where('year', $targetYear)
                ->first();

            $isPlaceholder = false;
            if ($existing && !empty($existing->table_html)) {
                $htmlLower = strtolower($existing->table_html);
                if (str_contains($htmlLower, 'indicator details') || 
                    (str_contains($htmlLower, 'indikator 1') && str_contains($htmlLower, 'rincian indikator')) || 
                    str_contains($htmlLower, 'belum ada data untuk tabel ini')) {
                    $isPlaceholder = true;
                }
            }

            // Jika belum ada data atau table_html kosong, atau starter dummy, atau source_type template: isi template
            if (!$existing || empty($existing->table_html) || $existing->source_type === 'template' || $isPlaceholder) {
                $yHtml = $this->adjustYearInHtml($cleanHtml, $sourceYear, $targetYear);
                $yTitleId = $this->adjustYearInTitle($titleId, $sourceYear, $targetYear);
                $yTitleEn = $this->adjustYearInTitle($titleEn, $sourceYear, $targetYear);
                $yNote = $this->adjustYearInNote($note, $sourceYear, $targetYear);

                TabelMetadata::updateOrCreate(
                    [
                        'table_code' => $tableCode,
                        'opd_code' => $opdCode,
                        'year' => $targetYear,
                    ],
                    [
                        'title_id' => $yTitleId ?: ($existing?->title_id),
                        'title_en' => $yTitleEn ?: ($existing?->title_en),
                        'source' => $source ?: ($existing?->source),
                        'note' => $yNote !== null ? $yNote : ($existing?->note),
                        'table_html' => $yHtml,
                        'source_type' => $targetSourceType,
                        'is_saved' => true,
                    ]
                );
            }
        }
    }

    private function buildEmptyTemplateFromHtml(string $html): string
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $xpath = new \DOMXPath($dom);
        $tbodyRows = $xpath->query('//tbody/tr');

        foreach ($tbodyRows as $tr) {
            $tds = $xpath->query('td', $tr);
            foreach ($tds as $cIdx => $td) {
                if ($cIdx === 0) continue;
                $colspan = (int) $td->getAttribute('colspan');
                $rawText = trim($td->textContent);
                if ($colspan >= 2 && preg_match('/[a-zA-Z]{3,}/', $rawText)) continue;
                if ($td->hasAttribute('rowspan') && preg_match('/[a-zA-Z]{3,}/', $rawText)) continue;
                // Lindungi label tahun (misal: 2024, 2025, 2022(SIUP)) agar tidak diubah menjadi '-'
                // Hanya lindungi jika berada di kolom indeks <= 1 dan merupakan label, bukan data numerik
                if ($cIdx <= 1 && preg_match('/^(19|20)\d{2}(\s*\(SIUP\))?$/', $rawText)) {
                    $col0 = $tds->item(0);
                    $col0Text = $col0 ? trim($col0->textContent) : '';
                    if ($cIdx === 0 || preg_match('/(jumlah|total)/i', $col0Text) || $td->hasAttribute('rowspan') || $col0->hasAttribute('rowspan')) {
                        continue;
                    }
                }
                $isPureNumberOrDash = preg_match('/^[\d.,\s\-%–—()]+$/', $rawText) || $rawText === '';
                if ($isPureNumberOrDash) {
                    while ($td->hasChildNodes()) {
                        $td->removeChild($td->firstChild);
                    }
                    $span = $dom->createElement('span', '-');
                    $span->setAttribute('class', 'text-slate-400 font-normal');
                    $td->appendChild($span);
                    $cls = $td->getAttribute('class');
                    $cls = preg_replace('/\btext-(left|right)\b/', '', $cls) . ' text-center align-middle';
                    $td->setAttribute('class', trim($cls));
                }
            }
        }

        $div = $xpath->query('/div')->item(0);
        $clean = '';
        if ($div) {
            foreach ($div->childNodes as $child) {
                $clean .= $dom->saveHTML($child);
            }
        }
        return $clean ?: $html;
    }

    private function adjustYearInTitle(?string $title, int $sourceYear, int $targetYear): ?string
    {
        if (!$title) return $title;

        // Jika memuat newline, pisahkan dan proses tiap baris
        if (str_contains($title, "\n")) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $title))));
            $adjusted = array_map(function($line) use ($sourceYear, $targetYear) {
                return $this->adjustYearInTitle($line, $sourceYear, $targetYear);
            }, $lines);
            return implode("\n", $adjusted);
        }

        $delta = $targetYear - $sourceYear;

        // 1. Pola tahun ajaran sekolah (misal: "2024/2025" -> "2025/2026")
        if (preg_match('/\b(19\d{2}|20\d{2})\s*\/\s*(19\d{2}|20\d{2})\b/', $title)) {
            return preg_replace_callback('/\b(19\d{2}|20\d{2})\s*\/\s*(19\d{2}|20\d{2})\b/', function($m) use ($delta) {
                $y1 = (int)$m[1] + $delta;
                $y2 = (int)$m[2] + $delta;
                return "{$y1}/{$y2}";
            }, $title);
        }

        // 2. Pola rentang multi-tahun (misal: "2021–2025" atau "2021-2025")
        if (preg_match('/\b(19\d{2}|20\d{2})\s*[–\-]\s*(19\d{2}|20\d{2})\b/u', $title)) {
            return preg_replace_callback('/\b(19\d{2}|20\d{2})\s*[–\-]\s*(19\d{2}|20\d{2})\b/u', function($m) use ($delta) {
                $y1 = (int)$m[1] + $delta;
                $y2 = (int)$m[2] + $delta;
                return "{$y1}–{$y2}";
            }, $title);
        }

        // 3. Nama bulan sebelum tahun (misal: "Desember 2025" -> "Desember 2026")
        $monthPattern = '/\b(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|May|June|July|August|October|December)\s+' . $sourceYear . '\b/i';
        if (preg_match($monthPattern, $title)) {
            return preg_replace_callback($monthPattern, function($m) use ($targetYear) {
                $words = preg_split('/\s+/', $m[0]);
                return $words[0] . ' ' . $targetYear;
            }, $title);
        }

        // 4. Pola tahun tunggal di akhir: ", 2025" -> ", 2026"
        $pattern = '/,\s*' . $sourceYear . '\s*$/';
        if (preg_match($pattern, $title)) {
            return preg_replace($pattern, ", {$targetYear}", $title);
        }

        // 5. Ganti tahun 4 digit sumber jika cocok
        return str_replace((string)$sourceYear, (string)$targetYear, $title);
    }

    private function adjustYearInHtml(string $html, int $sourceYear, int $targetYear): string
    {
        $delta = $targetYear - $sourceYear;

        $adjustedHtml = preg_replace_callback('/<th([^>]*)>(.*?)<\/th>/is', function ($matches) use ($sourceYear, $targetYear, $delta) {
            $attr = $matches[1];
            $inner = $matches[2];

            // 1. Tahun ajaran: 2022/2023 -> 2023/2024
            if (preg_match('/\b(19\d{2}|20\d{2})\s*\/\s*(19\d{2}|20\d{2})\b/', $inner)) {
                $newInner = preg_replace_callback('/\b(19\d{2}|20\d{2})\s*\/\s*(19\d{2}|20\d{2})\b/', function($m) use ($delta) {
                    $y1 = (int)$m[1] + $delta;
                    $y2 = (int)$m[2] + $delta;
                    return "{$y1}/{$y2}";
                }, $inner);
                return "<th{$attr}>{$newInner}</th>";
            }

            // 2. Rentang tahun: 2021–2025 -> 2022–2026
            if (preg_match('/\b(19\d{2}|20\d{2})\s*[–\-]\s*(19\d{2}|20\d{2})\b/u', $inner)) {
                $newInner = preg_replace_callback('/\b(19\d{2}|20\d{2})\s*[–\-]\s*(19\d{2}|20\d{2})\b/u', function($m) use ($delta) {
                    $y1 = (int)$m[1] + $delta;
                    $y2 = (int)$m[2] + $delta;
                    return "{$y1}–{$y2}";
                }, $inner);
                return "<th{$attr}>{$newInner}</th>";
            }

            // 3. Tahun tunggal 4 digit di dalam <th>
            if (preg_match('/\b(19\d{2}|20\d{2})\b/', $inner, $m)) {
                $newInner = preg_replace_callback('/\b(19\d{2}|20\d{2})\b/', function($m) use ($delta) {
                    $y = (int)$m[0] + $delta;
                    return (string)$y;
                }, $inner);
                return "<th{$attr}>{$newInner}</th>";
            }

            return "<th{$attr}>{$inner}</th>";
        }, $html);

        // 2. tbody multi-year Jumlah / Total block updates
        try {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $adjustedHtml . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);

            $hasJumlahMultiYear = false;
            $tds = $xpath->query('//tbody//td');
            foreach ($tds as $td) {
                $text = strtolower(trim($td->textContent));
                if (str_starts_with($text, 'jumlah') || str_starts_with($text, 'total') || str_contains($text, 'jumlah / total') || str_contains($text, 'jumlah/total') || str_contains($text, 'jumlah / tota')) {
                    // Perbaiki teks jika terpotong menjadi "Jumlah / Tota"
                    if (str_contains($text, 'tota') && !str_contains($text, 'total')) {
                        while ($td->hasChildNodes()) {
                            $td->removeChild($td->firstChild);
                        }
                        $td->appendChild($dom->createTextNode('Jumlah / '));
                        $spanTot = $dom->createElement('span', 'Total');
                        $spanTot->setAttribute('class', 'italic font-bold');
                        $td->appendChild($spanTot);
                    }

                    $rowspan = (int) $td->getAttribute('rowspan');
                    if ($rowspan > 1) {
                        $hasJumlahMultiYear = true;
                        $tr = $td->parentNode;

                        // Kumpulkan baris-baris tahun historis yang terkait dengan blok Jumlah ini
                        $yearRows = [$tr];
                        $nextTr = $tr ? $tr->nextSibling : null;
                        while ($nextTr) {
                            if ($nextTr instanceof \DOMElement && $nextTr->nodeName === 'tr') {
                                $rTds = $xpath->query('td', $nextTr);
                                // Jika baris ini diawali angka tahun 4 digit (misal 2024, 2023, dst.)
                                if ($rTds->length > 0 && (preg_match('/^(19|20)\d{2}\*?(\s*\(SIUP\))?$/', trim($rTds->item(0)->textContent)) || trim($rTds->item(0)->textContent) === '-')) {
                                    $yearRows[] = $nextTr;
                                } else {
                                    break;
                                }
                            }
                            $nextTr = $nextTr->nextSibling;
                        }

                        // Jika jumlah baris tahun di HTML lebih besar dari rowspan (misal rowspan 5 padahal barisnya ada 6 seperti pada Tabel 11.1)
                        if (count($yearRows) > $rowspan) {
                            $rowspan = count($yearRows);
                            $td->setAttribute('rowspan', (string)$rowspan);
                        }

                        foreach ($yearRows as $i => $yTr) {
                            $rowTds = $xpath->query('td', $yTr);
                            $yearTd = null;
                            foreach ($rowTds as $rTd) {
                                if ($rTd !== $td && preg_match('/^(19|20)\d{2}\*?(\s*\(SIUP\))?$/', trim($rTd->textContent))) {
                                    $yearTd = $rTd;
                                    break;
                                }
                            }
                            if (!$yearTd) {
                                $yearTd = ($i === 0) ? $rowTds->item(1) : $rowTds->item(0);
                            }
                            if ($yearTd) {
                                $curTxt = trim($yearTd->textContent);
                                if (preg_match('/^(19|20)\d{2}\*?(\s*\(SIUP\))?$/', $curTxt) || $curTxt === '-' || $curTxt === '') {
                                    $y = $targetYear - $i;
                                    $yearTd->textContent = (string)$y;
                                }
                            }
                        }
                    } else {
                        // Tidak ada rowspan > 1. Periksa apakah memuat tahun (misal: "Jumlah / Total 2025" pada 5.1.16 & 5.1.17)
                        if (preg_match('/\b(19|20)\d{2}\b/', $td->textContent)) {
                            foreach ($td->childNodes as $node) {
                                if ($node->nodeType === XML_TEXT_NODE) {
                                    $node->nodeValue = preg_replace('/\b(19|20)\d{2}\b/', (string)$targetYear, $node->nodeValue);
                                } elseif ($node->nodeType === XML_ELEMENT_NODE) {
                                    $node->textContent = preg_replace('/\b(19|20)\d{2}\b/', (string)$targetYear, $node->textContent);
                                }
                            }
                            // Cari baris-baris tahun di atas baris Jumlah ini
                            $tr = $td->parentNode;
                            $prevTr = $tr->previousSibling;
                            $aboveYearTds = [];
                            while ($prevTr) {
                                if ($prevTr->nodeType === XML_ELEMENT_NODE) {
                                    $pTds = $xpath->query('td', $prevTr);
                                    if ($pTds->length > 0 && preg_match('/^(19|20)\d{2}$/', trim($pTds->item(0)->textContent))) {
                                        array_unshift($aboveYearTds, $pTds->item(0));
                                    } else {
                                        break;
                                    }
                                }
                                $prevTr = $prevTr->previousSibling;
                            }
                            if (count($aboveYearTds) > 0) {
                                $hasJumlahMultiYear = true;
                                $cnt = count($aboveYearTds);
                                foreach ($aboveYearTds as $idx => $aTd) {
                                    $aTd->textContent = (string)($targetYear - ($cnt - $idx));
                                }
                            }
                        }
                    }
                }
            }

            // 3. tbody baris-baris tahun historis tanpa rowspan Jumlah (misal Tabel 5.3.2, 5.3.3, 5.3.4)
            if (!$hasJumlahMultiYear) {
                $tbodyTrs = $xpath->query('//tbody//tr');
                $trList = iterator_to_array($tbodyTrs);
                $bottomYearTds = [];
                for ($r = count($trList) - 1; $r >= 0; $r--) {
                    $rowTds = $xpath->query('td', $trList[$r]);
                    if ($rowTds->length > 0) {
                        $firstTd = $rowTds->item(0);
                        $txt = trim($firstTd->textContent);
                        if (preg_match('/^(19|20)\d{2}\*?(\s*\(SIUP\))?$/', $txt)) {
                            array_unshift($bottomYearTds, $firstTd);
                        } else {
                            break;
                        }
                    }
                }
                if (count($bottomYearTds) >= 2) {
                    $firstY = (int) preg_replace('/\D/', '', trim($bottomYearTds[0]->textContent));
                    $lastY = (int) preg_replace('/\D/', '', trim($bottomYearTds[count($bottomYearTds) - 1]->textContent));
                    $isDesc = $firstY > $lastY;
                    $count = count($bottomYearTds);

                    // Cek apakah baris sebelum $bottomYearTds[0] adalah baris Jumlah/Total tahun target (misal Tabel 4.2.17)
                    $startOffset = 0;
                    $firstTr = $bottomYearTds[0]->parentNode;
                    $prevTr = $firstTr ? $firstTr->previousSibling : null;
                    while ($prevTr && !($prevTr instanceof \DOMElement && $prevTr->nodeName === 'tr')) {
                        $prevTr = $prevTr->previousSibling;
                    }
                    if ($prevTr) {
                        $prevText = trim($prevTr->textContent);
                        if (preg_match('/(jumlah|total)/i', $prevText)) {
                            $startOffset = 1;
                        }
                    }

                    foreach ($bottomYearTds as $idx => $td) {
                        $targetY = $isDesc ? ($targetYear - $startOffset - $idx) : ($targetYear - $startOffset - ($count - 1 - $idx));
                        $td->textContent = ($targetY <= 2019 && str_contains($td->textContent, '*')) ? "{$targetY}*" : (string)$targetY;
                    }
                }
            }

            $div = $xpath->query('/div')->item(0);
            if ($div) {
                $clean = '';
                foreach ($div->childNodes as $child) {
                    $clean .= $dom->saveHTML($child);
                }
                return $clean ?: $adjustedHtml;
            }
        } catch (\Exception $e) {}

        return $adjustedHtml;
    }

    private function adjustYearInNote(?string $note, int $sourceYear, int $targetYear): ?string
    {
        if (!$note) return $note;
        return str_replace((string)$sourceYear, (string)$targetYear, $note);
    }
}
