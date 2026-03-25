<x-layout>
    <!-- Card with Top Right Buttons -->
    <x-card class="mb-2">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-medium text-gray-800">Accountability List</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <x-button size="sm" variant="info" onclick="toggleModal('export-modal')">Export</x-button>
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
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Department</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Location</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Item Control No.</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Model Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Date Received</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                            <th class="px-4 py-3 text-center text-sm font-medium w-15">Options</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($accountability as $acc)
                            @php
                                $status = match ($acc->inventory->status) {
                                    'ACTIVE' => 'active',
                                    'DEFECTIVE' => 'defective',
                                    'DISPOSED' => 'disposed',
                                    default => 'info',
                                };
                            @endphp
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->id }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->department }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->location }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->inventory->control_no ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->inventory->model_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->date_received }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <x-badge variant="{{ $status }}">
                                        {{ $acc->inventory->status }}
                                    </x-badge>
                                </td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-button size="xs" variant="info"
                                        href="{{ route('units.edit', $acc->inventory->id) }}">
                                        Manage
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
                {{ $accountability->appends(['search' => $search])->links() }}
            </div>
        </div>
    </x-card>

    {{-- Export User Modal --}}
    <div id="export-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 id="user-modal-title" class="text-xl font-semibold text-gray-800 mb-2">Export Accountability</h2>
            <p class="text-sm text-gray-600 mb-4">Please select paramaters below.</p>

            <form id="exportForm" method="GET" action="{{ route('accountability.export') }}" target="downloadFrame">
                <div class="space-y-3 grid grid-cols-2 gap-4">
                    <div class="mb-1">
                        <x-input label="Date From" name="date_from" type="date" class="w-full" required />
                    </div>

                    <div class="mb-1">
                        <x-input label="Date To" name="date_to" type="date" class="w-full" required />
                    </div>

                    <div class="col-span-2 mb-1">
                        <x-select label="Department" name="department" :options="['' => 'All'] + collect($departments)->mapWithKeys(fn($i) => [$i => $i])->toArray()" width="full" />
                    </div>

                    <div class="col-span-2 mb-1">
                        <x-select label="Location" name="location" :options="['' => 'All'] + collect($locations)->mapWithKeys(fn($i) => [$i => $i])->toArray()" width="full" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                        onclick="toggleModal('export-modal')">Cancel</button>

                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        Export
                    </button>
                </div>
            </form>
        </div>
    </div>
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
