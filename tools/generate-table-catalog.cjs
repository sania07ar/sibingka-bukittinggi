/**
 * Membuat config/sibingka_tables.php dari katalog JavaScript (public/sibingka-catalogs.js).
 * Dipakai server untuk menghitung persentase Monitoring (jumlah tabel per instansi).
 *
 * Jalankan setiap kali katalog tabel berubah:   node tools/generate-table-catalog.cjs
 */
const fs = require('fs');
const path = require('path');
const vm = require('vm');

const root = path.resolve(__dirname, '..');
const src = fs.readFileSync(path.join(root, 'public/sibingka-catalogs.js'), 'utf8');
const catalogs = vm.runInNewContext(
    src + '\n({ opd: opdTablesCatalog, instansi: instansiTablesCatalog, bps: bpsTablesCatalog })',
    { console }
);

function toPhp(map) {
    const lines = [];
    Object.keys(map).sort().forEach((code) => {
        const tables = (map[code] || []).map((t) => (typeof t === 'string' ? t : t.code)).filter(Boolean);
        const uniq = Array.from(new Set(tables));
        lines.push(`        '${code}' => [${uniq.map((c) => `'${c}'`).join(', ')}],`);
    });
    return lines.join('\n');
}

const out = `<?php

/**
 * DIBUAT OTOMATIS oleh tools/generate-table-catalog.cjs dari public/sibingka-catalogs.js
 * Jangan diubah manual. Berisi kode tabel resmi per OPD / Instansi / dataset BPS.
 * Dipakai App\\Support\\MonitoringProgress untuk menghitung persentase Monitoring.
 */
return [
    'opd' => [
${toPhp(catalogs.opd)}
    ],
    'instansi' => [
${toPhp(catalogs.instansi)}
    ],
    'bps' => [
${toPhp(catalogs.bps)}
    ],
];
`;
fs.writeFileSync(path.join(root, 'config/sibingka_tables.php'), out);
const count = (m) => Object.values(m).reduce((s, a) => s + (a || []).length, 0);
console.log('opd     :', Object.keys(catalogs.opd).length, 'instansi,', count(catalogs.opd), 'tabel');
console.log('instansi:', Object.keys(catalogs.instansi).length, 'instansi,', count(catalogs.instansi), 'tabel');
console.log('bps     :', Object.keys(catalogs.bps).length, 'dataset,', count(catalogs.bps), 'tabel');
