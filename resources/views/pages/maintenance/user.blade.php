<x-layout>

    <main class="max-w-7xl mx-auto py-2">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[var(--text-color)]">
                User Maintenance
            </h1>
            <p class="mt-2 text-[var(--text-color)]/60">
                Manage user accounts, roles, and access permissions.
            </p>
        </div>

        <div
            class="relative overflow-hidden rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)]/40 p-3">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 py-1 mb-4">

                <form method="GET" class="flex items-center gap-2">
                    <div class="flex w-full md:max-w-md items-center gap-2">
                        <div class="relative w-full">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search procedures..."
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-[var(--secondary-border-color)]
                       bg-[var(--secondary-color)]/40 text-[var(--text-color)]
                       focus:outline-none focus:ring-1 focus:ring-[var(--accent-color)]" />
                            <x-heroicon-o-magnifying-glass
                                class="w-5 h-5 text-[var(--text-color)]/50 absolute left-3 top-2.5" />
                        </div>

                        <button type="submit"
                            class="hidden md:inline-flex items-center justify-center px-3 py-2 rounded-lg
                   border border-[var(--secondary-border-color)]
                   bg-[var(--secondary-color)]/40 text-[var(--text-color)] text-sm
                   hover:bg-white/5 transition">
                            Search
                        </button>

                        @if (request('search'))
                            <a href="{{ url()->current() }}"
                                class="hidden md:inline-flex items-center justify-center px-3 py-2 rounded-lg
                   border border-[var(--secondary-border-color)]
                   bg-[var(--secondary-color)]/40 text-[var(--text-color)] text-sm
                   hover:bg-white/5 transition">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>

                {{-- ACTION --}}

                <button type="button" onclick="toggleModal('user-modal')"
                    class="hidden md:inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg border border-[var(--secondary-border-color)] bg-[var(--accent-color)] text-[var(--primary-color)] text-sm transition-all duration-200 hover:opacity-90">
                    <x-heroicon-o-plus class="w-4 h-4" />
                    <span>Add User</span>
                </button>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto rounded-lg border border-[var(--secondary-border-color)]">
                <table class="min-w-full text-sm">
                    {{-- Header --}}
                    <thead class="bg-white/5 border-b border-[var(--secondary-border-color)]">
                        <tr class="text-left">
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">ID</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Name</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Email</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Credentials</th>
                            <th class="px-5 py-3 text-right font-medium text-[var(--text-color)]/70">Options</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody class="divide-y divide-[var(--secondary-border-color)]">
                        @forelse($users as $user)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $user->id }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)] font-medium text-xs">
                                    {{ $user->name }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $user->email }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $user->credential }}
                                </td>

                                <td class="px-5 py-2">
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="openEditUserModal({{ $user }})"
                                            class="inline-flex items-center justify-center p-2 rounded-lg hover:bg-white/5 transition">
                                            <x-heroicon-o-pencil-square class="w-5 h-5 text-blue-400" />
                                        </button>

                                        <button type="button" onclick="openDeleteUserModal({{ $user->id }})"
                                            class="inline-flex items-center justify-center p-2 rounded-lg hover:bg-white/5 transition">
                                            <x-heroicon-o-trash class="w-5 h-5 text-red-400" />
                                        </button>
                                    </div>
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
                {{ $users->appends(['search' => $search])->links() }}
            </div>
        </div>
    </main>

    {{-- Add User Modal --}}
    <div id="user-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

        <div
            class="w-full max-w-lg rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">

            <!-- Header -->
            <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-blue-500/10 text-blue-400">
                        <x-heroicon-o-user-plus class="h-6 w-6" />
                    </div>

                    <div>
                        <h2 id="user-modal-title" class="text-lg font-semibold text-[var(--text-color)]">
                            Add User
                        </h2>
                        <p class="text-sm text-[var(--text-color)]/60">
                            Fill in the user details below.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <form id="user-form" action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="px-6 py-5 space-y-4">

                    <x-input name="name" label="Name" required />

                    <x-input name="email" label="Email" type="email" required />

                    <x-select label="Credential" name="credential" required>
                        <option value="">Select Credential</option>
                        <option value="ADMIN" @selected(old('credential') == 'ADMIN')>
                            ADMIN
                        </option>
                        <option value="USER" @selected(old('credential') == 'USER')>
                            USER
                        </option>
                    </x-select>

                    <x-input name="password" label="Password" type="password" required />

                    <x-input name="password_confirmation" label="Confirm Password" type="password" required />

                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                    <button type="button" onclick="toggleModal('user-modal')"
                        class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                        Cancel
                    </button>

                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                        Save User
                    </button>

                </div>
            </form>

        </div>
    </div>

    {{-- Edit User Modal --}}
    <div id="editUser-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

        <div class="w-full max-w-lg rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">

            <!-- Header -->
            <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-amber-500/10 text-amber-400">
                        <x-heroicon-o-pencil-square class="h-6 w-6" />
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-[var(--text-color)]">
                            Edit User
                        </h2>
                        <p class="text-sm text-[var(--text-color)]/60">
                            Update the user details below.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <form id="editUser-form" method="POST">
                @csrf
                @method('PUT')

                <div class="px-6 py-5 space-y-4">

                    <x-input id="editName" name="name" label="Name" required />

                    <x-input id="editEmail" name="email" label="Email" type="email" required />

                    <x-select id="editCredential" label="Credential" name="credential" required>
                        <option value="">Select Credential</option>
                        <option value="ADMIN">
                            ADMIN
                        </option>
                        <option value="USER">
                            USER
                        </option>
                    </x-select>

                    <x-input id="editPassword" name="password" label="Password" type="password" />

                    <x-input id="editPasswordConfirm" name="password_confirmation" label="Confirm Password"
                        type="password" />

                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                    <button type="button" onclick="toggleModal('editUser-modal')"
                        class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                        Cancel
                    </button>

                    <button type="submit"
                        class="rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-amber-700">
                        Save Changes
                    </button>

                </div>
            </form>

        </div>
    </div>

    {{-- Delete User Modal --}}
    <div id="deleteUser-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

        <div
            class="w-full max-w-md rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">

            <!-- Header -->
            <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-rose-500/10 text-rose-400">
                        <x-heroicon-o-exclamation-triangle class="h-6 w-6" />
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-[var(--text-color)]">
                            Delete User
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
                    Are you sure you want to permanently delete this user? This action cannot be reversed.
                </p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                <button type="button" onclick="toggleModal('deleteUser-modal')"
                    class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                    Cancel
                </button>

                <form id="deleteUser-form" method="POST">
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
