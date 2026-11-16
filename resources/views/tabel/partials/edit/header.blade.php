        <!-- HEADER TOP BAR -->
        <header class="w-full bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 transition-all shadow-2xs">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-10 py-2 sm:py-3 flex items-center justify-between gap-2">
                
                <!-- Left: Logo BPS & Title SiBingka -->
                <div class="flex items-center space-x-2 sm:space-x-4 min-w-0">
                    <a href="{{ route('home') }}" class="transition-transform hover:scale-105 shrink-0" title="Kembali ke Beranda">
                        <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-7 sm:h-9 md:h-10 w-auto object-contain">
                    </a>
                    <div class="hidden sm:block h-8 sm:h-9 w-[1px] bg-slate-300/80 shrink-0"></div>
                    <a href="{{ route('home') }}" class="transition-transform hover:scale-105 shrink-0" title="SiBingka - Sistem Informasi Bukittinggi dalam Angka">
                        <img src="{{ asset('images/sibingka-logo.png') }}" alt="Logo SiBingka" class="h-8 sm:h-10 md:h-12 w-auto object-contain drop-shadow-sm">
                    </a>
                    <div class="flex flex-col min-w-0">
                        <div class="flex items-center space-x-1.5 sm:space-x-2">
                            <h1 class="text-xs sm:text-base md:text-lg font-black tracking-tight text-slate-900 leading-tight truncate">
                                SiBingka <span class="font-bold text-[#f95a00] text-[11px] sm:text-sm">Kota Bukittinggi</span>
                            </h1>
                            <span class="hidden xs:inline-block px-1.5 sm:px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200/90 font-bold text-[9px] sm:text-[10px] tracking-wider uppercase shrink-0">
                                Editor
                            </span>
                        </div>
                        <p class="text-[10px] sm:text-xs text-slate-500 font-medium hidden sm:block truncate">
                            Sistem Informasi Bukittinggi dalam Angka
                        </p>
                    </div>
                </div>


                <!-- Right: Action Back to View Table -->
                <div class="flex items-center space-x-1.5 sm:space-x-3 shrink-0">
                    <button onclick="backToTableView()" 
                       class="px-2.5 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-1 sm:space-x-1.5 shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span class="hidden sm:inline">Kembali ke </span><span>Tabel</span>
                    </button>
                </div>

            </div>
        </header>
