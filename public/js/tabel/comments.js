/**
 * SiAngka Kota Bukittinggi - Cell Comments & Discussions Suite
 * Digunakan bersama oleh index.blade.php dan edit.blade.php
 */

let tableCommentsMap = {};
let activeCellKey = null;
let activeCellLabel = null;
let activeCellValue = null;

function getHeaderTitleForCol(colIdx) {
    const table = document.getElementById('dataDisplayTable');
    if (!table) return `Kolom ${colIdx + 1}`;

    // Khusus Tabel 2.2.2 (KPU Bukittinggi: Partai & Pendidikan)
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '2.2.2') {
        const titles222 = ['Partai', 'SMU', 'DIII', 'DIV / S1', 'S2/S3', 'Jumlah'];
        if (titles222[colIdx]) return titles222[colIdx];
    }
    // Khusus Tabel 4.1.2 (Kemenag Bukittinggi: Raudatul Athfal 2 tahun berjalan)
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '4.1.2') {
        const yr = parseInt(currentYear) || 2025;
        const titles412 = [
            'Kecamatan', 
            `Sekolah ${yr - 1}/${yr}`, `Sekolah ${yr}/${yr + 1}`,
            `Guru ${yr - 1}/${yr}`, `Guru ${yr}/${yr + 1}`,
            `Murid ${yr - 1}/${yr}`, `Murid ${yr}/${yr + 1}`
        ];
        if (titles412[colIdx]) return titles412[colIdx];
    }

    const theadRows = table.querySelectorAll('thead tr');
    if (theadRows.length === 0) return `Kolom ${colIdx + 1}`;

    // Bangun pemetaan matriks kolom sebenarnya untuk menangani colspan & rowspan
    const matrix = [];
    theadRows.forEach((tr, rIdx) => {
        if (!matrix[rIdx]) matrix[rIdx] = [];
        let cIdx = 0;
        tr.querySelectorAll('th, td').forEach(cell => {
            while (matrix[rIdx][cIdx]) { cIdx++; }
            const rSpan = parseInt(cell.getAttribute('rowspan') || 1);
            const cSpan = parseInt(cell.getAttribute('colspan') || 1);
            const text = cell.innerText.replace(/[\n\r]+/g, ' ').replace(/\s+/g, ' ').trim();
            for (let r = 0; r < rSpan; r++) {
                if (!matrix[rIdx + r]) matrix[rIdx + r] = [];
                for (let c = 0; c < cSpan; c++) {
                    matrix[rIdx + r][cIdx + c] = text;
                }
            }
            cIdx += cSpan;
        });
    });

    // Cari dari baris thead paling bawah ke atas untuk colIdx
    for (let r = matrix.length - 1; r >= 0; r--) {
        const t = matrix[r] ? matrix[r][colIdx] : '';
        if (t && !t.startsWith('(') && !/^kolom\s*\d+$/i.test(t)) {
            if ((typeof currentTableCode !== 'undefined' && currentTableCode === '2.2.2') || t.includes('Partai')) {
                if (/kolom\s*6/i.test(t)) return 'S2/S3';
            }
            return t;
        }
    }
    return `Kolom ${colIdx + 1}`;
}

async function loadTableComments() {
    try {
        const apiUrl = window.commentsApiUrl || '/api/tabel-opd/comments';
        const res = await fetch(`${apiUrl}?table_code=${encodeURIComponent(currentTableCode)}&opd_code=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}`);
        if (!res.ok) return;
        const json = await res.json();
        tableCommentsMap = json.grouped || {};
        renderCellCommentBadges();
    } catch (err) {
        console.warn('Gagal memuat catatan tabel:', err);
    }
}

function renderCellCommentBadges() {
    const table = document.getElementById('dataDisplayTable');
    if (!table) return;
    const bodyRows = table.querySelectorAll('tbody tr');

    let totalComments = 0;
    Object.values(tableCommentsMap).forEach(arr => {
        if (Array.isArray(arr)) totalComments += arr.length;
    });
    const badgeTotalEl = document.getElementById('headerTotalCommentsCount');
    if (badgeTotalEl) badgeTotalEl.innerText = totalComments;

    bodyRows.forEach((tr, rIdx) => {
        const rowKey = tr.getAttribute('data-key') || ('row_' + rIdx);
        const tds = tr.querySelectorAll('td');
        if (tds.length === 0) return;

        const firstTdText = tds[0].innerText.replace(/[\n\r]+/g, ' ').replace(/\s+/g, ' ').trim();

        tds.forEach((td, cIdx) => {
            if (cIdx === 0 && tds.length > 1) return;

            const cellKey = `${rowKey}_col_${cIdx}`;
            td.setAttribute('data-cell-key', cellKey);
            td.classList.add('relative', 'group');

            const colTitle = getHeaderTitleForCol(cIdx);
            const cellLabel = `${firstTdText} • ${colTitle}`;

            const existingBadge = td.querySelector('.cell-comment-badge-wrap');
            if (existingBadge) existingBadge.remove();

            const comments = tableCommentsMap[cellKey] || [];
            const count = comments.length;

            const inputEl = td.querySelector('input');
            const cellVal = inputEl ? inputEl.value : td.innerText.replace(/[\n\r]+/g, ' ').trim();

            const badgeWrap = document.createElement('span');
            badgeWrap.className = 'cell-comment-badge-wrap inline-flex items-center align-middle ml-1.5';

            const oldPin = td.querySelector('.cell-comment-corner-pin');
            if (oldPin) oldPin.remove();

            if (count > 0) {
                td.classList.add('bg-amber-100/80', 'ring-1', 'ring-orange-400');
                td.classList.remove('bg-orange-50/70', 'ring-orange-300');

                const cornerPin = document.createElement('span');
                cornerPin.className = 'cell-comment-corner-pin absolute top-0 right-0 w-2 h-2 bg-[#f95a00] rounded-bl-sm pointer-events-none';
                td.appendChild(cornerPin);

                badgeWrap.innerHTML = `
                    <button type="button" onclick="event.stopPropagation(); openCellCommentDrawer('${cellKey}', '${safeEscapeHtml(cellLabel)}', '${safeEscapeHtml(cellVal)}')"
                        class="inline-flex items-center space-x-1 px-1.5 py-0.5 rounded-full bg-[#f95a00] hover:bg-[#ea5300] text-white font-extrabold text-[10px] shadow-2xs transition-all transform hover:scale-105 cursor-pointer"
                        title="${count} Catatan Aktif (Klik untuk buka diskusi)">
                        <i class="fa-solid fa-comment-dots text-[9px]"></i>
                        <span>${count}</span>
                    </button>
                `;
            } else {
                td.classList.remove('bg-amber-100/80', 'ring-1', 'ring-orange-400', 'bg-orange-50/70', 'ring-orange-300');
                badgeWrap.innerHTML = `
                    <button type="button" onclick="event.stopPropagation(); openCellCommentDrawer('${cellKey}', '${safeEscapeHtml(cellLabel)}', '${safeEscapeHtml(cellVal)}')"
                        class="opacity-0 group-hover:opacity-100 transition-opacity p-0.5 text-slate-400 hover:text-[#f95a00] cursor-pointer"
                        title="Beri catatan / komentar pada data ini">
                        <i class="fa-regular fa-comment text-[10px]"></i>
                    </button>
                `;
            }

            td.appendChild(badgeWrap);
        });
    });
}

function openTableCommentOverview() {
    const table = document.getElementById('dataDisplayTable');
    const keysWithComments = Object.keys(tableCommentsMap);
    if (keysWithComments.length > 0) {
        const firstKey = keysWithComments[0];
        const list = tableCommentsMap[firstKey] || [];
        const first = list[0] || {};
        openCellCommentDrawer(firstKey, first.cell_label || 'Rincian Data', first.cell_value || '-');
    } else if (table) {
        const firstTd = table.querySelector('tbody tr td[data-cell-key]');
        if (firstTd) {
            const k = firstTd.getAttribute('data-cell-key');
            const row = firstTd.closest('tr');
            const rowLabel = row ? row.querySelector('td').innerText.trim() : 'Rincian';
            const cIdx = Array.from(row.children).indexOf(firstTd);
            const colTitle = getHeaderTitleForCol(cIdx);
            const inputEl = firstTd.querySelector('input');
            const val = inputEl ? inputEl.value : firstTd.innerText.trim();
            openCellCommentDrawer(k, `${rowLabel} • ${colTitle}`, val);
        } else {
            openCellCommentDrawer(`table_${currentTableCode}_general`, `Tabel ${currentTableCode} (${currentYear})`, '-');
        }
    } else {
        openCellCommentDrawer(`table_${currentTableCode}_general`, `Tabel ${currentTableCode} (${currentYear})`, '-');
    }
}

function openCellCommentDrawer(cellKey, cellLabel, cellValue) {
    activeCellKey = cellKey;
    activeCellLabel = cellLabel || 'Rincian Data';
    activeCellValue = cellValue || '-';

    const labelEl = document.getElementById('drawerCellLabel');
    if (labelEl) {
        labelEl.innerText = activeCellLabel;
        labelEl.title = activeCellLabel;
    }

    const valEl = document.getElementById('drawerCellValue');
    if (valEl) {
        valEl.innerText = activeCellValue || '-';
    }

    renderDrawerStream();

    const drawer = document.getElementById('cellCommentDrawer');
    const backdrop = document.getElementById('cellCommentDrawerBackdrop');
    if (drawer) drawer.classList.remove('translate-x-full');
    if (backdrop) backdrop.classList.remove('opacity-0', 'pointer-events-none');

    setTimeout(() => {
        const input = document.getElementById('drawerCommentInput');
        if (input) input.focus();
    }, 200);
}

function closeCellCommentDrawer() {
    const drawer = document.getElementById('cellCommentDrawer');
    const backdrop = document.getElementById('cellCommentDrawerBackdrop');
    if (drawer) drawer.classList.add('translate-x-full');
    if (backdrop) backdrop.classList.add('opacity-0', 'pointer-events-none');
    activeCellKey = null;
}

function renderDrawerStream() {
    const stream = document.getElementById('drawerCommentsStream');
    const countBadge = document.getElementById('drawerCommentCountBadge');
    if (!stream) return;

    const comments = (activeCellKey && tableCommentsMap[activeCellKey]) ? tableCommentsMap[activeCellKey] : [];
    if (countBadge) {
        countBadge.innerText = `${comments.length} catatan`;
    }

    if (comments.length === 0) {
        stream.innerHTML = `
            <div class="my-auto py-8 px-4 text-center">
                <div class="border border-dashed border-slate-300 rounded-2xl p-6 text-center bg-white shadow-2xs max-w-sm mx-auto">
                    <div class="w-14 h-14 rounded-full bg-orange-100/80 text-[#f95a00] flex items-center justify-center mx-auto mb-3.5 shadow-2xs">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm mb-1.5">Tidak ada catatan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed max-w-[240px] mx-auto">
                        Belum ada catatan untuk rincian ini. Silakan tulis komentar atau keterangan angka di bawah.
                    </p>
                </div>
            </div>
        `;
    } else {
        let html = '<div class="space-y-3">';
        const curUser = window.currentUserData || {};
        comments.forEach(c => {
            const isAdmin = (c.user_role === 'admin');
            const roleBadgeClass = isAdmin ? 'bg-orange-100 text-orange-800' : 'bg-emerald-100 text-emerald-800';
            const roleLabel = isAdmin ? 'BPS' : (c.user_role === 'instansi' ? 'INSTANSI' : 'OPD');
            const dateFormatted = c.created_at ? new Date(c.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '';
            const canDelete = (curUser.role === 'admin') || (curUser.name === c.user_name) || (curUser.displayName === c.user_name);

            html += `
                <div class="p-3.5 rounded-xl bg-white border border-slate-200/90 shadow-2xs space-y-1.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center space-x-1.5 min-w-0">
                            <span class="font-bold text-slate-900 text-xs truncate">${safeEscapeHtml(c.user_name)}</span>
                            <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded ${roleBadgeClass}">${roleLabel}</span>
                        </div>
                        <span class="text-[10px] text-slate-400 shrink-0">${dateFormatted}</span>
                    </div>
                    <p class="text-xs text-slate-700 whitespace-pre-wrap leading-relaxed">${safeEscapeHtml(c.comment)}</p>
                    ${canDelete ? `
                        <div class="text-right pt-1 border-t border-slate-100">
                            <button type="button" onclick="deleteCommentItem(${c.id})" class="text-[10px] text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                <i class="fa-solid fa-trash-can text-[9px] mr-1"></i>Hapus
                            </button>
                        </div>
                    ` : ''}
                </div>
            `;
        });
        html += '</div>';
        stream.innerHTML = html;

        setTimeout(() => {
            stream.scrollTop = stream.scrollHeight;
        }, 50);
    }
}

async function handleSendComment(e) {
    if (e && e.preventDefault) e.preventDefault();
    if (!activeCellKey) return;
    const input = document.getElementById('drawerCommentInput');
    const commentText = input ? input.value.trim() : '';
    if (!commentText) return;

    const btn = document.getElementById('btnSubmitDrawerComment');
    if (btn) btn.disabled = true;

    try {
        const saveUrl = window.saveCommentApiUrl || '/api/tabel-opd/comments';
        const csrfToken = window.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const res = await fetch(saveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                table_code: currentTableCode,
                opd_code: currentOpdCode,
                year: parseInt(currentYear) || 2025,
                cell_key: activeCellKey,
                cell_label: activeCellLabel,
                cell_value: activeCellValue,
                comment: commentText
            })
        });

        const data = await res.json();
        if (data.status === 'success') {
            if (input) input.value = '';
            if (!tableCommentsMap[activeCellKey]) {
                tableCommentsMap[activeCellKey] = [];
            }
            tableCommentsMap[activeCellKey].push(data.data);
            renderDrawerStream();
            renderCellCommentBadges();
            if (typeof showToast === 'function') showToast('Catatan berhasil dikirim!');
        } else {
            alert('Gagal mengirim catatan: ' + (data.message || 'Terjadi kesalahan.'));
        }
    } catch (err) {
        console.error('Error sending comment:', err);
        alert('Gagal mengirim catatan. Periksa koneksi Anda.');
    } finally {
        if (btn) btn.disabled = false;
    }
}

async function deleteCommentItem(id) {
    if (!confirm('Hapus catatan ini?')) return;
    try {
        const csrfToken = window.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const res = await fetch(`/api/tabel-opd/comments/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        const data = await res.json();
        if (data.status === 'success') {
            if (activeCellKey && tableCommentsMap[activeCellKey]) {
                tableCommentsMap[activeCellKey] = tableCommentsMap[activeCellKey].filter(c => c.id !== id);
                if (tableCommentsMap[activeCellKey].length === 0) {
                    delete tableCommentsMap[activeCellKey];
                }
            }
            renderDrawerStream();
            renderCellCommentBadges();
            if (typeof showToast === 'function') showToast('Catatan berhasil dihapus.');
        } else {
            alert('Gagal menghapus catatan: ' + (data.message || 'Terjadi kesalahan.'));
        }
    } catch (err) {
        console.error('Error deleting comment:', err);
        alert('Gagal menghapus catatan.');
    }
}

window.loadTableComments = loadTableComments;
window.fetchTableComments = loadTableComments;


