    <!-- CELL COMMENT / CHAT DRAWER (Slide-over di samping kecil) -->
    <div id="cellCommentDrawerBackdrop" onclick="closeCellCommentDrawer()" class="fixed inset-0 bg-slate-900/30 backdrop-blur-[2px] z-50 transition-opacity duration-300 opacity-0 pointer-events-none"></div>
    <div id="cellCommentDrawer" class="fixed top-0 right-0 bottom-0 w-80 sm:w-96 bg-white z-50 shadow-2xl flex flex-col border-l border-slate-200 transform translate-x-full transition-transform duration-300 ease-out">
        <!-- Drawer Header -->
        <div class="px-4 py-3.5 border-b border-slate-200 bg-slate-50 flex items-center justify-between shrink-0">
            <div class="flex items-center space-x-2.5 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-orange-100 text-[#f95a00] flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-comments text-sm"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-slate-800 text-xs sm:text-sm truncate">Catatan Rincian Data</h3>
                    <p id="drawerCellLabel" class="text-[11px] text-slate-500 truncate" title="...">Pilih rincian data</p>
                </div>
            </div>
            <button onclick="closeCellCommentDrawer()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition-colors cursor-pointer" title="Tutup">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Selected Cell Context Bar -->
        <div class="px-4 py-2.5 bg-orange-50/60 border-b border-orange-100 flex items-center justify-between text-xs shrink-0">
            <div class="flex items-center space-x-1.5 text-slate-600">
                <span class="text-[11px]">Nilai Rincian:</span>
                <span id="drawerCellValue" class="font-extrabold text-[#ea580c] px-2 py-0.5 rounded bg-white border border-orange-200 text-xs">-</span>
            </div>
            <span id="drawerCommentCountBadge" class="text-[10px] font-bold text-slate-500 bg-white px-2 py-0.5 rounded-full border border-slate-200">0 catatan</span>
        </div>

        <!-- Chat / Comment Stream (Scrollable) -->
        <div id="drawerCommentsStream" class="flex-1 overflow-y-auto p-4 space-y-3.5 flex flex-col bg-slate-50/40">
            <!-- Dynamic Content (Empty State or Comment Bubbles) -->
        </div>

        <!-- Drawer Footer Form (Input with Orange Border matching user screenshot) -->
        <form id="drawerCommentForm" onsubmit="handleSendComment(event)" class="p-3.5 border-t border-slate-200 bg-white shrink-0">
            <div class="relative flex items-center">
                <input type="text" id="drawerCommentInput" placeholder="Tambah catatan di sini..." autocomplete="off"
                    class="w-full border-2 border-[#f95a00] focus:border-[#d94e00] focus:outline-none focus:ring-0 rounded-xl pl-3.5 pr-11 py-2.5 text-xs text-slate-800 placeholder-slate-400 bg-white transition-all shadow-2xs" />
                <button type="submit" id="btnSubmitDrawerComment" class="absolute right-1.5 px-2.5 py-1.5 rounded-lg bg-[#f95a00] hover:bg-[#d94e00] text-white text-xs font-semibold transition-colors cursor-pointer shadow-2xs" title="Kirim Catatan">
                    <i class="fa-solid fa-paper-plane text-[11px]"></i>
                </button>
            </div>
            <div class="flex items-center justify-between mt-2 text-[10px] text-slate-400">
                <span>Tekan Enter untuk mengirim</span>
                <span class="text-orange-600 font-medium">BPS &amp; OPD Kolaboratif</span>
            </div>
        </form>
    </div>
