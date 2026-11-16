    <!-- Script to handle modals & tab selection -->
    <script>
        function openAboutModal(e) {
            if (e) e.preventDefault();
            const modal = document.getElementById('aboutModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeAboutModal() {
            const modal = document.getElementById('aboutModal');
            if (modal) modal.classList.add('hidden');
        }

        function selectNavTab(tabName, e) {
            if (e) e.preventDefault();
            if (tabName === 'beranda') {
                const el = document.getElementById('beranda-section');
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (tabName === 'tentang') {
                openAboutModal();
            }
        }
    </script>
