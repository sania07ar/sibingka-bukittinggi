<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Data Instansi Vertikal dan Lainnya - SiBingka Kota Bukittinggi</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- Master Catalog Tables (OPD, Instansi & BPS) -->
    <script src="{{ asset('sibingka-catalogs.js') }}"></script>

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f2f5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom scrollbar */
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
    </style>
</head>
<body class="min-h-screen lg:h-screen lg:overflow-hidden text-slate-800 antialiased flex flex-col justify-between selection:bg-orange-500 selection:text-white bg-[#f0f2f5] relative overflow-x-hidden">

    <!-- Background SiBingka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-20 select-none">
        <img src="{{ asset('images/sibingka-watermark-jamgadang.jpg') }}" alt="Watermark SiBingka Jam Gadang" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-16 sm:-translate-x-28 -translate-y-6 object-contain mix-blend-multiply">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-between h-full min-h-0">
        
        <!-- HEADER / LOGO BAR -->
        @include('partials.navbar')

        <!-- MAIN SECTION: LIST INSTANSI VERTIKAL -->
        <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-1.5 sm:py-2 flex-1 flex flex-col justify-center w-full min-h-0">
            
            @php
                $loggedInstansiCode = session('user.opd_code');
                $loggedInstansiName = session('user.dinas_name');
                $userRole = session('user.role');
                $isAdmin = $userRole === 'admin';
                $isInstansiUser = !$isAdmin && ($userRole === 'instansi' || !empty($loggedInstansiCode));

                $instansiList = [
                    ['code' => '01', 'short' => 'PERTANAHAN', 'full' => 'Kantor Pertanahan Kota Bukittinggi (BPN)', 'search' => 'pertanahan bpn agraria', 'icon' => 'fa-map-location-dot'],
                    ['code' => '02', 'short' => 'KPUD', 'full' => 'Komisi Pemilihan Umum Daerah Kota Bukittinggi', 'search' => 'kpud kpu pemilu pilkada', 'icon' => 'fa-check-to-slot'],
                    ['code' => '03', 'short' => 'KEMENAG', 'full' => 'Kementerian Agama Kota Bukittinggi', 'search' => 'kemenag agama haji kua', 'icon' => 'fa-mosque'],
                    ['code' => '04', 'short' => 'DINAS PENDIDIKAN PROV', 'full' => 'Cabang Dinas Pendidikan Wilayah I Prov. Sumbar', 'search' => 'pendidikan provinsi sma smk', 'icon' => 'fa-graduation-cap'],
                    ['code' => '05', 'short' => 'PGSD UNP', 'full' => 'Program Studi PGSD Universitas Negeri Padang', 'search' => 'pgsd unp universitas negeri padang', 'icon' => 'fa-school'],
                    ['code' => '06', 'short' => 'PSIKOLOGI UNP', 'full' => 'Departemen Psikologi UNP Kampus Bukittinggi', 'search' => 'psikologi unp universitas negeri padang', 'icon' => 'fa-brain'],
                    ['code' => '07', 'short' => 'KEDOKTERAN UNP', 'full' => 'Fakultas Kedokteran UNP Kampus Bukittinggi', 'search' => 'kedokteran unp dokter medis', 'icon' => 'fa-user-doctor'],
                    ['code' => '08', 'short' => 'AKBID BLABA', 'full' => 'Akademi Kebidanan Bukittinggi (AKBID)', 'search' => 'akbid blaba bidan kebidanan', 'icon' => 'fa-baby'],
                    ['code' => '09', 'short' => 'KEP. GIGI', 'full' => 'Jurusan Keperawatan Gigi Poltekkes Bukittinggi', 'search' => 'keperawatan gigi poltekkes perawat', 'icon' => 'fa-tooth'],
                    ['code' => '10', 'short' => 'STKIP AL HUSSUNAH', 'full' => 'STKIP Al-Hussunah Bukittinggi', 'search' => 'stkip al hussunah keguruan', 'icon' => 'fa-book-bookmark'],
                    ['code' => '11', 'short' => 'STIT AL HUSSUNAH', 'full' => 'STIT Al-Hussunah Bukittinggi', 'search' => 'stit al hussunah tarbiyah islam', 'icon' => 'fa-book-quran'],
                    ['code' => '12', 'short' => 'STIKES PERINTIS', 'full' => 'STIKES Perintis Bukittinggi', 'search' => 'stikes perintis kesehatan upertis', 'icon' => 'fa-heart-pulse'],
                    ['code' => '13', 'short' => 'STIKES PRIMA NUSANTARA', 'full' => 'STIKES Prima Nusantara Bukittinggi', 'search' => 'stikes prima nusantara kesehatan', 'icon' => 'fa-hospital-user'],
                    ['code' => '14', 'short' => 'UNIV YARSI', 'full' => 'Universitas Mohammad Natsir Yarsi Bukittinggi', 'search' => 'univ yarsi universitas mohammad natsir', 'icon' => 'fa-building-columns'],
                    ['code' => '15', 'short' => 'ITB HAS', 'full' => 'Institut Teknologi dan Bisnis Haji Agus Salim', 'search' => 'itb has haji agus salim ekonomi bisnis', 'icon' => 'fa-laptop-code'],
                    ['code' => '16', 'short' => 'TEKNIK UM', 'full' => 'Fakultas Teknik Universitas Muhammadiyah Sumbar', 'search' => 'teknik umsb um sumbar muhammadiyah', 'icon' => 'fa-compass-drafting'],
                    ['code' => '17', 'short' => 'HUKUM UM', 'full' => 'Fakultas Hukum Universitas Muhammadiyah Sumbar', 'search' => 'hukum umsb um sumbar muhammadiyah', 'icon' => 'fa-scale-balanced'],
                    ['code' => '18', 'short' => 'PARIWISATA UM', 'full' => 'Fakultas Pariwisata Universitas Muhammadiyah Sumbar', 'search' => 'pariwisata pariwisata um umsb muhammadiyah', 'icon' => 'fa-umbrella-beach'],
                    ['code' => '19', 'short' => 'KESEHATAN UM', 'full' => 'Fakultas Kesehatan Universitas Muhammadiyah Sumbar', 'search' => 'kesehatan farmasi umsb um muhammadiyah', 'icon' => 'fa-kit-medical'],
                    ['code' => '20', 'short' => 'FARMASI IB', 'full' => 'Akademi Farmasi Imam Bonjol Bukittinggi', 'search' => 'akfar farmasi imam bonjol obat', 'icon' => 'fa-pills'],
                    ['code' => '21', 'short' => 'UNIV FORT DE KOCK', 'full' => 'Universitas Fort De Kock Bukittinggi', 'search' => 'fort de kock ufdk kesehatan farmasi universitas', 'icon' => 'fa-university'],
                    ['code' => '22', 'short' => 'FARMASI DF', 'full' => 'Akademi Farmasi Dwi Farma Bukittinggi', 'search' => 'farmasi df dwi farma obat', 'icon' => 'fa-prescription-bottle-medical'],
                    ['code' => '23', 'short' => 'AKADEMI PARAMITA', 'full' => 'Akademi Akuntansi Paramita Bukittinggi', 'search' => 'akademi paramita akuntansi', 'icon' => 'fa-calculator'],
                    ['code' => '24', 'short' => 'PUSTAKA BUNG HATTA', 'full' => 'UPT Perpustakaan Proklamator Bung Hatta', 'search' => 'perpustakaan bung hatta pustaka buku literasi', 'icon' => 'fa-book'],
                    ['code' => '25', 'short' => 'PMI', 'full' => 'Palang Merah Indonesia Kota Bukittinggi', 'search' => 'pmi palang merah darah donor', 'icon' => 'fa-square-plus'],
                    ['code' => '26', 'short' => 'BPJS', 'full' => 'BPJS Kesehatan & Ketenagakerjaan Bukittinggi', 'search' => 'bpjs kesehatan ketenagakerjaan jkn jamsostek', 'icon' => 'fa-shield-heart'],
                    ['code' => '27', 'short' => 'PENGADILAN NEGERI', 'full' => 'Pengadilan Negeri Kota Bukittinggi', 'search' => 'pengadilan negeri pn hukum perdata pidana', 'icon' => 'fa-gavel'],
                    ['code' => '28', 'short' => 'KEJAKSAAN NEGERI', 'full' => 'Kejaksaan Negeri Kota Bukittinggi', 'search' => 'kejaksaan negeri kejari jaksa hukum', 'icon' => 'fa-shield-halved'],
                    ['code' => '29', 'short' => 'PENGADILAN AGAMA', 'full' => 'Pengadilan Agama Kota Bukittinggi', 'search' => 'pengadilan agama pa syariah nikah cerai', 'icon' => 'fa-balance-scale'],
                    ['code' => '30', 'short' => 'POLRES', 'full' => 'Kepolisian Resor Kota Bukittinggi', 'search' => 'polres kepolisian polisi keamanan kriminal lalu lintas', 'icon' => 'fa-handcuffs'],
                    ['code' => '31', 'short' => 'PLN', 'full' => 'PT PLN (Persero) ULP Bukittinggi', 'search' => 'pln listrik daya energi ulp', 'icon' => 'fa-bolt'],
                    ['code' => '32', 'short' => 'PDAM', 'full' => 'Perumda Air Minum Tirta Jam Gadang', 'search' => 'pdam air tirta jam gadang perumda', 'icon' => 'fa-faucet-drip'],
                    ['code' => '33', 'short' => 'UPTD KANTOR PELAYANAN PENDAPATAN', 'full' => 'UPTD Samsat / Pendapatan Daerah Bukittinggi', 'search' => 'uptd samsat pelayanan pendapatan pajak kendaraan bpkb stnk', 'icon' => 'fa-receipt'],
                    ['code' => '34', 'short' => 'POS', 'full' => 'PT Pos Indonesia (Persero) Kantor Pos Bukittinggi', 'search' => 'pos indonesia kantor pos paket logistik surat kurir', 'icon' => 'fa-envelope-open-text'],
                    ['code' => '35', 'short' => 'RRI', 'full' => 'LPP Radio Republik Indonesia Bukittinggi', 'search' => 'rri radio siaran publik lpp informasi berita', 'icon' => 'fa-tower-broadcast'],
                    ['code' => '36', 'short' => 'TASPEN', 'full' => 'PT TASPEN (Persero) Kantor Cabang Bukittinggi', 'search' => 'taspen pensiun asn pns tabungan hari tua', 'icon' => 'fa-piggy-bank'],
                    ['code' => '37', 'short' => 'BULOG', 'full' => 'Perum BULOG Kantor Cabang Bukittinggi', 'search' => 'bulog beras pangan sembako perum logistik', 'icon' => 'fa-wheat-awn'],
                ];

                $userInstansi = null;
                if ($isInstansiUser) {
                    $formattedLoggedCode = !empty($loggedInstansiCode) ? str_pad($loggedInstansiCode, 2, '0', STR_PAD_LEFT) : null;
                    foreach ($instansiList as $item) {
                        if ($formattedLoggedCode && $item['code'] === $formattedLoggedCode) {
                            $userInstansi = $item;
                            break;
                        }
                        if (!empty($loggedInstansiName)) {
                            $dName = strtolower(trim($loggedInstansiName));
                            if (str_contains(strtolower($item['short']), $dName) || 
                                str_contains(strtolower($item['full']), $dName) || 
                                str_contains($dName, strtolower($item['short']))) {
                                $userInstansi = $item;
                                break;
                            }
                        }
                    }
                }
            @endphp

            @if($isInstansiUser && $userInstansi)
                <!-- Banner Notifikasi Instansi Vertikal Aktif -->
                <div class="mb-2 px-3.5 py-1.5 rounded-xl bg-orange-50 border border-orange-200/90 shadow-2xs flex flex-row items-center gap-2 shrink-0">
                    <div class="flex items-center space-x-2.5 text-xs font-bold text-orange-950 truncate">
                        <div class="w-6 h-6 rounded-lg bg-[#f95a00] text-white flex items-center justify-center text-xs shrink-0 shadow-2xs">
                            <i class="fa-solid fa-landmark-flag"></i>
                        </div>
                        <span class="truncate">Selamat Datang, <strong class="text-orange-900 underline">{{ $userInstansi['code'] }}. {{ $userInstansi['full'] }}</strong></span>
                    </div>
                </div>
            @endif

            <!-- White Card Container -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3 sm:p-4 md:px-5 md:py-3.5 shadow-lg shadow-slate-200/30 w-full transition-all flex flex-col justify-between h-[calc(100vh-125px)] sm:h-[calc(100vh-130px)] lg:h-[calc(100vh-120px)] max-h-[860px]">
                
                @if($isInstansiUser && $userInstansi)
                    <!-- Card Header: Khusus Instansi User -->
                    <div class="flex flex-row items-center justify-between gap-3 pb-2.5 sm:pb-3 border-b border-slate-100 shrink-0">
                        <div>
                            <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight">Instansi Anda</h1>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Silakan klik kartu instansi Anda di bawah untuk mengelola data tabel statistik</p>
                        </div>
                    </div>

                    <!-- TAMPILAN KHUSUS USER INSTANSI: HANYA 1 KARTU INSTANSINYA SENDIRI -->
                    <div class="py-8 sm:py-12 flex flex-col items-center justify-center my-auto">
                        <div class="w-full max-w-xl">
                            <button type="button"
                                    onclick="openInstansiModal('{{ $userInstansi['code'] }}', '{{ $userInstansi['short'] }}', '{{ $userInstansi['full'] }}')"
                                    class="group w-full bg-white hover:bg-orange-50/40 border-2 border-orange-200 hover:border-[#f95a00] rounded-3xl p-5 sm:p-7 shadow-sm hover:shadow-xl transition-all duration-200 text-left cursor-pointer transform hover:-translate-y-1 relative overflow-hidden">
                                
                                <div class="absolute -top-12 -right-12 w-36 h-36 bg-orange-100/50 rounded-full blur-xl group-hover:bg-orange-200/50 transition-all pointer-events-none"></div>

                                <div class="flex items-center space-x-4 sm:space-x-5 relative z-10">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-[#fff4eb] text-[#f95a00] flex items-center justify-center text-2xl sm:text-3xl shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                                        <i class="fa-solid {{ $userInstansi['icon'] }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight">
                                            {{ $userInstansi['short'] }}
                                        </h2>
                                        <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1 leading-snug">
                                            {{ $userInstansi['full'] }}
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-orange-100/70 group-hover:bg-[#f95a00] text-orange-500 group-hover:text-white flex items-center justify-center text-base sm:text-lg shrink-0 transition-all group-hover:translate-x-1 shadow-xs">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Card Header: Title & Search Filter (Untuk Admin) -->
                    <div class="flex flex-row items-center justify-between gap-3 pb-2 sm:pb-3 border-b border-slate-100 shrink-0">
                        <div>
                            <div class="flex items-center space-x-2">
                                <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight">Pilih Instansi Vertikal & Lainnya</h1>
                                <span class="hidden sm:inline-flex items-center text-[10px] font-extrabold text-[#f95a00] bg-orange-50 border border-orange-200 px-2 py-0.5 rounded-full">
                                    37 Instansi
                                </span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Silakan pilih instansi vertikal / mitra BPS untuk melihat dan mengisi data</p>
                        </div>

                        <div class="flex items-center space-x-2">
                            <!-- Search Input Box -->
                            <div class="relative w-44 sm:w-60 flex items-center">
                                <input type="text"
                                       id="instansiSearchInput"
                                       oninput="handleSearchInstansi(this.value)"
                                       placeholder="Cari instansi..."
                                       class="w-full bg-[#f8fafc] hover:bg-[#eef2f5] focus:bg-white border border-slate-200/90 focus:border-[#f95a00] rounded-full pl-4 pr-9 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/15 transition-all">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400" style="top: 0; bottom: 0; right: 0;">
                                    <i class="fa-solid fa-magnifying-glass text-xs leading-none"></i>
                                </div>
                                <button type="button" 
                                        id="instansiClearSearch" 
                                        onclick="clearInstansiSearch()" 
                                        class="hidden absolute right-8 inset-y-0 my-auto w-4 h-4 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center text-[9px] transition-colors cursor-pointer"
                                        style="top: 0; bottom: 0; margin-top: auto; margin-bottom: auto;"
                                        title="Hapus pencarian">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Scrollable Instansi Grid Container (Menyamping 5 Kolom) -->
                    <div class="flex-1 overflow-y-auto pr-1 my-2 min-h-0">
                        <div id="instansiGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2 sm:gap-2.5">
                            @foreach($instansiList as $item)
                                <button type="button"
                                        onclick="openInstansiModal('{{ $item['code'] }}', '{{ $item['short'] }}', '{{ $item['full'] }}')"
                                        data-search="{{ $item['code'] }} {{ strtolower($item['short']) }} {{ strtolower($item['full']) }} {{ $item['search'] }}"
                                        class="instansi-item group w-full bg-white hover:bg-orange-50/40 border border-slate-100 hover:border-orange-300 rounded-xl sm:rounded-2xl p-2 sm:p-2.5 flex items-center justify-between shadow-2xs hover:shadow-xs transition-all duration-150 text-left cursor-pointer {{ $loggedInstansiCode === $item['code'] ? 'ring-2 ring-[#f95a00]/40 border-orange-400' : '' }}">
                                    <div class="flex items-center space-x-2 sm:space-x-2.5 min-w-0">
                                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#fff4eb] text-[#f95a00] flex items-center justify-center text-xs sm:text-sm shrink-0 group-hover:scale-105 transition-transform">
                                            <i class="fa-solid {{ $item['icon'] }}"></i>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-[9.5px] sm:text-[10px] font-bold text-slate-400 leading-tight">{{ $item['code'] }}</span>
                                            <span class="text-[11px] sm:text-xs font-bold text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight line-clamp-2">{{ $item['short'] }}</span>
                                            @if($loggedInstansiCode === $item['code'])
                                                <span class="text-[8.5px] font-extrabold text-orange-600 bg-orange-100 px-1.5 py-0.2 rounded-full self-start shrink-0 mt-0.5">Instansi Anda</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-5 h-5 sm:w-5.5 sm:h-5.5 rounded-full bg-orange-100/70 group-hover:bg-[#f95a00] text-orange-500 group-hover:text-white flex items-center justify-center text-[8px] shrink-0 ml-1 transition-all group-hover:translate-x-0.5">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        <!-- Empty State When Search Result Not Found -->
                        <div id="instansiEmptyState" class="hidden py-8 text-center">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 mx-auto flex items-center justify-center text-lg mb-2 shadow-xs">
                                <i class="fa-solid fa-building-circle-xmark"></i>
                            </div>
                            <h3 class="text-xs font-bold text-slate-800">Instansi Tidak Ditemukan</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5 max-w-sm mx-auto">Tidak ada instansi vertikal yang cocok dengan kata kunci pencarian Anda.</p>
                            <button onclick="clearInstansiSearch()" class="mt-2 px-3 py-1 rounded-lg bg-orange-100 text-orange-700 font-bold text-xs hover:bg-orange-200 transition-colors">
                                Reset Pencarian
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Card Footer Actions: Blanko PDF (Admin Only) & Home (Centered) -->
                <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 mt-1 sm:mt-1.5 pt-2 border-t border-slate-100 shrink-0">
                    @if($isAdmin)
                        <!-- BLANKO PDF (Google Drive) - Hanya Muncul untuk Admin BPS -->
                        <a href="https://drive.google.com/drive/folders/1ytU-i5aTt7-94u2jiNefX8Ef0Hqr3_5E"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-lg bg-orange-50 hover:bg-orange-100 text-[#f95a00] hover:text-orange-700 font-bold text-xs border border-orange-200/80 transition-all shadow-2xs hover:shadow-xs"
                           title="Buka Folder Google Drive Blanko PDF">
                            <i class="fa-solid fa-file-pdf text-xs"></i>
                            <span>BLANKO PDF</span>
                        </a>
                    @endif

                    <!-- HOME -->
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center space-x-1.5 px-4 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-bold text-xs border border-slate-200/80 transition-all shadow-2xs hover:shadow-xs">
                        <i class="fa-solid fa-house text-xs"></i>
                        <span>HOME</span>
                    </a>
                </div>

            </div>

        </main>

        <!-- FOOTER & USER SESSION BAR -->
        @include('dinas.partials.footer', [
            'isAdmin' => $isAdmin,
            'userIcon' => $userInstansi['icon'] ?? 'fa-landmark'
        ])

    </div>

    <!-- MODAL DAFTAR TABEL INSTANSI -->
    @include('dinas.partials.modal-tabel-list', [
        'modalId' => 'instansiModal',
        'headerTagId' => 'instansiHeaderTag',
        'headingId' => 'tabelWajibHeading',
        'headingText' => '1. Tabel Wajib Instansi',
        'closeFn' => 'closeInstansiModal()',
        'isAdmin' => $isAdmin,
        'searchPlaceholder' => 'Cari tabel instansi...'
    ])

    <!-- MODAL PILIH TAHUN -->
    @include('dinas.partials.modal-pilih-tahun')

    <!-- MODAL TAMBAH TABEL BARU (HANYA ADMINISTRATOR BPS) -->
    @if($isAdmin)
        @include('dinas.partials.modal-tambah-tabel', [
            'agencyList' => $instansiList,
            'agencyTypeLabel' => 'Instansi Vertikal Penyelenggara Data'
        ])
    @endif

    <!-- JAVASCRIPT CONFIG & INITIALIZATION -->
    <script>
        window.DinasCatalogConfig = {
            type: 'instansi',
            isAdmin: {{ $isAdmin ? 'true' : 'false' }},
            saveUrl: "{{ route('tabel-opd.api.save-custom-catalog') }}",
            deleteUrl: "{{ route('tabel-opd.api.delete-custom-catalog') }}",
            customCatalogUrl: "{{ url('/api/tabel-opd/custom-catalog') }}",
            tabelOpdUrl: "{{ url('/tabel-opd') }}",
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
    <script src="{{ asset('js/dinas-catalog.js') }}"></script>
</body>
</html>
