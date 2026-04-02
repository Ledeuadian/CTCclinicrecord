@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Staff Mode Indicator -->
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span class="text-green-800 font-medium">Staff Duties Mode</span>
            <span class="text-green-600 text-sm ml-2">- Managing clinic operations</span>
        </div>
    </div>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Staff Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Today's Appointments</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $todayAppointments }}</p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">This Week</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $weeklyAppointments }}</p>
                </div>
            </div>
        </div>

        <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
            <div class="flex items-center">
                <div class="p-3 bg-purple-500 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Patients</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $totalPatients }}</p>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-500 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pending</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingAppointments }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('staff.appointments') }}"
                   class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded hover:bg-blue-700 transition">
                    Manage Appointments
                </a>
                <a href="{{ route('staff.patients') }}"
                   class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded hover:bg-green-700 transition">
                    View Patients
                </a>
                <a href="{{ route('staff.reports') }}"
                   class="block w-full bg-purple-600 text-white text-center py-2 px-4 rounded hover:bg-purple-700 transition">
                    View Reports
                </a>
                <a href="{{ route('staff.reports.generate') }}"
                   class="block w-full bg-indigo-600 text-white text-center py-2 px-4 rounded hover:bg-indigo-700 transition">
                    📊 Generate Custom Report
                </a>
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm border">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Appointments</h3>
            @if($recentAppointments->count() > 0)
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($recentAppointments as $appointment)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $appointment->patient->user->name ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Doctor: {{ $appointment->doctor->user->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="px-3 py-1 text-xs rounded-full
                                    @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No recent appointments</p>
            @endif
        </div>
    </div>

    <!-- Monthly Statistics Chart (if available) -->
    @if(isset($monthlyStats) && $monthlyStats->count() > 0)
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Appointment Trends</h3>
        <div class="h-64 flex items-end justify-around space-x-2">
            @foreach($monthlyStats as $month => $count)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-blue-500 hover:bg-blue-600 transition-colors rounded-t"
                         style="height: {{ ($count / $monthlyStats->max()) * 100 }}%"
                         title="{{ $count }} appointments">
                    </div>
                    <span class="text-xs text-gray-600 mt-2">{{ date('M', mktime(0, 0, 0, $month, 1)) }}</span>
                    <span class="text-xs font-semibold text-gray-800">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
