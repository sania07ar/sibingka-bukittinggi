<!-- ========================================================================= -->
<!-- MODAL 1: BUAT AKUN BARU (DINAS / INSTANSI VERTIKAL & PILIH HAK AKSES)     -->
<!-- ========================================================================= -->
<div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 hidden overflow-y-auto">
    <div class="bg-white rounded-3xl p-5 sm:p-7 max-w-2xl w-full shadow-2xl border border-slate-100 my-8 max-h-[90vh] flex flex-col">
        
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 shrink-0">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-orange-100 text-[#f95a00] flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm sm:text-base text-slate-900">Buat Akun Dinas / Instansi Vertikal Baru</h3>
                    <p class="text-[11px] text-slate-500">Pilih template dinas/instansi dan atur modul halaman yang boleh dilihat user</p>
                </div>
            </div>
            <button type="button" onclick="closeCreateModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Form Body (Scrollable) -->
        <form action="{{ route('kelola-akun.dinas.create') }}" method="POST" id="formCreateDinas" class="overflow-y-auto pr-1 space-y-4 pt-4 flex-1">
            @csrf

            <!-- Pilihan Tipe Akun: OPD Kota vs Instansi Vertikal -->
            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kategori Mitra / Akun <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-2.5">
                    <label class="flex items-center space-x-2 p-2.5 rounded-xl border border-slate-200 hover:border-orange-400 cursor-pointer transition-all bg-orange-50/30">
                        <input type="radio" name="role" id="create_role_opd" value="opd" checked onchange="toggleCategoryFilter('create', 'opd')" class="w-4 h-4 text-orange-600 focus:ring-orange-500">
                        <div class="leading-tight">
                            <span class="font-bold text-xs text-slate-900 block">Dinas / OPD Kota</span>
                            <span class="text-[10px] text-slate-500">20 Dinas di Lingkup Pemko</span>
                        </div>
                    </label>
                    <label class="flex items-center space-x-2 p-2.5 rounded-xl border border-slate-200 hover:border-indigo-400 cursor-pointer transition-all bg-indigo-50/30">
                        <input type="radio" name="role" id="create_role_instansi" value="instansi" onchange="toggleCategoryFilter('create', 'instansi')" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                        <div class="leading-tight">
                            <span class="font-bold text-xs text-slate-900 block">Instansi Vertikal & Lainnya</span>
                            <span class="text-[10px] text-slate-500">37 Mitra Vertikal & Perguruan Tinggi</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Hidden inputs: opd_code and name (PIC removed, name defaults to dinas) -->
            <input type="hidden" name="opd_code" id="create_opd_code" value="">
            <input type="hidden" name="name" id="create_name" value="">

            <!-- Nama Dinas / Instansi (Pilihan Dropdown) -->
            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Pilih Nama Dinas / Instansi <span class="text-red-500">*</span>
                </label>
                <select name="dinas_name" 
                        id="create_dinas_name" 
                        required 
                        onchange="handleDinasSelection(this.value, 'create')"
                        class="input-custom w-full px-3 py-2.5 rounded-xl text-xs font-bold text-slate-800 bg-white">
                    <option value="">-- Pilih Dinas / Instansi --</option>
                    <optgroup label="20 Dinas / OPD Kota Bukittinggi" id="create_opd_group">
                        @foreach($opdList as $c => $opd)
                            <option value="{{ $opd['name'] }}" data-code="{{ $c }}" data-role="opd" data-short="{{ $opd['short_name'] }}" data-username="{{ $opd['default_username'] }}">
                                {{ $c }}. {{ $opd['short_name'] }} - {{ $opd['name'] }}
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="37 Instansi Vertikal & Perguruan Tinggi" id="create_instansi_group">
                        @foreach($instansiList as $ic => $inst)
                            <option value="{{ $inst['name'] }}" data-code="{{ $ic }}" data-role="instansi" data-short="{{ $inst['short_name'] }}" data-username="{{ $inst['default_username'] }}">
                                {{ $ic }}. {{ $inst['short_name'] }} - {{ $inst['name'] }}
                            </option>
                        @endforeach
                    </optgroup>
                </select>
                <p class="text-[10.5px] text-slate-500 mt-1">Pilih dinas atau instansi dari daftar resmi Pemerintah Kota Bukittinggi</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                
                <!-- Username Login -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Username Login <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="username" 
                           id="create_username" 
                           required
                           placeholder="Contoh: dinas_pupr"
                           class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold font-mono">
                    <span class="text-[10px] text-slate-400">Digunakan untuk login ke sistem</span>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="password" 
                           id="create_password" 
                           required
                           placeholder="Minimal 6 karakter"
                           class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold font-mono">
                </div>

            </div>

            <!-- No. WhatsApp / Telepon Dinas -->
            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    No. WhatsApp / Kontak Dinas (Opsional)
                </label>
                <input type="text" 
                       name="phone" 
                       id="create_phone" 
                       placeholder="0812xxxxxxxx"
                       class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
            </div>

            <!-- SECTION PILIHAN HAK AKSES HALAMAN -->
            <div class="pt-3 border-t border-slate-200">
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-2.5 mb-2 gap-2">
                    <div>
                        <h4 class="font-black text-xs sm:text-sm text-slate-900 flex items-center space-x-1.5">
                            <i class="fa-solid fa-key text-orange-500"></i>
                            <span>Pilih Halaman Yang Dapat Dilihat User Ini</span>
                        </h4>
                        <p class="text-[10.5px] text-slate-500">Tentukan modul yang diizinkan untuk dibuka oleh akun ini</p>
                    </div>

                    <!-- Preset Buttons -->
                    <div class="flex flex-wrap items-center gap-1.5 text-[10.5px] font-bold">
                        <button type="button" onclick="setPageCheckboxes('create', ['isi-data-opd', 'monitoring-opd', 'tabel-opd'])" class="px-2 py-1 rounded bg-orange-100 text-[#f95a00] hover:bg-orange-200 transition-colors">
                            Standar OPD
                        </button>
                        <button type="button" onclick="setPageCheckboxes('create', ['isi-data-instansi', 'monitoring-instansi'])" class="px-2 py-1 rounded bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors">
                            Standar Instansi Vertikal
                        </button>
                        <button type="button" onclick="selectAllPages('create', true)" class="px-2 py-1 rounded bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                            Semua
                        </button>
                        <button type="button" onclick="selectAllPages('create', false)" class="px-2 py-1 rounded bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors">
                            Kosongkan
                        </button>
                    </div>
                </div>

                <!-- Checklist Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    @foreach($pagesList as $pKey => $pInfo)
                        @php
                            $isInstansiPage = str_contains($pKey, 'instansi');
                            $cardBorder = $isInstansiPage ? 'hover:border-indigo-300 hover:bg-indigo-50/20' : 'hover:border-orange-300 hover:bg-orange-50/20';
                            $accentColor = $isInstansiPage ? 'text-indigo-600' : 'text-orange-600';
                        @endphp
                        <label class="flex items-start space-x-2.5 p-2.5 rounded-xl border border-slate-200 {{ $cardBorder }} cursor-pointer transition-all group">
                            <input type="checkbox" 
                                   name="allowed_pages[]" 
                                   value="{{ $pKey }}" 
                                   class="create-page-cb mt-1 w-4 h-4 rounded text-orange-600 focus:ring-orange-500 border-slate-300"
                                   {{ in_array($pKey, ['isi-data-opd', 'monitoring-opd', 'tabel-opd']) ? 'checked' : '' }}>
                            <div class="flex-1 leading-tight">
                                <div class="flex items-center space-x-1.5">
                                    <i class="fa-solid {{ $pInfo['icon'] }} text-xs {{ $accentColor }}"></i>
                                    <span class="font-bold text-slate-900 text-xs">{{ $pInfo['name'] }}</span>
                                </div>
                                <p class="text-[10px] text-slate-500 mt-0.5 leading-snug">{{ $pInfo['description'] }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>

            </div>

            <!-- Footer Buttons -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2 shrink-0">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                    Batal
                </button>
                <button type="submit" class="btn-simonda text-xs">
                    <i class="fa-solid fa-circle-check mr-1.5"></i>
                    <span>Simpan & Buat Akun</span>
                </button>
            </div>

        </form>

    </div>
</div>
