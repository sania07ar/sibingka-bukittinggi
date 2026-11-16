/** SiBingka - Skema tabel (tampilan / index): 9.2, 9.3, 9.4, 5.1.15, 5.1.16, 5.1.17, 5.2.1, 5.2.2 */
Object.assign(window.tableSchemas, {
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

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-center bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

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
                                <input type="text" class="table-edit-input w-full text-center bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="koperasi" value="${getVal(y, 'koperasi')}">
                            </td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-center bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="anggota" value="${getVal(y, 'anggota')}">
                            </td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-center bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="simpanan" value="${getVal(y, 'simpanan')}">
                            </td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-center bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="volume_usaha" value="${getVal(y, 'volume_usaha')}">
                            </td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle ${y === yr ? 'bg-amber-100/60' : ''}">
                                <input type="text" class="table-edit-input w-full text-center bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" data-key="permodalan" value="${getVal(y, 'permodalan')}">
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
                            const inp = (v) => `<input type="text" class="table-edit-input w-full text-center bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm" value="${v}">`;
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
                                ${Array(6).fill(0).map(() => `<td class="py-2.5 px-3 border border-slate-700 text-center">-</td>`).join('')}
                            </tr>
                        `;
                    });

                    const yearsDesc = [];
                    for (let y = yr; y >= yr - 4; y--) {
                        yearsDesc.push(y);
                    }

                    yearsDesc.forEach((y, idx) => {
                        const isFirstYear = (idx === 0);
                        const rowCls = isFirstYear ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors font-medium';

                        rowsHtml += `
                            <tr class="${rowCls}">
                                ${isFirstYear ? `<td rowspan="5" class="py-2.5 px-4 border border-slate-700 text-center font-extrabold align-middle bg-[#fed7aa]">Jumlah / Total</td>` : ''}
                                <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle bg-[#fed7aa]">${y}</td>
                                ${Array(6).fill(0).map(() => `<td class="py-2.5 px-3 border border-slate-700 text-center">-</td>`).join('')}
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
                                ${Array(12).fill(0).map(() => `<td class="py-2.5 px-2.5 border border-slate-700 text-center min-w-[110px]">-</td>`).join('')}
                            </tr>
                        `;
                    });

                    const yearsDesc = [];
                    for (let y = yr; y >= yr - 4; y--) {
                        yearsDesc.push(y);
                    }

                    yearsDesc.forEach((y, idx) => {
                        const isFirstYear = (idx === 0);
                        const rowCls = isFirstYear ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors font-medium';

                        rowsHtml += `
                            <tr class="${rowCls}">
                                ${isFirstYear ? `<td rowspan="5" class="py-2.5 px-4 border border-slate-700 text-center font-extrabold align-middle bg-[#fed7aa] min-w-[130px]">Jumlah / Total</td>` : ''}
                                <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle bg-[#fed7aa] min-w-[70px]">${y}</td>
                                ${Array(12).fill(0).map(() => `<td class="py-2.5 px-2.5 border border-slate-700 text-center min-w-[110px]">-</td>`).join('')}
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
            '5.1.17': {
                titleId: 'Target dan Realisasi Intensifikasi Sayur–Sayuran per Kecamatan di Kota Bukittinggi',
                titleEn: 'Target and Realization of Vegetables Intensification per District in Bukittinggi Municipality',
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
                                ${Array(12).fill(0).map(() => `<td class="py-2 px-1 border border-slate-700 text-center">-</td>`).join('')}
                            </tr>
                        `;
                    });

                    const yearsDesc = [];
                    for (let y = yr; y >= yr - 4; y--) {
                        yearsDesc.push(y);
                    }

                    yearsDesc.forEach((y, idx) => {
                        const isFirstYear = (idx === 0);
                        const rowCls = isFirstYear ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors font-medium';

                        rowsHtml += `
                            <tr class="${rowCls}">
                                ${isFirstYear ? `<td rowspan="5" class="py-2.5 px-4 border border-slate-700 text-center font-extrabold align-middle bg-[#fed7aa]">Jumlah / Total</td>` : ''}
                                <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle bg-[#fed7aa]">${y}</td>
                                ${Array(12).fill(0).map(() => `<td class="py-2 px-1 border border-slate-700 text-center">-</td>`).join('')}
                            </tr>
                        `;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Target</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Realisasi</div><div class="italic font-normal text-[11px] sm:text-xs">Realization</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-1 border border-slate-700">Kentang</th>
                                <th class="py-2 px-1 border border-slate-700">Tomat</th>
                                <th class="py-2 px-1 border border-slate-700">Lombok</th>
                                <th class="py-2 px-1 border border-slate-700">Bawang Daun</th>
                                <th class="py-2 px-1 border border-slate-700">Lainnya</th>
                                <th class="py-2 px-1 border border-slate-700">Jumlah</th>
                                <th class="py-2 px-1 border border-slate-700">Kentang</th>
                                <th class="py-2 px-1 border border-slate-700">Tomat</th>
                                <th class="py-2 px-1 border border-slate-700">Lombok</th>
                                <th class="py-2 px-1 border border-slate-700">Bawang Daun</th>
                                <th class="py-2 px-1 border border-slate-700">Lainnya</th>
                                <th class="py-2 px-1 border border-slate-700">Jumlah</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>
                                ${Array(12).fill(0).map((_, i) => `<th class="py-1 px-1 border border-slate-700">(${i + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '5.2.1': {
                titleId: 'Luas Areal Tanaman Perkebunan Menurut Kecamatan dan Jenis Tanaman di Kota Bukittinggi (ha)',
                titleEn: 'Planted Area of Estate Crops by District and Types of Crops in Bukittinggi Municipality (ha)',
                isMultiYear: true,
                source: 'Dinas Pertanian dan Pangan Kota Bukittinggi / <span class="italic text-slate-500">Agriculture and Food Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const y1 = yr - 1;
                    const y2 = yr;
                    const is2025 = (yr === 2025);
                    const is2024 = (yr === 2024);
                    // Standar BPS resmi: HANYA 4 Komoditi (Kelapa Sawit, Kelapa, Karet, Kopi) -> 8 kolom data (Kolom 2 s.d 9)
                    const dists = [
                        { name: '01. Guguk Panjang', data: is2025 ? ['-', '-', '0,86', '0,86', '-', '-', '2,9', '2,5'] : (is2024 ? ['-', '-', '-', '0,86', '-', '-', '2,9', '2,9'] : Array(8).fill('-')) },
                        { name: '02. Mandiangin Koto Selayan', data: is2025 ? ['-', '-', '2', '1,9', '-', '-', '2,2', '2,1'] : (is2024 ? ['-', '-', '-', '2', '-', '-', '2,2', '2,2'] : Array(8).fill('-')) },
                        { name: '03. Aur Birugo Tigo Baleh', data: is2025 ? ['-', '-', '0,9', '0,9', '-', '-', '-', '-'] : (is2024 ? ['-', '-', '-', '0,9', '-', '-', '-', '-'] : Array(8).fill('-')) }
                    ];
                    const totalData = is2025 ? ['-', '-', '3,76', '3,66', '-', '-', '5,1', '4,6'] : (is2024 ? ['-', '-', '-', '3,76', '-', '-', '5,1', '5,1'] : Array(8).fill('-'));

                    const crops = [
                        { id: 'Kelapa Sawit', en: 'Oil Palm' },
                        { id: 'Kelapa', en: 'Coconut' },
                        { id: 'Karet', en: 'Rubber' },
                        { id: 'Kopi', en: 'Coffee' }
                    ];

                    let thCropsHtml = '';
                    let thYearsHtml = '';
                    let thNumsHtml = '<th class="py-1 px-3 border border-slate-700 text-left">(1)</th>';
                    let cNum = 2;

                    crops.forEach(c => {
                        thCropsHtml += `
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="2">
                                <div>${c.id}</div><div class="italic font-normal text-[11px] sm:text-xs">${c.en}</div>
                            </th>
                        `;
                        thYearsHtml += `
                            <th class="py-2 px-2 border border-slate-700">${y1}</th>
                            <th class="py-2 px-2 border border-slate-700">${y2}</th>
                        `;
                        thNumsHtml += `
                            <th class="py-1 px-2 border border-slate-700">(${cNum})</th>
                            <th class="py-1 px-2 border border-slate-700">(${cNum + 1})</th>
                        `;
                        cNum += 2;
                    });

                    let rowsHtml = '';
                    dists.forEach(d => {
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${d.name}</td>
                                ${d.data.map(v => `<td class="py-2.5 px-3 border border-slate-700 text-right align-top pr-4 font-medium">${v}</td>`).join('')}
                            </tr>
                        `;
                    });
                    rowsHtml += `
                        <tr class="bg-[#fed7aa] font-bold">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-extrabold align-top">Bukittinggi</td>
                            ${totalData.map(v => `<td class="py-2.5 px-3 border border-slate-700 text-right align-top pr-4 font-extrabold">${v}</td>`).join('')}
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 align-middle" rowspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                ${thCropsHtml}
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                ${thYearsHtml}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                ${thNumsHtml}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '5.2.2': {
                titleId: 'Produksi Tanaman Perkebunan Menurut Kecamatan dan Jenis Tanaman di Kota Bukittinggi (ton)',
                titleEn: 'Production of Estate Crops by District and Types of Crops in Bukittinggi Municipality (ton)',
                isMultiYear: true,
                source: 'Dinas Pertanian dan Pangan Kota Bukittinggi / <span class="italic text-slate-500">Agriculture and Food Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const y1 = yr - 1;
                    const y2 = yr;
                    const is2025 = (yr === 2025);
                    // Standar BPS resmi: HANYA 4 Komoditi (Kelapa Sawit, Kelapa, Karet, Kopi) -> 8 kolom data (Kolom 2 s.d 9)
                    const dists = [
                        { name: '01. Guguk Panjang', data: is2025 ? ['-', '-', '0,0034', '0,0002', '-', '-', '0,0011', '0,0004'] : Array(8).fill('-') },
                        { name: '02. Mandiangin Koto Selayan', data: is2025 ? ['-', '-', '0,0012', '0,0002', '-', '-', '0,0008', '0,0001'] : Array(8).fill('-') },
                        { name: '03. Aur Birugo Tigo Baleh', data: is2025 ? ['-', '-', '0,001', '0,0002', '-', '-', '-', '-'] : Array(8).fill('-') }
                    ];
                    const totalData = is2025 ? ['-', '-', '0,0055', '0,0006', '-', '-', '0,0019', '0,00055'] : Array(8).fill('-');

                    const crops = [
                        { id: 'Kelapa Sawit', en: 'Oil Palm' },
                        { id: 'Kelapa', en: 'Coconut' },
                        { id: 'Karet', en: 'Rubber' },
                        { id: 'Kopi', en: 'Coffee' }
                    ];

                    let thCropsHtml = '';
                    let thYearsHtml = '';
                    let thNumsHtml = '<th class="py-1 px-3 border border-slate-700 text-left">(1)</th>';
                    let cNum = 2;

                    crops.forEach(c => {
                        thCropsHtml += `
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="2">
                                <div>${c.id}</div><div class="italic font-normal text-[11px] sm:text-xs">${c.en}</div>
                            </th>
                        `;
                        thYearsHtml += `
                            <th class="py-2 px-2 border border-slate-700">${y1}</th>
                            <th class="py-2 px-2 border border-slate-700">${y2}</th>
                        `;
                        thNumsHtml += `
                            <th class="py-1 px-2 border border-slate-700">(${cNum})</th>
                            <th class="py-1 px-2 border border-slate-700">(${cNum + 1})</th>
                        `;
                        cNum += 2;
                    });

                    let rowsHtml = '';
                    dists.forEach(d => {
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${d.name}</td>
                                ${d.data.map(v => `<td class="py-2.5 px-3 border border-slate-700 text-right align-top pr-4 font-medium">${v}</td>`).join('')}
                            </tr>
                        `;
                    });
                    rowsHtml += `
                        <tr class="bg-[#fed7aa] font-bold">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-extrabold align-top">Bukittinggi</td>
                            ${totalData.map(v => `<td class="py-2.5 px-3 border border-slate-700 text-right align-top pr-4 font-extrabold">${v}</td>`).join('')}
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 align-middle" rowspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                ${thCropsHtml}
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                ${thYearsHtml}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                ${thNumsHtml}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            }
});
