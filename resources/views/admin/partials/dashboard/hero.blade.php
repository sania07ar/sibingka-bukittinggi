        <!-- Hero Panoramic Banner -->
        <div id="beranda-section" class="scroll-mt-24 relative w-full rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm bg-white min-h-[380px] sm:min-h-[420px] lg:min-h-[440px] flex items-center">
            
            <!-- Full Panoramic FGD Bukittinggi Image with Seamless Natural Left Fade -->
            <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
                <img src="{{ asset('images/fgd.jpeg') }}?v={{ file_exists(public_path('images/fgd.jpeg')) ? filemtime(public_path('images/fgd.jpeg')) : time() }}" alt="FGD Bukittinggi dalam Angka" class="w-full h-full object-cover object-right sm:object-[70%_center]">
                <!-- Gradasi halus alami tanpa kotak: putih lembut di area teks kiri, lalu memudar transparan ke kanan agar foto HD jelas -->
                <div class="absolute inset-0 pointer-events-none" 
                     style="background: linear-gradient(to right, rgba(255, 255, 255, 0.96) 0%, rgba(255, 255, 255, 0.86) 32%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0) 65%);"></div>
            </div>

            <!-- Content Area (Tanpa kotak, menyatu langsung dengan banner) -->
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
