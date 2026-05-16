<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorProfileController extends Controller
{
    /**
     * Show doctor profile view
     */
    public function show()
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        return view('doctor.profile', compact('user', 'doctor'));
    }

    /**
     * Show form for editing doctor profile
     */
    public function edit()
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'Doctor profile not found.');
        }

        return view('doctor.edit-profile', compact('user', 'doctor'));
    }

    /**
     * Update doctor profile and user information
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'specialization' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_available' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'Doctor profile not found.');
        }

        // Update user information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update doctor information
        $doctor->update([
            'specialization' => $request->specialization,
            'address' => $request->address,
            'is_available' => $request->has('is_available') ? true : false,
        ]);

        return redirect()->route('doctor.profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update doctor password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
