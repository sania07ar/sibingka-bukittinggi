    <!-- ======================================================== -->
    <!-- 6. ABOUT MODAL                                           -->
    <!-- ======================================================== -->
    <div id="aboutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 relative">
            <button onclick="closeAboutModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('images/sibingka-logo.png') }}" alt="Logo SiBingka" class="h-10 w-auto">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Tentang SiBingka</h3>
                    <p class="text-xs text-slate-600 font-semibold">Badan Pusat Statistik Kota Bukittinggi</p>
                </div>
            </div>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                <strong>SiBingka (Sistem Informasi Bukittinggi dalam Angka)</strong> adalah platform terintegrasi yang dikembangkan oleh BPS Kota Bukittinggi untuk memudahkan Organisasi Perangkat Daerah (OPD) dan Instansi Vertikal dalam mengunggah, mengelola, serta memantau progres kelengkapan data sektoral secara real-time.
            </p>
            <div class="mt-6 flex justify-end">
                <button onclick="closeAboutModal()" class="px-5 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs">
                    Tutup
                </button>
            </div>
        </div>
    </div>
