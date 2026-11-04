{{-- CARD MONITORING TABEL PER DINAS & PER TABEL --}}
@php
    $loggedUser = auth()->user();
    $userOpdCode = null;
    if ($loggedUser && !empty($loggedUser->opd_code)) {
        $userOpdCode = str_pad($loggedUser->opd_code, 2, '0', STR_PAD_LEFT);
    }
    $initialOpd = request('opd', $userOpdCode ?? '01');
    $initialTable = request('table', request('code', ''));
    $initialYear = (int) request('year', $selectedYear ?? 2025);
    $activeTabType = $activeTab ?? 'opd';
@endphp

<div class="bg-white rounded-3xl p-5 sm:p-7 shadow-xs border border-slate-100 hover:border-orange-200 transition-all mb-6">
    
    <!-- Top Header: Icon + Title + Subtitle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3 mb-5">
        <div class="flex items-center space-x-3.5">
            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-[#fff4eb] text-[#f95a00] flex items-center justify-center text-lg sm:text-xl font-black shrink-0 shadow-2xs">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                        Monitoring Tabel
                    </h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-orange-100 text-[#f95a00] border border-orange-200 uppercase tracking-wide">
                        Atribut & Status
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Pilih Dinas, Tabel Statistik, dan Tahun untuk memantau status pengumpulan data sektoral secara rinci.
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-2 text-xs text-slate-400 font-medium">
            <!-- Badge Tahun Data Aktif (Tahun dipilih dari selector atas) -->
            <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-orange-50 border border-orange-200 text-[#f95a00] font-bold text-xs shadow-2xs">
                <i class="fa-solid fa-calendar-days text-[11px]"></i>
                <span>Tahun Data: <strong class="text-slate-900">{{ $selectedYear }}</strong></span>
            </span>
            <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-600 font-bold text-xs">
                <i class="fa-solid fa-circle-dot text-[9px] text-[#f95a00]"></i>
                <span id="monSummaryTotalTables">0 Tabel</span>
            </span>
        </div>
    </div>

    <!-- 2-Level Filter: 1. Dinas / OPD -> 2. Tabel Data (Tahun Mengikuti Pilihan Di Atas) -->
    <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200/80 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 sm:gap-4 items-end">
            
            <!-- 1. PILIH DINAS / OPD -->
            <div class="md:col-span-6">
                <label for="monFilterAgency" class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span class="flex items-center space-x-1.5">
                        <span class="w-4 h-4 rounded-full bg-[#f95a00] text-white text-[10px] flex items-center justify-center font-bold">1</span>
                        <span>Pilih Dinas / Instansi Penyelenggara</span>
                    </span>
                    <span id="monAgencyBadge" class="text-[10px] font-bold text-slate-400"></span>
                </label>
                <div class="relative">
                    <select id="monFilterAgency" onchange="onMonAgencyChanged(this.value)"
                            class="w-full appearance-none pl-9 pr-9 py-2.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 font-bold text-xs sm:text-[13px] text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#f95a00]/30 focus:border-[#f95a00] shadow-2xs transition-all cursor-pointer">
                        @if($activeTabType === 'instansi')
                            @foreach(config('simonda.instansi_list', []) as $iCode => $iInfo)
                                <option value="{{ $iCode }}" {{ $initialOpd === $iCode ? 'selected' : '' }}>
                                    {{ $iCode }}. {{ $iInfo['name'] ?? $iInfo['short_name'] }}
                                </option>
                            @endforeach
                        @else
                            @foreach(config('simonda.opd_list', []) as $oCode => $oInfo)
                                <option value="{{ $oCode }}" {{ $initialOpd === $oCode ? 'selected' : '' }}>
                                    {{ $oCode }}. {{ $oInfo['name'] ?? $oInfo['short_name'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center text-[#f95a00] text-xs">
                        <i class="fa-solid {{ $activeTabType === 'instansi' ? 'fa-landmark' : 'fa-building' }}"></i>
                    </div>
                    <div class="pointer-events-none absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 text-xs">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>

            <!-- 2. PILIH TABEL DATA -->
            <div class="md:col-span-6">
                <label for="monFilterTable" class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span class="flex items-center space-x-1.5">
                        <span class="w-4 h-4 rounded-full bg-[#f95a00] text-white text-[10px] flex items-center justify-center font-bold">2</span>
                        <span>Pilih Tabel Statistik Sektoral</span>
                    </span>
                    <span id="monTableCountBadge" class="text-[10px] font-bold text-[#f95a00]"></span>
                </label>
                <div class="relative">
                    <select id="monFilterTable" onchange="onMonTableChanged(this.value)"
                            class="w-full appearance-none pl-9 pr-9 py-2.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 font-bold text-xs sm:text-[13px] text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#f95a00]/30 focus:border-[#f95a00] shadow-2xs transition-all cursor-pointer">
                        <option value="">-- Memuat Daftar Tabel... --</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center text-[#f95a00] text-xs">
                        <i class="fa-solid fa-table-list"></i>
                    </div>
                    <div class="pointer-events-none absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 text-xs">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ATTRIBUTES & DETAIL CARD (SESUAI GAMBAR REFERENSI USER) -->
    <div id="monAttributesCard" class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-white relative transition-all">
        
        <div class="flex flex-wrap items-center justify-between pb-3.5 mb-4 border-b border-slate-100 gap-2">
            <h3 class="text-xs sm:text-sm font-black text-slate-900 tracking-wider uppercase flex items-center space-x-2">
                <span class="w-2 h-4 rounded-full bg-[#f95a00] inline-block"></span>
                <span>Attributes:</span>
            </h3>
            
            <!-- Quick Status Pill -->
            <div id="monTableStatusPillContainer" class="flex items-center space-x-2">
                <!-- Injected via JS -->
            </div>
        </div>

        <!-- Attributes Grid Layout (Sesuai Referensi) -->
        <div class="space-y-4 text-xs sm:text-[13px]">
            
            <!-- 1. Judul Tabel -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 items-start">
                <div class="md:col-span-3 font-bold text-slate-500">Judul:</div>
                <div class="md:col-span-9">
                    <p id="monAttrTitleId" class="font-extrabold text-slate-900 leading-snug">
                        -
                    </p>
                    <p id="monAttrTitleEn" class="italic text-slate-500 font-medium text-xs mt-1 leading-snug">
                        -
                    </p>
                </div>
            </div>

            <!-- 2. Tipe / Bidang -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 items-center">
                <div class="md:col-span-3 font-bold text-slate-500">Tipe:</div>
                <div class="md:col-span-9 font-semibold text-slate-800 flex items-center space-x-2">
                    <span id="monAttrType" class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200">
                        Wilayah
                    </span>
                    <span id="monAttrCategory" class="text-xs text-slate-500">Statistik Sektoral BPS</span>
                </div>
            </div>

            <!-- 3. Sumber Data (Desentralisasi Badge Hijau Toska) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 items-center">
                <div class="md:col-span-3 font-bold text-slate-500">Sumber Data:</div>
                <div class="md:col-span-9">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#0d9488] text-white shadow-2xs">
                        Desentralisasi
                    </span>
                    <span id="monAttrSource" class="ml-2.5 text-xs text-slate-600 font-medium">
                        -
                    </span>
                </div>
            </div>

            <!-- 4. Level Penyajian Data -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 items-center">
                <div class="md:col-span-3 font-bold text-slate-500">Level Penyajian Data:</div>
                <div class="md:col-span-9 font-extrabold text-slate-800">
                    Kabupaten/Kota <span class="text-slate-400 font-normal">(Kota Bukittinggi)</span>
                </div>
            </div>

            <!-- 5. Dinas / Instansi Penyelenggara Data -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 items-center">
                <div class="md:col-span-3 font-bold text-slate-500">Penyelenggara Data:</div>
                <div id="monAttrAgency" class="md:col-span-9 font-bold text-slate-800">
                    -
                </div>
            </div>

            <!-- 6. Keterangan / Status Monitoring Progress -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 sm:gap-4 items-start pt-2 border-t border-slate-100">
                <div class="md:col-span-3 font-bold text-slate-500">Status Progres & Verifikasi:</div>
                <div class="md:col-span-9 space-y-2">
                    <div id="monAttrProgressDetails" class="flex flex-wrap items-center gap-2">
                        <!-- Injected via JS -->
                    </div>
                    <p id="monAttrLastUpdate" class="text-[11px] text-slate-400 font-medium">
                        Terakhir diperbarui: -
                    </p>
                </div>
            </div>

        </div>

        <!-- Action Buttons: Buka Tabel Data & Edit Data -->
        <div class="mt-6 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <div class="text-xs text-slate-500 font-medium flex items-center space-x-1.5">
                <i class="fa-solid fa-circle-info text-slate-400"></i>
                <span>Gunakan tombol aksi untuk langsung melihat atau mengedit isian data tabel ini.</span>
            </div>
            
            <div class="flex items-center space-x-2">
                <!-- Tombol Edit Data -->
                <a id="monBtnEditTable" href="#"
                   class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300 font-bold text-xs sm:text-sm shadow-2xs hover:shadow transition-all cursor-pointer">
                    <i class="fa-solid fa-pen-to-square text-amber-700"></i>
                    <span>Edit Tabel</span>
                </a>

                <!-- Tombol Buka Tabel Data -->
                <a id="monBtnViewTable" href="#"
                   class="inline-flex items-center space-x-1.5 px-5 py-2 rounded-xl bg-[#f95a00] hover:bg-[#e04e00] text-white font-bold text-xs sm:text-sm shadow-2xs hover:shadow-md transition-all cursor-pointer">
                    <i class="fa-solid fa-table"></i>
                    <span>Buka Tabel Data</span>
                    <i class="fa-solid fa-arrow-right text-[11px] ml-1"></i>
                </a>
            </div>
        </div>

    </div>

</div>

<!-- JAVASCRIPT LOGIKA FILTER 3 TINGKAT & ATRIBUT TABEL -->
<script>
    window.monSelectedAgency = '{{ $initialOpd }}';
    window.monSelectedTable = '{{ $initialTable }}';
    window.monSelectedYear = {{ $initialYear }};
    window.monTabType = '{{ $activeTabType }}';

    // Helper untuk mendeteksi kategori tipe tabel dari kode
    function getTableFieldType(tableCode) {
        if (!tableCode) return 'Wilayah';
        const str = tableCode.toString().trim();
        if (str.startsWith('1.')) return 'Wilayah & Geografi';
        if (str.startsWith('2.')) return 'Pemerintahan & Keuangan';
        if (str.startsWith('3.')) return 'Penduduk & Ketenagakerjaan';
        if (str.startsWith('4.1')) return 'Pendidikan & Sosial';
        if (str.startsWith('4.2')) return 'Kesehatan & Lingkungan';
        if (str.startsWith('4.3')) return 'Sosial & Bencana Alam';
        if (str.startsWith('5.')) return 'Pertanian & Perkebunan';
        if (str.startsWith('6.')) return 'Industri & Energi';
        if (str.startsWith('7.')) return 'Perdagangan & Hotel';
        if (str.startsWith('8.')) return 'Transportasi & Infrastruktur';
        if (str.startsWith('9.')) return 'Koperasi & UKM';
        if (str.startsWith('10.')) return 'Keuangan Daerah';
        if (str.startsWith('11.')) return 'PDRB & Penanaman Modal';
        return 'Sosial & Kependudukan';
    }

    // Dipanggil saat dinas / OPD diubah
    function onMonAgencyChanged(newAgencyCode) {
        window.monSelectedAgency = newAgencyCode;
        populateMonTableDropdown(newAgencyCode);
    }

    // Dipanggil saat tabel diubah
    function onMonTableChanged(newTableCode) {
        window.monSelectedTable = newTableCode;
        renderMonTableAttributes();
    }

    // Mengisi dropdown tabel berdasarkan dinas yang dipilih
    function populateMonTableDropdown(agencyCode) {
        const selectEl = document.getElementById('monFilterTable');
        if (!selectEl) return;

        let tables = [];
        if (typeof getAgencyTables === 'function') {
            tables = getAgencyTables(agencyCode, window.monTabType);
        } else if (typeof opdTablesCatalog !== 'undefined') {
            const clean = agencyCode ? agencyCode.toString().padStart(2, '0') : '01';
            const cat = (window.monTabType === 'instansi' && typeof instansiTablesCatalog !== 'undefined')
                ? instansiTablesCatalog
                : opdTablesCatalog;
            tables = cat[clean] || [];
        }

        selectEl.innerHTML = '';

        if (!tables || tables.length === 0) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = '-- Belum ada tabel terdaftar untuk instansi ini --';
            selectEl.appendChild(opt);
            window.monSelectedTable = '';
            renderMonTableAttributes();
            return;
        }

        // Tampilkan badge jumlah tabel
        const badgeEl = document.getElementById('monTableCountBadge');
        if (badgeEl) {
            badgeEl.innerText = `${tables.length} Tabel`;
        }

        const summaryEl = document.getElementById('monSummaryTotalTables');
        if (summaryEl) {
            summaryEl.innerText = `${tables.length} Tabel di Instansi Ini`;
        }

        let selectedMatched = false;
        tables.forEach((t, idx) => {
            const opt = document.createElement('option');
            opt.value = t.code;
            opt.textContent = `Tabel ${t.code} - ${t.title || ''}`;
            if (window.monSelectedTable && t.code === window.monSelectedTable) {
                opt.selected = true;
                selectedMatched = true;
            } else if (!window.monSelectedTable && idx === 0) {
                opt.selected = true;
                selectedMatched = true;
                window.monSelectedTable = t.code;
            }
            selectEl.appendChild(opt);
        });

        if (!selectedMatched && tables.length > 0) {
            window.monSelectedTable = tables[0].code;
            selectEl.value = tables[0].code;
        }

        renderMonTableAttributes();
    }

    // Render tampilan attributes dan status verifikasi tabel
    function renderMonTableAttributes() {
        const agencyCode = window.monSelectedAgency ? window.monSelectedAgency.toString().padStart(2, '0') : '01';
        const tableCode = window.monSelectedTable;
        const year = window.monSelectedYear || 2025;

        // Dapatkan nama dinas
        const agencySelect = document.getElementById('monFilterAgency');
        let agencyName = agencySelect && agencySelect.selectedOptions[0] ? agencySelect.selectedOptions[0].text : `Instansi ${agencyCode}`;
        const agencyEl = document.getElementById('monAttrAgency');
        if (agencyEl) agencyEl.innerText = agencyName;

        // Dapatkan metadata info tabel dari katalog
        let tableInfo = null;
        if (typeof getCatalogTableInfo === 'function') {
            tableInfo = getCatalogTableInfo(tableCode, agencyCode, window.monTabType);
        }

        // Dapatkan data status verifikasi dari database jika di-inject oleh backend
        const dbKey = `${agencyCode}_${tableCode}`;
        const dbStatus = (window.allTablesStatusDb && window.allTablesStatusDb[dbKey]) ? window.allTablesStatusDb[dbKey] : null;

        // 1. Judul Tabel
        const titleIdEl = document.getElementById('monAttrTitleId');
        const titleEnEl = document.getElementById('monAttrTitleEn');
        let titleId = (dbStatus && dbStatus.title_id) ? dbStatus.title_id : (tableInfo && tableInfo.title ? tableInfo.title : `Tabel Data Statistik Sektoral ${tableCode}`);
        let titleEn = (dbStatus && dbStatus.title_en) ? dbStatus.title_en : (tableInfo && tableInfo.titleEn ? tableInfo.titleEn : `Sectoral Statistics Table ${tableCode} in Bukittinggi Municipality`);

        // Format dengan tahun jika belum ada
        if (!titleId.includes(String(year))) {
            titleId = `${titleId}, ${year}`;
        }
        if (!titleEn.includes(String(year))) {
            titleEn = `${titleEn}, ${year}`;
        }

        if (titleIdEl) titleIdEl.innerText = titleId;
        if (titleEnEl) titleEnEl.innerText = titleEn;

        // 2. Tipe / Bidang
        const typeEl = document.getElementById('monAttrType');
        if (typeEl) {
            typeEl.innerText = getTableFieldType(tableCode);
        }

        // 3. Sumber Data
        const sourceEl = document.getElementById('monAttrSource');
        if (sourceEl) {
            sourceEl.innerText = (dbStatus && dbStatus.source) ? dbStatus.source.replace(/<[^>]*>?/gm, '') : `${agencyName} / BPS Kota Bukittinggi`;
        }

        // 4. Status Pengumpulan Berdasarkan Angka Data Riil & Verifikasi
        const numStatus = (dbStatus && dbStatus.numeric_status) ? {
            status: dbStatus.status || dbStatus.numeric_status,
            numeric_cells: dbStatus.numeric_cells || 0,
            empty_cells: dbStatus.empty_cells || 0,
            total_cells: dbStatus.total_cells || 0,
            pct: dbStatus.numeric_pct || 0
        } : (dbStatus ? {
            status: dbStatus.status || (dbStatus.is_saved ? 'lengkap' : 'belum'),
            numeric_cells: dbStatus.numeric_cells || 0,
            empty_cells: dbStatus.empty_cells || 0,
            total_cells: dbStatus.total_cells || 0,
            pct: dbStatus.numeric_pct || (dbStatus.is_saved ? 100 : 0)
        } : { status: 'belum', numeric_cells: 0, empty_cells: 0, total_cells: 0, pct: 0 });

        const verStatus = dbStatus ? dbStatus.verification_status : null;

        updateMonStatusDom(numStatus, verStatus, dbStatus ? dbStatus.updated_at : null, year);

        // 5. Update Link Tombol Aksi (Buka Tabel & Edit Tabel)
        const btnView = document.getElementById('monBtnViewTable');
        const btnEdit = document.getElementById('monBtnEditTable');
        if (btnView && tableCode) {
            btnView.href = `/tabel?code=${encodeURIComponent(tableCode)}&opd=${encodeURIComponent(agencyCode)}&year=${encodeURIComponent(year)}&type=${encodeURIComponent(window.monTabType)}`;
        }
        if (btnEdit && tableCode) {
            btnEdit.href = `/tabel-opd?code=${encodeURIComponent(tableCode)}&opd=${encodeURIComponent(agencyCode)}&year=${encodeURIComponent(year)}&type=${encodeURIComponent(window.monTabType)}`;
        }

        // 6. Fetch live real-time status dari Database per tahun
        fetchLiveTableStatus(agencyCode, tableCode, year);
    }

    let monFetchTimer = null;
    function fetchLiveTableStatus(agencyCode, tableCode, year) {
        if (!tableCode) return;
        clearTimeout(monFetchTimer);
        monFetchTimer = setTimeout(() => {
            const apiUrl = `/api/tabel-opd/data?code=${encodeURIComponent(tableCode)}&opd=${encodeURIComponent(agencyCode)}&year=${encodeURIComponent(year)}`;
            fetch(apiUrl)
                .then(res => res.json())
                .then(data => {
                    if (data && data.success && data.metadata) {
                        const m = data.metadata;
                        const numStatus = data.numeric_status || {
                            status: (m.is_saved == 1 || m.is_saved === true) ? 'lengkap' : 'belum',
                            numeric_cells: 0,
                            empty_cells: 0,
                            total_cells: 0,
                            pct: (m.is_saved == 1 || m.is_saved === true) ? 100 : 0
                        };

                        updateMonStatusDom(numStatus, m.verification_status, m.updated_at, year);
                        
                        // Perbarui judul resmi jika ada dari database
                        if (m.title_id) {
                            const titleIdEl = document.getElementById('monAttrTitleId');
                            if (titleIdEl) titleIdEl.innerText = m.title_id;
                        }
                        if (m.title_en) {
                            const titleEnEl = document.getElementById('monAttrTitleEn');
                            if (titleEnEl) titleEnEl.innerText = m.title_en;
                        }
                        if (m.source) {
                            const sourceEl = document.getElementById('monAttrSource');
                            if (sourceEl) sourceEl.innerText = m.source.replace(/<[^>]*>?/gm, '');
                        }
                    } else {
                        updateMonStatusDom({ status: 'belum', numeric_cells: 0, empty_cells: 0, total_cells: 0, pct: 0 }, null, null, year);
                    }
                })
                .catch(err => {
                    console.warn('Gagal memuat status live tabel:', err);
                });
        }, 120);
    }

    function updateMonStatusDom(numStatus, verStatus, updatedAt, year) {
        const pillContainer = document.getElementById('monTableStatusPillContainer');
        const detailsContainer = document.getElementById('monAttrProgressDetails');
        const lastUpdateEl = document.getElementById('monAttrLastUpdate');

        let statusBadgeHtml = '';
        let detailsHtml = '';

        const status = (numStatus && numStatus.status) ? numStatus.status : 'belum';
        const numCells = numStatus ? (numStatus.numeric_cells || 0) : 0;
        const empCells = numStatus ? (numStatus.empty_cells || 0) : 0;
        const totCells = numStatus ? (numStatus.total_cells || 0) : 0;
        const pct = numStatus ? (numStatus.pct || 0) : 0;

        if (status === 'lengkap') {
            statusBadgeHtml = `<span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300 flex items-center space-x-1.5 shadow-2xs"><i class="fa-solid fa-circle-check text-emerald-600"></i><span>Lengkap (Angka Data Terisi Penuh)</span></span>`;
            
            let verBadge = '';
            if (verStatus === 'verified') {
                verBadge = `<span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200"><i class="fa-solid fa-check-double text-emerald-600"></i><span>Validasi BPS Selesai (Di-ACC)</span></span>`;
            } else if (verStatus === 'submitted') {
                verBadge = `<span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200"><i class="fa-solid fa-hourglass-half text-blue-600"></i><span>Menunggu Verifikasi BPS</span></span>`;
            } else if (verStatus === 'revision') {
                verBadge = `<span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-rose-50 text-rose-800 border border-rose-200"><i class="fa-solid fa-wrench text-rose-600"></i><span>Perlu Revisi OPD</span></span>`;
            } else {
                verBadge = `<span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200"><i class="fa-solid fa-file-pen text-amber-600"></i><span>Data Tersimpan (Draf)</span></span>`;
            }

            detailsHtml = `
                ${verBadge}
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    <i class="fa-solid fa-calculator text-emerald-600"></i>
                    <span>100% Angka Terisi (${numCells > 0 ? numCells + ' Sel Data' : 'Semua Sel Terisi'})</span>
                </span>
            `;
        } else if (status === 'proses') {
            statusBadgeHtml = `<span class="px-3 py-1 rounded-full text-xs font-extrabold bg-blue-100 text-blue-900 border border-blue-300 flex items-center space-x-1.5 shadow-2xs"><i class="fa-solid fa-circle-half-stroke text-blue-600"></i><span>Belum Lengkap (${pct}% Angka Terisi)</span></span>`;
            
            detailsHtml = `
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200">
                    <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                    <span>${numCells} Sel Terisi Angka (${empCells} Sel Masih Strip -)</span>
                </span>
                <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-xl text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                    <i class="fa-solid fa-hourglass-start text-amber-600"></i>
                    <span>Tahap Input Data Tahun ${year}</span>
                </span>
            `;
        } else {
            statusBadgeHtml = `<span class="px-3 py-1 rounded-full text-xs font-extrabold bg-slate-100 text-slate-700 border border-slate-300 flex items-center space-x-1.5 shadow-2xs"><i class="fa-solid fa-circle-xmark text-slate-400"></i><span>Belum Berisi Data Angka (0%)</span></span>`;
            
            detailsHtml = `
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                    <i class="fa-solid fa-circle-info text-slate-400"></i>
                    <span>Seluruh sel data masih bertanda strip (-) / kosong untuk Tahun ${year}</span>
                </span>
            `;
        }

        if (pillContainer) pillContainer.innerHTML = statusBadgeHtml;
        if (detailsContainer) detailsContainer.innerHTML = detailsHtml;

        if (lastUpdateEl) {
            if (updatedAt) {
                lastUpdateEl.innerText = `Terakhir diperbarui: ${new Date(updatedAt).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' })} WIB`;
            } else {
                lastUpdateEl.innerText = `Terakhir diperbarui: Belum pernah diperbarui untuk Tahun ${year}`;
            }
        }
    }

    // Inisialisasi awal saat DOM siap
    document.addEventListener('DOMContentLoaded', () => {
        populateMonTableDropdown(window.monSelectedAgency);
    });
</script>

