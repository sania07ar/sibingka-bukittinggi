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

        .ambient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            opacity: 0.4;
            transition: all 0.5s ease;
        }

        .btn-orange-glow {
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
        }
        .btn-orange-glow::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                60deg,
                transparent,
                rgba(255, 255, 255, 0.25),
                transparent
            );
            transform: rotate(30deg);
            transition: transform 0.6s ease;
        }
        .btn-orange-glow:hover::after {
            transform: rotate(30deg) translate(50%, 50%);
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
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
        $isInstansiUser = $role === 'instansi';
        $allowedPages = $currentUser['allowed_pages'] ?? [];
        $dinasName = $currentUser['dinas_name'] ?? ($currentUser['displayName'] ?? 'Dinas');
        $username = $currentUser['username'] ?? 'User';
        $opdCode = $currentUser['opd_code'] ?? '01';

        $targetRoute = $isInstansiUser ? route('isi-data-instansi') : route('isi-data-opd');
        $btnLabel = $isInstansiUser ? 'Mulai Isi Data Instansi' : 'Mulai Isi Data OPD';
    @endphp

    <!-- Flash Alert Notification if Access Denied -->
    @if(session('error'))
        <div id="welcome-alert-error" class="fixed top-24 left-1/2 -translate-x-1/2 z-50 max-w-lg w-full px-4 animate-in fade-in duration-300 transition-all">
            <div class="p-3 rounded-2xl text-xs font-bold flex items-center justify-between bg-red-600 text-white shadow-2xl shadow-red-900/30 border border-red-500">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-circle-exclamation text-base shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('welcome-alert-error').remove()" class="text-white hover:text-red-200 text-sm ml-2">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div id="welcome-alert-success" class="fixed top-24 left-1/2 -translate-x-1/2 z-50 max-w-lg w-full px-4 animate-in fade-in duration-300 transition-all">
            <div class="p-3 rounded-2xl text-xs font-bold flex items-center justify-between bg-emerald-600 text-white shadow-2xl shadow-emerald-900/30 border border-emerald-500">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-circle-check text-base shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('welcome-alert-success').remove()" class="text-white hover:text-emerald-200 text-sm ml-2">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Ambient Glow Background Spheres -->
    <div class="ambient-sphere w-[550px] h-[550px] bg-orange-200/50 -top-40 -left-40"></div>
    <div class="ambient-sphere w-[500px] h-[500px] bg-blue-100/50 -top-20 -right-20"></div>

    <!-- ======================================================== -->
    <!-- 1. HEADER / TOP NAVBAR                                   -->
    <!-- ======================================================== -->
    <header class="w-full bg-[#f0f2f5]/95 backdrop-blur-md border-b border-slate-200/70 relative z-20 shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between gap-3 sm:gap-4">
            
            <!-- Left: Logo & Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0 no-underline">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-7 sm:h-8 w-auto object-contain transition-transform group-hover:scale-105">
                <div class="flex flex-col justify-center leading-tight">
                    <span class="text-[11px] sm:text-xs font-black text-slate-900 tracking-tight uppercase font-sans">
                        BADAN PUSAT STATISTIK
                    </span>
                    <span class="text-[9px] sm:text-[10px] font-semibold italic text-slate-600 tracking-wide uppercase font-sans">
                        KOTA BUKITTINGGI
                    </span>
                </div>
            </a>

            <!-- Center: Navigation Links -->
            <nav class="hidden md:flex items-center space-x-6 lg:space-x-8 text-xs sm:text-sm font-semibold" id="topNavbar">
                <a href="#beranda-section" 
                   data-nav="beranda"
                   onclick="selectNavTab('beranda', event)"
                   class="nav-tab text-[#f95a00] border-b-2 border-[#f95a00] pb-1 transition-all cursor-pointer">
                    Beranda
                </a>
                <a href="#tentang-section" 
                   data-nav="tentang"
                   onclick="selectNavTab('tentang', event)"
                   class="nav-tab text-slate-700 hover:text-[#f95a00] border-b-2 border-transparent hover:border-[#f95a00] pb-1 transition-all cursor-pointer">
                    Tentang
                </a>
            </nav>

            <!-- Right: Actions & Official Badges -->
            <div class="flex items-center gap-2.5 sm:gap-3.5 shrink-0">
                <!-- BerAKHLAK Logo -->
                <div class="hidden md:flex items-center">
                    <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-6 sm:h-7 w-auto object-contain">
                </div>

                <!-- Divider -->
                <div class="hidden sm:block h-5 w-[1px] bg-slate-200"></div>

                <!-- User Account Profile & Logout -->
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200/80 text-slate-800 text-xs shadow-2xs">
                        <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[9px] shadow-sm shrink-0">
                            <i class="fa-solid {{ ($opdCode === '01' || stripos($dinasName, 'PUPR') !== false) ? 'fa-city' : 'fa-building' }} text-[9px]"></i>
                        </div>
                        <div class="flex flex-col text-left">
                            <span class="font-bold text-slate-900 leading-tight truncate max-w-[120px] sm:max-w-xs text-[11px] sm:text-xs">{{ $dinasName }}</span>
                            <span class="text-[9px] font-semibold text-slate-500">
                                {{ $isInstansiUser ? 'Instansi Vertikal' : 'Akun Dinas Pemko' }}
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari SiAngka Kota Bukittinggi?');">
                        @csrf
                        <button type="submit" 
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 flex items-center justify-center text-xs transition-colors cursor-pointer"
                                title="Keluar dari akun">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    <!-- ======================================================== -->
    <!-- 2. HERO PANORAMIC BANNER (FULL 1-SCREEN VIEWPORT)        -->
    <!-- ======================================================== -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 sm:py-3 md:py-4 flex-1 flex flex-col justify-center w-full">
        
        <!-- Hero Panoramic Banner -->
        <div id="beranda-section" class="scroll-mt-24 relative w-full rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm bg-white flex-1 flex items-center min-h-[460px] md:min-h-[500px] lg:min-h-[calc(100vh-165px)] max-h-[820px]">
            
            <!-- Right side FGD Bukittinggi Exact Image & Mask -->
            <div class="absolute inset-y-0 right-0 w-full sm:w-1/2 lg:w-[46%] xl:w-2/5 overflow-hidden pointer-events-none">
                <img src="{{ asset('images/fgd-bukittinggi-exact.png') }}" alt="FGD Bukittinggi dalam Angka" class="w-full h-full object-cover object-center">
                <!-- Gradasi halus pinggir kiri foto -->
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
            <div class="relative z-10 max-w-xl lg:max-w-2xl px-6 sm:px-10 lg:px-14 py-8 md:py-12">
                
                <!-- Greeting -->
                <p class="text-xs sm:text-sm font-bold text-[#ea580c] tracking-wide mb-2.5">
                    Selamat Datang, <span class="text-[#f95a00] font-extrabold">{{ $dinasName }}</span>
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

                <!-- CTA Button (Direct to their tables) -->
                <div class="mt-6 sm:mt-8 flex items-center gap-3">
                    <a href="{{ $targetRoute }}" 
                       class="btn-orange-glow inline-flex items-center gap-2.5 bg-[#f95a00] hover:bg-[#ea580c] text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 no-underline">
                        <i class="fa-solid fa-file-pen text-sm"></i>
                        <span>{{ $btnLabel }}</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- ======================================================== -->
    <!-- 3. BOTTOM MINANGKABAU SKYLINE SILHOUETTE & FOOTER        -->
    <!-- ======================================================== -->
    <footer class="w-full relative z-10 overflow-hidden bg-slate-50/70 backdrop-blur-xs border-t border-slate-200/60 py-2 sm:py-2.5 mt-auto shrink-0">
        
        <!-- Minangkabau Skyline Watermark -->
        <div class="w-full flex justify-center pointer-events-none opacity-30 mb-1 overflow-hidden">
            <img src="{{ asset('images/minang-skyline.png') }}" alt="Minangkabau Skyline" class="h-7 sm:h-8 w-auto max-w-none object-contain">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500 font-medium">
            <p>&copy; 2026 Badan Pusat Statistik Kota Bukittinggi. Sistem Informasi Data Daerah dalam Angka Bukittinggi (SiAngka).</p>
        </div>
    </footer>

    <!-- ======================================================== -->
    <!-- 4. ABOUT MODAL                                           -->
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

        function selectNavTab(tabName, e) {
            if (e) e.preventDefault();
            if (tabName === 'beranda') {
                const el = document.getElementById('beranda-section');
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (tabName === 'tentang') {
                openAboutModal();
            }
        }
    </script>
</body>
</html>

