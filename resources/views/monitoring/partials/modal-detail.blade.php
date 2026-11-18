<!-- DETAIL MODAL: RIWAYAT AKTIVITAS & PROGRESS -->
<div id="agencyDetailModal" class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl border border-slate-100 transform transition-all animate-in fade-in zoom-in-95 duration-150 relative">
        
        <!-- Modal Header -->
        <div class="flex items-start justify-between pb-4 border-b border-slate-100 gap-3">
            <div>
                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight uppercase">
                    RIWAYAT AKTIVITAS & PROGRESS
                </h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Aktivitas pengumpulan data <span id="modalAgencyShortName" class="font-bold text-slate-800">-</span>
                </p>
            </div>
            
            <button type="button" 
                    onclick="closeAgencyDetailModal()" 
                    class="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center cursor-pointer transition-colors shrink-0"
                    title="Tutup">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        @php
            $userRole = session('user.role');
            $isAdmin = ($userRole === 'admin');
            $isWali = ($userRole === 'walidata');
        @endphp

        <!-- Detail aktivitas, mengikuti urutan tahap: 1 Input Data -> 2 Verifikasi Wali Data -> 3 Validasi BPS -->
        <div id="modalTimelineContainer" class="py-3 max-h-[62vh] overflow-y-auto pr-1 space-y-3">

            <!-- Tahap saat ini -->
            <div class="flex items-center justify-between text-[11px] text-slate-500 px-1">
                <span>Tahap saat ini</span>
                <span id="modalCurrentStageBadge" class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-orange-100 text-[#f95a00]">Input Data</span>
            </div>

            <!-- 1. INPUT DATA -->
            <section class="rounded-2xl border border-slate-200/80 bg-white">
                <div class="px-4 pt-3.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#f95a00] text-white text-[11px] font-black flex items-center justify-center">1</span>
                            <h4 class="text-[13px] font-extrabold text-slate-900">Input Data</h4>
                        </div>
                        <span id="modalPctInput" class="text-sm font-black text-slate-900">0%</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-slate-100 mt-2 overflow-hidden"><div id="modalBarInput" class="h-full rounded-full bg-[#f95a00]" style="width:0%"></div></div>
                    <div id="modalCntInput" class="text-[10px] text-slate-400 mt-1">0 dari 0 tabel</div>
                </div>
                <div id="modalListInput" class="px-4 pb-2 mt-1"></div>
            </section>

            <!-- 2. VERIFIKASI WALI DATA -->
            <section class="rounded-2xl border border-slate-200/80 bg-white">
                <div class="px-4 pt-3.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-sky-600 text-white text-[11px] font-black flex items-center justify-center">2</span>
                            <h4 class="text-[13px] font-extrabold text-slate-900">Verifikasi Wali Data</h4>
                        </div>
                        <span id="modalPctVerif" class="text-sm font-black text-slate-900">0%</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-slate-100 mt-2 overflow-hidden"><div id="modalBarVerif" class="h-full rounded-full bg-sky-500" style="width:0%"></div></div>
                    <div id="modalCntVerif" class="text-[10px] text-slate-400 mt-1">0 dari 0 tabel</div>
                </div>
                <div id="modalListVerif" class="px-4 pb-2 mt-1"></div>
                @if($isWali)
                    <div class="px-4 pb-3.5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-center">
                            <button type="button" onclick="changeModalValidasiBps(2)" id="modalWaliValidateBtn" class="px-3 py-2 rounded-xl text-xs font-bold border border-[#f95a00] bg-[#f95a00] text-white hover:bg-orange-700 transition-all flex items-center justify-center space-x-1.5 cursor-pointer">
                                <i class="fa-solid fa-check"></i>
                                <span>Verifikasi Data (Wali Data)</span>
                            </button>
                            <button type="button" onclick="changeModalValidasiBps(1)" id="modalWaliRejectBtn" class="px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 transition-all flex items-center justify-center space-x-1.5 cursor-pointer">
                                <i class="fa-solid fa-rotate-left"></i>
                                <span>Minta Perbaikan ke Dinas</span>
                            </button>
                        </div>
                        <div id="modalWaliNotice" class="hidden mt-2 p-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-600 text-xs text-center font-medium">
                            <i class="fa-solid fa-hourglass-start text-slate-500 mr-1"></i>
                            <span>Data belum dapat diverifikasi karena belum ada tabel yang dikirim.</span>
                        </div>
                    </div>
                @endif
            </section>

            <!-- 3. VALIDASI BPS -->
            <section class="rounded-2xl border border-slate-200/80 bg-white">
                <div class="px-4 pt-3.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white text-[11px] font-black flex items-center justify-center">3</span>
                            <h4 class="text-[13px] font-extrabold text-slate-900">Validasi BPS</h4>
                        </div>
                        <span id="modalPctValid" class="text-sm font-black text-slate-900">0%</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-slate-100 mt-2 overflow-hidden"><div id="modalBarValid" class="h-full rounded-full bg-emerald-500" style="width:0%"></div></div>
                    <div id="modalCntValid" class="text-[10px] text-slate-400 mt-1">0 dari 0 tabel</div>
                </div>
                <div id="modalListValid" class="px-4 pb-2 mt-1"></div>
            </section>
        </div>

        <!-- Modal Footer: Link & Pagination -->
        <div class="pt-3.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <a id="modalAgencyGoLink" 
               href="#" 
               class="inline-flex items-center space-x-1.5 text-xs font-bold text-[#f95a00] hover:text-[#e04e00] transition-colors no-underline">
                <span id="modalAgencyGoLinkText">Buka Halaman Input Data</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>

            <!-- Pagination Buttons on Bottom Right -->
            <div class="flex items-center space-x-1">
                <button type="button" 
                        class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer"
                        title="Sebelumnya">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                </button>
                <button type="button" 
                        class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 hover:text-slate-900 flex items-center justify-center transition-colors cursor-pointer"
                        title="Selanjutnya">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>

    </div>
</div>

