<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\User;
use App\Models\EducationalLevel;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminPatients extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $patients = Patients::join('educational_level', 'educational_level.id', '=', 'patients.edulvl_id')
            ->leftJoin('users as u', function($join) {
                $join->on('u.id', '=', 'patients.user_id')
                    ->where('patients.patient_type', 1)
                    ->whereIn('u.user_type', [1, 2]); // Only students and staff, exclude doctors
            })
            ->leftJoin('admins as a', function($join) {
                $join->on('a.id', '=', 'patients.user_id')
                    ->where('patients.patient_type', 2)
                    ->whereIn('a.user_type', [1, 2]); // Only students and staff, exclude doctors
            })
            ->join('users as user_filter', 'user_filter.id', '=', 'patients.user_id')
            ->whereIn('user_filter.user_type', [1, 2]) // Global filter to exclude doctors
            ->select(
                'patients.*',
                DB::raw("CASE WHEN patients.patient_type = 1 THEN u.name ELSE a.name END as name"),
                'educational_level.level_name',
                'educational_level.year_level'
            )
            ->get();
        //
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Only get users with user_type 1 (Students) or 2 (Staff), exclude 3 (Doctors)
        $user = User::whereIn('user_type', [1, 2])->get()->toArray();
        $admin = Admin::where('user_type', 2)->get()->toArray(); // Admins are typically type 2
        $edulvl = EducationalLevel::all();

        $users = collect(array_merge($user, $admin));

        return view('admin.patients.create', compact('users', 'edulvl'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'patient_type' => 'required',
            'edulvl_id' => 'required',
            'user_id' => 'required',
            'school_id' => 'required',
            'address' => 'required',
            'medical_condition' => 'required',
            'medical_illness' => 'required',
            'operations' => 'required',
            'allergies' => 'required',
            'emergency_contact_name' => 'required',
            'emergency_contact_number' => 'required',
            'emergency_relationship' => 'required',
        ]);

        // Check if the combination of user_id and patient_type already exists
        $patientExists = \DB::table('patients')
        ->where('user_id', $request->user_id)
        ->where('patient_type', $request->patient_type)
        ->exists();

        // If the combination already exists, return an error
        if ($patientExists) {
            return redirect()->back()->withErrors([
                'user_id' => 'A patient with this user_id and patient_type already exists.'
            ])->withInput();
        }

        // Create a new patient
        Patients::create([
            'patient_type' => $request->patient_type,
            'edulvl_id' => $request->edulvl_id,
            'user_id' => $request->user_id,
            'school_id' => $request->school_id,
            'address' => $request->address,
            'medical_condition' => $request->medical_condition,
            'medical_illness' => $request->medical_illness,
            'operations' => $request->operations,
            'allergies' => $request->allergies,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'emergency_relationship' => $request->emergency_relationship,
        ]);

        //
        return redirect()->route('admin.patients.create')->with('success','Patients created successfully!');
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
        // Only get users with user_type 1 (Students) or 2 (Staff), exclude 3 (Doctors)
        $user = User::whereIn('user_type', [1, 2])->get()->toArray();
        $admin = Admin::where('user_type', 2)->get()->toArray(); // Admins are typically type 2
        $edulvl = EducationalLevel::all();

        $users = collect(array_merge($user, $admin));

        //
        $patients = Patients::where('patients.id', $id)
            ->leftJoin('users as u', function ($join) {
                $join->on('u.id', '=', 'patients.user_id')
                    ->where('patients.patient_type', 1);
            })
            ->leftJoin('admins as a', function ($join) {
                $join->on('a.id', '=', 'patients.user_id')
                    ->where('patients.patient_type', 2);
            })
            ->join('educational_level', 'educational_level.id', '=', 'patients.edulvl_id')
            ->select(
                'patients.*',
                DB::raw("CASE WHEN patients.patient_type = 1 THEN u.name ELSE a.name END as name"),
                'educational_level.level_name',
                'educational_level.year_level'
            )
            ->first(); // Using first() instead of firstOrFail()


        //
        return view('admin.patients.edit', compact('patients','users','edulvl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'patient_type' => 'required',
            'edulvl_id' => 'required',
            'user_id' => 'required',
            'school_id' => 'required',
            'address' => 'required',
            'medical_condition' => 'required',
            'medical_illness' => 'required',
            'operations' => 'required',
            'allergies' => 'required',
            'emergency_contact_name' => 'required',
            'emergency_contact_number' => 'required',
            'emergency_relationship' => 'required',
        ]);

        // Find the patient by ID
        $patients = Patients::findOrFail($id);

        // Update the patient details
        $patients->patient_type = $request->input('patient_type');
        $patients->edulvl_id = $request->input('edulvl_id');
        $patients->user_id = $request->input('user_id');
        $patients->school_id = $request->input('school_id');
        $patients->address = $request->input('address');
        $patients->medical_condition = $request->input('medical_condition');
        $patients->medical_illness = $request->input('medical_illness');
        $patients->operations = $request->input('operations');
        $patients->allergies = $request->input('allergies');
        $patients->emergency_contact_name = $request->input('emergency_contact_name');
        $patients->emergency_contact_number = $request->input('emergency_contact_number');
        $patients->emergency_relationship = $request->input('emergency_relationship');

        // Save the updated patients
        $patients->save();

        // Redirect back with a success message
        return redirect()->route('admin.patients.index')->with('success','Patient updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patients $patient)
    {
        //
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully!');
    }
}
