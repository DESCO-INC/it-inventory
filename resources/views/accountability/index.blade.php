<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-color)]">Accountability Dashboard</h1>
            <p class="text-sm  text-[var(--text-muted-color)]">Track assigned inventory, accountable personnel, and
                software installations.</p>
        </div>

        <div class="flex gap-2">
            <x-button size="md" onclick="toggleModal('export-modal')">
                Export
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
                    Accountability List
                </h2>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-[var(--table-header-bg)] text-[var(--table-header-text)]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Department</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Location</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Item Control No.</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Model Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Date Received</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Unit Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Acc. Status</th>
                            <th class="px-4 py-3 text-center text-sm font-medium w-15">Options</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($accountability as $acc)
                            @php
                                $status = match ($acc->inventory->status) {
                                    'ACTIVE' => 'bg-green-500/15 text-green-400',
                                    'DEFECTIVE' => 'bg-yellow-500/15 text-yellow-400',
                                    'DISPOSED' => 'bg-red-500/15 text-red-400',
                                    default => 'bg-gray-500/15 text-gray-400',
                                };
                                $accstatus = $acc->date_returned ? 'RETURNED' : 'ISSUED';

                                $accstatusbadge = match ($accstatus) {
                                    'ISSUED' => 'bg-green-500/15 text-green-400',
                                    'RETURNED' => 'bg-yellow-500/15 text-yellow-400',
                                    default => 'bg-gray-500/15 text-gray-400',
                                };
                            @endphp

                            <tr class="hover:bg-[var(--table-row-hover)]">
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->id }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->department }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->location }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->inventory->control_no ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->inventory->model_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->date_received }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $status }}">
                                        {{ $acc->inventory->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $accstatusbadge }}">
                                        {{ $accstatus }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-link size="sm" href="{{ route('inventory.edit', $acc->inventory->id) }}">
                                        View
                                    </x-link>
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
                {{ $accountability->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>

    {{-- Export Accountability Modal --}}
    <div id="export-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">

            <form id="exportForm" method="GET" action="{{ route('accountability.export') }}" target="downloadFrame">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Export Accountability
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Select the parameters for the export.
                    </p>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">

                    <x-input label="Date From" name="date_from" type="date" required />

                    <x-input label="Date To" name="date_to" type="date" required />

                    <div class="col-span-2">
                        <x-select label="Department" name="department" required>
                            <option value="">Select Department</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept }}" @selected(old('department') == $dept)>
                                    {{ $dept }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="col-span-2">
                        <x-select label="Location" name="location">
                            <option value="">All</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location }}" @selected(old('location') == $location)>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <x-button type="button" size="md" bg="bg-[var(--primary-color)]"
                        border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]"
                        onclick="toggleModal('export-modal')">
                        Cancel
                    </x-button>

                    <x-button type="submit" size="md" bg="bg-[var(--accent-color)]">
                        Export
                    </x-button>

                </div>

            </form>

        </div>
    </div>

    <form id="searchForm" method="GET" action="{{ route('accountability.index') }}">
        <input type="hidden" name="search" id="searchInput">
        <input type="hidden" name="status" id="statusInput">
    </form>

    <iframe name="downloadFrame" style="display:none;"></iframe>

    <script>
        function toggleModal(modalId) {
            $('#' + modalId).toggleClass('hidden');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#exportForm').on('submit', function() {

                let $btn = $(this).find('button[type="submit"]');

                $btn.prop('disabled', true)
                    .text('Exporting...')
                    .addClass('opacity-50 cursor-not-allowed');

                // close modal after 2s
                setTimeout(function() {
                    toggleModal('export-modal');
                }, 2000);

                // refresh after 4s (safer)
                setTimeout(function() {
                    $btn.prop('disabled', false)
                        .text('Export')
                        .removeClass('opacity-50 cursor-not-allowed');
                }, 3000); // give a bit of time for export to start
            });
        });
    </script>

</x-layout>
