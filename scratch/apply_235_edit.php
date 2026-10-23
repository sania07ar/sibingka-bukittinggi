<?php

require __DIR__ . '/../vendor/autoload.php';

$editPath = __DIR__ . '/../resources/views/tabel/edit.blade.php';
$editContent = file_get_contents($editPath);

$jsUnits = file_get_contents(__DIR__ . '/js_units.js');

// 1. Schema 2.3.5 for edit.blade.php
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

// 1. Add schema before '        };'
$editContent = str_replace(
    "                }\n            }\n        };",
    "                }\n            }" . $schema235 . "\n        };",
    $editContent
);

// 2. Add transformToEditableGrid for 2.3.5
$editableGrid235 = <<<JS
            // Khusus Tabel 2.3.5: Kolom Unit Kerja adalah label tetap, input pada PNS, PPPK, dan Jumlah
            if (currentTableCode === '2.3.5') {
                rows.forEach(tr => {
                    const cells = tr.querySelectorAll('td');
                    const isTotal = tr.getAttribute('data-total') === 'true';
                    const key = tr.getAttribute('data-key');
                    cells.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        if ((key && idx === 0) || (isTotal && idx === 0)) {
                            td.classList.add('font-semibold');
                            return;
                        }
                        if (!td.querySelector('.table-edit-input')) {
                            let val = td.innerText.trim();
                            td.setAttribute('data-orig-val', val);
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="\${val}" style="text-align: center; font-weight: 600;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('change', () => persistTableData(false));
                            }
                        }
                    });
                });
                return;
            }

JS;

$editContent = str_replace(
    "            // Khusus Tabel 2.3.3 & 2.3.4:",
    $editableGrid235 . "            // Khusus Tabel 2.3.3 & 2.3.4:",
    $editContent
);

// 3. Add persistTableData for 2.3.5
$persistEdit235 = <<<JS
                } else if (currentTableCode === '2.3.5') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const key = tr.getAttribute('data-key');
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (key && inputs.length >= 2) {
                            rowsData[currentYear][`\${key}_pns`] = inputs[0].value.trim();
                            rowsData[currentYear][`\${key}_pppk`] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear][`\${key}_jml`] = inputs[2].value.trim();
                            } else {
                                const nPns = parseFloat(inputs[0].value.trim().replace(',', '.')) || 0;
                                const nPppk = parseFloat(inputs[1].value.trim().replace(',', '.')) || 0;
                                rowsData[currentYear][`\${key}_jml`] = (nPns + nPppk).toString();
                            }
                        } else if (tr.getAttribute('data-total') === 'true' && inputs.length >= 2) {
                            rowsData[currentYear]['total_pns'] = inputs[0].value.trim();
                            rowsData[currentYear]['total_pppk'] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear]['total_jml'] = inputs[2].value.trim();
                            }
                        }
                    });
JS;

$editContent = str_replace(
    "                } else if (currentTableCode === '2.3.3' || currentTableCode === '2.3.4') {",
    $persistEdit235 . "\n                } else if (currentTableCode === '2.3.3' || currentTableCode === '2.3.4') {",
    $editContent
);

// 4. Add downloadEditExcelTemplate for 2.3.5
$downloadEditTemplate235 = <<<JS
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

                    maxCol = 4;
                    ws['!cols'] = [
                        { wch: 65 }, // Unit Kerja
                        { wch: 18 }, // PNS
                        { wch: 18 }, // PPPK
                        { wch: 20 }  // Total
                    ];
JS;

$editContent = str_replace(
    "                    maxCol = 5;\n                    ws['!cols'] = [\n                        { wch: 14 },\n                        { wch: 44 },\n                        { wch: 16 },\n                        { wch: 16 },\n                        { wch: 18 }\n                    ];\n                } else {",
    "                    maxCol = 5;\n                    ws['!cols'] = [\n                        { wch: 14 },\n                        { wch: 44 },\n                        { wch: 16 },\n                        { wch: 16 },\n                        { wch: 18 }\n                    ];\n" . $downloadEditTemplate235 . "\n                } else {",
    $editContent
);

// 5. Add handleEditExcelImport for 2.3.5
$editImport235 = <<<JS
                    } else if (currentTableCode === '2.3.5') {
                        $jsUnits

                        const extractedUnits = {};

                        dataRows.forEach(row => {
                            const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase().replace(/\s+/g, ' ');
                            if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan') || rowStr.startsWith('note') || rowStr.startsWith('source')) return;

                            if (/jumlah\s*\/\s*total/i.test(rowStr) || (rowStr.includes('jumlah') && rowStr.includes('total'))) return;

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
                                extractedUnits[matchedKey] = { pns: pnsVal, pppk: pppkVal, jml: jmlVal };
                            }
                        });

                        trs.forEach(tr => {
                            const key = tr.getAttribute('data-key');
                            if (key && extractedUnits[key]) {
                                const inputs = tr.querySelectorAll('.table-edit-input');
                                if (inputs.length >= 2) {
                                    inputs[0].value = extractedUnits[key].pns;
                                    inputs[0].classList.add('bg-amber-100');
                                    inputs[1].value = extractedUnits[key].pppk;
                                    inputs[1].classList.add('bg-amber-100');
                                    if (inputs.length >= 3) {
                                        inputs[2].value = extractedUnits[key].jml;
                                        inputs[2].classList.add('bg-amber-100');
                                    }
                                    filledCount++;
                                }
                            }
                        });
JS;

$editContent = str_replace(
    "                    } else if (currentTableCode === '2.3.4') {",
    $editImport235 . "\n                    } else if (currentTableCode === '2.3.4') {",
    $editContent
);

file_put_contents($editPath, $editContent);
echo "edit.blade.php updated successfully!\n";
