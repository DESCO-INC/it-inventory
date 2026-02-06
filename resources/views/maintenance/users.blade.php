<x-layout>
    <!-- Card with Top Right Buttons -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4">
            <h2 class="text-lg font-medium text-gray-800">Manage User</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <button onclick="openAddUserModal()"
                    class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">
                    Add New User
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-5 overflow-x-auto">

            <!-- Search -->
            <form method="GET" class="mb-4 flex items-center gap-2">
                <input type="hidden" name="form_type" value="search">

                <input name="search" id="search" type="text"
                    class="border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700 focus:ring-2 focus:ring-green-500 focus:border-green-500 min-w-[150px]"
                    placeholder="Search By ID" value="{{ request('search') }}" />

                <button class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600" type="submit">
                    Search
                </button>
            </form>

            <x-table.main>
                <thead class="bg-green-600 text-white">
                    <x-table.th class="w-[4%]">ID</x-table.th>
                    <x-table.th class="w-[24%]">Name</x-table.th>
                    <x-table.th class="w-[24%]">Email</x-table.th>
                    <x-table.th class="w-[24%]">Credentials</x-table.th>
                    <x-table.th class="w-[24%]">Action</x-table.th>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <x-table.td>{{ $user->id }}</x-table.td>
                            <x-table.td>{{ $user->name }}</x-table.td>
                            <x-table.td>{{ $user->email }}</x-table.td>
                            <x-table.td>{{ $user->credential }}</x-table.td>
                            <x-table.td class="text-center flex justify-center gap-1">
                                <button onclick="openEditUserModal({{ $user }})"
                                    class="bg-blue-500 text-white text-xs px-2 py-1 rounded hover:bg-blue-600">
                                    Edit
                                </button>
                                <button onclick="openDeleteUserModal({{ $user->id }})"
                                    class="bg-red-500 text-white text-xs px-2 py-1 rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-table.td colspan="5" class="text-center text-gray-500">
                                No records found
                            </x-table.td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table.main>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>

    {{-- Add / Edit User Modal --}}
    <div id="user-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 id="user-modal-title" class="text-xl font-semibold text-gray-800 mb-2">Add User</h2>
            <p class="text-sm text-gray-600 mb-4">Fill in the user details below.</p>

            <form id="user-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="user-form-method" value="POST">

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="user-name"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="user-email"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Credential</label>
                        <select name="credential" id="user-credential"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">-- Select Credential --</option>
                            <option value="ADMIN">ADMIN</option>
                            <option value="USER">USER</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="user-password"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="user-password-confirm"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                        onclick="closeUserModal()">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete User Modal --}}
    <div id="delete-user-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Delete</h2>
            <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete this user?</p>

            <form id="delete-user-form" method="POST" class="mt-6 flex justify-end space-x-3">
                @csrf
                @method('DELETE')
                <button type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                    onclick="closeDeleteUserModal()">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Delete</button>
            </form>
        </div>
    </div>

    {{-- JS --}}
    <script>
        // Pass route placeholders from Blade
        window.routes = {
            usersStore: "{{ route('users.store') }}",
            usersUpdate: "{{ route('users.update', ':id') }}",
            usersDelete: "{{ route('users.destroy', ':id') }}"
        };

        const userModal = document.getElementById('user-modal');
        const deleteModal = document.getElementById('delete-user-modal');
        const userForm = document.getElementById('user-form');
        const deleteForm = document.getElementById('delete-user-form');
        const modalTitle = document.getElementById('user-modal-title');
        const formMethod = document.getElementById('user-form-method');

        function openAddUserModal() {
            modalTitle.textContent = 'Add User';

            userForm.action = window.routes.usersStore;
            formMethod.value = 'POST';
            userForm.reset();

            // Make password fields required for Add
            document.getElementById('user-password').required = true;
            document.getElementById('user-password-confirm').required = true;

            userModal.classList.remove('hidden');
        }
        
        function openEditUserModal(user) {
            modalTitle.textContent = 'Edit User';

            // Use named route with placeholder
            userForm.action = window.routes.usersUpdate.replace(':id', user.id);
            formMethod.value = 'PUT';

            document.getElementById('user-name').value = user.name;
            document.getElementById('user-email').value = user.email;
            document.getElementById('user-credential').value = user.credential ?? '';

            // Clear password fields for edit
            document.getElementById('user-password').value = '';
            document.getElementById('user-password-confirm').value = '';

            // Make password optional for Edit
            document.getElementById('user-password').required = false;
            document.getElementById('user-password-confirm').required = false;

            userModal.classList.remove('hidden');
        }
        
        function closeUserModal() {
            userModal.classList.add('hidden');
        }
        
        function openDeleteUserModal(userId) {
            // Use named route with placeholder
            deleteForm.action = window.routes.usersDelete.replace(':id', userId);
            deleteModal.classList.remove('hidden');
        }
        
        function closeDeleteUserModal() {
            deleteModal.classList.add('hidden');
        }
    </script>

</x-layout>
