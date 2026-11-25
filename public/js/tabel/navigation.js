/**
 * SiBingka Kota Bukittinggi - Table Switcher & Navigation Suite
 * Digunakan bersama oleh index.blade.php dan edit.blade.php
 */

const cfgNav = window.SiBingkaConfig || {};
var currentYear = window.currentYear || cfgNav.currentYear || new Date().getFullYear().toString();
var currentTableCode = window.currentTableCode || cfgNav.currentTableCode || '1.1.6';
var currentOpdCode = window.currentOpdCode || cfgNav.currentOpdCode || '01';
var currentType = window.currentType || cfgNav.currentType || 'opd';

function updateYearSwitcher(isMultiYear, isExcludeSelectedYear) {
    const selectYearEl = document.getElementById('yearSwitcher');
    if (!selectYearEl) return;
    const curYr = window.currentYear || currentYear || new Date().getFullYear().toString();
    const curCode = window.currentTableCode || currentTableCode || '1.1.6';
    const curOpd = window.currentOpdCode || (typeof currentOpdCode !== 'undefined' ? currentOpdCode : '');
    const currentVal = curYr.toString();
    const curYrNum = parseInt(curYr) || 2025;

    // Deteksi rentang tahun dinamis dari tabel nyata di DOM jika ada
    let tableSpanYears = null;
    const tableEl = document.getElementById('tableContainer') ? document.getElementById('tableContainer').querySelector('table') : document.querySelector('table');
    if (tableEl && typeof getActualTablePeriod === 'function') {
        const actP = getActualTablePeriod(tableEl, null);
        if (actP && actP.start && actP.end && actP.end > actP.start) {
            tableSpanYears = actP.end - actP.start; // misal 2027 - 2021 = 6 (rentang 7 tahun)
        }
    }

    // Rentang tahun lengkap sesuai database dari 2036 hingga 2015
    const endYear = Math.max(2036, curYrNum);
    const startYear = Math.min(2015, curYrNum);
    selectYearEl.innerHTML = '';
    for (let y = endYear; y >= startYear; y--) {
        const opt = document.createElement('option');
        opt.value = y.toString();
        let p = (typeof getTablePeriod === 'function') ? getTablePeriod(y, curCode, curOpd) : null;
        if (curCode === '3.1.3') {
            const dynamicStart = y - 12;
            p = { start: dynamicStart, end: y, label: `${dynamicStart}–${y}` };
        } else if (curCode === '4.1.12') {
            const dynamicStart = y - 2;
            p = { start: dynamicStart, end: y, label: `${dynamicStart}–${y}` };
        } else if (curCode === '4.1.11' || curCode === '4.3.3' || curCode === '4.1.20') {
            const dynamicStart = y - 3;
            p = { start: dynamicStart, end: y, label: `${dynamicStart}–${y}` };
        } else if (tableSpanYears !== null && tableSpanYears > 0) {
            const dynamicStart = y - tableSpanYears;
            p = { start: dynamicStart, end: y, label: `${dynamicStart}–${y}` };
        } else if (!p) {
            p = { label: `${y - 4}–${y}` };
        }

        if (isExcludeSelectedYear) {
            opt.textContent = `Tahun ${y} (${y - 5}–${y - 1})`;
        } else if (isMultiYear && p && p.label) {
            opt.textContent = `Tahun ${y} (${p.label})`;
        } else {
            opt.textContent = `Tahun ${y}`;
        }
        if (y.toString() === currentVal) {
            opt.selected = true;
        }
        selectYearEl.appendChild(opt);
    }
    if (![...selectYearEl.options].some(o => o.value === currentVal)) {
        const customOpt = document.createElement('option');
        customOpt.value = currentVal;
        const cNum = parseInt(currentVal);
        let p = (typeof getTablePeriod === 'function') ? getTablePeriod(cNum, curCode, curOpd) : null;
        if (tableSpanYears !== null && tableSpanYears > 0) {
            const dynamicStart = cNum - tableSpanYears;
            p = { start: dynamicStart, end: cNum, label: `${dynamicStart}–${cNum}` };
        } else if (!p) {
            p = { label: `${cNum - 4}–${cNum}` };
        }

        if (isExcludeSelectedYear && !isNaN(cNum)) {
            customOpt.textContent = `Tahun ${currentVal} (${cNum - 5}–${cNum - 1})`;
        } else if (isMultiYear && !isNaN(cNum) && p && p.label) {
            customOpt.textContent = `Tahun ${currentVal} (${p.label})`;
        } else {
            customOpt.textContent = `Tahun ${currentVal}`;
        }
        customOpt.selected = true;
        selectYearEl.insertBefore(customOpt, selectYearEl.firstChild);
    }
    selectYearEl.value = currentVal;
}

function changeTableYear(newYear) {
    if (!newYear) return;
    const cleanYr = newYear.toString().trim();
    const newUrl = new URL(window.location.href);
    newUrl.searchParams.set('year', cleanYr);
    newUrl.searchParams.delete('title');
    newUrl.searchParams.delete('title_en');
    newUrl.searchParams.delete('titleEn');
    newUrl.searchParams.delete('saved');
    window.location.href = newUrl.toString();
}

function updateTableSwitcher() {
    const tableSelect = document.getElementById('tableSwitcher');
    if (!tableSelect) return;

    // Sinkronisasi ulang variabel aktif dari window.current* atau config
    const cfg = window.SiBingkaConfig || {};
    currentTableCode = (window.currentTableCode || currentTableCode || cfg.currentTableCode || '1.1.6').toString().trim().replace(/\.+$/, '');
    currentOpdCode = (window.currentOpdCode || currentOpdCode || cfg.currentOpdCode || '01').toString().trim().padStart(2, '0');
    currentType = (window.currentType || currentType || cfg.currentType || 'opd').toString().trim();
    currentYear = (window.currentYear || currentYear || cfg.currentYear || new Date().getFullYear().toString()).toString().trim();

    if (typeof getAgencyInfoForTable === 'function') {
        const verified = getAgencyInfoForTable(currentTableCode, currentOpdCode, currentType);
        if (verified && verified.opdCode && (verified.opdCode !== currentOpdCode || (verified.type && verified.type !== currentType))) {
            currentOpdCode = verified.opdCode.toString().padStart(2, '0');
            if (verified.type) currentType = verified.type;
            window.currentOpdCode = currentOpdCode;
            window.currentType = currentType;
        }
    }

    let tables = [];
    if (typeof getAgencyTables === 'function') {
        tables = getAgencyTables(currentOpdCode, currentType);
    }
    const cleanOpd = currentOpdCode ? currentOpdCode.toString().padStart(2, '0') : '01';
    if ((!tables || tables.length === 0) && typeof opdTablesCatalog !== 'undefined') {
        const cat = (currentType === 'instansi' && typeof instansiTablesCatalog !== 'undefined') 
            ? instansiTablesCatalog 
            : (currentType === 'bps' && typeof bpsTablesCatalog !== 'undefined' ? bpsTablesCatalog : opdTablesCatalog);
        tables = (cat && cat[cleanOpd]) ? cat[cleanOpd] : [];
    }

    tableSelect.innerHTML = '';

    let currentInList = false;
    if (tables && tables.length > 0) {
        tables.forEach(t => {
            const tCode = (t.code || '').toString().trim().replace(/\.+$/, '');
            const opt = document.createElement('option');
            opt.value = tCode;
            opt.textContent = `Tabel ${tCode} - ${t.title || ''}${t.isCustom ? ' [Tabel Baru]' : ''}`;
            opt.title = `Tabel ${tCode}: ${t.title || ''}`;
            if (tCode === currentTableCode) {
                opt.selected = true;
                currentInList = true;
            }
            tableSelect.appendChild(opt);
        });
    }

    if (!currentInList) {
        const opt = document.createElement('option');
        opt.value = currentTableCode;
        opt.textContent = `Tabel ${currentTableCode}`;
        opt.selected = true;
        tableSelect.insertBefore(opt, tableSelect.firstChild);
    }

    tableSelect.value = currentTableCode;

    const labelEl = document.getElementById('tableSwitcherLabel');
    if (labelEl) {
        labelEl.innerText = `Tabel ${currentTableCode}`;
    }

    const prevBtn = document.getElementById('btnPrevTable');
    const nextBtn = document.getElementById('btnNextTable');
    if (prevBtn && nextBtn) {
        if (tables && tables.length > 0) {
            const curIdx = tables.findIndex(t => (t.code || '').toString().trim().replace(/\.+$/, '') === currentTableCode);
            prevBtn.disabled = curIdx <= 0;
            nextBtn.disabled = curIdx === -1 || curIdx >= tables.length - 1;
        } else {
            prevBtn.disabled = true;
            nextBtn.disabled = true;
        }
    }
}

function changeTableCode(newCode) {
    if (!newCode) return;

    // Sinkronisasi ulang variabel aktif dari window.current* atau config
    const cfg = window.SiBingkaConfig || {};
    currentTableCode = (window.currentTableCode || currentTableCode || cfg.currentTableCode || '1.1.6').toString().trim().replace(/\.+$/, '');
    currentOpdCode = (window.currentOpdCode || currentOpdCode || cfg.currentOpdCode || '01').toString().trim().padStart(2, '0');
    currentType = (window.currentType || currentType || cfg.currentType || 'opd').toString().trim();
    currentYear = (window.currentYear || currentYear || cfg.currentYear || new Date().getFullYear().toString()).toString().trim();

    const cleanNewCode = newCode.toString().trim().replace(/\.+$/, '');
    if (!cleanNewCode || cleanNewCode === currentTableCode) return;

    let targetOpd = currentOpdCode;
    let targetType = currentType || 'opd';
    if (typeof getAgencyInfoForTable === 'function') {
        const info = getAgencyInfoForTable(cleanNewCode, currentOpdCode, currentType);
        if (info && info.opdCode) {
            targetOpd = info.opdCode.toString().padStart(2, '0');
            targetType = info.type || targetType;
        }
    }

    // Tentukan URL target (prioritaskan route resmi SiBingkaConfig agar aman di semua environment)
    let baseUrl = window.location.origin + window.location.pathname;
    if (window.SiBingkaConfig && window.SiBingkaConfig.routes) {
        if (window.isEditMode && window.SiBingkaConfig.routes.editTabel) {
            baseUrl = window.SiBingkaConfig.routes.editTabel;
        } else if (window.SiBingkaConfig.routes.tabelOpd) {
            baseUrl = window.SiBingkaConfig.routes.tabelOpd;
        }
    }

    const newUrl = new URL(baseUrl, window.location.origin);
    newUrl.searchParams.set('code', cleanNewCode);
    newUrl.searchParams.set('opd', targetOpd);
    newUrl.searchParams.set('year', currentYear);
    if (targetType) {
        newUrl.searchParams.set('type', targetType);
    }
    newUrl.searchParams.delete('title');
    newUrl.searchParams.delete('title_en');
    newUrl.searchParams.delete('titleEn');
    newUrl.searchParams.delete('saved');
    if (typeof getCatalogTableInfo === 'function') {
        const info = getCatalogTableInfo(cleanNewCode, targetOpd, targetType);
        if (info && info.title) {
            newUrl.searchParams.set('title', info.title);
        }
        if (info && info.titleEn) {
            newUrl.searchParams.set('title_en', info.titleEn);
        }
    }
    window.location.href = newUrl.toString();
}

function goToAdjacentTable(direction) {
    let tables = [];
    if (typeof getAgencyTables === 'function') {
        tables = getAgencyTables(currentOpdCode, currentType);
    }
    if ((!tables || tables.length === 0) && typeof opdTablesCatalog !== 'undefined') {
        const cleanOpd = currentOpdCode ? currentOpdCode.toString().padStart(2, '0') : '01';
        const cat = (currentType === 'instansi' && typeof instansiTablesCatalog !== 'undefined') 
            ? instansiTablesCatalog 
            : (currentType === 'bps' && typeof bpsTablesCatalog !== 'undefined' ? bpsTablesCatalog : opdTablesCatalog);
        tables = (cat && cat[cleanOpd]) ? cat[cleanOpd] : [];
    }
    if (!tables || tables.length === 0) return;
    const curIdx = tables.findIndex(t => t.code === currentTableCode);
    if (curIdx === -1) return;
    const targetIdx = curIdx + direction;
    if (targetIdx >= 0 && targetIdx < tables.length) {
        changeTableCode(tables[targetIdx].code);
    }
}

function formatTitleWithYear(title, defaultTitle, yLabel) {
    // Khusus Tabel 4.1.2 (Kemenag - RA): 2 Tahun Ajaran Berjalan [yr-1/yr dan yr/yr+1]
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '4.1.2') {
        const yrInt = parseInt(yLabel) || 2025;
        const y1 = `${yrInt - 1}/${yrInt}`;
        const y2 = `${yrInt}/${yrInt + 1}`;
        let raw = (defaultTitle || title || '').trim();
        const cleanBase = raw.replace(/([,\s]+)(19|20)\d{2}.*$/i, '').trim();
        const isEn = (raw.toLowerCase().includes('number') || (typeof schema !== 'undefined' && schema && schema.titleEn && defaultTitle === schema.titleEn));
        return isEn ? `${cleanBase}, ${y1} and ${y2}` : `${cleanBase}, ${y1} dan ${y2}`;
    }

    // Khusus Tabel Pertanahan 1.1.8 & 1.1.9 (7 tahun) & Perguruan Tinggi 4.1.18 & 4.1.19
    if (typeof currentTableCode !== 'undefined' && (currentTableCode === '1.1.8' || currentTableCode === '1.1.9' || currentTableCode === '4.1.18' || currentTableCode === '4.1.19')) {
        let raw = (defaultTitle || title || '').trim();
        const cleanBase = raw.replace(/([,\s]+)(?:19|20)\d{2}(?:\s*[\/–\-]\s*(?:19|20)\d{2})?.*$/i, '').trim();
        return `${cleanBase}, ${yLabel}`;
    }

    // Khusus Tabel 4.1.10 (Kemenag) & Perpustakaan (4.1.21 s.d 4.1.24): cukup satu tahun saja (misal 2026)
    if (typeof currentTableCode !== 'undefined' && (currentTableCode === '4.1.10' || currentTableCode === '4.1.21' || currentTableCode === '4.1.22' || currentTableCode === '4.1.23' || currentTableCode === '4.1.24')) {
        let raw = (defaultTitle || title || '').trim();
        if (raw.trim().toLowerCase() === 'table' || raw.trim().toLowerCase() === 'tabel') {
            raw = (defaultTitle || '').trim();
        }
        const cleanBase = raw.replace(/([,\s]+)(?:19|20)\d{2}(?:\s*[\/–\-]\s*(?:19|20)\d{2})?.*$/i, '').trim();
        return `${cleanBase}, ${yLabel}`;
    }

    // Khusus tabel pendidikan 4.1.x (OPD 08): tahun ajaran SiBingka Bukittinggi = Tahun + 1 (misal 2025 -> 2025/2026)
    if (typeof currentTableCode === 'string' && (currentOpdCode === '08' || currentTableCode.startsWith('4.1')) && currentTableCode !== '4.1.2' && currentTableCode !== '4.1.10' && currentTableCode !== '4.1.11' && currentTableCode !== '4.1.12' && currentTableCode !== '4.1.13' && currentTableCode !== '4.1.14' && currentTableCode !== '4.1.18' && currentTableCode !== '4.1.19' && currentTableCode !== '4.1.20' && currentTableCode !== '4.1.21' && currentTableCode !== '4.1.22' && currentTableCode !== '4.1.23' && currentTableCode !== '4.1.24') {
        const yrInt = parseInt(yLabel) || 2025;
        const acadYr = `${yrInt}/${yrInt + 1}`;
        let raw = (defaultTitle || title || '').trim();
        if (raw.trim().toLowerCase() === 'table' || raw.trim().toLowerCase() === 'tabel') {
            raw = (defaultTitle || '').trim();
        }
        const cleanBase = raw.replace(/([,\s]+)(19|20)\d{2}.*$/i, '').trim();
        return `${cleanBase}, ${acadYr}`;
    }

    // Khusus Tabel 4.1.12 (BPS Susenas - APM dan APK): multi-tahun 3 tahun [yr-2 s.d yr]
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '4.1.12') {
        const yrInt = parseInt(currentYear) || 2025;
        const range = `${yrInt - 2}–${yrInt}`;
        const raw = (defaultTitle || title || '').trim();
        const isEn = raw.toLowerCase().includes('participant') || (typeof schema !== 'undefined' && schema && schema.titleEn && defaultTitle === schema.titleEn);
        if (isEn) {
            return `Participant Rates and Gross Participant Rates by Educational Level in Bukittinggi Municipality, ${range}`;
        } else {
            return `Angka Partisipasi Murni (APM) dan Angka Partisipasi Kasar (APK) Menurut Jenjang Pendidikan di Kota Bukittinggi, ${range}`;
        }
    }

    // Khusus Tabel 4.1.20 (Dispora) & 4.3.3 (BPS PODES): multi-tahun 4 tahun [yr-3 s.d yr]
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '4.1.20') {
        const yrInt = parseInt(currentYear) || 2025;
        const range = `${yrInt - 3}–${yrInt}`;
        const raw = (defaultTitle || title || '').trim();
        const isEn = raw.toLowerCase().includes('sport') || (typeof schema !== 'undefined' && schema && schema.titleEn && defaultTitle === schema.titleEn);
        if (isEn) {
            return `Number of Sport Club in Bukittinggi, ${range}`;
        } else {
            return `Jumlah Klub/Persatuan Olahraga di Kota Bukittinggi, ${range}`;
        }
    }
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '3.1.3') {
        const yrInt = parseInt(currentYear) || 2024;
        const range = `${yrInt - 12}–${yrInt}`;
        const raw = (defaultTitle || title || '').trim();
        const isEn = raw.toLowerCase().includes('population density') || (typeof schema !== 'undefined' && schema && schema.titleEn && defaultTitle === schema.titleEn);
        if (isEn) {
            return `Population, Population Density, and Population Growth Rate ${range}`;
        } else {
            return `Jumlah Penduduk, Kepadatan Penduduk, dan Laju Pertumbuhan Penduduk ${range}`;
        }
    }
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '4.1.11') {
        const yrInt = parseInt(currentYear) || 2025;
        const range = `${yrInt - 3}–${yrInt}`;
        const raw = (defaultTitle || title || '').trim();
        const isEn = raw.toLowerCase().includes('subdistrict') || raw.toLowerCase().includes('educational') || (typeof schema !== 'undefined' && schema && schema.titleEn && defaultTitle === schema.titleEn);
        if (isEn) {
            return `Number of Subdistricts Having Educational Facilities by Subdistrict and Educational Level In Bukittinggi Municipality, ${range}`;
        } else {
            return `Jumlah Kelurahan yang Memiliki Fasilitas Sekolah Menurut Kecamatan dan Tingkat Pendidikan di Kota Bukittinggi, ${range}`;
        }
    }
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '4.3.3') {
        const yrInt = parseInt(currentYear) || 2025;
        const range = `${yrInt - 3}–${yrInt}`;
        const raw = (defaultTitle || title || '').trim();
        const isEn = raw.toLowerCase().includes('subdistrict') || raw.toLowerCase().includes('disaster') || (typeof schema !== 'undefined' && schema && schema.titleEn && defaultTitle === schema.titleEn);
        if (isEn) {
            return `Number of Subdistricts that Have Natural Disaster By District in Bukittinggi Municipality, ${range}`;
        } else {
            return `Jumlah Kelurahan yang Mengalami Bencana Alam Menurut Kecamatan Kota Bukittinggi ${range}`;
        }
    }

    let t = (title && title.trim()) ? title.trim() : (defaultTitle || '');
    if (!t) return '';

    if (t.includes('\n')) {
        const lines = t.split('\n').map(l => l.trim()).filter(Boolean);
        t = lines.join(' ');
    }

    if (t.includes(yLabel)) return t;

    if (/\bTahun\s+Anggaran\b(?!\s+(?:19|20)\d{2})/i.test(t)) {
        return t.replace(/\b(Tahun\s+Anggaran)\b/i, `$1 ${yLabel}`);
    }
    if (/\bYear\b(?!\s+(?:19|20)\d{2})/i.test(t)) {
        return t.replace(/\b(Year)\b/i, `$1 ${yLabel}`);
    }

    const monthYearPattern = /\b(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember|January|February|March|May|June|July|August|October|December)\s+(19|20)\d{2}\b/i;
    if (monthYearPattern.test(t)) {
        return t.replace(monthYearPattern, (m, month) => `${month} ${yLabel}`);
    }

    const rangePattern = /\b(?:19|20)\d{2}\s*[\/–\-]\s*(?:19|20)\d{2}\b/;
    if (rangePattern.test(t)) {
        return t.replace(rangePattern, yLabel);
    }

    const singleYearPattern = /\b(19|20)\d{2}\b/;
    if (singleYearPattern.test(t)) {
        return t.replace(singleYearPattern, yLabel);
    }

    return `${t}, ${yLabel}`;
}

function formatNoteWithYear(note, defaultNote, yLabel) {
    let n = (note !== undefined && note !== null && note.trim() !== '') ? note.trim() : (defaultNote || '');
    if (!n) return '';
    return n;
}

function sanitizeBilingualTitles(rawId, rawEn, defaultId, defaultEn) {
    let cleanId = (rawId || '').trim();
    let cleanEn = (rawEn || '').trim();

    if (cleanId.includes('/')) {
        const parts = cleanId.split('/');
        if (parts.length === 2 && !cleanEn) {
            cleanId = parts[0].trim();
            cleanEn = parts[1].trim();
        }
    }
    return {
        titleId: cleanId || defaultId || '',
        titleEn: cleanEn || defaultEn || ''
    };
}

