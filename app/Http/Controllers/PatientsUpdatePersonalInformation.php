<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientsUpdatePersonalInformation extends Controller
{
    /**
     * Show patient profile
     */
    public function profile()
    {
        $user = Auth::user();
        $patient = Patients::where('user_id', $user->id)->first();
        
        return view('patients.profile', compact('user', 'patient'));
    }

    /**
     * Show form for creating new patient profile
     */
    public function create()
    {
        $user = Auth::user();
        $existingPatient = Patients::where('user_id', $user->id)->first();
        
        if ($existingPatient) {
            return redirect()->route('patients.profile')
                ->with('info', 'You already have a patient profile.');
        }

        return view('patients.create-profile');
    }

    /**
     * Store a newly created patient profile
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_type' => 'required|string',
            'address' => 'required|string|max:255',
            'medical_condition' => 'nullable|string',
            'medical_illness' => 'nullable|string',
            'operations' => 'nullable|string',
            'allergies' => 'nullable|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:255',
            'emergency_relationship' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        
        // Check if patient profile already exists
        $existingPatient = Patients::where('user_id', $user->id)->first();
        if ($existingPatient) {
            return redirect()->route('patients.profile')
                ->with('error', 'Patient profile already exists.');
        }
        
        Patients::create([
            'user_id' => $user->id,
            'patient_type' => $request->patient_type,
            'address' => $request->address,
            'medical_condition' => $request->medical_condition,
            'medical_illness' => $request->medical_illness,
            'operations' => $request->operations,
            'allergies' => $request->allergies,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'emergency_relationship' => $request->emergency_relationship,
        ]);

        return redirect()->route('patients.index')
            ->with('success', 'Patient profile created successfully!');
    }

    /**
     * Show the form for editing patient profile
     */
    public function edit()
    {
        $user = Auth::user();
        $patients = Patients::where('user_id', $user->id)->first();
        
        if (!$patients) {
            return redirect()->route('patients.profile.create')
                ->with('info', 'Please create your patient profile first.');
        }

        return view('patients.edit-profile', compact('user', 'patients'));
    }

    /**
     * Update patient profile and user information
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'patient_type' => 'required|string',
            'address' => 'required|string|max:255',
            'medical_condition' => 'nullable|string',
            'medical_illness' => 'nullable|string',
            'operations' => 'nullable|string',
            'allergies' => 'nullable|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:255',
            'emergency_relationship' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $patients = Patients::where('user_id', $user->id)->first();
        
        if (!$patients) {
            return redirect()->route('patients.profile.create')
                ->with('error', 'Patient profile not found.');
        }
        
        // Update user information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update patient information
        $patients->update([
            'patient_type' => $request->patient_type,
            'address' => $request->address,
            'medical_condition' => $request->medical_condition,
            'medical_illness' => $request->medical_illness,
            'operations' => $request->operations,
            'allergies' => $request->allergies,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'emergency_relationship' => $request->emergency_relationship,
        ]);

        return redirect()->route('patients.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user password
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

    /**
     * Update only basic user information (name, email)
     */
    public function updateBasicInfo(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Basic information updated successfully!');
    }

    /**
     * Update only medical information
     */
    public function updateMedicalInfo(Request $request)
    {
        $request->validate([
            'medical_condition' => 'nullable|string',
            'medical_illness' => 'nullable|string',
            'operations' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $user = Auth::user();
        $patients = Patients::where('user_id', $user->id)->first();
        
        if (!$patients) {
            return redirect()->route('patients.profile.create')
                ->with('error', 'Patient profile not found.');
        }

        $patients->update([
            'medical_condition' => $request->medical_condition,
            'medical_illness' => $request->medical_illness,
            'operations' => $request->operations,
            'allergies' => $request->allergies,
        ]);

        return back()->with('success', 'Medical information updated successfully!');
    }

    /**
     * Update only emergency contact information
     */
    public function updateEmergencyContact(Request $request)
    {
        $request->validate([
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:255',
            'emergency_relationship' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $patients = Patients::where('user_id', $user->id)->first();
        
        if (!$patients) {
            return redirect()->route('patients.profile.create')
                ->with('error', 'Patient profile not found.');
        }

        $patients->update([
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'emergency_relationship' => $request->emergency_relationship,
        ]);

        return back()->with('success', 'Emergency contact updated successfully!');
    }
}
