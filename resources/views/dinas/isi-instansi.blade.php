<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Data Instansi Vertikal dan Lainnya - SiAngka Kota Bukittinggi</title>
    
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

    <!-- Background Sensus Ekonomi Ribbon Watermark (Exact Match to Mockup) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-35">
        <img src="/images/sensus-ribbon-watermark.png" alt="Sensus Ekonomi Ribbon Watermark" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-16 sm:-translate-x-32 -translate-y-6 object-contain">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-between h-full min-h-0">
        
        <!-- HEADER / LOGO BAR -->
        @include('partials.navbar')

        <!-- MAIN SECTION: LIST INSTANSI VERTIKAL (Menyamping 5 Kolom) -->
        <main class="max-w-7xl 2xl:max-w-[1550px] mx-auto px-2.5 sm:px-4 lg:px-6 py-1.5 sm:py-2 flex-1 flex flex-col justify-center w-full min-h-0">
            
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
                <div class="mb-2 px-3.5 py-1.5 rounded-xl bg-orange-50 border border-orange-200/90 shadow-2xs flex flex-row items-center justify-between gap-2 shrink-0">
                    <div class="flex items-center space-x-2.5 text-xs font-bold text-orange-950 truncate">
                        <div class="w-6 h-6 rounded-lg bg-[#f95a00] text-white flex items-center justify-center text-xs shrink-0 shadow-2xs">
                            <i class="fa-solid fa-landmark-flag"></i>
                        </div>
                        <span class="truncate">Selamat Datang, <strong class="text-orange-900 underline">{{ $userInstansi['code'] }}. {{ $userInstansi['full'] }}</strong></span>
                    </div>
                    <span class="text-[10px] font-extrabold text-[#f95a00] bg-white border border-orange-200 px-2.5 py-0.5 rounded-full shadow-2xs shrink-0">
                        <i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Terverifikasi
                    </span>
                </div>
            @endif

            <!-- White Card Container -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3 sm:p-4 md:px-5 md:py-3.5 shadow-lg shadow-slate-200/30 w-full transition-all flex flex-col justify-between h-[calc(100vh-125px)] sm:h-[calc(100vh-130px)] lg:h-[calc(100vh-120px)] max-h-[860px]">
                
                @if($isInstansiUser && $userInstansi)
                    <!-- Card Header: Khusus Instansi User -->
                    <div class="flex flex-row items-center justify-between gap-3 pb-2.5 sm:pb-3 border-b border-slate-100 shrink-0">
                        <div>
                            <div class="flex items-center space-x-2">
                                <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight">Instansi Anda</h1>
                                <span class="inline-flex items-center text-[10px] font-extrabold text-[#f95a00] bg-orange-50 border border-orange-200 px-2.5 py-0.5 rounded-full">
                                    1 Mitra Terdaftar
                                </span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Silakan klik kartu instansi Anda di bawah untuk mengelola data tabel statistik</p>
                        </div>
                    </div>

                    <!-- TAMPILAN KHUSUS USER INSTANSI: HANYA 1 KARTU INSTANSINYA SENDIRI -->
                    <div class="py-8 sm:py-12 flex flex-col items-center justify-center my-auto">
                        <div class="w-full max-w-xl">
                            <button type="button"
                                    onclick="openInstansiModal('{{ $userInstansi['code'] }}', '{{ $userInstansi['short'] }}', '{{ $userInstansi['full'] }}')"
                                    class="group w-full bg-linear-to-br from-white via-orange-50/25 to-orange-100/50 hover:to-orange-100/80 border-2 border-orange-300 hover:border-[#f95a00] rounded-3xl p-5 sm:p-7 shadow-md hover:shadow-2xl transition-all duration-200 text-left cursor-pointer transform hover:-translate-y-1 relative overflow-hidden">
                                
                                <div class="absolute -top-12 -right-12 w-36 h-36 bg-orange-200/40 rounded-full blur-xl group-hover:bg-orange-300/50 transition-all pointer-events-none"></div>

                                <div class="flex items-center space-x-4 sm:space-x-5 relative z-10">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-linear-to-br from-[#f95a00] to-orange-600 text-white flex items-center justify-center text-2xl sm:text-3xl shadow-lg shadow-orange-500/25 shrink-0 group-hover:scale-105 transition-transform">
                                        <i class="fa-solid {{ $userInstansi['icon'] }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="px-2.5 py-0.5 rounded-lg bg-indigo-100 text-indigo-950 font-black text-xs font-mono">
                                                KODE INSTANSI: {{ $userInstansi['code'] }}
                                            </span>
                                            <span class="px-2.5 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-extrabold text-[10.5px] inline-flex items-center">
                                                <i class="fa-solid fa-circle-check mr-1 text-[9px]"></i> Mitra Terhubung
                                            </span>
                                        </div>
                                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight">
                                            {{ $userInstansi['short'] }}
                                        </h2>
                                        <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1 leading-snug">
                                            {{ $userInstansi['full'] }}
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-orange-100 group-hover:bg-[#f95a00] text-orange-600 group-hover:text-white flex items-center justify-center text-sm sm:text-base shrink-0 transition-all group-hover:translate-x-1 shadow-xs">
                                        <i class="fa-solid fa-arrow-right"></i>
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

                        <!-- Search Input Box -->
                        <div class="relative w-48 sm:w-64 flex items-center">
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

                <!-- Card Footer Action: Home -->
                <div class="flex items-center justify-center mt-1 sm:mt-1.5 pt-2 border-t border-slate-100 shrink-0">
                    <!-- HOME -->
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center space-x-1.5 px-4 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-bold text-xs border border-slate-200/80 transition-all shadow-2xs hover:shadow-xs">
                        <i class="fa-solid fa-house text-xs"></i>
                        <span>HOME</span>
                    </a>
                </div>

            </div>

        </main>

        <!-- FOOTER & USER SESSION BAR DI BAGIAN BAWAH -->
        <footer class="w-full border-t border-slate-200/60 bg-white/40 backdrop-blur-sm py-1.5 px-4 sm:px-8 text-slate-600 shrink-0">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-1.5 text-xs">
                
                <!-- Info Pengguna yang Sedang Login & Tombol Logout -->
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-white/60 hover:bg-white/80 border border-slate-200/80 shadow-xs transition-all backdrop-blur-xs">
                    <div class="flex items-center space-x-1.5">
                        @if(session('user.role') === 'admin')
                            <div class="w-5 h-5 rounded-full overflow-hidden shrink-0 border border-slate-200 shadow-2xs" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px; max-width: 20px; max-height: 20px;">
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar Admin BPS" class="w-full h-full object-cover block rounded-full" style="width: 20px; height: 20px; max-width: 20px; max-height: 20px; object-fit: cover;">
                            </div>
                        @else
                            <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[9px] shadow-xs shrink-0" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;">
                                <i class="fa-solid fa-landmark"></i>
                            </div>
                        @endif
                        <span class="font-bold text-slate-800 text-xs">{{ session('user.displayName', 'Admin BPS Bukittinggi') }}</span>
                    </div>

                    <div class="h-3 w-px bg-slate-300"></div>

                    <form action="{{ route('logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari SiAngka Kota Bukittinggi?');">
                        @csrf
                        <button type="submit" 
                                title="Keluar dari sistem"
                                class="flex items-center space-x-1 text-slate-700 hover:text-red-600 font-bold transition-colors text-[11px] cursor-pointer group">
                            <i class="fa-solid fa-right-from-bracket text-[9px] text-slate-500 group-hover:text-red-600 transition-colors"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>

                <!-- Copyright & Address -->
                <div class="flex flex-col sm:flex-row items-center space-y-0.5 sm:space-y-0 sm:space-x-3 text-[11px] text-slate-500 text-center md:text-right">
                    <p>© {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bukittinggi</strong>.</p>
                    <span class="hidden sm:inline text-slate-300">•</span>
                    <span class="hover:text-orange-600 transition-colors">
                        <i class="fa-solid fa-location-dot text-[#f95a00] mr-1"></i>
                        Jl. Perwira No.58, Belakang Balok, Bukittinggi
                    </span>
                </div>

            </div>
        </footer>

    </div>

    <!-- INSTANSI TABLES INPUT MODAL (Full-Width Table matching OPD style) -->
    <div id="instansiModal" class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-4 md:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-2xl sm:rounded-3xl max-w-4xl w-full p-4 sm:p-6 md:p-7 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative overflow-hidden" id="instansiModalCard">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3.5">
                <!-- Left: Title & Instansi Badge Tag -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-[#f95a00] font-black text-sm shadow-xs" id="instansiModalBadge">
                        01
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-3 flex-wrap">
                        <h2 class="text-base sm:text-lg md:text-xl font-bold text-slate-800 tracking-tight">Input Tabel</h2>
                        <span id="instansiHeaderTag" class="text-xs sm:text-sm font-semibold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full border border-slate-200">
                            01. PERTANAHAN
                        </span>
                    </div>
                </div>

                <!-- Right: Close Button -->
                <button onclick="closeInstansiModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body (Full-Width Table) -->
            <div class="space-y-3.5 w-full">
                
                <div class="flex items-center justify-between mb-1">
                    <h3 id="tabelWajibHeading" class="text-xs sm:text-sm md:text-[15px] font-bold text-slate-800">
                        1. Tabel Wajib
                    </h3>
                    <span id="tabelBadgeCount" class="text-[11px] font-medium text-slate-400"></span>
                </div>

                <!-- Search Box (Full Width) -->
                <div class="relative flex items-center">
                    <input type="text"
                           id="tabelSearchInput"
                           oninput="handleSearchTable(this.value)"
                           placeholder="Cari tabel..."
                           class="w-full bg-[#f4f6f8] hover:bg-[#eef2f5] focus:bg-white border border-transparent focus:border-amber-400 rounded-xl pl-4 pr-10 py-2.5 text-xs sm:text-sm text-slate-700 placeholder-slate-400 focus:outline-none transition-all">
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-[#f98825]" style="top: 0; bottom: 0; right: 0;">
                        <i class="fa-solid fa-magnifying-glass text-xs sm:text-sm leading-none"></i>
                    </div>
                </div>

                <!-- Tables List Table (Full Width) -->
                <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-2xs bg-white min-h-[240px]">
                    <div class="overflow-x-auto max-h-[340px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 sticky top-0 z-10 bg-white text-[10px] sm:text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                                    <th class="py-2.5 px-4 w-20 sm:w-24 select-none cursor-pointer hover:text-slate-600" onclick="sortTableData('code')">
                                        <span>KODE</span> <i class="fa-solid fa-sort text-[8px] ml-0.5 opacity-60"></i>
                                    </th>
                                    <th class="py-2.5 px-4 select-none cursor-pointer hover:text-slate-600" onclick="sortTableData('title')">
                                        <span>JUDUL TABEL</span> <i class="fa-solid fa-sort text-[8px] ml-0.5 opacity-60"></i>
                                    </th>
                                    <th class="py-2.5 px-4 text-center w-28 sm:w-32 text-slate-400">
                                        <span>AKSI</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tabelListTableBody" class="divide-y divide-slate-100 text-xs">
                                <!-- Rendered dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer of Table: Tampilkan 10 hasil & Pagination -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-2 text-xs text-slate-500">
                    <div class="flex items-center space-x-1.5 text-[11px] sm:text-xs">
                        <span>Tampilkan</span>
                        <div class="relative inline-block">
                            <select id="itemsPerPageSelect" onchange="changeItemsPerPage(this.value)" class="appearance-none bg-[#fef6ee] hover:bg-[#fdeedc] text-[#f98825] border border-[#fbd4aa] rounded-lg px-2.5 py-0.5 pr-5 text-xs font-bold focus:outline-none cursor-pointer">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <i class="fa-solid fa-chevron-down text-[7px] text-[#f98825] absolute right-1.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                        <span>hasil</span>
                    </div>

                    <div class="flex items-center space-x-1" id="tabelPagination">
                        <!-- Pagination controls -->
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- POPUP PILIH TAHUN DATA (MUNCUL SAAT KLIK INPUT PADA TABEL) -->
    <div id="yearModal" class="fixed inset-0 z-60 hidden items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-md w-full p-5 sm:p-6 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative" id="yearModalCard">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-slate-100 pb-3 mb-4">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 text-[#f98825] flex items-center justify-center text-xs font-black shrink-0" id="selectedTableBadge">
                        1.1.1
                    </div>
                    <div>
                        <h3 id="selectedTableTitle" class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">
                            Nama Tabel
                        </h3>
                        <p id="selectedInstansiSubtitle" class="text-[11px] text-slate-400 font-medium">01. PERTANAHAN</p>
                    </div>
                </div>
                <button onclick="closeYearModal()" class="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors shrink-0 cursor-pointer">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            <!-- Modal Body: Sederhana Pilih Tahun -->
            <div class="space-y-4">
                <div>
                    <label for="selectedYearSelect" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Pilih Tahun:
                    </label>
                    <div class="relative">
                        <select id="selectedYearSelect" 
                                class="w-full bg-[#f4f6f8] hover:bg-[#eef2f5] focus:bg-white border border-slate-200 focus:border-[#f98825] rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 font-semibold focus:outline-none transition-all cursor-pointer appearance-none">
                            <option value="" selected disabled>Pilih Tahun</option>
                        </select>
                        <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-5 pt-3.5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                <button onclick="closeYearModal()" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors cursor-pointer">
                    Batal
                </button>
                <div class="flex items-center space-x-2">
                    <button onclick="submitSelectedYear()" class="px-4 py-2 rounded-xl bg-[#f98825] hover:bg-[#e07212] text-white text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5 cursor-pointer" title="Buka format tabel publikasi BPS">
                        <i class="fa-solid fa-table-cells text-[11px]"></i>
                        <span>Buka Data Tabel</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // Catalog Tabel untuk Instansi Vertikal & Mitra BPS
        const instansiTablesCatalog = {
            '01': [
                { code: '1.1.8', title: 'Jumlah Pembuatan Sertifikat Menurut Jenis Kepemilikan di Kota Bukittinggi', titleEn: 'Number Of Certificate  by type of ownersip in Bukittinggi' },
                { code: '1.1.9', title: 'Jumlah Pencatatan Peralihan Hak Menurut Jenis Kepemilikan di Kota Bukittinggi', titleEn: 'Number of changes Right Note by Owner in Bukittinggi' }
            ],
            '02': [
                { code: '2.2.1', title: 'Jumlah Anggota Dewan Perwakilan Rakyat Menurut Partai Politik dan Jenis Kelamin di Kota Bukittinggi (orang)', titleEn: 'Number of Regional House of Representative’s Member by Political and Sex in Bukittinggi Municipality (people) ' },
                { code: '2.2.2', title: 'Jumlah Anggota Dewan Perwakilan Rakyat Menurut Partai Politik dan Tingkat Pendidikan di Kota Bukittinggi', titleEn: 'Number of Regional House of Representative’s Member by Political and Education in Bukittinggi Municipality' },
                { code: '2.2.3', title: 'Jumlah Anggota Dewan Perwakilan Rakyat Menurut Partai Politik dan Agama di Kota Bukittinggi', titleEn: 'Number of Regional House of Representative’s Member by Political and Religion in Bukittinggi Municipality' }
            ],
            '03': [
                { code: '4.1.2', title: 'Jumlah Sekolah, Guru, dan Murid Raudatul Athfal (RA) di Bawah Kementerian Agama Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Kindergarten Under The Ministry of Religious Affairs by District in Bukittinggi Municipality' },
                { code: '4.1.4', title: 'Jumlah Sekolah, Guru, dan Murid Madrasah Ibtidaiyah (MI) di Bawah Kementerian Agama Menurut Kecamatan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Madrasah Ibtidaiyah (MI) Under The Ministry of Religious Affairs by District in Bukittinggi Municipality' },
                { code: '4.1.6', title: 'Jumlah Sekolah, Guru, dan Murid Madrasah Tsanawiyah (MTs) di Bawah Kementerian Agama Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Madrasah Tsanawiyah (MTs) Under The Ministry of Religious Affairs by Sub District in Bukittinggi Municipality' },
                { code: '4.1.9', title: 'Jumlah Sekolah, Guru, dan Murid Madrasah Aliyah (MA) di Bawah Kementerian Agama Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Madrasah Aliyah (MA) Under the Ministry of Religious Affairs by District in Bukittinggi Municipality' },
                { code: '4.1.10', title: 'Jumlah Sekolah, Guru, dan Murid Pondok Pesantren Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Islamic Boarding School by Subdistrict in Bukittinggi Municipality' },
                { code: '4.3.2', title: 'Jumlah Tempat Peribadatan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Prayer Houses by Religion of District in Bukittinggi Municipality' },
                { code: '4.3.9', title: 'Jumlah Nikah Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Marriage by District in Bukittinggi Municipality' },
                { code: '4.3.10', title: 'Jumlah Jemaah Haji Menurut Jenis Pekerjaan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Moeslem Pilgrims by Occupation of District in Bukittinggi' },
                { code: '4.3.11', title: 'Jumlah Jemaah Haji Menurut Jenis Pendidikan per Kecamatan di Kota Bukittinggi', titleEn: 'Number of Moeslem Pilgrims by Education Atteinment of District in Bukittinggi' },               
                { code: '4.3.12', title: 'Jumlah Jemaah Haji Menurut Golongan Umur dan Jenis Kelamin per Kecamatan di Kota Bukittinggi', titleEn: 'Number of Moeslem Pilgrims by Age Group and Sex of District in Bukittinggi' }
            ],
            '04': [
                { code: '4.1.7', title: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Atas (SMA) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Senior High Schools Under The Ministry of Education, Culture, Research, and Technology by Sub District in Bukittinggi Municipality' },
                { code: '4.1.8', title: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Kejuruan (SMK) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Teachers, and Pupils in Vocational High Schools Under The Ministry of Education, Culture, Research, and Technology by Sub District in Bukittinggi Municipality' }
            ],
            '05': [
                { code: '4.1.18', title: 'Jumlah Dosen di Fakultas PGSD UNP Belakang Balok', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas PGSD UNP Belakang Balok', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '06': [
                { code: '4.1.18', title: 'Jumlah Dosen di Fakultas Psikologi UNP Belakang Balok', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Psikologi UNP Belakang Balok', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '07': [
                { code: '4.1.18', title: 'Jumlah Dosen di Fakultas Kedokteran UNP Belakang Balok', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Kedokteran UNP Belakang Balok', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '08': [
                { code: '4.1.18', title: 'Jumlah Dosen di POLTEKES Depkes Prodi Akbid Belakang Balok', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan POLTEKES Depkes Prodi Akbid Belakang Balok', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '09': [
                { code: '4.1.18', title: 'Jumlah Dosen di POLTEKES Depkes Jurusan Keperawatan Gigi', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan POLTEKES Depkes Jurusan Keperawatan Gigi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '10': [
                { code: '4.1.18', title: 'Jumlah Dosen di STKIP Ahlussunah', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan STKIP Ahlussunah', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '11': [
                { code: '4.1.18', title: 'Jumlah Dosen di STIT Ahlussunah', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan STIT Ahlussunah', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '12': [
                { code: '4.1.18', title: 'Jumlah Dosen di Universitas Perintis Indonesia', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Universitas Perintis Indonesia', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '13': [
                { code: '4.1.18', title: 'Jumlah Dosen di Universitas Prima Nusantara', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan STIKES Prima Nusantara', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '14': [
                { code: '4.1.18', title: 'Jumlah Dosen di Univ Moh. Nasir Yarsi Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Univ Moh. Nasir Yarsi Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '15': [
                { code: '4.1.18', title: 'Jumlah Dosen di STIE, STBA, Akuntansi, Pertanian Agus Salim', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan STIE, STBA, Akuntansi, Pertanian Agus Salim', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '16': [
                { code: '4.1.18', title: 'Jumlah Dosen Fakultas Teknik Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Teknik Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '17': [
                { code: '4.1.18', title: 'Jumlah Dosen Fakultas Hukum Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Hukum Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '18': [
                { code: '4.1.18', title: 'Jumlah Dosen Fakultas Pariwisata Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Pariwisata Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '19': [
                { code: '4.1.18', title: 'Jumlah Dosen Fakultas Kesehatan Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Fakultas Kesehatan Universitas Muhammadiyah di Kota Bukittinggi', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '20': [
                { code: '4.1.18', title: 'Jumlah Dosen di Akademi Farmasi Imam Bonjol', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Akademi Farmasi Imam Bonjol', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '21': [
                { code: '4.1.18', title: 'Jumlah Dosen di Universitas Ford de Kock', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Universitas Ford de Kock', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '22': [
                { code: '4.1.18', title: 'Jumlah Dosen di Akademi Farmasi Dwi Farma ', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Akademi Farmasi Dwi Farma', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '23': [
                { code: '4.1.18', title: 'Jumlah Dosen di Akademi Pariwisata PARAMITA', titleEn: 'Number of Lecturer in Bukittinggi' },
                { code: '4.1.19', title: 'Jumlah Mahasiswa dan Lulusan Akademi Pariwisata PARAMITA', titleEn: 'Number of Students and Graduated in Academy/University in Bukittinggi' }
            ],
            '24': [
                { code: '4.1.21', title: 'Jumlah Pengunjung Pada UPT Perpustakaan Proklamator Bung Hatta Menurut Tingkat Pendidikan di Kota Bukittinggi', titleEn: 'Number of Visitor at UPT Perpustakaan Proklamator Bung Hatta by Education Level in Bukittinggi' },
                { code: '4.1.22', title: 'Jumlah Peminjam Buku Pada UPT Perpustakaan Proklamator Bung Hatta Menurut Pekerjaan di Kota Bukittinggi', titleEn: 'Number of Book Borrowed at Mhd. Hatta Library by Employment Status in Bukittinggi' },
                { code: '4.1.23', title: 'Jumlah Buku yang Dipinjamkan UPT Perpustakaan Proklamator Bung Hatta Menurut Penggolongan Koleksi Buku di Kota Bukittinggi', titleEn: 'Number of Books Which is Lended by  UPT Perpustakaan Proklamator Bung Hatta by Book Collection in Bukittinggi' }
            ],
            '25': [
                { code: '4.2.11', title: 'Jumlah Donatur Darah Menurut Golongan Darah yang Terdaftar pada PMI Kota Bukittinggi', titleEn: 'Number of Donor by Classification of Blood that Registered in Bukittinggi' }
            ],
            '26': [
                { code: '4.2.21', title: 'Jumlah Peserta Aktif BPJS Kesehatan per Puskesmas di Kota Bukittinggi di Kota Bukittinggi', titleEn: 'Number of Members Health Insurances by Civil Health Centre in Bukittinggi' },
                { code: '4.2.22', title: 'Jumlah Peserta Aktif BPJS Kesehatan Menurut jenis Kepesertaan di Kota Bukittinggi', titleEn: 'Number of Participant Health Insurance by Kind of Participant in Bukittinggi' }
            ],
            '27': [
                { code: '4.5.1', title: 'Jumlah Perkara yang Diterima dan Diputuskan oleh Pengadilan Negeri Bukittinggi di Kota Bukittinggi', titleEn: 'Number of Cases Which Reported and Cleared by Law Court in Bukittinggi' }
            ],
            '28': [
                { code: '4.5.2', title: 'Jumlah Perkara yang Masuk pada Kejaksaan Negeri Bukittinggi per Bulan di Kota Bukittinggi', titleEn: 'Number of Cases Which is Reported by Public by Month in Bukittinggi' },
                { code: '4.5.4', title: 'Jumlah Perkara yang Diselesaikan oleh Kejaksaan Negeri Bukittinggi per Bulan di Kota Bukittinggi', titleEn: 'Number of Cases Whics is Cleared by Public Count by Month in Bukittinggi' }
            ],
            '29': [
                { code: '4.5.5', title: 'Jumlah Perkara yang Diterima dan Diputuskan Pengadilan Agama Bukittinggi per Bulan di Kota Bukittinggi', titleEn: 'Number of Cases Which is Decided by Religion Count by Month in Bukittinggi' },
                { code: '4.5.3', title: 'Jenis Perkara Sisa Tahun Lalu yang Diterima dan Diputuskan Pengadilan Agama di Kota Bukittinggi', titleEn: 'Number of Cases Which is Decided by Religion Court in Bukittinggi' }
            ],
            '30': [
                { code: '4.5.6', title: 'Jumlah Kriminal Menurut Jenis Kejadian di Kota Bukittinggi', titleEn: 'Number of Crimes by Type of Crimes in Bukittinggi' },
                { code: '8.1.10', title: 'Banyaknya Tabrakan / Kecelakaan Lalu Lintas di Kota Bukittinggi', titleEn: 'Number of Traffic Accidents in Bukittinggi' }
            ],
            '31': [
                { code: '6.1', title: 'Daya Terpasang, Produksi, Listrik Terjual, dan Pelanggan di PLN Kota Bukittinggi (Ha)', titleEn: ' Installed Electricity Power, Production, and Electricity Sold at PLN Branch in Bukittinggi Municipality' },
                { code: '6.2', title: 'Jumlah Pelanggan Listrik di Kota Bukittinggi', titleEn: 'Number of Electricity Costumer in Bukittinggi Municipality' },
                { code: '6.3', title: 'Tenaga Listrik yang Dijual / Didistribusikan PLN Cabang Bukittinggi di Kota Bukittinggi', titleEn: 'Electric Power Which is Distributed by Branch Electric Enterprise Bukittinggi in Bukittinggi' }
            ],
            '32': [
                { code: '6.4', title: 'Jumlah Pelanggan dan Air yang Disalurkan oleh Perusahaan Umum Daerah Air Minum Tirta Jam Gadang Kota Bukittinggi', titleEn: 'Number of Customers and Distributed Water by Water Works Establishment Bukittinggi Municipality' }
            ],
            '33': [
                { code: '8.1.11', title: 'Jumlah Kendaraan Bermotor yang Mendaftar Ulang dan Balik Nama pada UPTD Pelayanan Pendapatan Provinsi di Kota Bukittinggi', titleEn: 'Number of Vehicles with Registered and Name Return on UPTD Provincial Incomes Service in Bukittinggi Municipality' }
            ],
            '34': [
                { code: '8.2.1', title: 'Jumlah Kantor Pos Pembantu Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Auxiliary Post Office by Subdistrict in Bukittinggi' },
                { code: '8.2.4', title: 'Jumlah Kiriman Surat dan Paket Yang Diterima dan Dikirim Kantor Pos Kota Bukittinggi', titleEn: 'Number of Letters and Packages Received and Sent by the Post Office of Bukittinggi Municipality' },
                { code: '8.2.5', title: 'Jumlah Wesel Pos yang Diterima / Dikirim di Kota Bukittinggi', titleEn: 'Number of Money Orders Sent Received / Send in Bukittinggi' },
                { code: '8.2.6', title: 'Jumlah Penerimaan dan Pengeluaran Giro dan Cek Pos di Kota Bukittinggi', titleEn: 'Number of Received and Paid of Giro and Postal Cheque in Bukittinggi' }
            ],
            '35': [
                { code: '8.2.7', title: 'Acara Siaran LPP RRI Bukittinggi', titleEn: 'Programmes of Radios Indonesian Republic in Bukittinggi' }            ],
            '36': [
                { code: '9.5', title: 'Jumlah Data Peserta Aktif Taspen Kota Bukittinggi', titleEn: 'Number of Data Taspens Member Active for Bukittinggi Municipality' },
                { code: '9.6', title: 'Jumlah Data Peserta Pensiun di Taspen Kota Bukittinggi', titleEn: 'Number of Data Taspens Member Inactive for Bukittinggi Municipality' }
            ],
            '37': [
                { code: '11.5', title: 'Penerimaan dan Penyaluran Beras Bulog dalam Daerah Kota Bukittinggi (kg)', titleEn: 'Inflow and Distribution of Rice Through Burreu of Logistic (Kg) in Bukittinggi Municipality' }
            ]
        };

        // State Management
        let currentInstansiCode = '01';
        let currentInstansiShort = 'PERTANAHAN';
        let currentInstansiFull = '';
        let currentTablesList = [];
        let filteredTablesList = [];
        let currentPage = 1;
        let itemsPerPage = 10;
        let selectedTableCode = '';
        let selectedTableTitle = '';
        let selectedTableTitleEn = '';

        // Search and filter instansi cards
        function handleSearchInstansi(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.instansi-item');
            let visibleCount = 0;

            items.forEach(item => {
                const searchText = (item.getAttribute('data-search') || item.innerText).toLowerCase();
                if (!q || searchText.includes(q)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            const emptyState = document.getElementById('instansiEmptyState');
            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }

            const clearBtn = document.getElementById('instansiClearSearch');
            if (clearBtn) {
                if (q) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }
        }

        function clearInstansiSearch() {
            const input = document.getElementById('instansiSearchInput');
            if (input) {
                input.value = '';
                handleSearchInstansi('');
                input.focus();
            }
        }

        function openInstansiModal(code, shortTitle, fullTitle) {
            currentInstansiCode = code;
            currentInstansiShort = shortTitle;
            currentInstansiFull = fullTitle;
            currentPage = 1;

            // Update Header Information
            document.getElementById('instansiModalBadge').innerText = code;
            document.getElementById('instansiHeaderTag').innerText = `${code}. ${shortTitle}`;
            document.getElementById('tabelWajibHeading').innerText = `1. Tabel Wajib`;

            // Load tables for this Instansi
            currentTablesList = instansiTablesCatalog[code] || [
                { code: '1.1.1', title: `Tabel Statistik Sektoral Utama - ${shortTitle}`, titleEn: `Main Sectoral Statistics Table - ${shortTitle}` },
                { code: '2.1.1', title: `Capaian Program dan Indikator Kinerja ${shortTitle}`, titleEn: `Program Achievements and Performance Indicators of ${shortTitle}` },
                { code: '3.1.1', title: `Rekapitulasi Layanan dan Pengelolaan Data ${shortTitle}`, titleEn: `Service Recapitulation and Data Management of ${shortTitle}` }
            ];
            filteredTablesList = [...currentTablesList];

            // Reset Search Input
            const searchInput = document.getElementById('tabelSearchInput');
            if (searchInput) searchInput.value = '';

            // Render Table Rows
            renderTableRows();

            // Show Modal
            const modal = document.getElementById('instansiModal');
            const card = document.getElementById('instansiModalCard');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeInstansiModal() {
            const modal = document.getElementById('instansiModal');
            const card = document.getElementById('instansiModalCard');

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 250);
        }

        function handleSearchTable(query) {
            const q = query.trim().toLowerCase();
            if (!q) {
                filteredTablesList = [...currentTablesList];
            } else {
                filteredTablesList = currentTablesList.filter(t => 
                    t.code.toLowerCase().includes(q) || 
                    t.title.toLowerCase().includes(q) ||
                    (t.titleEn && t.titleEn.toLowerCase().includes(q))
                );
            }
            currentPage = 1;
            renderTableRows();
        }

        function renderTableRows() {
            const tbody = document.getElementById('tabelListTableBody');
            const paginationContainer = document.getElementById('tabelPagination');
            const total = filteredTablesList.length;
            
            document.getElementById('tabelBadgeCount').innerText = `${total} tabel ditemukan`;

            if (total === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="py-10 text-center text-slate-400 text-xs">
                            <i class="fa-solid fa-folder-open text-3xl text-slate-300 block mb-2"></i>
                            Tidak ada tabel yang sesuai dengan kata kunci pencarian.
                        </td>
                    </tr>
                `;
                paginationContainer.innerHTML = '';
                return;
            }

            const totalPages = Math.ceil(total / itemsPerPage);
            if (currentPage > totalPages) currentPage = totalPages;
            const startIdx = (currentPage - 1) * itemsPerPage;
            const pageItems = filteredTablesList.slice(startIdx, startIdx + itemsPerPage);

            tbody.innerHTML = pageItems.map(tbl => {
                const titleEscaped = tbl.title.replace(/'/g, "\\'");
                const titleEnEscaped = tbl.titleEn ? tbl.titleEn.replace(/'/g, "\\'") : '';
                return `
                <tr onclick="openYearModal('${tbl.code}', '${titleEscaped}', '${titleEnEscaped}')"
                    class="hover:bg-amber-50/60 transition-colors group cursor-pointer">
                    <td class="py-3 px-4 align-middle">
                        <span class="inline-flex items-center justify-center bg-[#f98825] group-hover:bg-[#e07212] text-white font-bold text-[11px] px-2.5 py-0.5 rounded-full shadow-2xs transition-colors">
                            ${tbl.code}
                        </span>
                    </td>
                    <td class="py-3 px-4 align-middle text-slate-700 group-hover:text-slate-900 text-xs font-medium leading-relaxed">
                        <div class="flex items-center justify-between gap-2">
                            <div>
                                <span class="font-semibold text-slate-800">${tbl.title}</span>
                                ${tbl.titleEn ? `<span class="text-slate-400 mx-1">/</span><span class="italic text-slate-500 font-normal">${tbl.titleEn}</span>` : ''}
                            </div>
                            <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#f98825] transition-transform group-hover:translate-x-1 shrink-0"></i>
                        </div>
                    </td>
                    <td class="py-3 px-4 align-middle text-center">
                        <button onclick="event.stopPropagation(); openYearModal('${tbl.code}', '${titleEscaped}', '${titleEnEscaped}')"
                                title="Input Data Tabel ${tbl.code}"
                                class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-amber-50 group-hover:bg-[#f98825] text-[#f98825] group-hover:text-white border border-amber-200 group-hover:border-transparent font-bold text-[11px] transition-all shadow-2xs cursor-pointer">
                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                            <span>Input Data</span>
                        </button>
                    </td>
                </tr>
            `}).join('');

            // Render Pagination buttons
            let pagHtml = '';
            pagHtml += `<button onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled class="w-6 h-6 rounded text-slate-300 flex items-center justify-center cursor-not-allowed"' : 'class="w-6 h-6 rounded text-slate-600 hover:bg-slate-100 flex items-center justify-center cursor-pointer"'}><i class="fa-solid fa-chevron-left text-[9px]"></i></button>`;

            for (let p = 1; p <= totalPages; p++) {
                if (p === currentPage) {
                    pagHtml += `<button class="w-6 h-6 rounded bg-[#f98825] text-white font-bold text-xs flex items-center justify-center shadow-2xs">${p}</button>`;
                } else {
                    pagHtml += `<button onclick="goToPage(${p})" class="w-6 h-6 rounded text-slate-600 hover:bg-slate-100 text-xs flex items-center justify-center cursor-pointer">${p}</button>`;
                }
            }

            pagHtml += `<button onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled class="w-6 h-6 rounded text-slate-300 flex items-center justify-center cursor-not-allowed"' : 'class="w-6 h-6 rounded text-slate-600 hover:bg-slate-100 flex items-center justify-center cursor-pointer"'}><i class="fa-solid fa-chevron-right text-[9px]"></i></button>`;

            paginationContainer.innerHTML = pagHtml;
        }

        function goToPage(p) {
            const totalPages = Math.ceil(filteredTablesList.length / itemsPerPage);
            if (p < 1 || p > totalPages) return;
            currentPage = p;
            renderTableRows();
        }

        function changeItemsPerPage(val) {
            itemsPerPage = parseInt(val) || 10;
            currentPage = 1;
            renderTableRows();
        }

        function sortTableData(field) {
            filteredTablesList.sort((a, b) => {
                if (field === 'code') return a.code.localeCompare(b.code, undefined, { numeric: true });
                return a.title.localeCompare(b.title);
            });
            renderTableRows();
        }

        // Otomatis mengisi opsi tahun mulai tahun berjalan (misal 2026) hingga 2020.
        function populateYearOptions() {
            const yearSelect = document.getElementById('selectedYearSelect');
            if (!yearSelect) return;

            const currentYear = new Date().getFullYear();
            const endYear = Math.max(2036, currentYear + 10);

            let html = '<option value="" disabled>Pilih Tahun Data</option>';
            for (let y = endYear; y >= 2020; y--) {
                const is2025 = y === 2025;
                html += `<option value="${y}" ${is2025 ? 'selected' : ''}>Tahun ${y}</option>`;
            }
            yearSelect.innerHTML = html;
        }

        // POPUP PILIH TAHUN PADA TABEL TERPILIH
        function openYearModal(tableCode, tableTitle, tableTitleEn = '') {
            selectedTableCode = tableCode;
            selectedTableTitle = tableTitle;
            selectedTableTitleEn = tableTitleEn;

            document.getElementById('selectedTableBadge').innerText = tableCode;
            if (tableTitleEn && tableTitleEn.trim() !== '') {
                document.getElementById('selectedTableTitle').innerHTML = `
                    <span class="font-bold text-slate-900">${tableCode}. ${tableTitle}</span>
                    <span class="text-slate-400 font-normal mx-1">/</span>
                    <span class="italic text-slate-500 font-normal text-xs sm:text-[13px]">${tableTitleEn}</span>
                `;
            } else {
                document.getElementById('selectedTableTitle').innerText = `${tableCode}. ${tableTitle}`;
            }
            document.getElementById('selectedInstansiSubtitle').innerText = `${currentInstansiCode}. ${currentInstansiShort}`;

            // Generate opsi tahun dinamis
            populateYearOptions();

            const yearSelect = document.getElementById('selectedYearSelect');
            if (yearSelect) {
                yearSelect.value = '2025';
            }

            const modal = document.getElementById('yearModal');
            const card = document.getElementById('yearModalCard');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeYearModal() {
            const modal = document.getElementById('yearModal');
            const card = document.getElementById('yearModalCard');

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 250);
        }

        function submitSelectedYear() {
            const selectEl = document.getElementById('selectedYearSelect');
            const year = selectEl ? selectEl.value : '';
            if (!year) {
                alert('Silakan pilih tahun terlebih dahulu.');
                return;
            }

            // Arahkan ke halaman detail tabel data
            let targetUrl = "{{ url('/tabel-opd') }}?type=instansi&opd=" + encodeURIComponent(currentInstansiCode) + 
                              "&code=" + encodeURIComponent(selectedTableCode) + 
                              "&year=" + encodeURIComponent(year);
            if (selectedTableTitle) {
                targetUrl += "&title=" + encodeURIComponent(selectedTableTitle);
            }
            if (selectedTableTitleEn) {
                targetUrl += "&title_en=" + encodeURIComponent(selectedTableTitleEn);
            }
            window.location.href = targetUrl;
        }

        // Close on Escape or overlay click
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const yearModal = document.getElementById('yearModal');
                if (yearModal && !yearModal.classList.contains('hidden')) {
                    closeYearModal();
                } else {
                    closeInstansiModal();
                }
            }
        });

        const instansiModalEl = document.getElementById('instansiModal');
        if (instansiModalEl) {
            instansiModalEl.addEventListener('click', (e) => {
                if (e.target.id === 'instansiModal') closeInstansiModal();
            });
        }

        const yearModalEl = document.getElementById('yearModal');
        if (yearModalEl) {
            yearModalEl.addEventListener('click', (e) => {
                if (e.target.id === 'yearModal') closeYearModal();
            });
        }
    </script>
</body>
</html>
