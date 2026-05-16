@extends('admin.layout.navigation')
@section('content')
<div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Users -->
        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalUsers'] }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full dark:bg-blue-900">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Total Doctors -->
        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Doctors</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalDoctors'] }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full dark:bg-green-900">
                <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>

        <!-- Total Patients -->
        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Patients</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalPatients'] }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full dark:bg-purple-900">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Health Records -->
        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Health Records</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalHealthRecords'] }}</p>
            </div>
            <div class="p-3 bg-red-100 rounded-full dark:bg-red-900">
                <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Second Row Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Total Appointments -->
        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Appointments</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalAppointments'] }}</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full dark:bg-yellow-900">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <!-- Pending Appointments -->
        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pending Appointments</p>
                <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['pendingAppointments'] }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full dark:bg-orange-900">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Today's Appointments</p>
                <p class="text-2xl font-bold text-teal-600 dark:text-teal-400">{{ $stats['todayAppointments'] }}</p>
            </div>
            <div class="p-3 bg-teal-100 rounded-full dark:bg-teal-900">
                <svg class="w-6 h-6 text-teal-600 dark:text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Appointments</h3>
        @if($recentAppointments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Patient</th>
                            <th class="px-4 py-3">Doctor</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Time</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAppointments as $appointment)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                {{ $appointment->patient->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $appointment->doctor->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3">{{ $appointment->date }}</td>
                            <td class="px-4 py-3">{{ $appointment->time }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($appointment->status == 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @elseif($appointment->status == 'Completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @endif">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No appointments found.</p>
        @endif
    </div>

    <!-- Statistics by Course and Educational Level -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- By Course -->
        <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Patients by Course</h3>
            @if($byCourse->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Course Name</th>
                                <th class="px-4 py-3 text-center">Total</th>
                                <th class="px-4 py-3 text-center">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byCourse as $course)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.statistics.course', $course->id) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline">
                                        {{ $course->course_name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-center">{{ $course->total_patients }}</td>
                                <td class="px-4 py-3 text-center">{{ $stats['totalPatients'] > 0 ? round(($course->total_patients / $stats['totalPatients']) * 100, 1) : 0 }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No course data available.</p>
            @endif
        </div>

        <!-- By Educational Level -->
        <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Patients by Educational Level</h3>
            @if($byEducationalLevel->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Level Name</th>
                                <th class="px-4 py-3 text-center">Total</th>
                                <th class="px-4 py-3 text-center">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byEducationalLevel as $level)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.statistics.level', $level->id) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline">
                                        {{ $level->level_name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-center">{{ $level->total_patients }}</td>
                                <td class="px-4 py-3 text-center">{{ $stats['totalPatients'] > 0 ? round(($level->total_patients / $stats['totalPatients']) * 100, 1) : 0 }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No educational level data available.</p>
            @endif
        </div>
    </div>
</div>
@endsection
