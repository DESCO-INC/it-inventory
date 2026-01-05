<x-layout>
    <h1 class="text-xl font-semibold text-white mb-5">Welcome, {{ Auth::user()->name }}</h1>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-4 grid-rows-2 gap-2 mb-3">

        <!-- TOTAL ITEMS -->
        <div class="col-span-2 row-span-2 relative overflow-hidden bg-[#a4f5a6] rounded-xl shadow-sm border border-[#a4f5a6] p-10 hover:shadow-md transition-all duration-200 cursor-pointer"
            data-search="">
            <div class="absolute right-0 top-0 translate-x-5 -translate-y-5 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-rectangle-stack class="w-72 h-72 text-[#00c950]" />
            </div>
            <div class="relative flex flex-col h-full justify-center">
                <p class="text-xl font-semibold text-gray-600 uppercase tracking-wide">Total Inventory Items</p>
                <p class="mt-1 text-6xl font-extrabold text-gray-900">{{ $stats['TOTAL'] }}</p>
            </div>
        </div>

        <!-- Active Items -->
        <div class="relative bg-[#a6d8f5] rounded-xl shadow-sm border border-[#a6d8f5] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden cursor-pointer"
            data-search="ACTIVE">
            <div class="absolute right-0 top-0 translate-x-3 -translate-y-3 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-check-badge class="w-20 h-20 text-[#00a3d9]" />
            </div>
            <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Active Items</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['ACTIVE'] }}</p>
        </div>

        <!-- Unassigned Items (Clickable) -->
        <div class="relative bg-[#f5cda6] rounded-xl shadow-sm border border-[#f5cda6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden cursor-pointer"
            data-search="UNASSIGNED">

            <!-- Background Icon -->
            <div class="absolute right-0 top-0 translate-x-3 -translate-y-3 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-user-group class="w-20 h-20 text-[#d9823b]" />
            </div>

            <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Unassigned Items</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['UNASSIGNED'] }}</p>
        </div>

        <!-- Inactive Items -->
        <div class="relative bg-[#f5f5a6] rounded-xl shadow-sm border border-[#f5f5a6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden cursor-pointer"
            data-search="DEFECTIVE">
            <div class="absolute right-0 top-0 translate-x-3 -translate-y-3 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-x-circle class="w-20 h-20 text-[#e0b800]" />
            </div>
            <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Defective Items</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['DEFECTIVE'] }}</p>
        </div>

        <!-- Disposed Items -->
        <div class="relative bg-[#f5a6a6] rounded-xl shadow-sm border border-[#f5a6a6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden cursor-pointer"
            data-search="DISPOSED">
            <div class="absolute right-0 top-0 translate-x-3 -translate-y-3 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-trash class="w-20 h-20 text-[#d93030]" />
            </div>
            <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Disposed Items</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['DISPOSED'] }}</p>
        </div>
    </div>

    <!-- Card with Top Right Buttons -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4">
            <h2 class="text-lg font-medium text-gray-800">Item Inventory</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <a href="{{ route('units.create') }}"
                    class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">
                    Add New Inventory Item
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-5 overflow-x-auto">
            <!-- Search -->
            <form method="GET" class="mb-4 flex items-center gap-2">
                <x-basic.input type="text" name="search" value="{{ $search }}" placeholder="Search" />
                <x-basic.button variant="success">Search</x-basic.button>
            </form>

            <x-table.main class="">
                <thead class="bg-green-600 text-white">
                    <x-table.th>ID</x-table.th>
                    <x-table.th>Control Number</x-table.th>
                    <x-table.th>Unit</x-table.th>
                    <x-table.th>Model</x-table.th>
                    <x-table.th>Serial</x-table.th>
                    <x-table.th>Purchase Date</x-table.th>
                    <x-table.th>Depreciation Date</x-table.th>
                    <x-table.th>Assigned Status</x-table.th>
                    <x-table.th>Assigned Count</x-table.th>
                    <x-table.th>Status</x-table.th>
                    <x-table.th>Action</x-table.th>
                </thead>
                <tbody>
                    @forelse ($units as $unit)
                        <tr>
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
                            <x-table.td>{{ $unit->id }}</x-table.td>
                            <x-table.td>{{ $unit->control_no }}</x-table.td>
                            <x-table.td>{{ $unit->unit_category->name ?? '-' }}</x-table.td>
                            <x-table.td>{{ $unit->model_name }}</x-table.td>
                            <x-table.td>{{ $unit->serial }}</x-table.td>
                            <x-table.td>{{ $unit->purchase_date }}</x-table.td>
                            <x-table.td>{{ $unit->depreciation_date }}</x-table.td>
                            <x-table.td class="text-center">
                                <x-basic.badge variant="{{ $acc_status }}">
                                    {{ $unit->accountability_status }}
                                </x-basic.badge>
                            </x-table.td>
                            <x-table.td class="text-center">{{ $unit->accountability_count }}</x-table.td>
                            <x-table.td class="text-center">
                                <x-basic.badge variant="{{ $unit_status }}">
                                    {{ $unit->status }}
                                </x-basic.badge>
                            </x-table.td>
                            <x-table.td class="text-center">
                                <a href="{{ route('units.edit', $unit->id) }}"
                                    class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600 inline-block">
                                    Manage
                                </a>
                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-table.td colspan="11" class="text-center text-gray-500">
                                No records found
                            </x-table.td>
                        </tr>
                    @endforelse
                </tbody>

            </x-table.main>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $units->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>

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
