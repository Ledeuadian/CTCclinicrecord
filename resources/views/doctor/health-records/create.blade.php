@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Create Health Record</h1>
                    <p class="text-gray-600">Add a new health record for your patient</p>
                </div>
                <a href="{{ route('doctor.health-records') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
                    Back to Health Records
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('doctor.health-records.store') }}" method="POST" id="healthRecordForm">
                @csrf

                <!-- Patient Selection -->
                <div class="mb-6">
                    <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-900">Patient *</label>
                    <select name="patient_id" id="patient_id" 
                            class="block py-2.5 px-3 w-full text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                            required>
                        <option value="" disabled selected>Select a patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} (ID: {{ $patient->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Record Type Selection -->
                <div class="mb-6">
                    <label for="record_type" class="block mb-2 text-sm font-medium text-gray-900">Record Type *</label>
                    <select name="record_type" id="record_type" 
                            class="block py-2.5 px-3 w-full text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                            required onchange="toggleRecordFields()">
                        <option value="" disabled selected>Select record type</option>
                        <option value="physical" {{ old('record_type') == 'physical' ? 'selected' : '' }}>Physical Examination</option>
                        <option value="dental" {{ old('record_type') == 'dental' ? 'selected' : '' }}>Dental Examination</option>
                        <option value="immunization" {{ old('record_type') == 'immunization' ? 'selected' : '' }}>Immunization Record</option>
                    </select>
                    @error('record_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Physical Examination Fields -->
                <div id="physical_fields" class="record-fields" style="display: none;">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Physical Examination Details</h3>
                    
                    <!-- Vital Signs -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label for="height" class="block mb-2 text-sm font-medium text-gray-900">Height (cm)</label>
                            <input type="number" step="0.1" name="height" id="height" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('height') }}" placeholder="170.5">
                        </div>
                        <div>
                            <label for="weight" class="block mb-2 text-sm font-medium text-gray-900">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight" id="weight" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('weight') }}" placeholder="65.0">
                        </div>
                        <div>
                            <label for="bp" class="block mb-2 text-sm font-medium text-gray-900">Blood Pressure</label>
                            <input type="text" name="bp" id="bp" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('bp') }}" placeholder="120/80">
                        </div>
                    </div>

                    <!-- Examination Areas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="heart" class="block mb-2 text-sm font-medium text-gray-900">Heart</label>
                            <input type="text" name="heart" id="heart" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('heart') }}" placeholder="Regular rhythm, no murmurs">
                        </div>
                        <div>
                            <label for="lungs" class="block mb-2 text-sm font-medium text-gray-900">Lungs</label>
                            <input type="text" name="lungs" id="lungs" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('lungs') }}" placeholder="Clear to auscultation">
                        </div>
                        <div>
                            <label for="eyes" class="block mb-2 text-sm font-medium text-gray-900">Eyes</label>
                            <input type="text" name="eyes" id="eyes" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('eyes') }}" placeholder="Normal appearance">
                        </div>
                        <div>
                            <label for="ears" class="block mb-2 text-sm font-medium text-gray-900">Ears</label>
                            <input type="text" name="ears" id="ears" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('ears') }}" placeholder="Normal hearing">
                        </div>
                        <div>
                            <label for="nose" class="block mb-2 text-sm font-medium text-gray-900">Nose</label>
                            <input type="text" name="nose" id="nose" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('nose') }}" placeholder="No congestion">
                        </div>
                        <div>
                            <label for="throat" class="block mb-2 text-sm font-medium text-gray-900">Throat</label>
                            <input type="text" name="throat" id="throat" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('throat') }}" placeholder="No inflammation">
                        </div>
                        <div>
                            <label for="skin" class="block mb-2 text-sm font-medium text-gray-900">Skin</label>
                            <input type="text" name="skin" id="skin" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('skin') }}" placeholder="Normal color and texture">
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="mb-6">
                        <label for="remarks" class="block mb-2 text-sm font-medium text-gray-900">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="4" 
                                  class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Additional notes and observations...">{{ old('remarks') }}</textarea>
                    </div>
                </div>

                <!-- Dental Examination Fields -->
                <div id="dental_fields" class="record-fields" style="display: none;">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Dental Examination Details</h3>
                    
                    <div class="mb-6">
                        <label for="diagnosis" class="block mb-2 text-sm font-medium text-gray-900">Diagnosis</label>
                        <textarea name="diagnosis" id="diagnosis" rows="4" 
                                  class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Dental diagnosis and findings...">{{ old('diagnosis') }}</textarea>
                    </div>

                    <!-- Teeth Status Grid -->
                    <div class="mb-6">
                        <label class="block mb-4 text-sm font-medium text-gray-900">Teeth Status</label>
                        <div class="grid grid-cols-8 gap-2 p-4 bg-gray-50 rounded-lg">
                            @for($i = 1; $i <= 32; $i++)
                                <div class="text-center">
                                    <label for="tooth_{{ $i }}" class="text-xs text-gray-600">{{ $i }}</label>
                                    <select name="teeth_status[{{ $i }}]" id="tooth_{{ $i }}" 
                                            class="block w-full text-xs bg-white border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">-</option>
                                        <option value="healthy" {{ (old('teeth_status.' . $i) == 'healthy') ? 'selected' : '' }}>✓</option>
                                        <option value="cavity" {{ (old('teeth_status.' . $i) == 'cavity') ? 'selected' : '' }}>C</option>
                                        <option value="filled" {{ (old('teeth_status.' . $i) == 'filled') ? 'selected' : '' }}>F</option>
                                        <option value="missing" {{ (old('teeth_status.' . $i) == 'missing') ? 'selected' : '' }}>X</option>
                                        <option value="crown" {{ (old('teeth_status.' . $i) == 'crown') ? 'selected' : '' }}>Cr</option>
                                    </select>
                                </div>
                            @endfor
                        </div>
                        <div class="mt-2 text-xs text-gray-600">
                            Legend: ✓ = Healthy, C = Cavity, F = Filled, X = Missing, Cr = Crown
                        </div>
                    </div>
                </div>

                <!-- Immunization Fields -->
                <div id="immunization_fields" class="record-fields" style="display: none;">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Immunization Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="vaccine_name" class="block mb-2 text-sm font-medium text-gray-900">Vaccine Name *</label>
                            <input type="text" name="vaccine_name" id="vaccine_name" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('vaccine_name') }}" placeholder="COVID-19, Hepatitis B, etc.">
                        </div>
                        <div>
                            <label for="vaccine_type" class="block mb-2 text-sm font-medium text-gray-900">Vaccine Type</label>
                            <input type="text" name="vaccine_type" id="vaccine_type" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('vaccine_type') }}" placeholder="mRNA, Inactivated, etc.">
                        </div>
                        <div>
                            <label for="dosage" class="block mb-2 text-sm font-medium text-gray-900">Dosage</label>
                            <input type="text" name="dosage" id="dosage" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('dosage') }}" placeholder="0.5 mL, 1st dose, etc.">
                        </div>
                        <div>
                            <label for="site_of_administration" class="block mb-2 text-sm font-medium text-gray-900">Site of Administration</label>
                            <select name="site_of_administration" id="site_of_administration" 
                                    class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select site</option>
                                <option value="Left arm" {{ old('site_of_administration') == 'Left arm' ? 'selected' : '' }}>Left arm</option>
                                <option value="Right arm" {{ old('site_of_administration') == 'Right arm' ? 'selected' : '' }}>Right arm</option>
                                <option value="Left thigh" {{ old('site_of_administration') == 'Left thigh' ? 'selected' : '' }}>Left thigh</option>
                                <option value="Right thigh" {{ old('site_of_administration') == 'Right thigh' ? 'selected' : '' }}>Right thigh</option>
                                <option value="Oral" {{ old('site_of_administration') == 'Oral' ? 'selected' : '' }}>Oral</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="expiration_date" class="block mb-2 text-sm font-medium text-gray-900">Expiration Date</label>
                            <input type="date" name="expiration_date" id="expiration_date" 
                                   class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('expiration_date') }}">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900">Notes</label>
                        <textarea name="notes" id="notes" rows="4" 
                                  class="block w-full p-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Additional notes about the immunization...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('doctor.health-records') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Create Health Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleRecordFields() {
    const recordType = document.getElementById('record_type').value;
    const allFields = document.querySelectorAll('.record-fields');
    
    // Hide all field groups
    allFields.forEach(field => {
        field.style.display = 'none';
    });
    
    // Show selected field group
    if (recordType) {
        const targetFields = document.getElementById(recordType + '_fields');
        if (targetFields) {
            targetFields.style.display = 'block';
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleRecordFields();
});
</script>
@endsection