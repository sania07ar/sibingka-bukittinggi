/** SiBingka - Skema tabel (form isian / edit): 2.3.4, 2.3.5, 3.1.1, 3.1.2, 3.1.8, 4.3.1, 3.2.8, 9.1, 4.1.24, 4.2.2 */
Object.assign(window.tableSchemas, {
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
            '3.1.3': {
                titleId: 'Jumlah Penduduk, Kepadatan Penduduk, dan Laju Pertumbuhan Penduduk',
                titleEn: 'Population, Population Density, and Population Growth Rate',
                isMultiYear: true,
                source: 'Source: BPS, Hasil Proyeksi Penduduk interim 2020–2023 (Pertengahan tahun/Juni)/',
                note: '<div>* Proyeksi</div>',
                render: function(year) {
                    const yr = parseInt(year) || 2024;
                    const startY = yr - 12;
                    const endY = yr;

                    const known = {
                        2012: ['116.075', '4599', '0.10486111111111'],
                        2013: ['118.26', '4.686', '0.10277777777778'],
                        2014: ['120.491', '4774', '0.10347222222222'],
                        2015: ['122.621', '4858', '0.095138888888889'],
                        2016: ['124.715', '4941', '0.090972222222222'],
                        2017: ['126.804', '5024', '0.088888888888889'],
                        2018: ['128.783', '5103', '0.080555555555556'],
                        2019: ['130.773', '5181', '0.079861111111111'],
                        2020: ['121.028', '4795', '0.05625'],
                        2021: ['121.588', '4817', '0.031944444444444'],
                        2022: ['122.311', '4846', '0.040972222222222'],
                        2023: ['124.047', '5132', '0.0625'],
                        2024: ['125.015', '5.033', '0.85']
                    };

                    let tbodyHtml = '';
                    for (let y = startY; y <= endY; y++) {
                        const label = (y <= 2019) ? `${y}*` : `${y}`;
                        const d = known[y] || ['-', '-', '-'];
                        const c1 = d[0] === '-' ? '<span class="text-slate-400 font-normal">-</span>' : d[0];
                        const c2 = d[1] === '-' ? '<span class="text-slate-400 font-normal">-</span>' : d[1];
                        const c3 = d[2] === '-' ? '<span class="text-slate-400 font-normal">-</span>' : d[2];
                        tbodyHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">${label}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${c1}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${c2}</td>
                                <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${c3}</td>
                            </tr>
                        `;
                    }

                    return `<thead>
                        <tr class="bg-[#f95a00] text-white text-center font-bold">
                            <th class="py-3 px-4 font-bold border border-slate-700"><div>Tahun</div><div class="italic font-normal text-[11px] sm:text-xs">Year</div></th>
                            <th class="py-3 px-4 font-bold border border-slate-700"><div>Penduduk</div><div class="italic font-normal text-[11px] sm:text-xs">Population</div></th>
                            <th class="py-3 px-4 font-bold border border-slate-700"><div>Kepadatan</div><div class="italic font-normal text-[11px] sm:text-xs">Density (Km2)</div></th>
                            <th class="py-3 px-4 font-bold border border-slate-700"><div>Laju Pertumbuhan Penduduk</div><div class="italic font-normal text-[11px] sm:text-xs">Population Growth Rate (%)</div></th>
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
                    </tbody>`;
                }
            },
            '3.1.6': {
                titleId: 'Persentase Penduduk Berumur 15 Ke Atas Menurut Jenis Kelamin dan kepandaian Membaca dan Menulis di Kota Bukittinggi',
                titleEn: 'Percentage of Population Age 15 and over by Sex and Read/Writes Skill in Bukittinggi Municipality',
                source: 'Source: BPS, Hasil Susenas/',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const d = (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr]) ? serverDbDataStore[yr] : {};

                    const known = {
                        2025: {
                            l_dapat: '99,60',
                            l_tidak: '0,40',
                            p_dapat: '99,48',
                            p_tidak: '0,52'
                        },
                        2024: {
                            l_dapat: '99,45',
                            l_tidak: '0,55',
                            p_dapat: '99,85',
                            p_tidak: '0,15'
                        }
                    };

                    const cur = known[yr] || {
                        l_dapat: '-',
                        l_tidak: '-',
                        p_dapat: '-',
                        p_tidak: '-'
                    };

                    const valLDapat = d['l_dapat'] !== undefined ? d['l_dapat'] : cur.l_dapat;
                    const valLTidak = d['l_tidak'] !== undefined ? d['l_tidak'] : cur.l_tidak;
                    const valPDapat = d['p_dapat'] !== undefined ? d['p_dapat'] : cur.p_dapat;
                    const valPTidak = d['p_tidak'] !== undefined ? d['p_tidak'] : cur.p_tidak;

                    return `<thead>
                        <tr class="bg-[#f95a00] text-white text-center font-bold">
                            <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                <div>Jenis Kelamin</div>
                                <div class="italic font-normal text-[11px] sm:text-xs">Sex Type</div>
                            </th>
                            <th class="py-3 px-4 font-bold border border-slate-700">
                                <div>Persentase</div>
                                <div class="italic font-normal text-[11px] sm:text-xs">Percentage</div>
                            </th>
                        </tr>
                        <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                            <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>
                            <th class="py-1 px-3 border border-slate-700">(2)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle" rowspan="2">Laki–laki / <span class="italic font-normal">Male</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Dapat Baca Tulis / <span class="italic font-normal">Read / Write Skill</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${valLDapat}</td>
                        </tr>
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Tidak Dapat Baca Tulis / <span class="italic font-normal">Read / Write Unskill</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${valLTidak}</td>
                        </tr>
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle" rowspan="2">Perempuan / <span class="italic font-normal">Female</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Dapat Baca Tulis / <span class="italic font-normal">Read / Write Skill</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${valPDapat}</td>
                        </tr>
                        <tr class="hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium">
                            <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Tidak Dapat Baca Tulis / <span class="italic font-normal">Read / Write Unskill</span></td>
                            <td class="py-2.5 px-4 border border-slate-700 text-center align-middle">${valPTidak}</td>
                        </tr>
                    </tbody>`;
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
                                    <div>Protestan</div><div class="italic font-normal text-[11px] sm:text-xs">Protestant</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Katholik</div><div class="italic font-normal text-[11px] sm:text-xs">Catholic</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Hindu</div><div class="italic font-normal text-[11px] sm:text-xs">Hindu</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Budha</div><div class="italic font-normal text-[11px] sm:text-xs">Buddha</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Lainnya</div><div class="italic font-normal text-[11px] sm:text-xs">Other</div>
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
            '3.2.8': {
                titleId: 'Jumlah Pencari Kerja yang Terdaftar Menurut Tingkat Pendidikan yang Ditamatkan di Kota Bukittinggi',
                titleEn: 'Number of Job Seeker Registered by Educational Attainment in Bukittinggi Municipality',
                source: 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const dash = '<span class="text-slate-400 font-normal">-</span>';
                    const fmt = (val) => {
                        if (val === null || val === undefined || val === '' || val === '-') return dash;
                        const s = val.toString().trim();
                        const clean = s.replace(/[^\d]/g, '');
                        if (!clean) return dash;
                        return parseInt(clean, 10).toLocaleString('id-ID');
                    };

                    const knownEduByYear = {
                        2025: [
                            [5, 0, 5, 7, 0, 7, 1, 0, 1, 2, 0, 2],
                            [281, 142, 423, 139, 127, 266, 23, 6, 29, 90, 32, 122],
                            [125, 208, 333, 58, 65, 123, 11, 17, 28, 45, 49, 94],
                            [284, 551, 835, 68, 162, 230, 19, 21, 40, 55, 130, 185]
                        ]
                    };

                    const eduValues = (knownEduByYear[yr]) ? knownEduByYear[yr] : [
                        Array(12).fill(null),
                        Array(12).fill(null),
                        Array(12).fill(null),
                        Array(12).fill(null)
                    ];

                    const knownTotals = {
                        2025: [695, 901, 1596, 272, 354, 626, 54, 44, 98, 192, 211, 403],
                        2024: [647, 777, 1424, 336, 376, 712, 127, 98, 225, 181, 257, 438],
                        2023: [658, 784, 1442, 302, 423, 725, 102, 206, 308, 161, 211, 372],
                        2022: [619, 778, 1397, 362, 541, 903, 103, 120, 223, 619, 778, 1397],
                        2021: [520, 624, 1144, 269, 301, 572, 229, 295, 524, 520, 624, 1144],
                        2020: [649, 798, 1447, 188, 285, 473, 211, 483, 692, 649, 798, 1447]
                    };

                    const eduLabels = [
                        '01. SD/SLTP',
                        '02. SLTA',
                        '03. Akademik',
                        '04. Perguruan Tinggi'
                    ];

                    let rowsHtml = '';
                    eduLabels.forEach((label, idx) => {
                        rowsHtml += `
                            <tr class="hover:bg-amber-100/60 transition-colors">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" colspan="2">${label}</td>
                        `;
                        for (let c = 0; c < 12; c++) {
                            const val = eduValues[idx] ? eduValues[idx][c] : null;
                            rowsHtml += `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${fmt(val)}</td>`;
                        }
                        rowsHtml += `</tr>`;
                    });

                    for (let i = 0; i < 6; i++) {
                        const y = yr - i;
                        const tot = knownTotals[y] || null;

                        if (i === 0) {
                            rowsHtml += `
                                <tr class="bg-[#fed7aa] font-bold">
                                    <td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-top" rowspan="6">
                                        Jumlah / <span class="italic font-bold">Total</span>
                                    </td>
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${y}</td>
                            `;
                            for (let c = 0; c < 12; c++) {
                                const val = tot ? tot[c] : null;
                                rowsHtml += `<td class="py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold">${fmt(val)}</td>`;
                            }
                            rowsHtml += `</tr>`;
                        } else {
                            rowsHtml += `
                                <tr class="hover:bg-amber-100/60 transition-colors">
                                    <td class="py-2.5 px-4 border border-slate-700 text-center align-top">${y}</td>
                            `;
                            for (let c = 0; c < 12; c++) {
                                const val = tot ? tot[c] : null;
                                rowsHtml += `<td class="py-2.5 px-4 border border-slate-700 text-center align-top">${fmt(val)}</td>`;
                            }
                            rowsHtml += `</tr>`;
                        }
                    }

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2" colspan="2">
                                    <div>Pendidikan Ditamatkan</div><div class="italic font-normal text-[11px] sm:text-xs">Educational Attainment</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                    <div>Belum Ditempatkan Tahun Ini</div><div class="italic font-normal text-[11px] sm:text-xs">Not Placed This Year Yet</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                    <div>Terdaftar</div><div class="italic font-normal text-[11px] sm:text-xs">Registered</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                    <div>Ditempatkan Tahun Ini</div><div class="italic font-normal text-[11px] sm:text-xs">Placed This Year</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="3">
                                    <div>Dihapuskan Tahun Ini</div><div class="italic font-normal text-[11px] sm:text-xs">Cleared This Year</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold text-xs">
                                <th class="py-2 px-3 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Laki–laki</div><div class="italic font-normal text-[10px]">Male</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Perempuan</div><div class="italic font-normal text-[10px]">Female</div></th>
                                <th class="py-2 px-3 border border-slate-700"><div>Jumlah</div><div class="italic font-normal text-[10px]">Total</div></th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700" colspan="2">(1)</th>
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
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
            '9.1': {
                titleId: 'Jumlah Koperasi Aktif Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Active Cooperative in Bukittinggi Municipality',
                isMultiYear: true,
                isExcludeSelectedYear: false,
                source: 'Dinas Koperasi, UKM dan Tenaga Kerja Kota Bukittinggi / <span class="italic text-slate-500">Cooperative, Small and Medium Business and Labor Services of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const p = get5YearPeriod(yr);
                    const years = p.yearsAsc;

                    const dataStore = {
                        2020: { guguk_panjang: '54', mandiangin_koto_selayan: '17', aur_birugo_tigo_baleh: '23', bukittinggi: '94' },
                        2021: { guguk_panjang: '54', mandiangin_koto_selayan: '17', aur_birugo_tigo_baleh: '24', bukittinggi: '95' },
                        2022: { guguk_panjang: '53', mandiangin_koto_selayan: '17', aur_birugo_tigo_baleh: '24', bukittinggi: '94' },
                        2023: { guguk_panjang: '52', mandiangin_koto_selayan: '15', aur_birugo_tigo_baleh: '27', bukittinggi: '94' },
                        2024: { guguk_panjang: '57', mandiangin_koto_selayan: '25', aur_birugo_tigo_baleh: '31', bukittinggi: '113' },
                        2025: { guguk_panjang: '62', mandiangin_koto_selayan: '30', aur_birugo_tigo_baleh: '36', bukittinggi: '128' }
                    };

                    const getVal = (y, key) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[y]) {
                            if (serverDbDataStore[y][key] !== undefined) return serverDbDataStore[y][key];
                            if (key === 'bukittinggi' && serverDbDataStore[y]['total'] !== undefined) return serverDbDataStore[y]['total'];
                        }
                        if (dataStore[y]) {
                            if (dataStore[y][key] !== undefined) return dataStore[y][key];
                            if (key === 'bukittinggi' && dataStore[y]['total'] !== undefined) return dataStore[y]['total'];
                        }
                        return '-';
                    };

                    const rows = [
                        { label: '01. Guguk Panjang', key: 'guguk_panjang' },
                        { label: '02. Mandiangin Koto Selayan', key: 'mandiangin_koto_selayan' },
                        { label: '03. Aur Birugo Tigo Baleh', key: 'aur_birugo_tigo_baleh' }
                    ];

                    const rowsHtml = rows.map(r => `
                        <tr class="hover:bg-amber-100/60 transition-colors">
                            <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">${r.label}</td>
                            ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 ${y === yr ? 'font-bold bg-amber-100/60' : ''}">${getVal(y, r.key)}</td>`).join('')}
                        </tr>
                    `).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700 text-left align-middle">
                                    <div>Kecamatan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Subdistrict</div>
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
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700 text-left font-extrabold">Bukittinggi</td>
                                ${years.map(y => `<td class="py-2.5 px-3 text-center border border-slate-700 font-extrabold ${y === yr ? 'bg-amber-200/80 ring-1 ring-amber-400' : ''}">${getVal(y, 'bukittinggi')}</td>`).join('')}
                            </tr>
                        </tbody>
                    `;
                }
            },
                                    '4.1.24': {
                titleId: 'Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi',
                titleEn: 'Number of Library Institutions, Collections, and Library Visitors in the City of Bukittinggi',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'Dinas Perpustakaan dan Kearsipan Kota Bukittinggi / <span class="italic text-slate-500">Library and Archives Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const officialData = {
                        2025: {
                            umum: ['21', '38460', '52776', '24123'],
                            sd_mi: ['62', '309610', '4341086', '387320'],
                            smp_mts: ['19', '52104', '567268', '173524'],
                            sma_smk_ma: ['26', '44085', '714152', '34782'],
                            perguruan_tinggi: ['19', '25103', '15721', '10926'],
                            taman_bacaan: ['11', '872', '1245', '2764'],
                            total: ['158', '470234', '5692248', '633439']
                        }
                    };

                    const yrData = officialData[yr] || {};

                    const getVal = (rowKey, colIdx, colName) => {
                        const dbKey = `${rowKey}_${colName}`;
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][dbKey] !== undefined) {
                            return serverDbDataStore[yr][dbKey];
                        }
                        if (isFuture) {
                            return '-';
                        }
                        if (yrData[rowKey] && yrData[rowKey][colIdx] !== undefined) {
                            return yrData[rowKey][colIdx];
                        }
                        return '-';
                    };

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rows = [
                        { key: 'umum', label: 'Umum / <span class="italic font-normal text-slate-600">General</span>' },
                        { key: 'sd_mi', label: 'SD / <span class="italic font-normal text-slate-600">MI / Primary School</span>' },
                        { key: 'smp_mts', label: 'SMP / <span class="italic font-normal text-slate-600">MTs / Junior High School</span>' },
                        { key: 'sma_smk_ma', label: 'SMA / <span class="italic font-normal text-slate-600">SMK/MA / Senior High School</span>' },
                        { key: 'perguruan_tinggi', label: 'Perguruan Tinggi / <span class="italic font-normal text-slate-600">College</span>' },
                        { key: 'taman_bacaan', label: 'Taman Bacaan / <span class="italic font-normal text-slate-600">Perpustakaan Masyarakat / Public Library</span>' },
                        { key: 'total', label: 'Jumlah / Total', isTotal: true }
                    ];

                    const rowsHtml = rows.map(r => {
                        const isTot = r.isTotal;
                        const rowCls = isTot ? 'bg-[#fed7aa] font-bold' : 'hover:bg-amber-100/60 transition-colors';
                        const vPerpus = getVal(r.key, 0, 'perpus');
                        const vJudul = getVal(r.key, 1, 'judul');
                        const vEks = getVal(r.key, 2, 'eksemplar');
                        const vPengunjung = getVal(r.key, 3, 'pengunjung');

                        return `
                            <tr class="${rowCls}" data-key="${r.key}">
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left align-middle">${r.label}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vPerpus, isTot ? 'font-bold' : '')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vJudul, isTot ? 'font-bold' : '')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vEks, isTot ? 'font-bold' : '')}</td>
                                <td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(vPengunjung, isTot ? 'font-bold' : '')}</td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jenis Perpustakaan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Library</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah Perpustakaan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Library</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Jumlah Koleksi</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Collection</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jumlah Pengunjung</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Number of Visitor</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-2 px-3 font-bold border border-slate-700">
                                    <div>Judul</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Title</div>
                                </th>
                                <th class="py-2 px-3 font-bold border border-slate-700">
                                    <div>Eksemplar</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Copies</div>
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
                        </tbody>
                    `;
                }
            },
            '4.2.2': {
                titleId: 'Jumlah Tenaga Kesehatan Menurut Kecamatan di Kota Bukittinggi',
                titleEn: 'Number of Health Human Resources by District in Bukittinggi Municipality',
                isMultiYear: false,
                isExcludeSelectedYear: false,
                source: 'DINAS KESEHATAN Kota Bukittinggi / <span class="italic text-slate-500">Bukittinggi Municipality Health Office</span>',
                note: '<div class="space-y-1"><div><sup>1</sup> Tenaga medis terdiri atas dokter, dokter gigi, dokter spesialis, dan dokter gigi spesialis baik di dalam maupun di luar negeri yang diakui oleh Pemerintah RI sesuai dengan peraturan perundang-undangan (UU No. 29 Tahun 2004 tentang Praktik Kedokteran)</div><div class="italic text-slate-500">/ Medical worker includes doctor, dentist, medical specialist, and dentist specialist at home and abroad recognized by Indonesian government in accordance with the laws and regulations (Law No. 29 year 2004 about Medical Practice)</div></div>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const isFuture = (yr > 2025);
                    const officialData = {
                        2024: {
                            guguk: [12, 0, 20, 17, 5, 10, 3, 2, 0, 2, 0, 0],
                            mks: [48, 0, 120, 62, 40, 85, 6, 21, 1, 17, 0, 0],
                            abtb: [211, 2, 546, 85, 205, 32, 21, 33, 29, 93, 86, 0],
                            total: [271, 2, 686, 164, 250, 127, 30, 56, 30, 112, 86, 0]
                        },
                        2025: {
                            guguk: [153, 1, 197, 69, 72, 21, 10, 16, 13, 53, 90, 0],
                            mks: [25, 0, 167, 40, 35, 8, 6, 8, 8, 14, 19, 0],
                            abtb: [211, 2, 546, 85, 205, 32, 21, 33, 29, 93, 86, 0],
                            total: [389, 3, 910, 194, 312, 61, 37, 57, 50, 160, 195, 0]
                        }
                    };
                    const yrData = officialData[yr] || {};
                    const getVal = (rowKey, colIdx) => {
                        if (typeof serverDbDataStore !== 'undefined' && serverDbDataStore[yr] && serverDbDataStore[yr][`${rowKey}_col${colIdx}`] !== undefined) {
                            return serverDbDataStore[yr][`${rowKey}_col${colIdx}`];
                        }
                        if (yrData[rowKey] && yrData[rowKey][colIdx] !== undefined) {
                            return yrData[rowKey][colIdx];
                        }
                        return isFuture ? '-' : '-';
                    };

                    const inp = (v, cls = '') => `<input type="text" class="table-edit-input w-full text-right pr-2 bg-transparent py-1 px-1 rounded border border-transparent hover:border-slate-300 focus:border-amber-500 focus:bg-white focus:outline-none text-slate-800 font-semibold text-xs sm:text-sm ${cls}" value="${v}">`;

                    const rows = [
                        { key: 'guguk', name: '01. Guguk Panjang' },
                        { key: 'mks', name: '02. Mandiangin Koto Selayan' },
                        { key: 'abtb', name: '03. Aur Birugo Tigo Baleh' }
                    ];

                    let rowsHtml = '';
                    rows.forEach(r => {
                        let cells = `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">${r.name}</td>`;
                        for (let i = 0; i < 12; i++) {
                            const val = getVal(r.key, i);
                            cells += `<td class="py-1 px-2 border border-slate-700 text-center align-middle">${inp(val)}</td>`;
                        }
                        rowsHtml += `<tr class="hover:bg-amber-100/60 transition-colors" data-key="${r.key}">${cells}</tr>`;
                    });

                    // Baris Total / Jumlah
                    let totalCells = `<td class="py-2.5 px-4 border border-slate-700 text-left font-semibold align-middle">Jumlah / <span class="italic font-bold">Total</span></td>`;
                    for (let i = 0; i < 12; i++) {
                        const val = getVal('total', i);
                        totalCells += `<td class="py-1 px-2 border border-slate-700 text-center align-middle font-extrabold">${inp(val, 'font-bold')}</td>`;
                    }
                    rowsHtml += `<tr class="bg-[#fed7aa] font-bold" data-key="total">${totalCells}</tr>`;

                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Medis<sup>1</sup></div><div class="italic font-normal text-[11px] sm:text-xs">Medical Worker<sup>1</sup></div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Psikologi Klinis</div><div class="italic font-normal text-[11px] sm:text-xs">Clinical Psychology</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Keperawatan</div><div class="italic font-normal text-[11px] sm:text-xs">Nursing Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kebidanan</div><div class="italic font-normal text-[11px] sm:text-xs">Midwifery Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kefarmasian</div><div class="italic font-normal text-[11px] sm:text-xs">Pharmaceutical Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kesehatan Masyarakat</div><div class="italic font-normal text-[11px] sm:text-xs">Public Health Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kesehatan Lingkungan</div><div class="italic font-normal text-[11px] sm:text-xs">Environmental Health Worker</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Gizi</div><div class="italic font-normal text-[11px] sm:text-xs">Nutritionist</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Keterapian Fisik</div><div class="italic font-normal text-[11px] sm:text-xs">Physical Therapists</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Keteknisan Medis</div><div class="italic font-normal text-[11px] sm:text-xs">Medical Technicians</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Teknik Biomedika</div><div class="italic font-normal text-[11px] sm:text-xs">Biomedical Engineer</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Tenaga Kesehatan Tradisional</div><div class="italic font-normal text-[11px] sm:text-xs">Traditional Health Worker</div>
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
                                <th class="py-1 px-3 border border-slate-700">(8)</th>
                                <th class="py-1 px-3 border border-slate-700">(9)</th>
                                <th class="py-1 px-3 border border-slate-700">(10)</th>
                                <th class="py-1 px-3 border border-slate-700">(11)</th>
                                <th class="py-1 px-3 border border-slate-700">(12)</th>
                                <th class="py-1 px-3 border border-slate-700">(13)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            ${rowsHtml}
                        </tbody>
                    `;
                }
            },
});
