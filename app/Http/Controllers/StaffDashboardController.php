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
use App\Models\GeneratedReport;
use App\Models\CertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffDashboardController extends Controller
{
    /**
     * Display staff dashboard with statistics and recent activities
     * Staff has access to all doctor functionalities for managing patients
     */
    public function index()
    {
        $user = Auth::user();

        // Get statistics (aggregate all doctors' data for staff overview)
        $todayAppointments = Appointment::whereDate('date', Carbon::today())->count();

        $weeklyAppointments = Appointment::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $totalPatients = Patients::whereHas('user', function($query) {
            $query->whereIn('user_type', [1, 2]); // Students and Staff
        })->count();

        $pendingAppointments = Appointment::where('status', Appointment::STATUS_PENDING)->count();

        // Recent appointments
        $recentAppointments = Appointment::with(['patient.user', 'doctor'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->take(5)
            ->get();

        // Monthly appointment statistics - show all 12 months
        $monthlyStats = Appointment::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->whereYear('date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        // Fill in missing months with 0
        $allMonths = collect(range(1, 12))->mapWithKeys(function($m) {
            return [$m => 0];
        });
        $monthlyStats = $allMonths->merge($monthlyStats);

        return view('staff.dashboard', compact(
            'todayAppointments',
            'weeklyAppointments',
            'totalPatients',
            'pendingAppointments',
            'recentAppointments',
            'monthlyStats'
        ));
    }

    // AJAX Tab Methods for Shell Navigation
    public function ajaxDashboard()
    {
        return $this->index();
    }

    public function ajaxAppointments()
    {
        return $this->appointments(request());
    }

    public function ajaxPatients()
    {
        return $this->patients(request());
    }

    public function ajaxHealthRecords()
    {
        return $this->healthRecords(request());
    }

    public function ajaxMedicines()
    {
        return $this->medications(request());
    }

    public function ajaxPrescriptions()
    {
        return $this->prescriptions(request());
    }

    public function ajaxReports()
    {
        return $this->reports(request());
    }

    /**
     * Display appointments page
     */
    public function appointments(Request $request)
    {
        $query = Appointment::with(['patient.user', 'doctor'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $appointments = $query->paginate(15);
        $doctors = Doctors::with('user')->get();

        // Get pending appointments for the pending section
        $pendingAppointments = Appointment::with(['patient.user', 'doctor'])
            ->where('status', Appointment::STATUS_PENDING)
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // Get confirmed appointments for today
        $todayAppointments = Appointment::with(['patient.user', 'doctor'])
            ->where('status', Appointment::STATUS_CONFIRMED)
            ->whereDate('date', Carbon::today())
            ->orderBy('time', 'asc')
            ->get();

        // Calendar data for current month
        $calendarData = [];
        $currentMonthAppointments = Appointment::with(['patient.user', 'doctor'])
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->get();

        foreach ($currentMonthAppointments as $apt) {
            $dateKey = Carbon::parse($apt->date)->format('Y-m-d');
            if (!isset($calendarData[$dateKey])) {
                $calendarData[$dateKey] = [];
            }
            $calendarData[$dateKey][] = [
                'id' => $apt->id,
                'patient_name' => $apt->patient->user->name ?? 'N/A',
                'doctor_name' => $apt->doctor->user->name ?? 'N/A',
                'time' => Carbon::parse($apt->time)->format('h:i A'),
                'status' => $apt->status,
            ];
        }

        return view('staff.appointments', compact('appointments', 'doctors', 'pendingAppointments', 'todayAppointments', 'calendarData'));
    }

    /**
     * Update appointment status
     */
    public function updateAppointmentStatus(Request $request, $appointmentId)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', [
                Appointment::STATUS_PENDING,
                Appointment::STATUS_CONFIRMED,
                Appointment::STATUS_CANCELLED,
                'Completed'
            ])
        ]);

        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = $request->status;
        $appointment->save();

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated successfully'
        ]);
    }

    /**
     * Display patients list
     */
    public function patients(Request $request)
    {
        $query = Patients::with(['user', 'educationalLevel'])
            ->whereHas('user', function($q) {
                $q->whereIn('user_type', [1, 2]); // Students and Staff only
            });

        // Search functionality - search in user name, email, and patient data
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhere('school_id', 'like', "%{$search}%");
            });
        }

        // Filter by patient type
        if ($request->filled('patient_type')) {
            $query->where('patient_type', $request->patient_type);
        }

        $patients = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('staff.patients', compact('patients'));
    }

    /**
     * View individual patient details
     */
    public function viewPatient($patientId)
    {
        $patient = Patients::with(['user', 'educationalLevel'])->findOrFail($patientId);

        // Get health records
        $healthRecords = HealthRecords::where('patient_id', $patientId)
            ->with(['physicalExamination', 'dentalExamination', 'immunizationRecords'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get appointments
        $appointments = Appointment::where('patient_id', $patientId)
            ->with('doctor.user')
            ->orderBy('date', 'desc')
            ->get();

        // Get prescriptions
        $prescriptions = PrescriptionRecord::where('patient_id', $patientId)
            ->with(['medicine', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.patient-details', compact('patient', 'healthRecords', 'appointments', 'prescriptions'));
    }

    /**
     * Update patient information
     */
    public function updatePatient(Request $request, $patientId)
    {
        $patient = Patients::findOrFail($patientId);

        $request->validate([
            'bloodtype' => 'nullable|string|max:10',
        ]);

        $patient->update([
            'bloodtype' => $request->bloodtype,
        ]);

        return back()->with('success', 'Patient information updated successfully.');
    }

    /**
     * Display health records page
     */
    public function healthRecords(Request $request)
    {
        // Load only existing relationships: patient.user
        $query = HealthRecords::with(['patient.user']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('f_name', 'like', "%{$search}%")
                  ->orWhere('m_name', 'like', "%{$search}%")
                  ->orWhere('l_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        $healthRecords = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $totalHealthRecords = HealthRecords::count();
        $totalPhysicalExams = PhysicalExamination::count();
        $totalDentalExams = DentalExamination::count();
        $totalImmunizations = ImmunizationRecords::count();

        // Top diagnoses - ensure diagnosis is a valid string before counting
        $diagnosisStats = HealthRecords::select('diagnosis', \DB::raw('count(*) as count'))
            ->whereNotNull('diagnosis')
            ->where('diagnosis', '!=', '')
            ->whereRaw('LENGTH(diagnosis) > 0')
            ->groupBy('diagnosis')
            ->orderBy('count', 'desc')
            ->get();

        // Get paginated examination records for tabs
        $physicalExaminations = PhysicalExamination::with(['patient.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $dentalExaminations = DentalExamination::with(['patient.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $immunizationRecords = ImmunizationRecords::with(['patient.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('staff.health-records', compact('healthRecords', 'totalHealthRecords', 'totalPhysicalExams', 'totalDentalExams', 'totalImmunizations', 'diagnosisStats', 'physicalExaminations', 'dentalExaminations', 'immunizationRecords'));
    }

    /**
     * Display medicines page
     */
    public function medications(Request $request)
    {
        $query = Medicine::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%")
                  ->orWhere('manufacturer', 'like', "%{$search}%");
            });
        }

        // Filter by availability
        if ($request->filled('availability')) {
            if ($request->availability === 'in_stock') {
                $query->where('quantity', '>', 0);
            } elseif ($request->availability === 'out_of_stock') {
                $query->where('quantity', '<=', 0);
            } elseif ($request->availability === 'low_stock') {
                $query->where('quantity', '>', 0)
                      ->where('quantity', '<=', 10);
            }
        }

        $medicines = $query->orderBy('name')->paginate(15);

        // Statistics
        $totalMedicines = Medicine::count();
        $availableMedicines = Medicine::where('quantity', '>', 0)->count();
        $lowStockMedicines = Medicine::where('quantity', '>', 0)->where('quantity', '<=', 10)->count();
        $expiredMedicines = Medicine::where('expiration_date', '<', Carbon::now())->count();

        return view('staff.medicines', compact('medicines', 'totalMedicines', 'availableMedicines', 'lowStockMedicines', 'expiredMedicines'));
    }

    /**
     * Store new medicine
     */
    public function storeMedicine(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'dosage' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'expiration_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Medicine::create($request->all());

        return redirect()->back()->with('success', 'Medicine added successfully');
    }

    /**
     * Update medicine
     */
    public function updateMedicine(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'dosage' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'expiration_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $medicine = Medicine::findOrFail($id);
        $medicine->update($request->all());

        return redirect()->back()->with('success', 'Medicine updated successfully');
    }

    /**
     * Display prescriptions page
     */
    public function prescriptions(Request $request)
    {
        $query = PrescriptionRecord::with(['patient.user', 'medicine', 'doctor']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('f_name', 'like', "%{$search}%")
                  ->orWhere('m_name', 'like', "%{$search}%")
                  ->orWhere('l_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $prescriptions = $query->orderBy('created_at', 'desc')->paginate(15);
        $patients = Patients::with('user')->whereHas('user', function($q) {
            $q->whereIn('user_type', [1, 2]);
        })->get();
        $medicines = Medicine::where('quantity', '>', 0)->get();

        // Statistics
        $totalPrescriptions = PrescriptionRecord::count();
        $activePrescriptions = PrescriptionRecord::where('status', 'active')->count();
        $completedPrescriptions = PrescriptionRecord::where('status', 'completed')->count();
        $discontinuedPrescriptions = PrescriptionRecord::where('status', 'discontinued')->count();

        return view('staff.prescriptions', compact('prescriptions', 'patients', 'medicines', 'totalPrescriptions', 'activePrescriptions', 'completedPrescriptions', 'discontinuedPrescriptions'));
    }

    /**
     * Store new prescription
     */
    public function storePrescription(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medicine_id' => 'required|exists:medicine,id',
            'dosage' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'status' => 'required|in:active,completed,discontinued',
        ]);

        $prescription = new PrescriptionRecord($request->all());
        $prescription->prescribed_by = Auth::id();
        $prescription->save();

        return response()->json([
            'success' => true,
            'message' => 'Prescription created successfully'
        ]);
    }

    /**
     * Update prescription
     */
    public function updatePrescriptionRecord(Request $request, $id)
    {
        $request->validate([
            'dosage' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'status' => 'required|in:active,completed,discontinued',
        ]);

        $prescription = PrescriptionRecord::findOrFail($id);
        $prescription->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Prescription updated successfully'
        ]);
    }

    /**
     * Discontinue prescription
     */
    public function discontinuePrescription($id)
    {
        $prescription = PrescriptionRecord::findOrFail($id);
        $prescription->status = 'discontinued';
        $prescription->save();

        return response()->json([
            'success' => true,
            'message' => 'Prescription discontinued successfully'
        ]);
    }

    /**
     * Get prescription history for a patient
     */
    public function prescriptionHistory($patientId)
    {
        $prescriptions = PrescriptionRecord::where('patient_id', $patientId)
            ->with(['medicine', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($prescriptions);
    }

    /**
     * Display reports page
     */
    public function reports()
    {
        // Appointment statistics
        $appointmentStats = [
            'total' => Appointment::count(),
            'this_month' => Appointment::whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->count(),
            'pending' => Appointment::where('status', Appointment::STATUS_PENDING)->count(),
            'completed' => Appointment::where('status', 'Completed')->count(),
        ];

        // Patient statistics
        $patientStats = [
            'total_patients' => Patients::whereHas('user', function($q) {
                $q->whereIn('user_type', [1, 2]);
            })->count(),
            'new_this_month' => Patients::whereHas('user', function($q) {
                $q->whereIn('user_type', [1, 2]);
            })
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count(),
        ];

        // Monthly trends (last 12 months)
        $monthlyTrends = Appointment::selectRaw('DATE_FORMAT(date, "%m") as month, DATE_FORMAT(date, "%Y") as year, COUNT(*) as count')
            ->whereNotNull('date')
            ->groupBy('month', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        // Top conditions (if you have a conditions field in health records)
        $topConditions = [];

        // Recent health records
        $recentHealthRecords = HealthRecords::with(['patient.user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Medicine inventory status
        $medicineStats = [
            'total' => Medicine::count(),
            'in_stock' => Medicine::where('quantity', '>', 10)->count(),
            'low_stock' => Medicine::where('quantity', '>', 0)->where('quantity', '<=', 10)->count(),
            'out_of_stock' => Medicine::where('quantity', '<=', 0)->count(),
            'expired' => Medicine::where('expiration_date', '<', Carbon::now())->count(),
        ];

        return view('staff.reports', compact('appointmentStats', 'patientStats', 'monthlyTrends', 'topConditions', 'recentHealthRecords', 'medicineStats'));
    }

    /**
     * Show form to create new health record
     */
    public function createHealthRecord()
    {
        // Staff can create records for all patients
        $patients = Patients::with('user')
            ->whereHas('user', function($q) {
                $q->whereIn('user_type', [1, 2]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get available immunizations for dropdown
        $immunizations = Immunization::orderBy('name')->get();

        return view('staff.create-health-record', compact('patients', 'immunizations'));
    }

    /**
     * Store a new health record
     */
    public function storeHealthRecord(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'record_type' => 'required|in:physical,dental,immunization',
        ]);

        try {
            switch ($request->record_type) {
                case 'physical':
                    $this->createPhysicalExamination($request);
                    break;
                case 'dental':
                    $this->createDentalExamination($request);
                    break;
                case 'immunization':
                    $this->createImmunizationRecord($request);
                    break;
            }

            return redirect()->route('staff.health-records')
                ->with('success', 'Health record created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating health record: ' . $e->getMessage());
        }
    }

    /**
     * Create Physical Examination Record
     */
    private function createPhysicalExamination(Request $request)
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

        $patient = Patients::findOrFail($request->patient_id);

        PhysicalExamination::create([
            'patient_id' => $patient->id,
            'doctor_id' => null, // Staff member, not a doctor
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
    private function createDentalExamination(Request $request)
    {
        $request->validate([
            'diagnosis' => 'nullable|string',
            'teeth_status' => 'nullable|array',
        ]);

        DentalExamination::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => null, // Staff member, not a doctor
            'diagnosis' => $request->diagnosis,
            'teeth_status' => $request->teeth_status ?? [],
        ]);
    }

    /**
     * Create Immunization Record
     */
    private function createImmunizationRecord(Request $request)
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
            'administered_by' => Auth::user()->name . ' (Staff)',
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
        $record = HealthRecords::findOrFail($id);
        return view('staff.edit-health-record', compact('record'));
    }

    /**
     * Update Health Record
     */
    public function updateHealthRecord(Request $request, $id)
    {
        $record = HealthRecords::findOrFail($id);

        $request->validate([
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $record->update($request->only(['diagnosis', 'treatment', 'symptoms', 'notes']));

        return redirect()->route('staff.health-records')
            ->with('success', 'Health record updated successfully.');
    }

    /**
     * Edit Physical Examination
     */
    public function editPhysicalExam($id)
    {
        $exam = PhysicalExamination::with(['patient.user'])->findOrFail($id);
        return view('staff.edit-physical-exam', compact('exam'));
    }

    /**
     * Update Physical Examination
     */
    public function updatePhysicalExam(Request $request, $id)
    {
        $exam = PhysicalExamination::findOrFail($id);

        $request->validate([
            'height' => 'required|string',
            'weight' => 'required|string',
            'bp' => 'required|string',
            'heart' => 'nullable|string',
            'lungs' => 'nullable|string',
            'eyes' => 'nullable|string',
            'ears' => 'nullable|string',
            'nose' => 'nullable|string',
            'throat' => 'nullable|string',
            'skin' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $exam->update($request->only(['height', 'weight', 'bp', 'heart', 'lungs', 'eyes', 'ears', 'nose', 'throat', 'skin', 'remarks']));

        return redirect()->route('staff.health-records')
            ->with('success', 'Physical examination updated successfully.');
    }

    /**
     * Edit Dental Examination
     */
    public function editDentalExam($id)
    {
        $exam = DentalExamination::with(['patient.user'])->findOrFail($id);
        return view('staff.edit-dental-exam', compact('exam'));
    }

    /**
     * Update Dental Examination
     */
    public function updateDentalExam(Request $request, $id)
    {
        $exam = DentalExamination::findOrFail($id);

        $request->validate([
            'teeth_status' => 'nullable|array',
            'diagnosis' => 'nullable|string',
        ]);

        $exam->update($request->only(['teeth_status', 'diagnosis']));

        return redirect()->route('staff.health-records')
            ->with('success', 'Dental examination updated successfully.');
    }

    /**
     * Edit Immunization Record
     */
    public function editImmunization($id)
    {
        $record = ImmunizationRecords::with(['patient.user'])->findOrFail($id);
        return view('staff.edit-immunization', compact('record'));
    }

    /**
     * Update Immunization Record
     */
    public function updateImmunization(Request $request, $id)
    {
        $record = ImmunizationRecords::findOrFail($id);

        $request->validate([
            'vaccine_name' => 'required|string',
            'vaccine_type' => 'nullable|string',
            'dosage' => 'nullable|string',
            'site_of_administration' => 'nullable|string',
            'expiration_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $record->update($request->only(['vaccine_name', 'vaccine_type', 'dosage', 'site_of_administration', 'expiration_date', 'notes']));

        return redirect()->route('staff.health-records')
            ->with('success', 'Immunization record updated successfully.');
    }

    /**
     * Show report generation page
     */
    public function showReportGeneration()
    {
        $savedReports = GeneratedReport::where('generated_by_type', 'staff')
            ->where('generated_by_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.generate-report', compact('savedReports'));
    }

    /**
     * Generate report based on parameters
     */
    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:patient_statistics,appointment_statistics,health_records,prescriptions,medicine_inventory',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'title' => 'required|string|max:255',
        ]);

        $reportType = $request->report_type;
        $dateFrom = $request->date_from ? Carbon::parse($request->date_from) : Carbon::now()->subYear();
        $dateTo = $request->date_to ? Carbon::parse($request->date_to) : Carbon::now();

        $reportData = $this->compileReportData($reportType, $dateFrom, $dateTo);

        // Save report to database
        $report = GeneratedReport::create([
            'title' => $request->title,
            'report_type' => $reportType,
            'description' => $request->description,
            'parameters' => [
                'date_from' => $dateFrom->toDateString(),
                'date_to' => $dateTo->toDateString(),
            ],
            'generated_by_type' => 'staff',
            'generated_by_id' => auth()->id(),
            'status' => 'completed',
        ]);

        return view('staff.view-report', compact('report', 'reportData', 'dateFrom', 'dateTo'));
    }

    /**
     * View existing report
     */
    public function viewReport($id)
    {
        $report = GeneratedReport::findOrFail($id);

        // Check authorization
        if ($report->generated_by_id !== auth()->id() && $report->generated_by_type !== 'staff') {
            abort(403, 'Unauthorized access to this report.');
        }

        $dateFrom = Carbon::parse($report->parameters['date_from']);
        $dateTo = Carbon::parse($report->parameters['date_to']);

        $reportData = $this->compileReportData($report->report_type, $dateFrom, $dateTo);

        return view('staff.view-report', compact('report', 'reportData', 'dateFrom', 'dateTo'));
    }

    /**
     * Delete report
     */
    public function deleteReport($id)
    {
        $report = GeneratedReport::findOrFail($id);

        // Check authorization
        if ($report->generated_by_id !== auth()->id() && $report->generated_by_type !== 'staff') {
            abort(403, 'Unauthorized to delete this report.');
        }

        $report->delete();

        return redirect()->route('staff.reports.generate')
            ->with('success', 'Report deleted successfully.');
    }

    /**
     * Export report as PDF
     */
    public function exportReport($id, $format = 'pdf')
    {
        $report = GeneratedReport::findOrFail($id);

        // Check authorization
        if ($report->generated_by_id !== auth()->id() && $report->generated_by_type !== 'staff') {
            abort(403, 'Unauthorized to export this report.');
        }

        $dateFrom = Carbon::parse($report->parameters['date_from']);
        $dateTo = Carbon::parse($report->parameters['date_to']);

        $reportData = $this->compileReportData($report->report_type, $dateFrom, $dateTo);

        if ($format === 'csv') {
            return $this->exportAsCSV($report, $reportData);
        }

        // For now, return a simple download view
        // You can integrate a PDF library like DomPDF or mPDF later
        return view('staff.export-report', compact('report', 'reportData', 'dateFrom', 'dateTo'));
    }

    /**
     * Compile report data based on type
     */
    private function compileReportData($reportType, $dateFrom, $dateTo)
    {
        switch ($reportType) {
            case 'patient_statistics':
                return $this->compilePatientStatistics($dateFrom, $dateTo);
            case 'appointment_statistics':
                return $this->compileAppointmentStatistics($dateFrom, $dateTo);
            case 'health_records':
                return $this->compileHealthRecordsReport($dateFrom, $dateTo);
            case 'prescriptions':
                return $this->compilePrescriptionsReport($dateFrom, $dateTo);
            case 'medicine_inventory':
                return $this->compileMedicineInventoryReport();
            default:
                return [];
        }
    }

    private function compilePatientStatistics($dateFrom, $dateTo)
    {
        return [
            'total_patients' => Patients::whereHas('user', function($q) {
                $q->whereIn('user_type', [1, 2]);
            })->count(),
            'new_patients' => Patients::whereBetween('created_at', [$dateFrom, $dateTo])
                ->whereHas('user', function($q) {
                    $q->whereIn('user_type', [1, 2]);
                })->count(),
            'gender_distribution' => Patients::selectRaw('gender, COUNT(*) as count')
                ->whereHas('user', function($q) {
                    $q->whereIn('user_type', [1, 2]);
                })
                ->groupBy('gender')
                ->get(),
            'by_educational_level' => Patients::join('educational_levels', 'patients.edulvl_id', '=', 'educational_levels.id')
                ->selectRaw('educational_levels.level, COUNT(*) as count')
                ->whereHas('user', function($q) {
                    $q->whereIn('user_type', [1, 2]);
                })
                ->groupBy('educational_levels.level')
                ->get(),
        ];
    }

    private function compileAppointmentStatistics($dateFrom, $dateTo)
    {
        return [
            'total_appointments' => Appointment::whereBetween('date', [$dateFrom, $dateTo])->count(),
            'by_status' => Appointment::selectRaw('status, COUNT(*) as count')
                ->whereBetween('date', [$dateFrom, $dateTo])
                ->groupBy('status')
                ->get(),
            'by_month' => Appointment::selectRaw('DATE_FORMAT(date, "%Y-%m") as month, COUNT(*) as count')
                ->whereBetween('date', [$dateFrom, $dateTo])
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            'pending' => Appointment::where('status', Appointment::STATUS_PENDING)
                ->whereBetween('date', [$dateFrom, $dateTo])
                ->count(),
            'completed' => Appointment::where('status', 'Completed')
                ->whereBetween('date', [$dateFrom, $dateTo])
                ->count(),
        ];
    }

    private function compileHealthRecordsReport($dateFrom, $dateTo)
    {
        return [
            'total_records' => HealthRecords::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'physical_exams' => PhysicalExamination::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'dental_exams' => DentalExamination::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'immunizations' => ImmunizationRecords::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'recent_records' => HealthRecords::with(['patient.user'])
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get(),
        ];
    }

    private function compilePrescriptionsReport($dateFrom, $dateTo)
    {
        return [
            'total_prescriptions' => PrescriptionRecord::whereBetween('date_prescribed', [$dateFrom, $dateTo])->count(),
            'by_status' => PrescriptionRecord::selectRaw('status, COUNT(*) as count')
                ->whereBetween('date_prescribed', [$dateFrom, $dateTo])
                ->groupBy('status')
                ->get(),
            'most_prescribed' => PrescriptionRecord::join('medicines', 'prescription_records.medicine_id', '=', 'medicines.id')
                ->selectRaw('medicines.brand_name, COUNT(*) as count')
                ->whereBetween('prescription_records.date_prescribed', [$dateFrom, $dateTo])
                ->groupBy('medicines.brand_name')
                ->orderByDesc('count')
                ->take(10)
                ->get(),
            'recent_prescriptions' => PrescriptionRecord::with(['patient.user', 'medicine', 'doctor'])
                ->whereBetween('date_prescribed', [$dateFrom, $dateTo])
                ->orderBy('date_prescribed', 'desc')
                ->take(20)
                ->get(),
        ];
    }

    private function compileMedicineInventoryReport()
    {
        return [
            'total_medicines' => Medicine::count(),
            'in_stock' => Medicine::where('quantity', '>', 10)->count(),
            'low_stock' => Medicine::where('quantity', '>', 0)->where('quantity', '<=', 10)->count(),
            'out_of_stock' => Medicine::where('quantity', '<=', 0)->count(),
            'expired' => Medicine::where('expiration_date', '<', Carbon::now())->count(),
            'expiring_soon' => Medicine::where('expiration_date', '>', Carbon::now())
                ->where('expiration_date', '<=', Carbon::now()->addMonths(3))
                ->count(),
            'low_stock_items' => Medicine::where('quantity', '>', 0)
                ->where('quantity', '<=', 10)
                ->orderBy('quantity')
                ->get(),
            'expired_items' => Medicine::where('expiration_date', '<', Carbon::now())
                ->orderBy('expiration_date')
                ->get(),
        ];
    }

    private function exportAsCSV($report, $reportData)
    {
        $filename = str_replace(' ', '_', $report->title) . '_' . now()->format('YmdHis') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reportData, $report) {
            $file = fopen('php://output', 'w');

            // Add report header
            fputcsv($file, ['Report Title', $report->title]);
            fputcsv($file, ['Report Type', str_replace('_', ' ', ucwords($report->report_type))]);
            fputcsv($file, ['Generated On', $report->created_at->format('Y-m-d H:i:s')]);
            fputcsv($file, ['Date Range', $report->parameters['date_from'] . ' to ' . $report->parameters['date_to']]);
            fputcsv($file, []);

            // Add data based on report type
            foreach ($reportData as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    fputcsv($file, [ucwords(str_replace('_', ' ', $key))]);

                    if ($value instanceof \Illuminate\Support\Collection) {
                        $items = $value->toArray();
                        if (count($items) > 0) {
                            fputcsv($file, array_keys((array)$items[0]));
                            foreach ($items as $item) {
                                fputcsv($file, (array)$item);
                            }
                        }
                    }
                    fputcsv($file, []);
                } else {
                    fputcsv($file, [ucwords(str_replace('_', ' ', $key)), $value]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display certificate requests for staff to review
     */
    public function certificateRequests(Request $request)
    {
        $user = Auth::user();

        // Build query for certificate requests
        $query = CertificateRequest::query()
            ->with(['patient.user', 'certificateType']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('firstname', 'like', '%' . $search . '%')
                  ->orWhere('lastname', 'like', '%' . $search . '%');
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get counts for tabs
        $pendingCount = CertificateRequest::where('status', 'pending')->count();
        $approvedCount = CertificateRequest::where('status', 'approved')->count();
        $issuedCount = CertificateRequest::where('status', 'issued')->count();
        $rejectedCount = CertificateRequest::where('status', 'rejected')->count();

        return view('staff.certificate-requests', compact(
            'requests',
            'pendingCount',
            'approvedCount',
            'issuedCount',
            'rejectedCount'
        ));
    }

    /**
     * Show details of a certificate request
     */
    public function showCertificateRequest($id)
    {
        $request = CertificateRequest::with(['patient.user', 'certificateType', 'appointment'])
            ->findOrFail($id);

        return view('staff.certificate-request-detail', compact('request'));
    }

    /**
     * Approve a certificate request
     */
    public function approveCertificateRequest(Request $request, $id)
    {
        $user = Auth::user();
        $staffDoctor = Doctors::where('user_id', $user->id)->first();

        $certificateRequest = CertificateRequest::findOrFail($id);

        $validated = $request->validate([
            'doctor_notes' => 'nullable|string|max:1000',
        ]);

        $certificateRequest->update([
            'status' => CertificateRequest::STATUS_APPROVED,
            'doctor_id' => $staffDoctor->id ?? null,
            'doctor_notes' => $validated['doctor_notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Certificate request approved successfully.');
    }

    /**
     * Reject a certificate request
     */
    public function rejectCertificateRequest(Request $request, $id)
    {
        $user = Auth::user();
        $staffDoctor = Doctors::where('user_id', $user->id)->first();

        $certificateRequest = CertificateRequest::findOrFail($id);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $certificateRequest->update([
            'status' => CertificateRequest::STATUS_REJECTED,
            'doctor_id' => $staffDoctor->id ?? null,
            'doctor_notes' => $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', 'Certificate request rejected.');
    }

    /**
     * Mark a certificate as issued
     */
    public function issueCertificateRequest($id)
    {
        $certificateRequest = CertificateRequest::findOrFail($id);

        $certificateRequest->update([
            'status' => CertificateRequest::STATUS_ISSUED,
            'issued_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Certificate marked as issued.');
    }
}
