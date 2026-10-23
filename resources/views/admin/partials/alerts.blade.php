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
            <span>Terdapat kesalahan pengisian formulir:</span>
        </div>
        <ul class="list-disc list-inside pl-1 text-[11px] text-red-600">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
