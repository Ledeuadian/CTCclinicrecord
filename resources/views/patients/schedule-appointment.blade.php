@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">Schedule Doctor Appointment</h1>
            <p class="text-gray-600">Book an appointment with one of our qualified doctors</p>
        </div>

        <div class="p-6">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patients.store.appointment') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Doctor Selection -->
                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Doctor <span class="text-red-500">*</span>
                    </label>
                    <select name="doctor_id" id="doctor_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a doctor...</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->user->name }} - {{ $doctor->specialization }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Selection -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        Appointment Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date" id="date" required
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           value="{{ old('date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Time Selection -->
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
                        Preferred Time <span class="text-red-500">*</span>
                    </label>
                    <select name="time" id="time" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select time...</option>
                        <option value="08:00" {{ old('time') == '08:00' ? 'selected' : '' }}>8:00 AM</option>
                        <option value="09:00" {{ old('time') == '09:00' ? 'selected' : '' }}>9:00 AM</option>
                        <option value="10:00" {{ old('time') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                        <option value="11:00" {{ old('time') == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                        <option value="13:00" {{ old('time') == '13:00' ? 'selected' : '' }}>1:00 PM</option>
                        <option value="14:00" {{ old('time') == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                        <option value="15:00" {{ old('time') == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                        <option value="16:00" {{ old('time') == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                    </select>
                </div>

                <!-- Reason for Visit -->
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Visit (Optional)
                    </label>
                    <textarea name="reason" id="reason" rows="4" placeholder="Briefly describe your symptoms or reason for visit..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('reason') }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between pt-6">
                    <a href="{{ route('patients.dashboard') }}"
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Schedule Appointment
                    </button>
                </div>
            </form>

            <!-- Available Doctors Info -->
            <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-800 mb-3">Available Doctors</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($doctors as $doctor)
                        <div class="bg-white p-3 rounded border">
                            <h4 class="font-medium">Dr. {{ $doctor->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $doctor->specialization }}</p>
                            @if($doctor->address)
                                <p class="text-xs text-gray-500">{{ $doctor->address }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
