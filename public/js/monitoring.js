/**
 * SiMonDa Bukittinggi - Monitoring Progress Module (OPD & Instansi Vertikal)
 * Badan Pusat Statistik Kota Bukittinggi
 */

let currentModalAgency = null;

// Dropdown Menu Toggle
function toggleExportMenu() {
    const m = document.getElementById('exportDropdownMenu');
    if (m) m.classList.toggle('hidden');
}

// Close dropdown when clicked outside
document.addEventListener('click', function(e) {
    const btn = document.getElementById('exportDropdownBtn');
    const menu = document.getElementById('exportDropdownMenu');
    if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
    }
});

// Activity Logs Catalog
const agencyActivityLogs = {
    '01': [
        {
            date: '22 Jan 2026',
            time: '(14:30 WIB)',
            dotColor: 'bg-emerald-600',
            lineColor: 'bg-emerald-600',
            boxColor: 'bg-emerald-600',
            icon: 'fa-file-lines',
            title: 'Pembaruan Progress: Verifikasi data sektoral oleh admin BPS Kota Bukittinggi',
            badge: 'Berhasil',
            badgeClass: 'bg-emerald-100 text-emerald-800',
            actor: 'BPS Admin'
        },
        {
            date: '21 Jan 2026',
            time: '(11:15 WIB)',
            dotColor: 'bg-[#f98825]',
            lineColor: 'bg-emerald-600',
            boxColor: 'bg-[#e07212]',
            icon: 'fa-file-circle-check',
            title: 'Unggah Dokumen: Input Data Tahap II',
            badge: 'Proses Verifikasi',
            badgeClass: 'bg-amber-100 text-amber-800',
            actor: 'Admin Instansi'
        },
        {
            date: '19 Jan 2026',
            time: '(09:00 WIB)',
            dotColor: 'bg-rose-600',
            lineColor: 'bg-emerald-600',
            boxColor: 'bg-[#a81c2e]',
            icon: 'fa-screwdriver-wrench',
            title: 'Pemeriksaan: Penyesuaian format kolom data tabel',
            badge: 'Perlu Revisi',
            badgeClass: 'bg-rose-100 text-rose-800',
            actor: 'BPS Admin'
        },
        {
            date: '15 Jan 2026',
            time: '(10:00 WIB)',
            dotColor: 'bg-emerald-600',
            lineColor: 'bg-transparent',
            boxColor: 'bg-emerald-600',
            icon: 'fa-file-lines',
            title: 'Persiapan awal & Pembuatan tabel data statistik',
            badge: 'Selesai',
            badgeClass: 'bg-emerald-100 text-emerald-800',
            actor: 'BPS Admin'
        }
    ]
};

function getAgencyLogs(code, shortName) {
    if (agencyActivityLogs[code]) {
        return agencyActivityLogs[code];
    }

    const cleanName = shortName.replace(/^\d+\.\s*/, '');
    return [
        {
            date: '23 Jan 2026',
            time: '(14:20 WIB)',
            dotColor: 'bg-emerald-600',
            lineColor: 'bg-emerald-600',
            boxColor: 'bg-emerald-600',
            icon: 'fa-file-lines',
            title: `Pembaruan Progress: Verifikasi data sektoral oleh admin BPS Kota Bukittinggi`,
            badge: 'Berhasil',
            badgeClass: 'bg-emerald-100 text-emerald-800',
            actor: `Oleh: Admin ${cleanName}`
        },
        {
            date: '21 Jan 2026',
            time: '(10:45 WIB)',
            dotColor: 'bg-[#f98825]',
            lineColor: 'bg-emerald-600',
            boxColor: 'bg-[#e07212]',
            icon: 'fa-file-circle-check',
            title: `Unggah Dokumen: Input Data Sektoral (${cleanName})`,
            badge: 'Proses Verifikasi',
            badgeClass: 'bg-amber-100 text-amber-800',
            actor: `Oleh: Admin ${cleanName}`
        },
        {
            date: '18 Jan 2026',
            time: '(11:00 WIB)',
            dotColor: 'bg-emerald-600',
            lineColor: 'bg-emerald-600',
            boxColor: 'bg-emerald-600',
            icon: 'fa-file-lines',
            title: `Pemeriksaan Awal: Validasi struktur form tabel data oleh BPS`,
            badge: 'Selesai',
            badgeClass: 'bg-emerald-100 text-emerald-800',
            actor: 'BPS Admin'
        },
        {
            date: '15 Jan 2026',
            time: '(09:30 WIB)',
            dotColor: 'bg-emerald-600',
            lineColor: 'bg-transparent',
            boxColor: 'bg-emerald-600',
            icon: 'fa-file-lines',
            title: 'Persiapan awal & Pembuatan formulir tabel data',
            badge: 'Selesai',
            badgeClass: 'bg-emerald-100 text-emerald-800',
            actor: 'BPS Admin'
        }
    ];
}

// Open Unified Detail Modal
function openAgencyDetailModal(type, code, short, full, pct, status, stepLabel, step = 1, tables = '') {
    currentModalAgency = { type, code, short, full, pct, status, stepLabel, step, tables };

    const cleanShort = short.replace(/^\d+\.\s*/, '');
    const nameEl = document.getElementById('modalAgencyShortName');
    if (nameEl) nameEl.innerText = cleanShort;

    const link = document.getElementById('modalAgencyGoLink');
    const linkText = document.getElementById('modalAgencyGoLinkText');
    const selectedYear = window.monitoringSelectedYear || 2025;
    if (link) {
        const routeName = (type === 'instansi') ? 'isi-data-instansi' : 'isi-data-opd';
        link.href = `/${routeName}?${type}=${code}&year=${selectedYear}`;
    }
    if (linkText) {
        linkText.innerText = (type === 'instansi') ? 'Buka Halaman Input Data Instansi' : 'Buka Halaman Input Data OPD';
    }

    highlightModalStageButtons(step);

    const logs = getAgencyLogs(code, short);
    const container = document.getElementById('modalTimelineContainer');
    
    if (container) {
        let html = '';
        logs.forEach((log, idx) => {
            const isLast = idx === logs.length - 1;
            html += `
                <div class="flex items-start justify-between gap-3 relative">
                    <div class="w-24 sm:w-28 text-right shrink-0 pt-0.5">
                        <div class="text-[11px] sm:text-xs font-bold text-slate-800 leading-tight">${log.date}</div>
                        <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium leading-tight mt-0.5">${log.time}</div>
                    </div>
                    <div class="flex items-center space-x-2 shrink-0 relative">
                        ${!isLast ? `<div class="absolute left-1 top-3 bottom-[-24px] w-0.5 ${log.lineColor}"></div>` : ''}
                        <div class="w-2.5 h-2.5 rounded-full ${log.dotColor} relative z-10 shrink-0"></div>
                        <div class="w-8 h-8 rounded-lg ${log.boxColor} text-white flex items-center justify-center text-xs relative z-10 shadow-2xs shrink-0">
                            <i class="fa-solid ${log.icon}"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0 pt-0.5 pl-1">
                        <h4 class="text-xs sm:text-[13px] font-bold text-slate-900 leading-snug">
                            ${log.title}
                        </h4>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold ${log.badgeClass}">
                                ${log.badge}
                            </span>
                        </div>
                    </div>
                    <div class="w-24 sm:w-28 text-right shrink-0 pt-0.5">
                        <div class="text-[11px] font-semibold text-slate-700 leading-tight">
                            ${log.actor}
                        </div>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    const modal = document.getElementById('agencyDetailModal') || document.getElementById('opdDetailModal') || document.getElementById('instansiDetailModal');
    if (modal) modal.classList.remove('hidden');
}

// Backward compatibility aliases
function openOpdDetailModal(code, short, full, pct, status, stepLabel, tables, step = 1) {
    openAgencyDetailModal('opd', code, short, full, pct, status, stepLabel, step, tables);
}

function openInstansiDetailModal(code, short, full, pct, status, stepLabel, step = 1) {
    openAgencyDetailModal('instansi', code, short, full, pct, status, stepLabel, step);
}

function closeAgencyDetailModal() {
    const modal = document.getElementById('agencyDetailModal') || document.getElementById('opdDetailModal') || document.getElementById('instansiDetailModal');
    if (modal) modal.classList.add('hidden');
}

function closeOpdDetailModal() { closeAgencyDetailModal(); }
function closeInstansiDetailModal() { closeAgencyDetailModal(); }

// Stage Stage Names
const stageNames = {
    1: 'Persiapan',
    2: 'Input Data',
    3: 'Verifikasi',
    4: 'Validasi BPS',
    5: 'Publikasi'
};

function highlightModalStageButtons(activeStep) {
    const badge = document.getElementById('modalCurrentStageBadge');
    if (badge) {
        badge.innerText = stageNames[activeStep] || `Tahap ${activeStep}`;
        if (activeStep === 5) {
            badge.className = 'px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-700';
        } else if (activeStep === 1) {
            badge.className = 'px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-slate-100 text-slate-700';
        } else {
            badge.className = 'px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-orange-100 text-[#f95a00]';
        }
    }

    for (let s = 1; s <= 5; s++) {
        const btn = document.getElementById('modalStageBtn' + s);
        if (btn) {
            if (s === activeStep) {
                btn.className = 'modal-stage-btn px-2 py-1.5 rounded-xl text-[11px] font-bold border-2 border-[#f95a00] bg-orange-50 text-[#f95a00] shadow-2xs transition-all cursor-pointer ring-2 ring-orange-200';
            } else {
                btn.className = 'modal-stage-btn px-2 py-1.5 rounded-xl text-[11px] font-bold border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 transition-all cursor-pointer';
            }
        }
    }
}

function changeModalStage(newStage) {
    if (!currentModalAgency) return;
    highlightModalStageButtons(newStage);
    updateStageQuick(currentModalAgency.type, currentModalAgency.code, newStage);
}

// Update Stage via AJAX
async function updateStageQuick(agencyType, agencyCode, newStage) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const selectedYear = window.monitoringSelectedYear || 2025;
        const res = await fetch('/monitoring/update-stage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                agency_type: agencyType,
                agency_code: agencyCode,
                year: parseInt(selectedYear),
                stage: parseInt(newStage)
            })
        });
        const data = await res.json();
        if (data.success) {
            showToast(data.message);
            setTimeout(() => { window.location.reload(); }, 600);
        } else {
            alert('Gagal mengubah tahapan: ' + (data.message || 'Terjadi kesalahan'));
        }
    } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan jaringan saat menyimpan tahapan.');
    }
}

// Toast Notification
function showToast(msg) {
    const toast = document.getElementById('toastNotification');
    const msgEl = document.getElementById('toastMessage');
    if (!toast || !msgEl) return;
    msgEl.innerText = msg;
    toast.classList.remove('hidden');
    setTimeout(() => {
        toast.classList.remove('translate-y-3', 'opacity-0');
    }, 10);
    setTimeout(() => {
        toast.classList.add('translate-y-3', 'opacity-0');
        setTimeout(() => { toast.classList.add('hidden'); }, 300);
    }, 2500);
}

// Filter Cards
let activeFilter = 'all';

function setAgencyStatusFilter(status) {
    activeFilter = status;
    
    document.querySelectorAll('.status-filter-btn').forEach(btn => {
        btn.classList.remove('bg-[#f95a00]', 'text-white', 'shadow-2xs');
        btn.classList.add('bg-slate-100', 'text-slate-600');
    });

    const activeBtn = document.getElementById('filterBtn' + status.charAt(0).toUpperCase() + status.slice(1));
    if (activeBtn) {
        activeBtn.classList.remove('bg-slate-100', 'text-slate-600');
        activeBtn.classList.add('bg-[#f95a00]', 'text-white', 'shadow-2xs');
    }

    filterAgencyCards();
}

function setOpdStatusFilter(status) { setAgencyStatusFilter(status); }
function setInstansiStatusFilter(status) { setAgencyStatusFilter(status); }

function filterAgencyCards() {
    const input = document.getElementById('opdSearchInput') || document.getElementById('instansiSearchInput');
    const query = input ? input.value.toLowerCase().trim() : '';
    const cards = document.querySelectorAll('.agency-card, .opd-card, .instansi-card');

    cards.forEach(card => {
        const name = (card.getAttribute('data-name') || '').toLowerCase();
        const status = card.getAttribute('data-status') || '';
        
        const matchesQuery = query === '' || name.includes(query);
        const matchesFilter = activeFilter === 'all' || status === activeFilter;

        if (matchesQuery && matchesFilter) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}

function filterOpdCards() { filterAgencyCards(); }
function filterInstansiCards() { filterAgencyCards(); }

// Export Single Agency Activity Log
function exportCurrentAgencyLog() {
    if (!currentModalAgency) return;
    const logs = getAgencyLogs(currentModalAgency.code, currentModalAgency.short);
    
    const wsData = [
        [`RIWAYAT AKTIVITAS & PROGRESS - ${currentModalAgency.full.toUpperCase()}`],
        [`Badan Pusat Statistik Kota Bukittinggi`],
        [],
        ['No', 'Tanggal', 'Waktu', 'Aktivitas', 'Status', 'Pelaksana / Aktor']
    ];

    logs.forEach((log, idx) => {
        wsData.push([
            idx + 1,
            log.date,
            log.time,
            log.title,
            log.badge,
            log.actor
        ]);
    });

    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(wsData);

    ws['!cols'] = [
        { wch: 6 },
        { wch: 14 },
        { wch: 14 },
        { wch: 65 },
        { wch: 18 },
        { wch: 25 }
    ];

    const safeName = currentModalAgency.short.replace(/[^a-zA-Z0-9]/g, '_');
    XLSX.utils.book_append_sheet(wb, ws, 'Riwayat Aktivitas');
    XLSX.writeFile(wb, `Riwayat_Aktivitas_${safeName}.xlsx`);
}

function exportSingleOpdLog() { exportCurrentAgencyLog(); }
function exportSingleInstansiLog() { exportCurrentAgencyLog(); }

// Export Full Monitoring Table to Styled Excel
function exportMonitoringToExcel(options) {
    const { title, fileName, dataset, year } = options || {};
    const now = new Date();
    const daysIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const monthsIndo = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    const hari = daysIndo[now.getDay()];
    const tanggal = now.getDate();
    const bulan = monthsIndo[now.getMonth()];
    const tahunSekarang = now.getFullYear();
    const downloadDateHeader = `${hari}, ${tanggal} ${bulan} ${tahunSekarang}`;
    const tahunLaporan = year || window.monitoringSelectedYear || tahunSekarang;

    const borderThin = {
        top: { style: 'thin', color: { rgb: '000000' } },
        bottom: { style: 'thin', color: { rgb: '000000' } },
        left: { style: 'thin', color: { rgb: '000000' } },
        right: { style: 'thin', color: { rgb: '000000' } }
    };

    const headerStyle = {
        fill: { fgColor: { rgb: 'F6C85F' } },
        font: { name: 'Calibri', sz: 11, bold: true, color: { rgb: '000000' } },
        alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
        border: borderThin
    };

    const noStyle = {
        font: { name: 'Calibri', sz: 10, color: { rgb: '000000' } },
        alignment: { horizontal: 'center', vertical: 'center' },
        border: borderThin
    };

    const instansiStyle = {
        font: { name: 'Calibri', sz: 10, color: { rgb: '000000' } },
        alignment: { horizontal: 'left', vertical: 'center' },
        border: borderThin
    };

    const lengkapStyle = {
        fill: { fgColor: { rgb: '137333' } },
        font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: 'FFFFFF' } },
        alignment: { horizontal: 'center', vertical: 'center' },
        border: borderThin
    };

    const belumTerisiStyle = {
        fill: { fgColor: { rgb: 'A50E0E' } },
        font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: 'FFFFFF' } },
        alignment: { horizontal: 'center', vertical: 'center' },
        border: borderThin
    };

    const belumLengkapStyle = {
        fill: { fgColor: { rgb: 'B06000' } },
        font: { name: 'Calibri', sz: 10, bold: true, color: { rgb: 'FFFFFF' } },
        alignment: { horizontal: 'center', vertical: 'center' },
        border: borderThin
    };

    const titleStyle = {
        font: { name: 'Calibri', sz: 12, bold: true, color: { rgb: '000000' } },
        alignment: { horizontal: 'center', vertical: 'center' }
    };

    const subtitleStyle = {
        font: { name: 'Calibri', sz: 9.5, italic: true, color: { rgb: '475569' } },
        alignment: { horizontal: 'center', vertical: 'center' }
    };

    const ws = {};
    const totalRows = dataset.length;
    const range = { s: { c: 0, r: 0 }, e: { c: 2, r: 4 + totalRows } };

    ws['A1'] = { t: 's', v: title, s: titleStyle };
    ws['B1'] = { t: 's', v: '', s: titleStyle };
    ws['C1'] = { t: 's', v: '', s: titleStyle };

    ws['A2'] = { t: 's', v: `Badan Pusat Statistik Kota Bukittinggi | Waktu Unduh: ${downloadDateHeader}`, s: subtitleStyle };
    ws['B2'] = { t: 's', v: '', s: subtitleStyle };
    ws['C2'] = { t: 's', v: '', s: subtitleStyle };

    ws['A3'] = { t: 's', v: '' };
    ws['B3'] = { t: 's', v: '' };
    ws['C3'] = { t: 's', v: '' };

    ws['A4'] = { t: 's', v: 'No', s: headerStyle };
    ws['B4'] = { t: 's', v: 'Instansi / OPD', s: headerStyle };
    ws['C4'] = { t: 's', v: `STATUS MONITORING TAHUN ${tahunLaporan}`, s: headerStyle };

    ws['A5'] = { t: 's', v: '', s: headerStyle };
    ws['B5'] = { t: 's', v: '', s: headerStyle };
    ws['C5'] = { t: 's', v: `Waktu Unduh: ${downloadDateHeader}`, s: headerStyle };

    dataset.forEach((item, idx) => {
        const rowNum = idx + 6;
        let statusLabel = 'Belum Terisi';
        let statusStyle = belumTerisiStyle;

        if (item.progress === 100) {
            statusLabel = 'Lengkap (100%)';
            statusStyle = lengkapStyle;
        } else if (item.progress > 0) {
            statusLabel = `Proses (${item.progress}%)`;
            statusStyle = belumLengkapStyle;
        }

        ws['A' + rowNum] = { t: 'n', v: idx + 1, s: noStyle };
        ws['B' + rowNum] = { t: 's', v: item.full, s: instansiStyle };
        ws['C' + rowNum] = { t: 's', v: statusLabel, s: statusStyle };
    });

    ws['!ref'] = XLSX.utils.encode_range(range);
    ws['!merges'] = [
        { s: { r: 0, c: 0 }, e: { r: 0, c: 2 } },
        { s: { r: 1, c: 0 }, e: { r: 1, c: 2 } },
        { s: { r: 3, c: 0 }, e: { r: 4, c: 0 } },
        { s: { r: 3, c: 1 }, e: { r: 4, c: 1 } }
    ];

    ws['!cols'] = [
        { wch: 6 },
        { wch: 55 },
        { wch: 30 }
    ];

    const rowHeights = [
        { hpt: 22 },
        { hpt: 18 },
        { hpt: 8 },
        { hpt: 24 },
        { hpt: 24 }
    ];
    for (let i = 0; i < totalRows; i++) rowHeights.push({ hpt: 22 });
    ws['!rows'] = rowHeights;

    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, `Rekap ${tahunLaporan}`);

    XLSX.writeFile(wb, `${fileName}.xlsx`);
}

// Export All Tables Details to Excel (Per Tabel per Instansi untuk Tahun Terpilih)
function exportAllTablesDetailsExcel() {
    if (typeof XLSX === 'undefined') {
        alert('Library Excel belum siap. Silakan muat ulang halaman.');
        return;
    }

    const year = window.monitoringSelectedYear || (new Date()).getFullYear();
    const isInstansi = (typeof window.monTabType !== 'undefined' && window.monTabType === 'instansi');
    const catalog = isInstansi ? (window.instansiTablesCatalog || {}) : (window.opdTablesCatalog || {});
    const now = new Date();
    const daysIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const monthsIndo = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    const downloadDate = `${daysIndo[now.getDay()]}, ${now.getDate()} ${monthsIndo[now.getMonth()]} ${now.getFullYear()}`;

    const borderThin = {
        top: { style: 'thin', color: { rgb: '000000' } },
        bottom: { style: 'thin', color: { rgb: '000000' } },
        left: { style: 'thin', color: { rgb: '000000' } },
        right: { style: 'thin', color: { rgb: '000000' } }
    };

    const headerStyle = {
        fill: { fgColor: { rgb: 'F98825' } },
        font: { name: 'Calibri', sz: 11, bold: true, color: { rgb: 'FFFFFF' } },
        alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
        border: borderThin
    };

    const cellCenter = {
        font: { name: 'Calibri', sz: 10, color: { rgb: '000000' } },
        alignment: { horizontal: 'center', vertical: 'center' },
        border: borderThin
    };

    const cellLeft = {
        font: { name: 'Calibri', sz: 10, color: { rgb: '000000' } },
        alignment: { horizontal: 'left', vertical: 'center', wrapText: true },
        border: borderThin
    };

    const titleStyle = {
        font: { name: 'Calibri', sz: 13, bold: true, color: { rgb: '000000' } },
        alignment: { horizontal: 'center', vertical: 'center' }
    };

    const subtitleStyle = {
        font: { name: 'Calibri', sz: 9.5, italic: true, color: { rgb: '475569' } },
        alignment: { horizontal: 'center', vertical: 'center' }
    };

    const ws = {};
    const titleText = `RINCIAN MONITORING TABEL STATISTIK SEKTORAL ${isInstansi ? 'INSTANSI VERTIKAL' : 'OPD'} KOTA BUKITTINGGI - TAHUN ${year}`;
    
    ws['A1'] = { t: 's', v: titleText, s: titleStyle };
    ws['A2'] = { t: 's', v: `Badan Pusat Statistik Kota Bukittinggi | Waktu Unduh: ${downloadDate}`, s: subtitleStyle };

    const headers = ['No', 'Kode OPD', 'Instansi Penyelenggara', 'Kode Tabel', 'Judul Tabel Statistik Sektoral', `Status Data (${year})`, `Status Verifikasi BPS (${year})`];
    headers.forEach((h, colIdx) => {
        const colLetter = String.fromCharCode(65 + colIdx);
        ws[colLetter + '4'] = { t: 's', v: h, s: headerStyle };
    });

    let rowIdx = 5;
    let tableNum = 1;

    for (const agencyCode in catalog) {
        const cleanOpd = agencyCode.padStart(2, '0');
        let agencyName = `Instansi ${cleanOpd}`;
        if (!isInstansi && typeof opdNames !== 'undefined' && opdNames[cleanOpd]) {
            agencyName = opdNames[cleanOpd];
        } else if (isInstansi && typeof instansiNames !== 'undefined' && instansiNames[cleanOpd]) {
            agencyName = instansiNames[cleanOpd];
        }

        const tables = (typeof getAgencyTables === 'function') ? getAgencyTables(cleanOpd, isInstansi ? 'instansi' : 'opd') : catalog[agencyCode];
        if (tables && tables.length > 0) {
            tables.forEach(t => {
                const dbKey = `${cleanOpd}_${t.code}`;
                const dbStatus = (window.allTablesStatusDb && window.allTablesStatusDb[dbKey]) ? window.allTablesStatusDb[dbKey] : null;

                const numStat = dbStatus ? (dbStatus.status || dbStatus.numeric_status) : 'belum';
                const numPct = dbStatus ? (dbStatus.numeric_pct || 0) : 0;
                const ver = dbStatus ? (dbStatus.verification_status || 'draft') : 'belum';
                
                let dataStatusText = 'Belum Diisi (0% Angka / Strip -)';
                if (numStat === 'lengkap') {
                    dataStatusText = 'Lengkap (100% Angka Terisi)';
                } else if (numStat === 'proses') {
                    dataStatusText = `Belum Lengkap (${numPct}% Angka Terisi)`;
                }

                let verStatusText = 'Belum Diisi';
                if (numStat === 'lengkap' || numStat === 'proses') {
                    if (ver === 'verified') verStatusText = 'Validasi Selesai (Di-ACC)';
                    else if (ver === 'submitted') verStatusText = 'Menunggu Verifikasi BPS';
                    else if (ver === 'revision') verStatusText = 'Perlu Revisi';
                    else verStatusText = 'Draf (Sedang Diisi)';
                }

                ws['A' + rowIdx] = { t: 'n', v: tableNum++, s: cellCenter };
                ws['B' + rowIdx] = { t: 's', v: cleanOpd, s: cellCenter };
                ws['C' + rowIdx] = { t: 's', v: agencyName, s: cellLeft };
                ws['D' + rowIdx] = { t: 's', v: `Tabel ${t.code}`, s: cellCenter };
                ws['E' + rowIdx] = { t: 's', v: t.title || '', s: cellLeft };
                ws['F' + rowIdx] = { t: 's', v: dataStatusText, s: cellCenter };
                ws['G' + rowIdx] = { t: 's', v: verStatusText, s: cellCenter };
                rowIdx++;
            });
        }
    }

    const range = { s: { c: 0, r: 0 }, e: { c: 6, r: rowIdx - 1 } };
    ws['!ref'] = XLSX.utils.encode_range(range);
    ws['!merges'] = [
        { s: { r: 0, c: 0 }, e: { r: 0, c: 6 } },
        { s: { r: 1, c: 0 }, e: { r: 1, c: 6 } }
    ];

    ws['!cols'] = [
        { wch: 6 },
        { wch: 10 },
        { wch: 42 },
        { wch: 14 },
        { wch: 60 },
        { wch: 18 },
        { wch: 25 }
    ];

    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, `Rincian Tabel ${year}`);
    XLSX.writeFile(wb, `Monitoring_Rincian_Tabel_Bukittinggi_Tahun_${year}.xlsx`);
}

