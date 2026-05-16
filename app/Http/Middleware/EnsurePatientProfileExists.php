<?php

namespace App\Http\Middleware;

use App\Models\Patients;
use Closure;
use Illuminate\Support\Facades\Auth;

class EnsurePatientProfileExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Only check for patient-type users (user_type = 1)
        if ($user && $user->user_type == 1) {
            $patient = Patients::where('user_id', $user->id)->first();

            if (!$patient) {
                // Redirect to profile creation if no patient record exists
                return redirect()->route('patients.profile.create')
                    ->with('error', 'Please complete your patient profile first.');
            }
        }

        return $next($request);
    }
}
