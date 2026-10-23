<!-- FOOTER COPYRIGHT -->
<footer class="relative z-10 w-full py-3.5 px-4 text-center text-[11px] text-slate-500 border-t border-slate-200/70 bg-white/80 backdrop-blur-xs mt-auto shrink-0">
    <p>© <span id="currentYear"></span> <strong>Badan Pusat Statistik Kota Bukittinggi</strong>. SiAngka Kota Bukittinggi - Sistem Informasi Data Daerah dalam Angka.</p>
</footer>
<script>
    if (document.getElementById('currentYear')) {
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    }
</script>
