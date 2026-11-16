{{--
    Memuat SEMUA file .js di satu folder (di dalam folder public/), berurutan menurut nama file.
    Cara pakai:  @include('partials.script-group', ['dir' => 'js/tabel/table-index'])
    File panjang dipecah jadi beberapa file bernomor (01-..., 02-..., 99-...) agar mudah diubah.
    Tambah file baru di folder tersebut -> otomatis ikut dimuat (urutan mengikuti nomor di depan nama).
--}}
@php
    $scriptDir = trim($dir, '/');
    $scriptFiles = glob(public_path($scriptDir . '/*.js')) ?: [];
    sort($scriptFiles);
@endphp
@foreach ($scriptFiles as $scriptFile)
    <script src="{{ asset($scriptDir . '/' . basename($scriptFile)) }}?v={{ @filemtime($scriptFile) }}"></script>
@endforeach
