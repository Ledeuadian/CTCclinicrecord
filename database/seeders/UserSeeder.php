<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 0, // Admin
            'f_name' => 'Admin',
            'm_name' => 'System',
            'l_name' => 'User',
            'dob' => '1990-01-01',
            'address' => 'CKC Campus, Building A',
            'gender' => 'M',
            'contact_no' => '09123456789',
        ]);

        // Doctor users
        User::create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor1@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 3, // Doctor
            'f_name' => 'John',
            'm_name' => 'Medical',
            'l_name' => 'Smith',
            'dob' => '1985-05-15',
            'address' => 'CKC Medical Center',
            'gender' => 'M',
            'contact_no' => '09123456790',
        ]);

        User::create([
            'name' => 'Dr. Maria Santos',
            'email' => 'doctor2@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 3, // Doctor
            'f_name' => 'Maria',
            'm_name' => 'Rosa',
            'l_name' => 'Santos',
            'dob' => '1988-03-20',
            'address' => 'CKC Medical Center',
            'gender' => 'F',
            'contact_no' => '09223456790',
        ]);

        // Staff/Faculty users
        User::create([
            'name' => 'Jane Staff',
            'email' => 'staff@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 2, // Staff
            'f_name' => 'Jane',
            'l_name' => 'Staff',
            'm_name' => 'Office',
            'dob' => '1992-08-20',
            'address' => 'CKC Administration',
            'gender' => 'F',
            'contact_no' => '09123456791',
        ]);

        // Student users
        User::create([
            'name' => 'John Student',
            'email' => 'student1@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 1, // Student
            'f_name' => 'John',
            'm_name' => 'Academic',
            'l_name' => 'Student',
            'dob' => '2000-12-10',
            'address' => 'CKC Dormitory B',
            'gender' => 'M',
            'contact_no' => '09123456792',
        ]);

        User::create([
            'name' => 'Maria Garcia',
            'email' => 'student2@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 1, // Student
            'f_name' => 'Maria',
            'm_name' => 'Elena',
            'l_name' => 'Garcia',
            'dob' => '2001-06-15',
            'address' => 'CKC Dormitory C',
            'gender' => 'F',
            'contact_no' => '09223456792',
        ]);

        User::create([
            'name' => 'Pedro Cruz',
            'email' => 'student3@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 1, // Student
            'f_name' => 'Pedro',
            'm_name' => 'Antonio',
            'l_name' => 'Cruz',
            'dob' => '2000-09-22',
            'address' => 'CKC Dormitory A',
            'gender' => 'M',
            'contact_no' => '09323456792',
        ]);

        User::create([
            'name' => 'Ana Lopez',
            'email' => 'student4@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 1, // Student
            'f_name' => 'Ana',
            'm_name' => 'Marie',
            'l_name' => 'Lopez',
            'dob' => '2001-02-18',
            'address' => 'CKC Dormitory B',
            'gender' => 'F',
            'contact_no' => '09423456792',
        ]);

        User::create([
            'name' => 'Carlos Reyes',
            'email' => 'student5@ckc.edu',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'user_type' => 1, // Student
            'f_name' => 'Carlos',
            'm_name' => 'David',
            'l_name' => 'Reyes',
            'dob' => '2000-11-30',
            'address' => 'CKC Dormitory C',
            'gender' => 'M',
            'contact_no' => '09523456792',
        ]);
    }
}
