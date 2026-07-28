<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-color)]">Manage User</h1>
            <p class="text-sm text-[var(--text-muted-color)]">
                View, assign, and update user accountability records.
            </p>
        </div>

        <div class="flex gap-2">
            <x-button size="md" onclick="toggleModal('user-modal')">
                Add New User
            </x-button>
        </div>
    </div>

    {{-- CARD --}}
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
                                    <x-button size="sm" onclick="openEditUserModal({{ $user }})">
                                        Edit
                                    </x-button>
                                    <x-button size="sm" bg="bg-[var(--danger-color)]"
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

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>

    {{-- Add User Modal --}}
    <div id="user-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">

            <form id="user-form" action="{{ route('user.store') }}" method="POST">
                @csrf

                <div>
                    <h2 id="user-modal-title" class="text-lg font-semibold text-gray-800">
                        Add User
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Fill in the user details below.
                    </p>
                </div>

                <div class="mt-6 space-y-4">
                    <x-input name="name" label="Name" required />
                    <x-input name="email" label="Email" type="email" required />
                    <x-select label="Credential" name="credential">
                        <option value="">Select Credential</option>
                        <option value="ADMIN" @selected(old('credential') == 'ADMIN')>ADMIN</option>
                        <option value="USER" @selected(old('credential') == 'USER')>USER</option>
                    </x-select>
                    <x-input name="password" label="Password" type="password" required />
                    <x-input name="password_confirmation" label="Confirm Password" type="password" required />
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                        border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                        onclick="toggleModal('user-modal')">
                        Cancel
                    </x-button>
                    <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                        Save User
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit User Modal --}}
    <div id="editUser-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <form id="editUser-form" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Edit User
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Update the user details below.
                    </p>
                </div>

                <div class="mt-6 space-y-4">
                    <x-input id="editName" name="name" label="Name" required />

                    <x-input id="editEmail" name="email" label="Email" type="email" required />

                    <x-select id="editCredential" label="Credential" name="credential">
                        <option value="">Select Credential</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="USER">USER</option>
                    </x-select>

                    <x-input id="editPassword" name="password" label="Password" type="password" />

                    <x-input id="editPasswordConfirm" name="password_confirmation" label="Confirm Password"
                        type="password" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                        border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                        onclick="toggleModal('editUser-modal')">
                        Cancel
                    </x-button>

                    <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                        Save Changes
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete User Modal --}}
    <div id="deleteUser-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Delete User
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to delete this user?
                </p>
                <p class="mt-3 text-sm text-red-600">
                    This action cannot be undone. Once deleted, the user account will be
                    permanently removed.
                </p>
            </div>
            <form id="deleteUser-form" method="POST" class="mt-6 flex justify-end gap-3">
                @csrf
                @method('DELETE')
                <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                    border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                    onclick="toggleModal('deleteUser-modal')">
                    Cancel
                </x-button>
                <x-button type="submit" size="md" bg="bg-[var(--danger-color)]">
                    Delete
                </x-button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            $('#' + modalId).toggleClass('hidden');
        }

        function openEditUserModal(user) {
            $('#editUser-form').attr('action', '{{ route('user.update', ':id') }}'.replace(':id', user.id));

            $('#editName').val(user.name);
            $('#editEmail').val(user.email);
            $('#editCredential').val(user.credential ?? '');
            $('#editUser-modal').toggleClass('hidden');
        }


        function openDeleteUserModal(id) {
            let action = "{{ route('user.destroy', ':id') }}".replace(':id', id);
            $('#deleteUser-form').attr('action', action);
            $('#deleteUser-modal').toggleClass('hidden');
        }
    </script>

</x-layout>
