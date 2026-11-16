        <!-- BREADCRUMB NAVIGATION & YEAR SWITCHER -->
        <div id="breadcrumbBar" class="w-full bg-white/70 border-b border-slate-200/60 backdrop-blur-xs py-2 px-4 sm:px-6 lg:px-10">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                
                <!-- Breadcrumbs -->
                <div class="flex items-center space-x-2 text-slate-500 overflow-x-auto whitespace-nowrap">
                    <a href="{{ route('home') }}" class="hover:text-[#f95a00] transition-colors flex items-center space-x-1">
                        <i class="fa-solid fa-house text-[10px]"></i>
                        <span>Beranda</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    @php
                        $backRoute = route('isi-data-opd');
                        $backLabel = 'Daftar OPD';
                        if (($currentType ?? 'opd') === 'instansi') {
                            $backRoute = route('isi-data-instansi');
                            $backLabel = 'Daftar Instansi';
                        } elseif (($currentType ?? 'opd') === 'bps') {
                            $backRoute = route('data-bps');
                            $backLabel = 'Data BPS';
                        }
                    @endphp
                    <a id="breadcrumbCatalogLink" href="{{ $backRoute }}" class="hover:text-[#f95a00] transition-colors">
                        <span id="breadcrumbCatalogText">{{ $backLabel }}</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span id="breadcrumbOpdText" class="font-bold text-slate-800">{{ $currentOpdCode }}. {{ $opdName }}</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <a href="javascript:void(0)" onclick="backToTableView()" class="hover:text-[#f95a00] transition-colors">
                        <span id="breadcrumbTableText" class="font-bold text-slate-700">Tabel {{ $currentTableCode ?? '1.1.6' }}</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                    <span class="font-extrabold text-[#f95a00]">Edit Data</span>
                </div>

            </div>
        </div>
