<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-4">
                    Patient ID
                </th>
                <th scope="col" class="px-6 py-4">
                    Date
                </th>
                <th scope="col" class="px-6 py-4">
                    Time
                </th>
                <th scope="col" class="px-6 py-4">
                    Doctor
                </th>
                <th scope="col" class="px-6 py-4">
                    Status
                </th>
                <th scope="col" class="px-6 py-4">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $appointment->patient_id }}
                </th>
                <td class="px-6 py-4">
                    {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}
                </td>
                <td class="px-6 py-4">
                    {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                </td>
                <td class="px-6 py-4">
                    {{ $appointment->doc_id }}
                </td>
                <td class="px-6 py-4">
                    {{ $appointment->status }}
                </td>
                <td class="flex items-center px-6 py-4">
                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline-block;">
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
