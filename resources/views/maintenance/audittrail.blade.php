<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-color)]">Audit Trail & Activity Log</h1>
            <p class="text-sm text-[var(--text-muted-color)]">
                Track user activities, data modifications, and system events to maintain accountability and monitor
                changes across the application.
            </p>
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
                    Activity Log
                </h2>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-[var(--table-header-bg)] text-[var(--table-header-text)]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Action</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Model</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">User</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Changes</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($history as $audit)
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $audit->id }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $audit->action }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $audit->model }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $audit->user->name ?? 'System' }}
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $audit->created_at }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    @if (!empty($audit->changes))
                                        <button
                                            class="toggle-row inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-xs">
                                            <span class="label">View Changes</span>
                                            <x-heroicon-s-chevron-right class="icon-right w-4 h-4" />
                                            <x-heroicon-s-chevron-down class="icon-down w-4 h-4 hidden" />
                                        </button>
                                    @else
                                        <span class="text-gray-400">No changes</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- HIDDEN DETAIL ROW -->
                            <tr class="changes-row hidden bg-gray-50">
                                <td colspan="6" class="px-4 py-3 text-xs text-gray-800 bg-[var(--accent-color)]">
                                    @foreach ($audit->changes as $change)
                                        <div class="mb-1 flex gap-2 items-center">
                                            <span class="font-semibold w-40 text-white">{{ $change['label'] }}:</span>
                                            <span class="text-black">{{ $change['old'] }}</span>
                                            <span>→</span>
                                            <span class="text-white">{{ $change['new'] }}</span>
                                        </div>
                                    @endforeach
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
                {{ $history->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.toggle-row', function() {
            let btn = $(this);
            let currentRow = btn.closest('tr');
            let detailRow = currentRow.next('.changes-row');

            // close others
            $('.changes-row').not(detailRow).addClass('hidden');
            $('.toggle-row').not(btn).each(function() {
                $(this).find('.label').text('View Changes');
                $(this).find('.icon-right').removeClass('hidden');
                $(this).find('.icon-down').addClass('hidden');
            });

            // toggle current
            detailRow.toggleClass('hidden');

            let isOpen = !detailRow.hasClass('hidden');

            btn.find('.label').text(isOpen ? 'Hide Changes' : 'View Changes');
            btn.find('.icon-right').toggleClass('hidden', isOpen);
            btn.find('.icon-down').toggleClass('hidden', !isOpen);
        });
    </script>

</x-layout>
