/** SiBingka | table-editor | bagian 3/6: clean Ghost Columns
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
                bodyRows.forEach(tr => {
                    const tds = tr.querySelectorAll('td');
                    if (tds.length >= 2) {
                        tds[tds.length - 1].remove();
                    }
                });

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

                const savedKey = `sibingka_table_html_${currentTableCode}_${currentYear}`;
                if (localStorage.getItem(savedKey)) {
                    safeSetLocalStorage(savedKey, table.innerHTML);
                }
            }
        }

        // Format angka ribuan dengan titik pemisah (tanpa Rp) untuk tabel keuangan
        function transformHeaderToEditable(tableEl) {
            if (!tableEl) return;
            const thead = tableEl.querySelector('thead');
            if (!thead) return;

            const theadRows = thead.querySelectorAll('tr');
            if (theadRows.length === 0) return;

            theadRows.forEach((tr) => {
                const ths = tr.querySelectorAll('th');
                // Cek apakah baris ini adalah baris nomor kolom, misal (1), (2), (3) atau dengan background peach
                const isNumberingRow = tr.classList.contains('bg-[#fed7aa]') || 
                                       tr.classList.contains('subtable-header-numbering') ||
                                       (Array.from(ths).filter(th => !th.classList.contains('col-edit-action')).every(th => {
                                           const txt = th.innerText.trim();
                                           return /^\s*\(\s*\d+\s*\)\s*$/.test(txt) || /^\s*-\s*\d+\s*-?\s*$/.test(txt) || txt.toLowerCase() === 'no' || /^\s*\d+\s*$/.test(txt);
                                       }) && Array.from(ths).some(th => /^\s*\(\s*\d+\s*\)\s*$/.test(th.innerText.trim())));

                ths.forEach((th, cIdx) => {
                    if (th.classList.contains('col-edit-action')) return;
                    if (th.querySelector('.table-edit-header-input')) return;

                    if (isNumberingRow) {
                        let val = th.innerText.trim();
                        if (!val) {
                            val = `(${cIdx + 1})`;
                        }
                        th.innerHTML = `
                            <div class="flex items-center justify-center p-0.5 w-full">
                                <input type="text" 
                                       class="table-edit-input table-edit-header-input table-edit-header-num" 
                                       value="${safeEscapeHtml(val)}" 
                                       title="Ubah nomor kolom (contoh: (1), (2), dst)" 
                                       spellcheck="false" />
                            </div>
                        `;
                    } else {
                        // Header Judul Kolom
                        const childDivs = Array.from(th.children).filter(el => el.tagName === 'DIV');
                        const hasSub = childDivs.length >= 2 && (childDivs[1].classList.contains('italic') || childDivs[1].innerText.trim().length > 0);
                        
                        if (hasSub) {
                            let titleVal = childDivs[0].innerText.trim();
                            let subVal = childDivs[1].innerText.trim();
                            if ((currentTableCode === '2.2.2' || (tableEl && tableEl.innerText.includes('Partai'))) && /kolom\s*6/i.test(titleVal)) {
                                titleVal = 'S2/S3';
                            } else if ((currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) && /kolom\s*6/i.test(titleVal)) {
                                titleVal = 'AB';
                            }
                            th.innerHTML = `
                                <div class="flex flex-col gap-1 items-center justify-center p-1 w-full">
                                    <input type="text" 
                                           class="table-edit-input table-edit-header-input table-edit-header-title" 
                                           value="${safeEscapeHtml(titleVal)}" 
                                           placeholder="Judul Kolom" 
                                           title="Ubah judul utama kolom"
                                           spellcheck="false" />
                                    <input type="text" 
                                           class="table-edit-input table-edit-header-input table-edit-header-sub italic" 
                                           value="${safeEscapeHtml(subVal)}" 
                                           placeholder="Subtitle / Bahasa Inggris" 
                                           title="Ubah teks terjemahan / subtitle"
                                           spellcheck="false" />
                                </div>
                            `;
                        } else {
                            let titleVal = childDivs.length === 1 ? childDivs[0].innerText.trim() : th.innerText.trim();
                            if ((currentTableCode === '2.2.2' || (tableEl && tableEl.innerText.includes('Partai'))) && /kolom\s*6/i.test(titleVal)) {
                                titleVal = 'S2/S3';
                            } else if ((currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) && /kolom\s*6/i.test(titleVal)) {
                                titleVal = 'AB';
                            }
                            th.innerHTML = `
                                <div class="flex items-center justify-center p-1 w-full">
                                    <input type="text" 
                                           class="table-edit-input table-edit-header-input table-edit-header-title" 
                                           value="${safeEscapeHtml(titleVal)}" 
                                           placeholder="Judul Kolom" 
                                           title="Ubah judul kolom"
                                           spellcheck="false" />
                                </div>
                            `;
                        }
                    }

                    th.querySelectorAll('.table-edit-header-input').forEach(inp => {
                        inp.addEventListener('input', () => {
                            inp.setAttribute('value', inp.value);
                            window._hasUnsavedEdits = true;
                        });
                    });
                });
            });
        }

        function transformToEditableGrid(tableEl) {
            if (!tableEl) return;
            // 1. Transformasi seluruh kepala kolom tabel (thead) menjadi input yang bisa diedit
            transformHeaderToEditable(tableEl);

            const rows = tableEl.querySelectorAll('tbody tr');
            const isFinancialTable = ((currentType === 'opd' && currentOpdCode === '05') || currentTableCode.startsWith('2.4') || currentTableCode.startsWith('2.4.'));

            // Khusus Tabel 1.1.6: Kolom No (1, 2) dan nama kecamatan / nama sungai adalah label tetap, hanya sel Lebar yang diinput
            if (currentTableCode === '1.1.6') {
                rows.forEach(tr => {
                    const cells = tr.querySelectorAll('td');
                    cells.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        const txt = td.innerText.trim();
                        if (txt === '1' || txt === '2' || txt.includes('Batang') || txt.includes('Aur Birugo') || txt.includes('Mandiangin') || txt.includes('Guguk Panjang')) {
                            td.classList.add('font-medium');
                            return;
                        }
                        if (!td.querySelector('.table-edit-input')) {
                            let val = txt;
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="${val}" style="text-align: center; font-weight: 600;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('input', () => {
                                    inputEl.setAttribute('value', inputEl.value);
                                    window._hasUnsavedEdits = true;
                                });
                            }
                        }
                    });
                });
                appendActionColumnToEditor(tableEl);
                return;
            }

            // Khusus Tabel Dinas 08 / Tabel 4.1.x: Tabel Pendidikan (Sekolah, Guru, Murid)
            const isEducation3in1Edit = ['4.1.1', '4.1.3', '4.1.4', '4.1.5', '4.1.6', '4.1.7', '4.1.8', '4.1.9', '4.1.10', '4.1.11', '4.1.12', '4.1.13', '4.1.14', '4.1.15', '4.1.16', '4.1.17'].includes(currentTableCode);
            if (isEducation3in1Edit) {
                rows.forEach(tr => {
                    const text = tr.innerText.trim();
                    const tds = tr.querySelectorAll('td, th');
                    
                    // Cek baris header dalam tbody (Guru / Murid headers) atau baris pemisah -> JANGAN jadikan input!
                    const firstCellText = (tds[0] ? tds[0].innerText.trim() : '');
                    const isDistrictRow = /^\s*0?\d\./.test(firstCellText) || 
                                          firstCellText.includes('Guguk') || 
                                          firstCellText.includes('Mandiangin') || 
                                          firstCellText.includes('Aur Birugo');
                    const isTotalRow = firstCellText === 'Bukittinggi' || firstCellText.startsWith('Bukittinggi');

                    // Cek baris header dalam tbody (Guru / Murid headers) atau baris pemisah -> JANGAN jadikan input!
                    const isHeader = tr.classList.contains('subtable-spacer-row') ||
                                     text.includes('Guru') || text.includes('Teachers') || 
                                     text.includes('Murid') || text.includes('Students') ||
                                     text.includes('Negeri') || text.includes('Swasta') ||
                                     (!isDistrictRow && !isTotalRow && /\b(?:19|20)\d{2}\s*\/\s*(?:19|20)\d{2}\b/.test(text) && tds.length >= 6) ||
                                     text.includes('(1)') || text.includes('-1') ||
                                     tds.length === 1; // Baris separator

                    if (isHeader) {
                        return;
                    }
                    
                    tds.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        
                        // Kolom 0: Kecamatan / Bukittinggi -> label tetap
                        if (idx === 0) {
                            td.classList.add('font-bold', 'text-left');
                            return;
                        }

                        // Kolom Data & Total: buat editable input
                        if (!td.querySelector('.table-edit-input')) {
                            let val = td.innerText.trim();
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="${val}" style="text-align: right; font-weight: ${isTotalRow ? '700' : '600'}; padding-right: 0.5rem;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('input', () => {
                                    inputEl.setAttribute('value', inputEl.value);
                                    window._hasUnsavedEdits = true;
                                });
                            }
                        }
                    });
                });
                return;
            }

            // Khusus Tabel 2.3.5: Kolom Unit Kerja adalah label tetap, input pada PNS, PPPK, dan Jumlah
            if (currentTableCode === '2.3.5') {
                rows.forEach(tr => {
                    const cells = tr.querySelectorAll('td');
                    const isTotal = tr.getAttribute('data-total') === 'true';
                    const key = tr.getAttribute('data-key');
                    cells.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        if ((key && idx === 0) || (isTotal && idx === 0)) {
                            td.classList.add('font-semibold');
                            return;
                        }
                        if (!td.querySelector('.table-edit-input')) {
                            let val = td.innerText.trim();
                            td.setAttribute('data-orig-val', val);
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="${val}" style="text-align: center; font-weight: 600;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('input', () => {
                                    inputEl.setAttribute('value', inputEl.value);
                                    window._hasUnsavedEdits = true;
                                });
                            }
                        }
                    });
                });
                return;
            }
            // Khusus Tabel 2.3.3 & 2.3.4: Kolom No Golongan dan Nama Pangkat/Golongan adalah label tetap, input pada Laki-laki, Perempuan, dan Jumlah
            if (currentTableCode === '2.3.3' || currentTableCode === '2.3.4') {
                rows.forEach(tr => {
                    const cells = tr.querySelectorAll('td');
                    const isGroup = tr.hasAttribute('data-group');
                    const isTotal = tr.getAttribute('data-total') === 'true';
                    const key = tr.getAttribute('data-key');
                    if (isGroup) {
                        return;
                    }
                    cells.forEach((td, idx) => {
                        if (td.classList.contains('col-edit-action')) return;
                        if ((key && idx < 2) || (isTotal && idx === 0)) {
                            td.classList.add('font-semibold');
                            return;
                        }
                        if (!td.querySelector('.table-edit-input')) {
                            let val = td.innerText.trim();
                            td.setAttribute('data-orig-val', val);
                            td.innerHTML = `
                                <div class="flex items-center justify-center p-1">
                                    <input type="text" class="table-edit-input" value="${val}" style="text-align: center; font-weight: 600;" spellcheck="false" />
                                </div>
                            `;
                            const inputEl = td.querySelector('.table-edit-input');
                            if (inputEl) {
                                inputEl.addEventListener('input', () => {
                                    inputEl.setAttribute('value', inputEl.value);
                                    window._hasUnsavedEdits = true;
                                });
                            }
                        }
                    });
                });
                return;
            }

            rows.forEach(tr => {
                const cells = tr.querySelectorAll('td');
                cells.forEach((td, idx) => {
                    if (td.querySelector('.table-edit-input')) return;

                    let val = td.innerText.trim();
                    td.setAttribute('data-orig-val', val);

                    const isNumericOrData = idx > 0 || !isNaN(parseFloat(val.replace(',', '.'))) || val === '-' || val.includes('–');

                    if (isNumericOrData) {
                        if (idx > 0 && isFinancialTable && val !== '-' && val !== '') {
                            val = formatRupiahNumber(val);
                        } else if (idx > 0 && val !== '-' && val !== '') {
                            val = formatBpsNumber(val);
                        }
                        let isResultInput = (idx > 0);
                        if (cells.length === 4 && (currentTableCode.startsWith('custom_') || (!currentTableCode.startsWith('2.') && !currentTableCode.startsWith('4.') && !currentTableCode.startsWith('5.') && !currentTableCode.startsWith('8.')))) {
                            isResultInput = (idx === 2);
                        }
                        const isTotal = tr.classList.contains('font-bold') || tr.innerText.toLowerCase().includes('jumlah') || tr.innerText.toLowerCase().includes('total');
                        const alignStyle = isResultInput 
                            ? `text-align: right; font-weight: ${isTotal ? '700' : '600'}; padding-right: 0.5rem;` 
                            : 'text-align: center; font-weight: 600;';
                        td.innerHTML = `
                            <div class="flex items-center justify-center p-1">
                                <input type="text" class="table-edit-input" value="${val}" style="${alignStyle}" spellcheck="false" />
                            </div>
                        `;
                        const inputEl = td.querySelector('.table-edit-input');
                        if (inputEl) {
                            inputEl.addEventListener('input', () => {
                                inputEl.setAttribute('value', inputEl.value);
                                window._hasUnsavedEdits = true;
                            });
                            inputEl.addEventListener('blur', (e) => {
                                const formatter = (isFinancialTable && idx > 0) ? formatRupiahNumber : formatBpsNumber;
                                const formatted = formatter(e.target.value);
                                if (formatted !== e.target.value) {
                                    e.target.value = formatted;
                                }
                                inputEl.setAttribute('value', e.target.value);
                            });
                            inputEl.addEventListener('change', () => {
                                const formatter = (isFinancialTable && idx > 0) ? formatRupiahNumber : formatBpsNumber;
                                inputEl.value = formatter(inputEl.value);
                                inputEl.setAttribute('value', inputEl.value);
                                window._hasUnsavedEdits = true;
                            });
                        }
                    } else {
                        td.classList.add('font-bold', 'text-slate-900');
                    }
                });
            });

            // Tambahkan kolom Aksi dengan tombol hapus per baris
            appendActionColumnToEditor(tableEl);
        }
