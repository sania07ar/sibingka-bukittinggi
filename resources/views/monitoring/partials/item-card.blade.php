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

    // Line connecting colors
    $line1Color = ($step >= 2) ? 'bg-emerald-600' : 'bg-slate-300';
    $line2Color = ($step >= 3) ? 'bg-emerald-600' : 'bg-slate-300';
    $line3Color = ($step >= 4) ? 'bg-emerald-600' : 'bg-slate-300';
    $line4Color = ($step === 5) ? 'bg-emerald-600' : 'bg-slate-300';
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
                <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-900 border border-emerald-300 mt-0.5" title="{{ $item['verified'] }} tabel telah diverifikasi & di-ACC BPS">
                    <i class="fa-solid fa-check text-[8px]"></i>
                    <span>{{ $item['verified'] }} Di-ACC</span>
                </span>
            @endif
        </div>
    </div>

    <!-- 2. The 5-Step Stepper / Timeline (Center) -->
    <div class="w-full flex-1 min-w-[280px] max-w-[500px] px-2 py-0.5">
        
        <!-- Row A: The Circles & Connecting Lines Centered -->
        <div class="flex items-center w-full">
            
            <!-- Node 1: Persiapan -->
            @if($step >= 2 || ($step === 1 && $pct > 0))
                <div class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0 shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                </div>
            @elseif($step === 1 && $pct === 0)
                <div class="w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[8px] shrink-0 shadow-2xs ring-2 ring-rose-100">
                    <i class="fa-solid fa-circle"></i>
                </div>
            @else
                <div class="w-5 h-5 rounded-full bg-slate-300 text-white flex items-center justify-center text-[8px] shrink-0"></div>
            @endif

            <!-- Line 1-2 -->
            <div class="flex-1 h-0.5 {{ $line1Color }}"></div>

            <!-- Node 2: Input Data -->
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

            <!-- Line 2-3 -->
            <div class="flex-1 h-0.5 {{ $line2Color }}"></div>

            <!-- Node 3: Verifikasi -->
            @if($step > 3)
                <div class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0 shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                </div>
            @elseif($step === 3)
                <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center text-[8px] shrink-0 shadow-2xs ring-2 ring-orange-100">
                    <i class="fa-solid fa-circle"></i>
                </div>
            @else
                <div class="w-5 h-5 rounded-full bg-slate-300 text-white flex items-center justify-center text-[8px] shrink-0"></div>
            @endif

            <!-- Line 3-4 -->
            <div class="flex-1 h-0.5 {{ $line3Color }}"></div>

            <!-- Node 4: Validasi BPS -->
            @if($step > 4)
                <div class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0 shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                </div>
            @elseif($step === 4)
                <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center text-[8px] shrink-0 shadow-2xs ring-2 ring-orange-100">
                    <i class="fa-solid fa-circle"></i>
                </div>
            @else
                <div class="w-5 h-5 rounded-full bg-slate-300 text-white flex items-center justify-center text-[8px] shrink-0"></div>
            @endif

            <!-- Line 4-5 -->
            <div class="flex-1 h-0.5 {{ $line4Color }}"></div>

            <!-- Node 5: Publikasi -->
            @if($step === 5)
                <div class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0 shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                </div>
            @else
                <div class="w-5 h-5 rounded-full bg-slate-300 text-white flex items-center justify-center text-[8px] shrink-0"></div>
            @endif

        </div>

        <!-- Row B: Labels Exactly Under Each Node -->
        <div class="flex items-start justify-between w-full mt-1.5 text-center">
            
            <!-- Label 1 -->
            <div class="w-16 -ml-5.5 flex flex-col items-center">
                <span class="text-[10px] sm:text-[11px] font-semibold text-slate-800 leading-tight">Persiapan</span>
                @if($step === 1 && $pct === 0)
                    <span class="text-[9px] font-bold text-rose-600 leading-tight mt-0.5 whitespace-nowrap">Belum Mulai</span>
                @endif
            </div>

            <!-- Label 2 -->
            <div class="w-16 flex flex-col items-center">
                <span class="text-[10px] sm:text-[11px] font-semibold text-slate-800 leading-tight">Input Data</span>
                @if($step === 2)
                    <span class="text-[9px] font-bold text-[#f95a00] leading-tight mt-0.5 whitespace-nowrap">Pengisian</span>
                @endif
            </div>

            <!-- Label 3 -->
            <div class="w-16 flex flex-col items-center">
                <span class="text-[10px] sm:text-[11px] font-semibold text-slate-800 leading-tight">Verifikasi</span>
                @if($step === 3)
                    <span class="text-[9px] font-bold text-[#f95a00] leading-tight mt-0.5 whitespace-nowrap">Sedang Berjalan</span>
                @endif
            </div>

            <!-- Label 4 -->
            <div class="w-16 flex flex-col items-center">
                <span class="text-[10px] sm:text-[11px] font-semibold text-slate-800 leading-tight whitespace-nowrap">Validasi BPS</span>
                @if($step === 4)
                    <span class="text-[9px] font-bold text-[#f95a00] leading-tight mt-0.5 whitespace-nowrap">Validasi BPS</span>
                @endif
            </div>

            <!-- Label 5 -->
            <div class="w-16 -mr-5.5 flex flex-col items-center">
                <span class="text-[10px] sm:text-[11px] font-semibold text-slate-800 leading-tight">Publikasi</span>
                @if($step === 5)
                    <span class="text-[9px] font-bold text-emerald-600 leading-tight mt-0.5 whitespace-nowrap">Selesai</span>
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
            <!-- Quick Stage Selector Dropdown -->
            <div class="relative no-print">
                <select onchange="updateStageQuick('{{ $agencyType }}', '{{ $item['code'] }}', this.value)"
                        title="Ubah tahapan progres"
                        class="appearance-none text-[11px] font-bold py-1.5 pl-2.5 pr-6 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 focus:outline-none focus:ring-1 focus:ring-orange-500 cursor-pointer shadow-2xs transition-all">
                    <option value="1" {{ $step === 1 ? 'selected' : '' }}>1. Persiapan</option>
                    <option value="2" {{ $step === 2 ? 'selected' : '' }}>2. Input Data</option>
                    <option value="3" {{ $step === 3 ? 'selected' : '' }}>3. Verifikasi</option>
                    <option value="4" {{ $step === 4 ? 'selected' : '' }}>4. Validasi BPS</option>
                    <option value="5" {{ $step === 5 ? 'selected' : '' }}>5. Publikasi</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[8px] text-slate-400 absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            </div>

            <button type="button" 
                    onclick="openAgencyDetailModal('{{ $agencyType }}', '{{ $item['code'] }}', '{{ addslashes($item['short']) }}', '{{ addslashes($item['full']) }}', {{ $pct }}, '{{ $item['status'] }}', '{{ $item['step_label'] }}', {{ $step }}, '{{ addslashes($item['tables'] ?? '') }}')"
                    class="no-print px-3.5 py-1.5 rounded-xl border border-slate-200 hover:border-slate-400 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold transition-all shadow-2xs hover:shadow-xs flex items-center space-x-1 cursor-pointer shrink-0">
                <span>Detail</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </button>
        </div>

    </div>

</div>

