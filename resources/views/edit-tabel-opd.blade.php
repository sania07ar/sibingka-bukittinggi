<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Edit Data Tabel Statistik Sektoral - SiMonDa Bukittinggi BPS">
    <title>Edit Data Tabel - SiMonDa BPS Kota Bukittinggi</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- xlsx-js-style for Excel Import & Parsing -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Clean Modern Table Cell Input */
        .table-edit-input {
            background-color: #ffffff;
            color: #0f172a;
            font-weight: 700;
            font-size: 13.5px;
            border-radius: 8px;
            border: 1.5px solid #fb923c;
            padding: 6px 10px;
            min-width: 90px;
            width: 100%;
            max-width: 220px;
            height: 38px;
            font-family: inherit;
            outline: none;
            text-align: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.15s ease-in-out;
        }

        .table-edit-input:hover {
            border-color: #ea580c;
        }

        .table-edit-input:focus {
            background-color: #fffaf0;
            border-color: #f95a00;
            box-shadow: 0 0 0 3px rgba(249, 90, 0, 0.2);
        }

        /* BPS Official Table Border Rules: Hilangkan garis hitam di ujung tepi luar */
        .table-custom-border {
            border-left: none !important;
            border-right: none !important;
        }

        .table-custom-border th:first-child,
        .table-custom-border td:first-child {
            border-left: none !important;
        }

        .table-custom-border th:last-child,
        .table-custom-border td:last-child {
            border-right: none !important;
        }

        .table-custom-border thead tr:first-child th {
            border-top: none !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between text-slate-800 antialiased selection:bg-orange-500 selection:text-white relative bg-[#f4f6f8]">

    <!-- Decorative Top Background Glow -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-64 bg-gradient-to-b from-orange-100/40 via-orange-50/20 to-transparent pointer-events-none -z-10"></div>

    <!-- MAIN WRAPPER -->
    <div class="w-full flex-1 flex flex-col">
        
        <!-- HEADER TOP BAR -->
        <header class="w-full bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 transition-all shadow-2xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-2.5 sm:py-3 flex items-center justify-between">
                
                <!-- Left: Logo BPS & Title SiMonDa -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <a href="{{ route('home') }}" class="transition-transform hover:scale-105 shrink-0" title="Kembali ke Beranda">
                        <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-8 sm:h-9 md:h-10 w-auto object-contain">
                    </a>
                    <div class="flex flex-col">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-sm sm:text-base md:text-lg font-black tracking-tight text-slate-900 leading-tight">
                                SiMonDa Bukittinggi
                            </h1>
                            <span class="px-2 py-0.5 rounded-full bg-orange-100 text-[#f95a00] font-bold text-[10px] tracking-wider uppercase">
                                Editor Data
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium hidden sm:block">
                            Halaman Pengeditan Data Statistik Sektoral Kota Bukittinggi
                        </p>
                    </div>
                </div>


                <!-- Right: Action Back to View Table -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <button onclick="backToTableView()" 
                       class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-1.5 shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Kembali ke Tabel</span>
                    </button>
                </div>

            </div>
        </header>

        <!-- BREADCRUMB NAVIGATION & YEAR SWITCHER -->
        <div id="breadcrumbBar" class="w-full bg-white/70 border-b border-slate-200/60 backdrop-blur-xs py-2 px-4 sm:px-6 lg:px-10">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                
                <!-- Breadcrumbs -->
                <div class="flex items-center space-x-2 text-slate-500 overflow-x-auto whitespace-nowrap">
                    <a href="{{ route('home') }}" class="hover:text-[#f95a00] transition-colors flex items-center space-x-1">
                        <i class="fa-solid fa-house text-[10px]"></i>
                        <span>Beranda</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <a href="{{ route('isi-data-opd') }}" class="hover:text-[#f95a00] transition-colors">Daftar OPD</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span id="breadcrumbOpdText" class="font-bold text-slate-800">01. DINAS PUPR</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <a href="javascript:void(0)" onclick="backToTableView()" class="hover:text-[#f95a00] transition-colors">
                        <span id="breadcrumbTableText" class="font-bold text-slate-700">Tabel 1.1.6</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span class="font-extrabold text-[#f95a00]">Edit Data</span>
                </div>

            </div>
        </div>

        <!-- MAIN TABLE EDIT CONTAINER -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-3 sm:py-5 flex-1 w-full">
            
            <!-- TABLE CARD -->
            <div class="bg-white rounded-2xl p-4 sm:p-7 md:p-8 shadow-sm border border-slate-200/90 relative transition-all">
                
                <!-- TOP CARD HEADER BAR: 4-Square Grid Icon + Title + Edit Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-4 mb-6 gap-3">
                    <div class="flex items-center space-x-3">
                        <!-- 4-Square Grid Icon -->
                        <div class="grid grid-cols-2 gap-0.5 w-5 h-5 shrink-0" aria-hidden="true">
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                        </div>

                        <!-- Title: Edit Tabel 1.1.6 Tahun 2025 -->
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 id="pageMainHeading" class="text-base sm:text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                    Edit Data Tabel 1.1.6 Tahun 2025
                                </h2>
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px] uppercase tracking-wider">
                                    Mode Editor
                                </span>
                            </div>
                            <p id="subHeadingOpd" class="text-xs text-slate-500 font-medium">01. DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</p>
                        </div>
                    </div>

                    <!-- Right Header Actions: Import Excel + Reset + Save & Cancel -->
                    <div id="actionHeaderRight" class="flex items-center flex-wrap gap-2">
                        <!-- Import Excel Button -->
                        <button onclick="document.getElementById('editExcelInput').click()" 
                                class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Impor nilai data dari berkas Excel (.xlsx / .xls)">
                            <i class="fa-solid fa-file-excel text-emerald-600 text-[11px]"></i>
                            <span>Import Excel</span>
                        </button>
                        <input type="file" id="editExcelInput" accept=".xlsx, .xls, .csv" class="hidden" onchange="handleEditExcelImport(event)">

                        <button onclick="resetTableOriginal()" 
                                class="px-3 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Kembalikan nilai ke data awal">
                            <i class="fa-solid fa-rotate-left text-[11px]"></i>
                            <span>Reset Nilai</span>
                        </button>

                        <button onclick="backToTableView()" 
                                class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer">
                            <i class="fa-solid fa-xmark text-[11px]"></i>
                            <span>Batal</span>
                        </button>

                        <button onclick="saveAndReturn()" 
                                class="px-4 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>

                <!-- TABLE TITLE & METADATA SECTION -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 mb-5 text-xs sm:text-sm text-slate-900">
                    
                    <!-- Left Column: Tabel / Table Number -->
                    <div class="md:col-span-3 flex items-start space-x-4">
                        <div class="flex flex-col font-bold text-slate-900 space-y-1">
                            <span>Tabel</span>
                            <span class="italic font-normal text-slate-600">Table</span>
                        </div>
                        <div class="flex flex-col font-bold text-slate-900 space-y-1">
                            <span id="metaTableCode">1.1.6</span>
                            <span class="opacity-0">.</span>
                        </div>
                    </div>

                    <!-- Right Column: Tabel Title (Indonesian & English) -->
                    <div class="md:col-span-9 flex flex-col space-y-1">
                        <div id="metaTableTitleId" class="font-bold text-slate-900 leading-snug">
                            Nama Sungai/Batang, Lebar dan Kecamatan yang Dilalui di Kota Bukittinggi, 2025
                        </div>
                        <div id="metaTableTitleEn" class="italic font-normal text-slate-600 leading-snug">
                            Name, Width of The River and District Its Pass in Bukittinggi, 2025
                        </div>
                    </div>

                </div>

                <!-- INSTRUCTION BANNER -->
                <div class="mb-5 p-3.5 rounded-xl bg-orange-50 border border-orange-200 text-orange-950 text-xs flex items-center justify-between gap-3 shadow-2xs">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-[#f95a00] text-white flex items-center justify-center font-bold text-sm shadow-2xs shrink-0">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900">Petunjuk Pengeditan:</span>
                            <p class="text-slate-600 text-[11px] mt-0.5">Ubah angka atau teks pada kotak oranye di bawah ini. Setelah selesai, klik tombol <strong>"Simpan Perubahan"</strong> di atas atau di bawah tabel.</p>
                        </div>
                    </div>
                </div>

                <!-- TABLE DISPLAY CONTAINER (SCROLLABLE ON MOBILE) -->
                <div class="overflow-x-auto mb-5" id="printableTableSection">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse table-custom-border" id="dataDisplayTable">
                        <!-- Injected via JavaScript based on table code and year -->
                    </table>
                </div>

                <!-- TABLE FOOTER: SOURCE / SUMBER -->
                <div class="text-xs text-slate-700 space-y-1 pt-2 border-t border-slate-100 mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-2">
                        <div class="sm:col-span-2 font-bold flex space-x-1">
                            <span>Sumber</span>
                            <span class="font-normal">/</span>
                            <span class="italic font-normal text-slate-500">Source:</span>
                        </div>
                        <div class="sm:col-span-10 text-slate-600" id="tableSourceContent">
                            Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>
                        </div>
                    </div>
                </div>

                <!-- BOTTOM ACTION BAR -->
                <div id="bottomActionBar" class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-slate-200">
                    <button onclick="backToTableView()" 
                            class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-2 cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Batal & Kembali ke Tabel</span>
                    </button>

                    <div class="flex items-center flex-wrap gap-2">
                        <button onclick="resetTableOriginal()" 
                                class="px-4 py-2 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300 text-xs font-bold transition-all flex items-center space-x-1.5 cursor-pointer shadow-2xs">
                            <i class="fa-solid fa-rotate-left text-xs"></i>
                            <span>Reset Nilai Asli</span>
                        </button>
                        <button onclick="saveAndReturn()" 
                                class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all flex items-center space-x-1.5 cursor-pointer shadow-2xs">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Simpan Perubahan Data</span>
                        </button>
                    </div>
                </div>

            </div>

        </main>

        <!-- FOOTER & USER SESSION BAR -->
        <footer class="w-full border-t border-slate-200/60 bg-white/50 backdrop-blur-sm py-2.5 px-4 sm:px-8 text-slate-600 mt-auto">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2.5 text-xs">
                
                <div class="inline-flex items-center space-x-2.5 px-3 py-1 rounded-full bg-white/60 hover:bg-white/80 border border-slate-200/80 shadow-xs transition-all backdrop-blur-xs">
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[10px] shadow-xs">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <span class="font-bold text-slate-800 text-xs">{{ session('user.displayName', 'Admin BPS Bukittinggi') }}</span>
                    </div>
                </div>

                <div class="text-center md:text-right text-[11px] text-slate-500 font-medium">
                    &copy; {{ date('Y') }} Badan Pusat Statistik Kota Bukittinggi. All rights reserved.
                </div>

            </div>
        </footer>

    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastNotification" class="fixed bottom-5 right-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <div class="bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-xl border border-slate-700 flex items-center space-x-3 text-xs">
            <div id="toastIcon" class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check"></i>
            </div>
            <span id="toastMessage" class="font-medium">Pemberitahuan</span>
        </div>
    </div>

    <!-- JAVASCRIPT DATA CATALOG, EXPORT SUITE & RENDERER -->
    <script>
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

        // Table Schemas & Structured Data
        const tableSchemas = {
            '1.1.6': {
                titleId: 'Nama Sungai/Batang, Lebar dan Kecamatan yang Dilalui di Kota Bukittinggi',
                titleEn: 'Name, Width of The River and District Its Pass in Bukittinggi',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    const is2025 = year.toString() === '2025';
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
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 align-top" rowspan="2">
                                    01. Batang Tambuo
                                </td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-top ${is2025 ? '' : 'text-slate-400 font-normal'}" rowspan="2">
                                    ${is2025 ? '6–10' : '-'}
                                </td>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold ${is2025 ? '' : 'text-slate-400 font-normal'}">1</td>
                                <td class="py-2 px-4 border border-slate-700 ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    ${is2025 ? 'Aur Birugo Tigo Baleh' : '-'}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold ${is2025 ? '' : 'text-slate-400 font-normal'}">2</td>
                                <td class="py-2 px-4 border border-slate-700 ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    ${is2025 ? 'Mandiangin Koto Selayan' : '-'}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700 align-top" rowspan="2">
                                    02. Batang Sianok
                                </td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 align-top ${is2025 ? '' : 'text-slate-400 font-normal'}" rowspan="2">
                                    ${is2025 ? '12–15' : '-'}
                                </td>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold ${is2025 ? '' : 'text-slate-400 font-normal'}">1</td>
                                <td class="py-2 px-4 border border-slate-700 ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    ${is2025 ? 'Aur Birugo Tigo Baleh' : '-'}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold ${is2025 ? '' : 'text-slate-400 font-normal'}">2</td>
                                <td class="py-2 px-4 border border-slate-700 ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    ${is2025 ? 'Guguk Panjang' : '-'}
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
                titleId: 'Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi (km)',
                titleEn: 'Length of Roads by Level of Government Authority in Bukittinggi Municipality (km)',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kewenangan Pemerintah</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Level of Government</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Panjang Jalan (km)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Length of Roads (km)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Persentase (%)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Percentage (%)</div>
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
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Jalan Negara / Nasional</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">15,40</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">12,50</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Jalan Provinsi</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">18,20</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">14,77</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Jalan Kota Bukittinggi</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">89,63</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">72,73</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / Total</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">100,00</td>
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
                    const years = [yr - 4, yr - 3, yr - 2, yr - 1, yr];
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Jenis Permukaan Jalan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Road Surface</div>
                                </th>
                                <th class="py-2 px-4 font-bold border border-slate-700" colspan="5">
                                    <div>Tahun / Year</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                ${years.map(y => `<th class="py-1 px-3 border border-slate-700 ${y === yr ? 'bg-amber-600' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                ${years.map((y, i) => `<th class="py-1 px-2 border border-slate-700">(${i + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Aspal / Asphalt</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">105,20</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">107,40</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">109,10</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">110,80</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold bg-amber-50">112,50</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Kerikil / Gravel</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">12,50</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">11,20</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">10,00</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">8,90</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold bg-amber-50">7,50</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Tanah / Earth</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">5,53</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">4,63</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">4,13</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">3,53</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold bg-amber-50">3,23</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / Total</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.3': {
                titleId: 'Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km)',
                titleEn: 'Length of Roads by Road Condition in Bukittinggi Municipality (km)',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                isMultiYear: true,
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const years = [yr - 4, yr - 3, yr - 2, yr - 1, yr];
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Kondisi Jalan</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Road Condition</div>
                                </th>
                                <th class="py-2 px-4 font-bold border border-slate-700" colspan="5">
                                    <div>Tahun / Year</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                ${years.map(y => `<th class="py-1 px-3 border border-slate-700 ${y === yr ? 'bg-amber-600' : ''}">${y}</th>`).join('')}
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                ${years.map((y, i) => `<th class="py-1 px-2 border border-slate-700">(${i + 2})</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Baik / Good</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">65,40</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">68,10</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">70,50</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">72,80</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold bg-amber-50">75,20</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Sedang / Moderate</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">32,10</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">30,50</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">28,90</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">27,10</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold bg-amber-50">26,00</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Rusak / Damaged</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">18,20</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">17,00</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">16,20</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">15,50</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold bg-amber-50">14,80</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Rusak Berat / Severely Damaged</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">7,53</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">7,63</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">7,63</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">7,83</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700 font-bold bg-amber-50">7,23</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / Total</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,23</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.4': {
                titleId: 'Banyak dan Panjang Jembatan serta Panjang Trotoar di Kota Bukittinggi',
                titleEn: 'Number and Length of Bridges and Length of Sidewalks in Bukittinggi Municipality',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700" rowspan="2">
                                    <div>Uraian Prasarana</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Infrastructure Description</div>
                                </th>
                                <th class="py-2 px-4 font-bold border border-slate-700" colspan="2">
                                    <div>Tahun / Year ${year}</div>
                                </th>
                            </tr>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-1 px-4 border border-slate-700">Banyak / Jumlah (Unit)</th>
                                <th class="py-1 px-4 border border-slate-700">Panjang / Length (m)</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Jembatan Permanen (Beton / Baja)</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">38</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">624,50</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Jembatan Semi Permanen / Kayu</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">6</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">48,20</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Trotoar Jalan Utama</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">–</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">45.280,00</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Total Jembatan</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">44</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">672,70</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.5': {
                titleId: 'Panjang Gorong-gorong dan Panjang Drainase di Kota Bukittinggi',
                titleEn: 'Length of Culverts and Length of Drainage in Bukittinggi Municipality',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jenis Prasarana Sanitasi & Tata Air</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Sanitation & Drainage Infrastructure</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Panjang / Saluran (m)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Length (m)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kondisi Berfungsi Baik (%)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Good Condition (%)</div>
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
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Saluran Drainase Primer / Utama</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">32.450,00</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">88,50</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Saluran Drainase Sekunder & Lingkungan</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">76.820,00</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">82,10</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Gorong-gorong Jalan Kota</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">8.940,00</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">85,00</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Total Panjang Saluran & Gorong-gorong</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">118.210,00</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">84,08</td>
                            </tr>
                        </tbody>
                    `;
                }
            }
        };

        // Query params parsing
        const urlParams = new URLSearchParams(window.location.search);
        let currentTableCode = urlParams.get('code') || urlParams.get('table') || '1.1.6';
        let currentOpdCode = urlParams.get('opd') || '01';
        let currentYear = urlParams.get('year') || '2025';

        // Initialize Page
        document.addEventListener('DOMContentLoaded', () => {
            // Clean up accidental 2026 cache for table 1.1.6
            try {
                localStorage.removeItem('simonda_table_html_1.1.6_2026');
            } catch(e) {}

            initYearSwitcher();
            renderEditTablePage();
        });

        function initYearSwitcher() {
            const selectYearEl = document.getElementById('yearSwitcher');
            if (!selectYearEl) return;
            selectYearEl.innerHTML = '';

            const nowYear = new Date().getFullYear();
            const endYear = Math.max(2026, nowYear + 1);

            for (let y = endYear; y >= 2020; y--) {
                const opt = document.createElement('option');
                opt.value = y.toString();
                opt.textContent = `Tahun ${y}`;
                if (y.toString() === currentYear.toString()) {
                    opt.selected = true;
                }
                selectYearEl.appendChild(opt);
            }
            selectYearEl.value = currentYear.toString();
        }

        window.addEventListener('popstate', () => {
            const p = new URLSearchParams(window.location.search);
            currentTableCode = p.get('code') || p.get('table') || '1.1.6';
            currentOpdCode = p.get('opd') || '01';
            currentYear = p.get('year') || '2025';
            const selectYearEl = document.getElementById('yearSwitcher');
            if (selectYearEl) selectYearEl.value = currentYear.toString();
            renderEditTablePage();
        });

        function renderEditTablePage() {
            const opdName = opdNames[currentOpdCode] || 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG';
            document.getElementById('breadcrumbOpdText').innerText = `${currentOpdCode}. ${opdName}`;
            document.getElementById('breadcrumbTableText').innerText = `Tabel ${currentTableCode}`;

            document.getElementById('pageMainHeading').innerText = `Edit Data Tabel ${currentTableCode} Tahun ${currentYear}`;
            document.getElementById('subHeadingOpd').innerText = `${currentOpdCode}. ${opdName}`;
            document.getElementById('metaTableCode').innerText = currentTableCode;

            const schema = tableSchemas[currentTableCode] || {
                titleId: `Tabel Data Statistik Sektoral ${currentTableCode} di Kota Bukittinggi`,
                titleEn: `Sectoral Statistics Table ${currentTableCode} in Bukittinggi Municipality`,
                source: `${opdName} Kota Bukittinggi / <span class="italic text-slate-500">Bukittinggi Municipality</span>`,
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
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Data Statistik Sektoral Utama 1</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">Unit</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Data Statistik Sektoral Utama 2</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">%</td>
                            </tr>
                        </tbody>
                    `;
                }
            };

            const yr = parseInt(currentYear) || 2025;
            const yearLabel = schema.isMultiYear ? `${yr - 4}–${yr}` : `${yr}`;

            const customTitleId = localStorage.getItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
            const customTitleEn = localStorage.getItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
            const customSource = localStorage.getItem(`simonda_table_source_text_${currentTableCode}_${currentYear}`);

            document.getElementById('metaTableTitleId').innerText = customTitleId ? customTitleId : `${schema.titleId}, ${yearLabel}`;
            document.getElementById('metaTableTitleEn').innerText = customTitleEn ? customTitleEn : `${schema.titleEn}, ${yearLabel}`;
            document.getElementById('tableSourceContent').innerHTML = customSource ? customSource : schema.source;

            const tableEl = document.getElementById('dataDisplayTable');
            
            // Check if user previously saved custom data
            let savedHtml = localStorage.getItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
            if (savedHtml) {
                tableEl.innerHTML = savedHtml;
            } else {
                tableEl.innerHTML = schema.render(currentYear);
            }

            cleanGhostColumns(tableEl);

            // Transform cells to editable grid with orange inputs
            transformToEditableGrid(tableEl);
        }

        function cleanGhostColumns(table) {
            if (!table) return;
            const bodyRows = table.querySelectorAll('tbody tr');
            if (bodyRows.length === 0) return;

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
                bodyRows.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 2) {
                        tds[tds.length - 1].remove();
                    }
                });

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

                const savedKey = `simonda_table_html_${currentTableCode}_${currentYear}`;
                if (localStorage.getItem(savedKey)) {
                    localStorage.setItem(savedKey, table.innerHTML);
                }
            }
        }

        function transformToEditableGrid(tableEl) {
            const rows = tableEl.querySelectorAll('tbody tr');
            rows.forEach(tr => {
                const cells = tr.querySelectorAll('td');
                cells.forEach((td, idx) => {
                    if (td.querySelector('.table-edit-input')) return;

                    const val = td.innerText.trim();
                    td.setAttribute('data-orig-val', val);

                    const isNumericOrData = idx > 0 || !isNaN(parseFloat(val.replace(',', '.'))) || val === '-' || val.includes('–');

                    if (isNumericOrData) {
                        td.innerHTML = `
                            <div class="flex items-center justify-center p-1">
                                <input type="text" class="table-edit-input" value="${val}" spellcheck="false" />
                            </div>
                        `;
                    } else {
                        td.classList.add('font-bold', 'text-slate-900');
                    }
                });
            });
        }

        function changeTableYear(newYear) {
            currentYear = newYear.toString();
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('year', currentYear);
            window.history.pushState({}, '', newUrl);

            const selectYearEl = document.getElementById('yearSwitcher');
            if (selectYearEl) selectYearEl.value = currentYear;

            renderEditTablePage();
            showToast(`Tahun data diubah ke ${currentYear}`);
        }

        function resetTableOriginal() {
            const tableEl = document.getElementById('dataDisplayTable');
            const inputs = tableEl.querySelectorAll('.table-edit-input');
            
            inputs.forEach(input => {
                const td = input.closest('td');
                if (td) {
                    const origVal = td.getAttribute('data-orig-val') || '';
                    input.value = origVal;
                }
            });

            localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
            showToast('🔄 Nilai tabel dikembalikan ke data awal.');
        }

        function saveAndReturn() {
            const tableEl = document.getElementById('dataDisplayTable');
            
            // Convert to clean table markup for storage
            const clone = tableEl.cloneNode(true);
            const cloneInputs = clone.querySelectorAll('.table-edit-input');
            cloneInputs.forEach(input => {
                const td = input.closest('td');
                if (td) {
                    td.innerHTML = input.value.trim();
                }
            });

            // Save to localStorage
            localStorage.setItem(`simonda_table_html_${currentTableCode}_${currentYear}`, clone.innerHTML);
            localStorage.setItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '1');

            showToast('✅ Data tabel berhasil disimpan! Mengalihkan ke tabel...');
            setTimeout(() => {
                window.location.href = `{{ route('tabel-opd') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}&saved=1`;
            }, 500);
        }

        function backToTableView() {
            window.location.href = `{{ route('tabel-opd') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`;
        }

        function handleEditExcelImport(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    const sheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[sheetName];
                    const rawRows = XLSX.utils.sheet_to_json(worksheet, { header: 1, defval: '' });

                    const cleanRows = rawRows.filter(r => Array.isArray(r) && r.some(c => c !== null && c !== undefined && c.toString().trim() !== ''));
                    if (cleanRows.length < 2) {
                        alert('Berkas Excel kosong atau tidak memiliki cukup baris data.');
                        return;
                    }

                    // Find header row
                    let headerIdx = 0;
                    for (let i = 0; i < cleanRows.length; i++) {
                        const nonEmpties = cleanRows[i].filter(c => c !== null && c !== undefined && c.toString().trim() !== '');
                        const firstVal = (cleanRows[i][0] || '').toString().toLowerCase();
                        if (nonEmpties.length >= 2 && !firstVal.includes('badan pusat') && !firstVal.includes('tabel ') && !firstVal.includes('bps')) {
                            headerIdx = i;
                            break;
                        }
                    }

                    const dataRows = cleanRows.slice(headerIdx + 1);
                    const tableEl = document.getElementById('dataDisplayTable');
                    const tbody = tableEl.querySelector('tbody');
                    const trs = tbody.querySelectorAll('tr');

                    let filledCount = 0;
                    trs.forEach((tr, rowIdx) => {
                        const excelRow = dataRows[rowIdx];
                        if (!excelRow) return;

                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length > 0) {
                            // Find corresponding data values in excel row (usually starting after row name or index 1+)
                            let excelColIdx = excelRow.length > inputs.length ? (excelRow.length - inputs.length) : 0;
                            inputs.forEach((inp, inpIdx) => {
                                const val = excelRow[excelColIdx + inpIdx];
                                if (val !== undefined && val !== null) {
                                    inp.value = val.toString().trim();
                                    inp.classList.add('bg-amber-100');
                                    filledCount++;
                                }
                            });
                        }
                    });

                    showToast(`✅ Berhasil mengimpor nilai dari ${file.name}!`);
                } catch(err) {
                    console.error(err);
                    alert('Gagal membaca berkas Excel. Pastikan berkas berformat .xlsx, .xls, atau .csv yang valid.');
                } finally {
                    event.target.value = '';
                }
            };
            reader.readAsArrayBuffer(file);
        }

        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const toastMessage = document.getElementById('toastMessage');
            if (toast && toastMessage) {
                toastMessage.innerText = message;
                toast.classList.remove('translate-y-20', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');

                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3500);
            }
        }
    </script>
</body>
</html>
