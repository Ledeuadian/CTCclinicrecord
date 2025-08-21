<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUGGING DOCTOR PATIENT RELATIONSHIP ===\n\n";

// Check doctor user
$doctorUser = App\Models\User::where('email', 'doctor@ckc.edu')->first();
if (!$doctorUser) {
    echo "❌ Doctor user not found with email 'doctor@ckc.edu'\n";
    exit;
}

echo "✅ Doctor user found: {$doctorUser->name} (ID: {$doctorUser->id})\n";

// Check doctor record
$doctorRecord = App\Models\Doctors::where('user_id', $doctorUser->id)->first();
if (!$doctorRecord) {
    echo "❌ Doctor record not found for user ID {$doctorUser->id}\n";
    exit;
}

echo "✅ Doctor record found: ID {$doctorRecord->id}\n\n";

// Check patient
$patient = App\Models\User::where('name', 'LIKE', '%Anahi Trinity Gislason%')->first();
if (!$patient) {
    echo "❌ Patient 'Anahi Trinity Gislason' not found\n";
    echo "Searching for similar names...\n";
    $patients = App\Models\User::where('name', 'LIKE', '%Anahi%')->orWhere('name', 'LIKE', '%Trinity%')->orWhere('name', 'LIKE', '%Gislason%')->get();
    foreach ($patients as $p) {
        echo "   - {$p->name} (ID: {$p->id})\n";
    }
    exit;
}

echo "✅ Patient found: {$patient->name} (ID: {$patient->id})\n";

// Check patient record
$patientRecord = App\Models\Patients::where('user_id', $patient->id)->first();
if (!$patientRecord) {
    echo "❌ Patient record not found for user ID {$patient->id}\n";
    exit;
}

echo "✅ Patient record found: ID {$patientRecord->id}\n\n";

// Check appointments
$appointments = App\Models\Appointment::where('doc_id', $doctorRecord->id)
    ->where('patient_id', $patientRecord->id)
    ->get();

echo "🔍 Appointments between doctor and patient:\n";
if ($appointments->count() > 0) {
    foreach ($appointments as $apt) {
        echo "   - Appointment ID: {$apt->id}, Date: {$apt->date}, Status: {$apt->status}\n";
    }
} else {
    echo "   ❌ No appointments found between this doctor and patient\n";
}

// Check all appointments for this doctor
echo "\n🔍 All appointments for this doctor:\n";
$allAppointments = App\Models\Appointment::where('doc_id', $doctorRecord->id)->get();
if ($allAppointments->count() > 0) {
    foreach ($allAppointments as $apt) {
        echo "   - Appointment ID: {$apt->id}, Patient ID: {$apt->patient_id}, Date: {$apt->date}, Status: {$apt->status}\n";

        // Check if patient record exists
        $patientRecord = App\Models\Patients::find($apt->patient_id);
        if ($patientRecord) {
            $patientUser = App\Models\User::find($patientRecord->user_id);
            if ($patientUser) {
                echo "     Patient: {$patientUser->name}\n";
            } else {
                echo "     ❌ Patient user not found for patient record ID: {$patientRecord->id}\n";
            }
        } else {
            echo "     ❌ Patient record not found for patient_id: {$apt->patient_id}\n";
        }
    }
} else {
    echo "   ❌ No appointments found for this doctor\n";
}

// Check all appointments for this patient
echo "\n🔍 All appointments for patient '{$patient->name}':\n";
$patientAppointments = App\Models\Appointment::where('patient_id', $patientRecord->id)->with('doctor.user')->get();
if ($patientAppointments->count() > 0) {
    foreach ($patientAppointments as $apt) {
        $doctorName = $apt->doctor ? $apt->doctor->user->name : 'Unknown';
        echo "   - Doctor: {$doctorName}, Date: {$apt->date}, Status: {$apt->status}\n";
    }
} else {
    echo "   ❌ No appointments found for this patient\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
