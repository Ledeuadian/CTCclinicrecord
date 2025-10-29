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
use App\Models\Medicine;
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
        $immunizations = ImmunizationRecords::where('patient_id', $patient->id)->get();
        $physicalExams = PhysicalExamination::where('patient_id', $patient->id)
            ->with(['patient.user', 'doctor'])
            ->get();
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

        // Get all medicines with pagination
        $medicines = Medicine::orderBy('name', 'asc')->paginate(15);

        // Get statistics
        $totalMedicines = Medicine::count();
        $availableMedicines = Medicine::where('quantity', '>=', 10)
            ->where(function($query) {
                $query->whereNull('expiration_date')
                      ->orWhere('expiration_date', '>', now());
            })
            ->count();
        $lowStockMedicines = Medicine::where('quantity', '<', 10)->count();
        $expiredMedicines = Medicine::whereNotNull('expiration_date')
            ->where('expiration_date', '<', now())
            ->count();

        return view('doctor.medicines', compact(
            'medicines',
            'doctor',
            'totalMedicines',
            'availableMedicines',
            'lowStockMedicines',
            'expiredMedicines'
        ));
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
        $immunizationRecords = ImmunizationRecords::whereHas('patient.appointments', function($query) use ($doctor) {
            $query->where('doc_id', $doctor->id);
        })
        ->with(['patient.user'])
        ->orderBy('created_at', 'desc')
        ->paginate(10, ['*'], 'immunization_page');

        // Get summary statistics
        $totalHealthRecords = $healthRecords->total();
        $totalPhysicalExams = PhysicalExamination::where('doctor_id', $doctor->id)->count();
        $totalDentalExams = DentalExamination::where('doctor_id', $doctor->id)->count();
        $totalImmunizations = ImmunizationRecords::whereHas('patient.appointments', function($query) use ($doctor) {
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

        // Get the patient's user_id
        $patient = Patients::findOrFail($request->patient_id);

        PhysicalExamination::create([
            'patient_id' => $patient->id,
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

    /**
     * Edit Health Record
     */
    public function editHealthRecord($id)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }

        $record = HealthRecords::findOrFail($id);

        // Verify this record belongs to a patient the doctor has treated
        $hasAccess = Appointment::where('doc_id', $doctor->id)
            ->where('patient_id', $record->patient_id)
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'You do not have access to edit this record.');
        }

        return view('doctor.edit-health-record', compact('record', 'doctor'));
    }

    /**
     * Update Health Record
     */
    public function updateHealthRecord(Request $request, $id)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        $record = HealthRecords::findOrFail($id);

        $request->validate([
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $record->update([
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'symptoms' => $request->symptoms,
            'notes' => $request->notes,
        ]);

        return redirect()->route('doctor.health-records')
            ->with('success', 'Health record updated successfully.');
    }

    /**
     * Edit Physical Examination
     */
    public function editPhysicalExam($id)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }

        $exam = PhysicalExamination::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        return view('doctor.edit-physical-exam', compact('exam', 'doctor'));
    }

    /**
     * Update Physical Examination
     */
    public function updatePhysicalExam(Request $request, $id)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        $exam = PhysicalExamination::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

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

        $exam->update($request->only([
            'height', 'weight', 'bp', 'heart', 'lungs',
            'eyes', 'ears', 'nose', 'throat', 'skin', 'remarks'
        ]));

        return redirect()->route('doctor.health-records')
            ->with('success', 'Physical examination updated successfully.');
    }

    /**
     * Edit Dental Examination
     */
    public function editDentalExam($id)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }

        $exam = DentalExamination::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        return view('doctor.edit-dental-exam', compact('exam', 'doctor'));
    }

    /**
     * Update Dental Examination
     */
    public function updateDentalExam(Request $request, $id)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        $exam = DentalExamination::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        $request->validate([
            'diagnosis' => 'nullable|string',
            'teeth_status' => 'nullable|array',
        ]);

        $exam->update([
            'diagnosis' => $request->diagnosis,
            'teeth_status' => $request->teeth_status,
        ]);

        return redirect()->route('doctor.health-records')
            ->with('success', 'Dental examination updated successfully.');
    }

    /**
     * Edit Immunization Record
     */
    public function editImmunization($id)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }

        $record = ImmunizationRecords::findOrFail($id);

        // Verify access
        $hasAccess = Appointment::where('doc_id', $doctor->id)
            ->whereHas('patient', function($q) use ($record) {
                $q->where('id', $record->patient_id);
            })
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'You do not have access to edit this record.');
        }

        return view('doctor.edit-immunization', compact('record', 'doctor'));
    }

    /**
     * Update Immunization Record
     */
    public function updateImmunization(Request $request, $id)
    {
        $record = ImmunizationRecords::findOrFail($id);

        $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'vaccine_type' => 'nullable|string|max:255',
            'administered_by' => 'nullable|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'site_of_administration' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $record->update($request->only([
            'vaccine_name', 'vaccine_type', 'administered_by',
            'dosage', 'site_of_administration', 'expiration_date', 'notes'
        ]));

        return redirect()->route('doctor.health-records')
            ->with('success', 'Immunization record updated successfully.');
    }

    /**
     * Edit Prescription Record
     */
    public function editPrescription($id)
    {
        $doctor = Doctors::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }

        $prescription = PrescriptionRecord::findOrFail($id);

        // Verify access
        $hasAccess = Appointment::where('doc_id', $doctor->id)
            ->where('patient_id', $prescription->patient_id)
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'You do not have access to edit this record.');
        }

        $medicines = Medicine::all();

        return view('doctor.edit-prescription', compact('prescription', 'doctor', 'medicines'));
    }

    /**
     * Update Prescription Record
     */
    public function updatePrescription(Request $request, $id)
    {
        $prescription = PrescriptionRecord::findOrFail($id);

        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'dosage' => 'required|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'date_prescribed' => 'required|date',
        ]);

        $prescription->update($request->only([
            'medicine_id', 'dosage', 'frequency', 'duration',
            'instructions', 'date_prescribed'
        ]));

        return redirect()->route('doctor.health-records')
            ->with('success', 'Prescription updated successfully.');
    }

    /**
     * Store a new medicine
     */
    public function storeMedicine(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'medicine_type' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'expiration_date' => 'nullable|date',
        ]);

        Medicine::create($request->only([
            'name', 'medicine_type', 'description', 'quantity', 'expiration_date'
        ]));

        return redirect()->route('doctor.health-records')
            ->with('success', 'Medicine added successfully.');
    }

    /**
     * Update an existing medicine
     */
    public function updateMedicine(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'medicine_type' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'expiration_date' => 'nullable|date',
        ]);

        $medicine->update($request->only([
            'name', 'medicine_type', 'description', 'quantity', 'expiration_date'
        ]));

        return redirect()->route('doctor.health-records')
            ->with('success', 'Medicine updated successfully.');
    }

    /**
     * Display prescriptions page
     */
    public function prescriptions(Request $request)
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('doctor.dashboard')->with('error', 'Doctor profile not found.');
        }

        // Build query for prescriptions
        $query = PrescriptionRecord::where('doctor_id', $doctor->id)
            ->with(['patient.user', 'medicine']);

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhere('patient_id', 'like', '%' . $search . '%');
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Get prescriptions
        $prescriptions = $query->orderBy('date_prescribed', 'desc')->paginate(15);

        // Get statistics
        $totalPrescriptions = PrescriptionRecord::where('doctor_id', $doctor->id)->count();
        $activePrescriptions = PrescriptionRecord::where('doctor_id', $doctor->id)->where('status', 'active')->count();
        $completedPrescriptions = PrescriptionRecord::where('doctor_id', $doctor->id)->where('status', 'completed')->count();
        $discontinuedPrescriptions = PrescriptionRecord::where('doctor_id', $doctor->id)->where('status', 'discontinued')->count();

        // Get patients for dropdown
        $patients = Patients::whereHas('appointments', function($query) use ($doctor) {
            $query->where('doc_id', $doctor->id);
        })->with('user')->get();

        // Get medicines for dropdown
        $medicines = Medicine::orderBy('name', 'asc')->get();

        return view('doctor.prescriptions', compact(
            'doctor',
            'prescriptions',
            'totalPrescriptions',
            'activePrescriptions',
            'completedPrescriptions',
            'discontinuedPrescriptions',
            'patients',
            'medicines'
        ));
    }

    /**
     * Store a new prescription
     */
    public function storePrescription(Request $request)
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->route('doctor.dashboard')->with('error', 'Doctor profile not found.');
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medicine_id' => 'required|exists:medicine,id',
            'dosage' => 'required|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'instruction' => 'nullable|string',
            'date_prescribed' => 'required|date',
        ]);

        PrescriptionRecord::create([
            'patient_id' => $request->patient_id,
            'medicine_id' => $request->medicine_id,
            'doctor_id' => $doctor->id,
            'dosage' => $request->dosage,
            'frequency' => $request->frequency,
            'duration' => $request->duration,
            'instruction' => $request->instruction,
            'date_prescribed' => $request->date_prescribed,
            'status' => 'active',
        ]);

        return redirect()->route('doctor.prescriptions')
            ->with('success', 'Prescription created successfully.');
    }

    /**
     * Update an existing prescription
     */
    public function updatePrescriptionRecord(Request $request, $id)
    {
        $prescription = PrescriptionRecord::findOrFail($id);

        // Verify doctor owns this prescription
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if ($prescription->doctor_id != $doctor->id) {
            return redirect()->route('doctor.prescriptions')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'dosage' => 'required|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'instruction' => 'nullable|string',
        ]);

        $prescription->update($request->only([
            'dosage', 'frequency', 'duration', 'instruction'
        ]));

        return redirect()->route('doctor.prescriptions')
            ->with('success', 'Prescription updated successfully.');
    }

    /**
     * Discontinue a prescription
     */
    public function discontinuePrescription(Request $request, $id)
    {
        $prescription = PrescriptionRecord::findOrFail($id);

        // Verify doctor owns this prescription
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if ($prescription->doctor_id != $doctor->id) {
            return redirect()->route('doctor.prescriptions')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'discontinuation_reason' => 'required|string',
        ]);

        $prescription->update([
            'status' => 'discontinued',
            'date_discontinued' => now(),
            'discontinuation_reason' => $request->discontinuation_reason,
        ]);

        return redirect()->route('doctor.prescriptions')
            ->with('success', 'Prescription discontinued successfully.');
    }

    /**
     * Get prescription history for a patient
     */
    public function prescriptionHistory($patientId)
    {
        $user = Auth::user();
        $doctor = Doctors::where('user_id', $user->id)->first();

        if (!$doctor) {
            return response()->json(['error' => 'Doctor profile not found.'], 404);
        }

        $prescriptions = PrescriptionRecord::where('patient_id', $patientId)
            ->where('doctor_id', $doctor->id)
            ->with('medicine')
            ->orderBy('date_prescribed', 'desc')
            ->get();

        return response()->json($prescriptions);
    }
}
