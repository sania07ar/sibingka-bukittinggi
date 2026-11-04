<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head', ['title' => 'Pilih Layanan - SiAngka Kota Bukittinggi | BPS Kota Bukittinggi'])
    @include('admin.partials.portal-styles')
</head>
<body class="min-h-screen w-full bg-[#f1f4f9] text-slate-800 antialiased flex flex-col justify-between relative selection:bg-orange-500 selection:text-white overflow-x-hidden overflow-y-auto">

    @php
        $currentUser = session('user', []);
        $role = $currentUser['role'] ?? 'opd';
        $isInstansiUser = $role === 'instansi';
        $dinasName = $currentUser['dinas_name'] ?? ($currentUser['displayName'] ?? 'Dinas');
        $targetRoute = $isInstansiUser ? route('isi-data-instansi') : route('isi-data-opd');
        $serviceTitle = $isInstansiUser ? 'Isi Data Instansi Vertikal' : 'Isi Data OPD';
        $serviceDesc = $isInstansiUser ? 'Kelola dan lengkapi data statistik sektoral instansi vertikal Kota Bukittinggi.' : 'Kelola dan lengkapi data statistik sektoral OPD Kota Bukittinggi.';
    @endphp

    <!-- Ambient Background Lighting & Watermark -->
    @include('partials.ambient')

    <!-- HEADER / TOP NAVBAR -->
    <header class="w-full bg-[#f0f2f5]/95 backdrop-blur-md border-b border-slate-200/70 py-2 sm:py-2.5 px-3 sm:px-8 lg:px-12 relative z-20 shrink-0">
        <div class="max-w-7xl mx-auto flex flex-row items-center justify-between gap-3 sm:gap-6 flex-wrap sm:flex-nowrap">
            
            <!-- Left: BPS Kota Bukittinggi Logo & Title -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-2.5 transition-transform hover:scale-[1.02] no-underline text-inherit shrink-0">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-7 sm:h-8 md:h-9 w-auto object-contain">
                <div class="flex flex-col justify-center leading-tight">
                    <span class="text-[9px] sm:text-[11px] md:text-xs font-black italic text-slate-900 tracking-tight uppercase font-sans">
                        BADAN PUSAT STATISTIK
                    </span>
                    <span class="text-[8px] sm:text-[10px] md:text-[11px] font-black italic text-slate-800 tracking-tight uppercase font-sans">
                        KOTA BUKITTINGGI
                    </span>
                </div>
            </a>

            <!-- Right: BerAKHLAK Logo & Profile & Logout -->
            <div class="flex items-center justify-end space-x-3 shrink-0">
                <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-6 sm:h-8 md:h-9 w-auto object-contain">

                @if(session()->has('user'))
                    <div class="hidden md:flex items-center space-x-2 pl-3 border-l border-slate-300">
                        <div class="flex flex-col text-right leading-none">
                            <span class="text-xs font-bold text-slate-900 max-w-[150px] truncate" title="{{ $dinasName }}">
                                {{ $dinasName }}
                            </span>
                            <span class="text-[9.5px] font-semibold text-orange-600 mt-0.5">
                                {{ $isInstansiUser ? 'Instansi Vertikal' : 'Akun Dinas Pemko' }}
                            </span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 border border-slate-200 transition-colors shadow-2xs cursor-pointer" 
                                    title="Keluar dari akun">
                                <i class="fa-solid fa-power-off text-xs"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </header>

    <!-- MAIN PORTAL CONTAINER -->
    <main class="relative z-10 flex-1 flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-4 sm:py-6 max-w-5xl mx-auto w-full my-auto">
        
        <div class="text-center max-w-2xl mx-auto mb-4 sm:mb-6 space-y-1 shrink-0">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Pilih Menu Layanan
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed max-w-xl mx-auto">
                Halo, <strong class="text-slate-900">{{ $dinasName }}</strong>! Silakan pilih untuk langsung menginput tabel data atau menuju ke beranda informasi SiAngka.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 w-full max-w-4xl">
            
            <!-- KARTU 1: ISI DATA TABEL -->
            <a href="{{ $targetRoute }}" 
               class="portal-card block h-full bg-white/95 backdrop-blur-md rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-lg shadow-slate-900/5 relative overflow-hidden flex flex-col justify-between group hover:border-[#f95a00] hover:shadow-orange-500/10 active:border-orange-400 no-underline text-inherit cursor-pointer">
                <div>
                    <div class="mb-3 sm:mb-4">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-orange-50 border border-orange-100 text-[#f95a00] flex items-center justify-center text-lg sm:text-xl shadow-inner group-hover:scale-105 group-hover:bg-[#f95a00] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-file-pen"></i>
                        </div>
                    </div>

                    <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight mb-1 group-hover:text-[#f95a00] transition-colors">
                        {{ $serviceTitle }}
                    </h2>
                    
                    <p class="text-xs text-slate-600 leading-relaxed mb-3 sm:mb-4">
                        {{ $serviceDesc }}
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-[#f95a00] group-hover:text-[#e04e00]">
                    <span>Buka Lembar Kerja Tabel</span>
                    <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1.5"></i>
                </div>
            </a>

            <!-- KARTU 2: BERANDA UTAMA SIANGKA -->
            <a href="{{ route('home') }}" 
               class="portal-card block h-full bg-white/95 backdrop-blur-md rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-lg shadow-slate-900/5 relative overflow-hidden flex flex-col justify-between group hover:border-blue-400 hover:shadow-blue-500/10 active:border-blue-400 no-underline text-inherit cursor-pointer">
                <div>
                    <div class="mb-3 sm:mb-4">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-lg sm:text-xl shadow-inner group-hover:scale-105 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-house"></i>
                        </div>
                    </div>

                    <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight mb-1 group-hover:text-blue-600 transition-colors">
                        Beranda SiAngka
                    </h2>
                    
                    <p class="text-xs text-slate-600 leading-relaxed mb-3 sm:mb-4">
                        Lihat ringkasan informasi, petunjuk pengisian, dan fitur utama Sistem Informasi Data Daerah dalam Angka Bukittinggi.
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-blue-600 group-hover:text-blue-700">
                    <span>Masuk ke Beranda</span>
                    <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1.5"></i>
                </div>
            </a>

        </div>

    </main>

    <!-- FOOTER -->
    @include('admin.partials.portal-footer')

</body>
</html>

