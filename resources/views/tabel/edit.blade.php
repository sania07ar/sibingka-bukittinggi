<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    @include('partials.base-url')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Edit Data Tabel Statistik Sektoral - SiBingka Kota Bukittinggi BPS">
    <title>Edit Data Tabel - SiBingka Kota Bukittinggi</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- xlsx-js-style for Excel Import & Parsing -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>

    <!-- Master Tables Catalog (All OPD & Instansi) -->
    <script src="{{ asset('sibingka-catalogs.js') }}?v={{ @filemtime(public_path('sibingka-catalogs.js')) }}"></script>
    <!-- Table Helpers & Schemas -->
    <script src="{{ asset('js/tabel/helpers.js') }}?v={{ @filemtime(public_path('js/tabel/helpers.js')) }}"></script>
    @include('partials.script-group', ['dir' => 'js/tabel/schemas-edit'])

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/tabel-edit.css') }}?v={{ @filemtime(public_path('css/tabel-edit.css')) }}">
</head>
<body class="min-h-screen flex flex-col justify-between text-slate-800 antialiased selection:bg-orange-500 selection:text-white relative bg-[#f4f6f8]">

    <!-- Decorative Top Background Glow -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-64 bg-gradient-to-b from-orange-100/40 via-orange-50/20 to-transparent pointer-events-none -z-10"></div>

    <!-- Background SiBingka Jam Gadang Watermark -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden flex items-center justify-center opacity-15 select-none">
        <img src="{{ asset('images/sibingka-watermark-jamgadang.jpg') }}" alt="Watermark SiBingka Jam Gadang" class="w-[850px] sm:w-[1100px] lg:w-[1300px] max-w-none transform -translate-x-16 sm:-translate-x-28 -translate-y-6 object-contain mix-blend-multiply">
    </div>

    <!-- MAIN WRAPPER -->
    <div class="w-full flex-1 flex flex-col">
        
        @include('tabel.partials.edit.header')

        @include('tabel.partials.edit.breadcrumb')

        @include('tabel.partials.edit.main')

        @include('tabel.partials.edit.footer')

    </div>



    @include('tabel.partials.edit.comment-drawer')

    @include('tabel.partials.edit.toast')


    @include('tabel.partials.edit.config-script')

    <!-- 2. MODULAR JAVASCRIPT SUITE -->
    <script src="{{ asset('js/tabel/templates.js') }}?v={{ @filemtime(public_path('js/tabel/templates.js')) }}"></script>
    <script src="{{ asset('js/tabel/navigation.js') }}?v={{ @filemtime(public_path('js/tabel/navigation.js')) }}"></script>
    <script src="{{ asset('js/tabel/comments.js') }}?v={{ @filemtime(public_path('js/tabel/comments.js')) }}"></script>
    <script src="{{ asset('js/tabel/export-suite.js') }}?v={{ @filemtime(public_path('js/tabel/export-suite.js')) }}"></script>
    @include('partials.script-group', ['dir' => 'js/tabel/table-editor'])
</body>
</html>