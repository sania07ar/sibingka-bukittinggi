<!-- JAVASCRIPT LOGIC UNTUK KELOLA AKUN -->
<script>
    if (document.getElementById('currentYear')) {
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    }

    // Data 20 OPD & 37 Instansi Vertikal dari PHP Config
    const opdListData = @json($opdList);
    const instansiListData = @json($instansiList);

    // Tab Switching Logic (Dinas vs Admin Profile)
    function switchTab(tabId) {
        const contentDinas = document.getElementById('tab-content-dinas');
        const contentAdmin = document.getElementById('tab-content-admin');
        const btnDinas = document.getElementById('tab-btn-dinas');
        const btnAdmin = document.getElementById('tab-btn-admin');

        if (tabId === 'tab-dinas') {
            contentDinas.classList.remove('hidden');
            contentAdmin.classList.add('hidden');
            btnDinas.classList.add('active', 'font-black');
            btnDinas.classList.remove('font-bold', 'text-slate-600');
            btnAdmin.classList.remove('active', 'font-black');
            btnAdmin.classList.add('font-bold', 'text-slate-600');
        } else {
            contentAdmin.classList.remove('hidden');
            contentDinas.classList.add('hidden');
            btnAdmin.classList.add('active', 'font-black');
            btnAdmin.classList.remove('font-bold', 'text-slate-600');
            btnDinas.classList.remove('active', 'font-black');
            btnDinas.classList.add('font-bold', 'text-slate-600');
        }
    }

    // Handle dinas dropdown change in Create and Edit modals
    function handleDinasSelection(selectedName, mode) {
        if (!selectedName) return;
        const select = document.getElementById(`${mode}_dinas_name`);
        const opt = select.options[select.selectedIndex];
        if (!opt) return;

        const code = opt.getAttribute('data-code') || '';
        const role = opt.getAttribute('data-role') || 'opd';
        const defUsername = opt.getAttribute('data-username') || '';

        // Set hidden inputs
        const opdCodeInput = document.getElementById(`${mode}_opd_code`);
        if (opdCodeInput) opdCodeInput.value = code;

        const nameInput = document.getElementById(`${mode}_name`);
        if (nameInput) nameInput.value = selectedName;

        // Sync role radio
        if (mode === 'create') {
            const roleRadio = document.querySelector(`input[name="role"][value="${role}"]`);
            if (roleRadio) roleRadio.checked = true;

            const usernameInput = document.getElementById('create_username');
            if (usernameInput) {
                usernameInput.value = defUsername;
            }

            if (role === 'walidata') {
                setPageCheckboxes('create', ['monitoring-opd', 'monitoring-instansi', 'tabel-opd', 'isi-data-opd', 'isi-data-instansi']);
            } else if (role === 'instansi') {
                setPageCheckboxes('create', ['isi-data-instansi', 'monitoring-instansi']);
            } else {
                setPageCheckboxes('create', ['isi-data-opd', 'monitoring-opd', 'tabel-opd']);
            }
        } else if (mode === 'edit') {
            const opdRadio = document.getElementById('edit_role_opd');
            const instansiRadio = document.getElementById('edit_role_instansi');
            const waliRadio = document.getElementById('edit_role_walidata');
            if (role === 'walidata' && waliRadio) {
                waliRadio.checked = true;
            } else if (role === 'instansi' && instansiRadio) {
                instansiRadio.checked = true;
            } else if (opdRadio) {
                opdRadio.checked = true;
            }
        }
    }

    // Toggle category filter helper
    function toggleCategoryFilter(mode, type) {
        const opdGroup = document.getElementById(`${mode}_opd_group`);
        const instGroup = document.getElementById(`${mode}_instansi_group`);
        const waliGroup = document.getElementById(`${mode}_walidata_group`);
        if (opdGroup && instGroup) {
            if (type === 'opd') {
                opdGroup.style.display = '';
                instGroup.style.display = 'none';
                if (waliGroup) waliGroup.style.display = 'none';
            } else if (type === 'instansi') {
                opdGroup.style.display = 'none';
                instGroup.style.display = '';
                if (waliGroup) waliGroup.style.display = 'none';
            } else if (type === 'walidata') {
                opdGroup.style.display = 'none';
                instGroup.style.display = 'none';
                if (waliGroup) waliGroup.style.display = '';
            }
        }
    }

    // Checkbox Helper: Select All / Deselect All
    function selectAllPages(prefix, isChecked) {
        const checkboxes = document.querySelectorAll(`.${prefix}-page-cb`);
        checkboxes.forEach(cb => cb.checked = isChecked);
    }

    // Checkbox Helper: Set specific pages
    function setPageCheckboxes(prefix, targetPages) {
        const checkboxes = document.querySelectorAll(`.${prefix}-page-cb`);
        checkboxes.forEach(cb => {
            cb.checked = targetPages.includes(cb.value);
        });
    }

    // Modal Open / Close
    function openCreateModal() {
        toggleCategoryFilter('create', 'opd');
        document.getElementById('createModal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    let currentEditingUser = null;

    function openEditModal(userData) {
        currentEditingUser = userData;
        document.getElementById('editModalTitle').innerText = 'Edit Akun: ' + (userData.dinas_name || userData.name);
        document.getElementById('formEditDinas').action = `/kelola-akun/dinas/${userData.id}/update`;

        const isWali = (userData.role === 'walidata');
        const isInst = (userData.role === 'instansi');
        const opdRadio = document.getElementById('edit_role_opd');
        const instansiRadio = document.getElementById('edit_role_instansi');
        const waliRadio = document.getElementById('edit_role_walidata');
        if (opdRadio) opdRadio.checked = (!isInst && !isWali);
        if (instansiRadio) instansiRadio.checked = isInst;
        if (waliRadio) waliRadio.checked = isWali;
        toggleCategoryFilter('edit', isWali ? 'walidata' : (isInst ? 'instansi' : 'opd'));

        const opdCodeInput = document.getElementById('edit_opd_code');
        if (opdCodeInput) opdCodeInput.value = userData.opd_code || '';

        const nameInput = document.getElementById('edit_name');
        if (nameInput) nameInput.value = userData.name || userData.dinas_name || '';

        const usernameInput = document.getElementById('edit_username');
        if (usernameInput) usernameInput.value = userData.username || '';

        const phoneInput = document.getElementById('edit_phone');
        if (phoneInput) phoneInput.value = userData.phone || '';

        const passwordInput = document.getElementById('edit_password');
        if (passwordInput) passwordInput.value = '';

        const activeInput = document.getElementById('edit_is_active');
        if (activeInput) activeInput.checked = !!userData.is_active;

        // Set dinas dropdown value
        const select = document.getElementById('edit_dinas_name');
        if (select) {
            let matched = false;
            for (let i = 0; i < select.options.length; i++) {
                const opt = select.options[i];
                if (opt.value === userData.dinas_name || 
                    (userData.opd_code && opt.getAttribute('data-code') === userData.opd_code)) {
                    select.selectedIndex = i;
                    matched = true;
                    break;
                }
            }
            if (!matched && userData.dinas_name) {
                const customOpt = document.createElement('option');
                customOpt.value = userData.dinas_name;
                customOpt.text = userData.dinas_name;
                customOpt.setAttribute('data-code', userData.opd_code || '');
                customOpt.selected = true;
                select.appendChild(customOpt);
            }
        }

        // Allowed pages checkboxes
        let pages = [];
        if (Array.isArray(userData.allowed_pages)) {
            pages = userData.allowed_pages;
        } else if (typeof userData.allowed_pages === 'string') {
            try {
                pages = JSON.parse(userData.allowed_pages);
            } catch(e) {
                pages = [];
            }
        }

        setPageCheckboxes('edit', pages);
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        currentEditingUser = null;
    }

    // Single Account Delete Modal
    function openDeleteModal(id, dinasName, username, role) {
        document.getElementById('formDeleteDinas').action = `/kelola-akun/dinas/${id}/delete`;
        document.getElementById('deleteModalDinasName').innerText = dinasName;
        document.getElementById('deleteModalUsername').innerText = '@' + username;
        
        const badge = document.getElementById('deleteModalRoleBadge');
        if (role === 'instansi') {
            badge.innerText = 'INSTANSI VERTIKAL';
            badge.className = 'text-[9.5px] font-black px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800';
        } else {
            badge.innerText = 'OPD KOTA';
            badge.className = 'text-[9.5px] font-black px-2 py-0.5 rounded-full bg-orange-100 text-orange-800';
        }

        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function triggerDeleteFromEditModal() {
        if (!currentEditingUser) return;
        const u = currentEditingUser;
        closeEditModal();
        openDeleteModal(u.id, u.dinas_name || u.name, u.username, u.role);
    }

    // Bulk Delete / Reset Modal
    function openBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').classList.remove('hidden');
    }

    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').classList.add('hidden');
    }

    // Close on ESC
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
            closeDeleteModal();
            closeBulkDeleteModal();
        }
    });
</script>
