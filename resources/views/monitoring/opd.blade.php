<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Monitoring Progress Pengumpulan Data OPD - SiAngka Kota Bukittinggi</title>
    
    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..900;1,14..32,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Master Catalog Tables (OPD & Instansi) -->
    <script src="{{ asset('simonda-catalogs.js') }}"></script>

    <!-- SheetJS with Styles (xlsx-js-style) -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>

    <style>
        body {
            font-family: 'Inter',-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f3f8;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        ::-webkit-scrollbar { width: 7px; height: 7px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-card { box-shadow: none !important; border: 1px solid #cbd5e1 !important; break-inside: avoid; }
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased flex flex-col justify-between selection:bg-orange-500 selection:text-white bg-[#f0f3f8] relative overflow-x-hidden">

    <!-- Background SiAngka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-20 select-none">
        <img src="{{ asset('images/siangka-watermark-jamgadang.jpg') }}" alt="Watermark SiAngka Jam Gadang" class="w-[950px] sm:w-[1250px] lg:w-[1550px] max-w-none transform -translate-x-12 sm:-translate-x-20 -translate-y-4 object-contain mix-blend-multiply">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-between min-h-screen">
        
        <!-- HEADER / NAVBAR -->
        <div class="no-print">
            @include('partials.navbar')
        </div>

        @php
            $selectedYear = (int) request('year', 2025);
            $endYear = max(2036, ((int) date('Y')) + 10);
            $availableYears = range($endYear, 2018);

            $opdCatalogCounts = [
                '01' => 6, '02' => 4, '03' => 1, '04' => 5, '05' => 5,
                '06' => 4, '07' => 5, '08' => 6, '09' => 1, '10' => 1,
                '11' => 1, '12' => 8, '13' => 5, '14' => 4, '15' => 4,
                '16' => 3, '17' => 21, '18' => 5, '19' => 4, '20' => 4
            ];

            $opdIcons = [
                '01' => 'fa-city', '02' => 'fa-file-lines', '03' => 'fa-landmark', '04' => 'fa-users',
                '05' => 'fa-wallet', '06' => 'fa-address-card', '07' => 'fa-shop', '08' => 'fa-book-open',
                '09' => 'fa-shield-halved', '10' => 'fa-person-running', '11' => 'fa-book-bookmark',
                '12' => 'fa-circle-plus', '13' => 'fa-leaf', '14' => 'fa-people-group', '15' => 'fa-fire',
                '16' => 'fa-hand-holding-heart', '17' => 'fa-seedling', '18' => 'fa-store',
                '19' => 'fa-location-dot', '20' => 'fa-bus'
            ];

            $opdList = config('simonda.opd_list', []);

            // Ambil tahapan kustom yang diatur admin jika ada
            $manualStages = \App\Models\MonitoringStage::where('agency_type', 'opd')
                ->where('year', $selectedYear)
                ->pluck('stage', 'agency_code')
                ->toArray();

            // Ambil semua metadata snapshot tabel untuk tahun terpilih
            $allTablesRaw = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->select('table_code', 'opd_code', 'year', 'title_id', 'title_en', 'source', 'note', 'is_saved', 'verification_status', 'table_html', 'updated_at')
                ->get();

            // Hitung data angka non-strip dari tabel_opd_data untuk tahun terpilih
            $tabelDataCounts = \App\Models\TabelData::where('year', $selectedYear)
                ->whereNotNull('value')
                ->where('value', '!=', '-')
                ->where('value', '!=', '–')
                ->where('value', '!=', '')
                ->select('table_code', 'opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('table_code', 'opd_code')
                ->get()
                ->keyBy(function($r) {
                    return str_pad($r->opd_code, 2, '0', STR_PAD_LEFT) . '_' . $r->table_code;
                });

            // Hitung status verifikasi riil (Menunggu ACC, Di-ACC, Revisi) per OPD
            $submittedCounts = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'submitted')
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            $verifiedCounts = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'verified')
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            $revisionCounts = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'revision')
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            // Evaluasi status angka data per tabel untuk Card Monitoring Tabel & Rekap OPD
            $allTablesStatus = [];
            $opdNumericStats = []; // ['01' => ['lengkap' => X, 'proses' => Y, 'belum' => Z]]

            foreach ($allTablesRaw as $item) {
                $cOpd = str_pad($item->opd_code, 2, '0', STR_PAD_LEFT);
                $dbKey = $cOpd . '_' . $item->table_code;
                $tdCount = isset($tabelDataCounts[$dbKey]) ? (int) $tabelDataCounts[$dbKey]->count : 0;
                
                // Evaluasi status keterisian angka riil (bukan sekadar template / nama isian)
                $eval = $item->getNumericStatus($tdCount);

                $allTablesStatus[$dbKey] = [
                    'table_code' => $item->table_code,
                    'opd_code' => $cOpd,
                    'year' => $item->year,
                    'title_id' => $item->title_id,
                    'title_en' => $item->title_en,
                    'source' => $item->source,
                    'note' => $item->note,
                    'is_saved' => $item->is_saved,
                    'verification_status' => $item->verification_status,
                    'updated_at' => $item->updated_at ? $item->updated_at->toIso8601String() : null,
                    'status' => $eval['status'], // 'lengkap' | 'proses' | 'belum'
                    'status_label' => $eval['status_label'],
                    'numeric_cells' => $eval['numeric_cells'],
                    'empty_cells' => $eval['empty_cells'],
                    'total_cells' => $eval['total_cells'],
                    'numeric_pct' => $eval['pct'],
                ];

                if (!isset($opdNumericStats[$cOpd])) {
                    $opdNumericStats[$cOpd] = ['lengkap' => 0, 'proses' => 0, 'belum' => 0];
                }
                $opdNumericStats[$cOpd][$eval['status']]++;
            }

            $allOpds = [];
            $countSelesai = 0;
            $countBerjalan = 0;
            $countBelum = 0;

            foreach ($opdList as $code => $info) {
                $totalCat = $opdCatalogCounts[$code] ?? 4;
                $stat = $opdNumericStats[$code] ?? ['lengkap' => 0, 'proses' => 0, 'belum' => 0];
                $countLengkap = $stat['lengkap'];
                $countProses = $stat['proses'];
                $countBelumTabel = max(0, $totalCat - $countLengkap - $countProses);

                // Hitung progres riil berdasarkan keterisian angka data
                $saved = $countLengkap;
                if ($totalCat > 0) {
                    $score = $countLengkap + ($countProses * 0.5);
                    $pct = min(100, (int) round(($score / $totalCat) * 100));
                } else {
                    $pct = 0;
                }

                // Keterangan tabel berdasarkan angka data riil
                if ($countLengkap === $totalCat && $totalCat > 0) {
                    $tablesDesc = "{$totalCat} Tabel Data (Semua Terisi Lengkap)";
                } elseif ($countLengkap > 0 || $countProses > 0) {
                    $tablesDesc = "{$totalCat} Tabel Data ({$countLengkap} Lengkap, {$countProses} Belum Lengkap)";
                } else {
                    $tablesDesc = "{$totalCat} Tabel Data (Belum Diisi Data Angka)";
                }

                // Tahapan default sesuai data riil angka dan status verifikasi (3 Tahap Sektoral)
                $vCount = $verifiedCounts[$code] ?? ($verifiedCounts[ltrim($code, '0')] ?? 0);
                $sCount = $submittedCounts[$code] ?? ($submittedCounts[ltrim($code, '0')] ?? 0);

                if ($vCount >= $totalCat && $totalCat > 0) {
                    $step = 3;
                    $stepLabel = 'Validasi BPS';
                    $statusText = 'Validasi BPS';
                    $statusType = 'selesai';
                } elseif ($sCount > 0 || $vCount > 0) {
                    $step = 2;
                    $stepLabel = 'Verifikasi';
                    $statusText = 'Verifikasi Wali Data';
                    $statusType = 'berjalan';
                } elseif ($pct > 0) {
                    $step = 1;
                    $stepLabel = 'Input Data';
                    $statusText = 'Pengisian';
                    $statusType = 'berjalan';
                } else {
                    $step = 1;
                    $stepLabel = 'Input Data';
                    $statusText = 'Belum Mulai';
                    $statusType = 'belum';
                }

                // Terapkan penyesuaian manual dari admin jika ada
                if (isset($manualStages[$code])) {
                    $step = (int) $manualStages[$code];
                    $stageInfo = \App\Models\MonitoringStage::getStageInfo($step);
                    $stepLabel = $stageInfo['label'];
                    $statusText = $stageInfo['badge'];
                    $statusType = $stageInfo['type'];
                }

                if ($step === 3) {
                    $countSelesai++;
                } elseif ($step === 2 || ($step === 1 && $pct > 0)) {
                    $countBerjalan++;
                } else {
                    $countBelum++;
                }

                $allOpds[] = [
                    'code' => $code,
                    'short' => "{$code}. " . ($info['short_name'] ?? $info['name']),
                    'full' => $info['name'],
                    'icon' => $opdIcons[$code] ?? 'fa-building',
                    'progress' => $pct,
                    'status' => $statusText,
                    'step' => $step,
                    'step_label' => $stepLabel,
                    'status_type' => $statusType,
                    'tables' => $tablesDesc,
                    'saved' => $saved,
                    'total' => $totalCat,
                    'count_lengkap' => $countLengkap,
                    'count_proses' => $countProses,
                    'count_belum' => $countBelumTabel,
                    'submitted' => $submittedCounts[$code] ?? ($submittedCounts[ltrim($code, '0')] ?? 0),
                    'verified' => $verifiedCounts[$code] ?? ($verifiedCounts[ltrim($code, '0')] ?? 0),
                    'revision' => $revisionCounts[$code] ?? ($revisionCounts[ltrim($code, '0')] ?? 0),
                ];
            }

            $countTotal = count($allOpds);

            // Donut chart calculations
            $circ = 238.76;
            $dashSelesai = $countTotal > 0 ? round(($countSelesai / $countTotal) * $circ, 2) : 0;
            $dashBerjalan = $countTotal > 0 ? round(($countBerjalan / $countTotal) * $circ, 2) : 0;
            $dashBelum = $countTotal > 0 ? round(($countBelum / $countTotal) * $circ, 2) : 0;
            $offsetBerjalan = -$dashSelesai;
            $offsetBelum = -($dashSelesai + $dashBerjalan);
        @endphp

        <!-- MAIN MONITORING PROGRESS CONTAINER -->
        <main class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-6 flex-1 w-full">
            
            <!-- HEADER, YEAR SELECTOR, EXPORT DROPDOWN & TAB SWITCHER -->
            @include('monitoring.partials.header', [
                'activeTab' => 'opd',
                'selectedYear' => $selectedYear,
                'availableYears' => $availableYears
            ])

            <!-- TWO-COLUMN LAYOUT -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-5 items-start">
                
                <!-- LEFT COLUMN: OPD PROGRESS CARDS (XL: 9 Columns) -->
                <div class="xl:col-span-9 space-y-3">

                    <!-- FILTER & SEARCH BAR -->
                    <div class="no-print flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white rounded-2xl p-3 border border-slate-100 shadow-2xs mb-3">
                        <div class="relative flex-1">
                            <input type="text" 
                                   id="opdSearchInput"
                                   oninput="filterAgencyCards()"
                                   placeholder="Cari OPD / dinas..."
                                   class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500 font-medium text-slate-800 transition-all">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        </div>
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 shrink-0">
                            <button type="button" onclick="setAgencyStatusFilter('all')" id="filterBtnAll"
                                    class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-[#f95a00] text-white shadow-2xs cursor-pointer">
                                Semua ({{ $countTotal }})
                            </button>
                            <button type="button" onclick="setAgencyStatusFilter('selesai')" id="filterBtnSelesai"
                                    class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                                Selesai ({{ $countSelesai }})
                            </button>
                            <button type="button" onclick="setAgencyStatusFilter('berjalan')" id="filterBtnBerjalan"
                                    class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                                Berjalan ({{ $countBerjalan }})
                            </button>
                            <button type="button" onclick="setAgencyStatusFilter('belum')" id="filterBtnBelum"
                                    class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold transition-all bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                                Belum Mulai ({{ $countBelum }})
                            </button>
                        </div>
                    </div>
                    
                    <!-- DAFTAR KARTU OPD (KOMPONEN TERPISAH) -->
                    @foreach($allOpds as $opdItem)
                        @include('monitoring.partials.item-card', [
                            'item' => $opdItem,
                            'agencyType' => 'opd'
                        ])
                    @endforeach

                </div>

                <!-- RIGHT COLUMN: RINGKASAN PROGRES CARD (KOMPONEN TERPISAH) -->
                <div class="xl:col-span-3">
                    @include('monitoring.partials.ringkasan-card')
                </div>

            </div>

        </main>

        <!-- FOOTER BAR (KOMPONEN TERPISAH) -->
        @include('monitoring.partials.footer')

    </div>

    <!-- DETAIL MODAL & TOAST NOTIFICATION (KOMPONEN TERPISAH) -->
    @include('monitoring.partials.modal-detail')
    @include('monitoring.partials.toast')

    <!-- MODULAR MONITORING JAVASCRIPT -->
    <script>
        window.monitoringSelectedYear = {{ $selectedYear }};
        window.allTablesStatusDb = @json($allTablesStatus);
        const allOpdsData = @json($allOpds);

        function exportMonitoringExcel() {
            exportMonitoringToExcel({
                title: 'MONITORING PENGUMPULAN DATA SEKTORAL OPD KOTA BUKITTINGGI - TAHUN {{ $selectedYear }}',
                fileName: 'Monitoring_Data_OPD_Bukittinggi_Tahun_{{ $selectedYear }}',
                dataset: allOpdsData,
                year: {{ $selectedYear }}
            });
        }
    </script>
    <script src="{{ asset('js/monitoring.js') }}"></script>
</body>
</html>
