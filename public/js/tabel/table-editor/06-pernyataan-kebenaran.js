/** SiBingka | table-editor | pernyataan kebenaran data & tombol Simpan & Kirim
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group).
 *
 *  Alur: centang pernyataan -> tombol "Simpan & Kirim" aktif -> data disimpan ke database
 *  -> dikirim (masuk Monitoring sebagai "Input Data") -> verifikasi Wali Data -> validasi Admin BPS.
 */

function syncDeclarationButton() {
    const check = document.getElementById('dataDeclarationCheck');
    const btn = document.getElementById('btnSaveAndSubmit');
    if (!btn) return;

    if (check) {
        if (check.checked) {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            btn.classList.add('cursor-pointer');
            btn.title = 'Simpan data lalu kirim';
        } else {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            btn.classList.remove('cursor-pointer');
            btn.title = 'Centang pernyataan kebenaran data terlebih dahulu untuk menyimpan';
        }
    } else {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
        btn.classList.add('cursor-pointer');
        btn.title = 'Simpan data lalu kirim';
    }
}

function initDeclarationBox() {
    syncDeclarationButton();
    const check = document.getElementById('dataDeclarationCheck');
    if (check) {
        check.addEventListener('change', syncDeclarationButton);
    }
}

/** Simpan data tabel lalu kirim (wajib centang pernyataan kebenaran data). */
async function saveAndSubmitForVerification() {
    const check = document.getElementById('dataDeclarationCheck');
    if (check && !check.checked) {
        if (typeof showToast === 'function') {
            showToast('⚠️ Silakan centang pernyataan kebenaran data terlebih dahulu sebelum menyimpan.');
        } else {
            alert('Silakan centang pernyataan kebenaran data terlebih dahulu sebelum menyimpan.');
        }
        check.scrollIntoView({ behavior: 'smooth', block: 'center' });
        check.focus();
        return;
    }

    if (!confirm('Apakah Anda yakin?')) {
        return;
    }

    const btn = document.getElementById('btnSaveAndSubmit');
    const originalLabel = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.classList.add('opacity-60', 'cursor-wait');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i><span>Menyimpan...</span>';
    }
    const restore = () => {
        if (!btn) return;
        btn.innerHTML = originalLabel;
        btn.classList.remove('opacity-60', 'cursor-wait');
        btn.disabled = false;
    };

    try {
        // 1. Simpan ke database
        window._hasUnsavedEdits = false;
        const saved = await persistTableData(false);
        if (saved !== true) {
            restore();
            return;
        }

        // 2. Kirim: catat pernyataan kebenaran data dan masukkan ke Monitoring sebagai "Input Data"
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || csrfToken;
        const res = await fetch(window.SiBingkaConfig.routes.apiSubmitVerification, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
            body: JSON.stringify({
                table_code: currentTableCode,
                opd_code: currentOpdCode,
                year: currentYear,
                type: (typeof currentType !== 'undefined' && currentType) ? currentType : 'opd',
                declaration: true,
                data_declared: true
            })
        });

        let data = null;
        try { data = await res.json(); } catch (_) { /* bukan JSON */ }

        if (!res.ok || !data || data.success !== true) {
            const reason = (data && data.message) || (res.status === 401 ? 'Sesi login habis. Silakan masuk kembali.' : 'Server menjawab kode ' + res.status + '.');
            showToast('❌ Data tersimpan, tetapi gagal dikirim: ' + reason);
            restore();
            return;
        }

        // 3. Notifikasi lalu kembali ke tampilan tabel
        showToast('✅ Data tabel berhasil disimpan dan dikirim.');
        setTimeout(() => {
            let url = `${window.SiBingkaConfig.routes.tabelOpd}?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&saved=1`;
            if (typeof currentType !== 'undefined' && currentType) url += `&type=${encodeURIComponent(currentType)}`;
            window.location.href = url;
        }, 800);
    } catch (e) {
        console.error(e);
        showToast('❌ Tidak dapat terhubung ke server. Periksa koneksi internet lalu coba lagi.');
        restore();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDeclarationBox);
} else {
    initDeclarationBox();
}
