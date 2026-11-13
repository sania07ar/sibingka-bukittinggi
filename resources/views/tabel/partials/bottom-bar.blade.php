<!-- TABLE FOOTER: NOTE & SOURCE / SUMBER -->
<div class="text-xs text-slate-700 space-y-2 pt-2 border-t border-slate-100 table-footer-notes">
    <div id="tableNoteRow" class="hidden grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-2">
        <div class="sm:col-span-2 font-bold flex space-x-1">
            <span>Catatan</span>
            <span class="font-normal">/</span>
            <span class="italic font-normal text-slate-500">Note:</span>
        </div>
        <div class="sm:col-span-10 text-slate-800 font-medium leading-relaxed" id="tableNoteContent">
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-2">
        <div class="sm:col-span-2 font-bold flex space-x-1">
            <span>Sumber</span>
            <span class="font-normal">/</span>
            <span class="italic font-normal text-slate-500">Source:</span>
        </div>
        <div class="sm:col-span-10 text-slate-800 font-medium leading-relaxed" id="tableSourceContent">
            {{ $dbMetadata?->source ?? 'Badan Pusat Statistik Kota Bukittinggi' }}
        </div>
    </div>
</div>

<!-- PRINT ONLY FOOTER (OFFICIAL VERIFICATION LINE) -->
<div class="print-only print-footer-info">
    <span>Dokumen resmi publikasi statistik sektoral diexport melalui SiAngka BPS Kota Bukittinggi.</span>
    <span>Standar Publikasi Daerah Dalam Angka (DDA) &bull; Format Excel Landscape</span>
</div>

<!-- BOTTOM ACTION BAR -->
<div id="bottomActionBar" class="mt-8 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
    <button onclick="window.history.back()" 
            class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center space-x-2 cursor-pointer">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        <span>Kembali ke Halaman Sebelumnya</span>
    </button>
</div>

