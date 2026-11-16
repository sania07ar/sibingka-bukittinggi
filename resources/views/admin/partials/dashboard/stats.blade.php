        <!-- 3. FLOATING STATISTICS BAR -->
        <div class="relative z-20 -mt-10 sm:-mt-12 max-w-4xl mx-auto px-2 sm:px-4">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/70 p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-2 divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
                <div class="flex items-center gap-3.5 px-2 sm:px-4 py-2">
                    <div class="w-12 h-12 rounded-full bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 leading-none">{{ $totalOpd }}</div>
                        <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wide mt-1">OPD</div>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 px-2 sm:px-4 py-2 pt-3 sm:pt-2">
                    <div class="w-12 h-12 rounded-full bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-solid fa-landmark"></i>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 leading-none">{{ $totalInstansi }}</div>
                        <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wide mt-1">INSTANSI VERTIKAL</div>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 px-2 sm:px-4 py-2 pt-3 sm:pt-2">
                    <div class="w-12 h-12 rounded-full bg-orange-100/70 text-[#f95a00] flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-1.5">
                            <div class="text-2xl sm:text-3xl font-black text-slate-900 leading-none">
                                {{ $totalEntitiesFilled }}
                            </div>
                            <div class="relative shrink-0">
                                <select onchange="window.location.href='?year=' + this.value" 
                                        class="text-[11px] font-extrabold text-[#f95a00] bg-orange-50 hover:bg-orange-100 border border-orange-200/90 rounded-lg px-2 py-0.5 focus:outline-none focus:ring-1 focus:ring-orange-400 cursor-pointer transition-colors shadow-2xs"
                                        title="Pilih tahun data">
                                    @foreach($availableYears as $yr)
                                        <option value="{{ $yr }}" {{ $yr == $selectedYear ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wide mt-1">
                            TOTAL DATA TERISI
                        </div>
                        <div class="text-[10px] font-bold text-emerald-600 truncate mt-0.5" title="{{ $savedTableCount }} Tabel Terisi ({{ $realDataCount }} Data Indikator)">
                            <i class="fa-solid fa-circle-check text-[9px] mr-0.5"></i>{{ $savedTableCount }} Tabel Terisi <span class="text-slate-400 font-normal">({{ $realDataCount }} Indikator)</span>
                        </div>
                        <div class="text-[9.5px] font-medium text-slate-500 mt-0.5 truncate" title="{{ $filledOpdCount }} OPD • {{ $filledInstansiCount }} Instansi • {{ $filledBpsCount }} Data BPS">
                            <span class="text-orange-600 font-bold">{{ $filledOpdCount }}</span> OPD &bull; 
                            <span class="text-sky-600 font-bold">{{ $filledInstansiCount }}</span> Instansi &bull; 
                            <span class="text-emerald-600 font-bold">{{ $filledBpsCount }}</span> BPS
                        </div>
                    </div>
                </div>
            </div>
        </div>
