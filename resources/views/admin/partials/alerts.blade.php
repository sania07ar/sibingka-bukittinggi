<!-- Flash Alert Messages -->
@if(session('success'))
    <div id="flash-alert-success" class="mb-5 p-3.5 rounded-xl text-xs font-semibold flex items-center justify-between bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-sm transition-all duration-500">
        <div class="flex items-center space-x-2.5">
            <i class="fa-solid fa-circle-check text-base text-emerald-500 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="dismissFlashAlert('flash-alert-success')" class="text-emerald-600 hover:text-emerald-900 p-1 rounded-md transition-colors shrink-0" title="Tutup Notifikasi">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div id="flash-alert-error" class="mb-5 p-3.5 rounded-xl text-xs font-semibold flex items-center justify-between bg-red-50 text-red-800 border border-red-200 shadow-sm transition-all duration-500">
        <div class="flex items-center space-x-2.5">
            <i class="fa-solid fa-circle-xmark text-base text-red-500 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="dismissFlashAlert('flash-alert-error')" class="text-red-600 hover:text-red-900 p-1 rounded-md transition-colors shrink-0" title="Tutup Notifikasi">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div id="flash-alert-validation" class="mb-5 p-3.5 rounded-xl text-xs font-medium bg-red-50 text-red-800 border border-red-200 shadow-sm space-y-1 transition-all duration-500">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-1.5 font-bold text-red-700">
                <i class="fa-solid fa-triangle-exclamation text-red-500 shrink-0"></i>
                <span>Terdapat kesalahan pengisian formulir:</span>
            </div>
            <button type="button" onclick="dismissFlashAlert('flash-alert-validation')" class="text-red-600 hover:text-red-900 p-1 rounded-md transition-colors shrink-0" title="Tutup Notifikasi">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
        <ul class="list-disc list-inside pl-1 text-[11px] text-red-600">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    function dismissFlashAlert(id) {
        const el = document.getElementById(id);
        if (el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(() => el.remove(), 400);
        }
    }

    // Selang 2 menit (120.000 ms) notifikasi akan otomatis hilang
    ['flash-alert-success', 'flash-alert-error', 'flash-alert-validation'].forEach(function(alertId) {
        if (document.getElementById(alertId)) {
            setTimeout(function() {
                dismissFlashAlert(alertId);
            }, 120000);
        }
    });
</script>
