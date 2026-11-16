        <!-- MAIN TABLE EDIT CONTAINER -->
        <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-10 py-2 sm:py-5 flex-1 w-full">
            
            <!-- TABLE CARD -->
            <div class="bg-white rounded-2xl p-3 sm:p-7 md:p-8 shadow-sm border border-slate-200/90 relative transition-all">
                
                <!-- TOP CARD HEADER BAR: 4-Square Grid Icon + Title + Edit Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-4 mb-4 sm:mb-6 gap-3">
                    <div class="flex items-center space-x-3">
                        <!-- 4-Square Grid Icon -->
                        <div class="grid grid-cols-2 gap-0.5 w-5 h-5 shrink-0" aria-hidden="true">
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                            <div class="w-2 h-2 rounded-[2.5px] bg-[#f98825]"></div>
                        </div>

                        <!-- Title: Edit Tabel 1.1.6 Tahun 2025 -->
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 id="pageMainHeading" class="text-base sm:text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                    Edit Data Tabel {{ $currentTableCode ?? '1.1.6' }} Tahun {{ $currentYear ?? '2025' }}
                                </h2>
                                <span class="px-2 sm:px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[9px] sm:text-[10px] uppercase tracking-wider shrink-0">
                                    Editor
                                </span>
                            </div>
                            <p id="subHeadingOpd" class="text-xs text-slate-500 font-medium">{{ $currentOpdCode }}. {{ $opdName }}</p>
                        </div>
                    </div>

                    <!-- Right Header Actions: Table Switcher + Import Excel + Reset + Save & Cancel -->
                    <div id="actionHeaderRight" class="flex items-center flex-wrap gap-1.5 sm:gap-2">
                        <!-- Table Switcher Selector (Hanya Tampil 'Tabel X.X.X', Deskripsi Muncul Saat Ditekan) -->
                        <div class="relative flex items-center space-x-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 rounded-lg px-2 sm:px-2.5 py-1.5 transition-colors shadow-2xs cursor-pointer group" title="Ganti tabel dalam instansi ini">
                            <i class="fa-solid fa-table-list text-slate-400 text-xs shrink-0 pointer-events-none group-hover:text-[#f95a00] transition-colors"></i>
                            <span id="tableSwitcherLabel" class="text-xs font-bold text-slate-700 pointer-events-none select-none max-w-[95px] sm:max-w-none truncate">Tabel {{ $currentTableCode ?? '1.1.6' }}</span>
                            <i class="fa-solid fa-chevron-down text-[8px] text-slate-400 pointer-events-none"></i>
                            <select id="tableSwitcher" onchange="changeTableCode(this.value)" 
                                    onfocus="if (this.options.length <= 1 && typeof updateTableSwitcher === 'function') updateTableSwitcher();"
                                    onmousedown="if (this.options.length <= 1 && typeof updateTableSwitcher === 'function') updateTableSwitcher();"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer text-xs z-10">
                                <option value="{{ $currentTableCode ?? '1.1.6' }}" selected>Tabel {{ $currentTableCode ?? '1.1.6' }}</option>
                            </select>
                        </div>


                        <!-- Import Excel Button -->
                        <button onclick="document.getElementById('editExcelInput').click()" 
                                class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs flex items-center space-x-1 sm:space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Impor nilai data dari berkas Excel (.xlsx / .xls)">
                            <i class="fa-solid fa-file-excel text-emerald-600 text-[11px]"></i>
                            <span><span class="hidden sm:inline">Import </span>Excel</span>
                        </button>
                        <input type="file" id="editExcelInput" accept=".xlsx, .xls, .csv" class="hidden" onchange="handleEditExcelImport(event)">

                        <!-- Tambah Baris Button -->
                        <button onclick="addNewRow()" 
                                class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-orange-50 hover:bg-orange-100 text-[#f95a00] border border-orange-300 font-bold text-xs flex items-center space-x-1 sm:space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Tambah baris data baru ke tabel ini">
                            <i class="fa-solid fa-plus text-[11px]"></i>
                            <span>+ <span class="hidden sm:inline">Tambah </span>Baris</span>
                        </button>

                        <button onmousedown="window._isResetting = true;" onclick="resetTableOriginal()" 
                                class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300 font-bold text-xs flex items-center space-x-1 sm:space-x-1.5 shadow-2xs transition-all cursor-pointer"
                                title="Kembalikan nilai ke data awal">
                            <i class="fa-solid fa-rotate-left text-[11px]"></i>
                            <span>Reset<span class="hidden sm:inline"> Nilai</span></span>
                        </button>

                        <button onclick="backToTableView()" 
                                class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 font-bold text-xs flex items-center space-x-1 sm:space-x-1.5 shadow-2xs transition-all cursor-pointer">
                            <i class="fa-solid fa-xmark text-[11px]"></i>
                            <span>Batal</span>
                        </button>

                        @php
                            $userRole = session('user.role');
                            $isAdmin = ($userRole === 'admin');
                            $isWali = ($userRole === 'walidata');
                            $canVerify = ($isAdmin || $isWali);
                            $isLocked = (bool) ($dbMetadata?->is_locked ?? false);
                            $vStatus = $dbMetadata?->verification_status ?? 'draft';
                        @endphp

                        @if($isLocked && !$isAdmin)
                            <button disabled 
                                    class="px-3 sm:px-4 py-1.5 rounded-lg bg-slate-300 text-slate-500 font-bold text-xs flex items-center space-x-1 sm:space-x-1.5 cursor-not-allowed"
                                    title="Tabel terkunci karena sudah diverifikasi/ACC.">
                                <i class="fa-solid fa-lock text-xs"></i>
                                <span>Terkunci</span>
                            </button>
                        @else
                            <button onclick="saveAndReturn()" 
                                    class="px-3 sm:px-4 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center space-x-1 sm:space-x-1.5 shadow-2xs transition-all cursor-pointer">
                                <i class="fa-solid fa-floppy-disk text-xs"></i>
                                <span>Simpan<span class="hidden sm:inline"> Perubahan</span></span>
                            </button>
                        @endif
                    </div>
                </div>

                @if($isLocked && !$isAdmin)
                    <div class="mb-5 p-3.5 sm:p-4 rounded-2xl bg-amber-50 border border-amber-300 text-amber-900 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shrink-0 shadow-2xs">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                                <span class="font-extrabold text-amber-950 block text-[13px]">Tabel Terkunci (Read-Only)</span>
                                <span class="text-amber-800 text-[11.5px]">Data tabel ini telah disetujui (ACC) oleh BPS Bukittinggi. Perubahan tidak dapat disimpan tanpa persetujuan Admin BPS.</span>
                            </div>
                        </div>
                        <button onclick="backToTableView()" class="px-3.5 py-1.5 bg-white hover:bg-amber-100 rounded-xl border border-amber-300 font-bold text-amber-900 transition-colors shrink-0 cursor-pointer shadow-2xs">
                            Kembali ke Tabel
                        </button>
                    </div>
                @endif

                <!-- TABLE TITLE & METADATA SECTION -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 mb-5 text-xs sm:text-sm text-slate-900">
                    
                    <!-- Left Column: Tabel / Table Number -->
                    <div class="md:col-span-3 flex items-start space-x-4">
                        <div class="flex flex-col font-bold text-slate-900 space-y-1">
                            <span>Tabel</span>
                            <span class="italic font-normal text-slate-600">Table</span>
                        </div>
                        <div class="flex flex-col font-bold text-slate-900 space-y-1">
                            <span id="metaTableCode">{{ $currentTableCode ?? '1.1.6' }}</span>
                            <span class="opacity-0">.</span>
                        </div>
                    </div>

                    <!-- Right Column: Tabel Title (Indonesian & English) -->
                    <div class="md:col-span-9 flex flex-col space-y-1">
                        <div id="metaTableTitleId" class="font-bold text-slate-900 leading-snug">
                            {{ $dbMetadata?->title_id ?? 'Judul Tabel' }}
                        </div>
                        <div id="metaTableTitleEn" class="italic font-normal text-slate-600 leading-snug">
                            {{ $dbMetadata?->title_en ?? 'Table Title' }}
                        </div>
                    </div>

                </div>

                <!-- INSTRUCTION BANNER -->
                <div class="mb-5 p-3.5 rounded-xl bg-orange-50 border border-orange-200 text-orange-950 text-xs flex items-center justify-between gap-3 shadow-2xs">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-[#f95a00] text-white flex items-center justify-center font-bold text-sm shadow-2xs shrink-0">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900">Petunjuk Pengeditan:</span>
                            <p class="text-slate-600 text-[11px] mt-0.5">Ubah angka atau teks pada kotak oranye di bawah ini (termasuk judul kolom & nomor kolom pada kepala tabel). Setelah selesai, klik tombol <strong>"Simpan Perubahan"</strong> di atas atau di bawah tabel.</p>
                        </div>
                    </div>
                </div>

                <!-- Mobile Horizontal Scroll Hint (Hanya muncul jika tabel meluap & hilang saat digeser) -->
                <div id="mobileScrollHint" class="hidden sm:hidden flex items-center justify-between text-[11px] text-slate-500 bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-1.5 mb-3 select-none transition-all duration-300">
                    <span class="flex items-center gap-1.5 font-medium min-w-0 truncate">
                        <i class="fa-solid fa-arrows-left-right text-[#f95a00] text-xs shrink-0"></i>
                        <span class="truncate">Geser tabel ke samping untuk mengedit seluruh kolom</span>
                    </span>
                    <div class="flex items-center space-x-2 shrink-0 ml-2">
                        <i class="fa-solid fa-hand-pointer text-slate-400 text-xs animate-pulse"></i>
                        <button type="button" onclick="dismissMobileScrollHint()" class="text-slate-400 hover:text-slate-600 p-0.5 cursor-pointer" title="Tutup">
                            <i class="fa-solid fa-xmark text-[10px]"></i>
                        </button>
                    </div>
                </div>

                <!-- TABLE DISPLAY CONTAINER (SCROLLABLE ON MOBILE) -->
                <div class="overflow-x-auto mb-3" id="printableTableSection">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse table-custom-border" id="dataDisplayTable">
                        <!-- Injected via JavaScript based on table code and year -->
                    </table>
                </div>

                <!-- ACTION ROW UNDER TABLE: + Tambah Baris Data -->
                <div class="flex items-center justify-between mb-5">
                    <button type="button" onclick="addNewRow()" 
                            class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl bg-orange-100 hover:bg-[#f98825] text-[#f98825] hover:text-white font-bold text-xs border border-orange-300 hover:border-transparent transition-all shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>+ Tambah Baris Data</span>
                    </button>
                    <span class="text-[11px] text-slate-400 italic">Klik tombol di atas untuk menambah baris data baru ke tabel.</span>
                </div>

                <!-- TABLE FOOTER: NOTE & SOURCE / SUMBER -->
                <div class="text-xs text-slate-700 space-y-2 pt-2 border-t border-slate-100 mb-6">
                    <div id="tableNoteRow" class="hidden grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-2">
                        <div class="sm:col-span-2 font-bold flex space-x-1">
                            <span>Catatan</span>
                            <span class="font-normal">/</span>
                            <span class="italic font-normal text-slate-500">Note:</span>
                        </div>
                        <div class="sm:col-span-10 text-slate-700 leading-relaxed" id="tableNoteContent">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-2">
                        <div class="sm:col-span-2 font-bold flex space-x-1">
                            <span>Sumber</span>
                            <span class="font-normal">/</span>
                            <span class="italic font-normal text-slate-500">Source:</span>
                        </div>
                        <div class="sm:col-span-10 text-slate-600" id="tableSourceContent">
                            Dinas Pekerjaan Umum dan Penataan Ruang Kota Bukittinggi / <span class="italic text-slate-500">Public Work and Spatial Planning Service of Bukittinggi Municipality</span>
                        </div>
                    </div>
                </div>

                <!-- BOTTOM ACTION BAR -->
                <div id="bottomActionBar" class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-slate-200">
                    <button onclick="backToTableView()" 
                            class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-2 cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Batal & Kembali ke Tabel</span>
                    </button>

                    <div class="flex items-center flex-wrap gap-2">
                        <button onmousedown="window._isResetting = true;" onclick="resetTableOriginal()" 
                                class="px-4 py-2 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300 text-xs font-bold transition-all flex items-center space-x-1.5 cursor-pointer shadow-2xs">
                            <i class="fa-solid fa-rotate-left text-xs"></i>
                            <span>Reset Nilai Asli</span>
                        </button>
                        <button onclick="saveAndReturn()" 
                                class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all flex items-center space-x-1.5 cursor-pointer shadow-2xs">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Simpan Perubahan Data</span>
                        </button>
                    </div>
                </div>

            </div>

        </main>
