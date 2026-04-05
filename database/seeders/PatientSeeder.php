<?php

namespace Database\Seeders;

use App\Models\Patients;
use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        // Get student users
        $students = User::where('user_type', 1)->get();

        foreach ($students as $student) {
            Patients::create([
                'school_id' => 'STU' . str_pad($student->id, 5, '0', STR_PAD_LEFT),
                'patient_type' => 1, // Student
                'edulvl_id' => rand(1, 6), // Random grade level
                'user_id' => $student->id,
                'address' => $student->address,
                'medical_condition' => ['Diabetes', 'Asthma', 'Hypertension', 'None'][rand(0, 3)],
                'medical_illness' => ['Flu', 'Allergies', 'Migraine', 'None'][rand(0, 3)],
                'operations' => ['Appendectomy', 'Tonsillectomy', 'None'][rand(0, 2)],
                'allergies' => ['Penicillin', 'Peanuts', 'Shellfish', 'None'][rand(0, 3)],
                'emergency_contact_name' => $student->f_name . ' ' . $student->l_name . ' (Parent)',
                'emergency_contact_number' => '09' . rand(100000000, 999999999),
                'emergency_relationship' => 'Parent',
            ]);
        }
    }
}
