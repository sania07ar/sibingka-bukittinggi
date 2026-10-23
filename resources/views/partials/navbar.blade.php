<!-- TOP NAVBAR / LOGO BAR (BPS BUKITTINGGI - SENSUS EKONOMI - BerAKHLAK) -->
<header class="w-full bg-[#f0f2f5] border-b border-slate-200/60 py-2 sm:py-2.5 px-3 sm:px-8 lg:px-12 relative z-20 shrink-0">
    <div class="max-w-7xl mx-auto flex flex-row items-center justify-between gap-2 sm:gap-4 md:gap-6 flex-wrap sm:flex-nowrap">
        
        <!-- Left: BPS Kota Bukittinggi Logo -->
        <a href="{{ $homeUrl ?? route('home') }}" class="flex items-center space-x-2 sm:space-x-2.5 transition-transform hover:scale-[1.02] no-underline text-inherit shrink-0">
            <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-6 sm:h-8 md:h-9 w-auto object-contain">
            <div class="flex flex-col justify-center leading-tight">
                <span class="text-[9px] sm:text-[11px] md:text-xs font-black italic text-slate-900 tracking-tight uppercase font-sans">
                    BADAN PUSAT STATISTIK
                </span>
                <span class="text-[8px] sm:text-[10px] md:text-[11px] font-black italic text-slate-800 tracking-tight uppercase font-sans">
                    KOTA BUKITTINGGI
                </span>
            </div>
        </a>

        <!-- Center: Sensus Ekonomi 2026 Logo -->
        <div class="flex items-center justify-center transition-transform hover:scale-[1.02] shrink-0">
            <img src="{{ asset('images/sensus-ekonomi-clean.png') }}" alt="Sensus Ekonomi 2026" class="h-6 sm:h-8 md:h-9 w-auto object-contain">
        </div>

        <!-- Right: BerAKHLAK Logo -->
        <div class="flex items-center justify-end transition-transform hover:scale-[1.02] shrink-0">
            <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-6 sm:h-8 md:h-9 w-auto object-contain">
        </div>

    </div>
</header>
