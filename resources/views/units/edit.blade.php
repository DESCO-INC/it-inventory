<x-layout>
    <x-card class="mb-2">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-medium text-gray-800">Manage Inventory</h2>

            <div class="flex gap-2 mt-4 sm:mt-0">
                <x-button size="sm" id="btn_back" href="{{ route('units.index') }}" variant="gray">
                    Back
                </x-button>
            </div>
        </div>
    </x-card>

    <div class="grid grid-cols-2 grid-rows-2 gap-2">
        <x-card class="row-span-2">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                <h2 class="text-lg font-medium text-gray-800">Inventory Information</h2>
                <!-- Button Row (Right) -->
                <div class="flex gap-2 mt-4 sm:mt-0">
                    <form action="{{ route('units.update', $unit) }}" method="POST" id="unitForm">
                        <x-button size="sm" id="editButton" onclick="toggleButtons()">Update Information</x-button>
                        <x-button size="sm" id="saveButton" type="submit" class="hidden">Save Changes</x-button>
                        <x-button size="sm" id="deleteButton" onclick="toggleModal('deleteInventory_modal')"
                            class="hidden" variant="error">Delete</x-button>
                        <x-button size="sm" id="cancelButton" onclick="toggleButtons()" class="hidden"
                            variant="gray">Cancel</x-button>
                </div>
            </div>
            <div class="overflow-x-auto mt-4">
                <fieldset class="inventory_form space-y-6 grid grid-cols-2 gap-4" disabled>
                    @csrf
                    @method('PUT')

                    <!-- Model Name -->
                    <div class="mb-1">
                        <x-input label="Model Name" name="model_name" class="w-full" value="{{ $unit['model_name'] }}"
                            readonly="true" />
                    </div>

                    <!-- Category -->
                    <div class="mb-1">
                        <x-input label="Category" name="cat_id" class="w-full"
                            value="{{ $unit->unit_category->name ?? '' }}" readonly="true" />
                    </div>

                    <div class="mb-1">
                        <x-input label="Control Number" name="control_no" class="w-full"
                            value="{{ $unit['control_no'] }}" readonly="true" />
                    </div>

                    <div class="mb-1">
                        <x-input label="Serial" name="serial" class="w-full" value="{{ $unit['serial'] }}"
                            readonly="true" />
                    </div>

                    <div class="mb-1">
                        <x-input label="Purchase Number" name="purchase_no" class="w-full"
                            value="{{ $unit['purchase_no'] }}" />
                    </div>

                    <div class="mb-1">
                        <x-input label="Purchase Date" name="purchase_date" type="date" class="w-full"
                            value="{{ $unit['purchase_date'] }}" />
                    </div>

                    <div class="mb-1">
                        <x-input label="Manufacturing Date" name="manufacturing_date" type="date" class="w-full"
                            value="{{ $unit['manufacturing_date'] }}" />
                    </div>

                    <div class="mb-1">
                        <x-input label="Depreciation Date" name="depreciation_date" type="date" class="w-full"
                            value="{{ $unit['depreciation_date'] }}" />
                    </div>

                    <div class="mb-1">
                        <x-select label="Status" id="status" name="credential" :options="[
                            '' => 'Select Status',
                            'ACTIVE' => 'ACTIVE',
                            'DEFECTIVE' => 'DEFECTIVE',
                            'DISPOSED' => 'DISPOSED',
                        ]" width="full"
                            :value="$unit['status']" required />
                    </div>

                    <div class="mb-1">
                        <x-input label="Remarks" name="remarks" class="w-full" value="{{ $unit['remarks'] }}" />
                    </div>

                    <div class="mb-1 hidden" id="unitWeightField">
                        <x-input label="Unit Weight (kg)" name="unit_weight" type="number" class="w-full"
                            value="{{ $unit['remarks'] }}" />
                    </div>

                    <div class="mb-1 hidden" id="disposedLocationField">
                        <x-input label="Disposed Location" name="disposed_location" class="w-full"
                            value="{{ $unit['disposed_location'] }}" />
                    </div>
                    </form>
                </fieldset>
            </div>
        </x-card>

        <x-card class="col-start-2 h-[300px] flex flex-col">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                <h2 class="text-lg font-medium text-gray-800">Assigned Accountability</h2>

                <div class="flex gap-2 mt-4 sm:mt-0">
                    @if ($unit['status'] === 'ACTIVE')
                        <button class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600"
                            onclick="toggleModal('addUser_modal')">
                            Add User
                        </button>
                    @endif

                    <a href="{{ route('accountability.print', ['inventory_id' => $unit->id]) }}" target="_blank"
                        class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">
                        Print Accountability
                    </a>
                </div>
            </div>

            <!-- Scrollable list -->
            <div class="flex-1 overflow-y-auto pr-1">
                @foreach ($accountability as $index => $item)
                    <button type="button"
                        class="btn_updateUser block w-full text-left rounded-md shadow-sm p-3 flex items-start space-x-3 hover:shadow-md cursor-pointer mb-2 {{ $index === 0 ? 'bg-[#00c950] text-white border-none' : 'bg-[#f3f3f3] text-black border-[1.5px] border-[#00c950]' }}"
                        data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                        data-department="{{ $item->department }}" data-location="{{ $item->location }}"
                        data-history="{{ $item->history }}" data-date-received="{{ $item->date_received }}"
                        data-date-returned="{{ $item->date_returned }}">

                        <x-heroicon-s-user
                            class="w-6 h-6 {{ $index === 0 ? 'text-white' : 'text-green-600' }} mt-0.5" />

                        <div class="flex-1 flex flex-col space-y-0.5">
                            <div
                                class="flex items-center space-x-2 text-[11px] {{ $index === 0 ? 'text-white' : 'text-green-600' }}">
                                <span class="font-semibold">{{ $item->name }}</span>
                                <span>•</span>
                                <span class="{{ $index === 0 ? 'text-white/80' : 'text-green-600' }}">
                                    {{ $item->department }}
                                </span>
                                <span>•</span>
                                <span class="flex items-center space-x-1">
                                    <x-heroicon-s-map-pin class="w-3.5 h-3.5" />
                                    <span>{{ $item->location }}</span>
                                </span>
                            </div>

                            <div class="text-[11px] mt-0.5 {{ $index === 0 ? 'text-white' : 'text-green-600' }}">
                                <strong>History:</strong>
                                <span>{{ $item->history }}</span>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-card>

        <x-card class="col-start-2 row-start-2 h-[300px] flex flex-col">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
                <h2 class="text-lg font-medium text-gray-800">Installed Applications</h2>

                <div class="flex gap-2 mt-4 sm:mt-0">
                    <x-button size="sm" onclick="toggleModal('addApp_modal')">
                        Add Application
                    </x-button>
                </div>
            </div>

            <!-- Scroll Container (takes remaining space) -->
            <div class="flex-1 overflow-y-auto border border-[#00c950] rounded-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-green-500 text-white sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium">Software</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Date Installed</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Installed By</th>
                            <th class="px-4 py-2 text-center text-sm font-medium w-15">Options</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($software as $soft)
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $soft->software->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $soft->installed_at }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $soft->installed_by }}</td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-button size="xs" variant="info" class="btn_updateApp"
                                        data-id="{{ $soft->id }}" data-software_id="{{ $soft->software->id }}"
                                        data-product_key="{{ $soft->product_key }}"
                                        data-installed_at="{{ $soft->installed_at }}">
                                        Manage
                                    </x-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                                    No records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

    <!-- Delete Modal -->
    <div id="deleteInventory_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Delete</h2>
            <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete this item? This action cannot be
                undone.</p>
            <p class="mt-2 text-sm text-gray-600"><strong>Please note that both the assigned accountability and
                    installed software records will also be deleted. Proceed with caution.</strong></p>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                    onclick="toggleModal('deleteInventory_modal')">
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
    <div id="addUser_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Add User</h2>
            <p class="mt-2 text-sm text-gray-600">Fill out the form below to add a new user.</p>

            <!-- Form -->
            <form action="{{ route('accountability.store') }}" method="POST" class="mt-4 space-y-3">
                @csrf

                <input type="text" name="inventory_id" value="{{ $unit['id'] }}" hidden>

                <div class="mb-2">
                    <x-input label="Name" name="name" class="w-full" placeholder="Perseus Pogi" required />
                </div>

                <div class="mb-2">
                    <x-select label="Department" name="department" :options="['' => 'Select Department'] +
                        collect($department)->mapWithKeys(fn($i) => [$i => $i])->toArray()" width="full" required />
                </div>

                <div class="mb-2">
                    <x-input label="Location" name="location" class="w-full" placeholder="LIIP" required />
                </div>

                <div class="mb-2">
                    <x-input label="Repair History" name="history" class="w-full" />
                </div>

                <div class="mb-2">
                    <x-input label="Date Received" type="date" name="date_received" class="w-full" required />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-button variant="gray" onclick="toggleModal('addUser_modal')">
                        Cancel
                    </x-button>
                    <x-button type="submit">
                        Save
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update User Modal -->
    <div id="updateUser_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Update User</h2>
            <p class="mt-2 text-sm text-gray-600">Modify the details below.</p>

            <!-- Form -->
            <form id="updateUser_form" method="POST" class="mt-4 space-y-3">
                @csrf
                @method('PUT')

                <input type="hidden" id="update_id" name="id">
                <input type="hidden" name="inventory_id" value="{{ $unit['id'] }}">

                <div class="mb-2">
                    <x-input label="Name" id="update_name" name="name" class="w-full"
                        placeholder="Perseus Pogi" required />
                </div>

                <div class="mb-2">
                    <x-select label="Department" id="update_department" name="department" :options="['' => 'Select Department'] +
                        collect($department)->mapWithKeys(fn($i) => [$i => $i])->toArray()"
                        width="full" required />
                </div>

                <div class="mb-2">
                    <x-input label="Location" id="update_location" name="location" class="w-full"
                        placeholder="LIIP" required />
                </div>

                <div class="mb-2">
                    <x-input label="Repair History" id="update_history" name="history" class="w-full" />
                </div>

                <div class="mb-2">
                    <x-input label="Date Received" id="update_date_received" type="date" name="date_received"
                        class="w-full" required />
                </div>

                <div class="mb-2">
                    <x-input label="Date Returned" id="update_date_returned" type="date" name="date_returned"
                        class="w-full" />
                </div>

                <div class="mt-6 flex justify-between space-x-3">
                    <!-- Delete Button on the left -->
                    <x-button variant="error" id="btn_deleteUser" class="h-10">
                        Delete
                    </x-button>

                    <!-- Cancel & Save Buttons on the right -->
                    <div class="flex space-x-3">
                        <x-button variant="gray" onclick="toggleModal('updateUser_modal')" class="h-10">
                            Cancel
                        </x-button>
                        <x-button type="submit" class="h-10">
                            Save
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteUser_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Delete</h2>
            <p class="mt-2 text-sm text-gray-600">
                Are you sure you want to delete this accountability record? This action cannot be undone.
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                    onclick="document.getElementById('deleteModal').classList.add('hidden')">
                    Cancel
                </button>

                <form id="deleteUser_form" method="POST">
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

    <!-- Add App Modal -->
    <div id="addApp_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Add Application</h2>
            <p class="mt-2 text-sm text-gray-600">Please Select an app to add and fill the form.</p>

            <!-- Form -->
            <form action="{{ route('inventory_software.store') }}" method="POST" class="mt-4 space-y-3">
                @csrf

                <input type="text" name="inventory_id" value="{{ $unit['id'] }}" hidden>

                <div class="mb-2">
                    <x-select label="Software" name="software_id" :options="['' => 'Select Software'] +
                        $softwareLists->mapWithKeys(fn($i) => [$i->id => $i->name])->toArray()" width="full" required />
                </div>

                <div class="mb-2">
                    <x-input label="Product Key" name="product_key" class="w-full" placeholder="optional" />
                </div>

                <div class="mb-2">
                    <x-input label="Installation Date" type="date" name="installed_at" class="w-full" required />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-button variant="gray" onclick="toggleModal('addApp_modal')">
                        Cancel
                    </x-button>
                    <x-button type="submit">
                        Save
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update App Modal -->
    <div id="updateApp_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Update Application</h2>
            <p class="mt-2 text-sm text-gray-600">Please Select an app to add and fill the form.</p>

            <!-- Form -->
            <form id="updateApp_form" method="POST" class="mt-4 space-y-3">
                @csrf
                @method('PUT')
                <input type="hidden" id="updateApp_id" name="id">

                <div class="mb-2">
                    <x-select label="Software" id="updateApp_software_id" name="software_id" :options="['' => 'Select Software'] +
                        $softwareLists->mapWithKeys(fn($i) => [$i->id => $i->name])->toArray()"
                        width="full" required />
                </div>

                <div class="mb-2">
                    <x-input label="Product Key" id="updateApp_product_key" name="product_key" class="w-full"
                        placeholder="optional" />
                </div>

                <div class="mb-2">
                    <x-input label="Installation Date" id="updateApp_installed_at" type="date"
                        name="installed_at" class="w-full" required />
                </div>


                <div class="mt-6 flex justify-between space-x-3">
                    <!-- Delete Button on the left -->
                    <x-button variant="error" id="btn_deleteApp" class="h-10">
                        Delete
                    </x-button>

                    <!-- Cancel & Save Buttons on the right -->
                    <div class="flex space-x-3">
                        <x-button variant="gray" onclick="toggleModal('updateApp_modal')">
                            Cancel
                        </x-button>
                        <x-button type="submit">
                            Save
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteApp_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Delete</h2>
            <p class="mt-2 text-sm text-gray-600">
                Are you sure you want to delete this application record? This action cannot be undone.
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                    onclick="toggleModal('deleteApp_modal')">
                    Cancel
                </button>

                <form id="deleteApp_form" method="POST">
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

    <script>
        function toggleModal(modalId) {
            $('#' + modalId).toggleClass('hidden');
        }

        function toggleButtons() {
            $('.inventory_form').prop('disabled', !$('.inventory_form').prop('disabled'));
            $('#editButton').toggleClass('hidden');
            $('#saveButton').toggleClass('hidden');
            $('#deleteButton').toggleClass('hidden');
            $('#cancelButton').toggleClass('hidden');
        }

        $('.btn_updateUser').on('click', function() {
            let $updateUser_modal = $('#updateUser_modal');
            let $updateUser_form = $('#updateUser_form');

            $updateUser_modal.toggleClass('hidden');
            let id = $(this).data('id');
            let name = $(this).data('name');
            let department = $(this).data('department');
            let location = $(this).data('location');
            let history = $(this).data('history');
            let dateReceived = $(this).data('dateReceived');
            let dateReturned = $(this).data('dateReturned');

            $('#update_id').val(id);
            $('#update_name').val(name);
            $('#update_department').val(department);
            $('#update_location').val(location);
            $('#update_history').val(history);
            $('#update_date_received').val(dateReceived);
            $('#update_date_returned').val(dateReturned);

            baseUrl = "{{ url('/') }}";
            $updateUser_form.attr('action', `${baseUrl}/accountability/${id}`);
        });


        $('#btn_deleteUser').on('click', function() {
            let $deleteUser_modal = $('#deleteUser_modal');
            let $deleteUser_form = $('#deleteUser_form');
            $deleteUser_modal.toggleClass('hidden');
            $selected_id = $('#update_id').val();

            let baseUrl = "{{ route('accountability.destroy', ['id' => '__id__']) }}";
            $deleteUser_form.attr('action', baseUrl.replace('__id__', $selected_id));
        });

        $('.btn_updateApp').on('click', function() {
            let $updateApp_modal = $('#updateApp_modal');
            let $updateApp_form = $('#updateApp_form');

            $updateApp_modal.toggleClass('hidden');

            let id = $(this).data('id');
            let software_id = $(this).data('software_id');
            let product_key = $(this).data('product_key');
            let installed_at = $(this).data('installed_at');

            $('#updateApp_id').val(id);
            $('#updateApp_software_id').val(software_id);
            $('#updateApp_product_key').val(product_key);
            $('#updateApp_installed_at').val(installed_at);

            let baseUrl = "{{ url('/') }}";

            // ✅ correct route + variable
            $updateApp_form.attr('action', `${baseUrl}/inventory_software/${id}`);
        });

        $('#btn_deleteApp').on('click', function() {
            let $deleteApp_modal = $('#deleteApp_modal');
            let $deleteApp_form = $('#deleteApp_form');
            $deleteApp_modal.toggleClass('hidden');
            $selected_id = $('#updateApp_id').val();

            let baseUrl = "{{ route('inventory_software.destroy', ['inventory_software' => '__id__']) }}";
            $deleteApp_form.attr('action', baseUrl.replace('__id__', $selected_id));
        });
    </script>
</x-layout>
