    <!-- ======================================================== -->
    <!-- 2. HERO PANORAMIC BANNER (FULL 1-SCREEN VIEWPORT)        -->
    <!-- ======================================================== -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 sm:py-3 md:py-4 flex-1 flex flex-col justify-center w-full">
        
        <!-- Hero Panoramic Banner -->
        <div id="beranda-section" class="scroll-mt-24 relative w-full rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm bg-white flex-1 flex items-center min-h-[460px] md:min-h-[500px] lg:min-h-[calc(100vh-165px)] max-h-[820px]">
            
            <!-- Right side FGD Bukittinggi Exact Image & Mask -->
            <div class="absolute inset-y-0 right-0 w-full sm:w-1/2 lg:w-[46%] xl:w-2/5 overflow-hidden pointer-events-none">
                <img src="{{ asset('images/fgd-bukittinggi-exact.png') }}?v={{ file_exists(public_path('images/fgd-bukittinggi-exact.png')) ? filemtime(public_path('images/fgd-bukittinggi-exact.png')) : time() }}" alt="FGD Bukittinggi dalam Angka" class="w-full h-full object-cover object-center">
                <!-- Gradasi halus pinggir kiri foto -->
                <div class="absolute inset-y-0 left-0 w-14 sm:w-20 bg-gradient-to-r from-white to-transparent"></div>
            </div>

            <!-- Left side Orange Curve Accent Waves -->
            <div class="absolute inset-y-0 left-0 w-1/2 pointer-events-none opacity-85">
                <svg class="w-full h-full text-orange-400/20" viewBox="0 0 400 400" fill="none" preserveAspectRatio="none">
                    <path d="M-50,150 C100,80 150,280 350,200" stroke="currentColor" stroke-width="2.5" />
                    <path d="M-50,180 C120,110 180,310 380,230" stroke="currentColor" stroke-width="2" />
                    <path d="M-50,210 C140,140 210,340 410,260" stroke="currentColor" stroke-width="1.5" />
                </svg>
            </div>

            <!-- Content Area (Left aligned) -->
            <div class="relative z-10 max-w-xl lg:max-w-2xl px-6 sm:px-10 lg:px-14 py-8 md:py-12">
                
                <!-- Greeting -->
                <p class="text-xs sm:text-sm font-bold text-[#ea580c] tracking-wide mb-2.5">
                    Selamat Datang, <span class="text-[#f95a00] font-extrabold">{{ $dinasName }}</span>
                </p>

                <!-- Main Title: SiBingka Digital Application Style -->
                <div class="space-y-1 mb-2">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-800 tracking-tight leading-none flex flex-wrap items-baseline gap-x-3 gap-y-1">
                        <span class="text-slate-900 font-bold">SiBingka</span>
                        <span class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#f95a00] font-sans tracking-tight">Kota Bukittinggi</span>
                    </h1>
                </div>

                <!-- Formal Subtitle -->
                <p class="text-sm sm:text-base lg:text-lg font-bold text-slate-700 mt-2 tracking-normal leading-snug">
                    Sistem Informasi Bukittinggi dalam Angka
                </p>

                <!-- Concise Description -->
                <p class="text-xs sm:text-sm text-slate-700 font-medium mt-2.5 leading-relaxed max-w-md lg:max-w-lg">
                    Satu sistem informasi untuk pengelolaan, pemantauan, dan penyajian data statistik sektor pembangunan Kota Bukittinggi secara terintegrasi.
                </p>

                <!-- CTA Button (Direct to tables or monitoring for Wali Data) -->
                <div class="mt-6 sm:mt-8 flex flex-wrap items-center gap-3">
                    @if($isWaliData)
                        <a href="{{ route('monitoring-opd') }}" 
                           class="btn-orange-glow inline-flex items-center gap-2.5 bg-[#f95a00] hover:bg-[#ea580c] text-white font-bold text-sm px-5 py-3 rounded-xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 no-underline">
                            <i class="fa-solid fa-chart-line text-sm"></i>
                            <span>Monitoring OPD (Verifikasi)</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('monitoring-instansi') }}" 
                           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-5 py-3 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5 no-underline">
                            <i class="fa-solid fa-landmark text-sm"></i>
                            <span>Monitoring Instansi</span>
                        </a>
                        <a href="{{ route('monitoring-bps') }}" 
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-5 py-3 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5 no-underline">
                            <i class="fa-solid fa-chart-pie text-sm"></i>
                            <span>Monitoring BPS</span>
                        </a>
                    @elseif($isBpsUser)
                        <a href="{{ route('data-bps') }}" 
                           class="btn-orange-glow inline-flex items-center gap-2.5 bg-[#f95a00] hover:bg-[#ea580c] text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 no-underline">
                            <i class="fa-solid fa-database text-sm"></i>
                            <span>Mulai Isi Data BPS</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('monitoring-bps') }}" 
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-5 py-3.5 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5 no-underline">
                            <i class="fa-solid fa-chart-pie text-sm"></i>
                            <span>Monitoring BPS</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    @else
                        <a href="{{ $targetRoute }}" 
                           class="btn-orange-glow inline-flex items-center gap-2.5 bg-[#f95a00] hover:bg-[#ea580c] text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 no-underline">
                            <i class="fa-solid fa-file-pen text-sm"></i>
                            <span>{{ $btnLabel }}</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </main>
