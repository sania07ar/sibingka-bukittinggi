/** SiBingka | table-editor | pernyataan kebenaran data & kirim ke Wali Data
 *  Dimuat berurutan bersama file lain di folder ini (partials/script-group).
 *
 *  Alur: centang pernyataan -> tombol "Simpan & Kirim ke Wali Data" aktif -> data disimpan ke database
 *  -> dikirim ke Wali Data (masuk Monitoring sebagai "Input Data") -> verifikasi Wali Data -> validasi Admin BPS.
 */

function syncDeclarationButton() {
    const check = document.getElementById('dataDeclarationCheck');
    const btn = document.getElementById('btnSaveAndSubmit');
    if (!check || !btn) return;
    const on = check.checked;
    btn.disabled = !on;
    btn.classList.toggle('opacity-50', !on);
    btn.classList.toggle('cursor-not-allowed', !on);
    btn.classList.toggle('cursor-pointer', on);
    btn.title = on ? 'Simpan data lalu kirim ke Wali Data' : 'Centang pernyataan kebenaran data terlebih dahulu';
}

function initDeclarationBox() {
    const check = document.getElementById('dataDeclarationCheck');
    if (!check) return;
    check.addEventListener('change', syncDeclarationButton);
    syncDeclarationButton();
}

/** Simpan data tabel, lalu kirim ke Wali Data dengan pernyataan kebenaran data. */
async function saveAndSubmitForVerification() {
    const check = document.getElementById('dataDeclarationCheck');
    const btn = document.getElementById('btnSaveAndSubmit');

    if (!check || !check.checked) {
        showToast('⚠️ Centang pernyataan kebenaran data terlebih dahulu.');
        if (check) check.focus();
        return;
    }
    if (!confirm('Apakah Anda yakin?')) {
        return;
    }

    const originalLabel = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.classList.add('opacity-60', 'cursor-wait');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i><span>Mengirim...</span>';
    }
    const restore = () => {
        if (!btn) return;
        btn.innerHTML = originalLabel;
        btn.classList.remove('opacity-60', 'cursor-wait');
        syncDeclarationButton();
    };

    try {
        // 1. Simpan dulu ke database; berhenti kalau gagal.
        window._hasUnsavedEdits = false;
        const saved = await persistTableData(false);
        if (saved !== true) {
            restore();
            return;
        }

        // 2. Kirim ke Wali Data.
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || csrfToken;
        const res = await fetch(window.SiBingkaConfig.routes.apiSubmitVerification, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({
                table_code: currentTableCode,
                opd_code: currentOpdCode,
                year: currentYear,
                type: (typeof currentType !== 'undefined' && currentType) ? currentType : 'opd',
                declaration: true
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

        showToast('✅ ' + data.message);
        setTimeout(() => {
            let url = `${window.SiBingkaConfig.routes.tabelOpd}?code=${encodeURIComponent(currentTableCode)}&opd=${encodeURIComponent(currentOpdCode)}&year=${encodeURIComponent(currentYear)}&saved=1`;
            if (typeof currentType !== 'undefined' && currentType) url += `&type=${encodeURIComponent(currentType)}`;
            window.location.href = url;
        }, 900);
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
