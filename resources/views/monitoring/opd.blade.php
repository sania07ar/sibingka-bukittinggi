<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring OPD - SiAngka Kota Bukittinggi</title>
    
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

        /* Bottom HOME button */
        .btn-home-mon {
            background-color: #f28538;
            color: #ffffff;
            font-weight: 700;
            border-radius: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.85rem 1.5rem;
            min-height: 3.5rem;
            line-height: 1.2;
            box-shadow: 0 4px 12px rgba(242, 133, 56, 0.25);
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-home-mon:hover {
            background-color: #e07223;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 18px rgba(242, 133, 56, 0.38);
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
<body class="min-h-screen text-slate-800 antialiased flex flex-col justify-between selection:bg-orange-500 selection:text-white bg-[#f0f2f5] relative overflow-x-hidden">

    <!-- Background Sensus Ekonomi Ribbon Watermark (Exact Match to Mockup) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-30">
        <img src="/images/sensus-ribbon-watermark.png" alt="Sensus Ekonomi Ribbon Watermark" class="w-[900px] sm:w-[1200px] lg:w-[1400px] max-w-none transform -translate-x-12 sm:-translate-x-20 -translate-y-4 object-contain">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-between">
        
        <!-- HEADER / LOGO BAR -->
        @include('partials.navbar')

        <!-- MAIN MONITORING OPD CONTAINER -->
        <main class="max-w-3xl mx-auto px-4 sm:px-6 py-6 sm:py-8 flex-1 flex flex-col justify-center w-full">
            
            <!-- Title Header -->
            <div class="text-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    MONITORING DATA OPD
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-lg mx-auto">
                    Dashboard pemantauan & rekapitulasi pengumpulan data sektoral OPD untuk penyusunan Buku Bukittinggi Dalam Angka.
                </p>
            </div>

            <!-- List Pilihan Tahun Monitoring Spreadsheet -->
            <div class="space-y-3 bg-white/80 backdrop-blur-xs p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-lg shadow-slate-900/5">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wide flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-check text-[#f95a00]"></i>
                        Pilih Tahun Monitoring:
                    </span>
                    <span class="text-[11px] font-bold text-slate-400">Google Spreadsheet</span>
                </div>

                <!-- TAHUN 2026 (Aktif / Tahun Berjalan) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-2xl bg-orange-50/80 border-2 border-orange-300/90 hover:border-orange-500 transition-all shadow-xs gap-3">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-xl bg-[#f95a00] text-white flex items-center justify-center font-black text-base shadow-xs shrink-0">
                            2026
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Monitoring BDA 2026 OPD</h3>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="inline-flex items-center text-[10.5px] font-bold text-orange-700 bg-orange-100 px-2 py-0.5 rounded-md">
                                    <i class="fa-solid fa-circle-play mr-1 text-[8px]"></i> Tahun Berjalan / Aktif
                                </span>
                                <span class="text-[11px] text-slate-500 hidden sm:inline">20 OPD Kota Bukittinggi</span>
                            </div>
                        </div>
                    </div>
                    <a href="https://docs.google.com/spreadsheets/d/1LPukf54Rx7Z30Osw2lCR4ardM240I62c/edit?gid=1978844678#gid=1978844678"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="px-4 py-2.5 rounded-xl bg-[#f95a00] hover:bg-[#e04e00] text-white text-xs sm:text-sm font-bold shadow-sm hover:shadow-md transition-all flex items-center justify-center space-x-2 no-underline cursor-pointer shrink-0">
                        <i class="fa-solid fa-table"></i>
                        <span>Buka Spreadsheet 2026</span>
                    </a>
                </div>

                <!-- TAHUN 2025 (Arsip) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 rounded-2xl bg-slate-50/90 border border-slate-200 hover:border-orange-300 transition-colors gap-3">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-slate-700 text-white flex items-center justify-center font-black text-sm shadow-xs shrink-0">
                            2025
                        </div>
                        <div>
                            <h3 class="text-xs sm:text-sm font-extrabold text-slate-800">Monitoring BDA 2025 OPD</h3>
                            <span class="text-[10.5px] text-slate-400 font-medium">Arsip Monitoring OPD Tahun 2025</span>
                        </div>
                    </div>
                    <button onclick="openMonSpreadsheet('2025')"
                            class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 hover:text-slate-900 text-xs font-bold border border-slate-300 transition-colors flex items-center justify-center space-x-1.5 cursor-pointer shrink-0">
                        <i class="fa-solid fa-table text-slate-500"></i>
                        <span>Buka Spreadsheet</span>
                    </button>
                </div>

                <!-- TAHUN 2024 (Arsip) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 rounded-2xl bg-slate-50/90 border border-slate-200 hover:border-orange-300 transition-colors gap-3">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-slate-700 text-white flex items-center justify-center font-black text-sm shadow-xs shrink-0">
                            2024
                        </div>
                        <div>
                            <h3 class="text-xs sm:text-sm font-extrabold text-slate-800">Monitoring BDA 2024 OPD</h3>
                            <span class="text-[10.5px] text-slate-400 font-medium">Arsip Monitoring OPD Tahun 2024</span>
                        </div>
                    </div>
                    <button onclick="openMonSpreadsheet('2024')"
                            class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 hover:text-slate-900 text-xs font-bold border border-slate-300 transition-colors flex items-center justify-center space-x-1.5 cursor-pointer shrink-0">
                        <i class="fa-solid fa-table text-slate-500"></i>
                        <span>Buka Spreadsheet</span>
                    </button>
                </div>

                <!-- TAHUN 2023 (Arsip) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 rounded-2xl bg-slate-50/90 border border-slate-200 hover:border-orange-300 transition-colors gap-3">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-slate-700 text-white flex items-center justify-center font-black text-sm shadow-xs shrink-0">
                            2023
                        </div>
                        <div>
                            <h3 class="text-xs sm:text-sm font-extrabold text-slate-800">Monitoring BDA 2023 OPD</h3>
                            <span class="text-[10.5px] text-slate-400 font-medium">Arsip Monitoring OPD Tahun 2023</span>
                        </div>
                    </div>
                    <button onclick="openMonSpreadsheet('2023')"
                            class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 hover:text-slate-900 text-xs font-bold border border-slate-300 transition-colors flex items-center justify-center space-x-1.5 cursor-pointer shrink-0">
                        <i class="fa-solid fa-table text-slate-500"></i>
                        <span>Buka Spreadsheet</span>
                    </button>
                </div>

                <!-- Info Alert -->
                <div class="bg-blue-50 border border-blue-200/80 rounded-2xl p-3 flex items-start space-x-2 text-blue-800 text-xs mt-3">
                    <i class="fa-solid fa-circle-info text-blue-600 mt-0.5"></i>
                    <span>Tautan Google Spreadsheet ini memantau progres input, verifikasi tabel data, dan kelengkapan publikasi OPD.</span>
                </div>

            </div>

            <!-- BOTTOM CENTER: HOME BUTTON -->
            <div class="flex justify-center items-center mt-6 sm:mt-8">
                <a href="{{ route('home') }}"
                   class="btn-home-mon w-44 sm:w-52 text-sm sm:text-base uppercase tracking-wide no-underline">
                    <span>HOME</span>
                </a>
            </div>

        </main>

        <!-- FOOTER & USER SESSION BAR DI BAGIAN BAWAH -->
        <footer class="w-full border-t border-slate-200/60 bg-white/40 backdrop-blur-sm py-2.5 px-4 sm:px-8 text-slate-600 mt-auto">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2.5 text-xs">
                
                <!-- Info Pengguna yang Sedang Login & Tombol Logout (Transparan) -->
                <div class="inline-flex items-center space-x-2.5 px-3 py-1 rounded-full bg-white/60 hover:bg-white/80 border border-slate-200/80 shadow-xs transition-all backdrop-blur-xs">
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[10px] shadow-xs">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <span class="font-bold text-slate-800 text-xs">{{ session('user.displayName', 'Admin BPS Bukittinggi') }}</span>
                    </div>

                    <div class="h-3.5 w-px bg-slate-300"></div>

                    <form action="{{ route('logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari SiAngka Kota Bukittinggi?');">
                        @csrf
                        <button type="submit" 
                                title="Keluar dari sistem"
                                class="flex items-center space-x-1.5 text-slate-700 hover:text-red-600 font-bold transition-colors text-xs cursor-pointer group">
                            <i class="fa-solid fa-right-from-bracket text-[10px] text-slate-500 group-hover:text-red-600 transition-colors"></i>
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

    <!-- JAVASCRIPT LOGIC -->
    <script>
        const monitoringOpdLinks = {
            '2026': 'https://docs.google.com/spreadsheets/d/1LPukf54Rx7Z30Osw2lCR4ardM240I62c/edit?gid=1978844678#gid=1978844678',
            '2025': '',
            '2024': '',
            '2023': ''
        };

        function openMonSpreadsheet(year) {
            const link = monitoringOpdLinks[year];
            if (link && link.trim() !== '') {
                window.open(link, '_blank');
            } else {
                alert(`Template link Google Spreadsheet Monitoring OPD (Tahun ${year}) masih kosong (placeholder). Link dapat ditambahkan sewaktu-waktu.`);
            }
        }
    </script>
</body>
</html>
