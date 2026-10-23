<?php

require __DIR__ . '/../vendor/autoload.php';

$indexPath = __DIR__ . '/../resources/views/tabel/index.blade.php';
$editPath = __DIR__ . '/../resources/views/tabel/edit.blade.php';

$indexContent = file_get_contents($indexPath);
$editContent = file_get_contents($editPath);

$jsUnits = file_get_contents(__DIR__ . '/js_units.js');

// 1. Prepare Schema 2.3.5
$schema235 = <<<JS

            '2.3.5': {
                titleId: 'Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi (orang)',
                titleEn: 'Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement (people)',
                source: 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / <span class="italic text-slate-500">Human Resources and Development Agency of Bukittinggi Municipality</span>',
                note: (yr) => '<div>Data per-31 Desember ' + (yr || currentYear || '2025') + '</div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                    $jsUnits
                    let totPns = 0, totPppk = 0, totJml = 0;
                    let hasData = false;
                    let rowsHtml = '';

                    units235.forEach(u => {
                        const defPns = (yr === 2024 ? u.pns24 : (yr === 2025 ? u.pns25 : '-'));
                        const defPppk = (yr === 2024 ? u.pppk24 : (yr === 2025 ? u.pppk25 : '-'));

                        const pnsStr = (d[`\${u.key}_pns`] !== undefined && d[`\${u.key}_pns`] !== '') ? d[`\${u.key}_pns`] : defPns;
                        const pppkStr = (d[`\${u.key}_pppk`] !== undefined && d[`\${u.key}_pppk`] !== '') ? d[`\${u.key}_pppk`] : defPppk;

                        const numPns = parseFloat(String(pnsStr).replace(',', '.')) || 0;
                        const numPppk = parseFloat(String(pppkStr).replace(',', '.')) || 0;

                        const isPnsSet = (pnsStr !== '-' && pnsStr !== '');
                        const isPppkSet = (pppkStr !== '-' && pppkStr !== '');

                        if (isPnsSet || isPppkSet) {
                            hasData = true;
                        }

                        const rowJml = (isPnsSet || isPppkSet) ? (numPns + numPppk) : '-';

                        if (typeof rowJml === 'number') {
                            totPns += numPns;
                            totPppk += numPppk;
                            totJml += rowJml;
                        }

                        rowsHtml += `
                            <tr data-key="\${u.key}" class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-top">
                                    \${u.name}
                                </td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-top">\${pnsStr}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-top">\${pppkStr}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-100/70 align-top">\${rowJml}</td>
                            </tr>
                        `;
                    });

                    // Baris Total
                    rowsHtml += `
                        <tr data-total="true" class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
                            <td class="py-2.5 px-4 font-bold border border-slate-700 text-left">
                                <div>Jumlah</div>
                                <div class="italic font-normal text-xs text-slate-700">Total</div>
                            </td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">\${hasData ? totPns : '-'}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">\${hasData ? totPppk : '-'}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-200">\${hasData ? totJml : '-'}</td>
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-left w-[55%]">
                                    <div>Unit Kerja</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Placement</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[15%]">
                                    <div>PNS</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Civil Servant</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[15%]">
                                    <div>PPPK</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Employment Agreement</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 bg-amber-600 font-extrabold w-[15%]">
                                    <div>Jumlah</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-left">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center font-bold bg-amber-200/60">(4)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            \${rowsHtml}
                        </tbody>
                    `;
                }
            }
JS;

// 2. Prepare Template Download Block for 2.3.5
$downloadTemplate235 = <<<JS
            } else if (currentTableCode === '2.3.5') {
                titleId = `Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi, \${yr}`;
                titleEn = `Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement, \${yr}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1: Oranye BPS
                setCell(r, 0, 'Unit Kerja / Placement', headerOrangeStyle);
                setCell(r, 1, 'Pegawai Negeri Sipil (PNS) / Civil Servant', headerOrangeStyle);
                setCell(r, 2, 'Pegawai Pemerintah dengan Perjanjian Kerja (PPPK)', headerOrangeStyle);
                setCell(r, 3, 'Jumlah / Total (ASN)', headerOrangeStyle);
                r++;

                // Header Baris 2: Peach Penomoran Kolom (1) s.d (4)
                setCell(r, 0, '(1)', headerPeachStyle);
                setCell(r, 1, '(2)', headerPeachStyle);
                setCell(r, 2, '(3)', headerPeachStyle);
                setCell(r, 3, '(4)', headerPeachStyle);
                r++;

                $jsUnits

                const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                let totPns = 0, totPppk = 0, totJml = 0;
                let hasData = false;

                units235.forEach(u => {
                    const defPns = (yr === 2024 ? u.pns24 : (yr === 2025 ? u.pns25 : ''));
                    const defPppk = (yr === 2024 ? u.pppk24 : (yr === 2025 ? u.pppk25 : ''));

                    let pnsVal = (d[`\${u.key}_pns`] !== undefined && d[`\${u.key}_pns`] !== '') ? d[`\${u.key}_pns`] : defPns;
                    let pppkVal = (d[`\${u.key}_pppk`] !== undefined && d[`\${u.key}_pppk`] !== '') ? d[`\${u.key}_pppk`] : defPppk;

                    const hasPns = (pnsVal !== '' && pnsVal !== '-');
                    const hasPppk = (pppkVal !== '' && pppkVal !== '-');
                    if (hasPns || hasPppk) {
                        hasData = true;
                    }

                    const numPns = hasPns ? (parseFloat(String(pnsVal).replace(',', '.')) || 0) : '';
                    const numPppk = hasPppk ? (parseFloat(String(pppkVal).replace(',', '.')) || 0) : '';
                    const rowJml = (hasPns || hasPppk) ? ((numPns || 0) + (numPppk || 0)) : '';

                    if (numPns !== '') { totPns += numPns; }
                    if (numPppk !== '') { totPppk += numPppk; }
                    if (rowJml !== '') { totJml += rowJml; }

                    setCell(r, 0, u.name, dataCellStyle);
                    setCell(r, 1, (numPns !== '') ? numPns : (pnsVal || '-'), dataCenterStyle);
                    setCell(r, 2, (numPppk !== '') ? numPppk : (pppkVal || '-'), dataCenterStyle);
                    setCell(r, 3, (rowJml !== '') ? rowJml : '-', totalCenterStyle);
                    r++;
                });

                // Row Total
                setCell(r, 0, 'Jumlah / Total', headerPeachStyle);
                setCell(r, 1, hasData ? totPns : '-', totalCenterStyle);
                setCell(r, 2, hasData ? totPppk : '-', totalCenterStyle);
                setCell(r, 3, hasData ? totJml : '-', totalCenterStyle);
                r++;

                // Footer Catatan & Sumber
                r++;
                setCell(r, 0, `Catatan / Note: Data per-31 Desember \${yr}`, { font: { name: 'Calibri', sz: 9, italic: true } });
                r++;
                setCell(r, 0, 'Sumber / Source: Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / Human Resources and Development Agency of Bukittinggi Municipality', { font: { name: 'Calibri', sz: 9, italic: true } });

                maxCol = 4;
                ws['!cols'] = [
                    { wch: 65 }, // Unit Kerja
                    { wch: 18 }, // PNS
                    { wch: 18 }, // PPPK
                    { wch: 20 }  // Total
                ];
JS;

// 3. Prepare Excel Import for 2.3.5 (index.blade.php)
$excelImport235 = <<<JS
            } else if (currentTableCode === '2.3.5') {
                theadHtml = `<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700 text-left w-[55%]">
                            <div>Unit Kerja</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Placement</div>
                        </th>
                        <th class="py-3 px-4 font-bold border border-slate-700 w-[15%]">
                            <div>PNS</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Civil Servant</div>
                        </th>
                        <th class="py-3 px-4 font-bold border border-slate-700 w-[15%]">
                            <div>PPPK</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Employment Agreement</div>
                        </th>
                        <th class="py-3 px-4 font-bold border border-slate-700 bg-amber-600 font-extrabold w-[15%]">
                            <div>Jumlah</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                        </th>
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700 text-left">(1)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center font-bold bg-amber-200/60">(4)</th>
                    </tr>
                </thead>`;

                $jsUnits

                const extractedUnits235 = {};
                units235.forEach(u => {
                    extractedUnits235[u.key] = { pns: '-', pppk: '-', jml: '-' };
                });

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase().replace(/\s+/g, ' ');
                    if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan') || rowStr.startsWith('note') || rowStr.startsWith('source')) return;

                    if (/jumlah\s*\/\s*total/i.test(rowStr) || (rowStr.includes('jumlah') && rowStr.includes('total'))) {
                        return;
                    }

                    let matchedKey = null;

                    // 1. Cek nomor unit kerja (misal: 01. Sekretaris Daerah -> 1)
                    const mNum = (row[0] || '').toString().match(/^\s*0?(\d{1,2})\./);
                    if (mNum) {
                        const no = parseInt(mNum[1], 10);
                        if (no >= 1 && no <= 84) {
                            matchedKey = `unit_\${no}`;
                        }
                    }

                    // 2. Fallback pencocokan nama unit kerja
                    if (!matchedKey) {
                        for (const u of units235) {
                            const cleanUName = u.name.replace(/^\d+\.\s*/, '').toLowerCase().trim();
                            if (cleanUName.length > 4 && rowStr.includes(cleanUName)) {
                                matchedKey = u.key;
                                break;
                            }
                        }
                    }

                    if (matchedKey) {
                        const nums = row.filter(c => /^-?\d+([.,]\d+)?$/.test((c || '').toString().trim()));
                        const pnsVal = nums[0] !== undefined ? nums[0] : '0';
                        const pppkVal = nums[1] !== undefined ? nums[1] : '0';
                        const nPns = parseFloat(pnsVal.replace(',', '.')) || 0;
                        const nPppk = parseFloat(pppkVal.replace(',', '.')) || 0;
                        const jmlVal = nums[2] !== undefined ? nums[2] : (nPns + nPppk).toString();
                        extractedUnits235[matchedKey] = { pns: pnsVal, pppk: pppkVal, jml: jmlVal };
                    }
                });

                let totPns = 0, totPppk = 0, totJml = 0;
                let hasData = false;

                units235.forEach(u => {
                    const uData = extractedUnits235[u.key] || { pns: '-', pppk: '-', jml: '-' };
                    const nPns = parseFloat(String(uData.pns).replace(',', '.')) || 0;
                    const nPppk = parseFloat(String(uData.pppk).replace(',', '.')) || 0;
                    const isSet = (uData.pns !== '-' && uData.pns !== '') || (uData.pppk !== '-' && uData.pppk !== '');

                    if (isSet) {
                        hasData = true;
                        totPns += nPns;
                        totPppk += nPppk;
                        totJml += (nPns + nPppk);
                    }

                    const rowJmlStr = isSet ? (nPns + nPppk) : '-';

                    tbodyHtml += `
                        <tr data-key="\${u.key}" class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-top">
                                \${u.name}
                            </td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 align-top">\${uData.pns}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 align-top">\${uData.pppk}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-100/70 align-top">\${rowJmlStr}</td>
                        </tr>
                    `;
                });

                tbodyHtml += `
                    <tr data-total="true" class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
                        <td class="py-2.5 px-4 font-bold border border-slate-700 text-left">
                            <div>Jumlah</div>
                            <div class="italic font-normal text-xs text-slate-700">Total</div>
                        </td>
                        <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">\${hasData ? totPns : '-'}</td>
                        <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">\${hasData ? totPppk : '-'}</td>
                        <td class="py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-200">\${hasData ? totJml : '-'}</td>
                    </tr>
                </tbody>`;

                titleId = `Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi, \${currentYear}`;
                titleEn = `Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement, \${currentYear}`;
JS;

// Apply to index.blade.php
// 1. Add schema before '        };'
$indexContent = str_replace(
    "                }\n            }\n        };",
    "                }\n            }" . $schema235 . "\n        };",
    $indexContent
);

// 2. Add titleId in downloadExcelTemplate
$indexContent = str_replace(
    "titleEn = `Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people), \${yr}`;\n            }",
    "titleEn = `Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people), \${yr}`;\n            } else if (currentTableCode === '2.3.5') {\n                titleId = `Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi, \${yr}`;\n                titleEn = `Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement, \${yr}`;\n            }",
    $indexContent
);

// 3. Add template download branch
$indexContent = str_replace(
    "                    { wch: 18 }  // Total\n                ];\n            } else if (sourceTableHtml) {",
    "                    { wch: 18 }  // Total\n                ];\n" . $downloadTemplate235 . "\n            } else if (sourceTableHtml) {",
    $indexContent
);

// 4. Add generateTableFromExcel branch
$indexContent = str_replace(
    "titleEn = `Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people), \${currentYear}`;\n            } else {",
    "titleEn = `Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people), \${currentYear}`;\n" . $excelImport235 . "\n            } else {",
    $indexContent
);

// 5. Add persist data for 2.3.5 in index.blade.php
$persistIndex235 = <<<JS
                } else if (currentTableCode === '2.3.5') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const bodyRows = tableEl.querySelectorAll('tbody tr');
                        bodyRows.forEach(tr => {
                            const key = tr.getAttribute('data-key');
                            const tds = tr.querySelectorAll('td');
                            if (key && tds.length >= 4) {
                                rowsData[currentYear][`\${key}_pns`] = tds[1].innerText.trim();
                                rowsData[currentYear][`\${key}_pppk`] = tds[2].innerText.trim();
                                rowsData[currentYear][`\${key}_jml`] = tds[3].innerText.trim();
                            } else if (tr.getAttribute('data-total') === 'true' && tds.length >= 4) {
                                rowsData[currentYear]['total_pns'] = tds[1].innerText.trim();
                                rowsData[currentYear]['total_pppk'] = tds[2].innerText.trim();
                                rowsData[currentYear]['total_jml'] = tds[3].innerText.trim();
                            }
                        });
                    }
JS;

$indexContent = str_replace(
    "                                rowsData[currentYear]['total_jml'] = tds[3].innerText.trim();\n                            }\n                        });\n                    }\n                }",
    "                                rowsData[currentYear]['total_jml'] = tds[3].innerText.trim();\n                            }\n                        });\n                    }\n" . $persistIndex235 . "\n                }",
    $indexContent
);

file_put_contents($indexPath, $indexContent);
echo "index.blade.php updated successfully!\n";
