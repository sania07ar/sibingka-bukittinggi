@props([
    'agencyList' => [],
    'agencyTypeLabel' => 'Dinas / Instansi Penyelenggara Data'
])

<!-- POPUP MODAL TAMBAH TABEL BARU (HANYA ADMINISTRATOR BPS) -->
<div id="addTableModal" style="z-index: 100;" class="fixed inset-0 hidden items-center justify-center p-3 sm:p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300">
    <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl transform transition-all scale-95 opacity-0 duration-300 border border-slate-100 relative" id="addTableModalCard">
        
        <!-- Modal Header -->
        <div class="flex items-start justify-between border-b border-slate-100 pb-3 mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-orange-100 text-[#f98825] flex items-center justify-center text-sm font-bold shadow-2xs shrink-0">
                    <i class="fa-solid fa-table-columns"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                        Tambah Tabel Baru
                    </h3>
                    <p id="addTableOpdSubtitle" class="text-[11px] text-slate-500 font-medium">-</p>
                </div>
            </div>
            <button type="button" onclick="closeAddTableModal()" class="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors shrink-0 cursor-pointer" title="Tutup">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form id="addTableForm" onsubmit="submitNewTable(event)" class="space-y-3.5">
            <!-- Pilihan OPD/Instansi (Muncul jika dibuka secara global) -->
            <div id="addTableOpdSelectorContainer" class="hidden">
                <label for="newTableOpdSelect" class="block text-xs font-bold text-slate-700 mb-1">
                    {{ $agencyTypeLabel }} <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="newTableOpdSelect" class="w-full bg-[#f8fafc] hover:bg-[#f1f5f9] focus:bg-white border border-slate-200 focus:border-[#f98825] rounded-xl px-3.5 py-2 text-xs sm:text-sm text-slate-800 font-semibold focus:outline-none transition-all cursor-pointer">
                        @foreach($agencyList as $agency)
                            <option value="{{ $agency['code'] }}">{{ $agency['code'] }}. {{ $agency['short'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Kode Tabel -->
            <div>
                <label for="newTableCode" class="block text-xs font-bold text-slate-700 mb-1">
                    Nomor / Kode Tabel <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text"
                           id="newTableCode"
                           required
                           placeholder="Contoh: 8.1.6 atau 1.2.1"
                           class="w-full bg-[#f8fafc] hover:bg-[#f1f5f9] focus:bg-white border border-slate-200 focus:border-[#f98825] rounded-xl px-3.5 py-2 text-xs sm:text-sm text-slate-800 font-semibold focus:outline-none transition-all">
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Gunakan format angka dan titik (misal: 8.1.6) sesuai bab dan urutan tabel daerah.</p>
            </div>

            <!-- Judul Tabel (Indonesia) -->
            <div>
                <label for="newTableTitle" class="block text-xs font-bold text-slate-700 mb-1">
                    Judul Tabel (Bahasa Indonesia) <span class="text-red-500">*</span>
                </label>
                <textarea id="newTableTitle"
                          rows="2"
                          required
                          placeholder="Contoh: Panjang Jembatan Menurut Kondisi di Kota Bukittinggi (m)"
                          class="w-full bg-[#f8fafc] hover:bg-[#f1f5f9] focus:bg-white border border-slate-200 focus:border-[#f98825] rounded-xl px-3.5 py-2 text-xs sm:text-sm text-slate-800 font-medium focus:outline-none transition-all resize-none"></textarea>
            </div>

            <!-- Judul Tabel (Inggris) -->
            <div>
                <label for="newTableTitleEn" class="block text-xs font-bold text-slate-700 mb-1">
                    Judul Tabel (Bahasa Inggris) <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
                </label>
                <textarea id="newTableTitleEn"
                          rows="2"
                          placeholder="Contoh: Length of Bridges by Condition in Bukittinggi Municipality (m)"
                          class="w-full bg-[#f8fafc] hover:bg-[#f1f5f9] focus:bg-white border border-slate-200 focus:border-[#f98825] rounded-xl px-3.5 py-2 text-xs sm:text-sm text-slate-800 font-medium focus:outline-none transition-all resize-none"></textarea>
            </div>

            <!-- Modal Footer -->
            <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="closeAddTableModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="btnSubmitNewTable" class="px-4 py-2 rounded-xl bg-[#f98825] hover:bg-[#e07212] text-white text-xs font-bold shadow-xs hover:shadow-md transition-all flex items-center space-x-1.5 cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Simpan Tabel Baru</span>
                </button>
            </div>
        </form>

    </div>
</div>

