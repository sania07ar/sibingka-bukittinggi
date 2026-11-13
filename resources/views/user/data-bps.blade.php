<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Internal BPS - SiBingka Kota Bukittinggi</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- Master Tables Catalog (OPD, Instansi, & BPS) -->
    <script src="{{ asset('sibingka-catalogs.js') }}"></script>

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

    <!-- Background SiBingka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-20 select-none">
        <img src="{{ asset('images/sibingka-watermark-jamgadang.jpg') }}" alt="Watermark SiBingka Jam Gadang" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-16 sm:-translate-x-28 -translate-y-6 object-contain mix-blend-multiply">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="relative z-10 flex-1 flex flex-col justify-between h-full min-h-0">
        
        <!-- HEADER / LOGO BAR -->
        @include('partials.navbar')

        <!-- MAIN SECTION: LIST DATA BPS -->
        <main class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 py-1.5 sm:py-2 flex-1 flex flex-col justify-center w-full min-h-0">

            @php
                $userRole = session('user.role');
                $isAdmin = $userRole === 'admin';

                $bpsDatasets = [
                    [
                        'code' => '01',
                        'short' => 'PODES',
                        'full' => 'Potensi Desa / Kelurahan',
                        'desc' => 'Pendataan lengkap sarana prasarana, fasilitas publik, ekonomi, dan potensi sosial seluruh kelurahan di Kota Bukittinggi.',
                        'search' => '01 podes potensi desa kelurahan infrastruktur',
                        'icon' => 'fa-house-chimney-window',
                        'link' => 'https://drive.google.com/drive/folders/1uLHQDuVkwwkqmPiDzCbpkmGGmZ8YBDep'
                    ],
                    [
                        'code' => '02',
                        'short' => 'PENDUDUK',
                        'full' => 'Statistik Kependudukan & Proyeksi',
                        'desc' => 'Jumlah penduduk, laju pertumbuhan, kepadatan, rasio jenis kelamin, dan proyeksi kependudukan Kota Bukittinggi.',
                        'search' => '02 penduduk demografi sensus piramida kelamin',
                        'icon' => 'fa-users',
                        'link' => 'https://drive.google.com/drive/folders/1DZR2cpVOCLSqDVwzM3iFKDBVctyM5HxS'
                    ],
                    [
                        'code' => '03',
                        'short' => 'SUSENAS',
                        'full' => 'Survei Sosial Ekonomi Nasional',
                        'desc' => 'Indikator kesejahteraan rakyat, pengeluaran konsumsi pangan/non-pangan, kemiskinan, dan Indeks Pembangunan Manusia (IPM).',
                        'search' => '03 susenas sosial ekonomi konsumsi kemiskinan ipm',
                        'icon' => 'fa-chart-pie',
                        'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                    ],
                    [
                        'code' => '04',
                        'short' => 'SAKERNAS',
                        'full' => 'Survei Angkatan Kerja Nasional',
                        'desc' => 'Tingkat Pengangguran Terbuka (TPT), Tingkat Partisipasi Angkatan Kerja (TPAK), dan struktur lapangan pekerjaan masyarakat.',
                        'search' => '04 sakernas tenaga kerja angkatan pengangguran tpak tpt',
                        'icon' => 'fa-briefcase',
                        'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                    ],
                    [
                        'code' => '05',
                        'short' => 'HORTI',
                        'full' => 'Statistik Pertanian & Hortikultura',
                        'desc' => 'Data produksi dan luas panen komoditas hortikultura: sayuran, buah-buahan, tanaman obat/biofarmaka, dan tanaman hias.',
                        'search' => '05 horti pertanian hortikultura sayur buah tanaman panen',
                        'icon' => 'fa-seedling',
                        'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                    ],
                    [
                        'code' => '06',
                        'short' => 'IMK',
                        'full' => 'Industri Mikro dan Kecil',
                        'desc' => 'Profil dan pertumbuhan usaha industri manufaktur mikro & kecil, penyerapan tenaga kerja, dan nilai tambah output usaha.',
                        'search' => '06 imk industri mikro kecil usaha kerajinan olahan umkm',
                        'icon' => 'fa-industry',
                        'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                    ],
                    [
                        'code' => '07',
                        'short' => 'HOTEL',
                        'full' => 'Statistik Perhotelan & Pariwisata',
                        'desc' => 'Tingkat Penghunian Kamar (TPK) hotel berbintang & non-bintang, jumlah tamu menginap nusantara maupun mancanegara.',
                        'search' => '07 hotel pariwisata akomodasi tpk kamar tamu turis wisatawan',
                        'icon' => 'fa-hotel',
                        'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                    ],
                    [
                        'code' => '08',
                        'short' => 'IHK & INFLASI',
                        'full' => 'Indeks Harga Konsumen / Inflasi',
                        'desc' => 'Perkembangan tingkat inflasi bulanan (m-to-m), tahunan (y-on-y), serta pemantauan harga komoditas utama pembentuk inflasi.',
                        'search' => '08 ihk inflasi harga konsumen pasar sembako',
                        'icon' => 'fa-money-bill-trend-up',
                        'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                    ],
                    [
                        'code' => '09',
                        'short' => 'PDRB LAPUS',
                        'full' => 'PDRB Menurut Lapangan Usaha',
                        'desc' => 'Produk Domestik Regional Bruto berdasarkan 17 lapangan usaha (ADHB & ADHK) dan laju pertumbuhan ekonomi daerah.',
                        'search' => '09 pdrb lapus lapangan usaha ekonomi pertumbuhan adhb adhk pdrb',
                        'icon' => 'fa-chart-simple',
                        'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                    ],
                    [
                        'code' => '10',
                        'short' => 'PDRB PENGELUARAN',
                        'full' => 'PDRB Menurut Pengeluaran',
                        'desc' => 'Agregat PDRB sisi pengeluaran: Konsumsi Rumah Tangga, PMTB (Investasi), Konsumsi Pemerintah, serta Ekspor-Impor.',
                        'search' => '10 pdrb pengeluaran konsumsi investasi pmtb rumah tangga belanja',
                        'icon' => 'fa-wallet',
                        'link' => 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-'
                    ],
                ];
            @endphp

            <!-- White Card Container (Matching OPD/Instansi Style) -->
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
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Katalog survei, sensus, dan tabel data statistik BPS Kota Bukittinggi</p>
                    </div>

                    <!-- Search Input Box (Pill shape) -->
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
                    @foreach($bpsDatasets as $ds)
                        <button type="button"
                                onclick="openBpsModal('{{ $ds['code'] }}', '{{ addslashes($ds['short']) }}', '{{ addslashes($ds['full']) }}', '{{ $ds['link'] }}')"
                                data-search="{{ $ds['code'] }} {{ strtolower($ds['short']) }} {{ strtolower($ds['full']) }} {{ $ds['search'] }}"
                                class="bps-item group w-full bg-white hover:bg-orange-50/40 border border-slate-100 hover:border-orange-300 rounded-2xl p-2.5 sm:p-3 flex items-center justify-between shadow-2xs hover:shadow-xs transition-all duration-150 text-left cursor-pointer">
                            <div class="flex items-center space-x-2.5 sm:space-x-3.5 min-w-0">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-[#fff4eb] text-[#f95a00] flex items-center justify-center text-sm sm:text-base shrink-0 group-hover:scale-105 transition-transform">
                                    <i class="fa-solid {{ $ds['icon'] }}"></i>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 leading-tight">{{ $ds['code'] }}</span>
                                        <span class="text-xs sm:text-[13px] font-bold text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight">{{ $ds['short'] }}</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-medium leading-tight line-clamp-1 mt-0.5">{{ $ds['full'] }}</span>
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
                    <button onclick="clearBpsSearch()" class="mt-2 px-3 py-1 rounded-lg bg-orange-100 text-orange-700 font-bold text-xs hover:bg-orange-200 transition-colors cursor-pointer">
                        Reset Pencarian
                    </button>
                </div>

                <!-- Card Footer Actions: Home (Matching OPD style) -->
                <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 mt-3 pt-2.5 border-t border-slate-100 shrink-0">
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-bold text-xs border border-slate-200/80 transition-all shadow-2xs hover:shadow-xs">
                        <i class="fa-solid fa-house text-xs"></i>
                        <span>HOME</span>
                    </a>
                </div>

            </div>

        </main>

        <!-- FOOTER & USER SESSION BAR -->
        @include('dinas.partials.footer', [
            'isAdmin' => $isAdmin,
            'userIcon' => 'fa-database'
        ])

    </div>

    <!-- MODAL DAFTAR TABEL BPS -->
    @include('dinas.partials.modal-tabel-list', [
        'modalId' => 'bpsModal',
        'headerTagId' => 'bpsHeaderTag',
        'headingId' => 'tabelBpsHeading',
        'headingText' => '1. Tabel Statistik BPS',
        'closeFn' => 'closeBpsModal()',
        'isAdmin' => $isAdmin,
        'showDriveLink' => false,
        'badgeText' => 'Data Internal BPS',
        'searchPlaceholder' => 'Cari tabel statistik BPS...'
    ])

    <!-- MODAL PILIH TAHUN -->
    @include('dinas.partials.modal-pilih-tahun')

    <!-- MODAL TAMBAH TABEL BARU (HANYA ADMINISTRATOR BPS) -->
    @if($isAdmin)
        @include('dinas.partials.modal-tambah-tabel', [
            'agencyList' => $bpsDatasets,
            'agencyTypeLabel' => 'Dataset / Modul BPS'
        ])
    @endif

    <!-- JAVASCRIPT CONFIG & INITIALIZATION -->
    <script>
        window.DinasCatalogConfig = {
            type: 'bps',
            isAdmin: {{ $isAdmin ? 'true' : 'false' }},
            saveUrl: "{{ route('tabel-opd.api.save-custom-catalog') }}",
            deleteUrl: "{{ route('tabel-opd.api.delete-custom-catalog') }}",
            customCatalogUrl: "{{ url('/api/tabel-opd/custom-catalog') }}",
            tabelOpdUrl: "{{ url('/tabel-opd') }}",
            csrfToken: "{{ csrf_token() }}"
        };
        window.serverDbCustomTables = @json($customTables ?? []);
    </script>
    <script src="{{ asset('js/dinas-catalog.js') }}"></script>
</body>
</html>
