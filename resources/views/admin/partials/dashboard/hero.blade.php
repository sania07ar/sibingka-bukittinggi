
<!-- Hero Panoramic Banner -->
<div
    id="beranda-section"
    class="scroll-mt-24 relative w-full rounded-3xl overflow-hidden
           border border-slate-200/80 shadow-sm bg-white
           flex items-center min-h-[560px] sm:min-h-[420px] lg:min-h-[440px]"
>

    <!-- Responsive Background Image -->
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">

        <img
            src="{{ asset('images/fgd.jpeg') }}?v={{ file_exists(public_path('images/fgd.jpeg')) ? filemtime(public_path('images/fgd.jpeg')) : time() }}"
            alt="FGD Bukittinggi dalam Angka"
            class="w-full h-full object-cover object-[70%_center]"
        >

        <!-- Mobile Gradient: Strong White Overlay for Readability -->
        <div
            class="absolute inset-0 sm:hidden"
            style="background: linear-gradient(
                to bottom,
                rgba(255,255,255,0.98) 0%,
                rgba(255,255,255,0.96) 10%,
                rgba(255,255,255,0.85) 50%,
                rgba(255,255,255,0.25) 90%
            );"
        ></div>

        <!-- Desktop Gradient: Original Panoramic Appearance -->
        <div
            class="hidden sm:block absolute inset-0"
            style="background: linear-gradient(
                to right,
                rgba(255,255,255,0.97) 0%,
                rgba(255,255,255,0.90) 32%,
                rgba(255,255,255,0.45) 55%,
                rgba(255,255,255,0) 75%
            );"
        ></div>

    </div>

    <!-- Content Area -->
    <div
        class="relative z-10 w-full max-w-xl lg:max-w-2xl
               px-5 sm:px-10 lg:px-14
               py-10 sm:py-8 md:py-12"
    >

        <!-- Greeting -->
        <p class="text-xs sm:text-sm font-bold text-[#ea580c] tracking-wide mb-2.5">
            Selamat Datang,
            <span class="text-[#f95a00] font-extrabold">
                {{ $dinasName }}
            </span>
        </p>

        <!-- Main Title -->
        <div class="space-y-1 mb-2">

            <h1
                class="text-3xl sm:text-4xl lg:text-5xl
                       font-bold text-slate-800 tracking-tight
                       leading-tight flex flex-wrap items-baseline
                       gap-x-3 gap-y-1"
            >
                <span class="text-slate-900 font-bold">
                    SiBingka
                </span>

                <span
                    class="text-xl sm:text-2xl lg:text-3xl
                           font-bold text-[#f95a00]
                           font-sans tracking-tight"
                >
                    Kota Bukittinggi
                </span>
            </h1>

        </div>

        <!-- Subtitle -->
        <p
            class="text-sm sm:text-base lg:text-lg
                   font-bold text-slate-800 mt-3
                   tracking-normal leading-snug"
        >
            Sistem Informasi Bukittinggi dalam Angka
        </p>

        <!-- Description -->
        <p
            class="text-sm sm:text-sm lg:text-base
                   text-slate-700 font-medium mt-3
                   leading-relaxed max-w-md lg:max-w-lg"
        >
            Satu sistem informasi untuk pengelolaan, pemantauan,
            dan penyajian data statistik sektor pembangunan
            Kota Bukittinggi secara terintegrasi.
        </p>

        <!-- CTA Button -->
        <div class="mt-6 sm:mt-7 flex flex-wrap items-center gap-3">

            <a
                href="#monitoring-section"
                class="btn-orange-glow inline-flex items-center gap-2.5
                       bg-[#f95a00] hover:bg-[#ea580c]
                       text-white font-bold text-sm
                       px-6 py-3 rounded-xl
                       shadow-lg shadow-orange-500/30
                       transition-all transform hover:-translate-y-0.5
                       no-underline"
            >
                <span>Mulai Monitoring</span>

                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>

        </div>

    </div>

</div>
