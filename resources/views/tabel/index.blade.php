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
    <script src="{{ asset('js/tabel/helpers.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/schemas-display.js') }}?v={{ time() }}"></script>

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

                @include('tabel.partials.toolbar')

                @include('tabel.partials.metadata-section')

                @include('tabel.partials.excel-modal')

                <!-- TABLE DISPLAY CONTAINER (SCROLLABLE ON MOBILE) -->
                <div class="overflow-x-auto mb-5" id="printableTableSection">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse table-custom-border" id="dataDisplayTable">
                        @if(!empty($dbMetadata?->table_html) && str_contains($dbMetadata->table_html, '<tr'))
                            {!! $dbMetadata->table_html !!}
                        @elseif(!empty($dbFallbackMetadata?->table_html) && str_contains($dbFallbackMetadata->table_html, '<tr'))
                            {!! $dbFallbackMetadata->table_html !!}
                        @endif
                    </table>
                </div>



                @include('tabel.partials.bottom-bar')
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
            currentUserData: @json(session('user') ?? ['name' => 'Pengguna', 'role' => 'opd', 'displayName' => 'Pengguna']),
            routes: {
                dataBps: '{{ route("data-bps") }}',
                isiDataInstansi: '{{ route("isi-data-instansi") }}',
                isiDataOpd: '{{ route("isi-data-opd") }}',
                apiData: '{{ route("tabel-opd.api.data") }}',
                editTabel: '{{ route("edit-tabel-opd") }}',
                apiDelete: '{{ route("tabel-opd.api.delete") }}',
                apiComments: '{{ route("tabel-opd.api.comments") }}',
                apiSaveComment: '{{ route("tabel-opd.api.save-comment") }}'
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
        window.currentUserData = window.SiAngkaConfig.currentUserData;
        window.tableSchemas = window.tableSchemas || {};
        window.isEditMode = false;
    </script>

    <!-- 2. MODULAR JAVASCRIPT SUITE -->
    <script src="{{ asset('js/tabel/templates.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/navigation.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/comments.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/export-suite.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/tabel/table-index.js') }}?v={{ time() }}"></script>
</body>
</html>