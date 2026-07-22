<x-layout>

    <main class="max-w-7xl mx-auto py-2">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[var(--text-color)]">
                Software Maintenance
            </h1>
            <p class="mt-2 text-[var(--text-color)]/60">
                Manage software records, license information, versions, and installation details.
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

                <button type="button" onclick="toggleModal('add-modal')"
                    class="hidden md:inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg border border-[var(--secondary-border-color)] bg-[var(--accent-color)] text-[var(--primary-color)] text-sm transition-all duration-200 hover:opacity-90">
                    <x-heroicon-o-plus class="w-4 h-4" />
                    <span>Add Software</span>
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
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Supplier</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Category</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Date Added</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Added By</th>
                            <th class="px-5 py-3 text-right font-medium text-[var(--text-color)]/70">Options</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody class="divide-y divide-[var(--secondary-border-color)]">
                        @forelse($softwares as $software)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $software->id }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)] font-medium text-xs">
                                    {{ $software->name }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $software->supplier }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $software->category }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $software->created_at }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $software->created_by }}
                                </td>

                                <td class="px-5 py-2">
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="openEditUserModal({{ $software }})"
                                            class="inline-flex items-center justify-center p-2 rounded-lg hover:bg-white/5 transition">
                                            <x-heroicon-o-pencil-square class="w-5 h-5 text-blue-400" />
                                        </button>

                                        <button type="button" onclick="openDeleteUserModal({{ $software->id }})"
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
                {{ $softwares->appends(['search' => $search])->links() }}
            </div>
        </div>
    </main>

    {{-- Add Software Modal --}}
    <div id="add-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

        <div
            class="w-full max-w-lg rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">

            <!-- Header -->
            <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-blue-500/10 text-blue-400">
                        <x-heroicon-o-plus-circle class="h-6 w-6" />
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-[var(--text-color)]">
                            Add Software
                        </h2>
                        <p class="text-sm text-[var(--text-color)]/60">
                            Fill in the software details below.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <form id="add-form" method="POST" action="{{ route('software.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="px-6 py-5 space-y-4">

                    <x-input label="Name" name="name" placeholder="Ex: SolidWorks" required />

                    <x-input label="Supplier" name="supplier" placeholder="Ex: Desco" required />

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

                <!-- Footer -->
                <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                    <button type="button" onclick="toggleModal('add-modal')"
                        class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                        Cancel
                    </button>

                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                        Add Software
                    </button>

                </div>

            </form>

        </div>
    </div>

    {{-- Edit Software Modal --}}
    <div id="edit-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

        <div
            class="w-full max-w-lg rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">

            <!-- Header -->
            <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-amber-500/10 text-amber-400">
                        <x-heroicon-o-pencil-square class="h-6 w-6" />
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-[var(--text-color)]">
                            Edit Software
                        </h2>
                        <p class="text-sm text-[var(--text-color)]/60">
                            Update the software details below.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 space-y-4">
                    <x-input id="edit-name" label="Name" name="name" placeholder="Ex: SolidWorks" required />
                    <x-input id="edit-supplier" label="Supplier" name="supplier" placeholder="Ex: Desco" required />

                    <x-select id="edit-category" label="Plan Category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="SUBSCRIPTION">
                            SUBSCRIPTION
                        </option>
                        <option value="PERPETUAL">
                            PERPETUAL
                        </option>
                    </x-select>

                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                    <button type="button" onclick="toggleModal('edit-modal')"
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

    {{-- Delete Software Modal --}}
    <div id="delete-modal"
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
                            Delete Software
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
                    Are you sure you want to permanently delete
                    <span id="delete-software-name" class="font-semibold"></span>?
                </p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                <button type="button" onclick="toggleModal('delete-modal')"
                    class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                    Cancel
                </button>

                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
                        Delete Software
                    </button>

                </form>

            </div>

        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            $('#' + modalId).toggleClass('hidden');
        }

        function openEditUserModal(software) {
            $('#edit-form').attr('action', '{{ route('software.update', ':id') }}'.replace(':id', software.id));

            $('#edit-name').val(software.name);
            $('#edit-supplier').val(software.supplier);
            $('#edit-category').val(software.category);
            $('#edit-modal').toggleClass('hidden');
        }


        function openDeleteUserModal(id) {
            let action = "{{ route('software.destroy', ':id') }}".replace(':id', id);
            $('#delete-form').attr('action', action);
            $('#delete-modal').toggleClass('hidden');
        }
    </script>

</x-layout>
