@php
    $isAdmin = session('user.role') === 'admin';
    $verificationStatus = $dbMetadata?->verification_status ?? 'draft';
    $isLocked = (bool) ($dbMetadata?->is_locked ?? false);
@endphp

<!-- TABLE TITLE & METADATA SECTION -->
<div id="tableMetadataSection" class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 mb-6 text-xs sm:text-sm text-slate-900">
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

<!-- VERIFICATION STATUS ALERT & AUDIT TRAIL -->
<div id="verificationStatusBanner" class="mb-4">
    @if($verificationStatus === 'approved')
        <div class="p-3.5 sm:p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-base shrink-0 shadow-2xs">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h4 class="text-xs sm:text-sm font-black text-emerald-950">Data Telah Divalidasi BPS Bukittinggi</h4>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-200 text-emerald-900">ACC &bull; Publikasi</span>
                    </div>
                    <p class="text-[11px] text-emerald-800 font-medium mt-0.5">
                        Tabel ini telah melalui tahapan pemeriksaan kewajaran data oleh Tim Pembina BPS Kota Bukittinggi dan siap dicetak untuk Buku Daerah Dalam Angka (DDA).
                    </p>
                </div>
            </div>
            <div class="text-right shrink-0">
                <span class="text-[10px] text-emerald-700 font-semibold block">Diverifikasi oleh: {{ $dbMetadata->verifier_name ?? 'Admin BPS' }}</span>
                <span class="text-[9px] text-emerald-600 block">{{ $dbMetadata->verified_at ? \Carbon\Carbon::parse($dbMetadata->verified_at)->isoFormat('D MMMM Y, HH:mm') : '' }}</span>
            </div>
        </div>
    @elseif($verificationStatus === 'submitted')
        <div class="p-3.5 sm:p-4 rounded-2xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-base shrink-0 shadow-2xs">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h4 class="text-xs sm:text-sm font-black text-amber-950">Menunggu Verifikasi BPS Kota Bukittinggi</h4>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-200 text-amber-900">Antrean Periksa</span>
                    </div>
                    <p class="text-[11px] text-amber-800 font-medium mt-0.5">
                        Data telah diajukan oleh dinas dan sedang dalam proses penelaahan konsistensi & kewajaran angka oleh Pembina Data Statistik BPS.
                    </p>
                </div>
            </div>
            @if($isAdmin)
                <div class="flex items-center space-x-2 shrink-0">
                    <button onclick="handleApproveTable()" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center space-x-1">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>ACC Data</span>
                    </button>
                    <button onclick="openRevisionModal()" class="px-3 py-1.5 rounded-xl bg-white hover:bg-rose-50 text-rose-700 border border-rose-300 text-xs font-bold transition-all shadow-2xs cursor-pointer flex items-center space-x-1">
                        <i class="fa-solid fa-triangle-exclamation text-[11px]"></i>
                        <span>Revisi</span>
                    </button>
                </div>
            @endif
        </div>
    @elseif($verificationStatus === 'revision')
        <div class="p-3.5 sm:p-4 rounded-2xl bg-rose-50 border border-rose-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-start space-x-3">
                <div class="w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center text-base shrink-0 shadow-2xs mt-0.5">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h4 class="text-xs sm:text-sm font-black text-rose-950">Catatan Revisi dari BPS Bukittinggi</h4>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-200 text-rose-900">Perlu Perbaikan</span>
                    </div>
                    <div class="text-xs text-rose-900 bg-white/80 border border-rose-200/80 rounded-xl p-2.5 mt-1.5 font-medium leading-relaxed">
                        <i class="fa-solid fa-comment-dots text-rose-500 mr-1.5"></i>
                        "{{ $dbMetadata->rejection_notes ?? 'Mohon periksa kembali kelengkapan dan kewajaran data.' }}"
                    </div>
                </div>
            </div>
            @if(!$isLocked)
                <button onclick="goToEditPage()" class="px-3.5 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all shadow-2xs cursor-pointer shrink-0">
                    <i class="fa-solid fa-pen mr-1"></i> Perbaiki Sekarang
                </button>
            @endif
        </div>
    @endif
</div>

<!-- YEAR STATUS ALERT -->
<div id="yearStatusAlert" class="mb-4"></div>

