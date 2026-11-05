<!-- TAB CONTENT 1: KELOLA AKUN DINAS, INSTANSI VERTIKAL & HAK AKSES HALAMAN -->
<div id="tab-content-dinas" class="space-y-6">
    
    <!-- TOOLBAR / FILTER & ACTION BUTTONS -->
    <div class="bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col xl:flex-row items-center justify-between gap-4">
        
        <!-- Search & Filters Form -->
        <form action="{{ route('kelola-akun') }}" method="GET" class="w-full xl:w-auto flex flex-1 flex-col sm:flex-row items-center gap-2.5">
            
            <!-- Search Input -->
            <div class="relative w-full sm:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" 
                       name="q" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Cari dinas, instansi, username..." 
                       class="input-custom w-full pl-8 pr-3 py-2 rounded-xl text-xs font-semibold">
            </div>

            <!-- Filter Kategori / Type -->
            <select name="type" onchange="this.form.submit()" class="input-custom w-full sm:w-48 px-3 py-2 rounded-xl text-xs font-semibold">
                <option value="">Semua Kategori</option>
                <option value="opd" {{ ($filterType ?? '') === 'opd' ? 'selected' : '' }}>Dinas / OPD Kota (20)</option>
                <option value="instansi" {{ ($filterType ?? '') === 'instansi' ? 'selected' : '' }}>Instansi Vertikal & Lainnya (37)</option>
                <option value="walidata" {{ ($filterType ?? '') === 'walidata' ? 'selected' : '' }}>Wali Data (Diskominfo)</option>
            </select>

            <!-- Filter Status -->
            <select name="status" onchange="this.form.submit()" class="input-custom w-full sm:w-36 px-3 py-2 rounded-xl text-xs font-semibold">
                <option value="">Semua Status</option>
                <option value="1" {{ ($filterStatus ?? '') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ ($filterStatus ?? '') === '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            @if(!empty($search) || ($filterStatus !== null && $filterStatus !== '') || !empty($filterType))
                <a href="{{ route('kelola-akun') }}" class="px-2.5 py-2 text-xs font-bold text-slate-500 hover:text-red-600 transition-colors shrink-0">
                    <i class="fa-solid fa-xmark mr-1"></i> Reset
                </a>
            @endif
        </form>

        <!-- Action Buttons: Reset & + Buat Akun Baru -->
        <div class="w-full xl:w-auto flex flex-wrap items-center justify-end gap-2 shrink-0">
            <!-- Reset / Hapus Massal Akun -->
            <button type="button" 
                    onclick="openBulkDeleteModal()" 
                    class="inline-flex items-center space-x-1.5 px-3 py-2 rounded-xl text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 transition-all shadow-xs"
                    title="Hapus akun secara massal atau reset data akun">
                <i class="fa-solid fa-trash-can text-[11px] text-red-600"></i>
                <span>Reset / Hapus Akun</span>
            </button>

            <!-- + Buat Akun Baru -->
            <button type="button" 
                    onclick="openCreateModal()" 
                    class="btn-simonda text-xs">
                <i class="fa-solid fa-user-plus mr-1.5 text-xs"></i>
                <span>Buat Akun Baru</span>
            </button>

        </div>

    </div>

    <!-- TABLE OF ACCOUNTS -->
    <div class="bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200/90 shadow-md shadow-slate-900/5 overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-black text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4 min-w-[240px]">Dinas / Instansi</th>
                        <th class="py-3 px-4 min-w-[170px]">Akun Login</th>
                        <th class="py-3 px-4 text-center min-w-[150px]">Terakhir Login</th>
                        <th class="py-3 px-4 text-right min-w-[110px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @php
                        $opdIcons = [
                            '01' => 'fa-city',
                            '02' => 'fa-file-lines',
                            '03' => 'fa-landmark',
                            '04' => 'fa-users',
                            '05' => 'fa-coins',
                            '06' => 'fa-id-card',
                            '07' => 'fa-handshake',
                            '08' => 'fa-book-open',
                            '09' => 'fa-shield-halved',
                            '10' => 'fa-person-running',
                            '11' => 'fa-book-bookmark',
                            '12' => 'fa-circle-plus',
                            '13' => 'fa-leaf',
                            '14' => 'fa-people-group',
                            '15' => 'fa-fire',
                            '16' => 'fa-hand-holding-heart',
                            '17' => 'fa-seedling',
                            '18' => 'fa-store',
                            '19' => 'fa-location-dot',
                            '20' => 'fa-bus',
                        ];
                    @endphp
                    @forelse($dinasUsers as $index => $dUser)
                        @php
                            $userPages = is_array($dUser->allowed_pages) 
                                ? $dUser->allowed_pages 
                                : json_decode($dUser->allowed_pages ?? '[]', true);
                            $isWali = ($dUser->role === 'walidata');
                            $isInstansi = ($dUser->role === 'instansi');
                            $dinasIcon = $isWali ? 'fa-check-double' : ($isInstansi ? 'fa-landmark' : ($opdIcons[$dUser->opd_code] ?? 'fa-building'));
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            
                            <!-- No -->
                            <td class="py-3.5 px-4 text-center font-bold text-slate-400">
                                {{ $index + 1 }}
                            </td>

                            <!-- Nama Dinas & Kode & Kategori Badge -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center space-x-2.5">
                                    @if($isWali)
                                        <span class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 font-black text-xs flex items-center justify-center shrink-0 border border-teal-200/80" title="Wali Data Statistik Sektoral">
                                            <i class="fa-solid {{ $dinasIcon }} text-sm"></i>
                                        </span>
                                    @elseif($isInstansi)
                                        <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 font-black text-xs flex items-center justify-center shrink-0 border border-indigo-200/80" title="{{ $dUser->opd_code ? 'Kode: ' . $dUser->opd_code : 'Instansi Vertikal' }}">
                                            <i class="fa-solid {{ $dinasIcon }} text-sm"></i>
                                        </span>
                                    @else
                                        <span class="w-8 h-8 rounded-lg bg-orange-100 text-[#f95a00] font-black text-xs flex items-center justify-center shrink-0 border border-orange-200/80" title="{{ $dUser->opd_code ? 'Kode: ' . $dUser->opd_code : 'Dinas Kota' }}">
                                            <i class="fa-solid {{ $dinasIcon }} text-sm"></i>
                                        </span>
                                    @endif
                                    <div>
                                        <div class="flex items-center space-x-1.5 mb-0.5">
                                            <p class="font-extrabold text-slate-900 leading-tight">
                                                {{ $dUser->dinas_name ?? $dUser->name }}
                                            </p>
                                            @if($isWali)
                                                <span class="text-[9.5px] font-black bg-teal-100 text-teal-800 border border-teal-200 px-1.5 py-0.2 rounded-md">
                                                    WALI DATA (KOMINFO)
                                                </span>
                                            @elseif($isInstansi)
                                                <span class="text-[9.5px] font-black bg-indigo-100 text-indigo-800 border border-indigo-200 px-1.5 py-0.2 rounded-md">
                                                    INSTANSI VERTIKAL
                                                </span>
                                            @else
                                                <span class="text-[9.5px] font-black bg-orange-100 text-orange-800 border border-orange-200 px-1.5 py-0.2 rounded-md">
                                                    OPD KOTA
                                                </span>
                                            @endif
                                            @if(!$dUser->is_active)
                                                <span class="text-[9.5px] font-black bg-rose-100 text-rose-700 border border-rose-200 px-1.5 py-0.2 rounded-md">
                                                    NONAKTIF
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[10.5px] text-slate-500">
                                            @if($dUser->opd_code)
                                                <span class="font-bold text-slate-600">Kode: {{ $dUser->opd_code }}</span>
                                            @endif
                                            @if($dUser->phone)
                                                <span class="ml-1 text-slate-400">• <i class="fa-brands fa-whatsapp text-emerald-500"></i> {{ $dUser->phone }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Username & Password Hint -->
                            <td class="py-3.5 px-4 font-mono text-[11px]">
                                <div class="space-y-0.5">
                                    <div class="flex items-center space-x-1 font-bold text-slate-900">
                                        <i class="fa-solid fa-user text-slate-400 text-[10px]"></i>
                                        <span>{{ $dUser->username }}</span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-sans">
                                        Password: <span class="font-bold text-slate-500">{{ $dUser->password_plain_hint ?? 'Disimpan Terenkripsi' }}</span>
                                    </div>
                                </div>
                            </td>


                            <!-- Terakhir Login -->
                            <td class="py-3.5 px-4 text-center">
                                @if($dUser->last_login_at)
                                    <div class="inline-flex flex-col items-center">
                                        <span class="font-bold text-slate-800 text-[11px]">
                                            {{ \Carbon\Carbon::parse($dUser->last_login_at)->timezone('Asia/Jakarta')->isoFormat('D MMM Y') }}
                                        </span>
                                        <span class="text-[10px] text-slate-400">
                                            {{ \Carbon\Carbon::parse($dUser->last_login_at)->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                            ({{ \Carbon\Carbon::parse($dUser->last_login_at)->diffForHumans() }})
                                        </span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-400 border border-slate-200/80" title="Akun ini belum pernah melakukan login sejak didaftarkan">
                                        <i class="fa-regular fa-clock mr-1 text-[9px]"></i> Belum Login
                                    </span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end space-x-1.5">
                                    
                                    <!-- Toggle Status Aktif / Nonaktif -->
                                    <form action="{{ route('kelola-akun.dinas.toggle-status', $dUser->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors {{ $dUser->is_active ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' : 'bg-slate-100 text-slate-400 hover:bg-slate-200' }}"
                                                title="{{ $dUser->is_active ? 'Status: Aktif (Klik untuk Nonaktifkan)' : 'Status: Nonaktif (Klik untuk Aktifkan)' }}">
                                            <i class="fa-solid {{ $dUser->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                        </button>
                                    </form>

                                    <!-- Edit Button -->
                                    <button type="button" 
                                            onclick='openEditModal(@json($dUser))'
                                            class="w-7 h-7 rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 flex items-center justify-center transition-colors"
                                            title="Edit Akun & Izin Akses Halaman">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" 
                                            onclick="openDeleteModal({{ $dUser->id }}, '{{ addslashes($dUser->dinas_name ?? $dUser->name) }}', '{{ addslashes($dUser->username) }}', '{{ $dUser->role }}')"
                                            class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors"
                                            title="Hapus Akun">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-users-slash text-3xl text-slate-300"></i>
                                    <p class="font-bold text-sm">Tidak ada akun dinas/instansi yang ditemukan.</p>
                                    <p class="text-xs text-slate-400">Klik tombol <strong>"+ Buat Akun Baru"</strong> di atas untuk menambahkan akun.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
