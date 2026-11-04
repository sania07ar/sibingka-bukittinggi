<!-- POPUP PILIH TAHUN DATA (MUNCUL SAAT KLIK INPUT PADA TABEL) -->
<div id="yearModal" style="z-index: 80;" class="fixed inset-0 hidden items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
    <div class="bg-white rounded-2xl max-w-md w-full p-5 sm:p-6 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative" id="yearModalCard">
        
        <!-- Modal Header -->
        <div class="flex items-start justify-between border-b border-slate-100 pb-3 mb-4">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-orange-100 text-[#f98825] flex items-center justify-center text-xs font-black shrink-0" id="selectedTableBadge">
                    1.1.1
                </div>
                <div>
                    <h3 id="selectedTableTitle" class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">
                        Nama Tabel
                    </h3>
                    <p id="selectedOpdSubtitle" class="text-[11px] text-slate-400 font-medium">-</p>
                </div>
            </div>
            <button onclick="closeYearModal()" class="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors shrink-0 cursor-pointer" title="Tutup">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        <!-- Modal Body: Pilih Tahun -->
        <div class="space-y-4">
            <div>
                <label for="selectedYearSelect" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Pilih Tahun:
                </label>
                <div class="relative">
                    <select id="selectedYearSelect" 
                            class="w-full bg-[#f4f6f8] hover:bg-[#eef2f5] focus:bg-white border border-slate-200 focus:border-[#f98825] rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 font-semibold focus:outline-none transition-all cursor-pointer appearance-none">
                        <option value="" selected disabled>Pilih Tahun</option>
                    </select>
                    <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="mt-5 pt-3.5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
            <button onclick="closeYearModal()" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors cursor-pointer">
                Batal
            </button>
            <div class="flex items-center space-x-2">
                <button onclick="submitSelectedYear()" class="px-4 py-2 rounded-xl bg-[#f98825] hover:bg-[#e07212] text-white text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5 cursor-pointer" title="Buka format tabel publikasi BPS">
                    <i class="fa-solid fa-table-cells text-[11px]"></i>
                    <span>Buka Data Tabel</span>
                </button>
            </div>
        </div>

    </div>
</div>

