<x-layout>
    <x-card class="mb-2">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-medium text-gray-800">Manage Software</h2>

            <div class="flex gap-2 mt-4 sm:mt-0">
                {{-- <x-button size="sm" href="{{ route('manlist.create') }}"> --}}
                <x-button size="sm" onclick="toggleModal('add-modal')">
                    Add Software
                </x-button>

                <x-button size="sm" id="btn_back" href="{{ route('units.index') }}" variant="gray">
                    Back
                </x-button>
            </div>
        </div>
    </x-card>

    <x-card class="mb-2">
        <div class="overflow-x-auto">
            <form method="GET" class="mb-4 flex items-center gap-2">
                <input name="search" id="search" type="text"
                    class="border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700 focus:ring-2 focus:ring-green-500 focus:border-green-500 min-w-[150px]"
                    placeholder="Search Here" value="{{ request('search') }}" />

                <button class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600" type="submit">
                    Search
                </button>
            </form>
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-green-500 text-white">
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
                                    <x-button size="xs" variant="info" class="btn-edit"
                                        data-id="{{ $software->id }}" data-name="{{ $software->name }}"
                                        data-supplier="{{ $software->supplier }}"
                                        data-category="{{ $software->category }}">
                                        Edit
                                    </x-button>
                                    <x-button size="xs" variant="error" class="btn-delete"
                                        data-id="{{ $software->id }}" data-name="{{ $software->name }}">
                                        Delete
                                    </x-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-2 text-center text-gray-500">No records found.</td>
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
    </x-card>

    <!-- Add Modal -->
    <div id="add-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
            <h2 class="text-xl font-semibold text-gray-800">Add Software</h2>
            <p class="mt-2 text-sm text-gray-600">Please fill out the form</p>

            {{-- action="{{ route('manlist.import') }}" --}}
            <form id="add-form" method="POST" action="{{ route('software.store') }}" enctype="multipart/form-data"
                class="mt-4">
                @csrf

                <x-input label="Name" name="name" placeholder="Ex: Solidworks" class="w-full mb-2" required />
                <x-input label="Supplier" name="supplier" placeholder="Ex: Desco" class="w-full mb-2" required />
                <x-select label="Plan Category" name="category" :options="['' => 'Select Category', 'SUBSCRIPTION' => 'SUBSCRIPTION', 'PERPETUAL' => 'PERPETUAL']" width="full mb-2" required />

                <div class="mt-6 flex justify-end space-x-3">
                    <!-- Cancel -->
                    <x-button size="md" variant="gray" onclick="toggleModal('add-modal')">
                        Cancel
                    </x-button>

                    <!-- Add Button -->
                    <x-button size="md" type="submit">
                        Submit
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Edit Software</h2>

            <form id="edit-form" method="POST" class="mt-4">
                @csrf
                @method('PUT')

                <x-input label="Name" id="edit-name" name="name" placeholder="Ex: Solidworks" class="w-full mb-2"
                    required />
                <x-input label="Supplier" id="edit-supplier" name="supplier" placeholder="Ex: Desco" class="w-full mb-2"
                    required />
                <x-select label="Plan Category" id="edit-category" name="category" :options="['' => 'Select Category', 'SUBSCRIPTION' => 'SUBSCRIPTION', 'PERPETUAL' => 'PERPETUAL']"
                    width="full mb-2" required />

                <div class="mt-6 flex justify-end space-x-3">
                    <x-button size="md" variant="gray" onclick="toggleModal('edit-modal')">
                        Cancel
                    </x-button>

                    <x-button size="md" type="submit">
                        Update
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Delete Software</h2>
            <p class="mt-2 text-sm text-gray-600">
                Are you sure you want to delete <span id="delete-software-name" class="font-semibold"></span>?
            </p>

            <form id="delete-form" method="POST" class="mt-4">
                @csrf
                @method('DELETE')

                <div class="mt-6 flex justify-end space-x-3">
                    <x-button size="md" variant="gray" onclick="toggleModal('delete-modal')">
                        Cancel
                    </x-button>

                    <x-button size="md" type="submit" variant="error">
                        Delete
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#add-form').on('submit', function() {
                const $submit = $(this).find('button[type="submit"]');
                $submit.prop('disabled', true).text('Submitting...');
            });
        });
    </script>
    
    <script>
        function toggleModal(modalId) {
            $('#' + modalId).toggleClass('hidden');
        }

        // OPEN EDIT MODAL
        $(document).on('click', '.btn-edit', function() {
            const editRouteTemplate = "{{ route('software.update', ['software' => ':id']) }}";
            let id = $(this).data('id');
            let name = $(this).data('name');
            let supplier = $(this).data('supplier');
            let category = $(this).data('category');

            // Fill form fields
            $('#edit-name').val(name);
            $('#edit-supplier').val(supplier);
            $('#edit-category').val(category);

            const editRoute = editRouteTemplate.replace(':id', id);
            $('#edit-form').attr('action', editRoute);
            toggleModal('edit-modal');
        });

        // OPEN DELETE MODAL
        $(document).on('click', '.btn-delete', function() {
            const destroyRouteTemplate = "{{ route('software.destroy', ['software' => ':id']) }}";
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#delete-software-name').text(name);

            // set form action dynamically
            const destroyRoute = destroyRouteTemplate.replace(':id', id);
            $('#delete-form').attr('action', destroyRoute);

            // open modal
            toggleModal('delete-modal');
        });

        function clearFormInput() {
            // Clear Add Form
            $('#add-form').find('input[type="text"], input[type="email"], input[type="password"]').val('');
            $('#add-form').find('select').prop('selectedIndex', 0);
            $('#add-form').find('input[name="_modal"]').val('add');

            // Clear Edit Form
            $('#edit-form').find('input[type="text"], input[type="email"], input[type="password"]').val('');
            $('#edit-form').find('select').prop('selectedIndex', 0);
            $('#edit-form').find('input[name="_modal"]').val('edit');
            $('#edit-form').find('input[name="_id"]').val('');
        }
    </script>

</x-layout>
