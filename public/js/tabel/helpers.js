/**
 * SiBingka Kota Bukittinggi - Shared Helpers & Agency Dictionaries
 * Digunakan bersama oleh index.blade.php dan edit.blade.php
 */

        const opdNames = {
            '01': 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG',
            '02': 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU',
            '03': 'DEWAN PERWAKILAN RAKYAT DAERAH KOTA BUKITTINGGI',
            '04': 'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SDM',
            '05': 'BADAN KEUANGAN DAERAH',
            '06': 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL',
            '07': 'DINAS KOPERASI, UKM DAN TENAGA KERJA',
            '08': 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
            '09': 'BADAN PENANGGULANGAN BENCANA DAERAH',
            '10': 'DINAS PEMUDA DAN OLAHRAGA',
            '11': 'DINAS PERPUSTAKAAN DAN KEARSIPAN',
            '12': 'DINAS KESEHATAN',
            '13': 'DINAS LINGKUNGAN HIDUP',
            '14': 'DINAS P3APPKB',
            '15': 'DINAS KEBAKARAN',
            '16': 'DINAS SOSIAL',
            '17': 'DINAS PERTANIAN',
            '18': 'DINAS PERDAGANGAN',
            '19': 'DINAS PARIWISATA',
            '20': 'DINAS PERHUBUNGAN'
        };

        const instansiNames = {
            '01': 'KANTOR PERTANAHAN KOTA BUKITTINGGI (BPN)',
            '02': 'KOMISI PEMILIHAN UMUM DAERAH KOTA BUKITTINGGI',
            '03': 'KEMENTERIAN AGAMA KOTA BUKITTINGGI',
            '04': 'CABANG DINAS PENDIDIKAN WILAYAH I PROV. SUMBAR',
            '05': 'PROGRAM STUDI PGSD UNIVERSITAS NEGERI PADANG',
            '06': 'DEPARTEMEN PSIKOLOGI UNP KAMPUS BUKITTINGGI',
            '07': 'FAKULTAS KEDOKTERAN UNP KAMPUS BUKITTINGGI',
            '08': 'AKADEMI KEBIDANAN BUKITTINGGI (AKBID)',
            '09': 'JURUSAN KEPERAWATAN GIGI POLTEKKES BUKITTINGGI',
            '10': 'STKIP AL-HUSSUNAH BUKITTINGGI',
            '11': 'STIT AL-HUSSUNAH BUKITTINGGI',
            '12': 'STIKES PERINTIS BUKITTINGGI',
            '13': 'STIKES PRIMA NUSANTARA BUKITTINGGI',
            '14': 'UNIVERSITAS MOHAMMAD NATSIR YARSI BUKITTINGGI',
            '15': 'INSTITUT TEKNOLOGI DAN BISNIS HAJI AGUS SALIM',
            '16': 'FAKULTAS TEKNIK UNIVERSITAS MUHAMMADIYAH SUMBAR',
            '17': 'FAKULTAS HUKUM UNIVERSITAS MUHAMMADIYAH SUMBAR',
            '18': 'FAKULTAS PARIWISATA UNIVERSITAS MUHAMMADIYAH SUMBAR',
            '19': 'FAKULTAS KESEHATAN UNIVERSITAS MUHAMMADIYAH SUMBAR',
            '20': 'AKADEMI FARMASI IMAM BONJOL BUKITTINGGI',
            '21': 'UNIVERSITAS FORT DE KOCK BUKITTINGGI',
            '22': 'AKADEMI FARMASI DWI FARMA BUKITTINGGI',
            '23': 'AKADEMI AKUNTANSI PARAMITA BUKITTINGGI',
            '24': 'UPT PERPUSTAKAAN PROKLAMATOR BUNG HATTA',
            '25': 'PALANG MERAH INDONESIA KOTA BUKITTINGGI',
            '26': 'BPJS KESEHATAN & KETENAGAKERJAAN BUKITTINGGI',
            '27': 'PENGADILAN NEGERI KOTA BUKITTINGGI',
            '28': 'KEJAKSAAN NEGERI KOTA BUKITTINGGI',
            '29': 'PENGADILAN AGAMA KOTA BUKITTINGGI',
            '30': 'KEPOLISIAN RESOR KOTA BUKITTINGGI',
            '31': 'PT PLN (PERSERO) ULP BUKITTINGGI',
            '32': 'PERUMDA AIR MINUM TIRTA JAM GADANG',
            '33': 'UPTD SAMSAT / PENDAPATAN DAERAH BUKITTINGGI',
            '34': 'PT POS INDONESIA (PERSERO) KANTOR POS BUKITTINGGI',
            '35': 'LPP RADIO REPUBLIK INDONESIA BUKITTINGGI',
            '36': 'PT TASPEN (PERSERO) KANTOR CABANG BUKITTINGGI',
            '37': 'PERUM BULOG KANTOR CABANG BUKITTINGGI'
        };

        const bpsNames = {
            '01': 'PODES (Potensi Desa / Kelurahan)',
            '02': 'PENDUDUK (Statistik Kependudukan & Proyeksi)',
            '03': 'SUSENAS (Survei Sosial Ekonomi Nasional)',
            '04': 'SAKERNAS (Survei Angkatan Kerja Nasional)',
            '05': 'HORTI (Statistik Pertanian & Hortikultura)',
            '06': 'IMK (Industri Mikro dan Kecil)',
            '07': 'HOTEL (Statistik Perhotelan & Pariwisata)',
            '08': 'IHK & INFLASI (Indeks Harga Konsumen)',
            '09': 'PDRB LAPUS (PDRB Menurut Lapangan Usaha)',
            '10': 'PDRB PENGELUARAN (PDRB Menurut Pengeluaran)'
        };

        function getAgencyName(code) {
            if (currentType === 'bps') {
                return bpsNames[code] || 'BADAN PUSAT STATISTIK KOTA BUKITTINGGI';
            }
            if (currentType === 'instansi') {
                return instansiNames[code] || 'KANTOR PERTANAHAN KOTA BUKITTINGGI (BPN)';
            }
            return opdNames[code] || 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG';
        }


        function cleanHtmlYearRanges(html) {
            if (!html || typeof html !== 'string') return html;
            return html.replace(/<div>\s*((?:19|20)\d{2})\s*<\/div>\s*<div class="italic[^>]*>\s*((?:19|20)\d{2})\s*<\/div>/gi, '<div>$1/$2</div>');
        }


        function getStorageKey(prefix, code = currentTableCode, yr = currentYear) {
            const t = (typeof currentType !== 'undefined' && currentType) ? currentType : 'opd';
            const opd = (typeof currentOpdCode !== 'undefined' && currentOpdCode) ? currentOpdCode.toString().padStart(2, '0') : '01';
            return `${prefix}_${t}_${opd}_${code}_${yr}`;
        }

        function getScopedLocalStorageItem(prefix, code = currentTableCode, yr = currentYear) {
            const scopedKey = getStorageKey(prefix, code, yr);
            const val = localStorage.getItem(scopedKey);
            if (val !== null) return val;
            if (typeof currentType !== 'undefined' && currentType === 'instansi') {
                return null;
            }
            return localStorage.getItem(`${prefix}_${code}_${yr}`);
        }

        function setScopedLocalStorageItem(prefix, val, code = currentTableCode, yr = currentYear) {
            const scopedKey = getStorageKey(prefix, code, yr);
            safeSetLocalStorage(scopedKey, val);
        }

        function removeScopedLocalStorageItem(prefix, code = currentTableCode, yr = currentYear) {
            const scopedKey = getStorageKey(prefix, code, yr);
            try { localStorage.removeItem(scopedKey); } catch(e) {}
            try { localStorage.removeItem(`${prefix}_${code}_${yr}`); } catch(e) {}
        }


        function cleanupLocalStorageQuota(force = false) {
            try {
                let totalChars = 0;
                const htmlKeys = [];
                const activeScopedKey = (typeof getStorageKey === 'function') 
                    ? getStorageKey('sibingka_table_html', currentTableCode, currentYear) 
                    : `sibingka_table_html_${currentTableCode}_${currentYear}`;

                for (let i = 0; i < localStorage.length; i++) {
                    const k = localStorage.key(i);
                    if (!k) continue;
                    const val = localStorage.getItem(k) || '';
                    totalChars += k.length + val.length;

                    // Bersihkan segera key legacy unscoped 4.1.18 & 4.1.19 yang memicu tabrakan data antar kampus 05-23
                    if (/^sibingka_table_(?:html|is_saved|source|title|note)_(?:4\.1\.18|4\.1\.19)_/.test(k)) {
                        try { localStorage.removeItem(k); } catch(e) {}
                        continue;
                    }

                    if (k.includes('sibingka_table_html')) {
                        htmlKeys.push(k);
                    }
                }

                // Hapus cache HTML tabel lama yang bukan tabel aktif saat kuota mendekati batas
                if (force || totalChars > 350000 || htmlKeys.length > 2) {
                    htmlKeys.forEach(k => {
                        if (k !== activeScopedKey) {
                            try { localStorage.removeItem(k); } catch(e) {}
                        }
                    });
                    console.log('[LocalStorage Cleaner] Kuota cache HTML tabel lama dibersihkan.');
                }
            } catch (e) {
                console.warn('[LocalStorage Cleaner] Error:', e);
            }
        }


        function safeSetLocalStorage(key, val) {
            try {
                localStorage.setItem(key, val);
            } catch (e) {
                if (e && (e.name === 'QuotaExceededError' || e.name === 'NS_ERROR_DOM_QUOTA_REACHED' || e.code === 22 || e.code === 1014 || (e.message && e.message.includes('quota')))) {
                    console.warn('[LocalStorage] Kuota penuh saat menyimpan ' + key + '. Membersihkan cache HTML lama...', e);
                    cleanupLocalStorageQuota(true);
                    try {
                        localStorage.setItem(key, val);
                    } catch (retryErr) {
                        console.warn('[LocalStorage] Tidak dapat menyimpan ke cache lokal setelah pembersihan; database server tetap aman.', retryErr);
                    }
                } else {
                    console.warn('[LocalStorage] Error saving ' + key, e);
                }
            }
        }


        function get5YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 4;
            const end = yr;
            return {
                start: start,
                end: end,
                yearsAsc: [yr - 4, yr - 3, yr - 2, yr - 1, yr],
                yearsDesc: [yr, yr - 1, yr - 2, yr - 3, yr - 4],
                label: `${start}–${end}`
            };
        }

        function get4YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 3;
            const end = yr;
            return {
                start: start,
                end: end,
                yearsAsc: [yr - 3, yr - 2, yr - 1, yr],
                yearsDesc: [yr, yr - 1, yr - 2, yr - 3],
                label: `${start}–${end}`
            };
        }

        function get6YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 5;
            const end = yr;
            const yearsAsc = [];
            const yearsDesc = [];
            for (let y = start; y <= end; y++) {
                yearsAsc.push(y);
            }
            for (let y = end; y >= start; y--) {
                yearsDesc.push(y);
            }
            return {
                start: start,
                end: end,
                yearsAsc: yearsAsc,
                yearsDesc: yearsDesc,
                label: `${start}–${end}`
            };
        }

        function get7YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 6;
            const end = yr;
            const yearsAsc = [];
            const yearsDesc = [];
            for (let y = start; y <= end; y++) {
                yearsAsc.push(y);
            }
            for (let y = end; y >= start; y--) {
                yearsDesc.push(y);
            }
            return {
                start: start,
                end: end,
                yearsAsc: yearsAsc,
                yearsDesc: yearsDesc,
                label: `${start}–${end}`
            };
        }

        function get2YearPeriod(year) {
            const yr = parseInt(year) || 2025;
            const start = yr - 1;
            const end = yr;
            return {
                start: start,
                end: end,
                yearsAsc: [start, end],
                yearsDesc: [end, start],
                label: `${start}–${end}`
            };
        }

        function getTablePeriod(year, tableCode) {
            if (tableCode === '5.2.1' || tableCode === '5.2.2') {
                return get2YearPeriod(year);
            }
            if (tableCode === '4.1.20' || tableCode === '2.4.1' || tableCode === '2.4.2') {
                return get4YearPeriod(year);
            }
            if (tableCode === '4.2.20' || tableCode === '4.3.15' || tableCode === '9.3' || tableCode === '8.1.6') {
                return get7YearPeriod(year);
            }
            return get5YearPeriod(year);
        }


        // Format angka ribuan dengan titik pemisah (tanpa Rp) untuk tabel keuangan
        function formatRupiahNumber(val) {
            if (val === null || val === undefined) return val;
            let str = val.toString().trim();
            if (!str || str === '-' || str === '–' || str === '—') return str;
            if (/[a-zA-Z]/.test(str)) return str;
            if (/^\(\s*\d+\s*\)$/.test(str)) return str;
            if (/^(19|20)\d{2}$/.test(str)) return str;
            if (/^\d{1,3}(\.\d{3})+(,\d+)?$/.test(str)) return str;

            if (/^\d{1,3}(,\d{3})+(\.\d+)?$/.test(str)) {
                const parts = str.split('.');
                const intPart = parts[0].replace(/,/g, '.');
                const decPart = parts.length > 1 ? ',' + parts[1] : '';
                return intPart + decPart;
            }

            let intPart = str;
            let decPart = '';

            if (str.includes(',')) {
                const parts = str.split(',');
                intPart = parts[0].replace(/\./g, '');
                decPart = ',' + parts[1];
            } else if (str.includes('.')) {
                const parts = str.split('.');
                if (parts.length === 2) {
                    if (parts[1].length !== 3 || parts[0].length > 3) {
                        intPart = parts[0];
                        decPart = ',' + parts[1];
                    } else {
                        return str;
                    }
                } else if (parts.length > 2) {
                    return str;
                }
            }

            const isNegative = intPart.startsWith('-');
            const cleanDigits = intPart.replace(/[^\d]/g, '');
            if (!cleanDigits) return str;

            const formattedInt = cleanDigits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return (isNegative ? '-' : '') + formattedInt + decPart;
        }

        // Format angka BPS: angka < 1.000 jangan pakai titik, angka >= 1.000 pakai titik ribuan, desimal selalu koma (bukan titik)
        function formatBpsNumber(val) {
            if (val === null || val === undefined) return val;
            let str = val.toString().trim();
            if (!str || str === '-' || str === '–' || str === '—') return str;
            if (/[a-zA-Z]/.test(str)) return str;
            if (/^\s*\(\s*\d+\s*\)\s*$/.test(str)) return str;
            if (/^(19|20)\d{2}$/.test(str)) return str;
            if (/^\d+\s*[-–\/]\s*\d+$/.test(str)) return str;

            // Sudah berformat desimal koma standar Indonesia: misal "333,02" atau "1.234,56" atau "207,00"
            if (str.includes(',')) {
                const parts = str.split(',');
                const intPart = parts[0].replace(/\./g, '');
                const decPart = parts.slice(1).join(',');
                const numInt = parseInt(intPart, 10);
                if (isNaN(numInt)) return str;
                let formattedInt = intPart;
                if (Math.abs(numInt) >= 1000) {
                    formattedInt = (intPart.startsWith('-') ? '-' : '') + Math.abs(numInt).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                } else {
                    formattedInt = intPart.startsWith('-') ? '-' + Math.abs(numInt).toString() : Math.abs(numInt).toString();
                }
                return formattedInt + ',' + decPart;
            }

            // Memuat titik: bisa berupa desimal (8.84) atau pemisah ribuan (50.210)
            if (str.includes('.')) {
                const dotCount = (str.match(/\./g) || []).length;
                if (dotCount > 1) {
                    // Lebih dari satu titik: sudah merupakan pemisah ribuan standar BPS, misal 1.500.000
                    return str;
                }
                const parts = str.split('.');
                const left = parts[0];
                const right = parts[1];

                // Desimal jika: digit belakang titik bukan 3 angka ATAU digit depan adalah 0 / -0
                // Contoh: 8.84 (2 digit), 87.4 (1 digit), 0.0034 (4 digit), 0.86 (2 digit)
                if (right.length !== 3 || left === '0' || left === '-0') {
                    const numLeft = parseInt(left.replace(/\./g, ''), 10);
                    if (isNaN(numLeft)) return str;
                    let formattedLeft = left;
                    if (Math.abs(numLeft) >= 1000) {
                        formattedLeft = (left.startsWith('-') ? '-' : '') + Math.abs(numLeft).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    } else {
                        formattedLeft = left.startsWith('-') ? '-' + Math.abs(numLeft).toString() : Math.abs(numLeft).toString();
                    }
                    return formattedLeft + ',' + right;
                }

                // 3 digit di belakang titik pada nilai ribuan BPS (misal 50.210 atau 1.596)
                return str;
            }

            // Bilangan bulat murni tanpa koma dan tanpa titik
            if (/^-?\d+$/.test(str)) {
                const num = parseInt(str, 10);
                if (isNaN(num)) return str;
                if (Math.abs(num) >= 1000) {
                    return (str.startsWith('-') ? '-' : '') + Math.abs(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
                // Nilai di bawah 1.000: TIDAK PAKAI TITIK (misal 417, 100, 54, 0)
                return str;
            }

            return str;
        }


function safeEscapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
