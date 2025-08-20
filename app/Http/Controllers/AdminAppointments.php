<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminAppointments extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $appointments = Appointment::all();
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Get patients with their user information, excluding doctors (user_type = 3)
        $patients = \App\Models\Patients::join('users', 'users.id', '=', 'patients.user_id')
            ->whereIn('users.user_type', [1, 2]) // Only students and staff
            ->select('patients.id', 'users.name', 'patients.patient_type')
            ->get();
        
        // Get doctors with their user information
        $doctors = \App\Models\Doctors::join('users', 'users.id', '=', 'doctors.user_id')
            ->select('doctors.id', 'users.name', 'doctors.specialization')
            ->get();
        
        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'patient_id' => 'required', // Ensure the patient ID exists in the patients table
            'date' => 'required|date',
            'time' => 'required|date_format:H:i', // Time should be in HH:MM format
            'doc_id' => 'required', // Ensure the doctor ID exists in the doctors table
        ]);
        // Create a new appointment
        Appointment::create([
            'patient_id' => $request->patient_id,
            'date' => $request->date,
            'time' => $request->time,
            'doc_id' => $request->doc_id,
            'status' => Appointment::STATUS_PENDING,
        ]);

        // Redirect back to appointments index with a success message
        return redirect()->route('admin.appointments.create')->with('success', 'Appointment created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);
        
        // Get patients with their user information, excluding doctors (user_type = 3)
        $patients = \App\Models\Patients::join('users', 'users.id', '=', 'patients.user_id')
            ->whereIn('users.user_type', [1, 2]) // Only students and staff
            ->select('patients.id', 'users.name', 'patients.patient_type')
            ->get();
        
        // Get doctors with their user information
        $doctors = \App\Models\Doctors::join('users', 'users.id', '=', 'doctors.user_id')
            ->select('doctors.id', 'users.name', 'doctors.specialization')
            ->get();
        
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'patient_id' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'doc_id' => 'required',
            'status' => 'required',
        ]);

        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Update the appointment details
        $appointment->patient_id = $request->input('patient_id');
        $appointment->date = $request->input('date');
        $appointment->time = $request->input('time');
        $appointment->doc_id = $request->input('doc_id');
        $appointment->status = $request->input('status');

        // Save the updated appointment
        $appointment->save();

        // Redirect back with a success message
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment deleted successfully.');
    }
}
