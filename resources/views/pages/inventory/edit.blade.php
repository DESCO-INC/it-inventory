<x-layout>

    <main class="max-w-7xl mx-auto py-2">

        <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('units.index')], ['label' => 'Manage']]" />

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[var(--text-color)]">
                Manage Inventory
            </h1>
            <p class="mt-2 text-[var(--text-color)]/60">
                Manage inventory items, update records, and track their current status.
            </p>
        </div>


        <div class="grid grid-cols-2 grid-rows-[1fr_1fr] gap-2">
            <div
                class="row-span-2 relative overflow-hidden rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)]/40 p-5">

                <form action="{{ route('units.update', $unit) }}" method="POST" id="unitForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-6 flex items-center justify-between">
                        <h1 class="text-lg font-bold text-[var(--text-color)]">
                            Inventory Information
                        </h1>

                        <div class="flex items-center gap-1.5">

                            <button type="button" id="editButton" onclick="enableEdit()"
                                class="inline-flex items-center rounded-md border border-[var(--secondary-border-color)]
               bg-[var(--accent-color)]/90 px-2.5 py-1 text-xs font-medium
               text-[var(--primary-color)] transition-all duration-200
               hover:bg-[var(--accent-color)]">
                                Update
                            </button>

                            <button type="submit" id="saveButton"
                                class="hidden items-center rounded-md border border-emerald-500/20
               bg-emerald-500/10 px-2.5 py-1 text-xs font-medium
               text-emerald-400 transition-all duration-200
               hover:bg-emerald-500/20">
                                Save
                            </button>

                            <button type="button" id="deleteButton" onclick="toggleModal('deleteInventory_modal')"
                                class="hidden items-center rounded-md border border-rose-500/20
               bg-rose-500/10 px-2.5 py-1 text-xs font-medium
               text-rose-400 transition-all duration-200
               hover:bg-rose-500/20">
                                Delete
                            </button>

                            <button type="button" id="cancelButton" onclick="cancelEdit()"
                                class="hidden items-center rounded-md border border-slate-500/20
               bg-slate-500/10 px-2.5 py-1 text-xs font-medium
               text-slate-300 transition-all duration-200
               hover:bg-slate-500/20">
                                Cancel
                            </button>

                        </div>
                    </div>

                    <fieldset id="inventoryFieldset" class="grid grid-cols-2 gap-4" disabled>

                        <x-input label="Model Name" name="model_name" value="{{ $unit['model_name'] }}" readonly />
                        <x-input label="Category" name="cat_id" value="{{ $unit->unit_category->name ?? '' }}"
                            readonly />
                        <x-input label="Control Number" name="control_no" value="{{ $unit['control_no'] }}" readonly />
                        <x-input label="Serial" name="serial" value="{{ $unit['serial'] }}" />
                        <x-input label="Purchase Reference" value="{!! html_entity_decode($unit['purchase_no']) !!}" name="purchase_no" />
                        <x-input label="Purchase Date" name="purchase_date" value="{{ $unit['purchase_date'] }}"
                            type="date" />
                        <x-input label="Manufacturing Date" name="manufacturing_date"
                            value="{{ $unit['manufacturing_date'] }}" type="date" />
                        <x-input label="Depreciation Date" name="depreciation_date"
                            value="{{ $unit['depreciation_date'] }}" type="date" />

                        <x-select label="Status" name="status" required>
                            <option value="ACTIVE" @selected(old('status', $unit->status) == 'ACTIVE')>
                                ACTIVE
                            </option>
                            <option value="DEFECTIVE" @selected(old('status', $unit->status) == 'DEFECTIVE')>
                                DEFECTIVE
                            </option>
                            <option value="DISPOSED" @selected(old('status', $unit->status) == 'DISPOSED')>
                                DISPOSED
                            </option>
                        </x-select>

                        <x-input label="Remarks" name="remarks" />

                        <div id="disposedFields" class="contents">
                            <x-input label="Unit Weight" name="unit_weight"
                                value="{{ old('unit_weight', $unit->unit_weight) }}" />

                            <x-input label="Disposed Location" name="disposed_location"
                                value="{{ old('disposed_location', $unit->disposed_location) }}" />
                        </div>

                    </fieldset>

                </form>
            </div>

            <div
                class="relative h-[300px] flex flex-col overflow-hidden rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)]/40 p-5">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-lg font-bold text-[var(--text-color)]">
                        Assigned Accountability
                    </h1>

                    <div class="flex items-center gap-1.5">
                        @if ($unit['status'] === 'ACTIVE')
                            <button type="button" onclick="toggleModal('addUser_modal')"
                                class="inline-flex items-center rounded-md border border-[var(--secondary-border-color)] bg-[var(--accent-color)]/90 px-2.5 py-1 text-xs font-medium text-[var(--primary-color)] transition-all duration-200 hover:bg-[var(--accent-color)]">
                                Assign User
                            </button>
                        @endif

                        <a href="{{ route('accountability.print', ['inventory_id' => $unit->id]) }}" target="_blank"
                            class="inline-flex items-center rounded-md border border-[var(--secondary-border-color)] bg-[var(--accent-color)]/90 px-2.5 py-1 text-xs font-medium text-[var(--primary-color)] transition-all duration-200 hover:bg-[var(--accent-color)]">
                            Print Accountability
                        </a>
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

            <div
                class="relative h-[300px] flex flex-col overflow-hidden rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)]/40 p-5">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-lg font-bold text-[var(--text-color)]">
                        Installed Applications
                    </h1>

                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="toggleModal('addApp_modal')"
                            class="inline-flex items-center rounded-md border border-[var(--secondary-border-color)] bg-[var(--accent-color)]/90 px-2.5 py-1 text-xs font-medium text-[var(--primary-color)] transition-all duration-200 hover:bg-[var(--accent-color)]">
                            Add Application
                        </button>
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
                                        <button type="button" onclick="Edit_App_Modal({{ $soft }})"
                                            class="inline-flex items-center rounded-md border border-[var(--secondary-border-color)] bg-[var(--accent-color)]/90 px-2.5 py-1 text-xs font-medium text-[var(--primary-color)] transition-all duration-200 hover:bg-[var(--accent-color)]">
                                            Manage
                                        </button>
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


        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.showToast(
                        'warning',
                        @json($errors->first())
                    );
                });
            </script>
        @endif

        <!-- Delete Inventory Modal -->
        <div id="deleteInventory_modal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div
                class="w-full max-w-md rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">

                <!-- Header -->
                <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-rose-500/10 text-rose-400">
                            <x-heroicon-o-exclamation-triangle class="h-6 w-6" />
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-[var(--text-color)]">
                                Delete Inventory
                            </h2>
                            <p class="text-sm text-[var(--text-color)]/60">
                                This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="px-6 py-5">
                    <p class="leading-relaxed text-rose-400">
                        Please note that both the assigned accountability and installed software records will also be
                        deleted. Proceed with caution.
                    </p>
                </div>

                <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                    <button type="button" onclick="toggleModal('deleteInventory_modal')"
                        class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                        Cancel
                    </button>

                    <form method="POST" action="{{ route('units.destroy', $unit->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
                            Delete Inventory
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <!-- Add User Modal -->
        <div id="addUser_modal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

            <div
                class="w-full max-w-md rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">
                <form action="{{ route('accountability.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="inventory_id" value="{{ $unit->id }}">

                    <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-[var(--accent-color)]/10 text-[var(--accent-color)]">
                                <x-heroicon-o-user-plus class="h-6 w-6" />
                            </div>

                            <div>
                                <h2 class="text-lg font-semibold text-[var(--text-color)]">
                                    Assign Accountability
                                </h2>
                                <p class="text-sm text-[var(--text-color)]/60">
                                    Fill in the details below to assign a new user.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="space-y-4 px-6 py-5">
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

                    <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">
                        <button type="button" onclick="toggleModal('addUser_modal')"
                            class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                            Cancel
                        </button>

                        <button type="submit"
                            class="rounded-lg bg-[var(--accent-color)] px-4 py-2 text-sm font-medium text-[var(--primary-color)] transition hover:opacity-90">
                            Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div id="userEdit_modal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

            <div
                class="w-full max-w-md rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">

                <form id="userEdit_form" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="update_id" name="id">
                    <input type="hidden" name="inventory_id" value="{{ $unit->id }}">

                    <!-- Header -->
                    <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-[var(--accent-color)]/10 text-[var(--accent-color)]">
                                <x-heroicon-o-pencil-square class="h-6 w-6" />
                            </div>

                            <div>
                                <h2 class="text-lg font-semibold text-[var(--text-color)]">
                                    Update Accountability
                                </h2>
                                <p class="text-sm text-[var(--text-color)]/60">
                                    Modify the assigned user's information.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="space-y-4 px-6 py-5">
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
                        <x-input id="update_date_returned" label="Date Returned" type="date"
                            name="date_returned" />
                    </div>

                    <div
                        class="flex items-center justify-between border-t border-[var(--secondary-border-color)] px-6 py-4">
                        <button type="button" onclick="Delete_User_Modal($('#update_id').val())"
                            class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
                            Delete
                        </button>

                        <div class="flex gap-3">
                            <button type="button" onclick="toggleModal('userEdit_modal')"
                                class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                                Cancel
                            </button>
                            <button type="submit"
                                class="rounded-lg bg-[var(--accent-color)] px-4 py-2 text-sm font-medium text-[var(--primary-color)] transition hover:opacity-90">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete User Modal -->
        <div id="userDelete_modal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div
                class="w-full max-w-md rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">
                <!-- Header -->
                <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-rose-500/10 text-rose-400">
                            <x-heroicon-o-exclamation-triangle class="h-6 w-6" />
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-[var(--text-color)]">
                                Delete Accountability
                            </h2>
                            <p class="text-sm text-[var(--text-color)]/60">
                                This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Body -->
                <div class="px-6 py-5">
                    <p class="leading-relaxed text-rose-400">
                        Are you sure you want to permanently remove this accountability
                        record? Once deleted, it cannot be recovered.
                    </p>
                </div>
                <!-- Footer -->
                <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                    <button type="button" onclick="toggleModal('userDelete_modal')"
                        class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                        Cancel
                    </button>

                    <form id="userDelete_form" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
                            Delete User
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <!-- Add App Modal -->
        <div id="addApp_modal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div
                class="w-full max-w-md rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">
                <form action="{{ route('inventory_software.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="inventory_id" value="{{ $unit->id }}">
                    <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-[var(--accent-color)]/10 text-[var(--accent-color)]">
                                <x-heroicon-o-squares-plus class="h-6 w-6" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-[var(--text-color)]">Add Application</h2>
                                <p class="text-sm text-[var(--text-color)]/60">Assign software to this inventory item.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 px-6 py-5">
                        <x-select label="Software" name="software_id" required>
                            <option value="">Select Software</option>
                            @foreach ($softwareLists as $software)
                                <option value="{{ $software->id }}">{{ $software->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input label="Product Key" name="product_key" />
                        <x-input label="Remarks" name="remarks" />
                        <x-input label="Installation Date" type="date" name="date_installed" required />
                        <x-input label="Expiration Date" type="date" name="date_expired" />
                    </div>
                    <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">
                        <button type="button" onclick="toggleModal('addApp_modal')"
                            class="rounded-lg border border-[var(--secondary-border-color)] px-4 py-2 text-sm text-[var(--text-color)] hover:bg-white/5">Cancel</button>
                        <button type="submit"
                            class="rounded-lg bg-[var(--accent-color)] px-4 py-2 text-sm font-medium text-[var(--primary-color)]">Save
                            Application</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit App Modal -->
        <div id="appEdit_modal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div
                class="w-full max-w-md rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">
                <form id="appEdit_form" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" id="updateApp_id" name="id">
                    <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-[var(--accent-color)]/10 text-[var(--accent-color)]">
                                <x-heroicon-o-pencil-square class="h-6 w-6" /></div>
                            <div>
                                <h2 class="text-lg font-semibold text-[var(--text-color)]">Update Application</h2>
                                <p class="text-sm text-[var(--text-color)]/60">Modify application details.</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 px-6 py-5">
                        <x-select id="updateApp_software_id" label="Software" name="software_id" required>
                            <option value="">Select Software</option>
                            @foreach ($softwareLists as $software)
                                <option value="{{ $software->id }}">{{ $software->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input id="updateApp_product_key" label="Product Key" name="product_key" />
                        <x-input id="updateApp_remarks" label="Remarks" name="remarks" />
                        <x-input id="updateApp_date_installed" label="Installation Date" type="date"
                            name="date_installed" required />
                        <x-input id="updateApp_date_expired" label="Expiration Date" type="date"
                            name="date_expired" />
                    </div>
                    <div
                        class="flex items-center justify-between border-t border-[var(--secondary-border-color)] px-6 py-4">
                        <button type="button" onclick="Delete_App_Modal($('#updateApp_id').val())"
                            class="rounded-lg bg-rose-600 px-4 py-2 text-sm text-white hover:bg-rose-700">Delete</button>
                        <div class="flex gap-3">
                            <button type="button" onclick="toggleModal('appEdit_modal')"
                                class="rounded-lg border border-[var(--secondary-border-color)] px-4 py-2 text-sm text-[var(--text-color)] hover:bg-white/5">Cancel</button>
                            <button type="submit"
                                class="rounded-lg bg-[var(--accent-color)] px-4 py-2 text-sm font-medium text-[var(--primary-color)]">Save
                                Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete App Modal -->
        <div id="appDelete_modal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div
                class="w-full max-w-md rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">
                <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-rose-500/10 text-rose-400">
                            <x-heroicon-o-exclamation-triangle class="h-6 w-6" /></div>
                        <div>
                            <h2 class="text-lg font-semibold text-[var(--text-color)]">Delete Application</h2>
                            <p class="text-sm text-[var(--text-color)]/60">This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="leading-relaxed text-rose-400">Are you sure you want to permanently remove this
                        application record?</p>
                </div>
                <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">
                    <button type="button" onclick="toggleModal('appDelete_modal')"
                        class="rounded-lg border border-[var(--secondary-border-color)] px-4 py-2 text-sm text-[var(--text-color)] hover:bg-white/5">Cancel</button>
                    <form id="appDelete_form" method="POST">@csrf @method('DELETE')
                        <button type="submit"
                            class="rounded-lg bg-rose-600 px-4 py-2 text-sm text-white hover:bg-rose-700">Delete
                            Application</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

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

        function enableEdit() {
            $('#inventoryFieldset').prop('disabled', false);

            $('#editButton').hide();
            $('#saveButton').css('display', 'inline-flex');
            $('#deleteButton').css('display', 'inline-flex');
            $('#cancelButton').css('display', 'inline-flex');
        }

        function cancelEdit() {
            $('#unitForm')
                .find('input, select, textarea')
                .each(function() {
                    if (!(this.name in originalValues)) return;

                    if ($(this).is(':checkbox') || $(this).is(':radio')) {
                        $(this).prop('checked', originalValues[this.name]);
                    } else {
                        $(this).val(originalValues[this.name]);
                    }
                });

            toggleDisposedFields();
            $('#inventoryFieldset').prop('disabled', true);
            $('#editButton').css('display', 'inline-flex');
            $('#saveButton').hide();
            $('#deleteButton').hide();
            $('#cancelButton').hide();
        }

        function Edit_User_Modal(user) {
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
