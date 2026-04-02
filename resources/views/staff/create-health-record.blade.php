@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Staff Mode Indicator -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-blue-700 font-medium">Staff Mode - Creating Health Record</p>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Create New Health Record</h1>
                    <p class="text-gray-600">Add a new health record for a patient</p>
                </div>
                <a href="{{ route('staff.health-records') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Create Form -->
        <div class="bg-white shadow-sm rounded-lg">
            <form action="{{ route('staff.health-records.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Patient Selection -->
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Patient *
                        </label>
                        <select id="patient_id"
                                name="patient_id"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Select a Patient --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->name }}
                                    @if($patient->student_id)
                                        ({{ $patient->student_id }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Record Type Selection -->
                    <div>
                        <label for="record_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Record Type *
                        </label>
                        <select id="record_type"
                                name="record_type"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Select Record Type --</option>
                            <option value="physical" {{ old('record_type') == 'physical' ? 'selected' : '' }}>Physical Examination</option>
                            <option value="dental" {{ old('record_type') == 'dental' ? 'selected' : '' }}>Dental Examination</option>
                            <option value="immunization" {{ old('record_type') == 'immunization' ? 'selected' : '' }}>Immunization Record</option>
                        </select>
                        @error('record_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- General Health Record Fields -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">General Information</h3>

                        <!-- Diagnosis -->
                        <div class="mb-4">
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">
                                Diagnosis
                            </label>
                            <textarea id="diagnosis"
                                      name="diagnosis"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Enter diagnosis...">{{ old('diagnosis') }}</textarea>
                        </div>

                        <!-- Treatment -->
                        <div class="mb-4">
                            <label for="treatment" class="block text-sm font-medium text-gray-700 mb-2">
                                Treatment
                            </label>
                            <textarea id="treatment"
                                      name="treatment"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Enter treatment plan...">{{ old('treatment') }}</textarea>
                        </div>

                        <!-- Symptoms -->
                        <div class="mb-4">
                            <label for="symptoms" class="block text-sm font-medium text-gray-700 mb-2">
                                Symptoms
                            </label>
                            <textarea id="symptoms"
                                      name="symptoms"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Enter symptoms...">{{ old('symptoms') }}</textarea>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Additional Notes
                            </label>
                            <textarea id="notes"
                                      name="notes"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Enter any additional notes...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Physical Examination Fields (hidden by default) -->
                    <div id="physical_fields" class="hidden border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Physical Examination Details</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Height</label>
                                <input type="text" id="height" name="height" value="{{ old('height') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g., 170 cm">
                            </div>
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight</label>
                                <input type="text" id="weight" name="weight" value="{{ old('weight') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g., 65 kg">
                            </div>
                            <div>
                                <label for="bp" class="block text-sm font-medium text-gray-700 mb-2">Blood Pressure</label>
                                <input type="text" id="bp" name="bp" value="{{ old('bp') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g., 120/80">
                            </div>
                            <div>
                                <label for="heart" class="block text-sm font-medium text-gray-700 mb-2">Heart</label>
                                <input type="text" id="heart" name="heart" value="{{ old('heart') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Normal/Abnormal">
                            </div>
                            <div>
                                <label for="lungs" class="block text-sm font-medium text-gray-700 mb-2">Lungs</label>
                                <input type="text" id="lungs" name="lungs" value="{{ old('lungs') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="eyes" class="block text-sm font-medium text-gray-700 mb-2">Eyes</label>
                                <input type="text" id="eyes" name="eyes" value="{{ old('eyes') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="ears" class="block text-sm font-medium text-gray-700 mb-2">Ears</label>
                                <input type="text" id="ears" name="ears" value="{{ old('ears') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="nose" class="block text-sm font-medium text-gray-700 mb-2">Nose</label>
                                <input type="text" id="nose" name="nose" value="{{ old('nose') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="throat" class="block text-sm font-medium text-gray-700 mb-2">Throat</label>
                                <input type="text" id="throat" name="throat" value="{{ old('throat') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="skin" class="block text-sm font-medium text-gray-700 mb-2">Skin</label>
                                <input type="text" id="skin" name="skin" value="{{ old('skin') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="physical_remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                            <textarea id="physical_remarks" name="remarks" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <!-- Dental Examination Fields (hidden by default) -->
                    <div id="dental_fields" class="hidden border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Dental Examination Details</h3>

                        <!-- Dental Chart -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Dental Chart</label>

                            <!-- Legend -->
                            <div class="flex flex-wrap gap-4 mb-4 p-3 bg-gray-50 rounded">
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-green-500 rounded mr-2"></span>
                                    <span class="text-sm">Healthy</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-red-500 rounded mr-2"></span>
                                    <span class="text-sm">Cavity</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-blue-500 rounded mr-2"></span>
                                    <span class="text-sm">Filled</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-gray-400 rounded mr-2"></span>
                                    <span class="text-sm">Missing</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-yellow-500 rounded mr-2"></span>
                                    <span class="text-sm">Other</span>
                                </div>
                            </div>

                            <!-- Upper Teeth -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Upper Teeth</h4>
                                <div class="grid grid-cols-8 gap-2">
                                    @for($i = 1; $i <= 16; $i++)
                                        <div class="text-center">
                                            <div class="tooth-selector w-12 h-12 border-2 border-gray-300 rounded cursor-pointer hover:border-gray-500 transition flex items-center justify-center bg-white"
                                                 data-tooth="upper-{{ $i }}"
                                                 data-status="healthy"
                                                 onclick="toggleToothStatus(this)">
                                                <span class="text-xs font-medium">{{ $i }}</span>
                                            </div>
                                            <input type="hidden" name="teeth_status[upper][{{ $i }}]" value="healthy">
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Lower Teeth -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Lower Teeth</h4>
                                <div class="grid grid-cols-8 gap-2">
                                    @for($i = 1; $i <= 16; $i++)
                                        <div class="text-center">
                                            <div class="tooth-selector w-12 h-12 border-2 border-gray-300 rounded cursor-pointer hover:border-gray-500 transition flex items-center justify-center bg-white"
                                                 data-tooth="lower-{{ $i }}"
                                                 data-status="healthy"
                                                 onclick="toggleToothStatus(this)">
                                                <span class="text-xs font-medium">{{ $i }}</span>
                                            </div>
                                            <input type="hidden" name="teeth_status[lower][{{ $i }}]" value="healthy">
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="dental_diagnosis" class="block text-sm font-medium text-gray-700 mb-2">Dental Diagnosis</label>
                            <textarea id="dental_diagnosis" name="dental_diagnosis" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Enter dental diagnosis...">{{ old('dental_diagnosis') }}</textarea>
                        </div>
                    </div>

                    <!-- Immunization Fields (hidden by default) -->
                    <div id="immunization_fields" class="hidden border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Immunization Details</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="vaccine_name" class="block text-sm font-medium text-gray-700 mb-2">Vaccine Name</label>
                                <input type="text" id="vaccine_name" name="vaccine_name" value="{{ old('vaccine_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="vaccine_type" class="block text-sm font-medium text-gray-700 mb-2">Vaccine Type</label>
                                <input type="text" id="vaccine_type" name="vaccine_type" value="{{ old('vaccine_type') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="dosage" class="block text-sm font-medium text-gray-700 mb-2">Dosage</label>
                                <input type="text" id="dosage" name="dosage" value="{{ old('dosage') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="site_of_administration" class="block text-sm font-medium text-gray-700 mb-2">Site of Administration</label>
                                <input type="text" id="site_of_administration" name="site_of_administration" value="{{ old('site_of_administration') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="expiration_date" class="block text-sm font-medium text-gray-700 mb-2">Expiration Date</label>
                                <input type="date" id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="immunization_notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea id="immunization_notes" name="immunization_notes" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('immunization_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                    <a href="{{ route('staff.health-records') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Create Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Show/hide fields based on record type
    document.getElementById('record_type').addEventListener('change', function() {
        const physicalFields = document.getElementById('physical_fields');
        const dentalFields = document.getElementById('dental_fields');
        const immunizationFields = document.getElementById('immunization_fields');

        // Hide all
        physicalFields.classList.add('hidden');
        dentalFields.classList.add('hidden');
        immunizationFields.classList.add('hidden');

        // Show selected
        if (this.value === 'physical') {
            physicalFields.classList.remove('hidden');
        } else if (this.value === 'dental') {
            dentalFields.classList.remove('hidden');
        } else if (this.value === 'immunization') {
            immunizationFields.classList.remove('hidden');
        }
    });

    // Tooth status colors
    const statusColors = {
        'healthy': 'bg-green-500',
        'cavity': 'bg-red-500',
        'filled': 'bg-blue-500',
        'missing': 'bg-gray-400',
        'other': 'bg-yellow-500'
    };

    const statusOrder = ['healthy', 'cavity', 'filled', 'missing', 'other'];

    // Toggle tooth status
    function toggleToothStatus(element) {
        const currentStatus = element.getAttribute('data-status');
        const currentIndex = statusOrder.indexOf(currentStatus);
        const nextIndex = (currentIndex + 1) % statusOrder.length;
        const nextStatus = statusOrder[nextIndex];

        // Remove all status color classes
        Object.values(statusColors).forEach(colorClass => {
            element.classList.remove(colorClass);
        });

        // Add new status color
        element.classList.add(statusColors[nextStatus]);
        element.setAttribute('data-status', nextStatus);

        // Update hidden input
        const hiddenInput = element.parentElement.querySelector('input[type="hidden"]');
        hiddenInput.value = nextStatus;

        // Update border to white when not healthy for better visibility
        if (nextStatus !== 'healthy') {
            element.classList.remove('bg-white');
        } else {
            element.classList.add('bg-white');
        }
    }
</script>
@endsection
