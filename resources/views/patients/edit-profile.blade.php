@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">Edit Profile</h1>
            <p class="text-gray-600">Update your personal and medical information</p>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patients.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" required
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="patient_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Patient Type <span class="text-red-500">*</span>
                            </label>
                            <select name="patient_type" id="patient_type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select patient type...</option>
                                <option value="student" {{ old('patient_type', $patients->patient_type) == 'student' ? 'selected' : '' }}>Student</option>
                                <option value="staff" {{ old('patient_type', $patients->patient_type) == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="faculty" {{ old('patient_type', $patients->patient_type) == 'faculty' ? 'selected' : '' }}>Faculty</option>
                                <option value="external" {{ old('patient_type', $patients->patient_type) == 'external' ? 'selected' : '' }}>External</option>
                            </select>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" id="address" rows="3" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $patients->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Medical Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Medical Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="medical_condition" class="block text-sm font-medium text-gray-700 mb-2">
                                Medical Conditions (Optional)
                            </label>
                            <textarea name="medical_condition" id="medical_condition" rows="2"
                                      placeholder="List any ongoing medical conditions..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('medical_condition', $patients->medical_condition) }}</textarea>
                        </div>

                        <div>
                            <label for="medical_illness" class="block text-sm font-medium text-gray-700 mb-2">
                                Medical Illness History (Optional)
                            </label>
                            <textarea name="medical_illness" id="medical_illness" rows="2"
                                      placeholder="List any past illnesses..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('medical_illness', $patients->medical_illness) }}</textarea>
                        </div>

                        <div>
                            <label for="operations" class="block text-sm font-medium text-gray-700 mb-2">
                                Previous Operations (Optional)
                            </label>
                            <textarea name="operations" id="operations" rows="2"
                                      placeholder="List any previous operations or surgeries..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('operations', $patients->operations) }}</textarea>
                        </div>

                        <div>
                            <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">
                                Allergies (Optional)
                            </label>
                            <textarea name="allergies" id="allergies" rows="2"
                                      placeholder="List any known allergies (food, medication, environmental)..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('allergies', $patients->allergies) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Emergency Contact</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="emergency_contact_name" id="emergency_contact_name" required
                                   value="{{ old('emergency_contact_name', $patients->emergency_contact_name) }}"
                                   placeholder="Full name of emergency contact"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="emergency_contact_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="emergency_contact_number" id="emergency_contact_number" required
                                   value="{{ old('emergency_contact_number', $patients->emergency_contact_number) }}"
                                   placeholder="Phone number of emergency contact"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="emergency_relationship" class="block text-sm font-medium text-gray-700 mb-2">
                                Relationship <span class="text-red-500">*</span>
                            </label>
                            <select name="emergency_relationship" id="emergency_relationship" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select relationship...</option>
                                <option value="Parent" {{ old('emergency_relationship', $patients->emergency_relationship) == 'Parent' ? 'selected' : '' }}>Parent</option>
                                <option value="Guardian" {{ old('emergency_relationship', $patients->emergency_relationship) == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                                <option value="Spouse" {{ old('emergency_relationship', $patients->emergency_relationship) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                <option value="Sibling" {{ old('emergency_relationship', $patients->emergency_relationship) == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                <option value="Relative" {{ old('emergency_relationship', $patients->emergency_relationship) == 'Relative' ? 'selected' : '' }}>Relative</option>
                                <option value="Friend" {{ old('emergency_relationship', $patients->emergency_relationship) == 'Friend' ? 'selected' : '' }}>Friend</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between pt-6">
                    <a href="{{ route('patients.profile') }}"
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
