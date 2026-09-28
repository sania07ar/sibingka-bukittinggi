<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show the login form for Admin BPS Bukittinggi.
     */
    public function showLoginForm()
    {
        // If already logged in as admin, redirect to portal selection
        if (session()->has('user')) {
            return redirect()->route('portal');
        }

        return view('login');
    }

    /**
     * Handle Admin BPS Bukittinggi login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Nama pengguna / NIP Admin BPS wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $username = trim($request->input('username'));
        $password = $request->input('password');

        $configuredUsername = config('simonda.admin_username', 'admin_bps');
        $configuredPassword = config('simonda.admin_password', 'bpsbukittinggi');
        $adminDisplayName = config('simonda.admin_name', 'Admin BPS Bukittinggi');

        // Check credentials against configured Admin credentials
        // Note: also check if session has custom updated password
        $storedPassword = session('user.custom_password', $configuredPassword);

        if (strcasecmp($username, $configuredUsername) !== 0 || $password !== $storedPassword) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Nama pengguna atau kata sandi Admin BPS salah.');
        }

        // Store Admin user in session
        $userData = [
            'isLoggedIn' => true,
            'username' => $username,
            'displayName' => session('user.displayName', $adminDisplayName),
            'email' => session('user.email', 'bps1375@bps.go.id'),
            'nip' => session('user.nip', '198501012010011005'),
            'role' => 'admin',
            'roleLabel' => 'Administrator BPS Kota Bukittinggi',
            'loginTime' => now()->translatedFormat('d F Y, H:i') . ' WIB',
        ];

        session(['user' => $userData]);

        // Redirect to Portal page where user chooses between Kelola Akun or SiMonDa
        return redirect()->route('portal')->with('success', 'Selamat datang kembali, Administrator BPS Kota Bukittinggi!');
    }

    /**
     * Show the Portal Selection page (Kelola Akun vs Masuk SiMonDa).
     */
    public function showPortal()
    {
        return view('portal');
    }

    /**
     * Show the Kelola Akun page.
     */
    public function showKelolaAkun()
    {
        return view('kelola-akun');
    }

    /**
     * Update Account Profile / Password.
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

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari portal Admin SiMonDa Bukittinggi.');
    }
}
