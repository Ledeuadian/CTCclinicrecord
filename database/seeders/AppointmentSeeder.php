<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::create([
            'patient_id' => '1',
            'date' => '2024-10-20',
            'time' => '10:00',
            'doc_id' => '2',
            'status' => 'Confirmed',
        ]);
    }
}
