/** SiBingka | table-index | bagian 2/4: clean Ghost Columns
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group). */
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
            const tbody = table.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            let removedAny = false;

            // 1. Bersihkan BARIS HANTU PASTI di semua tabel (duplikasi header, nomor kolom -1, (1), dsb)
            const isYearTable = (typeof currentTableCode === 'string' && (currentTableCode === '4.1.18' || currentTableCode === '4.1.19'));
            rows.forEach(tr => {
                const tds = Array.from(tr.querySelectorAll('td'));
                if (tds.length === 0) return;
                const labelText = tds[0].innerText.trim();

                const isHeaderDuplicate = /^(?:Perguruan\s+Tinggi|College|Mahasiswa|Student|Lulusan|Graduate|Dosen|Lecturer)/i.test(labelText);
                const isColNumberGhost = /^(?:-1|\(1\)|-2|\(2\)|-3|\(3\))$/.test(labelText) || (labelText === '-1' || labelText === '(1)');
                const isInvalidYearRow = isYearTable && !/^(?:19|20)\d{2}$/.test(labelText) && !/^(?:Jumlah|Total)/i.test(labelText);

                if (isHeaderDuplicate || isColNumberGhost || isInvalidYearRow) {
                    tr.remove();
                    removedAny = true;
                }
            });

            // 2. Baris kosong tanpa data untuk tabel biasa (lewati tabel resmi terlindung)
            if (currentTableCode === '2.2.2' || currentTableCode.startsWith('1.1.') || currentTableCode.startsWith('2.3.') || (currentTableCode.startsWith('4.1') && currentTableCode !== '4.1.18' && currentTableCode !== '4.1.19') || currentTableCode.startsWith('5.1.') || currentTableCode.startsWith('5.2.') || currentTableCode.startsWith('8.1.') || currentTableCode.startsWith('8.2.') || currentTableCode === '9.11' || currentOpdCode === '02' || currentOpdCode === '03' || currentOpdCode === '08' || currentOpdCode === '04' || currentOpdCode === '20' || currentOpdCode === '17') {
                if (removedAny) {
                    const savedKey = `sibingka_table_html_${currentTableCode}_${currentYear}`;
                    if (localStorage.getItem(savedKey)) {
                        safeSetLocalStorage(savedKey, table.innerHTML);
                    }
                }
                return;
            }

            const remainingRows = tbody.querySelectorAll('tr');
            remainingRows.forEach(tr => {
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
            try {
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.set('year', currentYear);
                window.history.pushState({}, '', newUrl.toString());
            } catch(e) {}

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
            const url = sbUrl(`/tabel-opd/export-excel?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&type=${encodeURIComponent(currentType)}&template=1`);
            window.location.href = url;
            if (typeof showToast === 'function') {
                showToast(`📥 Mengunduh template Excel Tabel ${currentTableCode} Tahun ${currentYear}...`);
            }
            return;
        }
