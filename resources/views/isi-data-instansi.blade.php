<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Data Instansi Vertikal dan Lainnya - SiMonDa Bukittinggi dalam Angka</title>
    
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

        /* Instansi Action Buttons */
        .btn-instansi {
            background-color: #f95a00;
            color: #ffffff;
            font-weight: 700;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.85rem 0.5rem;
            min-height: 3.75rem;
            line-height: 1.2;
            box-shadow: 0 4px 10px rgba(249, 90, 0, 0.22);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-instansi:hover {
            background-color: #e04e00;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 16px rgba(249, 90, 0, 0.35);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .btn-instansi:active {
            transform: translateY(0) scale(0.99);
        }

        /* Bottom HOME button */
        .btn-home-bottom {
            background-color: #f28538;
            color: #ffffff;
            font-weight: 700;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.85rem 0.5rem;
            min-height: 3.75rem;
            line-height: 1.2;
            box-shadow: 0 4px 10px rgba(242, 133, 56, 0.25);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-home-bottom:hover {
            background-color: #e07223;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 16px rgba(242, 133, 56, 0.38);
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
        <img src="/images/sensus-ribbon-watermark.png" alt="Sensus Ekonomi Ribbon Watermark" class="w-[900px] sm:w-[1200px] lg:w-[1400px] max-w-none transform -translate-x-16 sm:-translate-x-28 -translate-y-4 object-contain">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-between">
        
        <!-- HEADER / LOGO BAR -->
        <header class="w-full bg-[#f0f2f5] border-b border-slate-200/60 py-2 sm:py-2.5 px-4 sm:px-8 lg:px-12">
            <div class="max-w-7xl mx-auto flex flex-row items-center justify-between gap-4 md:gap-6 flex-wrap lg:flex-nowrap">
                
                <!-- Left: BPS Kota Bukittinggi Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2.5 transition-transform hover:scale-[1.02]">
                    <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-8 sm:h-9 md:h-10 w-auto object-contain">
                    <div class="flex flex-col justify-center leading-tight">
                        <span class="text-[11px] sm:text-xs md:text-sm font-black italic text-slate-900 tracking-tight uppercase font-sans">
                            BADAN PUSAT STATISTIK
                        </span>
                        <span class="text-[10px] sm:text-[11px] md:text-xs font-black italic text-slate-800 tracking-tight uppercase font-sans">
                            KOTA BUKITTINGGI
                        </span>
                    </div>
                </a>

                <!-- Center: Sensus Ekonomi 2026 Logo -->
                <div class="flex items-center justify-center transition-transform hover:scale-[1.02]">
                    <img src="{{ asset('images/sensus-ekonomi-clean.png') }}" alt="Sensus Ekonomi 2026" class="h-8 sm:h-9 md:h-10 w-auto object-contain">
                </div>

                <!-- Right: BerAKHLAK Logo -->
                <div class="flex items-center justify-end transition-transform hover:scale-[1.02]">
                    <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-8 sm:h-9 md:h-10 w-auto object-contain">
                </div>

            </div>
        </header>

        <!-- MAIN INSTANSI BUTTONS GRID (6 Columns x 7 Rows) -->
        <main class="max-w-[1400px] mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-6 flex-1 flex flex-col justify-center w-full">
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5 sm:gap-3 w-full">
                
                <!-- ROW 1 -->
                <button onclick="openInstansiModal('01', 'PERTANAHAN', 'Kantor Pertanahan Kota Bukittinggi (BPN)')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>01. PERTANAHAN</span>
                </button>

                <button onclick="openInstansiModal('02', 'KPUD', 'Komisi Pemilihan Umum Daerah (KPUD) Kota Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>02. KPUD</span>
                </button>

                <button onclick="openInstansiModal('03', 'KEMENAG', 'Kementerian Agama Kota Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>03. KEMENAG</span>
                </button>

                <button onclick="openInstansiModal('04', 'DINAS PENDIDIKAN PROV', 'Cabang Dinas Pendidikan Wilayah I Provinsi Sumatera Barat')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">04. DINAS<br>PENDIDIKAN PROV</span>
                </button>

                <button onclick="openInstansiModal('05', 'PGSD UNP', 'Program Studi PGSD Universitas Negeri Padang Kampus Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>05. PGSD UNP</span>
                </button>

                <button onclick="openInstansiModal('06', 'PSIKOLOGI UNP', 'Departemen Psikologi Universitas Negeri Padang Kampus Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>06. PSIKOLOGI UNP</span>
                </button>

                <!-- ROW 2 -->
                <button onclick="openInstansiModal('07', 'KEDOKTERAN UNP', 'Fakultas Kedokteran Universitas Negeri Padang Kampus Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11.5px] uppercase tracking-tight">
                    <span>07. KEDOKTERAN UNP</span>
                </button>

                <button onclick="openInstansiModal('08', 'AKBID BLABA', 'Akademi Kebidanan Bukittinggi (AKBID)')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>08. AKBID BLABA</span>
                </button>

                <button onclick="openInstansiModal('09', 'KEP. GIGI', 'Jurusan Keperawatan Gigi Poltekkes Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>09. KEP. GIGI</span>
                </button>

                <button onclick="openInstansiModal('10', 'STKIP AL HUSSUNAH', 'STKIP Al-Hussunah Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">10. STKIP<br>ALHUSSUNAH</span>
                </button>

                <button onclick="openInstansiModal('11', 'STIT AL HUSSUNAH', 'STIT Al-Hussunah Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">11. STIT<br>ALHUSSUNAH</span>
                </button>

                <button onclick="openInstansiModal('12', 'STIKES PERINTIS', 'STIKES Perintis Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11.5px] uppercase tracking-tight">
                    <span>12. STIKES PERINTIS</span>
                </button>

                <!-- ROW 3 -->
                <button onclick="openInstansiModal('13', 'STIKES PRIMA NUSANTARA', 'STIKES Prima Nusantara Bukittinggi')"
                        class="btn-instansi text-[9.5px] sm:text-[10.5px] uppercase tracking-tight">
                    <span class="leading-tight">13. STIKES PRIMA<br>NUSANTARA</span>
                </button>

                <button onclick="openInstansiModal('14', 'UNIV YARSI', 'Universitas Mohammad Natsir Yarsi Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>14. UNIV YARSI</span>
                </button>

                <button onclick="openInstansiModal('15', 'ITB HAS', 'Institut Teknologi dan Bisnis Haji Agus Salim')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>15. ITB HAS</span>
                </button>

                <button onclick="openInstansiModal('16', 'TEKNIK UM', 'Fakultas Teknik Universitas Muhammadiyah Sumatera Barat')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>16. TEKNIK UM</span>
                </button>

                <button onclick="openInstansiModal('17', 'HUKUM UM', 'Fakultas Hukum Universitas Muhammadiyah Sumatera Barat')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>17. HUKUM UM</span>
                </button>

                <button onclick="openInstansiModal('18', 'PARIWISATA UM', 'Fakultas Pariwisata Universitas Muhammadiyah Sumatera Barat')"
                        class="btn-instansi text-[10px] sm:text-[11.5px] uppercase tracking-tight">
                    <span>18. PARIWISATA UM</span>
                </button>

                <!-- ROW 4 -->
                <button onclick="openInstansiModal('19', 'KESEHATAN UM', 'Fakultas Kesehatan Universitas Muhammadiyah Sumatera Barat')"
                        class="btn-instansi text-[10px] sm:text-[11.5px] uppercase tracking-tight">
                    <span>19. KESEHATAN UM</span>
                </button>

                <button onclick="openInstansiModal('20', 'FARMASI IB', 'Akademi Farmasi Imam Bonjol Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>20. FARMASI IB</span>
                </button>

                <button onclick="openInstansiModal('21', 'UNIV FORD DE KOCK', 'Universitas Ford De Kock Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">21. UNIV FORD DE KOCK</span>
                </button>

                <button onclick="openInstansiModal('22', 'FARMASI DF', 'Akademi Farmasi Dwi Farma Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>22. FARMASI DF</span>
                </button>

                <button onclick="openInstansiModal('23', 'AKADEMI PARAMITA', 'Akademi Akuntansi Paramita Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">23. AKADEMI PARAMITA</span>
                </button>

                <button onclick="openInstansiModal('24', 'PUSTAKA BUNG HATTA', 'UPT Perpustakaan Proklamator Bung Hatta')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">24. PUSTAKA BUNG<br>HATTA</span>
                </button>

                <!-- ROW 5 -->
                <button onclick="openInstansiModal('25', 'PMI', 'Palang Merah Indonesia (PMI) Kota Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>25. PMI</span>
                </button>

                <button onclick="openInstansiModal('26', 'BPJS', 'BPJS Kesehatan / Ketenagakerjaan Cabang Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>26. BPJS</span>
                </button>

                <button onclick="openInstansiModal('27', 'PENGADILAN NEGRI', 'Pengadilan Negeri Kota Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">27. PENGADILAN<br>NEGRI</span>
                </button>

                <button onclick="openInstansiModal('28', 'KEJAKSAAN NEGERI', 'Kejaksaan Negeri Kota Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">28. KEJAKSAAN NEGERI</span>
                </button>

                <button onclick="openInstansiModal('29', 'PENGADILAN AGAMA', 'Pengadilan Agama Kota Bukittinggi')"
                        class="btn-instansi text-[10px] sm:text-[11px] uppercase tracking-tight">
                    <span class="leading-tight">29. PENGADILAN AGAMA</span>
                </button>

                <button onclick="openInstansiModal('30', 'POLRES', 'Kepolisian Resor (Polres) Kota Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>30. POLRES</span>
                </button>

                <!-- ROW 6 -->
                <button onclick="openInstansiModal('31', 'PLN', 'PT PLN (Persero) ULP Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>31. PLN</span>
                </button>

                <button onclick="openInstansiModal('32', 'PDAM', 'Perumda Air Minum Tirta Jam Gadang Kota Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>32. PDAM</span>
                </button>

                <button onclick="openInstansiModal('33', 'UPTD KANTOR PELAYANAN PENDAPATAN', 'UPTD Samsat / Pelayanan Pendapatan Daerah Bukittinggi')"
                        class="btn-instansi text-[9.5px] sm:text-[10px] uppercase tracking-tight">
                    <span class="leading-tight">33. UPTD KANTOR<br>PELAYANAN PENDAPATAN</span>
                </button>

                <button onclick="openInstansiModal('34', 'POS', 'PT Pos Indonesia (Persero) Kantor Pos Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>34. POS</span>
                </button>

                <button onclick="openInstansiModal('35', 'RRI', 'LPP Radio Republik Indonesia (RRI) Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>35. RRI</span>
                </button>

                <button onclick="openInstansiModal('36', 'TASPEN', 'PT TASPEN (Persero) Kantor Cabang Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>36. TASPEN</span>
                </button>

            </div>

            <!-- ROW 7 (Bottom Center: 37. BULOG & HOME under columns 3 and 4) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5 sm:gap-3 w-full mt-2.5 sm:mt-3">
                <div class="hidden lg:block"></div> <!-- Column 1 blank -->
                <div class="hidden lg:block"></div> <!-- Column 2 blank -->

                <!-- 37. BULOG -->
                <button onclick="openInstansiModal('37', 'BULOG', 'Perum BULOG Kantor Cabang Bukittinggi')"
                        class="btn-instansi text-[11px] sm:text-xs uppercase tracking-tight">
                    <span>37. BULOG</span>
                </button>

                <!-- HOME -->
                <a href="{{ route('home') }}"
                   class="btn-home-bottom text-[11px] sm:text-xs uppercase tracking-tight text-white no-underline">
                    <span>HOME</span>
                </a>

                <div class="hidden lg:block"></div> <!-- Column 5 blank -->
                <div class="hidden lg:block"></div> <!-- Column 6 blank -->
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

                    <form action="{{ route('logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari SiMonDa Bukittinggi?');">
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

    <!-- INSTANSI INPUT MODAL -->
    <div id="instansiModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100" id="instansiModalCard">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 rounded-2xl bg-orange-100 flex items-center justify-center text-[#f95a00] text-lg font-bold shadow-xs" id="instansiBadge">
                        01
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-orange-600">Pengisian Data Instansi Vertikal & Mitra</span>
                        <h3 id="instansiTitle" class="text-base sm:text-lg font-extrabold text-slate-900 leading-tight">PERTANAHAN</h3>
                        <p id="instansiSubtitle" class="text-xs text-slate-500 mt-0.5">Kantor Pertanahan Kota Bukittinggi</p>
                    </div>
                </div>
                <button onclick="closeInstansiModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-4 space-y-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Petugas / Kontak Person</label>
                    <input type="text" placeholder="Masukkan nama petugas..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-hidden bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Kontak / WhatsApp</label>
                    <input type="text" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-hidden bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Data</label>
                    <select class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-orange-500 focus:outline-hidden bg-slate-50 focus:bg-white cursor-pointer">
                        <option value="2026">Tahun 2026 (Tahun Berjalan)</option>
                        <option value="2025" selected>Tahun 2025</option>
                        <option value="2024">Tahun 2024</option>
                        <option value="2023">Tahun 2023</option>
                        <option value="2022">Tahun 2022</option>
                        <option value="2021">Tahun 2021</option>
                        <option value="2020">Tahun 2020</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Upload Berkas Data (Excel / PDF)</label>
                    <div class="border-2 border-dashed border-slate-300 hover:border-orange-400 rounded-2xl p-4 text-center cursor-pointer bg-slate-50 hover:bg-orange-50/50 transition-colors">
                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-[#f95a00] mb-1"></i>
                        <p class="text-xs font-bold text-slate-700">Pilih file atau seret berkas ke sini</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Format didukung: .xlsx, .xls, .pdf (Maks. 10MB)</p>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="bg-blue-50 border border-blue-200/80 rounded-xl p-3 flex items-start space-x-2 text-blue-800 text-xs">
                    <i class="fa-solid fa-circle-info text-blue-600 mt-0.5"></i>
                    <span>Data yang dikirim akan diverifikasi oleh tim kompilasi BPS Kota Bukittinggi.</span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                <!-- Unduh Format Dropdown (Excel & PDF) -->
                <div class="relative inline-block text-left" id="instansiExportDropdownContainer">
                    <button type="button" onclick="toggleInstansiExportDropdown()" 
                            class="py-2 px-3 rounded-xl text-xs font-bold text-slate-700 hover:text-orange-600 bg-slate-100 hover:bg-orange-50 border border-slate-200 hover:border-orange-200 transition-all flex items-center space-x-1.5 cursor-pointer">
                        <i class="fa-solid fa-file-export text-orange-600"></i>
                        <span>Unduh Format</span>
                        <i id="instansiExportChevron" class="fa-solid fa-chevron-up text-[9px] ml-0.5 transition-transform duration-200"></i>
                    </button>

                    <!-- Dropdown Content (Opens upward) -->
                    <div id="instansiExportDropdownMenu" 
                         class="hidden absolute left-0 bottom-full mb-2 w-64 origin-bottom-left rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 border border-slate-200/90 divide-y divide-slate-100 z-50 animate-in fade-in zoom-in-95 duration-150">
                        <div class="p-2.5 bg-slate-50 rounded-t-2xl border-b border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-extrabold text-slate-700 uppercase tracking-wider">Format Data Instansi</span>
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-orange-100 text-orange-700">SiMonDa</span>
                        </div>
                        <div class="p-1.5 space-y-1">
                            <!-- Excel (.xlsx) -->
                            <button onclick="alert('Mengunduh Template Kuesioner Excel (.xlsx)...'); closeInstansiExportDropdown();" 
                                    class="w-full text-left flex items-center space-x-2.5 p-2 rounded-xl hover:bg-emerald-50 transition-colors group cursor-pointer">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-[#107c41] group-hover:bg-[#107c41] group-hover:text-white flex items-center justify-center shrink-0 transition-colors shadow-2xs">
                                    <i class="fa-solid fa-file-excel text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-950">Format Excel (.xlsx)</span>
                                        <span class="text-[9px] font-mono font-bold text-emerald-700">.XLSX</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400">Template isian tabular</p>
                                </div>
                            </button>
                            <!-- PDF (.pdf) -->
                            <button onclick="alert('Mengunduh Blanko Kuesioner PDF (.pdf)...'); closeInstansiExportDropdown();" 
                                    class="w-full text-left flex items-center space-x-2.5 p-2 rounded-xl hover:bg-rose-50 transition-colors group cursor-pointer">
                                <div class="w-7 h-7 rounded-lg bg-rose-100 text-red-600 group-hover:bg-red-600 group-hover:text-white flex items-center justify-center shrink-0 transition-colors shadow-2xs">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-800 group-hover:text-rose-950">Blanko PDF (.pdf)</span>
                                        <span class="text-[9px] font-mono font-bold text-rose-700">.PDF</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400">Panduan & kuesioner resmi</p>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button onclick="closeInstansiModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition-colors">
                        Batal
                    </button>
                    <button onclick="alert('Data instansi berhasil disimpan/dikirim!'); closeInstansiModal();" class="px-5 py-2 bg-[#f95a00] hover:bg-[#e04e00] text-white font-bold rounded-xl text-xs shadow-md transition-all">
                        Simpan Data
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        function openInstansiModal(code, shortTitle, fullTitle) {
            const modal = document.getElementById('instansiModal');
            const card = document.getElementById('instansiModalCard');
            
            document.getElementById('instansiBadge').innerText = code;
            document.getElementById('instansiTitle').innerText = `${code}. ${shortTitle}`;
            document.getElementById('instansiSubtitle').innerText = fullTitle;

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

        function toggleInstansiExportDropdown() {
            const menu = document.getElementById('instansiExportDropdownMenu');
            const chevron = document.getElementById('instansiExportChevron');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (chevron) chevron.classList.add('-rotate-180');
            } else {
                closeInstansiExportDropdown();
            }
        }

        function closeInstansiExportDropdown() {
            const menu = document.getElementById('instansiExportDropdownMenu');
            const chevron = document.getElementById('instansiExportChevron');
            if (menu) menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('-rotate-180');
        }

        // Close on Escape or overlay click
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeInstansiExportDropdown();
                closeInstansiModal();
            }
        });

        document.addEventListener('click', (e) => {
            const container = document.getElementById('instansiExportDropdownContainer');
            if (container && !container.contains(e.target)) {
                closeInstansiExportDropdown();
            }
        });

        document.getElementById('instansiModal').addEventListener('click', (e) => {
            if (e.target.id === 'instansiModal') closeInstansiModal();
        });
    </script>
</body>
</html>
