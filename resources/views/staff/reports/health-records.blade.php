<div class="space-y-6">
    <h2 class="text-xl font-semibold text-white">Health Records Summary</h2>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gray-700 rounded-lg p-4">
            <div class="text-gray-400 text-sm">Total Records</div>
            <div class="text-3xl font-bold text-white mt-2">{{ $data['total_records'] ?? 0 }}</div>
        </div>
        <div class="bg-gray-700 rounded-lg p-4">
            <div class="text-gray-400 text-sm">Physical Exams</div>
            <div class="text-3xl font-bold text-blue-400 mt-2">{{ $data['physical_exams'] ?? 0 }}</div>
        </div>
        <div class="bg-gray-700 rounded-lg p-4">
            <div class="text-gray-400 text-sm">Dental Exams</div>
            <div class="text-3xl font-bold text-green-400 mt-2">{{ $data['dental_exams'] ?? 0 }}</div>
        </div>
        <div class="bg-gray-700 rounded-lg p-4">
            <div class="text-gray-400 text-sm">Immunizations</div>
            <div class="text-3xl font-bold text-purple-400 mt-2">{{ $data['immunizations'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Recent Records -->
    @if(isset($data['recent_records']) && count($data['recent_records']) > 0)
    <div class="bg-gray-700 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-white mb-4">Recent Health Records</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-gray-300">
                <thead class="border-b border-gray-600">
                    <tr>
                        <th class="text-left py-2">Date</th>
                        <th class="text-left py-2">Patient</th>
                        <th class="text-left py-2">Diagnosis</th>
                        <th class="text-left py-2">Treatment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['recent_records'] as $record)
                    <tr class="border-b border-gray-600">
                        <td class="py-2">{{ $record->created_at->format('M d, Y') }}</td>
                        <td class="py-2">{{ $record->patient->user->name ?? 'N/A' }}</td>
                        <td class="py-2">{{ $record->diagnosis ?? 'N/A' }}</td>
                        <td class="py-2">{{ Str::limit($record->treatment ?? 'N/A', 50) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
