<x-layout>

    <main class="max-w-7xl mx-auto py-2">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[var(--text-color)]">
                Accountability Dashboard
            </h1>
            <p class="mt-2 text-[var(--text-color)]/60">
                Track assigned inventory, accountable personnel, and software installations.
            </p>
        </div>

        {{-- Dashboard Cards --}}
        <div class="grid grid-cols-4 gap-4 mb-5">
            <x-dashboard-card title="Active Items" :value="$activeCount" icon="heroicon-o-check-circle"
                iconColor="text-[#5dc0e9]/20" data-search="ACTIVE" />

            <x-dashboard-card title="Defective Items" :value="$defectiveCount" icon="heroicon-o-exclamation-triangle"
                iconColor="text-[#e7a770]/20" data-search="DEFECTIVE" />

            <x-dashboard-card title="Disposed Items" :value="$disposedCount" icon="heroicon-o-archive-box"
                iconColor="text-[#ead653]/20" data-search="DISPOSED" />

            <x-dashboard-card title="Items with Returned Status" :value="$returnedCount" icon="heroicon-o-receipt-refund"
                iconColor="text-red-500/20" data-status="RETURNED" />
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

                <button type="button" onclick="toggleModal('export-modal')"
                    class="hidden md:inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg border border-[var(--secondary-border-color)] bg-[var(--accent-color)] text-[var(--primary-color)] text-sm transition-all duration-200 hover:opacity-90">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                    <span>Export</span>
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
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Department</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Location</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Item Control No.</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Model Name</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Date Received</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Unit Status</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Acc. Status</th>
                            <th class="px-5 py-3 text-right font-medium text-[var(--text-color)]/70">Options</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody class="divide-y divide-[var(--secondary-border-color)]">
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

                            <tr class="hover:bg-white/5 transition">
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $acc->id }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)] font-medium text-xs">
                                    {{ $acc->name }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $acc->department }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $acc->location }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $acc->inventory->control_no ?? '-' }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $acc->inventory->model_name }}
                                </td>
                                <td class="px-5 py-2 text-[var(--text-color)]/70 text-xs">
                                    {{ $acc->date_received }}
                                </td>

                                <td class="px-5 py-2">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $status }}">
                                        {{ $acc->inventory->status }}
                                    </span>
                                </td>

                                <td class="px-5 py-2">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $accstatusbadge }}">
                                        {{ $accstatus }}
                                    </span>
                                </td>

                                <td class="px-5 py-2">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('units.edit', $acc->inventory->id) }}"
                                            class="inline-flex items-center justify-center p-2 rounded-lg hover:bg-white/5 transition">
                                            <x-heroicon-o-pencil-square class="w-5 h-5 text-blue-400" />
                                        </a>
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
                {{ $accountability->appends(['search' => $search])->links() }}
            </div>
        </div>
    </main>

    {{-- Export Accountability Modal --}}
    <div id="export-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

        <div
            class="w-full max-w-lg rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] shadow-2xl">

            <!-- Header -->
            <div class="border-b border-[var(--secondary-border-color)] px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-green-500/10 text-green-400">
                        <x-heroicon-o-arrow-down-tray class="h-6 w-6" />
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-[var(--text-color)]">
                            Export Accountability
                        </h2>
                        <p class="text-sm text-[var(--text-color)]/60">
                            Select the parameters for the export.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <form id="exportForm" method="GET" action="{{ route('accountability.export') }}" target="downloadFrame">

                <div class="px-6 py-5">
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <x-input label="Date From" name="date_from" type="date" class="w-full" required />
                        </div>

                        <div>
                            <x-input label="Date To" name="date_to" type="date" class="w-full" required />
                        </div>

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
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 border-t border-[var(--secondary-border-color)] px-6 py-4">

                    <button type="button" onclick="toggleModal('export-modal')"
                        class="rounded-lg border border-[var(--secondary-border-color)] bg-transparent px-4 py-2 text-sm font-medium text-[var(--text-color)] transition hover:bg-white/5">
                        Cancel
                    </button>

                    <button type="submit"
                        class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700">
                        Export
                    </button>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('[data-search], [data-status]');
            const form = document.getElementById('searchForm');

            cards.forEach(card => {
                card.addEventListener('click', function() {
                    document.getElementById('searchInput').value =
                        card.dataset.search || '';

                    document.getElementById('statusInput').value =
                        card.dataset.status || '';

                    form.submit();
                });
            });
        });
    </script>
</x-layout>
