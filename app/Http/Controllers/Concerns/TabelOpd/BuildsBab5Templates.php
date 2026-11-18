<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

use App\Models\TabelMetadata;

/**
 * Trait untuk membangun template dan struktur tabel Bab 5 (Pertanian, Kehutanan, Peternakan, dan Perikanan).
 * Digunakan oleh TabelOpdController.
 */
trait BuildsBab5Templates
{
    /**
     * Membangun HTML bersih berstandar BPS untuk Tabel 5.1.1 (Luas Panen Tanaman Sayuran Menurut Kecamatan dan Jenis Tanaman).
     * Tabel terdiri dari 3 sub-tabel yang disusun vertikal:
     * 1. Bawang Daun, Bawang Merah, Buncis, Cabai Rawit (Kolom 1 s.d. 9)
     * 2. Kangkung, Labu Siam, Terung (Kolom 1, 10 s.d. 15)
     * 3. Tomat, Wortel, Cabai Keriting (Kolom 1, 16 s.d. 21)
     */
    public function buildTabel511Html(int $year = 2024, ?string $existingHtml = null): string
    {
        $y1 = $year - 1;
        $y2 = $year;

        $districts = [
            '01. Guguk Panjang',
            '02. Mandiangin Koto Selayan',
            '03. Aur Birugo Tigo Baleh',
            'Bukittinggi',
        ];

        // Format helper untuk sel
        $fmt = function($v) {
            $vStr = trim((string)$v);
            if ($vStr === '' || $vStr === '-' || $vStr === '–' || $vStr === '—') {
                return '<span class="text-slate-400 font-normal">-</span>';
            }
            return htmlspecialchars($vStr, ENT_QUOTES, 'UTF-8');
        };

        // Data resmi tahun 2024 dari spreadsheet BPS Kota Bukittinggi
        $official2024 = [
            'sec1' => [
                '01. Guguk Panjang'          => ['5', '4', '2', '5', '-', '-', '4', '4'],
                '02. Mandiangin Koto Selayan' => ['11', '9', '17', '11', '-', '-', '5', '7'],
                '03. Aur Birugo Tigo Baleh'  => ['18', '19', '8', '10', '1', '1', '-', '-'],
                'Bukittinggi'                 => ['34', '32', '27', '26', '1', '1', '9', '11'],
            ],
            'sec2' => [
                '01. Guguk Panjang'          => ['9', '6', '2', '1', '4', '4'],
                '02. Mandiangin Koto Selayan' => ['12', '12', '-', '-', '9', '8'],
                '03. Aur Birugo Tigo Baleh'  => ['-', '-', '-', '-', '6', '5'],
                'Bukittinggi'                 => ['21', '18', '-', '-', '19', '17'],
            ],
            'sec3' => [
                '01. Guguk Panjang'          => ['-', '-', '-', '-', '5', '5'],
                '02. Mandiangin Koto Selayan' => ['9', '10', '-', '-', '53', '29'],
                '03. Aur Birugo Tigo Baleh'  => ['7', '8', '8', '8', '23', '23'],
                'Bukittinggi'                 => ['16', '18', '8', '8', '81', '57'],
            ],
        ];

        // Ekstraksi data dari existingHtml jika ada
        $extractedSec1 = [];
        $extractedSec2 = [];
        $extractedSec3 = [];

        if (!empty($existingHtml)) {
            $tbHtml = preg_match('/<tbody[^>]*>(.*?)<\/tbody>/is', $existingHtml, $mTb) ? $mTb[1] : $existingHtml;
            preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $tbHtml, $trs);

            $currentSection = 1;
            foreach ($trs[1] as $tr) {
                // Lewati baris subheader di dalam tbody
                if (preg_match('/(?:Kecamatan|District|Kangkung|Tomat|Sayuran|Vegetables|subtable-)/i', $tr) &&
                    (preg_match('/(?:Water Spinach|Tomato|District|subtable-)/i', $tr) || str_contains($tr, '&nbsp;'))) {
                    if (stripos($tr, 'Kangkung') !== false) {
                        $currentSection = 2;
                    } elseif (stripos($tr, 'Tomat') !== false) {
                        $currentSection = 3;
                    }
                    continue;
                }

                // Lewati baris tahun numerik atau baris penomoran
                if (preg_match('/(?:20\d{2}|19\d{2})/', $tr) && preg_match_all('/<(?:td|th)[^>]*>(.*?)<\/(?:td|th)>/is', $tr, $mCells) && count($mCells[1]) >= 6) {
                    $firstCell = trim(strip_tags($mCells[1][0]));
                    if ($firstCell === '-' || $firstCell === '(1)' || $firstCell === '-1' || empty($firstCell)) {
                        continue;
                    }
                }

                preg_match_all('/<(?:td|th)[^>]*>(.*?)<\/(?:td|th)>/is', $tr, $cells);
                if (empty($cells[1])) continue;

                $texts = array_map(function($c) { return trim(strip_tags($c)); }, $cells[1]);
                $first = $texts[0] ?? '';

                $matchedDist = null;
                if (preg_match('/Guguk\s*Panjang/i', $first)) {
                    $matchedDist = '01. Guguk Panjang';
                } elseif (preg_match('/Mandiangin/i', $first)) {
                    $matchedDist = '02. Mandiangin Koto Selayan';
                } elseif (preg_match('/Aur\s*Birugo/i', $first)) {
                    $matchedDist = '03. Aur Birugo Tigo Baleh';
                } elseif (preg_match('/Bukittinggi/i', $first)) {
                    $matchedDist = 'Bukittinggi';
                }

                if ($matchedDist) {
                    $vals = array_slice($texts, 1);
                    if ($currentSection === 1) {
                        $extractedSec1[$matchedDist] = array_slice($vals, 0, 8);
                        if (count($extractedSec1) === 4) {
                            $currentSection = 2;
                        }
                    } elseif ($currentSection === 2) {
                        $extractedSec2[$matchedDist] = array_slice($vals, 0, 6);
                        if (count($extractedSec2) === 4) {
                            $currentSection = 3;
                        }
                    } else {
                        $extractedSec3[$matchedDist] = array_slice($vals, 0, 6);
                    }
                }
            }
        }

        // Tentukan data final
        $getSecData = function($secKey, $extracted) use ($year, $official2024, $districts) {
            $result = [];
            foreach ($districts as $d) {
                if (isset($extracted[$d]) && count($extracted[$d]) >= ($secKey === 'sec1' ? 8 : 6)) {
                    $result[$d] = $extracted[$d];
                } elseif ($year === 2024 && isset($official2024[$secKey][$d])) {
                    $result[$d] = $official2024[$secKey][$d];
                } else {
                    $colCount = ($secKey === 'sec1') ? 8 : 6;
                    $result[$d] = array_fill(0, $colCount, '-');
                }
            }
            return $result;
        };

        $dataSec1 = $getSecData('sec1', $extractedSec1);
        $dataSec2 = $getSecData('sec2', $extractedSec2);
        $dataSec3 = $getSecData('sec3', $extractedSec3);

        // Bangun HTML tabel
        $html = '<table class="w-full text-left text-xs sm:text-sm border-collapse table-custom-border" id="dataDisplayTable">' . "\n";

        // THEAD: Sub-tabel 1 (Bawang Daun, Bawang Merah, Buncis, Cabai Rawit)
        $html .= '<thead>' . "\n";
        $html .= '    <tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">' . "\n";
        $html .= '            <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">' . "\n";
        $html .= '            <div>Bawang Daun</div><div class="italic font-normal text-[11px] sm:text-xs">Scallion</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">' . "\n";
        $html .= '            <div>Bawang Merah</div><div class="italic font-normal text-[11px] sm:text-xs">Shallots</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">' . "\n";
        $html .= '            <div>Buncis</div><div class="italic font-normal text-[11px] sm:text-xs">String Bean</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '        <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">' . "\n";
        $html .= '            <div>Cabai Rawit</div><div class="italic font-normal text-[11px] sm:text-xs">Chili/ Cayenne Pepper</div>' . "\n";
        $html .= '        </th>' . "\n";
        $html .= '    </tr>' . "\n";

        $html .= '    <tr class="bg-[#f95a00] text-white text-center font-bold">' . "\n";
        for ($i = 0; $i < 4; $i++) {
            $html .= "        <th class=\"py-2.5 px-3 font-bold border border-slate-700\"><div>{$y1}</div></th>\n";
            $html .= "        <th class=\"py-2.5 px-3 font-bold border border-slate-700\"><div>{$y2}</div></th>\n";
        }
        $html .= '    </tr>' . "\n";

        $html .= '    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">' . "\n";
        for ($i = 1; $i <= 9; $i++) {
            $html .= "        <th class=\"py-1 px-3 border border-slate-700\">({$i})</th>\n";
        }
        $html .= '    </tr>' . "\n";
        $html .= '</thead>' . "\n";

        // TBODY
        $html .= '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">' . "\n";

        // 1. Data Sub-tabel 1
        foreach ($districts as $d) {
            $isTotal = ($d === 'Bukittinggi');
            $rowClass = $isTotal
                ? 'bg-[#fed7aa] font-bold text-slate-900 border-t border-slate-700'
                : 'hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium';
            $cellClass = $isTotal ? ' font-bold' : '';

            $html .= "    <tr class=\"{$rowClass}\">\n";
            $html .= "        <td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle{$cellClass}\">{$d}</td>\n";
            foreach ($dataSec1[$d] as $val) {
                $html .= "        <td class=\"py-2.5 px-4 border border-slate-700 text-center align-middle text-right font-medium{$cellClass}\">" . $fmt($val) . "</td>\n";
            }
            $html .= "    </tr>\n";
        }

        // 2. Baris Pemisah 1
        $html .= "    <tr class=\"subtable-spacer-row pointer-events-none select-none\">\n";
        $html .= "        <td colspan=\"9\" class=\"h-6 sm:h-8 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center\">&nbsp;</td>\n";
        $html .= "    </tr>\n";

        // 3. Header Sub-tabel 2 (Kangkung, Labu Siam, Terung)
        $html .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold subtable-header-title\">\n";
        $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" rowspan=\"2\">\n";
        $html .= "            <div>Kecamatan</div><div class=\"italic font-normal text-[11px] sm:text-xs\">District</div>\n";
        $html .= "        </th>\n";
        $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"2\">\n";
        $html .= "            <div>Kangkung</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Water Spinach</div>\n";
        $html .= "        </th>\n";
        $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"2\">\n";
        $html .= "            <div>Labu Siam</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Chayote</div>\n";
        $html .= "        </th>\n";
        $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"2\">\n";
        $html .= "            <div>Terung</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Eggplant</div>\n";
        $html .= "        </th>\n";
        $html .= "        <th class=\"border border-slate-700 bg-slate-200/50\" colspan=\"2\" rowspan=\"3\"></th>\n";
        $html .= "    </tr>\n";

        $html .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years\">\n";
        for ($i = 0; $i < 3; $i++) {
            $html .= "        <th class=\"py-2.5 px-3 font-bold border border-slate-700 text-center align-middle text-xs\"><div>{$y1}</div></th>\n";
            $html .= "        <th class=\"py-2.5 px-3 font-bold border border-slate-700 text-center align-middle text-xs\"><div>{$y2}</div></th>\n";
        }
        $html .= "    </tr>\n";

        $html .= "    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering\">\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(1)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(10)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(11)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(12)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(13)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(14)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(15)</th>\n";
        $html .= "    </tr>\n";

        // 4. Data Sub-tabel 2
        foreach ($districts as $d) {
            $isTotal = ($d === 'Bukittinggi');
            $rowClass = $isTotal
                ? 'bg-[#fed7aa] font-bold text-slate-900 border-t border-slate-700'
                : 'hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium';
            $cellClass = $isTotal ? ' font-bold' : '';

            $html .= "    <tr class=\"{$rowClass}\">\n";
            $html .= "        <td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle{$cellClass}\">{$d}</td>\n";
            foreach ($dataSec2[$d] as $val) {
                $html .= "        <td class=\"py-2.5 px-4 border border-slate-700 text-center align-middle text-right font-medium{$cellClass}\">" . $fmt($val) . "</td>\n";
            }
            $html .= "        <td colspan=\"2\" class=\"border border-slate-700 bg-slate-100/40 text-center text-slate-300 font-normal\"><span class=\"text-slate-400 font-normal\">-</span></td>\n";
            $html .= "    </tr>\n";
        }

        // 5. Baris Pemisah 2
        $html .= "    <tr class=\"subtable-spacer-row pointer-events-none select-none\">\n";
        $html .= "        <td colspan=\"9\" class=\"h-6 sm:h-8 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center\">&nbsp;</td>\n";
        $html .= "    </tr>\n";

        // 6. Header Sub-tabel 3 (Tomat, Wortel, Cabai Keriting)
        $html .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold subtable-header-title\">\n";
        $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" rowspan=\"2\">\n";
        $html .= "            <div>Kecamatan</div><div class=\"italic font-normal text-[11px] sm:text-xs\">District</div>\n";
        $html .= "        </th>\n";
        $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"2\">\n";
        $html .= "            <div>Tomat</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Tomato</div>\n";
        $html .= "        </th>\n";
        $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"2\">\n";
        $html .= "            <div>Wortel</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Carrot</div>\n";
        $html .= "        </th>\n";
        $html .= "        <th class=\"py-3 px-4 font-bold border border-slate-700 text-center align-middle\" colspan=\"2\">\n";
        $html .= "            <div>Cabai Keriting</div><div class=\"italic font-normal text-[11px] sm:text-xs\">Chilli/ Curly chilli</div>\n";
        $html .= "        </th>\n";
        $html .= "        <th class=\"border border-slate-700 bg-slate-200/50\" colspan=\"2\" rowspan=\"3\"></th>\n";
        $html .= "    </tr>\n";

        $html .= "    <tr class=\"bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years\">\n";
        for ($i = 0; $i < 3; $i++) {
            $html .= "        <th class=\"py-2.5 px-3 font-bold border border-slate-700 text-center align-middle text-xs\"><div>{$y1}</div></th>\n";
            $html .= "        <th class=\"py-2.5 px-3 font-bold border border-slate-700 text-center align-middle text-xs\"><div>{$y2}</div></th>\n";
        }
        $html .= "    </tr>\n";

        $html .= "    <tr class=\"bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering\">\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(1)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(16)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(17)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(18)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(19)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(20)</th>\n";
        $html .= "        <th class=\"py-1 px-3 border border-slate-700 text-center font-bold text-xs\">(21)</th>\n";
        $html .= "    </tr>\n";

        // 7. Data Sub-tabel 3
        foreach ($districts as $d) {
            $isTotal = ($d === 'Bukittinggi');
            $rowClass = $isTotal
                ? 'bg-[#fed7aa] font-bold text-slate-900 border-t border-slate-700'
                : 'hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium';
            $cellClass = $isTotal ? ' font-bold' : '';

            $html .= "    <tr class=\"{$rowClass}\">\n";
            $html .= "        <td class=\"py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle{$cellClass}\">{$d}</td>\n";
            foreach ($dataSec3[$d] as $val) {
                $html .= "        <td class=\"py-2.5 px-4 border border-slate-700 text-center align-middle text-right font-medium{$cellClass}\">" . $fmt($val) . "</td>\n";
            }
            $html .= "        <td colspan=\"2\" class=\"border border-slate-700 bg-slate-100/40 text-center text-slate-300 font-normal\"><span class=\"text-slate-400 font-normal\">-</span></td>\n";
            $html .= "    </tr>\n";
        }

        $html .= '</tbody>' . "\n";
        $html .= '</table>';

        return $html;
    }
}
