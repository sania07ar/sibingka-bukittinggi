<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSimondaAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $user = session('user');

        // Check if user is active
        if (isset($user['is_active']) && !$user['is_active']) {
            session()->forget('user');
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Akun Anda sedang dinonaktifkan oleh Administrator BPS.');
        }

        $routeName = $request->route() ? $request->route()->getName() : null;
        $role = $user['role'] ?? 'opd';

        // 1. Only Administrator BPS can access Kelola Akun
        if (str_starts_with($routeName ?? '', 'kelola-akun')) {
            if ($role !== 'admin') {
                return redirect()->route('home')->with('error', 'Akses ditolak: Hanya Administrator BPS yang memiliki wewenang untuk mengelola akun.');
            }
        }

        // 2. If non-admin accesses portal selection, redirect to home if they only have specific page access
        if ($routeName === 'portal' && $role !== 'admin') {
            return redirect()->route('home');
        }

        // 3. Check page permissions for non-admin users
        if ($role === 'walidata') {
            return $next($request);
        }

        $managedPages = array_keys(config('simonda.pages', []));
        if ($role !== 'admin' && in_array($routeName, $managedPages, true)) {
            // General table data view and edit are essential workflows for all authenticated OPD/Instansi
            if (in_array($routeName, ['tabel-opd', 'edit-tabel-opd'], true)) {
                return $next($request);
            }

            // Always allow default data entry & monitoring according to role
            if ($role === 'instansi' && in_array($routeName, ['isi-data-instansi', 'monitoring-instansi'], true)) {
                return $next($request);
            }
            if ($role === 'opd' && in_array($routeName, ['isi-data-opd', 'monitoring-opd'], true)) {
                return $next($request);
            }

            // Refresh allowed_pages from database in case user session is stale
            $allowedPages = $user['allowed_pages'] ?? [];
            if (isset($user['id']) && $user['id'] > 0) {
                try {
                    $dbUser = \App\Models\User::find($user['id']);
                    if ($dbUser && !empty($dbUser->allowed_pages)) {
                        $allowedPages = is_array($dbUser->allowed_pages)
                            ? $dbUser->allowed_pages
                            : json_decode($dbUser->allowed_pages, true);
                        $user['allowed_pages'] = $allowedPages;
                        session(['user' => $user]);
                    }
                } catch (\Throwable $e) {
                    // Fallback to existing session
                }
            }

            if (!in_array($routeName, $allowedPages, true)) {
                $dinasName = $user['dinas_name'] ?? 'Dinas';
                return redirect()->route('home')->with('error', "Akses Ditolak: Akun {$dinasName} tidak memiliki hak akses untuk membuka halaman ini.");
            }
        }

        return $next($request);
    }
}
