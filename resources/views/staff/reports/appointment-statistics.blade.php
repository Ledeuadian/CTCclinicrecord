<div class="space-y-6">
    <h2 class="text-xl font-semibold text-white">Appointment Statistics</h2>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gray-700 rounded-lg p-4">
            <div class="text-gray-400 text-sm">Total Appointments</div>
            <div class="text-3xl font-bold text-white mt-2">{{ $data['total_appointments'] ?? 0 }}</div>
        </div>
        <div class="bg-gray-700 rounded-lg p-4">
            <div class="text-gray-400 text-sm">Pending</div>
            <div class="text-3xl font-bold text-yellow-400 mt-2">{{ $data['pending'] ?? 0 }}</div>
        </div>
        <div class="bg-gray-700 rounded-lg p-4">
            <div class="text-gray-400 text-sm">Completed</div>
            <div class="text-3xl font-bold text-green-400 mt-2">{{ $data['completed'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Status Distribution -->
    @if(isset($data['by_status']) && count($data['by_status']) > 0)
    <div class="bg-gray-700 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-white mb-4">Appointments by Status</h3>
        <table class="w-full text-gray-300">
            <thead class="border-b border-gray-600">
                <tr>
                    <th class="text-left py-2">Status</th>
                    <th class="text-right py-2">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['by_status'] as $item)
                <tr class="border-b border-gray-600">
                    <td class="py-2">{{ $item->status }}</td>
                    <td class="text-right py-2">{{ $item->count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Monthly Trends -->
    @if(isset($data['by_month']) && count($data['by_month']) > 0)
    <div class="bg-gray-700 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-white mb-4">Monthly Trends</h3>
        <table class="w-full text-gray-300">
            <thead class="border-b border-gray-600">
                <tr>
                    <th class="text-left py-2">Month</th>
                    <th class="text-right py-2">Appointments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['by_month'] as $item)
                <tr class="border-b border-gray-600">
                    <td class="py-2">{{ $item->month }}</td>
                    <td class="text-right py-2">{{ $item->count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
