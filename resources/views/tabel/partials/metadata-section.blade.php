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
        <div class="bg-emerald-50/60 border border-emerald-200/80 rounded-xl px-4 py-3 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-2xs">
            <div class="space-y-1">
                <div class="flex items-center space-x-2.5 flex-wrap">
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-emerald-100 text-emerald-900">
                        Data Tervalidasi BPS
                    </span>
                    <span class="text-xs text-slate-600 font-medium">
                        Telah disahkan untuk publikasi resmi Daerah Dalam Angka (DDA)
                    </span>
                </div>
                <div class="flex items-center space-x-1.5 text-[11px] text-emerald-800">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i>
                    <span>Diverifikasi oleh: <strong>{{ $dbMetadata->verifier_name ?? 'Admin BPS' }}</strong>@if($dbMetadata?->verified_at) &bull; {{ \Carbon\Carbon::parse($dbMetadata->verified_at)->isoFormat('D MMMM Y, HH:mm') }}@endif</span>
                </div>
            </div>
        </div>
    @elseif($verificationStatus === 'submitted')
        <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-2xs">
            <div class="space-y-1">
                <div class="flex items-center space-x-2.5 flex-wrap">
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-amber-100 text-amber-900">
                        Menunggu Validasi BPS
                    </span>
                    <span class="text-xs text-slate-500 font-medium">
                        Diajukan oleh <strong class="text-slate-800 font-bold">{{ $dbMetadata->submitted_by ?? session('user.displayName', 'Pengguna') }}</strong>@if($dbMetadata?->submitted_at) &bull; {{ \Carbon\Carbon::parse($dbMetadata->submitted_at)->isoFormat('D MMMM Y, HH:mm') }}@endif
                    </span>
                </div>
                @if($dbMetadata?->submitted_by || $dbMetadata?->data_declared)
                    <div class="flex items-center space-x-1.5 text-[11px] text-slate-500">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i>
                        <span>Pernyataan keabsahan data telah disetujui secara digital oleh produsen data.</span>
                    </div>
                @endif
            </div>

            @if($isAdmin)
                <div class="flex items-center space-x-2 shrink-0 self-end md:self-center">
                    <button type="button" onclick="openRevisionModal()" class="px-3.5 py-1.5 rounded-lg bg-white hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-300 hover:border-rose-300 text-xs font-semibold transition-all shadow-2xs cursor-pointer flex items-center space-x-1.5">
                        <i class="fa-solid fa-triangle-exclamation text-[11px] text-slate-400"></i>
                        <span>Minta Revisi</span>
                    </button>
                    <button type="button" onclick="handleApproveTable()" class="px-4 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold transition-all shadow-2xs cursor-pointer flex items-center space-x-1.5">
                        <i class="fa-solid fa-check text-[11px] text-white"></i>
                        <span>Setujui (ACC Data)</span>
                    </button>
                </div>
            @endif
        </div>
    @elseif($verificationStatus === 'revision')
        <div class="bg-rose-50/60 border border-rose-200 rounded-xl px-4 py-3 flex flex-col md:flex-row md:items-start justify-between gap-3 shadow-2xs">
            <div class="space-y-1.5 flex-1">
                <div class="flex items-center space-x-2.5 flex-wrap">
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-rose-100 text-rose-900">
                        Perlu Perbaikan
                    </span>
                    <span class="text-xs text-rose-900 font-bold">
                        Catatan Revisi dari BPS Kota Bukittinggi:
                    </span>
                </div>
                <div class="text-xs text-slate-700 bg-white border border-rose-200 rounded-lg p-2.5 font-medium leading-relaxed">
                    <i class="fa-solid fa-comment-dots text-rose-500 mr-1.5"></i>
                    "{{ $dbMetadata->rejection_notes ?? 'Mohon periksa kembali kelengkapan dan kewajaran data.' }}"
                </div>
            </div>
            @if(!$isLocked)
                <button type="button" onclick="goToEditPage()" class="px-3.5 py-1.5 rounded-lg bg-rose-700 hover:bg-rose-800 text-white text-xs font-semibold transition-all shadow-2xs cursor-pointer shrink-0 self-end md:self-center">
                    <i class="fa-solid fa-pen mr-1"></i> Perbaiki Sekarang
                </button>
            @endif
        </div>
    @endif
</div>

<!-- YEAR STATUS ALERT -->
<div id="yearStatusAlert" class="mb-4"></div>

