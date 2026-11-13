<!-- TOP CARD HEADER BAR: 4-Square Grid Icon + Title + Export Actions -->
<div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-4 mb-6 gap-3 top-card-header">
    <div class="flex items-center space-x-3">
        <!-- 4-Square Grid Icon -->
        <div class="grid grid-cols-2 gap-0.5 w-5 h-5 shrink-0" aria-hidden="true">
            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
        </div>

        <!-- Title: Tabel X.X.X Tahun XXXX -->
        <div>
            <h2 id="pageMainHeading" class="text-base sm:text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Tabel {{ $currentTableCode ?? '1.1.6' }} Tahun {{ $currentYear ?? date('Y') }}
            </h2>
            <p id="subHeadingOpd" class="text-xs text-slate-500 font-medium">{{ $opdName ?? '01. DINAS PEKERJAAN UMUM DAN PENATAAN RUANG' }}</p>
        </div>
    </div>

    <!-- Right Header Actions: Table Switcher + Year Switcher + Edit + Unggah Excel + Export Dropdown Menu -->
    <div id="actionHeaderRight" class="flex items-center flex-wrap gap-2">
        <!-- Table Switcher Selector -->
        <div class="relative flex items-center space-x-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 rounded-lg px-2.5 py-1.5 transition-colors shadow-2xs cursor-pointer group" title="Ganti tabel dalam instansi ini">
            <i class="fa-solid fa-table-list text-slate-400 text-xs shrink-0 pointer-events-none group-hover:text-[#f95a00] transition-colors"></i>
            <span id="tableSwitcherLabel" class="text-xs font-bold text-slate-700 pointer-events-none select-none">Tabel {{ $currentTableCode ?? '1.1.6' }}</span>
            <i class="fa-solid fa-chevron-down text-[8px] text-slate-400 pointer-events-none"></i>
            <select id="tableSwitcher" onchange="changeTableCode(this.value)" 
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer text-xs">
                <!-- Populated dynamically based on current OPD / Instansi -->
            </select>
        </div>

        <!-- Year Switcher Selector -->
        <div class="flex items-center space-x-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 rounded-lg px-2.5 py-1.5 transition-colors shadow-2xs">
            <i class="fa-solid fa-calendar-days text-slate-400 text-xs"></i>
            <select id="yearSwitcher" onchange="changeTableYear(this.value)" 
                    class="bg-transparent text-xs font-bold text-slate-700 focus:outline-none cursor-pointer">
                @php
                    $selYr = (int) ($currentYear ?? date('Y'));
                @endphp
                @for($y = 2035; $y >= 2018; $y--)
                    <option value="{{ $y }}" {{ $y === $selYr ? 'selected' : '' }}>Tahun {{ $y }}</option>
                @endfor
            </select>
        </div>

        <!-- Button: Form Import Excel -->
        <button onclick="toggleExcelUploadForm()" 
                id="btnToggleExcelUpload"
                class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#0F9D58] border border-emerald-300 font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                title="Import Data Tabel dari Berkas Excel">
            <i class="fa-solid fa-file-import text-xs"></i>
            <span>Import</span>
        </button>

        @php
            $isAdmin = session('user.role') === 'admin';
            $verificationStatus = $dbMetadata?->verification_status ?? 'draft';
            $isLocked = (bool) ($dbMetadata?->is_locked ?? false);
        @endphp

        <!-- Edit Button (Buka Halaman Editor Data) -->
        @if($isLocked && !$isAdmin)
            <button disabled 
                    class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 border border-slate-200 font-bold text-xs flex items-center space-x-1.5 cursor-not-allowed opacity-75"
                    title="Tabel sudah di-ACC & terkunci. Hubungi BPS jika perlu perubahan data.">
                <i class="fa-solid fa-lock text-[11px]"></i>
                <span>Terkunci</span>
            </button>
        @else
            <button id="editTableBtn" onclick="goToEditPage()" 
                    class="px-3 py-1.5 rounded-lg bg-[#fff8e6] hover:bg-[#ffefc2] text-[#d97706] border border-[#fde68a] font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                    title="Buka Halaman Pengeditan Data Tabel">
                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                <span>Edit Tabel</span>
            </button>
        @endif

        <!-- Button: Tampilan Google Spreadsheet (Publikasi Pusat) -->
        <button onclick="openSpreadsheetModal()" 
                id="btnOpenSpreadsheetView"
                class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                title="Buka Tampilan Google Spreadsheet & Salin Langsung untuk Publikasi Pusat">
            <i class="fa-solid fa-table-cells text-xs"></i>
            <span>Tampilan Spreadsheet</span>
        </button>

        <!-- Unified Export Dropdown Menu (Green Button) -->
        <div class="relative inline-block text-left" id="exportDropdownContainerTop">
            <button id="exportDropdownBtnTop" onclick="toggleExportDropdown('Top')" 
                    class="px-3.5 py-1.5 rounded-lg bg-[#0F9D58] hover:bg-[#0B8043] text-white font-bold text-xs flex items-center space-x-1.5 shadow-2xs transition-all cursor-pointer"
                    title="Pilih Format Ekspor Data (Excel, PDF)">
                <i class="fa-solid fa-file-export text-xs"></i>
                <span>Export</span>
                <i id="exportChevronTop" class="fa-solid fa-chevron-down text-[9px] ml-0.5 transition-transform duration-200"></i>
            </button>

            <!-- Dropdown Menu Box -->
            <div id="exportDropdownMenuTop" 
                 class="hidden absolute right-0 mt-2 w-72 origin-top-right rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 border border-slate-200/90 divide-y divide-slate-100 focus:outline-none z-50 animate-in fade-in zoom-in-95 duration-150">
                
                <div class="p-3 bg-slate-50/90 rounded-t-2xl border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-lg bg-emerald-100 text-[#0F9D58] flex items-center justify-center text-xs shadow-2xs">
                            <i class="fa-solid fa-download"></i>
                        </div>
                        <span class="text-[11px] font-extrabold text-slate-800 uppercase tracking-wider">Pilihan Format Ekspor</span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">SiBingka</span>
                </div>

                <div class="p-1.5 space-y-1">
                    <!-- Option 1: Excel (.xlsx / .xls) -->
                    <button onclick="exportToExcel(); closeAllExportDropdowns();" 
                            class="w-full text-left flex items-start space-x-3 p-2.5 rounded-xl hover:bg-emerald-50/90 transition-all group cursor-pointer border border-transparent hover:border-emerald-200/60">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#107c41] group-hover:bg-[#107c41] group-hover:text-white flex items-center justify-center shrink-0 transition-colors shadow-2xs">
                            <i class="fa-solid fa-file-excel text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-950">Microsoft Excel</span>
                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-mono">.XLSX</span>
                            </div>
                            <p class="text-[10.5px] text-slate-500 leading-tight mt-0.5">Tabel bergaris, nilai angka & rumus standar BPS</p>
                        </div>
                    </button>

                    <!-- Option 2: PDF (.pdf) -->
                    <button onclick="exportToPDF(); closeAllExportDropdowns();" 
                            class="w-full text-left flex items-start space-x-3 p-2.5 rounded-xl hover:bg-rose-50/90 transition-all group cursor-pointer border border-transparent hover:border-rose-200/60">
                        <div class="w-8 h-8 rounded-xl bg-rose-100 text-red-600 group-hover:bg-red-600 group-hover:text-white flex items-center justify-center shrink-0 transition-colors shadow-2xs">
                            <i class="fa-solid fa-file-pdf text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800 group-hover:text-rose-950">Dokumen PDF Resmi</span>
                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-rose-100 text-rose-800 font-mono">.PDF</span>
                            </div>
                            <p class="text-[10.5px] text-slate-500 leading-tight mt-0.5">Tata letak cetak resmi Daerah Dalam Angka</p>
                        </div>
                    </button>
                </div>

                <div class="px-3 py-2 bg-slate-50/60 rounded-b-2xl text-[10px] text-slate-400 text-center flex items-center justify-center space-x-1">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i>
                    <span>Standar Publikasi BPS Kota Bukittinggi</span>
                </div>
            </div>
        </div>
    </div>
</div>

