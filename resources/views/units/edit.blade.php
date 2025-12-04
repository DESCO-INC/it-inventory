<x-layout>
    <h1 class="text-xl font-semibold text-gray-800 mb-5">View Information</h1>

    <div class="grid grid-cols-6 gap-4">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden col-span-3">
            <!-- Table --><!-- Header -->
            <div class="px-6 py-5 border-b border-gray-200 flex items-center">
                <h1 class="text-xl font-semibold text-gray-800">Item Information</h1>

                <div class="flex-1"></div>

                <a href="{{ route('units.index') }}"
                    class="inline-block px-4 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600 transition font-medium ml-2 cursor-pointer">
                    back to list
                </a>


            </div>

            <div class="px-6 py-5 overflow-x-auto">
                <form action="{{ route('units.update', $unit->id) }}" method="POST"
                    class="space-y-6 grid grid-cols-3 gap-4" id="unitForm">
                    @csrf
                    @method('PUT')

                    <!-- Model Name -->
                    <div class="mb-2">
                        <x-form-label for="model_name">Model Name</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="model_name" name="model_name" value="{{ $unit['model_name'] }}"
                                readonly />
                            <x-form-error name='model_name' />
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-2">
                        <x-form-label for="unit_category_id">Category</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="cat_id" name="cat_id" value="{{ $unit->unit_category->name ?? '' }}"
                                readonly />
                            <x-form-input id="unit_category_id" name="unit_category_id" hidden />
                            <x-form-error name='serial' />
                        </div>
                        <x-form-error name='unit_category_id' value="{{ $unit['unit_category_id'] }}"></x-form-error>
                    </div>

                    <div class="mb-2">
                        <x-form-label for="control_no">Control Number</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="control_no" name="control_no" value="{{ $unit['control_no'] }}"
                                readonly />
                            <x-form-error name='control_no' />
                        </div>
                    </div>

                    <div class="mb-2">
                        <x-form-label for="serial">Serial</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="serial" name="serial" value="{{ $unit['serial'] }}" readonly />
                            <x-form-error name='serial' />
                        </div>
                    </div>

                    <div class="mb-2">
                        <x-form-label for="purchase_no">Purchase Reference</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="purchase_no" name="purchase_no" value="{{ $unit['purchase_no'] }}"
                                readonly />
                            <x-form-error name='purchase_no' />
                        </div>
                    </div>

                    <div class="mb-2">
                        <x-form-label for="purchase_date">Purchase Date</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="date" id="purchase_date" name="purchase_date"
                                value="{{ $unit['purchase_date'] }}" readonly />
                            <x-form-error name='purchase_date' />
                        </div>
                    </div>

                    <div class="mb-2">
                        <x-form-label for="manufacturing_date">Manufacturing Date</x-form-label>
                        <div class="mt-2">
                            <x-form-input type="date" id="manufacturing_date" name="manufacturing_date"
                                value="{{ $unit['manufacturing_date'] }}" readonly />
                            <x-form-error name='manufacturing_date' />
                        </div>
                    </div>

                    <div class="mb-2">
                        <x-form-label for="depreciation_date">Depreciation Date</x-form-label>
                        <div class="relative mt-2">
                            <input type="date" id="depreciation_date" name="depreciation_date" readonly
                                class="w-full pr-8 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                                value="{{ $unit['depreciation_date'] }}" />
                            <div class="absolute right-2 top-1/2 -translate-y-1/2 group">
                                <x-heroicon-o-information-circle
                                    class="w-4 h-4 text-gray-400 cursor-pointer hover:text-green-500" />
                                <div
                                    class="absolute right-0 mt-1 hidden group-hover:block bg-gray-800 text-white text-xs rounded-md px-2 py-1 whitespace-nowrap z-10 shadow-md">
                                    This is the computed depreciation start date.
                                </div>
                            </div>
                        </div>
                        <x-form-error name="depreciation_date" />
                    </div>

                    <div class="mb-2">
                        <x-form-label for="status">Status</x-form-label>
                        <select name="status" id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-focus:ring-green-500 focus:border-green-500 outline-none"
                            required disabled>
                            <option value="">Select Status</option>
                            <option value="ACTIVE" {{ $unit['status'] === 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                            <option value="INACTIVE" {{ $unit['status'] === 'INACTIVE' ? 'selected' : '' }}>INACTIVE
                            </option>
                            <option value="DISPOSED" {{ $unit['status'] === 'DISPOSED' ? 'selected' : '' }}>DISPOSED
                            </option>
                        </select>
                        <x-form-error name='status'></x-form-error>
                    </div>

                    <div class="mb-2 col-span-3">
                        <x-form-label for="remarks">Remarks</x-form-label>
                        <div class="mt-2">
                            <x-form-input id="remarks" name="remarks" value="{{ $unit['remarks'] }}" readonly />
                            <x-form-error name='remarks' />
                        </div>
                    </div>

                    <h1>Encoded by: {{ $unit['created_by'] }}</h1>

                    <!-- Form Actions -->
                    <div class="mt-3 flex items-center justify-end gap-3 pt-6 col-span-3">
                        <!-- Update Info Button -->
                        <button type="button" id="editButton"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                            Update Information
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" id="cancelButton"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition hidden">
                            Cancel
                        </button>

                        <!-- Save Changes Button -->
                        <button type="submit" id="saveButton"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition hidden">
                            Save Changes
                        </button>

                        <!-- Delete Button -->
                        <button type="button" id="deleteButton"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition hidden">
                            Delete
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden col-span-3">

            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-200 flex items-center">
                <h1 class="text-xl font-semibold text-gray-800">Item Accountability</h1>

                <div class="flex-1"></div>

                @if ($unit['status'] === 'ACTIVE')
                    <a id="addUserBtn"
                        class="inline-block px-4 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600 transition font-medium ml-2 cursor-pointer">
                        Add User
                    </a>
                @endif


                <a href="{{ route('accountability.print', ['inventory_id' => $unit->id]) }}" target="_blank"
                    class="inline-block px-4 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600 transition font-medium ml-2 cursor-pointer">
                    Print Accountability
                </a>


            </div>

            <!-- Table -->
            <div class="px-6 py-5 overflow-x-auto">

                @foreach ($accountability as $item)
                    <a href="#"
                        class="block max-w-2xl mx-auto rounded-md shadow-md p-4 flex items-start space-x-4 transform transition duration-300 hover:scale-105 hover:shadow-xl cursor-pointer mb-2"
                        style="background-color: #00c950;" data-id="{{ $item->id }}"
                        data-name="{{ $item->name }}" data-department="{{ $item->department }}"
                        data-location="{{ $item->location }}" data-date-received="{{ $item->date_received }}"
                        data-date-returned="{{ $item->date_returned }}">
                        <x-heroicon-s-user class="w-8 h-8 text-white mt-1" />
                        <div class="flex-1 flex flex-col space-y-1">
                            <div class="flex items-center space-x-2 text-xs text-white">
                                <span class="font-semibold">{{ $item->name }}</span>
                                <span>•</span>
                                <span class="text-white/80">{{ $item->department }}</span>
                            </div>
                            <div class="flex space-x-4 text-white text-xs mt-1">
                                <span class="flex items-center space-x-1">
                                    <x-heroicon-s-map-pin class="w-4 h-4" />
                                    <span>{{ $item->location }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <x-heroicon-s-calendar class="w-4 h-4" />
                                    <span>Received: {{ $item->date_received }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <x-heroicon-s-calendar class="w-4 h-4" />
                                    <span>Return: {{ $item->date_returned }}</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Delete Modal -->
    <div id="delete-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Delete</h2>
            <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete this item? This action cannot be
                undone.</p>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                    onclick="document.getElementById('delete-modal').classList.add('hidden')">
                    Cancel
                </button>

                <form method="POST" action="{{ route('units.destroy', $unit->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- Add User Modal -->
    <div id="addUserModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Add User</h2>
            <p class="mt-2 text-sm text-gray-600">Fill out the form below to add a new user.</p>

            <!-- Form -->
            <form action="{{ url('/accountability') }}" method="POST" class="mt-4 space-y-3">
                @csrf

                <input type="text" name="inventory_id" value="{{ $unit['id'] }}" hidden>

                <div class="mb-2">
                    <x-form-label>Name</x-form-label>
                    <div class="mt-2">
                        <x-form-input id="name" name="name" placeholder="Jane Smith" required />
                        <x-form-error name='name' />
                    </div>
                </div>

                <!-- Department -->
                <div class="mb-2">
                    <x-form-label for="department">Department</x-form-label>
                    <select name="department" id="department"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-focus:ring-green-500 focus:border-green-500 outline-none"
                        required>
                        <option value="">Select Department</option>
                        @foreach ($department as $departments)
                            <option value="{{ $departments->department }}">
                                {{ $departments->department }}
                            </option>
                        @endforeach
                    </select>
                    <x-form-error name='department'></x-form-error>
                </div>

                <div class="mb-2">
                    <x-form-label>Location</x-form-label>
                    <div class="mt-2">
                        <x-form-input id="location" name="location" placeholder="LIIP" required />
                        <x-form-error name='location' />
                    </div>
                </div>

                <div class="mb-2">
                    <x-form-label>Date Received</x-form-label>
                    <div class="mt-2">
                        <x-form-input type="date" id="date_received" name="date_received" required />
                        <x-form-error name='date_received' />
                    </div>
                </div>

                <div class="mb-2">
                    <x-form-label>Date Returned</x-form-label>
                    <div class="mt-2">
                        <x-form-input type="date" id="date_returned" name="date_returned" />
                        <x-form-error name='date_returned' />
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                        onclick="document.getElementById('addUserModal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update User Modal -->
    <div id="updateUserModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Update User</h2>
            <p class="mt-2 text-sm text-gray-600">Modify the details below.</p>

            <!-- Form -->
            <form id="updateUserForm" method="POST" class="mt-4 space-y-3">
                @csrf
                @method('PUT')

                <input type="hidden" id="update_id" name="id">
                <input type="hidden" name="inventory_id" value="{{ $unit['id'] }}">

                <div class="mb-2">
                    <x-form-label>Name</x-form-label>
                    <div class="mt-2">
                        <x-form-input id="update_name" name="name" required />
                    </div>
                </div>

                <!-- Department -->
                <div class="mb-2">
                    <x-form-label for="update_department">Department</x-form-label>
                    <select name="department" id="update_department"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 outline-none"
                        required>
                        <option value="">Select Department</option>
                        @foreach ($department as $departments)
                            <option value="{{ $departments->department }}">{{ $departments->department }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <x-form-label>Location</x-form-label>
                    <div class="mt-2">
                        <x-form-input id="update_location" name="location" required />
                    </div>
                </div>

                <div class="mb-2">
                    <x-form-label>Date Received</x-form-label>
                    <div class="mt-2">
                        <x-form-input type="date" id="update_date_received" name="date_received" required />
                    </div>
                </div>

                <div class="mb-2">
                    <x-form-label>Date Returned</x-form-label>
                    <div class="mt-2">
                        <x-form-input type="date" id="update_date_returned" name="date_returned" required />
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                        onclick="document.getElementById('updateUserModal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editButton');
            const saveButton = document.getElementById('saveButton');
            const cancelButton = document.getElementById('cancelButton');
            const deleteButton = document.getElementById('deleteButton');
            const deleteModal = document.getElementById('delete-modal');
            const form = document.getElementById('unitForm');

            const enableInputs = () => {
                form.querySelectorAll('input, select, textarea').forEach(el => {
                    if (el.id !== 'unit_category_id') {
                        el.removeAttribute('readonly');
                        el.removeAttribute('disabled');
                    }
                });
            };

            const disableInputs = () => {
                form.querySelectorAll('input, select, textarea').forEach(el => {
                    if (el.tagName === 'SELECT') {
                        el.setAttribute('disabled', true);
                    } else {
                        el.setAttribute('readonly', true);
                    }
                });
            };

            // When Update Information is clicked
            editButton.addEventListener('click', function() {
                enableInputs();
                editButton.classList.add('hidden');
                saveButton.classList.remove('hidden');
                cancelButton.classList.remove('hidden');
                deleteButton.classList.remove('hidden'); // Show Delete button
            });

            // When Cancel is clicked
            cancelButton.addEventListener('click', function() {
                disableInputs();
                cancelButton.classList.add('hidden');
                saveButton.classList.add('hidden');
                deleteButton.classList.add('hidden'); // Hide Delete button
                editButton.classList.remove('hidden');
            });

            // Show Delete Modal on Delete button click
            deleteButton.addEventListener('click', function() {
                deleteModal.classList.remove('hidden');
            });

            // Disable inputs on page load
            disableInputs();
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateModal = document.getElementById('updateUserModal');
            const updateForm = document.getElementById('updateUserForm');

            document.querySelectorAll('[data-id]').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Get data from clicked card
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const department = this.dataset.department;
                    const location = this.dataset.location;
                    const dateReceived = this.dataset.dateReceived;
                    const dateReturned = this.dataset.dateReturned;

                    // Fill the modal fields
                    document.getElementById('update_id').value = id;
                    document.getElementById('update_name').value = name;
                    document.getElementById('update_department').value = department;
                    document.getElementById('update_location').value = location;
                    document.getElementById('update_date_received').value = dateReceived;
                    document.getElementById('update_date_returned').value = dateReturned;

                    // Update form action URL dynamically
                    const baseUrl = "{{ url('/') }}";
                    updateForm.action = `${baseUrl}/accountability/${id}`;

                    // Show modal
                    updateModal.classList.remove('hidden');
                });
            });
        });
    </script>


    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('unit_category_id');
            const controlInput = document.getElementById('control_no');
            const purchaseDateInput = document.getElementById('purchase_date');
            const depreciationDateInput = document.getElementById('depreciation_date');

            // When category changes
            categorySelect.addEventListener('change', async function() {
                const categoryId = categorySelect.value;

                // Recalculate depreciation if a purchase date already exists
                if (purchaseDateInput.value) {
                    fillDepreciationDate();
                }

                if (!categoryId) {
                    controlInput.value = '';
                    return;
                }

                try {
                    const baseUrl = "{{ url('/') }}";
                    const response = await fetch(`${baseUrl}/units/next-control/${categoryId}`)
                    const data = await response.json();

                    // Example format: LGU-11-20004
                    const controlNumber =
                        `${data.code}-${data.nextId}-${data.countIndex}${String(data.totalSameCategory + 1).padStart(4, '0')}`;
                    controlInput.value = controlNumber;
                } catch (error) {
                    console.error('Error fetching next control number:', error);
                    controlInput.value = '';
                }
            });

            // When purchase date changes
            purchaseDateInput.addEventListener('change', fillDepreciationDate);

            // Function to calculate depreciation date
            function fillDepreciationDate() {
                const purchaseDateValue = purchaseDateInput.value;
                if (!purchaseDateValue) {
                    depreciationDateInput.value = '';
                    console.log("No purchase date selected");
                    return;
                }

                const purchaseDate = new Date(purchaseDateValue);
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                if (!selectedOption) {
                    depreciationDateInput.value = '';
                    return;
                }

                const yearsDepreciation = parseInt(selectedOption.getAttribute('data-depreciation')) || 0;
                if (yearsDepreciation > 0) {
                    const depreciationDate = new Date(purchaseDate);
                    depreciationDate.setFullYear(depreciationDate.getFullYear() + yearsDepreciation);
                    depreciationDateInput.value = depreciationDate.toISOString().split('T')[0];
                } else {
                    depreciationDateInput.value = '';
                }
            }
        });
    </script>

    <!-- JavaScript -->
    <script>
        const addUserBtn = document.getElementById('addUserBtn');
        const addUserModal = document.getElementById('addUserModal');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');

        // Open modal
        addUserBtn.addEventListener('click', () => {
            addUserModal.classList.remove('hidden');
        });

        // Close modal
        closeModal.addEventListener('click', () => {
            addUserModal.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            addUserModal.classList.add('hidden');
        });

        // Close modal when clicking outside the modal content
        window.addEventListener('click', (e) => {
            if (e.target === addUserModal) {
                addUserModal.classList.add('hidden');
            }
        });
    </script>

</x-layout>
