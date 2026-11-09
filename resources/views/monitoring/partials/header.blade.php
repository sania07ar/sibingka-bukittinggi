@php
    $currentTab = $activeTab ?? 'opd';
@endphp

<!-- TITLE HEADER & CONTROLS -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight uppercase">
            MONITORING PROGRESS PENGUMPULAN DATA
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5">
            Dashboard pemantauan real-time progres pengumpulan data sektoral {{ $currentTab === 'instansi' ? 'Instansi Vertikal & Lainnya' : ($currentTab === 'bps' ? 'Data BPS' : 'OPD') }} Kota Bukittinggi Tahun <span class="text-[#f95a00] font-bold">{{ $selectedYear }}</span>
        </p>
    </div>

    <!-- Right Action Controls (Pilihan Tahun & Ekspor Laporan) -->
    <div class="flex items-center gap-2.5 no-print shrink-0">
        
        <!-- Pilihan Tahun Monitoring (Satu-satunya Selector Tahun Utama di Halaman Ini) -->
        <div class="relative shrink-0">
            <select id="globalMonitoringYear" onchange="changeMonitoringYear(this.value)"
                    class="appearance-none inline-flex items-center space-x-2 pl-9 pr-8 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs sm:text-sm border border-slate-200/90 shadow-2xs hover:shadow transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                    title="Pilih tahun data untuk seluruh monitoring dan ekspor laporan">
                @foreach($availableYears as $yr)
                    <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>
                        Tahun {{ $yr }}
                    </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center text-[#f95a00] text-xs">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="pointer-events-none absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 text-[10px]">
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </div>

        <!-- Export Dropdown -->
        <div class="relative shrink-0">
            <button type="button" 
                    id="exportDropdownBtn"
                    onclick="toggleExportMenu()"
                    class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs sm:text-sm border border-slate-200/90 shadow-2xs hover:shadow transition-all cursor-pointer">
                <i class="fa-solid fa-file-lines text-slate-500"></i>
                <span>Ekspor Laporan (Tahun {{ $selectedYear }})</span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
            </button>

            <!-- Dropdown Content -->
            <div id="exportDropdownMenu" class="hidden absolute right-0 mt-1.5 w-64 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 text-xs">
                <button type="button" onclick="exportMonitoringExcel()" class="w-full text-left px-3.5 py-2.5 hover:bg-orange-50 text-slate-700 hover:text-[#f95a00] font-semibold flex items-center space-x-2.5 transition-colors cursor-pointer">
                    <i class="fa-solid fa-file-excel text-emerald-600 text-sm w-4"></i>
                    <div>
                        <div class="font-bold">Ekspor Rekap ke Excel</div>
                        <div class="text-[10px] text-slate-400">Semua dinas Tahun {{ $selectedYear }} (.xlsx)</div>
                    </div>
                </button>
                <button type="button" onclick="exportAllTablesDetailsExcel()" class="w-full text-left px-3.5 py-2.5 hover:bg-orange-50 text-slate-700 hover:text-[#f95a00] font-semibold flex items-center space-x-2.5 transition-colors cursor-pointer">
                    <i class="fa-solid fa-table-cells text-teal-600 text-sm w-4"></i>
                    <div>
                        <div class="font-bold">Ekspor Rincian Semua Tabel</div>
                        <div class="text-[10px] text-slate-400">Status seluruh tabel Tahun {{ $selectedYear }}</div>
                    </div>
                </button>
                <button type="button" onclick="window.print()" class="w-full text-left px-3.5 py-2.5 hover:bg-orange-50 text-slate-700 hover:text-[#f95a00] font-semibold flex items-center space-x-2.5 transition-colors cursor-pointer">
                    <i class="fa-solid fa-file-pdf text-rose-600 text-sm w-4"></i>
                    <div>
                        <div class="font-bold">Cetak / Simpan PDF</div>
                        <div class="text-[10px] text-slate-400">Format cetak Tahun {{ $selectedYear }}</div>
                    </div>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function changeMonitoringYear(yearVal) {
        const curUrl = new URL(window.location.href);
        curUrl.searchParams.set('year', yearVal);
        if (window.monSelectedAgency) {
            curUrl.searchParams.set('opd', window.monSelectedAgency);
        }
        if (window.monSelectedTable) {
            curUrl.searchParams.set('table', window.monSelectedTable);
        }
        window.location.href = curUrl.toString();
    }
</script>

<!-- TAB SWITCHER: OPD vs INSTANSI VERTIKAL vs DATA BPS -->
<div class="no-print flex items-center space-x-2 mb-4 bg-slate-200/60 p-1 rounded-2xl max-w-fit flex-wrap gap-y-1">
    <a href="{{ route('monitoring-opd', ['year' => $selectedYear]) }}"
       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all no-underline {{ $currentTab === 'opd' ? 'bg-white text-[#f95a00] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
        <i class="fa-solid fa-building mr-1.5 text-xs"></i>
        <span>OPD (20)</span>
    </a>
    <a href="{{ route('monitoring-instansi', ['year' => $selectedYear]) }}"
       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all no-underline {{ $currentTab === 'instansi' ? 'bg-white text-[#f95a00] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
        <i class="fa-solid fa-landmark mr-1.5 text-xs"></i>
        <span>Instansi Vertikal & Lainnya (37)</span>
    </a>
    <a href="{{ route('monitoring-bps', ['year' => $selectedYear]) }}"
       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all no-underline {{ $currentTab === 'bps' ? 'bg-white text-[#f95a00] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i>
        <span>Data BPS (10)</span>
    </a>
</div>

