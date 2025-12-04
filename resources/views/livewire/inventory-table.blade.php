<div>
    <!-- Dashboard Cards -->
    <div class="grid grid-cols-4 grid-rows-2 gap-2 mb-3">

        <!-- TOTAL ITEMS -->
        <div
            class="col-span-2 row-span-2 relative overflow-hidden bg-[#a4f5a6] rounded-xl shadow-sm border border-[#a4f5a6] p-10 hover:shadow-md transition-all duration-200 cursor-pointer"
            wire:click="$set('search', '')">
            <div class="absolute right-0 top-0 translate-x-5 -translate-y-5 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-rectangle-stack class="w-72 h-72 text-[#00c950]" />
            </div>
            <div class="relative flex flex-col h-full justify-center">
                <p class="text-xl font-semibold text-gray-600 uppercase tracking-wide">Total Inventory Items</p>
                <p class="mt-1 text-6xl font-extrabold text-gray-900">{{ $totalItems }}</p>
            </div>
        </div>

        <!-- Active Items -->
        <div
            class="relative bg-[#a6d8f5] rounded-xl shadow-sm border border-[#a6d8f5] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden cursor-pointer"
            wire:click="$set('search', 'ACTIVE')">
            <div class="absolute right-0 top-0 translate-x-2 translate-y-2 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-check-badge class="w-30 h-30 text-[#00a3d9]" />
            </div>
            <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Active Items</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusCounts['active'] }}</p>
        </div>

        <!-- Unassigned Items (Clickable) -->
        <div class="relative bg-[#f5cda6] rounded-xl shadow-sm border border-[#f5cda6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden cursor-pointer"
            wire:click="$set('search', 'UNASSIGNED')">

            <!-- Background Icon -->
            <div class="absolute right-0 top-0 translate-x-2 translate-y-2 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-user-group class="w-30 h-30 text-[#d9823b]" />
            </div>

            <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Unassigned Items</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusCounts['unassigned'] }}</p>
        </div>

        <!-- Inactive Items -->
        <div
            class="relative bg-[#f5f5a6] rounded-xl shadow-sm border border-[#f5f5a6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden cursor-pointer"
            wire:click="$set('search', 'INACTIVE')">
            <div class="absolute right-0 top-0 translate-x-2 translate-y-2 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-x-circle class="w-30 h-30 text-[#e0b800]" />
            </div>
            <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Inactive Items</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusCounts['inactive'] }}</p>
        </div>

        <!-- Disposed Items -->
        <div
            class="relative bg-[#f5a6a6] rounded-xl shadow-sm border border-[#f5a6a6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden cursor-pointer"
            wire:click="$set('search', 'DISPOSED')">
            <div class="absolute right-0 top-0 translate-x-2 translate-y-2 opacity-[0.5] pointer-events-none">
                <x-heroicon-o-trash class="w-30 h-30 text-[#d93030]" />
            </div>
            <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Disposed Items</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusCounts['disposed'] }}</p>
        </div>
    </div>

    <!-- Card with Top Right Buttons -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4">
            <h2 class="text-lg font-medium text-gray-800">Item Inventory</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <a href="{{ route('units.create') }}"
                    class="bg-green-500 text-white text-xs px-3 py-2 rounded hover:bg-green-600">
                    Add Item
                </a>
                <a href="" class="bg-blue-500 text-white text-xs px-3 py-2 rounded hover:bg-blue-600 hidden">
                    Export
                </a>
                <button class="bg-blue-500 text-white text-xs px-3 py-2 rounded hover:bg-blue-600 hidden"
                    id="importButton">
                    Import
                </button>
                <a href="" class="bg-blue-500 text-white text-xs px-3 py-2 rounded hover:bg-blue-600 hidden">
                    Download Template
                </a>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-5 overflow-x-auto">

            <input type="text" wire:model.live="search"
                placeholder="Search by Control No, Model, Serial, or Accountability"
                class="border border-green-500 rounded px-2 py-1 text-sm w-full sm:w-64
               focus:ring focus:ring-blue-300 focus:border-blue-500 mb-5" />

            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium w-10">#</th>
                            <th class="px-4 py-3 text-left text-sm font-medium max-w-[150px]">Control No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium max-w-[120px]">Unit</th>
                            <th class="px-4 py-3 text-left text-sm font-medium max-w-[200px]">Model</th>
                            <th class="px-4 py-3 text-left text-sm font-medium max-w-[150px]">Serial No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium w-36">Purchase Date</th>
                            <th class="px-4 py-3 text-left text-sm font-medium w-36">Depreciation</th>
                            <th class="px-4 py-3 text-left text-sm font-medium w-28">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium w-32">Assigned Acc.</th>
                            <th class="px-4 py-3 text-center text-sm font-medium w-24">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($inventory as $item)
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->id }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800 truncate max-w-[150px]"
                                    title="{{ $item->control_no }}">{{ $item->control_no }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800 truncate max-w-[120px]"
                                    title="{{ $item->unit_category->name }}">{{ $item->unit_category->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800 truncate max-w-[200px]"
                                    title="{{ $item->model_name }}">{{ $item->model_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800 truncate max-w-[150px]"
                                    title="{{ $item->serial }}">{{ $item->serial }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->purchase_date }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->depreciation_date }}</td>

                                <!-- Status Badge -->
                                @php
                                    $statusColors = [
                                        'ACTIVE' => ['text' => '#166534', 'bg' => '#bbf7d0'],
                                        'INACTIVE' => ['text' => '#991b1b', 'bg' => '#fecaca'],
                                        'DISPOSED' => ['text' => '#78350f', 'bg' => '#fef3c7'],
                                    ];
                                    $colors = $statusColors[$item->status] ?? ['text' => '#1f2937', 'bg' => '#e5e7eb'];
                                @endphp
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full"
                                        style="color: {{ $colors['text'] }}; background-color: {{ $colors['bg'] }};">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <!-- Assigned Accountability -->
                                <td class="px-4 py-3 text-xs text-center">
                                    @if ($item->accountability->count() > 0)
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                            {{ $item->accountability->count() }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                            UNASSIGNED
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('units.edit', $item->id) }}"
                                        class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">
                                        Manage
                                    </a>
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
                {{ $inventory->links() }}
            </div>
        </div>
    </div>
</div>
