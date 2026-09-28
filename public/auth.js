/**
 * SiMonDa Bukittinggi - Authentication & Session Management
 * Badan Pusat Statistik Kota Bukittinggi
 */

(function () {
    const AUTH_KEY = 'simonda_auth';

    function getAuthData() {
        const stored = localStorage.getItem(AUTH_KEY) || sessionStorage.getItem(AUTH_KEY);
        if (!stored) return null;
        try {
            const data = JSON.parse(stored);
            if (data && data.isLoggedIn) {
                return data;
            }
        } catch (e) {
            console.error("Error reading auth data:", e);
        }
        return null;
    }

    function requireAuth() {
        const user = getAuthData();
        const path = window.location.pathname;

        if (!user && !path.includes('/login') && path !== '/login.html') {
            window.location.replace('/login');
            return null;
        }
        return user;
    }

    function logoutUser() {
        if (confirm('Apakah Anda yakin ingin keluar dari SiMonDa Bukittinggi?')) {
            localStorage.removeItem(AUTH_KEY);
            sessionStorage.removeItem(AUTH_KEY);
            window.location.href = '/login';
        }
    }

    function initUserHeader() {
        const user = getAuthData();
        if (!user) return;

        const userBar = document.getElementById('userProfileBar');
        if (userBar) {
            const roleBadgeClass = user.role === 'admin' 
                ? 'bg-orange-500/20 text-orange-400 border-orange-500/40' 
                : (user.role === 'opd' ? 'bg-blue-500/20 text-blue-400 border-blue-500/40' : 'bg-emerald-500/20 text-emerald-400 border-emerald-500/40');

            userBar.innerHTML = `
                <div class="flex items-center space-x-2 sm:space-x-3 text-xs">
                    <div class="flex items-center space-x-1.5 sm:space-x-2 text-slate-200">
                        <div class="w-5 h-5 rounded-full bg-[#f95a00] text-white flex items-center justify-center font-bold text-[10px] shadow-sm">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span class="font-bold text-slate-100 text-xs truncate max-w-[140px] sm:max-w-xs">${user.displayName || user.username}</span>
                        <span class="text-[10px] font-bold uppercase px-1.5 py-0.5 rounded border ${roleBadgeClass} hidden sm:inline-block">
                            ${user.roleLabel || 'User'}
                        </span>
                    </div>
                    <button onclick="SiMonDaAuth.logout()" 
                            title="Keluar dari sistem"
                            class="flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-red-600/90 hover:bg-red-600 text-white font-bold transition-all text-[11px] cursor-pointer shadow">
                        <i class="fa-solid fa-right-from-bracket text-[10px]"></i>
                        <span>Keluar</span>
                    </button>
                </div>
            `;
        }
    }

    window.SiMonDaAuth = {
        getAuth: getAuthData,
        requireAuth: requireAuth,
        logout: logoutUser,
        initUserHeader: initUserHeader
    };

    const path = window.location.pathname;
    if (!path.includes('/login') && path !== '/login.html') {
        const auth = requireAuth();
        if (auth) {
            document.addEventListener('DOMContentLoaded', initUserHeader);
        }
    }
})();
