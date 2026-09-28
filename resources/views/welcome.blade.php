<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMonDa Bukittinggi dalam Angka - BPS Kota Bukittinggi</title>
    
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
        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f2f5;
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

        /* Custom orange button styling */
        .btn-simonda {
            background-color: #f95a00;
            color: #ffffff;
            font-weight: 700;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.7rem 1.15rem;
            line-height: 1.25;
            box-shadow: 0 4px 12px rgba(249, 90, 0, 0.25);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .btn-simonda:hover {
            background-color: #e04e00;
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 6px 18px rgba(249, 90, 0, 0.35);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-simonda:active {
            transform: translateY(0) scale(0.99);
        }

        /* Shimmer effect on button hover */
        .btn-simonda::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 40%;
            height: 200%;
            background: linear-gradient(
                60deg,
                rgba(255, 255, 255, 0) 20%,
                rgba(255, 255, 255, 0.25) 50%,
                rgba(255, 255, 255, 0) 80%
            );
            transform: rotate(25deg);
            transition: all 0.6s ease;
        }

        .btn-simonda:hover::after {
            left: 130%;
        }

        /* Compact button sizing on lower laptop heights */
        @media (max-height: 750px) and (min-width: 1024px) {
            .btn-simonda {
                padding: 0.55rem 0.95rem;
                font-size: 0.825rem;
                border-radius: 0.85rem;
            }
        }

        @media (max-height: 650px) and (min-width: 1024px) {
            .btn-simonda {
                padding: 0.45rem 0.8rem;
                font-size: 0.775rem;
            }
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
<body class="min-h-screen lg:h-screen lg:max-h-screen text-slate-800 antialiased flex flex-col justify-between selection:bg-orange-500 selection:text-white bg-[#f0f2f5] overflow-x-hidden overflow-y-auto lg:overflow-y-hidden">

    <!-- Background Sensus Ekonomi Ribbon Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-25">
        <img src="/images/sensus-ribbon-watermark.png" alt="Sensus Ekonomi Ribbon Watermark" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-20 sm:-translate-x-36 -translate-y-6 object-contain">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-between min-h-0 h-full">
        
        <!-- HEADER / LOGO BAR -->
        <header class="w-full bg-[#f0f2f5] border-b border-slate-200/60 py-2 sm:py-2.5 px-4 sm:px-8 lg:px-12 shrink-0">
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

        <!-- HERO SECTION -->
        <main class="max-w-6xl mx-auto px-4 sm:px-8 lg:px-12 py-2 sm:py-3 lg:py-4 flex-1 flex items-center justify-center w-full min-h-0">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 xl:gap-10 items-center w-full my-auto">
                
                <!-- LEFT COLUMN: Titles & 6 Action Buttons -->
                <div class="lg:col-span-6 flex flex-col justify-center">
                    
                    <!-- Main Title -->
                    <div class="space-y-0.5 sm:space-y-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-3xl xl:text-4xl 2xl:text-5xl font-black text-[#111827] tracking-tight leading-[1.12]">
                            SiMonDa Bukittinggi<br>
                            <span class="inline-block text-[#111827]">dalam Angka</span>
                        </h1>
                        
                        <!-- Subtitle in Vibrant Orange -->
                        <p class="text-sm sm:text-base lg:text-base xl:text-lg font-bold text-[#f95a00] pt-1 tracking-normal leading-snug">
                            Sistem Monitoring Data Bukittinggi<br class="hidden sm:inline"> dalam Angka
                        </p>
                    </div>

                    <!-- 6 Grid Action Buttons -->
                    <div class="mt-4 sm:mt-5 lg:mt-6 grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 max-w-md xl:max-w-lg">
                        
                        <!-- 1. ISI DATA OPD -->
                        <a href="{{ route('isi-data-opd') }}"
                           class="btn-simonda text-xs sm:text-sm uppercase tracking-wide group no-underline"
                           id="btn-isi-opd">
                            <span>ISI DATA OPD</span>
                            <i class="fa-solid fa-arrow-right ml-1.5 text-[10px] opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>

                        <!-- 2. MONITORING OPD -->
                        <a href="{{ route('monitoring-opd') }}"
                           class="btn-simonda text-xs sm:text-sm uppercase tracking-wide group no-underline"
                           id="btn-mon-opd">
                            <span>MONITORING OPD</span>
                            <i class="fa-solid fa-arrow-right ml-1.5 text-[10px] opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>

                        <!-- 3. ISI DATA INSTANSI VERTIKAL DAN LAINNYA -->
                        <a href="{{ route('isi-data-instansi') }}"
                           class="btn-simonda text-[11px] sm:text-xs uppercase tracking-tight py-2 sm:py-2.5 group no-underline"
                           id="btn-isi-vertikal">
                            <span class="leading-tight">ISI DATA INSTANSI<br>VERTIKAL DAN LAINNYA</span>
                        </a>

                        <!-- 4. MONITORING INSTANSI VERTIKAL DAN LAINNYA -->
                        <a href="{{ route('monitoring-instansi') }}"
                           class="btn-simonda text-[11px] sm:text-xs uppercase tracking-tight py-2 sm:py-2.5 group no-underline"
                           id="btn-mon-vertikal">
                            <span class="leading-tight">MONITORING INSTANSI<br>VERTIKAL DAN LAINNYA</span>
                        </a>

                        <!-- 5. DATA BPS -->
                        <a href="{{ route('data-bps') }}"
                           class="btn-simonda text-xs sm:text-sm uppercase tracking-wide group no-underline"
                           id="btn-data-bps">
                            <span>DATA BPS</span>
                            <i class="fa-solid fa-arrow-right ml-1.5 text-[10px] opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>

                        <!-- 6. MONITORING BPS (Belum Diaktifkan) -->
                        <button onclick="alert('Modul Monitoring BPS saat ini belum diaktifkan.');"
                                class="btn-simonda text-xs sm:text-sm uppercase tracking-wide group"
                                id="btn-mon-bps">
                            <span>MONITORING BPS</span>
                        </button>

                    </div>

                </div>

                <!-- RIGHT COLUMN: Framed Event Photo with Exact Reference Shape -->
                <div class="lg:col-span-6 flex justify-center lg:justify-end items-center relative py-1 sm:py-2 lg:py-0">
                    
                    <div class="relative w-full max-w-[300px] sm:max-w-[340px] md:max-w-[360px] lg:max-w-[370px] xl:max-w-[420px] 2xl:max-w-[450px] mx-auto lg:mr-0">
                        
                        <!-- Smooth Orange Frame Outline (Top-Left Arch & Border) -->
                        <div class="absolute -inset-1.5 sm:-inset-2 pointer-events-none z-20">
                            <!-- Custom SVG for precise curved orange frame outline matching design -->
                            <svg class="w-full h-full" viewBox="0 0 540 500" fill="none" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="orangeBorderGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stop-color="#ff6b00"/>
                                        <stop offset="50%" stop-color="#f95a00"/>
                                        <stop offset="100%" stop-color="#ea580c"/>
                                    </linearGradient>
                                </defs>
                                
                                <!-- Thick Corner Arc on Top-Left -->
                                <path d="M 120 4 C 40 4, 4 40, 4 120 L 4 40 C 4 15, 15 4, 40 4 Z" 
                                      fill="#f95a00" opacity="0.95"/>
                                
                                <!-- Outline stroke running from top across top-left to bottom-left -->
                                <path d="M 520 4 L 50 4 C 20 4, 4 20, 4 50 L 4 450 C 4 480, 20 496, 50 496 L 520 496" 
                                      stroke="url(#orangeBorderGrad)" 
                                      stroke-width="4.5" 
                                      stroke-linecap="round" 
                                      fill="none"/>
                            </svg>
                        </div>

                        <!-- Photo Card Container with Matched Rounded Corners -->
                        <div class="relative rounded-[1.5rem] sm:rounded-[1.75rem] xl:rounded-[2rem] overflow-hidden bg-white shadow-xl shadow-slate-900/15 border border-slate-200/80 group">
                            
                            <!-- The exact photo from user -->
                            <img src="/images/fgd-bukittinggi-exact.png" 
                                 alt="Focus Group Discussion Penyusunan Publikasi Kota Bukittinggi Dalam Angka" 
                                 class="w-full h-auto max-h-[min(50vh,380px)] xl:max-h-[420px] object-cover object-center block transform group-hover:scale-[1.015] transition-transform duration-500 ease-out">

                        </div>

                    </div>

                </div>

            </div>
        </main>

        <!-- FOOTER & USER SESSION BAR DI BAGIAN BAWAH -->
        <footer class="w-full border-t border-slate-200/60 bg-white/40 backdrop-blur-sm py-1.5 sm:py-2 px-4 sm:px-8 text-slate-600 shrink-0">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-1.5 sm:gap-2.5 text-xs">
                
                <!-- Info Pengguna yang Sedang Login & Navigasi Cepat (Bagian Bawah) -->
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 sm:py-1 rounded-full bg-white/70 hover:bg-white/90 border border-slate-200/80 shadow-xs transition-all backdrop-blur-xs">
                    <div class="flex items-center space-x-1.5 sm:space-x-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[9px] sm:text-[10px] shadow-xs">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <span class="font-bold text-slate-800 text-[11px] sm:text-xs">{{ session('user.displayName', 'Admin BPS Bukittinggi') }}</span>
                    </div>

                    <div class="h-3 w-px bg-slate-300"></div>

                    <a href="{{ route('portal') }}" class="flex items-center space-x-1 text-slate-600 hover:text-[#f95a00] font-bold transition-colors text-[10.5px] sm:text-[11px]" title="Kembali ke Pilihan Menu">
                        <i class="fa-solid fa-layer-group text-[9px] sm:text-[10px] text-[#f95a00]"></i>
                        <span>Pilihan Menu</span>
                    </a>

                    <div class="h-3 w-px bg-slate-300"></div>

                    <a href="{{ route('kelola-akun') }}" class="flex items-center space-x-1 text-slate-600 hover:text-indigo-600 font-bold transition-colors text-[10.5px] sm:text-[11px]" title="Kelola Akun Administrator">
                        <i class="fa-solid fa-user-gear text-[9px] sm:text-[10px] text-indigo-500"></i>
                        <span>Kelola Akun</span>
                    </a>

                    <div class="h-3 w-px bg-slate-300"></div>

                    <form action="{{ route('logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari SiMonDa Bukittinggi?');">
                        @csrf
                        <button type="submit" 
                                title="Keluar dari sistem"
                                class="flex items-center space-x-1 text-slate-700 hover:text-red-600 font-bold transition-colors text-[11px] sm:text-xs cursor-pointer group">
                            <i class="fa-solid fa-right-from-bracket text-[9px] sm:text-[10px] text-slate-500 group-hover:text-red-600 transition-colors"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>

                <!-- Copyright & Address -->
                <div class="flex flex-col sm:flex-row items-center space-y-0.5 sm:space-y-0 sm:space-x-3 text-[10.5px] sm:text-[11px] text-slate-500 text-center md:text-right">
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

    <!-- INTERACTIVE MODAL / DETAIL POPUP -->
    <div id="simondaModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100" id="modalCard">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-[#f95a00] text-xl shadow-xs">
                        <i id="modalIcon" class="fa-solid fa-folder-open"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-orange-600">SiMonDa Bukittinggi</span>
                        <h3 id="modalTitle" class="text-xl font-extrabold text-slate-900 leading-tight">Judul Menu</h3>
                    </div>
                </div>
                <button onclick="closeModal()" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-5 space-y-4">
                <p id="modalDesc" class="text-sm text-slate-600 leading-relaxed">
                    Deskripsi modul akan muncul di sini.
                </p>

                <!-- Status Card Example -->
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Periode Publikasi:</span>
                        <span class="font-bold text-slate-800">Bukittinggi Dalam Angka {{ date('Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Status Pengumpulan:</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                            Sedang Berlangsung
                        </span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2 mt-2">
                        <div class="bg-[#f95a00] h-2 rounded-full" style="width: 68%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 font-medium pt-1">
                        <span>Progres Input</span>
                        <span>68% Selesai</span>
                    </div>
                </div>

                <!-- Quick Action Buttons inside Modal -->
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <button onclick="alert('Membuka formulir data...')" class="w-full py-2.5 px-4 bg-[#f95a00] hover:bg-[#e04e00] text-white font-bold rounded-xl text-xs sm:text-sm shadow-md transition-all flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>Buka Modul</span>
                    </button>
                    <button onclick="alert('Mendownload template data excel...')" class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-file-excel text-emerald-600"></i>
                        <span>Unduh Format</span>
                    </button>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                <button onclick="closeModal()" class="px-5 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- JAVASCRIPT FOR INTERACTION -->
    <script>
        const iconMap = {
            'isi-opd': 'fa-building-columns',
            'mon-opd': 'fa-chart-line',
            'isi-vertikal': 'fa-landmark-flag',
            'mon-vertikal': 'fa-clipboard-check',
            'data-bps': 'fa-database',
            'mon-bps': 'fa-chart-pie'
        };

        function openModal(type, title, desc) {
            const modal = document.getElementById('simondaModal');
            const card = document.getElementById('modalCard');
            const modalTitle = document.getElementById('modalTitle');
            const modalDesc = document.getElementById('modalDesc');
            const modalIcon = document.getElementById('modalIcon');

            modalTitle.innerText = title;
            modalDesc.innerText = desc;
            
            // Set Icon
            modalIcon.className = `fa-solid ${iconMap[type] || 'fa-folder-open'}`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('simondaModal');
            const card = document.getElementById('modalCard');

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 250);
        }

        // Close on ESC or overlay click
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        document.getElementById('simondaModal').addEventListener('click', (e) => {
            if (e.target.id === 'simondaModal') closeModal();
        });
    </script>
</body>
</html>
