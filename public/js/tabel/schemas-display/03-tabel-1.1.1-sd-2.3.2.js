/** SiBingka - Skema tabel (tampilan / index): 1.1.1, 8.1.1, 8.1.2, 8.1.3, 8.1.4, 8.1.5, 8.1.6, 2.2.2, 2.2.5, 2.4.3, 2.4.5, 2.3.1, 2.3.2 */
Object.assign(window.tableSchemas, {
            '1.1.1': {
                titleId: 'Luas Daerah dan Jumlah Pulau Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Total Area and Number of Islands by Subdistrict in Bukittinggi Municipality',
                source: 'Badan Pusat Statistik Kota Bukittinggi / <span class="italic text-slate-500">BPS-Statistics of Bukittinggi Municipality</span>',
                render: function(year) {
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Subdistrict</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Luas</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Area</div>
                                    <div class="text-[11px] font-normal">(km² / sq.km)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Persentase Terhadap Luas Wilayah</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Percentage to Area</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Guguk Panjang</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">5,55</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">22,34</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Mandiangin Koto Selayan</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">12,86</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">51,77</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Aur Birugo Tigo Baleh</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">6,43</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">25,89</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Bukittinggi</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">24,84</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">100,00</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.1': {
                titleId: 'Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi',
                titleEn: 'Length of Road by Level of Government Authority in Bukittinggi Municipality (Km)',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                note: '<div class="space-y-1"><div>1. Data tidak termasuk panjang jalan tol / <span class="italic text-slate-500">Excluding toll road</span></div><div>2. Data tahun 2023 berdasarkan Keputusan Menteri Pekerjaan Umum dan Perumahan Rakyat No. 1688/KPTS/M/2022 / <span class="italic text-slate-500">Data of 2023 based on Public Works and Public Housing Ministerial Decree No. 1688/KPTS/M/2022</span></div></div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    // Data historis resmi dari database MySQL SiBingka Bukittinggi:
                    const dataStore = {
                        2019: { negara: '-', provinsi: '-', kota: '-', total: '-' },
                        2020: { negara: '11,75', provinsi: '-', kota: '180,17', total: '191,92' },
                        2021: { negara: '11,75', provinsi: '-', kota: '180,17', total: '191,92' },
                        2022: { negara: '11,75', provinsi: '-', kota: '180,17', total: '191,92' },
                        2023: { negara: '8,18',  provinsi: '-', kota: '198,3',  total: '206,48' },
                        2024: { negara: '8,18',  provinsi: '-', kota: '198,3',  total: '206,48' },
                        2025: { negara: '8,18',  provinsi: '-', kota: '198,3',  total: '206,48' },
                        2026: { negara: '-',     provinsi: '-', kota: '-',      total: '-' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (dataStore[y] && dataStore[y][key] !== undefined) return dataStore[y][key];
                        // Jika tahun belum ada datanya (misal 2019 atau >= 2026): jadikan strip (-)
                        if (y < 2020 || y >= 2026) return '-';
                        if (y <= 2022) {
                            return key === 'negara' ? '11,75' : key === 'provinsi' ? '-' : key === 'kota' ? '180,17' : '191,92';
                        }
                        if (y <= 2025) {
                            return key === 'negara' ? '8,18' : key === 'provinsi' ? '-' : key === 'kota' ? '198,3' : '206,48';
                        }
                        return '-';
                    };

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle">
                                    <div>Tingkat Kewenangan Pemerintahan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Level of Government Authority</div>
                                </th>
                                ${years.map(y => `<th class="py-3 px-4 border border-slate-700 text-center ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                ${years.map((y, idx) => `<th class="py-1 px-3 border border-slate-700 text-center">(${idx + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                    1. Negara / <span class="italic font-normal text-slate-700">State</span>
                                </td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'negara')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                    2. Provinsi / <span class="italic font-normal text-slate-700">Province</span>
                                </td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'provinsi')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                    3. Kota / <span class="italic font-normal text-slate-700">Municipality</span>
                                </td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'kota')}</td>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left">Jumlah / <span class="italic font-bold">Total</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-extrabold bg-amber-200/80' : ''}">${getVal(y, 'total')}</td>`).join('')}
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.2': {
                titleId: 'Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi (km)',
                titleEn: 'Length of Roads by Type of Road Surface in Bukittinggi Municipality (km)',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                isMultiYear: true,
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const dataStore812 = {
                        2020: { aspal: '180,17', kerikil: '-', tanah: '-',    lainnya: '-', total: '180,17' },
                        2021: { aspal: '180,17', kerikil: '-', tanah: '-',    lainnya: '-', total: '180,17' },
                        2022: { aspal: '180,17', kerikil: '-', tanah: '-',    lainnya: '-', total: '180,17' },
                        2023: { aspal: '192,18', kerikil: '-', tanah: '6,12', lainnya: '-', total: '198,3' },
                        2024: { aspal: '192,18', kerikil: '-', tanah: '6,12', lainnya: '-', total: '198,3' },
                        2025: { aspal: '192,18', kerikil: '-', tanah: '6,12', lainnya: '-', total: '198,3' },
                        2026: { aspal: '-',     kerikil: '-', tanah: '-',    lainnya: '-', total: '-' },
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        // Tahun 2019 ke bawah atau tahun 2026 ke atas yang belum dimasukkan datanya: WAJIB strip (-)
                        if (y <= 2019 || y >= 2026) {
                            return '-';
                        }
                        if (dataStore812[y] && dataStore812[y][key] !== undefined) {
                            return dataStore812[y][key];
                        }
                        return '-';
                    };

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jenis Permukaan Jalan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Road Surface</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700" colspan="5">
                                    <div>Tahun (km)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Year (km)</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs sm:text-sm">
                                ${years.map(y => `<th class="py-2 px-3 border border-slate-700 ${y === yr ? 'bg-amber-600 font-extrabold' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                ${years.map((y, idx) => `<th class="py-1 px-3 border border-slate-700">(${idx + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Aspal / <span class="italic font-normal text-slate-700">Paved</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'aspal')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Kerikil / <span class="italic font-normal text-slate-700">Gravel</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'kerikil')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Tanah / <span class="italic font-normal text-slate-700">Soil</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'tanah')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">4. Lainnya / <span class="italic font-normal text-slate-700">Others</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'lainnya')}</td>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / <span class="italic font-bold">Total</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-extrabold bg-amber-200/80' : ''}">${getVal(y, 'total')}</td>`).join('')}
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.3': {
                titleId: 'Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km)',
                titleEn: 'Length of Road by Condition of Road in Bukittinggi Municipality (km)',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                isMultiYear: true,
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    // Data riil resmi dari file Excel Dinas PUPR Kota Bukittinggi (2021-2025)
                    const dataStore813 = {
                        2021: { baik: '94,34',  sedang: '69,37', rusak: '15,83', rusak_berat: '0,63', total: '180,17' },
                        2022: { baik: '98,56',  sedang: '66,66', rusak: '14,52', rusak_berat: '0,43', total: '180,17' },
                        2023: { baik: '151,56', sedang: '29,78', rusak: '8,44',  rusak_berat: '8,52', total: '198,3' },
                        2024: { baik: '134,92', sedang: '47,02', rusak: '11,01', rusak_berat: '5,35', total: '198,3' },
                        2025: { baik: '131,05', sedang: '49,25', rusak: '12,87', rusak_berat: '5,13', total: '198,3' },
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) {
                            if (serverDbDataStore[y][key] !== undefined) return serverDbDataStore[y][key];
                            if (key === 'rusak' && serverDbDataStore[y]['rusak_ringan'] !== undefined) return serverDbDataStore[y]['rusak_ringan'];
                            if (key === 'rusak_ringan' && serverDbDataStore[y]['rusak'] !== undefined) return serverDbDataStore[y]['rusak'];
                        }
                        // Tahun yang belum dimasukkan datanya (<= 2020 atau >= 2026): WAJIB strip (-)
                        if (y <= 2020 || y >= 2026) {
                            return '-';
                        }
                        if (dataStore813[y]) {
                            if (dataStore813[y][key] !== undefined) return dataStore813[y][key];
                            if (key === 'rusak' && dataStore813[y]['rusak_ringan'] !== undefined) return dataStore813[y]['rusak_ringan'];
                            if (key === 'rusak_ringan' && dataStore813[y]['rusak'] !== undefined) return dataStore813[y]['rusak'];
                        }
                        return '-';
                    };

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Kondisi Jalan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Road Condition</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700" colspan="5">
                                    <div>Tahun (km)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Year (km)</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs sm:text-sm">
                                ${years.map(y => `<th class="py-2 px-3 border border-slate-700 ${y === yr ? 'bg-amber-600 font-extrabold' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                ${years.map((y, idx) => `<th class="py-1 px-3 border border-slate-700">(${idx + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Baik / Good</td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'baik')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Sedang / Moderate</td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'sedang')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Rusak / Damage</td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'rusak')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">4. Rusak Berat / Severely Damage</td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'rusak_berat')}</td>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / Total</td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-extrabold bg-amber-200/80' : ''}">${getVal(y, 'total')}</td>`).join('')}
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.4': {
                titleId: 'Banyak dan Panjang Jembatan, Panjang Trotoar Kota Bukittinggi',
                titleEn: 'Number and Length of Bridge, Length of Sidewalk in Bukittinggi',
                isMultiYear: true,
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2026;

                    // Data riil resmi BPS / Dinas PUPR Kota Bukittinggi per Kecamatan
                    const defaultKec814 = {
                        2025: { gp_u: '11', gp_p: '75,5', mks_u: '17', mks_p: '113', abt_u: '10', abt_p: '108,4' },
                        2024: { gp_u: '11', gp_p: '75,5', mks_u: '9',  mks_p: '75',  abt_u: '17', abt_p: '108,4' },
                        2023: { gp_u: '11', gp_p: '75,5', mks_u: '9',  mks_p: '75',  abt_u: '17', abt_p: '108,4' }
                    };
                    const defKec = defaultKec814[yr] || { gp_u: '-', gp_p: '-', mks_u: '-', mks_p: '-', abt_u: '-', abt_p: '-' };

                    // Ambil nilai dari serverDbDataStore jika ada
                    const storeYr = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                    const gP_unit  = (storeYr['guguk_panjang_unit'] !== undefined && storeYr['guguk_panjang_unit'] !== '') ? storeYr['guguk_panjang_unit'] : defKec.gp_u;
                    const gP_len   = (storeYr['guguk_panjang_panjang'] !== undefined && storeYr['guguk_panjang_panjang'] !== '') ? storeYr['guguk_panjang_panjang'] : defKec.gp_p;
                    const mks_unit = (storeYr['mandiangin_koto_selayan_unit'] !== undefined && storeYr['mandiangin_koto_selayan_unit'] !== '') ? storeYr['mandiangin_koto_selayan_unit'] : defKec.mks_u;
                    const mks_len  = (storeYr['mandiangin_koto_selayan_panjang'] !== undefined && storeYr['mandiangin_koto_selayan_panjang'] !== '') ? storeYr['mandiangin_koto_selayan_panjang'] : defKec.mks_p;
                    const abt_unit = (storeYr['aur_birugo_tigo_baleh_unit'] !== undefined && storeYr['aur_birugo_tigo_baleh_unit'] !== '') ? storeYr['aur_birugo_tigo_baleh_unit'] : defKec.abt_u;
                    const abt_len  = (storeYr['aur_birugo_tigo_baleh_panjang'] !== undefined && storeYr['aur_birugo_tigo_baleh_panjang'] !== '') ? storeYr['aur_birugo_tigo_baleh_panjang'] : defKec.abt_p;

                    // Daftar 5 tahun sesuai periode (misal 2026-2030 -> [2030, 2029, 2028, 2027, 2026])
                    const p = get5YearPeriod(yr);
                    const summaryYears = p.yearsDesc;
                    const defaultTotals = {
                        2025: { unit: '38', len: '296,9' },
                        2024: { unit: '37', len: '258,9' },
                        2023: { unit: '37', len: '258,9' },
                        2022: { unit: '34', len: '242,12' },
                        2021: { unit: '34', len: '242,12' }
                    };

                    let jumlahRowsHtml = '';
                    summaryYears.forEach((y, idx) => {
                        const sData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) ? serverDbDataStore[y] : {};
                        const def = defaultTotals[y] || { unit: '-', len: '-' };
                        const valUnit = (sData['total_unit'] !== undefined && sData['total_unit'] !== '') ? sData['total_unit'] : def.unit;
                        const valLen  = (sData['total_panjang'] !== undefined && sData['total_panjang'] !== '') ? sData['total_panjang'] : def.len;

                        jumlahRowsHtml += `<tr>`;
                        if (idx === 0) {
                            jumlahRowsHtml += `
                                <td class="py-2.5 px-4 font-bold border border-slate-700 text-center align-middle bg-amber-50/70" rowspan="${summaryYears.length}">
                                    <div>Jumlah</div>
                                    <div class="italic font-normal text-xs text-slate-600">Total</div>
                                </td>
                            `;
                        }
                        jumlahRowsHtml += `
                            <td class="py-2 px-3 font-bold border border-slate-700 text-center">${y}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 ${idx === 0 ? 'font-semibold' : ''}">${valUnit}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 ${idx === 0 ? 'font-semibold' : ''}">${valLen}</td>
                        </tr>`;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[50%]" colspan="2" rowspan="2">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-4 font-bold border border-slate-700 text-center w-[50%]" colspan="2">
                                    <div>Jembatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Bridge</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2 px-3 font-bold border border-slate-700 w-[25%]">
                                    <div>Banyaknya</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 w-[25%]">
                                    <div>Panjang</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Length</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center" colspan="2">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">01. GUGUK PANJANG</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${gP_unit}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${gP_len}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">02. MANDIANGIN KOTO SELAYAN</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${mks_unit}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${mks_len}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">03. AUR BIRUGO TIGO BALEH</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${abt_unit}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${abt_len}</td>
                            </tr>
                            ${jumlahRowsHtml}
                        </tbody>
                    `;
                }
            },
            '8.1.5': {
                titleId: 'Panjang Gorong–Gorong dan Panjang Drainase Kota Bukittinggi',
                titleEn: 'Length of Sewerage and Drainage in Bukittinggi',
                isMultiYear: true,
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;

                    // Data riil resmi BPS / Dinas PUPR Kota Bukittinggi per Kecamatan
                    // Hanya tahun yang sudah diinput oleh pengguna (2024 & 2025). Tahun yang belum diinput dikosongkan (-)
                    const defaultKec815 = {
                        2025: { gp: '39013,13', mks: '65078,7', abt: '39474,49' },
                        2024: { gp: '38856,93', mks: '64961,5', abt: '39066,19' }
                    };
                    const defKec = defaultKec815[yr] || { gp: '-', mks: '-', abt: '-' };

                    // Ambil nilai dari serverDbDataStore jika ada
                    const storeYr = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                    const gP  = (storeYr['guguk_panjang'] !== undefined && storeYr['guguk_panjang'] !== '') ? storeYr['guguk_panjang'] : defKec.gp;
                    const mks = (storeYr['mandiangin_koto_selayan'] !== undefined && storeYr['mandiangin_koto_selayan'] !== '') ? storeYr['mandiangin_koto_selayan'] : defKec.mks;
                    const abt = (storeYr['aur_birugo_tigo_baleh'] !== undefined && storeYr['aur_birugo_tigo_baleh'] !== '') ? storeYr['aur_birugo_tigo_baleh'] : defKec.abt;

                    // Daftar 5 tahun sesuai periode tahun aktif
                    const p = get5YearPeriod(yr);
                    const summaryYears = p.yearsDesc;
                    // Data yang sudah diinput oleh pengguna (2025: 143566,32; 2024: 142884,62).
                    const defaultTotals = {
                        2025: '143566,32',
                        2024: '142884,62'
                    };

                    let jumlahRowsHtml = '';
                    summaryYears.forEach((y, idx) => {
                        const sData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) ? serverDbDataStore[y] : {};
                        const def = defaultTotals[y] || '-';
                        const valTotal = (sData['total'] !== undefined && sData['total'] !== '') ? sData['total'] : def;

                        jumlahRowsHtml += `<tr>`;
                        if (idx === 0) {
                            jumlahRowsHtml += `
                                <td class="py-2.5 px-4 font-bold border border-slate-700 text-center align-middle bg-amber-50/70" rowspan="${summaryYears.length}">
                                    <div>Jumlah</div>
                                    <div class="italic font-normal text-xs text-slate-600">Total</div>
                                </td>
                            `;
                        }
                        jumlahRowsHtml += `
                            <td class="py-2 px-3 font-bold border border-slate-700 text-center">${y}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 ${idx === 0 ? 'font-semibold' : ''}">${valTotal}</td>
                        </tr>`;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[60%]" colspan="2">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 text-center w-[40%]">
                                    <div>Drainase (m)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Drainage</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center" colspan="2">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">01. GUGUK PANJANG</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${gP}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">02. MANDIANGIN KOTO SELAYAN</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${mks}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">03. AUR BIRUGO TIGO BALEH</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${abt}</td>
                            </tr>
                            ${jumlahRowsHtml}
                        </tbody>
                    `;
                }
            },
            '8.1.6': {
                titleId: 'Jumlah Mobil Penumpang Menurut Jenisnya di Kota Bukittinggi',
                titleEn: 'Number of Passenger Cars by Kind of Vehicles in Bukittinggi Municipality',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Perhubungan Kota Bukittinggi / <span class="italic text-slate-500">Transportation Services of Bukittinggi Municipality</span>',
                note: null,
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const startYr = yr - 6;
                    const years = [];
                    for (let y = startYr; y <= yr; y++) {
                        years.push(y);
                    }

                    const dataStore = {
                        2015: { bemo: '-', angkot: '540', bus: '-', taksi: '-', total: '540' },
                        2016: { bemo: '-', angkot: '540', bus: '-', taksi: '-', total: '540' },
                        2017: { bemo: '-', angkot: '540', bus: '-', taksi: '-', total: '540' },
                        2018: { bemo: '-', angkot: '540', bus: '-', taksi: '-', total: '540' },
                        2019: { bemo: '-', angkot: '539', bus: '-', taksi: '-', total: '539' },
                        2020: { bemo: '-', angkot: '539', bus: '-', taksi: '-', total: '539' },
                        2021: { bemo: '-', angkot: '539', bus: '-', taksi: '-', total: '539' },
                        2022: { bemo: '-', angkot: '489', bus: '-', taksi: '-', total: '489' },
                        2023: { bemo: '-', angkot: '466', bus: '-', taksi: '-', total: '466' },
                        2024: { bemo: '-', angkot: '466', bus: '-', taksi: '-', total: '466' },
                        2025: { bemo: '-', angkot: '466', bus: '-', taksi: '-', total: '466' }
                    };

                    let bodyRows = '';
                    years.forEach(y => {
                        let d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) 
                            ? serverDbDataStore[y] 
                            : (dataStore[y] || { bemo: '-', angkot: '-', bus: '-', taksi: '-', total: '-' });

                        bodyRows += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${y}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${d.bemo || '-'}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${d.angkot || '-'}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${d.bus || '-'}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${d.taksi || '-'}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${d.total || '-'}</td>
                            </tr>
                        `;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Tahun</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Year</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                    <div>Jenis Kendaraan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Kind of Vehicles</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Bemo</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Tricycle Motor</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Angkutan Kota</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Municipality Transport</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Bus Umum</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Public Bus</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Taksi</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Taxi</div>
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
                            ${bodyRows}
                        </tbody>
                    `;
                }
            },
                        '2.2.2': {
                titleId: 'Jumlah Anggota Dewan Perwakilan Rakyat Menurut Partai Politik dan Tingkat Pendidikan di Kota Bukittinggi',
                titleEn: 'Number of Regional House of Representative’s Member by Political and Education in Bukittinggi Municipality',
                source: 'Komisi Pemilihan Umum Kota Bukittinggi / <span class="italic text-slate-500">General Election Commission of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2024;
                    const officialData = [
                        { name: '1. Partai Kebangkitan Bangsa', v: ['0', '1', '1', '0', '2'] },
                        { name: '2. Partai Gerindra', v: ['0', '0', '4', '0', '4'] },
                        { name: '3. PDI Perjuangan', v: ['0', '0', '0', '0', '0'] },
                        { name: '4. Partai Golkar', v: ['0', '0', '3', '0', '3'] },
                        { name: '5. Partai Nasdem', v: ['1', '1', '1', '1', '4'] },
                        { name: '6. Partai Buruh', v: ['0', '0', '0', '0', '0'] },
                        { name: '7. Partai Gelombang Rakyat Indonesia', v: ['0', '0', '0', '0', '0'] },
                        { name: '8. Partai Keadilan Sejahtera', v: ['0', '0', '4', '1', '5'] },
                        { name: '9. Partai Kebangkitan Nusantara', v: ['0', '0', '0', '0', '0'] },
                        { name: '10. Partai Hati Nurani Rakyat', v: ['0', '0', '0', '0', '0'] },
                        { name: '11. Partai Garda Perubahan Indonesia', v: ['0', '0', '0', '0', '0'] },
                        { name: '12. Partai Amanat Nasional', v: ['1', '0', '2', '0', '3'] },
                        { name: '13. Partai Bulan Bintang', v: ['0', '0', '0', '0', '0'] },
                        { name: '14. Partai Demokrat', v: ['0', '0', '2', '1', '3'] },
                        { name: '15. Partai Solidaritas Indonesia', v: ['0', '0', '0', '0', '0'] },
                        { name: '16. Partai Perindo', v: ['0', '0', '0', '0', '0'] },
                        { name: '17. Partai Persatuan Pembangunan', v: ['1', '0', '1', '0', '2'] },
                        { name: '18. Partai Ummat', v: ['0', '0', '0', '0', '0'] }
                    ];
                    let totSMU = 0, totD3 = 0, totS1 = 0, totS2 = 0, totAll = 0;
                    const rowsHtml = officialData.map(p => {
                        const smu = p.v[0] || '-';
                        const d3 = p.v[1] || '-';
                        const s1 = p.v[2] || '-';
                        const s2 = p.v[3] || '-';
                        const tot = p.v[4] || '-';
                        totSMU += parseInt(smu) || 0;
                        totD3 += parseInt(d3) || 0;
                        totS1 += parseInt(s1) || 0;
                        totS2 += parseInt(s2) || 0;
                        totAll += parseInt(tot) || 0;
                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${p.name}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${smu}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${d3}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${s1}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${s2}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${tot}</td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Partai</div><div class="italic font-normal text-[11px] sm:text-xs">Party</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                    <div>Pendidikan</div><div class="italic font-normal text-[11px] sm:text-xs">Education</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>SMU</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>DIII</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>DIV</div><div class="italic font-normal text-[11px] sm:text-xs">S1</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>
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
                            <tr class="hover:bg-amber-100/60 transition-colors bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / Total</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${totSMU || 3}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${totD3 || 2}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${totS1 || 17}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${totS2 || 3}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${totAll || 25}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '2.2.5': {
                titleId: 'Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi',
                titleEn: 'Regional Representative Decision by Type of Decision in Bukittinggi Municipality',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'DPRD Kota Bukittinggi / <span class="italic text-slate-500">Representative of Bukittinggi Municipality</span>',
                note: null,
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    // Data historis resmi dari database MySQL SiBingka Bukittinggi:
                    const dataStore = {
                        2021: { peraturan_daerah: '12', keputusan_dprd: '45', keputusan_pimpinan: '–', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '28', paripurna_istimewa: '9', panitia_musyawarah: '23', badan_kehormatan: '3', badan_anggaran: '75', panitia_khusus: '60', gabungan_komisi: '25', rapat_komisi: '70', turun_lapangan: '6', keluar_daerah: '–', rapat_kerja: '–', penyampaian_aspirasi: '5', study_banding: '12', reses: '3', kunker_komisi: '3', total: '379' },
                        2022: { peraturan_daerah: '8', keputusan_dprd: '44', keputusan_pimpinan: '1', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '3', paripurna_terbuka: '20', paripurna_istimewa: '5', panitia_musyawarah: '22', badan_kehormatan: '4', badan_anggaran: '36', panitia_khusus: '56', gabungan_komisi: '27', rapat_komisi: '26', turun_lapangan: '1', keluar_daerah: '8', rapat_kerja: '9', penyampaian_aspirasi: '21', study_banding: '5', reses: '3', kunker_komisi: '3', total: '322' },
                        2023: { peraturan_daerah: '9', keputusan_dprd: '37', keputusan_pimpinan: '3', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '18', paripurna_istimewa: '5', panitia_musyawarah: '18', badan_kehormatan: '2', badan_anggaran: '80', panitia_khusus: '81', gabungan_komisi: '33', rapat_komisi: '12', turun_lapangan: '2', keluar_daerah: '–', rapat_kerja: '10', penyampaian_aspirasi: '9', study_banding: '23', reses: '3', kunker_komisi: '3', total: '348' },
                        2024: { peraturan_daerah: '8', keputusan_dprd: '34', keputusan_pimpinan: '1', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '19', paripurna_istimewa: '8', panitia_musyawarah: '16', badan_kehormatan: '2', badan_anggaran: '50', panitia_khusus: '60', gabungan_komisi: '30', rapat_komisi: '10', turun_lapangan: '–', keluar_daerah: '–', rapat_kerja: '5', penyampaian_aspirasi: '8', study_banding: '20', reses: '3', kunker_komisi: '4', total: '278' },
                        2025: { peraturan_daerah: '10', keputusan_dprd: '28', keputusan_pimpinan: '4', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '27', paripurna_istimewa: '6', panitia_musyawarah: '10', badan_kehormatan: '2', badan_anggaran: '51', panitia_khusus: '41', gabungan_komisi: '17', rapat_komisi: '13', turun_lapangan: '10', keluar_daerah: '–', rapat_kerja: '5', penyampaian_aspirasi: '12', study_banding: '3', reses: '3', kunker_komisi: '3', total: '245' },
                        2026: { peraturan_daerah: '–', keputusan_dprd: '–', keputusan_pimpinan: '–', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '–', paripurna_istimewa: '–', panitia_musyawarah: '–', badan_kehormatan: '–', badan_anggaran: '–', panitia_khusus: '–', gabungan_komisi: '–', rapat_komisi: '–', turun_lapangan: '–', keluar_daerah: '–', rapat_kerja: '–', penyampaian_aspirasi: '–', study_banding: '–', reses: '–', kunker_komisi: '–', total: '–' }
                    };

                    const rows = [
                        { key: 'peraturan_daerah', label: '01. Peraturan daerah' },
                        { key: 'keputusan_dprd', label: '02. Keputusan DPRD' },
                        { key: 'keputusan_pimpinan', label: '03. Keputusan Pimpinan' },
                        { key: 'pernyataan', label: '04. Pernyataan' },
                        { key: 'pernyataan_pendapat', label: '05. Pernyataan Pendapat' },
                        { key: 'resolusi', label: '06. Resolusi' },
                        { key: 'dengar_pendapat', label: '07. Dengar Pendapat dengan Pemerintah' },
                        { key: 'paripurna_terbuka', label: '08. Rapat Paripurna Terbuka' },
                        { key: 'paripurna_istimewa', label: '09. Rapat Paripurna Istimewa' },
                        { key: 'panitia_musyawarah', label: '10. Rapat Panitia Musyawarah' },
                        { key: 'badan_kehormatan', label: '11. Rapat Badan Kehormatan' },
                        { key: 'badan_anggaran', label: '12. Rapat Panitia / Badan Anggaran' },
                        { key: 'panitia_khusus', label: '13. Rapat Panitia Khusus' },
                        { key: 'gabungan_komisi', label: '14. Rapat Gabungan Komisi' },
                        { key: 'rapat_komisi', label: '15. Rapat Komisi' },
                        { key: 'turun_lapangan', label: '16. Turun ke Lapangan ke Kelurahan' },
                        { key: 'keluar_daerah', label: '17. Keluar Daerah' },
                        { key: 'rapat_kerja', label: '18. Rapat Kerja' },
                        { key: 'penyampaian_aspirasi', label: '19. Penyampaian Aspirasi' },
                        { key: 'study_banding', label: '20. Study Banding' },
                        { key: 'reses', label: '21. Reses' },
                        { key: 'kunker_komisi', label: '22. Kunker Komisi' }
                    ];

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                            return serverDbDataStore[y][key];
                        }
                        if (dataStore[y] && dataStore[y][key] !== undefined) return dataStore[y][key];
                        return '–';
                    };

                    const calcTotal = (y) => {
                        let sum = 0;
                        let hasData = false;
                        rows.forEach(r => {
                            const val = getVal(y, r.key);
                            if (val !== '–' && val !== '-' && val !== '' && !isNaN(parseFloat(val))) {
                                sum += parseFloat(val);
                                hasData = true;
                            }
                        });
                        const storedTotal = getVal(y, 'total');
                        if (storedTotal !== '–' && storedTotal !== '-' && storedTotal !== '') return storedTotal;
                        return hasData ? sum : '–';
                    };

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle min-w-[280px]">
                                    <div>Jenis Keputusan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type Of Decision</div>
                                </th>
                                ${years.map(y => `<th class="py-3 px-4 border border-slate-700 text-center ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                ${years.map((y, idx) => `<th class="py-1 px-3 border border-slate-700 text-center">(${idx + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rows.map(r => `
                                <tr>
                                    <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                        ${r.label}
                                    </td>
                                    ${years.map(y => `<td class="py-2 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, r.key)}</td>`).join('')}
                                </tr>
                            `).join('')}
                        </tbody>
                    `;
                }
            },
            '2.4.3': {
                titleId: 'Realisasi Pembiayaan Pemerintah Daerah Kota Bukittinggi (Rupiah)',
                titleEn: 'Realization of Bukittinggi Local Government Cost Budgeting (Rupiah)',
                source: 'Badan Keuangan Daerah Kota Bukittinggi / <span class="italic text-slate-500">Financial Office of Bukittinggi Municipality</span>',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const dataStore243 = {
                        2020: ['206,824', '107,774', '99,050', '-', '-', '-', '99,386', '206,824'],
                        2021: ['94,404', '94,377', '27', '-', '-', '-', '132,988', '99,404'],
                        2022: ['132,979', '132,979', '-', '10,000', '-', '10,000', '77,322', '122,979'],
                        2023: ['77,322', '77,322', '-', '-', '-', '-', '33,058', '77,322'],
                        2024: ['77,323', '33,058', '-', '-', '-', '-', '33,058', '35,348'],
                        2025: ['35.363.273.389,89', '35.363.273.389,89', '-', '-', '-', '-', '35.363.273.389,89', '35.363.273.389,89']
                    };

                    const rowLabels = [
                        'PENERIMAAN PEMBIAYAAN DAERAH / <span class="italic font-normal text-slate-700">REGIONAL COST EXPENDITURE</span>',
                        'Sisa Lebih Perhitungan Anggaran Tahun Sebelumnya / <span class="italic font-normal text-slate-700">Remaining of Budgeting Last Year</span>',
                        'Pencairan Dana Cadangan / <span class="italic font-normal text-slate-700">Disbursement of Reserve Funds</span>',
                        'PENGELUARAN PEMBIAYAAN DAERAH / <span class="italic font-normal text-slate-700">REGIONAL DEFRAYAL EXPENDITURE</span>',
                        'Pembentukan Dana Cadangan / <span class="italic font-normal text-slate-700">Remind of Reserve Fund</span>',
                        'Investasi Pemerintah Daerah / <span class="italic font-normal text-slate-700">Government Invesment</span>',
                        'SISA LEBIH PEMBIAYAAN ANGGARAN TAHUN BERKENAAN / <span class="italic font-normal text-slate-700">REMAINING</span>',
                        'PEMBIAYAAN DAERAH (1–2)'
                    ];

                    let theadYearsHtml = '';
                    let theadNumHtml = '';
                    years.forEach((y, idx) => {
                        theadYearsHtml += `<th class="py-3 px-4 font-bold border border-slate-700 ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}"><div>${y}</div></th>`;
                        theadNumHtml += `<th class="py-1 px-3 border border-slate-700 text-center">(${idx + 2})</th>`;
                    });

                    let tbodyHtml = '';
                    rowLabels.forEach((label, rIdx) => {
                        let rowTds = '';
                        years.forEach(y => {
                            let val = (dataStore243[y] && dataStore243[y][rIdx] !== undefined) ? dataStore243[y][rIdx] : '-';
                            rowTds += `<td class="py-2.5 px-4 border border-slate-700 text-right font-semibold align-top">${val}</td>`;
                        });
                        tbodyHtml += `<tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${label}</td>
                            ${rowTds}
                        </tr>`;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle">
                                    <div>Jenis Pembiayaan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Kind of Cost</div>
                                </th>
                                ${theadYearsHtml}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                ${theadNumHtml}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${tbodyHtml}
                        </tbody>
                    `;
                }
            },
            '2.4.5': {
                titleId: 'Realisasi Pembiayaan Pemerintah Daerah Kota Bukittinggi Tahun Anggaran (jutaan rupiah)',
                titleEn: 'Realization of Bukittinggi Local Government Cost Budgeting Year (million rupiah)',
                source: 'Badan Keuangan Daerah Kota Bukittinggi / <span class="italic text-slate-500">Financial Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const rows = [
                        { label: 'PBB / <span class="italic font-normal text-slate-700">Earth and Building Tax</span>', target: '5.226.842.474', realisasi: '6.071.791.061', persen: '116,17' },
                        { label: '– Pedesaan / <span class="italic font-normal text-slate-700">Rural</span>', target: '-', realisasi: '-', persen: '-' },
                        { label: '– Perkotaan / <span class="italic font-normal text-slate-700">Urban</span>', target: '5.226.842.474', realisasi: '6.071.791.061', persen: '116,17' },
                        { label: '– Perhutanan / <span class="italic font-normal text-slate-700">Foresty</span>', target: '-', realisasi: '-', persen: '-' },
                        { label: '– Perkebunan / <span class="italic font-normal text-slate-700">Estates Crops</span>', target: '-', realisasi: '-', persen: '-' },
                        { label: '– Pertambangan / <span class="italic font-normal text-slate-700">Mining</span>', target: '-', realisasi: '-', persen: '-' },
                        { label: '– Migas / <span class="italic font-normal text-slate-700">Oil and Gas</span>', target: '-', realisasi: '-', persen: '-' },
                        { label: '– Non Migas / <span class="italic font-normal text-slate-700">Non Oil and Gas</span>', target: '-', realisasi: '-', persen: '-' },
                        { label: 'BPHTB', target: '13.551.289.266', realisasi: '16.422.454.085', persen: '121,19' }
                    ];
                    const is2025 = yr === 2025;
                    let tbodyHtml = '';
                    rows.forEach(r => {
                        const tVal = is2025 ? r.target : '-';
                        const rVal = is2025 ? r.realisasi : '-';
                        const pVal = is2025 ? r.persen : '-';
                        tbodyHtml += `<tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${r.label}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-right font-semibold align-top">${tVal}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-right font-semibold align-top">${rVal}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-right font-semibold align-top">${pVal}</td>
                        </tr>`;
                    });
                    const totT = is2025 ? '18.778.131.740' : '-';
                    const totR = is2025 ? '22.494.245.146' : '-';
                    const totP = is2025 ? '119,79' : '-';

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Sektor</div><div class="italic font-normal text-[11px] sm:text-xs">Sector</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Target</div><div class="italic font-normal text-[11px] sm:text-xs">Target</div>
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
                            ${tbodyHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">
                                    Jumlah / <span class="italic font-bold">Total</span>
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right font-semibold align-top font-extrabold">${totT}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right font-semibold align-top font-extrabold">${totR}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right font-semibold align-top font-extrabold">${totP}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '2.3.1': {
                titleId: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan, Jenis ASN, dan Jenis Kelamin (orang)',
                titleEn: 'Number of State Civil Apparatus (ASN) of Bukittinggi Municipal Government by Occupation, Type of ASN, and Sex (people)',
                source: 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / <span class="italic text-slate-500">Human Resources and Development Agency of Bukittinggi Municipality</span>',
                note: (yr) => '<div>Data per-31 Desember ' + (yr || currentYear || '2025') + '</div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                    const defaultData231 = {
                        2025: {
                            jpt_utama:     { pns_l: '0',   pns_p: '0',    pppk_l: '0',  pppk_p: '0' },
                            jpt_madya:     { pns_l: '0',   pns_p: '0',    pppk_l: '0',  pppk_p: '0' },
                            jpt_pratama:   { pns_l: '17',  pns_p: '5',    pppk_l: '0',  pppk_p: '0' },
                            administrator: { pns_l: '62',  pns_p: '48',   pppk_l: '0',  pppk_p: '0' },
                            pengawas:      { pns_l: '110', pns_p: '140',  pppk_l: '0',  pppk_p: '0' },
                            eselon5:       { pns_l: '0',   pns_p: '0',    pppk_l: '0',  pppk_p: '0' },
                            dosen:         { pns_l: '0',   pns_p: '0',    pppk_l: '0',  pppk_p: '0' },
                            guru:          { pns_l: '99',  pns_p: '469',  pppk_l: '60', pppk_p: '201' },
                            medis:         { pns_l: '28',  pns_p: '293',  pppk_l: '21', pppk_p: '125' },
                            teknis:        { pns_l: '76',  pns_p: '202',  pppk_l: '70', pppk_p: '38' },
                            pelaksana:     { pns_l: '375', pns_p: '324',  pppk_l: '94', pppk_p: '47' }
                        }
                    };

                    const rows = [
                        { key: 'jpt_utama',     labelId: 'Jabatan Pimpinan Tinggi Utama', labelEn: 'Senior Executives' },
                        { key: 'jpt_madya',     labelId: 'Jabatan Pimpinan Tinggi Madya', labelEn: 'Middle Executives' },
                        { key: 'jpt_pratama',   labelId: 'Jabatan Pimpinan Tinggi Pratama', labelEn: 'Junior Executives' },
                        { key: 'administrator', labelId: 'Administrator', labelEn: 'Administrator' },
                        { key: 'pengawas',      labelId: 'Pengawas', labelEn: 'Supervisor' },
                        { key: 'eselon5',       labelId: 'Eselon V', labelEn: '5th Echelon' },
                        { key: 'dosen',         labelId: 'Jabatan Fungsional Dosen', labelEn: 'Certain Functional Position for Lecturer' },
                        { key: 'guru',          labelId: 'Jabatan Fungsional Guru', labelEn: 'Certain Functional Position for Teacher' },
                        { key: 'medis',         labelId: 'Jabatan Fungsional Medis', labelEn: 'Certain Functional Position for Medical Field' },
                        { key: 'teknis',        labelId: 'Jabatan Fungsional Teknis', labelEn: 'Certain Functional Position for Technical Field' },
                        { key: 'pelaksana',     labelId: 'Jabatan Fungsional Umum/Pelaksana', labelEn: 'General Functional Position' }
                    ];

                    const yrDefaults = defaultData231[yr] || {};

                    let totPnsL = 0, totPnsP = 0, totPnsJml = 0;
                    let totPppkL = 0, totPppkP = 0, totPppkJml = 0;
                    let totAsnL = 0, totAsnP = 0, totAsnJml = 0;
                    let hasData = false;

                    let rowsHtml = '';
                    rows.forEach(r => {
                        const def = yrDefaults[r.key] || { pns_l: '-', pns_p: '-', pppk_l: '-', pppk_p: '-' };

                        const pnsLStr = (d[`${r.key}_pns_l`] !== undefined && d[`${r.key}_pns_l`] !== '') ? d[`${r.key}_pns_l`] : def.pns_l;
                        const pnsPStr = (d[`${r.key}_pns_p`] !== undefined && d[`${r.key}_pns_p`] !== '') ? d[`${r.key}_pns_p`] : def.pns_p;
                        const pppkLStr = (d[`${r.key}_pppk_l`] !== undefined && d[`${r.key}_pppk_l`] !== '') ? d[`${r.key}_pppk_l`] : def.pppk_l;
                        const pppkPStr = (d[`${r.key}_pppk_p`] !== undefined && d[`${r.key}_pppk_p`] !== '') ? d[`${r.key}_pppk_p`] : def.pppk_p;

                        const numPnsL = parseFloat(String(pnsLStr).replace(',', '.')) || 0;
                        const numPnsP = parseFloat(String(pnsPStr).replace(',', '.')) || 0;
                        const numPppkL = parseFloat(String(pppkLStr).replace(',', '.')) || 0;
                        const numPppkP = parseFloat(String(pppkPStr).replace(',', '.')) || 0;

                        const isPnsLSet = (pnsLStr !== '-' && pnsLStr !== '');
                        const isPnsPSet = (pnsPStr !== '-' && pnsPStr !== '');
                        const isPppkLSet = (pppkLStr !== '-' && pppkLStr !== '');
                        const isPppkPSet = (pppkPStr !== '-' && pppkPStr !== '');

                        if (isPnsLSet || isPnsPSet || isPppkLSet || isPppkPSet) {
                            hasData = true;
                        }

                        const pnsJml = (isPnsLSet || isPnsPSet) ? (numPnsL + numPnsP) : '-';
                        const pppkJml = (isPppkLSet || isPppkPSet) ? (numPppkL + numPppkP) : '-';
                        const totalL = (isPnsLSet || isPppkLSet) ? (numPnsL + numPppkL) : '-';
                        const totalP = (isPnsPSet || isPppkPSet) ? (numPnsP + numPppkP) : '-';
                        const totalJml = (pnsJml !== '-' || pppkJml !== '-') ? ((typeof pnsJml === 'number' ? pnsJml : 0) + (typeof pppkJml === 'number' ? pppkJml : 0)) : '-';

                        if (typeof pnsJml === 'number') {
                            totPnsL += numPnsL;
                            totPnsP += numPnsP;
                            totPnsJml += pnsJml;
                        }
                        if (typeof pppkJml === 'number') {
                            totPppkL += numPppkL;
                            totPppkP += numPppkP;
                            totPppkJml += pppkJml;
                        }
                        if (typeof totalJml === 'number') {
                            totAsnL += (typeof totalL === 'number' ? totalL : 0);
                            totAsnP += (typeof totalP === 'number' ? totalP : 0);
                            totAsnJml += totalJml;
                        }

                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors" data-key="${r.key}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                    <div>${r.labelId}</div>
                                    <div class="italic font-normal text-xs text-slate-600">${r.labelEn}</div>
                                </td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pnsLStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pnsPStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-bold bg-amber-50/50">${pnsJml}</td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pppkLStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pppkPStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-bold bg-amber-50/50">${pppkJml}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-medium">${totalL}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-medium">${totalP}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${totalJml}</td>
                            </tr>
                        `;
                    });

                    // Baris Total / Jumlah
                    rowsHtml += `
                        <tr class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700" data-total="true">
                            <td class="py-2.5 px-4 font-bold border border-slate-700 text-left">
                                <div>Jumlah</div>
                                <div class="italic font-normal text-xs text-slate-700">Total</div>
                            </td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totPnsL : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totPnsP : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${hasData ? totPnsJml : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totPppkL : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totPppkP : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${hasData ? totPppkJml : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totAsnL : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totAsnP : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-200">${hasData ? totAsnJml : '-'}</td>
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 align-middle text-left" rowspan="2">
                                    <div>Jabatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Occupation</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Pegawai Negeri Sipil</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Civil Servant</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Pegawai Pemerintah dengan Perjanjian Kinerja</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Civil servants with employment agreements</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Aparatur Sipil Negara</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">State Civil Apparatus</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-2 border border-slate-700 bg-amber-600"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-2 border border-slate-700 bg-amber-600"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-2 border border-slate-700 bg-amber-600 font-extrabold"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-left">(1)</th>
                                <th class="py-1 px-2 border border-slate-700">(2)</th>
                                <th class="py-1 px-2 border border-slate-700">(3)</th>
                                <th class="py-1 px-2 border border-slate-700">(4)</th>
                                <th class="py-1 px-2 border border-slate-700">(5)</th>
                                <th class="py-1 px-2 border border-slate-700">(6)</th>
                                <th class="py-1 px-2 border border-slate-700">(7)</th>
                                <th class="py-1 px-2 border border-slate-700">(8)</th>
                                <th class="py-1 px-2 border border-slate-700">(9)</th>
                                <th class="py-1 px-2 border border-slate-700">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '2.3.2': {
                titleId: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin (orang)',
                titleEn: 'Number of Civil Servant of Bukittinggi Municipal Government by Educational Level, Type of ASN, and Sex (people)',
                source: 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / <span class="italic text-slate-500">Human Resources and Development Agency of Bukittinggi Municipality</span>',
                note: (yr) => '<div>Data per-31 Desember ' + (yr || currentYear || '2025') + '</div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                    const defaultData232 = {
                        2025: {
                            sd:    { pns_l: '37',  pns_p: '0',   pppk_l: '4',   pppk_p: '1' },
                            smp:   { pns_l: '19',  pns_p: '2',   pppk_l: '1',   pppk_p: '0' },
                            sma:   { pns_l: '151', pns_p: '53',  pppk_l: '116', pppk_p: '44' },
                            di:    { pns_l: '0',   pns_p: '0',   pppk_l: '0',   pppk_p: '0' },
                            dii:   { pns_l: '5',   pns_p: '4',   pppk_l: '0',   pppk_p: '0' },
                            diii:  { pns_l: '54',  pns_p: '258', pppk_l: '21',  pppk_p: '74' },
                            div:   { pns_l: '37',  pns_p: '30',  pppk_l: '0',   pppk_p: '4' },
                            s1:    { pns_l: '331', pns_p: '939', pppk_l: '101', pppk_p: '288' },
                            s2:    { pns_l: '133', pns_p: '194', pppk_l: '2',   pppk_p: '0' },
                            s3:    { pns_l: '0',   pns_p: '1',   pppk_l: '0',   pppk_p: '0' }
                        },
                        2024: {
                            sd:    { pns_l: '41',  pns_p: '0',   pppk_l: '0',  pppk_p: '0' },
                            smp:   { pns_l: '18',  pns_p: '2',   pppk_l: '0',  pppk_p: '0' },
                            sma:   { pns_l: '171', pns_p: '64',  pppk_l: '34', pppk_p: '5' },
                            di:    { pns_l: '0',   pns_p: '1',   pppk_l: '0',  pppk_p: '0' },
                            dii:   { pns_l: '7',   pns_p: '8',   pppk_l: '0',  pppk_p: '0' },
                            diii:  { pns_l: '58',  pns_p: '277', pppk_l: '18', pppk_p: '72' },
                            div:   { pns_l: '30',  pns_p: '23',  pppk_l: '0',  pppk_p: '4' },
                            s1:    { pns_l: '331', pns_p: '934', pppk_l: '95', pppk_p: '280' },
                            s2:    { pns_l: '128', pns_p: '170', pppk_l: '0',  pppk_p: '0' },
                            s3:    { pns_l: '0',   pns_p: '0',   pppk_l: '0',  pppk_p: '0' }
                        }
                    };

                    const rows = [
                        { key: 'sd',   labelId: 'Sekolah Dasar (SD)', labelEn: 'Primary School' },
                        { key: 'smp',  labelId: 'Sekolah Menengah Pertama (SMP)', labelEn: 'Junior High School' },
                        { key: 'sma',  labelId: 'Sekolah Menengah Atas (SMA)', labelEn: 'Senior High School' },
                        { key: 'di',   labelId: 'Diploma I / Akta I', labelEn: 'Diploma I/Akta I' },
                        { key: 'dii',  labelId: 'Diploma II / Akta II', labelEn: 'Diploma II/Akta II' },
                        { key: 'diii', labelId: 'Diploma III / Akta III', labelEn: 'Diploma III/Akta III' },
                        { key: 'div',  labelId: 'Diploma IV / Akta IV', labelEn: 'Diploma IV/Akta IV' },
                        { key: 's1',   labelId: 'S1 / Sarjana', labelEn: 'Under Graduate/Bachelor' },
                        { key: 's2',   labelId: 'S2 / Pasca Sarjana', labelEn: 'Graduate' },
                        { key: 's3',   labelId: 'S3 / Doktor/Ph.D', labelEn: 'Post Graduate' }
                    ];

                    const yrDefaults = defaultData232[yr] || {};

                    let totPnsL = 0, totPnsP = 0, totPnsJml = 0;
                    let totPppkL = 0, totPppkP = 0, totPppkJml = 0;
                    let totAsnL = 0, totAsnP = 0, totAsnJml = 0;
                    let hasData = false;

                    let rowsHtml = '';
                    rows.forEach(r => {
                        const def = yrDefaults[r.key] || { pns_l: '-', pns_p: '-', pppk_l: '-', pppk_p: '-' };

                        const pnsLStr = (d[`${r.key}_pns_l`] !== undefined && d[`${r.key}_pns_l`] !== '') ? d[`${r.key}_pns_l`] : def.pns_l;
                        const pnsPStr = (d[`${r.key}_pns_p`] !== undefined && d[`${r.key}_pns_p`] !== '') ? d[`${r.key}_pns_p`] : def.pns_p;
                        const pppkLStr = (d[`${r.key}_pppk_l`] !== undefined && d[`${r.key}_pppk_l`] !== '') ? d[`${r.key}_pppk_l`] : def.pppk_l;
                        const pppkPStr = (d[`${r.key}_pppk_p`] !== undefined && d[`${r.key}_pppk_p`] !== '') ? d[`${r.key}_pppk_p`] : def.pppk_p;

                        const numPnsL = parseFloat(String(pnsLStr).replace(',', '.')) || 0;
                        const numPnsP = parseFloat(String(pnsPStr).replace(',', '.')) || 0;
                        const numPppkL = parseFloat(String(pppkLStr).replace(',', '.')) || 0;
                        const numPppkP = parseFloat(String(pppkPStr).replace(',', '.')) || 0;

                        const isPnsLSet = (pnsLStr !== '-' && pnsLStr !== '');
                        const isPnsPSet = (pnsPStr !== '-' && pnsPStr !== '');
                        const isPppkLSet = (pppkLStr !== '-' && pppkLStr !== '');
                        const isPppkPSet = (pppkPStr !== '-' && pppkPStr !== '');

                        if (isPnsLSet || isPnsPSet || isPppkLSet || isPppkPSet) {
                            hasData = true;
                        }

                        const pnsJml = (isPnsLSet || isPnsPSet) ? (numPnsL + numPnsP) : '-';
                        const pppkJml = (isPppkLSet || isPppkPSet) ? (numPppkL + numPppkP) : '-';
                        const totalL = (isPnsLSet || isPppkLSet) ? (numPnsL + numPppkL) : '-';
                        const totalP = (isPnsPSet || isPppkPSet) ? (numPnsP + numPppkP) : '-';
                        const totalJml = (pnsJml !== '-' || pppkJml !== '-') ? ((typeof pnsJml === 'number' ? pnsJml : 0) + (typeof pppkJml === 'number' ? pppkJml : 0)) : '-';

                        if (typeof pnsJml === 'number') {
                            totPnsL += numPnsL;
                            totPnsP += numPnsP;
                            totPnsJml += pnsJml;
                        }
                        if (typeof pppkJml === 'number') {
                            totPppkL += numPppkL;
                            totPppkP += numPppkP;
                            totPppkJml += pppkJml;
                        }
                        if (typeof totalJml === 'number') {
                            totAsnL += (typeof totalL === 'number' ? totalL : 0);
                            totAsnP += (typeof totalP === 'number' ? totalP : 0);
                            totAsnJml += totalJml;
                        }

                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors" data-key="${r.key}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                    <div>${r.labelId}</div>
                                    <div class="italic font-normal text-xs text-slate-600">${r.labelEn}</div>
                                </td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pnsLStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pnsPStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-bold bg-amber-50/50">${pnsJml}</td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pppkLStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pppkPStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-bold bg-amber-50/50">${pppkJml}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-medium">${totalL}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-medium">${totalP}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${totalJml}</td>
                            </tr>
                        `;
                    });

                    // Baris Total / Jumlah
                    rowsHtml += `
                        <tr class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700" data-total="true">
                            <td class="py-2.5 px-4 font-bold border border-slate-700 text-left">
                                <div>Jumlah</div>
                                <div class="italic font-normal text-xs text-slate-700">Total</div>
                            </td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totPnsL : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totPnsP : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${hasData ? totPnsJml : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totPppkL : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totPppkP : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${hasData ? totPppkJml : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totAsnL : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totAsnP : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-200">${hasData ? totAsnJml : '-'}</td>
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 align-middle text-left" rowspan="2">
                                    <div>Tingkat Pendidikan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Educational Level</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Pegawai Negeri Sipil</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Civil Servant</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Pegawai Pemerintah dengan Perjanjian Kinerja</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Civil servants with employment agreements</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Aparatur Sipil Negara</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">State Civil Apparatus</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-2 border border-slate-700 bg-amber-600"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-2 border border-slate-700 bg-amber-600"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-2 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-2 border border-slate-700 bg-amber-600 font-extrabold"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-left">(1)</th>
                                <th class="py-1 px-2 border border-slate-700">(2)</th>
                                <th class="py-1 px-2 border border-slate-700">(3)</th>
                                <th class="py-1 px-2 border border-slate-700">(4)</th>
                                <th class="py-1 px-2 border border-slate-700">(5)</th>
                                <th class="py-1 px-2 border border-slate-700">(6)</th>
                                <th class="py-1 px-2 border border-slate-700">(7)</th>
                                <th class="py-1 px-2 border border-slate-700">(8)</th>
                                <th class="py-1 px-2 border border-slate-700">(9)</th>
                                <th class="py-1 px-2 border border-slate-700">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
});
