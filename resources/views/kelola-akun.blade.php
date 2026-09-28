<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Administrator - SiMonDa Bukittinggi | BPS Kota Bukittinggi</title>
    
    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/bps-symbol.png') }}">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..900;1,14..32,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f4f9;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Ambient Glow Spheres */
        .ambient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            opacity: 0.3;
            transition: all 0.5s ease;
        }

        /* SiMonDa Standard Orange Button */
        .btn-simonda {
            background: linear-gradient(135deg, #f95a00 0%, #eb5200 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.65rem 1.25rem;
            box-shadow: 0 4px 14px rgba(249, 90, 0, 0.25);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .btn-simonda:hover {
            background: linear-gradient(135deg, #ea5200 0%, #db4500 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(249, 90, 0, 0.35);
        }

        .input-custom {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-custom:focus {
            background-color: #ffffff;
            border-color: #f95a00;
            outline: none;
            box-shadow: 0 0 0 3px rgba(249, 90, 0, 0.14);
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased flex flex-col relative selection:bg-orange-500 selection:text-white bg-[#f1f4f9] overflow-x-hidden">

    <!-- Ambient Lighting Atmosphere -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="ambient-sphere w-96 h-96 bg-orange-200/40 -top-16 -right-16"></div>
        <div class="ambient-sphere w-96 h-96 bg-indigo-100/50 -bottom-16 -left-16"></div>
    </div>

    <!-- Background Sensus Ribbon Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-15 select-none">
        <img src="{{ asset('images/sensus-ribbon-watermark.png') }}" alt="Sensus Ekonomi Watermark" class="w-[900px] lg:w-[1200px] max-w-none transform -translate-x-16 object-contain">
    </div>

    <!-- HEADER / LOGO BAR -->
    <header class="w-full bg-[#f0f2f5]/90 backdrop-blur-md border-b border-slate-200/70 py-2.5 sm:py-3 px-4 sm:px-8 lg:px-12 relative z-20 shrink-0">
        <div class="max-w-6xl mx-auto flex flex-row items-center justify-between gap-4 flex-wrap sm:flex-nowrap">
            
            <!-- Left: BPS Kota Bukittinggi Logo -->
            <a href="{{ route('portal') }}" class="flex items-center space-x-2.5 transition-transform hover:scale-[1.02]">
                <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="h-8 sm:h-9 md:h-10 w-auto object-contain">
                <div class="flex flex-col justify-center leading-tight">
                    <span class="text-[11px] sm:text-xs md:text-sm font-black italic text-slate-900 tracking-tight uppercase font-sans">
                        BADAN PUSAT STATISTIK
                    </span>
                    <span class="text-[10px] sm:text-[11px] md:text-xs font-black italic text-slate-800 tracking-tight uppercase font-sans">
                        KOTA BUKITTINGGI
                    </span>
                </div>
            </a>

            <!-- Center: Breadcrumbs & Quick Nav -->
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-600">
                <a href="{{ route('portal') }}" class="hover:text-[#f95a00] flex items-center space-x-1 transition-colors">
                    <i class="fa-solid fa-house text-slate-400"></i>
                    <span>Pilihan Portal</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-900">Kelola Akun Admin</span>
            </div>

            <!-- Right: Direct to SiMonDa & Logout -->
            <div class="flex items-center space-x-2.5">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-white bg-[#f95a00] hover:bg-[#e04e00] shadow-sm transition-all">
                    <span>Masuk ke SiMonDa</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>

                <a href="{{ route('logout') }}" 
                   class="inline-flex items-center space-x-1.5 px-2.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-red-600 hover:bg-red-50 border border-slate-200 transition-all"
                   title="Keluar dari akun">
                    <i class="fa-solid fa-power-off text-xs"></i>
                </a>
            </div>

        </div>
    </header>

    <!-- MAIN BODY -->
    <main class="relative z-10 flex-1 max-w-5xl mx-auto w-full px-4 sm:px-8 py-6 sm:py-8">
        
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-xl text-xs font-semibold flex items-center space-x-2.5 bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-sm animate-fade-in">
                <i class="fa-solid fa-circle-check text-base text-emerald-500 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-3.5 rounded-xl text-xs font-semibold flex items-center space-x-2.5 bg-red-50 text-red-800 border border-red-200 shadow-sm animate-fade-in">
                <i class="fa-solid fa-circle-xmark text-base text-red-500 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 p-3.5 rounded-xl text-xs font-medium bg-red-50 text-red-800 border border-red-200 shadow-sm space-y-1">
                <div class="flex items-center space-x-1.5 font-bold text-red-700">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 shrink-0"></i>
                    <span>Terdapat kesalahan pengisian:</span>
                </div>
                <ul class="list-disc list-inside pl-1 text-[11px] text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Grid 2 Columns: Summary Card + Management Forms -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- LEFT COLUMN: Profile Card & Quick Actions (4 Cols) -->
            <div class="lg:col-span-4 space-y-4">
                
                <!-- Account Summary Card -->
                <div class="bg-white/95 backdrop-blur-md rounded-2xl p-5 border border-slate-200/90 shadow-md shadow-slate-900/5 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-400 to-[#f95a00]"></div>
                    
                    <!-- Avatar -->
                    <div class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-tr from-orange-500 to-amber-400 text-white flex items-center justify-center text-3xl font-black shadow-lg shadow-orange-500/20 mb-3 border-2 border-white">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>

                    <!-- User Info -->
                    <h2 class="text-base font-black text-slate-900 leading-tight">
                        {{ session('user.displayName', 'Admin BPS Bukittinggi') }}
                    </h2>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">
                        @ {{ session('user.username', 'admin_bps') }}
                    </p>

                    <div class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10.5px] font-bold mt-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Akun Administrator Aktif</span>
                    </div>

                    <!-- Detailed Meta Table -->
                    <div class="mt-4 pt-3.5 border-t border-slate-100 text-left space-y-2 text-xs">
                        <div class="flex justify-between items-center text-slate-600">
                            <span class="text-slate-400">Hak Akses:</span>
                            <span class="font-bold text-slate-800">Super Administrator</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-600">
                            <span class="text-slate-400">Email:</span>
                            <span class="font-bold text-slate-800">{{ session('user.email', 'bps1375@bps.go.id') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-600">
                            <span class="text-slate-400">Sesi Masuk:</span>
                            <span class="font-semibold text-slate-700 text-[11px]">{{ session('user.loginTime', now()->translatedFormat('d M Y, H:i')) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Quick Card -->
                <div class="bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-slate-200/90 shadow-xs space-y-2">
                    <span class="text-[10.5px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                        Pintas Navigasi
                    </span>
                    <a href="{{ route('home') }}" class="w-full py-2 px-3 rounded-xl bg-orange-50 hover:bg-orange-100 text-[#f95a00] font-bold text-xs flex items-center justify-between transition-colors">
                        <span class="flex items-center space-x-2">
                            <i class="fa-solid fa-chart-pie"></i>
                            <span>Buka Portal SiMonDa</span>
                        </span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                    <a href="{{ route('portal') }}" class="w-full py-2 px-3 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-between transition-colors">
                        <span class="flex items-center space-x-2">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Kembali ke Pilihan Menu</span>
                        </span>
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    </a>
                </div>

            </div>

            <!-- RIGHT COLUMN: Forms (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- SECTION 1: PERBARUI INFORMASI PROFIL -->
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
                                       class="w-full px-3 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed"
                                       title="Username dikonfigurasi melalui sistem">
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
                            <button type="submit" class="btn-simonda text-xs">
                                <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                                <span>Simpan Profil</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- SECTION 2: GANTI KATA SANDI -->
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
                                       required
                                       placeholder="Ketik ulang kata sandi baru"
                                       class="input-custom w-full px-3 py-2 rounded-xl text-xs font-semibold">
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <span class="text-[11px] text-slate-500">
                                <i class="fa-solid fa-circle-info text-orange-500 mr-1"></i>
                                Perubahan kata sandi langsung aktif untuk sesi login berikutnya.
                            </span>
                            <button type="submit" class="btn-simonda text-xs">
                                <i class="fa-solid fa-lock mr-1.5"></i>
                                <span>Perbarui Kata Sandi</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 w-full py-3.5 px-4 text-center text-[11px] text-slate-500 border-t border-slate-200/70 bg-white/80 backdrop-blur-xs mt-auto shrink-0">
        <p>© <span id="currentYear"></span> <strong>Badan Pusat Statistik Kota Bukittinggi</strong>. SiMonDa Bukittinggi dalam Angka.</p>
    </footer>

    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>
</body>
</html>
