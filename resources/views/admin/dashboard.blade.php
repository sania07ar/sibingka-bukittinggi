<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    @include('partials.base-url')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiBingka Kota Bukittinggi - {{ (session('user.role') === 'walidata') ? 'Wali Data (Diskominfo)' : 'Administrator BPS Kota Bukittinggi' }}</title>
    
    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/sibingka-icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sibingka-icon.png') }}">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..900;1,14..32,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ @filemtime(public_path('css/dashboard.css')) }}">
</head>
<body class="min-h-screen text-slate-800 flex flex-col selection:bg-orange-500 selection:text-white bg-[#f1f4f9] relative overflow-x-hidden">

    @php
        $currentUser = session('user', []);
        $userRole = $currentUser['role'] ?? 'admin';
        $isAdmin = ($userRole === 'admin');
        $isWaliData = ($userRole === 'walidata');
        $dinasName = $currentUser['displayName'] ?? ($isWaliData ? 'Wali Data (Diskominfo)' : 'Administrator BPS');
        $allowedPages = $currentUser['allowed_pages'] ?? array_keys(config('sibingka.pages', []));

        $totalOpd = 20;
        $totalInstansi = 37;

        $selectedYear = (int) request('year', date('Y'));
        $endYear = max(2036, ((int) date('Y')) + 10);
        $availableYears = range($endYear, 2015);

        try {
            $opdList = config('sibingka.opd_list', []);
            $instansiList = config('sibingka.instansi_list', []);

            // 1. Ambil metadata tabel yang tersimpan dan bukan sekadar template kosong untuk tahun terpilih
            $savedMetas = \App\Models\TabelMetadata::where('year', $selectedYear)
                ->where('is_saved', 1)
                ->where('source_type', '!=', 'template')
                ->get();

            // 2. Ambil baris data bernilai riil dari TabelData
            $tdRows = \App\Models\TabelData::where('year', $selectedYear)
                ->whereNotNull('value')
                ->whereNotIn('value', ['', '-', '–', '—', 'null', '...'])
                ->select('opd_code', 'table_code')
                ->distinct()
                ->get();

            $filledOpds = [];
            $filledInstansi = [];
            $filledBps = [];
            $tablesWithData = [];
            $metaNumericCount = 0;

            foreach ($savedMetas as $m) {
                $eval = $m->getNumericStatus();
                if ($eval['numeric_cells'] > 0 || $eval['status'] !== 'belum') {
                    $cOpd = (string) $m->opd_code;
                    $tablesWithData[$cOpd . '_' . $m->table_code] = true;
                    $metaNumericCount += $eval['numeric_cells'];

                    if (str_contains($m->source_type, 'bps') || str_starts_with($cOpd, 'bps')) {
                        $filledBps[$cOpd] = true;
                    } elseif (str_contains($m->source_type, 'instansi') || (is_numeric($cOpd) && (int)$cOpd > 20)) {
                        $filledInstansi[$cOpd] = true;
                    } else {
                        $c = str_pad($cOpd, 2, '0', STR_PAD_LEFT);
                        if (isset($opdList[$c])) {
                            $filledOpds[$c] = true;
                        } else {
                            $filledInstansi[$cOpd] = true;
                        }
                    }
                }
            }

            foreach ($tdRows as $td) {
                $cOpd = (string) $td->opd_code;
                $tablesWithData[$cOpd . '_' . $td->table_code] = true;

                if (str_contains($td->opd_code, 'bps')) {
                    $filledBps[$cOpd] = true;
                } elseif (is_numeric($cOpd) && (int)$cOpd > 20) {
                    $filledInstansi[$cOpd] = true;
                } else {
                    $c = str_pad($cOpd, 2, '0', STR_PAD_LEFT);
                    if (isset($opdList[$c])) {
                        $filledOpds[$c] = true;
                    } else {
                        $filledInstansi[$cOpd] = true;
                    }
                }
            }

            $filledOpdCount = count($filledOpds);
            $filledInstansiCount = count($filledInstansi);
            $filledBpsCount = count($filledBps);
            $totalEntitiesFilled = $filledOpdCount + $filledInstansiCount + $filledBpsCount;
            $savedTableCount = count($tablesWithData);

            $tdCellCount = \App\Models\TabelData::where('year', $selectedYear)
                ->whereNotNull('value')
                ->whereNotIn('value', ['', '-', '–', '—', 'null', '...'])
                ->count();

            $realDataCount = max($metaNumericCount, $tdCellCount);
        } catch (\Throwable $e) {
            $filledOpdCount = 0;
            $filledInstansiCount = 0;
            $filledBpsCount = 0;
            $totalEntitiesFilled = 0;
            $savedTableCount = 0;
            $realDataCount = 0;
        }
    @endphp

    <!-- Flash Alert Notification -->
    @if(session('error'))
        <div id="welcome-alert-error" class="fixed top-20 sm:top-24 inset-x-0 z-50 flex justify-center px-4 pointer-events-none">
            <div class="w-full max-w-lg pointer-events-auto p-3.5 rounded-2xl text-xs font-bold flex items-start sm:items-center justify-between gap-2.5 bg-red-600 text-white shadow-2xl shadow-red-900/30 border border-red-500">
                <div class="flex items-start sm:items-center space-x-2.5 min-w-0 flex-1">
                    <i class="fa-solid fa-circle-exclamation text-base shrink-0 mt-0.5 sm:mt-0"></i>
                    <span class="break-words leading-snug">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('welcome-alert-error').remove()" class="text-white hover:text-red-200 text-sm shrink-0 p-1 -mr-1 -mt-0.5 sm:mt-0 cursor-pointer" title="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div id="welcome-alert-success" class="fixed top-20 sm:top-24 inset-x-0 z-50 flex justify-center px-4 pointer-events-none">
            <div class="w-full max-w-lg pointer-events-auto p-3.5 rounded-2xl text-xs font-bold flex items-start sm:items-center justify-between gap-2.5 bg-emerald-600 text-white shadow-2xl shadow-emerald-900/30 border border-emerald-500">
                <div class="flex items-start sm:items-center space-x-2.5 min-w-0 flex-1">
                    <i class="fa-solid fa-circle-check text-base shrink-0 mt-0.5 sm:mt-0"></i>
                    <span class="break-words leading-snug">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('welcome-alert-success').remove()" class="text-white hover:text-emerald-200 text-sm shrink-0 p-1 -mr-1 -mt-0.5 sm:mt-0 cursor-pointer" title="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Ambient Glow Background Spheres -->
    <div class="ambient-sphere w-[550px] h-[550px] bg-orange-200/50 -top-40 -left-40"></div>
    <div class="ambient-sphere w-[500px] h-[500px] bg-blue-100/50 -top-20 -right-20"></div>

    @include('admin.partials.dashboard.header')

    <!-- ======================================================== -->
    <!-- 2. MAIN CONTENT: HERO, METRICS, AKSES DATA & MONITORING  -->
    <!-- ======================================================== -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-4 flex-1 w-full">
        
        @include('admin.partials.dashboard.hero')

        @include('admin.partials.dashboard.stats')

        @include('admin.partials.dashboard.sections')

    </main>

    @include('admin.partials.dashboard.footer')

    @include('admin.partials.dashboard.about-modal')

    @include('admin.partials.dashboard.scripts')
</body>
</html>

