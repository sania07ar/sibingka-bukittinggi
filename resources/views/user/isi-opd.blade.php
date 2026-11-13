<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Data OPD - SiBingka Kota Bukittinggi</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/sibingka-icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sibingka-icon.png') }}">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..900;1,14..32,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Master Catalog Tables (OPD, Instansi & BPS) -->
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

        <!-- MAIN SECTION: LIST INSTANSI (4 Kolom Grid) -->
        <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-1.5 sm:py-2 flex-1 flex flex-col justify-center w-full min-h-0">
            
            @php
                $loggedOpdCode = session('user.opd_code');
                $loggedDinasName = session('user.dinas_name');
                $userRole = session('user.role');
                $isAdmin = $userRole === 'admin';

                $allOpds = [
                    ['code' => '01', 'short' => 'Dinas PUPR', 'full' => 'Dinas Pekerjaan Umum dan Penataan Ruang', 'search' => '01 dinas pupr pekerjaan umum dan penataan ruang', 'icon' => 'fa-city'],
                    ['code' => '02', 'short' => 'Dinas PMPTSP', 'full' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'search' => '02 dinas pmptsp penanaman modal dan pelayanan terpadu satu pintu', 'icon' => 'fa-file-lines'],
                    ['code' => '03', 'short' => 'DPRD Kota Bukittinggi', 'full' => 'Dewan Perwakilan Rakyat Daerah Kota Bukittinggi', 'search' => '03 dprd dewan perwakilan rakyat daerah kota bukittinggi', 'icon' => 'fa-landmark'],
                    ['code' => '04', 'short' => 'Badan Kepegawaian dan Pengembangan SDM', 'full' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia', 'search' => '04 bkpsdm badan kepegawaian dan pengembangan sumber daya manusia sdm', 'icon' => 'fa-users'],
                    ['code' => '05', 'short' => 'Badan Keuangan', 'full' => 'Badan Keuangan Kota Bukittinggi', 'search' => '05 bkd badan keuangan bpkad bkeu', 'icon' => 'fa-coins'],
                    ['code' => '06', 'short' => 'Disdukcapil', 'full' => 'Dinas Kependudukan dan Pencatatan Sipil', 'search' => '06 disdukcapil dinas kependudukan dan pencatatan sipil capil', 'icon' => 'fa-id-card'],
                    ['code' => '07', 'short' => 'Dinas Koperasi, UKM dan Tenaga Kerja', 'full' => 'Dinas Koperasi, Usaha Kecil Menengah dan Tenaga Kerja', 'search' => '07 dinas koperasi ukm dan tenaga kerja disnaker diskop', 'icon' => 'fa-handshake'],
                    ['code' => '08', 'short' => 'Dinas Pendidikan dan Kebudayaan', 'full' => 'Dinas Pendidikan dan Kebudayaan Kota Bukittinggi', 'search' => '08 dinas pendidikan dan kebudayaan disdikbud disdik', 'icon' => 'fa-book-open'],
                    ['code' => '09', 'short' => 'Badan Penanggulangan Bencana Daerah', 'full' => 'Badan Penanggulangan Bencana Daerah Kota Bukittinggi', 'search' => '09 badan penanggulangan bencana daerah bpbd', 'icon' => 'fa-shield-halved'],
                    ['code' => '10', 'short' => 'Dinas Pemuda dan Olahraga', 'full' => 'Dinas Pemuda dan Olahraga Kota Bukittinggi', 'search' => '10 dinas pemuda dan olahraga dispora', 'icon' => 'fa-person-running'],
                    ['code' => '11', 'short' => 'Dinas Perpustakaan dan Kearsipan', 'full' => 'Dinas Perpustakaan dan Kearsipan Kota Bukittinggi', 'search' => '11 dinas perpustakaan dan kearsipan dispusip', 'icon' => 'fa-book-bookmark'],
                    ['code' => '12', 'short' => 'Dinas Kesehatan', 'full' => 'Dinas Kesehatan Kota Bukittinggi', 'search' => '12 dinas kesehatan dinkes', 'icon' => 'fa-circle-plus'],
                    ['code' => '13', 'short' => 'Dinas Lingkungan Hidup', 'full' => 'Dinas Lingkungan Hidup Kota Bukittinggi', 'search' => '13 dinas lingkungan hidup dlh', 'icon' => 'fa-leaf'],
                    ['code' => '14', 'short' => 'Dinas P3APPKB', 'full' => 'Dinas Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk dan KB', 'search' => '14 dinas p3appkb pemberdayaan perempuan perlindungan anak kb', 'icon' => 'fa-people-group'],
                    ['code' => '15', 'short' => 'Dinas Kebakaran', 'full' => 'Dinas Kebakaran Kota Bukittinggi', 'search' => '15 dinas kebakaran damkar pemadam', 'icon' => 'fa-fire'],
                    ['code' => '16', 'short' => 'Dinas Sosial', 'full' => 'Dinas Sosial Kota Bukittinggi', 'search' => '16 dinas sosial dinsos', 'icon' => 'fa-hand-holding-heart'],
                    ['code' => '17', 'short' => 'Dinas Pertanian', 'full' => 'Dinas Pertanian Kota Bukittinggi', 'search' => '17 dinas pertanian distan', 'icon' => 'fa-seedling'],
                    ['code' => '18', 'short' => 'Dinas Perdagangan', 'full' => 'Dinas Perdagangan Kota Bukittinggi', 'search' => '18 dinas perdagangan perindag pasar', 'icon' => 'fa-store'],
                    ['code' => '19', 'short' => 'Dinas Pariwisata', 'full' => 'Dinas Pariwisata Kota Bukittinggi', 'search' => '19 dinas pariwisata dispar wisata', 'icon' => 'fa-location-dot'],
                    ['code' => '20', 'short' => 'Dinas Perhubungan', 'full' => 'Dinas Perhubungan Kota Bukittinggi', 'search' => '20 dinas perhubungan dishub', 'icon' => 'fa-bus'],
                ];

                $isOpdUser = !$isAdmin && (!empty($loggedOpdCode) || !empty($loggedDinasName));
                $userOpd = null;

                if ($isOpdUser) {
                    $formattedLoggedCode = !empty($loggedOpdCode) ? str_pad($loggedOpdCode, 2, '0', STR_PAD_LEFT) : null;
                    foreach ($allOpds as $item) {
                        if ($formattedLoggedCode && $item['code'] === $formattedLoggedCode) {
                            $userOpd = $item;
                            break;
                        }
                        if (!empty($loggedDinasName)) {
                            $dName = strtolower(trim($loggedDinasName));
                            if (str_contains(strtolower($item['short']), $dName) || 
                                str_contains(strtolower($item['full']), $dName) || 
                                str_contains($dName, strtolower($item['short']))) {
                                $userOpd = $item;
                                break;
                            }
                        }
                    }
                }
            @endphp

            @if($isOpdUser && $userOpd)
                <!-- Banner Notifikasi Dinas Aktif -->
                <div class="mb-2 px-3.5 py-1.5 rounded-xl bg-orange-50 border border-orange-200/90 shadow-2xs flex flex-row items-center gap-2 shrink-0">
                    <div class="flex items-center space-x-2.5 text-xs font-bold text-orange-950 truncate">
                        <div class="w-6 h-6 rounded-lg bg-[#f95a00] text-white flex items-center justify-center text-xs shrink-0 shadow-2xs">
                            <i class="fa-solid fa-building-user"></i>
                        </div>
                        <span class="truncate">Selamat Datang, <strong class="text-orange-900 underline">{{ $userOpd['code'] }}. {{ $userOpd['full'] }}</strong></span>
                    </div>
                </div>
            @endif

            <!-- White Card Container -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3 sm:p-4 md:px-5 md:py-3.5 shadow-lg shadow-slate-200/30 w-full transition-all flex flex-col justify-between">
                
                @if($isOpdUser && $userOpd)
                    <!-- Card Header Untuk Dinas User (Tampilan Khusus 1 Dinas) -->
                    <div class="flex flex-row items-center justify-between gap-3 pb-2.5 sm:pb-3 border-b border-slate-100 shrink-0">
                        <div>
                            <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight">Instansi Anda</h1>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Silakan klik kartu instansi dinas Anda di bawah untuk mengelola dan mengisi data tabel statistik</p>
                        </div>
                    </div>

                    <!-- TAMPILAN USER DINAS: HANYA KELUAR 1 KARTU DINAS ITU SAJA -->
                    <div class="py-8 sm:py-12 flex flex-col items-center justify-center">
                        <div class="w-full max-w-xl">
                            <button type="button"
                                    onclick="openOpdModal('{{ $userOpd['code'] }}', '{{ $userOpd['short'] }}', '{{ $userOpd['full'] }}')"
                                    class="group w-full bg-white hover:bg-orange-50/40 border-2 border-orange-200 hover:border-[#f95a00] rounded-3xl p-5 sm:p-7 shadow-sm hover:shadow-xl transition-all duration-200 text-left cursor-pointer transform hover:-translate-y-1 relative overflow-hidden">
                                
                                <div class="absolute -top-12 -right-12 w-36 h-36 bg-orange-100/50 rounded-full blur-xl group-hover:bg-orange-200/50 transition-all pointer-events-none"></div>

                                <div class="flex items-center space-x-4 sm:space-x-5 relative z-10">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-[#fff4eb] text-[#f95a00] flex items-center justify-center text-2xl sm:text-3xl shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                                        <i class="fa-solid {{ $userOpd['icon'] }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight">
                                            {{ $userOpd['short'] }}
                                        </h2>
                                        <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1 leading-snug">
                                            {{ $userOpd['full'] }}
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-orange-100/70 group-hover:bg-[#f95a00] text-orange-500 group-hover:text-white flex items-center justify-center text-base sm:text-lg shrink-0 transition-all group-hover:translate-x-1 shadow-xs">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Card Header: Title & Search Filter (Untuk Admin BPS) -->
                    <div class="flex flex-row items-center justify-between gap-3 pb-2 sm:pb-3 border-b border-slate-100 shrink-0">
                        <div>
                            <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight">Pilih Instansi</h1>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Silakan pilih instansi untuk melihat data</p>
                        </div>

                        <div class="flex items-center space-x-2">
                            <!-- Search Input Box -->
                            <div class="relative w-44 sm:w-60 flex items-center">
                                <input type="text"
                                       id="instansiSearchInput"
                                       oninput="handleSearchInstansi(this.value)"
                                       placeholder="Cari instansi..."
                                       class="w-full bg-[#f8fafc] hover:bg-[#f1f5f9] focus:bg-white border border-slate-200/90 focus:border-[#f95a00] rounded-full pl-4 pr-9 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/15 transition-all">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400" style="top: 0; bottom: 0; right: 0;">
                                    <i class="fa-solid fa-magnifying-glass text-xs leading-none"></i>
                                </div>
                                <button type="button" 
                                        id="instansiClearSearch" 
                                        onclick="clearInstansiSearch()" 
                                        class="hidden absolute right-8 inset-y-0 my-auto w-4 h-4 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center text-[9px] transition-colors cursor-pointer"
                                        style="top: 0; bottom: 0; margin-top: auto; margin-bottom: auto;"
                                        title="Hapus pencarian">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 4-Column Grid Instansi List (20 OPD) -->
                    <div id="instansiGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 mt-2.5 sm:mt-3">
                        @foreach($allOpds as $opd)
                            <button type="button"
                                    onclick="openOpdModal('{{ $opd['code'] }}', '{{ $opd['short'] }}', '{{ $opd['full'] }}')"
                                    data-search="{{ $opd['search'] }}"
                                    class="instansi-item group w-full bg-white hover:bg-orange-50/40 border border-slate-100 hover:border-orange-300 rounded-2xl p-2.5 sm:p-3 flex items-center justify-between shadow-2xs hover:shadow-xs transition-all duration-150 text-left cursor-pointer">
                                <div class="flex items-center space-x-2.5 sm:space-x-3 min-w-0">
                                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-[#fff4eb] text-[#f95a00] flex items-center justify-center text-sm sm:text-base shrink-0 group-hover:scale-105 transition-transform">
                                        <i class="fa-solid {{ $opd['icon'] }}"></i>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 leading-tight">{{ $opd['code'] }}</span>
                                        <span class="text-xs sm:text-[12px] font-bold text-slate-900 group-hover:text-[#f95a00] transition-colors leading-tight line-clamp-2">{{ $opd['short'] }}</span>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-orange-100/70 group-hover:bg-[#f95a00] text-orange-500 group-hover:text-white flex items-center justify-center text-[9px] shrink-0 ml-1.5 transition-all group-hover:translate-x-0.5">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    <!-- Empty State When Search Result Not Found -->
                    <div id="instansiEmptyState" class="hidden py-6 text-center">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 mx-auto flex items-center justify-center text-lg mb-2 shadow-xs">
                            <i class="fa-solid fa-building-circle-xmark"></i>
                        </div>
                        <h3 class="text-xs font-bold text-slate-800">Instansi Tidak Ditemukan</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5 max-w-sm mx-auto">Tidak ada instansi yang cocok dengan kata kunci pencarian Anda.</p>
                        <button onclick="clearInstansiSearch()" class="mt-2 px-3 py-1 rounded-lg bg-orange-100 text-orange-700 font-bold text-xs hover:bg-orange-200 transition-colors">
                            Reset Pencarian
                        </button>
                    </div>
                @endif

                <!-- Card Footer Actions: Blanko PDF (Admin Only) & Home (Centered) -->
                <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 mt-2 sm:mt-2.5 pt-2 border-t border-slate-100 shrink-0">
                    @if($isAdmin)
                        <!-- BLANKO PDF (Google Drive) - Hanya Muncul untuk Admin BPS -->
                        <a href="https://drive.google.com/drive/folders/1ytU-i5aTt7-94u2jiNefX8Ef0Hqr3_5E"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-lg bg-orange-50 hover:bg-orange-100 text-[#f95a00] hover:text-orange-700 font-bold text-xs border border-orange-200/80 transition-all shadow-2xs hover:shadow-xs"
                           title="Buka Folder Google Drive Blanko PDF">
                            <i class="fa-solid fa-file-pdf text-xs"></i>
                            <span>BLANKO PDF</span>
                        </a>
                    @endif

                    <!-- HOME -->
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center space-x-1.5 px-4 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-bold text-xs border border-slate-200/80 transition-all shadow-2xs hover:shadow-xs">
                        <i class="fa-solid fa-house text-xs"></i>
                        <span>HOME</span>
                    </a>
                </div>

            </div>

        </main>

        <!-- FOOTER & USER SESSION BAR -->
        @include('dinas.partials.footer', [
            'isAdmin' => $isAdmin,
            'userIcon' => $userOpd['icon'] ?? 'fa-city'
        ])

    </div>

    <!-- MODAL DAFTAR TABEL OPD -->
    @include('dinas.partials.modal-tabel-list', [
        'modalId' => 'opdModal',
        'headerTagId' => 'opdHeaderTag',
        'headingId' => 'tabelWajibHeading',
        'headingText' => '1. Tabel Wajib',
        'closeFn' => 'closeOpdModal()',
        'isAdmin' => $isAdmin,
        'searchPlaceholder' => 'Cari tabel...'
    ])

    <!-- MODAL PILIH TAHUN -->
    @include('dinas.partials.modal-pilih-tahun')

    <!-- MODAL TAMBAH TABEL BARU (HANYA ADMINISTRATOR BPS) -->
    @if($isAdmin)
        @include('dinas.partials.modal-tambah-tabel', [
            'agencyList' => $allOpds,
            'agencyTypeLabel' => 'Dinas / OPD Penyelenggara Data'
        ])
    @endif

    <!-- JAVASCRIPT CONFIG & INITIALIZATION -->
    <script>
        window.DinasCatalogConfig = {
            type: 'opd',
            isAdmin: {{ $isAdmin ? 'true' : 'false' }},
            saveUrl: "{{ route('tabel-opd.api.save-custom-catalog') }}",
            deleteUrl: "{{ route('tabel-opd.api.delete-custom-catalog') }}",
            customCatalogUrl: "{{ url('/api/tabel-opd/custom-catalog') }}",
            tabelOpdUrl: "{{ url('/tabel-opd') }}",
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
    <script src="{{ asset('js/dinas-catalog.js') }}"></script>

    @if($isOpdUser)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userOpdCode = "{{ $loggedOpdCode }}";
            if (userOpdCode) {
                const buttons = document.querySelectorAll('.instansi-item');
                buttons.forEach(btn => {
                    const text = btn.innerText.trim();
                    if (text.startsWith(userOpdCode + '.')) {
                        btn.classList.add('ring-2', 'ring-[#f95a00]', 'scale-[1.01]', 'bg-orange-50/50');
                    }
                });
            }
        });
    </script>
    @endif
</body>
</html>
