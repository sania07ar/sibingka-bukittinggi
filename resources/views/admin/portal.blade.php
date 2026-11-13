<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head', ['title' => 'Pilih Layanan - SiBingka Kota Bukittinggi | BPS Kota Bukittinggi'])
    @include('admin.partials.portal-styles')
</head>
<body class="min-h-screen w-full bg-[#f1f4f9] text-slate-800 antialiased flex flex-col justify-between relative selection:bg-orange-500 selection:text-white overflow-x-hidden overflow-y-auto">

    <!-- Ambient Background Lighting & Watermark -->
    @include('partials.ambient')

    <!-- HEADER / TOP NAVBAR (BPS, BerAKHLAK, PROFIL & LOGOUT) -->
    <header class="w-full bg-[#f0f2f5]/95 backdrop-blur-md border-b border-slate-200/70 py-2 sm:py-2.5 px-3 sm:px-8 lg:px-12 relative z-20 shrink-0">
        <div class="max-w-7xl mx-auto grid items-center gap-2 sm:gap-4" style="grid-template-columns: 1fr auto 1fr;">
            
            <!-- Left: BPS Kota Bukittinggi Logo & Title -->
            <a href="{{ route('portal') }}" class="flex items-center space-x-2 sm:space-x-2.5 transition-transform hover:scale-[1.02] no-underline text-inherit shrink-0">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-7 sm:h-8 md:h-9 w-auto object-contain">
                <div class="hidden sm:flex flex-col justify-center leading-tight">
                    <span class="text-[9px] sm:text-[11px] md:text-xs font-black italic text-slate-900 tracking-tight uppercase font-sans">
                        BADAN PUSAT STATISTIK
                    </span>
                    <span class="text-[8px] sm:text-[10px] md:text-[11px] font-black italic text-slate-800 tracking-tight uppercase font-sans">
                        KOTA BUKITTINGGI
                    </span>
                </div>
            </a>

            <!-- Center: Logo SiBingka (logo aplikasi) -->
            <div class="flex items-center justify-center">
                <a href="{{ route('portal') }}" class="flex items-center justify-center gap-2.5 sm:gap-3 transition-transform hover:scale-[1.02] no-underline shrink-0" title="SiBingka - Sistem Informasi Bukittinggi dalam Angka">
                    <img src="{{ asset('images/sibingka-logo.png') }}" alt="Logo SiBingka" class="h-10 sm:h-12 md:h-14 w-auto object-contain drop-shadow-sm">
                    <div class="hidden lg:flex flex-col justify-center leading-tight text-left">
                        <span class="text-xl font-black tracking-tight text-slate-900">SiBingka</span>
                        <span class="text-[11px] font-medium text-slate-500">Sistem Informasi Bukittinggi dalam Angka</span>
                    </div>
                </a>
            </div>

            <!-- Right: BerAKHLAK Logo & Admin User Profile & Logout -->
            <div class="flex items-center justify-end justify-self-end space-x-3 shrink-0">
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

    <!-- MAIN PORTAL CONTAINER (Centered, Scrollable when needed, No cut-off) -->
    <main class="relative z-10 flex-1 flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-4 sm:py-6 max-w-5xl mx-auto w-full my-auto">
        
        <!-- ========================================================================= -->
        <!-- 1. GREETING HERO HEADER                                                   -->
        <!-- ========================================================================= -->
        <div class="text-center max-w-2xl mx-auto mb-4 sm:mb-6 space-y-1 shrink-0">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Pilih Menu Yang Ingin Dituju
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed max-w-xl mx-auto">
                Halo, <strong class="text-slate-900">{{ session('user.displayName', 'Administrator BPS') }}</strong>! Silakan pilih untuk mengelola akun dinas atau langsung masuk ke lembar kerja SiBingka.
            </p>
        </div>

        <!-- ========================================================================= -->
        <!-- 2. PILIHAN KARTU LAYANAN: KELOLA AKUN vs MASUK SiBingka                    -->
        <!-- ========================================================================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 w-full max-w-4xl">
            
            <!-- KARTU 1: KELOLA AKUN ADMIN & DINAS -->
            <a href="{{ route('kelola-akun') }}" 
               id="card-kelola-akun"
               class="portal-card block h-full bg-white/95 backdrop-blur-md rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-lg shadow-slate-900/5 relative overflow-hidden flex flex-col justify-between group hover:border-slate-400 hover:shadow-slate-900/10 active:border-indigo-400 no-underline text-inherit cursor-pointer">
                <div>
                    <!-- Header Icon -->
                    <div class="mb-3 sm:mb-4">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-lg sm:text-xl shadow-inner group-hover:scale-105 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                    </div>

                    <!-- Title & Description -->
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight mb-1 group-hover:text-indigo-600 transition-colors">
                        Kelola Akun Admin & Dinas
                    </h2>
                    
                    <p class="text-xs text-slate-600 leading-relaxed mb-3 sm:mb-4">
                        Perbarui profil admin BPS, ganti kata sandi, kelola akun dinas/instansi, dan atur izin hak akses halaman.
                    </p>

                    <!-- Features Checklist -->
                    <div class="space-y-1.5 mb-4 bg-slate-50/80 rounded-xl p-3 border border-slate-100 text-xs font-semibold text-slate-700">
                        <div class="flex items-center">
                            <i class="fa-solid fa-key text-amber-500 mr-2 text-xs"></i>
                            <span>Ganti & Perbarui Kata Sandi</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-users text-blue-500 mr-2 text-xs"></i>
                            <span>Kelola 20 Akun OPD & 37 Instansi Vertikal</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-shield-halved text-emerald-500 mr-2 text-xs"></i>
                            <span>Atur Hak Akses Modul & Halaman</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div>
                    <div class="btn-account w-full text-xs py-2.5 px-3 uppercase tracking-wider space-x-2 group-hover:shadow-md transition-all font-bold"
                         id="btn-pilih-kelola-akun">
                        <span>Kelola Akun Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-[11px] transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>
            </a>

            <!-- KARTU 2: MASUK KE HALAMAN UTAMA SiBingka -->
            <a href="{{ route('home') }}" 
               id="card-masuk-sibingka"
               class="portal-card block h-full bg-white/95 backdrop-blur-md rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-lg shadow-slate-900/5 relative overflow-hidden flex flex-col justify-between group hover:border-[#f95a00]/40 hover:shadow-orange-900/10 active:border-[#f95a00] no-underline text-inherit cursor-pointer">
                <div>
                    <!-- Header Icon -->
                    <div class="mb-3 sm:mb-4">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-orange-50 border border-orange-100 text-[#f95a00] flex items-center justify-center text-lg sm:text-xl shadow-inner group-hover:scale-105 group-hover:bg-[#f95a00] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                    </div>

                    <!-- Title & Description -->
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight mb-1 group-hover:text-[#f95a00] transition-colors">
                        Masuk ke SiBingka
                    </h2>
                    
                    <p class="text-xs text-slate-600 leading-relaxed mb-3 sm:mb-4">
                        Buka portal utama SiBingka Kota Bukittinggi untuk mengakses pengisian data OPD, Instansi Vertikal, dan monitoring.
                    </p>

                    <!-- Features Checklist -->
                    <div class="space-y-1.5 mb-4 bg-orange-50/40 rounded-xl p-3 border border-orange-100/70 text-xs font-semibold text-slate-700">
                        <div class="flex items-center">
                            <i class="fa-solid fa-building-columns text-orange-500 mr-2 text-xs"></i>
                            <span>Isi Data & Lembar Kerja Tabel OPD</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-building-flag text-indigo-500 mr-2 text-xs"></i>
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
                    <div class="btn-sibingka w-full text-xs py-2.5 px-3 uppercase tracking-wider space-x-2 group-hover:shadow-md transition-all font-bold"
                         id="btn-pilih-masuk-sibingka">
                        <span>Masuk ke SiBingka</span>
                        <i class="fa-solid fa-arrow-right text-[11px] transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>
            </a>

        </div>

    </main>

    <!-- FOOTER (INFORMASI COPYRIGHT & ALAMAT KANTOR BPS) -->
    <footer class="relative z-20 w-full py-2.5 sm:py-3 px-3 sm:px-8 lg:px-12 border-t border-slate-200/70 bg-white/90 backdrop-blur-md shrink-0">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2.5 text-xs">
            
            <div class="text-[11px] text-slate-600">
                <span class="font-bold text-slate-800">SiBingka Kota Bukittinggi</span> — Sistem Informasi Bukittinggi dalam Angka
            </div>

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
    </script>

</body>
</html>
