        <!-- FOOTER & USER SESSION BAR -->
        <footer class="w-full border-t border-slate-200/60 bg-white/50 backdrop-blur-sm py-2.5 px-4 sm:px-8 text-slate-600 mt-auto">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2.5 text-xs">
                
                <div class="inline-flex items-center space-x-2.5 px-3 py-1 rounded-full bg-white/60 hover:bg-white/80 border border-slate-200/80 shadow-xs transition-all backdrop-blur-xs">
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[10px] shadow-xs">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <span class="font-bold text-slate-800 text-xs">{{ session('user.displayName', 'Admin BPS Bukittinggi') }}</span>
                    </div>
                </div>

                <div class="text-center md:text-right text-[11px] text-slate-500 font-medium">
                    &copy; {{ date('Y') }} Badan Pusat Statistik Kota Bukittinggi. All rights reserved.
                </div>

            </div>
        </footer>
