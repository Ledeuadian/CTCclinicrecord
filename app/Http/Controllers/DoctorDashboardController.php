<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\Appointment;
use App\Models\Doctors;
use App\Models\HealthRecords;
use App\Models\PrescriptionRecord;
use App\Models\ImmunizationRecords;
use App\Models\PhysicalExamination;
use App\Models\DentalExamination;
use App\Models\Immunization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DoctorDashboardController extends Controller
{
    /**
     * Display doctor dashboard with statistics and recent activities
     */
    public function index()
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('dashboard')->with('error', 'Doctor profile not found.');
        }

        // Get statistics
        $todayAppointments = Appointment::where('doc_id', $doctor->id)
            ->whereDate('date', Carbon::today())
            ->count();

        $weeklyAppointments = Appointment::where('doc_id', $doctor->id)
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $totalPatients = Appointment::where('doc_id', $doctor->id)
            ->distinct('patient_id')
            ->count();

        $pendingAppointments = Appointment::where('doc_id', $doctor->id)
            ->where('status', Appointment::STATUS_PENDING)
            ->count();

        // Recent appointments
        $recentAppointments = Appointment::where('doc_id', $doctor->id)
            ->with(['patient.user'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->take(5)
            ->get();

        // Monthly appointment statistics
        $monthlyStats = Appointment::where('doc_id', $doctor->id)
            ->selectRaw('strftime("%m", date) as month, COUNT(*) as count')
            ->whereYear('date', Carbon::now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('doctor.dashboard', compact(
            'doctor',
            'todayAppointments',
            'weeklyAppointments',
            'totalPatients',
            'pendingAppointments',
            'recentAppointments',
            'monthlyStats'
        ));
    }

    /**
     * Display appointment management for doctors
     */
    public function appointments()
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('dashboard')->with('error', 'Doctor profile not found.');
        }

        // Get pending appointments
        $pendingAppointments = Appointment::where('doc_id', $doctor->id)
            ->where('status', Appointment::STATUS_PENDING)
            ->with(['patient.user'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // Get all active appointments for calendar (confirmed and pending)
        $calendarAppointments = Appointment::where('doc_id', $doctor->id)
            ->whereIn('status', [Appointment::STATUS_PENDING, Appointment::STATUS_CONFIRMED])
            ->with(['patient.user'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // Prepare calendar data - group appointments by date
        $calendarData = [];
        foreach ($calendarAppointments as $appointment) {
            $date = Carbon::parse($appointment->date)->format('Y-m-d');
            if (!isset($calendarData[$date])) {
                $calendarData[$date] = [];
            }
            $calendarData[$date][] = [
                'id' => $appointment->id,
                'patient_name' => $appointment->patient->user->name ?? 'N/A',
                'time' => Carbon::parse($appointment->time)->format('g:i A'),
                'status' => $appointment->status,
                'patient_id' => $appointment->patient_id
            ];
        }

        // Get current month and year for calendar display
        $currentMonth = Carbon::now()->format('Y-m');
        $currentDate = Carbon::now();

        // Get all appointments for the table view
        $appointments = Appointment::where('doc_id', $doctor->id)
            ->with(['patient.user'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(15);

        return view('doctor.appointments', compact(
            'appointments',
            'doctor',
            'pendingAppointments',
            'calendarAppointments',
            'calendarData',
            'currentMonth',
            'currentDate'
        ));
    }

    /**
     * Update appointment status
     */
    public function updateAppointmentStatus(Request $request, $appointmentId)
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return back()->with('error', 'Unauthorized action.');
        }

        $appointment = Appointment::where('id', $appointmentId)
            ->where('doc_id', $doctor->id)
            ->first();

        if (!$appointment) {
            return back()->with('error', 'Appointment not found.');
        }

        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled'
        ]);

        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment status updated successfully.');
    }

    /**
     * Display doctor's patients
     */
    public function patients()
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('dashboard')->with('error', 'Doctor profile not found.');
        }

        // Get patients who have appointments with this doctor
        $patients = Patients::whereHas('appointments', function($query) use ($doctor) {
                $query->where('doc_id', $doctor->id);
            })
            ->with(['user', 'appointments' => function($query) use ($doctor) {
                $query->where('doc_id', $doctor->id)->latest();
            }])
            ->paginate(15);

        return view('doctor.patients', compact('patients', 'doctor'));
    }

    /**
     * View individual patient record
     */
    public function viewPatient($patientId)
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('dashboard')->with('error', 'Doctor profile not found.');
        }

        $patient = Patients::with('user')->findOrFail($patientId);

        // Verify doctor has treated this patient
        $hasAppointment = Appointment::where('doc_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->exists();

        if (!$hasAppointment) {
            return back()->with('error', 'You can only view patients you have treated.');
        }

        // Get patient's medical records
        $healthRecords = HealthRecords::where('user_id', $patient->user_id)->get();
        $prescriptions = PrescriptionRecord::where('patient_id', $patient->id)
            ->with('medicine')
            ->get();
        $immunizations = ImmunizationRecords::where('patient_id', $patient->id)
            ->with('immunization')
            ->get();
        $physicalExams = PhysicalExamination::where('patient_id', $patient->id)->get();
        $dentalExams = DentalExamination::where('patient_id', $patient->id)->get();

        $appointments = Appointment::where('doc_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('doctor.patient-details', compact(
            'patient',
            'doctor',
            'healthRecords',
            'prescriptions',
            'immunizations',
            'physicalExams',
            'dentalExams',
            'appointments'
        ));
    }

    /**
     * Display medication management
     */
    public function medications()
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('doctor.dashboard')->with('error', 'Doctor profile not found.');
        }

        // Get prescriptions for patients who have appointments with this doctor
        $prescriptions = PrescriptionRecord::whereHas('patient.appointments', function($query) use ($doctor) {
                $query->where('doc_id', $doctor->id);
            })
            ->with(['patient.user', 'medicine'])
            ->orderBy('date_prescribed', 'desc')
            ->paginate(15);

        return view('doctor.medications', compact('prescriptions', 'doctor'));
    }

    /**
     * Display reports and statistics for doctor
     */
    public function reports()
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('dashboard')->with('error', 'Doctor profile not found.');
        }

        // Generate various statistics
        $appointmentStats = [
            'total' => Appointment::where('doc_id', $doctor->id)->count(),
            'this_month' => Appointment::where('doc_id', $doctor->id)
                ->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->count(),
            'pending' => Appointment::where('doc_id', $doctor->id)
                ->where('status', 'Pending')
                ->count(),
            'completed' => Appointment::where('doc_id', $doctor->id)
                ->where('status', 'Completed')
                ->count(),
        ];

        $patientStats = [
            'total_patients' => Appointment::where('doc_id', $doctor->id)
                ->distinct('patient_id')
                ->count(),
            'new_this_month' => Appointment::where('doc_id', $doctor->id)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->distinct('patient_id')
                ->count(),
        ];

        // Monthly appointment trends
        $monthlyTrends = Appointment::where('doc_id', $doctor->id)
            ->selectRaw('strftime("%m", date) as month, strftime("%Y", date) as year, COUNT(*) as count')
            ->whereYear('date', '>=', Carbon::now()->subYear()->year)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Top diagnoses/conditions
        $topConditions = HealthRecords::whereHas('patient.appointments', function($query) use ($doctor) {
                $query->where('doc_id', $doctor->id);
            })
            ->selectRaw('diagnosis, COUNT(*) as count')
            ->whereNotNull('diagnosis')
            ->groupBy('diagnosis')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        return view('doctor.reports', compact(
            'doctor',
            'appointmentStats',
            'patientStats',
            'monthlyTrends',
            'topConditions'
        ));
    }

    public function healthRecords()
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Get all health records for patients who have appointments with this doctor
        $healthRecords = HealthRecords::whereHas('patient.appointments', function($query) use ($doctor) {
            $query->where('doc_id', $doctor->id);
        })
        ->whereNotNull('patient_id')
        ->with(['patient' => function($query) {
            $query->whereNotNull('user_id')->with('user');
        }, 'patient.appointments' => function($query) use ($doctor) {
            $query->where('doc_id', $doctor->id)->latest();
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Get physical examinations
        $physicalExaminations = PhysicalExamination::where('doctor_id', $doctor->id)
            ->with(['patient.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'physical_page');

        // Get dental examinations
        $dentalExaminations = DentalExamination::where('doctor_id', $doctor->id)
            ->with(['patient.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'dental_page');

        // Get immunization records for patients treated by this doctor
        $immunizationRecords = ImmunizationRecords::whereHas('Patients.appointments', function($query) use ($doctor) {
            $query->where('doc_id', $doctor->id);
        })
        ->with(['Patients.user'])
        ->orderBy('created_at', 'desc')
        ->paginate(10, ['*'], 'immunization_page');

        // Get summary statistics
        $totalHealthRecords = $healthRecords->total();
        $totalPhysicalExams = PhysicalExamination::where('doctor_id', $doctor->id)->count();
        $totalDentalExams = DentalExamination::where('doctor_id', $doctor->id)->count();
        $totalImmunizations = ImmunizationRecords::whereHas('Patients.appointments', function($query) use ($doctor) {
            $query->where('doc_id', $doctor->id);
        })->count();

        $recentRecords = $totalHealthRecords + $totalPhysicalExams + $totalDentalExams + $totalImmunizations;

        // Get records by diagnosis for this doctor's patients
        $diagnosisStats = HealthRecords::whereHas('patient.appointments', function($query) use ($doctor) {
            $query->where('doc_id', $doctor->id);
        })
        ->whereNotNull('diagnosis')
        ->selectRaw('diagnosis, COUNT(*) as count')
        ->groupBy('diagnosis')
        ->orderBy('count', 'desc')
        ->limit(10)
        ->get();

        return view('doctor.health-records', compact(
            'doctor',
            'healthRecords',
            'physicalExaminations',
            'dentalExaminations',
            'immunizationRecords',
            'totalHealthRecords',
            'totalPhysicalExams',
            'totalDentalExams',
            'totalImmunizations',
            'recentRecords',
            'diagnosisStats'
        ));
    }

    /**
     * Show form for creating a new health record
     */
    public function createHealthRecord()
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        // Get patients who have appointments with this doctor
        $patients = Patients::whereHas('appointments', function($query) use ($doctor) {
            $query->where('doc_id', $doctor->id);
        })
        ->with('user')
        ->orderBy('id', 'desc')
        ->get();

        // Get available immunizations for dropdown
        $immunizations = Immunization::orderBy('name')->get();

        return view('doctor.health-records.create', compact('doctor', 'patients', 'immunizations'));
    }

    /**
     * Store a new health record
     */
    public function storeHealthRecord(Request $request)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found. Please contact administrator.');
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'record_type' => 'required|in:physical,dental,immunization',
        ]);

        // Verify doctor has access to this patient
        $hasAppointment = Appointment::where('doc_id', $doctor->id)
            ->where('patient_id', $request->patient_id)
            ->exists();

        if (!$hasAppointment) {
            return back()->with('error', 'You can only create records for patients you have treated.');
        }

        try {
            switch ($request->record_type) {
                case 'physical':
                    $this->createPhysicalExamination($request, $doctor);
                    break;
                case 'dental':
                    $this->createDentalExamination($request, $doctor);
                    break;
                case 'immunization':
                    $this->createImmunizationRecord($request, $doctor);
                    break;
            }

            return redirect()->route('doctor.health-records')
                ->with('success', 'Health record created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating health record: ' . $e->getMessage());
        }
    }

    /**
     * Create Physical Examination Record
     */
    private function createPhysicalExamination(Request $request, $doctor)
    {
        $request->validate([
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'bp' => 'nullable|string|max:20',
            'heart' => 'nullable|string|max:255',
            'lungs' => 'nullable|string|max:255',
            'eyes' => 'nullable|string|max:255',
            'ears' => 'nullable|string|max:255',
            'nose' => 'nullable|string|max:255',
            'throat' => 'nullable|string|max:255',
            'skin' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        PhysicalExamination::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor->id,
            'height' => $request->height,
            'weight' => $request->weight,
            'bp' => $request->bp,
            'heart' => $request->heart,
            'lungs' => $request->lungs,
            'eyes' => $request->eyes,
            'ears' => $request->ears,
            'nose' => $request->nose,
            'throat' => $request->throat,
            'skin' => $request->skin,
            'remarks' => $request->remarks,
        ]);
    }

    /**
     * Create Dental Examination Record
     */
    private function createDentalExamination(Request $request, $doctor)
    {
        $request->validate([
            'diagnosis' => 'nullable|string',
            'teeth_status' => 'nullable|array',
        ]);

        DentalExamination::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor->id,
            'diagnosis' => $request->diagnosis,
            'teeth_status' => $request->teeth_status ?? [],
        ]);
    }

    /**
     * Create Immunization Record
     */
    private function createImmunizationRecord(Request $request, $doctor)
    {
        $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'vaccine_type' => 'nullable|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'site_of_administration' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        ImmunizationRecords::create([
            'patient_id' => $request->patient_id,
            'vaccine_name' => $request->vaccine_name,
            'vaccine_type' => $request->vaccine_type,
            'administered_by' => $doctor->name,
            'dosage' => $request->dosage,
            'site_of_administration' => $request->site_of_administration,
            'expiration_date' => $request->expiration_date,
            'notes' => $request->notes,
        ]);
    }
}
