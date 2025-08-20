<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // Check if the request is for an admin route
        if ($request->is('admin/*')) {
            // Redirect to admin login page if not authenticated as admin
            return route('admin.login');
        }

        // Default redirect for non-admin users
        if (!$request->expectsJson()) {
            return route('login'); // Regular user login page
        }
    }
}
