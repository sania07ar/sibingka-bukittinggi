<!-- TOP NAVBAR / LOGO BAR (BPS BUKITTINGGI - BerAKHLAK) -->
<header class="w-full bg-[#f0f2f5] border-b border-slate-200/60 py-2 sm:py-2.5 px-3 sm:px-8 lg:px-12 relative z-20 shrink-0">
    <div class="max-w-7xl mx-auto grid items-center gap-2 sm:gap-4" style="grid-template-columns: 1fr auto 1fr;">
        
        <!-- Left: BPS Kota Bukittinggi Logo -->
        <a href="{{ $homeUrl ?? route('home') }}" class="flex items-center space-x-2 sm:space-x-2.5 transition-transform hover:scale-[1.02] no-underline text-inherit shrink-0">
            <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-6 sm:h-8 md:h-9 w-auto object-contain">
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
            @unless($hideCenterLogo ?? false)
            <a href="{{ $homeUrl ?? route('home') }}" class="flex items-center justify-center gap-2.5 sm:gap-3 transition-transform hover:scale-[1.02] no-underline shrink-0" title="SiBingka - Sistem Informasi Bukittinggi dalam Angka">
                <img src="{{ asset('images/sibingka-logo.png') }}" alt="Logo SiBingka" class="h-10 sm:h-12 md:h-14 w-auto object-contain drop-shadow-sm">
                <div class="hidden lg:flex flex-col justify-center leading-tight text-left">
                    <span class="text-xl font-black tracking-tight text-slate-900">SiBingka</span>
                    <span class="text-[11px] font-medium text-slate-500">Sistem Informasi Bukittinggi dalam Angka</span>
                </div>
            </a>
            @endunless
        </div>

        <!-- Right: BerAKHLAK Logo -->
        <div class="flex items-center justify-end justify-self-end transition-transform hover:scale-[1.02] shrink-0">
            <img src="{{ asset('images/berakhlak-clean.png') }}" alt="BerAKHLAK" class="h-6 sm:h-8 md:h-9 w-auto object-contain">
        </div>

    </div>
</header>
