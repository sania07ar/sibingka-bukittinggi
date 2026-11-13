<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $title ?? 'SiBingka Kota Bukittinggi - BPS Kota Bukittinggi')</title>
    <meta name="description" content="SiBingka Kota Bukittinggi - Sistem Informasi Bukittinggi dalam Angka - Badan Pusat Statistik Kota Bukittinggi">

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

    <!-- BASE STYLING & TOKENS -->
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f4f9;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Ambient Glow Spheres */
        .ambient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            opacity: 0.4;
            transition: all 0.5s ease;
        }

        /* Standard SiBingka Orange Gradient Button */
        .btn-sibingka {
            background: linear-gradient(135deg, #f95a00 0%, #eb5200 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.65rem 1.25rem;
            line-height: 1.25;
            box-shadow: 0 4px 14px rgba(249, 90, 0, 0.25), 0 1px 2px rgba(0, 0, 0, 0.06);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }
        .btn-sibingka:hover {
            background: linear-gradient(135deg, #ea5200 0%, #db4500 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(249, 90, 0, 0.35);
        }
        .btn-sibingka:active {
            transform: translateY(0.5px) scale(0.99);
            box-shadow: 0 2px 6px rgba(249, 90, 0, 0.2);
        }

        /* Shimmer Effect */
        .btn-sibingka::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 45%;
            height: 200%;
            background: linear-gradient(60deg, rgba(255, 255, 255, 0) 20%, rgba(255, 255, 255, 0.35) 50%, rgba(255, 255, 255, 0.85) 80%);
            transform: rotate(25deg);
            transition: all 0.65s ease;
        }
        .btn-sibingka:hover::after {
            left: 130%;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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

    @stack('styles')
    @yield('styles')
</head>
<body class="min-h-screen text-slate-800 antialiased flex flex-col justify-between relative selection:bg-orange-500 selection:text-white bg-[#f1f4f9] overflow-x-hidden">

    <!-- ========================================================================= -->
    <!-- 1. AMBIENT LIGHTING ATMOSPHERE & WATERMARK BACKGROUND                      -->
    <!-- ========================================================================= -->
    <div class="ambient-sphere w-96 h-96 bg-orange-200/40 top-[-60px] right-[-60px]"></div>
    <div class="ambient-sphere w-80 h-80 bg-blue-100/50 bottom-[-40px] left-[-40px]"></div>

    <!-- Background SiBingka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-20 select-none">
        <img src="{{ asset('images/sibingka-watermark-jamgadang.jpg') }}" alt="Watermark SiBingka Jam Gadang" class="w-[950px] sm:w-[1250px] lg:w-[1450px] max-w-none transform -translate-x-10 object-contain mix-blend-multiply">
    </div>

    <!-- ========================================================================= -->
    <!-- 2. HEADER / TOP NAVBAR (BPS, BerAKHLAK, PROFIL & LOGOUT)                   -->
    <!-- ========================================================================= -->
    <header class="w-full bg-[#f0f2f5]/95 backdrop-blur-md border-b border-slate-200/70 py-2 sm:py-2.5 px-3 sm:px-8 lg:px-12 relative z-20 shrink-0">
        <div class="max-w-7xl mx-auto flex flex-row items-center justify-between gap-3 sm:gap-6 flex-wrap sm:flex-nowrap">
            
            <!-- Left: BPS Kota Bukittinggi Logo & Title -->
            @php
                $userRole = session('user.role', 'opd');
                $defaultHomeUrl = (session()->has('user') && $userRole === 'admin') ? route('portal') : route('home');
                $navHomeUrl = $homeUrl ?? $defaultHomeUrl;
            @endphp
            <a href="{{ $navHomeUrl }}" class="flex items-center space-x-2 sm:space-x-2.5 transition-transform hover:scale-[1.02] no-underline text-inherit shrink-0">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-7 sm:h-8 md:h-9 w-auto object-contain">
                <div class="flex flex-col justify-center leading-tight">
                    <span class="text-[9px] sm:text-[11px] md:text-xs font-black italic text-slate-900 tracking-tight uppercase font-sans">
                        BADAN PUSAT STATISTIK
                    </span>
                    <span class="text-[8px] sm:text-[10px] md:text-[11px] font-black italic text-slate-800 tracking-tight uppercase font-sans">
                        KOTA BUKITTINGGI
                    </span>
                </div>
            </a>

            <!-- Right: BerAKHLAK Logo & Optional Quick User Actions -->
            <div class="flex items-center justify-end space-x-3 shrink-0">
                <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-6 sm:h-8 md:h-9 w-auto object-contain">

                @if(session()->has('user'))
                    <div class="hidden md:flex items-center space-x-2 pl-3 border-l border-slate-300">
                        <div class="flex flex-col text-right leading-none">
                            <span class="text-xs font-bold text-slate-900 max-w-[150px] truncate" title="{{ session('user.displayName') }}">
                                {{ session('user.displayName') }}
                            </span>
                            <span class="text-[9.5px] font-semibold text-orange-600 mt-0.5">
                                {{ session('user.roleLabel', 'User') }}
                            </span>
                        </div>
                        <a href="{{ route('logout') }}" 
                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 border border-slate-200 transition-colors shadow-2xs" 
                           title="Keluar dari akun">
                            <i class="fa-solid fa-power-off text-xs"></i>
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </header>

    <!-- ========================================================================= -->
    <!-- 3. MAIN PAGE CONTENT (@yield('content'))                                  -->
    <!-- ========================================================================= -->
    <main class="relative z-10 flex-1 w-full">
        @yield('content')
    </main>

    <!-- ========================================================================= -->
    <!-- 4. FOOTER (INFORMASI PENGGUNA, COPYRIGHT & ALAMAT KANTOR BPS)             -->
    <!-- ========================================================================= -->
    <footer class="relative z-20 w-full py-2.5 sm:py-3 px-3 sm:px-8 lg:px-12 border-t border-slate-200/70 bg-white/90 backdrop-blur-md shrink-0 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2.5 text-xs">
            
            <!-- User Status & Logout Button -->
            @if(session()->has('user'))
                <div class="inline-flex items-center space-x-2">
                    <div class="flex items-center space-x-2 bg-white/95 border border-slate-200/90 rounded-full py-1 px-3 shadow-2xs">
                        <div class="w-4 h-4 rounded-full overflow-hidden shrink-0 shadow-2xs border border-slate-200">
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center space-x-1.5 leading-none">
                            <span class="text-[11px] sm:text-xs font-bold text-slate-900">
                                {{ session('user.displayName', 'Pengguna') }}
                            </span>
                            <span class="text-[10px] text-slate-300">•</span>
                            <span class="text-[10px] font-semibold text-emerald-600">
                                {{ session('user.roleLabel', 'User') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('logout') }}" 
                       class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-slate-600 hover:text-red-600 bg-white/95 hover:bg-red-50 border border-slate-200 hover:border-red-200 transition-all shadow-2xs group"
                       title="Keluar dari akun">
                        <i class="fa-solid fa-power-off text-[10px] text-slate-400 group-hover:text-red-600 transition-colors"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            @else
                <div class="text-[11px] text-slate-600">
                    <span class="font-bold text-slate-800">SiBingka Kota Bukittinggi</span> — Sistem Informasi Bukittinggi dalam Angka
                </div>
            @endif

            <!-- Copyright & Alamat BPS Bukittinggi -->
            <div class="flex flex-col sm:flex-row items-center space-y-0.5 sm:space-y-0 sm:space-x-3 text-[10.5px] sm:text-[11px] text-slate-500 text-center sm:text-right">
                <p>© <span id="masterFooterYear"></span> <strong>Badan Pusat Statistik Kota Bukittinggi</strong>.</p>
                <span class="hidden sm:inline text-slate-300">•</span>
                <span class="hover:text-orange-600 transition-colors">
                    <i class="fa-solid fa-location-dot text-[#f95a00] mr-1"></i>
                    Jl. Perwira No.50, Belakang Balok, Bukittinggi
                </span>
            </div>

        </div>
    </footer>

    <!-- Master Scripts -->
    <script>
        if (document.getElementById('masterFooterYear')) {
            document.getElementById('masterFooterYear').innerText = new Date().getFullYear();
        }
        if (document.getElementById('currentYear')) {
            document.getElementById('currentYear').innerText = new Date().getFullYear();
        }
    </script>

    @stack('scripts')
    @yield('scripts')

</body>
</html>
