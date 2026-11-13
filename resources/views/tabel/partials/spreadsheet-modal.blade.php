    <!-- GOOGLE SPREADSHEET VIEW & PUBLICATION EXPORT MODAL -->
    <div id="spreadsheetModal" style="z-index: 105;" class="fixed inset-0 hidden items-center justify-center p-2 sm:p-4 md:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-6xl w-full h-[90vh] flex flex-col shadow-2xl border border-slate-300 overflow-hidden transform transition-all scale-95 opacity-0 duration-200" id="spreadsheetModalCard">
            
            <!-- SHEETS APP HEADER BAR -->
            <div class="px-4 py-2.5 bg-[#f8f9fa] border-b border-slate-200 flex flex-wrap items-center justify-between gap-2 shrink-0">
                <div class="flex items-center space-x-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-[#0F9D58] text-white flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-file-excel text-base"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center space-x-2">
                            <h3 id="spreadsheetDocTitle" class="text-xs sm:text-sm font-bold text-slate-800 truncate leading-tight">Publikasi_Pusat_Tabel</h3>
                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 shrink-0">Google Sheets Ready</span>
                        </div>
                        <p class="text-[10px] text-slate-500 truncate leading-tight mt-0.5">Tampilan kisi spreadsheet standar untuk disalin langsung ke naskah publikasi BPS Pusat</p>
                    </div>
                </div>

                <div class="flex items-center flex-wrap gap-2">
                    <!-- Tombol Salin Lengkap -->
                    <button onclick="copyTableForSpreadsheet(false)" 
                            class="px-3.5 py-1.5 rounded-xl bg-[#0F9D58] hover:bg-[#0B8043] text-white text-xs font-bold shadow-xs hover:shadow-md transition-all flex items-center space-x-1.5 cursor-pointer"
                            title="Salin judul, tabel lengkap, dan sumber ke clipboard">
                        <i class="fa-solid fa-copy text-xs"></i>
                        <span>Salin Seluruh Tabel</span>
                    </button>

                    <!-- Tombol Salin Data Saja -->
                    <button onclick="copyTableForSpreadsheet(true)" 
                            class="px-3 py-1.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 hover:text-slate-900 text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5 cursor-pointer"
                            title="Hanya salin baris rincian data dan total tanpa judul & header">
                        <i class="fa-solid fa-table-cells text-xs text-slate-500"></i>
                        <span>Salin Angka Saja</span>
                    </button>

                    <!-- Tombol Unduh XLSX -->
                    <button onclick="exportToExcel()" 
                            class="px-3 py-1.5 rounded-xl bg-white hover:bg-emerald-50 border border-emerald-300 text-[#0F9D58] hover:text-[#0B8043] text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5 cursor-pointer"
                            title="Unduh berkas Microsoft Excel (.xlsx)">
                        <i class="fa-solid fa-download text-xs"></i>
                        <span class="hidden sm:inline">Unduh XLSX</span>
                    </button>

                    <!-- Tombol Tutup -->
                    <button onclick="closeSpreadsheetModal()" 
                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors cursor-pointer"
                            title="Tutup (Esc)">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- SHEETS FORMULA BAR (FX BAR) -->
            <div class="px-3 py-1.5 bg-white border-b border-slate-200 flex items-center space-x-2 text-xs shrink-0 select-none">
                <div id="spreadsheetActiveCellLabel" class="w-14 text-center py-1 bg-slate-100 border border-slate-300 rounded font-mono font-bold text-slate-700 text-[11px]">
                    A1
                </div>
                <div class="text-slate-400 font-serif italic font-black text-xs px-1 select-none">
                    fx
                </div>
                <input type="text" id="spreadsheetFormulaInput" readonly 
                       placeholder="Klik sel pada tabel di bawah untuk melihat isi atau menyalinnya..."
                       class="flex-1 bg-slate-50 border border-slate-200 rounded px-2.5 py-1 text-xs text-slate-800 font-mono focus:outline-none focus:border-emerald-500" />
                <span class="text-[10px] text-slate-400 font-medium px-2 hidden md:inline">
                    <i class="fa-regular fa-lightbulb text-amber-500 mr-1"></i>Tekan <strong>Ctrl + V</strong> di Google Spreadsheet setelah klik tombol Salin
                </span>
            </div>

            <!-- SPREADSHEET GRID CONTAINER -->
            <div class="flex-1 overflow-auto bg-[#e8eaed] p-2 sm:p-4 select-text">
                <div class="bg-white rounded-lg shadow-sm border border-slate-300 inline-block min-w-full">
                    <table id="spreadsheetGridTable" class="border-collapse text-[11.5px] font-sans w-full text-slate-800">
                        <!-- Populated by JS -->
                    </table>
                </div>
            </div>

            <!-- SHEETS FOOTER BAR -->
            <div class="px-4 py-2 bg-[#f8f9fa] border-t border-slate-200 flex items-center justify-between text-xs text-slate-600 shrink-0">
                <div class="flex items-center space-x-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span id="spreadsheetStatsInfo" class="font-medium text-[11px] text-slate-600">0 baris, 0 kolom</span>
                </div>
                <div class="flex items-center space-x-3 text-[11px]">
                    <span class="text-slate-400 hidden sm:inline">Penyusun: BPS Kota Bukittinggi (SiBingka)</span>
                    <button onclick="copyTableForSpreadsheet(false)" class="text-emerald-700 hover:text-emerald-900 font-bold hover:underline cursor-pointer">
                        <i class="fa-solid fa-copy mr-1"></i>Salin ke Clipboard
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- SPREADSHEET TOAST NOTIFICATION -->
    <div id="spreadsheetToast" class="fixed bottom-6 right-6 z-110 hidden items-center space-x-3 bg-slate-900/95 text-white px-4 py-3 rounded-2xl shadow-2xl border border-slate-700/80 transform transition-all duration-300 translate-y-4 opacity-0">
        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
            <i class="fa-solid fa-check text-sm font-bold"></i>
        </div>
        <div>
            <p id="spreadsheetToastTitle" class="text-xs font-bold text-white">Berhasil Disalin!</p>
            <p id="spreadsheetToastDesc" class="text-[11px] text-slate-300">Buka Google Spreadsheet atau Publikasi Pusat, lalu tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-400 font-mono text-[10px] font-bold">Ctrl + V</kbd></p>
        </div>
    </div>
</body>
