<?php

namespace App\Http\Controllers;
use App\Models\Doctors;
use Illuminate\Http\Request;
use App\Models\User;

class AdminDoctor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $doctors = Doctors::with('user')->get();

        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // User Type = 3 for Doctors
        $users = User::where('user_type','=','3')
        ->get();
        return view('admin.doctors.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|unique:doctors',
            'specialization' => 'required',
            'address' => 'required',
        ]);

        // Create a new doctor
        Doctors::create([
            'user_id' => $request->user_id,
            'specialization' => $request->specialization,
            'address' => $request->address,
        ]);

        // Redirect back to doctor create with a success message
        return redirect()->route('admin.doctors.create')->with('success', 'Doctor created successfully!');
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
        $doctors = Doctors::findOrFail($id);
        // User Type = 3 for Doctors
        $users = User::where('user_type','=','3')
        ->get();
        //
        return view('admin.doctors.edit', compact('doctors','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'user_id' => 'required',
            'specialization' => 'required',
            'address' => 'required',
            'is_available' => 'required',
        ]);

        // Find the doctor by ID
        $doctor = Doctors::findOrFail($id);

        // Update the doctor details
        $doctor->user_id = $request->input('user_id');
        $doctor->specialization = $request->input('specialization');
        $doctor->address = $request->input('address');
        $doctor->is_available = $request->input('is_available');

        // Save the updated doctor
        $doctor->save();

        // Redirect back with a success message
        return redirect()->route('admin.doctors.index')->with('success','Doctor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctors $doctor)
    {
        //
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully!');
    }
}
