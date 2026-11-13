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
    <script src="{{ asset('js/tabel/helpers.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/schemas-edit.js') }}?v={{ time() }}"></script>

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


    <!-- 1. GLOBAL SIANGKA CONFIGURATION & STATE (HARUS PERTAMA SEBELUM MODUL JS LAINNYA) -->
    <script>
        window.SiAngkaConfig = {
            csrfToken: '{{ csrf_token() }}',
            currentOpdCode: '{{ $currentOpdCode ?? "01" }}',
            currentTableCode: '{{ $currentTableCode ?? "1.1.6" }}',
            currentYear: '{{ $currentYear ?? date("Y") }}',
            currentType: '{{ $currentType ?? "opd" }}',
            serverDbDataStore: @json($dbDataStore ?? []),
            serverDbMetadata: @json($dbMetadata ?? null),
            serverDbFallbackMetadata: @json($dbFallbackMetadata ?? null),
            serverDbCustomTables: @json($dbCustomTables ?? []),
            currentUserData: @json(session('user') ?? ['name' => 'Pengguna', 'role' => 'opd', 'displayName' => 'Pengguna']),
            routes: {
                dataBps: '{{ route("data-bps") }}',
                isiDataInstansi: '{{ route("isi-data-instansi") }}',
                isiDataOpd: '{{ route("isi-data-opd") }}',
                apiData: '{{ route("tabel-opd.api.data") }}',
                apiDelete: '{{ route("tabel-opd.api.delete") }}',
                apiSave: '{{ route("tabel-opd.api.save") }}',
                tabelOpd: '{{ route("tabel-opd") }}',
                apiComments: '{{ route("tabel-opd.api.comments") }}',
                apiSaveComment: '{{ route("tabel-opd.api.save-comment") }}',
                apiSubmitVerification: '{{ route("tabel-opd.api.submit-verification") }}',
                apiApproveVerification: '{{ route("tabel-opd.api.approve-verification") }}',
                apiRejectVerification: '{{ route("tabel-opd.api.reject-verification") }}'
            }
        };

        // Sinkronisasi variabel ke global window agar kompatibel 100%
        window.currentOpdCode = window.SiAngkaConfig.currentOpdCode;
        window.currentTableCode = window.SiAngkaConfig.currentTableCode;
        window.currentYear = window.SiAngkaConfig.currentYear;
        window.currentType = window.SiAngkaConfig.currentType;
        window.csrfToken = window.SiAngkaConfig.csrfToken;
        window.serverDbDataStore = window.SiAngkaConfig.serverDbDataStore;
        window.serverDbMetadata = window.SiAngkaConfig.serverDbMetadata;
        window.serverDbFallbackMetadata = window.SiAngkaConfig.serverDbFallbackMetadata;
        window.serverDbCustomTables = window.SiAngkaConfig.serverDbCustomTables;
        window.currentUserData = window.SiAngkaConfig.currentUserData;
        window.tableSchemas = window.tableSchemas || {};
        window.isEditMode = true;
    </script>

    <!-- 2. MODULAR JAVASCRIPT SUITE -->
    <script src="{{ asset('js/tabel/templates.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/navigation.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/comments.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/export-suite.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/table-editor.js') }}?v={{ time() }}"></script>
</body>
</html>