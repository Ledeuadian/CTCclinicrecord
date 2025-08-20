<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed educational levels first
        $this->call(EducationalLevelSeeder::class);
        
        // Create specific test accounts

        // Admin account
        \App\Models\Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@ckc.edu',
            'password' => bcrypt('password123'),
            'user_type' => 2, // Admin type
            'f_name' => 'Admin',
            'm_name' => 'System',
            'l_name' => 'User',
            'dob' => '1990-01-01',
            'address' => 'CKC Campus',
            'gender' => 'Male',
            'contact_no' => '09123456789',
        ]);

        // Doctor account
        User::factory()->create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor@ckc.edu',
            'user_type' => 3, // Doctor
            'password' => bcrypt('password123'),
            'f_name' => 'John',
            'm_name' => 'Medical',
            'l_name' => 'Smith',
            'dob' => '1985-05-15',
            'address' => 'CKC Medical Center',
            'gender' => 'Male',
            'contact_no' => '09123456790',
        ]);

        // Staff account
        User::factory()->create([
            'name' => 'Jane Staff',
            'email' => 'staff@ckc.edu',
            'user_type' => 2, // Staff
            'password' => bcrypt('password123'),
            'f_name' => 'Jane',
            'm_name' => 'Office',
            'l_name' => 'Staff',
            'dob' => '1992-08-20',
            'address' => 'CKC Administration',
            'gender' => 'Female',
            'contact_no' => '09123456791',
        ]);

        // Student account
        User::factory()->create([
            'name' => 'John Student',
            'email' => 'student@ckc.edu',
            'user_type' => 1, // Student
            'password' => bcrypt('password123'),
            'f_name' => 'John',
            'm_name' => 'Academic',
            'l_name' => 'Student',
            'dob' => '2000-12-10',
            'address' => 'CKC Dormitory',
            'gender' => 'Male',
            'contact_no' => '09123456792',
        ]);

        // Create some additional test users
        User::factory(3)->create();
    }
}
