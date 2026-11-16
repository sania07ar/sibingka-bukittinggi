/** SiBingka - Skema tabel (form isian / edit): 4.2.4, 4.2.5, 4.2.6, 4.2.7, 4.2.9, 4.2.10, 4.2.12, 4.2.13, 4.2.14, 4.2.15, 4.2.16, 4.2.17, 4.2.18, 4.2.19, 4.2.20 */
Object.assign(window.tableSchemas, {
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

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
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}" data-year="${y}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vPem)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vSwa)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vTot, 'font-bold bg-amber-100/50')}</td>
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

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
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}" data-year="${y}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vPem)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vSwa)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vTot, 'font-bold bg-amber-100/50')}</td>
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;
                    const inpText = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-left bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = items.map((it, idx) => `
                        <tr class="hover:bg-amber-100/60 transition-colors" data-row-index="${idx}">
                            <td class="py-1 px-2 border border-slate-700 text-left align-middle">${inpText(it.name)}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(it.val)}</td>
                        </tr>
                    `).join('') + `
                        <tr class="bg-amber-100/80 font-bold">
                            <td class="py-2.5 px-4 border border-slate-700 text-left align-middle uppercase font-bold">Jumlah / Total</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(totVal, 'font-bold bg-amber-100/50')}</td>
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vHidup = getVal(y, 'hidup');
                        const vMati = getVal(y, 'mati');
                        const vIbu = getVal(y, 'ibu');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}" data-year="${y}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vHidup)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vMati)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vIbu)}</td>
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = profs.map((name, idx) => `
                        <tr class="hover:bg-amber-100/60 transition-colors" data-prof-index="${idx}">
                            <td class="py-2 px-3 font-semibold border border-slate-700 text-left align-middle text-xs sm:text-sm">${name}</td>
                            ${years.map(y => `<td class="py-1 px-2 text-center border border-slate-700 align-middle">${inp(getVal(idx, y))}</td>`).join('')}
                        </tr>
                    `).join('') + `
                        <tr class="bg-amber-100/80 font-bold">
                            <td class="py-2.5 px-4 border border-slate-700 text-left align-middle uppercase font-bold">Jumlah / Total</td>
                            ${totals.map(t => `<td class="py-1 px-2 text-center border border-slate-700 align-middle">${inp(t, 'font-bold bg-amber-100/50')}</td>`).join('')}
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vBaru = getVal(y, 'baru');
                        const vLama = getVal(y, 'lama');
                        const vKunjungan = getVal(y, 'kunjungan');
                        const vRata = getVal(y, 'rata');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}" data-year="${y}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vBaru)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vLama)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vKunjungan)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vRata)}</td>
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
                    const officialData = {
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

                    const getVal = (mNum, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][mNum] && serverDbDataStore[yr][mNum][key] !== undefined) {
                            return serverDbDataStore[yr][mNum][key];
                        }
                        if (officialData[mNum] && officialData[mNum][key] !== undefined) {
                            return officialData[mNum][key];
                        }
                        return '-';
                    };

                    const inp = (v) => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" value="${v}">`;

                    const rowsHtml = months.map((m, idx) => {
                        const mNum = idx + 1;
                        const vTim = getVal(mNum, 'timbunan');
                        const vTer = getVal(mNum, 'terangkut');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors" data-month="${mNum}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle">
                                    ${m.no}. ${m.id} / <span class="italic font-normal text-slate-700">${m.en}</span>
                                </td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vTim)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vTer)}</td>
                            </tr>
                        `;
                    }).join('');

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

                    const officialData = {
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

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (officialData[y] && officialData[y][key] !== undefined) {
                            return officialData[y][key];
                        }
                        return '-';
                    };

                    const inp = (v) => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" value="${v}">`;

                    let rowsHtml = categories.map(cat => {
                        let cellsHtml = years.map(y => {
                            const val = getVal(y, cat.key);
                            return `<td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/30' : ''}">${inp(val)}</td>`;
                        }).join('');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors" data-key="${cat.key}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle">${cat.label}</td>
                                ${cellsHtml}
                            </tr>
                        `;
                    }).join('');

                    // Total row
                    let totalCellsHtml = years.map(y => {
                        const val = getVal(y, 'total') !== '-' ? getVal(y, 'total') : '100';
                        return `<td class="py-1 px-2 border border-slate-700 text-center align-middle font-bold ${y === yr ? 'bg-amber-200/50' : ''}">${inp(val, 'font-bold')}</td>`;
                    }).join('');
                    rowsHtml += `
                        <tr class="bg-[#fed7aa] font-bold" data-key="total">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-bold align-middle">Jumlah / Total</td>
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
                    const officialData = dataByYear[yr] || (dataByYear[2024] ? dataByYear[2024].map(r => ({ label: r.label, timbunan: '-', persentase: '-' })) : []);

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = officialData.map((row, idx) => {
                        const isTotal = row.label.toLowerCase().includes('jumlah');
                        const vTim = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][idx] && serverDbDataStore[yr][idx].timbunan !== undefined)
                            ? serverDbDataStore[yr][idx].timbunan : row.timbunan;
                        const vPer = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][idx] && serverDbDataStore[yr][idx].persentase !== undefined)
                            ? serverDbDataStore[yr][idx].persentase : row.persentase;

                        const trClass = isTotal ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
                        const fontClass = isTotal ? 'font-bold' : 'font-semibold';
                        return `
                            <tr class="${trClass}" data-index="${idx}">
                                <td class="py-2.5 px-4 border border-slate-700 text-left ${fontClass} align-middle">${row.label}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vTim, isTotal ? 'font-bold' : '')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vPer, isTotal ? 'font-bold' : '')}</td>
                            </tr>
                        `;
                    }).join('');

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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vPeg = getVal(y, 'pegawai');
                        const vTruk = getVal(y, 'truk');
                        const vGer = getVal(y, 'gerobak');
                        const vBecD = getVal(y, 'becak_dayung');
                        const vBecM = getVal(y, 'becak_motor');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}" data-year="${y}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vPeg)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vTruk)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vGer)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vBecD)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vBecM)}</td>
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
            '4.2.16': {
                titleId: 'Jumlah Timbunan dan Volume Sampah yang Diangkut di Kota Bukittinggi',
                titleEn: 'Rubbish Heap and Volume of Rubbish Carried in Bukittinggi Municipality',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Lingkungan Hidup Kota Bukittinggi / <span class="italic text-slate-500">Environmental Services Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2017: { timbunan: '-', terangkut: '-' },
                        2018: { timbunan: '-', terangkut: '-' },
                        2019: { timbunan: '-', terangkut: '-' },
                        2020: { timbunan: '45.068 (ton)', terangkut: '40.424 (ton)' },
                        2021: { timbunan: '51.254 (ton)', terangkut: '44.206 (ton)' },
                        2022: { timbunan: '45.707 (ton)', terangkut: '38.235 (ton)' },
                        2023: { timbunan: '47.450 (ton)', terangkut: '36.549 (ton)' },
                        2024: { timbunan: '49.554 (ton)', terangkut: '35.394 (ton)' },
                        2025: { timbunan: '49.170 (ton)', terangkut: '32.972 (ton)' }
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vTim = getVal(y, 'timbunan');
                        const vTer = getVal(y, 'terangkut');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors ${isCurrent ? 'bg-amber-100/30' : ''}" data-year="${y}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vTim)}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vTer)}</td>
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
                                    <div>Perkiraan Timbunan Sampah</div><div class="italic font-normal text-[11px] sm:text-xs">Estimation Heap of Rubbish (m3)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Volume Sampah yang Terangkut</div><div class="italic font-normal text-[11px] sm:text-xs">Volume of Rubbish is Carried (m3)</div>
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
                        '4.2.17': {
                titleId: 'Jumlah Akseptor Aktif Keluarga Berencana Menurut Alat Kontrasepsi di Kota Bukittinggi',
                titleEn: 'Number of Family Planning Acceptors by Contraception in Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas P3APPKB Kota Bukittinggi / <span class="italic text-slate-500">Women Empowerment & Children Protection, Control of Population and Family Planning Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const officialDistricts = {
                        2025: {
                            '01. Guguk Panjang': ['254', '255', '672', '909', '600', '175', '11'],
                            '02. Mandiangin Koto Selayan': ['204', '336', '1010', '960', '686', '156', '5'],
                            '03. Aur Birugo Tigo Baleh': ['112', '488', '316', '674', '406', '125', '2']
                        },
                        2024: {
                            '01. Guguk Panjang': ['198', '355', '544', '1131', '753', '171', '10'],
                            '02. Mandiangin Koto Selayan': ['172', '562', '935', '1412', '841', '146', '8'],
                            '03. Aur Birugo Tigo Baleh': ['137', '168', '398', '772', '470', '170', '3']
                        },
                        2023: {
                            '01. Guguk Panjang': ['232', '372', '628', '684', '741', '188', '14'],
                            '02. Mandiangin Koto Selayan': ['305', '418', '1118', '714', '1075', '184', '9'],
                            '03. Aur Birugo Tigo Baleh': ['128', '222', '392', '550', '504', '145', '3']
                        }
                    };

                    const officialYearTotals = {
                        2019: ['1088', '1154', '3551', '844', '4135', '500', '56'],
                        2020: ['1146', '1168', '3529', '854', '3844', '481', '50'],
                        2021: ['1109', '1073', '3544', '925', '3544', '521', '43'],
                        2022: ['475', '656', '2065', '1285', '2170', '549', '37'],
                        2023: ['665', '1012', '2138', '1948', '2320', '517', '26'],
                        2024: ['507', '1085', '1877', '3315', '2064', '487', '21'],
                        2025: ['570', '1079', '1998', '2543', '1692', '456', '18']
                    };

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const districts = [
                        { name: '01. Guguk Panjang', key: 'guguk_panjang' },
                        { name: '02. Mandiangin Koto Selayan', key: 'mandiangin_koto_selayan' },
                        { name: '03. Aur Birugo Tigo Baleh', key: 'aur_birugo_tigo_baleh' }
                    ];

                    const dData = officialDistricts[yr] || {};

                    let districtRowsHtml = districts.map((d, dIdx) => {
                        const vals = dData[d.name] || ['-', '-', '-', '-', '-', '-', '-'];
                        let sum = 0;
                        const cells = vals.map((v, cIdx) => {
                            const num = parseFloat(v.toString().replace(',', '.')) || 0;
                            sum += num;
                            return `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(v, `kb-input-dist dist-${dIdx} col-${cIdx}`)}</td>`;
                        }).join('');
                        const sumFormatted = (sum > 0) ? sum.toString() : '-';
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors kb-dist-row" data-dist="${dIdx}">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${d.name}</td>
                                ${cells}
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold kb-dist-total">${inp(sumFormatted, 'kb-row-total font-bold')}</td>
                            </tr>
                        `;
                    }).join('');

                    let pastYearsHtml = '';
                    for (let pastY = yr - 5; pastY < yr; pastY++) {
                        const pVals = officialYearTotals[pastY] || ['-', '-', '-', '-', '-', '-', '-'];
                        let pSum = 0;
                        const cells = pVals.map((v, cIdx) => {
                            const num = parseFloat(v.toString().replace(',', '.')) || 0;
                            pSum += num;
                            return `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(v, `kb-input-past past-${pastY} col-${cIdx}`)}</td>`;
                        }).join('');
                        const pSumFormatted = (pSum > 0) ? pSum.toString() : '-';
                        pastYearsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors kb-past-row" data-year="${pastY}">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${pastY}</td>
                                ${cells}
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${inp(pSumFormatted, 'kb-row-total font-bold')}</td>
                            </tr>
                        `;
                    }

                    const currTotals = officialYearTotals[yr] || ['-', '-', '-', '-', '-', '-', '-'];
                    let currSum = 0;
                    const currTotalCells = currTotals.map((v, cIdx) => {
                        const num = parseFloat(v.toString().replace(',', '.')) || 0;
                        currSum += num;
                        return `<td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${inp(v, `kb-total-input col-${cIdx} font-bold`)}</td>`;
                    }).join('');
                    const currSumFormatted = (currSum > 0) ? currSum.toString() : '-';

                    const totalRowHtml = `
                        <tr class="bg-[#fed7aa] font-bold text-slate-900 hover:bg-amber-200/70 transition-colors kb-curr-total-row">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-bold align-top">Jumlah / Total ${yr}</td>
                            ${currTotalCells}
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${inp(currSumFormatted, 'kb-grand-total font-extrabold')}</td>
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="7">
                                    <div>Alat Kontrasepsi</div><div class="italic font-normal text-[11px] sm:text-xs">Contraception Tools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>IMP</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>PIL</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>IUD</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Kondom</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Suntik</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>MOW</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>MOP</div></th>
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
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${districtRowsHtml}
                            ${pastYearsHtml}
                            ${totalRowHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.18': {
                titleId: 'Jumlah PPKBD, Kelompok UPPKS, PLKB dan CU Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of PPKBD, UPPKS Society, PLKB and CU by District in Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas P3APPKB Kota Bukittinggi / <span class="italic text-slate-500">Women Empowerment & Children Protection, Control of Population and Family Planning Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const officialDistricts = {
                        2025: {
                            '01. Guguk Panjang': ['7', '33', '9', '5', '66.21', '23', '10', '12'],
                            '02. Mandiangin Koto Selayan': ['9', '36', '16', '5', '57.98', '24', '9', '12'],
                            '03. Aur Birugo Tigo Baleh': ['8', '35', '7', '4', '68.72', '18', '8', '9']
                        },
                        2024: {
                            '01. Guguk Panjang': ['7', '64', '9', '5', '70.89', '23', '10', '12'],
                            '02. Mandiangin Koto Selayan': ['9', '55', '14', '5', '64.91', '22', '8', '12'],
                            '03. Aur Birugo Tigo Baleh': ['8', '44', '7', '4', '61.75', '18', '8', '9']
                        },
                        2023: {
                            '01. Guguk Panjang': ['7', '64', '9', '3', '67.13', '21', '8', '10'],
                            '02. Mandiangin Koto Selayan': ['9', '55', '10', '4', '63.62', '20', '7', '12'],
                            '03. Aur Birugo Tigo Baleh': ['8', '44', '7', '3', '57.65', '18', '7', '8']
                        }
                    };

                    const officialYearTotals = {
                        2019: ['24', '164', '30', '8', '68.16', '54', '19', '27'],
                        2020: ['24', '165', '27', '9', '68.1', '51', '19', '27'],
                        2021: ['24', '165', '26', '7', '67.72', '52', '20', '20'],
                        2022: ['24', '165', '26', '11', '55.3', '55', '21', '27'],
                        2023: ['24', '163', '26', '10', '62.8', '59', '22', '30'],
                        2024: ['24', '163', '30', '14', '66.02', '63', '26', '33'],
                        2025: ['24', '104', '32', '14', '64.3', '65', '27', '33']
                    };

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const districts = ['01. Guguk Panjang', '02. Mandiangin Koto Selayan', '03. Aur Birugo Tigo Baleh'];
                    const dData = officialDistricts[yr] || {};

                    let districtRowsHtml = districts.map(dName => {
                        const vals = dData[dName] || ['-', '-', '-', '-', '-', '-', '-', '-'];
                        const cells = vals.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(v)}</td>`).join('');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${dName}</td>
                                ${cells}
                            </tr>
                        `;
                    }).join('');

                    let pastYearsHtml = '';
                    for (let pastY = yr - 5; pastY < yr; pastY++) {
                        const pVals = officialYearTotals[pastY] || ['-', '-', '-', '-', '-', '-', '-', '-'];
                        const cells = pVals.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(v)}</td>`).join('');
                        pastYearsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${pastY}</td>
                                ${cells}
                            </tr>
                        `;
                    }

                    const currTotals = officialYearTotals[yr] || ['-', '-', '-', '-', '-', '-', '-', '-'];
                    const currTotalCells = currTotals.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${inp(v, 'font-bold')}</td>`).join('');
                    const totalRowHtml = `
                        <tr class="bg-[#fed7aa] font-bold text-slate-900 hover:bg-amber-200/70 transition-colors">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-bold align-top">Jumlah / Total ${yr}</td>
                            ${currTotalCells}
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>PPKBD</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Sub PPKBD</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>UPPKS / UPPKA</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>PLKB / PKB</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>CU (%)</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>BKB</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>BKR</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>BKL</div></th>
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
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${districtRowsHtml}
                            ${pastYearsHtml}
                            ${totalRowHtml}
                        </tbody>
                    `;
                }
            },
            '4.2.19': {
                titleId: 'Jumlah Klinik dan Tenaga Medis Keluarga Berencana di Kota Bukittinggi',
                titleEn: 'Number of Clinics and Medical Personal of Family Planning in Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas P3APPKB Kota Bukittinggi / <span class="italic text-slate-500">Women Empowerment & Children Protection, Control of Population and Family Planning Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const officialDistricts = {
                        2025: {
                            '01. Guguk Panjang': ['6', '14', '46'],
                            '02. Mandiangin Koto Selayan': ['9', '1', '35'],
                            '03. Aur Birugo Tigo Baleh': ['8', '1', '18']
                        },
                        2024: {
                            '01. Guguk Panjang': ['6', '22', '48'],
                            '02. Mandiangin Koto Selayan': ['10', '11', '39'],
                            '03. Aur Birugo Tigo Baleh': ['8', '2', '17']
                        },
                        2023: {
                            '01. Guguk Panjang': ['7', '12', '48'],
                            '02. Mandiangin Koto Selayan': ['9', '2', '46'],
                            '03. Aur Birugo Tigo Baleh': ['7', '1', '18']
                        }
                    };

                    const officialYearTotals = {
                        2019: ['24', '28', '98', '126'],
                        2020: ['24', '28', '98', '126'],
                        2021: ['27', '18', '64', '82'],
                        2022: ['24', '15', '85', '100'],
                        2023: ['23', '15', '115', '130'],
                        2024: ['24', '33', '104', '137'],
                        2025: ['23', '16', '99', '115']
                    };

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const districts = ['01. Guguk Panjang', '02. Mandiangin Koto Selayan', '03. Aur Birugo Tigo Baleh'];
                    const dData = officialDistricts[yr] || {};

                    let districtRowsHtml = districts.map(dName => {
                        const vals = dData[dName] || ['-', '-', '-'];
                        const vKlinik = vals[0] || '-';
                        const vDokter = vals[1] || '-';
                        const vBidan = vals[2] || '-';
                        const nDokter = parseFloat(vDokter.toString().replace(',', '.')) || 0;
                        const nBidan = parseFloat(vBidan.toString().replace(',', '.')) || 0;
                        const nJml = nDokter + nBidan;
                        const vJml = (nJml > 0) ? nJml.toString() : '-';

                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${dName}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(vKlinik)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(vDokter)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(vBidan)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${inp(vJml, 'font-bold')}</td>
                            </tr>
                        `;
                    }).join('');

                    let pastYearsHtml = '';
                    for (let pastY = yr - 5; pastY < yr; pastY++) {
                        const pVals = officialYearTotals[pastY] || ['-', '-', '-', '-'];
                        const cells = pVals.map((v, idx) => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top ${idx === 3 ? 'font-bold' : ''}">${inp(v, idx === 3 ? 'font-bold' : '')}</td>`).join('');
                        pastYearsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${pastY}</td>
                                ${cells}
                            </tr>
                        `;
                    }

                    const currTotals = officialYearTotals[yr] || ['-', '-', '-', '-'];
                    const currTotalCells = currTotals.map((v, idx) => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top ${idx === 3 ? 'font-extrabold' : 'font-bold'}">${inp(v, idx === 3 ? 'font-extrabold' : 'font-bold')}</td>`).join('');
                    const totalRowHtml = `
                        <tr class="bg-[#fed7aa] font-bold text-slate-900 hover:bg-amber-200/70 transition-colors">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-bold align-top">Jumlah / Total ${yr}</td>
                            ${currTotalCells}
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2"><div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2"><div>Klinik KB</div><div class="italic font-normal text-[11px] sm:text-xs">Clinic</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3"><div>Tenaga Medis</div><div class="italic font-normal text-[11px] sm:text-xs">Medical Personal</div></th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Dokter</div><div class="italic font-normal text-[11px] sm:text-xs">Doctor</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Bidan</div><div class="italic font-normal text-[11px] sm:text-xs">Midwive</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div></th>
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
                            ${districtRowsHtml}
                            ${pastYearsHtml}
                            ${totalRowHtml}
                        </tbody>
                    `;
                }
            },

                        '4.2.20': {
                titleId: 'Target dan Realisasi Keluarga Berencana di Kota Bukittinggi',
                titleEn: 'Target and Realization of Family Planning in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas P3APPKB Kota Bukittinggi / <span class="italic text-slate-500">Women Empowerment & Children Protection, Control of Population and Family Planning Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get7YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2017: { target: '3659', realisasi: '3864', persentase: '105.60' },
                        2018: { target: '3570', realisasi: '3581', persentase: '100.31' },
                        2019: { target: '3514', realisasi: '3386', persentase: '96.36' },
                        2020: { target: '2356', realisasi: '2558', persentase: '108.57' },
                        2021: { target: '2162', realisasi: '2767', persentase: '127.98' },
                        2022: { target: '3271', realisasi: '1687', persentase: '51.57' },
                        2023: { target: '2920', realisasi: '2770', persentase: '94.86' },
                        2024: { target: '3115', realisasi: '3707', persentase: '119.00' },
                        2025: { target: '2841', realisasi: '1670', persentase: '58.78' }
                    };

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const d = officialData[y] || { target: '-', realisasi: '-', persentase: '-' };
                        const rowClass = isCurrent ? 'bg-[#fed7aa] font-bold text-slate-900 hover:bg-amber-200/70' : 'hover:bg-amber-100/60';
                        return `
                            <tr class="${rowClass} transition-colors kb-target-row" data-year="${y}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle">${inp(d.target, 'kb-target-val')}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle">${inp(d.realisasi, 'kb-realisasi-val')}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle">${inp(d.persentase, 'kb-persen-val font-bold')}</td>
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
                                    <div>Target</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Realisasi</div><div class="italic font-normal text-[11px] sm:text-xs">Realization</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Persentase</div><div class="italic font-normal text-[11px] sm:text-xs">Percentage (%)</div>
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
});
