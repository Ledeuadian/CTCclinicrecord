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
use App\Http\Controllers\PatientsUpdatePersonalInformation;
// Doctor Controllers
use App\Http\Controllers\DoctorDashboardController;
// Admin Controllers
use App\Http\Controllers\AdminLoginController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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
        // Dashboard (main controller)
        Route::get('/dashboard', [PatientsController::class, 'index'])->name('dashboard');

        // Appointment Scheduling Routes
        Route::get('/schedule-appointment', [PatientsAppointmentScheduler::class, 'scheduleAppointment'])->name('schedule.appointment');
        Route::post('/schedule-appointment', [PatientsAppointmentScheduler::class, 'storeAppointment'])->name('store.appointment');
        Route::get('/appointments', [PatientsAppointmentScheduler::class, 'appointments'])->name('appointments');
        Route::patch('/appointments/{appointmentId}/cancel', [PatientsAppointmentScheduler::class, 'cancelAppointment'])->name('appointments.cancel');

        // Health Records Viewing Routes
        Route::get('/health-records', [PatientsViewPersonalHealthRecord::class, 'healthRecords'])->name('health.records');
        Route::get('/health-records/detailed', [PatientsViewPersonalHealthRecord::class, 'detailedHealthRecords'])->name('health.records.detailed');
        Route::get('/immunization-records', [PatientsViewPersonalHealthRecord::class, 'immunizationRecords'])->name('immunization.records');
        Route::get('/prescription-history', [PatientsViewPersonalHealthRecord::class, 'prescriptionHistory'])->name('prescription.history');
        Route::get('/examination-history', [PatientsViewPersonalHealthRecord::class, 'examinationHistory'])->name('examination.history');
        Route::get('/health-summary', [PatientsViewPersonalHealthRecord::class, 'healthSummary'])->name('health.summary');

        // Personal Information Management Routes
        Route::get('/profile', [PatientsUpdatePersonalInformation::class, 'profile'])->name('profile');
        Route::get('/profile/create', [PatientsUpdatePersonalInformation::class, 'create'])->name('profile.create');
        Route::post('/profile', [PatientsUpdatePersonalInformation::class, 'store'])->name('profile.store');
        Route::get('/profile/edit', [PatientsUpdatePersonalInformation::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [PatientsUpdatePersonalInformation::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [PatientsUpdatePersonalInformation::class, 'updatePassword'])->name('profile.password.update');
        Route::patch('/profile/basic-info', [PatientsUpdatePersonalInformation::class, 'updateBasicInfo'])->name('profile.basic.update');
        Route::patch('/profile/medical-info', [PatientsUpdatePersonalInformation::class, 'updateMedicalInfo'])->name('profile.medical.update');
        Route::patch('/profile/emergency-contact', [PatientsUpdatePersonalInformation::class, 'updateEmergencyContact'])->name('profile.emergency.update');
    });

    // Doctor Routes - for user_type = 3 (Doctors)
    Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'check.user.type:3'])->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/appointments', [DoctorDashboardController::class, 'appointments'])->name('appointments');
        Route::patch('/appointments/{appointmentId}/status', [DoctorDashboardController::class, 'updateAppointmentStatus'])->name('appointments.update-status');
        Route::get('/patients', [DoctorDashboardController::class, 'patients'])->name('patients');
        Route::get('/patients/{patientId}', [DoctorDashboardController::class, 'viewPatient'])->name('patient-details');
        Route::get('/health-records', [DoctorDashboardController::class, 'healthRecords'])->name('health-records');
        Route::get('/health-records/create', [DoctorDashboardController::class, 'createHealthRecord'])->name('health-records.create');
        Route::post('/health-records', [DoctorDashboardController::class, 'storeHealthRecord'])->name('health-records.store');
        Route::get('/medications', [DoctorDashboardController::class, 'medications'])->name('medications');
        Route::get('/reports', [DoctorDashboardController::class, 'reports'])->name('reports');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/login', [AdminLoginController::class , 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

Route::middleware('auth:admin')->group(function ()  {
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
    Route::resource('/admin/medicines', AdminMedicines::class)->names([
        'index' => 'admin.medicines.index',
        'create' => 'admin.medicines.create',
        'store' => 'admin.medicines.store',
        'edit' => 'admin.medicines.edit',
        'update' => 'admin.medicines.update',
        'destroy' => 'admin.medicines.destroy',
    ]);
    Route::resource('/admin/patients', AdminPatients::class)->names([
        'index' => 'admin.patients.index',
        'create' => 'admin.patients.create',
        'store' => 'admin.patients.store',
        'edit' => 'admin.patients.edit',
        'update' => 'admin.patients.update',
        'destroy' => 'admin.patients.destroy',
    ]);
    Route::resource('/admin/reports', AdminReports::class);
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
    Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

Route::post('/update-course/{id}', function (Request $request, $id) {
    $controller = new YourController();
    return $controller->update($request, $id);
});

require __DIR__.'/auth.php';


