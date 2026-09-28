<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data Statistik Sektoral - SiMonDa Bukittinggi dalam Angka</title>
    
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

        @media print {
            header, footer, #breadcrumbBar, #actionHeaderRight, #editModeAlert, #bottomActionBar, #toastNotification {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .table-custom-border td, .table-custom-border th {
                border: 1px solid #000000 !important;
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
                                OPD
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium hidden sm:block">
                            Sistem Monitoring Data Statistik Sektoral Kota Bukittinggi
                        </p>
                    </div>
                </div>


                <!-- Right: Navigation Action Buttons -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ route('isi-data-opd') }}" 
                       class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-1.5 shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Daftar OPD</span>
                    </a>
                    <a href="{{ route('home') }}" 
                       class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-[#f95a00] hover:bg-[#e04e00] text-white text-xs font-bold transition-all flex items-center space-x-1.5 shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-house text-[11px]"></i>
                        <span class="hidden sm:inline">Home</span>
                    </a>
                </div>

            </div>
        </header>

        <!-- BREADCRUMB & CONTEXT BAR -->
        <div id="breadcrumbBar" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 pt-4 sm:pt-6 w-full">
            <div class="flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500 pb-2">
                <div class="flex items-center space-x-2 font-medium">
                    <a href="{{ route('home') }}" class="hover:text-[#f95a00] transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <a href="{{ route('isi-data-opd') }}" class="hover:text-[#f95a00] transition-colors">Isi Data OPD</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span id="breadcrumbOpdText" class="font-bold text-slate-800">01. DINAS PUPR</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span id="breadcrumbTableText" class="font-bold text-[#f95a00]">Tabel 1.1.6</span>
                </div>

            </div>
        </div>

        <!-- MAIN TABLE DETAIL CONTAINER -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-3 sm:py-5 flex-1 w-full">
            
            <!-- TABLE CARD -->
            <div class="bg-white rounded-2xl p-4 sm:p-7 md:p-8 shadow-sm border border-slate-200/90 relative transition-all">
                
                <!-- TOP CARD HEADER BAR: 4-Square Grid Icon + Title + Export Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-4 mb-6 gap-3">
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

                    <!-- Right Header Actions: Year Switcher + Edit + Unggah Excel + Export Dropdown Menu -->
                    <div id="actionHeaderRight" class="flex items-center flex-wrap gap-2">
                        <!-- Year Switcher Selector -->
                        <div class="flex items-center space-x-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 rounded-lg px-2.5 py-1.5 transition-colors shadow-2xs">
                            <i class="fa-solid fa-calendar-days text-slate-400 text-xs"></i>
                            <select id="yearSwitcher" onchange="changeTableYear(this.value)" 
                                    class="bg-transparent text-xs font-bold text-slate-700 focus:outline-none cursor-pointer">
                                <!-- Populated dynamically -->
                            </select>
                        </div>

                        <!-- Button: Form Unggah Excel -->
                        <button onclick="toggleExcelUploadForm()" 
                                id="btnToggleExcelUpload"
                                class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#0F9D58] border border-emerald-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Buka Form Unggah Excel untuk Generate Data Tabel Otomatis">
                            <i class="fa-solid fa-file-excel text-[11px]"></i>
                            <span>Unggah Excel</span>
                        </button>

                        <!-- Edit Button (Buka Halaman Editor Data) -->
                        <button id="editTableBtn" onclick="goToEditPage()" 
                                class="px-3 py-1.5 rounded-lg bg-[#fff8e6] hover:bg-[#ffefc2] text-[#d97706] border border-[#fde68a] font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Buka Halaman Pengeditan Data Tabel">
                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                            <span>Edit Tabel</span>
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
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">SiMonDa</span>
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
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 mb-6 text-xs sm:text-sm text-slate-900">
                    
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
                                    Form Pengisian Data Tabel — Unggah Berkas Excel
                                </h3>
                                <p class="text-xs text-slate-600 mt-0.5" id="excelUploadSubtitle">
                                    Unggah berkas Excel (.xlsx / .xls) untuk men-generate data tabel ini secara otomatis.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <!-- Template Download Button -->
                            <button onclick="downloadExcelTemplate()" 
                                    class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-emerald-50 text-emerald-800 border border-emerald-300 font-bold text-xs transition-all shadow-2xs cursor-pointer shrink-0"
                                    title="Unduh format template Excel untuk diisi">
                                <i class="fa-solid fa-download text-emerald-600 text-[11px]"></i>
                                <span>Unduh Template Excel</span>
                            </button>
                            <!-- Close Form Button -->
                            <button onclick="toggleExcelUploadForm(false)" 
                                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer"
                                    title="Tutup form unggah">
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



                <!-- TABLE FOOTER: SOURCE / SUMBER -->
                <div class="text-xs text-slate-700 space-y-1 pt-2 border-t border-slate-100">
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

                <!-- BOTTOM ACTION BAR -->
                <div id="bottomActionBar" class="mt-8 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <button onclick="window.history.back()" 
                            class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-2 cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Kembali ke Halaman Sebelumnya</span>
                    </button>

                    <div class="flex items-center flex-wrap gap-2">
                        <button onclick="window.print()" 
                                class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition-all flex items-center space-x-1.5 cursor-pointer shadow-2xs">
                            <i class="fa-solid fa-print text-xs"></i>
                            <span>Cetak Tabel</span>
                        </button>
                        <!-- Bottom Export Dropdown Component -->
                        <div class="relative inline-block text-left" id="exportDropdownContainerBottom">
                            <button id="exportDropdownBtnBottom" onclick="toggleExportDropdown('Bottom')" 
                                    class="px-4 py-2 rounded-xl bg-[#0F9D58] hover:bg-[#0B8043] text-white text-xs font-bold transition-all flex items-center space-x-1.5 cursor-pointer shadow-2xs">
                                <i class="fa-solid fa-file-export text-xs"></i>
                                <span>Export</span>
                                <i id="exportChevronBottom" class="fa-solid fa-chevron-up text-[9px] ml-0.5 transition-transform duration-200"></i>
                            </button>

                            <!-- Dropdown Menu (Opens upward at page bottom) -->
                            <div id="exportDropdownMenuBottom" 
                                 class="hidden absolute right-0 bottom-full mb-2 w-72 origin-bottom-right rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 border border-slate-200/90 divide-y divide-slate-100 focus:outline-none z-50 animate-in fade-in zoom-in-95 duration-150">
                                
                                <div class="p-3 bg-slate-50/90 rounded-t-2xl border-b border-slate-100 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded-lg bg-emerald-100 text-[#0F9D58] flex items-center justify-center text-xs shadow-2xs">
                                            <i class="fa-solid fa-download"></i>
                                        </div>
                                        <span class="text-[11px] font-extrabold text-slate-800 uppercase tracking-wider">Pilihan Format Ekspor</span>
                                    </div>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">SiMonDa</span>
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
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    1
                                </td>
                                <td class="py-2 px-4 border border-slate-700 ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    ${is2025 ? 'Aur Birugo Tigo Baleh' : '-'}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    2
                                </td>
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
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    1
                                </td>
                                <td class="py-2 px-4 border border-slate-700 ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    ${is2025 ? 'Aur Birugo Tigo Baleh' : '-'}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center border border-slate-700 font-bold ${is2025 ? '' : 'text-slate-400 font-normal'}">
                                    2
                                </td>
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
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Jalan Kota</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">89,60</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">72,73</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / Total</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">100,00</td>
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
                    const y0 = yr - 4;
                    const y1 = yr - 3;
                    const y2 = yr - 2;
                    const y3 = yr - 1;
                    const y4 = yr;
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
                                <th class="py-2 px-3 border border-slate-700">${y0}</th>
                                <th class="py-2 px-3 border border-slate-700">${y1}</th>
                                <th class="py-2 px-3 border border-slate-700">${y2}</th>
                                <th class="py-2 px-3 border border-slate-700">${y3}</th>
                                <th class="py-2 px-3 border border-slate-700 bg-amber-500 font-extrabold">${y4}</th>
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
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Aspal / Hotmix</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">104,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">104,80</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">105,10</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">105,25</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-bold bg-amber-100/60">105,40</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Kerikil / Beton</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">15,40</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">14,80</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">14,50</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">14,35</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-bold bg-amber-100/60">14,20</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Tanah / Lainnya</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">3,60</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">3,60</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">3,60</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">3,60</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-bold bg-amber-100/60">3,60</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / Total</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-extrabold bg-amber-200/80">123,20</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.3': {
                titleId: 'Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km)',
                titleEn: 'Length of Roads by Road Condition in Bukittinggi Municipality (km)',
                isMultiYear: true,
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    const yr = parseInt(year) || 2025;
                    const y0 = yr - 4;
                    const y1 = yr - 3;
                    const y2 = yr - 2;
                    const y3 = yr - 1;
                    const y4 = yr;
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
                                <th class="py-2 px-3 border border-slate-700">${y0}</th>
                                <th class="py-2 px-3 border border-slate-700">${y1}</th>
                                <th class="py-2 px-3 border border-slate-700">${y2}</th>
                                <th class="py-2 px-3 border border-slate-700">${y3}</th>
                                <th class="py-2 px-3 border border-slate-700 bg-amber-500 font-extrabold">${y4}</th>
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
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Baik</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">72,40</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">74,10</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">75,50</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">76,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-bold bg-amber-100/60">76,80</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Sedang</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">35,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">34,00</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">33,10</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">32,50</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-bold bg-amber-100/60">32,10</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Rusak Ringan</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">11,80</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">11,30</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">10,80</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">10,70</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-bold bg-amber-100/60">10,50</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">4. Rusak Berat</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">3,80</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">3,80</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">3,80</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">3,80</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-bold bg-amber-100/60">3,80</td>
                            </tr>
                            <tr class="bg-[#fed7aa] font-bold">
                                <td class="py-2.5 px-4 border border-slate-700">Jumlah / Total</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700">123,20</td>
                                <td class="py-2.5 px-3 text-center border border-slate-700 font-extrabold bg-amber-200/80">123,20</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.4': {
                titleId: 'Banyak dan Panjang Jembatan, Panjang Trotoar di Kota Bukittinggi',
                titleEn: 'Number and Length of Bridges, Length of Sidewalks in Bukittinggi Municipality',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Rincian Prasarana</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Infrastructure Details</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Banyak / Jumlah Unit</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Quantity / Unit</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Total Panjang (Meter)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Total Length (Meters)</div>
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
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Jembatan Permanen / Beton</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">38</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">542,5</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Jembatan Gantung</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">3</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">120,0</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Trotoar dan Pejalan Kaki</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">14.850,0</td>
                            </tr>
                        </tbody>
                    `;
                }
            },
            '8.1.5': {
                titleId: 'Panjang Gorong-Gorong dan Panjang Drainase di Kota Bukittinggi',
                titleEn: 'Length of Culverts and Length of Drainage in Bukittinggi Municipality',
                source: 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>',
                render: function(year) {
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Jenis Prasarana Saluran</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Type of Drainage Infrastructure</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Kondisi Baik (m)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Good Condition (m)</div>
                                </th>
                                <th class="py-3 px-4 font-bold border border-slate-700">
                                    <div>Total Panjang (Meter)</div>
                                    <div class="italic font-normal text-[11px] sm:text-xs">Total Length (Meters)</div>
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
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">1. Gorong-Gorong (Culvert)</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">4.210</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">4.890</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">2. Drainase Primer</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">18.650</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">21.400</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">3. Drainase Sekunder & Lingkungan</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">42.300</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">49.800</td>
                            </tr>
                        </tbody>
                    `;
                }
            }
        };

        // Query Param State
        let currentOpdCode = '01';
        let currentTableCode = '1.1.6';
        let currentYear = '2025';
        let isEditMode = false;

        function initPage() {
            // One-time cleanup: remove accidental 2026 save for table 1.1.6
            try {
                localStorage.removeItem('simonda_table_html_1.1.6_2026');
            } catch(e) {}

            const params = new URLSearchParams(window.location.search);
            currentOpdCode = params.get('opd') || '01';
            currentTableCode = params.get('code') || params.get('table') || '1.1.6';
            currentYear = params.get('year') || '2025';

            // Check if returned with saved data confirmation
            if (params.get('saved') === '1') {
                showToast('✅ Perubahan data tabel berhasil disimpan ke SiMonDa!');
                const cleanUrl = new URL(window.location);
                cleanUrl.searchParams.delete('saved');
                window.history.replaceState({}, '', cleanUrl);
            }

            // Populate Year Switcher (Descending order)
            const selectYearEl = document.getElementById('yearSwitcher');
            const nowYear = new Date().getFullYear();
            const endYear = Math.max(2026, nowYear + 1);
            if (selectYearEl) {
                selectYearEl.innerHTML = '';
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

            renderTablePage();
            setupDragAndDrop();
        }

        window.addEventListener('popstate', () => {
            const params = new URLSearchParams(window.location.search);
            currentOpdCode = params.get('opd') || '01';
            currentTableCode = params.get('code') || params.get('table') || '1.1.6';
            currentYear = params.get('year') || '2025';
            const selectYearEl = document.getElementById('yearSwitcher');
            if (selectYearEl) selectYearEl.value = currentYear.toString();
            renderTablePage();
        });

        function renderTablePage() {
            const opdName = opdNames[currentOpdCode] || 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG';
            document.getElementById('breadcrumbOpdText').innerText = `${currentOpdCode}. ${opdName}`;
            document.getElementById('breadcrumbTableText').innerText = `Tabel ${currentTableCode}`;

            document.getElementById('pageMainHeading').innerText = `Tabel ${currentTableCode} Tahun ${currentYear}`;
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
            
            // Check for custom titles/source saved from Excel
            const customTitleId = localStorage.getItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
            const customTitleEn = localStorage.getItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
            const customSource = localStorage.getItem(`simonda_table_source_text_${currentTableCode}_${currentYear}`);

            document.getElementById('metaTableTitleId').innerText = customTitleId ? customTitleId : `${schema.titleId}, ${yearLabel}`;
            document.getElementById('metaTableTitleEn').innerText = customTitleEn ? customTitleEn : `${schema.titleEn}, ${yearLabel}`;
            document.getElementById('tableSourceContent').innerHTML = customSource ? customSource : schema.source;

            const tableEl = document.getElementById('dataDisplayTable');
            
            // Check if table data was edited in dedicated edit page or generated from Excel
            let savedHtml = localStorage.getItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
            const hasData = (currentTableCode === '1.1.6' && currentYear.toString() === '2025') || (savedHtml !== null && savedHtml !== '');

            if (savedHtml) {
                tableEl.innerHTML = savedHtml;
            } else {
                tableEl.innerHTML = schema.render(currentYear);
            }

            cleanGhostColumns(tableEl);

            // Year status banner & Excel Upload Section Control
            const alertEl = document.getElementById('yearStatusAlert');
            const uploadSection = document.getElementById('excelUploadSection');

            if (hasData) {
                // If data exists: hide upload section by default (can be toggled by button)
                if (uploadSection) uploadSection.classList.add('hidden');
                
                if (alertEl) {
                    const isSaved = localStorage.getItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`) === '1' || (currentTableCode === '1.1.6' && currentYear.toString() === '2025');

                    if (isSaved) {
                        alertEl.innerHTML = '';
                        alertEl.classList.add('hidden');
                    } else {
                        alertEl.classList.remove('hidden');
                        alertEl.innerHTML = `
                            <div class="p-3 rounded-xl bg-emerald-50/90 border border-emerald-300 text-emerald-950 text-xs flex flex-wrap items-center justify-between gap-2 shadow-2xs animate-in fade-in duration-200">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                                    <span>Data <strong>Tabel ${currentTableCode} Tahun ${currentYear}</strong> berhasil di-generate dari berkas Excel. Silakan periksa hasil tabel, lalu klik Simpan.</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button onclick="saveGeneratedExcel()" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all shadow-xs cursor-pointer flex items-center space-x-1.5">
                                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                                        <span>Simpan Data Tabel</span>
                                    </button>
                                </div>
                            </div>
                        `;
                    }
                }
            } else {
                // If NO data exists for this year: SHOW the Excel upload form by default!
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
                                    <p class="text-amber-800 text-[11px] mt-0.5">Gunakan <strong>Form Unggah Excel</strong> di bawah untuk men-generate data tabel otomatis, atau klik Edit Tabel untuk mengisi manual.</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 shrink-0">
                                ${currentTableCode === '1.1.6' ? `
                                    <button onclick="changeTableYear('2025')" class="px-3.5 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition-colors shadow-2xs cursor-pointer flex items-center space-x-1.5">
                                        <i class="fa-solid fa-calendar-check text-[11px]"></i>
                                        <span>Beralih ke Tahun 2025</span>
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }
            }
        }

        function cleanGhostColumns(table) {
            if (!table) return;
            const bodyRows = table.querySelectorAll('tbody tr');
            if (bodyRows.length === 0) return;

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





        function changeTableYear(newYear) {
            currentYear = newYear.toString();
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('year', currentYear);
            window.history.pushState({}, '', newUrl);

            const selectYearEl = document.getElementById('yearSwitcher');
            if (selectYearEl) selectYearEl.value = currentYear;

            renderTablePage();
            showToast(`Tahun data diubah ke ${currentYear}`);
        }

        function goToEditPage() {
            window.location.href = `{{ route('edit-tabel-opd') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`;
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
            const opdName = opdNames[currentOpdCode] || 'OPD';
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
            const opdName = opdNames[currentOpdCode] || 'OPD';

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
            if (typeof XLSX === 'undefined') {
                alert('Pustaka Excel belum siap. Silakan coba sesaat lagi.');
                return;
            }
            const wb = XLSX.utils.book_new();
            let data = [];

            if (currentTableCode === '1.1.6') {
                data = [
                    ['BADAN PUSAT STATISTIK KOTA BUKITTINGGI'],
                    [`Tabel 1.1.6 - Nama Sungai/Batang, Lebar dan Kecamatan yang Dilalui Tahun ${currentYear}`],
                    [''],
                    ['Nama Sungai (Batang)', 'Lebar (M)', 'No', 'Kecamatan yang Dilalui'],
                    ['01. Batang Tambuo', '6–10', 1, 'Aur Birugo Tigo Baleh'],
                    ['01. Batang Tambuo', '6–10', 2, 'Mandiangin Koto Selayan'],
                    ['02. Batang Sianok', '12–15', 1, 'Aur Birugo Tigo Baleh'],
                    ['02. Batang Sianok', '12–15', 2, 'Guguk Panjang']
                ];
            } else {
                data = [
                    ['BADAN PUSAT STATISTIK KOTA BUKITTINGGI'],
                    [`Tabel ${currentTableCode} Tahun ${currentYear}`],
                    [''],
                    ['Uraian / Kategori Indikator', `Nilai Capaian Tahun ${currentYear}`, 'Satuan'],
                    ['Contoh Data Sektoral 1', 100, 'Unit'],
                    ['Contoh Data Sektoral 2', 75.5, '%']
                ];
            }

            const ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, `Template_${currentTableCode}`);
            XLSX.writeFile(wb, `Template_Tabel_${currentTableCode.replace(/\./g, '_')}_${currentYear}.xlsx`);
            showToast('📥 Berkas template Excel berhasil diunduh!');
        }

        function handleExcelFileSelected(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (!file) return;

            const loadingEl = document.getElementById('excelUploadLoading');
            if (loadingEl) loadingEl.classList.remove('hidden');

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    const sheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[sheetName];
                    const rawRows = XLSX.utils.sheet_to_json(worksheet, { header: 1, defval: '' });

                    generateTableFromExcel(worksheet, rawRows, file.name);
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

        function generateTableFromExcel(worksheet, rawRows, fileName) {
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
            if (footerStartIdx !== -1) {
                const sourceParts = [];
                for (let i = footerStartIdx; i < rawRows.length; i++) {
                    const row = rawRows[i] || [];
                    const cells = row.map(c => (c || '').toString().trim()).filter(c => c !== '');
                    if (cells.length > 0) {
                        let text = cells.join(' ');
                        // clean up leading "Sumber/Source:" or "Sumber:"
                        text = text.replace(/^(sumber\s*\/\s*source|sumber|source)\s*:\s*/i, '').trim();
                        if (text) sourceParts.push(text);
                    }
                }
                if (sourceParts.length > 0) {
                    if (sourceParts.length === 1) {
                        extractedSource = escapeHtml(sourceParts[0]);
                    } else {
                        // First line Indonesian, second English (italic)
                        extractedSource = `${escapeHtml(sourceParts[0])} / <span class="italic text-slate-500">${escapeHtml(sourceParts.slice(1).join(' '))}</span>`;
                    }
                }
            }

            const activeRowLimit = footerStartIdx !== -1 ? footerStartIdx : rawRows.length;

            // 2. Helper to check numbering rows like (1), (2), (3) or 1, 2, 3
            function isNumberingCell(val) {
                if (val === null || val === undefined) return false;
                const s = val.toString().trim();
                return /^\s*\(\s*\d+\s*\)\s*$/.test(s) || /^\s*\d+\s*$/.test(s) || s.toLowerCase() === 'no';
            }

            function isNumberingRow(row) {
                if (!Array.isArray(row)) return false;
                const nonEmpties = row.map(c => (c || '').toString().trim()).filter(c => c !== '');
                if (nonEmpties.length === 0) return false;
                const hasParens = nonEmpties.some(c => /^\s*\(\s*\d+\s*\)\s*$/.test(c));
                const allNumOrNo = nonEmpties.every(c => isNumberingCell(c));
                return hasParens && allNumOrNo;
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

            // 6. Build <thead> HTML
            let theadHtml = '<thead>';

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
                    if (val && !val.startsWith('(') && !isNaN(parseInt(val)) && val.toLowerCase() !== 'no') {
                        val = `(${val})`;
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

            // 7. Build <tbody> HTML with Merge & Rowspan Support
            let tbodyHtml = '<tbody class="bg-[#fef9c3] text-slate-900 font-medium">';
            const hasExplicitDataMerges = merges.some(m => m.s.r >= dataRowIndices[0]);

            dataRowIndices.forEach((rIdx, loopIdx) => {
                const row = rawRows[rIdx] || [];
                tbodyHtml += `<tr class="hover:bg-amber-100/60 transition-colors">`;

                for (let c = 0; c < maxCols; c++) {
                    if (hasExplicitDataMerges) {
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
                        if (c === 0) {
                            alignClass = 'text-left font-semibold align-top';
                        } else if (isNumOrRange) {
                            alignClass = 'text-center align-top';
                        } else {
                            alignClass = 'text-left align-top';
                        }

                        tbodyHtml += `
                            <td class="py-2.5 px-4 border border-slate-700 ${alignClass}"${rSpanAttr}${cSpanAttr}>
                                ${val !== '' ? escapeHtml(val) : '<span class="text-slate-400 font-normal">-</span>'}
                            </td>
                        `;
                    } else {
                        // Fallback grouping for unmerged sheets
                        let val = (row[c] !== null && row[c] !== undefined) ? row[c].toString().trim() : '';

                        if ((c === 0 || c === 1) && val === '') {
                            continue;
                        }

                        let rowspan = 1;
                        if (c === 0 || c === 1) {
                            for (let nextIdx = loopIdx + 1; nextIdx < dataRowIndices.length; nextIdx++) {
                                const nextRow = rawRows[dataRowIndices[nextIdx]] || [];
                                const nextVal = (nextRow[c] !== null && nextRow[c] !== undefined) ? nextRow[c].toString().trim() : '';
                                if (nextVal === '') {
                                    rowspan++;
                                } else {
                                    break;
                                }
                            }
                        }

                        const rSpanAttr = rowspan > 1 ? ` rowspan="${rowspan}"` : '';
                        let alignClass = 'text-left';
                        const isNumOrRange = !isNaN(parseFloat(val.replace(',', '.'))) || /^\d+\s*[-–]\s*\d+$/.test(val);
                        if (c === 0) {
                            alignClass = 'text-left font-semibold align-top';
                        } else if (isNumOrRange) {
                            alignClass = 'text-center align-top';
                        } else {
                            alignClass = 'text-left align-top';
                        }

                        tbodyHtml += `
                            <td class="py-2.5 px-4 border border-slate-700 ${alignClass}"${rSpanAttr}>
                                ${val !== '' ? escapeHtml(val) : '<span class="text-slate-400 font-normal">-</span>'}
                            </td>
                        `;
                    }
                }

                tbodyHtml += `</tr>`;
            });

            tbodyHtml += '</tbody>';

            const completeTableHtml = theadHtml + tbodyHtml;

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

            // Mark as pending save so user can review and click "Simpan Data Tabel"
            localStorage.setItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '0');

            // 9. Re-render UI and feedback
            renderTablePage();
            showToast(`✅ Tabel berhasil di-generate secara rapi (${dataRowIndices.length} baris data) dari ${fileName}!`);

            const tableSec = document.getElementById('printableTableSection');
            if (tableSec) {
                tableSec.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function saveGeneratedExcel() {
            localStorage.setItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`, '1');
            renderTablePage();
            showToast(`💾 Data Tabel ${currentTableCode} Tahun ${currentYear} berhasil disimpan secara permanen di SiMonDa!`);
        }

        function resetGeneratedExcel() {
            if (confirm(`Apakah Anda yakin ingin menghapus data hasil generate Excel untuk Tahun ${currentYear}?`)) {
                localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_source_text_${currentTableCode}_${currentYear}`);
                renderTablePage();
                showToast('🗑️ Data Excel tahun ini berhasil dihapus.');
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
            const opdName = opdNames[currentOpdCode] || 'OPD';
            const titleId = document.getElementById('metaTableTitleId').innerText;
            const titleEn = document.getElementById('metaTableTitleEn').innerText;
            const source = document.getElementById('tableSourceContent').innerText.replace(/<[^>]*>?/gm, '');

            if (typeof XLSX !== 'undefined') {
                const wb = XLSX.utils.book_new();
                const ws = {};
                const merges = [];

                // Border styles - crisp thin border
                const borderThin = {
                    top: { style: 'thin', color: { rgb: '000000' } },
                    bottom: { style: 'thin', color: { rgb: '000000' } },
                    left: { style: 'thin', color: { rgb: '000000' } },
                    right: { style: 'thin', color: { rgb: '000000' } }
                };

                const headerOrangeStyle = {
                    fill: { fgColor: { rgb: 'F95A00' } },
                    font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: 'FFFFFF' } },
                    alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                    border: borderThin
                };

                const headerPeachStyle = {
                    fill: { fgColor: { rgb: 'FED7AA' } },
                    font: { name: 'Calibri', sz: 9.5, bold: true, color: { rgb: '000000' } },
                    alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
                    border: borderThin
                };

                const dataCellStyle = {
                    fill: { fgColor: { rgb: 'FEF9C3' } },
                    font: { name: 'Calibri', sz: 10, color: { rgb: '000000' } },
                    alignment: { horizontal: 'left', vertical: 'center', wrapText: true },
                    border: borderThin
                };

                const dataCenterStyle = {
                    fill: { fgColor: { rgb: 'FEF9C3' } },
                    font: { name: 'Calibri', sz: 10, color: { rgb: '000000' } },
                    alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
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
                    font: { name: 'Calibri', sz: 11, bold: true, color: { rgb: '000000' } }
                });
                setCell(r, 1, titleId, {
                    font: { name: 'Calibri', sz: 11, bold: true, color: { rgb: '000000' } }
                });
                r++;

                setCell(r, 0, 'Table', {
                    font: { name: 'Calibri', sz: 11, bold: true, italic: true, color: { rgb: '000000' } }
                });
                setCell(r, 1, titleEn, {
                    font: { name: 'Calibri', sz: 11, italic: true, color: { rgb: '000000' } }
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
                        { wch: 30 }, // Col A: Nama Sungai
                        { wch: 16 }, // Col B: Lebar
                        { wch: 6 },  // Col C: No (1, 2)
                        { wch: 32 }  // Col D: Kecamatan
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
                            } else if (cell.classList.contains('text-center') || /^\d+$/.test(text.trim())) {
                                style = dataCenterStyle;
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
                        let maxLen = 14;
                        grid.forEach(row => {
                            if (row[c] && row[c].val) {
                                const lines = row[c].val.toString().split('\n');
                                lines.forEach(l => {
                                    if (l.trim().length > maxLen) maxLen = l.trim().length;
                                });
                            }
                        });
                        colWidths.push({ wch: Math.min(Math.max(maxLen + 4, 18), 45) });
                    }
                    ws['!cols'] = colWidths;

                    ws['!ref'] = XLSX.utils.encode_range({
                        s: { r: 0, c: 0 },
                        e: { r: r + 1, c: maxCol - 1 }
                    });

                    ws['!merges'] = merges;
                }

                // Row Heights for official publication look
                const rowHeights = [];
                for (let ri = 0; ri < r + 2; ri++) {
                    if (ri < tableStartRow) {
                        rowHeights.push({ hpt: 20 });
                    } else if (ri === tableStartRow) {
                        rowHeights.push({ hpt: 30 }); // Header row
                    } else if (ri === tableStartRow + 1) {
                        rowHeights.push({ hpt: 20 }); // Numbering row (1), (2), (3)
                    } else if (ri < r - 1) {
                        rowHeights.push({ hpt: 22 }); // Data rows
                    } else {
                        rowHeights.push({ hpt: 20 });
                    }
                }
                ws['!rows'] = rowHeights;

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
            const opdName = opdNames[currentOpdCode] || 'OPD';
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
                doc.text('Sistem Monitoring Data Statistik Sektoral (SiMonDa) - Publikasi Bukittinggi Dalam Angka', 14, 19.5);

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
                doc.text(`Dokumen resmi statistik sektoral diexport melalui SiMonDa Kota Bukittinggi pada ${new Date().toLocaleString('id-ID')}`, 14, 198);

                const safeOpd = opdName.substring(0, 20).replace(/[^a-zA-Z0-9]/g, '_');
                const fileName = `Tabel_${currentTableCode.replace(/\./g, '_')}_${safeOpd}_${currentYear}.pdf`;
                doc.save(fileName);
                showToast(`📕 File PDF (${fileName}) berhasil diunduh!`);
            } else {
                window.print();
            }
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
    </script>
</body>
</html>
