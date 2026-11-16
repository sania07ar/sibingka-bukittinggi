# Status Perbaikan SiBingka

## Perubahan pada versi ini

1. Endpoint penyimpanan tabel (`POST /api/tabel-opd/save`) memvalidasi payload sebelum menyimpan.
2. Penyimpanan metadata dan nilai baris dijalankan dalam satu transaksi database. Jika satu bagian gagal, transaksi dibatalkan.
3. Kegagalan database sekarang mengembalikan HTTP 500 dan `success: false`; aplikasi tidak lagi melaporkan penyimpanan berhasil ketika database gagal.
4. Snapshot JSON hanya ditulis setelah transaksi database berhasil. Penulisan snapshot menggunakan file sementara lalu rename agar tidak meninggalkan file setengah tertulis.
5. Snapshot baru menggunakan nama yang di-scope berdasarkan tipe, OPD, kode tabel, dan tahun. Penyimpanan tidak lagi menulis file snapshot global yang dapat tertukar antar-OPD.
6. Penghapusan snapshot tidak lagi menghapus file legacy global yang mungkin dipakai OPD/instansi lain.
7. Validasi ukuran HTML, metadata, nilai sel, tahun, tipe, dan row key ditambahkan.

## Pemeriksaan otomatis yang berhasil

- 43 file PHP pada `app`, `bootstrap`, `config`, `database`, `routes`, dan `tests`: lulus `php -l`.
- Seluruh file JavaScript pada `public` dan `resources`: lulus `node --check`.

## Batas pemeriksaan

Paket sumber yang tersedia tidak menyertakan `vendor/`, `node_modules/`, salinan database produksi, maupun kredensial hosting. Karena itu pemeriksaan berikut belum dapat dijalankan dari lingkungan ini:

- Laravel feature/integration tests terhadap MySQL.
- Pengujian langsung login dengan seluruh role.
- Uji tambah/edit/hapus pada semua kombinasi OPD, instansi, BPS, dan tahun.
- Uji import berbagai workbook Excel asli dan variasi formatnya.
- Uji export Excel/PDF pada server hosting.
- Uji beban, backup/restore, permission server, SSL, dan konfigurasi web server.

**Kesimpulan:** versi ini memperbaiki cacat penyimpanan yang ditemukan, tetapi belum boleh disebut 100% siap produksi sebelum seluruh uji integrasi di atas lulus di staging/hosting dengan database salinan. Tidak ada perangkat lunak yang dapat dijamin bebas kesalahan mutlak.

## Wajib sebelum deployment

1. Buat staging dan backup database/file lama terlebih dahulu.
2. Gunakan PHP 8.3+ (sesuai `composer.json`) dan MySQL/MariaDB yang kompatibel.
3. Arahkan document root domain ke folder `public/`, bukan root proyek.
4. Isi `.env` produksi: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domain-anda`, `APP_KEY` unik, kredensial DB produksi, serta konfigurasi session/cookie HTTPS.
5. Ganti semua password bawaan akun admin, operator BPS, wali data, OPD, dan instansi. Source project saat ini masih memiliki beberapa kredensial/default password lama; jangan gunakan kredensial bawaan tersebut di server publik.
6. Jalankan `composer install --no-dev --optimize-autoloader`, `php artisan migrate --force`, `php artisan storage:link`, dan build aset frontend sesuai pipeline proyek.
7. Pastikan `storage/` dan `bootstrap/cache/` dapat ditulis oleh user proses web; folder source lain tidak perlu writable.
8. Jalankan `php artisan config:cache`, `php artisan route:cache` (setelah memastikan tidak ada route closure yang menghalanginya), dan `php artisan view:cache`.
9. Uji dengan akun peran berbeda dan data uji: edit → simpan → refresh → buka kembali; pastikan nilai tetap sama. Uji juga dua OPD berbeda untuk kode tabel/tahun yang sama guna memastikan isolasi.
10. Baru setelah hasil uji disetujui, lakukan cutover ke domain produksi.

## Uji edit minimal yang harus dilakukan

- Edit judul, sumber, catatan, dan beberapa sel angka; simpan; refresh; pastikan seluruh perubahan tetap ada.
- Ulangi pada dua OPD yang berbeda dengan kode tabel dan tahun yang sama.
- Ulangi pada tipe BPS dan instansi.
- Putuskan koneksi database saat menyimpan di staging; UI harus menampilkan gagal, bukan berhasil.
- Pastikan kegagalan simpan tidak mengubah snapshot JSON menjadi versi baru.
