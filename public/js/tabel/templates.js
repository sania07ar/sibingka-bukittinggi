/**
 * SiBingka Kota Bukittinggi - Table Templates Generator
 * Membangun struktur template kosong dari data tahun sebelumnya
 */

function buildEmptyTemplateFromSource(sourceHtml, targetYear, sourceYear) {
    if (!sourceHtml) return null;
    if (typeof currentTableCode !== 'undefined') {
        if (currentTableCode === '1.1.8' && window.tableSchemas && window.tableSchemas['1.1.8']) {
            return window.tableSchemas['1.1.8'].render(targetYear);
        }
        if (currentTableCode === '1.1.6' && window.tableSchemas && window.tableSchemas['1.1.6']) {
            return window.tableSchemas['1.1.6'].render(targetYear);
        }
        if (currentTableCode === '2.2.2' && window.tableSchemas && window.tableSchemas['2.2.2']) {
            return window.tableSchemas['2.2.2'].render(targetYear);
        }
        if (currentTableCode === '4.1.2' && window.tableSchemas && window.tableSchemas['4.1.2']) {
            return window.tableSchemas['4.1.2'].render(targetYear);
        }
        if (currentTableCode.startsWith('4.1') && window.tableSchemas && window.tableSchemas[currentTableCode]) {
            return window.tableSchemas[currentTableCode].render(targetYear);
        }
        if ((currentTableCode === '5.2.1' || currentTableCode === '5.2.2') && window.tableSchemas && window.tableSchemas[currentTableCode]) {
            return window.tableSchemas[currentTableCode].render(targetYear);
        }
        if (currentTableCode === '8.1.6' && window.tableSchemas && window.tableSchemas['8.1.6']) {
            return window.tableSchemas['8.1.6'].render(targetYear);
        }
    }
    const tempTable = document.createElement('table');
    tempTable.innerHTML = sourceHtml;

    // 1. thead: Ganti tahun lama di header jika ada teks tahun eksplisit
    if (sourceYear && targetYear && sourceYear.toString() !== targetYear.toString()) {
        const theadThs = tempTable.querySelectorAll('thead th');
        const delta = parseInt(targetYear) - parseInt(sourceYear);
        theadThs.forEach(th => {
            if (/\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(th.innerText)) {
                th.innerHTML = th.innerHTML.replace(/\b((?:19|20)\d{2})\s*\/\s*((?:19|20)\d{2})\b/g, (m, y1, y2) => {
                    return `${parseInt(y1) + delta}/${parseInt(y2) + delta}`;
                });
            } else if (/\b(?:19|20)\d{2}\s*[–\-]\s*(?:19|20)\d{2}\b/.test(th.innerText)) {
                th.innerHTML = th.innerHTML.replace(/\b((?:19|20)\d{2})\s*[–\-]\s*((?:19|20)\d{2})\b/g, (m, y1, y2) => {
                    return `${parseInt(y1) + delta}–${parseInt(y2) + delta}`;
                });
            } else if (/\b(19\d{2}|20\d{2})\b/.test(th.innerText)) {
                th.innerHTML = th.innerHTML.replace(/\b(19\d{2}|20\d{2})\b/g, (m) => {
                    return (parseInt(m, 10) + delta).toString();
                });
            }
        });
    }

    // 2. tbody: Kosongkan sel data nilai angka, tetapi pertahankan baris indikator / jabatan
    const tbodyRows = tempTable.querySelectorAll('tbody tr');
    tbodyRows.forEach(tr => {
        const tds = tr.querySelectorAll('td');
        if (tds.length === 0) return;

        tds.forEach((td, colIdx) => {
            // Kolom pertama selalu merupakan label indikator/jabatan/kategori
            if (colIdx === 0) return;

            // Jika sel memiliki colspan besar yang membentang hampir seluruh kolom, jangan diubah
            const colspan = parseInt(td.getAttribute('colspan') || '1', 10);
            if (colspan >= 2) {
                const text = td.innerText.trim();
                if (/[a-zA-Z]{3,}/.test(text)) {
                    return;
                }
            }

            // Jika sel memiliki rowspan dan berisi teks (bukan angka), jangan diubah
            if (td.hasAttribute('rowspan')) {
                const text = td.innerText.trim();
                if (/[a-zA-Z]{3,}/.test(text) && !/^\d+$/.test(text)) {
                    return;
                }
            }

            // Jangan timpa label tahun (misal: 2024, 2025, 2022(SIUP)) menjadi strip '-'
            const rawText = td.innerText.trim();
            if (/^(?:19|20)\d{2}(?:\s*\(.*\))?$/.test(rawText)) {
                return;
            }

            // Periksa apakah isi sel adalah angka murni, tanda strip, atau nilai kosong
            const cleanText = rawText.replace(/[.,\s]/g, '');
            const isNumericOrDash = /^-?\d+(\.\d+)?$/.test(cleanText) || rawText === '-' || rawText === '–' || rawText === '—' || rawText === '' || rawText === '...';
            if (isNumericOrDash) {
                td.innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                td.className = 'py-2.5 px-4 text-center border border-slate-700 align-middle font-normal';
            }
        });
    });

    // 3. Penanganan Khusus untuk Tabel Tertentu:
    // Khusus tabel 11.2: atur 6 rentang tahun historis pada bagian Jumlah [targetYear, targetYear - 1, ... targetYear - 5]
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '11.2' && targetYear) {
        const tYr = parseInt(targetYear);
        const tbody = tempTable.querySelector('tbody');
        if (tbody) {
            const allTrs = Array.from(tbody.querySelectorAll('tr'));
            const jumlahIdx = allTrs.findIndex(tr => tr.innerText.toLowerCase().includes('jumlah'));
            if (jumlahIdx !== -1) {
                // Perbarui 6 baris tahun historis
                for (let i = 0; i < 6; i++) {
                    const rowIdx = jumlahIdx + i;
                    const expectedYr = tYr - i;
                    if (rowIdx < allTrs.length) {
                        const tr = allTrs[rowIdx];
                        const firstTd = tr.querySelector('td');
                        if (firstTd) {
                            if (i === 0) {
                                firstTd.innerHTML = `Jumlah / <i>Total</i> ${expectedYr}`;
                            } else {
                                firstTd.innerHTML = `${expectedYr}`;
                            }
                        }
                    }
                }
            }
        }
    }

    // Khusus tabel 9.11 (Dinas Pertanian): atur 5 rentang tahun historis pada bagian Rata-rata [targetYear - 4 s.d targetYear]
    if (typeof currentTableCode !== 'undefined' && currentTableCode === '9.11' && targetYear) {
        const tYr = parseInt(targetYear);
        const tbody = tempTable.querySelector('tbody');
        if (tbody) {
            const allTrs = Array.from(tbody.querySelectorAll('tr'));
            const rataIdx = allTrs.findIndex(tr => tr.innerText.toLowerCase().includes('rata-rata') || tr.innerText.toLowerCase().includes('average'));
            if (rataIdx !== -1) {
                for (let i = 0; i < 5; i++) {
                    const rowIdx = rataIdx + i;
                    const expectedYr = (tYr - 4) + i;
                    if (rowIdx < allTrs.length) {
                        const tr = allTrs[rowIdx];
                        const firstTd = tr.querySelector('td');
                        if (firstTd) {
                            if (i === 0) {
                                firstTd.innerHTML = `Rata-rata / <i>Average</i> ${expectedYr}`;
                            } else {
                                firstTd.innerHTML = `${expectedYr}`;
                            }
                        }
                    }
                }
            }
        }
    }

    // Khusus tabel pariwisata 7.3, 7.4, 7.5 (Dinas Pariwisata): atur 5 rentang tahun historis pada bagian Jumlah [targetYear - 4 s.d targetYear]
    if (typeof currentTableCode !== 'undefined' && (currentTableCode === '7.3' || currentTableCode === '7.4' || currentTableCode === '7.5') && targetYear) {
        const tYr = parseInt(targetYear);
        const tbody = tempTable.querySelector('tbody');
        if (tbody) {
            const allTrs = Array.from(tbody.querySelectorAll('tr'));
            const jumlahIdx = allTrs.findIndex(tr => tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total'));
            if (jumlahIdx !== -1) {
                for (let i = 0; i < 5; i++) {
                    const rowIdx = jumlahIdx + i;
                    const expectedYr = (tYr - 4) + i;
                    if (rowIdx < allTrs.length) {
                        const tr = allTrs[rowIdx];
                        const firstTd = tr.querySelector('td');
                        if (firstTd) {
                            if (i === 0) {
                                firstTd.innerHTML = `Jumlah / <i>Total</i> ${expectedYr}`;
                            } else {
                                firstTd.innerHTML = `${expectedYr}`;
                            }
                        }
                    }
                }
            }
        }
    }

    return tempTable.innerHTML;
}

