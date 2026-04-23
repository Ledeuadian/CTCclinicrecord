<?php
// Database connection
$host = '127.0.0.1';
$dbname = 'ckc_shrms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    echo "=== USERS TABLE ===\n";
    echo "-------------------\n";
    
    $users = $pdo->query("SELECT id, email, password, user_type, name, f_name, m_name, l_name FROM users LIMIT 20");
    foreach ($users as $user) {
        echo "ID: {$user['id']}\n";
        echo "Email: {$user['email']}\n";
        echo "Password (hashed): {$user['password']}\n";
        echo "Type: {$user['user_type']}\n";
        echo "Name: {$user['name']} " . trim("{$user['f_name']} {$user['m_name']} {$user['l_name']}") . "\n";
        echo "---\n";
    }
    
    echo "\n=== ADMINS TABLE ===\n";
    echo "-------------------\n";
    
    $admins = $pdo->query("SELECT id, email, password, name, f_name, m_name, l_name FROM admins LIMIT 10");
    foreach ($admins as $admin) {
        echo "ID: {$admin['id']}\n";
        echo "Email: {$admin['email']}\n";
        echo "Password (hashed): {$admin['password']}\n";
        echo "Name: {$admin['name']} " . trim("{$admin['f_name']} {$admin['m_name']} {$admin['l_name']}") . "\n";
        echo "---\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}