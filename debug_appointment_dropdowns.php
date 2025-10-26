<?php

echo "=== DEBUGGING APPOINTMENT DROPDOWNS ===\n\n";

try {
    $pdo = new PDO('sqlite:database/database.sqlite');

    echo "1. CHECKING DATABASE RECORDS:\n";

    // Check patients count
    $patientsCount = $pdo->query("SELECT COUNT(*) as count FROM patients")->fetch(PDO::FETCH_ASSOC);
    echo "   Total patients: {$patientsCount['count']}\n";

    // Check doctors count
    $doctorsCount = $pdo->query("SELECT COUNT(*) as count FROM doctors")->fetch(PDO::FETCH_ASSOC);
    echo "   Total doctors: {$doctorsCount['count']}\n";

    // Check users count
    $usersCount = $pdo->query("SELECT COUNT(*) as count FROM users")->fetch(PDO::FETCH_ASSOC);
    echo "   Total users: {$usersCount['count']}\n";

    echo "\n2. CHECKING PATIENT-USER RELATIONSHIPS:\n";

    // Check patients with valid user relationships
    $patientsWithUsers = $pdo->query("
        SELECT COUNT(*) as count
        FROM patients p
        JOIN users u ON p.user_id = u.id
    ")->fetch(PDO::FETCH_ASSOC);
    echo "   Patients with valid user relationships: {$patientsWithUsers['count']}\n";

    // Check users by type for patients
    $usersByType = $pdo->query("
        SELECT u.user_type, COUNT(*) as count
        FROM patients p
        JOIN users u ON p.user_id = u.id
        GROUP BY u.user_type
    ")->fetchAll(PDO::FETCH_ASSOC);

    echo "   Patient users by type:\n";
    foreach ($usersByType as $userType) {
        echo "     - User type {$userType['user_type']}: {$userType['count']} patients\n";
    }

    echo "\n3. CHECKING DOCTOR-USER RELATIONSHIPS:\n";

    // Check doctors with valid user relationships
    $doctorsWithUsers = $pdo->query("
        SELECT COUNT(*) as count
        FROM doctors d
        JOIN users u ON d.user_id = u.id
    ")->fetch(PDO::FETCH_ASSOC);
    echo "   Doctors with valid user relationships: {$doctorsWithUsers['count']}\n";

    echo "\n4. SAMPLE DATA:\n";

    // Show sample patients
    $samplePatients = $pdo->query("
        SELECT p.id, u.name, p.patient_type, u.user_type
        FROM patients p
        JOIN users u ON p.user_id = u.id
        WHERE u.user_type IN (1, 2)
        LIMIT 3
    ")->fetchAll(PDO::FETCH_ASSOC);

    echo "   Sample patients (user_type 1,2):\n";
    foreach ($samplePatients as $patient) {
        echo "     - ID: {$patient['id']}, Name: {$patient['name']}, Type: {$patient['patient_type']}, User Type: {$patient['user_type']}\n";
    }

    // Show sample doctors
    $sampleDoctors = $pdo->query("
        SELECT d.id, u.name, d.specialization
        FROM doctors d
        JOIN users u ON d.user_id = u.id
        LIMIT 3
    ")->fetchAll(PDO::FETCH_ASSOC);

    echo "   Sample doctors:\n";
    foreach ($sampleDoctors as $doctor) {
        echo "     - ID: {$doctor['id']}, Name: {$doctor['name']}, Specialization: {$doctor['specialization']}\n";
    }

    echo "\n✅ Database check completed!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
