<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Monitoring Progress Pengumpulan Data Instansi - SiAngka Kota Bukittinggi</title>
    
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
            $instansiList = [
                ['code' => '01', 'short' => '01. Kantor Pertanahan (BPN)', 'full' => 'Kantor Pertanahan Kota Bukittinggi (BPN)', 'icon' => 'fa-map-location-dot', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '02', 'short' => '02. KPUD Kota Bukittinggi', 'full' => 'Komisi Pemilihan Umum Daerah Kota Bukittinggi', 'icon' => 'fa-check-to-slot', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '03', 'short' => '03. Kementerian Agama', 'full' => 'Kementerian Agama Kota Bukittinggi', 'icon' => 'fa-mosque', 'progress' => 75, 'status' => 'Terisi', 'step' => 4, 'step_label' => 'Validasi BPS', 'status_type' => 'berjalan'],
                ['code' => '04', 'short' => '04. Cabang Disdik Prov. Sumbar', 'full' => 'Cabang Dinas Pendidikan Wilayah I Prov. Sumbar', 'icon' => 'fa-graduation-cap', 'progress' => 60, 'status' => 'Terisi', 'step' => 3, 'step_label' => 'Sedang Berjalan', 'status_type' => 'berjalan'],
                ['code' => '05', 'short' => '05. Prodi PGSD UNP Bukittinggi', 'full' => 'Program Studi PGSD Universitas Negeri Padang', 'icon' => 'fa-school', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '06', 'short' => '06. Departemen Psikologi UNP', 'full' => 'Departemen Psikologi UNP Kampus Bukittinggi', 'icon' => 'fa-brain', 'progress' => 40, 'status' => 'Proses', 'step' => 2, 'step_label' => 'Pengisian', 'status_type' => 'berjalan'],
                ['code' => '07', 'short' => '07. Fakultas Kedokteran UNP', 'full' => 'Fakultas Kedokteran UNP Kampus Bukittinggi', 'icon' => 'fa-user-doctor', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '08', 'short' => '08. Akbid Bukittinggi (AKBID)', 'full' => 'Akademi Kebidanan Bukittinggi (AKBID)', 'icon' => 'fa-baby', 'progress' => 0, 'status' => 'Belum Terisi', 'step' => 1, 'step_label' => 'Belum Mulai', 'status_type' => 'belum'],
                ['code' => '09', 'short' => '09. Jurusan Keperawatan Gigi Poltekkes', 'full' => 'Jurusan Keperawatan Gigi Poltekkes Bukittinggi', 'icon' => 'fa-tooth', 'progress' => 70, 'status' => 'Terisi', 'step' => 3, 'step_label' => 'Sedang Berjalan', 'status_type' => 'berjalan'],
                ['code' => '10', 'short' => '10. STKIP Al-Hussunah Bukittinggi', 'full' => 'STKIP Al-Hussunah Bukittinggi', 'icon' => 'fa-book-bookmark', 'progress' => 30, 'status' => 'Proses', 'step' => 2, 'step_label' => 'Pengisian', 'status_type' => 'berjalan'],
                ['code' => '11', 'short' => '11. STIT Al-Hussunah Bukittinggi', 'full' => 'STIT Al-Hussunah Bukittinggi', 'icon' => 'fa-book-quran', 'progress' => 0, 'status' => 'Belum Terisi', 'step' => 1, 'step_label' => 'Belum Mulai', 'status_type' => 'belum'],
                ['code' => '12', 'short' => '12. STIKES Perintis Bukittinggi', 'full' => 'STIKES Perintis Bukittinggi', 'icon' => 'fa-heart-pulse', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '13', 'short' => '13. STIKES Prima Nusantara', 'full' => 'STIKES Prima Nusantara Bukittinggi', 'icon' => 'fa-hospital-user', 'progress' => 50, 'status' => 'Proses', 'step' => 3, 'step_label' => 'Sedang Berjalan', 'status_type' => 'berjalan'],
                ['code' => '14', 'short' => '14. Univ. Mohammad Natsir Yarsi', 'full' => 'Universitas Mohammad Natsir Yarsi Bukittinggi', 'icon' => 'fa-building-columns', 'progress' => 80, 'status' => 'Terisi', 'step' => 4, 'step_label' => 'Validasi BPS', 'status_type' => 'berjalan'],
                ['code' => '15', 'short' => '15. ITB Haji Agus Salim', 'full' => 'Institut Teknologi dan Bisnis Haji Agus Salim', 'icon' => 'fa-laptop-code', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '16', 'short' => '16. Fakultas Teknik UM Sumbar', 'full' => 'Fakultas Teknik Universitas Muhammadiyah Sumbar', 'icon' => 'fa-compass-drafting', 'progress' => 60, 'status' => 'Terisi', 'step' => 3, 'step_label' => 'Sedang Berjalan', 'status_type' => 'berjalan'],
                ['code' => '17', 'short' => '17. Fakultas Hukum UM Sumbar', 'full' => 'Fakultas Hukum Universitas Muhammadiyah Sumbar', 'icon' => 'fa-scale-balanced', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '18', 'short' => '18. Fakultas Pariwisata UM Sumbar', 'full' => 'Fakultas Pariwisata Universitas Muhammadiyah Sumbar', 'icon' => 'fa-umbrella-beach', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '19', 'short' => '19. Fakultas Kesehatan UM Sumbar', 'full' => 'Fakultas Kesehatan Universitas Muhammadiyah Sumbar', 'icon' => 'fa-kit-medical', 'progress' => 45, 'status' => 'Proses', 'step' => 2, 'step_label' => 'Pengisian', 'status_type' => 'berjalan'],
                ['code' => '20', 'short' => '20. Akfar Imam Bonjol Bukittinggi', 'full' => 'Akademi Farmasi Imam Bonjol Bukittinggi', 'icon' => 'fa-pills', 'progress' => 0, 'status' => 'Belum Terisi', 'step' => 1, 'step_label' => 'Belum Mulai', 'status_type' => 'belum'],
                ['code' => '21', 'short' => '21. Univ. Fort De Kock Bukittinggi', 'full' => 'Universitas Fort De Kock Bukittinggi', 'icon' => 'fa-university', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '22', 'short' => '22. Akfar Dwi Farma Bukittinggi', 'full' => 'Akademi Farmasi Dwi Farma Bukittinggi', 'icon' => 'fa-prescription-bottle-medical', 'progress' => 35, 'status' => 'Proses', 'step' => 2, 'step_label' => 'Pengisian', 'status_type' => 'berjalan'],
                ['code' => '23', 'short' => '23. Akademi Akuntansi Paramita', 'full' => 'Akademi Akuntansi Paramita Bukittinggi', 'icon' => 'fa-calculator', 'progress' => 0, 'status' => 'Belum Terisi', 'step' => 1, 'step_label' => 'Belum Mulai', 'status_type' => 'belum'],
                ['code' => '24', 'short' => '24. UPT Pustaka Bung Hatta', 'full' => 'UPT Perpustakaan Proklamator Bung Hatta', 'icon' => 'fa-book', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '25', 'short' => '25. PMI Kota Bukittinggi', 'full' => 'Palang Merah Indonesia Kota Bukittinggi', 'icon' => 'fa-square-plus', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '26', 'short' => '26. BPJS Kesehatan & Ketenagakerjaan', 'full' => 'BPJS Kesehatan & Ketenagakerjaan Bukittinggi', 'icon' => 'fa-shield-heart', 'progress' => 85, 'status' => 'Terisi', 'step' => 4, 'step_label' => 'Validasi BPS', 'status_type' => 'berjalan'],
                ['code' => '27', 'short' => '27. Pengadilan Negeri Bukittinggi', 'full' => 'Pengadilan Negeri Kota Bukittinggi', 'icon' => 'fa-gavel', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '28', 'short' => '28. Kejaksaan Negeri Bukittinggi', 'full' => 'Kejaksaan Negeri Kota Bukittinggi', 'icon' => 'fa-shield-halved', 'progress' => 70, 'status' => 'Terisi', 'step' => 3, 'step_label' => 'Sedang Berjalan', 'status_type' => 'berjalan'],
                ['code' => '29', 'short' => '29. Pengadilan Agama Bukittinggi', 'full' => 'Pengadilan Agama Kota Bukittinggi', 'icon' => 'fa-scale-balanced', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '30', 'short' => '30. Polres Bukittinggi', 'full' => 'Kepolisian Resor Kota Bukittinggi', 'icon' => 'fa-handcuffs', 'progress' => 75, 'status' => 'Terisi', 'step' => 4, 'step_label' => 'Validasi BPS', 'status_type' => 'berjalan'],
                ['code' => '31', 'short' => '31. PT PLN (Persero) ULP Bukittinggi', 'full' => 'PT PLN (Persero) ULP Bukittinggi', 'icon' => 'fa-bolt', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '32', 'short' => '32. Perumda Air Minum Tirta Jam Gadang', 'full' => 'Perumda Air Minum Tirta Jam Gadang', 'icon' => 'fa-faucet-drip', 'progress' => 80, 'status' => 'Terisi', 'step' => 4, 'step_label' => 'Validasi BPS', 'status_type' => 'berjalan'],
                ['code' => '33', 'short' => '33. UPTD Samsat Bukittinggi', 'full' => 'UPTD Samsat / Pendapatan Daerah Bukittinggi', 'icon' => 'fa-receipt', 'progress' => 60, 'status' => 'Terisi', 'step' => 3, 'step_label' => 'Sedang Berjalan', 'status_type' => 'berjalan'],
                ['code' => '34', 'short' => '34. PT Pos Indonesia Bukittinggi', 'full' => 'PT Pos Indonesia (Persero) Kantor Pos Bukittinggi', 'icon' => 'fa-envelope-open-text', 'progress' => 100, 'status' => 'Selesai', 'step' => 5, 'step_label' => 'Selesai', 'status_type' => 'selesai'],
                ['code' => '35', 'short' => '35. LPP RRI Bukittinggi', 'full' => 'LPP Radio Republik Indonesia Bukittinggi', 'icon' => 'fa-tower-broadcast', 'progress' => 50, 'status' => 'Proses', 'step' => 3, 'step_label' => 'Sedang Berjalan', 'status_type' => 'berjalan'],
                ['code' => '36', 'short' => '36. PT TASPEN Cabang Bukittinggi', 'full' => 'PT TASPEN (Persero) Kantor Cabang Bukittinggi', 'icon' => 'fa-piggy-bank', 'progress' => 75, 'status' => 'Terisi', 'step' => 4, 'step_label' => 'Validasi BPS', 'status_type' => 'berjalan'],
                ['code' => '37', 'short' => '37. Perum BULOG Cabang Bukittinggi', 'full' => 'Perum BULOG Kantor Cabang Bukittinggi', 'icon' => 'fa-wheat-awn', 'progress' => 0, 'status' => 'Belum Terisi', 'step' => 1, 'step_label' => 'Belum Mulai', 'status_type' => 'belum'],
            ];

            $selectedYear = (int) request('year', 2025);
            $endYear = max(2036, ((int) date('Y')) + 10);
            $availableYears = range($endYear, 2018);

            // Ambil penyesuaian tahapan manual instansi jika ada
            $manualStagesInstansi = \App\Models\MonitoringStage::where('agency_type', 'instansi')
                ->where('year', $selectedYear)
                ->pluck('stage', 'agency_code')
                ->toArray();

            // Hitung status verifikasi riil (Menunggu ACC, Di-ACC, Revisi) per Instansi
            $submittedCountsInstansi = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'submitted')
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            $verifiedCountsInstansi = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'verified')
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            $revisionCountsInstansi = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('verification_status', 'revision')
                ->select('opd_code', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('opd_code')
                ->pluck('count', 'opd_code')
                ->toArray();

            // Status lengkap per tabel untuk Card Monitoring Tabel dengan deteksi keterisian angka data riil
            $allTablesRawInst = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->select('table_code', 'opd_code', 'year', 'title_id', 'title_en', 'source', 'note', 'is_saved', 'verification_status', 'table_html', 'updated_at')
                ->get();

            $tabelDataCountsInst = \App\Models\TabelData::where('year', $selectedYear)
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

            $allTablesStatus = [];
            foreach ($allTablesRawInst as $item) {
                $cOpd = str_pad($item->opd_code, 2, '0', STR_PAD_LEFT);
                $dbKey = $cOpd . '_' . $item->table_code;
                $tdCount = isset($tabelDataCountsInst[$dbKey]) ? (int) $tabelDataCountsInst[$dbKey]->count : 0;
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
                    'status' => $eval['status'],
                    'status_label' => $eval['status_label'],
                    'numeric_cells' => $eval['numeric_cells'],
                    'empty_cells' => $eval['empty_cells'],
                    'total_cells' => $eval['total_cells'],
                    'numeric_pct' => $eval['pct'],
                ];
            }

            $countSelesai = 0;
            $countBerjalan = 0;
            $countBelum = 0;

            foreach ($instansiList as &$inst) {
                $code = $inst['code'];
                $pct = $inst['progress'];

                $inst['submitted'] = $submittedCountsInstansi[$code] ?? ($submittedCountsInstansi[ltrim($code, '0')] ?? 0);
                $inst['verified'] = $verifiedCountsInstansi[$code] ?? ($verifiedCountsInstansi[ltrim($code, '0')] ?? 0);
                $inst['revision'] = $revisionCountsInstansi[$code] ?? ($revisionCountsInstansi[ltrim($code, '0')] ?? 0);

                if ($pct === 100) {
                    $inst['step'] = 4;
                    $inst['step_label'] = 'Validasi BPS';
                    $inst['status'] = 'Validasi BPS';
                    $inst['status_type'] = 'berjalan';
                }

                if (isset($manualStagesInstansi[$code])) {
                    $st = (int) $manualStagesInstansi[$code];
                    $info = \App\Models\MonitoringStage::getStageInfo($st);
                    $inst['step'] = $st;
                    $inst['step_label'] = $info['label'];
                    $inst['status'] = $info['badge'];
                    $inst['status_type'] = $info['type'];
                }

                if ($inst['step'] === 5) {
                    $countSelesai++;
                } elseif ($inst['step'] >= 2) {
                    $countBerjalan++;
                } else {
                    $countBelum++;
                }
            }
            unset($inst);

            $countTotal = count($instansiList);

            // Donut chart stroke dash calculations
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
                'activeTab' => 'instansi',
                'selectedYear' => $selectedYear,
                'availableYears' => $availableYears
            ])

            <!-- CARD MONITORING TABEL PER INSTANSI & PER TABEL (SESUAI REQUEST USER) -->
            @include('monitoring.partials.monitoring-tabel-card', [
                'activeTab' => 'instansi',
                'selectedYear' => $selectedYear,
                'availableYears' => $availableYears
            ])

            <!-- TWO-COLUMN LAYOUT -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-5 items-start">
                
                <!-- LEFT COLUMN: INSTANSI PROGRESS CARDS (XL: 9 Columns) -->
                <div class="xl:col-span-9 space-y-3">
                    
                    <!-- FILTER & SEARCH BAR -->
                    <div class="no-print flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white rounded-2xl p-3 border border-slate-100 shadow-2xs mb-3">
                        <div class="relative flex-1">
                            <input type="text" 
                                   id="instansiSearchInput"
                                   oninput="filterAgencyCards()"
                                   placeholder="Cari instansi vertikal..."
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

                    <!-- DAFTAR KARTU INSTANSI (KOMPONEN TERPISAH) -->
                    @foreach($instansiList as $item)
                        @include('monitoring.partials.item-card', [
                            'item' => $item,
                            'agencyType' => 'instansi'
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
        const allInstansiData = @json($instansiList);

        function exportMonitoringExcel() {
            exportMonitoringToExcel({
                title: 'MONITORING PENGUMPULAN DATA SEKTORAL INSTANSI VERTIKAL & LAINNYA - TAHUN {{ $selectedYear }}',
                fileName: 'Monitoring_Data_Instansi_Bukittinggi_Tahun_{{ $selectedYear }}',
                dataset: allInstansiData,
                year: {{ $selectedYear }}
            });
        }
    </script>
    <script src="{{ asset('js/monitoring.js') }}"></script>
</body>
</html>
