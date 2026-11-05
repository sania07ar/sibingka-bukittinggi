<div class="bg-white rounded-3xl p-6 shadow-2xs border border-slate-100 sticky top-6">
    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight mb-5">
        Ringkasan Progres
    </h2>

    <!-- Donut Chart with Total in Center -->
    <div class="flex flex-col items-center justify-center my-3">
        <div class="relative w-36 h-36 flex items-center justify-center">
            <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                <!-- Base Circle -->
                <circle cx="50" cy="50" r="38" fill="transparent" stroke="#f1f5f9" stroke-width="12"></circle>
                
                <!-- Green Segment (Selesai) -->
                <circle cx="50" cy="50" r="38" fill="transparent" stroke="#10b981" stroke-width="12" 
                        stroke-dasharray="{{ $dashSelesai }} {{ $circ }}" stroke-dashoffset="0"></circle>
                
                <!-- Orange Segment (Berjalan) -->
                <circle cx="50" cy="50" r="38" fill="transparent" stroke="#f95a00" stroke-width="12" 
                        stroke-dasharray="{{ $dashBerjalan }} {{ $circ }}" stroke-dashoffset="{{ $offsetBerjalan }}"></circle>
                
                <!-- Grey Segment (Belum Mulai) -->
                <circle cx="50" cy="50" r="38" fill="transparent" stroke="#cbd5e1" stroke-width="12" 
                        stroke-dasharray="{{ $dashBelum }} {{ $circ }}" stroke-dashoffset="{{ $offsetBelum }}"></circle>
            </svg>
            
            <!-- Center Text: Total Count -->
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-3xl font-black text-slate-900 tracking-tight leading-none">{{ $countTotal }}</span>
            </div>
        </div>
    </div>

    <!-- Legend Items (Dynamic Values for 3 Stages) -->
    <div class="space-y-2.5 mt-5 pt-4 border-t border-slate-100 text-xs font-semibold">
        <!-- Tahap 3: Validasi BPS (Selesai) -->
        <div class="flex items-center justify-between text-slate-700">
            <div class="flex items-center space-x-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span>3. Validasi BPS Admin</span>
            </div>
            <span class="font-bold text-slate-900">{{ $countSelesai }}</span>
        </div>

        <!-- Tahap 2: Verifikasi Wali Data (Proses) -->
        <div class="flex items-center justify-between text-slate-700">
            <div class="flex items-center space-x-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#f95a00]"></span>
                <span>2. Verifikasi Wali Data</span>
            </div>
            <span class="font-bold text-slate-900">{{ $countBerjalan }}</span>
        </div>

        <!-- Tahap 1: Input Data (Pengisian) -->
        <div class="flex items-center justify-between text-slate-700">
            <div class="flex items-center space-x-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                <span>1. Input Data Dinas</span>
            </div>
            <span class="font-bold text-slate-900">{{ $countBelum }}</span>
        </div>
    </div>
</div>

