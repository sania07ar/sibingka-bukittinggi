<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data BPS - SiMonDa Bukittinggi dalam Angka</title>
    
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

        /* BPS Data Action Buttons (Matched to Home Page Size) */
        .btn-data-bps {
            background-color: #f95a00;
            color: #ffffff;
            font-weight: 700;
            border-radius: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.85rem 1.25rem;
            min-height: 3.5rem;
            line-height: 1.25;
            box-shadow: 0 4px 12px rgba(249, 90, 0, 0.25);
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-data-bps:hover {
            background-color: #e04e00;
            transform: translateY(-2px) scale(1.015);
            box-shadow: 0 6px 18px rgba(249, 90, 0, 0.35);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .btn-data-bps:active {
            transform: translateY(0) scale(0.99);
        }

        /* Bottom HOME button */
        .btn-home-bps {
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

        .btn-home-bps:hover {
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

        <!-- MAIN DATA BPS BUTTONS (2 Columns x 5 Rows + Centered HOME Button) -->
        <main class="max-w-3xl mx-auto px-4 sm:px-6 py-6 sm:py-8 flex-1 flex flex-col justify-center w-full">
            
            <!-- 2-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 sm:gap-x-8 gap-y-3 sm:gap-y-3.5 w-full">
                
                <!-- ROW 1 -->
                <!-- Left: PODES -->
                <button onclick="openBpsLink('PODES', 'Potensi Desa / Kelurahan')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>PODES</span>
                </button>

                <!-- Right: PENDUDUK -->
                <button onclick="openBpsLink('PENDUDUK', 'Statistik Kependudukan & Proyeksi')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>PENDUDUK</span>
                </button>

                <!-- ROW 2 -->
                <!-- Left: SUSENAS -->
                <button onclick="openBpsLink('SUSENAS', 'Survei Sosial Ekonomi Nasional')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>SUSENAS</span>
                </button>

                <!-- Right: SAKERNAS -->
                <button onclick="openBpsLink('SAKERNAS', 'Survei Angkatan Kerja Nasional')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>SAKERNAS</span>
                </button>

                <!-- ROW 3 -->
                <!-- Left: HORTI -->
                <button onclick="openBpsLink('HORTI', 'Statistik Pertanian & Hortikultura')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>HORTI</span>
                </button>

                <!-- Right: IMK -->
                <button onclick="openBpsLink('IMK', 'Industri Mikro dan Kecil')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>IMK</span>
                </button>

                <!-- ROW 4 -->
                <!-- Left: HOTEL -->
                <button onclick="openBpsLink('HOTEL', 'Statistik Perhotelan & Pariwisata')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>HOTEL</span>
                </button>

                <!-- Right: IHK -->
                <button onclick="openBpsLink('IHK', 'Indeks Harga Konsumen / Inflasi')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>IHK</span>
                </button>

                <!-- ROW 5 -->
                <!-- Left: PDRB LAPUS -->
                <button onclick="openBpsLink('PDRB LAPUS', 'PDRB Menurut Lapangan Usaha')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>PDRB LAPUS</span>
                </button>

                <!-- Right: PDRB PENGELUARAN -->
                <button onclick="openBpsLink('PDRB PENGELUARAN', 'PDRB Menurut Pengeluaran')"
                        class="btn-data-bps text-sm sm:text-base uppercase tracking-wide">
                    <span>PDRB PENGELUARAN</span>
                </button>

            </div>

            <!-- BOTTOM CENTER: HOME BUTTON -->
            <div class="flex justify-center items-center mt-5 sm:mt-6">
                <a href="{{ route('home') }}"
                   class="btn-home-bps w-44 sm:w-52 text-sm sm:text-base uppercase tracking-wide no-underline">
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

    <!-- DATA BPS MODAL DIALOG -->
    <div id="bpsModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100" id="bpsModalCard">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-[#f95a00] text-xl font-bold shadow-xs">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-orange-600">Katalog Data Internal BPS</span>
                        <h3 id="bpsTitle" class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">PODES</h3>
                        <p id="bpsSubtitle" class="text-xs text-slate-500 mt-0.5">Potensi Desa / Kelurahan</p>
                    </div>
                </div>
                <button onclick="closeBpsModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-4 space-y-3.5">
                <p id="bpsDesc" class="text-xs sm:text-[13px] text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-200/70">
                    Deskripsi rincian data survei / sensus BPS Kota Bukittinggi.
                </p>

                <!-- Status Pengelolaan -->
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="bg-orange-50/60 border border-orange-200/60 rounded-xl p-2.5">
                        <span class="text-slate-500 text-[11px] block">Tahun Publikasi:</span>
                        <span class="font-bold text-orange-950">{{ date('Y') }}</span>
                    </div>
                    <div class="bg-emerald-50/60 border border-emerald-200/60 rounded-xl p-2.5">
                        <span class="text-slate-500 text-[11px] block">Status Data:</span>
                        <span class="font-bold text-emerald-700 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-[11px]"></i> Terverifikasi
                        </span>
                    </div>
                </div>

                <!-- Action Options: Export Excel & PDF Suite -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                        <span>Pilihan Ekspor & Metadata</span>
                        <span class="text-[10px] text-orange-600 font-bold uppercase tracking-wider">Format Resmi</span>
                    </label>
                    <div class="grid grid-cols-2 gap-2.5">
                        <!-- Option 1: Excel (.xlsx / .xls) -->
                        <button onclick="alert('Mengunduh berkas Excel (.xlsx) untuk tabel ' + currentDataset + '...');"
                                class="py-2.5 px-3 rounded-xl bg-emerald-50/80 hover:bg-emerald-100/90 text-emerald-900 font-bold text-xs transition-all flex items-center space-x-2 border border-emerald-200/80 group cursor-pointer shadow-2xs">
                            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 text-xs shadow-2xs group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-file-excel"></i>
                            </div>
                            <div class="text-left flex-1 min-w-0">
                                <span class="block font-bold text-xs text-slate-800 group-hover:text-emerald-950 leading-tight">Excel (.xlsx)</span>
                                <span class="block text-[10px] text-slate-500 font-normal">Spreadsheet</span>
                            </div>
                        </button>

                        <!-- Option 2: PDF (.pdf) -->
                        <button onclick="alert('Mengunduh dokumen PDF resmi untuk publikasi ' + currentDataset + '...');"
                                class="py-2.5 px-3 rounded-xl bg-rose-50/80 hover:bg-rose-100/90 text-rose-900 font-bold text-xs transition-all flex items-center space-x-2 border border-rose-200/80 group cursor-pointer shadow-2xs">
                            <div class="w-7 h-7 rounded-lg bg-red-600 text-white flex items-center justify-center shrink-0 text-xs shadow-2xs group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div class="text-left flex-1 min-w-0">
                                <span class="block font-bold text-xs text-slate-800 group-hover:text-rose-950 leading-tight">PDF (.pdf)</span>
                                <span class="block text-[10px] text-slate-500 font-normal">Dokumen Resmi</span>
                            </div>
                        </button>
                    </div>

                    <!-- Metadata Link -->
                    <button onclick="alert('Membuka metadata statistik ' + currentDataset + '...');"
                            class="w-full mt-2 py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-slate-700 font-bold text-xs transition-colors flex items-center justify-center space-x-1.5 border border-slate-200 cursor-pointer">
                        <i class="fa-solid fa-book-open text-blue-600 text-xs"></i>
                        <span>Lihat Metadata & Definisi Variabel Statistik</span>
                    </button>
                </div>

                <!-- Update file box -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Update Dataset Internal (PJ Sensus / Survei)</label>
                    <div class="border-2 border-dashed border-slate-300 hover:border-orange-400 rounded-2xl p-3.5 text-center cursor-pointer bg-slate-50 hover:bg-orange-50/50 transition-colors">
                        <i class="fa-solid fa-cloud-arrow-up text-xl text-[#f95a00] mb-0.5"></i>
                        <p class="text-xs font-bold text-slate-700">Unggah berkas tabel terbaru</p>
                        <p class="text-[10.5px] text-slate-400">Format: .xlsx, .csv (Maks. 15MB)</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button onclick="closeBpsModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition-colors">
                    Tutup
                </button>
                <button onclick="alert('Data ' + currentDataset + ' berhasil diperbarui!'); closeBpsModal();" class="px-5 py-2 bg-[#f95a00] hover:bg-[#e04e00] text-white font-bold rounded-xl text-xs shadow-md transition-all">
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // Registry Data Google Drive BPS
        const bpsLinks = {
            'PODES': 'https://drive.google.com/drive/folders/1uLHQDuVkwwkqmPiDzCbpkmGGmZ8YBDep',
            'PENDUDUK': 'https://drive.google.com/drive/folders/1DZR2cpVOCLSqDVwzM3iFKDBVctyM5HxS',
            'SUSENAS': 'https://drive.google.com/drive/folders/165ZffQ57NgwBxsEuaSBO97y0A_oEJ1B-',
            'SAKERNAS': '',
            'HORTI': '',
            'IMK': '',
            'HOTEL': '',
            'IHK': '',
            'PDRB LAPUS': '',
            'PDRB PENGELUARAN': ''
        };

        function openBpsLink(key, label) {
            const url = bpsLinks[key];
            if (url && url.trim() !== '') {
                window.open(url, '_blank');
            } else {
                alert('Tautan Google Drive untuk ' + (label || key) + ' belum dikonfigurasi / segera tersedia.');
            }
        }

        let currentDataset = '';

        function openBpsModal(title, subtitle, desc) {
            currentDataset = title;
            const modal = document.getElementById('bpsModal');
            const card = document.getElementById('bpsModalCard');
            
            document.getElementById('bpsTitle').innerText = title;
            document.getElementById('bpsSubtitle').innerText = subtitle;
            document.getElementById('bpsDesc').innerText = desc;

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
