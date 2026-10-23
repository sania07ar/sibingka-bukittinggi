<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head', ['title' => 'Pilih Layanan - SiAngka Kota Bukittinggi | BPS Kota Bukittinggi'])
    @include('admin.partials.portal-styles')
</head>
<body class="min-h-screen w-full overflow-y-auto lg:overflow-hidden lg:h-screen lg:max-h-screen text-slate-800 antialiased flex flex-col justify-between relative selection:bg-orange-500 selection:text-white bg-[#f1f4f9]">

    <!-- Ambient Background Lighting & Watermark -->
    @include('partials.ambient')

    <!-- HEADER / LOGO BAR (BPS, Sensus Ekonomi, BerAKHLAK) -->
    @include('partials.navbar', ['homeUrl' => route('portal')])

    <!-- MAIN CONTENT -->
    <main class="relative z-10 flex-1 flex flex-col justify-start lg:justify-center items-center px-3 sm:px-6 lg:px-8 py-2.5 sm:py-3 lg:py-4 max-w-5xl mx-auto w-full pb-8 sm:pb-4 min-h-0">
        
        <!-- Welcome Hero Greeting -->
        @include('admin.partials.portal-hero')

        <!-- 2 PILIHAN UTAMA: KELOLA AKUN vs MASUK KE SiAngka -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 lg:gap-6 w-full max-w-4xl my-auto">
            <!-- Pilihan 1: Kelola Akun Admin -->
            @include('admin.partials.portal-card-kelola-akun')

            <!-- Pilihan 2: Masuk Halaman SiAngka -->
            @include('admin.partials.portal-card-masuk-simonda')
        </div>

    </main>

    <!-- FOOTER / BOTTOM BAR DENGAN PROFIL & LOGOUT -->
    @include('admin.partials.portal-footer')

</body>
</html>
