<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('PhpOffice\\PhpWord\\', __DIR__ . '/vendor/phpoffice/phpword/src/PhpWord/');
$loader->addPsr4('PhpOffice\\Math\\', __DIR__ . '/vendor/phpoffice/math/src/Math/');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\IOFactory;

$phpWord = new PhpWord();

// Set default font
$phpWord->setDefaultFontName('Calibri');
$phpWord->setDefaultFontSize(11);

// Add styles
$phpWord->addTitleStyle(1, ['name' => 'Calibri', 'size' => 14, 'bold' => true, 'color' => '1E3A8A'], ['spaceBefore' => 180, 'spaceAfter' => 80]);
$phpWord->addTitleStyle(2, ['name' => 'Calibri', 'size' => 11.5, 'bold' => true, 'color' => 'C2410C'], ['spaceBefore' => 140, 'spaceAfter' => 50]);

// Section with explicit INTEGER twips for A4 (11906 x 16838 twips)
// Crucial: Word strict schema fails if w:w or w:h are floating point numbers!
$section = $phpWord->addSection([
    'pageSizeW' => 11906,
    'pageSizeH' => 16838,
    'marginTop' => 1440,
    'marginBottom' => 1440,
    'marginLeft' => 1440,
    'marginRight' => 1440,
]);

// Header dan Footer
$header = $section->addHeader();
$header->addText('SiBingka Bukittinggi - Panduan Resmi Penggunaan Aplikasi untuk OPD / Dinas', ['size' => 9, 'color' => '64748B', 'italic' => true], ['alignment' => Jc::RIGHT]);

$footer = $section->addFooter();
$footer->addPreserveText('Halaman {PAGE} dari {NUMPAGES}  |  BPS Kota Bukittinggi dan Diskominfo Kota Bukittinggi', ['size' => 9, 'color' => '64748B'], ['alignment' => Jc::CENTER]);

// Judul Dokumen
$titleRun = $section->addTextRun(['alignment' => Jc::CENTER, 'spaceAfter' => 40]);
$titleRun->addText("PANDUAN OPERASIONAL PENGISIAN DATA SEKTORAL\n", ['size' => 16, 'bold' => true, 'color' => '1E3A8A']);
$titleRun->addText('SISTEM INFORMASI BUKITTINGGI DALAM ANGKA (SiBingka)', ['size' => 13, 'bold' => true, 'color' => 'EA580C']);

$subtitleRun = $section->addTextRun(['alignment' => Jc::CENTER, 'spaceAfter' => 160]);
$subtitleRun->addText("Tata Cara Penginputan Data, Template Excel, Pernyataan Keabsahan, dan Validasi Statistik\n", ['size' => 10, 'italic' => true, 'color' => '475569']);
$subtitleRun->addText('Pemerintah Kota Bukittinggi dan Badan Pusat Statistik (BPS) Kota Bukittinggi - Edisi 2026', ['size' => 9.5, 'color' => '64748B']);

// Garis Pemisah (menggunakan tabel 1 baris tipis agar 100% kompatibel tanpa VML pict)
$divider = $section->addTable(['alignment' => JcTable::CENTER, 'width' => 100 * 50, 'unit' => 'pct']);
$divider->addRow(20);
$divider->addCell(9000, ['bgColor' => 'CBD5E1']);

$section->addTextBreak(1);

// Box Ringkasan
$calloutTable = $section->addTable(['alignment' => JcTable::CENTER, 'width' => 100 * 50, 'unit' => 'pct']);
$calloutTable->addRow();
$calloutCell = $calloutTable->addCell(9000, ['bgColor' => 'EFF6FF', 'valign' => 'center']);
$calloutCell->addText('RINGKASAN EKSEKUTIF DAN KERANGKA SATU DATA', ['bold' => true, 'color' => '1D4ED8', 'size' => 10.5], ['spaceBefore' => 60, 'spaceAfter' => 40]);
$calloutCell->addText(
    "Aplikasi SiBingka (Sistem Informasi Bukittinggi Dalam Angka) dirancang sebagai jembatan kolaborasi data sektoral Satu Data Indonesia antara:\n1. Organisasi Perangkat Daerah (OPD) sebagai Produsen Data.\n2. Dinas Kominfo Kota Bukittinggi sebagai Wali Data Daerah.\n3. BPS Kota Bukittinggi sebagai Pembina Data Statistik.\nData yang diinputkan oleh dinas akan divalidasi dan digunakan sebagai sumber resmi rilis publikasi Kota Bukittinggi Dalam Angka.",
    ['size' => 9.5, 'color' => '1E293B'],
    ['spaceAfter' => 60]
);

$section->addTextBreak(1);

// BAB 1
$section->addTitle('BAB 1: AKSES DAN LOGIN SISTEM', 1);
$section->addText('Setiap dinas/OPD telah diberikan akun resmi terdaftar dengan kredensial terstandarisasi:', ['size' => 10]);

$step1 = $section->addTextRun(['spaceAfter' => 30]);
$step1->addText('1. Buka peramban (Google Chrome, Microsoft Edge, Mozilla Firefox) dan akses tautan web ', ['size' => 9.5]);
$step1->addText('SiBingka Bukittinggi.', ['bold' => true, 'color' => '1E3A8A']);

$step2 = $section->addTextRun(['spaceAfter' => 30]);
$step2->addText('2. Masukkan ', ['size' => 9.5]);
$step2->addText('Username Resmi Dinas ', ['bold' => true]);
$step2->addText('(contoh: dinas_pupr, dinas_kesehatan, dprd, diskoperindag, disdikbud).', ['italic' => true]);

$step3 = $section->addTextRun(['spaceAfter' => 80]);
$step3->addText('3. Masukkan ', ['size' => 9.5]);
$step3->addText('Kata Sandi 6 Digit Angka ', ['bold' => true]);
$step3->addText('resmi dinas Anda. Format sandi menggunakan kombinasi angka seragam (1375 + Nomor Urut OPD), lalu klik ', ['size' => 9.5]);
$step3->addText('Masuk ke Sistem.', ['bold' => true]);

// Tabel Contoh Akun
$tableHeaderStyle = ['bgColor' => 'F97316', 'valign' => 'center'];
$tableHeaderFontStyle = ['bold' => true, 'color' => 'FFFFFF', 'size' => 9.5];
$tableRowOddStyle = ['bgColor' => 'FFF7ED', 'valign' => 'center'];
$tableRowEvenStyle = ['bgColor' => 'FFFFFF', 'valign' => 'center'];
$tableCellFontStyle = ['size' => 9];

$opdTable = $section->addTable(['alignment' => JcTable::CENTER, 'width' => 100 * 50, 'unit' => 'pct']);
$opdTable->addRow(300);
$opdTable->addCell(800, $tableHeaderStyle)->addText('No', $tableHeaderFontStyle, ['alignment' => Jc::CENTER]);
$opdTable->addCell(4700, $tableHeaderStyle)->addText('Nama Dinas / OPD', $tableHeaderFontStyle);
$opdTable->addCell(2000, $tableHeaderStyle)->addText('Username', $tableHeaderFontStyle, ['alignment' => Jc::CENTER]);
$opdTable->addCell(1500, $tableHeaderStyle)->addText('Sandi', $tableHeaderFontStyle, ['alignment' => Jc::CENTER]);

$opdData = [
    ['1', 'Dinas Pendidikan dan Kebudayaan', 'disdikbud', '137501'],
    ['2', 'Dinas Kesehatan', 'dinas_kesehatan', '137502'],
    ['3', 'Dinas Pekerjaan Umum dan Penataan Ruang (PUPR)', 'dinas_pupr', '137503'],
    ['4', 'Dinas Perumahan dan Kawasan Permukiman', 'disperkim', '137504'],
    ['5', 'Dinas Sosial', 'dinsos', '137505'],
    ['6', 'DPRD Kota Bukittinggi', 'dprd', '137522'],
    ['7', 'Bappedalitbang', 'bappeda', '137517'],
    ['8', 'Dinas Komunikasi dan Informatika', 'diskominfo', '137514'],
];

foreach ($opdData as $idx => $row) {
    $rStyle = ($idx % 2 === 0) ? $tableRowOddStyle : $tableRowEvenStyle;
    $opdTable->addRow(260);
    $opdTable->addCell(800, $rStyle)->addText($row[0], $tableCellFontStyle, ['alignment' => Jc::CENTER]);
    $opdTable->addCell(4700, $rStyle)->addText($row[1], array_merge($tableCellFontStyle, ['bold' => true]));
    $opdTable->addCell(2000, $rStyle)->addText($row[2], $tableCellFontStyle, ['alignment' => Jc::CENTER]);
    $opdTable->addCell(1500, $rStyle)->addText($row[3], array_merge($tableCellFontStyle, ['bold' => true, 'color' => 'C2410C']), ['alignment' => Jc::CENTER]);
}

$section->addTextBreak(1);

// BAB 2
$section->addTitle('BAB 2: MEMILIH TABEL DAN TAHUN DATA', 1);
$section->addText('Setelah login berhasil:', ['size' => 10]);
$section->addListItem('Pilih menu "Isi Data OPD" pada dashboard atau panel navigasi.', 0, ['size' => 9.5]);
$section->addListItem('Sistem otomatis menampilkan daftar seluruh tabel statistik yang berada di bawah kewenangan dinas Anda.', 0, ['size' => 9.5]);
$section->addListItem('Gunakan menu dropdown "Tahun Data" (contoh: 2026, 2025, 2024, dst) di bagian atas untuk berpindah tahun pengumpulan. Tampilan tabel dan status verifikasi akan otomatis menyesuaikan secara instan.', 0, ['size' => 9.5]);

$section->addTextBreak(1);

// BAB 3
$section->addTitle('BAB 3: METODE PENGISIAN DATA', 1);
$section->addText('Aplikasi SiBingka menyediakan 2 (dua) metode pengisian data yang sangat fleksibel:', ['size' => 10]);

$section->addTitle('Metode A: Pengisian Langsung via Web (Online Editor)', 2);
$section->addListItem('Klik tombol "Edit Data" (warna oranye) di atas tabel yang bersangkutan.', 0, ['size' => 9.5]);
$section->addListItem('Sel data numerik akan berubah menjadi kotak isian interaktif.', 0, ['size' => 9.5]);
$section->addListItem('Ketik angka pada baris/kolom terkait. Angka total / jumlah akan otomatis dihitung oleh sistem secara instan.', 0, ['size' => 9.5]);
$section->addListItem('Jika data tidak tersedia atau nihil, ketikkan tanda strip "-".', 0, ['size' => 9.5]);
$section->addListItem('Setelah selesai, klik tombol hijau "Simpan Perubahan" di bagian atas/bawah tabel.', 0, ['size' => 9.5]);

$section->addTitle('Metode B: Pengisian via Template Excel (Download dan Import)', 2);
$section->addListItem('Langkah 1: Klik tombol "Export / Download" lalu pilih "Download Template Excel (Kosong)". Sistem akan mengunduh berkas .xlsx resmi yang formatnya 100% presisi sesuai struktur tabel BPS.', 0, ['size' => 9.5]);
$section->addListItem('Langkah 2: Buka berkas Excel tersebut di komputer dinas. Isi angka pada kolom tahun atau rincian yang bersangkutan.', 0, ['size' => 9.5]);
$section->addListItem('Langkah 3: Simpan file Excel Anda (Save As / Ctrl + S).', 0, ['size' => 9.5]);
$section->addListItem('Langkah 4: Kembali ke aplikasi web SiBingka, klik tombol "Import" (warna hijau muda) di atas tabel.', 0, ['size' => 9.5]);
$section->addListItem('Langkah 5: Pilih file Excel yang telah Anda isi, lalu klik tombol "Proses Import Data". Data akan langsung tersimpan dan tabel otomatis terisi rapi.', 0, ['size' => 9.5]);

$section->addTextBreak(1);

// BAB 4
$section->addTitle('BAB 4: ATURAN PENTING DAN PENCEGAHAN KESALAHAN IMPORT EXCEL', 1);

$tipTable = $section->addTable(['alignment' => JcTable::CENTER, 'width' => 100 * 50, 'unit' => 'pct']);
$tipTable->addRow();
$tipCell = $tipTable->addCell(9000, ['bgColor' => 'FEF3C7', 'valign' => 'center']);
$tipCell->addText('PERHATIAN KHUSUS FORMAT EXCEL:', ['bold' => true, 'color' => 'B45309', 'size' => 10], ['spaceBefore' => 50, 'spaceAfter' => 30]);
$tipCell->addText(
    "- Jangan Menambah / Menghapus Kolom: Struktur kolom header (Kolom A, B, C, dst) harus sesuai dengan template yang diunduh dari SiBingka.\n- Jangan Mengubah Urutan Baris: Baris nama kecamatan atau kategori tidak boleh dipindahkan posisinya.\n- Format Tabel Multi-Tahun (Contoh: Tabel 2.2.5 DPRD dan Tabel 8.1.4 PUPR):\n   * Pada Tabel 2.2.5: Kolom A adalah Jenis Keputusan, Kolom B sampai F adalah Tahun 2021 hingga 2025.\n   * Pada Tabel 8.1.4: Kolom A adalah Rincian Kecamatan / Tahun, Kolom C adalah Banyaknya Jembatan, Kolom D adalah Panjang Jembatan.\n- Fitur Proteksi Cerdas SiBingka: Sistem telah dilengkapi deteksi tabel ganda dan filter otomatis, sehingga proses import tidak akan menggandakan tabel ke bawah.",
    ['size' => 9.5, 'color' => '78350F'],
    ['spaceAfter' => 50]
);

$section->addTextBreak(1);

// BAB 5
$section->addTitle('BAB 5: PERNYATAAN KEABSAHAN DAN PENGAJUAN VALIDASI', 1);
$section->addText('Setelah angka selesai diisi dan dipastikan akurat oleh operator dinas:', ['size' => 10]);
$section->addListItem('Centang kotak Pakta Integritas / Pernyataan Keabsahan Data: "Saya menyatakan bahwa data yang diinputkan adalah benar dan sah sesuai catatan resmi dinas".', 0, ['size' => 9.5]);
$section->addListItem('Klik tombol "Kirim Data / Ajukan Validasi" (warna biru/hijau).', 0, ['size' => 9.5]);
$section->addListItem('Status tabel akan berubah menjadi "Menunggu Validasi Diskominfo / BPS".', 0, ['size' => 9.5]);
$section->addListItem('Wali Data (Diskominfo) dan Pembina Data (BPS) akan memeriksa konsistensi angka. Jika disetujui, status akan menjadi "Tervalidasi / Disetujui (ACC Data)". Jika ada catatan, status berubah menjadi "Perlu Revisi" disertai catatan perbaikan.', 0, ['size' => 9.5]);

$section->addTextBreak(1);

// BAB 6
$section->addTitle('BAB 6: LAYANAN BANTUAN DAN KONTAK HELPDESK', 1);
$section->addText('Apabila menemui kendala teknis atau pertanyaan metodologi statistik:', ['size' => 10]);

$contactTable = $section->addTable(['alignment' => JcTable::CENTER, 'width' => 100 * 50, 'unit' => 'pct']);
$contactTable->addRow(280);
$contactTable->addCell(3000, $tableHeaderStyle)->addText('Instansi / Peran', $tableHeaderFontStyle);
$contactTable->addCell(4000, $tableHeaderStyle)->addText('Fungsi Pendampingan', $tableHeaderFontStyle);
$contactTable->addCell(3000, $tableHeaderStyle)->addText('Saluran Bantuan', $tableHeaderFontStyle);

$contactTable->addRow(260);
$contactTable->addCell(3000, $tableRowOddStyle)->addText('BPS Kota Bukittinggi', array_merge($tableCellFontStyle, ['bold' => true]));
$contactTable->addCell(4000, $tableRowOddStyle)->addText('Pembina Data Statistik, Standar Data, Metodologi, dan Rekomendasi Statistik', $tableCellFontStyle);
$contactTable->addCell(3000, $tableRowOddStyle)->addText('PST BPS Kota Bukittinggi / Tim Nerwilis', $tableCellFontStyle);

$contactTable->addRow(260);
$contactTable->addCell(3000, $tableRowEvenStyle)->addText('Diskominfo Kota Bukittinggi', array_merge($tableCellFontStyle, ['bold' => true]));
$contactTable->addCell(4000, $tableRowEvenStyle)->addText('Wali Data Daerah, Kebijakan Satu Data, dan Akses Jaringan Pemko', $tableCellFontStyle);
$contactTable->addCell(3000, $tableRowEvenStyle)->addText('Bidang Statistik dan Layanan E-Gov Diskominfo', $tableCellFontStyle);

// Save document
$outPaths = [
    'D:/WEB/bps/PANDUAN_PENGGUNAAN_SIBINGKA_UNTUK_DINAS.docx',
    __DIR__ . '/PANDUAN_PENGGUNAAN_SIBINGKA_UNTUK_DINAS.docx',
];

$writer = IOFactory::createWriter($phpWord, 'Word2007');
foreach ($outPaths as $path) {
    $writer->save($path);
    echo "Saved to: $path (size: " . filesize($path) . " bytes)\n";
}
