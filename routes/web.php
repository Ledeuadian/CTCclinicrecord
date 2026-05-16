<?php

// User Contollers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ImmunizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HealthRecordsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\ReportsController;
// Patient Controllers (Separated)
use App\Http\Controllers\PatientsAppointmentScheduler;
use App\Http\Controllers\PatientsViewPersonalHealthRecord;
use App\Http\Controllers\PatientsUpdatePersonalInformation;use App\Http\Controllers\PatientCertificateController;// Doctor Controllers
use App\Http\Controllers\DoctorDashboardController;
// Staff Controllers
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\ImportController;
// Admin Controllers
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminAppointments;
use App\Http\Controllers\AdminUsers;
use App\Http\Controllers\AdminDoctor;
use App\Http\Controllers\AdminPatients;
use App\Http\Controllers\AdminMedicines;
use App\Http\Controllers\AdminImmunization;
use App\Http\Controllers\AdminReports;
use App\Http\Controllers\AdminDentalExamination;
use App\Http\Controllers\AdminPhysicalExamination;
use App\Http\Controllers\AdminPrescription;
use App\Http\Controllers\AdminPatientStatistics;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Generic dashboard - redirects to appropriate user dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        switch ($user->user_type) {
            case 0: // Admin
                return redirect()->route('admin.dashboard');
            case 1: // Student/Patient
                return redirect()->route('patients.dashboard');
            case 2: // Faculty & Staff
                return redirect()->route('staff.dashboard');
            case 3: // Doctor
                return redirect()->route('doctor.dashboard');
            default:
                return redirect()->route('patients.dashboard');
        }
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::resource('/appointments', AppointmentController::class);
    Route::resource('/health-records', HealthRecordsController::class);
    Route::resource('/doctors', DoctorsController::class);
    Route::resource('/medicine', MedicineController::class);
    Route::resource('/immunization', ImmunizationController::class);
    Route::resource('/course', CourseController::class);
    Route::resource('/patients', PatientsController::class);
    Route::resource('/reports', ReportsController::class);

    // Patient-specific routes
    Route::prefix('patient')->name('patients.')->group(function () {
        // Dashboard (main shell) - returns the shell view
        Route::get('/dashboard', function() {
            return view('patients.shells.patient-shell');
        })->name('dashboard');

        // Tab routes - all return the shell view, content loaded via AJAX
        Route::get('/appointments', function() {
            return view('patients.shells.patient-shell');
        })->name('appointments');

        Route::get('/health-records', function() {
            return view('patients.shells.patient-shell');
        })->name('health-records');

        // Alias for health-records (some views may use this route name)
        Route::get('/health-records', function() {
            return view('patients.shells.patient-shell');
        })->name('health.records');

        Route::get('/profile', function() {
            return view('patients.shells.patient-shell');
        })->name('profile');

        Route::get('/certificates', function() {
            return view('patients.shells.patient-shell');
        })->name('certificates');

        // Alias for certificates.index (some code uses this route name)
        Route::get('/certificates', function() {
            return view('patients.shells.patient-shell');
        })->name('certificates.index');

        // Appointment Scheduling Routes (separate pages, not in shell)
        Route::get('/schedule-appointment', [PatientsAppointmentScheduler::class, 'scheduleAppointment'])->name('schedule.appointment');
        Route::post('/schedule-appointment', [PatientsAppointmentScheduler::class, 'storeAppointment'])->name('store.appointment');
        Route::patch('/appointments/{appointmentId}/cancel', [PatientsAppointmentScheduler::class, 'cancelAppointment'])->name('appointments.cancel');

        // Health Records Viewing Routes (separate pages, not in shell)
        Route::get('/health-records/detailed', [PatientsViewPersonalHealthRecord::class, 'detailedHealthRecords'])->name('health.records.detailed');
        Route::get('/immunization-records', [PatientsViewPersonalHealthRecord::class, 'immunizationRecords'])->name('immunization.records');
        Route::get('/prescription-history', [PatientsViewPersonalHealthRecord::class, 'prescriptionHistory'])->name('prescription.history');
        Route::get('/examination-history', [PatientsViewPersonalHealthRecord::class, 'examinationHistory'])->name('examination.history');
        Route::get('/health-summary', [PatientsViewPersonalHealthRecord::class, 'healthSummary'])->name('health.summary');

        // Personal Information Management Routes (separate pages, not in shell)
        Route::get('/profile/create', [PatientsUpdatePersonalInformation::class, 'create'])->name('profile.create');
        Route::post('/profile', [PatientsUpdatePersonalInformation::class, 'store'])->name('profile.store');
        Route::get('/profile/edit', [PatientsUpdatePersonalInformation::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [PatientsUpdatePersonalInformation::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [PatientsUpdatePersonalInformation::class, 'updatePassword'])->name('profile.password.update');
        Route::patch('/profile/basic-info', [PatientsUpdatePersonalInformation::class, 'updateBasicInfo'])->name('profile.basic.update');
        Route::patch('/profile/medical-info', [PatientsUpdatePersonalInformation::class, 'updateMedicalInfo'])->name('profile.medical.info');
        Route::patch('/profile/emergency-contact', [PatientsUpdatePersonalInformation::class, 'updateEmergencyContact'])->name('profile.emergency.contact');

        // Certificate Request Routes (separate pages, not in shell)
        Route::get('/certificates/create', [PatientCertificateController::class, 'create'])->name('certificates.create');
        Route::post('/certificates', [PatientCertificateController::class, 'store'])->name('certificates.store');
        Route::get('/certificates/{id}', [PatientCertificateController::class, 'show'])->name('certificates.show');

        // AJAX Tab Content Routes (inside patient prefix, used by shell)
        Route::get('/ajax/dashboard', [PatientsController::class, 'ajaxDashboard'])->name('ajax.dashboard');
        Route::get('/ajax/appointments', [PatientsController::class, 'ajaxAppointments'])->name('ajax.appointments');
        Route::get('/ajax/health-records', [PatientsController::class, 'ajaxHealthRecords'])->name('ajax.health-records');
        Route::get('/ajax/profile', [PatientsController::class, 'ajaxProfile'])->name('ajax.profile');
        Route::get('/ajax/certificates', [PatientsController::class, 'ajaxCertificates'])->name('ajax.certificates');
    });
    Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'check.user.type:3'])->group(function () {
        Route::get('/', function() {
            return view('doctor.shells.doctor-shell');
        })->name('index');
        Route::get('/dashboard', function() {
            return view('doctor.shells.doctor-shell');
        })->name('dashboard');
        Route::get('/appointments', [DoctorDashboardController::class, 'appointments'])->name('appointments');
        Route::patch('/appointments/{appointmentId}/status', [DoctorDashboardController::class, 'updateAppointmentStatus'])->name('appointments.update-status');
        Route::get('/patients', [DoctorDashboardController::class, 'patients'])->name('patients');
        Route::get('/patients/{patientId}', [DoctorDashboardController::class, 'viewPatient'])->name('patient-details');
        Route::put('/patients/{patientId}', [DoctorDashboardController::class, 'updatePatient'])->name('patients.update');
        Route::get('/health-records', [DoctorDashboardController::class, 'healthRecords'])->name('health-records');
        Route::get('/health-records/create', [DoctorDashboardController::class, 'createHealthRecord'])->name('health-records.create');
        Route::post('/health-records', [DoctorDashboardController::class, 'storeHealthRecord'])->name('health-records.store');
        Route::get('/health-records/{id}/edit', [DoctorDashboardController::class, 'editHealthRecord'])->name('health-records.edit');
        Route::put('/health-records/{id}', [DoctorDashboardController::class, 'updateHealthRecord'])->name('health-records.update');

        // Print Health Records
        Route::get('/print/health-record/{patientId}', [DoctorDashboardController::class, 'printHealthRecord'])->name('print.health-record');

        // Physical Examinations
        Route::get('/physical-exams/{id}/edit', [DoctorDashboardController::class, 'editPhysicalExam'])->name('physical-exams.edit');
        Route::put('/physical-exams/{id}', [DoctorDashboardController::class, 'updatePhysicalExam'])->name('physical-exams.update');

        // Dental Examinations
        Route::get('/dental-exams/{id}/edit', [DoctorDashboardController::class, 'editDentalExam'])->name('dental-exams.edit');
        Route::put('/dental-exams/{id}', [DoctorDashboardController::class, 'updateDentalExam'])->name('dental-exams.update');

        // Immunizations
        Route::get('/immunizations/{id}/edit', [DoctorDashboardController::class, 'editImmunization'])->name('immunizations.edit');
        Route::put('/immunizations/{id}', [DoctorDashboardController::class, 'updateImmunization'])->name('immunizations.update');

        // Prescriptions (old routes)
        Route::get('/prescriptions/{id}/edit', [DoctorDashboardController::class, 'editPrescription'])->name('prescriptions.edit');
        Route::put('/prescriptions/{id}', [DoctorDashboardController::class, 'updatePrescription'])->name('prescriptions.update');

        // Prescriptions Management (new routes)
        Route::get('/prescriptions', [DoctorDashboardController::class, 'prescriptions'])->name('prescriptions');
        Route::get('/prescriptions/create', [DoctorDashboardController::class, 'createPrescription'])->name('prescriptions.create');
        Route::post('/prescription', [DoctorDashboardController::class, 'storePrescription'])->name('prescription.store');
        Route::put('/prescription/{id}', [DoctorDashboardController::class, 'updatePrescriptionRecord'])->name('prescription.update');
        Route::put('/prescription/{id}/discontinue', [DoctorDashboardController::class, 'discontinuePrescription'])->name('prescription.discontinue');
        Route::get('/prescription/history/{patientId}', [DoctorDashboardController::class, 'prescriptionHistory'])->name('prescription.history');

        // Medicine
        Route::post('/medicine', [DoctorDashboardController::class, 'storeMedicine'])->name('medicine.store');
        Route::put('/medicine/{id}', [DoctorDashboardController::class, 'updateMedicine'])->name('medicine.update');

        Route::get('/medications', [DoctorDashboardController::class, 'medications'])->name('medications');
        Route::get('/reports', [DoctorDashboardController::class, 'reports'])->name('reports');

        // Certificate Requests
        Route::get('/certificate-requests', [DoctorDashboardController::class, 'certificateRequests'])->name('certificate-requests');
        Route::get('/certificate-requests/{id}', [DoctorDashboardController::class, 'showCertificateRequest'])->name('certificate-requests.show');
        Route::post('/certificate-requests/{id}/approve', [DoctorDashboardController::class, 'approveCertificateRequest'])->name('certificate-requests.approve');
        Route::post('/certificate-requests/{id}/reject', [DoctorDashboardController::class, 'rejectCertificateRequest'])->name('certificate-requests.reject');
        Route::post('/certificate-requests/{id}/issue', [DoctorDashboardController::class, 'issueCertificateRequest'])->name('certificate-requests.issue');

        // AJAX Tab Content Routes
        Route::get('/ajax/dashboard', [DoctorDashboardController::class, 'ajaxDashboard'])->name('ajax.dashboard');
        Route::get('/ajax/appointments', [DoctorDashboardController::class, 'ajaxAppointments'])->name('ajax.appointments');
        Route::get('/ajax/patients', [DoctorDashboardController::class, 'ajaxPatients'])->name('ajax.patients');
        Route::get('/ajax/health-records', [DoctorDashboardController::class, 'ajaxHealthRecords'])->name('ajax.health-records');
        Route::get('/ajax/medications', [DoctorDashboardController::class, 'ajaxMedications'])->name('ajax.medications');
        Route::get('/ajax/prescriptions', [DoctorDashboardController::class, 'ajaxPrescriptions'])->name('ajax.prescriptions');
        Route::get('/ajax/reports', [DoctorDashboardController::class, 'ajaxReports'])->name('ajax.reports');

        // Create Routes for full-page forms
        Route::get('/medicines/create', [DoctorDashboardController::class, 'createMedicine'])->name('medicines.create');
        Route::get('/prescriptions/create', [DoctorDashboardController::class, 'createPrescriptionRecord'])->name('prescriptions.create-page');
    });
    // End Doctor Routes

    // Staff Routes - for user_type = 2 (Faculty & Staff)
    // Staff have access to doctor-like functionalities for managing patients
    Route::prefix('staff')->name('staff.')->middleware(['auth', 'check.user.type:2'])->group(function () {
        Route::get('/', [StaffDashboardController::class, 'index'])->name('index');
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('/appointments', [StaffDashboardController::class, 'appointments'])->name('appointments');
        Route::patch('/appointments/{appointmentId}/status', [StaffDashboardController::class, 'updateAppointmentStatus'])->name('appointments.update-status');
        Route::get('/patients', [StaffDashboardController::class, 'patients'])->name('patients');
        Route::get('/patients/create', [StaffDashboardController::class, 'createPatient'])->name('patients.create');
        Route::post('/patients', [StaffDashboardController::class, 'storePatient'])->name('patients.store');
        Route::get('/patients/{patientId}', [StaffDashboardController::class, 'viewPatient'])->name('patient-details');
        Route::put('/patients/{patientId}', [StaffDashboardController::class, 'updatePatient'])->name('patients.update');
        Route::get('/health-records', [StaffDashboardController::class, 'healthRecords'])->name('health-records');
        Route::get('/health-records/create', [StaffDashboardController::class, 'createHealthRecord'])->name('health-records.create');
        Route::post('/health-records', [StaffDashboardController::class, 'storeHealthRecord'])->name('health-records.store');
        Route::get('/health-records/{id}/edit', [StaffDashboardController::class, 'editHealthRecord'])->name('health-records.edit');
        Route::put('/health-records/{id}', [StaffDashboardController::class, 'updateHealthRecord'])->name('health-records.update');

        // Print Health Records
        Route::get('/print/health-record/{patientId}', [StaffDashboardController::class, 'printHealthRecord'])->name('print.health-record');

        // Physical Examinations
        Route::get('/physical-exams/{id}/edit', [StaffDashboardController::class, 'editPhysicalExam'])->name('physical-exams.edit');
        Route::put('/physical-exams/{id}', [StaffDashboardController::class, 'updatePhysicalExam'])->name('physical-exams.update');

        // Dental Examinations
        Route::get('/dental-exams/{id}/edit', [StaffDashboardController::class, 'editDentalExam'])->name('dental-exams.edit');
        Route::put('/dental-exams/{id}', [StaffDashboardController::class, 'updateDentalExam'])->name('dental-exams.update');

        // Immunization Records
        Route::get('/immunizations/{id}/edit', [StaffDashboardController::class, 'editImmunization'])->name('immunizations.edit');
        Route::put('/immunizations/{id}', [StaffDashboardController::class, 'updateImmunization'])->name('immunizations.update');

        // Medicines
        Route::get('/medications', [StaffDashboardController::class, 'medications'])->name('medications');
        Route::post('/medicine', [StaffDashboardController::class, 'storeMedicine'])->name('medicine.store');
        Route::put('/medicine/{id}', [StaffDashboardController::class, 'updateMedicine'])->name('medicine.update');

        // Staff Prescriptions Management
        Route::get('/prescriptions', [StaffDashboardController::class, 'prescriptions'])->name('prescriptions');
        Route::post('/prescription', [StaffDashboardController::class, 'storePrescription'])->name('prescription.store');
        Route::put('/prescription/{id}', [StaffDashboardController::class, 'updatePrescriptionRecord'])->name('prescription.update');
        Route::put('/prescription/{id}/discontinue', [StaffDashboardController::class, 'discontinuePrescription'])->name('prescription.discontinue');
        Route::get('/prescription/history/{patientId}', [StaffDashboardController::class, 'prescriptionHistory'])->name('prescription.history');

        // Reports & Statistics
        Route::get('/reports', [StaffDashboardController::class, 'reports'])->name('reports');
        Route::get('/reports/generate', [StaffDashboardController::class, 'showReportGeneration'])->name('reports.generate');
        Route::post('/reports/generate', [StaffDashboardController::class, 'generateReport'])->name('reports.store');
        Route::get('/reports/view/{id}', [StaffDashboardController::class, 'viewReport'])->name('reports.view');
        Route::delete('/reports/{id}', [StaffDashboardController::class, 'deleteReport'])->name('reports.delete');
        Route::get('/reports/export/{id}/{format}', [StaffDashboardController::class, 'exportReport'])->name('reports.export');

        // AJAX Tab Content Routes
        Route::get('/ajax/dashboard', [StaffDashboardController::class, 'ajaxDashboard'])->name('ajax.dashboard');
        Route::get('/ajax/appointments', [StaffDashboardController::class, 'ajaxAppointments'])->name('ajax.appointments');
        Route::get('/ajax/patients', [StaffDashboardController::class, 'ajaxPatients'])->name('ajax.patients');
        Route::get('/ajax/health-records', [StaffDashboardController::class, 'ajaxHealthRecords'])->name('ajax.health-records');
        Route::get('/ajax/medicines', [StaffDashboardController::class, 'ajaxMedicines'])->name('ajax.medicines');
        Route::get('/ajax/prescriptions', [StaffDashboardController::class, 'ajaxPrescriptions'])->name('ajax.prescriptions');
        Route::get('/ajax/reports', [StaffDashboardController::class, 'ajaxReports'])->name('ajax.reports');
        Route::get('/ajax/statistics', [StaffDashboardController::class, 'ajaxStatistics'])->name('ajax.statistics');
        Route::get('/ajax/import', [StaffDashboardController::class, 'ajaxImport'])->name('ajax.import');

        // Statistics Routes (detail pages)
        Route::get('/statistics/course/{id}', [StaffDashboardController::class, 'patientsByCourse'])->name('statistics.course');
        Route::get('/statistics/level/{id}', [StaffDashboardController::class, 'patientsByLevel'])->name('statistics.level');

        // Import routes (direct processing, not tab-based)
        Route::post('/import/process/users', [ImportController::class, 'processUsers'])->name('import.process.users');
        Route::post('/import/process/medicines', [ImportController::class, 'processMedicines'])->name('import.process.medicines');
        Route::get('/import/sample/users', [ImportController::class, 'downloadUsersSample'])->name('import.sample.users');
        Route::get('/import/sample/medicines', [ImportController::class, 'downloadMedicinesSample'])->name('import.sample.medicines');

        // Create Routes for full-page forms
        Route::get('/medicines/create', [StaffDashboardController::class, 'createMedicine'])->name('medicines.create');
        Route::get('/prescriptions/create', [StaffDashboardController::class, 'createPrescription'])->name('prescriptions.create-page');

        // Certificate Requests
        Route::get('/certificate-requests', [StaffDashboardController::class, 'certificateRequests'])->name('certificate-requests');
        Route::get('/certificate-requests/{id}', [StaffDashboardController::class, 'showCertificateRequest'])->name('certificate-requests.show');
        Route::post('/certificate-requests/{id}/approve', [StaffDashboardController::class, 'approveCertificateRequest'])->name('certificate-requests.approve');
        Route::post('/certificate-requests/{id}/reject', [StaffDashboardController::class, 'rejectCertificateRequest'])->name('certificate-requests.reject');
        Route::post('/certificate-requests/{id}/issue', [StaffDashboardController::class, 'issueCertificateRequest'])->name('certificate-requests.issue');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'check.user.type:0'])->group(function ()  {
    Route::resource('/admin/appointments',AdminAppointments::class)->names([
        'index' => 'admin.appointments.index',
        'create' => 'admin.appointments.create',
        'store' => 'admin.appointments.store',
        'edit' => 'admin.appointments.edit',
        'update' => 'admin.appointments.update',
        'destroy' => 'admin.appointments.destroy',
    ]);
    Route::resource('/admin/users', AdminUsers::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'update' => 'admin.users.update',
    ]);
    Route::get('/admin/users/edit/{user}/{type}', [AdminUsers::class, 'updateWithType'])->name('admin.users.updateWithType');
    Route::delete('/admin/users/destroy/{user}/{type}', [AdminUsers::class, 'deleteWithType'])->name('admin.users.deleteWithType');
    Route::resource('/admin/doctors', AdminDoctor::class)->names([
        'index' => 'admin.doctors.index',
        'create' => 'admin.doctors.create',
        'store' => 'admin.doctors.store',
        'edit' => 'admin.doctors.edit',
        'update' => 'admin.doctors.update',
        'destroy' => 'admin.doctors.destroy',
    ]);
    Route::get('/admin/medicines/export', [AdminMedicines::class, 'export'])->name('admin.medicines.export')->middleware('auth');
    Route::resource('/admin/medicines', AdminMedicines::class)->names([
        'index' => 'admin.medicines.index',
        'create' => 'admin.medicines.create',
        'store' => 'admin.medicines.store',
        'edit' => 'admin.medicines.edit',
        'update' => 'admin.medicines.update',
        'destroy' => 'admin.medicines.destroy',
    ]);

    // Import routes
    Route::get('/admin/import', [ImportController::class, 'index'])->name('admin.import.index')->middleware('auth');
    Route::get('/admin/import/users', [ImportController::class, 'users'])->name('admin.import.users')->middleware('auth');
    Route::post('/admin/import/process/users', [ImportController::class, 'processUsers'])->name('admin.import.process.users')->middleware('auth');
    Route::get('/admin/import/sample/users', [ImportController::class, 'downloadUsersSample'])->name('admin.import.sample.users');
    Route::get('/admin/import/medicines', [ImportController::class, 'medicines'])->name('admin.import.medicines')->middleware('auth');
    Route::post('/admin/import/process/medicines', [ImportController::class, 'processMedicines'])->name('admin.import.process.medicines')->middleware('auth');
    Route::get('/admin/import/sample/medicines', [ImportController::class, 'downloadMedicinesSample'])->name('admin.import.sample.medicines');

    Route::get('/admin/patients/export', [AdminPatients::class, 'export'])->name('admin.patients.export')->middleware('auth');
    Route::resource('/admin/patients', AdminPatients::class)->names([
        'index' => 'admin.patients.index',
        'create' => 'admin.patients.create',
        'store' => 'admin.patients.store',
        'edit' => 'admin.patients.edit',
        'update' => 'admin.patients.update',
        'destroy' => 'admin.patients.destroy',
    ]);
    Route::resource('/admin/immunization', AdminImmunization::class)->names([
        'index' => 'admin.immunization.index',
        'create' => 'admin.immunization.create',
        'store' => 'admin.immunization.store',
        'edit' => 'admin.immunization.edit',
        'update' => 'admin.immunization.update',
        'destroy' => 'admin.immunization.destroy',
    ]);
    Route::resource('/admin/dental', AdminDentalExamination::class)->names([
        'index' => 'admin.dental.index',
        'create' => 'admin.dental.create',
        'store' => 'admin.dental.store',
        'edit' => 'admin.dental.edit',
        'update' => 'admin.dental.update',
        'destroy' => 'admin.dental.destroy',
    ]);
    Route::resource('/admin/physical', AdminPhysicalExamination::class)->names([
        'index' => 'admin.physical.index',
        'create' => 'admin.physical.create',
        'store' => 'admin.physical.store',
        'edit' => 'admin.physical.edit',
        'update' => 'admin.physical.update',
        'destroy' => 'admin.physical.destroy',
    ]);
    Route::resource('/admin/prescription', AdminPrescription::class)->names([
        'index' => 'admin.prescription.index',
        'create' => 'admin.prescription.create',
        'store' => 'admin.prescription.store',
        'edit' => 'admin.prescription.edit',
        'update' => 'admin.prescription.update',
        'destroy' => 'admin.prescription.destroy',
    ]);
    Route::get('/admin/prescription/export', [AdminPrescription::class, 'export'])->name('admin.prescription.export')->middleware('auth');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Patient Statistics Routes
    Route::get('/admin/statistics/course/{id}', [AdminPatientStatistics::class, 'byCourse'])->name('admin.statistics.course');
    Route::get('/admin/statistics/level/{id}', [AdminPatientStatistics::class, 'byEducationalLevel'])->name('admin.statistics.level');
});

Route::post('/update-course/{id}', function (Request $request, $id) {
    $controller = new YourController();
    return $controller->update($request, $id);
});

require __DIR__.'/auth.php';


