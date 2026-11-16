/** SiBingka - Skema tabel (form isian / edit): 5.1.17, 5.1.18, 5.1.19, 5.2.1, 5.2.2 */
Object.assign(window.tableSchemas, {
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
                                ${Array(12).fill(0).map(() => `<td class="py-2 px-1 border border-slate-700 text-center"><input type="text" class="table-edit-input w-full text-center bg-white border border-slate-300 rounded px-1 py-1 text-xs" value="-"></td>`).join('')}
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
                                ${Array(12).fill(0).map(() => `<td class="py-2 px-1 border border-slate-700 text-center"><input type="text" class="table-edit-input w-full text-center ${inputCls} border border-slate-300 rounded px-1 py-1 text-xs" value="-"></td>`).join('')}
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
            '5.1.18': {
                titleId: 'Realisasi Pupuk di Kota Bukittinggi',
                titleEn: 'Realization of Fertilizer in Bukittinggi',
                isMultiYear: false,
                source: 'Dinas Pertanian dan Pangan Kota Bukittinggi / <span class="italic text-slate-500">Agriculture and Food Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const items = [
                        { name: '01. UREA', unit: 'Ton', gp: '3,75', mks: '48', abtb: '47,75', jml: '99,5' },
                        { name: '02. SP36', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' },
                        { name: '03. KCL', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' },
                        { name: '04. NPK', unit: 'Ton', gp: '3,57', mks: '45,12', abtb: '24,35', jml: '73,03' },
                        { name: '05. Bay Polan', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' },
                        { name: '06. Roton F', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' },
                        { name: '07. Racun', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' },
                        { name: 'a. Insektisida', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' },
                        { name: 'b. Rodentisida', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' },
                        { name: 'c. Fungisida', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' },
                        { name: 'd. Jamaskus', unit: '–', gp: '–', mks: '–', abtb: '–', jml: '–' }
                    ];

                    let rowsHtml = '';
                    items.forEach(it => {
                        const gp = (yr <= 2025) ? it.gp : '–';
                        const mks = (yr <= 2025) ? it.mks : '–';
                        const abtb = (yr <= 2025) ? it.abtb : '–';
                        const jml = (yr <= 2025) ? it.jml : '–';
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${it.name}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${it.unit}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">${gp}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">${mks}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">${abtb}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-bold">${jml}</td>
                            </tr>
                        `;
                    });

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jenis Pupuk</div><div class="italic font-normal text-[11px] sm:text-xs">Type of Fertilizer</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Satuan</div><div class="italic font-normal text-[11px] sm:text-xs">Unit</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Guguk Panjang</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Mandiangin Koto Selayan</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Aur Birugo Tigo Baleh</div>
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
            '5.1.19': {
                titleId: 'Jumlah Pengadaan Peralatan Pemberantasan Hama Penyakit Tanaman Menurut Jenisnya per Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Pest Control Machinery Procurement by District in Bukittinggi',
                isMultiYear: false,
                source: 'Dinas Pertanian dan Pangan Kota Bukittinggi / <span class="italic text-slate-500">Agriculture and Food Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const histData = {
                        2016: ['-', '-', '-', '-', '-'],
                        2017: ['-', '-', '-', '-', '-'],
                        2018: ['-', '-', '-', '-', '-'],
                        2019: ['-', '11', '-', '-', '11'],
                        2020: ['-', '0', '-', '-', '0'],
                        2021: ['-', '15', '-', '-', '15'],
                        2022: ['-', '8', '-', '-', '8'],
                        2023: ['-', '-', '-', '-', '-'],
                        2024: ['-', '-', '-', '-', '-'],
                        2025: ['-', '-', '-', '-', '-']
                    };

                    const dists = ['01. GUGUK PANJANG', '02. MANDIANGIN KOTO SELAYAN', '03. AUR BIRUGO TIGO BALEH'];
                    let rowsHtml = '';

                    dists.forEach(d => {
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top">${d}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">-</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">-</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">-</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">-</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-bold">-</td>
                            </tr>
                        `;
                    });

                    for (let y = yr - 5; y <= yr - 1; y++) {
                        const vals = histData[y] || ['-', '-', '-', '-', '-'];
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-center font-bold align-top">${y}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">${vals[0]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">${vals[1]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">${vals[2]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-medium">${vals[3]}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-bold">${vals[4]}</td>
                            </tr>
                        `;
                    }

                    const curVals = histData[yr] || ['-', '-', '-', '-', '-'];
                    rowsHtml += `
                        <tr class="bg-[#fed7aa] font-bold">
                            <td class="py-2.5 px-4 border border-slate-700 text-center font-extrabold align-top">Jumlah / Total ${yr}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-bold">${curVals[0]}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-bold">${curVals[1]}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-bold">${curVals[2]}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-bold">${curVals[3]}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-right align-top pr-4 font-extrabold">${curVals[4]}</td>
                        </tr>
                    `;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Motor Sprayer</div><div class="italic font-normal text-[11px] sm:text-xs">Sprayer Motors</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Sprayer Tangan</div><div class="italic font-normal text-[11px] sm:text-xs">Hand Sprayer</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Solder</div><div class="italic font-normal text-[11px] sm:text-xs">Solder</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Emposan</div><div class="italic font-normal text-[11px] sm:text-xs">Breather</div>
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
            },
});
