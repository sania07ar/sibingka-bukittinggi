/** SiBingka - Skema tabel (tampilan / index): 9.1, 4.1.24, 4.2.2, 4.2.4, 4.2.5, 4.2.6, 4.2.7, 4.2.9, 4.2.10, 4.2.12, 4.2.13, 4.2.14, 4.2.15, 4.1.20, 4.3.4 */
Object.assign(window.tableSchemas, {
            '9.1': {
                titleId: 'Jumlah Koperasi Aktif Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Active Cooperative in Bukittinggi Municipality',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const dataStore = {
                        2020: { guguk_panjang: '54', mandiangin_koto_selayan: '17', aur_birugo_tigo_baleh: '23', bukittinggi: '94' },
                        2021: { guguk_panjang: '54', mandiangin_koto_selayan: '17', aur_birugo_tigo_baleh: '24', bukittinggi: '95' },
                        2022: { guguk_panjang: '53', mandiangin_koto_selayan: '17', aur_birugo_tigo_baleh: '24', bukittinggi: '94' },
                        2023: { guguk_panjang: '52', mandiangin_koto_selayan: '15', aur_birugo_tigo_baleh: '27', bukittinggi: '94' },
                        2024: { guguk_panjang: '57', mandiangin_koto_selayan: '25', aur_birugo_tigo_baleh: '31', bukittinggi: '113' },
                        2025: { guguk_panjang: '62', mandiangin_koto_selayan: '30', aur_birugo_tigo_baleh: '36', bukittinggi: '128' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) {
                            if (serverDbDataStore[y][key] !== undefined) return serverDbDataStore[y][key];
                            if (key === 'bukittinggi' && serverDbDataStore[y]['total'] !== undefined) return serverDbDataStore[y]['total'];
                        }
                        if (dataStore[y]) {
                            if (dataStore[y][key] !== undefined) return dataStore[y][key];
                            if (key === 'bukittinggi' && dataStore[y]['total'] !== undefined) return dataStore[y]['total'];
                        }
                        return '-';
                    };

                    const rows = [
                        { label: '01. Guguk Panjang', key: 'guguk_panjang' },
                        { label: '02. Mandiangin Koto Selayan', key: 'mandiangin_koto_selayan' },
                        { label: '03. Aur Birugo Tigo Baleh', key: 'aur_birugo_tigo_baleh' }
                    ];

                    const rowsHtml = rows.map(r => `
                        <tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">${r.label}</td>
                            ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, r.key)}</td>`).join('')}
                        </tr>
                    `).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Subdistrict</div>
                                </th>
                                ${years.map(y => `<th class="py-3 px-4 border border-slate-700 text-center ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                ${years.map((y, idx) => `<th class="py-1 px-3 border border-slate-700 text-center">(${idx + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-extrabold">Bukittinggi</td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 font-extrabold ${y === yr ? 'bg-amber-200/80 ring-1 ring-amber-400' : ''}">${getVal(y, 'bukittinggi')}</td>`).join('')}
                            </tr>
                        </tbody>
                    `;
                }
            },
                                    '4.1.24': {
                titleId: 'Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi',
                titleEn: 'Number of Library Institutions, Collections, and Library Visitors in the City of Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Perpustakaan dan Kearsipan Kota Bukittinggi / <span class="italic text-slate-500">Library and Archives Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const officialData = {
                        2025: {
                            umum: ['21', '38460', '52776', '24123'],
                            sd_mi: ['62', '309610', '4341086', '387320'],
                            smp_mts: ['19', '52104', '567268', '173524'],
                            sma_smk_ma: ['26', '44085', '714152', '34782'],
                            perguruan_tinggi: ['19', '25103', '15721', '10926'],
                            taman_bacaan: ['11', '872', '1245', '2764'],
                            total: ['158', '470234', '5692248', '633439']
                        }
                    };

                    const yrData = officialData[yr] || {};

                    const getVal = (rowKey, colIdx, colName) => {
                        const dbKey = `${rowKey}_${colName}`;
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][dbKey] !== undefined) {
                            return serverDbDataStore[yr][dbKey];
                        }
                        if (isFuture) {
                            return '-';
                        }
                        if (yrData[rowKey] && yrData[rowKey][colIdx] !== undefined) {
                            return yrData[rowKey][colIdx];
                        }
                        return '-';
                    };

                    const rows = [
                        { key: 'umum', label: 'Umum / <span class="italic font-normal text-slate-600">General</span>' },
                        { key: 'sd_mi', label: 'SD / <span class="italic font-normal text-slate-600">MI / Primary School</span>' },
                        { key: 'smp_mts', label: 'SMP / <span class="italic font-normal text-slate-600">MTs / Junior High School</span>' },
                        { key: 'sma_smk_ma', label: 'SMA / <span class="italic font-normal text-slate-600">SMK/MA / Senior High School</span>' },
                        { key: 'perguruan_tinggi', label: 'Perguruan Tinggi / <span class="italic font-normal text-slate-600">College</span>' },
                        { key: 'taman_bacaan', label: 'Taman Bacaan / <span class="italic font-normal text-slate-600">Perpustakaan Masyarakat / Public Library</span>' },
                        { key: 'total', label: 'Jumlah / Total', isTotal: true }
                    ];

                    const rowsHtml = rows.map(r => {
                        const isTot = r.isTotal;
                        const rowCls = isTot ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
                        const tdCls = isTot ? 'font-bold' : '';
                        const vPerpus = getVal(r.key, 0, 'perpus');
                        const vJudul = getVal(r.key, 1, 'judul');
                        const vEks = getVal(r.key, 2, 'eksemplar');
                        const vPengunjung = getVal(r.key, 3, 'pengunjung');

                        const fmt = (v) => (v === '' || v === '-') ? '<span class="text-slate-400 font-normal">-</span>' : v;

                        return `
                            <tr class="${rowCls}" data-key="${r.key}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle">${r.label}</td>
                                <td class="py-2.5 px-3 border border-slate-700 text-center align-middle ${tdCls}">${fmt(vPerpus)}</td>
                                <td class="py-2.5 px-3 border border-slate-700 text-center align-middle ${tdCls}">${fmt(vJudul)}</td>
                                <td class="py-2.5 px-3 border border-slate-700 text-center align-middle ${tdCls}">${fmt(vEks)}</td>
                                <td class="py-2.5 px-3 border border-slate-700 text-center align-middle ${tdCls}">${fmt(vPengunjung)}</td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jenis Perpustakaan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Library</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah Perpustakaan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Library</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Jumlah Koleksi</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Collection</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah Pengunjung</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Visitor</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2 px-3 font-bold border border-slate-700">
                                    <div>Judul</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Title</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700">
                                    <div>Eksemplar</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Copies</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                                <th class="py-1 px-3 border border-slate-700">(5)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.2': {
                titleId: 'Jumlah Tenaga Kesehatan Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Health Human Resources by District in Bukittinggi Municipality',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'DINAS KESEHATAN Kota Bukittinggi / <span class="italic text-slate-500">Bukittinggi Municipality Health Office</span>',
                note: '<div class="space-y-1"><div><sup>1</sup> Tenaga medis terdiri atas dokter, dokter gigi, dokter spesialis, dan dokter gigi spesialis baik di dalam maupun di luar negeri yang diakui oleh Pemerintah RI sesuai dengan peraturan perundang-undangan (UU No. 29 Tahun 2004 tentang Praktik Kedokteran)</div><div class="italic text-slate-500">/ Medical worker includes doctor, dentist, medical specialist, and dentist specialist at home and abroad recognized by Indonesian government in accordance with the laws and regulations (Law No. 29 year 2004 about Medical Practice)</div></div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const officialData = {
                        2024: {
                            guguk: [12, 0, 20, 17, 5, 10, 3, 2, 0, 2, 0, 0],
                            mks: [48, 0, 120, 62, 40, 85, 6, 21, 1, 17, 0, 0],
                            abtb: [211, 2, 546, 85, 205, 32, 21, 33, 29, 93, 86, 0],
                            total: [271, 2, 686, 164, 250, 127, 30, 56, 30, 112, 86, 0]
                        },
                        2025: {
                            guguk: [153, 1, 197, 69, 72, 21, 10, 16, 13, 53, 90, 0],
                            mks: [25, 0, 167, 40, 35, 8, 6, 8, 8, 14, 19, 0],
                            abtb: [211, 2, 546, 85, 205, 32, 21, 33, 29, 93, 86, 0],
                            total: [389, 3, 910, 194, 312, 61, 37, 57, 50, 160, 195, 0]
                        }
                    };
                    const yrData = officialData[yr] || {};
                    const getVal = (rowKey, colIdx) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][`${rowKey}_col${colIdx}`] !== undefined) {
                            return serverDbDataStore[yr][`${rowKey}_col${colIdx}`];
                        }
                        if (yrData[rowKey] && yrData[rowKey][colIdx] !== undefined) {
                            return yrData[rowKey][colIdx];
                        }
                        return isFuture ? '<span class="text-slate-400 font-normal">-</span>' : '-';
                    };

                    const rows = [
                        { key: 'guguk', name: '01. Guguk Panjang' },
                        { key: 'mks', name: '02. Mandiangin Koto Selayan' },
                        { key: 'abtb', name: '03. Aur Birugo Tigo Baleh' }
                    ];

                    let rowsHtml = '';
                    rows.forEach(r => {
                        let cells = `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">${r.name}</td>`;
                        for (let i = 0; i < 12; i++) {
                            const val = getVal(r.key, i);
                            cells += `<td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${val}</td>`;
                        }
                        rowsHtml += `<tr class="hover:bg-amber-100/60 transition-colors">${cells}</tr>`;
                    });

                    // Baris Total / Jumlah
                    let totalCells = `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Jumlah / <span class="italic font-bold">Total</span></td>`;
                    for (let i = 0; i < 12; i++) {
                        const val = getVal('total', i);
                        totalCells += `<td class="py-2.5 px-4 border border-slate-700 text-center align-middle font-extrabold">${val}</td>`;
                    }
                    rowsHtml += `<tr class="bg-[#fed7aa] font-bold">${totalCells}</tr>`;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Medis<sup>1</sup></div><div class="italic font-normal text-[11px] sm:text-xs">Medical Worker<sup>1</sup></div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Psikologi Klinis</div><div class="italic font-normal text-[11px] sm:text-xs">Clinical Psychology</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Keperawatan</div><div class="italic font-normal text-[11px] sm:text-xs">Nursing Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kebidanan</div><div class="italic font-normal text-[11px] sm:text-xs">Midwifery Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kefarmasian</div><div class="italic font-normal text-[11px] sm:text-xs">Pharmaceutical Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kesehatan Masyarakat</div><div class="italic font-normal text-[11px] sm:text-xs">Public Health Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kesehatan Lingkungan</div><div class="italic font-normal text-[11px] sm:text-xs">Environmental Health Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Gizi</div><div class="italic font-normal text-[11px] sm:text-xs">Nutritionist</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Keterapian Fisik</div><div class="italic font-normal text-[11px] sm:text-xs">Physical Therapists</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Keteknisan Medis</div><div class="italic font-normal text-[11px] sm:text-xs">Medical Technicians</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Teknik Biomedika</div><div class="italic font-normal text-[11px] sm:text-xs">Biomedical Engineer</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kesehatan Tradisional</div><div class="italic font-normal text-[11px] sm:text-xs">Traditional Health Worker</div>
                                </th>
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
                                <th class="py-1 px-3 border border-slate-700">(10)</th>
                                <th class="py-1 px-3 border border-slate-700">(11)</th>
                                <th class="py-1 px-3 border border-slate-700">(12)</th>
                                <th class="py-1 px-3 border border-slate-700">(13)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.4': {
                titleId: 'Jumlah Tempat Tidur Pada Rumah Sakit Pemerintah dan Swasta di Kota Bukittinggi',
                titleEn: 'Number of Beds at Government and Private Hospital in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Kesehatan Kota Bukittinggi / <span class="italic text-slate-500">Public Health Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2019: { pemerintah: '536', swasta: '206', total: '742' },
                        2020: { pemerintah: '536', swasta: '206', total: '742' },
                        2021: { pemerintah: '550', swasta: '210', total: '760' },
                        2022: { pemerintah: '550', swasta: '210', total: '760' },
                        2023: { pemerintah: '559', swasta: '207', total: '766' },
                        2024: { pemerintah: '696', swasta: '196', total: '892' },
                        2025: { pemerintah: '696', swasta: '196', total: '892' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (officialData[y] && officialData[y][key] !== undefined) {
                            return officialData[y][key];
                        }
                        return '-';
                    };

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vPem = getVal(y, 'pemerintah');
                        const vSwa = getVal(y, 'swasta');
                        let vTot = getVal(y, 'total');
                        if (vTot === '-' && vPem !== '-' && vSwa !== '-') {
                            const nPem = parseFloat(vPem.replace(',', '.')) || 0;
                            const nSwa = parseFloat(vSwa.replace(',', '.')) || 0;
                            vTot = (nPem + nSwa).toString();
                        }
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vPem}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vSwa}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle font-bold ${isCurrent ? 'bg-amber-100/60' : ''}">${vTot}</td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Pemerintah</div><div class="italic font-normal text-[11px] sm:text-xs">Government</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.5': {
                titleId: 'Jumlah Pengunjung Pada Rumah Sakit Pemerintah dan Swasta di Kota Bukittinggi',
                titleEn: 'Number of Visitor at Hospital Government and Private in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Kesehatan Kota Bukittinggi / <span class="italic text-slate-500">Public Health Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2019: { pemerintah: '134841', swasta: '288153', total: '422994' },
                        2020: { pemerintah: '154371', swasta: '304479', total: '458850' },
                        2021: { pemerintah: '101276', swasta: '211187', total: '312463' },
                        2022: { pemerintah: '170506', swasta: '169637', total: '340143' },
                        2023: { pemerintah: '199642', swasta: '227969', total: '427611' },
                        2024: { pemerintah: '205631', swasta: '234808', total: '440439' },
                        2025: { pemerintah: '211800', swasta: '241852', total: '453652' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (officialData[y] && officialData[y][key] !== undefined) {
                            return officialData[y][key];
                        }
                        return '-';
                    };

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vPem = getVal(y, 'pemerintah');
                        const vSwa = getVal(y, 'swasta');
                        let vTot = getVal(y, 'total');
                        if (vTot === '-' && vPem !== '-' && vSwa !== '-') {
                            const nPem = parseFloat(String(vPem).replace(',', '.')) || 0;
                            const nSwa = parseFloat(String(vSwa).replace(',', '.')) || 0;
                            vTot = (nPem + nSwa).toString();
                        }
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vPem}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vSwa}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle font-bold ${isCurrent ? 'bg-amber-100/60' : ''}">${vTot}</td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Pemerintah</div><div class="italic font-normal text-[11px] sm:text-xs">Government</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.6': {
                titleId: 'Jumlah Kasus Penyakit Terbanyak di Kota Bukittinggi',
                titleEn: 'Number of Most Case of Disease in Bukittinggi Municipality',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Kesehatan Kota Bukittinggi / <span class="italic text-slate-500">Public Health Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const histData = {
                        2025: [
                            ['01. Hipertensi / Hypertension', '12478'],
                            ['02. ISPA / Acute Respiratory Infection', '5618'],
                            ['03. Common Cold', '4999'],
                            ['04. Necrosis of pulp', '3360'],
                            ['05. Low vision', '2970'],
                            ['06. Diabetes Mellitus', '2904'],
                            ['07. Dispepsia / Dyspepsia', '1525'],
                            ['08. Respiratory infection', '1487'],
                            ['09. Faringitis / Pharyngitis', '1479'],
                            ['10. Diabetes Mellitus komplikasi / Complicated Diabetes', '584'],
                            ['total', '37404']
                        ],
                        2024: [
                            ['01. Hipertensi / Hypertension', '11083'],
                            ['02. ISPA / Acute Respiratory Infection', '5576'],
                            ['03. Common Cold', '4849'],
                            ['04. Low vision', '3565'],
                            ['05. Necrosis of pulp', '2761'],
                            ['06. Diabetes Mellitus', '2664'],
                            ['07. Dispepsia / Dyspepsia', '942'],
                            ['08. Pulpitis', '825'],
                            ['09. Diabetes Mellitus komplikasi / Complicated Diabetes', '641'],
                            ['10. Faringitis / Pharyngitis', '310'],
                            ['total', '33216']
                        ],
                        2023: [
                            ['01. Hipertensi / Hypertension', '9696'],
                            ['02. Common Cold', '4445'],
                            ['03. Diabetes Mellitus', '3437'],
                            ['04. ISPA / Acute Respiratory Infection', '2087'],
                            ['05. Hipertensive Heart Disease', '1921'],
                            ['06. Congestive Heart Failure', '1848'],
                            ['07. Respiratory Disorder', '1406'],
                            ['08. Gastritis', '1079'],
                            ['09. Low vision', '413'],
                            ['10. Dispepsia / Dyspepsia', '343'],
                            ['total', '26675']
                        ]
                    };

                    const stdDiseases = [
                        '01. Hipertensi / Hypertension',
                        '02. ISPA / Acute Respiratory Infection',
                        '03. Common Cold',
                        '04. Necrosis of pulp',
                        '05. Low vision',
                        '06. Diabetes Mellitus',
                        '07. Dispepsia / Dyspepsia',
                        '08. Respiratory infection',
                        '09. Faringitis / Pharyngitis',
                        '10. Diabetes Mellitus komplikasi / Complicated Diabetes'
                    ];

                    let items = [];
                    let totVal = '-';
                    if (histData[yr]) {
                        items = histData[yr].slice(0, 10).map(x => ({ name: x[0], val: x[1] }));
                        totVal = histData[yr][10] ? histData[yr][10][1] : '-';
                    } else {
                        items = stdDiseases.map(d => ({ name: d, val: '-' }));
                    }

                    const rowsHtml = items.map(it => `
                        <tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle">${it.name}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 align-middle">${it.val}</td>
                        </tr>
                    `).join('') + `
                        <tr class="bg-amber-100/80 font-bold">
                            <td class="py-2.5 px-4 border border-slate-700 text-left align-middle uppercase">Jumlah / Total</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 align-middle">${totVal}</td>
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Penyakit</div><div class="italic font-normal text-[11px] sm:text-xs">Desease</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.7': {
                titleId: 'Banyak Lahir Hidup, lahir Mati, dan Kematian Ibu Sewaktu Melahirkan di Kota Bukittinggi',
                titleEn: 'Number of Live Birth, Still Birth and Maternal Death in Bukittinggi Municipality',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Kesehatan Kota Bukittinggi / <span class="italic text-slate-500">Public Health Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2019: { hidup: '2156', mati: '7', ibu: '2' },
                        2020: { hidup: '1865', mati: '7', ibu: '6' },
                        2021: { hidup: '1863', mati: '3', ibu: '3' },
                        2022: { hidup: '2286', mati: '16', ibu: '0' },
                        2023: { hidup: '2297', mati: '3', ibu: '0' },
                        2024: { hidup: '2161', mati: '20', ibu: '4' },
                        2025: { hidup: '2097', mati: '14', ibu: '0' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (officialData[y] && officialData[y][key] !== undefined) {
                            return officialData[y][key];
                        }
                        return '-';
                    };

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vHidup = getVal(y, 'hidup');
                        const vMati = getVal(y, 'mati');
                        const vIbu = getVal(y, 'ibu');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vHidup}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vMati}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vIbu}</td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lahir Hidup</div><div class="italic font-normal text-[11px] sm:text-xs">Live Birth</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lahir Mati</div><div class="italic font-normal text-[11px] sm:text-xs">Still Birth</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kematian Ibu Sewaktu Melahirkan</div><div class="italic font-normal text-[11px] sm:text-xs">Maternal Death</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.9': {
                titleId: 'Jumlah Dokter Praktek Menurut Keahlian di Kota Bukittinggi',
                titleEn: 'Number of Medical Specialist by Specialty in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Kesehatan Kota Bukittinggi / <span class="italic text-slate-500">Public Health Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const profs = [
                        '01. Dokter Spesialis Penyakit Dalam / Internist',
                        '02. Dokter Spesialis Anak / Paediatrician',
                        '03. Dokter Spesialis Obstetri dan Ginekologi / Obstetrician and Gynecologist',
                        '04. Dokter Spesialis Bedah / Surgeon',
                        '05. Dokter Spesialis Radiologi / Radiologist',
                        '06. Dokter Spesialis Anestesiologi / Anesthesiologist',
                        '07. Dokter Spesialis Lainnya / Other Specialist Doctors',
                        '08. Dokter Gigi Spesialis Lainnya / Other Specialist Dentists',
                        '09. Dokter Umum / General Practitioner',
                        '10. Dokter Gigi / Dentist',
                        '11. Apoteker / Pharmacist',
                        '12. Asisten Apoteker / Pharmacist Assistant',
                        '13. Fisioterapis / Physiotherapist',
                        '14. Analisis Kesehatan / Medical Analyst',
                        '15. Radiografer / Radiographer',
                        '16. Perekam Medik / Medical Record',
                        '17. Refraksionis Optisien / Refractionist Optician'
                    ];

                    const histData = {
                        2020: ['19', '14', '18', '27', '9', '14', '79', '2', '126', '54', '80', '133', '15', '53', '24', '42', '14'],
                        2021: ['22', '15', '20', '29', '10', '16', '85', '2', '135', '58', '88', '140', '16', '58', '26', '45', '15'],
                        2022: ['25', '17', '21', '30', '12', '18', '92', '3', '142', '60', '95', '145', '18', '62', '28', '48', '16'],
                        2023: ['28', '19', '23', '32', '13', '20', '98', '3', '150', '63', '102', '152', '20', '66', '30', '52', '17'],
                        2024: ['32', '21', '25', '35', '15', '22', '108', '4', '162', '67', '112', '160', '22', '72', '33', '56', '19'],
                        2025: ['32', '21', '25', '35', '15', '22', '108', '4', '162', '67', '112', '160', '22', '72', '33', '56', '19']
                    };

                    const getVal = (idx, y) => {
                        if (histData[y] && histData[y][idx] !== undefined) {
                            return histData[y][idx];
                        }
                        return '-';
                    };

                    const totals = years.map(y => {
                        let sum = 0;
                        let hasData = false;
                        for (let i = 0; i < 17; i++) {
                            const val = getVal(i, y);
                            if (val !== '-') {
                                sum += parseFloat(val) || 0;
                                hasData = true;
                            }
                        }
                        return hasData ? sum.toString() : '-';
                    });

                    const rowsHtml = profs.map((name, idx) => `
                        <tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2 px-3 font-semibold border border-slate-700 text-left align-middle text-xs sm:text-sm">${name}</td>
                            ${years.map(y => `<td class="py-2 px-3 text-center border border-slate-700 align-middle text-xs sm:text-sm">${getVal(idx, y)}</td>`).join('')}
                        </tr>
                    `).join('') + `
                        <tr class="bg-amber-100/80 font-bold">
                            <td class="py-2.5 px-4 border border-slate-700 text-left align-middle uppercase">Jumlah / Total</td>
                            ${totals.map(t => `<td class="py-2.5 px-4 text-center border border-slate-700 align-middle font-bold">${t}</td>`).join('')}
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-xs sm:text-sm" rowspan="2">
                                    <div>Jabatan</div><div class="italic font-normal text-[11px] sm:text-xs">Occupation</div>
                                </th>
                                <th class="py-2 px-4 font-bold border border-slate-700 text-xs sm:text-sm" colspan="5">
                                    <div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs sm:text-sm">
                                ${years.map(y => `<th class="py-2 px-3 border border-slate-700">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                ${years.map((y, idx) => `<th class="py-1 px-3 border border-slate-700">(${idx + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.10': {
                titleId: 'Jumlah Kunjungan dan Rata–rata Kunjungan per Hari pada Puskesmas Kota Bukittinggi di Kota Bukittinggi',
                titleEn: 'Number of Attendence and Average Daily Attendence to puskesmas in Bukittinggi Municipality in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'DINAS KESEHATAN Kota Bukittinggi / <span class="italic text-slate-500">Public Health Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2017: { baru: '26082', lama: '91162', kunjungan: '117244', rata: '58' },
                        2018: { baru: '25272', lama: '90319', kunjungan: '115591', rata: '58' },
                        2019: { baru: '20975', lama: '93073', kunjungan: '114048', rata: '58' },
                        2020: { baru: '22375', lama: '91420', kunjungan: '114155', rata: '58' },
                        2021: { baru: '22710', lama: '48812', kunjungan: '71522', rata: '35' },
                        2022: { baru: '22428', lama: '89412', kunjungan: '111840', rata: '55' },
                        2023: { baru: '18534', lama: '113450', kunjungan: '131984', rata: '63' },
                        2024: { baru: '12023', lama: '122306', kunjungan: '134329', rata: '53' },
                        2025: { baru: '10820', lama: '139147', kunjungan: '149967', rata: '81' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (officialData[y] && officialData[y][key] !== undefined) {
                            return officialData[y][key];
                        }
                        return '-';
                    };

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vBaru = getVal(y, 'baru');
                        const vLama = getVal(y, 'lama');
                        const vKunjungan = getVal(y, 'kunjungan');
                        const vRata = getVal(y, 'rata');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vBaru}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vLama}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vKunjungan}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vRata}</td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700" colspan="2">
                                    <div>Penderita</div><div class="italic font-normal text-[11px] sm:text-xs">Patient</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Kunjungan</div><div class="italic font-normal text-[11px] sm:text-xs">Attendence</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Rata–rata Kunjungan per Hari</div><div class="italic font-normal text-[11px] sm:text-xs">Average Daily Attendence</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-3 border border-slate-700"><div>Baru</div><div class="italic font-normal text-[10px]">New</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Lama</div><div class="italic font-normal text-[10px]">Old</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                                <th class="py-1 px-3 border border-slate-700">(5)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.12': {
                titleId: 'Perkiraan Rata–rata Timbunan Sampah dan Volume Sampah yang Terangkut per Hari Setiap Bulan di Kota Bukittinggi',
                titleEn: 'Estimation of Rubbish Heap and Volume of Rubbish Carry Out per Day Monthly in Bukittinggi',
                isMultiYear: false,
                source: 'Dinas Lingkungan Hidup Kota Bukittinggi / <span class="italic text-slate-500">Environmental Services Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const officialData4212 = {
                        1: { timbunan: '110.91', terangkut: '108.35' },
                        2: { timbunan: '100.88', terangkut: '98.32' },
                        3: { timbunan: '111.72', terangkut: '109.16' },
                        4: { timbunan: '104.32', terangkut: '101.76' },
                        5: { timbunan: '95.19', terangkut: '88.32' },
                        6: { timbunan: '90.67', terangkut: '83.8' },
                        7: { timbunan: '90.12', terangkut: '83.25' },
                        8: { timbunan: '85.16', terangkut: '78.29' },
                        9: { timbunan: '79', terangkut: '72.13' },
                        10: { timbunan: '85.77', terangkut: '78.9' },
                        11: { timbunan: '75.67', terangkut: '68.8' },
                        12: { timbunan: '119.45', terangkut: '112.58' }
                    };
                    const months = [
                        { no: '01', id: 'Januari', en: 'January' },
                        { no: '02', id: 'Februari', en: 'February' },
                        { no: '03', id: 'Maret', en: 'March' },
                        { no: '04', id: 'April', en: 'April' },
                        { no: '05', id: 'Mei', en: 'May' },
                        { no: '06', id: 'Juni', en: 'June' },
                        { no: '07', id: 'Juli', en: 'July' },
                        { no: '08', id: 'Agustus', en: 'August' },
                        { no: '09', id: 'September', en: 'September' },
                        { no: '10', id: 'Oktober', en: 'October' },
                        { no: '11', id: 'November', en: 'November' },
                        { no: '12', id: 'Desember', en: 'December' }
                    ];
                    let rowsHtml = '';
                    months.forEach((m, idx) => {
                        const mNum = idx + 1;
                        const rowData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][mNum]) ? serverDbDataStore[yr][mNum] : (officialData4212[mNum] || {});
                        const vTim = rowData.timbunan !== undefined ? rowData.timbunan : '-';
                        const vTer = rowData.terangkut !== undefined ? rowData.terangkut : '-';
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">
                                    ${m.no}. ${m.id} / <span class="italic font-normal text-slate-700">${m.en}</span>
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">
                                    ${vTim}
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">
                                    ${vTer}
                                </td>
                            </tr>
                        `;
                    });
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Sampah per Hari</div><div class="italic font-normal text-[11px] sm:text-xs">Number of Rubbish Heap (ton)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Volume Sampah yang Terangkut per Hari</div><div class="italic font-normal text-[11px] sm:text-xs">Volume of Rubbish Carry Out by Day (ton)</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.13': {
                titleId: 'Persentase Komposisi Sampah di Kota Bukittinggi (%)',
                titleEn: 'Percentage of Rubbish Composition in Bukittinggi (%)',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Lingkungan Hidup Kota Bukittinggi / <span class="italic text-slate-500">Environmental Services Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData4213 = {
                        2017: { organik: '-', logam: '-', plastik: '-', kaca: '-', kertas: '-', lainnya: '-', total: '-' },
                        2018: { organik: '-', logam: '-', plastik: '-', kaca: '-', kertas: '-', lainnya: '-', total: '-' },
                        2019: { organik: '-', logam: '-', plastik: '-', kaca: '-', kertas: '-', lainnya: '-', total: '-' },
                        2020: { organik: '-', logam: '-', plastik: '-', kaca: '-', kertas: '-', lainnya: '-', total: '-' },
                        2021: { organik: '67.06', logam: '0.64', plastik: '14.64', kaca: '0.7', kertas: '13.65', lainnya: '3.3', total: '100' },
                        2022: { organik: '62.26', logam: '0.46', plastik: '18.72', kaca: '0.5', kertas: '16.5', lainnya: '1.56', total: '100' },
                        2023: { organik: '69.39', logam: '0.48', plastik: '19.18', kaca: '0.3', kertas: '9.2', lainnya: '1.45', total: '100' },
                        2024: { organik: '55.98', logam: '1.75', plastik: '21.96', kaca: '1.35', kertas: '5.51', lainnya: '13.45', total: '100' },
                        2025: { organik: '55.98', logam: '1.75', plastik: '21.96', kaca: '1.35', kertas: '5.51', lainnya: '13.45', total: '100' }
                    };

                    const categories = [
                        { key: 'organik', label: '01. Organik' },
                        { key: 'logam', label: '02. Logam' },
                        { key: 'plastik', label: '03. Plastik' },
                        { key: 'kaca', label: '04. Gelas / Kaca' },
                        { key: 'kertas', label: '05. Kertas' },
                        { key: 'lainnya', label: '06. Lainnya' }
                    ];

                    let rowsHtml = '';
                    categories.forEach(cat => {
                        let cellsHtml = '';
                        years.forEach(y => {
                            const rowData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) ? serverDbDataStore[y] : (officialData4213[y] || {});
                            const val = rowData[cat.key] !== undefined ? rowData[cat.key] : '-';
                            cellsHtml += `<td class="py-2.5 px-4 border border-slate-700 text-center align-top ${y === yr ? 'bg-amber-100/60 font-semibold' : ''}">${val}</td>`;
                        });
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${cat.label}</td>
                                ${cellsHtml}
                            </tr>
                        `;
                    });

                    // Baris Total
                    let totalCellsHtml = '';
                    years.forEach(y => {
                        const rowData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) ? serverDbDataStore[y] : (officialData4213[y] || {});
                        const val = rowData.total !== undefined ? rowData.total : '100';
                        totalCellsHtml += `<td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold ${y === yr ? 'bg-amber-200/60' : ''}">${val}</td>`;
                    });
                    rowsHtml += `
                        <tr class="bg-[#fed7aa] font-bold">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-bold align-top">Jumlah / Total</td>
                            ${totalCellsHtml}
                        </tr>
                    `;

                    let theadYearsHtml = '';
                    let theadNumHtml = '';
                    years.forEach((y, idx) => {
                        theadYearsHtml += `<th class="py-3 px-4 font-bold border border-slate-700 ${y === yr ? 'bg-amber-600' : ''}"><div>${y}</div></th>`;
                        theadNumHtml += `<th class="py-1 px-3 border border-slate-700">(${idx + 2})</th>`;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jenis Sampah</div><div class="italic font-normal text-[11px] sm:text-xs">Kind of Rubbish</div>
                                </th>
                                ${theadYearsHtml}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                ${theadNumHtml}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.14': {
                titleId: 'Rata–rata Timbunan Sampah yang Terangkut menurut Sumber Timbunan Sampah di Kota Bukittinggi',
                titleEn: 'Rubbish Which is Carried by Source of Rubbish in Bukittinggi Municipality',
                isMultiYear: false,
                source: 'Dinas Lingkungan Hidup Kota Bukittinggi / <span class="italic text-slate-500">Environmental Services Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const dataByYear = {
                        2023: [
                            { label: '01. Rumah Tangga / Pemukiman', timbunan: '47,43', persentase: '52,51' },
                            { label: '02. Pasar', timbunan: '17,10', persentase: '18,93' },
                            { label: '03. Pertokoan/Komersial Fasilitas & Umum', timbunan: '8,94', persentase: '9,90' },
                            { label: '04. Perkantoran', timbunan: '0,42', persentase: '0,46' },
                            { label: '05. Sekolah', timbunan: '5,36', persentase: '5,93' },
                            { label: '06. Rumah Sakit', timbunan: '2,43', persentase: '2,69' },
                            { label: '07. Hotel', timbunan: '6,77', persentase: '7,49' },
                            { label: '08. Restorant', timbunan: '1,19', persentase: '1,32' },
                            { label: '09. Lainnya', timbunan: '0,70', persentase: '0,77' },
                            { label: 'Jumlah/ Total', timbunan: '90,33', persentase: '100' }
                        ],
                        2024: [
                            { label: '01. Rumah Tangga / Pemukiman', timbunan: '25,45', persentase: '26,25' },
                            { label: '02. Pasar', timbunan: '20,36', persentase: '21,00' },
                            { label: '03. Pertokoan / Komersial Fasilitas & Umum', timbunan: '14,06', persentase: '14,50' },
                            { label: '04. Perkantoran', timbunan: '0,35', persentase: '0,36' },
                            { label: '05. Sekolah', timbunan: '0,28', persentase: '0,29' },
                            { label: '06. Rumah Sakit', timbunan: '7,28', persentase: '7,51' },
                            { label: '07. Hotel', timbunan: '0,40', persentase: '0,41' },
                            { label: '08. Restorant', timbunan: '0,70', persentase: '0,72' },
                            { label: '09. Lainnya', timbunan: '28,06', persentase: '28,94' },
                            { label: 'Jumlah/ Total', timbunan: '96,95', persentase: '100' }
                        ]
                    };
                    const officialData4214 = dataByYear[yr] || (dataByYear[2024] ? dataByYear[2024].map(r => ({ label: r.label, timbunan: '-', persentase: '-' })) : []);

                    let rowsHtml = '';
                    officialData4214.forEach(row => {
                        const isTotal = row.label.toLowerCase().includes('jumlah');
                        const trClass = isTotal ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
                        const fontClass = isTotal ? 'font-bold' : 'font-semibold';
                        const alignClass = isTotal ? 'font-extrabold text-right' : 'font-semibold text-right';
                        rowsHtml += `
                            <tr class="${trClass}">
                                <td class="py-2.5 px-4 border border-slate-700 text-left ${fontClass} align-middle">${row.label}</td>
                                <td class="py-2.5 px-4 border border-slate-700 align-middle ${alignClass}" style="text-align: right;">${row.timbunan}</td>
                                <td class="py-2.5 px-4 border border-slate-700 align-middle ${alignClass}" style="text-align: right;">${row.persentase}</td>
                            </tr>
                        `;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Sumber</div><div class="italic font-normal text-[11px] sm:text-xs">Source</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Timbunan per Hari</div><div class="italic font-normal text-[11px] sm:text-xs">Rubbish Heap per Day (ton)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Persentase</div><div class="italic font-normal text-[11px] sm:text-xs">Percentage</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.15': {
                titleId: 'Jumlah Personil dan Sarana Kebersihan dan Pertamanan di Kota Bukittinggi',
                titleEn: 'Number of Personal, Tools and Equipment Cleanners in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Lingkungan Hidup Kota Bukittinggi / <span class="italic text-slate-500">Environmental Services Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2017: { pegawai: '257', truk: '17', gerobak: '58', becak_dayung: '8', becak_motor: '58' },
                        2018: { pegawai: '290', truk: '20', gerobak: '59', becak_dayung: '17', becak_motor: '62' },
                        2019: { pegawai: '287', truk: '19', gerobak: '39', becak_dayung: '13', becak_motor: '46' },
                        2020: { pegawai: '289', truk: '20', gerobak: '24', becak_dayung: '17', becak_motor: '45' },
                        2021: { pegawai: '313', truk: '20', gerobak: '24', becak_dayung: '10', becak_motor: '42' },
                        2022: { pegawai: '308', truk: '23', gerobak: '22', becak_dayung: '8', becak_motor: '45' },
                        2023: { pegawai: '292', truk: '17', gerobak: '22', becak_dayung: '8', becak_motor: '40' },
                        2024: { pegawai: '286', truk: '21', gerobak: '26', becak_dayung: '-', becak_motor: '39' },
                        2025: { pegawai: '258', truk: '17', gerobak: '51', becak_dayung: '-', becak_motor: '51' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (officialData[y] && officialData[y][key] !== undefined) {
                            return officialData[y][key];
                        }
                        return '-';
                    };

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vPeg = getVal(y, 'pegawai');
                        const vTruk = getVal(y, 'truk');
                        const vGer = getVal(y, 'gerobak');
                        const vBecD = getVal(y, 'becak_dayung');
                        const vBecM = getVal(y, 'becak_motor');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vPeg}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vTruk}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vGer}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vBecD}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${isCurrent ? 'font-semibold' : ''}">${vBecM}</td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Pegawai</div><div class="italic font-normal text-[11px] sm:text-xs">Personil</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Truk Sampah</div><div class="italic font-normal text-[11px] sm:text-xs">Truck of Trash/ (unit)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Gerobak</div><div class="italic font-normal text-[11px] sm:text-xs">Wagon (unit)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Becak Dayung</div><div class="italic font-normal text-[11px] sm:text-xs">Tricycle (unit)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Becak Motor</div><div class="italic font-normal text-[11px] sm:text-xs">Motor Tricycle (unit)</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                                <th class="py-1 px-3 border border-slate-700">(5)</th>
                                <th class="py-1 px-3 border border-slate-700">(6)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.1.20': {
                titleId: 'Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi',
                titleEn: 'Number of Sport Club in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Pemuda dan Olahraga Kota Bukittinggi / <span class="italic text-slate-500">Youth and Sports Agency of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const years = [yr - 3, yr - 2, yr - 1, yr];
                    const sportsList = [
                        { key: 'sport_1', name: '01. Sepak Bola / Soccer', def: { 2022: '3', 2023: '3', 2024: '3', 2025: '3' } },
                        { key: 'sport_2', name: '02. Bola Volly / Volley Ball', def: { 2022: '16', 2023: '16', 2024: '5', 2025: '5' } },
                        { key: 'sport_3', name: '03. Bola Basket / Basket Ball', def: { 2022: '17', 2023: '17', 2024: '18', 2025: '18' } },
                        { key: 'sport_4', name: '04. Bulu Tangkis / Badminton', def: { 2022: '7', 2023: '7', 2024: '7', 2025: '7' } },
                        { key: 'sport_5', name: '05. Tenis Meja / Table Tennis', def: { 2022: '3', 2023: '3', 2024: '3', 2025: '3' } },
                        { key: 'sport_6', name: '06. Atletik / Atletic', def: { 2022: '3', 2023: '3', 2024: '3', 2025: '3' } },
                        { key: 'sport_7', name: '07. Tenis / Tennis', def: { 2022: '7', 2023: '7', 2024: '6', 2025: '6' } },
                        { key: 'sport_8', name: '08. Catur / Chess', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_9', name: '09. Bridge / Bridge', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_10', name: '10. Bola Sodok / Billiards', def: { 2022: '1', 2023: '1', 2024: '3', 2025: '3' } },
                        { key: 'sport_11', name: '11. Renang / Swimming', def: { 2022: '6', 2023: '6', 2024: '6', 2025: '6' } },
                        { key: 'sport_12', name: '12. Karate / Karate', def: { 2022: '2', 2023: '2', 2024: '2', 2025: '2' } },
                        { key: 'sport_13', name: '13. Silat / Self Defence', def: { 2022: '26', 2023: '26', 2024: '26', 2025: '26' } },
                        { key: 'sport_14', name: '14. Gulat / Wrestler', def: { 2022: '2', 2023: '2', 2024: '2', 2025: '2' } },
                        { key: 'sport_15', name: '15. Aero Sport / Aero Sport', def: { 2022: '1', 2023: '1', 2024: '3', 2025: '3' } },
                        { key: 'sport_16', name: '16. Kempo / Kempo', def: { 2022: '5', 2023: '5', 2024: '5', 2025: '5' } },
                        { key: 'sport_17', name: '17. Wushu / Wushu', def: { 2022: '3', 2023: '3', 2024: '3', 2025: '3' } },
                        { key: 'sport_18', name: '18. Hoki / Hockey', def: { 2022: '1', 2023: '1', 2024: '2', 2025: '2' } },
                        { key: 'sport_19', name: '19. Menembak dan Berburu / Shooting', def: { 2022: '2', 2023: '2', 2024: '2', 2025: '2' } },
                        { key: 'sport_20', name: '20. Senam / Exercise', def: { 2022: '4', 2023: '4', 2024: '1', 2025: '1' } },
                        { key: 'sport_21', name: '21. Panahan / Archery', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_22', name: '22. Balap Motor / Road Race', def: { 2022: '1', 2023: '1', 2024: '5', 2025: '5' } },
                        { key: 'sport_23', name: '23. Sepau Roda / Roller sports', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_24', name: '24. Tarung Derajat / Tarung Derajat', def: { 2022: '6', 2023: '6', 2024: '6', 2025: '6' } },
                        { key: 'sport_25', name: '25. Tinju / Boxing', def: { 2022: '7', 2023: '7', 2024: '6', 2025: '6' } },
                        { key: 'sport_26', name: '26. Muaythai / Muaythai', def: { 2022: '3', 2023: '3', 2024: '2', 2025: '2' } },
                        { key: 'sport_27', name: '27. Taekwondo / Taekwondo', def: { 2022: '3', 2023: '3', 2024: '3', 2025: '3' } },
                        { key: 'sport_28', name: '28. Dayung / Rowing', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_29', name: '29. Balap Sepeda / Bike Racing', def: { 2022: '5', 2023: '5', 2024: '5', 2025: '5' } },
                        { key: 'sport_30', name: '30. Panjat Tebing / Rock Climbing', def: { 2022: '3', 2023: '3', 2024: '1', 2025: '1' } },
                        { key: 'sport_31', name: '31. Gate Ball / Gate Ball', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_32', name: '32. Hapkido / Hapkido', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_33', name: '33. Bola Tangan / Hand Ball', def: { 2022: '1', 2023: '1', 2024: '3', 2025: '3' } },
                        { key: 'sport_34', name: '34. Kriket / Cricket', def: { 2022: '1', 2023: '1', 2024: '2', 2025: '2' } },
                        { key: 'sport_35', name: '35. Beladiri Amatir / Mix Martial Arts', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_36', name: '36. Kick Boxing / Kick Boxing', def: { 2022: '1', 2023: '1', 2024: '2', 2025: '2' } },
                        { key: 'sport_37', name: '37. Binaraga / Bodybuilding', def: { 2022: '5', 2023: '5', 2024: '5', 2025: '5' } },
                        { key: 'sport_38', name: '38. Angkat Berat / Powerlifting', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_39', name: '39. Petanque / Petanque', def: { 2022: '1', 2023: '1', 2024: '2', 2025: '2' } },
                        { key: 'sport_40', name: '40. Sambo / Sambo', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_41', name: '41. Angkat Besi / Weightlifting', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_42', name: '42. E–Sport / E–Sport', def: { 2022: '1', 2023: '1', 2024: '1', 2025: '1' } },
                        { key: 'sport_43', name: '43. PJSI / Persatuan Judo Seluruh Indonesia', def: { 2022: '-', 2023: '-', 2024: '1', 2025: '1' } },
                        { key: 'sport_44', name: '44. PORDASI / Persatuan Olahraga Berkuda Seluruh Indonesia', def: { 2022: '-', 2023: '-', 2024: '1', 2025: '1' } },
                        { key: 'sport_45', name: '45. PSTI / Persatuan Sepak Takrau Indonesia', def: { 2022: '-', 2023: '-', 2024: '1', 2025: '1' } },
                        { key: 'sport_46', name: '46. PTMSI / Persatuan Tenis Meja Seluruh Indoneisa', def: { 2022: '-', 2023: '-', 2024: '1', 2025: '1' } }
                    ];

                    const getVal = (y, key, defObj) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (defObj && defObj[y] !== undefined) {
                            return defObj[y];
                        }
                        return '-';
                    };

                    const rowsHtml = sportsList.map(sp => {
                        let displayName = sp.name;
                        if (displayName.includes('/')) {
                            const parts = displayName.split('/');
                            displayName = `${parts[0].trim()} / <span class="italic font-normal text-slate-600">${parts.slice(1).join('/').trim()}</span>`;
                        }
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors" data-key="${sp.key}">
                                <td class="py-2 px-4 font-semibold border border-slate-700 text-left align-middle">${displayName}</td>
                                ${years.map(y => {
                                    const val = getVal(y, sp.key, sp.def);
                                    const isCur = (y === yr);
                                    const valDisplay = (val === '' || val === '-') ? '<span class="text-slate-400 font-normal">-</span>' : val;
                                    return `<td class="py-2 px-3 border border-slate-700 text-center align-middle ${isCur ? 'bg-amber-100/60 font-bold' : ''}">${valDisplay}</td>`;
                                }).join('')}
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle">
                                    <div>Jenis Olahraga</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Kind of Sport</div>
                                </th>
                                ${years.map(y => `<th class="py-3 px-4 border border-slate-700 text-center ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                ${years.map((y, idx) => `<th class="py-1 px-3 border border-slate-700 text-center">(${idx + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.3.4': {
                titleId: 'Jumlah Kejadian Bencana Alam di Kota Bukittinggi Menurut Kecamatan',
                titleEn: 'Number of Natural Disasters in Bukittinggi Municipality by District',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Badan Penanggulangan Bencana Daerah (BPBD) Kota Bukittinggi / <span class="italic text-slate-500">Regional Agency for Disaster Management of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const officialData = {
                        2023: {
                            guguk_panjang: ['38', '297', '0', '1'],
                            mandiangin_koto_selayan: ['48', '561', '2', '1'],
                            aur_birugo_tigo_baleh: ['23', '98', '1', '0'],
                            total: ['109', '956', '3', '2']
                        },
                        2024: {
                            guguk_panjang: ['45', '249', '8', '0'],
                            mandiangin_koto_selayan: ['31', '694', '0', '0'],
                            aur_birugo_tigo_baleh: ['17', '712', '50', '1'],
                            total: ['93', '1655', '58', '1']
                        },
                        2025: {
                            guguk_panjang: ['21', '130', '33', '6'],
                            mandiangin_koto_selayan: ['42', '74', '20', '8'],
                            aur_birugo_tigo_baleh: ['4', '0', '1', '1'],
                            total: ['67', '204', '54', '15']
                        }
                    };

                    const yrData = officialData[yr] || {};

                    const getVal = (distKey, colIdx, colName) => {
                        const dbKey = `${distKey}_${colName}`;
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][dbKey] !== undefined) {
                            return serverDbDataStore[yr][dbKey];
                        }
                        if (isFuture) {
                            return '-';
                        }
                        if (yrData[distKey] && yrData[distKey][colIdx] !== undefined) {
                            return yrData[distKey][colIdx];
                        }
                        return '-';
                    };

                    const dists = [
                        { key: 'guguk_panjang', label: '01. GUGUK PANJANG' },
                        { key: 'mandiangin_koto_selayan', label: '02. MANDIANGIN KOTO SELAYAN' },
                        { key: 'aur_birugo_tigo_baleh', label: '03. AUR BIRUGO TIGO BALEH' }
                    ];

                    const rowsHtml = dists.map(d => `
                        <tr class="hover:bg-amber-100/60 transition-colors" data-key="${d.key}">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle">${d.label}</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center align-middle">${getVal(d.key, 0, 'kejadian')}</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center align-middle">${getVal(d.key, 1, 'korban')}</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center align-middle">${getVal(d.key, 2, 'rumah')}</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center align-middle">${getVal(d.key, 3, 'lainnya')}</td>
                        </tr>
                    `).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah Kejadian Bencana Alam</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Natural Disaster</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah Korban Terdampak</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Victims Affected</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Jumlah Kerusakan Bangunan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Amount of Damage to Buildings</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Rumah</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">House</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lainnya</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Other</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                                <th class="py-1 px-3 border border-slate-700">(5)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                            <tr class="bg-[#fed7aa] font-bold" data-key="total">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-extrabold align-middle">Jumlah / <span class="italic font-bold">Total</span></td>
                                <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-extrabold">${getVal('total', 0, 'kejadian')}</td>
                                <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-extrabold">${getVal('total', 1, 'korban')}</td>
                                <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-extrabold">${getVal('total', 2, 'rumah')}</td>
                                <td class="py-2.5 px-3 border border-slate-700 text-center align-middle font-extrabold">${getVal('total', 3, 'lainnya')}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
});
