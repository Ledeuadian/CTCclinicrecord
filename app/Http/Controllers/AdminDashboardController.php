<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Models\User;
use App\Models\Doctors;
use App\Models\Patients;
use App\Models\HealthRecords;
use App\Models\Appointment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $stats = [
            'totalUsers' => User::count(),
            'totalDoctors' => User::where('user_type', 3)->count(),
            'totalPatients' => Patients::count(),
            'totalHealthRecords' => HealthRecords::count(),
            'totalAppointments' => Appointment::count(),
            'pendingAppointments' => Appointment::where('status', 'Pending')->count(),
            'todayAppointments' => Appointment::where('date', now()->toDateString())->count(),
        ];

        // Recent appointments
        $recentAppointments = Appointment::with(['patient.user', 'doctor'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments'));
    }
}
