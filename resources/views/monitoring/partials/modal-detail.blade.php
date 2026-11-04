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
                    Log pemantauan aktivitas pengumpulan data <span id="modalAgencyShortName" class="font-bold text-slate-800">-</span>
                </p>
            </div>
            
            <div class="flex items-center space-x-2 shrink-0">
                <button type="button" 
                        onclick="exportCurrentAgencyLog()"
                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors cursor-pointer"
                        title="Ekspor riwayat aktivitas ke Excel">
                    <i class="fa-solid fa-download text-[11px] text-slate-500"></i>
                    <span>Ekspor Data</span>
                </button>
                
                <button type="button" 
                        onclick="closeAgencyDetailModal()" 
                        class="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center cursor-pointer transition-colors"
                        title="Tutup">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Modal Stage Selector: Ubah Status Tahapan -->
        <div class="my-3.5 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80">
            <div class="flex items-center justify-between mb-2.5">
                <div>
                    <span class="text-xs font-bold text-slate-800">Ubah Tahapan Status Progres:</span>
                    <p class="text-[10px] text-slate-500">Sesuaikan tahapan riil (Persiapan s.d. Publikasi BPS)</p>
                </div>
                <span id="modalCurrentStageBadge" class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-orange-100 text-[#f95a00]">Validasi BPS</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-1.5 text-center">
                <button type="button" onclick="changeModalStage(1)" id="modalStageBtn1" class="modal-stage-btn px-2 py-1.5 rounded-xl text-[11px] font-bold border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 transition-all cursor-pointer">
                    1. Persiapan
                </button>
                <button type="button" onclick="changeModalStage(2)" id="modalStageBtn2" class="modal-stage-btn px-2 py-1.5 rounded-xl text-[11px] font-bold border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 transition-all cursor-pointer">
                    2. Input Data
                </button>
                <button type="button" onclick="changeModalStage(3)" id="modalStageBtn3" class="modal-stage-btn px-2 py-1.5 rounded-xl text-[11px] font-bold border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 transition-all cursor-pointer">
                    3. Verifikasi
                </button>
                <button type="button" onclick="changeModalStage(4)" id="modalStageBtn4" class="modal-stage-btn px-2 py-1.5 rounded-xl text-[11px] font-bold border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 transition-all cursor-pointer">
                    4. Validasi BPS
                </button>
                <button type="button" onclick="changeModalStage(5)" id="modalStageBtn5" class="modal-stage-btn px-2 py-1.5 rounded-xl text-[11px] font-bold border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 transition-all cursor-pointer">
                    5. Publikasi
                </button>
            </div>
        </div>

        <!-- Modal Body: Vertical Timeline -->
        <div id="modalTimelineContainer" class="py-5 space-y-5 max-h-[60vh] overflow-y-auto pr-1">
            <!-- Dynamically populated via JS -->
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

