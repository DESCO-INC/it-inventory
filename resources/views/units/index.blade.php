<x-layout>
    <!-- Dashboard Cards -->
    <div class="grid grid-cols-4 grid-rows-2 gap-2 mb-3">

        <!-- TOTAL ITEMS -->
        <x-card
            class="col-span-2 row-span-2 relative overflow-hidden bg-[#a4f5a6] hover:shadow-md transition-all duration-200 cursor-pointer"
            data-search="">
            <div class="absolute right-0 top-0 translate-x-5 -translate-y-5 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-rectangle-stack class="w-72 h-72 text-[#00c950]" />
            </div>
            <div class="relative flex flex-col h-full justify-center">
                <p class="text-xl font-semibold text-gray-600 uppercase tracking-wide">Total Inventory Items</p>
                <p class="mt-1 text-6xl font-extrabold text-gray-900">{{ $stats['TOTAL'] }}</p>
            </div>
        </x-card>

        <!-- Active Items -->
        <x-card class="relative overflow-hidden bg-[#a6d8f5] hover:shadow-md transition-all duration-200 cursor-pointer"
            data-search="ACTIVE">
            <div class="absolute right-0 top-0 translate-x-1 translate-y-6 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-check-badge class="w-20 h-20 text-[#00a3d9]" />
            </div>
            <div class="relative flex flex-col h-full justify-center">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Active Items</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['ACTIVE'] }}</p>
            </div>
        </x-card>

        <!-- Unassigned Items (Clickable) -->
        <x-card class="relative overflow-hidden bg-[#f5cda6] hover:shadow-md transition-all duration-200 cursor-pointer"
            data-search="UNASSIGNED">
            <div class="absolute right-0 top-0 translate-x-1 translate-y-6 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-user-group class="w-20 h-20 text-[#d9823b]" />
            </div>
            <div class="relative flex flex-col h-full justify-center">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Unassigned Items</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['UNASSIGNED'] }}</p>
            </div>
        </x-card>

        <!-- DEFECTIVE Items -->
        <x-card class="relative overflow-hidden bg-[#f5f5a6] hover:shadow-md transition-all duration-200 cursor-pointer"
            data-search="DEFECTIVE">
            <div class="absolute right-0 top-0 translate-x-1 translate-y-6 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-x-circle class="w-20 h-20 text-[#e0b800]" />
            </div>
            <div class="relative flex flex-col h-full justify-center">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Defective Items</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['DEFECTIVE'] }}</p>
            </div>
        </x-card>

        <!-- Disposed Items -->
        <x-card class="relative overflow-hidden bg-[#f5a6a6] hover:shadow-md transition-all duration-200 cursor-pointer"
            data-search="DISPOSED">
            <div class="absolute right-0 top-0 translate-x-1 translate-y-6 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-trash class="w-20 h-20 text-[#d93030]" />
            </div>
            <div class="relative flex flex-col h-full justify-center">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Disposed Items</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['DISPOSED'] }}</p>
            </div>
        </x-card>
    </div>

    <x-card class="mb-2">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-medium text-gray-800">Item Inventory</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <a href="{{ route('units.create') }}"
                    class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">
                    Add New Inventory Item
                </a>
            </div>
        </div>
    </x-card>

    <x-card class="mb-2">
        <div class="overflow-x-auto">
            <form method="GET" class="mb-4 flex items-center gap-2">
                <x-basic.input type="text" name="search" value="{{ $search }}" placeholder="Search" />
                <x-basic.button variant="success">Search</x-basic.button>
            </form>

            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-green-500 text-white">
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
                                    'ACTIVE' => 'active',
                                    'DEFECTIVE' => 'defective',
                                    'DISPOSED' => 'disposed',
                                    default => 'info',
                                };

                                $acc_status = match ($unit->accountability_status) {
                                    'ASSIGNED' => 'success',
                                    'UNASSIGNED' => 'unassigned',
                                    default => 'info',
                                };
                            @endphp
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->id }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->control_no }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->model_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->serial }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <x-badge variant="{{ $acc_status }}">
                                        {{ $unit->accountability_status }}
                                    </x-badge>
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $unit->accountability_count }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <x-badge variant="{{ $unit_status }}">
                                        {{ $unit->status }}
                                    </x-badge>
                                </td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-button size="xs" variant="info" href="{{ route('units.edit', $unit->id) }}">
                                        Manage
                                    </x-button>
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
    </x-card>

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
