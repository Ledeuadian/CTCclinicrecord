<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Models\User;
use App\Models\Doctors;
use App\Models\Patients;
use App\Models\HealthRecords;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

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

        // Statistics by course
        $byCourse = DB::table('patients')
            ->join('courses', 'patients.course_id', '=', 'courses.id')
            ->select('courses.id', 'courses.course_name', DB::raw('COUNT(*) as total_patients'))
            ->groupBy('courses.id', 'courses.course_name')
            ->orderBy('total_patients', 'desc')
            ->get();

        // Statistics by educational level
        $byEducationalLevel = DB::table('patients')
            ->join('educational_level', 'patients.edulvl_id', '=', 'educational_level.id')
            ->select('educational_level.id', 'educational_level.level_name', DB::raw('COUNT(*) as total_patients'))
            ->groupBy('educational_level.id', 'educational_level.level_name')
            ->orderBy('total_patients', 'desc')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments', 'byCourse', 'byEducationalLevel'));
    }
}
