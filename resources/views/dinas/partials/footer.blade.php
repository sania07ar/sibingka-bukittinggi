@php
    $isAdmin = $isAdmin ?? (session('user.role') === 'admin');
    $userIcon = $userIcon ?? 'fa-city';
    $displayName = session('user.displayName', 'Admin BPS Bukittinggi');
@endphp

<!-- FOOTER & USER SESSION BAR -->
<footer class="w-full border-t border-slate-200/60 bg-white/40 backdrop-blur-sm py-1.5 px-4 sm:px-8 text-slate-600 shrink-0">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-1.5 text-xs">
        
        <!-- Info Pengguna yang Sedang Login & Tombol Logout -->
        <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-white/60 hover:bg-white/80 border border-slate-200/80 shadow-xs transition-all backdrop-blur-xs">
            <div class="flex items-center space-x-1.5">
                @if($isAdmin)
                    <div class="w-5 h-5 rounded-full overflow-hidden shrink-0 border border-slate-200 shadow-2xs" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px; max-width: 20px; max-height: 20px;">
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar Admin BPS" class="w-full h-full object-cover block rounded-full" style="width: 20px; height: 20px; max-width: 20px; max-height: 20px; object-fit: cover;">
                    </div>
                @else
                    <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[9px] shadow-xs shrink-0" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;">
                        <i class="fa-solid {{ $userIcon }}"></i>
                    </div>
                @endif
                <span class="font-bold text-slate-800 text-xs">{{ $displayName }}</span>
            </div>

            <div class="h-3 w-px bg-slate-300"></div>

            <form action="{{ route('logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari SiAngka Kota Bukittinggi?');">
                @csrf
                <button type="submit" 
                        title="Keluar dari sistem"
                        class="flex items-center space-x-1 text-slate-700 hover:text-red-600 font-bold transition-colors text-[11px] cursor-pointer group">
                    <i class="fa-solid fa-right-from-bracket text-[9px] text-slate-500 group-hover:text-red-600 transition-colors"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>

        <!-- Copyright & Address -->
        <div class="flex flex-col sm:flex-row items-center space-y-0.5 sm:space-y-0 sm:space-x-3 text-[11px] text-slate-500 text-center md:text-right">
            <p>© {{ date('Y') }} <strong>Badan Pusat Statistik Kota Bukittinggi</strong>.</p>
            <span class="hidden sm:inline text-slate-300">•</span>
            <span class="hover:text-orange-600 transition-colors">
                <i class="fa-solid fa-location-dot text-[#f95a00] mr-1"></i>
                Jl. Perwira No.50, Belakang Balok, Bukittinggi
            </span>
        </div>

    </div>
</footer>

