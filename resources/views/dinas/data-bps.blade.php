<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data BPS - SiAngka Kota Bukittinggi</title>
    
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

        <!-- MAIN SECTION: LIST DATA BPS -->
        <main class="max-w-5xl mx-auto px-3 sm:px-6 lg:px-8 py-1.5 sm:py-2 flex-1 flex flex-col justify-center w-full min-h-0">

            <!-- White Card Container (Exact Match to isi-data-opd) -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3 sm:p-4 md:px-5 md:py-3.5 shadow-lg shadow-slate-200/30 w-full transition-all flex flex-col justify-between">
                
                <!-- Card Header: Title & Search Filter -->
                <div class="flex flex-row items-center justify-between gap-3 pb-2 sm:pb-3 border-b border-slate-100 shrink-0">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight">Data Internal BPS</h1>
                            <span class="hidden sm:inline-flex items-center text-[10px] font-extrabold text-[#f95a00] bg-orange-50 border border-orange-200 px-2 py-0.5 rounded-full">
                                10 Dataset Utama
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Katalog survei, sensus, dan publikasi statistik makro BPS Kota Bukittinggi</p>
                    </div>

                    <!-- Search Input Box (Pill shape with icon on right) -->
                    <div class="relative w-48 sm:w-64 flex items-center">
                        <input type="text"
                               id="bpsSearchInput"
                               oninput="handleSearchBps(this.value)"
                               placeholder="Cari data BPS..."
                               class="w-full bg-[#f8fafc] hover:bg-[#eef2f5] focus:bg-white border border-slate-200/90 focus:border-[#f95a00] rounded-full pl-4 pr-9 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/15 transition-all">
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400" style="top: 0; bottom: 0; right: 0;">
                            <i class="fa-solid fa-magnifying-glass text-xs leading-none"></i>
                        </div>
                        <button type="button" 
                                id="bpsClearSearch" 
                                onclick="clearBpsSearch()" 
                                class="hidden absolute right-8 inset-y-0 my-auto w-4 h-4 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center text-[9px] transition-colors cursor-pointer"
                                style="top: 0; bottom: 0; margin-top: auto; margin-bottom: auto;"
                                title="Hapus pencarian">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <!-- 2-Column Responsive Grid (10 Data Items matching OPD Style) -->
                <div id="bpsGrid" class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 mt-2.5 sm:mt-3">
                    
                    @php
                        $bpsDatasets = [
                            [
                                'code' => '01',
                                'key' => 'PODES',
                                'title' => 'PODES',
                                'subtitle' => 'Potensi Desa / Kelurahan',
                                'desc' => 'Pendataan lengkap sarana prasarana, fasilitas publik, ekonomi, dan potensi sosial seluruh kelurahan di Kota Bukittinggi.',
                                'search' => 'podes potensi desa kelurahan infrastruktur',
                                'icon' => 'fa-house-chimney-window',
                                'link' => 'https://drive.google.com/drive/folders/1uLHQDuVkwwkqmPiDzCbpkmGGmZ8YBDep'
                            ],
                            [
                                'code' => '02',
                                'key' => 'PENDUDUK',
                                'title' => 'PENDUDUK',
                                'subtitle' => 'Statistik Kependudukan & Proyeksi',
                                'desc' => 'Jumlah penduduk, laju pertumbuhan, kepadatan, rasio jenis kelamin, dan proyeksi kependudukan Kota Bukittinggi.',
                                'search' => 'penduduk demografi sensus piramida kelamin',
                                'icon' => 'fa-users',
                                'link' => 'https://drive.google.com/drive/folders/1DZR2cpVOCLSqDVwzM3iFKDBVctyM5HxS'
                            ],
                            [
                                'code' => '03',
                                'key' => 'SUSENAS',
                                'title' => 'SUSENAS',
                                'subtitle' => 'Survei Sosial Ekonomi Nasional',
                                'desc' => 'Indikator kesejahteraan rakyat, pengeluaran konsumsi pangan/non-pangan, kemiskinan, dan Indeks Pembangunan Manusia (IPM).',
                                'search' => 'susenas sosial ekonomi konsumsi kemiskinan ipm',
                                'icon' => 'fa-chart-pie',
                                'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                            ],
                            [
                                'code' => '04',
                                'key' => 'SAKERNAS',
                                'title' => 'SAKERNAS',
                                'subtitle' => 'Survei Angkatan Kerja Nasional',
                                'desc' => 'Tingkat Pengangguran Terbuka (TPT), Tingkat Partisipasi Angkatan Kerja (TPAK), dan struktur lapangan pekerjaan masyarakat.',
                                'search' => 'sakernas tenaga kerja angkatan pengangguran tpak tpt',
                                'icon' => 'fa-briefcase',
                                'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                            ],
                            [
                                'code' => '05',
                                'key' => 'HORTI',
                                'title' => 'HORTI',
                                'subtitle' => 'Statistik Pertanian & Hortikultura',
                                'desc' => 'Data produksi dan luas panen komoditas hortikultura: sayuran, buah-buahan, tanaman obat/biofarmaka, dan tanaman hias.',
                                'search' => 'horti pertanian hortikultura sayur buah tanaman panen',
                                'icon' => 'fa-seedling',
                                'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                            ],
                            [
                                'code' => '06',
                                'key' => 'IMK',
                                'title' => 'IMK',
                                'subtitle' => 'Industri Mikro dan Kecil',
                                'desc' => 'Profil dan pertumbuhan usaha industri manufaktur mikro & kecil, penyerapan tenaga kerja, dan nilai tambah output usaha.',
                                'search' => 'imk industri mikro kecil usaha kerajinan olahan umkm',
                                'icon' => 'fa-industry',
                                'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                            ],
                            [
                                'code' => '07',
                                'key' => 'HOTEL',
                                'title' => 'HOTEL',
                                'subtitle' => 'Statistik Perhotelan & Pariwisata',
                                'desc' => 'Tingkat Penghunian Kamar (TPK) hotel berbintang & non-bintang, jumlah tamu menginap nusantara maupun mancanegara.',
                                'search' => 'hotel pariwisata akomodasi tpk kamar tamu turis wisatawan',
                                'icon' => 'fa-hotel',
                                'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                            ],
                            [
                                'code' => '08',
                                'key' => 'IHK',
                                'title' => 'IHK & INFLASI',
                                'subtitle' => 'Indeks Harga Konsumen / Inflasi',
                                'desc' => 'Perkembangan tingkat inflasi bulanan (m-to-m), tahunan (y-on-y), serta pemantauan harga komoditas utama pembentuk inflasi.',
                                'search' => 'ihk inflasi harga konsumen pasar sembako',
                                'icon' => 'fa-money-bill-trend-up',
                                'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                            ],
                            [
                                'code' => '09',
                                'key' => 'PDRB LAPUS',
                                'title' => 'PDRB LAPANGAN USAHA',
                                'subtitle' => 'PDRB Menurut Lapangan Usaha',
                                'desc' => 'Produk Domestik Regional Bruto berdasarkan 17 lapangan usaha (ADHB & ADHK) dan laju pertumbuhan ekonomi daerah.',
                                'search' => 'pdrb lapus lapangan usaha ekonomi pertumbuhan adhb adhk pdrb',
                                'icon' => 'fa-chart-simple',
                                'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                            ],
                            [
                                'code' => '10',
                                'key' => 'PDRB PENGELUARAN',
                                'title' => 'PDRB PENGELUARAN',
                                'subtitle' => 'PDRB Menurut Pengeluaran',
                                'desc' => 'Agregat PDRB sisi pengeluaran: Konsumsi Rumah Tangga, PMTB (Investasi), Konsumsi Pemerintah, serta Ekspor-Impor.',
                                'search' => 'pdrb pengeluaran konsumsi investasi pmtb rumah tangga belanja',
                                'icon' => 'fa-wallet',
                                'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                            ],
                        ];
                    @endphp

                    @foreach($bpsDatasets as $ds)
                        <button type="button"
                                onclick="openBpsModal('{{ $ds['key'] }}', '{{ $ds['title'] }}', '{{ $ds['subtitle'] }}', '{{ $ds['desc'] }}', '{{ $ds['link'] }}')"
                                data-search="{{ $ds['code'] }} {{ strtolower($ds['title']) }} {{ strtolower($ds['subtitle']) }} {{ $ds['search'] }}"
                                class="bps-item group w-full bg-white hover:bg-orange-50/40 border border-slate-100 hover:border-orange-300 rounded-2xl p-2.5 sm:p-3 flex items-center justify-between shadow-2xs hover:shadow-xs transition-all duration-150 text-left cursor-pointer">
                            <div class="flex items-center space-x-2.5 sm:space-x-3.5 min-w-0">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-[#fff4eb] text-[#f95a00] flex items-center justify-center text-sm sm:text-base shrink-0 group-hover:scale-105 transition-transform">
                                    <i class="fa-solid {{ $ds['icon'] }}"></i>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 leading-tight">{{ $ds['code'] }}</span>
                                        <span class="text-xs sm:text-[13px] font-bold text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight">{{ $ds['title'] }}</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-medium leading-tight line-clamp-1 mt-0.5">{{ $ds['subtitle'] }}</span>
                                </div>
                            </div>
                            <div class="w-6 h-6 rounded-full bg-orange-100/70 group-hover:bg-[#f95a00] text-orange-500 group-hover:text-white flex items-center justify-center text-[9px] shrink-0 ml-1.5 transition-all group-hover:translate-x-0.5">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </button>
                    @endforeach

                </div>

                <!-- Empty State When Search Result Not Found -->
                <div id="bpsEmptyState" class="hidden py-8 text-center">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 mx-auto flex items-center justify-center text-lg mb-2 shadow-xs">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-800">Data BPS Tidak Ditemukan</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5 max-w-sm mx-auto">Tidak ada survei atau sensus BPS yang cocok dengan kata kunci pencarian Anda.</p>
                    <button onclick="clearBpsSearch()" class="mt-2 px-3 py-1 rounded-lg bg-orange-100 text-orange-700 font-bold text-xs hover:bg-orange-200 transition-colors">
                        Reset Pencarian
                    </button>
                </div>

                <!-- Card Footer Actions: Google Drive & Home (Matching OPD style) -->
                <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 mt-3 pt-2.5 border-t border-slate-100 shrink-0">

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
                
                <!-- Info Pengguna yang Sedang Login & Tombol Logout -->
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-white/60 hover:bg-white/80 border border-slate-200/80 shadow-xs transition-all backdrop-blur-xs">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[9px] shadow-xs shrink-0" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
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

    <!-- DATA BPS INTERACTIVE MODAL DIALOG (Matching OPD Style) -->
    <div id="bpsModal" class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-4 md:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-2xl sm:rounded-3xl max-w-lg w-full p-5 sm:p-6 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative overflow-hidden" id="bpsModalCard">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-[#f95a00] text-lg font-bold shadow-xs">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-orange-600 block">Katalog Data BPS</span>
                        <h3 id="bpsModalTitle" class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight">PODES</h3>
                        <p id="bpsModalSubtitle" class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">Potensi Desa / Kelurahan</p>
                    </div>
                </div>
                <button onclick="closeBpsModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="space-y-3">
                <p id="bpsModalDesc" class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-200/70">
                    Deskripsi rincian data survei / sensus BPS Kota Bukittinggi.
                </p>

                <!-- Status Pengelolaan -->
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="bg-orange-50/60 border border-orange-200/60 rounded-xl p-2.5">
                        <span class="text-slate-500 text-[10px] block">Tahun Publikasi:</span>
                        <span class="font-bold text-orange-950 text-xs">{{ date('Y') }}</span>
                    </div>
                    <div class="bg-emerald-50/60 border border-emerald-200/60 rounded-xl p-2.5">
                        <span class="text-slate-500 text-[10px] block">Status Verifikasi:</span>
                        <span class="font-bold text-emerald-700 flex items-center gap-1 text-xs">
                            <i class="fa-solid fa-circle-check text-[11px]"></i> Resmi BPS
                        </span>
                    </div>
                </div>

                <!-- Export & Access Actions -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                        <span>Pilihan Akses & Unduh Format</span>
                        <span class="text-[10px] text-orange-600 font-bold uppercase tracking-wider">Format Resmi</span>
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <!-- Option 1: Excel (.xlsx) -->
                        <button onclick="alert('Mengunduh berkas tabel Excel (.xlsx) ' + currentDatasetTitle + '...');"
                                class="p-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100/90 text-emerald-900 font-bold text-xs transition-all flex items-center space-x-2 border border-emerald-200/80 group cursor-pointer shadow-2xs">
                            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 text-xs shadow-2xs group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-file-excel"></i>
                            </div>
                            <div class="text-left flex-1 min-w-0">
                                <span class="block font-bold text-[11px] text-slate-800 group-hover:text-emerald-950 leading-tight">Excel (.xlsx)</span>
                                <span class="block text-[9.5px] text-slate-500 font-normal">Tabel Data</span>
                            </div>
                        </button>

                        <!-- Option 2: PDF (.pdf) -->
                        <button onclick="alert('Mengunduh publikasi resmi PDF (.pdf) ' + currentDatasetTitle + '...');"
                                class="p-2.5 rounded-xl bg-rose-50 hover:bg-rose-100/90 text-rose-900 font-bold text-xs transition-all flex items-center space-x-2 border border-rose-200/80 group cursor-pointer shadow-2xs">
                            <div class="w-7 h-7 rounded-lg bg-red-600 text-white flex items-center justify-center shrink-0 text-xs shadow-2xs group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div class="text-left flex-1 min-w-0">
                                <span class="block font-bold text-[11px] text-slate-800 group-hover:text-rose-950 leading-tight">PDF (.pdf)</span>
                                <span class="block text-[9.5px] text-slate-500 font-normal">Publikasi BPS</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Google Drive Direct Link -->
                <div id="driveBtnContainer">
                    <a id="bpsDriveLink" 
                       href="#" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="w-full py-2 px-3 rounded-xl bg-slate-100 hover:bg-orange-50 hover:border-orange-200 text-slate-700 hover:text-orange-700 font-bold text-xs transition-colors flex items-center justify-center space-x-2 border border-slate-200 cursor-pointer">
                        <i class="fa-brands fa-google-drive text-amber-600 text-xs"></i>
                        <span>Buka Folder Google Drive Dataset Ini</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-0.5"></i>
                    </a>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button onclick="closeBpsModal()" class="px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition-colors cursor-pointer">
                    Tutup
                </button>
                <button onclick="alert('Dataset ' + currentDatasetTitle + ' siap diekspor / digunakan.'); closeBpsModal();" class="px-4 py-1.5 bg-[#f95a00] hover:bg-[#e04e00] text-white font-bold rounded-xl text-xs shadow-xs hover:shadow-md transition-all cursor-pointer">
                    Akses Data
                </button>
            </div>

        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        let currentDatasetKey = '';
        let currentDatasetTitle = '';

        // Search and filter BPS cards
        function handleSearchBps(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.bps-item');
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

            const emptyState = document.getElementById('bpsEmptyState');
            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }

            const clearBtn = document.getElementById('bpsClearSearch');
            if (clearBtn) {
                if (q) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }
        }

        function clearBpsSearch() {
            const input = document.getElementById('bpsSearchInput');
            if (input) {
                input.value = '';
                handleSearchBps('');
                input.focus();
            }
        }

        function openBpsModal(key, title, subtitle, desc, link) {
            currentDatasetKey = key;
            currentDatasetTitle = title;

            document.getElementById('bpsModalTitle').innerText = title;
            document.getElementById('bpsModalSubtitle').innerText = subtitle;
            document.getElementById('bpsModalDesc').innerText = desc;

            const driveLink = document.getElementById('bpsDriveLink');
            if (link && link.trim() !== '') {
                driveLink.href = link;
                driveLink.classList.remove('pointer-events-none', 'opacity-50');
            } else {
                driveLink.href = 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-';
            }

            const modal = document.getElementById('bpsModal');
            const card = document.getElementById('bpsModalCard');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeBpsModal() {
            const modal = document.getElementById('bpsModal');
            const card = document.getElementById('bpsModalCard');

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
                closeBpsModal();
            }
        });

        const bpsModalEl = document.getElementById('bpsModal');
        if (bpsModalEl) {
            bpsModalEl.addEventListener('click', (e) => {
                if (e.target.id === 'bpsModal') closeBpsModal();
            });
        }
    </script>
</body>
</html>
