# 📘 Panduan Struktur File & Panduan Perubahan Data
## SiBingka (Sistem Informasi Bukittinggi dalam Angka) - BPS Kota Bukittinggi

Dokumen ini dibuat khusus sebagai panduan navigasi cepat jika Anda ingin mengubah nama dinas, daftar instansi, judul tabel, link Google Drive, akun pengguna, atau tampilan website secara manual.

---

## 📌 Ringkasan Cepat: Di Mana Mengubah Apa?

| Keinginan Anda | File yang Perlu Diedit | Lokasi Baris / Keterangan |
| :--- | :--- | :--- |
| **Menambah / Mengubah Nama OPD** | `resources/views/dinas/isi-opd.blade.php` | Bagian `@php $allOpds = [ ... ] @endphp` |
| **Menambah / Mengubah Daftar Instansi Vertikal** | `resources/views/dinas/isi-instansi.blade.php` | Bagian `@php $instansiList = [ ... ] @endphp` |
| **Mengubah Daftar & Deskripsi Data BPS (PODES, Susenas, dll)** | `resources/views/dinas/data-bps.blade.php` | Bagian `@php $bpsDatasets = [ ... ] @endphp` |
| **Mengubah Judul & Kode Tabel Publikasi BPS (Master Catalog)** | `public/sibingka-catalogs.js` | `opdTablesCatalog`, `instansiTablesCatalog`, `bpsTablesCatalog` |
| **Mengubah Link Folder Google Drive Blanko PDF** | `resources/views/dinas/isi-opd.blade.php` & `isi-instansi.blade.php` | Cari teks `https://drive.google.com/drive/folders/...` |
| **Mengubah Link Google Drive per Dataset BPS** | `resources/views/dinas/data-bps.blade.php` | Di dalam array `$bpsDatasets` pada kunci `'link'` |
| **Mengubah Desain Pop-up Daftar Tabel** | `resources/views/dinas/partials/modal-tabel-list.blade.php` | Komponen modal daftar tabel |
| **Mengubah Pop-up Pilihan Tahun** | `resources/views/dinas/partials/modal-pilih-tahun.blade.php` | Komponen modal pilih tahun |
| **Mengubah Form Pop-up Tambah Tabel Baru** | `resources/views/dinas/partials/modal-tambah-tabel.blade.php` | Komponen form tambah tabel kustom |
| **Mengubah Footer / Tulisan Bawah / Info Kontak BPS** | `resources/views/dinas/partials/footer.blade.php` | Komponen footer & session login |
| **Mengubah Halaman Monitoring OPD** | `resources/views/monitoring/opd.blade.php` | Halaman progres 5 tahap OPD |
| **Mengubah Halaman Monitoring Instansi** | `resources/views/monitoring/instansi.blade.php` | Halaman progres 5 tahap Instansi |
| **Mengubah Kartu Tahapan Progres Monitoring** | `resources/views/monitoring/partials/item-card.blade.php` | Komponen kartu stepper 1-5 |
| **Mengubah Pop-up Riwayat Detail Monitoring** | `resources/views/monitoring/partials/modal-detail.blade.php` | Pop-up log aktivitas & stage switcher |
| **Mengubah Tampilan Halaman Pengisian Angka Tabel** | `resources/views/tabel/index.blade.php` & `edit.blade.php` | Header tabel, kolom data, dan tombol simpan |
| **Mengubah Akun Dinas / Login / Password** | Database tabel `users` atau `app/Http/Controllers/AuthController.php` | Autentikasi dan data pengguna |
| **Mengubah Logika Simpan Data Tabel ke Database** | `app/Http/Controllers/TabelOpdController.php` | Logika controller CRUD tabel |
| **Alur & Tombol Verifikasi/ACC Tabel** | `resources/views/tabel/index.blade.php` | Tombol ACC Data, Minta Revisi, Kirim ke BPS |

---

## 🛡️ Alur Kerja Verifikasi & ACC Data (Satu Data Indonesia)

Sistem SiBingka kini dilengkapi alur verifikasi resmi antara produsen data (Dinas/Instansi) dan pembina data (BPS Bukittinggi):

1. **Pengisian Data oleh Dinas/OPD:**
   * Dinas masuk dan langsung mengisi/mengedit angka pada tabel mereka.
   * Setiap data yang diisi atau disimpan langsung terpantau oleh BPS melalui halaman **Monitoring**.
   * Dinas **tidak perlu repot menekan tombol kirim** secara manual, karena progres pengisian mereka sudah terdata otomatis.

2. **Pemeriksaan & Tindakan oleh Admin BPS:**
   * Tombol menu dropdown **"Tindakan"** (dengan opsi *ACC Data*, *Minta Revisi*, dan *Buka Kunci Tabel*) **eksklusif hanya untuk Admin BPS**.
   * **Jika Data Sesuai:** Admin BPS memilih **"ACC Data"**.
     * Status tabel berubah menjadi `verified` (*DI-ACC*) dan tabel otomatis **terkunci (*read-only*)** agar dinas tidak mengubah angka lagi.
     * Nama admin dan waktu persetujuan dicatat resmi dalam database.
     * Halaman Monitoring dinas otomatis naik ke **Tahap 4 (Validasi BPS Selesai / Siap Integrasi)**.
   * **Jika Ada Data Janggal:** Admin BPS memilih **"Minta Revisi"** dan mengetikkan catatan perbaikan (misal: *"Kolom 2 tahun 2024 melonjak tidak wajar"*).
     * Status tabel berubah menjadi `revision` (*Perlu Revisi*).
     * Pesan catatan BPS langsung tampil di banner merah pada tabel dinas.
     * Halaman Monitoring dinas otomatis kembali ke **Tahap 2 (Perlu Revisi)**.
   * **Buka Kunci:** Admin BPS dapat memilih opsi **"Buka Kunci Tabel"** kapan saja melalui menu Tindakan jika dinas perlu mengedit data yang sudah di-ACC atas izin BPS.

---

## 💬 Fitur Catatan & Komentar Rincian Data (Drawer Chat Samping)

Fitur ini memungkinkan **Dinas/OPD** dan **Admin BPS** saling berdiskusi, memberikan catatan penjelasan, atau bertanya tentang angka data tertentu:

1. **Tombol "Catatan" di Header Toolbar:**
   * Tampil di halaman lihat data ([`tabel/index.blade.php`](file:///d:/WEB/bps/sibingka-bukittinggi/resources/views/tabel/index.blade.php)) dan halaman edit ([`tabel/edit.blade.php`](file:///d:/WEB/bps/sibingka-bukittinggi/resources/views/tabel/edit.blade.php)).
   * Memiliki badge counter: `Catatan (X)` yang menunjukkan total komentar aktif pada tabel tersebut.
2. **Indikator pada Sel Tabel (Visual & Interaktif):**
   * Sel yang memiliki catatan akan diberi **tanda pin oranye di sudut kanan atas** (`corner pin`) dan **badge oranye hidup `[💬 X]`** berisi jumlah komentar.
   * Sel tanpa catatan: saat kursor diarahkan (*hover*), akan muncul ikon komentar kecil `💬` agar pengguna bisa langsung mengeklik dan menambahkan catatan baru.
3. **Slide-Over Drawer (Panel Samping):**
   * Mengeklik tombol catatan atau badge sel akan membuka panel drawer di sisi kanan layar.
   * Menampilkan rincian sel (nama baris & judul kolom), riwayat obrolan/komentar antara OPD dan BPS lengkap dengan tanggal dan badge role (`BPS` / `OPD`), serta kotak input untuk mengirim komentar baru atau menghapus catatan lama.

---

## 📂 Struktur Direktori Penting

```text
sibingka-bukittinggi/
├── app/
│   └── Http/
│       └── Controllers/
│           ├── AuthController.php           # Logika login & logout pengguna
│           ├── MonitoringController.php     # Logika halaman monitoring tahapan
│           └── TabelOpdController.php       # Logika data tabel & API katalog kustom
│
├── public/
│   ├── js/
│   │   ├── dinas-catalog.js                 # JS interaktif: pop-up, live search, paginasi
│   │   └── monitoring.js                    # JS monitoring: filter, ganti tahap, export Excel
│   ├── sibingka-catalogs.js                  # Master katalog daftar tabel DDA (OPD, Instansi, BPS)
│   └── images/                              # Logo BPS, watermark pita Sensus Ekonomi, avatar
│
├── resources/
│   └── views/
│       ├── dinas/
│       │   ├── isi-opd.blade.php            # Halaman utama pemilihan OPD
│       │   ├── isi-instansi.blade.php       # Halaman utama pemilihan Instansi Vertikal
│       │   ├── data-bps.blade.php           # Halaman utama katalog 10 dataset BPS
│       │   └── partials/                    # File pecahan (agar rapi & mudah diedit)
│       │       ├── modal-tabel-list.blade.php   # Modal pop-up daftar tabel
│       │       ├── modal-pilih-tahun.blade.php  # Modal pop-up pilih tahun
│       │       ├── modal-tambah-tabel.blade.php # Modal pop-up tambah tabel baru
│       │       └── footer.blade.php             # Footer bar & session logout
│       │
│       ├── monitoring/
│       │   ├── opd.blade.php                # Halaman monitoring OPD (ringkas)
│       │   ├── instansi.blade.php           # Halaman monitoring Instansi (ringkas)
│       │   └── partials/                    # Komponen stepper, ringkasan, dan detail
│       │
│       ├── tabel/
│       │   ├── index.blade.php              # Tampilan data tabel publikasi
│       │   └── edit.blade.php               # Form edit data tabel
│       │
│       └── partials/
│           └── navbar.blade.php             # Header atas (Logo BPS, Judul SiBingka)
│
└── routes/
    └── web.php                              # Daftar semua alamat URL website
```

---

## 💡 Contoh Praktis Cara Mengubah Data

### 1. Cara Menambah / Mengubah Nama Dinas (OPD)
Buka file **`resources/views/dinas/isi-opd.blade.php`**, cari bagian:
```php
$allOpds = [
    ['code' => '01', 'short' => 'Dinas PUPR', 'full' => 'Dinas Pekerjaan Umum dan Penataan Ruang', 'search' => '01 dinas pupr', 'icon' => 'fa-city'],
    // Tambahkan atau ubah baris di sini...
];
```
* **`code`**: Nomor urut dinas (misal: `'21'`).
* **`short`**: Nama singkatan dinas yang tampil di tombol kartu.
* **`full`**: Nama lengkap resmi dinas.
* **`icon`**: Kode icon FontAwesome (contoh: `'fa-hospital'`, `'fa-school'`, `'fa-building'`).

---

### 2. Cara Menambah Judul Tabel Baru di Katalog Master
Buka file **`public/sibingka-catalogs.js`**, cari kode OPD yang bersangkutan:
```javascript
const opdTablesCatalog = {
    '01': [
        { code: '1.1.6', title: 'Nama Sungai/Batang di Bukittinggi', titleEn: 'Name of River...' },
        // Tambahkan tabel baru di sini:
        { code: '1.1.7', title: 'Judul Tabel Baru Bahasa Indonesia', titleEn: 'Table Title in English' }
    ],
    // ...
};
```

---

### 3. Cara Mengubah Link Folder Google Drive
* **Untuk Folder Blanko PDF Umum:**
  Buka `resources/views/dinas/isi-opd.blade.php` atau `isi-instansi.blade.php`, cari teks:
  ```html
  href="https://drive.google.com/drive/folders/1ytU-i5aTt7-94u2jiNefX8Ef0Hqr3_5E"
  ```
  Ganti link tersebut dengan link folder Google Drive yang baru.

* **Untuk Dataset Internal BPS:**
  Buka `resources/views/dinas/data-bps.blade.php`, cari array `$bpsDatasets` dan ganti nilai `'link'` pada dataset yang diinginkan (misal PODES, Susenas, Sakernas).

---

## ⚡ Tips Jika Perubahan Belum Muncul di Browser
Jika Anda sudah mengubah file blade atau script tetapi di browser belum berubah, jalankan perintah ini di terminal:

```bash
# 1. Bersihkan cache tampilan blade
php artisan view:clear

# 2. Bersihkan cache konfigurasi & rute
php artisan route:clear
php artisan config:clear
```
Lalu di browser Anda, tekan tombol **`Ctrl + F5`** (Hard Refresh) untuk membersihkan cache browser.
