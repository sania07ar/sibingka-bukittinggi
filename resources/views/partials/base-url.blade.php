{{-- Alamat dasar aplikasi untuk JavaScript (lihat public/js/core/base-url.js) --}}
<script>window.SiBingkaBaseUrl = @json(rtrim(parse_url(url('/'), PHP_URL_PATH) ?: '', '/'));</script>
<script src="{{ asset('js/core/base-url.js') }}?v={{ @filemtime(public_path('js/core/base-url.js')) }}"></script>
<script>window.sbUrl = window.sbUrl || function (p) { return (window.SiBingkaBaseUrl || '') + p; };</script>
