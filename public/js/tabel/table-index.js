/**
 * SiBingka Kota Bukittinggi - Table Index Logic
 * Modul JavaScript untuk tampilan utama publikasi tabel
 */

// Sinkronisasi variabel global dari window.SiBingkaConfig
const cfg = window.SiBingkaConfig || {};
var serverDbDataStore = cfg.serverDbDataStore || [];
var serverDbMetadata = cfg.serverDbMetadata || null;
var serverDbFallbackMetadata = cfg.serverDbFallbackMetadata || null;
var csrfToken = cfg.csrfToken || '';
var currentOpdCode = cfg.currentOpdCode || '01';
var currentTableCode = cfg.currentTableCode || '1.1.6';
var currentYear = cfg.currentYear || new Date().getFullYear().toString();
var currentType = cfg.currentType || 'opd';
var currentUserData = cfg.currentUserData || { name: 'Pengguna', role: 'opd', displayName: 'Pengguna' };
var tableSchemas = window.tableSchemas || {};
var isEditMode = false;

// Data dari Database MySQL SiBingka Bukittinggi
        
        
        
        

        /**
         * Buat template tabel dengan struktur kolom & rincian baris dari tahun lain,
         * namun hanya nilai angka / data yang dikosongkan (diisi tanda strip '-').
         */
        function initPage() {
            // Bersihkan kelebihan kuota localStorage browser secara otomatis (force purge non-active table HTML)
            cleanupLocalStorageQuota(true);

            // One-time cleanup: remove accidental saves
            try {
                localStorage.removeItem('sibingka_table_html_1.1.6_2026');
                localStorage.removeItem('sibingka_table_html_8.1.2_2026');
                localStorage.removeItem('sibingka_table_html_8.1.2_2027');
                for (let y = 2015; y <= 2030; y++) {
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
                    const k = `sibingka_table_html_8.1.3_${y}`;
                    const val = localStorage.getItem(k);
                    if (val && (val.includes('72,40') || val.includes('123,20') || val.includes('74,10') || y <= 2020 || y >= 2026)) {
                        localStorage.removeItem(k);
                    }
                    if (y !== 2024 && y !== 2025) {
                        localStorage.removeItem(`sibingka_table_html_8.1.5_${y}`);
                        localStorage.removeItem(`sibingka_table_source_8.1.5_${y}`);
                        localStorage.removeItem(`sibingka_table_is_saved_8.1.5_${y}`);
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
            currentType = params.get('type') || currentType || 'opd';
            currentOpdCode = params.get('opd') || '01';
            currentTableCode = params.get('code') || params.get('table') || '1.1.6';
            currentYear = params.get('year') || '2025';

            // Selaraskan instansi jika tabel saat ini milik instansi/OPD lain
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

            // Check if returned with saved data confirmation
            if (params.get('saved') === '1') {
                showToast('✅ Perubahan data tabel berhasil disimpan ke SiBingka!');
                const cleanUrl = new URL(window.location);
                cleanUrl.searchParams.delete('saved');
                window.history.replaceState({}, '', cleanUrl);
            }


            renderTablePage();
            setupDragAndDrop();
        }

        function renderTablePage() {
            const isInstansi = currentType === 'instansi';
            const isBps = currentType === 'bps';
            const agencyName = getAgencyName(currentOpdCode);

            // Update Header & Breadcrumbs
            const badgeEl = document.getElementById('headerTypeBadge');
            if (badgeEl) badgeEl.innerText = isBps ? 'DATA INTERNAL BPS' : (isInstansi ? 'INSTANSI VERTIKAL' : 'OPD');

            const btnBackEl = document.getElementById('btnBackToDaftar');
            const btnBackTextEl = document.getElementById('btnBackToDaftarText');
            if (btnBackEl) {
                btnBackEl.href = isBps ? window.SiBingkaConfig.routes.dataBps : (isInstansi ? window.SiBingkaConfig.routes.isiDataInstansi : window.SiBingkaConfig.routes.isiDataOpd);
            }
            if (btnBackTextEl) {
                btnBackTextEl.innerText = isBps ? 'Data BPS' : (isInstansi ? 'Daftar Instansi' : 'Daftar OPD');
            }

            const breadcrumbCatalogLink = document.getElementById('breadcrumbCatalogLink');
            const breadcrumbCatalogText = document.getElementById('breadcrumbCatalogText');
            if (breadcrumbCatalogLink) {
                breadcrumbCatalogLink.href = isBps ? window.SiBingkaConfig.routes.dataBps : (isInstansi ? window.SiBingkaConfig.routes.isiDataInstansi : window.SiBingkaConfig.routes.isiDataOpd);
            }
            if (breadcrumbCatalogText) {
                breadcrumbCatalogText.innerText = isBps ? 'Data Internal BPS' : (isInstansi ? 'Isi Data Instansi Vertikal' : 'Isi Data OPD');
            }

            const bOpd = document.getElementById('breadcrumbOpdText');
            if (bOpd) bOpd.innerText = `${currentOpdCode}. ${agencyName}`;
            const bTable = document.getElementById('breadcrumbTableText');
            if (bTable) bTable.innerText = `Tabel ${currentTableCode}`;

            const subOpd = document.getElementById('subHeadingOpd');
            if (subOpd) subOpd.innerText = `${currentOpdCode}. ${agencyName}`;
            const mCode = document.getElementById('metaTableCode');
            if (mCode) mCode.innerText = currentTableCode;

            const printSub = document.getElementById('printOpdSubheading');
            if (printSub) {
                printSub.innerText = `${isInstansi ? 'Instansi' : 'OPD'} Penyelenggara Data: ${currentOpdCode}. ${agencyName}`;
            }

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
                                <td class="py-6 px-4 text-center text-slate-400 italic" colspan="3">
                                    Belum ada data untuk tabel ini. Silakan gunakan tombol Import atau Edit Tabel untuk mengisi data.
                                </td>
                            </tr>
                        </tbody>
                    `;
                }
            };

            // Jika schema title masih generik namun ada info katalog resmi, gunakan judul resmi katalog
            if (catInfo && catInfo.title && (!schema.titleId || schema.titleId.startsWith('Tabel Data Statistik Sektoral'))) {
                schema.titleId = catInfo.title;
                schema.titleEn = catInfo.titleEn || catInfo.title;
            }

            const yr = parseInt(currentYear) || 2025;
            const is822 = (currentTableCode === '8.2.2');
            const p = getTablePeriod(yr, currentTableCode);
            const yearLabel = schema.isExcludeSelectedYear ? `${yr - 5}–${yr - 1}` : ((schema.isMultiYear || is822) ? p.label : `${yr}`);
            document.getElementById('pageMainHeading').innerText = (schema.isMultiYear || schema.isExcludeSelectedYear || is822) ? `Tabel ${currentTableCode} Tahun ${yearLabel}` : `Tabel ${currentTableCode} Tahun ${currentYear}`;
            
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

            // Jika custom title belum ada untuk tahun ini, cari dari tahun lain di localStorage
            if (!customTitleId) {
                const searchYears = [2025, 2024, 2023, 2022, 2021, 2026, 2027, 2028, 2029, 2030, 2020, 2019, 2018];
                for (let y of searchYears) {
                    if (y.toString() === currentYear.toString()) continue;
                    const altTitle = localStorage.getItem(`sibingka_table_title_id_${currentTableCode}_${y}`);
                    if (altTitle && !altTitle.includes('Tabel Data Statistik Sektoral')) {
                        customTitleId = altTitle;
                        if (!customTitleEn) customTitleEn = localStorage.getItem(`sibingka_table_title_en_${currentTableCode}_${y}`);
                        if (!customSource) customSource = localStorage.getItem(`sibingka_table_source_text_${currentTableCode}_${y}`);
                        if (!customNote) customNote = localStorage.getItem(`sibingka_table_note_${currentTableCode}_${y}`);
                        break;
                    }
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

            // Bersihkan custom title jika masih berupa placeholder generik lawas atau keliru menempel judul TK di tabel non-TK
            if (catInfo && catInfo.title) {
                if (customTitleId && customTitleId.includes('Tabel Data Statistik Sektoral')) {
                    localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                if (customTitleEn && customTitleEn.includes('Sectoral Statistics Table')) {
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

            // For Table 8.1.1, 8.1.2, and 8.1.3, ensure title always reflects the exact 5-year range [yr-4, yr]
                        if (currentTableCode === '4.1.20') {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedRange = `${yrInt - 3}–${yrInt}`;
                const customId = localStorage.getItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                if (customId && (customId.includes('Number of Sport') || !customId.includes(expectedRange))) {
                    localStorage.removeItem(`sibingka_table_title_id_${currentTableCode}_${currentYear}`);
                    customTitleId = null;
                }
                const customEn = localStorage.getItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                if (customEn && (!customEn.includes(expectedRange) || customEn.toLowerCase() === 'table')) {
                    localStorage.removeItem(`sibingka_table_title_en_${currentTableCode}_${currentYear}`);
                    customTitleEn = null;
                }
                const cachedHtml = localStorage.getItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                if (cachedHtml && (!cachedHtml.includes(yrInt.toString()) || (cachedHtml.includes('2022') && yrInt >= 2026))) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                }
            }

            if (currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.2.2' || currentTableCode === '4.2.4' || currentTableCode === '4.2.5' || currentTableCode === '4.2.7' || currentTableCode === '4.2.9' || currentTableCode === '4.2.10' || currentTableCode === '4.2.13' || currentTableCode === '4.2.15' || currentTableCode === '4.2.16') {
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
                const nLower = customNote.toLowerCase();
                if (customNote.length > 600 || nLower.includes('tabel ') || nLower.includes('table ') || nLower.includes('negara') || nLower.includes('rahmat afrisyaf')) {
                    localStorage.removeItem(`sibingka_table_note_${currentTableCode}_${currentYear}`);
                    customNote = null;
                }
            }

            // Ensure title always contains the appropriate year or year range label
            function formatTitleWithYear(title, defaultTitle, yLabel) {
                // Khusus tabel pendidikan 4.1.x (OPD 08): tahun ajaran SiBingka Bukittinggi = Tahun + 1 (misal 2025 -> 2025/2026, 2026 -> 2026/2027)
                if (typeof currentTableCode === 'string' && (currentOpdCode === '08' || currentTableCode.startsWith('4.1')) && currentTableCode !== '4.1.20' && currentTableCode !== '4.1.24') {
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

            const mTitleId = document.getElementById('metaTableTitleId');
            if (mTitleId) mTitleId.innerText = formatTitleWithYear(customTitleId, schema.titleId, yearLabel);
            const mTitleEn = document.getElementById('metaTableTitleEn');
            if (mTitleEn) mTitleEn.innerText = formatTitleWithYear(customTitleEn, schema.titleEn, yearLabel);
            const tSource = document.getElementById('tableSourceContent');
            if (tSource) tSource.innerHTML = customSource ? customSource : schema.source;

            const noteRowEl = document.getElementById('tableNoteRow');
            const noteContentEl = document.getElementById('tableNoteContent');
            if (noteRowEl && noteContentEl) {
                const rawNote = customNote !== null ? customNote : (schema.note || '');
                const noteVal = formatNoteWithYear(rawNote, currentYear);
                if (noteVal) {
                    noteContentEl.innerHTML = noteVal;
                    noteRowEl.classList.remove('hidden');
                } else {
                    noteRowEl.classList.add('hidden');
                }
            }

            updateYearSwitcher(Boolean(schema.isMultiYear || currentTableCode === '8.2.2'), Boolean(schema.isExcludeSelectedYear));
            updateTableSwitcher();

            const tableEl = document.getElementById('dataDisplayTable');
            
            // Sanity check serverDbMetadata: pastikan metadata server sesuai dengan currentYear
            if (serverDbMetadata && serverDbMetadata.year && serverDbMetadata.year.toString() !== currentYear.toString()) {
                serverDbMetadata = null;
            }

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

            // Sterilisasi: Bersihkan seluruh tag <input> yang mungkin pernah tersimpan di savedHtml
            if (savedHtml && savedHtml.includes('<input')) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                tempDiv.querySelectorAll('input, .table-edit-input').forEach(inp => {
                    const val = (inp.value !== undefined ? inp.value : inp.getAttribute('value') || '').trim();
                    const parent = inp.closest('td, th') || inp.parentNode;
                    if (parent) {
                        parent.innerHTML = val;
                    }
                });
                savedHtml = tempDiv.innerHTML;
                safeSetLocalStorage(scopedHtmlKey, savedHtml);
            }

            // Sanity check: jika savedHtml rusak atau tidak mengandung struktur <tr> dan <th>, bersihkan
            if (savedHtml && (!savedHtml.includes('<tr') || !savedHtml.includes('<th'))) {
                removeScopedLocalStorageItem('sibingka_table_html');
                removeScopedLocalStorageItem('sibingka_table_is_saved');
                savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
            }

            // Sanity check: jika savedHtml adalah starter dummy placeholder ("Indikator 1" / "Indicator Details" / "Belum ada data")
            if (savedHtml && (savedHtml.includes('Indicator Details') || (savedHtml.includes('Indikator 1') && savedHtml.includes('Rincian Indikator')) || savedHtml.includes('Belum ada data untuk tabel ini'))) {
                removeScopedLocalStorageItem('sibingka_table_html');
                removeScopedLocalStorageItem('sibingka_table_is_saved');
                savedHtml = null;
            }

            if (savedHtml && currentTableCode === '2.4.2') {
                savedHtml = savedHtml.replace(/Jenis Pendapatan/gi, 'Jenis Belanja');
                savedHtml = savedHtml.replace(/Kind of Revenues/gi, 'Kind of Expenditures');
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

            // Self-healing tabel 9.4, 5.1.18 & tabel kecamatan: pastikan Kolom 6 selalu diganti dengan Aur Birugo Tigo Baleh
            if (savedHtml && (savedHtml.includes('Kolom 6') || savedHtml.includes('kolom 6'))) {
                                // Self-healing tabel 1.1.8 (Kantor Pertanahan): Bersihkan cache lokal jika format lama 3 kolom atau rentang tahun salah
                if (currentTableCode === '1.1.8' && savedHtml) {
                    if (savedHtml.includes('w-[60%]') || !savedHtml.includes('(7)') || !savedHtml.includes(currentYear.toString())) {
                        localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                        localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                        localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    }
                }
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

            // Self-healing tabel 9.1: baris ke-4 adalah Bukittinggi (bukan Jumlah / Total)
            if (currentTableCode === '9.1' && savedHtml && (savedHtml.includes('Jumlah') || savedHtml.includes('Total'))) {
                savedHtml = savedHtml.replace(/Jumlah\s*\/\s*<span[^>]*>Total<\/span>/gi, 'Bukittinggi')
                                     .replace(/Jumlah\s*\/\s*Total/gi, 'Bukittinggi')
                                     .replace(/<td([^>]*)>\s*Jumlah\s*<\/td>/gi, '<td$1>Bukittinggi</td>');
                safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
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

            // Auto-repair header tabel 5.4.2 (Petani Ikan Darat: Sewaktu-waktu/Sometime & Kolom (5))
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

            // Validasi savedHtml untuk tabel multi-tahun yang memiliki kolom tahun di header
            const isMultiYearTable = Boolean(schema && (schema.isMultiYear || schema.isExcludeSelectedYear)) || 
                                     ['8.1.1', '8.1.2', '8.1.3', '8.1.4', '8.1.5', '8.1.6', '8.2.2', '2.2.5', '1.1.10', '9.1', '9.3', '2.4.3', '2.4.1', '2.4.2', '5.2.1', '5.2.2'].includes(currentTableCode);

            const isRowBasedYearTable = ['4.1.18', '4.1.19', '8.1.4', '8.1.5', '8.1.6', '1.1.10', '4.2.4', '4.2.5', '4.2.7', '4.2.9', '4.2.10', '4.2.13', '4.2.15', '4.2.16'].includes(currentTableCode);

            if (!serverDbMetadata && !isLocallySaved && isMultiYearTable && savedHtml && !isRowBasedYearTable) {
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const allThs = Array.from(tempDiv.querySelectorAll('thead th'));
                const yrInt = parseInt(currentYear) || 2025;
                const pTable = getTablePeriod(yrInt, currentTableCode);
                const expectedStartYear = pTable.start.toString();
                const expectedEndYear = yrInt.toString();
                const hasStartYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedStartYear));
                const hasEndYearInHeader = allThs.some(th => th.innerText.trim().includes(expectedEndYear));
                const firstRowTds = tempDiv.querySelector('tbody tr') ? tempDiv.querySelector('tbody tr').querySelectorAll('td') : [];
                const minCols = (currentTableCode === '4.1.20') ? 5 : 6;
                const isMissingCells = firstRowTds.length > 0 && firstRowTds.length < minCols;

                if (!hasStartYearInHeader || !hasEndYearInHeader || isMissingCells) {
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
                    savedHtml = (tableSchemas['1.1.6']) ? tableSchemas['1.1.6'].render(currentYear) : null;
                }
            }

            // Self-healing: bersihkan cache jika tabel 1.1.9 memiliki sel dengan rowspan yang merusak baris
            if (currentTableCode === '1.1.9' && savedHtml && savedHtml.includes('rowspan=')) {
                localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                if (serverDbMetadata && serverDbMetadata.table_html && serverDbMetadata.table_html.includes('rowspan=')) {
                    serverDbMetadata.table_html = null;
                }
                savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
            }

            // Reset cache lama jika tabel 8.1.2, 8.1.3, 8.1.4, 8.1.5, atau 1.1.10 pernah tersimpan dengan nilai statis dummy / periode lama
            const tableSource = localStorage.getItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
            const isExcelImport = (tableSource === 'excel');

            // Self-healing tabel 2.2.5: bersihkan cache jika memuat baris Jumlah / Total atau nilai lama
            if (currentTableCode === '2.2.5' && savedHtml && (savedHtml.toLowerCase().includes('jumlah') || savedHtml.toLowerCase().includes('total'))) {
                localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                if (serverDbMetadata) {
                    serverDbMetadata.table_html = null;
                }
                savedHtml = null;
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
                    savedHtml = null;
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


            // Validasi kesesuaian periode tahun pada savedHtml untuk tabel multi-tahun
            if (savedHtml && (currentTableCode === '1.1.10' || currentTableCode === '8.1.5' || currentTableCode === '8.1.4' || currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '2.2.5')) {
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

            if ((currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.1.4' || currentTableCode === '8.1.5') && savedHtml && !isExcelImport) {
                const yrInt = parseInt(currentYear) || 2025;
                const hasAncientDummy = savedHtml.includes('72,40') || savedHtml.includes('123,20') || 
                                       savedHtml.includes('105,20') || savedHtml.includes('112,50') || savedHtml.includes('65,40') ||
                                       savedHtml.includes('Jembatan Permanen') || savedHtml.includes('Trotoar dan Pejalan') || savedHtml.includes('14.850,0') ||
                                       savedHtml.includes('Gorong-Gorong (Culvert)') || savedHtml.includes('Drainase Primer') || savedHtml.includes('Drainase Sekunder') ||
                                       savedHtml.includes('4.210') || savedHtml.includes('18.650') || savedHtml.includes('42.300');
                const isUnenteredYear = (currentTableCode === '8.1.2' && (yrInt <= 2019 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.3' && (yrInt <= 2020 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.4' && (yrInt <= 2020 || yrInt >= 2027)) ||
                                        (currentTableCode === '8.1.5' && (yrInt <= 2020 || yrInt >= 2027));
                if (hasAncientDummy || (isUnenteredYear && (!serverDbMetadata || !serverDbMetadata.table_html))) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = (serverDbMetadata && serverDbMetadata.table_html) ? serverDbMetadata.table_html : null;
                }
            }

            // Self-healing tabel 11.2 (Dinas PMPTSP - NIB menurut Sektor)
            if (currentTableCode === '11.2' && savedHtml) {
                const yrStr = currentYear.toString();
                const tempDiv = document.createElement('table');
                tempDiv.innerHTML = savedHtml;
                const jumlahCell = Array.from(tempDiv.querySelectorAll('td')).find(td => td.innerText.trim() === 'Jumlah');
                let isCorrupt112 = false;
                if (jumlahCell) {
                    const rowTds = jumlahCell.parentElement.querySelectorAll('td');
                    if (rowTds.length >= 2) {
                        const topYearText = rowTds[1].innerText.trim();
                        if (topYearText === '-' || topYearText !== yrStr) {
                            isCorrupt112 = true;
                        }
                    }
                }
                const ghostRow = Array.from(tempDiv.querySelectorAll('tbody tr')).find(tr => {
                    const tds = tr.querySelectorAll('td');
                    return tds.length >= 2 && tds[0].innerText.trim() === '-' && tr.nextElementSibling && tr.nextElementSibling.innerText.includes('Jumlah');
                });
                if (ghostRow) isCorrupt112 = true;

                if (isCorrupt112) {
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = null;
                    }
                    savedHtml = null;
                }
            }

            // Self-healing tabel 4.1.2 (Kemenag - RA): 2 tahun ajaran berjalan
            if (currentTableCode === '4.1.2' && savedHtml) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedY1 = `${yrInt - 1}/${yrInt}`;
                const expectedY2 = `${yrInt}/${yrInt + 1}`;
                if (/\b\d{4}\s*\/\s*\d{4}\b/.test(savedHtml)) {
                    let scIdx = 0;
                    savedHtml = savedHtml.replace(/\b\d{4}\s*\/\s*\d{4}\b/g, () => {
                        const col = scIdx % 2;
                        scIdx++;
                        return col === 0 ? expectedY1 : expectedY2;
                    });
                    safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                    safeSetLocalStorage(scopedHtmlKey, savedHtml);
                    if (serverDbMetadata) {
                        serverDbMetadata.table_html = savedHtml;
                    }
                }
            }

            // Self-healing tabel sekolah (Dinas Pendidikan 4.1.1, 4.1.3 s.d. 4.1.17): pastikan thead selalu urut [yr-2/yr-1, yr-1/yr, yr/yr+1]
            const schoolEducationCodes = ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'];
            if (schoolEducationCodes.includes(currentTableCode) && savedHtml) {
                const yrInt = parseInt(currentYear) || 2025;
                const expectedY1 = `${yrInt - 2}/${yrInt - 1}`;
                const expectedY2 = `${yrInt - 1}/${yrInt}`;
                const expectedY3 = `${yrInt}/${yrInt + 1}`;
                const hasCorruptYears = savedHtml.includes('2023/2026') || savedHtml.includes('2026/2025') || savedHtml.includes('2023/2025');
                const hasExpectedLatest = savedHtml.includes(expectedY3);

                if (hasCorruptYears || !hasExpectedLatest) {
                    if (/\b\d{4}\s*\/\s*\d{4}\b/.test(savedHtml)) {
                        let scIdx = 0;
                        savedHtml = savedHtml.replace(/\b\d{4}\s*\/\s*\d{4}\b/g, () => {
                            const col = scIdx % 3;
                            scIdx++;
                            if (col === 0) return expectedY1;
                            if (col === 1) return expectedY2;
                            return expectedY3;
                        });
                        safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
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
                    localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }

            // Sanity check untuk Tabel 8.1.1: Jika sel data (selain kolom 0) berisi nama baris/kategori
            // (seperti "1. Negara" atau "2. Provinsi" atau "3. Kota"), berarti HTML korup akibat salah geser kolom
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
                    localStorage.removeItem(`sibingka_table_source_${currentTableCode}_${currentYear}`);
                    localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
                    savedHtml = null;
                }
            }
            // Cek apakah data tersedia di database atau custom HTML
            const hasDbSaved = Boolean(serverDbMetadata && serverDbMetadata.is_saved);
            const isOfficialYear = ((currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3' || currentTableCode === '8.1.4' || currentTableCode === '8.1.5') && (currentYear.toString() === '2021' || currentYear.toString() === '2022' || currentYear.toString() === '2023' || currentYear.toString() === '2024' || currentYear.toString() === '2025' || currentYear.toString() === '2026'));
            const hasCustomData = (savedHtml !== null && savedHtml !== '');
            const hasData = isOfficialYear || hasDbSaved || hasCustomData;

            let isInheritedTemplate = false;
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
                    isInheritedTemplate = true;
                    try {
                        safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, savedHtml);
                        safeSetLocalStorage(`sibingka_table_source_${currentTableCode}_${currentYear}`, 'template');
                    } catch(e) {}
                }
            }

            if (savedHtml) {
                tableEl.innerHTML = cleanHtmlYearRanges(savedHtml);
            } else if (tableEl.innerHTML.trim().length > 50 && tableEl.querySelector('tr')) {
                // Pertahankan HTML yang sudah dirender langsung oleh Blade dari server
            } else {
                tableEl.innerHTML = cleanHtmlYearRanges(schema.render(currentYear));
            }

            // Jaminan Keamanan: Halaman utama (index.blade.php) adalah tampilan publikasi 100% read-only.
            // Konversi seluruh elemen <input> yang ada di dalam tabel menjadi teks statis murni.
            tableEl.querySelectorAll('input, .table-edit-input').forEach(inp => {
                if (inp.type === 'file' || inp.type === 'hidden') return;
                const val = (inp.value !== undefined ? inp.value : inp.getAttribute('value') || '').trim();
                const parent = inp.closest('td, th') || inp.parentNode;
                if (parent) {
                    parent.innerHTML = val;
                }
            });

            cleanGhostColumns(tableEl);
            cleanGhostRows(tableEl);

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
            // Dan deteksi otomatis format angka ribuan dengan titik pemisah untuk tabel keuangan (OPD 05 / Tabel 2.4.x)
            const isFinancialTable = (currentOpdCode === '05' || currentTableCode.startsWith('2.4') || currentTableCode.startsWith('2.4.'));

            tableEl.querySelectorAll('tbody tr').forEach(tr => {
                const tds = tr.querySelectorAll('td');
                const isTotalRow = tr.classList.contains('font-bold') || tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total');

                tds.forEach((td, idx) => {
                    const txt = td.innerText.trim();
                    if (txt === '-' || txt === '–' || txt === '—') {
                        td.classList.remove('text-left', 'text-right', 'align-top', 'align-bottom');
                        td.classList.add('text-center', 'align-middle');
                        td.style.textAlign = 'center';
                        td.style.verticalAlign = 'middle';
                        return;
                    }

                    // Format angka ribuan dengan titik pemisah (tanpa Rp) untuk tabel keuangan OPD 05
                    if (idx > 0 && isFinancialTable) {
                        const formatted = formatRupiahNumber(txt);
                        if (formatted !== txt) {
                            td.innerText = formatted;
                        }
                        if (formatted !== '0' && formatted !== '-') {
                            td.classList.remove('text-left', 'text-center');
                            td.classList.add('text-right');
                            td.style.textAlign = 'right';
                            if (isTotalRow) {
                                td.classList.add('font-extrabold');
                            } else {
                                td.classList.add('font-semibold');
                            }
                        } else if (formatted === '0') {
                            td.classList.add('text-center');
                            td.style.textAlign = 'center';
                        }
                    } else if (idx > 0 && /^\d{4,}$/.test(txt.replace(/[.,\s]/g, '')) && !/^(19|20)\d{2}$/.test(txt)) {
                        const formatted = formatRupiahNumber(txt);
                        if (formatted !== txt) {
                            td.innerText = formatted;
                        }
                    }
                });
            });

            // Pada Tabel 1.1.6 pastikan sel nama sungai dan lebar (rowspan) juga di tengah vertikal, serta kolom No selalu bernomor 1 dan 2
            if (currentTableCode === '1.1.6') {
                tableEl.querySelectorAll('tbody td[rowspan]').forEach(td => {
                    td.classList.remove('align-top', 'align-bottom');
                    td.classList.add('align-middle');
                    td.style.verticalAlign = 'middle';
                });

                // Pastikan kolom No selalu bernomor 1 dan 2 per sungai (restart untuk setiap sungai)
                const trs = tableEl.querySelectorAll('tbody tr');
                let currentNo = 1;
                trs.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 4) {
                        // Baris awal sungai baru (Tambuo baris 1, Sianok baris 1)
                        currentNo = 1;
                        tds[2].innerHTML = '1';
                        tds[2].className = 'py-2.5 px-3 text-center border border-slate-700 align-middle font-medium text-slate-800';
                        currentNo = 2;
                    } else if (tds.length >= 2) {
                        // Baris lanjutan sungai yang sama (Tambuo baris 2, Sianok baris 2)
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

            // Khusus Tabel Dinas 08 / Tabel 4.1.x (Tabel 3-in-1: Sekolah, Guru, Murid)
            const isEducation3in1 = ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'].includes(currentTableCode);
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

                    if (text.includes('Guru') || text.includes('Teachers') || text.includes('Murid') || text.includes('Students')) {
                        // Pastikan ada baris pemisah / gap setidaknya 1 spasi sebelum header sub-tabel
                        const prevTr = tr.previousElementSibling;
                        if (prevTr && !prevTr.classList.contains('subtable-spacer-row')) {
                            const spacer = document.createElement('tr');
                            spacer.className = 'subtable-spacer-row pointer-events-none select-none';
                            spacer.innerHTML = '<td colspan="10" class="h-7 sm:h-9 bg-[#f0f3f8] border-y border-slate-200/90 border-x-0 p-0 text-center">&nbsp;</td>';
                            tr.parentNode.insertBefore(spacer, tr);
                        }

                        tr.className = 'bg-[#f95a00] text-white text-center font-bold subtable-header-title';
                        tds.forEach(td => {
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
                    } else if (!isDistrictRow && !isTotalRow && /\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(text) && tds.length >= 6) {
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
                    } else if (text.includes('-1') || text.includes('(1)') || (tds.length === 10 && (tds[0].innerText.trim() === '-1' || tds[0].innerText.trim() === '(1)'))) {
                        tr.className = 'bg-[#fed7aa] text-slate-900 text-center font-bold text-xs subtable-header-numbering';
                        tds.forEach((td, idx) => {
                            td.className = 'py-1 px-2 border border-slate-700 text-center font-bold text-xs';
                            td.innerText = `(${idx + 1})`;
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

            // Year status banner & Excel Upload Section Control
            const alertEl = document.getElementById('yearStatusAlert');
            const uploadSection = document.getElementById('excelUploadSection');

            if (hasData) {
                // If data exists: hide upload section by default (can be toggled by button)
                if (uploadSection) uploadSection.classList.add('hidden');
                
                if (alertEl) {
                    const isSaved = localStorage.getItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`) === '1' ||
                                    hasDbSaved ||
                                    ((currentTableCode === '8.1.1' || currentTableCode === '8.1.2' || currentTableCode === '8.1.3') && (currentYear.toString() === '2025' || currentYear.toString() === '2026'));
                    const isFromExcel = localStorage.getItem(`sibingka_table_source_${currentTableCode}_${currentYear}`) === 'excel';

                    if (!isSaved && localStorage.getItem(`sibingka_table_source_${currentTableCode}_${currentYear}`) === 'excel') {
                        saveGeneratedExcel(true);
                    }
                    if (alertEl) {
                        alertEl.innerHTML = '';
                        alertEl.classList.add('hidden');
                    }
                }
            } else {
                // If NO data exists for this year:
                if (isInheritedTemplate) {
                    if (uploadSection) uploadSection.classList.add('hidden');
                    if (alertEl) {
                        alertEl.classList.remove('hidden');
                        alertEl.innerHTML = `
                            <div class="p-3.5 rounded-xl bg-sky-50 border border-sky-200 text-sky-950 text-xs flex flex-wrap items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center space-x-2.5">
                                    <i class="fa-solid fa-lightbulb text-sky-600 text-base shrink-0"></i>
                                    <div>
                                        <span class="font-bold text-sky-900">Format Kolom & Rincian Baris Tahun ${currentYear} Siap Diisi</span>
                                        <p class="text-sky-800 text-[11px] mt-0.5">Struktur kolom ke samping dan nama rincian baris ke bawah telah otomatis disesuaikan dari data yang tersedia. Angka untuk tahun ${currentYear} masih kosong (-). Klik <strong>Edit Tabel</strong> untuk langsung mengisi angka, atau <strong>Import</strong> berkas Excel.</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 shrink-0">
                                    <button onclick="goToEditPage()" class="px-3.5 py-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs transition-colors shadow-2xs cursor-pointer flex items-center space-x-1.5">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Isi Angka Tahun ${currentYear}</span>
                                    </button>
                                </div>
                            </div>
                        `;
                    }
                } else {
                    // SHOW the Excel upload form by default if completely no structure found
                    if (uploadSection) {
                        uploadSection.classList.remove('hidden');
                        const subtitle = document.getElementById('excelUploadSubtitle');
                        if (subtitle) {
                            subtitle.innerHTML = `Tabel ${currentTableCode} <strong>Tahun ${currentYear}</strong> belum memiliki data. Unggah file Excel (.xlsx) untuk membuat tabel secara otomatis.`;
                        }
                    }
                    
                    if (alertEl) {
                        alertEl.classList.remove('hidden');
                        alertEl.innerHTML = `
                            <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-950 text-xs flex flex-wrap items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center space-x-2.5">
                                    <i class="fa-solid fa-circle-exclamation text-amber-600 text-base shrink-0"></i>
                                    <div>
                                        <span class="font-bold text-amber-900">Tahun ${currentYear} Belum Memiliki Data</span>
                                        <p class="text-amber-800 text-[11px] mt-0.5">Gunakan <strong>Form Import Excel</strong> di bawah untuk men-generate data tabel otomatis, atau klik Edit Tabel untuk mengisi manual.</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 shrink-0">
                                    ${currentTableCode === '1.1.6' && currentYear.toString() !== '2024' ? `
                                        <button onclick="changeTableYear('2024')" class="px-3.5 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition-colors shadow-2xs cursor-pointer flex items-center space-x-1.5">
                                            <i class="fa-solid fa-calendar-check text-[11px]"></i>
                                            <span>Lihat Data Tahun 2024</span>
                                        </button>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    }
                }
            }

            // Toggle header "Hapus Excel" button (hanya tampil saat sedang mereview berkas Excel sebelum disimpan)
            const btnDeleteExcel = document.getElementById('btnDeleteExcelData');
            const isSaved = localStorage.getItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`) === '1' || hasDbSaved;
            const hasCustomExcelData = localStorage.getItem(`sibingka_table_html_${currentTableCode}_${currentYear}`) !== null &&
                                      localStorage.getItem(`sibingka_table_source_${currentTableCode}_${currentYear}`) === 'excel';
            if (btnDeleteExcel) {
                if (hasCustomExcelData && !isSaved) {
                    btnDeleteExcel.classList.remove('hidden');
                } else {
                    btnDeleteExcel.classList.add('hidden');
                }
            }

            // Muat data catatan & komentar rincian data tabel
            if (typeof fetchTableComments === 'function') {
                if (typeof loadTableComments === 'function') loadTableComments(); else if (typeof fetchTableComments === 'function') fetchTableComments();
            }
        }

        function cleanGhostColumns(table) {
            if (!table) return;
            // JANGAN PERNAH potong kolom pada Tabel 1.1.6, 8.1.x, atau tabel multi-tahun
            const schema = (typeof tableSchemas !== 'undefined') ? tableSchemas[currentTableCode] : null;
            if (schema && (schema.isMultiYear || schema.isExcludeSelectedYear)) return;
            if (currentTableCode === '1.1.6' || currentTableCode.startsWith('8.1') || currentTableCode.startsWith('4.1') || currentOpdCode === '08') return;

            const bodyRows = table.querySelectorAll('tbody tr');
            if (bodyRows.length === 0) return;

            // Jangan pernah hapus jika jumlah kolom data di body sama dengan atau kurang dari kolom di header
            const theadThs = table.querySelectorAll('thead tr:last-child th');
            if (theadThs.length > 0 && bodyRows[0] && bodyRows[0].querySelectorAll('td').length <= theadThs.length) {
                return;
            }

            // Check if every row in tbody ends with an empty cell or '-'
            let allEndWithHyphenOrEmpty = true;
            let rowCount = 0;

            bodyRows.forEach(tr => {
                const tds = tr.querySelectorAll('td');
                if (tds.length >= 2) {
                    rowCount++;
                    const lastText = tds[tds.length - 1].innerText.trim();
                    if (lastText !== '-' && lastText !== '') {
                        allEndWithHyphenOrEmpty = false;
                    }
                }
            });

            if (rowCount > 0 && allEndWithHyphenOrEmpty) {
                // Remove the last td from each tbody row
                bodyRows.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 2) {
                        tds[tds.length - 1].remove();
                    }
                });

                // In thead, clean up any trailing empty th or sync column count
                const theadRows = table.querySelectorAll('thead tr');
                theadRows.forEach(tr => {
                    const ths = tr.querySelectorAll('th');
                    if (ths.length > 0) {
                        const lastTh = ths[ths.length - 1];
                        const txt = lastTh.innerText.trim();
                        if (txt === '' || txt === '-' || txt.startsWith('Kolom')) {
                            lastTh.remove();
                        }
                    }
                });

                // Update storage if this was saved html
                const savedKey = `sibingka_table_html_${currentTableCode}_${currentYear}`;
                if (localStorage.getItem(savedKey)) {
                    safeSetLocalStorage(savedKey, table.innerHTML);
                }
            }
        }

        function cleanGhostRows(table) {
            if (!table) return;
            // JANGAN PERNAH hapus baris data resmi pada tabel Dishub (8.1.x, OPD 20), BPN (1.1.x), BKPSDM (2.3.x), Pendidikan (4.1.x, 08), KPU/DPRD (2.2.2, 02, 03), atau Pertanian (5.1.x, 5.2.x, 9.11)
            if (currentTableCode === '2.2.2' || currentTableCode.startsWith('1.1.') || currentTableCode.startsWith('2.3.') || currentTableCode.startsWith('4.1') || currentTableCode.startsWith('5.1.') || currentTableCode.startsWith('5.2.') || currentTableCode.startsWith('8.1.') || currentTableCode.startsWith('8.2.') || currentTableCode === '9.11' || currentOpdCode === '02' || currentOpdCode === '03' || currentOpdCode === '08' || currentOpdCode === '04' || currentOpdCode === '20' || currentOpdCode === '17') return;
            const tbody = table.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            let removedAny = false;
            rows.forEach(tr => {
                const tds = Array.from(tr.querySelectorAll('td'));
                if (tds.length === 0) return;
                // Baris yang memiliki label teks kategori/indikator di kolom pertama BUKAN baris hantu
                const labelText = tds[0].innerText.trim();
                if (/[a-zA-Z]{2,}/.test(labelText)) {
                    return;
                }
                const hasMeaningful = tds.some(td => {
                    const txt = td.innerText.trim();
                    return txt !== '' && txt !== '-' && txt !== '–' && txt !== '—';
                });
                if (!hasMeaningful) {
                    tr.remove();
                    removedAny = true;
                }
            });

            if (removedAny) {
                const savedKey = `sibingka_table_html_${currentTableCode}_${currentYear}`;
                if (localStorage.getItem(savedKey)) {
                    safeSetLocalStorage(savedKey, table.innerHTML);
                }
            }
        }

        async function deleteBottomRowView() {
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            const tbody = tableEl.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            if (rows.length <= 1) {
                alert('Tabel minimal harus memiliki 1 baris data.');
                return;
            }
            if (!confirm('Apakah Anda yakin ingin menghapus baris paling bawah dari tabel ini?')) {
                return;
            }

            const lastRow = rows[rows.length - 1];
            deleteRowElementView(lastRow);

            safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, tableEl.innerHTML);
            safeSetLocalStorage(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`, '1');
            await saveGeneratedExcel(true, '');
            showToast('🗑️ Baris paling bawah berhasil dihapus!');
        }

        function deleteRowElementView(tr) {
            if (!tr) return;
            const tbody = tr.parentElement;
            if (!tbody) return;
            const allRows = Array.from(tbody.querySelectorAll('tr'));
            const rIdx = allRows.indexOf(tr);
            if (rIdx === -1) return;

            const rowspanCells = Array.from(tr.querySelectorAll('td[rowspan]')).filter(td => {
                return (parseInt(td.getAttribute('rowspan') || '1', 10)) > 1;
            });

            if (rowspanCells.length > 0) {
                const nextTr = allRows[rIdx + 1];
                if (nextTr) {
                    rowspanCells.reverse().forEach(cell => {
                        const curSpan = parseInt(cell.getAttribute('rowspan'), 10);
                        if (curSpan > 2) {
                            cell.setAttribute('rowspan', curSpan - 1);
                        } else {
                            cell.removeAttribute('rowspan');
                        }
                        nextTr.insertBefore(cell, nextTr.firstChild);
                    });
                }
            } else {
                for (let i = rIdx - 1; i >= 0; i--) {
                    const prevTr = allRows[i];
                    const dist = rIdx - i;
                    const parentRowspanCells = Array.from(prevTr.querySelectorAll('td[rowspan]')).filter(td => {
                        const sp = parseInt(td.getAttribute('rowspan') || '1', 10);
                        return sp > dist;
                    });
                    if (parentRowspanCells.length > 0) {
                        parentRowspanCells.forEach(cell => {
                            const sp = parseInt(cell.getAttribute('rowspan') || '1', 10);
                            if (sp > 2) {
                                cell.setAttribute('rowspan', sp - 1);
                            } else {
                                cell.removeAttribute('rowspan');
                            }
                        });
                        break;
                    }
                }
            }

            tr.remove();
        }

        async function changeTableYear(newYear) {
            currentYear = newYear.toString();
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('year', currentYear);
            window.history.pushState({}, '', newUrl);

            const selectYearEl = document.getElementById('yearSwitcher');
            if (selectYearEl) selectYearEl.value = currentYear;

            // Ambil data terbaru dari database MySQL untuk tahun ini
            try {
                const res = await fetch(`${window.SiBingkaConfig.routes.apiData}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}&type=${typeof currentType !== 'undefined' ? currentType : 'opd'}`);
                const dataRes = await res.json();
                if (dataRes.success) {
                    if (dataRes.dataStore) {
                        Object.assign(serverDbDataStore, dataRes.dataStore);
                    }
                    if (dataRes.metadata !== undefined) {
                        serverDbMetadata = dataRes.metadata;
                    }
                    if (dataRes.fallbackMetadata !== undefined) {
                        serverDbFallbackMetadata = dataRes.fallbackMetadata;
                    }
                }
            } catch(e) {}

            renderTablePage();
            showToast(`Tahun data diubah ke ${currentYear}`);
        }

        function goToEditPage() {
            let url = `${window.SiBingkaConfig.routes.editTabel}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`;
            if (currentType) url += `&type=${currentType}`;
            const curTitle = document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText : '';
            const curTitleEn = document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText : '';
            if (curTitle) url += `&title=${encodeURIComponent(curTitle)}`;
            if (curTitleEn) url += `&title_en=${encodeURIComponent(curTitleEn)}`;
            window.location.href = url;
        }

        // Helper to get cell text with proper linebreaks for bilingual headers
        function getCellText(col) {
            const ta = col.querySelector('.pma-textarea');
            if (ta) return ta.value.trim();

            const divs = col.querySelectorAll('div');
            if (divs.length >= 2) {
                const lines = [];
                divs.forEach(d => {
                    const txt = d.innerText.trim();
                    if (txt) lines.push(txt);
                });
                if (lines.length > 0) return lines.join('\n');
            }

            return col.innerText.replace(/\r?\n|\r/g, ' ').trim();
        }

        // Format angka ribuan dengan titik pemisah (tanpa Rp) untuk tabel keuangan
        function toggleExcelUploadForm(forceState) {
            const section = document.getElementById('excelUploadSection');
            if (!section) return;
            if (typeof forceState === 'boolean') {
                if (forceState) section.classList.remove('hidden');
                else section.classList.add('hidden');
            } else {
                section.classList.toggle('hidden');
            }
            if (!section.classList.contains('hidden')) {
                section.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function downloadExcelTemplate() {
            const url = `/tabel-opd/export-excel?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&type=${encodeURIComponent(currentType)}&template=1`;
            window.location.href = url;
            if (typeof showToast === 'function') {
                showToast(`📥 Mengunduh template Excel Tabel ${currentTableCode} Tahun ${currentYear}...`);
            }
            return;
        }

        async function handleExcelFileSelected(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (!file) return;

            const loadingEl = document.getElementById('excelUploadLoading');
            if (loadingEl) loadingEl.classList.remove('hidden');

            try {
                const formData = new FormData();
                formData.append('excel_file', file);
                formData.append('table_code', currentTableCode);
                formData.append('opd_code', currentOpdCode);
                formData.append('year', currentYear);
                formData.append('type', currentType);
                formData.append('_token', csrfToken);

                const response = await fetch('/tabel-opd/import-excel', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    if (typeof showToast === 'function') {
                        showToast('✅ Berhasil mengimpor data menggunakan Laravel Excel!');
                    }
                    if (result.table_html) {
                        try {
                            const scopedHtmlKey = (typeof getStorageKey === 'function') ? getStorageKey('sibingka_table_html') : `sibingka_table_html_${currentTableCode}_${currentYear}`;
                            const scopedSavedKey = (typeof getStorageKey === 'function') ? getStorageKey('sibingka_table_is_saved') : `sibingka_table_is_saved_${currentTableCode}_${currentYear}`;
                            safeSetLocalStorage(scopedHtmlKey, result.table_html);
                            safeSetLocalStorage(scopedSavedKey, '1');
                            safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, result.table_html);
                            safeSetLocalStorage(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`, '1');
                            safeSetLocalStorage(`sibingka_table_source_${currentTableCode}_${currentYear}`, 'excel');
                            if (result.title_id && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('sibingka_table_title_id'), result.title_id);
                            if (result.title_en && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('sibingka_table_title_en'), result.title_en);
                            if (result.source && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('sibingka_table_source_text'), result.source);
                            if (result.note && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('sibingka_table_note'), result.note);
                        } catch(e) {}
                        const tableEl = document.getElementById('dataDisplayTable');
                        if (tableEl) tableEl.innerHTML = result.table_html;
                    }
                    setTimeout(() => { window.location.reload(); }, 600);
                } else {
                    alert(result.message || 'Gagal mengimpor berkas Excel.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat mengunggah berkas Excel: ' + (err.message || err));
            } finally {
                if (loadingEl) loadingEl.classList.add('hidden');
                event.target.value = '';
            }
            return;
        }

        async function resetTableOriginal() {
            if (!confirm(`Apakah Anda yakin ingin mereset seluruh nilai data Tabel ${currentTableCode} kembali ke data asli resmi BPS?`)) {
                return;
            }

            // 1. Bersihkan seluruh cache localStorage untuk tabel ini
            try {
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (k && (k.includes(`${currentTableCode}_${currentYear}`) || k.includes(`_${currentTableCode}_`) || k.endsWith(`_${currentTableCode}`))) {
                        keysToRemove.push(k);
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
            } catch(e) {}

            // 2. Ambil HTML template resmi BPS jika ada skema
            let defaultHtml = null;
            if (tableSchemas[currentTableCode] && typeof tableSchemas[currentTableCode].render === 'function') {
                try {
                    defaultHtml = tableSchemas[currentTableCode].render(currentYear);
                    if (defaultHtml && defaultHtml.includes('<input')) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = defaultHtml;
                        tempDiv.querySelectorAll('input, .table-edit-input').forEach(inp => {
                            const val = (inp.value !== undefined ? inp.value : inp.getAttribute('value') || '').trim();
                            const parent = inp.closest('td, th') || inp.parentNode;
                            if (parent) {
                                parent.innerHTML = val;
                            }
                        });
                        defaultHtml = tempDiv.innerHTML;
                    }
                } catch(err) {
                    console.error('Error rendering default schema:', err);
                }
            }

            // 3. Panggil API delete/reset ke server
            try {
                await fetch(window.SiBingkaConfig.routes.apiDelete, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: typeof currentType !== 'undefined' ? currentType : 'opd',
                        default_html: defaultHtml
                    })
                });
            } catch(e) {
                console.error('Reset API error:', e);
            }

            if (serverDbMetadata) {
                serverDbMetadata.table_html = defaultHtml;
                serverDbMetadata.is_saved = false;
                serverDbMetadata.source_type = 'template';
            }

            showToast('🔄 Nilai tabel berhasil dikembalikan ke data awal resmi BPS!');
            setTimeout(() => {
                window.location.reload();
            }, 300);
        }

        // Aliaskan juga resetGeneratedExcel ke resetTableOriginal
        window.resetGeneratedExcel = resetTableOriginal;

        function escapeHtml(str) {
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function setupDragAndDrop() {
            const dropZone = document.getElementById('excelDropZone');
            if (!dropZone) return;

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('border-emerald-600', 'bg-emerald-100/50');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('border-emerald-600', 'bg-emerald-100/50');
                }, false);
            });

            dropZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length > 0) {
                    const fakeEvent = { target: { files: files, value: '' } };
                    handleExcelFileSelected(fakeEvent);
                }
            }, false);
        }

        function fallbackCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showToast('📋 Format tabel disalin! Tekan Ctrl+V pada Google Sheets atau Excel.');
        }

        // EXPORT DROPDOWN TOGGLE HANDLERS
        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const msgEl = document.getElementById('toastMessage');
            msgEl.innerText = message;

            toast.classList.remove('translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3500);
        }


        // ==========================================
        // EXPORT & TINDAKAN DROPDOWN TOGGLE HANDLERS
        // ==========================================
        function toggleActionDropdown() {
            const menu = document.getElementById('actionDropdownMenu');
            const chevron = document.getElementById('actionChevron');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            closeAllExportDropdowns();
            if (isHidden) {
                menu.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        }

        function closeActionDropdown() {
            const menu = document.getElementById('actionDropdownMenu');
            const chevron = document.getElementById('actionChevron');
            if (menu) menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }

        document.addEventListener('click', function (e) {
            const actContainer = document.getElementById('actionDropdownContainer');
            const actMenu = document.getElementById('actionDropdownMenu');
            if (actContainer && !actContainer.contains(e.target) && actMenu && !actMenu.contains(e.target)) {
                closeActionDropdown();
            }
        });

        // ==========================================
        // VERIFIKASI & ACC WORKFLOW ACTIONS (ADMIN BPS)
        // ==========================================
        async function handleApproveTable() {
            if (!confirm(`ACC & Kunci Tabel ${currentTableCode} Tahun ${currentYear}?\n\nData ini akan disahkan sebagai data valid BPS untuk publikasi Daerah Dalam Angka (DDA) dan terkunci bagi dinas.`)) {
                return;
            }

            try {
                const res = await fetch('/api/tabel-opd/approve-verification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: currentType
                    })
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Data berhasil di-ACC & dikunci!');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal menyetujui data.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat menyetujui data tabel.');
            }
        }

        function openRevisionModal() {
            const modal = document.getElementById('revisionModal');
            const card = document.getElementById('revisionModalCard');
            const input = document.getElementById('revisionNotesInput');
            if (input) input.value = '';
            if (modal && card) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                    if (input) input.focus();
                }, 50);
            }
        }

        function closeRevisionModal() {
            const modal = document.getElementById('revisionModal');
            const card = document.getElementById('revisionModalCard');
            if (modal && card) {
                card.classList.remove('scale-100', 'opacity-100');
                card.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }
        }

        async function handleRejectTable(event) {
            event.preventDefault();
            const input = document.getElementById('revisionNotesInput');
            const notes = input ? input.value.trim() : '';
            if (!notes) {
                alert('Mohon isi pesan catatan perbaikan untuk dinas.');
                return;
            }

            const btn = document.getElementById('btnSubmitRevision');
            if (btn) btn.disabled = true;

            try {
                const res = await fetch('/api/tabel-opd/reject-verification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: currentType,
                        notes: notes
                    })
                });
                const data = await res.json();
                if (data.success) {
                    closeRevisionModal();
                    showToast('Catatan revisi berhasil dikirim ke dinas.');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal mengirim catatan revisi.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat mengirim catatan revisi.');
            } finally {
                if (btn) btn.disabled = false;
            }
        }

        async function handleUnlockTable() {
            if (!confirm(`Buka Kunci Tabel ${currentTableCode} Tahun ${currentYear}?\n\nDinas akan kembali dapat mengedit angka jika diperlukan perbaikan.`)) {
                return;
            }

            try {
                const res = await fetch('/api/tabel-opd/unlock-table', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear
                    })
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Kunci tabel berhasil dibuka.');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal membuka kunci tabel.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat membuka kunci tabel.');
            }
        }

        // Listener Keyboard Esc untuk menutup modal spreadsheet
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('spreadsheetModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeSpreadsheetModal();
                }
            }
        });

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPage);
        } else {
            initPage();
        }
    