    <!-- 1. GLOBAL SIBINGKA CONFIGURATION & STATE (HARUS PERTAMA SEBELUM MODUL JS LAINNYA) -->
    <script>
        window.SiBingkaConfig = {
            csrfToken: '{{ csrf_token() }}',
            currentOpdCode: '{{ $currentOpdCode ?? "01" }}',
            currentTableCode: '{{ $currentTableCode ?? "1.1.6" }}',
            currentYear: '{{ $currentYear ?? date("Y") }}',
            currentType: '{{ $currentType ?? "opd" }}',
            serverDbDataStore: @json($dbDataStore ?? []),
            serverDbMetadata: @json($dbMetadata ?? null),
            serverDbFallbackMetadata: @json($dbFallbackMetadata ?? null),
            serverDbCustomTables: @json($dbCustomTables ?? []),
            currentUserData: @json(session('user') ?? ['name' => 'Pengguna', 'role' => 'opd', 'displayName' => 'Pengguna']),
            routes: {
                dataBps: '{{ route("data-bps") }}',
                isiDataInstansi: '{{ route("isi-data-instansi") }}',
                isiDataOpd: '{{ route("isi-data-opd") }}',
                apiData: '{{ route("tabel-opd.api.data") }}',
                apiDelete: '{{ route("tabel-opd.api.delete") }}',
                apiSave: '{{ route("tabel-opd.api.save") }}',
                tabelOpd: '{{ route("tabel-opd") }}',
                apiComments: '{{ route("tabel-opd.api.comments") }}',
                apiSaveComment: '{{ route("tabel-opd.api.save-comment") }}',
                apiSubmitVerification: '{{ route("tabel-opd.api.submit-verification") }}',
                apiApproveVerification: '{{ route("tabel-opd.api.approve-verification") }}',
                apiRejectVerification: '{{ route("tabel-opd.api.reject-verification") }}'
            }
        };

        // Sinkronisasi variabel ke global window agar kompatibel 100%
        window.currentOpdCode = window.SiBingkaConfig.currentOpdCode;
        window.currentTableCode = window.SiBingkaConfig.currentTableCode;
        window.currentYear = window.SiBingkaConfig.currentYear;
        window.currentType = window.SiBingkaConfig.currentType;
        window.csrfToken = window.SiBingkaConfig.csrfToken;
        window.serverDbDataStore = window.SiBingkaConfig.serverDbDataStore;
        window.serverDbMetadata = window.SiBingkaConfig.serverDbMetadata;
        window.serverDbFallbackMetadata = window.SiBingkaConfig.serverDbFallbackMetadata;
        window.serverDbCustomTables = window.SiBingkaConfig.serverDbCustomTables;
        window.currentUserData = window.SiBingkaConfig.currentUserData;
        window.tableSchemas = window.tableSchemas || {};
        window.isEditMode = true;
    </script>
