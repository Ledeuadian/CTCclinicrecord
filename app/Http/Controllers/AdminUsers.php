<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUsers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $admin = Admin::all()->toArray();
        $user = User::all()->toArray();
        //
        $admins = collect(array_merge($admin,$user));
        //
        return view('admin.users.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'user_type' => 'required',
            'f_name' => 'required',
            'm_name' => 'required',
            'l_name' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'contact_no' => 'required',
            'email' => ['email', 'required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create regular user account for all user types (Student, Faculty & Staff, Doctor)
        User::create([
            'name' => $request->name,
            'user_type' => $request->user_type,
            'f_name' => $request->f_name,
            'm_name' => $request->m_name,
            'l_name' => $request->l_name,
            'dob' => $request->dob,
            'address' => $request->address,
            'gender' => $request->gender,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect
        return redirect()->route('admin.users.create')->with('success','User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the 2 argument of specified resource.
     */
    public function edit(Request $request, $id, $type)
    {
        // Find the user by ID - use User model for all types except Admin (0)
        if ($type == 0){
            $admin = Admin::findOrFail($id);
        } else {
            // Types 1 (Student), 2 (Faculty & Staff), 3 (Doctor) all use User model
            $admin = User::findOrFail($id);
        }
        //
        return view('admin.users.edit', compact('admin'));
    }

    /**
     * Remove the 2 argument specified resource from storage.
     */
    public function update(Request $request, $id, $type)
    {
        // Find the user by ID - use User model for all types except Admin (0)
        if ($type == 0){
            $admin = Admin::findOrFail($id);
        } else {
            // Types 1 (Student), 2 (Faculty & Staff), 3 (Doctor) all use User model
            $admin = User::findOrFail($id);
        }

        // Validation rules - password is optional for update
        $rules = [
            'name' => 'required|string|max:255',
            'user_type' => 'required|integer',
            'f_name' => 'required|string|max:255',
            'm_name' => 'nullable|string|max:255',
            'l_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'address' => 'nullable|string',
            'gender' => 'required|string|max:1',
            'contact_no' => 'nullable|string|max:20',
            'email' => $type == 0 ? 'required|email|unique:admins,email,' . $id : 'required|email|unique:users,email,' . $id,
        ];

        // Only validate password if it's being changed
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        // Update user fields
        $admin->name = $request->name;
        $admin->user_type = $request->user_type;
        $admin->f_name = $request->f_name;
        $admin->m_name = $request->m_name;
        $admin->l_name = $request->l_name;
        $admin->dob = $request->dob;
        $admin->address = $request->address;
        $admin->gender = $request->gender;
        $admin->contact_no = $request->contact_no;
        $admin->email = $request->email;

        // Only update password if provided
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        // Redirect with the NEW user_type to ensure the URL reflects the updated type
        return redirect()->route('admin.users.editWithType', ['user' => $admin->id, 'type' => $admin->user_type])->with('success', 'User updated successfully!');
    }

    /**
     * Remove the 2 argument specified resource from storage.
     */
    public function deleteWithType(Request $request, $id, $type)
    {
        // Find the user by ID
        if ($type == 0){
            // Find and delete the Admin model
            $user = Admin::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'Admin deleted successfully');
        } else {
            // Types 1, 2, 3 (Student, Staff, Doctor) all use User model
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
        }
    }
}
