<!-- HEADER / NAVBAR KELOLA AKUN -->
<header class="w-full bg-[#f0f2f5]/90 backdrop-blur-md border-b border-slate-200/70 py-2.5 sm:py-3 px-4 sm:px-8 lg:px-12 relative z-20 shrink-0">
    <div class="max-w-7xl mx-auto flex flex-row items-center justify-between gap-4 flex-wrap sm:flex-nowrap">
        
        <!-- Left: BPS Kota Bukittinggi Logo -->
        <a href="{{ route('home') }}" class="flex items-center space-x-2.5 transition-transform hover:scale-[1.02] no-underline text-inherit shrink-0">
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

        <!-- Center: Breadcrumbs & Quick Nav -->
        <div class="hidden md:flex items-center space-x-2 text-xs font-bold text-slate-600">
            <a href="{{ route('home') }}" class="hover:text-[#f95a00] flex items-center space-x-1 transition-colors">
                <i class="fa-solid fa-house text-slate-400"></i>
                <span>Beranda SiBingka</span>
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-900 flex items-center space-x-1.5">
                <i class="fa-solid fa-users-gear text-[#f95a00]"></i>
                <span>Kelola Akun Dinas & Instansi Vertikal</span>
            </span>
        </div>

        <!-- Right: Direct to SiBingka & Logout -->
        <div class="flex items-center space-x-2.5 shrink-0">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-white bg-[#f95a00] hover:bg-[#e04e00] shadow-sm transition-all">
                <span>Masuk ke SiBingka</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>

            <a href="{{ route('logout') }}" 
               class="inline-flex items-center space-x-1.5 px-2.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-red-600 hover:bg-red-50 border border-slate-200 transition-all"
               title="Keluar dari akun">
                <i class="fa-solid fa-power-off text-xs"></i>
            </a>
        </div>

    </div>
</header>
