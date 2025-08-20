<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\Appointment;
use App\Models\HealthRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientsController extends Controller
{
    /**
     * Display patient dashboard with appointments and health records
     */
    public function index()
    {
        $user = Auth::user();
        $patient = Patients::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return redirect()->route('patients.profile.create')
                ->with('info', 'Please complete your patient profile first.');
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $healthRecords = HealthRecords::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('patients.dashboard', compact('patient', 'appointments', 'healthRecords'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Patients $patients)
    {
        return view('patients.show', compact('patients'));
    }
}
