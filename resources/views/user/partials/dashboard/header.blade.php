    <!-- ======================================================== -->
    <!-- 1. HEADER / TOP NAVBAR                                   -->
    <!-- ======================================================== -->
    <header class="w-full bg-[#f0f2f5]/95 backdrop-blur-md border-b border-slate-200/70 relative z-20 shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 grid items-center gap-2 sm:gap-4" style="grid-template-columns: 1fr auto 1fr;">
            
            <!-- Left: Logo & Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0 no-underline">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-7 sm:h-8 w-auto object-contain transition-transform group-hover:scale-105">
                <div class="hidden sm:flex flex-col justify-center leading-tight">
                    <span class="text-[11px] sm:text-xs md:text-sm font-black italic text-slate-900 tracking-tight uppercase font-sans">
                        BADAN PUSAT STATISTIK
                    </span>
                    <span class="text-[10px] sm:text-[11px] md:text-xs font-black italic text-slate-800 tracking-tight uppercase font-sans">
                        KOTA BUKITTINGGI
                    </span>
                </div>
            </a>

            <!-- Center: Logo SiBingka -->
            <div class="flex items-center justify-center">
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-2.5 sm:gap-3 transition-transform hover:scale-[1.02] no-underline shrink-0" title="SiBingka - Sistem Informasi Bukittinggi dalam Angka">
                    <img src="{{ asset('images/sibingka-logo.png') }}" alt="Logo SiBingka" class="h-10 sm:h-12 md:h-14 w-auto object-contain drop-shadow-sm">
                    <div class="hidden lg:flex flex-col justify-center leading-tight text-left">
                        <span class="text-[11px] sm:text-xs md:text-sm font-black text-slate-900 tracking-tight font-sans">SiBingka</span>
                        <span class="text-[10px] sm:text-[11px] md:text-xs font-semibold text-slate-600 tracking-tight font-sans">Sistem Informasi Bukittinggi dalam Angka</span>
                    </div>
                </a>
            </div>


<!-- Right: Actions & Official Badges -->
            <div class="flex items-center gap-2.5 sm:gap-3.5 shrink-0 justify-self-end">
                <!-- BerAKHLAK Logo -->
                <div class="hidden md:flex items-center">
                    <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-6 sm:h-7 w-auto object-contain">
                </div>

                <!-- Divider -->
                <div class="hidden sm:block h-5 w-[1px] bg-slate-200"></div>

                <!-- User Account Profile & Logout -->
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200/80 text-slate-800 text-xs shadow-2xs">
                        <div class="w-5 h-5 rounded-full {{ $isBpsUser ? 'bg-blue-600' : 'bg-[#f95a00]' }} text-white flex items-center justify-center font-bold text-[9px] shadow-sm shrink-0">
                            <i class="fa-solid {{ $isBpsUser ? 'fa-database' : (($opdCode === '01' || stripos($dinasName, 'PUPR') !== false) ? 'fa-city' : 'fa-building') }} text-[9px]"></i>
                        </div>
                        <div class="flex flex-col text-left min-w-0">
                            <span class="font-bold text-slate-900 leading-tight truncate max-w-[80px] sm:max-w-[140px] md:max-w-xs text-[11px] sm:text-xs">{{ $dinasName }}</span>
                            <span class="text-[9px] font-semibold truncate max-w-[80px] sm:max-w-none text-slate-500">
                                @if($isWaliData)
                                    Wali Data (Diskominfo)
                                @elseif($isBpsUser)
                                    Operator Data BPS
                                @elseif($isInstansiUser)
                                    Instansi Vertikal
                                @else
                                    Akun Dinas Pemko
                                @endif
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari SiBingka Kota Bukittinggi?');">
                        @csrf
                        <button type="submit" 
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 flex items-center justify-center text-xs transition-colors cursor-pointer"
                                title="Keluar dari akun">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- Sub-navigation -->
        <div class="hidden md:block border-t border-slate-200/70 bg-white/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1.5 flex justify-center">
                <nav class="hidden md:flex items-center space-x-6 lg:space-x-8 text-xs sm:text-sm font-semibold" id="topNavbar">
                    <a href="#beranda-section" 
                       data-nav="beranda"
                       onclick="selectNavTab('beranda', event)"
                       class="nav-tab text-[#f95a00] border-b-2 border-[#f95a00] pb-1 transition-all cursor-pointer">
                        Beranda
                    </a>
                    <a href="#tentang-section" 
                       data-nav="tentang"
                       onclick="selectNavTab('tentang', event)"
                       class="nav-tab text-slate-700 hover:text-[#f95a00] border-b-2 border-transparent hover:border-[#f95a00] pb-1 transition-all cursor-pointer">
                        Tentang
                    </a>
                </nav>
            </div>
        </div>
    </header>
