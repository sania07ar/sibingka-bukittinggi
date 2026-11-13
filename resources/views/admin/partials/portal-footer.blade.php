<!-- FOOTER / BOTTOM BAR -->
<footer class="relative z-20 w-full py-2 sm:py-2.5 px-3 sm:px-8 lg:px-12 border-t border-slate-200/70 bg-white/90 backdrop-blur-md shrink-0">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 sm:gap-3 text-xs">
        
        <!-- User Profile & Logout -->
        <div class="inline-flex items-center space-x-2">
            <div class="flex items-center space-x-1.5 sm:space-x-2 bg-white/95 border border-slate-200/90 rounded-full py-0.5 sm:py-1 px-2.5 sm:px-3 shadow-xs">
                <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full overflow-hidden shrink-0 shadow-xs border border-slate-200">
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar Admin BPS" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col text-left leading-none pr-1">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900">
                        {{ session('user.displayName', 'Admin BPS Bukittinggi') }}
                    </span>
                    <span class="text-[9px] sm:text-[9.5px] font-semibold text-emerald-600">
                        Administrator
                    </span>
                </div>
            </div>

            <a href="{{ route('logout') }}" 
                class="inline-flex items-center space-x-1.5 px-2.5 sm:px-3 py-1 rounded-full text-[11px] sm:text-xs font-semibold text-slate-600 hover:text-red-600 bg-white/95 hover:bg-red-50 border border-slate-200 hover:border-red-200 transition-all shadow-xs group"
                title="Keluar dari akun">
                <i class="fa-solid fa-power-off text-[10px] sm:text-[11px] text-slate-400 group-hover:text-red-600 transition-colors"></i>
                <span>Keluar</span>
            </a>
        </div>

        <!-- Copyright -->
        <p class="text-[9.5px] sm:text-[11px] text-slate-500 text-center sm:text-right">
            © <span id="currentYear"></span> <strong>Badan Pusat Statistik Kota Bukittinggi</strong>. SiBingka Kota Bukittinggi - Sistem Informasi Bukittinggi dalam Angka.
        </p>

    </div>
</footer>

<script>
    if (document.getElementById('currentYear')) {
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    }
</script>
