<!-- =============================================================== -->
<!-- MODAL 3: KONFIRMASI HAPUS SATU AKUN -->
<!-- =============================================================== -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all duration-200">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-red-100 overflow-hidden transform transition-all p-6 text-center">
        
        <!-- Icon Danger -->
        <div class="w-16 h-16 mx-auto rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-2xl font-black mb-4 shadow-inner">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <!-- Title & Warning -->
        <h3 class="text-lg font-black text-slate-900 mb-1">Konfirmasi Hapus Akun</h3>
        <p class="text-xs text-slate-500 mb-4">
            Apakah Anda yakin ingin menghapus akun berikut dari sistem SiAngka Kota Bukittinggi?
        </p>

        <!-- Detail Box -->
        <div class="bg-red-50/70 border border-red-200/80 rounded-2xl p-3.5 mb-5 text-left space-y-1.5">
            <div class="flex items-center justify-between">
                <span class="text-[10.5px] font-bold text-red-500 uppercase tracking-wider">Nama Akun / Instansi:</span>
                <span id="deleteModalRoleBadge" class="text-[9.5px] font-black px-2 py-0.5 rounded-full bg-red-200 text-red-800">OPD</span>
            </div>
            <p id="deleteModalDinasName" class="text-sm font-extrabold text-slate-900 leading-snug">Dinas Terkait</p>
            <p class="text-xs font-mono text-slate-600">Username: <span id="deleteModalUsername" class="font-bold text-slate-800">@username</span></p>
            <div class="pt-2 border-t border-red-200/60 text-[10.5px] text-red-700 flex items-start space-x-1.5">
                <i class="fa-solid fa-circle-exclamation text-xs mt-0.5 shrink-0"></i>
                <span>Setelah dihapus, akun tidak dapat digunakan lagi untuk login. Tindakan ini permanen.</span>
            </div>
        </div>

        <!-- Form Action -->
        <form id="formDeleteDinas" method="POST" action="">
            @csrf
            <div class="flex items-center justify-end space-x-2">
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-2.5 px-4 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors border border-slate-200">
                    Batal
                </button>
                <button type="submit" class="w-1/2 py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 shadow-md shadow-red-600/20 transition-all flex items-center justify-center space-x-1.5">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Ya, Hapus Akun</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL 4: RESET / HAPUS MASSAL AKUN -->
<!-- =============================================================== -->
<div id="bulkDeleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all duration-200">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-red-100 overflow-hidden transform transition-all p-6">
        
        <div class="flex items-center space-x-3 mb-4 pb-3 border-b border-slate-100">
            <div class="w-11 h-11 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-lg font-black shrink-0">
                <i class="fa-solid fa-dumpster-fire"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-slate-900">Reset & Hapus Akun Massal</h3>
                <p class="text-xs text-slate-500">Pilih kelompok akun yang ingin dihapus atau dibersihkan</p>
            </div>
        </div>

        <form action="{{ route('kelola-akun.dinas.bulk-delete') }}" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-2.5">
                <label class="block text-xs font-bold text-slate-700">Pilih Kategori Akun Yang Akan Dihapus:</label>
                
                <label class="flex items-start space-x-3 p-3 rounded-xl border border-slate-200 hover:border-red-300 hover:bg-red-50/20 cursor-pointer transition-all">
                    <input type="radio" name="target_type" value="opd" class="mt-1 text-red-600 focus:ring-red-500 border-slate-300">
                    <div>
                        <p class="text-xs font-bold text-slate-800">Hapus Semua Akun OPD Kota (20 Dinas/Badan)</p>
                        <p class="text-[11px] text-slate-500">Hanya menghapus akun dinas pemerintah kota Bukittinggi.</p>
                    </div>
                </label>

                <label class="flex items-start space-x-3 p-3 rounded-xl border border-slate-200 hover:border-red-300 hover:bg-red-50/20 cursor-pointer transition-all">
                    <input type="radio" name="target_type" value="instansi" class="mt-1 text-red-600 focus:ring-red-500 border-slate-300">
                    <div>
                        <p class="text-xs font-bold text-slate-800">Hapus Semua Akun Instansi Vertikal (37 Instansi & Kampus)</p>
                        <p class="text-[11px] text-slate-500">Hanya menghapus akun instansi vertikal, BUMN, perbankan, dan perguruan tinggi.</p>
                    </div>
                </label>

                <label class="flex items-start space-x-3 p-3 rounded-xl border border-red-200 bg-red-50/30 hover:border-red-400 cursor-pointer transition-all">
                    <input type="radio" name="target_type" value="all" checked class="mt-1 text-red-600 focus:ring-red-500 border-slate-300">
                    <div>
                        <p class="text-xs font-bold text-red-700">Reset Total: Hapus Seluruh Akun Dinas & Instansi</p>
                        <p class="text-[11px] text-red-600/80">Menghapus seluruh akun dinas & instansi (Akun Administrator Super BPS tetap aman).</p>
                    </div>
                </label>
            </div>

            <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-amber-800 text-xs flex items-start space-x-2">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 mt-0.5 shrink-0"></i>
                <span>Setelah dihapus, Anda tetap dapat membuat ulang akun secara otomatis kapan saja menggunakan tombol <strong>Generate 20 OPD</strong> atau <strong>Generate 37 Instansi Vertikal</strong>.</span>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeBulkDeleteModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 shadow-md shadow-red-600/20 transition-all flex items-center space-x-1.5">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Eksekusi Hapus Akun</span>
                </button>
            </div>
        </form>

    </div>
</div>
