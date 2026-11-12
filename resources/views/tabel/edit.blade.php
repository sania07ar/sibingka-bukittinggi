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
    <!-- Table Helpers & Schemas -->
    <script src="{{ asset('js/tabel/helpers.js') }}"></script>
    <script src="{{ asset('js/tabel/schemas-edit.js') }}"></script>

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
            text-align: right;
            padding-right: 12px;
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

        /* Header Editable Inputs */
        .table-edit-header-input {
            text-align: center !important;
            padding-right: 6px !important;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        }
        .table-edit-header-input:focus {
            background-color: #ffffff !important;
            border-color: #ea580c !important;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.25) !important;
        }
        .table-edit-header-num {
            min-width: 34px !important;
            max-width: 80px !important;
            height: 28px !important;
            font-size: 11.5px !important;
            font-weight: 800 !important;
            background-color: #fffaf0 !important;
            border-color: #f59e0b !important;
            color: #78350f !important;
        }
        .table-edit-header-title {
            min-width: 55px !important;
            font-size: 12.5px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
        }
        .table-edit-header-sub {
            min-width: 55px !important;
            height: 26px !important;
            font-size: 11px !important;
            font-style: italic !important;
            color: #475569 !important;
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

    <!-- Background SiAngka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden flex items-center justify-center opacity-15 select-none">
        <img src="{{ asset('images/siangka-watermark-jamgadang.jpg') }}" alt="Watermark SiAngka Jam Gadang" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-16 sm:-translate-x-28 -translate-y-6 object-contain mix-blend-multiply">
    </div>

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
                    @php
                        $backRoute = route('isi-data-opd');
                        $backLabel = 'Daftar OPD';
                        if (($currentType ?? 'opd') === 'instansi') {
                            $backRoute = route('isi-data-instansi');
                            $backLabel = 'Daftar Instansi';
                        } elseif (($currentType ?? 'opd') === 'bps') {
                            $backRoute = route('data-bps');
                            $backLabel = 'Data BPS';
                        }
                    @endphp
                    <a id="breadcrumbCatalogLink" href="{{ $backRoute }}" class="hover:text-[#f95a00] transition-colors">
                        <span id="breadcrumbCatalogText">{{ $backLabel }}</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span id="breadcrumbOpdText" class="font-bold text-slate-800">01. DINAS PUPR</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <a href="javascript:void(0)" onclick="backToTableView()" class="hover:text-[#f95a00] transition-colors">
                        <span id="breadcrumbTableText" class="font-bold text-slate-700">Tabel {{ $currentTableCode ?? '1.1.6' }}</span>
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
                                    Edit Data Tabel {{ $currentTableCode ?? '1.1.6' }} Tahun {{ $currentYear ?? '2025' }}
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


                        <!-- Import Excel Button -->
                        <button onclick="document.getElementById('editExcelInput').click()" 
                                class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Impor nilai data dari berkas Excel (.xlsx / .xls)">
                            <i class="fa-solid fa-file-excel text-emerald-600 text-[11px]"></i>
                            <span>Import Excel</span>
                        </button>
                        <input type="file" id="editExcelInput" accept=".xlsx, .xls, .csv" class="hidden" onchange="handleEditExcelImport(event)">

                        <!-- Tambah Baris Button -->
                        <button onclick="addNewRow()" 
                                class="px-3 py-1.5 rounded-lg bg-orange-50 hover:bg-orange-100 text-[#f95a00] border border-orange-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Tambah baris data baru ke tabel ini">
                            <i class="fa-solid fa-plus text-[11px]"></i>
                            <span>+ Tambah Baris</span>
                        </button>

                        <button onmousedown="window._isResetting = true;" onclick="resetTableOriginal()" 
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

                        @php
                            $userRole = session('user.role');
                            $isAdmin = ($userRole === 'admin');
                            $isWali = ($userRole === 'walidata');
                            $canVerify = ($isAdmin || $isWali);
                            $isLocked = (bool) ($dbMetadata?->is_locked ?? false);
                            $vStatus = $dbMetadata?->verification_status ?? 'draft';
                        @endphp

                        @if($isLocked && !$isAdmin)
                            <button disabled 
                                    class="px-4 py-1.5 rounded-lg bg-slate-300 text-slate-500 font-bold text-xs flex items-center space-x-1.5 cursor-not-allowed"
                                    title="Tabel terkunci karena sudah diverifikasi/ACC.">
                                <i class="fa-solid fa-lock text-xs"></i>
                                <span>Terkunci</span>
                            </button>
                        @else
                            <button onclick="saveAndReturn()" 
                                    class="px-4 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer">
                                <i class="fa-solid fa-floppy-disk text-xs"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        @endif
                    </div>
                </div>

                @if($isLocked && !$isAdmin)
                    <div class="mb-5 p-3.5 sm:p-4 rounded-2xl bg-amber-50 border border-amber-300 text-amber-900 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shrink-0 shadow-2xs">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                                <span class="font-extrabold text-amber-950 block text-[13px]">Tabel Terkunci (Read-Only)</span>
                                <span class="text-amber-800 text-[11.5px]">Data tabel ini telah disetujui (ACC) oleh BPS Bukittinggi. Perubahan tidak dapat disimpan tanpa persetujuan Admin BPS.</span>
                            </div>
                        </div>
                        <button onclick="backToTableView()" class="px-3.5 py-1.5 bg-white hover:bg-amber-100 rounded-xl border border-amber-300 font-bold text-amber-900 transition-colors shrink-0 cursor-pointer shadow-2xs">
                            Kembali ke Tabel
                        </button>
                    </div>
                @endif

                <!-- TABLE TITLE & METADATA SECTION -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 mb-5 text-xs sm:text-sm text-slate-900">
                    
                    <!-- Left Column: Tabel / Table Number -->
                    <div class="md:col-span-3 flex items-start space-x-4">
                        <div class="flex flex-col font-bold text-slate-900 space-y-1">
                            <span>Tabel</span>
                            <span class="italic font-normal text-slate-600">Table</span>
                        </div>
                        <div class="flex flex-col font-bold text-slate-900 space-y-1">
                            <span id="metaTableCode">{{ $currentTableCode ?? '1.1.6' }}</span>
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
                            <p class="text-slate-600 text-[11px] mt-0.5">Ubah angka atau teks pada kotak oranye di bawah ini (termasuk judul kolom & nomor kolom pada kepala tabel). Setelah selesai, klik tombol <strong>"Simpan Perubahan"</strong> di atas atau di bawah tabel.</p>
                        </div>
                    </div>
                </div>

                <!-- TABLE DISPLAY CONTAINER (SCROLLABLE ON MOBILE) -->
                <div class="overflow-x-auto mb-3" id="printableTableSection">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse table-custom-border" id="dataDisplayTable">
                        <!-- Injected via JavaScript based on table code and year -->
                    </table>
                </div>

                <!-- ACTION ROW UNDER TABLE: + Tambah Baris Data -->
                <div class="flex items-center justify-between mb-5">
                    <button type="button" onclick="addNewRow()" 
                            class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl bg-orange-100 hover:bg-[#f98825] text-[#f98825] hover:text-white font-bold text-xs border border-orange-300 hover:border-transparent transition-all shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>+ Tambah Baris Data</span>
                    </button>
                    <span class="text-[11px] text-slate-400 italic">Klik tombol di atas untuk menambah baris data baru ke tabel.</span>
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
                        <button onmousedown="window._isResetting = true;" onclick="resetTableOriginal()" 
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



    <!-- CELL COMMENT / CHAT DRAWER (Slide-over di samping kecil) -->
    <div id="cellCommentDrawerBackdrop" onclick="closeCellCommentDrawer()" class="fixed inset-0 bg-slate-900/30 backdrop-blur-[2px] z-50 transition-opacity duration-300 opacity-0 pointer-events-none"></div>
    <div id="cellCommentDrawer" class="fixed top-0 right-0 bottom-0 w-80 sm:w-96 bg-white z-50 shadow-2xl flex flex-col border-l border-slate-200 transform translate-x-full transition-transform duration-300 ease-out">
        <!-- Drawer Header -->
        <div class="px-4 py-3.5 border-b border-slate-200 bg-slate-50 flex items-center justify-between shrink-0">
            <div class="flex items-center space-x-2.5 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-orange-100 text-[#f95a00] flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-comments text-sm"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-slate-800 text-xs sm:text-sm truncate">Catatan Rincian Data</h3>
                    <p id="drawerCellLabel" class="text-[11px] text-slate-500 truncate" title="...">Pilih rincian data</p>
                </div>
            </div>
            <button onclick="closeCellCommentDrawer()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition-colors cursor-pointer" title="Tutup">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Selected Cell Context Bar -->
        <div class="px-4 py-2.5 bg-orange-50/60 border-b border-orange-100 flex items-center justify-between text-xs shrink-0">
            <div class="flex items-center space-x-1.5 text-slate-600">
                <span class="text-[11px]">Nilai Rincian:</span>
                <span id="drawerCellValue" class="font-extrabold text-[#ea580c] px-2 py-0.5 rounded bg-white border border-orange-200 text-xs">-</span>
            </div>
            <span id="drawerCommentCountBadge" class="text-[10px] font-bold text-slate-500 bg-white px-2 py-0.5 rounded-full border border-slate-200">0 catatan</span>
        </div>

        <!-- Chat / Comment Stream (Scrollable) -->
        <div id="drawerCommentsStream" class="flex-1 overflow-y-auto p-4 space-y-3.5 flex flex-col bg-slate-50/40">
            <!-- Dynamic Content (Empty State or Comment Bubbles) -->
        </div>

        <!-- Drawer Footer Form (Input with Orange Border matching user screenshot) -->
        <form id="drawerCommentForm" onsubmit="handleSendComment(event)" class="p-3.5 border-t border-slate-200 bg-white shrink-0">
            <div class="relative flex items-center">
                <input type="text" id="drawerCommentInput" placeholder="Tambah catatan di sini..." autocomplete="off"
                    class="w-full border-2 border-[#f95a00] focus:border-[#d94e00] focus:outline-none focus:ring-0 rounded-xl pl-3.5 pr-11 py-2.5 text-xs text-slate-800 placeholder-slate-400 bg-white transition-all shadow-2xs" />
                <button type="submit" id="btnSubmitDrawerComment" class="absolute right-1.5 px-2.5 py-1.5 rounded-lg bg-[#f95a00] hover:bg-[#d94e00] text-white text-xs font-semibold transition-colors cursor-pointer shadow-2xs" title="Kirim Catatan">
                    <i class="fa-solid fa-paper-plane text-[11px]"></i>
                </button>
            </div>
            <div class="flex items-center justify-between mt-2 text-[10px] text-slate-400">
                <span>Tekan Enter untuk mengirim</span>
                <span class="text-orange-600 font-medium">BPS &amp; OPD Kolaboratif</span>
            </div>
        </form>
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


    <!-- JAVASCRIPT TABLE EDIT LOGIC -->
    <script>
        const tableSchemas = window.tableSchemas || {};

        // Data dari Database MySQL SiMonDa Bukittinggi
        let serverDbDataStore = @json($dbDataStore ?? []);
        let serverDbMetadata = @json($dbMetadata ?? null);
        let serverDbFallbackMetadata = @json($dbFallbackMetadata ?? null);
        window.serverDbCustomTables = @json($dbCustomTables ?? []);
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

                    // Jangan timpa label tahun khusus (misal: 2022(SIUP)) menjadi strip '-'
                    const rawText = td.innerText.trim();
                    if (/^(19|20)\d{2}\s*\(SIUP\)$/.test(rawText)) {
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

            // Khusus tabel 11.2, 3.1.8, & 3.2.8: atur 6 rentang tahun historis pada bagian Jumlah [targetYear, targetYear-1, ..., targetYear-5]
            if (currentTableCode === '11.2' || currentTableCode === '3.1.8' || currentTableCode === '3.2.8') {
                const yr = parseInt(targetYear) || 2026;
                // Bersihkan baris siluman / orphaned row sebelum Jumlah jika ada
                const allTrs = Array.from(tempTable.querySelectorAll('tbody tr'));
                allTrs.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    // Jika sel pertama berisi '-' dengan rowspan besar pada kecamatan, bersihkan
                    if (tds.length >= 2 && tds[1].getAttribute('rowspan') && tds[1].innerText.trim() === '-') {
                        tds[1].remove();
                        tds[0].setAttribute('colspan', '2');
                    }
                    if (tds.length >= 2 && tds[0].innerText.trim() === '-' && tr.nextElementSibling && tr.nextElementSibling.innerText.includes('Jumlah')) {
                        tr.remove();
                    }
                });

                const jumlahCell = Array.from(tempTable.querySelectorAll('td')).find(td => td.innerText.trim().startsWith('Jumlah'));
                if (jumlahCell) {
                    let currentRow = jumlahCell.parentElement;
                    for (let i = 0; i < 6; i++) {
                        if (!currentRow) break;
                        const y = yr - i;
                        const label = (y <= 2022 && currentTableCode === '11.2') ? `${y}(SIUP)` : `${y}`;
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

        // Query params parsing
        const urlParams = new URLSearchParams(window.location.search);
        let currentTableCode = urlParams.get('code') || urlParams.get('table') || '{{ $currentTableCode ?? "8.1.1" }}';
        let currentOpdCode = urlParams.get('opd') || '{{ $currentOpdCode ?? "01" }}';
        let currentYear = urlParams.get('year') || '{{ $currentYear ?? "2025" }}';
        let currentType = urlParams.get('type') || '{{ $currentType ?? "opd" }}';

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

        function cleanHtmlYearRanges(html) {
            if (!html || typeof html !== 'string') return html;
            return html.replace(/<div>\s*((?:19|20)\d{2})\s*<\/div>\s*<div class="italic[^>]*>\s*((?:19|20)\d{2})\s*<\/div>/gi, '<div>$1/$2</div>');
        }

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
                console.warn('[LocalStorage] Kuota penuh saat menyimpan ' + key + '. Membersihkan cache HTML lama...', e);
                try {
                    cleanupLocalStorageQuota(true);
                    localStorage.setItem(key, val);
                } catch (retryErr) {
                    console.warn('[LocalStorage] Gagal menyimpan ke cache lokal browser; data server database tetap aman.', retryErr);
                }
            }
        }

        // Initialize Page
        document.addEventListener('DOMContentLoaded', () => {
            // Bersihkan kelebihan kuota localStorage browser secara otomatis (force purge non-active table HTML)
            cleanupLocalStorageQuota(true);

            // Clean up accidental saves
            try {
                localStorage.removeItem('simonda_table_html_1.1.6_2026');
                localStorage.removeItem('simonda_table_html_8.1.2_2026');
                localStorage.removeItem('simonda_table_html_8.1.2_2027');
                for (let y = 2015; y <= 2035; y++) {
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
                }
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
                    const tid311 = localStorage.getItem(`simonda_table_title_id_3.1.1_${y}`);
                    if (tid311 && !tid311.includes('Rasio Jenis Kelamin')) {
                        localStorage.removeItem(`simonda_table_title_id_3.1.1_${y}`);
                        localStorage.removeItem(`simonda_table_title_en_3.1.1_${y}`);
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

            renderEditTablePage();
            fetchTableComments();
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (typeof closeAddTableModal === 'function') closeAddTableModal();
                    if (typeof closeCellCommentDrawer === 'function') closeCellCommentDrawer();
                }
            });
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
            const showRangeInDropdown = isMultiYear && currentTableCode !== '9.3' && currentTableCode !== '9.4';
            selectYearEl.innerHTML = '';
            for (let y = endYear; y >= 2018; y--) {
                const opt = document.createElement('option');
                opt.value = y.toString();
                const p = getTablePeriod(y, currentTableCode);
                if (isExcludeSelectedYear) {
                    opt.textContent = `Tahun ${y} (${y - 5}–${y - 1})`;
                } else if (showRangeInDropdown) {
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
                } else if (showRangeInDropdown && !isNaN(cNum)) {
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

            if (confirm('Beralih ke tabel lain? Pastikan perubahan Anda pada tabel ini telah disimpan terlebih dahulu.')) {
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
            } else {
                const sel = document.getElementById('tableSwitcher');
                if (sel) sel.value = currentTableCode;
            }
        }

        // --- TAMBAH BARIS DATA BARU (EDITOR) ---
        function addNewRow() {
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            const tbody = tableEl.querySelector('tbody');
            if (!tbody) return;

            // Bersihkan placeholder jika masih berupa pesan kosong
            const emptyTd = tbody.querySelector('td[colspan]');
            if (emptyTd && emptyTd.innerText.includes('Belum ada data')) {
                tbody.innerHTML = '';
            }

            const theadThs = tableEl.querySelectorAll('thead tr:last-child th');
            const totalCols = theadThs.length;

            const existingRows = tbody.querySelectorAll('tr');
            let nextNo = 1;
            existingRows.forEach(tr => {
                const firstTd = tr.querySelector('td');
                if (firstTd && !isNaN(parseInt(firstTd.innerText))) {
                    const n = parseInt(firstTd.innerText);
                    if (n >= nextNo) nextNo = n + 1;
                }
            });

            const tr = document.createElement('tr');

            // Cek apakah tabel memiliki kolom aksi di thead
            const hasActionCol = Boolean(tableEl.querySelector('thead .col-edit-action'));
            const dataColsCount = hasActionCol ? (totalCols - 1) : totalCols;

            let html = '';
            // Kolom 1: No
            html += `<td class="py-2.5 px-4 text-center border border-slate-700 font-bold">${nextNo}</td>`;

            if (dataColsCount === 4) {
                // Standar 4 Kolom BPS: No, Rincian Indikator, Capaian Nilai, Satuan
                html += `
                    <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                        <input type="text" class="table-edit-input" value="Indikator ${nextNo}" style="text-align: left; font-weight: 600;" spellcheck="false" />
                    </td>
                    <td class="py-2.5 px-4 text-center border border-slate-700">
                        <input type="text" class="table-edit-input" value="-" style="text-align: center; font-weight: 600;" spellcheck="false" />
                    </td>
                    <td class="py-2.5 px-4 text-center border border-slate-700">
                        <input type="text" class="table-edit-input" value="-" style="text-align: center; font-weight: 600;" spellcheck="false" />
                    </td>
                `;
            } else if (dataColsCount === 3) {
                html += `
                    <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                        <input type="text" class="table-edit-input" value="Indikator ${nextNo}" style="text-align: left; font-weight: 600;" spellcheck="false" />
                    </td>
                    <td class="py-2.5 px-4 text-center border border-slate-700">
                        <input type="text" class="table-edit-input" value="-" style="text-align: center; font-weight: 600;" spellcheck="false" />
                    </td>
                `;
            } else {
                html += `
                    <td class="py-2.5 px-4 font-semibold border border-slate-700 text-left">
                        <input type="text" class="table-edit-input" value="Indikator ${nextNo}" style="text-align: left; font-weight: 600;" spellcheck="false" />
                    </td>
                `;
                for (let c = 2; c < dataColsCount; c++) {
                    html += `
                        <td class="py-2.5 px-4 text-center border border-slate-700">
                            <input type="text" class="table-edit-input" value="-" style="text-align: center; font-weight: 600;" spellcheck="false" />
                        </td>
                    `;
                }
            }

            // Kolom Aksi
            html += `
                <td class="col-edit-action py-1.5 px-2 text-center border border-slate-700 bg-amber-50/50 align-middle">
                    <button type="button" onclick="deleteSpecificRow(this)" 
                            class="p-1 px-2 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-300 hover:border-rose-600 rounded transition-all text-xs font-semibold flex items-center justify-center gap-1 shadow-2xs mx-auto cursor-pointer" 
                            title="Hapus baris ini dari tabel">
                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                    </button>
                </td>
            `;

            tr.innerHTML = html;

            tr.querySelectorAll('.table-edit-input').forEach(inp => {
                inp.addEventListener('input', () => {
                    inp.setAttribute('value', inp.value);
                    window._hasUnsavedEdits = true;
                });
            });

            tbody.appendChild(tr);

            const firstInput = tr.querySelector('.table-edit-input');
            if (firstInput) {
                firstInput.focus();
                firstInput.select();
            }

            window._hasUnsavedEdits = true;
            showToast('✅ Baris data baru berhasil ditambahkan! Klik "Simpan Perubahan" setelah selesai.');
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

            if (typeof getAgencyInfoForTable === 'function') {
                const autoAgency = getAgencyInfoForTable(currentTableCode, currentOpdCode, currentType);
                if (autoAgency && autoAgency.opdCode) {
                    currentOpdCode = autoAgency.opdCode;
                    if (autoAgency.type) currentType = autoAgency.type;
                }
            }
            renderEditTablePage();
        });

        function renderEditTablePage() {
            const isInstansi = currentType === 'instansi';
            const isBps = currentType === 'bps';
            const agencyName = getAgencyName(currentOpdCode);

            const breadcrumbCatalogLink = document.getElementById('breadcrumbCatalogLink');
            const breadcrumbCatalogText = document.getElementById('breadcrumbCatalogText');
            if (breadcrumbCatalogLink) {
                breadcrumbCatalogLink.href = isBps ? "{{ route('data-bps') }}" : (isInstansi ? "{{ route('isi-data-instansi') }}" : "{{ route('isi-data-opd') }}");
            }
            if (breadcrumbCatalogText) {
                breadcrumbCatalogText.innerText = isBps ? 'Data BPS' : (isInstansi ? 'Daftar Instansi' : 'Daftar OPD');
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
            const p = getTablePeriod(yr, currentTableCode);
            const isRangeTable = (schema.isMultiYear || schema.isExcludeSelectedYear || currentTableCode === '8.2.2') && currentTableCode !== '9.3' && currentTableCode !== '9.4';
            const yearLabel = schema.isExcludeSelectedYear ? `${yr - 5}–${yr - 1}` : (isRangeTable ? p.label : `${yr}`);
            document.getElementById('pageMainHeading').innerText = isRangeTable ? `Edit Data Tabel ${currentTableCode} (${yearLabel})` : `Edit Data Tabel ${currentTableCode} Tahun ${currentYear}`;

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

            // Bersihkan jika title hanya berisi kata 'Table' atau 'Tabel'
            if (customTitleEn && (customTitleEn.trim().toLowerCase() === 'table' || customTitleEn.trim().toLowerCase() === 'tabel')) {
                localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                customTitleEn = null;
            }
            if (customTitleId && (customTitleId.trim().toLowerCase() === 'table' || customTitleId.trim().toLowerCase() === 'tabel' || /2023\/20\d{2}/.test(customTitleId) || /2024\/20\d{2}/.test(customTitleId))) {
                localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                customTitleId = null;
            }

            // Bersihkan custom title jika masih berupa placeholder generik lawas atau terpotong
            if (catInfo && catInfo.title) {
                if (customTitleId && customTitleId.includes('Tabel Data Statistik Sektoral')) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && customTitleEn.includes('Sectoral Statistics Table')) {
                    localStorage.removeItem(`simonda_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
                if (customTitleId && currentTableCode === '3.1.1' && !customTitleId.includes('Rasio Jenis Kelamin')) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && currentTableCode === '3.1.1' && !customTitleEn.includes('Sex Ratio')) {
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

            // For Table 8.1.1, 8.1.2, 8.1.3, 8.2.2, and 9.1, ensure title always reflects the exact 5-year range [yr-4, yr]
            if (currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.2.2' || currentTableCode === '9.1' || currentTableCode === '4.2.4' || currentTableCode === '4.2.5' || currentTableCode === '4.2.7' || currentTableCode === '4.2.9' || currentTableCode === '4.2.10' || currentTableCode === '4.2.13' || currentTableCode === '4.2.15' || currentTableCode === '4.2.16') {
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

            // For Table 9.3 and 9.4, ensure title does not contain year range, but single year [yr]
            if (currentTableCode === '9.3' || currentTableCode === '9.4') {
                const yrInt = parseInt(currentYear) || 2025;
                if (customTitleId && (customTitleId.match(/(19|20)\d{2}\s*[–\-]\s*(19|20)\d{2}/) || (currentTableCode === '9.4' && !customTitleId.includes(currentYear)))) {
                    localStorage.removeItem(`simonda_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && (customTitleEn.match(/(19|20)\d{2}\s*[–\-]\s*(19|20)\d{2}/) || (currentTableCode === '9.4' && !customTitleEn.includes(currentYear)))) {
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
                // Khusus tabel pendidikan 4.1.x: tahun ajaran SiAngka Bukittinggi = Tahun + 1 (misal 2025 -> 2025/2026)
                if (typeof currentTableCode === 'string' && currentTableCode.startsWith('4.1') && currentTableCode !== '4.1.20' && currentTableCode !== '4.1.24') {
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
            const rawSource = customSource ? customSource : schema.source;
            const cleanSourceHtml = (rawSource || '').replace(/^\s*(?:sumber\s*[\/:]\s*source|sumber\s*[\/:]|source\s*[\/:]|sumber|source)\s*:\s*/i, '').trim();
            document.getElementById('tableSourceContent').innerHTML = cleanSourceHtml;

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

            // Check if user previously saved custom data (prioritas database, kemudian localStorage)
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

            // Sanity check: jika savedHtml dari localStorage rusak atau tidak mengandung struktur <tr> dan <th>, bersihkan
            if (savedHtml && (!savedHtml.includes('<tr') || !savedHtml.includes('<th'))) {
                removeScopedLocalStorageItem('simonda_table_html');
                removeScopedLocalStorageItem('simonda_table_is_saved');
                savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
            }

            if (savedHtml && currentTableCode === '2.4.2') {
                savedHtml = savedHtml.replace(/Jenis Pendapatan/gi, 'Jenis Belanja');
                savedHtml = savedHtml.replace(/Kind of Revenues/gi, 'Kind of Expenditures');
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

            // Validasi savedHtml untuk tabel multi-tahun (8.1.1, 8.1.2, 8.1.3, 8.1.4, 8.1.5, 8.2.2, 2.2.5, 1.1.10, 9.1, 9.3 atau schema.isMultiYear)
            const isMultiYearTable = Boolean(schema && (schema.isMultiYear || schema.isExcludeSelectedYear)) || 
                                     ['8.1.1', '8.1.2', '8.1.3', '8.1.4', '8.1.5', '8.1.6', '8.2.2', '2.2.5', '1.1.10', '9.1', '9.3', '2.4.3', '2.4.1', '2.4.2'].includes(currentTableCode);

            if (currentTableCode === '9.3' && savedHtml) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedStartYear = (yrInt - 6).toString();
                const expectedEndYear = yrInt.toString();
                if (!savedHtml.includes(expectedStartYear) || !savedHtml.includes(expectedEndYear)) {
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
            if (savedHtml && (currentTableCode === '1.1.10' || currentTableCode === '8.1.5' || currentTableCode === '8.1.4' || currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '2.2.5' || currentTableCode === '9.1')) {
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

            if (isMultiYearTable && savedHtml && currentTableCode !== '9.3') {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const allThs = Array.from(tempDiv.querySelectorAll('thead th'));
                const yrInt = parseInt(currentYear) || 2025;
                const p = getTablePeriod(yrInt, currentTableCode);
                const expectedStartYear = p.start.toString();
                const expectedEndYear = p.end.toString();
                const hasStartYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedStartYear));
                const hasEndYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedEndYear));
                const firstRowTds = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td') : [];
                const minCols = (currentTableCode === '4.1.20') ? 5 : 6;
                const isMissingCells = firstRowTds.length > 0 && firstRowTds.length < minCols;

                if (!isLocallySaved && (!hasStartYearInHeader || !hasEndYearInHeader || isMissingCells) && currentTableCode !== '8.1.4' && currentTableCode !== '8.1.5' && currentTableCode !== '1.1.10') {
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
                    savedHtml = tableSchemas['1.1.6'].render(currentYear);
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

            // Self-healing tabel 11.2, 3.1.8, & 3.2.8 (NIB Sektor, Penduduk Wajib KTP, Pencari Kerja)
            if ((currentTableCode === '11.2' || currentTableCode === '3.1.8' || currentTableCode === '3.2.8') && savedHtml) {
                const yrStr = currentYear.toString();
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const jumlahCell = Array.from(tempDiv.querySelectorAll('td')).find(td => td.innerText.trim().startsWith('Jumlah'));
                let isCorruptMulti = false;
                if (jumlahCell) {
                    const rowTds = jumlahCell.parentElement.querySelectorAll('td');
                    if (rowTds.length >= 2) {
                        const topYearText = rowTds[1].innerText.trim();
                        if (topYearText === '-' || topYearText !== yrStr) {
                            isCorruptMulti = true;
                        }
                    }
                }
                const ghostRow = Array.from(tempDiv.querySelectorAll('tbody tr')).find(tr => {
                    const tds = tr.querySelectorAll('td');
                    return tds.length >= 2 && tds[0].innerText.trim() === '-' && tr.nextElementSibling && tr.nextElementSibling.innerText.includes('Jumlah');
                });
                if (ghostRow) isCorruptMulti = true;

                // Cek ghost cell rowspan di baris kecamatan untuk 3.1.8
                const ghostCol318 = tempDiv.querySelector('tbody tr td[rowspan="3"]');
                if (ghostCol318 && ghostCol318.innerText.trim() === '-') {
                    isCorruptMulti = true;
                }

                if (isCorruptMulti) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Self-healing tabel 9.4, 5.1.18 & tabel kecamatan: pastikan Kolom 6 selalu diganti dengan Aur Birugo Tigo Baleh
            if (savedHtml && (savedHtml.includes('Kolom 6') || savedHtml.includes('kolom 6'))) {
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

            // Self-healing tabel 5.1.19: pastikan urutan tahun selalu urut naik (ascending) dan thead tidak memiliki colspan 2
            if (currentTableCode === '5.1.19' && savedHtml) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedLastPastYear = (yrInt - 1).toString();
                if ((savedHtml.includes('colspan="2"') && savedHtml.includes('Kecamatan')) || !savedHtml.includes(expectedLastPastYear)) {
                    localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
                }
            }

            // Self-healing tabel 9.1: baris ke-4 adalah Bukittinggi (bukan Jumlah / Total)
            if (currentTableCode === '9.1' && savedHtml && (savedHtml.includes('Jumlah') || savedHtml.includes('Total'))) {
                savedHtml = savedHtml.replace(/Jumlah\s*\/\s*<span[^>]*>Total<\/span>/gi, 'Bukittinggi')
                                     .replace(/Jumlah\s*\/\s*Total/gi, 'Bukittinggi')
                                     .replace(/<td([^>]*)>\s*Jumlah\s*<\/td>/gi, '<td$1>Bukittinggi</td>');
                safeSetLocalStorage(`simonda_table_html_${currentTableCode}_${currentYear}`, savedHtml);
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
                            // Self-healing tabel 1.1.8 (Kantor Pertanahan): Bersihkan cache lokal jika format lama 3 kolom atau rentang tahun salah
                if (currentTableCode === '1.1.8' && savedHtml) {
                    if (savedHtml.includes('w-[60%]') || !savedHtml.includes('(7)') || !savedHtml.includes(currentYear.toString())) {
                        localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                        localStorage.removeItem(`simonda_table_source_${currentTableCode}_${currentYear}`);
                        localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    }
                }
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
                    savedHtml = null;
                }
            }

            // Sanity check untuk Tabel 8.1.1 & tabel sejenis: Jika sel data numerik berisi teks label baris
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
                    localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

            // Sanity check: jika savedHtml adalah starter dummy placeholder ("Indikator 1" / "Indicator Details" / "Belum ada data")
            if (savedHtml && (savedHtml.includes('Indicator Details') || (savedHtml.includes('Indikator 1') && savedHtml.includes('Rincian Indikator')) || savedHtml.includes('Belum ada data untuk tabel ini'))) {
                localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
                savedHtml = null;
            }

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

                // Rapikan kolom No kecamatan restart 1, 2 untuk masing-masing sungai
                const trs = tableEl.querySelectorAll('tbody tr');
                let currentNo = 1;
                trs.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 4) {
                        currentNo = 1;
                        tds[2].innerHTML = '1';
                        tds[2].className = 'py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800';
                        currentNo = 2;
                    } else if (tds.length >= 2) {
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

            // Khusus Tabel Dinas 08 / Tabel 4.1.x (Tabel Pendidikan: Sekolah, Guru, Murid)
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

            // Transform cells to editable grid with orange inputs
            transformToEditableGrid(tableEl);

            if (typeof renderCellCommentBadges === 'function') {
                renderCellCommentBadges();
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
                    safeSetLocalStorage(savedKey, table.innerHTML);
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

        function safeEscapeHtml(str) {
            if (str === null || str === undefined) return '';
            return str.toString()
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        function transformHeaderToEditable(tableEl) {
            if (!tableEl) return;
            const thead = tableEl.querySelector('thead');
            if (!thead) return;

            const theadRows = thead.querySelectorAll('tr');
            if (theadRows.length === 0) return;

            theadRows.forEach((tr) => {
                const ths = tr.querySelectorAll('th');
                // Cek apakah baris ini adalah baris nomor kolom, misal (1), (2), (3) atau dengan background peach
                const isNumberingRow = tr.classList.contains('bg-[#fed7aa]') || 
                                       tr.classList.contains('subtable-header-numbering') ||
                                       (Array.from(ths).filter(th => !th.classList.contains('col-edit-action')).every(th => {
                                           const txt = th.innerText.trim();
                                           return /^\s*\(\s*\d+\s*\)\s*$/.test(txt) || /^\s*-\s*\d+\s*-?\s*$/.test(txt) || txt.toLowerCase() === 'no' || /^\s*\d+\s*$/.test(txt);
                                       }) && Array.from(ths).some(th => /^\s*\(\s*\d+\s*\)\s*$/.test(th.innerText.trim())));

                ths.forEach((th, cIdx) => {
                    if (th.classList.contains('col-edit-action')) return;
                    if (th.querySelector('.table-edit-header-input')) return;

                    if (isNumberingRow) {
                        let val = th.innerText.trim();
                        if (!val) {
                            val = `(${cIdx + 1})`;
                        }
                        th.innerHTML = `
                            <div class="flex items-center justify-center p-0.5 w-full">
                                <input type="text" 
                                       class="table-edit-input table-edit-header-input table-edit-header-num" 
                                       value="${safeEscapeHtml(val)}" 
                                       title="Ubah nomor kolom (contoh: (1), (2), dst)" 
                                       spellcheck="false" />
                            </div>
                        `;
                    } else {
                        // Header Judul Kolom
                        const childDivs = Array.from(th.children).filter(el => el.tagName === 'DIV');
                        const hasSub = childDivs.length >= 2 && (childDivs[1].classList.contains('italic') || childDivs[1].innerText.trim().length > 0);
                        
                        if (hasSub) {
                            let titleVal = childDivs[0].innerText.trim();
                            let subVal = childDivs[1].innerText.trim();
                            if ((currentTableCode === '2.2.2' || (tableEl && tableEl.innerText.includes('Partai'))) && /kolom\s*6/i.test(titleVal)) {
                                titleVal = 'S2/S3';
                            } else if ((currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) && /kolom\s*6/i.test(titleVal)) {
                                titleVal = 'AB';
                            }
                            th.innerHTML = `
                                <div class="flex flex-col gap-1 items-center justify-center p-1 w-full">
                                    <input type="text" 
                                           class="table-edit-input table-edit-header-input table-edit-header-title" 
                                           value="${safeEscapeHtml(titleVal)}" 
                                           placeholder="Judul Kolom" 
                                           title="Ubah judul utama kolom"
                                           spellcheck="false" />
                                    <input type="text" 
                                           class="table-edit-input table-edit-header-input table-edit-header-sub italic" 
                                           value="${safeEscapeHtml(subVal)}" 
                                           placeholder="Subtitle / Bahasa Inggris" 
                                           title="Ubah teks terjemahan / subtitle"
                                           spellcheck="false" />
                                </div>
                            `;
                        } else {
                            let titleVal = childDivs.length === 1 ? childDivs[0].innerText.trim() : th.innerText.trim();
                            if ((currentTableCode === '2.2.2' || (tableEl && tableEl.innerText.includes('Partai'))) && /kolom\s*6/i.test(titleVal)) {
                                titleVal = 'S2/S3';
                            } else if ((currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) && /kolom\s*6/i.test(titleVal)) {
                                titleVal = 'AB';
                            }
                            th.innerHTML = `
                                <div class="flex items-center justify-center p-1 w-full">
                                    <input type="text" 
                                           class="table-edit-input table-edit-header-input table-edit-header-title" 
                                           value="${safeEscapeHtml(titleVal)}" 
                                           placeholder="Judul Kolom" 
                                           title="Ubah judul kolom"
                                           spellcheck="false" />
                                </div>
                            `;
                        }
                    }

                    th.querySelectorAll('.table-edit-header-input').forEach(inp => {
                        inp.addEventListener('input', () => {
                            inp.setAttribute('value', inp.value);
                            window._hasUnsavedEdits = true;
                        });
                    });
                });
            });
        }

        function transformToEditableGrid(tableEl) {
            if (!tableEl) return;
            // 1. Transformasi seluruh kepala kolom tabel (thead) menjadi input yang bisa diedit
            transformHeaderToEditable(tableEl);

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
                                inputEl.addEventListener('input', () => {
                                    inputEl.setAttribute('value', inputEl.value);
                                    window._hasUnsavedEdits = true;
                                });
                            }
                        }
                    });
                });
                appendActionColumnToEditor(tableEl);
                return;
            }

            // Khusus Tabel Dinas 08 / Tabel 4.1.x: Tabel Pendidikan (Sekolah, Guru, Murid)
            const isEducation3in1Edit = ['4.1.1', '4.1.2', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'].includes(currentTableCode);
            if (isEducation3in1Edit) {
                rows.forEach(tr => {
                    const text = tr.innerText.trim();
                    const tds = tr.querySelectorAll('td, th');
                    
                    // Cek baris header dalam tbody (Guru / Murid headers) atau baris pemisah -> JANGAN jadikan input!
                    const firstCellText = (tds[0] ? tds[0].innerText.trim() : '');
                    const isDistrictRow = /^\s*0?\d\./.test(firstCellText) || 
                                          firstCellText.includes('Guguk') || 
                                          firstCellText.includes('Mandiangin') || 
                                          firstCellText.includes('Aur Birugo');
                    const isTotalRow = firstCellText === 'Bukittinggi' || firstCellText.startsWith('Bukittinggi');

                    // Cek baris header dalam tbody (Guru / Murid headers) atau baris pemisah -> JANGAN jadikan input!
                    const isHeader = tr.classList.contains('subtable-spacer-row') ||
                                     text.includes('Guru') || text.includes('Teachers') || 
                                     text.includes('Murid') || text.includes('Students') ||
                                     text.includes('Negeri') || text.includes('Swasta') ||
                                     (!isDistrictRow && !isTotalRow && /\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(text) && tds.length >= 6) ||
                                     text.includes('(1)') || text.includes('-1') ||
                                     tds.length === 1; // Baris separator

                    if (isHeader) {
                        return;
                    }
                    
                    tds.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        
                        // Kolom 0: Kecamatan / Bukittinggi -> label tetap
                        if (idx === 0) {
                            td.classList.add('font-bold', 'text-left');
                            return;
                        }

                        // Kolom Data & Total: buat editable input
                        if (!td.querySelector('.table-edit-input')) {
                            let val = td.innerText.trim();
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="${val}" style="text-align: right; font-weight: ${isTotalRow ? '700' : '600'}; padding-right: 0.5rem;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('input', () => {
                                    inputEl.setAttribute('value', inputEl.value);
                                    window._hasUnsavedEdits = true;
                                });
                            }
                        }
                    });
                });
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
                                inputEl.addEventListener('input', () => {
                                    inputEl.setAttribute('value', inputEl.value);
                                    window._hasUnsavedEdits = true;
                                });
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
                                inputEl.addEventListener('input', () => {
                                    inputEl.setAttribute('value', inputEl.value);
                                    window._hasUnsavedEdits = true;
                                });
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
                        } else if (idx > 0 && val !== '-' && val !== '') {
                            val = formatBpsNumber(val);
                        }
                        let isResultInput = (idx > 0);
                        if (cells.length === 4 && (currentTableCode.startsWith('custom_') || (!currentTableCode.startsWith('2.') && !currentTableCode.startsWith('4.') && !currentTableCode.startsWith('5.') && !currentTableCode.startsWith('8.')))) {
                            isResultInput = (idx === 2);
                        }
                        const isTotal = tr.classList.contains('font-bold') || tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total');
                        const alignStyle = isResultInput 
                            ? `text-align: right; font-weight: ${isTotal ? '700' : '600'}; padding-right: 0.5rem;` 
                            : 'text-align: center; font-weight: 600;';
                        td.innerHTML = `
                            <div class="flex items-center justify-center p-1">
                                <input type="text" class="table-edit-input" value="${val}" style="${alignStyle}" spellcheck="false" />
                            </div>
                        `;
                        const inputEl = td.querySelector('.table-edit-input');
                        if (inputEl) {
                            inputEl.addEventListener('input', () => {
                                inputEl.setAttribute('value', inputEl.value);
                                window._hasUnsavedEdits = true;
                            });
                            inputEl.addEventListener('blur', (e) => {
                                const formatter = (isFinancialTable && idx > 0) ? formatRupiahNumber : formatBpsNumber;
                                const formatted = formatter(e.target.value);
                                if (formatted !== e.target.value) {
                                    e.target.value = formatted;
                                }
                                inputEl.setAttribute('value', e.target.value);
                            });
                            inputEl.addEventListener('change', () => {
                                const formatter = (isFinancialTable && idx > 0) ? formatRupiahNumber : formatBpsNumber;
                                inputEl.value = formatter(inputEl.value);
                                inputEl.setAttribute('value', inputEl.value);
                                window._hasUnsavedEdits = true;
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
            // JANGAN PERNAH hapus baris data resmi pada tabel Dishub (8.1.x, OPD 20), BPN (1.1.x), BKPSDM (2.3.x), Pendidikan (4.1.x, 08), KPU/DPRD (2.2.2, 02, 03), atau Pertanian (5.1.x, 5.2.x, 9.11)
            if (currentTableCode === '2.2.2' || currentTableCode.startsWith('1.1.') || currentTableCode.startsWith('2.3.') || currentTableCode.startsWith('4.1') || currentTableCode.startsWith('5.1.') || currentTableCode.startsWith('5.2.') || currentTableCode.startsWith('8.1.') || currentTableCode.startsWith('8.2.') || currentTableCode === '9.11' || currentOpdCode === '02' || currentOpdCode === '03' || currentOpdCode === '08' || currentOpdCode === '04' || currentOpdCode === '20' || currentOpdCode === '17') return;
            const tbody = table.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            let removedAny = false;
            rows.forEach(tr => {
                const tds = Array.from(tr.querySelectorAll('td')).filter(td => !td.classList.contains('col-edit-action'));
                if (tds.length === 0) return;
                // Baris yang memiliki label teks kategori/indikator di kolom pertama BUKAN baris hantu
                const labelText = tds[0].innerText.trim();
                if (/[a-zA-Z]{2,}/.test(labelText)) {
                    return;
                }
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
                window._hasUnsavedEdits = true;
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
                window._hasUnsavedEdits = true;
                showToast('🗑️ Baris paling bawah berhasil dihapus! Klik "Simpan Perubahan" setelah selesai.');
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
                window._hasUnsavedEdits = true;
                showToast('🗑️ Baris tabel berhasil dihapus! Klik "Simpan Perubahan" setelah selesai.');
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

            renderEditTablePage();
            showToast(`Tahun data diubah ke ${currentYear}`);
        }

        async function resetTableOriginal() {
            window._isResetting = true;
            if (!confirm(`Apakah Anda yakin ingin mereset/menghapus seluruh nilai data Tabel ${currentTableCode} untuk tahun ${currentYear}? Seluruh angka data yang sudah terisi akan terhapus dan kembali kosong (-).`)) {
                window._isResetting = false;
                return;
            }

            // 1. Bersihkan seluruh cache localStorage untuk tabel & tahun ini
            try {
                const scopedPrefix = `${typeof currentType !== 'undefined' ? currentType : 'opd'}_${(typeof currentOpdCode !== 'undefined' ? currentOpdCode : '01').toString().padStart(2, '0')}_${currentTableCode}`;
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (k && (k.includes(scopedPrefix) || k.includes(`${currentTableCode}_${currentYear}`))) {
                        keysToRemove.push(k);
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
            } catch(e) {}

            // 2. Bangun HTML kosong (seluruh angka data di-wipe menjadi '-') berdasarkan struktur tabel saat ini
            const tableEl = document.getElementById('dataDisplayTable');
            let emptyHtml = null;
            if (tableEl) {
                const clone = tableEl.cloneNode(true);
                clone.querySelectorAll('.col-edit-action').forEach(el => el.remove());
                
                // Kembalikan header th ke teks statis
                clone.querySelectorAll('thead th').forEach(th => {
                    const titleInp = th.querySelector('.table-edit-header-title');
                    const subInp = th.querySelector('.table-edit-header-sub');
                    const numInp = th.querySelector('.table-edit-header-num');
                    if (titleInp && subInp) {
                        const title = (titleInp.value || titleInp.getAttribute('value') || '').trim();
                        const sub = (subInp.value || subInp.getAttribute('value') || '').trim();
                        th.innerHTML = sub ? `<div>${title}</div><div class="italic font-normal text-[11px] sm:text-xs">${sub}</div>` : `<div>${title}</div>`;
                    } else if (titleInp) {
                        th.innerHTML = `<div>${(titleInp.value || titleInp.getAttribute('value') || '').trim()}</div>`;
                    } else if (numInp) {
                        let numVal = (numInp.value || numInp.getAttribute('value') || '').trim();
                        if (numVal && !numVal.startsWith('(') && /^\d+$/.test(numVal)) numVal = `(${numVal})`;
                        th.innerHTML = numVal;
                    }
                });

                // Kosongkan seluruh sel input data di tbody menjadi '-'
                clone.querySelectorAll('tbody tr').forEach(tr => {
                    const tds = tr.querySelectorAll('td, th');
                    tds.forEach((td, idx) => {
                        const input = td.querySelector('.table-edit-input');
                        if (input) {
                            td.innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                            td.className = td.className.replace(/text-(left|right)/g, '') + ' text-center align-middle';
                        }
                    });
                });

                emptyHtml = clone.innerHTML;
            }

            // Jika ada buildEmptyTemplateFromSource, gunakan untuk memastikan struktur tahun teratur
            if (emptyHtml && typeof buildEmptyTemplateFromSource === 'function') {
                emptyHtml = buildEmptyTemplateFromSource(emptyHtml, currentYear, currentYear);
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
                        default_html: emptyHtml
                    })
                });
            } catch(e) {
                console.error('Reset API error:', e);
            }

            // 4. Update in-memory server metadata
            if (serverDbMetadata) {
                serverDbMetadata.table_html = emptyHtml;
                serverDbMetadata.is_saved = false;
                serverDbMetadata.source_type = 'template';
            }

            window._hasUnsavedEdits = false;
            showToast('🗑️ Seluruh nilai data tabel berhasil dihapus/direset ke kosong (-)!');
            setTimeout(() => {
                window.location.reload();
            }, 300);
        }

        async function persistTableData(redirectAfter = false) {
            if (window._isResetting) return;
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            
            // 1. Commit input yang sedang fokus saat tombol simpan ditekan
            if (document.activeElement && document.activeElement.blur) {
                try { document.activeElement.blur(); } catch(e) {}
            }

            // 2. Pastikan nilai yang diketik disinkronkan ke atribut DOM sebelum cloning
            tableEl.querySelectorAll('.table-edit-input').forEach(inp => {
                inp.setAttribute('value', inp.value);
            });

            const clone = tableEl.cloneNode(true);
            clone.querySelectorAll('.col-edit-action').forEach(el => el.remove());

            // 3. Konversi kembali elemen input di header (thead th) ke format HTML standar BPS
            clone.querySelectorAll('thead th').forEach(th => {
                if (th.classList.contains('col-edit-action')) return;

                const titleInp = th.querySelector('.table-edit-header-title');
                const subInp = th.querySelector('.table-edit-header-sub');
                const numInp = th.querySelector('.table-edit-header-num');

                if (titleInp && subInp) {
                    let title = (titleInp.value !== undefined ? titleInp.value : titleInp.getAttribute('value') || '').trim();
                    let sub = (subInp.value !== undefined ? subInp.value : subInp.getAttribute('value') || '').trim();
                    if ((currentTableCode === '2.2.2' || (tableEl && tableEl.innerText.includes('Partai'))) && /kolom\s*6/i.test(title)) {
                        title = 'S2/S3';
                    } else if ((currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) && /kolom\s*6/i.test(title)) {
                        title = 'AB';
                    }
                    if (sub) {
                        th.innerHTML = `<div>${title}</div><div class="italic font-normal text-[11px] sm:text-xs">${sub}</div>`;
                    } else {
                        th.innerHTML = `<div>${title}</div>`;
                    }
                } else if (titleInp) {
                    let title = (titleInp.value !== undefined ? titleInp.value : titleInp.getAttribute('value') || '').trim();
                    if ((currentTableCode === '2.2.2' || (tableEl && tableEl.innerText.includes('Partai'))) && /kolom\s*6/i.test(title)) {
                        title = 'S2/S3';
                    } else if ((currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) && /kolom\s*6/i.test(title)) {
                        title = 'AB';
                    }
                    th.innerHTML = `<div>${title}</div>`;
                } else if (numInp) {
                    let numVal = (numInp.value !== undefined ? numInp.value : numInp.getAttribute('value') || '').trim();
                    if (numVal && !numVal.startsWith('(') && /^\d+$/.test(numVal)) {
                        numVal = `(${numVal})`;
                    }
                    th.innerHTML = numVal;
                } else {
                    const singleInp = th.querySelector('.table-edit-input');
                    if (singleInp) {
                        const val = (singleInp.value !== undefined ? singleInp.value : singleInp.getAttribute('value') || '').trim();
                        th.innerHTML = val;
                    }
                }
            });

            // 4. Konversi kembali elemen input di baris data (tbody td / th)
            const origInputs = Array.from(tableEl.querySelectorAll('tbody .table-edit-input'));
            const cloneInputs = Array.from(clone.querySelectorAll('tbody .table-edit-input'));
            const isFinancialTable = (currentOpdCode === '05' || currentTableCode.startsWith('2.4') || currentTableCode.startsWith('2.4.'));

            cloneInputs.forEach((input, idx) => {
                const cell = input.closest('td, th');
                if (cell) {
                    const origInput = origInputs[idx];
                    let finalVal = (origInput && origInput.value !== undefined) ? origInput.value.trim() : (input.value || input.getAttribute('value') || '').trim();
                    if (isFinancialTable) {
                        finalVal = formatRupiahNumber(finalVal);
                    }
                    cell.innerHTML = finalVal;
                    if (isFinancialTable && finalVal !== '-' && finalVal !== '0') {
                        cell.classList.remove('text-left', 'text-center');
                        cell.classList.add('text-right', 'font-semibold');
                        cell.style.textAlign = 'right';
                    } else if (finalVal !== '-' && finalVal !== '–' && finalVal !== '—' && !isNaN(finalVal.replace(/\./g, '').replace(',', '.'))) {
                        cell.classList.remove('text-left', 'text-center');
                        cell.classList.add('text-right', 'font-semibold');
                        cell.style.textAlign = 'right';
                    } else if (finalVal === '-' || finalVal === '–' || finalVal === '—') {
                        cell.classList.remove('text-left', 'text-right');
                        cell.classList.add('text-center');
                        cell.style.textAlign = 'center';
                    }
                }
            });

            cleanGhostRows(clone);

            // Save to localStorage
            const scopedHtmlKey = getStorageKey('simonda_table_html');
            const scopedSavedKey = getStorageKey('simonda_table_is_saved');
            safeSetLocalStorage(scopedHtmlKey, clone.innerHTML);
            safeSetLocalStorage(scopedSavedKey, '1');

            // Bersihkan legacy unscoped key agar tidak mencemari tabel kampus lain
            try {
                localStorage.removeItem(`simonda_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`simonda_table_is_saved_${currentTableCode}_${currentYear}`);
            } catch(e) {}

            // Simpan perubahan ke Database MySQL
            try {
                let rowsData = {};
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
                    const keys = ['hak_milik', 'hak_guna_bangunan', 'hak_pakai', 'hak_pengelolaan', 'hak_guna_usaha', 'hak_tanggungan'];
                    bodyRows.forEach((tr) => {
                        const firstTd = tr.querySelector('td:first-child');
                        const rowYr = firstTd ? firstTd.innerText.trim() : null;
                        if (rowYr && /^\d{4}$/.test(rowYr)) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            const inps = tr.querySelectorAll('.table-edit-input');
                            inps.forEach((inp, iIdx) => {
                                if (keys[iIdx]) {
                                    rowsData[rowYr][keys[iIdx]] = inp.value.trim();
                                }
                            });
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
                } else if (currentTableCode === '4.3.4') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const k = tr.getAttribute('data-key');
                        if (k && inputs.length >= 4) {
                            rowsData[currentYear][`${k}_kejadian`] = inputs[0].value.trim();
                            rowsData[currentYear][`${k}_korban`] = inputs[1].value.trim();
                            rowsData[currentYear][`${k}_rumah`] = inputs[2].value.trim();
                            rowsData[currentYear][`${k}_lainnya`] = inputs[3].value.trim();
                        }
                    });
                } else if (currentTableCode === '9.2') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const k = tr.getAttribute('data-key');
                        if (k && inputs.length >= 5) {
                            rowsData[currentYear][`${k}_kud`] = inputs[0].value.trim();
                            rowsData[currentYear][`${k}_kpri`] = inputs[1].value.trim();
                            rowsData[currentYear][`${k}_kopkar`] = inputs[2].value.trim();
                            rowsData[currentYear][`${k}_lainnya`] = inputs[3].value.trim();
                            rowsData[currentYear][`${k}_total`] = inputs[4].value.trim();
                        }
                    });
                } else if (currentTableCode === '9.3') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 5) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['koperasi'] = inputs[0].value.trim();
                            rowsData[rowYr]['anggota'] = inputs[1].value.trim();
                            rowsData[rowYr]['simpanan'] = inputs[2].value.trim();
                            rowsData[rowYr]['volume_usaha'] = inputs[3].value.trim();
                            rowsData[rowYr]['permodalan'] = inputs[4].value.trim();
                        }
                    });
                } else if (currentTableCode === '9.4') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const k = tr.getAttribute('data-key') || (tr.querySelector('td') ? tr.querySelector('td').innerText.trim().toLowerCase().replace(/[^a-z0-9]/g, '_') : '');
                        if (k && inputs.length >= 4) {
                            rowsData[currentYear][`${k}_gp`] = inputs[0].value.trim();
                            rowsData[currentYear][`${k}_mks`] = inputs[1].value.trim();
                            rowsData[currentYear][`${k}_abtb`] = inputs[2].value.trim();
                            rowsData[currentYear][`${k}_total`] = inputs[3].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.2') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const k = tr.getAttribute('data-key');
                        if (k) {
                            const inputs = tr.querySelectorAll('.table-edit-input');
                            inputs.forEach((inp, idx) => {
                                rowsData[currentYear][`${k}_col${idx}`] = inp.value.trim();
                            });
                        }
                    });
                } else if (currentTableCode === '4.2.4' || currentTableCode === '4.2.5') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 3) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['pemerintah'] = inputs[0].value.trim();
                            rowsData[rowYr]['swasta'] = inputs[1].value.trim();
                            rowsData[rowYr]['total'] = inputs[2].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.7') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 3) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['hidup'] = inputs[0].value.trim();
                            rowsData[rowYr]['mati'] = inputs[1].value.trim();
                            rowsData[rowYr]['ibu'] = inputs[2].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.10') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 4) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['baru'] = inputs[0].value.trim();
                            rowsData[rowYr]['lama'] = inputs[1].value.trim();
                            rowsData[rowYr]['kunjungan'] = inputs[2].value.trim();
                            rowsData[rowYr]['rata'] = inputs[3].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.15') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 5) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['pegawai'] = inputs[0].value.trim();
                            rowsData[rowYr]['truk'] = inputs[1].value.trim();
                            rowsData[rowYr]['gerobak'] = inputs[2].value.trim();
                            rowsData[rowYr]['becak_dayung'] = inputs[3].value.trim();
                            rowsData[rowYr]['becak_motor'] = inputs[4].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.16') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 2) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['timbunan'] = inputs[0].value.trim();
                            rowsData[rowYr]['terangkut'] = inputs[1].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.12') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const mNum = trIdx + 1;
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 2) {
                            rowsData[currentYear][mNum] = {
                                timbunan: inputs[0].value.trim(),
                                terangkut: inputs[1].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '4.2.13') {
                    rowsData = {};
                    const p = get5YearPeriod(currentYear);
                    p.yearsAsc.forEach(y => { rowsData[y] = {}; });
                    const catKeys = ['organik', 'logam', 'plastik', 'kaca', 'kertas', 'lainnya', 'total'];
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const key = catKeys[trIdx] || `cat_${trIdx}`;
                        p.yearsAsc.forEach((y, yIdx) => {
                            if (inputs[yIdx]) {
                                rowsData[y][key] = inputs[yIdx].value.trim();
                            }
                        });
                    });
                } else if (currentTableCode === '4.2.17') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 8) {
                            const keys = ['imp', 'pil', 'iud', 'kondom', 'suntik', 'mow', 'mop', 'jumlah'];
                            let rowPrefix = '';
                            if (text.includes('guguk')) rowPrefix = 'guguk_panjang';
                            else if (text.includes('mandiangin')) rowPrefix = 'mandiangin_koto_selayan';
                            else if (text.includes('aur birugo')) rowPrefix = 'aur_birugo_tigo_baleh';
                            else {
                                const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                                if (m) {
                                    const y = parseInt(m[1], 10);
                                    if (!rowsData[y]) rowsData[y] = {};
                                    keys.forEach((k, kIdx) => {
                                        rowsData[y][`total_${k}`] = inputs[kIdx].value.trim();
                                    });
                                }
                            }
                            if (rowPrefix) {
                                keys.forEach((k, kIdx) => {
                                    rowsData[currentYear][`${rowPrefix}_${k}`] = inputs[kIdx].value.trim();
                                });
                            }
                        }
                    });
                } else if (currentTableCode === '4.2.18') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 8) {
                            const keys = ['ppkbd', 'sub_ppkbd', 'uppks', 'plkb', 'cu', 'bkb', 'bkr', 'bkl'];
                            let rowPrefix = '';
                            if (text.includes('guguk')) rowPrefix = 'guguk_panjang';
                            else if (text.includes('mandiangin')) rowPrefix = 'mandiangin_koto_selayan';
                            else if (text.includes('aur birugo')) rowPrefix = 'aur_birugo_tigo_baleh';
                            else {
                                const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                                if (m) {
                                    const y = parseInt(m[1], 10);
                                    if (!rowsData[y]) rowsData[y] = {};
                                    keys.forEach((k, kIdx) => {
                                        rowsData[y][`total_${k}`] = inputs[kIdx].value.trim();
                                    });
                                }
                            }
                            if (rowPrefix) {
                                keys.forEach((k, kIdx) => {
                                    rowsData[currentYear][`${rowPrefix}_${k}`] = inputs[kIdx].value.trim();
                                });
                            }
                        }
                    });
                } else if (currentTableCode === '4.2.19') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 4) {
                            const keys = ['klinik', 'dokter', 'bidan', 'total'];
                            let rowPrefix = '';
                            if (text.includes('guguk')) rowPrefix = 'guguk_panjang';
                            else if (text.includes('mandiangin')) rowPrefix = 'mandiangin_koto_selayan';
                            else if (text.includes('aur birugo')) rowPrefix = 'aur_birugo_tigo_baleh';
                            else {
                                const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                                if (m) {
                                    const y = parseInt(m[1], 10);
                                    if (!rowsData[y]) rowsData[y] = {};
                                    keys.forEach((k, kIdx) => {
                                        rowsData[y][`total_${k}`] = inputs[kIdx].value.trim();
                                    });
                                }
                            }
                            if (rowPrefix) {
                                keys.forEach((k, kIdx) => {
                                    rowsData[currentYear][`${rowPrefix}_${k}`] = inputs[kIdx].value.trim();
                                });
                            }
                        }
                    });
                } else if (currentTableCode === '4.3.5' || currentTableCode === '4.3.6' || currentTableCode === '4.3.7' || currentTableCode === '4.3.8') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 1) {
                            rowsData[currentYear][trIdx] = {
                                jumlah: inputs[0].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '4.3.13') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 4) {
                            rowsData[currentYear][trIdx] = {
                                psm: inputs[0].value.trim(),
                                karang_taruna: inputs[1].value.trim(),
                                tks: inputs[2].value.trim(),
                                org_sosial: inputs[3].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '4.3.14') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 3) {
                            rowsData[currentYear][trIdx] = {
                                disabilitas: inputs[0].value.trim(),
                                anak_terlantar: inputs[1].value.trim(),
                                lanjut_usia: inputs[2].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '5.1.15' || currentTableCode === '5.1.16' || currentTableCode === '5.1.17' || currentTableCode === '5.1.18' || currentTableCode === '5.1.19') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach((tr, trIdx) => {
                            const tds = tr.querySelectorAll('td');
                            if (tds.length >= 2) {
                                rowsData[currentYear][trIdx] = Array.from(tds).map(td => {
                                    const inp = td.querySelector('.table-edit-input');
                                    return inp ? inp.value.trim() : td.innerText.trim();
                                });
                            }
                        });
                    }
                } else if (currentTableCode === '4.3.15') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m && inputs.length >= 5) {
                            const y = parseInt(m[1], 10);
                            if (!rowsData[y]) rowsData[y] = {};
                            rowsData[y]['orang_terlantar'] = inputs[0].value.trim();
                            rowsData[y]['bekas_napi'] = inputs[1].value.trim();
                            rowsData[y]['disabilitas'] = inputs[2].value.trim();
                            rowsData[y]['panti_asuhan'] = inputs[3].value.trim();
                            rowsData[y]['jumlah'] = inputs[4].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.20') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m && inputs.length >= 3) {
                            const y = parseInt(m[1], 10);
                            if (!rowsData[y]) rowsData[y] = {};
                            rowsData[y]['target'] = inputs[0].value.trim();
                            rowsData[y]['realisasi'] = inputs[1].value.trim();
                            rowsData[y]['persentase'] = inputs[2].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.14') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 2) {
                            rowsData[currentYear][trIdx] = {
                                timbunan: inputs[0].value.trim(),
                                persentase: inputs[1].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '4.2.9') {
                    rowsData = {};
                    const p = get5YearPeriod(currentYear);
                    p.yearsAsc.forEach(y => { rowsData[y] = {}; });
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        p.yearsAsc.forEach((y, yIdx) => {
                            if (inputs[yIdx]) {
                                rowsData[y][`prof_${trIdx}`] = inputs[yIdx].value.trim();
                            }
                        });
                    });
                } else if (currentTableCode === '4.2.6') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 2) {
                            rowsData[currentYear][`name_${trIdx}`] = inputs[0].value.trim();
                            rowsData[currentYear][`val_${trIdx}`] = inputs[1].value.trim();
                        } else if (inputs.length === 1) {
                            rowsData[currentYear][`val_${trIdx}`] = inputs[0].value.trim();
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
                        } else if (currentTableCode === '9.1') {
                            rowKey = trIdx === 0 ? 'guguk_panjang' : (trIdx === 1 ? 'mandiangin_koto_selayan' : (trIdx === 2 ? 'aur_birugo_tigo_baleh' : 'total'));
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

                    const targetSourceType = (typeof currentType !== 'undefined' && currentType === 'bps') 
                        ? 'custom_bps' 
                        : ((typeof currentType !== 'undefined' && currentType === 'instansi') ? 'custom_instansi' : 'manual');

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
                            source_type: targetSourceType,
                            type: typeof currentType !== 'undefined' ? currentType : 'opd',
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
            window._hasUnsavedEdits = false;
            await persistTableData(true);
        }

        function backToTableView() {
            if (window._hasUnsavedEdits) {
                if (!confirm('Perubahan yang Anda ketik belum disimpan. Apakah Anda yakin ingin membatalkan dan keluar? Semua perubahan yang belum disimpan akan dibatalkan.')) {
                    return;
                }
            }
            let url = `{{ route('tabel-opd') }}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`;
            if (currentType) url += `&type=${currentType}`;
            window.location.href = url;
        }

        function downloadEditExcelTemplate() {
            const url = `/tabel-opd/export-excel?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&type=${encodeURIComponent(currentType)}&template=1`;
            window.location.href = url;
            if (typeof showToast === 'function') {
                showToast(`📥 Mengunduh template Excel Tabel ${currentTableCode} Tahun ${currentYear}...`);
            }
            return;
        }

        async function handleEditExcelImport(event) {
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
                                Belum ada catatan untuk rincian ini. Pencacah dan pengawas dapat saling memberikan komentar di bawah.
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
                    showToast('💬 Catatan berhasil dikirim!');
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
                    showToast('🗑️ Catatan berhasil dihapus.');
                }
            } catch (err) {
                console.error('Error deleting comment:', err);
                alert('Gagal menghapus catatan.');
            }
        }
        async function submitTableVerification() {
            if (!confirm('Apakah Anda yakin ingin mengajukan data tabel ini ke Wali Data (Diskominfo) untuk diverifikasi?')) return;
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                const res = await fetch('{{ route("tabel-opd.api.submit-verification") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: 'opd'
                    })
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Gagal mengajukan verifikasi: ' + (data.message || ''));
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan.');
            }
        }

        async function approveTableVerification() {
            if (!confirm('Apakah Anda yakin ingin memverifikasi data tabel ini sebagai Wali Data (Diskominfo)?')) return;

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                const res = await fetch('{{ route("tabel-opd.api.approve-verification") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: 'opd'
                    })
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Gagal: ' + (data.message || ''));
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan.');
            }
        }

        async function rejectTableVerification() {
            const notes = prompt('Masukkan catatan perbaikan / revisi untuk dinas pengisi data:');
            if (notes === null || notes.trim() === '') return;

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                const res = await fetch('{{ route("tabel-opd.api.reject-verification") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: 'opd',
                        notes: notes
                    })
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Gagal mengirim revisi: ' + (data.message || ''));
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan.');
            }
        }
    </script>
</body>
</html>
