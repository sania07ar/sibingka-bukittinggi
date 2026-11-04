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
<div id="{{ $modalId }}" style="z-index: 70;" class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-4 md:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
    <div class="bg-white rounded-2xl sm:rounded-3xl max-w-4xl lg:max-w-5xl w-full p-4 sm:p-6 md:p-7 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative overflow-hidden" id="{{ $cardId }}">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4 sm:mb-5">
            <!-- Left: Grid Icon + Title + Agency Name -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-500 shadow-2xs shrink-0">
                    <div class="grid grid-cols-2 gap-0.5 w-3.5 h-3.5">
                        <span class="bg-[#f98825] rounded-[2px]"></span>
                        <span class="bg-[#f98825] rounded-[2px]"></span>
                        <span class="bg-[#f98825] rounded-[2px]"></span>
                        <span class="bg-[#f98825] rounded-[2px]"></span>
                    </div>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-3 flex-wrap">
                    @if($badgeText)
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-orange-600 bg-orange-50 border border-orange-200 px-2 py-0.5 rounded-full">
                            {{ $badgeText }}
                        </span>
                    @endif
                    <h2 class="text-base sm:text-lg md:text-xl font-bold text-slate-800 tracking-tight">Input Tabel</h2>
                    <span id="{{ $headerTagId }}" class="text-xs sm:text-sm font-semibold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full border border-slate-200">
                        -
                    </span>
                </div>
            </div>

            <!-- Right: Drive Link (If BPS) & Close Button -->
            <div class="flex items-center space-x-2 shrink-0">
                @if($showDriveLink)
                    <a id="bpsDriveLinkHeader" 
                       href="#" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       title="Buka Folder Google Drive Dataset"
                       class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200/80 transition-colors">
                        <i class="fa-brands fa-google-drive text-amber-600"></i>
                        <span>Google Drive</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>
                @endif

                <button onclick="{{ $closeFn }}" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer" title="Tutup">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body (Full-Width Table) -->
        <div class="space-y-3.5 w-full">
            
            <div class="flex items-center justify-between mb-1">
                <h3 id="{{ $headingId }}" class="text-xs sm:text-sm md:text-[15px] font-bold text-slate-800">
                    {{ $headingText }}
                </h3>
                <span id="tabelBadgeCount" class="text-[11px] font-medium text-slate-400"></span>
            </div>

            <!-- Search Box (Full Width) -->
            <div class="relative flex items-center">
                <input type="text"
                       id="tabelSearchInput"
                       oninput="handleSearchTable(this.value)"
                       placeholder="{{ $searchPlaceholder }}"
                       class="w-full bg-[#f4f6f8] hover:bg-[#eef2f5] focus:bg-white border border-transparent focus:border-amber-400 rounded-xl pl-4 pr-10 py-2.5 text-xs sm:text-sm text-slate-700 placeholder-slate-400 focus:outline-none transition-all">
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-[#f98825]" style="top: 0; bottom: 0; right: 0;">
                    <i class="fa-solid fa-magnifying-glass text-xs sm:text-sm leading-none"></i>
                </div>
            </div>

            <!-- Tables List Table (Full Width) -->
            <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-2xs bg-white min-h-[240px]">
                <div class="overflow-x-auto max-h-[340px] overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 sticky top-0 z-10 bg-white text-[10px] sm:text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                                <th class="py-2.5 px-4 w-20 sm:w-24 select-none cursor-pointer hover:text-slate-600" onclick="sortTableData('code')">
                                    <span>KODE</span> <i class="fa-solid fa-sort text-[8px] ml-0.5 opacity-60"></i>
                                </th>
                                <th class="py-2.5 px-4 select-none cursor-pointer hover:text-slate-600" onclick="sortTableData('title')">
                                    <span>JUDUL TABEL</span> <i class="fa-solid fa-sort text-[8px] ml-0.5 opacity-60"></i>
                                </th>
                                <th class="py-2.5 px-4 text-center w-28 sm:w-32 text-slate-400">
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
            <div class="flex flex-wrap items-center justify-between gap-3 pt-2 text-xs text-slate-500">
                <div class="flex items-center space-x-1.5 text-[11px] sm:text-xs">
                    <span>Tampilkan</span>
                    <div class="relative inline-block">
                        <select id="itemsPerPageSelect" onchange="changeItemsPerPage(this.value)" class="appearance-none bg-[#fef6ee] hover:bg-[#fdeedc] text-[#f98825] border border-[#fbd4aa] rounded-lg px-2.5 py-0.5 pr-5 text-xs font-bold focus:outline-none cursor-pointer">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <i class="fa-solid fa-chevron-down text-[7px] text-[#f98825] absolute right-1.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    <span>hasil</span>
                </div>

                <div class="flex items-center space-x-1" id="tabelPagination">
                    <!-- Pagination controls -->
                </div>
            </div>

            @if($isAdmin)
            <!-- Action Bar Bawah: Tambah Tabel Baru (HANYA ADMINISTRATOR BPS) -->
            <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
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

