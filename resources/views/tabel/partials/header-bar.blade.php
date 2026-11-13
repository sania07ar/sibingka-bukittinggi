        <!-- HEADER TOP BAR -->
        <header class="w-full bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 transition-all shadow-2xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-2.5 sm:py-3 flex items-center justify-between">
                
                <!-- Left: Logo BPS & Title SiBingka -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <a href="{{ route('home') }}" class="transition-transform hover:scale-105 shrink-0" title="Kembali ke Beranda">
                        <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-8 sm:h-9 md:h-10 w-auto object-contain">
                    </a>
                    <div class="flex flex-col">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-sm sm:text-base md:text-lg font-black tracking-tight text-slate-900 leading-tight">
                                SiBingka <span class="font-bold text-[#f95a00] text-xs sm:text-sm">Kota Bukittinggi</span>
                            </h1>
                            <span id="headerTypeBadge" class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200/90 font-bold text-[10px] tracking-wider uppercase">
                                {{ ($currentType ?? 'opd') === 'instansi' ? 'INSTANSI VERTIKAL' : 'OPD' }}
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium hidden sm:block">
                            Sistem Informasi Bukittinggi dalam Angka
                        </p>
                    </div>
                </div>


                <!-- Right: Navigation Action Buttons -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    @php
                        $backRoute = route('isi-data-opd');
                        $backLabel = 'Daftar OPD';
                        $catalogBreadcrumb = 'Isi Data OPD';
                        if (($currentType ?? 'opd') === 'instansi') {
                            $backRoute = route('isi-data-instansi');
                            $backLabel = 'Daftar Instansi';
                            $catalogBreadcrumb = 'Isi Data Instansi Vertikal';
                        } elseif (($currentType ?? 'opd') === 'bps') {
                            $backRoute = route('data-bps');
                            $backLabel = 'Data BPS';
                            $catalogBreadcrumb = 'Data Internal BPS';
                        }
                    @endphp
                    <a id="btnBackToDaftar" href="{{ $backRoute }}" 
                       class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-1.5 shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span id="btnBackToDaftarText">{{ $backLabel }}</span>
                    </a>
                    <a href="{{ route('home') }}" 
                       class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-[#f95a00] hover:bg-[#e04e00] text-white text-xs font-bold transition-all flex items-center space-x-1.5 shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-house text-[11px]"></i>
                        <span class="hidden sm:inline">Home</span>
                    </a>
                </div>

            </div>
        </header>

        <!-- BREADCRUMB & CONTEXT BAR -->
        <div id="breadcrumbBar" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 pt-4 sm:pt-6 w-full">
            <div class="flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500 pb-2">
                <div class="flex items-center space-x-2 font-medium">
                    <a href="{{ route('home') }}" class="hover:text-[#f95a00] transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <a id="breadcrumbCatalogLink" href="{{ $backRoute }}" class="hover:text-[#f95a00] transition-colors">
                        <span id="breadcrumbCatalogText">{{ $catalogBreadcrumb }}</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span id="breadcrumbOpdText" class="font-bold text-slate-800">01. DINAS PUPR</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span id="breadcrumbTableText" class="font-bold text-[#f95a00]">Tabel 1.1.6</span>
                </div>

            </div>
        </div>
