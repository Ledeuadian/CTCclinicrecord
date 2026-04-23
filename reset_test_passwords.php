<?php
// Reset all test account passwords to 'password123'

$host = '127.0.0.1';
$dbname = 'ckc_shrms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Hash the new password
    $newPassword = password_hash('password123', PASSWORD_BCRYPT);
    
    echo "Resetting passwords to 'password123'...\n\n";
    
    // Reset user accounts (from the USABLE_ACCOUNTS.md)
    $userEmails = [
        'admin@ckc.edu',      // Admin (user_type: 0)
        'doctor@ckc.edu',     // Doctor (user_type: 3) - Note: not in DB, using doctor1@ckc.edu
        'doctor1@ckc.edu',    // Doctor
        'doctor2@ckc.edu',    // Doctor
        'staff@ckc.edu',      // Staff (user_type: 2)
        'student@ckc.edu',    // Student (user_type: 1) - Note: not in DB, using student1@ckc.edu
        'student1@ckc.edu',   // Student
        'student2@ckc.edu',   // Student
        'student3@ckc.edu',   // Student
        'student4@ckc.edu',   // Student
        'student5@ckc.edu',   // Student
        'patient1@test.com',  // Patient/Student
        'natasha20@example.com',   // Doctor (random)
        'ernestine01@example.org', // Staff (random)
        'dolores.schmidt@example.com', // Student (random)
    ];
    
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
    $updatedUsers = 0;
    
    foreach ($userEmails as $email) {
        $stmt->execute([$newPassword, $email]);
        $count = $stmt->rowCount();
        if ($count > 0) {
            echo "✓ Updated: $email (users table)\n";
            $updatedUsers += $count;
        }
    }
    
    // Reset admin accounts
    $adminEmails = [
        'admin@ckc.edu',
    ];
    
    $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE email = ?");
    $updatedAdmins = 0;
    
    foreach ($adminEmails as $email) {
        $stmt->execute([$newPassword, $email]);
        $count = $stmt->rowCount();
        if ($count > 0) {
            echo "✓ Updated: $email (admins table)\n";
            $updatedAdmins += $count;
        }
    }
    
    echo "\n=== Summary ===\n";
    echo "Users updated: $updatedUsers\n";
    echo "Admins updated: $updatedAdmins\n";
    echo "\nAll test accounts now have password: password123\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}