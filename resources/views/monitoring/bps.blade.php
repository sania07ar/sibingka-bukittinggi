<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Monitoring Progress Pengumpulan Data BPS - SiAngka Kota Bukittinggi</title>
    
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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
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
            $bpsDatasets = [
                ['code' => '01', 'short' => '01. PODES', 'full' => 'Potensi Desa / Kelurahan', 'icon' => 'fa-house-chimney-window', 'link' => 'https://drive.google.com/drive/folders/1uLHQDuVkwwkqmPiDzCbpkmGGmZ8YBDep'],
                ['code' => '02', 'short' => '02. PENDUDUK', 'full' => 'Statistik Kependudukan & Proyeksi', 'icon' => 'fa-users', 'link' => 'https://drive.google.com/drive/folders/1DZR2cpVOCLSqDVwzM3iFKDBVctyM5HxS'],
                ['code' => '03', 'short' => '03. SUSENAS', 'full' => 'Survei Sosial Ekonomi Nasional', 'icon' => 'fa-chart-pie', 'link' => 'https://drive.google.com/drive/folders/1g9n_3D9_Nf-Psp11N1X0R49i-Y3p2c30'],
                ['code' => '04', 'short' => '04. SAKERNAS', 'full' => 'Survei Angkatan Kerja Nasional', 'icon' => 'fa-briefcase', 'link' => 'https://drive.google.com/drive/folders/1bEa-s8L0gQ2F9f323j2qLzGkP7B2D2_g'],
                ['code' => '05', 'short' => '05. HORTI', 'full' => 'Statistik Pertanian & Hortikultura', 'icon' => 'fa-seedling', 'link' => 'https://drive.google.com/drive/folders/18K_4E1Q993L_bQ9e-gK0P9P_F-4M1P32'],
                ['code' => '06', 'short' => '06. IMK', 'full' => 'Survei Industri Mikro & Kecil', 'icon' => 'fa-industry', 'link' => 'https://drive.google.com/drive/folders/1M2P_F9a0D2-Q3c89E1f_F-1p2K9M4e56'],
                ['code' => '07', 'short' => '07. HOTEL', 'full' => 'Statistik Perhotelan & Wisata', 'icon' => 'fa-hotel', 'link' => 'https://drive.google.com/drive/folders/1F3K_9P1e0A2_Q3c78D1f_M-9p2K9M4e77'],
                ['code' => '08', 'short' => '08. IHK & INFLASI', 'full' => 'Indeks Harga Konsumen & Inflasi', 'icon' => 'fa-arrow-trend-up', 'link' => 'https://drive.google.com/drive/folders/1Z9P_9L1e0B2_R4c88E1f_N-8p2K9M4e88'],
                ['code' => '09', 'short' => '09. PDRB LAPUS', 'full' => 'PDRB Menurut Lapangan Usaha', 'icon' => 'fa-chart-simple', 'link' => 'https://drive.google.com/drive/folders/1X8P_8K1e0C2_S5c99F1g_O-7p2K9M4e99'],
                ['code' => '10', 'short' => '10. PDRB PENGELUARAN', 'full' => 'PDRB Menurut Pengeluaran', 'icon' => 'fa-wallet', 'link' => 'https://drive.google.com/drive/folders/1W7P_7J1e0D2_T6c00G1h_P-6p2K9M4e00'],
            ];

            $selectedYear = (int) request('year', (int) date('Y'));
            $endYear = max(2036, ((int) date('Y')) + 10);
            $availableYears = range($endYear, 2018);

            // Ambil penyesuaian tahapan manual BPS jika ada
            $manualStagesBps = \App\Models\MonitoringStage::where('agency_type', 'bps')
                ->where('year', $selectedYear)
                ->pluck('stage', 'agency_code')
                ->toArray();

            // Hitung status verifikasi riil per dataset BPS
            $submittedCountsBps = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'submitted')
                ->where(function($q) {
                    $q->where('source_type', 'like', '%bps%')
                      ->orWhere('opd_code', 'like', 'bps%');
                })
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            $verifiedCountsBps = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'verified')
                ->where(function($q) {
                    $q->where('source_type', 'like', '%bps%')
                      ->orWhere('opd_code', 'like', 'bps%');
                })
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            $revisionCountsBps = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'revision')
                ->where(function($q) {
                    $q->where('source_type', 'like', '%bps%')
                      ->orWhere('opd_code', 'like', 'bps%');
                })
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            // Ambil semua tabel BPS pada tahun terpilih
            $allTablesBpsRaw = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where(function($q) {
                    $q->where('source_type', 'like', '%bps%')
                      ->orWhere('opd_code', 'like', 'bps%');
                })
                ->get();

            // Hitung sel angka valid per tabel BPS
            $tdCountsBps = \App\Models\TabelData::where('year', $selectedYear)
                ->whereNotNull('value')
                ->whereNotIn('value', ['', '-', '–', '—', 'null', '...'])
                ->where(function($q) {
                    $q->where('opd_code', 'like', 'bps%')
                      ->orWhereIn('opd_code', ['01','02','03','04','05','06','07','08','09','10']);
                })
                ->select('table_code', 'opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('table_code', 'opd_code')
                ->get()
                ->keyBy(function($r) {
                    return $r->opd_code . '_' . $r->table_code;
                });

            $allTablesStatus = [];
            $bpsStats = []; // ['01' => ['total' => X, 'lengkap' => Y, 'proses' => Z]]

            foreach ($allTablesBpsRaw as $item) {
                $cCode = (string) $item->opd_code;
                $dbKey = $cCode . '_' . $item->table_code;
                $tdCount = isset($tdCountsBps[$dbKey]) ? (int) $tdCountsBps[$dbKey]->count : 0;
                $eval = $item->getNumericStatus($tdCount);

                $allTablesStatus[$dbKey] = [
                    'table_code' => $item->table_code,
                    'opd_code' => $cCode,
                    'year' => $item->year,
                    'title_id' => $item->title_id,
                    'title_en' => $item->title_en,
                    'source' => $item->source,
                    'note' => $item->note,
                    'is_saved' => $item->is_saved,
                    'verification_status' => $item->verification_status,
                    'updated_at' => $item->updated_at ? $item->updated_at->toIso8601String() : null,
                    'status' => $eval['status'],
                    'status_label' => $eval['status_label'],
                    'numeric_cells' => $eval['numeric_cells'],
                    'empty_cells' => $eval['empty_cells'],
                    'total_cells' => $eval['total_cells'],
                    'numeric_pct' => $eval['pct'],
                ];

                $cleanCode = str_pad(preg_replace('/[^\d]/', '', $cCode), 2, '0', STR_PAD_LEFT);
                if (!isset($bpsStats[$cleanCode])) {
                    $bpsStats[$cleanCode] = ['total' => 0, 'lengkap' => 0, 'proses' => 0];
                }
                $bpsStats[$cleanCode]['total']++;
                if ($eval['status'] === 'lengkap') {
                    $bpsStats[$cleanCode]['lengkap']++;
                } elseif ($eval['status'] === 'proses' || $eval['numeric_cells'] > 0) {
                    $bpsStats[$cleanCode]['proses']++;
                }
            }

            $countSelesai = 0;
            $countBerjalan = 0;
            $countBelum = 0;

            foreach ($bpsDatasets as &$ds) {
                $code = $ds['code'];
                $stat = $bpsStats[$code] ?? ['total' => 0, 'lengkap' => 0, 'proses' => 0];
                
                $totalTables = max(1, $stat['total']);
                $score = $stat['lengkap'] + ($stat['proses'] * 0.5);
                $pct = min(100, (int) round(($score / $totalTables) * 100));

                $ds['progress'] = $pct;
                $ds['submitted'] = $submittedCountsBps[$code] ?? ($submittedCountsBps['bps_' . $code] ?? 0);
                $ds['verified'] = $verifiedCountsBps[$code] ?? ($verifiedCountsBps['bps_' . $code] ?? 0);
                $ds['revision'] = $revisionCountsBps[$code] ?? ($revisionCountsBps['bps_' . $code] ?? 0);

                if ($ds['verified'] > 0 || $pct === 100) {
                    $ds['step'] = 3;
                    $ds['step_label'] = 'Validasi BPS';
                    $ds['status'] = 'Validasi BPS';
                    $ds['status_type'] = 'selesai';
                } elseif ($ds['submitted'] > 0 || $pct >= 80) {
                    $ds['step'] = 2;
                    $ds['step_label'] = 'Verifikasi';
                    $ds['status'] = 'Verifikasi Wali Data';
                    $ds['status_type'] = 'berjalan';
                } elseif ($pct > 0 || $stat['proses'] > 0 || $stat['lengkap'] > 0) {
                    $ds['step'] = 1;
                    $ds['step_label'] = 'Input Data';
                    $ds['status'] = 'Pengisian';
                    $ds['status_type'] = 'berjalan';
                } else {
                    $ds['step'] = 1;
                    $ds['step_label'] = 'Input Data';
                    $ds['status'] = 'Belum Mulai';
                    $ds['status_type'] = 'belum';
                }

                if (isset($manualStagesBps[$code])) {
                    $st = (int) $manualStagesBps[$code];
                    $info = \App\Models\MonitoringStage::getStageInfo($st);
                    $ds['step'] = $st;
                    $ds['step_label'] = $info['label'];
                    $ds['status'] = $info['badge'];
                    $ds['status_type'] = $info['type'];
                }

                if ($ds['step'] === 3) {
                    $countSelesai++;
                } elseif ($ds['step'] === 2 || ($ds['step'] === 1 && $pct > 0)) {
                    $countBerjalan++;
                } else {
                    $countBelum++;
                }
            }
            unset($ds);

            $countTotal = count($bpsDatasets);

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
                'activeTab' => 'bps',
                'selectedYear' => $selectedYear,
                'availableYears' => $availableYears
            ])

            <!-- TWO-COLUMN LAYOUT -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-5 items-start">
                
                <!-- LEFT COLUMN: BPS PROGRESS CARDS (XL: 9 Columns) -->
                <div class="xl:col-span-9 space-y-3">
                    
                    <!-- FILTER & SEARCH BAR -->
                    <div class="no-print flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white rounded-2xl p-3 border border-slate-100 shadow-2xs mb-3">
                        <div class="relative flex-1">
                            <input type="text" 
                                   id="bpsSearchInput"
                                   oninput="filterAgencyCards()"
                                   placeholder="Cari dataset data BPS..."
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

                    <!-- DAFTAR KARTU DATA BPS -->
                    @foreach($bpsDatasets as $item)
                        @include('monitoring.partials.item-card', [
                            'item' => $item,
                            'agencyType' => 'bps'
                        ])
                    @endforeach

                </div>

                <!-- RIGHT COLUMN: RINGKASAN PROGRES CARD -->
                <div class="xl:col-span-3">
                    @include('monitoring.partials.ringkasan-card')
                </div>

            </div>

        </main>

        <!-- FOOTER BAR -->
        @include('monitoring.partials.footer')

    </div>

    <!-- DETAIL MODAL & TOAST NOTIFICATION -->
    @include('monitoring.partials.modal-detail')
    @include('monitoring.partials.toast')

    <!-- MODULAR MONITORING JAVASCRIPT -->
    <script>
        window.monitoringSelectedYear = {{ $selectedYear }};
        window.allTablesStatusDb = @json($allTablesStatus);
        const allBpsData = @json($bpsDatasets);

        function exportMonitoringExcel() {
            exportMonitoringToExcel({
                title: 'MONITORING PENGUMPULAN DATA STATISTIK BPS KOTA BUKITTINGGI - TAHUN {{ $selectedYear }}',
                fileName: 'Monitoring_Data_BPS_Bukittinggi_Tahun_{{ $selectedYear }}',
                dataset: allBpsData,
                year: {{ $selectedYear }}
            });
        }
    </script>
    <script src="{{ asset('js/monitoring.js') }}"></script>
</body>
</html>

