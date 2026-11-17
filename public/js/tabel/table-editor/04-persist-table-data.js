/** SiBingka | table-editor | bagian 5/6: persist Table Data
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group). */
        async function persistTableData(redirectAfter = false) {
            if (window._isResetting) return;
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            
            // 1. Commit input yang sedang fokus saat tombol simpan ditekan
            if (document.activeElement && document.activeElement.blur) {
                try { document.activeElement.blur(); } catch(e) {}
            }

            // 2. Pastikan nilai yang diketik disinkronkan ke atribut DOM sebelum cloning
            tableEl.querySelectorAll('.table-edit-input').forEach(inp => {
                inp.setAttribute('value', inp.value);
            });

            const clone = tableEl.cloneNode(true);
            clone.querySelectorAll('.col-edit-action').forEach(el => el.remove());

            // 3. Konversi kembali elemen input di header (thead th) ke format HTML standar BPS
            clone.querySelectorAll('thead th').forEach(th => {
                if (th.classList.contains('col-edit-action')) return;

                const titleInp = th.querySelector('.table-edit-header-title');
                const subInp = th.querySelector('.table-edit-header-sub');
                const numInp = th.querySelector('.table-edit-header-num');

                if (titleInp && subInp) {
                    let title = (titleInp.value !== undefined ? titleInp.value : titleInp.getAttribute('value') || '').trim();
                    let sub = (subInp.value !== undefined ? subInp.value : subInp.getAttribute('value') || '').trim();
                    if ((currentTableCode === '2.2.2' || (tableEl && tableEl.innerText.includes('Partai'))) && /kolom\s*6/i.test(title)) {
                        title = 'S2/S3';
                    } else if ((currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) && /kolom\s*6/i.test(title)) {
                        title = 'AB';
                    }
                    if (sub) {
                        th.innerHTML = `<div>${title}</div><div class="italic font-normal text-[11px] sm:text-xs">${sub}</div>`;
                    } else {
                        th.innerHTML = `<div>${title}</div>`;
                    }
                } else if (titleInp) {
                    let title = (titleInp.value !== undefined ? titleInp.value : titleInp.getAttribute('value') || '').trim();
                    if ((currentTableCode === '2.2.2' || (tableEl && tableEl.innerText.includes('Partai'))) && /kolom\s*6/i.test(title)) {
                        title = 'S2/S3';
                    } else if ((currentTableCode === '4.2.11' || (tableEl && tableEl.innerText.includes('Golongan Darah'))) && /kolom\s*6/i.test(title)) {
                        title = 'AB';
                    }
                    th.innerHTML = `<div>${title}</div>`;
                } else if (numInp) {
                    let numVal = (numInp.value !== undefined ? numInp.value : numInp.getAttribute('value') || '').trim();
                    if (numVal && !numVal.startsWith('(') && /^\d+$/.test(numVal)) {
                        numVal = `(${numVal})`;
                    }
                    th.innerHTML = numVal;
                } else {
                    const singleInp = th.querySelector('.table-edit-input');
                    if (singleInp) {
                        const val = (singleInp.value !== undefined ? singleInp.value : singleInp.getAttribute('value') || '').trim();
                        th.innerHTML = val;
                    }
                }
            });

            // 4. Konversi kembali elemen input di baris data (tbody td / th)
            const origInputs = Array.from(tableEl.querySelectorAll('tbody .table-edit-input'));
            const cloneInputs = Array.from(clone.querySelectorAll('tbody .table-edit-input'));
            const isFinancialTable = ((currentType === 'opd' && currentOpdCode === '05') || currentTableCode.startsWith('2.4') || currentTableCode.startsWith('2.4.'));

            cloneInputs.forEach((input, idx) => {
                const cell = input.closest('td, th');
                if (cell) {
                    const origInput = origInputs[idx];
                    let finalVal = (origInput && origInput.value !== undefined) ? origInput.value.trim() : (input.value || input.getAttribute('value') || '').trim();
                    if (isFinancialTable) {
                        finalVal = formatRupiahNumber(finalVal);
                    }
                    cell.innerHTML = finalVal;
                    if (isFinancialTable && finalVal !== '-' && finalVal !== '0') {
                        cell.classList.remove('text-left', 'text-center');
                        cell.classList.add('text-right', 'font-semibold');
                        cell.style.textAlign = 'right';
                    } else if (finalVal !== '-' && finalVal !== '–' && finalVal !== '—' && !isNaN(finalVal.replace(/\./g, '').replace(',', '.'))) {
                        cell.classList.remove('text-left', 'text-center');
                        cell.classList.add('text-right', 'font-semibold');
                        cell.style.textAlign = 'right';
                    } else if (finalVal === '-' || finalVal === '–' || finalVal === '—') {
                        cell.classList.remove('text-left', 'text-right');
                        cell.classList.add('text-center');
                        cell.style.textAlign = 'center';
                    }
                }
            });

            cleanGhostRows(clone);

            // Save to localStorage
            const scopedHtmlKey = getStorageKey('sibingka_table_html');
            const scopedSavedKey = getStorageKey('sibingka_table_is_saved');
            safeSetLocalStorage(scopedHtmlKey, clone.innerHTML);
            safeSetLocalStorage(scopedSavedKey, '1');

            // Bersihkan legacy unscoped key agar tidak mencemari tabel kampus lain
            let saveOk = true;      // diisi false bila server/database tidak menerima data
            let saveMessage = '';
            try {
                localStorage.removeItem(`sibingka_table_html_${currentTableCode}_${currentYear}`);
                localStorage.removeItem(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`);
            } catch(e) {}

            // Simpan perubahan ke Database MySQL
            try {
                let rowsData = {};
                if (currentTableCode === '1.1.6') {
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inp = tr.querySelector('.table-edit-input');
                        if (inp) {
                            if (text.includes('batang tambuo')) {
                                rowsData[currentYear]['batang_tambuo'] = inp.value.trim();
                            } else if (text.includes('batang sianok')) {
                                rowsData[currentYear]['batang_sianok'] = inp.value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '8.1.4') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (text.includes('guguk') && inputs.length >= 2) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['guguk_panjang_unit'] = inputs[0].value.trim();
                            rowsData[currentYear]['guguk_panjang_panjang'] = inputs[1].value.trim();
                        } else if (text.includes('mandiangin') && inputs.length >= 2) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['mandiangin_koto_selayan_unit'] = inputs[0].value.trim();
                            rowsData[currentYear]['mandiangin_koto_selayan_panjang'] = inputs[1].value.trim();
                        } else if (text.includes('aur birugo') && inputs.length >= 2) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['aur_birugo_tigo_baleh_unit'] = inputs[0].value.trim();
                            rowsData[currentYear]['aur_birugo_tigo_baleh_panjang'] = inputs[1].value.trim();
                        } else if (inputs.length >= 2) {
                            const m = tr.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) {
                                const y = parseInt(m[1], 10);
                                if (!rowsData[y]) rowsData[y] = {};
                                rowsData[y]['total_unit'] = inputs[0].value.trim();
                                rowsData[y]['total_panjang'] = inputs[1].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '8.1.5') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (text.includes('guguk') && inputs.length >= 1) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['guguk_panjang'] = inputs[0].value.trim();
                        } else if (text.includes('mandiangin') && inputs.length >= 1) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['mandiangin_koto_selayan'] = inputs[0].value.trim();
                        } else if (text.includes('aur birugo') && inputs.length >= 1) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['aur_birugo_tigo_baleh'] = inputs[0].value.trim();
                        } else if (inputs.length >= 1) {
                            const m = tr.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) {
                                const y = parseInt(m[1], 10);
                                if (!rowsData[y]) rowsData[y] = {};
                                rowsData[y]['total'] = inputs[0].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '1.1.10') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (text.includes('guguk') && inputs.length >= 4) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['gp_tt'] = inputs[0].value.trim();
                            rowsData[currentYear]['gp_btt'] = inputs[1].value.trim();
                            rowsData[currentYear]['gp_cmp'] = inputs[2].value.trim();
                            rowsData[currentYear]['gp_jml'] = inputs[3].value.trim();
                        } else if (text.includes('mandiangin') && inputs.length >= 4) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['mks_tt'] = inputs[0].value.trim();
                            rowsData[currentYear]['mks_btt'] = inputs[1].value.trim();
                            rowsData[currentYear]['mks_cmp'] = inputs[2].value.trim();
                            rowsData[currentYear]['mks_jml'] = inputs[3].value.trim();
                        } else if (text.includes('aur birugo') && inputs.length >= 4) {
                            if (!rowsData[currentYear]) rowsData[currentYear] = {};
                            rowsData[currentYear]['abt_tt'] = inputs[0].value.trim();
                            rowsData[currentYear]['abt_btt'] = inputs[1].value.trim();
                            rowsData[currentYear]['abt_cmp'] = inputs[2].value.trim();
                            rowsData[currentYear]['abt_jml'] = inputs[3].value.trim();
                        } else if (inputs.length >= 4) {
                            const m = tr.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                            if (m) {
                                const y = parseInt(m[1], 10);
                                if (!rowsData[y]) rowsData[y] = {};
                                rowsData[y]['total_tt'] = inputs[0].value.trim();
                                rowsData[y]['total_btt'] = inputs[1].value.trim();
                                rowsData[y]['total_cmp'] = inputs[2].value.trim();
                                rowsData[y]['total_jml'] = inputs[3].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '1.1.8') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    const keys = ['hak_milik', 'hak_guna_bangunan', 'hak_pakai', 'hak_pengelolaan', 'hak_guna_usaha', 'hak_tanggungan'];
                    bodyRows.forEach((tr) => {
                        const firstTd = tr.querySelector('td:first-child');
                        const rowYr = firstTd ? firstTd.innerText.trim() : null;
                        if (rowYr && /^\d{4}$/.test(rowYr)) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            const inps = tr.querySelectorAll('.table-edit-input');
                            inps.forEach((inp, iIdx) => {
                                if (keys[iIdx]) {
                                    rowsData[rowYr][keys[iIdx]] = inp.value.trim();
                                }
                            });
                        }
                    });
                } else if (currentTableCode === '1.1.9') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    const keys = ['jual_beli', 'pewarisan', 'hibah', 'tukar_menukar', 'pembagian_hak_bersama', 'lelang', 'lainnya', 'total'];
                    if (!rowsData[currentYear]) rowsData[currentYear] = {};
                    bodyRows.forEach((tr, trIdx) => {
                        const inp = tr.querySelector('.table-edit-input');
                        if (inp && keys[trIdx]) {
                            rowsData[currentYear][keys[trIdx]] = inp.value.trim();
                        }
                    });
                } else if (currentTableCode === '2.3.1' || currentTableCode === '2.3.2') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    const rowKeys = (currentTableCode === '2.3.2') ? [
                        'sd', 'smp', 'sma', 'di', 'dii', 'diii', 'div', 's1', 's2', 's3'
                    ] : [
                        'jpt_utama', 'jpt_madya', 'jpt_pratama',
                        'administrator', 'pengawas', 'eselon5',
                        'dosen', 'guru', 'medis', 'teknis', 'pelaksana'
                    ];
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 9 && rowKeys[trIdx]) {
                            const k = rowKeys[trIdx];
                            rowsData[currentYear][`${k}_pns_l`] = inputs[0].value.trim();
                            rowsData[currentYear][`${k}_pns_p`] = inputs[1].value.trim();
                            rowsData[currentYear][`${k}_pns_jml`] = inputs[2].value.trim();
                            rowsData[currentYear][`${k}_pppk_l`] = inputs[3].value.trim();
                            rowsData[currentYear][`${k}_pppk_p`] = inputs[4].value.trim();
                            rowsData[currentYear][`${k}_pppk_jml`] = inputs[5].value.trim();
                            rowsData[currentYear][`${k}_total_l`] = inputs[6].value.trim();
                            rowsData[currentYear][`${k}_total_p`] = inputs[7].value.trim();
                            rowsData[currentYear][`${k}_total_jml`] = inputs[8].value.trim();
                        } else if (inputs.length >= 9 && tr.innerText.toLowerCase().includes('jumlah')) {
                            rowsData[currentYear]['total_pns_l'] = inputs[0].value.trim();
                            rowsData[currentYear]['total_pns_p'] = inputs[1].value.trim();
                            rowsData[currentYear]['total_pns_jml'] = inputs[2].value.trim();
                            rowsData[currentYear]['total_pppk_l'] = inputs[3].value.trim();
                            rowsData[currentYear]['total_pppk_p'] = inputs[4].value.trim();
                            rowsData[currentYear]['total_pppk_jml'] = inputs[5].value.trim();
                            rowsData[currentYear]['total_total_l'] = inputs[6].value.trim();
                            rowsData[currentYear]['total_total_p'] = inputs[7].value.trim();
                            rowsData[currentYear]['total_total_jml'] = inputs[8].value.trim();
                        }
                    });
                } else if (currentTableCode === '2.3.5') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const key = tr.getAttribute('data-key');
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (key && inputs.length >= 2) {
                            rowsData[currentYear][`${key}_pns`] = inputs[0].value.trim();
                            rowsData[currentYear][`${key}_pppk`] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear][`${key}_jml`] = inputs[2].value.trim();
                            } else {
                                const nPns = parseFloat(inputs[0].value.trim().replace(',', '.')) || 0;
                                const nPppk = parseFloat(inputs[1].value.trim().replace(',', '.')) || 0;
                                rowsData[currentYear][`${key}_jml`] = (nPns + nPppk).toString();
                            }
                        } else if (tr.getAttribute('data-total') === 'true' && inputs.length >= 2) {
                            rowsData[currentYear]['total_pns'] = inputs[0].value.trim();
                            rowsData[currentYear]['total_pppk'] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear]['total_jml'] = inputs[2].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '2.3.3' || currentTableCode === '2.3.4') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const key = tr.getAttribute('data-key');
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (key && inputs.length >= 2) {
                            rowsData[currentYear][`${key}_l`] = inputs[0].value.trim();
                            rowsData[currentYear][`${key}_p`] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear][`${key}_jml`] = inputs[2].value.trim();
                            } else {
                                const nL = parseFloat(inputs[0].value.trim().replace(',', '.')) || 0;
                                const nP = parseFloat(inputs[1].value.trim().replace(',', '.')) || 0;
                                rowsData[currentYear][`${key}_jml`] = (nL + nP).toString();
                            }
                        } else if (tr.getAttribute('data-total') === 'true' && inputs.length >= 2) {
                            rowsData[currentYear]['total_l'] = inputs[0].value.trim();
                            rowsData[currentYear]['total_p'] = inputs[1].value.trim();
                            if (inputs.length >= 3) {
                                rowsData[currentYear]['total_jml'] = inputs[2].value.trim();
                            }
                        }
                    });
                } else if (currentTableCode === '4.3.4') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const k = tr.getAttribute('data-key');
                        if (k && inputs.length >= 4) {
                            rowsData[currentYear][`${k}_kejadian`] = inputs[0].value.trim();
                            rowsData[currentYear][`${k}_korban`] = inputs[1].value.trim();
                            rowsData[currentYear][`${k}_rumah`] = inputs[2].value.trim();
                            rowsData[currentYear][`${k}_lainnya`] = inputs[3].value.trim();
                        }
                    });
                } else if (currentTableCode === '9.2') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const k = tr.getAttribute('data-key');
                        if (k && inputs.length >= 5) {
                            rowsData[currentYear][`${k}_kud`] = inputs[0].value.trim();
                            rowsData[currentYear][`${k}_kpri`] = inputs[1].value.trim();
                            rowsData[currentYear][`${k}_kopkar`] = inputs[2].value.trim();
                            rowsData[currentYear][`${k}_lainnya`] = inputs[3].value.trim();
                            rowsData[currentYear][`${k}_total`] = inputs[4].value.trim();
                        }
                    });
                } else if (currentTableCode === '9.3') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 5) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['koperasi'] = inputs[0].value.trim();
                            rowsData[rowYr]['anggota'] = inputs[1].value.trim();
                            rowsData[rowYr]['simpanan'] = inputs[2].value.trim();
                            rowsData[rowYr]['volume_usaha'] = inputs[3].value.trim();
                            rowsData[rowYr]['permodalan'] = inputs[4].value.trim();
                        }
                    });
                } else if (currentTableCode === '9.4') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const k = tr.getAttribute('data-key') || (tr.querySelector('td') ? tr.querySelector('td').innerText.trim().toLowerCase().replace(/[^a-z0-9]/g, '_') : '');
                        if (k && inputs.length >= 4) {
                            rowsData[currentYear][`${k}_gp`] = inputs[0].value.trim();
                            rowsData[currentYear][`${k}_mks`] = inputs[1].value.trim();
                            rowsData[currentYear][`${k}_abtb`] = inputs[2].value.trim();
                            rowsData[currentYear][`${k}_total`] = inputs[3].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.2') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const k = tr.getAttribute('data-key');
                        if (k) {
                            const inputs = tr.querySelectorAll('.table-edit-input');
                            inputs.forEach((inp, idx) => {
                                rowsData[currentYear][`${k}_col${idx}`] = inp.value.trim();
                            });
                        }
                    });
                } else if (currentTableCode === '4.2.4' || currentTableCode === '4.2.5') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 3) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['pemerintah'] = inputs[0].value.trim();
                            rowsData[rowYr]['swasta'] = inputs[1].value.trim();
                            rowsData[rowYr]['total'] = inputs[2].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.7') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 3) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['hidup'] = inputs[0].value.trim();
                            rowsData[rowYr]['mati'] = inputs[1].value.trim();
                            rowsData[rowYr]['ibu'] = inputs[2].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.10') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 4) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['baru'] = inputs[0].value.trim();
                            rowsData[rowYr]['lama'] = inputs[1].value.trim();
                            rowsData[rowYr]['kunjungan'] = inputs[2].value.trim();
                            rowsData[rowYr]['rata'] = inputs[3].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.15') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 5) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['pegawai'] = inputs[0].value.trim();
                            rowsData[rowYr]['truk'] = inputs[1].value.trim();
                            rowsData[rowYr]['gerobak'] = inputs[2].value.trim();
                            rowsData[rowYr]['becak_dayung'] = inputs[3].value.trim();
                            rowsData[rowYr]['becak_motor'] = inputs[4].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.16') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const rowYr = parseInt(tr.getAttribute('data-year') || tr.querySelector('td')?.innerText.trim(), 10);
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (rowYr > 1900 && rowYr < 2100 && inputs.length >= 2) {
                            if (!rowsData[rowYr]) rowsData[rowYr] = {};
                            rowsData[rowYr]['timbunan'] = inputs[0].value.trim();
                            rowsData[rowYr]['terangkut'] = inputs[1].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.12') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const mNum = trIdx + 1;
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 2) {
                            rowsData[currentYear][mNum] = {
                                timbunan: inputs[0].value.trim(),
                                terangkut: inputs[1].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '4.2.13') {
                    rowsData = {};
                    const p = get5YearPeriod(currentYear);
                    p.yearsAsc.forEach(y => { rowsData[y] = {}; });
                    const catKeys = ['organik', 'logam', 'plastik', 'kaca', 'kertas', 'lainnya', 'total'];
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const key = catKeys[trIdx] || `cat_${trIdx}`;
                        p.yearsAsc.forEach((y, yIdx) => {
                            if (inputs[yIdx]) {
                                rowsData[y][key] = inputs[yIdx].value.trim();
                            }
                        });
                    });
                } else if (currentTableCode === '4.2.17') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 8) {
                            const keys = ['imp', 'pil', 'iud', 'kondom', 'suntik', 'mow', 'mop', 'jumlah'];
                            let rowPrefix = '';
                            if (text.includes('guguk')) rowPrefix = 'guguk_panjang';
                            else if (text.includes('mandiangin')) rowPrefix = 'mandiangin_koto_selayan';
                            else if (text.includes('aur birugo')) rowPrefix = 'aur_birugo_tigo_baleh';
                            else {
                                const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                                if (m) {
                                    const y = parseInt(m[1], 10);
                                    if (!rowsData[y]) rowsData[y] = {};
                                    keys.forEach((k, kIdx) => {
                                        rowsData[y][`total_${k}`] = inputs[kIdx].value.trim();
                                    });
                                }
                            }
                            if (rowPrefix) {
                                keys.forEach((k, kIdx) => {
                                    rowsData[currentYear][`${rowPrefix}_${k}`] = inputs[kIdx].value.trim();
                                });
                            }
                        }
                    });
                } else if (currentTableCode === '4.2.18') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 8) {
                            const keys = ['ppkbd', 'sub_ppkbd', 'uppks', 'plkb', 'cu', 'bkb', 'bkr', 'bkl'];
                            let rowPrefix = '';
                            if (text.includes('guguk')) rowPrefix = 'guguk_panjang';
                            else if (text.includes('mandiangin')) rowPrefix = 'mandiangin_koto_selayan';
                            else if (text.includes('aur birugo')) rowPrefix = 'aur_birugo_tigo_baleh';
                            else {
                                const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                                if (m) {
                                    const y = parseInt(m[1], 10);
                                    if (!rowsData[y]) rowsData[y] = {};
                                    keys.forEach((k, kIdx) => {
                                        rowsData[y][`total_${k}`] = inputs[kIdx].value.trim();
                                    });
                                }
                            }
                            if (rowPrefix) {
                                keys.forEach((k, kIdx) => {
                                    rowsData[currentYear][`${rowPrefix}_${k}`] = inputs[kIdx].value.trim();
                                });
                            }
                        }
                    });
                } else if (currentTableCode === '4.2.19') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 4) {
                            const keys = ['klinik', 'dokter', 'bidan', 'total'];
                            let rowPrefix = '';
                            if (text.includes('guguk')) rowPrefix = 'guguk_panjang';
                            else if (text.includes('mandiangin')) rowPrefix = 'mandiangin_koto_selayan';
                            else if (text.includes('aur birugo')) rowPrefix = 'aur_birugo_tigo_baleh';
                            else {
                                const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                                if (m) {
                                    const y = parseInt(m[1], 10);
                                    if (!rowsData[y]) rowsData[y] = {};
                                    keys.forEach((k, kIdx) => {
                                        rowsData[y][`total_${k}`] = inputs[kIdx].value.trim();
                                    });
                                }
                            }
                            if (rowPrefix) {
                                keys.forEach((k, kIdx) => {
                                    rowsData[currentYear][`${rowPrefix}_${k}`] = inputs[kIdx].value.trim();
                                });
                            }
                        }
                    });
                } else if (currentTableCode === '4.3.5' || currentTableCode === '4.3.6' || currentTableCode === '4.3.7' || currentTableCode === '4.3.8') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 1) {
                            rowsData[currentYear][trIdx] = {
                                jumlah: inputs[0].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '4.3.13') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 4) {
                            rowsData[currentYear][trIdx] = {
                                psm: inputs[0].value.trim(),
                                karang_taruna: inputs[1].value.trim(),
                                tks: inputs[2].value.trim(),
                                org_sosial: inputs[3].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '4.3.14') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 3) {
                            rowsData[currentYear][trIdx] = {
                                disabilitas: inputs[0].value.trim(),
                                anak_terlantar: inputs[1].value.trim(),
                                lanjut_usia: inputs[2].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '5.1.15' || currentTableCode === '5.1.16' || currentTableCode === '5.1.17' || currentTableCode === '5.1.18' || currentTableCode === '5.1.19') {
                    rowsData = {};
                    rowsData[currentYear] = {};
                    const tableEl = document.getElementById('dataDisplayTable');
                    if (tableEl) {
                        const trs = tableEl.querySelectorAll('tbody tr');
                        trs.forEach((tr, trIdx) => {
                            const tds = tr.querySelectorAll('td');
                            if (tds.length >= 2) {
                                rowsData[currentYear][trIdx] = Array.from(tds).map(td => {
                                    const inp = td.querySelector('.table-edit-input');
                                    return inp ? inp.value.trim() : td.innerText.trim();
                                });
                            }
                        });
                    }
                } else if (currentTableCode === '4.3.15') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m && inputs.length >= 5) {
                            const y = parseInt(m[1], 10);
                            if (!rowsData[y]) rowsData[y] = {};
                            rowsData[y]['orang_terlantar'] = inputs[0].value.trim();
                            rowsData[y]['bekas_napi'] = inputs[1].value.trim();
                            rowsData[y]['disabilitas'] = inputs[2].value.trim();
                            rowsData[y]['panti_asuhan'] = inputs[3].value.trim();
                            rowsData[y]['jumlah'] = inputs[4].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.20') {
                    rowsData = {};
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach(tr => {
                        const text = tr.innerText.toLowerCase();
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        const m = text.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m && inputs.length >= 3) {
                            const y = parseInt(m[1], 10);
                            if (!rowsData[y]) rowsData[y] = {};
                            rowsData[y]['target'] = inputs[0].value.trim();
                            rowsData[y]['realisasi'] = inputs[1].value.trim();
                            rowsData[y]['persentase'] = inputs[2].value.trim();
                        }
                    });
                } else if (currentTableCode === '4.2.14') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 2) {
                            rowsData[currentYear][trIdx] = {
                                timbunan: inputs[0].value.trim(),
                                persentase: inputs[1].value.trim()
                            };
                        }
                    });
                } else if (currentTableCode === '4.2.9') {
                    rowsData = {};
                    const p = get5YearPeriod(currentYear);
                    p.yearsAsc.forEach(y => { rowsData[y] = {}; });
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        p.yearsAsc.forEach((y, yIdx) => {
                            if (inputs[yIdx]) {
                                rowsData[y][`prof_${trIdx}`] = inputs[yIdx].value.trim();
                            }
                        });
                    });
                } else if (currentTableCode === '4.2.6') {
                    rowsData = { [currentYear]: {} };
                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        if (inputs.length >= 2) {
                            rowsData[currentYear][`name_${trIdx}`] = inputs[0].value.trim();
                            rowsData[currentYear][`val_${trIdx}`] = inputs[1].value.trim();
                        } else if (inputs.length === 1) {
                            rowsData[currentYear][`val_${trIdx}`] = inputs[0].value.trim();
                        }
                    });
                } else {
                    const theadThs = tableEl.querySelectorAll('thead tr:first-child th');
                    const colYears = [];
                    theadThs.forEach((th, idx) => {
                        const m = th.innerText.match(/\b(20\d{2}|19\d{2})\b/);
                        if (m) colYears.push({ colIdx: idx, year: parseInt(m[1], 10) });
                    });

                    const bodyRows = tableEl.querySelectorAll('tbody tr');
                    bodyRows.forEach((tr, trIdx) => {
                        const inputs = tr.querySelectorAll('.table-edit-input');
                        let rowKey = null;
                        if (currentTableCode === '2.2.5') {
                            const dprdKeys = [
                                'peraturan_daerah', 'keputusan_dprd', 'keputusan_pimpinan',
                                'pernyataan', 'pernyataan_pendapat', 'resolusi',
                                'dengar_pendapat', 'paripurna_terbuka', 'paripurna_istimewa',
                                'panitia_musyawarah', 'badan_kehormatan', 'badan_anggaran',
                                'panitia_khusus', 'gabungan_komisi', 'rapat_komisi',
                                'turun_lapangan', 'keluar_daerah', 'rapat_kerja',
                                'penyampaian_aspirasi', 'study_banding', 'reses',
                                'kunker_komisi'
                            ];
                            rowKey = dprdKeys[trIdx] || null;
                        } else if (currentTableCode === '8.1.2') {
                            rowKey = trIdx === 0 ? 'aspal' : (trIdx === 1 ? 'kerikil' : (trIdx === 2 ? 'tanah' : (trIdx === 3 ? 'lainnya' : 'total')));
                        } else if (currentTableCode === '8.1.3') {
                            rowKey = trIdx === 0 ? 'baik' : (trIdx === 1 ? 'sedang' : (trIdx === 2 ? 'rusak' : (trIdx === 3 ? 'rusak_berat' : 'total')));
                        } else if (currentTableCode === '9.1') {
                            rowKey = trIdx === 0 ? 'guguk_panjang' : (trIdx === 1 ? 'mandiangin_koto_selayan' : (trIdx === 2 ? 'aur_birugo_tigo_baleh' : 'total'));
                        } else {
                            rowKey = trIdx === 0 ? 'negara' : (trIdx === 1 ? 'provinsi' : (trIdx === 2 ? 'kota' : 'total'));
                        }
                        if (rowKey) {
                            inputs.forEach((inp, inpIdx) => {
                                const offset = 4;
                                const y = (colYears[inpIdx] ? colYears[inpIdx].year : (parseInt(currentYear) - offset + inpIdx));
                                if (!rowsData[y]) rowsData[y] = {};
                                rowsData[y][rowKey] = inp.value.trim();
                            });
                        }
                    });
                }

                    const targetSourceType = (typeof currentType !== 'undefined' && currentType === 'bps') 
                        ? 'custom_bps' 
                        : ((typeof currentType !== 'undefined' && currentType === 'instansi') ? 'custom_instansi' : 'manual');

                    const saveRes = await fetch(window.SiBingkaConfig.routes.apiSave, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            table_code: currentTableCode,
                            opd_code: currentOpdCode,
                            year: currentYear,
                            table_html: clone.innerHTML,
                            title_id: document.getElementById('metaTableTitleId') ? document.getElementById('metaTableTitleId').innerText : '',
                            title_en: document.getElementById('metaTableTitleEn') ? document.getElementById('metaTableTitleEn').innerText : '',
                            source: document.getElementById('tableSourceContent') ? document.getElementById('tableSourceContent').innerHTML : '',
                            note: document.getElementById('tableNoteContent') ? document.getElementById('tableNoteContent').innerHTML : '',
                            source_type: targetSourceType,
                            type: typeof currentType !== 'undefined' ? currentType : 'opd',
                            rows_data: rowsData
                        })
                    });

                    // Periksa jawaban server: jangan menampilkan "berhasil" kalau server menolak / database gagal
                    let saveData = null;
                    try { saveData = await saveRes.json(); } catch (_) { /* jawaban bukan JSON */ }
                    if (!saveRes.ok || (saveData && (saveData.success === false || saveData.db_saved === false))) {
                        saveOk = false;
                        saveMessage = (saveData && saveData.message)
                            ? saveData.message
                            : (saveRes.status === 419 ? 'Sesi halaman habis. Muat ulang halaman lalu simpan lagi.'
                               : saveRes.status === 401 ? 'Sesi login habis. Silakan masuk kembali.'
                               : 'Server menjawab kode ' + saveRes.status + '.');
                    }
            } catch(e) {
                console.warn('Gagal menyimpan ke database:', e);
                saveOk = false;
                saveMessage = 'Tidak dapat terhubung ke server. Periksa koneksi internet lalu coba lagi.';
            }

            if (!saveOk) {
                showToast('❌ Gagal menyimpan: ' + saveMessage);
                return false;
            }

            if (redirectAfter) {
                showToast('✅ Data tabel berhasil disimpan ke Database! Mengalihkan ke tabel...');
                setTimeout(() => {
                    let url = `${window.SiBingkaConfig.routes.tabelOpd}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}&saved=1`;
                    if (currentType) url += `&type=${currentType}`;
                    window.location.href = url;
                }, 500);
            } else {
                showToast('💾 Nilai data langsung tersimpan ke Database!');
            }
            return true;
        }
