        <!-- 4. AKSES DATA & MONITORING SECTIONS -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-5 relative z-20 mt-6">
            
            <!-- LEFT CARD: AKSES DATA -->
            <div id="akses-data-section" class="scroll-mt-24 transition-all duration-300 bg-white rounded-3xl border border-slate-200/70 p-5 sm:p-6 shadow-sm hover:shadow-md">
                <div class="flex items-start gap-3.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-base shadow-xs">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Akses Data</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola dan lihat data statistik berdasarkan sumber data</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('isi-data-opd') }}" 
                       class="flex-1 group bg-gradient-to-br from-orange-50/70 to-orange-50/30 border border-orange-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-orange-300 hover:shadow-md transition-all no-underline"
                       id="btn-isi-opd">
                        <div>
                            <div class="w-7 h-7 rounded-lg text-orange-500 flex items-center text-lg mb-2">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-orange-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                Data OPD
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                Isi dan kelola data OPD
                            </p>
                        </div>
                        <div class="flex justify-end mt-2 pt-1">
                            <span class="w-6 h-6 rounded-full border border-orange-300 text-orange-500 flex items-center justify-center text-[10px] group-hover:bg-orange-500 group-hover:text-white transition-all">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('isi-data-instansi') }}" 
                       class="flex-1 group bg-gradient-to-br from-sky-50/60 to-blue-50/30 border border-sky-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-sky-300 hover:shadow-md transition-all no-underline"
                       id="btn-isi-vertikal">
                        <div>
                            <div class="w-7 h-7 rounded-lg text-sky-600 flex items-center text-lg mb-2">
                                <i class="fa-solid fa-landmark"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-sky-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                Instansi Vertikal & Lainnya
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                Isi dan kelola data instansi
                            </p>
                        </div>
                        <div class="flex justify-end mt-2 pt-1">
                            <span class="w-6 h-6 rounded-full border border-sky-300 text-sky-600 flex items-center justify-center text-[10px] group-hover:bg-sky-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('data-bps') }}" 
                       class="flex-1 group bg-gradient-to-br from-emerald-50/60 to-teal-50/30 border border-emerald-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-emerald-300 hover:shadow-md transition-all no-underline"
                       id="btn-data-bps">
                        <div>
                            <div class="w-7 h-7 rounded-lg text-emerald-600 flex items-center text-lg mb-2">
                                <i class="fa-solid fa-chart-simple"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-emerald-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                Data BPS
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                Lihat data BPS Kota Bukittinggi
                            </p>
                        </div>
                        <div class="flex justify-end mt-2 pt-1">
                            <span class="w-6 h-6 rounded-full border border-emerald-300 text-emerald-600 flex items-center justify-center text-[10px] group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- RIGHT CARD: MONITORING -->
            <div id="monitoring-section" class="scroll-mt-24 transition-all duration-300 bg-white rounded-3xl border border-slate-200/70 p-5 sm:p-6 shadow-sm hover:shadow-md">
                <div class="flex items-start gap-3.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-base shadow-xs">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Monitoring</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Pantau perkembangan pengisian data secara real-time</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('monitoring-opd') }}" 
                       class="flex-1 group bg-gradient-to-br from-orange-50/70 to-orange-50/30 border border-orange-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-orange-300 hover:shadow-md transition-all no-underline"
                       id="btn-mon-opd">
                        <div>
                            <div class="w-7 h-7 rounded-lg text-orange-500 flex items-center text-lg mb-2">
                                <i class="fa-solid fa-file-invoice"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-orange-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                Monitoring OPD
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                Lihat progres pengisian data OPD
                            </p>
                        </div>
                        <div class="flex justify-end mt-2 pt-1">
                            <span class="w-6 h-6 rounded-full border border-orange-300 text-orange-500 flex items-center justify-center text-[10px] group-hover:bg-orange-500 group-hover:text-white transition-all">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('monitoring-instansi') }}" 
                       class="flex-1 group bg-gradient-to-br from-sky-50/60 to-blue-50/30 border border-sky-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-sky-300 hover:shadow-md transition-all no-underline"
                       id="btn-mon-vertikal">
                        <div>
                            <div class="w-7 h-7 rounded-lg text-sky-600 flex items-center text-lg mb-2">
                                <i class="fa-solid fa-file-contract"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-sky-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                Monitoring Instansi
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                Lihat progres pengisian data instansi
                            </p>
                        </div>
                        <div class="flex justify-end mt-2 pt-1">
                            <span class="w-6 h-6 rounded-full border border-sky-300 text-sky-600 flex items-center justify-center text-[10px] group-hover:bg-sky-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('monitoring-bps') }}" 
                       class="flex-1 group bg-gradient-to-br from-emerald-50/60 to-teal-50/30 border border-emerald-200/70 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between hover:border-emerald-300 hover:shadow-md transition-all no-underline"
                       id="btn-mon-bps">
                        <div>
                            <div class="w-7 h-7 rounded-lg text-emerald-600 flex items-center text-lg mb-2">
                                <i class="fa-solid fa-chart-column"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-[13px] group-hover:text-emerald-600 transition-colors leading-snug min-h-[2rem] flex items-center">
                                Monitoring BPS
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug min-h-[1.75rem]">
                                Lihat progres data BPS
                            </p>
                        </div>
                        <div class="flex justify-end mt-2 pt-1">
                            <span class="w-6 h-6 rounded-full border border-emerald-300 text-emerald-600 flex items-center justify-center text-[10px] group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
