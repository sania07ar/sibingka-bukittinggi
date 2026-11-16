<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSibingkaAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /**
     * Permintaan dari JavaScript (fetch/AJAX) tidak boleh dialihkan ke halaman HTML,
     * karena tombol di halaman akan gagal membaca jawabannya. Untuk itu dikirim JSON.
     */
    protected function wantsJson(Request $request): bool
    {
        return $request->expectsJson()
            || $request->ajax()
            || $request->is('api/*')
            || $request->is('monitoring/update-stage')
            || $request->is('tabel-opd/import-excel');
    }

    protected function deny(Request $request, string $message, int $status, string $route, bool $flash = true): Response
    {
        if ($this->wantsJson($request)) {
            return response()->json(['success' => false, 'message' => $message], $status);
        }

        $redirect = redirect()->route($route);
        return $flash ? $redirect->with('error', $message) : $redirect;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user')) {
            return $this->deny($request, 'Sesi Anda telah berakhir. Silakan masuk kembali.', 401, 'login', false);
        }

        $user = session('user');

        // Check if user is active
        if (isset($user['is_active']) && !$user['is_active']) {
            session()->forget('user');
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return $this->deny($request, 'Akun Anda sedang dinonaktifkan oleh Administrator BPS.', 401, 'login');
        }

        $routeName = $request->route() ? $request->route()->getName() : null;
        $role = $user['role'] ?? 'opd';

        // 1. Only Administrator BPS can access Kelola Akun
        if (str_starts_with($routeName ?? '', 'kelola-akun')) {
            if ($role !== 'admin') {
                return $this->deny($request, 'Akses ditolak: Hanya Administrator BPS yang memiliki wewenang untuk mengelola akun.', 403, 'home');
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

        $managedPages = array_keys(config('sibingka.pages', []));
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
                return $this->deny($request, "Akses Ditolak: Akun {$dinasName} tidak memiliki hak akses untuk membuka halaman ini.", 403, 'home');
            }
        }

        return $next($request);
    }
}
