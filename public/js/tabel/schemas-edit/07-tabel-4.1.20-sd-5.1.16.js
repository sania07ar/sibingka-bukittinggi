/** SiBingka - Skema tabel (form isian / edit): 4.1.20, 4.3.13, 4.3.14, 4.3.15, 4.3.5, 4.3.6, 4.3.7, 4.3.8, 4.3.4, 9.2, 9.3, 9.4, 5.1.15, 5.1.16 */
Object.assign(window.tableSchemas, {
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

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
                                    return `<td class="py-1 px-2 border border-slate-700 text-center align-middle ${isCur ? 'bg-amber-100/60 font-bold' : ''}" data-year="${y}">${inp(val, isCur ? 'font-bold' : '')}</td>`;
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
                                    '4.3.13': {
                titleId: 'Jumlah Pekerja Sosial Masyarakat, Karang Taruna, Tenaga Kerja Sosial dan Organisasi Sosial di Kota Bukittinggi',
                titleEn: 'Number of Public Social Officers, Youth Club, Social Workers and Social Organization in Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Sosial Kota Bukittinggi / <span class="italic text-slate-500">Social Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const officialDistricts = {
                        2025: {
                            '01. GUGUK PANJANG': ['47', 'Tidak Aktif', '1', '6'],
                            '02. MANDIANGIN KOTO SELAYAN': ['60', 'Tidak Aktif', '1', '4'],
                            '03. AUR BIRUGO TIGO BALEH': ['28', 'Tidak Aktif', '1', '4']
                        },
                        2024: {
                            '01. GUGUK PANJANG': ['109', '7', '1', '8'],
                            '02. MANDIANGIN KOTO SELAYAN': ['130', '9', '1', '7'],
                            '03. AUR BIRUGO TIGO BALEH': ['60', '8', '1', '2']
                        }
                    };
                    const officialTotals = {
                        2018: ['-', '-', '-', '-'],
                        2019: ['123', '21', '3', '17'],
                        2020: ['130', '121', '3', '17'],
                        2021: ['130', '83', '3', '18'],
                        2022: ['130', '24', '3', '18'],
                        2023: ['300', '24', '3', '17'],
                        2024: ['299', '24', '3', '17'],
                        2025: ['135', 'Tidak Aktif', '3', '14']
                    };

                    const inp = (v) => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" value="${v}">`;

                    const districts = ['01. GUGUK PANJANG', '02. MANDIANGIN KOTO SELAYAN', '03. AUR BIRUGO TIGO BALEH'];
                    const dData = officialDistricts[yr] || {};

                    const distRowsHtml = districts.map(dName => {
                        const vals = dData[dName] || ['-', '-', '-', '-'];
                        const cells = vals.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(v)}</td>`).join('');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${dName}</td>
                                ${cells}
                            </tr>
                        `;
                    }).join('');

                    let pastYearsHtml = '';
                    for (let py = yr - 5; py < yr; py++) {
                        const pVals = officialTotals[py] || ['-', '-', '-', '-'];
                        const cells = pVals.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(v)}</td>`).join('');
                        pastYearsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${py}</td>
                                ${cells}
                            </tr>
                        `;
                    }

                    const currTot = officialTotals[yr] || ['-', '-', '-', '-'];
                    const totCells = currTot.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${inp(v)}</td>`).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Pekerja Sosial Masyarakat</div><div class="italic font-normal text-[11px] sm:text-xs">Public Social Officers</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Karang Taruna</div><div class="italic font-normal text-[11px] sm:text-xs">Youth Club</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kerja Sosial</div><div class="italic font-normal text-[11px] sm:text-xs">Social Workers</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Organisasi Sosial</div><div class="italic font-normal text-[11px] sm:text-xs">Social Organization</div>
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
                            ${distRowsHtml}
                            ${pastYearsHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total ${yr}</span></td>
                                ${totCells}
                            </tr>
                        </tbody>
                    `;
                }
            },
            '4.3.14': {
                titleId: 'Jumlah Penyandang Disabilitas, Anak Terlantar dan Lanjut Usia Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Disable People, Homeless Child, and Old Age Person by District in Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Sosial Kota Bukittinggi / <span class="italic text-slate-500">Social Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const officialDistricts = {
                        2025: {
                            '01. GUGUK PANJANG': ['175', '0', '760'],
                            '02. MANDIANGIN KOTO SELAYAN': ['220', '1', '967'],
                            '03. AUR BIRUGO TIGO BALEH': ['88', '0', '387']
                        },
                        2024: {
                            '01. GUGUK PANJANG': ['132', '-', '1584'],
                            '02. MANDIANGIN KOTO SELAYAN': ['164', '-', '2016'],
                            '03. AUR BIRUGO TIGO BALEH': ['66', '-', '802']
                        }
                    };
                    const officialTotals = {
                        2018: ['-', '-', '-'],
                        2019: ['580', '15', '565'],
                        2020: ['566', '23', '745'],
                        2021: ['563', '42', '456'],
                        2022: ['533', '31', '450'],
                        2023: ['533', '15', '3879'],
                        2024: ['362', '-', '4402'],
                        2025: ['483', '1', '2114']
                    };

                    const inp = (v) => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" value="${v}">`;

                    const districts = ['01. GUGUK PANJANG', '02. MANDIANGIN KOTO SELAYAN', '03. AUR BIRUGO TIGO BALEH'];
                    const dData = officialDistricts[yr] || {};

                    const distRowsHtml = districts.map(dName => {
                        const vals = dData[dName] || ['-', '-', '-'];
                        const cells = vals.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(v)}</td>`).join('');
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${dName}</td>
                                ${cells}
                            </tr>
                        `;
                    }).join('');

                    let pastYearsHtml = '';
                    for (let py = yr - 5; py < yr; py++) {
                        const pVals = officialTotals[py] || ['-', '-', '-'];
                        const cells = pVals.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(v)}</td>`).join('');
                        pastYearsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${py}</td>
                                ${cells}
                            </tr>
                        `;
                    }

                    const currTot = officialTotals[yr] || ['-', '-', '-'];
                    const totCells = currTot.map(v => `<td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${inp(v)}</td>`).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Penyandang Disabilitas (DTSEN)</div><div class="italic font-normal text-[11px] sm:text-xs">Disable People (KK)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Anak Terlantar</div><div class="italic font-normal text-[11px] sm:text-xs">Homeless Child (orang)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lanjut Usia (Penerima Bansos APBN & APBD)</div><div class="italic font-normal text-[11px] sm:text-xs">Old Age (orang)</div>
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
                            ${distRowsHtml}
                            ${pastYearsHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total ${yr}</span></td>
                                ${totCells}
                            </tr>
                        </tbody>
                    `;
                }
            },
            '4.3.15': {
                titleId: 'Jumlah Orang Terlantar, Bekas Narapidana, Penyandang Disabilitas dan Penghuni Panti Asuhan yang Dibantu di Kota Bukittinggi',
                titleEn: 'Number of Homeless People, Ex Prisoner, Disable People, Refective Person in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Sosial Kota Bukittinggi / <span class="italic text-slate-500">Social Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get7YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2015: ['-', '-', '-', '-', '-'],
                        2016: ['-', '-', '-', '-', '-'],
                        2017: ['61', '15', '390', '94', '560'],
                        2018: ['39', '0', '123', '94', '256'],
                        2019: ['40', '2', '28', '96', '166'],
                        2020: ['54', '0', '482', '96', '632'],
                        2021: ['53', '78', '563', '107', '801'],
                        2022: ['55', '0', '345', '79', '479'],
                        2023: ['75', '12', '256', '72', '415'],
                        2024: ['44', '0', '302', '77', '423'],
                        2025: ['25', '0', '280', '75', '380']
                    };

                    const inp = (v) => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" value="${v}">`;

                    const rowsHtml = years.map(y => {
                        const isCurrent = (y === yr);
                        const vals = officialData[y] || ['-', '-', '-', '-', '-'];
                        const rowClass = isCurrent ? 'bg-[#fed7aa] font-bold text-slate-900 hover:bg-amber-200/70' : 'hover:bg-amber-100/60';
                        const cells = vals.map(v => `<td class="py-2.5 px-4 text-center border border-slate-700 align-middle">${inp(v)}</td>`).join('');
                        return `
                            <tr class="${rowClass} transition-colors" data-year="${y}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${isCurrent ? 'font-bold' : ''}">${y}</td>
                                ${cells}
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
                                    <div>Orang Terlantar</div><div class="italic font-normal text-[11px] sm:text-xs">Homeless People</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Bekas Napi</div><div class="italic font-normal text-[11px] sm:text-xs">Ex-prisoner</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Penyandang Disabilitas</div><div class="italic font-normal text-[11px] sm:text-xs">Disable People</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Penghuni Panti Asuhan</div><div class="italic font-normal text-[11px] sm:text-xs">Inhabitants of Social Institution</div>
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
            '4.3.5': {
                titleId: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Bulan',
                titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Month',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Kebakaran Kota Bukittinggi / <span class="italic text-slate-500">Fire Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const months = [
                        { label: '01. Januari / <span class="italic font-normal text-slate-700">January</span>' },
                        { label: '02. Februari / <span class="italic font-normal text-slate-700">February</span>' },
                        { label: '03. Maret / <span class="italic font-normal text-slate-700">March</span>' },
                        { label: '04. April / <span class="italic font-normal text-slate-700">April</span>' },
                        { label: '05. Mei / <span class="italic font-normal text-slate-700">May</span>' },
                        { label: '06. Juni / <span class="italic font-normal text-slate-700">June</span>' },
                        { label: '07. Juli / <span class="italic font-normal text-slate-700">July</span>' },
                        { label: '08. Agustus / <span class="italic font-normal text-slate-700">August</span>' },
                        { label: '09. September / <span class="italic font-normal text-slate-700">September</span>' },
                        { label: '10. Oktober / <span class="italic font-normal text-slate-700">October</span>' },
                        { label: '11. November / <span class="italic font-normal text-slate-700">November</span>' },
                        { label: '12. Desember / <span class="italic font-normal text-slate-700">December</span>' }
                    ];
                    const officialData = {
                        2023: ['1', '3', '2', '5', '1', '4', '4', '1', '3', '8', '1', '–'],
                        2024: ['3', '3', '5', '4', '1', '2', '3', '1', '5', '6', '1', '7'],
                        2025: ['3', '2', '2', '4', '8', '6', '21', '11', '3', '8', '9', '2']
                    };
                    const d = officialData[yr] || Array(12).fill('-');
                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = months.map((m, idx) => {
                        const val = d[idx] || '-';
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${m.label}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(val, 'damkar-val')}</td>
                            </tr>
                        `;
                    }).join('');

                    const totalDisplay = yr === 2023 ? '33' : (yr === 2024 ? '41' : (yr === 2025 ? '79' : '-'));

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Bulan</div><div class="italic font-normal text-[11px] sm:text-xs">Month</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah Kejadian</div><div class="italic font-normal text-[11px] sm:text-xs">Number of Incident</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total</span></td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold" id="damkarTotal">${totalDisplay}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '4.3.6': {
                titleId: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Tempat Kejadian',
                titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Incident Scene',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Kebakaran Kota Bukittinggi / <span class="italic text-slate-500">Fire Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const scenes = [
                        { label: '01. Rumah Tinggal / <span class="italic font-normal text-slate-700">Residential Home</span>' },
                        { label: '02. Rumah Makan / Kedai / Warung / <span class="italic font-normal text-slate-700">Restaurants / Shops/ Stalls</span>' },
                        { label: '03. Kandang / <span class="italic font-normal text-slate-700">Shed</span>' },
                        { label: '04. Pabrik / <span class="italic font-normal text-slate-700">Factory</span>' },
                        { label: '05. Lahan / <span class="italic font-normal text-slate-700">Land</span>' },
                        { label: '06. Gedung / <span class="italic font-normal text-slate-700">Building</span>' },
                        { label: '07. Kantor / <span class="italic font-normal text-slate-700">Office</span>' },
                        { label: '08. Sampah / <span class="italic font-normal text-slate-700">Garbage</span>' },
                        { label: '09. Konsleting Listrik / <span class="italic font-normal text-slate-700">Electrical Short</span>' },
                        { label: '10. Genset / <span class="italic font-normal text-slate-700">Generator</span>' },
                        { label: '11. Pasar / <span class="italic font-normal text-slate-700">Market</span>' },
                        { label: '12. Gas Elpiji / <span class="italic font-normal text-slate-700">Liquefied Petroleum Gas</span>' },
                        { label: '13. Mobil / <span class="italic font-normal text-slate-700">Car</span>' }
                    ];
                    const officialData = {
                        2023: ['9', '5', '1', '2', '1', '2', '–', '3', '4', '1', '–', '3', '2'],
                        2024: ['9', '4', '–', '1', '5', '1', '0', '3', '8', '1', '0', '4', '5'],
                        2025: ['6', '3', '1', '3', '37', '1', '0', '1', '10', '0', '0', '9', '8']
                    };
                    const d = officialData[yr] || Array(13).fill('-');
                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = scenes.map((s, idx) => {
                        const val = d[idx] || '-';
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${s.label}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(val, 'damkar-val')}</td>
                            </tr>
                        `;
                    }).join('');

                    const totalDisplay = yr === 2023 ? '33' : (yr === 2024 ? '41' : (yr === 2025 ? '79' : '-'));

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tempat Kejadian</div><div class="italic font-normal text-[11px] sm:text-xs">Incident Scene</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah Kejadian</div><div class="italic font-normal text-[11px] sm:text-xs">Number of Incident</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total</span></td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold" id="damkarTotal">${totalDisplay}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '4.3.7': {
                titleId: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Penyebab Kebakaran',
                titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Fire Cause',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Kebakaran Kota Bukittinggi / <span class="italic text-slate-500">Fire Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const causes = [
                        { label: '01. Korsleting Listrik / <span class="italic font-normal text-slate-700">Electric Short Circuit</span>' },
                        { label: '02. Kompor Gas / <span class="italic font-normal text-slate-700">Gas Stove</span>' },
                        { label: '03. Kompor Minyak Tanah / <span class="italic font-normal text-slate-700">Kerosene Stove</span>' },
                        { label: '04. Percikan Api / Las / <span class="italic font-normal text-slate-700">Sparks</span>' },
                        { label: '05. Pembakaran Sampah / <span class="italic font-normal text-slate-700">Garbage Burning</span>' },
                        { label: '06. Puntung Rokok / <span class="italic font-normal text-slate-700">Cigarette Butt</span>' },
                        { label: '07. Lainnya / <span class="italic font-normal text-slate-700">Others</span>' }
                    ];
                    const officialData = {
                        2023: ['4', '3', '–', '–', '3', '–', '23'],
                        2024: ['7', '4', '–', '–', '–', '5', '25'],
                        2025: ['10', '9', '0', '0', '1', '0', '59']
                    };
                    const d = officialData[yr] || Array(7).fill('-');
                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = causes.map((c, idx) => {
                        const val = d[idx] || '-';
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${c.label}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(val, 'damkar-val')}</td>
                            </tr>
                        `;
                    }).join('');

                    const totalDisplay = yr === 2023 ? '33' : (yr === 2024 ? '41' : (yr === 2025 ? '79' : '-'));

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Penyebab Kebakaran</div><div class="italic font-normal text-[11px] sm:text-xs">Fire Cause</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah Kejadian</div><div class="italic font-normal text-[11px] sm:text-xs">Number of Incident</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total</span></td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold" id="damkarTotal">${totalDisplay}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '4.3.8': {
                titleId: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Nilai Kerugian Akibat Kebakaran',
                titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Value of Losses Due to Fire',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Kebakaran Kota Bukittinggi / <span class="italic text-slate-500">Fire Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const losses = [
                        { label: '01. Kerugian &gt; 5M / <span class="italic font-normal text-slate-700">Loss &gt; 5B</span>' },
                        { label: '02. 1M &lt; Kerugian &lt; 5M / <span class="italic font-normal text-slate-700">1B &lt; Loss &lt; 5B</span>' },
                        { label: '03. 500 Jt &lt; Kerugian &lt; 1M / <span class="italic font-normal text-slate-700">500M &lt; Loss &lt; 1B</span>' },
                        { label: '04. 50 Jt &lt; Kerugian &lt; 500 Jt / <span class="italic font-normal text-slate-700">50M &lt; Loss &lt; 500M</span>' },
                        { label: '05. Kerugian &lt; 50 Jt / <span class="italic font-normal text-slate-700">Loss &lt; 50M</span>' }
                    ];
                    const officialData = {
                        2023: ['–', '–', '–', '6', '27'],
                        2024: ['–', '–', '–', '7', '34'],
                        2025: ['-', '2', '-', '1', '8']
                    };
                    const d = officialData[yr] || Array(5).fill('-');
                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = losses.map((l, idx) => {
                        const val = d[idx] || '-';
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${l.label}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${inp(val, 'damkar-val')}</td>
                            </tr>
                        `;
                    }).join('');

                    const totalDisplay = yr === 2023 ? '33' : (yr === 2024 ? '41' : (yr === 2025 ? '11' : '-'));

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Nilai Kerugian</div><div class="italic font-normal text-[11px] sm:text-xs">Value of Losses</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah Kejadian</div><div class="italic font-normal text-[11px] sm:text-xs">Number of Incident</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total</span></td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold" id="damkarTotal">${totalDisplay}</td>
                            </tr>
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = dists.map(d => `
                        <tr class="hover:bg-amber-100/60 transition-colors" data-key="${d.key}">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle">${d.label}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 0, 'kejadian'))}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 1, 'korban'))}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 2, 'rumah'))}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 3, 'lainnya'))}</td>
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
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 0, 'kejadian'), 'font-extrabold')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 1, 'korban'), 'font-extrabold')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 2, 'rumah'), 'font-extrabold')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 3, 'lainnya'), 'font-extrabold')}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '9.2': {
                titleId: 'Jumlah Koperasi Menurut Jenis Koperasi dan Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Cooperative by Kind of Cooperative and Subdistrict in Bukittinggi Municipality',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const officialData = {
                        2023: {
                            guguk_panjang: ['0', '13', '14', '25', '52'],
                            mandiangin_koto_selayan: ['0', '4', '1', '10', '15'],
                            aur_birugo_tigo_baleh: ['1', '12', '3', '11', '27'],
                            total: ['1', '29', '18', '46', '94']
                        },
                        2024: {
                            guguk_panjang: ['0', '13', '10', '34', '57'],
                            mandiangin_koto_selayan: ['0', '4', '1', '20', '25'],
                            aur_birugo_tigo_baleh: ['1', '10', '6', '14', '31'],
                            total: ['1', '27', '17', '68', '113']
                        },
                        2025: {
                            guguk_panjang: ['0', '29', '11', '22', '62'],
                            mandiangin_koto_selayan: ['0', '4', '1', '25', '30'],
                            aur_birugo_tigo_baleh: ['1', '10', '6', '19', '36'],
                            total: ['1', '43', '18', '66', '128']
                        }
                    };

                    const yrData = officialData[yr] || {};

                    const getVal = (distKey, colIdx, colName) => {
                        const dbKey = `${distKey}_${colName}`;
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][dbKey] !== undefined) {
                            return serverDbDataStore[yr][dbKey];
                        }
                        if (yrData[distKey] && yrData[distKey][colIdx] !== undefined) {
                            return yrData[distKey][colIdx];
                        }
                        return '-';
                    };

                    const dists = [
                        { key: 'guguk_panjang', label: 'Guguk Panjang' },
                        { key: 'mandiangin_koto_selayan', label: 'Mandiangin Koto Selayan' },
                        { key: 'aur_birugo_tigo_baleh', label: 'Aur Birugo Tigo Baleh' }
                    ];

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rowsHtml = dists.map(d => `
                        <tr class="hover:bg-amber-100/60 transition-colors" data-key="${d.key}">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle">${d.label}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 0, 'kud'))}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 1, 'kpri'))}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 2, 'kopkar'))}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 3, 'lainnya'))}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal(d.key, 4, 'total'), 'font-bold bg-amber-50/50')}</td>
                        </tr>
                    `).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Subdistrict</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>KUD</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>KPRI</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>KOPKAR</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lainnya</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Other</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Total</div>
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
                            <tr class="bg-[#fed7aa] font-bold" data-key="total">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-extrabold align-middle">Jumlah / <span class="italic font-bold">Total</span></td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 0, 'kud'), 'font-extrabold')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 1, 'kpri'), 'font-extrabold')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 2, 'kopkar'), 'font-extrabold')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 3, 'lainnya'), 'font-extrabold')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(getVal('total', 4, 'total'), 'font-extrabold bg-amber-100/80')}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '9.3': {
                titleId: 'Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha di Kota Bukittinggi',
                titleEn: 'Growth of Cooperative by Member, Deposite and Omset in Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get7YearPeriod(yr);
                    const years = p.yearsAsc;

                    const officialData = {
                        2017: { koperasi: '92', anggota: '15736', simpanan: '177732269', volume_usaha: '480543113', permodalan: '272173141' },
                        2018: { koperasi: '92', anggota: '15910', simpanan: '212256371', volume_usaha: '202499464', permodalan: '310499179' },
                        2019: { koperasi: '93', anggota: '15111', simpanan: '183270080', volume_usaha: '195793390', permodalan: '291298760' },
                        2020: { koperasi: '94', anggota: '14561', simpanan: '210868800', volume_usaha: '179916467', permodalan: '300268854' },
                        2021: { koperasi: '95', anggota: '14403', simpanan: '202041670', volume_usaha: '175575520', permodalan: '304235940' },
                        2022: { koperasi: '94', anggota: '14241', simpanan: '183893370', volume_usaha: '147951760', permodalan: '276352910' },
                        2023: { koperasi: '94', anggota: '14204', simpanan: '116872110', volume_usaha: '139303060', permodalan: '221056024' },
                        2024: { koperasi: '113', anggota: '13939', simpanan: '133938170', volume_usaha: '104568190', permodalan: '183952529' },
                        2025: { koperasi: '128', anggota: '14081', simpanan: '137045463', volume_usaha: '82924543', permodalan: '185537956' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (officialData[y] && officialData[y][key] !== undefined) return officialData[y][key];
                        return '-';
                    };

                    const rowsHtml = years.map(y => `
                        <tr class="hover:bg-amber-100/60 transition-colors" data-year="${y}">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${y}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="koperasi" value="${getVal(y, 'koperasi')}">
                            </td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="anggota" value="${getVal(y, 'anggota')}">
                            </td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="simpanan" value="${getVal(y, 'simpanan')}">
                            </td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="volume_usaha" value="${getVal(y, 'volume_usaha')}">
                            </td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="permodalan" value="${getVal(y, 'permodalan')}">
                            </td>
                        </tr>
                    `).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah Koperasi</div><div class="italic font-normal text-[11px] sm:text-xs">Number of Cooperative (Buah/Unit)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Anggota</div><div class="italic font-normal text-[11px] sm:text-xs">Member (Orang/ Person)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Simpanan</div><div class="italic font-normal text-[11px] sm:text-xs">Deposits (000)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Volume Usaha</div><div class="italic font-normal text-[11px] sm:text-xs">Omsets (000)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Permodalan</div><div class="italic font-normal text-[11px] sm:text-xs">Assets (000)</div>
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
            '9.4': {
                titleId: 'Jumlah Koperasi Menurut Jenisnya per Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Cooperation by Kind in District in Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const categories = [
                        { is_header: true, label: 'Koperasi Primer', key: 'primer_header' },
                        { key: 'kop_pertanian', label: '1. Kop. Pertanian', sub: false },
                        { key: 'kop_peternakan', label: '2. Kop. Peternakan', sub: false },
                        { key: 'kop_serba_usaha', label: '3. Kop. Serba Usaha', sub: false },
                        { key: 'kop_kerajinan', label: '4. Kop. Kerajinan', sub: false },
                        { key: 'kop_simpan_pinjam', label: '5. Kop. Simpan Pinjam', sub: false },
                        { key: 'kop_jasa_angkutan', label: '6. Kop. Jasa / <span class="italic font-normal text-slate-700">Angkutan</span>', raw_label: '6. Kop. Jasa / Angkutan', sub: false },
                        { is_header: true, label: '7. Kop Menurut Golongan', key: 'golongan_header' },
                        { key: 'gol_pegawai_negeri', label: '- Pegawai Negeri', sub: true },
                        { key: 'gol_angkatan_darat', label: '- Angkatan Darat', sub: true },
                        { key: 'gol_polri', label: '- Polri', sub: true },
                        { key: 'gol_karyawan_perum', label: '- Karyawan / <span class="italic font-normal text-slate-700">Perum</span>', raw_label: '- Karyawan / Perum', sub: true },
                        { key: 'gol_guru_swasta', label: '- Guru Swasta', sub: true },
                        { key: 'gol_veteran', label: '- Veteran', sub: true },
                        { key: 'gol_pensiun_abri', label: '- Pensiun ABRI', sub: true },
                        { key: 'gol_pensiun_pn', label: '- Pensiun PN', sub: true },
                        { key: 'gol_karyawan_bank', label: '- Karyawan Bank', sub: true },
                        { key: 'gol_organisasi_wanita', label: '- Organisasi Wanita', sub: true },
                        { key: 'kop_mahasiswa', label: '8. Kop. Mahasiswa', sub: false },
                        { key: 'kop_sekolah', label: '9. Kop. Sekolah', sub: false },
                        { key: 'koppas', label: '10. Koppas', sub: false },
                        { key: 'kop_lainnya', label: '11. Koperasi lainnya', sub: false },
                        { is_header: true, label: 'Koperasi Sekunder', key: 'sekunder_header' },
                        { key: 'sek_pkppn', label: '1. PKPPN', sub: false },
                        { key: 'sek_pusat_wanita', label: '2. Pusat Koperasi Wanita', sub: false }
                    ];

                    const officialDataByYear = {
                        2025: {
                            kop_pertanian: ['0', '0', '1', '1'],
                            kop_peternakan: ['0', '0', '0', '0'],
                            kop_serba_usaha: ['12', '3', '3', '18'],
                            kop_kerajinan: ['0', '0', '0', '0'],
                            kop_simpan_pinjam: ['4', '4', '1', '9'],
                            kop_jasa_angkutan: ['1', '0', '0', '1'],
                            gol_pegawai_negeri: ['13', '4', '10', '27'],
                            gol_angkatan_darat: ['0', '0', '2', '2'],
                            gol_polri: ['0', '0', '1', '1'],
                            gol_karyawan_perum: ['11', '1', '6', '18'],
                            gol_guru_swasta: ['0', '0', '0', '0'],
                            gol_veteran: ['1', '0', '0', '1'],
                            gol_pensiun_abri: ['1', '0', '0', '1'],
                            gol_pensiun_pn: ['0', '0', '0', '0'],
                            gol_karyawan_bank: ['0', '0', '0', '0'],
                            gol_organisasi_wanita: ['2', '1', '1', '4'],
                            kop_mahasiswa: ['0', '0', '0', '0'],
                            kop_sekolah: ['0', '0', '0', '0'],
                            koppas: ['2', '1', '0', '3'],
                            kop_lainnya: ['15', '16', '11', '42'],
                            sek_pkppn: ['0', '0', '0', '0'],
                            sek_pusat_wanita: ['0', '0', '0', '0']
                        },
                        2024: {
                            kop_pertanian: ['0', '0', '1', '1'],
                            kop_peternakan: ['0', '0', '0', '0'],
                            kop_serba_usaha: ['12', '3', '3', '18'],
                            kop_kerajinan: ['1', '0', '0', '1'],
                            kop_simpan_pinjam: ['12', '3', '3', '18'],
                            kop_jasa_angkutan: ['1', '0', '0', '1'],
                            gol_pegawai_negeri: ['12', '4', '10', '26'],
                            gol_angkatan_darat: ['0', '0', '2', '2'],
                            gol_polri: ['0', '0', '1', '1'],
                            gol_karyawan_perum: ['11', '1', '6', '18'],
                            gol_guru_swasta: ['0', '0', '0', '0'],
                            gol_veteran: ['1', '0', '0', '1'],
                            gol_pensiun_abri: ['1', '0', '0', '1'],
                            gol_pensiun_pn: ['0', '0', '0', '0'],
                            gol_karyawan_bank: ['0', '0', '0', '0'],
                            gol_organisasi_wanita: ['0', '0', '0', '0'],
                            kop_mahasiswa: ['0', '0', '0', '0'],
                            kop_sekolah: ['0', '0', '0', '0'],
                            koppas: ['2', '1', '-', '3'],
                            kop_lainnya: ['4', '13', '5', '22'],
                            sek_pkppn: ['-', '-', '-', '0'],
                            sek_pusat_wanita: ['-', '-', '-', '0']
                        },
                        2023: {
                            kop_pertanian: ['-', '-', '1', '1'],
                            kop_peternakan: ['-', '-', '-', '-'],
                            kop_serba_usaha: ['13', '3', '4', '20'],
                            kop_kerajinan: ['1', '-', '-', '1'],
                            kop_simpan_pinjam: ['3', '2', '-', '5'],
                            kop_jasa_angkutan: ['-', '-', '-', '-'],
                            gol_pegawai_negeri: ['13', '4', '12', '29'],
                            gol_angkatan_darat: ['1', '-', '-', '1'],
                            gol_polri: ['-', '-', '1', '1'],
                            gol_karyawan_perum: ['14', '1', '3', '18'],
                            gol_guru_swasta: ['-', '-', '-', '-'],
                            gol_veteran: ['-', '-', '-', '-'],
                            gol_pensiun_abri: ['-', '1', '-', '1'],
                            gol_pensiun_pn: ['-', '-', '-', '-'],
                            gol_karyawan_bank: ['-', '-', '-', '-'],
                            gol_organisasi_wanita: ['2', '-', '1', '3'],
                            kop_mahasiswa: ['-', '-', '-', '-'],
                            kop_sekolah: ['-', '-', '-', '-'],
                            koppas: ['-', '-', '-', '-'],
                            kop_lainnya: ['5', '4', '5', '14'],
                            sek_pkppn: ['-', '-', '-', '-'],
                            sek_pusat_wanita: ['-', '-', '-', '-']
                        }
                    };

                    const dataForYear = officialDataByYear[yr] || {};

                    let rowsHtml = '';
                    categories.forEach(cat => {
                        if (cat.is_header) {
                            rowsHtml += `
                                <tr class="hover:bg-amber-100/60 transition-colors">
                                    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">${cat.label}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top"><span class="text-slate-400 font-normal">-</span></td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top"><span class="text-slate-400 font-normal">-</span></td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top"><span class="text-slate-400 font-normal">-</span></td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top"><span class="text-slate-400 font-normal">-</span></td>
                                </tr>
                            `;
                        } else {
                            const vals = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][`${cat.key}_gp`] !== undefined)
                                ? [serverDbDataStore[yr][`${cat.key}_gp`], serverDbDataStore[yr][`${cat.key}_mks`], serverDbDataStore[yr][`${cat.key}_abtb`], serverDbDataStore[yr][`${cat.key}_total`]]
                                : (dataForYear[cat.key] || ['-', '-', '-', '-']);
                            const subCls = cat.sub ? 'pl-8' : '';
                            const inp = (v) => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" value="${v}">`;
                            rowsHtml += `
                                <tr class="hover:bg-amber-100/60 transition-colors" data-key="${cat.key}">
                                    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top ${subCls}" colspan="2">${cat.label}</td>
                                    <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vals[0])}</td>
                                    <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vals[1])}</td>
                                    <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vals[2])}</td>
                                    <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vals[3])}</td>
                                </tr>
                            `;
                        }
                    });

                    const officialTotals = {
                        2025: { gp: '62', mks: '30', abtb: '36', total: '128' },
                        2024: { gp: '57', mks: '25', abtb: '31', total: '113' },
                        2023: { gp: '52', mks: '15', abtb: '27', total: '94' },
                        2022: { gp: '53', mks: '17', abtb: '24', total: '94' },
                        2021: { gp: '54', mks: '17', abtb: '24', total: '95' },
                        2020: { gp: '54', mks: '17', abtb: '23', total: '94' },
                        2019: { gp: '54', mks: '17', abtb: '23', total: '94' },
                        2018: { gp: '54', mks: '16', abtb: '23', total: '93' }
                    };

                    const histYears = [yr, yr - 1, yr - 2, yr - 3, yr - 4, yr - 5];
                    const totalRowsCount = histYears.length;

                    histYears.forEach((hy, idx) => {
                        const t = officialTotals[hy] || { gp: '-', mks: '-', abtb: '-', total: '-' };
                        const isCur = (hy === yr);
                        const trCls = isCur ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
                        const boldCls = isCur ? 'font-extrabold' : '';

                        rowsHtml += `<tr class="${trCls}">`;
                        if (idx === 0) {
                            rowsHtml += `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" rowspan="${totalRowsCount}">Jumlah / <span class="italic font-bold">Total</span></td>`;
                        }
                        rowsHtml += `
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${boldCls}">${hy}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${boldCls}">${t.gp}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${boldCls}">${t.mks}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${boldCls}">${t.abtb}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${boldCls}">${t.total}</td>
                        </tr>`;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="2">
                                    <div>Jenis Koperasi</div><div class="italic font-normal text-[11px] sm:text-xs">Kind of Cooperative</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Guguk Panjang</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Mandiangin Koto Selayan</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Aur Birugo Tigo Baleh</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>
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
            '5.1.1': {
                titleId: 'Luas Panen Tanaman Sayuran Menurut Kecamatan dan Jenis Tanaman di Kota Bukittinggi (Ha)',
                titleEn: 'Harvested Area of Vegetables by Sub District and Kind of Plant in Bukittinggi Municipality (Ha)',
                isMultiYear: true,
                source: 'Dinas Pertanian dan Pangan Kota Bukittinggi / <span class="italic text-slate-500">Agriculture and Food Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2024;
                    const y1 = yr - 1;
                    const y2 = yr;

                    const official2024 = {
                        sec1: {
                            '01. Guguk Panjang': ['5', '4', '2', '5', '-', '-', '4', '4'],
                            '02. Mandiangin Koto Selayan': ['11', '9', '17', '11', '-', '-', '5', '7'],
                            '03. Aur Birugo Tigo Baleh': ['18', '19', '8', '10', '1', '1', '-', '-'],
                            'Bukittinggi': ['34', '32', '27', '26', '1', '1', '9', '11']
                        },
                        sec2: {
                            '01. Guguk Panjang': ['9', '6', '2', '1', '4', '4'],
                            '02. Mandiangin Koto Selayan': ['12', '12', '-', '-', '9', '8'],
                            '03. Aur Birugo Tigo Baleh': ['-', '-', '-', '-', '6', '5'],
                            'Bukittinggi': ['21', '18', '-', '-', '19', '17']
                        },
                        sec3: {
                            '01. Guguk Panjang': ['-', '-', '-', '-', '5', '5'],
                            '02. Mandiangin Koto Selayan': ['9', '10', '-', '-', '53', '29'],
                            '03. Aur Birugo Tigo Baleh': ['7', '8', '8', '8', '23', '23'],
                            'Bukittinggi': ['16', '18', '8', '8', '81', '57']
                        }
                    };

                    const dists = [
                        '01. Guguk Panjang',
                        '02. Mandiangin Koto Selayan',
                        '03. Aur Birugo Tigo Baleh',
                        'Bukittinggi'
                    ];

                    const getVal = (secKey, dist, colIdx) => {
                        if (yr === 2024 && official2024[secKey] && official2024[secKey][dist]) {
                            return official2024[secKey][dist][colIdx];
                        }
                        return '-';
                    };

                    const renderRows = (secKey, numCols, hasTrailingBlank) => {
                        return dists.map(d => {
                            const isTot = (d === 'Bukittinggi');
                            const rowCls = isTot 
                                ? 'bg-[#fed7aa] font-bold text-slate-900 border-t border-slate-700' 
                                : 'hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium';
                            const cellCls = isTot ? ' font-bold' : '';
                            let cells = `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle${cellCls}">${d}</td>`;
                            for (let c = 0; c < numCols; c++) {
                                const v = getVal(secKey, d, c);
                                cells += `<td class="py-2.5 px-2 border border-slate-700 text-center align-middle"><input type="text" class="table-edit-input w-full text-right bg-white border border-slate-300 rounded px-2 py-1 text-xs font-semibold" value="${v}"></td>`;
                            }
                            if (hasTrailingBlank) {
                                cells += `<td colspan="2" class="border border-slate-700 bg-slate-100/40 text-center text-slate-300 font-normal select-none">-</td>`;
                            }
                            return `<tr class="${rowCls}">${cells}</tr>`;
                        }).join('\n');
                    };

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Bawang Daun</div><div class="italic font-normal text-[11px] sm:text-xs">Scallion</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Bawang Merah</div><div class="italic font-normal text-[11px] sm:text-xs">Shallots</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Buncis</div><div class="italic font-normal text-[11px] sm:text-xs">String Bean</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Cabai Rawit</div><div class="italic font-normal text-[11px] sm:text-xs">Chili/ Cayenne Pepper</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                ${Array(4).fill(0).map(() => `<th class="py-2.5 px-3 font-bold border border-slate-700"><div>${y1}</div></th><th class="py-2.5 px-3 font-bold border border-slate-700"><div>${y2}</div></th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                ${Array(9).fill(0).map((_, i) => `<th class="py-1 px-3 border border-slate-700">(${i + 1})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${renderRows('sec1', 8, false)}
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="9" class="h-6 sm:h-8 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center align-middle" rowspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center align-middle" colspan="2">
                                    <div>Kangkung</div><div class="italic font-normal text-[11px] sm:text-xs">Water Spinach</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center align-middle" colspan="2">
                                    <div>Labu Siam</div><div class="italic font-normal text-[11px] sm:text-xs">Chayote</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center align-middle" colspan="2">
                                    <div>Terung</div><div class="italic font-normal text-[11px] sm:text-xs">Eggplant</div>
                                </th>
                                <th class="border border-slate-700 bg-slate-200/50" colspan="2" rowspan="3"></th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                ${Array(3).fill(0).map(() => `<th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle text-xs"><div>${y1}</div></th><th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle text-xs"><div>${y2}</div></th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center font-bold text-xs">(1)</th>
                                ${[10, 11, 12, 13, 14, 15].map(n => `<th class="py-1 px-3 border border-slate-700 text-center font-bold text-xs">(${n})</th>`).join('')}
                            </tr>
                            ${renderRows('sec2', 6, true)}
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="9" class="h-6 sm:h-8 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center align-middle" rowspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center align-middle" colspan="2">
                                    <div>Tomat</div><div class="italic font-normal text-[11px] sm:text-xs">Tomato</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center align-middle" colspan="2">
                                    <div>Wortel</div><div class="italic font-normal text-[11px] sm:text-xs">Carrot</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center align-middle" colspan="2">
                                    <div>Cabai Keriting</div><div class="italic font-normal text-[11px] sm:text-xs">Chilli/ Curly chilli</div>
                                </th>
                                <th class="border border-slate-700 bg-slate-200/50" colspan="2" rowspan="3"></th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                ${Array(3).fill(0).map(() => `<th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle text-xs"><div>${y1}</div></th><th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle text-xs"><div>${y2}</div></th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center font-bold text-xs">(1)</th>
                                ${[16, 17, 18, 19, 20, 21].map(n => `<th class="py-1 px-3 border border-slate-700 text-center font-bold text-xs">(${n})</th>`).join('')}
                            </tr>
                            ${renderRows('sec3', 6, true)}
                        </tbody>
                    `;
                }
            },
            '5.1.15': {
                titleId: 'Luas Areal Sawah Menurut Jenis Pengairan per Kecamatan di Kota Bukittinggi',
                titleEn: 'Area of Wetland by Type of Irrigation per District in Bukittinggi Municipality',
                isMultiYear: false,
                source: 'Dinas Pertanian dan Pangan Kota Bukittinggi / <span class="italic text-slate-500">Agriculture and Food Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const dists = [
                        '01. GUGUK PANJANG',
                        '02. MANDIANGIN KOTO SELAYAN',
                        '03. AUR BIRUGO TIGO BALEH'
                    ];

                    let rowsHtml = '';
                    dists.forEach(label => {
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td colspan="2" class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${label}</td>
                                ${Array(6).fill(0).map(() => `<td class="py-2.5 px-2 border border-slate-700 text-center"><input type="text" class="table-edit-input w-full text-center bg-white border border-slate-300 rounded px-2 py-1 text-xs" value="-"></td>`).join('')}
                            </tr>
                        `;
                    });

                    // 5 tahun berurutan dari atas: yr (2025) menurun ke yr - 4 (2021)
                    const yearsDesc = [];
                    for (let y = yr; y >= yr - 4; y--) {
                        yearsDesc.push(y);
                    }

                    yearsDesc.forEach((y, idx) => {
                        const isFirstYear = (idx === 0);
                        const rowCls = isFirstYear ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors font-medium';
                        const inputCls = isFirstYear ? 'bg-amber-50 font-bold' : 'bg-white';

                        rowsHtml += `
                            <tr class="${rowCls}">
                                ${isFirstYear ? `<td rowspan="5" class="py-2.5 px-4 border border-slate-700 text-center font-extrabold align-middle bg-[#fed7aa]">Jumlah / Total</td>` : ''}
                                <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle bg-[#fed7aa]">${y}</td>
                                ${Array(6).fill(0).map(() => `<td class="py-2.5 px-2 border border-slate-700 text-center"><input type="text" class="table-edit-input w-full text-center ${inputCls} border border-slate-300 rounded px-2 py-1 text-xs" value="-"></td>`).join('')}
                            </tr>
                        `;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="5">
                                    <div>Jenis Pengairan</div><div class="italic font-normal text-[11px] sm:text-xs">Type of Irrigation</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-3 border border-slate-700"><div>Teknis</div><div class="italic font-normal text-[10px]">Technical</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>½ Teknis</div><div class="italic font-normal text-[10px]">Semi Technical</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Sederhana</div><div class="italic font-normal text-[10px]">Simple</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Irigasi Non PU</div><div class="italic font-normal text-[10px]">Non PU Irrigation</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Tadah Hujan</div><div class="italic font-normal text-[10px]">Non Irrigation</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                                <th class="py-1 px-3 border border-slate-700">(5)</th>
                                <th class="py-1 px-3 border border-slate-700">(6)</th>
                                <th class="py-1 px-3 border border-slate-700">(7)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '5.1.16': {
                titleId: 'Target dan Realisasi Intensifikasi Palawija per Kecamatan di Kota Bukittinggi',
                titleEn: 'Target and Realization of Secondary Food Crops per District in Bukittinggi Municipality',
                isMultiYear: false,
                source: 'Dinas Pertanian dan Pangan Kota Bukittinggi / <span class="italic text-slate-500">Agriculture and Food Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const dists = [
                        '01. GUGUK PANJANG',
                        '02. MANDIANGIN KOTO SELAYAN',
                        '03. AUR BIRUGO TIGO BALEH'
                    ];

                    let rowsHtml = '';
                    dists.forEach(label => {
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td colspan="2" class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top min-w-[200px]">${label}</td>
                                ${Array(12).fill(0).map(() => `<td class="py-2 px-1 border border-slate-700 text-center min-w-[110px]"><input type="text" class="table-edit-input w-full text-center bg-white border border-slate-300 rounded px-1.5 py-1 text-xs font-semibold" value="-"></td>`).join('')}
                            </tr>
                        `;
                    });

                    // 5 tahun berurutan dari atas: yr (2025) menurun ke yr - 4 (2021)
                    const yearsDesc = [];
                    for (let y = yr; y >= yr - 4; y--) {
                        yearsDesc.push(y);
                    }

                    yearsDesc.forEach((y, idx) => {
                        const isFirstYear = (idx === 0);
                        const rowCls = isFirstYear ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors font-medium';
                        const inputCls = isFirstYear ? 'bg-amber-50 font-bold' : 'bg-white font-semibold';

                        rowsHtml += `
                            <tr class="${rowCls}">
                                ${isFirstYear ? `<td rowspan="5" class="py-2.5 px-4 border border-slate-700 text-center font-extrabold align-middle bg-[#fed7aa] min-w-[130px]">Jumlah / Total</td>` : ''}
                                <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle bg-[#fed7aa] min-w-[70px]">${y}</td>
                                ${Array(12).fill(0).map(() => `<td class="py-2 px-1 border border-slate-700 text-center min-w-[110px]"><input type="text" class="table-edit-input w-full text-center ${inputCls} border border-slate-300 rounded px-1.5 py-1 text-xs" value="-"></td>`).join('')}
                            </tr>
                        `;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3.5 px-4 font-bold border border-slate-700 min-w-[200px]" rowspan="2" colspan="2">
                                    <div class="text-xs sm:text-sm">Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs text-orange-100">District</div>
                                </th>
                                <th class="py-3 px-3 font-bold border border-slate-700 min-w-[700px]" colspan="6">
                                    <div class="text-xs sm:text-sm">Target</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs text-orange-100">Target</div>
                                </th>
                                <th class="py-3 px-3 font-bold border border-slate-700 min-w-[700px]" colspan="6">
                                    <div class="text-xs sm:text-sm">Realisasi</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs text-orange-100">Realization</div>
                                </th>
                            </tr>
                            <tr class="bg-[#ea580c] text-white text-center font-bold text-xs">
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[110px]">
                                    <div>Jagung</div><div class="italic font-normal text-[10px] text-orange-100">Maize</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[125px]">
                                    <div>Kacang Tanah</div><div class="italic font-normal text-[10px] text-orange-100">Peanuts</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[110px]">
                                    <div>Kedelai</div><div class="italic font-normal text-[10px] text-orange-100">Soybeans</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[125px]">
                                    <div>Kacang Hijau</div><div class="italic font-normal text-[10px] text-orange-100">Mungbeans</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[110px]">
                                    <div>Ubi Kayu</div><div class="italic font-normal text-[10px] text-orange-100">Cassava</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[125px]">
                                    <div>Ubi Jalar</div><div class="italic font-normal text-[10px] text-orange-100">Sweet Potatoes</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[110px]">
                                    <div>Jagung</div><div class="italic font-normal text-[10px] text-orange-100">Maize</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[125px]">
                                    <div>Kacang Tanah</div><div class="italic font-normal text-[10px] text-orange-100">Peanuts</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[110px]">
                                    <div>Kedelai</div><div class="italic font-normal text-[10px] text-orange-100">Soybeans</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[125px]">
                                    <div>Kacang Hijau</div><div class="italic font-normal text-[10px] text-orange-100">Mungbeans</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[110px]">
                                    <div>Ubi Kayu</div><div class="italic font-normal text-[10px] text-orange-100">Cassava</div>
                                </th>
                                <th class="py-2.5 px-2 border border-slate-700 min-w-[125px]">
                                    <div>Ubi Jalar</div><div class="italic font-normal text-[10px] text-orange-100">Sweet Potatoes</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1.5 px-3 border border-slate-700" colspan="2">(1)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(2)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(3)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(4)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(5)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(6)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(7)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(8)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(9)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(10)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(11)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(12)</th>
                                <th class="py-1.5 px-2 border border-slate-700">(13)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
});
