<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form for Admin BPS or Dinas Users.
     */
    public function showLoginForm()
    {
        // If already logged in, redirect directly to home
        if (session()->has('user')) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Handle Admin BPS & Dinas User Login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Nama pengguna / NIP / Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $username = trim($request->input('username'));
        $password = $request->input('password');

        $configuredUsername = config('simonda.admin_username', 'admin_bps');
        $configuredPassword = config('simonda.admin_password', 'bpsbukittinggi');
        $adminDisplayName = config('simonda.admin_name', 'Admin BPS Bukittinggi');
        $storedAdminPassword = session('user.custom_password', $configuredPassword);

        // 1. Check Super Admin credentials
        if (strcasecmp($username, $configuredUsername) === 0 && $password === $storedAdminPassword) {
            $userData = [
                'id' => 0,
                'isLoggedIn' => true,
                'username' => $username,
                'displayName' => session('user.displayName', $adminDisplayName),
                'email' => session('user.email', 'bps1375@bps.go.id'),
                'nip' => session('user.nip', '198501012010011005'),
                'role' => 'admin',
                'roleLabel' => 'Administrator BPS Kota Bukittinggi',
                'dinas_name' => 'BPS Kota Bukittinggi',
                'opd_code' => null,
                'allowed_pages' => array_keys(config('simonda.pages', [])),
                'loginTime' => now()->translatedFormat('d F Y, H:i') . ' WIB',
            ];

            session(['user' => $userData]);
            return redirect()->route('home')->with('success', 'Selamat datang kembali, Administrator BPS Kota Bukittinggi!');
        }

        // 2. Check Database Users (Dinas / OPD / Registered Admin)
        $dbUser = User::where('username', $username)
            ->orWhere('email', $username)
            ->orWhere('nip', $username)
            ->first();

        if ($dbUser) {
            // Verify password (hash or legacy fallback)
            $passwordMatches = Hash::check($password, $dbUser->password) || ($password === $dbUser->password);

            if ($passwordMatches) {
                // Ensure active
                if (!$dbUser->is_active) {
                    return back()
                        ->withInput($request->only('username'))
                        ->with('error', 'Akun dinas Anda saat ini sedang dinonaktifkan oleh Administrator BPS.');
                }

                $role = $dbUser->role ?? 'opd';
                $allowedPages = is_array($dbUser->allowed_pages) 
                    ? $dbUser->allowed_pages 
                    : json_decode($dbUser->allowed_pages ?? '[]', true);

                $userData = [
                    'id' => $dbUser->id,
                    'isLoggedIn' => true,
                    'username' => $dbUser->username ?? $dbUser->email,
                    'displayName' => $dbUser->name,
                    'email' => $dbUser->email,
                    'nip' => $dbUser->nip,
                    'phone' => $dbUser->phone,
                    'role' => $role,
                    'roleLabel' => $role === 'admin' ? 'Administrator BPS' : ($dbUser->dinas_name ?? 'User OPD'),
                    'dinas_name' => $dbUser->dinas_name ?? $dbUser->name,
                    'opd_code' => $dbUser->opd_code,
                    'allowed_pages' => $allowedPages,
                    'loginTime' => now()->translatedFormat('d F Y, H:i') . ' WIB',
                ];

                session(['user' => $userData]);

                // Update last login timestamp
                try {
                    $dbUser->update(['last_login_at' => now()]);
                } catch (\Throwable $th) {
                    // Ignore if column doesn't exist
                }

                if ($role === 'admin') {
                    return redirect()->route('home')->with('success', "Selamat datang, {$dbUser->name}!");
                }

                return redirect()->route('home')->with('success', "Selamat datang di SiAngka Kota Bukittinggi, {$dbUser->dinas_name}!");
            }
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Nama pengguna, NIP, atau kata sandi tidak sesuai.');
    }

    /**
     * Show the Portal Selection page (Redirects directly to SiAngka Home).
     */
    public function showPortal()
    {
        return redirect()->route('home');
    }

    /**
     * Show the Kelola Akun page (Admin profile + Dinas user management).
     */
    /**
     * Show the Kelola Akun page (Admin profile + Dinas & Instansi user management).
     */
    public function showKelolaAkun(Request $request)
    {
        $search = $request->query('q');
        $filterStatus = $request->query('status');
        $filterType = $request->query('type'); // 'opd', 'instansi', or null (all)

        $query = User::where('role', '!=', 'admin')->orWhereNull('role');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('dinas_name', 'like', "%{$search}%")
                  ->orWhere('opd_code', 'like', "%{$search}%");
            });
        }

        if ($filterStatus !== null && $filterStatus !== '') {
            $query->where('is_active', $filterStatus === '1');
        }

        if (!empty($filterType)) {
            if ($filterType === 'opd') {
                $query->where(function($q) {
                    $q->where('role', 'opd')->orWhereNull('role');
                });
            } elseif ($filterType === 'instansi') {
                $query->where('role', 'instansi');
            }
        }

        $dinasUsers = $query->orderBy('role')->orderBy('opd_code')->orderBy('name')->get();
        $pagesList = config('simonda.pages', []);
        $opdList = config('simonda.opd_list', []);
        $instansiList = config('simonda.instansi_list', []);

        return view('admin.kelola-akun', compact('dinasUsers', 'pagesList', 'opdList', 'instansiList', 'search', 'filterStatus', 'filterType'));
    }

    /**
     * Create a new Dinas / Instansi User.
     */
    public function createDinasUser(Request $request)
    {
        $request->validate([
            'role' => 'nullable|string|in:opd,instansi',
            'opd_code' => 'nullable|string|max:20',
            'dinas_name' => 'required|string|max:150',
            'name' => 'nullable|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'nullable|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:30',
            'nip' => 'nullable|string|max:30',
            'allowed_pages' => 'nullable|array',
            'is_active' => 'nullable',
        ], [
            'dinas_name.required' => 'Nama Dinas / Instansi wajib dipilih.',
            'username.required' => 'Username login wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan, silakan pilih username lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $role = $request->input('role', 'opd');
        $allowedPages = $request->input('allowed_pages');
        if (empty($allowedPages)) {
            $allowedPages = ($role === 'instansi')
                ? ['isi-data-instansi']
                : ['isi-data-opd', 'tabel-opd', 'edit-tabel-opd'];
        }
        $username = trim($request->input('username'));
        $dinasName = trim($request->input('dinas_name'));
        $name = $request->filled('name') ? trim($request->input('name')) : $dinasName;

        // Auto-generate fallback email if not supplied
        $email = $request->filled('email') 
            ? trim($request->input('email')) 
            : ($username . '@simonda.bukittinggikota.go.id');

        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $username . $counter . '@simonda.bukittinggikota.go.id';
            $counter++;
        }

        User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($request->input('password')),
            'nip' => $request->input('nip'),
            'phone' => $request->input('phone'),
            'role' => $role,
            'opd_code' => $request->input('opd_code'),
            'dinas_name' => $dinasName,
            'allowed_pages' => $allowedPages,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        $typeLabel = $role === 'instansi' ? 'Instansi Vertikal' : 'Dinas / OPD';
        return redirect()->route('kelola-akun')
            ->with('success', "Akun {$typeLabel} untuk {$dinasName} berhasil dibuat.");
    }

    /**
     * Update an existing Dinas / Instansi User.
     */
    public function updateDinasUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'nullable|string|in:opd,instansi',
            'opd_code' => 'nullable|string|max:20',
            'dinas_name' => 'required|string|max:150',
            'name' => 'nullable|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'email' => 'nullable|email|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:30',
            'nip' => 'nullable|string|max:30',
            'allowed_pages' => 'nullable|array',
            'is_active' => 'nullable',
        ], [
            'dinas_name.required' => 'Nama Dinas / Instansi wajib dipilih.',
            'username.required' => 'Username login wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
        ]);

        $dinasName = trim($request->input('dinas_name'));
        $user->name = $request->filled('name') ? trim($request->input('name')) : $dinasName;
        $user->username = trim($request->input('username'));

        if ($request->filled('email')) {
            $user->email = trim($request->input('email'));
        } elseif (empty($user->email)) {
            $user->email = $user->username . '@simonda.bukittinggikota.go.id';
        }

        $user->nip = $request->input('nip');
        $user->phone = $request->input('phone');
        if ($request->filled('role')) {
            $user->role = $request->input('role');
        }
        $user->opd_code = $request->input('opd_code');
        $user->dinas_name = $dinasName;
        $allowedPages = $request->input('allowed_pages');
        if (!empty($allowedPages)) {
            $user->allowed_pages = $allowedPages;
        } else {
            $user->allowed_pages = ($user->role === 'instansi')
                ? ['isi-data-instansi']
                : ['isi-data-opd', 'tabel-opd', 'edit-tabel-opd'];
        }
        $user->is_active = $request->has('is_active') ? true : false;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('kelola-akun')
            ->with('success', "Data dan hak akses akun {$user->dinas_name} berhasil diperbarui.");
    }

    /**
     * Delete a Dinas User.
     */
    public function deleteDinasUser($id)
    {
        $user = User::findOrFail($id);
        $dinasName = $user->dinas_name ?? $user->name;
        $user->delete();

        return redirect()->route('kelola-akun')
            ->with('success', "Akun {$dinasName} berhasil dihapus dari sistem.");
    }

    /**
     * Bulk Delete / Reset Dinas or Instansi Accounts.
     */
    public function bulkDeleteDinasUsers(Request $request)
    {
        $targetType = $request->input('target_type', 'all');

        $query = User::query();

        if ($targetType === 'opd') {
            $query->where(function ($q) {
                $q->where('role', 'opd')->orWhereNull('role');
            });
            $count = $query->count();
            $query->delete();
            $message = "Berhasil menghapus {$count} akun OPD Kota Bukittinggi.";
        } elseif ($targetType === 'instansi') {
            $query->where('role', 'instansi');
            $count = $query->count();
            $query->delete();
            $message = "Berhasil menghapus {$count} akun Instansi Vertikal & Perguruan Tinggi.";
        } else {
            // Delete all opd & instansi accounts (exclude any admin)
            $query->where('role', '!=', 'admin');
            $count = $query->count();
            $query->delete();
            $message = "Berhasil mereset dan menghapus seluruh {$count} akun dinas & instansi.";
        }

        return redirect()->route('kelola-akun')->with('success', $message);
    }

    /**
     * Toggle status active/inactive for a Dinas/Instansi user.
     */
    public function toggleDinasUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('kelola-akun')
            ->with('success', "Akun {$user->dinas_name} berhasil {$statusStr}.");
    }

    /**
     * Batch Seed: Auto-generate default accounts for all 20 OPDs.
     */
    public function batchSeedDinasUsers()
    {
        $opdList = config('simonda.opd_list', []);
        $defaultPages = ['isi-data-opd', 'monitoring-opd', 'tabel-opd', 'edit-tabel-opd'];
        $createdCount = 0;
        $updatedCount = 0;

        foreach ($opdList as $code => $opd) {
            $existing = User::where('opd_code', $code)
                ->where(function($q) {
                    $q->where('role', 'opd')->orWhereNull('role');
                })
                ->orWhere('username', $opd['default_username'])
                ->first();

            if (!$existing) {
                User::create([
                    'name' => 'Operator ' . $opd['short_name'],
                    'username' => $opd['default_username'],
                    'email' => $opd['email'],
                    'password' => Hash::make('bpsbukittinggi'),
                    'role' => 'opd',
                    'opd_code' => $code,
                    'dinas_name' => $opd['name'],
                    'allowed_pages' => $defaultPages,
                    'is_active' => true,
                ]);
                $createdCount++;
            } else {
                $existing->role = 'opd';
                $existing->opd_code = $code;
                $existing->dinas_name = $opd['name'];
                if (empty($existing->allowed_pages)) {
                    $existing->allowed_pages = $defaultPages;
                }
                $existing->save();
                $updatedCount++;
            }
        }

        return redirect()->route('kelola-akun')
            ->with('success', "Berhasil memproses akun 20 OPD! ({$createdCount} akun baru dibuat, {$updatedCount} akun disesuaikan). Kata sandi default: 'bpsbukittinggi'.");
    }

    /**
     * Batch Seed: Auto-generate default accounts for all 37 Instansi Vertikal.
     */
    public function batchSeedInstansiUsers()
    {
        $instansiList = config('simonda.instansi_list', []);
        $defaultPages = ['isi-data-instansi', 'monitoring-instansi', 'tabel-opd', 'edit-tabel-opd'];
        $createdCount = 0;
        $updatedCount = 0;

        foreach ($instansiList as $code => $inst) {
            $existing = User::where('opd_code', $code)
                ->where('role', 'instansi')
                ->orWhere('username', $inst['default_username'])
                ->first();

            if (!$existing) {
                User::create([
                    'name' => 'Operator ' . $inst['short_name'],
                    'username' => $inst['default_username'],
                    'email' => $inst['email'],
                    'password' => Hash::make('bpsbukittinggi'),
                    'role' => 'instansi',
                    'opd_code' => $code,
                    'dinas_name' => $inst['name'],
                    'allowed_pages' => $defaultPages,
                    'is_active' => true,
                ]);
                $createdCount++;
            } else {
                $existing->role = 'instansi';
                $existing->opd_code = $code;
                $existing->dinas_name = $inst['name'];
                if (empty($existing->allowed_pages)) {
                    $existing->allowed_pages = $defaultPages;
                }
                $existing->save();
                $updatedCount++;
            }
        }

        return redirect()->route('kelola-akun')
            ->with('success', "Berhasil memproses akun 37 Instansi Vertikal & Lainnya! ({$createdCount} akun baru dibuat, {$updatedCount} akun disesuaikan). Kata sandi default: 'bpsbukittinggi'.");
    }

    /**
     * Update Super Admin Account Profile / Password.
     */
    public function updateKelolaAkun(Request $request)
    {
        $action = $request->input('action_type', 'profile');

        if ($action === 'password') {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ], [
                'current_password.required' => 'Kata sandi saat ini wajib diisi.',
                'new_password.required' => 'Kata sandi baru wajib diisi.',
                'new_password.min' => 'Kata sandi baru minimal 6 karakter.',
                'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak sesuai.',
            ]);

            $configuredPassword = config('simonda.admin_password', 'bpsbukittinggi');
            $currentStoredPassword = session('user.custom_password', $configuredPassword);

            if ($request->input('current_password') !== $currentStoredPassword) {
                return back()->with('error', 'Kata sandi saat ini tidak sesuai.');
            }

            session([
                'user.custom_password' => $request->input('new_password')
            ]);

            return back()->with('success', 'Kata sandi administrator berhasil diperbarui.');
        }

        // Profile update
        $request->validate([
            'displayName' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'nip' => 'nullable|string|max:30',
        ], [
            'displayName.required' => 'Nama lengkap administrator wajib diisi.',
            'email.required' => 'Alamat email BPS wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $user = session('user', []);
        $user['displayName'] = $request->input('displayName');
        $user['email'] = $request->input('email');
        $user['nip'] = $request->input('nip');

        session(['user' => $user]);

        return back()->with('success', 'Informasi profil akun administrator berhasil diperbarui.');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari portal SiAngka Kota Bukittinggi.');
    }
}
