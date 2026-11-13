<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login BPS - SiBingka Kota Bukittinggi | BPS Kota Bukittinggi</title>
    <meta name="description" content="Portal Masuk Khusus Administrator SiBingka Kota Bukittinggi - Sistem Informasi Bukittinggi dalam Angka - Badan Pusat Statistik Kota Bukittinggi">
    
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
        html, body {
            height: 100%;
            height: 100dvh;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f4f9;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        @media (max-height: 560px), (max-width: 640px) {
            html, body {
                height: auto;
                min-height: 100%;
                overflow-y: auto;
            }
        }

        /* Ambient Glow Spheres */
        .ambient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            opacity: 0.4;
            transition: all 0.5s ease;
        }

        /* Standard SiBingka Orange Button */
        .btn-sibingka {
            background: linear-gradient(135deg, #f95a00 0%, #eb5200 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.65rem 1.25rem;
            line-height: 1.25;
            box-shadow: 0 4px 14px rgba(249, 90, 0, 0.25), 0 1px 2px rgba(0, 0, 0, 0.06);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            width: 100%;
        }

        .btn-sibingka:hover {
            background: linear-gradient(135deg, #ea5200 0%, #db4500 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(249, 90, 0, 0.35);
        }

        .btn-sibingka:active {
            transform: translateY(0.5px) scale(0.99);
            box-shadow: 0 2px 6px rgba(249, 90, 0, 0.2);
        }

        /* Shimmer effect on button */
        .btn-sibingka::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 45%;
            height: 200%;
            background: linear-gradient(
                60deg,
                rgba(255, 255, 255, 0) 20%,
                rgba(255, 255, 255, 0.35) 50%,
                rgba(255, 255, 255, 0.85) 80%
            );
            transform: rotate(25deg);
            transition: all 0.65s ease;
        }

        .btn-sibingka:hover::after {
            left: 130%;
        }

        /* Custom Input Styling (SiBingka Theme) */
        .input-sibingka {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-sibingka:focus {
            background-color: #ffffff;
            border-color: #f95a00;
            outline: none;
            box-shadow: 0 0 0 3px rgba(249, 90, 0, 0.14);
        }
    </style>
</head>
<body class="h-screen w-full bg-[#f1f4f9] text-slate-800 flex flex-col justify-between relative selection:bg-orange-500 selection:text-white overflow-hidden">

    <!-- Ambient Lighting Atmosphere (Contained so it doesn't cause overflow/scrollbar) -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="ambient-sphere w-80 h-80 bg-orange-200/40 -top-16 -right-10"></div>
        <div class="ambient-sphere w-72 h-72 bg-blue-100/50 -bottom-10 -left-10"></div>
    </div>

    <!-- Background SiBingka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center opacity-25 select-none">
        <img src="{{ asset('images/sibingka-watermark-jamgadang.jpg') }}" alt="Watermark SiBingka Jam Gadang" class="w-[850px] lg:w-[1050px] max-w-none transform -translate-x-12 sm:-translate-x-20 object-contain mix-blend-multiply">
    </div>

    <!-- HEADER / LOGO BAR -->
    @include('partials.navbar')

    <!-- MAIN LOGIN CONTAINER (Compact 2-Column Layout) -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-8 py-2 min-h-0">
        <div class="max-w-3xl w-full grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 items-center">
            
            <!-- LEFT COLUMN: BRAND LOGO & TITLE (Compact) -->
            <div class="flex flex-col items-center text-center justify-center space-y-2 md:pr-4">
                
                <!-- BPS Logo -->
                <div class="transition-transform duration-300 hover:scale-105">
                    <img src="{{ asset('images/bps-symbol.png') }}" alt="Logo BPS" class="w-20 sm:w-24 h-auto object-contain drop-shadow-xs">
                </div>

                <!-- Brand Name: SiBingka Digital Application Style -->
                <div class="space-y-1.5 flex flex-col items-center">
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight leading-none text-slate-800">
                        SiBingka
                    </h1>
                    <p class="text-xs font-bold text-[#f95a00] uppercase tracking-wider">
                        Kota Bukittinggi
                    </p>
                    <p class="text-xs text-slate-700 font-medium leading-relaxed max-w-[240px]">
                        Sistem Informasi Bukittinggi dalam Angka
                    </p>
                </div>

            </div>

            <!-- RIGHT COLUMN: LOGIN FORM (Compact Card with Soft Ambient Shadow) -->
            <div class="w-full max-w-[350px] mx-auto">
                <div class="bg-white/95 backdrop-blur-md rounded-2xl p-5 sm:p-6 shadow-[0_12px_36px_rgba(15,23,42,0.06)] border border-slate-200/60 relative overflow-hidden transition-all">
                    
                    <!-- Title Header -->
                    <h2 class="text-base sm:text-lg font-bold text-slate-800 tracking-wide uppercase text-center mb-4 pt-0.5">
                        MASUK KE AKUN ANDA
                    </h2>

                    <!-- Flash messages from Laravel Session -->
                    @if(session('error'))
                        <div class="mb-2.5 p-2 rounded-lg text-[11px] font-semibold flex items-center space-x-2 bg-red-50 text-red-700 border border-red-200 shadow-xs">
                            <i class="fa-solid fa-circle-xmark text-xs text-red-500 shrink-0"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-2.5 p-2 rounded-lg text-[11px] font-semibold flex items-center space-x-2 bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-xs">
                            <i class="fa-solid fa-circle-check text-xs text-emerald-500 shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-2.5 p-2 rounded-lg text-[11px] font-medium bg-red-50 text-red-700 border border-red-200 shadow-xs space-y-0.5">
                            <div class="flex items-center space-x-1 font-bold">
                                <i class="fa-solid fa-triangle-exclamation text-xs text-red-500 shrink-0"></i>
                                <span>Periksa input Anda:</span>
                            </div>
                            <ul class="list-disc list-inside pl-1 text-[10.5px]">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Login Admin -->
                    <form action="{{ route('login.post') }}" method="POST" id="loginForm" autocomplete="on" class="space-y-3">
                        @csrf
                        
                        <!-- Email / Username / NIP Input -->
                        <div>
                            <label for="usernameInput" class="block text-[10.5px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Email / Username / NIP
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute left-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-user-tie text-[11px]"></i>
                                </div>
                                <input type="text" 
                                       id="usernameInput" 
                                       name="username" 
                                       autocomplete="username"
                                       required
                                       value="{{ old('username') }}"
                                       placeholder="Masukkan email, username, atau NIP"
                                       class="input-sibingka w-full pl-8 pr-3 py-2 rounded-lg text-xs font-semibold placeholder:font-normal placeholder:text-slate-400">
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="passwordInput" class="block text-[10.5px] font-bold text-slate-700 uppercase tracking-wider">
                                    Kata Sandi
                                </label>
                                <button type="button" onclick="openForgotModal()" class="text-[10.5px] font-bold text-[#f95a00] hover:text-orange-700 hover:underline transition-colors">
                                    Lupa kata sandi?
                                </button>
                            </div>
                            <div class="relative flex items-center">
                                <div class="absolute left-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-key text-[11px]"></i>
                                </div>
                                <input type="password" 
                                       id="passwordInput" 
                                       name="password" 
                                       autocomplete="current-password"
                                       required
                                       placeholder="Masukkan kata sandi"
                                       class="input-sibingka w-full pl-8 pr-8 py-2 rounded-lg text-xs font-semibold placeholder:font-normal placeholder:text-slate-400">
                                <button type="button" 
                                        onclick="togglePasswordVisibility()" 
                                        class="absolute right-2.5 text-slate-400 hover:text-slate-600 p-1 transition-colors cursor-pointer"
                                        title="Tampilkan / Sembunyikan Kata Sandi">
                                    <i id="eyeIcon" class="fa-solid fa-eye text-[11px]"></i>
                                </button>
                            </div>
                            
                            <!-- Remember me -->
                            <div class="flex items-center mt-2">
                                <label class="flex items-center space-x-1.5 text-[11px] font-semibold text-slate-600 cursor-pointer select-none">
                                    <input type="checkbox" name="remember" id="rememberMe" checked class="w-3.5 h-3.5 rounded text-orange-600 focus:ring-orange-500 border-slate-300">
                                    <span>Ingat saya</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-1">
                            <button type="submit" id="btnSubmit" class="btn-sibingka text-xs tracking-wider uppercase">
                                <span id="btnText" class="flex items-center justify-center space-x-1.5">
                                    <span>MASUK</span>
                                    <i class="fa-solid fa-arrow-right-to-bracket text-[11px]"></i>
                                </span>
                                <span id="btnSpinner" class="hidden items-center justify-center space-x-1.5">
                                    <i class="fa-solid fa-circle-notch fa-spin text-xs"></i>
                                    <span>Memverifikasi...</span>
                                </span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 w-full py-2 px-4 text-center text-[10px] text-slate-500 border-t border-slate-200/70 bg-white/60 shrink-0">
        <p>© <span id="currentYear"></span> <strong>Badan Pusat Statistik Kota Bukittinggi</strong>. SiBingka Kota Bukittinggi - Sistem Informasi Bukittinggi dalam Angka.</p>
    </footer>

    <!-- MODAL FORGOT PASSWORD / HUBUNGI ADMIN -->
    <div id="forgotModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 hidden transition-all duration-300">
        <div class="bg-white rounded-2xl p-5 max-w-sm w-full shadow-2xl border border-slate-100 transform transition-all">
            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                <div class="flex items-center space-x-2 text-slate-900">
                    <div class="w-7 h-7 rounded-lg bg-orange-100 text-[#f95a00] flex items-center justify-center font-bold text-xs shadow-inner">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3 class="font-extrabold text-xs sm:text-sm text-slate-900">Bantuan Akun & Akses</h3>
                </div>
                <button onclick="closeForgotModal()" class="w-6 h-6 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
            
            <div class="py-3 text-xs text-slate-600 space-y-2.5 leading-relaxed">
                <p class="text-[11px] text-slate-600">
                    Silakan hubungi Tim Pengelola Data BPS Kota Bukittinggi untuk pembuatan akun admin baru atau pemulihan kata sandi:
                </p>
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-200/80 rounded-xl p-2.5 text-orange-950 space-y-1.5 text-[11px] shadow-xs">
                    <a href="https://wa.me/6281200000000" target="_blank" class="flex items-center justify-between hover:text-emerald-700 transition-colors group">
                        <span class="flex items-center font-medium">
                            <i class="fa-brands fa-whatsapp text-emerald-600 mr-2 text-sm"></i> WhatsApp Tim BDA
                        </span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400 group-hover:text-emerald-600"></i>
                    </a>
                    <div class="border-t border-orange-200/50 pt-1.5">
                        <a href="mailto:bps1375@bps.go.id" class="flex items-center justify-between hover:text-blue-700 transition-colors group">
                            <span class="flex items-center font-medium">
                                <i class="fa-solid fa-envelope text-blue-600 mr-2 text-xs"></i> bps1375@bps.go.id
                            </span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400 group-hover:text-blue-600"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-1 flex justify-end">
                <button type="button" onclick="closeForgotModal()" class="w-full py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-all shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        function openForgotModal() {
            document.getElementById('forgotModal').classList.remove('hidden');
        }

        function closeForgotModal() {
            document.getElementById('forgotModal').classList.add('hidden');
        }

        // Login form submit loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');

            btnText.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            btnSpinner.classList.add('flex');
            
            btnSubmit.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>
