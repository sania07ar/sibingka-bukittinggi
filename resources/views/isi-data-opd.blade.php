<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Data OPD - SiMonDa Bukittinggi dalam Angka</title>
    
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
<body class="min-h-screen text-slate-800 antialiased flex flex-col justify-between selection:bg-orange-500 selection:text-white bg-[#f0f2f5] relative overflow-x-hidden">

    <!-- Background Sensus Ekonomi Ribbon Watermark (Exact Match to Mockup) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-35">
        <img src="/images/sensus-ribbon-watermark.png" alt="Sensus Ekonomi Ribbon Watermark" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-16 sm:-translate-x-32 -translate-y-6 object-contain">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-between">
        
        <!-- HEADER / LOGO BAR -->
        <header class="w-full bg-[#f0f2f5] border-b border-slate-200/60 py-2.5 sm:py-3 px-4 sm:px-8 lg:px-12">
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

        <!-- MAIN OPD BUTTONS GRID -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-6 sm:py-8 flex-1 flex flex-col justify-center w-full">
            
            <!-- 20 OPD Buttons (4 Columns x 5 Rows) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4.5 w-full">
                
                <!-- 01. DINAS PUPR -->
                <button onclick="openOpdModal('01', 'DINAS PUPR', 'Dinas Pekerjaan Umum dan Penataan Ruang')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>01. DINAS PUPR</span>
                </button>

                <button onclick="openOpdModal('02', 'DINAS PMPTSP', 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>02. DINAS PMPTSP</span>
                </button>

                <button onclick="openOpdModal('03', 'DPRD KOTA BUKITTINGGI', 'Dewan Perwakilan Rakyat Daerah Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>03. DPRD KOTA BUKITTINGGI</span>
                </button>

                <button onclick="openOpdModal('04', 'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SDM', 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia')"
                        class="btn-opd text-[11px] sm:text-xs md:text-[12.5px] uppercase tracking-tight">
                    <span class="leading-tight">04. BADAN KEPEGAWAIAN<br>DAN PENGEMBANGAN SDM</span>
                </button>

                <!-- ROW 2 -->
                <button onclick="openOpdModal('05', 'BADAN KEUANGAN', 'Badan Keuangan Daerah Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>05. BADAN KEUANGAN</span>
                </button>

                <button onclick="openOpdModal('06', 'DISDUKCAPIL', 'Dinas Kependudukan dan Pencatatan Sipil')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>06. DISDUKCAPIL</span>
                </button>

                <button onclick="openOpdModal('07', 'DINAS KOPERASI, UKM DAN TENAGA KERJA', 'Dinas Koperasi, Usaha Kecil Menengah dan Tenaga Kerja')"
                        class="btn-opd text-[11px] sm:text-xs md:text-[12.5px] uppercase tracking-tight">
                    <span class="leading-tight">07. DINAS KOPERASI, UKM<br>DAN TENAGA KERJA</span>
                </button>

                <button onclick="openOpdModal('08', 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 'Dinas Pendidikan dan Kebudayaan Kota Bukittinggi')"
                        class="btn-opd text-[11px] sm:text-xs md:text-[12.5px] uppercase tracking-tight">
                    <span class="leading-tight">08. DINAS PENDIDIKAN DAN<br>KEBUDAYAAN</span>
                </button>

                <!-- ROW 3 -->
                <button onclick="openOpdModal('09', 'BADAN PENANGGULAN BENCANA DAERAH', 'Badan Penanggulangan Bencana Daerah (BPBD)')"
                        class="btn-opd text-[11px] sm:text-xs md:text-[12.5px] uppercase tracking-tight">
                    <span class="leading-tight">09. BADAN PENANGGULAN<br>BENCANA DAERAH</span>
                </button>

                <button onclick="openOpdModal('10', 'DINAS PEMUDA DAN OLAHRAGA', 'Dinas Pemuda dan Olahraga Kota Bukittinggi')"
                        class="btn-opd text-[11px] sm:text-xs md:text-[12.5px] uppercase tracking-tight">
                    <span class="leading-tight">10. DINAS PEMUDA DAN<br>OLAHRAGA</span>
                </button>

                <button onclick="openOpdModal('11', 'DINAS PERPUSTAKAAN DAN KEARSIPAN', 'Dinas Perpustakaan dan Kearsipan Kota Bukittinggi')"
                        class="btn-opd text-[11px] sm:text-xs md:text-[12.5px] uppercase tracking-tight">
                    <span class="leading-tight">11. DINAS PERPUSTAKAAN<br>DAN KEARSIPAN</span>
                </button>

                <button onclick="openOpdModal('12', 'DINAS KESEHATAN', 'Dinas Kesehatan Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>12. DINAS KESEHATAN</span>
                </button>

                <!-- ROW 4 -->
                <button onclick="openOpdModal('13', 'DINAS LINGKUNGAN HIDUP', 'Dinas Lingkungan Hidup Kota Bukittinggi')"
                        class="btn-opd text-[11px] sm:text-xs md:text-[12.5px] uppercase tracking-tight">
                    <span class="leading-tight">13. DINAS LINGKUNGAN<br>HIDUP</span>
                </button>

                <button onclick="openOpdModal('14', 'DINAS P3APPKB', 'Dinas Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>14. DINAS P3APPKB</span>
                </button>

                <button onclick="openOpdModal('15', 'DINAS KEBAKARAN', 'Dinas Kebakaran Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>15. DINAS KEBAKARAN</span>
                </button>

                <button onclick="openOpdModal('16', 'DINAS SOSIAL', 'Dinas Sosial Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>16. DINAS SOSIAL</span>
                </button>

                <!-- ROW 5 -->
                <button onclick="openOpdModal('17', 'DINAS PERTANIAN', 'Dinas Pertanian Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>17. DINAS PERTANIAN</span>
                </button>

                <button onclick="openOpdModal('18', 'DINAS PERDAGANGAN', 'Dinas Perdagangan Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>18. DINAS PERDAGANGAN</span>
                </button>

                <button onclick="openOpdModal('19', 'DINAS PARIWISATA', 'Dinas Pariwisata Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>19. DINAS PARIWISATA</span>
                </button>

                <button onclick="openOpdModal('20', 'DINAS PERHUBUNGAN', 'Dinas Perhubungan Kota Bukittinggi')"
                        class="btn-opd text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight">
                    <span>20. DINAS PERHUBUNGAN</span>
                </button>

            </div>

            <!-- ROW 6: BLANKO PDF & HOME (Centered under columns 2 and 3) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4.5 w-full mt-3.5 sm:mt-4.5">
                <div class="hidden lg:block"></div> <!-- Empty space under column 1 -->
                
                <!-- BLANKO PDF (Google Drive) -->
                <a href="https://drive.google.com/drive/folders/1ytU-i5aTt7-94u2jiNefX8Ef0Hqr3_5E"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn-opd-bottom text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight text-white no-underline"
                   title="Buka Folder Google Drive Blanko PDF">
                    <span>BLANKO PDF</span>
                </a>

                <!-- HOME -->
                <a href="{{ url('/') }}"
                   class="btn-opd-bottom text-xs sm:text-[13px] md:text-[13.5px] uppercase tracking-tight text-white no-underline">
                    <span>HOME</span>
                </a>

                <div class="hidden lg:block"></div> <!-- Empty space under column 4 -->
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
                <div class="relative">
                    <input type="text"
                           id="tabelSearchInput"
                           oninput="handleSearchTable(this.value)"
                           placeholder="Cari tabel..."
                           class="w-full bg-[#f4f6f8] hover:bg-[#eef2f5] focus:bg-white border border-transparent focus:border-amber-400 rounded-xl pl-4 pr-10 py-2.5 text-xs sm:text-sm text-slate-700 placeholder-slate-400 focus:outline-none transition-all">
                    <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-[#f98825]">
                        <i class="fa-solid fa-magnifying-glass text-xs sm:text-sm"></i>
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
                { code: '8.1.4', title: 'Banyak dan Panjang Jembatan, Panjang Trotoar di Kota Bukittinggi', titleEn: 'Number and Length of Bridges, Length of Sidewalks in Bukittinggi Municipality' },
                { code: '8.1.5', title: 'Panjang Gorong-Gorong dan Panjang Drainase di Kota Bukittinggi', titleEn: 'Length of Culverts and Length of Drainage in Bukittinggi Municipality' }
            ],
            '02': [
                { code: '2.1.1', title: 'Jumlah Izin Usaha yang Diterbitkan Menurut Sektor Usaha di Kota Bukittinggi', titleEn: 'Number of Business Licenses Issued by Business Sector in Bukittinggi Municipality' },
                { code: '2.1.2', title: 'Nilai Realisasi Investasi PMDN dan PMA Menurut Sektor di Kota Bukittinggi', titleEn: 'Value of Domestic and Foreign Investment Realization by Sector in Bukittinggi Municipality' },
                { code: '2.1.3', title: 'Jumlah Proyek Investasi dan Penyerapan Tenaga Kerja Menurut Kecamatan', titleEn: 'Number of Investment Projects and Labor Absorption by Subdistrict' },
                { code: '2.1.4', title: 'Jumlah Izin Non-Usaha dan Layanan Pengaduan Berizin yang Diselesaikan', titleEn: 'Number of Non-Business Licenses and Resolved Complaints' }
            ],
            '03': [
                { code: '3.2.1', title: 'Jumlah Keputusan dan Peraturan Daerah yang Ditetapkan DPRD Kota Bukittinggi', titleEn: 'Number of Decrees and Regional Regulations Stipulated by the Regional House of Representatives' },
                { code: '3.2.2', title: 'Jumlah Rapat Paripurna dan Rapat Dengar Pendapat DPRD Kota Bukittinggi', titleEn: 'Number of Plenary Sessions and Hearings of the Regional House of Representatives' }
            ],
            '04': [
                { code: '4.1.1', title: 'Jumlah Pegawai Negeri Sipil Menurut Tingkat Pendidikan dan Golongan', titleEn: 'Number of Civil Servants by Educational Level and Hierarchy Group' },
                { code: '4.1.2', title: 'Jumlah Aparatur Sipil Negara Menurut Perangkat Daerah dan Jenis Kelamin', titleEn: 'Number of State Civil Apparatus by Regional Apparatus and Sex' }
            ],
            '05': [
                { code: '5.1.1', title: 'Realisasi Pendapatan Asli Daerah (PAD) Kota Bukittinggi Menurut Jenis Pajak', titleEn: 'Realization of Regional Original Income (PAD) of Bukittinggi Municipality by Tax Type' },
                { code: '5.1.2', title: 'Realisasi Belanja Langsung dan Tidak Langsung Pemerintah Kota Bukittinggi', titleEn: 'Realization of Direct and Indirect Expenditures of Bukittinggi Municipality Government' }
            ],
            '06': [
                { code: '3.1.1', title: 'Jumlah Penduduk, Kepadatan Penduduk, dan Rasio Jenis Kelamin Menurut Kecamatan', titleEn: 'Population, Population Density, and Sex Ratio by Subdistrict' },
                { code: '3.1.2', title: 'Jumlah Penerbitan KTP Elektronik, KIA, dan Kartu Keluarga Menurut Kecamatan', titleEn: 'Number of Issuances of Electronic KTP, KIA, and Family Cards by Subdistrict' },
                { code: '3.1.3', title: 'Jumlah Kelahiran dan Kematian Menurut Jenis Kelamin dan Kecamatan', titleEn: 'Number of Births and Deaths by Sex and Subdistrict' }
            ],
            '07': [
                { code: '7.1.1', title: 'Jumlah Koperasi Aktif dan Tidak Aktif Menurut Jenis Koperasi di Kota Bukittinggi', titleEn: 'Number of Active and Inactive Cooperatives by Type in Bukittinggi Municipality' },
                { code: '7.1.2', title: 'Jumlah Usaha Mikro, Kecil, dan Menengah (UMKM) Binaan Menurut Sektor', titleEn: 'Number of Fostered MSMEs by Sector' },
                { code: '7.2.1', title: 'Jumlah Pencari Kerja Terdaftar (AK-1) Menurut Tingkat Pendidikan', titleEn: 'Number of Registered Job Seekers (AK-1) by Educational Level' }
            ],
            '08': [
                { code: '4.2.1', title: 'Jumlah Sekolah, Guru, dan Murid Jenjang TK, SD, dan SMP di Kota Bukittinggi', titleEn: 'Number of Schools, Teachers, and Pupils of Kindergarten, Primary, and Junior High Schools' },
                { code: '4.2.2', title: 'Angka Partisipasi Murni (APM) dan Angka Partisipasi Kasar (APK) Menurut Jenjang', titleEn: 'Net Enrollment Rate (NER) and Gross Enrollment Rate (GER) by Level' },
                { code: '4.2.3', title: 'Jumlah Cagar Budaya dan Sanggar Seni Terdaftar di Kota Bukittinggi', titleEn: 'Number of Cultural Heritage and Art Studios Registered in Bukittinggi Municipality' }
            ],
            '09': [
                { code: '1.2.1', title: 'Jumlah Kejadian Bencana Alam dan Nilai Kerugian Menurut Jenis Bencana', titleEn: 'Number of Natural Disaster Occurrences and Loss Values by Type of Disaster' },
                { code: '1.2.2', title: 'Jumlah Korban Terdampak Bencana dan Titik Evakuasi Menurut Kecamatan', titleEn: 'Number of Victims Affected by Disasters and Evacuation Points by Subdistrict' }
            ],
            '10': [
                { code: '5.3.1', title: 'Jumlah Sarana Olahraga dan Organisasi Kepemudaan Terdaftar di Kota Bukittinggi', titleEn: 'Number of Sports Facilities and Youth Organizations Registered in Bukittinggi Municipality' },
                { code: '5.3.2', title: 'Prestasi Atlet dan Kontingen Kota Bukittinggi pada Kejurda/Porprov', titleEn: 'Achievements of Bukittinggi Athletes and Contingents in Championships/Porprov' }
            ],
            '11': [
                { code: '4.3.1', title: 'Jumlah Pengunjung Perpustakaan Daerah dan Jumlah Koleksi Buku Menurut Jenis', titleEn: 'Number of Regional Library Visitors and Book Collections by Type' },
                { code: '4.3.2', title: 'Tingkat Gemar Membaca (TGM) Masyarakat Kota Bukittinggi', titleEn: 'Reading Interest Level (TGM) of Bukittinggi Municipality Community' }
            ],
            '12': [
                { code: '4.4.1', title: 'Jumlah Rumah Sakit, Puskesmas, Pustu, dan Posyandu di Kota Bukittinggi', titleEn: 'Number of Hospitals, Public Health Centers, and Integrated Healthcare Posts' },
                { code: '4.4.2', title: 'Jumlah Dokter, Bidan, Perawat, dan Tenaga Kesehatan Lainnya di Kota Bukittinggi', titleEn: 'Number of Doctors, Midwives, Nurses, and Other Health Personnel' },
                { code: '4.4.3', title: 'Prevalensi Balita Stunting dan Cakupan Imunisasi Lengkap Menurut Puskesmas', titleEn: 'Prevalence of Stunted Toddlers and Complete Immunization Coverage by Puskesmas' }
            ],
            '13': [
                { code: '1.3.1', title: 'Volume Timbulan Sampah Harian dan Jumlah Sampah Terangkut ke TPA', titleEn: 'Daily Waste Generation Volume and Amount of Waste Transported to Landfill' },
                { code: '1.3.2', title: 'Luas Ruang Terbuka Hijau (RTH) Menurut Jenis dan Lokasi di Kota Bukittinggi', titleEn: 'Area of Green Open Space (RTH) by Type and Location in Bukittinggi Municipality' }
            ],
            '14': [
                { code: '3.3.1', title: 'Jumlah Kasus Kekerasan terhadap Perempuan dan Anak yang Ditangani', titleEn: 'Number of Handled Cases of Violence Against Women and Children' },
                { code: '3.3.2', title: 'Jumlah Pasangan Usia Subur (PUS) dan Peserta KB Aktif Menurut Metode Kontrasepsi', titleEn: 'Number of Eligible Couples (PUS) and Active Family Planning Participants by Contraceptive Method' }
            ],
            '15': [
                { code: '1.4.1', title: 'Jumlah Kejadian Kebakaran dan Nilai Kerugian Menurut Penyebab dan Kecamatan', titleEn: 'Number of Fire Incidents and Loss Values by Cause and Subdistrict' },
                { code: '1.4.2', title: 'Response Time Penanganan Kebakaran dan Armada Pemadam yang Beroperasi', titleEn: 'Response Time for Fire Fighting and Operating Fire Fleets' }
            ],
            '16': [
                { code: '4.5.1', title: 'Jumlah Pemerlu Pelayanan Kesejahteraan Sosial (PPKS) Menurut Kategori', titleEn: 'Number of Persons in Need of Social Welfare Services (PPKS) by Category' },
                { code: '4.5.2', title: 'Realisasi Bantuan Sosial (PKH, BPNT, dan Bansos APBD) Menurut Kecamatan', titleEn: 'Realization of Social Assistance (PKH, BPNT, and Regional Budget Assistance) by Subdistrict' }
            ],
            '17': [
                { code: '5.4.1', title: 'Luas Panen, Produksi, dan Produktivitas Tanaman Padi dan Palawija di Kota Bukittinggi', titleEn: 'Harvested Area, Production, and Productivity of Paddy and Secondary Crops in Bukittinggi' },
                { code: '5.4.2', title: 'Populasi Ternak Sapi, Kambing, dan Unggas Menurut Kecamatan di Kota Bukittinggi', titleEn: 'Livestock Population of Cattle, Goats, and Poultry by Subdistrict' }
            ],
            '18': [
                { code: '5.5.1', title: 'Perkembangan Harga Rata-rata Bahan Pokok dan Barang Penting di Pasar Tradisional', titleEn: 'Development of Average Prices of Staple Goods and Essential Commodities in Traditional Markets' },
                { code: '5.5.2', title: 'Jumlah Pasar Rakyat, Toko Modern, dan Pedagang Kaki Lima Terdaftar', titleEn: 'Number of Public Markets, Modern Stores, and Registered Street Vendors' }
            ],
            '19': [
                { code: '5.6.1', title: 'Jumlah Kunjungan Wisatawan Nusantara dan Mancanegara ke Objek Wisata Kota Bukittinggi', titleEn: 'Number of Domestic and Foreign Tourist Visits to Tourist Objects in Bukittinggi' },
                { code: '5.6.2', title: 'Tingkat Penghunian Kamar (TPK) Hotel dan Penginapan di Kota Bukittinggi', titleEn: 'Room Occupancy Rate (ROR) of Hotels and Accommodations in Bukittinggi Municipality' }
            ],
            '20': [
                { code: '6.2.1', title: 'Jumlah Kendaraan Wajib Uji Berkala (KIR) yang Lulus Uji di Kota Bukittinggi', titleEn: 'Number of Periodic Inspection-Mandatory Vehicles (KIR) Passing the Test in Bukittinggi' },
                { code: '6.2.2', title: 'Jumlah Rambu Lalu Lintas, APILL, dan Fasilitas Keselamatan Jalan', titleEn: 'Number of Traffic Signs, Traffic Signals, and Road Safety Facilities' }
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
            const endYear = Math.max(2026, currentYear + 1);

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
    </script>
</body>
</html>
