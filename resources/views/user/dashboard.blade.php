<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    @include('partials.base-url')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiBingka Kota Bukittinggi - BPS Kota Bukittinggi</title>
    
    <!-- Favicon Logo BPS -->
    <link rel="icon" type="image/png" href="{{ asset('images/sibingka-icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sibingka-icon.png') }}">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..900;1,14..32,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ @filemtime(public_path('css/dashboard.css')) }}">
</head>
<body class="min-h-screen text-slate-800 flex flex-col selection:bg-orange-500 selection:text-white bg-[#f1f4f9] relative overflow-x-hidden">

    @php
        $currentUser = session('user', []);
        $role = $currentUser['role'] ?? 'opd';
        $isInstansiUser = $role === 'instansi';
        $isWaliData = $role === 'walidata';
        $isBpsUser = $role === 'bps';
        $allowedPages = $currentUser['allowed_pages'] ?? [];
        $dinasName = $currentUser['dinas_name'] ?? ($currentUser['displayName'] ?? 'Dinas');
        $username = $currentUser['username'] ?? 'User';
        $opdCode = $currentUser['opd_code'] ?? '01';

        if ($isWaliData) {
            $targetRoute = route('monitoring-opd');
            $btnLabel = 'Mulai Monitoring & Verifikasi Data';
        } elseif ($isBpsUser) {
            $targetRoute = route('data-bps');
            $btnLabel = 'Mulai Isi Data BPS';
        } elseif ($isInstansiUser) {
            $targetRoute = route('isi-data-instansi');
            $btnLabel = 'Mulai Isi Data Instansi';
        } else {
            $targetRoute = route('isi-data-opd');
            $btnLabel = 'Mulai Isi Data OPD';
        }
    @endphp

    <!-- Flash Alert Notification if Access Denied -->
    @if(session('error'))
        <div id="welcome-alert-error" class="fixed top-24 left-1/2 -translate-x-1/2 z-50 max-w-lg w-full px-4 animate-in fade-in duration-300 transition-all">
            <div class="p-3 rounded-2xl text-xs font-bold flex items-center justify-between bg-red-600 text-white shadow-2xl shadow-red-900/30 border border-red-500">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-circle-exclamation text-base shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('welcome-alert-error').remove()" class="text-white hover:text-red-200 text-sm ml-2">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div id="welcome-alert-success" class="fixed top-24 left-1/2 -translate-x-1/2 z-50 max-w-lg w-full px-4 animate-in fade-in duration-300 transition-all">
            <div class="p-3 rounded-2xl text-xs font-bold flex items-center justify-between bg-emerald-600 text-white shadow-2xl shadow-emerald-900/30 border border-emerald-500">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-circle-check text-base shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('welcome-alert-success').remove()" class="text-white hover:text-emerald-200 text-sm ml-2">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Ambient Glow Background Spheres -->
    <div class="ambient-sphere w-[550px] h-[550px] bg-orange-200/50 -top-40 -left-40"></div>
    <div class="ambient-sphere w-[500px] h-[500px] bg-blue-100/50 -top-20 -right-20"></div>

    @include('user.partials.dashboard.header')

    @include('user.partials.dashboard.main')

    @include('user.partials.dashboard.footer')

    @include('user.partials.dashboard.about-modal')

    @include('user.partials.dashboard.scripts')
</body>
</html>

