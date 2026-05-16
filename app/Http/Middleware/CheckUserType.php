<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $userType
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        // Check 'admin' guard first (for admin login)
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->user_type == $userType) {
                return $next($request);
            }
            return $this->denyAccess($user->user_type);
        }

        // Also check default guard (for other login methods)
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type == $userType) {
                return $next($request);
            }
            return $this->denyAccess($user->user_type);
        }

        // Not logged in - redirect to login
        return redirect()->route('login');
    }

    private function denyAccess($userType)
    {
        switch ($userType) {
            case 0:
                return redirect()->route('admin.dashboard')->with('error', 'Access denied.');
            case 1:
                return redirect()->route('patients.dashboard')->with('error', 'Access denied.');
            case 2:
                return redirect()->route('staff.dashboard')->with('error', 'Access denied.');
            case 3:
                return redirect()->route('doctor.dashboard')->with('error', 'Access denied.');
            default:
                return redirect()->route('login')->with('error', 'Access denied.');
        }
    }
}
