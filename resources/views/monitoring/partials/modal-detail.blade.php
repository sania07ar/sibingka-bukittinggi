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

        <!-- Modal Action: Status Validasi BPS & Verifikasi Wali Data -->
        @php
            $userRole = session('user.role');
            $isAdmin = ($userRole === 'admin');
            $isWali = ($userRole === 'walidata');
        @endphp
        <div class="my-3.5 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80">
            <div class="flex items-center justify-between mb-2.5">
                <div>
                    <span class="text-xs font-bold text-slate-800">Status Validasi & Verifikasi:</span>
                    <p class="text-[10px] text-slate-500">Alur: Input Data &rarr; Verifikasi Wali Data (Diskominfo) &rarr; Validasi BPS (Admin BPS)</p>
                </div>
                <span id="modalCurrentStageBadge" class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-orange-100 text-[#f95a00]">Verifikasi</span>
            </div>
            @if($isAdmin)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-center">
                    <button type="button" onclick="changeModalValidasiBps(3)" id="modalBpsValidateBtn" class="px-3 py-2 rounded-xl text-xs font-bold border border-emerald-300 bg-emerald-50 hover:bg-emerald-600 hover:text-white text-emerald-800 transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Beri Validasi BPS (ACC Selesai)</span>
                    </button>
                    <button type="button" onclick="changeModalValidasiBps(2)" id="modalBpsUnvalidateBtn" class="px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-300 text-slate-600 transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Batalkan Validasi BPS</span>
                    </button>
                </div>
                <div id="modalBpsNotice" class="hidden mt-2 p-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs text-center font-medium">
                    <i class="fa-solid fa-lock text-amber-600 mr-1"></i>
                    <span>Validasi BPS hanya dapat dilakukan ketika Wali Data sudah memverifikasi data ini.</span>
                </div>
            @elseif($isWali)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-center">
                    <button type="button" onclick="changeModalValidasiBps(2)" id="modalWaliValidateBtn" class="px-3 py-2 rounded-xl text-xs font-bold border border-[#f95a00] bg-orange-50 hover:bg-[#f95a00] hover:text-white text-[#f95a00] transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs">
                        <i class="fa-solid fa-check"></i>
                        <span>Verifikasi Data (Wali Data)</span>
                    </button>
                    <button type="button" onclick="changeModalValidasiBps(1)" id="modalWaliRejectBtn" class="px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-300 text-slate-600 transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Minta Perbaikan ke Dinas</span>
                    </button>
                </div>
                <div id="modalWaliNotice" class="hidden mt-2 p-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-600 text-xs text-center font-medium">
                    <i class="fa-solid fa-hourglass-start text-slate-500 mr-1"></i>
                    <span>Data belum dapat diverifikasi karena dinas/instansi/BPS belum mengirim/meneruskan data ke Wali Data.</span>
                </div>
            @else
                <p class="text-[11px] font-medium text-slate-500 italic">Status validasi hanya dapat diubah oleh Administrator BPS dan Wali Data Kota Bukittinggi.</p>
            @endif
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

