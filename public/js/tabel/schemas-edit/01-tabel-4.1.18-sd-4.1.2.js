/** SiBingka - Skema tabel (form isian / edit): 4.1.18, 4.1.19, 1.1.6, 1.1.8, 1.1.9, 1.1.10, 4.1.1, 4.1.2 */
Object.assign(window.tableSchemas, {
            '4.1.11': {
                titleId: 'Jumlah Kelurahan yang Memiliki Fasilitas Sekolah Menurut Kecamatan dan Tingkat Pendidikan di Kota Bukittinggi',
                titleEn: 'Number of Subdistricts Having Educational Facilities by Subdistrict and Educational Level In Bukittinggi Municipality',
                isMultiYear: true,
                render: function(year) {
                    const yrInt = parseInt(year) || 2025;
                    const y1 = yrInt - 3;
                    const y2 = yrInt - 2;
                    const y3 = yrInt - 1;
                    const y4 = yrInt;
                    return `<thead>
                        <tr class="bg-[#f95a00] text-white text-center font-bold">
                            <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                <div>SD</div><div class="italic font-normal text-[11px] sm:text-xs">Primary School</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                <div>SMP</div><div class="italic font-normal text-[11px] sm:text-xs">Junior High School</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                <div>SMA</div><div class="italic font-normal text-[11px] sm:text-xs">Senior High School</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                <div>SMK</div><div class="italic font-normal text-[11px] sm:text-xs">Vocational High School</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                <div>Akademi/Perguruan Tinggi</div><div class="italic font-normal text-[11px] sm:text-xs">College/University</div>
                            </th>
                        </tr>
                        <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y1}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y2}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y3}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y4}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y1}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y2}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y3}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y4}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y1}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y2}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y3}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y4}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y1}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y2}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y3}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y4}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y1}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y2}</div></th>
                            <th class="py-2 px-3 border border-slate-700 text-center"><div>${y3}</div></th>
                            <th class="py-2 px-3 font-bold border border-slate-700 text-center"><div>${y4}</div></th>
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
                            <th class="py-1 px-3 border border-slate-700">(16)</th>
                            <th class="py-1 px-3 border border-slate-700">(17)</th>
                            <th class="py-1 px-3 border border-slate-700">(18)</th>
                            <th class="py-1 px-3 border border-slate-700">(19)</th>
                            <th class="py-1 px-3 border border-slate-700">(20)</th>
                            <th class="py-1 px-3 border border-slate-700">(21)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2 px-4 border border-slate-700 text-left font-semibold align-middle">01. Guguk Panjang</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">7</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">7</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">7</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">6</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">6</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">6</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">4</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">4</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">4</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                        </tr>
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2 px-4 border border-slate-700 text-left font-semibold align-middle">02. Mandiangin Koto Selayan</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">8</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">8</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">8</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">7</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">4</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">4</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">4</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">5</td>
                        </tr>
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2 px-4 border border-slate-700 text-left font-semibold align-middle">03. Aur Birugo Tigo Baleh</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">8</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">8</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">8</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">3</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">3</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">1</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">...</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                            <td class="py-2 px-3 border border-slate-700 text-center align-middle">2</td>
                        </tr>
                        <tr class="bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700 hover:bg-amber-200/60 transition-colors">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-bold align-middle">Bukittinggi</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">23</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">...</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">23</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">23</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">13</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">...</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">14</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">16</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">10</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">...</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">11</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">11</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">8</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">...</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">8</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">8</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">12</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">...</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">12</td>
                            <td class="py-2.5 px-3 border border-slate-700 text-center font-bold align-middle">12</td>
                        </tr>
                    </tbody>`;
                }
            },
            '4.1.12': {
                titleId: 'Angka Partisipasi Murni (APM) dan Angka Partisipasi Kasar (APK) Menurut Jenjang Pendidikan di Kota Bukittinggi',
                titleEn: 'Participant Rates and Gross Participant Rates by Educational Level in Bukittinggi Municipality',
                isMultiYear: true,
                render: function(year) {
                    const yrInt = parseInt(year) || 2025;
                    const y1 = yrInt - 2;
                    const y2 = yrInt - 1;
                    const y3 = yrInt;
                    const dash = '<span class="text-slate-400 font-normal">-</span>';
                    const knownData = {
                        sd: {
                            2022: { apm: '99,85', apk: '106,34' },
                            2023: { apm: '99,85', apk: '106,72' },
                            2024: { apm: '99,21', apk: '107,81' },
                            2025: { apm: '98,43', apk: '103,17' }
                        },
                        smp: {
                            2022: { apm: '81,98', apk: '86,77' },
                            2023: { apm: '82,83', apk: '93,12' },
                            2024: { apm: '88,76', apk: '111,92' },
                            2025: { apm: '86,27', apk: '105,80' }
                        },
                        sma: {
                            2022: { apm: '74,92', apk: '92,48' },
                            2023: { apm: '76,92', apk: '98,85' },
                            2024: { apm: '81,33', apk: '99,96' },
                            2025: { apm: '73,50', apk: '97,96' }
                        }
                    };

                    const sd_apm1 = knownData.sd[y1]?.apm ?? dash;
                    const sd_apm2 = knownData.sd[y2]?.apm ?? dash;
                    const sd_apm3 = knownData.sd[y3]?.apm ?? dash;
                    const sd_apk1 = knownData.sd[y1]?.apk ?? dash;
                    const sd_apk2 = knownData.sd[y2]?.apk ?? dash;
                    const sd_apk3 = knownData.sd[y3]?.apk ?? dash;

                    const smp_apm1 = knownData.smp[y1]?.apm ?? dash;
                    const smp_apm2 = knownData.smp[y2]?.apm ?? dash;
                    const smp_apm3 = knownData.smp[y3]?.apm ?? dash;
                    const smp_apk1 = knownData.smp[y1]?.apk ?? dash;
                    const smp_apk2 = knownData.smp[y2]?.apk ?? dash;
                    const smp_apk3 = knownData.smp[y3]?.apk ?? dash;

                    const sma_apm1 = knownData.sma[y1]?.apm ?? dash;
                    const sma_apm2 = knownData.sma[y2]?.apm ?? dash;
                    const sma_apm3 = knownData.sma[y3]?.apm ?? dash;
                    const sma_apk1 = knownData.sma[y1]?.apk ?? dash;
                    const sma_apk2 = knownData.sma[y2]?.apk ?? dash;
                    const sma_apk3 = knownData.sma[y3]?.apk ?? dash;

                    return `<thead>
                        <tr class="bg-[#f95a00] text-white text-center font-bold">
                            <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                <div>Jenjang Pendidikan</div><div class="italic font-normal text-[11px] sm:text-xs">Educational Level</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                <div>Angka Partisipasi Murni</div><div class="italic font-normal text-[11px] sm:text-xs">Net Participation Rate</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                <div>Angka Partisipasi Kasar</div><div class="italic font-normal text-[11px] sm:text-xs">Gross Participation Rate</div>
                            </th>
                        </tr>
                        <tr class="bg-[#f95a00] text-white text-center font-bold text-xs sm:text-sm">
                            <th class="py-2 px-3 border border-slate-700">${y1}</th>
                            <th class="py-2 px-3 border border-slate-700">${y2}</th>
                            <th class="py-2 px-3 border border-slate-700">${y3}</th>
                            <th class="py-2 px-3 border border-slate-700">${y1}</th>
                            <th class="py-2 px-3 border border-slate-700">${y2}</th>
                            <th class="py-2 px-3 border border-slate-700">${y3}</th>
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
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">SD/MI/ <span class="italic font-normal">Elementary School</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sd_apm1}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sd_apm2}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sd_apm3}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sd_apk1}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sd_apk2}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sd_apk3}</td>
                        </tr>
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">SMP/MTs/ <span class="italic font-normal">Junior High School</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${smp_apm1}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${smp_apm2}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${smp_apm3}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${smp_apk1}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${smp_apk2}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${smp_apk3}</td>
                        </tr>
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">SMA/SMK/MA/ <span class="italic font-normal">Senior High School</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sma_apm1}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sma_apm2}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sma_apm3}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sma_apk1}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sma_apk2}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${sma_apk3}</td>
                        </tr>
                    </tbody>`;
                }
            },
            '4.1.13': {
                titleId: 'Angka Melek Aksara Menurut Jenis Kelamin dan Kelompok Umur di Kota Bukittinggi',
                titleEn: 'Literacy Rate by Sex and Age Group in Bukittinggi Municipality',
                render: function(year) {
                    const yrInt = parseInt(year) || 2025;
                    const dash = '<span class="text-slate-400 font-normal">-</span>';
                    const known = {
                        2025: {
                            '15_24': { l: '100,00', p: '100,00', tot: '100,00' },
                            '15_59': { l: '99,85', p: '99,80', tot: '99,82' },
                            '15_plus': { l: '99,60', p: '99,48', tot: '99,54' },
                            '60_plus': { l: '98,20', p: '97,50', tot: '97,82' }
                        },
                        2024: {
                            '15_24': { l: '100,00', p: '100,00', tot: '100,00' },
                            '15_59': { l: '99,80', p: '99,75', tot: '99,77' },
                            '15_plus': { l: '99,45', p: '99,85', tot: '99,65' },
                            '60_plus': { l: '97,90', p: '97,20', tot: '97,52' }
                        }
                    };
                    const cur = known[yrInt] || {};
                    const rows = [
                        { key: '15_24', label: '15–24' },
                        { key: '15_59', label: '15–59' },
                        { key: '15_plus', label: '15+' },
                        { key: '60_plus', label: '60+' }
                    ];
                    const tbody = rows.map(r => {
                        const l = cur[r.key]?.l ?? dash;
                        const p = cur[r.key]?.p ?? dash;
                        const tot = cur[r.key]?.tot ?? dash;
                        return `<tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">${r.label}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${l}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${p}</td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${tot}</td>
                        </tr>`;
                    }).join('');

                    return `<thead>
                        <tr class="bg-[#f95a00] text-white text-center font-bold">
                            <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                <div>Kelompok Umur</div><div class="italic font-normal text-[11px] sm:text-xs">Age Group</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                <div>Jenis Kelamin / Sex</div>
                            </th>
                        </tr>
                        <tr class="bg-[#f95a00] text-white text-center font-bold text-xs sm:text-sm">
                            <th class="py-2 px-3 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                            <th class="py-2 px-3 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                            <th class="py-2 px-3 border border-slate-700"><div>Laki-laki + Perempuan</div><div class="italic font-normal text-[10px]">Male + Female</div></th>
                        </tr>
                        <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                            <th class="py-1 px-3 border border-slate-700">(1)</th>
                            <th class="py-1 px-3 border border-slate-700">(2)</th>
                            <th class="py-1 px-3 border border-slate-700">(3)</th>
                            <th class="py-1 px-3 border border-slate-700">(4)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                        ${tbody}
                    </tbody>`;
                }
            },
            '4.1.14': {
                titleId: 'Persentase Penduduk Usia 7—24 Tahun Menurut Jenis Kelamin, Kelompok Umur dan Partisipasi Sekolah di Kota Bukittinggi',
                titleEn: 'Percentage of Population Aged 7—24 Years by Sex, Age Group and School Participation in Bukittinggi',
                render: function(year) {
                    const dash = '<span class="text-slate-400 font-normal">-</span>';
                    const sexes = [
                        { key: 'l', label: 'Laki–laki / <span class="italic font-normal">Male</span>' },
                        { key: 'p', label: 'Perempuan / <span class="italic font-normal">Female</span>' },
                        { key: 'tot', label: 'Laki-laki + Perempuan / <span class="italic font-normal">Total</span>' }
                    ];
                    const ageGroups = ['7–12', '13–15', '16–18', '19–24', '7–24'];

                    let tbody = '';
                    sexes.forEach(s => {
                        ageGroups.forEach((ag, idx) => {
                            tbody += '<tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">';
                            if (idx === 0) {
                                tbody += `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle" rowspan="5">${s.label}</td>`;
                            }
                            tbody += `
                                <td class="py-2.5 px-4 border border-slate-700 text-left align-middle">${ag}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${dash}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${dash}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${dash}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle font-bold">${dash}</td>
                            </tr>`;
                        });
                    });

                    return `<thead>
                        <tr class="bg-[#f95a00] text-white text-center font-bold">
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="2" rowspan="2">
                                <div>Jenis Kelamin dan Kelompok Umur</div><div class="italic font-normal text-[11px] sm:text-xs">Sex and Age Group</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="4">
                                <div>Partisipasi Sekolah</div><div class="italic font-normal text-[11px] sm:text-xs">School Participation</div>
                            </th>
                        </tr>
                        <tr class="bg-[#f95a00] text-white text-center font-bold text-xs sm:text-sm">
                            <th class="py-2 px-3 border border-slate-700"><div>Tidak/Belum Pernah Sekolah</div><div class="italic font-normal text-[10px]">No Schooling</div></th>
                            <th class="py-2 px-3 border border-slate-700"><div>Masih Sekolah</div><div class="italic font-normal text-[10px]">Attending School</div></th>
                            <th class="py-2 px-3 border border-slate-700"><div>Tidak Sekolah Lagi</div><div class="italic font-normal text-[10px]">Dropout</div></th>
                            <th class="py-2 px-3 border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
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
                        ${tbody}
                    </tbody>`;
                }
            },
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
});
