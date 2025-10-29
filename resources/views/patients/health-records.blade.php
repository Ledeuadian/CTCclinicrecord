@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">My Health Records</h1>
            <p class="text-gray-600">View your complete medical history and records</p>
        </div>

        <div class="p-6">
            @php
                $totalRecords = $healthRecords->count() + $dentalExaminations->count() + 
                               $physicalExaminations->count() + $immunizationRecords->count() + 
                               $prescriptionRecords->count();
            @endphp

            @if($totalRecords > 0)
                <!-- Summary Statistics -->
                <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Health Records Summary</h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <p class="text-3xl font-bold text-blue-600">{{ $totalRecords }}</p>
                            <p class="text-sm text-gray-600 mt-1">Total Records</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <p class="text-3xl font-bold text-green-600">{{ $dentalExaminations->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Dental Exams</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <p class="text-3xl font-bold text-purple-600">{{ $physicalExaminations->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Physical Exams</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <p class="text-3xl font-bold text-yellow-600">{{ $immunizationRecords->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Immunizations</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <p class="text-3xl font-bold text-red-600">{{ $prescriptionRecords->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Prescriptions</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Dental Examinations -->
                    @foreach($dentalExaminations as $dental)
                        <div class="border border-green-200 bg-green-50 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded-full mb-2">
                                        Dental Examination
                                    </span>
                                    <h3 class="text-lg font-medium text-gray-800">
                                        Dental Exam #{{ $dental->id }}
                                    </h3>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $dental->created_at->format('F j, Y g:i A') }}
                                </span>
                            </div>

                            @if($dental->doctor)
                                <div class="mb-3">
                                    <span class="text-sm font-medium text-gray-600">Doctor:</span>
                                    <p class="text-gray-800">{{ $dental->doctor->user->name ?? 'N/A' }}</p>
                                </div>
                            @endif

                            @if($dental->diagnosis)
                                <div class="mb-3">
                                    <span class="text-sm font-medium text-gray-600">Diagnosis:</span>
                                    <p class="text-gray-800">{{ $dental->diagnosis }}</p>
                                </div>
                            @endif

                            @if($dental->teeth_status && is_array($dental->teeth_status) && count($dental->teeth_status) > 0)
                                <div class="mt-4 pt-4 border-t border-green-200">
                                    <span class="text-sm font-medium text-gray-600 block mb-2">Teeth Status:</span>
                                    <div class="grid grid-cols-8 gap-1 text-xs">
                                        @for($i = 1; $i <= 32; $i++)
                                            @php
                                                $status = $dental->teeth_status[$i] ?? '';
                                                $bgColor = match($status) {
                                                    'healthy' => 'bg-green-100 text-green-800',
                                                    'cavity' => 'bg-red-100 text-red-800',
                                                    'filled' => 'bg-blue-100 text-blue-800',
                                                    'missing' => 'bg-gray-100 text-gray-800',
                                                    'crown' => 'bg-yellow-100 text-yellow-800',
                                                    default => 'bg-gray-50 text-gray-400'
                                                };
                                            @endphp
                                            <div class="p-1 {{ $bgColor }} rounded text-center">
                                                {{ $i }}
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Physical Examinations -->
                    @foreach($physicalExaminations as $physical)
                        <div class="border border-purple-200 bg-purple-50 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-purple-600 text-white text-xs font-semibold rounded-full mb-2">
                                        Physical Examination
                                    </span>
                                    <h3 class="text-lg font-medium text-gray-800">
                                        Physical Exam #{{ $physical->id }}
                                    </h3>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $physical->created_at->format('F j, Y g:i A') }}
                                </span>
                            </div>

                            @if($physical->doctor)
                                <div class="mb-3">
                                    <span class="text-sm font-medium text-gray-600">Doctor:</span>
                                    <p class="text-gray-800">{{ $physical->doctor->user->name ?? 'N/A' }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                @if($physical->height)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Height:</span>
                                        <p class="text-gray-800">{{ $physical->height }} cm</p>
                                    </div>
                                @endif
                                @if($physical->weight)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Weight:</span>
                                        <p class="text-gray-800">{{ $physical->weight }} kg</p>
                                    </div>
                                @endif
                                @if($physical->bp)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Blood Pressure:</span>
                                        <p class="text-gray-800">{{ $physical->bp }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($physical->heart)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Heart:</span>
                                        <p class="text-gray-800">{{ $physical->heart }}</p>
                                    </div>
                                @endif
                                @if($physical->lungs)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Lungs:</span>
                                        <p class="text-gray-800">{{ $physical->lungs }}</p>
                                    </div>
                                @endif
                                @if($physical->eyes)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Eyes:</span>
                                        <p class="text-gray-800">{{ $physical->eyes }}</p>
                                    </div>
                                @endif
                                @if($physical->ears)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Ears:</span>
                                        <p class="text-gray-800">{{ $physical->ears }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($physical->remarks)
                                <div class="mt-4 pt-4 border-t border-purple-200">
                                    <span class="text-sm font-medium text-gray-600">Remarks:</span>
                                    <p class="text-gray-800">{{ $physical->remarks }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Immunization Records -->
                    @foreach($immunizationRecords as $immunization)
                        <div class="border border-yellow-200 bg-yellow-50 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-yellow-600 text-white text-xs font-semibold rounded-full mb-2">
                                        Immunization Record
                                    </span>
                                    <h3 class="text-lg font-medium text-gray-800">
                                        {{ $immunization->vaccine_name }}
                                    </h3>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $immunization->created_at->format('F j, Y g:i A') }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($immunization->vaccine_type)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Vaccine Type:</span>
                                        <p class="text-gray-800">{{ $immunization->vaccine_type }}</p>
                                    </div>
                                @endif
                                @if($immunization->dosage)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Dosage:</span>
                                        <p class="text-gray-800">{{ $immunization->dosage }}</p>
                                    </div>
                                @endif
                                @if($immunization->site_of_administration)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Administration Site:</span>
                                        <p class="text-gray-800">{{ $immunization->site_of_administration }}</p>
                                    </div>
                                @endif
                                @if($immunization->expiration_date)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Expiration Date:</span>
                                        <p class="text-gray-800">{{ \Carbon\Carbon::parse($immunization->expiration_date)->format('F j, Y') }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($immunization->notes)
                                <div class="mt-4 pt-4 border-t border-yellow-200">
                                    <span class="text-sm font-medium text-gray-600">Notes:</span>
                                    <p class="text-gray-800">{{ $immunization->notes }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Prescription Records -->
                    @foreach($prescriptionRecords as $prescription)
                        <div class="border border-red-200 bg-red-50 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full mb-2">
                                        Prescription
                                    </span>
                                    <h3 class="text-lg font-medium text-gray-800">
                                        {{ $prescription->medicine->name ?? 'Medicine #' . $prescription->medicine_id }}
                                    </h3>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $prescription->created_at->format('F j, Y g:i A') }}
                                </span>
                            </div>

                            @if($prescription->doctor)
                                <div class="mb-3">
                                    <span class="text-sm font-medium text-gray-600">Prescribed by:</span>
                                    <p class="text-gray-800">{{ $prescription->doctor->user->name ?? 'N/A' }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($prescription->dosage)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Dosage:</span>
                                        <p class="text-gray-800">{{ $prescription->dosage }}</p>
                                    </div>
                                @endif
                                @if($prescription->instruction)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Instructions:</span>
                                        <p class="text-gray-800">{{ $prescription->instruction }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- General Health Records -->
                    @foreach($healthRecords as $record)
                        <div class="border border-blue-200 bg-blue-50 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full mb-2">
                                        Health Record
                                    </span>
                                    <h3 class="text-lg font-medium text-gray-800">
                                        Health Record #{{ $record->id }}
                                    </h3>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $record->created_at->format('F j, Y g:i A') }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($record->diagnosis)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Diagnosis:</span>
                                        <p class="text-gray-800">{{ $record->diagnosis }}</p>
                                    </div>
                                @endif
                                @if($record->treatment)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Treatment:</span>
                                        <p class="text-gray-800">{{ $record->treatment }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($record->notes)
                                <div class="mt-4 pt-4 border-t border-blue-200">
                                    <span class="text-sm font-medium text-gray-600">Notes:</span>
                                    <p class="text-gray-800">{{ $record->notes }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No health records -->
                <div class="text-center py-12">
                    <div class="bg-gray-50 p-8 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">No Health Records</h3>
                        <p class="text-gray-600 mb-4">You don't have any health records yet. Records will appear here after your medical consultations.</p>
                        <a href="{{ route('patients.schedule.appointment') }}"
                           class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                            Schedule an Appointment
                        </a>
                    </div>
                </div>
            @endif

            <!-- Back to Dashboard -->
            <div class="mt-8 text-center border-t border-gray-200 pt-6">
                <a href="{{ route('patients.dashboard') }}"
                   class="text-blue-600 hover:text-blue-800">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
