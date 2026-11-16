# Struktur Kode SiBingka

Kode yang panjang sudah dipecah ke beberapa file kecil. Panduan ini menunjukkan di mana mengubah apa.

## Backend (PHP)

| Mau ubah | Buka file |
|---|---|
| Daftar alamat (route) | `routes/web.php` |
| Login, logout, Kelola Akun | `app/Http/Controllers/AuthController.php` |
| Hak akses halaman / sesi habis | `app/Http/Middleware/CheckSibingkaAuth.php` |
| Halaman Isi Data OPD / Instansi / BPS | `app/Http/Controllers/PageController.php` |
| Verifikasi Wali Data & validasi BPS (monitoring) | `app/Http/Controllers/MonitoringController.php` |
| Halaman tabel, simpan, hapus, ambil data | `app/Http/Controllers/TabelOpdController.php` |

`TabelOpdController` dibagi lagi menjadi bagian-bagian di `app/Http/Controllers/Concerns/TabelOpd/`:

| File | Isi |
|---|---|
| `ResolvesAgencies.php` | nama, kode, dan jenis instansi |
| `HandlesExcel.php` | ekspor dan impor Excel |
| `ManagesTableMetadata.php` | metadata tabel dan data tersimpan |
| `AdjustsTemplateYears.php` | salin template ke tahun lain |
| `ManagesCustomCatalog.php` | tabel buatan sendiri (custom) |
| `ManagesComments.php` | komentar pada tabel |
| `ManagesVerification.php` | kirim, verifikasi, tolak, buka kunci |
| `BuildsBab1Templates.php` ... `BuildsBab9Templates.php` | template HTML tabel per kelompok kode |

## Frontend (JavaScript)

| Folder / file | Isi |
|---|---|
| `public/js/core/base-url.js` | fungsi `sbUrl()` agar alamat benar walau web dipasang di sub-folder |
| `public/js/tabel/table-index/` | logika halaman tampilan tabel (dimuat berurutan 01, 02, ...) |
| `public/js/tabel/table-editor/` | logika halaman edit tabel (99-mulai-halaman.js dijalankan paling akhir) |
| `public/js/tabel/schemas-display/` | skema tabel untuk tampilan |
| `public/js/tabel/schemas-edit/` | skema tabel untuk form isian |
| `public/js/tabel/*.js` | helper bersama (helpers, navigation, comments, export-suite, templates) |
| `public/js/monitoring.js`, `public/js/dinas-catalog.js` | halaman monitoring dan katalog tabel |

Semua file `.js` di dalam folder bernomor dimuat otomatis, berurutan menurut nama file
(`resources/views/partials/script-group.blade.php`). Menambah tabel baru cukup membuat file baru
di `schemas-display/` dan `schemas-edit/`, contoh `99-tabel-baru.js`:

```js
Object.assign(window.tableSchemas, {
    'x.x.x': { titleId: '...', titleEn: '...', render: function (year) { return `...`; } },
});
```

## Tampilan (Blade) dan CSS

| Halaman | File utama | Bagian-bagiannya |
|---|---|---|
| Dashboard Admin | `resources/views/admin/dashboard.blade.php` | `resources/views/admin/partials/dashboard/` |
| Dashboard Pengguna | `resources/views/user/dashboard.blade.php` | `resources/views/user/partials/dashboard/` |
| Edit tabel | `resources/views/tabel/edit.blade.php` | `resources/views/tabel/partials/edit/` |
| Lihat tabel | `resources/views/tabel/index.blade.php` | `resources/views/tabel/partials/` |
| Header seluruh halaman | `resources/views/partials/navbar.blade.php` | |

CSS ada di `public/css/` (`dashboard.css`, `tabel-index.css`, `tabel-edit.css`, `login.css`).

## Alamat di JavaScript

Jangan menulis alamat seperti `fetch('/api/...')` langsung. Pakai `sbUrl('/api/...')`.
Web ini bisa dipasang di sub-folder (contoh `domain.go.id/sibingka-bukittinggi/`), dan alamat yang
diawali `/` tanpa `sbUrl()` akan mengarah ke root domain, bukan ke aplikasi ini.
