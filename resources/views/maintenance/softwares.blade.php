<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-color)]">Manage Software</h1>
            <p class="text-sm text-[var(--text-muted-color)]">
                Add, update, and manage software records, including license information,installation details, and
                expiration dates.
            </p>
        </div>

        <div class="flex gap-2">
            <x-button size="md" onclick="toggleModal('add-modal')">
                Add Software
            </x-button>
        </div>
    </div>

    <div class="mb-2 bg-white rounded-lg shadow-sm overflow-hidden px-6 py-4">
        <div class="overflow-x-auto">
            {{-- SEARCH --}}
            <div class="flex justify-between">
                <form method="GET" class="mb-4 flex items-center gap-2">
                    <input name="search" id="search" type="text"
                        class="border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700"
                        placeholder="Search Here" value="{{ request('search') }}" />

                    <x-button type="submit" size="sm">Search</x-button>
                    @if (request('search'))
                        <x-link size="sm" bg="bg-[var(--primary-color)]" border="border-[var(--text-muted-color)]"
                            text="text-[var(--text-color)]" href="{{ url()->current() }}">
                            Clear
                        </x-link>
                    @endif
                </form>

                <h2 class="text-sm font-semibold text-[var(--text-muted-color)] leading-none">
                    User List
                </h2>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-[var(--table-header-bg)] text-[var(--table-header-text)]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Supplier</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Category</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Date Added</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Added By</th>
                            <th class="px-4 py-3 text-center text-sm font-medium w-15">Options</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($softwares as $software)
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->id }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->supplier }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->category }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->created_at }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->created_by }}</td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-button size="sm" onclick="openEditModal({{ $software }})">
                                        Edit
                                    </x-button>
                                    <x-button size="sm" bg="bg-[var(--danger-color)]"
                                        onclick="openDeleteModal({{ $software->id }})">
                                        Delete
                                    </x-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-2 text-center text-gray-500">No records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $softwares->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="add-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">

            <form id="add-form" method="POST" action="{{ route('software.store') }}" enctype="multipart/form-data">
                @csrf

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Add Software
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Fill in the software details below.
                    </p>
                </div>

                <div class="mt-6 space-y-4">

                    <x-input label="Name" name="name" placeholder="Ex: SolidWorks" required />

                    <x-input label="Supplier" name="supplier" placeholder="Ex: DESCO" required />

                    <x-select label="Plan Category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="SUBSCRIPTION" @selected(old('category') == 'SUBSCRIPTION')>
                            SUBSCRIPTION
                        </option>
                        <option value="PERPETUAL" @selected(old('category') == 'PERPETUAL')>
                            PERPETUAL
                        </option>
                    </x-select>

                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                        border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                        onclick="toggleModal('add-modal')">
                        Cancel
                    </x-button>

                    <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                        Save Software
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Edit Software
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Update the software details below.
                    </p>
                </div>

                <div class="mt-6 space-y-4">

                    <x-input id="edit-name" label="Name" name="name" placeholder="Ex: SolidWorks" required />

                    <x-input id="edit-supplier" label="Supplier" name="supplier" placeholder="Ex: DESCO" required />

                    <x-select id="edit-category" label="Plan Category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="SUBSCRIPTION">SUBSCRIPTION</option>
                        <option value="PERPETUAL">PERPETUAL</option>
                    </x-select>

                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                        border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                        onclick="toggleModal('edit-modal')">
                        Cancel
                    </x-button>

                    <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                        Save Changes
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Delete Software
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to delete
                    <span id="delete-software-name" class="font-semibold text-gray-800"></span>?
                </p>

                <p class="mt-3 text-sm text-red-600">
                    This action cannot be undone. Once deleted, the software record
                    will be permanently removed.
                </p>
            </div>

            <form id="delete-form" method="POST" class="mt-6">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">

                    <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                        border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                        onclick="toggleModal('delete-modal')">
                        Cancel
                    </x-button>

                    <x-button type="submit" size="md" bg="bg-[var(--danger-color)]">
                        Delete
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            $('#' + modalId).toggleClass('hidden');
        }

        function openEditModal(software) {
            $('#edit-form').attr('action', '{{ route('software.update', ':id') }}'.replace(':id', software.id));

            $('#edit-name').val(software.name);
            $('#edit-supplier').val(software.supplier);
            $('#edit-category').val(software.category);
            $('#edit-modal').toggleClass('hidden');
        }

        function openDeleteModal(id) {
            let action = "{{ route('software.destroy', ':id') }}".replace(':id', id);
            $('#delete-form').attr('action', action);
            $('#delete-modal').toggleClass('hidden');
        }
    </script>

</x-layout>
