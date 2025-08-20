<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\Appointment;
use App\Models\Doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientsAppointmentScheduler extends Controller
{
    /**
     * Show form to schedule doctor appointment
     */
    public function scheduleAppointment()
    {
        $doctors = Doctors::with('user')->get();
        return view('patients.schedule-appointment', compact('doctors'));
    }

    /**
     * Store new appointment
     */
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'reason' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        $patient = Patients::where('user_id', $user->id)->first();

        if (!$patient) {
            return redirect()->route('patients.profile.create')
                ->with('error', 'Please complete your patient profile first.');
        }

        // Check if appointment slot is available
        $existingAppointment = Appointment::where('doc_id', $request->doctor_id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', Appointment::STATUS_CANCELLED)
            ->first();

        if ($existingAppointment) {
            return back()->with('error', 'This time slot is already booked. Please choose another time.');
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doc_id' => $request->doctor_id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => Appointment::STATUS_PENDING,
            'reason' => $request->reason
        ]);

        return redirect()->route('patients.appointments')
            ->with('success', 'Appointment scheduled successfully! You will receive confirmation soon.');
    }

    /**
     * Display patient's appointments
     */
    public function appointments()
    {
        $user = Auth::user();
        $patient = Patients::where('user_id', $user->id)->first();

        if (!$patient) {
            return redirect()->route('patients.profile.create');
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->orderBy('date', 'desc')
            ->get();

        return view('patients.appointments', compact('appointments'));
    }

    /**
     * Cancel an appointment
     */
    public function cancelAppointment(Request $request, $appointmentId)
    {
        $user = Auth::user();
        $patient = Patients::where('user_id', $user->id)->first();

        if (!$patient) {
            return redirect()->route('patients.profile.create');
        }

        $appointment = Appointment::where('id', $appointmentId)
            ->where('patient_id', $patient->id)
            ->first();

        if (!$appointment) {
            return back()->with('error', 'Appointment not found.');
        }

        if ($appointment->status === Appointment::STATUS_CANCELLED) {
            return back()->with('error', 'Cannot cancel already cancelled appointments.');
        }

        $appointment->update(['status' => Appointment::STATUS_CANCELLED]);

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}
