/** SiBingka | table-index | bagian 3/4: EXPORT DROPDOWN TOGGLE HANDLERS
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group). */
        async function handleExcelFileSelected(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (!file) return;

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
                        const tableEl = document.getElementById('dataDisplayTable');
                        if (tableEl) tableEl.innerHTML = result.table_html;
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

        async function resetTableOriginal() {
            if (!confirm(`Apakah Anda yakin ingin mereset seluruh nilai data Tabel ${currentTableCode} kembali ke data asli resmi BPS?`)) {
                return;
            }

            // 1. Bersihkan seluruh cache localStorage untuk tabel ini
            try {
                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (k && (k.includes(`${currentTableCode}_${currentYear}`) || k.includes(`_${currentTableCode}_`) || k.endsWith(`_${currentTableCode}`))) {
                        keysToRemove.push(k);
                    }
                }
                keysToRemove.forEach(k => localStorage.removeItem(k));
            } catch(e) {}

            // 2. Ambil HTML template resmi BPS jika ada skema
            let defaultHtml = null;
            if (tableSchemas[currentTableCode] && typeof tableSchemas[currentTableCode].render === 'function') {
                try {
                    defaultHtml = tableSchemas[currentTableCode].render(currentYear);
                    if (defaultHtml && defaultHtml.includes('<input')) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = defaultHtml;
                        tempDiv.querySelectorAll('input, .table-edit-input').forEach(inp => {
                            const val = (inp.value !== undefined ? inp.value : inp.getAttribute('value') || '').trim();
                            const parent = inp.closest('td, th') || inp.parentNode;
                            if (parent) {
                                parent.innerHTML = val;
                            }
                        });
                        defaultHtml = tempDiv.innerHTML;
                    }
                } catch(err) {
                    console.error('Error rendering default schema:', err);
                }
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
                        default_html: defaultHtml
                    })
                });
            } catch(e) {
                console.error('Reset API error:', e);
            }

            if (serverDbMetadata) {
                serverDbMetadata.table_html = defaultHtml;
                serverDbMetadata.is_saved = false;
                serverDbMetadata.source_type = 'template';
            }

            showToast('🔄 Nilai tabel berhasil dikembalikan ke data awal resmi BPS!');
            setTimeout(() => {
                window.location.reload();
            }, 300);
        }

        // Aliaskan juga resetGeneratedExcel ke resetTableOriginal
        window.resetGeneratedExcel = resetTableOriginal;

        function escapeHtml(str) {
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function setupDragAndDrop() {
            const dropZone = document.getElementById('excelDropZone');
            if (!dropZone) return;

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('border-emerald-600', 'bg-emerald-100/50');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('border-emerald-600', 'bg-emerald-100/50');
                }, false);
            });

            dropZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length > 0) {
                    const fakeEvent = { target: { files: files, value: '' } };
                    handleExcelFileSelected(fakeEvent);
                }
            }, false);
        }

        function fallbackCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showToast('📋 Format tabel disalin! Tekan Ctrl+V pada Google Sheets atau Excel.');
        }

        // EXPORT DROPDOWN TOGGLE HANDLERS
        var toastTimeout = null;
        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const msgEl = document.getElementById('toastMessage');
            if (!toast || !msgEl) return;
            msgEl.innerText = message;

            toast.classList.remove('translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            if (toastTimeout) {
                clearTimeout(toastTimeout);
            }
            toastTimeout = setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3500);
        }


        // ==========================================
        // EXPORT & TINDAKAN DROPDOWN TOGGLE HANDLERS
        // ==========================================
        function toggleActionDropdown() {
            const menu = document.getElementById('actionDropdownMenu');
            const chevron = document.getElementById('actionChevron');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            closeAllExportDropdowns();
            if (isHidden) {
                menu.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        }

        function closeActionDropdown() {
            const menu = document.getElementById('actionDropdownMenu');
            const chevron = document.getElementById('actionChevron');
            if (menu) menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }

        document.addEventListener('click', function (e) {
            const actContainer = document.getElementById('actionDropdownContainer');
            const actMenu = document.getElementById('actionDropdownMenu');
            if (actContainer && !actContainer.contains(e.target) && actMenu && !actMenu.contains(e.target)) {
                closeActionDropdown();
            }
        });

        // ==========================================
        // VERIFIKASI & ACC WORKFLOW ACTIONS (ADMIN BPS)
        // ==========================================
        async function handleApproveTable() {
            if (!confirm(`ACC & Kunci Tabel ${currentTableCode} Tahun ${currentYear}?\n\nData ini akan disahkan sebagai data valid BPS untuk publikasi Daerah Dalam Angka (DDA) dan terkunci bagi dinas.`)) {
                return;
            }

            try {
                const res = await fetch(sbUrl('/api/tabel-opd/approve-verification'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: currentType
                    })
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Data berhasil di-ACC & dikunci!');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal menyetujui data.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat menyetujui data tabel.');
            }
        }
