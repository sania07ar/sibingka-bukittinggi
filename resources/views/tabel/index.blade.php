<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data Statistik Sektoral - SiAngka Kota Bukittinggi</title>
    
    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    
    <!-- Google Fonts: Inter (Standar Formal Pemerintahan & Publikasi Statistik) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..900;1,14..32,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- xlsx-js-style for Styled Excel (.xlsx) Export with Borders & Colors -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>

    <!-- jsPDF & jsPDF-AutoTable for Vector PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

    <!-- Master Tables Catalog (All OPD & Instansi) -->
    <script src="{{ asset('simonda-catalogs.js') }}"></script>
    <!-- Table Helpers & Schemas -->
    <script src="{{ asset('js/tabel/helpers.js') }}"></script>
    <script src="{{ asset('js/tabel/schemas-display.js') }}"></script>

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f2f5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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

        .table-custom-border td, .table-custom-border th {
            border: 1px solid #334155;
        }

        /* phpMyAdmin Style Editable Form Inputs */
        .pma-edit-cell {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 6px;
            width: 100%;
            padding: 2px;
        }

        .pma-textarea {
            background-color: #f58220;
            color: #0f172a;
            font-weight: 700;
            font-size: 13px;
            font-family: inherit;
            border-radius: 6px;
            border: 1px solid #d9680c;
            padding: 5px 8px;
            width: 100%;
            min-width: 60px;
            height: 34px;
            min-height: 32px;
            max-height: 75px;
            resize: both;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.15);
            outline: none;
            line-height: 1.35;
            transition: background-color 0.15s, border-color 0.15s, box-shadow 0.15s;
        }

        .pma-textarea:focus {
            background-color: #fa933b;
            border-color: #9a3412;
            box-shadow: 0 0 0 2px rgba(245, 130, 32, 0.45);
        }

        .pma-select {
            background-color: #f58220;
            color: #0f172a;
            font-weight: 700;
            font-size: 11px;
            border-radius: 6px;
            border: 1px solid #d9680c;
            padding: 5px 6px;
            height: 34px;
            min-width: 44px;
            cursor: pointer;
            outline: none;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.15);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%230f172a'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 6px center;
            background-size: 11px;
            padding-right: 20px;
            transition: background-color 0.15s;
            shrink: 0;
        }

        .pma-select:focus {
            background-color: #fa933b;
            border-color: #9a3412;
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

        /* ==========================================================================
           PRINT STYLING (A4 LANDSCAPE - EXCEL SPREADSHEET STYLE)
           ========================================================================== */
        .print-only {
            display: none !important;
        }

        @page {
            size: A4 landscape;
            margin: 8mm 12mm 10mm 12mm;
        }

        @media print {
            /* Force exact background colors and borders in print */
            *, *::before, *::after {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            html, body {
                width: 100% !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                color: #0f172a !important;
                font-size: 11px !important;
            }

            /* Show elements intended only for print */
            .print-only {
                display: block !important;
            }

            /* Hide all interactive/screen-only UI elements */
            header,
            footer,
            #breadcrumbBar,
            #actionHeaderRight,
            #editModeAlert,
            #bottomActionBar,
            #toastNotification,
            #excelUploadSection,
            #yearStatusAlert,
            .top-card-header,
            .fixed,
            .no-print,
            button,
            select {
                display: none !important;
            }

            /* Flatten containers for full-width landscape printing */
            main {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            main > div {
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
                margin: 0 !important;
                background: transparent !important;
            }

            /* Table Metadata Section (Table Number + Title) */
            #tableMetadataSection {
                display: flex !important;
                align-items: flex-start !important;
                gap: 16px !important;
                margin-bottom: 8px !important;
                page-break-after: avoid !important;
            }

            #tableMetadataSection .font-bold {
                font-size: 12px !important;
            }

            /* Printable Table Wrapper */
            #printableTableSection {
                overflow: visible !important;
                width: 100% !important;
                margin: 0 0 8px 0 !important;
                padding: 0 !important;
            }

            /* Table styled like Excel Spreadsheet */
            #dataDisplayTable {
                width: 100% !important;
                border-collapse: collapse !important;
                table-layout: auto !important;
                font-size: 10.5px !important;
                background-color: #ffffff !important;
                border: 1.5px solid #000000 !important;
            }

            #dataDisplayTable thead {
                display: table-header-group !important;
            }

            #dataDisplayTable thead th {
                border: 1px solid #000000 !important;
                padding: 5px 6px !important;
                line-height: 1.25 !important;
                text-align: center !important;
                vertical-align: middle !important;
            }

            /* Top level header (Orange) */
            #dataDisplayTable thead tr:first-child th {
                background-color: #f95a00 !important;
                color: #ffffff !important;
                font-weight: 800 !important;
            }

            /* Subheader level (Amber/Light Orange for column numbers (1), (2), (3)...) */
            #dataDisplayTable thead tr:nth-child(2) th {
                background-color: #fed7aa !important;
                color: #1e293b !important;
                font-weight: 700 !important;
                font-size: 10px !important;
            }

            #dataDisplayTable tbody {
                display: table-row-group !important;
            }

            #dataDisplayTable tbody tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            #dataDisplayTable tbody tr:nth-child(even) {
                background-color: #f8fafc !important;
            }

            #dataDisplayTable tbody td {
                border: 1px solid #334155 !important;
                padding: 4px 6px !important;
                font-size: 10px !important;
                line-height: 1.3 !important;
                color: #0f172a !important;
            }

            /* Table Footnotes: Catatan & Sumber */
            .table-footer-notes {
                font-size: 9.5px !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                margin-top: 6px !important;
                line-height: 1.35 !important;
            }

            .print-footer-info {
                display: flex !important;
                justify-content: space-between !important;
                margin-top: 10px !important;
                padding-top: 5px !important;
                border-top: 1px dashed #94a3b8 !important;
                font-size: 8.5px !important;
                color: #475569 !important;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between text-slate-800 antialiased selection:bg-orange-500 selection:text-white relative bg-[#f4f6f8]">

    <!-- Decorative Top Background Glow -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-64 bg-gradient-to-b from-orange-100/40 via-orange-50/20 to-transparent pointer-events-none -z-10"></div>

    <!-- Background SiAngka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden flex items-center justify-center opacity-15 select-none">
        <img src="{{ asset('images/siangka-watermark-jamgadang.jpg') }}" alt="Watermark SiAngka Jam Gadang" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-16 sm:-translate-x-28 -translate-y-6 object-contain mix-blend-multiply">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="w-full flex-1 flex flex-col">
        
    @include('tabel.partials.header-bar')

        <!-- MAIN TABLE DETAIL CONTAINER -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-3 sm:py-5 flex-1 w-full">
            
            <!-- TABLE CARD -->
            <div class="bg-white rounded-2xl p-4 sm:p-7 md:p-8 shadow-sm border border-slate-200/90 relative transition-all">
                
                <!-- OFFICIAL BPS LANDSCAPE PRINT HEADER (EXCEL-STYLE PRINTOUT) -->
                <div class="print-only mb-4 pb-3 border-b-2 border-slate-900">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-10 w-auto object-contain">
                            <div>
                                <h1 class="text-xs font-black tracking-wider text-slate-900 uppercase leading-tight">
                                    BADAN PUSAT STATISTIK KOTA BUKITTINGGI
                                </h1>
                                <p class="text-[10px] font-bold text-[#f95a00] uppercase tracking-wide leading-tight">
                                    Sistem Informasi Data Daerah dalam Angka (SiAngka)
                                </p>
                                <p class="text-[9.5px] text-slate-600 font-medium" id="printOpdSubheading">
                                    {{ ($currentType ?? 'opd') === 'instansi' ? 'Instansi' : 'OPD' }} Penyelenggara Data: DINAS PEKERJAAN UMUM DAN PENATAAN RUANG
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2.5 py-0.5 rounded bg-slate-100 border border-slate-300 text-[9.5px] font-extrabold text-slate-800 tracking-wider">
                                FORMAT EXCEL / PUBLIKASI LANDSCAPE
                            </span>
                            <div class="text-[9px] text-slate-500 font-medium mt-1" id="printTimestamp">
                                Waktu Cetak: -
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TOP CARD HEADER BAR: 4-Square Grid Icon + Title + Export Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-4 mb-6 gap-3 top-card-header">
                    <div class="flex items-center space-x-3">
                        <!-- 4-Square Grid Icon -->
                        <div class="grid grid-cols-2 gap-0.5 w-5 h-5 shrink-0" aria-hidden="true">
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                        </div>

                        <!-- Title: Tabel 1.1.6 Tahun 2025 -->
                        <div>
                            <h2 id="pageMainHeading" class="text-base sm:text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                Tabel 1.1.6 Tahun 2025
                            </h2>
                            <p id="subHeadingOpd" class="text-xs text-slate-500 font-medium">01. DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</p>
                        </div>
                    </div>

                    <!-- Right Header Actions: Table Switcher + Year Switcher + Edit + Unggah Excel + Export Dropdown Menu -->
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

                        <!-- Year Switcher Selector -->
                        <div class="flex items-center space-x-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 rounded-lg px-2.5 py-1.5 transition-colors shadow-2xs">
                            <i class="fa-solid fa-calendar-days text-slate-400 text-xs"></i>
                            <select id="yearSwitcher" onchange="changeTableYear(this.value)" 
                                    class="bg-transparent text-xs font-bold text-slate-700 focus:outline-none cursor-pointer">
                                <!-- Populated dynamically -->
                            </select>
                        </div>

                        <!-- Button: Form Import Excel -->
                        <button onclick="toggleExcelUploadForm()" 
                                id="btnToggleExcelUpload"
                                class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#0F9D58] border border-emerald-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Import Data Tabel dari Berkas Excel">
                            <i class="fa-solid fa-file-import text-xs"></i>
                            <span>Import</span>
                        </button>

                        @php
                            $isAdmin = session('user.role') === 'admin';
                            $verificationStatus = $dbMetadata?->verification_status ?? 'draft';
                            $isLocked = (bool) ($dbMetadata?->is_locked ?? false);
                        @endphp

                        <!-- Edit Button (Buka Halaman Editor Data) -->
                        @if($isLocked && !$isAdmin)
                            <button disabled 
                                    class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 border border-slate-200 font-bold text-xs flex items-center space-x-1.5 cursor-not-allowed opacity-75"
                                    title="Tabel sudah di-ACC & terkunci. Hubungi BPS jika perlu perubahan data.">
                                <i class="fa-solid fa-lock text-[11px]"></i>
                                <span>Terkunci</span>
                            </button>
                        @else
                            <button id="editTableBtn" onclick="goToEditPage()" 
                                    class="px-3 py-1.5 rounded-lg bg-[#fff8e6] hover:bg-[#ffefc2] text-[#d97706] border border-[#fde68a] font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                    title="Buka Halaman Pengeditan Data Tabel">
                                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                <span>Edit Tabel</span>
                            </button>
                        @endif

                        <!-- Button: Tampilan Google Spreadsheet (Publikasi Pusat) -->
                        <button onclick="openSpreadsheetModal()" 
                                id="btnOpenSpreadsheetView"
                                class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Buka Tampilan Google Spreadsheet & Salin Langsung untuk Publikasi Pusat">
                            <i class="fa-solid fa-table-cells text-xs"></i>
                            <span>Tampilan Spreadsheet</span>
                        </button>

                        <!-- Unified Export Dropdown Menu (Green Button) -->
                        <div class="relative inline-block text-left" id="exportDropdownContainerTop">
                            <button id="exportDropdownBtnTop" onclick="toggleExportDropdown('Top')" 
                                    class="px-3.5 py-1.5 rounded-lg bg-[#0F9D58] hover:bg-[#0B8043] text-white font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                    title="Pilih Format Ekspor Data (Excel, PDF)">
                                <i class="fa-solid fa-file-export text-xs"></i>
                                <span>Export</span>
                                <i id="exportChevronTop" class="fa-solid fa-chevron-down text-[9px] ml-0.5 transition-transform duration-200"></i>
                            </button>

                            <!-- Dropdown Menu Box -->
                            <div id="exportDropdownMenuTop" 
                                 class="hidden absolute right-0 mt-2 w-72 origin-top-right rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 border border-slate-200/90 divide-y divide-slate-100 focus:outline-none z-50 animate-in fade-in zoom-in-95 duration-150">
                                
                                <div class="p-3 bg-slate-50/90 rounded-t-2xl border-b border-slate-100 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded-lg bg-emerald-100 text-[#0F9D58] flex items-center justify-center text-xs shadow-2xs">
                                            <i class="fa-solid fa-download"></i>
                                        </div>
                                        <span class="text-[11px] font-extrabold text-slate-800 uppercase tracking-wider">Pilihan Format Ekspor</span>
                                    </div>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">SiAngka</span>
                                </div>

                                <div class="p-1.5 space-y-1">
                                    <!-- Option 1: Excel (.xlsx / .xls) -->
                                    <button onclick="exportToExcel(); closeAllExportDropdowns();" 
                                            class="w-full text-left flex items-start space-x-3 p-2.5 rounded-xl hover:bg-emerald-50/90 transition-all group cursor-pointer border border-transparent hover:border-emerald-200/60">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#107c41] group-hover:bg-[#107c41] group-hover:text-white flex items-center justify-center shrink-0 transition-colors shadow-2xs">
                                            <i class="fa-solid fa-file-excel text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-950">Microsoft Excel</span>
                                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-mono">.XLSX</span>
                                            </div>
                                            <p class="text-[10.5px] text-slate-500 leading-tight mt-0.5">Tabel bergaris, nilai angka & rumus standar BPS</p>
                                        </div>
                                    </button>

                                    <!-- Option 2: PDF (.pdf) -->
                                    <button onclick="exportToPDF(); closeAllExportDropdowns();" 
                                            class="w-full text-left flex items-start space-x-3 p-2.5 rounded-xl hover:bg-rose-50/90 transition-all group cursor-pointer border border-transparent hover:border-rose-200/60">
                                        <div class="w-8 h-8 rounded-xl bg-rose-100 text-red-600 group-hover:bg-red-600 group-hover:text-white flex items-center justify-center shrink-0 transition-colors shadow-2xs">
                                            <i class="fa-solid fa-file-pdf text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-slate-800 group-hover:text-rose-950">Dokumen PDF Resmi</span>
                                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-rose-100 text-rose-800 font-mono">.PDF</span>
                                            </div>
                                            <p class="text-[10.5px] text-slate-500 leading-tight mt-0.5">Tata letak cetak resmi Daerah Dalam Angka</p>
                                        </div>
                                    </button>


                                </div>

                                <div class="px-3 py-2 bg-slate-50/60 rounded-b-2xl text-[10px] text-slate-400 text-center flex items-center justify-center space-x-1">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i>
                                    <span>Standar Publikasi BPS Kota Bukittinggi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- TABLE TITLE & METADATA SECTION -->
                <div id="tableMetadataSection" class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 mb-6 text-xs sm:text-sm text-slate-900">
                    
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



                <!-- VERIFICATION STATUS ALERT & AUDIT TRAIL -->
                <div id="verificationStatusBanner" class="mb-4">
                    @if($verificationStatus === 'verified')
                        <div class="p-3.5 sm:p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-base shrink-0 shadow-2xs">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-xs sm:text-sm font-black text-emerald-950">Data Resmi Terverifikasi BPS Kota Bukittinggi</h4>
                                        <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-200/80 text-emerald-900 border border-emerald-300">
                                            <i class="fa-solid fa-lock text-[8px]"></i>
                                            <span>DI-ACC</span>
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-emerald-800 font-medium mt-0.5">
                                        Data tabel ini telah disetujui oleh <strong>{{ $dbMetadata->verified_by ?? 'Tim Nerwilis BPS' }}</strong>
                                        @if($dbMetadata->verified_at)
                                            pada {{ $dbMetadata->verified_at->translatedFormat('d F Y, H:i') }} WIB
                                        @endif
                                        dan siap dikompilasi ke publikasi Daerah Dalam Angka (DDA).
                                    </p>
                                </div>
                            </div>
                            @if($isAdmin)
                                <button onclick="handleUnlockTable()" class="px-3 py-1.5 rounded-xl bg-white hover:bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-bold transition-all shadow-2xs cursor-pointer shrink-0">
                                    <i class="fa-solid fa-lock-open mr-1"></i> Buka Kunci
                                </button>
                            @endif
                        </div>
                    @elseif($verificationStatus === 'submitted')
                        <div class="p-3.5 sm:p-4 rounded-2xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-base shrink-0 shadow-2xs">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-xs sm:text-sm font-black text-amber-950">Menunggu Verifikasi BPS Kota Bukittinggi</h4>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-200 text-amber-900">Antrean Periksa</span>
                                    </div>
                                    <p class="text-[11px] text-amber-800 font-medium mt-0.5">
                                        Data telah diajukan oleh dinas dan sedang dalam proses penelaahan konsistensi & kewajaran angka oleh Pembina Data Statistik BPS.
                                    </p>
                                </div>
                            </div>
                            @if($isAdmin)
                                <div class="flex items-center space-x-2 shrink-0">
                                    <button onclick="handleApproveTable()" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center space-x-1">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                        <span>ACC Data</span>
                                    </button>
                                    <button onclick="openRevisionModal()" class="px-3 py-1.5 rounded-xl bg-white hover:bg-rose-50 text-rose-700 border border-rose-300 text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center space-x-1">
                                        <i class="fa-solid fa-triangle-exclamation text-[11px]"></i>
                                        <span>Revisi</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @elseif($verificationStatus === 'revision')
                        <div class="p-3.5 sm:p-4 rounded-2xl bg-rose-50 border border-rose-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center text-base shrink-0 shadow-2xs mt-0.5">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-xs sm:text-sm font-black text-rose-950">Catatan Revisi dari BPS Bukittinggi</h4>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-200 text-rose-900">Perlu Perbaikan</span>
                                    </div>
                                    <div class="text-xs text-rose-900 bg-white/80 border border-rose-200/80 rounded-xl p-2.5 mt-1.5 font-medium leading-relaxed">
                                        <i class="fa-solid fa-comment-dots text-rose-500 mr-1.5"></i>
                                        "{{ $dbMetadata->rejection_notes ?? 'Mohon periksa kembali kelengkapan dan kewajaran data.' }}"
                                    </div>
                                </div>
                            </div>
                            @if(!$isLocked)
                                <button onclick="goToEditPage()" class="px-3.5 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all shadow-2xs cursor-pointer shrink-0">
                                    <i class="fa-solid fa-pen mr-1"></i> Perbaiki Sekarang
                                </button>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- YEAR STATUS ALERT -->
                <div id="yearStatusAlert" class="mb-4"></div>

                <!-- EXCEL UPLOAD & AUTO-GENERATE FORM CONTAINER -->
                <div id="excelUploadSection" class="mb-6 p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-emerald-50/80 via-white to-orange-50/40 border border-emerald-200/90 shadow-sm transition-all hidden">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-emerald-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-2xs shrink-0">
                                <i class="fa-solid fa-file-excel"></i>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 leading-snug">
                                    Form Pengisian Data Tabel — Import Berkas Excel
                                </h3>
                                <p class="text-xs text-slate-600 mt-0.5" id="excelUploadSubtitle">
                                    Import berkas Excel (.xlsx / .xls) untuk men-generate data tabel ini secara otomatis.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <!-- Close Form Button -->
                            <button onclick="toggleExcelUploadForm(false)" 
                                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer"
                                    title="Tutup form import">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Dropzone / File Picker -->
                    <div id="excelDropZone" 
                         onclick="document.getElementById('excelFileInput').click()"
                         class="border-2 border-dashed border-emerald-300 hover:border-emerald-500 rounded-2xl p-6 sm:p-8 bg-white/90 hover:bg-emerald-50/40 transition-all text-center cursor-pointer group shadow-2xs">
                        
                        <input type="file" id="excelFileInput" accept=".xlsx, .xls, .csv" class="hidden" onchange="handleExcelFileSelected(event)">
                        
                        <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-100 group-hover:bg-emerald-600 text-emerald-700 group-hover:text-white flex items-center justify-center text-2xl transition-all shadow-xs mb-3 group-hover:scale-105">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>

                        <h4 class="text-sm font-bold text-slate-800 group-hover:text-emerald-950 mb-1">
                            Pilih Berkas Excel atau Tarik & Lepas (Drag & Drop) ke Sini
                        </h4>
                        <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                            Mendukung format <strong>.XLSX</strong>, <strong>.XLS</strong>, atau <strong>.CSV</strong>. Baris dan kolom akan dibaca secara instan dan di-generate menjadi tampilan tabel standar BPS.
                        </p>

                        <div class="mt-4 inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-emerald-600 group-hover:bg-emerald-700 text-white font-bold text-xs shadow-2xs transition-all">
                            <i class="fa-solid fa-folder-open text-xs"></i>
                            <span>Pilih Berkas dari Komputer</span>
                        </div>
                    </div>

                    <!-- Loading / Processing indicator -->
                    <div id="excelUploadLoading" class="hidden mt-4 p-4 rounded-xl bg-white border border-emerald-200 text-center space-y-2">
                        <div class="inline-block animate-spin text-emerald-600 text-xl">
                            <i class="fa-solid fa-circle-notch"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-700">Membaca berkas Excel dan men-generate baris tabel...</p>
                    </div>

                </div>

                <!-- TABLE DISPLAY CONTAINER (SCROLLABLE ON MOBILE) -->
                <div class="overflow-x-auto mb-5" id="printableTableSection">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse table-custom-border" id="dataDisplayTable">
                        <!-- Injected via JavaScript based on table code and year -->
                    </table>
                </div>



                <!-- TABLE FOOTER: NOTE & SOURCE / SUMBER -->
                <div class="text-xs text-slate-700 space-y-2 pt-2 border-t border-slate-100 table-footer-notes">
                    <div id="tableNoteRow" class="hidden grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-2">
                        <div class="sm:col-span-2 font-bold flex space-x-1">
                            <span>Catatan</span>
                            <span class="font-normal">/</span>
                            <span class="italic font-normal text-slate-500">Note:</span>
                        </div>
                        <div class="sm:col-span-10 text-slate-800 font-medium leading-relaxed" id="tableNoteContent">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-2">
                        <div class="sm:col-span-2 font-bold flex space-x-1">
                            <span>Sumber</span>
                            <span class="font-normal">/</span>
                            <span class="italic font-normal text-slate-500">Source:</span>
                        </div>
                        <div class="sm:col-span-10 text-slate-800 font-medium leading-relaxed" id="tableSourceContent">
                            Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>
                        </div>
                    </div>
                </div>

                <!-- PRINT ONLY FOOTER (OFFICIAL VERIFICATION LINE) -->
                <div class="print-only print-footer-info">
                    <span>Dokumen resmi publikasi statistik sektoral diexport melalui SiAngka BPS Kota Bukittinggi.</span>
                    <span>Standar Publikasi Daerah Dalam Angka (DDA) &bull; Format Excel Landscape</span>
                </div>

                <!-- BOTTOM ACTION BAR -->
                <div id="bottomActionBar" class="mt-8 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <button onclick="window.history.back()" 
                            class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-2 cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Kembali ke Halaman Sebelumnya</span>
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

    @include('tabel.partials.toast')
    @include('tabel.partials.comments-drawer')
    @include('tabel.partials.spreadsheet-modal')

    <!-- JAVASCRIPT TABLE LOGIC & RENDERER -->
    <script>
        const tableSchemas = window.tableSchemas || {};


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
                        if (currentTableCode === '1.1.8' && tableSchemas['1.1.8']) {
                return tableSchemas['1.1.8'].render(targetYear);
            }
            if (currentTableCode === '1.1.6' && tableSchemas['1.1.6']) {
                return tableSchemas['1.1.6'].render(targetYear);
            }
            if (currentTableCode.startsWith('4.1') && tableSchemas[currentTableCode]) {
                return tableSchemas[currentTableCode].render(targetYear);
            }
            if ((currentTableCode === '5.2.1' || currentTableCode === '5.2.2') && tableSchemas[currentTableCode]) {
                return tableSchemas[currentTableCode].render(targetYear);
            }
            if (currentTableCode === '8.1.6' && tableSchemas['8.1.6']) {
                return tableSchemas['8.1.6'].render(targetYear);
            }
            const tempTable = document.createElement('table');
            tempTable.innerHTML = sourceHtml;

            // 1. thead: Ganti tahun lama di header jika ada teks tahun eksplisit
            if (sourceYear && targetYear && sourceYear.toString() !== targetYear.toString()) {
                const theadThs = tempTable.querySelectorAll('thead th');
                const delta = parseInt(targetYear) - parseInt(sourceYear);
                theadThs.forEach(th => {
                    if (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(th.innerText)) {
                        th.innerHTML = th.innerHTML.replace(/\b((?:19|20)\d{2})\s*\/\s*((?:19|20)\d{2})\b/g, (m, y1, y2) => {
                            return `${parseInt(y1) + delta}/${parseInt(y2) + delta}`;
                        });
                    } else if (/\b(?:19|20)\d{2}\s*[–\-]\s*(?:19|20)\d{2}\b/.test(th.innerText)) {
                        th.innerHTML = th.innerHTML.replace(/\b((?:19|20)\d{2})\s*[–\-]\s*((?:19|20)\d{2})\b/g, (m, y1, y2) => {
                            return `${parseInt(y1) + delta}–${parseInt(y2) + delta}`;
                        });
                    } else if (/\b(19\d{2}|20\d{2})\b/.test(th.innerText)) {
                        th.innerHTML = th.innerHTML.replace(/\b(19\d{2}|20\d{2})\b/g, (m) => {
                            return (parseInt(m, 10) + delta).toString();
                        });
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

            // Khusus tabel 9.11 (Dinas Pertanian): atur 5 rentang tahun historis pada bagian Rata-rata [targetYear, targetYear-1, ..., targetYear-4]
            if (currentTableCode === '9.11') {
                const yr = parseInt(targetYear) || 2026;
                const ratarataCell = Array.from(tempTable.querySelectorAll('td')).find(td => td.innerText.trim().toLowerCase().includes('rata-rata') || td.innerText.trim().toLowerCase().includes('average'));
                if (ratarataCell) {
                    ratarataCell.setAttribute('rowspan', '5');
                    let currentRow = ratarataCell.parentElement;
                    let tbody = currentRow.parentElement;
                    const histAverages = {
                        2025: ['9.750', '41.500', '256.667', '-', '32.917'],
                        2024: ['6.417', '34.833', '190.833', '-', '32.000'],
                        2023: ['6.083', '31.375', '173.333', '-', '26.833'],
                        2022: ['6.433', '30.125', '166.667', '-', '31.625'],
                        2021: ['5.791', '29.875', '162.083', '53.916', '29.083'],
                        2020: ['5.889', '29.722', '160.000', '60.000', '28.333'],
                        2019: ['4.917', '28.583', '150.000', '60.000', '25.833']
                    };
                    const colCount = 5;

                    let subsequentRows = [];
                    let r = currentRow.nextElementSibling;
                    while (r) {
                        subsequentRows.push(r);
                        r = r.nextElementSibling;
                    }
                    while (subsequentRows.length < 4) {
                        const newTr = document.createElement('tr');
                        newTr.className = 'hover:bg-amber-100/60 transition-colors';
                        tbody.appendChild(newTr);
                        subsequentRows.push(newTr);
                    }
                    if (subsequentRows.length > 4) {
                        for (let k = 4; k < subsequentRows.length; k++) {
                            subsequentRows[k].remove();
                        }
                    }

                    for (let i = 0; i < 5; i++) {
                        const y = (yr - i).toString();
                        const known = histAverages[yr - i];
                        const targetRow = (i === 0) ? currentRow : subsequentRows[i - 1];
                        if (!targetRow) break;

                        const tds = targetRow.querySelectorAll('td');
                        const yearTd = (i === 0) ? tds[1] : tds[0];
                        if (yearTd) {
                            yearTd.innerText = y;
                            yearTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top' + (i === 0 ? ' font-extrabold' : '');
                        }

                        for (let c = 0; c < colCount; c++) {
                            const valTd = (i === 0) ? tds[2 + c] : tds[1 + c];
                            if (valTd) {
                                if (i === 0) {
                                    valTd.innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                                } else {
                                    valTd.innerText = known ? known[c] : '-';
                                }
                                valTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top text-center align-middle';
                            }
                        }
                    }
                }
            }

            // Khusus tabel pariwisata 7.3, 7.4, 7.5 (Dinas Pariwisata): atur 5 rentang tahun historis pada bagian Jumlah [targetYear, targetYear-1, ..., targetYear-4]
            if (['7.3', '7.4', '7.5'].includes(currentTableCode)) {
                const yr = parseInt(targetYear) || 2026;
                const histTotals = {
                    '7.3': {
                        2025: ['750.821', '17.768.964'],
                        2024: ['604.541', '14.472.272'],
                        2023: ['820.943', '19.536.206'],
                        2022: ['991.632', '24.205.697'],
                        2021: ['618.049', '14.876.991'],
                        2020: ['363.045', '8.746.437'],
                        2019: ['729.705', '10.620.300']
                    },
                    '7.4': {
                        2025: ['175.214', '3.360.118'],
                        2024: ['160.099', '3.085.615'],
                        2023: ['220.525', '3.170.210'],
                        2022: ['236.449', '3.440.474'],
                        2021: ['131.873', '1.860.079']
                    },
                    '7.5': {
                        2025: ['45.094'],
                        2024: ['35.303'],
                        2023: ['19.390'],
                        2022: ['491'],
                        2021: ['17'],
                        2020: ['2.337'],
                        2019: ['32.653']
                    }
                };
                const colCount = currentTableCode === '7.5' ? 1 : 2;

                // Khusus 7.5 bersihkan 1926 pada baris Belanda jika targetYear >= 2026
                if (currentTableCode === '7.5' && yr >= 2026) {
                    tempTable.querySelectorAll('tbody tr').forEach(tr => {
                        if (tr.innerText.includes('Belanda') || tr.innerText.includes('Netherland')) {
                            const tds = tr.querySelectorAll('td');
                            if (tds.length >= 2 && tds[tds.length - 1].innerText.trim() === '1926') {
                                tds[tds.length - 1].innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                            }
                        }
                    });
                }

                const jumlahCell = Array.from(tempTable.querySelectorAll('td')).find(td => td.innerText.trim().toLowerCase().includes('jumlah') || td.innerText.trim().toLowerCase().includes('total'));
                if (jumlahCell) {
                    jumlahCell.setAttribute('rowspan', '5');
                    let currentRow = jumlahCell.parentElement;
                    let tbody = currentRow.parentElement;
                    let subsequentRows = [];
                    let r = currentRow.nextElementSibling;
                    while (r) {
                        subsequentRows.push(r);
                        r = r.nextElementSibling;
                    }

                    // Pastikan ada 4 baris setelah Jumlah (sehingga total 5 tahun)
                    while (subsequentRows.length < 4) {
                        const newTr = document.createElement('tr');
                        newTr.className = 'hover:bg-amber-100/60 transition-colors';
                        tbody.appendChild(newTr);
                        subsequentRows.push(newTr);
                    }

                    for (let i = 0; i < 5; i++) {
                        const targetY = yr - i;
                        const known = histTotals[currentTableCode] && histTotals[currentTableCode][targetY];
                        const targetRow = (i === 0) ? currentRow : subsequentRows[i - 1];

                        if (i === 0) {
                            const tds = targetRow.querySelectorAll('td');
                            if (tds[1]) {
                                tds[1].innerText = targetY.toString();
                                tds[1].className = 'py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold';
                            }
                            for (let c = 0; c < colCount; c++) {
                                if (tds[2 + c]) {
                                    if (known) {
                                        tds[2 + c].innerText = known[c];
                                    } else {
                                        tds[2 + c].innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                                    }
                                    tds[2 + c].className = 'py-2.5 px-4 border border-slate-700 text-center align-top font-extrabold text-center align-middle';
                                }
                            }
                        } else {
                            targetRow.innerHTML = '';
                            const yTd = document.createElement('td');
                            yTd.innerText = targetY.toString();
                            yTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top';
                            targetRow.appendChild(yTd);

                            for (let c = 0; c < colCount; c++) {
                                const dTd = document.createElement('td');
                                if (known) {
                                    dTd.innerText = known[c];
                                } else {
                                    dTd.innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                                }
                                dTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top text-center align-middle';
                                targetRow.appendChild(dTd);
                            }
                        }
                    }

                    // Hapus baris berlebih jika ada
                    if (subsequentRows.length > 4) {
                        for (let k = 4; k < subsequentRows.length; k++) {
                            subsequentRows[k].remove();
                        }
                    }
                }
            }

            return tempTable.innerHTML;
        }

        function cleanHtmlYearRanges(html) {
            if (!html || typeof html !== 'string') return html;
            return html.replace(/<div>\s*((?:19|20)\d{2})\s*<\/div>\s*<div class="italic[^>]*>\s*((?:19|20)\d{2})\s*<\/div>/gi, '<div>$1/$2</div>');
        }

        // Query Param State
        let currentOpdCode = '{{ $currentOpdCode ?? "01" }}';
        let currentTableCode = '{{ $currentTableCode ?? "8.1.1" }}';
        let currentYear = '{{ $currentYear ?? "2025" }}';
        let currentType = '{{ $currentType ?? "opd" }}';
        let isEditMode = false;

        function getStorageKey(prefix, code = currentTableCode, yr = currentYear) {
            const t = (typeof currentType !== 'undefined' && currentType) ? currentType : 'opd';
            const opd = (typeof currentOpdCode !== 'undefined' && currentOpdCode) ? currentOpdCode.toString().padStart(2, '0') : '01';
            return `${prefix}_${t}_${opd}_${code}_${yr}`;
        }

        function getScopedLocalStorageItem(prefix, code = currentTableCode, yr = currentYear) {
            const scopedKey = getStorageKey(prefix, code, yr);
            const val = localStorage.getItem(scopedKey);
            if (val !== null) return val;
            if (typeof currentType !== 'undefined' && currentType === 'instansi') {
                return null;
            }
            return localStorage.getItem(`${prefix}_${code}_${yr}`);
        }

        function setScopedLocalStorageItem(prefix, val, code = currentTableCode, yr = currentYear) {
            const scopedKey = getStorageKey(prefix, code, yr);
            safeSetLocalStorage(scopedKey, val);
        }

        function removeScopedLocalStorageItem(prefix, code = currentTableCode, yr = currentYear) {
            const scopedKey = getStorageKey(prefix, code, yr);
            try { localStorage.removeItem(scopedKey); } catch(e) {}
            try { localStorage.removeItem(`${prefix}_${code}_${yr}`); } catch(e) {}
        }


        function cleanupLocalStorageQuota(force = false) {
            try {
                let totalChars = 0;
                const htmlKeys = [];
                const activeScopedKey = (typeof getStorageKey === 'function') 
                    ? getStorageKey('simonda_table_html', currentTableCode, currentYear) 
                    : `simonda_table_html_${currentTableCode}_${currentYear}`;

                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (!k) continue;
                    const val = localStorage.getItem(k) || '';
                    totalChars += k.length + val.length;

                    // Bersihkan segera key legacy unscoped 4.1.18 & 4.1.19 yang memicu tabrakan data antar kampus 05-23
                    if (/^simonda_table_(?:html|is_saved|source|title|note)_(?:4\.1\.18|4\.1\.19)_/.test(k)) {
                        try { localStorage.removeItem(k); } catch(e) {}
                        continue;
                    }

                    if (k.includes('simonda_table_html')) {
                        htmlKeys.push(k);
                    }
                }

                // Hapus cache HTML tabel lama yang bukan tabel aktif saat kuota mendekati batas
                if (force || totalChars > 350000 || htmlKeys.length > 2) {
                    htmlKeys.forEach(k => {
                        if (k !== activeScopedKey) {
                            try { localStorage.removeItem(k); } catch(e) {}
                        }
                    });
                    console.log('[LocalStorage Cleaner] Kuota cache HTML tabel lama dibersihkan.');
                }
            } catch (e) {
                console.warn('[LocalStorage Cleaner] Error:', e);
            }
        }

        function safeSetLocalStorage(key, val) {
            try {
                localStorage.setItem(key, val);
            } catch (e) {
                if (e && (e.name === 'QuotaExceededError' || e.name === 'NS_ERROR_DOM_QUOTA_REACHED' || e.code === 22 || e.code === 1014 || (e.message && e.message.includes('quota')))) {
                    console.warn('[LocalStorage] Kuota penuh saat menyimpan ' + key + '. Membersihkan cache HTML lama...', e);
                    cleanupLocalStorageQuota(true);
                    try {
                        localStorage.setItem(key, val);
                    } catch (retryErr) {
                        console.warn('[LocalStorage] Tidak dapat menyimpan ke cache lokal setelah pembersihan; database server tetap aman.', retryErr);
                    }
                } else {
                    console.warn('[LocalStorage] Error saving ' + key, e);
                }
            }
        }

        function initPage() {
            // Bersihkan kelebihan kuota localStorage browser secara otomatis (force purge non-active table HTML)
            cleanupLocalStorageQuota(true);

            // One-time cleanup: remove accidental saves
            try {
                localStorage.removeItem('simonda_table_html_1.1.6_2026');
                localStorage.removeItem('simonda_table_html_8.1.2_2026');
                localStorage.removeItem('simonda_table_html_8.1.2_2027');
                for (let y = 2015; y <= 2030; y++) {
                    ['5.1.15', '5.1.16', '5.1.17'].forEach(code => {
                        const k = `simonda_table_html_${code}_${y}`;
                        const val = localStorage.getItem(k);
                        if (val && (val.includes('212,10') || val.includes('105,22'))) {
                            safeSetLocalStorage(k, val.replace(/212,10/g, '8,84').replace(/105,22/g, '4,39'));
                        }
                    });
                    ['5.2.1', '5.2.2'].forEach(code => {
                        const k = `simonda_table_html_${code}_${y}`;
                        const val = localStorage.getItem(k);
                        if (val && (val.includes('Kulit Manis') || val.includes('Cassiavera') || val.includes('Cengkeh') || val.includes('Pala') || val.includes('Pinang') || val.includes('Tebu') || val.includes('Kakao') || val.includes('Cocoa') || val.includes('(10)') || val.includes('(21)'))) {
                            localStorage.removeItem(k);
                            localStorage.removeItem(`simonda_table_source_${code}_${y}`);
                            localStorage.removeItem(`simonda_table_is_saved_${code}_${y}`);
                        }
                    });
                    const k542 = `simonda_table_html_5.4.2_${y}`;
                    const val542 = localStorage.getItem(k542);
                    if (val542 && (val542.includes('colspan="2"><div>Sewaktu-waktu</div>') || val542.includes('(6)</th>') || !val542.includes('Sometime'))) {
                        safeSetLocalStorage(k542, val542.replace(/<th([^>]*?)colspan=[\'"]?2[\'"]?([^>]*?)>\s*<div>Sewaktu-waktu<\/div>\s*<\/th>/gi, '<th$1$2><div>Sewaktu-waktu</div><div class="italic font-normal text-[11px] sm:text-xs">Sometime</div></th>')
                                                        .replace(/colspan="2"><div>Sewaktu-waktu<\/div>/gi, '><div>Sewaktu-waktu</div><div class="italic font-normal text-[11px] sm:text-xs">Sometime</div>')
                                                        .replace(/<th([^>]*?)>\s*\(6\)\s*<\/th>/gi, '<th$1>(5)</th>'));
                    }
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

                // Cleanup cache tahun ajaran dan title generik
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (!k) continue;

                    // 1. Bersihkan data Perpustakaan yang salah masuk ke tabel 4.3.5 (Damkar)
                    if (k.includes('4.3.5')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('Perpustakaan') || val.includes('Library') || val.includes('Koleksi')) {
                            keysToRemove.push(k);
                            continue;
                        }
                    }

                    // 2. Bersihkan cache tahun ajaran acak / korup pada tabel pendidikan 4.1.x
                    if (k.startsWith('simonda_table_html_4.1.')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('2023/2026') || val.includes('2026/2025') || val.includes('2023/2025')) {
                            keysToRemove.push(k);
                            continue;
                        }
                    }

                    if (k.startsWith('simonda_table_html_')) {
                        const val = localStorage.getItem(k);
                        if (val && val.includes('sm:text-xs">20')) {
                            safeSetLocalStorage(k, cleanHtmlYearRanges(val));
                        }
                    }
                    if (k.startsWith('simonda_table_title_en_')) {
                        const val = localStorage.getItem(k);
                        if (val && (val.trim().toLowerCase() === 'table' || val.trim().toLowerCase() === 'tabel')) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k.startsWith('simonda_table_title_id_')) {
                        const val = localStorage.getItem(k);
                        if (val && (/2023\/20\d{2}/.test(val) || /2024\/20\d{2}/.test(val))) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k && k.includes('2.2.2')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('Kolom 6') || val.includes('kolom 6')) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k && (k.includes('8.1.7') || k.includes('8.1.9'))) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('-2') || val.includes('-3') || val.includes('...')) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k && k.includes('8.1.6')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('Kolom 6') || val.includes('kolom 6')) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k && k.includes('4.1.2')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('2023/2024') && val.includes('2025/2026')) {
                            keysToRemove.push(k);
                        }
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
            } catch(e) {}

            const params = new URLSearchParams(window.location.search);
            currentType = params.get('type') || currentType || 'opd';
            currentOpdCode = params.get('opd') || '01';
            currentTableCode = params.get('code') || params.get('table') || '1.1.6';
            currentYear = params.get('year') || '2025';

            // Selaraskan instansi jika tabel saat ini milik instansi/OPD lain
            if (typeof getAgencyInfoForTable === 'function') {
                const autoAgency = getAgencyInfoForTable(currentTableCode, currentOpdCode, currentType);
                if (autoAgency && autoAgency.opdCode && (autoAgency.opdCode !== currentOpdCode || (autoAgency.type && autoAgency.type !== currentType))) {
                    currentOpdCode = autoAgency.opdCode;
                    if (autoAgency.type) currentType = autoAgency.type;
                    if (window.history && window.history.replaceState) {
                        const syncUrl = new URL(window.location.href);
                        syncUrl.searchParams.set('opd', currentOpdCode);
                        if (currentType) syncUrl.searchParams.set('type', currentType);
                        window.history.replaceState({}, '', syncUrl.toString());
                    }
                }
            }

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

        function get4YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 3;
            const end = yr;
            return {
                start: start,
                end: end,
                yearsAsc: [yr - 3, yr - 2, yr - 1, yr],
                yearsDesc: [yr, yr - 1, yr - 2, yr - 3],
                label: `${start}–${end}`
            };
        }

        function get6YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 5;
            const end = yr;
            const yearsAsc = [];
            const yearsDesc = [];
            for (let y = start; y <= end; y++) {
                yearsAsc.push(y);
            }
            for (let y = end; y >= start; y--) {
                yearsDesc.push(y);
            }
            return {
                start: start,
                end: end,
                yearsAsc: yearsAsc,
                yearsDesc: yearsDesc,
                label: `${start}–${end}`
            };
        }

        function get7YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 6;
            const end = yr;
            const yearsAsc = [];
            const yearsDesc = [];
            for (let y = start; y <= end; y++) {
                yearsAsc.push(y);
            }
            for (let y = end; y >= start; y--) {
                yearsDesc.push(y);
            }
            return {
                start: start,
                end: end,
                yearsAsc: yearsAsc,
                yearsDesc: yearsDesc,
                label: `${start}–${end}`
            };
        }

        function get2YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 1;
            const end = yr;
            return {
                start: start,
                end: end,
                yearsAsc: [start, end],
                yearsDesc: [end, start],
                label: `${start}–${end}`
            };
        }

        function getTablePeriod(year, tableCode) {
            if (tableCode === '5.2.1' || tableCode === '5.2.2') {
                return get2YearPeriod(year);
            }
            if (tableCode === '4.1.20' || tableCode === '2.4.1' || tableCode === '2.4.2') {
                return get4YearPeriod(year);
            }
            if (tableCode === '4.2.20' || tableCode === '4.3.15' || tableCode === '9.3' || tableCode === '8.1.6') {
                return get7YearPeriod(year);
            }
            return get5YearPeriod(year);
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
                const p = getTablePeriod(y, currentTableCode);
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
                const p = getTablePeriod(cNum, currentTableCode);
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

            // Selaraskan OPD jika tabel saat ini milik instansi/OPD lain
            if (typeof getAgencyInfoForTable === 'function') {
                const verified = getAgencyInfoForTable(currentTableCode, currentOpdCode, currentType);
                if (verified && verified.opdCode && verified.opdCode !== currentOpdCode) {
                    currentOpdCode = verified.opdCode;
                    if (verified.type) currentType = verified.type;
                }
            }

            let tables = [];
            if (typeof getAgencyTables === 'function') {
                tables = getAgencyTables(currentOpdCode, currentType);
            }
            const cleanOpd = currentOpdCode ? currentOpdCode.toString().padStart(2, '0') : '01';
            if ((!tables || tables.length === 0) && typeof opdTablesCatalog !== 'undefined') {
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
                    opt.textContent = `Tabel ${t.code} - ${t.title || ''}${t.isCustom ? ' [Tabel Baru]' : ''}`;
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

            // Cari instansi/OPD yang memiliki tabel newCode secara otomatis
            let targetOpd = currentOpdCode;
            let targetType = currentType || 'opd';
            if (typeof getAgencyInfoForTable === 'function') {
                const info = getAgencyInfoForTable(newCode, currentOpdCode, currentType);
                if (info && info.opdCode) {
                    targetOpd = info.opdCode;
                    targetType = info.type || 'opd';
                }
            }

            const newUrl = new URL(window.location.origin + window.location.pathname);
            newUrl.searchParams.set('code', newCode);
            newUrl.searchParams.set('opd', targetOpd);
            newUrl.searchParams.set('year', currentYear);
            if (targetType) {
                newUrl.searchParams.set('type', targetType);
            }
            // Hapus parameter title lama agar tidak mencemari tabel tujuan
            newUrl.searchParams.delete('title');
            newUrl.searchParams.delete('title_en');
            newUrl.searchParams.delete('titleEn');
            if (typeof getCatalogTableInfo === 'function') {
                const info = getCatalogTableInfo(newCode, targetOpd, targetType);
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

            // Selaraskan instansi jika tabel saat ini milik instansi/OPD lain
            if (typeof getAgencyInfoForTable === 'function') {
                const autoAgency = getAgencyInfoForTable(currentTableCode, currentOpdCode, currentType);
                if (autoAgency && autoAgency.opdCode && (autoAgency.opdCode !== currentOpdCode || (autoAgency.type && autoAgency.type !== currentType))) {
                    currentOpdCode = autoAgency.opdCode;
                    if (autoAgency.type) currentType = autoAgency.type;
                    if (window.history && window.history.replaceState) {
                        const syncUrl = new URL(window.location.href);
                        syncUrl.searchParams.set('opd', currentOpdCode);
                        if (currentType) syncUrl.searchParams.set('type', currentType);
                        window.history.replaceState({}, '', syncUrl.toString());
                    }
                }
            }
            const selectYearEl = document.getElementById('yearSwitcher');
            if (selectYearEl) selectYearEl.value = currentYear.toString();
            renderTablePage();
        });

        function renderTablePage() {
            const isInstansi = currentType === 'instansi';
            const isBps = currentType === 'bps';
            const agencyName = getAgencyName(currentOpdCode);

            // Update Header & Breadcrumbs
            const badgeEl = document.getElementById('headerTypeBadge');
            if (badgeEl) badgeEl.innerText = isBps ? 'DATA INTERNAL BPS' : (isInstansi ? 'INSTANSI VERTIKAL' : 'OPD');

            const btnBackEl = document.getElementById('btnBackToDaftar');
            const btnBackTextEl = document.getElementById('btnBackToDaftarText');
            if (btnBackEl) {
                btnBackEl.href = isBps ? "{{ route('data-bps') }}" : (isInstansi ? "{{ route('isi-data-instansi') }}" : "{{ route('isi-data-opd') }}");
            }
            if (btnBackTextEl) {
                btnBackTextEl.innerText = isBps ? 'Data BPS' : (isInstansi ? 'Daftar Instansi' : 'Daftar OPD');
            }

            const breadcrumbCatalogLink = document.getElementById('breadcrumbCatalogLink');
            const breadcrumbCatalogText = document.getElementById('breadcrumbCatalogText');
            if (breadcrumbCatalogLink) {
                breadcrumbCatalogLink.href = isBps ? "{{ route('data-bps') }}" : (isInstansi ? "{{ route('isi-data-instansi') }}" : "{{ route('isi-data-opd') }}");
            }
            if (breadcrumbCatalogText) {
                breadcrumbCatalogText.innerText = isBps ? 'Data Internal BPS' : (isInstansi ? 'Isi Data Instansi Vertikal' : 'Isi Data OPD');
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
            const is822 = (currentTableCode === '8.2.2');
            const p = getTablePeriod(yr, currentTableCode);
            const yearLabel = schema.isExcludeSelectedYear ? `${yr - 5}–${yr - 1}` : ((schema.isMultiYear || is822) ? p.label : `${yr}`);
            document.getElementById('pageMainHeading').innerText = (schema.isMultiYear || schema.isExcludeSelectedYear || is822) ? `Tabel ${currentTableCode} Tahun ${yearLabel}` : `Tabel ${currentTableCode} Tahun ${currentYear}`;
            
            // Check for custom titles/source saved from Database, Fallback Structure, or Excel
            let customTitleId = (serverDbMetadata && serverDbMetadata.title_id) ? serverDbMetadata.title_id : (getScopedLocalStorageItem('simonda_table_title_id') || (serverDbFallbackMetadata && serverDbFallbackMetadata.title_id ? serverDbFallbackMetadata.title_id : null));
            let customTitleEn = (serverDbMetadata && serverDbMetadata.title_en) ? serverDbMetadata.title_en : (getScopedLocalStorageItem('simonda_table_title_en') || (serverDbFallbackMetadata && serverDbFallbackMetadata.title_en ? serverDbFallbackMetadata.title_en : null));
            let customSource = (serverDbMetadata && serverDbMetadata.source) ? serverDbMetadata.source : (getScopedLocalStorageItem('simonda_table_source_text') || (serverDbFallbackMetadata && serverDbFallbackMetadata.source ? serverDbFallbackMetadata.source : null));
            let customNote = (serverDbMetadata && serverDbMetadata.note !== undefined && serverDbMetadata.note !== null) ? serverDbMetadata.note : (getScopedLocalStorageItem('simonda_table_note') || (serverDbFallbackMetadata && serverDbFallbackMetadata.note !== undefined ? serverDbFallbackMetadata.note : null));

            // Isolasi judul & sumber untuk Instansi Vertikal Kampus (05 s.d 23): selalu prioritaskan nama kampus resmi dari katalog
            if (isInstansi && catInfo && catInfo.title) {
                if (!customTitleId || customTitleId.includes('Perguruan Tinggi') || customTitleId.includes('Tabel Data Statistik Sektoral')) {
                    customTitleId = catInfo.title;
                    customTitleEn = catInfo.titleEn || catInfo.title;
                }
                if (!customSource || customSource.includes('Dinas') || customSource.includes('Kecamatan')) {
                    customSource = `${agencyName} / <span class="italic text-slate-500">Bukittinggi Municipality</span>`;
                }
            }

            // Catatan resmi untuk Tabel 4.3.3 (PODES Bencana Alam)
            if (currentTableCode === '4.3.3') {
                const officialNote433 = '<div class="space-y-1"><div><sup>1</sup> Desa pada tabel ini termasuk Unit Permukiman Transmigrasi (UPT) yang masih dibina oleh kementerian terkait dan nagari di Provinsi Sumatera Barat / <span class="italic text-slate-500">Villages in this table are included in Transmigration Settlement Unit which is still fostered by the relevant ministries and the nagari in the Province of Sumatera Barat</span></div><div><sup>2</sup> Kejadian dalam setahun sebelum tahun pencacahan / <span class="italic text-slate-500">Occurred during the last one year before the enumeration years</span></div><div><sup>3</sup> Periode tahun 2024 adalah Januari - April / <span class="italic text-slate-500">2024 Period is January-April</span></div></div>';
                if (!customNote || customNote.length < 50 || !customNote.includes('Transmigrasi')) {
                    customNote = officialNote433;
                    safeSetLocalStorage(`simonda_table_note_${currentTableCode}_${currentYear}`, officialNote433);
                }
            }

            // Jika custom title belum ada untuk tahun ini, cari dari tahun lain di localStorage
            if (!customTitleId) {
                const searchYears = [2025, 2024, 2023, 2022, 2021, 2026, 2027, 2028, 2029, 2030, 2020, 2019, 2018];
                for (let y of searchYears) {
                    if (y.toString() === currentYear.toString()) continue;
                    const altTitle = localStorage.getItem(`simonda_table_title_id_${currentTableCode}_${y}`);
                    if (altTitle && !altTitle.includes('Tabel Data Statistik Sektoral')) {
                        customTitleId = altTitle;
                        if (!customTitleEn) customTitleEn = localStorage.getItem(`simonda_table_title_en_${currentTableCode}_${y}`);
                        if (!customSource) customSource = localStorage.getItem(`simonda_table_source_text_${currentTableCode}_${y}`);
                        if (!customNote) customNote = localStorage.getItem(`simonda_table_note_${currentTableCode}_${y}`);
                        break;
                    }
                }
            }

            // Bersihkan jika title hanya berisi kata 'Table' atau 'Tabel'
            if (customTitleEn && (customTitleEn.trim().toLowerCase() === 'table' || customTitleEn.trim().toLowerCase() === 'tabel')) {
                localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                customTitleEn = null;
            }
            if (customTitleId && (customTitleId.trim().toLowerCase() === 'table' || customTitleId.trim().toLowerCase() === 'tabel' || /2023\/20\d{2}/.test(customTitleId) || /2024\/20\d{2}/.test(customTitleId))) {
                localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                customTitleId = null;
            }

            // Bersihkan custom title jika masih berupa placeholder generik lawas atau keliru menempel judul TK di tabel non-TK
            if (catInfo && catInfo.title) {
                if (customTitleId && customTitleId.includes('Tabel Data Statistik Sektoral')) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && customTitleEn.includes('Sectoral Statistics Table')) {
                    localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
                // Jika tabel bukan 4.1.1 tetapi customTitleId memuat Taman Kanak-Kanak / (TK), bersihkan cache yang keliru
                if (currentTableCode !== '4.1.1' && customTitleId && (customTitleId.includes('Taman Kanak') || customTitleId.includes('(TK)'))) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                    customTitleEn = null;
                }
            }

            // Auto-detect dan perbaiki jika titleId dan titleEn terbalik (English di ID, Indonesia di EN)
            // ATAU jika titleId memuat baris ganda (ID & EN tergabung dengan newline)
            function sanitizeBilingualTitles(tId, tEn) {
                if (!tId && !tEn) return { id: tId, en: tEn };
                if (tId && tId.includes('\n')) {
                    const lines = tId.split('\n').map(l => l.trim()).filter(Boolean);
                    if (lines.length >= 2) {
                        tId = lines[0];
                        if (!tEn || tEn.toLowerCase() === 'table' || tEn === lines[1]) {
                            tEn = lines[1];
                        }
                    }
                }
                if (tEn && tEn.includes('\n')) {
                    const lines = tEn.split('\n').map(l => l.trim()).filter(Boolean);
                    if (lines.length >= 2) {
                        tEn = lines[1];
                    }
                }
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
                        if (currentTableCode === '4.1.20') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedRange = `${yrInt - 3}–${yrInt}`;
                const customId = localStorage.getItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                if (customId && (customId.includes('Number of Sport') || !customId.includes(expectedRange))) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                const customEn = localStorage.getItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                if (customEn && (!customEn.includes(expectedRange) || customEn.toLowerCase() === 'table')) {
                    localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
                const cachedHtml = localStorage.getItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                if (cachedHtml && (!cachedHtml.includes(yrInt.toString()) || (cachedHtml.includes('2022') && yrInt >= 2026))) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                }
            }

            if (currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.2.2' || currentTableCode === '4.2.4' || currentTableCode === '4.2.5' || currentTableCode === '4.2.7' || currentTableCode === '4.2.9' || currentTableCode === '4.2.10' || currentTableCode === '4.2.13' || currentTableCode === '4.2.15' || currentTableCode === '4.2.16') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedRange = `${yrInt - 4}–${yrInt}`;
                if (customTitleId && !customTitleId.includes(expectedRange)) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && (!customTitleEn.includes(expectedRange) || customTitleEn.includes('XXX'))) {
                    localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
            }

            if (currentTableCode === '8.1.6') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedRange = `${yrInt - 6}–${yrInt}`;
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
                // Khusus tabel pendidikan 4.1.x (OPD 08): tahun ajaran SiAngka Bukittinggi = Tahun + 1 (misal 2025 -> 2025/2026, 2026 -> 2026/2027)
                if (typeof currentTableCode === 'string' && (currentOpdCode === '08' || currentTableCode.startsWith('4.1')) && currentTableCode !== '4.1.20' && currentTableCode !== '4.1.24') {
                    const yrInt = parseInt(yLabel) || 2025;
                    const acadYr = `${yrInt}/${yrInt + 1}`;
                    let raw = (defaultTitle || title || '').trim();
                    if (raw.trim().toLowerCase() === 'table' || raw.trim().toLowerCase() === 'tabel') {
                        raw = (defaultTitle || '').trim();
                    }
                    // Bersihkan pecahan tahun ajaran atau tahun acak di akhir judul
                    const cleanBase = raw.replace(/([,\s]+)(19|20)\d{2}.*$/i, '').trim();
                    return `${cleanBase}, ${acadYr}`;
                }

                // Khusus Tabel 4.1.20 (Dispora): multi-tahun 4 tahun [yr-3 s.d yr]
                if (currentTableCode === '4.1.20') {
                    const yrInt = parseInt(currentYear) || 2025;
                    const range = `${yrInt - 3}–${yrInt}`;
                    const raw = (defaultTitle || title || '').trim();
                    const isEn = raw.toLowerCase().includes('sport') || (schema && schema.titleEn && defaultTitle === schema.titleEn);
                    if (isEn) {
                        return `Number of Sport Club in Bukittinggi, ${range}`;
                    } else {
                        return `Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi, ${range}`;
                    }
                }

                let t = (title && title.trim()) ? title.trim() : (defaultTitle || '');
                if (!t) return '';

                // Jika title masih memuat baris ganda / newline, gabungkan dengan spasi agar judul tidak terpotong
                if (t.includes('\n')) {
                    const lines = t.split('\n').map(l => l.trim()).filter(Boolean);
                    t = lines.join(' ');
                }

                if (t.includes(yLabel)) return t;

                // 1. Cek pola "Tahun Anggaran" atau "Year" tanpa tahun
                if (/\bTahun\s+Anggaran\b(?!\s+(?:19|20)\d{2})/i.test(t)) {
                    return t.replace(/\b(Tahun\s+Anggaran)\b/i, `$1 ${yLabel}`);
                }
                if (/\bYear\b(?!\s+(?:19|20)\d{2})/i.test(t)) {
                    return t.replace(/\b(Year)\b/i, `$1 ${yLabel}`);
                }

                // 2. Cek jika ada nama bulan sebelum tahun (misal: "Desember 2021" atau "December 2021")
                const monthYearPattern = /\b(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|May|June|July|August|October|December)\s+(19|20)\d{2}\b/i;
                if (monthYearPattern.test(t)) {
                    return t.replace(monthYearPattern, (m, month) => `${month} ${yLabel}`);
                }

                // 2. Cek tahun atau rentang tahun di akhir judul
                const yearPattern = /(,\s*|\s+)(19|20)\d{2}(\s*[–\-]\s*(19|20)\d{2})?\s*$/;
                if (yearPattern.test(t)) {
                    return t.replace(yearPattern, (match, prefix) => `${prefix}${yLabel}`);
                }

                // 3. Cek tahun 4 digit standalone di dalam judul (bukan di dalam format tahun ajaran bertanda /)
                const standaloneYearPattern = /(?<!\/)\b(19|20)\d{2}\b(?!\/)/;
                if (standaloneYearPattern.test(t)) {
                    return t.replace(standaloneYearPattern, yLabel);
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

            updateYearSwitcher(Boolean(schema.isMultiYear || currentTableCode === '8.2.2'), Boolean(schema.isExcludeSelectedYear));
            updateTableSwitcher();

            const tableEl = document.getElementById('dataDisplayTable');
            
            // Sanity check serverDbMetadata: pastikan metadata server sesuai dengan currentYear
            if (serverDbMetadata && serverDbMetadata.year && serverDbMetadata.year.toString() !== currentYear.toString()) {
                serverDbMetadata = null;
            }

            // Check if table data was edited in dedicated edit page or generated from Excel
            // Prioritaskan localStorage jika ada status tersimpan lokal (simonda_table_is_saved)
            const scopedHtmlKey = getStorageKey('simonda_table_html');
            const scopedSavedKey = getStorageKey('simonda_table_is_saved');
            const localSavedHtml = localStorage.getItem(scopedHtmlKey);
            const isLocallySaved = (localStorage.getItem(scopedSavedKey) === '1');
            let savedHtml = (serverDbMetadata && serverDbMetadata.table_html && serverDbMetadata.table_html.includes('<tr'))
                ? serverDbMetadata.table_html
                : ((isLocallySaved && localSavedHtml && localSavedHtml.includes('<tr')) ? localSavedHtml : null);
            if (savedHtml) savedHtml = cleanHtmlYearRanges(savedHtml);

            // Sterilisasi: Bersihkan seluruh tag <input> yang mungkin pernah tersimpan di savedHtml
            if (savedHtml && savedHtml.includes('<input')) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                tempDiv.querySelectorAll('input, .table-edit-input').forEach(inp => {
                    const val = (inp.value !== undefined ? inp.value : inp.getAttribute('value') || '').trim();
                    const parent = inp.closest('td, th') || inp.parentNode;
                    if (parent) {
                        parent.innerHTML = val;
                    }
                });
                savedHtml = tempDiv.innerHTML;
                safeSetLocalStorage(scopedHtmlKey, savedHtml);
            }

            // Sanity check: jika savedHtml rusak atau tidak mengandung struktur <tr> dan <th>, bersihkan
            if (savedHtml && (!savedHtml.includes('<tr') || !savedHtml.includes('<th'))) {
                removeScopedLocalStorageItem('simonda_table_html');
                removeScopedLocalStorageItem('simonda_table_is_saved');
                savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
            }

            // Sanity check: jika savedHtml adalah starter dummy placeholder ("Indikator 1" / "Indicator Details" / "Belum ada data")
            if (savedHtml && (savedHtml.includes('Indicator Details') || (savedHtml.includes('Indikator 1') && savedHtml.includes('Rincian Indikator')) || savedHtml.includes('Belum ada data untuk tabel ini'))) {
                removeScopedLocalStorageItem('simonda_table_html');
                removeScopedLocalStorageItem('simonda_table_is_saved');
                savedHtml = null;
            }

            if (savedHtml && currentTableCode === '2.4.2') {
                savedHtml = savedHtml.replace(/Jenis Pendapatan/gi, 'Jenis Belanja');
                savedHtml = savedHtml.replace(/Kind of Revenues/gi, 'Kind of Expenditures');
            }

            // Self-healing tabel 5.1.15, 5.1.16, 5.1.17: pulihkan nilai desimal dari serial-hour conversion
            if (savedHtml && (currentTableCode === '5.1.15' || currentTableCode === '5.1.16' || currentTableCode === '5.1.17')) {
                if (savedHtml.includes('212,10') || savedHtml.includes('105,22')) {
                    savedHtml = savedHtml.replace(/212,10/g, '8,84').replace(/105,22/g, '4,39');
                    safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                }
            }

            // Self-healing tabel 5.1.16: pastikan thead selalu bilingual (Maize, Peanuts, dll) dan lebar kolom lega
            if (currentTableCode === '5.1.16' && savedHtml) {
                if (!savedHtml.includes('Maize') || !savedHtml.includes('Peanuts')) {
                    const tempTable = document.createElement('table');
                    tempTable.innerHTML = savedHtml;
                    const schemaHtml = tableSchemas['5.1.16'] ? tableSchemas['5.1.16'].render(currentYear) : '';
                    if (schemaHtml) {
                        const tempSchema = document.createElement('table');
                        tempSchema.innerHTML = schemaHtml;
                        const newThead = tempSchema.querySelector('thead');
                        const oldThead = tempTable.querySelector('thead');
                        if (newThead && oldThead) {
                            oldThead.replaceWith(newThead);
                            tempTable.querySelectorAll('tbody td').forEach(td => {
                                if (td.colSpan >= 2) {
                                    td.classList.add('min-w-[200px]');
                                } else {
                                    td.classList.add('min-w-[110px]');
                                }
                            });
                            savedHtml = tempTable.innerHTML;
                            safeSetLocalStorage(scopedHtmlKey, savedHtml);
                            if (serverDbMetadata) {
                                serverDbMetadata.table_html = savedHtml;
                            }
                        }
                    }
                }
            }

            // Self-healing tabel 9.4, 5.1.18 & tabel kecamatan: pastikan Kolom 6 selalu diganti dengan Aur Birugo Tigo Baleh
            if (savedHtml && (savedHtml.includes('Kolom 6') || savedHtml.includes('kolom 6'))) {
                                // Self-healing tabel 1.1.8 (Kantor Pertanahan): Bersihkan cache lokal jika format lama 3 kolom atau rentang tahun salah
                if (currentTableCode === '1.1.8' && savedHtml) {
                    if (savedHtml.includes('w-[60%]') || !savedHtml.includes('(7)') || !savedHtml.includes(currentYear.toString())) {
                        localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                        localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                        localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    }
                }
                                if (currentTableCode === '2.2.2' || savedHtml.includes('Partai') || savedHtml.includes('Pendidikan')) {
                    savedHtml = savedHtml.replace(/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/gi, '<th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>')
                                         .replace(/<th([^>]*)>\s*Kolom\s*6\s*<\/th>/gi, '<th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>')
                                         .replace(/>\s*Kolom\s*6\s*</gi, '>S2/S3<')
                                         .replace(/Kolom\s*6/gi, 'S2/S3');
                    safeSetLocalStorage(scopedHtmlKey, savedHtml);
                    safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                } else if (currentTableCode === '4.2.11' || savedHtml.includes('Golongan Darah') || savedHtml.includes('Donatur Darah')) {
                    savedHtml = savedHtml.replace(/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/gi, '<th class="py-3 px-4 font-bold border border-slate-700"><div>AB</div></th>')
                                         .replace(/Kolom\s*6/gi, 'AB');
                    safeSetLocalStorage(scopedHtmlKey, savedHtml);
                    safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                } else if (['9.4', '5.1.18'].includes(currentTableCode) || savedHtml.includes('Mandiangin') || savedHtml.includes('Guguk Panjang')) {
                    savedHtml = savedHtml.replace(/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/gi, '<th class="py-3 px-4 font-bold border border-slate-700"><div>Aur Birugo Tigo Baleh</div></th>')
                                         .replace(/<th([^>]*)>\s*Kolom\s*6\s*<\/th>/gi, '<th$1>Aur Birugo Tigo Baleh</th>')
                                         .replace(/>\s*Kolom\s*6\s*</gi, '>Aur Birugo Tigo Baleh<');
                    safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                }
            }

            // Self-healing tabel 9.1: baris ke-4 adalah Bukittinggi (bukan Jumlah / Total)
            if (currentTableCode === '9.1' && savedHtml && (savedHtml.includes('Jumlah') || savedHtml.includes('Total'))) {
                savedHtml = savedHtml.replace(/Jumlah\s*\/\s*<span[^>]*>Total<\/span>/gi, 'Bukittinggi')
                                     .replace(/Jumlah\s*\/\s*Total/gi, 'Bukittinggi')
                                     .replace(/<td([^>]*)>\s*Jumlah\s*<\/td>/gi, '<td$1>Bukittinggi</td>');
                safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
            }

            // Self-healing tabel 4.3.3: hilangkan baris Catatan dari tbody dan rapikan nama kecamatan
            if (currentTableCode === '4.3.3' && savedHtml) {
                if (savedHtml.includes('Transmigrasi') || savedHtml.includes('pencacahan') || savedHtml.includes('Catatan')) {
                    const tempTable = document.createElement('table');
                    tempTable.innerHTML = savedHtml;
                    const rowsToRemove = [];
                    tempTable.querySelectorAll('tbody tr').forEach(tr => {
                        const txt = tr.textContent;
                        if (txt.includes('Catatan') || txt.includes('Transmigrasi') || txt.includes('pencacahan') || txt.includes('Periode tahun')) {
                            rowsToRemove.push(tr);
                        }
                    });
                    rowsToRemove.forEach(tr => tr.remove());
                    savedHtml = tempTable.innerHTML;
                    savedHtml = savedHtml.replace(/Aur Birugo Tigo baleh/g, 'Aur Birugo Tigo Baleh');
                    safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                }
            }

            // Self-healing tabel 5.2.1 & 5.2.2: pastikan HANYA 4 komoditi resmi (Kelapa Sawit, Kelapa, Karet, Kopi) dengan 9 kolom total (1 s.d 9)
            if ((currentTableCode === '5.2.1' || currentTableCode === '5.2.2') && savedHtml) {
                const hasExtraCrops = savedHtml.includes('Kulit Manis') || savedHtml.includes('Cassiavera') ||
                                      savedHtml.includes('Cengkeh') || savedHtml.includes('Clove') ||
                                      savedHtml.includes('Pala') || savedHtml.includes('Nutmeg') ||
                                      savedHtml.includes('Pinang') || savedHtml.includes('Areca Nut') ||
                                      savedHtml.includes('Tebu') || savedHtml.includes('Sugar Cane') ||
                                      savedHtml.includes('Kakao') || savedHtml.includes('Cocoa') ||
                                      savedHtml.includes('(10)') || savedHtml.includes('(21)');
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const headerThs = tempDiv.querySelectorAll('thead tr:last-child th');
                if (hasExtraCrops || headerThs.length !== 9) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = (tableSchemas[currentTableCode]) ? tableSchemas[currentTableCode].render(currentYear) : null;
                }
            }

            // Auto-repair header tabel 5.4.2 (Petani Ikan Darat: Sewaktu-waktu/Sometime & Kolom (5))
            if (currentTableCode === '5.4.2' && savedHtml) {
                if (savedHtml.includes('colspan="2"><div>Sewaktu-waktu</div>') || savedHtml.includes('(6)</th>') || !savedHtml.includes('Sometime')) {
                    savedHtml = savedHtml.replace(/<th([^>]*?)colspan=[\'"]?2[\'"]?([^>]*?)>\s*<div>Sewaktu-waktu<\/div>\s*<\/th>/gi, '<th$1$2><div>Sewaktu-waktu</div><div class="italic font-normal text-[11px] sm:text-xs">Sometime</div></th>')
                                         .replace(/colspan="2"><div>Sewaktu-waktu<\/div>/gi, '><div>Sewaktu-waktu</div><div class="italic font-normal text-[11px] sm:text-xs">Sometime</div>')
                                         .replace(/<th([^>]*?)>\s*\(6\)\s*<\/th>/gi, '<th$1>(5)</th>');
                    safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                }
            }

            // Self-healing tabel 9.11 (Dinas Pertanian - Rata-rata 5 tahun berjalan)
            if (currentTableCode === '9.11' && savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const ratarataCell = Array.from(tempDiv.querySelectorAll('td')).find(td => td.innerText.trim().toLowerCase().includes('rata-rata') || td.innerText.trim().toLowerCase().includes('average'));
                if (ratarataCell) {
                    const yr = parseInt(currentYear) || 2026;
                    let currentRow = ratarataCell.parentElement;
                    let tbody = currentRow.parentElement;
                    let isCorruptYears = false;

                    const histAverages = {
                        2025: ['9.750', '41.500', '256.667', '-', '32.917'],
                        2024: ['6.417', '34.833', '190.833', '-', '32.000'],
                        2023: ['6.083', '31.375', '173.333', '-', '26.833'],
                        2022: ['6.433', '30.125', '166.667', '-', '31.625'],
                        2021: ['5.791', '29.875', '162.083', '53.916', '29.083'],
                        2020: ['5.889', '29.722', '160.000', '60.000', '28.333'],
                        2019: ['4.917', '28.583', '150.000', '60.000', '25.833']
                    };
                    const colCount = 5;

                    if (ratarataCell.getAttribute('rowspan') !== '5') {
                        ratarataCell.setAttribute('rowspan', '5');
                        isCorruptYears = true;
                    }

                    // Kumpulkan baris-baris setelah Rata-rata
                    let subsequentRows = [];
                    let r = currentRow.nextElementSibling;
                    while (r) {
                        subsequentRows.push(r);
                        r = r.nextElementSibling;
                    }

                    while (subsequentRows.length < 4) {
                        const newTr = document.createElement('tr');
                        newTr.className = 'hover:bg-amber-100/60 transition-colors';
                        tbody.appendChild(newTr);
                        subsequentRows.push(newTr);
                        isCorruptYears = true;
                    }

                    for (let i = 0; i < 5; i++) {
                        const expectedY = (yr - i).toString();
                        const known = histAverages[yr - i];
                        const targetRow = (i === 0) ? currentRow : subsequentRows[i - 1];
                        if (!targetRow) break;

                        const tds = targetRow.querySelectorAll('td');
                        const yearTd = (i === 0) ? tds[1] : tds[0];
                        if (yearTd && yearTd.innerText.trim() !== expectedY) {
                            isCorruptYears = true;
                            yearTd.innerText = expectedY;
                        }

                        // Isi nilai historis jika sel masih kosong/strip atau corrupt
                        for (let c = 0; c < colCount; c++) {
                            const valTd = (i === 0) ? tds[2 + c] : tds[1 + c];
                            if (valTd) {
                                const curVal = valTd.innerText.trim();
                                if (known && (curVal === '-' || curVal === '')) {
                                    valTd.innerText = known[c];
                                    isCorruptYears = true;
                                }
                            } else if (i > 0) {
                                const newTd = document.createElement('td');
                                newTd.innerText = known ? known[c] : '-';
                                newTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top text-center align-middle';
                                targetRow.appendChild(newTd);
                                isCorruptYears = true;
                            }
                        }
                    }

                    // Hapus baris siluman berlebih jika > 4 baris setelah Rata-rata
                    if (subsequentRows.length > 4) {
                        for (let k = 4; k < subsequentRows.length; k++) {
                            subsequentRows[k].remove();
                        }
                        isCorruptYears = true;
                    }

                    if (isCorruptYears) {
                        savedHtml = tempDiv.innerHTML;
                        safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                        if (serverDbMetadata) {
                            serverDbMetadata.table_html = savedHtml;
                        }
                    }
                }
            }

            // Self-healing tabel pariwisata 7.3, 7.4, 7.5 (Dinas Pariwisata - Jumlah 5 tahun berjalan)
            if (['7.3', '7.4', '7.5'].includes(currentTableCode) && savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const jumlahCell = Array.from(tempDiv.querySelectorAll('td')).find(td => td.innerText.trim().toLowerCase().includes('jumlah') || td.innerText.trim().toLowerCase().includes('total'));
                if (jumlahCell) {
                    const yr = parseInt(currentYear) || 2026;
                    let currentRow = jumlahCell.parentElement;
                    let tbody = currentRow.parentElement;
                    let isCorruptYears = false;

                    const histTotals = {
                        '7.3': {
                            2025: ['750.821', '17.768.964'],
                            2024: ['604.541', '14.472.272'],
                            2023: ['820.943', '19.536.206'],
                            2022: ['991.632', '24.205.697'],
                            2021: ['618.049', '14.876.991'],
                            2020: ['363.045', '8.746.437'],
                            2019: ['729.705', '10.620.300']
                        },
                        '7.4': {
                            2025: ['175.214', '3.360.118'],
                            2024: ['160.099', '3.085.615'],
                            2023: ['220.525', '3.170.210'],
                            2022: ['236.449', '3.440.474'],
                            2021: ['131.873', '1.860.079']
                        },
                        '7.5': {
                            2025: ['45.094'],
                            2024: ['35.303'],
                            2023: ['19.390'],
                            2022: ['491'],
                            2021: ['17'],
                            2020: ['2.337'],
                            2019: ['32.653']
                        }
                    };
                    const colCount = currentTableCode === '7.5' ? 1 : 2;

                    // Pastikan rowspan Jumlah adalah 5
                    if (jumlahCell.getAttribute('rowspan') !== '5') {
                        jumlahCell.setAttribute('rowspan', '5');
                        isCorruptYears = true;
                    }

                    // Khusus 7.5 bersihkan 1926 pada baris Belanda jika currentYear >= 2026
                    if (currentTableCode === '7.5' && yr >= 2026) {
                        tempDiv.querySelectorAll('tbody tr').forEach(tr => {
                            if (tr.innerText.includes('Belanda') || tr.innerText.includes('Netherland')) {
                                const tds = tr.querySelectorAll('td');
                                if (tds.length >= 2 && tds[tds.length - 1].innerText.trim() === '1926') {
                                    tds[tds.length - 1].innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                                    isCorruptYears = true;
                                }
                            }
                        });
                    }

                    // Kumpulkan baris-baris setelah Jumlah
                    let subsequentRows = [];
                    let r = currentRow.nextElementSibling;
                    while (r) {
                        subsequentRows.push(r);
                        r = r.nextElementSibling;
                    }

                    // Jika jumlah baris setelah Jumlah < 4 (misal tabel 7.4 sebelumnya cuma 3 baris), tambahkan baris ke-4 (tahun ke-5)
                    while (subsequentRows.length < 4) {
                        const newTr = document.createElement('tr');
                        newTr.className = 'hover:bg-amber-100/60 transition-colors';
                        tbody.appendChild(newTr);
                        subsequentRows.push(newTr);
                        isCorruptYears = true;
                    }

                    for (let i = 0; i < 5; i++) {
                        const expectedY = (yr - i).toString();
                        const known = histTotals[currentTableCode] && histTotals[currentTableCode][yr - i];
                        const targetRow = (i === 0) ? currentRow : subsequentRows[i - 1];
                        if (!targetRow) break;

                        const tds = targetRow.querySelectorAll('td');
                        const yearTd = (i === 0) ? tds[1] : tds[0];
                        if (yearTd && yearTd.innerText.trim() !== expectedY) {
                            isCorruptYears = true;
                            yearTd.innerText = expectedY;
                        }

                        // Isi nilai historis jika sel masih kosong/strip atau corrupt
                        for (let c = 0; c < colCount; c++) {
                            const valTd = (i === 0) ? tds[2 + c] : tds[1 + c];
                            if (valTd) {
                                const curVal = valTd.innerText.trim();
                                if (known && (curVal === '-' || curVal === '')) {
                                    valTd.innerText = known[c];
                                    isCorruptYears = true;
                                }
                            } else if (i > 0) {
                                const newTd = document.createElement('td');
                                newTd.innerText = known ? known[c] : '-';
                                newTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top text-center align-middle';
                                targetRow.appendChild(newTd);
                                isCorruptYears = true;
                            }
                        }
                    }

                    // Hapus baris siluman berlebih jika > 4 baris setelah Jumlah
                    if (subsequentRows.length > 4) {
                        for (let k = 4; k < subsequentRows.length; k++) {
                            subsequentRows[k].remove();
                        }
                        isCorruptYears = true;
                    }

                    if (isCorruptYears) {
                        savedHtml = tempDiv.innerHTML;
                        safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                        if (serverDbMetadata) {
                            serverDbMetadata.table_html = savedHtml;
                        }
                    }
                }
            }

            // Validasi savedHtml untuk tabel multi-tahun (8.1.1, 8.1.2, 8.1.3, 8.1.4, 8.1.5, 8.2.2, 2.2.5, 1.1.10 atau schema.isMultiYear)
            const isMultiYearTable = Boolean(schema && (schema.isMultiYear || schema.isExcludeSelectedYear)) || 
                                     ['8.1.1', '8.1.2', '8.1.3', '8.1.4', '8.1.5', '8.1.6', '8.2.2', '2.2.5', '1.1.10', '9.1', '9.3', '2.4.3', '2.4.1', '2.4.2', '5.2.1', '5.2.2'].includes(currentTableCode);

            if (!isLocallySaved && isMultiYearTable && savedHtml && !['8.1.4', '8.1.5', '8.1.6', '1.1.10', '4.2.4', '4.2.5', '4.2.7', '4.2.9', '4.2.10', '4.2.13', '4.2.15', '4.2.16'].includes(currentTableCode)) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const allThs = Array.from(tempDiv.querySelectorAll('thead th'));
                const yrInt = parseInt(currentYear) || 2025;
                const pTable = getTablePeriod(yrInt, currentTableCode);
                const expectedStartYear = pTable.start.toString();
                const expectedEndYear = yrInt.toString();
                const hasStartYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedStartYear));
                const hasEndYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedEndYear));
                const firstRowTds = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td') : [];
                const minCols = (currentTableCode === '4.1.20') ? 5 : 6;
                const isMissingCells = firstRowTds.length > 0 && firstRowTds.length < minCols;

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

            // Reset cache jika tabel 1.1.6 rusak / plain text / format terpotong
            if (currentTableCode === '1.1.6' && savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const thCount = tempDiv.querySelectorAll('thead th').length;
                const bodyRows = tempDiv.querySelectorAll('tbody tr');
                const hasTambuo = savedHtml.includes('Batang Tambuo') || savedHtml.includes('Tambuo');
                if (thCount < 4 || bodyRows.length < 2 || !hasTambuo || !savedHtml.includes('<tbody')) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = (tableSchemas['1.1.6']) ? tableSchemas['1.1.6'].render(currentYear) : null;
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
                const tempDiv = document.createElement('table');
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
                const tempDiv = document.createElement('table');
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
                const tempDiv = document.createElement('table');
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

            // Self-healing tabel 4.1.2 (Kemenag - RA): 2 tahun ajaran berjalan
            if (currentTableCode === '4.1.2' && savedHtml) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedY1 = `${yrInt - 1}/${yrInt}`;
                const expectedY2 = `${yrInt}/${yrInt + 1}`;
                if (/\b\d{4}\s*\/\s*\d{4}\b/.test(savedHtml)) {
                    let scIdx = 0;
                    savedHtml = savedHtml.replace(/\b\d{4}\s*\/\s*\d{4}\b/g, () => {
                        const col = scIdx % 2;
                        scIdx++;
                        return col === 0 ? expectedY1 : expectedY2;
                    });
                    safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    safeSetLocalStorage(scopedHtmlKey, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                }
            }

            // Self-healing tabel sekolah (Dinas Pendidikan 4.1.1, 4.1.3 s.d. 4.1.17): pastikan thead selalu urut [yr-2/yr-1, yr-1/yr, yr/yr+1]
            const schoolEducationCodes = ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'];
            if (schoolEducationCodes.includes(currentTableCode) && savedHtml) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedY1 = `${yrInt - 2}/${yrInt - 1}`;
                const expectedY2 = `${yrInt - 1}/${yrInt}`;
                const expectedY3 = `${yrInt}/${yrInt + 1}`;
                const hasCorruptYears = savedHtml.includes('2023/2026') || savedHtml.includes('2026/2025') || savedHtml.includes('2023/2025');
                const hasExpectedLatest = savedHtml.includes(expectedY3);

                if (hasCorruptYears || !hasExpectedLatest) {
                    if (/\b\d{4}\s*\/\s*\d{4}\b/.test(savedHtml)) {
                        let scIdx = 0;
                        savedHtml = savedHtml.replace(/\b\d{4}\s*\/\s*\d{4}\b/g, () => {
                            const col = scIdx % 3;
                            scIdx++;
                            if (col === 0) return expectedY1;
                            if (col === 1) return expectedY2;
                            return expectedY3;
                        });
                        safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    }
                }
            }

            // Validasi umum: jika baris data memiliki sel lebih sedikit daripada kolom header (tabel terpotong)
            if (savedHtml && !['5.1.15', '5.1.16', '5.1.17', '1.1.6'].includes(currentTableCode)) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                let headerColSpan = 0;
                tempDiv.querySelectorAll('thead tr:last-child th').forEach(th => headerColSpan += (th.colSpan || 1));
                let firstRowColSpan = 0;
                if (tempDiv.querySelector('tbody tr')) {
                    tempDiv.querySelector('tbody tr').querySelectorAll('td').forEach(td => firstRowColSpan += (td.colSpan || 1));
                }
                if (headerColSpan > 0 && firstRowColSpan > 0 && firstRowColSpan < headerColSpan) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

            // Sanity check untuk Tabel 8.1.1: Jika sel data (selain kolom 0) berisi nama baris/kategori
            // (seperti "1. Negara" atau "2. Provinsi" atau "3. Kota"), berarti HTML korup akibat salah geser kolom
            if (savedHtml) {
                const tempDiv = document.createElement('table');
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

                if (serverDbFallbackMetadata && serverDbFallbackMetadata.table_html && !serverDbFallbackMetadata.table_html.includes('Belum ada data untuk tabel ini') && !serverDbFallbackMetadata.table_html.includes('Indicator Details')) {
                    sourceHtml = serverDbFallbackMetadata.table_html;
                    sourceYr = serverDbFallbackMetadata.year;
                }

                if (!sourceHtml) {
                    const checkYears = [2025, 2024, 2023, 2022, 2021, 2026, 2027, 2028, 2029, 2030, 2020, 2019, 2018];
                    for (let y of checkYears) {
                        if (y.toString() === currentYear.toString()) continue;
                        const localKey = `simonda_table_html_${currentTableCode}_${y}`;
                        const localHtml = localStorage.getItem(localKey);
                        if (localHtml && !localHtml.includes('Belum ada data untuk tabel ini') && !localHtml.includes('Indicator Details') && !(localHtml.includes('Indikator 1') && localHtml.includes('Rincian Indikator'))) {
                            sourceHtml = localHtml;
                            sourceYr = y;
                            break;
                        }
                    }
                }

                if (sourceHtml && !sourceHtml.includes('Belum ada data untuk tabel ini')) {
                    savedHtml = buildEmptyTemplateFromSource(sourceHtml, currentYear, sourceYr);
                    isInheritedTemplate = true;
                    try {
                        safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                        safeSetLocalStorage(`simonda_table_source_${currentTableCode}_${currentYear}`, 'template');
                    } catch(e) {}
                }
            }

            if (savedHtml) {
                tableEl.innerHTML = cleanHtmlYearRanges(savedHtml);
            } else {
                tableEl.innerHTML = cleanHtmlYearRanges(schema.render(currentYear));
            }

            // Jaminan Keamanan: Halaman utama (index.blade.php) adalah tampilan publikasi 100% read-only.
            // Konversi seluruh elemen <input> yang ada di dalam tabel menjadi teks statis murni.
            tableEl.querySelectorAll('input, .table-edit-input').forEach(inp => {
                if (inp.type === 'file' || inp.type === 'hidden') return;
                const val = (inp.value !== undefined ? inp.value : inp.getAttribute('value') || '').trim();
                const parent = inp.closest('td, th') || inp.parentNode;
                if (parent) {
                    parent.innerHTML = val;
                }
            });

            cleanGhostColumns(tableEl);
            cleanGhostRows(tableEl);

            // Jaminan header 2.2.2: Kolom ke-5 adalah S2/S3 (bukan Kolom 6)
            if (currentTableCode === '2.2.2' || (tableEl && (tableEl.innerText.includes('Partai') || tableEl.innerText.includes('Pendidikan')))) {
                tableEl.querySelectorAll('thead th').forEach(th => {
                    if (/kolom\s*6/i.test(th.innerText.trim())) {
                        th.innerHTML = '<div>S2/S3</div>';
                    }
                });
            }
            if (currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) {
                tableEl.querySelectorAll('thead th').forEach(th => {
                    if (/kolom\s*6/i.test(th.innerText.trim())) {
                        th.innerHTML = '<div>AB</div>';
                    }
                });
            }

            // Atur lebar tabel agar proporsional, panjang, dan tidak sempit
            if (currentTableCode === '5.1.16' || currentTableCode === '5.1.17') {
                tableEl.style.minWidth = '1600px';
                tableEl.classList.add('table-auto');
            } else if (currentTableCode === '5.2.1' || currentTableCode === '5.2.2') {
                tableEl.style.minWidth = '1100px';
                tableEl.classList.add('table-auto');
            } else if (currentTableCode === '5.1.15') {
                tableEl.style.minWidth = '1100px';
                tableEl.classList.add('table-auto');
            } else {
                tableEl.style.minWidth = '';
            }

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

                // Pastikan kolom No selalu bernomor 1 dan 2 per sungai (restart untuk setiap sungai)
                const trs = tableEl.querySelectorAll('tbody tr');
                let currentNo = 1;
                trs.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 4) {
                        // Baris awal sungai baru (Tambuo baris 1, Sianok baris 1)
                        currentNo = 1;
                        tds[2].innerHTML = '1';
                        tds[2].className = 'py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800';
                        currentNo = 2;
                    } else if (tds.length >= 2) {
                        // Baris lanjutan sungai yang sama (Tambuo baris 2, Sianok baris 2)
                        tds[0].innerHTML = currentNo.toString();
                        tds[0].className = 'py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800';
                        currentNo++;
                    }
                });
            }

            // Khusus Tabel 4.1.2 (Kemenag - RA): 2 Tahun Ajaran Berjalan
            if (currentTableCode === '4.1.2') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedY1 = `${yrInt - 1}/${yrInt}`;
                const expectedY2 = `${yrInt}/${yrInt + 1}`;
                const validAcadYears = [expectedY1, expectedY2];

                const theadThs = tableEl.querySelectorAll('thead th');
                let thAcadIdx = 0;
                theadThs.forEach(th => {
                    if (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(th.innerText)) {
                        const correctYr = validAcadYears[thAcadIdx % 2];
                        thAcadIdx++;
                        th.innerHTML = `<div>${correctYr}</div>`;
                    }
                });
            }

            // Khusus Tabel Dinas 08 / Tabel 4.1.x (Tabel 3-in-1: Sekolah, Guru, Murid)
            const isEducation3in1 = ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'].includes(currentTableCode);
            if (isEducation3in1) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedY1 = `${yrInt - 2}/${yrInt - 1}`;
                const expectedY2 = `${yrInt - 1}/${yrInt}`;
                const expectedY3 = `${yrInt}/${yrInt + 1}`;
                const validAcadYears = [expectedY1, expectedY2, expectedY3];

                // 1. Enforce urutan tahun ajaran di thead
                const theadThs = tableEl.querySelectorAll('thead th');
                let thAcadIdx = 0;
                theadThs.forEach(th => {
                    if (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(th.innerText)) {
                        const correctYr = validAcadYears[thAcadIdx % 3];
                        thAcadIdx++;
                        th.innerHTML = `<div>${correctYr}</div>`;
                    }
                });

                const trs = tableEl.querySelectorAll('tbody tr');
                trs.forEach(tr => {
                    const text = tr.innerText.trim();
                    const tds = tr.querySelectorAll('td, th');
                    
                    // Cek jika baris adalah baris pemisah / gap antar sub-tabel
                    if (tr.classList.contains('subtable-spacer-row') || (tds.length === 1 && (tds[0].getAttribute('colspan') >= 8 || tds[0].colSpan >= 8))) {
                        tr.className = 'subtable-spacer-row pointer-events-none select-none';
                        tds[0].className = 'h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center';
                        tds[0].innerHTML = '&nbsp;';
                        return;
                    }

                    const firstCellText = (tds[0] ? tds[0].innerText.trim() : '');
                    const isDistrictRow = /^\s*0?\d\./.test(firstCellText) || 
                                          firstCellText.includes('Guguk') || 
                                          firstCellText.includes('Mandiangin') || 
                                          firstCellText.includes('Aur Birugo');
                    const isTotalRow = firstCellText === 'Bukittinggi' || firstCellText.startsWith('Bukittinggi');

                    if (text.includes('Guru') || text.includes('Teachers') || text.includes('Murid') || text.includes('Students')) {
                        // Pastikan ada baris pemisah / gap setidaknya 1 spasi sebelum header sub-tabel
                        const prevTr = tr.previousElementSibling;
                        if (prevTr && !prevTr.classList.contains('subtable-spacer-row')) {
                            const spacer = document.createElement('tr');
                            spacer.className = 'subtable-spacer-row pointer-events-none select-none';
                            spacer.innerHTML = '<td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>';
                            tr.parentNode.insertBefore(spacer, tr);
                        }

                        tr.className = 'bg-[#f95a00] text-white text-center font-bold subtable-header-title';
                        tds.forEach(td => {
                            td.className = 'py-2.5 px-3 font-bold border border-slate-700 text-center align-middle';
                            if ((td.innerText.includes('Guru') || td.innerText.includes('Murid')) && !td.querySelector('.italic')) {
                                const isGuru = td.innerText.includes('Guru');
                                td.innerHTML = isGuru 
                                    ? '<div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>'
                                    : '<div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>';
                            } else if (td.innerText.includes('Kecamatan') && !td.querySelector('.italic')) {
                                td.innerHTML = '<div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>';
                            } else if (td.innerText.includes('Jumlah') && !td.querySelector('.italic')) {
                                td.innerHTML = '<div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>';
                            }
                        });
                    } else if (text.includes('Negeri') || text.includes('Swasta') || text.includes('Public') || text.includes('Private')) {
                        tr.className = 'bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle';
                        tds.forEach(td => {
                            td.className = 'py-2 px-3 font-bold border border-slate-700 text-center align-middle';
                            if (td.innerText.includes('Negeri') && !td.querySelector('.italic')) {
                                td.innerHTML = '<div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>';
                            } else if (td.innerText.includes('Swasta') && !td.querySelector('.italic')) {
                                td.innerHTML = '<div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>';
                            }
                        });
                    } else if (!isDistrictRow && !isTotalRow && /\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(text) && tds.length >= 6) {
                        tr.className = 'bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years';
                        let subAcadIdx = 0;
                        tds.forEach(td => {
                            td.className = 'py-1.5 px-2 font-bold border border-slate-700 text-center align-middle text-xs';
                            if (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(td.innerText)) {
                                const correctYr = validAcadYears[subAcadIdx % 3];
                                subAcadIdx++;
                                td.innerHTML = `<div>${correctYr}</div>`;
                            }
                        });
                    } else if (text.includes('-1') || text.includes('(1)') || (tds.length === 10 && (tds[0].innerText.trim() === '-1' || tds[0].innerText.trim() === '(1)'))) {
                        tr.className = 'bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering';
                        tds.forEach((td, idx) => {
                            td.className = 'py-1 px-2 border border-slate-700 text-center font-bold text-xs';
                            td.innerText = `(${idx + 1})`;
                        });
                    } else if (isTotalRow) {
                        tr.className = 'bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700 hover:bg-amber-200/60 transition-colors';
                        tds.forEach((td, idx) => {
                            td.classList.add('font-bold');
                            if (idx === 0) td.className = 'py-2.5 px-4 border border-slate-700 text-left font-bold align-middle';
                            else td.className = 'py-2.5 px-3 border border-slate-700 text-center font-bold align-middle';
                        });
                    } else if (isDistrictRow) {
                        tr.className = 'hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium';
                        tds.forEach((td, idx) => {
                            if (idx === 0) {
                                td.className = 'py-2 px-4 border border-slate-700 text-left font-semibold align-middle';
                            } else {
                                td.className = 'py-2 px-3 border border-slate-700 text-center align-middle';
                            }
                        });
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

            // Muat data catatan & komentar rincian data tabel
            if (typeof fetchTableComments === 'function') {
                fetchTableComments();
            }
        }

        function cleanGhostColumns(table) {
            if (!table) return;
            // JANGAN PERNAH potong kolom pada Tabel 1.1.6, 8.1.x, atau tabel multi-tahun
            const schema = (typeof tableSchemas !== 'undefined') ? tableSchemas[currentTableCode] : null;
            if (schema && (schema.isMultiYear || schema.isExcludeSelectedYear)) return;
            if (currentTableCode === '1.1.6' || currentTableCode.startsWith('8.1') || currentTableCode.startsWith('4.1') || currentOpdCode === '08') return;

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
                    safeSetLocalStorage(savedKey, table.innerHTML);
                }
            }
        }

        function cleanGhostRows(table) {
            if (!table) return;
            // JANGAN PERNAH hapus baris data resmi pada tabel Dishub (8.1.x, OPD 20), BPN (1.1.x), BKPSDM (2.3.x), Pendidikan (4.1.x, 08), KPU/DPRD (2.2.2, 02, 03), atau Pertanian (5.1.x, 5.2.x, 9.11)
            if (currentTableCode === '2.2.2' || currentTableCode.startsWith('1.1.') || currentTableCode.startsWith('2.3.') || currentTableCode.startsWith('4.1') || currentTableCode.startsWith('5.1.') || currentTableCode.startsWith('5.2.') || currentTableCode.startsWith('8.1.') || currentTableCode.startsWith('8.2.') || currentTableCode === '9.11' || currentOpdCode === '02' || currentOpdCode === '03' || currentOpdCode === '08' || currentOpdCode === '04' || currentOpdCode === '20' || currentOpdCode === '17') return;
            const tbody = table.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            let removedAny = false;
            rows.forEach(tr => {
                const tds = Array.from(tr.querySelectorAll('td'));
                if (tds.length === 0) return;
                // Baris yang memiliki label teks kategori/indikator di kolom pertama BUKAN baris hantu
                const labelText = tds[0].innerText.trim();
                if (/[a-zA-Z]{2,}/.test(labelText)) {
                    return;
                }
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
                    safeSetLocalStorage(savedKey, table.innerHTML);
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

            safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, tableEl.innerHTML);
            safeSetLocalStorage(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '1');
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
                const res = await fetch(`{{ route('tabel-opd.api.data') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}&type=${typeof currentType !== 'undefined' ? currentType : 'opd'}`);
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
            let url = `{{ route('edit-tabel-opd') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`;
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

        // Format angka BPS: angka < 1.000 jangan pakai titik, angka >= 1.000 pakai titik ribuan, desimal selalu koma (bukan titik)
        function formatBpsNumber(val) {
            if (val === null || val === undefined) return val;
            let str = val.toString().trim();
            if (!str || str === '-' || str === '–' || str === '—') return str;
            if (/[a-zA-Z]/.test(str)) return str;
            if (/^\s*\(\s*\d+\s*\)\s*$/.test(str)) return str;
            if (/^(19|20)\d{2}$/.test(str)) return str;
            if (/^\d+\s*[-–\/]\s*\d+$/.test(str)) return str;

            // Sudah berformat desimal koma standar Indonesia: misal "333,02" atau "1.234,56" atau "207,00"
            if (str.includes(',')) {
                const parts = str.split(',');
                const intPart = parts[0].replace(/\./g, '');
                const decPart = parts.slice(1).join(',');
                const numInt = parseInt(intPart, 10);
                if (isNaN(numInt)) return str;
                let formattedInt = intPart;
                if (Math.abs(numInt) >= 1000) {
                    formattedInt = (intPart.startsWith('-') ? '-' : '') + Math.abs(numInt).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                } else {
                    formattedInt = intPart.startsWith('-') ? '-' + Math.abs(numInt).toString() : Math.abs(numInt).toString();
                }
                return formattedInt + ',' + decPart;
            }

            // Memuat titik: bisa berupa desimal (8.84) atau pemisah ribuan (50.210)
            if (str.includes('.')) {
                const dotCount = (str.match(/\./g) || []).length;
                if (dotCount > 1) {
                    // Lebih dari satu titik: sudah merupakan pemisah ribuan standar BPS, misal 1.500.000
                    return str;
                }
                const parts = str.split('.');
                const left = parts[0];
                const right = parts[1];

                // Desimal jika: digit belakang titik bukan 3 angka ATAU digit depan adalah 0 / -0
                // Contoh: 8.84 (2 digit), 87.4 (1 digit), 0.0034 (4 digit), 0.86 (2 digit)
                if (right.length !== 3 || left === '0' || left === '-0') {
                    const numLeft = parseInt(left.replace(/\./g, ''), 10);
                    if (isNaN(numLeft)) return str;
                    let formattedLeft = left;
                    if (Math.abs(numLeft) >= 1000) {
                        formattedLeft = (left.startsWith('-') ? '-' : '') + Math.abs(numLeft).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    } else {
                        formattedLeft = left.startsWith('-') ? '-' + Math.abs(numLeft).toString() : Math.abs(numLeft).toString();
                    }
                    return formattedLeft + ',' + right;
                }

                // 3 digit di belakang titik pada nilai ribuan BPS (misal 50.210 atau 1.596)
                return str;
            }

            // Bilangan bulat murni tanpa koma dan tanpa titik
            if (/^-?\d+$/.test(str)) {
                const num = parseInt(str, 10);
                if (isNaN(num)) return str;
                if (Math.abs(num) >= 1000) {
                    return (str.startsWith('-') ? '-' : '') + Math.abs(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
                // Nilai di bawah 1.000: TIDAK PAKAI TITIK (misal 417, 100, 54, 0)
                return str;
            }

            return str;
        }

        // ==========================================
        // EXPORT & SPREADSHEET VISUALIZER SUITE
        // ==========================================

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
            const url = `/tabel-opd/export-excel?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&type=${encodeURIComponent(currentType)}&template=1`;
            window.location.href = url;
            if (typeof showToast === 'function') {
                showToast(`📥 Mengunduh template Excel Tabel ${currentTableCode} Tahun ${currentYear}...`);
            }
            return;
        }

        async function handleExcelFileSelected(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (!file) return;

            const loadingEl = document.getElementById('excelUploadLoading');
            if (loadingEl) loadingEl.classList.remove('hidden');

            try {
                const formData = new FormData();
                formData.append('excel_file', file);
                formData.append('table_code', currentTableCode);
                formData.append('opd_code', currentOpdCode);
                formData.append('year', currentYear);
                formData.append('type', currentType);
                formData.append('_token', '{{ csrf_token() }}');

                const response = await fetch('/tabel-opd/import-excel', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    if (typeof showToast === 'function') {
                        showToast('✅ Berhasil mengimpor data menggunakan Laravel Excel!');
                    }
                    if (result.table_html) {
                        try {
                            const scopedHtmlKey = (typeof getStorageKey === 'function') ? getStorageKey('simonda_table_html') : `simonda_table_html_${currentTableCode}_${currentYear}`;
                            const scopedSavedKey = (typeof getStorageKey === 'function') ? getStorageKey('simonda_table_is_saved') : `simonda_table_is_saved_${currentTableCode}_${currentYear}`;
                            safeSetLocalStorage(scopedHtmlKey, result.table_html);
                            safeSetLocalStorage(scopedSavedKey, '1');
                            safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, result.table_html);
                            safeSetLocalStorage(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '1');
                            safeSetLocalStorage(`simonda_table_source_${currentTableCode}_${currentYear}`, 'excel');
                            if (result.title_id && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('simonda_table_title_id'), result.title_id);
                            if (result.title_en && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('simonda_table_title_en'), result.title_en);
                            if (result.source && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('simonda_table_source_text'), result.source);
                            if (result.note && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('simonda_table_note'), result.note);
                        } catch(e) {}
                        const tableEl = document.getElementById('dataDisplayTable');
                        if (tableEl) tableEl.innerHTML = result.table_html;
                    }
                    setTimeout(() => { window.location.reload(); }, 600);
                } else {
                    alert(result.message || 'Gagal mengimpor berkas Excel.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat mengunggah berkas Excel: ' + (err.message || err));
            } finally {
                if (loadingEl) loadingEl.classList.add('hidden');
                event.target.value = '';
            }
            return;
        }

        async function resetTableOriginal() {
            if (!confirm(`Apakah Anda yakin ingin mereset seluruh nilai data Tabel ${currentTableCode} kembali ke data asli resmi BPS?`)) {
                return;
            }

            // 1. Bersihkan seluruh cache localStorage untuk tabel ini
            try {
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (k && (k.includes(`${currentTableCode}_${currentYear}`) || k.includes(`_${currentTableCode}_`) || k.endsWith(`_${currentTableCode}`))) {
                        keysToRemove.push(k);
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
            } catch(e) {}

            // 2. Ambil HTML template resmi BPS jika ada skema
            let defaultHtml = null;
            if (tableSchemas[currentTableCode] && typeof tableSchemas[currentTableCode].render === 'function') {
                try {
                    defaultHtml = tableSchemas[currentTableCode].render(currentYear);
                    if (defaultHtml && defaultHtml.includes('<input')) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = defaultHtml;
                        tempDiv.querySelectorAll('input, .table-edit-input').forEach(inp => {
                            const val = (inp.value !== undefined ? inp.value : inp.getAttribute('value') || '').trim();
                            const parent = inp.closest('td, th') || inp.parentNode;
                            if (parent) {
                                parent.innerHTML = val;
                            }
                        });
                        defaultHtml = tempDiv.innerHTML;
                    }
                } catch(err) {
                    console.error('Error rendering default schema:', err);
                }
            }

            // 3. Panggil API delete/reset ke server
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
                        year: currentYear,
                        type: typeof currentType !== 'undefined' ? currentType : 'opd',
                        default_html: defaultHtml
                    })
                });
            } catch(e) {
                console.error('Reset API error:', e);
            }

            if (serverDbMetadata) {
                serverDbMetadata.table_html = defaultHtml;
                serverDbMetadata.is_saved = false;
                serverDbMetadata.source_type = 'template';
            }

            showToast('🔄 Nilai tabel berhasil dikembalikan ke data awal resmi BPS!');
            setTimeout(() => {
                window.location.reload();
            }, 300);
        }

        // Aliaskan juga resetGeneratedExcel ke resetTableOriginal
        window.resetGeneratedExcel = resetTableOriginal;

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
            const url = `/tabel-opd/export-excel?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&type=${encodeURIComponent(currentType)}`;
            window.location.href = url;
            if (typeof showToast === 'function') {
                showToast(`📥 Mengunduh berkas Excel Tabel ${currentTableCode} Tahun ${currentYear}...`);
            }
            return;
        }

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


        // ==========================================
        // EXPORT & TINDAKAN DROPDOWN TOGGLE HANDLERS
        // ==========================================
        function toggleActionDropdown() {
            const menu = document.getElementById('actionDropdownMenu');
            const chevron = document.getElementById('actionChevron');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            closeAllExportDropdowns();
            if (isHidden) {
                menu.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        }

        function closeActionDropdown() {
            const menu = document.getElementById('actionDropdownMenu');
            const chevron = document.getElementById('actionChevron');
            if (menu) menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }

        document.addEventListener('click', function (e) {
            const actContainer = document.getElementById('actionDropdownContainer');
            const actMenu = document.getElementById('actionDropdownMenu');
            if (actContainer && !actContainer.contains(e.target) && actMenu && !actMenu.contains(e.target)) {
                closeActionDropdown();
            }
        });

        // ==========================================
        // VERIFIKASI & ACC WORKFLOW ACTIONS (ADMIN BPS)
        // ==========================================
        async function handleApproveTable() {
            if (!confirm(`ACC & Kunci Tabel ${currentTableCode} Tahun ${currentYear}?\n\nData ini akan disahkan sebagai data valid BPS untuk publikasi Daerah Dalam Angka (DDA) dan terkunci bagi dinas.`)) {
                return;
            }

            try {
                const res = await fetch('/api/tabel-opd/approve-verification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: currentType
                    })
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Data berhasil di-ACC & dikunci!');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal menyetujui data.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat menyetujui data tabel.');
            }
        }

        function openRevisionModal() {
            const modal = document.getElementById('revisionModal');
            const card = document.getElementById('revisionModalCard');
            const input = document.getElementById('revisionNotesInput');
            if (input) input.value = '';
            if (modal && card) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                    if (input) input.focus();
                }, 50);
            }
        }

        function closeRevisionModal() {
            const modal = document.getElementById('revisionModal');
            const card = document.getElementById('revisionModalCard');
            if (modal && card) {
                card.classList.remove('scale-100', 'opacity-100');
                card.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }
        }

        async function handleRejectTable(event) {
            event.preventDefault();
            const input = document.getElementById('revisionNotesInput');
            const notes = input ? input.value.trim() : '';
            if (!notes) {
                alert('Mohon isi pesan catatan perbaikan untuk dinas.');
                return;
            }

            const btn = document.getElementById('btnSubmitRevision');
            if (btn) btn.disabled = true;

            try {
                const res = await fetch('/api/tabel-opd/reject-verification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: currentType,
                        notes: notes
                    })
                });
                const data = await res.json();
                if (data.success) {
                    closeRevisionModal();
                    showToast('Catatan revisi berhasil dikirim ke dinas.');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal mengirim catatan revisi.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat mengirim catatan revisi.');
            } finally {
                if (btn) btn.disabled = false;
            }
        }

        async function handleUnlockTable() {
            if (!confirm(`Buka Kunci Tabel ${currentTableCode} Tahun ${currentYear}?\n\nDinas akan kembali dapat mengedit angka jika diperlukan perbaikan.`)) {
                return;
            }

            try {
                const res = await fetch('/api/tabel-opd/unlock-table', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear
                    })
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Kunci tabel berhasil dibuka.');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal membuka kunci tabel.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat membuka kunci tabel.');
            }
        }

        // ==========================================
        // FITUR CATATAN / KOMENTAR RINCIAN DATA (DRAWER CHAT)
        // ==========================================
        let activeCellKey = null;
        let activeCellLabel = '';
        let activeCellValue = '';
        let tableCommentsMap = {}; // key: cell_key -> [comments]
        const currentUserData = @json(session('user') ?? ['name' => 'Pengguna', 'role' => 'opd', 'displayName' => 'Pengguna']);

        async function fetchTableComments() {
            try {
                const res = await fetch(`{{ route('tabel-opd.api.comments') }}?table_code=${encodeURIComponent(currentTableCode)}&opd_code=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}`);
                if (!res.ok) return;
                const json = await res.json();
                tableCommentsMap = json.grouped || {};
                renderCellCommentBadges();
            } catch (err) {
                console.warn('Gagal memuat catatan tabel:', err);
            }
        }

        function getHeaderTitleForCol(colIdx) {
            const table = document.getElementById('dataDisplayTable');
            if (!table) return `Kolom ${colIdx + 1}`;
            const theadRows = table.querySelectorAll('thead tr');
            if (theadRows.length === 0) return `Kolom ${colIdx + 1}`;

            let title = '';
            for (let r = theadRows.length - 1; r >= 0; r--) {
                const ths = theadRows[r].querySelectorAll('th');
                if (ths[colIdx] && ths[colIdx].innerText.trim() && !ths[colIdx].innerText.trim().startsWith('(')) {
                    title = ths[colIdx].innerText.replace(/[\n\r]+/g, ' ').replace(/\s+/g, ' ').trim();
                    break;
                }
            }
            return title || `Kolom ${colIdx + 1}`;
        }

        function renderCellCommentBadges() {
            const table = document.getElementById('dataDisplayTable');
            if (!table) return;
            const bodyRows = table.querySelectorAll('tbody tr');

            let totalComments = 0;
            Object.values(tableCommentsMap).forEach(arr => {
                if (Array.isArray(arr)) totalComments += arr.length;
            });
            const badgeTotalEl = document.getElementById('headerTotalCommentsCount');
            if (badgeTotalEl) badgeTotalEl.innerText = totalComments;

            bodyRows.forEach((tr, rIdx) => {
                const rowKey = tr.getAttribute('data-key') || ('row_' + rIdx);
                const tds = tr.querySelectorAll('td');
                if (tds.length === 0) return;

                const firstTdText = tds[0].innerText.replace(/[\n\r]+/g, ' ').replace(/\s+/g, ' ').trim();

                tds.forEach((td, cIdx) => {
                    if (cIdx === 0 && tds.length > 1) return;

                    const cellKey = `${rowKey}_col_${cIdx}`;
                    td.setAttribute('data-cell-key', cellKey);
                    td.classList.add('relative', 'group');

                    const colTitle = getHeaderTitleForCol(cIdx);
                    const cellLabel = `${firstTdText} • ${colTitle}`;

                    const existingBadge = td.querySelector('.cell-comment-badge-wrap');
                    if (existingBadge) existingBadge.remove();

                    const comments = tableCommentsMap[cellKey] || [];
                    const count = comments.length;

                    const inputEl = td.querySelector('input');
                    const cellVal = inputEl ? inputEl.value : td.innerText.replace(/[\n\r]+/g, ' ').trim();

                    const badgeWrap = document.createElement('span');
                    badgeWrap.className = 'cell-comment-badge-wrap inline-flex items-center align-middle ml-1.5';

                    // Bersihkan corner pin lama jika ada
                    const oldPin = td.querySelector('.cell-comment-corner-pin');
                    if (oldPin) oldPin.remove();

                    if (count > 0) {
                        td.classList.add('bg-amber-100/80', 'ring-1', 'ring-orange-400');
                        td.classList.remove('bg-orange-50/70', 'ring-orange-300');

                        // Tambahkan indikator corner pin aktif di sudut kanan atas sel
                        const cornerPin = document.createElement('span');
                        cornerPin.className = 'cell-comment-corner-pin absolute top-0 right-0 w-2 h-2 bg-[#f95a00] rounded-bl-sm pointer-events-none';
                        td.appendChild(cornerPin);

                        // Badge hidup / jelas kelihatan dengan warna oranye SiAngka
                        badgeWrap.innerHTML = `
                            <button type="button" onclick="event.stopPropagation(); openCellCommentDrawer('${cellKey}', '${escapeHtml(cellLabel)}', '${escapeHtml(cellVal)}')"
                                class="inline-flex items-center space-x-1 px-1.5 py-0.5 rounded-full bg-[#f95a00] hover:bg-[#ea5300] text-white font-extrabold text-[10px] shadow-2xs transition-all transform hover:scale-105 cursor-pointer"
                                title="${count} Catatan Aktif (Klik untuk buka diskusi)">
                                <i class="fa-solid fa-comment-dots text-[9px]"></i>
                                <span>${count}</span>
                            </button>
                        `;
                    } else {
                        td.classList.remove('bg-amber-100/80', 'ring-1', 'ring-orange-400', 'bg-orange-50/70', 'ring-orange-300');
                        badgeWrap.innerHTML = `
                            <button type="button" onclick="event.stopPropagation(); openCellCommentDrawer('${cellKey}', '${escapeHtml(cellLabel)}', '${escapeHtml(cellVal)}')"
                                class="opacity-0 group-hover:opacity-100 transition-opacity p-0.5 text-slate-400 hover:text-[#f95a00] cursor-pointer"
                                title="Beri catatan / komentar pada data ini">
                                <i class="fa-regular fa-comment text-[10px]"></i>
                            </button>
                        `;
                    }

                    td.appendChild(badgeWrap);
                });
            });
        }

        function openTableCommentOverview() {
            const table = document.getElementById('dataDisplayTable');
            const keysWithComments = Object.keys(tableCommentsMap);
            if (keysWithComments.length > 0) {
                const firstKey = keysWithComments[0];
                const list = tableCommentsMap[firstKey] || [];
                const first = list[0] || {};
                openCellCommentDrawer(firstKey, first.cell_label || 'Rincian Data', first.cell_value || '-');
            } else if (table) {
                const firstTd = table.querySelector('tbody tr td[data-cell-key]');
                if (firstTd) {
                    const k = firstTd.getAttribute('data-cell-key');
                    const row = firstTd.closest('tr');
                    const rowLabel = row ? row.querySelector('td').innerText.trim() : 'Rincian';
                    const cIdx = Array.from(row.children).indexOf(firstTd);
                    const colTitle = getHeaderTitleForCol(cIdx);
                    const inputEl = firstTd.querySelector('input');
                    const val = inputEl ? inputEl.value : firstTd.innerText.trim();
                    openCellCommentDrawer(k, `${rowLabel} • ${colTitle}`, val);
                } else {
                    openCellCommentDrawer(`table_${currentTableCode}_general`, `Tabel ${currentTableCode} (${currentYear})`, '-');
                }
            } else {
                openCellCommentDrawer(`table_${currentTableCode}_general`, `Tabel ${currentTableCode} (${currentYear})`, '-');
            }
        }

        function openCellCommentDrawer(cellKey, cellLabel, cellValue) {
            activeCellKey = cellKey;
            activeCellLabel = cellLabel || 'Rincian Data';
            activeCellValue = cellValue || '-';

            const labelEl = document.getElementById('drawerCellLabel');
            if (labelEl) {
                labelEl.innerText = activeCellLabel;
                labelEl.title = activeCellLabel;
            }

            const valEl = document.getElementById('drawerCellValue');
            if (valEl) {
                valEl.innerText = activeCellValue || '-';
            }

            renderDrawerStream();

            const drawer = document.getElementById('cellCommentDrawer');
            const backdrop = document.getElementById('cellCommentDrawerBackdrop');
            if (drawer) {
                drawer.classList.remove('translate-x-full');
            }
            if (backdrop) {
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
            }

            setTimeout(() => {
                const input = document.getElementById('drawerCommentInput');
                if (input) input.focus();
            }, 200);
        }

        function closeCellCommentDrawer() {
            const drawer = document.getElementById('cellCommentDrawer');
            const backdrop = document.getElementById('cellCommentDrawerBackdrop');
            if (drawer) {
                drawer.classList.add('translate-x-full');
            }
            if (backdrop) {
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            }
            activeCellKey = null;
        }

        function renderDrawerStream() {
            const stream = document.getElementById('drawerCommentsStream');
            const countBadge = document.getElementById('drawerCommentCountBadge');
            if (!stream) return;

            const comments = (activeCellKey && tableCommentsMap[activeCellKey]) ? tableCommentsMap[activeCellKey] : [];
            if (countBadge) {
                countBadge.innerText = `${comments.length} catatan`;
            }

            if (comments.length === 0) {
                stream.innerHTML = `
                    <div class="my-auto py-8 px-4 text-center">
                        <div class="border border-dashed border-slate-300 rounded-2xl p-6 text-center bg-white shadow-2xs max-w-sm mx-auto">
                            <div class="w-14 h-14 rounded-full bg-orange-100/80 text-[#f95a00] flex items-center justify-center mx-auto mb-3.5 shadow-2xs">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm mb-1.5">Tidak ada catatan</h4>
                            <p class="text-xs text-slate-500 leading-relaxed max-w-[240px] mx-auto">
                                Belum ada catatan untuk rincian ini. Silakan tulis komentar atau keterangan angka di bawah.
                            </p>
                        </div>
                    </div>
                `;
            } else {
                let html = '<div class="space-y-3">';
                comments.forEach(c => {
                    const isAdmin = (c.user_role === 'admin');
                    const roleBadgeClass = isAdmin ? 'bg-orange-100 text-orange-800' : 'bg-emerald-100 text-emerald-800';
                    const roleLabel = isAdmin ? 'BPS' : (c.user_role === 'instansi' ? 'INSTANSI' : 'OPD');
                    const dateFormatted = c.created_at ? new Date(c.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '';
                    const canDelete = (currentUserData.role === 'admin') || (currentUserData.name === c.user_name) || (currentUserData.displayName === c.user_name);

                    html += `
                        <div class="p-3.5 rounded-xl bg-white border border-slate-200/90 shadow-2xs space-y-1.5">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center space-x-1.5 min-w-0">
                                    <span class="font-bold text-slate-900 text-xs truncate">${escapeHtml(c.user_name)}</span>
                                    <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded ${roleBadgeClass}">${roleLabel}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 shrink-0">${dateFormatted}</span>
                            </div>
                            <p class="text-xs text-slate-700 whitespace-pre-wrap leading-relaxed">${escapeHtml(c.comment)}</p>
                            ${canDelete ? `
                                <div class="text-right pt-1 border-t border-slate-100">
                                    <button type="button" onclick="deleteCommentItem(${c.id})" class="text-[10px] text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                        <i class="fa-solid fa-trash-can text-[9px] mr-1"></i>Hapus
                                    </button>
                                </div>
                            ` : ''}
                        </div>
                    `;
                });
                html += '</div>';
                stream.innerHTML = html;

                setTimeout(() => {
                    stream.scrollTop = stream.scrollHeight;
                }, 50);
            }
        }

        async function handleSendComment(e) {
            e.preventDefault();
            if (!activeCellKey) return;
            const input = document.getElementById('drawerCommentInput');
            const commentText = input ? input.value.trim() : '';
            if (!commentText) return;

            const btn = document.getElementById('btnSubmitDrawerComment');
            if (btn) btn.disabled = true;

            try {
                const res = await fetch(`{{ route('tabel-opd.api.save-comment') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: parseInt(currentYear) || 2025,
                        cell_key: activeCellKey,
                        cell_label: activeCellLabel,
                        cell_value: activeCellValue,
                        comment: commentText
                    })
                });

                const data = await res.json();
                if (data.status === 'success') {
                    if (input) input.value = '';
                    if (!tableCommentsMap[activeCellKey]) {
                        tableCommentsMap[activeCellKey] = [];
                    }
                    tableCommentsMap[activeCellKey].push(data.data);
                    renderDrawerStream();
                    renderCellCommentBadges();
                    showToast('Catatan berhasil dikirim!');
                } else {
                    alert('Gagal mengirim catatan: ' + (data.message || 'Terjadi kesalahan.'));
                }
            } catch (err) {
                console.error('Error sending comment:', err);
                alert('Gagal mengirim catatan. Periksa koneksi Anda.');
            } finally {
                if (btn) btn.disabled = false;
            }
        }

        async function deleteCommentItem(id) {
            if (!confirm('Hapus catatan ini?')) return;
            try {
                const res = await fetch(`/api/tabel-opd/comments/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();
                if (data.status === 'success') {
                    if (activeCellKey && tableCommentsMap[activeCellKey]) {
                        tableCommentsMap[activeCellKey] = tableCommentsMap[activeCellKey].filter(c => c.id !== id);
                        if (tableCommentsMap[activeCellKey].length === 0) {
                            delete tableCommentsMap[activeCellKey];
                        }
                    }
                    renderDrawerStream();
                    renderCellCommentBadges();
                    showToast('Catatan berhasil dihapus.');
                } else {
                    alert('Gagal menghapus catatan: ' + (data.message || 'Terjadi kesalahan.'));
                }
            } catch (err) {
                console.error('Error deleting comment:', err);
                alert('Gagal menghapus catatan.');
            }
        }

        // ==========================================================================
        // GOOGLE SPREADSHEET VIEW & PUBLICATION EXPORT SUITE
        // ==========================================================================

        function getSpreadsheetColLetter(index) {
            let col = '';
            index++;
            while (index > 0) {
                let rem = (index - 1) % 26;
                col = String.fromCharCode(65 + rem) + col;
                index = Math.floor((index - rem) / 26);
            }
            return col;
        }

        function openSpreadsheetModal() {
            const modal = document.getElementById('spreadsheetModal');
            const card = document.getElementById('spreadsheetModalCard');
            if (!modal || !card) return;

            renderSpreadsheetGrid();

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeSpreadsheetModal() {
            const modal = document.getElementById('spreadsheetModal');
            const card = document.getElementById('spreadsheetModalCard');
            if (!modal || !card) return;

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        function showSpreadsheetToast(title, desc) {
            const toast = document.getElementById('spreadsheetToast');
            if (!toast) return;

            const titleEl = document.getElementById('spreadsheetToastTitle');
            const descEl = document.getElementById('spreadsheetToastDesc');
            if (titleEl && title) titleEl.innerText = title;
            if (descEl && desc) descEl.innerHTML = desc;

            toast.classList.remove('hidden');
            toast.classList.add('flex');
            setTimeout(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            if (window._ssToastTimer) clearTimeout(window._ssToastTimer);
            window._ssToastTimer = setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.classList.remove('flex');
                }, 300);
            }, 4000);
        }

        function renderSpreadsheetGrid(gridTableId = 'spreadsheetGridTable', activeLabelId = 'spreadsheetActiveCellLabel', formulaInputId = 'spreadsheetFormulaInput', statsInfoId = 'spreadsheetStatsInfo') {
            const origTable = document.getElementById('dataDisplayTable');
            const gridTable = document.getElementById(gridTableId);
            if (!origTable || !gridTable) return;

            const titleId = document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText.trim() : `Tabel ${currentTableCode}`;
            const titleEn = document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText.trim() : '';
            const sourceEl = document.getElementById('tableSourceContent');
            const cleanSource = sourceEl ? sourceEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : '';
            const noteEl = document.getElementById('tableNoteContent');
            const cleanNote = noteEl ? noteEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : '';

            // Update document title di app bar modal
            const docTitleEl = document.getElementById('spreadsheetDocTitle');
            if (docTitleEl) {
                docTitleEl.innerText = `Publikasi_Pusat_Tabel_${currentTableCode}_Tahun_${currentYear}`;
            }

            // Hitung jumlah kolom
            let maxCols = 1;
            origTable.querySelectorAll('tr').forEach(tr => {
                let count = 0;
                tr.querySelectorAll('th, td').forEach(c => {
                    count += parseInt(c.getAttribute('colspan') || 1);
                });
                if (count > maxCols) maxCols = count;
            });
            maxCols = Math.max(maxCols, 5);

            let rowCounter = 1;

            // 1. THEAD: Kolom Huruf A, B, C, D...
            let theadHtml = '<thead><tr>';
            theadHtml += '<th class="gs-col-header w-10 min-w-[40px] text-slate-400 font-mono text-[10px] select-none bg-[#f1f3f4]">#</th>';
            for (let c = 0; c < maxCols; c++) {
                theadHtml += `<th class="gs-col-header font-mono select-none">${getSpreadsheetColLetter(c)}</th>`;
            }
            theadHtml += '</tr></thead>';

            // 2. TBODY: Baris-baris spreadsheet
            let tbodyHtml = '<tbody>';

            // Baris 1: Judul Bahasa Indonesia
            tbodyHtml += `<tr>`;
            tbodyHtml += `<td class="gs-row-header font-mono select-none">${rowCounter}</td>`;
            tbodyHtml += `<td colspan="${maxCols}" class="gs-cell font-bold text-slate-900 bg-white" data-cell-name="A${rowCounter}" data-cell-val="${titleId.replace(/"/g, '&quot;')}">${titleId}</td>`;
            tbodyHtml += `</tr>`;
            rowCounter++;

            // Baris 2: Judul Bahasa Inggris
            if (titleEn) {
                tbodyHtml += `<tr>`;
                tbodyHtml += `<td class="gs-row-header font-mono select-none">${rowCounter}</td>`;
                tbodyHtml += `<td colspan="${maxCols}" class="gs-cell italic text-slate-600 bg-white" data-cell-name="A${rowCounter}" data-cell-val="${titleEn.replace(/"/g, '&quot;')}">${titleEn}</td>`;
                tbodyHtml += `</tr>`;
                rowCounter++;
            }

            // Baris 3: Pemisah kosong
            tbodyHtml += `<tr class="h-3 bg-[#fdfdfd]">`;
            tbodyHtml += `<td class="gs-row-header font-mono select-none text-[9px] text-slate-300">${rowCounter}</td>`;
            for (let c = 0; c < maxCols; c++) {
                tbodyHtml += `<td class="gs-cell bg-[#fafafa]" data-cell-name="${getSpreadsheetColLetter(c)}${rowCounter}" data-cell-val=""></td>`;
            }
            tbodyHtml += `</tr>`;
            rowCounter++;

            // Baris THEAD tabel asli
            const theadRows = origTable.querySelectorAll('thead tr');
            theadRows.forEach((tr) => {
                tbodyHtml += `<tr>`;
                tbodyHtml += `<td class="gs-row-header font-mono select-none text-slate-500 font-bold bg-[#f1f5f9]">${rowCounter}</td>`;
                let colIdx = 0;
                tr.querySelectorAll('th, td').forEach(cell => {
                    const colspan = cell.getAttribute('colspan') ? ` colspan="${cell.getAttribute('colspan')}"` : '';
                    const rowspan = cell.getAttribute('rowspan') ? ` rowspan="${cell.getAttribute('rowspan')}"` : '';
                    const text = cell.innerText.replace(/\r?\n+/g, ' ').trim();
                    const cellName = `${getSpreadsheetColLetter(colIdx)}${rowCounter}`;
                    colIdx += parseInt(cell.getAttribute('colspan') || 1);
                    tbodyHtml += `<td class="gs-cell font-bold text-center bg-[#f8fafc] text-slate-800 border-slate-300" ${colspan}${rowspan} data-cell-name="${cellName}" data-cell-val="${text.replace(/"/g, '&quot;')}">${text}</td>`;
                });
                tbodyHtml += `</tr>`;
                rowCounter++;
            });

            // Baris TBODY tabel asli
            const tbodyRows = origTable.querySelectorAll('tbody tr');
            tbodyRows.forEach((tr) => {
                if (tr.classList.contains('subtable-spacer-row')) {
                    tbodyHtml += `<tr class="h-4 bg-slate-100">`;
                    tbodyHtml += `<td class="gs-row-header font-mono select-none text-[9px] text-slate-400 bg-slate-200">${rowCounter}</td>`;
                    tbodyHtml += `<td colspan="${maxCols}" class="gs-cell bg-slate-100 text-slate-400 text-center font-mono text-[10px]" data-cell-name="A${rowCounter}" data-cell-val="">--- Baris Pemisah ---</td>`;
                    tbodyHtml += `</tr>`;
                    rowCounter++;
                    return;
                }

                tbodyHtml += `<tr>`;
                tbodyHtml += `<td class="gs-row-header font-mono select-none">${rowCounter}</td>`;
                let colIdx = 0;
                const cells = tr.querySelectorAll('td, th');
                const isTotalRow = tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total');
                cells.forEach((cell, cIdx) => {
                    const colspan = cell.getAttribute('colspan') ? ` colspan="${cell.getAttribute('colspan')}"` : '';
                    const rowspan = cell.getAttribute('rowspan') ? ` rowspan="${cell.getAttribute('rowspan')}"` : '';
                    let text = cell.innerText.replace(/\r?\n+/g, ' ').trim();
                    text = text.replace(/\s*\d+\s*komentar/i, '').trim();

                    const isNumeric = (cIdx > 0 && /^[\d\.,\-\s]+$/.test(text)) || cell.classList.contains('text-right') || cell.classList.contains('text-center');
                    const alignClass = cIdx === 0 ? 'text-left font-medium' : (isNumeric ? 'text-right font-mono' : 'text-center');
                    const boldClass = isTotalRow ? 'font-bold bg-[#f8fafc]' : '';

                    const cellName = `${getSpreadsheetColLetter(colIdx)}${rowCounter}`;
                    colIdx += parseInt(cell.getAttribute('colspan') || 1);

                    tbodyHtml += `<td class="gs-cell ${alignClass} ${boldClass}" ${colspan}${rowspan} data-cell-name="${cellName}" data-cell-val="${text.replace(/"/g, '&quot;')}">${text}</td>`;
                });
                tbodyHtml += `</tr>`;
                rowCounter++;
            });

            // Baris FOOTER (Catatan & Sumber)
            if (cleanNote) {
                tbodyHtml += `<tr>`;
                tbodyHtml += `<td class="gs-row-header font-mono select-none text-[9px] text-slate-400">${rowCounter}</td>`;
                tbodyHtml += `<td colspan="${maxCols}" class="gs-cell text-slate-600 italic bg-white" data-cell-name="A${rowCounter}" data-cell-val="Catatan: ${cleanNote.replace(/"/g, '&quot;')}"><strong>Catatan / Note:</strong> ${cleanNote}</td>`;
                tbodyHtml += `</tr>`;
                rowCounter++;
            }
            if (cleanSource) {
                tbodyHtml += `<tr>`;
                tbodyHtml += `<td class="gs-row-header font-mono select-none text-[9px] text-slate-400">${rowCounter}</td>`;
                tbodyHtml += `<td colspan="${maxCols}" class="gs-cell text-slate-700 font-medium bg-white" data-cell-name="A${rowCounter}" data-cell-val="Sumber: ${cleanSource.replace(/"/g, '&quot;')}"><strong>Sumber / Source:</strong> ${cleanSource}</td>`;
                tbodyHtml += `</tr>`;
                rowCounter++;
            }

            tbodyHtml += '</tbody>';
            gridTable.innerHTML = theadHtml + tbodyHtml;

            // Pasang event click sel untuk formula bar
            gridTable.querySelectorAll('.gs-cell').forEach(cell => {
                cell.addEventListener('click', function() {
                    gridTable.querySelectorAll('.gs-cell-active').forEach(c => c.classList.remove('gs-cell-active'));
                    this.classList.add('gs-cell-active');
                    const cellName = this.getAttribute('data-cell-name') || 'A1';
                    const cellVal = this.getAttribute('data-cell-val') || this.innerText.trim();
                    const activeLabel = document.getElementById(activeLabelId);
                    const formulaInput = document.getElementById(formulaInputId);
                    if (activeLabel) activeLabel.innerText = cellName;
                    if (formulaInput) formulaInput.value = cellVal;
                });
            });

            // Set default active cell ke A1
            const firstCell = gridTable.querySelector('.gs-cell');
            if (firstCell) {
                firstCell.classList.add('gs-cell-active');
                const activeLabel = document.getElementById(activeLabelId);
                const formulaInput = document.getElementById(formulaInputId);
                if (activeLabel) activeLabel.innerText = firstCell.getAttribute('data-cell-name') || 'A1';
                if (formulaInput) formulaInput.value = firstCell.getAttribute('data-cell-val') || firstCell.innerText.trim();
            }

            // Update stats info
            const statsEl = document.getElementById(statsInfoId);
            if (statsEl) {
                statsEl.innerText = `${rowCounter - 1} baris, ${maxCols} kolom siap disalin`;
            }
        }

        function copyTableForSpreadsheet(dataOnly = false) {
            const table = document.getElementById('dataDisplayTable');
            if (!table) {
                alert('Tabel tidak ditemukan.');
                return;
            }

            const titleId = document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText.trim() : `Tabel ${currentTableCode}`;
            const titleEn = document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText.trim() : '';
            const sourceEl = document.getElementById('tableSourceContent');
            const cleanSource = sourceEl ? sourceEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : '';
            const noteEl = document.getElementById('tableNoteContent');
            const cleanNote = noteEl ? noteEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : '';

            let maxCols = 1;
            table.querySelectorAll('tr').forEach(tr => {
                let count = 0;
                tr.querySelectorAll('th, td').forEach(c => {
                    count += parseInt(c.getAttribute('colspan') || 1);
                });
                if (count > maxCols) maxCols = count;
            });

            // 1. Bangun TSV (Tab-Separated Values)
            let tsvLines = [];
            if (!dataOnly) {
                tsvLines.push(titleId);
                if (titleEn) tsvLines.push(titleEn);
                tsvLines.push(''); // Baris kosong pemisah
                
                table.querySelectorAll('thead tr').forEach(tr => {
                    let rowVals = [];
                    tr.querySelectorAll('th, td').forEach(cell => {
                        const text = (cell.innerText || '').replace(/\r?\n+/g, ' ').trim();
                        const colspan = parseInt(cell.getAttribute('colspan') || 1);
                        rowVals.push(text);
                        for (let i = 1; i < colspan; i++) rowVals.push('');
                    });
                    tsvLines.push(rowVals.join('\t'));
                });
            }

            table.querySelectorAll('tbody tr').forEach(tr => {
                if (tr.classList.contains('subtable-spacer-row')) {
                    tsvLines.push('');
                    return;
                }
                let rowVals = [];
                tr.querySelectorAll('th, td').forEach(cell => {
                    let text = (cell.innerText || '').replace(/\r?\n+/g, ' ').trim();
                    text = text.replace(/\s*\d+\s*komentar/i, '').trim();
                    const colspan = parseInt(cell.getAttribute('colspan') || 1);
                    rowVals.push(text);
                    for (let i = 1; i < colspan; i++) rowVals.push('');
                });
                tsvLines.push(rowVals.join('\t'));
            });

            if (!dataOnly) {
                if (cleanNote) {
                    tsvLines.push('');
                    tsvLines.push('Catatan: ' + cleanNote);
                }
                if (cleanSource) {
                    tsvLines.push('Sumber: ' + cleanSource);
                }
            }
            const fullTsv = tsvLines.join('\r\n');

            // 2. Bangun HTML Table Bersih (untuk paste kaya fitur di Google Docs/Word/Sheets)
            let cleanHtml = `<table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10pt; color: #000000;">`;
            if (!dataOnly) {
                cleanHtml += `<tr><td colspan="${maxCols}" style="font-weight: bold; font-size: 11pt; border: none; padding: 4px 0;">${titleId}</td></tr>`;
                if (titleEn) {
                    cleanHtml += `<tr><td colspan="${maxCols}" style="font-style: italic; color: #475569; border: none; padding: 2px 0 6px 0;">${titleEn}</td></tr>`;
                }
                cleanHtml += `<tr><td colspan="${maxCols}" style="border: none; height: 6px;"></td></tr>`;

                table.querySelectorAll('thead tr').forEach(tr => {
                    cleanHtml += `<tr>`;
                    tr.querySelectorAll('th, td').forEach(cell => {
                        const colspan = cell.getAttribute('colspan') ? ` colspan="${cell.getAttribute('colspan')}"` : '';
                        const rowspan = cell.getAttribute('rowspan') ? ` rowspan="${cell.getAttribute('rowspan')}"` : '';
                        const text = cell.innerText.replace(/\r?\n+/g, ' ').trim();
                        cleanHtml += `<th${colspan}${rowspan} style="background-color: #f1f5f9; font-weight: bold; text-align: center; border: 1px solid #94a3b8; padding: 5px;">${text}</th>`;
                    });
                    cleanHtml += `</tr>`;
                });
            }

            table.querySelectorAll('tbody tr').forEach(tr => {
                if (tr.classList.contains('subtable-spacer-row')) {
                    cleanHtml += `<tr><td colspan="${maxCols}" style="border: 1px solid #e2e8f0; height: 8px; background-color: #f8fafc;"></td></tr>`;
                    return;
                }
                cleanHtml += `<tr>`;
                const isTotal = tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total');
                tr.querySelectorAll('th, td').forEach((cell, cIdx) => {
                    const colspan = cell.getAttribute('colspan') ? ` colspan="${cell.getAttribute('colspan')}"` : '';
                    const rowspan = cell.getAttribute('rowspan') ? ` rowspan="${cell.getAttribute('rowspan')}"` : '';
                    let text = cell.innerText.replace(/\r?\n+/g, ' ').trim();
                    text = text.replace(/\s*\d+\s*komentar/i, '').trim();
                    const isNumeric = (cIdx > 0 && /^[\d\.,\-\s]+$/.test(text));
                    const align = cIdx === 0 ? 'left' : (isNumeric ? 'right' : 'center');
                    const bold = isTotal ? 'font-weight: bold; background-color: #f1f5f9;' : '';
                    cleanHtml += `<td${colspan}${rowspan} style="text-align: ${align}; border: 1px solid #cbd5e1; padding: 4px 6px; ${bold}">${text}</td>`;
                });
                cleanHtml += `</tr>`;
            });

            if (!dataOnly) {
                if (cleanNote) {
                    cleanHtml += `<tr><td colspan="${maxCols}" style="border: none; padding-top: 8px; font-style: italic; color: #475569;"><strong>Catatan:</strong> ${cleanNote}</td></tr>`;
                }
                if (cleanSource) {
                    cleanHtml += `<tr><td colspan="${maxCols}" style="border: none; padding-top: 2px; color: #334155;"><strong>Sumber:</strong> ${cleanSource}</td></tr>`;
                }
            }
            cleanHtml += `</table>`;

            // 3. Salin ke Clipboard
            if (navigator.clipboard && window.ClipboardItem) {
                const textBlob = new Blob([fullTsv], { type: 'text/plain' });
                const htmlBlob = new Blob([cleanHtml], { type: 'text/html' });
                navigator.clipboard.write([
                    new ClipboardItem({
                        'text/plain': textBlob,
                        'text/html': htmlBlob
                    })
                ]).then(() => {
                    showSpreadsheetToast(
                        dataOnly ? 'Data Angka Berhasil Disalin!' : 'Seluruh Tabel Berhasil Disalin!',
                        'Format spreadsheet siap ditempel. Buka Google Sheets atau Publikasi Pusat lalu tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-400 font-mono text-[10px] font-bold">Ctrl + V</kbd>'
                    );
                }).catch(err => {
                    fallbackCopySpreadsheetText(fullTsv);
                    showSpreadsheetToast(
                        dataOnly ? 'Data Angka Berhasil Disalin!' : 'Seluruh Tabel Berhasil Disalin!',
                        'Format teks TSV siap ditempel dengan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-400 font-mono text-[10px] font-bold">Ctrl + V</kbd>'
                    );
                });
            } else {
                fallbackCopySpreadsheetText(fullTsv);
                showSpreadsheetToast(
                    dataOnly ? 'Data Angka Berhasil Disalin!' : 'Seluruh Tabel Berhasil Disalin!',
                    'Format teks TSV siap ditempel dengan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-400 font-mono text-[10px] font-bold">Ctrl + V</kbd>'
                );
            }
        }

        function fallbackCopySpreadsheetText(text) {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.left = '-9999px';
            ta.style.top = '-9999px';
            document.body.appendChild(ta);
            ta.focus();
            ta.select();
            try {
                document.execCommand('copy');
            } catch (e) {
                console.error('Fallback copy failed', e);
            }
            document.body.removeChild(ta);
        }

        // Listener Keyboard Esc untuk menutup modal spreadsheet
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('spreadsheetModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeSpreadsheetModal();
                }
            }
        });

        document.addEventListener('DOMContentLoaded', initPage);
    </script>
    </script>
</body>
</html>
