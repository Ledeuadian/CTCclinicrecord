<!-- Staff Dashboard Partial View -->
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-800">Total Patients</h3>
                <p class="text-2xl font-bold text-green-600">{{ $totalPatients }}</p>
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

    <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
        <div class="flex items-center">
            <div class="p-3 bg-purple-500 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-800">Health Records</h3>
                <p class="text-2xl font-bold text-purple-600">{{ $healthRecordsCount }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="/staff/appointments" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded hover:bg-blue-700 transition">
                View Appointments
            </a>
            <a href="/staff/patients" class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded hover:bg-green-700 transition">
                View Patients
            </a>
            <a href="/staff/health-records" class="block w-full bg-purple-600 text-white text-center py-2 px-4 rounded hover:bg-purple-700 transition">
                Health Records
            </a>
            <a href="/staff/reports" class="block w-full bg-yellow-600 text-white text-center py-2 px-4 rounded hover:bg-yellow-700 transition">
                View Reports
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
        <p class="text-gray-500 text-center py-4">No recent activity</p>
    </div>
</div>
