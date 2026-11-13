/**
 * SiBingka Kota Bukittinggi - Dinas & Catalog Interactions
 * Digunakan untuk: Halaman OPD (isi-opd), Instansi Vertikal (isi-instansi), dan Data Internal BPS (data-bps).
 */

(function (window, document) {
    'use strict';

    // State
    let currentAgencyCode = '01';
    let currentAgencyShort = '';
    let currentAgencyFull = '';
    let currentDriveLink = '';
    let currentTablesList = [];
    let filteredTablesList = [];
    let currentPage = 1;
    let itemsPerPage = 10;

    let selectedTableCode = '';
    let selectedTableTitle = '';
    let selectedTableTitleEn = '';

    function getConfig() {
        return window.DinasCatalogConfig || {
            type: 'opd',
            isAdmin: false,
            saveUrl: '/api/tabel-opd/save-custom-catalog',
            deleteUrl: '/api/tabel-opd/delete-custom-catalog',
            customCatalogUrl: '/api/tabel-opd/custom-catalog',
            tabelOpdUrl: '/tabel-opd',
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        };
    }

    function getCatalog() {
        const type = getConfig().type || 'opd';
        if (type === 'bps') {
            return window.bpsTablesCatalog || {};
        } else if (type === 'instansi') {
            return window.instansiTablesCatalog || {};
        }
        return window.opdTablesCatalog || {};
    }

    function getActiveModalId() {
        const type = getConfig().type || 'opd';
        if (type === 'bps' && document.getElementById('bpsModal')) return 'bpsModal';
        if (type === 'instansi' && document.getElementById('instansiModal')) return 'instansiModal';
        if (document.getElementById('opdModal')) return 'opdModal';
        return 'agencyModal';
    }

    function getActiveModalCardId() {
        const modalId = getActiveModalId();
        return modalId + 'Card';
    }

    // --- Search & Filter Instansi / BPS Cards ---
    window.handleSearchInstansi = function (query) {
        const q = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('.instansi-item, .bps-item');
        let visibleCount = 0;

        items.forEach(item => {
            const searchText = (item.getAttribute('data-search') || item.innerText).toLowerCase();
            if (!q || searchText.includes(q)) {
                item.classList.remove('hidden');
                visibleCount++;
            } else {
                item.classList.add('hidden');
            }
        });

        const emptyState = document.getElementById('instansiEmptyState') || document.getElementById('bpsEmptyState');
        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        const clearBtn = document.getElementById('instansiClearSearch') || document.getElementById('bpsClearSearch');
        if (clearBtn) {
            if (q) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }
    };
    window.handleSearchBps = window.handleSearchInstansi;

    window.clearInstansiSearch = function () {
        const input = document.getElementById('instansiSearchInput') || document.getElementById('bpsSearchInput');
        if (input) {
            input.value = '';
            window.handleSearchInstansi('');
            input.focus();
        }
    };
    window.clearBpsSearch = window.clearInstansiSearch;

    // --- Custom Tables Sync & Storage ---
    function loadCustomTablesForAgency(code) {
        const cfg = getConfig();
        const catalog = getCatalog();
        const cleanCode = code ? code.toString().padStart(2, '0') : '';
        const storageKey = `sibingka_custom_${cfg.type}_tables_${code}`;

        // 1. Gabungkan langsung dari window.serverDbCustomTables jika di-inject oleh backend
        if (typeof window !== 'undefined' && Array.isArray(window.serverDbCustomTables)) {
            if (!catalog[code]) catalog[code] = [];
            window.serverDbCustomTables.forEach(st => {
                const stOpd = st.opd_code ? st.opd_code.toString().padStart(2, '0') : '';
                if (!stOpd || stOpd === cleanCode || stOpd === code) {
                    if (!catalog[code].some(t => t.code.trim() === st.code.trim())) {
                        catalog[code].push({
                            code: st.code,
                            title: st.title,
                            titleEn: st.titleEn || st.title,
                            isCustom: true
                        });
                    }
                }
            });
        }

        try {
            const stored = JSON.parse(localStorage.getItem(storageKey) || '[]');
            if (Array.isArray(stored)) {
                if (!catalog[code]) catalog[code] = [];
                stored.forEach(st => {
                    const exists = catalog[code].some(t => t.code.trim() === st.code.trim());
                    if (!exists) {
                        catalog[code].push({ ...st, isCustom: true });
                    }
                });
            }
        } catch (e) {
            console.warn('Gagal membaca custom tables dari localStorage:', e);
        }

        // Sync dari Database SiBingka
        const fetchUrl = `${cfg.customCatalogUrl}?type=${encodeURIComponent(cfg.type)}&opd=${encodeURIComponent(code)}`;
        fetch(fetchUrl)
            .then(res => res.json())
            .then(data => {
                if (data && data.success && Array.isArray(data.tables)) {
                    let hasNew = false;
                    if (!catalog[code]) catalog[code] = [];
                    data.tables.forEach(dbTable => {
                        const exists = catalog[code].some(t => t.code.trim() === dbTable.code.trim());
                        if (!exists) {
                            catalog[code].push({
                                code: dbTable.code,
                                title: dbTable.title,
                                titleEn: dbTable.titleEn || dbTable.title,
                                isCustom: true
                            });
                            hasNew = true;
                        }
                    });
                    if (hasNew && currentAgencyCode === code) {
                        currentTablesList = catalog[code];
                        filteredTablesList = [...currentTablesList];
                        window.renderTableRows();
                    }
                }
            })
            .catch(() => {});
    }

    // --- Open & Close Agency Table List Modal ---
    window.openAgencyModal = function (code, shortTitle, fullTitle, driveLink = '') {
        currentAgencyCode = code;
        currentAgencyShort = shortTitle;
        currentAgencyFull = fullTitle;
        currentDriveLink = driveLink;
        currentPage = 1;

        loadCustomTablesForAgency(code);

        // Header tags
        const tagEl = document.getElementById('opdHeaderTag') || 
                      document.getElementById('instansiHeaderTag') || 
                      document.getElementById('bpsHeaderTag');
        if (tagEl) {
            tagEl.innerText = `${code}. ${shortTitle}`;
        }

        // Google Drive link
        const driveBtn = document.getElementById('bpsDriveLinkHeader');
        if (driveBtn) {
            driveBtn.classList.add('hidden');
            driveBtn.classList.remove('inline-flex');
        }

        // Catalog load
        const catalog = getCatalog();
        const isBps = getConfig().type === 'bps';
        currentTablesList = catalog[code] || (isBps ? [] : [
            { code: '1.1.1', title: `Tabel Statistik Utama - ${shortTitle}`, titleEn: `Main Statistics Table - ${shortTitle}` }
        ]);
        filteredTablesList = [...currentTablesList];

        // Reset search input
        const searchInput = document.getElementById('tabelSearchInput');
        if (searchInput) searchInput.value = '';

        window.renderTableRows();

        const modalId = getActiveModalId();
        const cardId = getActiveModalCardId();
        const modal = document.getElementById(modalId);
        const card = document.getElementById(cardId);

        if (modal && card) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.style.display = 'flex';
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    };

    // Aliases for seamless backward compatibility
    window.openOpdModal = window.openAgencyModal;
    window.openInstansiModal = window.openAgencyModal;
    window.openBpsModal = window.openAgencyModal;

    window.closeAgencyModal = function () {
        const modalId = getActiveModalId();
        const cardId = getActiveModalCardId();
        const modal = document.getElementById(modalId);
        const card = document.getElementById(cardId);

        if (modal && card) {
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.style.display = 'none';
            }, 250);
        }
    };

    window.closeOpdModal = window.closeAgencyModal;
    window.closeInstansiModal = window.closeAgencyModal;
    window.closeBpsModal = window.closeAgencyModal;

    // --- Search & Render Table Rows ---
    window.handleSearchTable = function (query) {
        const q = (query || '').trim().toLowerCase();
        if (!q) {
            filteredTablesList = [...currentTablesList];
        } else {
            filteredTablesList = currentTablesList.filter(t => 
                t.code.toLowerCase().includes(q) || 
                t.title.toLowerCase().includes(q) ||
                (t.titleEn && t.titleEn.toLowerCase().includes(q))
            );
        }
        currentPage = 1;
        window.renderTableRows();
    };

    window.renderTableRows = function () {
        const tbody = document.getElementById('tabelListTableBody');
        const paginationContainer = document.getElementById('tabelPagination');
        const badgeCount = document.getElementById('tabelBadgeCount');
        if (!tbody) return;

        const total = filteredTablesList.length;
        if (badgeCount) {
            badgeCount.innerText = `${total} tabel ditemukan`;
        }

        if (total === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="py-10 text-center text-slate-400 text-xs">
                        <i class="fa-solid fa-folder-open text-3xl text-slate-300 block mb-2"></i>
                        ${getConfig().type === 'bps' 
                            ? 'Belum ada tabel untuk dataset ini. Silakan klik tombol <strong>"+ Tambah Tabel Baru"</strong> di atas untuk menambahkan tabel secara manual.' 
                            : 'Tidak ada tabel yang sesuai dengan kata kunci pencarian.'}
                    </td>
                </tr>
            `;
            if (paginationContainer) paginationContainer.innerHTML = '';
            return;
        }

        const totalPages = Math.ceil(total / itemsPerPage);
        if (currentPage > totalPages) currentPage = totalPages;
        const startIdx = (currentPage - 1) * itemsPerPage;
        const pageItems = filteredTablesList.slice(startIdx, startIdx + itemsPerPage);
        const isAdmin = getConfig().isAdmin;

        tbody.innerHTML = pageItems.map(tbl => {
            const titleEscaped = tbl.title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
            const titleEnEscaped = tbl.titleEn ? tbl.titleEn.replace(/'/g, "\\'").replace(/"/g, '&quot;') : '';
            return `
            <tr onclick="openYearModal('${tbl.code}', '${titleEscaped}', '${titleEnEscaped}')"
                class="hover:bg-amber-50/60 transition-colors group cursor-pointer">
                <td class="py-3 px-4 align-middle">
                    <span class="inline-flex items-center justify-center bg-[#f98825] group-hover:bg-[#e07212] text-white font-bold text-[11px] px-2.5 py-0.5 rounded-full shadow-2xs transition-colors">
                        ${tbl.code}
                    </span>
                </td>
                <td class="py-3 px-4 align-middle text-slate-700 group-hover:text-slate-900 text-xs font-medium leading-relaxed">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <span class="font-semibold text-slate-800">${tbl.title}</span>
                            ${tbl.titleEn ? `<span class="text-slate-400 mx-1">/</span><span class="italic text-slate-500 font-normal">${tbl.titleEn}</span>` : ''}
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#f98825] transition-transform group-hover:translate-x-1 shrink-0"></i>
                    </div>
                </td>
                <td class="py-3 px-4 align-middle text-center">
                    <div class="inline-flex items-center space-x-1.5">
                        <button onclick="event.stopPropagation(); openYearModal('${tbl.code}', '${titleEscaped}', '${titleEnEscaped}')"
                                title="Input Data Tabel ${tbl.code}"
                                class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-amber-50 group-hover:bg-[#f98825] text-[#f98825] group-hover:text-white border border-amber-200 group-hover:border-transparent font-bold text-[11px] transition-all shadow-2xs cursor-pointer">
                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                            <span>Input Data</span>
                        </button>
                        ${tbl.isCustom && isAdmin ? `
                            <button onclick="event.stopPropagation(); deleteCustomTable('${tbl.code}')"
                                    title="Hapus tabel kustom [${tbl.code}]"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `}).join('');

        // Pagination
        if (paginationContainer) {
            let pagHtml = '';
            pagHtml += `<button onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled class="w-6 h-6 rounded text-slate-300 flex items-center justify-center cursor-not-allowed"' : 'class="w-6 h-6 rounded text-slate-600 hover:bg-slate-100 flex items-center justify-center cursor-pointer"'}><i class="fa-solid fa-chevron-left text-[9px]"></i></button>`;

            for (let p = 1; p <= totalPages; p++) {
                if (p === currentPage) {
                    pagHtml += `<button class="w-6 h-6 rounded bg-[#f98825] text-white font-bold text-xs flex items-center justify-center shadow-2xs">${p}</button>`;
                } else {
                    pagHtml += `<button onclick="goToPage(${p})" class="w-6 h-6 rounded text-slate-600 hover:bg-slate-100 text-xs flex items-center justify-center cursor-pointer">${p}</button>`;
                }
            }

            pagHtml += `<button onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled class="w-6 h-6 rounded text-slate-300 flex items-center justify-center cursor-not-allowed"' : 'class="w-6 h-6 rounded text-slate-600 hover:bg-slate-100 flex items-center justify-center cursor-pointer"'}><i class="fa-solid fa-chevron-right text-[9px]"></i></button>`;

            paginationContainer.innerHTML = pagHtml;
        }
    };

    window.goToPage = function (p) {
        const totalPages = Math.ceil(filteredTablesList.length / itemsPerPage);
        if (p < 1 || p > totalPages) return;
        currentPage = p;
        window.renderTableRows();
    };

    window.changeItemsPerPage = function (val) {
        itemsPerPage = parseInt(val) || 10;
        currentPage = 1;
        window.renderTableRows();
    };

    window.sortTableData = function (field) {
        filteredTablesList.sort((a, b) => {
            if (field === 'code') return a.code.localeCompare(b.code, undefined, { numeric: true });
            return a.title.localeCompare(b.title);
        });
        window.renderTableRows();
    };

    // --- Year Modal Handling ---
    window.populateYearOptions = function () {
        const yearSelect = document.getElementById('selectedYearSelect');
        if (!yearSelect) return;

        const currentYear = new Date().getFullYear();
        const endYear = Math.max(2036, currentYear + 10);

        let html = '<option value="" disabled>Pilih Tahun Data</option>';
        for (let y = endYear; y >= 2020; y--) {
            const is2025 = y === 2025;
            html += `<option value="${y}" ${is2025 ? 'selected' : ''}>Tahun ${y}</option>`;
        }
        yearSelect.innerHTML = html;
    };

    window.openYearModal = function (tableCode, tableTitle, tableTitleEn = '') {
        selectedTableCode = tableCode;
        selectedTableTitle = tableTitle;
        selectedTableTitleEn = tableTitleEn;

        const badge = document.getElementById('selectedTableBadge');
        if (badge) badge.innerText = tableCode;

        const titleEl = document.getElementById('selectedTableTitle');
        if (titleEl) {
            if (tableTitleEn && tableTitleEn.trim() !== '') {
                titleEl.innerHTML = `
                    <span class="font-bold text-slate-900">${tableCode}. ${tableTitle}</span>
                    <span class="text-slate-400 font-normal mx-1">/</span>
                    <span class="italic text-slate-500 font-normal text-xs sm:text-[13px]">${tableTitleEn}</span>
                `;
            } else {
                titleEl.innerText = `${tableCode}. ${tableTitle}`;
            }
        }

        const subtitleEl = document.getElementById('selectedOpdSubtitle');
        if (subtitleEl) {
            subtitleEl.innerText = `${currentAgencyCode}. ${currentAgencyShort}`;
        }

        window.populateYearOptions();

        const yearSelect = document.getElementById('selectedYearSelect');
        if (yearSelect) {
            yearSelect.value = '2025';
        }

        const modal = document.getElementById('yearModal');
        const card = document.getElementById('yearModalCard');

        if (modal && card) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.style.display = 'flex';
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    };

    window.closeYearModal = function () {
        const modal = document.getElementById('yearModal');
        const card = document.getElementById('yearModalCard');

        if (modal && card) {
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.style.display = 'none';
            }, 250);
        }
    };

    window.submitSelectedYear = function () {
        const selectEl = document.getElementById('selectedYearSelect');
        const year = selectEl ? selectEl.value : '';
        if (!year) {
            alert('Silakan pilih tahun terlebih dahulu.');
            return;
        }

        const cfg = getConfig();
        let targetUrl = `${cfg.tabelOpdUrl}?type=${encodeURIComponent(cfg.type)}&opd=${encodeURIComponent(currentAgencyCode)}&code=${encodeURIComponent(selectedTableCode)}&year=${encodeURIComponent(year)}`;
        if (selectedTableTitle) {
            targetUrl += "&title=" + encodeURIComponent(selectedTableTitle);
        }
        if (selectedTableTitleEn) {
            targetUrl += "&title_en=" + encodeURIComponent(selectedTableTitleEn);
        }
        window.location.href = targetUrl;
    };

    // --- Add Custom Table Modal Logic ---
    window.openAddTableModal = function () {
        const selectorDiv = document.getElementById('addTableOpdSelectorContainer');
        if (selectorDiv) selectorDiv.classList.add('hidden');

        const subtitle = document.getElementById('addTableOpdSubtitle');
        if (subtitle) subtitle.innerText = `${currentAgencyCode}. ${currentAgencyShort}`;

        const codeInput = document.getElementById('newTableCode');
        const titleInput = document.getElementById('newTableTitle');
        const titleEnInput = document.getElementById('newTableTitleEn');
        if (codeInput) codeInput.value = '';
        if (titleInput) titleInput.value = '';
        if (titleEnInput) titleEnInput.value = '';

        const modal = document.getElementById('addTableModal');
        const card = document.getElementById('addTableModalCard');

        if (modal && card) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.style.display = 'flex';
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
                if (codeInput) codeInput.focus();
            }, 10);
        }
    };

    window.openAddTableModalGlobal = function () {
        const selectEl = document.getElementById('newTableOpdSelect');
        const selectorDiv = document.getElementById('addTableOpdSelectorContainer');
        if (selectorDiv) selectorDiv.classList.remove('hidden');

        if (currentAgencyCode && selectEl) {
            selectEl.value = currentAgencyCode;
        }

        const subtitle = document.getElementById('addTableOpdSubtitle');
        const selText = (selectEl && selectEl.options[selectEl.selectedIndex]) ? selectEl.options[selectEl.selectedIndex].text : 'Pilih Instansi';
        if (subtitle) subtitle.innerText = selText;

        if (selectEl) {
            selectEl.onchange = function () {
                currentAgencyCode = this.value;
                if (subtitle) subtitle.innerText = this.options[this.selectedIndex].text;
            };
        }

        const codeInput = document.getElementById('newTableCode');
        const titleInput = document.getElementById('newTableTitle');
        const titleEnInput = document.getElementById('newTableTitleEn');
        if (codeInput) codeInput.value = '';
        if (titleInput) titleInput.value = '';
        if (titleEnInput) titleEnInput.value = '';

        const modal = document.getElementById('addTableModal');
        const card = document.getElementById('addTableModalCard');

        if (modal && card) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.style.display = 'flex';
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
                if (codeInput) codeInput.focus();
            }, 10);
        }
    };

    window.closeAddTableModal = function () {
        const modal = document.getElementById('addTableModal');
        const card = document.getElementById('addTableModalCard');

        if (modal && card) {
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.style.display = 'none';
            }, 250);
        }
    };

    window.submitNewTable = function (e) {
        if (e && e.preventDefault) e.preventDefault();

        const selectorDiv = document.getElementById('addTableOpdSelectorContainer');
        const isGlobal = selectorDiv && !selectorDiv.classList.contains('hidden');

        if (isGlobal) {
            const selectEl = document.getElementById('newTableOpdSelect');
            if (selectEl && selectEl.value) {
                currentAgencyCode = selectEl.value;
                const optText = selectEl.options[selectEl.selectedIndex].text;
                const parts = optText.split('. ');
                currentAgencyShort = parts.length > 1 ? parts.slice(1).join('. ') : optText;
            }
        }

        const codeInput = document.getElementById('newTableCode');
        const titleInput = document.getElementById('newTableTitle');
        const titleEnInput = document.getElementById('newTableTitleEn');

        const code = codeInput ? codeInput.value.trim() : '';
        const title = titleInput ? titleInput.value.trim() : '';
        const titleEn = (titleEnInput && titleEnInput.value.trim()) ? titleEnInput.value.trim() : title;

        if (!code || !title) {
            alert('Kode tabel dan Judul tabel wajib diisi!');
            return;
        }

        const catalog = getCatalog();
        if (!catalog[currentAgencyCode]) {
            catalog[currentAgencyCode] = [];
        }

        // Cek duplikasi
        const isDuplicate = catalog[currentAgencyCode].some(t => t.code.trim().toLowerCase() === code.toLowerCase());
        if (isDuplicate) {
            alert(`Tabel dengan kode ${code} sudah ada di instansi ini.`);
            return;
        }

        const newTable = {
            code: code,
            title: title,
            titleEn: titleEn,
            isCustom: true
        };

        catalog[currentAgencyCode].push(newTable);
        currentTablesList = catalog[currentAgencyCode];
        filteredTablesList = [...currentTablesList];

        // Simpan ke localStorage
        const cfg = getConfig();
        const storageKey = `sibingka_custom_${cfg.type}_tables_${currentAgencyCode}`;
        try {
            let stored = JSON.parse(localStorage.getItem(storageKey) || '[]');
            if (!Array.isArray(stored)) stored = [];
            stored.push(newTable);
            localStorage.setItem(storageKey, JSON.stringify(stored));
        } catch (err) {
            console.error('Gagal menyimpan ke localStorage:', err);
        }

        // Simpan ke database via AJAX API
        fetch(cfg.saveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': cfg.csrfToken
            },
            body: JSON.stringify({
                table_code: code,
                opd_code: currentAgencyCode,
                title: title,
                title_en: titleEn,
                type: cfg.type
            })
        }).catch(err => {
            console.error('Gagal menyimpan tabel baru ke database:', err);
        });

        window.closeAddTableModal();

        // Refresh tabel bila modal sedang terbuka
        const activeModal = document.getElementById(getActiveModalId());
        if (activeModal && !activeModal.classList.contains('hidden')) {
            window.renderTableRows();
        }

        if (confirm(`Tabel baru [${code}] "${title}" berhasil ditambahkan!\n\nApakah Anda ingin langsung membuka dan menginput data tabel ini sekarang?`)) {
            window.openYearModal(code, title, titleEn);
        }
    };

    window.deleteCustomTable = function (code) {
        if (!confirm(`Apakah Anda yakin ingin menghapus tabel kustom [${code}]?`)) {
            return;
        }

        const catalog = getCatalog();
        if (catalog[currentAgencyCode]) {
            catalog[currentAgencyCode] = catalog[currentAgencyCode].filter(t => t.code !== code);
            currentTablesList = catalog[currentAgencyCode];
            filteredTablesList = [...currentTablesList];
        }

        const cfg = getConfig();
        const storageKey = `sibingka_custom_${cfg.type}_tables_${currentAgencyCode}`;
        try {
            let stored = JSON.parse(localStorage.getItem(storageKey) || '[]');
            stored = stored.filter(t => t.code !== code);
            localStorage.setItem(storageKey, JSON.stringify(stored));
        } catch (e) {}

        fetch(cfg.deleteUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': cfg.csrfToken
            },
            body: JSON.stringify({
                table_code: code,
                opd_code: currentAgencyCode,
                type: cfg.type
            })
        }).catch(() => {});

        window.renderTableRows();
    };

    // Hotkey & Backdrop listener
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            window.closeYearModal();
            window.closeAgencyModal();
            window.closeAddTableModal();
        }
    });

    document.addEventListener('click', (e) => {
        const modalId = getActiveModalId();
        if (e.target.id === modalId) window.closeAgencyModal();
        if (e.target.id === 'yearModal') window.closeYearModal();
        if (e.target.id === 'addTableModal') window.closeAddTableModal();
    });

})(window, document);
