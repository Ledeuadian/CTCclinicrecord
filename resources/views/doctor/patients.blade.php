@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">My Patients</h1>
            <p class="text-gray-600">Patients who have appointments with you</p>
        </div>

        <div class="p-6">
            <!-- Search and Filter -->
            <div class="mb-6 flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text"
                           id="searchPatients"
                           placeholder="Search patients by name, ID, or email..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="sm:w-48">
                    <select id="filterType"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Patient Types</option>
                        <option value="1">Students</option>
                        <option value="2">Faculty & Staff</option>
                    </select>
                </div>
            </div>

            <!-- Patients Grid -->
            @if($patients->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="patientsGrid">
                    @foreach($patients as $patient)
                        <div class="patient-card bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition"
                             data-name="{{ strtolower($patient->user->name) }}"
                             data-email="{{ strtolower($patient->user->email) }}"
                             data-id="{{ $patient->id }}"
                             data-type="{{ $patient->patient_type }}">

                            <!-- Patient Header -->
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold text-lg">
                                    {{ substr($patient->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $patient->user->name }}</h3>
                                    <p class="text-sm text-gray-500">ID: {{ $patient->id }}</p>
                                </div>
                            </div>

                            <!-- Patient Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Type:</span>
                                    <span class="font-medium">
                                        @if($patient->patient_type == 1) Student
                                        @elseif($patient->patient_type == 2) Faculty & Staff
                                        @else Other
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">{{ $patient->user->email }}</span>
                                </div>
                                @if($patient->school_id)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">School ID:</span>
                                        <span class="font-medium">{{ $patient->school_id }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Appointment Stats -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-blue-600">{{ $patient->appointments_count ?? 0 }}</p>
                                        <p class="text-xs text-gray-600">Total Visits</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-green-600">
                                            {{ $patient->appointments->where('created_at', '>=', now()->subMonth())->count() }}
                                        </p>
                                        <p class="text-xs text-gray-600">This Month</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Latest Appointment -->
                            @if($patient->appointments->first())
                                @php $lastAppointment = $patient->appointments->first(); @endphp
                                <div class="border-t border-gray-200 pt-3 mb-4">
                                    <p class="text-sm font-medium text-gray-800 mb-1">Latest Appointment</p>
                                    <p class="text-xs text-gray-600">
                                        {{ \Carbon\Carbon::parse($lastAppointment->date)->format('M j, Y') }} at
                                        {{ \Carbon\Carbon::parse($lastAppointment->time)->format('g:i A') }}
                                    </p>
                                    <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full
                                        @if($lastAppointment->status === 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($lastAppointment->status === 'Confirmed') bg-green-100 text-green-800
                                        @elseif($lastAppointment->status === 'Completed') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $lastAppointment->status }}
                                    </span>
                                </div>
                            @endif

                            <!-- Medical Alerts -->
                            @if($patient->allergies || $patient->medical_condition)
                                <div class="border-t border-gray-200 pt-3 mb-4">
                                    <p class="text-sm font-medium text-red-600 mb-1">⚠️ Medical Alerts</p>
                                    @if($patient->allergies)
                                        <p class="text-xs text-gray-600"><strong>Allergies:</strong> {{ Str::limit($patient->allergies, 30) }}</p>
                                    @endif
                                    @if($patient->medical_condition)
                                        <p class="text-xs text-gray-600"><strong>Conditions:</strong> {{ Str::limit($patient->medical_condition, 30) }}</p>
                                    @endif
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <a href="{{ route('doctor.patient-details', $patient->id) }}"
                                   class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-md text-sm hover:bg-blue-700 transition">
                                    View Details
                                </a>
                                <button class="bg-gray-200 text-gray-700 py-2 px-3 rounded-md text-sm hover:bg-gray-300 transition"
                                        onclick="quickContact('{{ $patient->user->email }}')">
                                    Contact
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($patients->hasPages())
                    <div class="mt-8">
                        {{ $patients->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Patients Found</h3>
                    <p class="text-gray-500">You don't have any patients with appointments yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchPatients');
    const typeFilter = document.getElementById('filterType');
    const patientCards = document.querySelectorAll('.patient-card');

    function filterPatients() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedType = typeFilter.value;

        patientCards.forEach(card => {
            const name = card.dataset.name;
            const email = card.dataset.email;
            const id = card.dataset.id;
            const type = card.dataset.type;

            const matchesSearch = name.includes(searchTerm) ||
                                email.includes(searchTerm) ||
                                id.includes(searchTerm);
            const matchesType = selectedType === '' || type === selectedType;

            if (matchesSearch && matchesType) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterPatients);
    typeFilter.addEventListener('change', filterPatients);
});

function quickContact(email) {
    window.location.href = `mailto:${email}`;
}
</script>
@endpush
@endsection
