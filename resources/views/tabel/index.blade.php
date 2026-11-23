<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    @include('partials.base-url')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data Statistik Sektoral - SiBingka Kota Bukittinggi</title>
    
    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/sibingka-icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sibingka-icon.png') }}">
    
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
    <script src="{{ asset('sibingka-catalogs.js') }}?v={{ @filemtime(public_path('sibingka-catalogs.js')) }}"></script>
    <!-- Table Helpers & Schemas -->
    <script src="{{ asset('js/tabel/helpers.js') }}?v={{ @filemtime(public_path('js/tabel/helpers.js')) }}"></script>
    @include('partials.script-group', ['dir' => 'js/tabel/schemas-display'])

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/tabel-index.css') }}?v={{ @filemtime(public_path('css/tabel-index.css')) }}">
</head>
<body class="min-h-screen flex flex-col justify-between text-slate-800 antialiased selection:bg-orange-500 selection:text-white relative bg-[#f4f6f8]">

    <!-- Decorative Top Background Glow -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-64 bg-gradient-to-b from-orange-100/40 via-orange-50/20 to-transparent pointer-events-none -z-10"></div>

    <!-- Background SiBingka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden flex items-center justify-center opacity-15 select-none">
        <img src="{{ asset('images/sibingka-watermark-jamgadang.jpg') }}" alt="Watermark SiBingka Jam Gadang" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-16 sm:-translate-x-28 -translate-y-6 object-contain mix-blend-multiply">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="w-full flex-1 flex flex-col">
        
    @include('tabel.partials.header-bar')

        <!-- MAIN TABLE DETAIL CONTAINER -->
        <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-10 py-2 sm:py-5 flex-1 w-full">
            
            <!-- TABLE CARD -->
            <div class="bg-white rounded-2xl p-3 sm:p-7 md:p-8 shadow-sm border border-slate-200/90 relative transition-all">
                
                <!-- OFFICIAL BPS LANDSCAPE PRINT HEADER (EXCEL-STYLE PRINTOUT) -->
                <div class="print-only mb-4 pb-3 border-b-2 border-slate-900">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-10 w-auto object-contain">
                            <img src="{{ asset('images/sibingka-logo.png') }}" alt="Logo SiBingka" class="h-10 w-auto object-contain">
                            <div>
                                <h1 class="text-xs font-black tracking-wider text-slate-900 uppercase leading-tight">
                                    BADAN PUSAT STATISTIK KOTA BUKITTINGGI
                                </h1>
                                <p class="text-[10px] font-bold text-[#f95a00] uppercase tracking-wide leading-tight">
                                    Sistem Informasi Bukittinggi dalam Angka (SiBingka)
                                </p>
                                <p class="text-[9.5px] text-slate-600 font-medium" id="printOpdSubheading">
                                    {{ ($currentType ?? 'opd') === 'instansi' ? 'Instansi' : 'OPD' }} Penyelenggara Data: {{ $currentOpdCode }}. {{ $opdName }}
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

                <!-- Mobile Horizontal Scroll Hint (Hanya muncul jika tabel meluap & hilang saat digeser) -->
                <div id="mobileScrollHint" class="hidden sm:hidden flex items-center justify-between text-[11px] text-slate-500 bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-1.5 mb-3 select-none transition-all duration-300">
                    <span class="flex items-center gap-1.5 font-medium min-w-0 truncate">
                        <i class="fa-solid fa-arrows-left-right text-[#f95a00] text-xs shrink-0"></i>
                        <span class="truncate">Geser tabel ke samping untuk melihat data lengkap</span>
                    </span>
                    <div class="flex items-center space-x-2 shrink-0 ml-2">
                        <i class="fa-solid fa-hand-pointer text-slate-400 text-xs animate-pulse"></i>
                        <button type="button" onclick="dismissMobileScrollHint()" class="text-slate-400 hover:text-slate-600 p-0.5 cursor-pointer" title="Tutup">
                            <i class="fa-solid fa-xmark text-[10px]"></i>
                        </button>
                    </div>
                </div>

                <!-- TABLE DISPLAY CONTAINER (SCROLLABLE ON MOBILE) -->
                <div class="overflow-x-auto mb-5" id="printableTableSection">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse table-custom-border" id="dataDisplayTable">
                        @if(!empty($dbMetadata?->table_html) && str_contains($dbMetadata->table_html, '<tr'))
                            {!! preg_replace('/<\/?table[^>]*>/i', '', $dbMetadata->table_html) !!}
                        @elseif(!empty($dbFallbackMetadata?->table_html) && str_contains($dbFallbackMetadata->table_html, '<tr') && empty($isMultiYearTable))
                            {!! preg_replace('/<\/?table[^>]*>/i', '', $dbFallbackMetadata->table_html) !!}
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

    <!-- 1. GLOBAL SIBINGKA CONFIGURATION & STATE (HARUS PERTAMA SEBELUM MODUL JS LAINNYA) -->
    <script>
        window.SiBingkaConfig = {
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
                tabelOpd: '{{ route("tabel-opd") }}',
                apiData: '{{ route("tabel-opd.api.data") }}',
                editTabel: '{{ route("edit-tabel-opd") }}',
                apiDelete: '{{ route("tabel-opd.api.delete") }}',
                apiComments: '{{ route("tabel-opd.api.comments") }}',
                apiSaveComment: '{{ route("tabel-opd.api.save-comment") }}'
            }
        };

        // Sinkronisasi variabel ke global window agar kompatibel 100%
        window.currentOpdCode = window.SiBingkaConfig.currentOpdCode;
        window.currentTableCode = window.SiBingkaConfig.currentTableCode;
        window.currentYear = window.SiBingkaConfig.currentYear;
        window.currentType = window.SiBingkaConfig.currentType;
        window.csrfToken = window.SiBingkaConfig.csrfToken;
        window.serverDbDataStore = window.SiBingkaConfig.serverDbDataStore;
        window.serverDbMetadata = window.SiBingkaConfig.serverDbMetadata;
        window.serverDbFallbackMetadata = window.SiBingkaConfig.serverDbFallbackMetadata;
        window.serverDbCustomTables = window.SiBingkaConfig.serverDbCustomTables;
        window.currentUserData = window.SiBingkaConfig.currentUserData;
        window.tableSchemas = window.tableSchemas || {};
        window.isEditMode = false;
    </script>

    <!-- 2. MODULAR JAVASCRIPT SUITE -->
    <script src="{{ asset('js/tabel/templates.js') }}?v={{ @filemtime(public_path('js/tabel/templates.js')) }}"></script>
    <script src="{{ asset('js/tabel/navigation.js') }}?v={{ @filemtime(public_path('js/tabel/navigation.js')) }}"></script>
    <script src="{{ asset('js/tabel/comments.js') }}?v={{ @filemtime(public_path('js/tabel/comments.js')) }}"></script>
    <script src="{{ asset('js/tabel/export-suite.js') }}?v={{ @filemtime(public_path('js/tabel/export-suite.js')) }}"></script>
    @include('partials.script-group', ['dir' => 'js/tabel/table-index'])
</body>
</html>