@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Patient Details</h1>
                <p class="text-gray-600">Complete medical record for {{ $patient->user->name }}</p>
            </div>
            <a href="{{ route('doctor.patients') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                ← Back to Patients
            </a>
        </div>

        <div class="p-6">
            <!-- Patient Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Patient Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
                        <p class="text-gray-800 font-medium">{{ $patient->user->name }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Patient ID</label>
                        <p class="text-gray-800 font-medium">{{ $patient->id }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                        <p class="text-gray-800">{{ $patient->user->email }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">School ID</label>
                        <p class="text-gray-800">{{ $patient->school_id ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Patient Type</label>
                        <p class="text-gray-800">
                            @if($patient->patient_type == 1) Student
                            @elseif($patient->patient_type == 2) Faculty & Staff
                            @else Other
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                        <p class="text-gray-800">{{ $patient->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Medical History -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Medical History</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <label class="block text-sm font-medium text-red-700 mb-2">Medical Conditions</label>
                        <p class="text-gray-800">{{ $patient->medical_condition ?: 'None reported' }}</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                        <label class="block text-sm font-medium text-orange-700 mb-2">Allergies</label>
                        <p class="text-gray-800">{{ $patient->allergies ?: 'None reported' }}</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <label class="block text-sm font-medium text-blue-700 mb-2">Medical Illness History</label>
                        <p class="text-gray-800">{{ $patient->medical_illness ?: 'None reported' }}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                        <label class="block text-sm font-medium text-purple-700 mb-2">Previous Operations</label>
                        <p class="text-gray-800">{{ $patient->operations ?: 'None reported' }}</p>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Emergency Contact</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Contact Name</label>
                        <p class="text-gray-800">{{ $patient->emergency_contact_name ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Phone Number</label>
                        <p class="text-gray-800">{{ $patient->emergency_contact_number ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Relationship</label>
                        <p class="text-gray-800">{{ $patient->emergency_relationship ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Appointment History -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Appointment History with You</h2>
                @if($appointments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Date</th>
                                    <th class="px-6 py-3">Time</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Reason</th>
                                    <th class="px-6 py-3">Scheduled</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->date)->format('M j, Y') }}</td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($appointment->status === 'Pending') bg-yellow-100 text-yellow-800
                                                @elseif($appointment->status === 'Confirmed') bg-green-100 text-green-800
                                                @elseif($appointment->status === 'Completed') bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $appointment->reason ?: 'General consultation' }}</td>
                                        <td class="px-6 py-4">{{ $appointment->created_at->format('M j, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No appointment history with this patient.</p>
                @endif
            </div>

            <!-- Health Records -->
            @if($healthRecords->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Health Records</h2>
                    <div class="space-y-4">
                        @foreach($healthRecords as $record)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-medium text-gray-800">Record #{{ $record->id }}</h3>
                                    <span class="text-sm text-gray-500">{{ $record->created_at->format('M j, Y') }}</span>
                                </div>
                                @if($record->diagnosis)
                                    <p class="text-sm text-gray-600"><strong>Diagnosis:</strong> {{ $record->diagnosis }}</p>
                                @endif
                                @if($record->treatment)
                                    <p class="text-sm text-gray-600"><strong>Treatment:</strong> {{ $record->treatment }}</p>
                                @endif
                                @if($record->notes)
                                    <p class="text-sm text-gray-600"><strong>Notes:</strong> {{ $record->notes }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Prescriptions -->
            @if($prescriptions->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Prescription History</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Date</th>
                                    <th class="px-6 py-3">Medicine</th>
                                    <th class="px-6 py-3">Dosage</th>
                                    <th class="px-6 py-3">Instructions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescriptions as $prescription)
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($prescription->date_prescribed)->format('M j, Y') }}</td>
                                        <td class="px-6 py-4">{{ $prescription->medicine->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ $prescription->dosage }}</td>
                                        <td class="px-6 py-4">{{ $prescription->instructions ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="flex space-x-4">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Add Health Record
                    </button>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                        Prescribe Medication
                    </button>
                    <button class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                        Schedule Follow-up
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
