/**
 * SiBingka Kota Bukittinggi - Table Editable Form Schemas
 * Dikelola secara modular untuk edit.blade.php
 */

window.tableSchemas = {
            '4.1.18': {
                titleId: 'Jumlah Dosen di Perguruan Tinggi',
                titleEn: 'Number of Lecturer in Bukittinggi',
                isMultiYear: true,
                render: function(year) {
                    const yrInt = parseInt(year) || 2025;
                    const cOpd = (typeof currentOpdCode !== 'undefined') ? String(currentOpdCode).padStart(2, '0') : '';
                    const is3Year = (cOpd === '07');
                    const years = is3Year 
                        ? [yrInt - 2, yrInt - 1, yrInt] 
                        : [yrInt - 4, yrInt - 3, yrInt - 2, yrInt - 1, yrInt];
                    let rowsHtml = '';
                    years.forEach(y => {
                        rowsHtml += `
                            <tr class="hover:bg-amber-50">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-right">${y}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">-</td>
                            </tr>
                        `;
                    });
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Perguruan Tinggi</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">College</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                    <div>Dosen</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Lecturer</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Tetap</div><div class="italic font-normal text-[11px] sm:text-xs">Full Time</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Tidak tetap</div><div class="italic font-normal text-[11px] sm:text-xs">Part Time</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Asisten</div><div class="italic font-normal text-[11px] sm:text-xs">Assistant</div></th>
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
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.1.19': {
                titleId: 'Jumlah Mahasiswa dan Lulusan di Perguruan Tinggi',
                titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi',
                isMultiYear: true,
                render: function(year) {
                    const yrInt = parseInt(year) || 2025;
                    const cOpd = (typeof currentOpdCode !== 'undefined') ? String(currentOpdCode).padStart(2, '0') : '';
                    const is3Year = (cOpd === '07');
                    const years = is3Year 
                        ? [yrInt - 2, yrInt - 1, yrInt] 
                        : [yrInt - 4, yrInt - 3, yrInt - 2, yrInt - 1, yrInt];
                    let rowsHtml = '';
                    years.forEach(y => {
                        rowsHtml += `
                            <tr class="hover:bg-amber-50">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-right">${y}</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold">-</td>
                            </tr>
                        `;
                    });
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Perguruan Tinggi</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">College</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                    <div>Mahasiswa</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                    <div>Lulusan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Graduated</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Laki-laki</div><div class="italic font-normal text-[11px] sm:text-xs">Male</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[11px] sm:text-xs">Female</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Laki-laki</div><div class="italic font-normal text-[11px] sm:text-xs">Male</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[11px] sm:text-xs">Female</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
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
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Nama Sungai (Batang)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Name of The River</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lebar (M)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Width (M)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
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
                                <td class="py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800">1</td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Aur Birugo Tigo Baleh
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800">2</td>
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
                                <td class="py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800">1</td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Aur Birugo Tigo Baleh
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800">2</td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Guguk Panjang
                                </td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '1.1.8': {
                titleId: 'Jumlah Pembuatan Sertifikat Menurut Jenis Kepemilikan di Kota Bukittinggi',
                titleEn: 'Number of Issued Land Certificates by Type of Ownership in Bukittinggi',
                source: 'Kantor Pertanahan Kota Bukittinggi (BPN) / <span class="italic text-slate-500">Land Office of Bukittinggi Municipality</span>',
                isMultiYear: true,
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const startYr = yr - 6;
                    const known = {
                        2017: ['68', '4', '10', '–', '–', '596'],
                        2018: ['1.167', '14', '5', '0', '0', '-'],
                        2019: ['995', '8', '31', '0', '0', '-'],
                        2020: ['410', '9', '23', '0', '0', '268'],
                        2021: ['433', '6', '18', '0', '0', '433'],
                        2022: ['369', '3', '135', '0', '0', '400'],
                        2023: ['751', '7', '65', '0', '0', '398'],
                        2024: ['774', '9', '72', '0', '0', '392'],
                        2025: ['200', '5', '35', '-', '-', '286']
                    };
                    let rowsHtml = '';
                    for (let y = startYr; y <= yr; y++) {
                        const vals = known[y] || ['-', '-', '-', '-', '-', '-'];
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${y}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${vals[0]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${vals[1]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${vals[2]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${vals[3]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${vals[4]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${vals[5]}</td>
                            </tr>
                        `;
                    }
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Hak Milik</div><div class="italic font-normal text-[11px] sm:text-xs">Freehold Title</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Hak Guna Bangunan</div><div class="italic font-normal text-[11px] sm:text-xs">Building Rights Title</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Hak Pakai</div><div class="italic font-normal text-[11px] sm:text-xs">Right of Use Title</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Hak Pengelolaan</div><div class="italic font-normal text-[11px] sm:text-xs">Management Rights</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Hak Guna Usaha</div><div class="italic font-normal text-[11px] sm:text-xs">Commercial Exploitation Rights</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>Hak Tanggungan</div><div class="italic font-normal text-[11px] sm:text-xs">Mortgage Rights</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
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
            '1.1.9': {
                titleId: 'Jumlah Pencatatan Peralihan Hak Menurut Jenis Kepemilikan di Kota Bukittinggi',
                titleEn: 'Number of Title Transfer Registrations by Type of Ownership in Bukittinggi Municipality',
                source: 'Kantor Pertanahan Kota Bukittinggi (BPN) / <span class="italic text-slate-500">Land Office of Bukittinggi Municipality</span>',
                isMultiYear: true,
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
                isMultiYear: false,
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
            '11.3': {
                titleId: 'Jumlah Nomor Izin Berusaha (NIB) yang Dikeluarkan per Bulan di Kota Bukittinggi',
                titleEn: 'Number of Business Identification Numbers (NIB) Issued by Month in Bukittinggi Municipality',
                isMultiYear: false,
                source: 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kota Bukittinggi / <span class="italic text-slate-500">Investment and Integrated One-Stop Services Office of Bukittinggi Municipality</span>',
                note: 'Catatan / <span class="italic text-slate-500">Note</span>: Tahun 2020-2023 masih berupa Surat Izin Usaha Perdagangan (SIUP) / <span class="italic text-slate-500">In 2020-2023 was still a Trading Business License (SIUP)</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const months = [
                        { key: 'jan', label: '01. Januari / January', def: '386' },
                        { key: 'feb', label: '02. Februari / February', def: '460' },
                        { key: 'mar', label: '03. Maret / March', def: '254' },
                        { key: 'apr', label: '04. April / April', def: '250' },
                        { key: 'mei', label: '05. Mei / May', def: '289' },
                        { key: 'jun', label: '06. Juni / June', def: '260' },
                        { key: 'jul', label: '07. Juli / July', def: '293' },
                        { key: 'ags', label: '08. Agustus / August', def: '301' },
                        { key: 'sep', label: '09. September / September', def: '330' },
                        { key: 'okt', label: '10. Oktober / October', def: '283' },
                        { key: 'nov', label: '11. November / November', def: '211' },
                        { key: 'des', label: '12. Desember / December', def: '248' }
                    ];

                    const storeYr = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                    let monthRowsHtml = '';
                    months.forEach(m => {
                        const val = (storeYr[m.key] !== undefined && storeYr[m.key] !== '') ? storeYr[m.key] : (yr === 2025 ? m.def : '-');
                        monthRowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold align-middle" colspan="2">${m.label}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">
                                    <input type="text" class="w-full text-center bg-white border border-slate-300 rounded px-2 py-1 text-xs table-edit-input" data-key="${m.key}" value="${val}">
                                </td>
                            </tr>
                        `;
                    });

                    const historyRows = [
                        { key: 'total_' + yr, yrLabel: `${yr}`, val: (yr === 2025 ? '3.565' : '-'), isCurrent: true },
                        { key: 'total_2024', yrLabel: '2024', val: (storeYr['total_2024'] || '6.008'), isCurrent: false },
                        { key: 'total_2023', yrLabel: '2023 (SIUP)', val: (storeYr['total_2023'] || '6.907'), isCurrent: false },
                        { key: 'total_2022', yrLabel: '2022 (SIUP)', val: (storeYr['total_2022'] || '2.542'), isCurrent: false },
                        { key: 'total_2021', yrLabel: '2021 (SIUP)', val: (storeYr['total_2021'] || '260'), isCurrent: false },
                        { key: 'total_2020', yrLabel: '2020 (SIUP)', val: (storeYr['total_2020'] || '278'), isCurrent: false }
                    ];

                    let totalRowsHtml = '';
                    historyRows.forEach((h, idx) => {
                        const rowClass = h.isCurrent ? 'bg-[#fed7aa] font-bold text-slate-900 border-t border-slate-700' : 'hover:bg-amber-100/60 transition-colors bg-[#fed7aa] font-bold text-slate-900';
                        totalRowsHtml += `<tr class="${rowClass}">`;
                        if (idx === 0) {
                            totalRowsHtml += `
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle bg-amber-50/70" rowspan="${historyRows.length}">
                                    <div>Jumlah</div>
                                    <div class="italic font-bold text-xs">Total</div>
                                </td>
                            `;
                        }
                        totalRowsHtml += `
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle font-bold">${h.yrLabel}</td>
                            <td class="py-1 px-2 border border-slate-700 text-center align-middle">
                                <input type="text" class="w-full text-center bg-white border border-slate-300 rounded px-2 py-1 text-xs table-edit-input" data-key="${h.key}" value="${h.val}">
                            </td>
                        </tr>`;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Bulan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Month</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${monthRowsHtml}
                            ${totalRowsHtml}
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
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Nama Sungai (Batang)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Name of The River</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lebar (M)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Width (M)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
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
                                <td class="py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800">1</td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Aur Birugo Tigo Baleh
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800">2</td>
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
                                <td class="py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800">1</td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Aur Birugo Tigo Baleh
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800">2</td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Guguk Panjang
                                </td>
                            </tr>
                        </tbody>
                    `;
                }
            },
                        '4.1.1': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Taman Kanak-Kanak (TK) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Kindergarten Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality',
                source: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Data Semester Ganjil / <span class=\"italic text-slate-500\">Ministry of Education, Culture, Research, and Technology, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '16'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '16'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '16'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '51'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '51'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '51'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '53'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '53'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '53'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA GURU -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '102'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '94'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '115'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '102'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '94'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '115'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '109'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '95'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '124'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '115'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '100'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '130'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '14'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '12'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '12'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '97'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '69'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '103'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '111'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '81'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '115'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '20'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '308'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '258'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '342'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '328'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '275'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '360'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA MURID -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '950'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '948'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '963'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '950'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '948'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '963'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '55'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '46'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '69'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1041'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1068'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1189'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1096'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1114'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1258'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '196'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '201'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '167'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '789'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '748'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '795'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '985'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '949'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '962'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '251'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '247'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '236'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2780'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2764'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2947'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '3031'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '3011'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '3183'}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
                                    '4.1.2': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Raudatul Athfal (RA) di Bawah Kementerian Agama Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Kindergarten Under The Ministry of Religious Affairs by District in Bukittinggi Municipality',
                source: 'Kementerian Agama, EMIS, Data Semester Ganjil / <span class="italic text-slate-500">Ministry of Religious Affairs, EMIS, Odd Semester Data</span>',
                note: 'Seluruh Raudatul Athfal (RA) berstatus swasta / <span class="italic text-slate-500">All Raudatul Athfal (RA) are private</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const y1 = `${yr - 1}/${yr}`;
                    const y2 = `${yr}/${yr + 1}`;
                    const officialData = {
                        2025: {
                            guguk_panjang: ['2', '2', '5', '5', '31', '33'],
                            mandiangin: ['3', '3', '25', '18', '149', '145'],
                            aur_birugo: ['1', '1', '3', '3', '24', '19'],
                            bukittinggi: ['6', '6', '33', '26', '204', '197']
                        }
                    };
                    const yrData = officialData[yr] || {};
                    const getVal = (rowKey, colIdx) => {
                        if (yrData[rowKey] && yrData[rowKey][colIdx] !== undefined) {
                            return yrData[rowKey][colIdx];
                        }
                        return '-';
                    };
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>${y1}</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>${y2}</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>${y1}</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>${y2}</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>${y1}</div></th>
                                <th class="py-3 px-4 font-bold border border-slate-700"><div>${y2}</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(5)</th>
                                <th class="py-1 px-3 border border-slate-700">(6)</th>
                                <th class="py-1 px-3 border border-slate-700">(8)</th>
                                <th class="py-1 px-3 border border-slate-700">(9)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">01. Guguk Panjang</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('guguk_panjang', 0)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('guguk_panjang', 1)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('guguk_panjang', 2)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('guguk_panjang', 3)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('guguk_panjang', 4)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('guguk_panjang', 5)}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">02. Mandiangin Koto Selayan</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('mandiangin', 0)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('mandiangin', 1)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('mandiangin', 2)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('mandiangin', 3)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('mandiangin', 4)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('mandiangin', 5)}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('aur_birugo', 0)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('aur_birugo', 1)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('aur_birugo', 2)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('aur_birugo', 3)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('aur_birugo', 4)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('aur_birugo', 5)}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Bukittinggi</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('bukittinggi', 0)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('bukittinggi', 1)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('bukittinggi', 2)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('bukittinggi', 3)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('bukittinggi', 4)}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${getVal('bukittinggi', 5)}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '4.1.3': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Sekolah Dasar (SD) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Primary Schools Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality',
                source: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Data Semester Ganjil / <span class=\"italic text-slate-500\">Ministry of Education, Culture, Research, and Technology, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '26'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '26'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '25'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '11'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '11'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '11'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '15'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '15'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '16'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '46'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '46'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '45'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '20'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '65'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '65'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '65'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA GURU -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '280'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '275'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '270'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '110'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '115'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '118'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '390'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '390'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '388'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '310'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '305'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '298'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '125'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '128'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '130'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '435'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '433'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '428'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '190'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '188'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '185'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '65'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '68'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '72'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '255'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '256'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '257'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '780'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '768'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '753'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '300'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '311'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '320'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1080'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1079'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1073'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA MURID -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.950'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.920'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.890'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.420'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.450'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.480'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5.370'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5.370'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5.370'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4.520'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4.480'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4.410'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.680'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.710'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.740'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6.200'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6.190'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6.150'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.680'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.650'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.620'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '890'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '920'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '950'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.570'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.570'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.570'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '11.150'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '11.050'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '10.920'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '3.990'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '4.080'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '4.170'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '15.140'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '15.130'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '15.090'}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
                                    '4.1.4': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Madrasah Ibtidaiyah (MI) di Bawah Kementerian Agama Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Madrasah Ibtidaiyah (MI) Under The Ministry of Religious Affairs by District in Bukittinggi Municipality',
                source: 'Kementerian Agama, Data Semester Ganjil / <span class=\"italic text-slate-500\">Ministry of Religious Affairs, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA GURU -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '20'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '20'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '25'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '32'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '34'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '36'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '56'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '58'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '61'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '16'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '16'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '16'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '16'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '17'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '25'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '66'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '68'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '73'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '90'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '92'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '98'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA MURID -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '285'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '290'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '305'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '285'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '290'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '305'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '510'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '525'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '540'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '480'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '495'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '510'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '990'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.020'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.050'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '240'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '245'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '255'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '240'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '245'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '255'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '510'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '525'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '540'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1.005'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1.030'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1.070'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1.515'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1.555'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '1.610'}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
                        '4.1.5': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Pertama (SMP) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Junior High Schools Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality',
                source: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Data Semester Ganjil / <span class=\"italic text-slate-500\">Ministry of Education, Culture, Research, and Technology, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '11'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '11'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '11'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '19'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA GURU -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '135'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '132'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '130'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '72'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '75'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '78'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '207'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '207'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '208'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '142'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '140'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '138'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '85'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '88'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '90'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '227'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '228'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '228'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '88'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '86'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '85'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '36'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '38'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '40'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '124'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '124'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '125'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '365'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '358'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '353'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '193'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '201'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '208'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '558'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '559'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '561'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA MURID -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.150'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.120'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.100'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '980'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.010'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.030'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.130'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.130'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.130'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.340'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.310'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2.290'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.120'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.150'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.180'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.460'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.460'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3.470'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.420'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.400'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.390'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '490'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '510'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '520'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.910'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.910'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1.910'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5.910'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5.830'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5.780'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2.590'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2.670'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2.730'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '8.500'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '8.500'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '8.510'}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
                                                '4.1.7': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Atas (SMA) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Senior High Schools Under The Ministry of Education, Culture, Research, and Technology by Sub District in Bukittinggi Municipality',
                source: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Data Semester Ganjil / <span class="italic text-slate-500">Ministry of Education, Culture, Research, and Technology, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '6'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '3'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '3'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '11'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '12'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '12'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '129'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '129'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '124'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '76'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '73'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '73'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '205'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '202'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '197'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '128'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '121'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '120'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '23'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '152'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '145'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '143'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '66'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '67'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '65'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '26'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '84'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '91'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '91'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '323'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '317'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '309'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '118'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '121'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '122'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '441'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '438'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '431'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.141'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.177'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.117'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '669'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '503'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '567'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.810'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.680'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.684'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.953'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.015'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.998'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '101'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '111'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '136'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.054'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.126'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2.134'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.023'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.080'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.094'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '198'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '188'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '118'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.221'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.268'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.212'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5.117'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5.272'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5.209'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '968'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '802'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '821'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '6.085'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '6.074'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '6.030'}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '4.1.8': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Kejuruan (SMK) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Vocational High Schools Under The Ministry of Education, Culture, Research, and Technology by Sub District in Bukittinggi Municipality',
                source: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Data Semester Ganjil / <span class="italic text-slate-500">Ministry of Education, Culture, Research, and Technology, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '7'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '3'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '11'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '225'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '146'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '371'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '30'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '30'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '61'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '61'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '225'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '237'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '462'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '3.693'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '1.360'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '5.053'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '192'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '192'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '542'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center">${isFuture ? '-' : '542'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '3.693'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '2.094'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5.787'}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '4.1.15': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Kelompok Bermain (KB) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Play Groups (KB) Under The Ministry of Education and Culture by District in Bukittinggi Municipality',
                source: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Data Semester Ganjil / <span class=\"italic text-slate-500\">Ministry of Education, Culture, Research, and Technology, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '14'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '14'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '14'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '14'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '14'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '14'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '30'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '30'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '30'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '30'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '30'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '30'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA GURU -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '28'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '29'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '30'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '28'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '29'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '30'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '44'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '45'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '46'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '44'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '45'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '46'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '22'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '23'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '22'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '23'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '94'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '97'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '100'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '94'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '97'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '100'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA MURID -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '245'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '250'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '260'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '245'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '250'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '260'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '380'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '395'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '410'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '380'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '395'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '410'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '190'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '195'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '205'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '190'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '195'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '205'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '815'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '840'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '875'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '815'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '840'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '875'}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
                                    '4.1.16': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Taman Penitipan Anak (TPA) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Day Care Centers (TPA) Under The Ministry of Education and Culture by District in Bukittinggi Municipality',
                source: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Data Semester Ganjil / <span class=\"italic text-slate-500\">Ministry of Education, Culture, Research, and Technology, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '2'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '1'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '5'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA GURU -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '7'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '8'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '5'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '20'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '22'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '20'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '22'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA MURID -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '42'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '45'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '48'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '42'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '45'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '48'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '38'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '40'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '42'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '38'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '40'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '42'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '22'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '25'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '22'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '24'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '25'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '102'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '109'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '115'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '102'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '109'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '115'}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
                                    '4.1.17': {
                titleId: 'Jumlah Sekolah, Guru, dan Murid Satuan PAUD Sejenis (SPS) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Schools, Teachers, and Pupils in Similar Early Childhood Education Units (SPS) Under The Ministry of Education and Culture by District in Bukittinggi Municipality',
                source: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Data Semester Ganjil / <span class=\"italic text-slate-500\">Ministry of Education, Culture, Research, and Technology, Odd Semester Report Data</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const y1 = `${yr - 2}/${yr - 1}`;
                    const y2 = `${yr - 1}/${yr}`;
                    const y3 = `${yr}/${yr + 1}`;
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="6">
                                    <div>Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">Schools</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-2 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '4'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '6'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '3'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '13'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '13'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '13'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '13'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '13'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '13'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 2. HEADER GURU -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA GURU -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '12'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '12'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '13'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '12'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '12'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '13'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '20'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '18'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '19'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '20'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '10'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '10'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '9'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '10'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '10'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '39'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '41'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '43'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '39'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '41'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '43'}</td>
                            </tr>

                            <!-- PEMISAH 1 SPACE -->
                            <tr class="subtable-spacer-row pointer-events-none select-none">
                                <td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>
                            </tr>

                            <!-- 3. HEADER MURID -->
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-title">
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" colspan="6">
                                    <div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>
                                </th>
                                <th class="py-2.5 px-3 font-bold border border-slate-700 text-center align-middle" rowspan="2" colspan="3">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle">
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700 text-center align-middle" colspan="3">
                                    <div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years">
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y1}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y2}</th>
                                <th class="py-1.5 px-2 font-bold border border-slate-700 text-center">${y3}</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering">
                                <th class="py-1 px-3 border border-slate-700 text-center">(1)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(2)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(3)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(4)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(5)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(6)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(7)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(8)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(9)</th>
                                <th class="py-1 px-3 border border-slate-700 text-center">(10)</th>
                            </tr>

                            <!-- DATA MURID -->
                            
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">01. Guguk Panjang</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '95'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '98'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '105'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '95'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '98'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '105'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">02. Mandiangin Koto Selayan</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '140'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '145'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '150'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '140'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '145'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '150'}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2 px-4 border border-slate-700 text-left font-semibold">03. Aur Birugo Tigo Baleh</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '70'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '72'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '75'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '70'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '72'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center ">${isFuture ? '-' : '75'}</td>
                            </tr>
                            <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700">
                                <td class="py-2 px-4 border border-slate-700 text-left font-bold">Bukittinggi</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '-'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '305'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '315'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '330'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '305'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '315'}</td>
                                <td class="py-2 px-3 border border-slate-700 text-center font-bold">${isFuture ? '-' : '330'}</td>
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
                    const units235 = [
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
            },
            '3.1.1': {
                titleId: 'Jumlah Penduduk, Laju Pertumbuhan Penduduk, Distribusi Persentase Penduduk, Kepadatan Penduduk, Rasio Jenis Kelamin Penduduk Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Population, Population Growth Rate, Percentage Distribution of Population, Population Density, and Population Sex Ratio by District in Bukittinggi Municipality',
                source: 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                    
                    const defaultData311 = {
                        2025: {
                            '01': { pop: '50.210', pct: '34,97', ratio: '100,73' },
                            '02': { pop: '61.395', pct: '42,76', ratio: '100,60' },
                            '03': { pop: '31.990', pct: '22,28', ratio: '100,09' },
                            'total': { pop: '143.595', pct: '-', ratio: '100,53' }
                        },
                        2024: {
                            '01': { pop: '49.614', pct: '34,99', ratio: '100,70' },
                            '02': { pop: '60.751', pct: '42,84', ratio: '100,60' },
                            '03': { pop: '31.439', pct: '22,17', ratio: '100,10' },
                            'total': { pop: '141.804', pct: '-', ratio: '100,52' }
                        }
                    };

                    const def = defaultData311[yr] || {};
                    const v1Pop = d['01_pop'] !== undefined ? d['01_pop'] : (def['01'] ? def['01'].pop : '-');
                    const v1Pct = d['01_pct'] !== undefined ? d['01_pct'] : (def['01'] ? def['01'].pct : '-');
                    const v1Ratio = d['01_ratio'] !== undefined ? d['01_ratio'] : (def['01'] ? def['01'].ratio : '-');

                    const v2Pop = d['02_pop'] !== undefined ? d['02_pop'] : (def['02'] ? def['02'].pop : '-');
                    const v2Pct = d['02_pct'] !== undefined ? d['02_pct'] : (def['02'] ? def['02'].pct : '-');
                    const v2Ratio = d['02_ratio'] !== undefined ? d['02_ratio'] : (def['02'] ? def['02'].ratio : '-');

                    const v3Pop = d['03_pop'] !== undefined ? d['03_pop'] : (def['03'] ? def['03'].pop : '-');
                    const v3Pct = d['03_pct'] !== undefined ? d['03_pct'] : (def['03'] ? def['03'].pct : '-');
                    const v3Ratio = d['03_ratio'] !== undefined ? d['03_ratio'] : (def['03'] ? def['03'].ratio : '-');

                    let numPop1 = parseFloat(String(v1Pop).replace(/\./g, '').replace(',', '.')) || 0;
                    let numPop2 = parseFloat(String(v2Pop).replace(/\./g, '').replace(',', '.')) || 0;
                    let numPop3 = parseFloat(String(v3Pop).replace(/\./g, '').replace(',', '.')) || 0;
                    let calcTotalPop = (v1Pop !== '-' || v2Pop !== '-' || v3Pop !== '-') ? (numPop1 + numPop2 + numPop3).toLocaleString('id-ID') : '-';

                    const vTotPop = d['total_pop'] !== undefined ? d['total_pop'] : (def['total'] ? def['total'].pop : calcTotalPop);
                    const vTotPct = d['total_pct'] !== undefined ? d['total_pct'] : (def['total'] ? def['total'].pct : '-');
                    const vTotRatio = d['total_ratio'] !== undefined ? d['total_ratio'] : (def['total'] ? def['total'].ratio : '-');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Subdistrict</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah Penduduk (jiwa)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Population (people)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Persentase Penduduk</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Percentage of Total Population (%)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Rasio Jenis Kelamin</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Population Sex Ratio</div>
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
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">
                                    01. Guguk Panjang
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v1Pop}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v1Pct}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v1Ratio}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">
                                    02. Mandiangin Koto Selayan
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v2Pop}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v2Pct}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v2Ratio}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">
                                    03. Aur Birugo Tigo Baleh
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v3Pop}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v3Pct}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v3Ratio}</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">
                                    Jumlah / Total (Bukittinggi)
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vTotPop}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vTotPct}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vTotRatio}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '3.1.2': {
                titleId: 'Penduduk Menurut Golongan Umur dan Jenis Kelamin di Kota Bukittinggi',
                titleEn: 'Population by Age Group and Sex in Bukittinggi Municipality',
                source: 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                    
                    const ageGroups = [
                        { key: '0_4', label: '0–4', l: '5.203', p: '4.882', tot: '10.085' },
                        { key: '5_9', label: '5–9', l: '6.541', p: '6.044', tot: '12.585' },
                        { key: '10_14', label: '10–14', l: '6.837', p: '6.469', tot: '13.306' },
                        { key: '15_19', label: '15–19', l: '6.594', p: '6.223', tot: '12.817' },
                        { key: '20_24', label: '20–24', l: '6.303', p: '5.946', tot: '12.249' },
                        { key: '25_29', label: '25–29', l: '6.127', p: '5.937', tot: '12.064' },
                        { key: '30_34', label: '30–34', l: '5.472', p: '5.429', tot: '10.901' },
                        { key: '35_39', label: '35–39', l: '5.169', p: '5.094', tot: '10.263' },
                        { key: '40_44', label: '40–44', l: '5.101', p: '5.096', tot: '10.197' },
                        { key: '45_49', label: '45–49', l: '4.657', p: '4.476', tot: '9.133' },
                        { key: '50_54', label: '50–54', l: '4.025', p: '4.025', tot: '8.050' },
                        { key: '55_59', label: '55–59', l: '3.179', p: '3.369', tot: '6.548' },
                        { key: '60_64', label: '60–64', l: '2.663', p: '2.866', tot: '5.529' },
                        { key: '65_69', label: '65–69', l: '2.070', p: '2.262', tot: '4.332' },
                        { key: '70_74', label: '70–74', l: '1.305', p: '1.507', tot: '2.812' },
                        { key: '75_plus', label: '75+', l: '1.198', p: '1.898', tot: '3.096' }
                    ];

                    let sumL = 0, sumP = 0, sumTot = 0;
                    let hasAnyData = false;

                    const rowsHtml = ageGroups.map(grp => {
                        const is2025 = (yr === 2025);
                        let vL = d[`${grp.key}_l`] !== undefined ? d[`${grp.key}_l`] : (is2025 ? grp.l : '-');
                        let vP = d[`${grp.key}_p`] !== undefined ? d[`${grp.key}_p`] : (is2025 ? grp.p : '-');
                        
                        let numL = parseFloat(String(vL).replace(/\./g, '').replace(',', '.')) || 0;
                        let numP = parseFloat(String(vP).replace(/\./g, '').replace(',', '.')) || 0;
                        let calcRowTot = (vL !== '-' || vP !== '-') ? (numL + numP).toLocaleString('id-ID') : '-';
                        let vTot = d[`${grp.key}_tot`] !== undefined ? d[`${grp.key}_tot`] : (is2025 ? grp.tot : calcRowTot);

                        if (vL !== '-' || vP !== '-') {
                            hasAnyData = true;
                            sumL += numL;
                            sumP += numP;
                            if (calcRowTot !== '-') sumTot += (numL + numP);
                        }

                        return `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">
                                    ${grp.label}
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vL}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vP}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vTot}</td>
                            </tr>
                        `;
                    }).join('');

                    const is2025 = (yr === 2025);
                    const finalTotalL = d['total_l'] !== undefined ? d['total_l'] : (is2025 ? '71.987' : (hasAnyData ? sumL.toLocaleString('id-ID') : '-'));
                    const finalTotalP = d['total_p'] !== undefined ? d['total_p'] : (is2025 ? '71.608' : (hasAnyData ? sumP.toLocaleString('id-ID') : '-'));
                    const finalTotalTot = d['total_tot'] !== undefined ? d['total_tot'] : (is2025 ? '143.595' : (hasAnyData ? sumTot.toLocaleString('id-ID') : '-'));

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kelompok Umur</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Age Group</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Laki–laki</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Male</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Perempuan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Female</div>
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
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">
                                    Jumlah / <span class="italic font-bold">Total</span>
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${finalTotalL}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${finalTotalP}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${finalTotalTot}</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '3.1.8': {
                titleId: 'Jumlah Penduduk Wajib KTP (Kartu Tanda Penduduk) dan yang Telah Memiliki KTP dirinci Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Population Owner Identity Card and Be Possessed Identity Card Already by District in Bukittinggi Municipality',
                source: 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};
                    
                    const fmt = (v) => {
                        if (v === undefined || v === null || v === '' || v === '-') return '-';
                        const s = v.toString().trim();
                        const clean = s.replace(/[^\d]/g, '');
                        if (!clean) return '-';
                        return parseInt(clean, 10).toLocaleString('id-ID');
                    };

                    const defKec = {
                        2025: {
                            '01_pop': '50.210', '01_wajib': '35.853', '01_ktp': '35.348',
                            '02_pop': '61.395', '02_wajib': '43.995', '02_ktp': '43.463',
                            '03_pop': '31.990', '03_wajib': '22.523', '03_ktp': '22.214'
                        },
                        2024: {
                            '01_pop': '49.614', '01_wajib': '35.197', '01_ktp': '34.988',
                            '02_pop': '60.751', '02_wajib': '43.195', '02_ktp': '42.932',
                            '03_pop': '31.439', '03_wajib': '21.901', '03_ktp': '21.764'
                        }
                    };
                    const fallback = defKec[yr] || {};

                    const v1Pop = d['01_pop'] !== undefined ? fmt(d['01_pop']) : (fallback['01_pop'] || '-');
                    const v1Wajib = d['01_wajib'] !== undefined ? fmt(d['01_wajib']) : (fallback['01_wajib'] || '-');
                    const v1Ktp = d['01_ktp'] !== undefined ? fmt(d['01_ktp']) : (fallback['01_ktp'] || '-');

                    const v2Pop = d['02_pop'] !== undefined ? fmt(d['02_pop']) : (fallback['02_pop'] || '-');
                    const v2Wajib = d['02_wajib'] !== undefined ? fmt(d['02_wajib']) : (fallback['02_wajib'] || '-');
                    const v2Ktp = d['02_ktp'] !== undefined ? fmt(d['02_ktp']) : (fallback['02_ktp'] || '-');

                    const v3Pop = d['03_pop'] !== undefined ? fmt(d['03_pop']) : (fallback['03_pop'] || '-');
                    const v3Wajib = d['03_wajib'] !== undefined ? fmt(d['03_wajib']) : (fallback['03_wajib'] || '-');
                    const v3Ktp = d['03_ktp'] !== undefined ? fmt(d['03_ktp']) : (fallback['03_ktp'] || '-');

                    const knownTotals = {
                        2025: { pop: '143.595', wajib: '102.371', ktp: '101.025' },
                        2024: { pop: '141.804', wajib: '100.293', ktp: '99.684' },
                        2023: { pop: '138.534', wajib: '99.849',  ktp: '95.690' },
                        2022: { pop: '134.412', wajib: '96.195',  ktp: '92.459' },
                        2021: { pop: '130.211', wajib: '90.846',  ktp: '90790' },
                        2020: { pop: '101.745', wajib: '88.327',  ktp: '88.289' },
                        2019: { pop: '123.296', wajib: '85.296',  ktp: '85.454' }
                    };

                    let totalRowsHtml = '';
                    for (let i = 0; i < 6; i++) {
                        const y = yr - i;
                        const known = knownTotals[y] || {};
                        const valPop = d[`tot_${y}_pop`] !== undefined ? fmt(d[`tot_${y}_pop`]) : (known.pop || '-');
                        const valWajib = d[`tot_${y}_wajib`] !== undefined ? fmt(d[`tot_${y}_wajib`]) : (known.wajib || '-');
                        const valKtp = d[`tot_${y}_ktp`] !== undefined ? fmt(d[`tot_${y}_ktp`]) : (known.ktp || '-');

                        if (i === 0) {
                            totalRowsHtml += `
                                <tr class="bg-[#fed7aa] font-bold">
                                    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" rowspan="6">
                                        Jumlah / <span class="italic font-bold">Total</span>
                                    </td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">
                                        ${y}
                                    </td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">
                                        ${valPop}
                                    </td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">
                                        ${valWajib}
                                    </td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">
                                        ${valKtp}
                                    </td>
                                </tr>
                            `;
                        } else {
                            totalRowsHtml += `
                                <tr class="hover:bg-amber-100/60 transition-colors">
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">
                                        ${y}
                                    </td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">
                                        ${valPop}
                                    </td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">
                                        ${valWajib}
                                    </td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">
                                        ${valKtp}
                                    </td>
                                </tr>
                            `;
                        }
                    }

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jumlah Penduduk</div><div class="italic font-normal text-[11px] sm:text-xs">Number of Population</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Wajib KTP</div><div class="italic font-normal text-[11px] sm:text-xs">Must Have ID</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Memiliki KTP Elektronik</div><div class="italic font-normal text-[11px] sm:text-xs">Have Electronic ID</div>
                                </th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                                <th class="py-1 px-3 border border-slate-700">(4)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">
                                    01. GUGUK PANJANG
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v1Pop}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v1Wajib}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v1Ktp}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">
                                    02. MANDIANGIN KOTO SELAYAN
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v2Pop}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v2Wajib}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v2Ktp}</td>
                            </tr>
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">
                                    03. AUR BIRUGO TIGO BALEH
                                </td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v3Pop}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v3Wajib}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${v3Ktp}</td>
                            </tr>
                            ${totalRowsHtml}
                        </tbody>
                    `;
                }
            },
            '4.3.1': {
                titleId: 'Jumlah Penduduk Menurut Agama yang Dianut di Kota Bukittinggi',
                titleEn: 'Number of Population by Religion in Bukittinggi',
                source: 'Dinas Kependudukan dan Pencatatan Sipil Kota Bukittinggi / <span class="italic text-slate-500">Population and Civil Registration Office of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yrKey = year ? year.toString() : '2025';
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yrKey]) ? serverDbDataStore[yrKey] : {};

                    const rowsDef = [
                        // 01. GUGUK PANJANG
                        { key: '01_total', label: '01. GUGUK PANJANG', isKec: true },
                        { key: '01_01', label: '1. Tarok Dipo' },
                        { key: '01_02', label: '2. Bukik Cangang Kayu Ramang' },
                        { key: '01_03', label: '3. Pakan Kurai' },
                        { key: '01_04', label: '4. Aur Tajungkang Tengah Sawah' },
                        { key: '01_05', label: '5. Benteng Pasar Atas' },
                        { key: '01_06', label: '6. Kayu Kubu' },
                        { key: '01_07', label: '7. Bukik Apit Puhun' },
                        // 02. MANDIANGIN KOTO SELAYAN
                        { key: '02_total', label: '02. MANDIANGIN KOTO SELAYAN', isKec: true },
                        { key: '02_01', label: '1. Campago Guguk Bulek' },
                        { key: '02_02', label: '2. Campago Ipuh' },
                        { key: '02_03', label: '3. Puhun Tembok' },
                        { key: '02_04', label: '4. Kubu Gulai Bancah' },
                        { key: '02_05', label: '5. Puhun Pintu Kabun' },
                        { key: '02_06', label: '6. Pulai Anak Air' },
                        { key: '02_07', label: '7. Koto Selayan' },
                        { key: '02_08', label: '8. Garegeh' },
                        { key: '02_09', label: '9. Manggis Ganting' },
                        // 03. AUR BIRUGO TIGO BALEH
                        { key: '03_total', label: '03. AUR BIRUGO TIGO BALEH', isKec: true },
                        { key: '03_01', label: '1. Aur Kuning' },
                        { key: '03_02', label: '2. Birugo' },
                        { key: '03_03', label: '3. Belakang Balok' },
                        { key: '03_04', label: '4. Sapiran' },
                        { key: '03_05', label: '5. Kubu Tanjung' },
                        { key: '03_06', label: '6. Pakan Labuah' },
                        { key: '03_07', label: '7. Parit Antang' },
                        { key: '03_08', label: '8. Ladang Cakiah' },
                        // TOTAL
                        { key: 'total', label: 'Jumlah / Total', isTotal: true }
                    ];

                    const defaultDataByYear = {
                        '2025': {
                            '01_total': { islam: '48.867', protestan: '656', katholik: '579', hindu: '5', budha: '103', lainnya: '0' },
                            '01_01':    { islam: '18.160', protestan: '535', katholik: '322', hindu: '5', budha: '4',   lainnya: '0' },
                            '01_02':    { islam: '2.543',  protestan: '22',  katholik: '30',  hindu: '0', budha: '2',   lainnya: '0' },
                            '01_03':    { islam: '7.853',  protestan: '12',  katholik: '0',   hindu: '0', budha: '7',   lainnya: '0' },
                            '01_04':    { islam: '8.481',  protestan: '20',  katholik: '21',  hindu: '0', budha: '3',   lainnya: '0' },
                            '01_05':    { islam: '1.144',  protestan: '26',  katholik: '197', hindu: '0', budha: '87',  lainnya: '0' },
                            '01_06':    { islam: '4.346',  protestan: '6',   katholik: '3',   hindu: '0', budha: '0',   lainnya: '0' },
                            '01_07':    { islam: '6.340',  protestan: '35',  katholik: '6',   hindu: '0', budha: '0',   lainnya: '0' },
                            '02_total': { islam: '59.317', protestan: '1.559', katholik: '494', hindu: '0', budha: '25', lainnya: '0' },
                            '02_01':    { islam: '8.168',  protestan: '605', katholik: '124', hindu: '0', budha: '1',   lainnya: '0' },
                            '02_02':    { islam: '11.942', protestan: '74',  katholik: '3',   hindu: '0', budha: '0',   lainnya: '0' },
                            '02_03':    { islam: '6.657',  protestan: '13',  katholik: '15',  hindu: '0', budha: '3',   lainnya: '0' },
                            '02_04':    { islam: '7.273',  protestan: '22',  katholik: '12',  hindu: '0', budha: '6',   lainnya: '0' },
                            '02_05':    { islam: '8.330',  protestan: '13',  katholik: '8',   hindu: '0', budha: '7',   lainnya: '0' },
                            '02_06':    { islam: '6.647',  protestan: '298', katholik: '161', hindu: '0', budha: '8',   lainnya: '0' },
                            '02_07':    { islam: '1.996',  protestan: '0',   katholik: '0',   hindu: '0', budha: '0',   lainnya: '0' },
                            '02_08':    { islam: '3.236',  protestan: '14',  katholik: '5',   hindu: '0', budha: '0',   lainnya: '0' },
                            '02_09':    { islam: '5.068',  protestan: '520', katholik: '166', hindu: '0', budha: '0',   lainnya: '0' },
                            '03_total': { islam: '31.749', protestan: '184', katholik: '53',  hindu: '0', budha: '4',   lainnya: '0' },
                            '03_01':    { islam: '8.062',  protestan: '8',   katholik: '0',   hindu: '0', budha: '0',   lainnya: '0' },
                            '03_02':    { islam: '6.986',  protestan: '49',  katholik: '6',   hindu: '0', budha: '0',   lainnya: '0' },
                            '03_03':    { islam: '3.036',  protestan: '47',  katholik: '27',  hindu: '0', budha: '4',   lainnya: '0' },
                            '03_04':    { islam: '3.691',  protestan: '80',  katholik: '20',  hindu: '0', budha: '0',   lainnya: '0' },
                            '03_05':    { islam: '2.046',  protestan: '0',   katholik: '0',   hindu: '0', budha: '0',   lainnya: '0' },
                            '03_06':    { islam: '3.830',  protestan: '0',   katholik: '0',   hindu: '0', budha: '0',   lainnya: '0' },
                            '03_07':    { islam: '1.681',  protestan: '0',   katholik: '0',   hindu: '0', budha: '0',   lainnya: '0' },
                            '03_08':    { islam: '2.417',  protestan: '0',   katholik: '0',   hindu: '0', budha: '0',   lainnya: '0' },
                            'total':    { islam: '139.933',protestan: '2.399',katholik: '1.126',hindu: '5', budha: '132', lainnya: '0' }
                        },
                        '2024': {
                            '01_total': { islam: '48.238', protestan: '649', katholik: '617', hindu: '5', budha: '105', lainnya: '-' },
                            '01_01':    { islam: '18.026', protestan: '523', katholik: '345', hindu: '5', budha: '4',   lainnya: '-' },
                            '01_02':    { islam: '2.486',  protestan: '23',  katholik: '32',  hindu: '-', budha: '2',   lainnya: '-' },
                            '01_03':    { islam: '7.709',  protestan: '12',  katholik: '5',   hindu: '-', budha: '7',   lainnya: '-' },
                            '01_04':    { islam: '8.280',  protestan: '21',  katholik: '24',  hindu: '-', budha: '4',   lainnya: '-' },
                            '01_05':    { islam: '1.145',  protestan: '24',  katholik: '202', hindu: '-', budha: '88',  lainnya: '-' },
                            '01_06':    { islam: '4.307',  protestan: '6',   katholik: '3',   hindu: '-', budha: '-',   lainnya: '-' },
                            '01_07':    { islam: '6.285',  protestan: '40',  katholik: '6',   hindu: '-', budha: '-',   lainnya: '-' },
                            '02_total': { islam: '58.704', protestan: '1.540', katholik: '481', hindu: '-', budha: '26', lainnya: '-' },
                            '02_01':    { islam: '8.080',  protestan: '603', katholik: '132', hindu: '-', budha: '1',   lainnya: '-' },
                            '02_02':    { islam: '11.879', protestan: '72',  katholik: '2',   hindu: '-', budha: '-',   lainnya: '-' },
                            '02_03':    { islam: '6.619',  protestan: '13',  katholik: '15',  hindu: '-', budha: '4',   lainnya: '-' },
                            '02_04':    { islam: '7.144',  protestan: '22',  katholik: '12',  hindu: '-', budha: '7',   lainnya: '-' },
                            '02_05':    { islam: '8.269',  protestan: '12',  katholik: '8',   hindu: '-', budha: '6',   lainnya: '-' },
                            '02_06':    { islam: '6.582',  protestan: '291', katholik: '162', hindu: '-', budha: '8',   lainnya: '-' },
                            '02_07':    { islam: '1.930',  protestan: '2',   katholik: '-',   hindu: '-', budha: '-',   lainnya: '-' },
                            '02_08':    { islam: '3.242',  protestan: '29',  katholik: '4',   hindu: '-', budha: '-',   lainnya: '-' },
                            '02_09':    { islam: '4.959',  protestan: '496', katholik: '146', hindu: '-', budha: '-',   lainnya: '-' },
                            '03_total': { islam: '31.205', protestan: '178', katholik: '52',  hindu: '-', budha: '4',   lainnya: '-' },
                            '03_01':    { islam: '7.980',  protestan: '9',   katholik: '-',   hindu: '-', budha: '-',   lainnya: '-' },
                            '03_02':    { islam: '6.831',  protestan: '44',  katholik: '7',   hindu: '-', budha: '-',   lainnya: '-' },
                            '03_03':    { islam: '2.989',  protestan: '45',  katholik: '25',  hindu: '-', budha: '4',   lainnya: '-' },
                            '03_04':    { islam: '3.561',  protestan: '79',  katholik: '20',  hindu: '-', budha: '-',   lainnya: '-' },
                            '03_05':    { islam: '1.989',  protestan: '-',   katholik: '-',   hindu: '-', budha: '-',   lainnya: '-' },
                            '03_06':    { islam: '3.742',  protestan: '-',   katholik: '-',   hindu: '-', budha: '-',   lainnya: '-' },
                            '03_07':    { islam: '1.675',  protestan: '-',   katholik: '-',   hindu: '-', budha: '-',   lainnya: '-' },
                            '03_08':    { islam: '2.438',  protestan: '1',   katholik: '-',   hindu: '-', budha: '-',   lainnya: '-' },
                            'total':    { islam: '138.147',protestan: '2.367',katholik: '1.150',hindu: '5', budha: '135', lainnya: '-' }
                        }
                    };

                    const curDef = defaultDataByYear[yrKey] || {};

                    const fmt = (val) => {
                        if (val === undefined || val === null || val === '' || val === '-' || val === '–' || val === '—') return '-';
                        let s = String(val).trim();
                        if (s === '0') return '0';
                        let clean = s.replace(/[^\d]/g, '');
                        if (!clean) return '-';
                        return parseInt(clean, 10).toLocaleString('id-ID');
                    };

                    let rowsHtml = '';
                    rowsDef.forEach(r => {
                        const def = curDef[r.key] || {};
                        const vIslam = fmt(d[`${r.key}_islam`] !== undefined ? d[`${r.key}_islam`] : def.islam);
                        const vProtestan = fmt(d[`${r.key}_protestan`] !== undefined ? d[`${r.key}_protestan`] : def.protestan);
                        const vKatholik = fmt(d[`${r.key}_katholik`] !== undefined ? d[`${r.key}_katholik`] : def.katholik);
                        const vHindu = fmt(d[`${r.key}_hindu`] !== undefined ? d[`${r.key}_hindu`] : def.hindu);
                        const vBudha = fmt(d[`${r.key}_budha`] !== undefined ? d[`${r.key}_budha`] : def.budha);
                        const vLainnya = fmt(d[`${r.key}_lainnya`] !== undefined ? d[`${r.key}_lainnya`] : def.lainnya);

                        if (r.isTotal) {
                            rowsHtml += `
                                <tr class="bg-[#fed7aa] font-bold">
                                    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Jumlah / <span class="italic font-bold">Total</span></td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vIslam}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vProtestan}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vKatholik}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vHindu}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vBudha}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${vLainnya}</td>
                                </tr>
                            `;
                        } else if (r.isKec) {
                            rowsHtml += `
                                <tr class="bg-amber-100/80 font-bold">
                                    <td class="py-2.5 px-4 border border-slate-700 text-left font-bold align-top">${r.label}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${vIslam}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${vProtestan}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${vKatholik}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${vHindu}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${vBudha}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-bold">${vLainnya}</td>
                                </tr>
                            `;
                        } else {
                            rowsHtml += `
                                <tr class="hover:bg-amber-100/60 transition-colors">
                                    <td class="py-2.5 px-4 border border-slate-700 text-left font-medium align-top pl-8">${r.label}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vIslam}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vProtestan}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vKatholik}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vHindu}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vBudha}</td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${vLainnya}</td>
                                </tr>
                            `;
                        }
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Islam</div><div class="italic font-normal text-[11px] sm:text-xs">Moslem</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kristen Protestan</div><div class="italic font-normal text-[11px] sm:text-xs">Protestant</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Katolik</div><div class="italic font-normal text-[11px] sm:text-xs">Catholic</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Hindu</div><div class="italic font-normal text-[11px] sm:text-xs">Hindu</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Buddha</div><div class="italic font-normal text-[11px] sm:text-xs">Buddhist</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lainnya</div><div class="italic font-normal text-[11px] sm:text-xs">Others</div>
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
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },

            '4.2.3': {
                titleId: 'Jumlah Rumah Sakit Umum, Rumah Sakit Khusus, dan Puskesmas Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of General Hospital, Specialized Hospital, and Public Health Center by District in Bukittinggi',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'DINAS KESEHATAN Kota Bukittinggi / <span class="italic text-slate-500">Bukittinggi Municipality Health Office</span>',
                note: '<sup>1</sup> Puskesmas yang teregistrasi / <span class="italic text-slate-500">Registered Public Health Center</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const prevYr = yr - 1;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                    const officialData = {
                        2025: {
                            gp:   ['1', '1', '0', '0', '0', '0', '2', '2', '58', '58', '8', '7', '9', '9'],
                            mks:  ['1', '1', '0', '0', '0', '0', '4', '4', '50', '49', '5', '5', '9', '9'],
                            abtb: ['3', '3', '1', '1', '0', '0', '1', '1', '32', '32', '8', '13', '8', '8'],
                            tot:  ['5', '5', '1', '1', '0', '0', '7', '7', '140', '139', '21', '25', '26', '26']
                        },
                        2024: {
                            gp:   ['1', '1', '0', '0', '0', '0', '2', '2', '57', '58', '8', '8', '9', '9'],
                            mks:  ['1', '1', '0', '0', '0', '0', '4', '4', '48', '50', '5', '5', '9', '9'],
                            abtb: ['3', '3', '1', '1', '0', '0', '1', '1', '32', '32', '8', '8', '8', '8'],
                            tot:  ['5', '5', '1', '1', '0', '0', '7', '7', '137', '140', '21', '21', '26', '26']
                        }
                    };

                    const yrData = officialData[yr] || officialData[2025];
                    const rows = [
                        { key: 'gp', name: '01. Guguk Panjang' },
                        { key: 'mks', name: '02. Mandiangin Koto Selayan' },
                        { key: 'abtb', name: '03. Aur Birugo Tigo baleh' }
                    ];

                    let rowsHtml = '';
                    rows.forEach(r => {
                        let cells = `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${r.name}</td>`;
                        for (let i = 0; i < 14; i++) {
                            const defVal = (yrData[r.key] && yrData[r.key][i] !== undefined) ? yrData[r.key][i] : '-';
                            const val = d[`${r.key}_col${i}`] !== undefined ? d[`${r.key}_col${i}`] : defVal;
                            cells += `<td class="py-1 px-2 border border-slate-700 text-center align-middle">
                                <input type="text" name="${r.key}_col${i}" value="${val}" class="w-full text-center bg-transparent focus:bg-amber-50 focus:outline-none border-b border-transparent focus:border-amber-500 font-medium table-edit-input" />
                            </td>`;
                        }
                        rowsHtml += `<tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">${cells}</tr>`;
                    });

                    // Baris Total
                    let totalCells = `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">Bukittinggi</td>`;
                    for (let i = 0; i < 14; i++) {
                        const defVal = (yrData['tot'] && yrData['tot'][i] !== undefined) ? yrData['tot'][i] : '-';
                        const val = d[`tot_col${i}`] !== undefined ? d[`tot_col${i}`] : defVal;
                        totalCells += `<td class="py-1 px-2 border border-slate-700 text-center align-middle font-extrabold">
                            <input type="text" name="tot_col${i}" value="${val}" class="w-full text-center bg-transparent focus:bg-amber-50 focus:outline-none border-b border-transparent focus:border-amber-500 font-extrabold table-edit-input" />
                        </td>`;
                    }
                    rowsHtml += `<tr class="bg-[#fed7aa] font-bold text-slate-900 border-t-2 border-slate-700">${totalCells}</tr>`;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Rumah Sakit Umum</div><div class="italic font-normal text-[11px] sm:text-xs">General Hospital</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Rumah Sakit Khusus</div><div class="italic font-normal text-[11px] sm:text-xs">Specialized Hospital</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Puskesmas<sup>1</sup> Rawat Inap</div><div class="italic font-normal text-[11px] sm:text-xs">Public Health Center<sup>1</sup> with Inpatient Care</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Puskesmas<sup>1</sup> Non Rawat Inap</div><div class="italic font-normal text-[11px] sm:text-xs">Public Health Center<sup>1</sup> without Inpatient Care</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Posyandu</div><div class="italic font-normal text-[11px] sm:text-xs">Maternal &amp; Child Health Center</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Klinik / Balai Kesehatan</div><div class="italic font-normal text-[11px] sm:text-xs">Clinic / Health Center</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Polindes / Poskeskel</div><div class="italic font-normal text-[11px] sm:text-xs">Village Maternity</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2 px-3 font-bold border border-slate-700">${prevYr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${yr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${prevYr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${yr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${prevYr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${yr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${prevYr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${yr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${prevYr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${yr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${prevYr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${yr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${prevYr}</th>
                                <th class="py-2 px-3 font-bold border border-slate-700">${yr}</th>
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
                                <th class="py-1 px-3 border border-slate-700">(14)</th>
                                <th class="py-1 px-3 border border-slate-700">(15)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            }
        };
    }
    window.schemasEdit = schemasEdit;
})();