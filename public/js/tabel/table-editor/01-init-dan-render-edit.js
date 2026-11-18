/** SiBingka | table-editor | 01 init dan render edit.js
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group). */
/**
 * SiBingka Kota Bukittinggi - Table Editor Logic
 * Modul JavaScript untuk editor grid spreadsheet data tabel
 */

// Sinkronisasi variabel global dari window.SiBingkaConfig
const cfg = window.SiBingkaConfig || {};
var serverDbDataStore = cfg.serverDbDataStore || [];
var serverDbMetadata = cfg.serverDbMetadata || null;
var serverDbFallbackMetadata = cfg.serverDbFallbackMetadata || null;
var serverDbCustomTables = cfg.serverDbCustomTables || [];
var csrfToken = cfg.csrfToken || '';
var currentOpdCode = cfg.currentOpdCode || '01';
var currentTableCode = cfg.currentTableCode || '1.1.6';
var currentYear = cfg.currentYear || new Date().getFullYear().toString();
var currentType = cfg.currentType || 'opd';
var currentUserData = cfg.currentUserData || { name: 'Pengguna', role: 'opd', displayName: 'Pengguna' };
var tableSchemas = window.tableSchemas || {};
var isEditMode = true;

// Data dari Database MySQL SiBingka Bukittinggi
        
        
        
        
        

        /**
         * Buat template tabel dengan struktur kolom & rincian baris dari tahun lain,
         * namun hanya nilai angka / data yang dikosongkan (diisi tanda strip '-').
         */
        function initEditorPage() {
            // Bersihkan kelebihan kuota localStorage browser secara otomatis (force purge non-active table HTML)
            cleanupLocalStorageQuota(true);

            // Clean up accidental saves
            try {
                localStorage.removeItem('sibingka_table_html_1.1.6_2026');
                localStorage.removeItem('sibingka_table_html_8.1.2_2026');
                localStorage.removeItem('sibingka_table_html_8.1.2_2027');
                for (let y = 2018; y <= 2035; y++) {
                    const k4214 = `sibingka_table_html_4.2.14_${y}`;
                    const val4214 = localStorage.getItem(k4214);
                    if (val4214 && (val4214.includes('(4)') || val4214.includes('(5)'))) {
                        localStorage.removeItem(k4214);
                        localStorage.removeItem(`sibingka_table_source_4.2.14_${y}`);
                    }
                }
                for (let y = 2015; y <= 2035; y++) {
                    ['5.1.15', '5.1.16', '5.1.17'].forEach(code => {
                        const k = `sibingka_table_html_${code}_${y}`;
                        const val = localStorage.getItem(k);
                        if (val && (val.includes('212,10') || val.includes('105,22'))) {
                            safeSetLocalStorage(k, val.replace(/212,10/g, '8,84').replace(/105,22/g, '4,39'));
                        }
                    });
                    ['5.2.1', '5.2.2'].forEach(code => {
                        const k = `sibingka_table_html_${code}_${y}`;
                        const val = localStorage.getItem(k);
                        if (val && (val.includes('Kulit Manis') || val.includes('Cassiavera') || val.includes('Cengkeh') || val.includes('Pala') || val.includes('Pinang') || val.includes('Tebu') || val.includes('Kakao') || val.includes('Cocoa') || val.includes('(10)') || val.includes('(21)'))) {
                            localStorage.removeItem(k);
                            localStorage.removeItem(`sibingka_table_source_${code}_${y}`);
                            localStorage.removeItem(`sibingka_table_is_saved_${code}_${y}`);
                        }
                    });
                    const k542 = `sibingka_table_html_5.4.2_${y}`;
                    const val542 = localStorage.getItem(k542);
                    if (val542 && (val542.includes('colspan="2"><div>Sewaktu-waktu</div>') || val542.includes('(6)</th>') || !val542.includes('Sometime'))) {
                        safeSetLocalStorage(k542, val542.replace(/<th([^>]*?)colspan=[\'"]?2[\'"]?([^>]*?)>\s*<div>Sewaktu-waktu<\/div>\s*<\/th>/gi, '<th$1$2><div>Sewaktu-waktu</div><div class="italic font-normal text-[11px] sm:text-xs">Sometime</div></th>')
                                                        .replace(/colspan="2"><div>Sewaktu-waktu<\/div>/gi, '><div>Sewaktu-waktu</div><div class="italic font-normal text-[11px] sm:text-xs">Sometime</div>')
                                                        .replace(/<th([^>]*?)>\s*\(6\)\s*<\/th>/gi, '<th$1>(5)</th>'));
                    }
                }
                for (let y = 2015; y <= 2030; y++) {
                    const k = `sibingka_table_html_8.1.3_${y}`;
                    const val = localStorage.getItem(k);
                    if (val && (val.includes('72,40') || val.includes('123,20') || val.includes('74,10') || y <= 2020 || y >= 2026)) {
                        localStorage.removeItem(k);
                    }
                    const k231 = `sibingka_table_html_2.3.1_${y}`;
                    const val231 = localStorage.getItem(k231);
                    if (val231 && (!val231.includes('Pegawai Negeri Sipil') || !val231.includes('PPPK'))) {
                        localStorage.removeItem(k231);
                        localStorage.removeItem(`sibingka_table_source_2.3.1_${y}`);
                        localStorage.removeItem(`sibingka_table_is_saved_2.3.1_${y}`);
                    }
                    const k232 = `sibingka_table_html_2.3.2_${y}`;
                    const val232 = localStorage.getItem(k232);
                    if (val232 && (!val232.includes('Pegawai Negeri Sipil') || !val232.includes('PPPK'))) {
                        localStorage.removeItem(k232);
                        localStorage.removeItem(`sibingka_table_source_2.3.2_${y}`);
                        localStorage.removeItem(`sibingka_table_is_saved_2.3.2_${y}`);
                    }
                    const k233 = `sibingka_table_html_2.3.3_${y}`;
                    const val233 = localStorage.getItem(k233);
                    if (val233 && (!val233.includes('Pangkat') || !val233.includes('Pegawai Negeri Sipil'))) {
                        localStorage.removeItem(k233);
                        localStorage.removeItem(`sibingka_table_source_2.3.3_${y}`);
                        localStorage.removeItem(`sibingka_table_is_saved_2.3.3_${y}`);
                    }
                    const tid311 = localStorage.getItem(`sibingka_table_title_id_3.1.1_${y}`);
                    if (tid311 && !tid311.includes('Rasio Jenis Kelamin')) {
                        localStorage.removeItem(`sibingka_table_title_id_3.1.1_${y}`);
                        localStorage.removeItem(`sibingka_table_title_en_3.1.1_${y}`);
                    }
                }

                // Cleanup cache tahun ajaran dan title generik
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (!k) continue;

                    // 1. Bersihkan data Perpustakaan yang salah masuk ke tabel 4.3.5 (Damkar)
                    if (k.includes('4.3.5')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('Perpustakaan') || val.includes('Library') || val.includes('Koleksi')) {
                            keysToRemove.push(k);
                            continue;
                        }
                    }

                    // 2. Bersihkan cache tahun ajaran acak / korup pada tabel pendidikan 4.1.x
                    if (k.startsWith('sibingka_table_html_4.1.')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('2023/2026') || val.includes('2026/2025') || val.includes('2023/2025')) {
                            keysToRemove.push(k);
                            continue;
                        }
                    }

                    if (k.startsWith('sibingka_table_html_')) {
                        const val = localStorage.getItem(k);
                        if (val && val.includes('sm:text-xs">20')) {
                            safeSetLocalStorage(k, cleanHtmlYearRanges(val));
                        }
                    }
                    if (k.startsWith('sibingka_table_title_en_')) {
                        const val = localStorage.getItem(k);
                        if (val && (val.trim().toLowerCase() === 'table' || val.trim().toLowerCase() === 'tabel')) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k.startsWith('sibingka_table_title_id_')) {
                        const val = localStorage.getItem(k);
                        if (val && (/2023\/20\d{2}/.test(val) || /2024\/20\d{2}/.test(val))) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k && k.includes('2.2.2')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('Kolom 6') || val.includes('kolom 6')) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k && (k.includes('8.1.7') || k.includes('8.1.9'))) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('-2') || val.includes('-3') || val.includes('...')) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k && k.includes('8.1.6')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('Kolom 6') || val.includes('kolom 6')) {
                            keysToRemove.push(k);
                        }
                    }
                    if (k && k.includes('4.1.2')) {
                        const val = localStorage.getItem(k) || '';
                        if (val.includes('2023/2024') && val.includes('2025/2026')) {
                            keysToRemove.push(k);
                        }
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
            } catch(e) {}

            const params = new URLSearchParams(window.location.search);
            currentType = params.get('type') || currentType || (cfg && cfg.currentType) || (window.SiBingkaConfig && window.SiBingkaConfig.currentType) || 'opd';
            currentOpdCode = params.get('opd') || currentOpdCode || (cfg && cfg.currentOpdCode) || (window.SiBingkaConfig && window.SiBingkaConfig.currentOpdCode) || '01';
            currentTableCode = params.get('code') || params.get('table') || currentTableCode || (cfg && cfg.currentTableCode) || (window.SiBingkaConfig && window.SiBingkaConfig.currentTableCode) || '1.1.6';
            currentYear = params.get('year') || currentYear || (cfg && cfg.currentYear) || (window.SiBingkaConfig && window.SiBingkaConfig.currentYear) || '2025';
            currentOpdCode = currentOpdCode.toString().padStart(2, '0');

            if (typeof getAgencyInfoForTable === 'function') {
                const autoAgency = getAgencyInfoForTable(currentTableCode, currentOpdCode, currentType);
                if (autoAgency && autoAgency.opdCode && (autoAgency.opdCode !== currentOpdCode || (autoAgency.type && autoAgency.type !== currentType))) {
                    currentOpdCode = autoAgency.opdCode;
                    if (autoAgency.type) currentType = autoAgency.type;
                    if (window.history && window.history.replaceState) {
                        const syncUrl = new URL(window.location.href);
                        syncUrl.searchParams.set('opd', currentOpdCode);
                        if (currentType) syncUrl.searchParams.set('type', currentType);
                        window.history.replaceState({}, '', syncUrl.toString());
                    }
                }
            }
            window.currentOpdCode = currentOpdCode;
            window.currentType = currentType;
            window.currentTableCode = currentTableCode;
            window.currentYear = currentYear;

            renderEditTablePage();
            if (typeof initMobileScrollHint === 'function') initMobileScrollHint();
            if (typeof loadTableComments === 'function') loadTableComments(); else if (typeof fetchTableComments === 'function') fetchTableComments();
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (typeof closeAddTableModal === 'function') closeAddTableModal();
                    if (typeof closeCellCommentDrawer === 'function') closeCellCommentDrawer();
                }
            });
        }

        function addNewRow() {
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            const tbody = tableEl.querySelector('tbody');
            if (!tbody) return;

            // Bersihkan placeholder jika masih berupa pesan kosong
            const emptyTd = tbody.querySelector('td[colspan]');
            if (emptyTd && emptyTd.innerText.includes('Belum ada data')) {
                tbody.innerHTML = '';
            }

            // Pastikan thead memiliki kolom aksi (agar header dan body sinkron)
            if (typeof appendActionColumnToEditor === 'function') {
                appendActionColumnToEditor(tableEl);
            }

            // Cari semua baris data yang valid (bukan pesan kosong, bukan spacer)
            const allRows = Array.from(tbody.querySelectorAll('tr'));
            const validRows = allRows.filter(r => {
                if (r.querySelector('td[colspan]') && r.innerText.includes('Belum ada data')) return false;
                if (r.classList.contains('subtable-spacer-row')) return false;
                return true;
            });

            const tr = document.createElement('tr');
            let html = '';

            if (validRows.length > 0) {
                // Ambil baris acuan terakhir di atasnya
                const refRow = validRows[validRows.length - 1];
                const refTds = Array.from(refRow.querySelectorAll('td'));
                // Ambil sel data (tanpa kolom aksi)
                const refDataTds = refTds.filter(td => !td.classList.contains('col-edit-action'));

                // Loop setiap kolom data sesuai persis dengan baris acuan
                refDataTds.forEach((refTd, colIdx) => {
                    const refInput = refTd.querySelector('.table-edit-input');
                    const tdClass = refTd.className || 'py-2.5 px-4 text-center border border-slate-700';

                    if (colIdx === 0) {
                        // Kolom 0: Kolom Identitas / Baris / Tahun / No
                        if (refInput) {
                            const rawVal = (refInput.value || refInput.getAttribute('value') || '').trim();
                            let nextVal = '';

                            // 1. Cek apakah Tahun 4 digit (misal: 2024, 2025)
                            if (/^(19|20)\d{2}$/.test(rawVal)) {
                                let maxYear = parseInt(rawVal);
                                validRows.forEach(r => {
                                    const inp = r.querySelector('td:first-child .table-edit-input');
                                    if (inp && /^(19|20)\d{2}$/.test(inp.value.trim())) {
                                        const y = parseInt(inp.value.trim());
                                        if (y > maxYear) maxYear = y;
                                    }
                                });
                                nextVal = (maxYear + 1).toString();
                            }
                            // 2. Cek apakah Tahun Ajaran / Rentang (misal: 2024/2025 atau 2024-2025)
                            else if (/^(\d{4})\s*([\/\-])\s*(\d{4})$/.test(rawVal)) {
                                const m = rawVal.match(/^(\d{4})\s*([\/\-])\s*(\d{4})$/);
                                const sep = m[2];
                                const y1 = parseInt(m[1]) + 1;
                                const y2 = parseInt(m[3]) + 1;
                                nextVal = `${y1}${sep}${y2}`;
                            }
                            // 3. Cek apakah Angka Bulat / Nomor Urut (misal: 1, 2, 3)
                            else if (/^\d+$/.test(rawVal)) {
                                let maxNum = parseInt(rawVal);
                                validRows.forEach(r => {
                                    const inp = r.querySelector('td:first-child .table-edit-input');
                                    if (inp && /^\d+$/.test(inp.value.trim())) {
                                        const n = parseInt(inp.value.trim());
                                        if (n > maxNum) maxNum = n;
                                    }
                                });
                                nextVal = (maxNum + 1).toString();
                            }
                            // 4. Cek apakah Nomor Urut dengan Titik (misal: 1., 2.)
                            else if (/^(\d+)(\.\s*)$/.test(rawVal)) {
                                const m = rawVal.match(/^(\d+)(\.\s*)$/);
                                const nextNum = parseInt(m[1]) + 1;
                                nextVal = `${nextNum}.`;
                            }
                            // 5. Cek apakah Teks dengan Nomor di Akhir (misal: Indikator 1, Baris 1)
                            else if (/^(.*?\D)(\d+)$/.test(rawVal)) {
                                const m = rawVal.match(/^(.*?\D)(\d+)$/);
                                const prefix = m[1];
                                const nextNum = parseInt(m[2]) + 1;
                                nextVal = `${prefix}${nextNum}`;
                            }
                            // 6. Label Kategori Bebas (misal: nama instansi/kategori)
                            else {
                                nextVal = '';
                            }

                            const inpStyle = refInput.getAttribute('style') || 'text-align: center; font-weight: 600;';
                            const placeholder = refInput.placeholder || 'Isi data/tahun...';

                            html += `
                                <td class="${tdClass}">
                                    <input type="text" class="table-edit-input" value="${nextVal}" placeholder="${placeholder}" style="${inpStyle}" spellcheck="false" />
                                </td>
                            `;
                        } else {
                            // Kolom pertama teks statis (bukan input), misalnya nomor urut <td>1</td>
                            let maxNo = 0;
                            validRows.forEach(r => {
                                const fTd = r.querySelector('td');
                                if (fTd && !fTd.classList.contains('col-edit-action')) {
                                    const cleanTxt = fTd.innerText.trim().replace(/\.$/, '');
                                    const n = parseInt(cleanTxt);
                                    if (!isNaN(n) && n > maxNo) maxNo = n;
                                }
                            });
                            const nextNo = (maxNo > 0) ? (maxNo + 1) : (validRows.length + 1);
                            html += `<td class="${tdClass} font-bold">${nextNo}</td>`;
                        }
                    } else {
                        // Kolom Data ke-1, 2, dst: Sesuaikan dengan sel acuan di atasnya
                        let inpStyle = 'text-align: center; font-weight: 600;';
                        if (refInput && refInput.getAttribute('style')) {
                            inpStyle = refInput.getAttribute('style');
                        } else if (refTd.classList.contains('text-right')) {
                            inpStyle = 'text-align: right; font-weight: 600;';
                        } else if (refTd.classList.contains('text-left')) {
                            inpStyle = 'text-align: left; font-weight: 600;';
                        }

                        html += `
                            <td class="${tdClass}">
                                <input type="text" class="table-edit-input" value="-" style="${inpStyle}" spellcheck="false" />
                            </td>
                        `;
                    }
                });
            } else {
                // Fallback jika belum ada baris data sama sekali di tbody
                const theadThs = Array.from(tableEl.querySelectorAll('thead tr:last-child th')).filter(th => !th.classList.contains('col-edit-action'));
                const colCount = Math.max(theadThs.length, 2);

                html += `
                    <td class="py-2.5 px-4 font-semibold border border-slate-700 text-center">
                        <input type="text" class="table-edit-input" value="${currentYear || '2026'}" style="text-align: center; font-weight: 600;" spellcheck="false" />
                    </td>
                `;
                for (let c = 1; c < colCount; c++) {
                    html += `
                        <td class="py-2.5 px-4 text-center border border-slate-700">
                            <input type="text" class="table-edit-input" value="-" style="text-align: center; font-weight: 600;" spellcheck="false" />
                        </td>
                    `;
                }
            }

            // Kolom Aksi Hapus di bagian paling kanan
            html += `
                <td class="col-edit-action py-1.5 px-2 text-center border border-slate-700 bg-amber-50/50 align-middle">
                    <button type="button" onclick="deleteSpecificRow(this)" 
                            class="p-1 px-2 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-300 hover:border-rose-600 rounded transition-all text-xs font-semibold flex items-center justify-center gap-1 shadow-2xs mx-auto cursor-pointer" 
                            title="Hapus baris ini dari tabel">
                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                    </button>
                </td>
            `;

            tr.innerHTML = html;

            // Pasang event listener input untuk deteksi perubahan
            tr.querySelectorAll('.table-edit-input').forEach(inp => {
                inp.addEventListener('input', () => {
                    inp.setAttribute('value', inp.value);
                    window._hasUnsavedEdits = true;
                });
            });

            tbody.appendChild(tr);

            // Auto-focus ke input pertama yang ditambahkan
            const firstInput = tr.querySelector('.table-edit-input');
            if (firstInput) {
                firstInput.focus();
                firstInput.select();
            }

            window._hasUnsavedEdits = true;
            if (typeof showToast === 'function') {
                showToast('✨ Baris data baru berhasil ditambahkan! Sesuaikan isian lalu simpan perubahan.');
            }
        }

        function renderEditTablePage() {
            const isInstansi = currentType === 'instansi';
            const isBps = currentType === 'bps';
            const agencyName = getAgencyName(currentOpdCode);

            const breadcrumbCatalogLink = document.getElementById('breadcrumbCatalogLink');
            const breadcrumbCatalogText = document.getElementById('breadcrumbCatalogText');
            if (breadcrumbCatalogLink) {
                breadcrumbCatalogLink.href = isBps ? window.SiBingkaConfig.routes.dataBps : (isInstansi ? window.SiBingkaConfig.routes.isiDataInstansi : window.SiBingkaConfig.routes.isiDataOpd);
            }
            if (breadcrumbCatalogText) {
                breadcrumbCatalogText.innerText = isBps ? 'Data BPS' : (isInstansi ? 'Daftar Instansi' : 'Daftar OPD');
            }

            const bOpdEl = document.getElementById('breadcrumbOpdText');
            if (bOpdEl) bOpdEl.innerText = `${currentOpdCode}. ${agencyName}`;
            const bTableEl = document.getElementById('breadcrumbTableText');
            if (bTableEl) bTableEl.innerText = `Tabel ${currentTableCode}`;

            const subOpdEl = document.getElementById('subHeadingOpd');
            if (subOpdEl) subOpdEl.innerText = `${currentOpdCode}. ${agencyName}`;
            const metaCodeEl = document.getElementById('metaTableCode');
            if (metaCodeEl) metaCodeEl.innerText = currentTableCode;

            // Ambil judul resmi dari katalog master OPD / Instansi
            const catInfo = (typeof getCatalogTableInfo === 'function') 
                ? getCatalogTableInfo(currentTableCode, currentOpdCode, currentType) 
                : null;
            const defaultTitleId = (catInfo && catInfo.title) 
                ? catInfo.title 
                : `Tabel Data Statistik Sektoral ${currentTableCode} di Kota Bukittinggi`;
            const defaultTitleEn = (catInfo && catInfo.titleEn) 
                ? catInfo.titleEn 
                : (catInfo && catInfo.title ? catInfo.title : `Sectoral Statistics Table ${currentTableCode} in Bukittinggi Municipality`);

            const schema = tableSchemas[currentTableCode] || {
                titleId: defaultTitleId,
                titleEn: defaultTitleEn,
                source: `${agencyName} Kota Bukittinggi / <span class="italic text-slate-500">Bukittinggi Municipality</span>`,
                render: function(year) {
                    return `
                        <thead>
                            <tr class="bg-[#f95a00] text-white text-center font-bold">
                                <th class="py-3 px-4 font-bold border border-slate-700">Rincian Indikator / Kategori Data</th>
                                <th class="py-3 px-4 font-bold border border-slate-700">Capaian Nilai Tahun ${year}</th>
                                <th class="py-3 px-4 font-bold border border-slate-700">Satuan</th>
                            </tr>
                            <tr class="bg-[#fed7aa] text-slate-900 text-center font-bold text-xs">
                                <th class="py-1 px-3 border border-slate-700">(1)</th>
                                <th class="py-1 px-3 border border-slate-700">(2)</th>
                                <th class="py-1 px-3 border border-slate-700">(3)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#fef9c3] text-slate-900 font-medium">
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Data Statistik Sektoral Utama 1</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">Unit</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 px-4 font-semibold border border-slate-700">Data Statistik Sektoral Utama 2</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">-</td>
                                <td class="py-2.5 px-4 text-center border border-slate-700">%</td>
                            </tr>
                        </tbody>
                    `;
                }
            };

            // Jika schema title masih generik namun ada info katalog resmi, gunakan judul resmi katalog
            if (catInfo && catInfo.title && (!schema.titleId || schema.titleId.startsWith('Tabel Data Statistik Sektoral') || schema.titleId.includes('Perguruan Tinggi'))) {
                schema.titleId = catInfo.title;
                schema.titleEn = catInfo.titleEn || catInfo.title;
            }

            const yr = parseInt(currentYear) || 2025;
            const p = getTablePeriod(yr, currentTableCode, currentOpdCode);
            const isRangeTable = (schema.isMultiYear || schema.isExcludeSelectedYear || currentTableCode === '8.2.2') && currentTableCode !== '9.3' && currentTableCode !== '9.4';
            let yearLabel = schema.isExcludeSelectedYear ? `${yr - 5}–${yr - 1}` : (isRangeTable ? p.label : `${yr}`);
            document.getElementById('pageMainHeading').innerText = isRangeTable ? `Edit Data Tabel ${currentTableCode} (${yearLabel})` : `Edit Data Tabel ${currentTableCode} Tahun ${currentYear}`;

            // Check for custom titles/source saved from Database, Fallback Structure, or Excel
            let customTitleId = (serverDbMetadata && serverDbMetadata.title_id) ? serverDbMetadata.title_id : (getScopedLocalStorageItem('sibingka_table_title_id') || (serverDbFallbackMetadata && serverDbFallbackMetadata.title_id ? serverDbFallbackMetadata.title_id : null));
            let customTitleEn = (serverDbMetadata && serverDbMetadata.title_en) ? serverDbMetadata.title_en : (getScopedLocalStorageItem('sibingka_table_title_en') || (serverDbFallbackMetadata && serverDbFallbackMetadata.title_en ? serverDbFallbackMetadata.title_en : null));
            let customSource = (serverDbMetadata && serverDbMetadata.source) ? serverDbMetadata.source : (getScopedLocalStorageItem('sibingka_table_source_text') || (serverDbFallbackMetadata && serverDbFallbackMetadata.source ? serverDbFallbackMetadata.source : null));
            let customNote = (serverDbMetadata && serverDbMetadata.note !== undefined && serverDbMetadata.note !== null) ? serverDbMetadata.note : (getScopedLocalStorageItem('sibingka_table_note') || (serverDbFallbackMetadata && serverDbFallbackMetadata.note !== undefined ? serverDbFallbackMetadata.note : null));

            // Isolasi judul & sumber untuk Instansi Vertikal Kampus (05 s.d 23): selalu prioritaskan nama kampus resmi dari katalog
            if (isInstansi && catInfo && catInfo.title) {
                if (!customTitleId || customTitleId.includes('Perguruan Tinggi') || customTitleId.includes('Tabel Data Statistik Sektoral')) {
                    customTitleId = catInfo.title;
                    customTitleEn = catInfo.titleEn || catInfo.title;
                }
                if (!customSource || customSource.includes('Dinas') || customSource.includes('Kecamatan')) {
                    customSource = `${agencyName} / <span class="italic text-slate-500">Bukittinggi Municipality</span>`;
                }
            }

            // Catatan resmi untuk Tabel 4.3.3 (PODES Bencana Alam)
            if (currentTableCode === '4.3.3') {
                const officialNote433 = '<div class="space-y-1"><div><sup>1</sup> Desa pada tabel ini termasuk Unit Permukiman Transmigrasi (UPT) yang masih dibina oleh kementerian terkait dan nagari di Provinsi Sumatera Barat / <span class="italic text-slate-500">Villages in this table are included in Transmigration Settlement Unit which is still fostered by the relevant ministries and the nagari in the Province of Sumatera Barat</span></div><div><sup>2</sup> Kejadian dalam setahun sebelum tahun pencacahan / <span class="italic text-slate-500">Occurred during the last one year before the enumeration years</span></div><div><sup>3</sup> Periode tahun 2024 adalah Januari - April / <span class="italic text-slate-500">2024 Period is January-April</span></div></div>';
                if (!customNote || customNote.length < 50 || !customNote.includes('Transmigrasi')) {
                    customNote = officialNote433;
                    safeSetLocalStorage(`sibingka_table_note_${currentTableCode}_${currentYear}`, officialNote433);
                }
            }

            // Bersihkan jika title hanya berisi kata 'Table' atau 'Tabel'
            if (customTitleEn && (customTitleEn.trim().toLowerCase() === 'table' || customTitleEn.trim().toLowerCase() === 'tabel')) {
                localStorage.removeItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                customTitleEn = null;
            }
            if (customTitleId && (customTitleId.trim().toLowerCase() === 'table' || customTitleId.trim().toLowerCase() === 'tabel' || /2023\/20\d{2}/.test(customTitleId) || /2024\/20\d{2}/.test(customTitleId))) {
                localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                customTitleId = null;
            }

            // Bersihkan custom title jika masih berupa placeholder generik lawas atau terpotong
            if (catInfo && catInfo.title) {
                if (customTitleId && customTitleId.includes('Tabel Data Statistik Sektoral')) {
                    localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && customTitleEn.includes('Sectoral Statistics Table')) {
                    localStorage.removeItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
                if (customTitleId && currentTableCode === '3.1.1' && !customTitleId.includes('Rasio Jenis Kelamin')) {
                    localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && currentTableCode === '3.1.1' && !customTitleEn.includes('Sex Ratio')) {
                    localStorage.removeItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
                // Jika tabel bukan 4.1.1 tetapi customTitleId memuat Taman Kanak-Kanak / (TK), bersihkan cache yang keliru
                if (currentTableCode !== '4.1.1' && customTitleId && (customTitleId.includes('Taman Kanak') || customTitleId.includes('(TK)'))) {
                    localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                    customTitleEn = null;
                }
            }

            // Auto-detect dan perbaiki jika titleId dan titleEn terbalik (English di ID, Indonesia di EN)
            // ATAU jika titleId memuat baris ganda (ID & EN tergabung dengan newline)
            function sanitizeBilingualTitles(tId, tEn) {
                if (!tId && !tEn) return { id: tId, en: tEn };
                if (tId && tId.includes('\n')) {
                    const lines = tId.split('\n').map(l => l.trim()).filter(Boolean);
                    if (lines.length >= 2) {
                        tId = lines[0];
                        if (!tEn || tEn.toLowerCase() === 'table' || tEn === lines[1]) {
                            tEn = lines[1];
                        }
                    }
                }
                if (tEn && tEn.includes('\n')) {
                    const lines = tEn.split('\n').map(l => l.trim()).filter(Boolean);
                    if (lines.length >= 2) {
                        tEn = lines[1];
                    }
                }
                const idHasEnglish = /\b(Actual|Number|Length|Population|Government|Expenditures|Revenues|Percentage|District|Kind of)\b/i.test(tId);
                const enHasIndo = /\b(Realisasi|Jumlah|Panjang|Penduduk|Pemerintah|Belanja|Pendapatan|Menurut|Jenis|Kecamatan|Banyaknya)\b/i.test(tEn);
                if (idHasEnglish && enHasIndo) {
                    return { id: tEn, en: tId };
                }
                return { id: tId, en: tEn };
            }

            const cleanTitles = sanitizeBilingualTitles(customTitleId, customTitleEn);
            customTitleId = cleanTitles.id;
            customTitleEn = cleanTitles.en;

            const cleanSchemaTitles = sanitizeBilingualTitles(schema.titleId, schema.titleEn);
            schema.titleId = cleanSchemaTitles.id;
            schema.titleEn = cleanSchemaTitles.en;

            // For Table 8.1.1, 8.1.2, 8.1.3, 8.2.2, and 9.1, ensure title always reflects the exact 5-year range [yr-4, yr]
            if (currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.2.2' || currentTableCode === '9.1' || currentTableCode === '4.2.4' || currentTableCode === '4.2.5' || currentTableCode === '4.2.7' || currentTableCode === '4.2.9' || currentTableCode === '4.2.10' || currentTableCode === '4.2.13' || currentTableCode === '4.2.15' || currentTableCode === '4.2.16') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedRange = `${yrInt - 4}–${yrInt}`;
                if (customTitleId && !customTitleId.includes(expectedRange)) {
                    localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && (!customTitleEn.includes(expectedRange) || customTitleEn.includes('XXX'))) {
                    localStorage.removeItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
            }

            if (currentTableCode === '8.1.6') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedRange = `${yrInt - 6}–${yrInt}`;
                if (customTitleId && !customTitleId.includes(expectedRange)) {
                    localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && !customTitleEn.includes(expectedRange)) {
                    localStorage.removeItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
            }

            // For Table 9.3 and 9.4, ensure title does not contain year range, but single year [yr]
            if (currentTableCode === '9.3' || currentTableCode === '9.4') {
                const yrInt = parseInt(currentYear) || 2025;
                if (customTitleId && (customTitleId.match(/(19|20)\d{2}\s*[–\-]\s*(19|20)\d{2}/) || (currentTableCode === '9.4' && !customTitleId.includes(currentYear)))) {
                    localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && (customTitleEn.match(/(19|20)\d{2}\s*[–\-]\s*(19|20)\d{2}/) || (currentTableCode === '9.4' && !customTitleEn.includes(currentYear)))) {
                    localStorage.removeItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
            }

            // Sanitize customSource if it contains corrupted dumps from Excel
            if (customSource) {
                const sLower = customSource.toLowerCase();
                if (customSource.length > 220 || sLower.includes('catatan') || sLower.includes('tabel ') || sLower.includes('table ') || sLower.includes('negara') || sLower.includes('jumlah') || sLower.includes('rahmat afrisyaf') || sLower.includes('180.17')) {
                    localStorage.removeItem(`sibingka_table_source_text_${currentTableCode}_${currentYear}`);
                    customSource = null;
                }
            }

            // Sanitize customNote if it contains corrupted dumps from Excel
            if (customNote) {
                const nLower = customNote.toLowerCase().trim();
                if (customNote.length > 2000 || /^tabel\s*[\d\.]+/i.test(nLower) || /^table\s*[\d\.]+/i.test(nLower) || nLower.includes('rahmat afrisyaf')) {
                    localStorage.removeItem(`sibingka_table_note_${currentTableCode}_${currentYear}`);
                    customNote = null;
                }
            }

            // Ensure title always contains the appropriate year or year range label
            function formatTitleWithYear(title, defaultTitle, yLabel) {
                // Khusus Tabel Pertanahan 1.1.8 & 1.1.9 (7 tahun) & Perguruan Tinggi 4.1.18 & 4.1.19: Multi-tahun
                if (typeof currentTableCode === 'string' && (currentTableCode === '1.1.8' || currentTableCode === '1.1.9' || currentTableCode === '4.1.18' || currentTableCode === '4.1.19')) {
                    let raw = (title && !title.includes('Perguruan Tinggi') ? title : defaultTitle || title || '').trim();
                    const cleanBase = raw.replace(/([,\s]+)(?:19|20)\d{2}(?:\s*[\/–\-]\s*(?:19|20)\d{2})?.*$/i, '').trim();
                    return `${cleanBase}, ${yLabel}`;
                }

                // Khusus tabel pendidikan 4.1.x: tahun ajaran SiBingka Bukittinggi = Tahun + 1 (misal 2025 -> 2025/2026)
                if (typeof currentTableCode === 'string' && (currentOpdCode === '08' || currentTableCode.startsWith('4.1')) && currentTableCode !== '4.1.2' && currentTableCode !== '4.1.11' && currentTableCode !== '4.1.12' && currentTableCode !== '4.1.13' && currentTableCode !== '4.1.14' && currentTableCode !== '4.1.18' && currentTableCode !== '4.1.19' && currentTableCode !== '4.1.20' && currentTableCode !== '4.1.21' && currentTableCode !== '4.1.22' && currentTableCode !== '4.1.23' && currentTableCode !== '4.1.24') {
                    const yrInt = parseInt(yLabel) || 2025;
                    const acadYr = `${yrInt}/${yrInt + 1}`;
                    let raw = (defaultTitle || title || '').trim();
                    if (raw.trim().toLowerCase() === 'table' || raw.trim().toLowerCase() === 'tabel') {
                        raw = (defaultTitle || '').trim();
                    }
                    // Bersihkan pecahan tahun ajaran atau tahun acak di akhir judul
                    const cleanBase = raw.replace(/([,\s]+)(19|20)\d{2}.*$/i, '').trim();
                    return `${cleanBase}, ${acadYr}`;
                }

                // Khusus Tabel 4.1.12 (BPS Susenas - APM dan APK): multi-tahun 3 tahun [yr-2 s.d yr]
                if (typeof currentTableCode !== 'undefined' && currentTableCode === '4.1.12') {
                    const yrInt = parseInt(currentYear) || 2025;
                    const range = `${yrInt - 2}–${yrInt}`;
                    const raw = (defaultTitle || title || '').trim();
                    const isEn = raw.toLowerCase().includes('participant') || (schema && schema.titleEn && defaultTitle === schema.titleEn);
                    if (isEn) {
                        return `Participant Rates and Gross Participant Rates by Educational Level in Bukittinggi Municipality, ${range}`;
                    } else {
                        return `Angka Partisipasi Murni (APM) dan Angka Partisipasi Kasar (APK) Menurut Jenjang Pendidikan di Kota Bukittinggi, ${range}`;
                    }
                }

                // Khusus Tabel 4.1.20 (Dispora): multi-tahun 4 tahun [yr-3 s.d yr]
                if (currentTableCode === '4.1.20') {
                    const yrInt = parseInt(currentYear) || 2025;
                    const range = `${yrInt - 3}–${yrInt}`;
                    const raw = (defaultTitle || title || '').trim();
                    const isEn = raw.toLowerCase().includes('sport') || (schema && schema.titleEn && defaultTitle === schema.titleEn);
                    if (isEn) {
                        return `Number of Sport Club in Bukittinggi, ${range}`;
                    } else {
                        return `Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi, ${range}`;
                    }
                }

                let t = (title && title.trim()) ? title.trim() : (defaultTitle || '');
                if (!t) return '';

                // Jika title masih memuat baris ganda / newline, gabungkan dengan spasi agar judul tidak terpotong
                if (t.includes('\n')) {
                    const lines = t.split('\n').map(l => l.trim()).filter(Boolean);
                    t = lines.join(' ');
                }

                if (t.includes(yLabel)) return t;

                // 1. Cek pola "Tahun Anggaran" atau "Year" tanpa tahun
                if (/\bTahun\s+Anggaran\b(?!\s+(?:19|20)\d{2})/i.test(t)) {
                    return t.replace(/\b(Tahun\s+Anggaran)\b/i, `$1 ${yLabel}`);
                }
                if (/\bYear\b(?!\s+(?:19|20)\d{2})/i.test(t)) {
                    return t.replace(/\b(Year)\b/i, `$1 ${yLabel}`);
                }

                // 2. Cek jika ada nama bulan sebelum tahun (misal: "Desember 2021" atau "December 2021")
                const monthYearPattern = /\b(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|May|June|July|August|October|December)\s+(19|20)\d{2}\b/i;
                if (monthYearPattern.test(t)) {
                    return t.replace(monthYearPattern, (m, month) => `${month} ${yLabel}`);
                }

                // 2. Cek tahun atau rentang tahun di akhir judul
                const yearPattern = /(,\s*|\s+)(19|20)\d{2}(\s*[–\-]\s*(19|20)\d{2})?\s*$/;
                if (yearPattern.test(t)) {
                    return t.replace(yearPattern, (match, prefix) => `${prefix}${yLabel}`);
                }

                // 3. Cek tahun 4 digit standalone di dalam judul (bukan di dalam format tahun ajaran bertanda /)
                const standaloneYearPattern = /(?<!\/)\b(19|20)\d{2}\b(?!\/)/;
                if (standaloneYearPattern.test(t)) {
                    return t.replace(standaloneYearPattern, yLabel);
                }

                return `${t.replace(/,\s*$/, '')}, ${yLabel}`;
            }

            // Ensure note always contains the appropriate year when it mentions dynamic cut-off dates like "31 Desember [year]"
            function formatNoteWithYear(note, yr) {
                if (!note) return '';
                if (typeof note === 'function') return note(yr);
                let n = String(note);
                return n.replace(/(31\s+Desember\s+)\b(19|20)\d{2}\b/gi, `$1${yr}`)
                        .replace(/(per-?31\s+Desember\s+)\b(19|20)\d{2}\b/gi, `$1${yr}`)
                        .replace(/(per\s+31\s+Desember\s+)\b(19|20)\d{2}\b/gi, `$1${yr}`)
                        .replace(/(December\s+31(?:st)?,?\s*)\b(19|20)\d{2}\b/gi, `$1${yr}`)
                        .replace(/(as of December 31(?:st)?,?\s*)\b(19|20)\d{2}\b/gi, `$1${yr}`);
            }

            document.getElementById('metaTableTitleId').innerText = formatTitleWithYear(customTitleId, schema.titleId, yearLabel);
            document.getElementById('metaTableTitleEn').innerText = formatTitleWithYear(customTitleEn, schema.titleEn, yearLabel);
            const rawSource = customSource ? customSource : schema.source;
            const cleanSourceHtml = (rawSource || '').replace(/^\s*(?:sumber\s*[\/:]\s*source|sumber\s*[\/:]|source\s*[\/:]|sumber|source)\s*:\s*/i, '').trim();
            document.getElementById('tableSourceContent').innerHTML = cleanSourceHtml;

            const noteRowEl = document.getElementById('tableNoteRow');
            const noteContentEl = document.getElementById('tableNoteContent');
            const addNoteWrapper = document.getElementById('btnAddNoteWrapper');
            if (noteRowEl && noteContentEl) {
                const rawNote = customNote !== null ? customNote : (schema.note || '');
                const noteVal = formatNoteWithYear(rawNote, currentYear);
                if (noteVal) {
                    noteContentEl.innerHTML = noteVal;
                    noteRowEl.classList.remove('hidden');
                    if (addNoteWrapper) addNoteWrapper.classList.add('hidden');
                } else {
                    noteRowEl.classList.add('hidden');
                    if (addNoteWrapper) addNoteWrapper.classList.remove('hidden');
                }
            }

            updateYearSwitcher(Boolean(schema.isMultiYear || currentTableCode === '8.2.2'), Boolean(schema.isExcludeSelectedYear));
            updateTableSwitcher();

            const tableEl = document.getElementById('dataDisplayTable');
            
            // Sanity check serverDbMetadata: pastikan metadata server sesuai dengan currentYear
            if (serverDbMetadata && serverDbMetadata.year && serverDbMetadata.year.toString() !== currentYear.toString()) {
                serverDbMetadata = null;
            }

            // Check if user previously saved custom data (prioritas database, kemudian localStorage)
                        // Check if table data was edited in dedicated edit page or generated from Excel
            // Prioritaskan localStorage jika ada status tersimpan lokal (sibingka_table_is_saved)
            const scopedHtmlKey = getStorageKey('sibingka_table_html');
            const scopedSavedKey = getStorageKey('sibingka_table_is_saved');
            const localSavedHtml = localStorage.getItem(scopedHtmlKey);
            const isLocallySaved = (localStorage.getItem(scopedSavedKey) === '1');
            let savedHtml = (serverDbMetadata && serverDbMetadata.table_html && serverDbMetadata.table_html.includes('<tr'))
                ? serverDbMetadata.table_html
                : ((isLocallySaved && localSavedHtml && localSavedHtml.includes('<tr')) ? localSavedHtml : null);
            if (savedHtml) savedHtml = cleanHtmlYearRanges(savedHtml);

            // Sanity check: jika savedHtml dari localStorage rusak atau tidak mengandung struktur <tr> dan <th>, bersihkan
            if (savedHtml && (!savedHtml.includes('<tr') || !savedHtml.includes('<th'))) {
                removeScopedLocalStorageItem('sibingka_table_html');
                removeScopedLocalStorageItem('sibingka_table_is_saved');
                savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
            }

            if (savedHtml && currentTableCode === '2.4.2') {
                savedHtml = savedHtml.replace(/Jenis Pendapatan/gi, 'Jenis Belanja');
                savedHtml = savedHtml.replace(/Kind of Revenues/gi, 'Kind of Expenditures');
            }

            // Self-healing tabel 4.3.3: hilangkan baris Catatan dari tbody dan rapikan nama kecamatan
            if (currentTableCode === '4.3.3' && savedHtml) {
                if (savedHtml.includes('Transmigrasi') || savedHtml.includes('pencacahan') || savedHtml.includes('Catatan')) {
                    const tempTable = document.createElement('table');
                    tempTable.innerHTML = savedHtml;
                    const rowsToRemove = [];
                    tempTable.querySelectorAll('tbody tr').forEach(tr => {
                        const txt = tr.textContent;
                        if (txt.includes('Catatan') || txt.includes('Transmigrasi') || txt.includes('pencacahan') || txt.includes('Periode tahun')) {
                            rowsToRemove.push(tr);
                        }
                    });
                    rowsToRemove.forEach(tr => tr.remove());
                    savedHtml = tempTable.innerHTML;
                    savedHtml = savedHtml.replace(/Aur Birugo Tigo baleh/g, 'Aur Birugo Tigo Baleh');
                    safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                }
            }

            // Self-healing tabel 4.1.11 (PODES Fasilitas Sekolah): pastikan tabel tunggal (bukan 3 sub-tabel Sekolah/Guru/Murid)
            if (currentTableCode === '4.1.11' && savedHtml) {
                if (savedHtml.includes('Guru') || savedHtml.includes('Teachers') || savedHtml.includes('Murid') || savedHtml.includes('Students') || savedHtml.includes('subtable-spacer-row')) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = (typeof tableSchemas !== 'undefined' && tableSchemas['4.1.11']) ? tableSchemas['4.1.11'].render(currentYear) : null;
                    if (savedHtml) {
                        safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    }
                }
            }

            // Self-healing tabel 4.1.12, 4.1.13, 4.1.14 (BPS Susenas): pastikan BUKAN tabel sekolah 3-in-1
            if (['4.1.12', '4.1.13', '4.1.14'].includes(currentTableCode) && savedHtml) {
                if (savedHtml.includes('Guru') || savedHtml.includes('Teachers') || savedHtml.includes('Murid') || savedHtml.includes('Students') || savedHtml.includes('subtable-spacer-row') || savedHtml.includes('Kecamatan')) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = (typeof tableSchemas !== 'undefined' && tableSchemas[currentTableCode]) ? tableSchemas[currentTableCode].render(currentYear) : null;
                    if (savedHtml) {
                        safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    }
                }
            }

            // Self-healing tabel 3.1.3 (Jumlah, Kepadatan, Laju Pertumbuhan Penduduk):
            // Pastikan baris-baris tahun selalu urut dari [yr - 12] s.d. [yr] sesuai rentang tahun di judul
            if (currentTableCode === '3.1.3' && savedHtml) {
                const yrInt = parseInt(currentYear) || 2024;
                const startY = yrInt - 12;
                const tempTable = document.createElement('table');
                tempTable.innerHTML = savedHtml;
                const trs = tempTable.querySelectorAll('tbody tr');
                if (trs.length === 13) {
                    let needsFix = false;
                    trs.forEach((tr, idx) => {
                        const expectedYr = startY + idx;
                        const expectedStr = (expectedYr <= 2019) ? `${expectedYr}*` : `${expectedYr}`;
                        const td = tr.querySelector('td');
                        if (td && td.textContent.trim() !== expectedStr) {
                            needsFix = true;
                            td.textContent = expectedStr;
                        }
                    });
                    if (needsFix) {
                        savedHtml = tempTable.innerHTML;
                        safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                        if (typeof scopedHtmlKey !== 'undefined') {
                            safeSetLocalStorage(scopedHtmlKey, savedHtml);
                        }
                        if (serverDbMetadata) {
                            serverDbMetadata.table_html = savedHtml;
                        }
                    }
                }
            }

            // Validasi savedHtml untuk tabel multi-tahun (8.1.1, 8.1.2, 8.1.3, 8.1.4, 8.1.5, 8.2.2, 2.2.5, 1.1.10, 9.1, 9.3 atau schema.isMultiYear)
            const isMultiYearTable = Boolean(schema && (schema.isMultiYear || schema.isExcludeSelectedYear)) || 
                                     ['8.1.1', '8.1.2', '8.1.3', '8.1.4', '8.1.5', '8.1.6', '8.2.2', '2.2.5', '9.1', '9.3', '2.4.3', '2.4.1', '2.4.2'].includes(currentTableCode);

            if (currentTableCode === '9.3' && savedHtml) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedStartYear = (yrInt - 6).toString();
                const expectedEndYear = yrInt.toString();
                if (!savedHtml.includes(expectedStartYear) || !savedHtml.includes(expectedEndYear)) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Self-healing tabel 1.1.10: bersihkan cache jika tersimpan dengan label multi-tahun 2028–2032
            if (currentTableCode === '1.1.10' && savedHtml && (savedHtml.includes('2028–2032') || savedHtml.includes('2028-2032'))) {
                localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                if (serverDbMetadata) {
                    serverDbMetadata.table_html = null;
                }
                savedHtml = null;
            }

            // Self-healing tabel 11.3: bersihkan cache jika tabel lama belum memiliki colspan="2" pada baris bulan atau rowspan="6"
            if (currentTableCode === '11.3' && savedHtml) {
                if (!savedHtml.includes('colspan="2"') || !savedHtml.includes('rowspan="6"')) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Validasi kesesuaian periode tahun pada savedHtml untuk tabel multi-tahun
            if (savedHtml && (currentTableCode === '1.1.10' || currentTableCode === '8.1.5' || currentTableCode === '8.1.4' || currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '2.2.5' || currentTableCode === '9.1')) {
                const yrInt = parseInt(currentYear) || 2025;
                if (!savedHtml.includes(yrInt.toString())) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            if (isMultiYearTable && savedHtml && currentTableCode !== '9.3') {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const allThs = Array.from(tempDiv.querySelectorAll('thead th'));
                const yrInt = parseInt(currentYear) || 2025;
                const p = getTablePeriod(yrInt, currentTableCode);
                const expectedStartYear = p.start.toString();
                const expectedEndYear = p.end.toString();
                const hasStartYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedStartYear));
                const hasEndYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedEndYear));
                const firstRowTds = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td') : [];
                const minCols = (currentTableCode === '4.1.20') ? 5 : 6;
                const isMissingCells = firstRowTds.length > 0 && firstRowTds.length < minCols;

                const isRowBasedYearTable = ['1.1.8', '4.1.18', '4.1.19', '8.1.4', '8.1.5', '8.1.6', '1.1.10'].includes(currentTableCode);

                if (!serverDbMetadata && !isLocallySaved && (!hasStartYearInHeader || !hasEndYearInHeader || isMissingCells) && !isRowBasedYearTable) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

            // Reset cache jika tabel 1.1.6 rusak / plain text / format terpotong
            if (currentTableCode === '1.1.6' && savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const thCount = tempDiv.querySelectorAll('thead th').length;
                const bodyRows = tempDiv.querySelectorAll('tbody tr');
                const hasTambuo = savedHtml.includes('Batang Tambuo') || savedHtml.includes('Tambuo');
                if (thCount < 4 || bodyRows.length < 2 || !hasTambuo || !savedHtml.includes('<tbody')) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = tableSchemas['1.1.6'].render(currentYear);
                }
            }

            // Reset cache lama jika tabel 8.1.2, 8.1.3, 8.1.4, atau 8.1.5 pernah tersimpan dengan nilai statis dummy
            const tableSource = localStorage.getItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
            const isExcelImport = (tableSource === 'excel');

            if ((currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.1.4' || currentTableCode === '8.1.5') && savedHtml && !isExcelImport) {
                const yrInt = parseInt(currentYear) || 2025;
                const hasAncientDummy = savedHtml.includes('72,40') || savedHtml.includes('123,20') || 
                                       savedHtml.includes('105,20') || savedHtml.includes('112,50') || savedHtml.includes('65,40') ||
                                       savedHtml.includes('Jembatan Permanen') || savedHtml.includes('Trotoar Jalan Utama') || savedHtml.includes('45.280,00') ||
                                       savedHtml.includes('Saluran Drainase Primer') || savedHtml.includes('Saluran Drainase Sekunder') || savedHtml.includes('Gorong-gorong Jalan Kota') ||
                                       savedHtml.includes('32.450,00') || savedHtml.includes('76.820,00') || savedHtml.includes('8.940,00') || savedHtml.includes('118.210,00');
                const isUnenteredYear = (currentTableCode === '8.1.2' && (yrInt <= 2019 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.3' && (yrInt <= 2020 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.4' && (yrInt <= 2020 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.5' && (yrInt <= 2020 || yrInt >= 2027));
                if (hasAncientDummy || isUnenteredYear) {
                    if (!serverDbMetadata || !serverDbMetadata.is_saved) {
                        localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                        savedHtml = null;
                    }
                }
            }

            // Self-healing tabel 2.3.1 & 2.3.2: bersihkan cache jika format tabel tidak memiliki header standar BPS (10 kolom)
            if ((currentTableCode === '2.3.1' || currentTableCode === '2.3.2') && savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const thCount = tempDiv.querySelectorAll('thead th').length;
                const isProper = thCount >= 9 && savedHtml.includes('Pegawai Negeri Sipil');
                if (!isProper) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                }
            }

            // Self-healing tabel 2.3.3: bersihkan cache jika format tabel tidak memiliki header standar BPS atau mengandung data import lama yang tertukar
            if (currentTableCode === '2.3.3' && savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const thCount = tempDiv.querySelectorAll('thead th').length;
                const firstRowTds = tempDiv.querySelectorAll('tbody tr:first-child td');
                const hasCorruptedMismatch = Array.from(firstRowTds).some(td => td.innerText.trim() === '107' || td.innerText.trim() === '1.498');
                const isProper = thCount >= 5 && savedHtml.includes('Pangkat') && !hasCorruptedMismatch;
                if (!isProper) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Self-healing tabel 11.2, 3.1.8, & 3.2.8 (NIB Sektor, Penduduk Wajib KTP, Pencari Kerja)
            if ((currentTableCode === '11.2' || currentTableCode === '3.1.8' || currentTableCode === '3.2.8') && savedHtml) {
                const yrStr = currentYear.toString();
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const jumlahCell = Array.from(tempDiv.querySelectorAll('td')).find(td => td.innerText.trim().startsWith('Jumlah'));
                let isCorruptMulti = false;
                if (jumlahCell) {
                    const rowTds = jumlahCell.parentElement.querySelectorAll('td');
                    if (rowTds.length >= 2) {
                        const topYearText = rowTds[1].innerText.trim();
                        if (topYearText === '-' || topYearText !== yrStr) {
                            isCorruptMulti = true;
                        }
                    }
                }
                const ghostRow = Array.from(tempDiv.querySelectorAll('tbody tr')).find(tr => {
                    const tds = tr.querySelectorAll('td');
                    return tds.length >= 2 && tds[0].innerText.trim() === '-' && tr.nextElementSibling && tr.nextElementSibling.innerText.includes('Jumlah');
                });
                if (ghostRow) isCorruptMulti = true;

                // Cek ghost cell rowspan di baris kecamatan untuk 3.1.8
                const ghostCol318 = tempDiv.querySelector('tbody tr td[rowspan="3"]');
                if (ghostCol318 && ghostCol318.innerText.trim() === '-') {
                    isCorruptMulti = true;
                }

                if (isCorruptMulti) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Self-healing tabel 9.4, 5.1.18 & tabel kecamatan: pastikan Kolom 6 selalu diganti dengan Aur Birugo Tigo Baleh
            if (savedHtml && (savedHtml.includes('Kolom 6') || savedHtml.includes('kolom 6'))) {
                if (currentTableCode === '2.2.2' || savedHtml.includes('Partai') || savedHtml.includes('Pendidikan')) {
                    savedHtml = savedHtml.replace(/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/gi, '<th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>')
                                         .replace(/<th([^>]*)>\s*Kolom\s*6\s*<\/th>/gi, '<th class="py-3 px-4 font-bold border border-slate-700"><div>S2/S3</div></th>')
                                         .replace(/>\s*Kolom\s*6\s*</gi, '>S2/S3<')
                                         .replace(/Kolom\s*6/gi, 'S2/S3');
                    safeSetLocalStorage(scopedHtmlKey, savedHtml);
                    safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                } else if (currentTableCode === '4.2.11' || savedHtml.includes('Golongan Darah') || savedHtml.includes('Donatur Darah')) {
                    savedHtml = savedHtml.replace(/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/gi, '<th class="py-3 px-4 font-bold border border-slate-700"><div>AB</div></th>')
                                         .replace(/Kolom\s*6/gi, 'AB');
                    safeSetLocalStorage(scopedHtmlKey, savedHtml);
                    safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                } else if (['9.4', '5.1.18'].includes(currentTableCode) || savedHtml.includes('Mandiangin') || savedHtml.includes('Guguk Panjang')) {
                    savedHtml = savedHtml.replace(/<th([^>]*)>\s*(?:<div>)?\s*Kolom\s*6\s*(?:<\/div>)?\s*<\/th>/gi, '<th class="py-3 px-4 font-bold border border-slate-700"><div>Aur Birugo Tigo Baleh</div></th>')
                                         .replace(/<th([^>]*)>\s*Kolom\s*6\s*<\/th>/gi, '<th$1>Aur Birugo Tigo Baleh</th>')
                                         .replace(/>\s*Kolom\s*6\s*</gi, '>Aur Birugo Tigo Baleh<');
                    safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                }
            }

            // Self-healing tabel 5.1.16: pastikan thead selalu bilingual (Maize, Peanuts, dll) dan lebar kolom lega
            if (currentTableCode === '5.1.16' && savedHtml) {
                if (!savedHtml.includes('Maize') || !savedHtml.includes('Peanuts')) {
                    const tempTable = document.createElement('table');
                    tempTable.innerHTML = savedHtml;
                    const schemaHtml = tableSchemas['5.1.16'] ? tableSchemas['5.1.16'].render(currentYear) : '';
                    if (schemaHtml) {
                        const tempSchema = document.createElement('table');
                        tempSchema.innerHTML = schemaHtml;
                        const newThead = tempSchema.querySelector('thead');
                        const oldThead = tempTable.querySelector('thead');
                        if (newThead && oldThead) {
                            oldThead.replaceWith(newThead);
                            tempTable.querySelectorAll('tbody td').forEach(td => {
                                if (td.colSpan >= 2) {
                                    td.classList.add('min-w-[200px]');
                                } else {
                                    td.classList.add('min-w-[110px]');
                                }
                            });
                            savedHtml = tempTable.innerHTML;
                            safeSetLocalStorage(scopedHtmlKey, savedHtml);
                            if (serverDbMetadata) {
                                serverDbMetadata.table_html = savedHtml;
                            }
                        }
                    }
                }
            }

            // Self-healing tabel 5.1.19: pastikan urutan tahun selalu urut naik (ascending) dan thead tidak memiliki colspan 2
            if (currentTableCode === '5.1.19' && savedHtml) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedLastPastYear = (yrInt - 1).toString();
                if ((savedHtml.includes('colspan="2"') && savedHtml.includes('Kecamatan')) || !savedHtml.includes(expectedLastPastYear)) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
                }
            }

            // Self-healing tabel 9.1: baris ke-4 adalah Bukittinggi (bukan Jumlah / Total)
            if (currentTableCode === '9.1' && savedHtml && (savedHtml.includes('Jumlah') || savedHtml.includes('Total'))) {
                savedHtml = savedHtml.replace(/Jumlah\s*\/\s*<span[^>]*>Total<\/span>/gi, 'Bukittinggi')
                                     .replace(/Jumlah\s*\/\s*Total/gi, 'Bukittinggi')
                                     .replace(/<td([^>]*)>\s*Jumlah\s*<\/td>/gi, '<td$1>Bukittinggi</td>');
                safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
            }

            // Self-healing tabel 5.2.1 & 5.2.2: pastikan HANYA 4 komoditi resmi (Kelapa Sawit, Kelapa, Karet, Kopi) dengan 9 kolom total (1 s.d 9)
            if ((currentTableCode === '5.2.1' || currentTableCode === '5.2.2') && savedHtml) {
                const hasExtraCrops = savedHtml.includes('Kulit Manis') || savedHtml.includes('Cassiavera') ||
                                      savedHtml.includes('Cengkeh') || savedHtml.includes('Clove') ||
                                      savedHtml.includes('Pala') || savedHtml.includes('Nutmeg') ||
                                      savedHtml.includes('Pinang') || savedHtml.includes('Areca Nut') ||
                                      savedHtml.includes('Tebu') || savedHtml.includes('Sugar Cane') ||
                                      savedHtml.includes('Kakao') || savedHtml.includes('Cocoa') ||
                                      savedHtml.includes('(10)') || savedHtml.includes('(21)');
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const headerThs = tempDiv.querySelectorAll('thead tr:last-child th');
                if (hasExtraCrops || headerThs.length !== 9) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = (tableSchemas[currentTableCode]) ? tableSchemas[currentTableCode].render(currentYear) : null;
                }
            }

            // Self-healing tabel 3.1.6: pastikan merge Laki-laki / Perempuan (rowspan="2") dan hapus kolom kosong (3)
            if (currentTableCode === '3.1.6' && savedHtml) {
                if (savedHtml.includes('>(3)</th>') || savedHtml.includes('<div>-</div>') || !savedHtml.includes('rowspan="2"')) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = (tableSchemas[currentTableCode]) ? tableSchemas[currentTableCode].render(currentYear) : null;
                }
            }

            // Self-healing tabel 5.1.1: pastikan struktur 3 sub-tabel vertikal dengan spacer row dan subheader lengkap
            if (currentTableCode === '5.1.1' && savedHtml) {
                if (!savedHtml.includes('subtable-spacer-row') || 
                    savedHtml.includes('<td>Kecamatan/District</td>') || 
                    savedHtml.includes('<td>Kangkung') || 
                    savedHtml.includes('Indicator Details') ||
                    !savedHtml.includes('(15)') || 
                    !savedHtml.includes('(21)')) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = (tableSchemas[currentTableCode]) ? tableSchemas[currentTableCode].render(currentYear) : null;
                }
            }

            // Auto-repair header tabel 5.4.2 (Petani Ikan Darat: Sewaktu-waktu/Sometime & Kolom (5))
                            // Self-healing tabel 1.1.8 (Kantor Pertanahan): Bersihkan cache lokal jika format lama 3 kolom atau rentang tahun salah
                if (currentTableCode === '1.1.8' && savedHtml) {
                    if (savedHtml.includes('w-[60%]') || !savedHtml.includes('(7)') || !savedHtml.includes(currentYear.toString())) {
                        localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                        localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                        localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    }
                }
            if (currentTableCode === '5.4.2' && savedHtml) {
                if (savedHtml.includes('colspan="2"><div>Sewaktu-waktu</div>') || savedHtml.includes('(6)</th>') || !savedHtml.includes('Sometime')) {
                    savedHtml = savedHtml.replace(/<th([^>]*?)colspan=[\'"]?2[\'"]?([^>]*?)>\s*<div>Sewaktu-waktu<\/div>\s*<\/th>/gi, '<th$1$2><div>Sewaktu-waktu</div><div class="italic font-normal text-[11px] sm:text-xs">Sometime</div></th>')
                                         .replace(/colspan="2"><div>Sewaktu-waktu<\/div>/gi, '><div>Sewaktu-waktu</div><div class="italic font-normal text-[11px] sm:text-xs">Sometime</div>')
                                         .replace(/<th([^>]*?)>\s*\(6\)\s*<\/th>/gi, '<th$1>(5)</th>');
                    safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                }
            }

            // Self-healing tabel 9.11 (Dinas Pertanian - Rata-rata 5 tahun berjalan)
            if (currentTableCode === '9.11' && savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const ratarataCell = Array.from(tempDiv.querySelectorAll('td')).find(td => td.innerText.trim().toLowerCase().includes('rata-rata') || td.innerText.trim().toLowerCase().includes('average'));
                if (ratarataCell) {
                    const yr = parseInt(currentYear) || 2026;
                    let currentRow = ratarataCell.parentElement;
                    let tbody = currentRow.parentElement;
                    let isCorruptYears = false;

                    const histAverages = {
                        2025: ['9.750', '41.500', '256.667', '-', '32.917'],
                        2024: ['6.417', '34.833', '190.833', '-', '32.000'],
                        2023: ['6.083', '31.375', '173.333', '-', '26.833'],
                        2022: ['6.433', '30.125', '166.667', '-', '31.625'],
                        2021: ['5.791', '29.875', '162.083', '53.916', '29.083'],
                        2020: ['5.889', '29.722', '160.000', '60.000', '28.333'],
                        2019: ['4.917', '28.583', '150.000', '60.000', '25.833']
                    };
                    const colCount = 5;

                    if (ratarataCell.getAttribute('rowspan') !== '5') {
                        ratarataCell.setAttribute('rowspan', '5');
                        isCorruptYears = true;
                    }

                    // Kumpulkan baris-baris setelah Rata-rata
                    let subsequentRows = [];
                    let r = currentRow.nextElementSibling;
                    while (r) {
                        subsequentRows.push(r);
                        r = r.nextElementSibling;
                    }

                    while (subsequentRows.length < 4) {
                        const newTr = document.createElement('tr');
                        newTr.className = 'hover:bg-amber-100/60 transition-colors';
                        tbody.appendChild(newTr);
                        subsequentRows.push(newTr);
                        isCorruptYears = true;
                    }

                    for (let i = 0; i < 5; i++) {
                        const expectedY = (yr - i).toString();
                        const known = histAverages[yr - i];
                        const targetRow = (i === 0) ? currentRow : subsequentRows[i - 1];
                        if (!targetRow) break;

                        const tds = targetRow.querySelectorAll('td');
                        const yearTd = (i === 0) ? tds[1] : tds[0];
                        if (yearTd && yearTd.innerText.trim() !== expectedY) {
                            isCorruptYears = true;
                            yearTd.innerText = expectedY;
                        }

                        // Isi nilai historis jika sel masih kosong/strip atau corrupt
                        for (let c = 0; c < colCount; c++) {
                            const valTd = (i === 0) ? tds[2 + c] : tds[1 + c];
                            if (valTd) {
                                const curVal = valTd.innerText.trim();
                                if (known && (curVal === '-' || curVal === '')) {
                                    valTd.innerText = known[c];
                                    isCorruptYears = true;
                                }
                            } else if (i > 0) {
                                const newTd = document.createElement('td');
                                newTd.innerText = known ? known[c] : '-';
                                newTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top text-center align-middle';
                                targetRow.appendChild(newTd);
                                isCorruptYears = true;
                            }
                        }
                    }

                    // Hapus baris siluman berlebih jika > 4 baris setelah Rata-rata
                    if (subsequentRows.length > 4) {
                        for (let k = 4; k < subsequentRows.length; k++) {
                            subsequentRows[k].remove();
                        }
                        isCorruptYears = true;
                    }

                    if (isCorruptYears) {
                        savedHtml = tempDiv.innerHTML;
                        safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                        if (serverDbMetadata) {
                            serverDbMetadata.table_html = savedHtml;
                        }
                    }
                }
            }

            // Self-healing tabel pariwisata 7.3, 7.4, 7.5 (Dinas Pariwisata - Jumlah 5 tahun berjalan)
            if (['7.3', '7.4', '7.5'].includes(currentTableCode) && savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const jumlahCell = Array.from(tempDiv.querySelectorAll('td')).find(td => td.innerText.trim().toLowerCase().includes('jumlah') || td.innerText.trim().toLowerCase().includes('total'));
                if (jumlahCell) {
                    const yr = parseInt(currentYear) || 2026;
                    let currentRow = jumlahCell.parentElement;
                    let tbody = currentRow.parentElement;
                    let isCorruptYears = false;

                    const histTotals = {
                        '7.3': {
                            2025: ['750.821', '17.768.964'],
                            2024: ['604.541', '14.472.272'],
                            2023: ['820.943', '19.536.206'],
                            2022: ['991.632', '24.205.697'],
                            2021: ['618.049', '14.876.991'],
                            2020: ['363.045', '8.746.437'],
                            2019: ['729.705', '10.620.300']
                        },
                        '7.4': {
                            2025: ['175.214', '3.360.118'],
                            2024: ['160.099', '3.085.615'],
                            2023: ['220.525', '3.170.210'],
                            2022: ['236.449', '3.440.474'],
                            2021: ['131.873', '1.860.079']
                        },
                        '7.5': {
                            2025: ['45.094'],
                            2024: ['35.303'],
                            2023: ['19.390'],
                            2022: ['491'],
                            2021: ['17'],
                            2020: ['2.337'],
                            2019: ['32.653']
                        }
                    };
                    const colCount = currentTableCode === '7.5' ? 1 : 2;

                    // Pastikan rowspan Jumlah adalah 5
                    if (jumlahCell.getAttribute('rowspan') !== '5') {
                        jumlahCell.setAttribute('rowspan', '5');
                        isCorruptYears = true;
                    }

                    // Khusus 7.5 bersihkan 1926 pada baris Belanda jika currentYear >= 2026
                    if (currentTableCode === '7.5' && yr >= 2026) {
                        tempDiv.querySelectorAll('tbody tr').forEach(tr => {
                            if (tr.innerText.includes('Belanda') || tr.innerText.includes('Netherland')) {
                                const tds = tr.querySelectorAll('td');
                                if (tds.length >= 2 && tds[tds.length - 1].innerText.trim() === '1926') {
                                    tds[tds.length - 1].innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                                    isCorruptYears = true;
                                }
                            }
                        });
                    }

                    // Kumpulkan baris-baris setelah Jumlah
                    let subsequentRows = [];
                    let r = currentRow.nextElementSibling;
                    while (r) {
                        subsequentRows.push(r);
                        r = r.nextElementSibling;
                    }

                    // Jika jumlah baris setelah Jumlah < 4 (misal tabel 7.4 sebelumnya cuma 3 baris), tambahkan baris ke-4 (tahun ke-5)
                    while (subsequentRows.length < 4) {
                        const newTr = document.createElement('tr');
                        newTr.className = 'hover:bg-amber-100/60 transition-colors';
                        tbody.appendChild(newTr);
                        subsequentRows.push(newTr);
                        isCorruptYears = true;
                    }

                    for (let i = 0; i < 5; i++) {
                        const expectedY = (yr - i).toString();
                        const known = histTotals[currentTableCode] && histTotals[currentTableCode][yr - i];
                        const targetRow = (i === 0) ? currentRow : subsequentRows[i - 1];
                        if (!targetRow) break;

                        const tds = targetRow.querySelectorAll('td');
                        const yearTd = (i === 0) ? tds[1] : tds[0];
                        if (yearTd && yearTd.innerText.trim() !== expectedY) {
                            isCorruptYears = true;
                            yearTd.innerText = expectedY;
                        }

                        // Isi nilai historis jika sel masih kosong/strip atau corrupt
                        for (let c = 0; c < colCount; c++) {
                            const valTd = (i === 0) ? tds[2 + c] : tds[1 + c];
                            if (valTd) {
                                const curVal = valTd.innerText.trim();
                                if (known && (curVal === '-' || curVal === '')) {
                                    valTd.innerText = known[c];
                                    isCorruptYears = true;
                                }
                            } else if (i > 0) {
                                const newTd = document.createElement('td');
                                newTd.innerText = known ? known[c] : '-';
                                newTd.className = 'py-2.5 px-4 border border-slate-700 text-center align-top text-center align-middle';
                                targetRow.appendChild(newTd);
                                isCorruptYears = true;
                            }
                        }
                    }

                    // Hapus baris siluman berlebih jika > 4 baris setelah Jumlah
                    if (subsequentRows.length > 4) {
                        for (let k = 4; k < subsequentRows.length; k++) {
                            subsequentRows[k].remove();
                        }
                        isCorruptYears = true;
                    }

                    if (isCorruptYears) {
                        savedHtml = tempDiv.innerHTML;
                        safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                        if (serverDbMetadata) {
                            serverDbMetadata.table_html = savedHtml;
                        }
                    }
                }
            }

            // Self-healing tabel 5.1.15, 5.1.16, 5.1.17: pulihkan nilai desimal dari serial-hour conversion
            if (savedHtml && (currentTableCode === '5.1.15' || currentTableCode === '5.1.16' || currentTableCode === '5.1.17')) {
                if (savedHtml.includes('212,10') || savedHtml.includes('105,22')) {
                    savedHtml = savedHtml.replace(/212,10/g, '8,84').replace(/105,22/g, '4,39');
                    safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                }
            }

            // Validasi umum: jika baris data memiliki sel lebih sedikit daripada kolom header (tabel terpotong)
            if (savedHtml && !['5.1.15', '5.1.16', '5.1.17', '1.1.6'].includes(currentTableCode)) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                let headerColSpan = 0;
                tempDiv.querySelectorAll('thead tr:last-child th').forEach(th => headerColSpan += (th.colSpan || 1));
                let firstRowColSpan = 0;
                if (tempDiv.querySelector('tbody tr')) {
                    tempDiv.querySelector('tbody tr').querySelectorAll('td').forEach(td => firstRowColSpan += (td.colSpan || 1));
                }
                if (headerColSpan > 0 && firstRowColSpan > 0 && firstRowColSpan < headerColSpan) {
                    savedHtml = null;
                }
            }

            // Sanity check untuk Tabel 8.1.1 & tabel sejenis: Jika sel data numerik berisi teks label baris
            if (savedHtml) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const rows = tempDiv.querySelectorAll('tbody tr');
                let isCorrupt = false;
                rows.forEach(r => {
                    const tds = r.querySelectorAll('td');
                    for (let c = 1; c < tds.length; c++) {
                        const txt = tds[c].innerText.trim();
                        if (txt.includes('Negara / State') || txt.includes('Provinsi / Province') || txt.includes('Kota / Municipality') || txt.includes('Kewenangan')) {
                            isCorrupt = true;
                            break;
                        }
                    }
                });
                if (isCorrupt) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

            // Sanity check: jika savedHtml adalah starter dummy placeholder ("Indikator 1" / "Indicator Details" / "Rincian Indikator" / "Data Statistik Sektoral" / "Belum ada data")
            if (savedHtml && (
                savedHtml.includes('Indicator Details') || 
                savedHtml.includes('Rincian Indikator') || 
                savedHtml.includes('Data Statistik Sektoral') || 
                savedHtml.includes('Capaian Nilai Tahun') || 
                savedHtml.includes('Belum ada data untuk tabel ini')
            ) && currentTableCode !== 'custom') {
                localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                savedHtml = null;
            }

            // Jika tahun ini belum ada data tersimpan, cari struktur tabel dari tahun lain (HANYA untuk tabel non-multi-tahun)
            if (!savedHtml && !isMultiYearTable) {
                let sourceHtml = null;
                let sourceYr = null;

                if (serverDbFallbackMetadata && serverDbFallbackMetadata.table_html && !serverDbFallbackMetadata.table_html.includes('Belum ada data untuk tabel ini') && !serverDbFallbackMetadata.table_html.includes('Indicator Details')) {
                    sourceHtml = serverDbFallbackMetadata.table_html;
                    sourceYr = serverDbFallbackMetadata.year;
                }

                if (!sourceHtml) {
                    const checkYears = [2025, 2024, 2023, 2022, 2021, 2026, 2027, 2028, 2029, 2030, 2020, 2019, 2018];
                    for (let y of checkYears) {
                        if (y.toString() === currentYear.toString()) continue;
                        const localKey = `sibingka_table_html_${currentTableCode}_${y}`;
                        const localHtml = localStorage.getItem(localKey);
                        if (localHtml && !localHtml.includes('Belum ada data untuk tabel ini') && !localHtml.includes('Indicator Details') && !(localHtml.includes('Indikator 1') && localHtml.includes('Rincian Indikator'))) {
                            sourceHtml = localHtml;
                            sourceYr = y;
                            break;
                        }
                    }
                }

                if (sourceHtml && !sourceHtml.includes('Belum ada data untuk tabel ini')) {
                    savedHtml = buildEmptyTemplateFromSource(sourceHtml, currentYear, sourceYr);
                    try {
                        safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                        safeSetLocalStorage(`sibingka_table_source_${currentTableCode}_${currentYear}`, 'template');
                    } catch(e) {}
                }
            }

            if (savedHtml) {
                tableEl.innerHTML = cleanHtmlYearRanges(savedHtml);
            } else {
                tableEl.innerHTML = cleanHtmlYearRanges(schema.render(currentYear));
            }

            cleanGhostColumns(tableEl);
            cleanGhostRows(tableEl);

            // Sinkronisasi rentang tahun aktual dari baris tabel di editor (misal Kedokteran 3 tahun 2022-2024, atau instansi lain)
            if (isRangeTable) {
                const actualP = (typeof getActualTablePeriod === 'function') ? getActualTablePeriod(tableEl, p) : p;
                if (actualP && actualP.label && actualP.label !== yearLabel) {
                    yearLabel = actualP.label;
                    const hHeading = document.getElementById('pageMainHeading');
                    if (hHeading) hHeading.innerText = `Edit Data Tabel ${currentTableCode} (${yearLabel})`;
                    const mTitle = document.getElementById('editorTableTitle');
                    if (mTitle) mTitle.value = formatTitleWithYear(customTitleId, schema.titleId, yearLabel);
                    const mTitleEn = document.getElementById('editorTableTitleEn');
                    if (mTitleEn) mTitleEn.value = formatTitleWithYear(customTitleEn, schema.titleEn, yearLabel);
                    updateYearSwitcher(true, Boolean(schema.isExcludeSelectedYear));
                }
            }

            // Jaminan header 2.2.2: Kolom ke-5 adalah S2/S3 (bukan Kolom 6)
            if (currentTableCode === '2.2.2' || (tableEl && (tableEl.innerText.includes('Partai') || tableEl.innerText.includes('Pendidikan')))) {
                tableEl.querySelectorAll('thead th').forEach(th => {
                    if (/kolom\s*6/i.test(th.innerText.trim())) {
                        th.innerHTML = '<div>S2/S3</div>';
                    }
                });
            }
            if (currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) {
                tableEl.querySelectorAll('thead th').forEach(th => {
                    if (/kolom\s*6/i.test(th.innerText.trim())) {
                        th.innerHTML = '<div>AB</div>';
                    }
                });
            }

            // Atur lebar tabel agar proporsional, panjang, dan tidak sempit
            if (currentTableCode === '5.1.16' || currentTableCode === '5.1.17') {
                tableEl.style.minWidth = '1600px';
                tableEl.classList.add('table-auto');
            } else if (currentTableCode === '5.2.1' || currentTableCode === '5.2.2') {
                tableEl.style.minWidth = '1100px';
                tableEl.classList.add('table-auto');
            } else if (currentTableCode === '5.1.15') {
                tableEl.style.minWidth = '1100px';
                tableEl.classList.add('table-auto');
            } else {
                tableEl.style.minWidth = '';
            }

            // Pastikan semua sel yang berisi tanda strip (-) berada persis di tengah (horizontal & vertikal)
            tableEl.querySelectorAll('tbody td').forEach(td => {
                const txt = td.innerText.trim();
                if (txt === '-' || txt === '–' || txt === '—') {
                    td.classList.remove('text-left', 'text-right', 'align-top', 'align-bottom');
                    td.classList.add('text-center', 'align-middle');
                    td.style.textAlign = 'center';
                    td.style.verticalAlign = 'middle';
                }
            });

            // Pada Tabel 1.1.6 pastikan sel nama sungai dan lebar (rowspan) juga di tengah vertikal, serta kolom No selalu bernomor 1 dan 2
            if (currentTableCode === '1.1.6') {
                tableEl.querySelectorAll('tbody td[rowspan]').forEach(td => {
                    td.classList.remove('align-top', 'align-bottom');
                    td.classList.add('align-middle');
                    td.style.verticalAlign = 'middle';
                });

                // Rapikan kolom No kecamatan restart 1, 2 untuk masing-masing sungai
                const trs = tableEl.querySelectorAll('tbody tr');
                let currentNo = 1;
                trs.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 4) {
                        currentNo = 1;
                        tds[2].innerHTML = '1';
                        tds[2].className = 'py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800';
                        currentNo = 2;
                    } else if (tds.length >= 2) {
                        tds[0].innerHTML = currentNo.toString();
                        tds[0].className = 'py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800';
                        currentNo++;
                    }
                });
            }

            // Khusus Tabel 4.1.2 (Kemenag - RA): 2 Tahun Ajaran Berjalan
            if (currentTableCode === '4.1.2') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedY1 = `${yrInt - 1}/${yrInt}`;
                const expectedY2 = `${yrInt}/${yrInt + 1}`;
                const validAcadYears = [expectedY1, expectedY2];

                const theadThs = tableEl.querySelectorAll('thead th');
                let thAcadIdx = 0;
                theadThs.forEach(th => {
                    if (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(th.innerText)) {
                        const correctYr = validAcadYears[thAcadIdx % 2];
                        thAcadIdx++;
                        th.innerHTML = `<div>${correctYr}</div>`;
                    }
                });
            }

            // Khusus Tabel Dinas 08 / Tabel 4.1.x (Tabel Pendidikan: Sekolah, Guru, Murid)
            const isEducation3in1 = (currentType !== 'bps') && ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.15', '4.1.16', '4.1.17'].includes(currentTableCode);
            if (isEducation3in1) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedY1 = `${yrInt - 2}/${yrInt - 1}`;
                const expectedY2 = `${yrInt - 1}/${yrInt}`;
                const expectedY3 = `${yrInt}/${yrInt + 1}`;
                const validAcadYears = [expectedY1, expectedY2, expectedY3];

                // 1. Enforce urutan tahun ajaran di thead
                const theadThs = tableEl.querySelectorAll('thead th');
                let thAcadIdx = 0;
                theadThs.forEach(th => {
                    if (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(th.innerText)) {
                        const correctYr = validAcadYears[thAcadIdx % 3];
                        thAcadIdx++;
                        th.innerHTML = `<div>${correctYr}</div>`;
                    }
                });

                const trs = tableEl.querySelectorAll('tbody tr');
                trs.forEach(tr => {
                    const text = tr.innerText.trim();
                    const tds = tr.querySelectorAll('td, th');
                    
                    // Cek jika baris adalah baris pemisah / gap antar sub-tabel
                    if (tr.classList.contains('subtable-spacer-row') || (tds.length === 1 && (tds[0].getAttribute('colspan') >= 8 || tds[0].colSpan >= 8))) {
                        tr.className = 'subtable-spacer-row pointer-events-none select-none';
                        tds[0].className = 'h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center';
                        tds[0].innerHTML = '&nbsp;';
                        return;
                    }

                    const firstCellText = (tds[0] ? tds[0].innerText.trim() : '');
                    const isDistrictRow = /^\s*0?\d\./.test(firstCellText) || 
                                          firstCellText.includes('Guguk') || 
                                          firstCellText.includes('Mandiangin') || 
                                          firstCellText.includes('Aur Birugo');
                    const isTotalRow = firstCellText === 'Bukittinggi' || firstCellText.startsWith('Bukittinggi');

                    if (text.includes('Guru') || text.includes('Teachers') || text.includes('Murid') || text.includes('Students') || text.includes('Kangkung') || text.includes('Tomat') || tr.classList.contains('subtable-header-title')) {
                        // Pastikan ada baris pemisah / gap setidaknya 1 spasi sebelum header sub-tabel
                        const prevTr = tr.previousElementSibling;
                        if (prevTr && !prevTr.classList.contains('subtable-spacer-row')) {
                            const spacer = document.createElement('tr');
                            spacer.className = 'subtable-spacer-row pointer-events-none select-none';
                            spacer.innerHTML = '<td colspan="9" class="h-6 sm:h-8 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>';
                            tr.parentNode.insertBefore(spacer, tr);
                        }

                        tr.className = 'bg-[#f95a00] text-white text-center font-bold subtable-header-title';
                        tds.forEach(td => {
                            if (td.classList.contains('bg-slate-200/50') || (td.getAttribute('colspan') >= 2 && td.innerText.trim() === '')) return;
                            td.className = 'py-2.5 px-3 font-bold border border-slate-700 text-center align-middle';
                            if ((td.innerText.includes('Guru') || td.innerText.includes('Murid')) && !td.querySelector('.italic')) {
                                const isGuru = td.innerText.includes('Guru');
                                td.innerHTML = isGuru 
                                    ? '<div>Guru</div><div class="italic font-normal text-[11px] sm:text-xs">Teachers</div>'
                                    : '<div>Murid</div><div class="italic font-normal text-[11px] sm:text-xs">Students</div>';
                            } else if (td.innerText.includes('Kecamatan') && !td.querySelector('.italic')) {
                                td.innerHTML = '<div>Kecamatan</div><div class="italic font-normal text-[11px] sm:text-xs">District</div>';
                            } else if (td.innerText.includes('Jumlah') && !td.querySelector('.italic')) {
                                td.innerHTML = '<div>Jumlah</div><div class="italic font-normal text-[11px] sm:text-xs">Total</div>';
                            }
                        });
                    } else if (text.includes('Negeri') || text.includes('Swasta') || text.includes('Public') || text.includes('Private')) {
                        tr.className = 'bg-[#f95a00] text-white text-center font-bold subtable-header-subtitle';
                        tds.forEach(td => {
                            td.className = 'py-2 px-3 font-bold border border-slate-700 text-center align-middle';
                            if (td.innerText.includes('Negeri') && !td.querySelector('.italic')) {
                                td.innerHTML = '<div>Negeri</div><div class="italic font-normal text-[11px] sm:text-xs">Public</div>';
                            } else if (td.innerText.includes('Swasta') && !td.querySelector('.italic')) {
                                td.innerHTML = '<div>Swasta</div><div class="italic font-normal text-[11px] sm:text-xs">Private</div>';
                            }
                        });
                    } else if (!isDistrictRow && !isTotalRow && (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(text) || (currentTableCode === '5.1.1' && /\b(?:19|20)\d{2}\b/.test(text)) || tr.classList.contains('subtable-header-years')) && tds.length >= 6) {
                        tr.className = 'bg-[#f95a00] text-white text-center font-bold text-xs subtable-header-years';
                        let subAcadIdx = 0;
                        tds.forEach(td => {
                            td.className = 'py-1.5 px-2 font-bold border border-slate-700 text-center align-middle text-xs';
                            if (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(td.innerText)) {
                                const correctYr = validAcadYears[subAcadIdx % 3];
                                subAcadIdx++;
                                td.innerHTML = `<div>${correctYr}</div>`;
                            }
                        });
                    } else if (text.includes('-1') || text.includes('(1)') || tr.classList.contains('subtable-header-numbering') || (tds.length >= 6 && tds[0].innerText.trim() === '(1)')) {
                        tr.className = 'bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering';
                        tds.forEach((td, idx) => {
                            if (!tr.classList.contains('subtable-header-numbering')) {
                                td.className = 'py-1 px-2 border border-slate-700 text-center font-bold text-xs';
                                td.innerText = `(${idx + 1})`;
                            }
                        });
                    } else if (isTotalRow) {
                        tr.className = 'bg-amber-100/70 font-bold border-t-2 border-b-2 border-slate-700 hover:bg-amber-200/60 transition-colors';
                        tds.forEach((td, idx) => {
                            td.classList.add('font-bold');
                            if (idx === 0) td.className = 'py-2.5 px-4 border border-slate-700 text-left font-bold align-middle';
                            else td.className = 'py-2.5 px-3 border border-slate-700 text-center font-bold align-middle';
                        });
                    } else if (isDistrictRow) {
                        tr.className = 'hover:bg-amber-100/60 transition-colors bg-[#fef9c3] text-slate-900 font-medium';
                        tds.forEach((td, idx) => {
                            if (idx === 0) {
                                td.className = 'py-2 px-4 border border-slate-700 text-left font-semibold align-middle';
                            } else {
                                td.className = 'py-2 px-3 border border-slate-700 text-center align-middle';
                            }
                        });
                    }
                });
            }

            // Transform cells to editable grid with orange inputs
            transformToEditableGrid(tableEl);

            if (typeof renderCellCommentBadges === 'function') {
                renderCellCommentBadges();
            }
        }
