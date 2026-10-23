<!-- TOP STATS COUNTER BAR -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 sm:gap-4 mb-6">
    
    <!-- Stat 1: Total Terdaftar -->
    <div class="bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3.5">
        <div class="w-11 h-11 rounded-xl bg-orange-100 text-[#f95a00] flex items-center justify-center text-lg font-bold shrink-0">
            <i class="fa-solid fa-users-viewfinder"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Total Akun Mitra</span>
            <span class="text-xl font-black text-slate-900">{{ $dinasUsers->count() }}</span>
            <span class="text-[10px] text-slate-400 block">Dinas & Instansi</span>
        </div>
    </div>

    <!-- Stat 2: Akun OPD Kota -->
    <div class="bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3.5">
        <div class="w-11 h-11 rounded-xl bg-orange-50 border border-orange-200 text-[#f95a00] flex items-center justify-center text-lg font-bold shrink-0">
            <i class="fa-solid fa-building-columns"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Akun OPD Kota</span>
            <span class="text-xl font-black text-[#f95a00]">
                {{ $dinasUsers->where('role', 'opd')->count() }} / 20
            </span>
            <span class="text-[10px] text-slate-400 block">Dinas Daerah</span>
        </div>
    </div>

    <!-- Stat 3: Akun Instansi Vertikal -->
    <div class="bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3.5">
        <div class="w-11 h-11 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-600 flex items-center justify-center text-lg font-bold shrink-0">
            <i class="fa-solid fa-landmark-flag"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Instansi Vertikal</span>
            <span class="text-xl font-black text-indigo-600">
                {{ $dinasUsers->where('role', 'instansi')->count() }} / 37
            </span>
            <span class="text-[10px] text-slate-400 block">Vertikal & Kampus</span>
        </div>
    </div>

    <!-- Stat 4: Akun Aktif -->
    <div class="bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3.5">
        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg font-bold shrink-0">
            <i class="fa-solid fa-user-check"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Status Aktif</span>
            <span class="text-xl font-black text-emerald-600">
                {{ $dinasUsers->where('is_active', true)->count() }}
            </span>
            <span class="text-[10px] text-slate-400 block">Siap Login</span>
        </div>
    </div>

</div>
