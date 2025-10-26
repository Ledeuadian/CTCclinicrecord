<?php

echo "=== DEBUGGING USER_ID ERROR ===\n\n";

try {
    $pdo = new PDO('sqlite:database/database.sqlite');

    // Check physical_examinations table structure
    echo "1. Physical Examinations Table Structure:\n";
    $columns = $pdo->query("PRAGMA table_info(physical_examinations)")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "  - {$column['name']} ({$column['type']})\n";
    }

    // Check if user_id still exists
    $hasUserId = false;
    $hasPatientId = false;
    foreach ($columns as $column) {
        if ($column['name'] === 'user_id') $hasUserId = true;
        if ($column['name'] === 'patient_id') $hasPatientId = true;
    }

    echo "\n2. Column Status:\n";
    echo "  - user_id exists: " . ($hasUserId ? "YES" : "NO") . "\n";
    echo "  - patient_id exists: " . ($hasPatientId ? "YES" : "NO") . "\n";

    // Check foreign keys
    echo "\n3. Foreign Keys:\n";
    $foreignKeys = $pdo->query("PRAGMA foreign_key_list(physical_examinations)")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($foreignKeys as $fk) {
        echo "  - {$fk['from']} -> {$fk['table']}.{$fk['to']}\n";
    }

    // Check if there are any records in physical_examinations
    echo "\n4. Records in physical_examinations:\n";
    $count = $pdo->query("SELECT COUNT(*) as count FROM physical_examinations")->fetch(PDO::FETCH_ASSOC);
    echo "  - Total records: {$count['count']}\n";

    if ($count['count'] > 0) {
        $sample = $pdo->query("SELECT * FROM physical_examinations LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
        echo "  - Sample records:\n";
        foreach ($sample as $record) {
            echo "    ID: {$record['id']}, patient_id: " . (isset($record['patient_id']) ? $record['patient_id'] : 'NULL') .
                 ", doctor_id: " . (isset($record['doctor_id']) ? $record['doctor_id'] : 'NULL') . "\n";
        }
    }

    echo "\n✅ Database structure check completed\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
