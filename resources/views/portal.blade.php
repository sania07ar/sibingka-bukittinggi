<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Layanan - SiMonDa Bukittinggi | BPS Kota Bukittinggi</title>
    
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
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f4f9;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        @media (min-width: 1024px) {
            html, body {
                height: 100vh;
                max-height: 100vh;
                overflow: hidden;
            }
        }

        /* Ambient Glow Spheres */
        .ambient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            opacity: 0.35;
            transition: all 0.5s ease;
        }

        /* SiMonDa Standard Orange Button */
        .btn-simonda {
            background: linear-gradient(135deg, #f95a00 0%, #eb5200 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.65rem 1.25rem;
            box-shadow: 0 4px 14px rgba(249, 90, 0, 0.25);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .btn-simonda:hover {
            background: linear-gradient(135deg, #ea5200 0%, #db4500 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 90, 0, 0.35);
        }

        .btn-simonda:active {
            transform: translateY(0) scale(0.99);
        }

        /* Slate / Indigo Button for Kelola Akun */
        .btn-account {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.65rem 1.25rem;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-account:hover {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.3);
        }

        .btn-account:active {
            transform: translateY(0) scale(0.99);
        }

        /* Shimmer effect on buttons */
        .btn-simonda::after, .btn-account::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 45%;
            height: 200%;
            background: linear-gradient(
                60deg,
                rgba(255, 255, 255, 0) 20%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0.8) 80%
            );
            transform: rotate(25deg);
            transition: all 0.65s ease;
        }

        .btn-simonda:hover::after, .btn-account:hover::after {
            left: 130%;
        }

        /* Interactive Portal Choice Card */
        .portal-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .portal-card:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body class="h-screen max-h-screen overflow-hidden text-slate-800 antialiased flex flex-col justify-between relative selection:bg-orange-500 selection:text-white bg-[#f1f4f9]">

    <!-- Ambient Lighting Atmosphere -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="ambient-sphere w-96 h-96 bg-orange-200/50 -top-16 -right-16"></div>
        <div class="ambient-sphere w-96 h-96 bg-blue-200/40 -bottom-16 -left-16"></div>
    </div>

    <!-- Background Sensus Ekonomi Ribbon Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-20 select-none">
        <img src="{{ asset('images/sensus-ribbon-watermark.png') }}" alt="Sensus Ekonomi Watermark" class="w-[900px] lg:w-[1200px] max-w-none transform -translate-x-16 object-contain">
    </div>

    <!-- HEADER / LOGO BAR -->
    <header class="w-full bg-[#f0f2f5] border-b border-slate-200/60 py-2 sm:py-2.5 px-4 sm:px-8 lg:px-12 relative z-20 shrink-0">
        <div class="max-w-6xl mx-auto flex flex-row items-center justify-between gap-4 md:gap-6 flex-wrap lg:flex-nowrap">
            
            <!-- Left: BPS Kota Bukittinggi Logo -->
            <div class="flex items-center space-x-2.5 transition-transform hover:scale-[1.02]">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-7 sm:h-8 md:h-9 w-auto object-contain">
                <div class="flex flex-col justify-center leading-tight">
                    <span class="text-[10px] sm:text-[11px] md:text-xs font-black italic text-slate-900 tracking-tight uppercase font-sans">
                        BADAN PUSAT STATISTIK
                    </span>
                    <span class="text-[9px] sm:text-[10px] md:text-[11px] font-black italic text-slate-800 tracking-tight uppercase font-sans">
                        KOTA BUKITTINGGI
                    </span>
                </div>
            </div>

            <!-- Center: Sensus Ekonomi 2026 Logo -->
            <div class="flex items-center justify-center transition-transform hover:scale-[1.02]">
                <img src="{{ asset('images/sensus-ekonomi-clean.png') }}" alt="Sensus Ekonomi 2026" class="h-7 sm:h-8 md:h-9 w-auto object-contain">
            </div>

            <!-- Right: BerAKHLAK Logo -->
            <div class="flex items-center justify-end transition-transform hover:scale-[1.02]">
                <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-7 sm:h-8 md:h-9 w-auto object-contain">
            </div>

        </div>
    </header>

    <!-- MAIN CONTENT (FITS 1 SCREEN) -->
    <main class="relative z-10 flex-1 flex flex-col justify-center items-center px-4 sm:px-8 py-2 sm:py-3 lg:py-4 max-w-5xl mx-auto w-full min-h-0">
        
        <!-- Welcome Hero Greeting -->
        <div class="text-center max-w-2xl mx-auto mb-3 sm:mb-4 lg:mb-5 space-y-1 sm:space-y-1.5 shrink-0">
            <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-orange-100/80 border border-orange-200/70 text-[#f95a00] text-[10.5px] font-black tracking-wider uppercase shadow-xs">
                <i class="fa-solid fa-layer-group text-[10px]"></i>
                <span>Portal Layanan Administrator</span>
            </div>

            <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                Pilih Menu Yang Ingin Dituju
            </h1>

            <p class="text-[11.5px] sm:text-xs text-slate-600 font-medium leading-relaxed max-w-xl mx-auto">
                Halo, <strong class="text-slate-900">{{ session('user.displayName', 'Administrator BPS') }}</strong>! Silakan pilih apakah Anda ingin mengelola akun admin terlebih dahulu, atau langsung masuk ke halaman utama SiMonDa.
            </p>
        </div>

        <!-- 2 PILIHAN UTAMA: KELOLA AKUN vs MASUK KE SIMONDA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 w-full max-w-4xl my-auto">
            
            <!-- CARD 1: KELOLA AKUN -->
            <div class="portal-card bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-5 lg:p-6 border border-slate-200/90 shadow-lg shadow-slate-900/5 relative overflow-hidden flex flex-col justify-between group hover:border-slate-400 hover:shadow-slate-900/10">
                <!-- Top Color Strip -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-slate-700 via-indigo-600 to-slate-900"></div>

                <div>
                    <!-- Header Icon & Badge -->
                    <div class="flex items-center justify-between mb-3 lg:mb-4">
                        <div class="w-11 h-11 lg:w-12 lg:h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-lg lg:text-xl shadow-inner group-hover:scale-105 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10.5px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                            <i class="fa-solid fa-shield-halved mr-1 text-indigo-500"></i> Pengaturan Akun
                        </span>
                    </div>

                    <!-- Title & Description -->
                    <h2 class="text-base sm:text-lg lg:text-xl font-black text-slate-900 tracking-tight mb-1 group-hover:text-indigo-600 transition-colors">
                        Kelola Akun Admin
                    </h2>
                    
                    <p class="text-[11.5px] sm:text-xs text-slate-600 leading-relaxed mb-3">
                        Perbarui informasi profil akun administrator BPS, ganti kata sandi login, kelola email resmi, serta status keamanan sesi.
                    </p>

                    <!-- Features Checklist -->
                    <div class="space-y-1.5 mb-3.5 lg:mb-4 bg-slate-50/80 rounded-xl p-2.5 sm:p-3 border border-slate-100 text-[11px] sm:text-xs font-semibold text-slate-700">
                        <div class="flex items-center">
                            <i class="fa-solid fa-key text-amber-500 mr-2 text-xs"></i>
                            <span>Ganti & Perbarui Kata Sandi</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-id-card text-blue-500 mr-2 text-xs"></i>
                            <span>Profil Nama & NIP Administrator</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-shield-check text-emerald-500 mr-2 text-xs"></i>
                            <span>Keamanan Sesi & Akses Login</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div>
                    <a href="{{ route('kelola-akun') }}" 
                       class="btn-account w-full text-xs uppercase tracking-wider space-x-2 group-hover:shadow-md transition-all"
                       id="btn-pilih-kelola-akun">
                        <span>Kelola Akun Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-[11px] transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>

            <!-- CARD 2: MASUK KE SIMONDA -->
            <div class="portal-card bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-5 lg:p-6 border border-orange-200/90 shadow-lg shadow-orange-500/10 relative overflow-hidden flex flex-col justify-between group hover:border-[#f95a00] hover:shadow-orange-500/15">
                <!-- Top Color Strip -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-orange-400 via-[#f95a00] to-amber-500"></div>

                <div>
                    <!-- Header Icon & Badge -->
                    <div class="flex items-center justify-between mb-3 lg:mb-4">
                        <div class="w-11 h-11 lg:w-12 lg:h-12 rounded-xl bg-orange-50 border border-orange-200 text-[#f95a00] flex items-center justify-center text-lg lg:text-xl shadow-inner group-hover:scale-105 group-hover:bg-[#f95a00] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10.5px] font-bold bg-orange-50 text-[#f95a00] border border-orange-200">
                            <i class="fa-solid fa-database mr-1"></i> Portal SiMonDa
                        </span>
                    </div>

                    <!-- Title & Description -->
                    <h2 class="text-base sm:text-lg lg:text-xl font-black text-slate-900 tracking-tight mb-1 group-hover:text-[#f95a00] transition-colors">
                        Masuk Halaman SiMonDa
                    </h2>
                    
                    <p class="text-[11.5px] sm:text-xs text-slate-600 leading-relaxed mb-3">
                        Langsung menuju sistem utama SiMonDa Bukittinggi dalam Angka untuk mengisi data OPD, Instansi Vertikal, Data BPS, serta monitoring.
                    </p>

                    <!-- Features Checklist -->
                    <div class="space-y-1.5 mb-3.5 lg:mb-4 bg-orange-50/40 rounded-xl p-2.5 sm:p-3 border border-orange-100 text-[11px] sm:text-xs font-semibold text-slate-700">
                        <div class="flex items-center">
                            <i class="fa-solid fa-building-columns text-[#f95a00] mr-2 text-xs"></i>
                            <span>Isi Data OPD (20 Dinas Terdaftar)</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-landmark-flag text-indigo-500 mr-2 text-xs"></i>
                            <span>Isi Data Instansi Vertikal & Lainnya</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chart-line text-emerald-500 mr-2 text-xs"></i>
                            <span>Data BPS & Monitoring Rekapitulasi</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div>
                    <a href="{{ route('home') }}" 
                       class="btn-simonda w-full text-xs uppercase tracking-wider space-x-2 group-hover:shadow-md transition-all"
                       id="btn-pilih-masuk-simonda">
                        <span>Masuk ke SiMonDa</span>
                        <i class="fa-solid fa-arrow-right text-[11px] transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>

        </div>

    </main>

    <!-- FOOTER / BOTTOM BAR (100% FLUSH DI BAGIAN PALING BAWAH LAYAR) -->
    <footer class="relative z-20 w-full py-2 sm:py-2.5 px-4 sm:px-8 lg:px-12 border-t border-slate-200/70 bg-white/80 backdrop-blur-md shrink-0">
        <div class="max-w-6xl mx-auto flex flex-row items-center justify-between gap-3 text-xs">
            
            <!-- User Profile & Logout (Di Bawah) -->
            <div class="inline-flex items-center space-x-2.5">
                <div class="flex items-center space-x-2 bg-white/95 border border-slate-200/90 rounded-full py-1 px-3 shadow-xs">
                    <div class="w-5 h-5 rounded-full bg-orange-100 text-[#f95a00] flex items-center justify-center font-black text-[10px]">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="flex flex-col text-left leading-none pr-1">
                        <span class="text-xs font-bold text-slate-900">
                            {{ session('user.displayName', 'Admin BPS Bukittinggi') }}
                        </span>
                        <span class="text-[9.5px] font-semibold text-emerald-600">
                            Administrator
                        </span>
                    </div>
                </div>

                <a href="{{ route('logout') }}" 
                   class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold text-slate-600 hover:text-red-600 bg-white/95 hover:bg-red-50 border border-slate-200 hover:border-red-200 transition-all shadow-xs group"
                   title="Keluar dari akun">
                    <i class="fa-solid fa-power-off text-[11px] text-slate-400 group-hover:text-red-600 transition-colors"></i>
                    <span>Keluar</span>
                </a>
            </div>

            <!-- Copyright -->
            <p class="text-[10.5px] sm:text-[11px] text-slate-500 text-right">
                © <span id="currentYear"></span> <strong>Badan Pusat Statistik Kota Bukittinggi</strong>. SiMonDa Bukittinggi dalam Angka.
            </p>

        </div>
    </footer>

    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>
</body>
</html>
