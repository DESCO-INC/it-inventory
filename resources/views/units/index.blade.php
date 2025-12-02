<x-layout>
    <h1 class="text-xl font-semibold text-white mb-5">Welcome, {{ Auth::user()->name }}</h1>
    
    <livewire:inventory-table />

    <!-- Import Item Modal -->
    <div id="import-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">Import Items</h2>
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-600 dark:text-blue-400"
                role="alert">
                <span class="font-medium">Reminder:</span> Please make sure your file matches the required template
                before importing. <a href="#" class="underline text-blue-600 hover:text-blue-800 ml-1" download>
                    Download Template </a>
            </div>

            <form method="POST" action="{{ route('inventory.import') }}" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="import_file" class="block text-gray-700 font-medium mb-1">Choose File</label>
                    <input type="file" name="file" id="import_file"
                        class="w-full border border-gray-300 rounded-md p-2 cursor-pointer" required>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                        onclick="document.getElementById('import-modal').classList.add('hidden')">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const importButton = document.getElementById('importButton');
            const importModal = document.getElementById('import-modal');

            importButton.addEventListener('click', function(e) {
                e.preventDefault(); // prevent default anchor behavior
                importModal.classList.remove('hidden');
            });
        });
    </script>

</x-layout>
