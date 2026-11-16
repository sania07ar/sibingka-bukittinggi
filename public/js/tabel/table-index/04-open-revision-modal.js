/** SiBingka | table-index | bagian 4/4: open Revision Modal
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group). */
        function openRevisionModal() {
            const modal = document.getElementById('revisionModal');
            const card = document.getElementById('revisionModalCard');
            const input = document.getElementById('revisionNotesInput');
            if (input) input.value = '';
            if (modal && card) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                    if (input) input.focus();
                }, 50);
            }
        }

        function closeRevisionModal() {
            const modal = document.getElementById('revisionModal');
            const card = document.getElementById('revisionModalCard');
            if (modal && card) {
                card.classList.remove('scale-100', 'opacity-100');
                card.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }
        }

        async function handleRejectTable(event) {
            event.preventDefault();
            const input = document.getElementById('revisionNotesInput');
            const notes = input ? input.value.trim() : '';
            if (!notes) {
                alert('Mohon isi pesan catatan perbaikan untuk dinas.');
                return;
            }

            const btn = document.getElementById('btnSubmitRevision');
            if (btn) btn.disabled = true;

            try {
                const res = await fetch(sbUrl('/api/tabel-opd/reject-verification'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear,
                        type: currentType,
                        notes: notes
                    })
                });
                const data = await res.json();
                if (data.success) {
                    closeRevisionModal();
                    showToast('Catatan revisi berhasil dikirim ke dinas.');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal mengirim catatan revisi.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat mengirim catatan revisi.');
            } finally {
                if (btn) btn.disabled = false;
            }
        }

        async function handleUnlockTable() {
            if (!confirm(`Buka Kunci Tabel ${currentTableCode} Tahun ${currentYear}?\n\nDinas akan kembali dapat mengedit angka jika diperlukan perbaikan.`)) {
                return;
            }

            try {
                const res = await fetch(sbUrl('/api/tabel-opd/unlock-table'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        table_code: currentTableCode,
                        opd_code: currentOpdCode,
                        year: currentYear
                    })
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Kunci tabel berhasil dibuka.');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    alert(data.message || 'Gagal membuka kunci tabel.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat membuka kunci tabel.');
            }
        }

        // Listener Keyboard Esc untuk menutup modal spreadsheet
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('spreadsheetModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeSpreadsheetModal();
                }
            }
        });

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPage);
        } else {
            initPage();
        }
    
