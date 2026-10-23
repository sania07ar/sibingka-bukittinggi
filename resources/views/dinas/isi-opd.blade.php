<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Data OPD - SiAngka Kota Bukittinggi</title>
    
    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    
    <!-- Google Fonts: Inter (Standar Formal Pemerintahan & Publikasi Statistik) -->
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

        /* OPD Action Buttons */
        .btn-opd {
            background-color: #f95a00;
            color: #ffffff;
            font-weight: 700;
            border-radius: 1.15rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1.1rem 1rem;
            min-height: 4.5rem;
            line-height: 1.3;
            box-shadow: 0 4px 12px rgba(249, 90, 0, 0.22);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-opd:hover {
            background-color: #e04e00;
            transform: translateY(-2px) scale(1.015);
            box-shadow: 0 8px 18px rgba(249, 90, 0, 0.35);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .btn-opd:active {
            transform: translateY(0) scale(0.99);
        }

        /* Bottom helper buttons (BLANKO PDF & HOME) */
        .btn-opd-bottom {
            background-color: #f28538;
            color: #ffffff;
            font-weight: 700;
            border-radius: 1.15rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1.1rem 1rem;
            min-height: 4.5rem;
            line-height: 1.3;
            box-shadow: 0 4px 12px rgba(242, 133, 56, 0.25);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-opd-bottom:hover {
            background-color: #e07223;
            transform: translateY(-2px) scale(1.015);
            box-shadow: 0 8px 18px rgba(242, 133, 56, 0.38);
            border-color: rgba(255, 255, 255, 0.35);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
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

        <!-- MAIN SECTION: LIST INSTANSI (3 Kolom Menyamping) -->
        <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-1.5 sm:py-2 flex-1 flex flex-col justify-center w-full min-h-0">
            
            @php
                $loggedOpdCode = session('user.opd_code');
                $loggedDinasName = session('user.dinas_name');
                $userRole = session('user.role');
                $isAdmin = $userRole === 'admin';

                $allOpds = [
                    ['code' => '01', 'short' => 'Dinas PUPR', 'full' => 'Dinas Pekerjaan Umum dan Penataan Ruang', 'search' => '01 dinas pupr pekerjaan umum dan penataan ruang', 'icon' => 'fa-city'],
                    ['code' => '02', 'short' => 'Dinas PMPTSP', 'full' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'search' => '02 dinas pmptsp penanaman modal dan pelayanan terpadu satu pintu', 'icon' => 'fa-file-lines'],
                    ['code' => '03', 'short' => 'DPRD Kota Bukittinggi', 'full' => 'Dewan Perwakilan Rakyat Daerah Kota Bukittinggi', 'search' => '03 dprd dewan perwakilan rakyat daerah kota bukittinggi', 'icon' => 'fa-landmark'],
                    ['code' => '04', 'short' => 'Badan Kepegawaian dan Pengembangan SDM', 'full' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia', 'search' => '04 bkpsdm badan kepegawaian dan pengembangan sumber daya manusia sdm', 'icon' => 'fa-users'],
                    ['code' => '05', 'short' => 'Badan Keuangan', 'full' => 'Badan Keuangan Kota Bukittinggi', 'search' => '05 bkd badan keuangan bpkad bkeu', 'icon' => 'fa-coins'],
                    ['code' => '06', 'short' => 'Disdukcapil', 'full' => 'Dinas Kependudukan dan Pencatatan Sipil', 'search' => '06 disdukcapil dinas kependudukan dan pencatatan sipil capil', 'icon' => 'fa-id-card'],
                    ['code' => '07', 'short' => 'Dinas Koperasi, UKM dan Tenaga Kerja', 'full' => 'Dinas Koperasi, Usaha Kecil Menengah dan Tenaga Kerja', 'search' => '07 dinas koperasi ukm dan tenaga kerja disnaker diskop', 'icon' => 'fa-handshake'],
                    ['code' => '08', 'short' => 'Dinas Pendidikan dan Kebudayaan', 'full' => 'Dinas Pendidikan dan Kebudayaan Kota Bukittinggi', 'search' => '08 dinas pendidikan dan kebudayaan disdikbud disdik', 'icon' => 'fa-book-open'],
                    ['code' => '09', 'short' => 'Badan Penanggulangan Bencana Daerah', 'full' => 'Badan Penanggulangan Bencana Daerah Kota Bukittinggi', 'search' => '09 badan penanggulangan bencana daerah bpbd', 'icon' => 'fa-shield-halved'],
                    ['code' => '10', 'short' => 'Dinas Pemuda dan Olahraga', 'full' => 'Dinas Pemuda dan Olahraga Kota Bukittinggi', 'search' => '10 dinas pemuda dan olahraga dispora', 'icon' => 'fa-person-running'],
                    ['code' => '11', 'short' => 'Dinas Perpustakaan dan Kearsipan', 'full' => 'Dinas Perpustakaan dan Kearsipan Kota Bukittinggi', 'search' => '11 dinas perpustakaan dan kearsipan dispusip', 'icon' => 'fa-book-bookmark'],
                    ['code' => '12', 'short' => 'Dinas Kesehatan', 'full' => 'Dinas Kesehatan Kota Bukittinggi', 'search' => '12 dinas kesehatan dinkes', 'icon' => 'fa-circle-plus'],
                    ['code' => '13', 'short' => 'Dinas Lingkungan Hidup', 'full' => 'Dinas Lingkungan Hidup Kota Bukittinggi', 'search' => '13 dinas lingkungan hidup dlh', 'icon' => 'fa-leaf'],
                    ['code' => '14', 'short' => 'Dinas P3APPKB', 'full' => 'Dinas Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk dan KB', 'search' => '14 dinas p3appkb pemberdayaan perempuan perlindungan anak kb', 'icon' => 'fa-people-group'],
                    ['code' => '15', 'short' => 'Dinas Kebakaran', 'full' => 'Dinas Kebakaran Kota Bukittinggi', 'search' => '15 dinas kebakaran damkar pemadam', 'icon' => 'fa-fire'],
                    ['code' => '16', 'short' => 'Dinas Sosial', 'full' => 'Dinas Sosial Kota Bukittinggi', 'search' => '16 dinas sosial dinsos', 'icon' => 'fa-hand-holding-heart'],
                    ['code' => '17', 'short' => 'Dinas Pertanian', 'full' => 'Dinas Pertanian Kota Bukittinggi', 'search' => '17 dinas pertanian distan', 'icon' => 'fa-seedling'],
                    ['code' => '18', 'short' => 'Dinas Perdagangan', 'full' => 'Dinas Perdagangan Kota Bukittinggi', 'search' => '18 dinas perdagangan perindag pasar', 'icon' => 'fa-store'],
                    ['code' => '19', 'short' => 'Dinas Pariwisata', 'full' => 'Dinas Pariwisata Kota Bukittinggi', 'search' => '19 dinas pariwisata dispar wisata', 'icon' => 'fa-location-dot'],
                    ['code' => '20', 'short' => 'Dinas Perhubungan', 'full' => 'Dinas Perhubungan Kota Bukittinggi', 'search' => '20 dinas perhubungan dishub', 'icon' => 'fa-bus'],
                ];

                $isOpdUser = !$isAdmin && (!empty($loggedOpdCode) || !empty($loggedDinasName));
                $userOpd = null;

                if ($isOpdUser) {
                    $formattedLoggedCode = !empty($loggedOpdCode) ? str_pad($loggedOpdCode, 2, '0', STR_PAD_LEFT) : null;
                    foreach ($allOpds as $item) {
                        if ($formattedLoggedCode && $item['code'] === $formattedLoggedCode) {
                            $userOpd = $item;
                            break;
                        }
                        if (!empty($loggedDinasName)) {
                            $dName = strtolower(trim($loggedDinasName));
                            if (str_contains(strtolower($item['short']), $dName) || 
                                str_contains(strtolower($item['full']), $dName) || 
                                str_contains($dName, strtolower($item['short']))) {
                                $userOpd = $item;
                                break;
                            }
                        }
                    }
                }
            @endphp

            @if($isOpdUser && $userOpd)
                <!-- Banner Notifikasi Dinas Aktif -->
                <div class="mb-2 px-3.5 py-1.5 rounded-xl bg-orange-50 border border-orange-200/90 shadow-2xs flex flex-row items-center justify-between gap-2 shrink-0">
                    <div class="flex items-center space-x-2.5 text-xs font-bold text-orange-950 truncate">
                        <div class="w-6 h-6 rounded-lg bg-[#f95a00] text-white flex items-center justify-center text-xs shrink-0 shadow-2xs">
                            <i class="fa-solid fa-building-user"></i>
                        </div>
                        <span class="truncate">Selamat Datang, <strong class="text-orange-900 underline">{{ $userOpd['code'] }}. {{ $userOpd['full'] }}</strong></span>
                    </div>
                    <span class="text-[10px] font-extrabold text-[#f95a00] bg-white border border-orange-200 px-2.5 py-0.5 rounded-full shadow-2xs shrink-0">
                        <i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Terverifikasi
                    </span>
                </div>
            @endif

            <!-- White Card Container -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3 sm:p-4 md:px-5 md:py-3.5 shadow-lg shadow-slate-200/30 w-full transition-all flex flex-col justify-between">
                
                @if($isOpdUser && $userOpd)
                    <!-- Card Header Untuk Dinas User (Tampilan Khusus 1 Dinas) -->
                    <div class="flex flex-row items-center justify-between gap-3 pb-2.5 sm:pb-3 border-b border-slate-100 shrink-0">
                        <div>
                            <div class="flex items-center space-x-2">
                                <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight">Instansi Anda</h1>
                                <span class="inline-flex items-center text-[10px] font-extrabold text-[#f95a00] bg-orange-50 border border-orange-200 px-2.5 py-0.5 rounded-full">
                                    1 Instansi Terdaftar
                                </span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Silakan klik kartu instansi dinas Anda di bawah untuk mengelola dan mengisi data tabel statistik</p>
                        </div>
                    </div>

                    <!-- TAMPILAN USER DINAS: HANYA KELUAR 1 KARTU DINAS ITU SAJA -->
                    <div class="py-8 sm:py-12 flex flex-col items-center justify-center">
                        <div class="w-full max-w-xl">
                            <button type="button"
                                    onclick="openOpdModal('{{ $userOpd['code'] }}', '{{ $userOpd['short'] }}', '{{ $userOpd['full'] }}')"
                                    class="group w-full bg-linear-to-br from-white via-orange-50/25 to-orange-100/50 hover:to-orange-100/80 border-2 border-orange-300 hover:border-[#f95a00] rounded-3xl p-5 sm:p-7 shadow-md hover:shadow-2xl transition-all duration-200 text-left cursor-pointer transform hover:-translate-y-1 relative overflow-hidden">
                                
                                <div class="absolute -top-12 -right-12 w-36 h-36 bg-orange-200/40 rounded-full blur-xl group-hover:bg-orange-300/50 transition-all pointer-events-none"></div>

                                <div class="flex items-center space-x-4 sm:space-x-5 relative z-10">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-linear-to-br from-[#f95a00] to-orange-600 text-white flex items-center justify-center text-2xl sm:text-3xl shadow-lg shadow-orange-500/25 shrink-0 group-hover:scale-105 transition-transform">
                                        <i class="fa-solid {{ $userOpd['icon'] }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="px-2.5 py-0.5 rounded-lg bg-orange-100 text-orange-950 font-black text-xs font-mono">
                                                KODE OPD: {{ $userOpd['code'] }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-extrabold text-[10.5px] inline-flex items-center">
                                                <i class="fa-solid fa-circle-check mr-1 text-[9px]"></i> Akun Terhubung
                                            </span>
                                        </div>
                                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight">
                                            {{ $userOpd['short'] }}
                                        </h2>
                                        <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1 leading-snug">
                                            {{ $userOpd['full'] }}
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
                    <!-- Card Header: Title & Search Filter (Untuk Admin BPS) -->
                    <div class="flex flex-row items-center justify-between gap-3 pb-2 sm:pb-3 border-b border-slate-100 shrink-0">
                        <div>
                            <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight">Pilih Instansi</h1>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Silakan pilih instansi untuk melihat data</p>
                        </div>

                        <!-- Search Input Box -->
                        <div class="relative w-48 sm:w-64 flex items-center">
                            <input type="text"
                                   id="instansiSearchInput"
                                   oninput="handleSearchInstansi(this.value)"
                                   placeholder="Cari instansi..."
                                   class="w-full bg-[#f8fafc] hover:bg-[#f1f5f9] focus:bg-white border border-slate-200/90 focus:border-[#f95a00] rounded-full pl-4 pr-9 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/15 transition-all">
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

                    <!-- 4-Column × 5-Row Instansi List Grid (20 OPD Mockup Style) -->
                    <div id="instansiGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 mt-2.5 sm:mt-3">
                        @foreach($allOpds as $opd)
                            <button type="button"
                                    onclick="openOpdModal('{{ $opd['code'] }}', '{{ $opd['short'] }}', '{{ $opd['full'] }}')"
                                    data-search="{{ $opd['search'] }}"
                                    class="instansi-item group w-full bg-white hover:bg-orange-50/40 border border-slate-100 hover:border-orange-300 rounded-2xl p-2.5 sm:p-3 flex items-center justify-between shadow-2xs hover:shadow-xs transition-all duration-150 text-left cursor-pointer">
                                <div class="flex items-center space-x-2.5 sm:space-x-3 min-w-0">
                                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-[#fff4eb] text-[#f95a00] flex items-center justify-center text-sm sm:text-base shrink-0 group-hover:scale-105 transition-transform">
                                        <i class="fa-solid {{ $opd['icon'] }}"></i>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 leading-tight">{{ $opd['code'] }}</span>
                                        <span class="text-xs sm:text-[12px] font-bold text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight line-clamp-2">{{ $opd['short'] }}</span>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-orange-100/70 group-hover:bg-[#f95a00] text-orange-500 group-hover:text-white flex items-center justify-center text-[9px] shrink-0 ml-1.5 transition-all group-hover:translate-x-0.5">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    <!-- Empty State When Search Result Not Found -->
                    <div id="instansiEmptyState" class="hidden py-6 text-center">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 mx-auto flex items-center justify-center text-lg mb-2 shadow-xs">
                            <i class="fa-solid fa-building-circle-xmark"></i>
                        </div>
                        <h3 class="text-xs font-bold text-slate-800">Instansi Tidak Ditemukan</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5 max-w-sm mx-auto">Tidak ada instansi yang cocok dengan kata kunci pencarian Anda.</p>
                        <button onclick="clearInstansiSearch()" class="mt-2 px-3 py-1 rounded-lg bg-orange-100 text-orange-700 font-bold text-xs hover:bg-orange-200 transition-colors">
                            Reset Pencarian
                        </button>
                    </div>
                @endif

                <!-- Card Footer Actions: Blanko PDF & Home (Centered) -->
                <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 mt-2 sm:mt-2.5 pt-2 border-t border-slate-100 shrink-0">
                    <!-- BLANKO PDF (Google Drive) -->
                    <a href="https://drive.google.com/drive/folders/1ytU-i5aTt7-94u2jiNefX8Ef0Hqr3_5E"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-lg bg-orange-50 hover:bg-orange-100 text-[#f95a00] hover:text-orange-700 font-bold text-xs border border-orange-200/80 transition-all shadow-2xs hover:shadow-xs"
                       title="Buka Folder Google Drive Blanko PDF">
                        <i class="fa-solid fa-file-pdf text-xs"></i>
                        <span>BLANKO PDF</span>
                    </a>

                    <!-- HOME -->
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-bold text-xs border border-slate-200/80 transition-all shadow-2xs hover:shadow-xs">
                        <i class="fa-solid fa-house text-xs"></i>
                        <span>HOME</span>
                    </a>
                </div>

            </div>

        </main>

        <!-- FOOTER & USER SESSION BAR DI BAGIAN BAWAH -->
        <footer class="w-full border-t border-slate-200/60 bg-white/40 backdrop-blur-sm py-1.5 px-4 sm:px-8 text-slate-600 shrink-0">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-1.5 text-xs">
                
                <!-- Info Pengguna yang Sedang Login & Tombol Logout (Transparan) -->
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-white/60 hover:bg-white/80 border border-slate-200/80 shadow-xs transition-all backdrop-blur-xs">
                    <div class="flex items-center space-x-1.5">
                        @if($isAdmin)
                            <div class="w-5 h-5 rounded-full overflow-hidden shrink-0 border border-slate-200 shadow-2xs" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px; max-width: 20px; max-height: 20px;">
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar Admin BPS" class="w-full h-full object-cover block rounded-full" style="width: 20px; height: 20px; max-width: 20px; max-height: 20px; object-fit: cover;">
                            </div>
                        @else
                            <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[9px] shadow-xs shrink-0" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;">
                                <i class="fa-solid {{ $userOpd['icon'] ?? 'fa-city' }}"></i>
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

    <!-- OPD INPUT TABEL MODAL (FULL-WIDTH TABEL VIEW) -->
    <div id="opdModal" class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-4 md:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-2xl sm:rounded-3xl max-w-4xl lg:max-w-5xl w-full p-5 sm:p-7 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative overflow-hidden" id="opdModalCard">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4 sm:mb-5">
                <!-- Left: 4-square Grid Icon + Title "Input Tabel" + OPD Name -->
                <div class="flex items-center space-x-3">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-500 shadow-2xs shrink-0">
                        <div class="grid grid-cols-2 gap-0.5 w-3.5 h-3.5">
                            <span class="bg-[#f98825] rounded-[2px]"></span>
                            <span class="bg-[#f98825] rounded-[2px]"></span>
                            <span class="bg-[#f98825] rounded-[2px]"></span>
                            <span class="bg-[#f98825] rounded-[2px]"></span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-3 flex-wrap">
                        <h2 class="text-base sm:text-lg md:text-xl font-bold text-slate-800 tracking-tight">Input Tabel</h2>
                        <span id="opdHeaderTag" class="text-xs sm:text-sm font-semibold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full border border-slate-200">
                            01. DINAS PUPR
                        </span>
                    </div>
                </div>

                <!-- Right: Close Button -->
                <button onclick="closeOpdModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer">
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

    <!-- POPUP PILIH TAHUN DATA GOOGLE SPREADSHEET (MUNCUL SAAT KLIK INPUT PADA TABEL) -->
    <div id="yearModal" class="fixed inset-0 z-60 hidden items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-md w-full p-5 sm:p-6 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative" id="yearModalCard">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-slate-100 pb-3 mb-4">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 text-[#f98825] flex items-center justify-center text-xs font-black shrink-0" id="selectedTableBadge">
                        1.1.6
                    </div>
                    <div>
                        <h3 id="selectedTableTitle" class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">
                            Nama Tabel
                        </h3>
                        <p id="selectedOpdSubtitle" class="text-[11px] text-slate-400 font-medium">01. DINAS PUPR</p>
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
                    <button onclick="submitSelectedYear('table')" class="px-4 py-2 rounded-xl bg-[#f98825] hover:bg-[#e07212] text-white text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5 cursor-pointer" title="Buka format tabel publikasi BPS">
                        <i class="fa-solid fa-table-cells text-[11px]"></i>
                        <span>Buka Data Tabel</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

        </div>
    </div>

    <!-- BLANKO PDF MODAL -->
    <div id="blankoModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100" id="blankoModalCard">
            
            <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 rounded-2xl bg-orange-100 flex items-center justify-center text-[#f95a00] text-lg font-bold shadow-xs">
                        <i class="fa-solid fa-file-pdf text-red-600"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-orange-600">Dokumen Blanko</span>
                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 leading-tight">Blanko Pengumpulan Data OPD</h3>
                    </div>
                </div>
                <button onclick="closeBlankoModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <div class="mt-4 space-y-3">
                <p class="text-xs text-slate-600 leading-relaxed">
                    Silakan unduh dokumen Blanko PDF untuk panduan dan format pengisian data sektoral OPD dalam penyusunan publikasi <strong>Bukittinggi Dalam Angka</strong>.
                </p>

                <div class="space-y-2 pt-1">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 hover:border-orange-300 transition-colors">
                        <div class="flex items-center space-x-2.5">
                            <i class="fa-solid fa-file-pdf text-red-600 text-lg"></i>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">Blanko_Format_Data_OPD_2026.pdf</h4>
                                <span class="text-[11px] text-slate-400">PDF Document • 2.4 MB</span>
                            </div>
                        </div>
                        <button onclick="alert('Mengunduh Blanko Format Data OPD PDF...')" class="p-2 text-[#f95a00] hover:bg-orange-100 rounded-lg transition-colors">
                            <i class="fa-solid fa-download"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 hover:border-orange-300 transition-colors">
                        <div class="flex items-center space-x-2.5">
                            <i class="fa-solid fa-file-excel text-emerald-600 text-lg"></i>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">Template_Kuesioner_OPD_2026.xlsx</h4>
                                <span class="text-[11px] text-slate-400">Excel Spreadsheet • 1.1 MB</span>
                            </div>
                        </div>
                        <button onclick="alert('Mengunduh Template Kuesioner OPD Excel...')" class="p-2 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-colors">
                            <i class="fa-solid fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-3 border-t border-slate-100 flex justify-end">
                <button onclick="closeBlankoModal()" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition-colors">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // Katalog Daftar Tabel Statistik Sektoral per OPD (Bukittinggi Dalam Angka)
        const opdTablesCatalog = {
            '01': [
                { code: '1.1.6', title: 'Nama Sungai/Batang, Lebar dan Kecamatan yang Dilalui di Kota Bukittinggi', titleEn: 'Name of River, Width and Subdistrict Passed Through in Bukittinggi Municipality' },
                { code: '8.1.1', title: 'Panjang Jalan Menurut Tingkat Kewenangan Pemerintah di Kota Bukittinggi', titleEn: 'Length of Roads by Level of Government Authority in Bukittinggi Municipality' },
                { code: '8.1.2', title: 'Panjang Jalan Menurut Jenis Permukaan Jalan di Kota Bukittinggi (km)', titleEn: 'Length of Roads by Type of Road Surface in Bukittinggi Municipality (km)' },
                { code: '8.1.3', title: 'Panjang Jalan Menurut Kondisi Jalan di Kota Bukittinggi (km)', titleEn: 'Length of Roads by Road Condition in Bukittinggi Municipality (km)' },
                { code: '8.1.4', title: 'Banyak dan Panjang Jembatan, Panjang Trotoar Kota Bukittinggi', titleEn: 'Number and Length of Bridge, Length of Sidewalk in Bukittinggi' },
                { code: '8.1.5', title: 'Panjang Gorong-Gorong dan Panjang Drainase di Kota Bukittinggi', titleEn: 'Length of Culverts and Length of Drainage in Bukittinggi Municipality' }
            ],
            '02': [
                { code: '1.1.10', title: 'Jumlah IMB/PBG yang Dikeluarkan Dinas Penanaman Modal PTSP Kota Bukittinggi Menurut Klasifikasinya di Kota Bukittinggi', titleEn: 'Number of Building Approvals (IMB/PBG) Issued by Investment and One-Stop Integrated Services of Bukittinggi Municipality by Classification' },
                { code: '11.2', title: 'Jumlah Nomor Induk Berusaha (NIB) yang Dikeluarkan Menurut Sektor di Kota Bukittinggi', titleEn: 'Number of Business Identification Numbers (NIB) Issued by Sector in Bukittinggi Municipality' },
                { code: '11.3', title: 'Jumlah Nomor Izin Berusaha (NIB) yang Dikeluarkan per Bulan di Kota Bukittinggiin Bukittinggi Municipality' },
                { code: '11.4', title: 'Jumlah Nomor Induk Berusaha (NIB) yang Dikeluarkan Menurut Sektor di Kota Bukittinggi', titleEn: 'Number of Business Identification Numbers (NIB) Issued by Sector in Bukittinggi Municipality' }
            ],
            '03': [
                { code: '2.2.5', title: 'Keputusan dan Hasil Rapat Kerja DPRD di Kota Bukittinggi', titleEn: 'Decrees and Results of Regional House of Representatives Working Meetings in Bukittinggi Municipality' }
            ],
            '04': [
                { code: '2.3.1', title: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Jabatan, Jenis ASN, dan Jenis Kelamin (orang)', titleEn: 'Number of State Civil Apparatus (ASN) of Bukittinggi Municipal Government by Occupation, Type of ASN, and Sex' },
                { code: '2.3.2', title: 'Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Bukittinggi Menurut Tingkat Pendidikan, Jenis ASN, dan Jenis Kelamin (orang)', titleEn: 'Number of Civil Servant of Bukittinggi Municipal Government by Educational Level, Type of ASN, and Sex (people)' },
                { code: '2.3.3', title: 'Jumlah Pegawai Negeri Sipil Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang)', titleEn: 'Number of Bukittinggi Municipality Government’s Civil Servants by Hierarchy and Sex (people)' },
                { code: '2.3.4', title: 'Jumlah Pegawai Pemerintah dengan Perjanjian Kerja Pemerintah Kota Bukittinggi Menurut Tingkat Kepangkatan dan Jenis Kelamin (orang)', titleEn: 'Number of Bukittinggi Municipal Government’s Civil servants with employment agreements  by Hierarchy and Sex (people)' },
                { code: '2.3.5', title: 'Banyak Aparatur Sipil Negara di Lingkungan Pemerintah Kota Bukittinggi Menurut Unit Kerja di Kota Bukittinggi', titleEn: 'Number of Civil Servants in Local Government of Bukittinggi Municipality' }
            ],
            '05': [
                { code: '2.4.1', title: 'Realisasi Pendapatan Pemerintah Kota Bukittinggi Menurut Jenis Pendapatan (Juta rupiah)', titleEn: 'Actual Bukittinggi Municipal Government Revenues by Kind of Revenues(thousand rupiahs)' },
                { code: '2.4.2', title: 'Realisasi Belanja Pemerintah Kota Bukittinggi Menurut Jenis Belanja (Juta rupiah)', titleEn: 'Actual Bukittinggi Municipal Government Expenditures by Kind of Expenditures (million rupiah)' },
                { code: '2.4.3', title: 'Realisasi Pembiayaan Pemerintah Daerah Kota Bukittinggi', titleEn: 'Realization of Bukittinggi Local Government Cost Budgeting' },
                { code: '2.4.4', title: 'Perkembangan Pendapatan Asli Daerah di Kota Bukittinggi', titleEn: 'Regional Real Receipt Budget in Bukittinggi' },
                { code: '2.4.5', title: 'Realisasi Pembiayaan Pemerintah Daerah Kota Bukittinggi', titleEn: 'Realization of Bukittinggi Local Government Cost Budgeting' }             
            ],
            '06': [
                { code: '3.1.1', title: 'Jumlah Penduduk, Laju Pertumbuhan Penduduk, Distribusi Persentase Penduduk, Kepadatan Penduduk, Rasio Jenis Kelamin Penduduk Menurut Kecamatan di Kota Bukittinggi ', titleEn: 'Population, Population Growth Rate, Percentage Distribution of Population, Population Density, and Population Sex Ratio by District in Bukittinggi Municipality' },
                { code: '3.1.2', title: 'Penduduk Menurut Golongan Umur dan Jenis Kelamin di Kota Bukittinggi', titleEn: 'Population by Age Group and Sex in Bukittinggi Municipality' },
                { code: '3.1.8', title: 'Jumlah Penduduk Wajib KTP (Kartu Tanda Penduduk) dan yang Telah Memiliki KTP dirinci Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Population Owner Identity Card and Be Possessed Identity Card Already by District in Bukittinggi Municipality' },
                { code: '4.3.1', title: 'Jumlah Penduduk Menurut Agama yang Dianut di Kota Bukittinggi', titleEn: 'Number of Population by Religion in Bukittinggi' },
            ],
            '07': [
                { code: '3.2.8', title: 'Jumlah Pencari Kerja yang Terdaftar Menurut Tingkat Pendidikan yang Ditamatkan di Kota Bukittinggi', titleEn: 'Number of Job Seeker Registered by Educational Attainment in Bukittinggi Municipality' },
                { code: '9.1', title: 'Jumlah Koperasi Aktif Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Active Cooperative in Bukittinggi Municipality' },
                { code: '9.2', title: 'Jumlah Koperasi Menurut Jenis Koperasi dan Kecamatan di Kota Bukittinggi', titleEn: 'Number of Cooperative by Kind of Cooperative and Subdistrict in Bukittinggi Municipality' },
                { code: '9.3', title: 'Perkembangan Koperasi Dirinci Menurut Anggota, Simpanan dan Volume Usaha di Kota Bukittinggi', titleEn: 'Growth of Cooperative by Member, Deposite and Omset in Bukittinggi' },
                { code: '9.4', title: 'Jumlah Koperasi Menurut Jenisnya per Kecamatan di Kota Bukittinggi', titleEn: 'Number of Cooperation by Kind in District in Bukittinggi' },
            ],
            '08': [
                { code: '4.1.1', title: 'Jumlah Sekolah, Guru, dan Murid Taman Kanak–Kanak (TK) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Kindergarten Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
                { code: '4.1.3', title: 'Jumlah Sekolah, Guru, dan Murid Sekolah Dasar (SD) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Primary Schools Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
                { code: '4.1.5', title: 'Jumlah Sekolah, Guru, dan Murid Sekolah Menengah Pertama (SMP) di Bawah Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Junior High Schools Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
                { code: '4.1.15', title: 'Jumlah Sekolah, Guru, dan Murid Kelompok Bermain (KB) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Playgroup Under The Ministry of Education, Culture, Research, and Technology by Subistrict in Bukittinggi Municipality' },
                { code: '4.1.16', title: 'Jumlah Sekolah, Guru, dan Murid Taman Penitipan Anak (TPA) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Day Care Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
                { code: '4.1.17', title: 'Jumlah Sekolah, Guru, dan Murid Satuan PAUD Sejenis (SPS) di Bawah Kementerian Pendidikan dan Kebudayaan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils in Satuan PAUD Sejenis (SPS) Under The Ministry of Education, Culture, Research, and Technology by District in Bukittinggi Municipality' },
            ],
            '09': [
                { code: '4.3.4', title: 'Jumlah Kejadian Bencana Alam di Kota Bukittinggi Menurut Kecamatan', titleEn: 'Number of Natural Disasters in Bukittinggi Municipality by District' }
            ],
            '10': [
                { code: '4.1.20', title: 'Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi', titleEn: 'Number of Sport Club in Bukittinggi' }
            ],
            '11': [
                { code: '4.1.24', title: 'Jumlah Lembaga Perpustakaan, Koleksi, dan Pengunjung Perpustakaan di Kota Bukittinggi', titleEn: 'Number of Library Institutions, Collections, and Library Visitors in the City of Bukittinggi' }
            ],
            '12': [
                { code: '4.2.2', title: 'Jumlah Tenaga Kesehatan Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Health Human Resources by District in Bukittinggi Municipality' },
                { code: '4.2.3', title: 'Jumlah Rumah Sakit Umum, Rumah Sakit Khusus, dan Puskesmas Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of General Hospital, Specialized Hospital, dan Public Health Center by District in Bukittinggi' },
                { code: '4.2.4', title: 'Jumlah Tempat Tidur Pada Rumah Sakit Pemerintah dan Swasta di Kota Bukittinggi', titleEn: 'Number of Beds at Government and Private Hospital in Bukittinggi' },
                { code: '4.2.5', title: 'Jumlah Pengunjung Pada Rumah Sakit Pemerintah dan Swasta di Kota Bukittinggi', titleEn: 'Number of Visitor at Hospital Government and Private in Bukittinggi' },
                { code: '4.2.6', title: 'Jumlah Kasus Penyakit Terbanyak di Kota Bukittinggi', titleEn: 'Number of Most Desease Case in Bukittinggi' },
                { code: '4.2.7', title: 'Banyak Lahir Hidup, lahir Mati, dan Kematian Ibu Sewaktu Melahirkan di Kota Bukittinggi', titleEn: 'Number of Abortion and Maternal Deaths at Child Birth in Bukittinggi' },
                { code: '4.2.9', title: 'Jumlah Dokter Praktek Menurut Keahlian di Kota Bukittinggi', titleEn: 'Number of Physicians by Profession in Bukittinggi' },
                { code: '4.2.10', title: 'Jumlah Kunjungan dan Rata–rata Kunjungan per Hari pada Puskesmas Kota Bukittinggi di Kota Bukittinggi', titleEn: 'Number of Attendence and Average Daily Attendence to puskesmas in Bukittinggi Municipality in Bukittinggi' }
            ],
            '13': [
                { code: '4.2.12', title: 'Perkiraan Rata–rata Timbunan Sampah dan Volume Sampah yang Terangkut per Hari Setiap Bulan di Kota Bukittinggi', titleEn: 'Number of Rubbish Heap and Volume of Rubbish Carry Out by Day Every Month in Bukittinggi' },
                { code: '4.2.13', title: 'Persentase Komposisi Sampah di Kota Bukittinggi', titleEn: 'Number of Rubish Composition in Bukittinggi' },
                { code: '4.2.14', title: 'Rata–rata Timbunan Sampah yang Terangkut menurut Sumbernya di Kota Bukittinggi', titleEn: 'Rubbish Which is Carried by Source of Rubbish in Bukittinggi' },
                { code: '4.2.15', title: 'Jumlah Personil dan Sarana Kebersihan dan Pertamanan di Kota Bukittinggi', titleEn: 'Number of Personal, Tools and Equipment Cleanners in Bukittinggi' },              
                { code: '4.2.16', title: 'Jumlah Timbunan dan Volume Sampah yang Diangkut di Kota Bukittinggi', titleEn: 'Rubbish Which is Carried by Source of Rubbish in Bukittinggi' }
            ],
            '14': [
                { code: '4.2.17', title: 'Jumlah Akseptor Aktif Keluarga Berencana Menurut Alat Kontrasepsi di Kota Bukittinggi', titleEn: 'Number of Family Planning Acceptors by Contraception in Bukittinggi' },
                { code: '4.2.18', title: 'Jumlah PPKBD, Kelompok UPPKS, PLKB dan CU Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of PPKBD, UPPKS Society, PLKB and CU by District in Bukittinggi' },
                { code: '4.2.19', title: 'Jumlah Klinik dan Tenaga Medis Keluarga Berencana di Kota Bukittinggi', titleEn: 'Number of Clinics and Medical Personal of Family Planning in Bukittinggi' },
                { code: '4.2.20', title: 'Target dan Realisasi Keluarga Berencana di Kota Bukittinggi', titleEn: 'Target and Realization of Family Planning in Bukittinggi' }
            ],
            '15': [
                { code: '4.3.5', title: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menuru Bulan', titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Month' },
                { code: '4.3.6', title: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Tempat Kejadian', titleEn: 'Number of Fire Incident in Bukittinggi Municipality by incident Scene' },
                { code: '4.3.7', title: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Penyebab Kebakaran', titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Fire Cause' },
                { code: '4.3.8', title: 'Jumlah Kejadian Kebakaran di Kota Bukittinggi Menurut Nilai Kerugian Akibat Kebakaran', titleEn: 'Number of Fire Incident in Bukittinggi Municipality by Value of Losses Due to Fire' }
            ],
            '16': [
                { code: '4.3.13', title: 'Jumlah Pekerja Sosial Masyarakat, Karang Taruna, Tenaga Kerja Sosial dan Organisasi Sosial di Kota Bukittinggi', titleEn: 'Number of Public Social Officers, Youth Club, Social Workers and Social Organization in Bukittinggi' },
                { code: '4.3.14', title: 'Jumlah Penyandang Disabilitas, Anak Terlantar dan Lanjut Usia Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Disable People, Homeless Child, and Old Age Person by District in Bukittinggi' },   
                { code: '4.3.15', title: 'Jumlah Orang terlantar, Bekas Narapidana, Penyandang Disabilitas dan Penghuni Panti Asuhan yang Dibantu di Kota Bukittinggi', titleEn: 'Number of Homeless People, Ex Prisoner, Disable People, Refective Person in Bukittinggi' }
            ],
            '17': [
                { code: '5.1.15', title: 'Luas Areal Sawah Menurut jenis Pengairan per Kecamatan di Kota Bukittinggi', titleEn: 'Plantation Area by Type of irigation by District in Bukittinggi' },
                { code: '5.1.16', title: 'Target dan realisasi Intensifikasi Palawija per Kecamatan di Kota Bukittinggi', titleEn: 'Target and Realization of Intensification Food Crops by District in Bukittinggi' },
                { code: '5.1.17', title: 'Target dan realisasi Intensifikasi Sayur–Sayuran per Kecamatan di Kota Bukittinggi', titleEn: 'Target and Realization of Intensification vegetables by District in Bukittinggi' },
                { code: '5.1.18', title: 'Realisasi Pupuk di Kota Bukittinggi', titleEn: 'Realization of Fertilizer in Bukittinggi' },
                { code: '5.1.19', title: 'Jumlah Pengadaan Peralatan Pemberantasan Hama Penyakit Tanaman Menurut Jenisnya per Kecamatan di Kota Bukittinggi', titleEn: 'Number of Pest Control Machinery Procurement by District in Bukittinggi' },
                { code: '5.2.1', title: 'Luas Areal Tanaman Perkebunan Menurut Kecamatan dan Jenis Tanaman di Kota Bukittinggi (ha)', titleEn: 'Planted Area of Estate Crops by District and Types of Crops in Bukittinggi Municipality (ha)' },
                { code: '5.2.2', title: 'Produksi Perkebunan Menurut Kecamatan dan Jenis Tanaman di Kota Bukittinggi (Ribu ton)', titleEn: 'Production of Estate Crops by District and Types of Crops in Bukittinggi Municipality (Thousands ton)' },
                { code: '5.2.3', title: 'Luas Areal Tanaman Perkebunan Rakyat Menurut Jenis Tanaman di Kota Bukittinggi (ha)', titleEn: 'Area of Smallholder by Types of Crops in Bukittinggi Municipality (ha)' },
                { code: '5.2.4', title: 'Produksi Tanaman Perkebunan Rakyat Menurut Jenis Tanaman di Kota Bukittinggi (ton)', titleEn: 'Production of Smallholder by Types of Crops in Bukittinggi Municipality (ton)' },
                { code: '5.3.1', title: 'Jumlah Ternak dan Unggas Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Livestock and Poultry by District in Bukittinggi' },
                { code: '5.3.2', title: 'Jumlah Pemotongan Ternak Menurut Jenis Ternak di Kota Bukittinggi', titleEn: 'Number of Registered Slughtered Livestock by District in Bukittinggi' },
                { code: '5.3.3', title: 'Jumlah Produksi Daging Menurut Jenis Ternak di Kota Bukittinggi (Ton)', titleEn: 'Number Production of Livestock by Kind (Ton) in Bukittinggi' },
                { code: '5.3.4', title: 'Jumlah Produksi Daging Unggas di Kota Bukittinggi (Ton)', titleEn: 'Number Production of Poultry (Ton) in Bukittinggi' },
                { code: '5.3.5', title: 'Jumlah Vaksinasi Ternak di Kota Bukittinggi', titleEn: 'Number of Cattle Vaccination in Bukittinggi' },
                { code: '5.3.6', title: 'Produksi Susu Sapi di Kota Bukittinggi (Liter)', titleEn: 'Production of Cow Milk (litre) in Bukittinggi' },
                { code: '5.3.7', title: 'Jumlah Produksi Telur Menurut Kecamatan di Kota Bukittinggi (Kg)', titleEn: 'Production of poultry Egg by District (Kg) in Bukittinggi Municipality' },
                { code: '5.4.1', title: 'Jumlah Ikan yang Diperdagangkan Menurut Kecamatan di Kota Bukittinggi (Ton)', titleEn: 'Number of Fish Trading by District (Ton) in Bukittinggi Municipality' },
                { code: '5.4.2', title: 'Jumlah Petani Ikan Darat Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Number of Fresh Water Fish Farmers by District in Bukittinggi Municipality' },
                { code: '5.4.3', title: 'Luas Areal Pemeliharaan Ikan Darat per Kecamatan di Kota Bukittinggi (Ha)', titleEn: 'Fresh Water Fishery Area by District (Ha) in Bukittinggi Municipality' },
                { code: '5.4.4', title: 'Produksi Ikan Darat per Kecamatan di Kota Bukittinggi (Ha)', titleEn: 'Production of Fresh Water Fish (Ton) in Bukittinggi Municipality' },
                { code: '9.11', title: 'Harga Komoditi Perkebunan di Pasar Bukittinggi', titleEn: 'Market Prices in Bukittinggi' }
            ],
            '18': [
                { code: '6.5', title: 'Jumlah Perusahaan dan Tenaga Kerja yang Terdaftar pada Industri Kecil Makanan dan Minuman di Kota Bukittinggi', titleEn: 'Number of Companies and Man Power at Small Scale Industrial of Food and Beverages in Bukittinggi' },
                { code: '6.6', title: 'Jumlah Perusahaan dan tenaga Kerja yang Terdaftar pada Industri Kecil Sandang dan Kulit di Kota Bukittinggi', titleEn: 'Number of Companies and Man Power at Small Scale Industrial of Food and Beverages in Bukittinggi' },
                { code: '6.7', title: 'Jumlah Perusahaan dan tenaga Kerja yang Terdaftar pada Industri Kecil Lainnya di Kota Bukittinggi', titleEn: 'Number of Companies and Man Power at Small Scale Industrial of Other in Bukittinggi' },
                { code: '6.8', title: 'Jumlah Perusahaan dan tenaga Kerja yang Terdaftar pada Industri Kecil Lainnya di Kota Bukittinggi', titleEn: 'Number of Companies and Man Power at Small Scale Industrial of Metals, Chemical Products and Other Crafts in Bukittinggi' },
                { code: '11.1', title: 'Jumlah Sarana Perdagangan Menurut Jenisnya di Kota Bukittinggi', titleEn: 'Number of Trading Facilities by Type of Facility in Bukittinggi Municipality' }
            ],
            '19': [
                { code: '7.1', title: 'Jumlah Rumah Makan, Restoran dan Cafe di Kota Bukittinggi', titleEn: 'Number of Restaurants and Cafe in Bukittinggi Municipality' },
                { code: '7.3', title: 'Jumlah Pengunjung & Hasil Penjualan Karcis Taman Margasatwa dan Budaya Kinantan di Kota Bukittinggi', titleEn: 'Number of Visitor and Result of Ticket Sold of Taman Margasatwa dan Budaya Kinantan in Bukittinggi' },
                { code: '7.4', title: 'Jumlah Pengunjung & Hasil Penjualan Karcis Taman Panorama Lobang Jepang di Kota Bukittinggi', titleEn: 'Number of Visitor and Result of Ticket Sold of Taman Panorama Lobang Jepang in Bukittinggi' },
                { code: '7.5', title: 'Jumlah Wisatawan Asing Berkunjung ke Bukittinggi Menurut Kebangsaan di Kota Bukittinggi', titleEn: 'Number of Foreign Tourist Visiting to Bukittinggi by Nationality in Bukittinggi' }
            ],
            '20': [
                { code: '8.1.6', title: 'Jumlah Mobil Penumpang Menurut Jenisnya di Kota Bukittinggi', titleEn: 'Number of Passenger’s Car by Kind of Vehicles in Bukittinggi' },
                { code: '8.1.7', title: 'Jumlah Kendaraan Wajib Uji Dalam Daerah Kota Bukittinggi', titleEn: 'Number of Vehicles Compulsory Test in Bukittinggi Municipality' },
                { code: '8.1.8', title: 'Jumlah Kendaraan Tidak Bermotor di Kota Bukittinggi', titleEn: 'Number of Non Engine Vehicles in Bukittinggi' },
                { code: '8.1.9', title: 'Jumlah Terminal/Pangkalan, Luas dan Daya Tampung Terminal di Kota Bukittinggi', titleEn: 'Number of Terminal, Wide and Capacity in Bukittinggi' }
            ]
        };

        let currentOpdCode = '01';
        let currentOpdShort = 'DINAS PUPR';
        let currentOpdFull = 'Dinas Pekerjaan Umum dan Penataan Ruang';
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

        function openOpdModal(code, shortTitle, fullTitle) {
            currentOpdCode = code;
            currentOpdShort = shortTitle;
            currentOpdFull = fullTitle;
            currentPage = 1;

            // Update Header Information
            document.getElementById('opdHeaderTag').innerText = `${code}. ${shortTitle}`;
            document.getElementById('tabelWajibHeading').innerText = `1. Tabel Wajib`;

            // Load tables for this OPD
            currentTablesList = opdTablesCatalog[code] || [
                { code: '1.1.1', title: `Tabel Statistik Sektoral Utama - ${shortTitle}`, titleEn: `Main Sectoral Statistics Table - ${shortTitle}` },
                { code: '2.1.1', title: `Capaian Program dan Indikator Kinerja ${shortTitle}`, titleEn: `Program Achievements and Performance Indicators of ${shortTitle}` },
                { code: '3.1.1', title: `Rekapitulasi Layanan dan Pengelolaan Data ${shortTitle}`, titleEn: `Service Recapitulation and Data Management of ${shortTitle}` }
            ];
            filteredTablesList = [...currentTablesList];

            // Reset Search Input
            document.getElementById('tabelSearchInput').value = '';

            // Render Table Rows
            renderTableRows();

            // Show Modal
            const modal = document.getElementById('opdModal');
            const card = document.getElementById('opdModalCard');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
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
            document.getElementById('selectedOpdSubtitle').innerText = `${currentOpdCode}. ${currentOpdShort}`;

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

            // Arahkan ke halaman detail tabel data (format Tabel 1.1.1 / 1.1.6 Tahun 2025/2026)
            let targetUrl = "{{ url('/tabel-opd') }}?opd=" + encodeURIComponent(currentOpdCode) + 
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

        function closeOpdModal() {
            const modal = document.getElementById('opdModal');
            const card = document.getElementById('opdModalCard');

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 250);
        }

        function openBlankoModal() {
            const modal = document.getElementById('blankoModal');
            const card = document.getElementById('blankoModalCard');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeBlankoModal() {
            const modal = document.getElementById('blankoModal');
            const card = document.getElementById('blankoModalCard');

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 250);
        }

        // Close on Escape or overlay click
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeYearModal();
                closeOpdModal();
                closeBlankoModal();
            }
        });

        document.getElementById('opdModal').addEventListener('click', (e) => {
            if (e.target.id === 'opdModal') closeOpdModal();
        });

        document.getElementById('yearModal').addEventListener('click', (e) => {
            if (e.target.id === 'yearModal') closeYearModal();
        });

        document.getElementById('blankoModal').addEventListener('click', (e) => {
            if (e.target.id === 'blankoModal') closeBlankoModal();
        });

        // Highlight User's Own OPD
        @if($isOpdUser)
            document.addEventListener('DOMContentLoaded', () => {
                const userOpdCode = "{{ $loggedOpdCode }}";
                if (userOpdCode) {
                    const buttons = document.querySelectorAll('.btn-opd');
                    buttons.forEach(btn => {
                        const text = btn.innerText.trim();
                        if (text.startsWith(userOpdCode + '.')) {
                            btn.classList.add('ring-4', 'ring-[#f95a00]', 'ring-offset-2', 'scale-[1.02]', 'shadow-xl', 'bg-[#ea5200]');
                            const badge = document.createElement('span');
                            badge.className = 'text-[9.5px] font-black bg-white text-orange-600 px-2 py-0.5 rounded-full mt-1.5 block shadow-xs tracking-wider';
                            badge.innerText = 'DINAS ANDA';
                            btn.appendChild(badge);
                        }
                    });
                }
            });
        @endif
    </script>
</body>
</html>
