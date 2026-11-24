@props([
    'modalId' => 'agencyModal',
    'cardId' => null,
    'headerTagId' => 'opdHeaderTag',
    'headingId' => 'tabelWajibHeading',
    'headingText' => '1. Tabel Wajib',
    'closeFn' => 'closeAgencyModal()',
    'showDriveLink' => false,
    'isAdmin' => false,
    'badgeText' => null,
    'searchPlaceholder' => 'Cari tabel...'
])

@php
    $cardId = $cardId ?? ($modalId . 'Card');
@endphp

<!-- MODAL DAFTAR TABEL STATISTIK -->
<div id="{{ $modalId }}" style="z-index: 70;" class="fixed inset-0 z-50 hidden items-center justify-center p-2 sm:p-4 md:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
    <div class="bg-white rounded-2xl sm:rounded-3xl max-w-4xl lg:max-w-5xl w-full p-3 sm:p-6 md:p-7 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative max-h-[94vh] flex flex-col overflow-hidden" id="{{ $cardId }}">
        
        <!-- Modal Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-3 mb-3 sm:mb-5 gap-2.5 sm:gap-3 shrink-0">
            <!-- Left: Grid Icon + Title + Agency Name + Mobile Close Button -->
            <div class="flex items-center justify-between w-full sm:w-auto">
                <div class="flex items-center space-x-2.5 sm:space-x-3 min-w-0">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-500 shadow-2xs shrink-0">
                        <div class="grid grid-cols-2 gap-0.5 w-3.5 h-3.5">
                            <span class="bg-[#f98825] rounded-[2px]"></span>
                            <span class="bg-[#f98825] rounded-[2px]"></span>
                            <span class="bg-[#f98825] rounded-[2px]"></span>
                            <span class="bg-[#f98825] rounded-[2px]"></span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1.5 sm:space-x-3 flex-wrap min-w-0">
                        @if($badgeText)
                            <span class="text-[9px] sm:text-[10px] font-extrabold uppercase tracking-wider text-orange-600 bg-orange-50 border border-orange-200 px-1.5 sm:px-2 py-0.5 rounded-full shrink-0">
                                {{ $badgeText }}
                            </span>
                        @endif
                        <h2 class="text-sm sm:text-lg md:text-xl font-bold text-slate-800 tracking-tight shrink-0">Input Tabel</h2>
                        <span id="{{ $headerTagId }}" class="text-[11px] sm:text-sm font-semibold text-slate-500 bg-slate-100 px-2 sm:px-2.5 py-0.5 rounded-full border border-slate-200 truncate max-w-[130px] xs:max-w-[200px] sm:max-w-xs" title="-">
                            -
                        </span>
                    </div>
                </div>

                <!-- Close Button (Mobile Only - Top Right) -->
                <button onclick="{{ $closeFn }}" class="sm:hidden w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer shrink-0 ml-2" title="Tutup">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            <!-- Right: Unduh Excel (Pilih Tahun) & Desktop Close Button -->
            <div class="flex items-center justify-between sm:justify-end space-x-2 shrink-0 w-full sm:w-auto">
                <div class="inline-flex items-center space-x-1.5 bg-emerald-50/70 border border-emerald-200/90 rounded-xl p-1 shadow-2xs w-full sm:w-auto justify-between sm:justify-start">
                    <div class="flex items-center space-x-1">
                        <span class="sm:hidden text-[10px] font-bold text-emerald-800 ml-1">Tahun:</span>
                        <select id="modalExportYearSelect" 
                                onchange="window.updateModalExportUrl(this.value)" 
                                class="bg-white border border-emerald-200 text-emerald-800 text-xs font-bold rounded-lg px-2 py-1 focus:outline-none cursor-pointer"
                                title="Pilih tahun data Excel yang ingin diunduh">
                            @php
                                $maxYear = max(2036, ((int)date('Y')) + 1);
                                $minYear = 2015;
                            @endphp
                            @foreach(range($maxYear, $minYear) as $yr)
                                <option value="{{ $yr }}" {{ ((int)request('year', date('Y'))) === $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <a id="modalExportAgencyExcelBtn" 
                       href="#" 
                       class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors no-underline shrink-0"
                       title="Unduh Seluruh Tabel Instansi Ini ke Format Excel (.xlsx)">
                        <i class="fa-solid fa-file-excel text-xs"></i>
                        <span>Unduh Excel</span>
                    </a>
                </div>
                <!-- Desktop Close Button -->
                <button onclick="{{ $closeFn }}" class="hidden sm:flex w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 items-center justify-center transition-colors cursor-pointer shrink-0" title="Tutup">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body (Full-Width Table) -->
        <div class="space-y-3 w-full flex-1 min-h-0 flex flex-col overflow-y-auto">
            
            <div class="flex items-center justify-between mb-0.5 shrink-0">
                <h3 id="{{ $headingId }}" class="text-xs sm:text-sm md:text-[15px] font-bold text-slate-800">
                    {{ $headingText }}
                </h3>
                <span id="tabelBadgeCount" class="text-[11px] font-medium text-slate-400"></span>
            </div>

            <!-- Search Box (Full Width) -->
            <div class="relative flex items-center shrink-0">
                <input type="text"
                       id="tabelSearchInput"
                       oninput="handleSearchTable(this.value)"
                       placeholder="{{ $searchPlaceholder }}"
                       class="w-full bg-[#f4f6f8] hover:bg-[#eef2f5] focus:bg-white border border-transparent focus:border-amber-400 rounded-xl pl-4 pr-10 py-2 sm:py-2.5 text-xs sm:text-sm text-slate-700 placeholder-slate-400 focus:outline-none transition-all">
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-[#f98825]" style="top: 0; bottom: 0; right: 0;">
                    <i class="fa-solid fa-magnifying-glass text-xs sm:text-sm leading-none"></i>
                </div>
            </div>

            <!-- Tables List Table (Full Width) -->
            <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-2xs bg-white flex-1 min-h-[180px] sm:min-h-[220px] flex flex-col">
                <div class="overflow-x-auto overflow-y-auto flex-1 min-h-0 w-full">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 sticky top-0 z-10 bg-white text-[10px] sm:text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                                <th class="py-2.5 px-2.5 sm:px-4 w-16 sm:w-24 select-none cursor-pointer hover:text-slate-600" onclick="sortTableData('code')">
                                    <span>KODE</span> <i class="fa-solid fa-sort text-[8px] ml-0.5 opacity-60"></i>
                                </th>
                                <th class="py-2.5 px-2.5 sm:px-4 select-none cursor-pointer hover:text-slate-600" onclick="sortTableData('title')">
                                    <span>JUDUL TABEL</span> <i class="fa-solid fa-sort text-[8px] ml-0.5 opacity-60"></i>
                                </th>
                                <th class="py-2.5 px-2.5 sm:px-4 text-center w-24 sm:w-32 text-slate-400">
                                    <span>AKSI</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tabelListTableBody" class="divide-y divide-slate-100 text-xs">
                            <!-- Rendered dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer of Table: Tampilkan 10 hasil & Pagination -->
            <div class="flex flex-wrap items-center justify-between gap-3 pt-2 text-xs text-slate-500 shrink-0">
                <div class="flex items-center space-x-1.5 text-[11px] sm:text-xs">
                    <span>Tampilkan</span>
                    <div class="relative inline-block">
                        <select id="itemsPerPageSelect" onchange="changeItemsPerPage(this.value)"
                            class="appearance-none bg-[#fef6ee] hover:bg-[#fdeedc] text-[#f98825] border border-[#fbd4aa] rounded-lg px-2.5 py-0.5 pr-6 text-xs font-bold focus:outline-none cursor-pointer">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <div class="absolute inset-y-0 right-1.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-[8px] text-[#f98825] leading-none"></i>
                        </div>
                    </div>
                    <span>hasil</span>
                </div>

                <div class="flex items-center space-x-1" id="tabelPagination">
                    <!-- Pagination controls -->
                </div>
            </div>

            @if($isAdmin)
            <!-- Action Bar Bawah: Tambah Tabel Baru (HANYA ADMINISTRATOR BPS) -->
            <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 shrink-0">
                <div class="flex items-center space-x-2 text-[11px] text-slate-500">
                    <span class="w-5 h-5 rounded-full bg-amber-100 text-[#f98825] flex items-center justify-center font-bold text-[10px] shrink-0">
                        <i class="fa-solid fa-plus"></i>
                    </span>
                    <span>Perlu menambahkan tabel statistik sektoral baru untuk instansi ini?</span>
                </div>
                <button type="button" 
                        onclick="openAddTableModal()" 
                        class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl bg-[#f98825] hover:bg-[#e07212] text-white text-xs font-bold shadow-xs hover:shadow-md transition-all cursor-pointer">
                    <i class="fa-solid fa-table-list text-xs"></i>
                    <span>+ Tambah Tabel Baru</span>
                </button>
            </div>
            @endif

        </div>

    </div>
</div>

