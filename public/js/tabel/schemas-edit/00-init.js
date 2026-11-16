/**
 * SiBingka Kota Bukittinggi - Skema tabel (form isian / edit)
 * Satu file memuat beberapa tabel. Semua file di folder ini dimuat otomatis, berurutan
 * menurut nama file (lihat resources/views/partials/script-group.blade.php).
 * Menambah tabel baru: buat file baru di folder ini, contoh 99-tabel-baru.js, lalu
 * isi dengan Object.assign(window.tableSchemas, { 'x.x.x': { ... } });
 */

window.tableSchemas = window.tableSchemas || {};
