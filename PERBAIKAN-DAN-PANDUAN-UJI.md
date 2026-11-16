# Catatan Perbaikan SiBingka

## Perubahan pada paket ini

1. **Simpan data lebih aman**
   - Browser sekarang menunggu jawaban API dan memeriksa status HTTP serta `success` dari server.
   - Pesan berhasil tidak lagi ditampilkan ketika server gagal menyimpan.
   - Cache lokal baru diperbarui setelah server mengonfirmasi penyimpanan. Database menjadi sumber data utama.
2. **Arah penyimpanan saat impor**
   - Struktur template untuk impor dicari berdasarkan kode OPD/instansi dan jenis data yang sedang dibuka.
   - Template dari tahun lain tidak lagi dipakai sebagai model database untuk kemudian disimpan, sehingga record tahun/instansi asal tidak tertimpa.
3. **Impor Excel**
   - Nilai angka dari Excel dikonversi ke teks secara aman sebelum diproses. Sebelumnya, `trim()` langsung pada angka dapat menyebabkan `TypeError` di PHP 8.
   - Validasi ekstensi, ukuran, dan status unggahan ditambahkan.
   - Pesan gagal impor dibuat lebih mudah dipahami.
4. **URL**
   - URL impor dan ekspor template diambil dari route Laravel, bukan alamat root yang di-hardcode. Ini lebih aman saat aplikasi dipasang di subfolder/domain berbeda.

## Persiapan menjalankan aplikasi

Persyaratan paket saat ini: PHP 8.3+, Composer, Node.js/npm, dan database yang dikonfigurasi pada `.env`.

Jalankan dari folder proyek:

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Isi koneksi database di `.env`, lalu jalankan:

```bash
php artisan migrate --seed
npm install
npm run build
php artisan storage:link
php artisan optimize:clear
php artisan serve
```

Jika aplikasi sudah memiliki database berisi data produksi, **backup database terlebih dahulu** dan jangan menjalankan seeder tanpa memastikan isi seeder aman untuk database tersebut.

## Jika unggah Excel masih gagal

Batas unggah aplikasi ditetapkan 20 MB. Pastikan konfigurasi PHP juga mengizinkan ukuran tersebut (misalnya `upload_max_filesize = 20M` dan `post_max_size = 24M`), lalu restart PHP/web server. Gunakan file `.xlsx`, `.xls`, atau `.csv` yang berisi tabel sesuai template SiBingka. Untuk hasil paling konsisten, unduh template dari tombol **Unduh Template Excel**, isi template tersebut, lalu impor kembali.

## Checklist uji setelah dipasang

- Login dengan akun uji OPD, Instansi, dan Admin.
- Buka satu tabel, ubah angka, simpan, lalu buka ulang halaman dan pastikan angka tetap sama.
- Uji simpan pada dua OPD/instansi berbeda dengan kode tabel yang sama (jika katalog memiliki kasus tersebut); pastikan data tidak tertukar.
- Unduh template Excel, isi beberapa sel angka dan teks, lalu impor. Pastikan hasilnya masuk ke tabel yang sedang dibuka.
- Uji impor file kosong, file bukan Excel, dan file di atas 20 MB; aplikasi seharusnya menolak dengan pesan yang jelas.
- Uji tambah/hapus baris, ganti tahun, ekspor Excel/PDF, komentar, dan alur verifikasi sesuai hak akses.

## Catatan verifikasi

Paket sumber tidak menyertakan `vendor/`, `.env`, atau database sehingga pengujian end-to-end (login, query database, upload nyata, dan seluruh alur tombol) harus dilakukan setelah dependensi dan database milik instalasi dipasang. Pemeriksaan sintaks PHP dan JavaScript dilakukan pada file proyek; ini bukan pengganti uji fungsional di server.
