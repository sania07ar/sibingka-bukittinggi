<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head', ['title' => 'Kelola Akun Dinas & Instansi Vertikal - SiAngka Kota Bukittinggi | BPS Kota Bukittinggi'])
    @include('admin.partials.styles')
</head>
<body class="min-h-screen text-slate-800 antialiased flex flex-col relative selection:bg-orange-500 selection:text-white bg-[#f1f4f9] overflow-x-hidden">

    <!-- Ambient Lighting Atmosphere & Watermark -->
    @include('partials.ambient')

    <!-- HEADER / NAVBAR -->
    @include('admin.partials.navbar')

    <!-- MAIN BODY -->
    <main class="relative z-10 flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-5 sm:py-7">
        
        <!-- Flash Alert Messages -->
        @include('admin.partials.alerts')

        <!-- TOP STATS COUNTER BAR -->
        @include('admin.partials.stats')

        <!-- TABS NAVIGATION -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200/90 shadow-xs mb-6 overflow-hidden">
            <div class="flex border-b border-slate-200">
                <button onclick="switchTab('tab-dinas')" 
                        id="tab-btn-dinas" 
                        class="tab-btn active px-5 py-3.5 text-xs sm:text-sm font-black border-b-2 border-transparent transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-users-gear text-sm"></i>
                    <span>Kelola Akun Dinas & Instansi Vertikal</span>
                    <span class="px-2 py-0.5 rounded-full text-[10.5px] bg-orange-100 text-orange-700 font-bold ml-1">
                        {{ $dinasUsers->count() }}
                    </span>
                </button>
                <button onclick="switchTab('tab-admin')" 
                        id="tab-btn-admin" 
                        class="tab-btn px-5 py-3.5 text-xs sm:text-sm font-bold text-slate-600 border-b-2 border-transparent hover:text-slate-900 transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                    <span>Profil & Password Administrator BPS</span>
                </button>
            </div>
        </div>

        <!-- TAB 1: KELOLA AKUN DINAS, INSTANSI VERTIKAL & HAK AKSES HALAMAN -->
        @include('admin.partials.tab-dinas')

        <!-- TAB 2: PENGATURAN PROFIL & PASSWORD ADMIN BPS -->
        @include('admin.partials.tab-admin')

    </main>

    <!-- FOOTER COPYRIGHT -->
    @include('partials.footer')

    <!-- MODAL DIALOGS -->
    @include('admin.partials.modal-create')
    @include('admin.partials.modal-edit')
    @include('admin.partials.modal-delete')

    <!-- JAVASCRIPT LOGIC -->
    @include('admin.partials.scripts')

</body>
</html>
