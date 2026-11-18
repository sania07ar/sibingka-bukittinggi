/**
 * SiBingka Bukittinggi - Monitoring Progress Module (OPD & Instansi Vertikal)
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

// Riwayat aktivitas nyata dari database: kirim tabel, verifikasi Wali Data, validasi BPS.
// Datanya disiapkan server (App\Support\MonitoringProgress::activitiesFor) dan ikut di window.monAllData.
const ACTIVITY_STYLE = {
    kirim:      { icon: 'fa-paper-plane',      boxColor: 'bg-[#f95a00]',  badge: 'Terkirim',      badgeClass: 'bg-orange-100 text-orange-800',  verb: 'Mengirim 1 tabel' },
    verifikasi: { icon: 'fa-user-check',       boxColor: 'bg-sky-600',    badge: 'Terverifikasi', badgeClass: 'bg-sky-100 text-sky-800',        verb: 'Verifikasi Wali Data atas 1 tabel' },
    validasi:   { icon: 'fa-circle-check',     boxColor: 'bg-emerald-600', badge: 'Tervalidasi',  badgeClass: 'bg-emerald-100 text-emerald-800', verb: 'Validasi Admin BPS atas 1 tabel' }
};

function getAgencyLogs(code) {
    const items = Array.isArray(window.monAllData) ? window.monAllData : [];
    const item = items.find((entry) => String(entry.code) === String(code));
    const activities = (item && Array.isArray(item.activities)) ? item.activities : [];

    return activities.map((act) => {
        const style = ACTIVITY_STYLE[act.kind] || ACTIVITY_STYLE.kirim;
        const tableName = `Tabel ${act.table_code}` + (act.title ? ` - ${act.title}` : '');
        return {
            kind: act.kind,
            date: act.date,
            time: act.time ? `Pukul ${act.time}` : '',
            icon: style.icon,
            boxColor: style.boxColor,
            tableName,
            title: `${style.verb}: ${tableName}`,
            badge: style.badge,
            badgeClass: style.badgeClass,
            actor: act.actor && act.actor !== '-' ? `Oleh: ${act.actor}` : ''
        };
    });
}

// Helper: format tanggal relatif singkat
function _relativeTime(dateStr, timeStr) {
    if (!dateStr) return '';
    // dateStr biasanya sudah format "17 Nov 2026" atau ISO, timeStr "Pukul 13:53"
    // Coba parse dari dateStr + timeStr
    try {
        // Coba parse ISO langsung jika dateStr berformat ISO
        let dt;
        if (/^\d{4}-\d{2}-\d{2}/.test(dateStr)) {
            dt = new Date(dateStr);
        } else {
            // Format "17 November 2026" atau "17 Nov 2026"
            const rawTime = timeStr ? timeStr.replace('Pukul ', '') : '00:00';
            dt = new Date(dateStr + ' ' + rawTime);
        }
        if (isNaN(dt.getTime())) return '';
        const diffMs = Date.now() - dt.getTime();
        const diffMin = Math.floor(diffMs / 60000);
        const diffHr  = Math.floor(diffMs / 3600000);
        const diffDay = Math.floor(diffMs / 86400000);
        if (diffMin < 2)   return 'baru saja';
        if (diffMin < 60)  return diffMin + ' menit lalu';
        if (diffHr < 24)   return diffHr + ' jam lalu';
        if (diffDay === 1) return 'kemarin';
        return diffDay + ' hari lalu';
    } catch(e) { return ''; }
}

// Daftar aktivitas per tahap (urut: Input Data, Verifikasi Wali Data, Validasi BPS), tanggal tercatat dari database
function renderModalStageLists(logs) {
    const stageConfig = [
        { kind: 'kirim',      el: 'modalListInput', empty: 'Belum ada tabel yang dikirim.',                dotCls: 'bg-[#f95a00]', borderCls: 'border-orange-200' },
        { kind: 'verifikasi', el: 'modalListVerif', empty: 'Belum ada tabel yang diverifikasi Wali Data.', dotCls: 'bg-sky-500',    borderCls: 'border-sky-200'    },
        { kind: 'validasi',   el: 'modalListValid', empty: 'Belum ada tabel yang divalidasi BPS.',         dotCls: 'bg-emerald-500',borderCls: 'border-emerald-200' }
    ];
    stageConfig.forEach(({ kind, el, empty, dotCls, borderCls }) => {
        const box = document.getElementById(el);
        if (!box) return;
        const rows = logs.filter((log) => log.kind === kind);
        if (!rows.length) {
            box.innerHTML = `<p class="py-2.5 text-[11px] text-slate-400 italic">${empty}</p>`;
            return;
        }
        // Tampilkan sebagai activity feed dengan timeline dot
        box.innerHTML = `<div class="relative mt-1">` +
            // Garis vertikal
            `<div class="absolute left-[7px] top-2 bottom-2 w-px bg-slate-100 pointer-events-none"></div>` +
            rows.map((log) => {
                const relative = _relativeTime(log.date, log.time);
                const actorHtml = log.actor ? `<span class="text-slate-400">· ${log.actor}</span>` : '';
                const timeClean = log.time ? log.time.replace('Pukul ', '') : '';
                return `
                <div class="relative flex items-start gap-3 py-2 activity-log-item">
                    <span class="shrink-0 mt-1 w-3.5 h-3.5 rounded-full ${dotCls} ring-2 ring-white z-10 inline-block"></span>
                    <div class="flex-1 min-w-0 flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <div class="text-[12px] font-bold text-slate-800 leading-snug break-words">${log.tableName}</div>
                            ${log.actor ? `<div class="text-[10px] text-slate-500 mt-0.5">${log.actor}</div>` : ''}
                        </div>
                        <div class="text-right shrink-0 ml-1">
                            <div class="text-[11px] font-semibold text-slate-700 leading-tight whitespace-nowrap">${log.date}</div>
                            ${timeClean ? `<div class="text-[10px] text-slate-400 leading-tight mt-0.5">${timeClean}</div>` : ''}
                            ${relative ? `<div class="text-[10px] text-slate-400 italic mt-0.5">${relative}</div>` : ''}
                        </div>
                    </div>
                </div>`;
            }).join('') +
        `</div>`;
    });
}

// Isi 3 persentase (Input Data, Verifikasi Wali Data, Validasi BPS) pada modal detail
function renderModalProgressBars(a) {
    const rows = [
        ['Input', a.pctInput, a.cntInput],
        ['Verif', a.pctVerif, a.cntVerif],
        ['Valid', a.pctValid, a.cntValid]
    ];
    rows.forEach(([key, pct, count]) => {
        const pctEl = document.getElementById('modalPct' + key);
        const barEl = document.getElementById('modalBar' + key);
        const cntEl = document.getElementById('modalCnt' + key);
        if (pctEl) pctEl.innerText = (pct || 0) + '%';
        if (barEl) barEl.style.width = Math.min(100, pct || 0) + '%';
        if (cntEl) cntEl.innerText = (count || 0) + ' dari ' + (a.cntTotal || 0) + ' tabel';
    });
}

// Open Unified Detail Modal
function openAgencyDetailModal(type, code, short, full, pct, status, stepLabel, step = 1, tables = '', isVerifiedByWali = false, hasSubmitted = false, pctInput = 0, pctVerif = 0, pctValid = 0, cntInput = 0, cntVerif = 0, cntValid = 0, cntTotal = 0) {
    currentModalAgency = { type, code, short, full, pct, status, stepLabel, step, tables, isVerifiedByWali, hasSubmitted, pctInput, pctVerif, pctValid, cntInput, cntVerif, cntValid, cntTotal };
    renderModalProgressBars(currentModalAgency);

    const cleanShort = short.replace(/^\d+\.\s*/, '');
    const nameEl = document.getElementById('modalAgencyShortName');
    if (nameEl) nameEl.innerText = cleanShort;

    const link = document.getElementById('modalAgencyGoLink');
    const linkText = document.getElementById('modalAgencyGoLinkText');
    const selectedYear = window.monitoringSelectedYear || (new Date().getFullYear());
    if (link) {
        let routeName = 'isi-data-opd';
        if (type === 'instansi') {
            routeName = 'isi-data-instansi';
        } else if (type === 'bps') {
            routeName = 'data-bps';
        }
        link.href = sbUrl(`/${routeName}?${type}=${code}&year=${selectedYear}`);
    }
    if (linkText) {
        let btnText = 'Buka Halaman Input Data OPD';
        if (type === 'instansi') {
            btnText = 'Buka Halaman Input Data Instansi';
        } else if (type === 'bps') {
            btnText = 'Buka Halaman Data BPS';
        }
        linkText.innerText = btnText;
    }

    highlightModalStageButtons(step, isVerifiedByWali, hasSubmitted);

    const logs = getAgencyLogs(code);
    const container = document.getElementById('modalTimelineContainer');
    
    renderModalStageLists(logs);

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

// Stage Stage Names (3 Tahapan Monitoring)
const stageNames = {
    1: 'Input Data',
    2: 'Verifikasi',
    3: 'Validasi BPS'
};

function highlightModalStageButtons(activeStep, isVerifiedByWali = false, hasSubmitted = false) {
    const badge = document.getElementById('modalCurrentStageBadge');
    if (badge) {
        if (activeStep === 3) {
            badge.innerText = 'Tervalidasi BPS';
            badge.className = 'px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-700';
        } else if (isVerifiedByWali || activeStep === 2) {
            badge.innerText = 'Terverifikasi Wali Data';
            badge.className = 'px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800';
        } else if (hasSubmitted) {
            badge.innerText = 'Diteruskan ke Wali Data';
            badge.className = 'px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-orange-100 text-[#f95a00]';
        } else {
            badge.innerText = 'Input Data (Pengisian)';
            badge.className = 'px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-slate-100 text-slate-700';
        }
    }

    // Admin BPS Buttons
    const validateBtn = document.getElementById('modalBpsValidateBtn');
    const unvalidateBtn = document.getElementById('modalBpsUnvalidateBtn');
    const bpsNotice = document.getElementById('modalBpsNotice');

    if (validateBtn && unvalidateBtn) {
        if (activeStep === 3) {
            validateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border-2 border-emerald-600 bg-emerald-600 text-white shadow-2xs transition-all cursor-default flex items-center justify-center space-x-1.5 pointer-events-none opacity-90';
            validateBtn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Sudah Tervalidasi BPS</span>';
            validateBtn.disabled = true;
            unvalidateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-300 text-slate-600 transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs';
            unvalidateBtn.disabled = false;
            if (bpsNotice) bpsNotice.classList.add('hidden');
        } else if (isVerifiedByWali) {
            validateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-emerald-400 bg-emerald-50 hover:bg-emerald-600 hover:text-white text-emerald-800 transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs';
            validateBtn.innerHTML = '<i class="fa-solid fa-check-double"></i><span>Beri Validasi BPS (ACC Selesai)</span>';
            validateBtn.disabled = false;
            unvalidateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-slate-100 text-slate-400 transition-all cursor-not-allowed pointer-events-none flex items-center justify-center space-x-1.5';
            unvalidateBtn.disabled = true;
            if (bpsNotice) bpsNotice.classList.add('hidden');
        } else {
            // Wali Data belum verifikasi: Admin BPS TIDAK BISA validasi
            validateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-amber-200 bg-amber-50/70 text-amber-800 transition-all cursor-not-allowed flex items-center justify-center space-x-1.5 opacity-90';
            validateBtn.innerHTML = '<i class="fa-solid fa-lock text-amber-600"></i><span>Menunggu Verifikasi Wali Data</span>';
            validateBtn.disabled = true;
            unvalidateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-slate-100 text-slate-400 transition-all cursor-not-allowed pointer-events-none flex items-center justify-center space-x-1.5';
            unvalidateBtn.disabled = true;
            if (bpsNotice) bpsNotice.classList.remove('hidden');
        }
    }

    // Wali Data Buttons
    const waliValidateBtn = document.getElementById('modalWaliValidateBtn');
    const waliRejectBtn = document.getElementById('modalWaliRejectBtn');
    const waliNotice = document.getElementById('modalWaliNotice');

    if (waliValidateBtn && waliRejectBtn) {
        if (isVerifiedByWali || activeStep === 3) {
            waliValidateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border-2 border-emerald-600 bg-emerald-600 text-white shadow-2xs transition-all cursor-default flex items-center justify-center space-x-1.5 pointer-events-none opacity-90';
            waliValidateBtn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Sudah Terverifikasi Wali Data</span>';
            waliValidateBtn.disabled = true;
            waliRejectBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-300 text-slate-600 transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs';
            if (waliNotice) waliNotice.classList.add('hidden');
        } else if (hasSubmitted) {
            waliValidateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-[#f95a00] bg-orange-50 hover:bg-[#f95a00] hover:text-white text-[#f95a00] transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs';
            waliValidateBtn.innerHTML = '<i class="fa-solid fa-check"></i><span>Verifikasi Data (Wali Data)</span>';
            waliValidateBtn.disabled = false;
            waliRejectBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-300 text-slate-600 transition-all cursor-pointer flex items-center justify-center space-x-1.5 shadow-2xs';
            if (waliNotice) waliNotice.classList.add('hidden');
        } else {
            waliValidateBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-slate-100 text-slate-400 transition-all cursor-not-allowed flex items-center justify-center space-x-1.5';
            waliValidateBtn.innerHTML = '<i class="fa-solid fa-hourglass-start"></i><span>Menunggu Pengiriman Data</span>';
            waliValidateBtn.disabled = true;
            waliRejectBtn.className = 'px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 bg-slate-100 text-slate-400 transition-all cursor-not-allowed pointer-events-none flex items-center justify-center space-x-1.5';
            if (waliNotice) waliNotice.classList.remove('hidden');
        }
    }
}

function toggleWaliVerification(agencyType, agencyCode, targetStage = 2) {
    if (!confirm('Apakah Anda yakin ingin memverifikasi data instansi ini sebagai Wali Data (Diskominfo)?')) return;
    updateStageQuick(agencyType, agencyCode, targetStage);
}

function changeModalValidasiBps(targetStage) {
    if (!currentModalAgency) return;
    toggleBpsValidation(currentModalAgency.type, currentModalAgency.code, targetStage);
}

function toggleBpsValidation(agencyType, agencyCode, targetStage) {
    const isApproving = (parseInt(targetStage) === 3);
    const confirmMsg = isApproving 
        ? 'Apakah Anda yakin ingin menyetujui Validasi BPS (ACC) untuk dinas/instansi ini?' 
        : 'Apakah Anda yakin ingin membatalkan Validasi BPS?';
    if (!confirm(confirmMsg)) return;

    updateStageQuick(agencyType, agencyCode, targetStage);
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
        const selectedYear = window.monitoringSelectedYear || (new Date().getFullYear());
        const res = await fetch(sbUrl('/monitoring/update-stage'), {
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
    const logs = getAgencyLogs(currentModalAgency.code);
    
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
    const range = { s: { c: 0, r: 0 }, e: { c: 4, r: 4 + totalRows } };

    ws['A1'] = { t: 's', v: title, s: titleStyle };
    ws['B1'] = { t: 's', v: '', s: titleStyle };
    ws['C1'] = { t: 's', v: '', s: titleStyle };
    ws['D1'] = { t: 's', v: '', s: titleStyle };
    ws['E1'] = { t: 's', v: '', s: titleStyle };

    ws['A2'] = { t: 's', v: `Badan Pusat Statistik Kota Bukittinggi | Waktu Unduh: ${downloadDateHeader}`, s: subtitleStyle };
    ws['B2'] = { t: 's', v: '', s: subtitleStyle };
    ws['C2'] = { t: 's', v: '', s: subtitleStyle };
    ws['D2'] = { t: 's', v: '', s: subtitleStyle };
    ws['E2'] = { t: 's', v: '', s: subtitleStyle };

    ws['A3'] = { t: 's', v: '' };
    ws['B3'] = { t: 's', v: '' };
    ws['C3'] = { t: 's', v: '' };
    ws['D3'] = { t: 's', v: '' };
    ws['E3'] = { t: 's', v: '' };

    ws['A4'] = { t: 's', v: 'No', s: headerStyle };
    ws['B4'] = { t: 's', v: 'Instansi / OPD', s: headerStyle };
    ws['C4'] = { t: 's', v: `PERSENTASE MONITORING TAHUN ${tahunLaporan}`, s: headerStyle };
    ws['D4'] = { t: 's', v: '', s: headerStyle };
    ws['E4'] = { t: 's', v: '', s: headerStyle };

    ws['A5'] = { t: 's', v: '', s: headerStyle };
    ws['B5'] = { t: 's', v: '', s: headerStyle };
    ws['C5'] = { t: 's', v: 'Input Data', s: headerStyle };
    ws['D5'] = { t: 's', v: 'Verifikasi Wali Data', s: headerStyle };
    ws['E5'] = { t: 's', v: 'Validasi BPS', s: headerStyle };

    // 3 persentase: Input Data, Verifikasi Wali Data, Validasi BPS (dari status tabel di database)
    const pctStyle = (value) => (value >= 100 ? lengkapStyle : (value > 0 ? belumLengkapStyle : belumTerisiStyle));
    dataset.forEach((item, idx) => {
        const rowNum = idx + 6;
        const pctInput = Number(item.pct_input || 0);
        const pctVerif = Number(item.pct_verif || 0);
        const pctValid = Number(item.pct_valid || 0);

        ws['A' + rowNum] = { t: 'n', v: idx + 1, s: noStyle };
        ws['B' + rowNum] = { t: 's', v: item.full, s: instansiStyle };
        ws['C' + rowNum] = { t: 's', v: `${pctInput}%`, s: pctStyle(pctInput) };
        ws['D' + rowNum] = { t: 's', v: `${pctVerif}%`, s: pctStyle(pctVerif) };
        ws['E' + rowNum] = { t: 's', v: `${pctValid}%`, s: pctStyle(pctValid) };
    });

    ws['!ref'] = XLSX.utils.encode_range(range);
    ws['!merges'] = [
        { s: { r: 0, c: 0 }, e: { r: 0, c: 4 } },
        { s: { r: 1, c: 0 }, e: { r: 1, c: 4 } },
        { s: { r: 3, c: 0 }, e: { r: 4, c: 0 } },
        { s: { r: 3, c: 1 }, e: { r: 4, c: 1 } },
        { s: { r: 3, c: 2 }, e: { r: 3, c: 4 } }
    ];

    ws['!cols'] = [
        { wch: 6 },
        { wch: 55 },
        { wch: 18 },
        { wch: 22 },
        { wch: 18 }
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

