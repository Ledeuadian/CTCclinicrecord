<div id="immunizationModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">New Immunization</h2>
            <button id="closeModalButton" class="text-gray-600 hover:text-gray-900 text-xl">
                &times;
            </button>
        </div>
        <form action="{{ route('immunization.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelModalButton" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Appointment
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Modal backdrop -->
<div id="modalBackdrop" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden z-40"></div>
