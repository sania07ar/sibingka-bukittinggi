/** SiBingka - Skema tabel (form isian / edit): 4.1.3, 4.1.4, 4.1.5, 4.1.7 */
Object.assign(window.tableSchemas, {
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
});
