<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the incoming request data
         $request->validate([
            'patient_id' => 'required|exists:patients,patient_id', // Ensure the patient ID exists in the patients table
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
            'status' => $request->status = Appointment::STATUS_PENDING,
        ]);

        // Redirect back to appointments index with a success message
        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);
        //
        return view('appointments.edit', compact('appointment'));
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
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
        $appointment->delete();

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment deleted successfully.');
    }
}
