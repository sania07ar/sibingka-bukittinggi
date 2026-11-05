@php
    $step = $item['step'];
    $pct = $item['progress'];
    
    // Color variables for Percentage and Subtitle
    $pctColor = match(true) {
        $pct === 100 => 'text-emerald-600',
        $pct === 0 => 'text-slate-900',
        default => 'text-[#f95a00]',
    };

    $statusSubColor = match(true) {
        $pct === 100 => 'text-emerald-600',
        $pct === 0 => 'text-rose-600',
        default => 'text-[#f95a00]',
    };

    // Line connecting colors for 3 Stages
    $line1Color = ($step >= 2) ? 'bg-emerald-600' : 'bg-slate-200';
    $line2Color = ($step >= 3) ? 'bg-emerald-600' : 'bg-slate-200';
@endphp

<div class="agency-card print-card bg-white rounded-2xl sm:rounded-3xl p-3.5 sm:p-4 shadow-2xs hover:shadow-xs border border-slate-100 hover:border-orange-200 transition-all flex flex-col lg:flex-row items-center justify-between gap-4"
     data-status="{{ $item['status_type'] }}"
     data-name="{{ strtolower($item['short'] . ' ' . $item['full']) }}">
    
    <!-- 1. Agency Icon & Name (Left) -->
    <div class="flex items-center space-x-3 w-full lg:w-[240px] shrink-0">
        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-sm sm:text-base shrink-0 shadow-2xs">
            <i class="fa-solid {{ $item['icon'] }}"></i>
        </div>
        <div class="min-w-0 flex-1">
            <h3 class="text-xs sm:text-[13px] font-extrabold text-slate-900 leading-snug line-clamp-2">
                {{ $item['short'] }}
            </h3>
            <!-- Verification Workflow Badges -->
            @if(!empty($item['revision']) && $item['revision'] > 0)
                <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-rose-100 text-rose-900 border border-rose-300 mt-0.5" title="{{ $item['revision'] }} tabel butuh perbaikan oleh dinas">
                    <i class="fa-solid fa-triangle-exclamation text-[8px]"></i>
                    <span>{{ $item['revision'] }} Butuh Revisi</span>
                </span>
            @elseif(!empty($item['verified']) && $item['verified'] > 0)
                <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-900 border border-emerald-300 mt-0.5" title="{{ $item['verified'] }} tabel telah diverifikasi & di-ACC">
                    <i class="fa-solid fa-check text-[8px]"></i>
                    <span>{{ $item['verified'] }} Terverifikasi</span>
                </span>
            @endif
        </div>
    </div>

    <!-- 2. The 3-Step Stepper / Timeline: Input Data -> Verifikasi -> Validasi BPS (Center) -->
    <div class="w-full flex-1 min-w-[280px] max-w-[440px] px-2 py-0.5">
        
        <!-- Row A: The Circles & Connecting Lines Centered -->
        <div class="flex items-center w-full">
            
            <!-- Node 1: Input Data (Dinas/OPD/Instansi) -->
            @if($step > 1)
                <div class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0 shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                </div>
            @elseif($step === 1 && $pct > 0)
                <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center text-[8px] shrink-0 shadow-2xs ring-2 ring-orange-100">
                    <i class="fa-solid fa-circle"></i>
                </div>
            @elseif($step === 1 && $pct === 0)
                <div class="w-5 h-5 rounded-full bg-slate-300 text-white flex items-center justify-center text-[8px] shrink-0 shadow-2xs">
                    <i class="fa-solid fa-circle"></i>
                </div>
            @else
                <div class="w-5 h-5 rounded-full bg-slate-300 text-white flex items-center justify-center text-[8px] shrink-0"></div>
            @endif

            <!-- Line 1-2 (Input Data -> Verifikasi) -->
            <div class="flex-1 h-0.5 {{ $line1Color }}"></div>

            <!-- Node 2: Verifikasi (Wali Data Kominfo) -->
            @if($step > 2)
                <div class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0 shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                </div>
            @elseif($step === 2)
                <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center text-[8px] shrink-0 shadow-2xs ring-2 ring-orange-100">
                    <i class="fa-solid fa-circle"></i>
                </div>
            @else
                <div class="w-5 h-5 rounded-full bg-slate-300 text-white flex items-center justify-center text-[8px] shrink-0"></div>
            @endif

            <!-- Line 2-3 (Verifikasi -> Validasi BPS) -->
            <div class="flex-1 h-0.5 {{ $line2Color }}"></div>

            <!-- Node 3: Validasi BPS (Admin BPS) -->
            @if($step === 3)
                <div class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0 shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                </div>
            @else
                <div class="w-5 h-5 rounded-full bg-slate-300 text-white flex items-center justify-center text-[8px] shrink-0"></div>
            @endif

        </div>

        <!-- Row B: Labels Exactly Under Each Node -->
        <div class="flex items-start justify-between w-full mt-1.5 text-center">
            
            <!-- Label 1: Input Data -->
            <div class="w-24 -ml-4 flex flex-col items-center">
                <span class="text-[10px] sm:text-[11px] font-semibold text-slate-800 leading-tight">Input Data</span>
                @if($step === 1)
                    <span class="text-[9px] font-bold {{ $pct > 0 ? 'text-[#f95a00]' : 'text-slate-500' }} leading-tight mt-0.5 whitespace-nowrap">
                        {{ $pct > 0 ? 'Pengisian' : 'Belum Mulai' }}
                    </span>
                @endif
            </div>

            <!-- Label 2: Verifikasi -->
            <div class="w-24 flex flex-col items-center">
                <span class="text-[10px] sm:text-[11px] font-semibold text-slate-800 leading-tight">Verifikasi</span>
                @if($step === 2)
                    <span class="text-[9px] font-bold text-[#f95a00] leading-tight mt-0.5 whitespace-nowrap">Wali Data</span>
                @endif
            </div>

            <!-- Label 3: Validasi BPS -->
            <div class="w-24 -mr-4 flex flex-col items-center">
                <span class="text-[10px] sm:text-[11px] font-semibold text-slate-800 leading-tight whitespace-nowrap">Validasi BPS</span>
                @if($step === 3)
                    <span class="text-[9px] font-bold text-emerald-600 leading-tight mt-0.5 whitespace-nowrap">Selesai (ACC)</span>
                @endif
            </div>

        </div>

    </div>

    <!-- 3. Percentage, Status, Quick Dropdown & Detail Button (Right) -->
    <div class="flex items-center space-x-4 lg:space-x-5 w-full lg:w-auto justify-end shrink-0 border-t lg:border-t-0 pt-2.5 lg:pt-0 border-slate-100">
        
        <div class="text-center min-w-[65px] shrink-0">
            <div class="text-base sm:text-lg font-black {{ $pctColor }} leading-none">
                {{ $pct }}%
            </div>
            <div class="text-[10.5px] sm:text-[11px] font-bold {{ $statusSubColor }} mt-1 leading-none">
                {{ $item['status'] }}
            </div>
        </div>

        <div class="flex items-center space-x-2 shrink-0">
            @php
                $isAdmin = (session('user.role') === 'admin');
                $isValidated = ($step === 3);
            @endphp

            @if($isAdmin)
                <!-- Admin BPS: Khusus Mengubah / Mengatur Validasi BPS -->
                @if($isValidated)
                    <button type="button" 
                            onclick="toggleBpsValidation('{{ $agencyType }}', '{{ $item['code'] }}', 2)"
                            title="Klik jika ingin membatalkan Validasi BPS"
                            class="no-print group inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border border-emerald-300 bg-emerald-50 hover:bg-rose-50 text-emerald-700 hover:text-rose-700 hover:border-rose-300 text-xs font-bold transition-all shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-circle-check text-emerald-600 group-hover:hidden text-xs"></i>
                        <i class="fa-solid fa-xmark text-rose-600 hidden group-hover:inline text-xs"></i>
                        <span class="group-hover:hidden">Tervalidasi BPS</span>
                        <span class="hidden group-hover:inline">Batal Validasi</span>
                    </button>
                @else
                    <button type="button" 
                            onclick="toggleBpsValidation('{{ $agencyType }}', '{{ $item['code'] }}', 3)"
                            title="Klik untuk menyetujui Validasi BPS"
                            class="no-print inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border border-slate-200 hover:border-emerald-500 bg-white hover:bg-emerald-600 hover:text-white text-slate-700 text-xs font-bold transition-all shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-check-double text-slate-400 group-hover:text-white text-xs"></i>
                        <span>Validasi BPS</span>
                    </button>
                @endif
            @else
                <!-- Non-Admin (Wali Data / OPD): Tampilan Status Validasi BPS -->
                @if($isValidated)
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                        <i class="fa-solid fa-circle-check text-xs"></i>
                        <span>Tervalidasi BPS</span>
                    </span>
                @else
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-xl bg-slate-50 text-slate-600 border border-slate-200 text-xs font-semibold">
                        <i class="fa-solid fa-clock text-xs text-slate-400"></i>
                        <span>Belum Validasi</span>
                    </span>
                @endif
            @endif

            <button type="button" 
                    onclick="openAgencyDetailModal('{{ $agencyType }}', '{{ $item['code'] }}', '{{ addslashes($item['short']) }}', '{{ addslashes($item['full']) }}', {{ $pct }}, '{{ $item['status'] }}', '{{ $item['step_label'] }}', {{ $step }}, '{{ addslashes($item['tables'] ?? '') }}')"
                    class="no-print px-3.5 py-1.5 rounded-xl border border-slate-200 hover:border-slate-400 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold transition-all shadow-2xs hover:shadow-xs flex items-center space-x-1 cursor-pointer shrink-0">
                <span>Detail</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </button>
        </div>

    </div>

</div>

