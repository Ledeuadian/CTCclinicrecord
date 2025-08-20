@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">My Health Records</h1>
            <p class="text-gray-600">View your complete medical history and records</p>
        </div>

        <div class="p-6">
            @if($healthRecords->count() > 0)
                <div class="space-y-6">
                    @foreach($healthRecords as $record)
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-medium text-gray-800">
                                    Health Record #{{ $record->id }}
                                </h3>
                                <span class="text-sm text-gray-500">
                                    {{ $record->created_at->format('F j, Y g:i A') }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($record->blood_pressure)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Blood Pressure:</span>
                                        <p class="text-gray-800">{{ $record->blood_pressure }}</p>
                                    </div>
                                @endif

                                @if($record->temperature)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Temperature:</span>
                                        <p class="text-gray-800">{{ $record->temperature }}°C</p>
                                    </div>
                                @endif

                                @if($record->weight)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Weight:</span>
                                        <p class="text-gray-800">{{ $record->weight }} kg</p>
                                    </div>
                                @endif

                                @if($record->height)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Height:</span>
                                        <p class="text-gray-800">{{ $record->height }} cm</p>
                                    </div>
                                @endif
                            </div>

                            @if($record->diagnosis || $record->treatment || $record->notes)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    @if($record->diagnosis)
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-gray-600">Diagnosis:</span>
                                            <p class="text-gray-800">{{ $record->diagnosis }}</p>
                                        </div>
                                    @endif

                                    @if($record->treatment)
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-gray-600">Treatment:</span>
                                            <p class="text-gray-800">{{ $record->treatment }}</p>
                                        </div>
                                    @endif

                                    @if($record->notes)
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Notes:</span>
                                            <p class="text-gray-800">{{ $record->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Summary Statistics -->
                <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Health Summary</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ $healthRecords->count() }}</p>
                            <p class="text-sm text-gray-600">Total Records</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-green-600">
                                {{ $healthRecords->where('created_at', '>=', now()->subMonths(3))->count() }}
                            </p>
                            <p class="text-sm text-gray-600">Last 3 Months</p>
                        </div>
                        @if($healthRecords->whereNotNull('weight')->count() > 0)
                            <div>
                                <p class="text-2xl font-bold text-purple-600">
                                    {{ $healthRecords->whereNotNull('weight')->avg('weight') ? number_format($healthRecords->whereNotNull('weight')->avg('weight'), 1) : 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-600">Avg Weight (kg)</p>
                            </div>
                        @endif
                        @if($healthRecords->whereNotNull('height')->count() > 0)
                            <div>
                                <p class="text-2xl font-bold text-orange-600">
                                    {{ $healthRecords->whereNotNull('height')->avg('height') ? number_format($healthRecords->whereNotNull('height')->avg('height'), 1) : 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-600">Avg Height (cm)</p>
                            </div>
                        @endif
                    </div>
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
