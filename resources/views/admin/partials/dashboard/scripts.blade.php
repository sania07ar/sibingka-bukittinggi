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
            if (tabName !== 'kelola-akun') {
                if (e) e.preventDefault();
            }

            const tabs = document.querySelectorAll('.nav-tab');
            tabs.forEach(tab => {
                if (tab.getAttribute('data-nav') === tabName) {
                    tab.classList.remove('text-slate-600', 'text-slate-700', 'border-transparent');
                    tab.classList.add('text-[#f95a00]', 'border-[#f95a00]');
                } else {
                    tab.classList.remove('text-[#f95a00]', 'border-[#f95a00]');
                    tab.classList.add('text-slate-700', 'border-transparent');
                }
            });

            if (tabName === 'beranda') {
                const el = document.getElementById('beranda-section');
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (tabName === 'tentang') {
                openAboutModal();
            }
        }
    </script>
