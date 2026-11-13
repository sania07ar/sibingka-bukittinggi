<!-- TAB CONTENT 2: PENGATURAN PROFIL & PASSWORD ADMIN BPS -->
<div id="tab-content-admin" class="hidden">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- LEFT COLUMN: Profile Summary Card (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-white/95 backdrop-blur-md rounded-2xl p-6 border border-slate-200/90 shadow-md shadow-slate-900/5 text-center">
                <!-- Avatar with Badge -->
                <div class="relative w-24 h-24 mx-auto mb-4">
                    <div class="w-full h-full rounded-2xl overflow-hidden ring-4 ring-orange-500/20 shadow-md">
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar Admin BPS" class="w-full h-full object-cover">
                    </div>
                    <span class="absolute -bottom-1 -right-1 w-7 h-7 bg-emerald-500 text-white rounded-lg flex items-center justify-center text-xs shadow-md border-2 border-white" title="Akun Aktif & Terverifikasi">
                        <i class="fa-solid fa-shield-check"></i>
                    </span>
                </div>

                <h3 class="font-black text-base sm:text-lg text-slate-900 leading-tight">
                    {{ session('user.displayName', 'Admin BPS Bukittinggi') }}
                </h3>
                <p class="text-xs font-bold text-[#f95a00] mt-0.5">
                    Administrator Utama SiBingka
                </p>
                <p class="text-[11px] text-slate-500 mt-1">
                    BPS Kota Bukittinggi • IPDS
                </p>

                <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-left text-xs">
                    <div class="flex items-center justify-between text-slate-600">
                        <span class="font-semibold text-slate-400">Username:</span>
                        <span class="font-bold text-slate-800 font-mono">{{ session('user.username', 'admin_bps') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span class="font-semibold text-slate-400">Hak Akses:</span>
                        <span class="font-black text-emerald-600 uppercase text-[10px] bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                            Super Admin
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span class="font-semibold text-slate-400">Status Sesi:</span>
                        <span class="font-bold text-slate-800 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                            Login Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info Box Hak Akses Admin -->
            <div class="bg-orange-50/70 border border-orange-200/80 rounded-2xl p-4 text-xs space-y-2">
                <div class="flex items-center space-x-2 text-[#f95a00] font-black">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Hak Istimewa Administrator</span>
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Sebagai admin BPS, Anda memiliki hak penuh untuk mengakses semua modul data (OPD, Instansi, BPS, dan Monitoring) serta mengelola seluruh akun dinas dan instansi di Kota Bukittinggi.
                </p>
            </div>

        </div>

        <!-- RIGHT COLUMN: Profile & Password Forms (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- FORM 1: PROFIL -->
            <div class="bg-white/95 backdrop-blur-md rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-md shadow-slate-900/5">
                <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-100">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-lg bg-orange-100 text-[#f95a00] flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm sm:text-base text-slate-900">Informasi Profil Administrator</h3>
                            <p class="text-[11px] text-slate-500">Perbarui identitas profil dan alamat kontak email resmi BPS</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('kelola-akun.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="action_type" value="profile">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Nama Lengkap / Tampilan
                            </label>
                            <input type="text" 
                                   name="displayName" 
                                   value="{{ old('displayName', session('user.displayName', 'Admin BPS Bukittinggi')) }}" 
                                   required
                                   class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Username Login
                            </label>
                            <input type="text" 
                                   value="{{ session('user.username', 'admin_bps') }}" 
                                   disabled
                                   class="w-full px-3 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Email Resmi BPS
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', session('user.email', 'bps1375@bps.go.id')) }}" 
                                   required
                                   class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                NIP Petugas (Opsional)
                            </label>
                            <input type="text" 
                                   name="nip" 
                                   value="{{ old('nip', session('user.nip', '198501012010011005')) }}" 
                                   placeholder="18 Digit NIP"
                                   class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="btn-sibingka text-xs">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                            <span>Simpan Profil</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- FORM 2: PASSWORD -->
            <div class="bg-white/95 backdrop-blur-md rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-md shadow-slate-900/5">
                <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-100">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm sm:text-base text-slate-900">Ubah Kata Sandi (Password)</h3>
                            <p class="text-[11px] text-slate-500">Pastikan gunakan kata sandi yang aman dan mudah diingat oleh tim admin</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('kelola-akun.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="action_type" value="password">

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Kata Sandi Saat Ini
                        </label>
                        <input type="password" 
                               name="current_password" 
                               autocomplete="current-password"
                               required
                               placeholder="Masukkan kata sandi lama Anda"
                               class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Kata Sandi Baru
                            </label>
                            <input type="password" 
                                   name="new_password" 
                                   autocomplete="new-password"
                                   required
                                   placeholder="Minimal 6 karakter"
                                   class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Ulangi Kata Sandi Baru
                            </label>
                            <input type="password" 
                                   name="new_password_confirmation" 
                                   autocomplete="new-password"
                                   required
                                   placeholder="Ketik ulang kata sandi baru"
                                   class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <span class="text-[11px] text-slate-500">
                            <i class="fa-solid fa-circle-info text-orange-500 mr-1"></i>
                            Perubahan langsung aktif untuk login berikutnya.
                        </span>
                        <button type="submit" class="btn-sibingka text-xs">
                            <i class="fa-solid fa-lock mr-1.5"></i>
                            <span>Perbarui Kata Sandi</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>
