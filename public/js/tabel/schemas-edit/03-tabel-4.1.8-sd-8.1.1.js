/** SiBingka - Skema tabel (form isian / edit): 4.1.8, 4.1.15, 4.1.16, 4.1.17, 1.1.1, 8.1.1 */
Object.assign(window.tableSchemas, {
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
});
