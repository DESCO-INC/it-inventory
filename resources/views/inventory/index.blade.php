<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-color)]">Inventory Dashboard</h1>
            <p class="text-sm  text-[var(--text-muted-color)]">Monitor your inventory status and stock movement.</p>
        </div>
    </div>

    {{-- Dashboard Cards --}}
    <div class="grid grid-cols-4 grid-rows-2 gap-4 mb-5">

        {{-- Total Items --}}
        <div class="relative overflow-hidden col-span-2 row-span-2 rounded-xl bg-[var(--accent-color)]/70 text-[var(--primary-color)] p-6 transition hover:border-[var(--accent-color)]/40 hover:shadow-lg cursor-pointer"
            data-search="">

            <x-heroicon-o-rectangle-stack class="absolute -right-8 -bottom-8 w-48 h-48" />

            <div class="relative z-10 flex flex-col h-full">
                <span class="text-2xl font-semibold">
                    Total Inventory Items
                </span>

                <div class="flex-1 flex items-center">
                    <h2 class="text-6xl font-bold">
                        {{ $stats['TOTAL'] }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Active Items --}}
        <div class="relative overflow-hidden rounded-xl bg-[var(--success-color)]/70 text-[var(--primary-color)] p-3 transition hover:border-[var(--accent-color)]/40 hover:shadow-lg cursor-pointer"
            data-search="ACTIVE">

            <x-heroicon-o-check-circle class="absolute -right-4 -bottom-4 w-24 h-24 text-[var(--primary-color)]" />

            <div class="relative z-10 flex flex-col h-full">
                <span class="text-sm font-medium">
                    Active Items
                </span>

                <div class="flex-1 flex items-center">
                    <h2 class="text-3xl font-bold leading-none">
                        {{ $stats['ACTIVE'] }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Unassigned Items --}}
        <div class="relative overflow-hidden rounded-xl bg-[var(--warning-color)]/70 text-[var(--primary-color)] p-3 transition hover:border-[var(--accent-color)]/40 hover:shadow-lg cursor-pointer"
            data-search="UNASSIGNED">

            <x-heroicon-o-users class="absolute -right-4 -bottom-4 w-24 h-24" />

            <div class="relative z-10 flex flex-col h-full">
                <span class="text-sm font-medium">
                    Unassigned Items
                </span>

                <div class="flex-1 flex items-center">
                    <h2 class="text-3xl font-bold leading-none">
                        {{ $stats['UNASSIGNED'] }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Defective Items --}}
        <div class="relative overflow-hidden rounded-xl bg-[var(--danger-color)]/70 text-[var(--primary-color)] p-3 transition hover:border-[var(--accent-color)]/40 hover:shadow-lg cursor-pointer"
            data-search="DEFECTIVE">

            <x-heroicon-o-x-circle class="absolute -right-4 -bottom-4 w-24 h-24" />

            <div class="relative z-10 flex flex-col h-full">
                <span class="text-sm font-medium">
                    Defective Items
                </span>

                <div class="flex-1 flex items-center">
                    <h2 class="text-3xl font-bold leading-none">
                        {{ $stats['DEFECTIVE'] }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Disposed Items --}}
        <div class="relative overflow-hidden rounded-xl bg-[var(--info-color)]/70 text-[var(--primary-color)] p-3 transition hover:border-[var(--accent-color)]/40 hover:shadow-lg cursor-pointer"
            data-search="DISPOSED">

            <x-heroicon-o-archive-box class="absolute -right-4 -bottom-4 w-24 h-24" />

            <div class="relative z-10 flex flex-col h-full">
                <span class="text-sm font-medium">
                    Disposed Items
                </span>

                <div class="flex-1 flex items-center">
                    <h2 class="text-3xl font-bold leading-none">
                        {{ $stats['DISPOSED'] }}
                    </h2>
                </div>
            </div>
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

                <div class="mb-4 flex items-center gap-2">
                    <x-link size="sm" href="{{ route('inventory.create') }}">
                        <x-heroicon-o-plus class="w-4 h-4" /> Add Inventory Item
                    </x-link>
                </div>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-[var(--table-header-bg)] text-[var(--table-header-text)]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Control Number</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Model</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Serial</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Assigned Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">User Count</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                            <th class="px-4 py-3 text-center text-sm font-medium w-15">Options</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($units as $unit)
                            @php
                                $unit_status = match ($unit->status) {
                                    'ACTIVE' => 'bg-[var(--success-color)]/70 text-[var(--text-color)]',
                                    'DEFECTIVE' => 'bg-[var(--warning-color)]/70 text-[var(--text-color)]',
                                    'DISPOSED' => 'bg-[var(--danger-color)]/70 text-[var(--text-color)]',
                                    default => 'bg-[var(--text-muted-color)]/70 text-[var(--text-color)]',
                                };

                                $acc_status = match ($unit->accountability_status) {
                                    'ASSIGNED' => 'bg-[var(--success-color)]/70 text-[var(--text-color)]',
                                    'UNASSIGNED' => 'bg-[var(--warning-color)]/70 text-[var(--text-color)]',
                                    default => 'bg-[var(--text-muted-color)]/70 text-[var(--text-color)]',
                                };
                            @endphp

                            <tr class="hover:bg-[var(--table-row-hover)]">
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->id }}</td>

                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->control_no }}</td>

                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->model_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->serial }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $acc_status }}">
                                        {{ $unit->accountability_status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->accountability_count }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $unit_status }}">
                                        {{ $unit->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-link size="sm" href="{{ route('inventory.edit', $unit->id) }}">
                                        Manage
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
                {{ $units->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>

    <form id="searchForm" method="GET" action="{{ route('inventory.index') }}">
        <input type="hidden" name="search" id="searchInput" value="" />
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('[data-search]');
            const form = document.getElementById('searchForm');
            const input = document.getElementById('searchInput');

            cards.forEach(card => {
                card.addEventListener('click', function() {
                    const searchValue = card.getAttribute('data-search');
                    input.value = searchValue; // set the search value
                    form.submit(); // submit the form
                });
            });
        });
    </script>

</x-layout>
