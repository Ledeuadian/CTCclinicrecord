@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Add New Patient</h1>
                <p class="text-gray-600">Create a new patient record</p>
            </div>
            <a href="{{ route('staff.patients') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                ← Back to Patients
            </a>
        </div>

        <form action="{{ route('staff.patients.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Account Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Account Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                               required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                </div>
            </div>

            <!-- Patient Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Patient Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label for="patient_type" class="block text-sm font-medium text-gray-700 mb-2">Patient Type *</label>
                        <select name="patient_type" id="patient_type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('patient_type') border-red-500 @enderror"
                                required>
                            <option value="">Select Type...</option>
                            <option value="1" {{ old('patient_type') == '1' ? 'selected' : '' }}>Student</option>
                            <option value="2" {{ old('patient_type') == '2' ? 'selected' : '' }}>Faculty & Staff</option>
                        </select>
                        @error('patient_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="school_id" class="block text-sm font-medium text-gray-700 mb-2">School ID</label>
                        <input type="text" name="school_id" id="school_id" value="{{ old('school_id') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="bloodtype" class="block text-sm font-medium text-gray-700 mb-2">Blood Type</label>
                        <select name="bloodtype" id="bloodtype"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Blood Type...</option>
                            <option value="A+" {{ old('bloodtype') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('bloodtype') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('bloodtype') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('bloodtype') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('bloodtype') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('bloodtype') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('bloodtype') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('bloodtype') == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Medical Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="medical_condition" class="block text-sm font-medium text-gray-700 mb-2">Medical Conditions</label>
                        <textarea name="medical_condition" id="medical_condition" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="e.g., Asthma, Diabetes...">{{ old('medical_condition') }}</textarea>
                    </div>
                    <div>
                        <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                        <textarea name="allergies" id="allergies" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="e.g., Penicillin, Peanuts...">{{ old('allergies') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Emergency Contact</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">Contact Name</label>
                        <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ old('emergency_contact_name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="emergency_contact_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="emergency_contact_number" id="emergency_contact_number" value="{{ old('emergency_contact_number') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="emergency_relationship" class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                        <input type="text" name="emergency_relationship" id="emergency_relationship" value="{{ old('emergency_relationship') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., Parent, Spouse">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('staff.patients') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-medium transition">
                    Create Patient
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
