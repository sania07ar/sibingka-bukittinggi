/** SiBingka | table-editor | bagian 6/6: FITUR CATATAN / KOMENTAR RINCIAN DATA (DRAWER CHAT)
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group). */
        async function saveAndReturn() {
            if (typeof saveAndSubmitForVerification === 'function') {
                return saveAndSubmitForVerification();
            }
            window._hasUnsavedEdits = false;
            await persistTableData(true);
        }

        function backToTableView() {
            if (window._hasUnsavedEdits) {
                if (!confirm('Perubahan yang Anda ketik belum disimpan. Apakah Anda yakin ingin membatalkan dan keluar? Semua perubahan yang belum disimpan akan dibatalkan.')) {
                    return;
                }
            }
            let url = `${window.SiBingkaConfig.routes.tabelOpd}?code=${currentTableCode}&opd=${currentOpdCode}&year=${currentYear}`;
            if (currentType) url += `&type=${currentType}`;
            window.location.href = url;
        }

        function downloadEditExcelTemplate() {
            const url = sbUrl(`/tabel-opd/export-excel?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&type=${encodeURIComponent(currentType)}&template=1`);
            window.location.href = url;
            if (typeof showToast === 'function') {
                showToast(`📥 Mengunduh template Excel Tabel ${currentTableCode} Tahun ${currentYear}...`);
            }
            return;
        }

        async function handleEditExcelImport(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (!file) return;

            if (!confirm('Apakah Anda yakin?')) {
                event.target.value = '';
                return;
            }

            const loadingEl = document.getElementById('excelUploadLoading');
            if (loadingEl) loadingEl.classList.remove('hidden');

            try {
                const formData = new FormData();
                formData.append('excel_file', file);
                formData.append('table_code', currentTableCode);
                formData.append('opd_code', currentOpdCode);
                formData.append('year', currentYear);
                formData.append('type', currentType);
                formData.append('_token', csrfToken);

                const response = await fetch(sbUrl('/tabel-opd/import-excel'), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    if (typeof showToast === 'function') {
                        showToast('✅ Berhasil mengimpor data menggunakan Laravel Excel!');
                    }
                    if (result.table_html) {
                        try {
                            const scopedHtmlKey = (typeof getStorageKey === 'function') ? getStorageKey('sibingka_table_html') : `sibingka_table_html_${currentTableCode}_${currentYear}`;
                            const scopedSavedKey = (typeof getStorageKey === 'function') ? getStorageKey('sibingka_table_is_saved') : `sibingka_table_is_saved_${currentTableCode}_${currentYear}`;
                            safeSetLocalStorage(scopedHtmlKey, result.table_html);
                            safeSetLocalStorage(scopedSavedKey, '1');
                            safeSetLocalStorage(`sibingka_table_html_${currentTableCode}_${currentYear}`, result.table_html);
                            safeSetLocalStorage(`sibingka_table_is_saved_${currentTableCode}_${currentYear}`, '1');
                            safeSetLocalStorage(`sibingka_table_source_${currentTableCode}_${currentYear}`, 'excel');
                            if (result.title_id && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('sibingka_table_title_id'), result.title_id);
                            if (result.title_en && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('sibingka_table_title_en'), result.title_en);
                            if (result.source && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('sibingka_table_source_text'), result.source);
                            if (result.note && typeof getStorageKey === 'function') safeSetLocalStorage(getStorageKey('sibingka_table_note'), result.note);
                        } catch(e) {}
                    }
                    setTimeout(() => { window.location.reload(); }, 600);
                } else {
                    alert(result.message || 'Gagal mengimpor berkas Excel.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat mengunggah berkas Excel: ' + (err.message || err));
            } finally {
                if (loadingEl) loadingEl.classList.add('hidden');
                event.target.value = '';
            }
            return;
        }

        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const toastMessage = document.getElementById('toastMessage');
            if (toast && toastMessage) {
                toastMessage.innerText = message;
                toast.classList.remove('translate-y-20', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');

                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3500);
            }
        }
        // ==========================================
        // FITUR CATATAN / KOMENTAR RINCIAN DATA (DRAWER CHAT)
        // ==========================================
         // key: cell_key -> [comments]
        

        // Tombol kirim sekarang ada di bawah "Sumber" (06-pernyataan-kebenaran.js): wajib centang pernyataan kebenaran data.
        async function submitTableVerification() {
            return saveAndSubmitForVerification();
        }

        async function approveTableVerification() {
            if (!confirm('Apakah Anda yakin ingin memverifikasi data tabel ini sebagai Wali Data (Diskominfo)?')) return;

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || csrfToken;
                const res = await fetch(window.SiBingkaConfig.routes.apiApproveVerification, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: 'opd'
                    })
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Gagal: ' + (data.message || ''));
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan.');
            }
        }

        async function rejectTableVerification() {
            const notes = prompt('Masukkan catatan perbaikan / revisi untuk dinas pengisi data:');
            if (notes === null || notes.trim() === '') return;

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || csrfToken;
                const res = await fetch(window.SiBingkaConfig.routes.apiRejectVerification, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: 'opd',
                        notes: notes
                    })
                });
                const data = await res.json();
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Gagal mengirim revisi: ' + (data.message || ''));
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan.');
            }
        }
    
