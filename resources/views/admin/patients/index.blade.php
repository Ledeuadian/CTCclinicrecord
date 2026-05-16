@extends('admin.layout.navigation')

@section('content')
<div class="mb-4 flex justify-end">
    <a href="{{ route('admin.patients.export') }}"
       class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Export to CSV
    </a>
</div>

<div class="relative overflow-x-auto">
    @if (session('success'))
    <div id="alert-border-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div class="ms-3 text-sm font-medium">
            {{ session('success') }}
        </div>
    </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="alert-border-4" class="flex items-center p-4 mb-4 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div class="ms-3 text-sm font-medium">
                    {{ $error }}
                </div>
            </div>
        @endforeach
    @endif
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-4">
                    Id
                </th>
                <th scope="col" class="px-6 py-4">
                    Name
                </th>
                <th scope="col" class="px-6 py-4">
                    School ID
                </th>
                <th scope="col" class="px-6 py-4">
                    Education Level
                </th>
                <th scope="col" class="px-6 py-4">
                    Patient Type
                </th>
                <th scope="col" class="px-6 py-4">
                    Address
                </th>
                <th scope="col" class="px-6 py-4">
                    Medical Condition
                </th>
                <th scope="col" class="px-6 py-4">
                    Medical Illness
                </th>
                <th scope="col" class="px-6 py-4">
                    Operations
                </th>
                <th scope="col" class="px-6 py-4">
                    Allergies
                </th>
                <th scope="col" class="px-6 py-4">
                    Emergency Contact Name
                </th>
                <th scope="col" class="px-6 py-4">
                    Emergency Contact Number
                </th>
                <th scope="col" class="px-6 py-4">
                    Emergency Relationship
                </th>
                <th scope="col" class="px-6 py-4">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $patient->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $patient->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->school_id }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->level_name }} {{ $patient->year_level }}
                </td>
                <td class="px-6 py-4">
                    @if ($patient->patient_type == 1)
                        Patient
                    @elseif ($patient->patient_type == 2)
                        Faculty & Staff
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{ $patient->address }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->medical_condition }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->medical_illness }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->operations }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->allergies }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->emergency_contact_name }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->emergency_contact_number }}
                </td>
                <td class="px-6 py-4">
                    {{ $patient->emergency_relationship }}
                </td>
                <td class="flex items-center px-6 py-4">
                    <a href="{{ route('admin.patients.edit', $patient->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">
                        <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3r" onclick="return confirm('Are you sure?')">Remove</button>
                        </form>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
