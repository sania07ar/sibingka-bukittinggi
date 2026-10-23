<!-- CARD 1: KELOLA AKUN -->
<a href="{{ route('kelola-akun') }}" 
   id="card-kelola-akun"
   class="portal-card block bg-white/95 backdrop-blur-md rounded-xl sm:rounded-2xl p-3.5 sm:p-5 lg:p-6 border border-slate-200/90 shadow-md sm:shadow-lg shadow-slate-900/5 relative overflow-hidden flex flex-col justify-between group hover:border-slate-400 hover:shadow-slate-900/10 active:border-indigo-400 no-underline text-inherit cursor-pointer">
    <div>
        <!-- Header Icon -->
        <div class="mb-2 sm:mb-3 lg:mb-4">
            <div class="w-9 h-9 sm:w-11 sm:h-11 lg:w-12 lg:h-12 rounded-lg sm:rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-base sm:text-lg lg:text-xl shadow-inner group-hover:scale-105 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-user-gear"></i>
            </div>
        </div>

        <!-- Title & Description -->
        <h2 class="text-sm sm:text-lg lg:text-xl font-black text-slate-900 tracking-tight mb-1 group-hover:text-indigo-600 transition-colors">
            Kelola Akun Admin
        </h2>
        
        <p class="text-[10.5px] sm:text-[11.5px] lg:text-xs text-slate-600 leading-snug sm:leading-relaxed mb-2 sm:mb-3">
            Perbarui profil admin BPS, ganti kata sandi, kelola akun dinas/instansi, dan izin akses halaman.
        </p>

        <!-- Features Checklist -->
        <div class="space-y-1 sm:space-y-1.5 mb-3 lg:mb-4 bg-slate-50/80 rounded-lg sm:rounded-xl p-2 sm:p-2.5 lg:p-3 border border-slate-100 text-[10.5px] sm:text-[11px] lg:text-xs font-semibold text-slate-700">
            <div class="flex items-center">
                <i class="fa-solid fa-key text-amber-500 mr-2 text-[10.5px] sm:text-xs"></i>
                <span>Ganti & Perbarui Kata Sandi</span>
            </div>
            <div class="flex items-center">
                <i class="fa-solid fa-id-card text-blue-500 mr-2 text-[10.5px] sm:text-xs"></i>
                <span>Profil Nama & NIP Administrator</span>
            </div>
            <div class="flex items-center">
                <i class="fa-solid fa-shield-check text-emerald-500 mr-2 text-[10.5px] sm:text-xs"></i>
                <span>Keamanan Sesi & Akses Login</span>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div>
        <div class="btn-account w-full text-[11px] sm:text-xs py-2 sm:py-2.5 px-3 uppercase tracking-wider space-x-2 group-hover:shadow-md transition-all font-bold"
             id="btn-pilih-kelola-akun">
            <span>Kelola Akun Sekarang</span>
            <i class="fa-solid fa-arrow-right text-[10px] sm:text-[11px] transition-transform group-hover:translate-x-1"></i>
        </div>
    </div>
</a>
