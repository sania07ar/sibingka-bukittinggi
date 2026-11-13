/**
 * SiBingka Kota Bukittinggi - Export & Spreadsheet Modal Suite
 * Digunakan untuk export XLSX, PDF, Print Landscape, dan Tampilan Salin Spreadsheet
 */

function toggleExportDropdown(position) {
    const menu = document.getElementById('exportDropdownMenu' + position);
    const chevron = document.getElementById('exportChevron' + position);
    if (!menu) return;

    const isHidden = menu.classList.contains('hidden');
    closeAllExportDropdowns();

    if (isHidden) {
        menu.classList.remove('hidden');
        if (chevron) chevron.classList.add('rotate-180');
    }
}

function closeAllExportDropdowns() {
    ['Top', 'Bottom'].forEach(pos => {
        const menu = document.getElementById('exportDropdownMenu' + pos);
        const chevron = document.getElementById('exportChevron' + pos);
        if (menu) menu.classList.add('hidden');
        if (chevron) chevron.classList.remove('rotate-180');
    });
}

function exportToExcel() {
    const url = `/tabel-opd/export-excel?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&type=${encodeURIComponent(currentType)}`;
    window.location.href = url;
    if (typeof showToast === 'function') {
        showToast(`📥 Mengunduh berkas Excel Tabel ${currentTableCode} Tahun ${currentYear}...`);
    }
}

function exportToPDF() {
    const opdName = (typeof getAgencyName === 'function') ? getAgencyName(currentOpdCode) : currentOpdCode;
    const titleIdEl = document.getElementById('metaTableTitleId');
    const titleEnEl = document.getElementById('metaTableTitleEn');
    const sourceEl = document.getElementById('tableSourceContent');
    const titleId = titleIdEl ? titleIdEl.innerText : '';
    const titleEn = titleEnEl ? titleEnEl.innerText : '';
    const source = sourceEl ? sourceEl.innerText.replace(/<[^>]*>?/gm, '') : '';

    if (window.jspdf && window.jspdf.jsPDF) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'landscape',
            unit: 'mm',
            format: 'a4'
        });

        doc.setFont('helvetica', 'bold');
        doc.setFontSize(13);
        doc.setTextColor(249, 90, 0);
        doc.text('BADAN PUSAT STATISTIK KOTA BUKITTINGGI', 14, 14);

        doc.setFontSize(9.5);
        doc.setTextColor(71, 85, 105);
        doc.setFont('helvetica', 'normal');
        doc.text('Sistem Informasi Bukittinggi dalam Angka (SiBingka) Kota Bukittinggi', 14, 19.5);

        doc.setDrawColor(226, 232, 240);
        doc.setLineWidth(0.4);
        doc.line(14, 22, 283, 22);

        doc.setFont('helvetica', 'bold');
        doc.setFontSize(11);
        doc.setTextColor(15, 23, 42);
        doc.text(`Tabel / Table ${currentTableCode} (${currentYear})`, 14, 29);

        doc.setFontSize(10.5);
        doc.text(titleId, 14, 34);

        doc.setFont('helvetica', 'italic');
        doc.setFontSize(9.5);
        doc.setTextColor(100, 116, 139);
        doc.text(titleEn, 14, 39);

        doc.autoTable({
            html: '#dataDisplayTable',
            startY: 44,
            theme: 'grid',
            headStyles: {
                fillColor: [249, 90, 0],
                textColor: [255, 255, 255],
                fontStyle: 'bold',
                halign: 'center',
                valign: 'middle',
                lineWidth: 0.2,
                lineColor: [51, 65, 85]
            },
            bodyStyles: {
                textColor: [30, 41, 59],
                lineWidth: 0.2,
                lineColor: [51, 65, 85]
            },
            alternateRowStyles: {
                fillColor: [254, 249, 195]
            },
            styles: {
                font: 'helvetica',
                fontSize: 8.5,
                cellPadding: 2.8
            },
            didParseCell: function(data) {
                if (data.cell.raw && data.cell.raw.querySelector) {
                    const ta = data.cell.raw.querySelector('.pma-textarea');
                    if (ta) {
                        data.cell.text = [ta.value.trim()];
                    }
                }
            },
            margin: { left: 14, right: 14 }
        });

        const finalY = doc.lastAutoTable.finalY || 140;

        doc.setFont('helvetica', 'bold');
        doc.setFontSize(8.5);
        doc.setTextColor(51, 65, 85);
        doc.text('Sumber / Source:', 14, finalY + 7);
        doc.setFont('helvetica', 'normal');
        doc.text(source, 42, finalY + 7);

        doc.setFontSize(7.5);
        doc.setTextColor(148, 163, 184);
        doc.text(`Dokumen resmi statistik sektoral diexport melalui SiBingka Kota Bukittinggi pada ${new Date().toLocaleString('id-ID')}`, 14, 198);

        const safeOpd = opdName.substring(0, 20).replace(/[^a-zA-Z0-9]/g, '_');
        const fileName = `Tabel_${currentTableCode.replace(/\./g, '_')}_${safeOpd}_${currentYear}.pdf`;
        doc.save(fileName);
        if (typeof showToast === 'function') {
            showToast(`📕 File PDF (${fileName}) berhasil diunduh!`);
        }
    } else {
        printTableLandscape();
    }
}

function printTableLandscape() {
    const opdName = (typeof getAgencyName === 'function') ? getAgencyName(currentOpdCode) : currentOpdCode;
    const opdSubheading = document.getElementById('printOpdSubheading');
    if (opdSubheading) {
        opdSubheading.innerText = `${currentType === 'instansi' ? 'Instansi' : 'OPD'} Penyelenggara Data: ${currentOpdCode}. ${opdName}`;
    }

    const now = new Date();
    const dateStr = now.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
    const timeStr = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    const tsEl = document.getElementById('printTimestamp');
    if (tsEl) {
        tsEl.innerText = `Waktu Cetak: ${dateStr}, ${timeStr} WIB`;
    }

    closeAllExportDropdowns();
    if (typeof toggleExcelUploadForm === 'function') {
        toggleExcelUploadForm(false);
    }

    setTimeout(() => {
        window.print();
    }, 100);
}

function openSpreadsheetModal() {
    const modal = document.getElementById('spreadsheetModal');
    const card = document.getElementById('spreadsheetModalCard');
    if (!modal || !card) return;

    renderSpreadsheetGrid();

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        card.classList.remove('scale-95', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeSpreadsheetModal() {
    const modal = document.getElementById('spreadsheetModal');
    const card = document.getElementById('spreadsheetModalCard');
    if (!modal || !card) return;

    card.classList.remove('scale-100', 'opacity-100');
    card.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}

function showSpreadsheetToast(title, desc) {
    const toast = document.getElementById('spreadsheetToast');
    if (!toast) return;

    const titleEl = document.getElementById('spreadsheetToastTitle');
    const descEl = document.getElementById('spreadsheetToastDesc');
    if (titleEl && title) titleEl.innerText = title;
    if (descEl && desc) descEl.innerHTML = desc;

    toast.classList.remove('hidden');
    toast.classList.add('flex');
    setTimeout(() => {
        toast.classList.remove('translate-y-4', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    }, 10);

    if (window._ssToastTimer) clearTimeout(window._ssToastTimer);
    window._ssToastTimer = setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove('flex');
        }, 300);
    }, 4000);
}

function getSpreadsheetColLetter(index) {
    let letter = '';
    while (index >= 0) {
        letter = String.fromCharCode((index % 26) + 65) + letter;
        index = Math.floor(index / 26) - 1;
    }
    return letter;
}

function renderSpreadsheetGrid(gridTableId = 'spreadsheetGridTable', activeLabelId = 'spreadsheetActiveCellLabel', formulaInputId = 'spreadsheetFormulaInput', statsInfoId = 'spreadsheetStatsInfo') {
    const origTable = document.getElementById('dataDisplayTable');
    const gridTable = document.getElementById(gridTableId);
    if (!origTable || !gridTable) return;

    const titleId = document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText.trim() : `Tabel ${currentTableCode}`;
    const titleEn = document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText.trim() : '';
    const sourceEl = document.getElementById('tableSourceContent');
    const cleanSource = sourceEl ? sourceEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : '';
    const noteEl = document.getElementById('tableNoteContent');
    const cleanNote = noteEl ? noteEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : '';

    const docTitleEl = document.getElementById('spreadsheetDocTitle');
    if (docTitleEl) {
        docTitleEl.innerText = `Publikasi_Pusat_Tabel_${currentTableCode}_Tahun_${currentYear}`;
    }

    let maxCols = 1;
    origTable.querySelectorAll('tr').forEach(tr => {
        let count = 0;
        tr.querySelectorAll('th, td').forEach(c => {
            count += parseInt(c.getAttribute('colspan') || 1);
        });
        if (count > maxCols) maxCols = count;
    });
    maxCols = Math.max(maxCols, 5);

    let rowCounter = 1;

    let theadHtml = '<thead><tr>';
    theadHtml += '<th class="gs-col-header w-10 min-w-[40px] text-slate-400 font-mono text-[10px] select-none bg-[#f1f3f4]">#</th>';
    for (let c = 0; c < maxCols; c++) {
        theadHtml += `<th class="gs-col-header font-mono select-none">${getSpreadsheetColLetter(c)}</th>`;
    }
    theadHtml += '</tr></thead>';

    let tbodyHtml = '<tbody>';

    tbodyHtml += `<tr>`;
    tbodyHtml += `<td class="gs-row-header font-mono select-none">${rowCounter}</td>`;
    tbodyHtml += `<td colspan="${maxCols}" class="gs-cell font-bold text-slate-900 bg-white" data-cell-name="A${rowCounter}" data-cell-val="${titleId.replace(/"/g, '&quot;')}">${titleId}</td>`;
    tbodyHtml += `</tr>`;
    rowCounter++;

    if (titleEn) {
        tbodyHtml += `<tr>`;
        tbodyHtml += `<td class="gs-row-header font-mono select-none">${rowCounter}</td>`;
        tbodyHtml += `<td colspan="${maxCols}" class="gs-cell italic text-slate-600 bg-white" data-cell-name="A${rowCounter}" data-cell-val="${titleEn.replace(/"/g, '&quot;')}">${titleEn}</td>`;
        tbodyHtml += `</tr>`;
        rowCounter++;
    }

    tbodyHtml += `<tr class="h-3 bg-[#fdfdfd]">`;
    tbodyHtml += `<td class="gs-row-header font-mono select-none text-[9px] text-slate-300">${rowCounter}</td>`;
    for (let c = 0; c < maxCols; c++) {
        tbodyHtml += `<td class="gs-cell bg-[#fafafa]" data-cell-name="${getSpreadsheetColLetter(c)}${rowCounter}" data-cell-val=""></td>`;
    }
    tbodyHtml += `</tr>`;
    rowCounter++;

    const theadRows = origTable.querySelectorAll('thead tr');
    theadRows.forEach((tr) => {
        tbodyHtml += `<tr>`;
        tbodyHtml += `<td class="gs-row-header font-mono select-none text-slate-500 font-bold bg-[#f1f5f9]">${rowCounter}</td>`;
        let colIdx = 0;
        tr.querySelectorAll('th, td').forEach(cell => {
            const colspan = cell.getAttribute('colspan') ? ` colspan="${cell.getAttribute('colspan')}"` : '';
            const rowspan = cell.getAttribute('rowspan') ? ` rowspan="${cell.getAttribute('rowspan')}"` : '';
            let text = cell.innerText.replace(/\r?\n+/g, ' ').trim();
            // Jaminan S2/S3 untuk Tabel 2.2.2 KPU
            if ((typeof currentTableCode !== 'undefined' && currentTableCode === '2.2.2') || origTable.innerText.includes('Partai')) {
                if (/kolom\s*6/i.test(text)) text = 'S2/S3';
            }
            const cellName = `${getSpreadsheetColLetter(colIdx)}${rowCounter}`;
            colIdx += parseInt(cell.getAttribute('colspan') || 1);
            tbodyHtml += `<td class="gs-cell font-bold text-center bg-[#f8fafc] text-slate-800 border-slate-300" ${colspan}${rowspan} data-cell-name="${cellName}" data-cell-val="${text.replace(/"/g, '&quot;')}">${text}</td>`;
        });
        tbodyHtml += `</tr>`;
        rowCounter++;
    });

    const tbodyRows = origTable.querySelectorAll('tbody tr');
    tbodyRows.forEach((tr) => {
        if (tr.classList.contains('subtable-spacer-row')) {
            tbodyHtml += `<tr class="h-4 bg-slate-100">`;
            tbodyHtml += `<td class="gs-row-header font-mono select-none text-[9px] text-slate-400 bg-slate-200">${rowCounter}</td>`;
            tbodyHtml += `<td colspan="${maxCols}" class="gs-cell bg-slate-100 text-slate-400 text-center font-mono text-[10px]" data-cell-name="A${rowCounter}" data-cell-val="">--- Baris Pemisah ---</td>`;
            tbodyHtml += `</tr>`;
            rowCounter++;
            return;
        }

        tbodyHtml += `<tr>`;
        tbodyHtml += `<td class="gs-row-header font-mono select-none">${rowCounter}</td>`;
        let colIdx = 0;
        const cells = tr.querySelectorAll('td, th');
        const isTotalRow = tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total');
        cells.forEach((cell, cIdx) => {
            const colspan = cell.getAttribute('colspan') ? ` colspan="${cell.getAttribute('colspan')}"` : '';
            const rowspan = cell.getAttribute('rowspan') ? ` rowspan="${cell.getAttribute('rowspan')}"` : '';
            let text = cell.innerText.replace(/\r?\n+/g, ' ').trim();
            text = text.replace(/\s*\d+\s*komentar/i, '').trim();

            const isNumeric = (cIdx > 0 && /^[\d\.,\-\s]+$/.test(text)) || cell.classList.contains('text-right') || cell.classList.contains('text-center');
            const alignClass = cIdx === 0 ? 'text-left font-medium' : (isNumeric ? 'text-right font-mono' : 'text-center');
            const boldClass = isTotalRow ? 'font-bold bg-[#f8fafc]' : '';

            const cellName = `${getSpreadsheetColLetter(colIdx)}${rowCounter}`;
            colIdx += parseInt(cell.getAttribute('colspan') || 1);

            tbodyHtml += `<td class="gs-cell ${alignClass} ${boldClass}" ${colspan}${rowspan} data-cell-name="${cellName}" data-cell-val="${text.replace(/"/g, '&quot;')}">${text}</td>`;
        });
        tbodyHtml += `</tr>`;
        rowCounter++;
    });

    if (cleanNote) {
        tbodyHtml += `<tr>`;
        tbodyHtml += `<td class="gs-row-header font-mono select-none text-[9px] text-slate-400">${rowCounter}</td>`;
        tbodyHtml += `<td colspan="${maxCols}" class="gs-cell text-slate-600 italic bg-white" data-cell-name="A${rowCounter}" data-cell-val="Catatan: ${cleanNote.replace(/"/g, '&quot;')}"><strong>Catatan / Note:</strong> ${cleanNote}</td>`;
        tbodyHtml += `</tr>`;
        rowCounter++;
    }
    if (cleanSource) {
        tbodyHtml += `<tr>`;
        tbodyHtml += `<td class="gs-row-header font-mono select-none text-[9px] text-slate-400">${rowCounter}</td>`;
        tbodyHtml += `<td colspan="${maxCols}" class="gs-cell text-slate-700 font-medium bg-white" data-cell-name="A${rowCounter}" data-cell-val="Sumber: ${cleanSource.replace(/"/g, '&quot;')}"><strong>Sumber / Source:</strong> ${cleanSource}</td>`;
        tbodyHtml += `</tr>`;
        rowCounter++;
    }

    tbodyHtml += '</tbody>';
    gridTable.innerHTML = theadHtml + tbodyHtml;

    gridTable.querySelectorAll('.gs-cell').forEach(cell => {
        cell.addEventListener('click', function() {
            gridTable.querySelectorAll('.gs-cell-active').forEach(c => c.classList.remove('gs-cell-active'));
            this.classList.add('gs-cell-active');
            const cellName = this.getAttribute('data-cell-name') || 'A1';
            const cellVal = this.getAttribute('data-cell-val') || this.innerText.trim();
            const activeLabel = document.getElementById(activeLabelId);
            const formulaInput = document.getElementById(formulaInputId);
            if (activeLabel) activeLabel.innerText = cellName;
            if (formulaInput) formulaInput.value = cellVal;
        });
    });

    const firstCell = gridTable.querySelector('.gs-cell');
    if (firstCell) {
        firstCell.classList.add('gs-cell-active');
        const activeLabel = document.getElementById(activeLabelId);
        const formulaInput = document.getElementById(formulaInputId);
        if (activeLabel) activeLabel.innerText = firstCell.getAttribute('data-cell-name') || 'A1';
        if (formulaInput) formulaInput.value = firstCell.getAttribute('data-cell-val') || firstCell.innerText.trim();
    }

    const statsEl = document.getElementById(statsInfoId);
    if (statsEl) {
        statsEl.innerText = `${rowCounter - 1} baris, ${maxCols} kolom siap disalin`;
    }
}

function copyTableForSpreadsheet(dataOnly = false) {
    const table = document.getElementById('dataDisplayTable');
    if (!table) {
        alert('Tabel tidak ditemukan.');
        return;
    }

    const titleId = document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText.trim() : `Tabel ${currentTableCode}`;
    const titleEn = document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText.trim() : '';
    const sourceEl = document.getElementById('tableSourceContent');
    const cleanSource = sourceEl ? sourceEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : '';
    const noteEl = document.getElementById('tableNoteContent');
    const cleanNote = noteEl ? noteEl.innerText.replace(/<[^>]*>?/gm, '').replace(/\s+/g, ' ').trim() : '';

    let maxCols = 1;
    table.querySelectorAll('tr').forEach(tr => {
        let count = 0;
        tr.querySelectorAll('th, td').forEach(c => {
            count += parseInt(c.getAttribute('colspan') || 1);
        });
        if (count > maxCols) maxCols = count;
    });

    let tsvLines = [];
    if (!dataOnly) {
        tsvLines.push(titleId);
        if (titleEn) tsvLines.push(titleEn);
        tsvLines.push('');
        
        table.querySelectorAll('thead tr').forEach(tr => {
            let rowVals = [];
            tr.querySelectorAll('th, td').forEach(cell => {
                let text = (cell.innerText || '').replace(/\r?\n+/g, ' ').trim();
                if ((typeof currentTableCode !== 'undefined' && currentTableCode === '2.2.2') || table.innerText.includes('Partai')) {
                    if (/kolom\s*6/i.test(text)) text = 'S2/S3';
                }
                const colspan = parseInt(cell.getAttribute('colspan') || 1);
                rowVals.push(text);
                for (let i = 1; i < colspan; i++) rowVals.push('');
            });
            tsvLines.push(rowVals.join('\t'));
        });
    }

    table.querySelectorAll('tbody tr').forEach(tr => {
        if (tr.classList.contains('subtable-spacer-row')) {
            tsvLines.push('');
            return;
        }
        let rowVals = [];
        tr.querySelectorAll('th, td').forEach(cell => {
            let text = (cell.innerText || '').replace(/\r?\n+/g, ' ').trim();
            text = text.replace(/\s*\d+\s*komentar/i, '').trim();
            const colspan = parseInt(cell.getAttribute('colspan') || 1);
            rowVals.push(text);
            for (let i = 1; i < colspan; i++) rowVals.push('');
        });
        tsvLines.push(rowVals.join('\t'));
    });

    if (!dataOnly) {
        if (cleanNote) {
            tsvLines.push('');
            tsvLines.push('Catatan: ' + cleanNote);
        }
        if (cleanSource) {
            tsvLines.push('Sumber: ' + cleanSource);
        }
    }
    const fullTsv = tsvLines.join('\r\n');

    let cleanHtml = `<table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10pt; color: #000000;">`;
    if (!dataOnly) {
        cleanHtml += `<tr><td colspan="${maxCols}" style="font-weight: bold; font-size: 11pt; border: none; padding: 4px 0;">${titleId}</td></tr>`;
        if (titleEn) {
            cleanHtml += `<tr><td colspan="${maxCols}" style="font-style: italic; color: #475569; border: none; padding: 2px 0 6px 0;">${titleEn}</td></tr>`;
        }
        cleanHtml += `<tr><td colspan="${maxCols}" style="border: none; height: 6px;"></td></tr>`;

        table.querySelectorAll('thead tr').forEach(tr => {
            cleanHtml += `<tr>`;
            tr.querySelectorAll('th, td').forEach(cell => {
                const colspan = cell.getAttribute('colspan') ? ` colspan="${cell.getAttribute('colspan')}"` : '';
                const rowspan = cell.getAttribute('rowspan') ? ` rowspan="${cell.getAttribute('rowspan')}"` : '';
                let text = cell.innerText.replace(/\r?\n+/g, ' ').trim();
                if ((typeof currentTableCode !== 'undefined' && currentTableCode === '2.2.2') || table.innerText.includes('Partai')) {
                    if (/kolom\s*6/i.test(text)) text = 'S2/S3';
                }
                cleanHtml += `<th${colspan}${rowspan} style="background-color: #f1f5f9; font-weight: bold; text-align: center; border: 1px solid #94a3b8; padding: 5px;">${text}</th>`;
            });
            cleanHtml += `</tr>`;
        });
    }

    table.querySelectorAll('tbody tr').forEach(tr => {
        if (tr.classList.contains('subtable-spacer-row')) {
            cleanHtml += `<tr><td colspan="${maxCols}" style="border: 1px solid #e2e8f0; height: 8px; background-color: #f8fafc;"></td></tr>`;
            return;
        }
        cleanHtml += `<tr>`;
        const isTotal = tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total');
        tr.querySelectorAll('th, td').forEach((cell, cIdx) => {
            const colspan = cell.getAttribute('colspan') ? ` colspan="${cell.getAttribute('colspan')}"` : '';
            const rowspan = cell.getAttribute('rowspan') ? ` rowspan="${cell.getAttribute('rowspan')}"` : '';
            let text = cell.innerText.replace(/\r?\n+/g, ' ').trim();
            text = text.replace(/\s*\d+\s*komentar/i, '').trim();
            const isNumeric = (cIdx > 0 && /^[\d\.,\-\s]+$/.test(text));
            const align = cIdx === 0 ? 'left' : (isNumeric ? 'right' : 'center');
            const bold = isTotal ? 'font-weight: bold; background-color: #f1f5f9;' : '';
            cleanHtml += `<td${colspan}${rowspan} style="text-align: ${align}; border: 1px solid #cbd5e1; padding: 4px 6px; ${bold}">${text}</td>`;
        });
        cleanHtml += `</tr>`;
    });

    if (!dataOnly) {
        if (cleanNote) {
            cleanHtml += `<tr><td colspan="${maxCols}" style="border: none; padding-top: 8px; font-style: italic; color: #475569;"><strong>Catatan:</strong> ${cleanNote}</td></tr>`;
        }
        if (cleanSource) {
            cleanHtml += `<tr><td colspan="${maxCols}" style="border: none; padding-top: 2px; color: #334155;"><strong>Sumber:</strong> ${cleanSource}</td></tr>`;
        }
    }
    cleanHtml += `</table>`;

    if (navigator.clipboard && window.ClipboardItem) {
        const textBlob = new Blob([fullTsv], { type: 'text/plain' });
        const htmlBlob = new Blob([cleanHtml], { type: 'text/html' });
        navigator.clipboard.write([
            new ClipboardItem({
                'text/plain': textBlob,
                'text/html': htmlBlob
            })
        ]).then(() => {
            showSpreadsheetToast(
                dataOnly ? 'Data Angka Berhasil Disalin!' : 'Seluruh Tabel Berhasil Disalin!',
                'Format spreadsheet siap ditempel. Buka Google Sheets atau Publikasi Pusat lalu tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-400 font-mono text-[10px] font-bold">Ctrl + V</kbd>'
            );
        }).catch(() => {
            fallbackCopySpreadsheetText(fullTsv);
            showSpreadsheetToast(
                dataOnly ? 'Data Angka Berhasil Disalin!' : 'Seluruh Tabel Berhasil Disalin!',
                'Format teks TSV siap ditempel dengan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-400 font-mono text-[10px] font-bold">Ctrl + V</kbd>'
            );
        });
    } else {
        fallbackCopySpreadsheetText(fullTsv);
        showSpreadsheetToast(
            dataOnly ? 'Data Angka Berhasil Disalin!' : 'Seluruh Tabel Berhasil Disalin!',
            'Format teks TSV siap ditempel dengan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-400 font-mono text-[10px] font-bold">Ctrl + V</kbd>'
        );
    }
}

function fallbackCopySpreadsheetText(text) {
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.style.position = 'fixed';
    ta.style.left = '-9999px';
    ta.style.top = '-9999px';
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    try {
        document.execCommand('copy');
    } catch (e) {
        console.error('Fallback copy failed', e);
    }
    document.body.removeChild(ta);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('spreadsheetModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeSpreadsheetModal();
        }
    }
});

