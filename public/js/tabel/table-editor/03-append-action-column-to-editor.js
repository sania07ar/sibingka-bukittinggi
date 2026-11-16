/** SiBingka | table-editor | bagian 4/6: append Action Column To Editor
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group). */
        function appendActionColumnToEditor(tableEl) {
            if (!tableEl) return;
            const thead = tableEl.querySelector('thead');
            const tbody = tableEl.querySelector('tbody');
            if (!thead || !tbody) return;

            // Pastikan belum ada kolom aksi
            if (thead.querySelector('.col-edit-action')) return;

            const theadRows = thead.querySelectorAll('tr');
            if (theadRows.length === 0) return;

            const headerRowSpan = theadRows.length;
            const firstHeaderTr = theadRows[0];
            const th = document.createElement('th');
            th.className = 'col-edit-action py-2 px-3 border border-slate-700 text-center text-xs font-bold w-14 bg-[#f95a00] text-white';
            th.setAttribute('rowspan', headerRowSpan);
            th.innerText = 'Aksi';
            firstHeaderTr.appendChild(th);

            // Tambahkan tombol hapus di setiap baris data
            const bodyRows = tbody.querySelectorAll('tr');
            bodyRows.forEach(tr => {
                if (tr.querySelector('.col-edit-action')) return;
                const td = document.createElement('td');
                td.className = 'col-edit-action py-1.5 px-2 text-center border border-slate-700 bg-amber-50/50 align-middle';
                td.innerHTML = `
                    <button type="button" onclick="deleteSpecificRow(this)" 
                            class="p-1 px-2 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-300 hover:border-rose-600 rounded transition-all text-xs font-semibold flex items-center justify-center gap-1 shadow-2xs mx-auto cursor-pointer" 
                            title="Hapus baris ini dari tabel">
                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                    </button>
                `;
                tr.appendChild(td);
            });
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
                const tds = Array.from(tr.querySelectorAll('td')).filter(td => !td.classList.contains('col-edit-action'));
                if (tds.length === 0) return;
                const input0 = tds[0].querySelector('.table-edit-input');
                const labelText = (input0 ? input0.value : tds[0].innerText).trim();

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
                    window._hasUnsavedEdits = true;
                }
                return;
            }

            const remainingRows = tbody.querySelectorAll('tr');
            remainingRows.forEach(tr => {
                const tds = Array.from(tr.querySelectorAll('td')).filter(td => !td.classList.contains('col-edit-action'));
                if (tds.length === 0) return;
                // Baris yang memiliki label teks kategori/indikator di kolom pertama BUKAN baris hantu
                const labelText = tds[0].innerText.trim();
                if (/[a-zA-Z]{2,}/.test(labelText)) {
                    return;
                }
                const hasMeaningful = tds.some(td => {
                    const input = td.querySelector('.table-edit-input');
                    const val = input ? input.value.trim() : td.innerText.trim();
                    return val !== '' && val !== '-' && val !== '–' && val !== '—';
                });
                if (!hasMeaningful) {
                    tr.remove();
                    removedAny = true;
                }
            });

            if (removedAny) {
                window._hasUnsavedEdits = true;
            }
        }

        function deleteBottomRow() {
            const tableEl = document.getElementById('dataDisplayTable');
            if (!tableEl) return;
            const tbody = tableEl.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            if (rows.length <= 1) {
                alert('Tabel minimal harus memiliki 1 baris data.');
                return;
            }
            if (confirm('Apakah Anda yakin ingin menghapus baris paling bawah dari tabel ini?')) {
                const lastRow = rows[rows.length - 1];
                deleteRowElement(lastRow);
                window._hasUnsavedEdits = true;
                showToast('🗑️ Baris paling bawah berhasil dihapus! Klik "Simpan Perubahan" setelah selesai.');
            }
        }

        function deleteSpecificRow(btn) {
            const tr = btn.closest('tr');
            if (!tr) return;
            const tableEl = tr.closest('table');
            const tbody = tableEl ? tableEl.querySelector('tbody') : null;
            const rows = tbody ? tbody.querySelectorAll('tr') : [];
            if (rows.length <= 1) {
                alert('Tabel minimal harus memiliki 1 baris data.');
                return;
            }
            if (confirm('Apakah Anda yakin ingin menghapus baris ini dari tabel?')) {
                deleteRowElement(tr);
                window._hasUnsavedEdits = true;
                showToast('🗑️ Baris tabel berhasil dihapus! Klik "Simpan Perubahan" setelah selesai.');
            }
        }

        function deleteRowElement(tr) {
            if (!tr) return;
            const tbody = tr.parentElement;
            if (!tbody) return;
            const allRows = Array.from(tbody.querySelectorAll('tr'));
            const rIdx = allRows.indexOf(tr);
            if (rIdx === -1) return;

            // Deteksi apakah baris ini memiliki sel rowspan > 1
            const rowspanCells = Array.from(tr.querySelectorAll('td[rowspan]')).filter(td => {
                if (td.classList.contains('col-edit-action')) return false;
                return (parseInt(td.getAttribute('rowspan') || '1', 10)) > 1;
            });

            if (rowspanCells.length > 0) {
                // Jika ada baris berikutnya di bawahnya, pindahkan sel rowspan ke baris berikutnya
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
                // Cek apakah baris ini merupakan kelanjutan dari baris atas yang memiliki rowspan
                for (let i = rIdx - 1; i >= 0; i--) {
                    const prevTr = allRows[i];
                    const dist = rIdx - i;
                    const parentRowspanCells = Array.from(prevTr.querySelectorAll('td[rowspan]')).filter(td => {
                        if (td.classList.contains('col-edit-action')) return false;
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

            renderEditTablePage();
            showToast(`Tahun data diubah ke ${currentYear}`);
        }

        async function resetTableOriginal() {
            window._isResetting = true;
            if (!confirm(`Apakah Anda yakin ingin mereset/menghapus seluruh nilai data Tabel ${currentTableCode} untuk tahun ${currentYear}? Seluruh angka data yang sudah terisi akan terhapus dan kembali kosong (-).`)) {
                window._isResetting = false;
                return;
            }

            // 1. Bersihkan seluruh cache localStorage untuk tabel & tahun ini
            try {
                const scopedPrefix = `${typeof currentType !== 'undefined' ? currentType : 'opd'}_${(typeof currentOpdCode !== 'undefined' ? currentOpdCode : '01').toString().padStart(2, '0')}_${currentTableCode}`;
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (k && (k.includes(scopedPrefix) || k.includes(`${currentTableCode}_${currentYear}`))) {
                        keysToRemove.push(k);
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
            } catch(e) {}

            // 2. Bangun HTML kosong (seluruh angka data di-wipe menjadi '-') berdasarkan struktur tabel saat ini
            const tableEl = document.getElementById('dataDisplayTable');
            let emptyHtml = null;
            if (tableEl) {
                const clone = tableEl.cloneNode(true);
                clone.querySelectorAll('.col-edit-action').forEach(el => el.remove());
                
                // Kembalikan header th ke teks statis
                clone.querySelectorAll('thead th').forEach(th => {
                    const titleInp = th.querySelector('.table-edit-header-title');
                    const subInp = th.querySelector('.table-edit-header-sub');
                    const numInp = th.querySelector('.table-edit-header-num');
                    if (titleInp && subInp) {
                        const title = (titleInp.value || titleInp.getAttribute('value') || '').trim();
                        const sub = (subInp.value || subInp.getAttribute('value') || '').trim();
                        th.innerHTML = sub ? `<div>${title}</div><div class="italic font-normal text-[11px] sm:text-xs">${sub}</div>` : `<div>${title}</div>`;
                    } else if (titleInp) {
                        th.innerHTML = `<div>${(titleInp.value || titleInp.getAttribute('value') || '').trim()}</div>`;
                    } else if (numInp) {
                        let numVal = (numInp.value || numInp.getAttribute('value') || '').trim();
                        if (numVal && !numVal.startsWith('(') && /^\d+$/.test(numVal)) numVal = `(${numVal})`;
                        th.innerHTML = numVal;
                    }
                });

                // Kosongkan seluruh sel input data di tbody menjadi '-'
                clone.querySelectorAll('tbody tr').forEach(tr => {
                    const tds = tr.querySelectorAll('td, th');
                    tds.forEach((td, idx) => {
                        const input = td.querySelector('.table-edit-input');
                        if (input) {
                            td.innerHTML = '<span class="text-slate-400 font-normal">-</span>';
                            td.className = td.className.replace(/text-(left|right)/g, '') + ' text-center align-middle';
                        }
                    });
                });

                emptyHtml = clone.innerHTML;
            }

            // Jika ada buildEmptyTemplateFromSource, gunakan untuk memastikan struktur tahun teratur
            if (emptyHtml && typeof buildEmptyTemplateFromSource === 'function') {
                emptyHtml = buildEmptyTemplateFromSource(emptyHtml, currentYear, currentYear);
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
                        default_html: emptyHtml
                    })
                });
            } catch(e) {
                console.error('Reset API error:', e);
            }

            // 4. Update in-memory server metadata
            if (serverDbMetadata) {
                serverDbMetadata.table_html = emptyHtml;
                serverDbMetadata.is_saved = false;
                serverDbMetadata.source_type = 'template';
            }

            window._hasUnsavedEdits = false;
            showToast('🗑️ Seluruh nilai data tabel berhasil dihapus/direset ke kosong (-)!');
            setTimeout(() => {
                window.location.reload();
            }, 300);
        }
