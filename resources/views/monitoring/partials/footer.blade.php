<!-- FOOTER BAR -->
<footer class="w-full bg-transparent py-4 px-4 sm:px-8 mt-auto no-print">
    <div class="max-w-[1440px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
        
        <!-- Bottom Action Buttons -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}"
               class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold border border-slate-200/90 shadow-2xs hover:shadow transition-all no-underline cursor-pointer">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Beranda</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-red-50 text-slate-600 hover:text-red-600 font-bold border border-slate-200/90 shadow-2xs hover:shadow transition-all cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket text-[11px]"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>

        <!-- Copyright -->
        <div class="text-center sm:text-right text-[11px] text-slate-500">
            <div>© {{ date('Y') }} Badan Pusat Statistik Kota Bukittinggi.</div>
            <div class="text-[10px] text-slate-400">SiAngka Kota Bukittinggi - Sistem Informasi Data Daerah dalam Angka.</div>
        </div>

    </div>
</footer>

