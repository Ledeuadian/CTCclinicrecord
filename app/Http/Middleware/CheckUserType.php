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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->user_type != $userType) {
            // Redirect to the appropriate dashboard based on user type
            $userType = Auth::user()->user_type;
            switch ($userType) {
                case 0:
                    return redirect()->route('admin.dashboard')->with('error', 'Access denied. You do not have permission to access this page.');
                case 1:
                    return redirect()->route('patients.dashboard')->with('error', 'Access denied. You do not have permission to access this page.');
                case 2:
                    return redirect()->route('staff.dashboard')->with('error', 'Access denied. You do not have permission to access this page.');
                case 3:
                    return redirect()->route('doctor.dashboard')->with('error', 'Access denied. You do not have permission to access this page.');
                default:
                    return redirect()->route('login')->with('error', 'Access denied. You do not have permission to access this page.');
            }
        }

        return $next($request);
    }
}
