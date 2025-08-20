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
    public function updateWithType(Request $request, $id, $type)
    {
        // Find the user by ID
        if ($type == 1){
            $admin = User::findOrFail($id);
        } else if($type == 2){
            $admin = Admin::findOrFail($id);
        }
        //
        return view('admin.users.edit', compact('admin'));
    }

    /**
     * Remove the 2 argument specified resource from storage.
     */

    public function deleteWithType(Request $request, $id, $type)
    {
        // Find the user by ID
        if ($type == 1){
            // Find and delete the User model
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
        } else if($type  == 2){
            // Find and delete the Admin model
            $user = Admin::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'Admin deleted successfully');
        }
    }
}
