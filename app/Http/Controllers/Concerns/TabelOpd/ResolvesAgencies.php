<?php

namespace App\Http\Controllers\Concerns\TabelOpd;

use App\Models\TabelData;
use App\Models\TabelMetadata;
use App\Models\TabelComment;
use App\Exports\TableOpdExport;
use App\Imports\TableOpdImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

/**
 * Nama, kode, dan jenis instansi (OPD / Instansi Vertikal / BPS).
 * Dipakai oleh App\Http\Controllers\TabelOpdController.
 */
trait ResolvesAgencies
{
    /**
     * Tampilkan Halaman Tabel OPD dengan Data dari Database
     */
    /**
     * Pastikan opd_code selaras dengan tabel resmi Daerah Dalam Angka
     */
    protected function normalizeOpdCode(string $tableCode, string $opdCode): string
    {
        if (str_starts_with($tableCode, '5.') || $tableCode === '9.11') {
            return '17'; // Dinas Pertanian dan Pangan Kota Bukittinggi
        }
        if (str_starts_with($tableCode, '7.')) {
            return '19'; // Dinas Pariwisata, Pemuda dan Olahraga
        }
        if (in_array($tableCode, ['8.1.6', '8.1.7', '8.1.8', '8.1.9'])) {
            return '20'; // Dinas Perhubungan
        }
        if (str_starts_with($tableCode, '8.1.') || str_starts_with($tableCode, '8.2.')) {
            return '01'; // Dinas PUPR
        }
        if (str_starts_with($tableCode, '2.2.')) {
            $cleanPassed = str_pad($opdCode, 2, '0', STR_PAD_LEFT);
            if ($cleanPassed === '02') {
                return '02'; // KPU Kota Bukittinggi
            }
            return '03'; // Sekretariat DPRD
        }
        if (str_starts_with($tableCode, '2.3.')) {
            return '04'; // BKPSDM
        }
        if (str_starts_with($tableCode, '2.4.')) {
            return '05'; // Badan Keuangan Daerah
        }
        if (str_starts_with($tableCode, '9.')) {
            return '07'; // Dinas Koperasi, UKM dan Tenaga Kerja
        }
        if ($tableCode === '11.1') {
            return '18'; // Dinas Perdagangan
        }
        if ($tableCode === '11.2') {
            return '02'; // DPM-PTSP
        }
        return match ($tableCode) {
            '4.1.24' => '11', // Dinas Perpustakaan dan Kearsipan
            '4.1.20' => '10', // Dinas Pemuda dan Olahraga
            '4.3.4'  => '09', // Badan Penanggulangan Bencana Daerah
            '4.3.5', '4.3.6', '4.3.7', '4.3.8' => '15', // Dinas Pemadam Kebakaran dan Penyelamatan
            default  => $opdCode,
        };
    }

    /**
     * Normalisasi instansi/OPD dan tipe data tabel resmi SiBingka
     */
    public function normalizeAgency(string $tableCode, string $opdCode, string $type): array
    {
        $cleanCode = trim(rtrim($tableCode, '.'));
        $cleanOpd = str_pad($opdCode, 2, '0', STR_PAD_LEFT);

        // 1. Khusus tabel kampus Perguruan Tinggi 4.1.18 & 4.1.19 (SELALU INSTANSI VERTIKAL!)
        if (in_array($cleanCode, ['4.1.18', '4.1.19'])) {
            $type = 'instansi';
            $num = (int) $opdCode;
            if ($num < 5 || $num > 23) {
                $opdCode = '05'; // Default: Fakultas PGSD UNP Belakang Balok
            } else {
                $opdCode = $cleanOpd;
            }
            return [$opdCode, $type];
        }

        // 2. Khusus tabel instansi vertikal lainnya
        if (in_array($cleanCode, ['4.1.21', '4.1.22', '4.1.23'])) return ['24', 'instansi']; // UPT Perpustakaan Bung Hatta
        if (in_array($cleanCode, ['4.2.11', '4.2.12', '4.2.13'])) return ['25', 'instansi']; // PMI
        if ($cleanCode === '2.1.2') return ['27', 'instansi']; // Pengadilan Negeri
        if ($cleanCode === '2.1.3') return ['28', 'instansi']; // Kejaksaan Negeri
        if ($cleanCode === '2.1.4') return ['29', 'instansi']; // Pengadilan Agama
        if (in_array($cleanCode, ['2.1.1', '4.5.6', '8.1.10'])) return ['30', 'instansi']; // Polres
        if (in_array($cleanCode, ['8.1.11', '8.1.12'])) return ['34', 'instansi']; // Pos
        if (in_array($cleanCode, ['1.1.7', '1.1.8', '1.1.9'])) return ['01', 'instansi']; // BPN
        if ($cleanCode === '2.2.1') return ['02', 'instansi']; // KPU
        if (in_array($cleanCode, ['4.1.3', '4.1.4', '4.1.5', '4.2.14', '4.4.1', '4.4.2', '4.4.3', '4.4.4', '4.4.5', '4.4.6', '4.4.7', '4.4.8'])) {
            return ['03', 'instansi']; // Kemenag
        }

        // 3. Jika bukan instansi khusus dan bukan bps, arahkan ke OPD resmi
        if ($type !== 'bps' && $type !== 'instansi') {
            $opdCode = $this->normalizeOpdCode($cleanCode, $opdCode);
            $type = 'opd';
        }

        return [str_pad($opdCode, 2, '0', STR_PAD_LEFT), $type];
    }

    /**
     * Dapatkan nama instansi / OPD berdasarkan kode dan tipenya
     */
    public function getAgencyName(string $code, string $type): string
    {
        $code = str_pad($code, 2, '0', STR_PAD_LEFT);
        if ($type === 'bps') {
            $bpsNames = [
                '01' => 'PODES (Potensi Desa / Kelurahan)',
                '02' => 'PENDUDUK (Statistik Kependudukan & Proyeksi)',
                '03' => 'SUSENAS (Survei Sosial Ekonomi Nasional)',
                '04' => 'SAKERNAS (Survei Angkatan Kerja Nasional)',
                '05' => 'HORTI (Statistik Pertanian & Hortikultura)',
                '06' => 'IMK (Industri Mikro dan Kecil)',
                '07' => 'HOTEL (Statistik Perhotelan & Pariwisata)',
                '08' => 'IHK & INFLASI (Indeks Harga Konsumen)',
                '09' => 'PDRB LAPUS (PDRB Menurut Lapangan Usaha)',
                '10' => 'PDRB PENGELUARAN (PDRB Menurut Pengeluaran)',
            ];
            return $bpsNames[$code] ?? 'BADAN PUSAT STATISTIK KOTA BUKITTINGGI';
        }

        if ($type === 'instansi') {
            $instansiNames = [
                '01' => 'KANTOR PERTANAHAN KOTA BUKITTINGGI (BPN)',
                '02' => 'KOMISI PEMILIHAN UMUM DAERAH KOTA BUKITTINGGI',
                '03' => 'KEMENTERIAN AGAMA KOTA BUKITTINGGI',
                '04' => 'CABANG DINAS PENDIDIKAN WILAYAH I PROV. SUMBAR',
                '05' => 'PROGRAM STUDI PGSD UNIVERSITAS NEGERI PADANG',
                '06' => 'DEPARTEMEN PSIKOLOGI UNP KAMPUS BUKITTINGGI',
                '07' => 'FAKULTAS KEDOKTERAN UNP KAMPUS BUKITTINGGI',
                '08' => 'AKADEMI KEBIDANAN BUKITTINGGI (AKBID)',
                '09' => 'JURUSAN KEPERAWATAN GIGI POLTEKKES BUKITTINGGI',
                '10' => 'STKIP AL-HUSSUNAH BUKITTINGGI',
                '11' => 'STIT AL-HUSSUNAH BUKITTINGGI',
                '12' => 'STIKES PERINTIS BUKITTINGGI',
                '13' => 'STIKES PRIMA NUSANTARA BUKITTINGGI',
                '14' => 'UNIVERSITAS MOHAMMAD NATSIR YARSI BUKITTINGGI',
                '15' => 'INSTITUT TEKNOLOGI DAN BISNIS HAJI AGUS SALIM',
                '16' => 'FAKULTAS TEKNIK UNIVERSITAS MUHAMMADIYAH SUMBAR',
                '17' => 'FAKULTAS HUKUM UNIVERSITAS MUHAMMADIYAH SUMBAR',
                '18' => 'FAKULTAS PARIWISATA UNIVERSITAS MUHAMMADIYAH SUMBAR',
                '19' => 'FAKULTAS KESEHATAN UNIVERSITAS MUHAMMADIYAH SUMBAR',
                '20' => 'AKADEMI FARMASI IMAM BONJOL BUKITTINGGI',
                '21' => 'UNIVERSITAS FORT DE KOCK BUKITTINGGI',
                '22' => 'AKADEMI FARMASI DWI FARMA BUKITTINGGI',
                '23' => 'AKADEMI AKUNTANSI PARAMITA BUKITTINGGI',
                '24' => 'UPT PERPUSTAKAAN PROKLAMATOR BUNG HATTA',
                '25' => 'PALANG MERAH INDONESIA KOTA BUKITTINGGI',
                '26' => 'BPJS KESEHATAN & KETENAGAKERJAAN BUKITTINGGI',
                '27' => 'PENGADILAN NEGERI KOTA BUKITTINGGI',
                '28' => 'KEJAKSAAN NEGERI KOTA BUKITTINGGI',
                '29' => 'PENGADILAN AGAMA KOTA BUKITTINGGI',
                '30' => 'KEPOLISIAN RESOR KOTA BUKITTINGGI',
                '31' => 'PT PLN (PERSERO) ULP BUKITTINGGI',
                '32' => 'PERUMDA AIR MINUM TIRTA JAM GADANG',
                '33' => 'UPTD SAMSAT / PENDAPATAN DAERAH BUKITTINGGI',
                '34' => 'PT POS INDONESIA (PERSERO) KANTOR POS BUKITTINGGI',
                '35' => 'LPP RADIO REPUBLIK INDONESIA BUKITTINGGI',
                '36' => 'PT TASPEN (PERSERO) KANTOR CABANG BUKITTINGGI',
                '37' => 'PERUM BULOG KANTOR CABANG BUKITTINGGI',
            ];
            return $instansiNames[$code] ?? 'INSTANSI VERTIKAL PENYELENGGARA DATA';
        }

        $opdNames = [
            '01' => 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG',
            '02' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU',
            '03' => 'SEKRETARIAT DPRD KOTA BUKITTINGGI',
            '04' => 'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA',
            '05' => 'BADAN KEUANGAN DAERAH KOTA BUKITTINGGI',
            '06' => 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL',
            '07' => 'DINAS KOPERASI, UKM DAN TENAGA KERJA',
            '08' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
            '09' => 'BADAN PENANGGULANGAN BENCANA DAERAH',
            '10' => 'DINAS KEPEMUDAAN DAN OLAHRAGA',
            '11' => 'DINAS PERPUSTAKAAN DAN KEARSIPAN',
            '12' => 'DINAS LINGKUNGAN HIDUP',
            '13' => 'DINAS KESEHATAN KOTA BUKITTINGGI',
            '14' => 'DINAS P3APPKB KOTA BUKITTINGGI',
            '15' => 'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN',
            '16' => 'SATUAN POLISI PAMONG PRAJA',
            '17' => 'DINAS PERTANIAN DAN PANGAN',
            '18' => 'DINAS PERDAGANGAN DAN PERINDUSTRIAN',
            '19' => 'DINAS PARIWISATA',
            '20' => 'DINAS PERHUBUNGAN KOTA BUKITTINGGI',
            '21' => 'DINAS KOMUNIKASI DAN INFORMATIKA',
            '22' => 'DINAS SOSIAL KOTA BUKITTINGGI',
            '23' => 'BADAN PERENCANAAN, PENELITIAN DAN PENGEMBANGAN KOTA BUKITTINGGI',
            '24' => 'INSPEKTORAT DAERAH KOTA BUKITTINGGI',
            '25' => 'KECAMATAN GUGUK PANJANG',
            '26' => 'KECAMATAN MANDIANGIN KOTO SELAYAN',
            '27' => 'KECAMATAN AUR BIRUGO TIGO BALEH',
        ];
        return $opdNames[$code] ?? 'ORGANISASI PERANGKAT DAERAH (OPD)';
    }
}
