<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-color)]">Manage Inventory</h1>
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('inventory.index')], ['label' => 'Manage']]" />
        </div>
    </div>

    <div class="grid grid-cols-2 grid-rows-[1fr_1fr] gap-2">
        <div class="mb-2 bg-white rounded-lg shadow-sm row-span-2 relative overflow-hidden px-6 py-4">
            <form action="{{ route('inventory.update', $inventory) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-lg font-bold text-[var(--text-color)]">
                        Inventory Information
                    </h1>

                    <div class="flex items-center gap-1.5">

                        <x-button size="sm" id="editButton" onclick="toggleEdit()">
                            Update
                        </x-button>

                        <x-button type="submit" size="sm" bg="bg-[var(--success-color)]" id="saveButton" hidden>
                            Save
                        </x-button>

                        <x-button size="sm" bg="bg-[var(--danger-color)]" id="deleteButton"
                            onclick="toggleModal('deleteInventory_modal')" hidden>
                            Delete
                        </x-button>

                        <x-button size="sm" bg="bg-[var(--primary-color)]"
                            border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]" id="cancelButton"
                            onclick="toggleEdit()" hidden>
                            Cancel
                        </x-button>

                    </div>
                </div>

                <fieldset id="inventoryFieldset" class="grid grid-cols-2 gap-4" disabled>

                    <x-input label="Model Name" name="model_name" value="{{ $inventory['model_name'] }}" readonly />
                    <x-input label="Category" name="cat_id" value="{{ $inventory->unit_category->name ?? '' }}"
                        readonly />
                    <x-input label="Control Number" name="control_no" value="{{ $inventory['control_no'] }}" readonly />
                    <x-input label="Serial" name="serial" value="{{ $inventory['serial'] }}" />
                    <x-input label="Purchase Reference" value="{!! html_entity_decode($inventory['purchase_no']) !!}" name="purchase_no" />
                    <x-input label="Purchase Date" name="purchase_date" value="{{ $inventory['purchase_date'] }}"
                        type="date" />
                    <x-input label="Manufacturing Date" name="manufacturing_date"
                        value="{{ $inventory['manufacturing_date'] }}" type="date" />
                    <x-input label="Depreciation Date" name="depreciation_date"
                        value="{{ $inventory['depreciation_date'] }}" type="date" />

                    <x-select label="Status" name="status" required>
                        <option value="ACTIVE" @selected(old('status', $inventory->status) == 'ACTIVE')>
                            ACTIVE
                        </option>
                        <option value="DEFECTIVE" @selected(old('status', $inventory->status) == 'DEFECTIVE')>
                            DEFECTIVE
                        </option>
                        <option value="DISPOSED" @selected(old('status', $inventory->status) == 'DISPOSED')>
                            DISPOSED
                        </option>
                    </x-select>

                    <x-input label="Remarks" name="remarks" value="{{ $inventory['remarks'] }}" />

                    <div id="disposedFields" class="contents">
                        <x-input label="Unit Weight" name="unit_weight"
                            value="{{ old('unit_weight', $inventory->unit_weight) }}" />

                        <x-input label="Disposed Location" name="disposed_location"
                            value="{{ old('disposed_location', $inventory->disposed_location) }}" />
                    </div>

                </fieldset>

            </form>
        </div>

        <div class="mb-2 bg-white rounded-lg shadow-sm relative h-[300px] flex flex-col overflow-hidden px-6 py-4">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-lg font-bold text-[var(--text-color)]">
                    Assigned Accountability
                </h1>

                <div class="flex items-center gap-1.5">
                    @if ($inventory['status'] === 'ACTIVE')
                        <x-button size="sm" id="editButton" onclick="toggleModal('addUser_modal')">
                            Assign User
                        </x-button>
                    @endif

                    <x-link size="sm"
                        href="{{ route('accountability.print', ['inventory_id' => $inventory->id]) }}" target="_blank">
                        Print Accountability
                    </x-link>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto pr-1">
                @foreach ($accountability as $index => $item)
                    <button type="button" onclick='Edit_User_Modal(@json($item))'
                        class="block w-full text-left rounded-md shadow-sm p-3 flex items-start space-x-3 hover:shadow-md cursor-pointer mb-2
            {{ $index === 0
                ? 'bg-[var(--accent-color)] text-[var(--primary-color)] border-none'
                : 'bg-[var(--secondary-color)]/40 text-[var(--text-color)] border border-[var(--secondary-border-color)] hover:bg-[var(--secondary-color)]/60' }}">

                        <x-heroicon-s-user
                            class="w-6 h-6 {{ $index === 0 ? 'text-[var(--primary-color)]' : 'text-[var(--accent-color)]' }} mt-0.5" />

                        <div class="flex-1 flex flex-col space-y-0.5">
                            <div
                                class="flex items-center space-x-2 text-[11px] {{ $index === 0 ? 'text-[var(--primary-color)]' : 'text-[var(--accent-color)]' }}">
                                <span class="font-semibold">{{ $item->name }}</span>
                                <span>•</span>
                                <span
                                    class="{{ $index === 0 ? 'text-[var(--primary-color)]/80' : 'text-[var(--text-color)]/70' }}">
                                    {{ $item->department }}
                                </span>
                                <span>•</span>
                                <span class="flex items-center space-x-1">
                                    <x-heroicon-s-map-pin class="w-3.5 h-3.5" />
                                    <span>{{ $item->location }}</span>
                                </span>
                            </div>

                            <div
                                class="text-[11px] mt-0.5 {{ $index === 0 ? 'text-[var(--primary-color)]' : 'text-[var(--text-color)]/70' }}">
                                <strong>History:</strong>
                                <span>{{ $item->history }}</span>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="mb-2 bg-white rounded-lg shadow-sm relative h-[300px] flex flex-col overflow-hidden px-6 py-4">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-lg font-bold text-[var(--text-color)]">
                    Installed Applications
                </h1>

                <div class="flex items-center gap-1.5">
                    <x-button size="sm" onclick="toggleModal('addApp_modal')">
                        Add Application
                    </x-button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto border border-[var(--secondary-border-color)] rounded-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-[var(--accent-color)]/90 text-[var(--primary-color)] sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium">Software</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Date Installed</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Date Expiration</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Installed By</th>
                            <th class="px-4 py-2 text-center text-sm font-medium w-15">Options</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($software as $soft)
                            <tr>
                                <td class="px-4 py-3 text-xs">{{ $soft->software->name }}</td>
                                <td class="px-4 py-3 text-xs">{{ $soft->date_installed }}</td>
                                <td class="px-4 py-3 text-xs">{{ $soft->date_expired }}</td>
                                <td class="px-4 py-3 text-xs">{{ $soft->installed_by }}</td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-button size="sm" onclick="Edit_App_Modal({{ $soft }})">
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
        </div>
    </div>

    <!-- Delete Inventory Modal -->
    <div id="deleteInventory_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Delete Inventory
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to delete this inventory item?
                </p>

                <p class="mt-3 text-sm text-red-600">
                    This action cannot be undone. Any assigned accountability and installed software records associated
                    with this inventory will also be permanently deleted.
                </p>
            </div>

            <div class="mt-6 flex justify-end gap-3">

                <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                    border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                    onclick="toggleModal('deleteInventory_modal')">
                    Cancel
                </x-button>

                <form method="POST" action="{{ route('inventory.destroy', $inventory->id) }}">
                    @csrf
                    @method('DELETE')

                    <x-button type="submit" size="md" bg="bg-[var(--danger-color)]">
                        Delete
                    </x-button>
                </form>

            </div>

        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUser_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">

            <form action="{{ route('accountability.store') }}" method="POST">
                @csrf
                <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Assign Accountability
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Fill in the details below to assign this inventory item to a user.
                    </p>
                </div>

                <div class="mt-6 space-y-4">
                    <x-input label="Name" name="name" required />

                    <x-select label="Department" name="department" required>
                        <option value="">Select Department</option>
                        @foreach ($department as $dept)
                            <option value="{{ $dept }}" @selected(old('department') == $dept)>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input label="Location" name="location" required />
                    <x-input label="Repair History" name="history" placeholder="Optional" />
                    <x-input label="Date Received" type="date" name="date_received" required />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                        border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                        onclick="toggleModal('addUser_modal')">
                        Cancel
                    </x-button>

                    <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                        Save User
                    </x-button>
                </div>

            </form>

        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="userEdit_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">

            <form id="userEdit_form" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" id="update_id" name="id">
                <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Update Accountability
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Modify the assigned user's information.
                    </p>
                </div>

                <div class="mt-6 space-y-4">
                    <x-input id="update_name" label="Name" name="name" required />

                    <x-select id="update_department" label="Department" name="department" required>
                        <option value="">Select Department</option>
                        @foreach ($department as $dept)
                            <option value="{{ $dept }}">
                                {{ $dept }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input id="update_location" label="Location" name="location" required />
                    <x-input id="update_history" label="Repair History" name="history" />
                    <x-input id="update_date_received" label="Date Received" type="date" name="date_received"
                        required />
                    <x-input id="update_date_returned" label="Date Returned" type="date" name="date_returned" />
                </div>

                <div class="mt-6 flex items-center justify-between">

                    <x-button type="button" size="md" bg="bg-[var(--danger-color)]"
                        onclick="Delete_User_Modal($('#update_id').val())">
                        Delete
                    </x-button>

                    <div class="flex gap-3">
                        <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                            border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                            onclick="toggleModal('userEdit_modal')">
                            Cancel
                        </x-button>

                        <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                            Save Changes
                        </x-button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- Delete User Modal -->
    <div id="userDelete_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Delete Accountability
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to delete this accountability record?
                </p>

                <p class="mt-3 text-sm text-red-600">
                    This action cannot be undone. Once deleted, the accountability record
                    will be permanently removed.
                </p>
            </div>

            <div class="mt-6 flex justify-end gap-3">

                <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                    border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                    onclick="toggleModal('userDelete_modal')">
                    Cancel
                </x-button>

                <form id="userDelete_form" method="POST">
                    @csrf
                    @method('DELETE')

                    <x-button type="submit" size="md" bg="bg-[var(--danger-color)]">
                        Delete
                    </x-button>
                </form>

            </div>

        </div>
    </div>

    <!-- Add App Modal -->
    <div id="addApp_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">

            <form action="{{ route('inventory_software.store') }}" method="POST">
                @csrf
                <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Add Application
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Assign software to this inventory item.
                    </p>
                </div>

                <div class="mt-6 space-y-4">

                    <x-select label="Software" name="software_id" required>
                        <option value="">Select Software</option>
                        @foreach ($softwareLists as $software)
                            <option value="{{ $software->id }}">
                                {{ $software->name }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input label="Product Key" name="product_key" />

                    <x-input label="Remarks" name="remarks" />

                    <x-input label="Installation Date" type="date" name="date_installed" required />

                    <x-input label="Expiration Date" type="date" name="date_expired" />

                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                        border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                        onclick="toggleModal('addApp_modal')">
                        Cancel
                    </x-button>

                    <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                        Save Application
                    </x-button>

                </div>

            </form>

        </div>
    </div>

    <!-- Edit App Modal -->
    <div id="appEdit_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">

            <form id="appEdit_form" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" id="updateApp_id" name="id">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Update Application
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Modify the application details for this inventory item.
                    </p>
                </div>

                <div class="mt-6 space-y-4">

                    <x-select id="updateApp_software_id" label="Software" name="software_id" required>
                        <option value="">Select Software</option>
                        @foreach ($softwareLists as $software)
                            <option value="{{ $software->id }}">
                                {{ $software->name }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input id="updateApp_product_key" label="Product Key" name="product_key" />

                    <x-input id="updateApp_remarks" label="Remarks" name="remarks" />

                    <x-input id="updateApp_date_installed" label="Installation Date" type="date"
                        name="date_installed" required />

                    <x-input id="updateApp_date_expired" label="Expiration Date" type="date"
                        name="date_expired" />

                </div>

                <div class="mt-6 flex items-center justify-between">

                    <x-button type="button" size="md" bg="bg-[var(--danger-color)]"
                        onclick="Delete_App_Modal($('#updateApp_id').val())">
                        Delete
                    </x-button>

                    <div class="flex gap-3">

                        <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                            border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                            onclick="toggleModal('appEdit_modal')">
                            Cancel
                        </x-button>

                        <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                            Save Changes
                        </x-button>

                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- Delete App Modal -->
    <div id="appDelete_modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Delete Application
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to delete this application?
                </p>

                <p class="mt-3 text-sm text-red-600">
                    This action cannot be undone. Once deleted, the application record
                    will be permanently removed.
                </p>
            </div>

            <div class="mt-6 flex justify-end gap-3">

                <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                    border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                    onclick="toggleModal('appDelete_modal')">
                    Cancel
                </x-button>

                <form id="appDelete_form" method="POST">
                    @csrf
                    @method('DELETE')

                    <x-button type="submit" size="md" bg="bg-[var(--danger-color)]">
                        Delete
                    </x-button>
                </form>

            </div>

        </div>
    </div>

    <script>
        let originalValues = {};

        $(document).ready(function() {
            $('#unitForm fieldset').prop('disabled', true);
            $('#unitForm')
                .find('input, select, textarea')
                .each(function() {
                    if ($(this).is(':checkbox') || $(this).is(':radio')) {
                        originalValues[this.name] = $(this).prop('checked');
                    } else {
                        originalValues[this.name] = $(this).val();
                    }
                });

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitButtons = form.querySelectorAll(
                        'button[type="submit"], input[type="submit"]'
                    );

                    submitButtons.forEach(button => {
                        button.disabled = true;
                        button.textContent = 'Submitting...';
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                    });
                });
            });

            toggleDisposedFields();
            $('[name="status"]').on('change', toggleDisposedFields);
        });

        function toggleModal(modalId) {
            $('#' + modalId).toggleClass('hidden');
        }

        function toggleEdit() {
            $('#editButton, #saveButton, #deleteButton, #cancelButton').each(function() {
                this.hidden = !this.hidden;
            });

            $('#card_formSave').toggleClass('hidden');
            $('#inventoryFieldset').prop('disabled', !$('#inventoryFieldset').prop('disabled'));
            toggleDisposedFields();
        }

        function Edit_User_Modal(user) {
            console.log(user);
            $('#userEdit_form').attr('action', '{{ route('accountability.update', ':id') }}'.replace(':id', user.id));
            $('#userEdit_modal').toggleClass('hidden');

            $('#update_id').val(user.id);
            $('#update_name').val(user.name);
            $('#update_department').val(user.department);
            $('#update_location').val(user.location);
            $('#update_history').val(user.history);
            $('#update_date_received').val(user.date_received);
            $('#update_date_returned').val(user.date_returned);
        }

        function Delete_User_Modal(id) {
            let action = "{{ route('accountability.destroy', ':id') }}".replace(':id', id);
            $('#userDelete_form').attr('action', action);
            $('#userDelete_modal').toggleClass('hidden');
        }

        function Edit_App_Modal(app) {
            $('#appEdit_form').attr('action', '{{ route('inventory_software.update', ':id') }}'.replace(':id', app.id));
            $('#appEdit_modal').toggleClass('hidden');

            $('#updateApp_id').val(app.id);
            $('#updateApp_software_id').val(app.software_id);
            $('#updateApp_product_key').val(app.product_key);
            $('#updateApp_remarks').val(app.remarks);
            $('#updateApp_date_installed').val(app.date_installed);
            $('#updateApp_date_expired').val(app.date_expired);
        }

        function Delete_App_Modal(id) {
            let action = "{{ route('inventory_software.destroy', ':id') }}".replace(':id', id);
            $('#appDelete_form').attr('action', action);
            $('#appDelete_modal').toggleClass('hidden');
        }

        function toggleDisposedFields() {
            const status = $('[name="status"]').val();

            if (status === 'DISPOSED') {
                $('#disposedFields').show();
            } else {
                $('#disposedFields').hide();
            }
        }
    </script>
</x-layout>
