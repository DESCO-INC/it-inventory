<x-layout>

    <main class="max-w-7xl mx-auto py-2">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[var(--text-color)]">
                Inventory Dashboard
            </h1>
            <p class="mt-2 text-[var(--text-color)]/60">
                Monitor your inventory status and stock movement.
            </p>
        </div>

        {{-- Dashboard Cards --}}
        <div class="grid grid-cols-1 grid-cols-4 grid-rows-2 gap-4 mb-5">

            {{-- Total Items --}}
            <div class="relative overflow-hidden col-span-2 row-span-2
           rounded-xl border border-[var(--secondary-border-color)]
           bg-[var(--secondary-color)]/40
           p-6 transition
           hover:border-[var(--accent-color)]/40
           hover:shadow-lg cursor-pointer"
                data-search="">

                {{-- Background Icon --}}
                <x-heroicon-o-rectangle-stack class="absolute -right-8 -bottom-8 w-48 h-48 text-[#00c950]/20" />

                <div class="relative z-10 flex flex-col h-full">

                    <span class="text-sm text-[var(--text-color)]/60">
                        Total Inventory Items
                    </span>

                    {{-- Center Content --}}
                    <div class="flex-1 flex items-center">
                        <h2 class="text-6xl font-bold text-[var(--text-color)]">
                            {{ $stats['TOTAL'] }}
                        </h2>
                    </div>

                </div>

            </div>

            <x-dashboard-card title="Active Items" :value="$stats['ACTIVE']" icon="heroicon-o-check-circle"
                iconColor="text-[#5dc0e9]/20" data-search="ACTIVE" />

            <x-dashboard-card title="Unassigned Items" :value="$stats['UNASSIGNED']" icon="heroicon-o-users"
                iconColor="text-[#e7a770]/20" data-search="UNASSIGNED" />

            <x-dashboard-card title="Defective Items" :value="$stats['DEFECTIVE']" icon="heroicon-o-x-circle"
                iconColor="text-[#ead653]/20" data-search="DEFECTIVE" />

            <x-dashboard-card title="Disposed Items" :value="$stats['DISPOSED']" icon="heroicon-o-archive-box"
                iconColor="text-red-500/20" data-search="DISPOSED" />
        </div>

        <div
            class="relative overflow-hidden rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)]/40 p-3">

            {{-- Toolbar --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 py-1 mb-4">

                {{-- SEARCH --}}
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

                <a href="{{ route('units.create') }}"
                    class="hidden md:inline-flex items-center justify-center px-3 py-2 rounded-lg
                   border border-[var(--secondary-border-color)]
                   bg-[var(--accent-color)] text-[var(--primary-color)] text-sm">
                    <x-heroicon-o-plus class="w-4 h-4" />
                    <span>Add Inventory Item</span>
                </a>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto rounded-lg border border-[var(--secondary-border-color)]">
                <table class="min-w-full text-sm">
                    {{-- Header --}}
                    <thead class="bg-white/5 border-b border-[var(--secondary-border-color)]">
                        <tr class="text-left">
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">ID</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Control Number</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Model</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Serial</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Assigned Status</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">User Count</th>
                            <th class="px-5 py-3 font-medium text-[var(--text-color)]/70">Status</th>
                            <th class="px-5 py-3 text-right font-medium text-[var(--text-color)]/70">Options</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody class="divide-y divide-[var(--secondary-border-color)]">
                        @forelse($units as $unit)
                            @php
                                $unit_status = match ($unit->status) {
                                    'ACTIVE' => 'bg-green-500/15 text-green-400',
                                    'DEFECTIVE' => 'bg-yellow-500/15 text-yellow-400',
                                    'DISPOSED' => 'bg-red-500/15 text-red-400',
                                    default => 'bg-gray-500/15 text-gray-400',
                                };

                                $acc_status = match ($unit->accountability_status) {
                                    'ASSIGNED' => 'bg-green-500/15 text-green-400',
                                    'UNASSIGNED' => 'bg-yellow-500/15 text-yellow-400',
                                    default => 'bg-gray-500/15 text-gray-400',
                                };
                            @endphp

                            <tr class="hover:bg-white/5 transition">
                                <td class="px-5 py-2 text-[var(--text-color)]/70">
                                    {{ $unit->id }}
                                </td>

                                <td class="px-5 py-2 text-[var(--text-color)] font-medium">
                                    {{ $unit->control_no }}
                                </td>

                                <td class="px-5 py-2 text-[var(--text-color)]/70">
                                    {{ $unit->model_name }}
                                </td>

                                <td class="px-5 py-2 text-[var(--text-color)]/70">
                                    {{ $unit->serial }}
                                </td>

                                <td class="px-5 py-2">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $acc_status }}">
                                        {{ $unit->accountability_status }}
                                    </span>
                                </td>

                                <td class="px-5 py-2 text-[var(--text-color)]/70">
                                    {{ $unit->accountability_count }}
                                </td>

                                <td class="px-5 py-2">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $unit_status }}">
                                        {{ $unit->status }}
                                    </span>
                                </td>

                                <td class="px-5 py-2">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('units.edit', $unit->id) }}"
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
                {{ $units->appends(['search' => $search])->links() }}
            </div>
        </div>
    </main>

    <form id="searchForm" method="GET" action="{{ route('units.index') }}">
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
