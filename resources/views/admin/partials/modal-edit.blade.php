<!-- ========================================================================= -->
<!-- MODAL 2: EDIT AKUN & UBAH HAK AKSES HALAMAN                              -->
<!-- ========================================================================= -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 hidden overflow-y-auto">
    <div class="bg-white rounded-3xl p-5 sm:p-7 max-w-2xl w-full shadow-2xl border border-slate-100 my-8 max-h-[90vh] flex flex-col">
        
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 shrink-0">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm sm:text-base text-slate-900" id="editModalTitle">Edit Akun Dinas</h3>
                    <p class="text-[11px] text-slate-500">Perbarui profil dan kredensial akun pengguna</p>
                </div>
            </div>
            <button type="button" onclick="closeEditModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Form Body (Scrollable) -->
        <form action="" method="POST" id="formEditDinas" class="overflow-y-auto pr-1 space-y-4 pt-4 flex-1">
            @csrf

            <!-- Kategori / Role -->
            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kategori Akun
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                    <label class="flex items-center space-x-2 p-2 rounded-xl border border-slate-200 cursor-pointer">
                        <input type="radio" name="role" id="edit_role_opd" value="opd" onchange="toggleCategoryFilter('edit', 'opd')" class="w-4 h-4 text-orange-600 focus:ring-orange-500">
                        <span class="font-bold text-xs text-slate-800">Dinas / OPD Kota</span>
                    </label>
                    <label class="flex items-center space-x-2 p-2 rounded-xl border border-slate-200 cursor-pointer">
                        <input type="radio" name="role" id="edit_role_instansi" value="instansi" onchange="toggleCategoryFilter('edit', 'instansi')" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                        <span class="font-bold text-xs text-slate-800">Instansi Vertikal</span>
                    </label>
                    <label class="flex items-center space-x-2 p-2 rounded-xl border border-slate-200 cursor-pointer">
                        <input type="radio" name="role" id="edit_role_walidata" value="walidata" onchange="toggleCategoryFilter('edit', 'walidata')" class="w-4 h-4 text-teal-600 focus:ring-teal-500">
                        <span class="font-bold text-xs text-slate-800">Wali Data (Diskominfo)</span>
                    </label>
                </div>
            </div>

            <!-- Hidden inputs: opd_code and name (PIC removed, name defaults to dinas) -->
            <input type="hidden" name="opd_code" id="edit_opd_code" value="">
            <input type="hidden" name="name" id="edit_name" value="">

            <!-- Nama Dinas / Instansi (Pilihan Dropdown) -->
            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Pilih Nama Dinas / Instansi <span class="text-red-500">*</span>
                </label>
                <select name="dinas_name" 
                        id="edit_dinas_name" 
                        required 
                        onchange="handleDinasSelection(this.value, 'edit')"
                        class="input-custom w-full px-3 py-2.5 rounded-xl text-xs font-bold text-slate-800 bg-white">
                    <option value="">-- Pilih Dinas / Instansi --</option>
                    <optgroup label="20 Dinas / OPD Kota Bukittinggi" id="edit_opd_group">
                        @foreach($opdList as $c => $opd)
                            <option value="{{ $opd['name'] }}" data-code="{{ $c }}" data-role="opd" data-short="{{ $opd['short_name'] }}" data-username="{{ $opd['default_username'] }}">
                                {{ $c }}. {{ $opd['short_name'] }} - {{ $opd['name'] }}
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="37 Instansi Vertikal & Perguruan Tinggi" id="edit_instansi_group">
                        @foreach($instansiList as $ic => $inst)
                            <option value="{{ $inst['name'] }}" data-code="{{ $ic }}" data-role="instansi" data-short="{{ $inst['short_name'] }}" data-username="{{ $inst['default_username'] }}">
                                {{ $ic }}. {{ $inst['short_name'] }} - {{ $inst['name'] }}
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Wali Data Statistik Sektoral" id="edit_walidata_group">
                        <option value="Dinas Komunikasi dan Informatika (Wali Data)" data-code="00" data-role="walidata" data-short="DISKOMINFO" data-username="walidata_kominfo">
                            00. DISKOMINFO - Bagian Sistem Informasi (Wali Data Kota)
                        </option>
                    </optgroup>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                
                <!-- Username Login -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Username Login <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="username" 
                           id="edit_username" 
                           required
                           class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold font-mono">
                </div>

                <!-- Password Baru (Opsional) -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kata Sandi Baru (Kosongkan jika tidak diubah)
                    </label>
                    <input type="text" 
                           name="password" 
                           id="edit_password" 
                           placeholder="Ketik password baru jika ingin mereset"
                           class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold font-mono">
                </div>

            </div>

            <!-- No. WhatsApp / HP Dinas -->
            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    No. WhatsApp / Kontak Dinas (Opsional)
                </label>
                <input type="text" 
                       name="phone" 
                       id="edit_phone" 
                       class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
            </div>


            <!-- Status Aktif Checkbox -->
            <div class="pt-2 flex items-center">
                <label class="flex items-center space-x-2 cursor-pointer select-none">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                    <span class="text-xs font-bold text-slate-800">Status Akun Aktif</span>
                </label>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between shrink-0">
                <button type="button" 
                        onclick="triggerDeleteFromEditModal()" 
                        class="inline-flex items-center space-x-1 px-3 py-2 rounded-xl text-xs font-bold text-red-600 hover:bg-red-50 hover:text-red-700 border border-transparent hover:border-red-200 transition-all">
                    <i class="fa-solid fa-trash-can text-xs mr-1"></i>
                    <span>Hapus Akun Ini</span>
                </button>
                <div class="flex items-center space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="btn-simonda text-xs">
                        <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>
