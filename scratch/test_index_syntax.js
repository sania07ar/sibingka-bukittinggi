
;

;

;

;

;

        const opdNames = {
            '01': 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG',
            '02': 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU',
            '03': 'DEWAN PERWAKILAN RAKYAT DAERAH KOTA BUKITTINGGI',
            '04': 'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SDM',
            '05': 'BADAN KEUANGAN DAERAH',
            '06': 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL',
            '07': 'DINAS KOPERASI, UKM DAN TENAGA KERJA',
            '08': 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
            '09': 'BADAN PENANGGULANGAN BENCANA DAERAH',
            '10': 'DINAS PEMUDA DAN OLAHRAGA',
            '11': 'DINAS PERPUSTAKAAN DAN KEARSIPAN',
            '12': 'DINAS KESEHATAN',
            '13': 'DINAS LINGKUNGAN HIDUP',
            '14': 'DINAS P3APPKB',
            '15': 'DINAS KEBAKARAN',
            '16': 'DINAS SOSIAL',
            '17': 'DINAS PERTANIAN',
            '18': 'DINAS PERDAGANGAN',
            '19': 'DINAS PARIWISATA',
            '20': 'DINAS PERHUBUNGAN'
        };

        const instansiNames = {
            '01': 'KANTOR PERTANAHAN KOTA BUKITTINGGI (BPN)',
            '02': 'KOMISI PEMILIHAN UMUM DAERAH KOTA BUKITTINGGI',
            '03': 'KEMENTERIAN AGAMA KOTA BUKITTINGGI',
            '04': 'CABANG DINAS PENDIDIKAN WILAYAH I PROV. SUMBAR',
            '05': 'PROGRAM STUDI PGSD UNIVERSITAS NEGERI PADANG',
            '06': 'DEPARTEMEN PSIKOLOGI UNP KAMPUS BUKITTINGGI',
            '07': 'FAKULTAS KEDOKTERAN UNP KAMPUS BUKITTINGGI',
            '08': 'AKADEMI KEBIDANAN BUKITTINGGI (AKBID)',
            '09': 'JURUSAN KEPERAWATAN GIGI POLTEKKES BUKITTINGGI',
            '10': 'STKIP AL-HUSSUNAH BUKITTINGGI',
            '11': 'STIT AL-HUSSUNAH BUKITTINGGI',
            '12': 'STIKES PERINTIS BUKITTINGGI',
            '13': 'STIKES PRIMA NUSANTARA BUKITTINGGI',
            '14': 'UNIVERSITAS MOHAMMAD NATSIR YARSI BUKITTINGGI',
            '15': 'INSTITUT TEKNOLOGI DAN BISNIS HAJI AGUS SALIM',
            '16': 'FAKULTAS TEKNIK UNIVERSITAS MUHAMMADIYAH SUMBAR',
            '17': 'FAKULTAS HUKUM UNIVERSITAS MUHAMMADIYAH SUMBAR',
            '18': 'FAKULTAS PARIWISATA UNIVERSITAS MUHAMMADIYAH SUMBAR',
            '19': 'FAKULTAS KESEHATAN UNIVERSITAS MUHAMMADIYAH SUMBAR',
            '20': 'AKADEMI FARMASI IMAM BONJOL BUKITTINGGI',
            '21': 'UNIVERSITAS FORT DE KOCK BUKITTINGGI',
            '22': 'AKADEMI FARMASI DWI FARMA BUKITTINGGI',
            '23': 'AKADEMI AKUNTANSI PARAMITA BUKITTINGGI',
            '24': 'UPT PERPUSTAKAAN PROKLAMATOR BUNG HATTA',
            '25': 'PALANG MERAH INDONESIA KOTA BUKITTINGGI',
            '26': 'BPJS KESEHATAN & KETENAGAKERJAAN BUKITTINGGI',
            '27': 'PENGADILAN NEGERI KOTA BUKITTINGGI',
            '28': 'KEJAKSAAN NEGERI KOTA BUKITTINGGI',
            '29': 'PENGADILAN AGAMA KOTA BUKITTINGGI',
            '30': 'KEPOLISIAN RESOR KOTA BUKITTINGGI',
            '31': 'PT PLN (PERSERO) ULP BUKITTINGGI',
            '32': 'PERUMDA AIR MINUM TIRTA JAM GADANG',
            '33': 'UPTD SAMSAT / PENDAPATAN DAERAH BUKITTINGGI',
            '34': 'PT POS INDONESIA (PERSERO) KANTOR POS BUKITTINGGI',
            '35': 'LPP RADIO REPUBLIK INDONESIA BUKITTINGGI',
            '36': 'PT TASPEN (PERSERO) KANTOR CABANG BUKITTINGGI',
            '37': 'PERUM BULOG KANTOR CABANG BUKITTINGGI'
        };

        function getAgencyName(code) {
            if (currentType === 'instansi') {
                return instansiNames[code] || 'KANTOR PERTANAHAN KOTA BUKITTINGGI (BPN)';
            }
            return opdNames[code] || 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG';
        }

        // Table Schemas & Structured Data
        const tableSchemas = {
            '1.1.8': {
                titleId: 'Jumlah Pembuatan Sertifikat Menurut Jenis Kepemilikan di Kota Bukittinggi',
                titleEn: 'Number of Certificate Issuances by Type of Ownership in Bukittinggi Municipality',
                source: 'Kantor Pertanahan Kota Bukittinggi (BPN) / <span class="italic text-slate-500">Land Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yrKey = year ? year.toString() : '2025';
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yrKey]) ? serverDbDataStore[yrKey] : {};
                    const vMilik = d['hak_milik'] !== undefined ? d['hak_milik'] : '-';
                    const vHgb = d['hak_guna_bangunan'] !== undefined ? d['hak_guna_bangunan'] : '-';
                    const vPakai = d['hak_pakai'] !== undefined ? d['hak_pakai'] : '-';
                    const vPengelolaan = d['hak_pengelolaan'] !== undefined ? d['hak_pengelolaan'] : '-';
                    const vWakaf = d['hak_wakaf'] !== undefined ? d['hak_wakaf'] : '-';
                    
                    let numMilik = parseFloat(String(vMilik).replace(',', '.')) || 0;
                    let numHgb = parseFloat(String(vHgb).replace(',', '.')) || 0;
                    let numPakai = parseFloat(String(vPakai).replace(',', '.')) || 0;
                    let numPengelolaan = parseFloat(String(vPengelolaan).replace(',', '.')) || 0;
                    let numWakaf = parseFloat(String(vWakaf).replace(',', '.')) || 0;
                    let calcTotal = (vMilik !== '-' || vHgb !== '-' || vPakai !== '-' || vPengelolaan !== '-' || vWakaf !== '-')
                        ? (numMilik + numHgb + numPakai + numPengelolaan + numWakaf)
                        : '-';
                    const vTotal = d['total'] !== undefined ? d['total'] : calcTotal;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 w-16">No</th>
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[60%] text-left">
                                    <div>Jenis Kepemilikan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Ownership</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[30%]">
                                    <div>Jumlah Sertifikat</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Certificates</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-left">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">1</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Hak Milik / Freehold</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vMilik}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">2</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Hak Guna Bangunan / Right to Build</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vHgb}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">3</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Hak Pakai / Right to Use</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vPakai}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">4</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Hak Pengelolaan / Right of Management</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vPengelolaan}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">5</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Hak Wakaf / Waqf Land Title</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vWakaf}</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 text-center border border-slate-700" colspan="2">Jumlah / Total</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vTotal}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '1.1.9': {
                titleId: 'Jumlah Pencatatan Peralihan Hak Menurut Jenis Kepemilikan di Kota Bukittinggi',
                titleEn: 'Number of Title Transfer Registrations by Type of Ownership in Bukittinggi Municipality',
                source: 'Kantor Pertanahan Kota Bukittinggi (BPN) / <span class="italic text-slate-500">Land Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yrKey = year ? year.toString() : '2025';
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yrKey]) ? serverDbDataStore[yrKey] : {};
                    const vJualBeli = d['jual_beli'] !== undefined ? d['jual_beli'] : '-';
                    const vWaris = d['pewarisan'] !== undefined ? d['pewarisan'] : '-';
                    const vHibah = d['hibah'] !== undefined ? d['hibah'] : '-';
                    const vTukar = d['tukar_menukar'] !== undefined ? d['tukar_menukar'] : '-';
                    const vBagi = d['pembagian_hak_bersama'] !== undefined ? d['pembagian_hak_bersama'] : '-';
                    const vLelang = d['lelang'] !== undefined ? d['lelang'] : '-';
                    const vLainnya = d['lainnya'] !== undefined ? d['lainnya'] : '-';
                    
                    let numJualBeli = parseFloat(String(vJualBeli).replace(',', '.')) || 0;
                    let numWaris = parseFloat(String(vWaris).replace(',', '.')) || 0;
                    let numHibah = parseFloat(String(vHibah).replace(',', '.')) || 0;
                    let numTukar = parseFloat(String(vTukar).replace(',', '.')) || 0;
                    let numBagi = parseFloat(String(vBagi).replace(',', '.')) || 0;
                    let numLelang = parseFloat(String(vLelang).replace(',', '.')) || 0;
                    let numLainnya = parseFloat(String(vLainnya).replace(',', '.')) || 0;
                    let calcTotal = (vJualBeli !== '-' || vWaris !== '-' || vHibah !== '-' || vTukar !== '-' || vBagi !== '-' || vLelang !== '-' || vLainnya !== '-')
                        ? (numJualBeli + numWaris + numHibah + numTukar + numBagi + numLelang + numLainnya)
                        : '-';
                    const vTotal = d['total'] !== undefined ? d['total'] : calcTotal;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 w-16">No</th>
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[60%] text-left">
                                    <div>Jenis Peralihan Hak</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Title Transfer</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[30%]">
                                    <div>Jumlah Pencatatan Peralihan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Registrations</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-left">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">1</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Jual Beli / Sale and Purchase</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vJualBeli}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">2</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Pewarisan / Inheritance</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vWaris}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">3</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Hibah / Grant</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vHibah}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">4</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Tukar Menukar / Exchange</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vTukar}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">5</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Pembagian Hak Bersama / Division of Joint Rights</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vBagi}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">6</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Lelang / Auction</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vLelang}</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">7</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">Lainnya / Others</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vLainnya}</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 text-center border border-slate-700" colspan="2">Jumlah / Total</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${vTotal}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '1.1.10': {
                titleId: 'Jumlah IMB/PBG yang Dikeluarkan Dinas Penanaman Modal PTSP Kota Bukittinggi Menurut Klasifikasinya di Kota Bukittinggi',
                titleEn: 'Number of Building Approvals (IMB/PBG) Issued by Investment and One-Stop Integrated Services of Bukittinggi Municipality by Classification',
                isMultiYear: true,
                source: 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kota Bukittinggi / <span class="italic text-slate-500">Investment and Integrated One-Stop Services Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2026;

                    // Data riil resmi BPS / Dinas DPMPTSP Kota Bukittinggi per Kecamatan
                    const defaultKec1110 = {
                        2025: {
                            gp:  { tt: '14', btt: '7',  cmp: '2', jml: '23' },
                            mks: { tt: '45', btt: '5',  cmp: '2', jml: '52' },
                            abt: { tt: '23', btt: '1',  cmp: '-', jml: '24' }
                        },
                        2024: {
                            gp:  { tt: '64', btt: '29', cmp: '1', jml: '94' },
                            mks: { tt: '150', btt: '14', cmp: '-', jml: '164' },
                            abt: { tt: '77', btt: '18', cmp: '-', jml: '95' }
                        },
                        2023: {
                            gp:  { tt: '36', btt: '5', cmp: '8', jml: '49' },
                            mks: { tt: '74', btt: '8', cmp: '2', jml: '84' },
                            abt: { tt: '41', btt: '8', cmp: '5', jml: '54' }
                        }
                    };
                    const defK = defaultKec1110[yr] || {
                        gp:  { tt: '-', btt: '-', cmp: '-', jml: '-' },
                        mks: { tt: '-', btt: '-', cmp: '-', jml: '-' },
                        abt: { tt: '-', btt: '-', cmp: '-', jml: '-' }
                    };

                    // Ambil nilai dari serverDbDataStore jika ada
                    const storeYr = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                    const gp_tt  = (storeYr['gp_tt'] !== undefined && storeYr['gp_tt'] !== '') ? storeYr['gp_tt'] : defK.gp.tt;
                    const gp_btt = (storeYr['gp_btt'] !== undefined && storeYr['gp_btt'] !== '') ? storeYr['gp_btt'] : defK.gp.btt;
                    const gp_cmp = (storeYr['gp_cmp'] !== undefined && storeYr['gp_cmp'] !== '') ? storeYr['gp_cmp'] : defK.gp.cmp;
                    const gp_jml = (storeYr['gp_jml'] !== undefined && storeYr['gp_jml'] !== '') ? storeYr['gp_jml'] : defK.gp.jml;

                    const mks_tt  = (storeYr['mks_tt'] !== undefined && storeYr['mks_tt'] !== '') ? storeYr['mks_tt'] : defK.mks.tt;
                    const mks_btt = (storeYr['mks_btt'] !== undefined && storeYr['mks_btt'] !== '') ? storeYr['mks_btt'] : defK.mks.btt;
                    const mks_cmp = (storeYr['mks_cmp'] !== undefined && storeYr['mks_cmp'] !== '') ? storeYr['mks_cmp'] : defK.mks.cmp;
                    const mks_jml = (storeYr['mks_jml'] !== undefined && storeYr['mks_jml'] !== '') ? storeYr['mks_jml'] : defK.mks.jml;

                    const abt_tt  = (storeYr['abt_tt'] !== undefined && storeYr['abt_tt'] !== '') ? storeYr['abt_tt'] : defK.abt.tt;
                    const abt_btt = (storeYr['abt_btt'] !== undefined && storeYr['abt_btt'] !== '') ? storeYr['abt_btt'] : defK.abt.btt;
                    const abt_cmp = (storeYr['abt_cmp'] !== undefined && storeYr['abt_cmp'] !== '') ? storeYr['abt_cmp'] : defK.abt.cmp;
                    const abt_jml = (storeYr['abt_jml'] !== undefined && storeYr['abt_jml'] !== '') ? storeYr['abt_jml'] : defK.abt.jml;

                    // Daftar 5 tahun sesuai periode (misal 2026-2030 -> [2030, 2029, 2028, 2027, 2026])
                    const p = get5YearPeriod(yr);
                    const summaryYears = p.yearsDesc;
                    const defaultTotals = {
                        2025: { tt: '82',  btt: '13', cmp: '4',  jml: '99' },
                        2024: { tt: '291', btt: '61', cmp: '1',  jml: '353' },
                        2023: { tt: '151', btt: '21', cmp: '15', jml: '187' },
                        2022: { tt: '204', btt: '9',  cmp: '15', jml: '228' },
                        2021: { tt: '225', btt: '26', cmp: '14', jml: '265' },
                        2020: { tt: '196', btt: '18', cmp: '14', jml: '228' },
                        2019: { tt: '222', btt: '19', cmp: '32', jml: '273' }
                    };

                    let jumlahRowsHtml = '';
                    summaryYears.forEach((y, idx) => {
                        const sData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) ? serverDbDataStore[y] : {};
                        const def = defaultTotals[y] || { tt: '-', btt: '-', cmp: '-', jml: '-' };
                        const valTT  = (sData['total_tt'] !== undefined && sData['total_tt'] !== '') ? sData['total_tt'] : def.tt;
                        const valBTT = (sData['total_btt'] !== undefined && sData['total_btt'] !== '') ? sData['total_btt'] : def.btt;
                        const valCMP = (sData['total_cmp'] !== undefined && sData['total_cmp'] !== '') ? sData['total_cmp'] : def.cmp;
                        const valJML = (sData['total_jml'] !== undefined && sData['total_jml'] !== '') ? sData['total_jml'] : def.jml;

                        const isCurrentYearRow = (y === yr);
                        const rowClass = isCurrentYearRow ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
                        const cellClass = isCurrentYearRow ? 'font-extrabold' : '';

                        jumlahRowsHtml += `<tr class="${rowClass}">`;
                        if (idx === 0) {
                            jumlahRowsHtml += `
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle bg-amber-50/70" rowspan="${summaryYears.length}">
                                    <div>Jumlah</div>
                                    <div class="italic font-bold text-xs">Total</div>
                                </td>
                            `;
                        }
                        jumlahRowsHtml += `
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${cellClass}">${y}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${cellClass}">${valTT}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${cellClass}">${valBTT}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${cellClass}">${valCMP}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-top ${cellClass}">${valJML}</td>
                        </tr>`;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tempat tinggal</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Residential</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Bukan tempat tinggal</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Non-residential</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Campuran</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Mixed</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
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
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">
                                    01. GUGUK PANJANG
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${gp_tt}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${gp_btt}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${gp_cmp}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${gp_jml}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">
                                    02. MANDIANGIN KOTO SELAYAN
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${mks_tt}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${mks_btt}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${mks_cmp}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${mks_jml}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">
                                    03. AUR BIRUGO TIGO BALEH
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${abt_tt}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${abt_btt}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${abt_cmp}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${abt_jml}</td>
                            </tr>
                            ${jumlahRowsHtml}
                        </tbody>
                    `;
                }
            },
            '1.1.6': {
                titleId: 'Nama Sungai/Batang, Lebar dan Kecamatan yang Dilalui di Kota Bukittinggi',
                titleEn: 'Name, Width of The River and District Its Pass in Bukittinggi',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yrKey = year ? year.toString() : '2025';
                    const tambuoWidth = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yrKey] && serverDbDataStore[yrKey]['batang_tambuo']) 
                        ? serverDbDataStore[yrKey]['batang_tambuo'] 
                        : '-';
                    const sianokWidth = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yrKey] && serverDbDataStore[yrKey]['batang_sianok']) 
                        ? serverDbDataStore[yrKey]['batang_sianok'] 
                        : '-';
                    const tambuoClass = tambuoWidth !== '-' ? 'font-semibold' : 'text-slate-400 font-normal';
                    const sianokClass = sianokWidth !== '-' ? 'font-semibold' : 'text-slate-400 font-normal';

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[38%]">
                                    <div>Nama Sungai (Batang)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Name of The River</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[18%]">
                                    <div>Lebar (M)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Width (M)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700 w-[44%]" colspan="2">
                                    <div>Kecamatan yang Dilalui</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">District Its Pass</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-2 border border-slate-700 w-12">No</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 align-middle" rowspan="2">
                                    01. Batang Tambuo
                                </td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${tambuoClass}" rowspan="2">
                                    ${tambuoWidth}
                                </td>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold">
                                    1
                                </td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Aur Birugo Tigo Baleh
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold">
                                    2
                                </td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Mandiangin Koto Selayan
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 align-middle" rowspan="2">
                                    02. Batang Sianok
                                </td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle ${sianokClass}" rowspan="2">
                                    ${sianokWidth}
                                </td>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold">
                                    1
                                </td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Aur Birugo Tigo Baleh
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold">
                                    2
                                </td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Guguk Panjang
                                </td>
                            </tr>
                        </tbody>
                    `;
                }
            },
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

                    // Data historis resmi dari database MySQL SiMonDa Bukittinggi:
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
                isMultiYear: true,
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
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
                        // Tahun 2019 ke bawah atau tahun 2026 ke atas yang belum ada datanya: WAJIB strip (-)
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
                                ${years.map(y => `<th class="py-2 px-3 border border-slate-700 ${y === yr ? 'bg-amber-500 font-extrabold' : ''}">${y}</th>`).join('')}
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
                isMultiYear: true,
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>',
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
                                ${years.map(y => `<th class="py-2 px-3 border border-slate-700 ${y === yr ? 'bg-amber-500 font-extrabold' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                ${years.map((y, idx) => `<th class="py-1 px-3 border border-slate-700">(${idx + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Baik / <span class="italic text-slate-500 font-normal">Good</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'baik')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Sedang / <span class="italic text-slate-500 font-normal">Moderate</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'sedang')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Rusak / <span class="italic text-slate-500 font-normal">Damage</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'rusak')}</td>`).join('')}
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">4. Rusak Berat / <span class="italic text-slate-500 font-normal">Severely Damage</span></td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, 'rusak_berat')}</td>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / <span class="italic font-bold">Total</span></td>
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

                        jumlahRowsHtml += `<tr class="hover:bg-amber-100/60 transition-colors">`;
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
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">01. GUGUK PANJANG</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${gP_unit}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${gP_len}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">02. MANDIANGIN KOTO SELAYAN</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${mks_unit}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${mks_len}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
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

                        jumlahRowsHtml += `<tr class="hover:bg-amber-100/60 transition-colors">`;
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
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">01. GUGUK PANJANG</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${gP}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">02. MANDIANGIN KOTO SELAYAN</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${mks}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">03. AUR BIRUGO TIGO BALEH</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">${abt}</td>
                            </tr>
                            ${jumlahRowsHtml}
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

                    // Data historis resmi dari database MySQL SiMonDa Bukittinggi:
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
                            <tr class="hover:bg-amber-100/60 transition-colors">
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
                        <tr class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
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
                            <tr class="hover:bg-amber-100/60 transition-colors">
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
                        <tr class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
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
            '2.3.3': {
                titleId: 'Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang)',
                titleEn: 'Number of Bukittinggi Municipality Government’s Civil Servants by Hierarchy and Sex (people)',
                source: 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / <span class="italic text-slate-500">Human Resources and Development Agency of Bukittinggi Municipality</span>',
                note: (yr) => '<div>Data per-31 Desember ' + (yr || currentYear || '2025') + '</div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                    const defaultData233 = {
                        2025: {
                            '1_ia':   { l: '0',   p: '0' },
                            '2_ib':   { l: '0',   p: '0' },
                            '3_ic':   { l: '1',   p: '0' },
                            '4_id':   { l: '5',   p: '0' },
                            '5_iia':  { l: '43',  p: '2' },
                            '6_iib':  { l: '5',   p: '1' },
                            '7_iic':  { l: '41',  p: '80' },
                            '8_iid':  { l: '57',  p: '54' },
                            '9_iiia': { l: '103', p: '117' },
                            '10_iiib':{ l: '91',  p: '220' },
                            '11_iiic':{ l: '98',  p: '212' },
                            '12_iiid':{ l: '193', p: '468' },
                            '13_iva': { l: '68',  p: '167' },
                            '14_ivb': { l: '37',  p: '103' },
                            '15_ivc': { l: '24',  p: '57' },
                            '16_ivd': { l: '1',   p: '0' },
                            '17_ive': { l: '0',   p: '0' }
                        },
                        2024: {
                            '1_ia':   { l: '0',   p: '0' },
                            '2_ib':   { l: '0',   p: '0' },
                            '3_ic':   { l: '2',   p: '0' },
                            '4_id':   { l: '15',  p: '1' },
                            '5_iia':  { l: '36',  p: '1' },
                            '6_iib':  { l: '5',   p: '1' },
                            '7_iic':  { l: '57',  p: '93' },
                            '8_iid':  { l: '57',  p: '51' },
                            '9_iiia': { l: '107', p: '114' },
                            '10_iiib':{ l: '86',  p: '246' },
                            '11_iiic':{ l: '91',  p: '177' },
                            '12_iiid':{ l: '197', p: '480' },
                            '13_iva': { l: '68',  p: '142' },
                            '14_ivb': { l: '39',  p: '117' },
                            '15_ivc': { l: '23',  p: '56' },
                            '16_ivd': { l: '1',   p: '0' },
                            '17_ive': { l: '0',   p: '0' }
                        }
                    };

                    const rankGroups = [
                        {
                            groupId: 'Golongan I',
                            groupEn: 'Range I',
                            ranks: [
                                { key: '1_ia', noGol: '1. I / A', labelId: 'Juru Muda', labelEn: 'Junior Clerk' },
                                { key: '2_ib', noGol: '2. I / B', labelId: 'Juru Muda Tingkat I', labelEn: 'First Class Junior Clerk' },
                                { key: '3_ic', noGol: '3. I / C', labelId: 'Juru', labelEn: 'Clerk' },
                                { key: '4_id', noGol: '4. I / D', labelId: 'Juru Tingkat I', labelEn: 'First Class Clerk' }
                            ]
                        },
                        {
                            groupId: 'Golongan II',
                            groupEn: 'Range II',
                            ranks: [
                                { key: '5_iia', noGol: '5. II / A', labelId: 'Pengatur Muda', labelEn: 'Junior Supervisor' },
                                { key: '6_iib', noGol: '6. II / B', labelId: 'Pengatur Muda Tingkat I', labelEn: 'First Class Junior Supervisor' },
                                { key: '7_iic', noGol: '7. II / C', labelId: 'Pengatur', labelEn: 'Supervisor' },
                                { key: '8_iid', noGol: '8. II / D', labelId: 'Pengatur Tingkat I', labelEn: 'First Class Supervisor' }
                            ]
                        },
                        {
                            groupId: 'Golongan III',
                            groupEn: 'Range III',
                            ranks: [
                                { key: '9_iiia', noGol: '9. III / A', labelId: 'Penata Muda', labelEn: 'Junior Superintendent' },
                                { key: '10_iiib', noGol: '10. III / B', labelId: 'Penata Muda Tingkat I', labelEn: 'First Class Junior Superintendent' },
                                { key: '11_iiic', noGol: '11. III / C', labelId: 'Penata', labelEn: 'Superintendent' },
                                { key: '12_iiid', noGol: '12. III / D', labelId: 'Penata Tingkat I', labelEn: 'First Class Superintendent' }
                            ]
                        },
                        {
                            groupId: 'Golongan IV',
                            groupEn: 'Range IV',
                            ranks: [
                                { key: '13_iva', noGol: '13. IV / A', labelId: 'Pembina', labelEn: 'Administrator' },
                                { key: '14_ivb', noGol: '14. IV / B', labelId: 'Pembina Tingkat I', labelEn: 'First Class Administrator' },
                                { key: '15_ivc', noGol: '15. IV / C', labelId: 'Pembina Utama Muda', labelEn: 'Junior Administrator' },
                                { key: '16_ivd', noGol: '16. IV / D', labelId: 'Pembina Utama Madya', labelEn: 'Middle Administrator' },
                                { key: '17_ive', noGol: '17. IV / E', labelId: 'Pembina Utama', labelEn: 'Senior Administrator' }
                            ]
                        }
                    ];

                    const yrDefaults = defaultData233[yr] || {};

                    let totL = 0, totP = 0, totJml = 0;
                    let hasData = false;
                    let rowsHtml = '';

                    rankGroups.forEach(grp => {
                        let grpL = 0, grpP = 0, grpJml = 0;
                        let grpHasData = false;
                        let grpRanksHtml = '';

                        grp.ranks.forEach(rk => {
                            const def = yrDefaults[rk.key] || { l: '-', p: '-' };

                            const lStr = (d[`${rk.key}_l`] !== undefined && d[`${rk.key}_l`] !== '') ? d[`${rk.key}_l`] : def.l;
                            const pStr = (d[`${rk.key}_p`] !== undefined && d[`${rk.key}_p`] !== '') ? d[`${rk.key}_p`] : def.p;

                            const numL = parseFloat(String(lStr).replace(',', '.')) || 0;
                            const numP = parseFloat(String(pStr).replace(',', '.')) || 0;

                            const isLSet = (lStr !== '-' && lStr !== '');
                            const isPSet = (pStr !== '-' && pStr !== '');

                            if (isLSet || isPSet) {
                                hasData = true;
                                grpHasData = true;
                            }

                            const rowJml = (isLSet || isPSet) ? (numL + numP) : '-';

                            if (typeof rowJml === 'number') {
                                grpL += numL;
                                grpP += numP;
                                grpJml += rowJml;

                                totL += numL;
                                totP += numP;
                                totJml += rowJml;
                            }

                            grpRanksHtml += `
                                <tr data-key="${rk.key}" class="hover:bg-amber-100/60 transition-colors">
                                    <td class="py-2 px-3 font-semibold border border-slate-700 text-center whitespace-nowrap">${rk.noGol}</td>
                                    <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                        <div>${rk.labelId}</div>
                                        <div class="italic font-normal text-xs text-slate-600">${rk.labelEn}</div>
                                    </td>
                                    <td class="py-2 px-3 text-center border border-slate-700">${lStr}</td>
                                    <td class="py-2 px-3 text-center border border-slate-700">${pStr}</td>
                                    <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${rowJml}</td>
                                </tr>
                            `;
                        });

                        // Baris Header Golongan
                        rowsHtml += `
                            <tr data-group="true" class="bg-amber-100/70 font-bold text-slate-800 border-t border-b border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold" colspan="2">
                                    <span>${grp.groupId}</span> / <span class="italic font-normal text-xs text-slate-700">${grp.groupEn}</span>
                                </td>
                                <td class="py-2 px-3 text-center border border-slate-700"></td>
                                <td class="py-2 px-3 text-center border border-slate-700"></td>
                                <td class="py-2 px-3 text-center border border-slate-700"></td>
                            </tr>
                            ${grpRanksHtml}
                        `;
                    });

                    // Baris Total / Jumlah Akhir
                    rowsHtml += `
                        <tr data-total="true" class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
                            <td class="py-2.5 px-4 font-bold border border-slate-700 text-left" colspan="2">
                                <div>Jumlah</div>
                                <div class="italic font-normal text-xs text-slate-700">Total</div>
                            </td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totL : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totP : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-200">${hasData ? totJml : '-'}</td>
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-3 font-bold border border-slate-700 align-middle text-center" colspan="2" rowspan="2">
                                    <div>Pangkat / Golongan / Ruang</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Hierarchy / Range</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Pegawai Negeri Sipil</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Civil Servant</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-3 border border-slate-700 text-center"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-3 border border-slate-700 text-center"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-3 border border-slate-700 text-center bg-amber-600 font-extrabold"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center" colspan="2">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center font-bold bg-amber-200/60">(4)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '2.3.4': {
                titleId: 'Jumlah Pegawai Pemerintah dengan Perjanjian Kerja Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang)',
                titleEn: 'Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people)',
                source: 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / <span class="italic text-slate-500">Human Resources and Development Agency of Bukittinggi Municipality</span>',
                note: (yr) => '<div>Data per-31 Desember ' + (yr || currentYear || '2025') + '</div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                    const defaultData234 = {
                        2025: {
                            'gol_1': { l: '4', p: '1' },
                            'gol_2': { l: '0', p: '0' },
                            'gol_3': { l: '0', p: '0' },
                            'gol_4': { l: '1', p: '0' },
                            'gol_5': { l: '116', p: '44' },
                            'gol_6': { l: '0', p: '0' },
                            'gol_7': { l: '21', p: '74' },
                            'gol_8': { l: '0', p: '4' },
                            'gol_9': { l: '101', p: '288' },
                            'gol_10': { l: '2', p: '0' },
                            'gol_11': { l: '0', p: '0' },
                            'gol_12': { l: '0', p: '0' },
                            'gol_13': { l: '0', p: '0' },
                            'gol_14': { l: '0', p: '0' },
                            'gol_15': { l: '0', p: '0' },
                            'gol_16': { l: '0', p: '0' },
                            'gol_17': { l: '0', p: '0' }
                        },
                        2024: {
                            'gol_1': { l: '0', p: '0' },
                            'gol_2': { l: '0', p: '0' },
                            'gol_3': { l: '0', p: '0' },
                            'gol_4': { l: '0', p: '0' },
                            'gol_5': { l: '34', p: '5' },
                            'gol_6': { l: '0', p: '0' },
                            'gol_7': { l: '18', p: '72' },
                            'gol_8': { l: '0', p: '4' },
                            'gol_9': { l: '95', p: '280' },
                            'gol_10': { l: '0', p: '0' },
                            'gol_11': { l: '0', p: '0' },
                            'gol_12': { l: '0', p: '0' },
                            'gol_13': { l: '0', p: '0' },
                            'gol_14': { l: '0', p: '0' },
                            'gol_15': { l: '0', p: '0' },
                            'gol_16': { l: '0', p: '0' },
                            'gol_17': { l: '0', p: '0' }
                        }
                    };

                    const ranks = [
                        { key: 'gol_1',  noGol: '1.',  labelId: 'Golongan I',    labelEn: 'Range I (Setara SD)' },
                        { key: 'gol_2',  noGol: '2.',  labelId: 'Golongan II',   labelEn: 'Range II' },
                        { key: 'gol_3',  noGol: '3.',  labelId: 'Golongan III',  labelEn: 'Range III' },
                        { key: 'gol_4',  noGol: '4.',  labelId: 'Golongan IV',   labelEn: 'Range IV (Setara SMP)' },
                        { key: 'gol_5',  noGol: '5.',  labelId: 'Golongan V',    labelEn: 'Range V (Setara SMA/SMK)' },
                        { key: 'gol_6',  noGol: '6.',  labelId: 'Golongan VI',   labelEn: 'Range VI (Setara D-II)' },
                        { key: 'gol_7',  noGol: '7.',  labelId: 'Golongan VII',  labelEn: 'Range VII (Setara D-III)' },
                        { key: 'gol_8',  noGol: '8.',  labelId: 'Golongan VIII', labelEn: 'Range VIII (Setara D-IV)' },
                        { key: 'gol_9',  noGol: '9.',  labelId: 'Golongan IX',   labelEn: 'Range IX (Setara S-1/D-IV)' },
                        { key: 'gol_10', noGol: '10.', labelId: 'Golongan X',    labelEn: 'Range X (Setara S-2)' },
                        { key: 'gol_11', noGol: '11.', labelId: 'Golongan XI',   labelEn: 'Range XI (Setara S-3)' },
                        { key: 'gol_12', noGol: '12.', labelId: 'Golongan XII',  labelEn: 'Range XII' },
                        { key: 'gol_13', noGol: '13.', labelId: 'Golongan XIII', labelEn: 'Range XIII' },
                        { key: 'gol_14', noGol: '14.', labelId: 'Golongan XIV',  labelEn: 'Range XIV' },
                        { key: 'gol_15', noGol: '15.', labelId: 'Golongan XV',   labelEn: 'Range XV' },
                        { key: 'gol_16', noGol: '16.', labelId: 'Golongan XVI',  labelEn: 'Range XVI' },
                        { key: 'gol_17', noGol: '17.', labelId: 'Golongan XVII', labelEn: 'Range XVII' }
                    ];

                    const yrDefaults = defaultData234[yr] || {};

                    let totL = 0, totP = 0, totJml = 0;
                    let hasData = false;
                    let rowsHtml = '';

                    ranks.forEach(rk => {
                        const def = yrDefaults[rk.key] || { l: '-', p: '-' };
                        const lStr = (d[`${rk.key}_l`] !== undefined && d[`${rk.key}_l`] !== '') ? d[`${rk.key}_l`] : def.l;
                        const pStr = (d[`${rk.key}_p`] !== undefined && d[`${rk.key}_p`] !== '') ? d[`${rk.key}_p`] : def.p;

                        const numL = parseFloat(String(lStr).replace(',', '.')) || 0;
                        const numP = parseFloat(String(pStr).replace(',', '.')) || 0;

                        const isLSet = (lStr !== '-' && lStr !== '');
                        const isPSet = (pStr !== '-' && pStr !== '');

                        if (isLSet || isPSet) {
                            hasData = true;
                        }

                        const rowJml = (isLSet || isPSet) ? (numL + numP) : '-';

                        if (typeof rowJml === 'number') {
                            totL += numL;
                            totP += numP;
                            totJml += rowJml;
                        }

                        rowsHtml += `
                            <tr data-key="${rk.key}" class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-3 font-semibold border border-slate-700 text-center w-12">${rk.noGol}</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                    <div>${rk.labelId}</div>
                                    <div class="italic font-normal text-xs text-slate-600">${rk.labelEn}</div>
                                </td>
                                <td class="py-2 px-3 text-center border border-slate-700">${lStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700">${pStr}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${rowJml}</td>
                            </tr>
                        `;
                    });

                    // Baris Total / Jumlah Akhir
                    rowsHtml += `
                        <tr data-total="true" class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
                            <td class="py-2.5 px-4 font-bold border border-slate-700 text-left" colspan="2">
                                <div>Jumlah</div>
                                <div class="italic font-normal text-xs text-slate-700">Total</div>
                            </td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totL : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totP : '-'}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-200">${hasData ? totJml : '-'}</td>
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-3 font-bold border border-slate-700 align-middle text-center" colspan="2" rowspan="2">
                                    <div>Tingkat Kepangkatan / Golongan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Hierarchy / Range</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Pegawai Pemerintah dengan Perjanjian Kerja</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Civil Servants with Employment Agreements</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-3 border border-slate-700 text-center"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-3 border border-slate-700 text-center"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-3 border border-slate-700 text-center bg-amber-600 font-extrabold"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center" colspan="2">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center font-bold bg-amber-200/60">(4)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '2.3.5': {
                titleId: 'Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi (orang)',
                titleEn: 'Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement (people)',
                source: 'Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / <span class="italic text-slate-500">Human Resources and Development Agency of Bukittinggi Municipality</span>',
                note: (yr) => '<div>Data per-31 Desember ' + (yr || currentYear || '2025') + '</div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                    ﻿const units235 = [
    { key: 'unit_1', no: 1, name: "01. Sekretaris Daerah", pns25: '104', pppk25: '5', pns24: '99', pppk24: '4' },
    { key: 'unit_2', no: 2, name: "02. Badan Kepegawaian dan Pengembangan Sumber Daya Manusia", pns25: '27', pppk25: '2', pns24: '27', pppk24: '0' },
    { key: 'unit_3', no: 3, name: "03. Badan Keuangan", pns25: '57', pppk25: '5', pns24: '50', pppk24: '3' },
    { key: 'unit_4', no: 4, name: "04. Badan Perencanaan Penelitian dan Pembangunan", pns25: '32', pppk25: '1', pns24: '33', pppk24: '0' },
    { key: 'unit_5', no: 5, name: "05. Inspektorat Daerah", pns25: '43', pppk25: '0', pns24: '44', pppk24: '0' },
    { key: 'unit_6', no: 6, name: "06. Sekretariat Dewan Perwakilan Rakyat daerah", pns25: '26', pppk25: '3', pns24: '27', pppk24: '0' },
    { key: 'unit_7', no: 7, name: "07. Dinas Pemadam Kebakaran dan Penyelamatan", pns25: '24', pppk25: '25', pns24: '24', pppk24: '25' },
    { key: 'unit_8', no: 8, name: "08. Dinas Kependudukan Dan Pencatatan Sipil", pns25: '22', pppk25: '2', pns24: '23', pppk24: '0' },
    { key: 'unit_9', no: 9, name: "09. Dinas Kesehatan", pns25: '54', pppk25: '7', pns24: '49', pppk24: '5' },
    { key: 'unit_10', no: 10, name: "10. Dinas Komunikasi Dan Informatika", pns25: '19', pppk25: '3', pns24: '20', pppk24: '3' },
    { key: 'unit_11', no: 11, name: "11. Dinas Koperasi, Usaha Kecil mengengah Dan Tenaga Kerja", pns25: '24', pppk25: '4', pns24: '21', pppk24: '1' },
    { key: 'unit_12', no: 12, name: "12. Dinas Lingkungan Hidup", pns25: '101', pppk25: '22', pns24: '102', pppk24: '10' },
    { key: 'unit_13', no: 13, name: "13. Dinas Pariwisata", pns25: '45', pppk25: '15', pns24: '44', pppk24: '3' },
    { key: 'unit_14', no: 14, name: "14. Dinas Pekerjaan Umum dan Penataan Ruang", pns25: '52', pppk25: '8', pns24: '50', pppk24: '5' },
    { key: 'unit_15', no: 15, name: "15. Dinas Pemberdayaan Perempuan Dan Perlindungan Anak, Pengendalian Penduduk Dan Keluarga Berencana", pns25: '28', pppk25: '2', pns24: '30', pppk24: '0' },
    { key: 'unit_16', no: 16, name: "16. Dinas Penanaman Modal Pelayanan Terpadu Satu Pintu", pns25: '23', pppk25: '3', pns24: '25', pppk24: '2' },
    { key: 'unit_17', no: 17, name: "17. Dinas Pendidikan Dan Kebudayaan", pns25: '66', pppk25: '5', pns24: '71', pppk24: '0' },
    { key: 'unit_18', no: 18, name: "18. Dinas Perhubungan", pns25: '36', pppk25: '6', pns24: '41', pppk24: '2' },
    { key: 'unit_19', no: 19, name: "19. Dinas Perpustakaan Dan Kearsipan", pns25: '22', pppk25: '1', pns24: '28', pppk24: '1' },
    { key: 'unit_20', no: 20, name: "20. Dinas Pertanian Dan Pangan", pns25: '42', pppk25: '5', pns24: '39', pppk24: '3' },
    { key: 'unit_21', no: 21, name: "21. Dinas Perdagangan dan Perindustrian", pns25: '28', pppk25: '13', pns24: '26', pppk24: '3' },
    { key: 'unit_22', no: 22, name: "22. Dinas Perumahan Dan Kawasan Pemukiman", pns25: '30', pppk25: '7', pns24: '29', pppk24: '0' },
    { key: 'unit_23', no: 23, name: "23. Dinas Sosial", pns25: '21', pppk25: '5', pns24: '19', pppk24: '0' },
    { key: 'unit_24', no: 24, name: "24. Dinas Pemuda dan Olahraga", pns25: '17', pppk25: '6', pns24: '17', pppk24: '0' },
    { key: 'unit_25', no: 25, name: "25. Satuan Polisi Pamong Praja", pns25: '59', pppk25: '50', pns24: '47', pppk24: '0' },
    { key: 'unit_26', no: 26, name: "26. Badan Penanggulangan Bencana Daerah", pns25: '11', pppk25: '15', pns24: '12', pppk24: '15' },
    { key: 'unit_27', no: 27, name: "27. Badan Kesatuan Bangsa dan Politik", pns25: '14', pppk25: '1', pns24: '15', pppk24: '1' },
    { key: 'unit_28', no: 28, name: "28. Kecamatan Aur Birugo Tigo Baleh", pns25: '14', pppk25: '1', pns24: '15', pppk24: '1' },
    { key: 'unit_29', no: 29, name: "29. Kecamatan Guguk Panjang", pns25: '13', pppk25: '2', pns24: '14', pppk24: '1' },
    { key: 'unit_30', no: 30, name: "30. Kecamatan Mandiangin Koto Selayan", pns25: '17', pppk25: '1', pns24: '18', pppk24: '1' },
    { key: 'unit_31', no: 31, name: "31. Keluarahan Campago Guguk Bulek", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_32', no: 32, name: "32. Kelurahan Campago Ipuh", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_33', no: 33, name: "33. Kelurahan Garegeh", pns25: '6', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_34', no: 34, name: "34. Kelurahan Koto Selayan", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_35', no: 35, name: "35. Kelurahan Kubu Gulai Bancah", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_36', no: 36, name: "36. Kelurahan Manggis Ganting", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_37', no: 37, name: "37. Kelurahan Puhun Pintu Kabun", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_38', no: 38, name: "38. Kelurahan Puhun Tembok", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_39', no: 39, name: "39. Kelurahan Pulai Anak Air", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_40', no: 40, name: "40. Kelurahan Aur Tajungkang Tengah Sawah", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_41', no: 41, name: "41. Kelurahan Benteng Pasar Atas", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_42', no: 42, name: "42. Kelurahan Bukit Apit Puhun", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_43', no: 43, name: "43. Kelurahan Bukit Cangang kayu Ramang", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_44', no: 44, name: "44. Kelurahan Kayu Kubu", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_45', no: 45, name: "45. Kelurahan Pakan Kurai", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_46', no: 46, name: "46. Kelurahan Tarok Dipo", pns25: '7', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_47', no: 47, name: "47. Kelurahan Belakang Balok", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_48', no: 48, name: "48. Kelurahan Aur Kuning", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_49', no: 49, name: "49. Kelurahan Birugo", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_50', no: 50, name: "50. Kelurahan Kubu Tanjung", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_51', no: 51, name: "51. Kelurahan Ladang Cakiah", pns25: '7', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_52', no: 52, name: "52. Kelurahan Pakan Labuah", pns25: '6', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_53', no: 53, name: "53. Kelurahan Parit Antang", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_54', no: 54, name: "54. Kelurahan Sapiran", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_55', no: 55, name: "55. TK", pns25: '13', pppk25: '2', pns24: '15', pppk24: '2' },
    { key: 'unit_56', no: 56, name: "56. SD", pns25: '373', pppk25: '178', pns24: '389', pppk24: '179' },
    { key: 'unit_57', no: 57, name: "57. SMP \/ MTsN", pns25: '202', pppk25: '83', pns24: '209', pppk24: '81' },
    { key: 'unit_58', no: 58, name: "58. UPTD Sanggar Kegiatan Belajar", pns25: '3', pppk25: '9', pns24: '3', pppk24: '9' },
    { key: 'unit_59', no: 59, name: "59. UPTD Instalasi Farmasi", pns25: '5', pppk25: '2', pns24: '6', pppk24: '2' },
    { key: 'unit_60', no: 60, name: "60. UPTD Laboratorium Kesehatan", pns25: '16', pppk25: '1', pns24: '16', pppk24: '1' },
    { key: 'unit_61', no: 61, name: "61. UPTD Puskemas Guguak Panjang", pns25: '35', pppk25: '3', pns24: '36', pppk24: '3' },
    { key: 'unit_62', no: 62, name: "62. UPTD Puskesmas Gulai Bancah", pns25: '30', pppk25: '1', pns24: '30', pppk24: '1' },
    { key: 'unit_63', no: 63, name: "63. UPTD Puskemas Mandiangin", pns25: '31', pppk25: '3', pns24: '33', pppk24: '3' },
    { key: 'unit_64', no: 64, name: "64. UPTD Puskesmas Nilam Sari", pns25: '31', pppk25: '5', pns24: '33', pppk24: '5' },
    { key: 'unit_65', no: 65, name: "65. UPTD Puskesmas Perkotaan Rasimah Ahmad", pns25: '40', pppk25: '3', pns24: '41', pppk24: '3' },
    { key: 'unit_66', no: 66, name: "66. UPTD Puskesmas Plus Mandiangin", pns25: '29', pppk25: '4', pns24: '29', pppk24: '4' },
    { key: 'unit_67', no: 67, name: "67. UPTD Puskemas Tigo Baleh", pns25: '41', pppk25: '2', pns24: '44', pppk24: '2' },
    { key: 'unit_68', no: 68, name: "68. UPTD RSUD", pns25: '95', pppk25: '124', pns24: '88', pppk24: '124' },
    { key: 'unit_69', no: 69, name: "69. UPTD Balai Benih Ikan Hias", pns25: '4', pppk25: '2', pns24: '2', pppk24: '0' },
    { key: 'unit_70', no: 70, name: "70. UPTD Pusat Kesehatan Hewan", pns25: '5', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_71', no: 71, name: "71. UPTD Rumah Potong Hewan", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_72', no: 72, name: "72. UPTD Kerajinan Industri", pns25: '2', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_73', no: 73, name: "73. UPTD Penguji Kendaraan bermotor", pns25: '6', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_74', no: 74, name: "74. UPTD Terminal dan Parkir", pns25: '16', pppk25: '9', pns24: '18', pppk24: '0' },
    { key: 'unit_75', no: 75, name: "75. UPTD Penerangan Fasilitas Umum", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_76', no: 76, name: "76. UPTD Perlengkapan dan Peralatan", pns25: '4', pppk25: '0', pns24: '4', pppk24: '0' },
    { key: 'unit_77', no: 77, name: "77. UPTD Kemetrologian", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_78', no: 78, name: "78. UPTD Perlindungan Perempuan dan Anak", pns25: '5', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_79', no: 79, name: "79. STAF AHLI", pns25: '3', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_80', no: 80, name: "80. Tugas Belajar", pns25: '4', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_81', no: 81, name: "81. MPP", pns25: '6', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_82', no: 82, name: "82. Diperbantukan", pns25: '12', pppk25: '0', pns24: '13', pppk24: '0' },
    { key: 'unit_83', no: 83, name: "83. CLTN", pns25: '1', pppk25: '0', pns24: '2', pppk24: '0' },
    { key: 'unit_84', no: 84, name: "84. Pemberhentian Sementara", pns25: '1', pppk25: '0', pns24: '2', pppk24: '0' },
];

                    let totPns = 0, totPppk = 0, totJml = 0;
                    let hasData = false;
                    let rowsHtml = '';

                    units235.forEach(u => {
                        const defPns = (yr === 2024 ? u.pns24 : (yr === 2025 ? u.pns25 : '-'));
                        const defPppk = (yr === 2024 ? u.pppk24 : (yr === 2025 ? u.pppk25 : '-'));

                        const pnsStr = (d[`${u.key}_pns`] !== undefined && d[`${u.key}_pns`] !== '') ? d[`${u.key}_pns`] : defPns;
                        const pppkStr = (d[`${u.key}_pppk`] !== undefined && d[`${u.key}_pppk`] !== '') ? d[`${u.key}_pppk`] : defPppk;

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
                            <tr data-key="${u.key}" class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-top">
                                    ${u.name}
                                </td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-top">${pnsStr}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-top">${pppkStr}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-100/70 align-top">${rowJml}</td>
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
                            <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">${hasData ? totPns : '-'}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">${hasData ? totPppk : '-'}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-200">${hasData ? totJml : '-'}</td>
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
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            }
        };

        // Data dari Database MySQL SiMonDa Bukittinggi
        let serverDbDataStore = {};
        let serverDbMetadata = {};
        let serverDbFallbackMetadata = {};
        const csrfToken = '"dummy"';

        /**
         * Buat template tabel dengan struktur kolom & rincian baris dari tahun lain,
         * namun hanya nilai angka / data yang dikosongkan (diisi tanda strip '-').
         */
        function buildEmptyTemplateFromSource(sourceHtml, targetYear, sourceYear) {
            if (!sourceHtml) return null;
            if (currentTableCode === '1.1.6' && tableSchemas['1.1.6']) {
                return tableSchemas['1.1.6'].render(targetYear);
            }
            const tempTable = document.createElement('table');
            tempTable.innerHTML = sourceHtml;

            // 1. thead: Ganti tahun lama di header jika ada teks tahun eksplisit
            if (sourceYear && targetYear && sourceYear.toString() !== targetYear.toString()) {
                const theadThs = tempTable.querySelectorAll('thead th');
                theadThs.forEach(th => {
                    const regexYr = new RegExp(`\\b${sourceYear}\\b`, 'g');
                    if (regexYr.test(th.innerText)) {
                        th.innerHTML = th.innerHTML.replace(regexYr, targetYear);
                    }
                });
            }

            // 2. tbody: Kosongkan sel data nilai angka, tetapi pertahankan baris indikator / jabatan
            const tbodyRows = tempTable.querySelectorAll('tbody tr');
            tbodyRows.forEach(tr => {
                const tds = tr.querySelectorAll('td');
                if (tds.length === 0) return;

                tds.forEach((td, colIdx) => {
                    // Kolom pertama selalu merupakan label indikator/jabatan/kategori
                    if (colIdx === 0) return;

                    // Jika sel memiliki colspan besar yang membentang hampir seluruh kolom (misal subheader "Golongan I"), jangan diubah
                    const colspan = parseInt(td.getAttribute('colspan') || '1', 10);
                    if (colspan >= 2) {
                        const text = td.innerText.trim();
                        if (/[a-zA-Z]{3,}/.test(text)) {
                            return;
                        }
                    }

                    // Jika sel memiliki rowspan dan berisi teks (bukan angka), jangan diubah
                    if (td.hasAttribute('rowspan')) {
                        const text = td.innerText.trim();
                        if (/[a-zA-Z]{3,}/.test(text) && !/^\d+$/.test(text)) {
                            return;
                        }
                    }

                    // Jangan timpa label tahun (misal: 2024, 2025, 2022(SIUP)) menjadi strip '-'
                    const rawText = td.innerText.trim();
                    if (/^(19|20)\d{2}(\s*\(SIUP\))?$/.test(rawText)) {
                        return;
                    }

                    // Periksa apakah isi sel adalah angka murni, tanda strip, atau nilai kosong
                    const isPureNumberOrDash = /^[\d.,\s\-%–—()]+$/.test(rawText) || rawText === '';
                    
                    if (isPureNumberOrDash) {
                        td.innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                        td.className = td.className.replace(/text-(left|right)/g, '') + ' text-center align-middle';
                    }
                });
            });

            // Khusus tabel 11.2: atur 6 rentang tahun historis pada bagian Jumlah [targetYear, targetYear-1, ..., targetYear-5]
            if (currentTableCode === '11.2') {
                const yr = parseInt(targetYear) || 2026;
                // Bersihkan baris siluman / orphaned row sebelum Jumlah jika ada
                const allTrs = Array.from(tempTable.querySelectorAll('tbody tr'));
                allTrs.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 2 && tds[0].innerText.trim() === '-' && tr.nextElementSibling && tr.nextElementSibling.innerText.includes('Jumlah')) {
                        tr.remove();
                    }
                });

                const jumlahCell = Array.from(tempTable.querySelectorAll('td')).find(td => td.innerText.trim() === 'Jumlah');
                if (jumlahCell) {
                    let currentRow = jumlahCell.parentElement;
                    for (let i = 0; i < 6; i++) {
                        if (!currentRow) break;
                        const y = yr - i;
                        const label = (y <= 2022) ? `${y}(SIUP)` : `${y}`;
                        const tds = currentRow.querySelectorAll('td');
                        const yearTd = (i === 0) ? tds[1] : tds[0];
                        if (yearTd) {
                            yearTd.innerText = label;
                            yearTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top' + (i === 0 ? ' font-extrabold' : '');
                        }
                        currentRow = currentRow.nextElementSibling;
                    }
                }
            }

            return tempTable.innerHTML;
        }

        // Query Param State
        let currentOpdCode = '"dummy"';
        let currentTableCode = '"dummy"';
        let currentYear = '"dummy"';
        let currentType = '"dummy"';
        let isEditMode = false;

        function initPage() {
            // One-time cleanup: remove accidental saves
            try {
                localStorage.removeItem('simonda_table_html_1.1.6_2026');
                localStorage.removeItem('simonda_table_html_8.1.2_2026');
                localStorage.removeItem('simonda_table_html_8.1.2_2027');
                for (let y = 2015; y <= 2030; y++) {
                    const k = `simonda_table_html_8.1.3_${y}`;
                    const val = localStorage.getItem(k);
                    if (val && (val.includes('72,40') || val.includes('123,20') || val.includes('74,10') || y <= 2020 || y >= 2026)) {
                        localStorage.removeItem(k);
                    }
                    if (y !== 2024 && y !== 2025) {
                        localStorage.removeItem(`simonda_table_html_8.1.5_${y}`);
                        localStorage.removeItem(`simonda_table_source_8.1.5_${y}`);
                        localStorage.removeItem(`simonda_table_is_saved_8.1.5_${y}`);
                    }
                    const k231 = `simonda_table_html_2.3.1_${y}`;
                    const val231 = localStorage.getItem(k231);
                    if (val231 && (!val231.includes('Pegawai Negeri Sipil') || !val231.includes('PPPK'))) {
                        localStorage.removeItem(k231);
                        localStorage.removeItem(`simonda_table_source_2.3.1_${y}`);
                        localStorage.removeItem(`simonda_table_is_saved_2.3.1_${y}`);
                    }
                    const k232 = `simonda_table_html_2.3.2_${y}`;
                    const val232 = localStorage.getItem(k232);
                    if (val232 && (!val232.includes('Pegawai Negeri Sipil') || !val232.includes('PPPK'))) {
                        localStorage.removeItem(k232);
                        localStorage.removeItem(`simonda_table_source_2.3.2_${y}`);
                        localStorage.removeItem(`simonda_table_is_saved_2.3.2_${y}`);
                    }
                    const k233 = `simonda_table_html_2.3.3_${y}`;
                    const val233 = localStorage.getItem(k233);
                    if (val233 && (!val233.includes('Pangkat') || !val233.includes('Pegawai Negeri Sipil'))) {
                        localStorage.removeItem(k233);
                        localStorage.removeItem(`simonda_table_source_2.3.3_${y}`);
                        localStorage.removeItem(`simonda_table_is_saved_2.3.3_${y}`);
                    }
                }
            } catch(e) {}

            const params = new URLSearchParams(window.location.search);
            currentType = params.get('type') || currentType || 'opd';
            currentOpdCode = params.get('opd') || '01';
            currentTableCode = params.get('code') || params.get('table') || '1.1.6';
            currentYear = params.get('year') || '2025';

            // Check if returned with saved data confirmation
            if (params.get('saved') === '1') {
                showToast('✅ Perubahan data tabel berhasil disimpan ke SiAngka!');
                const cleanUrl = new URL(window.location);
                cleanUrl.searchParams.delete('saved');
                window.history.replaceState({}, '', cleanUrl);
            }


            renderTablePage();
            setupDragAndDrop();
        }

        function get5YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 4;
            const end = yr;
            return {
                start: start,
                end: end,
                yearsAsc: [yr - 4, yr - 3, yr - 2, yr - 1, yr],
                yearsDesc: [yr, yr - 1, yr - 2, yr - 3, yr - 4],
                label: `${start}–${end}`
            };
        }

        function updateYearSwitcher(isMultiYear, isExcludeSelectedYear) {
            const selectYearEl = document.getElementById('yearSwitcher');
            if (!selectYearEl) return;
            const currentVal = currentYear.toString();
            const nowYear = new Date().getFullYear();
            const endYear = Math.max(2036, nowYear + 10);
            selectYearEl.innerHTML = '';
            for (let y = endYear; y >= 2018; y--) {
                const opt = document.createElement('option');
                opt.value = y.toString();
                const p = get5YearPeriod(y);
                if (isExcludeSelectedYear) {
                    opt.textContent = `Tahun ${y} (${y - 5}–${y - 1})`;
                } else if (isMultiYear) {
                    opt.textContent = `Tahun ${y} (${p.label})`;
                } else {
                    opt.textContent = `Tahun ${y}`;
                }
                if (y.toString() === currentVal) {
                    opt.selected = true;
                }
                selectYearEl.appendChild(opt);
            }
            if (![...selectYearEl.options].some(o => o.value === currentVal)) {
                const customOpt = document.createElement('option');
                customOpt.value = currentVal;
                const cNum = parseInt(currentVal);
                const p = get5YearPeriod(cNum);
                if (isExcludeSelectedYear && !isNaN(cNum)) {
                    customOpt.textContent = `Tahun ${currentVal} (${cNum - 5}–${cNum - 1})`;
                } else if (isMultiYear && !isNaN(cNum)) {
                    customOpt.textContent = `Tahun ${currentVal} (${p.label})`;
                } else {
                    customOpt.textContent = `Tahun ${currentVal}`;
                }
                customOpt.selected = true;
                selectYearEl.insertBefore(customOpt, selectYearEl.firstChild);
            }
            selectYearEl.value = currentVal;
        }

        function updateTableSwitcher() {
            const tableSelect = document.getElementById('tableSwitcher');
            if (!tableSelect) return;

            let tables = [];
            if (typeof getAgencyTables === 'function') {
                tables = getAgencyTables(currentOpdCode, currentType);
            }
            if ((!tables || tables.length === 0) && typeof opdTablesCatalog !== 'undefined') {
                const cleanOpd = currentOpdCode ? currentOpdCode.toString().padStart(2, '0') : '01';
                const cat = (currentType === 'instansi' && typeof instansiTablesCatalog !== 'undefined') 
                    ? instansiTablesCatalog 
                    : opdTablesCatalog;
                tables = (cat && cat[cleanOpd]) ? cat[cleanOpd] : [];
            }

            tableSelect.innerHTML = '';

            let currentInList = false;
            if (tables && tables.length > 0) {
                tables.forEach(t => {
                    const opt = document.createElement('option');
                    opt.value = t.code;
                    opt.textContent = `Tabel ${t.code} - ${t.title || ''}`;
                    opt.title = `Tabel ${t.code}: ${t.title || ''}`;
                    if (t.code === currentTableCode) {
                        opt.selected = true;
                        currentInList = true;
                    }
                    tableSelect.appendChild(opt);
                });
            }

            if (!currentInList) {
                const opt = document.createElement('option');
                opt.value = currentTableCode;
                opt.textContent = `Tabel ${currentTableCode}`;
                opt.selected = true;
                tableSelect.insertBefore(opt, tableSelect.firstChild);
            }

            tableSelect.value = currentTableCode;

            const labelEl = document.getElementById('tableSwitcherLabel');
            if (labelEl) {
                labelEl.innerText = `Tabel ${currentTableCode}`;
            }

            // Update disabled state tombol Prev / Next
            const prevBtn = document.getElementById('btnPrevTable');
            const nextBtn = document.getElementById('btnNextTable');
            if (prevBtn && nextBtn) {
                if (tables && tables.length > 0) {
                    const curIdx = tables.findIndex(t => t.code === currentTableCode);
                    prevBtn.disabled = curIdx <= 0;
                    nextBtn.disabled = curIdx === -1 || curIdx >= tables.length - 1;
                } else {
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                }
            }
        }

        function changeTableCode(newCode) {
            if (!newCode || newCode === currentTableCode) return;
            const newUrl = new URL(window.location.origin + window.location.pathname);
            newUrl.searchParams.set('code', newCode);
            newUrl.searchParams.set('opd', currentOpdCode);
            newUrl.searchParams.set('year', currentYear);
            if (currentType) {
                newUrl.searchParams.set('type', currentType);
            }
            if (typeof getCatalogTableInfo === 'function') {
                const info = getCatalogTableInfo(newCode, currentOpdCode, currentType);
                if (info && info.title) {
                    newUrl.searchParams.set('title', info.title);
                }
                if (info && info.titleEn) {
                    newUrl.searchParams.set('title_en', info.titleEn);
                }
            }
            window.location.href = newUrl.toString();
        }

        function goToAdjacentTable(direction) {
            let tables = [];
            if (typeof getAgencyTables === 'function') {
                tables = getAgencyTables(currentOpdCode, currentType);
            }
            if ((!tables || tables.length === 0) && typeof opdTablesCatalog !== 'undefined') {
                const cleanOpd = currentOpdCode ? currentOpdCode.toString().padStart(2, '0') : '01';
                const cat = (currentType === 'instansi' && typeof instansiTablesCatalog !== 'undefined') 
                    ? instansiTablesCatalog 
                    : opdTablesCatalog;
                tables = (cat && cat[cleanOpd]) ? cat[cleanOpd] : [];
            }
            if (!tables || tables.length === 0) return;
            const curIdx = tables.findIndex(t => t.code === currentTableCode);
            if (curIdx === -1) return;
            const targetIdx = curIdx + direction;
            if (targetIdx >= 0 && targetIdx < tables.length) {
                changeTableCode(tables[targetIdx].code);
            }
        }

        window.addEventListener('popstate', () => {
            const params = new URLSearchParams(window.location.search);
            currentType = params.get('type') || currentType || 'opd';
            currentOpdCode = params.get('opd') || '01';
            currentTableCode = params.get('code') || params.get('table') || '1.1.6';
            currentYear = params.get('year') || '2025';
            const selectYearEl = document.getElementById('yearSwitcher');
            if (selectYearEl) selectYearEl.value = currentYear.toString();
            renderTablePage();
        });

        function renderTablePage() {
            const isInstansi = currentType === 'instansi';
            const agencyName = getAgencyName(currentOpdCode);

            // Update Header & Breadcrumbs
            const badgeEl = document.getElementById('headerTypeBadge');
            if (badgeEl) badgeEl.innerText = isInstansi ? 'INSTANSI VERTIKAL' : 'OPD';

            const btnBackEl = document.getElementById('btnBackToDaftar');
            const btnBackTextEl = document.getElementById('btnBackToDaftarText');
            if (btnBackEl) {
                btnBackEl.href = isInstansi ? ""dummy"" : ""dummy"";
            }
            if (btnBackTextEl) {
                btnBackTextEl.innerText = isInstansi ? 'Daftar Instansi' : 'Daftar OPD';
            }

            const breadcrumbCatalogLink = document.getElementById('breadcrumbCatalogLink');
            const breadcrumbCatalogText = document.getElementById('breadcrumbCatalogText');
            if (breadcrumbCatalogLink) {
                breadcrumbCatalogLink.href = isInstansi ? ""dummy"" : ""dummy"";
            }
            if (breadcrumbCatalogText) {
                breadcrumbCatalogText.innerText = isInstansi ? 'Isi Data Instansi Vertikal' : 'Isi Data OPD';
            }

            document.getElementById('breadcrumbOpdText').innerText = `${currentOpdCode}. ${agencyName}`;
            document.getElementById('breadcrumbTableText').innerText = `Tabel ${currentTableCode}`;

            document.getElementById('subHeadingOpd').innerText = `${currentOpdCode}. ${agencyName}`;
            document.getElementById('metaTableCode').innerText = currentTableCode;

            const printSub = document.getElementById('printOpdSubheading');
            if (printSub) {
                printSub.innerText = `${isInstansi ? 'Instansi' : 'OPD'} Penyelenggara Data: ${currentOpdCode}. ${agencyName}`;
            }

            // Ambil judul resmi dari katalog master OPD / Instansi
            const catInfo = (typeof getCatalogTableInfo === 'function') 
                ? getCatalogTableInfo(currentTableCode, currentOpdCode, currentType) 
                : null;
            const defaultTitleId = (catInfo && catInfo.title) 
                ? catInfo.title 
                : `Tabel Data Statistik Sektoral ${currentTableCode} di Kota Bukittinggi`;
            const defaultTitleEn = (catInfo && catInfo.titleEn) 
                ? catInfo.titleEn 
                : (catInfo && catInfo.title ? catInfo.title : `Sectoral Statistics Table ${currentTableCode} in Bukittinggi Municipality`);

            const schema = tableSchemas[currentTableCode] || {
                titleId: defaultTitleId,
                titleEn: defaultTitleEn,
                source: `${agencyName} Kota Bukittinggi / <span class="italic text-slate-500">Bukittinggi Municipality</span>`,
                render: function(year) {
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">Rincian Indikator / Kategori Data</th>
                                <th class="py-3 px-4 font-bold border border-slate-700">Capaian Nilai Tahun ${year}</th>
                                <th class="py-3 px-4 font-bold border border-slate-700">Satuan</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-6 px-4 text-center text-slate-400 italic" colspan="3">
                                    Belum ada data untuk tabel ini. Silakan gunakan tombol Import atau Edit Tabel untuk mengisi data.
                                </td>
                            </tr>
                        </tbody>
                    `;
                }
            };

            // Jika schema title masih generik namun ada info katalog resmi, gunakan judul resmi katalog
            if (catInfo && catInfo.title && (!schema.titleId || schema.titleId.startsWith('Tabel Data Statistik Sektoral'))) {
                schema.titleId = catInfo.title;
                schema.titleEn = catInfo.titleEn || catInfo.title;
            }

            const yr = parseInt(currentYear) || 2025;
            const p = get5YearPeriod(yr);
            const yearLabel = schema.isExcludeSelectedYear ? `${yr - 5}–${yr - 1}` : (schema.isMultiYear ? p.label : `${yr}`);
            document.getElementById('pageMainHeading').innerText = (schema.isMultiYear || schema.isExcludeSelectedYear) ? `Tabel ${currentTableCode} Tahun ${yearLabel}` : `Tabel ${currentTableCode} Tahun ${currentYear}`;
            
            // Check for custom titles/source saved from Database, Fallback Structure, or Excel
            let customTitleId = (serverDbMetadata && serverDbMetadata.title_id) ? serverDbMetadata.title_id : (localStorage.getItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`) || (serverDbFallbackMetadata && serverDbFallbackMetadata.title_id ? serverDbFallbackMetadata.title_id : null));
            let customTitleEn = (serverDbMetadata && serverDbMetadata.title_en) ? serverDbMetadata.title_en : (localStorage.getItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`) || (serverDbFallbackMetadata && serverDbFallbackMetadata.title_en ? serverDbFallbackMetadata.title_en : null));
            let customSource = (serverDbMetadata && serverDbMetadata.source) ? serverDbMetadata.source : (localStorage.getItem(`simonda_table_source_text_${currentTableCode}_${currentYear}`) || (serverDbFallbackMetadata && serverDbFallbackMetadata.source ? serverDbFallbackMetadata.source : null));
            let customNote = (serverDbMetadata && serverDbMetadata.note !== undefined && serverDbMetadata.note !== null) ? serverDbMetadata.note : (localStorage.getItem(`simonda_table_note_${currentTableCode}_${currentYear}`) || (serverDbFallbackMetadata && serverDbFallbackMetadata.note !== undefined ? serverDbFallbackMetadata.note : null));

            // Bersihkan custom title jika masih berupa placeholder generik lawas
            if (catInfo && catInfo.title) {
                if (customTitleId && customTitleId.includes('Tabel Data Statistik Sektoral')) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && customTitleEn.includes('Sectoral Statistics Table')) {
                    localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
            }

            // Auto-detect dan perbaiki jika titleId dan titleEn terbalik (English di ID, Indonesia di EN)
            function sanitizeBilingualTitles(tId, tEn) {
                if (!tId || !tEn) return { id: tId, en: tEn };
                const idHasEnglish = /\b(Actual|Number|Length|Population|Government|Expenditures|Revenues|Percentage|District|Kind of)\b/i.test(tId);
                const enHasIndo = /\b(Realisasi|Jumlah|Panjang|Penduduk|Pemerintah|Belanja|Pendapatan|Menurut|Jenis|Kecamatan|Banyaknya)\b/i.test(tEn);
                if (idHasEnglish && enHasIndo) {
                    return { id: tEn, en: tId };
                }
                return { id: tId, en: tEn };
            }

            const cleanTitles = sanitizeBilingualTitles(customTitleId, customTitleEn);
            customTitleId = cleanTitles.id;
            customTitleEn = cleanTitles.en;

            const cleanSchemaTitles = sanitizeBilingualTitles(schema.titleId, schema.titleEn);
            schema.titleId = cleanSchemaTitles.id;
            schema.titleEn = cleanSchemaTitles.en;

            // For Table 8.1.1, 8.1.2, and 8.1.3, ensure title always reflects the exact 5-year range [yr-4, yr]
            if (currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedRange = `${yrInt - 4}–${yrInt}`;
                if (customTitleId && !customTitleId.includes(expectedRange)) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && !customTitleEn.includes(expectedRange)) {
                    localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
            }

            // Sanitize customSource if it contains corrupted dumps from Excel
            if (customSource) {
                const sLower = customSource.toLowerCase();
                if (customSource.length > 220 || sLower.includes('catatan') || sLower.includes('tabel ') || sLower.includes('table ') || sLower.includes('negara') || sLower.includes('jumlah') || sLower.includes('rahmat afrisyaf') || sLower.includes('180.17')) {
                    localStorage.removeItem(`simonda_table_source_text_${currentTableCode}_${currentYear}`);
                    customSource = null;
                }
            }

            // Sanitize customNote if it contains corrupted dumps from Excel
            if (customNote) {
                const nLower = customNote.toLowerCase();
                if (customNote.length > 600 || nLower.includes('tabel ') || nLower.includes('table ') || nLower.includes('negara') || nLower.includes('rahmat afrisyaf')) {
                    localStorage.removeItem(`simonda_table_note_${currentTableCode}_${currentYear}`);
                    customNote = null;
                }
            }

            // Ensure title always contains the appropriate year or year range label
            function formatTitleWithYear(title, defaultTitle, yLabel) {
                let t = (title && title.trim()) ? title.trim() : (defaultTitle || '');
                if (!t) return '';
                if (t.includes(yLabel)) return t;

                // 1. Cek jika ada nama bulan sebelum tahun (misal: "Desember 2021" atau "December 2021")
                const monthYearPattern = /\b(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|May|June|July|August|October|December)\s+(19|20)\d{2}\b/i;
                if (monthYearPattern.test(t)) {
                    return t.replace(monthYearPattern, (m, month) => `${month} ${yLabel}`);
                }

                // 2. Cek tahun atau rentang tahun di akhir judul
                const yearPattern = /(,\s*|\s+)(19|20)\d{2}(\s*[–\-]\s*(19|20)\d{2})?\s*$/;
                if (yearPattern.test(t)) {
                    return t.replace(yearPattern, (match, prefix) => `${prefix}${yLabel}`);
                }

                // 3. Cek tahun 4 digit manapun di dalam judul
                const anyYearPattern = /\b(19|20)\d{2}\b/;
                if (anyYearPattern.test(t)) {
                    return t.replace(anyYearPattern, yLabel);
                }

                return `${t.replace(/,\s*$/, '')}, ${yLabel}`;
            }

            // Ensure note always contains the appropriate year when it mentions dynamic cut-off dates like "31 Desember [year]"
            function formatNoteWithYear(note, yr) {
                if (!note) return '';
                if (typeof note === 'function') return note(yr);
                let n = String(note);
                return n.replace(/(31\s+Desember\s+)\b(19|20)\d{2}\b/gi, `$1${yr}`)
                        .replace(/(per-?31\s+Desember\s+)\b(19|20)\d{2}\b/gi, `$1${yr}`)
                        .replace(/(per\s+31\s+Desember\s+)\b(19|20)\d{2}\b/gi, `$1${yr}`)
                        .replace(/(December\s+31(?:st)?,?\s*)\b(19|20)\d{2}\b/gi, `$1${yr}`)
                        .replace(/(as of December 31(?:st)?,?\s*)\b(19|20)\d{2}\b/gi, `$1${yr}`);
            }

            document.getElementById('metaTableTitleId').innerText = formatTitleWithYear(customTitleId, schema.titleId, yearLabel);
            document.getElementById('metaTableTitleEn').innerText = formatTitleWithYear(customTitleEn, schema.titleEn, yearLabel);
            document.getElementById('tableSourceContent').innerHTML = customSource ? customSource : schema.source;

            const noteRowEl = document.getElementById('tableNoteRow');
            const noteContentEl = document.getElementById('tableNoteContent');
            if (noteRowEl && noteContentEl) {
                const rawNote = customNote !== null ? customNote : (schema.note || '');
                const noteVal = formatNoteWithYear(rawNote, currentYear);
                if (noteVal) {
                    noteContentEl.innerHTML = noteVal;
                    noteRowEl.classList.remove('hidden');
                } else {
                    noteRowEl.classList.add('hidden');
                }
            }

            updateYearSwitcher(Boolean(schema.isMultiYear), Boolean(schema.isExcludeSelectedYear));
            updateTableSwitcher();

            const tableEl = document.getElementById('dataDisplayTable');
            
            // Sanity check serverDbMetadata: pastikan metadata server sesuai dengan currentYear
            if (serverDbMetadata && serverDbMetadata.year && serverDbMetadata.year.toString() !== currentYear.toString()) {
                serverDbMetadata = null;
            }

            // Check if table data was edited in dedicated edit page or generated from Excel
            let savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : localStorage.getItem(`simonda_table_html_${currentTableCode}_${currentYear}`);

            // Sanity check: jika savedHtml dari localStorage rusak atau tidak mengandung struktur <tr> dan <th>, bersihkan
            if (savedHtml && (!savedHtml.includes('<tr') || !savedHtml.includes('<th'))) {
                localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
            }

            if (savedHtml && currentTableCode === '2.4.2') {
                savedHtml = savedHtml.replace(/Jenis Pendapatan/gi, 'Jenis Belanja');
                savedHtml = savedHtml.replace(/Kind of Revenues/gi, 'Kind of Expenditures');
            }

            // Validasi savedHtml untuk tabel multi-tahun (8.1.1, 8.1.2, 8.1.3, 8.1.4, 8.1.5, 2.2.5, 1.1.10 atau schema.isMultiYear)
            const isMultiYearTable = Boolean(schema && (schema.isMultiYear || schema.isExcludeSelectedYear)) || 
                                     ['8.1.1', '8.1.2', '8.1.3', '8.1.4', '8.1.5', '2.2.5', '1.1.10'].includes(currentTableCode);

            if (isMultiYearTable && savedHtml && currentTableCode !== '8.1.4' && currentTableCode !== '8.1.5' && currentTableCode !== '1.1.10') {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = savedHtml;
                const allThs = Array.from(tempDiv.querySelectorAll('thead th'));
                const yrInt = parseInt(currentYear) || 2025;
                const expectedStartYear = (yrInt - 4).toString();
                const expectedEndYear = yrInt.toString();
                const hasStartYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedStartYear));
                const hasEndYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedEndYear));
                const firstRowTds = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td') : [];
                const isMissingCells = firstRowTds.length > 0 && firstRowTds.length < 6;

                if (!hasStartYearInHeader || !hasEndYearInHeader || isMissingCells) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata && serverDbMetadata.table_html) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Reset cache lama jika tabel 1.1.6 pernah tersimpan rusak saat awal migrasi
            if (currentTableCode === '1.1.6' && savedHtml && localStorage.getItem(`simonda_table_source_${currentTableCode}_${currentYear}`) !== 'excel') {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = savedHtml;
                const thCount = tempDiv.querySelectorAll('thead tr:last-child th').length;
                const tdCount = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td') : 0;
                if (thCount >= 4 && tdCount <= 1) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

            // Self-healing: bersihkan cache jika tabel 1.1.9 memiliki sel dengan rowspan yang merusak baris
            if (currentTableCode === '1.1.9' && savedHtml && savedHtml.includes('rowspan=')) {
                localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                if (serverDbMetadata && serverDbMetadata.table_html && serverDbMetadata.table_html.includes('rowspan=')) {
                    serverDbMetadata.table_html = null;
                }
                savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
            }

            // Reset cache lama jika tabel 8.1.2, 8.1.3, 8.1.4, 8.1.5, atau 1.1.10 pernah tersimpan dengan nilai statis dummy / periode lama
            const tableSource = localStorage.getItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
            const isExcelImport = (tableSource === 'excel');

            // Self-healing tabel 2.2.5: bersihkan cache jika memuat baris Jumlah / Total atau nilai lama
            if (currentTableCode === '2.2.5' && savedHtml && (savedHtml.toLowerCase().includes('jumlah') || savedHtml.toLowerCase().includes('total'))) {
                localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                if (serverDbMetadata) {
                    serverDbMetadata.table_html = null;
                }
                savedHtml = null;
            }

            // Self-healing tabel 2.3.1 & 2.3.2: bersihkan cache jika format tabel tidak memiliki header standar BPS (10 kolom)
            if ((currentTableCode === '2.3.1' || currentTableCode === '2.3.2') && savedHtml) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = savedHtml;
                const thCount = tempDiv.querySelectorAll('thead th').length;
                const isProper = thCount >= 9 && savedHtml.includes('Pegawai Negeri Sipil');
                if (!isProper) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Self-healing tabel 2.3.3: bersihkan cache jika format tabel tidak memiliki header standar BPS atau mengandung data import lama yang tertukar
            if (currentTableCode === '2.3.3' && savedHtml) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = savedHtml;
                const thCount = tempDiv.querySelectorAll('thead th').length;
                const firstRowTds = tempDiv.querySelectorAll('tbody tr:first-child td');
                const hasCorruptedMismatch = Array.from(firstRowTds).some(td => td.innerText.trim() === '107' || td.innerText.trim() === '1.498');
                const isProper = thCount >= 5 && savedHtml.includes('Pangkat') && !hasCorruptedMismatch;
                if (!isProper) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }


            // Validasi kesesuaian periode tahun pada savedHtml untuk tabel multi-tahun
            if (savedHtml && (currentTableCode === '1.1.10' || currentTableCode === '8.1.5' || currentTableCode === '8.1.4' || currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '2.2.5')) {
                const yrInt = parseInt(currentYear) || 2025;
                if (!savedHtml.includes(yrInt.toString())) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            if ((currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.1.4' || currentTableCode === '8.1.5') && savedHtml && !isExcelImport) {
                const yrInt = parseInt(currentYear) || 2025;
                const hasAncientDummy = savedHtml.includes('72,40') || savedHtml.includes('123,20') || 
                                       savedHtml.includes('105,20') || savedHtml.includes('112,50') || savedHtml.includes('65,40') ||
                                       savedHtml.includes('Jembatan Permanen') || savedHtml.includes('Trotoar dan Pejalan') || savedHtml.includes('14.850,0') ||
                                       savedHtml.includes('Gorong-Gorong (Culvert)') || savedHtml.includes('Drainase Primer') || savedHtml.includes('Drainase Sekunder') ||
                                       savedHtml.includes('4.210') || savedHtml.includes('18.650') || savedHtml.includes('42.300');
                const isUnenteredYear = (currentTableCode === '8.1.2' && (yrInt <= 2019 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.3' && (yrInt <= 2020 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.4' && (yrInt <= 2020 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.5' && (yrInt <= 2020 || yrInt >= 2027));
                if (hasAncientDummy || (isUnenteredYear && (!serverDbMetadata || !serverDbMetadata.table_html))) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
                }
            }

            // Self-healing tabel 11.2 (Dinas PMPTSP - NIB menurut Sektor)
            if (currentTableCode === '11.2' && savedHtml) {
                const yrStr = currentYear.toString();
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = savedHtml;
                const jumlahCell = Array.from(tempDiv.querySelectorAll('td')).find(td => td.innerText.trim() === 'Jumlah');
                let isCorrupt112 = false;
                if (jumlahCell) {
                    const rowTds = jumlahCell.parentElement.querySelectorAll('td');
                    if (rowTds.length >= 2) {
                        const topYearText = rowTds[1].innerText.trim();
                        if (topYearText === '-' || topYearText !== yrStr) {
                            isCorrupt112 = true;
                        }
                    }
                }
                const ghostRow = Array.from(tempDiv.querySelectorAll('tbody tr')).find(tr => {
                    const tds = tr.querySelectorAll('td');
                    return tds.length >= 2 && tds[0].innerText.trim() === '-' && tr.nextElementSibling && tr.nextElementSibling.innerText.includes('Jumlah');
                });
                if (ghostRow) isCorrupt112 = true;

                if (isCorrupt112) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Validasi umum: jika baris data memiliki sel lebih sedikit daripada kolom header (tabel terpotong)
            if (savedHtml) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = savedHtml;
                const headerCols = tempDiv.querySelectorAll('thead tr:last-child th').length;
                const firstRowTds = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td').length : 0;
                if (headerCols > 0 && firstRowTds > 0 && firstRowTds < headerCols) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

            // Sanity check untuk Tabel 8.1.1: Jika sel data (selain kolom 0) berisi nama baris/kategori
            // (seperti "1. Negara" atau "2. Provinsi" atau "3. Kota"), berarti HTML korup akibat salah geser kolom
            if (savedHtml) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = savedHtml;
                const rows = tempDiv.querySelectorAll('tbody tr');
                let isCorrupt = false;
                rows.forEach(r => {
                    const tds = r.querySelectorAll('td');
                    for (let c = 1; c < tds.length; c++) {
                        const txt = tds[c].innerText.trim();
                        if (txt.includes('Negara / State') || txt.includes('Provinsi / Province') || txt.includes('Kota / Municipality') || txt.includes('Kewenangan')) {
                            isCorrupt = true;
                            break;
                        }
                    }
                });
                if (isCorrupt) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }
            // Cek apakah data tersedia di database atau custom HTML
            const hasDbSaved = Boolean(serverDbMetadata && serverDbMetadata.is_saved);
            const isOfficialYear = ((currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.1.4' || currentTableCode === '8.1.5') && (currentYear.toString() === '2021' || currentYear.toString() === '2022' || currentYear.toString() === '2023' || currentYear.toString() === '2024' || currentYear.toString() === '2025' || currentYear.toString() === '2026'));
            const hasCustomData = (savedHtml !== null && savedHtml !== '');
            const hasData = isOfficialYear || hasDbSaved || hasCustomData;

            let isInheritedTemplate = false;
            // Jika tahun ini belum ada data tersimpan, cari struktur tabel dari tahun lain (HANYA untuk tabel non-multi-tahun)
            if (!savedHtml && !isMultiYearTable) {
                let sourceHtml = null;
                let sourceYr = null;

                if (serverDbFallbackMetadata && serverDbFallbackMetadata.table_html && !serverDbFallbackMetadata.table_html.includes('Belum ada data untuk tabel ini')) {
                    sourceHtml = serverDbFallbackMetadata.table_html;
                    sourceYr = serverDbFallbackMetadata.year;
                }

                if (!sourceHtml) {
                    const checkYears = [2025, 2024, 2023, 2022, 2021, 2026, 2027];
                    for (let y of checkYears) {
                        if (y.toString() === currentYear.toString()) continue;
                        const localKey = `simonda_table_html_${currentTableCode}_${y}`;
                        const localHtml = localStorage.getItem(localKey);
                        if (localHtml && !localHtml.includes('Belum ada data untuk tabel ini')) {
                            sourceHtml = localHtml;
                            sourceYr = y;
                            break;
                        }
                    }
                }

                if (sourceHtml && !sourceHtml.includes('Belum ada data untuk tabel ini')) {
                    savedHtml = buildEmptyTemplateFromSource(sourceHtml, currentYear, sourceYr);
                    isInheritedTemplate = true;
                }
            }

            if (savedHtml) {
                tableEl.innerHTML = savedHtml;
            } else {
                tableEl.innerHTML = schema.render(currentYear);
            }

            cleanGhostColumns(tableEl);
            cleanGhostRows(tableEl);

            // Pastikan semua sel yang berisi tanda strip (-) berada persis di tengah (horizontal & vertikal)
            // Dan deteksi otomatis format angka ribuan dengan titik pemisah untuk tabel keuangan (OPD 05 / Tabel 2.4.x)
            const isFinancialTable = (currentOpdCode === '05' || currentTableCode.startsWith('2.4') || currentTableCode.startsWith('2.4.'));

            tableEl.querySelectorAll('tbody tr').forEach(tr => {
                const tds = tr.querySelectorAll('td');
                const isTotalRow = tr.classList.contains('font-bold') || tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total');

                tds.forEach((td, idx) => {
                    const txt = td.innerText.trim();
                    if (txt === '-' || txt === '–' || txt === '—') {
                        td.classList.remove('text-left', 'text-right', 'align-top', 'align-bottom');
                        td.classList.add('text-center', 'align-middle');
                        td.style.textAlign = 'center';
                        td.style.verticalAlign = 'middle';
                        return;
                    }

                    // Format angka ribuan dengan titik pemisah (tanpa Rp) untuk tabel keuangan OPD 05
                    if (idx > 0 && isFinancialTable) {
                        const formatted = formatRupiahNumber(txt);
                        if (formatted !== txt) {
                            td.innerText = formatted;
                        }
                        if (formatted !== '0' && formatted !== '-') {
                            td.classList.remove('text-left', 'text-center');
                            td.classList.add('text-right');
                            td.style.textAlign = 'right';
                            if (isTotalRow) {
                                td.classList.add('font-extrabold');
                            } else {
                                td.classList.add('font-semibold');
                            }
                        } else if (formatted === '0') {
                            td.classList.add('text-center');
                            td.style.textAlign = 'center';
                        }
                    } else if (idx > 0 && /^\d{4,}$/.test(txt.replace(/[.,\s]/g, '')) && !/^(19|20)\d{2}$/.test(txt)) {
                        const formatted = formatRupiahNumber(txt);
                        if (formatted !== txt) {
                            td.innerText = formatted;
                        }
                    }
                });
            });

            // Pada Tabel 1.1.6 pastikan sel nama sungai dan lebar (rowspan) juga di tengah vertikal, serta kolom No selalu bernomor 1 dan 2
            if (currentTableCode === '1.1.6') {
                tableEl.querySelectorAll('tbody td[rowspan]').forEach(td => {
                    td.classList.remove('align-top', 'align-bottom');
                    td.classList.add('align-middle');
                    td.style.verticalAlign = 'middle';
                });

                // Pastikan kolom No selalu 1 dan 2 (tidak pernah hilang atau berubah jadi strip)
                const trs = tableEl.querySelectorAll('tbody tr');
                trs.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 4) {
                        // Baris awal sungai: tds[2] adalah kolom No (1)
                        if (tds[2].innerText.trim() === '-' || tds[2].innerText.trim() === '') {
                            tds[2].innerHTML = '1';
                            tds[2].className = 'py-2 px-2 text-center border border-slate-700 font-bold';
                        }
                    } else if (tds.length >= 2) {
                        // Baris lanjutan sungai: tds[0] adalah kolom No (2)
                        if (tds[0].innerText.trim() === '-' || tds[0].innerText.trim() === '') {
                            tds[0].innerHTML = '2';
                            tds[0].className = 'py-2 px-2 text-center border border-slate-700 font-bold';
                        }
                    }
                });
            }

            // Year status banner & Excel Upload Section Control
            const alertEl = document.getElementById('yearStatusAlert');
            const uploadSection = document.getElementById('excelUploadSection');

            if (hasData) {
                // If data exists: hide upload section by default (can be toggled by button)
                if (uploadSection) uploadSection.classList.add('hidden');
                
                if (alertEl) {
                    const isSaved = localStorage.getItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`) === '1' ||
                                    hasDbSaved ||
                                    ((currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3') && (currentYear.toString() === '2025' || currentYear.toString() === '2026'));
                    const isFromExcel = localStorage.getItem(`simonda_table_source_${currentTableCode}_${currentYear}`) === 'excel';

                    if (!isSaved && localStorage.getItem(`simonda_table_source_${currentTableCode}_${currentYear}`) === 'excel') {
                        saveGeneratedExcel(true);
                    }
                    if (alertEl) {
                        alertEl.innerHTML = '';
                        alertEl.classList.add('hidden');
                    }
                }
            } else {
                // If NO data exists for this year:
                if (isInheritedTemplate) {
                    if (uploadSection) uploadSection.classList.add('hidden');
                    if (alertEl) {
                        alertEl.classList.remove('hidden');
                        alertEl.innerHTML = `
                            <div class="p-3.5 rounded-xl bg-sky-50 border border-sky-200 text-sky-950 text-xs flex flex-wrap items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center space-x-2.5">
                                    <i class="fa-solid fa-lightbulb text-sky-600 text-base shrink-0"></i>
                                    <div>
                                        <span class="font-bold text-sky-900">Format Kolom & Rincian Baris Tahun ${currentYear} Siap Diisi</span>
                                        <p class="text-sky-800 text-[11px] mt-0.5">Struktur kolom ke samping dan nama rincian baris ke bawah telah otomatis disesuaikan dari data yang tersedia. Angka untuk tahun ${currentYear} masih kosong (-). Klik <strong>Edit Tabel</strong> untuk langsung mengisi angka, atau <strong>Import</strong> berkas Excel.</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 shrink-0">
                                    <button onclick="goToEditPage()" class="px-3.5 py-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs transition-colors shadow-2xs cursor-pointer flex items-center space-x-1.5">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Isi Angka Tahun ${currentYear}</span>
                                    </button>
                                </div>
                            </div>
                        `;
                    }
                } else {
                    // SHOW the Excel upload form by default if completely no structure found
                    if (uploadSection) {
                        uploadSection.classList.remove('hidden');
                        const subtitle = document.getElementById('excelUploadSubtitle');
                        if (subtitle) {
                            subtitle.innerHTML = `Tabel ${currentTableCode} <strong>Tahun ${currentYear}</strong> belum memiliki data. Unggah file Excel (.xlsx) untuk membuat tabel secara otomatis.`;
                        }
                    }
                    
                    if (alertEl) {
                        alertEl.classList.remove('hidden');
                        alertEl.innerHTML = `
                            <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-950 text-xs flex flex-wrap items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center space-x-2.5">
                                    <i class="fa-solid fa-circle-exclamation text-amber-600 text-base shrink-0"></i>
                                    <div>
                                        <span class="font-bold text-amber-900">Tahun ${currentYear} Belum Memiliki Data</span>
                                        <p class="text-amber-800 text-[11px] mt-0.5">Gunakan <strong>Form Import Excel</strong> di bawah untuk men-generate data tabel otomatis, atau klik Edit Tabel untuk mengisi manual.</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 shrink-0">
                                    ${currentTableCode === '1.1.6' && currentYear.toString() !== '2024' ? `
                                        <button onclick="changeTableYear('2024')" class="px-3.5 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition-colors shadow-2xs cursor-pointer flex items-center space-x-1.5">
                                            <i class="fa-solid fa-calendar-check text-[11px]"></i>
                                            <span>Lihat Data Tahun 2024</span>
                                        </button>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    }
                }
            }

            // Toggle header "Hapus Excel" button (hanya tampil saat sedang mereview berkas Excel sebelum disimpan)
            const btnDeleteExcel = document.getElementById('btnDeleteExcelData');
            const isSaved = localStorage.getItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`) === '1' || hasDbSaved;
            const hasCustomExcelData = localStorage.getItem(`simonda_table_html_${currentTableCode}_${currentYear}`) !== null &&
                                      localStorage.getItem(`simonda_table_source_${currentTableCode}_${currentYear}`) === 'excel';
            if (btnDeleteExcel) {
                if (hasCustomExcelData && !isSaved) {
                    btnDeleteExcel.classList.remove('hidden');
                } else {
                    btnDeleteExcel.classList.add('hidden');
                }
            }
        }

        function cleanGhostColumns(table) {
            if (!table) return;
            // JANGAN PERNAH potong kolom pada Tabel 1.1.6, 8.1.x, atau tabel multi-tahun
            const schema = (typeof tableSchemas !== 'undefined') ? tableSchemas[currentTableCode] : null;
            if (schema && (schema.isMultiYear || schema.isExcludeSelectedYear)) return;
            if (currentTableCode === '1.1.6' || currentTableCode.startsWith('8.1')) return;

            const bodyRows = table.querySelectorAll('tbody tr');
            if (bodyRows.length === 0) return;

            // Jangan pernah hapus jika jumlah kolom data di body sama dengan atau kurang dari kolom di header
            const theadThs = table.querySelectorAll('thead tr:last-child th');
            if (theadThs.length > 0 && bodyRows[0] && bodyRows[0].querySelectorAll('td').length <= theadThs.length) {
                return;
            }

            // Check if every row in tbody ends with an empty cell or '-'
            let allEndWithHyphenOrEmpty = true;
            let rowCount = 0;

            bodyRows.forEach(tr => {
                const tds = tr.querySelectorAll('td');
                if (tds.length >= 2) {
                    rowCount++;
                    const lastText = tds[tds.length - 1].innerText.trim();
                    if (lastText !== '-' && lastText !== '') {
                        allEndWithHyphenOrEmpty = false;
                    }
                }
            });

            if (rowCount > 0 && allEndWithHyphenOrEmpty) {
                // Remove the last td from each tbody row
                bodyRows.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 2) {
                        tds[tds.length - 1].remove();
                    }
                });

                // In thead, clean up any trailing empty th or sync column count
                const theadRows = table.querySelectorAll('thead tr');
                theadRows.forEach(tr => {
                    const ths = tr.querySelectorAll('th');
                    if (ths.length > 0) {
                        const lastTh = ths[ths.length - 1];
                        const txt = lastTh.innerText.trim();
                        if (txt === '' || txt === '-' || txt.startsWith('Kolom')) {
                            lastTh.remove();
                        }
                    }
                });

                // Update storage if this was saved html
                const savedKey = `simonda_table_html_${currentTableCode}_${currentYear}`;
                if (localStorage.getItem(savedKey)) {
                    localStorage.setItem(savedKey, table.innerHTML);
                }
            }
        }

        function cleanGhostRows(table) {
            if (!table) return;
            const tbody = table.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            let removedAny = false;
            rows.forEach(tr => {
                const tds = Array.from(tr.querySelectorAll('td'));
                if (tds.length === 0) return;
                const hasMeaningful = tds.some(td => {
                    const txt = td.innerText.trim();
                    return txt !== '' && txt !== '-' && txt !== '–' && txt !== '—';
                });
                if (!hasMeaningful) {
                    tr.remove();
                    removedAny = true;
                }
            });

            if (removedAny) {
                const savedKey = `simonda_table_html_${currentTableCode}_${currentYear}`;
                if (localStorage.getItem(savedKey)) {
                    localStorage.setItem(savedKey, table.innerHTML);
                }
            }
        }

        async function deleteBottomRowView() {
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            const tbody = tableEl.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            if (rows.length <= 1) {
                alert('Tabel minimal harus memiliki 1 baris data.');
                return;
            }
            if (!confirm('Apakah Anda yakin ingin menghapus baris paling bawah dari tabel ini?')) {
                return;
            }

            const lastRow = rows[rows.length - 1];
            deleteRowElementView(lastRow);

            localStorage.setItem(`simonda_table_html_${currentTableCode}_${currentYear}`, tableEl.innerHTML);
            localStorage.setItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '1');
            await saveGeneratedExcel(true, '');
            showToast('🗑️ Baris paling bawah berhasil dihapus!');
        }

        function deleteRowElementView(tr) {
            if (!tr) return;
            const tbody = tr.parentElement;
            if (!tbody) return;
            const allRows = Array.from(tbody.querySelectorAll('tr'));
            const rIdx = allRows.indexOf(tr);
            if (rIdx === -1) return;

            const rowspanCells = Array.from(tr.querySelectorAll('td[rowspan]')).filter(td => {
                return (parseInt(td.getAttribute('rowspan') || '1', 10)) > 1;
            });

            if (rowspanCells.length > 0) {
                const nextTr = allRows[rIdx + 1];
                if (nextTr) {
                    rowspanCells.reverse().forEach(cell => {
                        const curSpan = parseInt(cell.getAttribute('rowspan'), 10);
                        if (curSpan > 2) {
                            cell.setAttribute('rowspan', curSpan - 1);
                        } else {
                            cell.removeAttribute('rowspan');
                        }
                        nextTr.insertBefore(cell, nextTr.firstChild);
                    });
                }
            } else {
                for (let i = rIdx - 1; i >= 0; i--) {
                    const prevTr = allRows[i];
                    const dist = rIdx - i;
                    const parentRowspanCells = Array.from(prevTr.querySelectorAll('td[rowspan]')).filter(td => {
                        const sp = parseInt(td.getAttribute('rowspan') || '1', 10);
                        return sp > dist;
                    });
                    if (parentRowspanCells.length > 0) {
                        parentRowspanCells.forEach(cell => {
                            const sp = parseInt(cell.getAttribute('rowspan') || '1', 10);
                            if (sp > 2) {
                                cell.setAttribute('rowspan', sp - 1);
                            } else {
                                cell.removeAttribute('rowspan');
                            }
                        });
                        break;
                    }
                }
            }

            tr.remove();
        }

        async function changeTableYear(newYear) {
            currentYear = newYear.toString();
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('year', currentYear);
            window.history.pushState({}, '', newUrl);

            const selectYearEl = document.getElementById('yearSwitcher');
            if (selectYearEl) selectYearEl.value = currentYear;

            // Ambil data terbaru dari database MySQL untuk tahun ini
            try {
                const res = await fetch(`"dummy"?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`);
                const dataRes = await res.json();
                if (dataRes.success) {
                    if (dataRes.dataStore) {
                        Object.assign(serverDbDataStore, dataRes.dataStore);
                    }
                    if (dataRes.metadata !== undefined) {
                        serverDbMetadata = dataRes.metadata;
                    }
                    if (dataRes.fallbackMetadata !== undefined) {
                        serverDbFallbackMetadata = dataRes.fallbackMetadata;
                    }
                }
            } catch(e) {}

            renderTablePage();
            showToast(`Tahun data diubah ke ${currentYear}`);
        }

        function goToEditPage() {
            let url = `"dummy"?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`;
            if (currentType) url += `&type=${currentType}`;
            const curTitle = document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText : '';
            const curTitleEn = document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText : '';
            if (curTitle) url += `&title=${encodeURIComponent(curTitle)}`;
            if (curTitleEn) url += `&title_en=${encodeURIComponent(curTitleEn)}`;
            window.location.href = url;
        }

        // Helper to get cell text with proper linebreaks for bilingual headers
        function getCellText(col) {
            const ta = col.querySelector('.pma-textarea');
            if (ta) return ta.value.trim();

            const divs = col.querySelectorAll('div');
            if (divs.length >= 2) {
                const lines = [];
                divs.forEach(d => {
                    const txt = d.innerText.trim();
                    if (txt) lines.push(txt);
                });
                if (lines.length > 0) return lines.join('\n');
            }

            return col.innerText.replace(/\r?\n|\r/g, ' ').trim();
        }

        // Format angka ribuan dengan titik pemisah (tanpa Rp) untuk tabel keuangan
        function formatRupiahNumber(val) {
            if (val === null || val === undefined) return val;
            let str = val.toString().trim();
            if (!str || str === '-' || str === '–' || str === '—') return str;
            if (/[a-zA-Z]/.test(str)) return str;
            if (/^\(\s*\d+\s*\)$/.test(str)) return str;
            if (/^(19|20)\d{2}$/.test(str)) return str;
            if (/^\d{1,3}(\.\d{3})+(,\d+)?$/.test(str)) return str;

            if (/^\d{1,3}(,\d{3})+(\.\d+)?$/.test(str)) {
                const parts = str.split('.');
                const intPart = parts[0].replace(/,/g, '.');
                const decPart = parts.length > 1 ? ',' + parts[1] : '';
                return intPart + decPart;
            }

            let intPart = str;
            let decPart = '';

            if (str.includes(',')) {
                const parts = str.split(',');
                intPart = parts[0].replace(/\./g, '');
                decPart = ',' + parts[1];
            } else if (str.includes('.')) {
                const parts = str.split('.');
                if (parts.length === 2) {
                    if (parts[1].length !== 3 || parts[0].length > 3) {
                        intPart = parts[0];
                        decPart = ',' + parts[1];
                    } else {
                        return str;
                    }
                } else if (parts.length > 2) {
                    return str;
                }
            }

            const isNegative = intPart.startsWith('-');
            const cleanDigits = intPart.replace(/[^\d]/g, '');
            if (!cleanDigits) return str;

            const formattedInt = cleanDigits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return (isNegative ? '-' : '') + formattedInt + decPart;
        }

        // ==========================================
        // EXPORT & SPREADSHEET VISUALIZER SUITE
        // ==========================================

        function openSpreadsheetModal() {
            openGoogleSpreadsheetOnline();
        }
        function closeSpreadsheetModal() {}

        /**
         * Generate Rich HTML Table with exact BPS colors for full-fidelity clipboard copying
         */
        function generateRichSpreadsheetHtml() {
            const tableEl = document.getElementById('dataDisplayTable');
            const opdName = getAgencyName(currentOpdCode);
            const titleId = document.getElementById('metaTableTitleId').innerText;
            const titleEn = document.getElementById('metaTableTitleEn').innerText;
            const source = document.getElementById('tableSourceContent').innerText.replace(/<[^>]*>?/gm, '');

            let maxCols = 1;
            const allTrs = tableEl.querySelectorAll('tr');
            allTrs.forEach(tr => {
                let colSum = 0;
                tr.querySelectorAll('th, td').forEach(c => {
                    colSum += parseInt(c.getAttribute('colspan') || 1, 10);
                });
                if (colSum > maxCols) maxCols = colSum;
            });

            let html = `
                <table style="border-collapse: collapse; font-family: Calibri, 'Segoe UI', Arial, sans-serif; font-size: 11pt; color: #000000; width: 100%;">
                    <tr>
                        <td colspan="${maxCols}" style="font-weight: bold; font-size: 13pt; color: #1e293b; padding: 6px 0;">BADAN PUSAT STATISTIK KOTA BUKITTINGGI</td>
                    </tr>
                    <tr>
                        <td colspan="${maxCols}" style="font-weight: bold; font-size: 12pt; color: #0f172a; padding: 4px 0;">TABEL ${currentTableCode} (${currentYear}): ${titleId}</td>
                    </tr>
                    <tr>
                        <td colspan="${maxCols}" style="font-style: italic; color: #475569; padding: 2px 0 8px 0;">${titleEn}</td>
                    </tr>
                    <tr>
                        <td colspan="${maxCols}" style="font-size: 10pt; color: #334155; padding-bottom: 10px;">Instansi / OPD: <b>${opdName}</b></td>
                    </tr>
            `;

            const theadRows = tableEl.querySelectorAll('thead tr');
            theadRows.forEach((tr, trIdx) => {
                html += '<tr>';
                tr.querySelectorAll('th, td').forEach(c => {
                    const colspan = c.getAttribute('colspan') || 1;
                    const rowspan = c.getAttribute('rowspan') || 1;
                    const isOrange = trIdx === 0;
                    const bgColor = isOrange ? '#f95a00' : '#fed7aa';
                    const textColor = isOrange ? '#ffffff' : '#0f172a';
                    const text = getCellText(c);

                    html += `<th colspan="${colspan}" rowspan="${rowspan}" style="background-color: ${bgColor}; color: ${textColor}; font-weight: bold; text-align: center; vertical-align: middle; border: 1px solid #334155; padding: 8px 12px; font-family: Calibri, Arial, sans-serif;">${text}</th>`;
                });
                html += '</tr>';
            });

            const tbodyRows = tableEl.querySelectorAll('tbody tr');
            tbodyRows.forEach(tr => {
                html += '<tr>';
                tr.querySelectorAll('th, td').forEach(c => {
                    const colspan = c.getAttribute('colspan') || 1;
                    const rowspan = c.getAttribute('rowspan') || 1;
                    const text = getCellText(c);
                    const isCenter = c.classList.contains('text-center');
                    const isBold = c.classList.contains('font-semibold') || c.classList.contains('font-bold');
                    const align = isCenter ? 'center' : 'left';
                    const weight = isBold ? 'bold' : 'normal';

                    html += `<td colspan="${colspan}" rowspan="${rowspan}" style="background-color: #fef9c3; color: #0f172a; font-weight: ${weight}; text-align: ${align}; vertical-align: top; border: 1px solid #334155; padding: 6px 10px; font-family: Calibri, Arial, sans-serif;">${text}</td>`;
                });
                html += '</tr>';
            });

            html += `
                    <tr>
                        <td colspan="${maxCols}" style="padding-top: 8px; font-size: 10pt; color: #475569; font-family: Calibri, Arial, sans-serif;"><b>Sumber / Source:</b> <i>${source}</i></td>
                    </tr>
                </table>
            `;

            return html;
        }

        /**
         * Generate TSV for fallback / plain-text clipboard
         */
        function generateTableTSV() {
            const tableEl = document.getElementById('dataDisplayTable');
            const titleId = document.getElementById('metaTableTitleId').innerText;
            const titleEn = document.getElementById('metaTableTitleEn').innerText;
            const source = document.getElementById('tableSourceContent').innerText.replace(/<[^>]*>?/gm, '');
            const opdName = getAgencyName(currentOpdCode);

            let tsv = `BADAN PUSAT STATISTIK KOTA BUKITTINGGI\n`;
            tsv += `TABEL ${currentTableCode} (${currentYear})\n`;
            tsv += `${titleId}\n`;
            tsv += `${titleEn}\n`;
            tsv += `Instansi / OPD: ${opdName}\n\n`;

            const rows = tableEl.querySelectorAll('tr');
            rows.forEach(row => {
                const cols = row.querySelectorAll('th, td');
                const rowData = [];
                cols.forEach(col => {
                    rowData.push(getCellText(col));
                });
                tsv += rowData.join('\t') + '\n';
            });

            tsv += `\nSumber / Source: ${source}\n`;
            return tsv;
        }

        /**
         * Copy Rich Formatted HTML + Plain TSV to Clipboard (100% browser compatible)
         */
        function copySpreadsheetRichHtml() {
            const html = generateRichSpreadsheetHtml();
            const tsv = generateTableTSV();

            let copied = false;
            if (navigator.clipboard && window.ClipboardItem) {
                try {
                    const htmlBlob = new Blob([html], { type: 'text/html' });
                    const textBlob = new Blob([tsv], { type: 'text/plain' });
                    const item = new ClipboardItem({
                        'text/html': htmlBlob,
                        'text/plain': textBlob
                    });

                    navigator.clipboard.write([item]).then(() => {
                        showToast('📋 Format tabel & warna lengkap BPS disalin ke clipboard!');
                    }).catch(() => {
                        fallbackRichCopy(html, tsv);
                    });
                    copied = true;
                } catch (e) {
                    copied = false;
                }
            }

            if (!copied) {
                fallbackRichCopy(html, tsv);
            }
        }

        function fallbackRichCopy(html, text) {
            const container = document.createElement('div');
            container.innerHTML = html;
            container.style.position = 'fixed';
            container.style.left = '-9999px';
            container.style.top = '0';
            container.style.opacity = '0';
            container.contentEditable = 'true';
            document.body.appendChild(container);

            const selection = window.getSelection();
            const range = document.createRange();
            range.selectNodeContents(container);
            selection.removeAllRanges();
            selection.addRange(range);

            function listener(e) {
                e.clipboardData.setData('text/html', html);
                e.clipboardData.setData('text/plain', text);
                e.preventDefault();
            }
            document.addEventListener('copy', listener);
            try {
                document.execCommand('copy');
            } catch (err) {
                console.error('execCommand error:', err);
            }
            document.removeEventListener('copy', listener);
            selection.removeAllRanges();
            document.body.removeChild(container);
            showToast('📋 Format tabel & warna lengkap BPS disalin ke clipboard!');
        }

        // ==========================================
        // EXCEL IMPORT & AUTO-GENERATOR SUITE
        // ==========================================

        function toggleExcelUploadForm(forceState) {
            const section = document.getElementById('excelUploadSection');
            if (!section) return;
            if (typeof forceState === 'boolean') {
                if (forceState) section.classList.remove('hidden');
                else section.classList.add('hidden');
            } else {
                section.classList.toggle('hidden');
            }
            if (!section.classList.contains('hidden')) {
                section.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function downloadExcelTemplate() {
            try {
                if (typeof XLSX === 'undefined') {
                    alert('Pustaka Excel belum siap. Silakan coba sesaat lagi.');
                    return;
                }

            const yr = parseInt(currentYear) || 2025;
            const opdName = getAgencyName(currentOpdCode);
            const catInfo = (typeof getCatalogTableInfo === 'function') 
                ? getCatalogTableInfo(currentTableCode, currentOpdCode, currentType) 
                : null;
            let titleId = (document.getElementById('metaTableTitleId') && document.getElementById('metaTableTitleId').innerText.trim())
                ? document.getElementById('metaTableTitleId').innerText.trim()
                : (catInfo && catInfo.title ? catInfo.title : `Tabel ${currentTableCode}`);
            let titleEn = (document.getElementById('metaTableTitleEn') && document.getElementById('metaTableTitleEn').innerText.trim())
                ? document.getElementById('metaTableTitleEn').innerText.trim()
                : (catInfo && catInfo.titleEn ? catInfo.titleEn : (catInfo && catInfo.title ? catInfo.title : `Table ${currentTableCode}`));

            // Pastikan titleId adalah bahasa Indonesia dan titleEn adalah bahasa Inggris
            const idHasEnglish = /\b(Actual|Number|Length|Population|Government|Expenditures|Revenues|Percentage|District|Kind of)\b/i.test(titleId);
            const enHasIndo = /\b(Realisasi|Jumlah|Panjang|Penduduk|Pemerintah|Belanja|Pendapatan|Menurut|Jenis|Kecamatan|Banyaknya)\b/i.test(titleEn);
            if (idHasEnglish && enHasIndo) {
                const temp = titleId;
                titleId = titleEn;
                titleEn = temp;
            }
            const pRange = get5YearPeriod(yr);
            const roadTemplateRange = pRange.label;
            if (currentTableCode === '8.1.1') {
                titleId = `Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi (km), ${roadTemplateRange}`;
                titleEn = `Length of Road by Level of Government Authority in Bukittinggi Municipality (km), ${roadTemplateRange}`;
            } else if (currentTableCode === '8.1.2') {
                titleId = `Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi (km), ${roadTemplateRange}`;
                titleEn = `Length of Roads by Type of Road Surface in Bukittinggi Municipality (km), ${roadTemplateRange}`;
            } else if (currentTableCode === '8.1.3') {
                titleId = `Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km), ${roadTemplateRange}`;
                titleEn = `Length of Road by Condition of Road in Bukittinggi Municipality (km), ${roadTemplateRange}`;
            } else if (currentTableCode === '8.1.4') {
                titleId = `Banyak dan Panjang Jembatan, Panjang Trotoar Kota Bukittinggi, ${roadTemplateRange}`;
                titleEn = `Number and Length of Bridge, Length of Sidewalk in Bukittinggi, ${roadTemplateRange}`;
            } else if (currentTableCode === '8.1.5') {
                titleId = `Panjang Gorong–Gorong dan Panjang Drainase Kota Bukittinggi, ${roadTemplateRange}`;
                titleEn = `Length of Culvert and Length of Drainage in Bukittinggi, ${roadTemplateRange}`;
            } else if (currentTableCode === '1.1.10') {
                titleId = `Jumlah IMB/PBG yang Dikeluarkan Dinas Penanaman Modal PTSP Kota Bukittinggi Menurut Klasifikasinya di Kota Bukittinggi, ${roadTemplateRange}`;
                titleEn = `Number of Building Approvals (IMB/PBG) Issued by Investment and One-Stop Integrated Services of Bukittinggi Municipality by Classification, ${roadTemplateRange}`;
            } else if (currentTableCode === '2.2.5') {
                titleId = `Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi, ${roadTemplateRange}`;
                titleEn = `Decrees and Results of Regional House of Representatives Working Meetings in Bukittinggi Municipality, ${roadTemplateRange}`;
            } else if (currentTableCode === '2.3.1') {
                titleId = `Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan, Jenis ASN, dan Jenis Kelamin (orang), ${yr}`;
                titleEn = `Number of State Civil Apparatus (ASN) of Bukittinggi Municipal Government by Occupation, Type of ASN, and Sex (people), ${yr}`;
            } else if (currentTableCode === '2.3.2') {
                titleId = `Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin (orang), ${yr}`;
                titleEn = `Number of Civil Servant of Bukittinggi Municipal Government by Educational Level, Type of ASN, and Sex (people), ${yr}`;
            } else if (currentTableCode === '2.3.3') {
                titleId = `Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang), ${yr}`;
                titleEn = `Number of Bukittinggi Municipality Government’s Civil Servants by Hierarchy and Sex (people), ${yr}`;
            } else if (currentTableCode === '2.3.4') {
                titleId = `Jumlah Pegawai Pemerintah dengan Perjanjian Kerja Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang), ${yr}`;
                titleEn = `Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people), ${yr}`;
            } else if (currentTableCode === '2.3.5') {
                titleId = `Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi, ${yr}`;
                titleEn = `Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement, ${yr}`;
            }
            const sourceEl = document.getElementById('tableSourceContent');
            const cleanSource = sourceEl ? sourceEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : `${opdName} Kota Bukittinggi`;
            const noteEl = document.getElementById('tableNoteContent');
            const noteRow = document.getElementById('tableNoteRow');
            const cleanNote = (noteEl && noteRow && !noteRow.classList.contains('hidden'))
                ? noteEl.innerText.replace(/<[^>]*>?/gm, '').trim()
                : '';

            // BPS Excel Palette & Styles
            const borderThin = {
                top: { style: 'thin', color: { rgb: '334155' } },
                bottom: { style: 'thin', color: { rgb: '334155' } },
                left: { style: 'thin', color: { rgb: '334155' } },
                right: { style: 'thin', color: { rgb: '334155' } }
            };

            const headerOrangeStyle = {
                fill: { fgColor: { rgb: 'F95A00' } },
                font: { name: 'Calibri', sz: 9.5, bold: true, color: { rgb: 'FFFFFF' } },
                alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                border: borderThin
            };

            const headerPeachStyle = {
                fill: { fgColor: { rgb: 'FED7AA' } },
                font: { name: 'Calibri', sz: 9, bold: true, color: { rgb: '000000' } },
                alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                border: borderThin
            };

            const dataCellStyle = {
                fill: { fgColor: { rgb: 'FFFFFF' } },
                font: { name: 'Calibri', sz: 9.5, color: { rgb: '000000' } },
                alignment: { horizontal: 'left', vertical: 'center', wrapText: true },
                border: borderThin
            };
            const dataLeftStyle = dataCellStyle;

            const dataCenterStyle = {
                fill: { fgColor: { rgb: 'FFFFFF' } },
                font: { name: 'Calibri', sz: 9.5, color: { rgb: '000000' } },
                alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                border: borderThin
            };

            const totalRowStyle = {
                fill: { fgColor: { rgb: 'FED7AA' } },
                font: { name: 'Calibri', sz: 9.5, bold: true, color: { rgb: '000000' } },
                alignment: { horizontal: 'left', vertical: 'center', wrapText: true },
                border: borderThin
            };

            const totalCenterStyle = {
                fill: { fgColor: { rgb: 'FED7AA' } },
                font: { name: 'Calibri', sz: 9.5, bold: true, color: { rgb: '000000' } },
                alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                border: borderThin
            };

            const wb = XLSX.utils.book_new();
            const ws = {};
            const merges = [];

            function setCell(row, col, value, style) {
                const cellRef = XLSX.utils.encode_cell({ r: row, c: col });
                ws[cellRef] = {
                    v: value,
                    t: typeof value === 'number' ? 'n' : 's',
                    s: style || {}
                };
            }

            let r = 0;

            // 1. Block Judul Publikasi Resmi BPS (A1:B1, A2:B2)
            setCell(r, 0, `Tabel ${currentTableCode}`, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
            setCell(r, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
            r++;
            setCell(r, 0, 'Table', { font: { name: 'Calibri', sz: 10, bold: true, italic: true, color: { rgb: '000000' } } });
            setCell(r, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });
            r += 2; // Baris 3 kosong, tabel data mulai di r

            const tableStartRow = r;
            let maxCol = 2;

            // 2. DETEKSI STRUKTUR TABEL, NAMA ISIAN KOLOM, DAN DATA HISTORIS
            // Deteksi apakah di layar saat ini (#dataDisplayTable) sudah masuk data
            const tableEl = document.getElementById('dataDisplayTable');
            let hasValidDomRows = false;
            if (tableEl) {
                const trs = tableEl.querySelectorAll('tbody tr');
                if (trs.length > 0 && !tableEl.innerText.includes('Belum ada data untuk tabel ini')) {
                    hasValidDomRows = true;
                }
            }

            // Jika tahun yang sedang dilihat belum ada data, deteksi data dari tahun sebelum atau sesudahnya
            // dari localStorage, database serverDbMetadata, atau tableSchemas
            let sourceTableHtml = null;
            if (hasValidDomRows) {
                sourceTableHtml = tableEl.innerHTML;
            } else {
                const yearsToCheck = [yr, yr - 1, yr - 2, yr - 3, yr - 4, yr + 1, yr + 2, 2025, 2024, 2023, 2022, 2021];
                for (let checkY of yearsToCheck) {
                    const savedKey = `simonda_table_html_${currentTableCode}_${checkY}`;
                    const savedHtml = localStorage.getItem(savedKey);
                    if (savedHtml && !savedHtml.includes('Belum ada data untuk tabel ini')) {
                        sourceTableHtml = savedHtml;
                        break;
                    }
                }

                if (!sourceTableHtml && typeof serverDbMetadata !== 'undefined' && serverDbMetadata && serverDbMetadata.table_html && !serverDbMetadata.table_html.includes('Belum ada data untuk tabel ini')) {
                    sourceTableHtml = serverDbMetadata.table_html;
                }

                if (!sourceTableHtml && tableSchemas[currentTableCode]) {
                    sourceTableHtml = tableSchemas[currentTableCode].render(currentYear);
                }
            }

            if (sourceTableHtml && currentTableCode === '2.4.2') {
                sourceTableHtml = sourceTableHtml.replace(/Jenis Pendapatan/gi, 'Jenis Belanja');
                sourceTableHtml = sourceTableHtml.replace(/Kind of Revenues/gi, 'Kind of Expenditures');
            }

            // 3. GENERASI TEMPLATE RESMI BERDASARKAN HASIL DETEKSI
            if (currentTableCode === '1.1.6') {
                // Header Tabel 1.1.6: Standar 4 Kolom BPS
                setCell(r, 0, 'Nama Sungai (Batang)/Name of The River', headerOrangeStyle);
                setCell(r, 1, 'Lebar/Width (M)', headerOrangeStyle);
                setCell(r, 2, 'Kecamatan yang Dilalui/District Its Pass', headerOrangeStyle);
                setCell(r, 3, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 2 }, e: { r: r, c: 3 } });
                r++;

                setCell(r, 0, '(1)', headerPeachStyle);
                setCell(r, 1, '(2)', headerPeachStyle);
                setCell(r, 2, 'No', headerPeachStyle);
                setCell(r, 3, '(3)', headerPeachStyle);
                r++;

                // Deteksi nama sungai dan rincian kecamatan yang sudah masuk ke dalam tabel
                let riverGroups = [];
                let activeRiver = null;

                if (sourceTableHtml) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = (sourceTableHtml && !sourceTableHtml.includes('<table')) ? `<table>${sourceTableHtml}</table>` : (sourceTableHtml || '');
                    const bodyRows = tempDiv.querySelectorAll('tbody tr');

                    bodyRows.forEach(tr => {
                        const tds = tr.querySelectorAll('td');
                        if (tds.length === 0) return;
                        if (tds.length >= 3) {
                            const name = tds[0].innerText.trim();
                            const width = tds[1].innerText.trim();
                            let num = '1';
                            let distName = '';
                            if (tds.length >= 4) {
                                num = tds[2].innerText.trim();
                                distName = tds[3].innerText.trim();
                            } else {
                                const raw = tds[2].innerText.trim();
                                const m = raw.match(/^(\d+)\.?\s*(.*)$/);
                                num = m ? m[1] : '1';
                                distName = m ? m[2] : raw;
                            }
                            activeRiver = { name: name, width: width, subdistricts: [{ num: num, name: distName }] };
                            riverGroups.push(activeRiver);
                        } else if (tds.length >= 1 && activeRiver) {
                            let num = (activeRiver.subdistricts.length + 1).toString();
                            let distName = '';
                            if (tds.length >= 2) {
                                num = tds[0].innerText.trim();
                                distName = tds[1].innerText.trim();
                            } else {
                                distName = tds[0].innerText.trim();
                            }
                            activeRiver.subdistricts.push({ num: num, name: distName });
                        }
                    });
                }

                // Pastikan hanya 2 sungai resmi Kota Bukittinggi (Batang Tambuo & Batang Sianok)
                riverGroups = riverGroups.filter(rg => {
                    const n = rg.name.toLowerCase();
                    return n.includes('tambuo') || n.includes('sianok');
                });

                // Jika belum ada data masuk sama sekali, sertakan daftar sungai standar Kota Bukittinggi
                if (riverGroups.length === 0) {
                    riverGroups = [
                        { name: '01. Batang Tambuo', width: '6–10', subdistricts: [{ num: '1', name: 'Aur Birugo Tigo Baleh' }, { num: '2', name: 'Mandiangin Koto Selayan' }] },
                        { name: '02. Batang Sianok', width: '12–15', subdistricts: [{ num: '1', name: 'Aur Birugo Tigo Baleh' }, { num: '2', name: 'Guguk Panjang' }] }
                    ];
                }

                riverGroups.forEach(rg => {
                    const startRow = r;
                    const span = rg.subdistricts.length;
                    rg.subdistricts.forEach((sub, sIdx) => {
                        const curR = startRow + sIdx;
                        setCell(curR, 0, sIdx === 0 ? rg.name : '', dataCellStyle);
                        setCell(curR, 1, sIdx === 0 ? (rg.width || '-') : '', dataCenterStyle);
                        const pNum = parseInt(sub.num, 10);
                        setCell(curR, 2, !isNaN(pNum) ? pNum : (sIdx + 1), dataCenterStyle);
                        setCell(curR, 3, sub.name || '-', dataCellStyle);
                    });
                    if (span > 1) {
                        merges.push({ s: { r: startRow, c: 0 }, e: { r: startRow + span - 1, c: 0 } });
                        merges.push({ s: { r: startRow, c: 1 }, e: { r: startRow + span - 1, c: 1 } });
                    }
                    r += span;
                });
                maxCol = 4;
            } else if (currentTableCode === '8.1.1') {
                // Header Tabel 8.1.1: Standar Multi-Tahun BPS
                const p = get5YearPeriod(yr);
                const years = p.yearsAsc;
                const roadRange = p.label;

                titleId = `Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi (km), ${roadRange}`;
                titleEn = `Length of Road by Level of Government Authority in Bukittinggi Municipality (km), ${roadRange}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1: Oranye BPS
                setCell(r, 0, 'Tingkat Kewenangan Pemerintahan / Level of Government Authority', headerOrangeStyle);
                years.forEach((y, idx) => {
                    setCell(r, idx + 1, y, headerOrangeStyle);
                });
                r++;

                // Header Baris 2: Peach Penomoran Kolom (1) s.d (6)
                setCell(r, 0, '(1)', headerPeachStyle);
                years.forEach((y, idx) => {
                    setCell(r, idx + 1, `(${idx + 2})`, headerPeachStyle);
                });
                r++;

                // Baris-baris Data Resmi BPS Kota Bukittinggi
                const rows = [
                    { label: '1. Negara / State', key: 'negara' },
                    { label: '2. Provinsi / Province', key: 'provinsi' },
                    { label: '3. Kota / Municipality', key: 'kota' },
                    { label: 'Jumlah / Total', key: 'total', isTotal: true }
                ];

                const defaultDataStore = {
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
                    if (defaultDataStore[y] && defaultDataStore[y][key] !== undefined) return defaultDataStore[y][key];
                    if (y < 2020 || y >= 2026) return '-';
                    if (y <= 2022) {
                        return key === 'negara' ? '11,75' : key === 'provinsi' ? '-' : key === 'kota' ? '180,17' : '191,92';
                    }
                    if (y <= 2025) {
                        return key === 'negara' ? '8,18' : key === 'provinsi' ? '-' : key === 'kota' ? '198,3' : '206,48';
                    }
                    return '-';
                };

                rows.forEach(item => {
                    const rowStyle = item.isTotal ? totalRowStyle : dataCellStyle;
                    const centerStyle = item.isTotal ? totalCenterStyle : dataCenterStyle;

                    setCell(r, 0, item.label, rowStyle);
                    years.forEach((y, idx) => {
                        let val = getVal(y, item.key);
                        if (tableEl) {
                            const trs = tableEl.querySelectorAll('tbody tr');
                            trs.forEach(tr => {
                                const firstTd = tr.querySelector('td');
                                if (firstTd) {
                                    const txt = firstTd.innerText.toLowerCase();
                                    const matchKey = item.key === 'total' 
                                        ? (txt.includes('jumlah') || txt.includes('total'))
                                        : txt.includes(item.key);
                                    if (matchKey) {
                                        const tds = tr.querySelectorAll('td');
                                        if (tds[idx + 1]) {
                                            const domVal = tds[idx + 1].innerText.trim();
                                            if (domVal && domVal !== '') val = domVal;
                                        }
                                    }
                                }
                            });
                        }

                        const numVal = parseFloat(String(val).replace(',', '.'));
                        if (!isNaN(numVal) && String(val).trim() !== '-' && !String(val).includes('–')) {
                            setCell(r, idx + 1, numVal, centerStyle);
                        } else {
                            setCell(r, idx + 1, val || '-', centerStyle);
                        }
                    });
                    r++;
                });

                maxCol = 6;
                ws['!cols'] = [
                    { wch: 42 }, // Tingkat Kewenangan Pemerintahan
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 }
                ];
            } else if (currentTableCode === '8.1.2') {
                // Header Tabel 8.1.2: Standar Multi-Tahun BPS
                const p = get5YearPeriod(yr);
                const years = p.yearsAsc;
                const roadRange = p.label;

                titleId = `Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi (km), ${roadRange}`;
                titleEn = `Length of Roads by Type of Road Surface in Bukittinggi Municipality (km), ${roadRange}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1:
                setCell(r, 0, 'Jenis Permukaan Jalan / Type of Road Surface', headerOrangeStyle);
                setCell(r, 1, 'Tahun (km) / Year (km)', headerOrangeStyle);
                for (let c = 2; c <= 5; c++) {
                    setCell(r, c, '', headerOrangeStyle);
                }
                merges.push({ s: { r: r, c: 1 }, e: { r: r, c: 5 } });
                merges.push({ s: { r: r, c: 0 }, e: { r: r + 1, c: 0 } });
                r++;

                // Header Baris 2: Tahun-tahun
                setCell(r, 0, '', headerOrangeStyle);
                years.forEach((y, idx) => {
                    setCell(r, idx + 1, y, headerOrangeStyle);
                });
                r++;

                // Header Baris 3: Peach Penomoran Kolom (1) s.d (6)
                setCell(r, 0, '(1)', headerPeachStyle);
                years.forEach((y, idx) => {
                    setCell(r, idx + 1, `(${idx + 2})`, headerPeachStyle);
                });
                r++;

                // Baris-baris Data Resmi BPS Kota Bukittinggi (Lengkap dengan label isian yang diperlukan)
                const rows = [
                    { label: '1. Aspal / Paved', key: 'aspal' },
                    { label: '2. Kerikil / Gravel', key: 'kerikil' },
                    { label: '3. Tanah / Soil', key: 'tanah' },
                    { label: '4. Lainnya / Others', key: 'lainnya' },
                    { label: 'Jumlah / Total', key: 'total', isTotal: true }
                ];

                const defaultDataStore812 = {
                    2020: { aspal: '180,17', kerikil: '-', tanah: '-',    lainnya: '-', total: '180,17' },
                    2021: { aspal: '180,17', kerikil: '-', tanah: '-',    lainnya: '-', total: '180,17' },
                    2022: { aspal: '180,17', kerikil: '-', tanah: '-',    lainnya: '-', total: '180,17' },
                    2023: { aspal: '192,18', kerikil: '-', tanah: '6,12', lainnya: '-', total: '198,3' },
                    2024: { aspal: '192,18', kerikil: '-', tanah: '6,12', lainnya: '-', total: '198,3' },
                    2025: { aspal: '192,18', kerikil: '-', tanah: '6,12', lainnya: '-', total: '198,3' },
                    2026: { aspal: '-',     kerikil: '-', tanah: '-',    lainnya: '-', total: '-' }
                };

                const getVal812 = (y, key) => {
                    if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                        return serverDbDataStore[y][key];
                    }
                    if (defaultDataStore812[y] && defaultDataStore812[y][key] !== undefined) return defaultDataStore812[y][key];
                    if (y <= 2019 || y >= 2026) return '-';
                    if (y <= 2022) {
                        return key === 'aspal' ? '180,17' : (key === 'total' ? '180,17' : '-');
                    }
                    if (y <= 2025) {
                        return key === 'aspal' ? '192,18' : (key === 'tanah' ? '6,12' : (key === 'total' ? '198,3' : '-'));
                    }
                    return '-';
                };

                rows.forEach(item => {
                    const rowStyle = item.isTotal ? totalRowStyle : dataCellStyle;
                    const centerStyle = item.isTotal ? totalCenterStyle : dataCenterStyle;

                    setCell(r, 0, item.label, rowStyle);
                    years.forEach((y, idx) => {
                        let val = getVal812(y, item.key);
                        if (tableEl) {
                            const trs = tableEl.querySelectorAll('tbody tr');
                            trs.forEach(tr => {
                                const firstTd = tr.querySelector('td');
                                if (firstTd) {
                                    const txt = firstTd.innerText.toLowerCase();
                                    const matchKey = item.key === 'total' 
                                        ? (txt.includes('jumlah') || txt.includes('total'))
                                        : txt.includes(item.key);
                                    if (matchKey) {
                                        const tds = tr.querySelectorAll('td');
                                        if (tds[idx + 1]) {
                                            const domVal = tds[idx + 1].innerText.trim();
                                            if (domVal && domVal !== '') val = domVal;
                                        }
                                    }
                                }
                            });
                        }

                        const numVal = parseFloat(String(val).replace(',', '.'));
                        if (!isNaN(numVal) && String(val).trim() !== '-' && !String(val).includes('–')) {
                            setCell(r, idx + 1, numVal, centerStyle);
                        } else {
                            setCell(r, idx + 1, val || '-', centerStyle);
                        }
                    });
                    r++;
                });

                maxCol = 6;
                ws['!cols'] = [
                    { wch: 38 }, // Jenis Permukaan Jalan
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 }
                ];
            } else if (currentTableCode === '8.1.3') {
                // Header Tabel 8.1.3: Standar Multi-Tahun BPS
                const p = get5YearPeriod(yr);
                const years = p.yearsAsc;
                const roadRange = p.label;

                titleId = `Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km), ${roadRange}`;
                titleEn = `Length of Road by Condition of Road in Bukittinggi Municipality (km), ${roadRange}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1:
                setCell(r, 0, 'Kondisi Jalan / Road Condition', headerOrangeStyle);
                setCell(r, 1, 'Tahun (km) / Year (km)', headerOrangeStyle);
                for (let c = 2; c <= 5; c++) {
                    setCell(r, c, '', headerOrangeStyle);
                }
                merges.push({ s: { r: r, c: 1 }, e: { r: r, c: 5 } });
                merges.push({ s: { r: r, c: 0 }, e: { r: r + 1, c: 0 } });
                r++;

                // Header Baris 2: Tahun-tahun
                setCell(r, 0, '', headerOrangeStyle);
                years.forEach((y, idx) => {
                    setCell(r, idx + 1, y, headerOrangeStyle);
                });
                r++;

                // Header Baris 3: Peach Penomoran Kolom (1) s.d (6)
                setCell(r, 0, '(1)', headerPeachStyle);
                years.forEach((y, idx) => {
                    setCell(r, idx + 1, `(${idx + 2})`, headerPeachStyle);
                });
                r++;

                // Baris-baris Data Resmi BPS Kota Bukittinggi (Lengkap dengan label isian yang diperlukan)
                const rows = [
                    { label: '1. Baik / Good', key: 'baik' },
                    { label: '2. Sedang / Moderate', key: 'sedang' },
                    { label: '3. Rusak / Damage', key: 'rusak' },
                    { label: '4. Rusak Berat / Severely Damage', key: 'rusak_berat' },
                    { label: 'Jumlah / Total', key: 'total', isTotal: true }
                ];

                const defaultDataStore813 = {
                    2021: { baik: '94,34',  sedang: '69,37', rusak: '15,83', rusak_berat: '0,63', total: '180,17' },
                    2022: { baik: '98,56',  sedang: '66,66', rusak: '14,52', rusak_berat: '0,43', total: '180,17' },
                    2023: { baik: '151,56', sedang: '29,78', rusak: '8,44',  rusak_berat: '8,52', total: '198,3' },
                    2024: { baik: '134,92', sedang: '47,02', rusak: '11,01', rusak_berat: '5,35', total: '198,3' },
                    2025: { baik: '131,05', sedang: '49,25', rusak: '12,87', rusak_berat: '5,13', total: '198,3' },
                    2026: { baik: '-',     sedang: '-',     rusak: '-',     rusak_berat: '-',    total: '-' }
                };

                const getVal813 = (y, key) => {
                    if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) {
                        if (serverDbDataStore[y][key] !== undefined) return serverDbDataStore[y][key];
                        if (key === 'rusak' && serverDbDataStore[y]['rusak_ringan'] !== undefined) return serverDbDataStore[y]['rusak_ringan'];
                        if (key === 'rusak_ringan' && serverDbDataStore[y]['rusak'] !== undefined) return serverDbDataStore[y]['rusak'];
                    }
                    if (defaultDataStore813[y]) {
                        if (defaultDataStore813[y][key] !== undefined) return defaultDataStore813[y][key];
                        if (key === 'rusak' && defaultDataStore813[y]['rusak_ringan'] !== undefined) return defaultDataStore813[y]['rusak_ringan'];
                    }
                    if (y <= 2020 || y >= 2026) return '-';
                    return '-';
                };

                rows.forEach(item => {
                    const rowStyle = item.isTotal ? totalRowStyle : dataCellStyle;
                    const centerStyle = item.isTotal ? totalCenterStyle : dataCenterStyle;

                    setCell(r, 0, item.label, rowStyle);
                    years.forEach((y, idx) => {
                        let val = getVal813(y, item.key);
                        if (tableEl) {
                            const trs = tableEl.querySelectorAll('tbody tr');
                            trs.forEach(tr => {
                                const firstTd = tr.querySelector('td');
                                if (firstTd) {
                                    const txt = firstTd.innerText.toLowerCase();
                                    const matchKey = item.key === 'total' 
                                        ? (txt.includes('jumlah') || txt.includes('total'))
                                        : (item.key === 'rusak_berat'
                                            ? (txt.includes('rusak berat') || txt.includes('severely'))
                                            : (item.key === 'rusak'
                                                ? (txt.includes('rusak') && !txt.includes('berat'))
                                                : txt.includes(item.key)));
                                    if (matchKey) {
                                        const tds = tr.querySelectorAll('td');
                                        if (tds[idx + 1]) {
                                            const domVal = tds[idx + 1].innerText.trim();
                                            if (domVal && domVal !== '') val = domVal;
                                        }
                                    }
                                }
                            });
                        }

                        const numVal = parseFloat(String(val).replace(',', '.'));
                        if (!isNaN(numVal) && String(val).trim() !== '-' && !String(val).includes('–')) {
                            setCell(r, idx + 1, numVal, centerStyle);
                        } else {
                            setCell(r, idx + 1, val || '-', centerStyle);
                        }
                    });
                    r++;
                });

                maxCol = 6;
                ws['!cols'] = [
                    { wch: 38 }, // Kondisi Jalan
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 }
                ];
            } else if (currentTableCode === '8.1.4') {
                // Header Tabel 8.1.4: Standar Multi-Tahun BPS (Kecamatan & 5 Tahun Terakhir)
                const p = get5YearPeriod(yr);
                const summaryYears = p.yearsDesc;
                const roadRange = p.label;

                titleId = `Banyak dan Panjang Jembatan, Panjang Trotoar Kota Bukittinggi, ${roadRange}`;
                titleEn = `Number and Length of Bridge, Length of Sidewalk in Bukittinggi, ${roadRange}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1: Oranye BPS
                setCell(r, 0, 'Kecamatan / District', headerOrangeStyle);
                setCell(r, 1, '', headerOrangeStyle);
                setCell(r, 2, 'Jembatan / Bridge', headerOrangeStyle);
                setCell(r, 3, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r + 1, c: 1 } });
                merges.push({ s: { r: r, c: 2 }, e: { r: r, c: 3 } });
                r++;

                // Header Baris 2: Sub-kolom Jembatan
                setCell(r, 0, '', headerOrangeStyle);
                setCell(r, 1, '', headerOrangeStyle);
                setCell(r, 2, 'Banyaknya / Number', headerOrangeStyle);
                setCell(r, 3, 'Panjang / Length', headerOrangeStyle);
                r++;

                // Header Baris 3: Peach Penomoran Kolom
                setCell(r, 0, '(1)', headerPeachStyle);
                setCell(r, 1, '', headerPeachStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                setCell(r, 2, '(2)', headerPeachStyle);
                setCell(r, 3, '(3)', headerPeachStyle);
                r++;

                // Data Kecamatan Default & Nilai dari DOM / Server Data
                const defaultKec = {
                    2025: { gp_u: '11', gp_p: '75,5', mks_u: '17', mks_p: '113', abt_u: '10', abt_p: '108,4' },
                    2024: { gp_u: '11', gp_p: '75,5', mks_u: '9',  mks_p: '75',  abt_u: '17', abt_p: '108,4' },
                    2023: { gp_u: '11', gp_p: '75,5', mks_u: '9',  mks_p: '75',  abt_u: '17', abt_p: '108,4' }
                };
                const defK = defaultKec[yr] || { gp_u: '-', gp_p: '-', mks_u: '-', mks_p: '-', abt_u: '-', abt_p: '-' };
                const storeYr = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                const kecItems = [
                    { label: '01. GUGUK PANJANG', key: 'guguk_panjang', unit: (storeYr['guguk_panjang_unit'] || defK.gp_u), len: (storeYr['guguk_panjang_panjang'] || defK.gp_p) },
                    { label: '02. MANDIANGIN KOTO SELAYAN', key: 'mandiangin_koto_selayan', unit: (storeYr['mandiangin_koto_selayan_unit'] || defK.mks_u), len: (storeYr['mandiangin_koto_selayan_panjang'] || defK.mks_p) },
                    { label: '03. AUR BIRUGO TIGO BALEH', key: 'aur_birugo_tigo_baleh', unit: (storeYr['aur_birugo_tigo_baleh_unit'] || defK.abt_u), len: (storeYr['aur_birugo_tigo_baleh_panjang'] || defK.abt_p) }
                ];

                kecItems.forEach(item => {
                    let valUnit = item.unit;
                    let valLen = item.len;

                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const firstTd = tr.querySelector('td');
                            if (firstTd && firstTd.innerText.toLowerCase().includes(item.label.toLowerCase().slice(4))) {
                                const tds = tr.querySelectorAll('td');
                                if (tds.length >= 3) {
                                    const uVal = tds[tds.length - 2].innerText.trim();
                                    const lVal = tds[tds.length - 1].innerText.trim();
                                    if (uVal && uVal !== '') valUnit = uVal;
                                    if (lVal && lVal !== '') valLen = lVal;
                                }
                            }
                        });
                    }

                    setCell(r, 0, item.label, dataCellStyle);
                    setCell(r, 1, '', dataCellStyle);
                    merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });

                    const numUnit = parseFloat(String(valUnit).replace(',', '.'));
                    setCell(r, 2, (!isNaN(numUnit) && String(valUnit).trim() !== '-' && !String(valUnit).includes('–')) ? numUnit : (valUnit || '-'), dataCenterStyle);

                    const numLen = parseFloat(String(valLen).replace(',', '.'));
                    setCell(r, 3, (!isNaN(numLen) && String(valLen).trim() !== '-' && !String(valLen).includes('–')) ? numLen : (valLen || '-'), dataCenterStyle);
                    r++;
                });

                // Baris Jumlah / Total per 5 tahun terakhir
                const defaultTotals = {
                    2025: { unit: '38', len: '296,9' },
                    2024: { unit: '37', len: '258,9' },
                    2023: { unit: '37', len: '258,9' },
                    2022: { unit: '34', len: '242,12' },
                    2021: { unit: '34', len: '242,12' }
                };

                const startSumRow = r;
                summaryYears.forEach((y, sIdx) => {
                    const sData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) ? serverDbDataStore[y] : {};
                    const defT = defaultTotals[y] || { unit: '-', len: '-' };
                    let valUnit = (sData['total_unit'] !== undefined && sData['total_unit'] !== '') ? sData['total_unit'] : defT.unit;
                    let valLen  = (sData['total_panjang'] !== undefined && sData['total_panjang'] !== '') ? sData['total_panjang'] : defT.len;

                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const tds = tr.querySelectorAll('td');
                            const rowTxt = tr.innerText;
                            if (rowTxt.includes(y.toString()) && (rowTxt.includes('Jumlah') || rowTxt.includes('Total') || tds.length === 3 || tds.length === 4)) {
                                if (tds.length >= 3) {
                                    const uVal = tds[tds.length - 2].innerText.trim();
                                    const lVal = tds[tds.length - 1].innerText.trim();
                                    if (uVal && uVal !== '') valUnit = uVal;
                                    if (lVal && lVal !== '') valLen = lVal;
                                }
                            }
                        });
                    }

                    setCell(r, 0, 'Jumlah / Total', totalRowStyle);
                    setCell(r, 1, y, totalCenterStyle);

                    const numUnit = parseFloat(String(valUnit).replace(',', '.'));
                    setCell(r, 2, (!isNaN(numUnit) && String(valUnit).trim() !== '-' && !String(valUnit).includes('–')) ? numUnit : (valUnit || '-'), totalCenterStyle);

                    const numLen = parseFloat(String(valLen).replace(',', '.'));
                    setCell(r, 3, (!isNaN(numLen) && String(valLen).trim() !== '-' && !String(valLen).includes('–')) ? numLen : (valLen || '-'), totalCenterStyle);
                    r++;
                });

                if (summaryYears.length > 1) {
                    merges.push({ s: { r: startSumRow, c: 0 }, e: { r: startSumRow + summaryYears.length - 1, c: 0 } });
                }

                maxCol = 4;
                ws['!cols'] = [
                    { wch: 32 }, // Kecamatan / Label Jumlah
                    { wch: 14 }, // Tahun
                    { wch: 18 }, // Banyaknya
                    { wch: 18 }  // Panjang
                ];
            } else if (currentTableCode === '8.1.5') {
                // Header Tabel 8.1.5: Standar Multi-Tahun BPS (Kecamatan & 5 Tahun Terakhir)
                const p = get5YearPeriod(yr);
                const summaryYears = p.yearsDesc;
                const roadRange = p.label;

                titleId = `Panjang Gorong–Gorong dan Panjang Drainase Kota Bukittinggi, ${roadRange}`;
                titleEn = `Length of Sewerage and Drainage in Bukittinggi, ${roadRange}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1: Oranye BPS
                setCell(r, 0, 'Kecamatan / District', headerOrangeStyle);
                setCell(r, 1, '', headerOrangeStyle);
                setCell(r, 2, 'Drainase (m) / Drainage', headerOrangeStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                r++;

                // Header Baris 2: Peach Penomoran Kolom
                setCell(r, 0, '(1)', headerPeachStyle);
                setCell(r, 1, '', headerPeachStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                setCell(r, 2, '(2)', headerPeachStyle);
                r++;

                // Data Kecamatan Default & Nilai dari DOM / Server Data
                const defaultKec815 = {
                    2025: { gp: '39013,13', mks: '65078,7', abt: '39474,49' },
                    2024: { gp: '38856,93', mks: '64961,5', abt: '39066,19' }
                };
                const defK = defaultKec815[yr] || { gp: '-', mks: '-', abt: '-' };
                const storeYr = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                const kecItems = [
                    { label: '01. GUGUK PANJANG', key: 'guguk_panjang', val: (storeYr['guguk_panjang'] || defK.gp) },
                    { label: '02. MANDIANGIN KOTO SELAYAN', key: 'mandiangin_koto_selayan', val: (storeYr['mandiangin_koto_selayan'] || defK.mks) },
                    { label: '03. AUR BIRUGO TIGO BALEH', key: 'aur_birugo_tigo_baleh', val: (storeYr['aur_birugo_tigo_baleh'] || defK.abt) }
                ];

                kecItems.forEach(item => {
                    let val = item.val;

                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const firstTd = tr.querySelector('td');
                            if (firstTd && firstTd.innerText.toLowerCase().includes(item.label.toLowerCase().slice(4))) {
                                const tds = tr.querySelectorAll('td');
                                if (tds.length >= 2) {
                                    const dVal = tds[tds.length - 1].innerText.trim();
                                    if (dVal && dVal !== '') val = dVal;
                                }
                            }
                        });
                    }

                    setCell(r, 0, item.label, dataCellStyle);
                    setCell(r, 1, '', dataCellStyle);
                    merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });

                    const numVal = parseFloat(String(val).replace(',', '.'));
                    setCell(r, 2, (!isNaN(numVal) && String(val).trim() !== '-' && !String(val).includes('–')) ? numVal : (val || '-'), dataCenterStyle);
                    r++;
                });

                // Baris Jumlah / Total per 5 tahun terakhir
                const defaultTotals815 = {
                    2025: '143566,32',
                    2024: '142884,62'
                };

                const startSumRow = r;
                summaryYears.forEach((y, sIdx) => {
                    const sData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) ? serverDbDataStore[y] : {};
                    const defT = defaultTotals815[y] || '-';
                    let valTotal = (sData['total'] !== undefined && sData['total'] !== '') ? sData['total'] : defT;

                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const tds = tr.querySelectorAll('td');
                            const rowTxt = tr.innerText;
                            if (rowTxt.includes(y.toString()) && (rowTxt.includes('Jumlah') || rowTxt.includes('Total') || tds.length === 2 || tds.length === 3)) {
                                if (tds.length >= 2) {
                                    const dVal = tds[tds.length - 1].innerText.trim();
                                    if (dVal && dVal !== '') valTotal = dVal;
                                }
                            }
                        });
                    }

                    setCell(r, 0, 'Jumlah / Total', totalRowStyle);
                    setCell(r, 1, y, totalCenterStyle);

                    const numVal = parseFloat(String(valTotal).replace(',', '.'));
                    setCell(r, 2, (!isNaN(numVal) && String(valTotal).trim() !== '-' && !String(valTotal).includes('–')) ? numVal : (valTotal || '-'), totalCenterStyle);
                    r++;
                });

                if (summaryYears.length > 1) {
                    merges.push({ s: { r: startSumRow, c: 0 }, e: { r: startSumRow + summaryYears.length - 1, c: 0 } });
                }

                maxCol = 3;
                ws['!cols'] = [
                    { wch: 32 }, // Kecamatan / Label Jumlah
                    { wch: 14 }, // Tahun
                    { wch: 22 }  // Drainase (m)
                ];
            } else if (currentTableCode === '1.1.10') {
                const tableEl = document.getElementById('tableOPD');
                const p = get5YearPeriod(yr);
                const summaryYears = p.yearsDesc;

                // Judul Kolom (2 baris header + 1 baris penomoran (1)..(5))
                setCell(r, 0, 'Kecamatan / District', headerOrangeStyle);
                setCell(r, 1, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });

                setCell(r, 2, 'Tempat tinggal / Residential', headerOrangeStyle);
                setCell(r, 3, 'Bukan tempat tinggal / Non-residential', headerOrangeStyle);
                setCell(r, 4, 'Campuran / Mixed', headerOrangeStyle);
                setCell(r, 5, 'Jumlah / Total', headerOrangeStyle);
                r++;

                setCell(r, 0, '(1)', headerPeachStyle);
                setCell(r, 1, '', headerPeachStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                setCell(r, 2, '(2)', headerPeachStyle);
                setCell(r, 3, '(3)', headerPeachStyle);
                setCell(r, 4, '(4)', headerPeachStyle);
                setCell(r, 5, '(5)', headerPeachStyle);
                r++;

                // Data Kecamatan Default & Nilai dari DOM / Server Data
                const defaultKec1110 = {
                    2025: {
                        gp:  { tt: '14', btt: '7',  cmp: '2', jml: '23' },
                        mks: { tt: '45', btt: '5',  cmp: '2', jml: '52' },
                        abt: { tt: '23', btt: '1',  cmp: '-', jml: '24' }
                    },
                    2024: {
                        gp:  { tt: '64', btt: '29', cmp: '1', jml: '94' },
                        mks: { tt: '150', btt: '14', cmp: '-', jml: '164' },
                        abt: { tt: '77', btt: '18', cmp: '-', jml: '95' }
                    },
                    2023: {
                        gp:  { tt: '36', btt: '5', cmp: '8', jml: '49' },
                        mks: { tt: '74', btt: '8', cmp: '2', jml: '84' },
                        abt: { tt: '41', btt: '8', cmp: '5', jml: '54' }
                    }
                };
                const defK = defaultKec1110[yr] || {
                    gp:  { tt: '-', btt: '-', cmp: '-', jml: '-' },
                    mks: { tt: '-', btt: '-', cmp: '-', jml: '-' },
                    abt: { tt: '-', btt: '-', cmp: '-', jml: '-' }
                };
                const storeYr = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                const kecItems = [
                    { label: '01. GUGUK PANJANG', match: 'guguk', vals: [
                        storeYr['gp_tt'] || defK.gp.tt,
                        storeYr['gp_btt'] || defK.gp.btt,
                        storeYr['gp_cmp'] || defK.gp.cmp,
                        storeYr['gp_jml'] || defK.gp.jml
                    ]},
                    { label: '02. MANDIANGIN KOTO SELAYAN', match: 'mandiangin', vals: [
                        storeYr['mks_tt'] || defK.mks.tt,
                        storeYr['mks_btt'] || defK.mks.btt,
                        storeYr['mks_cmp'] || defK.mks.cmp,
                        storeYr['mks_jml'] || defK.mks.jml
                    ]},
                    { label: '03. AUR BIRUGO TIGO BALEH', match: 'aur birugo', vals: [
                        storeYr['abt_tt'] || defK.abt.tt,
                        storeYr['abt_btt'] || defK.abt.btt,
                        storeYr['abt_cmp'] || defK.abt.cmp,
                        storeYr['abt_jml'] || defK.abt.jml
                    ]}
                ];

                kecItems.forEach(item => {
                    let vals = [...item.vals];
                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const firstTd = tr.querySelector('td');
                            if (firstTd && firstTd.innerText.toLowerCase().includes(item.match)) {
                                const tds = tr.querySelectorAll('td');
                                if (tds.length >= 5) {
                                    vals[0] = tds[1].innerText.trim() || vals[0];
                                    vals[1] = tds[2].innerText.trim() || vals[1];
                                    vals[2] = tds[3].innerText.trim() || vals[2];
                                    vals[3] = tds[4].innerText.trim() || vals[3];
                                }
                            }
                        });
                    }

                    setCell(r, 0, item.label, dataCellStyle);
                    setCell(r, 1, '', dataCellStyle);
                    merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });

                    for (let c = 0; c < 4; c++) {
                        const val = vals[c];
                        const numVal = parseFloat(String(val).replace(',', '.'));
                        setCell(r, c + 2, (!isNaN(numVal) && String(val).trim() !== '-' && !String(val).includes('–')) ? numVal : (val || '-'), dataCenterStyle);
                    }
                    r++;
                });

                // Baris Jumlah / Total per 5 tahun terakhir
                const defaultTotals1110 = {
                    2025: { tt: '82',  btt: '13', cmp: '4',  jml: '99' },
                    2024: { tt: '291', btt: '61', cmp: '1',  jml: '353' },
                    2023: { tt: '151', btt: '21', cmp: '15', jml: '187' },
                    2022: { tt: '204', btt: '9',  cmp: '15', jml: '228' },
                    2021: { tt: '225', btt: '26', cmp: '14', jml: '265' },
                    2020: { tt: '196', btt: '18', cmp: '14', jml: '228' },
                    2019: { tt: '222', btt: '19', cmp: '32', jml: '273' }
                };

                const startSumRow = r;
                summaryYears.forEach((y, sIdx) => {
                    const sData = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) ? serverDbDataStore[y] : {};
                    const defT = defaultTotals1110[y] || { tt: '-', btt: '-', cmp: '-', jml: '-' };
                    let vals = [
                        (sData['total_tt'] !== undefined && sData['total_tt'] !== '') ? sData['total_tt'] : defT.tt,
                        (sData['total_btt'] !== undefined && sData['total_btt'] !== '') ? sData['total_btt'] : defT.btt,
                        (sData['total_cmp'] !== undefined && sData['total_cmp'] !== '') ? sData['total_cmp'] : defT.cmp,
                        (sData['total_jml'] !== undefined && sData['total_jml'] !== '') ? sData['total_jml'] : defT.jml
                    ];

                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const tds = tr.querySelectorAll('td');
                            const rowTxt = tr.innerText;
                            if (rowTxt.includes(y.toString()) && (rowTxt.includes('Jumlah') || rowTxt.includes('Total') || tds.length === 5 || tds.length === 6)) {
                                if (tds.length === 6) {
                                    vals[0] = tds[2].innerText.trim() || vals[0];
                                    vals[1] = tds[3].innerText.trim() || vals[1];
                                    vals[2] = tds[4].innerText.trim() || vals[2];
                                    vals[3] = tds[5].innerText.trim() || vals[3];
                                } else if (tds.length === 5) {
                                    vals[0] = tds[1].innerText.trim() || vals[0];
                                    vals[1] = tds[2].innerText.trim() || vals[1];
                                    vals[2] = tds[3].innerText.trim() || vals[2];
                                    vals[3] = tds[4].innerText.trim() || vals[3];
                                }
                            }
                        });
                    }

                    setCell(r, 0, 'Jumlah / Total', totalRowStyle);
                    setCell(r, 1, y, totalCenterStyle);

                    for (let c = 0; c < 4; c++) {
                        const val = vals[c];
                        const numVal = parseFloat(String(val).replace(',', '.'));
                        setCell(r, c + 2, (!isNaN(numVal) && String(val).trim() !== '-' && !String(val).includes('–')) ? numVal : (val || '-'), totalCenterStyle);
                    }
                    r++;
                });

                if (summaryYears.length > 1) {
                    merges.push({ s: { r: startSumRow, c: 0 }, e: { r: startSumRow + summaryYears.length - 1, c: 0 } });
                }

                maxCol = 6;
                ws['!cols'] = [
                    { wch: 28 }, // Kecamatan / Label Jumlah
                    { wch: 14 }, // Tahun
                    { wch: 18 }, // Tempat tinggal
                    { wch: 22 }, // Bukan tempat tinggal
                    { wch: 16 }, // Campuran
                    { wch: 16 }  // Jumlah
                ];
            } else if (currentTableCode === '2.2.5') {
                const targetYears = (yr <= 2025) ? [2021, 2022, 2023, 2024, 2025] : [yr - 4, yr - 3, yr - 2, yr - 1, yr];
                const dprdRange = `${targetYears[0]}–${targetYears[4]}`;

                titleId = `Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi, ${dprdRange}`;
                titleEn = `Decrees and Results of Regional House of Representatives Working Meetings in Bukittinggi Municipality, ${dprdRange}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1: Oranye BPS
                setCell(r, 0, 'Jenis Keputusan / Type Of Decision', headerOrangeStyle);
                targetYears.forEach((y, idx) => {
                    setCell(r, idx + 1, y, headerOrangeStyle);
                });
                r++;

                // Header Baris 2: Peach Penomoran Kolom (1) s.d (6)
                setCell(r, 0, '(1)', headerPeachStyle);
                targetYears.forEach((y, idx) => {
                    setCell(r, idx + 1, `(${idx + 2})`, headerPeachStyle);
                });
                r++;

                // 22 Baris Data DPRD resmi (TANPA baris Jumlah / Total)
                const dprdTemplateRows = [
                    { label: '01. Peraturan daerah', key: 'peraturan_daerah' },
                    { label: '02. Keputusan DPRD', key: 'keputusan_dprd' },
                    { label: '03. Keputusan Pimpinan', key: 'keputusan_pimpinan' },
                    { label: '04. Pernyataan', key: 'pernyataan' },
                    { label: '05. Pernyataan Pendapat', key: 'pernyataan_pendapat' },
                    { label: '06. Resolusi', key: 'resolusi' },
                    { label: '07. Dengar Pendapat dengan Pemerintah', key: 'dengar_pendapat' },
                    { label: '08. Rapat Paripurna Terbuka', key: 'paripurna_terbuka' },
                    { label: '09. Rapat Paripurna Istimewa', key: 'paripurna_istimewa' },
                    { label: '10. Rapat Panitia Musyawarah', key: 'panitia_musyawarah' },
                    { label: '11. Rapat Badan Kehormatan', key: 'badan_kehormatan' },
                    { label: '12. Rapat Badan Anggaran', key: 'badan_anggaran' },
                    { label: '13. Rapat Panitia Khusus', key: 'panitia_khusus' },
                    { label: '14. Rapat Gabungan Komisi', key: 'gabungan_komisi' },
                    { label: '15. Rapat Komisi-Komisi', key: 'rapat_komisi' },
                    { label: '16. Rapat Kerja / Kunjungan Kerja / Turun Lapangan Komisi', key: 'turun_lapangan' },
                    { label: '17. Rapat Kerja Komisi ke Luar Daerah', key: 'keluar_daerah' },
                    { label: '18. Rapat Kerja dengan Pemerintah Daerah', key: 'rapat_kerja' },
                    { label: '19. Penyampaian Aspirasi Masyarakat', key: 'penyampaian_aspirasi' },
                    { label: '20. Study Banding', key: 'study_banding' },
                    { label: '21. Reses', key: 'reses' },
                    { label: '22. Kunjungan Kerja Komisi', key: 'kunker_komisi' }
                ];

                const defaultDataStore225 = {
                    2021: { peraturan_daerah: '12', keputusan_dprd: '45', keputusan_pimpinan: '–', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '28', paripurna_istimewa: '9', panitia_musyawarah: '23', badan_kehormatan: '–', badan_anggaran: '22', panitia_khusus: '33', gabungan_komisi: '2', rapat_komisi: '15', turun_lapangan: '–', keluar_daerah: '–', rapat_kerja: '7', penyampaian_aspirasi: '10', study_banding: '7', reses: '3', kunker_komisi: '4' },
                    2022: { peraturan_daerah: '8', keputusan_dprd: '44', keputusan_pimpinan: '1', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '3', paripurna_terbuka: '20', paripurna_istimewa: '5', panitia_musyawarah: '22', badan_kehormatan: '–', badan_anggaran: '31', panitia_khusus: '27', gabungan_komisi: '12', rapat_komisi: '16', turun_lapangan: '–', keluar_daerah: '–', rapat_kerja: '8', penyampaian_aspirasi: '6', study_banding: '25', reses: '3', kunker_komisi: '4' },
                    2023: { peraturan_daerah: '9', keputusan_dprd: '37', keputusan_pimpinan: '3', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '18', paripurna_istimewa: '5', panitia_musyawarah: '18', badan_kehormatan: '1', badan_anggaran: '40', panitia_khusus: '35', gabungan_komisi: '12', rapat_komisi: '28', turun_lapangan: '–', keluar_daerah: '–', rapat_kerja: '1', penyampaian_aspirasi: '8', study_banding: '15', reses: '3', kunker_komisi: '5' },
                    2024: { peraturan_daerah: '8', keputusan_dprd: '34', keputusan_pimpinan: '1', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '19', paripurna_istimewa: '8', panitia_musyawarah: '16', badan_kehormatan: '1', badan_anggaran: '32', panitia_khusus: '40', gabungan_komisi: '30', rapat_komisi: '10', turun_lapangan: '–', keluar_daerah: '–', rapat_kerja: '5', penyampaian_aspirasi: '8', study_banding: '20', reses: '3', kunker_komisi: '4' },
                    2025: { peraturan_daerah: '10', keputusan_dprd: '28', keputusan_pimpinan: '4', pernyataan: '–', pernyataan_pendapat: '–', resolusi: '–', dengar_pendapat: '–', paripurna_terbuka: '27', paripurna_istimewa: '6', panitia_musyawarah: '10', badan_kehormatan: '2', badan_anggaran: '51', panitia_khusus: '41', gabungan_komisi: '17', rapat_komisi: '13', turun_lapangan: '10', keluar_daerah: '–', rapat_kerja: '5', penyampaian_aspirasi: '12', study_banding: '3', reses: '3', kunker_komisi: '3' }
                };

                const getVal225 = (y, key) => {
                    if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y] && serverDbDataStore[y][key] !== undefined) {
                        return serverDbDataStore[y][key];
                    }
                    if (defaultDataStore225[y] && defaultDataStore225[y][key] !== undefined) {
                        return defaultDataStore225[y][key];
                    }
                    return '-';
                };

                dprdTemplateRows.forEach((item, rowIdx) => {
                    setCell(r, 0, item.label, dataCellStyle);

                    targetYears.forEach((y, idx) => {
                        let val = getVal225(y, item.key);

                        if (tableEl) {
                            const trs = tableEl.querySelectorAll('tbody tr');
                            trs.forEach(tr => {
                                const firstTd = tr.querySelector('td');
                                if (firstTd) {
                                    const txt = firstTd.innerText.toLowerCase();
                                    const mNum = txt.match(/^0?(\d+)/);
                                    const isMatch = mNum ? (parseInt(mNum[1], 10) - 1 === rowIdx) : txt.includes(item.key.replace(/_/g, ' '));
                                    if (isMatch) {
                                        const tds = tr.querySelectorAll('td');
                                        if (tds[idx + 1]) {
                                            const domVal = tds[idx + 1].innerText.trim();
                                            if (domVal && domVal !== '') val = domVal;
                                        }
                                    }
                                }
                            });
                        }

                        const numVal = parseFloat(String(val).replace(',', '.'));
                        if (!isNaN(numVal) && String(val).trim() !== '-' && !String(val).includes('–')) {
                            setCell(r, idx + 1, numVal, dataCenterStyle);
                        } else {
                            setCell(r, idx + 1, val || '-', dataCenterStyle);
                        }
                    });
                    r++;
                });

                maxCol = 6;
                ws['!cols'] = [
                    { wch: 48 }, // Jenis Keputusan
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 },
                    { wch: 14 }
                ];
            } else if (currentTableCode === '2.3.1' || currentTableCode === '2.3.2') {
                const is232 = (currentTableCode === '2.3.2');
                titleId = is232
                    ? `Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin (orang), ${yr}`
                    : `Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan, Jenis ASN, dan Jenis Kelamin (orang), ${yr}`;
                titleEn = is232
                    ? `Number of Civil Servant of Bukittinggi Municipal Government by Educational Level, Type of ASN, and Sex, ${yr}`
                    : `Number of State Civil Apparatus (ASN) of Bukittinggi Municipal Government by Occupation, Type of ASN, and Sex, ${yr}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1: Oranye BPS
                setCell(r, 0, is232 ? 'Tingkat Pendidikan / Educational Level' : 'Jabatan / Occupation', headerOrangeStyle);
                setCell(r, 1, 'Pegawai Negeri Sipil / Civil Servant', headerOrangeStyle);
                setCell(r, 2, '', headerOrangeStyle);
                setCell(r, 3, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 1 }, e: { r: r, c: 3 } });

                setCell(r, 4, 'Pegawai Pemerintah dengan Perjanjian Kinerja / Civil servants with employment agreements', headerOrangeStyle);
                setCell(r, 5, '', headerOrangeStyle);
                setCell(r, 6, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 4 }, e: { r: r, c: 6 } });

                setCell(r, 7, 'Aparatur Sipil Negara / State Civil Apparatus', headerOrangeStyle);
                setCell(r, 8, '', headerOrangeStyle);
                setCell(r, 9, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 7 }, e: { r: r, c: 9 } });

                merges.push({ s: { r: r, c: 0 }, e: { r: r + 1, c: 0 } });
                r++;

                // Header Baris 2: Sub-kolom Jenis Kelamin
                setCell(r, 0, '', headerOrangeStyle);
                const subCols = [
                    'Laki–laki / Male', 'Perempuan / Female', 'Jumlah / Total',
                    'Laki–laki / Male', 'Perempuan / Female', 'Jumlah / Total',
                    'Laki–laki / Male', 'Perempuan / Female', 'Jumlah / Total'
                ];
                subCols.forEach((sc, idx) => {
                    setCell(r, idx + 1, sc, headerOrangeStyle);
                });
                r++;

                // Header Baris 3: Peach Penomoran Kolom (1) s.d (10)
                setCell(r, 0, '(1)', headerPeachStyle);
                for (let c = 1; c <= 9; c++) {
                    setCell(r, c, `(${c + 1})`, headerPeachStyle);
                }
                r++;

                const rows231 = [
                    { key: 'jpt_utama',     label: 'Jabatan Pimpinan Tinggi Utama / Senior Executives' },
                    { key: 'jpt_madya',     label: 'Jabatan Pimpinan Tinggi Madya / Middle Executives' },
                    { key: 'jpt_pratama',   label: 'Jabatan Pimpinan Tinggi Pratama / Junior Executives' },
                    { key: 'administrator', label: 'Administrator / Administrator' },
                    { key: 'pengawas',      label: 'Pengawas / Supervisor' },
                    { key: 'eselon5',       label: 'Eselon V / 5th Echelon' },
                    { key: 'dosen',         label: 'Jabatan Fungsional Dosen / Certain Functional Position for Lecturer' },
                    { key: 'guru',          label: 'Jabatan Fungsional Guru / Certain Functional Position for Teacher' },
                    { key: 'medis',         label: 'Jabatan Fungsional Medis / Certain Functional Position for Medical Field' },
                    { key: 'teknis',        label: 'Jabatan Fungsional Teknis / Certain Functional Position for Technical Field' },
                    { key: 'pelaksana',     label: 'Jabatan Fungsional Umum/Pelaksana / General Functional Position' }
                ];

                const rows232 = [
                    { key: 'sd',   label: 'Sekolah Dasar (SD) / Primary School' },
                    { key: 'smp',  label: 'Sekolah Menengah Pertama (SMP) / Junior High School' },
                    { key: 'sma',  label: 'Sekolah Menengah Atas (SMA) / Senior High School' },
                    { key: 'di',   label: 'Diploma I / Akta I / Diploma I/Akta I' },
                    { key: 'dii',  label: 'Diploma II / Akta II / Diploma II/Akta II' },
                    { key: 'diii', label: 'Diploma III / Akta III / Diploma III/Akta III' },
                    { key: 'div',  label: 'Diploma IV / Akta IV / Diploma IV/Akta IV' },
                    { key: 's1',   label: 'S1 / Sarjana / Under Graduate/Bachelor' },
                    { key: 's2',   label: 'S2 / Pasca Sarjana / Graduate' },
                    { key: 's3',   label: 'S3 / Doktor/Ph.D / Post Graduate' }
                ];

                const activeExportRows = is232 ? rows232 : rows231;
                const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                const defaultData231 = {
                    2025: {
                        jpt_utama:     { pns_l: 0,   pns_p: 0,    pppk_l: 0,  pppk_p: 0 },
                        jpt_madya:     { pns_l: 0,   pns_p: 0,    pppk_l: 0,  pppk_p: 0 },
                        jpt_pratama:   { pns_l: 17,  pns_p: 5,    pppk_l: 0,  pppk_p: 0 },
                        administrator: { pns_l: 62,  pns_p: 48,   pppk_l: 0,  pppk_p: 0 },
                        pengawas:      { pns_l: 110, pns_p: 140,  pppk_l: 0,  pppk_p: 0 },
                        eselon5:       { pns_l: 0,   pns_p: 0,    pppk_l: 0,  pppk_p: 0 },
                        dosen:         { pns_l: 0,   pns_p: 0,    pppk_l: 0,  pppk_p: 0 },
                        guru:          { pns_l: 99,  pns_p: 469,  pppk_l: 60, pppk_p: 201 },
                        medis:         { pns_l: 28,  pns_p: 293,  pppk_l: 21, pppk_p: 125 },
                        teknis:        { pns_l: 76,  pns_p: 202,  pppk_l: 70, pppk_p: 38 },
                        pelaksana:     { pns_l: 375, pns_p: 324,  pppk_l: 94, pppk_p: 47 }
                    }
                };
                const defaultData232 = {
                    2025: {
                        sd:    { pns_l: 37,  pns_p: 0,   pppk_l: 4,   pppk_p: 1 },
                        smp:   { pns_l: 19,  pns_p: 2,   pppk_l: 1,   pppk_p: 0 },
                        sma:   { pns_l: 151, pns_p: 53,  pppk_l: 116, pppk_p: 44 },
                        di:    { pns_l: 0,   pns_p: 0,   pppk_l: 0,   pppk_p: 0 },
                        dii:   { pns_l: 5,   pns_p: 4,   pppk_l: 0,   pppk_p: 0 },
                        diii:  { pns_l: 54,  pns_p: 258, pppk_l: 21,  pppk_p: 74 },
                        div:   { pns_l: 37,  pns_p: 30,  pppk_l: 0,   pppk_p: 4 },
                        s1:    { pns_l: 331, pns_p: 939, pppk_l: 101, pppk_p: 288 },
                        s2:    { pns_l: 133, pns_p: 194, pppk_l: 2,   pppk_p: 0 },
                        s3:    { pns_l: 0,   pns_p: 1,   pppk_l: 0,   pppk_p: 0 }
                    },
                    2024: {
                        sd:    { pns_l: 41,  pns_p: 0,   pppk_l: 0,  pppk_p: 0 },
                        smp:   { pns_l: 18,  pns_p: 2,   pppk_l: 0,  pppk_p: 0 },
                        sma:   { pns_l: 171, pns_p: 64,  pppk_l: 34, pppk_p: 5 },
                        di:    { pns_l: 0,   pns_p: 1,   pppk_l: 0,  pppk_p: 0 },
                        dii:   { pns_l: 7,   pns_p: 8,   pppk_l: 0,  pppk_p: 0 },
                        diii:  { pns_l: 58,  pns_p: 277, pppk_l: 18, pppk_p: 72 },
                        div:   { pns_l: 30,  pns_p: 23,  pppk_l: 0,  pppk_p: 4 },
                        s1:    { pns_l: 331, pns_p: 934, pppk_l: 95, pppk_p: 280 },
                        s2:    { pns_l: 128, pns_p: 170, pppk_l: 0,  pppk_p: 0 },
                        s3:    { pns_l: 0,   pns_p: 0,   pppk_l: 0,  pppk_p: 0 }
                    }
                };

                const yrDefaults = (is232 ? defaultData232[yr] : defaultData231[yr]) || {};

                let totPnsL = 0, totPnsP = 0, totPnsJml = 0;
                let totPppkL = 0, totPppkP = 0, totPppkJml = 0;
                let totAsnL = 0, totAsnP = 0, totAsnJml = 0;
                let hasData = false;

                activeExportRows.forEach(item => {
                    const def = yrDefaults[item.key] || { pns_l: '', pns_p: '', pppk_l: '', pppk_p: '' };

                    const pnsLVal = (d[`${item.key}_pns_l`] !== undefined && d[`${item.key}_pns_l`] !== '') ? d[`${item.key}_pns_l`] : def.pns_l;
                    const pnsPVal = (d[`${item.key}_pns_p`] !== undefined && d[`${item.key}_pns_p`] !== '') ? d[`${item.key}_pns_p`] : def.pns_p;
                    const pppkLVal = (d[`${item.key}_pppk_l`] !== undefined && d[`${item.key}_pppk_l`] !== '') ? d[`${item.key}_pppk_l`] : def.pppk_l;
                    const pppkPVal = (d[`${item.key}_pppk_p`] !== undefined && d[`${item.key}_pppk_p`] !== '') ? d[`${item.key}_pppk_p`] : def.pppk_p;

                    const hasPnsL = (pnsLVal !== '' && pnsLVal !== '-');
                    const hasPnsP = (pnsPVal !== '' && pnsPVal !== '-');
                    const hasPppkL = (pppkLVal !== '' && pppkLVal !== '-');
                    const hasPppkP = (pppkPVal !== '' && pppkPVal !== '-');

                    if (hasPnsL || hasPnsP || hasPppkL || hasPppkP) {
                        hasData = true;
                    }

                    const numPnsL = hasPnsL ? (parseFloat(String(pnsLVal).replace(',', '.')) || 0) : '';
                    const numPnsP = hasPnsP ? (parseFloat(String(pnsPVal).replace(',', '.')) || 0) : '';
                    const numPppkL = hasPppkL ? (parseFloat(String(pppkLVal).replace(',', '.')) || 0) : '';
                    const numPppkP = hasPppkP ? (parseFloat(String(pppkPVal).replace(',', '.')) || 0) : '';

                    const pnsJml = (hasPnsL || hasPnsP) ? ((numPnsL || 0) + (numPnsP || 0)) : '';
                    const pppkJml = (hasPppkL || hasPppkP) ? ((numPppkL || 0) + (numPppkP || 0)) : '';
                    const totalL = (hasPnsL || hasPppkL) ? ((numPnsL || 0) + (numPppkL || 0)) : '';
                    const totalP = (hasPnsP || hasPppkP) ? ((numPnsP || 0) + (numPppkP || 0)) : '';
                    const totalJml = (pnsJml !== '' || pppkJml !== '') ? ((pnsJml || 0) + (pppkJml || 0)) : '';

                    if (numPnsL !== '') totPnsL += numPnsL;
                    if (numPnsP !== '') totPnsP += numPnsP;
                    if (pnsJml !== '') totPnsJml += pnsJml;
                    if (numPppkL !== '') totPppkL += numPppkL;
                    if (numPppkP !== '') totPppkP += numPppkP;
                    if (pppkJml !== '') totPppkJml += pppkJml;
                    if (totalL !== '') totAsnL += totalL;
                    if (totalP !== '') totAsnP += totalP;
                    if (totalJml !== '') totAsnJml += totalJml;

                    setCell(r, 0, item.label, dataCellStyle);
                    setCell(r, 1, numPnsL !== '' ? numPnsL : '-', dataCenterStyle);
                    setCell(r, 2, numPnsP !== '' ? numPnsP : '-', dataCenterStyle);
                    setCell(r, 3, pnsJml !== '' ? pnsJml : '-', dataCenterStyle);
                    setCell(r, 4, numPppkL !== '' ? numPppkL : '-', dataCenterStyle);
                    setCell(r, 5, numPppkP !== '' ? numPppkP : '-', dataCenterStyle);
                    setCell(r, 6, pppkJml !== '' ? pppkJml : '-', dataCenterStyle);
                    setCell(r, 7, totalL !== '' ? totalL : '-', dataCenterStyle);
                    setCell(r, 8, totalP !== '' ? totalP : '-', dataCenterStyle);
                    setCell(r, 9, totalJml !== '' ? totalJml : '-', dataCenterStyle);
                    r++;
                });

                // Row Total
                setCell(r, 0, 'Jumlah / Total', totalRowStyle);
                setCell(r, 1, hasData ? totPnsL : '-', totalCenterStyle);
                setCell(r, 2, hasData ? totPnsP : '-', totalCenterStyle);
                setCell(r, 3, hasData ? totPnsJml : '-', totalCenterStyle);
                setCell(r, 4, hasData ? totPppkL : '-', totalCenterStyle);
                setCell(r, 5, hasData ? totPppkP : '-', totalCenterStyle);
                setCell(r, 6, hasData ? totPppkJml : '-', totalCenterStyle);
                setCell(r, 7, hasData ? totAsnL : '-', totalCenterStyle);
                setCell(r, 8, hasData ? totAsnP : '-', totalCenterStyle);
                setCell(r, 9, hasData ? totAsnJml : '-', totalCenterStyle);
                r++;

                // Footer Catatan & Sumber
                r++;
                setCell(r, 0, `Catatan / Note: Data per-31 Desember ${yr}`, { font: { name: 'Calibri', sz: 9, italic: true } });
                r++;
                setCell(r, 0, 'Sumber / Source: Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / Human Resources and Development Agency of Bukittinggi Municipality', { font: { name: 'Calibri', sz: 9, italic: true } });

                maxCol = 10;
                ws['!cols'] = [
                    { wch: 48 }, // Kategori
                    { wch: 14 }, { wch: 14 }, { wch: 14 }, // PNS
                    { wch: 14 }, { wch: 14 }, { wch: 14 }, // PPPK
                    { wch: 14 }, { wch: 14 }, { wch: 16 }  // Total ASN
                ];
            } else if (currentTableCode === '2.3.3') {
                titleId = `Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang), ${yr}`;
                titleEn = `Number of Bukittinggi Municipality Government’s Civil Servants by Hierarchy and Sex (people), ${yr}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1: Oranye BPS
                setCell(r, 0, 'Pangkat / Golongan / Ruang / Hierarchy / Range', headerOrangeStyle);
                setCell(r, 1, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r + 1, c: 1 } });

                setCell(r, 2, 'Pegawai Negeri Sipil / Civil Servant', headerOrangeStyle);
                setCell(r, 3, '', headerOrangeStyle);
                setCell(r, 4, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 2 }, e: { r: r, c: 4 } });
                r++;

                // Header Baris 2: Sub-kolom Jenis Kelamin
                setCell(r, 0, '', headerOrangeStyle);
                setCell(r, 1, '', headerOrangeStyle);
                setCell(r, 2, 'Laki–laki / Male', headerOrangeStyle);
                setCell(r, 3, 'Perempuan / Female', headerOrangeStyle);
                setCell(r, 4, 'Jumlah / Total', headerOrangeStyle);
                r++;

                // Header Baris 3: Peach Penomoran Kolom (1) s.d (4)
                setCell(r, 0, '(1)', headerPeachStyle);
                setCell(r, 1, '', headerPeachStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r + 1, c: 1 } });
                setCell(r, 2, '(2)', headerPeachStyle);
                setCell(r, 3, '(3)', headerPeachStyle);
                setCell(r, 4, '(4)', headerPeachStyle);
                r++;

                const rankGroups = [
                    {
                        groupId: 'Golongan I',
                        groupEn: 'Range I',
                        ranks: [
                            { key: '1_ia', noGol: '1. I / A', labelId: 'Juru Muda', labelEn: 'Junior Clerk' },
                            { key: '2_ib', noGol: '2. I / B', labelId: 'Juru Muda Tingkat I', labelEn: 'First Class Junior Clerk' },
                            { key: '3_ic', noGol: '3. I / C', labelId: 'Juru', labelEn: 'Clerk' },
                            { key: '4_id', noGol: '4. I / D', labelId: 'Juru Tingkat I', labelEn: 'First Class Clerk' }
                        ]
                    },
                    {
                        groupId: 'Golongan II',
                        groupEn: 'Range II',
                        ranks: [
                            { key: '5_iia', noGol: '5. II / A', labelId: 'Pengatur Muda', labelEn: 'Junior Supervisor' },
                            { key: '6_iib', noGol: '6. II / B', labelId: 'Pengatur Muda Tingkat I', labelEn: 'First Class Junior Supervisor' },
                            { key: '7_iic', noGol: '7. II / C', labelId: 'Pengatur', labelEn: 'Supervisor' },
                            { key: '8_iid', noGol: '8. II / D', labelId: 'Pengatur Tingkat I', labelEn: 'First Class Supervisor' }
                        ]
                    },
                    {
                        groupId: 'Golongan III',
                        groupEn: 'Range III',
                        ranks: [
                            { key: '9_iiia', noGol: '9. III / A', labelId: 'Penata Muda', labelEn: 'Junior Superintendent' },
                            { key: '10_iiib', noGol: '10. III / B', labelId: 'Penata Muda Tingkat I', labelEn: 'First Class Junior Superintendent' },
                            { key: '11_iiic', noGol: '11. III / C', labelId: 'Penata', labelEn: 'Superintendent' },
                            { key: '12_iiid', noGol: '12. III / D', labelId: 'Penata Tingkat I', labelEn: 'First Class Superintendent' }
                        ]
                    },
                    {
                        groupId: 'Golongan IV',
                        groupEn: 'Range IV',
                        ranks: [
                            { key: '13_iva', noGol: '13. IV / A', labelId: 'Pembina', labelEn: 'Administrator' },
                            { key: '14_ivb', noGol: '14. IV / B', labelId: 'Pembina Tingkat I', labelEn: 'First Class Administrator' },
                            { key: '15_ivc', noGol: '15. IV / C', labelId: 'Pembina Utama Muda', labelEn: 'Junior Administrator' },
                            { key: '16_ivd', noGol: '16. IV / D', labelId: 'Pembina Utama Madya', labelEn: 'Middle Administrator' },
                            { key: '17_ive', noGol: '17. IV / E', labelId: 'Pembina Utama', labelEn: 'Senior Administrator' }
                        ]
                    }
                ];

                const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                const defaultData233 = {
                    2025: {
                        '1_ia': { l: 0, p: 0 }, '2_ib': { l: 0, p: 0 }, '3_ic': { l: 1, p: 0 }, '4_id': { l: 5, p: 0 },
                        '5_iia': { l: 43, p: 2 }, '6_iib': { l: 5, p: 1 }, '7_iic': { l: 41, p: 80 }, '8_iid': { l: 57, p: 54 },
                        '9_iiia': { l: 103, p: 117 }, '10_iiib': { l: 91, p: 220 }, '11_iiic': { l: 98, p: 212 }, '12_iiid': { l: 193, p: 468 },
                        '13_iva': { l: 68, p: 167 }, '14_ivb': { l: 37, p: 103 }, '15_ivc': { l: 24, p: 57 }, '16_ivd': { l: 1, p: 0 }, '17_ive': { l: 0, p: 0 }
                    },
                    2024: {
                        '1_ia': { l: 0, p: 0 }, '2_ib': { l: 0, p: 0 }, '3_ic': { l: 2, p: 0 }, '4_id': { l: 15, p: 1 },
                        '5_iia': { l: 36, p: 1 }, '6_iib': { l: 5, p: 1 }, '7_iic': { l: 57, p: 93 }, '8_iid': { l: 57, p: 51 },
                        '9_iiia': { l: 107, p: 114 }, '10_iiib': { l: 86, p: 246 }, '11_iiic': { l: 91, p: 177 }, '12_iiid': { l: 197, p: 480 },
                        '13_iva': { l: 68, p: 142 }, '14_ivb': { l: 39, p: 117 }, '15_ivc': { l: 23, p: 56 }, '16_ivd': { l: 1, p: 0 }, '17_ive': { l: 0, p: 0 }
                    }
                };

                const yrDefaults = defaultData233[yr] || {};
                let totL = 0, totP = 0, totJml = 0;
                let hasData = false;

                rankGroups.forEach(grp => {
                    let grpL = 0, grpP = 0, grpJml = 0;
                    let grpHasData = false;

                    const rankRowsToRender = [];
                    grp.ranks.forEach(rk => {
                        const def = yrDefaults[rk.key] || { l: '', p: '' };
                        const lVal = (d[`${rk.key}_l`] !== undefined && d[`${rk.key}_l`] !== '') ? d[`${rk.key}_l`] : def.l;
                        const pVal = (d[`${rk.key}_p`] !== undefined && d[`${rk.key}_p`] !== '') ? d[`${rk.key}_p`] : def.p;

                        const hasL = (lVal !== '' && lVal !== '-');
                        const hasP = (pVal !== '' && pVal !== '-');
                        if (hasL || hasP) {
                            hasData = true;
                            grpHasData = true;
                        }

                        const numL = hasL ? (parseFloat(String(lVal).replace(',', '.')) || 0) : '';
                        const numP = hasP ? (parseFloat(String(pVal).replace(',', '.')) || 0) : '';
                        const rowJml = (hasL || hasP) ? ((numL || 0) + (numP || 0)) : '';

                        if (numL !== '') { grpL += numL; totL += numL; }
                        if (numP !== '') { grpP += numP; totP += numP; }
                        if (rowJml !== '') { grpJml += rowJml; totJml += rowJml; }

                        rankRowsToRender.push({
                            noGol: rk.noGol,
                            label: `${rk.labelId} / ${rk.labelEn}`,
                            l: (numL !== '') ? numL : (lVal || '-'),
                            p: (numP !== '') ? numP : (pVal || '-'),
                            jml: (rowJml !== '') ? rowJml : '-'
                        });
                    });

                    // Row Group Header
                    setCell(r, 0, `${grp.groupId} / ${grp.groupEn}`, headerPeachStyle);
                    setCell(r, 1, '', headerPeachStyle);
                    merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                    setCell(r, 2, '', headerPeachStyle);
                    setCell(r, 3, '', headerPeachStyle);
                    setCell(r, 4, '', headerPeachStyle);
                    r++;

                    // Rank Data Rows
                    rankRowsToRender.forEach(item => {
                        setCell(r, 0, item.noGol, dataCenterStyle);
                        setCell(r, 1, item.label, dataCellStyle);
                        setCell(r, 2, item.l, dataCenterStyle);
                        setCell(r, 3, item.p, dataCenterStyle);
                        setCell(r, 4, item.jml, totalCenterStyle);
                        r++;
                    });
                });

                // Row Total
                setCell(r, 0, 'Jumlah / Total', headerPeachStyle);
                setCell(r, 1, '', headerPeachStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                setCell(r, 2, hasData ? totL : '-', totalCenterStyle);
                setCell(r, 3, hasData ? totP : '-', totalCenterStyle);
                setCell(r, 4, hasData ? totJml : '-', totalCenterStyle);
                r++;

                // Footer Catatan & Sumber
                r++;
                setCell(r, 0, `Catatan / Note: Data per-31 Desember ${yr}`, { font: { name: 'Calibri', sz: 9, italic: true } });
                r++;
                setCell(r, 0, 'Sumber / Source: Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / Human Resources and Development Agency of Bukittinggi Municipality', { font: { name: 'Calibri', sz: 9, italic: true } });

                maxCol = 5;
                ws['!cols'] = [
                    { wch: 14 }, // No Gol
                    { wch: 44 }, // Pangkat
                    { wch: 16 }, // L
                    { wch: 16 }, // P
                    { wch: 18 }  // Total
                ];
            } else if (currentTableCode === '2.3.4') {
                titleId = `Jumlah Pegawai Pemerintah dengan Perjanjian Kerja Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang), ${yr}`;
                titleEn = `Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people), ${yr}`;
                setCell(0, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(1, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });

                // Header Baris 1: Oranye BPS
                setCell(r, 0, 'Tingkat Kepangkatan / Golongan / Hierarchy / Range', headerOrangeStyle);
                setCell(r, 1, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r + 1, c: 1 } });

                setCell(r, 2, 'Pegawai Pemerintah dengan Perjanjian Kerja / Civil Servants with Employment Agreements', headerOrangeStyle);
                setCell(r, 3, '', headerOrangeStyle);
                setCell(r, 4, '', headerOrangeStyle);
                merges.push({ s: { r: r, c: 2 }, e: { r: r, c: 4 } });
                r++;

                // Header Baris 2: Sub-kolom Jenis Kelamin
                setCell(r, 0, '', headerOrangeStyle);
                setCell(r, 1, '', headerOrangeStyle);
                setCell(r, 2, 'Laki–laki / Male', headerOrangeStyle);
                setCell(r, 3, 'Perempuan / Female', headerOrangeStyle);
                setCell(r, 4, 'Jumlah / Total', headerOrangeStyle);
                r++;

                // Header Baris 3: Peach Penomoran Kolom (1) s.d (4)
                setCell(r, 0, '(1)', headerPeachStyle);
                setCell(r, 1, '', headerPeachStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                setCell(r, 2, '(2)', headerPeachStyle);
                setCell(r, 3, '(3)', headerPeachStyle);
                setCell(r, 4, '(4)', headerPeachStyle);
                r++;

                const ranks234 = [
                    { key: 'gol_1',  noGol: '1.',  label: 'Golongan I / Range I (Setara SD)' },
                    { key: 'gol_2',  noGol: '2.',  label: 'Golongan II / Range II' },
                    { key: 'gol_3',  noGol: '3.',  label: 'Golongan III / Range III' },
                    { key: 'gol_4',  noGol: '4.',  label: 'Golongan IV / Range IV (Setara SMP)' },
                    { key: 'gol_5',  noGol: '5.',  label: 'Golongan V / Range V (Setara SMA/SMK)' },
                    { key: 'gol_6',  noGol: '6.',  label: 'Golongan VI / Range VI (Setara D-II)' },
                    { key: 'gol_7',  noGol: '7.',  label: 'Golongan VII / Range VII (Setara D-III)' },
                    { key: 'gol_8',  noGol: '8.',  label: 'Golongan VIII / Range VIII (Setara D-IV)' },
                    { key: 'gol_9',  noGol: '9.',  label: 'Golongan IX / Range IX (Setara S-1/D-IV)' },
                    { key: 'gol_10', noGol: '10.', label: 'Golongan X / Range X (Setara S-2)' },
                    { key: 'gol_11', noGol: '11.', label: 'Golongan XI / Range XI (Setara S-3)' },
                    { key: 'gol_12', noGol: '12.', label: 'Golongan XII / Range XII' },
                    { key: 'gol_13', noGol: '13.', label: 'Golongan XIII / Range XIII' },
                    { key: 'gol_14', noGol: '14.', label: 'Golongan XIV / Range XIV' },
                    { key: 'gol_15', noGol: '15.', label: 'Golongan XV / Range XV' },
                    { key: 'gol_16', noGol: '16.', label: 'Golongan XVI / Range XVI' },
                    { key: 'gol_17', noGol: '17.', label: 'Golongan XVII / Range XVII' }
                ];

                const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                const defaultData234 = {
                    2025: {
                        'gol_1': { l: 4, p: 1 }, 'gol_2': { l: 0, p: 0 }, 'gol_3': { l: 0, p: 0 }, 'gol_4': { l: 1, p: 0 },
                        'gol_5': { l: 116, p: 44 }, 'gol_6': { l: 0, p: 0 }, 'gol_7': { l: 21, p: 74 }, 'gol_8': { l: 0, p: 4 },
                        'gol_9': { l: 101, p: 288 }, 'gol_10': { l: 2, p: 0 }, 'gol_11': { l: 0, p: 0 }, 'gol_12': { l: 0, p: 0 },
                        'gol_13': { l: 0, p: 0 }, 'gol_14': { l: 0, p: 0 }, 'gol_15': { l: 0, p: 0 }, 'gol_16': { l: 0, p: 0 }, 'gol_17': { l: 0, p: 0 }
                    },
                    2024: {
                        'gol_1': { l: 0, p: 0 }, 'gol_2': { l: 0, p: 0 }, 'gol_3': { l: 0, p: 0 }, 'gol_4': { l: 0, p: 0 },
                        'gol_5': { l: 34, p: 5 }, 'gol_6': { l: 0, p: 0 }, 'gol_7': { l: 18, p: 72 }, 'gol_8': { l: 0, p: 4 },
                        'gol_9': { l: 95, p: 280 }, 'gol_10': { l: 0, p: 0 }, 'gol_11': { l: 0, p: 0 }, 'gol_12': { l: 0, p: 0 },
                        'gol_13': { l: 0, p: 0 }, 'gol_14': { l: 0, p: 0 }, 'gol_15': { l: 0, p: 0 }, 'gol_16': { l: 0, p: 0 }, 'gol_17': { l: 0, p: 0 }
                    }
                };

                const yrDefaults = defaultData234[yr] || {};
                let totL = 0, totP = 0, totJml = 0;
                let hasData = false;

                ranks234.forEach(rk => {
                    const def = yrDefaults[rk.key] || { l: '', p: '' };
                    let lVal = (d[`${rk.key}_l`] !== undefined && d[`${rk.key}_l`] !== '') ? d[`${rk.key}_l`] : def.l;
                    let pVal = (d[`${rk.key}_p`] !== undefined && d[`${rk.key}_p`] !== '') ? d[`${rk.key}_p`] : def.p;

                    const hasL = (lVal !== '' && lVal !== '-');
                    const hasP = (pVal !== '' && pVal !== '-');
                    if (hasL || hasP) {
                        hasData = true;
                    }

                    const numL = hasL ? (parseFloat(String(lVal).replace(',', '.')) || 0) : '';
                    const numP = hasP ? (parseFloat(String(pVal).replace(',', '.')) || 0) : '';
                    const rowJml = (hasL || hasP) ? ((numL || 0) + (numP || 0)) : '';

                    if (numL !== '') { totL += numL; }
                    if (numP !== '') { totP += numP; }
                    if (rowJml !== '') { totJml += rowJml; }

                    setCell(r, 0, rk.noGol, dataCenterStyle);
                    setCell(r, 1, rk.label, dataCellStyle);
                    setCell(r, 2, (numL !== '') ? numL : (lVal || '-'), dataCenterStyle);
                    setCell(r, 3, (numP !== '') ? numP : (pVal || '-'), dataCenterStyle);
                    setCell(r, 4, (rowJml !== '') ? rowJml : '-', totalCenterStyle);
                    r++;
                });

                // Row Total
                setCell(r, 0, 'Jumlah / Total', headerPeachStyle);
                setCell(r, 1, '', headerPeachStyle);
                merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                setCell(r, 2, hasData ? totL : '-', totalCenterStyle);
                setCell(r, 3, hasData ? totP : '-', totalCenterStyle);
                setCell(r, 4, hasData ? totJml : '-', totalCenterStyle);
                r++;

                // Footer Catatan & Sumber
                r++;
                setCell(r, 0, `Catatan / Note: Data per-31 Desember ${yr}`, { font: { name: 'Calibri', sz: 9, italic: true } });
                r++;
                setCell(r, 0, 'Sumber / Source: Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / Human Resources and Development Agency of Bukittinggi Municipality', { font: { name: 'Calibri', sz: 9, italic: true } });

                maxCol = 5;
                ws['!cols'] = [
                    { wch: 10 }, // No Gol
                    { wch: 48 }, // Golongan & Keterangan
                    { wch: 16 }, // L
                    { wch: 16 }, // P
                    { wch: 18 }  // Total
                ];
            } else if (currentTableCode === '2.3.5') {
                titleId = `Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi, ${yr}`;
                titleEn = `Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement, ${yr}`;
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

                ﻿const units235 = [
    { key: 'unit_1', no: 1, name: "01. Sekretaris Daerah", pns25: '104', pppk25: '5', pns24: '99', pppk24: '4' },
    { key: 'unit_2', no: 2, name: "02. Badan Kepegawaian dan Pengembangan Sumber Daya Manusia", pns25: '27', pppk25: '2', pns24: '27', pppk24: '0' },
    { key: 'unit_3', no: 3, name: "03. Badan Keuangan", pns25: '57', pppk25: '5', pns24: '50', pppk24: '3' },
    { key: 'unit_4', no: 4, name: "04. Badan Perencanaan Penelitian dan Pembangunan", pns25: '32', pppk25: '1', pns24: '33', pppk24: '0' },
    { key: 'unit_5', no: 5, name: "05. Inspektorat Daerah", pns25: '43', pppk25: '0', pns24: '44', pppk24: '0' },
    { key: 'unit_6', no: 6, name: "06. Sekretariat Dewan Perwakilan Rakyat daerah", pns25: '26', pppk25: '3', pns24: '27', pppk24: '0' },
    { key: 'unit_7', no: 7, name: "07. Dinas Pemadam Kebakaran dan Penyelamatan", pns25: '24', pppk25: '25', pns24: '24', pppk24: '25' },
    { key: 'unit_8', no: 8, name: "08. Dinas Kependudukan Dan Pencatatan Sipil", pns25: '22', pppk25: '2', pns24: '23', pppk24: '0' },
    { key: 'unit_9', no: 9, name: "09. Dinas Kesehatan", pns25: '54', pppk25: '7', pns24: '49', pppk24: '5' },
    { key: 'unit_10', no: 10, name: "10. Dinas Komunikasi Dan Informatika", pns25: '19', pppk25: '3', pns24: '20', pppk24: '3' },
    { key: 'unit_11', no: 11, name: "11. Dinas Koperasi, Usaha Kecil mengengah Dan Tenaga Kerja", pns25: '24', pppk25: '4', pns24: '21', pppk24: '1' },
    { key: 'unit_12', no: 12, name: "12. Dinas Lingkungan Hidup", pns25: '101', pppk25: '22', pns24: '102', pppk24: '10' },
    { key: 'unit_13', no: 13, name: "13. Dinas Pariwisata", pns25: '45', pppk25: '15', pns24: '44', pppk24: '3' },
    { key: 'unit_14', no: 14, name: "14. Dinas Pekerjaan Umum dan Penataan Ruang", pns25: '52', pppk25: '8', pns24: '50', pppk24: '5' },
    { key: 'unit_15', no: 15, name: "15. Dinas Pemberdayaan Perempuan Dan Perlindungan Anak, Pengendalian Penduduk Dan Keluarga Berencana", pns25: '28', pppk25: '2', pns24: '30', pppk24: '0' },
    { key: 'unit_16', no: 16, name: "16. Dinas Penanaman Modal Pelayanan Terpadu Satu Pintu", pns25: '23', pppk25: '3', pns24: '25', pppk24: '2' },
    { key: 'unit_17', no: 17, name: "17. Dinas Pendidikan Dan Kebudayaan", pns25: '66', pppk25: '5', pns24: '71', pppk24: '0' },
    { key: 'unit_18', no: 18, name: "18. Dinas Perhubungan", pns25: '36', pppk25: '6', pns24: '41', pppk24: '2' },
    { key: 'unit_19', no: 19, name: "19. Dinas Perpustakaan Dan Kearsipan", pns25: '22', pppk25: '1', pns24: '28', pppk24: '1' },
    { key: 'unit_20', no: 20, name: "20. Dinas Pertanian Dan Pangan", pns25: '42', pppk25: '5', pns24: '39', pppk24: '3' },
    { key: 'unit_21', no: 21, name: "21. Dinas Perdagangan dan Perindustrian", pns25: '28', pppk25: '13', pns24: '26', pppk24: '3' },
    { key: 'unit_22', no: 22, name: "22. Dinas Perumahan Dan Kawasan Pemukiman", pns25: '30', pppk25: '7', pns24: '29', pppk24: '0' },
    { key: 'unit_23', no: 23, name: "23. Dinas Sosial", pns25: '21', pppk25: '5', pns24: '19', pppk24: '0' },
    { key: 'unit_24', no: 24, name: "24. Dinas Pemuda dan Olahraga", pns25: '17', pppk25: '6', pns24: '17', pppk24: '0' },
    { key: 'unit_25', no: 25, name: "25. Satuan Polisi Pamong Praja", pns25: '59', pppk25: '50', pns24: '47', pppk24: '0' },
    { key: 'unit_26', no: 26, name: "26. Badan Penanggulangan Bencana Daerah", pns25: '11', pppk25: '15', pns24: '12', pppk24: '15' },
    { key: 'unit_27', no: 27, name: "27. Badan Kesatuan Bangsa dan Politik", pns25: '14', pppk25: '1', pns24: '15', pppk24: '1' },
    { key: 'unit_28', no: 28, name: "28. Kecamatan Aur Birugo Tigo Baleh", pns25: '14', pppk25: '1', pns24: '15', pppk24: '1' },
    { key: 'unit_29', no: 29, name: "29. Kecamatan Guguk Panjang", pns25: '13', pppk25: '2', pns24: '14', pppk24: '1' },
    { key: 'unit_30', no: 30, name: "30. Kecamatan Mandiangin Koto Selayan", pns25: '17', pppk25: '1', pns24: '18', pppk24: '1' },
    { key: 'unit_31', no: 31, name: "31. Keluarahan Campago Guguk Bulek", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_32', no: 32, name: "32. Kelurahan Campago Ipuh", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_33', no: 33, name: "33. Kelurahan Garegeh", pns25: '6', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_34', no: 34, name: "34. Kelurahan Koto Selayan", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_35', no: 35, name: "35. Kelurahan Kubu Gulai Bancah", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_36', no: 36, name: "36. Kelurahan Manggis Ganting", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_37', no: 37, name: "37. Kelurahan Puhun Pintu Kabun", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_38', no: 38, name: "38. Kelurahan Puhun Tembok", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_39', no: 39, name: "39. Kelurahan Pulai Anak Air", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_40', no: 40, name: "40. Kelurahan Aur Tajungkang Tengah Sawah", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_41', no: 41, name: "41. Kelurahan Benteng Pasar Atas", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_42', no: 42, name: "42. Kelurahan Bukit Apit Puhun", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_43', no: 43, name: "43. Kelurahan Bukit Cangang kayu Ramang", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_44', no: 44, name: "44. Kelurahan Kayu Kubu", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_45', no: 45, name: "45. Kelurahan Pakan Kurai", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_46', no: 46, name: "46. Kelurahan Tarok Dipo", pns25: '7', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_47', no: 47, name: "47. Kelurahan Belakang Balok", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_48', no: 48, name: "48. Kelurahan Aur Kuning", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_49', no: 49, name: "49. Kelurahan Birugo", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_50', no: 50, name: "50. Kelurahan Kubu Tanjung", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_51', no: 51, name: "51. Kelurahan Ladang Cakiah", pns25: '7', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_52', no: 52, name: "52. Kelurahan Pakan Labuah", pns25: '6', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_53', no: 53, name: "53. Kelurahan Parit Antang", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_54', no: 54, name: "54. Kelurahan Sapiran", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_55', no: 55, name: "55. TK", pns25: '13', pppk25: '2', pns24: '15', pppk24: '2' },
    { key: 'unit_56', no: 56, name: "56. SD", pns25: '373', pppk25: '178', pns24: '389', pppk24: '179' },
    { key: 'unit_57', no: 57, name: "57. SMP \/ MTsN", pns25: '202', pppk25: '83', pns24: '209', pppk24: '81' },
    { key: 'unit_58', no: 58, name: "58. UPTD Sanggar Kegiatan Belajar", pns25: '3', pppk25: '9', pns24: '3', pppk24: '9' },
    { key: 'unit_59', no: 59, name: "59. UPTD Instalasi Farmasi", pns25: '5', pppk25: '2', pns24: '6', pppk24: '2' },
    { key: 'unit_60', no: 60, name: "60. UPTD Laboratorium Kesehatan", pns25: '16', pppk25: '1', pns24: '16', pppk24: '1' },
    { key: 'unit_61', no: 61, name: "61. UPTD Puskemas Guguak Panjang", pns25: '35', pppk25: '3', pns24: '36', pppk24: '3' },
    { key: 'unit_62', no: 62, name: "62. UPTD Puskesmas Gulai Bancah", pns25: '30', pppk25: '1', pns24: '30', pppk24: '1' },
    { key: 'unit_63', no: 63, name: "63. UPTD Puskemas Mandiangin", pns25: '31', pppk25: '3', pns24: '33', pppk24: '3' },
    { key: 'unit_64', no: 64, name: "64. UPTD Puskesmas Nilam Sari", pns25: '31', pppk25: '5', pns24: '33', pppk24: '5' },
    { key: 'unit_65', no: 65, name: "65. UPTD Puskesmas Perkotaan Rasimah Ahmad", pns25: '40', pppk25: '3', pns24: '41', pppk24: '3' },
    { key: 'unit_66', no: 66, name: "66. UPTD Puskesmas Plus Mandiangin", pns25: '29', pppk25: '4', pns24: '29', pppk24: '4' },
    { key: 'unit_67', no: 67, name: "67. UPTD Puskemas Tigo Baleh", pns25: '41', pppk25: '2', pns24: '44', pppk24: '2' },
    { key: 'unit_68', no: 68, name: "68. UPTD RSUD", pns25: '95', pppk25: '124', pns24: '88', pppk24: '124' },
    { key: 'unit_69', no: 69, name: "69. UPTD Balai Benih Ikan Hias", pns25: '4', pppk25: '2', pns24: '2', pppk24: '0' },
    { key: 'unit_70', no: 70, name: "70. UPTD Pusat Kesehatan Hewan", pns25: '5', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_71', no: 71, name: "71. UPTD Rumah Potong Hewan", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_72', no: 72, name: "72. UPTD Kerajinan Industri", pns25: '2', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_73', no: 73, name: "73. UPTD Penguji Kendaraan bermotor", pns25: '6', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_74', no: 74, name: "74. UPTD Terminal dan Parkir", pns25: '16', pppk25: '9', pns24: '18', pppk24: '0' },
    { key: 'unit_75', no: 75, name: "75. UPTD Penerangan Fasilitas Umum", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_76', no: 76, name: "76. UPTD Perlengkapan dan Peralatan", pns25: '4', pppk25: '0', pns24: '4', pppk24: '0' },
    { key: 'unit_77', no: 77, name: "77. UPTD Kemetrologian", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_78', no: 78, name: "78. UPTD Perlindungan Perempuan dan Anak", pns25: '5', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_79', no: 79, name: "79. STAF AHLI", pns25: '3', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_80', no: 80, name: "80. Tugas Belajar", pns25: '4', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_81', no: 81, name: "81. MPP", pns25: '6', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_82', no: 82, name: "82. Diperbantukan", pns25: '12', pppk25: '0', pns24: '13', pppk24: '0' },
    { key: 'unit_83', no: 83, name: "83. CLTN", pns25: '1', pppk25: '0', pns24: '2', pppk24: '0' },
    { key: 'unit_84', no: 84, name: "84. Pemberhentian Sementara", pns25: '1', pppk25: '0', pns24: '2', pppk24: '0' },
];


                const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                let totPns = 0, totPppk = 0, totJml = 0;
                let hasData = false;

                units235.forEach(u => {
                    const defPns = (yr === 2024 ? u.pns24 : (yr === 2025 ? u.pns25 : ''));
                    const defPppk = (yr === 2024 ? u.pppk24 : (yr === 2025 ? u.pppk25 : ''));

                    let pnsVal = (d[`${u.key}_pns`] !== undefined && d[`${u.key}_pns`] !== '') ? d[`${u.key}_pns`] : defPns;
                    let pppkVal = (d[`${u.key}_pppk`] !== undefined && d[`${u.key}_pppk`] !== '') ? d[`${u.key}_pppk`] : defPppk;

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
                setCell(r, 0, `Catatan / Note: Data per-31 Desember ${yr}`, { font: { name: 'Calibri', sz: 9, italic: true } });
                r++;
                setCell(r, 0, 'Sumber / Source: Badan Kepegawaian dan Pengembangan SDM Kota Bukittinggi / Human Resources and Development Agency of Bukittinggi Municipality', { font: { name: 'Calibri', sz: 9, italic: true } });

                maxCol = 4;
                ws['!cols'] = [
                    { wch: 65 }, // Unit Kerja
                    { wch: 18 }, // PNS
                    { wch: 18 }, // PPPK
                    { wch: 20 }  // Total
                ];
            } else if (sourceTableHtml) {
                // UNTUK SEMUA TABEL LAINNYA (8.1.1, 8.1.2, 8.1.3, 8.1.4, 8.1.5, 1.1.8, 1.1.9, 1.1.1, 2.2.5, dst.)
                // Otomatis deteksi thead, baris-baris nama indikator, dan seluruh kolom yang ada
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = sourceTableHtml;

                const theadRows = tempDiv.querySelectorAll('thead tr');
                const tbodyRows = tempDiv.querySelectorAll('tbody tr');
                const allRows = Array.from(theadRows).concat(Array.from(tbodyRows));

                const grid = [];
                let gridRowIdx = 0;

                allRows.forEach((tr, trIdx) => {
                    const isHeader = tr.closest('thead') !== null;
                    const isSubHeader = isHeader && trIdx > 0;
                    const cells = tr.querySelectorAll('th, td');

                    if (!grid[gridRowIdx]) grid[gridRowIdx] = [];
                    let gridColIdx = 0;

                    cells.forEach(cell => {
                        while (grid[gridRowIdx][gridColIdx]) {
                            gridColIdx++;
                        }

                        const colspan = parseInt(cell.getAttribute('colspan') || 1, 10);
                        const rowspan = parseInt(cell.getAttribute('rowspan') || 1, 10);
                        let text = getCellText(cell);

                        const isTotalRow = !isHeader && (tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total'));
                        let style = dataCellStyle;
                        if (isHeader) {
                            style = isSubHeader ? headerPeachStyle : headerOrangeStyle;
                        } else if (isTotalRow) {
                            style = (gridColIdx === 0) ? totalRowStyle : totalCenterStyle;
                        } else if (cell.classList.contains('text-center') || /^\(\d+\)$/.test(text.trim())) {
                            style = dataCenterStyle;
                        }

                        for (let ro = 0; ro < rowspan; ro++) {
                            for (let co = 0; co < colspan; co++) {
                                const targetR = gridRowIdx + ro;
                                const targetC = gridColIdx + co;
                                if (!grid[targetR]) grid[targetR] = [];

                                let cellVal = (ro === 0 && co === 0) ? text : '';

                                // Pastikan kolom angka dikosongkan/diisi strip '-' agar siap diisi angka baru oleh OPD:
                                if (!isHeader && gridColIdx > 0) {
                                    const rawVal = (cellVal || '').trim();
                                    const isPureNumberOrDash = /^[\d.,\s\-%–—()]+$/.test(rawVal) || rawVal === '';
                                    const hasAlpha = /[a-zA-Z]{3,}/.test(rawVal);
                                    if (isPureNumberOrDash && !hasAlpha) {
                                        cellVal = '-';
                                    }
                                }

                                grid[targetR][targetC] = {
                                    val: cellVal,
                                    style: style
                                };
                            }
                        }

                        if (colspan > 1 || rowspan > 1) {
                            merges.push({
                                s: { r: tableStartRow + gridRowIdx, c: gridColIdx },
                                e: { r: tableStartRow + gridRowIdx + rowspan - 1, c: gridColIdx + colspan - 1 }
                            });
                        }

                        gridColIdx += colspan;
                    });

                    gridRowIdx++;
                });

                grid.forEach(row => { if (row.length > maxCol) maxCol = row.length; });

                grid.forEach((row, ri) => {
                    row.forEach((cellData, ci) => {
                        if (cellData) {
                            setCell(tableStartRow + ri, ci, cellData.val, cellData.style);
                        }
                    });
                });

                r = tableStartRow + grid.length;
            } else {
                // FALLBACK JIKA TABEL BELUM MEMILIKI DATA DI TAHUN MANAPUN
                setCell(r, 0, 'No', headerOrangeStyle);
                setCell(r, 1, 'Uraian / Rincian Indikator (Data Indicator)', headerOrangeStyle);
                setCell(r, 2, `Capaian Tahun ${yr} / Achievement Year ${yr}`, headerOrangeStyle);
                setCell(r, 3, 'Satuan / Unit', headerOrangeStyle);
                r++;

                setCell(r, 0, '(1)', headerPeachStyle);
                setCell(r, 1, '(2)', headerPeachStyle);
                setCell(r, 2, '(3)', headerPeachStyle);
                setCell(r, 3, '(4)', headerPeachStyle);
                r++;

                let rowsToGenerate = [];
                const titleLower = titleId.toLowerCase();
                if (titleLower.includes('kecamatan')) {
                    rowsToGenerate = [
                        { no: 1, name: '01. GUGUK PANJANG', val: '-', unit: '' },
                        { no: 2, name: '02. MANDIANGIN KOTO SELAYAN', val: '-', unit: '' },
                        { no: 3, name: '03. AUR BIRUGO TIGO BALEH', val: '-', unit: '' },
                        { no: '', name: 'Jumlah / Total', val: '-', unit: '', isTotal: true }
                    ];
                } else if (titleLower.includes('jenis kelamin')) {
                    rowsToGenerate = [
                        { no: 1, name: '1. Laki-laki / Male', val: '-', unit: 'Orang' },
                        { no: 2, name: '2. Perempuan / Female', val: '-', unit: 'Orang' },
                        { no: '', name: 'Jumlah / Total', val: '-', unit: 'Orang', isTotal: true }
                    ];
                } else {
                    rowsToGenerate = [
                        { no: 1, name: '01. Indikator / Kategori Data 1', val: '-', unit: '' },
                        { no: 2, name: '02. Indikator / Kategori Data 2', val: '-', unit: '' },
                        { no: 3, name: '03. Indikator / Kategori Data 3', val: '-', unit: '' },
                        { no: '', name: 'Jumlah / Total', val: '-', unit: '', isTotal: true }
                    ];
                }

                rowsToGenerate.forEach(item => {
                    const curStyle = item.isTotal ? totalRowStyle : dataCellStyle;
                    const centerStyle = item.isTotal ? totalCenterStyle : dataCenterStyle;
                    setCell(r, 0, item.no, centerStyle);
                    setCell(r, 1, item.name, curStyle);
                    setCell(r, 2, item.val, centerStyle);
                    setCell(r, 3, item.unit, centerStyle);
                    r++;
                });
                maxCol = 4;
            }

            // 4. FOOTER RESMI (Catatan & Sumber BPS)
            if (currentTableCode !== '2.3.1' && currentTableCode !== '2.3.2' && currentTableCode !== '2.3.3') {
                r++; // Baris kosong pemisah
                const finalNoteText = (currentTableCode === '8.1.1' && !cleanNote) 
                    ? '1. Data tidak termasuk panjang jalan tol / Excluding toll road\n2. Data tahun 2023 berdasarkan Keputusan Menteri Pekerjaan Umum dan Perumahan Rakyat No. 1688/KPTS/M/2022 / Data of 2023 based on Public Works and Public Housing Ministerial Decree No. 1688/KPTS/M/2022' 
                    : cleanNote;
                if (finalNoteText) {
                    setCell(r, 0, 'Catatan / Note:', { font: { name: 'Calibri', sz: 9.5, italic: true } });
                    setCell(r, 1, finalNoteText, { font: { name: 'Calibri', sz: 9.5, italic: true } });
                    r++;
                }

                const finalSourceText = cleanSource || (tableSchemas[currentTableCode] ? tableSchemas[currentTableCode].source.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : `${opdName} Kota Bukittinggi`);
                setCell(r, 0, 'Sumber / Source:', { font: { name: 'Calibri', sz: 9.5, italic: true } });
                setCell(r, 1, finalSourceText, { font: { name: 'Calibri', sz: 9.5, italic: true } });
                r++;
            }

            // 5. ATUR LEBAR KOLOM EXCEL (Auto Fit jika belum dispesifikasikan)
            if (!ws['!cols']) {
                const colWidths = [];
                for (let c = 0; c < maxCol; c++) {
                    if (c === 0 && maxCol > 2) {
                        colWidths.push({ wch: 10 }); // Kolom No / Kode
                    } else if (c === 1 || (c === 0 && maxCol <= 2)) {
                        colWidths.push({ wch: 38 }); // Kolom Uraian / Kategori / Kecamatan
                    } else {
                        colWidths.push({ wch: 18 }); // Kolom Nilai / Tahun / Satuan
                    }
                }
                ws['!cols'] = colWidths;
            }
            ws['!merges'] = merges;
            ws['!ref'] = XLSX.utils.encode_range({
                s: { r: 0, c: 0 },
                e: { r: r + 1, c: Math.max(maxCol - 1, 1) }
            });

            // 6. SIMPAN WORKBOOK & UNDUH BERKAS
            const isRoadTable = (currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.1.4' || currentTableCode === '8.1.5' || currentTableCode === '1.1.10' || currentTableCode === '2.2.5');
            const pRangeFile = get5YearPeriod(yr);
            const fileYrSuffix = isRoadTable ? pRangeFile.label.replace('–', '_') : currentYear;
            XLSX.utils.book_append_sheet(wb, ws, `Template_${currentTableCode}`.substring(0, 31));
            XLSX.writeFile(wb, `Template_Tabel_${currentTableCode.replace(/\./g, '_')}_${fileYrSuffix}.xlsx`);
            const toastYr = isRoadTable ? pRangeFile.label : currentYear;
            showToast(`📥 Berkas template Excel Tabel ${currentTableCode} Tahun ${toastYr} berhasil diunduh!`);
            } catch (err) {
                console.error('Error generating Excel template:', err);
                alert('Gagal mengunduh template Excel: ' + (err.message || err));
            }
        }

        function handleExcelFileSelected(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (!file) return;

            const loadingEl = document.getElementById('excelUploadLoading');
            if (loadingEl) loadingEl.classList.remove('hidden');

            const reader = new FileReader();
            reader.onload = async function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    let sheetName = workbook.SheetNames[0];
                    for (let name of workbook.SheetNames) {
                        const ws = workbook.Sheets[name];
                        const testRows = XLSX.utils.sheet_to_json(ws, { header: 1, defval: '' });
                        if (testRows && testRows.length > 0) {
                            sheetName = name;
                            break;
                        }
                    }
                    const worksheet = workbook.Sheets[sheetName];
                    const rawRows = XLSX.utils.sheet_to_json(worksheet, { header: 1, defval: '' });

                    await generateTableFromExcel(worksheet, rawRows, file.name);
                } catch(err) {
                    console.error(err);
                    alert('Gagal membaca berkas Excel: ' + (err.message || err));
                } finally {
                    if (loadingEl) loadingEl.classList.add('hidden');
                    event.target.value = '';
                }
            };
            reader.readAsArrayBuffer(file);
        }

        async function generateTableFromExcel(worksheet, rawRows, fileName) {
            if (!Array.isArray(rawRows) || rawRows.length === 0) {
                alert('Berkas Excel kosong atau tidak terbaca.');
                return;
            }

            const merges = worksheet && worksheet['!merges'] ? worksheet['!merges'] : [];

            // 1. Detect Footer / Source rows from the bottom
            let footerStartIdx = -1;
            for (let i = 0; i < rawRows.length; i++) {
                const row = rawRows[i] || [];
                const c0 = (row[0] || '').toString().trim().toLowerCase();
                const c1 = (row[1] || '').toString().trim().toLowerCase();
                const rowStr = row.map(c => (c || '').toString().trim()).join(' ').toLowerCase();
                
                if (c0.startsWith('sumber') || c0.startsWith('source') || c0.startsWith('catatan') || c0.startsWith('note') ||
                    c1.startsWith('sumber') || c1.startsWith('source') ||
                    rowStr.startsWith('sumber') || rowStr.startsWith('source')) {
                    footerStartIdx = i;
                    break;
                }
            }

            // Extract footer / source text if found
            let extractedSource = '';
            let extractedNote = '';
            if (footerStartIdx !== -1) {
                const sourceParts = [];
                const noteParts = [];
                let currentSection = '';

                const footerLimit = Math.min(rawRows.length, footerStartIdx + 10);
                for (let i = footerStartIdx; i < footerLimit; i++) {
                    const row = rawRows[i] || [];
                    const cells = row.map(c => (c || '').toString().trim()).filter(c => c !== '');
                    if (cells.length > 0) {
                        const line = cells.join(' ');
                        const lower = line.toLowerCase();

                        // Stop if reaching next table or signature block
                        if (i > footerStartIdx && (/^tabel\b/i.test(cells[0]) || /^table\b/i.test(cells[0]) || lower.includes('kepala dinas') || lower.includes('nip.') || lower.includes('badan pusat'))) {
                            break;
                        }

                        if (lower.startsWith('catatan') || lower.startsWith('note')) {
                            currentSection = 'note';
                            const cleaned = line.replace(/^(catatan\s*\/\s*note|catatan|note)\s*:\s*/i, '').trim();
                            if (cleaned) noteParts.push(cleaned);
                        } else if (lower.startsWith('sumber') || lower.startsWith('source')) {
                            currentSection = 'source';
                            const cleaned = line.replace(/^(sumber\s*\/\s*source|sumber|source)\s*:\s*/i, '').trim();
                            if (cleaned) sourceParts.push(cleaned);
                        } else {
                            if (currentSection === 'note') {
                                noteParts.push(line);
                            } else if (currentSection === 'source') {
                                sourceParts.push(line);
                            }
                        }
                    }
                }

                if (sourceParts.length > 0) {
                    const sJoined = sourceParts.join(' ');
                    if (sJoined.toLowerCase().includes('dinas pekerjaan umum')) {
                        extractedSource = 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Works and Spatial Planning Services of Bukittinggi Municipality</span>';
                    } else if (sJoined.length < 220 && !sJoined.toLowerCase().includes('tabel ')) {
                        if (sourceParts.length === 1) {
                            extractedSource = escapeHtml(sourceParts[0]);
                        } else {
                            extractedSource = `${escapeHtml(sourceParts[0])} / <span class="italic text-slate-500">${escapeHtml(sourceParts.slice(1).join(' '))}</span>`;
                        }
                    }
                }

                if (noteParts.length > 0) {
                    const noteJoined = noteParts.join(' ');
                    if (noteJoined.toLowerCase().includes('jalan tol') || noteJoined.toLowerCase().includes('toll road') || noteJoined.includes('1688/KPTS/M/2022')) {
                        extractedNote = `
                            <div class="space-y-1">
                                <div>1. Data tidak termasuk panjang jalan tol / <span class="italic text-slate-500">Excluding toll road</span></div>
                                <div>2. Data tahun 2023 berdasarkan Keputusan Menteri Pekerjaan Umum dan Perumahan Rakyat No. 1688/KPTS/M/2022 / <span class="italic text-slate-500">Data of 2023 based on Public Works and Public Housing Ministerial Decree No. 1688/KPTS/M/2022</span></div>
                            </div>
                        `;
                    } else {
                        extractedNote = `<div class="space-y-1">${noteParts.map(p => `<div>${escapeHtml(p)}</div>`).join('')}</div>`;
                    }
                }
            }

            const activeRowLimit = footerStartIdx !== -1 ? footerStartIdx : rawRows.length;

            // 2. Helper to check numbering rows like (1), (2), (3) or -1, -2, -3 or 1, 2, 3
            function isNumberingCell(val) {
                if (val === null || val === undefined) return false;
                const s = val.toString().trim();
                return /^\s*\(\s*\d+\s*\)\s*$/.test(s) || 
                       /^\s*-\s*\d+\s*-?\s*$/.test(s) || 
                       /^\s*\d+\s*$/.test(s) || 
                       s.toLowerCase() === 'no';
            }

            function isNumberingRow(row) {
                if (!Array.isArray(row)) return false;
                const nonEmpties = row.map(c => (c || '').toString().trim()).filter(c => c !== '');
                if (nonEmpties.length === 0) return false;
                const hasParensOrDash = nonEmpties.some(c => /^\s*\(\s*\d+\s*\)\s*$/.test(c) || /^\s*-\s*\d+\s*-?\s*$/.test(c));
                const allNumOrNo = nonEmpties.every(c => isNumberingCell(c));
                const isSequential = nonEmpties.length >= 2 && nonEmpties.every((c, idx) => {
                    const num = parseInt(c.replace(/[^\d]/g, ''), 10);
                    return num === idx + 1;
                });
                return (hasParensOrDash && allNumOrNo) || isSequential;
            }

            // 3. Detect Title rows from the top (Tabel 1.1.6, Table, etc.)
            let titleId = '';
            let titleEn = '';
            let contentStartRowIdx = 0;

            for (let i = 0; i < activeRowLimit; i++) {
                const row = rawRows[i] || [];
                const nonEmpties = row.map(c => (c || '').toString().trim()).filter(c => c !== '');
                if (nonEmpties.length === 0) {
                    if (contentStartRowIdx === i) contentStartRowIdx = i + 1;
                    continue;
                }

                const c0 = (row[0] || '').toString().trim();
                const c1 = (row[1] || '').toString().trim();
                const rowStr = nonEmpties.join(' ').toLowerCase();

                // If row contains "Tabel ..." or "Table" or "Badan Pusat Statistik"
                if (/^tabel\b/i.test(c0) || /^table\b/i.test(c0) || c0.toLowerCase() === 'tabel' || c0.toLowerCase() === 'table' || rowStr.includes('badan pusat statistik')) {
                    if (/^tabel\b/i.test(c0) || c0.toLowerCase() === 'tabel') {
                        titleId = c1 || nonEmpties.slice(1).join(' ') || c0;
                    } else if (/^table\b/i.test(c0) || c0.toLowerCase() === 'table') {
                        titleEn = c1 || nonEmpties.slice(1).join(' ') || c0;
                    }
                    contentStartRowIdx = i + 1;
                    continue;
                }

                // If single cell title row before headers
                if (nonEmpties.length === 1 && !isNumberingCell(nonEmpties[0])) {
                    if (!titleId) {
                        titleId = nonEmpties[0];
                    } else if (!titleEn) {
                        titleEn = nonEmpties[0];
                    }
                    contentStartRowIdx = i + 1;
                    continue;
                }

                // Reached table header
                contentStartRowIdx = i;
                break;
            }

            // Auto-swap jika titleId terbalik dengan titleEn dari Excel
            if (titleId && titleEn) {
                const idHasEnglish = /\b(Actual|Number|Length|Population|Government|Expenditures|Revenues|Percentage|District|Kind of)\b/i.test(titleId);
                const enHasIndo = /\b(Realisasi|Jumlah|Panjang|Penduduk|Pemerintah|Belanja|Pendapatan|Menurut|Jenis|Kecamatan|Banyaknya)\b/i.test(titleEn);
                if (idHasEnglish && enHasIndo) {
                    const temp = titleId;
                    titleId = titleEn;
                    titleEn = temp;
                }
            }

            // 4. Find Numbering Row and Header Rows
            let numberingRowIdx = -1;
            for (let i = contentStartRowIdx; i < activeRowLimit; i++) {
                if (isNumberingRow(rawRows[i])) {
                    numberingRowIdx = i;
                    break;
                }
            }

            let headerRowIndices = [];
            let dataRowIndices = [];

            if (numberingRowIdx !== -1) {
                // Header rows are between contentStartRowIdx and numberingRowIdx
                for (let i = contentStartRowIdx; i < numberingRowIdx; i++) {
                    const nonEmpties = (rawRows[i] || []).filter(c => c !== null && c !== undefined && c.toString().trim() !== '');
                    if (nonEmpties.length > 0) headerRowIndices.push(i);
                }
                // Data rows are after numberingRowIdx up to activeRowLimit
                for (let i = numberingRowIdx + 1; i < activeRowLimit; i++) {
                    const nonEmpties = (rawRows[i] || []).filter(c => c !== null && c !== undefined && c.toString().trim() !== '');
                    if (nonEmpties.length > 0) dataRowIndices.push(i);
                }
            } else {
                // Fallback: first non-empty row is header, subsequent are data
                let foundHeader = false;
                for (let i = contentStartRowIdx; i < activeRowLimit; i++) {
                    const nonEmpties = (rawRows[i] || []).filter(c => c !== null && c !== undefined && c.toString().trim() !== '');
                    if (nonEmpties.length > 0) {
                        if (!foundHeader) {
                            headerRowIndices.push(i);
                            foundHeader = true;
                        } else {
                            dataRowIndices.push(i);
                        }
                    }
                }
            }

            if (headerRowIndices.length === 0 || dataRowIndices.length === 0) {
                alert('Tidak dapat mendeteksi struktur kolom atau baris data pada berkas Excel.');
                return;
            }

            // 5. Calculate max columns strictly from table rows (headers and data)
            let maxCols = 0;
            headerRowIndices.concat(dataRowIndices).forEach(rIdx => {
                const row = rawRows[rIdx] || [];
                for (let c = 0; c < row.length; c++) {
                    if (row[c] !== null && row[c] !== undefined && row[c].toString().trim() !== '') {
                        maxCols = Math.max(maxCols, c + 1);
                    }
                }
            });

            // Only merges within table rows where data is actually present should expand columns
            const tableMerges = merges.filter(m => m.s.r >= headerRowIndices[0] && m.s.r <= dataRowIndices[dataRowIndices.length - 1]);
            tableMerges.forEach(m => {
                const anyDataInSpan = dataRowIndices.some(dIdx => {
                    const dRow = rawRows[dIdx] || [];
                    for (let checkC = m.s.c + 1; checkC <= m.e.c; checkC++) {
                        if (dRow[checkC] !== null && dRow[checkC] !== undefined && dRow[checkC].toString().trim() !== '') {
                            return true;
                        }
                    }
                    return false;
                });
                if (anyDataInSpan && m.e.c + 1 > maxCols) {
                    maxCols = m.e.c + 1;
                }
            });

            // Trim any trailing columns where ALL data rows and headers are completely empty
            while (maxCols > 1) {
                const colIdx = maxCols - 1;
                const colHasData = dataRowIndices.some(dIdx => {
                    const dRow = rawRows[dIdx] || [];
                    const v = dRow[colIdx];
                    return v !== null && v !== undefined && v.toString().trim() !== '';
                });
                const colHasHeader = headerRowIndices.some(hIdx => {
                    const hRow = rawRows[hIdx] || [];
                    const v = hRow[colIdx];
                    return v !== null && v !== undefined && v.toString().trim() !== '';
                });
                if (!colHasData && !colHasHeader) {
                    maxCols--;
                } else {
                    break;
                }
            }
            if (maxCols === 0) maxCols = 3;

            // Merge helper function
            function getCellMerge(r, c) {
                if (!merges || !merges.length) return null;
                for (let m of merges) {
                    if (r >= m.s.r && r <= m.e.r && c >= m.s.c && c <= m.e.c) {
                        return {
                            isOrigin: (r === m.s.r && c === m.s.c),
                            rowspan: m.e.r - m.s.r + 1,
                            colspan: m.e.c - m.s.c + 1
                        };
                    }
                }
                return null;
            }

            // Format bilingual header: Indonesian (bold) / English (italic)
            function formatHeaderContent(val) {
                const str = (val || '').toString().trim();
                if (!str) return '';
                if (str.includes('/')) {
                    const parts = str.split('/');
                    const id = parts[0].trim();
                    const en = parts.slice(1).join('/').trim();
                    return `<div>${escapeHtml(id)}</div><div class="italic font-normal text-[11px] sm:text-xs">${escapeHtml(en)}</div>`;
                }
                return `<div>${escapeHtml(str)}</div>`;
            }

            // 6. Build the table HTML with smart year detection for Table 8.1.1 (multi-year)
            const yr = parseInt(currentYear) || 2025;
            const schema = tableSchemas[currentTableCode];

            // Scan only header rows (headerRowIndices) for 4-digit years (jangan memindai baris judul di rIdx 0!)
            const excelYearColMap = {};
            let hasYearColumnsInExcel = false;
            headerRowIndices.forEach(rIdx => {
                const row = rawRows[rIdx] || [];
                for (let c = 0; c < maxCols; c++) {
                    const cellStr = (row[c] || '').toString().trim();
                    const match = cellStr.match(/\b(20\d{2}|19\d{2})\b/);
                    if (match) {
                        const y = parseInt(match[1], 10);
                        if (!excelYearColMap[y]) {
                            excelYearColMap[y] = c;
                            hasYearColumnsInExcel = true;
                        }
                    }
                }
            });

            // KHUSUS TABEL 1.1.6: Format Resmi Standar BPS (Nama Sungai, Lebar, No, Kecamatan yang Dilalui)
            if (currentTableCode === '1.1.6') {
                theadHtml = `<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700 w-[38%]">
                            <div>Nama Sungai (Batang)</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Name of The River</div>
                        </th>
                        <th class="py-3 px-4 font-bold border border-slate-700 w-[18%]">
                            <div>Lebar (M)</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Width (M)</div>
                        </th>
                        <th class="py-3 px-4 font-bold border border-slate-700 w-[44%]" colspan="2">
                            <div>Kecamatan yang Dilalui</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">District Its Pass</div>
                        </th>
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                        <th class="py-1 px-2 border border-slate-700 text-center w-12">No</th>
                        <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                    </tr>
                </thead>`;

                let rivers = [];
                let currentRiver = null;

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const c0 = (row[0] !== null && row[0] !== undefined) ? row[0].toString().trim() : '';
                    const c1 = (row[1] !== null && row[1] !== undefined) ? row[1].toString().trim() : '';
                    const c2 = (row[2] !== null && row[2] !== undefined) ? row[2].toString().trim() : '';
                    // Abaikan baris kosong atau yang seluruh isinya hanya strip (-)
                    const meaningfulCells = [c0, c1, c2, c3].filter(c => c !== '' && c !== '-' && c !== '–' && c !== '—');
                    if (meaningfulCells.length === 0) return;
                    if (c0.toLowerCase().startsWith('sumber') || c0.toLowerCase().startsWith('catatan')) return;

                    // Khusus 1.1.6: Hanya izinkan sungai resmi (Batang Tambuo dan Batang Sianok)
                    if (c0 && c0 !== '-') {
                        const c0Lower = c0.toLowerCase();
                        if (!c0Lower.includes('tambuo') && !c0Lower.includes('sianok')) {
                            return;
                        }
                    }

                    if (c0 && c0 !== '-' && (!currentRiver || currentRiver.name.toLowerCase() !== c0.toLowerCase())) {
                        currentRiver = {
                            name: c0,
                            width: c1 || '-',
                            items: []
                        };
                        rivers.push(currentRiver);
                    }

                    if (!currentRiver) {
                        currentRiver = {
                            name: c0 || 'Sungai',
                            width: c1 || '-',
                            items: []
                        };
                        rivers.push(currentRiver);
                    } else if (c1 && (currentRiver.width === '-' || currentRiver.width === '')) {
                        currentRiver.width = c1;
                    }

                    let itemNo = '';
                    let itemKecamatan = '';

                    if (c3) {
                        itemNo = (c2 && c2 !== '-' && c2 !== '–' && c2 !== '—') ? c2 : (currentRiver.items.length + 1).toString();
                        itemKecamatan = c3;
                    } else if (c2) {
                        const m = c2.match(/^(\d+)\.?\s*(.*)$/);
                        if (m && m[2]) {
                            itemNo = m[1];
                            itemKecamatan = m[2];
                        } else {
                            itemNo = (currentRiver.items.length + 1).toString();
                            itemKecamatan = c2;
                        }
                    }

                    if (itemKecamatan) {
                        currentRiver.items.push({ no: itemNo, kecamatan: itemKecamatan });
                    }
                });

                if (rivers.length === 0) {
                    rivers.push({
                        name: '01. Batang Tambuo',
                        width: '-',
                        items: [
                            { no: '1', kecamatan: 'Aur Birugo Tigo Baleh' },
                            { no: '2', kecamatan: 'Mandiangin Koto Selayan' }
                        ]
                    });
                } else {
                    rivers.forEach(r => {
                        if (r.items.length === 0) {
                            r.items.push({ no: '1', kecamatan: '-' });
                        }
                    });
                }

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
                rivers.forEach(r => {
                    const rowSpan = r.items.length;
                    r.items.forEach((item, idx) => {
                        tbodyHtml += `<tr class="hover:bg-amber-100/60 transition-colors">`;
                        if (idx === 0) {
                            tbodyHtml += `
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 align-middle" rowspan="${rowSpan}">
                                    ${escapeHtml(r.name)}
                                </td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-middle" rowspan="${rowSpan}">
                                    ${escapeHtml(r.width)}
                                </td>
                            `;
                        }
                        tbodyHtml += `
                            <td class="py-2 px-2 text-center border border-slate-700 font-bold">
                                ${escapeHtml(item.no)}
                            </td>
                            <td class="py-2 px-4 border border-slate-700 font-medium">
                                ${escapeHtml(item.kecamatan)}
                            </td>
                        </tr>`;
                    });
                });
                tbodyHtml += '</tbody>';

                titleId = `Nama Sungai/Batang, Lebar dan Kecamatan yang Dilalui di Kota Bukittinggi, ${currentYear}`;
                titleEn = `Name, Width of The River and District Its Pass in Bukittinggi, ${currentYear}`;
            } else if (currentTableCode === '8.1.4') {
                theadHtml = `<thead>
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
                </thead>`;

                let kecData = {
                    'guguk_panjang': { name: '01. GUGUK PANJANG', unit: '-', len: '-' },
                    'mandiangin_koto_selayan': { name: '02. MANDIANGIN KOTO SELAYAN', unit: '-', len: '-' },
                    'aur_birugo_tigo_baleh': { name: '03. AUR BIRUGO TIGO BALEH', unit: '-', len: '-' }
                };
                let jumlahEntries = [];
                const excelDataByYear = {};

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase();
                    if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan')) return;

                    const cells = [];
                    for (let c = 0; c < row.length; c++) {
                        const v = row[c];
                        if (v !== null && v !== undefined && v.toString().trim() !== '') {
                            cells.push({ col: c, val: v.toString().trim() });
                        }
                    }
                    if (cells.length === 0) return;

                    // 1. Detect Kecamatan row
                    if (rowStr.includes('guguk')) {
                        const nums = cells.filter(x => !x.val.toLowerCase().includes('guguk') && !x.val.toLowerCase().includes('panjang'));
                        if (nums.length >= 2) {
                            let u = nums[0].val;
                            let l = nums[1].val;
                            if (/^\d+\.\d+$/.test(l)) l = l.replace('.', ',');
                            kecData['guguk_panjang'].unit = u;
                            kecData['guguk_panjang'].len = l;
                        }
                    } else if (rowStr.includes('mandiangin')) {
                        const nums = cells.filter(x => !x.val.toLowerCase().includes('mandiangin') && !x.val.toLowerCase().includes('koto'));
                        if (nums.length >= 2) {
                            let u = nums[0].val;
                            let l = nums[1].val;
                            if (/^\d+\.\d+$/.test(l)) l = l.replace('.', ',');
                            kecData['mandiangin_koto_selayan'].unit = u;
                            kecData['mandiangin_koto_selayan'].len = l;
                        }
                    } else if (rowStr.includes('aur birugo') || rowStr.includes('tigo baleh') || rowStr.includes('birugo')) {
                        const nums = cells.filter(x => !x.val.toLowerCase().includes('aur') && !x.val.toLowerCase().includes('birugo'));
                        if (nums.length >= 2) {
                            let u = nums[0].val;
                            let l = nums[1].val;
                            if (/^\d+\.\d+$/.test(l)) l = l.replace('.', ',');
                            kecData['aur_birugo_tigo_baleh'].unit = u;
                            kecData['aur_birugo_tigo_baleh'].len = l;
                        }
                    }

                    // 2. Detect Year row in Jumlah section
                    let rowYear = null;
                    cells.forEach(cell => {
                        const m = cell.val.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m && !rowYear) {
                            rowYear = parseInt(m[1], 10);
                        }
                    });

                    if (rowYear) {
                        const valCells = cells.filter(x => x.val !== rowYear.toString() && !x.val.toLowerCase().includes('jumlah') && !x.val.toLowerCase().includes('total'));
                        let u = valCells.length > 0 ? valCells[0].val : '-';
                        let l = valCells.length > 1 ? valCells[1].val : '-';
                        if (/^\d+\.\d+$/.test(l)) l = l.replace('.', ',');
                        jumlahEntries.push({ year: rowYear, unit: u, len: l });

                        if (!excelDataByYear[rowYear]) excelDataByYear[rowYear] = {};
                        excelDataByYear[rowYear]['total_unit'] = u;
                        excelDataByYear[rowYear]['total_panjang'] = l;
                    }
                });

                const p814 = get5YearPeriod(currentYear);
                const expectedYears = p814.yearsDesc;
                const normalizedJumlahEntries = [];
                expectedYears.forEach(y => {
                    const found = jumlahEntries.find(e => e.year === y);
                    if (found) {
                        normalizedJumlahEntries.push(found);
                    } else {
                        const existing = (excelDataByYear[y]) ? excelDataByYear[y] : {};
                        normalizedJumlahEntries.push({
                            year: y,
                            unit: existing['total_unit'] || '-',
                            len: existing['total_panjang'] || '-'
                        });
                    }
                });
                jumlahEntries = normalizedJumlahEntries;

                // Simpan kecamatan ke tahun aktif
                const actYr = parseInt(currentYear) || 2025;
                if (!excelDataByYear[actYr]) excelDataByYear[actYr] = {};
                excelDataByYear[actYr]['guguk_panjang_unit'] = kecData['guguk_panjang'].unit;
                excelDataByYear[actYr]['guguk_panjang_panjang'] = kecData['guguk_panjang'].len;
                excelDataByYear[actYr]['mandiangin_koto_selayan_unit'] = kecData['mandiangin_koto_selayan'].unit;
                excelDataByYear[actYr]['mandiangin_koto_selayan_panjang'] = kecData['mandiangin_koto_selayan'].len;
                excelDataByYear[actYr]['aur_birugo_tigo_baleh_unit'] = kecData['aur_birugo_tigo_baleh'].unit;
                excelDataByYear[actYr]['aur_birugo_tigo_baleh_panjang'] = kecData['aur_birugo_tigo_baleh'].len;

                window.uploadedExcelDataByYear = excelDataByYear;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
                ['guguk_panjang', 'mandiangin_koto_selayan', 'aur_birugo_tigo_baleh'].forEach(k => {
                    const item = kecData[k];
                    tbodyHtml += `
                        <tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">
                                ${escapeHtml(item.name)}
                            </td>
                            <td class="py-2.5 px-4 text-center border border-slate-700">${escapeHtml(item.unit)}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700">${escapeHtml(item.len)}</td>
                        </tr>
                    `;
                });

                jumlahEntries.forEach((entry, idx) => {
                    tbodyHtml += `<tr class="hover:bg-amber-100/60 transition-colors">`;
                    if (idx === 0) {
                        tbodyHtml += `
                            <td class="py-2.5 px-4 font-bold border border-slate-700 text-center align-middle bg-amber-50/70" rowspan="${jumlahEntries.length}">
                                <div>Jumlah</div>
                                <div class="italic font-normal text-xs text-slate-600">Total</div>
                            </td>
                        `;
                    }
                    tbodyHtml += `
                        <td class="py-2 px-3 font-bold border border-slate-700 text-center">${entry.year}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 ${idx === 0 ? 'font-semibold' : ''}">${escapeHtml(entry.unit)}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 ${idx === 0 ? 'font-semibold' : ''}">${escapeHtml(entry.len)}</td>
                    </tr>`;
                });
                tbodyHtml += '</tbody>';

                titleId = `Banyak dan Panjang Jembatan, Panjang Trotoar Kota Bukittinggi, ${currentYear}`;
                titleEn = `Number and Length of Bridge, Length of Sidewalk in Bukittinggi, ${currentYear}`;
            } else if (currentTableCode === '8.1.5') {
                theadHtml = `<thead>
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
                </thead>`;

                let kecData = {
                    'guguk_panjang': { name: '01. GUGUK PANJANG', val: '-' },
                    'mandiangin_koto_selayan': { name: '02. MANDIANGIN KOTO SELAYAN', val: '-' },
                    'aur_birugo_tigo_baleh': { name: '03. AUR BIRUGO TIGO BALEH', val: '-' }
                };
                let jumlahEntries = [];
                const excelDataByYear = {};

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase();
                    if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan')) return;

                    const cells = [];
                    for (let c = 0; c < row.length; c++) {
                        const v = row[c];
                        if (v !== null && v !== undefined && v.toString().trim() !== '') {
                            cells.push({ col: c, val: v.toString().trim() });
                        }
                    }
                    if (cells.length === 0) return;

                    // 1. Detect Kecamatan row
                    if (rowStr.includes('guguk')) {
                        const nums = cells.filter(x => !x.val.toLowerCase().includes('guguk') && !x.val.toLowerCase().includes('panjang'));
                        if (nums.length >= 1) {
                            let v = nums[0].val;
                            if (/^\d+\.\d+$/.test(v)) v = v.replace('.', ',');
                            kecData['guguk_panjang'].val = v;
                        }
                    } else if (rowStr.includes('mandiangin')) {
                        const nums = cells.filter(x => !x.val.toLowerCase().includes('mandiangin') && !x.val.toLowerCase().includes('koto'));
                        if (nums.length >= 1) {
                            let v = nums[0].val;
                            if (/^\d+\.\d+$/.test(v)) v = v.replace('.', ',');
                            kecData['mandiangin_koto_selayan'].val = v;
                        }
                    } else if (rowStr.includes('aur birugo') || rowStr.includes('tigo baleh') || rowStr.includes('birugo')) {
                        const nums = cells.filter(x => !x.val.toLowerCase().includes('aur') && !x.val.toLowerCase().includes('birugo'));
                        if (nums.length >= 1) {
                            let v = nums[0].val;
                            if (/^\d+\.\d+$/.test(v)) v = v.replace('.', ',');
                            kecData['aur_birugo_tigo_baleh'].val = v;
                        }
                    }

                    // 2. Detect Year row in Jumlah section
                    let rowYear = null;
                    cells.forEach(cell => {
                        const m = cell.val.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m && !rowYear) {
                            rowYear = parseInt(m[1], 10);
                        }
                    });

                    if (rowYear) {
                        const valCells = cells.filter(x => x.val !== rowYear.toString() && !x.val.toLowerCase().includes('jumlah') && !x.val.toLowerCase().includes('total'));
                        let v = valCells.length > 0 ? valCells[0].val : '-';
                        if (/^\d+\.\d+$/.test(v)) v = v.replace('.', ',');
                        jumlahEntries.push({ year: rowYear, val: v });

                        if (!excelDataByYear[rowYear]) excelDataByYear[rowYear] = {};
                        excelDataByYear[rowYear]['total'] = v;
                    }
                });

                const p815 = get5YearPeriod(currentYear);
                const expectedYears815 = p815.yearsDesc;
                const normalizedJumlahEntries815 = [];
                expectedYears815.forEach(y => {
                    const found = jumlahEntries.find(e => e.year === y);
                    normalizedJumlahEntries815.push(found || { year: y, val: '-' });
                });
                jumlahEntries = normalizedJumlahEntries815;

                // Simpan kecamatan ke tahun aktif
                const actYr = parseInt(currentYear) || 2025;
                if (!excelDataByYear[actYr]) excelDataByYear[actYr] = {};
                excelDataByYear[actYr]['guguk_panjang'] = kecData['guguk_panjang'].val;
                excelDataByYear[actYr]['mandiangin_koto_selayan'] = kecData['mandiangin_koto_selayan'].val;
                excelDataByYear[actYr]['aur_birugo_tigo_baleh'] = kecData['aur_birugo_tigo_baleh'].val;

                window.uploadedExcelDataByYear = excelDataByYear;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
                ['guguk_panjang', 'mandiangin_koto_selayan', 'aur_birugo_tigo_baleh'].forEach(k => {
                    const item = kecData[k];
                    tbodyHtml += `
                        <tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left" colspan="2">
                                ${escapeHtml(item.name)}
                            </td>
                            <td class="py-2.5 px-4 text-center border border-slate-700">${escapeHtml(item.val)}</td>
                        </tr>
                    `;
                });

                jumlahEntries.forEach((entry, idx) => {
                    tbodyHtml += `<tr class="hover:bg-amber-100/60 transition-colors">`;
                    if (idx === 0) {
                        tbodyHtml += `
                            <td class="py-2.5 px-4 font-bold border border-slate-700 text-center align-middle bg-amber-50/70" rowspan="${jumlahEntries.length}">
                                <div>Jumlah</div>
                                <div class="italic font-normal text-xs text-slate-600">Total</div>
                            </td>
                        `;
                    }
                    tbodyHtml += `
                        <td class="py-2 px-3 font-bold border border-slate-700 text-center">${entry.year}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 ${idx === 0 ? 'font-semibold' : ''}">${escapeHtml(entry.val)}</td>
                    </tr>`;
                });
                tbodyHtml += '</tbody>';

                titleId = `Panjang Gorong–Gorong dan Panjang Drainase Kota Bukittinggi, ${p815.label}`;
                titleEn = `Length of Sewerage and Drainage in Bukittinggi, ${p815.label}`;
            } else if (currentTableCode === '8.1.1') {
                const targetYears = [yr - 4, yr - 3, yr - 2, yr - 1, yr];
                const roadRange = `${yr - 4}–${yr}`;

                theadHtml = `<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle">
                            <div>Tingkat Kewenangan Pemerintahan</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Level of Government Authority</div>
                        </th>
                        ${targetYears.map(y => `<th class="py-3 px-4 border border-slate-700 text-center ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}">${y}</th>`).join('')}
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                        ${targetYears.map((y, idx) => `<th class="py-1 px-3 border border-slate-700 text-center">(${idx + 2})</th>`).join('')}
                    </tr>
                </thead>`;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';

                // Find label/kategori column (first column not used as year column)
                let kategoriCol = 0;
                for (let c = 0; c < maxCols; c++) {
                    if (!Object.values(excelYearColMap).includes(c)) {
                        kategoriCol = c;
                        break;
                    }
                }

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const firstCell = (row[kategoriCol] || '').toString().trim();
                    if (!firstCell) return;

                    const isTotalRow = firstCell.toLowerCase().includes('jumlah') || firstCell.toLowerCase().includes('total');
                    const rowClass = isTotalRow ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';

                    tbodyHtml += `<tr class="${rowClass}">`;

                    let labelHtml = escapeHtml(firstCell);
                    if (firstCell.includes('/') && !firstCell.includes('<span')) {
                        const parts = firstCell.split('/');
                        labelHtml = `${escapeHtml(parts[0].trim())} / <span class="${isTotalRow ? 'italic font-bold' : 'italic font-normal text-slate-700'}">${escapeHtml(parts.slice(1).join('/').trim())}</span>`;
                    }

                    tbodyHtml += `<td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">${labelHtml}</td>`;

                    targetYears.forEach((y, yIdx) => {
                        let val = '-';
                        if (excelYearColMap[y] !== undefined) {
                            const raw = row[excelYearColMap[y]];
                            if (raw !== null && raw !== undefined && raw.toString().trim() !== '') {
                                val = raw.toString().trim();
                            }
                        } else {
                            const fallbackCol = kategoriCol + 1 + yIdx;
                            const raw = row[fallbackCol];
                            if (raw !== null && raw !== undefined && raw.toString().trim() !== '') {
                                val = raw.toString().trim();
                            }
                        }
                        const isNum = !isNaN(parseFloat(val.replace(',', '.'))) || /^\d+\s*[-–]\s*\d+$/.test(val);
                        const alignClass = isNum ? `text-center ${isTotalRow ? 'font-extrabold' : ''}` : 'text-center';
                        const displayVal = val === '-' ? '<span class="text-slate-400 font-normal">-</span>' : escapeHtml(val);
                        tbodyHtml += `<td class="py-2.5 px-3 border border-slate-700 ${alignClass} ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${displayVal}</td>`;
                    });

                    tbodyHtml += `</tr>`;
                });

                tbodyHtml += '</tbody>';

                // Automatically set clean bilingual title matching the 5-year range
                titleId = `Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi (km), ${roadRange}`;
                titleEn = `Length of Road by Level of Government Authority in Bukittinggi Municipality (km), ${roadRange}`;
            } else if (currentTableCode === '8.1.2') {
                const targetYears = [yr - 4, yr - 3, yr - 2, yr - 1, yr];
                const roadRange = `${yr - 4}–${yr}`;

                theadHtml = `<thead>
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
                        ${targetYears.map(y => `<th class="py-2 px-3 border border-slate-700 ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}">${y}</th>`).join('')}
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700">(1)</th>
                        ${targetYears.map((y, idx) => `<th class="py-1 px-3 border border-slate-700">(${idx + 2})</th>`).join('')}
                    </tr>
                </thead>`;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';

                let kategoriCol = 0;
                for (let c = 0; c < maxCols; c++) {
                    if (!Object.values(excelYearColMap).includes(c)) {
                        kategoriCol = c;
                        break;
                    }
                }

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const firstCell = (row[kategoriCol] || '').toString().trim();
                    if (!firstCell) return;

                    const isTotalRow = firstCell.toLowerCase().includes('jumlah') || firstCell.toLowerCase().includes('total');
                    const rowClass = isTotalRow ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';

                    tbodyHtml += `<tr class="${rowClass}">`;

                    let labelHtml = escapeHtml(firstCell);
                    if (firstCell.includes('/') && !firstCell.includes('<span')) {
                        const parts = firstCell.split('/');
                        labelHtml = `${escapeHtml(parts[0].trim())} / <span class="${isTotalRow ? 'italic font-bold' : 'italic font-normal text-slate-700'}">${escapeHtml(parts.slice(1).join('/').trim())}</span>`;
                    }

                    tbodyHtml += `<td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">${labelHtml}</td>`;

                    targetYears.forEach((y, yIdx) => {
                        let val = '-';
                        if (excelYearColMap[y] !== undefined) {
                            const raw = row[excelYearColMap[y]];
                            if (raw !== null && raw !== undefined && raw.toString().trim() !== '') {
                                val = raw.toString().trim();
                                // Normalisasi format angka desimal Excel (. ke ,)
                                if (/^\d+\.\d+$/.test(val)) {
                                    val = val.replace('.', ',');
                                }
                            }
                        } else {
                            const fallbackCol = kategoriCol + 1 + yIdx;
                            const raw = row[fallbackCol];
                            if (raw !== null && raw !== undefined && raw.toString().trim() !== '') {
                                val = raw.toString().trim();
                                if (/^\d+\.\d+$/.test(val)) {
                                    val = val.replace('.', ',');
                                }
                            } else if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) {
                                const rKey = firstCell.toLowerCase().includes('aspal') ? 'aspal' : 
                                            (firstCell.toLowerCase().includes('kerikil') ? 'kerikil' : 
                                            (firstCell.toLowerCase().includes('tanah') ? 'tanah' : 
                                            (firstCell.toLowerCase().includes('lainnya') ? 'lainnya' : 'total')));
                                if (serverDbDataStore[y][rKey]) {
                                    val = serverDbDataStore[y][rKey];
                                }
                            }
                        }
                        const isDash = (val === '-' || val === '–' || val === '—' || val === '');
                        const alignClass = isTotalRow ? 'text-center font-extrabold' : 'text-center';
                        const displayVal = isDash ? '<span class="text-slate-400 font-normal">-</span>' : escapeHtml(val);
                        tbodyHtml += `<td class="py-2.5 px-3 border border-slate-700 ${alignClass} align-middle ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${displayVal}</td>`;
                    });

                    tbodyHtml += `</tr>`;
                });

                tbodyHtml += '</tbody>';

                titleId = `Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi (km), ${roadRange}`;
                titleEn = `Length of Roads by Type of Road Surface in Bukittinggi Municipality (km), ${roadRange}`;
            } else if (currentTableCode === '8.1.3') {
                const targetYears = [yr - 4, yr - 3, yr - 2, yr - 1, yr];
                const roadRange = `${yr - 4}–${yr}`;

                theadHtml = `<thead>
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
                        ${targetYears.map(y => `<th class="py-2 px-3 border border-slate-700 ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}">${y}</th>`).join('')}
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700">(1)</th>
                        ${targetYears.map((y, idx) => `<th class="py-1 px-3 border border-slate-700">(${idx + 2})</th>`).join('')}
                    </tr>
                </thead>`;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';

                let kategoriCol = 0;
                for (let c = 0; c < maxCols; c++) {
                    if (!Object.values(excelYearColMap).includes(c)) {
                        kategoriCol = c;
                        break;
                    }
                }

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const firstCell = (row[kategoriCol] || '').toString().trim();
                    if (!firstCell) return;

                    const isTotalRow = firstCell.toLowerCase().includes('jumlah') || firstCell.toLowerCase().includes('total');
                    const rowClass = isTotalRow ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';

                    tbodyHtml += `<tr class="${rowClass}">`;

                    let labelHtml = escapeHtml(firstCell);
                    if (firstCell.includes('/') && !firstCell.includes('<span')) {
                        const parts = firstCell.split('/');
                        labelHtml = `${escapeHtml(parts[0].trim())} / <span class="${isTotalRow ? 'italic font-bold' : 'italic font-normal text-slate-700'}">${escapeHtml(parts.slice(1).join('/').trim())}</span>`;
                    }

                    tbodyHtml += `<td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">${labelHtml}</td>`;

                    targetYears.forEach((y, yIdx) => {
                        let val = '-';
                        if (excelYearColMap[y] !== undefined) {
                            const raw = row[excelYearColMap[y]];
                            if (raw !== null && raw !== undefined && raw.toString().trim() !== '') {
                                val = raw.toString().trim();
                                if (/^\d+\.\d+$/.test(val)) {
                                    val = val.replace('.', ',');
                                }
                            }
                        } else {
                            const fallbackCol = kategoriCol + 1 + yIdx;
                            const raw = row[fallbackCol];
                            if (raw !== null && raw !== undefined && raw.toString().trim() !== '') {
                                val = raw.toString().trim();
                                if (/^\d+\.\d+$/.test(val)) {
                                    val = val.replace('.', ',');
                                }
                            } else if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) {
                                const fLower = firstCell.toLowerCase();
                                const rKey = fLower.includes('baik') ? 'baik' :
                                            (fLower.includes('sedang') ? 'sedang' :
                                            (fLower.includes('berat') ? 'rusak_berat' :
                                            (fLower.includes('rusak') ? 'rusak' : 'total')));
                                if (serverDbDataStore[y][rKey]) {
                                    val = serverDbDataStore[y][rKey];
                                }
                            }
                        }
                        const isDash = (val === '-' || val === '–' || val === '—' || val === '');
                        const alignClass = isTotalRow ? 'text-center font-extrabold' : 'text-center';
                        const displayVal = isDash ? '<span class="text-slate-400 font-normal">-</span>' : escapeHtml(val);
                        tbodyHtml += `<td class="py-2.5 px-3 border border-slate-700 ${alignClass} align-middle ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${displayVal}</td>`;
                    });

                    tbodyHtml += `</tr>`;
                });

                tbodyHtml += '</tbody>';

                titleId = `Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km), ${roadRange}`;
                titleEn = `Length of Road by Condition of Road in Bukittinggi Municipality (km), ${roadRange}`;
            } else if (currentTableCode === '2.2.5') {
                const targetYears = (yr <= 2025) ? [2021, 2022, 2023, 2024, 2025] : [yr - 4, yr - 3, yr - 2, yr - 1, yr];
                const dprdRange = `${targetYears[0]}–${targetYears[4]}`;

                theadHtml = `<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle">
                            <div>Jenis Keputusan</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Type Of Decision</div>
                        </th>
                        ${targetYears.map(y => `<th class="py-3 px-4 border border-slate-700 text-center ${y === yr ? 'bg-amber-600 font-extrabold ring-1 ring-white/30' : ''}">${y}</th>`).join('')}
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                        ${targetYears.map((y, idx) => `<th class="py-1 px-3 border border-slate-700 text-center">(${idx + 2})</th>`).join('')}
                    </tr>
                </thead>`;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';

                let kategoriCol = 0;
                for (let c = 0; c < maxCols; c++) {
                    if (!Object.values(excelYearColMap).includes(c)) {
                        kategoriCol = c;
                        break;
                    }
                }

                const dprdKeys = [
                    'peraturan_daerah', 'keputusan_dprd', 'keputusan_pimpinan',
                    'pernyataan', 'pernyataan_pendapat', 'resolusi',
                    'dengar_pendapat', 'paripurna_terbuka', 'paripurna_istimewa',
                    'panitia_musyawarah', 'badan_kehormatan', 'badan_anggaran',
                    'panitia_khusus', 'gabungan_komisi', 'rapat_komisi',
                    'turun_lapangan', 'keluar_daerah', 'rapat_kerja',
                    'penyampaian_aspirasi', 'study_banding', 'reses',
                    'kunker_komisi'
                ];

                const excelDataByYear = {};

                let keyIndex = 0;
                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const firstCell = (row[kategoriCol] || '').toString().trim();
                    if (!firstCell) return;

                    // Abaikan baris header atau metadata yang tidak sengaja terbaca
                    if (firstCell.startsWith('-') || firstCell.toLowerCase().startsWith('sumber') || firstCell.toLowerCase().startsWith('catatan')) {
                        return;
                    }

                    // PENTING: Pengguna tidak meminta baris jumlah, jangan tambahkan baris jumlah/total
                    if (firstCell.toLowerCase().includes('jumlah') || firstCell.toLowerCase().includes('total')) {
                        return;
                    }

                    const mNum = firstCell.match(/^0?(\d+)/);
                    let rowKey = null;
                    if (mNum) {
                        const idx = parseInt(mNum[1], 10) - 1;
                        if (dprdKeys[idx]) rowKey = dprdKeys[idx];
                    }
                    if (!rowKey && dprdKeys[keyIndex]) {
                        rowKey = dprdKeys[keyIndex];
                    }
                    keyIndex++;

                    tbodyHtml += `<tr class="hover:bg-amber-100/60 transition-colors">`;

                    let labelHtml = escapeHtml(firstCell.replace(/\r?\n/g, ' '));
                    tbodyHtml += `<td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">${labelHtml}</td>`;

                    targetYears.forEach((y, yIdx) => {
                        let val = '-';
                        if (excelYearColMap[y] !== undefined) {
                            const raw = row[excelYearColMap[y]];
                            if (raw !== null && raw !== undefined && raw.toString().trim() !== '') {
                                val = raw.toString().trim();
                            }
                        } else {
                            const fallbackCol = kategoriCol + 1 + yIdx;
                            const raw = row[fallbackCol];
                            if (raw !== null && raw !== undefined && raw.toString().trim() !== '') {
                                val = raw.toString().trim();
                            }
                        }
                        const isDash = (val === '-' || val === '–' || val === '—' || val === '');
                        const displayVal = isDash ? '<span class="text-slate-400 font-normal">-</span>' : escapeHtml(val);
                        tbodyHtml += `<td class="py-2.5 px-3 border border-slate-700 text-center ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${displayVal}</td>`;

                        if (rowKey) {
                            if (!excelDataByYear[y]) excelDataByYear[y] = {};
                            excelDataByYear[y][rowKey] = isDash ? '-' : val;
                        }
                    });

                    tbodyHtml += `</tr>`;
                });

                tbodyHtml += '</tbody>';
                window.uploadedExcelDataByYear = excelDataByYear;

                titleId = `Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi, ${dprdRange}`;
                titleEn = `Decrees and Results of Regional House of Representatives Working Meetings in Bukittinggi Municipality, ${dprdRange}`;
            } else if (currentTableCode === '2.3.1' || currentTableCode === '2.3.2') {
                const is232 = (currentTableCode === '2.3.2');
                theadHtml = `<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-4 font-bold border border-slate-700 align-middle text-left" rowspan="2">
                            ${is232 ? '<div>Tingkat Pendidikan</div><div class="italic font-normal text-[11px] sm:text-xs">Educational Level</div>' : '<div>Jabatan</div><div class="italic font-normal text-[11px] sm:text-xs">Occupation</div>'}
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
                </thead>`;

                const rowDefs231 = [
                    { key: 'jpt_utama',     label: 'Jabatan Pimpinan Tinggi Utama / Senior Executives', regex: /\b(jpt\s*utama|tinggi\s*utama|senior\s*executives)\b/i },
                    { key: 'jpt_madya',     label: 'Jabatan Pimpinan Tinggi Madya / Middle Executives', regex: /\b(jpt\s*madya|tinggi\s*madya|middle\s*executives)\b/i },
                    { key: 'jpt_pratama',   label: 'Jabatan Pimpinan Tinggi Pratama / Junior Executives', regex: /\b(jpt\s*pratama|tinggi\s*pratama|junior\s*executives|eselon\s*(ii|2))\b/i },
                    { key: 'administrator', label: 'Administrator / Administrator', regex: /\b(administrator|eselon\s*(iii|3))\b/i },
                    { key: 'pengawas',      label: 'Pengawas / Supervisor', regex: /\b(pengawas|supervisor|eselon\s*(iv|4))\b/i },
                    { key: 'eselon5',       label: 'Eselon V / 5th Echelon', regex: /\b(eselon\s*(v|5)|5th\s*echelon)\b/i },
                    { key: 'dosen',         label: 'Jabatan Fungsional Dosen / Certain Functional Position for Lecturer', regex: /\b(dosen|lecturer)\b/i },
                    { key: 'guru',          label: 'Jabatan Fungsional Guru / Certain Functional Position for Teacher', regex: /\b(guru|teacher)\b/i },
                    { key: 'medis',         label: 'Jabatan Fungsional Medis / Certain Functional Position for Medical Field', regex: /\b(medis|kesehatan|medical)\b/i },
                    { key: 'teknis',        label: 'Jabatan Fungsional Teknis / Certain Functional Position for Technical Field', regex: /\b(teknis|technical)\b/i },
                    { key: 'pelaksana',     label: 'Jabatan Fungsional Umum/Pelaksana / General Functional Position', regex: /\b(pelaksana|umum|general\s*functional)\b/i }
                ];

                const rowDefs232 = [
                    { key: 'sd',   label: 'Sekolah Dasar (SD) / Primary School', regex: /\b(sd|sekolah\s*dasar|primary\s*school)\b/i },
                    { key: 'smp',  label: 'Sekolah Menengah Pertama (SMP) / Junior High School', regex: /\b(smp|menengah\s*pertama|junior\s*high)\b/i },
                    { key: 'sma',  label: 'Sekolah Menengah Atas (SMA) / Senior High School', regex: /\b(sma|smk|menengah\s*atas|senior\s*high)\b/i },
                    { key: 'di',   label: 'Diploma I / Akta I', regex: /\b(diploma\s*(i|1)|akta\s*(i|1)|d[\s\-_.]*(i|1))\b/i },
                    { key: 'dii',  label: 'Diploma II / Akta II', regex: /\b(diploma\s*(ii|2)|akta\s*(ii|2)|d[\s\-_.]*(ii|2))\b/i },
                    { key: 'diii', label: 'Diploma III / Akta III', regex: /\b(diploma\s*(iii|3)|akta\s*(iii|3)|d[\s\-_.]*(iii|3))\b/i },
                    { key: 'div',  label: 'Diploma IV / Akta IV', regex: /\b(diploma\s*(iv|4)|akta\s*(iv|4)|d[\s\-_.]*(iv|4))\b/i },
                    { key: 's1',   label: 'S1 / Sarjana / Under Graduate/Bachelor', regex: /\b(s[\s\-_.]*1|sarjana|under\s*graduate|bachelor)\b/i },
                    { key: 's2',   label: 'S2 / Pasca Sarjana / Graduate', regex: /\b(s[\s\-_.]*2|pasca\s*sarjana|magister|master)\b/i },
                    { key: 's3',   label: 'S3 / Doktor/Ph.D / Post Graduate', regex: /\b(s[\s\-_.]*3|doktor|ph\.?d|post\s*graduate)\b/i }
                ];

                // Prioritas pencocokan untuk menghindari konflik substring (DIV sebelum DI, S3/S2 sebelum S1)
                const matchPriority232 = ['div', 'diii', 'dii', 'di', 's3', 's2', 's1', 'sd', 'smp', 'sma'];

                const rowDefs = is232 ? rowDefs232 : rowDefs231;

                const excelDataByYear = {};
                excelDataByYear[yr] = {};

                const extractedRows = {};
                rowDefs.forEach(r => {
                    extractedRows[r.key] = {
                        label: r.label,
                        pns_l: '-', pns_p: '-', pns_jml: '-',
                        pppk_l: '-', pppk_p: '-', pppk_jml: '-',
                        total_l: '-', total_p: '-', total_jml: '-'
                    };
                });

                let parsedTotalRow = null;

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase();
                    if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan') || rowStr.startsWith('note') || rowStr.startsWith('source')) return;

                    const firstCell = (row[0] || '').toString().trim();
                    const firstCellLower = firstCell.toLowerCase().replace(/\s+/g, ' ');

                    // Cek jika baris total / jumlah
                    if (firstCellLower.includes('jumlah') || firstCellLower.includes('total')) {
                        const vals = [];
                        for (let c = 1; c <= 9; c++) {
                            const v = (row[c] !== null && row[c] !== undefined) ? row[c].toString().trim() : '-';
                            vals.push(v);
                        }
                        parsedTotalRow = vals;
                        return;
                    }

                    // Cocokkan dengan indikator resmi secara aman
                    let matchedKey = null;
                    if (is232) {
                        for (const key of matchPriority232) {
                            const rd = rowDefs232.find(r => r.key === key);
                            if (rd && rd.regex && rd.regex.test(firstCellLower)) {
                                matchedKey = rd.key;
                                break;
                            }
                        }
                    } else {
                        for (const rd of rowDefs231) {
                            if (rd.regex && rd.regex.test(firstCellLower)) {
                                matchedKey = rd.key;
                                break;
                            }
                        }
                    }

                    if (matchedKey) {
                        const cleanVal = (val) => {
                            if (val === null || val === undefined) return '-';
                            const s = val.toString().trim();
                            if (!s || s === '–' || s === '—') return '-';
                            return s;
                        };

                        const pnsL = cleanVal(row[1]);
                        const pnsP = cleanVal(row[2]);
                        let pnsJml = cleanVal(row[3]);
                        const pppkL = cleanVal(row[4]);
                        const pppkP = cleanVal(row[5]);
                        let pppkJml = cleanVal(row[6]);
                        let totL = cleanVal(row[7]);
                        let totP = cleanVal(row[8]);
                        let totJml = cleanVal(row[9]);

                        const nPnsL = parseFloat(pnsL.replace(',', '.')) || 0;
                        const nPnsP = parseFloat(pnsP.replace(',', '.')) || 0;
                        const nPppkL = parseFloat(pppkL.replace(',', '.')) || 0;
                        const nPppkP = parseFloat(pppkP.replace(',', '.')) || 0;

                        if (pnsJml === '-' && (pnsL !== '-' || pnsP !== '-')) pnsJml = (nPnsL + nPnsP).toString();
                        if (pppkJml === '-' && (pppkL !== '-' || pppkP !== '-')) pppkJml = (nPppkL + nPppkP).toString();
                        if (totL === '-' && (pnsL !== '-' || pppkL !== '-')) totL = (nPnsL + nPppkL).toString();
                        if (totP === '-' && (pnsP !== '-' || pppkP !== '-')) totP = (nPnsP + nPppkP).toString();
                        if (totJml === '-' && (pnsJml !== '-' || pppkJml !== '-')) {
                            const nPJ = parseFloat(pnsJml.replace(',', '.')) || 0;
                            const nPKJ = parseFloat(pppkJml.replace(',', '.')) || 0;
                            totJml = (nPJ + nPKJ).toString();
                        }

                        extractedRows[matchedKey] = {
                            label: firstCell || extractedRows[matchedKey].label,
                            pns_l: pnsL, pns_p: pnsP, pns_jml: pnsJml,
                            pppk_l: pppkL, pppk_p: pppkP, pppk_jml: pppkJml,
                            total_l: totL, total_p: totP, total_jml: totJml
                        };

                        excelDataByYear[yr][`${matchedKey}_pns_l`] = pnsL;
                        excelDataByYear[yr][`${matchedKey}_pns_p`] = pnsP;
                        excelDataByYear[yr][`${matchedKey}_pns_jml`] = pnsJml;
                        excelDataByYear[yr][`${matchedKey}_pppk_l`] = pppkL;
                        excelDataByYear[yr][`${matchedKey}_pppk_p`] = pppkP;
                        excelDataByYear[yr][`${matchedKey}_pppk_jml`] = pppkJml;
                        excelDataByYear[yr][`${matchedKey}_total_l`] = totL;
                        excelDataByYear[yr][`${matchedKey}_total_p`] = totP;
                        excelDataByYear[yr][`${matchedKey}_total_jml`] = totJml;
                    }
                });

                window.uploadedExcelDataByYear = excelDataByYear;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
                let sumPnsL = 0, sumPnsP = 0, sumPnsJml = 0;
                let sumPppkL = 0, sumPppkP = 0, sumPppkJml = 0;
                let sumTotL = 0, sumTotP = 0, sumTotJml = 0;

                rowDefs.forEach(rd => {
                    const rData = extractedRows[rd.key];
                    const nPL = parseFloat(rData.pns_l.replace(',', '.')) || 0;
                    const nPP = parseFloat(rData.pns_p.replace(',', '.')) || 0;
                    const nPKL = parseFloat(rData.pppk_l.replace(',', '.')) || 0;
                    const nPKP = parseFloat(rData.pppk_p.replace(',', '.')) || 0;

                    sumPnsL += nPL;
                    sumPnsP += nPP;
                    sumPppkL += nPKL;
                    sumPppkP += nPKP;

                    tbodyHtml += `
                        <tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">${escapeHtml(rData.label)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700">${escapeHtml(rData.pns_l)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700">${escapeHtml(rData.pns_p)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold bg-amber-50/50">${escapeHtml(rData.pns_jml)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700">${escapeHtml(rData.pppk_l)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700">${escapeHtml(rData.pppk_p)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-bold bg-amber-50/50">${escapeHtml(rData.pppk_jml)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-medium">${escapeHtml(rData.total_l)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-medium">${escapeHtml(rData.total_p)}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${escapeHtml(rData.total_jml)}</td>
                        </tr>
                    `;
                });

                sumPnsJml = sumPnsL + sumPnsP;
                sumPppkJml = sumPppkL + sumPppkP;
                sumTotL = sumPnsL + sumPppkL;
                sumTotP = sumPnsP + sumPppkP;
                sumTotJml = sumPnsJml + sumPppkJml;

                const disp = (parsedVal, calcVal) => {
                    if (parsedVal && parsedVal !== '-' && parsedVal !== '') return escapeHtml(parsedVal);
                    return calcVal > 0 ? calcVal : '-';
                };

                const totPnsLStr = parsedTotalRow ? disp(parsedTotalRow[0], sumPnsL) : (sumPnsL > 0 ? sumPnsL : '-');
                const totPnsPStr = parsedTotalRow ? disp(parsedTotalRow[1], sumPnsP) : (sumPnsP > 0 ? sumPnsP : '-');
                const totPnsJmlStr = parsedTotalRow ? disp(parsedTotalRow[2], sumPnsJml) : (sumPnsJml > 0 ? sumPnsJml : '-');
                const totPppkLStr = parsedTotalRow ? disp(parsedTotalRow[3], sumPppkL) : (sumPppkL > 0 ? sumPppkL : '-');
                const totPppkPStr = parsedTotalRow ? disp(parsedTotalRow[4], sumPppkP) : (sumPppkP > 0 ? sumPppkP : '-');
                const totPppkJmlStr = parsedTotalRow ? disp(parsedTotalRow[5], sumPppkJml) : (sumPppkJml > 0 ? sumPppkJml : '-');
                const totAsnLStr = parsedTotalRow ? disp(parsedTotalRow[6], sumTotL) : (sumTotL > 0 ? sumTotL : '-');
                const totAsnPStr = parsedTotalRow ? disp(parsedTotalRow[7], sumTotP) : (sumTotP > 0 ? sumTotP : '-');
                const totAsnJmlStr = parsedTotalRow ? disp(parsedTotalRow[8], sumTotJml) : (sumTotJml > 0 ? sumTotJml : '-');

                tbodyHtml += `
                    <tr class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
                        <td class="py-2.5 px-4 font-bold border border-slate-700 text-left">Jumlah / Total</td>
                        <td class="py-2 px-3 text-center border border-slate-700">${totPnsLStr}</td>
                        <td class="py-2 px-3 text-center border border-slate-700">${totPnsPStr}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-extrabold">${totPnsJmlStr}</td>
                        <td class="py-2 px-3 text-center border border-slate-700">${totPppkLStr}</td>
                        <td class="py-2 px-3 text-center border border-slate-700">${totPppkPStr}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-extrabold">${totPppkJmlStr}</td>
                        <td class="py-2 px-3 text-center border border-slate-700">${totAsnLStr}</td>
                        <td class="py-2 px-3 text-center border border-slate-700">${totAsnPStr}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-200">${totAsnJmlStr}</td>
                    </tr>
                </tbody>`;

                titleId = is232
                    ? `Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin (orang), ${currentYear}`
                    : `Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan, Jenis ASN, dan Jenis Kelamin (orang), ${currentYear}`;
                titleEn = is232
                    ? `Number of Civil Servant of Bukittinggi Municipal Government by Educational Level, Type of ASN, and Sex (people), ${currentYear}`
                    : `Number of State Civil Apparatus (ASN) of Bukittinggi Municipal Government by Occupation, Type of ASN, and Sex (people), ${currentYear}`;
            } else if (currentTableCode === '2.3.3') {
                theadHtml = `<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-3 font-bold border border-slate-700 align-middle text-center" colspan="2" rowspan="2">
                            <div>Pangkat / Golongan / Ruang</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Hierarchy / Range</div>
                        </th>
                        <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                            <div>Pegawai Negeri Sipil</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Civil Servant</div>
                        </th>
                    </tr>
                    <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                        <th class="py-2 px-3 border border-slate-700 text-center"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                        <th class="py-2 px-3 border border-slate-700 text-center"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                        <th class="py-2 px-3 border border-slate-700 text-center bg-amber-600 font-extrabold"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700 text-center" colspan="2">(1)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center font-bold bg-amber-200/60">(4)</th>
                    </tr>
                </thead>`;

                const rankGroups = [
                    {
                        groupId: 'Golongan I',
                        groupEn: 'Range I',
                        ranks: [
                            { key: '1_ia', noGol: '1. I / A', labelId: 'Juru Muda', labelEn: 'Junior Clerk', match: ['1. i / a', '1. i/a', 'i / a', 'i/a', 'juru muda', 'junior clerk'] },
                            { key: '2_ib', noGol: '2. I / B', labelId: 'Juru Muda Tingkat I', labelEn: 'First Class Junior Clerk', match: ['2. i / b', '2. i/b', 'i / b', 'i/b', 'juru muda tingkat i', 'juru muda tk i', 'first class junior clerk'] },
                            { key: '3_ic', noGol: '3. I / C', labelId: 'Juru', labelEn: 'Clerk', match: ['3. i / c', '3. i/c', 'i / c', 'i/c', 'juru', 'clerk'] },
                            { key: '4_id', noGol: '4. I / D', labelId: 'Juru Tingkat I', labelEn: 'First Class Clerk', match: ['4. i / d', '4. i/d', 'i / d', 'i/d', 'juru tingkat i', 'juru tk i', 'first class clerk'] }
                        ]
                    },
                    {
                        groupId: 'Golongan II',
                        groupEn: 'Range II',
                        ranks: [
                            { key: '5_iia', noGol: '5. II / A', labelId: 'Pengatur Muda', labelEn: 'Junior Supervisor', match: ['5. ii / a', '5. ii/a', 'ii / a', 'ii/a', 'pengatur muda', 'junior supervisor'] },
                            { key: '6_iib', noGol: '6. II / B', labelId: 'Pengatur Muda Tingkat I', labelEn: 'First Class Junior Supervisor', match: ['6. ii / b', '6. ii/b', 'ii / b', 'ii/b', 'pengatur muda tingkat i', 'pengatur muda tk i', 'first class junior supervisor'] },
                            { key: '7_iic', noGol: '7. II / C', labelId: 'Pengatur', labelEn: 'Supervisor', match: ['7. ii / c', '7. ii/c', 'ii / c', 'ii/c', 'pengatur', 'supervisor'] },
                            { key: '8_iid', noGol: '8. II / D', labelId: 'Pengatur Tingkat I', labelEn: 'First Class Supervisor', match: ['8. ii / d', '8. ii/d', 'ii / d', 'ii/d', 'pengatur tingkat i', 'pengatur tk i', 'first class supervisor'] }
                        ]
                    },
                    {
                        groupId: 'Golongan III',
                        groupEn: 'Range III',
                        ranks: [
                            { key: '9_iiia', noGol: '9. III / A', labelId: 'Penata Muda', labelEn: 'Junior Superintendent', match: ['9. iii / a', '9. iii/a', 'iii / a', 'iii/a', 'penata muda', 'junior superintendent'] },
                            { key: '10_iiib', noGol: '10. III / B', labelId: 'Penata Muda Tingkat I', labelEn: 'First Class Junior Superintendent', match: ['10. iii / b', '10. iii/b', 'iii / b', 'iii/b', 'penata muda tingkat i', 'penata muda tk i', 'first class junior superintendent'] },
                            { key: '11_iiic', noGol: '11. III / C', labelId: 'Penata', labelEn: 'Superintendent', match: ['11. iii / c', '11. iii/c', 'iii / c', 'iii/c', 'penata', 'superintendent'] },
                            { key: '12_iiid', noGol: '12. III / D', labelId: 'Penata Tingkat I', labelEn: 'First Class Superintendent', match: ['12. iii / d', '12. iii/d', 'iii / d', 'iii/d', 'penata tingkat i', 'penata tk i', 'first class superintendent'] }
                        ]
                    },
                    {
                        groupId: 'Golongan IV',
                        groupEn: 'Range IV',
                        ranks: [
                            { key: '13_iva', noGol: '13. IV / A', labelId: 'Pembina', labelEn: 'Administrator', match: ['13. iv / a', '13. iv/a', 'iv / a', 'iv/a', 'pembina', 'administrator'] },
                            { key: '14_ivb', noGol: '14. IV / B', labelId: 'Pembina Tingkat I', labelEn: 'First Class Administrator', match: ['14. iv / b', '14. iv/b', 'iv / b', 'iv/b', 'pembina tingkat i', 'pembina tk i', 'first class administrator'] },
                            { key: '15_ivc', noGol: '15. IV / C', labelId: 'Pembina Utama Muda', labelEn: 'Junior Administrator', match: ['15. iv / c', '15. iv/c', 'iv / c', 'iv/c', 'pembina utama muda', 'junior administrator'] },
                            { key: '16_ivd', noGol: '16. IV / D', labelId: 'Pembina Utama Madya', labelEn: 'Middle Administrator', match: ['16. iv / d', '16. iv/d', 'iv / d', 'iv/d', 'pembina utama madya', 'middle administrator'] },
                            { key: '17_ive', noGol: '17. IV / E', labelId: 'Pembina Utama', labelEn: 'Senior Administrator', match: ['17. iv / e', '17. iv/e', 'iv / e', 'iv/e', 'pembina utama', 'senior administrator'] }
                        ]
                    }
                ];

                const excelDataByYear = {};
                excelDataByYear[yr] = {};

                const extractedRanks = {};
                rankGroups.forEach(grp => {
                    grp.ranks.forEach(rk => {
                        extractedRanks[rk.key] = { l: '-', p: '-', jml: '-' };
                    });
                });

                let currentGroupIdx = -1;
                let rankIdxInGroup = 0;

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase();
                    if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan') || rowStr.startsWith('note') || rowStr.startsWith('source')) return;

                    // Deteksi Baris Header Golongan (Golongan I, Golongan II, Golongan III, Golongan IV)
                    if (/golongan\s*i\b/i.test(rowStr) && !/golongan\s*ii/i.test(rowStr) && !/golongan\s*iii/i.test(rowStr) && !/golongan\s*iv/i.test(rowStr)) {
                        currentGroupIdx = 0;
                        rankIdxInGroup = 0;
                        return;
                    } else if (/golongan\s*ii\b/i.test(rowStr) && !/golongan\s*iii/i.test(rowStr)) {
                        currentGroupIdx = 1;
                        rankIdxInGroup = 0;
                        return;
                    } else if (/golongan\s*iii\b/i.test(rowStr)) {
                        currentGroupIdx = 2;
                        rankIdxInGroup = 0;
                        return;
                    } else if (/golongan\s*iv\b/i.test(rowStr)) {
                        currentGroupIdx = 3;
                        rankIdxInGroup = 0;
                        return;
                    }

                    if (/jumlah\s*\/\s*total/i.test(rowStr) || (rowStr.includes('jumlah') && rowStr.includes('total'))) {
                        return;
                    }

                    const nonBlankCells = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).filter(c => c !== '');
                    if (nonBlankCells.length < 2) return;

                    let matchedKey = null;

                    if (currentGroupIdx >= 0 && currentGroupIdx < rankGroups.length) {
                        const grp = rankGroups[currentGroupIdx];
                        // Prioritaskan pencocokan string terpanjang terlebih dahulu (agar 'tingkat i' tidak tertimpa nama induk)
                        const candidateRanks = [...grp.ranks].sort((a, b) => {
                            const maxA = Math.max(...a.match.map(m => m.length));
                            const maxB = Math.max(...b.match.map(m => m.length));
                            return maxB - maxA;
                        });

                        for (let rk of candidateRanks) {
                            if (rk.match.some(m => rowStr.includes(m))) {
                                matchedKey = rk.key;
                                break;
                            }
                        }

                        // Fallback urutan baris dalam golongan jika nama tidak terdeteksi tapi memiliki angka
                        if (!matchedKey && rankIdxInGroup < grp.ranks.length) {
                            matchedKey = grp.ranks[rankIdxInGroup].key;
                        }
                        rankIdxInGroup++;
                    } else {
                        // Pencocokan global terurut panjang string
                        const allRanks = [];
                        rankGroups.forEach(g => allRanks.push(...g.ranks));
                        allRanks.sort((a, b) => {
                            const maxA = Math.max(...a.match.map(m => m.length));
                            const maxB = Math.max(...b.match.map(m => m.length));
                            return maxB - maxA;
                        });
                        for (let rk of allRanks) {
                            if (rk.match.some(m => rowStr.includes(m))) {
                                matchedKey = rk.key;
                                break;
                            }
                        }
                    }

                    if (matchedKey) {
                        const numericValues = [];
                        row.forEach(c => {
                            if (c !== null && c !== undefined) {
                                const s = c.toString().trim();
                                if (/^-?\d+([.,]\d+)?$/.test(s)) {
                                    numericValues.push(s);
                                }
                            }
                        });

                        const lVal = numericValues[0] || '0';
                        const pVal = numericValues[1] || '0';
                        const nL = parseFloat(lVal.replace(',', '.')) || 0;
                        const nP = parseFloat(pVal.replace(',', '.')) || 0;
                        const jmlVal = numericValues[2] || (nL + nP).toString();

                        extractedRanks[matchedKey] = { l: lVal, p: pVal, jml: jmlVal };
                        excelDataByYear[yr][`${matchedKey}_l`] = lVal;
                        excelDataByYear[yr][`${matchedKey}_p`] = pVal;
                        excelDataByYear[yr][`${matchedKey}_jml`] = jmlVal;
                    }
                });

                window.uploadedExcelDataByYear = excelDataByYear;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
                let totL = 0, totP = 0, totJml = 0;
                let hasData = false;

                rankGroups.forEach(grp => {
                    let grpL = 0, grpP = 0, grpJml = 0;
                    let grpHasData = false;
                    let grpRanksHtml = '';

                    grp.ranks.forEach(rk => {
                        const rkData = extractedRanks[rk.key] || { l: '-', p: '-', jml: '-' };
                        const nL = parseFloat(String(rkData.l).replace(',', '.')) || 0;
                        const nP = parseFloat(String(rkData.p).replace(',', '.')) || 0;
                        const isSet = (rkData.l !== '-' && rkData.l !== '') || (rkData.p !== '-' && rkData.p !== '');

                        if (isSet) {
                            hasData = true;
                            grpHasData = true;
                            grpL += nL;
                            grpP += nP;
                            grpJml += (nL + nP);
                            totL += nL;
                            totP += nP;
                            totJml += (nL + nP);
                        }

                        const rkJmlStr = isSet ? (nL + nP) : '-';

                        grpRanksHtml += `
                            <tr data-key="${rk.key}" class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-3 font-semibold border border-slate-700 text-center whitespace-nowrap">${rk.noGol}</td>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                    <div>${rk.labelId}</div>
                                    <div class="italic font-normal text-xs text-slate-600">${rk.labelEn}</div>
                                </td>
                                <td class="py-2 px-3 text-center border border-slate-700">${rkData.l}</td>
                                <td class="py-2 px-3 text-center border border-slate-700">${rkData.p}</td>
                                <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${rkJmlStr}</td>
                            </tr>
                        `;
                    });

                    tbodyHtml += `
                        <tr data-group="true" class="bg-amber-100/70 font-bold text-slate-800 border-t border-b border-slate-700">
                            <td class="py-2 px-4 border border-slate-700 text-left font-bold" colspan="2">
                                <span>${grp.groupId}</span> / <span class="italic font-normal text-xs text-slate-700">${grp.groupEn}</span>
                            </td>
                            <td class="py-2 px-3 text-center border border-slate-700"></td>
                            <td class="py-2 px-3 text-center border border-slate-700"></td>
                            <td class="py-2 px-3 text-center border border-slate-700"></td>
                        </tr>
                        ${grpRanksHtml}
                    `;
                });

                tbodyHtml += `
                    <tr data-total="true" class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
                        <td class="py-2.5 px-4 font-bold border border-slate-700 text-left" colspan="2">
                            <div>Jumlah</div>
                            <div class="italic font-normal text-xs text-slate-700">Total</div>
                        </td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totL : '-'}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totP : '-'}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-200">${hasData ? totJml : '-'}</td>
                    </tr>
                </tbody>`;

                titleId = `Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang), ${currentYear}`;
                titleEn = `Number of Bukittinggi Municipality Government’s Civil Servants by Hierarchy and Sex (people), ${currentYear}`;
            } else if (currentTableCode === '2.3.4') {
                theadHtml = `<thead>
                    <tr class="bg-[#f95a00] text-white text-center font-bold">
                        <th class="py-3 px-3 font-bold border border-slate-700 align-middle text-center" colspan="2" rowspan="2">
                            <div>Tingkat Kepangkatan / Golongan</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Hierarchy / Range</div>
                        </th>
                        <th class="py-2 px-3 font-bold border border-slate-700 text-center" colspan="3">
                            <div>Pegawai Pemerintah dengan Perjanjian Kerja</div>
                            <div class="italic font-normal text-[11px] sm:text-xs">Civil Servants with Employment Agreements</div>
                        </th>
                    </tr>
                    <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                        <th class="py-2 px-3 border border-slate-700 text-center"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                        <th class="py-2 px-3 border border-slate-700 text-center"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                        <th class="py-2 px-3 border border-slate-700 text-center bg-amber-600 font-extrabold"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                    </tr>
                    <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                        <th class="py-1 px-3 border border-slate-700 text-center" colspan="2">(1)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                        <th class="py-1 px-3 border border-slate-700 text-center font-bold bg-amber-200/60">(4)</th>
                    </tr>
                </thead>`;

                const ranks234 = [
                    { key: 'gol_1',  noGol: '1.',  labelId: 'Golongan I',    labelEn: 'Range I (Setara SD)' },
                    { key: 'gol_2',  noGol: '2.',  labelId: 'Golongan II',   labelEn: 'Range II' },
                    { key: 'gol_3',  noGol: '3.',  labelId: 'Golongan III',  labelEn: 'Range III' },
                    { key: 'gol_4',  noGol: '4.',  labelId: 'Golongan IV',   labelEn: 'Range IV (Setara SMP)' },
                    { key: 'gol_5',  noGol: '5.',  labelId: 'Golongan V',    labelEn: 'Range V (Setara SMA/SMK)' },
                    { key: 'gol_6',  noGol: '6.',  labelId: 'Golongan VI',   labelEn: 'Range VI (Setara D-II)' },
                    { key: 'gol_7',  noGol: '7.',  labelId: 'Golongan VII',  labelEn: 'Range VII (Setara D-III)' },
                    { key: 'gol_8',  noGol: '8.',  labelId: 'Golongan VIII', labelEn: 'Range VIII (Setara D-IV)' },
                    { key: 'gol_9',  noGol: '9.',  labelId: 'Golongan IX',   labelEn: 'Range IX (Setara S-1/D-IV)' },
                    { key: 'gol_10', noGol: '10.', labelId: 'Golongan X',    labelEn: 'Range X (Setara S-2)' },
                    { key: 'gol_11', noGol: '11.', labelId: 'Golongan XI',   labelEn: 'Range XI (Setara S-3)' },
                    { key: 'gol_12', noGol: '12.', labelId: 'Golongan XII',  labelEn: 'Range XII' },
                    { key: 'gol_13', noGol: '13.', labelId: 'Golongan XIII', labelEn: 'Range XIII' },
                    { key: 'gol_14', noGol: '14.', labelId: 'Golongan XIV',  labelEn: 'Range XIV' },
                    { key: 'gol_15', noGol: '15.', labelId: 'Golongan XV',   labelEn: 'Range XV' },
                    { key: 'gol_16', noGol: '16.', labelId: 'Golongan XVI',  labelEn: 'Range XVI' },
                    { key: 'gol_17', noGol: '17.', labelId: 'Golongan XVII', labelEn: 'Range XVII' }
                ];

                const matchPriority234 = [
                    { key: 'gol_17', regex: /\b(golongan\s*(xvii|17)|range\s*(xvii|17)|17\.?\s*(xvii|17))\b/i },
                    { key: 'gol_16', regex: /\b(golongan\s*(xvi|16)|range\s*(xvi|16)|16\.?\s*(xvi|16))\b/i },
                    { key: 'gol_15', regex: /\b(golongan\s*(xv|15)|range\s*(xv|15)|15\.?\s*(xv|15))\b/i },
                    { key: 'gol_14', regex: /\b(golongan\s*(xiv|14)|range\s*(xiv|14)|14\.?\s*(xiv|14))\b/i },
                    { key: 'gol_13', regex: /\b(golongan\s*(xiii|13)|range\s*(xiii|13)|13\.?\s*(xiii|13))\b/i },
                    { key: 'gol_12', regex: /\b(golongan\s*(xii|12)|range\s*(xii|12)|12\.?\s*(xii|12))\b/i },
                    { key: 'gol_11', regex: /\b(golongan\s*(xi|11)|range\s*(xi|11)|11\.?\s*(xi|11))\b/i },
                    { key: 'gol_10', regex: /\b(golongan\s*(x|10)|range\s*(x|10)|10\.?\s*(x|10))\b/i },
                    { key: 'gol_9',  regex: /\b(golongan\s*(ix|9)|range\s*(ix|9)|9\.?\s*(ix|9))\b/i },
                    { key: 'gol_8',  regex: /\b(golongan\s*(viii|8)|range\s*(viii|8)|8\.?\s*(viii|8))\b/i },
                    { key: 'gol_7',  regex: /\b(golongan\s*(vii|7)|range\s*(vii|7)|7\.?\s*(vii|7))\b/i },
                    { key: 'gol_6',  regex: /\b(golongan\s*(vi|6)|range\s*(vi|6)|6\.?\s*(vi|6))\b/i },
                    { key: 'gol_5',  regex: /\b(golongan\s*(v|5)|range\s*(v|5)|5\.?\s*(v|5))\b/i },
                    { key: 'gol_4',  regex: /\b(golongan\s*(iv|4)|range\s*(iv|4)|4\.?\s*(iv|4))\b/i },
                    { key: 'gol_3',  regex: /\b(golongan\s*(iii|3)|range\s*(iii|3)|3\.?\s*(iii|3))\b/i },
                    { key: 'gol_2',  regex: /\b(golongan\s*(ii|2)|range\s*(ii|2)|2\.?\s*(ii|2))\b/i },
                    { key: 'gol_1',  regex: /\b(golongan\s*(i|1)|range\s*(i|1)|1\.?\s*(i|1))\b/i }
                ];

                const excelDataByYear = {};
                excelDataByYear[yr] = {};

                const extractedRanks234 = {};
                ranks234.forEach(rk => {
                    extractedRanks234[rk.key] = { l: '-', p: '-', jml: '-' };
                });

                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase().replace(/\s+/g, ' ');
                    if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan') || rowStr.startsWith('note') || rowStr.startsWith('source')) return;

                    if (/jumlah\s*\/\s*total/i.test(rowStr) || (rowStr.includes('jumlah') && rowStr.includes('total'))) {
                        return;
                    }

                    let matchedKey = null;
                    for (const m of matchPriority234) {
                        if (m.regex.test(rowStr)) {
                            matchedKey = m.key;
                            break;
                        }
                    }

                    if (matchedKey) {
                        const numericValues = row.filter(c => /^-?\d+([.,]\d+)?$/.test((c || '').toString().trim()));
                        const lVal = numericValues[0] || '0';
                        const pVal = numericValues[1] || '0';
                        const nL = parseFloat(lVal.replace(',', '.')) || 0;
                        const nP = parseFloat(pVal.replace(',', '.')) || 0;
                        const jmlVal = numericValues[2] || (nL + nP).toString();

                        extractedRanks234[matchedKey] = { l: lVal, p: pVal, jml: jmlVal };
                        excelDataByYear[yr][`${matchedKey}_l`] = lVal;
                        excelDataByYear[yr][`${matchedKey}_p`] = pVal;
                        excelDataByYear[yr][`${matchedKey}_jml`] = jmlVal;
                    }
                });

                window.uploadedExcelDataByYear = excelDataByYear;

                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
                let totL = 0, totP = 0, totJml = 0;
                let hasData = false;

                ranks234.forEach(rk => {
                    const rkData = extractedRanks234[rk.key] || { l: '-', p: '-', jml: '-' };
                    const nL = parseFloat(String(rkData.l).replace(',', '.')) || 0;
                    const nP = parseFloat(String(rkData.p).replace(',', '.')) || 0;
                    const isSet = (rkData.l !== '-' && rkData.l !== '') || (rkData.p !== '-' && rkData.p !== '');

                    if (isSet) {
                        hasData = true;
                        totL += nL;
                        totP += nP;
                        totJml += (nL + nP);
                    }

                    const rkJmlStr = isSet ? (nL + nP) : '-';

                    tbodyHtml += `
                        <tr data-key="${rk.key}" class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-3 font-semibold border border-slate-700 text-center w-12">${rk.noGol}</td>
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                                <div>${rk.labelId}</div>
                                <div class="italic font-normal text-xs text-slate-600">${rk.labelEn}</div>
                            </td>
                            <td class="py-2 px-3 text-center border border-slate-700">${rkData.l}</td>
                            <td class="py-2 px-3 text-center border border-slate-700">${rkData.p}</td>
                            <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-100/70">${rkJmlStr}</td>
                        </tr>
                    `;
                });

                tbodyHtml += `
                    <tr data-total="true" class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
                        <td class="py-2.5 px-4 font-bold border border-slate-700 text-left" colspan="2">
                            <div>Jumlah</div>
                            <div class="italic font-normal text-xs text-slate-700">Total</div>
                        </td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totL : '-'}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-bold">${hasData ? totP : '-'}</td>
                        <td class="py-2 px-3 text-center border border-slate-700 font-extrabold bg-amber-200">${hasData ? totJml : '-'}</td>
                    </tr>
                </tbody>`;

                titleId = `Jumlah Pegawai Pemerintah dengan Perjanjian Kerja Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang), ${currentYear}`;
                titleEn = `Number of Bukittinggi Municipal Government’s Civil servants with employment agreements by Hierarchy and Sex (people), ${currentYear}`;
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

                ﻿const units235 = [
    { key: 'unit_1', no: 1, name: "01. Sekretaris Daerah", pns25: '104', pppk25: '5', pns24: '99', pppk24: '4' },
    { key: 'unit_2', no: 2, name: "02. Badan Kepegawaian dan Pengembangan Sumber Daya Manusia", pns25: '27', pppk25: '2', pns24: '27', pppk24: '0' },
    { key: 'unit_3', no: 3, name: "03. Badan Keuangan", pns25: '57', pppk25: '5', pns24: '50', pppk24: '3' },
    { key: 'unit_4', no: 4, name: "04. Badan Perencanaan Penelitian dan Pembangunan", pns25: '32', pppk25: '1', pns24: '33', pppk24: '0' },
    { key: 'unit_5', no: 5, name: "05. Inspektorat Daerah", pns25: '43', pppk25: '0', pns24: '44', pppk24: '0' },
    { key: 'unit_6', no: 6, name: "06. Sekretariat Dewan Perwakilan Rakyat daerah", pns25: '26', pppk25: '3', pns24: '27', pppk24: '0' },
    { key: 'unit_7', no: 7, name: "07. Dinas Pemadam Kebakaran dan Penyelamatan", pns25: '24', pppk25: '25', pns24: '24', pppk24: '25' },
    { key: 'unit_8', no: 8, name: "08. Dinas Kependudukan Dan Pencatatan Sipil", pns25: '22', pppk25: '2', pns24: '23', pppk24: '0' },
    { key: 'unit_9', no: 9, name: "09. Dinas Kesehatan", pns25: '54', pppk25: '7', pns24: '49', pppk24: '5' },
    { key: 'unit_10', no: 10, name: "10. Dinas Komunikasi Dan Informatika", pns25: '19', pppk25: '3', pns24: '20', pppk24: '3' },
    { key: 'unit_11', no: 11, name: "11. Dinas Koperasi, Usaha Kecil mengengah Dan Tenaga Kerja", pns25: '24', pppk25: '4', pns24: '21', pppk24: '1' },
    { key: 'unit_12', no: 12, name: "12. Dinas Lingkungan Hidup", pns25: '101', pppk25: '22', pns24: '102', pppk24: '10' },
    { key: 'unit_13', no: 13, name: "13. Dinas Pariwisata", pns25: '45', pppk25: '15', pns24: '44', pppk24: '3' },
    { key: 'unit_14', no: 14, name: "14. Dinas Pekerjaan Umum dan Penataan Ruang", pns25: '52', pppk25: '8', pns24: '50', pppk24: '5' },
    { key: 'unit_15', no: 15, name: "15. Dinas Pemberdayaan Perempuan Dan Perlindungan Anak, Pengendalian Penduduk Dan Keluarga Berencana", pns25: '28', pppk25: '2', pns24: '30', pppk24: '0' },
    { key: 'unit_16', no: 16, name: "16. Dinas Penanaman Modal Pelayanan Terpadu Satu Pintu", pns25: '23', pppk25: '3', pns24: '25', pppk24: '2' },
    { key: 'unit_17', no: 17, name: "17. Dinas Pendidikan Dan Kebudayaan", pns25: '66', pppk25: '5', pns24: '71', pppk24: '0' },
    { key: 'unit_18', no: 18, name: "18. Dinas Perhubungan", pns25: '36', pppk25: '6', pns24: '41', pppk24: '2' },
    { key: 'unit_19', no: 19, name: "19. Dinas Perpustakaan Dan Kearsipan", pns25: '22', pppk25: '1', pns24: '28', pppk24: '1' },
    { key: 'unit_20', no: 20, name: "20. Dinas Pertanian Dan Pangan", pns25: '42', pppk25: '5', pns24: '39', pppk24: '3' },
    { key: 'unit_21', no: 21, name: "21. Dinas Perdagangan dan Perindustrian", pns25: '28', pppk25: '13', pns24: '26', pppk24: '3' },
    { key: 'unit_22', no: 22, name: "22. Dinas Perumahan Dan Kawasan Pemukiman", pns25: '30', pppk25: '7', pns24: '29', pppk24: '0' },
    { key: 'unit_23', no: 23, name: "23. Dinas Sosial", pns25: '21', pppk25: '5', pns24: '19', pppk24: '0' },
    { key: 'unit_24', no: 24, name: "24. Dinas Pemuda dan Olahraga", pns25: '17', pppk25: '6', pns24: '17', pppk24: '0' },
    { key: 'unit_25', no: 25, name: "25. Satuan Polisi Pamong Praja", pns25: '59', pppk25: '50', pns24: '47', pppk24: '0' },
    { key: 'unit_26', no: 26, name: "26. Badan Penanggulangan Bencana Daerah", pns25: '11', pppk25: '15', pns24: '12', pppk24: '15' },
    { key: 'unit_27', no: 27, name: "27. Badan Kesatuan Bangsa dan Politik", pns25: '14', pppk25: '1', pns24: '15', pppk24: '1' },
    { key: 'unit_28', no: 28, name: "28. Kecamatan Aur Birugo Tigo Baleh", pns25: '14', pppk25: '1', pns24: '15', pppk24: '1' },
    { key: 'unit_29', no: 29, name: "29. Kecamatan Guguk Panjang", pns25: '13', pppk25: '2', pns24: '14', pppk24: '1' },
    { key: 'unit_30', no: 30, name: "30. Kecamatan Mandiangin Koto Selayan", pns25: '17', pppk25: '1', pns24: '18', pppk24: '1' },
    { key: 'unit_31', no: 31, name: "31. Keluarahan Campago Guguk Bulek", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_32', no: 32, name: "32. Kelurahan Campago Ipuh", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_33', no: 33, name: "33. Kelurahan Garegeh", pns25: '6', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_34', no: 34, name: "34. Kelurahan Koto Selayan", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_35', no: 35, name: "35. Kelurahan Kubu Gulai Bancah", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_36', no: 36, name: "36. Kelurahan Manggis Ganting", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_37', no: 37, name: "37. Kelurahan Puhun Pintu Kabun", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_38', no: 38, name: "38. Kelurahan Puhun Tembok", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_39', no: 39, name: "39. Kelurahan Pulai Anak Air", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_40', no: 40, name: "40. Kelurahan Aur Tajungkang Tengah Sawah", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_41', no: 41, name: "41. Kelurahan Benteng Pasar Atas", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_42', no: 42, name: "42. Kelurahan Bukit Apit Puhun", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_43', no: 43, name: "43. Kelurahan Bukit Cangang kayu Ramang", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_44', no: 44, name: "44. Kelurahan Kayu Kubu", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_45', no: 45, name: "45. Kelurahan Pakan Kurai", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_46', no: 46, name: "46. Kelurahan Tarok Dipo", pns25: '7', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_47', no: 47, name: "47. Kelurahan Belakang Balok", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_48', no: 48, name: "48. Kelurahan Aur Kuning", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_49', no: 49, name: "49. Kelurahan Birugo", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_50', no: 50, name: "50. Kelurahan Kubu Tanjung", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_51', no: 51, name: "51. Kelurahan Ladang Cakiah", pns25: '7', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_52', no: 52, name: "52. Kelurahan Pakan Labuah", pns25: '6', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_53', no: 53, name: "53. Kelurahan Parit Antang", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_54', no: 54, name: "54. Kelurahan Sapiran", pns25: '7', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_55', no: 55, name: "55. TK", pns25: '13', pppk25: '2', pns24: '15', pppk24: '2' },
    { key: 'unit_56', no: 56, name: "56. SD", pns25: '373', pppk25: '178', pns24: '389', pppk24: '179' },
    { key: 'unit_57', no: 57, name: "57. SMP \/ MTsN", pns25: '202', pppk25: '83', pns24: '209', pppk24: '81' },
    { key: 'unit_58', no: 58, name: "58. UPTD Sanggar Kegiatan Belajar", pns25: '3', pppk25: '9', pns24: '3', pppk24: '9' },
    { key: 'unit_59', no: 59, name: "59. UPTD Instalasi Farmasi", pns25: '5', pppk25: '2', pns24: '6', pppk24: '2' },
    { key: 'unit_60', no: 60, name: "60. UPTD Laboratorium Kesehatan", pns25: '16', pppk25: '1', pns24: '16', pppk24: '1' },
    { key: 'unit_61', no: 61, name: "61. UPTD Puskemas Guguak Panjang", pns25: '35', pppk25: '3', pns24: '36', pppk24: '3' },
    { key: 'unit_62', no: 62, name: "62. UPTD Puskesmas Gulai Bancah", pns25: '30', pppk25: '1', pns24: '30', pppk24: '1' },
    { key: 'unit_63', no: 63, name: "63. UPTD Puskemas Mandiangin", pns25: '31', pppk25: '3', pns24: '33', pppk24: '3' },
    { key: 'unit_64', no: 64, name: "64. UPTD Puskesmas Nilam Sari", pns25: '31', pppk25: '5', pns24: '33', pppk24: '5' },
    { key: 'unit_65', no: 65, name: "65. UPTD Puskesmas Perkotaan Rasimah Ahmad", pns25: '40', pppk25: '3', pns24: '41', pppk24: '3' },
    { key: 'unit_66', no: 66, name: "66. UPTD Puskesmas Plus Mandiangin", pns25: '29', pppk25: '4', pns24: '29', pppk24: '4' },
    { key: 'unit_67', no: 67, name: "67. UPTD Puskemas Tigo Baleh", pns25: '41', pppk25: '2', pns24: '44', pppk24: '2' },
    { key: 'unit_68', no: 68, name: "68. UPTD RSUD", pns25: '95', pppk25: '124', pns24: '88', pppk24: '124' },
    { key: 'unit_69', no: 69, name: "69. UPTD Balai Benih Ikan Hias", pns25: '4', pppk25: '2', pns24: '2', pppk24: '0' },
    { key: 'unit_70', no: 70, name: "70. UPTD Pusat Kesehatan Hewan", pns25: '5', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_71', no: 71, name: "71. UPTD Rumah Potong Hewan", pns25: '6', pppk25: '0', pns24: '6', pppk24: '0' },
    { key: 'unit_72', no: 72, name: "72. UPTD Kerajinan Industri", pns25: '2', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_73', no: 73, name: "73. UPTD Penguji Kendaraan bermotor", pns25: '6', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_74', no: 74, name: "74. UPTD Terminal dan Parkir", pns25: '16', pppk25: '9', pns24: '18', pppk24: '0' },
    { key: 'unit_75', no: 75, name: "75. UPTD Penerangan Fasilitas Umum", pns25: '5', pppk25: '0', pns24: '5', pppk24: '0' },
    { key: 'unit_76', no: 76, name: "76. UPTD Perlengkapan dan Peralatan", pns25: '4', pppk25: '0', pns24: '4', pppk24: '0' },
    { key: 'unit_77', no: 77, name: "77. UPTD Kemetrologian", pns25: '8', pppk25: '0', pns24: '8', pppk24: '0' },
    { key: 'unit_78', no: 78, name: "78. UPTD Perlindungan Perempuan dan Anak", pns25: '5', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_79', no: 79, name: "79. STAF AHLI", pns25: '3', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_80', no: 80, name: "80. Tugas Belajar", pns25: '4', pppk25: '0', pns24: '3', pppk24: '0' },
    { key: 'unit_81', no: 81, name: "81. MPP", pns25: '6', pppk25: '0', pns24: '7', pppk24: '0' },
    { key: 'unit_82', no: 82, name: "82. Diperbantukan", pns25: '12', pppk25: '0', pns24: '13', pppk24: '0' },
    { key: 'unit_83', no: 83, name: "83. CLTN", pns25: '1', pppk25: '0', pns24: '2', pppk24: '0' },
    { key: 'unit_84', no: 84, name: "84. Pemberhentian Sementara", pns25: '1', pppk25: '0', pns24: '2', pppk24: '0' },
];


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
                            matchedKey = `unit_${no}`;
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
                        <tr data-key="${u.key}" class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-top">
                                ${u.name}
                            </td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 align-top">${uData.pns}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 align-top">${uData.pppk}</td>
                            <td class="py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-100/70 align-top">${rowJmlStr}</td>
                        </tr>
                    `;
                });

                tbodyHtml += `
                    <tr data-total="true" class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">
                        <td class="py-2.5 px-4 font-bold border border-slate-700 text-left">
                            <div>Jumlah</div>
                            <div class="italic font-normal text-xs text-slate-700">Total</div>
                        </td>
                        <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">${hasData ? totPns : '-'}</td>
                        <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">${hasData ? totPppk : '-'}</td>
                        <td class="py-2.5 px-4 text-center border border-slate-700 font-extrabold bg-amber-200">${hasData ? totJml : '-'}</td>
                    </tr>
                </tbody>`;

                titleId = `Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi, ${currentYear}`;
                titleEn = `Number of Civil Servants in Local Government of Bukittinggi Municipality by Placement, ${currentYear}`;
            } else {
                theadHtml = '<thead>';

                // Render Header Rows
                headerRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    theadHtml += `<tr class="bg-[#f95a00] text-white text-center font-bold">`;

                    for (let c = 0; c < maxCols; c++) {
                        const merge = getCellMerge(rIdx, c);
                        if (merge && !merge.isOrigin) {
                            continue;
                        }

                        let rowspan = merge ? merge.rowspan : 1;
                        let colspan = merge ? merge.colspan : 1;

                        // Fallback colspan detection if no explicit merge
                        if (!merge && row[c] && c < maxCols - 1) {
                            let emptyCount = 0;
                            for (let nextC = c + 1; nextC < maxCols; nextC++) {
                                if (!row[nextC] || row[nextC].toString().trim() === '') {
                                    emptyCount++;
                                } else {
                                    break;
                                }
                            }
                            const dataHasCols = dataRowIndices.some(dIdx => {
                                const dRow = rawRows[dIdx] || [];
                                return dRow[c + 1] && dRow[c + 1].toString().trim() !== '';
                            });
                            if (emptyCount > 0 && dataHasCols) {
                                colspan = emptyCount + 1;
                                c += emptyCount;
                            }
                        }

                        const val = row[c] || '';
                        const rSpanAttr = rowspan > 1 ? ` rowspan="${rowspan}"` : '';
                        const cSpanAttr = colspan > 1 ? ` colspan="${colspan}"` : '';

                        theadHtml += `
                            <th class="py-3 px-4 font-bold border border-slate-700"${rSpanAttr}${cSpanAttr}>
                                ${formatHeaderContent(val || `Kolom ${c + 1}`)}
                            </th>
                        `;
                    }

                    theadHtml += `</tr>`;
                });

                // Render Numbering Row
                theadHtml += `<tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">`;
                if (numberingRowIdx !== -1) {
                    const numRow = rawRows[numberingRowIdx] || [];
                    for (let c = 0; c < maxCols; c++) {
                        const merge = getCellMerge(numberingRowIdx, c);
                        if (merge && !merge.isOrigin) continue;

                        let rowspan = merge ? merge.rowspan : 1;
                        let colspan = merge ? merge.colspan : 1;
                        let val = (numRow[c] || '').toString().trim();

                        if (!val && c > 0) {
                            val = `(${c + 1})`;
                        }
                        if (val) {
                            const cleanNum = val.replace(/[^\d]/g, '');
                            if (cleanNum && val.toLowerCase() !== 'no') {
                                val = `(${cleanNum})`;
                            }
                        }

                        const rSpanAttr = rowspan > 1 ? ` rowspan="${rowspan}"` : '';
                        const cSpanAttr = colspan > 1 ? ` colspan="${colspan}"` : '';
                        theadHtml += `<th class="py-1 px-3 border border-slate-700"${rSpanAttr}${cSpanAttr}>${escapeHtml(val || `(${c + 1})`)}</th>`;
                    }
                } else {
                    for (let c = 0; c < maxCols; c++) {
                        theadHtml += `<th class="py-1 px-3 border border-slate-700">(${c + 1})</th>`;
                    }
                }
                theadHtml += `</tr></thead>`;

                if (currentTableCode === '2.4.2') {
                    theadHtml = theadHtml.replace(/Jenis Pendapatan/gi, 'Jenis Belanja');
                    theadHtml = theadHtml.replace(/Kind of Revenues/gi, 'Kind of Expenditures');
                }

                // 7. Build <tbody> HTML with Merge & Rowspan Support
                tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';

                dataRowIndices.forEach((rIdx, loopIdx) => {
                    const row = rawRows[rIdx] || [];
                    const meaningfulRow = row.filter(c => c !== null && c !== undefined && c.toString().trim() !== '' && c.toString().trim() !== '-' && c.toString().trim() !== '–' && c.toString().trim() !== '—');
                    if (meaningfulRow.length === 0) return;

                    const firstCellText = (row[0] || '').toString().toLowerCase();
                    const isTotalRow = firstCellText.includes('jumlah') || firstCellText.includes('total');
                    const rowClass = isTotalRow ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
                    tbodyHtml += `<tr class="${rowClass}">`;

                    for (let c = 0; c < maxCols; c++) {
                        const merge = getCellMerge(rIdx, c);
                        if (merge && !merge.isOrigin) {
                            continue;
                        }

                        let rowspan = merge ? merge.rowspan : 1;
                        let colspan = merge ? merge.colspan : 1;
                        let val = (row[c] !== null && row[c] !== undefined) ? row[c].toString().trim() : '';

                        const rSpanAttr = rowspan > 1 ? ` rowspan="${rowspan}"` : '';
                        const cSpanAttr = colspan > 1 ? ` colspan="${colspan}"` : '';
                        
                        let alignClass = 'text-left';
                        const isNumOrRange = !isNaN(parseFloat(val.replace(',', '.'))) || /^\d+\s*[-–]\s*\d+$/.test(val);
                        const isFinTable = (currentOpdCode === '05' || currentTableCode.startsWith('2.4') || currentTableCode.startsWith('2.4.'));
                        
                        if (c === 0) {
                            alignClass = 'text-left font-semibold align-top';
                        } else if (c > 0 && isFinTable) {
                            val = formatRupiahNumber(val);
                            alignClass = `text-right font-semibold align-top ${isTotalRow ? 'font-extrabold' : ''}`;
                        } else if (isNumOrRange) {
                            alignClass = `text-center align-top ${isTotalRow ? 'font-extrabold' : ''}`;
                        } else {
                            alignClass = 'text-left align-top';
                        }

                        let displayVal = val !== '' ? escapeHtml(val) : '<span class="text-slate-400 font-normal">-</span>';
                        if (c === 0 && val.includes('/') && !val.includes('<span')) {
                            const parts = val.split('/');
                            const idPart = parts[0].trim();
                            const enPart = parts.slice(1).join('/').trim();
                            displayVal = `${escapeHtml(idPart)} / <span class="${isTotalRow ? 'italic font-bold' : 'italic font-normal text-slate-700'}">${escapeHtml(enPart)}</span>`;
                        }

                        tbodyHtml += `
                            <td class="py-2.5 px-4 border border-slate-700 ${alignClass}"${rSpanAttr}${cSpanAttr}>
                                ${displayVal}
                            </td>
                        `;
                    }

                    tbodyHtml += `</tr>`;
                });

                tbodyHtml += '</tbody>';
            }

            const completeTableHtml = theadHtml + tbodyHtml;

            // Simpan mapping seluruh data per tahun dari berkas Excel jika ada
            if (Object.keys(excelYearColMap).length > 0) {
                const excelDataByYear = {};
                let katCol = 0;
                for (let c = 0; c < maxCols; c++) {
                    if (!Object.values(excelYearColMap).includes(c)) {
                        katCol = c;
                        break;
                    }
                }
                dataRowIndices.forEach(rIdx => {
                    const row = rawRows[rIdx] || [];
                    const firstCell = (row[katCol] || '').toString().toLowerCase();
                    let rowKey = '';
                    if (currentTableCode === '8.1.1') {
                        rowKey = firstCell.includes('negara') ? 'negara' :
                                (firstCell.includes('provinsi') ? 'provinsi' :
                                (firstCell.includes('kota') ? 'kota' :
                                (firstCell.includes('total') || firstCell.includes('jumlah') ? 'total' : '')));
                    } else if (currentTableCode === '8.1.2') {
                        rowKey = firstCell.includes('aspal') ? 'aspal' :
                                (firstCell.includes('kerikil') ? 'kerikil' :
                                (firstCell.includes('tanah') ? 'tanah' :
                                (firstCell.includes('lainnya') ? 'lainnya' : 
                                (firstCell.includes('total') || firstCell.includes('jumlah') ? 'total' : ''))));
                    } else if (currentTableCode === '8.1.3') {
                        rowKey = firstCell.includes('baik') ? 'baik' :
                                (firstCell.includes('sedang') ? 'sedang' :
                                (firstCell.includes('berat') ? 'rusak_berat' :
                                (firstCell.includes('rusak') ? 'rusak' : 
                                (firstCell.includes('total') || firstCell.includes('jumlah') ? 'total' : ''))));
                    } else if (currentTableCode === '2.2.5') {
                        const dprdKeys = [
                            'peraturan_daerah', 'keputusan_dprd', 'keputusan_pimpinan',
                            'pernyataan', 'pernyataan_pendapat', 'resolusi',
                            'dengar_pendapat', 'paripurna_terbuka', 'paripurna_istimewa',
                            'panitia_musyawarah', 'badan_kehormatan', 'badan_anggaran',
                            'panitia_khusus', 'gabungan_komisi', 'rapat_komisi',
                            'turun_lapangan', 'keluar_daerah', 'rapat_kerja',
                            'penyampaian_aspirasi', 'study_banding', 'reses',
                            'kunker_komisi'
                        ];
                        if (firstCell.includes('jumlah') || firstCell.includes('total')) {
                            rowKey = '';
                        } else {
                            const mNum = firstCell.match(/^0?(\d+)/);
                            if (mNum) {
                                const idx = parseInt(mNum[1], 10) - 1;
                                if (dprdKeys[idx]) rowKey = dprdKeys[idx];
                            }
                        }
                    }
                    if (rowKey) {
                        const targetYears = [yr - 4, yr - 3, yr - 2, yr - 1, yr];
                        targetYears.forEach((y, yIdx) => {
                            const cIdx = excelYearColMap[y] !== undefined ? excelYearColMap[y] : (katCol + 1 + yIdx);
                            let raw = (row[cIdx] !== null && row[cIdx] !== undefined) ? row[cIdx].toString().trim() : '-';
                            if (/^\d+\.\d+$/.test(raw)) raw = raw.replace('.', ',');
                            if (!excelDataByYear[y]) excelDataByYear[y] = {};
                            excelDataByYear[y][rowKey] = raw;
                        });
                    }
                });
                window.uploadedExcelDataByYear = excelDataByYear;
            }

            // 8. Save to localStorage
            localStorage.setItem(`simonda_table_html_${currentTableCode}_${currentYear}`, completeTableHtml);
            localStorage.setItem(`simonda_table_source_${currentTableCode}_${currentYear}`, 'excel');

            if (titleId) {
                localStorage.setItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`, titleId);
            }
            if (titleEn) {
                localStorage.setItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`, titleEn);
            }
            if (extractedSource) {
                localStorage.setItem(`simonda_table_source_text_${currentTableCode}_${currentYear}`, extractedSource);
            }
            if (extractedNote) {
                localStorage.setItem(`simonda_table_note_${currentTableCode}_${currentYear}`, extractedNote);
            }

            // Langsung tandai tersimpan dan simpan ke database MySQL!
            localStorage.setItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '1');

            // 9. Re-render UI dan simpan langsung ke database
            renderTablePage();
            await saveGeneratedExcel(true, fileName);

            const tableSec = document.getElementById('printableTableSection');
            if (tableSec) {
                tableSec.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        async function saveGeneratedExcel(isAuto = false, fileName = '') {
            localStorage.setItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '1');

            const tableHtml = localStorage.getItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
            const titleId = localStorage.getItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`) || (document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText : '');
            const titleEn = localStorage.getItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`) || (document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText : '');
            const source = localStorage.getItem(`simonda_table_source_text_${currentTableCode}_${currentYear}`) || (document.getElementById('tableSourceContent') ? document.getElementById('tableSourceContent').innerHTML : '');
            const note = localStorage.getItem(`simonda_table_note_${currentTableCode}_${currentYear}`);

            // Simpan ke database MySQL
            try {
                let rowsData = null;
                if (currentTableCode === '1.1.6') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const text = tr.innerText.toLowerCase();
                            const tds = tr.querySelectorAll('td');
                            if (text.includes('batang tambuo') && tds.length >= 2) {
                                rowsData[currentYear]['batang_tambuo'] = tds[1].innerText.trim();
                            } else if (text.includes('batang sianok') && tds.length >= 2) {
                                rowsData[currentYear]['batang_sianok'] = tds[1].innerText.trim();
                            }
                        });
                    }
                } else if (currentTableCode === '8.1.1') {
                    rowsData = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const yrInt = parseInt(currentYear) || 2025;
                        const defaultYears = (yrInt <= 2025) ? [2021, 2022, 2023, 2024, 2025] : [yrInt - 4, yrInt - 3, yrInt - 2, yrInt - 1, yrInt];
                        const thYears = [];
                        const ths = tableEl.querySelectorAll('thead tr:first-child th');
                        ths.forEach(th => {
                            const m = th.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) thYears.push(parseInt(m[1], 10));
                        });
                        const targetYears = thYears.length === 5 ? thYears : defaultYears;

                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach((tr, trIdx) => {
                            const tds = tr.querySelectorAll('td');
                            const rowKey = trIdx === 0 ? 'negara' : (trIdx === 1 ? 'provinsi' : (trIdx === 2 ? 'kota' : 'total'));
                            targetYears.forEach((y, yIdx) => {
                                const td = tds[yIdx + 1];
                                if (td) {
                                    if (!rowsData[y]) rowsData[y] = {};
                                    rowsData[y][rowKey] = td.innerText.trim();
                                }
                            });
                        });
                    }
                } else if (currentTableCode === '8.1.2') {
                    rowsData = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const yrInt = parseInt(currentYear) || 2025;
                        const defaultYears = (yrInt <= 2025) ? [2021, 2022, 2023, 2024, 2025] : [yrInt - 4, yrInt - 3, yrInt - 2, yrInt - 1, yrInt];
                        const thYears = [];
                        const ths = tableEl.querySelectorAll('thead tr:first-child th, thead tr:nth-child(2) th');
                        ths.forEach(th => {
                            const m = th.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) thYears.push(parseInt(m[1], 10));
                        });
                        const targetYears = thYears.length === 5 ? thYears : defaultYears;

                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach((tr, trIdx) => {
                            const tds = tr.querySelectorAll('td');
                            const rowKey = trIdx === 0 ? 'aspal' : (trIdx === 1 ? 'kerikil' : (trIdx === 2 ? 'tanah' : (trIdx === 3 ? 'lainnya' : 'total')));
                            targetYears.forEach((y, yIdx) => {
                                const td = tds[yIdx + 1];
                                if (td) {
                                    if (!rowsData[y]) rowsData[y] = {};
                                    rowsData[y][rowKey] = td.innerText.trim();
                                }
                            });
                        });
                    }
                } else if (currentTableCode === '8.1.3') {
                    rowsData = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const yrInt = parseInt(currentYear) || 2025;
                        const defaultYears = (yrInt <= 2025) ? [2021, 2022, 2023, 2024, 2025] : [yrInt - 4, yrInt - 3, yrInt - 2, yrInt - 1, yrInt];
                        const ths = tableEl.querySelectorAll('thead tr:nth-child(2) th');
                        const thYears = [];
                        ths.forEach(th => {
                            const m = th.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) thYears.push(parseInt(m[1], 10));
                        });
                        const targetYears = thYears.length === 5 ? thYears : defaultYears;

                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach((tr, trIdx) => {
                            const tds = tr.querySelectorAll('td');
                            const rowKey = trIdx === 0 ? 'baik' : (trIdx === 1 ? 'sedang' : (trIdx === 2 ? 'rusak' : (trIdx === 3 ? 'rusak_berat' : 'total')));
                            targetYears.forEach((y, yIdx) => {
                                const td = tds[yIdx + 1];
                                if (td) {
                                    if (!rowsData[y]) rowsData[y] = {};
                                    rowsData[y][rowKey] = td.innerText.trim();
                                }
                            });
                        });
                    }
                } else if (currentTableCode === '8.1.4') {
                    rowsData = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const text = tr.innerText.toLowerCase();
                            const tds = tr.querySelectorAll('td');
                            if (text.includes('guguk') && tds.length >= 3) {
                                if (!rowsData[currentYear]) rowsData[currentYear] = {};
                                rowsData[currentYear]['guguk_panjang_unit'] = tds[1].innerText.trim();
                                rowsData[currentYear]['guguk_panjang_panjang'] = tds[2].innerText.trim();
                            } else if (text.includes('mandiangin') && tds.length >= 3) {
                                if (!rowsData[currentYear]) rowsData[currentYear] = {};
                                rowsData[currentYear]['mandiangin_koto_selayan_unit'] = tds[1].innerText.trim();
                                rowsData[currentYear]['mandiangin_koto_selayan_panjang'] = tds[2].innerText.trim();
                            } else if (text.includes('aur birugo') && tds.length >= 3) {
                                if (!rowsData[currentYear]) rowsData[currentYear] = {};
                                rowsData[currentYear]['aur_birugo_tigo_baleh_unit'] = tds[1].innerText.trim();
                                rowsData[currentYear]['aur_birugo_tigo_baleh_panjang'] = tds[2].innerText.trim();
                            }
                        });
                    }
                } else if (currentTableCode === '8.1.5') {
                    rowsData = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach(tr => {
                            const text = tr.innerText.toLowerCase();
                            const tds = tr.querySelectorAll('td');
                            if (text.includes('guguk') && tds.length >= 2) {
                                if (!rowsData[currentYear]) rowsData[currentYear] = {};
                                rowsData[currentYear]['guguk_panjang'] = tds[1].innerText.trim();
                            } else if (text.includes('mandiangin') && tds.length >= 2) {
                                if (!rowsData[currentYear]) rowsData[currentYear] = {};
                                rowsData[currentYear]['mandiangin_koto_selayan'] = tds[1].innerText.trim();
                            } else if (text.includes('aur birugo') && tds.length >= 2) {
                                if (!rowsData[currentYear]) rowsData[currentYear] = {};
                                rowsData[currentYear]['aur_birugo_tigo_baleh'] = tds[1].innerText.trim();
                            }
                        });
                    }
                } else if (currentTableCode === '2.2.5') {
                    rowsData = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const yrInt = parseInt(currentYear) || 2025;
                        const defaultYears = (yrInt <= 2025) ? [2021, 2022, 2023, 2024, 2025] : [yrInt - 4, yrInt - 3, yrInt - 2, yrInt - 1, yrInt];
                        const thYears = [];
                        const ths = tableEl.querySelectorAll('thead tr:first-child th, thead tr:nth-child(2) th');
                        ths.forEach(th => {
                            const m = th.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m && !thYears.includes(parseInt(m[1], 10))) thYears.push(parseInt(m[1], 10));
                        });
                        const targetYears = thYears.length === 5 ? thYears : defaultYears;

                        const dprdKeys = [
                            'peraturan_daerah', 'keputusan_dprd', 'keputusan_pimpinan',
                            'pernyataan', 'pernyataan_pendapat', 'resolusi',
                            'dengar_pendapat', 'paripurna_terbuka', 'paripurna_istimewa',
                            'panitia_musyawarah', 'badan_kehormatan', 'badan_anggaran',
                            'panitia_khusus', 'gabungan_komisi', 'rapat_komisi',
                            'turun_lapangan', 'keluar_daerah', 'rapat_kerja',
                            'penyampaian_aspirasi', 'study_banding', 'reses',
                            'kunker_komisi'
                        ];

                        const trs = tableEl.querySelectorAll('tbody tr');
                        let kIdx = 0;
                        trs.forEach((tr) => {
                            const firstTd = tr.querySelector('td');
                            const firstText = firstTd ? firstTd.innerText.toLowerCase() : '';
                            if (firstText.includes('jumlah') || firstText.includes('total')) {
                                return; // Abaikan baris jumlah
                            }
                            const mNum = firstText.match(/^0?(\d+)/);
                            let rowKey = null;
                            if (mNum) {
                                const idx = parseInt(mNum[1], 10) - 1;
                                if (dprdKeys[idx]) rowKey = dprdKeys[idx];
                            }
                            if (!rowKey && dprdKeys[kIdx]) {
                                rowKey = dprdKeys[kIdx];
                            }
                            kIdx++;

                            if (rowKey) {
                                const tds = tr.querySelectorAll('td');
                                targetYears.forEach((y, yIdx) => {
                                    const td = tds[yIdx + 1];
                                    if (td) {
                                        if (!rowsData[y]) rowsData[y] = {};
                                        rowsData[y][rowKey] = td.innerText.trim();
                                    }
                                });
                            }
                        });
                    }
                } else if (currentTableCode === '2.3.1' || currentTableCode === '2.3.2') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const rowKeys = (currentTableCode === '2.3.2') ? [
                            'sd', 'smp', 'sma', 'di', 'dii', 'diii', 'div', 's1', 's2', 's3'
                        ] : [
                            'jpt_utama', 'jpt_madya', 'jpt_pratama',
                            'administrator', 'pengawas', 'eselon5',
                            'dosen', 'guru', 'medis', 'teknis', 'pelaksana'
                        ];
                        const trs = tableEl.querySelectorAll('tbody tr');
                        let rIdx = 0;
                        trs.forEach(tr => {
                            const tds = tr.querySelectorAll('td');
                            if (tds.length >= 10 && rIdx < rowKeys.length) {
                                const k = rowKeys[rIdx];
                                rowsData[currentYear][`${k}_pns_l`] = tds[1].innerText.trim();
                                rowsData[currentYear][`${k}_pns_p`] = tds[2].innerText.trim();
                                rowsData[currentYear][`${k}_pns_jml`] = tds[3].innerText.trim();
                                rowsData[currentYear][`${k}_pppk_l`] = tds[4].innerText.trim();
                                rowsData[currentYear][`${k}_pppk_p`] = tds[5].innerText.trim();
                                rowsData[currentYear][`${k}_pppk_jml`] = tds[6].innerText.trim();
                                rowsData[currentYear][`${k}_total_l`] = tds[7].innerText.trim();
                                rowsData[currentYear][`${k}_total_p`] = tds[8].innerText.trim();
                                rowsData[currentYear][`${k}_total_jml`] = tds[9].innerText.trim();
                                rIdx++;
                            } else if (tds.length >= 10 && tr.innerText.toLowerCase().includes('jumlah')) {
                                rowsData[currentYear]['total_pns_l'] = tds[1].innerText.trim();
                                rowsData[currentYear]['total_pns_p'] = tds[2].innerText.trim();
                                rowsData[currentYear]['total_pns_jml'] = tds[3].innerText.trim();
                                rowsData[currentYear]['total_pppk_l'] = tds[4].innerText.trim();
                                rowsData[currentYear]['total_pppk_p'] = tds[5].innerText.trim();
                                rowsData[currentYear]['total_pppk_jml'] = tds[6].innerText.trim();
                                rowsData[currentYear]['total_total_l'] = tds[7].innerText.trim();
                                rowsData[currentYear]['total_total_p'] = tds[8].innerText.trim();
                                rowsData[currentYear]['total_total_jml'] = tds[9].innerText.trim();
                            }
                        });
                    }
                } else if (currentTableCode === '2.3.3') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const bodyRows = tableEl.querySelectorAll('tbody tr');
                        bodyRows.forEach(tr => {
                            const key = tr.getAttribute('data-key');
                            const tds = tr.querySelectorAll('td');
                            if (key && tds.length >= 5) {
                                rowsData[currentYear][`${key}_l`] = tds[2].innerText.trim();
                                rowsData[currentYear][`${key}_p`] = tds[3].innerText.trim();
                                rowsData[currentYear][`${key}_jml`] = tds[4].innerText.trim();
                            } else if (tr.getAttribute('data-total') === 'true' && tds.length >= 4) {
                                rowsData[currentYear]['total_l'] = tds[1].innerText.trim();
                                rowsData[currentYear]['total_p'] = tds[2].innerText.trim();
                                rowsData[currentYear]['total_jml'] = tds[3].innerText.trim();
                            }
                        });
                    }
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
                                rowsData[currentYear][`${key}_pns`] = tds[1].innerText.trim();
                                rowsData[currentYear][`${key}_pppk`] = tds[2].innerText.trim();
                                rowsData[currentYear][`${key}_jml`] = tds[3].innerText.trim();
                            } else if (tr.getAttribute('data-total') === 'true' && tds.length >= 4) {
                                rowsData[currentYear]['total_pns'] = tds[1].innerText.trim();
                                rowsData[currentYear]['total_pppk'] = tds[2].innerText.trim();
                                rowsData[currentYear]['total_jml'] = tds[3].innerText.trim();
                            }
                        });
                    }
                }

                // Gabungkan seluruh data per tahun dari Excel jika ada
                if (window.uploadedExcelDataByYear && typeof rowsData === 'object' && rowsData !== null) {
                    Object.keys(window.uploadedExcelDataByYear).forEach(y => {
                        if (!rowsData[y]) rowsData[y] = {};
                        Object.assign(rowsData[y], window.uploadedExcelDataByYear[y]);
                    });
                }

                await fetch('"dummy"', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        table_html: tableHtml,
                        title_id: titleId,
                        title_en: titleEn,
                        source: source,
                        note: note,
                        source_type: 'excel',
                        rows_data: rowsData
                    })
                });

                // Ambil data terbaru dari database MySQL untuk tahun ini
                const res = await fetch(`"dummy"?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`);
                const dataRes = await res.json();
                if (dataRes.success) {
                    if (dataRes.dataStore) {
                        Object.assign(serverDbDataStore, dataRes.dataStore);
                    }
                    if (dataRes.metadata !== undefined) {
                        serverDbMetadata = dataRes.metadata;
                    }
                }
            } catch(e) {
                console.warn('Gagal menyimpan ke database:', e);
            }

            renderTablePage();
            if (isAuto) {
                showToast(`✅ Data ${fileName ? `dari ${fileName} ` : ''}berhasil diimpor & langsung tersimpan ke Database SiAngka!`);
            } else {
                showToast(`💾 Data Tabel ${currentTableCode} Tahun ${currentYear} berhasil disimpan permanen di Database SiAngka!`);
            }
        }

        async function resetGeneratedExcel() {
            if (confirm(`Apakah Anda yakin ingin menghapus data hasil generate Excel untuk Tahun ${currentYear}?`)) {
                localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_source_text_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_note_${currentTableCode}_${currentYear}`);

                // Hapus juga di database MySQL
                try {
                    await fetch('"dummy"', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            table_code: currentTableCode,
                            opd_code: currentOpdCode,
                            year: currentYear
                        })
                    });
                } catch(e) {}

                renderTablePage();
                showToast('🗑️ Data Excel tahun ini berhasil dihapus dari database.');
            }
        }

        function escapeHtml(str) {
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function setupDragAndDrop() {
            const dropZone = document.getElementById('excelDropZone');
            if (!dropZone) return;

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('border-emerald-600', 'bg-emerald-100/50');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('border-emerald-600', 'bg-emerald-100/50');
                }, false);
            });

            dropZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length > 0) {
                    const fakeEvent = { target: { files: files, value: '' } };
                    handleExcelFileSelected(fakeEvent);
                }
            }, false);
        }

        function fallbackCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showToast('📋 Format tabel disalin! Tekan Ctrl+V pada Google Sheets atau Excel.');
        }

        // EXPORT DROPDOWN TOGGLE HANDLERS
        function toggleExportDropdown(position) {
            const menu = document.getElementById('exportDropdownMenu' + position);
            const chevron = document.getElementById('exportChevron' + position);
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');

            // Close other dropdowns first
            closeAllExportDropdowns();

            if (isHidden) {
                menu.classList.remove('hidden');
                if (chevron) {
                    chevron.classList.add(position === 'Top' ? 'rotate-180' : '-rotate-180');
                }
            }
        }

        function closeAllExportDropdowns() {
            ['Top', 'Bottom'].forEach(pos => {
                const menu = document.getElementById('exportDropdownMenu' + pos);
                const chevron = document.getElementById('exportChevron' + pos);
                if (menu) menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180', '-rotate-180');
            });
        }

        // Close dropdowns on click outside or escape key
        document.addEventListener('click', function (e) {
            const topCont = document.getElementById('exportDropdownContainerTop');
            const botCont = document.getElementById('exportDropdownContainerBottom');
            const clickedInsideTop = topCont && topCont.contains(e.target);
            const clickedInsideBot = botCont && botCont.contains(e.target);

            if (!clickedInsideTop && !clickedInsideBot) {
                closeAllExportDropdowns();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAllExportDropdowns();
            }
        });

        /**
         * Export to Excel (.xlsx) matching the exact official BPS publication layout
         */
        function exportToExcel() {
            const tableEl = document.getElementById('dataDisplayTable');
            const opdName = getAgencyName(currentOpdCode);
            const titleId = document.getElementById('metaTableTitleId').innerText;
            const titleEn = document.getElementById('metaTableTitleEn').innerText;
            const source = document.getElementById('tableSourceContent').innerText.replace(/<[^>]*>?/gm, '');

            if (typeof XLSX !== 'undefined') {
                const wb = XLSX.utils.book_new();
                const ws = {};
                const merges = [];

                // Border styles - crisp thin border
                const borderThin = {
                    top: { style: 'thin', color: { rgb: '334155' } },
                    bottom: { style: 'thin', color: { rgb: '334155' } },
                    left: { style: 'thin', color: { rgb: '334155' } },
                    right: { style: 'thin', color: { rgb: '334155' } }
                };

                const headerOrangeStyle = {
                    fill: { fgColor: { rgb: 'F95A00' } },
                    font: { name: 'Calibri', sz: 9.5, bold: true, color: { rgb: 'FFFFFF' } },
                    alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                    border: borderThin
                };

                const headerPeachStyle = {
                    fill: { fgColor: { rgb: 'FED7AA' } },
                    font: { name: 'Calibri', sz: 9, bold: true, color: { rgb: '000000' } },
                    alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                    border: borderThin
                };

                const dataCellStyle = {
                    fill: { fgColor: { rgb: 'FFFFFF' } },
                    font: { name: 'Calibri', sz: 9, color: { rgb: '000000' } },
                    alignment: { horizontal: 'left', vertical: 'center', wrapText: true },
                    border: borderThin
                };

                const dataCenterStyle = {
                    fill: { fgColor: { rgb: 'FFFFFF' } },
                    font: { name: 'Calibri', sz: 9, color: { rgb: '000000' } },
                    alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                    border: borderThin
                };

                const dataRightStyle = {
                    fill: { fgColor: { rgb: 'FFFFFF' } },
                    font: { name: 'Calibri', sz: 9, color: { rgb: '000000' } },
                    alignment: { horizontal: 'right', vertical: 'center', wrapText: true },
                    border: borderThin
                };

                function setCell(row, col, value, style) {
                    const cellRef = XLSX.utils.encode_cell({ r: row, c: col });
                    ws[cellRef] = {
                        v: value,
                        t: typeof value === 'number' ? 'n' : 's',
                        s: style || {}
                    };
                }

                // Row counter
                let r = 0;

                // 1. EXACT BPS TITLE BLOCK (A1 & B1, A2 & B2):
                setCell(r, 0, `Tabel ${currentTableCode}`, {
                    font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } }
                });
                setCell(r, 1, titleId, {
                    font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } }
                });
                r++;

                setCell(r, 0, 'Table', {
                    font: { name: 'Calibri', sz: 10, bold: true, italic: true, color: { rgb: '000000' } }
                });
                setCell(r, 1, titleEn, {
                    font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } }
                });
                r += 2; // Row 3 is blank, table starts at Row 4 (0-indexed row 3)

                const tableStartRow = r;

                // 2. FOR TABLE 1.1.6: Exact 4-column BPS Layout (Kolom C = No 1, 2; Kolom D = Nama Kecamatan)
                if (currentTableCode === '1.1.6') {
                    // Header Row 4:
                    setCell(r, 0, 'Nama Sungai (Batang)/Name of The River', headerOrangeStyle);
                    setCell(r, 1, 'Lebar/Width (M)', headerOrangeStyle);
                    setCell(r, 2, 'Kecamatan yang Dilalui/District Its Pass', headerOrangeStyle);
                    setCell(r, 3, '', headerOrangeStyle);
                    merges.push({ s: { r: r, c: 2 }, e: { r: r, c: 3 } }); // Merge C4:D4
                    r++;

                    // Numbering Row 5:
                    setCell(r, 0, '(1)', headerPeachStyle);
                    setCell(r, 1, '(2)', headerPeachStyle);
                    setCell(r, 2, '(3)', headerPeachStyle);
                    setCell(r, 3, '', headerPeachStyle);
                    merges.push({ s: { r: r, c: 2 }, e: { r: r, c: 3 } }); // Merge C5:D5
                    r++;

                    // Parse data rows
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    let riverGroups = [];
                    let activeRiver = null;

                    bodyRows.forEach(tr => {
                        const tds = tr.querySelectorAll('td');
                        if (tds.length === 0) return;

                        if (tds.length >= 3) {
                            // First row of river
                            const name = tds[0].innerText.trim();
                            const width = tds[1].innerText.trim();
                            let num = '1';
                            let distName = '';

                            if (tds.length >= 4) {
                                num = tds[2].innerText.trim();
                                distName = tds[3].innerText.trim();
                            } else {
                                const raw = tds[2].innerText.trim();
                                const m = raw.match(/^(\d+)\.?\s*(.*)$/);
                                if (m) {
                                    num = m[1];
                                    distName = m[2];
                                } else {
                                    distName = raw;
                                }
                            }

                            activeRiver = {
                                name: name,
                                width: width,
                                subdistricts: [{ num: num, name: distName }]
                            };
                            riverGroups.push(activeRiver);
                        } else if (tds.length >= 1 && activeRiver) {
                            // Continuation row of river
                            let num = (activeRiver.subdistricts.length + 1).toString();
                            let distName = '';

                            if (tds.length >= 2) {
                                num = tds[0].innerText.trim();
                                distName = tds[1].innerText.trim();
                            } else {
                                const raw = tds[0].innerText.trim();
                                const m = raw.match(/^(\d+)\.?\s*(.*)$/);
                                if (m) {
                                    num = m[1];
                                    distName = m[2];
                                } else {
                                    distName = raw;
                                }
                            }
                            activeRiver.subdistricts.push({ num: num, name: distName });
                        }
                    });

                    // Fallback if empty
                    if (riverGroups.length === 0) {
                        riverGroups = [
                            {
                                name: '01. Batang Tambuo',
                                width: '5–7',
                                subdistricts: [
                                    { num: '1', name: 'Aur Birugo Tigo Baleh' },
                                    { num: '2', name: 'Mandiangin Koto Selayan' }
                                ]
                            },
                            {
                                name: '02. Batang Sianok',
                                width: '12–15',
                                subdistricts: [
                                    { num: '1', name: 'Aur Birugo Tigo Baleh' },
                                    { num: '2', name: 'Guguk Panjang' }
                                ]
                            }
                        ];
                    }

                    // Render groups into worksheet with vertical merges
                    riverGroups.forEach(rg => {
                        const startRow = r;
                        const span = rg.subdistricts.length;

                        rg.subdistricts.forEach((sub, sIdx) => {
                            const curR = startRow + sIdx;
                            setCell(curR, 0, sIdx === 0 ? rg.name : '', dataCellStyle);
                            setCell(curR, 1, sIdx === 0 ? rg.width : '', dataCenterStyle);
                            const parsedNum = parseInt(sub.num, 10);
                            setCell(curR, 2, !isNaN(parsedNum) ? parsedNum : sub.num, dataCenterStyle);
                            setCell(curR, 3, sub.name, dataCellStyle);
                        });

                        if (span > 1) {
                            merges.push({ s: { r: startRow, c: 0 }, e: { r: startRow + span - 1, c: 0 } });
                            merges.push({ s: { r: startRow, c: 1 }, e: { r: startRow + span - 1, c: 1 } });
                        }

                        r += span;
                    });

                    // Blank row
                    r++;

                    // Footer Source (exactly matching BPS: Row 11 & Row 12)
                    setCell(r, 0, 'Sumber/Source:', {
                        font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } }
                    });
                    setCell(r, 1, 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi/', {
                        font: { name: 'Calibri', sz: 10, color: { rgb: '000000' } }
                    });
                    r++;
                    setCell(r, 1, 'Public Work and Spatial Planning Service of Bukittinggi Municipality', {
                        font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } }
                    });

                    ws['!cols'] = [
                        { wch: 26 }, // Col A: Nama Sungai
                        { wch: 14 }, // Col B: Lebar
                        { wch: 5 },  // Col C: No (1, 2)
                        { wch: 28 }  // Col D: Kecamatan
                    ];

                    ws['!ref'] = XLSX.utils.encode_range({
                        s: { r: 0, c: 0 },
                        e: { r: r + 1, c: 3 }
                    });

                    ws['!merges'] = merges;
                } else {
                    // GENERAL TABLES: Standard BPS table export
                    const theadRows = tableEl.querySelectorAll('thead tr');
                    const tbodyRows = tableEl.querySelectorAll('tbody tr');
                    const allRows = Array.from(theadRows).concat(Array.from(tbodyRows));

                    const grid = [];
                    let gridRowIdx = 0;

                    allRows.forEach((tr, trIdx) => {
                        const isHeader = tr.closest('thead') !== null;
                        const isSubHeader = isHeader && trIdx > 0;
                        const cells = tr.querySelectorAll('th, td');

                        if (!grid[gridRowIdx]) grid[gridRowIdx] = [];
                        let gridColIdx = 0;

                        cells.forEach(cell => {
                            while (grid[gridRowIdx][gridColIdx]) {
                                gridColIdx++;
                            }

                            const colspan = parseInt(cell.getAttribute('colspan') || 1, 10);
                            const rowspan = parseInt(cell.getAttribute('rowspan') || 1, 10);
                            const text = getCellText(cell);

                            let style = dataCellStyle;
                            if (isHeader) {
                                style = isSubHeader ? headerPeachStyle : headerOrangeStyle;
                            } else if (cell.classList.contains('text-center') || text.trim() === '-' || /^\(\d+\)$/.test(text.trim())) {
                                style = dataCenterStyle;
                            } else if (cell.classList.contains('text-right') || /^[\d,.-]+$/.test(text.trim())) {
                                style = dataRightStyle;
                            }

                            for (let ro = 0; ro < rowspan; ro++) {
                                for (let co = 0; co < colspan; co++) {
                                    const targetR = gridRowIdx + ro;
                                    const targetC = gridColIdx + co;
                                    if (!grid[targetR]) grid[targetR] = [];
                                    grid[targetR][targetC] = {
                                        val: (ro === 0 && co === 0) ? text : '',
                                        style: style
                                    };
                                }
                            }

                            if (colspan > 1 || rowspan > 1) {
                                merges.push({
                                    s: { r: tableStartRow + gridRowIdx, c: gridColIdx },
                                    e: { r: tableStartRow + gridRowIdx + rowspan - 1, c: gridColIdx + colspan - 1 }
                                });
                            }

                            gridColIdx += colspan;
                        });

                        gridRowIdx++;
                    });

                    let maxCol = 0;
                    grid.forEach(row => { if (row.length > maxCol) maxCol = row.length; });
                    if (maxCol < 1) maxCol = 1;

                    grid.forEach((row, ri) => {
                        row.forEach((cellData, ci) => {
                            if (cellData) {
                                setCell(tableStartRow + ri, ci, cellData.val, cellData.style);
                            }
                        });
                    });

                    r = tableStartRow + grid.length + 1;

                    const noteContentEl = document.getElementById('tableNoteContent');
                    const noteRowEl = document.getElementById('tableNoteRow');
                    if (noteRowEl && !noteRowEl.classList.contains('hidden') && noteContentEl && noteContentEl.innerText.trim()) {
                        setCell(r, 0, 'Catatan / Note:', {
                            font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } }
                        });
                        const noteLines = noteContentEl.innerText.trim().split('\n').filter(l => l.trim() !== '');
                        noteLines.forEach((nl, nlIdx) => {
                            setCell(r + nlIdx, 1, nl.trim(), {
                                font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } }
                            });
                        });
                        r += Math.max(noteLines.length, 1) + 1;
                    }

                    const cleanSource = source
                        .replace(/<[^>]*>?/gm, '')
                        .replace(/\/+/g, ' / ')
                        .replace(/\s+/g, ' ')
                        .trim();

                    setCell(r, 0, 'Sumber / Source:', {
                        font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } }
                    });
                    setCell(r, 1, cleanSource, {
                        font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } }
                    });

                    const colWidths = [];
                    for (let c = 0; c < maxCol; c++) {
                        let maxLen = 8;
                        grid.forEach(row => {
                            if (row[c] && row[c].val) {
                                const lines = row[c].val.toString().split('\n');
                                lines.forEach(l => {
                                    if (l.trim().length > maxLen) maxLen = l.trim().length;
                                });
                            }
                        });
                        if (c === 0) {
                            // Kolom Uraian: pas dan tidak terlalu lebar, teks wrap ke bawah
                            colWidths.push({ wch: Math.min(Math.max(maxLen + 2, 20), 28) });
                        } else {
                            // Kolom Data Tahun: kompak pas untuk angka/strip agar muat 1 halaman A4
                            colWidths.push({ wch: Math.min(Math.max(maxLen + 2, 9), 12) });
                        }
                    }
                    ws['!cols'] = colWidths;

                    ws['!ref'] = XLSX.utils.encode_range({
                        s: { r: 0, c: 0 },
                        e: { r: r + 1, c: maxCol - 1 }
                    });

                    ws['!merges'] = merges;
                }

                // Row Heights for compact publication look fitting A4 page
                const rowHeights = [];
                for (let ri = 0; ri < r + 2; ri++) {
                    if (ri < tableStartRow) {
                        rowHeights.push({ hpt: 18 });
                    } else if (ri === tableStartRow) {
                        rowHeights.push({ hpt: 26 }); // Header row
                    } else if (ri === tableStartRow + 1) {
                        rowHeights.push({ hpt: 18 }); // Numbering row (1), (2), (3)
                    } else if (ri < r - 1) {
                        rowHeights.push({ hpt: 19 }); // Data rows
                    } else {
                        rowHeights.push({ hpt: 18 });
                    }
                }
                ws['!rows'] = rowHeights;

                // Excel Page Setup: Pas A4 Landscape & Fit to 1 Page Width agar cetak rapi tidak terpotong
                if (!ws['!sheetPr']) ws['!sheetPr'] = {};
                ws['!sheetPr'].pageSetUpPr = { fitToPage: true };

                ws['!pageSetup'] = {
                    paperSize: 9,              // 9 = A4 Paper
                    orientation: 'landscape',  // Horizontal (Landscape)
                    fitToWidth: 1,             // Seluruh kolom pas 1 halaman lebar (tidak terbagi 2 halaman)
                    fitToHeight: 0,            // Baris berlanjut alami ke bawah bila banyak
                    fitToPage: true,
                    scale: 100
                };

                ws['!margins'] = {
                    left: 0.4,
                    right: 0.4,
                    top: 0.5,
                    bottom: 0.5,
                    header: 0.2,
                    footer: 0.2
                };

                XLSX.utils.book_append_sheet(wb, ws, `Tabel ${currentTableCode}`);

                const safeOpd = opdName.substring(0, 20).replace(/[^a-zA-Z0-9]/g, '_');
                const fileName = `Tabel_${currentTableCode.replace(/\./g, '_')}_${safeOpd}_${currentYear}.xlsx`;
                XLSX.writeFile(wb, fileName);
                showToast(`📗 File Excel (${fileName}) berformat standar BPS resmi berhasil diunduh!`);
            } else {
                showToast('Fitur Excel sedang disiapkan, beralih ke format cetak...');
                window.print();
            }
        }

        /**
         * Export to Official PDF (.pdf) using jsPDF & AutoTable
         */
        function exportToPDF() {
            const opdName = getAgencyName(currentOpdCode);
            const titleId = document.getElementById('metaTableTitleId').innerText;
            const titleEn = document.getElementById('metaTableTitleEn').innerText;
            const source = document.getElementById('tableSourceContent').innerText.replace(/<[^>]*>?/gm, '');

            if (window.jspdf && window.jspdf.jsPDF) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });

                // Header BPS
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(13);
                doc.setTextColor(249, 90, 0); // BPS Orange #f95a00
                doc.text('BADAN PUSAT STATISTIK KOTA BUKITTINGGI', 14, 14);

                doc.setFontSize(9.5);
                doc.setTextColor(71, 85, 105);
                doc.setFont('helvetica', 'normal');
                doc.text('Sistem Informasi Data Daerah dalam Angka (SiAngka) Kota Bukittinggi', 14, 19.5);

                // Divider Line
                doc.setDrawColor(226, 232, 240);
                doc.setLineWidth(0.4);
                doc.line(14, 22, 283, 22);

                // Table Title Header
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(11);
                doc.setTextColor(15, 23, 42);
                doc.text(`Tabel / Table ${currentTableCode} (${currentYear})`, 14, 29);

                doc.setFontSize(10.5);
                doc.text(titleId, 14, 34);

                doc.setFont('helvetica', 'italic');
                doc.setFontSize(9.5);
                doc.setTextColor(100, 116, 139);
                doc.text(titleEn, 14, 39);

                // AutoTable Generator from HTML
                doc.autoTable({
                    html: '#dataDisplayTable',
                    startY: 44,
                    theme: 'grid',
                    headStyles: {
                        fillColor: [249, 90, 0], // #f95a00
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center',
                        valign: 'middle',
                        lineWidth: 0.2,
                        lineColor: [51, 65, 85]
                    },
                    bodyStyles: {
                        textColor: [30, 41, 59],
                        lineWidth: 0.2,
                        lineColor: [51, 65, 85]
                    },
                    alternateRowStyles: {
                        fillColor: [254, 249, 195] // #fef9c3 Light yellow like BDA
                    },
                    styles: {
                        font: 'helvetica',
                        fontSize: 8.5,
                        cellPadding: 2.8
                    },
                    didParseCell: function(data) {
                        if (data.cell.raw && data.cell.raw.querySelector) {
                            const ta = data.cell.raw.querySelector('.pma-textarea');
                            if (ta) {
                                data.cell.text = [ta.value.trim()];
                            }
                        }
                    },
                    margin: { left: 14, right: 14 }
                });

                const finalY = doc.lastAutoTable.finalY || 140;

                // Source Note
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(8.5);
                doc.setTextColor(51, 65, 85);
                doc.text('Sumber / Source:', 14, finalY + 7);
                doc.setFont('helvetica', 'normal');
                doc.text(source, 42, finalY + 7);

                // Document Footer
                doc.setFontSize(7.5);
                doc.setTextColor(148, 163, 184);
                doc.text(`Dokumen resmi statistik sektoral diexport melalui SiAngka Kota Bukittinggi pada ${new Date().toLocaleString('id-ID')}`, 14, 198);

                const safeOpd = opdName.substring(0, 20).replace(/[^a-zA-Z0-9]/g, '_');
                const fileName = `Tabel_${currentTableCode.replace(/\./g, '_')}_${safeOpd}_${currentYear}.pdf`;
                doc.save(fileName);
                showToast(`📕 File PDF (${fileName}) berhasil diunduh!`);
            } else {
                printTableLandscape();
            }
        }

        /**
         * Print Table in Landscape Orientation (Excel-style neat layout)
         */
        function printTableLandscape() {
            // Update OPD Subheading in print header
            const opdName = getAgencyName(currentOpdCode);
            const opdSubheading = document.getElementById('printOpdSubheading');
            if (opdSubheading) {
                opdSubheading.innerText = `${currentType === 'instansi' ? 'Instansi' : 'OPD'} Penyelenggara Data: ${currentOpdCode}. ${opdName}`;
            }

            // Update timestamp
            const now = new Date();
            const dateStr = now.toLocaleDateString('id-ID', { 
                day: 'numeric', 
                month: 'long', 
                year: 'numeric' 
            });
            const timeStr = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            const tsEl = document.getElementById('printTimestamp');
            if (tsEl) {
                tsEl.innerText = `Waktu Cetak: ${dateStr}, ${timeStr} WIB`;
            }

            // Close any open dropdowns or upload drawer
            closeAllExportDropdowns();
            if (typeof toggleExcelUploadForm === 'function') {
                toggleExcelUploadForm(false);
            }

            // Small delay to allow any DOM updates to render before dialog
            setTimeout(() => {
                window.print();
            }, 100);
        }

        // Toast Notification Helper
        let toastTimeout;
        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const msgEl = document.getElementById('toastMessage');
            msgEl.innerText = message;

            toast.classList.remove('translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3500);
        }

        document.addEventListener('DOMContentLoaded', initPage);
    