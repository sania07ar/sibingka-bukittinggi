<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Edit Data Tabel Statistik Sektoral - SiAngka Kota Bukittinggi BPS">
    <title>Edit Data Tabel - SiAngka Kota Bukittinggi</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- xlsx-js-style for Excel Import & Parsing -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>

    <!-- Master Tables Catalog (All OPD & Instansi) -->
    <script src="{{ asset('simonda-catalogs.js') }}"></script>

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

        @page {
            size: A4 landscape;
            margin: 8mm 12mm 10mm 12mm;
        }

        @media print {
            *, *::before, *::after {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            header, footer, #breadcrumbBar, #actionHeaderRight, #bottomActionBar, .fixed {
                display: none !important;
            }
            main {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            #printableTableSection {
                overflow: visible !important;
                width: 100% !important;
            }
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
                
                <!-- Left: Logo BPS & Title SiAngka -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <a href="{{ route('home') }}" class="transition-transform hover:scale-105 shrink-0" title="Kembali ke Beranda">
                        <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-8 sm:h-9 md:h-10 w-auto object-contain">
                    </a>
                    <div class="flex flex-col">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-sm sm:text-base md:text-lg font-black tracking-tight text-slate-900 leading-tight">
                                SiAngka <span class="font-bold text-[#f95a00] text-xs sm:text-sm">Kota Bukittinggi</span>
                            </h1>
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200/90 font-bold text-[10px] tracking-wider uppercase">
                                Editor Data
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium hidden sm:block">
                            Sistem Informasi Data Daerah dalam Angka Bukittinggi
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
                    <a id="breadcrumbCatalogLink" href="{{ ($currentType ?? 'opd') === 'instansi' ? route('isi-data-instansi') : route('isi-data-opd') }}" class="hover:text-[#f95a00] transition-colors">
                        <span id="breadcrumbCatalogText">{{ ($currentType ?? 'opd') === 'instansi' ? 'Daftar Instansi' : 'Daftar OPD' }}</span>
                    </a>
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

                    <!-- Right Header Actions: Table Switcher + Import Excel + Reset + Save & Cancel -->
                    <div id="actionHeaderRight" class="flex items-center flex-wrap gap-2">
                        <!-- Table Switcher Selector (Hanya Tampil 'Tabel X.X.X', Deskripsi Muncul Saat Ditekan) -->
                        <div class="relative flex items-center space-x-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 rounded-lg px-2.5 py-1.5 transition-colors shadow-2xs cursor-pointer group" title="Ganti tabel dalam instansi ini">
                            <i class="fa-solid fa-table-list text-slate-400 text-xs shrink-0 pointer-events-none group-hover:text-[#f95a00] transition-colors"></i>
                            <span id="tableSwitcherLabel" class="text-xs font-bold text-slate-700 pointer-events-none select-none">Tabel {{ $currentTableCode ?? '1.1.6' }}</span>
                            <i class="fa-solid fa-chevron-down text-[8px] text-slate-400 pointer-events-none"></i>
                            <select id="tableSwitcher" onchange="changeTableCode(this.value)" 
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer text-xs">
                                <!-- Populated dynamically based on current OPD / Instansi -->
                            </select>
                        </div>

                        <!-- Unduh Template Button -->
                        <button onclick="downloadEditExcelTemplate()" 
                                class="px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Unduh format template Excel untuk diisi">
                            <i class="fa-solid fa-file-arrow-down text-amber-600 text-[11px]"></i>
                            <span>Unduh Template</span>
                        </button>

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

                <!-- TABLE FOOTER: NOTE & SOURCE / SUMBER -->
                <div class="text-xs text-slate-700 space-y-2 pt-2 border-t border-slate-100 mb-6">
                    <div id="tableNoteRow" class="hidden grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-2">
                        <div class="sm:col-span-2 font-bold flex space-x-1">
                            <span>Catatan</span>
                            <span class="font-normal">/</span>
                            <span class="italic font-normal text-slate-500">Note:</span>
                        </div>
                        <div class="sm:col-span-10 text-slate-700 leading-relaxed" id="tableNoteContent">
                        </div>
                    </div>
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
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold">1</td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Aur Birugo Tigo Baleh
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold">2</td>
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
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold">1</td>
                                <td class="py-2 px-4 border border-slate-700 font-medium">
                                    Aur Birugo Tigo Baleh
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold">2</td>
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
        let serverDbDataStore = @json($dbDataStore ?? []);
        let serverDbMetadata = @json($dbMetadata ?? null);
        let serverDbFallbackMetadata = @json($dbFallbackMetadata ?? null);
        const csrfToken = '{{ csrf_token() }}';

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

        // Query params parsing
        const urlParams = new URLSearchParams(window.location.search);
        let currentTableCode = urlParams.get('code') || urlParams.get('table') || '{{ $currentTableCode ?? "8.1.1" }}';
        let currentOpdCode = urlParams.get('opd') || '{{ $currentOpdCode ?? "01" }}';
        let currentYear = urlParams.get('year') || '{{ $currentYear ?? "2025" }}';
        let currentType = urlParams.get('type') || '{{ $currentType ?? "opd" }}';

        // Initialize Page
        document.addEventListener('DOMContentLoaded', () => {
            // Clean up accidental saves
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

            renderEditTablePage();
        });

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
            if (confirm('Beralih ke tabel lain dalam instansi ini? Pastikan perubahan Anda telah disimpan terlebih dahulu.')) {
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
            } else {
                const sel = document.getElementById('tableSwitcher');
                if (sel) sel.value = currentTableCode;
            }
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
            const p = new URLSearchParams(window.location.search);
            currentType = p.get('type') || '{{ $currentType ?? "opd" }}';
            currentTableCode = p.get('code') || p.get('table') || '1.1.6';
            currentOpdCode = p.get('opd') || '01';
            currentYear = p.get('year') || '2025';
            renderEditTablePage();
        });

        function renderEditTablePage() {
            const isInstansi = currentType === 'instansi';
            const agencyName = getAgencyName(currentOpdCode);

            const breadcrumbCatalogLink = document.getElementById('breadcrumbCatalogLink');
            const breadcrumbCatalogText = document.getElementById('breadcrumbCatalogText');
            if (breadcrumbCatalogLink) {
                breadcrumbCatalogLink.href = isInstansi ? "{{ route('isi-data-instansi') }}" : "{{ route('isi-data-opd') }}";
            }
            if (breadcrumbCatalogText) {
                breadcrumbCatalogText.innerText = isInstansi ? 'Daftar Instansi' : 'Daftar OPD';
            }

            document.getElementById('breadcrumbOpdText').innerText = `${currentOpdCode}. ${agencyName}`;
            document.getElementById('breadcrumbTableText').innerText = `Tabel ${currentTableCode}`;

            document.getElementById('subHeadingOpd').innerText = `${currentOpdCode}. ${agencyName}`;
            document.getElementById('metaTableCode').innerText = currentTableCode;

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

            // Jika schema title masih generik namun ada info katalog resmi, gunakan judul resmi katalog
            if (catInfo && catInfo.title && (!schema.titleId || schema.titleId.startsWith('Tabel Data Statistik Sektoral'))) {
                schema.titleId = catInfo.title;
                schema.titleEn = catInfo.titleEn || catInfo.title;
            }

            const yr = parseInt(currentYear) || 2025;
            const p = get5YearPeriod(yr);
            const yearLabel = schema.isExcludeSelectedYear ? `${yr - 5}–${yr - 1}` : (schema.isMultiYear ? p.label : `${yr}`);
            document.getElementById('pageMainHeading').innerText = (schema.isMultiYear || schema.isExcludeSelectedYear) ? `Edit Data Tabel ${currentTableCode} (${yearLabel})` : `Edit Data Tabel ${currentTableCode} Tahun ${currentYear}`;

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

            // Check if user previously saved custom data (prioritas database, kemudian localStorage)
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

            if (isMultiYearTable && savedHtml) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = savedHtml;
                const allThs = Array.from(tempDiv.querySelectorAll('thead th'));
                const yrInt = parseInt(currentYear) || 2025;
                const p = get5YearPeriod(yrInt);
                const expectedStartYear = p.start.toString();
                const expectedEndYear = p.end.toString();
                const hasStartYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedStartYear));
                const hasEndYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedEndYear));
                const firstRowTds = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td') : [];
                const isMissingCells = firstRowTds.length > 0 && firstRowTds.length < 6;

                if ((!hasStartYearInHeader || !hasEndYearInHeader || isMissingCells) && currentTableCode !== '8.1.4' && currentTableCode !== '8.1.5' && currentTableCode !== '1.1.10') {
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
                const tdCount = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td').length : 0;
                if (thCount >= 4 && tdCount <= 1) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

            // Reset cache lama jika tabel 8.1.2, 8.1.3, 8.1.4, atau 8.1.5 pernah tersimpan dengan nilai statis dummy
            const tableSource = localStorage.getItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
            const isExcelImport = (tableSource === 'excel');

            if ((currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.1.4' || currentTableCode === '8.1.5') && savedHtml && !isExcelImport) {
                const yrInt = parseInt(currentYear) || 2025;
                const hasAncientDummy = savedHtml.includes('72,40') || savedHtml.includes('123,20') || 
                                       savedHtml.includes('105,20') || savedHtml.includes('112,50') || savedHtml.includes('65,40') ||
                                       savedHtml.includes('Jembatan Permanen') || savedHtml.includes('Trotoar Jalan Utama') || savedHtml.includes('45.280,00') ||
                                       savedHtml.includes('Saluran Drainase Primer') || savedHtml.includes('Saluran Drainase Sekunder') || savedHtml.includes('Gorong-gorong Jalan Kota') ||
                                       savedHtml.includes('32.450,00') || savedHtml.includes('76.820,00') || savedHtml.includes('8.940,00') || savedHtml.includes('118.210,00');
                const isUnenteredYear = (currentTableCode === '8.1.2' && (yrInt <= 2019 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.3' && (yrInt <= 2020 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.4' && (yrInt <= 2020 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.5' && (yrInt <= 2020 || yrInt >= 2027));
                if (hasAncientDummy || isUnenteredYear) {
                    if (!serverDbMetadata || !serverDbMetadata.is_saved) {
                        localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                        savedHtml = null;
                    }
                }
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
                    savedHtml = null;
                }
            }

            // Sanity check untuk Tabel 8.1.1 & tabel sejenis: Jika sel data numerik berisi teks label baris
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
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

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
            tableEl.querySelectorAll('tbody td').forEach(td => {
                const txt = td.innerText.trim();
                if (txt === '-' || txt === '–' || txt === '—') {
                    td.classList.remove('text-left', 'text-right', 'align-top', 'align-bottom');
                    td.classList.add('text-center', 'align-middle');
                    td.style.textAlign = 'center';
                    td.style.verticalAlign = 'middle';
                }
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
                        if (tds[2].innerText.trim() === '-' || tds[2].innerText.trim() === '') {
                            tds[2].innerHTML = '1';
                            tds[2].className = 'py-2 px-2 text-center border border-slate-700 font-bold';
                        }
                    } else if (tds.length >= 2) {
                        if (tds[0].innerText.trim() === '-' || tds[0].innerText.trim() === '') {
                            tds[0].innerHTML = '2';
                            tds[0].className = 'py-2 px-2 text-center border border-slate-700 font-bold';
                        }
                    }
                });
            }

            // Transform cells to editable grid with orange inputs
            transformToEditableGrid(tableEl);
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

        function transformToEditableGrid(tableEl) {
            const rows = tableEl.querySelectorAll('tbody tr');
            const isFinancialTable = (currentOpdCode === '05' || currentTableCode.startsWith('2.4') || currentTableCode.startsWith('2.4.'));

            // Khusus Tabel 1.1.6: Kolom No (1, 2) dan nama kecamatan / nama sungai adalah label tetap, hanya sel Lebar yang diinput
            if (currentTableCode === '1.1.6') {
                rows.forEach(tr => {
                    const cells = tr.querySelectorAll('td');
                    cells.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        const txt = td.innerText.trim();
                        if (txt === '1' || txt === '2' || txt.includes('Batang') || txt.includes('Aur Birugo') || txt.includes('Mandiangin') || txt.includes('Guguk Panjang')) {
                            td.classList.add('font-medium');
                            return;
                        }
                        if (!td.querySelector('.table-edit-input')) {
                            let val = txt;
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="${val}" style="text-align: center; font-weight: 600;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('change', () => persistTableData(false));
                            }
                        }
                    });
                });
                appendActionColumnToEditor(tableEl);
                return;
            }

            // Khusus Tabel 2.3.5: Kolom Unit Kerja adalah label tetap, input pada PNS, PPPK, dan Jumlah
            if (currentTableCode === '2.3.5') {
                rows.forEach(tr => {
                    const cells = tr.querySelectorAll('td');
                    const isTotal = tr.getAttribute('data-total') === 'true';
                    const key = tr.getAttribute('data-key');
                    cells.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        if ((key && idx === 0) || (isTotal && idx === 0)) {
                            td.classList.add('font-semibold');
                            return;
                        }
                        if (!td.querySelector('.table-edit-input')) {
                            let val = td.innerText.trim();
                            td.setAttribute('data-orig-val', val);
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="${val}" style="text-align: center; font-weight: 600;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('change', () => persistTableData(false));
                            }
                        }
                    });
                });
                return;
            }
            // Khusus Tabel 2.3.3 & 2.3.4: Kolom No Golongan dan Nama Pangkat/Golongan adalah label tetap, input pada Laki-laki, Perempuan, dan Jumlah
            if (currentTableCode === '2.3.3' || currentTableCode === '2.3.4') {
                rows.forEach(tr => {
                    const cells = tr.querySelectorAll('td');
                    const isGroup = tr.hasAttribute('data-group');
                    const isTotal = tr.getAttribute('data-total') === 'true';
                    const key = tr.getAttribute('data-key');
                    if (isGroup) {
                        return;
                    }
                    cells.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        if ((key && idx < 2) || (isTotal && idx === 0)) {
                            td.classList.add('font-semibold');
                            return;
                        }
                        if (!td.querySelector('.table-edit-input')) {
                            let val = td.innerText.trim();
                            td.setAttribute('data-orig-val', val);
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="${val}" style="text-align: center; font-weight: 600;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('change', () => persistTableData(false));
                            }
                        }
                    });
                });
                return;
            }

            rows.forEach(tr => {
                const cells = tr.querySelectorAll('td');
                cells.forEach((td, idx) => {
                    if (td.querySelector('.table-edit-input')) return;

                    let val = td.innerText.trim();
                    td.setAttribute('data-orig-val', val);

                    const isNumericOrData = idx > 0 || !isNaN(parseFloat(val.replace(',', '.'))) || val === '-' || val.includes('–');

                    if (isNumericOrData) {
                        if (idx > 0 && isFinancialTable && val !== '-' && val !== '') {
                            val = formatRupiahNumber(val);
                        }
                        const alignStyle = (isFinancialTable && idx > 0) ? 'text-align: right; font-weight: 700;' : '';
                        td.innerHTML = `
                            <div class="flex items-center justify-center p-1">
                                <input type="text" class="table-edit-input" value="${val}" style="${alignStyle}" spellcheck="false" />
                            </div>
                        `;
                        const inputEl = td.querySelector('.table-edit-input');
                        if (inputEl) {
                            if (isFinancialTable && idx > 0) {
                                inputEl.addEventListener('blur', (e) => {
                                    const formatted = formatRupiahNumber(e.target.value);
                                    if (formatted !== e.target.value) {
                                        e.target.value = formatted;
                                    }
                                    persistTableData(false);
                                });
                            }
                            inputEl.addEventListener('change', () => {
                                if (isFinancialTable && idx > 0) {
                                    inputEl.value = formatRupiahNumber(inputEl.value);
                                }
                                persistTableData(false);
                            });
                        }
                    } else {
                        td.classList.add('font-bold', 'text-slate-900');
                    }
                });
            });

            // Tambahkan kolom Aksi dengan tombol hapus per baris
            appendActionColumnToEditor(tableEl);
        }

        function appendActionColumnToEditor(tableEl) {
            if (!tableEl) return;
            const thead = tableEl.querySelector('thead');
            const tbody = tableEl.querySelector('tbody');
            if (!thead || !tbody) return;

            // Pastikan belum ada kolom aksi
            if (thead.querySelector('.col-edit-action')) return;

            const theadRows = thead.querySelectorAll('tr');
            if (theadRows.length === 0) return;

            const headerRowSpan = theadRows.length;
            const firstHeaderTr = theadRows[0];
            const th = document.createElement('th');
            th.className = 'col-edit-action py-2 px-3 border border-slate-700 text-center text-xs font-bold w-14 bg-[#f95a00] text-white';
            th.setAttribute('rowspan', headerRowSpan);
            th.innerText = 'Aksi';
            firstHeaderTr.appendChild(th);

            // Tambahkan tombol hapus di setiap baris data
            const bodyRows = tbody.querySelectorAll('tr');
            bodyRows.forEach(tr => {
                if (tr.querySelector('.col-edit-action')) return;
                const td = document.createElement('td');
                td.className = 'col-edit-action py-1.5 px-2 text-center border border-slate-700 bg-amber-50/50 align-middle';
                td.innerHTML = `
                    <button type="button" onclick="deleteSpecificRow(this)" 
                            class="p-1 px-2 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-300 hover:border-rose-600 rounded transition-all text-xs font-semibold flex items-center justify-center gap-1 shadow-2xs mx-auto cursor-pointer" 
                            title="Hapus baris ini dari tabel">
                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                    </button>
                `;
                tr.appendChild(td);
            });
        }

        function cleanGhostRows(table) {
            if (!table) return;
            if (currentTableCode.startsWith('2.3.')) return;
            const tbody = table.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            let removedAny = false;
            rows.forEach(tr => {
                const tds = Array.from(tr.querySelectorAll('td')).filter(td => !td.classList.contains('col-edit-action'));
                if (tds.length === 0) return;
                const hasMeaningful = tds.some(td => {
                    const input = td.querySelector('.table-edit-input');
                    const val = input ? input.value.trim() : td.innerText.trim();
                    return val !== '' && val !== '-' && val !== '–' && val !== '—';
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

        function deleteBottomRow() {
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            const tbody = tableEl.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            if (rows.length <= 1) {
                alert('Tabel minimal harus memiliki 1 baris data.');
                return;
            }
            if (confirm('Apakah Anda yakin ingin menghapus baris paling bawah dari tabel ini?')) {
                const lastRow = rows[rows.length - 1];
                deleteRowElement(lastRow);
                persistTableData(false);
                showToast('🗑️ Baris paling bawah berhasil dihapus!');
            }
        }

        function deleteSpecificRow(btn) {
            const tr = btn.closest('tr');
            if (!tr) return;
            const tableEl = tr.closest('table');
            const tbody = tableEl ? tableEl.querySelector('tbody') : null;
            const rows = tbody ? tbody.querySelectorAll('tr') : [];
            if (rows.length <= 1) {
                alert('Tabel minimal harus memiliki 1 baris data.');
                return;
            }
            if (confirm('Apakah Anda yakin ingin menghapus baris ini dari tabel?')) {
                deleteRowElement(tr);
                persistTableData(false);
                showToast('🗑️ Baris tabel berhasil dihapus!');
            }
        }

        function deleteRowElement(tr) {
            if (!tr) return;
            const tbody = tr.parentElement;
            if (!tbody) return;
            const allRows = Array.from(tbody.querySelectorAll('tr'));
            const rIdx = allRows.indexOf(tr);
            if (rIdx === -1) return;

            // Deteksi apakah baris ini memiliki sel rowspan > 1
            const rowspanCells = Array.from(tr.querySelectorAll('td[rowspan]')).filter(td => {
                if (td.classList.contains('col-edit-action')) return false;
                return (parseInt(td.getAttribute('rowspan') || '1', 10)) > 1;
            });

            if (rowspanCells.length > 0) {
                // Jika ada baris berikutnya di bawahnya, pindahkan sel rowspan ke baris berikutnya
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
                // Cek apakah baris ini merupakan kelanjutan dari baris atas yang memiliki rowspan
                for (let i = rIdx - 1; i >= 0; i--) {
                    const prevTr = allRows[i];
                    const dist = rIdx - i;
                    const parentRowspanCells = Array.from(prevTr.querySelectorAll('td[rowspan]')).filter(td => {
                        if (td.classList.contains('col-edit-action')) return false;
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

            try {
                const res = await fetch(`{{ route('tabel-opd.api.data') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`);
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

            renderEditTablePage();
            showToast(`Tahun data diubah ke ${currentYear}`);
        }

        async function resetTableOriginal() {
            if (confirm(`Apakah Anda yakin ingin mereset seluruh nilai data Tabel ${currentTableCode} kembali ke data asli resmi BPS?`)) {
                localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);

                try {
                    await fetch('{{ route("tabel-opd.api.delete") }}', {
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

                showToast('🔄 Nilai tabel berhasil dikembalikan ke data awal resmi BPS!');
                setTimeout(() => {
                    window.location.reload();
                }, 400);
            }
        }

        async function persistTableData(redirectAfter = false) {
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            
            // Convert to clean table markup for storage
            const clone = tableEl.cloneNode(true);
            clone.querySelectorAll('.col-edit-action').forEach(el => el.remove());
            cleanGhostRows(clone);

            const cloneInputs = clone.querySelectorAll('.table-edit-input');
            const isFinancialTable = (currentOpdCode === '05' || currentTableCode.startsWith('2.4') || currentTableCode.startsWith('2.4.'));

            cloneInputs.forEach(input => {
                const td = input.closest('td');
                if (td) {
                    let finalVal = input.value.trim();
                    if (isFinancialTable) {
                        finalVal = formatRupiahNumber(finalVal);
                    }
                    td.innerHTML = finalVal;
                    if (isFinancialTable && finalVal !== '-' && finalVal !== '0') {
                        td.classList.remove('text-left', 'text-center');
                        td.classList.add('text-right', 'font-semibold');
                        td.style.textAlign = 'right';
                    }
                }
            });

            // Save to localStorage
            localStorage.setItem(`simonda_table_html_${currentTableCode}_${currentYear}`, clone.innerHTML);
            localStorage.setItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '1');

            // Simpan perubahan ke Database MySQL
            try {
                const rowsData = {};
                if (currentTableCode === '1.1.6') {
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inp = tr.querySelector('.table-edit-input');
                        if (inp) {
                            if (text.includes('batang tambuo')) {
                                rowsData[currentYear]['batang_tambuo'] = inp.value.trim();
                            } else if (text.includes('batang sianok')) {
                                rowsData[currentYear]['batang_sianok'] = inp.value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '8.1.4') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (text.includes('guguk') && inputs.length >= 2) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['guguk_panjang_unit'] = inputs[0].value.trim();
                            rowsData[currentYear]['guguk_panjang_panjang'] = inputs[1].value.trim();
                        } else if (text.includes('mandiangin') && inputs.length >= 2) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['mandiangin_koto_selayan_unit'] = inputs[0].value.trim();
                            rowsData[currentYear]['mandiangin_koto_selayan_panjang'] = inputs[1].value.trim();
                        } else if (text.includes('aur birugo') && inputs.length >= 2) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['aur_birugo_tigo_baleh_unit'] = inputs[0].value.trim();
                            rowsData[currentYear]['aur_birugo_tigo_baleh_panjang'] = inputs[1].value.trim();
                        } else if (inputs.length >= 2) {
                            const m = tr.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) {
                                const y = parseInt(m[1], 10);
                                if (!rowsData[y]) rowsData[y] = {};
                                rowsData[y]['total_unit'] = inputs[0].value.trim();
                                rowsData[y]['total_panjang'] = inputs[1].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '8.1.5') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (text.includes('guguk') && inputs.length >= 1) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['guguk_panjang'] = inputs[0].value.trim();
                        } else if (text.includes('mandiangin') && inputs.length >= 1) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['mandiangin_koto_selayan'] = inputs[0].value.trim();
                        } else if (text.includes('aur birugo') && inputs.length >= 1) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['aur_birugo_tigo_baleh'] = inputs[0].value.trim();
                        } else if (inputs.length >= 1) {
                            const m = tr.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) {
                                const y = parseInt(m[1], 10);
                                if (!rowsData[y]) rowsData[y] = {};
                                rowsData[y]['total'] = inputs[0].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '1.1.10') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (text.includes('guguk') && inputs.length >= 4) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['gp_tt'] = inputs[0].value.trim();
                            rowsData[currentYear]['gp_btt'] = inputs[1].value.trim();
                            rowsData[currentYear]['gp_cmp'] = inputs[2].value.trim();
                            rowsData[currentYear]['gp_jml'] = inputs[3].value.trim();
                        } else if (text.includes('mandiangin') && inputs.length >= 4) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['mks_tt'] = inputs[0].value.trim();
                            rowsData[currentYear]['mks_btt'] = inputs[1].value.trim();
                            rowsData[currentYear]['mks_cmp'] = inputs[2].value.trim();
                            rowsData[currentYear]['mks_jml'] = inputs[3].value.trim();
                        } else if (text.includes('aur birugo') && inputs.length >= 4) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['abt_tt'] = inputs[0].value.trim();
                            rowsData[currentYear]['abt_btt'] = inputs[1].value.trim();
                            rowsData[currentYear]['abt_cmp'] = inputs[2].value.trim();
                            rowsData[currentYear]['abt_jml'] = inputs[3].value.trim();
                        } else if (inputs.length >= 4) {
                            const m = tr.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) {
                                const y = parseInt(m[1], 10);
                                if (!rowsData[y]) rowsData[y] = {};
                                rowsData[y]['total_tt'] = inputs[0].value.trim();
                                rowsData[y]['total_btt'] = inputs[1].value.trim();
                                rowsData[y]['total_cmp'] = inputs[2].value.trim();
                                rowsData[y]['total_jml'] = inputs[3].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '1.1.8') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    const keys = ['hak_milik', 'hak_guna_bangunan', 'hak_pakai', 'hak_pengelolaan', 'hak_wakaf', 'total'];
                    if (!rowsData[currentYear]) rowsData[currentYear] = {};
                    bodyRows.forEach((tr, trIdx) => {
                        const inp = tr.querySelector('.table-edit-input');
                        if (inp && keys[trIdx]) {
                            rowsData[currentYear][keys[trIdx]] = inp.value.trim();
                        }
                    });
                } else if (currentTableCode === '1.1.9') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    const keys = ['jual_beli', 'pewarisan', 'hibah', 'tukar_menukar', 'pembagian_hak_bersama', 'lelang', 'lainnya', 'total'];
                    if (!rowsData[currentYear]) rowsData[currentYear] = {};
                    bodyRows.forEach((tr, trIdx) => {
                        const inp = tr.querySelector('.table-edit-input');
                        if (inp && keys[trIdx]) {
                            rowsData[currentYear][keys[trIdx]] = inp.value.trim();
                        }
                    });
                } else if (currentTableCode === '2.3.1' || currentTableCode === '2.3.2') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    const rowKeys = (currentTableCode === '2.3.2') ? [
                        'sd', 'smp', 'sma', 'di', 'dii', 'diii', 'div', 's1', 's2', 's3'
                    ] : [
                        'jpt_utama', 'jpt_madya', 'jpt_pratama',
                        'administrator', 'pengawas', 'eselon5',
                        'dosen', 'guru', 'medis', 'teknis', 'pelaksana'
                    ];
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 9 && rowKeys[trIdx]) {
                            const k = rowKeys[trIdx];
                            rowsData[currentYear][`${k}_pns_l`] = inputs[0].value.trim();
                            rowsData[currentYear][`${k}_pns_p`] = inputs[1].value.trim();
                            rowsData[currentYear][`${k}_pns_jml`] = inputs[2].value.trim();
                            rowsData[currentYear][`${k}_pppk_l`] = inputs[3].value.trim();
                            rowsData[currentYear][`${k}_pppk_p`] = inputs[4].value.trim();
                            rowsData[currentYear][`${k}_pppk_jml`] = inputs[5].value.trim();
                            rowsData[currentYear][`${k}_total_l`] = inputs[6].value.trim();
                            rowsData[currentYear][`${k}_total_p`] = inputs[7].value.trim();
                            rowsData[currentYear][`${k}_total_jml`] = inputs[8].value.trim();
                        } else if (inputs.length >= 9 && tr.innerText.toLowerCase().includes('jumlah')) {
                            rowsData[currentYear]['total_pns_l'] = inputs[0].value.trim();
                            rowsData[currentYear]['total_pns_p'] = inputs[1].value.trim();
                            rowsData[currentYear]['total_pns_jml'] = inputs[2].value.trim();
                            rowsData[currentYear]['total_pppk_l'] = inputs[3].value.trim();
                            rowsData[currentYear]['total_pppk_p'] = inputs[4].value.trim();
                            rowsData[currentYear]['total_pppk_jml'] = inputs[5].value.trim();
                            rowsData[currentYear]['total_total_l'] = inputs[6].value.trim();
                            rowsData[currentYear]['total_total_p'] = inputs[7].value.trim();
                            rowsData[currentYear]['total_total_jml'] = inputs[8].value.trim();
                        }
                    });
                } else if (currentTableCode === '2.3.5') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const key = tr.getAttribute('data-key');
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (key && inputs.length >= 2) {
                            rowsData[currentYear][`${key}_pns`] = inputs[0].value.trim();
                            rowsData[currentYear][`${key}_pppk`] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear][`${key}_jml`] = inputs[2].value.trim();
                            } else {
                                const nPns = parseFloat(inputs[0].value.trim().replace(',', '.')) || 0;
                                const nPppk = parseFloat(inputs[1].value.trim().replace(',', '.')) || 0;
                                rowsData[currentYear][`${key}_jml`] = (nPns + nPppk).toString();
                            }
                        } else if (tr.getAttribute('data-total') === 'true' && inputs.length >= 2) {
                            rowsData[currentYear]['total_pns'] = inputs[0].value.trim();
                            rowsData[currentYear]['total_pppk'] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear]['total_jml'] = inputs[2].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '2.3.3' || currentTableCode === '2.3.4') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const key = tr.getAttribute('data-key');
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (key && inputs.length >= 2) {
                            rowsData[currentYear][`${key}_l`] = inputs[0].value.trim();
                            rowsData[currentYear][`${key}_p`] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear][`${key}_jml`] = inputs[2].value.trim();
                            } else {
                                const nL = parseFloat(inputs[0].value.trim().replace(',', '.')) || 0;
                                const nP = parseFloat(inputs[1].value.trim().replace(',', '.')) || 0;
                                rowsData[currentYear][`${key}_jml`] = (nL + nP).toString();
                            }
                        } else if (tr.getAttribute('data-total') === 'true' && inputs.length >= 2) {
                            rowsData[currentYear]['total_l'] = inputs[0].value.trim();
                            rowsData[currentYear]['total_p'] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear]['total_jml'] = inputs[2].value.trim();
                            }
                        }
                    });
                } else {
                    const theadThs = tableEl.querySelectorAll('thead tr:first-child th');
                    const colYears = [];
                    theadThs.forEach((th, idx) => {
                        const m = th.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m) colYears.push({ colIdx: idx, year: parseInt(m[1], 10) });
                    });

                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        let rowKey = null;
                        if (currentTableCode === '2.2.5') {
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
                            rowKey = dprdKeys[trIdx] || null;
                        } else if (currentTableCode === '8.1.2') {
                            rowKey = trIdx === 0 ? 'aspal' : (trIdx === 1 ? 'kerikil' : (trIdx === 2 ? 'tanah' : (trIdx === 3 ? 'lainnya' : 'total')));
                        } else if (currentTableCode === '8.1.3') {
                            rowKey = trIdx === 0 ? 'baik' : (trIdx === 1 ? 'sedang' : (trIdx === 2 ? 'rusak' : (trIdx === 3 ? 'rusak_berat' : 'total')));
                        } else {
                            rowKey = trIdx === 0 ? 'negara' : (trIdx === 1 ? 'provinsi' : (trIdx === 2 ? 'kota' : 'total'));
                        }
                        if (rowKey) {
                            inputs.forEach((inp, inpIdx) => {
                                const offset = 4;
                                const y = (colYears[inpIdx] ? colYears[inpIdx].year : (parseInt(currentYear) - offset + inpIdx));
                                if (!rowsData[y]) rowsData[y] = {};
                                rowsData[y][rowKey] = inp.value.trim();
                            });
                        }
                    });
                }

                await fetch('{{ route("tabel-opd.api.save") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        table_html: clone.innerHTML,
                        title_id: document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText : '',
                        title_en: document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText : '',
                        source: document.getElementById('tableSourceContent') ? document.getElementById('tableSourceContent').innerHTML : '',
                        note: document.getElementById('tableNoteContent') ? document.getElementById('tableNoteContent').innerHTML : '',
                        source_type: 'manual',
                        rows_data: rowsData
                    })
                });
            } catch(e) {
                console.warn('Gagal menyimpan ke database:', e);
            }

            if (redirectAfter) {
                showToast('✅ Data tabel berhasil disimpan ke Database! Mengalihkan ke tabel...');
                setTimeout(() => {
                    let url = `{{ route('tabel-opd') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}&saved=1`;
                    if (currentType) url += `&type=${currentType}`;
                    window.location.href = url;
                }, 500);
            } else {
                showToast('💾 Nilai data langsung tersimpan ke Database!');
            }
        }

        async function saveAndReturn() {
            await persistTableData(true);
        }

        function backToTableView() {
            let url = `{{ route('tabel-opd') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`;
            if (currentType) url += `&type=${currentType}`;
            window.location.href = url;
        }

        function downloadEditExcelTemplate() {
            try {
                if (typeof XLSX === 'undefined') {
                    alert('Pustaka Excel belum siap. Silakan coba sesaat lagi.');
                    return;
                }

                const yr = parseInt(currentYear) || 2025;
                const opdName = (typeof getAgencyName === 'function') ? getAgencyName(currentOpdCode) : 'OPD';
                const catInfo = (typeof getCatalogTableInfo === 'function') ? getCatalogTableInfo(currentTableCode, currentOpdCode, currentType) : null;
                let titleId = (document.getElementById('metaTableTitleId') && document.getElementById('metaTableTitleId').innerText.trim())
                    ? document.getElementById('metaTableTitleId').innerText.trim()
                    : (catInfo && catInfo.title ? catInfo.title : `Tabel ${currentTableCode}`);
                let titleEn = (document.getElementById('metaTableTitleEn') && document.getElementById('metaTableTitleEn').innerText.trim())
                    ? document.getElementById('metaTableTitleEn').innerText.trim()
                    : (catInfo && catInfo.titleEn ? catInfo.titleEn : (catInfo && catInfo.title ? catInfo.title : `Table ${currentTableCode}`));

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

                const dataCenterStyle = {
                    fill: { fgColor: { rgb: 'FFFFFF' } },
                    font: { name: 'Calibri', sz: 9.5, color: { rgb: '000000' } },
                    alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
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
                setCell(r, 0, `Tabel ${currentTableCode}`, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                setCell(r, 1, titleId, { font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: '000000' } } });
                r++;
                setCell(r, 0, 'Table', { font: { name: 'Calibri', sz: 10, bold: true, italic: true, color: { rgb: '000000' } } });
                setCell(r, 1, titleEn, { font: { name: 'Calibri', sz: 10, italic: true, color: { rgb: '000000' } } });
                r += 2;

                let maxCol = 2;

                if (currentTableCode === '2.3.3') {
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

                    // Header Baris 3: Peach Penomoran Kolom
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

                    rankGroups.forEach(grp => {
                        setCell(r, 0, `${grp.groupId} / ${grp.groupEn}`, headerPeachStyle);
                        setCell(r, 1, '', headerPeachStyle);
                        merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                        setCell(r, 2, '', headerPeachStyle);
                        setCell(r, 3, '', headerPeachStyle);
                        setCell(r, 4, '', headerPeachStyle);
                        r++;

                        grp.ranks.forEach(rk => {
                            setCell(r, 0, rk.noGol, dataCenterStyle);
                            setCell(r, 1, `${rk.labelId} / ${rk.labelEn}`, dataCellStyle);
                            setCell(r, 2, '', dataCenterStyle);
                            setCell(r, 3, '', dataCenterStyle);
                            setCell(r, 4, '', totalCenterStyle);
                            r++;
                        });
                    });

                    // Row Total
                    setCell(r, 0, 'Jumlah / Total', headerPeachStyle);
                    setCell(r, 1, '', headerPeachStyle);
                    merges.push({ s: { r: r, c: 0 }, e: { r: r, c: 1 } });
                    setCell(r, 2, '-', totalCenterStyle);
                    setCell(r, 3, '-', totalCenterStyle);
                    setCell(r, 4, '-', totalCenterStyle);
                    r++;

                    maxCol = 5;
                    ws['!cols'] = [
                        { wch: 14 },
                        { wch: 44 },
                        { wch: 16 },
                        { wch: 16 },
                        { wch: 18 }
                    ];
                } else if (currentTableCode === '2.3.4') {
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

                    const yr = parseInt(currentYear) || 2025;
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

                    maxCol = 5;
                    ws['!cols'] = [
                        { wch: 14 },
                        { wch: 44 },
                        { wch: 16 },
                        { wch: 16 },
                        { wch: 18 }
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

                    maxCol = 4;
                    ws['!cols'] = [
                        { wch: 65 }, // Unit Kerja
                        { wch: 18 }, // PNS
                        { wch: 18 }, // PPPK
                        { wch: 20 }  // Total
                    ];
                } else {
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tr');
                        trs.forEach((tr, trIdx) => {
                            const isHeader = tr.closest('thead') !== null;
                            const isSub = isHeader && trIdx > 0;
                            const cells = tr.querySelectorAll('th, td');
                            let cIdx = 0;
                            cells.forEach(cell => {
                                const val = cell.querySelector('input') ? cell.querySelector('input').value : cell.innerText.trim();
                                const style = isHeader ? (isSub ? headerPeachStyle : headerOrangeStyle) : (cell.classList.contains('font-bold') ? totalCenterStyle : dataCenterStyle);
                                setCell(r, cIdx, val, style);
                                cIdx++;
                            });
                            if (cIdx > maxCol) maxCol = cIdx;
                            r++;
                        });
                    }
                }

                // Footer
                r++;
                setCell(r, 0, `Catatan / Note: Data per-31 Desember ${yr}`, { font: { name: 'Calibri', sz: 9, italic: true } });
                r++;
                setCell(r, 0, `Sumber / Source: ${opdName} Kota Bukittinggi`, { font: { name: 'Calibri', sz: 9, italic: true } });

                ws['!merges'] = merges;
                ws['!ref'] = XLSX.utils.encode_range({
                    s: { r: 0, c: 0 },
                    e: { r: r + 1, c: Math.max(maxCol - 1, 1) }
                });

                XLSX.utils.book_append_sheet(wb, ws, `Template_${currentTableCode}`.substring(0, 31));
                XLSX.writeFile(wb, `Template_Tabel_${currentTableCode.replace(/\./g, '_')}_${currentYear}.xlsx`);
                showToast(`📥 Berkas template Excel Tabel ${currentTableCode} Tahun ${currentYear} berhasil diunduh!`);
            } catch (err) {
                console.error('Error generating template in edit view:', err);
                alert('Gagal mengunduh template Excel: ' + (err.message || err));
            }
        }

        function handleEditExcelImport(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (!file) return;

            const reader = new FileReader();
            reader.onload = async function(e) {
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

                    let dataRows = cleanRows.slice(headerIdx + 1);
                    // Skip numbering row (e.g. (1), (2), (3) or -1, -2, -3)
                    if (dataRows.length > 0) {
                        const firstRow = dataRows[0] || [];
                        const nonEmpties = firstRow.filter(c => c !== null && c !== undefined && c.toString().trim() !== '');
                        const isNumRow = nonEmpties.length >= 2 && nonEmpties.every(c => {
                            const s = c.toString().trim();
                            return /^\s*\(\s*\d+\s*\)\s*$/.test(s) || /^\s*-\s*\d+\s*-?\s*$/.test(s) || /^\s*\d+\s*$/.test(s) || s.toLowerCase() === 'no';
                        }) && nonEmpties.some(c => /^\s*\(\s*\d+\s*\)\s*$/.test(c) || /^\s*-\s*\d+\s*-?\s*$/.test(c));
                        if (isNumRow) {
                            dataRows = dataRows.slice(1);
                        }
                    }

                    const tableEl = document.getElementById('dataDisplayTable');
                    const tbody = tableEl.querySelector('tbody');
                    const trs = tbody.querySelectorAll('tr');

                    // Check if table has year-based header columns
                    const theadThs = tableEl.querySelectorAll('thead tr:first-child th');
                    const colYears = [];
                    theadThs.forEach((th, idx) => {
                        const m = th.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m) colYears.push({ colIdx: idx, year: parseInt(m[1], 10) });
                    });

                    // Map Excel header row years to column indices
                    const excelYearColMap = {};
                    let hasYearHeadersInExcel = false;
                    const excelHeaderRow = cleanRows[headerIdx] || [];
                    excelHeaderRow.forEach((cVal, cIdx) => {
                        const m = (cVal || '').toString().match(/\b(20\d{2}|19\d{2})\b/);
                        if (m) {
                            excelYearColMap[parseInt(m[1], 10)] = cIdx;
                            hasYearHeadersInExcel = true;
                        }
                    });

                    let filledCount = 0;

                    if (currentTableCode === '2.3.3') {
                        const rankGroups = [
                            {
                                groupId: 'Golongan I',
                                ranks: [
                                    { key: '1_ia', match: ['1. i / a', '1. i/a', 'i / a', 'i/a', 'juru muda', 'junior clerk'] },
                                    { key: '2_ib', match: ['2. i / b', '2. i/b', 'i / b', 'i/b', 'juru muda tingkat i', 'juru muda tk i', 'first class junior clerk'] },
                                    { key: '3_ic', match: ['3. i / c', '3. i/c', 'i / c', 'i/c', 'juru', 'clerk'] },
                                    { key: '4_id', match: ['4. i / d', '4. i/d', 'i / d', 'i/d', 'juru tingkat i', 'juru tk i', 'first class clerk'] }
                                ]
                            },
                            {
                                groupId: 'Golongan II',
                                ranks: [
                                    { key: '5_iia', match: ['5. ii / a', '5. ii/a', 'ii / a', 'ii/a', 'pengatur muda', 'junior supervisor'] },
                                    { key: '6_iib', match: ['6. ii / b', '6. ii/b', 'ii / b', 'ii/b', 'pengatur muda tingkat i', 'pengatur muda tk i', 'first class junior supervisor'] },
                                    { key: '7_iic', match: ['7. ii / c', '7. ii/c', 'ii / c', 'ii/c', 'pengatur', 'supervisor'] },
                                    { key: '8_iid', match: ['8. ii / d', '8. ii/d', 'ii / d', 'ii/d', 'pengatur tingkat i', 'pengatur tk i', 'first class supervisor'] }
                                ]
                            },
                            {
                                groupId: 'Golongan III',
                                ranks: [
                                    { key: '9_iiia', match: ['9. iii / a', '9. iii/a', 'iii / a', 'iii/a', 'penata muda', 'junior superintendent'] },
                                    { key: '10_iiib', match: ['10. iii / b', '10. iii/b', 'iii / b', 'iii/b', 'penata muda tingkat i', 'penata muda tk i', 'first class junior superintendent'] },
                                    { key: '11_iiic', match: ['11. iii / c', '11. iii/c', 'iii / c', 'iii/c', 'penata', 'superintendent'] },
                                    { key: '12_iiid', match: ['12. iii / d', '12. iii/d', 'iii / d', 'iii/d', 'penata tingkat i', 'penata tk i', 'first class superintendent'] }
                                ]
                            },
                            {
                                groupId: 'Golongan IV',
                                ranks: [
                                    { key: '13_iva', match: ['13. iv / a', '13. iv/a', 'iv / a', 'iv/a', 'pembina', 'administrator'] },
                                    { key: '14_ivb', match: ['14. iv / b', '14. iv/b', 'iv / b', 'iv/b', 'pembina tingkat i', 'pembina tk i', 'first class administrator'] },
                                    { key: '15_ivc', match: ['15. iv / c', '15. iv/c', 'iv / c', 'iv/c', 'pembina utama muda', 'junior administrator'] },
                                    { key: '16_ivd', match: ['16. iv / d', '16. iv/d', 'iv / d', 'iv/d', 'pembina utama madya', 'middle administrator'] },
                                    { key: '17_ive', match: ['17. iv / e', '17. iv/e', 'iv / e', 'iv/e', 'pembina utama', 'senior administrator'] }
                                ]
                            }
                        ];

                        const extractedRanks = {};
                        let curGroupIdx = -1;
                        let rkIdxInGroup = 0;

                        dataRows.forEach(row => {
                            const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase();
                            if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan') || rowStr.startsWith('note') || rowStr.startsWith('source')) return;

                            if (/golongan\s*i\b/i.test(rowStr) && !/golongan\s*ii/i.test(rowStr) && !/golongan\s*iii/i.test(rowStr) && !/golongan\s*iv/i.test(rowStr)) {
                                curGroupIdx = 0; rkIdxInGroup = 0; return;
                            } else if (/golongan\s*ii\b/i.test(rowStr) && !/golongan\s*iii/i.test(rowStr)) {
                                curGroupIdx = 1; rkIdxInGroup = 0; return;
                            } else if (/golongan\s*iii\b/i.test(rowStr)) {
                                curGroupIdx = 2; rkIdxInGroup = 0; return;
                            } else if (/golongan\s*iv\b/i.test(rowStr)) {
                                curGroupIdx = 3; rkIdxInGroup = 0; return;
                            }

                            if (/jumlah\s*\/\s*total/i.test(rowStr) || (rowStr.includes('jumlah') && rowStr.includes('total'))) return;

                            let matchedKey = null;
                            if (curGroupIdx >= 0 && curGroupIdx < rankGroups.length) {
                                const grp = rankGroups[curGroupIdx];
                                const candRanks = [...grp.ranks].sort((a, b) => {
                                    const maxA = Math.max(...a.match.map(m => m.length));
                                    const maxB = Math.max(...b.match.map(m => m.length));
                                    return maxB - maxA;
                                });
                                for (let rk of candRanks) {
                                    if (rk.match.some(m => rowStr.includes(m))) {
                                        matchedKey = rk.key;
                                        break;
                                    }
                                }
                                if (!matchedKey && rkIdxInGroup < grp.ranks.length) {
                                    matchedKey = grp.ranks[rkIdxInGroup].key;
                                }
                                rkIdxInGroup++;
                            }

                            if (matchedKey) {
                                const nums = row.filter(c => /^-?\d+([.,]\d+)?$/.test((c || '').toString().trim()));
                                const lVal = nums[0] || '0';
                                const pVal = nums[1] || '0';
                                const nL = parseFloat(lVal.replace(',', '.')) || 0;
                                const nP = parseFloat(pVal.replace(',', '.')) || 0;
                                const jmlVal = nums[2] || (nL + nP).toString();
                                extractedRanks[matchedKey] = { l: lVal, p: pVal, jml: jmlVal };
                            }
                        });

                        trs.forEach(tr => {
                            const key = tr.getAttribute('data-key');
                            if (key && extractedRanks[key]) {
                                const inputs = tr.querySelectorAll('.table-edit-input');
                                if (inputs.length >= 2) {
                                    inputs[0].value = extractedRanks[key].l;
                                    inputs[0].classList.add('bg-amber-100');
                                    inputs[1].value = extractedRanks[key].p;
                                    inputs[1].classList.add('bg-amber-100');
                                    if (inputs.length >= 3) {
                                        inputs[2].value = extractedRanks[key].jml;
                                        inputs[2].classList.add('bg-amber-100');
                                    }
                                    filledCount++;
                                }
                            }
                        });
                    } else if (currentTableCode === '2.3.5') {
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


                        const extractedUnits = {};

                        dataRows.forEach(row => {
                            const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase().replace(/\s+/g, ' ');
                            if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan') || rowStr.startsWith('note') || rowStr.startsWith('source')) return;

                            if (/jumlah\s*\/\s*total/i.test(rowStr) || (rowStr.includes('jumlah') && rowStr.includes('total'))) return;

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
                                extractedUnits[matchedKey] = { pns: pnsVal, pppk: pppkVal, jml: jmlVal };
                            }
                        });

                        trs.forEach(tr => {
                            const key = tr.getAttribute('data-key');
                            if (key && extractedUnits[key]) {
                                const inputs = tr.querySelectorAll('.table-edit-input');
                                if (inputs.length >= 2) {
                                    inputs[0].value = extractedUnits[key].pns;
                                    inputs[0].classList.add('bg-amber-100');
                                    inputs[1].value = extractedUnits[key].pppk;
                                    inputs[1].classList.add('bg-amber-100');
                                    if (inputs.length >= 3) {
                                        inputs[2].value = extractedUnits[key].jml;
                                        inputs[2].classList.add('bg-amber-100');
                                    }
                                    filledCount++;
                                }
                            }
                        });
                    } else if (currentTableCode === '2.3.4') {
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

                        const extractedRanks = {};

                        dataRows.forEach(row => {
                            const rowStr = row.map(c => (c !== null && c !== undefined ? c.toString().trim() : '')).join(' ').toLowerCase().replace(/\s+/g, ' ');
                            if (!rowStr || rowStr.startsWith('sumber') || rowStr.startsWith('catatan') || rowStr.startsWith('note') || rowStr.startsWith('source')) return;

                            if (/jumlah\s*\/\s*total/i.test(rowStr) || (rowStr.includes('jumlah') && rowStr.includes('total'))) return;

                            let matchedKey = null;
                            for (const m of matchPriority234) {
                                if (m.regex.test(rowStr)) {
                                    matchedKey = m.key;
                                    break;
                                }
                            }

                            if (matchedKey) {
                                const nums = row.filter(c => /^-?\d+([.,]\d+)?$/.test((c || '').toString().trim()));
                                const lVal = nums[0] !== undefined ? nums[0] : '0';
                                const pVal = nums[1] !== undefined ? nums[1] : '0';
                                const nL = parseFloat(lVal.replace(',', '.')) || 0;
                                const nP = parseFloat(pVal.replace(',', '.')) || 0;
                                const jmlVal = nums[2] !== undefined ? nums[2] : (nL + nP).toString();
                                extractedRanks[matchedKey] = { l: lVal, p: pVal, jml: jmlVal };
                            }
                        });

                        trs.forEach(tr => {
                            const key = tr.getAttribute('data-key');
                            if (key && extractedRanks[key]) {
                                const inputs = tr.querySelectorAll('.table-edit-input');
                                if (inputs.length >= 2) {
                                    inputs[0].value = extractedRanks[key].l;
                                    inputs[0].classList.add('bg-amber-100');
                                    inputs[1].value = extractedRanks[key].p;
                                    inputs[1].classList.add('bg-amber-100');
                                    if (inputs.length >= 3) {
                                        inputs[2].value = extractedRanks[key].jml;
                                        inputs[2].classList.add('bg-amber-100');
                                    }
                                    filledCount++;
                                }
                            }
                        });
                    } else if (currentTableCode === '2.3.1' || currentTableCode === '2.3.2') {
                        const is232 = (currentTableCode === '2.3.2');
                        const rowDefs231 = [
                            { key: 'jpt_utama',     regex: /\b(jpt\s*utama|tinggi\s*utama|senior\s*executives)\b/i },
                            { key: 'jpt_madya',     regex: /\b(jpt\s*madya|tinggi\s*madya|middle\s*executives)\b/i },
                            { key: 'jpt_pratama',   regex: /\b(jpt\s*pratama|tinggi\s*pratama|junior\s*executives|eselon\s*(ii|2))\b/i },
                            { key: 'administrator', regex: /\b(administrator|eselon\s*(iii|3))\b/i },
                            { key: 'pengawas',      regex: /\b(pengawas|supervisor|eselon\s*(iv|4))\b/i },
                            { key: 'eselon5',       regex: /\b(eselon\s*(v|5)|5th\s*echelon)\b/i },
                            { key: 'dosen',         regex: /\b(dosen|lecturer)\b/i },
                            { key: 'guru',          regex: /\b(guru|teacher)\b/i },
                            { key: 'medis',         regex: /\b(medis|kesehatan|medical)\b/i },
                            { key: 'teknis',        regex: /\b(teknis|technical)\b/i },
                            { key: 'pelaksana',     regex: /\b(pelaksana|umum|general\s*functional)\b/i }
                        ];

                        const rowDefs232 = [
                            { key: 'div',  regex: /\b(diploma\s*(iv|4)|akta\s*(iv|4)|d[\s\-_.]*(iv|4))\b/i },
                            { key: 'diii', regex: /\b(diploma\s*(iii|3)|akta\s*(iii|3)|d[\s\-_.]*(iii|3))\b/i },
                            { key: 'dii',  regex: /\b(diploma\s*(ii|2)|akta\s*(ii|2)|d[\s\-_.]*(ii|2))\b/i },
                            { key: 'di',   regex: /\b(diploma\s*(i|1)|akta\s*(i|1)|d[\s\-_.]*(i|1))\b/i },
                            { key: 's3',   regex: /\b(s[\s\-_.]*3|doktor|ph\.?d|post\s*graduate)\b/i },
                            { key: 's2',   regex: /\b(s[\s\-_.]*2|pasca\s*sarjana|magister|master)\b/i },
                            { key: 's1',   regex: /\b(s[\s\-_.]*1|sarjana|under\s*graduate|bachelor)\b/i },
                            { key: 'sd',   regex: /\b(sd|sekolah\s*dasar|primary\s*school)\b/i },
                            { key: 'smp',  regex: /\b(smp|menengah\s*pertama|junior\s*high)\b/i },
                            { key: 'sma',  regex: /\b(sma|smk|menengah\s*atas|senior\s*high)\b/i }
                        ];

                        const cleanVal = (val) => {
                            if (val === null || val === undefined) return '-';
                            const s = val.toString().trim();
                            if (!s || s === '–' || s === '—') return '-';
                            return s;
                        };

                        const extractedMap = {};
                        let extractedTotal = null;

                        cleanRows.forEach(row => {
                            if (!Array.isArray(row)) return;
                            const firstCell = (row[0] || '').toString().trim();
                            const firstCellLower = firstCell.toLowerCase().replace(/\s+/g, ' ');
                            if (!firstCellLower || firstCellLower.startsWith('sumber') || firstCellLower.startsWith('catatan') || firstCellLower.startsWith('note') || firstCellLower.startsWith('source')) return;

                            if (firstCellLower.includes('jumlah') || firstCellLower.includes('total')) {
                                extractedTotal = [];
                                for (let c = 1; c <= 9; c++) {
                                    extractedTotal.push(cleanVal(row[c]));
                                }
                                return;
                            }

                            let matchedKey = null;
                            if (is232) {
                                for (const rd of rowDefs232) {
                                    if (rd.regex.test(firstCellLower)) {
                                        matchedKey = rd.key;
                                        break;
                                    }
                                }
                            } else {
                                for (const rd of rowDefs231) {
                                    if (rd.regex.test(firstCellLower)) {
                                        matchedKey = rd.key;
                                        break;
                                    }
                                }
                            }

                            if (matchedKey) {
                                const pnsL = cleanVal(row[1]);
                                const pnsP = cleanVal(row[2]);
                                let pnsJml = cleanVal(row[3]);
                                const pppkL = cleanVal(row[4]);
                                const pppkP = cleanVal(row[5]);
                                let pppkJml = cleanVal(row[6]);
                                let totL = cleanVal(row[7]);
                                let totP = cleanVal(row[8]);
                                let totJml = cleanVal(row[9]);

                                const nPL = parseFloat(pnsL.replace(',', '.')) || 0;
                                const nPP = parseFloat(pnsP.replace(',', '.')) || 0;
                                const nPKL = parseFloat(pppkL.replace(',', '.')) || 0;
                                const nPKP = parseFloat(pppkP.replace(',', '.')) || 0;

                                if (pnsJml === '-' && (pnsL !== '-' || pnsP !== '-')) {
                                    pnsJml = (nPL + nPP).toString();
                                }
                                if (pppkJml === '-' && (pppkL !== '-' || pppkP !== '-')) {
                                    pppkJml = (nPKL + nPKP).toString();
                                }
                                if (totL === '-' && (pnsL !== '-' || pppkL !== '-')) {
                                    totL = (nPL + nPKL).toString();
                                }
                                if (totP === '-' && (pnsP !== '-' || pppkP !== '-')) {
                                    totP = (nPP + nPKP).toString();
                                }
                                if (totJml === '-' && (pnsJml !== '-' || pppkJml !== '-')) {
                                    const nPJ = parseFloat(pnsJml.replace(',', '.')) || 0;
                                    const nPKJ = parseFloat(pppkJml.replace(',', '.')) || 0;
                                    totJml = (nPJ + nPKJ).toString();
                                }

                                extractedMap[matchedKey] = [
                                    pnsL, pnsP, pnsJml,
                                    pppkL, pppkP, pppkJml,
                                    totL, totP, totJml
                                ];
                            }
                        });

                        trs.forEach(tr => {
                            const key = tr.getAttribute('data-key');
                            const inputs = tr.querySelectorAll('.table-edit-input');
                            if (key && extractedMap[key]) {
                                const vals = extractedMap[key];
                                inputs.forEach((inp, i) => {
                                    if (vals[i] !== undefined) {
                                        inp.value = vals[i];
                                        inp.classList.add('bg-amber-100');
                                    }
                                });
                                filledCount++;
                            } else if (tr.getAttribute('data-total') === 'true' && extractedTotal) {
                                inputs.forEach((inp, i) => {
                                    if (extractedTotal[i] !== undefined) {
                                        inp.value = extractedTotal[i];
                                        inp.classList.add('bg-amber-100');
                                    }
                                });
                                filledCount++;
                            }
                        });
                    } else {
                    trs.forEach((tr, rowIdx) => {
                        const excelRow = dataRows[rowIdx];
                        if (!excelRow) return;

                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length > 0) {
                            if (colYears.length === inputs.length && hasYearHeadersInExcel) {
                                // Match each input column by Year!
                                inputs.forEach((inp, inpIdx) => {
                                    const targetYear = colYears[inpIdx].year;
                                    if (excelYearColMap[targetYear] !== undefined) {
                                        const raw = excelRow[excelYearColMap[targetYear]];
                                        const val = (raw !== undefined && raw !== null && raw.toString().trim() !== '') ? raw.toString().trim() : '-';
                                        inp.value = val;
                                    } else {
                                        // Tahun yang belum ada di Excel di-strip (-)
                                        inp.value = '-';
                                    }
                                    inp.classList.add('bg-amber-100');
                                    filledCount++;
                                });
                            } else {
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
                        }
                    });
                    }

                    // Simpan langsung ke database MySQL!
                    await persistTableData(false);
                    showToast(`✅ Berhasil mengimpor nilai dari ${file.name} & langsung tersimpan ke Database!`);
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
