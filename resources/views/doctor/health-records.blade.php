@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">Health Records</h1>
            <p class="text-gray-600">Health records for patients with appointments with you</p>
        </div>

        <div class="p-6">
            <!-- Summary Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-md">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-2xl font-bold text-blue-600">{{ $totalRecords }}</p>
                            <p class="text-blue-600 font-medium">Total Health Records</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-md">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-2xl font-bold text-green-600">{{ $recentRecords }}</p>
                            <p class="text-green-600 font-medium">Records This Month</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-md">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-2xl font-bold text-purple-600">{{ $diagnosisStats->count() }}</p>
                            <p class="text-purple-600 font-medium">Unique Diagnoses</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Diagnoses -->
            @if($diagnosisStats->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Most Common Diagnoses</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($diagnosisStats->take(6) as $diagnosis)
                                <div class="bg-white rounded-lg p-3 border border-gray-200">
                                    <p class="font-medium text-gray-800">{{ $diagnosis->diagnosis }}</p>
                                    <p class="text-sm text-gray-600">{{ $diagnosis->count }} {{ $diagnosis->count == 1 ? 'case' : 'cases' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Health Records List -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Health Records</h2>

                @if($healthRecords->count() > 0)
                    <div class="space-y-4">
                        @foreach($healthRecords as $record)
                            <div class="border border-gray-200 rounded-lg">
                                <div class="p-6">
                                    <!-- Record Header -->
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                                {{ substr($record->patient->user->name, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="font-semibold text-gray-800">{{ $record->patient->user->name }}</h3>
                                                <p class="text-sm text-gray-600">Patient ID: {{ $record->patient->id }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-800">{{ $record->created_at->format('M j, Y') }}</p>
                                            <p class="text-sm text-gray-600">{{ $record->created_at->format('g:i A') }}</p>
                                        </div>
                                    </div>

                                    <!-- Record Content -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @if($record->diagnosis)
                                            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                                <h4 class="font-medium text-red-800 mb-2">Diagnosis</h4>
                                                <p class="text-gray-800">{{ $record->diagnosis }}</p>
                                            </div>
                                        @endif

                                        @if($record->treatment)
                                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                                <h4 class="font-medium text-blue-800 mb-2">Treatment</h4>
                                                <p class="text-gray-800">{{ $record->treatment }}</p>
                                            </div>
                                        @endif

                                        @if($record->symptoms)
                                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                                <h4 class="font-medium text-yellow-800 mb-2">Symptoms</h4>
                                                <p class="text-gray-800">{{ $record->symptoms }}</p>
                                            </div>
                                        @endif

                                        @if($record->notes)
                                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                                <h4 class="font-medium text-green-800 mb-2">Notes</h4>
                                                <p class="text-gray-800">{{ $record->notes }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Vital Signs -->
                                    @if($record->blood_pressure || $record->heart_rate || $record->temperature || $record->weight)
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <h4 class="font-medium text-gray-800 mb-3">Vital Signs</h4>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                @if($record->blood_pressure)
                                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                                        <p class="text-sm text-gray-600">Blood Pressure</p>
                                                        <p class="font-semibold text-gray-800">{{ $record->blood_pressure }}</p>
                                                    </div>
                                                @endif
                                                @if($record->heart_rate)
                                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                                        <p class="text-sm text-gray-600">Heart Rate</p>
                                                        <p class="font-semibold text-gray-800">{{ $record->heart_rate }} bpm</p>
                                                    </div>
                                                @endif
                                                @if($record->temperature)
                                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                                        <p class="text-sm text-gray-600">Temperature</p>
                                                        <p class="font-semibold text-gray-800">{{ $record->temperature }}°C</p>
                                                    </div>
                                                @endif
                                                @if($record->weight)
                                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                                        <p class="text-sm text-gray-600">Weight</p>
                                                        <p class="font-semibold text-gray-800">{{ $record->weight }} kg</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Quick Actions -->
                                    <div class="mt-4 pt-4 border-t border-gray-200 flex space-x-3">
                                        <a href="{{ route('doctor.patient.details', $record->patient->id) }}"
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Patient Details
                                        </a>
                                        <span class="text-gray-300">|</span>
                                        <button class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            Add Follow-up
                                        </button>
                                        <span class="text-gray-300">|</span>
                                        <button class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                            Print Record
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($healthRecords->hasPages())
                        <div class="mt-8">
                            {{ $healthRecords->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Health Records Found</h3>
                        <p class="text-gray-500">No health records available for your patients yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
