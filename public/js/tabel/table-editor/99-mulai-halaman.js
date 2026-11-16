/** SiBingka | table-editor | mulai halaman editor
 *  Dijalankan paling akhir supaya semua fungsi di file lain sudah termuat. */

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEditorPage);
} else {
    initEditorPage();
}
