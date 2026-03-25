<x-layout>
    <!-- Card with Top Right Buttons -->
    <x-card class="mb-2">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-medium text-gray-800">Manage User</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <button onclick="toggleModal('user-modal')"
                    class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">
                    Add New User
                </button>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="overflow-x-auto">
            <form method="GET" class="mb-4 flex items-center gap-2 w-[300px]">
                <x-input name="search" size="sm" value="{{ $search }}" placeholder="Search" />
                <x-button size="sm" variant="success">Search</x-button>
            </form>

            <div class="overflow-x-auto border border-gray-200 rounded">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                        <thead class="bg-green-500 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-medium">Name</th>
                                <th class="px-4 py-3 text-left text-sm font-medium">Email</th>
                                <th class="px-4 py-3 text-left text-sm font-medium">Credentials</th>
                                <th class="px-4 py-3 text-center text-sm font-medium w-15">Options</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-4 py-3 text-xs text-gray-800">{{ $user->id }}</td>
                                    <td class="px-4 py-3 text-xs text-gray-800">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-xs text-gray-800">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-xs text-gray-800">{{ $user->credential }}</td>
                                    <td class="px-4 py-2 text-center flex justify-center gap-1">
                                        <x-button size="xs" variant="info"
                                            onclick="openEditUserModal({{ $user }})">
                                            Edit
                                        </x-button>
                                        <x-button size="xs" variant="error"
                                            onclick="openDeleteUserModal({{ $user->id }})">
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
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->appends(['search' => $search])->links() }}
            </div>
        </div>
    </x-card>

    {{-- Add User Modal --}}
    <div id="user-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 id="user-modal-title" class="text-xl font-semibold text-gray-800 mb-2">Add User</h2>
            <p class="text-sm text-gray-600 mb-4">Fill in the user details below.</p>

            <form id="user-form" action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <x-input name="name" label="Name" required />
                    </div>
                    <div>
                        <x-input name="email" label="Email" type="email" required />
                    </div>
                    <div>
                        <x-select label="Credential" name="credential" :options="['' => 'Select Credential', 'ADMIN' => 'ADMIN', 'USER' => 'USER']" width="full" />
                    </div>

                    <div>
                        <x-input name="password" label="Password" type="password" required />
                    </div>
                    <div>
                        <x-input name="password_confirmation" label="Confirm Password" type="password" required />
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-button size="sm" variant="gray" onclick="toggleModal('user-modal')">Cancel</x-button>
                    <x-button type="submit">Save</x-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit User Modal --}}
    <div id="editUser-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Edit User</h2>
            <p class="text-sm text-gray-600 mb-4">Fill in the user details below.</p>

            <form id="editUser-form" method="POST" class="mt-4">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <div>
                        <x-input id="editName" name="name" label="Name" required />
                    </div>
                    <div>
                        <x-input id="editEmail" name="email" label="Email" type="email" required />
                    </div>
                    <div>
                        <x-select id="editCredential" label="Credential" name="credential" :options="['' => 'Select Credential', 'ADMIN' => 'ADMIN', 'USER' => 'USER']"
                            width="full" />
                    </div>

                    <div>
                        <x-input id="editPassword" name="password" label="Password" type="password" />
                    </div>
                    <div>
                        <x-input id="editPasswordConfirm" name="password_confirmation" label="Confirm Password"
                            type="password" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-button size="sm" variant="gray" onclick="toggleModal('editUser-modal')">Cancel</x-button>
                    <x-button type="submit">Save</x-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete User Modal --}}
    <div id="deleteUser-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Delete</h2>
            <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete this user?</p>

            <form id="deleteUser-form" method="POST" class="mt-6 flex justify-end space-x-3">
                @csrf
                @method('DELETE')
                <button type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                    onclick="toggleModal('deleteUser-modal')">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Delete</button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            $('#' + modalId).toggleClass('hidden');
        }

        function openEditUserModal(user) {
            $('#editUser-form').attr('action', '{{ route('users.update', ':id') }}'.replace(':id', user.id));

            $('#editName').val(user.name);
            $('#editEmail').val(user.email);
            $('#editCredential').val(user.credential ?? '');
            $('#editUser-modal').toggleClass('hidden');
        }


        function openDeleteUserModal(id) {
            let action = "{{ route('users.destroy', ':id') }}".replace(':id', id);
            $('#deleteUser-form').attr('action', action);
            $('#deleteUser-modal').toggleClass('hidden');
        }
    </script>

</x-layout>
