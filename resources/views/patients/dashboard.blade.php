@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">Patient Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}!</p>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-blue-800 mb-3">Schedule Appointment</h3>
                    <p class="text-blue-600 mb-4">Book an appointment with a doctor</p>
                    <a href="{{ route('patients.schedule.appointment') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Schedule Now
                    </a>
                </div>

                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-green-800 mb-3">Health Records</h3>
                    <p class="text-green-600 mb-4">View your medical history</p>
                    <a href="{{ route('patients.health.records') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        View Records
                    </a>
                </div>

                <div class="bg-purple-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-purple-800 mb-3">Update Profile</h3>
                    <p class="text-purple-600 mb-4">Manage your personal information</p>
                    <a href="{{ route('patients.profile') }}"
                       class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Recent Appointments</h3>
                    @if($appointments->count() > 0)
                        <div class="space-y-3">
                            @foreach($appointments as $appointment)
                                <div class="bg-white p-4 rounded border">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium">Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</p>
                                            <p class="text-sm text-gray-600">{{ $appointment->date }} at {{ $appointment->time }}</p>
                                            <span class="inline-block px-2 py-1 text-xs rounded
                                                @if($appointment->status === 'Pending') bg-yellow-100 text-yellow-800
                                                @elseif($appointment->status === 'Confirmed') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $appointment->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('patients.appointments') }}"
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                View All Appointments →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500">No appointments yet.</p>
                        <a href="{{ route('patients.schedule.appointment') }}"
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            Schedule your first appointment →
                        </a>
                    @endif
                </div>

                <!-- Health Summary -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Health Summary</h3>
                    @if($patient)
                        <div class="space-y-2">
                            @if($patient->medical_condition)
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Medical Conditions:</span>
                                    <p class="text-sm text-gray-800">{{ $patient->medical_condition }}</p>
                                </div>
                            @endif
                            @if($patient->allergies)
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Allergies:</span>
                                    <p class="text-sm text-gray-800">{{ $patient->allergies }}</p>
                                </div>
                            @endif
                            <div>
                                <span class="text-sm font-medium text-gray-600">Emergency Contact:</span>
                                <p class="text-sm text-gray-800">{{ $patient->emergency_contact_name }} ({{ $patient->emergency_relationship }})</p>
                                <p class="text-sm text-gray-600">{{ $patient->emergency_contact_number }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500">Complete your profile to see health summary.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
