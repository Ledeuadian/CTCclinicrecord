<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Course;
use App\Models\EducationalLevel;
use Illuminate\Support\Facades\DB;

class AdminReports extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get statistics by course
        $byCourse = DB::table('patients')
            ->join('courses', 'patients.course_id', '=', 'courses.id')
            ->select('courses.course_name', DB::raw('COUNT(*) as total_patients'))
            ->groupBy('courses.course_name')
            ->orderBy('total_patients', 'desc')
            ->get();

        // Get statistics by educational level
        $byEducationalLevel = DB::table('patients')
            ->join('educational_level', 'patients.edulvl_id', '=', 'educational_level.id')
            ->select('educational_level.level_name', DB::raw('COUNT(*) as total_patients'))
            ->groupBy('educational_level.level_name')
            ->orderBy('total_patients', 'desc')
            ->get();

        // Total patients
        $totalPatients = Patients::count();

        return view('admin.reports.index', compact('byCourse', 'byEducationalLevel', 'totalPatients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
