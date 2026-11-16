/**
 * SiBingka - Alamat dasar aplikasi (base URL)
 *
 * Aplikasi bisa berjalan di sub-folder (contoh: https://domain.go.id/sibingka-bukittinggi/).
 * Alamat yang ditulis langsung seperti "/login" atau "/api/..." akan salah arah karena
 * mengarah ke root domain. Pakai sbUrl('/path') supaya alamat selalu benar.
 *
 *   sbUrl('/tabel-opd/import-excel')  ->  /sibingka-bukittinggi/tabel-opd/import-excel
 */
(function (w) {
    'use strict';

    function detectBase() {
        // 1. Diisi server lewat partials/base-url.blade.php
        if (typeof w.SiBingkaBaseUrl === 'string') {
            return w.SiBingkaBaseUrl.replace(/\/+$/, '');
        }
        // 2. Cadangan: turunkan dari alamat file script ini sendiri
        var el = document.currentScript;
        if (el && el.src) {
            try {
                var p = new URL(el.src, w.location.href).pathname;
                var i = p.indexOf('/js/core/base-url.js');
                if (i >= 0) return p.slice(0, i).replace(/\/+$/, '');
            } catch (e) { /* abaikan */ }
        }
        return '';
    }

    var BASE = detectBase();

    /** Tambahkan alamat dasar ke path aplikasi. URL penuh (http/https) dibiarkan. */
    function sbUrl(path) {
        path = String(path == null ? '' : path);
        if (/^([a-z][a-z0-9+.-]*:)?\/\//i.test(path)) return path;
        if (path.charAt(0) !== '/') path = '/' + path;
        if (BASE && (path === BASE || path.indexOf(BASE + '/') === 0)) return path;
        return BASE + path;
    }

    w.sbBaseUrl = BASE;
    w.sbUrl = sbUrl;
})(window);
