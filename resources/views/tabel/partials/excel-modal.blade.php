<!-- EXCEL UPLOAD & AUTO-GENERATE FORM CONTAINER -->
<div id="excelUploadSection" class="mb-6 p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-emerald-50/80 via-white to-orange-50/40 border border-emerald-200/90 shadow-sm transition-all hidden">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-emerald-100">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-2xs shrink-0">
                <i class="fa-solid fa-file-excel"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 leading-snug">
                    Form Pengisian Data Tabel — Import Berkas Excel
                </h3>
                <p class="text-xs text-slate-600 mt-0.5" id="excelUploadSubtitle">
                    Import berkas Excel (.xlsx / .xls) untuk men-generate data tabel ini secara otomatis via Laravel Excel.
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <!-- Close Form Button -->
            <button onclick="toggleExcelUploadForm(false)" 
                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer"
                    title="Tutup form import">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Dropzone / File Picker -->
    <div id="excelDropZone" 
         onclick="document.getElementById('excelFileInput').click()"
         class="border-2 border-dashed border-emerald-300 hover:border-emerald-500 rounded-2xl p-6 sm:p-8 bg-white/90 hover:bg-emerald-50/40 transition-all text-center cursor-pointer group shadow-2xs">
        
        <input type="file" id="excelFileInput" accept=".xlsx, .xls, .csv" class="hidden" onchange="handleExcelFileSelected(event)">
        
        <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-100 group-hover:bg-emerald-600 text-emerald-700 group-hover:text-white flex items-center justify-center text-2xl transition-all shadow-xs mb-3 group-hover:scale-105">
            <i class="fa-solid fa-cloud-arrow-up"></i>
        </div>

        <h4 class="text-sm font-bold text-slate-800 group-hover:text-emerald-950 mb-1">
            Pilih Berkas Excel atau Tarik & Lepas (Drag & Drop) ke Sini
        </h4>
        <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
            Mendukung format <strong>.XLSX</strong>, <strong>.XLS</strong>, atau <strong>.CSV</strong>. Baris dan kolom akan dibaca secara instan dan di-generate menjadi tampilan tabel standar BPS.
        </p>

        <div class="mt-4 inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-emerald-600 group-hover:bg-emerald-700 text-white font-bold text-xs shadow-2xs transition-all">
            <i class="fa-solid fa-folder-open text-xs"></i>
            <span>Pilih Berkas dari Komputer</span>
        </div>
    </div>

    <!-- Loading / Processing indicator -->
    <div id="excelUploadLoading" class="hidden mt-4 p-4 rounded-xl bg-white border border-emerald-200 text-center space-y-2">
        <div class="inline-block animate-spin text-emerald-600 text-xl">
            <i class="fa-solid fa-circle-notch"></i>
        </div>
        <p class="text-xs font-bold text-slate-700">Membaca berkas Excel via Laravel Excel dan memperbarui baris tabel...</p>
    </div>

</div>

