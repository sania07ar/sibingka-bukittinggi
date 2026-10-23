<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiAngka Kota Bukittinggi - BPS Kota Bukittinggi</title>
    
    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..900;1,14..32,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f4f9;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Ambient Glow Spheres (Exact Match to Login Page) */
        .ambient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            opacity: 0.4;
            transition: all 0.5s ease;
        }

        /* Shimmer on Primary Buttons */
        .btn-orange-glow {
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
        }
        .btn-orange-glow::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 40%;
            height: 200%;
            background: linear-gradient(60deg, rgba(255, 255, 255, 0) 20%, rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0) 80%);
            transform: rotate(25deg);
            transition: all 0.6s ease;
        }
        .btn-orange-glow:hover::after {
            left: 130%;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
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
<body class="min-h-screen text-slate-800 flex flex-col selection:bg-orange-500 selection:text-white bg-[#f1f4f9] relative overflow-x-hidden">

    @php
        $currentUser = session('user', []);
        $role = $currentUser['role'] ?? 'opd';
        $isAdmin = $role === 'admin';
        $allowedPages = $currentUser['allowed_pages'] ?? [];
        $dinasName = $currentUser['dinas_name'] ?? ($currentUser['displayName'] ?? 'Dinas');
        $username = $currentUser['username'] ?? 'User';
        $opdCode = $currentUser['opd_code'] ?? '01';

        // Data Statistik Riil dari Database SiMonDa
        $totalOpd = 20;
        $totalInstansi = 37;

        // Hitung tabel dan data indikator yang sudah tersimpan di database
        $savedTableCount = \App\Models\TabelMetadata::where('is_saved', 1)->distinct()->pluck('table_code')->count();
        $realDataCount = \App\Models\TabelData::where('value', '!=', '-')->where('value', '!=', '')->count();

        // Hitung persentase kelengkapan data riil
        // OPD aktif (Dinas PUPR / OPD 01) memiliki 6 tabel wajib dan seluruhnya (6 tabel) telah diinput data riilnya
        $percentComplete = 100;
        if (!$isAdmin && $role === 'opd') {
            $opdCatalogTotal = 6;
            $percentComplete = $opdCatalogTotal > 0 ? min(100, round(($savedTableCount / $opdCatalogTotal) * 100)) : 100;
        }

        // SVG circumference calculations for donut chart (r = 16 => circumference = 2 * pi * 16 = 100.53)
        $circumference = 100.53;
        $strokeDashoffset = $circumference - ($percentComplete / 100 * $circumference);
    @endphp

    <!-- Flash Alert Notification if Access Denied -->
    @if(session('error'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 max-w-lg w-full px-4 animate-in fade-in duration-300">
            <div class="p-3 rounded-2xl text-xs font-bold flex items-center justify-between bg-red-600 text-white shadow-2xl shadow-red-900/30 border border-red-500">
                <span class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-sm"></i>
                    <span>{{ session('error') }}</span>
                </span>
                <button onclick="this.parentElement.parentElement.remove()" class="p-1 hover:opacity-75">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 max-w-lg w-full px-4 animate-in fade-in duration-300">
            <div class="p-3 rounded-2xl text-xs font-bold flex items-center justify-between bg-emerald-600 text-white shadow-2xl shadow-emerald-900/30 border border-emerald-500">
                <span class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                    <span>{{ session('success') }}</span>
                </span>
                <button onclick="this.parentElement.parentElement.remove()" class="p-1 hover:opacity-75">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Ambient Lighting Atmosphere (Exact Match to Login Page) -->
    <div class="ambient-sphere w-96 h-96 bg-orange-200/40 top-[-60px] right-[-40px] fixed z-0"></div>
    <div class="ambient-sphere w-80 h-80 bg-blue-100/50 bottom-[-40px] left-[-40px] fixed z-0"></div>

    <!-- Background Sensus Ekonomi Ribbon Watermark (Exact Match to Login Page) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-15 select-none">
        <img src="{{ asset('images/sensus-ribbon-watermark.png') }}" alt="Sensus Ekonomi Watermark" class="w-[750px] lg:w-[950px] max-w-none transform -translate-x-10 object-contain">
    </div>

    <!-- ======================================================== -->
    <!-- 1. TOP NAVBAR / HEADER                                   -->
    <!-- ======================================================== -->
    <header class="w-full bg-[#f0f2f5]/90 backdrop-blur-md border-b border-slate-200/70 shadow-xs sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Left: Logo & Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0 no-underline">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-9 sm:h-10 w-auto object-contain transition-transform group-hover:scale-105">
                <div class="flex flex-col justify-center leading-tight">
                    <span class="text-xs sm:text-sm font-black text-slate-900 tracking-tight uppercase font-sans">
                        BADAN PUSAT STATISTIK
                    </span>
                    <span class="text-[10px] sm:text-[11px] font-semibold italic text-slate-600 tracking-wide uppercase font-sans">
                        KOTA BUKITTINGGI
                    </span>
                </div>
            </a>

            <!-- Center: Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold" id="topNavbar">
                <a href="#beranda-section" 
                   data-nav="beranda"
                   onclick="selectNavTab('beranda', event)"
                   class="nav-tab text-[#f95a00] border-b-2 border-[#f95a00] pb-1 transition-all cursor-pointer">
                    Beranda
                </a>
                <a href="#akses-data-section" 
                   data-nav="data"
                   onclick="selectNavTab('data', event)"
                   class="nav-tab text-slate-600 hover:text-[#f95a00] border-b-2 border-transparent pb-1 transition-all cursor-pointer">
                    Data
                </a>
                <a href="#monitoring-section" 
                   data-nav="monitoring"
                   onclick="selectNavTab('monitoring', event)"
                   class="nav-tab text-slate-600 hover:text-[#f95a00] border-b-2 border-transparent pb-1 transition-all cursor-pointer">
                    Monitoring
                </a>
                <a href="#tentang-section" 
                   data-nav="tentang"
                   onclick="selectNavTab('tentang', event)"
                   class="nav-tab text-slate-600 hover:text-[#f95a00] border-b-2 border-transparent pb-1 transition-all cursor-pointer">
                    Tentang
                </a>
            </nav>

            <!-- Right: Actions & Official Badges -->
            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                
                <!-- Sensus Ekonomi 2026 Logo -->
                <div class="hidden sm:flex items-center">
                    <img src="{{ asset('images/sensus-ekonomi-clean.png') }}" alt="Sensus Ekonomi 2026" class="h-8 sm:h-9 w-auto object-contain">
                </div>

                <!-- BerAKHLAK Logo -->
                <div class="hidden md:flex items-center">
                    <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-8 sm:h-9 w-auto object-contain">
                </div>

                <!-- Divider -->
                <div class="hidden sm:block h-7 w-[1px] bg-slate-200"></div>



                <!-- User Account Profile & Logout at Far Right Edge -->
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-800 text-xs shadow-xs">
                        @if($isAdmin)
                            <div class="w-6 h-6 rounded-full overflow-hidden shrink-0 border border-slate-200 shadow-2xs" style="width: 24px; height: 24px; min-width: 24px; min-height: 24px; max-width: 24px; max-height: 24px;">
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar Admin BPS" class="w-full h-full object-cover block rounded-full" style="width: 24px; height: 24px; max-width: 24px; max-height: 24px; object-fit: cover;">
                            </div>
                        @else
                            <div class="w-6 h-6 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[10px] shadow-sm shrink-0">
                                <i class="fa-solid {{ ($opdCode === '01' || stripos($dinasName, 'PUPR') !== false) ? 'fa-city' : 'fa-building' }} text-[10px]"></i>
                            </div>
                        @endif
                        <div class="flex flex-col text-left">
                            <span class="font-bold text-slate-900 leading-tight truncate max-w-[130px] sm:max-w-xs">{{ $dinasName }}</span>
                            <span class="text-[9.5px] font-semibold text-slate-500">
                                @if($isAdmin)
                                    Administrator BPS
                                @else
                                    Akun Dinas/Instansi
                                @endif
                            </span>
                        </div>
                    </div>

                    @if($isAdmin)
                        <a href="{{ route('portal') }}" 
                           title="Pilihan Portal"
                           class="w-8 h-8 rounded-xl bg-orange-50 hover:bg-orange-500 text-orange-600 hover:text-white border border-orange-200 hover:border-orange-500 flex items-center justify-center text-xs transition-colors"
                           id="btn-portal">
                            <i class="fa-solid fa-table-cells-large"></i>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari SiAngka Kota Bukittinggi?');">
                        @csrf
                        <button type="submit" 
                                class="w-8 h-8 rounded-xl bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 flex items-center justify-center text-xs transition-colors cursor-pointer"
                                title="Keluar dari akun">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    <!-- ======================================================== -->
    <!-- 2. HERO SECTION & FLOATING METRICS                       -->
    <!-- ======================================================== -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-4 flex-1 w-full">
        
        <!-- Hero Panoramic Banner -->
        <div id="beranda-section" class="scroll-mt-24 relative w-full rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm bg-white min-h-[380px] sm:min-h-[420px] lg:min-h-[440px] flex items-center">
            
            <!-- Right side FGD Bukittinggi Exact Image & Mask -->
            <div class="absolute inset-y-0 right-0 w-full sm:w-1/2 lg:w-[46%] xl:w-2/5 overflow-hidden pointer-events-none">
                <img src="{{ asset('images/fgd-bukittinggi-exact.png') }}" alt="FGD Bukittinggi dalam Angka" class="w-full h-full object-cover object-center">
                <!-- Gradasi halus hanya di pinggir kiri foto agar foto tetap tajam & jelas -->
                <div class="absolute inset-y-0 left-0 w-14 sm:w-20 bg-gradient-to-r from-white to-transparent"></div>
            </div>

            <!-- Left side Orange Curve Accent Waves -->
            <div class="absolute inset-y-0 left-0 w-1/2 pointer-events-none opacity-85">
                <svg class="w-full h-full text-orange-400/20" viewBox="0 0 400 400" fill="none" preserveAspectRatio="none">
                    <path d="M-50,150 C100,80 150,280 350,200" stroke="currentColor" stroke-width="2.5" />
                    <path d="M-50,180 C120,110 180,310 380,230" stroke="currentColor" stroke-width="2" />
                    <path d="M-50,210 C140,140 210,340 410,260" stroke="currentColor" stroke-width="1.5" />
                </svg>
            </div>

            <!-- Content Area (Left aligned) -->
            <div class="relative z-10 max-w-xl lg:max-w-2xl px-6 sm:px-10 lg:px-14 py-8">
                
                <!-- Greeting (Warm friendly orange accent) -->
                <p class="text-xs sm:text-sm font-bold text-[#ea580c] tracking-wide mb-2.5">
                    Selamat Datang, <span class="text-[#f95a00] font-extrabold">{{ !$isAdmin ? $dinasName : ($currentUser['displayName'] ?? 'Administrator BPS') }}</span>
                </p>

                <!-- Main Title: SiAngka Digital Application Style -->
                <div class="space-y-1 mb-2">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-800 tracking-tight leading-none flex flex-wrap items-baseline gap-x-3 gap-y-1">
                        <span class="text-slate-900 font-bold">SiAngka</span>
                        <span class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#f95a00] font-sans tracking-tight">Kota Bukittinggi</span>
                    </h1>
                </div>

                <!-- Formal Subtitle -->
                <p class="text-sm sm:text-base lg:text-lg font-bold text-slate-700 mt-2 tracking-normal leading-snug">
                    Sistem Informasi Data Daerah dalam Angka Bukittinggi
                </p>

                <!-- Concise Description -->
                <p class="text-xs sm:text-sm text-slate-700 font-medium mt-2.5 leading-relaxed max-w-md lg:max-w-lg">
                    Satu sistem informasi untuk pengelolaan, pemantauan, dan penyajian data statistik sektor pembangunan Kota Bukittinggi secara terintegrasi.
                </p>

                <!-- CTA Button -->
                <div class="mt-6 sm:mt-7 flex items-center gap-3">
                    <a href="#monitoring-section" 
                       class="btn-orange-glow inline-flex items-center gap-2.5 bg-[#f95a00] hover:bg-[#ea580c] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 no-underline">
                        <span>Mulai Monitoring</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- 3. FLOATING STATISTICS / METRICS BAR                     -->
        <!-- Khusus tampil untuk Administrator BPS, disembunyikan untuk Akun User / Dinas -->
        <!-- ======================================================== -->
        @if($isAdmin)
        <div class="relative z-20 -mt-10 sm:-mt-12 max-w-4xl mx-auto px-2 sm:px-4">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/70 p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-2 divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
                
                <!-- Stat 1: 20 OPD -->
                <div class="flex items-center gap-3.5 px-2 sm:px-4 py-2">
                    <div class="w-12 h-12 rounded-full bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 leading-none">{{ $totalOpd }}</div>
                        <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wide mt-1">OPD</div>
                    </div>
                </div>

                <!-- Stat 2: 37 INSTANSI VERTIKAL -->
                <div class="flex items-center gap-3.5 px-2 sm:px-4 py-2 pt-3 sm:pt-2">
                    <div class="w-12 h-12 rounded-full bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-solid fa-landmark"></i>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 leading-none">{{ $totalInstansi }}</div>
                        <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wide mt-1">INSTANSI VERTIKAL</div>
                    </div>
                </div>

                <!-- Stat 3: DATA INDIKATOR (Riil dari Database) -->
                <div class="flex items-center gap-3.5 px-2 sm:px-4 py-2 pt-3 sm:pt-2">
                    <div class="w-12 h-12 rounded-full bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 leading-none">{{ $realDataCount }}</div>
                        <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wide mt-1">DATA INDIKATOR</div>
                        <div class="text-[9.5px] font-semibold text-emerald-600">({{ $savedTableCount }} Tabel Terisi)</div>
                    </div>
                </div>

            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-5 relative z-20 {{ $isAdmin ? 'mt-6' : '-mt-5 sm:-mt-8 lg:-mt-10' }}">
            
            <!-- LEFT CARD: AKSES DATA -->
            <div id="akses-data-section" class="scroll-mt-24 transition-all duration-300 bg-white rounded-3xl border border-slate-200/70 p-5 sm:p-6 shadow-sm hover:shadow-md">
                
                <!-- Section Header -->
                <div class="flex items-start gap-3.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-base shadow-xs">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Akses Data</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola dan lihat data statistik berdasarkan sumber data</p>
                    </div>
                </div>

                <!-- 3 Sub-Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    
                    <!-- 1. Data OPD -->
                    @if($isAdmin || in_array('isi-data-opd', $allowedPages))
                        <a href="{{ route('isi-data-opd') }}" 
                           class="group bg-gradient-to-br from-orange-50/70 to-orange-50/30 border border-orange-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-orange-300 hover:shadow-md transition-all no-underline"
                           id="btn-isi-opd">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-orange-500 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-orange-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                    Data OPD
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                    Isi dan kelola data OPD
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1">
                                <span class="w-6 h-6 rounded-full border border-orange-300 text-orange-500 flex items-center justify-center text-[10px] group-hover:bg-orange-500 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @else
                        <button type="button" 
                                onclick="alert('Akses Dibatasi: Akun {{ $dinasName }} tidak memiliki hak akses untuk halaman Isi Data OPD. Silakan hubungi Administrator BPS.');"
                                class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between opacity-50 cursor-not-allowed text-left">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-slate-400 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <h3 class="font-bold text-slate-700 text-xs sm:text-[13px] leading-snug min-h-[2rem] flex items-center">
                                    Data OPD
                                </h3>
                                <p class="text-[11px] text-slate-400 mt-1 leading-snug min-h-[1.75rem]">
                                    Akses belum dibuka
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1 text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                        </button>
                    @endif

                    <!-- 2. Data Instansi Vertikal dan Lainnya -->
                    @if($isAdmin || in_array('isi-data-instansi', $allowedPages))
                        <a href="{{ route('isi-data-instansi') }}" 
                           class="group bg-gradient-to-br from-sky-50/60 to-blue-50/30 border border-sky-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-sky-300 hover:shadow-md transition-all no-underline"
                           id="btn-isi-vertikal">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-sky-600 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-landmark"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-sky-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                    Instansi Vertikal & Lainnya
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                    Isi dan kelola data instansi
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1">
                                <span class="w-6 h-6 rounded-full border border-sky-300 text-sky-600 flex items-center justify-center text-[10px] group-hover:bg-sky-600 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @else
                        <button type="button" 
                                onclick="alert('Akses Dibatasi: Akun {{ $dinasName }} tidak memiliki hak akses untuk halaman Isi Data Instansi Vertikal.');"
                                class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between opacity-50 cursor-not-allowed text-left">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-slate-400 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-landmark"></i>
                                </div>
                                <h3 class="font-bold text-slate-700 text-xs sm:text-[13px] leading-snug min-h-[2rem] flex items-center">
                                    Instansi Vertikal & Lainnya
                                </h3>
                                <p class="text-[11px] text-slate-400 mt-1 leading-snug min-h-[1.75rem]">
                                    Akses belum dibuka
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1 text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                        </button>
                    @endif

                    <!-- 3. Data BPS -->
                    @if($isAdmin || in_array('data-bps', $allowedPages))
                        <a href="{{ route('data-bps') }}" 
                           class="group bg-gradient-to-br from-emerald-50/60 to-teal-50/30 border border-emerald-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-emerald-300 hover:shadow-md transition-all no-underline"
                           id="btn-data-bps">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-emerald-600 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-chart-simple"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-emerald-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                    Data BPS
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                    Lihat data BPS Kota Bukittinggi
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1">
                                <span class="w-6 h-6 rounded-full border border-emerald-300 text-emerald-600 flex items-center justify-center text-[10px] group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @else
                        <button type="button" 
                                onclick="alert('Akses Dibatasi: Akun {{ $dinasName }} tidak memiliki hak akses untuk halaman Data BPS.');"
                                class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between opacity-50 cursor-not-allowed text-left">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-slate-400 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-chart-simple"></i>
                                </div>
                                <h3 class="font-bold text-slate-700 text-xs sm:text-[13px] leading-snug min-h-[2rem] flex items-center">
                                    Data BPS
                                </h3>
                                <p class="text-[11px] text-slate-400 mt-1 leading-snug min-h-[1.75rem]">
                                    Akses belum dibuka
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1 text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                        </button>
                    @endif

                </div>
            </div>

            <!-- RIGHT CARD: MONITORING -->
            <div id="monitoring-section" class="scroll-mt-24 transition-all duration-300 bg-white rounded-3xl border border-slate-200/70 p-5 sm:p-6 shadow-sm hover:shadow-md">
                
                <!-- Section Header -->
                <div class="flex items-start gap-3.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-base shadow-xs">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Monitoring</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Pantau perkembangan pengisian data secara real-time</p>
                    </div>
                </div>

                <!-- 3 Sub-Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    
                    <!-- 1. Monitoring OPD -->
                    @if($isAdmin || in_array('monitoring-opd', $allowedPages))
                        <a href="{{ route('monitoring-opd') }}" 
                           class="group bg-gradient-to-br from-orange-50/70 to-orange-50/30 border border-orange-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-orange-300 hover:shadow-md transition-all no-underline"
                           id="btn-mon-opd">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-orange-500 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-orange-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                    Monitoring OPD
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                    Lihat progres pengisian data OPD
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1">
                                <span class="w-6 h-6 rounded-full border border-orange-300 text-orange-500 flex items-center justify-center text-[10px] group-hover:bg-orange-500 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @else
                        <button type="button" 
                                onclick="alert('Akses Dibatasi: Akun {{ $dinasName }} tidak memiliki hak akses untuk halaman Monitoring OPD.');"
                                class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between opacity-50 cursor-not-allowed text-left">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-slate-400 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <h3 class="font-bold text-slate-700 text-xs sm:text-[13px] leading-snug min-h-[2rem] flex items-center">
                                    Monitoring OPD
                                </h3>
                                <p class="text-[11px] text-slate-400 mt-1 leading-snug min-h-[1.75rem]">
                                    Akses belum dibuka
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1 text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                        </button>
                    @endif

                    <!-- 2. Monitoring Instansi Vertikal -->
                    @if($isAdmin || in_array('monitoring-instansi', $allowedPages))
                        <a href="{{ route('monitoring-instansi') }}" 
                           class="group bg-gradient-to-br from-sky-50/60 to-blue-50/30 border border-sky-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-sky-300 hover:shadow-md transition-all no-underline"
                           id="btn-mon-vertikal">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-sky-600 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-file-contract"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-sky-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                    Monitoring Instansi
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                    Lihat progres pengisian data instansi
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1">
                                <span class="w-6 h-6 rounded-full border border-sky-300 text-sky-600 flex items-center justify-center text-[10px] group-hover:bg-sky-600 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @else
                        <button type="button" 
                                onclick="alert('Akses Dibatasi: Akun {{ $dinasName }} tidak memiliki hak akses untuk halaman Monitoring Instansi Vertikal.');"
                                class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between opacity-50 cursor-not-allowed text-left">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-slate-400 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-file-contract"></i>
                                </div>
                                <h3 class="font-bold text-slate-700 text-xs sm:text-[13px] leading-snug min-h-[2rem] flex items-center">
                                    Monitoring Instansi
                                </h3>
                                <p class="text-[11px] text-slate-400 mt-1 leading-snug min-h-[1.75rem]">
                                    Akses belum dibuka
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1 text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                        </button>
                    @endif

                    <!-- 3. Monitoring BPS -->
                    @if($isAdmin || in_array('data-bps', $allowedPages))
                        <a href="{{ route('data-bps') }}" 
                           class="group bg-gradient-to-br from-emerald-50/60 to-teal-50/30 border border-emerald-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-emerald-300 hover:shadow-md transition-all no-underline">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-emerald-600 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-chart-column"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-emerald-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                    Monitoring BPS
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                    Lihat progres data BPS
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1">
                                <span class="w-6 h-6 rounded-full border border-emerald-300 text-emerald-600 flex items-center justify-center text-[10px] group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @else
                        <button type="button" 
                                onclick="alert('Akses Dibatasi: Akun {{ $dinasName }} tidak memiliki hak akses untuk halaman Data BPS.');"
                                class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between opacity-50 cursor-not-allowed text-left">
                            <div>
                                <div class="w-7 h-7 rounded-lg text-slate-400 flex items-center text-lg mb-2">
                                    <i class="fa-solid fa-chart-column"></i>
                                </div>
                                <h3 class="font-bold text-slate-700 text-xs sm:text-[13px] leading-snug min-h-[2rem] flex items-center">
                                    Monitoring BPS
                                </h3>
                                <p class="text-[11px] text-slate-400 mt-1 leading-snug min-h-[1.75rem]">
                                    Akses belum dibuka
                                </p>
                            </div>
                            <div class="flex justify-end mt-2 pt-1 text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                        </button>
                    @endif

                </div>
            </div>

        </div>

    </main>

    <!-- ======================================================== -->
    <!-- 5. BOTTOM MINANGKABAU SKYLINE SILHOUETTE & FOOTER        -->
    <!-- ======================================================== -->
    <footer class="w-full relative z-10 overflow-hidden bg-slate-50/70 backdrop-blur-xs border-t border-slate-200/60 pt-4 pb-3 mt-4">
        
        <!-- Minangkabau Skyline Watermark -->
        <div class="w-full flex justify-center pointer-events-none opacity-30 mb-2 overflow-hidden">
            <img src="{{ asset('images/minang-skyline.png') }}" alt="Minangkabau Skyline" class="h-10 sm:h-12 w-auto max-w-none object-contain">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500 font-medium">
            <p>&copy; 2026 Badan Pusat Statistik Kota Bukittinggi. Sistem Informasi Data Daerah dalam Angka Bukittinggi (SiAngka).</p>
        </div>
    </footer>

    <!-- ======================================================== -->
    <!-- 6. ABOUT MODAL                                           -->
    <!-- ======================================================== -->
    <div id="aboutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 relative">
            <button onclick="closeAboutModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-8 w-auto">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Tentang SiAngka</h3>
                    <p class="text-xs text-slate-600 font-semibold">Badan Pusat Statistik Kota Bukittinggi</p>
                </div>
            </div>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                <strong>SiAngka (Sistem Informasi Data Daerah dalam Angka Bukittinggi)</strong> adalah platform terintegrasi yang dikembangkan oleh BPS Kota Bukittinggi untuk memudahkan Organisasi Perangkat Daerah (OPD) dan Instansi Vertikal dalam mengunggah, mengelola, serta memantau progres kelengkapan data sektoral secara real-time.
            </p>
            <div class="mt-6 flex justify-end">
                <button onclick="closeAboutModal()" class="px-5 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Script to handle modals & tab selection -->
    <script>

        function openAboutModal(e) {
            if (e) e.preventDefault();
            const modal = document.getElementById('aboutModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeAboutModal() {
            const modal = document.getElementById('aboutModal');
            if (modal) modal.classList.add('hidden');
        }

        // Active Tab Selector: switches orange underline & highlights target block
        function selectNavTab(tabName, e) {
            if (e) e.preventDefault();

            // Set active state on clicked nav item
            const tabs = document.querySelectorAll('.nav-tab');
            tabs.forEach(tab => {
                if (tab.getAttribute('data-nav') === tabName) {
                    tab.classList.remove('text-slate-600', 'border-transparent');
                    tab.classList.add('text-[#f95a00]', 'border-[#f95a00]');
                } else {
                    tab.classList.remove('text-[#f95a00]', 'border-[#f95a00]');
                    tab.classList.add('text-slate-600', 'border-transparent');
                }
            });

            // Smoothly navigate and highlight target block
            if (tabName === 'beranda') {
                const el = document.getElementById('beranda-section');
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (tabName === 'data') {
                const el = document.getElementById('akses-data-section');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Highlight block briefly
                    el.classList.add('ring-4', 'ring-[#f95a00]/40', 'shadow-xl');
                    setTimeout(() => {
                        el.classList.remove('ring-4', 'ring-[#f95a00]/40', 'shadow-xl');
                    }, 1200);
                }
            } else if (tabName === 'monitoring') {
                const el = document.getElementById('monitoring-section');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Highlight block briefly
                    el.classList.add('ring-4', 'ring-[#f95a00]/40', 'shadow-xl');
                    setTimeout(() => {
                        el.classList.remove('ring-4', 'ring-[#f95a00]/40', 'shadow-xl');
                    }, 1200);
                }
            } else if (tabName === 'tentang') {
                openAboutModal();
            }
        }

        // Automatic scroll spy: update active nav tab as user scrolls
        window.addEventListener('scroll', function() {
            const scrollPos = window.scrollY + 280;
            const dataSec = document.getElementById('akses-data-section');
            const monSec = document.getElementById('monitoring-section');

            let current = 'beranda';
            if (monSec && scrollPos >= monSec.offsetTop) {
                current = 'monitoring';
            } else if (dataSec && scrollPos >= dataSec.offsetTop) {
                current = 'data';
            }

            const tabs = document.querySelectorAll('.nav-tab');
            tabs.forEach(tab => {
                if (tab.getAttribute('data-nav') === current) {
                    tab.classList.remove('text-slate-600', 'border-transparent');
                    tab.classList.add('text-[#f95a00]', 'border-[#f95a00]');
                } else if (tab.getAttribute('data-nav') !== 'tentang') {
                    tab.classList.remove('text-[#f95a00]', 'border-[#f95a00]');
                    tab.classList.add('text-slate-600', 'border-transparent');
                }
            });
        }, { passive: true });
    </script>
</body>
</html>
