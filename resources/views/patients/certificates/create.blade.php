@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('patients.certificates.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
                <span class="mr-1">←</span> Back to Certificates
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Request Medical Certificate</h1>
            <p class="text-gray-600">Fill out the form below to request a medical certificate</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('patients.certificates.store') }}" method="POST">
                @csrf

                <!-- Patient Info -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Patient Information</h3>
                    <p class="text-gray-900">{{ $patient->user->firstname }} {{ $patient->user->middlename ?? '' }} {{ $patient->user->lastname }}</p>
                    <p class="text-sm text-gray-500">
                        @if($patient->school_id)
                            School ID: {{ $patient->school_id }}
                        @else
                            Patient Type: {{ ucfirst($patient->patient_type) }}
                        @endif
                    </p>
                </div>

                <!-- Certificate Type -->
                <div class="mb-6">
                    <label for="certificate_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Certificate Type <span class="text-red-500">*</span>
                    </label>
                    <select name="certificate_type_id" id="certificate_type_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('certificate_type_id') border-red-500 @enderror">
                        <option value="">-- Select Certificate Type --</option>
                        @foreach($certificateTypes as $type)
                            <option value="{{ $type->id }}" {{ old('certificate_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('certificate_type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    @if(old('certificate_type_id'))
                        @php $selectedType = $certificateTypes->firstWhere('id', old('certificate_type_id')) @endphp
                        @if($selectedType && $selectedType->description)
                            <p class="mt-2 text-sm text-gray-500">{{ $selectedType->description }}</p>
                        @endif
                    @endif
                </div>

                <!-- Related Appointment (Optional) -->
                @if($appointments->count() > 0)
                <div class="mb-6">
                    <label for="appointment_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Related Appointment <span class="text-xs text-gray-500">(Optional)</span>
                    </label>
                    <select name="appointment_id" id="appointment_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- None --</option>
                        @foreach($appointments as $appointment)
                            <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }} - {{ $appointment->concern ?? 'General Checkup' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Select an appointment if the certificate is related to a specific visit</p>
                </div>
                @endif

                <!-- Reason/Purpose -->
                <div class="mb-6">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Purpose/Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea name="reason" id="reason" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('reason') border-red-500 @enderror"
                              placeholder="Please explain why you need this certificate (e.g., for work, school, insurance, etc.)">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">What happens next?</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Your request will be reviewed by the clinic staff</li>
                                    <li>A doctor will verify and approve your certificate</li>
                                    <li>You'll be notified once your certificate is ready</li>
                                    <li>You can collect your certificate at the clinic</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('patients.certificates.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('certificate_type_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const description = selectedOption.text;
    console.log('Selected:', description);
});
</script>
@endpush