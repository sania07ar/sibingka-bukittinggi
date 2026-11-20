        <!-- Hero Panoramic Banner -->
        <div id="beranda-section" class="scroll-mt-24 relative w-full rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm bg-white min-h-[380px] sm:min-h-[420px] lg:min-h-[440px] flex items-center">
            
            <div class="absolute inset-y-0 right-0 w-full sm:w-1/2 lg:w-[46%] xl:w-2/5 overflow-hidden pointer-events-none">
                <img src="{{ asset('images/fgd-bukittinggi-exact.png') }}?v={{ file_exists(public_path('images/fgd-bukittinggi-exact.png')) ? filemtime(public_path('images/fgd-bukittinggi-exact.png')) : time() }}" alt="FGD Bukittinggi dalam Angka" class="w-full h-full object-cover object-center">
                <div class="absolute inset-y-0 left-0 w-14 sm:w-20 bg-gradient-to-r from-white to-transparent"></div>
            </div>

            <div class="absolute inset-y-0 left-0 w-1/2 pointer-events-none opacity-85">
                <svg class="w-full h-full text-orange-400/20" viewBox="0 0 400 400" fill="none" preserveAspectRatio="none">
                    <path d="M-50,150 C100,80 150,280 350,200" stroke="currentColor" stroke-width="2.5" />
                    <path d="M-50,180 C120,110 180,310 380,230" stroke="currentColor" stroke-width="2" />
                    <path d="M-50,210 C140,140 210,340 410,260" stroke="currentColor" stroke-width="1.5" />
                </svg>
            </div>

            <div class="relative z-10 max-w-xl lg:max-w-2xl px-6 sm:px-10 lg:px-14 py-8">
                <p class="text-xs sm:text-sm font-bold text-[#ea580c] tracking-wide mb-2.5">
                    Selamat Datang, <span class="text-[#f95a00] font-extrabold">{{ $dinasName }}</span>
                </p>

                <div class="space-y-1 mb-2">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-800 tracking-tight leading-none flex flex-wrap items-baseline gap-x-3 gap-y-1">
                        <span class="text-slate-900 font-bold">SiBingka</span>
                        <span class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#f95a00] font-sans tracking-tight">Kota Bukittinggi</span>
                    </h1>
                </div>

                <p class="text-sm sm:text-base lg:text-lg font-bold text-slate-700 mt-2 tracking-normal leading-snug">
                    Sistem Informasi Bukittinggi dalam Angka
                </p>

                <p class="text-xs sm:text-sm text-slate-700 font-medium mt-2.5 leading-relaxed max-w-md lg:max-w-lg">
                    Satu sistem informasi untuk pengelolaan, pemantauan, dan penyajian data statistik sektor pembangunan Kota Bukittinggi secara terintegrasi.
                </p>

                <div class="mt-6 sm:mt-7 flex items-center gap-3">
                    <a href="#monitoring-section" 
                       class="btn-orange-glow inline-flex items-center gap-2.5 bg-[#f95a00] hover:bg-[#ea580c] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 no-underline">
                        <span>Mulai Monitoring</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
