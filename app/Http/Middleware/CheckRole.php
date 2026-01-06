<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu!');
        }

        $user = Auth::user();

        // Debug: Log user role information
        \Log::info('CheckRole Debug', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'required_roles' => $roles,
            'current_url' => $request->url()
        ]);

        // Check if user has role attribute, if not, treat as basic user
        $userRole = null;
        try {
            $userRole = $user->role ?? null;
            \Log::info('User role retrieved', ['role' => $userRole]);
        } catch (\Exception $e) {
            \Log::warning('Could not access user role: ' . $e->getMessage());
            // If role column doesn't exist, allow access to dashboard but restrict admin functions
            if (in_array('Admin', $roles)) {
                abort(403, 'Akses ditolak. Database belum lengkap, silahkan hubungi administrator.');
            }
        }

        // If no role is set, treat as basic user
        if (empty($userRole)) {
            \Log::warning('User has no role set', ['user_id' => $user->id]);
            // Allow access to basic functions, deny admin functions
            if (in_array('Admin', $roles)) {
                abort(403, 'Akses ditolak. Role belum diatur, silahkan hubungi administrator.');
            }
            // Allow Warga and Mitra access if role is not set
            return $next($request);
        }

        // Admin bebas akses semuanya
        if ($userRole === 'Admin') {
            \Log::info('Admin access granted', ['user_id' => $user->id]);
            return $next($request);
        }

        // Jika role user tidak ada dalam daftar yang diizinkan
        if (!in_array($userRole, $roles)) {
            \Log::warning('Access denied', [
                'user_role' => $userRole,
                'required_roles' => $roles,
                'user_id' => $user->id
            ]);
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        \Log::info('Access granted', [
            'user_role' => $userRole,
            'required_roles' => $roles,
            'user_id' => $user->id
        ]);

        return $next($request);
    }
}
